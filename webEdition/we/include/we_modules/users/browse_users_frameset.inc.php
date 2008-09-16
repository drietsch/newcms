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