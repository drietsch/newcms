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
 * Language file: we_class.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$l_we_class["ChangePark"] = "Данный атрибут можно изменить только для неопубликованного документа!";
$l_we_class["fieldusers"] = "Пользователи";
$l_we_class["other"] = "Другие";
$l_we_class["use_object"] = "Использовать объект";
$l_we_class["users"] = "Владельцы по умолчанию";
$l_we_class["copytext/css"] = "Копировать таблицу стилей CSS";
$l_we_class["copytext/js"] = "Копировать Javascript";
$l_we_class["copytext/html"] = "Копировать страницу HTML";
$l_we_class["copytext/plain"] = "Копировать текстовую страницу";
$l_we_class["copyTemplate"] = "Копировать шаблон";
$l_we_class["copyFolder"] = "Копировать директорию";
$l_we_class["copy_owners_expl"] = "Выберите директорию, чье содержимое должно быть скопировано в текущую директорию.";
$l_we_class["category"] = "Категория";
$l_we_class["folder_saved_ok"] = "Директория '%s' успешно сохранена!";
$l_we_class["response_save_ok"] = "Документ '%s' успешно сохранен!";
$l_we_class["response_publish_ok"] = "Документ '%s' успешно опубликован!";
$l_we_class["response_unpublish_ok"] = "Документ '%s' успешно снят с публикации!";
$l_we_class["response_save_notok"] = "Ошибка при сохранении документа '%s'!";
$l_we_class["response_path_exists"] = "Невозможно сохранить документ или директорию %s, так как это местоположение уже занято другим документом или директорией!";
$l_we_class["width"] = "Ширина";
$l_we_class["height"] = "Высота";
$l_we_class["width_tmp"] = "Ширина";
$l_we_class["height_tmp"] = "Высота";
$l_we_class["percent_width_tmp"] = "Ширина в %";
$l_we_class["percent_height_tmp"] = "Высота в %";
$l_we_class["alt"] = "Альтернативный текст";
$l_we_class["alt_kurz"] = "Альт.текст";
$l_we_class["title"] = "Заголовок";
$l_we_class["use_meta_title"] = "Использовать meta заголовок";
$l_we_class["longdesc_text"] = "Файл длинного описания";
$l_we_class["align"] = "Центровка";
$l_we_class["name"] = "Имя";
$l_we_class["hspace"] = "Расстояние по горизонтали";
$l_we_class["vspace"] = "Расстояние по вертикали";
$l_we_class["border"] = "Граница";
$l_we_class["fields"] = "Поля";
$l_we_class["AutoFolder"] = "Автоматическая папка";
$l_we_class["AutoFilename"] = "Имя файла";
$l_we_class["import_ok"] = "Документы успешно импортированы!";
$l_we_class["function"] = "Функция";
$l_we_class["contenttable"] = "Таблица-содержание";
$l_we_class["quality"] = "Качество";
$l_we_class["salign"] = "Расположение Flash ролика";
$l_we_class["play"] = "Воспроизведение (Play)";
$l_we_class["loop"] = "Повтор (Loop)";
$l_we_class["scale"] = "Масштаб";
$l_we_class["bgcolor"] = "Цвет заднего фона";
$l_we_class["response_save_noperms_to_create_folders"] = "Документ не был сохранен, так как у Вас нет соответствующих полномочий для создания директорий (%s)!";
$l_we_class["file_on_liveserver"]="Файл уже существует";
$l_we_class["defaults"] = "По умолчанию";
$l_we_class["attribs"] = "Атрибуты";
$l_we_class["intern"] = "Внутренняя";
$l_we_class["extern"] = "Внешняя";
$l_we_class["linkType"] = "Тип ссылки";
$l_we_class["href"] = "Href"; // TRANSLATE
$l_we_class["target"] = "Цель";
$l_we_class["hyperlink"] = "Гиперссылка";
$l_we_class["nolink"] = "Ссылка отсутствует";
$l_we_class["noresize"] = "Не менять размер";
$l_we_class["pixel"] = "Pixel"; // TRANSLATE
$l_we_class["percent"] = "Процент";
$l_we_class["new_doc_type"] = "Новый тип документов";
$l_we_class["doctypes"] = "Типы документов";
$l_we_class["subdirectory"] = "Поддиректория";
$l_we_class["subdir"][SUB_DIR_NO] = "-- -- ";
$l_we_class["subdir"][SUB_DIR_YEAR] = "Год";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH] = "Год/месяц";
$l_we_class["subdir"][SUB_DIR_YEAR_MONTH_DAY] = "Год/месяц/день";
$l_we_class["doctype_save_ok"] = "Тип документа '%s' успешно сохранен!";
$l_we_class["doctype_save_nok_exist"] = "Имя типа документа '%s' уже существует.\\n Выберите другое имя и попробуйте еще раз!";
$l_we_class["delete_doc_type"] = "Удалить '%s'";
$l_we_class["doctype_delete_prompt"] = "Удалить тип документа '%s'! Вы уверены?";
$l_we_class["doctype_delete_nok"] = "Имя типа документа '%s' уже используется!\\n Данный тип документов не может быть удален!";
$l_we_class["doctype_delete_ok"] = "Тип документа '%s' успешно удален!";
$l_we_class["confirm_ext_change"] = "Вы изменили условия генерирования динамической страницы.\\nИзменить расширение на заданное по умолчанию?";
$l_we_class["newDocTypeName"] = 'Введите, пожалуйста, имя для нового типа документов!';
$l_we_class["no_perms"] = 'Вы не уполномочены на проведение данной операции!';
$l_we_class["workspaces"] = "Рабочие пространства";
$l_we_class["extraWorkspaces"] = "Дополнительные рабочие пространства";
$l_we_class["edit"] = "Редактировать";
$l_we_class["workspace"] = "Рабочее пространство";
$l_we_class["information"] = "Справка";
$l_we_class["previeweditmode"] = "Preview Editmode"; // TRANSLATE
$l_we_class["preview"] = "Предварительный просмотр";
$l_we_class["no_preview_available"] = "No preview available for this file. To view this file please download it first."; // TRANSLATE
$l_we_class["file_not_saved"] = "File wasn't saved yet."; // TRANSLATE
$l_we_class["download"] = "Download"; // TRANSLATE
$l_we_class["validation"] = "Проверка";
$l_we_class["variants"] = "Варианты";
$l_we_class["tab_properties"] = "Свойства";
$l_we_class["metainfos"] = "Мета-информация";
$l_we_class["fields"] = "Поля";
$l_we_class["search"] = "Поиск";
$l_we_class["schedpro"] = "Планировщик ПРО";
$l_we_class["generateTemplate"] = "Сгенерировать шаблон";
$l_we_class["autoplay"] = "Autoplay"; // TRANSLATE
$l_we_class["controller"] = "Показать контрольную панель";
$l_we_class["volume"] = "Громкость";
$l_we_class["hidden"] = "Скрыто";
$l_we_class["workspacesFromClass"] = "Перенять от класса";
$l_we_class["image"] = "Изображение";
$l_we_class["thumbnails"] = "Иконки";
$l_we_class["edit_show"] = "Показывать опции изображений";
$l_we_class["edit_hide"] = "Скрыть опции изображений";
$l_we_class["resize"] = "Изменить размер";
$l_we_class["rotate"] = "Вращать изображение";
$l_we_class["rotate_hint"] = "Версия GD library, установленная на сервере, не поддерживает функцию вращения изображения!";
$l_we_class["crop"] = "Crop image"; // TRANSLATE
$l_we_class["quality"] = "Качество";
$l_we_class["quality_hint"] = "Введите качество изображения для компрессирования JPEG. <br><br> 10: максимальное качество, занимает наибольший объем памяти <br> 0: минимальное качество занимает наименьший объем памяти";
$l_we_class["quality_maximum"] = "Максимум";
$l_we_class["quality_high"] = "Высокое";
$l_we_class["quality_medium"] = "Среднее";
$l_we_class["quality_low"] = "Низкое";
$l_we_class["convert"] = "Конвертировать";
$l_we_class["convert_gif"] = "Формат GIF";
$l_we_class["convert_jpg"] = "Формат JPEG";
$l_we_class["convert_png"] = "Формат PNG";
$l_we_class["rotate0"] = "без вращения";
$l_we_class["rotate180"] = "вращать на 180&deg;";
$l_we_class["rotate90l"] = "вращать 90&deg; против часовой стрелки";
$l_we_class["rotate90r"] = "вращать 90&deg; по часовой стрелке";
$l_we_class["change_compression"] = "Изменить компрессирование";
$l_we_class["upload"] = "Загрузить";
$l_we_class["type_not_supported_hint"] = "Установленная на сервере версия GD Library не поддерживает %s как формат вывода на экран! Рекомендуется конвертировать изображение в формат, поддерживаемый GD Library.";
$l_we_class["CSS"] = "CSS"; // TRANSLATE
$l_we_class['we_del_workspace_error'] = "Данное рабочее пространство не удалено, так как оно задействовано объектами класса!";
$l_we_class["master_template"] = "Master template"; // TRANSLATE
$l_we_class["same_master_template"] = "The selected master template cannot be identical with the current template!"; // TRANSLATE
$l_we_class["documents"] = "Documents"; // TRANSLATE
$l_we_class["no_documents"] = "No document based on this template"; // TRANSLATE
?>