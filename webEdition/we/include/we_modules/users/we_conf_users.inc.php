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


define("USER_TABLE",TBL_PREFIX .  "tblUser");
define("LOCK_TABLE",TBL_PREFIX . "tblLock");

define("WE_LANGUAGE_ID","0");
define("PING_TIME","60"); // 1 Min
define("PING_TOLERANZ","20"); // 20 sec

define("WE_USERS_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/users/");
define("WE_USERS_MODULE_PATH","/webEdition/we/include/we_modules/users/");

@include(WE_USERS_MODULE_DIR."we_conf_userpro.inc.php");

?>