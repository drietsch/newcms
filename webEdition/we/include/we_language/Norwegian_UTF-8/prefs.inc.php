<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Loading preferences, one moment ...";
$l_prefs["preload_wait"] = "Loading preferences";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Saving preferences, one moment ...";
$l_prefs["save_wait"] = "Saving preferences";

$l_prefs["saved"] = "Preferences have been saved successfully.";
$l_prefs["saved_successfully"] = "Preferences saved";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "User interface";
$l_prefs["tab_glossary"] = "Glossary";
$l_prefs["tab_extensions"] = "File extensions";
$l_prefs["tab_editor"] = 'Editor';
$l_prefs["tab_formmail"] = 'Formmail';
$l_prefs["formmail_recipients"] = 'Formmail recipients';
$l_prefs["tab_proxy"] = 'Proxy Server';
$l_prefs["tab_advanced"] = 'Advanced';
$l_prefs["tab_system"] = 'System';
$l_prefs["tab_error_handling"] = 'Error handling';
$l_prefs["tab_cockpit"] = 'Cockpit';
$l_prefs["tab_cache"] = 'Cache';
$l_prefs["tab_language"] = 'Languages';
$l_prefs["tab_modules"] = 'Modules';
$l_prefs["tab_versions"] = 'Versioning';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Language";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode";
	$l_prefs["seem_deactivate"] = "deactivate";
	$l_prefs["seem_startdocument"] = "Home";
	$l_prefs["seem_start_type_document"] = "Document";
	$l_prefs["seem_start_type_object"] = "Object";
	$l_prefs["seem_start_type_cockpit"] = "Cockpit";
	$l_prefs["question_change_to_seem_start"] = "Do you want to change to the selected document?";


	/**
	 * Sidebar
	 */
	$l_prefs["sidebar"] = "Sidebar";
	$l_prefs["sidebar_deactivate"] = "deactivate";
	$l_prefs["sidebar_show_on_startup"] = "show on startup";
	$l_prefs["sidebar_width"] = "Width in pixel";
	$l_prefs["sidebar_document"] = "Document";


	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Window dimension";
	$l_prefs["maximize"] = "Maximize";
	$l_prefs["specify"] = "Specify";
	$l_prefs["width"] = "Width";
	$l_prefs["height"] = "Height";
	$l_prefs["predefined"] = "Predefined dimensions";
	$l_prefs["show_predefined"] = "Show predefined dimensions";
	$l_prefs["hide_predefined"] = "Hide predefined dimensions";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Treemenu";
	$l_prefs["all"] = "All";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */
	$l_prefs["extensions_information"] = "Set the default file extensions for static and dynamic pages here.";
	
	$l_prefs["we_extensions"] = "webEdition extensions";
	$l_prefs["static"] = "Static pages";
	$l_prefs["dynamic"] = "Dynamic pages";
	$l_prefs["html_extensions"] = "HTML extensions";
	$l_prefs["html"] = "HTML pages";
	
/*****************************************************************************
 * Glossary
 *****************************************************************************/

	$l_prefs["glossary_publishing"] = "Check before publishing";
	$l_prefs["force_glossary_check"] = "Force glossary check";
	$l_prefs["force_glossary_action"] = "Force action";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Columns in the cockpit ";


/*****************************************************************************
 * CACHING
 *****************************************************************************/

	/**
	 * Cache Type
	 */
	$l_prefs["cache_information"] = "Set the preset values of the fields \"Caching Type\" and \"Cache lifetime in seconds\" for new templates here.<br /><br />Please note that these setting are only the presets of the fields.";
	$l_prefs["cache_navigation_information"] = "Enter the defaults for the &lt;we:navigation&gt; tag here. This value can be overwritten by the attribute \"cachelifetime\" of the &lt;we:navigation&gt; tag.";
	
	$l_prefs["cache_presettings"] = "Presetting";
	$l_prefs["cache_type"] = "Caching Type";
	$l_prefs["cache_type_none"] = "Caching deactivated";
	$l_prefs["cache_type_full"] = "Full cache";
	$l_prefs["cache_type_document"] = "Document cache";
	$l_prefs["cache_type_wetag"] = "we:Tag cache";

	/**
	 * Cache Life Time
	 */
	$l_prefs["cache_lifetime"] = "Cache lifetime in seconds";

	$l_prefs['cache_lifetimes'] = array();
	$l_prefs['cache_lifetimes'][0] = "";
	$l_prefs['cache_lifetimes'][60] = "1 minute";
	$l_prefs['cache_lifetimes'][300] = "5 minutes";
	$l_prefs['cache_lifetimes'][600] = "10 minutes";
	$l_prefs['cache_lifetimes'][1800] = "30 minutes";
	$l_prefs['cache_lifetimes'][3600] = "1 hour";
	$l_prefs['cache_lifetimes'][21600] = "6 hours";
	$l_prefs['cache_lifetimes'][43200] = "12 hours";
	$l_prefs['cache_lifetimes'][86400] = "1 day";

	$l_prefs['delete_cache_after'] = 'Clear cache after';
	$l_prefs['delete_cache_add'] = 'adding a new entry';
	$l_prefs['delete_cache_edit'] = 'changing a entry';
	$l_prefs['delete_cache_delete'] = 'deleting a entry';
	$l_prefs['cache_navigation'] = 'Default setting';
	$l_prefs['default_cache_lifetime'] = 'Default cache lifetime';


/*****************************************************************************
 * LOCALES // LANGUAGES
 *****************************************************************************/

	/**
	 * Languages
	 */
	$l_prefs["locale_information"] = "Add all languages for which you would provide a web page.<br /><br />This preference will be used for the glossary check and the spellchecking.";

	$l_prefs["locale_languages"] = "Language";
	$l_prefs["locale_countries"] = "Country";
	$l_prefs["locale_add"] = "Add language";
	$l_prefs['cannot_delete_default_language'] = "The default language cannot be deleted.";
	$l_prefs["language_already_exists"] = "This language already exists";
	$l_prefs["add_dictionary_question"] = "Would you like to upload the dictionary for this language?";

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = 'Editor PlugIn';
	$l_prefs["use_it"] = "Use it";
	$l_prefs["start_automatic"] = "Start automatically";
	$l_prefs["ask_at_start"] = 'Ask on start which<br>editor to be used';
	$l_prefs["must_register"] = 'Must be registered';
	$l_prefs["change_only_in_ie"] = 'These settings cannot be changed. The Editor PlugIn operates only with the Windows version of Internet Explorer, Mozilla, Firebird as well as Firefox.';
	$l_prefs["install_plugin"] = 'To be able to use the Editor PlugIn the Mozilla ActiveX PlugIn must be installed.';
	$l_prefs["confirm_install_plugin"] = 'The Mozilla ActiveX PlugIn allows to run ActiveX controls in Mozilla browsers. After the installation you must restart your browser.\\n\\nNote: ActiveX can be a security risk!\\n\\nContinue installation?';

	$l_prefs["install_editor_plugin"] = 'To be able to use the webEdition Editor PlugIn, it must be installed.';
	$l_prefs["install_editor_plugin_text"]= 'The webEdition Editor Plugin will be installed...';

	/**
	 * TEMPLATE EDITOR
	 */
	
	$l_prefs["editor_information"] = "Specify font and size which should be used for the editing of templates, CSS- and Java Script files within webEdition.<br /><br />These settings are used for the text editor of the abovementioned file types.";
	
	$l_prefs["editor_font"] = 'Font in editor';
	$l_prefs["editor_fontname"] = 'Fontname';
	$l_prefs["editor_fontsize"] = 'Size';
	$l_prefs["editor_dimension"] = 'Editor dimension';
	$l_prefs["editor_dimension_normal"] = 'Default';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Please enter all E-Mail addresses, which should receive forms sent by the formmail function (&lt;we:form type=\"formmail\" ..&gt;).<br><br>If you do not enter an E-Mail address, you cannot send forms using the formmail function!";

	$l_prefs["formmail_log"] = "Formmail log";
	$l_prefs['log_is_empty'] = "The log is empty!";
	$l_prefs['ip_address'] = "IP address";
	$l_prefs['blocked_until'] = "Blocked until";
	$l_prefs['unblock'] = "Unblock";
	$l_prefs['clear_log_question'] = "Do you really want to clear the log?";
	$l_prefs['clear_block_entry_question'] = "Do you really want to unblock the IP %s ?";
	$l_prefs["forever"] = "Always";
	$l_prefs["yes"] = "yes";
	$l_prefs["no"] = "no";
	$l_prefs["on"] = "on";
	$l_prefs["off"] = "off";
	$l_prefs["formmailConfirm"] = "Formmail confirmation function";
	$l_prefs["logFormmailRequests"] = "Log formmail requests";
	$l_prefs["deleteEntriesOlder"] = "Delete entries older than";
	$l_prefs["blockFormmail"] = "Limit formmail requests";
	$l_prefs["formmailSpan"] = "Within the span of time";
	$l_prefs["formmailTrials"] = "Requests allowed";
	$l_prefs["blockFor"] = "Block for";
	$l_prefs["formmailViaWeDoc"] = "Call formmail via webEdition-Dokument.";
	$l_prefs["never"] = "never";
	$l_prefs["1_day"] = "1 day";
	$l_prefs["more_days"] = "%s days";
	$l_prefs["1_week"] = "1 week";
	$l_prefs["more_weeks"] = "%s weeks";
	$l_prefs["1_year"] = "1 year";
	$l_prefs["more_years"] = "%s years";
	$l_prefs["1_minute"] = "1 minute";
	$l_prefs["more_minutes"] = "%s minutes";
	$l_prefs["1_hour"] = "1 hour";
	$l_prefs["more_hours"] = "%s hours";
	$l_prefs["ever"] = "always";





/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["proxy_information"] = "Specify your Proxy settings for your server here, if your server uses a proxy for the connection with the Internet.";
	
	$l_prefs["useproxy"] = "Use proxy server for<br>live update";
	$l_prefs["proxyaddr"] = "Address";
	$l_prefs["proxyport"] = "Port";
	$l_prefs["proxyuser"] = "User name";
	$l_prefs["proxypass"] = "Password";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Default settings for<br><em>php</em>-attribut in we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Default value for the<br><em>inlineedit</em> attribute in<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Edit textfields inside the document (<em>true</em>) or in a new<br />browser window (<em>false</em>)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Use Safari Wysiwyg<br>editor (beta version)";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Default value for the<br><em>showinputs</em> attribute in<br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Type of database<br>connections";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "HTTP authentication";
	$l_prefs["useauth"] = "Server uses HTTP<br>authentication in the webEdition<br>directory";
	$l_prefs["authuser"] = "User name";
	$l_prefs["authpass"] = "Password";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directory";

	$l_prefs["pagelogger_dir"] = "pageLogger directory";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Errorpage for not existing objects';

	/**
	 * TEMPLATE TAG CHECK
	 */

	$l_prefs["templates"] = "Templates";
	$l_prefs["disable_template_tag_check"] = "Deactivate check for missing,<br />closing we:tags";

	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "Use webEdition error handler";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Handle these errors";
	$l_prefs["error_notices"] = "Notices";
	$l_prefs["error_warnings"] = "Warnings";
	$l_prefs["error_errors"] = "Errors";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.';

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Displaying of errors";
	$l_prefs["error_display"] = "Show errors";
	$l_prefs["error_log"] = "Log errors";
	$l_prefs["error_mail"] = "Send a mail";
	$l_prefs["error_mail_address"] = "Address";
	$l_prefs["error_mail_not_saved"] = 'Errors won\'t be sent to the given e-mail address due to the address is not correct!\n\nThe remaining preferences have been saved successfully.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Show expert settings";
	$l_prefs["hide_expert"] = "Hide expert settings";
	$l_prefs["show_debug_frame"] = "Show debug frame";
	$l_prefs["debug_normal"] = "In normal mode";
	$l_prefs["debug_seem"] = "In seeMode";
	$l_prefs["debug_restart"] = "Changes require a restart";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "DB/Object module";
	$l_prefs["tree_count"] = "Number of displayed objects";
	$l_prefs["tree_count_description"] = "This value defines the maximum number of items being displayed in the left navigation.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Backup";
	$l_prefs["backup_slow"] = "Slow";
	$l_prefs["backup_fast"] = "Fast";
	$l_prefs["performance"] = "Here you can set an appropriate performance level. The performance level should be adequate to the server system. If the system has limited resources (memory, timeout etc.) choose a slow level, otherwise choose a fast level.";
	$l_prefs["backup_auto"]="Auto";

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Validation';
	$l_prefs['xhtml_default'] = 'Default value for the attribute <em>xml</em> in we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'The XHTML debugging will support your development of a xhtml valid web-site. The output of every we:Tag will be checked for validity and misplaced attribs can be displayed or removed. Please note: This action can take some time. Therefore you should only activate xhtml debugging during the development of your web-site.';
	$l_prefs['xhtml_debug_headline'] = 'XHTML debugging';
	$l_prefs['xhtml_debug_html'] = 'Activate XHTML debugging';
	$l_prefs['xhtml_remove_wrong'] = 'Remove invalid attributes';
	$l_prefs['xhtml_show_wrong_headline'] = 'Notification of invalid attributes';
	$l_prefs['xhtml_show_wrong_html'] = 'Activate';
	$l_prefs['xhtml_show_wrong_text_html'] = 'As text';
	$l_prefs['xhtml_show_wrong_js_html'] = 'As JavaScript-Alert';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'In the error log (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Max Upload Size<br>displaying in hints";
	$l_prefs["we_max_upload_size_hint"]="(in MByte, 0=automatic)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Access rights for<br>new directories";
	$l_prefs["we_new_folder_mod_hint"]="(default is 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "The default directory of a document type has to be located within the work area of the user, thus being able to select the corresponding document type.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "The user's work area hast to be located within the default directory defined in the document type for the user being able to select the document type.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Inverse";
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standard";
   $l_prefs["we_doctype_workspace_behavior"] = "Behaviour of the document type selection";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Use java upload';

/*****************************************************************************
 * message_reporting
 *****************************************************************************/
	$l_prefs["message_reporting"]["information"] = "You can decide on the respective check boxes whether you like to receive a notice for webEdition operations as for example saving, publishing or deleting.";
	
	$l_prefs["message_reporting"]["headline"] = "Notifications";
	$l_prefs["message_reporting"]["show_notices"] = "Show Notices";
	$l_prefs["message_reporting"]["show_warnings"] = "Show Warnings";
	$l_prefs["message_reporting"]["show_errors"] = "Show Errors";


/*****************************************************************************
 * Module Activation
 *****************************************************************************/
	$l_prefs["module_activation"]["information"] = "Here you can activate or deactivate your modules if you do not need them.<br /><br />Deactivated modules improve the overall performance of webEdition.";
	
	$l_prefs["module_activation"]["headline"] = "Module activation";

/*****************************************************************************
 * Email settings
 *****************************************************************************/
	
	$l_prefs["mailer_information"] = "Adjust whether webEditionin should dispatch emails via the integrated PHP function or a seperate SMTP server should be used.<br /><br />When using a SMTP mail server, the risk that messages are classified by the receiver as a \"Spam\" is lowered.";
	
	$l_prefs["mailer_type"] = "Mailer type";
	$l_prefs["mailer_php"] = "Use php mail() function";
	$l_prefs["mailer_smtp"] = "Use SMTP server";
	$l_prefs["email"] = "E-Mail";
	$l_prefs["tab_email"] = "E-Mail";
	$l_prefs["smtp_auth"] = "Authentication";
	$l_prefs["smtp_server"] = "SMTP server";
	$l_prefs["smtp_port"] = "SMTP port";
	$l_prefs["smtp_username"] = "User name";
	$l_prefs["smtp_password"] = "Password";
	$l_prefs["smtp_halo"] = "SMTP halo";
	$l_prefs["smtp_timeout"] = "SMTP timeout";
	
/*****************************************************************************
 * Versions settings
 *****************************************************************************/

	$l_prefs["versioning"] = "Versioning";
	$l_prefs["version_all"] = "all";
	$l_prefs["versioning_activate_text"] = "Activate versioning for some or all content types.";
	$l_prefs["versioning_time_text"] = "If you specify a time period, only versions are saved which are created in this time until today. Older versions will be deleted.";
	$l_prefs["versioning_time"] = "Time period";
	$l_prefs["versioning_anzahl_text"] = "Number of versions which will be created for each document or object.";
	$l_prefs["versioning_anzahl"] = "Number";
	$l_prefs["versioning_wizard_text"] = "Open the Version-Wizard to delete or reset versions.";
	$l_prefs["versioning_wizard"] = "Open Versions-Wizard";
	$l_prefs["ContentType"] = "Content Type";
	$l_prefs["versioning_create_text"] = "Determine which actions provoke new versions. Either if you publish or if you save, unpublish, delete or import files, too.";
	$l_prefs["versioning_create"] = "Create Version";
	$l_prefs["versions_create_publishing"] = "only when publishing";
	$l_prefs["versions_create_always"] = "always";

	$l_prefs['use_jeditor'] = "Use"; //TRANSLATE
	$l_prefs["editor_font_colors"] = 'Specify font colors'; //TRANSLATE
	$l_prefs["editor_normal_font_color"] = 'Default'; //TRANSLATE
	$l_prefs["editor_we_tag_font_color"] = 'webEdition tags'; //TRANSLATE
	$l_prefs["editor_we_attribute_font_color"] = 'webEdition attributes'; //TRANSLATE
	$l_prefs["editor_html_tag_font_color"] = 'HTML tags'; //TRANSLATE
	$l_prefs["editor_html_attribute_font_color"] = 'HTML attributes'; //TRANSLATE
	$l_prefs["editor_pi_tag_font_color"] = 'PHP code'; //TRANSLATE
	$l_prefs["editor_comment_font_color"] = 'Comments'; //TRANSLATE
	$l_prefs["jeditor"] = 'Java source editor'; //TRANSLATE
	
	$l_prefs["juplod_not_installed"] = 'JUpload is not installed!'; //TRANSLATE
?>