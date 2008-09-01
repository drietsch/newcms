<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * class for error_reporting, uses the javascript function showmessage in
 * webEdition.php
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_core_MessageReporting
{

	// contansts for messaging!
	// these are binray checked like permissions in unix, DON'T change indexes
	const kMessageInfo = -1;

	const kMessageFrontend = -2;

	const kMessageNotice = 1;

	const kMessageWarning = 2;

	const kMessageError = 4;

	/**
	 * returns js-call for the showMessage function
	 *
	 * @param string $message
	 * @param integer $priority
	 * @param boolean $isJsMsg
	 * @param boolean $isOpener
	 * @return string
	 */
	static function getShowMessageCall($message, $priority, $isJsMsg = false, $isOpener = false)
	{
		
		if ($priority == self::kMessageInfo || $priority == self::kMessageFrontend) {
			
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

