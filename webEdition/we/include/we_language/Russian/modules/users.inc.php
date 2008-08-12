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
$l_users["user_same"] = "Собственный пользователь не может быть удален!";
$l_users["grant_owners_ok"] = "Владельцы успешно назначены!";
$l_users["grant_owners_notok"] = "Ошибка при назначении владельцев!";
$l_users["grant_owners"] = "Назначить владельцев";
$l_users["grant_owners_expl"] = "Подчинить заданным выше владельцам и пользователям все файлы и директории, находящиеся в текущей директории";
$l_users["make_def_ws"] = "По умолчанию";
$l_users["user_saved_ok"] = "Пользователь '%s' успешно сохранен!";
$l_users["group_saved_ok"] = "Группа '%s' успешно сохранена";
$l_users["alias_saved_ok"] = "Алиас '%s' успешно сохранен";
$l_users["user_saved_nok"] = "Пользователь '%s' не может быть сохранен!";
$l_users["nothing_to_save"] = "Нет предмета для сохранения!";
$l_users["username_exists"] = "Имя пользователя '%s' уже существует!";
$l_users["username_empty"] = "Имя пользователя не заполнено!";
$l_users["user_deleted"] = "Пользователь '%s' удален!";
$l_users["nothing_to_delete"] = "Нет предмета удаления!";
$l_users["delete_last_user"] = "Для управления требуется по меньшей мере один администратор.\\nВы не можете удалить последнего администратора.";
$l_users["modify_last_admin"] = "Для управления требуется по меньшей мере один администратор.\\nВы не можете изменить права последнего адинистратора.";
$l_users["user_path_nok"] = "Путь не верен!";
$l_users["user_data"] = "Данные пользователя";
$l_users["first_name"] = "Имя";
$l_users["second_name"] = "Фамилия";
$l_users["username"] = "Имя пользователя";
$l_users["password"] = "Пароль";
$l_users["workspace_specify"] = "Установить рабочую область";
$l_users["permissions"] = "Права";
$l_users["user_permissions"] = "Полномочия пользователя/редактора";
$l_users["admin_permissions"] = "Полномочия администратора";
$l_users["password_alert"] = "Пароль должен состоять минимум из 4 знаков"; 
$l_users["delete_alert_user"] = "All user data for user '%s' will be deleted.\\n Are you sure that you wish to do this?"; // TRANSLATE
$l_users["delete_alert_alias"] = "Все данные алиаса '%s' будут удалены.\\n Вы уверены?";
$l_users["delete_alert_group"] = "Все данные группы и пользователей группы '%s' будут удалены. Вы уверены?";
$l_users["created_by"] = "Создано пользователем:";
$l_users["changed_by"] = "Изменено пользователем:";
$l_users["no_perms"] = "У Вас нет полномочий на данную опцию!";
$l_users["publish_specify"] = "User is allowed to publish."; // TRANSLATE 
$l_users["work_permissions"] = "Working permissions"; // TRANSLATE
$l_users["control_permissions"] = "Control permissions"; // TRANSLATE
$l_users["log_permissions"] = "Login permissions"; // TRANSLATE
$l_users["file_locked"][FILE_TABLE] = "В данный момент файл '%s' обрабатывается пользователем '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "В данный момент шаблон '%s' обрабатывается пользователем '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "В данный момент класс '%s' обрабатывается пользователем '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "В данный момент объект '%s' обрабатывается пользователем '%s'!";
}
$l_users["acces_temp_denied"] = "Доступ временно отклонен";  
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
$l_users["workspace_documents"] = "Документы рабочей области";
$l_users["workspace_templates"] = "Шаблоны рабочей области";
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
$l_users["gelцscht"] = "deleted"; // TRANSLATE
$l_users["ohne"] = "without"; // TRANSLATE
$l_users["user"] = "Пользователь";
$l_users["usertyp"] = "Тип пользователя";
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
$l_users["sucheleer"] = "Не введено ключевое слово для поиска";
$l_users["alias_data"] = "Alias data"; // TRANSLATE
$l_users["rights_and_workspaces"] = "Права и<br>рабочие<br>области";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>