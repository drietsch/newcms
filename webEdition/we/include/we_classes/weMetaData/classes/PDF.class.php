<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * @abstract implementation class of metadata reader for PDF metadata
 */
class weMetaData_PDF extends weMetaData {

	var $accesstypes = array("read","write");

	function __construct($filetype) {
		$this->weMetaData_PDF($filetype);
	}

	function weMetaData_PDF($filetype) {
		$this->filetype = $filetype;
	}

	function _checkDependencies() {
		return false;
	}

	function _getMetaData($selection = "") {
		if(!$this->_valid) return false;
		if(is_array($selection)) {
			// fetch some
		} else {
			// fetch all
		}
		return $this->metadata;
	}

}
?>