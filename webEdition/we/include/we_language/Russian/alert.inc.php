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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["noRightsToDelete"] = "\\'%s\\' cannot be deleted! You do not have permission to perform this action!";
$l_alert["noRightsToMove"] = "\\'%s\\' cannot be moved! You do not have permission to perform this action!"; // TRANSLATE
$l_alert[FILE_TABLE]["in_wf_warning"] = "����� ��������� ������� ��������� � �����, ��� ����� ���������!\\n��������� ��������?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "����� ��������� ������� ������� � �����, ��� ����� ���������!\\n��������� ������?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "����� ��������� ������� ������ � ����� ��� ����� ���������!\\n��������� �����?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "����� ��������� ������� ������� � ����� ��� ����� ���������!\\n��������� ������?";
$l_alert[FILE_TABLE]["not_im_ws"] = "������ ���� �� �� ������ �������� ������������!";
$l_alert["folder"]["not_im_ws"] = "������ ���������� �� �� ������ �������� ������������!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "������ ������ �� �� ������ �������� ������������!";
$l_alert["delete_recipient"] = "�� �������, ��� ������ ������� ��������� ����������� �����?";
$l_alert["recipient_exists"] = "����������� ����� ��� ����������!";
$l_alert["input_name"] = "������� ����� ����������� �����!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "����������� ����� ������ ��������� �� ����� 255 ��������!";
$l_alert["not_entered_recipient"] = "�� ������ ����������� �����!";
$l_alert["recipient_new_name"] = "�������� ����������� �����!";
$l_alert["no_new"]["objectFile"] = "�� �� ������������ ��������� ����� �������!<br>� ��� ���� ��� ����������������  ����������,  ���� ����������� �����, � ������� ������������� ���� ������� ������������!";
$l_alert["required_field_alert"] = "������ ���� '%s' ����������� � ����������!";
$l_alert["phpError"] = "���������� ��������� ������� webEdition";
$l_alert["3timesLoginError"] = "LogIn ��� ������ %s ��� �������! ����������, ��������� %s �����(�) � ���������� �����!";
$l_alert["popupLoginError"] = "���������� ������� ���� webEdition!\\n\\n������� webEdition ����� ���� �������� ������ ��� �������, ���� ��� ������� �� ��������� ���� pop-up.";
$l_alert['publish_when_not_saved_message'] = "�������� ��� �� ��������! �� ��� �� ������ ��� ������������?";
$l_alert["template_in_use"] = "������ ������ � ������ � �� ����� ���� ������!";
$l_alert["no_cookies"] = "�� �� ������������ cookies. �����������, ����������, cookies � ����� ��������!";
$l_alert["doctype_hochkomma"] = "��� �������! ��� ���� ��������� �� ������ ��������� ���������� ' � ������� , !";
$l_alert["thumbnail_hochkomma"] = "������������ ��� ������! ����� ������� ��� �������� ' � ������� , �������� �����������������!";
$l_alert["can_not_open_file"] = "���� %s ���������� �������!";
$l_alert["no_perms_title"] = "��� ����������!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "� ������� ��������!";
$l_alert["no_perms"] = "��� ��������� ������� ����������, ����������, � ��������� �������� (%s)<br> ��� � ��������������! <br>";
$l_alert["temporaere_no_access"] = "������ ����������";
$l_alert["temporaere_no_access_text"] = "� ��������� ������ ���� \"%s\" ����������� \"%s\".";
$l_alert["file_locked_footer"] = "� ��������� ������ ������ �������� ����������� \"%s\".";
$l_alert["file_no_save_footer"] = "� ��� ��� ���������� �� ���������� ������� �����.";
$l_alert["login_failed"] = "�������� ��� ������������ �/��� ������!";
$l_alert["login_failed_security"] = "����� ������� webEdition �������!\\n\\n��������� ��������� �����, ���������� ��� ����� � �������, �, �� ������������ ������������, ������� ����� � ������� ��� �������.\\n\\n����������� ����� ���� � �������.";
$l_alert["perms_no_permissions"] = "� ��� ��� ���������� �� ��� ��������!";
$l_alert["no_image"] = "��������� ���� ���� �� ��������� � �������!";
$l_alert["delete_ok"] = "����� ��� ���������� ������� �������!";
$l_alert["nothing_to_delete"] = "������ �� �������� ��� ��������!";
$l_alert["delete"] = "������� ��������� ������.\\n�� �������?";
$l_alert["delete_folder"] = "������� ��������� ����������?\\n��������: ��� �������� ���������� ��� �� ���������� (��������� � �������������) ����� ������������� �������!";
$l_alert["delete_nok_error"] = "���� '%s' �� ����� ���� ������.";
$l_alert["delete_nok_file"] = "���� '%s' �� ����� ���� ������.\\n��������, �� �������.";
$l_alert["delete_nok_folder"] = "���������� '%s' �� ����� ���� �������.\\n��������, ��� ��������.";
$l_alert["delete_nok_noexist"] = "���� '%s' �� ����������!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move"] = "Move selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["move_ok"] = "Files successfully moved!"; // TRANSLATE
$l_alert["move_duplicate"] = "There are files with the same name in the target directory!\\nThe files cannot be moved."; // TRANSLATE
$l_alert["move_nofolder"] = "The selected files cannot be moved.\\nIt isn't possible to move directories."; // TRANSLATE
$l_alert["move_onlysametype"] = "The selected objects cannnot be moved.\\nObjects can only be moved in there own classdirectory."; // TRANSLATE
$l_alert["move_no_dir"] = "Please choose a target directory!"; // TRANSLATE
$l_alert["nothing_to_move"] = "There is nothing marked to move!"; // TRANSLATE
$l_alert["move_of_files_failed"] = "One or more files couldn't moved! Please move these files manually.\\nThe following files are affected:\\n%s"; // TRANSLATE
$l_alert["template_save_warning"] = "This template is used by %s published documents. Should they be resaved? Attention: This procedure may take some time if you have many documents!"; // TRANSLATE
$l_alert["template_save_warning1"] = "This template is used by one published document. Should it be resaved?"; // TRANSLATE
$l_alert["template_save_warning2"] = "This template is used by other templates and documents, should they be resaved?"; // TRANSLATE
$l_alert["thumbnail_exists"] = '������ ������ ��� ����������!';
$l_alert["thumbnail_not_exists"] = '������ ������ �����������!';
$l_alert["doctype_exists"] = "������ ��� ���������� ��� ����������!";
$l_alert["doctype_empty"] = "������� ��� ��� ������ ���� ����������!";
$l_alert["delete_cat"] = "�� �������, ��� ������ ������� ��������� ���������?";
$l_alert["delete_cat_used"] = "������ ��������� - ����������� � �� ����� ���� �������!";
$l_alert["cat_exists"] = "��������� ��� ����������!";
$l_alert["cat_changed"] = "��������� � ��������! ������������� ���������, ������������ ��� ���������!\\n�������� ������ ���������?";
$l_alert["max_name_cat"] = "��� ��������� ������ ��������� �� ����� 32 ��������!";
$l_alert["not_entered_cat"] = "�� ������� ��� ���������!";
$l_alert["cat_new_name"] = "������� ����� ��� ���������!";
$l_alert["we_backup_import_upload_err"] = "������ ��� �������� ���������� �����! ����������� ���������� ������ ����� ��� �������� ���������� %s. ���� ������ ������ ���������� ����� ��������� ���� ������, ��������� ��� � ���������� webEdition/we_Backup ��� ������ FTP � �������� '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "�� ���������� ����������, ��������������� ��������� ���������.";
$l_alert["we_name_not_allowed"] = "����� 'we' � 'webEdition' ��������������� ��� ������������� ����� �������� � �� ����� ������������� ��� ������ �����!";
$l_alert["we_filename_empty"] = "�� ������� ��� ��� ����� ��������� ��� ����������!";
$l_alert["exit_doc_question_".FILE_TABLE] = "������ ��������, ��-��������, ��� �������. ��������� ���� ���������? <BR>";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "������ ������, ��-��������, ��� �������. ��������� ���� ���������?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "������ �����, ��-��������, ��� �������. ��������� ���� ���������?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "������ ������, ��-��������, ��� �������. ��������� ���� ���������?";
}
$l_alert["deleteTempl_notok_used"] = "���� ��� ��������� �������� ��������� � ��������� � �� ����� ���� �������!";
$l_alert["delete_notok"] = "������ ��� ��������!";
$l_alert["nothing_to_save"] = "������� ���������� � ������ ������ �� ���������!";
$l_alert["we_filename_notValid"] = "������������ ��� �����\\n���������� ������� ���������� �������� �� � �� z, ������� � �����, �����, ������ ����� _, ����� -, ����� . (a-z, A-Z, 0-9, _, -, .).";
$l_alert["empty_image_to_save"] = "��������� ����������� ����������� �����������.\\n ����������?";
$l_alert["path_exists"] = "������ ���� ��� �������� %s �� ��������, ��� ��� ������ �������� ��� ���������� � ��� �� �����!";
$l_alert["folder_not_empty"] = "� ����� � ���, ��� ���� ��� ��������� ���������� �� ��������� ������� �� �����������, �� ������ ���� ��������� �������! ������� ��������� ����� �������: \\n%s";
$l_alert["name_nok"] = "����� �� ������ ��������� �������� '<' � '>'!";
$l_alert["found_in_workflow"] = "��������� � �������� ������ ��������� � ������! ������� �� �� ������?";
$l_alert["import_we_dirs"] = "������� ������������� ������ ����� �� ��������� ���������� webEdition!\\n ��� ���������� �������� ��� ������������� �������� webEdition, ������� ��� �� ����� ���� �������������!";
$l_alert["wrong_file"]["image/*"] = "���������� ��������� ����. �� ���� �� ��������� � ����������� ������, ���� ������������ ������������ � ����!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "���������� ��������� ����.  �� ���� �� ��������� � Flash �������, ���� ������������ ����� �� �����!";
$l_alert["wrong_file"]["video/quicktime"] = "���������� ��������� ����. �� ���� �� ��������� � ������� Quicktime, ���� �� ������� ����� �� �����!";
$l_alert["no_file_selected"] = "�� ������� ����� � ��������!";
$l_alert["browser_crashed"] = "���������� ������� ����: ������, ��������� ���������! ���������, ����������, ���� ���������/�������� � ������������� �������";
$l_alert["copy_folders_no_id"] = "������� ���������, ����������, ������� ����������!";
$l_alert["copy_folder_not_valid"] =  "������ ���������� ���� � �� �� ���������� ��� ������������ ����������!";
$l_alert['no_views']['headline'] = 'Attention'; // TRANSLATE
$l_alert['no_views']['description'] = '������ ����������� ������ �������� � ������ "���".';
$l_alert['navigation']['last_document'] = 'You edit the last document.'; // TRANSLATE
$l_alert['navigation']['first_document'] = '�� ������������ ������ ��������.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.'; // TRANSLATE
$l_alert['navigation']['no_entry'] = 'No entry found in history.'; // TRANSLATE
$l_alert['delete_single']['confirm_delete'] = '������� ������ ��������?';
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.'; // TRANSLATE
$l_alert['delete_single']['return_to_start'] = '�������� ������� ������.\\n����� � �������� ��������� ������ ����� (seeMode).';
$l_alert['move_single']['return_to_start'] = 'The document was moved. \\nBack to seeMode startdocument.'; // TRANSLATE
$l_alert['move_single']['no_delete'] = 'This document could not be moved'; // TRANSLATE
$l_alert['cockpit_not_activated'] = 'The action could not be performed because the cockpit is not activated.'; //TRANSLATE
$l_alert['cockpit_reset_settings'] = 'Are you sure to delete the current Cockpit settings and reset the default settings?'; //TRANSLATE
$l_alert['no_cockpit_mode'] = 'Please, switch to the cockpit to add a new widget.'; // TRANSLATE
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';
?>