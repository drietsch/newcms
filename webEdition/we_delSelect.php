<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_delSelector.inc.php");
protect();

$_SERVER["PHP_SELF"] = "/webEdition/we_delSelect.php";


$fs = new we_delSelector(
			isset($id) ? $id : ( isset($_REQUEST["id"] ) ? $_REQUEST["id"] : ''),
			isset($table) ? $table : ( isset( $_REQUEST["table"] ) ? $_REQUEST["table"] : FILE_TABLE ));

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>