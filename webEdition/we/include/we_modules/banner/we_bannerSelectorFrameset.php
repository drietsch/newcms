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
		$JSIDName = $_REQUEST["we_cmd"][2];
		$JSTextName = $_REQUEST["we_cmd"][3];
		$JSCommand = $_REQUEST["we_cmd"][4];

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/we_bannerSelect.php");
?>