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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");

###### protect #################################################################
### protect()
### protects a page. Guests can not see this page


function protect()
{
	global $l_alert;
	if ($_SESSION["user"]["Username"] == "") {
		
		print htmlTop();
		print 
				we_htmlElement::jsElement(
						we_message_reporting::getShowMessageCall(
								$l_alert["perms_no_permissions"], 
								WE_MESSAGE_ERROR) . "top.close();");
		print "</body></html>";
		exit();
	}
}

###### login ###################################################################
### login()
### the same as protect but with an othe error message. It is used after the login


function login()
{
	global $l_alert;
	if ($_SESSION["user"]["Username"] == "") {
		
		print htmlTop();
		print 
				we_htmlElement::jsElement(
						we_message_reporting::getShowMessageCall($l_alert["login_failed"], WE_MESSAGE_ERROR) . "history.back();");
		print "</body></html>";
		exit();
	
	}
}

?>