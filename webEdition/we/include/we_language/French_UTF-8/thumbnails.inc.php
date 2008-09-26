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
$l_thumbnails["preload_wait"] = "Chargement des préférences";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Enregistrement des préférences en cours, un moment s'il vous plaît ...";
$l_thumbnails["save_wait"] = "Enregistrement des préférence";

$l_thumbnails["saved"] = "Les préférences ont été enregistré avec succès.";
$l_thumbnails["saved_successfully"] = "Préférences enregistrés";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "S'il vous plaît saisissez le nom de la novelle imagette!";
	$l_thumbnails["delete_prompt"] = "Supprimer l'imagette \'%s\' ! Êtes-vous sûr?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Imagettes";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Nom";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Propriété";
	$l_thumbnails["width"] = "Largeur";
	$l_thumbnails["height"] = "Hauteur";
	$l_thumbnails["ratio"] = "Garder les proportions";
	$l_thumbnails["maximize"] = "Si besoin est maximaliser";
	$l_thumbnails["interlace"] = "Interlace Yes / No"; // TRANSLATE
	$l_thumbnails["quality"] = "Quality"; // TRANSLATE

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Format d'Edition";
	$l_thumbnails["format_original"] = "Format original";
	$l_thumbnails["format_gif"] = "Fichier GIF";
	$l_thumbnails["format_jpg"] = "Fichier JPEG";
	$l_thumbnails["format_png"] = "Ficher PNG";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Pour ajouter une imagette, cliquez s'il vous plaît sur le button-plus";
	$l_thumbnails["add_description_nogdlib"] = "Pour que vous puisse profiter des fonctions des imagettes, il est nécéssaire que la GD Library soit installée!";
	$l_thumbnails["format_not_supported"] = "Le Format de la graphique n'est pas supporter par la GD Library installée sur le serveur!";
	$l_thumbnails["no_image_uploaded"] = "Pour que vous puisse profiter des fonctions des imagettes,il est nécéssaire qu'une graphic est chargée!";

	$l_thumbnails["create_thumbnails"] = "Crée des Imagettes";
?>