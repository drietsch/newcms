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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_catSelector.inc.php");
protect();

$_SERVER["PHP_SELF"] = "/webEdition/we_catSelect.php";


$fs = new we_catSelector(
			isset($id) ? $id : ( isset($_REQUEST["id"] ) ? $_REQUEST["id"] : ''),
			isset($table) ? $table : ( isset( $_REQUEST["table"] ) ? $_REQUEST["table"] : FILE_TABLE ),
			isset($JSIDName) ? $JSIDName : ( isset( $_REQUEST["JSIDName"] ) ? $_REQUEST["JSIDName"] : "" ),
			isset($JSTextName) ? $JSTextName : ( isset( $_REQUEST["JSTextName"] ) ? $_REQUEST["JSTextName"] : "" ),
			isset($JSCommand) ? $JSCommand : ( isset( $_REQUEST["JSCommand"] ) ? $_REQUEST["JSCommand"] : "" ),
			isset($order) ? $order : ( isset( $_REQUEST["order"] ) ? $_REQUEST["order"] : "" ),
			isset($sessionID) ? $sessionID : ( isset( $_REQUEST["sessionID"] ) ? $_REQUEST["sessionID"] : "" ),
			isset($we_editCatID) ? $we_editCatID : ( isset( $_REQUEST["we_editCatID"] ) ? $_REQUEST["we_editCatID"] : "" ),
			isset($we_EntryText) ? $we_EntryText : ( isset( $_REQUEST["we_EntryText"] ) ? $_REQUEST["we_EntryText"] : "" ),
			isset($rootDirID) ? $rootDirID : ( isset( $_REQUEST["rootDirID"] ) ? $_REQUEST["rootDirID"] : "" ),
			isset($noChoose) ? $noChoose : ( isset( $_REQUEST["noChoose"] ) ? $_REQUEST["noChoose"] : "" ) );

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>