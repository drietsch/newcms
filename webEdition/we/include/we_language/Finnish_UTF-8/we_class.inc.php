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
 * Language file: we_class.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$l_we_class["ChangePark"] = "Voit muuttaa tätä määrettä vain jos dokumentti ei ole julkaistu!";
$l_we_class["fieldusers"] = "Käyttäjät";
$l_we_class["other"] = "Muut";
$l_we_class["use_object"] = "Käytä objektia";
$l_we_class["language"] = "Kieli";
$l_we_class["users"] = "Oletusomistajat";
$l_we_class["copytext/css"] = "Kopioi CSS -tyylitiedosto";
$l_we_class["copytext/js"] = "Kopioi JavaScript -tiedosto";
$l_we_class["copytext/html"] = "Kopioi HTML -sivu";
$l_we_class["copytext/plain"] = "Kopioi tekstitiedosto";
$l_we_class["copytext/xml"] = "Kopioi XML dokumentti";
$l_we_class["copyTemplate"] = "Kopioi sivupohja";
$l_we_class["copyFolder"] = "Kopioi hakemisto";
$l_we_class["copy_owners_expl"] = "Valitse hakemisto jonka sisällön haluat kopioida nykyiseen hakemistoon.";
$l_we_class["category"] = "Kategoria";
$l_we_class["folder_saved_ok"] = "Hakemisto '%s' on tallennettu!";
$l_we_class["response_save_ok"] = "Dokumentti '%s' on tallennettu!";
$l_we_class["response_publish_ok"] = "Dokumentti '%s' on julkaistu!";
$l_we_class["response_unpublish_ok"] = "Dokumentti '%s' on poistettu julkaisusta!";
$l_we_class["response_save_notok"] = "Virhe tallennettaessa dokumenttia '%s'!";
$l_we_class["response_path_exists"] = "Dokumenttia ja hakemistoa %s ei voitu tallentaa koska toinen dokumentti sijaitsee samassa kohteessa!";
$l_we_class["width"] = "Leveys";
$l_we_class["height"] = "Korkeus";
$l_we_class["width_tmp"] = "Leveys";
$l_we_class["height_tmp"] = "Korkeus";
$l_we_class["percent_width_tmp"] = "Leveys %";
$l_we_class["percent_height_tmp"] = "Korkeus %";
$l_we_class["alt"] = "Vaihtoehtoinen teksti";
$l_we_class["alt_kurz"] = "Valinnainen teksti";
$l_we_class["title"] = "Otsikko";
$l_we_class["use_meta_title"] = "Käytä meta-otsikkoa";
$l_we_class["longdesc_text"] = "Tiedoston pitempi kuvaus";
$l_we_class["align"] = "Paikka";
$l_we_class["name"] = "Nimi";
$l_we_class["hspace"] = "Vaakasuuntainen väli";
$l_we_class["vspace"] = "Pystysuuntainen väli";
$l_we_class["border"] = "Reunus";
$l_we_class["fields"] = "Kentät";
$l_we_class["AutoFolder"] = "Automaattinen kansio";
$l_we_class["AutoFilename"] = "Automaattinen tiedoston nimi";
$l_we_class["import_ok"] = "Dokumentit on tuotu!";
$l_we_class["function"] = "Toiminto";
$l_we_class["contenttable"] = "Sisältötaulukko";
$l_we_class["quality"] = "Laatu";
$l_we_class["salign"] = "Skaalattu paikka";
$l_we_class["play"] = "Soita";
$l_we_class["loop"] = "Toisto";
$l_we_class["scale"] = "Skaalaa";
$l_we_class["bgcolor"] = "Taustan väri";
$l_we_class["response_save_noperms_to_create_folders"] = "Dokumenttia ei voitu tallentaa koska sinulla ei ole tarvittavia oikeuksia luoda hakemistoja (%s)!";
$l_we_class["file_on_liveserver"]="Tiedosto on jo olemassa";
$l_we_class["defaults"] = "Oletusarvot";
$l_we_class["attribs"] = "Määreet";
$l_we_class["intern"] = "Sisäinen";
$l_we_class["extern"] = "Ulkoinen";
$l_we_class["linkType"] = "Linkin tyyppi";
$l_we_class["href"] = "Href"; // TRANSLATE
$l_we_class["target"] = "Kohde";
$l_we_class["hyperlink"] = "Hyperlinkki";
$l_we_class["nolink"] = "Ei linkkiä";
$l_we_class["noresize"] = "Säilytä alkuperäinen koko";
$l_we_class["pixel"] = "Pikseli";
$l_we_class["percent"] = "Prosentti";
$l_we_class["new_doc_type"] = "Uusi dokumenttityyppi";
$l_we_class["doctypes"] = "Dokumentti tyypit";
$l_we_class["subdirectory"] = "Alihakemisto";
$l_we_class["subdir"][SUB_DIR_NO] = "-- ei hakemistoa --";
$l_we_class["subdir"][SUB_DIR_YEAR] = "Vuosi";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH] = "Vuosi/Kuukausi";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH_DAY] = "Vuosi/kuukausi/päivä";
$l_we_class["doctype_save_ok"] = "Dokumenttityyppi '%s' tallennettu!";
$l_we_class["doctype_save_nok_exist"] = "Dokumenttityyppi '%s' on jo olemassa.\\n Muuta dokumenttityypin nimeä ja koita uudestaan!";
$l_we_class["delete_doc_type"] = "Poista '%s'";
$l_we_class["doctype_delete_prompt"] = "Poista dokumenttityyppi '%s'! Oletko varma?";
$l_we_class["doctype_delete_nok"] = "Dokukenttiyyppi '%s' on käytössä!\\nDokumenttia ei voida poistaa!";
$l_we_class["doctype_delete_ok"] = "Dokumenttityyppi '%s' on poistettu!";
$l_we_class["confirm_ext_change"] = "Olet muuttanut sivun dynaamista luontia\\nHaluatko muuttaa tiedoston päätteen oletukseksi?";
$l_we_class["newDocTypeName"] = 'Kirjoita uuden dokumenttityypin nimi!';
$l_we_class["no_perms"] = 'Sinulla ei ole oikeuksia käyttää tätä toimintoa!';
$l_we_class["workspaces"] = "Työtilat";
$l_we_class["extraWorkspaces"] = "Lisätyötilat";
$l_we_class["edit"] = "Muokkaa";
$l_we_class["edit_image"] = "Kuvankäsittely";
$l_we_class["workspace"] = "Työtila";
$l_we_class["information"] = "Tietoja";
$l_we_class["previeweditmode"] = "Esikatsele Muokkaustilaa";
$l_we_class["preview"] = "Esikatselu";
$l_we_class["no_preview_available"] = "Tälle tiedostolle ei ole tarjolla esikatselutilaa. Katsellaksesi tiedostoa lataa se ensin omalle koneellesi.";
$l_we_class["file_not_saved"] = "Tiedostoa ei tallennettu vielä.";
$l_we_class["download"] = "Lataa";
$l_we_class["validation"] = "Validointi";
$l_we_class["variants"] = "Muunnelmat";
$l_we_class["tab_properties"] = "Ominaisuudet";
$l_we_class["metainfos"] = "Meta -tiedot";
$l_we_class["fields"] = "Kentät";
$l_we_class["search"] = "Etsi";
$l_we_class["schedpro"] = "Ajastin PRO";
$l_we_class["generateTemplate"] = "Luo sivupohja";
$l_we_class["autoplay"] = "Automaattinen toisto";
$l_we_class["controller"] = "Näytä ohjaimet";
$l_we_class["volume"] = "Äänenvoimakkuus";
$l_we_class["hidden"] = "Piilotettu";
$l_we_class["workspacesFromClass"] = "Peri työtilat luokalta";
$l_we_class["image"] = "Kuva";
$l_we_class["thumbnails"] = "Esikatselukuvat";
$l_we_class["metadata"] = "Metadata"; // TRANSLATE
$l_we_class["edit_show"] = "Näytä kuvan ominaisuudet";
$l_we_class["edit_hide"] = "Piilota kuvan ominaisuudet";
$l_we_class["resize"] = "Muuta kokoa";
$l_we_class["rotate"] = "Käännä kuvaa";
$l_we_class["rotate_hint"] = "Palvelimelle asennettu GD-kirjaston versio ei tue kuvan kääntöä!";
$l_we_class["crop"] = "Rajaa kuvaa";
$l_we_class["quality"] = "Laatu";
$l_we_class["quality_hint"] = "Aseta kuvan laatu JPEG -pakkauselle tässä.<br><br> 10: paras laatu, vie eniten tilaa kovalevyltä <br>0: huonoin laatu, vie vähiten tilaa kovalevyltä";
$l_we_class["quality_maximum"] = "Maksimi";
$l_we_class["quality_high"] = "Korkea";
$l_we_class["quality_medium"] = "Keskitaso";
$l_we_class["quality_low"] = "Huono";
$l_we_class["convert"] = "Muunna kuvan tyyppi";
$l_we_class["convert_gif"] = "GIF";
$l_we_class["convert_jpg"] = "JPEG";
$l_we_class["convert_png"] = "PNGt";
$l_we_class["rotate0"] = "Älä käännä kuvaa";
$l_we_class["rotate180"] = "Käännä 180&deg;";
$l_we_class["rotate90l"] = "Käännä 90&deg; ccw";
$l_we_class["rotate90r"] = "Käännä 90&deg; cw";
$l_we_class["change_compression"] = "Muuta pakkausta";
$l_we_class["upload"] = "Lataa";
$l_we_class["type_not_supported_hint"] = "Palvelimelle asennettu GD-kirjasto ei tue %s kuvatyyppiä! Muunna kuvaformaatti yhteensopivaan muotoon!";
$l_we_class["CSS"] = "CSS"; // TRANSLATE
$l_we_class['we_del_workspace_error'] = "Työtilaa ei voitu poistaa koska se on luokan objektien käytössä!";
$l_we_class["master_template"] = "Pääsivupohja";
$l_we_class["same_master_template"] = "Valittu pääsivupohja ei voi olla identtinen nykyisen sivupohjan kassa.!";
$l_we_class["documents"] = "Dokumentit";
$l_we_class["no_documents"] = "Ei tähän sivupohjaan perustuvia dokumentteja";

$l_we_class["grant_language"] = "Vaihda kieltä";
$l_we_class["grant_language_expl"] = "Muuta kaikkien tämänhetkisen hakemiston alla olevien tiedostojen (ja hakemistojen) kieltä.";
$l_we_class["grant_language_ok"] = "Kieli onnistuneesti muutettu!";
$l_we_class["grant_language_notok"] = "Virhe kielenvaihdon yhteydessä!";
$l_we_class["notValidFolder"] = "Valittu hakemisto on virheellinen!";


$l_we_class["saveFirstMessage"] = "Sinun on tallennettava muutokset ennen tämän komennon suorittamista.";

$l_we_class["image_edit_null_not_allowed"] = "Kentissä leveys ja korkeus vain nollaa suuremmat arvot ovat sallittuja!";

$l_we_class['doctype_changed_question'] = "Should the default values for the document type be applied for this document?"; // TRANSLATE
$l_we_class['availableAfterSave'] = "The feature is only available after saving the entry."; // TRANSLATE
?>