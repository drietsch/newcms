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

// contansts for messaging!
// these are binray checked like permissions in unix, DON'T change indexes
define("WE_MESSAGE_INFO", -1);
define("WE_MESSAGE_FRONTEND", -2);
define("WE_MESSAGE_NOTICE", 1);
define("WE_MESSAGE_WARNING", 2);
define("WE_MESSAGE_ERROR", 4);

/**
 * class forerror_reporting, uses the javascript function showmessage in
 * webEdition.php
 *
 */
class we_message_reporting {

	/**
	 * returns js-call for the showMessage function
	 *
	 * @param string $message
	 * @param integer $priority
	 * @param boolean $isJsMsg
	 * @return string
	 */
	function getShowMessageCall($message, $priority, $isJsMsg=false, $isOpener=false) {

		if ($priority == WE_MESSAGE_INFO || $priority == WE_MESSAGE_FRONTEND) {

			if ($isJsMsg) { // message is build from scripts, just print it!
				return "alert( $message );";

			} else {
				return 'alert("' . str_replace("'", "\'", $message) . '");';

			}

		} else {

			if ($isJsMsg) { // message is build from scripts, just print it!
				return ($isOpener ? "top.opener." : "") . "top.we_showMessage($message, $priority, window);";

			} else {
				return ($isOpener ? "top.opener." : "") . "top.we_showMessage(\"" . str_replace("\"", "\\\"", $message) . "\", $priority, window);";

			}
		}
	}
}

?>