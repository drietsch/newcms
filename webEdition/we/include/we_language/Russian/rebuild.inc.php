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
 * Language file: rebuild.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_rebuild"]["rebuild_documents"] = "Rebuild - documents"; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_maintable"] = "Пересохранить главную таблицу";
$GLOBALS["l_rebuild"]["rebuild_tmptable"] = "Пересохранить временную таблицу";
$GLOBALS["l_rebuild"]["rebuild_objects"] = "Объекты";
$GLOBALS["l_rebuild"]["rebuild_index"] = "Таблицы индексов";
$GLOBALS["l_rebuild"]["rebuild_all"] = "Все документы и шаблоны";
$GLOBALS["l_rebuild"]["rebuild_templates"] = "All templates"; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_filter"] = "Статические страницы webEdition";
$GLOBALS["l_rebuild"]["rebuild_thumbnails"] = "Перестройка – создание иконок";
$GLOBALS["l_rebuild"]["txt_rebuild_documents"] = "With this option the documents and templates saved in the data base will be written to the file system."; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_objects"] = "Выберите данную опцию для перезаписи таблиц объектов. Это необходимо при наличии ошибок в таблицах объектов.";
$GLOBALS["l_rebuild"]["txt_rebuild_index"] = "If in search some documents can not be found or are being found several times, you can rewrite the index table thus the search index here."; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_thumbnails"] = "Здесь можно переписать иконки графических изображений.";
$GLOBALS["l_rebuild"]["txt_rebuild_all"] = "С помощью данной опции переписываются все документы и шаблоны.";
$GLOBALS["l_rebuild"]["txt_rebuild_templates"] = "With this option all templates will be rewritten."; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_filter"] = "Здесь можно указать статические страницы, предназначенные для перезаписи. Если Вы ничего не указали, все статические страницы webEdition будут переписаны вновь.";
$GLOBALS["l_rebuild"]["rebuild"] = "Перестроить";
$GLOBALS["l_rebuild"]["dirs"] = "директории";
$GLOBALS["l_rebuild"]["thumbdirs"] = "графику в следующих директориях";
$GLOBALS["l_rebuild"]["thumbnails"] = "создать иконки";
$GLOBALS["l_rebuild"]["documents"] = "Documents and templates"; // TRANSLATE
$GLOBALS["l_rebuild"]["catAnd"] = "и соединение";
$GLOBALS["l_rebuild"]["finished"] = "Перестройка успешно завершена!";
$GLOBALS["l_rebuild"]["nothing_to_rebuild"] = "Нет статических документов, отвечающих выбранным критериям!";
$GLOBALS["l_rebuild"]["no_thumbs_selected"] = "Выберите, пожалуйста, по крайней мере одну иконку!";
$GLOBALS["l_rebuild"]["savingDocument"] = "Сохранение документа: ";
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviCheck"] = 'Rebuild static documents afterwards.'; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviHint"] = 'For static navigation entries a rebuild of the corresponding documents is necessary, in addition.'; // TRANSLATE
?>