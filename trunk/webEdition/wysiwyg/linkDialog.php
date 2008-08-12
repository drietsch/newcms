<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weHyperlinkDialog.class.inc.php");

$dialog = new weHyperlinkDialog();
$dialog->initByHttp();
$dialog->registerCmdFn("weDoLinkCmd");
print $dialog->getHTML();

function weDoLinkCmd($args){

	if((!isset($args["href"])) || $args["href"] == "http://") $args["href"] = "";

	$param = ($args["param"] ? "?".str_replace("?","",$args["param"]) : "");
	$param = ereg_replace('^&"','',$param);
	$param = ereg_replace('&$','',$param);
	$href = $args["href"] . $param . ($args["anchor"] ? "#".$args["anchor"] : "");
	return '<script language="JavaScript" type="text/javascript">

top.opener.weWysiwygObject_'.$args["editname"].'.createLink("'.$href.'","'.$args["target"].'","'.$args["class"].'","'.$args["lang"].'","'.$args["hreflang"].'","'.$args["title"].'","'.$args["accesskey"].'","'.$args["tabindex"].'","'.$args["rel"].'","'.$args["rev"].'");
top.close();
</script>
';
}
?>