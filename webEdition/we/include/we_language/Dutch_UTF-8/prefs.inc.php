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
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Bezig met laden van voorkeuren, even geduld a.u.b. ...";
$l_prefs["preload_wait"] = "Bezig met laden van voorkeuren";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Bezig met bewaren van voorkeuren, even geduld a.u.b. ...";
$l_prefs["save_wait"] = "Bezig met bewaren van voorkeuren";

$l_prefs["saved"] = "Voorkeuren zijn succesvol bewaard.";
$l_prefs["saved_successfully"] = "Voorkeuren zijn bewaard";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Gebruikers-interface";
$l_prefs["tab_glossary"] = "Verklarende woordenlijst";
$l_prefs["tab_extensions"] = "Bestands-extensies";
$l_prefs["tab_editor"] = 'Editor'; // TRANSLATE
$l_prefs["tab_formmail"] = 'Mailformulier';
$l_prefs["formmail_recipients"] = 'Mailformulier ontvangers';
$l_prefs["tab_proxy"] = 'Proxy-Server';
$l_prefs["tab_advanced"] = 'Geavanceerd';
$l_prefs["tab_system"] = 'Systeem';
$l_prefs["tab_error_handling"] = 'Fout afhandeling';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_cache"] = 'Cache'; // TRANSLATE
$l_prefs["tab_language"] = 'Talen';
$l_prefs["tab_modules"] = 'Modules'; // TRANSLATE
$l_prefs["tab_versions"] = 'Versioning'; // TRANSLATE

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Taal";
	$l_prefs["language_notice"] = "Het wisselen van taal wordt pas zichtbaar na het opnieuw inloggen in webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeModus";
	$l_prefs["seem_deactivate"] = "Deactiveer seeMode";
	$l_prefs["seem_startdocument"] = "seeMode startdocument";
	$l_prefs["seem_start_type_document"] = "Document"; // TRANSLATE
	$l_prefs["seem_start_type_object"] = "Object"; // TRANSLATE
	$l_prefs["seem_start_type_cockpit"] = "Cockpit"; // TRANSLATE
	$l_prefs["question_change_to_seem_start"] = "Wilt u het geselecteerde document wijzigen?";


	/**
	 * Sidebar
	 */
	$l_prefs["sidebar"] = "Sidebar"; // TRANSLATE
	$l_prefs["sidebar_deactivate"] = "deactivateer";
	$l_prefs["sidebar_show_on_startup"] = "toon bij opstarten";
	$l_prefs["sidebar_width"] = "Breedte in pixels";
	$l_prefs["sidebar_document"] = "Document"; // TRANSLATE


	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Schermdimensie";
	$l_prefs["maximize"] = "Maximaliseer";
	$l_prefs["specify"] = "Specificeer";
	$l_prefs["width"] = "Breedte";
	$l_prefs["height"] = "Hoogte";
	$l_prefs["predefined"] = "Vooraf bepaalde dimensies";
	$l_prefs["show_predefined"] = "Toon vooraf bepaalde dimensies";
	$l_prefs["hide_predefined"] = "Verberg vooraf bepaalde dimensies";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Boomstructuur";
	$l_prefs["all"] = "Alles";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */
	$l_prefs["extensions_information"] = "Stel hier de standaard extensie voor statische en dynamische pagina's in.";
	
	$l_prefs["we_extensions"] = "webEdition extensies";
	$l_prefs["static"] = "Statische pagina's";
	$l_prefs["dynamic"] = "Dynamische pagina's";
	$l_prefs["html_extensions"] = "HTML extensies";
	$l_prefs["html"] = "HTML pagina's";
	
/*****************************************************************************
 * Glossary
 *****************************************************************************/

	$l_prefs["glossary_publishing"] = "Controleer voor publiceren";
	$l_prefs["force_glossary_check"] = "Forceer controle verklarende woordenlijst";
	$l_prefs["force_glossary_action"] = "Forceer actie";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Kolommen in de cockpit ";


/*****************************************************************************
 * CACHING
 *****************************************************************************/

	/**
	 * Cache Type
	 */
	$l_prefs["cache_information"] = "Stel vooraf de waarden van de velden \"Caching Type\" en \"Cache levensduur in seconden\" voor nieuwe sjablonen hier in.<br /><br />Let er wel op dat deze instellingen alleen de voorkeur zijn voor de velden.";
	$l_prefs["cache_navigation_information"] = "Voer hier de standaard waarden in voor de &lt;we:navigation&gt;. De waarde kan overcshreven worden door het attribuut \"cachelifetime\" van de &lt;we:navigation&gt; tag.";
	
	$l_prefs["cache_presettings"] = "Vooraf instellen";
	$l_prefs["cache_type"] = "Caching Type"; // TRANSLATE
	$l_prefs["cache_type_none"] = "Caching uitgeschakeld";
	$l_prefs["cache_type_full"] = "Volledige cache";
	$l_prefs["cache_type_document"] = "Document cache"; // TRANSLATE
	$l_prefs["cache_type_wetag"] = "we:Tag cache"; // TRANSLATE

	/**
	 * Cache Life Time
	 */
	$l_prefs["cache_lifetime"] = "Cache levensduur in seconden";

	$l_prefs['cache_lifetimes'] = array();
	$l_prefs['cache_lifetimes'][0] = "";
	$l_prefs['cache_lifetimes'][60] = "1 minuut";
	$l_prefs['cache_lifetimes'][300] = "5 minuten";
	$l_prefs['cache_lifetimes'][600] = "10 minuten";
	$l_prefs['cache_lifetimes'][1800] = "30 minuten";
	$l_prefs['cache_lifetimes'][3600] = "1 uur";
	$l_prefs['cache_lifetimes'][21600] = "6 uur";
	$l_prefs['cache_lifetimes'][43200] = "12 uur";
	$l_prefs['cache_lifetimes'][86400] = "1 dag";

	$l_prefs['delete_cache_after'] = 'Cache legen na';
	$l_prefs['delete_cache_add'] = 'Nieuwe invoer toevoegen';
	$l_prefs['delete_cache_edit'] = 'Invoer wijzigen';
	$l_prefs['delete_cache_delete'] = 'Invoer verwijderen';
	$l_prefs['cache_navigation'] = 'Standaard instellingen';
	$l_prefs['default_cache_lifetime'] = 'Standaard cache levensduur';


/*****************************************************************************
 * LOCALES // LANGUAGES
 *****************************************************************************/

	/**
	 * Languages
	 */
	$l_prefs["locale_information"] = "Voeg alle talen toe die u wilt gebruiken.<br /><br />Deze voorkeur wordt gebruikt voor de woordenlijst controle en de spellingscontrole.";

	$l_prefs["locale_languages"] = "Taal";
	$l_prefs["locale_countries"] = "Land";
	$l_prefs["locale_add"] = "Voeg taal toe";
	$l_prefs['cannot_delete_default_language'] = "De standaard taal kon niet verwijderd worden.";
	$l_prefs["language_already_exists"] = "Deze taal bestaat al";
	$l_prefs["add_dictionary_question"] = "Wilt u het woordenboek voor deze taal uploaden?";

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = 'Editor PlugIn'; // TRANSLATE
	$l_prefs["use_it"] = "Gebruik";
	$l_prefs["start_automatic"] = "Start automatisch";
	$l_prefs["ask_at_start"] = 'Vraag bij opstart welke<br>editor er gebruikt moet worden';
	$l_prefs["must_register"] = 'Moet registreerd zijn';
	$l_prefs["change_only_in_ie"] = 'Deze instellingen kunnen niet gewijzigd worden. De Editor PlugIn werkt alleen met de Windows versie van Internet Explorer, Mozilla, Firebird evenals Firefox.';
	$l_prefs["install_plugin"] = 'Om de Editor PlugIn te kunnen gebruiken moet de Mozilla ActiveX PlugIn geïnstalleerd zijn.';
	$l_prefs["confirm_install_plugin"] = 'De Mozilla ActiveX PlugIn maakt het mogelijk om ActiveX controls te draaien in Mozilla browsers. Na de installatie moet u uw browser herstarten.\\n\\nLet op: ActiveX kan een veiligheids risico met zich meebrengen!\\n\\nVerder gaan met installeren?';

	$l_prefs["install_editor_plugin"] = 'Om gebruik te kunnen maken van de webEdition Editor PlugIn, moet deze geïnstalleerd zijn.';
	$l_prefs["install_editor_plugin_text"]= 'De webEdition Editor Plugin wordt geïnstalleerd...';

	/**
	 * TEMPLATE EDITOR
	 */
	
	$l_prefs["editor_information"] = "Specificeer lettertype en grootte die gebruikt moet worden bij het wijzigen van sjablonen, CSS- en Java Script bestanden binnen webEdition.<br /><br />Deze instellingen worden gebruikt voor de tekst editor van de bovengenoemde bestands types.";
	
	$l_prefs["editor_font"] = 'Lettertype in editor';
	$l_prefs["editor_fontname"] = 'Fontnaam';
	$l_prefs["editor_fontsize"] = 'Grootte';
	$l_prefs["editor_dimension"] = 'Editor dimensie';
	$l_prefs["editor_dimension_normal"] = 'Standaard';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Voer a.u.b. alle E-mail adressen in, welke formulieren moeten ontvangen verstuurd door de formmail functie (&lt;we:form type=\"formmail\" ..&gt;).<br><br>Als u geen E-Mail adres invoert, kunt u geen formulieren verzenden met de formmail functie!";

	$l_prefs["formmail_log"] = "Formmail log"; // TRANSLATE
	$l_prefs['log_is_empty'] = "De log is leeg!";
	$l_prefs['ip_address'] = "IP adres";
	$l_prefs['blocked_until'] = "Geblokkeerd tot";
	$l_prefs['unblock'] = "Deblokkeer";
	$l_prefs['clear_log_question'] = "Weet u zeker dat u de log wilt wissen?";
	$l_prefs['clear_block_entry_question'] = "Weet u zeker dat u de IP %s wilt deblokkeren?";
	$l_prefs["forever"] = "Altijd";
	$l_prefs["yes"] = "ja";
	$l_prefs["no"] = "nee";
	$l_prefs["on"] = "aan";
	$l_prefs["off"] = "uit";
	$l_prefs["formmailConfirm"] = "Formmail bevestigings functie";
	$l_prefs["logFormmailRequests"] = "Log formmail aanvragen";
	$l_prefs["deleteEntriesOlder"] = "Verwijder invoeren ouder dan";
	$l_prefs["blockFormmail"] = "Beperk formmail aanvragen";
	$l_prefs["formmailSpan"] = "Binnen een tijdspanne van";
	$l_prefs["formmailTrials"] = "Aanvragen toegestaan";
	$l_prefs["blockFor"] = "Blokkeer voor";
	$l_prefs["formmailViaWeDoc"] = "Call formmail via webEdition-Dokument."; // TRANSLATE
	$l_prefs["never"] = "nooit";
	$l_prefs["1_day"] = "1 dag";
	$l_prefs["more_days"] = "%s dagen";
	$l_prefs["1_week"] = "1 week"; // TRANSLATE
	$l_prefs["more_weeks"] = "%s weken";
	$l_prefs["1_year"] = "1 year"; // TRANSLATE
	$l_prefs["more_years"] = "%s years"; // TRANSLATE
	$l_prefs["1_minute"] = "1 minuut";
	$l_prefs["more_minutes"] = "%s minuten";
	$l_prefs["1_hour"] = "1 uur";
	$l_prefs["more_hours"] = "%s uren";
	$l_prefs["ever"] = "altijd";





/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["proxy_information"] = "Specificeer hier uw Proxy instellingen voor uw server, indien uw server een proxy gebruikt voor verbinding met het internet.";
	
	$l_prefs["useproxy"] = "Gebruik proxy-server voor<br>Live-Update";
	$l_prefs["proxyaddr"] = "Adres";
	$l_prefs["proxyport"] = "Poort";
	$l_prefs["proxyuser"] = "Gebruikersnaam";
	$l_prefs["proxypass"] = "Wachtwoord";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Standaard instellingen voor<br><em>php</em>-attribuut in we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Standaard waarde voor het<br><em>inlineedit</em> attribuut in<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Wijzig tekstvelden binnen het document (<em>true</em>) of in een nieuw<br />browser venster (<em>false</em>)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Gebruik Safari Wysiwyg<br>editor (beta versie)";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Standaard waarde voor de<br><em>showinputs</em> attribuut in<br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Type database<br>connecties";
	$l_prefs["db_set_charset"] = "Connection charset"; // TRANSLATE
	
	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "HTTP authenticatie";
	$l_prefs["useauth"] = "Server gebruikt HTTP<br>authenticatie in de webEdition<br>directory";
	$l_prefs["authuser"] = "Gebruikersnaam";
	$l_prefs["authpass"] = "Wachtwoord";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directorie";

	$l_prefs["pagelogger_dir"] = "pageLogger directorie";
	
	/**
	 * HOOKS
	 */
	$l_prefs["hooks"] = "Hooks"; // TRANSLATE //TRANSLATE
	$l_prefs["hooks_information"] = "The use of hooks allows for the execution of arbitrary any PHP code during storing, publishing, unpublishing and deleting of any content type in webEdition.<br/>
	Further information can be found in the online documentation.<br/><br/>Allow execution of hooks?"; 

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Foutmeldingspagina voor niet bestaande objecten';

	/**
	 * TEMPLATE TAG CHECK
	 */

	$l_prefs["templates"] = "Sjablonen";
	$l_prefs["disable_template_tag_check"] = "Deactivateer controle voor ontbrekende,<br />sluit we:tags";

	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "Gebruik de webEdition foutbehandelaar";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Behandel deze fouten";
	$l_prefs["error_notices"] = "Notities";
	$l_prefs["error_warnings"] = "Waarschuwingen";
	$l_prefs["error_errors"] = "Fouten";

	$l_prefs["error_notices_warning"] = 'Optie voor ontwikkelaars! Niet activeren op live-systemen.';

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Weergave van fouten";
	$l_prefs["error_display"] = "Toon fouten";
	$l_prefs["error_log"] = "Log fouten";
	$l_prefs["error_mail"] = "Verzend een mail";
	$l_prefs["error_mail_address"] = "Adres";
	$l_prefs["error_mail_not_saved"] = 'Fouten worden niet verstuurd naar het aangegeven e-mail adres omdat het adres niet correct is!\n\nDe overige voorkeuren zijn succesvol bewaard.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Toon expert instellingen";
	$l_prefs["hide_expert"] = "Verberg expert instellingen";
	$l_prefs["show_debug_frame"] = "Toon debug frame";
	$l_prefs["debug_normal"] = "In normale modus";
	$l_prefs["debug_seem"] = "In seeModus";
	$l_prefs["debug_restart"] = "Veranderingen vereisen een herstart";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "Database/Object module";
	$l_prefs["tree_count"] = "Aantal getoonde objecten";
	$l_prefs["tree_count_description"] = "Deze waarde defineert het maximum aantal onderdelen getoond in de linker navigatie.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Backup"; // TRANSLATE
	$l_prefs["backup_slow"] = "Langzaam";
	$l_prefs["backup_fast"] = "Snel";
	$l_prefs["performance"] = "Hier kunt u een gewenst prestatie niveau instellen. Het prestatie niveau moet bij het server systeem passen. Als het systeem beperkte hulpmiddelen bevat (geheugen, timeout etc.) kies dan een langzaam niveau, zoniet kies dan een snel niveau.";
	$l_prefs["backup_auto"]="Auto"; // TRANSLATE

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Validatie';
	$l_prefs['xhtml_default'] = 'Standaard waarde voor het attribuut <em>xml</em> in we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'De XHTML debugging ondersteunt u in het ontwikkelen van een geldige xhtml web-site. De output van elke we:Tag wordt gecontroleerd op geldigheid en verkeerd geplaatste attributen kunnen verplaatst of verwijderd worden. Let op: Dit kan enige tijd duren. Daarom zou u xhtml debugging alleen moeten activeren tijdens het ontwikkelen van uw web-site.';
	$l_prefs['xhtml_debug_headline'] = 'XHTML debugging'; // TRANSLATE
	$l_prefs['xhtml_debug_html'] = 'Activeer XHTML debugging';
	$l_prefs['xhtml_remove_wrong'] = 'Verwijder ongeldige attributen';
	$l_prefs['xhtml_show_wrong_headline'] = 'Notificatie van ongeldige attributen';
	$l_prefs['xhtml_show_wrong_html'] = 'Activateer';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Als tekst';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Als JavaScript-Melding';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'In de fouten log (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Max Upload Grootte<br>weergave in hints";
	$l_prefs["we_max_upload_size_hint"]="(in MByte, 0=automatisch)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Toegangsrechten voor <br>nieuwe directories";
	$l_prefs["we_new_folder_mod_hint"]="(standaard is 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "De standaard directory van een document type moet zich bevinden binnen het werkgebied van de gebruiker, waardoor het corresponderende document type geselecteerd kan worden.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "Het werkgebied van de gebruiker moet zich bevinden binnen de standaard directory gedefinieerd in het document type zodat de gebruiker een document type kan selecteren.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Omgekeerd";
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standaard";
   $l_prefs["we_doctype_workspace_behavior"] = "Werking van de document type selectie";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Gebruik java upload';

/*****************************************************************************
 * message_reporting
 *****************************************************************************/
	$l_prefs["message_reporting"]["information"] = "U kunt hier instellen of u een melding wilt ontvangen voor webEdition handelingen als bewaren, publiceren of verwijderen.";
	
	$l_prefs["message_reporting"]["headline"] = "Notificaties";
	$l_prefs["message_reporting"]["show_notices"] = "Toon meldingen";
	$l_prefs["message_reporting"]["show_warnings"] = "Toon waarschuwingen";
	$l_prefs["message_reporting"]["show_errors"] = "Toon fouten";


/*****************************************************************************
 * Module Activation
 *****************************************************************************/
	$l_prefs["module_activation"]["information"] = "Hier kunt u uw modules activeren of deactiveren als u ze niet nodig heeft.<br /><br />Het deactiveren van modules verbetert de prestaties van webEdition.";
	
	$l_prefs["module_activation"]["headline"] = "Module activatie";

/*****************************************************************************
 * Email settings
 *****************************************************************************/
	
	$l_prefs["mailer_information"] = "Stel in of webEdition emails moet verwerken via de geïntegreerde PHP functie of dat er gebruikt gemaakt moet worden van een aparte SMTP server.<br /><br />Indien u gebruik maakt van een SMTP mail server, is de kans kleiner dat berichten als \"Spam\" worden gezien.";
	
	$l_prefs["mailer_type"] = "Mailer type"; // TRANSLATE
	$l_prefs["mailer_php"] = "Gebruik php mail() functie";
	$l_prefs["mailer_smtp"] = "Gebruik SMTP server";
	$l_prefs["email"] = "Email";
	$l_prefs["tab_email"] = "Email";
	$l_prefs["smtp_auth"] = "Authenticatie";
	$l_prefs["smtp_server"] = "SMTP server"; // TRANSLATE
	$l_prefs["smtp_port"] = "SMTP poort";
	$l_prefs["smtp_username"] = "Gebruikersnaam";
	$l_prefs["smtp_password"] = "Wachtwoord";
	$l_prefs["smtp_halo"] = "SMTP halo"; // TRANSLATE
	$l_prefs["smtp_timeout"] = "SMTP timeout"; // TRANSLATE
	
/*****************************************************************************
 * Versions settings
 *****************************************************************************/

	$l_prefs["versioning"] = "Versioning"; // TRANSLATE
	$l_prefs["version_all"] = "all"; // TRANSLATE
	$l_prefs["versioning_activate_text"] = "Activate versioning for some or all content types."; // TRANSLATE
	$l_prefs["versioning_time_text"] = "If you specify a time period, only versions are saved which are created in this time until today. Older versions will be deleted."; // TRANSLATE
	$l_prefs["versioning_time"] = "Time period"; // TRANSLATE
	$l_prefs["versioning_anzahl_text"] = "Number of versions which will be created for each document or object."; // TRANSLATE
	$l_prefs["versioning_anzahl"] = "Number"; // TRANSLATE
	$l_prefs["versioning_wizard_text"] = "Open the Version-Wizard to delete or reset versions."; // TRANSLATE
	$l_prefs["versioning_wizard"] = "Open Versions-Wizard"; // TRANSLATE
	$l_prefs["ContentType"] = "Content Type"; // TRANSLATE
	$l_prefs["versioning_create_text"] = "Determine which actions provoke new versions. Either if you publish or if you save, unpublish, delete or import files, too."; // TRANSLATE
	$l_prefs["versioning_create"] = "Create Version"; // TRANSLATE
	$l_prefs["versions_create_publishing"] = "only when publishing"; // TRANSLATE
	$l_prefs["versions_create_always"] = "always"; // TRANSLATE
	
	$l_prefs['use_jeditor'] = "Use"; // TRANSLATE
	$l_prefs["editor_font_colors"] = 'Specify font colors'; // TRANSLATE
	$l_prefs["editor_normal_font_color"] = 'Default'; // TRANSLATE
	$l_prefs["editor_we_tag_font_color"] = 'webEdition tags'; // TRANSLATE
	$l_prefs["editor_we_attribute_font_color"] = 'webEdition attributes'; // TRANSLATE
	$l_prefs["editor_html_tag_font_color"] = 'HTML tags'; // TRANSLATE
	$l_prefs["editor_html_attribute_font_color"] = 'HTML attributes'; // TRANSLATE
	$l_prefs["editor_pi_tag_font_color"] = 'PHP code'; // TRANSLATE
	$l_prefs["editor_comment_font_color"] = 'Comments'; // TRANSLATE
	$l_prefs["jeditor"] = 'Java source editor'; // TRANSLATE
	
	
	$l_prefs["juplod_not_installed"] = 'JUpload is not installed!'; // TRANSLATE
	

?>