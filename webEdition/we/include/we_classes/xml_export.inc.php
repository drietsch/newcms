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


class XML_Export {

	var $count = 0;
	var $allow_entities = true;
	var $we_tags = array();
	var $docs_exported = array();
	var $temps_exported = array();

	function XML_Export() {print "init";}

	function parse_we_tag($we_tag, $document_id) {
		global $DB_WE;
		$endTag = false;
		$out = -1;
/*
		eregi("<(/?)we:(.+)>?", $we_tag, $regs);
		if ($regs[1]) $endTag = true;

		$foo = (substr($foo,-1) == "/") ? $regs[2] : ($regs[2]."/");
		eregi("([^ >/]+) ?(.*)", $foo, $regs);
		$tagname = $regs[1];
		$attr = trim(ereg_replace("(.*)/$", "\\1", $regs[2]));

		if (!$endTag) {
			$attribs = "";
			preg_match_all('/([^=]+)= *("[^"]*")/', $attr, $foo, PREG_SET_ORDER);
			for ($i = 0; $i < sizeof($foo); $i++) {
				$attribs .= '"'.trim($foo[$i][1]).'"=>'.trim($foo[$i][2]).',';
			}
			$arrstr = "array(".ereg_replace('(.+),$', "\\1", $attribs).")";
			eval('$arr = '.$arrstr.';');

			switch ($tagname) {
				case "img":
					$cid = 0;
					$cid = f("SELECT CID FROM ".LINK_TABLE." WHERE DID=".$document_id." AND Type='img' AND Name='".$arr["name"]."';", "CID", $DB_WE);
					if ($cid) {
						$bdid = 0;
						$bdid = f("SELECT BDID FROM ".CONTENT_TABLE." WHERE ID=".$cid, "BDID", $DB_WE);
						if ($bdid) {
							$imgid = 0;
							$imgid = f("SELECT ID FROM ".FILE_TABLE." WHERE ID=".$bdid, "ID", $DB_WE);
							if ($imgid) {
								$out = $imgid;
							}
						}
					}
					break;

				case "include":
				case "js":
				case "css":
					if (!empty($arr["id"])) {
						$out = $arr["id"];
					}
					break;

				// TODO
				case "a":
				case "field":
				case "flashmovie":
				case "form":
				case "href":
				case "link":
				case "linklist";
				case "printVersion":
				case "url":
					break;
			}
		}
*/
		return $out;
	}

	function get_we_tags($code) {
		$we_tags = array();
		$foo = array();

		preg_match_all ("|(</?we:[^><]+[<>])|U", $code, $foo, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($foo); $i++) {
			if (substr($foo[$i][1], -1) == "<") {
				$foo[$i][1] = substr($foo[$i][1], 0, strlen($foo[$i][1]) - 1);
			}
			array_push($we_tags, $foo[$i][1]);
		}

		return $we_tags;
	}

	function array_mergeunique($base, $extra) {
		if (is_array($base) && is_array($extra)) {
			$ext_arr = (is_array($extra)) ? $extra : array($extra);
			for ($i = 0; $i < sizeOf($ext_arr); $i++) {
				if (!in_array($ext_arr[$i], $base) && !in_array($ext_arr[$i], $this->docs_exported)) {
					$base[] = $ext_arr[$i];
				}
			}
		}
		return $base;
	}

	function export_content($id, $table) {
		global $DB_WE;
		$db_tmp = new DB_WE();
		$attrib_format = "<attrib name='%s' type='%s' size='%s' flags='%s'>%s</attrib>\n";
		$content_format = "<content Name='%s' Type='%s' DocumentTable='%s'>\n";
		$out = array("");

		$DB_WE->query("SELECT * FROM ".LINK_TABLE." WHERE ".LINK_TABLE.".DocumentTable='".mysql_real_escape_string($table)."' AND ".LINK_TABLE.".DID=".abs($id));
		$metadata = $DB_WE->metadata(CONTENT_TABLE);

		while ($DB_WE->next_record()) {
			$out[0] .= sprintf($content_format, $DB_WE->f("Name"), $DB_WE->f("Type"), $DB_WE->f("DocumentTable"));
			$db_tmp->query("SELECT * FROM ".CONTENT_TABLE." WHERE ID=".abs($DB_WE->f("CID")).";");

			while ($db_tmp->next_record()) {		
				foreach ($metadata as $field) {
					if ($field["name"] == "Dat") {
						$dat = $db_tmp->f($field["name"]);

						$we_tags = $this->get_we_tags($dat);
						if (sizeOf($we_tags) > 0) {
							foreach ($we_tags as $we_tag) {
								$entity = $this->parse_we_tag($we_tag, $id);
								if ($entity != -1) {
									$out[1][] = $entity;
								}
							}
						}

						$out[0] .= sprintf($attrib_format, $field["name"], $field["type"], $field["len"], $field["flags"],
								"<![CDATA[".base64_encode($dat)."]]>");
					}
					else {
						$out[0] .= sprintf($attrib_format, $field["name"], $field["type"], $field["len"], $field["flags"],
								$db_tmp->f($field["name"]));
					}
				}
			}
			$out[0] .= "</content>\n";
		}

		return $out;
	}

	function export_entry($id, $table) {
		global $DB_WE;
		$attrib_format = "<attrib name='%s' type='%s' size='%s' flags='%s'>%s</attrib>\n";
		$out = "";

		$metadata = $DB_WE->metadata($table);
		$DB_WE->query("SELECT * FROM ".mysql_real_escape_string($table)." WHERE ID=".abs($id));

		while ($DB_WE->next_record()) {
			foreach ($metadata as $field) {
				$out .= sprintf($attrib_format, $field["name"], $field["type"], $field["len"], $field["flags"], $DB_WE->f($field["name"]));
			}
		}

		return $out;
	}

	function export_nodes($pid) {
		global $DB_WE;
		$out = array();
		$arr = array("","");
		$entities = array();
		$nodes = "";
		$document_id = 0;
		$document_node = "";
		$template_node = "";
		$where = "";

		$where = "WHERE ";
		if (is_array($pid)) {
			for ($i = 0; $i < sizeOf($pid); $i++) {
				$where .= "ID=".abs(trim($pid[$i]));
				if ($i != sizeOf($pid)-1) $where .= " OR ";
			}
		}
		else $where.= "ID=".abs(trim($pid));

		$db_main = new DB_WE();
		$db_main->query("SELECT ID FROM ".FILE_TABLE." ".$where);

		while ($db_main->next_record()) {
			$this->count++;

			// document node
			$document_id = $db_main->f("ID");

			if ($document_id && !in_array($document_id, $this->docs_exported)) { // prevent double export
				$document_node = "<document>\n";
				$document_node .= $this->export_entry($document_id, FILE_TABLE);

				$arr = $this->export_content($document_id, FILE_TABLE);

				$entities = $this->array_mergeunique($entities, $arr[0]);
				// $document_node.= $docs[0];
				$document_node .= "</document>\n";

				array_push($this->docs_exported, $document_id);
				$nodes .= $document_node;
			}

			// template node
			$template_id = f("SELECT TemplateID FROM ".FILE_TABLE." WHERE ID=".abs($document_id), "TemplateID", $DB_WE);

			if ($template_id && !in_array($template_id, $this->temps_exported)) { // prevent double export
				$template_node = "<template>\n";
				$template_node .= $this->export_entry($template_id, TEMPLATES_TABLE);

				$arr = $this->export_content($template_id, TEMPLATES_TABLE);
				$entities = $this->array_mergeunique($entities, $arr[0]);
				$template_node .= $arr[0];
				$template_node .= "</template>\n";

				array_push($this->temps_exported, $template_id);
				$nodes .= $template_node;
			}
		}

		$out = array($nodes, $entities);
		return $out;
	}

	function update_entities($base, $extra) {
		if (!is_array($base))
			return false;

		while ($this->allow_entities) {
			for ($i = 0; $i < sizeOf($base); $i++) {
				if (in_array($base[$i], $this->docs_exported)) {
					$e = array_splice($base, $i, 1);
					continue 2;
				}
			}
			break;
		}

		$ext_arr = (is_array($extra)) ? $extra : array($extra);
		for ($i = 0; $i < sizeOf($ext_arr); $i++) {

			// prevent double export of entities
			if (!in_array($ext_arr[$i], $base) && !in_array($ext_arr[$i], $this->docs_exported)) {
				$base[] = $ext_arr[$i];
			}
		}

		return $base;
	}

	function xml_output($documents, $file) {
		$xml_out = "";
		$entities = array();
		$arr = array();
		$dtd = str_replace("\t", "", "
			<!DOCTYPE we_site [
			<!ELEMENT we_site (document|template)+>
			<!ELEMENT document (attrib+, content*)>
			<!ELEMENT template (attrib+, content*)>
			<!ELEMENT content (attrib)+>
			<!ATTLIST content Name CDATA #REQUIRED>
			<!ATTLIST content Type CDATA #REQUIRED>
			<!ATTLIST content DocumentTable CDATA #IMPLIED>
			<!ELEMENT attrib (#PCDATA)>
			<!ATTLIST attrib name CDATA #REQUIRED>
			<!ATTLIST attrib type CDATA #REQUIRED>
			<!ATTLIST attrib size CDATA #IMPLIED>
			<!ATTLIST attrib flags CDATA #IMPLIED>
			]>");
		$root = "<we_site>";
		$nodes = "";

		$xml_out = '<?xml version="1.0" standalone="yes" ?>';
		$xml_out.= $dtd."\n".$root."\n";

		// add document and template nodes 
		$arr = $this->export_nodes($documents);
		$xml_out.= $arr[0];

		// if allowed add nodes of linked documents or entities
		while ($this->allow_entities) {
			$entities = $this->update_entities($entities, $arr[1]);

			while (sizeOf($entities) > 1) {
				$nodes = $this->export_nodes($entities);
				$xml_out.= $nodes[0];
				continue 2;
			}
			break;
		}
		$xml_out.= str_replace("<", "</", $root);

		// write xml string to file
		$fh = fopen($file, "w");
		if ($fh) fwrite($fh, $xml_out);
		fclose($fh);
	}

}

?>
