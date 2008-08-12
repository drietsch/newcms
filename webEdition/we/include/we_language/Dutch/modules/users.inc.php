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
 * Language: Dutch
 */
$l_users["user_same"] = "De eigenaar kan niet verwijderd worden!";
$l_users["grant_owners_ok"] = "Eigenaren zijn succesvol gewijzigd!";
$l_users["grant_owners_notok"] = "Er is een fout opgetreden tijdens het wijzigen van de eigenaars!";
$l_users["grant_owners"] = "Wijzig eigenaars";
$l_users["grant_owners_expl"] = "Wijzig de eigenaars van alle bestanden en directories die zich bevinden in de huidige directory naar de bovenstaande eigenaar instellingen.";
$l_users["make_def_ws"] = "Standaard";
$l_users["user_saved_ok"] = "Gebruiker '%s' is succesvol bewaard!";
$l_users["group_saved_ok"] = "Groep '%s' X is succesvol bewaard!";
$l_users["alias_saved_ok"] = "Alias '%s' is succesvol bewaard!";
$l_users["user_saved_nok"] = "Gebruiker '%s' kan niet bewaard worden!";
$l_users["nothing_to_save"] = "Er is niks om te bewaren!";
$l_users["username_exists"] = "Gebruikersnaam '%s' bestaat al!";
$l_users["username_empty"] = "Gebruikersnaam is leeg!";
$l_users["user_deleted"] = "Gebruiker '%s' is verwijderd!";
$l_users["nothing_to_delete"] = "Er is niks om te verwijderen!";
$l_users["delete_last_user"] = "U probeert de laatste gebruiker met admin rechten te verwijderen. Hierdoor wordt het systeem onaanpasbaar! Daarom kunt u de gebruiker niet verwijderen.";
$l_users["modify_last_admin"] = "Er moet minimaal één admin zijn.\\n U kunt de rechten van de laatste admin niet wijzigen.";
$l_users["user_path_nok"] = "Het pad is niet correct!";
$l_users["user_data"] = "gebruikersdata";
$l_users["first_name"] = "Voornaam";
$l_users["second_name"] = "Achternaam";
$l_users["username"] = "Gebruikersnaam";
$l_users["password"] = "Wachtwoord";
$l_users["workspace_specify"] = "Specificeer werkgebied";
$l_users["permissions"] = "Rechten";
$l_users["user_permissions"] = "Gebruikersrechten";
$l_users["admin_permissions"] = "Administrator rechten";
$l_users["password_alert"] = "Het wachtwoord moet minimaal 4 karakters bevatten.";
$l_users["delete_alert_user"] = "Alle gebruikersdata voor gebruiker '%s' wordt verwijderd.\\n Weet u zeker dat u dit wilt doen?";
$l_users["delete_alert_alias"] = "Alle alias data voor alias '%s' wordt verwijderd.\\n Weet u zeker dat u dit wilt doen?";
$l_users["delete_alert_group"] = "Alle groep data en gebruikers van groep '%s' worden verwijderd. Weet u zeker dat u dit wilt doen?";
$l_users["created_by"] = "Aangemaakt door";
$l_users["changed_by"] = "Gewijzigd door:";
$l_users["no_perms"] = "U bent niet bevoegd om deze optie te gebruiken!";
$l_users["publish_specify"] = "Gebruiker is bevoegd te publiceren.";
$l_users["work_permissions"] = "Werk rechten";
$l_users["control_permissions"] = "Controle rechten";
$l_users["log_permissions"] = "Inlog rechten";
$l_users["file_locked"][FILE_TABLE] = "Het bestand '%s' wordt momenteel gebruikt door '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Het sjabloon '%s' wordt momenteel gebruikt door '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "De class '%s' wordt momenteel gebruikt door '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Het object '%s' wordt momenteel gebruikt door '%s'!";
}
$l_users["acces_temp_denied"] = "Toegang tijdelijk geweigerd!";
$l_users["description"] = "Omschrijving";
$l_users["group_data"] = "Groep data";
$l_users["group_name"] = "Groepsnaam";
$l_users["group_member"] = "Groeps abonnement";
$l_users["group"] = "Groep";
$l_users["address"] = "Adres";
$l_users["houseno"] = "Huisnummer/appartement";
$l_users["state"] = "Provincie";
$l_users["PLZ"] = "Postcode";
$l_users["city"] = "Stad";
$l_users["country"] = "land";
$l_users["tel_pre"] = "Telefoon kerncijfer";
$l_users["fax_pre"] = "Fax kerncijfer";
$l_users["telephone"] = "Telefoon";
$l_users["fax"] = "Fax"; 
$l_users["mobile"] = "Mobiel";
$l_users["email"] = "Email";
$l_users["general_data"] = "Algemene data";
$l_users["workspace_documents"] = "Werkgebied documenten";
$l_users["workspace_templates"] = "Werkgebied sjablonen";
$l_users["workspace_objects"] = "Werkgebied Objecten";
$l_users["save_changed_user"] = "Gebruiker is gewijzigd.\\nWilt u de wijziging bewaren?";
$l_users["not_able_to_save"] = "Data is niet bewaard omdat deze niet geldig is!";
$l_users["cannot_save_used"] = "Status kan niet gewijzigd worden omdat deze bezig is!";
$l_users["geaendert_von"] = "Gewijzigd door";
$l_users["geaendert_am"] = "Gewijzigd bij";
$l_users["angelegt_am"] = "Opgezet bij";
$l_users["angelegt_von"] = "Opgezet door";
$l_users["status"] = "Status"; 
$l_users["value"] = " Waarde ";
$l_users["gesperrt"] = "Beperkt";
$l_users["freigegeben"] = "open";
$l_users["gelöscht"] = "verwijder";
$l_users["ohne"] = "zonder";
$l_users["user"] = "Gebruiker";
$l_users["usertyp"] = "Type gebruiker";
$l_users["search"] = "Search"; // TRANSLATE
$l_users["search_results"] = "Zoek resultaat";
$l_users["search_for"] = "Search for"; // TRANSLATE
$l_users["inherit"] = "Verkrijg rechten van hoofd groep.";
$l_users["inherit_ws"] = "Verkrijg documenten werkgebied van hoofd groep.";
$l_users["inherit_wst"] = "Verkrijg sjabloon werkgebied van hoofd groep.";
$l_users["inherit_wso"] = "Verkrijg objecten werkgebied van hoofd groep";
$l_users["organization"] = "Organisatie";
$l_users["give_org_name"] = "Naam organisatie";
$l_users["can_not_create_org"] = "De organisatie kan niet aangemaakt worden";
$l_users["org_name_empty"] = "Naam organisatie is leeg";
$l_users["salutation"] = "Aanhef";
$l_users["sucheleer"] = "Zoekterm is leeg!";
$l_users["alias_data"] = "Alias gegevens";
$l_users["rights_and_workspaces"] = "Rechten en<br>werkgebieden";
$l_users["workspace_navigations"] = "Workspave Navigatie";
$l_users["inherit_wsn"] = "Neem navigatie workspaces over van hoofdgroep";
$l_users["workspace_newsletter"] = "Workspace nieuwsbrief";
$l_users["inherit_wsnl"] = "Neem nieuwsbrief workspaces over van hoofdgroep";

$l_users["delete_user_same"] = "U kunt niet uw eigen account verwijderen.";
$l_users["delete_group_user_same"] = "U kunt niet uw eigen groep verwijderen.";

$l_users["login_denied"] = "Login denied"; // TRANSLATE
$l_users["workspaceFieldError"] = "FOUT: Ongeldige workspace invoer!"; 
$l_users["noGroupError"] = "FOUT: Ongeldige invoer in field groep!"; 

?>