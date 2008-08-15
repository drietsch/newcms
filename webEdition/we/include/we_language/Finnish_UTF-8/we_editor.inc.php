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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "Kenttä '%s' on jo olemassa! Kentän nimi on oltava yksilöllinen!";
$l_we_editor["variantNameInvalid"] = "Artikkelimuuttujan nimi ei voi olla tyhjä!";

$l_we_editor["folder_save_nok_parent_same"] = "Valittu juurihakemisto on samanniminen kuin nykyinen hakemisto! Valitse toinen hakemisto ja yritä uudelleen!";
$l_we_editor["pfolder_notsave"] = "Hakemistoa ei voida tallentaa valittuun hakemistoon!";
$l_we_editor["required_field_alert"] = "Kenttä '%s' on pakollinen!";

$l_we_editor["category"]["response_save_ok"] = "Kategoriaa '%s' on tallennettu!";
$l_we_editor["category"]["response_save_notok"] = "Virhe tallennettaessa kategoriaa '%s'!";
$l_we_editor["category"]["response_path_exists"] = "Kategoriaa '%s' ei voitu tallentaa koska toinen kategoria sijaitsee samassa kohteessa!";
$l_we_editor["category"]["we_filename_notValid"] = "Virheellinen nimi!\\nMerkit \", \\' < > ja / eivät ole sallittuja!";
$l_we_editor["category"]["filename_empty"]       = "Tiedoston nimi ei voi olla tyhjä.";
$l_we_editor["category"]["name_komma"] = "Virheellinen nimi! Pilkku ei ole sallittu!";

$l_we_editor["text/webedition"]["response_save_ok"] = "webEdition -sivu '%s' on tallennettu!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "webEdition -sivu '%s' on julkaistu!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Virhe julkaistaessa webEdition -sivua '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "webEdition -sivu '%s' on poistettu julkaisusta!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Virhe poistettaessa julkaisusta webEdition -sivua '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "webEdition -sivu '%s' ei ole julkaistu!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Virhe tallennettaessa webEdition -sivua '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "webEdition sivua '%s' ei voitu tallentaa, koska toinen dokumentti tai hakemisto sijaisee samassa kohteessa!";
$l_we_editor["text/webedition"]["filename_empty"] = "Dokumentille ei ole annettu nimeä!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Virheellinen tiedoston nimi!\\nSallitut merkit ovat alfa-numeerisia, isot ja pienet kirjaimet, alaviiva, tavuviiva ja piste (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Annettu tiedoston nimi ei ole sallittu!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Dokumenttia ei voitu tallentaa koska sinulla ei ole riittäviä oikeuksia luoda kansioita (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "webEdition -sivu julkaistaan automaattisesti %s.";

$l_we_editor["text/html"]["response_save_ok"] = "HTML -sivu '%s' on tallennettu!";
$l_we_editor["text/html"]["response_publish_ok"] = "HTML -sivu '%s' on julkaistu!";
$l_we_editor["text/html"]["response_publish_notok"] = "Virhe julkaistaessa HTML -sivua '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "HTML -sivu '%s' on poistettu julkaisusta!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Virhe poistettaessa julkaisusta HTML -sivua '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "HTML -sivua '%s' ei ole julkaistu!";
$l_we_editor["text/html"]["response_save_notok"] = "Virhe tallennettaessa HTML -sivua '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "HTML -sivua '%s' ei voitu tallentaa koska toinen dokumentti tai hakemisto sijaitsee samassa kohteessa!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Sivupohja '%s' on tallennettu!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Sivupohja '%s' on julkaistu!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Sivupohja '%s' on poistettu julkaisusta!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Virhe tallennettaessa sivupohjaa '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Sivupohjaa '%s' ei voitu tallentaa koska toinen sivupohja tai hakemisto sijaitsee samassa kohteessa!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Tyylitiedosto '%s' on tallennettu!";
$l_we_editor["text/css"]["response_publish_ok"] = "Tyylitiedosto '%s' on julkaistu!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Tyylitiedosto '%s' on poistettu julkaisusta!";
$l_we_editor["text/css"]["response_save_notok"] = "Virhe tallennettaessa tyylitiedostoa '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Tyylitiedostoa '%s' ei voitu tallentaa, koska samanniminen tiedosto tai hakemisto sijaitsee samassa kohteessa!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "JavaScript -tiedosto '%s' on julkaistu!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "JavaScript -tiedosto '%s' on poistettu julkaisusta!";
$l_we_editor["text/js"]["response_save_notok"] = "Virhe tallennettaessa JavaScript -tiedostoa '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "JavaScript -tiedostoa '%s' ei voitu tallenntaa, koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Tekstitiedosto '%s' on julkaistu!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Tekstitiedosto '%s' on poistettu julkaisusta!";
$l_we_editor["text/plain"]["response_save_notok"] = "Virhe tallennettaessa tekstitiedostoa '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Tekstitiedostoa '%s' ei voitu tallentaa, koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/xml"]["response_save_ok"] = "The XML file '%s' has been successfully saved!";
$l_we_editor["text/xml"]["response_publish_ok"] = "XML -tiedosto '%s' onnistuneesti julkaistu!";
$l_we_editor["text/xml"]["response_unpublish_ok"] = "XML -tiedosto '%s' onnistuneesti poistettu julkaisusta!";
$l_we_editor["text/xml"]["response_save_notok"] = "Virhe tallentaessa XML -tiedostoa '%s'!";
$l_we_editor["text/xml"]["response_path_exists"] = "XML -tiedostoa '%s' ei voitu tallentaa koska toinen dokumentti tai hakemisto sijaitsee samassa paikassa!";
$l_we_editor["text/xml"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/xml"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/xml"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/xml"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "The directory '%s' has been successfully saved!";
$l_we_editor["folder"]["response_publish_ok"] = "Hakemisto '%s' on julkaistu!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Hakemisto '%s' on poistettu julkaisusta!";
$l_we_editor["folder"]["response_save_notok"] = "Virhe hakemiston '%s' tallennuksessa!";
$l_we_editor["folder"]["response_path_exists"] = "Hakemistoa '%s' ei voitu tallentaa koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["folder"]["filename_empty"] = "Hakemistolle ei ole annettu nimeä!";
$l_we_editor["folder"]["we_filename_notValid"] = "Virheellinen hakemiston nimi\\nSallitut merkit ovat alfa-numeerisia, isot ja pienet kirjaimet, alaviiva, tavuviiva ja piste (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Hakemiston nimi ei ole sallittu!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Hakemistoa ei voitu tallentaa, koska sinulla ei ole tarvittavia oikeuksia luoda kasioita (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "Kuva '%s' on tallennettu!";
$l_we_editor["image/*"]["response_publish_ok"] = "Kuva '%s' on julkaistu!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "Kuva '%s' on poistettu julkaisusta!";
$l_we_editor["image/*"]["response_save_notok"] = "Virhe tallennettaessa kuvaa '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "Kuvaa '%s' ei voitu tallentaa, koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Dokumentti '%s' on julkaistu!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Dokumentti '%s' on poistettu julkaisusta!";
$l_we_editor["application/*"]["response_save_notok"] = "Virhe tallennettaessa dokumenttia '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Dokumenttia '%s' ei voitu tallentaa, koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Tallennettaessa tiedostoa '%s' tapahtui virhe! \\nMuut tiedostot -tyyppisen tiedoston pääte ei voi olla '%s'!\\nOle hyvä ja luo HTML-sivu tähän tarkoitukseen!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Flash -tiedosto '%s' on tallennettu!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Flash -tiedosto '%s' on julkaistu!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Flash -tiedosto '%s' on poistettu julkaisusta!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Virhe tallennettaessa Flash -tiedostoa '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Flash -tiedostoa '%s' ei voitu tallentaa, koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Quicktime -tiedosto '%s' on julkaistu!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Quicktime -tiedosto '%s' on poistettu julkaisusta!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Virhe tallennettaessa Quicktime -tiedostoa '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Quicktime -tiedostoa '%s' ei voitu tallentaa koska samanniminen tiedosto tai hakemisto sijaitsee kohteessa!";
$l_we_editor["video/quicktime"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["video/quicktime"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["video/quicktime"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["video/quicktime"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

/*****************************************************************************
 * PLEASE DON'T TOUCH THE NEXT LINES
 * UNLESS YOU KNOW EXACTLY WHAT YOU ARE DOING!
 *****************************************************************************/

$_language_directory = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules";
$_directory = dir($_language_directory);

while (false !== ($entry = $_directory->read())) {
	if (ereg('_we_editor', $entry)) {
		include_once($_language_directory."/".$entry);
	}
}
?>