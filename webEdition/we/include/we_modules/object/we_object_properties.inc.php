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



include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");

$parts = array();

if ($we_doc->EditPageNr != WE_EDITPAGE_WORKSPACE) {
	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["path"],
						"html"=>$GLOBALS['we_doc']->formPath(),
						"space"=>140,
						"icon"=>"path.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_object"]["default"],
						"html"=>$GLOBALS['we_doc']->formDefault(),
						"space"=>140,
						"icon"=>"default.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_cache"]["cache"],
						"html"=>$GLOBALS['we_doc']->formCache(),
						"space"=>140,
						"icon"=>"cache.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["Charset"],
						"html"=>$GLOBALS['we_doc']->formCharset(),
						"space"=>140,
						"icon"=>"charset.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["CSS"],
						"html"=>$GLOBALS['we_doc']->formCSS(),
						"space"=>140,
						"icon"=>"css.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_object"]["copyClass"],
						"html"=>$GLOBALS['we_doc']->formCopyDocument(),
						"space"=>140,
						"icon"=>"copy.gif")
				);

} else {

	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["workspaces"],
						"html"=>$GLOBALS['we_doc']->formWorkspaces(),
						"space"=>140,
						"icon"=>"workspace.gif")
				);
	array_push($parts,array(
						"headline"=>$GLOBALS["l_object"]["behaviour"],
						"html"=>$GLOBALS['we_doc']->formWorkspacesFlag(),
						"space"=>140,
						"icon"=>"display.gif")
				);
}
print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("","100%",$parts,30,"",-1,"","",false);

?>