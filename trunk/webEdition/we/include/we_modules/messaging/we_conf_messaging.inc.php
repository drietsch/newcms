<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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