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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * @abstract mapping for filetypes and implementations of metadata reader/writer
 * 			uses fileextensions for deciding, wich implementation class has to be used
 */

/**
 * @var array mapping array
 */
$dataTypeMapping = array(
	"jpe" => array("Exif","IPTC"),  // iptc support is currently broken, will be fixed later
	"jpg" => array("Exif","IPTC"),
	"jpeg" => array("Exif","IPTC"),
	//"pdf" => array("PDF"), // not implemented yet
);

// wbmp support in exif_read_data() for PHP Version 4.3.2 and newer
if(version_compare(PHP_VERSION, "4.3.2", "ge")) {
	$dataTypeMapping["wbmp"] = array("Exif");
}

/**
 * @var mapping of image type constants (int) to file extensions (i.e. "1" => "gif")
 * @link http://de.php.net/manual/de/function.exif-imagetype.php php reference manual
 */
$imageTypeMap = array(
	"", // image type 0 not defined
	"gif", // IMAGETYPE_GIF
	"jpg", // IMAGETYPE_JPEG
	"png", // IMAGETYPE_PNG
	"swf", // IMAGETYPE_SWF
	"psd", // IMAGETYPE_PSD
	"bmp", // IMAGETYPE_BMP
	"tif", // IMAGETYPE_TIFF_II intel-Bytefolge
	"tif", // IMAGETYPE_TIFF_MM motorola-Bytefolge
	"jpc", // IMAGETYPE_JPC
	"jp2", // IMAGETYPE_JP2
	"jpx", // IMAGETYPE_JPX
	"jb2", // IMAGETYPE_JB2
	"swc", // IMAGETYPE_SWC
	"iff", // IMAGETYPE_IFF
	"wbmp", // IMAGETYPE_WBMP
	"xbm", // IMAGETYPE_XBM
);
?>
