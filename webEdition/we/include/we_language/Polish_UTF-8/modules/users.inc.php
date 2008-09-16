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
 * Language file: users.inc.php
 * Provides language strings.
 * Language: English
 */
$l_users["user_same"] = "The owner cannot be deleted!"; // TRANSLATE
$l_users["grant_owners_ok"] = "Udało się przenieść dane właściciela!";
$l_users["grant_owners_notok"] = "Wystąpił błąd przy przenoszeniu właściciela!";
$l_users["grant_owners"] = "Przenieś właściciela";
$l_users["grant_owners_expl"] = "Przenieś ustawionego wyżej właściciela i wszystkich użytkowników na wszystkie pliki i katalogi, które znajdują się w tym katalogu.";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "Zapisano użytkownika '%s'";
$l_users["group_saved_ok"] = "Zapisano grupę '%s'";
$l_users["alias_saved_ok"] = "Zapisano alias '%s'";
$l_users["user_saved_nok"] = "Nie udało się zapisać użytkownika '%s'!";
$l_users["nothing_to_save"] = "Brak obiektów do zapisania!";
$l_users["username_exists"] = "Nazwa użytkownika już istnieje '%s'!";
$l_users["username_empty"] = "Nie wypełniono nazwy użytkownika!";
$l_users["user_deleted"] = "Usunięto użytkownika '%s'!";
$l_users["nothing_to_delete"] = "Brak obiektów do usunięcia!";
$l_users["delete_last_user"] = "Do zarządzania jest potrzebny przynajmniej administrator.\\nNie można usunąć ostatniego administratora.";
$l_users["modify_last_admin"] = "Do zarządzania jest potrzebny przynajmniej administrator.\\n Nie można zmienić uprawnień ostatniego administratora.";
$l_users["user_path_nok"] = "Nieprawidłowa ścieżka!";
$l_users["user_data"] = "Dane użytkowników";
$l_users["first_name"] = "Imię";
$l_users["second_name"] = "Nazwisko";
$l_users["username"] = "Nazwa użytkownika";
$l_users["password"] = "Hasło";
$l_users["workspace_specify"] = "Wyszczególnij obszar roboczy";
$l_users["permissions"] = "Uprawnienia";
$l_users["user_permissions"] = "Redaktor";
$l_users["admin_permissions"] = "Administrator";
$l_users["password_alert"] = "Hasło musi się składać z conajmniej 4 znaków";
$l_users["delete_alert_user"] = "Usunięcie wszystkich danych użytkownika '%s'.\\n Na pewno?";
$l_users["delete_alert_alias"] = "Usunięcie wszystkich danych aliasu dla aliasu '%s'.\\n Na pewno?";
$l_users["delete_alert_group"] = "Usunięcie wszystkich danych grupy i użytkowników grupy dla grupy '%s'.\\nNa pewno?";
$l_users["created_by"] = "Sporządził";
$l_users["changed_by"] = "Zmienił";
$l_users["no_perms"] = "Nie masz uprawnień do korzystania z tej opcji!";
$l_users["publish_specify"] = "Użytkownik może publikować";
$l_users["work_permissions"] = "Uprawnienia robocze";
$l_users["control_permissions"] = "Uprawnienia kontrolne";
$l_users["log_permissions"] = "Prawo do logowania";
$l_users["file_locked"][FILE_TABLE] = "Plik '%s' jest właśnie edytowany przez użytkownika '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Szablon '%s' jest właśnie edytowany przez użytkownika '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Klasa '%s' jest właśnie edytowana przez użytkownika '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Obiekt '%s' jest właśnie edytowany przez użytkownika '%s'!";
}
$l_users["acces_temp_denied"] = "Dostęp jest obecnie niemożliwy";
$l_users["description"] = "Opis";
$l_users["group_data"] = "Dane grupy";
$l_users["group_name"] = "Nazwa grupy";
$l_users["group_member"] = "Przynależność do grup";
$l_users["group"] = "Grupa";
$l_users["address"] = "Adres";
$l_users["houseno"] = "Numer domu";
$l_users["state"] = "Województwo";
$l_users["PLZ"] = "Kod pocztowy";
$l_users["city"] = "Miasto";
$l_users["country"] = "Kraj";
$l_users["tel_pre"] = "Nr kierunkowy telefonu";
$l_users["fax_pre"] = "Nr kierunkowy faksu";
$l_users["telephone"] = "Telefon";
$l_users["fax"] = "Faks";
$l_users["mobile"] = "Tel. komórkowy";
$l_users["email"] = "e-mail";
$l_users["general_data"] = "Dane ogólne";
$l_users["workspace_documents"] = "Obszar roboczy dokumentów";
$l_users["workspace_templates"] = "Obszar roboczy szablonów";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "Zmieniono użytkownika.\\nCzy chcesz zapisać zmiany?";
$l_users["not_able_to_save"] = " Nie zapisano danych, ponieważ są nieprawidłowe!";
$l_users["cannot_save_used"] = " Nie można zmienić statusu - trwa edycja!";
$l_users["geaendert_von"] = "Zmienił";
$l_users["geaendert_am"] = "Zmieniono dn.";
$l_users["angelegt_am"] = "Wprowadzono dn.";
$l_users["angelegt_von"] = "Wprowadził";
$l_users["status"] = "Status"; // TRANSLATE
$l_users["value"] = " Wartość ";
$l_users["gesperrt"] = "zablokowano";
$l_users["freigegeben"] = "Zatwierdzone";
$l_users["gelöscht"] = "Usunięto";
$l_users["ohne"] = "Brak";
$l_users["user"] = "Użytkownik";
$l_users["usertyp"] = "Typ użytkownika";
$l_users["serach_results"] = "Wyniki wyszukiwania";
$l_users["inherit"] = "Przejęcie uprawnień grupy nadrzędnej";
$l_users["inherit_ws"] = "Przejęcie obszaru roboczego grupy nadrzędnej";
$l_users["inherit_wst"] = "Przejęcie obszaru roboczego szablonów z grupy nadrzędnej";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organizacja";
$l_users["give_org_name"] = "Nazwa organizacji";
$l_users["can_not_create_org"] = "Nie można utworzyć organizacji";
$l_users["org_name_empty"] = "Nazwa organizacji jest pusta";
$l_users["salutation"] = "Tytuł";
$l_users["sucheleer"] = "Nie podano słowa do wyszukania.";
$l_users["alias_data"] = "Dane aliasów";
$l_users["rights_and_workspaces"] = "Uprawnienia i <br>obszary robocze";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspace_newsletter"] = "Workspace Newsletter"; // TRANSLATE
$l_users["inherit_wsnl"] = "Inherit newsletter workspaces from parent group"; // TRANSLATE

$l_users["delete_user_same"] = "Sie können nicht Ihr eigenes Konto löschen."; // TRANSLATE
$l_users["delete_group_user_same"] = "Sie können nicht Ihre eigene Gruppe löschen."; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>