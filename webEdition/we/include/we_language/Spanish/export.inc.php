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
$l_export["txt_auto_selection"] = "Exportar documentos u objetos autom�ticamente de acuerdo al tipo de documento o clase.";
$l_export["manual_selection"] = "Selecci�n manual";
$l_export["txt_manual_selection"] = "Exportar manualmente los documentos u objetos seleccionados.";
$l_export["element"] = "Selecci�n de elementos";
$l_export["documents"] = "Documentos";
$l_export["objects"] = "Objetos";
$l_export["step1"] = "Selecionar par�metros";
$l_export["step2"] = "Seleccionar articulos para exportar";
$l_export["step3"] = "Seleccionar par�metros de exportaci�n ";
$l_export["step10"] = "Exportaci�n terminada";
$l_export["step99"] = "Error mientras se exportaba";
$l_export["step99_notice"] = "Exportaci�n no posible";
$l_export["server_finished"] = "El archivo exportado ha sido salvado en el servidor.";
$l_export["backup_finished"] = "La exportaci�n ha sido exitosa.";
$l_export["download_starting"] = "La descarga del archivo exportado ha sido iniciado.<br><br>Si la descarga no se inicia despu�s de 10 segundos,<br>";
$l_export["download"] = "por favor, dar clic aqu�.";
$l_export["download_failed"] = "El archivo que UD solicit� no existe o a UD no le est� permitido descargarlo.";
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
$l_export["categories"] = "Categor�as";
$l_export["wizard_title"] = "Asistente de Exportaci�n";
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Delimitador";
$l_export["csv_enclose"] = "Adjuntar car�cter";
$l_export["csv_escape"] = "Evadir car�cter";
$l_export["csv_lineend"] = "Formato de archivo";
$l_export["csv_null"] = "Reemplazo Nulo";
$l_export["csv_fieldnames"] = "Colocar nombre de campos en primera fila";
$l_export["windows"] = "Formato de Windows";
$l_export["unix"] = "Formato UNIX";
$l_export["mac"] = "Formato Mac";
$l_export["generic_export"] = "Exportaci�n gen�rica";
$l_export["title"] = "Asistente de Exportaci�n";
$l_export["gxml_export"] = "Exportaci�n gen�rica de XML";
$l_export["txt_gxml_export"] = "Exportar documentos y objetos webEdition a un archivo XML \"plano\" (3 niveles).";
$l_export["csv_export"] = "Exportaci�n de CSV";
$l_export["txt_csv_export"] = "Exportar objetos webEdition a un archivo CSV (Valores Separados por Comas).";
$l_export["csv_params"] = "Ajustes";
$l_export["error"] = "El proceso de exportaci�n no fue exitoso!";
$l_export["error_unknown"] = "Un error desconocido ocurrio!";
$l_export["error_object_module"] = "La exportaci�n de documentos a archivos CSV no es actualmente sostenida!<br><br>Dado que el M�dulo Base de datos/Objeto no est� instalado, la exportaci�n de archivos CSV no est� disponible.";
$l_export["error_nothing_selected_docs"] = "La exportaci�n no ha sido ejecutada!<br><br>Ning�n documento fue selecionado.";
$l_export["error_nothing_selected_objs"] = "La exportaci�n no ha sido ejecutada!<br><br>Ning�n documento u objeto fue selecionado.";
$l_export["error_download_failed"] = "Descarga del archivo exportado fallida.";
$l_export["comma"] = ", {coma}";
$l_export["semicolon"] = "; {punto y coma}";
$l_export["colon"] = ": {dos puntos}";
$l_export["tab"] = "\\t {tabulador}";
$l_export["space"] = "  {espacio}";
$l_export["double_quote"] = "\" {comillas dobles}";
$l_export["single_quote"] = "' {comilla}";
$l_export['we_export'] = 'Exportaci�n de webEdition';
$l_export['wxml_export'] = 'Exportaci�n de XML webEdition';
$l_export['txt_wxml_export'] = 'Exportaci�n de documentos, plantillas, objetos y clases webEdition, correspondiendo a la DTD (definici�n de tipo de documento) espec�fica de webEdition.';

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
$l_export['select_export'] ='Para exportar una entrada, por favor seleccione la casilla apropiada en el �rbol. Nota importante: Todas las entradas seleccionadas en todas las ramas ser�n exportadas y si se exporta un directorio, todos los documentos en ese directorio ser�n exportados tambi�n!';
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = 'No existe nada para eliminar.';
$l_export['nothing_to_save'] = '�No existe nada para salvar!';
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
$l_export['selection'] = 'Selecci�n';
$l_export['save_ok'] = 'La exportaci�n ha sido guardada.';
$l_export['save_group_ok'] = 'El grupo ha sido guardado.';
$l_export['log'] = 'Detalles';
$l_export['start_export'] = 'Iniciar exportaci�n';
$l_export['prepare'] = 'Preparar exportaci�n...';
$l_export['doctype'] = 'Tipo de documento';
$l_export['category'] = 'Categor�a';
$l_export['end_export'] = 'Exportaci�n terminada';
$l_export['newFolder'] = "Nuevo grupo";
$l_export['folder_empty'] = "�La carpeta est� vac�a!";
$l_export['folder_path_exists'] = "�La carpeta ya existe!";
$l_export['wrongtext'] = "Nombre no v�lido";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "�La carpeta ya existe!";
$l_export['delete_ok'] = 'La exportaci�n ha sido eliminada.';
$l_export['delete_nok'] = 'ERROR: La exportaci�n no ha sido eliminada';
$l_export['delete_group_ok'] = 'El grupo ha sido eliminado.';
$l_export['delete_group_nok'] = 'ERROR: El grupo no ha sido eliminado';
$l_export['delete_question'] = '�Desea eliminar la exportaci�n actual?';
$l_export['delete_group_question'] = '�Desea eliminar el grupo actual?';
$l_export['download_starting2'] = 'La descarga de la exportaci�n ha sido iniciada.';
$l_export['download_starting3'] = 'Si la descarga no se inicia despues de 10 seconds,';
$l_export['working'] = 'Trabajando';

$l_export['txt_document_options'] = 'La plantilla predeterminada es la que est� definida en las propiedades del documento. Los documentos incluidos son documentos internos que se incluyen en el documento de exportaci�n con las etiquetas we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js and we:addDelNewsletterEmail. Los objetos incluidos son aquellos que seincluyen en el documento de exportaci�n con las etiquetas we:object and we:form. Los documentos vinculados son documentos internos que se vinculan al el documento de exportaci�n con las etiquetas HTML: body, a, img, table and td.';
$l_export['txt_object_options'] = 'La clase predeterminada est� definida en las propiedades del objeto.';
$l_export['txt_exportdeep_options'] = 'La profundidad de exportaci�n define el nivel para la exportaci�n de los documentos incluidos. �El valor debe ser un n�mero!';
$l_export['name_empty'] = '�El campo del nombre no puede estar vac�o!';
$l_export['name_exists'] = 'El nombre ya existe!';

$l_export['help'] = 'Ayuda';
$l_export['info'] = 'Informaci�n';
$l_export['path_nok'] = '�El camino no es correcto!';

$l_export['must_save'] = 'La exportaci�n ha sido modificada.\\n�Debe salvar los datos de exportaci�n antes de poder hacer la exportaci�n!';
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