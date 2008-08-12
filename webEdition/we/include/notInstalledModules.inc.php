<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");


	print '<script type="text/javascript">var win = window.open("http://modules.webedition.de/index.php?modules='.rawurlencode($_SESSION["we_module_list"]).'&language='.$GLOBALS["WE_LANGUAGE"].'&weversion='.WE_VERSION.'","nomods","width=640,height=480,scrollbars=yes,statusbar=no,menubar=no,resizable=yes")</script>';
?>