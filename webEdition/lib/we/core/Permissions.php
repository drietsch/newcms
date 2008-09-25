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
 * Base class for permissions
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_core_Permissions
{

	/**
	 * check on specific permission
	 * 
	 * @param string $perm
	 * @return boolean
	 */
	static function hasPerm($perm)
	{
		$perm = strtoupper($perm);
		if (isset($_SESSION["perms"]["ADMINISTRATOR"]) && $_SESSION["perms"]["ADMINISTRATOR"]) {
			return true;
		}
		//we_util_Log::errorlog($perm);
		//we_util_Log::errorlog($_SESSION["perms"][$perm]);
		//we_util_Log::errorlog($_SESSION["perms"]);
		return ((isset($_SESSION["perms"][$perm]) && $_SESSION["perms"][$perm]) || (!isset($_SESSION["perms"][$perm])));
	}

	/**
	 * check on permission to see a page
	 * 
	 * @return string
	 */
	static function protect()
	{
		
		$translate = we_core_Local::addTranslation('permissions.xml');
		
		if (!isset($_SESSION["user"]["Username"]) || $_SESSION["user"]["Username"] == "") {
			$page = new we_ui_layout_HTMLPage();
			$page->addJSFile('/webEdition/js/we_showMessage.js');
			
			$message = we_util_Strings::quoteForJSString($translate->_('You are not permitted to perform this action! Please login again.'), false);
			
			$messageCall = we_core_MessageReporting::getShowMessageCall($message, we_core_MessageReporting::kMessageNotice);
			
			$page->addInlineJS($messageCall . 'if (opener) {top.close();} else {location="/webEdition"}');
			print $page->getHTML();
			exit();
		}
	}

}
