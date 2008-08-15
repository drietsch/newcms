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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "Поле '%s' уже существует! Имя поля не должно повторяться!";

$l_we_editor["folder_save_nok_parent_same"] = "Выбранная родительская директория идентична текущей директории! Выберите, пожалуйста, другую директорию и попробуйте еще раз!";
$l_we_editor["pfolder_notsave"] = "Данная директория не может быть сохранена в выбранной директории!";
$l_we_editor["required_field_alert"] = "Требуется заполнить поле '%s'!";

$l_we_editor["category"]["response_save_ok"] = "Категория '%s' успешно сохранена!";
$l_we_editor["category"]["response_save_notok"] = "Ошибка при сохранении категория '%s'!";
$l_we_editor["category"]["response_path_exists"] = "Категория '%s' не могла быть сохранена, так как другая категория занимает это местоположение!";
$l_we_editor["category"]["we_filename_notValid"] = "Имя недействительно! Символы \\n\", \\' / < > и \\\\ не допускаются!";
$l_we_editor["category"]["filename_empty"]       = "The file name cannot be empty."; // TRANSLATE
$l_we_editor["category"]["name_komma"] = "Недействительное имя! Запятая недопустима!";

$l_we_editor["text/webedition"]["response_save_ok"] = "Страница webEdition '%s' успешно сохранена!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "Страница webEdition '%s' успешно опубликована!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Ошибка при опубликовании страницы webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "Страница webEdition '%s' успешно снята с публикации!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Ошибка при снятии с публикации страницы webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "Страница webEdition '%s' не опубликована!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Ошибка при сохранении страницы webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "Страница webEdition '%s' не могла быть сохранена, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/webedition"]["filename_empty"] = "Для этого документа не введено имя!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Недействительное имя файла\\nДопустимыми являются большие и малые буквы латинского алфавита, цифры, дефис, нижняя черта и точка (a-z, A-Z, 0-9, _, -, .).";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "Введенное имя файла недействительно!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "Документ не сохранен, так как у Вас нет необходимых полномочий на создание директорий (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "Страница webEdition будет автоматически опубликована %s!";

$l_we_editor["text/html"]["response_save_ok"] = "Страница HTML '%s' успешно сохранена!";
$l_we_editor["text/html"]["response_publish_ok"] = "Страница HTML '%s' успешно опубликована!";
$l_we_editor["text/html"]["response_publish_notok"] = "Ошибка при опубликовании страницы HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "Страница HTML '%s' успешно снята с публикации!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Ошибка при снятии с публикации страницы HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "Страница HTML '%s' не опубликована!";
$l_we_editor["text/html"]["response_save_notok"] = "Ошибка при сохранении страницы HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "Страница HTML '%s' не сохранена, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "Шаблон '%s' успешно сохранен!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "Шаблон '%s' успешно опубликован!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "Шаблон '%s' успешно снят с публикации!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Ошибка при сохранении шаблона '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "Шаблон '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "Таблица стилей '%s' успешно сохранена!";
$l_we_editor["text/css"]["response_publish_ok"] = "Таблица стилей '%s' успешно опубликована!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "Таблица стилей '%s' успешно снята с публикации!";
$l_we_editor["text/css"]["response_save_notok"] = "Ошибка при сохранении стилевого оформления '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "Таблица стилей '%s' не сохранена, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "JavaScript '%s' успешно опубликован!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "JavaScript '%s' успешно снят с публикации!";
$l_we_editor["text/js"]["response_save_notok"] = "Ошибка при сохранении JavaScript '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "JavaScript '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "Текстовый файл '%s' успешно опубликован!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "Текстовый файл'%s' успешно снят с публикации!";
$l_we_editor["text/plain"]["response_save_notok"] = "Ошибка при сохранении текстового файла '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "Текстовый файл '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "The directory '%s' has been successfully saved!";
$l_we_editor["folder"]["response_publish_ok"] = "Директория '%s' успешно опубликована!";
$l_we_editor["folder"]["response_unpublish_ok"] = "Директория '%s' успешно снята с публикации!";
$l_we_editor["folder"]["response_save_notok"] = "Ошибка при сохранении директории '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "Директория '%s' не сохранена, так как другой документ или директория занимает это местоположение!";
$l_we_editor["folder"]["filename_empty"] = "Данной директории не присвоено имя!";
$l_we_editor["folder"]["we_filename_notValid"] = "Недействительное имя папки/директории\\nДопустимыми являются большие и малые буквы латинского алфавита, цифры, дефис, нижняя черта и точка (a-z, A-Z, 0-9, _, -, .).";
$l_we_editor["folder"]["we_filename_notAllowed"] = "Введенное имя директории недействительно!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "Директория не сохранена, так как у Вас нет необходимых полномочий на создание директорий (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "Графический образ '%s' успешно сохранен!";
$l_we_editor["image/*"]["response_publish_ok"] = "Графический образ '%s' успешно опубликован!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "Графический образ '%s' успешно снят с публикации!";
$l_we_editor["image/*"]["response_save_notok"] = "Ошибка при сохранении графического образа '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "Графический образ '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "Документ '%s' успешно опубликован!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "Документ '%s' успешно снят с публикации!";
$l_we_editor["application/*"]["response_save_notok"] = "Ошибка при сохранении  документа '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "Документ '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Ошибка при сохранении '%s'\\nРасширение '%s' является недопустимым для других файлов.\\nС этой целью нужно открыть новую страницу HTML!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "Анимация flashmovie '%s' успешно сохранена!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "Анимация flashmovie '%s' успешно опубликована!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "Анимация flashmovie '%s' успешно снята с публикации!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Ошибка при сохранении анимации flashmovie '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "Анимация flashmovie '%s' не сохранена, так как другой документ или директория занимает это местоположение!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "Фильм quicktime '%s' успешно опубликован!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "Фильм quicktime '%s'успешно снят с публикации!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Ошибка при сохранении фильма quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "Фильм quicktime '%s' не сохранен, так как другой документ или директория занимает это местоположение!";
$l_we_editor["video/quicktime"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["video/quicktime"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["video/quicktime"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["video/quicktime"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

/*****************************************************************************
 * PLEASE DON'T TOUCH THE NEXT LINES
 * UNLESS YOU KNOW EXACTLY WHAT YOU ARE DOING!
 *****************************************************************************/

$_language_directory = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules";
$_directory = dir($_language_directory);

while (false !== ($entry = $_directory->read())) {
	if (ereg('_we_editor', $entry)) {
		include_once($_language_directory."/".$entry);
	}
}
?>