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


/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_message_reporting/we_message_reporting.class.php");

/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/start.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

$ignore_browser = isset($_REQUEST["ignore_browser"]) &&  ($_REQUEST["ignore_browser"] === "true");

/*****************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function getValueLoginMode($val) {
	switch ($val) {
		case "seem" :
			if (isset($_COOKIE["we_mode"]) && $_COOKIE["we_mode"] == "seem") { // last mode was seem mode
				return " checked=\"checked\"";
			} else {
				return "";
			}
			break;

		case "normal" :
			if (!isset($_COOKIE["we_mode"]) || $_COOKIE["we_mode"] != "seem") { // start normal mode
				return " checked=\"checked\"";
			} else {
				return "";
			}
			break;
	}
}

function checkSupportedBrowser() {
	global $SYSTEM, $BROWSER, $IE55;

	$_supported = false;

	switch ($SYSTEM) {
		case "WIN" :
			switch ($BROWSER) {
				case "IE":
					if ($IE55) {
						$_supported = true;
					}

					break;

				case "SAFARI":
				case "NN6":
					$_supported = true;
					break;
			}

			break;

		case "MAC":
			switch ($BROWSER) {
				case "NN6":
				case "SAFARI":
					$_supported = true;
					break;
			}

			break;

		case "X11":
			switch ($BROWSER) {
				case "NN6":
					$_supported = true;
					break;
			}

			break;

		case "UNKNOWN":
			switch ($BROWSER) {
				case "IE":
					if ($IE55) {
						$_supported = true;
					}

					break;

				case "NN6":
				case "SAFARI":
					$_supported = true;
					break;
			}

			break;
	}

	return $_supported;
}

/*****************************************************************************
 * CREATE TMP, FRAGMENTS AND VERSIONS FOLDER
 *****************************************************************************/
if (!is_dir(TMP_DIR)) {
	createLocalFolder(TMP_DIR);
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");
if (!is_dir(FRAGMENT_LOCATION)) {
	createLocalFolder(FRAGMENT_LOCATION);
}
if (!is_dir($_SERVER["DOCUMENT_ROOT"].VERSION_DIR)) {
	createLocalFolder($_SERVER["DOCUMENT_ROOT"], VERSION_DIR);
}

/*****************************************************************************
 * CHECK FOR FAILED LOGIN ATTEMPTS
 *****************************************************************************/

$DB_WE->query("SELECT ID FROM ".FAILED_LOGINS_TABLE." WHERE IP='".addslashes($_SERVER["REMOTE_ADDR"])."' AND LoginDate > (".(time() - (60 * abs(LOGIN_FAILED_TIME))).")");

if ($DB_WE->num_rows() >= LOGIN_FAILED_NR) {
	htmlTop("webEdition " . WE_VERSION);
	print we_htmlElement::jsElement(
		we_message_reporting::getShowMessageCall( sprintf($l_alert["3timesLoginError"], LOGIN_FAILED_NR,LOGIN_FAILED_TIME), WE_MESSAGE_ERROR )
	);
	print "</html>";
	exit();
}

/*****************************************************************************
 * SWITCH MODE
 *****************************************************************************/
if ( isset($GLOBALS["userLoginDenied"]) ) {
	$login = 4;
} else if (isset($_SESSION["user"]["Username"]) && isset($_POST["password"]) && isset($_POST["username"])) {
	$login = 2;
	setcookie("we_mode", $_REQUEST["mode"], time() + 2592000);	//	Cookie remembers the last selected mode, it will expire in one Month !!!
} else if (isset($_POST["password"]) && isset($_POST["username"])) {
	$login = 1;
} else {
	$login = 0;
	if ($ignore_browser) {
		setcookie("ignore_browser", "true", time() + 2592000);	//	Cookie remembers that the incompatible mode has been selected, it will expire in one Month !!!
	}
}

/*****************************************************************************
 * CREATE HEADER
 *****************************************************************************/
htmlTop("webEdition " . WE_VERSION);
print STYLESHEET;

print we_htmlElement::jsElement("", array("src" => JS_DIR . "windows.js"));
print we_htmlElement::jsElement("", array("src" => JS_DIR . "weJsStrings.php"));

if ($login != 2) {
	print we_htmlElement::linkElement(array("rel" => "home", "href" => "/webEdition/"));
	print we_htmlElement::linkElement(array("rel" => "author", "href" => $l_start["we_homepage"]));
}

print we_htmlElement::linkElement(array("rel" => "SHORTCUT ICON", "href" => "/webEdition/images/webedition.ico"));

$_head_javascript = "
	cookieBackup = document.cookie;
	document.cookie = \"cookie=yep\";
	cookieOk = document.cookie.indexOf(\"cookie=yep\") > -1;
	document.cookie = cookieBackup;

	if (!cookieOk) {
		" . we_message_reporting::getShowMessageCall( $l_alert["no_cookies"], WE_MESSAGE_ERROR ) . "
	}

";

$_head_javascript .= '
var messageSettings = ' . (WE_MESSAGE_ERROR + WE_MESSAGE_WARNING + WE_MESSAGE_NOTICE) . ';

/**
 * setting is built like the unix file system privileges with the 3 options
 * see notices, see warnings, see errors
 *
 * 1 => see Errors
 * 2 => see Warnings
 * 4 => see Notices
 *
 * @param message string
 * @param prio integer one of the values 1,2,4
 * @param win object reference to the calling window
 */
function showMessage(message, prio, win){

	if (!win) {
		win = window;
	}
	if (!prio) { // default is error, to avoid missing messages
		prio = 4;
	}

	if (prio & messageSettings) { // show it, if you should

		// the used vars are in file JS_DIR . "weJsStrings.php";
		switch (prio) {

			// Notice
			case 1:
				win.alert(we_string_message_reporting_notice + ":\n" + message);
				break;

			// Warning
			case 2:
				win.alert(we_string_message_reporting_warning + ":\n" + message);
				break;

			// Error
			case 4:
				win.alert(we_string_message_reporting_error + ":\n" + message);
				break;
		}
	}
}
';

print we_htmlElement::jsElement($_head_javascript);

print "</head>";

/*****************************************************************************
 * CHECK FOR PROBLEMS
 *****************************************************************************/

if (isset($_POST["checkLogin"]) && !count($_COOKIE)) {
	$_error = we_htmlElement::htmlB($l_start["coockies_disabled"]);

	$_error_count = 0;
	$tmp = ini_get("session.save_path");

	if (!(is_dir($tmp) && file_exists($tmp))) {
		$_error .= $_error_count++ . " - " . sprintf($l_start["tmp_path"], ini_get("session.save_path")) . "<br>";
	}

	if (!ini_get("session.use_cookies")) {
		$_error .= $_error_count++ . " - " . $l_start["use_cookies"] . "<br>";
	}

	if (ini_get("session.cookie_path") != "/") {
		$_error .= $_error_count++ . " - " . sprintf($l_start["cookie_path"], ini_get("session.cookie_path")) . "<br>";
	}

	if ($_error_count == 1) {
		$_error .= "<br>" . $l_start["solution_one"];
	} else if ($_error_count > 1) {
		$_error .= "<br>" . $l_start["solution_more"];
	}

	$_layout = new we_htmlTable(array("width" => "100%", "height" => "75%", "style" => "width: 100%; height: 75%;"), 1, 1);

	$_layout->setCol(0, 0, array("align" => "center", "valign" => "middle"), we_htmlElement::htmlCenter(htmlMessageBox(500, 250, we_htmlElement::htmlP(array("class" => "defaultfont"), $_error), $l_alert["phpError"])));

	print we_htmlElement::htmlBody(array("bgcolor" => "#FFFFFF"), $_layout->getHtmlCode()) . "</html>";

} else if(!$DB_WE->connect()) {
	$_error = we_htmlElement::htmlB($l_start["no_db_connction"]);

	$_error_count = 0;
	$tmp = ini_get("session.save_path");

	if (!(is_dir($tmp) && file_exists($tmp))) {
		$_error .= $_error_count++ . " - " . sprintf($l_start["tmp_path"], ini_get("session.save_path")) . "<br>";
	}

	if (!ini_get("session.use_cookies")) {
		$_error .= $_error_count++ . " - " . $l_start["use_cookies"] . "<br>";
	}

	if (ini_get("session.cookie_path") != "/") {
		$_error .= $_error_count++ . " - " . sprintf($l_start["cookie_path"], ini_get("session.cookie_path")) . "<br>";
	}

	if ($_error_count == 1) {
		$_error .= "<br>" . $l_start["solution_one"];
	} else if ($_error_count > 1) {
		$_error .= "<br>" . $l_start["solution_more"];
	}

	$_layout = new we_htmlTable(array("width" => "100%", "height" => "75%", "style" => "width: 100%; height: 75%;"), 1, 1);

	$_layout->setCol(0, 0, array("align" => "center", "valign" => "middle"), we_htmlElement::htmlCenter(htmlMessageBox(500, 250, we_htmlElement::htmlP(array("class" => "defaultfont"), $_error), $l_alert["phpError"])));

	print we_htmlElement::htmlBody(array("bgcolor" => "#FFFFFF"), $_layout->getHtmlCode()) . "</html>";


} else if (isset($_POST["checkLogin"]) && $_POST["checkLogin"] != session_id()) {
	$_error = we_htmlElement::htmlB(sprintf($l_start["phpini_problems"], (ini_get("cfg_file_path") ? " (" . ini_get("cfg_file_path") . ")" : "")) . "<br><br>");

	$_error_count = 0;
	$tmp = ini_get("session.save_path");

	if (!(is_dir($tmp) && file_exists($tmp))) {
		$_error .= $_error_count++ . " - " . sprintf($l_start["tmp_path"], ini_get("session.save_path")) . "<br>";
	}

	if (!ini_get("session.use_cookies")) {
		$_error .= $_error_count++ . " - " . $l_start["use_cookies"] . "<br>";
	}

	if (ini_get("session.cookie_path") != "/") {
		$_error .= $_error_count++ . " - " . sprintf($l_start["cookie_path"], ini_get("session.cookie_path")) . "<br>";
	}

	if ($_error_count == 1) {
		$_error .= "<br>" . $l_start["solution_one"];
	} else if ($_error_count > 1) {
		$_error .= "<br>" . $l_start["solution_more"];
	}

	$_layout = new we_htmlTable(array("width" => "100%", "height" => "75%", "style" => "width: 100%; height: 75%;"), 1, 1);

	$_layout->setCol(0, 0, array("align" => "center", "valign" => "middle"), we_htmlElement::htmlCenter(htmlMessageBox(500, 250, we_htmlElement::htmlP(array("class" => "defaultfont"), $_error), $l_alert["phpError"])));

	print we_htmlElement::htmlBody(array("bgcolor" => "#FFFFFF"), $_layout->getHtmlCode()) . "</html>";

} else if (!$ignore_browser && !checkSupportedBrowser()) {

	/*********************************************************************
	 * CHECK BROWSER
	 *********************************************************************/


	if ($SYSTEM == "MAC") {
		$_browser_table = new we_htmlTable(array("cellspacing" => 0, "cellpadding" => 0, "border" => 0, "width" => "100%"), 12, 2);
	} else {
		$_browser_table = new we_htmlTable(array("cellspacing" => 0, "cellpadding" => 0, "border" => 0, "width" => "100%"), 12, 3);
	}

	$_browser_table->setCol(1, 0, ($SYSTEM == "MAC") ? array("align" => "center", "class" => "defaultfont", "colspan" => 2) : array("align" => "center", "class" => "defaultfont", "colspan" => 3), we_htmlElement::htmlB($l_start["browser_not_supported"]));
	$_browser_table->setCol(3, 0, ($SYSTEM == "MAC") ? array("align" => "center", "class" => "defaultfont", "colspan" => 2) : array("align" => "center", "class" => "defaultfont", "colspan" => 3), $l_start["browser_supported"]);

	if ($SYSTEM == "MAC") {
		$_browser_table->setCol(5, 0, array("align" => "center"), we_htmlElement::htmlA(array("href" => "http://www.apple.com/safari/", "target" => "_blank"), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/supported_browser_safari.gif", "width" => 80, "height" => 80, "border" => 0))));
		$_browser_table->setCol(5, 1, array("align" => "center"), we_htmlElement::htmlA(array("href" => "http://www.mozilla.org/", "target" => "_blank"), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/supported_browser_firefox.gif", "width" => 80, "height" => 80, "border" => 0))));
	} else {
		$_browser_table->setCol(5, 0, array("align" => "center"), we_htmlElement::htmlA(array("href" => "http://www.microsoft.com/windows/ie/", "target" => "_blank"), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/supported_browser_ie.gif", "width" => 80, "height" => 80, "border" => 0))));
		$_browser_table->setCol(5, 1, array("align" => "center"), we_htmlElement::htmlA(array("href" => "http://www.mozilla.org/", "target" => "_blank"), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/supported_browser_firefox.gif", "width" => 80, "height" => 80, "border" => 0))));
		$_browser_table->setCol(5, 2, array("align" => "center"), we_htmlElement::htmlA(array("href" => "http://www.apple.com/safari/", "target" => "_blank"), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/supported_browser_safari.gif", "width" => 80, "height" => 80, "border" => 0))));
	}

	if ($SYSTEM == "MAC") {
		$_browser_table->setCol(7, 0, array("align" => "center", "class" => "defaultfont"), we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => "http://www.apple.com/safari/", "target" => "_blank"),$l_start["browser_safari"])));
		$_browser_table->setCol(7, 1, array("align" => "center", "class" => "defaultfont"), we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => "http://www.mozilla.org/", "target" => "_blank"),$l_start["browser_firefox"])));
	} else {
		$_browser_table->setCol(7, 0, array("align" => "center", "class" => "defaultfont"), we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => "http://www.microsoft.com/windows/ie/", "target" => "_blank"),$l_start["browser_ie"])));
		$_browser_table->setCol(7, 1, array("align" => "center", "class" => "defaultfont"), we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => "http://www.mozilla.org/", "target" => "_blank"),$l_start["browser_firefox"])));
		$_browser_table->setCol(7, 2, array("align" => "center", "class" => "defaultfont"), we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => "http://www.apple.com/safari/", "target" => "_blank"),$l_start["browser_safari"])));
	}

	if ($SYSTEM == "MAC") {
		$_browser_table->setCol(9, 0, array("align" => "center", "valign" => "top", "class" => "defaultfont"), $l_start["browser_safari_version"]);
		$_browser_table->setCol(9, 1, array("align" => "center", "valign" => "top", "class" => "defaultfont"), $l_start["browser_firefox_version"]);
	} else {
		$_browser_table->setCol(9, 0, array("align" => "center", "valign" => "top", "class" => "defaultfont"), $l_start["browser_ie_version"]);
		$_browser_table->setCol(9, 1, array("align" => "center", "valign" => "top", "class" => "defaultfont"), $l_start["browser_firefox_version"]);
		$_browser_table->setCol(9, 2, array("align" => "center", "valign" => "top", "class" => "defaultfont"), $l_start["browser_safari_version"]);
	}

	$_browser_table->setCol(0, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 20));
	$_browser_table->setCol(2, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 50));
	$_browser_table->setCol(4, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 30));
	$_browser_table->setCol(6, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 10));
	$_browser_table->setCol(8, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 5));
	$_browser_table->setCol(10, 0, ($SYSTEM == "MAC") ? array("colspan" => 2) : array("colspan" => 3), getPixel(1, 50));

	$_browser_table->setCol(11, 0, ($SYSTEM == "MAC") ? array("align" => "center", "class" => "defaultfont", "colspan" => 2) : array("align" => "center", "class" => "defaultfont", "colspan" => 3), we_htmlElement::htmlA(array("href" => WEBEDITION_DIR . "index.php?ignore_browser=true"), $l_start["ignore_browser"]));

	$_layout = new we_htmlTable(array("width" => "100%", "height" => "75%", "style" => "width: 100%; height: 75%;"), 1, 1);

	$_layout->setCol(0, 0, array("align" => "center", "valign" => "middle"), we_htmlElement::htmlCenter(htmlMessageBox(500, 380, $_browser_table->getHtmlCode(), $l_start["cannot_start_we"])));

	print we_htmlElement::htmlBody(array("bgcolor" => "#FFFFFF"), $_layout->getHtmlCode()) . "</html>";

} else {

/*****************************************************************************
 * GENERATE LOGIN
 *****************************************************************************/

	$_hidden_values = we_htmlElement::htmlHidden(array("name" => "checkLogin", "value" => session_id()));

	if ($ignore_browser) {
		$_hidden_values .= we_htmlElement::htmlHidden(array("name" => "ignore_browser", "value" => "true"));
	}




	/*************************************************************************
	 * BUILD DIALOG
	 *************************************************************************/

	$GLOBALS["loginpage"] = ($login == 2) ? false : true;
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_templates/we_info.inc.php");

	$dialogtable = '<table cellpadding="0" cellspacing="0" border="0" style="width:818px;">
	<tr style="height:10px;">
		<td style="width:260px;background-color:#386AAB;"></td>
		<td rowspan="2" style="width:430px;">'.$_loginTable.'</td>
		<td valign="top" style="width:260px;background-image:url(/webEdition/images/login/right.jpg);background-repeat:repeat-y;"><img src="/webEdition/images/login/top_r.jpg" width="260" height="10"/></td>

	</tr>
	<tr>
		<td  valign="bottom" style="width:260px;height:296px;background-color:#386AAB;"><img src="/webEdition/images/login/left	.jpg" width="260" height="296" /></td>

		<td valign="bottom" style="width:260px;height:296px;background-image:url(/webEdition/images/login/right.jpg);background-repeat:repeat-y;"><img src="/webEdition/images/login/bottom_r.jpg" width="260" height="296" /></td>

	</tr>
	<tr style="height:100px;">
		<td style="width:260px;"><img src="/webEdition/images/login/bottom_l2.jpg" width="260" height="100" /></td>
		<td style="background-image:url(/webEdition/images/login/bottom.jpg);height:100px;"><img src="/webEdition/images/login/bottom_l.jpg" width="184" height="100" /></td>
		<td style="width:260px;"><img src="/webEdition/images/login/bottom_r2.jpg" width="260" height="100" /></td>
	</tr>

</table>';



	//	PHP-Table
	$_contenttable = 432;
	$_layoutLeft   = 14;
	$_layoutLeft2   = 3;
	$_layoutMiddle = 406;
	$_layoutRight1 = 12;
	$_layoutRight2 = 10;
	$_layoutRight  = ($_layoutRight1 + $_layoutRight2);

	$_layouttable = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => 440), 4, 5);

	$_layouttable->setCol(0, 0, null, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/top_left2.gif", "width" => $_layoutLeft2, "height" => 21)));
	$_layouttable->setCol(0, 1, null, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/top_left.gif", "width" => $_layoutLeft, "height" => 21)));
	$_layouttable->setCol(0, 2, array("background" => IMAGE_DIR . "info/top.gif", "width" => $_layoutMiddle, "class" => "small", "align" => "right"), "&nbsp;");
	$_layouttable->setCol(0, 3, array("colspan" => 2, "width"   => $_layoutRight), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/top_right.gif", "width" => $_layoutRight, "height" => 21)));

	//	Here is table to log in
	$GLOBALS["loginpage"] = ($login == 2) ? false : true;

	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_templates/we_info.inc.php");

	$_layouttable->setCol(1, 0, array("background" => IMAGE_DIR . "info/left2.gif"), getPixel($_layoutLeft2, 1));
	$_layouttable->setCol(1, 1, array("colspan" => 3, "width" => $_contenttable), $_loginTable);
	$_layouttable->setCol(1, 4, array("width" => $_layoutRight2, "background" => IMAGE_DIR . "info/right.gif"), getPixel($_layoutRight2, 1));

	$_layouttable->setCol(2, 0, array("width" => $_layoutLeft2), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/bottom_left2.gif", "width" => $_layoutLeft2, "height" => 16)));
	$_layouttable->setCol(2, 1, null, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/bottom_left.gif", "width" => $_layoutLeft, "height" => 16)));
	$_layouttable->setCol(2, 2, array("background" => IMAGE_DIR . "info/bottom.gif"), getPixel(1, 16));
	$_layouttable->setCol(2, 3, array("colspan" => 2, "width" => $_layoutRight), we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "info/bottom_right.gif", "width" => $_layoutRight, "height" => 16)));

	$_layouttable->setCol(3, 0, null, getPixel($_layoutLeft2, 1));
	$_layouttable->setCol(3, 1, null, getPixel($_layoutLeft, 1));
	$_layouttable->setCol(3, 2, null, getPixel($_layoutMiddle, 1));
	$_layouttable->setCol(3, 3, null, getPixel($_layoutRight1, 1));
	$_layouttable->setCol(3, 4, null, getPixel($_layoutRight2, 1));

	/*************************************************************************
	 * GENERATE NEEDED JAVASCRIPTS
	 *************************************************************************/

	if ($login == 2) {
		$_body_javascript = "";

		//	Here the mode - SEEM or normal is saved in the SESSION!!!
		//	Perhaps this must move to another place later.
		//	Later we must check permissions as well!
		if ($_REQUEST["mode"] == "normal") {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/permissionhandler/permissionhandler.class.php");

			if (permissionhandler::isUserAllowedForAction("work_mode", "normal")) {
				$_SESSION["we_mode"] = $_REQUEST["mode"];
			} else {
				$_body_javascript .= we_message_reporting::getShowMessageCall($GLOBALS["l_we_SEEM"]["only_seem_mode_allowed"], WE_MESSAGE_ERROR);
				$_SESSION["we_mode"] = "seem";
			}
		} else {
			$_SESSION["we_mode"] = $_REQUEST["mode"];
		}

		$_body_javascript .= "function open_we() {";

		if (isset($_SESSION["prefs"]["weWidth"]) && $_SESSION["prefs"]["weWidth"] > 0) {
			$_body_javascript .= "var aw=" . $_SESSION["prefs"]["weWidth"] . ";\n";
		} else {
			$_body_javascript .= "var aw=8000;\n";
		}

		if (isset($_SESSION["prefs"]["weHeight"]) && $_SESSION["prefs"]["weHeight"] > 0) {
			$_body_javascript .= "var ah=" . $_SESSION["prefs"]["weHeight"] . ";\n";
		} else {
			$_body_javascript .= "var ah=6000;\n";
		}

		$_body_javascript .= "win = new jsWindow('" . WEBEDITION_DIR . "webEdition.php?h='+ah+'&w='+aw+'&browser='+((document.all) ? 'ie' : 'nn'), '" . md5(uniqid(rand())) . "', -1, -1, aw, ah, true, true, true, true, '" . $l_alert["popupLoginError"] . "', '/webEdition/index.php'); }";
	} else if ($login == 1) {
		$DB_WE->query("INSERT INTO ".FAILED_LOGINS_TABLE." (Username, Password, IP, LoginDate) VALUES('" . $_POST["username"] . "', '*****', '" . $_SERVER["REMOTE_ADDR"] . "', '" . time() . "')");

		/*****************************************************************************
		 * CHECK FOR FAILED LOGIN ATTEMPTS
		 *****************************************************************************/

		$DB_WE->query("SELECT ID FROM ".FAILED_LOGINS_TABLE." WHERE IP='".mysql_real_escape_string($_SERVER["REMOTE_ADDR"])."' AND LoginDate > (".(time() - (60 * abs(LOGIN_FAILED_TIME))).")");

		if ($DB_WE->num_rows() >= LOGIN_FAILED_NR) {
			$_body_javascript =	we_message_reporting::getShowMessageCall(sprintf($l_alert["3timesLoginError"], LOGIN_FAILED_NR,LOGIN_FAILED_TIME), WE_MESSAGE_ERROR);
		}else{
			$_body_javascript =	we_message_reporting::getShowMessageCall($l_alert["login_failed"], WE_MESSAGE_ERROR);
		}
	} else if ($login == 3) {
		$_body_javascript =	we_message_reporting::getShowMessageCall($l_alert["login_failed_security"], WE_MESSAGE_ERROR) . "document.location = '/webEdition/index.php" . (($ignore_browser || (isset($_COOKIE["ignore_browser"]) && $_COOKIE["ignore_browser"] == "true")) ? "&ignore_browser=" . (isset($_COOKIE["ignore_browser"]) ? $_COOKIE["ignore_browser"] : ($ignore_browser ? "true" : "false")) : "") . "';";
		
	} else if ( $login == 4 ) {
		$_body_javascript =	we_message_reporting::getShowMessageCall($l_alert["login_denied_for_user"], WE_MESSAGE_ERROR);
	}

	$_layout = new we_htmlTable(array("width" => "100%", "height" => "100%", "style" => "width: 100%; height: 100%;"), 1, 1);

	$_layout->setCol(0, 0, array("align" => "center", "valign" => "middle"), we_htmlElement::htmlForm(array("action" => WEBEDITION_DIR . "index.php", "method" => "post", "name" => "loginForm"), $_hidden_values . $dialogtable));

	print we_htmlElement::htmlBody(array("bgcolor" => "#386AAB", "class" => "header", "onload" => (($login == 2) ? "open_we();" : "document.loginForm.username.focus();document.loginForm.username.select();")), $_layout->getHtmlCode() . ((isset($_body_javascript)) ? we_htmlElement::jsElement($_body_javascript) : "")) . "</html>";
}

?>