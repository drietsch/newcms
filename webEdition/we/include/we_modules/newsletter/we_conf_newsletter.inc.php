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