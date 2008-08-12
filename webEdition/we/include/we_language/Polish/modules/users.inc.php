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
$l_users["grant_owners_ok"] = "Uda�o si� przenie�� dane w�a�ciciela!";
$l_users["grant_owners_notok"] = "Wyst�pi� b��d przy przenoszeniu w�a�ciciela!";
$l_users["grant_owners"] = "Przenie� w�a�ciciela";
$l_users["grant_owners_expl"] = "Przenie� ustawionego wy�ej w�a�ciciela i wszystkich u�ytkownik�w na wszystkie pliki i katalogi, kt�re znajduj� si� w tym katalogu.";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "Zapisano u�ytkownika '%s'";
$l_users["group_saved_ok"] = "Zapisano grup� '%s'";
$l_users["alias_saved_ok"] = "Zapisano alias '%s'";
$l_users["user_saved_nok"] = "Nie uda�o si� zapisa� u�ytkownika '%s'!";
$l_users["nothing_to_save"] = "Brak obiekt�w do zapisania!";
$l_users["username_exists"] = "Nazwa u�ytkownika ju� istnieje '%s'!";
$l_users["username_empty"] = "Nie wype�niono nazwy u�ytkownika!";
$l_users["user_deleted"] = "Usuni�to u�ytkownika '%s'!";
$l_users["nothing_to_delete"] = "Brak obiekt�w do usuni�cia!";
$l_users["delete_last_user"] = "Do zarz�dzania jest potrzebny przynajmniej administrator.\\nNie mo�na usun�� ostatniego administratora.";
$l_users["modify_last_admin"] = "Do zarz�dzania jest potrzebny przynajmniej administrator.\\n Nie mo�na zmieni� uprawnie� ostatniego administratora.";
$l_users["user_path_nok"] = "Nieprawid�owa �cie�ka!";
$l_users["user_data"] = "Dane u�ytkownik�w";
$l_users["first_name"] = "Imi�";
$l_users["second_name"] = "Nazwisko";
$l_users["username"] = "Nazwa u�ytkownika";
$l_users["password"] = "Has�o";
$l_users["workspace_specify"] = "Wyszczeg�lnij obszar roboczy";
$l_users["permissions"] = "Uprawnienia";
$l_users["user_permissions"] = "Redaktor";
$l_users["admin_permissions"] = "Administrator";
$l_users["password_alert"] = "Has�o musi si� sk�ada� z conajmniej 4 znak�w";
$l_users["delete_alert_user"] = "Usuni�cie wszystkich danych u�ytkownika '%s'.\\n Na pewno?";
$l_users["delete_alert_alias"] = "Usuni�cie wszystkich danych aliasu dla aliasu '%s'.\\n Na pewno?";
$l_users["delete_alert_group"] = "Usuni�cie wszystkich danych grupy i u�ytkownik�w grupy dla grupy '%s'.\\nNa pewno?";
$l_users["created_by"] = "Sporz�dzi�";
$l_users["changed_by"] = "Zmieni�";
$l_users["no_perms"] = "Nie masz uprawnie� do korzystania z tej opcji!";
$l_users["publish_specify"] = "U�ytkownik mo�e publikowa�";
$l_users["work_permissions"] = "Uprawnienia robocze";
$l_users["control_permissions"] = "Uprawnienia kontrolne";
$l_users["log_permissions"] = "Prawo do logowania";
$l_users["file_locked"][FILE_TABLE] = "Plik '%s' jest w�a�nie edytowany przez u�ytkownika '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Szablon '%s' jest w�a�nie edytowany przez u�ytkownika '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Klasa '%s' jest w�a�nie edytowana przez u�ytkownika '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Obiekt '%s' jest w�a�nie edytowany przez u�ytkownika '%s'!";
}
$l_users["acces_temp_denied"] = "Dost�p jest obecnie niemo�liwy";
$l_users["description"] = "Opis";
$l_users["group_data"] = "Dane grupy";
$l_users["group_name"] = "Nazwa grupy";
$l_users["group_member"] = "Przynale�no�� do grup";
$l_users["group"] = "Grupa";
$l_users["address"] = "Adres";
$l_users["houseno"] = "Numer domu";
$l_users["state"] = "Wojew�dztwo";
$l_users["PLZ"] = "Kod pocztowy";
$l_users["city"] = "Miasto";
$l_users["country"] = "Kraj";
$l_users["tel_pre"] = "Nr kierunkowy telefonu";
$l_users["fax_pre"] = "Nr kierunkowy faksu";
$l_users["telephone"] = "Telefon";
$l_users["fax"] = "Faks";
$l_users["mobile"] = "Tel. kom�rkowy";
$l_users["email"] = "e-mail";
$l_users["general_data"] = "Dane og�lne";
$l_users["workspace_documents"] = "Obszar roboczy dokument�w";
$l_users["workspace_templates"] = "Obszar roboczy szablon�w";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "Zmieniono u�ytkownika.\\nCzy chcesz zapisa� zmiany?";
$l_users["not_able_to_save"] = " Nie zapisano danych, poniewa� s� nieprawid�owe!";
$l_users["cannot_save_used"] = " Nie mo�na zmieni� statusu - trwa edycja!";
$l_users["geaendert_von"] = "Zmieni�";
$l_users["geaendert_am"] = "Zmieniono dn.";
$l_users["angelegt_am"] = "Wprowadzono dn.";
$l_users["angelegt_von"] = "Wprowadzi�";
$l_users["status"] = "Status"; // TRANSLATE
$l_users["value"] = " Warto�� ";
$l_users["gesperrt"] = "zablokowano";
$l_users["freigegeben"] = "Zatwierdzone";
$l_users["gel�scht"] = "Usuni�to";
$l_users["ohne"] = "Brak";
$l_users["user"] = "U�ytkownik";
$l_users["usertyp"] = "Typ u�ytkownika";
$l_users["serach_results"] = "Wyniki wyszukiwania";
$l_users["inherit"] = "Przej�cie uprawnie� grupy nadrz�dnej";
$l_users["inherit_ws"] = "Przej�cie obszaru roboczego grupy nadrz�dnej";
$l_users["inherit_wst"] = "Przej�cie obszaru roboczego szablon�w z grupy nadrz�dnej";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organizacja";
$l_users["give_org_name"] = "Nazwa organizacji";
$l_users["can_not_create_org"] = "Nie mo�na utworzy� organizacji";
$l_users["org_name_empty"] = "Nazwa organizacji jest pusta";
$l_users["salutation"] = "Tytu�";
$l_users["sucheleer"] = "Nie podano s�owa do wyszukania.";
$l_users["alias_data"] = "Dane alias�w";
$l_users["rights_and_workspaces"] = "Uprawnienia i <br>obszary robocze";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspace_newsletter"] = "Workspace Newsletter"; // TRANSLATE
$l_users["inherit_wsnl"] = "Inherit newsletter workspaces from parent group"; // TRANSLATE

$l_users["delete_user_same"] = "Sie k�nnen nicht Ihr eigenes Konto l�schen."; // TRANSLATE
$l_users["delete_group_user_same"] = "Sie k�nnen nicht Ihre eigene Gruppe l�schen."; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>