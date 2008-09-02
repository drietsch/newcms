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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/we_bannerSelector.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/banner.inc.php");

$_SERVER["PHP_SELF"] = "/webEdition/we/include/we_modules/banner/we_bannerSelect.php";
$fs = new we_bannerSelector(isset($id) ? $id : (isset($_REQUEST["id"]) ? $_REQUEST["id"] : ''),
							isset($JSIDName) ? $JSIDName : (isset($_REQUEST["JSIDName"]) ? $_REQUEST["JSIDName"] : ''),
							isset($JSTextName) ? $JSTextName : (isset($_REQUEST["JSTextName"]) ? $_REQUEST["JSTextName"] : ''),
							isset($JSCommand) ? $JSCommand : (isset($_REQUEST["JSCommand"]) ? $_REQUEST["JSCommand"] : ''),
							isset($order) ? $order : (isset($_REQUEST["order"]) ? $_REQUEST["order"] : ''));
							
$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>