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


		$id = $_REQUEST["we_cmd"][1];
		$JSIDName = stripslashes($_REQUEST["we_cmd"][2]);
		$JSTextName = stripslashes($_REQUEST["we_cmd"][3]);
		$JSCommand = stripslashes($_REQUEST["we_cmd"][4]);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/export/we_exportDirSelect.php");
?>