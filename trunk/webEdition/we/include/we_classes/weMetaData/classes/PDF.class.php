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
 * @abstract implementation class of metadata reader for PDF metadata
 * @author Alexander Lindenstruth
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 27.09.2007
 * @uses -?-
 * @link -?-
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