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
 * Language file: update.inc.php
 *
 * Provides language strings.
 *
 * Language: Russian
 */

$l_update["title"] = "Обновление webEdition";


$l_navi["update"] = "Обновление";
$l_navi["modul"] = "Установка модуля";
$l_navi["log"] = "Запись";
$l_navi["language"] = "Языки";

$l_update["check"]["headline"]      = "Поиск новой версии";
$l_update["check"]["actualVersion"] = "Инсталлированные версии:";
$l_update["check"]["lastUpdate"]    = "Последняя инсталляция:";
$l_update["check"]["lookForUpdate"] = "Поиск новой версии";
$l_update["check"]["neverUpdated"]  = "-";


$l_update["log"]["title"]          = "Запись инсталляции";
$l_update["log"]["date"]           = "Дата / Время";
$l_update["log"]["aktion"]         = "Действие";
$l_update["log"]["version"]        = "Версия";
$l_update["log"]["empty_log"]      = "Запись инсталляции отсутствует";
$l_update["log"]["entries_total"]  = "Все записи:";
$l_update["log"]["entries_page"]   = "Страница";
$l_update["log"]["confirm_delete"] = "Вы уверены, что хотите удалить?";

$l_update["log"]["legend"]["title"]   = "Отображать:";
$l_update["log"]["legend"]["messages"] = "сообщения";
$l_update["log"]["legend"]["notices"]  = "примечания";
$l_update["log"]["legend"]["errors"]   = "ошибки";


$l_update["connection_error"]["headline"] = "Обновление в данный момент невозможно";
$l_update["connection_error"]["text"]     = "В данный момент нет соединения с сервером webEdition (www.webedition.de). Попробуйте, пожалуйста, позже.<br><br>При соединении к интернет через Proxy-сервер проверьте, пожалуйста, настройки proxy.";
$l_update["connection_error"]["js_alert"] = "Нет соединения с сервером webEdition.\\nДля повторения попытки нажмите на кнопку «обновить»\\nили попробуйте позже.";


$l_update["language"]["headline"]       = "Инсталляция языков";
$l_update["language"]["description"]    = "Начиная с версии webEdition 3.0 возможна доинсталляция языкового пакета. Загрузочный языковой пакет зависит от версии webEdition. Инсталлируйте только нужные для работы языки.<br><br>В настоящее время Вы работаете в webEdition версии %s.";
$l_update["language"]["sysLng"]         = "Системный язык";
$l_update["language"]["usedLng"]        = "Применяемый язык";
$l_update["language"]["installed_lngs"] = "Инсталлированные языки";
$l_update["language"]["search"]         = "Поиск языков";
$l_update["language"]["delete"] = "Удалить выбранные языки";
$l_update["language"]["confirm_delete"] = "При продолжении операции из Вашей системы webEdition будут удалены выбранные языки. Если данный язык установлен языком по умолчанию, в дальнейшем будет использован системный язык %s.";
$l_update["language"]["delete_error_file"] = "Ошибка при удалении языковых файлов.\\nСледующий файл не был удален:\\n";
$l_update["language"]["delete_error_folder"] = " Ошибка при удалении языковых файлов.\\nСледующая директория не была удалена:\\n";



?>