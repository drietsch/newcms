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
$l_prefs["tab_extensions"] = "Extensiones de archivo";
$l_prefs["tab_editor"] = 'Editor'; // TRANSLATE
$l_prefs["tab_formmail"] = 'Formas de correos';
$l_prefs["formmail_recipients"] = 'Destinatarios de formas de correos';
$l_prefs["tab_proxy"] = 'Servidor proxy';
$l_prefs["tab_advanced"] = 'Advanzada';
$l_prefs["tab_system"] = 'Sistema';
$l_prefs["tab_error_handling"] = 'Manejo de error';
$l_prefs["tab_cockpit"] = 'Cockpit'; // TRANSLATE
$l_prefs["tab_modules"] = 'M�dulos';

/*****************************************************************************
 * USER INTERFACE
 *****************************************************************************/

	/**
	 * LANGUAGE
	 */

	$l_prefs["choose_language"] = "Idioma";
	$l_prefs["language_notice"] = "The language change will only take effect everywhere after restarting webEdition.";

	/**
	 * SEEM
	 */
	$l_prefs["seem"] = "seeMode"; // TRANSLATE
	$l_prefs["seem_deactivate"] = "Desactivar seeMode";
	$l_prefs["seem_startdocument"] = "Documento inicio de seeMode";
	$l_prefs["question_change_to_seem_start"] = "Desea Ud cambiar el documento seleccionado?";

	/**
	 * WINDOW DIMENSION
	 */

	$l_prefs["dimension"] = "Dimensiones de ventana";
	$l_prefs["maximize"] = "M�ximizar";
	$l_prefs["specify"] = "Especificar";
	$l_prefs["width"] = "Ancho";
	$l_prefs["height"] = "Alto";
	$l_prefs["predefined"] = "Dimensiones predefinidas";
	$l_prefs["show_predefined"] = "Mostrar dimensiones predefinidas";
	$l_prefs["hide_predefined"] = "Ocultar dimensiones predefinidas";

	/**
	 * TREE
	 */

	$l_prefs["tree_title"] = "Men� en �rbol";
	$l_prefs["all"] = "Todos";
/*****************************************************************************
 * FILE EXTENSIONS
 *****************************************************************************/

	/**
	 * FILE EXTENSIONS
	 */

	$l_prefs["we_extensions"] = "Extensiones webEdition ";
	$l_prefs["static"] = "P�ginas est�ticas";
	$l_prefs["dynamic"] = "P�ginas din�micas";
	$l_prefs["html_extensions"] = "Extensiones HTML";
	$l_prefs["html"] = "P�ginas HTML";

/*****************************************************************************
 * COCKPIT
 *****************************************************************************/

	/**
	 * Cockpit
	 */

	$l_prefs["cockpit_amount_columns"] = "Columns in the cockpit "; // TRANSLATE

/*****************************************************************************
 * EDITOR
 *****************************************************************************/

	/**
	 * EDITOR PLUGIN
	 */

	$l_prefs["editor_plugin"] = 'PlugIn del Editor';
	$l_prefs["use_it"] = "Usarlo";
	$l_prefs["start_automatic"] = "Iniciar autom�ticamente";
	$l_prefs["ask_at_start"] = 'Preguntar al iniciar cu�l<br>editor ser� usado';
	$l_prefs["must_register"] = 'Debe estar registrado';
	$l_prefs["change_only_in_ie"] = 'Estos ajustes no pueden ser cambiados. El PlugIn del Editor opera solamente con la versi�n Windows del Internet Explorer, Mozilla, Firebird, as� como tambi�n Firefox.';
	$l_prefs["install_plugin"] = 'Para poder usar el PlugIn del Editor, el Mozilla ActiveX PlugIn debe de estar instalado.';
	$l_prefs["confirm_install_plugin"] = 'El Mozilla ActiveX PlugIn le permite correr los controles ActiveX en el navegador Mozilla . Despu�s de la instalaci�n, Ud debe reiniciar su navegador.\\n\\nNota: ActiveX puede ser un riesgo de seguridad!\\n\\nContinuar la instalaci�n?';

	$l_prefs["install_editor_plugin"] = 'Para poder usar el Plugin del editor de webEdition, este debe estar instalado.';
	$l_prefs["install_editor_plugin_text"]= 'El Plugin del editor de webEdition ser� instalado...';

	/**
	 * TEMPLATE EDITOR
	 */

	$l_prefs["editor_font"] = 'Tipo de letra en el editor';
	$l_prefs["editor_fontname"] = 'Tipo de letra';
	$l_prefs["editor_fontsize"] = 'Tama�o de fuente';
	$l_prefs["editor_dimension"] = 'Dimensi�n del Editor';
	$l_prefs["editor_dimension_normal"] = 'Predeterminado';

/*****************************************************************************
 * FORMMAIL RECIPIENTS
 *****************************************************************************/

	/**
	 * FORMMAIL RECIPIENTS
	 */

	$l_prefs["formmail_information"] = "Por favor, entre todas las direcciones de E-Mail que recibir�n los formularios enviadas por la funci�n formas de correos (&lt;we:form type=\"formmail\" ..&gt;).<br><br>Si UD no entra una direcci�n de E-Mail, no podr� mandar formas usando la funci�n de formas de correos!";

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

	$l_prefs["useproxy"] = "Usar servidor proxy para la<br>Actualizaci�n en vivo";
	$l_prefs["proxyaddr"] = "Direcci�n";
	$l_prefs["proxyport"] = "Puerto";
	$l_prefs["proxyuser"] = "Nombre de usuario";
	$l_prefs["proxypass"] = "Contrase�a";

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
	 $l_prefs["safari_wysiwyg"] = "Use el Wysiwyg editor<br>de Safari (versi�n beta)";

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

	$l_prefs["auth"] = "Autentificaci�n HTTP";
	$l_prefs["useauth"] = "El servidor usa autentificaci�n<br>HTTP en el directorio<br>webEdition";
	$l_prefs["authuser"] = "Nombre de usuario";
	$l_prefs["authpass"] = "Contrase�a";

	/**
 	* THUMBNAIL DIR
 	*/
	$l_prefs["thumbnail_dir"] = "Directorio de im�genes en miniatura";

	$l_prefs["pagelogger_dir"] = "Directorio pageLogger";

/*****************************************************************************
 * ERROR HANDLING
 *****************************************************************************/


	$l_prefs['error_no_object_found'] = 'Errorpage for not existing objects'; // TRANSLATE
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
	$l_prefs["error_mail_address"] = "Direci�n";
	$l_prefs["error_mail_not_saved"] = 'Los errores no ser�n enviados a la direcci�n de E-mail dada porque la direcci�n no es correcta!\n\nLa preferencias restantes han sido salvadas exitosamente.';

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

	$l_prefs["module_object"] = "M�dulo Base de datos/Objeto";
	$l_prefs["tree_count"] = "N�mero de objetos mostrados";
	$l_prefs["tree_count_description"] = "Este valor define el n�mero m�ximo de objetos que son mostrados en la navegaci�n a la izquierda.";

/*****************************************************************************
 * BACKUP
 *****************************************************************************/
	$l_prefs["backup"] = "Reserva";
	$l_prefs["backup_slow"] = "Lento";
	$l_prefs["backup_fast"] = "R�pido";
	$l_prefs["performance"] = "Aqui Ud puede ajustar un nivel apropiado de ejecuci�n. El nivel de ejecuci�n debe ser adecuado al sistema de su servidor. Si su sistema tiene recursos limitados (memoria, pausas, etc) Ud debe escoger un nivel menor sino puede escoger un nivel mayor.";
	$l_prefs["backup_auto"]="Auto"; // TRANSLATE

/*****************************************************************************
 * Validation
 *****************************************************************************/
	$l_prefs['validation']='Validaci�n';
	$l_prefs['xhtml_default'] = 'Valor por defecto para el atributo <em>xml</em> en we:Tags';
	$l_prefs['xhtml_debug_explanation'] = '�La depuraci�n de XHTML soportar� su desarrollo de un sitio web xhtml v�lido. La salida de cada we:Tag ser� chequeada para su validez y los atributos mal colocados pueden ser mostrados o removidos. Por favor notar: Esta acci�n puede tardar alg�n tiempo. En consecuencia usted debe activar la depuraci�n xhtml solo durante el desarrollo de su sitio web.';
	$l_prefs['xhtml_debug_headline'] = 'Depuraci�n XHTML';
	$l_prefs['xhtml_debug_html'] = 'Activar depuraci�n XHTML';
	$l_prefs['xhtml_remove_wrong'] = 'Remover atributos no v�lidos';
	$l_prefs['xhtml_show_wrong_headline'] = 'Notificaci�n de atributos no v�lidos';
	$l_prefs['xhtml_show_wrong_html'] = 'Activar';
	$l_prefs['xhtml_show_wrong_text_html'] = 'Como texto';
	$l_prefs['xhtml_show_wrong_js_html'] = 'Como Alerta-JavaScript';
	$l_prefs['xhtml_show_wrong_error_log_html'] = 'En el log (PHP) de error';


/*****************************************************************************
 * max upload size
 *****************************************************************************/
	$l_prefs["we_max_upload_size"]="El tama�o m�ximo de subida<br>mostr�ndose en se�ales";
	$l_prefs["we_max_upload_size_hint"]="(en MByte, 0=automatic)";

/*****************************************************************************
 * we_new_folder_mod
 *****************************************************************************/
	$l_prefs["we_new_folder_mod"]="Derechos de acceso<br>nuevos directorios";
	$l_prefs["we_new_folder_mod_hint"]="(valor predeterminado es 755)";

/*****************************************************************************
* we_doctype_workspace_behavior
*****************************************************************************/

   $l_prefs["we_doctype_workspace_behavior_hint0"] = "El directorio por defecto de un tipo de documento ha de estar localizado dentro del �rea de trabajo del usuario, de esta manera puede seleccionar el tipo de documento correspondiente.";
   $l_prefs["we_doctype_workspace_behavior_hint1"] = "El �rea de trabajo del usuario ha de estar localizada dentro del directorio por defecto definido en el tipo de documento por el usuario pudiendo de esta manera seleccionar el tipo de documento.";
   $l_prefs["we_doctype_workspace_behavior_1"] = "Inverso";
   $l_prefs["we_doctype_workspace_behavior_0"] = "Standard"; // TRANSLATE
   $l_prefs["we_doctype_workspace_behavior"] = "Comportamiento de la selecci�n del tipo de documento";


/*****************************************************************************
 * jupload
 *****************************************************************************/

	$l_prefs['use_jupload'] = 'Use java upload'; // TRANSLATE

?>