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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["notice"] = "Notice";
$l_alert["warning"] = "Varoitus";
$l_alert["error"] = "Virhe";

$l_alert["noRightsToDelete"] = "\\'%s\\' ei voida poistaa! Sinulla ei ole k‰yttˆoikeutta suorittaa t‰t‰ toimintoa!";
$l_alert["noRightsToMove"] = "\\'%s\\' ei voida siirt‰‰! Sinulla ei ole oikeuksia t‰h‰n toimenpiteeseen!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "Dokumentti t‰ytyy tallentaa ennenkuin se voidaan asettaa tyˆnkulkuun!\\nHaluatko tallentaa dokumentin?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Dokumentti t‰ytyy tallentaa ennenkuin se voidaan asettaa tyˆnkulkuun!\\nHaluatko tallentaa dokumentin?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Luokka t‰ytyy tallentaa ennenkuin se voidaan asettaa tyˆnkulkuun!\\nHaluatko tallentaa luokan?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Sivupohja t‰ytyy tallentaa ennekuin se voidaan asettaa tyˆnkulkuun!\\nHaluatko tallentaa sivupohjan?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Tiedosto ei sijaitse tyˆtilassasi!";
$l_alert["folder"]["not_im_ws"] = "Hakemisto ei sijaitse tyˆtilassasi!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Sivupohja ei sijaitse tyˆtilassasi!";
$l_alert["delete_recipient"] = "Haluatko varmasti poistaa valitut s‰hkˆpostiosoitteet?";
$l_alert["recipient_exists"] = "S‰hkˆpostiosoite on jo olemassa!";
$l_alert["input_name"] = "Anna uusi kategorian nimi!";
$l_alert['input_file_name'] = "Anna tiedostonimi.";
$l_alert["max_name_recipient"] = "S‰hkˆpostiosoitteen pituus voi olla maksimissaan 255 merkki‰ pitk‰!";
$l_alert["not_entered_recipient"] = "S‰hkˆpostiosoitetta ei ole annettu!";
$l_alert["recipient_new_name"] = "Muuta s‰hkˆpostiosoitetta!";
$l_alert["no_new"]["objectFile"] = "Sinulla ei ole oikeuksia luoda objekteja!<br>Sinulla ei ole joko oikeuksia tai Sellaista luokkaa ei ole olemassa jossa tyˆtilasi olisi oikea!";
$l_alert["required_field_alert"] = "Kentt‰ '%s' on pakollinen!";
$l_alert["phpError"] = "webEdition -j‰rjestelm‰‰ ei voida k‰ynnist‰‰!";
$l_alert["3timesLoginError"] = "Kirjautuminen ep‰onnistui %s kertaa! Odota %s minuuttia ja yrit‰ uudelleen!";
$l_alert["popupLoginError"] = "webEdition -ikkunaa ei voitu avata!\\n\\nwebEdition -j‰rjestelm‰ voidaan k‰ynnist‰‰ voin jos selaimesi ei est‰ ponnahdusikkunoiden avautumista.";
$l_alert['publish_when_not_saved_message'] = "Dokumenttia ei ole tallennettu! Haluatko julkaista sen jokatapauksessa?";
$l_alert["template_in_use"] = "Sivupohja on k‰ytˆss‰, joten sit‰ ei voida poistaa!";
$l_alert["no_cookies"] = "Et ole aktivoinut keksej‰. Aktivoi keksit selaimestasi!";
$l_alert["doctype_hochkomma"] = "Virheellinen nimi! Ei sallitut merkit ovat ' (hipsu) ja , (pilkku)!";
$l_alert["thumbnail_hochkomma"] = "Virheellinen nimi! Virheellisi‰ merkkej‰ ovat ' (heittomerkki) and , (pilkku)!";
$l_alert["can_not_open_file"] = "Tiedostoa %s ei voida avata!";
$l_alert["no_perms_title"] = "P‰‰sy estetty!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "P‰‰sy estetty!";
$l_alert["no_perms"] = "Ota yhteytt‰ omistajaan (%s) tai j‰rjestelm‰nvalvojaan<br>jos tarvitset oikeuksia!";
$l_alert["temporaere_no_access"] = "Ei p‰‰sy‰!";
$l_alert["temporaere_no_access_text"] = "Tiedosto \"%s\" on k‰ytˆss‰ k‰ytt‰j‰ll‰ \"%s\".";
$l_alert["file_locked_footer"] = "Dokumentti on k‰ytˆss‰ k‰ytt‰j‰ll‰ \"%s\".";
$l_alert["file_no_save_footer"] = "Sinulla ei ole oikeuksia tallentaa tiedostoa.";
$l_alert["login_failed"] = "V‰‰r‰ k‰ytt‰j‰nimi ja/tai salasana!";
$l_alert["login_failed_security"] = "webEdition -j‰rjestelm‰‰!\\n\\nTurvallisuussyist‰ kirjautuminen on keskeytetty, koska kirjautumisen maksimiaika kului umpeen!\\n\\nKirjaudu uudelleen j‰rjestelm‰‰n.";
$l_alert["perms_no_permissions"] = "Sinulla ei ole oikeuksia suorittaa toimintoa!";
$l_alert["no_image"] = "Valitsemasi tiedosto ei ole kuva!";
$l_alert["delete_ok"] = "Tiedostot ja kansiot on poistettu!";
$l_alert["delete_cache_ok"] = "V‰limuisti onnistuneesti tyhjennetty!";
$l_alert["nothing_to_delete"] = "Mit‰‰n ei ole valittu poistettavaksi!";
$l_alert["delete"] = "Poista valitut tiedostot?\\nHaluatko jatkaa?";
$l_alert["delete_cache"] = "Tyhjenn‰ v‰limuisti valituilta osin?\\nHaluatko jatkaa?";
$l_alert["delete_folder"] = "Poista valitut hakemistot?\\nHuomaa: Hakemistoa poistettaessa, myˆs kaikki dokumentit poistettavan hakemiston sis‰ll‰ poistetaan automaattisesti!\\nHaluatko jatkaa?";
$l_alert["delete_nok_error"] = "Tiedostoa '%s' ei voitu poistaa.";
$l_alert["delete_nok_file"] = "Tiedostoa '%s' ei voitu poistaa.\\nTiedosto on voitu kirjoitussuojata. ";
$l_alert["delete_nok_folder"] = "Hakemistoa '%s' ei voitu poistaa.\\nHakemisto on voitu kirjoitussuojata.";
$l_alert["delete_nok_noexist"] = "Tiedostoa '%s' ei ole olemassa!";
$l_alert["noResourceTitle"] = "No Item!"; // TRANSLATE
$l_alert["noResource"] = "The document or directory does not exist!"; // TRANSLATE
$l_alert["move_exit_open_docs_question"] = "Ennen kuin dokumentteja voi siit‰‰, ne t‰ytyy sulkea. Kaikki tallentamattomat muutokset menetet‰‰n sulkemisen yhteydess‰. Seuraavat dokumentit suljetaan:\\n\\n";
$l_alert["move_exit_open_docs_continue"] = 'Jatka?';
$l_alert["move"] = "Siirr‰ valitut?\\nHaluatko jatkaa?";
$l_alert["move_ok"] = "Tiedostot onnistuneesti siirretty!";
$l_alert["move_duplicate"] = "Kohdehakemistossa on samannimisi‰ tiedostoja!\\nTiedostoja ei voida siirt‰‰!.";
$l_alert["move_nofolder"] = "Valittuja tiedostoja ei voida siirt‰‰.\\nHakemistojen siirto ei ole mahdollista.";
$l_alert["move_onlysametype"] = "Valittuja objekteja ei voida siirt‰‰.\\nObjekteja voidaan siirt‰‰ vain oman luokkahakemistonsa sis‰isesti.";
$l_alert["move_no_dir"] = "Valitse kohdehakemisto!";
$l_alert["document_move_warning"] = "Dokumentin siirron j‰lkeen on tarpeen suorittaa uudelleenrakennus.<br />Haluatko tehd‰ sen nyt?";
$l_alert["nothing_to_move"] = "Mit‰‰n ei ole merkitty siirrett‰v‰ksi!";
$l_alert["move_of_files_failed"] = "Yht‰ tai useampaa tiedostoa ei voitu siirt‰‰! Siirr‰ tiedostot manuaalisesti.\\nSeuraavat tiedostot vaikuttuivat:\\n%s";
$l_alert["template_save_warning"] = "T‰m‰ sivupohja on k‰ytˆss‰ %s julkaistulla dokumentilla. Tallennetaanko ne uudelleen? Huomautus: T‰m‰ prosessi voi kest‰‰ hetkisen jos dokumentteja on useita!";
$l_alert["template_save_warning1"] = "T‰m‰ sivupohja on k‰ytˆss‰ yhdell‰ julkaistulla dokumentilla. Tallennetaanko t‰m‰ dokumentti uudelleen?";
$l_alert["template_save_warning2"] = "T‰m‰ sivupohja on k‰ytˆss‰ muilla sivupohjilla tai dokumenteilla, tallennetaanko ne uudelleen?";
$l_alert["thumbnail_exists"] = "Esikatselukuva on jo olemassa!";
$l_alert["thumbnail_not_exists"] = "Esikatselukuvaa ei ole olemassa!";
$l_alert["doctype_exists"] = "Dokumenttityyppi on jo olemassa!";
$l_alert["doctype_empty"] = "Sinun on annettava nimi dokumenttityypille!";
$l_alert["delete_cat"] = "Haluatko varmasti poistaa valitun kategorian?";
$l_alert["delete_cat_used"] = "Kategoriaa ei voida tuhota!";
$l_alert["cat_exists"] = "Kategoria on jo olemassa!";
$l_alert["cat_changed"] = "Kategoria on k‰ytˆss‰! Tallenna uudelleen dokumentit jotka k‰ytt‰v‰t t‰t‰ kategoriaa!\\nMuutetaanko kategoriaa siit‰ huolimatta?";
$l_alert["max_name_cat"] = "Kategorian nimi voi olla maksimissaan 32 merkki‰ pitk‰!";
$l_alert["not_entered_cat"] = "Kategorian nime‰ ei annettu!";
$l_alert["cat_new_name"] = "Anna uusi nimi kategorialle!";
$l_alert["we_backup_import_upload_err"] = "Varmuuskopiotiedostoa ladattaessa tapahtui virha! Ladattavien tiedostojen maksimikoko on %s. Jos varmuuskopiotiedoston koko ylitt‰‰ rajan, lataa tiedosto hakemistoon webEdition/we_backup k‰ytt‰en FTP -tiedostonsiirtoa ja valitse '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "Ei dokumentteja jotka vastaisivat valittuja m‰‰reit‰.";
$l_alert["we_name_not_allowed"] = "Termit 'we' and 'webEdition' ovat varattuja sanoja joten niit‰ ei voida k‰ytt‰‰!";
$l_alert["we_filename_empty"] = "Hakemistolle tai tiedostolle ei ole annettu nime‰!";
$l_alert["exit_multi_doc_question"] = "Useat avoinna olevat dokumentit sis‰lt‰v‰t tallentamattomia muutoksia. Jos jatkat kaikki tallentamattomat muutokset menetet‰‰n. Haluatko jatkaa ja hyl‰t‰ kaikki tekem‰si muutokset?";
$l_alert["exit_doc_question_".FILE_TABLE] = "Dokumenttia on muutettu.<br>Haluatko tallentaa muutokset?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Sivupohjaa on muutettu.<br>Haluatko tallentaa muutokset?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Luokkaa on muutettu.<BR>Haluatko tallentaa muutokset?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Objektia on muutettu.<br>Haluatko tallentaa muutokset?";
}
$l_alert["deleteTempl_notok_used"] = "Yksi tai useampi sivupohja on k‰ytˆss‰ ja niit‰ ei voida poistaa!";
$l_alert["deleteClass_notok_used"] = "One or more of the classes are in use and could not be deleted!"; // TRANSLATE
$l_alert["delete_notok"] = "Virhe poistettaessa!";
$l_alert["nothing_to_save"] = "Ei tallennettavaa!";
$l_alert["nothing_to_publish"] = "Julkaisutoiminto on toistaiseksi poistettu k‰ytˆst‰!";
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "Valittu kuva on tyhj‰.\\n Jatketaanko?";
$l_alert["path_exists"] = "Tiedostoa tai dokumenttia %s ei voitu tallentaa koska samanniminen dokumentti on kohteessa!";
$l_alert["folder_not_empty"] = "Yksi tai useampi hakemisto ei ole t‰ysin tyhj‰ joten poistaminen ei onnistunut! Poista tiedostot k‰sin.\\nSeuraavat tiedostot on poistettava k‰sin:\\n%s";
$l_alert["name_nok"] = "Nimet eiv‰t saa sis‰lt‰‰ merkkej‰ kuten '<' or '>'!";
$l_alert["found_in_workflow"] = "Yksi ja useampi valinta on tyˆnkulussa! Haluatko poistaa valinnat tyˆnkulusta?";
$l_alert["import_we_dirs"] = "Yrit‰t tuoda webEdition hakemistosta!\\nHakemistot on suojattu webEdition -j‰rjestelm‰ss‰ ja niit‰ ei voida k‰ytt‰‰ tuomiseen!";
$l_alert["wrong_file"]["image/*"] = "Valitsemasi tiedosto ei ole kuva!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Valitsemasi tiedosto ei ole Flash -tiedosto!";
$l_alert["wrong_file"]["video/quicktime"] = "Valitsemasi tiedosto ei ole Quicktime -tiedosto!";
$l_alert["no_file_selected"] = "Tuontitiedostoa ei ole valittu!";
$l_alert["browser_crashed"] = "Ikkunaa ei voitu avata koska selaimessa tapahtui virhe! Tallenna tyˆt ja k‰ynnist‰ selain uudelleen.";
$l_alert["copy_folders_no_id"] = "Tallenna nykyinen hakemisto ensin!";
$l_alert["copy_folder_not_valid"] =  "Samaa hakemistoa tai juurihakemistoja ei voida kopioida!";
$l_alert['no_views']['headline'] = 'Huomio';
$l_alert['no_views']['description'] = 'T‰lle dokumentille ei ole n‰kym‰‰.';
$l_alert['navigation']['last_document'] = 'Muokkaat viimeisint‰ dokumenttia.';
$l_alert['navigation']['first_document'] = 'Muokkaat ensimm‰ist‰ dokumenttia.';
$l_alert['navigation']['doc_not_found'] = 'Sopivaa dokumenttia ei lˆytynyt.';
$l_alert['navigation']['no_entry'] = 'Ei merkintˆj‰ sivuhistoriassa.';
$l_alert['navigation']['no_open_document'] = 'Dokumentteja ei ole auki.';
$l_alert['delete_single']['confirm_delete'] = 'Poistetaanko t‰m‰ dokumentti?';
$l_alert['delete_single']['no_delete'] = 'Dokumenttia ei voitu poistaa.';
$l_alert['delete_single']['return_to_start'] = 'Dokumentti poistettiin. \\nPalaa helppok‰yttˆtilan alkuun.';
$l_alert['move_single']['return_to_start'] = 'Dokumentti siirrettiin. \\nPalaa helppok‰yttˆtilan aloitusdokumenttiin.';
$l_alert['move_single']['no_delete'] = 'Dokumenttia ei voitu siirt‰‰';
$l_alert['cockpit_not_activated'] = 'Toimintoa ei voi suorittaa koska pika-aloitus ei ole auki.';
$l_alert['cockpit_reset_settings'] = 'Haluatko varmasti poistaa nykyiset pika-aloituksen asetukset ja palauttaa oletusasetukset?';
$l_alert['save_error_fields_value_not_valid'] = 'Korostetut kent‰t sis‰lt‰v‰t virheellisi‰ syˆtteit‰.\\nOle hyv‰ ja syˆt‰ kelvollista dataa.';

$l_alert['eplugin_exit_doc'] = "Dokumenttia on muokattu ulkoisella ohjelmalla. Yhteys ulkoisen ohjelman ja webEditionin v‰lill‰ suljetaan ja sis‰ltˆ‰ ei en‰‰ synkronoida.\\nHaluatko sulkea dokumentin?";

$l_alert['delete_workspace_user'] = "Hakemistoa %s ei voitu poistaa! Se on asetettu tyˆtilaksi seuraaville k‰ytt‰j‰ryhmille tai k‰ytt‰jille:\\n%s";
$l_alert['delete_workspace_user_r'] = "Hakemistoa %s ei voitu poistaa! Hakemiston sis‰ll‰ on alihakemistoja jotka on asetettu tyˆtilaksi seuraaville k‰ytt‰j‰ryhmille tai k‰ytt‰jille:\\n%s";
$l_alert['delete_workspace_object'] = "Hakemistoa %s ei voitu poistaa! Se on asetettu tyˆtilaksi seuraaville objekteille:\\n%s";
$l_alert['delete_workspace_object_r'] = "Hakemistoa %s ei voitu poistaa! Hakemiston sis‰ll‰ on alihakemistoja jotka on asetettu tyˆtilaksi seuraaville objekteille:\\n%s";


$l_alert['field_contains_incorrect_chars'] = "Kentt‰ (tyyppi‰ %s) sis‰lt‰‰ virheellisi‰ merkkej‰.";
$l_alert['field_input_contains_incorrect_length'] = "Kentt‰tyypin \'Tekstikentt‰\' maksimipituus on 255 merkki‰. Jos tarvitset enemm‰n tilaa, k‰yt‰ kentt‰tyyppi‰ \'Iso tekstikentt‰\'.";
$l_alert['field_int_contains_incorrect_length'] = "Kentt‰tyypin \'Kokonaisluku\' maksimipituus on 10 merkki‰.";
$l_alert['field_int_value_to_height'] = "Kentt‰tyypin \'Kokonaisluku\' maksimiarvo on 2147483647.";


$l_alert["we_filename_notValid"] = "Virheellinen tiedoston nimi\\nSallitut merkit ovat alfa-numeerisia, isot ja pienet kirjaimet, alaviiva, tavuviiva ja piste (a-z, A-Z, 0-9, _, -, .)";

$l_alert["login_denied_for_user"] = "The user cannot login. The user access is disabled."; // TRANSLATE
$l_alert["no_perm_to_delete_single_document"] = "You have not the needed permissions to delete the active document."; // TRANSLATE

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "The document has been moved to a folder with divergent customer account policies. Should the settings of the folder be transmitted to this document?"; // TRANSLATE
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "The directory has been moved to a folder with divergent customers account policies. Should the settings be adopted for this directory and all subelements? "; // TRANSLATE

$l_alert['field_in_tab_notvalid_pre'] = "The settings could not be saved, because the following fields contain invalid values:"; // TRANSLATE
$l_alert['field_in_tab_notvalid'] = ' - field %s on tab %s'; // TRANSLATE
$l_alert['field_in_tab_notvalid_post'] = 'Correct the fields before saving the settings.'; // TRANSLATE 
$l_alert['discard_changed_data'] = 'There are unsaved changes that will be discarded. Are you sure?'; // TRANSLATE
?>