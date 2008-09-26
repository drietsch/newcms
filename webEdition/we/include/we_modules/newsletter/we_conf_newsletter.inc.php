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