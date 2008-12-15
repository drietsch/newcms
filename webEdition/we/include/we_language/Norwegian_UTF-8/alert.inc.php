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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["notice"] = "Notice";
$l_alert["warning"] = "Warning";
$l_alert["error"] = "Error";

$l_alert["noRightsToDelete"] = "\\'%s\\' cannot be deleted! You do not have permission to perform this action!";
$l_alert["noRightsToMove"] = "\\'%s\\' cannot be moved! You do not have permission to perform this action!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "The document has to be saved before it can be put in the workflow!\\nDo you want to save the document right now?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "The object has to be saved before it can be put in the workflow!\\nDo you want to save the document right now?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "The class has to be saved before it can be put in the workflow!\\nDo you want to save the class right now?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "The template has to be saved before it can be put in the workflow!\\nDo you want to save the template right now?";
$l_alert[FILE_TABLE]["not_im_ws"] = "The file is not located inside your workspace!";
$l_alert["folder"]["not_im_ws"] = "The folder is not located inside your workspace!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "The template is not located inside your workspace!";
$l_alert["delete_recipient"] = "Do you really want to delete the selected E-mail address?";
$l_alert["recipient_exists"] = "That E-mail address already exists!";
$l_alert["input_name"] = "Enter a new E-mail address!";
$l_alert['input_file_name'] = "Enter a filename.";
$l_alert["max_name_recipient"] = "An Email address may only be 255 characters long!";
$l_alert["not_entered_recipient"] = "No E-mail address has been entered!";
$l_alert["recipient_new_name"] = "Change E-mail address!";
$l_alert["no_new"]["objectFile"] = "You are not allowed to create new objects!<br>Either you have no permission or there is no class where one of your workspaces is valid!";
$l_alert["required_field_alert"] = "The field '%s' is required and has to be filled!";
$l_alert["phpError"] = "webEdition cannot be started!";
$l_alert["3timesLoginError"] = "Login failed %s times! Please wait %s minutes and try again!";
$l_alert["popupLoginError"] = "The webEdition window could not be opened!\\n\\nwebEdition can be started only when your browser does not block pop-up windows.";
$l_alert['publish_when_not_saved_message'] = "The document has not yet been saved! Do you want to publish it anyway?";
$l_alert["template_in_use"] = "The template is in use and cannot be removed!";
$l_alert["no_cookies"] = "You have not activated cookies. Please activate cookies in your browser!";
$l_alert["doctype_hochkomma"] = "Invalid name! Invalid characters are ' (apostrophe) , (comma) and \" (quote)!";
$l_alert["thumbnail_hochkomma"] = "Invalid name! Invalid characters are ' (apostrophe) and , (comma)!";
$l_alert["can_not_open_file"] = "The file %s could not be opened!";
$l_alert["no_perms_title"] = "Permission denied!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action.";
$l_alert["access_denied"] = "Access denied!";
$l_alert["no_perms"] = "Please contact the owner (%s) or an administrator<br>if you need access!";
$l_alert["temporaere_no_access"] = "Access not possible!";
$l_alert["temporaere_no_access_text"] = "The file \"%s\" is being edited by \"%s\" at the moment.";
$l_alert["file_locked_footer"] = "This document is edited by \"%s\" at the moment.";
$l_alert["file_no_save_footer"] = "You don't have the permissions to save this file.";
$l_alert["login_failed"] = "Wrong user name and/or password!";
$l_alert["login_failed_security"] = "webEdition could not be started!\\n\\nFor security reasons the login process was aborted, because the maximum time to log into webEdition has been exceeded!\\n\\nPlease login again.";
$l_alert["perms_no_permissions"] = "You are not permitted to perform this action!";
$l_alert["no_image"] = "The file you have selected is not an image!";
$l_alert["delete_ok"] = "Files or directories successfully deleted!";
$l_alert["delete_cache_ok"] = "Cache successfully deleted!";
$l_alert["nothing_to_delete"] = "There is nothing marked for deletion!";
$l_alert["delete"] = "Delete selected entries?\\nDo you want to continue?";
$l_alert["delete_cache"] = "Delete cache for the selected entries?\\nDo you want to continue?";
$l_alert["delete_folder"] = "Delete selected directory?\\nPlease note: When deleting a directory, all documents and directories within it are also automatically erased!\\nDo you want to continue?";
$l_alert["delete_nok_error"] = "The file '%s' cannot be deleted.";
$l_alert["delete_nok_file"] = "The file '%s' cannot be deleted.\\nIt is possibly write protected. ";
$l_alert["delete_nok_folder"] = "The directory '%s' cannot be deleted.\\nIt is possible that it is write-protected.";
$l_alert["delete_nok_noexist"] = "File '%s' does not exist!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move_exit_open_docs_question"] = "Before moving all %s must be closed.\\nIf you continue, the following %s will be closed, unsaved changes will not be saved.\\n\\n";
$l_alert["move_exit_open_docs_continue"] = 'Continue?';
$l_alert["move"] = "Move selected entries?\\nDo you want to continue?";
$l_alert["move_ok"] = "Files successfully moved!";
$l_alert["move_duplicate"] = "There are files with the same name in the target directory!\\nThe files cannot be moved.";
$l_alert["move_nofolder"] = "The selected files cannot be moved.\\nIt isn't possible to move directories.";
$l_alert["move_onlysametype"] = "The selected objects cannnot be moved.\\nObjects can only be moved in there own classdirectory.";
$l_alert["move_no_dir"] = "Please choose a target directory!";
$l_alert["document_move_warning"] = "After moving documents it is  necessary to do a rebuild.<br />Would you like to do this now?";
$l_alert["nothing_to_move"] = "There is nothing marked to move!";
$l_alert["move_of_files_failed"] = "One or more files couldn't moved! Please move these files manually.\\nThe following files are affected:\\n%s";
$l_alert["template_save_warning"] = "This template is used by %s published documents. Should they be resaved? Attention: This procedure may take some time if you have many documents!";
$l_alert["template_save_warning1"] = "This template is used by one published document. Should it be resaved?";
$l_alert["template_save_warning2"] = "This template is used by other templates and documents, should they be resaved?";
$l_alert["thumbnail_exists"] = 'This thumbnail already exists!';
$l_alert["thumbnail_not_exists"] = 'This thumbnail does not exist!';
$l_alert["doctype_exists"] = "This document type already exists!";
$l_alert["doctype_empty"] = "You must enter a name for the new document type!";
$l_alert["delete_cat"] = "Do you really want to delete the selected category?";
$l_alert["delete_cat_used"] = "This category is in use and cannot be deleted!";
$l_alert["cat_exists"] = "That category already exists!";
$l_alert["cat_changed"] = "The category is in use! Resave the documents which are using the category!\\nShould the category be modified anyway?";
$l_alert["max_name_cat"] = "A category name may only be 32 characters long!";
$l_alert["not_entered_cat"] = "No category name has been entered!";
$l_alert["cat_new_name"] = "Enter the new name for the category!";
$l_alert["we_backup_import_upload_err"] = "An error occured while uploading the backup file! The maximum file size for uploads is %s. If your backup file exceeds this limit, please upload it into the directory webEdition/we_Backup via FTP and choose '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "No documents match the selected attributes.";
$l_alert["we_name_not_allowed"] = "The terms 'we' and 'webEdition' are reserved words and may not be used!";
$l_alert["we_filename_empty"] = "No name has been entered for this document or directory!";
$l_alert["exit_multi_doc_question"] = "Several open documents contain unsaved changes. If you continue all unsaved changes are discarded. Do you want to continue and discard all modifications?";
$l_alert["exit_doc_question_".FILE_TABLE] = "The document has been changed.<BR> Would you like to save your changes?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "The template has been changed.<BR> Would you like to save your changes?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "The class has been changed.<BR> Would you like to save your changes?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "The object has been changed.<BR> Would you like to save your changes?";
}
$l_alert["deleteTempl_notok_used"] = "One or more of the templates are in use and could not be deleted!";
$l_alert["deleteClass_notok_used"] = "One or more of the classes are in use and could not be deleted!";
$l_alert["delete_notok"] = "Error while deleting!";
$l_alert["nothing_to_save"] = "The save function is disabled at the moment!";
$l_alert["nothing_to_publish"] = "The publish function is disabled at the moment!";
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "The selected image is empty.\\n Continue?";
$l_alert["path_exists"] = "The file or document %s cannot be saved because another document is already in its place!";
$l_alert["folder_not_empty"] = "One or more directories are not completely empty and hence could not be erased! Erase the files by hand.\\n The following files are effected:\\n%s";
$l_alert["name_nok"] = "The names must not contain characters like '<' or '>'!";
$l_alert["found_in_workflow"] = "One or more selected entries are in the workflow process! Do you want to remove them from the workflow process?";
$l_alert["import_we_dirs"] = "You are trying to import from a webEdition directory!\\n Those directories are used and protected by webEdition and therefore cannot be used for import!";
$l_alert["wrong_file"]["image/*"] = "The file could not be stored. Either it is not an image or your webspace is exhausted!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "The file could not be stored. Either it is not a Flash movie or your disk space is exhausted!";
$l_alert["wrong_file"]["video/quicktime"] = "The file could not be stored. Either it is not a Quicktime movie or your disk space is exhausted!";
$l_alert["wrong_file"]["text/css"] = "The file could not be stored. Either it is not a CSS file or your disk space is exhausted!"; // TRANSLATE
$l_alert["no_file_selected"] = "No file has been choosen for upload!";
$l_alert["browser_crashed"] = "The window could not be opened because of an error with your browser!  Please save your work and restart the browser.";
$l_alert["copy_folders_no_id"] = "Please save the current directory first!";
$l_alert["copy_folder_not_valid"] =  "The same directory or one of the parent directories can not be copied!";
$l_alert['no_views']['headline'] = 'Attention';
$l_alert['no_views']['description'] = 'There is no view for this document available.';
$l_alert['navigation']['last_document'] = 'You edit the last document.';
$l_alert['navigation']['first_document'] = 'You edit the first document.';
$l_alert['navigation']['doc_not_found'] = 'Could not find matching document.';
$l_alert['navigation']['no_entry'] = 'No entry found in history.';
$l_alert['navigation']['no_open_document'] = 'There is no open document.';
$l_alert['delete_single']['confirm_delete'] = 'Delete this document?';
$l_alert['delete_single']['no_delete'] = 'This document could not be deleted.';
$l_alert['delete_single']['return_to_start'] = 'The document was deleted. \\nBack to seeMode startdocument.';
$l_alert['move_single']['return_to_start'] = 'The document was moved. \\nBack to seeMode startdocument.';
$l_alert['move_single']['no_delete'] = 'This document could not be moved';
$l_alert['cockpit_not_activated'] = 'The action could not be performed because the cockpit is not activated.';
$l_alert['cockpit_reset_settings'] = 'Are you sure to delete the current Cockpit settings and reset the default settings?';
$l_alert['save_error_fields_value_not_valid'] = 'The highlighted fields contain invalid data.\\nPlease enter valid data.';

$l_alert['eplugin_exit_doc'] = "The document has been edited with extern editor. The connection between webEdition and extern editor will be closed and the content will not be synchronized anymore.\\nDo you want to close the document?";

$l_alert['delete_workspace_user'] = "The directory %s could not be deleted! It is defined as workspace for the following users or groups:\\n%s";
$l_alert['delete_workspace_user_r'] = "The directory %s could not be deleted! Within the directory there are other directories which are defined as workspace for the following users or groups:\\n%s";
$l_alert['delete_workspace_object'] = "The directory %s could not be deleted! It is defined as workspace for the following objects:\\n%s";
$l_alert['delete_workspace_object_r'] = "The directory %s could not be deleted! Within the directory there are other directories which are defined as workspace in the following objects:\\n%s";


$l_alert['field_contains_incorrect_chars'] = "A field (of the type %s) contains invalid characters.";
$l_alert['field_input_contains_incorrect_length'] = "The maximum length of a field of the type \'Text input\' is 255 characters. If you need more characters, use a field of the type \'Textarea\'.";
$l_alert['field_int_contains_incorrect_length'] = "The maximum length of a field of the type \'Integer\' is 10 characters.";
$l_alert['field_int_value_to_height'] = "The maximum value of a field of the type \'Integer\' is 2147483647.";


$l_alert["we_filename_notValid"] = "Invalid file name\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";

$l_alert["login_denied_for_user"] = "The user cannot login. The user access is disabled.";
$l_alert["no_perm_to_delete_single_document"] = "You have not the needed permissions to delete the active document.";

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "The document has been moved to a folder with divergent customer account policies. Should the settings of the folder be transmitted to this document?";
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "The directory has been moved to a folder with divergent customers account policies. Should the settings be adopted for this directory and all subelements? ";

$l_alert['field_in_tab_notvalid_pre'] = "The settings could not be saved, because the following fields contain invalid values:";
$l_alert['field_in_tab_notvalid'] = ' - field %s on tab %s';
$l_alert['field_in_tab_notvalid_post'] = 'Correct the fields before saving the settings.'; 
$l_alert['discard_changed_data'] = 'There are unsaved changes that will be discarded. Are you sure?';
?>