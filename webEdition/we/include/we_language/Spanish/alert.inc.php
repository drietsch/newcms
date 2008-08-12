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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: English
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["noRightsToDelete"] = "\\'%s\\' cannot be deleted! You do not have permission to perform this action!";
$l_alert["noRightsToMove"] = "\\'%s\\' cannot be moved! You do not have permission to perform this action!"; // TRANSLATE
$l_alert[FILE_TABLE]["in_wf_warning"] = "El documento debe ser salvado antes de poder ser colocado en el flujo de trabajo!\\Desea UD salvar el documento ahora?";
if( defined("OBJECT_FILES_TABLE") ){
  $l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "El objeto debe ser salvado antes de poder ser colocado en el flujo de trabajo!\\Desea UD salvar el objeto ahora?";
  $l_alert[OBJECT_TABLE]["in_wf_warning"] = "La clase debe ser salvada antes de poder ser colocada en el flujo de trabajo!\\Desea UD salvar la clase ahora?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "La plantilla debe ser salvada antes de poder ser colocada en el flujo de trabajo!\\Desea UD salvar la plantilla ahora?";
$l_alert[FILE_TABLE]["not_im_ws"] = "El archivo no est� situado dentro de su �rea de trabajo!";
$l_alert["folder"]["not_im_ws"] = "La carpeta no est� situado dentro de su �rea de trabajo!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "La plantilla no est� situado dentro de su �rea de trabajo!";
$l_alert["delete_recipient"] = "UD realmente desea borrar la direcci�n de E-mail seleccionada?";
$l_alert["recipient_exists"] = "Esa direcci�n de E-mail ya existe!";
$l_alert["input_name"] = "Entre una nueva direcci�n de E-mail!";
$l_alert['input_file_name'] = "Enter a filename."; // TRANSLATE
$l_alert["max_name_recipient"] = "La direcci�n de E-mail solo debe tener hasta 255 caracteres!";
$l_alert["not_entered_recipient"] = "Ninguna direcci�n de E-mail ha sido entrada!";
$l_alert["recipient_new_name"] = "Cambiar direcci�n de E-mail!";
$l_alert["no_new"]["objectFile"] = "Ud no puede crear nuevos objetos!<br>O Ud no tiene permiso o no hay una clase donde una de sus �reas de trabajo sea v�lida!";
$l_alert["required_field_alert"] = "El campo '%s' es requerido y tiene que ser llenado!";
$l_alert["phpError"] = "webEdition no se puede iniciar!";
$l_alert["3timesLoginError"] = "Conexi�n al sistema fallida '%s' veces! Por favor, espere '%s' minutos e intentelo nuevamente!";
$l_alert["popupLoginError"] = "La ventana de webEdition no se puede abrir\\n\\nwebEdition puede ser iniciado solamente cuando su navegador no bloquea las ventanas pop-up.";
$l_alert['publish_when_not_saved_message'] = "El documento a�n no ha sido salvado! Desea Ud publicarlo de todas formas?";
$l_alert["template_in_use"] = "La plantilla est� siendo usada y no se puede remover!";
$l_alert["no_cookies"] = "UD no tiene cookies activados. Por favor, activar los cookies en su navegador!";
$l_alert["doctype_hochkomma"] = "Nombre inv�lido!Los car�cteres inv�lidos son ' (apostrofe) y , (coma)!";
$l_alert["thumbnail_hochkomma"] = "Nombre inv�lido! Los car�cteres inv�lidos son ' (apostrofe) y , (coma)!";
$l_alert["can_not_open_file"] = "El archivo '%s' no pudo ser abierto!";
$l_alert["no_perms_title"] = "Permiso denegado!";
$l_alert["no_perms_action"] = "You don't have the permission to perform this action."; // TRANSLATE
$l_alert["access_denied"] = "Acceso denegado!";
$l_alert["no_perms"] = "Por favor, contacte al due�o (%s) o a un administrador<br>si necesita acceso!";
$l_alert["temporaere_no_access"] = "Acceso no posible!";
$l_alert["temporaere_no_access_text"] = "El archivo '%s' est� siendo editado por '%s' en este momento.";
$l_alert["file_locked_footer"] = "This document is edited by \"%s\" at the moment."; // TRANSLATE
$l_alert["file_no_save_footer"] = "UD no tiene los permisos para salvar este archivo.";
$l_alert["login_failed"] = "Nombre de usuario y/o contrase�a incorrectos!";
$l_alert["login_failed_security"] = "webEdition no pudo ser iniciado!\\n\\nEl proceso de conexi�n al sistema fue abortado por razones de seguridad, porque el tiempo maximo para conectarse a webEdition ha sido excedido!\\n\\nPor favor, conectarse nuevamente.";
$l_alert["perms_no_permissions"] = "A Ud no le est� permitido ejecutar esta acci�n!";
$l_alert["no_image"] = "El archivo que Ud ha seleccionado no es una imagen!";
$l_alert["delete_ok"] = "Archivos o directorios exitosamente borrados!";
$l_alert["nothing_to_delete"] = "No hay nada marcado para ser borrado!";
$l_alert["delete"] = "Borrar las entradas seleccionadas?\\nDesea Ud continuar?";
$l_alert["delete_folder"] = "Borrar el directorio seleccionado?\\nPor favor, note que: Cuando se borra un directorio, todos los  documentos y directorios dentro del mismo son autom�ticamente borrados!\\nDesea UD continuar?";
$l_alert["delete_nok_error"] = "El archivo '%s' no puede ser borrado.";
$l_alert["delete_nok_file"] = "El archivo '%s' no puede ser borrado.\\nEs posible que est� protegido contra escritura.";
$l_alert["delete_nok_folder"] = "El directorio '%s' no puede ser borrado.\\nEs posible que est� protegido contra escritura.";
$l_alert["delete_nok_noexist"] = "El archivo '%s' no existe!";
$l_alert["noResourceTitle"] = "No Item!";
$l_alert["noResource"] = "The document or directory does not exist!";
$l_alert["move"] = "Move selected entries?\\nDo you want to continue?"; // TRANSLATE
$l_alert["move_ok"] = "Files successfully moved!"; // TRANSLATE
$l_alert["move_duplicate"] = "There are files with the same name in the target directory!\\nThe files cannot be moved."; // TRANSLATE
$l_alert["move_nofolder"] = "The selected files cannot be moved.\\nIt isn't possible to move directories."; // TRANSLATE
$l_alert["move_onlysametype"] = "The selected objects cannnot be moved.\\nObjects can only be moved in there own classdirectory."; // TRANSLATE
$l_alert["move_no_dir"] = "Please choose a target directory!"; // TRANSLATE
$l_alert["nothing_to_move"] = "There is nothing marked to move!"; // TRANSLATE
$l_alert["move_of_files_failed"] = "One or more files couldn't moved! Please move these files manually.\\nThe following files are affected:\\n%s"; // TRANSLATE
$l_alert["template_save_warning"] = "This template is used by %s published documents. Should they be resaved? Attention: This procedure may take some time if you have many documents!"; // TRANSLATE
$l_alert["template_save_warning1"] = "This template is used by one published document. Should it be resaved?"; // TRANSLATE
$l_alert["template_save_warning2"] = "This template is used by other templates and documents, should they be resaved?"; // TRANSLATE
$l_alert["thumbnail_exists"] = 'Esta imagen en miniatura ya existe!';
$l_alert["thumbnail_not_exists"] = 'Esta imagen en miniatura no existe!';
$l_alert["doctype_exists"] = "Este tipo de documento ya existe!";
$l_alert["doctype_empty"] = "UD debe entrar un nombre para el nuevo tipo de documento!";
$l_alert["delete_cat"] = "Ud realmente desea borrar la categor�a seleccionada?";
$l_alert["delete_cat_used"] = "Esta categor�a est� en uso y no puede ser borrada!";
$l_alert["cat_exists"] = "Esta categor�a ya existe!";
$l_alert["cat_changed"] = "La categor�a est� en uso! Salve nuevamente los documentos que est�n usando la categor�a!\\\\nDebe la categor�a ser modificada de todas formas?";
$l_alert["max_name_cat"] = "El nombre de la categor�a debe tener solamente 32 car�cteres!";
$l_alert["not_entered_cat"] = "Ning�n nombre de categor�a ha sido entrado!";
$l_alert["cat_new_name"] = "Entre el nuevo nombre para la categor�a!";
$l_alert["we_backup_import_upload_err"] = "Un error ocurrio mientras se cargaba el archivo de reserva! El tama�o maximo del archivo para cargar es %s. Si su archivo de reserva excede este limite, por favor, cargarlo en el directorio webEdition/we_Backup v�a FTP y escoger '".$l_backup["import_from_server"]."'";
$l_alert["rebuild_nodocs"] = "Ning�n documento se iguala con los atributos seleccionados.";
$l_alert["we_name_not_allowed"] = "Los terminos 'we' and 'webEdition' son palabras reservadas y no deben ser usadas!";
$l_alert["we_filename_empty"] = "Ning�n nombre ha sido entrado para este documento o directorio!";
$l_alert["exit_doc_question_".FILE_TABLE] = "El documento ha sido cambiado.<BR> Desear�a Ud salvar sus cambios?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "La plantilla ha sido cambiada.<BR> Desear�a Ud salvar sus cambios?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "La clase ha sido cambiada.<BR> Desear�a Ud salvar sus cambios?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "El objeto ha sido cambiado.<BR> Desear�a UD salvar sus cambios?";
}
$l_alert["deleteTempl_notok_used"] = "Una o m�s de las plantillas est�n en uso y no podr�an ser borradas";
$l_alert["delete_notok"] = "Error mientras se borraba!";
$l_alert["nothing_to_save"] = "La funci�n de salvar est� desactivada por el momento!";
$l_alert["we_filename_notValid"] = "Nombre de archivo inv�lido\\\\nLos car�cteres v�lidos son alpha-n�mericos, may�sculas y min�sculas, as� como subrayados, gui�n y punto (a-z, A-Z, 0-9, _, -, .)";
$l_alert["empty_image_to_save"] = "La imagen seleccionada est� vacia..\\nContinuar?";
$l_alert["path_exists"] = "El archivo o documento %s no puede ser salvado porque otro documento ya ocupa su lugar!";
$l_alert["folder_not_empty"] = "Uno o m�s directorios no est�n completamente vacios y por lo tanto no pueden ser borrados! Borre los archivos manualmente.\\\\n Los siguientes archivos son efectuados:\\n%s";
$l_alert["name_nok"] = "Los nombres no deben contener car�cteres como '<' o '>'!";
$l_alert["found_in_workflow"] = "Una o m�s entradas seleccionadas est�n en el proceso del flujo de trabajo! Desea Ud removerlas del proceso del flujo de trabajo?";
$l_alert["import_we_dirs"] = "Ud est� tratando de importar desde un directorio webEdition!\\\\n Esos directorios son usados y protejidos por webEdition y por lo tanto no pueden ser usados para importar!";
$l_alert["wrong_file"]["image/*"] = "El archivo no pudo ser guardado. Este archivo no es una imagen o su espacio web est� agotado!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "El archivo no pudo ser guardado. Este archivo no es una pel�cula Flash o no hay espacio suficiente en su disco duro!";
$l_alert["wrong_file"]["video/quicktime"] = "El archivo no pudo ser guardado. Este archivo no es una pel�cula Quicktime o no hay espacio suficiente en su disco duro!";
$l_alert["no_file_selected"] = "Ning�n archivo ha sido selecionado para cargar!";
$l_alert["browser_crashed"] = "La ventana no pudo ser abierta por un error con su navegador!  Por favor, salve su trabajo y reinicie el navegador.";
$l_alert["copy_folders_no_id"] = "Por favor, salve el directorio actual primero!";
$l_alert["copy_folder_not_valid"] =  "El mismo directorio o uno de los directorios primarios no puede ser copiado!";
$l_alert['no_views']['headline'] = '�Atenci�n!';
$l_alert['no_views']['description'] = 'No hay vista disponible para este documento.';
$l_alert['navigation']['last_document'] = 'Ud edita el �ltimo documento.';
$l_alert['navigation']['first_document'] = 'Ud edita el primer documento.';
$l_alert['navigation']['doc_not_found'] = 'No se puede encontrar documento concordante.';
$l_alert['navigation']['no_entry'] = 'Ninguna entrada se encontro en la historia.';
$l_alert['delete_single']['confirm_delete'] = 'Borrar este documento?';
$l_alert['delete_single']['no_delete'] = 'Este documento no puede ser borrado.';
$l_alert['delete_single']['return_to_start'] = 'El documento fue borrado. \\nAtras al documento de inicio de seeMode.';
$l_alert['move_single']['return_to_start'] = 'The document was moved. \\nBack to seeMode startdocument.'; // TRANSLATE
$l_alert['move_single']['no_delete'] = 'This document could not be moved'; // TRANSLATE
$l_alert['cockpit_not_activated'] = 'The action could not be performed because the cockpit is not activated.'; //TRANSLATE
$l_alert['cockpit_reset_settings'] = 'Are you sure to delete the current Cockpit settings and reset the default settings?'; //TRANSLATE
$l_alert['no_cockpit_mode'] = 'Please, switch to the cockpit to add a new widget.'; // TRANSLATE
$l_alert['error_fields_value_not_valid'] = 'Invalid entries in input fields!';

?>