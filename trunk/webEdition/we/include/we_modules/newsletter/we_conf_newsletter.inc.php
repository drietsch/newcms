<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


define("NEWSLETTER_TABLE", TBL_PREFIX . "tblNewsletter");
define("NEWSLETTER_BLOCK_TABLE", TBL_PREFIX . "tblNewsletterBlock");
define("NEWSLETTER_CONFIRM_TABLE", TBL_PREFIX . "tblNewsletterConfirm");
define("NEWSLETTER_GROUP_TABLE", TBL_PREFIX . "tblNewsletterGroup");
define("NEWSLETTER_LOG_TABLE", TBL_PREFIX . "tblNewsletterLog");
define("NEWSLETTER_PREFS_TABLE", TBL_PREFIX . "tblNewsletterPrefs");

define("WE_NEWSLETTER_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/newsletter/");
define("WE_NEWSLETTER_MODULE_PATH", "/webEdition/we/include/we_modules/newsletter/");
define("WE_NEWSLETTER_CACHE_DIR", WE_NEWSLETTER_MODULE_DIR . "/cache/");

?>