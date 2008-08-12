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
$l_users["user_saved_ok"] = "K�ytt�j� '%s' on tallennettu!";
$l_users["group_saved_ok"] = "Ryhm� '%s' X on tallennettu!";
$l_users["alias_saved_ok"] = "Alias '%s' on tallennettu!";
$l_users["user_saved_nok"] = "K�ytt�j�� '%s' ei voitu tallentaa!";
$l_users["nothing_to_save"] = "Ei tallennettavaa!";
$l_users["username_exists"] = "K�ytt�j�nimi '%s' on jo olemassa!";
$l_users["username_empty"] = "K�ytt�j�nimi on tyhj�!";
$l_users["user_deleted"] = "K�ytt�j� '%s' on poistettu!";
$l_users["nothing_to_delete"] = "Ei poistettavaa!";
$l_users["delete_last_user"] = "Yrit�t poistaa viimeista j�rjestelm�nvalvojan oikeuksilla olevaa k�ytt�j��. Poistaminen voi est�� j�rjestelm�n k�yt�n! T�ten poistaminen ei ole mahdollista.";
$l_users["modify_last_admin"] = "K�ytt�jist� yhden on oltava j�rjestelm�nvalvoja.\n Et voi muuttaa viimeisen j�rjestelm�nvalvojan oikeuksia";
$l_users["user_path_nok"] = "Polku on virheellinen!";
$l_users["user_data"] = "K�ytt�j�tiedot";
$l_users["first_name"] = "Etunimi";
$l_users["second_name"] = "Sukunimi";
$l_users["username"] = "K�ytt�j�nimi";
$l_users["password"] = "Salasana";
$l_users["workspace_specify"] = "M��rit� ty�tila";
$l_users["permissions"] = "Oikeudet";
$l_users["user_permissions"] = "K�ytt�j�n oikeudet";
$l_users["admin_permissions"] = "J�rjestelm�nvalvojan oikeudet";
$l_users["password_alert"] = "Salasanan on oltava v�hint��n 4 kirjaiminen.";
$l_users["delete_alert_user"] = "Kaikki k�ytt�j�tiedot k�ytt�j�lt� '%s' poistetaan.\\n Oletko varma ett� haluat tehd� t�m�n?";
$l_users["delete_alert_alias"] = "Kaikki aliastiedot aliakselle '%s' poistetaan.\\n Oletko varma?";
$l_users["delete_alert_group"] = "Kaikki ryhm�tiedot ryhm�lle '%s' poistetaan. Oletko varma?";
$l_users["created_by"] = "Luonut:";
$l_users["changed_by"] = "Muutettu:";
$l_users["no_perms"] = "Sinulla ei ole oikeuksia tehd� t�t�!";
$l_users["publish_specify"] = "K�ytt�j� voi julkaista.";
$l_users["work_permissions"] = "Ty�oikeudet";
$l_users["control_permissions"] = "Hallintaoikeudet";
$l_users["log_permissions"] = "Kirjautumisoikeudet";
$l_users["file_locked"][FILE_TABLE] = "Tiedosto '%s' on k�yt�ss� k�ytt�j�ll� '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Sivupohja '%s' on k�yt�ss� k�ytt�j�ll� '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Luokka '%s' on k�yt�ss� k�ytt�j�ll� '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Objekti '%s' on k�yt�ss� k�ytt�j�ll� '%s'!";
}
$l_users["acces_temp_denied"] = "P��sy v�liaikaisesti ev�tty!";
$l_users["description"] = "Kuvaus";
$l_users["group_data"] = "Ryhm�n tiedot";
$l_users["group_name"] = "Ryhm�n tiedot";
$l_users["group_member"] = "Ryhm�n j�senyys";
$l_users["group"] = "Ryhm�";
$l_users["address"] = "Osoite";
$l_users["houseno"] = "Talon/asunnon numero";
$l_users["state"] = "L��ni";
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
$l_users["workspace_documents"] = "Ty�tilan dokumentit";
$l_users["workspace_templates"] = "Ty�tilan sivupohjat";
$l_users["workspace_objects"] = "Ty�tilan objektit";
$l_users["save_changed_user"] = "K�ytt�j�� on muokattu.\\nHaluatko tallentaa muutokset?";
$l_users["not_able_to_save"] = "Tietoja ei ole tallennettu niiden virheellisyyden takia!";
$l_users["cannot_save_used"] = "Tilaa ei voida muuttaa koska se on 'k�sittelyss�'!";
$l_users["geaendert_von"] = "Muokannut";
$l_users["geaendert_am"] = "Muokattu";
$l_users["angelegt_am"] = "Perustettu";
$l_users["angelegt_von"] = "Perustaja";
$l_users["status"] = "Tila";
$l_users["value"] = " Arvo ";
$l_users["gesperrt"] = "rajattu";
$l_users["freigegeben"] = "avoin";
$l_users["gel�scht"] = "poistettu";
$l_users["ohne"] = "ilman";
$l_users["user"] = "K�ytt�j�";
$l_users["usertyp"] = "K�ytt�j�tyyppi";
$l_users["search"] = "Suche"; // TRANSLATE
$l_users["search_result"] = "Ergebnis"; // TRANSLATE
$l_users["search_for"] = "Suche nach"; // TRANSLATE
$l_users["inherit"] = "Peri oikeudet k�ytt�j�ryhm�lt�.";
$l_users["inherit_ws"] = "Peri dokumenttien ty�tilat k�ytt�j�ryhm�lt�.";
$l_users["inherit_wst"] = "Peri sivupohjien ty�tilat k�ytt�j�ryhm�lt�.";
$l_users["inherit_wso"] = "Peri objektien ty�tilat k�ytt�j�ryhm�lt�";
$l_users["organization"] = "Organisaatio";
$l_users["give_org_name"] = "Organisaation nimi";
$l_users["can_not_create_org"] = "Organisaatiota ei saatu luotua";
$l_users["org_name_empty"] = "Organisaation nimi on tyhj�";
$l_users["salutation"] = "Tervehdys";
$l_users["sucheleer"] = "Etsint�sana on tyhj�!";
$l_users["alias_data"] = "Aliaksen tiedot";
$l_users["rights_and_workspaces"] = "Oikeudet ja<br>ty�tilat";
$l_users["workspace_navigations"] = "Ty�tilan navigaatio";
$l_users["inherit_wsn"] = "Peri navigaation ty�tilat k�ytt�j�ryhm�lt�";
$l_users["workspace_newsletter"] = "Ty�tilan uutiskirjeet";
$l_users["inherit_wsnl"] = "Peri uutiskirjeiden ty�tilat k�ytt�j�ryhm�lt�";

$l_users["delete_user_same"] = "Et voi poistaa omaa k�ytt�j�tili�si.";
$l_users["delete_group_user_same"] = "Et voi poistaa omaa k�ytt�j�ryhm��si";

$l_users["login_denied"] = "Login denied"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!"; // TRANSLATE
$l_users["noGroupError"] = "Error: Invalid entry in field group!"; // TRANSLATE

?>