<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


		$id = $_REQUEST["we_cmd"][1];
		$JSIDName = stripslashes($_REQUEST["we_cmd"][2]);
		$JSTextName = stripslashes($_REQUEST["we_cmd"][3]);
		$JSCommand = stripslashes($_REQUEST["we_cmd"][4]);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/export/we_exportDirSelect.php");
?>