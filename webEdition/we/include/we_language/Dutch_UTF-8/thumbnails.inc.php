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
 * Language: Dutch
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_thumbnails["preload"] = "Bezig met laden van voorkeuren, één moment geduld a.u.b...";
$l_thumbnails["preload_wait"] = "Bezig met laden van voorkeuren";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Bezig met bewaren van voorkeuren, even geduld a.u.b. ...";
$l_thumbnails["save_wait"] = "Bezig met bewaren van voorkeuren";

$l_thumbnails["saved"] = "Voorkeuren zijn succesvol bewaard.";
$l_thumbnails["saved_successfully"] = "Voorkeuren bewaard";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Voer a.u.b. een naam in voor de nieuwe thumbnail!";
	$l_thumbnails["delete_prompt"] = "Verwijder thumbnail \'%s\'! Weet u het zeker?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Thumbnails";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Naam";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Eigenschappen";
	$l_thumbnails["width"] = "Breedte";
	$l_thumbnails["height"] = "Hoogte";
	$l_thumbnails["ratio"] = "Behoud aspect ratio";
	$l_thumbnails["maximize"] = "Maximaliseer indien vereist";
	$l_thumbnails["interlace"] = "Interlace Ja / Nee";
	$l_thumbnails["quality"] = "Quality"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Uitvoer formaat";
	$l_thumbnails["format_original"] = "Origineel formaat";
	$l_thumbnails["format_gif"] = "GIF bestand";
	$l_thumbnails["format_jpg"] = "JPEG bestand";
	$l_thumbnails["format_png"] = "PNG bestand";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Klik a.u.b. op de plus knop om thumbnails toe te voegen.";
	$l_thumbnails["add_description_nogdlib"] = "The gd bibliotheek has to be installed on your server to use the thumbnail functions. Please contact your server administrator for information on this library.";
	$l_thumbnails["format_not_supported"] = "De gd bibliotheek die geïnstalleerd is op uw server ondersteunt het afbeeldings formaat niet. Neem a.u.b. contact op met uw server administrator voor informatie over deze bibliotheek.";
	$l_thumbnails["no_image_uploaded"] = "U moet eerst een afbeelding uplaoden om gebruik te kunnen maken van de thumbnail functies.";

	$l_thumbnails["create_thumbnails"] = "Maak thumbnails aan";
?>