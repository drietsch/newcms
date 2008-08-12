<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: customer.inc.php,v 1.25 2008/01/21 14:19:22 alexander.lindenstruth Exp $

/**
 * Language file: customer.inc.php
 * Provides language strings.
 * Language: English
 */

$l_customer["menu_customer"] = "Customer";
$l_customer["menu_new"] = "New";
$l_customer["menu_save"] = "Save";
$l_customer["menu_delete"] = "Delete";
$l_customer["menu_exit"] = "Close";
$l_customer["menu_info"] = "Info";
$l_customer["menu_help"] = "Help";

$l_customer["menu_admin"] = "Administration";

$l_customer["save_changed_customer"] = "Customer has been changed.\\nDo you want to save your changes?";
$l_customer["customer_saved_ok"] = "Customer '%s' was successfully saved.";
$l_customer["customer_saved_nok"] = "Customer '%s' cannot be saved";
$l_customer["nothing_to_save"] = "There is nothing to save";
$l_customer["username_exists"] = "User name '%s' already exists!";
$l_customer["username_empty"] = "User name has not been filled in!";
$l_customer["password_empty"] = "Password has not been filled in!";
$l_customer["customer_deleted"] = "Customer was successfully deleted.";
$l_customer["nothing_to_delete"] = "There is nothing to delete!";

$l_customer["no_space"] = "Spaces are not allowed.";

$l_customer["customer_data"] = "Customer details";
$l_customer["first_name"] = "Firstname";
$l_customer["second_name"] = "Name";
$l_customer["username"] = "User name";
$l_customer["password"] = "Password";

$l_customer["login"] = "Login";
$l_customer["login_denied"] = "Access denied";

$l_customer["permissions"] = "Permissions";

$l_customer["password_alert"] = "The password must be at least 4 characters long.";
$l_customer["delete_alert"] = "Delete all customer details.\\nAre you sure?";

$l_customer["created_by"] = "Created by";
$l_customer["changed_by"] = "Changed by";

$l_customer["no_perms"] = "You do not have permission to use this option.";
$l_customer["topic"] = "Topic";

$l_customer["not_nummer"] = "Initial letter cannot be a number.";
$l_customer["field_not_empty"] = "The field name must be completed.";
$l_customer["delete_field"] = "Are you sure that you want to delete this field? This process cannot be reversed.";

$l_customer["display"] = "Show";

$l_customer["insert_field"] = "Insert field";

//---- new things

$l_customer["customer"] = "Customer";
$l_customer["common"] = "General";
$l_customer["all"] = "All";
$l_customer["sort"] = "Sort";
$l_customer["branch"] = "View";

$l_customer["field_name"] = "Name";
$l_customer["field_type"] = "Type";
$l_customer["field_default"] = "Default";
$l_customer["add_mail"] = "Insert E-mail";
$l_customer["edit_mail"] = "Edit E-mail";

$l_customer["no_branch"] = "No view has been selected!";
$l_customer["no_field"] = "No field has been selected!";

$l_customer["field_saved"] = "Field is saved.";
$l_customer["field_deleted"] = "Field is deleted from %s view.";
$l_customer["del_fild_question"] = "Do you want to delete the field?";

$l_customer["field_admin"] = "Fields administration";
$l_customer["sort_admin"] = "Sort administration";

$l_customer["name"] = "Name";
$l_customer["sort_branch"] = "View";
$l_customer["sort_field"] = "Field";
$l_customer["sort_order"] = "Order";
$l_customer["sort_saved"] = "Sort is saved.";
$l_customer["sort_name"] = "sort";
$l_customer["sort_function"] = "Function";
$l_customer["no_sort"] = "--No Sort--";

$l_customer["branch_select"] = "Select view";
$l_customer["fields"] = "Fields";

$l_customer["add_sort_group"] = "Insert new group";
$l_customer["search"] = "Search";
$l_customer["search_for"] = "Search for";
$l_customer["simple_search"] = "Simple search";
$l_customer["advanced_search"] = "Advanced search";
$l_customer["search_result"] = "Result";

$l_customer["no_value"] = "[-No value-]";
$l_customer["other"] = "Other";

$l_customer["cannot_save_property"] = "The '%s' field is protected and cannot be saved!";

$l_customer["settings"] = "Settings";

$l_customer["Username"] = "Username";
$l_customer["Password"] = "Password";
$l_customer["Forname"] = "First name";
$l_customer["Surname"] = "Last name";
$l_customer["MemeberSince"] = "Member since";
$l_customer["LastLogin"] = "Last login";
$l_customer["LastAccess"] = "Last access";

$l_customer["default_date_type"] = "Default date format";
$l_customer["custom_date_format"] = "Custom date format";
$l_customer["default_sort_view"] = "Default sort view";

$l_customer["unix_ts"] = "Unix timestamp";
$l_customer["mysql_ts"] = "MySQL timestamp";
$l_customer["start_year"] = "Start year";

$l_customer["settings_saved"] = "Settings have been saved.";
$l_customer["settings_not_saved"] = "Failed to save settings!";

$l_customer["data"] = "Data";

$l_customer["add_field"] = "Add field";
$l_customer["edit_field"] = "Edit field";

$l_customer["edit_branche"] = "Edit view";
$l_customer["not_implemented"] = "not implemented";
$l_customer["branch_no_edit"] = "The area is protected and cannot be changed!";
$l_customer["name_exists"] = "That name already exists!";

$l_customer["import"] = "Import";
$l_customer["export"] = "Export";

$l_customer["export_title"] = "Export wizard";
$l_customer["import_title"] = "Import wizard";

$l_customer["export_step1"] = "Export format";
$l_customer["export_step2"] = "Select customers";
$l_customer["export_step3"] = "Export data";
$l_customer["export_step4"] = "Export finished";

$l_customer["import_step1"] = "Import format";
$l_customer["import_step2"] = "Import data";
$l_customer["import_step3"] = "Select dataset";
$l_customer["import_step4"] = "Assign data fields";
$l_customer["import_step5"] = "Export finished";

$l_customer["file_format"] = "File format";
$l_customer["export_to"] = "Export to";

$l_customer["export_to_server"] = "Server";
$l_customer["export_to_ftp"] = "FTP";
$l_customer["export_to_local"] = "Local";

$l_customer["ftp_host"] = "Host";
$l_customer["ftp_username"] = "User name";
$l_customer["ftp_password"] = "Password";

$l_customer["filename"] = "File name";
$l_customer["path"] = "Path";

$l_customer["xml_format"] = "XML";
$l_customer["csv_format"] = "CSV";

$l_customer["csv_delimiter"] = "Delimiter";
$l_customer["csv_enclose"] = "Enclose";
$l_customer["csv_escape"] = "Escape";
$l_customer["csv_lineend"] = "Line end";
$l_customer["csv_null"] = "NULL replacment";
$l_customer["csv_fieldnames"] = "First row contains fileds name";

$l_customer["generic_export"] = "Generic export";
$l_customer["gxml_export"] = "Generic-XML export";
$l_customer["txt_gxml_export"] = "Export to \"fleet\" XML file, as e.g phpMyAdmin did. The fields from data set will be mapped to the webEdition fields.";
$l_customer["csv_export"] = "CSV export";
$l_customer["txt_csv_export"] = "Export to CSV file (Comma Separated Values) or other selected text format (z. B. *.txt). The fields from data set will be mapped to the webEdition fields.";
$l_customer["csv_params"] = "CSV file settings";

$l_customer["filter_selection"] = "Filter selection";
$l_customer["manual_selection"] = "Manuel selection";
$l_customer["sortname_empty"] = "Sort name is empty!";
$l_customer["fieldname_exists"] = "The field name already exists!";
$l_customer["treetext_format"] = "Menu text format";
$l_customer["we_filename_notValid"] = "Invalid user name!\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen, dot and whitespace (a-z, A-Z, 0-9, _, -, ., )";

$l_customer["windows"] = "Windows format";
$l_customer["unix"] = "UNIX format";
$l_customer["mac"] = "Mac format";

$l_customer["comma"] = ", {comma}";
$l_customer["semicolon"] = "; {semicolon}";
$l_customer["colon"] = ": {colon}";
$l_customer["tab"] = "\\t {tab}";
$l_customer["space"] = "  {space}";
$l_customer["double_quote"] = "\" {double quote}";
$l_customer["single_quote"] = "' {single quote}";

$l_customer["exporting"] = "Exporting...";
$l_customer["cdata"] = "Coding";
$l_customer["export_xml_cdata"] = "Add CDATA sections";
$l_customer["export_xml_entities"] = "Replace entities";

$l_customer["export_finished"] = "Export finished.";
$l_customer["server_finished"] = "The export file has been saved on the server.";
$l_customer["download_starting"] = "Download of the export file has been started.<br><br>If the download does not start after 10 seconds,<br>";
$l_customer["download"] = "please click here.";
$l_customer["download_failed"] = "Either the file you requested does not exist or you are not permitted to download it.";

$l_customer["generic_import"] = "Generic import";
$l_customer["gxml_import"] = "Generic XML import";
$l_customer["txt_gxml_import"] = "Import \"flat\" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the customer dataset fields.";
$l_customer["csv_import"] = "CSV import";
$l_customer["txt_csv_import"] = "Import CSV files (Comma Separated Values) or modified textformats (e. g. *.txt). The dataset fields are assigned to the customer fields.";
$l_customer["source_file"] = "Source file";

$l_customer["server_import"] = "Import file from server";
$l_customer["upload_import"] = "Import file from the local harddrive.";
$l_customer["file_uploaded"] = "The file is uploaded.";

$l_customer["num_data_sets"] = "Datasets:";
$l_customer["to"] = "to";
$l_customer["well_formed"] = "The XML document is well-formed.";
$l_customer["select_elements"] = "Please choose the datasets to import.";
$l_customer["xml_valid_1"] = "The XML file is valid and contains";
$l_customer["xml_valid_m2"] = "XML child node in the first level with different names. Please choose the XML node and the number of elements to import.";
$l_customer["not_well_formed"] = "The XML document is not well-formed and cannot be imported.";
$l_customer["missing_child_node"] = "The XML document is well-formed, but contains no XML nodes and can therefore not be imported.";

$l_customer["none"] = "-- none --";
$l_customer["any"] = "-- none --";
$l_customer["we_flds"] = "webEdition&nbsp;fields";
$l_customer["rcd_flds"] = "Dataset&nbsp;fields";
$l_customer["attributes"] = "Attribute";
$l_customer["we_title"] = "Title";
$l_customer["we_description"] = "Description";
$l_customer["we_keywords"] = "Keywords";

$l_customer["pfx"] = "Prefix";
$l_customer["pfx_doc"] = "Document";
$l_customer["pfx_obj"] = "Object";
$l_customer["rcd_fld"] = "Dataset field";
$l_customer["auto"] = "Auto";
$l_customer["asgnd"] = "Assigned";

$l_customer["remark_csv"] = "You are able to import CSV files (Comma Separated Values) or modified text formats (e. g. *.txt). The field delimiter (e. g. , ; tab, space) and text delimiter (= which encapsulates the text inputs) can be preset at the import of these file formats.";
$l_customer["remark_xml"] = "To avoid the predefined timeout of a PHP-script, select the option \"Import data-sets separately\", to import large files.<br>If you are unsure whether the selected file is webEdition XML or not, the file can be tested for validity and syntax.";

$l_customer["record_field"] = "Dataset field";
$l_customer["missing_filesource"] = "Source file is empty! Please select a sorce file.";
$l_customer["importing"] = "Importing";
$l_customer["same_names"] = "Same names";
$l_customer["same_rename"] = "Rename";
$l_customer["same_overwrite"] = "Overwrite";
$l_customer["same_skip"] = "Skip";

$l_customer["rename_customer"] = "The customer '%s' has been renamed to '%s'";
$l_customer["overwrite_customer"] = "The customer '%s' has been overwritten";
$l_customer["skip_customer"] = "The customer '%s' has been skipped";

$l_customer["import_finished_desc"] = "%s new customers have been imported!";
$l_customer["show_log"] = " Warnings";
$l_customer["import_step5"] = "Import finished";

$l_customer["view"] = "View";
$l_customer["registered_user"] = "registered User";
$l_customer["unregistered_user"] = "unregistered User";

$l_customer["default_soting_no_del"]="The sort is used in settings and must not be deleted!";
$l_customer["we_fieldname_notValid"] = "Invalid field name!\\nValid characters are alpha-numeric, upper and lower case, as well as underscore (a-z, A-Z, 0-9, _)";

$l_customer["orderTab"] = 'Orders of this customer';
$l_customer['default_order'] = 'pre-set order';

$l_customer["connected_with_customer"] = "Connected with customer";
$l_customer["one_customer"] = "Customer";


?>