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