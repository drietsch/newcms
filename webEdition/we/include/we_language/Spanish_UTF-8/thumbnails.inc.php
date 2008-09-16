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
 * Language file: thumbnails.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_thumbnails["preload"] = "Loading preferences, one moment ..."; // TRANSLATE
$l_thumbnails["preload_wait"] = "Cargando preferencias";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Salvando preferencias, un momento ...";
$l_thumbnails["save_wait"] = "Salvando preferencias";

$l_thumbnails["saved"] = "Las preferencias han sido salvadas exitosamente.";
$l_thumbnails["saved_successfully"] = "Preferencias salvadas";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Por favor, entre el nombre de la nueva imagen en miniatura!";
	$l_thumbnails["delete_prompt"] = "Borrar imagen en miniatura \'%s\'! Está Ud seguro?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Imágenes en miniatura";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Nombre";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Propiedades";
	$l_thumbnails["width"] = "Ancho";
	$l_thumbnails["height"] = "Alto";
	$l_thumbnails["ratio"] = "Mantener proporción de aspecto";
	$l_thumbnails["maximize"] = "Máximizar si es requerido";
	$l_thumbnails["interlace"] = "Interlace Yes / No"; // TRANSLATE
	$l_thumbnails["quality"] = "Quality"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Formato de salida";
	$l_thumbnails["format_original"] = "Formato original";
	$l_thumbnails["format_gif"] = "Archivo GIF";
	$l_thumbnails["format_jpg"] = "Archivo JPEG";
	$l_thumbnails["format_png"] = "Archivo PNG";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Por favor, clic en el botón + para adicionar nuevas imágenes en miniatura";
	$l_thumbnails["add_description_nogdlib"] = "Damit Ihnen die Funktionen für Miniaturansichten zur Verfügung stehen, muß die GD Libraray auf Ihrem Server installiert sein!";
	$l_thumbnails["format_not_supported"] = "Das Format der Grafik wird leider nicht von der auf dem Server installierten GD Library unterstützt!";
	$l_thumbnails["no_image_uploaded"] = "Damit Ihnen die Funktionen für Miniaturansichten zur Verfügung stehen, muß zuerst eine Grafik hochgeladen werden!";

	$l_thumbnails["create_thumbnails"] = "Crear imágenes en miniatura";
?>