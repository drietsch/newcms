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

// this function is universal function for all messages in webEdition
/* 
if you make changes here, make also in: 
	/www/we5/webEdition/we/include/we_classes/we_dirSelector.inc.php (188-213) 
	/www/we5/webEdition/we/include/we_classes/we_docSelector.inc.php (219-244)
	/www/we5/webEdition/we/include/we_classes/we_multiSelector.inc.php (130-155) 
	/www/we5/webEdition/we/include/we_modules/banner/we_bannerDirSelector.php (126-151)
	/www/we5/webEdition/we/include/we_modules/export/we_exportDirSelector.php (126-151) 	
	/www/we5/webEdition/we/include/we_modules/newsletter/weNewsletterDirSelector.inc.php (222-247) 
	/www/we5/webEdition/we/include/we_modules/voting/we_votingDirSelector.php (129-154)
	/www/we5/webEdition/we/include/we_tools/navigation/we_navigationDirSelector.php (130-155)
*/
var WE_MESSAGE_INFO = -1;
var WE_MESSAGE_FRONTEND = -2;
var WE_MESSAGE_NOTICE = 1;
var WE_MESSAGE_WARNING = 2;
var WE_MESSAGE_ERROR = 4;

function we_showMessage (message, prio, win) {
	if (win.top.showMessage != null) {
		win.top.showMessage(message, prio, win);
	} else if (win.top.opener) {
		if (win.top.opener.top.showMessage != null) {
			win.top.opener.top.showMessage(message, prio, win);
		} else if (win.top.opener.top.opener.top.showMessage != null) {
			win.top.opener.top.opener.top.showMessage(message, prio, win);
		} else if (win.top.opener.top.opener.top.opener.top.showMessage != null) {
			win.top.opener.top.opener.top.opener.top.showMessage(message, prio, win);
		}
	} else { // there is no webEdition window open, just show the alert
		if (!win) {
			win = window;
		}
		win.alert(message);

	}
}