<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

if(!isset($_REQUEST["we_cmd"])){
	exit();
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
//protect();
switch($_REQUEST["we_cmd"][0]){
	case "selectorSuggest" :
		$include = "we_ajax/weSelectorSuggest.inc.php";
		break;
}

include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/".$include);
?>