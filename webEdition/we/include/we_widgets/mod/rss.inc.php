<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cockpit.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/PEAR.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Parser.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/RSS.php");

protect();


print htmlTop();
print "<script type=\"text/javascript\">

function init() {
	parent.executeAjaxRequest('" . implode("', '", $_REQUEST["we_cmd"]) . "');
	
}


</script>";
print we_htmlElement::htmlBody(
		array("onload" => "init()")
);
print "</html>";
?>