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

function we_stripslashes(&$arr)
{
	foreach ($arr as $n => $v) {
		if (is_array($v)) {
			we_stripslashes($arr[$n]);
		} else {
			$arr[$n] = stripslashes($v);
		}
	}
}

if ((get_magic_quotes_gpc() == 1)) {
	if (!empty($_REQUEST)) {
		foreach ($_REQUEST as $n => $v) {
			if (is_array($v)) {
				we_stripslashes($v);
				$_REQUEST[$n] = $v;
			} else {
				$_REQUEST[$n] = stripslashes($v);
			}
		}
	}
}

// bugfix for php bug id #37276
if (version_compare(phpversion(), '5.1.3', '=')) {
	if (isset($_REQUEST['we_cmd'])) {
		foreach ($_REQUEST['we_cmd'] as $key => $value) {
			if (is_array($value)) {
				$value = array_shift($value);
			}
			$_REQUEST['we_cmd'][$key] = $value;
		}
	}
}

define("WE_UA", "BIG_U");
define("LOAD_MAID_DB", 0);
define("LOAD_TEMP_DB", 1);
define("LOAD_REVERT_DB", 2);
define("LOAD_SCHEDULE_DB", 3);

define("WE_TREE_DEFAULT_WIDTH", 300);

// Activate the webEdition error handler
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler();

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_version.php");

define("WEBEDITION_DIR", "/webEdition/");
define("SITE_DIR", WEBEDITION_DIR . "site/");
define("IMAGE_DIR", WEBEDITION_DIR . "images/");
define("HTML_DIR", WEBEDITION_DIR . "html/");
define("JS_DIR", WEBEDITION_DIR . "js/");
define("TREE_IMAGE_DIR", IMAGE_DIR . "tree/");
define("ICON_DIR", TREE_IMAGE_DIR . "icons/");
define("EDIT_IMAGE_DIR", IMAGE_DIR . "edit/");
define("BACKUP_DIR", WEBEDITION_DIR . "we_backup/");
define("VERSION_DIR", WEBEDITION_DIR . "we/versions/");

define("BUTTONS_DIR", IMAGE_DIR . "button/");

define("WE_EDITPAGE_PROPERTIES", 0);
define("WE_EDITPAGE_CONTENT", 1);
define("WE_EDITPAGE_INFO", 2);
define("WE_EDITPAGE_PREVIEW", 3);
define("WE_EDITPAGE_WORKSPACE", 4);
define("WE_EDITPAGE_METAINFO", 5);
define("WE_EDITPAGE_FIELDS", 6);
define("WE_EDITPAGE_SEARCH", 7);
define("WE_EDITPAGE_SCHEDULER", 8);
define("WE_EDITPAGE_THUMBNAILS", 9);
define("WE_EDITPAGE_VALIDATION", 10);
define("WE_EDITPAGE_VARIANTS", 11);
define("WE_EDITPAGE_PREVIEW_TEMPLATE", 12);
define("WE_EDITPAGE_CFWORKSPACE", 13); // Bug Fix #6062
define("WE_EDITPAGE_WEBUSER", 14); // Bug Fix #6062
define("WE_EDITPAGE_IMAGEEDIT", 15);
define("WE_EDITPAGE_DOCLIST", 16);
define("WE_EDITPAGE_VERSIONS", 17);

define("FILE_ONLY", 0);
define("FOLDER_ONLY", 1);

define("WE_UB", "SER_MODULE");

$MNEMONIC_EDITPAGES = array(
	'0' => 'properties', '1' => 'edit', '2' => 'information', '3' => 'preview', '10' => 'validation'
);
if (isset($_pro_modules) && in_array("schedpro", $_pro_modules)) { //	schedpro only when installed
	$MNEMONIC_EDITPAGES['8'] = 'schedpro';
}
if (isset($_we_active_modules) && in_array('shop', $_we_active_modules)) {
	$MNEMONIC_EDITPAGES['11'] = 'variants';
}

eval('$GLOBALS[WE_UA . WE_UB]=' . WE_UA . WE_UB . ';');
	
// refresh pageExt array
$PAGE_EXT = array(
	".html", ".php"
);

define("SUB_DIR_NO", 0);
define("SUB_DIR_YEAR", 1);
define("SUB_DIR_YEAR_MONTH", 2);
define("SUB_DIR_YEAR_MONTH_DAY", 3);

// Initialize imageType array
$IMAGE_TYPE = array(
	"", "image/gif", "image/jpeg", "image/png"
);

// Refresh imageExt array
$IMAGE_EXT = array(
	"", ".gif", ".jpg", ".png"
);

// Initialize gdImageType arrays
$GDIMAGE_TYPE = array(
	".gif" => "gif", ".jpg" => "jpg", ".jpeg" => "jpg", ".png" => "png"
);

define("IMAGE_CONTENT_TYPES", "image/jpeg,image/pjpeg,image/gif,image/png,image/x-png");

define("CATEGORY_TABLE", TBL_PREFIX . "tblCategorys");
define("CLEAN_UP_TABLE", TBL_PREFIX . "tblCleanUp");
define("CONTENT_TABLE", TBL_PREFIX . "tblContent");
define("DOC_TYPES_TABLE", TBL_PREFIX . "tblDocTypes");
define("ERROR_LOG_TABLE", TBL_PREFIX . "tblErrorLog");
define("FAILED_LOGINS_TABLE", TBL_PREFIX . "tblFailedLogins");
define("FILE_TABLE", TBL_PREFIX . "tblFile");
define("INDEX_TABLE", TBL_PREFIX . "tblIndex");
define("LINK_TABLE", TBL_PREFIX . "tblLink");
define("PASSWD_TABLE", TBL_PREFIX . "tblPasswd");
define("PREFS_TABLE", TBL_PREFIX . "tblPrefs");
define("RECIPIENTS_TABLE", TBL_PREFIX . "tblRecipients");
define("TEMPLATES_TABLE", TBL_PREFIX . "tblTemplates");
define("TEMPORARY_DOC_TABLE", TBL_PREFIX . "tblTemporaryDoc");
define("UPDATE_LOG_TABLE", TBL_PREFIX . "tblUpdateLog");
define("THUMBNAILS_TABLE", TBL_PREFIX . "tblthumbnails");
define("VALIDATION_SERVICES_TABLE", TBL_PREFIX . "tblvalidationservices");
define("HISTORY_TABLE", TBL_PREFIX . "tblhistory");
define("FORMMAIL_LOG_TABLE", TBL_PREFIX . "tblformmaillog");
define("FORMMAIL_BLOCK_TABLE", TBL_PREFIX . "tblformmailblock");
define("METADATA_TABLE", TBL_PREFIX . "tblMetadata");
define("NOTEPAD_TABLE", TBL_PREFIX . "tblwidgetnotepad");
define("VERSIONS_TABLE", TBL_PREFIX . "tblversions");
define("VERSIONS_TABLE_LOG", TBL_PREFIX . "tblversionslog");

define("NAVIGATION_TABLE", TBL_PREFIX . "tblnavigation");
define("NAVIGATION_RULE_TABLE", TBL_PREFIX . "tblnavigationrules");

define("WE_FRAGMENT_DIR", $_SERVER["DOCUMENT_ROOT"] . "/webEdition/fragments"); // important noot to add a slash at the end!
define("WE_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/");
define("WE_MODULE_PATH", "/webEdition/we/include/we_modules/");

define("WE_TOOLS_DIR", $_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/");
define("WE_TOOLS_PATH", "/webEdition/apps/");

if (!defined("LOGIN_FAILED_TIME")) {
	define("LOGIN_FAILED_TIME", 2);
}

if (!defined("LOGIN_FAILED_NR")) {
	define("LOGIN_FAILED_NR", 3);
}

define(
		"WE_WYSIWYG_COMMANDS", 
		"formatblock,fontname,fontsize,applystyle,bold,italic,underline,subscript,superscript,strikethrough,removeformat,forecolor,backcolor,justifyleft,justifycenter,justifyright,justifyfull,insertunorderedlist,insertorderedlist,indent,outdent,createlink,unlink,anchor,insertimage,inserthorizontalrule,insertspecialchar,inserttable,edittable,editcell,insertcolumnright,insertcolumnleft,insertrowabove,insertrowbelow,deletecol,deleterow,increasecolspan,decreasecolspan,caption,removecaption,importrtf,fullscreen,cut,copy,paste,undo,redo,visibleborders,editsource,prop,justify,list,link,color,copypaste,table,insertbreak,acronym,lang,spellcheck");

/**
 * Fix the none existing $_SERVER['REQUEST_URI'] on IIS
 */
if (!isset($_SERVER['REQUEST_URI'])) {
	if (isset($_SERVER['HTTP_REQUEST_URI'])) {
		define("WE_SERVER_REQUEST_URI", $_SERVER['HTTP_REQUEST_URI']);
	
	} else {
		
		if (isset($_SERVER['SCRIPT_NAME'])) {
			$_SERVER['HTTP_REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
		
		} else {
			$_SERVER['HTTP_REQUEST_URI'] = $_SERVER['PHP_SELF'];
		
		}
		
		if (isset($_SERVER['QUERY_STRING'])) {
			$_SERVER['HTTP_REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
		
		}
		define("WE_SERVER_REQUEST_URI", $_SERVER['HTTP_REQUEST_URI']);
	
	}

} else {
	define("WE_SERVER_REQUEST_URI", $_SERVER['REQUEST_URI']);

}

define("WINDOW_SELECTOR_WIDTH", "900");
define("WINDOW_SELECTOR_HEIGHT", "685");
define("WINDOW_DIRSELECTOR_WIDTH", "900");
define("WINDOW_DIRSELECTOR_HEIGHT", "600");
define("WINDOW_DOCSELECTOR_WIDTH", "900");
define("WINDOW_DOCSELECTOR_HEIGHT", "685");
define("WINDOW_CATSELECTOR_WIDTH", "900");
define("WINDOW_CATSELECTOR_HEIGHT", "600");
define("WINDOW_DELSELECTOR_WIDTH", "900");
define("WINDOW_DELSELECTOR_HEIGHT", "600");

$GLOBALS['WE_LANGS'] = array(
	
		"de" => "Deutsch", 
		"en" => "English", 
		"nl" => "Dutch", 
		"fi" => "Finnish", 
		"ru" => "Russian", 
		"es" => "Spanish", 
		"pl" => "Polish", 
		"fr" => "French"
);
?>