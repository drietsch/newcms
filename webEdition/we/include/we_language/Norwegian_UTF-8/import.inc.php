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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: English
 */
$l_import['title'] = 'Import Wizard';
$l_import['wxml_import'] = 'webEdition XML import';
$l_import['gxml_import'] = 'Generic XML import';
$l_import['csv_import'] = 'CSV import';
$l_import['import'] = 'Importing';
$l_import['none'] = '-- none --';
$l_import['any'] = '-- none --';
$l_import['source_file'] = 'Source file';
$l_import['import_dir'] = 'Target directory';
$l_import['select_source_file'] = 'Please choose a source file.';
$l_import['we_title'] = 'Title';
$l_import['we_description'] = 'Description';
$l_import['we_keywords'] = 'Keywords';
$l_import['uts'] = 'Unix-Timestamp';
$l_import['unix_timestamp'] = 'The unix time stamp is a way to track time as a running total of seconds. This count starts at the Unix Epoch on January 1st, 1970.';
$l_import['gts'] = 'GMT Timestamp';
$l_import['gmt_timestamp'] = 'General Mean Time ie. Greenwich Mean Time (GMT).';
$l_import['fts'] = 'Specified format';
$l_import['format_timestamp'] = 'The following characters are recognized in the format parameter string: Y (a full numeric representation of a year, 4 digits), y (a two digit representation of a year), m (numeric representation of a month, with leading zeros), n (numeric representation of a month, without leading zeros), d (day of the month, 2 digits with leading zeros), j (day of the month without leading zeros), H (24-hour format of an hour with leading zeros), G (24-hour format of an hour without leading zeros), i (minutes with leading zeros), s (seconds, with leading zeros)';
$l_import['import_progress'] = 'Importing';
$l_import['prepare_progress'] = 'Preparing';
$l_import['finish_progress'] = 'Finished';
$l_import['finish_import'] = 'The Import was successful!';
$l_import['import_file'] = 'File import';
$l_import['import_data'] = 'Data import';
$l_import['file_import'] = 'Import local files';
$l_import['txt_file_import'] = 'Import one or more files from the local harddrive.';
$l_import['site_import'] = 'Import files from server';
$l_import['site_import_isp'] = 'Import graphics from server';
$l_import['txt_site_import_isp'] = 'Import graphics form the root-directory of the server. Set filter options to choose which graphics are to be imported.';
$l_import['txt_site_import'] = 'Import files from the root-directory of the server. Set filter options to choose if graphics, HTML pages, Flash, JavaScript, or CSS files, plain-text documents, or other types of files are to be imported.';
$l_import['txt_wxml_import'] = 'webEdition XML files contain information about webEdition documents, templates or objects. Choose a directory to which the files are to be imported.';
$l_import['txt_gxml_import'] = 'Import "flat" XML files, such as those provided by phpMyAdmin. The dataset fields have to be allocated to the webEdition dataset fields. Use this to import XML files exported from webEdition without the export module.';
$l_import['txt_csv_import'] = 'Import CSV files (Comma Separated Values) or modified textformats (e. g. *.txt). The dataset fields are assigned to the webEdition fields.';
$l_import['add_expat_support'] = 'In order to implement support for the XML expat parser, you will need to recompile PHP to add support for this library to your PHP build. The expat extension, created by James Clark, can be found at http://www.jclark.com/xml/.';
$l_import['xml_file'] = 'XML file';
$l_import['templates'] = 'Templates';
$l_import['classes'] = 'Classes';
$l_import['predetermined_paths'] = 'Path settings';
$l_import['maintain_paths'] = 'Maintain paths';
$l_import['import_options'] = 'Import options';
$l_import['file_collision'] = 'File collision';
$l_import['collision_txt'] = 'When you import a file to a folder that contains a file with the same name, a file name collision occurs. You can specify how the import wizard should handle the new and existing files.';
$l_import['replace'] = 'Replace';
$l_import['replace_txt'] = 'Delete the existing file and replace it with the new file.';
$l_import['rename'] = 'Rename';
$l_import['rename_txt'] = 'Assign a unique name to the new file. All links will be adjusted to the new filename.';
$l_import['skip'] = 'Skip';
$l_import['skip_txt'] = 'Skip the current file and leave both copies in their original locations.';
$l_import['extra_data'] = 'Extra Data';
$l_import['integrated_data'] = 'Import integrated data';
$l_import['integrated_data_txt'] = 'Select this option to import integrated data by templates or documents.';
$l_import['max_level'] = 'to level';
$l_import['import_doctypes'] = 'Import doctypes';
$l_import['import_categories'] = 'Import categories';
$l_import['invalid_wxml'] = 'The XML document is well-formed but not valid. It does not apply to the webEdition document type definition (DTD).';
$l_import['valid_wxml'] = 'The XML document is well-formed and valid.  It applies to the webEdition document type definition (DTD).';
$l_import['specify_docs'] = 'Please choose the documents to import.';
$l_import['specify_objs'] = 'Please choose the objects to import.';
$l_import['specify_docs_objs'] = 'Please choose whether to import documents and objects.';
$l_import['no_object_rights'] = 'You do not have authorization to import objects.';
$l_import['display_validation'] = 'Display XML validation';
$l_import['xml_validation'] = 'XML validation';
$l_import['warning'] = 'Warning';
$l_import['attribute'] = 'Attribute';
$l_import['invalid_nodes'] = 'Invalid XML node at position ';
$l_import['no_attrib_node'] = 'No XML element "attrib" at position ';
$l_import['invalid_attributes'] = 'Invalid attributes at position ';
$l_import['attrs_incomplete'] = 'The list of #required and #fixed attributes is incomplete at position ';
$l_import['wrong_attribute'] = 'The attribute name is neither defined as #required nor #implied at position ';
$l_import['documents'] = 'Documents';
$l_import['objects'] = 'Objects';
$l_import['fileselect_server'] = 'Load file from server';
$l_import['fileselect_local'] = 'Upload file from local hard disc';
$l_import['filesize_local'] = 'Because of restrictions within PHP, the file that you wish to upload cannot exceed %s.';
$l_import['xml_mime_type'] = 'The selected file cannot be imported. Mime-type:';
$l_import['invalid_path'] = 'The path of the source file is invalid.';
$l_import['ext_xml'] = 'Please select a source file with the extension ".xml".';
$l_import['store_docs'] = 'Target directory documents';
$l_import['store_tpls'] = 'Target directory templates';
$l_import['store_objs'] = 'Target directory objects';
$l_import['doctype'] = 'Document type';
$l_import['gxml'] = 'Generic XML';
$l_import['data_import'] = 'Import data';
$l_import['documents'] = 'Documents';
$l_import['objects'] = 'Objects';
$l_import['type'] = 'Type';
$l_import['template'] = 'Template';
$l_import['class'] = 'Class';
$l_import['categories'] = 'Categories';
$l_import['isDynamic'] = 'Generate page dynamically';
$l_import['extension'] = 'Extension';
$l_import['filetype'] = 'Filetype';
$l_import['directory'] = 'Directory';
$l_import['select_data_set'] = 'Select dataset';
$l_import['select_docType'] = 'Please choose a template.';
$l_import['file_exists'] = 'The selected source file does not exist. Please check the given file path. Path: ';
$l_import['file_readable'] = 'The selected source file is not readable and thereby cannot be imported.';
$l_import['asgn_rcd_flds'] = 'Assign data fields';
$l_import['we_flds'] = 'webEdition&nbsp;fields';
$l_import['rcd_flds'] = 'Dataset&nbsp;fields';
$l_import['name'] = 'Name';
$l_import['auto'] = 'Automatic';
$l_import['asgnd'] = 'Assigned';
$l_import['pfx'] = 'Prefix';
$l_import['pfx_doc'] = 'Document';
$l_import['pfx_obj'] = 'Object';
$l_import['rcd_fld'] = 'Dataset field';
$l_import['import_settings'] = 'Import settings';
$l_import['xml_valid_1'] = 'The XML file is valid and contains';
$l_import['xml_valid_s2'] = 'elements. Please select the elements to import.';
$l_import['xml_valid_m2'] = 'XML child node in the first level with different names. Please choose the XML node and the number of elements to import.';
$l_import['well_formed'] = 'The XML document is well-formed.';
$l_import['not_well_formed'] = 'The XML document is not well-formed and cannot be imported.';
$l_import['missing_child_node'] = 'The XML document is well-formed, but contains no XML nodes and can therefore not be imported.';
$l_import['select_elements'] = 'Please choose the datasets to import.';
$l_import['num_elements'] = 'Please choose the number of datasets from 1 to ';
$l_import['xml_invalid'] = '';
$l_import['option_select'] = 'Selection..';
$l_import['num_data_sets'] = 'Datasets:';
$l_import['to'] = 'to';
$l_import['assign_record_fields'] = 'Assign data fields';
$l_import['we_fields'] = 'webEdition fields';
$l_import['record_fields'] = 'Dataset fields';
$l_import['record_field'] = 'Dataset field ';
$l_import['attributes'] = 'Attributes';
$l_import['settings'] = 'Settings';
$l_import['field_options'] = 'Field options';
$l_import['csv_file'] = 'CSV file';
$l_import['csv_settings'] = 'CSV settings';
$l_import['xml_settings'] = 'XML settings';
$l_import['file_format'] = 'File format';
$l_import['field_delimiter'] = 'Separator';
$l_import['comma'] = ', {comma}';
$l_import['semicolon'] = '; {semicolon}';
$l_import['colon'] = ': {colon}';
$l_import['tab'] = "\\t {tab}";
$l_import['space'] = '  {space}';
$l_import['text_delimiter'] = 'Text separator';
$l_import['double_quote'] = '" {double quote}';
$l_import['single_quote'] = '\' {single quote}';
$l_import['contains'] = 'First line contains field name';
$l_import['split_xml'] = 'Import datasets sequential';
$l_import['wellformed_xml'] = 'Validation for well-formed XML';
$l_import['validate_xml'] = 'XML validiation';
$l_import['select_csv_file'] = 'Please choose a CSV source file.';
$l_import['select_seperator'] = 'Please, select a seperator.';
$l_import['format_date'] = 'Date format';
$l_import['info_sdate'] = 'Select the date format for the webEdition field';
$l_import['info_mdate'] = 'Select the date format for the webEdition fields';
$l_import['remark_csv'] = 'You are able to import CSV files (Comma Separated Values) or modified text formats (e. g. *.txt). The field delimiter (e. g. , ; tab, space) and text delimiter (= which encapsulates the text inputs) can be preset at the import of these file formats.';
$l_import['remark_xml'] = 'To avoid the predefined timeout of a PHP-script, select the option "Import data-sets separately", to import large files.<br>If you are unsure whether the selected file is webEdition XML or not, the file can be tested for validity and syntax.';

$l_import["import_docs"]="Import documents";
$l_import["import_templ"]="Import templates";
$l_import["import_objs"]="Import objects";
$l_import["import_classes"]="Import classes";
$l_import["import_doctypes"]="Import DocTypes";
$l_import["import_cats"]="Import categories";
$l_import["documents_desc"]="Select the directory where the documents will be imported. If the option \"".$l_import['maintain_paths']."\" is checked, the documents paths will be restored, otherwise the documents paths will be ignored.";
$l_import["templates_desc"]="Select the directory where the templates will be imported. If the option \"".$l_import['maintain_paths']."\" is checked, the template paths will be restored, otherwise the template paths will be ignored.";
$l_import['handle_document_options'] = 'Documents';
$l_import['handle_template_options'] = 'Templates';
$l_import['handle_object_options'] = 'Objects';
$l_import['handle_class_options'] = 'Classes';
$l_import["handle_doctype_options"] = "Doctype";
$l_import["handle_category_options"] = "Category";
$l_import['log'] = 'Details';
$l_import['start_import'] = 'Start import';
$l_import['prepare'] = 'Prepare...';
$l_import['update_links'] = 'Update links...';
$l_import['doctype'] = 'Document-Type';
$l_import['category'] = 'Category';
$l_import['end_import'] = 'Import finshed';

$l_import['handle_owners_option'] = 'Owners data';
$l_import['txt_owners'] = 'Import linked owmers data.';
$l_import['handle_owners'] = 'Restore owners data';
$l_import['notexist_overwrite'] = 'If the user do not exist, the option "Overwrite owners data" will be applied';
$l_import['owner_overwrite'] = 'Overwrite owners data';

$l_import['name_collision'] = 'Name collision';

$l_import['item'] = 'Article';
$l_import['backup_file_found'] = 'The file looks like webEdition backup file. Please use the \"Backup\" option from the \"File\" menu to import the data.';
$l_import['backup_file_found_question'] = 'Would you like now to close the current dialog and to start the backup wizard?';
$l_import['close'] = 'Close';
$l_import['handle_file_options'] = 'Files';
$l_import['import_files'] = 'Import files';
$l_import['weBinary'] = 'File';
$l_import['format_unknown'] = 'The file format is unknown!';
$l_import['customer_import_file_found'] = 'The file looks like import file with customer\'s data. Please use the \"Import/Export\" option from the customer module (PRO) to import the data.';
$l_import['upload_failed'] = 'The file can\'t be uploaded. Please verify if the file size is greater then %s';

$l_import['import_navigation'] = 'Import navigation';
$l_import['weNavigation'] = 'Navigation';
$l_import['navigation_desc'] = 'Select the directory where the navigation will be imported.';
$l_import['weNavigationRule'] = 'Navigation rule';
$l_import['weThumbnail'] = 'Thumbnail';
$l_import['import_thumbnails'] = 'Import thumbnails';
$l_import['rebuild'] = 'Rebuild';
$l_import['rebuild_txt'] = 'Automatic rebuild';
$l_import['finished_success'] = 'The import of the data has finished successfully.';
?>