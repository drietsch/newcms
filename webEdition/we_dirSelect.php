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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_dirSelector.inc.php");
protect();

$_SERVER["PHP_SELF"] = "/webEdition/we_dirSelect.php";

$fs = new we_dirSelector(
		isset( $id ) ? $id : ( isset( $_REQUEST["id"] ) ? $_REQUEST["id"] : '' ),
		isset( $table ) ? $table : ( isset( $_REQUEST["table"] ) ? $_REQUEST["table"] : FILE_TABLE ),
		isset( $JSIDName ) ? $JSIDName : ( isset( $_REQUEST["JSIDName" ] ) ? $_REQUEST["JSIDName"] : '' ),
		isset( $JSTextName ) ? $JSTextName : ( isset( $_REQUEST["JSTextName"] ) ? $_REQUEST["JSTextName"] : '' ),
		isset( $JSCommand ) ? $JSCommand : ( isset( $_REQUEST["JSCommand"] ) ? $_REQUEST["JSCommand"] : '' ),
		isset( $order ) ? $order : ( isset( $_REQUEST["order"] ) ? $_REQUEST["order"] : '' ),
		isset( $sessionID ) ? $sessionID : ( isset( $_REQUEST["sessionID"] ) ? $_REQUEST["sessionID"] : '' ),
		isset( $we_editDirID ) ? $we_editDirID : ( isset( $_REQUEST["we_editDirID"] ) ? $_REQUEST["we_editDirID"] : '' ),
		isset( $we_FolderText ) ? $we_FolderText : ( isset( $_REQUEST["we_FolderText"] ) ? $_REQUEST["we_FolderText"] : '' ),
		isset( $rootDirID ) ? $rootDirID : ( isset( $_REQUEST["rootDirID"] ) ? $_REQUEST["rootDirID"] : '' ),
		isset( $multiple ) ? $multiple : ( isset( $_REQUEST["multiple"] ) ? $_REQUEST["multiple"] : '' ));

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>