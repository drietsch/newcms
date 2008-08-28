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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_delSelector.inc.php");
protect();

$_SERVER["PHP_SELF"] = "/webEdition/we_delSelect.php";


$fs = new we_delSelector(
			isset($id) ? $id : ( isset($_REQUEST["id"] ) ? $_REQUEST["id"] : ''),
			isset($table) ? $table : ( isset( $_REQUEST["table"] ) ? $_REQUEST["table"] : FILE_TABLE ));

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>