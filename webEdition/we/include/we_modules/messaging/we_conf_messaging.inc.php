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


define("MESSAGING_SYSTEM","1");
define("MESSAGES_TABLE",TBL_PREFIX . "tblMessages");
define("MSG_ACCOUNTS_TABLE",TBL_PREFIX . "tblMsgAccounts");
define("MSG_ADDRBOOK_TABLE",TBL_PREFIX . "tblMsgAddrbook");
define("MSG_FOLDERS_TABLE",TBL_PREFIX . "tblMsgFolders");
define("MSG_SETTINGS_TABLE",TBL_PREFIX . "tblMsgSettings");
define("MSG_TODO_TABLE",TBL_PREFIX . "tblTODO");
define("MSG_TODOHISTORY_TABLE",TBL_PREFIX . "tblTODOHistory");


define("WE_MESSAGING_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/messaging/");
define("WE_MESSAGING_MODULE_PATH","/webEdition/we/include/we_modules/messaging/");

?>