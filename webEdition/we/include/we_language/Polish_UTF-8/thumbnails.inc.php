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
 * Language file: thumbnails.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_thumbnails["preload"] = "Loading preferences, one moment ..."; // TRANSLATE
$l_thumbnails["preload_wait"] = "Ładuj ustawienia";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Ustawienia są zapisywane, proszę czekać ...";
$l_thumbnails["save_wait"] = "Zapisz ustawienia";

$l_thumbnails["saved"] = "Zapisano ustawienia.";
$l_thumbnails["saved_successfully"] = "Zapisano ustawienia";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Proszę nadać nazwę nowej miniaturze podglądu!";
	$l_thumbnails["delete_prompt"] = "Usuń podgląd miniatury \'%s\'! Jesteś pewien?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Podgląd miniatury";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Nazwa";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Właściwości";
	$l_thumbnails["width"] = "Szerokość";
	$l_thumbnails["height"] = "Wysokość";
	$l_thumbnails["ratio"] = "Zachowaj proporcje";
	$l_thumbnails["maximize"] = "Maksymalizuj w razie potrzeby";
	$l_thumbnails["interlace"] = "Interlace Yes / No"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Format zadania";
	$l_thumbnails["format_original"] = "Oryginalny format";
	$l_thumbnails["format_gif"] = "Plik GIF";
	$l_thumbnails["format_jpg"] = "Plik JPEG";
	$l_thumbnails["format_png"] = "Plik PNG";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Aby dodać nową mianiaturę kliknij w klawisz Plus";
	$l_thumbnails["add_description_nogdlib"] = "Aby funkcja podglądu miniatur była dostępna wymagana jest na serwerze instalacja GD Library!";
	$l_thumbnails["format_not_supported"] = "Format grafiki nie jest obsługiwany przez zainstalowaną GD Library!";
	$l_thumbnails["no_image_uploaded"] = "Najpierw załaduj plik graficzny!";

	$l_thumbnails["create_thumbnails"] = "Utwórz podgląd miniatury";
?>