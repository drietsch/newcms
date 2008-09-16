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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: Dutch
 */
$l_we_editor["doubble_field_alert"] = "Het veld '%s' bestaat al! Een veldnaam moet uniek zijn!";
$l_we_editor["variantNameInvalid"] = "De naam van een artikel variant mag niet leeg zijn!";

$l_we_editor["folder_save_nok_parent_same"] = "De gekozen hoofd directory bevind zich in de eigenlijke directory! Kies a.u.b. een andere directory en probeer het opnieuw!";
$l_we_editor["pfolder_notsave"] = "De directory kan niet bewaard worden in de gekozen directory!";
$l_we_editor["required_field_alert"] = "Het veld '%s' is vereist en moet ingevuld worden!";

$l_we_editor["category"]["response_save_ok"] = "De categorie '%s' is succesvol bewaard!";
$l_we_editor["category"]["response_save_notok"] = "Fout tijdens het bewaren van categorie '%s'!";
$l_we_editor["category"]["response_path_exists"] = "De categorie '%s' kon niet bewaard worden omdat een andere categorie zich op dezelfde plek bevind!";
$l_we_editor["category"]["we_filename_notValid"] = "Ongeldige naam!\\n\", \\' / < > en \\\\ zijn niet toegestaan!";
$l_we_editor["category"]["filename_empty"]       = "De bestandsnaam mag niet leeg zijn.";
$l_we_editor["category"]["name_komma"] = "Ongeldige naam! Een komma is niet toegestaan!";

$l_we_editor["text/webedition"]["response_save_ok"] = "De webEdition pagina '%s' is succesvol bewaard!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "De webEdition pagina '%s' is succesvol gepubliceerd!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Fout tijdens het publiceren van webEdition pagina '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "De webEdition pagina '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Fout tijdens het depubliceren van webEdition pagina '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "De webEdition pagina '%s' is niet gepubliceerd!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Fout tijdens het bewaren van webEdition pagina '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "De webEdition pagina '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/webedition"]["filename_empty"] = "Er is geen naam ingevoerd voor dit document!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Ongeldige bestandsnaam\\nGeldige karakters zijn alfa-numeriek, boven- en onderkast, eveneens als de underscore, koppelteken en punt (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "De bestandsnaam die u heeft ingevoerd is niet toegestaan!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Het document kon niet bewaard worden omdat u niet de juiste rechten heeft om mappen aan te maken (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "De webEdition pagina zal automatisch gepubliceerd worden op %s.";

$l_we_editor["text/html"]["response_save_ok"] = "De HTML pagina '%s' is succesvol bewaard!";
$l_we_editor["text/html"]["response_publish_ok"] = "De HTML pagina '%s' is succesvol gepubliceerd!";
$l_we_editor["text/html"]["response_publish_notok"] = "Fout tijdens het publiceren van HTML pagina '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "De HTML pagina '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Fout tijdens het depubliceren van HTML pagina '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "De HTML pagina '%s' is niet gepubliceerd!";
$l_we_editor["text/html"]["response_save_notok"] = "Fout tijdens het bewaren van HTML pagina '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "De HTML pagina '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Het sjabloon '%s' is succesvol bewaard!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Het sjabloon'%s' is succesvol gepubliceerd!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Het sjabloon '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Fout tijdens het bewaren van sjabloon '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Het sjabloon '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "De stylesheet '%s' is succesvol bewaard!";
$l_we_editor["text/css"]["response_publish_ok"] = "De stylesheet '%s' is succesvol gepubliceerd!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "De stylesheet '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/css"]["response_save_notok"] = "Fout tijdens het bewaren van stylesheet '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "De stylesheet '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "Het JavaScript '%s'is succesvol bewaard!";
$l_we_editor["text/js"]["response_publish_ok"] = "Het JavaScript'%s' is succesvol gepubliceerd!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "Het JavaScript '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/js"]["response_save_notok"] = "Fout tijdens het bewaren van JavaScript '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "Het JavaScript '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "Het tekst bestand '%s' is succesvol bewaard!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Het tekst bestand '%s' is succesvol gepubliceerd!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Het tekst bestand '%s' is succesvol gedepubliceerd!";
$l_we_editor["text/plain"]["response_save_notok"] = "Fout tijdens het bewaren van tekst bestand '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Het tekst bestand '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/xml"]["response_save_ok"] = "Het XML bestand '%s' is succesvol bewaard!";
$l_we_editor["text/xml"]["response_publish_ok"] = "Het XML bestand '%s' is succesvol gepubliceerd!";
$l_we_editor["text/xml"]["response_unpublish_ok"] = "Het XML bestand '%s' is succesvol gedepubliceerd!"; 
$l_we_editor["text/xml"]["response_save_notok"] = "Fout tijdens opslaan van XML bestand '%s'!";
$l_we_editor["text/xml"]["response_path_exists"] = "Het XML bestand '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde locatie bevind!"; 
$l_we_editor["text/xml"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/xml"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/xml"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/xml"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "De directory '%s' is succesvol bewaard!";
$l_we_editor["folder"]["response_publish_ok"] = "De directory '%s' is succesvol gepubliceerd!";
$l_we_editor["folder"]["response_unpublish_ok"] = "De directory '%s' is succesvol gedepubliceerd!";
$l_we_editor["folder"]["response_save_notok"] = "Fout tijdens het bewaren van directory '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "De directory '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["folder"]["filename_empty"] = "Er is geen naam ingevoerd voor deze directory!";
$l_we_editor["folder"]["we_filename_notValid"] = "Ongeldige map naam\\nGeldige karakters zijn alfa-numeriek, boven- en onderkast, eveneens als de underscore, koppelteken en punt (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "De ingevoerde directory naam is niet toegestaan!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "De directory kon niet bewaard worden omdat u niet de juisten rechten heeft om mappen aan te maken (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "De afbeelding '%s' is succesvol bewaard!";
$l_we_editor["image/*"]["response_publish_ok"] = "De afbeelding '%s' is succesvol gepubliceerd!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "De afbeelding '%s' is succesvol gedepubliceerd!";
$l_we_editor["image/*"]["response_save_notok"] = "Fout tijdens het bewaren van afbeelding '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "De afbeelding '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "Het document '%s' is succesvol bewaard!";
$l_we_editor["application/*"]["response_publish_ok"] = "Het document '%s' is succesvol gepubliceerd!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Het document '%s' is succesvol gedepubliceerd!";
$l_we_editor["application/*"]["response_save_notok"] = "Fout tijdens het bewaren van document '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Het document '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Voer a.u.b. een omschrijving in het 'Omschrijving' veld!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Fout tijdens het bewaren van '%s' \\nDe bestands extensie '%s' is niet geldig voor andere bestanden!\\nMaak hier a.u.b. een HTML pagina voor aan!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "De Flash film '%s' is succesvol bewaard!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "De Flash film '%s' is succesvol gepubliceerd!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "De Flash film '%s' is succesvol gedepubliceerd!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Fout tijdens het bewaren van Flash film '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "De Flash film '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "De Quicktime film '%s' is succesvol bewaard!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "De Quicktime film '%s' is succesvol gepubliceerd!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "De Quicktime film '%s' is succesvol gedepubliceerd!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Fout tijdens het bewaren van Quicktime film '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "De Quicktime film '%s' kon niet bewaard worden omdat een ander document of directory zich op dezelfde plek bevind!";
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