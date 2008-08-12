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
 * Language file: users.inc.php
 * Provides language strings.
 * Language: English
 */
$l_users["user_same"] = "����������� ������������ �� ����� ���� ������!";
$l_users["grant_owners_ok"] = "��������� ������� ���������!";
$l_users["grant_owners_notok"] = "������ ��� ���������� ����������!";
$l_users["grant_owners"] = "��������� ����������";
$l_users["grant_owners_expl"] = "��������� �������� ���� ���������� � ������������� ��� ����� � ����������, ����������� � ������� ����������";
$l_users["make_def_ws"] = "�� ���������";
$l_users["user_saved_ok"] = "������������ '%s' ������� ��������!";
$l_users["group_saved_ok"] = "������ '%s' ������� ���������";
$l_users["alias_saved_ok"] = "����� '%s' ������� ��������";
$l_users["user_saved_nok"] = "������������ '%s' �� ����� ���� ��������!";
$l_users["nothing_to_save"] = "��� �������� ��� ����������!";
$l_users["username_exists"] = "��� ������������ '%s' ��� ����������!";
$l_users["username_empty"] = "��� ������������ �� ���������!";
$l_users["user_deleted"] = "������������ '%s' ������!";
$l_users["nothing_to_delete"] = "��� �������� ��������!";
$l_users["delete_last_user"] = "��� ���������� ��������� �� ������� ���� ���� �������������.\\n�� �� ������ ������� ���������� ��������������.";
$l_users["modify_last_admin"] = "��� ���������� ��������� �� ������� ���� ���� �������������.\\n�� �� ������ �������� ����� ���������� �������������.";
$l_users["user_path_nok"] = "���� �� �����!";
$l_users["user_data"] = "������ ������������";
$l_users["first_name"] = "���";
$l_users["second_name"] = "�������";
$l_users["username"] = "��� ������������";
$l_users["password"] = "������";
$l_users["workspace_specify"] = "���������� ������� �������";
$l_users["permissions"] = "�����";
$l_users["user_permissions"] = "���������� ������������/���������";
$l_users["admin_permissions"] = "���������� ��������������";
$l_users["password_alert"] = "������ ������ �������� ������� �� 4 ������"; 
$l_users["delete_alert_user"] = "All user data for user '%s' will be deleted.\\n Are you sure that you wish to do this?"; // TRANSLATE
$l_users["delete_alert_alias"] = "��� ������ ������ '%s' ����� �������.\\n �� �������?";
$l_users["delete_alert_group"] = "��� ������ ������ � ������������� ������ '%s' ����� �������. �� �������?";
$l_users["created_by"] = "������� �������������:";
$l_users["changed_by"] = "�������� �������������:";
$l_users["no_perms"] = "� ��� ��� ���������� �� ������ �����!";
$l_users["publish_specify"] = "User is allowed to publish."; // TRANSLATE 
$l_users["work_permissions"] = "Working permissions"; // TRANSLATE
$l_users["control_permissions"] = "Control permissions"; // TRANSLATE
$l_users["log_permissions"] = "Login permissions"; // TRANSLATE
$l_users["file_locked"][FILE_TABLE] = "� ������ ������ ���� '%s' �������������� ������������� '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "� ������ ������ ������ '%s' �������������� ������������� '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "� ������ ������ ����� '%s' �������������� ������������� '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "� ������ ������ ������ '%s' �������������� ������������� '%s'!";
}
$l_users["acces_temp_denied"] = "������ �������� ��������";  
$l_users["description"] = "Description"; // TRANSLATE
$l_users["group_data"] = "Group data"; // TRANSLATE
$l_users["group_name"] = "Group name"; // TRANSLATE
$l_users["group_member"] = "Group membership"; // TRANSLATE
$l_users["group"] = "Group"; // TRANSLATE
$l_users["address"] = "Address"; // TRANSLATE
$l_users["houseno"] = "House number/apartment"; // TRANSLATE
$l_users["state"] = "State"; // TRANSLATE
$l_users["PLZ"] = "Zip"; // TRANSLATE
$l_users["city"] = "City"; // TRANSLATE
$l_users["country"] = "Country"; // TRANSLATE
$l_users["tel_pre"] = "Phone area code"; // TRANSLATE
$l_users["fax_pre"] = "Fax area code"; // TRANSLATE
$l_users["telephone"] = "Phone"; // TRANSLATE
$l_users["fax"] = "Fax"; // TRANSLATE
$l_users["mobile"] = "Mobile"; // TRANSLATE
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "General data"; // TRANSLATE
$l_users["workspace_documents"] = "��������� ������� �������";
$l_users["workspace_templates"] = "������� ������� �������";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "User has been changed.\\nDo you want to save your changes?"; // TRANSLATE
$l_users["not_able_to_save"] = "Data has not been saved because of invalidity of data!"; // TRANSLATE
$l_users["cannot_save_used"] = "Status cannot be changed because it is in processing!"; // TRANSLATE
$l_users["geaendert_von"] = "Changed by"; // TRANSLATE
$l_users["geaendert_am"] = "Changed at"; // TRANSLATE
$l_users["angelegt_am"] = "Set up at"; // TRANSLATE
$l_users["angelegt_von"] = "Set up by"; // TRANSLATE
$l_users["status"] = "Status"; // TRANSLATE
$l_users["value"] = " Value "; // TRANSLATE
$l_users["gesperrt"] = "restricted"; // TRANSLATE
$l_users["freigegeben"] = "open"; // TRANSLATE
$l_users["gel�scht"] = "deleted"; // TRANSLATE
$l_users["ohne"] = "without"; // TRANSLATE
$l_users["user"] = "������������";
$l_users["usertyp"] = "��� ������������";
$l_users["serach_results"] = "Search result"; // TRANSLATE
$l_users["inherit"] = "Inherit permissions from parent group."; // TRANSLATE
$l_users["inherit_ws"] = "Inherit documents workspace from parent group."; // TRANSLATE
$l_users["inherit_wst"] = "Inherit templates workspace from parent group."; // TRANSLATE
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organization"; // TRANSLATE
$l_users["give_org_name"] = "Organization name"; // TRANSLATE
$l_users["can_not_create_org"] = "The organisation cannot be created"; // TRANSLATE
$l_users["org_name_empty"] = "Organization name is empty"; // TRANSLATE
$l_users["salutation"] = "Salutation"; // TRANSLATE
$l_users["sucheleer"] = "�� ������� �������� ����� ��� ������";
$l_users["alias_data"] = "Alias data"; // TRANSLATE
$l_users["rights_and_workspaces"] = "����� �<br>�������<br>�������";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>