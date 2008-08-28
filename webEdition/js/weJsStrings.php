<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] .  '/alert.inc.php');

header("Content-Type: text/javascript");

print "
var we_string_message_reporting_notice = \"" . $GLOBALS['l_alert']['notice'] . "\";
var we_string_message_reporting_warning = \"" . $GLOBALS['l_alert']['warning'] . "\";
var we_string_message_reporting_error = \"" . $GLOBALS['l_alert']['error'] . "\";
";

?>