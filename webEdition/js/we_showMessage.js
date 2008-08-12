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