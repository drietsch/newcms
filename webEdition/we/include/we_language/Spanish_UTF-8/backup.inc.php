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

$l_backup["save_not_checked"] = "Ud no ha escogido donde salvar el archivo de reserva!";
$l_backup["wizard_title"] = "Asistente de Importación de Reserva";
$l_backup["wizard_title_export"] = "Asistente de Exportación de Reserva";
$l_backup["save_before"] = "Durante la importación todo el data existente será borrado! Es recomendable que UD salve su data existente primero.";
$l_backup["save_question"] = "Desea Ud salvar el data existente?";
$l_backup["step1"] = "Paso 1/4 - Salvar data existente";
$l_backup["step2"] = "Paso 2/4 - Seleccionar fuente de importación";
$l_backup["step3"] = "Paso 3/4 - Importar data salvado";
$l_backup["step4"] = "Paso 4/4 - Restauración terminada";
$l_backup["extern"] = "Restaurar archivos y carpetas webEdition externos";
$l_backup["settings"] = "Restaurar preferencias";
$l_backup["rebuild"] = "Reconstrucción automática";
$l_backup["select_upload_file"] = "Cargar importación desde archivo local";
$l_backup["select_server_file"] = "Escoja en esta lista el archivo de reserva que Ud desea importar.";
$l_backup["charset_warning"] = "If you encounter problems when restoring a backup, please ensure that the target system uses the same character set as the source system. This applies both to the character set of the database (collation) as well as for the character set of the user interface language!"; // TRANSLATE
$l_backup["finished_success"] = "La importación del data de reserva ha finalizado exitosamente.";
$l_backup["finished_fail"] = "La importación del data de reserva no ha finalizado exitosamente";
$l_backup["question_taketime"] = "La exportación puede tomar algún tiempo.";
$l_backup["question_wait"] = "Por favor, espere!";
$l_backup["export_title"] = "Exportar";
$l_backup["finished"] = "Finalizado";
$l_backup["extern_files_size"] = "Dado que el tamaño máximo del archivo es limitado a %.1f MB (%s byte) por lös ajustes de su base de datos, multiples archivos deben ser creados.";
$l_backup["extern_files_question"] = "Salvar archivos y carpetas webEdition externos";
$l_backup["export_location"] = "Especifique el directorio donde Ud desea salvar el archivo de reserva.";
$l_backup["export_location_server"] = "En el servidor";
$l_backup["export_location_send"] = "En el disco duro local";
$l_backup["can_not_open_file"] = "Incapaz de abrir el archivo '%s'.";
$l_backup["too_big_file"] = "El archivo '%s' no puede ser escrito ya que el tamaño excede el tamaño máximo de archivo.";
$l_backup["cannot_save_tmpfile"] = "Incapaz de crear archivo temporal. Chequear si Ud tiene permisos de escritura sobre %s";
$l_backup["cannot_save_backup"] = "Incapaz de salvar archivo de reserva.";
$l_backup["cannot_send_backup"] = "Incapaz de ejecutar la reserva.";
$l_backup["finish"] = "The backup was successfully created and is ready to download."; // TRANSLATE
$l_backup["finish_error"] = " Error: Incapaz de ejecutar la reserva.";
$l_backup["finish_warning"] = "Advertencia: Reserva completada, sin embargo, algunos archivos pueden no estar completados!";
$l_backup["export_step1"] = "Paso 1 de 2 - Parámetros de exportación";
$l_backup["export_step2"] = "Paso 2 de 2 - Exportación completada";
$l_backup["unspecified_error"] = "Un error desconocido ha ocurrido!";
$l_backup["export_users_data"] = "Salvar data del usuario";
$l_backup["import_users_data"] = "Restaurar data del usuario";
$l_backup["import_from_server"] = "Restaurando data desde el servidor";
$l_backup["import_from_local"] = "Restaurando desde un archivo local";
$l_backup["backup_form"] = "Reserva desde";
$l_backup["nothing_selected"] = "Nada seleccionado!";
$l_backup["query_is_too_big"] = "La reserva contiene un archivo el cual no podría ser restaurado al exceder el limite de %s bytes!";
$l_backup["show_all"] = "Show all files"; // TRANSLATE
$l_backup["import_customer_data"] = "Restaurar data del cliente";
$l_backup["import_shop_data"] = "Restaurar data de compra";
$l_backup["export_customer_data"] = "Salvar data del cliente";
$l_backup["export_shop_data"] = "Salvar data de compra";
$l_backup["working"] = "Trabajando...";
$l_backup["preparing_file"] = "Preparando archivo para importar...";
$l_backup["external_backup"] = "Salvando data externo...";
$l_backup["import_content"] = "Importando contenido";
$l_backup["import_files"] = "Importando archivos";
$l_backup["import_doctypes"] = "Restaurar tipos de documentos";
$l_backup["import_user_data"] = "Restaurar data del usuario";
$l_backup["import_templates"] = "Importando plantillas";
$l_backup["export_content"] = "Exportando contenido";
$l_backup["export_files"] = "Exportando archivos";
$l_backup["export_doctypes"] = "Salvar tipo de documento";
$l_backup["export_user_data"] = "Salvar data del usuario";
$l_backup["export_templates"] = "Exportando plantillas";
$l_backup["download_starting"] = "La descarga del archivo de reserva ha sido iniciada.<br><br>Si la descarga no se inicia después de 10 segundos,<br>";
$l_backup["download"] = "Por favor, hacer clic aquí.";
$l_backup["download_failed"] = "El archivo que Ud solicitó no existe o no le está permitido descargarlo.";
$l_backup["extern_backup_question_exp"] = "Ud seleccionó la opción 'Salvar archivos y carpetas webEdition externos'. Esta opción podría tomar algún tiempo y puede conducir a algunos errores específicos del sistema. Desea Ud proceder de todas formas?";
$l_backup["extern_backup_question_exp_all"] = "Ud seleccionó la opción 'Chequear todos'. Eso también chequea la opción 'Salvar archivos y carpetas webEdition externos'. Esta opción podría tomar tiempo y puede conducir a algunos errores específicos del sistema. <br><br>Desea Ud permitir que 'Salvar archivos y carpetas webEdition externos' sea chequeada de todas formas?";
$l_backup["extern_backup_question_imp"] = "Ud seleccionó la opción 'Restaurar archivos y carpetas webEdition externos'. Esta opción podría tomar tiempo y puede conducir a algunos errores específicos del sistema. Desea Ud proceder de todas formas?";
$l_backup["extern_backup_question_imp_all"] = "Ud seleccionó la opción 'Chequear todos'. Eso también chequea la opción 'Restaurar archivos y carpetas webEdition externos'. Esta opción podría tomar tiempo y puede conducir a algunos errores específicos del sistema. <br><br>Desea Ud permitir que 'Restaurar archivos y carpetas webEdition externos' sea chequeado de todas formas?";
$l_backup["nothing_selected_fromlist"] = "Escoja en la lista el archivo de reserva que Ud desea importar para proceder!";
$l_backup["export_workflow_data"] = "Salvar data del flujo de trabajo";
$l_backup["export_todo_data"] = "Salvar data de tarea\mensajes";
$l_backup["import_workflow_data"] = "Restaurar data del flujo de trabajo";
$l_backup["import_todo_data"] = "Restaurar data de tarea\mensaje";
$l_backup["import_check_all"] = "Chequear todo";
$l_backup["export_check_all"] = "Chequear todo";
$l_backup["import_shop_dep"] = "Ud ha seleccionado la opción 'Restaurar data de compra'. El Módulo Compras necesita el data del cliente y por eso, 'Restaurar data del cliente' ha sido automáticamente seleccionado.";
$l_backup["export_shop_dep"] = "Ud ha seleccionado la opción 'Salvar data de compra'. El Módulo Compras necesita el data del cliente y por eso, 'Salvar data del cliente' ha sido automáticamente seleccionado.";
$l_backup["import_workflow_dep"] = "Ud ha seleccionado la opción 'Restaurar data del flujo de trabajo'. El Módulo Flujo de Trabajo necesita los documentos y el data del usuario y por eso, 'Restaurar documentos y plantillas' y 'Restaurar data del usuario' han sido automáticamente seleccionados.";
$l_backup["export_workflow_dep"] = "Ud ha seleccionado la opción 'Salvar data del flujo de trabajo'. El Módulo Flujo de Trabajo necesita los documentos y el data del usuario y por eso, 'Salvar documentos y plantillas' y 'Salvar data del flujo de trabajo' han sido automáticamente seleccionado.";
$l_backup["import_todo_dep"] = "Ud ha seleccionado la opción 'Restaurar data de tarea\mensaje'. El Módulo Tarea\Mensaje necesita el data del usuario y por eso, 'Restaurar data del usuario' ha sido automáticamente seleccionado.";
$l_backup["export_todo_dep"] = "Ud ha seleccionado la opción 'Salvar data de tarea\mensaje'. El Módulo Tarea\Mensaje necesita el data del usuario y por eso, 'Salvar data del usuario' ha sido automáticamente seleccionado.";
$l_backup["export_newsletter_data"] = "Salvar data del boletín informativo";
$l_backup["import_newsletter_data"] = "Restaurar data del boletín informativo";
$l_backup["export_newsletter_dep"] = "Ud ha seleccionado la opción 'Salvar data del boletín informativo'. El Módulo Hoja Informativa necesita los documentos y el data del usuario y por eso, 'Salvar documentos y plantillas' y 'Salvar data del cliente' ha sido automáticamente seleccionado.";
$l_backup["import_newsletter_dep"] = "Ud ha seleccionado la opción 'Restaurar data del boletín informativo'. El Módulo Hoja Informativa necesita los documentos y el data del usuario y por eso, 'Restaurar documentos y plantillas' y 'Restaurar data del cliente' ha sido automáticamente seleccionado.";
$l_backup["warning"] = "Advertencia";
$l_backup["error"] = "Error"; // TRANSLATE
$l_backup["export_temporary_data"] = "Salvar data temporal";
$l_backup["import_temporary_data"] = "Restaurar data temporal";
$l_backup["export_banner_data"] = "Salvar data de la pancarta";
$l_backup["import_banner_data"] = "Restaurar data de la pancarta";
$l_backup["export_prefs"] = "Preferencias al salvar";
$l_backup["import_prefs"] = "Preferencias al restaurar";
$l_backup["export_links"] = "Salvar vínculos";
$l_backup["import_links"] = "Restaurar vínculos";
$l_backup["export_indexes"] = "Salvar índices";
$l_backup["import_indexes"] = "Restaurar índices";
$l_backup["filename"] = "Nombre de archivo";
$l_backup["compress"] = "Comprimir";
$l_backup["decompress"] = "Descomprimir";
$l_backup["option"] = "Opciones de reserva";
$l_backup["filename_compression"] = "Aqui puede Ud entrar un nombre para el archivo destino de reserva y habilitar la compresión. El archivo será comprimido usando la compresión gzip y el archivo resultante tendrá la extensión .gz. Esta acción puede tomar unos minutos.<br>Si la reserva no fue exitosa, por favor, trate de cambiar los ajustes.";
$l_backup["export_core_data"] = "Salvar documentos y plantillas";
$l_backup["import_core_data"] = "Restaurar documentos y plantillas";
$l_backup["export_object_data"] = "Salvar objetos and clases";
$l_backup["import_object_data"] = "Restaurar objetos and clases";
$l_backup["export_binary_data"] = "Salvar data binario";
$l_backup["import_binary_data"] = "Restaurar data binario";
$l_backup["export_schedule_data"] = "Salvar data del planificador";
$l_backup["import_schedule_data"] = "Restaurar data del planificador";
$l_backup["export_settings_data"] = "Salvar ajustes";
$l_backup["import_settings_data"] = "Restaurar ajustes";
$l_backup["export_extern_data"] = "Salvar archivo/carpetas externos";
$l_backup["import_extern_data"] = "Restaurar archivo/carpetas externos";
$l_backup["export_binary_dep"] = "Ud ha seleccionado la opción 'Salvar data binario'. El data binario necesita los documentos y por eso, 'Salvar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["import_binary_dep"] = "Ud ha seleccionado la opción 'Restaurar data binario'. El data binario necesita el data de los documentos y por eso, 'Restaurar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["export_schedule_dep"] = "Ud ha seleccionado la opción 'Salvar data del planificador'. El Módulo Planificador necesita los documentos y por eso, 'Salvar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["import_schedule_dep"] = "Ud ha seleccionado la opción 'Restaurar data del planificador'. El Módulo Planificador necesita el data de los documentos y por eso, 'Restaurar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["export_temporary_dep"] = "Ud ha seleccionado la opción 'Salvar data temporal'. El data temporal necesita los documentos y por eso, 'Salvar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["import_temporary_dep"] = "Ud ha seleccionado la opción 'Restaurar data temporal'. El data temporal necesita el data de los documentos y por eso, 'Restaurar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["compress_file"] = "Comprimir archivo";
$l_backup["export_options"] = "Seleccionar el data que debe ser salvado.";
$l_backup["import_options"] = "Seleccionar el data que debe ser restaurado.";
$l_backup["extern_exp"] = "Esta opción puede tomar algún tiempo y conducir a errores especificos del sistema.";
$l_backup["unselect_dep2"] = "Ud ha cancelado la selección de '%s'. Las opciones que le siguén serán automáticamente canceladas.";
$l_backup["unselect_dep3"] = "Esta opción puede ser seleccionada nuevamente.";
$l_backup["gzip"] = "gzip"; // TRANSLATE
$l_backup["zip"] = "zip"; // TRANSLATE
$l_backup["bzip"] = "bzip"; // TRANSLATE
$l_backup["none"] = "ninguno";
$l_backup["cannot_split_file"] = "El archivo '%s' no se puede preparar para ser restaurado!";
$l_backup["cannot_split_file_ziped"] = "El archivo ha sido comprimido con métodos de compresión infundados.";
$l_backup["export_banner_dep"] = "Ud ha seleccionado la opción 'Salvar data de la pancarta'. El data data de la pancarta necesita los documentos y por eso, 'Salvar documentos y plantillas' ha sido automáticamente seleccionado.";
$l_backup["import_banner_dep"] = "Ud ha seleccionado la opción 'Restaurar data de la pancarta'. El data data de la pancarta necesita los documentos y por eso, 'Salvar documentos y plantillas' ha sido automáticamente seleccionado.";

$l_backup["delold_notice"] = "Es recomendable que Ud borre los archivos viejos en su servidor para tener mas espacio libre.<br>Desea Ud continuar?";
$l_backup["delold_confirm"] = "Todo el data existente será borrado!\\nEstá Ud seguro?";
$l_backup["delete_entry"] = "Borrar %s";
$l_backup["delete_nok"] = "Los archivos no pueden ser borrados!";
$l_backup["nothing_to_delete"] = "No hay nada para borrar!";

$l_backup["files_not_deleted"] = "Uno o mas archivos no pueden ser borrados! Es posible que estén protegidos contra escritura. Borre los archivos manualmente. Los siguientes archivos son afectados:";

$l_backup["delete_old_files"]="Delete old files..."; // TRANSLATE

$l_backup["export_configuration_data"]="Save configuration"; // TRANSLATE
$l_backup["import_configuration_data"]="Restore configuration"; // TRANSLATE

$l_backup["import_export_data"] = "Restaurar datos de exportación";
$l_backup["export_export_data"] = "Guardar datos de exportación";

$l_backup["export_versions_data"] = "Save version data"; // TRANSLATE
$l_backup["export_versions_binarys_data"] = "Save Version-Binary-Files"; // TRANSLATE
$l_backup["import_versions_data"] = "Restore version data"; // TRANSLATE
$l_backup["import_versions_binarys_data"] = "Restore Version-Binary-Files"; // TRANSLATE

$l_backup["export_versions_dep"] = "You have selected the option 'Save version data'. The version data need the documents, objects and version-binary-files and because of that, 'Save documents and templates', 'Save object and classes' and 'Save Version-Binary-Files' has been automatically selected."; // TRANSLATE
$l_backup["import_versions_dep"] = "You have selected the option 'Restore version data'. The version data need the documents data, object data an version-binary-files and because of that, 'Restore documents and templates', 'Restore objects and classes and 'Restore Version-Binary-Files' has been automatically selected."; // TRANSLATE

$l_backup["export_versions_binarys_dep"] = "You have selected the option 'Save Version-Binary-Files'. The Version-Binary-Files need the documents, objects and version data and because of that, 'Save documents and templates', 'Save object and classes' and 'Save version data' has been automatically selected."; // TRANSLATE
$l_backup["import_versions_binarys_dep"] = "You have selected the option 'Restore Version-Binary-Files'. The Version-Binary-Files need the documents data, object data an version data and because of that, 'Restore documents and templates', 'Restore objects and classes and 'Restore version data' has been automatically selected."; // TRANSLATE

$l_backup["del_backup_confirm"] = "¿Desea eliminar la copia de seguridad seleccionada?";
$l_backup["name_notok"] = "¡El nombre del fichero no es correcto!";
$l_backup["backup_deleted"] = "La copia de seguridad %s ha sido eliminada";
$l_backup['error_delete'] = "¡La copia de seguridad no puede ser eliminada! Intente eliminarla en la carpeta /webEdition/we_backup del servidor FTP.";

$l_backup['core_info'] = 'Todos los documentos y plantillas.';
$l_backup['object_info'] = 'Objetos y Clases del Módulo de Base Datos/Objetos.';
$l_backup['binary_info'] = 'Datos Binarios - Imágenes, PDFs y otros documentos.';
$l_backup['user_info'] = 'Datos de usuarios y cuentas del Módulo Gestión de Cliente.';
$l_backup['customer_info'] = 'Datos de clientes y cuentas del Módulo Gestión de Cliente.';
$l_backup['shop_info'] = 'Pedidos del Módulo Compras.';
$l_backup['workflow_info'] = 'Datos del Módulo Flujo de Trabajo.';
$l_backup['todo_info'] = 'Mensajes y tareas del Módulo Tareas/Mensajería.';
$l_backup['newsletter_info'] = 'Datos del Módulo Boletín Informativo.';
$l_backup['banner_info'] = 'Banner y estadístiscas del Módulo Pancarta/Estadísticas.';
$l_backup['schedule_info'] = 'Datos programados del Módulo Planificador.';
$l_backup['settings_info'] = 'Configuraciones de la aplicación webEdition.';
$l_backup['temporary_info'] = 'Datos de documentos y objetos no publicados.';
$l_backup['export_info'] = 'Datos del Módulo Exportación.';
$l_backup['glossary_info'] = 'Data from the glossary.'; // TRANSLATE
$l_backup['versions_info'] = 'Data from Versioning.'; // TRANSLATE
$l_backup['versions_binarys_info'] = 'This option could take some time and memory because the folder "'.VERSION_DIR.'" could be very large. It is recommended to save this folder manually.'; // TRANSLATE


$l_backup["import_voting_data"] = "Restaurar datos de la votación";
$l_backup["export_voting_data"] = "Salvar datos de la votación";
$l_backup['voting_info'] = 'Datos del módulo de votación.';

$l_backup['we_backups'] = 'Copias de seguridad de webEdition';
$l_backup['other_files'] = 'Otros ficheros';

$l_backup['filename_info'] = 'Entre el nombre del archivo de copia.';
$l_backup['backup_log_exp'] = 'El diario sera guardado en /webEdition/we_backup/tmp/lastlog.php';
$l_backup['export_backup_log'] = 'Crear diario';

$l_backup['download_file'] = 'Descargar Archivo';

$l_backup['import_file_found'] = 'El archivo parece un archivo de importación de webEdition. Por favor use la opción \"Importación/Exportación\" del menú \"Archivo\" para importar los datos.';
$l_backup['customer_import_file_found'] = 'El archivo parece un archivo de importación con datos del cliente. Por favor use la opción \"Importación/Exportación\" del módulo Gestión de Cliente (PRO) para importar los datos.';
$l_backup['import_file_found_question'] = '¿Desea cerrar ahora la ventana de diálogo actual y comenzar el asistente de importación/exportación?';
$l_backup['format_unknown'] = '¡El formato del archivo es desconocido!';
$l_backup['upload_failed'] = 'El archivo no puede ser subido. Por favor verifique si el tamaño del archivo es más grande que %s';
$l_backup['file_missing'] = '¡El archivo de copia no se encuentra!';
$l_backup['recover_option'] = 'Opciones de importación';

$l_backup['no_resource'] = 'Fatal Error: There are not enough resources to finish the backup!'; // TRANSLATE
$l_backup['error_compressing_backup'] = 'An error occured while compressing the backup, so the backup could not be finished!'; // TRANSLATE
$l_backup['error_timeout'] = 'An timeout occured while creating the backup, so the backup could not be finished!'; // TRANSLATE

$l_backup["export_spellchecker_data"] = "Save spellchecker data"; // TRANSLATE
$l_backup["import_spellchecker_data"] = "Restore spellchecker data"; // TRANSLATE
$l_backup['spellchecker_info'] = 'Data for spellchecker: settings, general and personal dictionaries'; // TRANSLATE

$l_backup["import_banner_data"] = "Restaurar data de la pancarta";
$l_backup["export_banner_data"] = "Salvar data de la pancarta";

$l_backup["export_glossary_data"] = "Save glossary data"; // TRANSLATE
$l_backup["import_glossary_data"] = "Restore glossary data"; // TRANSLATE

$l_backup["protect"] = "Protect backup file"; // TRANSLATE
$l_backup["protect_txt"] = "The backup file will be protected from unprivileged download with additional php code. This protection requires additional disk space for import!"; // TRANSLATE

$l_backup["recover_backup_unsaved_changes"] = "Some open files have unsaved changes. Please check these before you continue."; // TRANSLATE
$l_backup["file_not_readable"] = "The backup file is not readable. Please check the file permissions."; // TRANSLATE

$l_backup["tools_import_desc"] = "Here you can restore webEdition tools data. Please select the desired tools from the list."; // TRANSLATE
$l_backup["tools_export_desc"] = "Here you can save webEdition tools data. Please select the desired tools from the list."; // TRANSLATE

$l_backup['ftp_hint'] = "Attention! Use the Binary mode for the download by FTP if the backup file is zip compressed! A download in ASCII 	mode destroys the file, so that it cannot be recovered!"; // TRANSLATE

?>