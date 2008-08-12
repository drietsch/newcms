<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

/**
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "����������� ���������, ���������, ����������";
$l_prefs["preload_wait"] = "�������� ��������";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "����������� ���������, ���������, ����������";
$l_prefs["save_wait"] = "���������� ��������";

$l_prefs["saved"] = "���������� �������� ������ �������";
$l_prefs["saved_successfully"] = "��������� ���������";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "���������������� ���������";
$l_prefs["tab_extensions"] = "���������� ������";
$l_prefs["tab_editor"] = '��������';
$l_prefs["tab_formmail"] = 'Formmail';
$l_prefs["formmail_recipients"] = '���������� Formmail';
$l_prefs["tab_proxy"] = 'Proxy-������';
$l_prefs["tab_advanced"] = '����������� ���������';
$l_prefs["tab_system"] = '�������';
$l_prefs["tab_error_handling"] = '������';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_modules"] = '������';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "����";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "����������� �����";
	$l_prefs["seem_deactivate"] = "�������������� �����";
	$l_prefs["seem_startdocument"] = "��������� �������� ������";
	$l_prefs["question_change_to_seem_start"] = "������� � ���������� ���������?";

	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "������ ����";
	$l_prefs["maximize"] = "���������������";
	$l_prefs["specify"] = "����������";
	$l_prefs["width"] = "������";
	$l_prefs["height"] = "������";
	$l_prefs["predefined"] = "�������� �������";
	$l_prefs["show_predefined"] = "�������� �������� �������";
	$l_prefs["hide_predefined"] = "������ �������� �������";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "���� ������";
	$l_prefs["all"] = "���";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */

	$l_prefs["we_extensions"] = "���������� webEdition";
	$l_prefs["static"] = "����������� ��������";
	$l_prefs["dynamic"] = "������������ ��������";
	$l_prefs["html_extensions"] = "���������� HTML";
	$l_prefs["html"] = "�������� HTML";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Columns in the cockpit "; // TRANSLATE

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = '��������-������';
	$l_prefs["use_it"] = "���������";
	$l_prefs["start_automatic"] = "�������������� ������";
	$l_prefs["ask_at_start"] = '��� ������� ����������<br>����� �������� ���������';
	$l_prefs["must_register"] = '������ ���� ���������������';
	$l_prefs["change_only_in_ie"] = '������ ��������� ������ ��������. ��������-������ �������� � Internet Explorer ������ ������ Windows.';
	$l_prefs["install_plugin"] = '������������� ���������-������ � ����� �������� ������� �� ������� �������������� ������� Mozilla ActiveX.';
	$l_prefs["confirm_install_plugin"] = '������ Mozilla ActiveX ��������� ���������� ActiveX Controls � �������� Mozilla. ����� ����������� ������� ����� ������ ��������� �������.\\n\\n������� �� ��������: ActiveX ����� ������������ ������ ������������!\\n\\n���������� �����������?';

	$l_prefs["install_editor_plugin"] = '������� ����� �������������� ������ ���������-������ webEdition.';
	$l_prefs["install_editor_plugin_text"]= '��������-������ � �������� �����������...';

	/**
	 * TEMPLATE EDITOR
	 */

	$l_prefs["editor_font"] = '����� � ���������';
	$l_prefs["editor_fontname"] = '�������� ������';
	$l_prefs["editor_fontsize"] = '������ ������';
	$l_prefs["editor_dimension"] = '������ ���������';
	$l_prefs["editor_dimension_normal"] = '�� ���������';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "�������, ����������, ������ ����������� ����� ���� ����������� ����, ����������� � ������� ������� formmail (&lt;we:form&nbsp;type=\"formmail\"&nbsp;..&gt;).<br><br>���� ����� email �� ������, ��������� ���� � �������������� ������� formmail ��������������� ������!";

	$l_prefs["formmail_log"] = "Formmail log"; // TRANSLATE
	$l_prefs['log_is_empty'] = "The log is empty!"; // TRANSLATE
	$l_prefs['ip_address'] = "IP address"; // TRANSLATE
	$l_prefs['blocked_until'] = "Blocked until"; // TRANSLATE
	$l_prefs['unblock'] = "Unblock"; // TRANSLATE
	$l_prefs['clear_log_question'] = "Do you really want to clear the log?"; // TRANSLATE
	$l_prefs['clear_block_entry_question'] = "Do you really want to unblock the IP %s ?"; // TRANSLATE
	$l_prefs["forever"] = "Always"; // TRANSLATE
	$l_prefs["yes"] = "yes"; // TRANSLATE
	$l_prefs["no"] = "no"; // TRANSLATE
	$l_prefs["on"] = "on"; // TRANSLATE
	$l_prefs["off"] = "off"; // TRANSLATE
	$l_prefs["formmailConfirm"] = "Formmail confirmation function"; // TRANSLATE
	$l_prefs["logFormmailRequests"] = "Log formmail requests"; // TRANSLATE
	$l_prefs["deleteEntriesOlder"] = "Delete entries older than"; // TRANSLATE
	$l_prefs["blockFormmail"] = "Limit formmail requests"; // TRANSLATE
	$l_prefs["formmailSpan"] = "Within the span of time"; // TRANSLATE
	$l_prefs["formmailTrials"] = "Requests allowed"; // TRANSLATE
	$l_prefs["blockFor"] = "Block for"; // TRANSLATE
	$l_prefs["never"] = "never"; // TRANSLATE
	$l_prefs["1_day"] = "1 day"; // TRANSLATE
	$l_prefs["more_days"] = "%s days"; // TRANSLATE
	$l_prefs["1_week"] = "1 week"; // TRANSLATE
	$l_prefs["more_weeks"] = "%s weeks"; // TRANSLATE
	$l_prefs["1_minute"] = "1 minute"; // TRANSLATE
	$l_prefs["more_minutes"] = "%s minutes"; // TRANSLATE
	$l_prefs["1_hour"] = "1 hour"; // TRANSLATE
	$l_prefs["more_hours"] = "%s hours"; // TRANSLATE
	$l_prefs["ever"] = "always"; // TRANSLATE

/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["useproxy"] = "��� ������ ����������<br>������������ proxy-������";
	$l_prefs["proxyaddr"] = "�����";
	$l_prefs["proxyport"] = "����";
	$l_prefs["proxyuser"] = "��� ������������";
	$l_prefs["proxypass"] = "������";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "��������� �� ��������� ���<br><em>php</em>-�������� � we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "�������� �� ��������� <br><em>inlineedit</em> �������� �<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "������������� ��������� ���� � ��������� (<em>true</em>) ��� � ����� ����<br/>�������� (<em>false</em>)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "�������������� ����������<br>Wysiwyg (beta-������) Safari";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "�������� �� ��������� <br><em>showinputs</em> �������� �<br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "��� ����������<br>���� ������";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "�������������� HTTP";
	$l_prefs["useauth"] = "������ ����������<br>�������������� HTTP<br>� ���������� webEdition";
	$l_prefs["authuser"] = "��� ������������";
	$l_prefs["authpass"] = "������";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directory"; // TRANSLATE

	$l_prefs["pagelogger_dir"] = "���������� pageLogger";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Errorpage for not existing objects'; // TRANSLATE
	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "��������� ���������� ������";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "������ ��� ����������";
	$l_prefs["error_notices"] = "����������";
	$l_prefs["error_warnings"] = "���������������";
	$l_prefs["error_errors"] = "������";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.'; // TRANSLATE

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "����� ������ �� �����";
	$l_prefs["error_display"] = "���������� ������";
	$l_prefs["error_log"] = "������� ������ �� �������";
	$l_prefs["error_mail"] = "��������� ���������";
	$l_prefs["error_mail_address"] = "�����";
	$l_prefs["error_mail_not_saved"] = '����� ������ �����������: ������ �� ����� ���������� �� ����� ������!\n\n��������� ��������� ������� ���������.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "���������� ���������������� ���������";
	$l_prefs["hide_expert"] = "������ ���������������� ���������";
	$l_prefs["show_debug_frame"] = "���������� debug frame";
	$l_prefs["debug_normal"] = "� ������� ������";
	$l_prefs["debug_seem"] = "����������� ��������������";
	$l_prefs["debug_restart"] = "��� ����������: ����������";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "���� ������/������";
	$l_prefs["tree_count"] = "���������� ��������� �� ����� ��������";
	$l_prefs["tree_count_description"] = "������ �������� ������ ������������ ���������� ��������, ��������� �� ����� �  ��������� �����";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Backup"; // TRANSLATE
	$l_prefs["backup_slow"] = "Slow"; // TRANSLATE
	$l_prefs["backup_fast"] = "Fast"; // TRANSLATE
	$l_prefs["performance"] = "Here you can set an appropriate performance level. The performance level should be adequate to the server system. If the system has limited resources (memory, timeout etc.) choose a slow level, otherwise choose a fast level."; // TRANSLATE
	$l_prefs["backup_auto"]="��������������";

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='��������';
	$l_prefs['xhtml_default'] = '�������� �� ��������� ��� ������� �������� <em>xml</em> � ����� we:Tags';
	$l_prefs['xhtml_debug_explanation'] = '���������� �� �������� �������������� ��� xhtml �������� � ���������� ���-�����, ������� ������ ����������������� ��� �xhtml valid�. ���� we:Tag ����������� �� ����������������, �������� �������� ��� ���� ������������� ��� ���������. ������� �� ��������: �������� �� �������� �������������� �������� ��������� �����. ������������� ������������ ������ ���������� �� �������� �������������� ������ ��� ���������� ���-�����.';
	$l_prefs['xhtml_debug_headline'] = '�������� �������������� XHTML';
	$l_prefs['xhtml_debug_html'] = '������������ �������� �������������� XHTML';
	$l_prefs['xhtml_remove_wrong'] = '������� �������� ��������';
	$l_prefs['xhtml_show_wrong_headline'] = '���������� ��� ������� �������� ���������';
	$l_prefs['xhtml_show_wrong_html'] = '������������';
	$l_prefs['xhtml_show_wrong_text_html'] = '��� �����';
	$l_prefs['xhtml_show_wrong_js_html'] = '��� JavaScript-Alert';
	$l_prefs['xhtml_show_wrong_error_log_html'] = '������ ������ (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="����������� ��������� ����� <br>������������ � ���������";
	$l_prefs["we_max_upload_size_hint"]="(� MByte, 0=automatic)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="����� ������� �<br>����� �����������";
	$l_prefs["we_new_folder_mod_hint"]="(�� ��������� 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "���������� �� ��������� ������� ���� ��������� ������ ���� ����������� � ������� ������� ������������, ��� �������������� ��� ����������� ������ ���������������� ���� ���������.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "������� ������� ������� ������������ ������ ���� ����������� � ���������� �� ���������, �������� � ���� ��������� ������������, �������� ����� ������ ���� ���������.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "��������� ";
   $l_prefs["we_doctype_workspace_behavior_0"] = "�����������";
   $l_prefs["we_doctype_workspace_behavior"] = "��������� ���������� ���� ���������";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Use java upload'; // TRANSLATE

?>