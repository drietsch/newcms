<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

protect();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/rebuild/we_rebuild_wizard.inc.php");


$fr = isset($_REQUEST["fr"]) ? $_REQUEST["fr"] : "";


switch($fr){

	case "body":
		print we_rebuild_wizard::getBody();
		break;
	case "busy":
		print we_rebuild_wizard::getBusy();
		break;
	case "cmd":
		print we_rebuild_wizard::getCmd();
		break;
	default:
		print we_rebuild_wizard::getFrameset();
}

?>