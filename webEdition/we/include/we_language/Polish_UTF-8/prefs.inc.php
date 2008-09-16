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
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Ładowanie ustawień, zaczekaj chwilę ...";
$l_prefs["preload_wait"] = "Ładuję ustawienia";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Zapisano ustawienia, zaczekaj chwilę ...";
$l_prefs["save_wait"] = "Zapisuję ustawienia";

$l_prefs["saved"] = "Ustawienia zostały zapamiętane.";
$l_prefs["saved_successfully"] = "Zapisano ustawienia";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Interfejs";
$l_prefs["tab_glossary"] = "Glossary"; // TRANSLATE
$l_prefs["tab_extensions"] = "Rozszerzenia plików";
$l_prefs["tab_editor"] = 'Edytor';
$l_prefs["tab_formmail"] = 'Formmail'; // TRANSLATE
$l_prefs["formmail_recipients"] = 'Odbiorca formularza poczty';
$l_prefs["tab_proxy"] = 'Serwer Proxy';
$l_prefs["tab_advanced"] = 'Zaawansowane';
$l_prefs["tab_system"] = 'System'; // TRANSLATE
$l_prefs["tab_error_handling"] = 'Obsługa błędów';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_cache"] = 'Cache'; // TRANSLATE
$l_prefs["tab_language"] = 'Languages'; // TRANSLATE
$l_prefs["tab_modules"] = 'Moduły';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Język";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode"; // TRANSLATE
	$l_prefs["seem_deactivate"] = "Wyłącz seeMode";
	$l_prefs["seem_startdocument"] = "Dokument startowy - seeMode";
	$l_prefs["seem_start_type_document"] = "Document"; // TRANSLATE
	$l_prefs["seem_start_type_object"] = "Object"; // TRANSLATE
	$l_prefs["seem_start_type_cockpit"] = "Cockpit"; // TRANSLATE
	$l_prefs["question_change_to_seem_start"] = "Chcesz zamienić na wybrany dokument?";


	/**
	 * Sidebar
	 */
	$l_prefs["sidebar"] = "Sidebar"; // TRANSLATE
	$l_prefs["sidebar_deactivate"] = "deactivate"; // TRANSLATE
	$l_prefs["sidebar_show_on_startup"] = "show on startup"; // TRANSLATE
	$l_prefs["sidebar_width"] = "Width in pixel"; // TRANSLATE
	$l_prefs["sidebar_document"] = "Document"; // TRANSLATE


	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Wielkość okna";
	$l_prefs["maximize"] = "Maksymalizuj";
	$l_prefs["specify"] = "Ustaw";
	$l_prefs["width"] = "Szerokość";
	$l_prefs["height"] = "Wysokość";
	$l_prefs["predefined"] = "Wymary domyślne";
	$l_prefs["show_predefined"] = "Wyświetl wymiary domyślne";
	$l_prefs["hide_predefined"] = "Wyłacz wymiary domyślne";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Tytuł drzewa";
	$l_prefs["all"] = "Wszystkie";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */
	$l_prefs["extensions_information"] = "Set the default file extensions for static and dynamic pages here."; // TRANSLATE
	
	$l_prefs["we_extensions"] = "Rozszerzenia webEdition";
	$l_prefs["static"] = "Strony Statyczne";
	$l_prefs["dynamic"] = "Strony dynamiczne";
	$l_prefs["html_extensions"] = "Rozszerzenia HTML";
	$l_prefs["html"] = "Strony HTML";
	
/*****************************************************************************
 * Glossary
 *****************************************************************************/

	$l_prefs["glossary_publishing"] = "Check before publishing"; // TRANSLATE
	$l_prefs["force_glossary_check"] = "Force glossary check"; // TRANSLATE
	$l_prefs["force_glossary_action"] = "Force action"; // TRANSLATE

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Columns in the cockpit "; // TRANSLATE


/*****************************************************************************
 * CACHING
 *****************************************************************************/

	/**
	 * Cache Type
	 */
	$l_prefs["cache_information"] = "Set the preset values of the fields \"Caching Type\" and \"Cache lifetime in seconds\" for new templates here.<br /><br />Please note that these setting are only the presets of the fields."; // TRANSLATE
	$l_prefs["cache_navigation_information"] = "Enter the defaults for the &lt;we:navigation&gt; tag here. This value can be overwritten by the attribute \"cachelifetime\" of the &lt;we:navigation&gt; tag."; // TRANSLATE
	
	$l_prefs["cache_presettings"] = "Presetting"; // TRANSLATE
	$l_prefs["cache_type"] = "Caching Type"; // TRANSLATE
	$l_prefs["cache_type_none"] = "Caching deactivated"; // TRANSLATE
	$l_prefs["cache_type_full"] = "Full cache"; // TRANSLATE
	$l_prefs["cache_type_document"] = "Document cache"; // TRANSLATE
	$l_prefs["cache_type_wetag"] = "we:Tag cache"; // TRANSLATE

	/**
	 * Cache Life Time
	 */
	$l_prefs["cache_lifetime"] = "Cache lifetime in seconds"; // TRANSLATE

	$l_prefs['cache_lifetimes'] = array();
	$l_prefs['cache_lifetimes'][0] = "";
	$l_prefs['cache_lifetimes'][60] = "1 minute"; // TRANSLATE
	$l_prefs['cache_lifetimes'][300] = "5 minutes"; // TRANSLATE
	$l_prefs['cache_lifetimes'][600] = "10 minutes"; // TRANSLATE
	$l_prefs['cache_lifetimes'][1800] = "30 minutes"; // TRANSLATE
	$l_prefs['cache_lifetimes'][3600] = "1 hour"; // TRANSLATE
	$l_prefs['cache_lifetimes'][21600] = "6 hours"; // TRANSLATE
	$l_prefs['cache_lifetimes'][43200] = "12 hours"; // TRANSLATE
	$l_prefs['cache_lifetimes'][86400] = "1 day"; // TRANSLATE

	$l_prefs['delete_cache_after'] = 'Clear cache after'; // TRANSLATE
	$l_prefs['delete_cache_add'] = 'adding a new entry'; // TRANSLATE
	$l_prefs['delete_cache_edit'] = 'changing a entry'; // TRANSLATE
	$l_prefs['delete_cache_delete'] = 'deleting a entry'; // TRANSLATE
	$l_prefs['cache_navigation'] = 'Default setting'; // TRANSLATE
	$l_prefs['default_cache_lifetime'] = 'Default cache lifetime'; // TRANSLATE


/*****************************************************************************
 * LOCALES // LANGUAGES
 *****************************************************************************/

	/**
	 * Languages
	 */
	$l_prefs["locale_information"] = "Add all languages for which you would provide a web page.<br /><br />This preference will be used for the glossary check and the spellchecking."; // TRANSLATE

	$l_prefs["locale_languages"] = "Language"; // TRANSLATE
	$l_prefs["locale_countries"] = "Country"; // TRANSLATE
	$l_prefs["locale_add"] = "Add language"; // TRANSLATE
	$l_prefs['cannot_delete_default_language'] = "The default language cannot be deleted."; // TRANSLATE
	$l_prefs["language_already_exists"] = "This language already exists"; // TRANSLATE
	$l_prefs["add_dictionary_question"] = "Would you like to upload the dictionary for this language?"; // TRANSLATE

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = 'Rozszerzenie edytora';
	$l_prefs["use_it"] = "Użyj";
	$l_prefs["start_automatic"] = "Uruchom automatycznie";
	$l_prefs["ask_at_start"] = 'Zapytaj przy starcie, który edytor<br> ma być używany<br>';
	$l_prefs["must_register"] = 'Musisz być zarejestrowany';
	$l_prefs["change_only_in_ie"] = 'Ponieważ rozszerzenie edytora działa tylko w systemie Windows w przeglądarkach Internet Explorer, Mozilla Firebird oraz Firefox nie można zmienić tych ustawień.';
	$l_prefs["install_plugin"] = 'Żeby można było wykorzystać rozszerzenie edytora w twojej przeglądarce, powinienieś zainstalować Mozilla ActiveX PlugIn.';
	$l_prefs["confirm_install_plugin"] = 'Mozilla ActiveX PlugIn umożliwia zintegrowanie kontrolek ActiveX w przeglądarce Mozilla. Po instalacji należy na nowo uruchomić przeglądarkę.\\n\\nPamiętaj: ActiveX może stanowić ryzyko dla bezpieczeństwa!\\n\\nKontynuować instalację?';

	$l_prefs["install_editor_plugin"] = 'Żeby używać rozszerzenia edytora w Twojej przeglądarce, musisz go zainstalować.';
	$l_prefs["install_editor_plugin_text"]= 'Rozszerzenie edytora dla webEdition zostanie zainstalowane...';

	/**
	 * TEMPLATE EDITOR
	 */
	
	$l_prefs["editor_information"] = "Specify font and size which should be used for the editing of templates, CSS- and Java Script files within webEdition.<br /><br />These settings are used for the text editor of the abovementioned file types."; // TRANSLATE
	
	$l_prefs["editor_font"] = 'Czcionka w edytorze';
	$l_prefs["editor_fontname"] = 'Krój pisma';
	$l_prefs["editor_fontsize"] = 'Wielkość';
	$l_prefs["editor_dimension"] = 'Wielkość edytora';
	$l_prefs["editor_dimension_normal"] = 'Normalna';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Wpisz tutaj wszystkie adresy e-mail, do których mogą być wysyłane formularze za pomocą funkcji Formmail (&lt;we:form type=\"formmail\" ..&gt;) .<br><br>Jeżeli nie wpisano tu żadnych adresów e-mail, to nie można wysyłać formularzy za pomocą funkcji Formmail!";

	$l_prefs["formmail_log"] = "Formmail log"; // TRANSLATE
	$l_prefs['log_is_empty'] = "The log is empty!"; // TRANSLATE
	$l_prefs['ip_address'] = "IP address"; // TRANSLATE
	$l_prefs['blocked_until'] = "Blocked until"; // TRANSLATE
	$l_prefs['unblock'] = "Unblock"; // TRANSLATE
	$l_prefs['clear_log_question'] = "Do you really want to clear the log?"; // TRANSLATE
	$l_prefs['clear_block_entry_question'] = "Do you really want to unblock the IP %s ?"; // TRANSLATE
	$l_prefs["forever"] = "Always"; // TRANSLATE
	$l_prefs["yes"] = "yes"; // TRANSLATE
	$l_prefs["no"] = "no"; // TRANSLATE
	$l_prefs["on"] = "on"; // TRANSLATE
	$l_prefs["off"] = "off"; // TRANSLATE
	$l_prefs["formmailConfirm"] = "Formmail confirmation function"; // TRANSLATE
	$l_prefs["logFormmailRequests"] = "Log formmail requests"; // TRANSLATE
	$l_prefs["deleteEntriesOlder"] = "Delete entries older than"; // TRANSLATE
	$l_prefs["blockFormmail"] = "Limit formmail requests"; // TRANSLATE
	$l_prefs["formmailSpan"] = "Within the span of time"; // TRANSLATE
	$l_prefs["formmailTrials"] = "Requests allowed"; // TRANSLATE
	$l_prefs["blockFor"] = "Block for"; // TRANSLATE
	$l_prefs["never"] = "never"; // TRANSLATE
	$l_prefs["1_day"] = "1 day"; // TRANSLATE
	$l_prefs["more_days"] = "%s days"; // TRANSLATE
	$l_prefs["1_week"] = "1 week"; // TRANSLATE
	$l_prefs["more_weeks"] = "%s weeks"; // TRANSLATE
	$l_prefs["1_minute"] = "1 minute"; // TRANSLATE
	$l_prefs["more_minutes"] = "%s minutes"; // TRANSLATE
	$l_prefs["1_hour"] = "1 hour"; // TRANSLATE
	$l_prefs["more_hours"] = "%s hours"; // TRANSLATE
	$l_prefs["ever"] = "always"; // TRANSLATE

/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["proxy_information"] = "Specify your Proxy settings for your server here, if your server uses a proxy for the connection with the Internet."; // TRANSLATE
	
	$l_prefs["useproxy"] = "Użyj Serwera Proxy do aktualizacji Live-Update<br>";
	$l_prefs["proxyaddr"] = "Adres";
	$l_prefs["proxyport"] = "Port"; // TRANSLATE
	$l_prefs["proxyuser"] = "Nazwa użytkownika";
	$l_prefs["proxypass"] = "Hasło";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Standardowe ustawienie dla<br>atrybutu <em>php</em> w we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Standardowe ustawienie dla<br>atrybutu <em>inlineedit</em> w<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Pola tekstowe otwierać w obrębie strony (true) lub w <br />nowym oknie (false)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Użyj edytora Wysiwyg<br>Safari (wersja beta)";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Standardowe ustawienie dla <br>atrybutu <em>showinputs</em> w <br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Rodzaj połączeń <br>bazą danych";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "Autentyfikacja HTTP";
	$l_prefs["useauth"] = "Serwer stosuje Autentyfikację HTTP<br>w katalogu webEdition<br>";
	$l_prefs["authuser"] = "Nazwa użytkownika";
	$l_prefs["authpass"] = "Hasło";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directory"; // TRANSLATE

	$l_prefs["pagelogger_dir"] = "Katalog pageLoggera";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Errorpage for not existing objects'; // TRANSLATE

	/**
	 * TEMPLATE TAG CHECK
	 */

	$l_prefs["templates"] = "Templates"; // TRANSLATE
	$l_prefs["disable_template_tag_check"] = "Deactivate check for missing,<br />closing we:tags"; // TRANSLATE

	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "Włącz obsługe błędów webEdition <br>";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Do obsługiwanego błędu";
	$l_prefs["error_notices"] = "Wskazówki";
	$l_prefs["error_warnings"] = "Ostrzeżenia";
	$l_prefs["error_errors"] = "Błędy";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.'; // TRANSLATE

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Wyświetlanie błędów";
	$l_prefs["error_display"] = "Wyświetl błąd";
	$l_prefs["error_log"] = "Rejestruj błędy";
	$l_prefs["error_mail"] = "Wyślij e-mail z informacją o błędzie";
	$l_prefs["error_mail_address"] = "Adresy";
	$l_prefs["error_mail_not_saved"] = 'Błedy nie zostaną wysłane na podany przez Ciebie adres, ponieważ adres ten podano błędnie!\n\nZapisano pozostałe ustawienia.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Wyświetl ustawienia eksperta";
	$l_prefs["hide_expert"] = "Ukryj ustawienia eksperta";
	$l_prefs["show_debug_frame"] = "Wyświetl Debug-Frame";
	$l_prefs["debug_normal"] = "W trybie normalnym";
	$l_prefs["debug_seem"] = "W trybie SeeModus";
	$l_prefs["debug_restart"] = "Zmiany wymagają ponownego uruchomienia";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "Moduł DB/Obiekt";
	$l_prefs["tree_count"] = "Liczba obiektów do wyświetlenia";
	$l_prefs["tree_count_description"] = "Wartość ta podaje maksymalną liczbę wpisów do wyświetlenia w lewym oknie nawigacji.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Backup"; // TRANSLATE
	$l_prefs["backup_slow"] = "Slow"; // TRANSLATE
	$l_prefs["backup_fast"] = "Fast"; // TRANSLATE
	$l_prefs["performance"] = "Here you can set an appropriate performance level. The performance level should be adequate to the server system. If the system has limited resources (memory, timeout etc.) choose a slow level, otherwise choose a fast level."; // TRANSLATE
	$l_prefs["backup_auto"]="Auto"; // TRANSLATE

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Walidacja';
	$l_prefs['xhtml_default'] = 'Standardowe ustawienie atrybutu <em>xml</em> w we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'Wyszukiwanie błędów w XHTML (Debugging) wspierasz tworząc bezbłedne strony WWW. Opcjonalnie można sprawdzić każde wystąpienie znacznika we:Tags pod kątem ważności a w razie potrzeby usunąć bądź wyswietlić błędne atrybuty. Pamiętaj, że proces ten wymaga trochę czasu i może być używany tylko w trakcie tworzenia nowej strony WWW.';
	$l_prefs['xhtml_debug_headline'] = 'XHTML-Debugging';
	$l_prefs['xhtml_debug_html'] = 'Włącz Debugging XHTML';
	$l_prefs['xhtml_remove_wrong'] = 'Usuń błędne atrybuty';
	$l_prefs['xhtml_show_wrong_headline'] = 'Powiadomienie przy błędnych atrybutach';
	$l_prefs['xhtml_show_wrong_html'] = 'Włącz';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Jako tekst';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Jako komunikat JavaScript';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'W logu błędów (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Maksymalna wielkość uploadu w<br>tekstach wskazówek";
	$l_prefs["we_max_upload_size_hint"]="(w MB, 0=automatycznie)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Prawa dostępu do <br>nowych katalogów";
	$l_prefs["we_new_folder_mod_hint"]="(Standardowo 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "Standardowy katalog typu dokumentu musi się znajdować wewnątrz obszaru roboczego użytkownika, aby użytkownik mógł zmieniać typ dokumentu.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "Obszar roboczy użytkownika musi się znajdować wewnątrz ustawionego w typie dokumentu katalogu standadardowego, aby użytkownik mógł zminiać typ dokumentu.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Odwrotnie";
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standardowo";
   $l_prefs["we_doctype_workspace_behavior"] = "Wybór zachowania typu dokumentu";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Use java upload'; // TRANSLATE

/*****************************************************************************
 * message_reporting
 *****************************************************************************/
	$l_prefs["message_reporting"]["information"] = "You can decide on the respective check boxes whether you like to receive a notice for webEdition operations as for example saving, publishing or deleting."; // TRANSLATE
	
	$l_prefs["message_reporting"]["headline"] = "Notifications"; // TRANSLATE
	$l_prefs["message_reporting"]["show_notices"] = "Show Notices"; // TRANSLATE
	$l_prefs["message_reporting"]["show_warnings"] = "Show Warnings"; // TRANSLATE
	$l_prefs["message_reporting"]["show_errors"] = "Show Errors"; // TRANSLATE


/*****************************************************************************
 * Module Activation
 *****************************************************************************/
	$l_prefs["module_activation"]["information"] = "Here you can activate or deactivate your modules if you do not need them.<br /><br />Deactivated modules improve the overall performance of webEdition."; // TRANSLATE
	
	$l_prefs["module_activation"]["headline"] = "Module activation"; // TRANSLATE

/*****************************************************************************
 * Email settings
 *****************************************************************************/
	
	$l_prefs["mailer_information"] = "Adjust whether webEditionin should dispatch emails via the integrated PHP function or a seperate SMTP server should be used.<br /><br />When using a SMTP mail server, the risk that messages are classified by the receiver as a \"Spam\" is lowered."; // TRANSLATE
	
	$l_prefs["mailer_type"] = "Mailer type"; // TRANSLATE
	$l_prefs["mailer_php"] = "Use php mail() function"; // TRANSLATE
	$l_prefs["mailer_smtp"] = "Use SMTP server"; // TRANSLATE
	$l_prefs["email"] = "E-Mail"; // TRANSLATE
	$l_prefs["tab_email"] = "E-Mail"; // TRANSLATE
	$l_prefs["smtp_auth"] = "Authentication"; // TRANSLATE
	$l_prefs["smtp_server"] = "SMTP server"; // TRANSLATE
	$l_prefs["smtp_port"] = "SMTP port"; // TRANSLATE
	$l_prefs["smtp_username"] = "User name"; // TRANSLATE
	$l_prefs["smtp_password"] = "Password"; // TRANSLATE
	$l_prefs["smtp_halo"] = "SMTP halo"; // TRANSLATE
	$l_prefs["smtp_timeout"] = "SMTP timeout"; // TRANSLATE

/*****************************************************************************
 * Versions settings
 *****************************************************************************/

	$l_prefs["versioning"] = "Versioning"; //TRANSLATE
	$l_prefs["version_all"] = "all"; //TRANSLATE
	$l_prefs["versioning_activate_text"] = "Activate versioning for some or all content types."; //TRANSLATE
	$l_prefs["versioning_time_text"] = "If you specify a time period, only versions are saved which are created in this time until today. Older versions will be deleted."; //TRANSLATE
	$l_prefs["versioning_time"] = "Time period"; //TRANSLATE
	$l_prefs["versioning_anzahl_text"] = "Number of versions which will be created for each document or object."; //TRANSLATE
	$l_prefs["versioning_anzahl"] = "Number"; //TRANSLATE
	$l_prefs["versioning_wizard_text"] = "Open the Version-Wizard to delete or reset versions."; //TRANSLATE
	$l_prefs["versioning_wizard"] = "Open Versions-Wizard"; //TRANSLATE
	$l_prefs["ContentType"] = "Content Type"; //TRANSLATE
	$l_prefs["versioning_create_text"] = "Determine which actions provoke new versions. Either if you publish or if you save, unpublish, delete or import files, too."; //TRANSLATE
	$l_prefs["versioning_create"] = "Create Version"; //TRANSLATE
	$l_prefs["versions_create_publishing"] = "only when publishing"; //TRANSLATE
	$l_prefs["versions_create_always"] = "always"; //TRANSLATE

	$l_prefs['use_jeditor'] = "Use"; //TRANSLATE
	$l_prefs["editor_font_colors"] = 'Specify font colors'; //TRANSLATE
	$l_prefs["editor_normal_font_color"] = 'Default'; //TRANSLATE
	$l_prefs["editor_we_tag_font_color"] = 'webEdition tags'; //TRANSLATE
	$l_prefs["editor_we_attribute_font_color"] = 'webEdition attributes'; //TRANSLATE
	$l_prefs["editor_html_tag_font_color"] = 'HTML tags'; //TRANSLATE
	$l_prefs["editor_html_attribute_font_color"] = 'HTML attributes'; //TRANSLATE
	$l_prefs["editor_pi_tag_font_color"] = 'PHP code'; //TRANSLATE
	$l_prefs["editor_comment_font_color"] = 'Comments'; //TRANSLATE
	$l_prefs["jeditor"] = 'Java source editor'; //TRANSLATE
	
	$l_prefs["juplod_not_installed"] = 'JUpload is not installed!'; //TRANSLATE
	
?>