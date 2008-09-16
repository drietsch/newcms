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
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Директория назначения";
$GLOBALS["l_import_files"]["file"] = "Файл";
$GLOBALS["l_import_files"]["sameName_expl"] = "Определите действия системы webEdition в случае, если имя файла уже существует";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Переписать существующий файл";
$GLOBALS["l_import_files"]["sameName_rename"] = "Переименовать новый файл";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Не импортировать данный файл";
$GLOBALS["l_import_files"]["sameName_headline"] = "Что делать в случае,<br> если файл уже существует?";
$GLOBALS["l_import_files"]["step1"] = "Импорт локальных файлов - шаг 1 из 2";
$GLOBALS["l_import_files"]["step2"] = "Импорт локальных файлов - шаг 2 из 2";
$GLOBALS["l_import_files"]["import_expl"] = "Нажатием на кнопку, находящуюся рядом с окном ввода, можно выбрать файл на жестком диске. После выбора появляется новое окно ввода, в котором можно выбрать следующий файл. Примите во внимание то, что в связи с ограничениями PHP и MySQL максимальный размер файла составляет %s.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Ошибка импортирования!\\n\\nНе импортированы следующие файлы:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Импорт успешно завершен!";
$GLOBALS["l_import_files"]["import_file"] = "Импорт файла %s";

$GLOBALS["l_import_files"]["no_perms"] = "Ошибка: нет разрешения";
$GLOBALS["l_import_files"]["move_file_error"] = "Ошибка: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Ошибка:  fread()";
$GLOBALS["l_import_files"]["php_error"] = "Ошибка: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Ошибка: файл существует";
$GLOBALS["l_import_files"]["save_error"] = "Ошибка при сохранении";
$GLOBALS["l_import_files"]["publish_error"] = "Ошибка при опубликовании";

$GLOBALS["l_import_files"]["root_dir_1"] = "Вы задали корневой каталог веб-сервера как исходную директорию. Вы уверены, что хотите импортировать все содержимое корневого каталога ?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Вы задали корневой каталог веб-сервера как директорию назначения. Вы уверены, что хотите импортировать непосредственно в корневой каталог?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Вы задали корневой каталог веб-сервера как исходную директорию и директорию назначения одновременно. Вы уверены, что хотите импортировать содержимое корневого каталога непосредственно в корневой каталог?";

$GLOBALS["l_import_files"]["thumbnails"] = "Иконки";
$GLOBALS["l_import_files"]["make_thumbs"] = "Создать<br>иконки";
$GLOBALS["l_import_files"]["image_options_open"] = "Показывать функции графики";
$GLOBALS["l_import_files"]["image_options_close"] = "Скрыть функции графики";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Для корректной работы функций графики на Вашем сервере должна быть установлена GD Library!";
?>