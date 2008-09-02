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
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: English
 */

$l_workflow["new_workflow"] = "New workflow"; // TRANSLATE
$l_workflow["workflow"] = "Flujo de Trabajo";

$l_workflow["doc_in_wf_warning"] = "El documento se encuentra en el flujo de trabajo";
$l_workflow["message"] = "Mensaje";
$l_workflow["in_workflow"] = "Documento en el flujo de trabajo";
$l_workflow["decline_workflow"] = "Rechazar documento";
$l_workflow["pass_workflow"] = "Reenviar documeto";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "¡El documento fue colocado con éxito en el flujo de trabajo!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "¡El documento no pudo ser colocado en el flujo de trabajo!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "¡El objeto fue colocado con éxito en el flujo de trabajo!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "¡El objeto no pudo ser colocado en el flujo de trabajo!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "¡El objeto fue continuado con éxito!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "¡El objeto no puede ser continuado!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "¡El objeto fue devuelto al autor!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "¡El objeto no puede ser devuelto al autor!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "¡El documento fue continado con éxito!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "¡El documento no puede ser continuado!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "¡El documento fue devuelto al autor!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "¡El documento no puede ser devuelto al autor!";

$l_workflow["no_wf_defined"] = "¡Ningún flujo de trabajo ha sido definido para este documento!";

$l_workflow["document"] = "Documento";

$l_workflow["del_last_step"] = "¡El último paso en serie no puede ser borrado!";
$l_workflow["del_last_task"] = "¡El último paso en paralelo no puede ser borrado!";
$l_workflow["save_ok"] = "El flujo de trabajo fue salvado!";
$l_workflow["delete_ok"] = "El flujo de trabajo fue borrado!";
$l_workflow["delete_nok"] = "El flujo de trabajo no puede ser borrado!";

$l_workflow["name"] = "Nombre";
$l_workflow["type"] = "Tipo";
$l_workflow["type_dir"] = "Basado en directorio";
$l_workflow["type_doctype"] = "Basado en tipo de documento\categoría";
$l_workflow["type_object"] = "Basado en objeto";

$l_workflow["dirs"] = "Directorios";
$l_workflow["doctype"] = "Tipo de documento";
$l_workflow["categories"] = "Categorías";
$l_workflow["classes"] = "Clases";

$l_workflow["active"] = "El flujo de trabajo is activo";

$l_workflow["step"] = "Paso";
$l_workflow["and_or"] = "Y/O";
$l_workflow["worktime"] = "Tiempo de trabajo (Hrs.)";
$l_workflow["user"] = "Usuario";

$l_workflow["edit"] = "Editar";
$l_workflow["send_mail"] = "Enviar E-Mail";
$l_workflow["select_user"] = "Seleccionar usuario";

$l_workflow["and"] = " y ";
$l_workflow["or"] = " o ";

$l_workflow["waiting_on_approval"] = "Esperando por la aprobación de %s";
$l_workflow["status"] = "Estatus";
$l_workflow["step_from"] = "Paso %s de %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "Fecha de inicio del paso";
$l_workflow["step_plan"] = "Fecha de final";
$l_workflow["step_worktime"] = "Tiempo de trabajo planificado";

$l_workflow["current_time"] = "Tiempo actual";
$l_workflow["time_elapsed"] = "Tiempo transcurrido (h:m:s)";
$l_workflow["time_remained"] = "Tiempo restante (h:m:s)";

$l_workflow["todo_subject"] = "Tarea del flujo de trabajo";
$l_workflow["todo_next"] = "Hay un documento esperando por Ud en el flujo de trabajo";

$l_workflow["go_next"] = "Siguiente paso";

$l_workflow["new_step"] = "Crear paso en serie adicional";
$l_workflow["new_task"] = "Crear paso en paralelo adicional";

$l_workflow["delete_step"] = "Borrar paso en serie";
$l_workflow["delete_task"] = "Borrar paso en paralelo";

$l_workflow["save_question"] = "Todos los documentos que están en el flujo de trabajo serán removidos del mismo!\\nContinuar de todas formas?";
$l_workflow["nothing_to_save"] = "Nada para salvar!";
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?"; // TRANSLATE

$l_workflow["delete_question"] = "Todo el data del flujo de trabajo será borrado!\\nContinuar de todas formas?";
$l_workflow["nothing_to_delete"] = "Nada para borrar!";

$l_workflow["user_empty"] = "No se ha definido ningún Usuario para el paso %s.!";
$l_workflow["folders_empty"] = "No se ha definido ningúna carpeta para el flujo de trabajo!";
$l_workflow["objects_empty"] = "No se ha definido ningún objeto para el flujo de trabajo!";
$l_workflow["doctype_empty"] = "No se ha definido ningún tipo de documento o categoría para el flujo de trabajo!";
$l_workflow["worktime_empty"] = "No se ha definido ningún tiempo de trabajo para el paso %s.!";
$l_workflow["name_empty"] = "No se ha definido ningún nombre para el flujo de trabajo!";
$l_workflow["cannot_find_active_step"] = "¡El paso activo no se puede encontrar!";

$l_workflow["no_perms"] = "Sin Permiso";
$l_workflow["plan"] = "(plan)"; // TRANSLATE

$l_workflow["todo_returned"] = "El documento ha sido devuelto desde el flujo de trabajo.";

$l_workflow["description"] = "Descripción";
$l_workflow["time"] = "Tiempo";

$l_workflow["log_approve_force"] = "El usuario ha aprobado el documento forzadamente.";
$l_workflow["log_approve"] = "El usuario ha aprobado el documento.";
$l_workflow["log_decline_force"] = "El usuario ha cancelado el documento forzadamente.";
$l_workflow["log_decline"] = "El usuario ha cancelado el flujo de trabajo del documento.";
$l_workflow["log_doc_finished_force"] = "El flujo de trabajo ha finalizado forzadamente.";
$l_workflow["log_doc_finished"] = "El flujo de trabajo fue finalizado.";
$l_workflow["log_insert_doc"] = "El documento ha sido insertado en el flujo de trabajo.";

$l_workflow["logbook"] = "Diario";
$l_workflow["empty_log"] = "Vaciar Diario";
$l_workflow["emty_log_question"] = "¿Desea UD realmente vaciar el diario?";
$l_workflow["empty_log_ok"] = "El diario fue vaciado.";
$l_workflow["log_is_empty"] = "El diario está vacío.";

$l_workflow["log_question_all"] = "Eliminar todo";
$l_workflow["log_question_time"] = "Eliminar las entradas anteriores a:";
$l_workflow["log_question_text"] = "Escoger opción:";

$l_workflow["log_remove_doc"] = "El documento fue removido del flujo de trabajo";
$l_workflow["action"] = "Acción";

$l_workflow[FILE_TABLE]["messagePath"] = "Documento";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Objeto";
}
$l_workflow["auto_approved"] = "El documento fue aprovado automáticamente";
$l_workflow["auto_declined"] = "El documento fue rechazado automáticamente";

$l_workflow["doc_deleted"] = "El documento fue borrado!";
$l_workflow["ask_before_recover"] = "¡El documento/objeto aún está en el flujo de trabajo! ¿Puede UD sacar estos documentos/objetos del Flujo de Trabajo?";

$l_workflow["double_name"] = "¡El nombre del flujo de trabajo ya existe!";

$l_workflow["more_information"] = "Más información";
$l_workflow["less_information"] = "Menos información";

$l_workflow["no_wf_defined_object"] = "¡Ningún flujo de trabajo ha sido definido para este objeto!";
?>