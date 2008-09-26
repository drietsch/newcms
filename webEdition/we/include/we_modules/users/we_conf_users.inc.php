<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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