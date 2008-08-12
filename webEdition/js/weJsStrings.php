<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] .  '/alert.inc.php');

header("Content-Type: text/javascript");

print "
var we_string_message_reporting_notice = \"" . $GLOBALS['l_alert']['notice'] . "\";
var we_string_message_reporting_warning = \"" . $GLOBALS['l_alert']['warning'] . "\";
var we_string_message_reporting_error = \"" . $GLOBALS['l_alert']['error'] . "\";
";

?>