<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/delete/deleteProgressDialog.inc.php");

$frame = isset($_REQUEST["frame"]) ? $_REQUEST["frame"] : "";

switch($frame){
	
	case "main":
		print deleteProgressDialog::main();
		break;
	case "cmd":
		print deleteProgressDialog::cmd();
		break;
	default:
		print deleteProgressDialog::frameset();
}


?>