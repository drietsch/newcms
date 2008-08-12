<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: thumbnails.inc.php,v 1.11 2007/06/20 07:22:24 damjan.denic Exp $

/**
 * Language file: thumbnails.inc.php
 * Provides language strings.
 * Language: English
 */

/*****************************************************************************
 * PRELOAD
 *****************************************************************************/

$l_thumbnails["preload"] = "Loading preferences, one moment ...";
$l_thumbnails["preload_wait"] = "Loading preferences";

/*****************************************************************************
 * SAVE
 *****************************************************************************/

$l_thumbnails["save"] = "Saving preferences, one moment ...";
$l_thumbnails["save_wait"] = "Saving preferences";

$l_thumbnails["saved"] = "Preferences have been saved successfully.";
$l_thumbnails["saved_successfully"] = "Preferences saved";

/*****************************************************************************
 * THUMBNAILS
 *****************************************************************************/

	/**
	 * JAVASCRIPT
	 */

	$l_thumbnails["new"] = "Please enter a name of the new thumbnail!";
	$l_thumbnails["delete_prompt"] = "Delete thumbnail \'%s\'! Are you sure?";

	/**
	 * CAPTION
	 */

	$l_thumbnails["thumbnails"] = "Thumbnails";

	/**
	 * NAME
	 */

	$l_thumbnails["name"] = "Name";

	/**
	 * PROPERTIES
	 */

	$l_thumbnails["properties"] = "Properties";
	$l_thumbnails["width"] = "Width";
	$l_thumbnails["height"] = "Height";
	$l_thumbnails["ratio"] = "Keep aspect ratio";
	$l_thumbnails["maximize"] = "Maximize if required";
	$l_thumbnails["interlace"] = "Interlace Yes / No";
	$l_thumbnails["quality"] = "Quality";

	/**
	 * FORMAT
	 */

	$l_thumbnails["format"] = "Output format";
	$l_thumbnails["format_original"] = "Original format";
	$l_thumbnails["format_gif"] = "GIF file";
	$l_thumbnails["format_jpg"] = "JPEG file";
	$l_thumbnails["format_png"] = "PNG file";

/*****************************************************************************
 * THUMBNAILS View
 *****************************************************************************/

	$l_thumbnails["add_descriptiontext"] = "Please click on the plus button to add new thumbnails.";
	$l_thumbnails["add_description_nogdlib"] = "The gd library has to be installed on your server to use the thumbnail functions. Please contact your server administrator for information on this library.";
	$l_thumbnails["format_not_supported"] = "The gd library installed on your server does not support the image format. Please contact your server administrator for information on this library.";
	$l_thumbnails["no_image_uploaded"] = "First you have to upload an image to use the thumbnail functions.";

	$l_thumbnails["create_thumbnails"] = "Create thumbnails";
?>