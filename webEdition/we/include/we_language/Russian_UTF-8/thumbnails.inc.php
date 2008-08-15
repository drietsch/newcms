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
 * Language file: thumbnails.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_thumbnails["preload"] = "Загружаются настройки ...";
$l_thumbnails["preload_wait"] = "Загрузка настроек";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Сохранение настроек ...";
$l_thumbnails["save_wait"] = "Сохранение настроек ";

$l_thumbnails["saved"] = "Настройки успешно сохранены";
$l_thumbnails["saved_successfully"] = "Настройки сохранены";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Введите имя для новой иконки! ";
	$l_thumbnails["delete_prompt"] = "Удалить иконку \'%s\'. Вы уверены?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Иконки";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Имя";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Свойства";
	$l_thumbnails["width"] = "Ширина";
	$l_thumbnails["height"] = "Высота";
	$l_thumbnails["ratio"] = "Сохранить пропорции";
	$l_thumbnails["maximize"] = "Увеличить по потребности";
	$l_thumbnails["interlace"] = "Interlace Yes / No"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Формат вывода на экран";
	$l_thumbnails["format_original"] = "Первоначальный формат";
	$l_thumbnails["format_gif"] = "Файл GIF";
	$l_thumbnails["format_jpg"] = "Файл JPEG";
	$l_thumbnails["format_png"] = "Файл PNG";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Для добавления новой иконки нужно нажать на кнопку «плюс»";
	$l_thumbnails["add_description_nogdlib"] = "Ипользование иконок обеспечивается установкой на сервере GD Library!";
	$l_thumbnails["format_not_supported"] = "Формат графики не поддерживается GD Library, установленной на сервере.";
	$l_thumbnails["no_image_uploaded"] = "Для использования иконок необходимо загрузить соответствующую графику!";

	$l_thumbnails["create_thumbnails"] = "Создание иконок";
?>