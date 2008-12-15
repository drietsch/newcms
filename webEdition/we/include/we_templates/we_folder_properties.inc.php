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

$parts = array();

array_push($parts,array("icon"=>"path.gif", "headline"=>$GLOBALS["l_we_class"]["path"],"html"=>$GLOBALS['we_doc']->formPath(),"space"=>140));


if($we_doc->Table==FILE_TABLE) {
	if(isset($_SESSION["perms"]["ADMINISTRATOR"]) && $_SESSION["perms"]["ADMINISTRATOR"]){
		array_push($parts,array("icon"=>"lang.gif", "headline"=>$GLOBALS["l_we_class"]["language"],"html"=>$GLOBALS['we_doc']->formLanguage(),"space"=>140,"noline"=>1));
		array_push($parts,array("headline"=>$GLOBALS["l_we_class"]["grant_language"],"html"=>$GLOBALS['we_doc']->formChangeLanguage(),"space"=>140, "forceRightHeadline"=>1));
	} else if($we_doc->Table==FILE_TABLE) {
		array_push($parts,array("icon"=>"lang.gif", "headline"=>$GLOBALS["l_we_class"]["language"],"html"=>$GLOBALS['we_doc']->formLanguage(),"space"=>140));
	}
}

if($we_doc->Table==FILE_TABLE && we_hasPerm("CAN_COPY_FOLDERS")){
	array_push($parts,array("icon"=>"copy.gif", "headline"=>$GLOBALS["l_we_class"]["copyFolder"],"html"=>$GLOBALS['we_doc']->formCopyDocument(),"space"=>140));
}

$wepos = weGetCookieVariable("but_weDirProp");
$znr = 4;
if($we_doc->Table==FILE_TABLE || (defined('OBJECT_FILES_TABLE') && $we_doc->Table==OBJECT_FILES_TABLE)){
	array_push($parts,array("icon"=>"user.gif", "headline"=>$GLOBALS["l_we_class"]["owners"],"html"=>$GLOBALS['we_doc']->formCreatorOwners()."<br>","space"=>140, "noline"=>1));
	if(isset($_SESSION["perms"]["ADMINISTRATOR"]) && $_SESSION["perms"]["ADMINISTRATOR"]){
		array_push($parts,array("headline"=>$GLOBALS["l_users"]["grant_owners"],"html"=>$GLOBALS['we_doc']->formChangeOwners(),"space"=>140, "forceRightHeadline"=>1));
	}
}

if(sizeof($parts) == 1){
	$znr = -1;
}

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("weDirProp","100%",$parts,20);

?>