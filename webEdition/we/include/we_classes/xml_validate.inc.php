<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


class XML_Validate extends XML_Parser {
	/**
	 * This array contains all child elements of the "we:document" node.
	 * @var array
	 */
	var $docNode = array("ClassName", "Name", "ID", "Table", "wasUpdate", "InWebEdition", "OwnersReadOnly", "ParentID", "ParentPath",
		"Text", "Filename", "Path", "OldPath", "CreationDate", "ModDate", "IsFolder", "ContentType", "Icon", "EditPageNr", "CopyID",
		"Owners", "CreatorID", "ModifierID", "DefaultInit", "RestrictOwners", "Extension", "IsDynamic", "Published", "Category",
		"IsSearchable", "schedArr", "DocType", "FromOk", "ToOk", "From", "To", "TemplateID", "TemplatePath", "hidePages", "WebUserID");

	/**
	 * This array contains all child elements of the "we:content" node with the parent node "we:document".
	 * @var array
	 */
	var $docChildNode = array("ClassName", "Name", "Type", "BDID", "Dat", "IsBinary", "AutoBR", "LanguageID");

	/**
	 * This array contains all child elements of the "we:template node".
	 * @var array
	 */
	var $tplNode = array("ClassName", "Name", "ID", "Table", "wasUpdate", "InWebEdition", "OwnersReadOnly", "ParentID", "ParentPath",
		"Text", "Filename", "Path", "OldPath", "CreationDate", "ModDate", "IsFolder", "ContentType", "Icon", "EditPageNr", "CopyID",
		"Owners", "CreatorID", "ModifierID", "DefaultInit", "RestrictOwners", "Extension", "IsDynamic", "Published", "Category",
		"IsSearchable", "schedArr");

	/**
	 * This array contains all child elements of the "we:content" node with the parent node "we:template".
	 * @var array
	 */
	var $tplChildNode = array("ClassName", "Name", "Type", "BDID", "Dat", "IsBinary", "AutoBR", "LanguageID");

	/**
	 * This array contains all child elements of the "we:object" node.
	 * @var array
	 */
	var $objNode = array("ClassName", "Name", "ID", "Table", "wasUpdate", "InWebEdition", "OwnersReadOnly", "ParentID", "ParentPath", "Text",
		"Filename", "Path", "OldPath", "CreationDate", "ModDate", "IsFolder", "ContentType", "Icon", "EditPageNr", "CopyID", "Owners",
		"CreatorID", "ModifierID", "DefaultInit", "RestrictOwners", "Extension", "IsDynamic", "Published", "Category", "IsSearchable",
		"schedArr", "DefArray", "AllowedClasses", "Templates", "ExtraTemplates", "Workspaces", "ExtraWorkspaces", "ExtraWorkspacesSelected",
		"RootDirPath", "rootDirID", "TableID", "ObjectID", "Category", "FromOk", "ToOk", "From", "To", "WebUserID");

	/**
	 * This array contains all child elements of the "we:content" node with the parent node "we:object".
	 * @var array
	 */
	var $objChildNode = array("ClassName", "Name", "Type", "Dat", "Len");

	/**
	 * This array contains all child elements of the "we:doctype" node.
	 * @var array
	 */
	var $dtNode = array("ClassName", "Name", "ID", "Table", "wasUpdate", "InWebEdition", "Category", "DocType", "Extension", "ParentID",
		"ParentPath", "TemplateID", "ContentTable", "IsDynamic", "IsSearchable", "Notify", "NotifyTemplateID", "NotifySubject",
		"NotifyOnChange", "SubDir", "Templates");

	/**
	 * This array contains all child elements of the "we:class" node.
	 * @var array
	 */
	var $clsNode = array("ClassName", "Name", "ID", "Table", "wasUpdate", "InWebEdition", "OwnersReadOnly", "ParentID", "ParentPath", "Text",
		"Filename", "Path", "OldPath", "CreationDate", "ModDate", "IsFolder", "ContentType", "Icon", "EditPageNr", "CopyID", "Owners",
		"CreatorID", "ModifierID", "DefaultInit", "RestrictOwners", "Extension", "IsDynamic", "Published", "Category", "IsSearchable",
		"schedArr", "WorkspaceFlag", "RestrictUsers", "UsersReadOnly", "SerializedArray", "Templates", "Workspaces", "Users", "strOrder",
		"Category", "DefaultCategory", "DefaultText", "DefaultValues", "DefaultTitle", "DefaultKeywords", "DefaultDesc");

	/**
	 * This array contains all child elements of the "we:category" node.
	 * @var array
	 */
	var $catNode = array("ID", "Category", "Text", "Path", "ParentID", "IsFolder", "Icon");


	/**
	* @param string $file
	* @desc Parses the given XML file.
	*/
	function XML_Validate($file = "") {
		if (!empty($file)) {
			// Read and try to parse the given file.
			$this->getFile($file);
		}
	}

	/**
	* @throws TRUE if valid, otherwise FALSE.
	* @desc Validates if the xml document matches the webEdition DTD.
	*/
	function validate_we_xml() {
		$valid = true;
		// Node-set with the paths of the child nodes.
		$node_set = $this->evaluate("webEdition/child::*");

		// If the node_set does not contain nodes either the name of the document root does not match
		// or there are no child nodes.
		if (count($node_set)>0) {
			// Run through the child nodes.
			foreach($node_set as $node) {
				// The current node name.
				$n = $this->nodeName($node);

				// Test if the node name complies with the specified node names.
				if ($n!="we:document" && $n!="we:template" && $n!="we:object" && $n!="we:doctype" && $n!="we:class" && $n!="we:category") {
					// The node name is not valid.
					$valid = false;
					break;
				} else {
					// Run through the second level child elements.
					foreach ($this->nodes[$node]["children"] as $k=>$v) {
						// Check whether there is a child element, except of we:content, that itself contains child
						// elements or whether there are content elements in we:doctype or we:category nodes.
						if (($v>1 && $k!="we:content") || (($n=="we:class" || $n=="we:doctype" || $n=="we:category") && $k=="we:content")) {
							// Invalid child elements or content nodes, q.v. above.
							$valid = false;
							break;
						}
						else if ($n=="we:document") {
							if ($k!="we:content") {
								if (!in_array($k, $this->docNode)) {
									// The current element <$k> is not defined in the array docNode.
									$valid = false;
									break;
								}
							} else {
								for ($i=1; $i <= $v; $i++) {
									foreach($this->nodes[$node."/".$k."[".$i."]"]["children"] as $ck=>$cv) {
										if (!in_array($ck, $this->docChildNode)) {
											// The current child element <$ck> is not defined in the array docChildNode.
											$valid = false;
											break;
										}
									}
								}
							}
						}
						else if ($n=="we:template") {
							if ($k!="we:content") {
								if (!in_array($k, $this->tplNode)) {
									// The current element <$k> is not defined in the array tplNode.
									$valid = false;
									break;
								}
							} else {
								for ($i=1; $i <= $v; $i++) {
									foreach($this->nodes[$node."/".$k."[".$i."]"]["children"] as $ck=>$cv) {
										if (!in_array($ck, $this->tplChildNode)) {
											// The current child element <$ck> is not defined in the array tplChildNode.
											$valid = false;
											break;
										}
									}
								}
							}
						}
						else if ($n=="we:object") {
							if ($k!="we:content") {
								if (!in_array($k, $this->objNode)) {
									// The current element <$k> is not defined in the array objNode.
									$valid = false;
									break;
								}
							} else {
								for ($i=1; $i <= $v; $i++) {
									foreach($this->nodes[$node."/".$k."[".$i."]"]["children"] as $ck=>$cv) {
										if (!in_array($ck, $this->objChildNode)) {
											// The current child element <$ck> is not defined in the array objChildNode.
											$valid = false;
											break;
										}
									}
								}
							}
						}
						else if ($n=="we:doctype") {
							if (!in_array($k, $this->dtNode)) {
								// The current element <$k> is not defined in the array dtNode.
								$valid = false;
								break;
							}
						}
						else if ($n=="we:class") {
							if (!in_array($k, $this->clsNode)) {
								// The current element <$k> is not defined in the array clsNode.
								$valid = false;
								break;
							}
						}
						else if ($n=="we:category") {
							if (!in_array($k, $this->catNode)) {
								// The current element <$k> is not defined in the array catNode.
								$valid = false;
								break;
							}
						}
					}
				}
			}
		} else {
			// Either the name of the document root does not match
			// or there are no child elements.
			$valid = false;

			if ($this->nodeName($this->root)!="webEdition") {
				// The name of the document root does not match.
			}
			else if (count($this->nodes[$this->root]["children"])==0) {
				// The document root does not contain any child elements.
			}
		}
		// Returns TRUE if valid, otherwise FALSE.
		return $valid;
	}

}

?>
