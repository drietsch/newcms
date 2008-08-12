<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_sessionLogout($attribs,$content){
    
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tagParser.inc.php");
	$foo = attributFehltError($attribs,"id","sessionLogout");if($foo) return $foo;
	
	$id = we_getTagAttribute("id",$attribs);

	$id = ($id == "self") ? $GLOBALS["WE_MAIN_DOC"]->ID : $id;
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=$id",new DB_WE);

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