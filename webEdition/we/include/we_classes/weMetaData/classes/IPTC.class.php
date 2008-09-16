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

$GLOBALS['____weMetaData_IPTC_usedFields'] = array(
	'object_name',
	'edit_status',
	'priority',
	'category',
	'supplementary_category',
	'fixture_identifier',
	'keywords',
	'release_date',
	'release_time',
	'special_instructions',
	'reference_service',
	'reference_date',
	'reference_number',
	'created_date',
	'originating_program',
	'program_version',
	'object_cycle',
	'byline',
	'byline_title',
	'city',
	'province_state',
	'country_code',
	'country',
	'original_transmission_reference',
	'headline',
	'credit',
	'source',
	'copyright_string',
	'caption',
	'local_caption',
	'caption_writer'
);



/**
 * @abstract implementation class of metadata reader for IPTC data
 * @author Alexander Lindenstruth
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 27.09.2007
 * @uses IPTC PEAR_IPTC Package for reading IPTC data. See link below for more information
 * @link http://pear.php.net/package/Image_IPTC/ PEAR IPTC Package
 */
class weMetaData_IPTC extends weMetaData {

	var $accesstypes = array("read");

	function __construct($filetype) {
		$this->weMetaData_IPTC($filetype);
	}

	function weMetaData_IPTC($filetype) {
		$this->filetype = $filetype;
	}

	function _checkDependencies() {
		if(is_readable($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/lib/PEAR_IPTC.php")) {
			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/lib/PEAR_IPTC.php");
			return true;
		} else {
			return false;
		}
	}

	function getUsedFields() {
		return $GLOBALS['____weMetaData_IPTC_usedFields'];
	}

	function _getMetaData($selection = "") {
		if(!$this->_valid) return false;

		// seems not to work correctly so only an empty array is returned to caller:
		$this->metadata = array();
		//$this->metadata = array("Copyright" => "/me","Make" => "Fuji");

		$_iptcData = new Image_IPTC($this->datasource);
		if($_iptcData->isValid()) {
			if(is_array($selection)) {
				// fetch some tags
				foreach($selection as $value) {
					$this->metadata[] = $_iptcData->getTag($value);
				}
			} else {
				foreach ($GLOBALS['____weMetaData_IPTC_usedFields'] as $fieldName) {
					$_data = $_iptcData->getTag($fieldName);
					if (!is_null($_data)) {
						$this->metadata[$fieldName] = $_data;
					}
				}
			}
		}

		return $this->metadata;
	}

}
?>