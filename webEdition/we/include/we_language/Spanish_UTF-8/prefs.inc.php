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

$l_prefs["preload"] = "Cargando preferencias, un momento ...";
$l_prefs["preload_wait"] = "Cargando preferencias";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_prefs["save"] = "Salvando preferencias, un momento ...";
$l_prefs["save_wait"] = "Salvando preferencias";

$l_prefs["saved"] = "Las preferencias han sido salvadas exitosamente.";
$l_prefs["saved_successfully"] = "Preferencias salvadas";

/*****************************************************************************
 * TABS
 *****************************************************************************/

$l_prefs["tab_ui"] = "Interfaz del usuario";
$l_prefs["tab_glossary"] = "Glossary"; // TRANSLATE
$l_prefs["tab_extensions"] = "Extensiones de archivo";
$l_prefs["tab_editor"] = 'Editor'; // TRANSLATE
$l_prefs["tab_formmail"] = 'Formas de correos';
$l_prefs["formmail_recipients"] = 'Destinatarios de formas de correos';
$l_prefs["tab_proxy"] = 'Servidor proxy';
$l_prefs["tab_advanced"] = 'Advanzada';
$l_prefs["tab_system"] = 'Sistema';
$l_prefs["tab_error_handling"] = 'Manejo de error';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_cache"] = 'Cache'; // TRANSLATE
$l_prefs["tab_language"] = 'Languages'; // TRANSLATE
$l_prefs["tab_modules"] = 'Módulos';
$l_prefs["tab_versions"] = 'Versioning'; // TRANSLATE

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Idioma";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition."; // TRANSLATE

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode"; // TRANSLATE
	$l_prefs["seem_deactivate"] = "Desactivar seeMode";
	$l_prefs["seem_startdocument"] = "Documento inicio de seeMode";
	$l_prefs["seem_start_type_document"] = "Document"; // TRANSLATE
	$l_prefs["seem_start_type_object"] = "Object"; // TRANSLATE
	$l_prefs["seem_start_type_cockpit"] = "Cockpit"; // TRANSLATE
	$l_prefs["question_change_to_seem_start"] = "Desea Ud cambiar el documento seleccionado?";


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

	$l_prefs["dimension"] = "Dimensiones de ventana";
	$l_prefs["maximize"] = "Máximizar";
	$l_prefs["specify"] = "Especificar";
	$l_prefs["width"] = "Ancho";
	$l_prefs["height"] = "Alto";
	$l_prefs["predefined"] = "Dimensiones predefinidas";
	$l_prefs["show_predefined"] = "Mostrar dimensiones predefinidas";
	$l_prefs["hide_predefined"] = "Ocultar dimensiones predefinidas";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Menú en árbol";
	$l_prefs["all"] = "Todos";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */
	$l_prefs["extensions_information"] = "Set the default file extensions for static and dynamic pages here."; // TRANSLATE
	
	$l_prefs["we_extensions"] = "Extensiones webEdition ";
	$l_prefs["static"] = "Páginas estáticas";
	$l_prefs["dynamic"] = "Páginas dinámicas";
	$l_prefs["html_extensions"] = "Extensiones HTML";
	$l_prefs["html"] = "Páginas HTML";
	
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

	$l_prefs["editor_plugin"] = 'PlugIn del Editor';
	$l_prefs["use_it"] = "Usarlo";
	$l_prefs["start_automatic"] = "Iniciar automáticamente";
	$l_prefs["ask_at_start"] = 'Preguntar al iniciar cuál<br>editor será usado';
	$l_prefs["must_register"] = 'Debe estar registrado';
	$l_prefs["change_only_in_ie"] = 'Estos ajustes no pueden ser cambiados. El PlugIn del Editor opera solamente con la versión Windows del Internet Explorer, Mozilla, Firebird, así como también Firefox.';
	$l_prefs["install_plugin"] = 'Para poder usar el PlugIn del Editor, el Mozilla ActiveX PlugIn debe de estar instalado.';
	$l_prefs["confirm_install_plugin"] = 'El Mozilla ActiveX PlugIn le permite correr los controles ActiveX en el navegador Mozilla . Después de la instalación, Ud debe reiniciar su navegador.\\n\\nNota: ActiveX puede ser un riesgo de seguridad!\\n\\nContinuar la instalación?';

	$l_prefs["install_editor_plugin"] = 'Para poder usar el Plugin del editor de webEdition, este debe estar instalado.';
	$l_prefs["install_editor_plugin_text"]= 'El Plugin del editor de webEdition será instalado...';

	/**
	 * TEMPLATE EDITOR
	 */
	
	$l_prefs["editor_information"] = "Specify font and size which should be used for the editing of templates, CSS- and Java Script files within webEdition.<br /><br />These settings are used for the text editor of the abovementioned file types."; // TRANSLATE
	
	$l_prefs["editor_font"] = 'Tipo de letra en el editor';
	$l_prefs["editor_fontname"] = 'Tipo de letra';
	$l_prefs["editor_fontsize"] = 'Tamaño de fuente';
	$l_prefs["editor_dimension"] = 'Dimensión del Editor';
	$l_prefs["editor_dimension_normal"] = 'Predeterminado';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Por favor, entre todas las direcciones de E-Mail que recibirán los formularios enviadas por la función formas de correos (&lt;we:form type=\"formmail\" ..&gt;).<br><br>Si UD no entra una dirección de E-Mail, no podrá mandar formas usando la función de formas de correos!";

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
	
	$l_prefs["useproxy"] = "Usar servidor proxy para la<br>Actualización en vivo";
	$l_prefs["proxyaddr"] = "Dirección";
	$l_prefs["proxyport"] = "Puerto";
	$l_prefs["proxyuser"] = "Nombre de usuario";
	$l_prefs["proxypass"] = "Contraseña";

/*****************************************************************************
 * ADVANCED
 *****************************************************************************/

	/**
	 * ATTRIBS
	 */

	$l_prefs["default_php_setting"] = "Ajustes predefinidos para<br><em>php</em>-el atributo en we:tags";

	/**
	 * INLINEEDIT
	 */

	 $l_prefs["inlineedit_default"] = "Valor por defecto para el atributo <br><em>inlineedit</em> en <br>&lt;we:textarea&gt;";
	 $l_prefs["inlineedit_default_isp"] = "Editar campos de texto dentro del documento (<em>true</em>) o en una nueva ventana<br />browser  (<em>false</em>)";

	/**
	 * SAFARI WYSIWYG
	 */
	 $l_prefs["safari_wysiwyg"] = "Use el Wysiwyg editor<br>de Safari (versión beta)";

	/**
	 * SHOWINPUTS
	 */
	 $l_prefs["showinputs_default"] = "Valor por defecto para el atributo<br><em>showinputs</em> en<br>&lt;we:img&gt;";

	/**
	 * DATABASE
	 */

	$l_prefs["db_connect"] = "Tipo de conexiones de<br> base de datos";

	/**
	 * HTTP AUTHENTICATION
	 */

	$l_prefs["auth"] = "Autentificación HTTP";
	$l_prefs["useauth"] = "El servidor usa autentificación<br>HTTP en el directorio<br>webEdition";
	$l_prefs["authuser"] = "Nombre de usuario";
	$l_prefs["authpass"] = "Contraseña";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Directorio de imágenes en miniatura";

	$l_prefs["pagelogger_dir"] = "Directorio pageLogger";

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

	$l_prefs["error_use_handler"] = "Usar el proceso de tratamiento<br>de errores de webEdition";

	/**
	 * ERROR TYPES
	 */

	$l_prefs["error_types"] = "Tratar estos errores";
	$l_prefs["error_notices"] = "Avisos";
	$l_prefs["error_warnings"] = "Advertencias";
	$l_prefs["error_errors"] = "Errores";

	$l_prefs["error_notices_warning"] = 'Option for developers! Do not activate on live-systems.'; // TRANSLATE

	/**
	 * ERROR DISPLAY
	 */

	$l_prefs["error_displaying"] = "Desplegando errores";
	$l_prefs["error_display"] = "Mostrar errores";
	$l_prefs["error_log"] = "Reportar errores";
	$l_prefs["error_mail"] = "Enviar un correos";
	$l_prefs["error_mail_address"] = "Direción";
	$l_prefs["error_mail_not_saved"] = 'Los errores no serán enviados a la dirección de E-mail dada porque la dirección no es correcta!\n\nLa preferencias restantes han sido salvadas exitosamente.';

	/**
	 * DEBUG FRAME
	 */

	$l_prefs["show_expert"] = "Mostrar ajustes del experto";
	$l_prefs["hide_expert"] = "Ocultar ajustes del experto";
	$l_prefs["show_debug_frame"] = "Mostrar marco del depurador";
	$l_prefs["debug_normal"] = "En modo normal";
	$l_prefs["debug_seem"] = "En seeMode";
	$l_prefs["debug_restart"] = "Los cambios requieren de un reinicio";

/*****************************************************************************
 * MODULES
 *****************************************************************************/

	/**
	 * OBJECT MODULE
	 */

	$l_prefs["module_object"] = "Módulo Base de datos/Objeto";
	$l_prefs["tree_count"] = "Número de objetos mostrados";
	$l_prefs["tree_count_description"] = "Este valor define el número máximo de objetos que son mostrados en la navegación a la izquierda.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Reserva";
	$l_prefs["backup_slow"] = "Lento";
	$l_prefs["backup_fast"] = "Rápido";
	$l_prefs["performance"] = "Aqui Ud puede ajustar un nivel apropiado de ejecución. El nivel de ejecución debe ser adecuado al sistema de su servidor. Si su sistema tiene recursos limitados (memoria, pausas, etc) Ud debe escoger un nivel menor sino puede escoger un nivel mayor.";
	$l_prefs["backup_auto"]="Auto"; // TRANSLATE

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Validación';
	$l_prefs['xhtml_default'] = 'Valor por defecto para el atributo <em>xml</em> en we:Tags';
	$l_prefs['xhtml_debug_explanation'] = '´La depuración de XHTML soportará su desarrollo de un sitio web xhtml válido. La salida de cada we:Tag será chequeada para su validez y los atributos mal colocados pueden ser mostrados o removidos. Por favor notar: Esta acción puede tardar algún tiempo. En consecuencia usted debe activar la depuración xhtml solo durante el desarrollo de su sitio web.';
	$l_prefs['xhtml_debug_headline'] = 'Depuración XHTML';
	$l_prefs['xhtml_debug_html'] = 'Activar depuración XHTML';
	$l_prefs['xhtml_remove_wrong'] = 'Remover atributos no válidos';
	$l_prefs['xhtml_show_wrong_headline'] = 'Notificación de atributos no válidos';
	$l_prefs['xhtml_show_wrong_html'] = 'Activar';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Como texto';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Como Alerta-JavaScript';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'En el log (PHP) de error';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="El tamaño máximo de subida<br>mostrándose en señales";
	$l_prefs["we_max_upload_size_hint"]="(en MByte, 0=automatic)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Derechos de acceso<br>nuevos directorios";
	$l_prefs["we_new_folder_mod_hint"]="(valor predeterminado es 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "El directorio por defecto de un tipo de documento ha de estar localizado dentro del área de trabajo del usuario, de esta manera puede seleccionar el tipo de documento correspondiente.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "El área de trabajo del usuario ha de estar localizada dentro del directorio por defecto definido en el tipo de documento por el usuario pudiendo de esta manera seleccionar el tipo de documento.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Inverso";
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standard"; // TRANSLATE
   $l_prefs["we_doctype_workspace_behavior"] = "Comportamiento de la selección del tipo de documento";


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