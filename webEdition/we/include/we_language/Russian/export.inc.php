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
$l_export["txt_auto_selection"] = "Экспортирует  документы или объекты, выбранные автоматически, согласно типа документа или класса";
$l_export["manual_selection"] = "Выбор вручную";
$l_export["txt_manual_selection"] = "Экспортирует документы или объекты, выбранные вручную";
$l_export["element"] = "Выбор элемента";
$l_export["documents"] = "Документы";
$l_export["objects"] = "Объекты";
$l_export["step1"] = "Выбрать параметры";
$l_export["step2"] = "Выбрать элементы для экспорта";
$l_export["step3"] = "Выбрать параметры экспорта";
$l_export["step10"] = "Экспорт завершен";
$l_export["step99"] = "Ошибка при экспортировании";
$l_export["step99_notice"] = "Экспорт невозможен";
$l_export["server_finished"] = "Экспортированный файл сохранен на сервере";
$l_export["backup_finished"] = "Экспорт прошел успешно";
$l_export["download_starting"] = "Download of the export file has been started.<br><br>If the download does not start after 10 seconds,<br>"; // TRANSLATE
$l_export["download"] = "please click here."; // TRANSLATE
$l_export["download_failed"] = "Either the file you requested does not exist or you are not permitted to download it."; // TRANSLATE
$l_export["file_format"] = "File format"; // TRANSLATE
$l_export["export_to"] = "Export to"; // TRANSLATE
$l_export["export_to_server"] = "Server"; // TRANSLATE
$l_export["export_to_local"] = "Local harddisc"; // TRANSLATE
$l_export["cdata"] = "Кодировка";
$l_export["export_xml_cdata"] = "Добавить области CDATA";
$l_export["export_xml_entities"] = "Заменить сущности (entities)";
$l_export["filename"] = "File name"; // TRANSLATE
$l_export["path"] = "Path"; // TRANSLATE
$l_export["doctypename"] = "Documents of document type"; // TRANSLATE
$l_export["classname"] = "Objects of class"; // TRANSLATE
$l_export["dir"] = "Directory"; // TRANSLATE
$l_export["categories"] = "Categories"; // TRANSLATE
$l_export["wizard_title"] = "Export Wizard"; // TRANSLATE
$l_export["xml_format"] = "XML"; // TRANSLATE
$l_export["csv_format"] = "CSV"; // TRANSLATE
$l_export["csv_delimiter"] = "Delimiter"; // TRANSLATE
$l_export["csv_enclose"] = "Enclose character"; // TRANSLATE
$l_export["csv_escape"] = "Escape character"; // TRANSLATE
$l_export["csv_lineend"] = "File format"; // TRANSLATE
$l_export["csv_null"] = "NULL replacement"; // TRANSLATE
$l_export["csv_fieldnames"] = "Put field names in first row"; // TRANSLATE
$l_export["windows"] = "Windows format"; // TRANSLATE
$l_export["unix"] = "UNIX format"; // TRANSLATE
$l_export["mac"] = "Mac format"; // TRANSLATE
$l_export["generic_export"] = "Generic export"; // TRANSLATE
$l_export["title"] = "Export Wizard"; // TRANSLATE
$l_export["gxml_export"] = "Generic XML export"; // TRANSLATE
$l_export["txt_gxml_export"] = "Export webEdition documents and objects to a \"flat\" XML file (3 levels)."; // TRANSLATE
$l_export["csv_export"] = "CSV export"; // TRANSLATE
$l_export["txt_csv_export"] = "Export webEdition objects to a CSV file (comma separated values)."; // TRANSLATE
$l_export["csv_params"] = "Settings"; // TRANSLATE
$l_export["error"] = "Экспорт не выполнен!";
$l_export["error_unknown"] = "Неизвестная ошибка!";
$l_export["error_object_module"] = "В данный момент не поддерживается экспорт данных в файлы CSV!<br><br>Не инсталлирован модуль «База данных/объект», без которого функция экспорта файлов CSV не работает.";
$l_export["error_nothing_selected_docs"] = "Экспорт не выполнен!<br><br>Отсутствуют выделенные документы";
$l_export["error_nothing_selected_objs"] = "Экспорт не выполнен!<br><br>Отсутствуют выделенные документы или объекты";
$l_export["error_download_failed"] = "Загрузка экспортируемых файлов не состоялась";
$l_export["comma"] = ", {comma}"; // TRANSLATE
$l_export["semicolon"] = "; {semicolon}"; // TRANSLATE
$l_export["colon"] = ": {colon}"; // TRANSLATE
$l_export["tab"] = "\\t {tab}"; // TRANSLATE
$l_export["space"] = "  {space}"; // TRANSLATE
$l_export["double_quote"] = "\" {double quote}"; // TRANSLATE
$l_export["single_quote"] = "' {single quote}"; // TRANSLATE
$l_export['we_export'] = 'Экспорт webEdition';
$l_export['wxml_export'] = 'XML экспорт';
$l_export['txt_wxml_export'] = 'Экспорт документов, шаблонов, объектов и классов webEdition в соответствии с определением типа документа, заданным в webEdition.';

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
$l_export['select_export'] ='Для того, чтобы экспортировать  запись нужно выделить соответствующее окошко в дереве файлов. Важное примечание: экспортируются все выделенные записи из всех областей, а при экспорте директории – все документы этой директории ';
$l_export['templates'] = 'Templates'; // TRANSLATE
$l_export['classes'] = 'Classes'; // TRANSLATE

$l_export['nothing_to_delete'] = 'Нет предмета удаления.';
$l_export['nothing_to_save'] = 'Нет предмета сохранения!';
$l_export['no_perms'] = 'Нет разрешения!';
$l_export['new'] = 'Новую';
$l_export['export'] = 'экспортную';
$l_export['group'] = 'группу';
$l_export['save'] = 'сохранить';
$l_export['delete'] = 'удалить';
$l_export['quit'] = 'Выйти';
$l_export['property'] = 'Свойство';
$l_export['name'] = 'Имя';
$l_export['save_to'] = 'Сохранить (куда):';
$l_export['selection'] = 'выделенное';
$l_export['save_ok'] = 'Данные экспорта сохранены.';
$l_export['save_group_ok'] = 'Группа сохранена.';
$l_export['log'] = 'Детальные записи';
$l_export['start_export'] = 'Запуск экспорта';
$l_export['prepare'] = 'Подготовка к запуску...';
$l_export['doctype'] = 'тип документа';
$l_export['category'] = 'категория';
$l_export['end_export'] = 'Экспорт завершен';
$l_export['newFolder'] = "Новая группа";
$l_export['folder_empty'] = "Папка  пуста!";
$l_export['folder_path_exists'] = "Папка уже существует!";
$l_export['wrongtext'] = "Имя недействительно";
$l_export['wrongfilename'] = "The filename is not valid!"; // TRANSLATE
$l_export['folder_exists'] = "Папка уже существует";
$l_export['delete_ok'] = 'Данные экспорта удалены.';
$l_export['delete_nok'] = 'ОШИБКА: данные экспорта не удалены';
$l_export['delete_group_ok'] = 'Группа удалена.';
$l_export['delete_group_nok'] = 'ОШИБКА: группа не удалена';
$l_export['delete_question'] = 'Удалить данные текущего экспорта?';
$l_export['delete_group_question'] = 'Удалить текущую группу?';
$l_export['download_starting2'] = 'Запущена загрузка экспортного файла.';
$l_export['download_starting3'] = 'Если загрузка не начнется через 10 секунд,';
$l_export['working'] = 'в работе';

$l_export['txt_document_options'] = 'Шаблоном по умолчанию является шаблон, заданный в свойствах документа. Включенными документами являются внутренние документы, вложенные в экспортированные документ с помощью тегов we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js, а также we:addDelNewsletterEmail. Включенными объектами являются объекты, вложенные в экспортированный документ с помощью тегов we:object и we:form. Документами, связанными ссылками, являются внутренние документы, связанные ссылкой с экспортированным документом с помощью таких тегов HTM  как:  body, a, img, table и td.';
$l_export['txt_object_options'] = 'Классом по умолчанию является класс, заданный в свойствах объекта.';
$l_export['txt_exportdeep_options'] = 'Глубина экспорта определяет граничный уровень экспорта вложенных документов и объектов. Данное поле должно состоять из цифр!';
$l_export['name_empty'] = 'Должно быть заполнено имя!';
$l_export['name_exists'] = 'Имя уже существует!';

$l_export['help'] = 'Помощь';
$l_export['info'] = 'Справка';
$l_export['path_nok'] = 'Путь неверный!';

$l_export['must_save'] = "Данные экспорта были изменены.\\nПрежде чем экспортировать, Вы должны сохранить данные экспорта!";
$l_export['handle_owners_option'] = 'Данные владельцев';
$l_export['handle_owners'] = 'Экспорт данных владельцев';
$l_export['txt_owners'] = 'Экспорт данных владельцев, связанных ссылкой. ';

$l_export['weBinary'] = 'File'; // TRANSLATE
$l_export['handle_navigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigation'] = 'Navigation'; // TRANSLATE
$l_export['weNavigationRule'] = 'Navigation rule'; // TRANSLATE
$l_export['weThumbnail'] = 'Thumbnails'; // TRANSLATE
$l_export['handle_thumbnails'] = 'Thumbnails'; // TRANSLATE
?>