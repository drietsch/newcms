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
 * Language file: users.inc.php
 * Provides language strings.
 * Language: English
 */
$l_users["user_same"] = "The owner cannot be deleted!";
$l_users["grant_owners_ok"] = "Owners have been successfully changed!";
$l_users["grant_owners_notok"] = "There was an error while changing the owners!";
$l_users["grant_owners"] = "Change owners";
$l_users["grant_owners_expl"] = "Change the owners of all files and directories which reside in the current directory to the owner setting above.";
$l_users["make_def_ws"] = "Default";
$l_users["user_saved_ok"] = "User '%s' has been successfully saved!";
$l_users["group_saved_ok"] = "Group '%s' X has been successfully saved!";
$l_users["alias_saved_ok"] = "Alias '%s' has been successfully saved!";
$l_users["user_saved_nok"] = "User '%s' cannot be saved!";
$l_users["nothing_to_save"] = "Nothing to save!";
$l_users["username_exists"] = "User name '%s' already exists!";
$l_users["username_empty"] = "User name is empty!";
$l_users["user_deleted"] = "User '%s' is deleted!";
$l_users["nothing_to_delete"] = "Nothing to delete!";
$l_users["delete_last_user"] = "You are trying to delete the last user with administrator rights. Deleting would make the system unmanageable! Therefore deleting is not possible.";
$l_users["modify_last_admin"] = "There must be at least one administrator. You cannot change the rights of the last administrator.";
$l_users["user_path_nok"] = "The path is not correct!";
$l_users["user_data"] = "User data";
$l_users["first_name"] = "First name";
$l_users["second_name"] = "Last name";
$l_users["username"] = "User name";
$l_users["password"] = "Password";
$l_users["workspace_specify"] = "Specify workspace";
$l_users["permissions"] = "Permissions";
$l_users["user_permissions"] = "User permissions";
$l_users["admin_permissions"] = "Administrator permissions";
$l_users["password_alert"] = "Password must be at least 4 characters long.";
$l_users["delete_alert_user"] = "All user data for user '%s' will be deleted.\\nAre you sure that you wish to do this?";
$l_users["delete_alert_alias"] = "All alias data for alias '%s' will be deleted.\\nAre you sure that you wish to do this?";
$l_users["delete_alert_group"] = "All group data and group users of group '%s' will be deleted.\\nAre you sure that you wish to do this?";
$l_users["created_by"] = "Created by";
$l_users["changed_by"] = "Changed by:";
$l_users["no_perms"] = "You have no permission to use this option!";
$l_users["publish_specify"] = "User is allowed to publish.";
$l_users["work_permissions"] = "Working permissions";
$l_users["control_permissions"] = "Control permissions";
$l_users["log_permissions"] = "Login permissions";
$l_users["file_locked"][FILE_TABLE] = "The file '%s' is currently being used by '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "The template '%s' is currently being used by '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "The class '%s' is currently being used by '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "The object '%s' is currently being used by '%s'!";
}
$l_users["acces_temp_denied"] = "Access temporarily denied!";
$l_users["description"] = "Description";
$l_users["group_data"] = "Group data";
$l_users["group_name"] = "Group name";
$l_users["group_member"] = "Group membership";
$l_users["group"] = "Group";
$l_users["address"] = "Address";
$l_users["houseno"] = "House number/apartment";
$l_users["state"] = "State";
$l_users["PLZ"] = "Zip";
$l_users["city"] = "City";
$l_users["country"] = "Country";
$l_users["tel_pre"] = "Phone area code";
$l_users["fax_pre"] = "Fax area code";
$l_users["telephone"] = "Phone";
$l_users["fax"] = "Fax";
$l_users["mobile"] = "Mobile";
$l_users["email"] = "E-Mail";
$l_users["general_data"] = "General data";
$l_users["workspace_documents"] = "Workspace documents";
$l_users["workspace_templates"] = "Workspace templates";
$l_users["workspace_objects"] = "Workspace Objects";
$l_users["save_changed_user"] = "User has been changed.\\nDo you want to save your changes?";
$l_users["not_able_to_save"] = "Data has not been saved because of invalidity of data!";
$l_users["cannot_save_used"] = "Status cannot be changed because it is in processing!";
$l_users["geaendert_von"] = "Changed by";
$l_users["geaendert_am"] = "Changed at";
$l_users["angelegt_am"] = "Set up at";
$l_users["angelegt_von"] = "Set up by";
$l_users["status"] = "Status";
$l_users["value"] = " Value ";
$l_users["gesperrt"] = "restricted";
$l_users["freigegeben"] = "open";
$l_users["gelöscht"] = "deleted";
$l_users["ohne"] = "without";
$l_users["user"] = "User";
$l_users["usertyp"] = "User type";
$l_users["search"] = "Suche";
$l_users["search_result"] = "Ergebnis";
$l_users["search_for"] = "Suche nach";
$l_users["inherit"] = "Inherit permissions from parent group.";
$l_users["inherit_ws"] = "Inherit documents workspace from parent group.";
$l_users["inherit_wst"] = "Inherit templates workspace from parent group.";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group";
$l_users["organization"] = "Organization";
$l_users["give_org_name"] = "Organization name";
$l_users["can_not_create_org"] = "The organisation cannot be created";
$l_users["org_name_empty"] = "Organization name is empty";
$l_users["salutation"] = "Salutation";
$l_users["sucheleer"] = "Search word is empty!";
$l_users["alias_data"] = "Alias data";
$l_users["rights_and_workspaces"] = "Permissions and<br>workspaces";
$l_users["workspace_navigations"] = "Workspave Navigation";
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group";
$l_users["workspace_newsletter"] = "Workspace Newsletter";
$l_users["inherit_wsnl"] = "Inherit newsletter workspaces from parent group";

$l_users["delete_user_same"] = "Sie können nicht Ihr eigenes Konto löschen.";
$l_users["delete_group_user_same"] = "Sie können nicht Ihre eigene Gruppe löschen.";

$l_users["login_denied"] = "Login denied";
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>