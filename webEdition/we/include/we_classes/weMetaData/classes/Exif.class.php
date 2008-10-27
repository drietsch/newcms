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

// make accessable for others too, but use weMetaData_Exif::getUsedFields();
$GLOBALS['____weMetaData_Exif_usedFields'] = array(
		"FileDateTime",
		"FileSize",
		"FileType",
		"MimeType",
		"ImageDescription",
		"Make",
		"Model",
		"Orientation",
		"XResolution",
		"YResolution",
		"ResolutionUnit",
		"Software",
		"DateTime",
		"Artist",
		"HostComputer",
		"YCbCrPositioning",
		"ColorSpace",
		"ExifImageWidth",
		"ExifImageLength",
		"Copyright",
		"ExposureTime",
		"FNumber",
		"ExifVersion",
		"DateTimeOriginal",
		"ExposureBiasValue",
		"MeteringMode",
		"Flash",
		"FocalLength",
		"UserComment"
	);

/**
 * @abstract implementation class of metadata reader for Exif data
 * @author Alexander Lindenstruth
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 27.09.2007
 * @uses exif php exif functions, see link below for more information
 * @link http://de.php.net/manual/de/ref.exif.php reference manual for php exif functions
 */
class weMetaData_Exif extends weMetaData {

	var $accesstypes = array("read");

	function __construct($filetype) {
		$this->weMetaData_Exif($filetype);
	}

	function weMetaData_Exif($filetype) {
		$this->filetype = $filetype;
	}

	function getUsedFields() {
		return $GLOBALS['____weMetaData_Exif_usedFields'];
	}

	function _checkDependencies() {
		if(is_callable("exif_read_data")) {
			return true;
		} else {
			return false;
		}
	}

	function _getMetaData($selection = "") {
		if(!$this->_valid) return false;
		if(is_array($selection)) {
			// fetch some
		} else {
			// fetch all
			if(@exif_imagetype($this->datasource)) {
				$_metadata = @exif_read_data($this->datasource);
			} else {
				$this->_valid = false;
				return false;
			}
		}

		foreach($GLOBALS['____weMetaData_Exif_usedFields'] as $value) {
			if(isset($_metadata[$value])) {
				$this->metadata[$value] = $_metadata[$value];
			}
		}
		//$this->metadata = $_metadata;
		return $this->metadata;
	}

}
?>