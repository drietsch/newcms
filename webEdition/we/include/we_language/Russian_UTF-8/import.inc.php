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


/**
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Import Wizard'; // TRANSLATE
$l_import['wxml_import'] = 'webEdition XML import'; // TRANSLATE
$l_import['gxml_import'] = 'Generic XML import'; // TRANSLATE
$l_import['csv_import'] = 'CSV import'; // TRANSLATE
$l_import['import'] = 'Importing'; // TRANSLATE
$l_import['none'] = '-- none --'; // TRANSLATE
$l_import['any'] = '-- none --'; // TRANSLATE
$l_import['source_file'] = 'Source file'; // TRANSLATE
$l_import['import_dir'] = 'Target directory'; // TRANSLATE
$l_import['select_source_file'] = 'Please choose a source file.'; // TRANSLATE
$l_import['we_title'] = 'Title'; // TRANSLATE
$l_import['we_description'] = 'Description'; // TRANSLATE
$l_import['we_keywords'] = 'Keywords'; // TRANSLATE
$l_import['uts'] = 'Unix-Timestamp'; // TRANSLATE
$l_import['unix_timestamp'] = 'The unix time stamp is a way to track time as a running total of seconds. This count starts at the Unix Epoch on January 1st, 1970.'; // TRANSLATE
$l_import['gts'] = 'GMT Timestamp'; // TRANSLATE
$l_import['gmt_timestamp'] = 'General Mean Time ie. Greenwich Mean Time (GMT).'; // TRANSLATE
$l_import['fts'] = 'Specified format'; // TRANSLATE
$l_import['format_timestamp'] = 'The following characters are recognized in the format parameter string: Y (a full numeric representation of a year, 4 digits), y (a two digit representation of a year), m (numeric representation of a month, with leading zeros), n (numeric representation of a month, without leading zeros), d (day of the month, 2 digits with leading zeros), j (day of the month without leading zeros), H (24-hour format of an hour with leading zeros), G (24-hour format of an hour without leading zeros), i (minutes with leading zeros), s (seconds, with leading zeros)'; // TRANSLATE
$l_import['import_progress'] = 'Importing'; // TRANSLATE
$l_import['prepare_progress'] = 'Preparing'; // TRANSLATE
$l_import['finish_progress'] = 'Finished'; // TRANSLATE
$l_import['finish_import'] = 'The Import was successful!'; // TRANSLATE
$l_import['import_file'] = 'File import'; // TRANSLATE
$l_import['import_data'] = 'Data import'; // TRANSLATE
$l_import['file_import'] = 'Import local files'; // TRANSLATE
$l_import['txt_file_import'] = 'Import one or more files from the local harddrive.'; // TRANSLATE
$l_import['site_import'] = 'Import files from server'; // TRANSLATE
$l_import['site_import_isp'] = 'Import graphics from server'; // TRANSLATE
$l_import['txt_site_import_isp'] = 'Импорт графики с корневого каталога сервера. Установите фильтры по отбору графики для импорта.';
$l_import['txt_site_import'] = 'Import files from the root-directory of the server. Set filter options to choose if graphics, HTML pages, Flash, JavaScript, or CSS files, plain-text documents, or other types of files are to be imported.'; // TRANSLATE
$l_import['txt_wxml_import'] = 'webEdition XML files contain information about webEdition documents, templates or objects. Choose a directory to which the files are to be imported.'; // TRANSLATE
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.'; // TRANSLATE
$l_import['txt_csv_import'] = 'Import CSV files (Comma Separated Values) or modified textformats (e. g. *.txt). The dataset fields are assigned to the webEdition fields.'; // TRANSLATE
$l_import['add_expat_support'] = 'In order to implement support for the XML expat parser, you will need to recompile PHP to add support for this library to your PHP build. The expat extension, created by James Clark, can be found at http://www.jclark.com/xml/.'; // TRANSLATE
$l_import['xml_file'] = 'Файл-XML';
$l_import['templates'] = 'Шаблоны';
$l_import['classes'] = 'Классы';
$l_import['predetermined_paths'] = 'Предустановленные пути';
$l_import['maintain_paths'] = 'Оставить пути без изменений';
$l_import['import_options'] = 'Опции импорта';
$l_import['file_collision'] = 'Если файл уже существует';
$l_import['collision_txt'] = 'При импорте файлов в директорию, содержащую файл с таким же именем, возможны конфликты данных. Вы можете задать соответствующие параметры для Мастера импорта.';
$l_import['replace'] = 'Заменить';
$l_import['replace_txt'] = 'Удалить уже имеющийся файл и заменить новым файлом.';
$l_import['rename'] = 'Переименовать';
$l_import['rename_txt'] = 'Имени файла назначается один номер ID. Все ссылки, указывающие на такой файл, соответствуют его ID.';
$l_import['skip'] = 'Пропустить';
$l_import['skip_txt'] = 'При пропуске текущего файла сохраняется файл, записанный ранее.';
$l_import['extra_data'] = 'Данные экстра';
$l_import['integrated_data'] = 'Импортировать включенные данные';
$l_import['integrated_data_txt'] = 'При выборе данной опции импортируются данные/документы, включенные в шаблоны.';
$l_import['max_level'] = 'максимальный уровень';
$l_import['import_doctypes'] = 'Импортировать типы документов';
$l_import['import_categories'] = 'Импортировать категории';
$l_import['invalid_wxml'] = 'Возможен импорт только файлов XML, соответствующих определению типа документа.';
$l_import['valid_wxml'] = 'The XML document is well-formed and valid.  It applies to the webEdition document type definition (DTD).'; // TRANSLATE
$l_import['specify_docs'] = 'Please choose the documents to import.'; // TRANSLATE
$l_import['specify_objs'] = 'Please choose the objects to import.'; // TRANSLATE
$l_import['specify_docs_objs'] = 'Please choose whether to import documents and objects.'; // TRANSLATE
$l_import['no_object_rights'] = 'You do not have authorization to import objects.'; // TRANSLATE
$l_import['display_validation'] = 'Display XML validation'; // TRANSLATE
$l_import['xml_validation'] = 'XML validation'; // TRANSLATE
$l_import['warning'] = 'Warning'; // TRANSLATE
$l_import['attribute'] = 'Attribute'; // TRANSLATE
$l_import['invalid_nodes'] = 'Invalid XML node at position '; // TRANSLATE
$l_import['no_attrib_node'] = 'No XML element "attrib" at position '; // TRANSLATE
$l_import['invalid_attributes'] = 'Invalid attributes at position '; // TRANSLATE
$l_import['attrs_incomplete'] = 'The list of #required and #fixed attributes is incomplete at position '; // TRANSLATE
$l_import['wrong_attribute'] = 'The attribute name is neither defined as #required nor #implied at position '; // TRANSLATE
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['fileselect_server'] = 'Load file from server'; // TRANSLATE
$l_import['fileselect_local'] = 'Upload file from local hard disc'; // TRANSLATE
$l_import['filesize_local'] = 'Because of restrictions within PHP, the file that you wish to upload cannot exceed %s.'; // TRANSLATE
$l_import['xml_mime_type'] = 'The selected file cannot be imported. Mime-type:'; // TRANSLATE
$l_import['invalid_path'] = 'The path of the source file is invalid.'; // TRANSLATE
$l_import['ext_xml'] = 'Please select a source file with the extension ".xml".'; // TRANSLATE
$l_import['store_docs'] = 'Target directory documents'; // TRANSLATE
$l_import['store_tpls'] = 'Target directory templates'; // TRANSLATE
$l_import['store_objs'] = 'Target directory objects'; // TRANSLATE
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'Generic XML'; // TRANSLATE
$l_import['data_import'] = 'Import data'; // TRANSLATE
$l_import['documents'] = 'Documents'; // TRANSLATE
$l_import['objects'] = 'Objects'; // TRANSLATE
$l_import['type'] = 'Type'; // TRANSLATE
$l_import['template'] = 'Template'; // TRANSLATE
$l_import['class'] = 'Class'; // TRANSLATE
$l_import['categories'] = 'Categories'; // TRANSLATE
$l_import['isDynamic'] = 'Generate page dynamically'; // TRANSLATE
$l_import['extension'] = 'Extension'; // TRANSLATE
$l_import['filetype'] = 'Filetype'; // TRANSLATE
$l_import['directory'] = 'Directory'; // TRANSLATE
$l_import['select_data_set'] = 'Select dataset'; // TRANSLATE
$l_import['select_docType'] = 'Please choose a template.'; // TRANSLATE
$l_import['file_exists'] = 'The selected source file does not exist. Please check the given file path. Path: '; // TRANSLATE
$l_import['file_readable'] = 'The selected source file is not readable and thereby cannot be imported.'; // TRANSLATE
$l_import['asgn_rcd_flds'] = 'Assign data fields'; // TRANSLATE
$l_import['we_flds'] = 'webEdition&nbsp;fields'; // TRANSLATE
$l_import['rcd_flds'] = 'Dataset&nbsp;fields'; // TRANSLATE
$l_import['name'] = 'Name'; // TRANSLATE
$l_import['auto'] = 'Automatic'; // TRANSLATE
$l_import['asgnd'] = 'Assigned'; // TRANSLATE
$l_import['pfx'] = 'Prefix'; // TRANSLATE
$l_import['pfx_doc'] = 'Document'; // TRANSLATE
$l_import['pfx_obj'] = 'Object'; // TRANSLATE
$l_import['rcd_fld'] = 'Dataset field'; // TRANSLATE
$l_import['import_settings'] = 'Import settings'; // TRANSLATE
$l_import['xml_valid_1'] = 'The XML file is valid and contains'; // TRANSLATE
$l_import['xml_valid_s2'] = 'elements. Please select the elements to import.'; // TRANSLATE
$l_import['xml_valid_m2'] = 'XML child node in the first level with different names. Please choose the XML node and the number of elements to import.'; // TRANSLATE
$l_import['well_formed'] = 'The XML document is well-formed.'; // TRANSLATE
$l_import['not_well_formed'] = 'The XML document is not well-formed and cannot be imported.'; // TRANSLATE
$l_import['missing_child_node'] = 'The XML document is well-formed, but contains no XML nodes and can therefore not be imported.'; // TRANSLATE
$l_import['select_elements'] = 'Please choose the datasets to import.'; // TRANSLATE
$l_import['num_elements'] = 'Please choose the number of datasets from 1 to '; // TRANSLATE
$l_import['xml_invalid'] = ''; // TRANSLATE
$l_import['option_select'] = 'Selection..'; // TRANSLATE
$l_import['num_data_sets'] = 'Datasets:'; // TRANSLATE
$l_import['to'] = 'to'; // TRANSLATE
$l_import['assign_record_fields'] = 'Assign data fields'; // TRANSLATE
$l_import['we_fields'] = 'webEdition fields'; // TRANSLATE
$l_import['record_fields'] = 'Dataset fields'; // TRANSLATE
$l_import['record_field'] = 'Dataset field '; // TRANSLATE
$l_import['attributes'] = 'Attributes'; // TRANSLATE
$l_import['settings'] = 'Settings'; // TRANSLATE
$l_import['field_options'] = 'Field options'; // TRANSLATE
$l_import['csv_file'] = 'CSV file'; // TRANSLATE
$l_import['csv_settings'] = 'CSV settings'; // TRANSLATE
$l_import['xml_settings'] = 'XML settings'; // TRANSLATE
$l_import['file_format'] = 'File format'; // TRANSLATE
$l_import['field_delimiter'] = 'Separator'; // TRANSLATE
$l_import['comma'] = ', {comma}'; // TRANSLATE
$l_import['semicolon'] = '; {semicolon}'; // TRANSLATE
$l_import['colon'] = ': {colon}'; // TRANSLATE
$l_import['tab'] = "\\t {tab}"; // TRANSLATE
$l_import['space'] = '  {space}'; // TRANSLATE
$l_import['text_delimiter'] = 'Text separator'; // TRANSLATE
$l_import['double_quote'] = '" {double quote}'; // TRANSLATE
$l_import['single_quote'] = '\' {single quote}'; // TRANSLATE
$l_import['contains'] = 'First line contains field name'; // TRANSLATE
$l_import['split_xml'] = 'Import datasets sequential'; // TRANSLATE
$l_import['wellformed_xml'] = 'Validation for well-formed XML'; // TRANSLATE
$l_import['validate_xml'] = 'XML validiation'; // TRANSLATE
$l_import['select_csv_file'] = 'Please choose a CSV source file.'; // TRANSLATE
$l_import['select_seperator'] = 'Please, select a seperator.'; // TRANSLATE
$l_import['format_date'] = 'Date format'; // TRANSLATE
$l_import['info_sdate'] = 'Select the date format for the webEdition field'; // TRANSLATE
$l_import['info_mdate'] = 'Select the date format for the webEdition fields'; // TRANSLATE
$l_import['remark_csv'] = 'You are able to import CSV files (Comma Separated Values) or modified text formats (e. g. *.txt). The field delimiter (e. g. , ; tab, space) and text delimiter (= which encapsulates the text inputs) can be preset at the import of these file formats.'; // TRANSLATE
$l_import['remark_xml'] = 'To avoid the predefined timeout of a PHP-script, select the option "Import data-sets separately", to import large files.<br>If you are unsure whether the selected file is webEdition XML or not, the file can be tested for validity and syntax.'; // TRANSLATE

$l_import["import_docs"]="Импорт документов ";
$l_import["import_templ"]="Импорт шаблонов ";
$l_import["import_objs"]="Импорт объектов ";
$l_import["import_classes"]="Импорт классов ";
$l_import["import_doctypes"]="Импорт типов документов ";
$l_import["import_cats"]="Импорт категорий ";
$l_import["documents_desc"]="Введите, пожалуйста, директорию назначения для импортируемых документов. В случае если отмечена опция \"".$l_import['maintain_paths']."\", соответствующий путь воссоздается автоматически, в противном случае путь игнорируется. ";
$l_import["templates_desc"]=" Введите, пожалуйста, директорию назначения для импортируемых объектов. В случае если отмечена опция \"".$l_import['maintain_paths']."\", соответствующий путь воссоздается автоматически, в противном случае путь игнорируется. ";
$l_import['handle_document_options'] = 'Документы';
$l_import['handle_template_options'] = 'Шаблоны';
$l_import['handle_object_options'] = 'Объекты';
$l_import['handle_class_options'] = 'Классы';
$l_import["handle_doctype_options"] = "Типы документов";
$l_import["handle_category_options"] = "Категории";
$l_import['log'] = 'Детальные записи';
$l_import['start_import'] = 'Запуск импорта';
$l_import['prepare'] = 'Подготовка...';
$l_import['update_links'] = 'Обновление ссылок...';
$l_import['doctype'] = 'тип документа';
$l_import['category'] = 'Категория';
$l_import['end_import'] = 'Импорт завершен';

$l_import['handle_owners_option'] = 'Данные владельцев';
$l_import['txt_owners'] = 'Импорт данных владельцев, связанных ссылками.';
$l_import['handle_owners'] = 'Восстановить данные владельцев';
$l_import['notexist_overwrite'] = 'При отсутствии владельца переписать данные владельца';
$l_import['owner_overwrite'] = 'Переписать данные владельца';

$l_import['name_collision'] = 'Противоречие имени';

$l_import['item'] = 'Единица';
$l_import['backup_file_found'] = 'Файл относится к резервным файлам webEdition. Для импорта данных воспользуйтесь опцией \"Backup\" в пункте меню \"Файл\".';
$l_import['backup_file_found_question'] = 'Закрыть данное диалоговое окно и начать запуск Мастера backup?';
$l_import['close'] = 'Закрыть';
$l_import['handle_file_options'] = 'Файлы';
$l_import['import_files'] = 'Импорт файлов';
$l_import['weBinary'] = 'Файл';
$l_import['format_unknown'] = 'Формат файла неизвестен!';
$l_import['customer_import_file_found'] = 'Файл относится к файлам импорта с данными клиентов. Для импорта данных воспользуйтесь опцией \"Импорт/экспорт\" модуля управления клиентами (ПРО).';
$l_import['upload_failed'] = 'Невозможно загрузить файл. Убедитесь в том, что размер файла не превышает %s';

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