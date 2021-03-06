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


function we_tag_sessionLogout($attribs,$content){
    
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tagParser.inc.php");
	$foo = attributFehltError($attribs,"id","sessionLogout");if($foo) return $foo;
	
	$id = we_getTagAttribute("id",$attribs);

	$id = ($id == "self") ? $GLOBALS["WE_MAIN_DOC"]->ID : $id;
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."",new DB_WE);

	if(!empty($row)) {
		$url = $row["Path"].($row["IsFolder"] ? "/" : "");
	} else  {
		$url = "";
	}
	
	$attr = we_make_attribs($attribs,"id");
	
	//  then lets parse the content
    $tp = new we_tagParser();
    $tags = $tp->getAllTags($content);
    $tp->parseTags($tags,$content);
	
	return '<a href="'.$url.'?we_webUser_logout=1" '.($attr ? $attr : '').'>'.$content."</a>";
}
?>