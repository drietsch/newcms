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

include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] .  '/alert.inc.php');

header("Content-Type: text/javascript");

print "
var we_string_message_reporting_notice = \"" . $GLOBALS['l_alert']['notice'] . "\";
var we_string_message_reporting_warning = \"" . $GLOBALS['l_alert']['warning'] . "\";
var we_string_message_reporting_error = \"" . $GLOBALS['l_alert']['error'] . "\";
";

?>