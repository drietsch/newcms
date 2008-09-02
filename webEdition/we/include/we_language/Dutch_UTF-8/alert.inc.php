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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["notice"] = "Mededeling";
$l_alert["warning"] = "Waarschuwing";
$l_alert["error"] = "Fout";

$l_alert["noRightsToDelete"] = "\\'%s\\' kan niet verwijderd worden! U bent niet bevoegd om deze actie uit te voeren!";
$l_alert["noRightsToMove"] = "\\'%s\\' kan niet verplaatst worden! U heeft niet de juiste rechten om deze actie uit te voeren!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "Het document moet eerst bewaard worden voordat het in de workflow geplaatst kan worden!\\nWilt u het document nu bewaren?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Het object moet eerst bewaard worden voordat het in de workflow geplaatst kan worden!\\nWilt u het object nu bewaren?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "De class moet eerst bewaard worden voordat deze in de workflow geplaatst kan worden!\\nWilt u de class nu bewaren?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Het sjabloon moet eerst bewaard worden voordat het in de workflow geplaatst kan worden!\\nWilt u het sjabloon nu bewaren?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Het bestand bevindt zich niet in uw werkgebied!";
$l_alert["folder"]["not_im_ws"] = "De map bevindt zich niet in uw werkgebied!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Het sjabloon bevindt zich niet in uw werkgebied!";
$l_alert["delete_recipient"] = "Weet u zeker dat u het geselecteerde e-mail adres wilt verwijderen?";
$l_alert["recipient_exists"] = "Dit e-mail adres bestaat al!";
$l_alert["input_name"] = "Voer een nieuw e-mail adres in!";
$l_alert['input_file_name'] = "Voer een bestandsnaam in.";
$l_alert["max_name_recipient"] = "Een e-mail adres mag slechts 255 karakters bevatten!";
$l_alert["not_entered_recipient"] = "Er is geen e-mail adres ingevoerd!";
$l_alert["recipient_new_name"] = "Wijzig e-mail adres!";
$l_alert["no_new"]["objectFile"] = "U mag geen nieuwe objecten aanmaken!<br>Of u heeft niet de juiste rechten of er is geen classe waar één van uw werkgebieden geldig is!";
$l_alert["required_field_alert"] = "Het veld '%s' is verplicht en moet ingevuld worden!";
$l_alert["phpError"] = "webEdition kan niet opgestart worden!";
$l_alert["3timesLoginError"] = "Het inloggen is %s mislukt! Wacht a.u.b. %s minuten en probeer het opnieuw!";
$l_alert["popupLoginError"] = "Het webEdition venster kon niet geopend worden!\\n\\nwebEdition kan alleen opgestart worden wanneer uw browser geen pop-up vensters blokkeert.";
$l_alert['publish_when_not_saved_message'] = "Het document is nog niet bewaard! Wilt u het toch publiceren?";
$l_alert["template_in_use"] = "Het sjabloon is in gebruik en kan niet verwijderd worden!";
$l_alert["no_cookies"] = "U heeft geen cookies geactiveerd. Activeer a.u.b. de cookies in uw browser!";
$l_alert["doctype_hochkomma"] = "Ongeldige naam! Ongeldige karakters zijn de ' (apostrof) en de , (komma)!";
$l_alert["thumbnail_hochkomma"] = "Ongeldige naam! Ongeldige karakters zijn de ' (apostrof) en de , (komma)!";
$l_alert["can_not_open_file"] = "Het bestand %s kon niet geopend worden!";
$l_alert["no_perms_title"] = "Geen toestemming!";
$l_alert["access_denied"] = "Toegang geweigerd!";
$l_alert["no_perms"] = "Neem a.u.b. contact op met de eigenaar (%s) of een admin<br>als u toegang nodig hebt!";
$l_alert["temporaere_no_access"] = "Toegang niet mogelijk!";
$l_alert["temporaere_no_access_text"] = "Het bestand \"%s\" wordt op dit moment gewijzigd door \"%s\".";
$l_alert["file_locked_footer"] = "Dit document wordt op dit moment gewijzigd door \"%s\".";
$l_alert["file_no_save_footer"] = "U heeft niet de juiste rechten om dit bestand te bewaren.";
$l_alert["login_failed"] = "Verkeerde gebruikersnaam en/of wachtwoord!";
$l_alert["login_failed_security"] = "webEdition kon niet opgestart worden!\\n\\nOm veiligheids redenen is het inlog proces afgebroken, omdat de maximale inlog tijd in webEdition is overschreden!\\n\\nLog a.u.b. opnieuw in.";
$l_alert["perms_no_permissions"] = "U bent niet bevoegd om deze actie uit te voeren!";
$l_alert["no_image"] = "Het bestand dat u hebt geselecteerd is geen afbeelding!";
$l_alert["delete_ok"] = "Bestanden of directories succesvol verwijderd!";
$l_alert["delete_cache_ok"] = "Cache succesvol geleegd!";
$l_alert["nothing_to_delete"] = "Er is niks geselecteerd om te verwijderen!";
$l_alert["delete"] = "Geselecteerde onderdelen verwijderen?\\nWilt u doorgaan?";
$l_alert["delete_cache"] = "Cace legen voor de geselecteerde onderdelen?\\nWilt u doorgaan?";
$l_alert["delete_folder"] = "Geselecteerde directory verwijderen?\\nLet op: Wanneer u een directory verwijderd worden automatisch alle documenten en directories binnen de directory gewist!\\nWilt u doorgaan?";
$l_alert["delete_nok_error"] = "Het bestand '%s' kan niet verwijderd worden.";
$l_alert["delete_nok_file"] = "Het bestand '%s' kan niet verwijderd worden.\\nHet is mogelijk beveiligd tegen schrijven. ";
$l_alert["delete_nok_folder"] = "De directory '%s' kan niet verwijderd worden.\\nHet is mogelijk beveiligd tegen schrijven.";
$l_alert["delete_nok_noexist"] = "Bestand '%s' bestaat niet!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move_exit_open_docs_question"] = "Voordat documenten verplaatst kunnen worden, moeten ze eerst gesloten worden. Alle niet bewaarde wijzigingen zullen verloren gaan tijdens het proces. Het volgende document wordt afgesloten:\\n\\n";
$l_alert["move_exit_open_docs_continue"] = 'Doorgaan?';
$l_alert["move"] = "Geselecteerde items verplaatsen?\\nWilt u verder gaan?";
$l_alert["move_ok"] = "Bestand succesvol verplaatst!";
$l_alert["move_duplicate"] = "Er bevinden zich bestanden met dezelfde naam in de doel directorie!\\nDe bestanden kunnen niet verplaatst worden.";
$l_alert["move_nofolder"] = "De geselecteerde bestanden kunnen niet verplaatst worden.\\nHet is niet mogelijk om directories te verplaatsen.";
$l_alert["move_onlysametype"] = "De geselecteerde objecten kunnen niet verplaatst worden..\\nObjecten kunnen alleen verplaatst worden in hun eigen classdirectorie.";
$l_alert["move_no_dir"] = "Kies a.u.b. een doel directorie!";
$l_alert["document_move_warning"] = "Na het verplaatsen van documenten moeten deze opnieuw opgebouwd worden.<br />Wilt u dit nu doen?";
$l_alert["nothing_to_move"] = "Er is niks gemarkeerd om te verplaatsen!";
$l_alert["move_of_files_failed"] = "Een of meer bestanden konder niet verplaatst worden! Verplaats de bestanden a.u.b. handmatig.\\nHet gaat om de volgende bestanden:\\n%s";
$l_alert["template_save_warning"] = "Dit sjabloon wordt gebruikt door %s gepubliceerde documenten. Moeten deze opnieuw bewaard worden? Attentie: Dit kan enige tijd duren als het om veel documenten gaat!";
$l_alert["template_save_warning1"] = "Dit sjabloon wordt gebruikt door één gepubliceerd document. Moet deze opnieuw bewaard worden?";
$l_alert["template_save_warning2"] = "Dit sjabloon wordt gebruikt door andere sjablonen en documenten, moeten deze opnieuw bewaard worden?";
$l_alert["thumbnail_exists"] = 'Deze thumbnail bestaat al!';
$l_alert["thumbnail_not_exists"] = 'Deze thumbnail bestaat niet!';
$l_alert["doctype_exists"] = "Dit document type bestaat al!";
$l_alert["doctype_empty"] = "U moet een naam invoeren voor het nieuwe document type!";
$l_alert["delete_cat"] = "Weet u zeker dat u de geselecteerde categorie wilt verwijderen?";
$l_alert["delete_cat_used"] = "Deze category is in gebruik en kan niet verwijderd worden!";
$l_alert["cat_exists"] = "Die categorie bestaal al!";
$l_alert["cat_changed"] = "De categorie is in gebruik! Bewaar de documenten opnieuw die gebruik maken van de categorie!\\nMoet de categorie toch gewijzigd worden?";
$l_alert["max_name_cat"] = "Een categorienaam mag slechts 32 karakters bevatten!";
$l_alert["not_entered_cat"] = "Er is geen categorienaam ingevoerd!";
$l_alert["cat_new_name"] = "Voer de nieuwe categorienaam in!";
$l_alert["we_backup_import_upload_err"] = "Er is een fout opgetreden tijdens het uploaden van het backup bestand! De maximale bestandsgrootte voor uploads is %s. Als uw backup bestand de limiet overschrijdt, upload het dan a.u.b. in de directory webEdition/we_Backup via FTP en kies '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "Er zijn geen documenten die passen bij de geselecteerde attributen.";
$l_alert["we_name_not_allowed"] = "De termen 'we' en 'webEdition' zijn gereserveerde woorden en mogen niet gebruikt worden!";
$l_alert["we_filename_empty"] = "Er is geen naam ingevoerd voor dit document of directory!";
$l_alert["exit_multi_doc_question"] = "Meerdere geopende documenten bevatten niet bewaarde wijzigingen. Als u doorgaat gaan alle wijzigingen verloren. Wilt u doorgaan en de wijzigingen negeren?";
$l_alert["exit_doc_question_".FILE_TABLE] = "Het document is gewijzigd.<BR> Wilt u de wijzigingen bewaren?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Het sjabloon is gewijzigd.<BR> Wilt u de wijzigingen bewaren?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "De classe is gewijzigd.<BR> Wilt u de wijzigingen bewaren?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Het object is gewijzigd.<BR> Wilt u de wijzigingen bewaren?";
}
$l_alert["deleteTempl_notok_used"] = "Eén of meerdere sjablonen zijn in gebruik en konden niet verwijderd worden!";
$l_alert["deleteClass_notok_used"] = "One or more of the classes are in use and could not be deleted!"; // TRANSLATE
$l_alert["delete_notok"] = "Fout tijdens het verwijderen!";
$l_alert["nothing_to_save"] = "De bewaar functie is uitgeschakeld op dit moment!";
$l_alert["nothing_to_publish"] = "De publiceer functie is op dit moment uitgeschakeld!";
$l_alert["we_filename_notValid"] = "Invalid filename\\nValid characters are alpha-numeric, upper and lower case, as well as underscore, hyphen and dot (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "De geselecteerde afbeelding is leeg.\\n Doorgaan?";
$l_alert["path_exists"] = "Het bestand of document %s  kan niet bewaard worden omdat een ander document zich al op deze plek bevind!";
$l_alert["folder_not_empty"] = "Eén of meerdere directories zijn niet geheel leeg en kunnen daardoor niet verwijderd worden! Wis de bestanden handmatig.\\n Het gaat om de volgende bestanden:\\n%s";
$l_alert["name_nok"] = "De namen moeten karakters bevatten als '<' of '>'!";
$l_alert["found_in_workflow"] = "Eén of meerdere geselecteerde invoeren zitten in het worklfow proces! Wilt u ze uit het workflow proces halen?";
$l_alert["import_we_dirs"] = "U probeert vanuit een webEdition directory te importeren!\\n Die directories worden gebruikt en beschermd door webEdition en kunnen daardoor niet gebruikt worden voor import!";
$l_alert["wrong_file"]["image/*"] = "Het bestand kon niet opgeslagen worden. Of het is geen afbeelding of uw server is vol!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Het bestand kon niet opgeslagen worden. Of het is geen Flash film of uw schijf is vol!";
$l_alert["wrong_file"]["video/quicktime"] = "Het bestand kon niet opgeslagen worden. Of het is geen Quicktime film of uw schijf is vol!";
$l_alert["no_file_selected"] = "Er is geen bestand gekozen voor upload!";
$l_alert["browser_crashed"] = "Het venster kon niet geopend worden vanwege een fout in uw browser!  Sla a.u.b. uw werk op en herstart de browser.";
$l_alert["copy_folders_no_id"] = "Bewaar a.u.b. eerst de huidige directory!";
$l_alert["copy_folder_not_valid"] =  "Dezelfde directory of één van de hoofd directories kon niet gekopiëerd worden!";
$l_alert['no_views']['headline'] = 'Attentie';
$l_alert['no_views']['description'] = 'Er is geen weergave beschikbaar voor dit document.';
$l_alert['navigation']['last_document'] = 'U wijzigt het laatste document.';
$l_alert['navigation']['first_document'] = 'U wijzigt het eerste document.';
$l_alert['navigation']['doc_not_found'] = 'Kon geen bijpassend document vinden.';
$l_alert['navigation']['no_entry'] = 'Geen invoer gevonden in geschiedenis.';
$l_alert['navigation']['no_open_document'] = 'Er is geen geopend document.'; 
$l_alert['delete_single']['confirm_delete'] = 'Dit document verwijderen?';
$l_alert['delete_single']['no_delete'] = 'Dit document kon niet verwijderd worden.';
$l_alert['delete_single']['return_to_start'] = 'Het document is verwijderd. \\nTerug naar seeModus startdocument.';
$l_alert['move_single']['return_to_start'] = 'Het document is verplaatst. \\nTerug naar het seeMode startdocument.';
$l_alert['move_single']['no_delete'] = 'Dit document kon niet verplaatst worden';
$l_alert['cockpit_not_activated'] = 'Deze actie kon niet uitgevoerd worden omdat de cockpit niet geactiveerd is.';
$l_alert['cockpit_reset_settings'] = 'Weet u zeker dat u de huidige cockpit instellingen wilt verwijderen en de standaard instellingen terug wilt zetten?';
$l_alert['save_error_fields_value_not_valid'] = 'De uitgelichte velden bevatten ongeldige data.\\nVoer a.u.b. geldige data in.';

$l_alert['eplugin_exit_doc'] = "Het document is gewijzigd met een externe editor. De verbinding tussen webEdition en de externe editor wordt afgesloten en wordt niet meer gesynchroniseerd.\\nWilt u het document sluiten?";

$l_alert['delete_workspace_user'] = "De directory %s kon niet verwijderd worden! Deze is gedefinieerd als werkgebied voor de volgende gebruikers of groepen:\\n%s";
$l_alert['delete_workspace_user_r'] = "De directory %s kon niet verwijderd worden! Binnen deze directory bevinden zich andere directories die zijn gedefinieerd als werkgebied voor de volgende gebruikers of groepen:\\n%s";
$l_alert['delete_workspace_object'] = "De directory %s kon niet verwijderd worden! Deze is gedefinieerd als werkgebied in de volgende objecten:\\n%s";
$l_alert['delete_workspace_object_r'] = "De directory %s kon niet verwijderd worden! Binnen deze directory bevinden zich andere directories die zijn gedefinieerd als werkgebied in de volgende objecten:\\n%s";


$l_alert['field_contains_incorrect_chars'] = "Een veld (van het type %s) bevat ongeldige karakters.";
$l_alert['field_input_contains_incorrect_length'] = "De maximale lengte van een veld met het type \'Text input\' is 255 karakters. Indien u meer karakters nodig hebt, maak dan gebruik van het veld met het type \'Textarea\'.";
$l_alert['field_int_contains_incorrect_length'] = "De maximale lengte van een veld met het type \'Integer\' is 10 karakters."; 
$l_alert['field_int_value_to_height'] = "De maximale waarde van een veld met het type \'Integer\' is 2147483647.";


$l_alert["we_filename_notValid"] = "Ongeldige bestandsnaam\\nGeldige karakters zijn alfa-numeriek, boven- en onderkast, evenals de underscore, koppelteken en punt (a-z, A-Z, 0-9, _, -, .)";
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';

$l_alert["login_denied_for_user"] = "The user cannot login. The user access is disabled.";
$l_alert["no_perm_to_delete_single_document"] = "You have not the needed permissions to delete the active document.";

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "The document has been moved to a folder with divergent customer account policies. Should the settings of the folder be transmitted to this document?";
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "The directory has been moved to a folder with divergent customers account policies. Should the settings be adopted for this directory and all subelements? ";

$l_alert['field_in_tab_notvalid_pre'] = "The settings could not be saved, because the following fields contain invalid values:"; // translate
$l_alert['field_in_tab_notvalid'] = ' - field %s on tab %s';
$l_alert['field_in_tab_notvalid_post'] = 'Correct the fields before saving the settings.'; 
$l_alert['discard_changed_data'] = 'There are unsaved changes that will be discarded. Are you sure?';
?>