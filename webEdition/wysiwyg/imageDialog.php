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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


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