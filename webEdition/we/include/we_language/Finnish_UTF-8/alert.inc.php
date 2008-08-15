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

$l_alert["noRightsToDelete"] = "\\'%s\\' ei voida poistaa! Sinulla ei ole käyttöoikeutta suorittaa tätä toimintoa!";
$l_alert["noRightsToMove"] = "\\'%s\\' ei voida siirtää! Sinulla ei ole oikeuksia tähän toimenpiteeseen!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "Dokumentti täytyy tallentaa ennenkuin se voidaan asettaa työnkulkuun!\\nHaluatko tallentaa dokumentin?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Dokumentti täytyy tallentaa ennenkuin se voidaan asettaa työnkulkuun!\\nHaluatko tallentaa dokumentin?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "Luokka täytyy tallentaa ennenkuin se voidaan asettaa työnkulkuun!\\nHaluatko tallentaa luokan?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Sivupohja täytyy tallentaa ennekuin se voidaan asettaa työnkulkuun!\\nHaluatko tallentaa sivupohjan?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Tiedosto ei sijaitse työtilassasi!";
$l_alert["folder"]["not_im_ws"] = "Hakemisto ei sijaitse työtilassasi!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Sivupohja ei sijaitse työtilassasi!";
$l_alert["delete_recipient"] = "Haluatko varmasti poistaa valitut sähköpostiosoitteet?";
$l_alert["recipient_exists"] = "Sähköpostiosoite on jo olemassa!";
$l_alert["input_name"] = "Anna uusi kategorian nimi!";
$l_alert['input_file_name'] = "Anna tiedostonimi.";
$l_alert["max_name_recipient"] = "Sähköpostiosoitteen pituus voi olla maksimissaan 255 merkkiä pitkä!";
$l_alert["not_entered_recipient"] = "Sähköpostiosoitetta ei ole annettu!";
$l_alert["recipient_new_name"] = "Muuta sähköpostiosoitetta!";
$l_alert["no_new"]["objectFile"] = "Sinulla ei ole oikeuksia luoda objekteja!<br>Sinulla ei ole joko oikeuksia tai Sellaista luokkaa ei ole olemassa jossa työtilasi olisi oikea!";
$l_alert["required_field_alert"] = "Kenttä '%s' on pakollinen!";
$l_alert["phpError"] = "webEdition -järjestelmää ei voida käynnistää!";
$l_alert["3timesLoginError"] = "Kirjautuminen epäonnistui %s kertaa! Odota %s minuuttia ja yritä uudelleen!";
$l_alert["popupLoginError"] = "webEdition -ikkunaa ei voitu avata!\\n\\nwebEdition -järjestelmä voidaan käynnistää voin jos selaimesi ei estä ponnahdusikkunoiden avautumista.";
$l_alert['publish_when_not_saved_message'] = "Dokumenttia ei ole tallennettu! Haluatko julkaista sen jokatapauksessa?";
$l_alert["template_in_use"] = "Sivupohja on käytössä, joten sitä ei voida poistaa!";
$l_alert["no_cookies"] = "Et ole aktivoinut keksejä. Aktivoi keksit selaimestasi!";
$l_alert["doctype_hochkomma"] = "Virheellinen nimi! Ei sallitut merkit ovat ' (hipsu) ja , (pilkku)!";
$l_alert["thumbnail_hochkomma"] = "Virheellinen nimi! Virheellisiä merkkejä ovat ' (heittomerkki) and , (pilkku)!";
$l_alert["can_not_open_file"] = "Tiedostoa %s ei voida avata!";
$l_alert["no_perms_title"] = "Pääsy estetty!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "Pääsy estetty!";
$l_alert["no_perms"] = "Ota yhteyttä omistajaan (%s) tai järjestelmänvalvojaan<br>jos tarvitset oikeuksia!";
$l_alert["temporaere_no_access"] = "Ei pääsyä!";
$l_alert["temporaere_no_access_text"] = "Tiedosto \"%s\" on käytössä käyttäjällä \"%s\".";
$l_alert["file_locked_footer"] = "Dokumentti on käytössä käyttäjällä \"%s\".";
$l_alert["file_no_save_footer"] = "Sinulla ei ole oikeuksia tallentaa tiedostoa.";
$l_alert["login_failed"] = "Väärä käyttäjänimi ja/tai salasana!";
$l_alert["login_failed_security"] = "webEdition -järjestelmää!\\n\\nTurvallisuussyistä kirjautuminen on keskeytetty, koska kirjautumisen maksimiaika kului umpeen!\\n\\nKirjaudu uudelleen järjestelmään.";
$l_alert["perms_no_permissions"] = "Sinulla ei ole oikeuksia suorittaa toimintoa!";
$l_alert["no_image"] = "Valitsemasi tiedosto ei ole kuva!";
$l_alert["delete_ok"] = "Tiedostot ja kansiot on poistettu!";
$l_alert["delete_cache_ok"] = "Välimuisti onnistuneesti tyhjennetty!";
$l_alert["nothing_to_delete"] = "Mitään ei ole valittu poistettavaksi!";
$l_alert["delete"] = "Poista valitut tiedostot?\\nHaluatko jatkaa?";
$l_alert["delete_cache"] = "Tyhjennä välimuisti valituilta osin?\\nHaluatko jatkaa?";
$l_alert["delete_folder"] = "Poista valitut hakemistot?\\nHuomaa: Hakemistoa poistettaessa, myös kaikki dokumentit poistettavan hakemiston sisällä poistetaan automaattisesti!\\nHaluatko jatkaa?";
$l_alert["delete_nok_error"] = "Tiedostoa '%s' ei voitu poistaa.";
$l_alert["delete_nok_file"] = "Tiedostoa '%s' ei voitu poistaa.\\nTiedosto on voitu kirjoitussuojata. ";
$l_alert["delete_nok_folder"] = "Hakemistoa '%s' ei voitu poistaa.\\nHakemisto on voitu kirjoitussuojata.";
$l_alert["delete_nok_noexist"] = "Tiedostoa '%s' ei ole olemassa!";
$l_alert["noResourceTitle"] = "No Item!"; // TRANSLATE
$l_alert["noResource"] = "The document or directory does not exist!"; // TRANSLATE
$l_alert["move_exit_open_docs_question"] = "Ennen kuin dokumentteja voi siitää, ne täytyy sulkea. Kaikki tallentamattomat muutokset menetetään sulkemisen yhteydessä. Seuraavat dokumentit suljetaan:\\n\\n";
$l_alert["move_exit_open_docs_continue"] = 'Jatka?';
$l_alert["move"] = "Siirrä valitut?\\nHaluatko jatkaa?";
$l_alert["move_ok"] = "Tiedostot onnistuneesti siirretty!";
$l_alert["move_duplicate"] = "Kohdehakemistossa on samannimisiä tiedostoja!\\nTiedostoja ei voida siirtää!.";
$l_alert["move_nofolder"] = "Valittuja tiedostoja ei voida siirtää.\\nHakemistojen siirto ei ole mahdollista.";
$l_alert["move_onlysametype"] = "Valittuja objekteja ei voida siirtää.\\nObjekteja voidaan siirtää vain oman luokkahakemistonsa sisäisesti.";
$l_alert["move_no_dir"] = "Valitse kohdehakemisto!";
$l_alert["document_move_warning"] = "Dokumentin siirron jälkeen on tarpeen suorittaa uudelleenrakennus.<br />Haluatko tehdä sen nyt?";
$l_alert["nothing_to_move"] = "Mitään ei ole merkitty siirrettäväksi!";
$l_alert["move_of_files_failed"] = "Yhtä tai useampaa tiedostoa ei voitu siirtää! Siirrä tiedostot manuaalisesti.\\nSeuraavat tiedostot vaikuttuivat:\\n%s";
$l_alert["template_save_warning"] = "Tämä sivupohja on käytössä %s julkaistulla dokumentilla. Tallennetaanko ne uudelleen? Huomautus: Tämä prosessi voi kestää hetkisen jos dokumentteja on useita!";
$l_alert["template_save_warning1"] = "Tämä sivupohja on käytössä yhdellä julkaistulla dokumentilla. Tallennetaanko tämä dokumentti uudelleen?";
$l_alert["template_save_warning2"] = "Tämä sivupohja on käytössä muilla sivupohjilla tai dokumenteilla, tallennetaanko ne uudelleen?";
$l_alert["thumbnail_exists"] = "Esikatselukuva on jo olemassa!";
$l_alert["thumbnail_not_exists"] = "Esikatselukuvaa ei ole olemassa!";
$l_alert["doctype_exists"] = "Dokumenttityyppi on jo olemassa!";
$l_alert["doctype_empty"] = "Sinun on annettava nimi dokumenttityypille!";
$l_alert["delete_cat"] = "Haluatko varmasti poistaa valitun kategorian?";
$l_alert["delete_cat_used"] = "Kategoriaa ei voida tuhota!";
$l_alert["cat_exists"] = "Kategoria on jo olemassa!";
$l_alert["cat_changed"] = "Kategoria on käytössä! Tallenna uudelleen dokumentit jotka käyttävät tätä kategoriaa!\\nMuutetaanko kategoriaa siitä huolimatta?";
$l_alert["max_name_cat"] = "Kategorian nimi voi olla maksimissaan 32 merkkiä pitkä!";
$l_alert["not_entered_cat"] = "Kategorian nimeä ei annettu!";
$l_alert["cat_new_name"] = "Anna uusi nimi kategorialle!";
$l_alert["we_backup_import_upload_err"] = "Varmuuskopiotiedostoa ladattaessa tapahtui virha! Ladattavien tiedostojen maksimikoko on %s. Jos varmuuskopiotiedoston koko ylittää rajan, lataa tiedosto hakemistoon webEdition/we_backup käyttäen FTP -tiedostonsiirtoa ja valitse '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "Ei dokumentteja jotka vastaisivat valittuja määreitä.";
$l_alert["we_name_not_allowed"] = "Termit 'we' and 'webEdition' ovat varattuja sanoja joten niitä ei voida käyttää!";
$l_alert["we_filename_empty"] = "Hakemistolle tai tiedostolle ei ole annettu nimeä!";
$l_alert["exit_multi_doc_question"] = "Useat avoinna olevat dokumentit sisältävät tallentamattomia muutoksia. Jos jatkat kaikki tallentamattomat muutokset menetetään. Haluatko jatkaa ja hylätä kaikki tekemäsi muutokset?";
$l_alert["exit_doc_question_".FILE_TABLE] = "Dokumenttia on muutettu.<br>Haluatko tallentaa muutokset?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Sivupohjaa on muutettu.<br>Haluatko tallentaa muutokset?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Luokkaa on muutettu.<BR>Haluatko tallentaa muutokset?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Objektia on muutettu.<br>Haluatko tallentaa muutokset?";
}
$l_alert["deleteTempl_notok_used"] = "Yksi tai useampi sivupohja on käytössä ja niitä ei voida poistaa!";
$l_alert["deleteClass_notok_used"] = "One or more of the classes are in use and could not be deleted!"; // TRANSLATE
$l_alert["delete_notok"] = "Virhe poistettaessa!";
$l_alert["nothing_to_save"] = "Ei tallennettavaa!";
$l_alert["nothing_to_publish"] = "Julkaisutoiminto on toistaiseksi poistettu käytöstä!";
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "Valittu kuva on tyhjä.\\n Jatketaanko?";
$l_alert["path_exists"] = "Tiedostoa tai dokumenttia %s ei voitu tallentaa koska samanniminen dokumentti on kohteessa!";
$l_alert["folder_not_empty"] = "Yksi tai useampi hakemisto ei ole täysin tyhjä joten poistaminen ei onnistunut! Poista tiedostot käsin.\\nSeuraavat tiedostot on poistettava käsin:\\n%s";
$l_alert["name_nok"] = "Nimet eivät saa sisältää merkkejä kuten '<' or '>'!";
$l_alert["found_in_workflow"] = "Yksi ja useampi valinta on työnkulussa! Haluatko poistaa valinnat työnkulusta?";
$l_alert["import_we_dirs"] = "Yrität tuoda webEdition hakemistosta!\\nHakemistot on suojattu webEdition -järjestelmässä ja niitä ei voida käyttää tuomiseen!";
$l_alert["wrong_file"]["image/*"] = "Valitsemasi tiedosto ei ole kuva!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Valitsemasi tiedosto ei ole Flash -tiedosto!";
$l_alert["wrong_file"]["video/quicktime"] = "Valitsemasi tiedosto ei ole Quicktime -tiedosto!";
$l_alert["no_file_selected"] = "Tuontitiedostoa ei ole valittu!";
$l_alert["browser_crashed"] = "Ikkunaa ei voitu avata koska selaimessa tapahtui virhe! Tallenna työt ja käynnistä selain uudelleen.";
$l_alert["copy_folders_no_id"] = "Tallenna nykyinen hakemisto ensin!";
$l_alert["copy_folder_not_valid"] =  "Samaa hakemistoa tai juurihakemistoja ei voida kopioida!";
$l_alert['no_views']['headline'] = 'Huomio';
$l_alert['no_views']['description'] = 'Tälle dokumentille ei ole näkymää.';
$l_alert['navigation']['last_document'] = 'Muokkaat viimeisintä dokumenttia.';
$l_alert['navigation']['first_document'] = 'Muokkaat ensimmäistä dokumenttia.';
$l_alert['navigation']['doc_not_found'] = 'Sopivaa dokumenttia ei löytynyt.';
$l_alert['navigation']['no_entry'] = 'Ei merkintöjä sivuhistoriassa.';
$l_alert['navigation']['no_open_document'] = 'Dokumentteja ei ole auki.';
$l_alert['delete_single']['confirm_delete'] = 'Poistetaanko tämä dokumentti?';
$l_alert['delete_single']['no_delete'] = 'Dokumenttia ei voitu poistaa.';
$l_alert['delete_single']['return_to_start'] = 'Dokumentti poistettiin. \\nPalaa helppokäyttötilan alkuun.';
$l_alert['move_single']['return_to_start'] = 'Dokumentti siirrettiin. \\nPalaa helppokäyttötilan aloitusdokumenttiin.';
$l_alert['move_single']['no_delete'] = 'Dokumenttia ei voitu siirtää';
$l_alert['cockpit_not_activated'] = 'Toimintoa ei voi suorittaa koska pika-aloitus ei ole auki.';
$l_alert['cockpit_reset_settings'] = 'Haluatko varmasti poistaa nykyiset pika-aloituksen asetukset ja palauttaa oletusasetukset?';
$l_alert['save_error_fields_value_not_valid'] = 'Korostetut kentät sisältävät virheellisiä syötteitä.\\nOle hyvä ja syötä kelvollista dataa.';

$l_alert['eplugin_exit_doc'] = "Dokumenttia on muokattu ulkoisella ohjelmalla. Yhteys ulkoisen ohjelman ja webEditionin välillä suljetaan ja sisältöä ei enää synkronoida.\\nHaluatko sulkea dokumentin?";

$l_alert['delete_workspace_user'] = "Hakemistoa %s ei voitu poistaa! Se on asetettu työtilaksi seuraaville käyttäjäryhmille tai käyttäjille:\\n%s";
$l_alert['delete_workspace_user_r'] = "Hakemistoa %s ei voitu poistaa! Hakemiston sisällä on alihakemistoja jotka on asetettu työtilaksi seuraaville käyttäjäryhmille tai käyttäjille:\\n%s";
$l_alert['delete_workspace_object'] = "Hakemistoa %s ei voitu poistaa! Se on asetettu työtilaksi seuraaville objekteille:\\n%s";
$l_alert['delete_workspace_object_r'] = "Hakemistoa %s ei voitu poistaa! Hakemiston sisällä on alihakemistoja jotka on asetettu työtilaksi seuraaville objekteille:\\n%s";


$l_alert['field_contains_incorrect_chars'] = "Kenttä (tyyppiä %s) sisältää virheellisiä merkkejä.";
$l_alert['field_input_contains_incorrect_length'] = "Kenttätyypin \'Tekstikenttä\' maksimipituus on 255 merkkiä. Jos tarvitset enemmän tilaa, käytä kenttätyyppiä \'Iso tekstikenttä\'.";
$l_alert['field_int_contains_incorrect_length'] = "Kenttätyypin \'Kokonaisluku\' maksimipituus on 10 merkkiä.";
$l_alert['field_int_value_to_height'] = "Kenttätyypin \'Kokonaisluku\' maksimiarvo on 2147483647.";


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