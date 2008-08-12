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
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "Nuevo V�nculo"; // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "�Cargando data!<br>Esto puede tomar tiempo cuando se cargan varios elementos de men� ...";
$GLOBALS["l_global"]["text"] = "Texto";
$GLOBALS["l_global"]["yes"] = "Si";
$GLOBALS["l_global"]["no"] = "No"; // TRANSLATE
$GLOBALS["l_global"]["checked"] = "Chequeado";
$GLOBALS["l_global"]["max_file_size"] = "Tama�o m�ximo de archivo(en bytes)";
$GLOBALS["l_global"]["default"] = "Predefinido";
$GLOBALS["l_global"]["values"] = "Valores";
$GLOBALS["l_global"]["name"] = "Nombre";
$GLOBALS["l_global"]["type"] = "Tipo";
$GLOBALS["l_global"]["attributes"] = "Atributos";
$GLOBALS["l_global"]["formmailerror"] = "La forma no fue propuesta por las siguientes razones:";
$GLOBALS["l_global"]["email_notallfields"] = "UD no ha llenado todos los campos requeridos!";
$GLOBALS["l_global"]["email_ban"] = "UD no tiene los derechos para usar este script!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "La direcci�n del destinatario no es v�lida!";
$GLOBALS["l_global"]["email_no_recipient"] = "La direcci�n del destinatario no existe!";
$GLOBALS["l_global"]["email_invalid"] = "Su <b>direcci�n de E-mail</b> no es v�lida!";
$GLOBALS["l_global"]["question"] = "Pregunta";
$GLOBALS["l_global"]["warning"] = "Advertenc�a";
$GLOBALS["l_global"]["we_alert"] = "Esta funci�n no est� disponible en la versi�n demo de webEdition!";
$GLOBALS["l_global"]["index_table"] = "Tabla del �ndice";
$GLOBALS["l_global"]["cannotconnect"] = "No se puede conectar con el servidor de webEdition!";
$GLOBALS["l_global"]["recipients"] = "Destinatarios de formas de correos";
$GLOBALS["l_global"]["recipients_txt"] = "Por favor, entre todas las direciones de E-mail que recibir�n formularios enviados por las funciones de formas de correos (&lt;we:form type=&quot;formmail&quot; ..&gt;). Si UD no entra una direci�n de E-mail, no podr� enviar formularios usando esta funci�n!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Un nuevo objeto %s de clase %s ha sido creado!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Nuevo objeto";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Nuevo documento";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Un nuevo documento %s ha sido creado!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Objeto borrado";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "El objeto %s ha sido borrado!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Documento borrado";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "El documento %s ha sido borrado!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Nueva p�gina despu�s de salvar";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Ninguna entrada encontrada!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Salve nuevamente los documentos temporales";
$GLOBALS["l_global"]["save_mainTable"] = "Salve nuevamente la tabla principal de la base de datos";
$GLOBALS["l_global"]["add_workspace"] = "Adicionar �rea de trabajo";
$GLOBALS["l_global"]["folder_not_editable"] = "Este directorio no puede ser escogido!";
$GLOBALS["l_global"]["modules"] = "M�dulos";
$GLOBALS["l_global"]["center"] = "Centro";
$GLOBALS["l_global"]["jswin"] = "Ventana Pop-up";
$GLOBALS["l_global"]["open"] = "Abrir";
$GLOBALS["l_global"]["posx"] = "Posici�n x";
$GLOBALS["l_global"]["posy"] = "Posici�n y";
$GLOBALS["l_global"]["status"] = "Estatus";
$GLOBALS["l_global"]["scrollbars"] = "Barras de<br>desplazamiento";
$GLOBALS["l_global"]["menubar"] = "Barra del<br>men�";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Cambiable<br>de tama�o";
$GLOBALS["l_global"]["location"] = "Ubicaci�n";
$GLOBALS["l_global"]["title"] = "Titulo";
$GLOBALS["l_global"]["description"] = "Descripci�n";
$GLOBALS["l_global"]["required_field"] = "Campo requerido";
$GLOBALS["l_global"]["from"] = "De"; 
$GLOBALS["l_global"]["to"] = "A";
$GLOBALS["l_global"]["search"]="Buscar";
$GLOBALS["l_global"]["in"]="en";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Reconstrucci�n autom�tica";
$GLOBALS["l_global"]["we_publish_at_save"] = "Publicar despu�s de salvar";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving"; // TRANSLATE
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving";
$GLOBALS["l_global"]["wrapcheck"] = "Empaque";
$GLOBALS["l_global"]["static_docs"] = "Documentos est�ticos";
$GLOBALS["l_global"]["save_templates_before"] = "Salvar plantillas por adelantado";
$GLOBALS["l_global"]["specify_docs"] = "Documentos con el siguiente criterio";
$GLOBALS["l_global"]["object_docs"] = "Todos los objetos";
$GLOBALS["l_global"]["all_docs"] = "Todos los documentos";
$GLOBALS["l_global"]["ask_for_editor"] = "Preguntar por el editor";             
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Introducci�n";
$GLOBALS["l_global"]["doctypes"] = "Tipos de documentos";
$GLOBALS["l_global"]["content"] = "Contenido";
$GLOBALS["l_global"]["site_not_exist"] = "La p�gina no existe!";
$GLOBALS["l_global"]["site_not_published"] = "P�gina a�n no publicada!";
$GLOBALS["l_global"]["required"] = "Entrada de datos requerida";
$GLOBALS["l_global"]["all_rights_reserved"] = "Todos los derechos reservados";
$GLOBALS["l_global"]["width"] = "Ancho";
$GLOBALS["l_global"]["height"] = "Alto";
$GLOBALS["l_global"]["new_username"] = "Nuevo nombre de usuario";
$GLOBALS["l_global"]["username"] = "Nombre de usuario";
$GLOBALS["l_global"]["password"] = "Contrase�a";
$GLOBALS["l_global"]["documents"] = "Documentos";
$GLOBALS["l_global"]["templates"] = "Plantillas";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "Autorizado a";
$GLOBALS["l_global"]["left"] = "Izquierda";
$GLOBALS["l_global"]["right"] = "Derecha";
$GLOBALS["l_global"]["top"] = "Cima";
$GLOBALS["l_global"]["bottom"] = "Fondo";
$GLOBALS["l_global"]["topleft"] = "Izquierda superior";
$GLOBALS["l_global"]["topright"] = "Derecha superior";
$GLOBALS["l_global"]["bottomleft"] = "Izquierda inferior";
$GLOBALS["l_global"]["bottomright"] = "Derecha inferior";
$GLOBALS["l_global"]["true"] = "Si";
$GLOBALS["l_global"]["false"] = "No"; // TRANSLATE
$GLOBALS["l_global"]["showall"] = "Mostrar todos";
$GLOBALS["l_global"]["noborder"] = "Sin borde";
$GLOBALS["l_global"]["border"] = "Borde";
$GLOBALS["l_global"]["align"] = "Aliniaci�n";
$GLOBALS["l_global"]["hspace"] = "EspacioH";
$GLOBALS["l_global"]["vspace"] = "EspacioV";
$GLOBALS["l_global"]["exactfit"] = "Acomodo exacto";
$GLOBALS["l_global"]["select_color"] = "Seleccionar color";
$GLOBALS["l_global"]["changeUsername"] = "Cambiar nombre de usuario";
$GLOBALS["l_global"]["changePass"] = "Cambiar contrase�a";
$GLOBALS["l_global"]["oldPass"] = "Antigua contrase�a";
$GLOBALS["l_global"]["newPass"] = "Nueva contrase�a";
$GLOBALS["l_global"]["newPass2"] = "Repetir nueva contrase�a";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Las entradas no coinciden!";
$GLOBALS["l_global"]["pass_not_match"] = "Antigua contrase�a incorrecta!";
$GLOBALS["l_global"]["passwd_not_match"] = "Las contrase�as no coinciden!";
$GLOBALS["l_global"]["pass_to_short"] = "La contrase�a debe tener al menos 4 car�cteres!";
$GLOBALS["l_global"]["pass_changed"] = "Contrase�a exitosamente cambiada!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Las contrase�as solo deben contener car�cteres alpha-n�mericos (a-z, A-Z and 0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "Todos";
$GLOBALS["l_global"]["selected"] = "Seleccionado";
$GLOBALS["l_global"]["username_to_short"] = "El nombre de usuario debe tener al menos 4 car�cteres!";
$GLOBALS["l_global"]["username_changed"] = "Nombre de usuario exitosamente cambiado!";
$GLOBALS["l_global"]["published"] = "Publicado";
$GLOBALS["l_global"]["help_welcome"] = "Bienvenido a la Ayuda de webEdition";
$GLOBALS["l_global"]["edit_file"] = "Editar archivo";
$GLOBALS["l_global"]["docs_saved"] = "Documentos exitosamente salvados!";
$GLOBALS["l_global"]["preview"] = "Vista previa";
$GLOBALS["l_global"]["close"] = "Cerrar ventana";
$GLOBALS["l_global"]["loginok"] =  "<strong>Conexi�n con el sistema ok! Por favor, espere!</strong><br>webEdition abrir� en una nueva ventana. Si esa ventana no se abre, asegurece de que UD no ha bloqueado las ventanas pop-up en su navegador!";
$GLOBALS["l_global"]["apple"] = "&#x2318;"; // TRANSLATE
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "CTRL"; // TRANSLATE
$GLOBALS["l_global"]["required_fields"] = "Campos requeridos";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Por el momento, ning�n documento fue cargado.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Abrir/Cerrar";
$GLOBALS["l_global"]["rebuild"] = "Reconstruir";
$GLOBALS["l_global"]["welcome_to_we"] = "Bienvenido a webEdition 3";
$GLOBALS["l_global"]["tofit"] = "Bienvenido a webEdition 3";
$GLOBALS["l_global"]["unlocking_document"] = "Abriendo documento";
$GLOBALS["l_global"]["variant_field"] = "Campo variante";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
?>