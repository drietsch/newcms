<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


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