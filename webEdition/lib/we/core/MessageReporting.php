<?php

/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * class for error_reporting, uses the javascript function showmessage in
 * webEdition.php
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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

