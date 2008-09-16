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
 * Language file: export.inc.php
 * Provides language strings.
 * Language: English
 */
$l_export["save_changed_export"] = "Valitse on muokattu.\\nHaluatko tallentaa muutokset?";
$l_export["auto_selection"] = "Automaattinen valinta";
$l_export["txt_auto_selection"] = "Vie dokumentteja ja objekteja automaattisesti riippuen dokumentin tyypistä ja luokasta.";
$l_export["txt_auto_selection_csv"] = "Vie objekteja automaattisesti riippuen luokasta.";
$l_export["manual_selection"] = "Manuaalinen valinta";
$l_export["txt_manual_selection"] = "Vie manuaalisesti valinta.";
$l_export["txt_manual_selection_csv"] = "Vie manuaalisesti valinta.";
$l_export["element"] = "Elementin valinta";
$l_export["documents"] = "Dokumentit";
$l_export["objects"] = "Objektit";
$l_export["step1"] = "Valitse parametrit";
$l_export["step2"] = "Valitse kohdat jotka haluat viedä";
$l_export["step3"] = "Valitse vientiparametrit";
$l_export["step10"] = "Vienti päättynyt";
$l_export["step99"] = "Virhe viedessä!";
$l_export["step99_notice"] = "Vienti ei mahdollista";
$l_export["server_finished"] = "Vientitiedosto on tallennettu palvelimelle.";
$l_export["backup_finished"] = "Vienti onnistui.";
$l_export["download_starting"] = "Vientitiedoston lataaminen on aloitettu.<br><br>Jos siirto ei ala 10 minuutin kuluessa,<br>";
$l_export["download"] = "klikkaa tästä.";
$l_export["download_failed"] = "Pyytämääsi tiedostoa ei ole olemassa tai sinulla ei ole oikeutta ladata sitä.";
$l_export["file_format"] = "Tiedostomuoto";
$l_export["export_to"] = "Vie kohteeseen";
$l_export["export_to_server"] = "Palvelin";
$l_export["export_to_local"] = "Paikallinen kovalevy";
$l_export["cdata"] = "Koodaus";
$l_export["export_xml_cdata"] = "Lisää CDATA kohdat";
$l_export["export_xml_entities"] = "Korvaa nimitykset";
$l_export["filename"] = "Tiedostonimi";
$l_export["path"] = "Polku";
$l_export["doctypename"] = "Dokumentit dokumenttityypin perusteella";
$l_export["classname"] = "Objektit luokan perusteella";
$l_export["dir"] = "Hakemisto";
$l_export["categories"] = "Kategoriat";
$l_export["wizard_title"] = "Vientivelho";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Erotin";
$l_export["csv_enclose"] = "Sulkeva merkki";
$l_export["csv_escape"] = "\"Escape\" -merkki";
$l_export["csv_lineend"] = "Tiedostomuoto";
$l_export["csv_null"] = "NULL korvaaja";
$l_export["csv_fieldnames"] = "Aseta kenttänimet ensimmäiselle riville";
$l_export["windows"] = "Windows muoto";
$l_export["unix"] = "UNIX muoto";
$l_export["mac"] = "Mac muoto";
$l_export["generic_export"] = "Yleinen vienti";
$l_export["title"] = "Vientivelho";
$l_export["gxml_export"] = "Yleinen XML vienti";
$l_export["txt_gxml_export"] = "Vie webEdition dokumenttejä ja objekteja XML \"flat\" tiedostoon (3 tasoa).";
$l_export["csv_export"] = "CSV vienti";
$l_export["txt_csv_export"] = "Vie webEdition objekteja CSV tiedostoon (comma separated values, pilkkueroteltu).";
$l_export["csv_params"] = "Asetukset";
$l_export["error"] = "Vienti ei onnistunut!";
$l_export["error_unknown"] = "Tuntematon virhe!";
$l_export["error_object_module"] = "Dokumenttien vienti CSV -tiedostoon ei ole tuettu,<br><br>koska tietokanta/objektimoduuli ei ole asennettu, CSV -tiedostoon vienti ei ole mahdollista.";
$l_export["error_nothing_selected_docs"] = "Vientiä ei suoritettu!<br><br>Dokumenttejä ei ole valittu.";
$l_export["error_nothing_selected_objs"] = "Vientiä ei suoritettu!<br><br>Dokumenttejä tai objekteja ei valittu.";
$l_export["error_download_failed"] = "Vientitiedoston lataaminen ei onnistunut.";
$l_export["comma"] = ", {pilkku}";
$l_export["semicolon"] = "; {puolipiste}";
$l_export["colon"] = ": {kaksoispiste}";
$l_export["tab"] = "\\t {tabulaattori}";
$l_export["space"] = "  {välilyönti}";
$l_export["double_quote"] = "\" {lainausmerkit}";
$l_export["single_quote"] = "' {heittomerkit}";
$l_export['we_export'] = 'webEdition vienti';
$l_export['wxml_export'] = 'webEdition XML vienti';
$l_export['txt_wxml_export'] = 'webEdition DTD:n (document type definition) mukainen dokumenttien, sivupohjien, objektien ja luokkien vienti.';

$l_export['options'] = 'Valinnat';
$l_export['handle_document_options'] = 'Dokumentit';
$l_export['handle_template_options'] = 'Sivupohjat';
$l_export['handle_def_templates'] = 'Vie oletussivupohjat';
$l_export['handle_document_includes'] = 'Vie sisälletyt (inclue) documentit';
$l_export['handle_document_linked'] = 'Vie linkitetyt dokumentit';
$l_export['handle_object_options'] = 'Objektit';
$l_export['handle_def_classes'] = 'Vie oletusluokat';
$l_export['handle_object_includes'] = 'Vie sisälletyt (include) objektit';
$l_export['handle_classes_options'] = 'Luokat';
$l_export['handle_class_defs'] = 'Oletusarvo';
$l_export['handle_object_embeds'] = 'Vie sisäiset objektit';
$l_export['handle_doctype_options'] = 'Dokumenttityypit/<br>Kategoriat/<br>Navigaatio';
$l_export['handle_doctypes'] = 'Dokumenttityypit';
$l_export['handle_categorys'] = 'Kategoriat';
$l_export['export_depth'] = 'Viennin syvyys';
$l_export['to_level'] = 'tasolle';
$l_export['select_export'] ='Valitse vietävät kohdat alla olevasta hakemistopuusta rastittamalla ne. Huomioitavaa: jos viet hakemiston, myös kaikki dokumentit kyseisessä hakemistossa viedään !';
$l_export['templates'] = 'Sivupohjat';
$l_export['classes'] = 'Luokat';

$l_export['nothing_to_delete'] = 'Ei poistettavaa.';
$l_export['nothing_to_save'] = 'Ei tallennettavaa!';
$l_export['no_perms'] = 'Ei käyttöoikeuksia!';
$l_export['new'] = 'Uusi';
$l_export['export'] = 'Vie';
$l_export['group'] = 'Ryhmä';
$l_export['save'] = 'Tallenna';
$l_export['delete'] = 'Poista';
$l_export['quit'] = 'Poistu';
$l_export['property'] = 'Ominaisuudet';
$l_export['name'] = 'Nimi';
$l_export['save_to'] = 'Tallenna kohteeseen:';
$l_export['selection'] = 'Valinta';
$l_export['save_ok'] = 'Tallennus onnistui.';
$l_export['save_group_ok'] = 'Ryhmä tallennettu.';
$l_export['log'] = 'Lisätiedot';
$l_export['start_export'] = 'Aloita vienti';
$l_export['prepare'] = 'Valmistellaan vientiä...';
$l_export['doctype'] = 'Dokumenttityyppi';
$l_export['category'] = 'Kategia';
$l_export['end_export'] = 'Vienti päättynyt';
$l_export['newFolder'] = "Uusi ryhmä";
$l_export['folder_empty'] = "Hakemisto on tyhjä!";
$l_export['folder_path_exists'] = "Hakemisto on jo olemassa!";
$l_export['wrongtext'] = "Nimi ei ole sallittu";
$l_export['wrongfilename'] = "Tiedostonimi ei ole sallittu!";
$l_export['folder_exists'] = "Hakemisto on jo olemassa";
$l_export['delete_ok'] = 'Vientitiedosto on poistettu.';
$l_export['delete_nok'] = 'VIRHE: Vientitiedostoa ei poistettu';
$l_export['delete_group_ok'] = 'Ryhmä on poistettu.';
$l_export['delete_group_nok'] = 'VIRHE: Ryhmää ei poistettu';
$l_export['delete_question'] = 'Haluatko poistaa valitun vientitiedoston?';
$l_export['delete_group_question'] = 'Haluatko poistaa valitun ryhmän?';
$l_export['download_starting2'] = 'Vientitiedoston lataaminen on alkanut.';
$l_export['download_starting3'] = 'Jos lataaminen ei ala 10 sekunnin sisllä, ';
$l_export['working'] = 'Työskennellään';

$l_export['txt_document_options'] = 'Oletussivupohja on sivupohja joka määritetään oletukseksi dokumentin ominaisuuksiin. Sisällytetyt dokumentit ovat sisäisiä dokumentteja jotka sisällytetään vietävään dokumenttiin tageilla we:include, we:form, we:url, we:linToSeeMode, we:a, we:href, we:link, we:css, we:js ja we:addDelNewsletterEmail. Sisällytetyt objektit ovat objekteja jotka sisällytetään vientidokumenttiin tageilla we:object ja we:form. Linkitetyt dokumentit ovat sisäisiä dokumentteja jotka linkitetään vientidokumenttiin HTML -tageilla body, a, img, table ja td.';
$l_export['txt_object_options'] = 'Oletusluokka on luokka joka määritetään oletukseksi objektin ominaisuuksiin. Viedäksesi myös objektiin liitetyt sisäiset dokumentit yms., aktivoi optio "Vie sisälletyt dokumentit" ';
$l_export['txt_exportdeep_options'] = 'Vientisyvyys määrittää viennin hakemistosyvyyden. Arvon on oltava numeerinen!';
$l_export['name_empty'] = 'Nimi ei voi olla tyhjä!';
$l_export['name_exists'] = 'Nimi on jo olemassa!';

$l_export['help'] = 'Ohje';
$l_export['info'] = 'Tietoja';
$l_export['path_nok'] = 'Polku on ei sallittu!';

$l_export['must_save'] = "Vienti tallennettu.\\nSinun on tallennettava vientitieto ennen vientiä!";
$l_export['handle_owners_option'] = 'Omistajan tieto';
$l_export['handle_owners'] = 'Vie omistajan tieto';
$l_export['txt_owners'] = 'Vie linkitetty omistajan tieto';

$l_export['weBinary'] = 'Tiedosto';
$l_export['handle_navigation'] = 'Navigaatio';
$l_export['weNavigation'] = 'Navigaatio';
$l_export['weNavigationRule'] = 'Navigointisääntö';
$l_export['weThumbnail'] = 'Pikkukuvat';
$l_export['handle_thumbnails'] = 'Pikkukuvat';

$l_export['navigation_hint'] = 'To export the navigation entries, the template on which the navigation is displayed has also to be exported!'; // TRANSLATE

?>