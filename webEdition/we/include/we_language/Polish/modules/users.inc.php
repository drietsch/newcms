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
$l_users["user_same"] = "The owner cannot be deleted!"; // TRANSLATE
$l_users["grant_owners_ok"] = "Uda³o siê przenie¶æ dane w³a¶ciciela!";
$l_users["grant_owners_notok"] = "Wyst±pi³ b³±d przy przenoszeniu w³a¶ciciela!";
$l_users["grant_owners"] = "Przenie¶ w³a¶ciciela";
$l_users["grant_owners_expl"] = "Przenie¶ ustawionego wy¿ej w³a¶ciciela i wszystkich u¿ytkowników na wszystkie pliki i katalogi, które znajduj± siê w tym katalogu.";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "Zapisano u¿ytkownika '%s'";
$l_users["group_saved_ok"] = "Zapisano grupê '%s'";
$l_users["alias_saved_ok"] = "Zapisano alias '%s'";
$l_users["user_saved_nok"] = "Nie uda³o siê zapisaæ u¿ytkownika '%s'!";
$l_users["nothing_to_save"] = "Brak obiektów do zapisania!";
$l_users["username_exists"] = "Nazwa u¿ytkownika ju¿ istnieje '%s'!";
$l_users["username_empty"] = "Nie wype³niono nazwy u¿ytkownika!";
$l_users["user_deleted"] = "Usuniêto u¿ytkownika '%s'!";
$l_users["nothing_to_delete"] = "Brak obiektów do usuniêcia!";
$l_users["delete_last_user"] = "Do zarz±dzania jest potrzebny przynajmniej administrator.\\nNie mo¿na usun±æ ostatniego administratora.";
$l_users["modify_last_admin"] = "Do zarz±dzania jest potrzebny przynajmniej administrator.\\n Nie mo¿na zmieniæ uprawnieñ ostatniego administratora.";
$l_users["user_path_nok"] = "Nieprawid³owa ¶cie¿ka!";
$l_users["user_data"] = "Dane u¿ytkowników";
$l_users["first_name"] = "Imiê";
$l_users["second_name"] = "Nazwisko";
$l_users["username"] = "Nazwa u¿ytkownika";
$l_users["password"] = "Has³o";
$l_users["workspace_specify"] = "Wyszczególnij obszar roboczy";
$l_users["permissions"] = "Uprawnienia";
$l_users["user_permissions"] = "Redaktor";
$l_users["admin_permissions"] = "Administrator";
$l_users["password_alert"] = "Has³o musi siê sk³adaæ z conajmniej 4 znaków";
$l_users["delete_alert_user"] = "Usuniêcie wszystkich danych u¿ytkownika '%s'.\\n Na pewno?";
$l_users["delete_alert_alias"] = "Usuniêcie wszystkich danych aliasu dla aliasu '%s'.\\n Na pewno?";
$l_users["delete_alert_group"] = "Usuniêcie wszystkich danych grupy i u¿ytkowników grupy dla grupy '%s'.\\nNa pewno?";
$l_users["created_by"] = "Sporz±dzi³";
$l_users["changed_by"] = "Zmieni³";
$l_users["no_perms"] = "Nie masz uprawnieñ do korzystania z tej opcji!";
$l_users["publish_specify"] = "U¿ytkownik mo¿e publikowaæ";
$l_users["work_permissions"] = "Uprawnienia robocze";
$l_users["control_permissions"] = "Uprawnienia kontrolne";
$l_users["log_permissions"] = "Prawo do logowania";
$l_users["file_locked"][FILE_TABLE] = "Plik '%s' jest w³a¶nie edytowany przez u¿ytkownika '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Szablon '%s' jest w³a¶nie edytowany przez u¿ytkownika '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Klasa '%s' jest w³a¶nie edytowana przez u¿ytkownika '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Obiekt '%s' jest w³a¶nie edytowany przez u¿ytkownika '%s'!";
}
$l_users["acces_temp_denied"] = "Dostêp jest obecnie niemo¿liwy";
$l_users["description"] = "Opis";
$l_users["group_data"] = "Dane grupy";
$l_users["group_name"] = "Nazwa grupy";
$l_users["group_member"] = "Przynale¿no¶æ do grup";
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
$l_users["save_changed_user"] = "Zmieniono u¿ytkownika.\\nCzy chcesz zapisaæ zmiany?";
$l_users["not_able_to_save"] = " Nie zapisano danych, poniewa¿ s± nieprawid³owe!";
$l_users["cannot_save_used"] = " Nie mo¿na zmieniæ statusu - trwa edycja!";
$l_users["geaendert_von"] = "Zmieni³";
$l_users["geaendert_am"] = "Zmieniono dn.";
$l_users["angelegt_am"] = "Wprowadzono dn.";
$l_users["angelegt_von"] = "Wprowadzi³";
$l_users["status"] = "Status"; // TRANSLATE
$l_users["value"] = " Warto¶æ ";
$l_users["gesperrt"] = "zablokowano";
$l_users["freigegeben"] = "Zatwierdzone";
$l_users["gelöscht"] = "Usuniêto";
$l_users["ohne"] = "Brak";
$l_users["user"] = "U¿ytkownik";
$l_users["usertyp"] = "Typ u¿ytkownika";
$l_users["serach_results"] = "Wyniki wyszukiwania";
$l_users["inherit"] = "Przejêcie uprawnieñ grupy nadrzêdnej";
$l_users["inherit_ws"] = "Przejêcie obszaru roboczego grupy nadrzêdnej";
$l_users["inherit_wst"] = "Przejêcie obszaru roboczego szablonów z grupy nadrzêdnej";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organizacja";
$l_users["give_org_name"] = "Nazwa organizacji";
$l_users["can_not_create_org"] = "Nie mo¿na utworzyæ organizacji";
$l_users["org_name_empty"] = "Nazwa organizacji jest pusta";
$l_users["salutation"] = "Tytu³";
$l_users["sucheleer"] = "Nie podano s³owa do wyszukania.";
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