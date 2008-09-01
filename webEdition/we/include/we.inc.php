<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                               |
// +----------------------------------------------------------------------+
//

// remove trailing slash
if (isset($_SERVER["DOCUMENT"."_ROOT"]) && substr($_SERVER["DOCUMENT"."_ROOT"],-1) == "/") {
	$_SERVER["DOCUMENT"."_ROOT"] = substr($_SERVER["DOCUMENT"."_ROOT"],0,-1);
}

// Set PHP flags
@$_memlimit = abs(ini_get("memory_limit"));
if ($_memlimit < 32) {
	@ini_set("memory_limit", "32M");
}
@ini_set("allow_url_fopen", "1");
@ini_set("file_uploads", "1");
@ini_set("session.use_trans_sid", "0");

// Activate the webEdition error handler
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");

//	Insert all config files for all modules.
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_installed_modules.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_active_integrated_modules.inc.php");

// use the following arrays:
// we_available_modules - modules and informations about integrated and none integrated modules
// we_installed_modules - all installed (none integrated) modules
// we_active_integrated_modules - all active integrated modules
// we_active_modules - all active modules integrated and none integrated
// merge we_installed_modules and we_active_integrated_modules to we_active_modules
$_we_active_modules = array_merge($_we_active_integrated_modules, $_we_installed_modules);

for ($i=0; $i<sizeof($_we_active_modules); $i++ ) {
	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/" . $_we_active_modules[$i] . "/we_conf_" . $_we_active_modules[$i] . ".inc.php")) {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/" . $_we_active_modules[$i] . "/we_conf_" . $_we_active_modules[$i] . ".inc.php");
	}
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_defines.inc.php");

if (!defined("NO_SESS")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_session.inc.php");
	include_once($_SERVER['DOCUMENT_ROOT']. '/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
	$_tooldefines = weToolLookup::getDefineInclude();
	if(!empty($_tooldefines)) {
		foreach ($_tooldefines as $_tooldefine) {
			@include_once($_tooldefine);
		}
	}

}

if (isset($_SESSION) && isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem") {
	define("MULTIEDITOR_AMOUNT", 1);
} else {
	define("MULTIEDITOR_AMOUNT", 16);
}

if (defined("WE_WEBUSER_LANGUAGE")) {
	$GLOBALS["WE_LANGUAGE"] = WE_WEBUSER_LANGUAGE;
} else if (isset($_SESSION["prefs"]["Language"]) && $_SESSION["prefs"]["Language"] != "") {
    if(is_dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$_SESSION["prefs"]["Language"])){
       $GLOBALS["WE_LANGUAGE"] = $_SESSION["prefs"]["Language"];
     } else {    //  bugfix #4229
       $GLOBALS["WE_LANGUAGE"] = WE_LANGUAGE;
        $_SESSION["prefs"]["Language"] = WE_LANGUAGE;
    }
} else {
	$GLOBALS["WE_LANGUAGE"] = WE_LANGUAGE;
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/define_styles.inc.php");

if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_perms.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_available_modules.inc.php");
	//	At last we set the charset, as determined from the choosen language
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/charset/charset.inc.php");
	define("WE_DEFAULT_TITLE",'webEdition (c) living-e AG');
	define("WE_DEFAULT_HEAD",'
		<title>'.WE_DEFAULT_TITLE.'</title>
		<meta http-equiv="expires" content="0">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="content-type" content="text/html; charset='.$_language["charset"].'">
		<script language="JavaScript" type="text/javascript" src="' . JS_DIR . '/we_showMessage.js"></script>
		<script language="JavaScript" type="text/javascript" src="' . JS_DIR . '/attachKeyListener.js"></script>
');

	if(	isset($_REQUEST["we_cmd"][0]) && (	//	header when not in preview mode of documents
		$_REQUEST["we_cmd"][0] == "edit_link"        ||
		$_REQUEST["we_cmd"][0] == "edit_linklist"    ||
		$_REQUEST["we_cmd"][0] == "show_newsletter"   ||
		$_REQUEST["we_cmd"][0] == "save_document"    ||
		$_REQUEST["we_cmd"][0] == "load_editor"      ||
		$_REQUEST["we_cmd"][0] == "reload_editpage"  && ($_SESSION["EditPageNr"] == WE_EDITPAGE_PREVIEW || $_SESSION["EditPageNr"] == WE_EDITPAGE_CONTENT || $_SESSION["EditPageNr"] == WE_EDITPAGE_PROPERTIES ) ||
		$_REQUEST["we_cmd"][0] == "switch_edit_page" && ($_REQUEST["we_cmd"][1] == WE_EDITPAGE_CONTENT || $_REQUEST["we_cmd"][1] == WE_EDITPAGE_PREVIEW || $_REQUEST["we_cmd"][1] == WE_EDITPAGE_PROPERTIES ) ||
		$_REQUEST["we_cmd"][0] == "load_editor" && isset($_REQUEST["we_transaction"]) && isset($_SESSION["we_data"][$_REQUEST["we_transaction"]]) && $_SESSION["we_data"][$_REQUEST["we_transaction"]][0]["Table"] == FILE_TABLE && $_SESSION["EditPageNr"] == WE_EDITPAGE_PREVIEW) ||
		isset($show_stylesheet) && $show_stylesheet
		){
		//	dont send charset, it is determined from document itself
	} else {
		header("Content-Type: text/html; charset=" . $_language["charset"]);
	}
}


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/parser.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_message_reporting/we_message_reporting.class.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/weModuleInfo.class.php");

?>