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
 * Language file: prefs.inc.php
 * Provides language strings.
 * Language: Deutsch
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Einstellungen werden geladen, einen Moment ...";
$l_prefs["preload_wait"] = "Lade Einstellungen";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Einstellungen werden gespeichert, einen Moment ...";
$l_prefs["save_wait"] = "Speichere Einstellungen";

$l_prefs["saved"] = "Die Einstellungen wurden erfolgreich gespeichert.";
$l_prefs["saved_successfully"] = "Einstellungen gespeichert";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Oberfl�che";
$l_prefs["tab_glossary"] = "Glossar";
$l_prefs["tab_extensions"] = "Dateierweiterungen";
$l_prefs["tab_editor"] = 'Editor';
$l_prefs["tab_formmail"] = 'Formmail';
$l_prefs["formmail_recipients"] = 'Formmail Empf�nger';
$l_prefs["tab_proxy"] = 'Proxy Server';
$l_prefs["tab_advanced"] = 'Erweitert';
$l_prefs["tab_system"] = 'System';
$l_prefs["tab_error_handling"] = 'Fehlerbehandlung';
$l_prefs["tab_cockpit"] = 'Cockpit';
$l_prefs["tab_cache"] = 'Cache';
$l_prefs["tab_language"] = 'Sprachen';
$l_prefs["tab_modules"] = 'Module';
$l_prefs["tab_versions"] = 'Versionierung';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Sprache";
	$l_prefs["language_notice"] = "Die Sprachumstellung wird erst nach einem Neustart des webEdition an allen Stellen durchgef�hrt.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode";
	$l_prefs["seem_deactivate"] = "deaktivieren";
	$l_prefs["seem_startdocument"] = "Startseite";
	$l_prefs["seem_start_type_document"] = "Dokument";
	$l_prefs["seem_start_type_object"] = "Objekt";
	$l_prefs["seem_start_type_cockpit"] = "Cockpit";
	$l_prefs["question_change_to_seem_start"] = "M�chten Sie zum ausgew�hlten Dokument wechseln?";


	/**
	 * Sidebar
	 */
	$l_prefs["sidebar"] = "Sidebar";
	$l_prefs["sidebar_deactivate"] = "deaktivieren";
	$l_prefs["sidebar_show_on_startup"] = "beim Starten anzeigen";
	$l_prefs["sidebar_width"] = "Breite in Pixel";
	$l_prefs["sidebar_document"] = "Dokument";


	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Fenstergr��e";
	$l_prefs["maximize"] = "Maximieren";
	$l_prefs["specify"] = "Spezifizieren";
	$l_prefs["width"] = "Breite";
	$l_prefs["height"] = "H�he";
	$l_prefs["predefined"] = "Voreingestellte Gr��en";
	$l_prefs["show_predefined"] = "Voreingestellte Gr��en anzeigen";
	$l_prefs["hide_predefined"] = "Voreingestellte Gr��en ausblenden";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Baummen�";
	$l_prefs["all"] = "Alle";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */

	$l_prefs["extensions_information"] = "Hier werden die standardm��ig verwendeten Datei-Erweiterungen f�r statische und dynamische Seiten festgelegt.";

	$l_prefs["we_extensions"] = "webEdition-Erweiterungen";
	$l_prefs["static"] = "Statische Seiten";
	$l_prefs["dynamic"] = "Dynamische Seiten";
	$l_prefs["html_extensions"] = "HTML-Erweiterungen";
	$l_prefs["html"] = "HTML-Dateien";

/*****************************************************************************
 * Glossary
 *****************************************************************************/

	$l_prefs["glossary_publishing"] = "Pr�fen bei Ver�ffentlichung";
	$l_prefs["force_glossary_check"] = "Glossarpr�fung erzwingen";
	$l_prefs["force_glossary_action"] = "Aktion erzwingen";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Spalten im Cockpit";

/*****************************************************************************
 * CACHING
 *****************************************************************************/

	/**
	 * Cache Type
	 */
	$l_prefs["cache_information"] = "Stellen Sie hier die Werte ein, mit welchen die Felder \"Art des Caches\" und \"Cache G�ltigkeit in Sekunden\" bei neuen Vorlagen belegt sein sollen.<br /><br />Beachten Sie bitte, dass diese Einstellung lediglich eine Vorbelegung der Felder ist.";
	$l_prefs["cache_navigation_information"] = "Tragen Sie hier die Standardwerte f�r den Tag &lt;we:navigation&gt; ein. Dieser Wert kann durch das setzen des Attributes cachelifetime im Tag &lt;we:navigation&gt; �berschrieben werden.";

	$l_prefs["cache_presettings"] = "Voreinstellung";
	$l_prefs["cache_type"] = "Art des Caches";
	$l_prefs["cache_type_none"] = "Caching deaktiviert";
	$l_prefs["cache_type_full"] = "Full Cache";
	$l_prefs["cache_type_document"] = "Dokument Cache";
	$l_prefs["cache_type_wetag"] = "we:Tag Cache";


	$l_prefs['delete_cache_after'] = 'Cache der Navigation l�schen';
	$l_prefs['delete_cache_add'] = 'nach Anlegen eines neuen Eintrages';
	$l_prefs['delete_cache_edit'] = 'nach �ndern eines Eintrages';
	$l_prefs['delete_cache_delete'] = 'nach L�schen eines Eintrages';
	$l_prefs['cache_navigation'] = 'Standardeinstellung';
	$l_prefs['default_cache_lifetime'] = 'Standard Cache G�ltigkeit';

	/**
	 * Cache Life Time
	 */
	$l_prefs["cache_lifetime"] = "Cache G�ltigkeit in Sekunden";

	$l_prefs['cache_lifetimes'] = array();
	$l_prefs['cache_lifetimes'][0] = "";
	$l_prefs['cache_lifetimes'][60] = "1 Minute";
	$l_prefs['cache_lifetimes'][300] = "5 Minuten";
	$l_prefs['cache_lifetimes'][600] = "10 Minuten";
	$l_prefs['cache_lifetimes'][1800] = "30 Minuten";
	$l_prefs['cache_lifetimes'][3600] = "1 Stunde";
	$l_prefs['cache_lifetimes'][21600] = "6 Stunden";
	$l_prefs['cache_lifetimes'][43200] = "12 Stunden";
	$l_prefs['cache_lifetimes'][86400] = "1 Tag";



/*****************************************************************************
 * LOCALES // LANGUAGES
 *****************************************************************************/

	/**
	 * Languages
	 */
	$l_prefs["locale_information"] = "F�gen Sie hier alle Sprachen hinzu, f�r welche Sie eine Webseite mit webEdition erstellen m�chten.<br /><br />Diese Einstellung wird f�r das Glossar und die Rechtschreibpr�fung einzelner Dokumente verwendet.";

	$l_prefs["locale_languages"] = "Sprache";
	$l_prefs["locale_countries"] = "Land";
	$l_prefs["locale_add"] = "Sprache hinzuf�gen";
	$l_prefs['cannot_delete_default_language'] = "Die Standardsprache kann nicht gel�scht werden.";
	$l_prefs["language_already_exists"] = "Diese Sprache wurde bereits angelegt.";
	$l_prefs["add_dictionary_question"] = "M�chten Sie gleich das W�rterbuch f�r diese Sprache hinzuf�gen?";


/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */
	$l_prefs["editor_plugin"] = 'Editor PlugIn';
	$l_prefs["use_it"] = "Benutzen";
	$l_prefs["start_automatic"] = "Automatisch starten";
	$l_prefs["ask_at_start"] = 'Beim Starten nachfragen,<br>welcher Editor benutzt<br>werden soll';
	$l_prefs["must_register"] = 'Muss registriert sein';
	$l_prefs["change_only_in_ie"] = 'Da das Editor PlugIn nur unter Windows im Internet Explorer, Mozilla, Firebird sowie Firefox funktioniert, sind diese Einstellungen nicht ver�nderbar.';
	$l_prefs["install_plugin"] = 'Um das Editor PlugIn in Ihrem Browser benutzen zu k�nnen, muss das Mozilla ActiveX PlugIn installiert werden.';
	$l_prefs["confirm_install_plugin"] = 'Das Mozilla ActiveX PlugIn erm�glicht es, ActiveX Controls in Mozilla Browser zu integrieren. Nach der Installation muss der Browser neu gestartet werden.\\n\\nBeachten Sie: ActiveX kann ein Sicherheitsrisiko darstellen!\\n\\nMit der Installation fortfahren?';

	$l_prefs["install_editor_plugin"] = 'Um das webEdition Editor PlugIn in Ihrem Browser benutzen zu k�nnen, muss es installiert werden.';
	$l_prefs["install_editor_plugin_text"]= 'Das webEdition Editor PlugIn wird installiert...';


	/**
	 * TEMPLATE EDITOR
	 */

	$l_prefs["editor_information"] = "Geben Sie hier Schriftart und Gr��e an, die f�r die Bearbeitung der Vorlagen, CSS- und Java Script-Dateien innerhalb von webEdition verwendet werden soll.<br /><br />Diese Einstellungen werden f�r den Texteditor der obengenannten Dateitypen verwendet.";

	$l_prefs["editor_font"] = 'Schrift im Editor';
	$l_prefs["editor_fontname"] = 'Schriftart';
	$l_prefs["editor_fontsize"] = 'Gr��e';

	
/*****************************************************************************
 * FORMMAIL
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Tragen Sie hier alle E-Mail-Adressen ein, an welche Formulare mit der Formmail-Funktion (&lt;we:form type=\"formmail\" ..&gt;) geschickt werden d�rfen.<br><br>Ist hier keine E-Mail-Adresse eingetragen, kann man keine Formulare mit der Formmail-Funktion verschicken!";

	$l_prefs["formmail_log"] = "Formmail-Logbuch";
	$l_prefs['log_is_empty'] = "Das Logbuch ist leer!";
	$l_prefs['ip_address'] = "IP Adresse";
	$l_prefs['blocked_until'] = "Geblockt bis";
	$l_prefs['unblock'] = "freigeben";
	$l_prefs['logboockEmptyQuestion'] = "M�chten Sie das Logbuch wirklich leeren?";
	$l_prefs['clear_block_entry_question'] = "M�chten Sie die IP %s wirklich freigeben?";
	$l_prefs["forever"] = "F�r immer";
	$l_prefs["yes"] = "ja";
	$l_prefs["no"] = "nein";
	$l_prefs["on"] = "ein";
	$l_prefs["off"] = "aus";
	$l_prefs["formmailConfirm"] = "Formmail Best�tigungsfunktion";
	$l_prefs["logFormmailRequests"] = "Formmail Anfragen protokollieren";
	$l_prefs["deleteEntriesOlder"] = "Eintr�ge l�schen die �lter sind als";
	$l_prefs["formmailViaWeDoc"] = "Formmail �ber webEdition-Dokument aufrufen";
	$l_prefs["blockFormmail"] = "Formmail Anfragen begrenzen";
	$l_prefs["formmailSpan"] = "Innerhalb der Zeitspanne";
	$l_prefs["formmailTrials"] = "Erlaubte Anfragen";
	$l_prefs["blockFor"] = "Blockieren f�r";
	$l_prefs["never"] = "nie";
	$l_prefs["1_day"] = "1 Tag";
	$l_prefs["more_days"] = "%s Tage";
	$l_prefs["1_week"] = "1 Woche";
	$l_prefs["more_weeks"] = "%s Wochen";
	$l_prefs["1_year"] = "1 Jahr";
	$l_prefs["more_years"] = "%s Jahre";
	$l_prefs["1_minute"] = "1 Minute";
	$l_prefs["more_minutes"] = "%s Minuten";
	$l_prefs["1_hour"] = "1 Stunde";
	$l_prefs["more_hours"] = "%s Stunden";
	$l_prefs["ever"] = "immer";


/*****************************************************************************
 * PROXY SERVER
 *****************************************************************************/

	/**
	 * PROXY SERVER
	 */

	$l_prefs["proxy_information"] = "Hier nehmen Sie die Einstellungen f�r den Proxy Server vor, falls Ihr Server einen Proxy f�r die Verbindung mit dem Internet verwendet.";

	$l_prefs["useproxy"] = "Proxy Server f�r Live-Update<br>verwenden";
	$l_prefs["proxyaddr"] = "Adresse";
	$l_prefs["proxyport"] = "Port";
	$l_prefs["proxyuser"] = "Benutzername";
	$l_prefs["proxypass"] = "Kennwort";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Standard Einstellung f�r<br><em>php</em>-Attribut in we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Standard Einstellung f�r<br><em>inlineedit</em>-Attribut in<br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Textfelder innerhalb der Seite (true) oder in einem<br />neuen Fenster (false) �ffnen";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Safari Wysiwyg Editor<br>(Betaversion) benutzen";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Standard Einstellung f�r<br><em>showinputs</em>-Attribut in<br>&lt;we:img&gt;";

	 /**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Art der Datenbank-<br>verbindungen";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "HTTP Authentifizierung";
	$l_prefs["useauth"] = "Server verwendet HTTP<br>Authentifizierung im webEdition<br>Verzeichnis";
	$l_prefs["authuser"] = "Benutzername";
	$l_prefs["authpass"] = "Kennwort";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"]="Verzeichnis f�r Miniaturansichten";

	$l_prefs["pagelogger_dir"] = "pageLogger-Verzeichnis";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/

	$l_prefs['error_no_object_found'] = 'Fehlerseite f�r nicht existierende Objekte';

	/**
	 * TEMPLATE TAG CHECK
	 */

	$l_prefs["templates"] = "Vorlagen";
	$l_prefs["disable_template_tag_check"] = "Pr�fung auf fehlende,<br />schlie�ende we:tags deaktivieren";

	/**
	 * ERROR HANDLER
	 */

	$l_prefs["error_use_handler"] = "webEdition Fehler-<br>behandlung aktivieren";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Zu behandelnde Fehler";
	$l_prefs["error_notices"] = "Hinweise";
	$l_prefs["error_warnings"] = "Warnungen";
	$l_prefs["error_errors"] = "Fehler";

	$l_prefs["error_notices_warning"] = 'Option f�r Entwickler! Nicht auf Live-System aktivieren.';


	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Fehleranzeige";
	$l_prefs["error_display"] = "Fehler anzeigen";
	$l_prefs["error_log"] = "Fehler protokollieren";
	$l_prefs["error_mail"] = "Fehler als Mail senden";
	$l_prefs["error_mail_address"] = "Adresse";
	$l_prefs["error_mail_not_saved"] = 'Fehler werden nicht an die von Ihnen eingegebene E-Mail-Adresse geschickt, da diese Adresse fehlerhaft eingegeben wurde!\n\nDie restlichen Einstellungen wurden erfolgreich gespeichert.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Experteneinstellungen anzeigen";
	$l_prefs["hide_expert"] = "Experteneinstellungen ausblenden";
	$l_prefs["show_debug_frame"] = "Debug-Frame anzeigen";
	$l_prefs["debug_normal"] = "Im normalen Modus";
	$l_prefs["debug_seem"] = "Im SeeModus";
	$l_prefs["debug_restart"] = "�nderungen erfordern einen Neustart";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "DB/Objekt Modul";
	$l_prefs["tree_count"] = "Anzahl anzuzeigender Objekte";
	$l_prefs["tree_count_description"] = "Dieser Wert gibt die maximale Anzahl anzuzeigender Eintr�ge in der linken Navigation an.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"]="Backup";
	$l_prefs["backup_slow"]="Langsam";
	$l_prefs["backup_fast"]="Schnell";
	$l_prefs["performance"]="Stellen Sie hier ein passendes Leistungslevel ein. Dieses richtet sich nach der Leistungsf�higkeit Ihres Servers. Wenn die Ressourcen Ihres Systemes eingeschr�nkt sind (Speicher, Timeout etc.) w�hlen Sie bitte eine niedrigere Einstellung.";
	$l_prefs["backup_auto"]="Auto";


/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Validierung';
	$l_prefs['xhtml_default'] = 'Standardeinstellung f�r das <em>xml</em>-Attribut in we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'Das XHTML-Debugging unterst�tzt Sie bei der Erstellung valider Web-Sites. Optional kann jede Ausgabe eines we:Tags auf G�ltigkeit kontrolliert werden und bei Bedarf fehlerhafte Attribute entfernt, bzw. angezeigt werden. Bitte beachten Sie, dass dieser Vorgang etwas Zeit erfordert und nur w�hrend der Erstellung einer neuen Web-Site benutzt werden sollte.';
	$l_prefs['xhtml_debug_headline'] = 'XHTML-Debugging';
	$l_prefs['xhtml_debug_html'] = 'XHTML-Debugging aktivieren';
	$l_prefs['xhtml_remove_wrong'] = 'Fehlerhafte Attribute entfernen';
	$l_prefs['xhtml_show_wrong_headline'] = 'Benachrichtigung bei fehlerhaften Attributen';
	$l_prefs['xhtml_show_wrong_html'] = 'Aktivieren';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Als Text';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Als JavaScript-Meldung';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'Ins Error-Log (PHP)';

/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Maximale Upload Gr��e<br>in Hinweistexten";
	$l_prefs["we_max_upload_size_hint"]="(in MByte, 0=automatisch)";


/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Zugriffsrechte f�r<br>neue Verzeichnisse";
	$l_prefs["we_new_folder_mod_hint"]="(Standard ist 755)";



/*****************************************************************************
 * we_doctype_workspace_behavior
 *****************************************************************************/

	$l_prefs["we_doctype_workspace_behavior_hint0"] = "Das Standardverzeichnis eines Dokument-Typs mu� sich innerhalb des Arbeitsbereich des Benutzers befinden, damit der Benutzer den Dokument-Typ ausw�hlen kann.";
	$l_prefs["we_doctype_workspace_behavior_hint1"] = "Der Arbeitsbereich des Benutzers mu� sich innerhalb des im Dokument-Typ eingestellten Standardverzeichnis befinden, damit der Benutzer den Dokument-Typ ausw�hlen kann.";
	$l_prefs["we_doctype_workspace_behavior_1"] = "Umgekehrt";
	$l_prefs["we_doctype_workspace_behavior_0"] = "Standard";
	$l_prefs["we_doctype_workspace_behavior"] = "Verhalten der Dokument-Typ Auswahl";

/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Java-Upload benutzen';
/*****************************************************************************
 * message_reporting
 *****************************************************************************/
	$l_prefs["message_reporting"]["information"] = "�ber die jeweiligen, nachfolgenden Checkboxen k�nnen Sie entscheiden, ob Sie bei den webEdition Aktionen wie z. B. Speichern, Ver�ffentlichen, L�schen usw. einen Hinweis erhalten m�chten.";

	$l_prefs["message_reporting"]["headline"] = "Benachrichtigungen";
	$l_prefs["message_reporting"]["show_notices"] = "Hinweise anzeigen";
	$l_prefs["message_reporting"]["show_warnings"] = "Warnungen anzeigen";
	$l_prefs["message_reporting"]["show_errors"] = "Fehler anzeigen";

/*****************************************************************************
 * Module Activation
 *****************************************************************************/
	$l_prefs["module_activation"]["information"] = "Hier k�nnen Sie die Module aktivieren bzw. deaktivieren wenn Sie diese nicht ben�tigen.<br /><br />Nicht aktivierte Module verbessern die Performance von webEdition.";

	$l_prefs["module_activation"]["headline"] = "Modulaktivierung";

/*****************************************************************************
 * Email settings
 *****************************************************************************/

	$l_prefs["mailer_information"] = "Hier k�nnen Sie einstellen, ob f�r die von webEdition versendeten E-Mails die in PHP integrierte mail()-Funktion oder ein SMTP-Server verwendet werden soll.<br /><br />Durch die Verwendung des \"richtigen\" Mailservers sinkt das Risiko, dass Mails beim Empf�nger als \"Spam\" eingestuft werden.";

	$l_prefs["mailer_type"] = "Mailer-Typ";
	$l_prefs["mailer_php"] = "Benutze php mail() Funktion";
	$l_prefs["mailer_smtp"] = "Benutze SMTP-Server";
	$l_prefs["email"] = "E-Mail";
	$l_prefs["tab_email"] = "E-Mail";
	$l_prefs["smtp_auth"] = "Authentifizierung";
	$l_prefs["smtp_server"] = "SMTP-Server";
	$l_prefs["smtp_port"] = "SMTP-Port";
	$l_prefs["smtp_username"] = "Benutzername";
	$l_prefs["smtp_password"] = "Kennwort";
	$l_prefs["smtp_halo"] = "SMTP-Halo";
	$l_prefs["smtp_timeout"] = "SMTP-Timeout";
	
/*****************************************************************************
 * Versions settings
 *****************************************************************************/

	$l_prefs["versioning"] = "Versionierung";
	$l_prefs["version_all"] = "alle";
	$l_prefs["versioning_activate_text"] = "Aktivieren sie hier die Versionierung entweder f�r alle oder nur bestimmte Inhaltstypen.";
	$l_prefs["versioning_time_text"] = "Bei Angabe eines Zeitraums werden nur Versionen gespeichert, deren Erstellungsdatum sich innerhalb des angegebenen Zeitraums bis heute befindet. �ltere Versionen werden gel�scht.";
	$l_prefs["versioning_time"] = "Zeitraum";
	$l_prefs["versioning_anzahl_text"] = "Geben Sie hier eine Anzahl von Versionen an, die f�r jedes Dokument bzw. Objekt gespeichert werden sollen. ";
	$l_prefs["versioning_anzahl"] = "Anzahl";
	$l_prefs["versioning_wizard_text"] = "�ffnen Sie den Versions-Wizard um Versionen zu l�schen oder �ltere Versionen wiederherzustellen.";
	$l_prefs["versioning_wizard"] = "Versions-Wizard �ffnen";
	$l_prefs["ContentType"] = "Inhaltstyp";
	$l_prefs["versioning_create_text"] = "Legen Sie fest, bei welchen Aktionen Versionen erzeugt werden sollen. Entweder nur beim Ver�ffentlichen oder auch beim Speichern, Parken, L�schen oder Importieren.";
	$l_prefs["versioning_create"] = "Version erstellen";
	$l_prefs["versions_create_publishing"] = "nur beim Ver�ffentlichen";
	$l_prefs["versions_create_always"] = "immer";
	
	
//########### NEU
	$l_prefs['use_jeditor'] = "Benutzen";
	$l_prefs["editor_font_colors"] = 'Schriftfarben spezifizieren';
	$l_prefs["editor_normal_font_color"] = 'Standard';
	$l_prefs["editor_we_tag_font_color"] = 'webEdition-Tags';
	$l_prefs["editor_we_attribute_font_color"] = 'webEdition-Attribute';
	$l_prefs["editor_html_tag_font_color"] = 'HTML-Tags';
	$l_prefs["editor_html_attribute_font_color"] = 'HTML-Attribute';
	$l_prefs["editor_pi_tag_font_color"] = 'PHP Code';
	$l_prefs["editor_comment_font_color"] = 'Kommentare';
	$l_prefs["jeditor"] = 'Java Quelltext Editor';
	

?>