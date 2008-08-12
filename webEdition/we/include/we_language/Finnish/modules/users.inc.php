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
$l_users["user_same"] = "Omistajaa ei voida poistaa!";
$l_users["grant_owners_ok"] = "Omistaja on muutettu!";
$l_users["grant_owners_notok"] = "Virhe muutettaessa omistajaa!";
$l_users["grant_owners"] = "Vaihda omistajaa";
$l_users["grant_owners_expl"] = "Vaihda kyseisen kansion kaikkien tiedostojen ja hakemistojen omistajaa.";
$l_users["make_def_ws"] = "Oletus";
$l_users["user_saved_ok"] = "Käyttäjä '%s' on tallennettu!";
$l_users["group_saved_ok"] = "Ryhmä '%s' X on tallennettu!";
$l_users["alias_saved_ok"] = "Alias '%s' on tallennettu!";
$l_users["user_saved_nok"] = "Käyttäjää '%s' ei voitu tallentaa!";
$l_users["nothing_to_save"] = "Ei tallennettavaa!";
$l_users["username_exists"] = "Käyttäjänimi '%s' on jo olemassa!";
$l_users["username_empty"] = "Käyttäjänimi on tyhjä!";
$l_users["user_deleted"] = "Käyttäjä '%s' on poistettu!";
$l_users["nothing_to_delete"] = "Ei poistettavaa!";
$l_users["delete_last_user"] = "Yrität poistaa viimeista järjestelmänvalvojan oikeuksilla olevaa käyttäjää. Poistaminen voi estää järjestelmän käytön! Täten poistaminen ei ole mahdollista.";
$l_users["modify_last_admin"] = "Käyttäjistä yhden on oltava järjestelmänvalvoja.\n Et voi muuttaa viimeisen järjestelmänvalvojan oikeuksia";
$l_users["user_path_nok"] = "Polku on virheellinen!";
$l_users["user_data"] = "Käyttäjätiedot";
$l_users["first_name"] = "Etunimi";
$l_users["second_name"] = "Sukunimi";
$l_users["username"] = "Käyttäjänimi";
$l_users["password"] = "Salasana";
$l_users["workspace_specify"] = "Määritä työtila";
$l_users["permissions"] = "Oikeudet";
$l_users["user_permissions"] = "Käyttäjän oikeudet";
$l_users["admin_permissions"] = "Järjestelmänvalvojan oikeudet";
$l_users["password_alert"] = "Salasanan on oltava vähintään 4 kirjaiminen.";
$l_users["delete_alert_user"] = "Kaikki käyttäjätiedot käyttäjältä '%s' poistetaan.\\n Oletko varma että haluat tehdä tämän?";
$l_users["delete_alert_alias"] = "Kaikki aliastiedot aliakselle '%s' poistetaan.\\n Oletko varma?";
$l_users["delete_alert_group"] = "Kaikki ryhmätiedot ryhmälle '%s' poistetaan. Oletko varma?";
$l_users["created_by"] = "Luonut:";
$l_users["changed_by"] = "Muutettu:";
$l_users["no_perms"] = "Sinulla ei ole oikeuksia tehdä tätä!";
$l_users["publish_specify"] = "Käyttäjä voi julkaista.";
$l_users["work_permissions"] = "Työoikeudet";
$l_users["control_permissions"] = "Hallintaoikeudet";
$l_users["log_permissions"] = "Kirjautumisoikeudet";
$l_users["file_locked"][FILE_TABLE] = "Tiedosto '%s' on käytössä käyttäjällä '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Sivupohja '%s' on käytössä käyttäjällä '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Luokka '%s' on käytössä käyttäjällä '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Objekti '%s' on käytössä käyttäjällä '%s'!";
}
$l_users["acces_temp_denied"] = "Pääsy väliaikaisesti evätty!";
$l_users["description"] = "Kuvaus";
$l_users["group_data"] = "Ryhmän tiedot";
$l_users["group_name"] = "Ryhmän tiedot";
$l_users["group_member"] = "Ryhmän jäsenyys";
$l_users["group"] = "Ryhmä";
$l_users["address"] = "Osoite";
$l_users["houseno"] = "Talon/asunnon numero";
$l_users["state"] = "Lääni";
$l_users["PLZ"] = "Postinumero";
$l_users["city"] = "Kunta";
$l_users["country"] = "Maa";
$l_users["tel_pre"] = "Suuntanumero";
$l_users["fax_pre"] = "Suuntanumero faksille";
$l_users["telephone"] = "Puhelin";
$l_users["fax"] = "Faksi";
$l_users["mobile"] = "Matkapuhelin";
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "Yleistiedot";
$l_users["workspace_documents"] = "Työtilan dokumentit";
$l_users["workspace_templates"] = "Työtilan sivupohjat";
$l_users["workspace_objects"] = "Työtilan objektit";
$l_users["save_changed_user"] = "Käyttäjää on muokattu.\\nHaluatko tallentaa muutokset?";
$l_users["not_able_to_save"] = "Tietoja ei ole tallennettu niiden virheellisyyden takia!";
$l_users["cannot_save_used"] = "Tilaa ei voida muuttaa koska se on 'käsittelyssä'!";
$l_users["geaendert_von"] = "Muokannut";
$l_users["geaendert_am"] = "Muokattu";
$l_users["angelegt_am"] = "Perustettu";
$l_users["angelegt_von"] = "Perustaja";
$l_users["status"] = "Tila";
$l_users["value"] = " Arvo ";
$l_users["gesperrt"] = "rajattu";
$l_users["freigegeben"] = "avoin";
$l_users["gelöscht"] = "poistettu";
$l_users["ohne"] = "ilman";
$l_users["user"] = "Käyttäjä";
$l_users["usertyp"] = "Käyttäjätyyppi";
$l_users["search"] = "Suche"; // TRANSLATE
$l_users["search_result"] = "Ergebnis"; // TRANSLATE
$l_users["search_for"] = "Suche nach"; // TRANSLATE
$l_users["inherit"] = "Peri oikeudet käyttäjäryhmältä.";
$l_users["inherit_ws"] = "Peri dokumenttien työtilat käyttäjäryhmältä.";
$l_users["inherit_wst"] = "Peri sivupohjien työtilat käyttäjäryhmältä.";
$l_users["inherit_wso"] = "Peri objektien työtilat käyttäjäryhmältä";
$l_users["organization"] = "Organisaatio";
$l_users["give_org_name"] = "Organisaation nimi";
$l_users["can_not_create_org"] = "Organisaatiota ei saatu luotua";
$l_users["org_name_empty"] = "Organisaation nimi on tyhjä";
$l_users["salutation"] = "Tervehdys";
$l_users["sucheleer"] = "Etsintäsana on tyhjä!";
$l_users["alias_data"] = "Aliaksen tiedot";
$l_users["rights_and_workspaces"] = "Oikeudet ja<br>työtilat";
$l_users["workspace_navigations"] = "Työtilan navigaatio";
$l_users["inherit_wsn"] = "Peri navigaation työtilat käyttäjäryhmältä";
$l_users["workspace_newsletter"] = "Työtilan uutiskirjeet";
$l_users["inherit_wsnl"] = "Peri uutiskirjeiden työtilat käyttäjäryhmältä";

$l_users["delete_user_same"] = "Et voi poistaa omaa käyttäjätiliäsi.";
$l_users["delete_group_user_same"] = "Et voi poistaa omaa käyttäjäryhmääsi";

$l_users["login_denied"] = "Login denied"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!"; // TRANSLATE
$l_users["noGroupError"] = "Error: Invalid entry in field group!"; // TRANSLATE

?>