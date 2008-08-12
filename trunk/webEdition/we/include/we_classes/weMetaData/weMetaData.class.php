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
 * @abstract class for reading and writing metadata from/to media files (i.e. audio, video or image files)
 * 			The implementations are to be found in its subclasses (i.e. "weMetaData_IPTC")
 * @author Alexander Lindenstruth
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 26.09.2007
 */
class weMetaData {

	/**
	 * @var array specifies possible access methods to metadata handled by this implementation class (i.e. exif: readonly)
	 */
	var $accesstypes = array("read,write");

	/**
	 * @var array mapping of datatypes and their metadata models
	 */
	var $dataTypeMapping = array();

	/**
	 * @var string name and path of the file for read/write operations
	 */
	var $datasource = "";

	/**
	 * @var array access permissions to datasource (read and/or write). Other permissions can
	 * 			be implemented by subclasses (i.e. "modify")
	 */
	var $datasourcePerms = array();

	/**
	 * @var string filetype of the file that has to be read/written (i.e. "jpg")
	 */
	var $filetype = array();

	/**
	 * @var string array of metadata types that have to be read/written from/to the file
	 */
	var $datatype = array();

	/**
	 * @var array containing all metadata fetched from datasource
	 */
	var $metadata = array();

	/**
	 * @var array of objects instance of the implementation class for reading/writing metadata
	 * 			has to be an array because multiple metadata readers/writers can be specified for a fileformat.
	 */
	var $_instance = array();

	/**
	 * @var bool flag for validity checks within these classes
	 */
	var $_valid = true;

	/**
	 * @abstract constructor method for PHP5
	 * @param string filetype filetype of the file whose metadata has to be read  (i.e. "mp3")
	 * @return bool returns false if no spezialisation for the given filetype is available
	 */
	function __construct($source = "") {
		$this->weMetaData($source);
	}

	/**
	 * @abstract constructor for PHP4
	 * @param string filetype filetype of the file whose metadata has to be read  (i.e. "mp3")
	 * @return bool returns false if no spezialisation for the given filetype is available
	 */
	function weMetaData($source = "") {
		if(empty($source)) {
			$this->_valid = false;
			return false;
		}
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/conf/mapping.inc.php");
		$this->dataTypeMapping = $dataTypeMapping; // from mapping.inc.php
		$this->imageTypeMap = $imageTypeMap; // from mapping.inc.php

		if($this->_setDatasource($source)) {
			if($this->_setDatatype()) {
				foreach($this->datatype as $_type) {
					$this->_getInstance($_type);
				}
			}
		}
	}

	/*
	 * public methods for usage from outside
	 * their only purpose is to redirect calls to protected methods that can be overridden by subclasses
	 * to implement other behaviours so that all calls are being transparently redirected to an appropriate
	 * implementation class
	 */

	/**
	 * @abstract method for identifying all valid implementations for a given file.
	 * @return array of all valid metadata types or false if there are none
	 */
	function getImplementations() {
		if(!$this->_valid) return false;
		if(empty($this->datatype)) {
			return false;
		}
		return $this->datatype;
	}

	function getMetaData($selection = "") {
		if(!$this->_valid) return false;
		foreach($this->datatype as $_type) {
			if(!in_array("read",$this->_instance[$_type]->accesstypes)) {
				return false;
			} else {
				$this->metadata[strToLower($_type)] = $this->_instance[$_type]->_getMetaData();
			}
		}
		return $this->metadata;
	}

	function setMetaData($data = "", $datatype = "") {
		foreach($this->datatype as $_type) {
			if(!$this->_instance[$_type]->_valid) return false;
			if(!in_array("write",$this->_instance[$_type]->accesstypes)) {
				return false;
			} else {
				$this->_instance[$_type]->_setMetaData($data = "");
			}
		}
		return true;
	}

	/**
	 * @abstract saves fetched metadata to database, currently in table tblContent
	 * @return bool false if fails, else true
	 */
	function saveToDatabase($id = "") {
		if(!$this->_valid) return false;
		// table name: CONTENT_TABLE
		// currently all metadata is saved via we_root::setElement()
		return true;
	}

	/*
	 * protected methods, only for internal usage:
	 */

	/**
	 * @abstract method for setting the datasource that has to be used
	 * 			takes a webEdition document id and fetches document path and name from database (tblFile).
	 * 			this method has to be overridden if the used datasource is not a webEdition Document with
	 * 			tblFile database entry
	 * 			sets $this->datasourcePerms according to read/write rights
	 * @param string datasource id of webEdition document
	 * @return bool returns false if datasource is not valid
	 */
	function _setDatasource($datasource = "") {
		// determines if given datasource is valid. will be assignet to instances later:
		if(!$this->_valid) {
			return false;
		} else if(empty($datasource)) {
			$this->_valid = false;
			return false;
		} else if(is_numeric($datasource)) {
			// TODO: get path to file from database (tblFile)
			$datasource = $this->_getDatasourceFromDatabase($datasource);
		} else if(is_file($datasource)) {
			$this->_valid = true;
			if(is_readable($datasource)) {
				$this->datasourcePerms[] = "read";
			} else {
				$this->_valid = false;
			}
			if(is_writable($datasource)) {
				$this->datasourcePerms[] = "write";
			}
		} else {
			// check if it is a temporary file (i.e. an uploaded image that has not been saved yet):
			if(!is_readable($_SERVER["DOCUMENT_ROOT"]."webEdition/we/include/tmp/",$datasource)) {
				$this->_valid = false;
				return false;
			}
		}
		$this->datasource = $datasource;
		return true;
	}

	/**
	 * @abstract internal (private) function for obtaining path/name of the media file from database (tblFile)
	 */
	function _getDatasourceFromDatabase() {
			$this->_valid = false;
			return false;
	}

	/**
	 * @abstract method for detecting type of current file needed, for identifying correct metadata implementation class
	 */
	function _setDatatype() {
		/*
		 * detecting filetype in this order:
		 * 1. exif_imagetype()
		 * 2. file extension
		 */
		if(!$this->_valid) return false;
		if(is_callable("exif_imagetype")) {
			$_filetype = @exif_imagetype($this->datasource);
		} else {
			$_filetype = "";
		}
		// if $_filetype is a numeric value, filetype should first be identified by
		// Get fype for image-type returned by getimagesize, exif_read_data, exif_thumbnail, exif_imagetype
		if(!empty($_filetype) && is_numeric($_filetype)) {
			if(isset($this->imageTypeMap[$_filetype]) && !empty($this->imageTypeMap[$_filetype])) {
				$this->filetype = $this->imageTypeMap[$_filetype];
			} else {
				$this->_valid = false;
				$_filetype = "";
			}
		}
		// if first check fails try to identify file extension:
		if(empty($_filetype)) {
			// try to identify type of file by its extension by checking substring after last point in $this->datasource
			$_extension = strrchr($this->datasource,".");
			if(!empty($_extension) && $_extension!=".") {
				$this->filetype = substr($_extension,1);
			} else {
				$this->_valid = false;
				return false;
			}
		}

		if(array_key_exists(strtolower($this->filetype),$this->dataTypeMapping)) {
			$this->datatype = $this->dataTypeMapping[$this->filetype];
			$this->_valid = true;
		} else {
			$this->_valid = false;
			return false;
		}
		return true;
	}

	/**
	 * @return object instance of the metadata implementation class
	 * @return bool returns false if no or invalid datatype specified
	 */
	function _getInstance($value="") {
		if(!$this->_valid) return false;
		if(is_readable($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/classes/".$value.".class.php")) {
			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/classes/".$value.".class.php");
			$className = "weMetaData_".$value;
			$this->_instance[$value] = new $className($this->filetype);
			if(!$this->_instance[$value]->_checkDependencies()) {
				$this->_instance[$value]->_valid = false;
			} else {
				$this->_instance[$value]->_valid = true;
				$this->_instance[$value]->datasource = $this->datasource;
			}
			return true;
		} else {
			$this->_instance[$value]->_valid = false;
			return false;
		}
	}

	/**
	 * @abstract public method for fetching metadata from datasource
	 * @param mixed selection empty or "all" returns all metadata values available in given Datasource,
	 * 			a selection is specified as an array of metadata tags/fields
	 * @return array metadata according to $selection
	 */
	function _getMetaData($selection = "") {
		// override!
		return $this->metadata;
	}

	/**
	 * @abstract public method for fetching metadata from datasource
	 * @param mixed selection empty or "all" returns all metadata values available in given Datasource,
	 * 			a selection is specified as an array of metadata tags/fields
	 * @return array metadata according to $selection
	 */
	function _setMetaData($data = "", $datatype = "") {
		return true;
		// override!
	}

	/**
	 * @abstract checks if all dependencies of this class are met
	 * 			(i.e. if needed libraries, php extensions or classes are available)
	 * @return bool returns true if all dependencies are met and false if not
	 */
	function _checkDependencies() {
		// override!
		return true;
	}


	function getDefinedMetaDataFields() {
		// if metadataFields are not cached, we have to get them from db
		if (!isset($GLOBALS['WE_METADATA_DEFINED_FIELDS'])) {
			$GLOBALS['WE_METADATA_DEFINED_FIELDS'] = array();
			$GLOBALS['DB_WE']->query("SELECT * FROM " . METADATA_TABLE . " order by id,type");
			while ($GLOBALS['DB_WE']->next_record()) {
				$GLOBALS['WE_METADATA_DEFINED_FIELDS'][] = array(
					"id" => $GLOBALS['DB_WE']->f("id"),
					"tag" => $GLOBALS['DB_WE']->f("tag"),
					"type" => $GLOBALS['DB_WE']->f("type"),
					"importFrom" => $GLOBALS['DB_WE']->f("importFrom")
				);
			}
		}
		return $GLOBALS['WE_METADATA_DEFINED_FIELDS'];
	}
}
?>