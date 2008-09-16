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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once(WE_USERS_MODULE_DIR . "we_usersSelector.inc.php");

protect();
$_SERVER["PHP_SELF"] = WE_USERS_MODULE_PATH . "we_usersSelect.php";

$fs = new we_usersSelector(isset($id) ? $id : (isset($_REQUEST["id"]) ? $_REQUEST["id"] : "" ),
							isset($table) ? $table : (isset($_REQUEST["table"]) ? $_REQUEST["table"] : USER_TABLE),
							isset($JSIDName) ? $JSIDName : (isset($_REQUEST["JSIDName"]) ? $_REQUEST["JSIDName"] : "" ),
							isset($JSTextName) ? $JSTextName : (isset($_REQUEST["JSTextName"]) ? $_REQUEST["JSTextName"] : "" ),
							isset($JSCommand) ? $JSCommand : (isset($_REQUEST["JSCommand"]) ? $_REQUEST["JSCommand"] : "" ),
							isset($order) ? $order : (isset($_REQUEST["order"]) ? $_REQUEST["order"] : "" ),
							isset($sessionID) ? $sessionID : (isset($_REQUEST["sessionID"]) ? $_REQUEST["sessionID"] : "" ),
							isset($rootDirID) ? $rootDirID : (isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "" ),
							isset($filter) ? $filter : (isset($_REQUEST["filter"]) ? $_REQUEST["filter"] : "" ),
							isset($multiple) ? $multiple : (isset($_REQUEST["multiple"]) ? $_REQUEST["multiple"] : "" ));

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>