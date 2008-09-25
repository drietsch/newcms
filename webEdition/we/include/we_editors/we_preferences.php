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
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weConfParser.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/weModuleInfo.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/prefs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/languages.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/countries.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

$yuiSuggest =& weSuggest::getInstance();

// Check which group of settings to work with
if (!isset($_REQUEST["setting"]) || $_REQUEST["setting"] == "") {
	$_REQUEST["setting"] = "ui";
}

$save_javascript = "";
$editor_reloaded = false;
$email_saved = true;
$tabname = isset($_REQUEST["tabname"]) && $_REQUEST["tabname"]!="" ? $_REQUEST["tabname"] : "setting_ui";
/*****************************************************************************
 * VARIABLES
 *****************************************************************************/

// Create array for needed configuration variables
$global_config = array();

// Variables for SEEM
$global_config[] = array('define("WE_SEEM",', '// Enable seeMode' . "\n" . 'define("WE_SEEM", 1);');

// Variables for thumbnails
$global_config[] = array('define("WE_THUMBNAIL_DIRECTORY",', '// Directory in which to save thumbnails' . "\n" . 'define("WE_THUMBNAIL_DIRECTORY", "/__we_thumbs__");');

// Variables for error handling
$global_config[] = array('define("WE_ERROR_HANDLER",', '// Show errors that occur in webEdition' . "\n" . 'define("WE_ERROR_HANDLER", 0);');
$global_config[] = array('define("WE_ERROR_NOTICES",', '// Handle notices' . "\n" . 'define("WE_ERROR_NOTICES", 0);');
$global_config[] = array('define("WE_ERROR_WARNINGS",', '// Handle warnings' . "\n" . 'define("WE_ERROR_WARNINGS", 0);');
$global_config[] = array('define("WE_ERROR_ERRORS",', '// Handle errors' . "\n" . 'define("WE_ERROR_ERRORS", 0);');
$global_config[] = array('define("WE_ERROR_SHOW",', '// Show errors' . "\n" . 'define("WE_ERROR_SHOW", 0);');
$global_config[] = array('define("WE_ERROR_LOG",', '// Log errors' . "\n" . 'define("WE_ERROR_LOG", 0);');
$global_config[] = array('define("WE_ERROR_MAIL",', '// Mail errors' . "\n" . 'define("WE_ERROR_MAIL", 0);');
$global_config[] = array('define("WE_ERROR_MAIL_ADDRESS",', '// E-Mail address to which to mail errors' . "\n" . 'define("WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");');
$global_config[] = array('define("ERROR_DOCUMENT_NO_OBJECTFILE",', '// Document to open when trying to open non-existing object' . "\n" . 'define("ERROR_DOCUMENT_NO_OBJECTFILE", 0);');
$global_config[] = array('define("DISABLE_TEMPLATE_TAG_CHECK",', '// Disable the check for missing close tags in templates' . "\n" . 'define("DISABLE_TEMPLATE_TAG_CHECK", 0);');

// Backup variable
$global_config[] = array('define("BACKUP_STEPS",', '// Number of entries per batch' . "\n" . 'define("BACKUP_STEPS", 10);');
// inlineedit default value
$global_config[] = array('define("INLINEEDIT_DEFAULT",', '// Default setting for inlineedit attribute' . "\n" . 'define("INLINEEDIT_DEFAULT", true);');
$global_config[] = array('define("WE_PHP_DEFAULT",', '// Default setting for php attribute' . "\n" . 'define("WE_PHP_DEFAULT", false);');

// xhtml
$global_config[] = array('define("XHTML_DEFAULT",', '// Default setting for xml attribute' . "\n" . 'define("XHTML_DEFAULT", false);');
$global_config[] = array('define("XHTML_DEBUG",', '// Enable XHTML debug' . "\n" . 'define("XHTML_DEBUG", false);');
$global_config[] = array('define("XHTML_REMOVE_WRONG",', '// Remove wrong xhtml attributes from we:tags' . "\n" . 'define("XHTML_REMOVE_WRONG", false);');

$global_config[] = array('define("WE_MAX_UPLOAD_SIZE",', '// Maximal possible uploadsize' . "\n" . 'define("WE_MAX_UPLOAD_SIZE", "");');
$global_config[] = array('define("WE_DOCTYPE_WORKSPACE_BEHAVIOR",', '// Which Doctypes should be shown for which workspace 0=normal behaviour , 1=new behaviour' . "\n" . 'define("WE_DOCTYPE_WORKSPACE_BEHAVIOR", 0);');

// accessibility
$global_config[] = array('define("SHOWINPUTS_DEFAULT",', '// Default setting for showinputs attribute' . "\n" . 'define("SHOWINPUTS_DEFAULT", true);');
$global_config[] = array('define("WE_NEW_FOLDER_MOD",', '// File permissions when creating a new directory' . "\n" . 'define("WE_NEW_FOLDER_MOD", "755");');

// pageLogger Dir
$global_config[] = array('define("WE_TRACKER_DIR",', '// Directory in which pageLogger is installed' . "\n" . 'define("WE_TRACKER_DIR", "");');

// econda dir
$global_config[] = array('define("WE_ECONDA_STAT",', '// use econda status' . "\n" . 'define("WE_ECONDA_STAT", 0);');
$global_config[] = array('define("WE_ECONDA_PATH",', '// econda js path' . "\n" . 'define("WE_ECONDA_PATH", "");');
$global_config[] = array('define("WE_ECONDA_ID",', '// econda js id' . "\n" . 'define("WE_ECONDA_ID", "");');

$global_config[] = array('define("SAFARI_WYSIWYG",', '// Flag if beta wysiwyg for safari should be used' . "\n" . 'define("SAFARI_WYSIWYG", false);');

//formmail stuff
$global_config[] = array('define("FORMMAIL_CONFIRM",', '// Flag if formmail confirm function should be work' . "\n" . 'define("FORMMAIL_CONFIRM", true);');
$global_config[] = array('define("FORMMAIL_VIAWEDOC",', '// Flag if formmail should be send only via a webEdition document' . "\n" . 'define("FORMMAIL_VIAWEDOC", false);');
$global_config[] = array('define("FORMMAIL_LOG",', '// Flag if formmail calls should be logged' . "\n" . 'define("FORMMAIL_LOG", false);');
$global_config[] = array('define("FORMMAIL_EMPTYLOG",', '// Time how long formmail calls should be logged' . "\n" . 'define("FORMMAIL_EMPTYLOG", 604800);');
$global_config[] = array('define("FORMMAIL_BLOCK",', '// Flag if formmail calls should be blocked after a time' . "\n" . 'define("FORMMAIL_BLOCK", false);');
$global_config[] = array('define("FORMMAIL_SPAN",', '// Time span in seconds' . "\n" . 'define("FORMMAIL_SPAN", 300);');
$global_config[] = array('define("FORMMAIL_TRIALS",', '// Num of trials sending formmail with same ip address in span' . "\n" . 'define("FORMMAIL_TRIALS", 3);');
$global_config[] = array('define("FORMMAIL_BLOCKTIME",', '// Time to block ip' . "\n" . 'define("FORMMAIL_BLOCKTIME", 86400);');

// sidebar stuff
$global_config[] = array('define("SIDEBAR_DISABLED",', '// Sidebar is disabled' . "\n" . 'define("SIDEBAR_DISABLED", 0);');
$global_config[] = array('define("SIDEBAR_SHOW_ON_STARTUP",', '// Show Sidebar on startup' . "\n" . 'define("SIDEBAR_SHOW_ON_STARTUP", 1);');
$global_config[] = array('define("SIDEBAR_DEFAULT_DOCUMENT",', '// Default document id of the sidebar' . "\n" . 'define("SIDEBAR_DEFAULT_DOCUMENT", 0);');
$global_config[] = array('define("SIDEBAR_DEFAULT_WIDTH",', '// Default width of the sidebar' . "\n" . 'define("SIDEBAR_DEFAULT_WIDTH", 300);');

// extension stuff
$global_config[] = array('define("DEFAULT_STATIC_EXT",', '// Default static extension' . "\n" . 'define("DEFAULT_STATIC_EXT", ".html");');
$global_config[] = array('define("DEFAULT_DYNAMIC_EXT",', '// Default dynamic extension' . "\n" . 'define("DEFAULT_DYNAMIC_EXT", ".php");');
$global_config[] = array('define("DEFAULT_HTML_EXT",', '// Default html extension' . "\n" . 'define("DEFAULT_HTML_EXT", ".html");');

/*****************************************************************************
 * FUNCTIONS
 *****************************************************************************/

/**
 * This function returns the HTML code of a dialog.
 *
 * @param          string                                  $name
 * @param          string                                  $title
 * @param          array                                   $content
 * @param          int                                     $expand             (optional)
 * @param          string                                  $show_text          (optional)
 * @param          string                                  $hide_text          (optional)
 * @param          bool                                    $cookie             (optional)
 * @param          string                                  $JS                 (optional)
 *
 * @return         string
 */

function create_dialog($name, $title, $content, $expand = -1, $show_text = "", $hide_text = "", $cookie = false, $JS = "") {
	$_output = "";

	// Check, if we need to write some JavaScripts
	if ($JS != "") {
		$_output .= $JS;
	}

	if ($expand != -1) {
		$_output .= we_multiIconBox::getJS();
	}

	// Return HTML code of dialog
	return $_output . we_multiIconBox::getHTML($name, "100%", $content, 30, "", $expand, $show_text, $hide_text, $cookie != false ? ($cookie == "down") : $cookie);
}


function getColorInput($name,$value,$disabled=false, $width=20,$height=20) {
	return hidden($name,$value).'<table cellpadding="0" cellspacing="0" style="border:1px solid gray;margin:2px 0;"><tr><td'.($disabled ? ' class="disabled"' : '').' id="color_'.$name.'" '.($value ? (' style="background-color:'.$value.';"') : '').'><a style="cursor:'.($disabled ? "default" : "pointer").';" href="javascript:if(document.getElementById(&quot;color_'.$name.'&quot;).getAttribute(&quot;class&quot;)!=&quot;disabled&quot;) {we_cmd(\'openColorChooser\',\''.$name.'\',document.we_form.elements[\''.$name.'\'].value,&quot;opener.setColorField(\''.$name.'\');&quot;);}">'.getPixel($width,$height).'</a></td></tr></table>';
}

/**
 * This functions return either the saved option or the changed one.
 *
 * @param          string                                  $settingvalue
 *
 * @see            return_value()
 *
 * @return         unknown
 */

function get_value($settingvalue) {
	switch ($settingvalue) {
		/*********************************************************************
		 * WINDOW DIMENSIONS
		 *********************************************************************/

		case "ui_language":
			return $_SESSION["prefs"]["Language"];
			break;

		case "ui_seem_start_file":
			return $_SESSION["prefs"]["seem_start_file"];
			break;

		case "ui_seem_start_type":
			if (($_SESSION["prefs"]["seem_start_type"] == "document" || $_SESSION["prefs"]["seem_start_type"] == "object") && $_SESSION["prefs"]["seem_start_file"] == 0) {
				return "cockpit";
			} else {
				return $_SESSION["prefs"]["seem_start_type"];
			}
			break;

		case "ui_disable_seem":
			return defined("WE_SEEM") ? (WE_SEEM == 0 ? true : false) : false;
			break;

		case "ui_size_opt":
			return $_SESSION["prefs"]["sizeOpt"];
			break;

		case "ui_we_width":
			return $_SESSION["prefs"]["weWidth"];
			break;

		case "ui_we_height":
			return $_SESSION["prefs"]["weHeight"];
			break;

		case "ui_sidebar_disable":
            return defined("SIDEBAR_DISABLED") ? SIDEBAR_DISABLED : 0;
            break;

		case "ui_sidebar_show_on_startup":
            return defined("SIDEBAR_SHOW_ON_STARTUP") ? SIDEBAR_SHOW_ON_STARTUP : 1;
            break;

		case "ui_sidebar_file":
            return defined("SIDEBAR_DEFAULT_DOCUMENT") ? SIDEBAR_DEFAULT_DOCUMENT : 0;
            break;

		case "ui_sidebar_width":
            return defined("SIDEBAR_DEFAULT_WIDTH") ? SIDEBAR_DEFAULT_WIDTH : 300;
            break;

		/*********************************************************************
		 * FILE EXTENSIONS
		 *********************************************************************/

		case "extension_static":
			return (defined("DEFAULT_STATIC_EXT") ? DEFAULT_STATIC_EXT : '.html');
			break;

		case "extension_dynamic":
			return (defined("DEFAULT_DYNAMIC_EXT") ? DEFAULT_DYNAMIC_EXT : '.php');
			break;

		case "extension_html":
			return (defined("DEFAULT_HTML_EXT") ? DEFAULT_HTML_EXT : '.html');
			break;

		/*********************************************************************
		 * CACHING
		 *********************************************************************/

		case "cache_type":
			return defined("WE_CACHE_TYPE") ? WE_CACHE_TYPE : "none";
			break;

		case "cache_lifetime":
			return defined("WE_CACHE_LIFETIME") ? WE_CACHE_LIFETIME : 0;
			break;

		/*********************************************************************
		 * CACHING
		 *********************************************************************/

		case "locale_locales":
			we_loadLanguageConfig();
			return $GLOBALS['weFrontendLanguages'];
			break;

		case "locale_default":
			we_loadLanguageConfig();
			return $GLOBALS['weDefaultFrontendLanguage'];
			break;

		/*********************************************************************
		 * COCKPIT
		 *********************************************************************/

		case "cockpit_amount_columns":
			return $_SESSION["prefs"]["cockpit_amount_columns"];
			break;

		/*********************************************************************
		 * TEMPLATE EDITOR
		 *********************************************************************/

		case "editor_font_name":
			return $_SESSION["prefs"]["editorFontname"];
			break;

		case "editor_font_size":
			return $_SESSION["prefs"]["editorFontsize"];
			break;
		
		case "editor_font_color":
			return $_SESSION["prefs"]["editorFontcolor"];
			break;

        case "editor_we_tag_font_color":
			return $_SESSION["prefs"]["editorWeTagFontcolor"];
			break;

        case "editor_we_attribute_font_color":
			return $_SESSION["prefs"]["editorWeAttributeFontcolor"];
			break;

        case "editor_html_tag_font_color":
			return $_SESSION["prefs"]["editorHTMLTagFontcolor"];
			break;

        case "editor_html_attribute_font_color":
			return $_SESSION["prefs"]["editorHTMLAttributeFontcolor"];
			break;

        case "editor_pi_tag_font_color":
			return $_SESSION["prefs"]["editorPiTagFontcolor"];
			break;

        case "editor_comment_font_color":
			return $_SESSION["prefs"]["editorCommentFontcolor"];
			break;



		/*********************************************************************
		 * PROXY SERVER
		 *********************************************************************/

		case "proxy_proxy":
			// Check for settings file
			if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php")) {
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php");
			}

			return defined("WE_PROXYHOST");
			break;

		case "proxy_host":
			return defined("WE_PROXYHOST") ? WE_PROXYHOST : "";
			break;

		case "proxy_port":
			return defined("WE_PROXYPORT") ? WE_PROXYPORT : "";
			break;

		case "proxy_user":
			return defined("WE_PROXYUSER") ? WE_PROXYUSER : "";
			break;

		case "proxy_password":
			return defined("WE_PROXYPASSWORD") ? WE_PROXYPASSWORD : "";
			break;

		/*********************************************************************
		 * ADVANCED
		 *********************************************************************/


		case "auth_auth":
			return (defined("HTTP_USERNAME") && defined("HTTP_PASSWORD"));
			break;

		case "auth_user":
			return defined("HTTP_USERNAME") ? HTTP_USERNAME : "";
			break;

		case "auth_password":
			return defined("HTTP_PASSWORD") ? HTTP_PASSWORD : "";
			break;

		/*********************************************************************
		 * ERROR HANDLING
		 *********************************************************************/

		case "we_error_handler":
			return defined("WE_ERROR_HANDLER") ? WE_ERROR_HANDLER : false;
			break;

		case "error_handling_notices":
			return defined("WE_ERROR_NOTICES") ? WE_ERROR_NOTICES : false;
			break;

		case "error_handling_warnings":
			return defined("WE_ERROR_WARNINGS") ? WE_ERROR_WARNINGS : true;
			break;

		case "error_handling_errors":
			return defined("WE_ERROR_ERRORS") ? WE_ERROR_ERRORS : true;
			break;

		case "error_display_errors":
			return defined("WE_ERROR_SHOW") ? WE_ERROR_SHOW : true;
			break;

		case "error_log_errors":
			return defined("WE_ERROR_LOG") ? WE_ERROR_LOG : true;
			break;

		case "error_mail_errors":
			return defined("WE_ERROR_MAIL") ? WE_ERROR_MAIL : false;
			break;

		case "error_mail_address":
			return defined("WE_ERROR_MAIL_ADDRESS") ? WE_ERROR_MAIL_ADDRESS : "";
			break;

		case "error_document_no_objectfile":
			return defined("ERROR_DOCUMENT_NO_OBJECTFILE") ? ERROR_DOCUMENT_NO_OBJECTFILE : 0;
			break;

		case "disable_template_tag_check":
			return defined("DISABLE_TEMPLATE_TAG_CHECK") ? DISABLE_TEMPLATE_TAG_CHECK : 0;
			break;

		case "error_debug_normal":
			return $_SESSION["prefs"]["debug_normal"];
			break;

		case "error_debug_seem":
			return $_SESSION["prefs"]["debug_seem"];
			break;

		/*********************************************************************
		 * MESSAGE SETTINGS
		 *********************************************************************/
		case 'message_reporting':
			return (isset($_SESSION["prefs"]["message_reporting"]) && $_SESSION["prefs"]["message_reporting"]) ? $_SESSION["prefs"]["message_reporting"] : (WE_MESSAGE_ERROR + WE_MESSAGE_WARNING + WE_MESSAGE_NOTICE);
			break;

		/*********************************************************************
		 * BACKUP
		 *********************************************************************/

		case "backup_steps":
			return defined("BACKUP_STEPS") ? BACKUP_STEPS : 10;
			break;

		/*********************************************************************
		 * THUMBNAILS
		 *********************************************************************/

		case "thumbnail_dir":
			return (defined("WE_THUMBNAIL_DIRECTORY")  && WE_THUMBNAIL_DIRECTORY) ? WE_THUMBNAIL_DIRECTORY : '/__we_thumbs__';
			break;
		/*********************************************************************
		 * INLINEEDIT
		 *********************************************************************/

		case "inlineedit_default":
			return defined("INLINEEDIT_DEFAULT") ? INLINEEDIT_DEFAULT : true;
			break;

		/*********************************************************************
		 * PHP ON OFF
		 *********************************************************************/

		case "we_php_default":
			return defined("WE_PHP_DEFAULT") ? WE_PHP_DEFAULT : false;
			break;

		/*********************************************************************
		 * SAFARI WYSIWYG
		 *********************************************************************/

		case "safari_wysiwyg":
			return defined("SAFARI_WYSIWYG") ? SAFARI_WYSIWYG : true;
			break;

		/*********************************************************************
		 * SHOWINPUTS
		 *********************************************************************/

		case "showinputs_default":
			return defined("SHOWINPUTS_DEFAULT") ? SHOWINPUTS_DEFAULT : true;
			break;

		/*********************************************************************
		 * SHOWINPUTS
		 *********************************************************************/

		case "showinputs_default":
			return defined("SHOWINPUTS_DEFAULT") ? SHOWINPUTS_DEFAULT : true;
			break;

		/*********************************************************************
		 * WE_MAX_UPLOAD_SIZE
		 *********************************************************************/

		case "we_max_upload_size":
			return defined("WE_MAX_UPLOAD_SIZE") ? WE_MAX_UPLOAD_SIZE : "";
			break;

		/*********************************************************************
		 * WE_NEW_FOLDER_MOD
		 *********************************************************************/

		case "we_new_folder_mod":
			return defined("WE_NEW_FOLDER_MOD") ? WE_NEW_FOLDER_MOD : "755";
			break;

		/*********************************************************************
		 * WE_DOCTYPE_WORKSPACE_BEHAVIOUR
		 *********************************************************************/

		case "we_doctype_workspace_behavior":
			return defined("WE_DOCTYPE_WORKSPACE_BEHAVIOR") ? WE_DOCTYPE_WORKSPACE_BEHAVIOR : 0;
			break;

		/*********************************************************************
		 * TREE
		 *********************************************************************/

		case "default_tree_count":
			return $_SESSION["prefs"]["default_tree_count"];
			break;

		/*********************************************************************
    	 * Validation
 	     *********************************************************************/
		case "xhtml_default":
            return defined("XHTML_DEFAULT") ? XHTML_DEFAULT : false;
            break;

		case "xhtml_debug":
            return defined("XHTML_DEBUG") ? XHTML_DEBUG : false;
            break;

		case "xhtml_remove_wrong":
            return defined("XHTML_REMOVE_WRONG") ? XHTML_REMOVE_WRONG : false;
            break;

		case "xhtml_show_wrong":
            return $_SESSION["prefs"]["xhtml_show_wrong"];
            break;

        case "xhtml_show_wrong_text":
            return $_SESSION["prefs"]["xhtml_show_wrong_text"];
            break;

        case "xhtml_show_wrong_js":
            return $_SESSION["prefs"]["xhtml_show_wrong_js"];
            break;

        case "xhtml_show_wrong_error_log":
            return $_SESSION["prefs"]["xhtml_show_wrong_error_log"];
            break;

		/*********************************************************************
		 * WESTAT
		 *********************************************************************/

		case "we_tracker_dir":
			return (defined("WE_TRACKER_DIR")  && WE_TRACKER_DIR) ? WE_TRACKER_DIR : '';
			break;

        case "we_econda_stat":
            return (defined("WE_ECONDA_STAT")  && WE_ECONDA_STAT) ? WE_ECONDA_STAT : 0;
            break;

        case "we_econda_path":
            return (defined("WE_ECONDA_PATH")  && WE_ECONDA_PATH) ? WE_ECONDA_PATH : '';
            break;

        case "we_econda_id":
            return (defined("WE_ECONDA_ID")  && WE_ECONDA_ID) ? WE_ECONDA_ID : '';
            break;

        case "use_jupload":
        	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/jupload/jupload.jar')) {
        		return 0;
        	}
			if(isset($_SESSION['prefs']['use_jupload'])) {
				return $_SESSION["prefs"]['use_jupload'];
			} else {
				return 1;
			}
			break;

		case "use_jeditor":
			if(isset($_SESSION['prefs']['use_jeditor'])) {
				return $_SESSION["prefs"]['use_jeditor'];
			} else {
				return 1;
			}
			break;

		case "specify_jeditor_colors":
			if(isset($_SESSION['prefs']['specify_jeditor_colors'])) {
				return $_SESSION["prefs"]['specify_jeditor_colors'];
			} else {
				return 1;
			}
			break;

		/**
		 * formmail stuff
		 */
		case "formmail_log":
            return defined("FORMMAIL_LOG") ? FORMMAIL_LOG : false;
            break;

		case "formmail_confirm":
            return defined("FORMMAIL_CONFIRM") ? FORMMAIL_CONFIRM : true;
            break;

		case "formmail_ViaWeDoc":
            return defined("FORMMAIL_VIAWEDOC") ? FORMMAIL_VIAWEDOC : false;
            break;

		case "formmail_block":
            return defined("FORMMAIL_BLOCK") ? FORMMAIL_BLOCK : false;
            break;

		case "formmail_span":
            return defined("FORMMAIL_SPAN") ? FORMMAIL_SPAN : 300;
            break;

		case "formmail_emptylog":
            return defined("FORMMAIL_EMPTYLOG") ? FORMMAIL_EMPTYLOG : 604800;
            break;

		case "formmail_trials":
            return defined("FORMMAIL_TRIALS") ? FORMMAIL_TRIALS : 3;
            break;

		case "formmail_blocktime":
            return defined("FORMMAIL_BLOCKTIME") ? FORMMAIL_BLOCKTIME : 86400;
            break;

		/*********************************************************************
		 * EMAIL
		 *********************************************************************/
		case "mailer_type":
			return defined('WE_MAILER') ? WE_MAILER : 'php';
			break;
		case "smtp_server":
			return defined('SMTP_SERVER') ? SMTP_SERVER : 'localhost';
		break;
		case "smtp_port":
			return defined('SMTP_PORT') ? SMTP_PORT : 25;
		break;
		case "smtp_auth":
			return defined('SMTP_AUTH') ? SMTP_AUTH : 0;
		break;
		case "smtp_username":
			return defined('SMTP_USERNAME') ? SMTP_USERNAME : '';
		break;
		case "smtp_password":
			return defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '';
		break;
		case "smtp_halo":
			return defined('SMTP_HALO') ? SMTP_HALO : '';
		break;
		case "smtp_timeout":
			return defined('SMTP_TIMEOUT') ? SMTP_TIMEOUT : '';
		break;
		default:
			return "";
			break;
			
		/*********************************************************************
		 * VERSIONING
		 *********************************************************************/

		case "version_image/*":
			return (defined("VERSIONING_IMAGE")) ? VERSIONING_IMAGE : 0;
			break;
		case "version_text/html":
			return (defined("VERSIONING_TEXT_HTML")) ? VERSIONING_TEXT_HTML : 0;
			break;
		case "version_text/webedition":
			return (defined("VERSIONING_TEXT_WEBEDITION")) ? VERSIONING_TEXT_WEBEDITION : 0;
			break;
		case "version_text/js":
			return (defined("VERSIONING_TEXT_JS")) ? VERSIONING_TEXT_JS : 0;
			break;
		case "version_text/css":
			return (defined("VERSIONING_TEXT_CSS")) ? VERSIONING_TEXT_CSS : 0;
			break;
		case "version_text/plain":
			return (defined("VERSIONING_TEXT_PLAIN")) ? VERSIONING_TEXT_PLAIN : 0;
			break;
		case "version_application/x-shockwave-flash":
			return (defined("VERSIONING_FLASH")) ? VERSIONING_FLASH : 0;
			break;
		case "version_video/quicktime":
			return (defined("VERSIONING_QUICKTIME")) ? VERSIONING_QUICKTIME : 0;
			break;
		case "version_application/*":
			return (defined("VERSIONING_SONSTIGE")) ? VERSIONING_SONSTIGE : 0;
			break;
		case "version_text/xml":
			return (defined("VERSIONING_TEXT_XML")) ? VERSIONING_TEXT_XML : 0;
			break;
		case "version_objectFile":
			return (defined("VERSIONING_OBJECT")) ? VERSIONING_OBJECT : 0;
			break;
		case "versions_time_days":
			return (defined("VERSIONS_TIME_DAYS")) ? VERSIONS_TIME_DAYS : -1;
			break;
		case "versions_time_weeks":
			return (defined("VERSIONS_TIME_WEEKS")) ? VERSIONS_TIME_WEEKS : -1;
			break;
		case "versions_time_years":
			return (defined("VERSIONS_TIME_YEARS")) ? VERSIONS_TIME_YEARS : -1;
			break;
		case "versions_anzahl":
			return (defined("VERSIONS_ANZAHL")) ? VERSIONS_ANZAHL : "";
			break;
		case "versions_create":
			return (defined("VERSIONS_CREATE")) ? VERSIONS_CREATE : 0;
			break;
	}
}

/**
 * This functions saves an option in the current session.
 *
 * @param          string                                  $settingvalue
 * @param          string                                  $settingname
 *
 * @see            save_all_values
 * @see            weConfParser::changeSourceCode()
 *
 * @return         bool
 */

function remember_value($settingvalue, $settingname) {
	global $save_javascript, $editor_reloaded, $email_saved, $DB_WE;
	$_update_prefs = false;
	if (isset($settingvalue) && ($settingvalue !== null || $settingname=='$_REQUEST["we_tracker_dir"]' || $settingname=='$_REQUEST["we_econda_stat"]' || $settingname=='$_REQUEST["we_econda_path"]' ||  $settingname=='$_REQUEST["we_econda_id"]' || $settingname=='$_REQUEST["ui_sidebar_disable"]' || $settingname=='$_REQUEST["smtp_halo"]' || $settingname=='$_REQUEST["smtp_timeout"]')) {
		switch ($settingname) {
			/*****************************************************************
			 * WINDOW DIMENSIONS
			 *****************************************************************/

			case '$_REQUEST["Language"]':
				$_SESSION["prefs"]["Language"] = $settingvalue;

				if ($settingvalue != $GLOBALS["WE_LANGUAGE"]) {
					$save_javascript .= "

						// reload current document => reload all open Editors on demand
						var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
						for (frameId in _usedEditors) {

							if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
								_usedEditors[frameId].setEditorReloadAllNeeded(true);
								_usedEditors[frameId].setEditorIsActive(true);

							} else {
								_usedEditors[frameId].setEditorReloadAllNeeded(true);
							}
						}
						_multiEditorreload = true;


						if (parent.opener.top.rframe.bframe.bm_vtabs) {
							parent.opener.top.rframe.bframe.bm_vtabs.location.reload();
						}
						
						if (parent.opener.top.rframe.bframe.infoFrame) {
							parent.opener.top.rframe.bframe.infoFrame.location.reload();
						}

						if(top.opener.top.weSidebar && top.opener.top.weSidebar.reloadHeader) {
					
							top.opener.top.weSidebar.reloadHeader();
							top.opener.top.weSidebar.reload();
							top.opener.top.weSidebar.reloadFooter();

						}

						if (parent.opener.top.header) {
							parent.opener.top.header.location.reload();
						}

						if (parent.opener.top.reload_weJsStrings) {
							parent.opener.top.reload_weJsStrings(\"$settingvalue\");
						}
					";
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["seem_start_file"]':
				$_SESSION["prefs"]["seem_start_file"] = $settingvalue;

				$_update_prefs = true;
				break;

			case '$_REQUEST["seem_start_type"]':
				$_SESSION["prefs"]["seem_start_type"] = $settingvalue;

				$_update_prefs = true;
				break;

			case '$_REQUEST["disable_seem"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				if ($settingvalue == 0 && WE_SEEM == 0) {
					$_file = weConfParser::changeSourceCode("define", $_file, "WE_SEEM", 1);
				} else if ($settingvalue == 1 && WE_SEEM == 1) {
					$_file = weConfParser::changeSourceCode("define", $_file, "WE_SEEM", 0);
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["sizeOpt"]':
				if ($settingvalue == 0) {
					$_SESSION["prefs"]["weWidth"] = 0;
					$_SESSION["prefs"]["weHeight"] = 0;
					$_SESSION["prefs"]["sizeOpt"] = 0;
				} else if (($settingvalue == 1) && (isset($_REQUEST["weWidth"]) && is_numeric($_REQUEST["weWidth"])) && (isset($_REQUEST["weHeight"]) && is_numeric($_REQUEST["weHeight"]))) {
					$_SESSION["prefs"]["sizeOpt"] = 1;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["weWidth"]':
				if ($_SESSION["prefs"]["sizeOpt"] == 1) {
					$_generate_java_script = false;

					if ($_SESSION["prefs"]["weWidth"] != $settingvalue) {
						$_generate_java_script = true;
					}

					$_SESSION["prefs"]["weWidth"] = $settingvalue;

					if ($_generate_java_script) {
						$save_javascript .= "
							parent.opener.top.resizeTo(" . $settingvalue . ", " . $_REQUEST["weHeight"] . ");
							parent.opener.top.moveTo((screen.width / 2) - " . ($settingvalue / 2) . ", (screen.height / 2) - " . ($_REQUEST["weHeight"] / 2) . ");
						";
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["weHeight"]':
				if ($_SESSION["prefs"]["sizeOpt"] == 1) {
					$_SESSION["prefs"]["weHeight"] = $settingvalue;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["ui_sidebar_disable"]':
				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (SIDEBAR_DISABLED == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "SIDEBAR_DISABLED", 0);
					}
				} else if ($settingvalue == 1) {
					if (SIDEBAR_DISABLED == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "SIDEBAR_DISABLED", 1);
					}
				}

				$_sidebar_show_on_startup = ((isset($_REQUEST["ui_sidebar_show_on_startup"]) && $_REQUEST["ui_sidebar_show_on_startup"] != null) ? $_REQUEST["ui_sidebar_show_on_startup"] : 0);
				if (SIDEBAR_SHOW_ON_STARTUP != $_sidebar_show_on_startup) {
					$_file = weConfParser::changeSourceCode("define", $_file, "SIDEBAR_SHOW_ON_STARTUP", $_sidebar_show_on_startup);
				}

				$_sidebar_document = ((isset($_REQUEST["ui_sidebar_file"]) && $_REQUEST["ui_sidebar_file"] != null) ? $_REQUEST["ui_sidebar_file"] : 0);
				if (SIDEBAR_DEFAULT_DOCUMENT != $_sidebar_document) {
					$_file = weConfParser::changeSourceCode("define", $_file, "SIDEBAR_DEFAULT_DOCUMENT", $_sidebar_document);
				}

				$_sidebar_width = ((isset($_REQUEST["ui_sidebar_width"]) && $_REQUEST["ui_sidebar_width"] != null) ? $_REQUEST["ui_sidebar_width"] : 0);
				if (SIDEBAR_DEFAULT_WIDTH != $_sidebar_width) {
					$_file = weConfParser::changeSourceCode("define", $_file, "SIDEBAR_DEFAULT_WIDTH", $_sidebar_width);
				}

				$_update_prefs = true;
				break;

			/*****************************************************************
			 * FILE EXTENSIONS
			 *****************************************************************/

			case '$_REQUEST["DefaultStaticExt"]':
				if (DEFAULT_STATIC_EXT != $settingvalue) {
					$_file = &$GLOBALS['config_files']['conf_global']['content'];
					$_file = weConfParser::changeSourceCode("define", $_file, "DEFAULT_STATIC_EXT", $settingvalue);
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["DefaultDynamicExt"]':
				if (DEFAULT_DYNAMIC_EXT != $settingvalue) {
					$_file = &$GLOBALS['config_files']['conf_global']['content'];
					$_file = weConfParser::changeSourceCode("define", $_file, "DEFAULT_DYNAMIC_EXT", $settingvalue);
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["DefaultHTMLExt"]':
				if (DEFAULT_HTML_EXT != $settingvalue) {
					$_file = &$GLOBALS['config_files']['conf_global']['content'];
					$_file = weConfParser::changeSourceCode("define", $_file, "DEFAULT_HTML_EXT", $settingvalue);
				}

				$_update_prefs = true;
				break;

			/*****************************************************************
			 * TEMPLATE EDITOR
			 *****************************************************************/

			case '$_REQUEST["editorFont"]':
				if ($settingvalue == 0) {
					$_SESSION["prefs"]["editorFontname"] = "none";
					$_SESSION["prefs"]["editorFontsize"] = -1;
					$_SESSION["prefs"]["editorFont"] = 0;
				} else if (($settingvalue == 1) && isset($_REQUEST["editorFontname"]) && isset($_REQUEST["editorFontsize"])) {
					$_SESSION["prefs"]["editorFont"] = 1;
				}

				if (!$editor_reloaded) {
					$editor_reloaded = true;

					// editor font has changed - mark all editors to reload!
					$save_javascript .= '
					if (!_multiEditorreload) {
						var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
							for (frameId in _usedEditors) {

								if ( (_usedEditors[frameId].getEditorEditorTable() == "' . TEMPLATES_TABLE . '" || _usedEditors[frameId].getEditorEditorTable() == "' . FILE_TABLE . '") &&
									_usedEditors[frameId].getEditorEditPageNr() == ' . WE_EDITPAGE_CONTENT . ' ) {

									if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
										_usedEditors[frameId].setEditorReloadNeeded(true);
										_usedEditors[frameId].setEditorIsActive(true);

									} else {
										_usedEditors[frameId].setEditorReloadNeeded(true);
									}
								}
							}
					}
					_multiEditorreload = true;
					';

				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["editorFontname"]':
				if ($_SESSION["prefs"]["editorFont"] == 1) {
					$_SESSION["prefs"]["editorFontname"] = $settingvalue;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["editorFontsize"]':
				if ($_SESSION["prefs"]["editorFont"] == 1) {
					$_SESSION["prefs"]["editorFontsize"] = $settingvalue;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["editorFontcolor"]':
				$_SESSION["prefs"]["editorFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorWeTagFontcolor"]':
				$_SESSION["prefs"]["editorWeTagFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorWeAttributeFontcolor"]':
				$_SESSION["prefs"]["editorWeAttributeFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorHTMLTagFontcolor"]':
				$_SESSION["prefs"]["editorHTMLTagFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorHTMLAttributeFontcolor"]':
				$_SESSION["prefs"]["editorHTMLAttributeFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorPiTagFontcolor"]':
				$_SESSION["prefs"]["editorPiTagFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["editorCommentFontcolor"]':
				$_SESSION["prefs"]["editorCommentFontcolor"] = $settingvalue;
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * FORMMAIL RECIPIENTS
			 *****************************************************************/

			case '$_REQUEST["formmail_values"]':
				if ((isset($_REQUEST["formmail_values"]) && $_REQUEST["formmail_values"] != "") || (isset($_REQUEST["formmail_deleted"]) && $_REQUEST["formmail_deleted"] != "")) {
					$_recipients = explode("<##>", $_REQUEST["formmail_values"]);

					if (sizeof($_recipients)) {
						foreach ($_recipients as $i => $_recipient) {
							$_single_recipient = explode("<#>", $_recipient);

							if (isset($_single_recipient[0]) && ($_single_recipient[0] == "#")) {
								if (isset($_single_recipient[1]) && $_single_recipient[1]) {
									$DB_WE->query("INSERT INTO " . RECIPIENTS_TABLE . " (Email) VALUES('" . $_single_recipient[1] . "')");
								}
							} else {
								if (isset($_single_recipient[1]) && isset($_single_recipient[0]) && $_single_recipient[1] && $_single_recipient[0]) {
									$DB_WE->query("UPDATE " . RECIPIENTS_TABLE . " SET Email='" . $_single_recipient[1] . "' WHERE ID=" . $_single_recipient[0]);
								}
							}
						}
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["formmail_deleted"]':

				if (isset($_REQUEST["formmail_deleted"]) && $_REQUEST["formmail_deleted"] != "") {

					$_formmail_deleted = explode(",", $_REQUEST["formmail_deleted"]);

					for ($i = 0; $i < sizeof($_formmail_deleted); $i++) {
						$DB_WE->query("DELETE FROM " . RECIPIENTS_TABLE . " WHERE ID=" . $_formmail_deleted[$i]);
					}
				}
				$_update_prefs = true;
				break;


			case '$_REQUEST["active_integrated_modules"]':

				$_activeIntegratedModulesFile = "";
				foreach ($_REQUEST["active_integrated_modules"] as $_module) {
					$_activeIntegratedModulesFile .= '
$_we_active_integrated_modules[] = "' . $_module . '";';

				}

				$_activeIntegratedModulesFile = '<?php
$_we_active_integrated_modules = array();
' . $_activeIntegratedModulesFile . '

?>';
				// save active integrated modules
				$GLOBALS['config_files']['active_integrated_modules']['content'] = $_activeIntegratedModulesFile;

			break;
			/*****************************************************************
			 * PROXY SERVER
			 *****************************************************************/

			case '$_REQUEST["useproxy"]':
				if ($settingvalue == 1) {
					// Create content of settings file
					$_proxy_file =
						'<?php
	define("WE_PROXYHOST", "' . ((isset($_REQUEST["proxyhost"]) && $_REQUEST["proxyhost"] != null) ? $_REQUEST["proxyhost"] : '') . '");
	define("WE_PROXYPORT", "' . ((isset($_REQUEST["proxyport"]) && $_REQUEST["proxyport"] != null) ? $_REQUEST["proxyport"] : '') . '");
	define("WE_PROXYUSER", "' . ((isset($_REQUEST["proxyuser"]) && $_REQUEST["proxyuser"] != null) ? $_REQUEST["proxyuser"] : '') . '");
	define("WE_PROXYPASSWORD", "' . ((isset($_REQUEST["proxypass"]) && $_REQUEST["proxypass"] != null) ? $_REQUEST["proxypass"] : '') . '");
?>';

					// Create/overwrite proxy settings file
					$GLOBALS['config_files']['proxysettings']['content'] = $_proxy_file;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["proxyhost"]':
			case '$_REQUEST["proxyport"]':
			case '$_REQUEST["proxyuser"]':
			case '$_REQUEST["proxypass"]':
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * ADVANCED
			 *****************************************************************/

			case '$_REQUEST["we_php_default"]':
				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_PHP_DEFAULT", $settingvalue);

				$_update_prefs = true;
				break;

			case '$_REQUEST["db_connect"]':

				$_file = &$GLOBALS['config_files']['conf']['content'];

				if ($settingvalue == 0) {
					if (DB_CONNECT == "pconnect") {
						$_file = weConfParser::changeSourceCode("define", $_file, 'DB_CONNECT', 'connect');
					}
				} else if ($settingvalue == 1) {
					if (DB_CONNECT == "connect") {
						$_file = weConfParser::changeSourceCode("define", $_file, 'DB_CONNECT', 'pconnect');
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["useauth"]':

				$_file = &$GLOBALS['config_files']['conf']['content'];

				if ($settingvalue == 1) {
				    // enable
				    if ( !(defined("HTTP_USERNAME")) || !(defined("HTTP_PASSWORD")) ) {
				    	$_file = str_replace("//define(\"HTTP_USERNAME\",", "define(\"HTTP_USERNAME\",", $_file);
    				    $_file = str_replace("//define(\"HTTP_PASSWORD\",", "define(\"HTTP_PASSWORD\",", $_file);
				    }

				    $un = defined("HTTP_USERNAME") ? HTTP_USERNAME : "";
				    $pw = defined("HTTP_PASSWORD") ? HTTP_PASSWORD : "";
				    if ($un != $_REQUEST["authuser"] || $pw != $_REQUEST["authpass"]) {

    					$_file = weConfParser::changeSourceCode("define", $_file, 'HTTP_USERNAME', ((isset($_REQUEST["authuser"]) && $_REQUEST["authuser"] != null) ? $_REQUEST["authuser"] : ''));
    					$_file = weConfParser::changeSourceCode("define", $_file, 'HTTP_PASSWORD', ((isset($_REQUEST["authpass"]) && $_REQUEST["authpass"] != null) ? $_REQUEST["authpass"] : ''));

				    }

				} else {
				    // disable
				    if (defined("HTTP_USERNAME") || defined("HTTP_PASSWORD")) {

				    	$_file = str_replace("define(\"HTTP_USERNAME\",", "//define(\"HTTP_USERNAME\",", $_file);
    				    $_file = str_replace("define(\"HTTP_PASSWORD\",", "//define(\"HTTP_PASSWORD\",", $_file);

				    }
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["authuser"]':
			case '$_REQUEST["authpass"]':
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * ERROR HANDLING
			 *****************************************************************/

			case '$_REQUEST["we_error_handler"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_HANDLER == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_HANDLER", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_HANDLER == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_HANDLER", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_handling_notices"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_NOTICES == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_NOTICES", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_NOTICES == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_NOTICES", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_handling_warnings"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_WARNINGS == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_WARNINGS", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_WARNINGS == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_WARNINGS", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_handling_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_ERRORS == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_ERRORS", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_ERRORS == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_ERRORS", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_display_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_SHOW == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_SHOW", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_SHOW == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_SHOW", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_log_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_LOG == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_LOG", 0);
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_LOG == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_LOG", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_mail_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (WE_ERROR_MAIL == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL", 0);
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");
					}
				} else if ($settingvalue == 1) {
					if (WE_ERROR_MAIL == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_mail_address"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($_REQUEST["error_mail_errors"] == 1) {
					if ($settingvalue != "") {
						if (we_check_email($settingvalue)) {
							if (WE_ERROR_MAIL_ADDRESS != $settingvalue) {
								$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", $settingvalue);
							}
						} else {
							$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");
							$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL", 0);

							$email_saved = false;
						}
					} else {
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");
						$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL", 0);

						$email_saved = false;
					}
				} else {
					$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");
				}

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_document_no_objectfile"]':

				if (!defined('ERROR_DOCUMENT_NO_OBJECTFILE') || ERROR_DOCUMENT_NO_OBJECTFILE != $settingvalue) {
					$_file = &$GLOBALS['config_files']['conf_global']['content'];
					$_file = weConfParser::changeSourceCode("define", $_file, "ERROR_DOCUMENT_NO_OBJECTFILE", $settingvalue);
					$_update_prefs = false;
				}
				break;

			case '$_REQUEST["disable_template_tag_check"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];

				if ($settingvalue == 0) {
					if (DISABLE_TEMPLATE_TAG_CHECK == 1) {
						$_file = weConfParser::changeSourceCode("define", $_file, "DISABLE_TEMPLATE_TAG_CHECK", 0);
					}
				} else if ($settingvalue == 1) {
					if (DISABLE_TEMPLATE_TAG_CHECK == 0) {
						$_file = weConfParser::changeSourceCode("define", $_file, "DISABLE_TEMPLATE_TAG_CHECK", 1);
					}
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["debug_normal"]':
				$_SESSION["prefs"]["debug_normal"] = $settingvalue;
				$_update_prefs = true;
				break;

			case '$_REQUEST["debug_seem"]':
				$_SESSION["prefs"]["debug_seem"] = $settingvalue;
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * BACKUP
			 *****************************************************************/

			case '$_REQUEST["backup_steps"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "BACKUP_STEPS", $settingvalue);

				$_update_prefs = false;
				break;
			/*****************************************************************
			 * INLINEEDIT
			 *****************************************************************/

			case '$_REQUEST["inlineedit_default"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "INLINEEDIT_DEFAULT", $settingvalue);

				$_update_prefs = false;
				break;

			/*****************************************************************
			 * SAFARI WYSIWYG
			 *****************************************************************/

			case '$_REQUEST["safari_wysiwyg"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "SAFARI_WYSIWYG", $settingvalue);

				$_update_prefs = false;
				break;

			/*****************************************************************
			 * SHOWINPUTS
			 *****************************************************************/

			case '$_REQUEST["showinputs_default"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "SHOWINPUTS_DEFAULT", $settingvalue);

				$_update_prefs = false;
				break;

			/*****************************************************************
			 * WE_MAX_UPLOAD_SIZE
			 *****************************************************************/

			case '$_REQUEST["we_max_upload_size"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_MAX_UPLOAD_SIZE", abs($settingvalue));

				$_update_prefs = false;
				break;

			/*****************************************************************
			 * WE_NEW_FOLDER_MOD
			 *****************************************************************/

			case '$_REQUEST["we_new_folder_mod"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_NEW_FOLDER_MOD", $settingvalue);

				$_update_prefs = false;
				break;
			/*****************************************************************
			 * WE_DOCTYPE_WORKSPACE_BEHAVIOR
			 *****************************************************************/

			case '$_REQUEST["we_doctype_workspace_behavior"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_DOCTYPE_WORKSPACE_BEHAVIOR", $settingvalue);

				$_update_prefs = false;
				break;



			/**
			 * formmail stuff
			 */
			case '$_REQUEST["formmail_confirm"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_CONFIRM", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["formmail_ViaWeDoc"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_VIAWEDOC", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["formmail_log"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_LOG", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["formmail_block"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_BLOCK", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["formmail_span"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_SPAN", $settingvalue);

				$_update_prefs = false;
				break;
			case '$_REQUEST["formmail_emptylog"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_EMPTYLOG", $settingvalue);

				$_update_prefs = false;
				break;
			case '$_REQUEST["formmail_blocktime"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_BLOCKTIME", $settingvalue);

				$_update_prefs = false;
				break;
			case '$_REQUEST["formmail_trials"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "FORMMAIL_TRIALS", $settingvalue);

				$_update_prefs = false;
				break;


			/*****************************************************************
			 * Validation
			 *****************************************************************/

			case '$_REQUEST["xhtml_default"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "XHTML_DEFAULT", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["xhtml_debug"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "XHTML_DEBUG", $settingvalue);

				$_update_prefs = false;
				break;

			case '$_REQUEST["xhtml_remove_wrong"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "XHTML_REMOVE_WRONG", $settingvalue);

				$_update_prefs = false;
				break;

            case '$_REQUEST["xhtml_show_wrong"]':
				$_SESSION["prefs"]["xhtml_show_wrong"] = $settingvalue;
				$_update_prefs = true;
				break;

            case '$_REQUEST["xhtml_show_wrong_text"]':
				$_SESSION["prefs"]["xhtml_show_wrong_text"] = $settingvalue;
				$_update_prefs = true;
				break;

            case '$_REQUEST["xhtml_show_wrong_js"]':
				$_SESSION["prefs"]["xhtml_show_wrong_js"] = $settingvalue;
				$_update_prefs = true;
				break;

            case '$_REQUEST["xhtml_show_wrong_error_log"]':
				$_SESSION["prefs"]["xhtml_show_wrong_error_log"] = $settingvalue;
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * message reporting
			 *****************************************************************/
            case '$_REQUEST["message_reporting"]':
            	$_SESSION["prefs"]["message_reporting"] = $settingvalue;
            	$_update_prefs = true;
            	break;

			/*****************************************************************
			 * THUMBNAILS
			 *****************************************************************/

			case '$_REQUEST["thumbnail_dir"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_THUMBNAIL_DIRECTORY", $settingvalue);

				$_update_prefs = false;
				break;
            /*****************************************************************
             * WESTAT
             *****************************************************************/

            case '$_REQUEST["we_tracker_dir"]':

                $save_javascript .= "

                        if (parent.opener.top.header) {
                            parent.opener.top.header.location.reload();
                        }
                        ";

                $_file = &$GLOBALS['config_files']['conf_global']['content'];
                $_file = weConfParser::changeSourceCode("define", $_file, "WE_TRACKER_DIR", $settingvalue);

                $_update_prefs = false;
                break;
            /*****************************************************************
             * ECONDA
             *****************************************************************/

            case '$_REQUEST["we_econda_stat"]':
                $_update_prefs = false;
                if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_ECONDA_STAT", $settingvalue,'status for econda')) {
                    $_update_prefs = true;
                }
                break;
                
            case '$_REQUEST["we_econda_path"]':
                $_update_prefs = false;
                if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_ECONDA_PATH", $settingvalue,'econda js path')) {
                    $_update_prefs = true;
                }
                break;
                
            case '$_REQUEST["we_econda_id"]':
                $_update_prefs = false;
                if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_ECONDA_ID", $settingvalue,'econda js id')) {
                    $_update_prefs = true;
                }
                break;
                
            /*****************************************************************
			 * TREE
			 *****************************************************************/

			case '$_REQUEST["default_tree_count"]':
				$_SESSION["prefs"]["default_tree_count"] = $settingvalue;
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * COCKPIT
			 *****************************************************************/

			case '$_REQUEST["cockpit_amount_columns"]':
				$_SESSION["prefs"]["cockpit_amount_columns"] = $settingvalue;
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * CACHING
			 *****************************************************************/

			case '$_REQUEST["cache_type"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_CACHE_TYPE", $settingvalue, 'Cache Type')) {
					$_update_prefs = true;
				}

				// Save cache settings for navi tool
				include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationSettingControl.class.php');
				weNavigationSettingControl::saveSettings(false);

				break;

			case '$_REQUEST["cache_lifetime"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_CACHE_LIFETIME", $settingvalue, 'Cache Life Time')) {
					$_update_prefs = true;
				}
				break;


			/*****************************************************************
			 * JUPLOAD
			 *****************************************************************/
			case '$_REQUEST["use_jupload"]':
				$_SESSION['prefs']['use_jupload'] = $settingvalue;
				$DB_WE->query('UPDATE ' . PREFS_TABLE . ' SET use_jupload="' . $settingvalue . '";');
				$_update_prefs = true;
				break;
			/*****************************************************************
			 * JUPLOAD
			 *****************************************************************/
			case '$_REQUEST["use_jeditor"]':
				$_SESSION["prefs"]["use_jeditor"] = $settingvalue;
				$_update_prefs = true;
				break;
				
			case '$_REQUEST["specify_jeditor_colors"]':
				$_SESSION["prefs"]["specify_jeditor_colors"] = $settingvalue;
				$_update_prefs = true;
				break;
				

			/*****************************************************************
			 * EMAIL
			 *****************************************************************/
			case '$_REQUEST["mailer_type"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_MAILER", $settingvalue,'mailer type; possible values are php and smtp')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_server"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_SERVER", $settingvalue,'SMTP server address')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_port"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_POST", $settingvalue,'SMTP server port')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_auth"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_AUTH", $settingvalue,'SMTP authentication')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_username"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_USERNAME", $settingvalue,'SMTP username')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_password"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_PASSWORD", $settingvalue,'SMTP password')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_halo"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_HALO", $settingvalue,'SMTP halo string')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["smtp_timeout"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "SMTP_TIMEOUT", $settingvalue,'SMTP timeout')) {
					$_update_prefs = true;
				}
				break;
			/*****************************************************************
			 * VERSIONING
			 *****************************************************************/
			case '$_REQUEST["version_image/*"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_IMAGE", $settingvalue,'Versioning status for ContentType image/* ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/html"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_HTML", $settingvalue,'Versioning status for ContentType text/html ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/webedition"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_WEBEDITION", $settingvalue,'Versioning status for ContentType text/webedition ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/js"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_JS", $settingvalue,'Versioning status for ContentType text/js ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/css"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_CSS", $settingvalue,'Versioning status for ContentType text/css ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/plain"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_PLAIN", $settingvalue,'Versioning status for ContentType text/plain ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_application/x-shockwave-flash"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_FLASH", $settingvalue,'Versioning status for ContentType application/x-shockwave-flash ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_video/quicktime"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_QUICKTIME", $settingvalue,'Versioning status for ContentType video/quicktime ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_application/*"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_SONSTIGE", $settingvalue,'Versioning status for ContentType application/* ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_text/xml"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_TEXT_XML", $settingvalue,'Versioning status for ContentType text/xml ')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["version_objectFile"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONING_OBJECT", $settingvalue,'Versioning status for ContentType objectFile ')) {
					$_update_prefs = true;
				}
				break;
								
			case '$_REQUEST["versions_time_days"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONS_TIME_DAYS", $settingvalue,'Versioning Number of Days')) {
					$_update_prefs = true;
				}
				break;
				
			case '$_REQUEST["versions_time_weeks"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONS_TIME_WEEKS", $settingvalue,'Versioning Number of Weeks')) {
					$_update_prefs = true;
				}
				break;
				
			case '$_REQUEST["versions_time_years"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONS_TIME_YEARS", $settingvalue,'Versioning Number of Years')) {
					$_update_prefs = true;
				}
				break;
				
			case '$_REQUEST["versions_anzahl"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONS_ANZAHL", $settingvalue,'Versioning Number of Versions')) {
					$_update_prefs = true;
				}
				break;
			case '$_REQUEST["versions_create"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "VERSIONS_CREATE", $settingvalue,'Versioning Save version only if publishing')) {
					$_update_prefs = true;
				}
				break;
			
			/*****************************************************************
			 * CANCEL OTHER REQUESTS
			 *****************************************************************/

			default:
				$_update_prefs = false;
				break;
		}
	} else {
		switch ($settingname) {

			/*****************************************************************
			 * CACHING
			 *****************************************************************/

			case '$_REQUEST["cache_type"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_CACHE_TYPE", 'none', 'Cache Type')) {
					$_update_prefs = true;
				}
				break;

			case '$_REQUEST["cache_lifetime"]':
				$_update_prefs = false;
				if(weConfParser::setGlobalPrefInContent($GLOBALS['config_files']['conf_global']['content'], "WE_CACHE_LIFETIME", 0, 'Cache Life Time')) {
					$_update_prefs = true;
				}
				break;

			/*****************************************************************
			 * COCKPIT
			 *****************************************************************/

			case '$_REQUEST["cockpit_amount_columns"]':
				$_SESSION["prefs"]["cockpit_amount_columns"] = '';
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * WINDOW DIMENSIONS
			 *****************************************************************/

			case '$_REQUEST["weWidth"]':
			case '$_REQUEST["weHeight"]':
				$_update_prefs = true;
				break;

			case '$_REQUEST["disable_seem"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_SEEM", 1);

				$_update_prefs = true;
				break;

			/*****************************************************************
			 * TEMPLATE EDITOR
			 *****************************************************************/
/*
			case '$_REQUEST["usePlugin"]':
				if (($BROWSER == "IE" || $_SESSION["MozillaActiveX"]) && $SYSTEM == "WIN") {
					$_SESSION["prefs"]["usePlugin"] = 0;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["autostartPlugin"]':
				if (($BROWSER == "IE" || $_SESSION["MozillaActiveX"]) && $SYSTEM == "WIN") {
					$_SESSION["prefs"]["autostartPlugin"] = 0;
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["promptPlugin"]':
				if (($BROWSER == "IE" || $_SESSION["MozillaActiveX"]) && $SYSTEM == "WIN") {
					$_SESSION["prefs"]["promptPlugin"] = 0;
				}

				$_update_prefs = true;
*/				break;

			case '$_REQUEST["editorFont"]':
				$_SESSION["prefs"]["editorFontname"] = "none";
				$_SESSION["prefs"]["editorFontsize"] = -1;
				$_SESSION["prefs"]["editorFont"] = 0;

				if (!$editor_reloaded) {
					$editor_reloaded = true;

					$save_javascript .= '
					if (!_multiEditorreload) {
						var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
							for (frameId in _usedEditors) {

								if ( (_usedEditors[frameId].getEditorEditorTable() == "' . TEMPLATES_TABLE . '" || _usedEditors[frameId].getEditorEditorTable() == "' . FILE_TABLE . '") &&
									_usedEditors[frameId].getEditorEditPageNr() == ' . WE_EDITPAGE_CONTENT . ' ) {

									if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
										_usedEditors[frameId].setEditorReloadNeeded(true);
										_usedEditors[frameId].setEditorIsActive(true);

									} else {
										_usedEditors[frameId].setEditorReloadNeeded(true);
									}
								}
							}
					}
					_multiEditorreload = true;
					';
				}

				$_update_prefs = true;
				break;

			case '$_REQUEST["editorWidth"]':
			case '$_REQUEST["editorHeight"]':
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * PROXY SERVER
			 *****************************************************************/

			case '$_REQUEST["useproxy"]':

				// Delete proxy settings file
				if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php")) {
					unlink($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php");
				}
				$GLOBALS['config_files']['proxysettings'] = array();
				unset($GLOBALS['config_files']['proxysettings']);

				$_update_prefs = true;
				break;

			case '$_REQUEST["proxyhost"]':
			case '$_REQUEST["proxyport"]':
			case '$_REQUEST["proxyuser"]':
			case '$_REQUEST["proxypass"]':
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * ADVANCED
			 *****************************************************************/

			case '$_REQUEST["useauth"]':

				$_file = &$GLOBALS['config_files']['conf']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, 'HTTP_USERNAME', 'myUsername', false);
				$_file = weConfParser::changeSourceCode("define", $_file, 'HTTP_PASSWORD', 'myPassword', false);

				$_update_prefs = true;
				break;

			case '$_REQUEST["authuser"]':
			case '$_REQUEST["authpass"]':
				$_update_prefs = true;
				break;

			/*****************************************************************
			 * ERROR HANDLING
			 *****************************************************************/

			case '$_REQUEST["error_handling_notices"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_NOTICES", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["we_error_handler"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_HANDLER", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_handling_warnings"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_WARNINGS", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_handling_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_ERRORS", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_display_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_SHOW", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_log_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_LOG", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_mail_errors"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL", 0);

				$_update_prefs = true;
				break;

			case '$_REQUEST["error_mail_address"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "WE_ERROR_MAIL_ADDRESS", "mail@somedomain.com");

				$_update_prefs = true;
				break;

			case '$_REQUEST["debug_normal"]':
				$_SESSION["prefs"]["debug_normal"] = 0;

				$_update_prefs = true;
				break;

			case '$_REQUEST["debug_normal"]':
				$_SESSION["prefs"]["debug_normal"] = 0;

				$_update_prefs = true;
				break;


			case '$_REQUEST["message_reporting"]':
				$_SESSION["prefs"]["message_reporting"] = 7;
				$_update_prefs = true;
				break;


			case '$_REQUEST["disable_template_tag_check"]':

				$_file = &$GLOBALS['config_files']['conf_global']['content'];
				$_file = weConfParser::changeSourceCode("define", $_file, "DISABLE_TEMPLATE_TAG_CHECK", 0);

				$_update_prefs = true;
				break;

			/*****************************************************************
			 * CANCEL OTHER REQUESTS
			 *****************************************************************/

			default:
				$_update_prefs = false;
				break;
		}
	}

	// Return if the preferences need to be written to the database
	return $_update_prefs;
}

/**
 * This functions saves all options.
 *
 * @see            remember_value()
 *
 * @return         void
 */

function save_all_values() {
	global $DB_WE, $BROWSER, $SYSTEM;

	// First, read all needed files
	$GLOBALS['config_files'] = array();

	// we_conf.inc.php
	$GLOBALS['config_files']['conf'] = array();
	$GLOBALS['config_files']['conf']['filename'] = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php";
	$GLOBALS['config_files']['conf']['content'] = weFile::load($GLOBALS['config_files']['conf']['filename']);

	// we_conf_global.inc.php
	$GLOBALS['config_files']['conf_global'] = array();
	$GLOBALS['config_files']['conf_global']['filename'] = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php";
	$GLOBALS['config_files']['conf_global']['content'] = weFile::load($GLOBALS['config_files']['conf_global']['filename']);

	// proxysettings.inc.php
	$GLOBALS['config_files']['proxysettings'] = array();
	$GLOBALS['config_files']['proxysettings']['filename'] = $_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php";
	$GLOBALS['config_files']['proxysettings']['content'] = weFile::load($GLOBALS['config_files']['proxysettings']['filename']);

	// we_active_integrated_modules.inc.php
	$GLOBALS['config_files']['active_integrated_modules'] = array();
	$GLOBALS['config_files']['active_integrated_modules']['filename'] = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_active_integrated_modules.inc.php";
	$GLOBALS['config_files']['active_integrated_modules']['content'] = weFile::load($GLOBALS['config_files']['active_integrated_modules']['filename']);


	// Second, change sourcecodes of the configfiles
	$_update_prefs = false;

	/*************************************************************************
	 * User Interface
	 *************************************************************************/

	$_update_prefs = remember_value(isset($_REQUEST["Language"]) ? $_REQUEST["Language"] : null, '$_REQUEST["Language"]');
	if(!(defined("ISP_VERSION") && ISP_VERSION)){
		$_update_prefs = remember_value(isset($_REQUEST["default_tree_count"]) ? $_REQUEST["default_tree_count"] : null, '$_REQUEST["default_tree_count"]') || $_update_prefs;
		if($_REQUEST["seem_start_type"]=="cockpit") {
			$_update_prefs = remember_value("cockpit", '$_REQUEST["seem_start_type"]') || $_update_prefs;
			$_update_prefs = remember_value(0, '$_REQUEST["seem_start_file"]') || $_update_prefs;
		} elseif($_REQUEST["seem_start_type"]=="object") {
			$_update_prefs = remember_value("object", '$_REQUEST["seem_start_type"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["seem_start_object"]) ? $_REQUEST["seem_start_object"] : 0, '$_REQUEST["seem_start_file"]') || $_update_prefs;
		} elseif($_REQUEST["seem_start_type"]=="document") {
			$_update_prefs = remember_value("document", '$_REQUEST["seem_start_type"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["seem_start_document"]) ? $_REQUEST["seem_start_document"] : 0, '$_REQUEST["seem_start_file"]') || $_update_prefs;
		} else {
			$_update_prefs = remember_value("", '$_REQUEST["seem_start_type"]') || $_update_prefs;
		}
		if (we_hasPerm("ADMINISTRATOR")) {
			$_disableSeem = isset($_REQUEST["disable_seem"]) && $_REQUEST["disable_seem"] ? 1 : 0;
			$_update_prefs = remember_value($_disableSeem, '$_REQUEST["disable_seem"]') || $_update_prefs;
		}
	}
	$_update_prefs = remember_value(isset($_REQUEST["sizeOpt"]) ? $_REQUEST["sizeOpt"] : null, '$_REQUEST["sizeOpt"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["weWidth"]) ? $_REQUEST["weWidth"] : null, '$_REQUEST["weWidth"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["weHeight"]) ? $_REQUEST["weHeight"] : null, '$_REQUEST["weHeight"]') || $_update_prefs;

	$_update_prefs = remember_value(isset($_REQUEST["ui_sidebar_disable"]) ? 1 : 0, '$_REQUEST["ui_sidebar_disable"]') || $_update_prefs;


	/*************************************************************************
	 * COCKPIT
	 *************************************************************************/

	$_update_prefs = remember_value(isset($_REQUEST["cockpit_amount_columns"]) ? $_REQUEST["cockpit_amount_columns"] : 5, '$_REQUEST["cockpit_amount_columns"]');


	/*************************************************************************
	 * CACHING
	 *************************************************************************/

	$_update_prefs = remember_value(isset($_REQUEST["cache_type"]) ? $_REQUEST["cache_type"] : 'none', '$_REQUEST["cache_type"]');
	$_update_prefs = remember_value(isset($_REQUEST["cache_lifetime"]) ? $_REQUEST["cache_lifetime"] : 0, '$_REQUEST["cache_lifetime"]');

	/*************************************************************************
	 * Frontend Languages
	 *************************************************************************/

	if(isset($_REQUEST['locale_locales']) && isset($_REQUEST['locale_default'])) {
		we_writeLanguageConfig($_REQUEST['locale_default'], explode(",", $_REQUEST['locale_locales']));

	}

	/*************************************************************************
	 * FILE EXTENSIONS
	 *************************************************************************/
	// Save settings if users has permission
	if(!(defined("ISP_VERSION") && ISP_VERSION)){
		if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
			$_update_prefs = remember_value(isset($_REQUEST["DefaultStaticExt"]) ? $_REQUEST["DefaultStaticExt"] : null, '$_REQUEST["DefaultStaticExt"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["DefaultDynamicExt"]) ? $_REQUEST["DefaultDynamicExt"] : null, '$_REQUEST["DefaultDynamicExt"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["DefaultHTMLExt"]) ? $_REQUEST["DefaultHTMLExt"] : null, '$_REQUEST["DefaultHTMLExt"]') || $_update_prefs;
		}
	}
	/*************************************************************************
	 * TEMPLATE EDITOR
	 *************************************************************************/
	$_update_prefs = remember_value(isset($_REQUEST["editorFont"]) ? $_REQUEST["editorFont"] : null, '$_REQUEST["editorFont"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorFontname"]) ? $_REQUEST["editorFontname"] : null, '$_REQUEST["editorFontname"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorFontsize"]) ? $_REQUEST["editorFontsize"] : null, '$_REQUEST["editorFontsize"]') || $_update_prefs;

	$_update_prefs = remember_value(isset($_REQUEST["editorFontcolor"]) ? $_REQUEST["editorFontcolor"] : null, '$_REQUEST["editorFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorWeTagFontcolor"]) ? $_REQUEST["editorWeTagFontcolor"] : null, '$_REQUEST["editorWeTagFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorWeAttributeFontcolor"]) ? $_REQUEST["editorWeAttributeFontcolor"] : null, '$_REQUEST["editorWeAttributeFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorHTMLTagFontcolor"]) ? $_REQUEST["editorHTMLTagFontcolor"] : null, '$_REQUEST["editorHTMLTagFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorHTMLAttributeFontcolor"]) ? $_REQUEST["editorHTMLAttributeFontcolor"] : null, '$_REQUEST["editorHTMLAttributeFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorPiTagFontcolor"]) ? $_REQUEST["editorPiTagFontcolor"] : null, '$_REQUEST["editorPiTagFontcolor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST["editorCommentFontcolor"]) ? $_REQUEST["editorCommentFontcolor"] : null, '$_REQUEST["editorCommentFontcolor"]') || $_update_prefs;
	
	/*************************************************************************
	 * FORMMAIL RECIPIENTS
	 *************************************************************************/
	// Save settings if users has permission
	if (we_hasPerm("FORMMAIL")) {
		$_update_prefs = remember_value(isset($_REQUEST["formmail_values"]) ? $_REQUEST["formmail_values"] : null, '$_REQUEST["formmail_values"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_deleted"]) ? $_REQUEST["formmail_deleted"] : null, '$_REQUEST["formmail_deleted"]') || $_update_prefs;
	}

	/*************************************************************************
	 * PROXY SERVER
	 *************************************************************************/

	// Save settings if users has permission
	if (we_hasPerm("ADMINISTRATOR")) {
		$_update_prefs = remember_value(isset($_REQUEST["useproxy"]) ? $_REQUEST["useproxy"] : null, '$_REQUEST["useproxy"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["proxyhost"]) ? $_REQUEST["proxyhost"] : null, '$_REQUEST["proxyhost"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["proxyport"]) ? $_REQUEST["proxyport"] : null, '$_REQUEST["proxyport"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["proxyuser"]) ? $_REQUEST["proxyuser"] : null, '$_REQUEST["proxyuser"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["proxypass"]) ? $_REQUEST["proxypass"] : null, '$_REQUEST["proxypass"]') || $_update_prefs;
	}

	/*************************************************************************
	 * active_integrated_modules
	 *************************************************************************/
	$_update_prefs = remember_value(isset($_REQUEST["active_integrated_modules"]) ? $_REQUEST["active_integrated_modules"] : null, '$_REQUEST["active_integrated_modules"]') || $_update_prefs;

	/*************************************************************************
	 * ADVANCED
	 *************************************************************************/

	// Save settings if users has permission
	if (we_hasPerm("ADMINISTRATOR")) {
		$_update_prefs = remember_value(isset($_REQUEST["we_php_default"]) ? $_REQUEST["we_php_default"] : null, '$_REQUEST["we_php_default"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["db_connect"]) ? $_REQUEST["db_connect"] : null, '$_REQUEST["db_connect"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["thumbnail_dir"]) ? $_REQUEST["thumbnail_dir"] : null, '$_REQUEST["thumbnail_dir"]') || $_update_prefs;
        $_update_prefs = remember_value(isset($_REQUEST["we_tracker_dir"]) ? $_REQUEST["we_tracker_dir"] : null, '$_REQUEST["we_tracker_dir"]') || $_update_prefs;
        $_update_prefs = remember_value(isset($_REQUEST["we_econda_stat"]) ? $_REQUEST["we_econda_stat"] : null, '$_REQUEST["we_econda_stat"]') || $_update_prefs;
        $_update_prefs = remember_value(isset($_REQUEST["we_econda_path"]) ? $_REQUEST["we_econda_path"] : null, '$_REQUEST["we_econda_path"]') || $_update_prefs;
        $_update_prefs = remember_value(isset($_REQUEST["we_econda_id"]) ? $_REQUEST["we_econda_id"] : null, '$_REQUEST["we_econda_id"]') || $_update_prefs;

		$_update_prefs = remember_value(isset($_REQUEST["inlineedit_default"]) ? $_REQUEST["inlineedit_default"] : null, '$_REQUEST["inlineedit_default"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["safari_wysiwyg"]) ? $_REQUEST["safari_wysiwyg"] : null, '$_REQUEST["safari_wysiwyg"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["showinputs_default"]) ? $_REQUEST["showinputs_default"] : null, '$_REQUEST["showinputs_default"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["we_max_upload_size"]) ? $_REQUEST["we_max_upload_size"] : null, '$_REQUEST["we_max_upload_size"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["we_new_folder_mod"]) ? $_REQUEST["we_new_folder_mod"] : null, '$_REQUEST["we_new_folder_mod"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["we_doctype_workspace_behavior"]) ? $_REQUEST["we_doctype_workspace_behavior"] : null, '$_REQUEST["we_doctype_workspace_behavior"]') || $_update_prefs;

    	$_update_prefs = remember_value(isset($_REQUEST["useauth"]) ? $_REQUEST["useauth"] : null, '$_REQUEST["useauth"]') || $_update_prefs;
    	$_update_prefs = remember_value(isset($_REQUEST["authuser"]) ? $_REQUEST["authuser"] : null, '$_REQUEST["authuser"]') || $_update_prefs;
    	$_update_prefs = remember_value(isset($_REQUEST["authpass"]) ? $_REQUEST["authpass"] : null, '$_REQUEST["authpass"]') || $_update_prefs;

	}

	/*************************************************************************
	 * ERROR HANDLING
	 *************************************************************************/


	// Save settings if users has permission
	if(!(defined("ISP_VERSION") && ISP_VERSION)){
		if (we_hasPerm("ADMINISTRATOR")) {
			$_update_prefs = remember_value(isset($_REQUEST["error_document_no_objectfile"]) ? $_REQUEST["error_document_no_objectfile"] : null, '$_REQUEST["error_document_no_objectfile"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["disable_template_tag_check"]) ? $_REQUEST["disable_template_tag_check"] : null, '$_REQUEST["disable_template_tag_check"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["we_error_handler"]) ? $_REQUEST["we_error_handler"] : null, '$_REQUEST["we_error_handler"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_handling_errors"]) ? $_REQUEST["error_handling_errors"] : null, '$_REQUEST["error_handling_errors"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_handling_warnings"]) ? $_REQUEST["error_handling_warnings"] : null, '$_REQUEST["error_handling_warnings"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_handling_notices"]) ? $_REQUEST["error_handling_notices"] : null, '$_REQUEST["error_handling_notices"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_display_errors"]) ? $_REQUEST["error_display_errors"] : null, '$_REQUEST["error_display_errors"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_log_errors"]) ? $_REQUEST["error_log_errors"] : null, '$_REQUEST["error_log_errors"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_mail_errors"]) ? $_REQUEST["error_mail_errors"] : null, '$_REQUEST["error_mail_errors"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["error_mail_address"]) ? $_REQUEST["error_mail_address"] : null, '$_REQUEST["error_mail_address"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["debug_normal"]) ? $_REQUEST["debug_normal"] : null, '$_REQUEST["debug_normal"]') || $_update_prefs;
			$_update_prefs = remember_value(isset($_REQUEST["debug_seem"]) ? $_REQUEST["debug_seem"] : null, '$_REQUEST["debug_seem"]') || $_update_prefs;
		}
	}

	/*************************************************************************
	 * message-reporting
	 *************************************************************************/
	$_update_prefs = remember_value(isset($_REQUEST["message_reporting"]) ? $_REQUEST["message_reporting"] : null, '$_REQUEST["message_reporting"]') || $_update_prefs;



	/*************************************************************************
	 * Validation
	 *************************************************************************/
    // Save settings if users has permission
	if (we_hasPerm("ADMINISTRATOR")) {
		// formmail stuff
		$_update_prefs = remember_value(isset($_REQUEST["formmail_confirm"]) ? $_REQUEST["formmail_confirm"] : null, '$_REQUEST["formmail_confirm"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_ViaWeDoc"]) ? $_REQUEST["formmail_ViaWeDoc"] : null, '$_REQUEST["formmail_ViaWeDoc"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_log"]) ? $_REQUEST["formmail_log"] : null, '$_REQUEST["formmail_log"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_block"]) ? $_REQUEST["formmail_block"] : null, '$_REQUEST["formmail_block"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_emptylog"]) ? $_REQUEST["formmail_emptylog"] : null, '$_REQUEST["formmail_emptylog"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_span"]) ? $_REQUEST["formmail_span"] : null, '$_REQUEST["formmail_span"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_blocktime"]) ? $_REQUEST["formmail_blocktime"] : null, '$_REQUEST["formmail_blocktime"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["formmail_trials"]) ? $_REQUEST["formmail_trials"] : null, '$_REQUEST["formmail_trials"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_default"]) ? $_REQUEST["xhtml_default"] : null, '$_REQUEST["xhtml_default"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_debug"]) ? $_REQUEST["xhtml_debug"] : null, '$_REQUEST["xhtml_debug"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_remove_wrong"]) ? $_REQUEST["xhtml_remove_wrong"] : null, '$_REQUEST["xhtml_remove_wrong"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_show_wrong"]) ? $_REQUEST["xhtml_show_wrong"] : null, '$_REQUEST["xhtml_show_wrong"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_show_wrong_text"]) ? $_REQUEST["xhtml_show_wrong_text"] : null, '$_REQUEST["xhtml_show_wrong_text"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_show_wrong_js"]) ? $_REQUEST["xhtml_show_wrong_js"] : null, '$_REQUEST["xhtml_show_wrong_js"]') || $_update_prefs;
		$_update_prefs = remember_value(isset($_REQUEST["xhtml_show_wrong_error_log"]) ? $_REQUEST["xhtml_show_wrong_error_log"] : null, '$_REQUEST["xhtml_show_wrong_error_log"]') || $_update_prefs;
	}

	/*************************************************************************
	 * BACKUP
	 *************************************************************************/

	if (we_hasPerm("ADMINISTRATOR")) {
		$_update_prefs = remember_value(isset($_REQUEST["backup_steps"]) ? $_REQUEST["backup_steps"] : null, '$_REQUEST["backup_steps"]') || $_update_prefs;
	}

	/*************************************************************************
	 * JUPLOAD
	*************************************************************************/
	$_update_prefs = remember_value(isset($_REQUEST['use_jupload']) ? $_REQUEST['use_jupload'] : null, '$_REQUEST["use_jupload"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST['use_jeditor']) ? $_REQUEST['use_jeditor'] : null, '$_REQUEST["use_jeditor"]') || $_update_prefs;
	$_update_prefs = remember_value(isset($_REQUEST['specify_jeditor_colors']) ? $_REQUEST['specify_jeditor_colors'] : null, '$_REQUEST["specify_jeditor_colors"]') || $_update_prefs;


	/*************************************************************************
	 * EMAIL
	 *************************************************************************/
	if (we_hasPerm("ADMINISTRATOR")) {

		$_update_prefs = remember_value(isset($_REQUEST["mailer_type"]) ? $_REQUEST["mailer_type"] : 'php', '$_REQUEST["mailer_type"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_server"]) ? $_REQUEST["smtp_server"] : 'localhost', '$_REQUEST["smtp_server"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_port"]) ? $_REQUEST["smtp_port"] : '25', '$_REQUEST["smtp_port"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_auth"]) ? $_REQUEST["smtp_auth"] : '0', '$_REQUEST["smtp_auth"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_username"]) ? $_REQUEST["smtp_username"] : '', '$_REQUEST["smtp_username"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_password"]) ? $_REQUEST["smtp_password"] : '', '$_REQUEST["smtp_password"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_halo"]) ? $_REQUEST["smtp_halo"] : '', '$_REQUEST["smtp_halo"]');
		$_update_prefs = remember_value(isset($_REQUEST["smtp_timeout"]) ? $_REQUEST["smtp_timeout"] : '', '$_REQUEST["smtp_timeout"]');

	}
	
	/*************************************************************************
	 * VERSIONING
	 *************************************************************************/
	if (we_hasPerm("ADMINISTRATOR")) {

		$_update_prefs = remember_value(isset($_REQUEST["version_image/*"]) ? $_REQUEST["version_image/*"] : '0', '$_REQUEST["version_image/*"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/html"]) ? $_REQUEST["version_text/html"] : '0', '$_REQUEST["version_text/html"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/webedition"]) ? $_REQUEST["version_text/webedition"] : '0', '$_REQUEST["version_text/webedition"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/js"]) ? $_REQUEST["version_text/js"] : '0', '$_REQUEST["version_text/js"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/css"]) ? $_REQUEST["version_text/css"] : '0', '$_REQUEST["version_text/css"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/plain"]) ? $_REQUEST["version_text/plain"] : '0', '$_REQUEST["version_text/plain"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_application/x-shockwave-flash"]) ? $_REQUEST["version_application/x-shockwave-flash"] : '0', '$_REQUEST["version_application/x-shockwave-flash"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_video/quicktime"]) ? $_REQUEST["version_video/quicktime"] : '0', '$_REQUEST["version_video/quicktime"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_application/*"]) ? $_REQUEST["version_application/*"] : '0', '$_REQUEST["version_application/*"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_text/xml"]) ? $_REQUEST["version_text/xml"] : '0', '$_REQUEST["version_text/xml"]');
		$_update_prefs = remember_value(isset($_REQUEST["version_objectFile"]) ? $_REQUEST["version_objectFile"] : '0', '$_REQUEST["version_objectFile"]');
		$_update_prefs = remember_value(isset($_REQUEST["versions_time_days"]) ? $_REQUEST["versions_time_days"] : '-1', '$_REQUEST["versions_time_days"]');
		$_update_prefs = remember_value(isset($_REQUEST["versions_time_weeks"]) ? $_REQUEST["versions_time_weeks"] : '-1', '$_REQUEST["versions_time_weeks"]');
		$_update_prefs = remember_value(isset($_REQUEST["versions_time_years"]) ? $_REQUEST["versions_time_years"] : '-1', '$_REQUEST["versions_time_years"]');
		$_update_prefs = remember_value(isset($_REQUEST["versions_anzahl"]) ? $_REQUEST["versions_anzahl"] : '-1', '$_REQUEST["versions_anzahl"]');
		$_update_prefs = remember_value(isset($_REQUEST["versions_create"]) ? $_REQUEST["versions_create"] : '1', '$_REQUEST["versions_create"]');
	
		$_SESSION['versions']['logPrefsChanged'] = array();
		foreach($_SESSION['versions']['logPrefs'] as $k=>$v) {
			if(isset($_REQUEST[$k])) {
				if($_SESSION['versions']['logPrefs'][$k]!=$_REQUEST[$k]) {
					$_SESSION['versions']['logPrefsChanged'][$k] = $_REQUEST[$k];
				}
			}
			elseif($_SESSION['versions']['logPrefs'][$k] != "") {
				$_SESSION['versions']['logPrefsChanged'][$k] = "";
			}
			
		}

		if(!empty($_SESSION['versions']['logPrefsChanged'])) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLog.class.php");
			$versionslog = new versionsLog();
			$versionslog->saveVersionsLog($_SESSION['versions']['logPrefsChanged'], WE_LOGGING_VERSIONS_PREFS);
		}
		unset($_SESSION['versions']['logPrefs']);
		unset($_SESSION['versions']['logPrefsChanged']);
	}

	/*************************************************************************
	 * SAVE CHANGES
	 *************************************************************************/

	// Third save all changes of the config files
	foreach($GLOBALS['config_files'] as $identifier => $file) {
		weFile::save($file['filename'], $file['content']);

	}

	if($_update_prefs) {
		doUpdateQuery($DB_WE, PREFS_TABLE, $_SESSION["prefs"], (" WHERE userID=" . $_SESSION["prefs"]["userID"]));
	}


}

/**
 * Checks the global configuration file we_conf_global.inc.php if every needed value
 * is available and adds missing values.
 *
 * @param          $values                                 array
 *
 * @return         void
 */

function check_global_config($values) {
	// Initialize variables
	$_rewrite_config = false;

	// Read the global configuration file
	$_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php";
	$_temp_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/tmp_we_conf_global.inc.php";
	$_file = weFile::load($_file_name);

	// Cut closing PHP tag from configuration file
	$_file = substr($_file, 0, strpos($_file, "?>"));

	// Go through all needed values
	for ($i = 0; $i < count($values); $i++) {
		if (strpos($_file, $values[$i][0]) === false) {

			// Add needed variable
			$_file .= $values[$i][1] . "\n\n";

			// Set flag for config going to be rewritten
			$_rewrite_config = true;
		}
	}

	$_file .= "\n\n?>";
	// Check if we need to rewrite the config file
	if ($_rewrite_config) {
		weFile::save($_temp_file_name,$_file);
		$counter = 0;
		while ($counter < 1000) {
			if (copy($_temp_file_name, $_file_name)) {
				$counter = 1000;
				@unlink($_temp_file_name);
			}
			$counter++;
		}

	}
}



/**
 * This builds every single dialog (of a tab).
 *
 * @param          $selected_setting                       string              (optional)
 *
 * @see            render_dialog()
 *
 * @return         string
 */

function build_dialog($selected_setting = "ui") {
	global $l_alert, $l_prefs, $DB_WE, $BROWSER, $SYSTEM, $MOZ_AX, $MOZ13, $NET6;
	$yuiSuggest =& weSuggest::getInstance();

	$we_button = new we_button();

	switch ($selected_setting) {
		case "save":
			/*****************************************************************
			 * SAVE DIALOG
			 *****************************************************************/

			$_settings = array();

			/**
			 * Saving
			 */

			// Build dialog
			array_push($_settings, array("headline" => "", "html" => $l_prefs["save"], "space" => 0));

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			$_dialog = create_dialog("", $l_prefs["save_wait"], $_settings);

			break;

		case "saved":
			/*****************************************************************
			 * SAVED SUCCESSFULLY DIALOG
			 *****************************************************************/

			$_settings = array();

			/**
			 * Saved
			 */

			// Build dialog
			array_push($_settings, array("headline" => "", "html" => $l_prefs["saved"], "space" => 0));

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			$_dialog = create_dialog("", $l_prefs["saved_successfully"], $_settings);

			break;

		case "ui":
			/*****************************************************************
			 * LANGUAGE
			 *****************************************************************/

			$_settings = array();

			/**
			 * Language
			 */

			//	Look which languages are installed ...
			$_language_directory = dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language");

			while (false !== ($entry = $_language_directory->read())) {
			  	if($entry != "." && $entry != "..") {
					if (is_dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry)
						&& is_file($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry."/translation.inc.php")) {

						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry."/translation.inc.php");
					} else {
						// do nothing
					}
			  	} else {
			  		// do nothing
			  	}
			}

			global $_languages;

			if(sizeof($_language["translation"]) > 1) { // Build language select box
				$_languages = new we_htmlSelect(array("name" => "Language", "class" => "weSelect", "onChange" => "document.getElementById('langnote').style.display='block'"));
			  	foreach ($_language["translation"] as $key=>$value) {
			    	$_languages->addOption($key, $value);

			    	// Set selected extension
			    	if ($key == get_value("ui_language")) {
			      		$_languages->selectOption($key);
			    	} else {
			    		// do nothing
			    	}
			  	}
				// Lang notice
				$langNote = '<div id="langnote" style="padding: 5px; background-color: rgb(221, 221, 221); width: 190px; display:none">
<table border="0" cellpadding="2" width="100%">
<tbody>
<tr>
<td style="padding-right: 10px;" valign="top">
  <img src="/webEdition/images/info_small.gif" height="22" width="20">
</td>
<td class="middlefont">'.$l_prefs["language_notice"].'
</td>
</tr>
</tbody>
</table>
</div>';
			 	// Build dialog
			  	array_push($_settings, array("headline" => $l_prefs["choose_language"], "html" => $_languages->getHtmlCode()."<br><br>".$langNote, "space" => 200));
			} else { // Just one Language Installed, no select box needed
				foreach ($_language["translation"] as $key=>$value) {
			    	$_languages = $value;
			  	}
			  	// Build dialog
			  	array_push($_settings, array("headline" =>$l_prefs["choose_language"], "html" => $_languages, "space" => 200));
			}


			/*****************************************************************
			 * AMOUNT COLUMNS IN COCKPIT
			 *****************************************************************/

			$_amount = new we_htmlSelect(array("name" => 'cockpit_amount_columns', "class" => "weSelect"));
			for($i = 1; $i <= 10; $i++) {
				$_amount->addOption($i, $i);
				if ($i == get_value("cockpit_amount_columns")) {
					$_amount->selectOption($i);
				}
			}

			array_push($_settings, array("headline" => $GLOBALS['l_prefs']["cockpit_amount_columns"], "html" => $_amount->getHtmlCode(), "space" => 200));


			/*****************************************************************
			 * SEEM
			 *****************************************************************/
			if( !(defined("ISP_VERSION") && ISP_VERSION )){
				/**
				 * Disable SEEM
				 */

				// Generate needed JS
				$_needed_JavaScript = "
							<script language=\"JavaScript\" type=\"text/javascript\"><!--
								" . $we_button->create_state_changer(false) . "
							//-->
							</script>";

				// Build maximize window
				$_seem_disabler = we_forms::checkbox(1, get_value("ui_disable_seem"), "disable_seem", $l_prefs["seem_deactivate"]);

				// Build dialog if user has permission
				if (we_hasPerm("ADMINISTRATOR")) {
					array_push($_settings, array("headline" => $l_prefs["seem"], "html" => $_seem_disabler, "space" => 200));
				}

				/***************************************************
				 * SEEM start document
				 ***************************************************/

				if (we_hasPerm("CHANGE_START_DOCUMENT")) {
					// Generate needed JS
					$_needed_JavaScript .= "
							<script language=\"JavaScript\" type=\"text/javascript\"><!--
                                function selectSidebarDoc() {
                                    myWind = false;

                                    for (k = parent.opener.top.jsWindow_count; k > -1; k--) {
                                        eval(\"if (parent.opener.top.jsWindow\" + k + \"Object) {\" +
                                             \" if (parent.opener.top.jsWindow\" + k + \"Object.ref == 'preferences') {\" +
                                             \"     myWind = parent.opener.top.jsWindow\" + k + \"Object.wind;\" +
                                             \"     myWindStr = 'top.jsWindow\" + k + \"Object.wind';\" +
                                             \" }\" +
                                             \"}\");

                                        if (myWind) {
                                            break;
                                        }
                                    }
                                    parent.opener.top.we_cmd('openDocselector', myWind.frames['we_preferences'].document.forms[0].elements['ui_sidebar_file'].value, '" . FILE_TABLE . "', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'ui_sidebar_file\'].value', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'ui_sidebar_file_name\'].value', '', '" . session_id() . "', '', 'text/webedition',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");
                                }
                                
                                function select_seem_start() {
									myWind = false;

									for (k = parent.opener.top.jsWindow_count; k > -1; k--) {
										eval(\"if (parent.opener.top.jsWindow\" + k + \"Object) {\" +
											 \"	if (parent.opener.top.jsWindow\" + k + \"Object.ref == 'preferences') {\" +
											 \"		myWind = parent.opener.top.jsWindow\" + k + \"Object.wind;\" +
											 \"		myWindStr = 'top.jsWindow\" + k + \"Object.wind';\" +
											 \"	}\" +
											 \"}\");

					 					if (myWind) {
											break;
										}
									}
									if(document.getElementById('seem_start_type').value == 'object') {
									";
					if(defined("OBJECT_FILES_TABLE")) {
						//$_needed_JavaScript .=	"parent.opener.top.we_cmd('openDocselector', myWind.frames['we_preferences'].document.forms[0].elements['seem_start_object'].value, '" . OBJECT_FILES_TABLE . "', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_object\'].value', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_object_name\'].value', '', '" . session_id() . "', '', 'objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).");";
						$_needed_JavaScript .=	"parent.opener.top.we_cmd('openDocselector', myWind.frames['we_preferences'].document.forms[0].elements['seem_start_object'].value, '" . OBJECT_FILES_TABLE . "', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_object\'].value', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_object_name\'].value', '', '" . session_id() . "', '', 'objectFile',1);";
					}
					$_needed_JavaScript .= "
									} else {
										parent.opener.top.we_cmd('openDocselector', myWind.frames['we_preferences'].document.forms[0].elements['seem_start_document'].value, '" . FILE_TABLE . "', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_document\'].value', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'seem_start_document_name\'].value', '', '" . session_id() . "', '', 'text/webedition',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");
									}
								}
								function show_seem_chooser(val) {
									if(val == 'document') {
										if(!!document.getElementById('selectordummy')) {
											document.getElementById('selectordummy').style.display = 'none';
										}
										if(!!document.getElementById('seem_start_object')) {
											document.getElementById('seem_start_object').style.display = 'none';
										}
										if(!!document.getElementById('seem_start_document')) {
											document.getElementById('seem_start_document').style.display = 'block';
										}
								";
					if(defined("OBJECT_FILES_TABLE")) {
						$_needed_JavaScript .= "
									} else if(val == 'object') {
										if(!!document.getElementById('selectordummy')) {
											document.getElementById('selectordummy').style.display = 'none';
										}
										if(!!document.getElementById('seem_start_document')) {
											document.getElementById('seem_start_document').style.display = 'none';
										}
										if(!!document.getElementById('seem_start_object')) {
											document.getElementById('seem_start_object').style.display = 'block';
										}
								";
					}
					$_needed_JavaScript .= "
									} else {
										if(!!document.getElementById('selectordummy')) {
											document.getElementById('selectordummy').style.display = 'block';
										}
										if(!!document.getElementById('seem_start_document')) {
											document.getElementById('seem_start_document').style.display = 'none';
										}
										if(!!document.getElementById('seem_start_object')) {
											document.getElementById('seem_start_object').style.display = 'none';
										}

									}
								}
							//-->
							</script>";

					// Cockpit
					$_object_path = "";
					$_object_id = 0;
					$_document_path = "";
					$_document_id = 0;
					$_seem_start_type = "";
					if(get_value("ui_seem_start_type") == "cockpit") {
						$_SESSION["prefs"]["seem_start_file"] = 0;
						$_seem_start_type = "cockpit";


					// Object
					} else if(get_value("ui_seem_start_type") == "object") {
						$_seem_start_type = "object";
						if (get_value("ui_seem_start_file") != 0) {
							$_object_id = get_value("ui_seem_start_file");
							$_get_object_paths = getPathsFromTable(OBJECT_FILES_TABLE, "", FILE_ONLY, $_object_id);

							if(isset($_get_object_paths[$_object_id])){	//	seeMode start file exists
								$_object_path = $_get_object_paths[$_object_id];

							}

						}

					// Document
					} else if(get_value("ui_seem_start_type") == "document") {
						$_seem_start_type = "document";
						if (get_value("ui_seem_start_file") != 0) {
							$_document_id = get_value("ui_seem_start_file");
							$_get_document_paths = getPathsFromTable(FILE_TABLE, "", FILE_ONLY, $_document_id);

							if(isset($_get_document_paths[$_document_id])){	//	seeMode start file exists
								$_document_path = $_get_document_paths[$_document_id];

							}

						}

					}

					$_start_type = new we_htmlSelect(array("name" => "seem_start_type","class" => "weSelect", "id" => "seem_start_type", "onchange" => "show_seem_chooser(this.value);"));

					$showStartType = false;
					$permitedStartTypes = array("");
					$_start_type->addOption("", "-");
					$_seem_cockpit_selectordummy = "<div id='selectordummy' style='height:".($BROWSER=="IE"?"33px":"24px").";'>&nbsp;</div>";
					if (we_hasPerm("CAN_SEE_QUICKSTART")) {
						$_start_type->addOption("cockpit", $l_prefs["seem_start_type_cockpit"]);
						$showStartType = true;
						$permitedStartTypes[] = "cockpit";
					}

					$selectorSpace = $BROWSER == "IE" ? 8 : 160;

					$_seem_document_chooser = "";
					if (we_hasPerm("CAN_SEE_DOCUMENTS")) {
						$_start_type->addOption("document", $l_prefs["seem_start_type_document"]);
						$showStartType = true;
						// Build SEEM select start document chooser

						$yuiSuggest->setAcId("Doc");
						$yuiSuggest->setContentType("folder,text/webEdition,text/html,image/*");
						$yuiSuggest->setInput("seem_start_document_name", $_document_path,"",get_value("ui_disable_seem"));
						$yuiSuggest->setMaxResults(20);
						$yuiSuggest->setMayBeEmpty(false);
						$yuiSuggest->setResult("seem_start_document", $_document_id);
						$yuiSuggest->setSelector("Docselector");
						$yuiSuggest->setWidth(150);
						$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:select_seem_start()", true, 100, 22, "", "", get_value("ui_disable_seem"), false),10);
						$yuiSuggest->setContainerWidth(259);
						
						$_seem_document_chooser = $we_button->create_button_table(array($yuiSuggest->getHTML()), 0, array("id"=>"seem_start_document", "style"=>"display:none"));
						$permitedStartTypes[] =	"document";
					}
					$_seem_object_chooser = "";
					if(defined("OBJECT_FILES_TABLE") && we_hasPerm("CAN_SEE_OBJECTFILES")) {
						$_start_type->addOption("object", $l_prefs["seem_start_type_object"]);
						$showStartType = true;
					// Build SEEM select start object chooser

						$yuiSuggest->setAcId("Obj");
						$yuiSuggest->setContentType("folder,objectFile");
						$yuiSuggest->setInput("seem_start_object_name", $_object_path,"",get_value("ui_disable_seem"));
						$yuiSuggest->setMaxResults(20);
						$yuiSuggest->setMayBeEmpty(false);
						$yuiSuggest->setResult("seem_start_object", $_object_id);
						$yuiSuggest->setSelector("Docselector");
						$yuiSuggest->setTable(OBJECT_FILES_TABLE);
						$yuiSuggest->setWidth(150);
						$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:select_seem_start()", true, 100, 22, "", "", get_value("ui_disable_seem"), false),10);
						$yuiSuggest->setContainerWidth(259);

						$_seem_object_chooser = $we_button->create_button_table(array($yuiSuggest->getHTML()), 0, array("id"=>"seem_start_object", "style"=>"display:none"));
						$permitedStartTypes[] = "object";
					}

					// Build final HTML code
					if ($showStartType) {
						if (in_array($_seem_start_type,$permitedStartTypes)) {
							$_start_type->selectOption($_seem_start_type);
						} else {
							$_seem_start_type = $permitedStartTypes[0];
						}
						$_seem_html = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 2, 1);
						$_seem_html->setCol(0, 0, array("class" => "defaultfont"), $_start_type->getHtmlCode());
						$_seem_html->setCol(1, 0, array("style" => "padding-top:5px;"), $_seem_cockpit_selectordummy . $_seem_document_chooser . $_seem_object_chooser);
						array_push($_settings, array("headline" => $l_prefs["seem_startdocument"], "html" => $_seem_html->getHtmlCode().'<script language="JavaScript" type="text/javascript">show_seem_chooser("'.$_seem_start_type.'");</script>', "space" => 200));
					}

					// Build dialog if user has permission
				}

				/*********************************************************
				 *Sidebar
				 *********************************************************/
				if (we_hasPerm("ADMINISTRATOR")) {

					// Settings
					$_sidebar_disable = get_value("ui_sidebar_disable");
					if($_sidebar_disable) {
						$_sidebar_show = "none";
					} else {
						$_sidebar_show = "block";
					}
					$_sidebar_show_on_startup = get_value("ui_sidebar_show_on_startup");
					$_sidebar_width = get_value("ui_sidebar_width");
					$_sidebar_id = get_value("ui_sidebar_file");
					$_sidebar_paths = getPathsFromTable(FILE_TABLE, "", FILE_ONLY, $_sidebar_id);
					$_sidebar_path = "";
					if(isset($_sidebar_paths[$_sidebar_id])) {
						$_sidebar_path = $_sidebar_paths[$_sidebar_id];

					}

					// Enable / disable sidebar
					$_sidebar_disabler = we_forms::checkbox(0, $_sidebar_disable, "ui_sidebar_disable", $l_prefs["sidebar_deactivate"], false, "defaultfont", "document.getElementById('sidebar_options').style.display=(this.checked?'none':'block');");

					// Show on Startup
					$_sidebar_show_on_startup = we_forms::checkbox(1, $_sidebar_show_on_startup, "ui_sidebar_show_on_startup", $l_prefs["sidebar_show_on_startup"], false, "defaultfont", "");

					// Sidebar width
					$_sidebar_width = htmlTextInput('ui_sidebar_width', 8, $_sidebar_width, 255, "onchange=\"if ( isNaN( this.value ) ||  parseInt(this.value) < 100 ) { this.value=100; };\"", "text", 150);
					$_sidebar_width_chooser = htmlSelect("tmp_sidebar_width", array(''=>'',100=>100,150=>150,200=>200,250=>250,300=>300,350=>350,400=>400), 1, "", false,"onChange=\"document.forms[0].elements['ui_sidebar_width'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;\"","value",100,"defaultfont");

					// Sidebar document
					//$_sidebar_hidden = we_htmlElement::htmlHidden(array("name" => "ui_sidebar_file", "value" => $_sidebar_id, "id"=>"yuiAcResultSidebarDoc"));
					$_sidebar_document_button = $we_button->create_button("select", "javascript:selectSidebarDoc()");

					$yuiSuggest->setAcId("SidebarDoc");
					$yuiSuggest->setContentType("folder,text/webEdition");
					$yuiSuggest->setInput("ui_sidebar_file_name", $_sidebar_path);
					$yuiSuggest->setMaxResults(20);
					$yuiSuggest->setMayBeEmpty(true);
					$yuiSuggest->setResult("ui_sidebar_file", $_sidebar_id);
					$yuiSuggest->setSelector("Docselector");
					$yuiSuggest->setWidth(150);
					$yuiSuggest->setSelectButton($_sidebar_document_button,10);
					$yuiSuggest->setContainerWidth(259);

					// build html
					$_sidebar_html1 = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 1, 1);

					$_sidebar_html1->setCol(0, 0, null, $_sidebar_disabler);

					// build html
					$_sidebar_html2 = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0", "id"=>"sidebar_options", "style"=>"display:" . $_sidebar_show), 8, 3);

					$_sidebar_html2->setCol(0, 0, array("colspan"=>3,"height"=>10), "");

					$_sidebar_html2->setCol(1, 0, array("colspan"=>3,"height"=>10), $_sidebar_show_on_startup);

					$_sidebar_html2->setCol(2, 0, array("colspan"=>3,"height"=>10), "");

					$_sidebar_html2->setCol(3, 0, array("colspan"=>3,"class"=>"defaultfont"), $l_prefs["sidebar_width"]);

					$_sidebar_html2->setCol(4, 0, null, $_sidebar_width);
					$_sidebar_html2->setCol(4, 1, null, getPixel(10,1));
					$_sidebar_html2->setCol(4, 2, null, $_sidebar_width_chooser);

					$_sidebar_html2->setCol(5, 0, array("colspan"=>3,"height"=>10), "");

					$_sidebar_html2->setCol(6, 0, array("colspan"=>3,"class"=>"defaultfont"), $l_prefs["sidebar_document"]);

					$_sidebar_html2->setCol(7, 0, array("colspan"=>3), $yuiSuggest->getHTML());

					// Build dialog if user has permission
					array_push($_settings, array("headline" => $l_prefs["sidebar"], "html" => $_sidebar_html1->getHtmlCode() . $_sidebar_html2->getHtmlCode(), "space" => 200));
				}

			}

			/*****************************************************************
			 * TREE
			 *****************************************************************/
			 if(!( defined("ISP_VERSION") && ISP_VERSION )){
				$_value_selected=false;
				$_tree_count=get_value("default_tree_count");

				$_file_tree_count = new we_htmlSelect(array("name" => "default_tree_count","class"=>"weSelect"));

				$_file_tree_count->addOption(0, $l_prefs["all"]);
				if (0 == $_tree_count) {
						$_file_tree_count->selectOption(0);
						$_value_selected = true;
				}

				for ($i = 10; $i < 51; $i+=10) {
					$_file_tree_count->addOption($i, $i);

					// Set selected extension
					if ($i == $_tree_count) {
						$_file_tree_count->selectOption($i);
						$_value_selected = true;
					}
				}

				for ($i = 100; $i < 501; $i+=100) {
					$_file_tree_count->addOption($i, $i);

					// Set selected extension
					if ($i == $_tree_count) {
						$_file_tree_count->selectOption($i);
						$_value_selected = true;
					}
				}

				if (!$_value_selected) {
					$_file_tree_count->addOption($_tree_count, $_tree_count);
						// Set selected extension
					$_file_tree_count->selectOption($_tree_count);
				}

				array_push($_settings, array("headline" => $l_prefs["tree_title"], "html" => htmlAlertAttentionBox($l_prefs["tree_count_description"],2,200)."<br>".$_file_tree_count->getHtmlCode(), "space" => 200));
			 }

			/*****************************************************************
			 * WINDOW DIMENSIONS
			 *****************************************************************/

			/**
			 * Window dimensions
			 */

			$_window_max = false;
			$_window_specify = false;

			if (get_value("ui_size_opt") == 0) {
				$_window_max = true;
			}

			if (get_value("ui_size_opt") == 1) {
				$_window_specify = true;
			}

			// Build maximize window
			$_window_max_code = we_forms::radiobutton(0, get_value("ui_size_opt") == 0, "sizeOpt", $l_prefs["maximize"], true, "defaultfont", "document.getElementsByName('weWidth')[0].disabled = true;document.getElementsByName('weHeight')[0].disabled = true;");

			// Build specify window dimension
			$_window_specify_code = we_forms::radiobutton(1, !(get_value("ui_size_opt") == 0), "sizeOpt", $l_prefs["specify"], true, "defaultfont", "document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;");

			// Create specify window dimension input
			$_window_specify_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 4, 4);

			$_window_specify_table->setCol(0, 0, null, getPixel(1, 10));
			$_window_specify_table->setCol(1, 0, null, getPixel(50, 1));
			$_window_specify_table->setCol(2, 0, null, getPixel(1, 5));
			$_window_specify_table->setCol(3, 0, null, getPixel(50, 1));

			$_window_specify_table->setCol(1, 1, array("class" => "defaultfont"), $l_prefs["width"] . ":");
			$_window_specify_table->setCol(3, 1, array("class" => "defaultfont"), $l_prefs["height"] . ":");

			$_window_specify_table->setCol(1, 2, null, getPixel(10, 1));
			$_window_specify_table->setCol(3, 2, null, getPixel(10, 1));

			$_window_specify_table->setCol(1, 3, null, htmlTextInput("weWidth", 6, (get_value("ui_size_opt") != 0 ? get_value("ui_we_width") : ""), 4, (get_value("ui_size_opt") == 0 ? "disabled=\"disabled\"" : ""), "text", 60));
			$_window_specify_table->setCol(3, 3, null, htmlTextInput("weHeight", 6, (get_value("ui_size_opt") != 0 ? get_value("ui_we_height") : ""), 4, (get_value("ui_size_opt") == 0 ? "disabled=\"disabled\"" : ""), "text", 60));

			// Build apply current window dimension
			$_window_current_dimension_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 1, 2);

			$_window_current_dimension_table->setCol(0, 0, null, getPixel(50, 1));
			$_window_current_dimension_table->setCol(0, 1, null, $we_button->create_button("apply_current_dimension", "javascript:document.getElementsByName('sizeOpt')[1].checked = true;document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;document.getElementsByName('weWidth')[0].value = " . ($BROWSER == "IE" ? "parent.opener.top.document.body.clientWidth" : "parent.opener.top.window.outerWidth") . ";document.getElementsByName('weHeight')[0].value = " . ($BROWSER == "IE" ? "parent.opener.top.document.body.clientHeight;" : "parent.opener.top.window.outerHeight;"), true));

			// Build final HTML code
			$_window_html = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 5, 1);
			$_window_html->setCol(0, 0, null, $_window_max_code);
			$_window_html->setCol(1, 0, null, getPixel(1, 10));
			$_window_html->setCol(2, 0, null, $_window_specify_code . $_window_specify_table->getHtmlCode());
			$_window_html->setCol(3, 0, null, getPixel(1, 10));
			$_window_html->setCol(4, 0, null, $_window_current_dimension_table->getHtmlCode());

			// Build dialog
			array_push($_settings, array("headline" => $l_prefs["dimension"], "html" => $_window_html->getHtmlCode(), "space" => 200));

			/**
			 * Predefined window dimensions
			 */

			// Create predefined window dimension buttons
			$_window_predefined_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 3, 1);

			$_window_predefined_table->setCol(0, 0, null, $we_button->create_button_table(array($we_button->create_button("res_800", "javascript:document.getElementsByName('sizeOpt')[1].checked = true;document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;document.getElementsByName('weWidth')[0].value = '800';document.getElementsByName('weHeight')[0].value = '600';", true), $we_button->create_button("res_1024", "javascript:document.getElementsByName('sizeOpt')[1].checked = true;document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;document.getElementsByName('weWidth')[0].value = '1024';document.getElementsByName('weHeight')[0].value = '768';", true))));
			$_window_predefined_table->setCol(2, 0, null, $we_button->create_button_table(array($we_button->create_button("res_1280", "javascript:document.getElementsByName('sizeOpt')[1].checked = true;document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;document.getElementsByName('weWidth')[0].value = '1280';document.getElementsByName('weHeight')[0].value = '960';", true), $we_button->create_button("res_1600", "javascript:document.getElementsByName('sizeOpt')[1].checked = true;document.getElementsByName('weWidth')[0].disabled = false;document.getElementsByName('weHeight')[0].disabled = false;document.getElementsByName('weWidth')[0].value = '1600';document.getElementsByName('weHeight')[0].value = '1200';", true))));

			$_window_predefined_table->setCol(1, 0, null, getPixel(1, 10));

			// Build dialog
			array_push($_settings, array("headline" => $l_prefs["predefined"], "html" => $_window_predefined_table->getHtmlCode(), "space" => 200));

			$_settings_cookie = weGetCookieVariable("but_settings_predefined");

			/**
			 * BUILD FINAL DIALOG
			 */
			 $_tabUi = (we_hasPerm("CHANGE_START_DOCUMENT") ? 7 : 6);


			$_dialog = create_dialog("settings_predefined", $l_prefs["tab_ui"], $_settings, $_tabUi, $l_prefs["show_predefined"], $l_prefs["hide_predefined"], $_settings_cookie, (isset($_needed_JavaScript) ? $_needed_JavaScript : ""));

			break;

		case "cache":

			$_settings = array();

			if (we_hasPerm("ADMINISTRATOR")) {

				/*****************************************************************
				 * Information
				 *****************************************************************/

				$_information = htmlAlertAttentionBox($l_prefs["cache_information"], 2, 450, false);

				// Build dialog if user has permission
				array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));


				/*****************************************************************
				 * Pre Settings Cache
				 *****************************************************************/

				// Cache Type
				$cache_type = new we_htmlSelect(array("name" => 'cache_type', "style" => "width:200px;", "class" => "weSelect"));
				$cache_type->addOption('none', $GLOBALS['l_prefs']["cache_type_none"]);
				$cache_type->addOption('tag', $GLOBALS['l_prefs']["cache_type_wetag"]);
				$cache_type->addOption('document', $GLOBALS['l_prefs']["cache_type_document"]);
				$cache_type->addOption('full', $GLOBALS['l_prefs']["cache_type_full"]);
				$cache_type->selectOption(get_value("cache_type"));

				// Cache Life Time
				$_lifeTime = htmlTextInput('cache_lifetime', 8, get_value("cache_lifetime"), 255, "", "text", 100);
				$_lifeTimeChooser = htmlSelect("tmp_cache_lifetime]", $l_prefs['cache_lifetimes'], 1, get_value("cache_lifetime"), false,"onChange=\"document.forms[0].elements['cache_lifetime'].value=this.options[this.selectedIndex].value;document.forms[0].elements['cache_lifetime'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;\"","value",100,"defaultfont");
				$cache_lifetime = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $_lifeTime . '</td><td>' . $_lifeTimeChooser . '</td></tr></table>';

				// Build final HTML code
				$_add_html	=	$GLOBALS['l_prefs']["cache_type"] . "<br />"
							.	$cache_type->getHtmlCode() . "<br /><br />"
							.	$GLOBALS['l_prefs']["cache_lifetime"] . "<br />"
							.	$cache_lifetime;

				// Build dialog element if users has permission
				array_push($_settings, array("headline" => $l_prefs["cache_presettings"], "html" => $_add_html, "space" => 200));



				/*****************************************************************
				 * Information
				 *****************************************************************/

				$_information = htmlAlertAttentionBox($l_prefs["cache_navigation_information"], 2, 450, false);

				// Build dialog if user has permission
				array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));

				/*****************************************************************
				 * Default Settings Cache for we:navigation
				 *****************************************************************/

				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");

				$configFile = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/navigation/conf/we_conf_navigation.inc.php";
				if(!file_exists($configFile) || !is_file($configFile)) {
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/navigation/class/weNavigationSettingControl.class.php");
					weNavigationSettingControl::saveSettings(true);
				}
				include($configFile);

				// Cache Life Time
				$_lifeTime = htmlTextInput('CacheLifeTime', 8, $GLOBALS['weDefaultNavigationCacheLifetime'], 255, "", "text", 100);
				$_lifeTimeChooser = htmlSelect("CacheLifeTimeSelect]", $l_prefs['cache_lifetimes'], 1, $GLOBALS['weDefaultNavigationCacheLifetime'], false,"onChange=\"document.forms[0].elements['CacheLifeTime'].value=this.options[this.selectedIndex].value;document.forms[0].elements['CacheLifeTime'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;\"","value",100,"defaultfont");
				$cache_lifetime = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $_lifeTime . '</td><td>' . $_lifeTimeChooser . '</td></tr></table>';

				array_push($_settings, array(
									'headline' => $l_prefs['cache_navigation'],
									'space' => 200,
									'html' => $GLOBALS['l_prefs']["cache_lifetime"] . "<br />" .$cache_lifetime)
				);

				// Cache Lifetime
				$content = 		we_forms::checkboxWithHidden($GLOBALS['weNavigationCacheDeleteAfterAdd'], 'NavigationCacheAdd', $l_prefs['delete_cache_add']) . '<br />'
							.	we_forms::checkboxWithHidden($GLOBALS['weNavigationCacheDeleteAfterEdit'], 'NavigationCacheEdit', $l_prefs['delete_cache_edit']) . '<br />'
							.	we_forms::checkboxWithHidden($GLOBALS['weNavigationCacheDeleteAfterDelete'], 'NavigationCacheDelete', $l_prefs['delete_cache_delete']) . '<br />';

				array_push($_settings, array(
									'headline' => $GLOBALS['l_prefs']['delete_cache_after'],
									'space' => 200,
									'html' => $content,
									'noline' => 1)
				);

			}

			// Build dialog element if user has permission
			$_dialog = create_dialog("", $l_prefs["tab_cache"], $_settings);

			break;



		case "language":

			if (we_hasPerm("ADMINISTRATOR")) {
				$default = get_value("locale_default");
				$locales = get_value("locale_locales");

				$preJs = "
<script type=\"text/javascript\">
	function addLocale() {
		var LanguageIndex = document.getElementById('locale_language').selectedIndex;
		var LanguageValue = document.getElementById('locale_language').options[LanguageIndex].value;
		var LanguageText = document.getElementById('locale_language').options[LanguageIndex].text;

		var CountryIndex = document.getElementById('locale_country').selectedIndex;
		var CountryValue = document.getElementById('locale_country').options[CountryIndex].value;
		var CountryText = document.getElementById('locale_country').options[CountryIndex].text;

		if(LanguageValue.substr(0, 1) == \"~\") {
			LanguageValue = LanguageValue.substr(1);
		}
		if(LanguageValue == \"\") {
			return;
		}

		if(CountryValue.substr(0, 1) == \"~\") {
			CountryValue = CountryValue.substr(1);
		}
		if(CountryValue != \"\") {
			var LocaleValue = LanguageValue + '_' + CountryValue;
			var LocaleText = LanguageText + ' (' + CountryText + ')';
		} else {
			var LocaleValue = LanguageValue;
			var LocaleText = LanguageText;
		}

		var found = false;
		for(i = 0; i < document.getElementById('locale_temp_locales').options.length; i++) {
			if(document.getElementById('locale_temp_locales').options[i].value == LocaleValue) {
				found = true;
			}
		}

		if(found == true) {
			" . we_message_reporting::getShowMessageCall($GLOBALS['l_prefs']["language_already_exists"], WE_MESSAGE_ERROR) . "
		} else {

			var option = new Option(LocaleText, LocaleValue, false, false);
			document.getElementById('locale_temp_locales').options[document.getElementById('locale_temp_locales').options.length] = option

			if(document.getElementById('locale_temp_locales').options.length == 1) {
				setDefaultLocale(LocaleValue);
			}
";

				if(defined("SPELLCHECKER")) {
					$preJs .= "

			// W�rterbuch hinzuf�gen
			if(confirm('{$GLOBALS['l_prefs']["add_dictionary_question"]}')) {
				top.opener.top.we_cmd('edit_spellchecker_ifthere');
			}
";
				}

				$preJs .= "

		}
		resetLocales();

	}

	function deleteLocale() {

		if(document.getElementById('locale_temp_locales').selectedIndex > -1) {
			var LocaleIndex = document.getElementById('locale_temp_locales').selectedIndex;
			var LocaleValue =  document.getElementById('locale_temp_locales').options[LocaleIndex].value;

			if(LocaleValue == document.getElementById('locale_default').value) {
				" . we_message_reporting::getShowMessageCall($GLOBALS['l_prefs']['cannot_delete_default_language'], WE_MESSAGE_ERROR) . "
			} else {
				document.getElementById('locale_temp_locales').options[LocaleIndex] = null;
			}
			resetLocales();
		}

	}

	function defaultLocale() {

		if(document.getElementById('locale_temp_locales').selectedIndex > -1) {
			var LocaleIndex = document.getElementById('locale_temp_locales').selectedIndex;
			var LocaleValue =  document.getElementById('locale_temp_locales').options[LocaleIndex].value;

			setDefaultLocale(LocaleValue);
		}

	}

	function setDefaultLocale(Value) {

		if(document.getElementById('locale_temp_locales').options.length > 0) {
			Index = 0;
			for(i = 0; i < document.getElementById('locale_temp_locales').options.length; i++) {
				if(document.getElementById('locale_temp_locales').options[i].value == Value) {
					Index = i;
				}
				document.getElementById('locale_temp_locales').options[i].style.background = '#ffffff';
			}
			document.getElementById('locale_temp_locales').options[Index].style.background = '#cccccc';
			document.getElementById('locale_temp_locales').options[Index].selected = false;
			document.getElementById('locale_default').value = Value;
		}

	}

	function resetLocales() {

		if(document.getElementById('locale_temp_locales').options.length > 0) {
			var temp = new Array(document.getElementById('locale_temp_locales').options.length);
			for(i = 0; i < document.getElementById('locale_temp_locales').options.length; i++) {
				temp[i] = document.getElementById('locale_temp_locales').options[i].value;
			}
			document.getElementById('locale_locales').value = temp.join(\",\");
		}

	}

	function initLocale(Locale) {
		if(Locale != \"\") {
			setDefaultLocale(Locale);
		}
		resetLocales();
	}

	Array.prototype.contains = function(obj) {
		var i, listed = false;
		for (i=0; i<this.length; i++) {
			if (this[i] === obj) {
				listed = true;
				break;
			}
		}
		return listed;
	}

</script>
";

				$postJs = <<<EOF
<script type="text/javascript">
	initLocale("{$default}");
</script>
EOF;


				$_settings = array();

				/*****************************************************************
				 * Information
				 *****************************************************************/

				$_hidden_fields  = we_htmlElement::htmlHidden(array("name" => "locale_default", "value" => $default, "id" => "locale_default"));
				$_hidden_fields  .= we_htmlElement::htmlHidden(array("name" => "locale_locales", "value" => implode(",", array_keys($locales)), "id" => "locale_locales"));

				$_information = htmlAlertAttentionBox($l_prefs["locale_information"], 2, 450, false);

				// Build dialog if user has permission
				array_push($_settings, array("headline" => "", "html" =>  $_information, "space" => 0));


				/*****************************************************************
				 * Locales
				 *****************************************************************/

				$_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => 'locale_temp_locales', "size" => "10", "id" => 'locale_temp_locales', "style" => "width: 340px"));
				$_select_box->addOptions(sizeof($locales), array_keys($locales), array_values($locales));

				$_enabled_buttons = false;
				if(sizeof($locales)>0) {
					$_enabled_buttons = true;
				}


				// Create edit list
				$_editlist_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 2, 3);

				// Buttons
				$default = $we_button->create_button("default", "javascript:defaultLocale()", true, 100, 22, "", "", !$_enabled_buttons);
				$delete = $we_button->create_button("delete", "javascript:deleteLocale()", true, 100);

				$_html = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 1, 3);
				$_html->setCol(0, 0, array("class" => "defaultfont"), $default);
				$_html->setCol(0, 1, null, getPixel(25, 2));
				$_html->setCol(0, 2, array("class" => "defaultfont"), $delete);

				$_editlist_table->setCol(0, 0, null, $_hidden_fields . $_select_box->getHtmlCode());
				$_editlist_table->setCol(0, 1, null, getPixel(10, 1));
				$_editlist_table->setCol(0, 2, array("valign" => "top"), $default . getPixel(1, 10) . $delete);

				// Build dialog if user has permission
				if (we_hasPerm("FORMMAIL")) {
					array_push($_settings, array("headline" => "", "html" => $_editlist_table->getHtmlCode(), "space" => 0));
				}


				/*****************************************************************
				 * Add Locales
				 *****************************************************************/

				// Languages
				$Languages = $GLOBALS['l_languages'];
				$TopLanguages = array();
				$TopLanguages['~de'] = $Languages['de'];
				$TopLanguages['~nl'] = $Languages['nl'];
				$TopLanguages['~en'] = $Languages['en'];
				$TopLanguages['~fi'] = $Languages['fi'];
				$TopLanguages['~fr'] = $Languages['fr'];
				$TopLanguages['~pl'] = $Languages['pl'];
				$TopLanguages['~ru'] = $Languages['ru'];
				$TopLanguages['~es'] = $Languages['es'];
				asort($Languages);
				asort($TopLanguages);
				$TopLanguages[''] = "---";
				$Languages = array_merge($TopLanguages, $Languages);

				$_languages = new we_htmlSelect(array("name" => 'locale_language', "id" => 'locale_language', "style" => "width: 139px", "class" => "weSelect"));
				$_languages->addOptions(sizeof($Languages), array_keys($Languages), array_values($Languages));

				// Countries
				$Countries = $GLOBALS['l_countries'];
				$TopCountries = array();
				$TopCountries['~DE'] = $Countries['DE'];
				$TopCountries['~CH'] = $Countries['CH'];
				$TopCountries['~AT'] = $Countries['AT'];
				$TopCountries['~NL'] = $Countries['NL'];
				$TopCountries['~GB'] = $Countries['GB'];
				$TopCountries['~US'] = $Countries['US'];
				$TopCountries['~FI'] = $Countries['FI'];
				$TopCountries['~FR'] = $Countries['FR'];
				$TopCountries['~PL'] = $Countries['PL'];
				$TopCountries['~RU'] = $Countries['RU'];
				$TopCountries['~ES'] = $Countries['ES'];
				asort($Countries);
				asort($TopCountries);
				$TopCountries['~'] = "---";
				$Countries = array_merge(array("" => ""), $TopCountries, $Countries);

				$_countries = new we_htmlSelect(array("name" => 'locale_country', "id" => 'locale_country', "style" => "width: 139px", "class" => "weSelect"));
				$_countries->addOptions(sizeof($Countries), array_keys($Countries),  array_values($Countries));

				// Button
				$_add_button = $we_button->create_button("add", "javascript:addLocale()", true, 139);

				// Build final HTML code
				$_add_html	=	$GLOBALS['l_prefs']["locale_languages"] . "<br />"
										.	$_languages->getHtmlCode() . "<br /><br />"
										.	$GLOBALS['l_prefs']["locale_countries"] . "<br />"
										.	$_countries->getHtmlCode() . "<br /><br />"
										.	$_add_button;

				// Build dialog element if users has permission
				array_push($_settings, array("headline" => $l_prefs["locale_add"], "html" => $_add_html, "space" => 200));



				/*****************************************************************
				 * Dialog
				 *****************************************************************/

				// Build dialog element if user has permission
				$_dialog = $preJs . create_dialog("", $l_prefs["tab_language"], $_settings) . $postJs;

			}

			break;

		case "extensions":

			/*****************************************************************
			 * FILE EXTENSIONS
			 *****************************************************************/


			$_settings = array();

			/**
			 * Information
			 */

			$_information = htmlAlertAttentionBox($l_prefs["extensions_information"], 2, 450, false);

			array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");

			/**
			 * webEdition extensions
			 */

			// Get webEdition extensions
			$_we_extensions = array();

			$_we_extensions = explode(",", $GLOBALS["WE_CONTENT_TYPES"]["text/webedition"]["Extension"]);

			// Build static webEdition extensions select box
			$_static_we_extensions = new we_htmlSelect(array("name" => "DefaultStaticExt","class"=>"weSelect"));
			foreach ($_we_extensions as $key=>$value) {
				$_static_we_extensions->addOption($value, $value);

				// Set selected extension
				if ($value == get_value("extension_static")) {
					$_static_we_extensions->selectOption($value);
				}
			}

			// Build dynamic webEdition extensions select box
			$_dynamic_we_extensions = new we_htmlSelect(array("name" => "DefaultDynamicExt","class"=>"weSelect"));

			foreach ($_we_extensions as $key=>$value) {
				$_dynamic_we_extensions->addOption($value, $value);

				// Set selected extension
				if ($value == get_value("extension_dynamic")) {
					$_dynamic_we_extensions->selectOption($value);
				}
			}

			// Build final HTML code
			$_we_extensions_html = $l_prefs["static"] . "<br>" . $_static_we_extensions->getHtmlCode() . "<br><br>" . $l_prefs["dynamic"] . "<br>" . $_dynamic_we_extensions->getHtmlCode();

			// Build dialog element if users has permission
			if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
				array_push($_settings, array("headline" => $l_prefs["we_extensions"], "html" => $_we_extensions_html, "space" => 200));
			}

			/**
			 * HTML extensions
			 */

			// Get extensions
			$_html_extensions = array();

			$_html_extensions = explode(",", $GLOBALS["WE_CONTENT_TYPES"]["text/html"]["Extension"]);

			// Build static webEdition extensions select box
			$_static_html_extensions = new we_htmlSelect(array("name" => "DefaultHTMLExt","class"=>"weSelect"));
			foreach ($_html_extensions as $key=>$value) {
				$_static_html_extensions->addOption($value, $value);

				// Set selected extension
				if ($value == get_value("extension_html")) {
					$_static_html_extensions->selectOption($value);
				}
			}

			// Build final HTML code
			$_html_extensions_html = $l_prefs["html"] . "<br>" . $_static_html_extensions->getHtmlCode();

			// Build dialog element if user has permission
			if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
				array_push($_settings, array("headline" => $l_prefs["html_extensions"], "html" => $_html_extensions_html, "space" => 200, "noline" => 1));
			}

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
				$_dialog = create_dialog("", $l_prefs["tab_extensions"], $_settings);
			}

			break;

		case "editor":
			/*********************************************************************
			 * EDITOR PLUGIN
			 *********************************************************************/

			$_settings = array();


			// Create checkboxes
			/*********************************************************************
			 * TEMPLATE EDITOR
			 *********************************************************************/

			
			$_needed_JavaScript = '<script language="JavaScript" type="text/javascript">

function setJavaEditorDisabled(disabled) {
	document.getElementById("_specify_jeditor_colors").disabled = disabled;
	document.getElementById("label__specify_jeditor_colors").style.color = (disabled ? "gray" : "");
	document.getElementById("label__specify_jeditor_colors").style.cursor = (disabled ? "default" : "pointer");
	if (document.getElementById("_specify_jeditor_colors").checked) {
		setEditorColorsDisabled(disabled);
	} else {
		setEditorColorsDisabled(true);
	}
}
			
function setEditorColorsDisabled(disabled) {
	setColorChooserDisabled("editorFontcolor", disabled);
	setColorChooserDisabled("editorWeTagFontcolor", disabled);
	setColorChooserDisabled("editorWeAttributeFontcolor", disabled);
	setColorChooserDisabled("editorHTMLTagFontcolor", disabled);
	setColorChooserDisabled("editorHTMLAttributeFontcolor", disabled);
	setColorChooserDisabled("editorPiTagFontcolor", disabled);
	setColorChooserDisabled("editorCommentFontcolor", disabled);
}

function setColorChooserDisabled(id, disabled) {
	var td = document.getElementById("color_"+ id);
	td.setAttribute("class", disabled ? "disabled" : "");
	td.firstChild.style.cursor = disabled ? "default" : "pointer";
	document.getElementById("label_"+id).style.color=disabled ? "gray" : "";
}
			
			</script>';
			
			/**
			 * Information
			 */

			$_information = htmlAlertAttentionBox($l_prefs["editor_information"], 2, 480, false);

			array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));

			
			/**
			 * Editor font settings
			 */

            $_template_fonts = array("Courier New", "Courier", "mono", "Verdana", "Arial", "Helvetica", "Monaco", "serif", "sans-serif", "none");
            $_template_font_sizes = array(8, 9, 10, 11, 12, 14, 16, 18, 24, 32, 48, 72, -1);

			$_template_editor_font_specify = false;
			$_template_editor_font_size_specify = false;

			if (get_value("editor_font_name") != "" && get_value("editor_font_name") != "none") {
				$_template_editor_font_specify = true;
			}

			if (get_value("editor_font_size") != "" && get_value("editor_font_size") != -1) {
				$_template_editor_font_size_specify = true;
			}

			// Build specify font
			$_template_editor_font_specify_code = we_forms::checkbox(1, $_template_editor_font_specify, "editorFont", $l_prefs["specify"], true, "defaultfont", "if (document.getElementsByName('editorFont')[0].checked) { document.getElementsByName('editorFontname')[0].disabled = false;document.getElementsByName('editorFontsize')[0].disabled = false; } else { document.getElementsByName('editorFontname')[0].disabled = true;document.getElementsByName('editorFontsize')[0].disabled = true; }");

			


			$_template_editor_font_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => "editorFontname",  "size" => "1", "style" => "width: 135px;", ($_template_editor_font_specify ? "enabled" : "disabled") => ($_template_editor_font_specify ? "enabled" : "disabled")));

			$_colorsDisabled = get_value('specify_jeditor_colors') == 0  ||  get_value('use_jeditor') == 0;
			
			$_template_editor_fontcolor_selector = getColorInput("editorFontcolor",get_value("editor_font_color"), $_colorsDisabled);
			$_template_editor_we_tag_fontcolor_selector = getColorInput("editorWeTagFontcolor",get_value("editor_we_tag_font_color"), $_colorsDisabled);
			$_template_editor_we_attribute_fontcolor_selector = getColorInput("editorWeAttributeFontcolor",get_value("editor_we_attribute_font_color"), $_colorsDisabled);
			$_template_editor_html_tag_fontcolor_selector = getColorInput("editorHTMLTagFontcolor",get_value("editor_html_tag_font_color"), $_colorsDisabled);
			$_template_editor_html_attribute_fontcolor_selector = getColorInput("editorHTMLAttributeFontcolor",get_value("editor_html_attribute_font_color"), $_colorsDisabled);
			$_template_editor_pi_tag_fontcolor_selector = getColorInput("editorPiTagFontcolor",get_value("editor_pi_tag_font_color"), $_colorsDisabled);
			$_template_editor_comment_fontcolor_selector = getColorInput("editorCommentFontcolor",get_value("editor_comment_font_color"), $_colorsDisabled);
			
			for ($i = 0; $i < (count($_template_fonts) - 1); $i++) {
				$_template_editor_font_select_box->addOption($_template_fonts[$i], $_template_fonts[$i]);

                if (!$_template_editor_font_specify) {
                    if ($_template_fonts[$i] == "Courier New") {
				        $_template_editor_font_select_box->selectOption($_template_fonts[$i]);
				    }
				} else {
                    if ($_template_fonts[$i] == get_value("editor_font_name")) {
				        $_template_editor_font_select_box->selectOption($_template_fonts[$i]);

				    }
				}
			}

			$_template_editor_font_sizes_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => "editorFontsize",  "size" => "1", "style" => "width: 135px;", ($_template_editor_font_size_specify ? "enabled" : "disabled") => ($_template_editor_font_size_specify ? "enabled" : "disabled")));

			for ($i = 0; $i < (count($_template_font_sizes) - 1); $i++) {
				$_template_editor_font_sizes_select_box->addOption($_template_font_sizes[$i], $_template_font_sizes[$i]);

                if (!$_template_editor_font_specify) {
                    if ($_template_font_sizes[$i] == 11) {
				        $_template_editor_font_sizes_select_box->selectOption($_template_font_sizes[$i]);
				    }
				} else {
                    if ($_template_font_sizes[$i] == get_value("editor_font_size")) {
				        $_template_editor_font_sizes_select_box->selectOption($_template_font_sizes[$i]);

				    }
				}
			}
			
			$_attr = ' class="defaultfont" style="width:150px;"';
			$_attr_dis = ' class="defaultfont" style="width:150px;color:gray;"';
			
			$_template_editor_font_specify_table = '<table style="margin:0 0 20px 50px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td'.$_attr.'>' . $l_prefs["editor_fontname"] . '</td><td>' . $_template_editor_font_select_box->getHtmlCode() . '</td>
	</tr>
	<tr>
		<td'.$_attr.'>' . $l_prefs["editor_fontsize"] . '</td><td>' . $_template_editor_font_sizes_select_box->getHtmlCode() . '</td>
	</tr>
</table>';
			
			$_useJEditor = get_value('use_jeditor');
		
			$_template_editor_use_jeditor_checkbox = we_forms::checkboxWithHidden($_useJEditor, "use_jeditor", $l_prefs['use_jeditor'],false, "defaultfont","setJavaEditorDisabled(!this.checked);");
			
			$_template_editor_font_color_checkbox = we_forms::checkboxWithHidden(get_value('specify_jeditor_colors'), "specify_jeditor_colors", $l_prefs["editor_font_colors"],false,"defaultfont","setEditorColorsDisabled(!this.checked);",!$_useJEditor);

			
			
			$_template_editor_font_color_table = '<table id="editorColorTable" style="margin: 10px 0 0 50px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td id="label_editorFontcolor" '.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_normal_font_color"] . '</td><td>' . $_template_editor_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorWeTagFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_we_tag_font_color"] . '</td><td>' . $_template_editor_we_tag_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorWeAttributeFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_we_attribute_font_color"] . '</td><td>' . $_template_editor_we_attribute_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorHTMLTagFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_html_tag_font_color"] . '</td><td>' . $_template_editor_html_tag_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorHTMLAttributeFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_html_attribute_font_color"] . '</td><td>' . $_template_editor_html_attribute_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorPiTagFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_pi_tag_font_color"] . '</td><td>' . $_template_editor_pi_tag_fontcolor_selector . '</td>
	</tr>
	<tr>
		<td id="label_editorCommentFontcolor"'.($_colorsDisabled ? $_attr_dis : $_attr).'>' . $l_prefs["editor_comment_font_color"] . '</td><td>' . $_template_editor_comment_fontcolor_selector . '</td>
	</tr>
</table>';
			
			// Build dialog
			array_push($_settings, array("headline" => $l_prefs["editor_font"], "html" => $_template_editor_font_specify_code . $_template_editor_font_specify_table , "space" => 150));
			
			array_push($_settings, array("headline" => $l_prefs["jeditor"], "html" => $_template_editor_use_jeditor_checkbox . '<div style="height:10px"></div>' . $_template_editor_font_color_checkbox . $_template_editor_font_color_table, "space" => 150));
			
			//array_push($_settings, array('headline' => $l_prefs['use_jeditor'], 'html' => htmlSelect('use_jeditor',array($l_prefs["no"],$l_prefs["yes"]),1,get_value('use_jeditor')), "space" => 200));
			

			/**
			 * BUILD FINAL DIALOG
			 */
			$_settings_cookie = weGetCookieVariable("but_settings_editor_predefined");

			$_dialog = create_dialog("settings_editor_predefined", $l_prefs["tab_editor"], $_settings, 5, $l_prefs["show_predefined"], $l_prefs["hide_predefined"], $_settings_cookie, $_needed_JavaScript);

			break;

		case "recipients":
			/*********************************************************************
			 * FORMMAIL RECIPIENTS
			 *********************************************************************/

			$_settings = array();

			// Generate needed JS
			$_needed_JavaScript = "
						<script language=\"JavaScript\" type=\"text/javascript\"><!--
							var hot = false;

							" . (!we_hasPerm("CHANGE_START_DOCUMENT") ? $we_button->create_state_changer(false) : "") . "
							function set_state_edit_delete_recipient() {
								var p = document.forms[0].elements[\"we_recipient\"];
								var i = p.length;

								if (i == 0) {
									edit_enabled = switch_button_state('edit', 'edit_enabled', 'disabled');
									delete_enabled = switch_button_state('delete', 'delete_enabled', 'disabled');
								} else {
									edit_enabled = switch_button_state('edit', 'edit_enabled', 'enabled');
									delete_enabled = switch_button_state('delete', 'delete_enabled', 'enabled');
								}
							}

							function inSelectBox(val) {
								var p = document.forms[0].elements[\"we_recipient\"];

								for (var i = 0; i < p.options.length; i++) {
									if (p.options[i].text == val) {
										return true;
									}
								}
								return false;
							}

							function addElement(value, text, sel) {
								var p = document.forms[0].elements[\"we_recipient\"];
								var i = p.length;

								p.options[i] =  new Option(text, value);

								if (sel) {
									p.selectedIndex = i;
								}
							}

							function in_array(n, h) {
								for (var i = 0; i < h.length; i++) {
									if (h[i] == n) {
										return true;
									}
								}
								return false;
							}

							function add_recipient() {
								var newRecipient = prompt(\"" . $l_alert["input_name"] . "\", \"\");
								var p = document.forms[0].elements[\"we_recipient\"];

								if (newRecipient != null) {
									if (newRecipient.length > 0) {
										if (newRecipient.length > 255 ) {
											" . we_message_reporting::getShowMessageCall($l_alert["max_name_recipient"], WE_MESSAGE_ERROR) . "
											return;
										}

										if (!inSelectBox(newRecipient)) {
											addElement(\"#\", newRecipient, true);
											hot = true;

											set_state_edit_delete_recipient();
										} else {
											" . we_message_reporting::getShowMessageCall($l_alert["recipient_exists"], WE_MESSAGE_ERROR) . "
										}
									} else {
										" . we_message_reporting::getShowMessageCall($l_alert["not_entered_recipient"], WE_MESSAGE_ERROR) . "
									}
								}
							}

							function delete_recipient() {
								var p = document.forms[0].elements[\"we_recipient\"];

								if (p.selectedIndex >= 0) {
									if (confirm(\"" . $l_alert["delete_recipient"] . "\")) {
										hot = true;

										var d = document.forms[0].elements[\"formmail_deleted\"];

										d.value += ((d.value)  ? \",\" : \"\") + p.options[p.selectedIndex].value;
										p.options[p.selectedIndex] = null;

										set_state_edit_delete_recipient();
									}
								}
							}

							function edit_recipient() {
								var p = document.forms[0].elements[\"we_recipient\"];

								if (p.selectedIndex >= 0) {
									var editRecipient = p.options[p.selectedIndex].text;

									editRecipient = prompt(\"" . $l_alert["recipient_new_name"] . "\", editRecipient);
								}

								if (p.selectedIndex >= 0 && editRecipient != null) {
									if (editRecipient != \"\") {
										if (p.options[p.selectedIndex].text == editRecipient) {
											return;
										}

										if (editRecipient.length > 255 ) {
											" . we_message_reporting::getShowMessageCall($l_alert["max_name_recipient"], WE_MESSAGE_ERROR) . "
											return;
										}

										if (!inSelectBox(editRecipient)) {
											p.options[p.selectedIndex].text = editRecipient;
											hot = true;
										} else {
											" . we_message_reporting::getShowMessageCall($l_alert["recipient_exists"], WE_MESSAGE_ERROR) . "
										}
									} else {
										" . we_message_reporting::getShowMessageCall($l_alert["not_entered_recipient"], WE_MESSAGE_ERROR) . "
									}
								}
							}

							function send_recipients() {
								if (hot) {
									var p = document.forms[0].elements[\"we_recipient\"];
									var v = document.forms[0].elements[\"formmail_values\"];

									v.value = \"\";

									for (var i = 0; i < p.options.length; i++) {
										v.value += p.options[i].value + \"<#>\" + p.options[i].text + ( (i < (p.options.length -1 )) ? \"<##>\" : \"\");
									}
								}
							}

							function formmailLogOnOff() {
								var formmail_log = document.forms[0].elements[\"formmail_log\"];
								var formmail_block = document.forms[0].elements[\"formmail_block\"];
								var formmail_emptylog = document.forms[0].elements[\"formmail_emptylog\"];
								var formmail_span = document.forms[0].elements[\"formmail_span\"];
								var formmail_trials = document.forms[0].elements[\"formmail_trials\"];
								var formmail_blocktime = document.forms[0].elements[\"formmail_blocktime\"];

								var flag = formmail_log.options[formmail_log.selectedIndex].value == 1;

								formmail_emptylog.disabled = !flag;

								formmail_block.disabled = !flag;
								if (formmail_block.options[formmail_block.selectedIndex].value == 1) {
									formmail_span.disabled = !flag;
									formmail_trials.disabled = !flag;
									formmail_blocktime.disabled = !flag;
								}
							}
							function formmailBlockOnOff() {
								var formmail_block = document.forms[0].elements[\"formmail_block\"];
								var formmail_span = document.forms[0].elements[\"formmail_span\"];
								var formmail_trials = document.forms[0].elements[\"formmail_trials\"];
								var formmail_blocktime = document.forms[0].elements[\"formmail_blocktime\"];

								var flag = formmail_block.options[formmail_block.selectedIndex].value == 1;

								formmail_span.disabled = !flag;
								formmail_trials.disabled = !flag;
								formmail_blocktime.disabled = !flag;
							}
						//-->
						</script>";

			/**
			 * Information
			 */

			$_information = htmlAlertAttentionBox($l_prefs["formmail_information"], 2, 450, false);

			// Build dialog if user has permission
			if (we_hasPerm("FORMMAIL")) {
				array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));
			}

			/**
			 * Recipients list
			 */

			$_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => "we_recipient",  "size" => "10", "style" => "width: 340px;height:100px", "ondblclick" => "edit_recipient();"));

			$_enabled_buttons = false;

			$DB_WE->query("SELECT ID, Email FROM " . RECIPIENTS_TABLE . " ORDER BY Email");

			while ($DB_WE->next_record()) {
				$_enabled_buttons = true;
				$_select_box->addOption($DB_WE->f("ID"), $DB_WE->f("Email"));
			}

			// Create needed hidden fields
			$_hidden_fields  = we_htmlElement::htmlHidden(array("name" => "formmail_values", "value" => ""));
			$_hidden_fields .= we_htmlElement::htmlHidden(array("name" => "formmail_deleted", "value" => ""));

			// Create edit list
			$_editlist_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 2, 3);

			$_editlist_table->setCol(0, 0, null, $_hidden_fields . $_select_box->getHtmlCode());
			$_editlist_table->setCol(0, 1, null, getPixel(10, 1));
			$_editlist_table->setCol(0, 2, array("valign" => "top"), $we_button->create_button("add", "javascript:add_recipient();") . getPixel(1, 10) . $we_button->create_button("edit", "javascript:edit_recipient();", true, 100, 22, "", "", !$_enabled_buttons, false) . getPixel(1, 10) . $we_button->create_button("delete", "javascript:delete_recipient();", true, 100, 22, "", "", !$_enabled_buttons, false));

			// Build dialog if user has permission
			if (we_hasPerm("FORMMAIL")) {
				array_push($_settings, array("headline" => "", "html" => $_editlist_table->getHtmlCode(), "space" => 0));
			}

			// formmail stuff


			if (we_hasPerm("ADMINISTRATOR")) {
				$_formmail_confirm = new we_htmlSelect(array("name" => "formmail_confirm","style"=>"width:88px;","class"=>"weSelect"));
				$_formmail_confirm->addOption(1,$l_prefs["on"]);
				$_formmail_confirm->addOption(0,$l_prefs["off"]);
				if(get_value("formmail_confirm")){
				    $_formmail_confirm->selectOption(1);
				} else {
				    $_formmail_confirm->selectOption(0);
				}

				array_push($_settings, array('html' => $_formmail_confirm->getHtmlCode() , "space" => 250,"headline"=>$l_prefs["formmailConfirm"]));

				$_formmail_log = new we_htmlSelect(array("name" => "formmail_log","onchange"=>"formmailLogOnOff()","style"=>"width:88px;","class"=>"weSelect"));
				$_formmail_log->addOption(1,$l_prefs["yes"]);
				$_formmail_log->addOption(0,$l_prefs["no"]);
				if(get_value("formmail_log")){
				    $_formmail_log->selectOption(1);
				} else {
				    $_formmail_log->selectOption(0);
				}

				$_html = '<table border="0" cellpading="0" cellspacing="0">
							<tr>
								<td>'.$_formmail_log->getHtmlCode() . '</td>
								<td style="padding-left:10px;">' . $we_button->create_button("logbook",'javascript:we_cmd(\'show_formmail_log\')') . '</td>
							</tr>
						</table>';
				array_push($_settings, array('html' => $_html, "space" => 250,"headline"=>$l_prefs["logFormmailRequests"],"noline"=>1));

				$_isDisabled = (get_value("formmail_log") == 0);


				$_formmail_emptylog = new we_htmlSelect(array("name" => "formmail_emptylog","style"=>"width:88px;","class"=>"weSelect"));
				if ($_isDisabled) {
					$_formmail_emptylog->setAttribute("disabled","disabled");
				}
				$_formmail_emptylog->addOption(-1,$l_prefs["never"]);
				$_formmail_emptylog->addOption(86400,$l_prefs["1_day"]);
				$_formmail_emptylog->addOption(172800, sprintf($l_prefs["more_days"],2));
				$_formmail_emptylog->addOption(345600,sprintf($l_prefs["more_days"],4));
				$_formmail_emptylog->addOption(604800,$l_prefs["1_week"]);
				$_formmail_emptylog->addOption(1209600,sprintf($l_prefs["more_weeks"],2));
				$_formmail_emptylog->addOption(2419200,sprintf($l_prefs["more_weeks"],4));
				$_formmail_emptylog->addOption(4838400,sprintf($l_prefs["more_weeks"],8));
				$_formmail_emptylog->addOption(9676800,sprintf($l_prefs["more_weeks"],16));
				$_formmail_emptylog->addOption(19353600,sprintf($l_prefs["more_weeks"],32));

				$_formmail_emptylog->selectOption(get_value("formmail_emptylog"));


				array_push($_settings, array('html' => $_formmail_emptylog->getHtmlCode(), "space" => 250,"headline"=>$l_prefs["deleteEntriesOlder"]));

				////////////////////////////////
				// formmail only via we doc //
				////////////////////////////////
				$_formmail_ViaWeDoc = new we_htmlSelect(array("name" => "formmail_ViaWeDoc","style"=>"width:88px;","class"=>"weSelect"));
				$_formmail_ViaWeDoc->addOption(1,$l_prefs["yes"]);
				$_formmail_ViaWeDoc->addOption(0,$l_prefs["no"]);
				if(get_value("formmail_ViaWeDoc")){
				    $_formmail_ViaWeDoc->selectOption(1);
				} else {
				    $_formmail_ViaWeDoc->selectOption(0);
				}

				array_push($_settings, array('html' => $_formmail_ViaWeDoc->getHtmlCode() , "space" => 250,"headline"=>$l_prefs["formmailViaWeDoc"]));

				/////////////////////////////
				// limit formmail requests //
				/////////////////////////////
				$_formmail_block = new we_htmlSelect(array("name" => "formmail_block","onchange"=>"formmailBlockOnOff()","style"=>"width:88px;","class"=>"weSelect"));
				if ($_isDisabled) {
					$_formmail_block->setAttribute("disabled","disabled");
				}
				$_formmail_block->addOption(1,$l_prefs["yes"]);
				$_formmail_block->addOption(0,$l_prefs["no"]);
				if(get_value("formmail_block")){
				    $_formmail_block->selectOption(1);
				} else {
				    $_formmail_block->selectOption(0);
				}

				$_html = '<table border="0" cellpading="0" cellspacing="0">
							<tr>
								<td>'.$_formmail_block->getHtmlCode() . '</td>
								<td style="padding-left:10px;">' . $we_button->create_button("logbook",'javascript:we_cmd(\'show_formmail_block_log\')') . '</td>
							</tr>
						</table>';

				array_push($_settings, array('html' => $_html, "space" => 250,"headline"=>$l_prefs["blockFormmail"],"noline"=>1));

				$_isDisabled = $_isDisabled || (get_value("formmail_block") == 0);

				// table is IE fix. Without table IE has a gap on the left of the input
				$_formmail_trials = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.
						htmlTextInput("formmail_trials",24,get_value("formmail_trials"),"","","text",88,0,"",$_isDisabled).
						'</td></tr></table>';

				array_push($_settings, array('html' => $_formmail_trials, "space" => 250,"headline"=>$l_prefs["formmailTrials"],"noline"=>1));

				if (!$_isDisabled) {
					$_isDisabled = (get_value("formmail_block") == 0);
				}

				$_formmail_span = new we_htmlSelect(array("name" => "formmail_span","style"=>"width:88px;","class"=>"weSelect"));
				if ($_isDisabled) {
					$_formmail_span->setAttribute("disabled","disabled");
				}
				$_formmail_span->addOption(60,$l_prefs["1_minute"]);
				$_formmail_span->addOption(120,sprintf($l_prefs["more_minutes"],2));
				$_formmail_span->addOption(180,sprintf($l_prefs["more_minutes"],3));
				$_formmail_span->addOption(300,sprintf($l_prefs["more_minutes"],5));
				$_formmail_span->addOption(600,sprintf($l_prefs["more_minutes"],10));
				$_formmail_span->addOption(1200,sprintf($l_prefs["more_minutes"],20));
				$_formmail_span->addOption(1800,sprintf($l_prefs["more_minutes"],30));
				$_formmail_span->addOption(2700,sprintf($l_prefs["more_minutes"],45));
				$_formmail_span->addOption(3600,$l_prefs["1_hour"]);
				$_formmail_span->addOption(7200,sprintf($l_prefs["more_hours"],2));
				$_formmail_span->addOption(14400,sprintf($l_prefs["more_hours"],4));
				$_formmail_span->addOption(28800,sprintf($l_prefs["more_hours"],8));
				$_formmail_span->addOption(86400,sprintf($l_prefs["more_hours"],24));

				$_formmail_span->selectOption(get_value("formmail_span"));


				array_push($_settings, array('html' => $_formmail_span->getHtmlCode(), "space" => 250,"headline"=>$l_prefs["formmailSpan"],"noline"=>1));
				$_formmail_blocktime = new we_htmlSelect(array("name" => "formmail_blocktime","style"=>"width:88px;","class"=>"weSelect"));
				if ($_isDisabled) {
					$_formmail_blocktime->setAttribute("disabled","disabled");
				}
				$_formmail_blocktime->addOption(60,$l_prefs["1_minute"]);
				$_formmail_blocktime->addOption(120,sprintf($l_prefs["more_minutes"],2));
				$_formmail_blocktime->addOption(180,sprintf($l_prefs["more_minutes"],3));
				$_formmail_blocktime->addOption(300,sprintf($l_prefs["more_minutes"],5));
				$_formmail_blocktime->addOption(600,sprintf($l_prefs["more_minutes"],10));
				$_formmail_blocktime->addOption(1200,sprintf($l_prefs["more_minutes"],20));
				$_formmail_blocktime->addOption(1800,sprintf($l_prefs["more_minutes"],30));
				$_formmail_blocktime->addOption(2700,sprintf($l_prefs["more_minutes"],45));
				$_formmail_blocktime->addOption(3600,$l_prefs["1_hour"]);
				$_formmail_blocktime->addOption(7200,sprintf($l_prefs["more_hours"],2));
				$_formmail_blocktime->addOption(14400,sprintf($l_prefs["more_hours"],4));
				$_formmail_blocktime->addOption(28800,sprintf($l_prefs["more_hours"],8));
				$_formmail_blocktime->addOption(86400,sprintf($l_prefs["more_hours"],24));
				$_formmail_blocktime->addOption(-1,$l_prefs["ever"]);

				$_formmail_blocktime->selectOption(get_value("formmail_blocktime"));


				array_push($_settings, array('html' => $_formmail_blocktime->getHtmlCode(), "space" => 250,"headline"=>$l_prefs["blockFor"],"noline"=>1));

			}

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			if (we_hasPerm("FORMMAIL")) {
				$_dialog = create_dialog("", $l_prefs["formmail_recipients"], $_settings, -1, "", "", false, $_needed_JavaScript);
			}

			break;

		case "active_integrated_modules":

			$_settings = array();

			/*****************************************************************
			 * Information
			 *****************************************************************/

			$_information = htmlAlertAttentionBox($l_prefs["module_activation"]["information"], 2, 450, false);

			// Build dialog if user has permission
			array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));


			/*****************************************************************
			 * Information
			 *****************************************************************/

			$_modInfos = weModuleInfo::getIntegratedModules();

			$_html = "";

			foreach ($_modInfos as $_modKey => $_modInfo) {

				$_html .= we_forms::checkbox($_modKey, $_modInfo["alwaysActive"] || in_array($_modKey, $GLOBALS["_we_active_modules"]), "active_integrated_modules[$_modKey]", $_modInfo["text"], false, "defaultfont", "", $_modInfo["alwaysActive"]) . ($_modInfo["alwaysActive"] ? "<input type=\"hidden\" name=\"active_integrated_modules[$_modKey]\" value=\"$_modKey\" />" : "" ) . "<br />";

			}

			// Build dialog element if users has permission
			array_push($_settings, array("headline" => $l_prefs["module_activation"]["headline"], "html" => $_html, "space" => 200));


			$_dialog = create_dialog("", $l_prefs["module_activation"]["headline"], $_settings, -1);


		break;

		case "proxy":
			/*********************************************************************
			 * PROXY SERVER
			 *********************************************************************/

			$_settings = array();

			/**
			 * Proxy server
			 */

			// Generate needed JS
			$_needed_JavaScript = "
						<script language=\"JavaScript\" type=\"text/javascript\"><!--
							function set_state() {
								if (document.getElementsByName('useproxy')[0].checked == true) {
									_new_state = false;
								} else {
									_new_state = true;
								}

								document.getElementsByName('proxyhost')[0].disabled = _new_state;
								document.getElementsByName('proxyport')[0].disabled = _new_state;
								document.getElementsByName('proxyuser')[0].disabled = _new_state;
								document.getElementsByName('proxypass')[0].disabled = _new_state;
							}
						//-->
						</script>";

			/**
			 * Information
			 */

			$_information = htmlAlertAttentionBox($l_prefs["proxy_information"], 2, 450, false);

			array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));


			// Check Proxy settings  ...
			$_proxy = get_value("proxy_proxy");
			$_proxy_host = get_value("proxy_host");
			$_proxy_port = get_value("proxy_port");
			$_proxy_user = get_value("proxy_user");
			$_proxy_pass = get_value("proxy_password");

			$_use_proxy = we_forms::checkbox(1, $_proxy, "useproxy", $l_prefs["useproxy"], false, "defaultfont", "set_state();");

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["tab_proxy"], "html" => $_use_proxy, "space" => 200));
			}

			/**
			 * Address
			 */

			$_proxyaddr = htmlTextInput("proxyhost", 22, $_proxy_host, "", "", "text", 225, 0, "", !$_proxy);

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["proxyaddr"], "html" => $_proxyaddr, "space" => 200, "noline" => 1));
			}

			/**
			 * Port
			 */

			$_proxyport = htmlTextInput("proxyport", 22, $_proxy_port, "", "", "text", 225, 0, "", !$_proxy);

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["proxyport"], "html" => $_proxyport, "space" => 200, "noline" => 1));
			}

			/**
			 * User name
			 */

			$_proxyuser = htmlTextInput("proxyuser", 22, $_proxy_user, "", "", "text", 225, 0, "", !$_proxy);

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["proxyuser"], "html" => $_proxyuser, "space" => 200, "noline" => 1));
			}

			/**
			 * Password
			 */

			$_proxypass = htmlTextInput("proxypass", 22, $_proxy_pass, "", "", "password", 225, 0, "", !$_proxy);

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["proxypass"], "html" => $_proxypass, "space" => 200, "noline" => 1));
			}

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				$_dialog = create_dialog("", $l_prefs["tab_proxy"], $_settings, -1, "", "", false, $_needed_JavaScript);
			}

			break;

		case "advanced":
			/*********************************************************************
			 * ATTRIBS
			 *********************************************************************/

			$_settings = array();
			$_needed_JavaScript = "";
			/**
			 * PHP setting
			 */

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				// Build select box
				$_php_setting = new we_htmlSelect(array("name" => "we_php_default","class"=>"weSelect"));
				for ($i = 0; $i < 2; $i++) {
					$_php_setting->addOption($i, $i == 0 ? "false" : "true");

					// Set selected setting
					if ($i == 0 && !get_value("we_php_default")) {
						$_php_setting->selectOption($i);
					} else if ($i == 1 && get_value("we_php_default")) {
						$_php_setting->selectOption($i);
					}
				}
				array_push($_settings, array("headline" => $l_prefs["default_php_setting"], "html" => $_php_setting->getHtmlCode(), "space" => 200));


			}


			/**
			 * inlineedit setting
			 */

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				// Build select box
				$_php_setting = new we_htmlSelect(array("name" => "inlineedit_default","class"=>"weSelect"));
				for ($i = 0; $i < 2; $i++) {
					$_php_setting->addOption($i, $i == 0 ? "false" : "true");

					// Set selected setting
					if ($i == 0 && !get_value("inlineedit_default")) {
						$_php_setting->selectOption($i);
					} else if ($i == 1 && get_value("inlineedit_default")) {
						$_php_setting->selectOption($i);
					}
				}

				array_push($_settings, array("headline" => ( (defined('ISP_VERSION') && ISP_VERSION) ? $l_prefs["inlineedit_default_isp"] : $l_prefs["inlineedit_default"]), "html" => $_php_setting->getHtmlCode(), "space" => ( (defined('ISP_VERSION') && ISP_VERSION) ? 350 : 200)));
			}

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				// Build select box
				$_php_setting = new we_htmlSelect(array("name" => "safari_wysiwyg","class"=>"weSelect"));
				for ($i = 0; $i < 2; $i++) {
					$_php_setting->addOption($i, $i == 0 ? "false" : "true");

					// Set selected setting
					if ($i == 0 && !get_value("safari_wysiwyg")) {
						$_php_setting->selectOption($i);
					} else if ($i == 1 && get_value("safari_wysiwyg")) {
						$_php_setting->selectOption($i);
					}
				}

				array_push($_settings, array("headline" => $l_prefs["safari_wysiwyg"], "html" => $_php_setting->getHtmlCode(), "space" => 200));
			}

            // Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				// Build select box
				$_php_setting = new we_htmlSelect(array("name" => "showinputs_default","class"=>"weSelect"));
				for ($i = 0; $i < 2; $i++) {
					$_php_setting->addOption($i, $i == 0 ? "false" : "true");

					// Set selected setting
					if ($i == 0 && !get_value("showinputs_default")) {
						$_php_setting->selectOption($i);
					} else if ($i == 1 && get_value("showinputs_default")) {
						$_php_setting->selectOption($i);
					}
				}

				array_push($_settings, array("headline" => $l_prefs["showinputs_default"], "html" => $_php_setting->getHtmlCode(), "space" => 200));

				$_we_doctype_workspace_behavior = abs(get_value("we_doctype_workspace_behavior"));
				$_we_doctype_workspace_behavior_table = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.
				we_forms::radiobutton("0",($_we_doctype_workspace_behavior == "0"),"we_doctype_workspace_behavior",$l_prefs["we_doctype_workspace_behavior_0"],true,"defaultfont","",false,$l_prefs["we_doctype_workspace_behavior_hint0"],0,430).
				'</td></tr><tr><td style="padding-top:10px;">'.
				we_forms::radiobutton("1",($_we_doctype_workspace_behavior == "1"),"we_doctype_workspace_behavior",$l_prefs["we_doctype_workspace_behavior_1"],true,"defaultfont","",false,$l_prefs["we_doctype_workspace_behavior_hint1"],0,430).
				'</td></tr></table>';


				array_push($_settings, array("headline" => $l_prefs["we_doctype_workspace_behavior"], "html" => $_we_doctype_workspace_behavior_table, "space" => 200));
			}



			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				$_dialog = create_dialog("", $l_prefs["tab_advanced"], $_settings, -1, "", "", null, $_needed_JavaScript);
			}

			break;

		case "system":
			/*********************************************************************
			 * ATTRIBS
			 *********************************************************************/

			if (we_hasPerm("ADMINISTRATOR") && !(defined("ISP_VERSION") && ISP_VERSION) ) {
				$_settings = array();
				$_needed_JavaScript = "";

				$_we_max_upload_size = abs(get_value("we_max_upload_size"));
    			$_we_max_upload_size = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.
    							htmlTextInput("we_max_upload_size", 22, $_we_max_upload_size, "", ' onkeypress="return IsDigit(event);"', "text", 60).'</td><td style="padding-left:20px;" class="small">'.
    							$l_prefs["we_max_upload_size_hint"].
    							'</td></tr></table>';
				array_push($_settings, array("headline" => $l_prefs["we_max_upload_size"], "html" => $_we_max_upload_size, "space" => 200));
				$_needed_JavaScript .= '<script type="text/javascript">function IsDigit(e) {
					var key;

					if (e != null && e.charCode) {
						key = e.charCode;
					} else {
						key = event.keyCode;
					}

					return (((key >= 48) && (key <= 57)) || (key == 0) || (key == 13));
				}
				</script>';

				$_we_new_folder_mod = get_value("we_new_folder_mod");
    			$_we_new_folder_mod = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.
    							htmlTextInput("we_new_folder_mod", 22, $_we_new_folder_mod, 3, ' onkeypress="return IsDigit(event);"', "text", 60).'</td><td style="padding-left:20px;" class="small">'.
    							$l_prefs["we_new_folder_mod_hint"].
    							'</td></tr></table>';
				array_push($_settings, array("headline" => $l_prefs["we_new_folder_mod"], "html" => $_we_new_folder_mod, "space" => 200));

				// Build db select box
				$_db_connect = new we_htmlSelect(array("name" => "db_connect", "class" => "weSelect"));
				for ($i = 0; $i < 2; $i++) {
					$_db_connect->addOption($i, $i == 0 ? "connect" : "pconnect");

					// Set selected setting
					if ($i == 0 && DB_CONNECT == "connect") {
						$_db_connect->selectOption($i);
					} else if ($i == 1 && DB_CONNECT == "pconnect") {
						$_db_connect->selectOption($i);
					}
				}
				array_push($_settings, array("headline" => $l_prefs["db_connect"], "html" => $_db_connect->getHtmlCode(), "space" => 200));

				$jUploadDisabled = !file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/jupload/jupload.jar');
				
				
				array_push($_settings, array('headline' => $l_prefs['use_jupload'], 'html' => htmlSelect('use_jupload',array($l_prefs["no"],$l_prefs["yes"]),1,get_value('use_jupload'),false,$jUploadDisabled ? "disabled=\"disabled\"" : "") . ($jUploadDisabled ? '<span class="small" style="margin-left:30px;">('.$l_prefs['juplod_not_installed'].')</span>' : ""), "space" => 200));

				// Generate needed JS
				$_needed_JavaScript .= "
						<script language=\"JavaScript\" type=\"text/javascript\"><!--
							function set_state_auth() {
								if (document.getElementsByName('useauthEnabler')[0].checked == true) {
                                    document.getElementsByName('useauth')[0].value = 1;
									_new_state = false;
								} else {
                                    document.getElementsByName('useauth')[0].value = 0;
									_new_state = true;
								}

								document.getElementsByName('authuser')[0].disabled = _new_state;
								document.getElementsByName('authpass')[0].disabled = _new_state;
							}
						//-->
						</script>";

				// Check authentication settings  ...
				$_auth = get_value("auth_auth");
				$_auth_user = get_value("auth_user");
				$_auth_pass = get_value("auth_password");

    			// Build dialog if user has permission
     			$_use_auth = hidden('useauth', $_auth);
    			$_use_auth .= we_forms::checkbox(1, $_auth, "useauthEnabler", $l_prefs["useauth"], false, "defaultfont", "set_state_auth();");
    			array_push($_settings, array("headline" => $l_prefs["auth"], "html" => $_use_auth, "space" => 200, "noline" => 1));

    			/**
    			 * User name
    			 */


     			$_authuser = htmlTextInput("authuser", 22, $_auth_user, "", "", "text", 225, 0, "", !$_auth);
    			array_push($_settings, array("headline" => $l_prefs["authuser"], "html" => $_authuser, "space" => 200, "noline" => 1));

    			/**
    			 * Password
    			 */


    			$_authpass = htmlTextInput("authpass", 22, $_auth_pass, "", "", "password", 225, 0, "", !$_auth);
    			array_push($_settings, array("headline" => $l_prefs["authpass"], "html" => $_authpass, "space" => 200));

			    include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_classes/base/we_image_edit.class.php');

			    if( we_image_edit::gd_version() > 0 ){   //  gd lib ist installiert

			        $_but     = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button("select", "javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'thumbnail_dir\\'].value', 'folder', document.forms[0].elements['thumbnail_dir'].value, '')") : "";
				    $_inp = htmlTextInput("thumbnail_dir", 12, get_value("thumbnail_dir"), "", "", "text", 125);
                    $_thumbnail_dir = $we_button->create_button_table(array($_inp,$_but));

			    } else {                                 //  gd lib ist nicht installiert

			        include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
			        $_but     = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button("select", "#", true, 100, 22,'','', true) : "";
				    $_inp = htmlTextInput("thumbnail_dir", 12, get_value("thumbnail_dir"), "", "", "text", 125,'0','',true);
                    $_thumbnail_dir = $we_button->create_button_table(array($_inp,$_but)) . '<br/>' . $l_thumbnails["add_description_nogdlib"];
			    }

			    array_push($_settings, array("headline" => $l_prefs["thumbnail_dir"], "html" => $_thumbnail_dir, "space" => 200));

			    /**
			     * set pageLogger dir
			     */ 
			    $_but     = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button("select", "javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'we_tracker_dir\\'].value', 'folder', document.forms[0].elements['we_tracker_dir'].value, '')") : "";
				$_inp = htmlTextInput("we_tracker_dir", 12, get_value("we_tracker_dir"), "", "", "text", 125);
                $_we_tracker_dir = $we_button->create_button_table(array($_inp,$_but));
			    array_push($_settings, array("headline" => $l_prefs["pagelogger_dir"], "html" => $_we_tracker_dir, "space" => 200));
			    
			    /**
			     * econda settings
			     * 
			     * @todo move the language vars to lang.../prefs.inc.php
			     */
                //$l_prefs["econda_information"] = "econda ist der Spezialist für erfolgreiches Web Shop Controlling. <br><a href='http://www.econda.de/ssa/shop.php' onclick='window.open(this.href,\"econda\",\"width=800,height=600,resizable=yes,menubar=yes,scrollbars=yes,status=yes,toolbar=yes\"); return false'>Online-Antrag</a>";
			    $l_prefs["econda_information"] = "Info text for ECONDA is following.";
				$l_prefs["econda_enable"] = "activate ECONDA";
                 // Generate needed JS
                $_needed_JavaScript .= "
                        <script language=\"JavaScript\" type=\"text/javascript\"><!--
                            function set_state_econda() {
                                if (document.getElementsByName('useEcondaEnabler')[0].checked == true) {
                                    document.getElementsByName('we_econda_stat')[0].value = 1;
                                    document.getElementsByName('we_econda_path')[0].disabled = false;
                                } else {
                                    document.getElementsByName('we_econda_stat')[0].value = 0;
                                    document.getElementsByName('we_econda_path')[0].disabled = true;
                                    document.getElementsByName('we_econda_path')[0].value = '';
                                    document.getElementsByName('we_econda_id')[0].value = 0;
			                     }
 			                }
                             
			                function selectEcondaJsFile() {
                                myWind = false;

                                for (k = parent.opener.top.jsWindow_count; k > -1; k--) {
                                    eval(\"if (parent.opener.top.jsWindow\" + k + \"Object) {\" +
                                         \" if (parent.opener.top.jsWindow\" + k + \"Object.ref == 'preferences') {\" +
                                         \"     myWind = parent.opener.top.jsWindow\" + k + \"Object.wind;\" +
                                         \"     myWindStr = 'top.jsWindow\" + k + \"Object.wind';\" +
                                         \" }\" +
                                         \"}\");
                                    if (myWind) {
                                       break;
                                    }
                                }
                                parent.opener.top.we_cmd('openDocselector', myWind.frames['we_preferences'].document.forms[0].elements['we_econda_id'].value, '" . FILE_TABLE . "', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'we_econda_id\'].value', myWindStr + '.frames[\'we_preferences\'].document.forms[0].elements[\'we_econda_path\'].value', '', '" . session_id() . "', '', 'text/js',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");
                           }
                                
                           //-->
                        </script>";
                $econdaHtml = htmlAlertAttentionBox($l_prefs["econda_information"], 2, 240, false)."<br>";

                $econdaHtml .= hidden('we_econda_stat', get_value("we_econda_stat"));
               
                $econdaHtml .= we_forms::checkbox(1, get_value("we_econda_stat"), "useEcondaEnabler", $l_prefs["econda_enable"], false, "defaultfont", "set_state_econda()");

                $yuiSuggest->setAcId("Econda");
                $yuiSuggest->setContentType("folder,text/js");
                $yuiSuggest->setInput("we_econda_path", get_value("we_econda_path"));
                $yuiSuggest->setMaxResults(20);
                $yuiSuggest->setMayBeEmpty(true);
                $yuiSuggest->setResult("we_econda_id", get_value("we_econda_id"));
                $yuiSuggest->setSelector("Docselector");
                $yuiSuggest->setWidth(125);
                $yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:selectEcondaJsFile()", true, 100, 22, "", "", "", false),10);
                $yuiSuggest->setContainerWidth(234);
                        
                $econdaHtml .= $yuiSuggest->getHTML();
                array_push($_settings, array("headline" => "econda", "html" => $econdaHtml, "space" => 200));
			    
				// Build dialog element if user has permission
				$_dialog = create_dialog("", $l_prefs["tab_system"], $_settings, -1, "", "", null, $_needed_JavaScript);
			}

			break;
		case "error_handling":
			/*********************************************************************
			 * ERROR TYPES
			 *********************************************************************/

			$_settings = array();

			// Generate needed JS
			$_needed_JavaScript = "
						<script language=\"JavaScript\" type=\"text/javascript\"><!--
							function set_state_mail() {
								if (document.getElementsByName('error_mail_errors')[0].checked == true) {
									if (document.getElementsByName('error_mail_errors')[0].disabled == false) {
										_new_state = false;
									} else {
										_new_state = true;
									}
								} else {
									_new_state = true;
								}

								document.getElementsByName('error_mail_address')[0].disabled = _new_state;
							}

							function set_state_error_handler() {
								if (document.getElementsByName('we_error_handler')[0].checked == true) {
									_new_state = false;
									_new_style = 'black';
									_new_cursor = document.all ? 'hand' : 'pointer';
								} else {
									_new_state = true;
									_new_style = 'gray';
									_new_cursor = '';
								}

								document.getElementsByName('error_handling_notices')[0].disabled = _new_state;
								document.getElementsByName('error_handling_warnings')[0].disabled = _new_state;
								document.getElementsByName('error_handling_errors')[0].disabled = _new_state;

								document.getElementById('label_error_handling_notices').style.color = _new_style;
								document.getElementById('label_error_handling_warnings').style.color = _new_style;
								document.getElementById('label_error_handling_errors').style.color = _new_style;

								document.getElementById('label_error_handling_notices').style.cursor = _new_cursor;
								document.getElementById('label_error_handling_warnings').style.cursor = _new_cursor;
								document.getElementById('label_error_handling_errors').style.cursor = _new_cursor;

								document.getElementsByName('error_display_errors')[0].disabled = _new_state;
								document.getElementsByName('error_log_errors')[0].disabled = _new_state;
								document.getElementsByName('error_mail_errors')[0].disabled = _new_state;

								document.getElementById('label_error_display_errors').style.color = _new_style;
								document.getElementById('label_error_log_errors').style.color = _new_style;
								document.getElementById('label_error_mail_errors').style.color = _new_style;

								document.getElementById('label_error_display_errors').style.cursor = _new_cursor;
								document.getElementById('label_error_log_errors').style.cursor = _new_cursor;
								document.getElementById('label_error_mail_errors').style.cursor = _new_cursor;

								set_state_mail();
							}
						//-->
						</script>";

			/**
			 * Error handler
			 */
			$_foldAt = 4;

			if (defined('OBJECT_TABLE') && we_hasPerm('ADMINISTRATOR')) {
				$_foldAt++;
				$_acButton1 = $we_button->create_button('select', "javascript:we_cmd('openDocselector', document.forms[0].elements['error_document_no_objectfile'].value, '" . FILE_TABLE . "', 'document.forms[0].elements[\\'error_document_no_objectfile\\'].value', 'document.forms[0].elements[\\'error_document_no_objectfile_text\\'].value', '', '" . session_id() . "', '', 'text/webEdition', 1)");
				$_acButton2 = $we_button->create_button('image:function_trash', 'javascript:document.forms[0].elements[\'error_document_no_objectfile\'].value = 0;document.forms[0].elements[\'error_document_no_objectfile_text\'].value = \'\'');
		
				$yuiSuggest->setAcId("doc2");
				$yuiSuggest->setContentType("folder,text/webEdition,text/html");
				$yuiSuggest->setInput('error_document_no_objectfile_text', ( (defined('ERROR_DOCUMENT_NO_OBJECTFILE') && ERROR_DOCUMENT_NO_OBJECTFILE) ? id_to_path(ERROR_DOCUMENT_NO_OBJECTFILE) : '' ));
				$yuiSuggest->setMaxResults(20);
				$yuiSuggest->setMayBeEmpty(true);
				$yuiSuggest->setResult('error_document_no_objectfile', ( (defined('ERROR_DOCUMENT_NO_OBJECTFILE') && ERROR_DOCUMENT_NO_OBJECTFILE) ? ERROR_DOCUMENT_NO_OBJECTFILE : 0 ));
				$yuiSuggest->setSelector("Docselector");
				$yuiSuggest->setWidth(300);
				$yuiSuggest->setSelectButton($_acButton1,10);
				$yuiSuggest->setTrashButton($_acButton2,4);
				
				array_push($_settings, array('headline' => $l_prefs['error_no_object_found'], 'html' => $yuiSuggest->getHTML(), 'space' => 0));
			}

			// Create checkboxes
			$_disable_template_tag_check = we_forms::checkbox(1, get_value("disable_template_tag_check"), "disable_template_tag_check", $l_prefs["disable_template_tag_check"]);

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["templates"], "html" => $_disable_template_tag_check, "space" => 200));
			}

			// Create checkboxes
			$_we_error_handler = we_forms::checkbox(1, get_value("we_error_handler"), "we_error_handler", $l_prefs["error_use_handler"], false, "defaultfont", "set_state_error_handler();");

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["tab_error_handling"], "html" => $_we_error_handler, "space" => 200));
			}

			/**
			 * Error types
			 */

			// Create checkboxes
			$_error_handling_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 7, 1);

			$_error_handling_table->setCol(0, 0, null, we_forms::checkbox(1, get_value("error_handling_errors"), "error_handling_errors", $l_prefs["error_errors"], false, "defaultfont", "", !get_value("we_error_handler")));
			$_error_handling_table->setCol(1, 0, null, getPixel(1, 5));
			$_error_handling_table->setCol(2, 0, null, we_forms::checkbox(1, get_value("error_handling_warnings"), "error_handling_warnings", $l_prefs["error_warnings"], false, "defaultfont", "", !get_value("we_error_handler")));
			$_error_handling_table->setCol(3, 0, null, getPixel(1, 5));
			$_error_handling_table->setCol(4, 0, null, we_forms::checkbox(1, get_value("error_handling_notices"), "error_handling_notices", $l_prefs["error_notices"], false, "defaultfont", "", !get_value("we_error_handler")));
			$_error_handling_table->setCol(5, 0, null, getPixel(1, 5));
			$_error_handling_table->setCol(6, 0, array('class' => 'defaultfont', 'style' => 'padding-left: 25px;'), htmlAlertAttentionBox($l_prefs['error_notices_warning'],1,220));


			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["error_types"], "html" => $_error_handling_table->getHtmlCode(), "space" => 200));
			}

			/*********************************************************************
			 * ERROR DISPLAY
			 *********************************************************************/

			// Create checkboxes
			$_error_display_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 7, 1);

			$_error_display_table->setCol(0, 0, null, we_forms::checkbox(1, get_value("error_display_errors"), "error_display_errors", $l_prefs["error_display"], false, "defaultfont", "", !get_value("we_error_handler")));
			$_error_display_table->setCol(1, 0, null, getPixel(1, 5));
			$_error_display_table->setCol(2, 0, null, we_forms::checkbox(1, get_value("error_log_errors"), "error_log_errors", $l_prefs["error_log"], false, "defaultfont", "", !get_value("we_error_handler")));
			$_error_display_table->setCol(3, 0, null, getPixel(1, 5));
			$_error_display_table->setCol(4, 0, null, we_forms::checkbox(1, get_value("error_mail_errors"), "error_mail_errors", $l_prefs["error_mail"], false, "defaultfont", "set_state_mail();", !get_value("we_error_handler")));

			// Create specify mail address input
			$_error_mail_specify_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 1, 4);

			$_error_mail_specify_table->setCol(0, 0, null, getPixel(50, 1));

			$_error_mail_specify_table->setCol(0, 1, array("class" => "defaultfont"), $l_prefs["error_mail_address"] . ":");

			$_error_mail_specify_table->setCol(0, 2, null, getPixel(10, 1));

			$_error_mail_specify_table->setCol(0, 3, array("align" => "left"), htmlTextInput("error_mail_address", 6, (get_value("error_mail_errors") != 0 ? get_value("error_mail_address") : ""), 100, ((!get_value("error_mail_errors") || !get_value("we_error_handler")) ? "disabled=\"disabled\"" : ""), "text", 105));

			$_error_display_table->setCol(5, 0, null, getPixel(1, 10));
			$_error_display_table->setCol(6, 0, null, $_error_mail_specify_table->getHtmlCode());

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["error_displaying"], "html" => $_error_display_table->getHtmlCode(), "space" => 200));
			}

			/*********************************************************************
			 * DEBUG FRAME
			 *********************************************************************/

			/**
			 * Show debug frame
			 */

			// Create checkboxes
			$_debug_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 3, 1);

			$_debug_table->setCol(0, 0, null, we_forms::checkbox(1, get_value("error_debug_normal"), "debug_normal", $l_prefs["debug_normal"] . "*"));
			$_debug_table->setCol(1, 0, null, getPixel(1, 5));
			$_debug_table->setCol(2, 0, null, we_forms::checkbox(1, get_value("error_debug_seem"), "debug_seem", $l_prefs["debug_seem"] . "*"));

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => $l_prefs["show_debug_frame"], "html" => $_debug_table->getHtmlCode(), "space" => 200, "noline" => 1));
			}

			// Create notice
			$_debug_notice = getPixel(6, 6) . "<span class=\"small\">* " . $l_prefs["debug_restart"] . "</span>";

			// Build notice dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => "", "html" => $_debug_notice, "space" => 200));
			}

			$_settings_cookie = weGetCookieVariable("but_settings_error_expert");

			/**
			 * BUILD FINAL DIALOG
			 */

			// Build dialog element if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				$_dialog = create_dialog("settings_error_expert", $l_prefs["tab_error_handling"], $_settings, $_foldAt, $l_prefs["show_expert"], $l_prefs["hide_expert"], $_settings_cookie, $_needed_JavaScript);
			}

			break;

		/*********************************************************************
         * Validation (XHTML)
         *********************************************************************/
		case 'message_reporting':

			$_val = get_value('message_reporting');

			$_js = '
			<script type="text/javascript">
			function handle_message_reporting_click() {
				val = 0;
				var fields = new Array("message_reporting_notices", "message_reporting_warnings", "message_reporting_errors");
				for (i=0;i<fields.length;i++) {

					if (document.getElementById(fields[i]).checked) {
						val += parseInt(document.getElementById(fields[i]).value);
					}
				}
				document.getElementById("message_reporting").value = val;

			}
			</script>
			';


			$_settings = array();

			/*****************************************************************
			 * Information
			 *****************************************************************/

			$_information = htmlAlertAttentionBox($l_prefs["message_reporting"]["information"], 2, 450, false);

			// Build dialog if user has permission
			array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));


			/*****************************************************************
			 * Settings
			 *****************************************************************/

			$_error = "<input type=\"hidden\" id=\"message_reporting\" name=\"message_reporting\" value=\"$_val\" />" . we_forms::checkbox(WE_MESSAGE_ERROR, 1, "message_reporting_errors", $l_prefs["message_reporting"]["show_errors"], false, "defaultfont", "handle_message_reporting_click();", true);
			$_warning = we_forms::checkbox(WE_MESSAGE_WARNING, $_val & WE_MESSAGE_WARNING, "message_reporting_warnings", $l_prefs["message_reporting"]["show_warnings"], false, "defaultfont", "handle_message_reporting_click();" );
			$_notice =we_forms::checkbox(WE_MESSAGE_NOTICE, $_val & WE_MESSAGE_NOTICE, "message_reporting_notices", $l_prefs["message_reporting"]["show_notices"], false, "defaultfont", "handle_message_reporting_click();" );

			// Build final HTML code
			$_html	=		$_error . "<br />"
						.	$_warning . "<br />"
						.	$_notice;

			// Build dialog element if users has permission
			array_push($_settings, array("headline" => $l_prefs["message_reporting"]["headline"], "html" => $_html, "space" => 200));

			$_dialog = create_dialog("settings_message_reporting", $l_prefs["message_reporting"]["headline"], $_settings, -1, "", "", false, $_js);

		break;


        /*********************************************************************
         * Validation (XHTML)
         *********************************************************************/
        case 'validation':

            $_settings = array();

            $js = '
            <script type="text/javascript">

            mainXhtmlFields  = Array("setXhtml_remove_wrong","setXhtml_show_wrong");
            showXhtmlFields = Array("setXhtml_show_wrong_text","setXhtml_show_wrong_js","setXhtml_show_wrong_error_log");

            function disable_xhtml_fields(val,fields){
                for(i=0;i<fields.length;i++){
                    elem = document.forms[0][fields[i]];
                    label = document.getElementById("label_" + fields[i]);
                    if(val == 1){
                        elem.disabled = false;
                        label.style.color = "black";
                        label.style.cursor = document.all ? "hand" : "pointer";
                    } else {
                        elem.disabled = true;
                        label.style.color = "gray";
                        label.style.cursor = "";
                    }
                }
            }

            function set_xhtml_field(val, field){
                document.forms[0][field].value = (val ? 1 : 0);
            }
            </script>';

			// Build dialog if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {

			    //   select xhtml_default in we:tags
				$_php_setting = new we_htmlSelect(array("name" => "xhtml_default","class"=>"weSelect"));
				$_php_setting->addOption(0,'false');
				$_php_setting->addOption(1,'true');

				if(get_value("xhtml_default")){
				    $_php_setting->selectOption(1);
				} else {
				    $_php_setting->selectOption(0);
				}
				array_push($_settings, array('html' => $l_prefs['xhtml_default'], 'space' => 0,'noline'=>1));
				array_push($_settings, array('html' => $_php_setting->getHtmlCode(), "space" => 200));


				array_push($_settings, array('html' => htmlAlertAttentionBox($l_prefs['xhtml_debug_explanation'],2,450), 'space' => 0, 'noline'=>1));

				//  activate xhtml_debug
				$_xhtml_debug  = we_forms::checkbox(1,get_value("xhtml_debug"), "setXhtml_debug", $l_prefs['xhtml_debug_html'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_debug\');disable_xhtml_fields(this.checked, mainXhtmlFields);disable_xhtml_fields((document.forms[0][\'setXhtml_show_wrong\'].checked && this.checked), showXhtmlFields);');
				$_xhtml_debug .= hidden('xhtml_debug',get_value("xhtml_debug"));
				array_push($_settings, array('headline'=>$l_prefs['xhtml_debug_headline'], 'html' => $_xhtml_debug, 'space'=>200,'noline'=>1));

				//  activate xhtml_remove_wrong
				$_xhtml_remove_wrong  = we_forms::checkbox(1,get_value("xhtml_remove_wrong"), "setXhtml_remove_wrong", $l_prefs['xhtml_remove_wrong'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_remove_wrong\');', !get_value('xhtml_debug'));
				$_xhtml_remove_wrong .= hidden('xhtml_remove_wrong',get_value("xhtml_remove_wrong"));
				array_push($_settings, array('html' => $_xhtml_remove_wrong, 'space'=>200));

				//  activate xhtml_show_wrong
				$_xhtml_show_wrong = we_forms::checkbox(1,get_value("xhtml_show_wrong"), "setXhtml_show_wrong", $l_prefs['xhtml_show_wrong_html'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_show_wrong\');disable_xhtml_fields(this.checked,showXhtmlFields);', !get_value('xhtml_debug'));
				$_xhtml_show_wrong .= hidden('xhtml_show_wrong',get_value("xhtml_show_wrong"));
				array_push($_settings, array('headline'=>$l_prefs['xhtml_show_wrong_headline'], 'html'=>'', 'space'=>400,'noline'=>1));
				array_push($_settings, array('html' => $_xhtml_show_wrong, 'space'=>200,'noline'=>1));

				//  activate xhtml_show_wrong_text
				$_xhtml_show_wrong_text = we_forms::checkbox(1,get_value("xhtml_show_wrong_text"), 'setXhtml_show_wrong_text', $l_prefs['xhtml_show_wrong_text_html'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_show_wrong_text\');', !get_value('xhtml_show_wrong'));
				$_xhtml_show_wrong_text .= hidden('xhtml_show_wrong_text',get_value("xhtml_show_wrong_text"));
				array_push($_settings, array('html' => $_xhtml_show_wrong_text, 'space'=>220,'noline'=>1));

                //  activate xhtml_show_wrong_text
				$_xhtml_show_wrong_js = we_forms::checkbox(1,get_value("xhtml_show_wrong_js"), 'setXhtml_show_wrong_js', $l_prefs['xhtml_show_wrong_js_html'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_show_wrong_js\');', !get_value('xhtml_show_wrong'));
				$_xhtml_show_wrong_js .= hidden('xhtml_show_wrong_js',get_value("xhtml_show_wrong_js"));
				array_push($_settings, array('html' => $_xhtml_show_wrong_js, 'space'=>220,'noline'=>1));

                //  activate xhtml_show_wrong_text
				$_xhtml_show_wrong_error_log = we_forms::checkbox(1,get_value("xhtml_show_wrong_error_log"), "setXhtml_show_wrong_error_log", $l_prefs['xhtml_show_wrong_error_log_html'], false, 'defaultfont', 'set_xhtml_field(this.checked,\'xhtml_show_wrong_error_log\');', !get_value('xhtml_show_wrong'));
				$_xhtml_show_wrong_error_log .= hidden('xhtml_show_wrong_error_log',get_value("xhtml_show_wrong_error_log"));
				array_push($_settings, array('html' => $_xhtml_show_wrong_error_log, 'space'=>220,'noline'=>1));
			}

			// Build dialog element if user has permission
			if (we_hasPerm("ADMINISTRATOR")) {
				$_dialog = create_dialog("", $l_prefs["validation"], $_settings, -1, "", "", null, $js);
			}
            break;

        /*********************************************************************
         * BACKUP
         *********************************************************************/
		case "backup":


			$_settings = array();

			$perf=new we_htmlTable(array("width"=>"420", "border"=>"0","cellpadding"=>"2","cellspacing"=>"0"),3,5);
			$perf->setCol(0,0,array("class"=>"header_small"),$l_prefs["backup_slow"]);
			$perf->setCol(0,1,array(),getPixel(5,2));
			$perf->setCol(0,2,array("class"=>"header_small","align"=>"right"),$l_prefs["backup_fast"]);



			$steps=array(1,5,7,10,15,20,30,40,50,80,100,500,1000);
			$backup_steps=get_value("backup_steps");
			$steps_code='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;"><tr>';
			foreach($steps as $step){
				if($step==$backup_steps) $steps_code.='<td>'.we_htmlElement::htmlInput(array("type"=>"radio","value"=>"$step","name"=>"backup_steps","checked"=>true)).'</td>';
				else $steps_code.='<td>'.we_htmlElement::htmlInput(array("type"=>"radio","value"=>"$step","name"=>"backup_steps")).'</td>';
			}
			$steps_code.= '</tr></table>';
			$perf->setCol(1,0,array("class"=>"defaultfont","colspan"=>3),$steps_code);

			if($backup_steps==0) $steps_code=we_htmlElement::htmlInput(array("type"=>"radio","value"=>"0","name"=>"backup_steps","checked"=>true));
			else $steps_code=we_htmlElement::htmlInput(array("type"=>"radio","value"=>"0","name"=>"backup_steps"));
			$steps_code.=$l_prefs["backup_auto"];
			$perf->setCol(2,0,array("class"=>"header_small","colspan"=>3),$steps_code);


			if (we_hasPerm("ADMINISTRATOR")) {
				array_push($_settings, array("headline" => htmlAlertAttentionBox($l_prefs["performance"],2,450), "html" => "", "space" => 200));
				array_push($_settings, array("headline" => "", "html" => $perf->getHtmlCode(), "space" => 15));
			}

			// Build dialog

			$_settings_cookie = weGetCookieVariable("but_settings_predefined");

			/**
			 * BUILD FINAL DIALOG
			 */
			if (we_hasPerm("ADMINISTRATOR")) {
				$_dialog = create_dialog("settings_backup", $l_prefs["backup"], $_settings);
			}

			break;

			/*********************************************************************
         	* EMAIL
         	*********************************************************************/
			case "email":

				$_settings = array();

				/**
				 * Information
				 */

				$_information = htmlAlertAttentionBox($l_prefs["mailer_information"], 2, 450, false);

				array_push($_settings, array("headline" => "", "html" => $_information, "space" => 0));

				if (we_hasPerm('ADMINISTRATOR')) {



					$_emailSelect = htmlSelect('mailer_type', array('php'=>$l_prefs['mailer_php'],'smtp'=>$l_prefs['mailer_smtp']), 1, get_value('mailer_type'), false,"onchange=\"var el = document.getElementById('smtp_table').style; if(this.value=='smtp') el.display='block'; else el.display='none';\"",'value',300,'defaultfont');

					array_push($_settings, array('headline'=> $l_prefs['mailer_type'], 'html' => $_emailSelect, 'space' => 120, 'noline' => 1));

					$_smtp_table = new we_htmlTable(array('border'=>'0', 'cellpadding'=>'0', 'cellspacing'=>'0', 'id'=>'smtp_table','width'=>300, 'style'=>'display: ' . ((get_value('mailer_type')=='php') ? 'none' : 'block') . ';'), 11, 3);

					$_smtp_table->setCol(0, 0, array('class' => 'defaultfont'), $l_prefs['smtp_server']);
					$_smtp_table->setCol(0, 1, array('class' => 'defaultfont'), getPixel(10,5));
					$_smtp_table->setCol(0, 2, array('align' => 'right'), htmlTextInput('smtp_server', 24, get_value('smtp_server'), 180, '' , 'text', 180));

					$_smtp_table->setCol(1, 0, array('class' => 'defaultfont'), getPixel(10,10));

					$_smtp_table->setCol(2, 0, array('class' => 'defaultfont'), $l_prefs['smtp_port']);
					$_smtp_table->setCol(2, 2, array('align' => 'right'), htmlTextInput('smtp_port', 24, get_value('smtp_port'), 180, '', 'text', 180));

					$_smtp_table->setCol(3, 0, array('class' => 'defaultfont'), getPixel(10,10));
					$_smtp_table->setCol(4, 0, array('class' => 'defaultfont'), $l_prefs['smtp_halo']);
					$_smtp_table->setCol(4, 2, array('align' => 'right'), htmlTextInput('smtp_halo', 24, get_value('smtp_halo'), 180, '', 'text', 180));

					$_smtp_table->setCol(5, 0, array('class' => 'defaultfont'), getPixel(10,10));
					$_smtp_table->setCol(6, 0, array('class' => 'defaultfont'), $l_prefs['smtp_timeout']);
					$_smtp_table->setCol(6, 2, array('align' => 'right'), htmlTextInput('smtp_timeout', 24, get_value('smtp_timeout'), 180, '', 'text', 180));


					$_auth_table = new we_htmlTable(array('border'=>'0', 'cellpadding'=>'0', 'cellspacing'=>'0', 'id'=>'auth_table','width'=>200, 'style'=>'display: ' . ((get_value('smtp_auth') == 1) ? 'block' : 'none') . ';'), 4, 3);

					$_auth_table->setCol(0, 0, array('class' => 'defaultfont'), $l_prefs['smtp_username']);
					$_auth_table->setCol(0, 1, array('class' => 'defaultfont'), getPixel(10,10));
					$_auth_table->setCol(0, 2, array('align' => 'right'), htmlTextInput('smtp_username', 14, get_value('smtp_username'), 105, '', 'text', 105));

					$_auth_table->setCol(1, 0, array('class' => 'defaultfont'), getPixel(10,10));

					$_auth_table->setCol(2, 0, array('class' => 'defaultfont'), $l_prefs['smtp_password']);
					$_auth_table->setCol(2, 2, array('align' => 'right'), htmlTextInput('smtp_password', 14, get_value('smtp_password'), 105, '', 'password', 105));

					$_auth_table->setCol(3, 0, array('class' => 'defaultfont'), getPixel(10,10));

					$_smtp_table->setCol(7, 0, array('class' => 'defaultfont'), getPixel(10,20));
					$_smtp_table->setCol(8, 0, array('class' => 'defaultfont','colspan'=>3),
						we_forms::checkbox(1, get_value('smtp_auth') , 'smtp_auth', $l_prefs['smtp_auth'], false, 'defaultfont', "var el2 = document.getElementById('auth_table').style; if(this.checked) el2.display='block'; else el2.display='none';" )
					);
					$_smtp_table->setCol(9, 0, array('class' => 'defaultfont'), getPixel(10,10));
					$_smtp_table->setCol(10, 0, array('align' => 'right','colspan'=>3), getPixel(5,5) . $_auth_table->getHtmlCode());

					array_push($_settings, array('headline'=>'','html' => $_smtp_table->getHtmlCode(), 'space' => 120, 'noline' => 1));

				}

				$_dialog = create_dialog('settings_email', $l_prefs['email'] , $_settings);

			break;
			
			case 'versions':
				
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
				 
	            $_settings = array();
	            
	            $version = new weVersions();
	            
	            
	            //js
				$jsCheckboxCheckAll = '';
		
				foreach ($version->contentTypes as $k) {
					if($k!="all") {
						$jsCheckboxCheckAll .= 'document.getElementById("version_'.$k.'").checked = checked;';
					}			
				}
				
	            $js = '
	            <script type="text/javascript">
	            	            	
	            	function checkAll(val) {
						
		            	if(val.checked) {
		            		checked = 1;
		            	}
		            	else {
		            		checked = 0;
		            	}
						'.$jsCheckboxCheckAll.';
		            	
					}
	            	
	            	function checkAllRevert() {
	            	
	            		var checkbox = document.getElementById("version_all");
						checkbox.checked = false;
	            	}
	            	
	            	function openVersionWizard() {
	            	
						parent.opener.top.we_cmd("versions_wizard");
					
					}
					
	            </script>';
	            
	            $_SESSION['versions']['Prefs'] = array(
	            	"version_image/*",
	            	"version_text/html",
	            	"version_text/webedition",
	            	"version_text/js",
	            	"version_text/css",
	            	"version_text/plain",
	            	"version_application/x-shockwave-flash",
	            	"version_video/quicktime",
	            	"version_application/*",
	            	"version_text/xml",
	            	"version_objectFile",
	            	"versions_time_days",
	            	"versions_time_weeks",
	            	"versions_time_years",
	            	"versions_anzahl"
	            );
	            $_SESSION['versions']['logPrefs'] = array();
	            foreach($_SESSION['versions']['Prefs'] as $k) {
	            	$_SESSION['versions']['logPrefs'][$k] = get_value($k);
	            }
	           
				// Build dialog if user has permission
				if (we_hasPerm("ADMINISTRATOR")) {
					
					array_push($_settings, array(
						'html' => htmlAlertAttentionBox($l_prefs['versioning_activate_text'],2,470), 
						'noline'=>1, 
						'space' => 0)
					);
					
					$checkboxes = "";
					foreach ($version->contentTypes as $k) {
						
						$txt = $k;
						$name = "version_".$k;
						$val = 1;
						$checked = get_value("version_".$k);
						if($k=="all") {
							$jvs = "checkAll(this);";
							$checkboxes .= we_forms::checkbox($val, $checked, $name, $l_prefs["version_all"], false, "defaultfont", $jvs)."<br/>";
						}
						else {
							$jvs = "checkAllRevert(this);";
							$checkboxes .= we_forms::checkbox($val, $checked, $name, $GLOBALS["l_contentTypes"][$txt], false, "defaultfont", $jvs)."<br/>";
						}
						
					}
					
					array_push($_settings, array(
						'headline' => $l_prefs['ContentType'],
						'space' => 170,
						'html' => $checkboxes
						)
					);
					
					array_push($_settings, array(
						'html' => htmlAlertAttentionBox($l_prefs['versioning_time_text'],2,470), 
						'noline'=>1, 
						'space' => 0
						)
					);
	
					$_versions_time_days = new we_htmlSelect(array(
						"name" => "versions_time_days",
						"style"=>"",
						"class"=>"weSelect"
						)
					);	
					$secondsDay = 86400;
					$secondsWeek = 604800;	
					$secondsYear = 31449600;
										
					$_versions_time_days->addOption(-1,"");
					$_versions_time_days->addOption($secondsDay,$l_prefs["1_day"]);
					for($x = 2; $x<=31; $x++) {
						$_versions_time_days->addOption(($x*$secondsDay),sprintf($l_prefs["more_days"],$x));
					}
					$_versions_time_days->selectOption(get_value("versions_time_days"));
					
					
					$_versions_time_weeks = new we_htmlSelect(array(
						"name" => "versions_time_weeks",
						"style"=>"",
						"class"=>"weSelect")
					);
					$_versions_time_weeks->addOption(-1,"");
					$_versions_time_weeks->addOption($secondsWeek,$l_prefs["1_week"]);
					for($x = 2; $x<=52; $x++) {
						$_versions_time_weeks->addOption(($x*$secondsWeek),sprintf($l_prefs["more_weeks"],$x));
					}
					$_versions_time_weeks->selectOption(get_value("versions_time_weeks"));
					
				
					$_versions_time_years = new we_htmlSelect(array(
						"name" => "versions_time_years",
						"style"=>"",
						"class"=>"weSelect"
						)
					);				
					$_versions_time_years->addOption(-1,"");
					$_versions_time_years->addOption($secondsYear,$l_prefs["1_year"]);
					for($x = 2; $x<=10; $x++) {
						$_versions_time_years->addOption(($x*$secondsYear),sprintf($l_prefs["more_years"],$x));
					}
					$_versions_time_years->selectOption(get_value("versions_time_years"));

					array_push($_settings, array(
						'html' => $_versions_time_days->getHtmlCode()." ".$_versions_time_weeks->getHtmlCode()." ".$_versions_time_years->getHtmlCode(), 
						"space" => 170, 
						"headline"=>$l_prefs["versioning_time"]
						)
					);

					
					array_push($_settings, array(
						'html' => htmlAlertAttentionBox($l_prefs['versioning_anzahl_text'],2,470), 
						'noline'=>1, 
						'space' => 0
						)
					);
	
					
					$_versions_anzahl = htmlTextInput("versions_anzahl",24,get_value("versions_anzahl"),5,"","text",50,0,"");
					
					array_push($_settings, array(
						'headline'=>$l_prefs['versioning_anzahl'], 
						'html' => $_versions_anzahl, 
						'space'=>170
						)
					);
					
					
					array_push($_settings, array(
						'html' => htmlAlertAttentionBox($l_prefs['versioning_create_text'],2,470,false), 
						'noline'=>1, 
						'space' => 0
						)
					);
	
					$_versions_create_publishing = we_forms::radiobutton("1",(get_value("versions_create") == "1"),"versions_create",$l_prefs["versions_create_publishing"],true,"defaultfont","",false,"");
					$_versions_create_always = we_forms::radiobutton("0",(get_value("versions_create") == "0"),"versions_create",$l_prefs["versions_create_always"],true,"defaultfont","",false,"");
			
					array_push($_settings, array(
						'headline'=>$l_prefs['versioning_create'], 
						'html' => $_versions_create_publishing."<br/>".$_versions_create_always, 
						'space'=>170
						)
					);
					
					
					array_push($_settings, array(
						'html' => htmlAlertAttentionBox($l_prefs['versioning_wizard_text'],2,470), 
						'noline'=>1, 
						'space' => 0
						)
					);
					
					$_versions_wizard = "<div style='float:left;'>".$we_button->create_button("openVersionWizard", "javascript:openVersionWizard()", true, 100,22,"","")."</div>";
					
					array_push($_settings, array(
						'headline'=>$l_prefs['versioning_wizard'], 
						'html' => $_versions_wizard, 
						'space'=>170)
					);
					
				}

				// Build dialog element if user has permission
				if (we_hasPerm("ADMINISTRATOR")) {
					$_dialog = create_dialog("", $l_prefs["validation"], $_settings, -1, "", "", null, $js);
				}
				
            break;

	}

	if (isset($_dialog)) {
		return $_dialog;
	} else {
		return "";
	}
}



/**
 * This functions renders the complete dialog.
 *
 * @return         string
 */

function render_dialog() {
	global $global_config,$tabname;

	// Check configuration file for all needed variables
	check_global_config($global_config);

	// Render setting groups
	if($tabname=="setting_ui") $_output  = we_htmlElement::htmlDiv(array("id" => "setting_ui"), build_dialog("ui"));
	else $_output  = we_htmlElement::htmlDiv(array("id" => "setting_ui", "style" => "display: none;"), build_dialog("ui"));

	if($tabname=="setting_extensions") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_extensions"), build_dialog("extensions"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_extensions", "style" =>  "display: none;"), build_dialog("extensions"));

	if($tabname=="setting_editor") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_editor"), build_dialog("editor"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_editor", "style" => "display: none;"), build_dialog("editor"));

	if($tabname=="setting_recipients") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_recipients"), build_dialog("recipients"));
	else  $_output .= we_htmlElement::htmlDiv(array("id" => "setting_recipients", "style" => "display: none;"), build_dialog("recipients"));

	if($tabname=="setting_proxy") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_proxy"), build_dialog("proxy"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_proxy", "style" => "display: none;"), build_dialog("proxy"));

	if($tabname=="setting_advanced") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_advanced"), build_dialog("advanced"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_advanced", "style" => "display: none;"), build_dialog("advanced"));

	if($tabname=="setting_system") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_system"), build_dialog("system"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_system", "style" => "display: none;"), build_dialog("system"));

	if($tabname=="setting_error_handling") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_error_handling"), build_dialog("error_handling"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_error_handling", "style" => "display: none;"), build_dialog("error_handling"));

	if($tabname=="setting_backup") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_backup"), build_dialog("backup"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_backup", "style" => "display: none;"), build_dialog("backup"));

	if($tabname=="setting_validation") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_validation"), build_dialog("validation"));
	else$_output .= we_htmlElement::htmlDiv(array("id" => "setting_validation", "style" => "display: none;"), build_dialog("validation"));

	if($tabname=="setting_cache") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_cache"), build_dialog("cache"));
	else$_output .= we_htmlElement::htmlDiv(array("id" => "setting_cache", "style" => "display: none;"), build_dialog("cache"));

	if($tabname=="setting_language") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_language"), build_dialog("language"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_language", "style" => "display: none;"), build_dialog("language"));

	if($tabname=="setting_message_reporting") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_message_reporting"), build_dialog("message_reporting"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_message_reporting", "style" => "display: none;"), build_dialog("message_reporting"));

	if($tabname=="setting_active_integrated_modules") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_active_integrated_modules"), build_dialog("active_integrated_modules"));
	else $_output .= we_htmlElement::htmlDiv(array("id" => "setting_active_integrated_modules", "style" => "display: none;"), build_dialog("active_integrated_modules"));

	if($tabname=="setting_email") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_email"), build_dialog("email"));
	$_output .= we_htmlElement::htmlDiv(array("id" => "setting_email", "style" => "display: none;"), build_dialog("email"));
	
	if($tabname=="setting_versions") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_versions"), build_dialog("versions"));
	$_output .= we_htmlElement::htmlDiv(array("id" => "setting_versions", "style" => "display: none;"), build_dialog("versions"));

	// Render save screen
	if($tabname=="setting_save") $_output .= we_htmlElement::htmlDiv(array("id" => "setting_save"), build_dialog("save"));
	$_output .= we_htmlElement::htmlDiv(array("id" => "setting_save", "style" => "display: none;"), build_dialog("save"));


	// Hide preload screen
	$_output .= we_htmlElement::jsElement("
					<!--
						setTimeout(\"top.we_cmd('show_tabs');\", 50);
					//-->
				", array());

	return $_output;
}

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

htmlTop();

$doSave = false;
$acError = false;
$acErrorMsg = "";
// Check if we need to save settings
if (isset($_REQUEST["save_settings"]) && $_REQUEST["save_settings"] == "true") {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php");
	$acQuery = new weSelectorQuery();
	
	// check seemode start document | object
	if ($_REQUEST['seem_start_type']=="document") {
		if (empty($_REQUEST['seem_start_document'])) {
			$acError = true;
			$acErrorMsg = sprintf($l_alert['field_in_tab_notvalid'],$l_prefs["seem_startdocument"],$l_prefs["tab_ui"])."\\n";
		} else {
			$acResponse = $acQuery->getItemById($_REQUEST['seem_start_document'],FILE_TABLE,array("IsFolder"));
			if (!$acResponse || $acResponse[0]['IsFolder']==1) {
				$acError = true;
				$acErrorMsg = sprintf($l_alert['field_in_tab_notvalid'],$l_prefs["seem_startdocument"],$l_prefs["tab_ui"])."\\n";
			}
		}
	} elseif ($_REQUEST['seem_start_type']=="object") {
		if (empty($_REQUEST['seem_start_object'])) {
			$acError = true;
			$acErrorMsg = sprintf($l_alert['field_in_tab_notvalid'],$l_prefs["seem_startdocument"],$l_prefs["tab_ui"])."\\n";
		} else {
			$acResponse = $acQuery->getItemById($_REQUEST['seem_start_object'],OBJECT_FILES_TABLE,array("IsFolder"));
			if (!$acResponse || $acResponse[0]['IsFolder']==1) {
				$acError = true;
				$acErrorMsg = sprintf($l_alert['field_in_tab_notvalid'],$l_prefs["seem_startdocument"],$l_prefs["tab_ui"])."\\n";
			}
		}
	}
	// check sidebar document
	if ((isset($_REQUEST['ui_sidebar_disable']) && !$_REQUEST['ui_sidebar_disable'] && $_REQUEST['ui_sidebar_file_name'])!="") {
		$acResponse = $acQuery->getItemById($_REQUEST['ui_sidebar_file'],FILE_TABLE,array("IsFolder"));
		if (!$acResponse || $acResponse[0]['IsFolder']==1) {
			$acError = true;
			$acErrorMsg .= sprintf($l_alert['field_in_tab_notvalid'],$l_prefs["sidebar"]." / ".$l_prefs["sidebar_document"],$l_prefs["tab_ui"])."\\n";
		}
	}
	// check doc for error on none existing objects
	if (isset($_REQUEST['error_document_no_objectfile_text']) && $_REQUEST['error_document_no_objectfile_text']!="") {
		$acResponse = $acQuery->getItemById($_REQUEST['error_document_no_objectfile'],FILE_TABLE,array("IsFolder"));
		if (!$acResponse || $acResponse[0]['IsFolder']==1) {
			$acError = true;
			$acErrorMsg .= sprintf($l_alert['field_in_tab_notvalid'],$l_prefs['error_no_object_found'],$l_prefs["tab_error_handling"])."\\n";
		}
	}
	// check if versioning number is correct
	if (isset($_REQUEST['versions_anzahl']) && $_REQUEST['versions_anzahl']!="") {
		if (!pos_number($_REQUEST['versions_anzahl'])) {
			$acError = true;
			$acErrorMsg .= sprintf($l_alert['field_in_tab_notvalid'],$l_prefs['versioning_anzahl'],$l_prefs["tab_versions"])."\\n";
		}
	}
	$doSave=true;
}

if ($doSave && !$acError) {
	save_all_values();

	$save_javascript = we_htmlElement::jsElement("
							function doClose() {

								var _multiEditorreload = false;
							   " . $save_javascript . "

							   " . (!$email_saved
										? we_message_reporting::getShowMessageCall($l_prefs["error_mail_not_saved"], WE_MESSAGE_ERROR)
							   			: we_message_reporting::getShowMessageCall($l_prefs["saved"], WE_MESSAGE_NOTICE)
							   		) . "
							   top.opener.top.frames[0].location.reload();
							   top.close();
							}

					   ");
							   		
	


	print STYLESHEET . $save_javascript . "</head>";
	print we_htmlElement::htmlBody(array("class" => "weDialogBody","onload"=>"doClose()"), build_dialog("saved")) . "</html>";

} else {
	$_form = we_htmlElement::htmlForm(array("onSubmit"=>"return false;", "name" => "we_form", "method" => "post", "action" => $_SERVER["PHP_SELF"]), we_htmlElement::htmlHidden(array("name" => "save_settings", "value" => "false")) . render_dialog());
	
	$_we_cmd_js = we_htmlElement::jsElement('function we_cmd(){
	
	var args = "";
	var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
	switch (arguments[0]){
		case "browse_server":
            new jsWindow(url,"browse_server",-1,-1,840,400,true,false,true);
			break;
		case "openDocselector":
			new jsWindow(url,"openDocselector",-1,-1,' . WINDOW_DOCSELECTOR_WIDTH . ',' . WINDOW_DOCSELECTOR_HEIGHT . ',true,false,true,true);
			break;
		case "show_formmail_log":
			url = "/webEdition/we/include/we_editors/weFormmailLog.php"
			new jsWindow(url,"openDocselector",-1,-1,840,400,true,false,true);
			break;
		case "show_formmail_block_log":
			url = "/webEdition/we/include/we_editors/weFormmailBlockLog.php"
			new jsWindow(url,"openDocselector",-1,-1,840,400,true,false,true);
			break;
		case "openColorChooser":
			new jsWindow(url,"we_colorChooser",-1,-1,430,370,true,true,true);
			break;
			
		default:
			for(var i = 0; i < arguments.length; i++){
				args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
			}
			eval(\'parent.we_cmd(\'+args+\')\');
	}
}

function setColorField(name) {
	document.getElementById("color_" + name).style.backgroundColor=document.we_form.elements[name].value;
}

' . ($acError ? we_message_reporting::getShowMessageCall($l_alert['field_in_tab_notvalid_pre']."\\n\\n".$acErrorMsg."\\n".$l_alert['field_in_tab_notvalid_post'], WE_MESSAGE_ERROR) : ""));

	$_we_win_js = '<script src="'.JS_DIR.'windows.js" language="JavaScript" type="text/javascript"></script>';
	
	

	print STYLESHEET . $_we_cmd_js . $_we_win_js . $yuiSuggest->getYuiCssFiles() . $yuiSuggest->getYuiJsFiles() . "</head>";

	print we_htmlElement::htmlBody(array("class" => "weDialogBody"), $_form) .
				$yuiSuggest->getYuiCss() .
				$yuiSuggest->getYuiJs() .
				"</html>";
}

?>