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

$l_thumbnails["preload"] = "Ladataan asetuksia, hetkinen ...";
$l_thumbnails["preload_wait"] = "Ladataan asetuksia";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Tallennetaan asetuksia, hetkinen ...";
$l_thumbnails["save_wait"] = "Tallennetaan asetuksia";

$l_thumbnails["saved"] = "Asetukset on tallennettu.";
$l_thumbnails["saved_successfully"] = "Asetukset tallennettu";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Kirjoita esikatselukuvan nimi!";
	$l_thumbnails["delete_prompt"] = "Poista esikatselukuva \'%s\'! Oletko varma?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Esikatselukuvat";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Nimi";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Ominaisuudet";
	$l_thumbnails["width"] = "Leveys";
	$l_thumbnails["height"] = "Korkeus";
	$l_thumbnails["ratio"] = "Säilytä kuvasuhde";
	$l_thumbnails["maximize"] = "Maksimoi koko jos tarvetta";
	$l_thumbnails["interlace"] = "Limitys (interlace) Kyllä / Ei";
	$l_thumbnails["quality"] = "Quality"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Tallennustyyppi";
	$l_thumbnails["format_original"] = "Alkuperäinen tyyppi";
	$l_thumbnails["format_gif"] = "GIF -tiedosto";
	$l_thumbnails["format_jpg"] = "JPEG -tiedosto";
	$l_thumbnails["format_png"] = "PNG -tiedosto";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Paina plus -painiketta lisätäksesi uusia esikatselukuvia.";
	$l_thumbnails["add_description_nogdlib"] = "Käyttääksesi esikatselukuva toimintoja gd -kirjasto on asennettava palvelimella. Ota yhteyttä järjestelmän ylläpitäjään asenuspyyntöä varten.";
	$l_thumbnails["format_not_supported"] = "Asennettu gd- kirjasto ei tue kuvatyypiä. Ota yhteyttä järjestelmän ylläpitäjään korjataksesi ongelmatilanteen.";
	$l_thumbnails["no_image_uploaded"] = "Kuva on ladattava palvelimelle käyttääksesi esikatselukuva toimintoa.";

	$l_thumbnails["create_thumbnails"] = "Luo esikatselukuvia";
?>