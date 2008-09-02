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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tagParser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_parser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_splitFile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_validate.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_import.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/csv.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_baseCollection.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_baseElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wizard.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wiz_import.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wizard_seem.inc.php");

$wizard = new we_wizard_import();

protect();

if (isset($_REQUEST["pnt"])) $what = $_REQUEST["pnt"];
else $what = "wizframeset";

if (isset($_REQUEST["type"])) $type = $_REQUEST["type"];
else $type = "";

if (isset($_REQUEST["step"])) $step = $_REQUEST["step"];
else $step = 0;

if (isset($_REQUEST["mode"])) $mode = $_REQUEST["mode"];
else $mode = 0;

switch ($what) {
	case "wizframeset":
		print $wizard->getWizFrameset();
		break;
	case "wizbody":
		print $wizard->getWizBody($type, $step, $mode);
		break;
	case "wizbusy":
		print $wizard->getWizBusy();
		break;
	case "wizcmd":
		print $wizard->getWizCmd();
		break;
}

?>