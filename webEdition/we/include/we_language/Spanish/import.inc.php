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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Asistente de Importación';
$l_import['wxml_import'] = 'Importación de XML webEdition';
$l_import['gxml_import'] = 'Importación de XML Genérico';
$l_import['csv_import'] = 'Importación de CSV';
$l_import['import'] = 'Importando';
$l_import['none'] = '-- none --'; // TRANSLATE
$l_import['any'] = '-- none --'; // TRANSLATE
$l_import['source_file'] = 'Archivo original';
$l_import['import_dir'] = 'Directorio objetivo';
$l_import['select_source_file'] = 'Por favor escoja el archivo original.';
$l_import['we_title'] = 'Titulo';
$l_import['we_description'] = 'Descripción';
$l_import['we_keywords'] = 'Palabras claves';
$l_import['uts'] = 'Marca horária Unix';
$l_import['unix_timestamp'] = 'La marca horária unix es una forma de seguir el tiempo como una marcha total segundos. Este conteo se inicia en el Unix Epoch, 1st de Enero, 1970.';
$l_import['gts'] = 'Marca horária GMT';
$l_import['gmt_timestamp'] = 'General Mean Time ie. Greenwich Mean Time (GMT).'; // TRANSLATE
$l_import['fts'] = 'Formato especificado';
$l_import['format_timestamp'] = 'Los siguientes carácteres son reconocidos en la cadena de parámetros de formato: Y (una representación númerica completa de un año, 4 dígitos), y (una represenatación de un año de dos dígitos), m (representación númerica de un mes, encabezada por ceros), n (representación númerica de un mes, no encabezada por ceros), d (día del mes, 2 dígitos encabezados por ceros), j (día del mes no encabezado por ceros), H (formato de 24 horas de una hora, encabezado por ceros), G (formato de 24 horas de una hora no encabezado por ceros), i (minutos encabezados por ceros), s (segundos encabezados por ceros)';
$l_import['import_progress'] = 'Importando';
$l_import['prepare_progress'] = 'Preparando';
$l_import['finish_progress'] = 'Terminado';
$l_import['finish_import'] = 'La importación fue exitosa!';
$l_import['import_file'] = 'Importación de archivos';
$l_import['import_data'] = 'Importación de data';
$l_import['file_import'] = 'Importando archivos locales';
$l_import['txt_file_import'] = 'Importar uno o más archivos desde su disco duro local.';
$l_import['site_import'] = 'Importar archivos desde el servidor';
$l_import['site_import_isp'] = 'Importando gráficos desde el servidor';
$l_import['txt_site_import_isp'] = 'Importando gráficos desde el directorio raíz del servidor. Configure las opciones del filtro para escoger cuales gráficos serán importados.';
$l_import['txt_site_import'] = 'Importar archivos desde el directorio raíz del servidor. Ajuste las opciones de filtro para escoger si los gráficos, las páginas HTML, Flash, JavaScript, archivos CSS, documentos de texto simple, u otro tipo de archivo serán importados.';
$l_import['txt_wxml_import'] = 'Los archivos XML de webEdition contienen información acerca de documentos, plantillas u objetos webEdition. Escoja un directorio al cual los archivos serán importados.';
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.'; // TRANSLATE
$l_import['txt_csv_import'] = 'Importar archivos CSV (Valores Separados por Comas) o formatos de texto modificados (por ejemplo *.txt). Los campos de conjuntos de datos son ubicados a los campos de webEdition.';
$l_import['add_expat_support'] = 'Para implementar el apoyo del programa analizador sintáctico del expat XML, Ud necesitará recopilar PHP para adicionar apoyo a esta librería para su forma PHP. La extensión expat , creada por James Clark, puede ser encontrada en http://www.jclark.com/xml/.';
$l_import['xml_file'] = 'Archivo XML';
$l_import['templates'] = 'Plantillas';
$l_import['classes'] = 'Clases';
$l_import['predetermined_paths'] = 'Ajustes de la ruta de acceso';
$l_import['maintain_paths'] = 'Mantener las rutas de acceso';
$l_import['import_options'] = 'Importar opciones';
$l_import['file_collision'] = 'Colisión de archivos';
$l_import['collision_txt'] = 'Cuando Ud importa un archivo a una carpeta que contiene un archivo con el mismo nombre, una colisión de nombres de archivo ocurre. Ud puede especificar como el asistente de importación debe manejar los archivos nuevos y existentes.';
$l_import['replace'] = 'Reemplazar';
$l_import['replace_txt'] = 'Borrar el archivo existente y reemplazarlo con un archivo nuevo.';
$l_import['rename'] = 'Renombrar';
$l_import['rename_txt'] = 'Asignar un nombre único al archivo nuevo. Todos los vínculos serán ajustados al nuevo nombre de archivo.';
$l_import['skip'] = 'Saltar';
$l_import['skip_txt'] = 'Saltar el archivo actual y dejar ambas copias en su ubicación original.';
$l_import['extra_data'] = 'Data extra';
$l_import['integrated_data'] = 'Importar data integrado ';
$l_import['integrated_data_txt'] = 'Seleccione esta opción para importar data integrado por plantillas y documentos.';
$l_import['max_level'] = 'a nivelar';
$l_import['import_doctypes'] = 'Importar tipos de documentos';
$l_import['import_categories'] = 'Importar categorías';
$l_import['invalid_wxml'] = 'El documento XML está bien formado pero no es valido. No se aplica a la definición de tipo de documento webEdition (DTD).';
$l_import['valid_wxml'] = 'El documento XML está bien formado y es valido. Se aplica a la definición de tipo de documento webEdition (DTD).';
$l_import['specify_docs'] = 'Por favor, escoja los documentos a importar.';
$l_import['specify_objs'] = 'Por favor, escoja los objetos a importar.';
$l_import['specify_docs_objs'] = 'Por favor, escoja si importar documentos y objetos.';
$l_import['no_object_rights'] = 'Ud no tiene autorización para importar objetos.';
$l_import['display_validation'] = 'Mostrar validación de XML';
$l_import['xml_validation'] = 'Validación de XML';
$l_import['warning'] = 'Advertencia';
$l_import['attribute'] = 'Atributo';
$l_import['invalid_nodes'] = 'Nódulo XML invalido en posición';
$l_import['no_attrib_node'] = 'No hay elemento XML "atributo" en posición';
$l_import['invalid_attributes'] = 'Atributos invalidos en posición';
$l_import['attrs_incomplete'] = 'La lista de atributos #requeridos y #reparados está incompleta en posición';
$l_import['wrong_attribute'] = 'El nombre del atributo no está definido como #requerido ni como #implícito en posición ';
$l_import['documents'] = 'Documentos';
$l_import['objects'] = 'Objetos';
$l_import['fileselect_server'] = 'Cargar archivo desde el servidor';
$l_import['fileselect_local'] = 'Cargar archivo desde su disco duro local';
$l_import['filesize_local'] = 'Por las restrinciones dentro de PHP, el archivo que UD desea cargar no puede exceder 0.999MB.';
$l_import['xml_mime_type'] = 'El archivo seleccionado no puede ser importado. Tipo MIME';
$l_import['invalid_path'] = 'La ruta de acceso del archivo original es invalido.';
$l_import['ext_xml'] = 'Por favor, seleccione un archivo original con la extensión ".xml".';
$l_import['store_docs'] = 'Documentos del directorio objetivo';
$l_import['store_tpls'] = 'Plantillas del directorio objetivo';
$l_import['store_objs'] = 'Objectos del directorio objetivo';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'XML genérico';
$l_import['data_import'] = 'Importar data';
$l_import['documents'] = 'Documentos';
$l_import['objects'] = 'Objetos';
$l_import['type'] = 'Tipo';
$l_import['template'] = 'Plantilla';
$l_import['class'] = 'Clase';
$l_import['categories'] = 'Categoría';
$l_import['isDynamic'] = 'Generar la página dinámicamente';
$l_import['extension'] = 'Extensión';
$l_import['filetype'] = 'Tipo de archivo';
$l_import['directory'] = 'Directorio';
$l_import['select_data_set'] = 'Seleccione conjunto de datos';
$l_import['select_docType'] = 'Por favor, escoja una plantilla.';
$l_import['file_exists'] = 'El archivo original seleccionado no existe. Por favor, chequear la ruta de acceso del archivo dado. Ruta: ';
$l_import['file_readable'] = 'El archivo original seleccionado es no leíble y por lo tanto no puede ser importado.';
$l_import['asgn_rcd_flds'] = 'Asignar campos de data';
$l_import['we_flds'] = 'Campos de webEdition';
$l_import['rcd_flds'] = 'Campos de conjunto de datos';
$l_import['name'] = 'Nombre';
$l_import['auto'] = 'Automático';
$l_import['asgnd'] = 'Asignado';
$l_import['pfx'] = 'Prefijo';
$l_import['pfx_doc'] = 'Documento';
$l_import['pfx_obj'] = 'Objeto';
$l_import['rcd_fld'] = 'Campo de conjunto de datos';
$l_import['import_settings'] = 'Importar ajustes';
$l_import['xml_valid_1'] = 'El archivo XML es valido y contiene';
$l_import['xml_valid_s2'] = 'elementos. Por favor, seleccione el elemento a importar.';
$l_import['xml_valid_m2'] = 'Nódulo hijo XML en el primer nivel con nombres diferentes. Por favor, escoja el nódulo XML y el número de elementos a importar.';
$l_import['well_formed'] = 'El documento XML está bien formado.';
$l_import['not_well_formed'] = 'El documento XML no está bien formado y no puede ser importado.';
$l_import['missing_child_node'] = 'El documento XML está bien formado, pero no contiene nódulos XML y por lo tanto puede no ser importada.';
$l_import['select_elements'] = 'Por favor, escoja los conjuntos de datos a importar.';
$l_import['num_elements'] = 'Por favor, escoja el múmero de conjuntos de datos desde 1 a ';
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'Selección..';
$l_import['num_data_sets'] = 'Conjunto de datos:';
$l_import['to'] = 'a';
$l_import['assign_record_fields'] = 'Asignar campos de data';
$l_import['we_fields'] = 'Campos webEdition';
$l_import['record_fields'] = 'Campos de conjuntos de datos';
$l_import['record_field'] = 'Campo de conjunto de datos ';
$l_import['attributes'] = 'Atributos';
$l_import['settings'] = 'Ajustes';
$l_import['field_options'] = 'Opciones de campo';
$l_import['csv_file'] = 'Archivo CSV';
$l_import['csv_settings'] = 'Ajustes de CSV';
$l_import['xml_settings'] = 'Ajustes de XML';
$l_import['file_format'] = 'Formato de archivo';
$l_import['field_delimiter'] = 'Separador';
$l_import['comma'] = ', {coma}';
$l_import['semicolon'] = '; {punto y coma}';
$l_import['colon'] = ': {dos puntos}';
$l_import['tab'] = "\\t {tabulador}";
$l_import['space'] = '  {área}';
$l_import['text_delimiter'] = 'Separador de texto';
$l_import['double_quote'] = '" {comillas}';
$l_import['single_quote'] = '\' {comilla}';
$l_import['contains'] = 'La primera línea contiene el nombre del campo';
$l_import['split_xml'] = 'Importación secuencial de conjuntos de datos';
$l_import['wellformed_xml'] = 'Validación para XML bien formados';
$l_import['validate_xml'] = 'Validación de XML';
$l_import['select_csv_file'] = 'Por favor, escoja un archivo original CSV.';
$l_import['select_seperator'] = 'Por favor, seleccione un separador.';
$l_import['format_date'] = 'Formato de fecha';
$l_import['info_sdate'] = 'Seleccione el formato de fecha para el campo webEdition';
$l_import['info_mdate'] = 'Seleccione el formato de fecha para los campos webEdition';
$l_import['remark_csv'] = 'Ud es capaz de importar archivos CSV (Valores Separados por Comas) o modificar formatos de texto  (por ejemplo *.txt). El delimitador de campo (por ejemplo , ; tabulador, área) y el delimitador de texto (= el cual encapsula las entradas de texto) pueden ser preajustados en la importación de estos formatos de archivo.';
$l_import['remark_xml'] = 'Para evitar la pausa predefinida de un PHP-script, seleccione la opción "Importar conjuntos de datos separadamente", para importar archvios extensos.<br>Si Ud está inseguro de si el archivo seleccionado es un XML de webEdition o no, el archivo puede ser comprobado por validez y sintaxis.';

$l_import["import_docs"]="Import documents"; // TRANSLATE
$l_import["import_templ"]="Import templates"; // TRANSLATE
$l_import["import_objs"]="Import objects"; // TRANSLATE
$l_import["import_classes"]="Import classes"; // TRANSLATE
$l_import["import_doctypes"]="Import DocTypes"; // TRANSLATE
$l_import["import_cats"]="Import categorys"; // TRANSLATE
$l_import["documents_desc"]="Select the directory where the documents will be imported. If the option \"".$l_import['maintain_paths']."\" is checked, the documents paths will be restored, otherwise the documents paths will be ignored."; // TRANSLATE
$l_import["templates_desc"]="Select the directory where the templates will be imported. If the option \"".$l_import['maintain_paths']."\" is checked, the template paths will be restored, otherwise the template paths will be ignored."; // TRANSLATE
$l_import['handle_document_options'] = 'Documentos';
$l_import['handle_template_options'] = 'Plantillas';
$l_import['handle_object_options'] = 'Objectos';
$l_import['handle_class_options'] = 'Clases';
$l_import["handle_doctype_options"] = "Tipos de documentos";
$l_import["handle_category_options"] = "Categoría";
$l_import['log'] = 'Detalles';
$l_import['start_import'] = 'Comenzar importación';
$l_import['prepare'] = 'Preparar...';
$l_import['update_links'] = 'Actualizar vínculos...';
$l_import['doctype'] = 'Tipos de documentos';
$l_import['category'] = 'Categoría';
$l_import['end_import'] = 'Importación terminada';

$l_import['handle_owners_option'] = 'Datos  propietarios';
$l_import['txt_owners'] = 'Importar datos propietarios vinculados.';
$l_import['handle_owners'] = 'Restaurar datos propietarios';
$l_import['notexist_overwrite'] = 'Si el usuario no existe, la opción "Sobrescribir datos propietarios" será aplicada';
$l_import['owner_overwrite'] = 'Sobrescribir datos propietarios';

$l_import['name_collision'] = 'Colisión de nombre';

$l_import['item'] = 'Artículo';
$l_import['backup_file_found'] = 'El archivo parece un archivo de copia webEdition. Por favor use la opción \"Reserva\" del menú \"Archivo\" para importar los datos.';
$l_import['backup_file_found_question'] = '¿Desea cerrar la ventana de diálogo actual y comenzar el asistente de copia?';
$l_import['close'] = 'Cerrar';
$l_import['handle_file_options'] = 'Archivos';
$l_import['import_files'] = 'Importar archivos';
$l_import['weBinary'] = 'Archivo';
$l_import['format_unknown'] = '¡El formato del archivo es desconocido!';
$l_import['customer_import_file_found'] = 'El archivo parece un archivo de importación con los datos del cliente. Por favor use la opción \"Import/Export\" del módulo cliente (PRO) para importar los datos.';
$l_import['upload_failed'] = 'El fichero no puede ser subido. Por favor verifique si el tamaño es más grande que %s';

$l_import['import_navigation'] = 'Import navigation'; // TRANSLATE
$l_import['weNavigation'] = 'Navigation'; // TRANSLATE
$l_import['navigation_desc'] = 'Select the directory where the navigation will be imported.'; // TRANSLATE
$l_import['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_import['weThumbnail'] = 'Thumbnail'; // TRANSLATE
$l_import['import_thumbnails'] = 'Import thumbnails'; // TRANSLATE
$l_import['rebuild'] = 'Rebuild'; // TRANSLATE
$l_import['rebuild_txt'] = 'Automatic rebuild'; // TRANSLATE
$l_import['finished_success'] = 'The import of the data has finished successfully.'; // TRANSLATE
?>