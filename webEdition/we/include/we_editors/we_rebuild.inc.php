<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

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