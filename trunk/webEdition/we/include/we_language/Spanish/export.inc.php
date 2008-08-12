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
 * Language file: export.inc.php
 * Provides language strings.
 * Language: English
 */
$l_export["auto_selection"] = "Automatic selection"; // TRANSLATE
$l_export["txt_auto_selection"] = "Exportar documentos u objetos automáticamente de acuerdo al tipo de documento o clase.";
$l_export["manual_selection"] = "Selección manual";
$l_export["txt_manual_selection"] = "Exportar manualmente los documentos u objetos seleccionados.";
$l_export["element"] = "Selección de elementos";
$l_export["documents"] = "Documentos";
$l_export["objects"] = "Objetos";
$l_export["step1"] = "Selecionar parámetros";
$l_export["step2"] = "Seleccionar articulos para exportar";
$l_export["step3"] = "Seleccionar parámetros de exportación ";
$l_export["step10"] = "Exportación terminada";
$l_export["step99"] = "Error mientras se exportaba";
$l_export["step99_notice"] = "Exportación no posible";
$l_export["server_finished"] = "El archivo exportado ha sido salvado en el servidor.";
$l_export["backup_finished"] = "La exportación ha sido exitosa.";
$l_export["download_starting"] = "La descarga del archivo exportado ha sido iniciado.<br><br>Si la descarga no se inicia después de 10 segundos,<br>";
$l_export["download"] = "por favor, dar clic aquí.";
$l_export["download_failed"] = "El archivo que UD solicitó no existe o a UD no le está permitido descargarlo.";
$l_export["file_format"] = "Formato de archivo";
$l_export["export_to"] = "Exportar a";
$l_export["export_to_server"] = "Servidor";
$l_export["export_to_local"] = "Disco duro local";
$l_export["cdata"] = "Codificando";
$l_export["export_xml_cdata"] = "Adicionar secciones CDATA";
$l_export["export_xml_entities"] = "Reemplazar entidades";
$l_export["filename"] = "Nombre archivo";
$l_export["path"] = "Ruta de acceso";
$l_export["doctypename"] = "Documentos del tipo de documento";
$l_export["classname"] = "Clase de objetos";
$l_export["dir"] = "Directorio";
$l_export["categories"] = "Categorías";
$l_export["wizard_title"] = "Asistente de Exportación";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Delimitador";
$l_export["csv_enclose"] = "Adjuntar carácter";
$l_export["csv_escape"] = "Evadir carácter";
$l_export["csv_lineend"] = "Formato de archivo";
$l_export["csv_null"] = "Reemplazo Nulo";
$l_export["csv_fieldnames"] = "Colocar nombre de campos en primera fila";
$l_export["windows"] = "Formato de Windows";
$l_export["unix"] = "Formato UNIX";
$l_export["mac"] = "Formato Mac";
$l_export["generic_export"] = "Exportación genérica";
$l_export["title"] = "Asistente de Exportación";
$l_export["gxml_export"] = "Exportación genérica de XML";
$l_export["txt_gxml_export"] = "Exportar documentos y objetos webEdition a un archivo XML \"plano\" (3 niveles).";
$l_export["csv_export"] = "Exportación de CSV";
$l_export["txt_csv_export"] = "Exportar objetos webEdition a un archivo CSV (Valores Separados por Comas).";
$l_export["csv_params"] = "Ajustes";
$l_export["error"] = "El proceso de exportación no fue exitoso!";
$l_export["error_unknown"] = "Un error desconocido ocurrio!";
$l_export["error_object_module"] = "La exportación de documentos a archivos CSV no es actualmente sostenida!<br><br>Dado que el Módulo Base de datos/Objeto no está instalado, la exportación de archivos CSV no está disponible.";
$l_export["error_nothing_selected_docs"] = "La exportación no ha sido ejecutada!<br><br>Ningún documento fue selecionado.";
$l_export["error_nothing_selected_objs"] = "La exportación no ha sido ejecutada!<br><br>Ningún documento u objeto fue selecionado.";
$l_export["error_download_failed"] = "Descarga del archivo exportado fallida.";
$l_export["comma"] = ", {coma}";
$l_export["semicolon"] = "; {punto y coma}";
$l_export["colon"] = ": {dos puntos}";
$l_export["tab"] = "\\t {tabulador}";
$l_export["space"] = "  {espacio}";
$l_export["double_quote"] = "\" {comillas dobles}";
$l_export["single_quote"] = "' {comilla}";
$l_export['we_export'] = 'Exportación de webEdition';
$l_export['wxml_export'] = 'Exportación de XML webEdition';
$l_export['txt_wxml_export'] = 'Exportación de documentos, plantillas, objetos y clases webEdition, correspondiendo a la DTD (definición de tipo de documento) específica de webEdition.';

$l_export['options'] = 'Options'; // TRANSLATE
$l_export['handle_document_options'] = 'Documents'; // TRANSLATE
$l_export['handle_template_options'] = 'Templates'; // TRANSLATE
$l_export['handle_def_templates'] = 'Export default templates'; // TRANSLATE
$l_export['handle_document_includes'] = 'Export included documents'; // TRANSLATE
$l_export['handle_document_linked'] = 'Export linked documents'; // TRANSLATE
$l_export['handle_object_options'] = 'Objects'; // TRANSLATE
$l_export['handle_def_classes'] = 'Export default classes'; // TRANSLATE
$l_export['handle_object_includes'] = 'Export included objects'; // TRANSLATE
$l_export['handle_classes_options'] = 'Classes'; // TRANSLATE
$l_export['handle_class_defs'] = 'Default value'; // TRANSLATE
$l_export['handle_object_embeds'] = 'Export embedded objects'; // TRANSLATE
$l_export['handle_doctype_options'] = 'Doctypes/<br>Categorys/<br>Navigation'; // TRANSLATE
$l_export['handle_doctypes'] = 'Doctypes'; // TRANSLATE
$l_export['handle_categorys'] = 'Categorys'; // TRANSLATE
$l_export['export_depth'] = 'Export depth'; // TRANSLATE
$l_export['to_level'] = 'to level'; // TRANSLATE
$l_export['select_export'] ='Para exportar una entrada, por favor seleccione la casilla apropiada en el árbol. Nota importante: Todas las entradas seleccionadas en todas las ramas serán exportadas y si se exporta un directorio, todos los documentos en ese directorio serán exportados también!';
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = 'No existe nada para eliminar.';
$l_export['nothing_to_save'] = '¡No existe nada para salvar!';
$l_export['no_perms'] = 'No posee permisos!';
$l_export['new'] = 'Nuevo';
$l_export['export'] = 'Exportar';
$l_export['group'] = 'Agrupar';
$l_export['save'] = 'Guardar';
$l_export['delete'] = 'Eliminar';
$l_export['quit'] = 'Salir';
$l_export['property'] = 'Propiedad';
$l_export['name'] = 'Nombre';
$l_export['save_to'] = 'Guardar en:';
$l_export['selection'] = 'Selección';
$l_export['save_ok'] = 'La exportación ha sido guardada.';
$l_export['save_group_ok'] = 'El grupo ha sido guardado.';
$l_export['log'] = 'Detalles';
$l_export['start_export'] = 'Iniciar exportación';
$l_export['prepare'] = 'Preparar exportación...';
$l_export['doctype'] = 'Tipo de documento';
$l_export['category'] = 'Categoría';
$l_export['end_export'] = 'Exportación terminada';
$l_export['newFolder'] = "Nuevo grupo";
$l_export['folder_empty'] = "¡La carpeta está vacía!";
$l_export['folder_path_exists'] = "¡La carpeta ya existe!";
$l_export['wrongtext'] = "Nombre no válido";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "¡La carpeta ya existe!";
$l_export['delete_ok'] = 'La exportación ha sido eliminada.';
$l_export['delete_nok'] = 'ERROR: La exportación no ha sido eliminada';
$l_export['delete_group_ok'] = 'El grupo ha sido eliminado.';
$l_export['delete_group_nok'] = 'ERROR: El grupo no ha sido eliminado';
$l_export['delete_question'] = '¿Desea eliminar la exportación actual?';
$l_export['delete_group_question'] = '¿Desea eliminar el grupo actual?';
$l_export['download_starting2'] = 'La descarga de la exportación ha sido iniciada.';
$l_export['download_starting3'] = 'Si la descarga no se inicia despues de 10 seconds,';
$l_export['working'] = 'Trabajando';

$l_export['txt_document_options'] = 'La plantilla predeterminada es la que está definida en las propiedades del documento. Los documentos incluidos son documentos internos que se incluyen en el documento de exportación con las etiquetas we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js and we:addDelNewsletterEmail. Los objetos incluidos son aquellos que seincluyen en el documento de exportación con las etiquetas we:object and we:form. Los documentos vinculados son documentos internos que se vinculan al el documento de exportación con las etiquetas HTML: body, a, img, table and td.';
$l_export['txt_object_options'] = 'La clase predeterminada está definida en las propiedades del objeto.';
$l_export['txt_exportdeep_options'] = 'La profundidad de exportación define el nivel para la exportación de los documentos incluidos. ¡El valor debe ser un número!';
$l_export['name_empty'] = '¡El campo del nombre no puede estar vacío!';
$l_export['name_exists'] = 'El nombre ya existe!';

$l_export['help'] = 'Ayuda';
$l_export['info'] = 'Información';
$l_export['path_nok'] = '¡El camino no es correcto!';

$l_export['must_save'] = 'La exportación ha sido modificada.\\n¡Debe salvar los datos de exportación antes de poder hacer la exportación!';
$l_export['handle_owners_option'] = 'Datos propietarios';
$l_export['handle_owners'] = 'Exportar datos propietarios';
$l_export['txt_owners'] = 'Exportar datos propietarios vinculados.';

$l_export['weBinary'] = 'File'; // TRANSLATE
$l_export['handle_navigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_export['weThumbnail'] = 'Thumbnails'; // TRANSLATE
$l_export['handle_thumbnails'] = 'Thumbnails'; // TRANSLATE
?>