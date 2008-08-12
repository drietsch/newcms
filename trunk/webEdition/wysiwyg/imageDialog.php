<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weImageDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php");

$dialog = new weImageDialog();
$dialog->initByHttp();
$dialog->registerCmdFn("weDoImgCmd");
$yuiSuggest =& weSuggest::getInstance();
print $dialog->getHTML();

function weDoImgCmd($args){
	
	if($args["thumbnail"] && $args["fileID"]){
		$thumbObj = new we_thumbnail();
		$thumbObj->initByImageIDAndThumbID($args["fileID"],$args["thumbnail"]);
		if(!file_exists($thumbObj->getOutputPath(true))){
			$thumbObj->createThumb();	
		}
	}
	
	return '<script language="JavaScript" type="text/javascript">

top.opener.weWysiwygObject_'.$args["editname"].'.insertImage("'.$args["src"].'","'.$args["width"].'","'.$args["height"].'","'.$args["hspace"].'","'.$args["vspace"].'","'.$args["border"].'","'.addslashes($args["alt"]).'","'.$args["align"].'","'.$args["name"].'","'.$args["class"].'","'.addslashes($args["title"]).'","'.$args["longdesc"].'");
top.close();
</script>
';
}
?>