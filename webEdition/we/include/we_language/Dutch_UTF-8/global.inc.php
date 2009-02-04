<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "Nieuwe koppeling"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Data wordt geladen!<br>Dit kan enige tijd duren wanneer meerdere menu elementen geladen worden ...";
$GLOBALS["l_global"]["text"] = "Tekst";
$GLOBALS["l_global"]["yes"] = "Ja";
$GLOBALS["l_global"]["no"] = "Nee";
$GLOBALS["l_global"]["checked"] = "Gemarkeerd";
$GLOBALS["l_global"]["max_file_size"] = "Maximale bestandsgrootte (in bytes)";
$GLOBALS["l_global"]["default"] = "Standaard";
$GLOBALS["l_global"]["values"] = "Waardes";
$GLOBALS["l_global"]["name"] = "Naam";
$GLOBALS["l_global"]["type"] = "Type"; // TRANSLATE
$GLOBALS["l_global"]["attributes"] = "Attributen";
$GLOBALS["l_global"]["formmailerror"] = "Het mailformulier was niet voorgelegd om de volgende reden:";
$GLOBALS["l_global"]["email_notallfields"] = "U heeft niet alle vereiste velden ingevuld!";
$GLOBALS["l_global"]["email_ban"] = "U heeft niet de juiste rechten om dit script te gebruiken!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Het adres van de ontvanger(s) is ongeldig!";
$GLOBALS["l_global"]["email_no_recipient"] = "Het adres van de ontvanger(s) bestaat niet!";
$GLOBALS["l_global"]["email_invalid"] = "Uw <b>E-mail adres</b> is ongeldig!";
$GLOBALS["l_global"]["captcha_invalid"] = "The entered security code is wrong!"; // TRANSLATE
$GLOBALS["l_global"]["question"] = "Vraag";
$GLOBALS["l_global"]["warning"] = "Waarschuwing";
$GLOBALS["l_global"]["we_alert"] = "Deze functie is niet beschikbaar in de demo-versie van webEdition!";
$GLOBALS["l_global"]["index_table"] = "Index tabel";
$GLOBALS["l_global"]["cannotconnect"] = "Kan niet verbinden met de webEdition server!";
$GLOBALS["l_global"]["recipients"] = "Formmail ontvangers";
$GLOBALS["l_global"]["recipients_txt"] = "Voer a.u.b. alle E-mail adressen in die formulieren moeten ontvangen d.m.v. de mailformulier functie (&lt;we:form type=&quot;formmail&quot; ..&gt;). Als u geen E-mail adres invoert, kunt u geen formulieren verzenden met de mailformulier functie!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Nieuw object %s of class %s aangemaakt!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Nieuw object";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Nieuw document";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Nieuw document %s aangemaakt!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Object verwijderd";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Het object %s is verwijderd!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Document verwijderd";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Het document %s is verwijderd!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Nieuwe pagina na bewaren";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Geen invoeren gevonden!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Bewaar tijdelijke documenten opnieuw";
$GLOBALS["l_global"]["save_mainTable"] = "Bewaar hoofd database-tabel opnieuw";
$GLOBALS["l_global"]["add_workspace"] = "Voeg werkgebied toe";
$GLOBALS["l_global"]["folder_not_editable"] = "Deze directory kan niet gekozen worden!";
$GLOBALS["l_global"]["modules"] = "Modules"; // TRANSLATE
$GLOBALS["l_global"]["modules_and_tools"] = "Modules en Tools";
$GLOBALS["l_global"]["center"] = "Centreer";
$GLOBALS["l_global"]["jswin"] = "Pop-up venster";
$GLOBALS["l_global"]["open"] = "Open"; // TRANSLATE
$GLOBALS["l_global"]["posx"] = "x positie";
$GLOBALS["l_global"]["posy"] = "y positie";
$GLOBALS["l_global"]["status"] = "Status"; // TRANSLATE
$GLOBALS["l_global"]["scrollbars"] = "Scroll balken";
$GLOBALS["l_global"]["menubar"] = "Menu balk";
$GLOBALS["l_global"]["toolbar"] = "Gereedschappen balk";
$GLOBALS["l_global"]["resizable"] = "Schaalbaar";
$GLOBALS["l_global"]["location"] = "Locatie";
$GLOBALS["l_global"]["title"] = "Titel";
$GLOBALS["l_global"]["description"] = "Omschrijving";
$GLOBALS["l_global"]["required_field"] = "Vereist veld";
$GLOBALS["l_global"]["from"] = "Van";
$GLOBALS["l_global"]["to"] = "Naar";
$GLOBALS["l_global"]["search"]="Zoek";
$GLOBALS["l_global"]["in"]="in"; // TRANSLATE
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Automatisch heropbouwen";
$GLOBALS["l_global"]["we_publish_at_save"] = "Publiceren na bewaren";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "Nieuw document na bewaren";
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving"; // TRANSLATE
$GLOBALS["l_global"]["wrapcheck"] = "Wrapping"; // TRANSLATE
$GLOBALS["l_global"]["static_docs"] = "Statische documenten";
$GLOBALS["l_global"]["save_templates_before"] = "Bewaar sjablonen vooraf";
$GLOBALS["l_global"]["specify_docs"] = "Documenten met de volgende criteria";
$GLOBALS["l_global"]["object_docs"] = "Alle objecten";
$GLOBALS["l_global"]["all_docs"] = "Alle documenten";
$GLOBALS["l_global"]["ask_for_editor"] = "Vraag naar editor";
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Introductie";
$GLOBALS["l_global"]["doctypes"] = "Document types"; // TRANSLATE
$GLOBALS["l_global"]["content"] = "Inhoud";
$GLOBALS["l_global"]["site_not_exist"] = "Pagina bestaat niet!";
$GLOBALS["l_global"]["site_not_published"] = "Pagina is nog niet gepubliceerd!";
$GLOBALS["l_global"]["required"] = "Invoer vereist";
$GLOBALS["l_global"]["all_rights_reserved"] = "Alle rechten voorbehouden";
$GLOBALS["l_global"]["width"] = "Breedte";
$GLOBALS["l_global"]["height"] = "Hoogte";
$GLOBALS["l_global"]["new_username"] = "Nieuwe gebruikersnaam";
$GLOBALS["l_global"]["username"] = "Gebruikersnaam";
$GLOBALS["l_global"]["password"] = "Wachtwoord";
$GLOBALS["l_global"]["documents"] = "Documenten";
$GLOBALS["l_global"]["templates"] = "Sjablonen";
$GLOBALS["l_global"]["objects"] = "Objecten";
$GLOBALS["l_global"]["licensed_to"] = "Licentie";
$GLOBALS["l_global"]["left"] = "Links";
$GLOBALS["l_global"]["right"] = "Rechts";
$GLOBALS["l_global"]["top"] = "Boven";
$GLOBALS["l_global"]["bottom"] = "Onder";
$GLOBALS["l_global"]["topleft"] = "Links boven";
$GLOBALS["l_global"]["topright"] = "Rechts boven";
$GLOBALS["l_global"]["bottomleft"] = "Links onder";
$GLOBALS["l_global"]["bottomright"] = "Rechts onder";
$GLOBALS["l_global"]["true"] = "Ja";
$GLOBALS["l_global"]["false"] = "Nee";
$GLOBALS["l_global"]["showall"] = "Toon alles";
$GLOBALS["l_global"]["noborder"] = "Geen rand";
$GLOBALS["l_global"]["border"] = "Rand";
$GLOBALS["l_global"]["align"] = "Uitlijning";
$GLOBALS["l_global"]["hspace"] = "Hspace"; // TRANSLATE
$GLOBALS["l_global"]["vspace"] = "Vspace"; // TRANSLATE
$GLOBALS["l_global"]["exactfit"] = "Exact passend";
$GLOBALS["l_global"]["select_color"] = "Selecteer kleur";
$GLOBALS["l_global"]["changeUsername"] = "Wijzig gebruikersnaam";
$GLOBALS["l_global"]["changePass"] = "Wijzig wachtwoord";
$GLOBALS["l_global"]["oldPass"] = "Oud wachtwoord";
$GLOBALS["l_global"]["newPass"] = "Nieuw wachtwoord";
$GLOBALS["l_global"]["newPass2"] = "Herhaal nieuwe wachtwoord";
$GLOBALS["l_global"]["pass_not_confirmed"] = "De invoeren komen niet overeen!";
$GLOBALS["l_global"]["pass_not_match"] = "Oude wachtwoord niet correct!";
$GLOBALS["l_global"]["passwd_not_match"] = "De wachtwoorden komen niet overeen!";
$GLOBALS["l_global"]["pass_to_short"] = "Wachtwoorden moeten minimaal 4 karakters bevatten!";
$GLOBALS["l_global"]["pass_changed"] = "Wachtwoord succesvol gewijzigd!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Wachtwoorden mogen alleen alfa-numerieke karakters bevatten (a-z, A-Z and 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "De gebruikersbaam mag alleen alfa-numerieke karakters bevatten (a-z, A-Z en 0-9) en '.', '_' of '-'!";
$GLOBALS["l_global"]["all"] = "Alle";
$GLOBALS["l_global"]["selected"] = "Geselecteerde";
$GLOBALS["l_global"]["username_to_short"] = "De gebruikersnaam moet minimaal 4 karakters bevatten!";
$GLOBALS["l_global"]["username_changed"] = "Gebruikersnaam succesvol gewijzigd!";
$GLOBALS["l_global"]["published"] = "Gepubliceerd";
$GLOBALS["l_global"]["help_welcome"] = "Welkom bij webEdition Help";
$GLOBALS["l_global"]["edit_file"] = "Wijzig bestand";
$GLOBALS["l_global"]["docs_saved"] = "Documenten succesvol bewaard!";
$GLOBALS["l_global"]["preview"] = "Voorvertoning";
$GLOBALS["l_global"]["close"] = "Sluit venster";
$GLOBALS["l_global"]["loginok"] =  "<strong>Login ok! Even geduld a.u.b.!</strong><br>webEdition opent in een nieuw venster. Wanneer dit venster niet opent, zorg er dan voor dat u geen pop-up vensters blokkeert in uw browser!";
$GLOBALS["l_global"]["apple"] = "APPLE";
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "Vereiste velden";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Op dit moment wordt er geen document ge-upload.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Open/Sluit";
$GLOBALS["l_global"]["rebuild"] = "Heropbouwen";
$GLOBALS["l_global"]["welcome_to_we"] = "Welkom bij webEdition 4";
$GLOBALS["l_global"]["tofit"] = "Welkom bij webEdition 4";
$GLOBALS["l_global"]["unlocking_document"] = "Document ontgrendelen";
$GLOBALS["l_global"]["variant_field"] = "Variant veld";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Klik a.u.b. op de volgende koppeling, indien u niet doorgestuurd word binnen 30 seconden ";
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition inlog";
$GLOBALS["l_global"]["untitled"] = "Untitled"; // TRANSLATE
$GLOBALS["l_global"]["no_document_opened"] = "There is no document opened!"; // TRANSLATE
?>