<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


$id = $_REQUEST["we_cmd"][4];
$table = USER_TABLE;
$JSIDName = $_REQUEST["we_cmd"][1];
$JSTextName = $_REQUEST["we_cmd"][2];
$JSCommand = isset($_REQUEST["we_cmd"][5]) ? $_REQUEST["we_cmd"][5] : "";
$sessionID = isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : 0;
$rootDirID = isset($_REQUEST["we_cmd"][7]) ? $_REQUEST["we_cmd"][7] : 0;
$filter = $_REQUEST["we_cmd"][3];
$multiple = isset($_REQUEST["we_cmd"][8]) ? $_REQUEST["we_cmd"][8] : 0;

include_once(WE_USERS_MODULE_DIR . "we_usersSelect.php");

?>