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
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_prefs["preload"] = "Chargement des préférences en cours, un moment s'il vous plaît ...";
$l_prefs["preload_wait"] = "Chargement des préférences";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Enregistrement des préférences en cours, un moment s'il vous plaît ...";
$l_prefs["save_wait"] = "Enregistrement des préférence";

$l_prefs["saved"] = "Les préférences ont été enregistré avec succès.";
$l_prefs["saved_successfully"] = "Préférences enregistrés";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Surface";
$l_prefs["tab_glossary"] = "Glossary"; // TRANSLATE
$l_prefs["tab_extensions"] = "Extensions de fichier";
$l_prefs["tab_editor"] = 'Editeur';
$l_prefs["tab_formmail"] = 'Formmail'; // TRANSLATE
$l_prefs["formmail_recipients"] = 'Destinataire-Formmail';
$l_prefs["tab_proxy"] = 'Server-Proxy';
$l_prefs["tab_advanced"] = 'Avancé';
$l_prefs["tab_system"] = 'Système';
$l_prefs["tab_error_handling"] = 'Traitement des Erreurs';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_cache"] = 'Cache'; // TRANSLATE
$l_prefs["tab_language"] = 'Languages'; // TRANSLATE
$l_prefs["tab_modules"] = 'Modules'; // TRANSLATE
$l_prefs["tab_versions"] = 'Versioning'; // TRANSLATE

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Langue";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition."; // TRANSLATE

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode"; // TRANSLATE
	$l_prefs["seem_deactivate"] = "désactiver  le seeMode ";
	$l_prefs["seem_startdocument"] = "Page d'accueil du seeMode ";
	$l_prefs["seem_start_type_document"] = "Document"; // TRANSLATE
	$l_prefs["seem_start_type_object"] = "Object"; // TRANSLATE
	$l_prefs["seem_start_type_cockpit"] = "Cockpit"; // TRANSLATE
	$l_prefs["question_change_to_seem_start"] = "Voulez-vous changer au document choisi?";


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

	$l_prefs["dimension"] = "Taille de la fenêtre";
	$l_prefs["maximize"] = "Maximaliser";
	$l_prefs["specify"] = "Spécifier";
	$l_prefs["width"] = "Largeur";
	$l_prefs["height"] = "Hauteur";
	$l_prefs["predefined"] = "Tailles préréglées";
	$l_prefs["show_predefined"] = "Afficher les tailles préréglées";
	$l_prefs["hide_predefined"] = "Cacher les tailles préréglées";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Menu d'abre";
	$l_prefs["all"] = "Tous";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */
	$l_prefs["extensions_information"] = "Set the default file extensions for static and dynamic pages here."; // TRANSLATE
	
	$l_prefs["we_extensions"] = "Extension-webEdition";
	$l_prefs["static"] = "Sites statiques";
	$l_prefs["dynamic"] = "Sites dynamiques";
	$l_prefs["html_extensions"] = "Extension-HTML";
	$l_prefs["html"] = "Site-HTML";
	
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

	$l_prefs["editor_plugin"] = 'PlugIn-Editeur';
	$l_prefs["use_it"] = "Utiliser";
	$l_prefs["start_automatic"] = "Démarrer automatiquement";
	$l_prefs["ask_at_start"] = 'En démarrant demander,<br>quel editeur doit<br>être utilisé';
	$l_prefs["must_register"] = 'Doit être enregistré';
	$l_prefs["change_only_in_ie"] = 'Comme le PlugIn Editor fonctionne seulement sous Windows dans le Internet Explorer, Mozilla, Firebird et Firefox ces préférences ne sont pas modifiables.';
	$l_prefs["install_plugin"] = 'Pour que vous puissiez utiliser le Plugin-Editeur avec votre Navigateur, il est nécéssaire d\'installer le PlugIn ActiveX pour Mozilla.';
	$l_prefs["confirm_install_plugin"] = 'Le PlugIn ActiveX pour Mozilla , permet d\'intégrer des Controles ActiveX dans le navigateur Mozilla. Le navigateur doit être redémarré après l\'installation .\\n\\nConsidérez: ActiveX peut-être un risque pour la sécurité!\\n\\nContinuer avec l\'installation?';

	$l_prefs["install_editor_plugin"] = 'Pour que vous puissiez utilisé le PlugIn dans votre navigateur, vous deviez l\'installer d\'abord.';
	$l_prefs["install_editor_plugin_text"]= 'Le Plugin-Editeur de webEdition est installé...';

	/**
	 * TEMPLATE EDITOR
	 */
	
	$l_prefs["editor_information"] = "Specify font and size which should be used for the editing of templates, CSS- and Java Script files within webEdition.<br /><br />These settings are used for the text editor of the abovementioned file types."; // TRANSLATE
	
	$l_prefs["editor_font"] = 'Police dans l\'editeur';
	$l_prefs["editor_fontname"] = 'Type de Police';
	$l_prefs["editor_fontsize"] = 'Taille';
	$l_prefs["editor_dimension"] = 'Taille de l\'editeur';
	$l_prefs["editor_dimension_normal"] = 'Normal';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Saisissez ici tous les adresses e-mail, aux quelles des formulaires avec la fonction-formmail  (&lt;we:form type=\"formmail\" ..&gt;) sont être envoyés.<br><br>Si aucune adresse e-mail est saisie ici, il n'est pas possible d'envoyer des formulaires avec la fonction-Formmail!";

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
	$l_prefs["formmailViaWeDoc"] = "Call formmail via webEdition-Dokument."; // TRANSLATE
	$l_prefs["never"] = "never"; // TRANSLATE
	$l_prefs["1_day"] = "1 day"; // TRANSLATE
	$l_prefs["more_days"] = "%s days"; // TRANSLATE
	$l_prefs["1_week"] = "1 week"; // TRANSLATE
	$l_prefs["more_weeks"] = "%s weeks"; // TRANSLATE
	$l_prefs["1_year"] = "1 year"; // TRANSLATE
	$l_prefs["more_years"] = "%s years"; // TRANSLATE
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
	
	$l_prefs["useproxy"] = "Utiliser un Server-Proxy pour<br>la mise à jour en direct";
	$l_prefs["proxyaddr"] = "Adresse";
	$l_prefs["proxyport"] = "Port"; // TRANSLATE
	$l_prefs["proxyuser"] = "Nom d'utilisateur";
	$l_prefs["proxypass"] = "Mot de passe";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Préférences standard pour l'attribut-<br><em>php</em> dans les we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Préférences standard pour<br>l'attribut-<em>inlineedit</em> dans la <br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Champs de texte dans le site (true) ou dans un <br />nouveau fenêtre (false) ouvrir";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Emploi l´editeur WYSIWYG (vérsion beta)";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Préférences standard pour l'attribut<br><em>showinputs</em> dans <br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Type de connexion-<br>de base de données";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "Authentification HTTP";
	$l_prefs["useauth"] = "Le serveur utilise <br>l'authentification HTTP dans <br>le répertoire webEdition";
	$l_prefs["authuser"] = "Nom d'utilisateur";
	$l_prefs["authpass"] = "Mot de passe";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Thumbnail directory"; // TRANSLATE

	$l_prefs["pagelogger_dir"] = "Répertoire de pageLogger";

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

	$l_prefs["error_use_handler"] = "Activer le traitement des<br>erreurs de webEdition ";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Erreurs à traiter";
	$l_prefs["error_notices"] = "Renseignements";
	$l_prefs["error_warnings"] = "Avertissements";
	$l_prefs["error_errors"] = "Erreurs";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.'; // TRANSLATE

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Affichage d'erreur";
	$l_prefs["error_display"] = "Afficher les erreurs";
	$l_prefs["error_log"] = "Protocoler les erreurs";
	$l_prefs["error_mail"] = "Envoyer les erreurs par e-mail";
	$l_prefs["error_mail_address"] = "Adresse";
	$l_prefs["error_mail_not_saved"] = 'Les erreurs ne vont pas être envoyé à l\'adresse insérere parce que l\'adresse est défectueux!\n\nLes autres préférences ont été enregistrées avec succès.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Afficher les préférences d'expert";
	$l_prefs["hide_expert"] = "Cacher les préférences d'expert";
	$l_prefs["show_debug_frame"] = "afficher le Debug-Frame ";
	$l_prefs["debug_normal"] = "Dans mode normal";
	$l_prefs["debug_seem"] = "Dans le SeeMode";
	$l_prefs["debug_restart"] = "Les changement demandent un nouveau démarrage";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "Module de base de données-/ Objects";
	$l_prefs["tree_count"] = "Nombre des objects à afficher";
	$l_prefs["tree_count_description"] = "Cette valeure définit le nombre maximal des entrées affichées dans la navigation gauche.";

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
	$l_prefs['validation']='Validation'; // TRANSLATE
	$l_prefs['xhtml_default'] = 'Préférences standard pour l\'attribut <em>xml</em> dans les we:Tags';
	$l_prefs['xhtml_debug_explanation'] = 'Le Débogage-XHTML vous aide à créer des site-web valide. Optionel chaque édition d\'un we:Tag peut être vérifié sur sa validité 	et si besoin sur des attributs défectueux. Considérez s\'il vous plaît que ce processus nécessite du temps et il considerable d\'effectuer cette option seulement quand vous créez un nouveau site.';
	$l_prefs['xhtml_debug_headline'] = 'Débogage-XHTML';
	$l_prefs['xhtml_debug_html'] = 'Activer le Débogage-XHTML ';
	$l_prefs['xhtml_remove_wrong'] = 'Enlever les attributs défectueux';
	$l_prefs['xhtml_show_wrong_headline'] = 'Notification en cas d\'attributs défectueux';
	$l_prefs['xhtml_show_wrong_html'] = 'Activer';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Comme texte';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Comme Message-JavaScript';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'Dans le Error-Log (PHP)';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="Taille maximale de téléchargement<br>dans les textes de notification";
	$l_prefs["we_max_upload_size_hint"]="(en Mega Octet, 0=automatique)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Droits d'accès pour des<br>nouveauxnew répertoires.";
	$l_prefs["we_new_folder_mod_hint"]="(stander est 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "Le répertoire standard d'un type-de-document doit être dans l'éspace de travail de l'utilisateur, pour que l'utilisateur puisse choisir le type-de-document.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "L'éspace de travail doit être dans le répertoire standard de l'utilisateur, pour que l'utilisateur puisse  choisir le type-de-document.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Inverse"; // TRANSLATE
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standard"; // TRANSLATE
   $l_prefs["we_doctype_workspace_behavior"] = "Comportement du choix du type-de-document";


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

	$l_prefs["juplod_not_installed"] = 'JUpload is not installed!'; //TRANSLATE
	
?>