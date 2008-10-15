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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weAbstractCustomerFilter.class.php");

define("WECF_ACCESS", "f_1");
define("WECF_CONTROLONTEMPLATE", "f_2");
define("WECF_NO_ACCESS", "f_3");
define("WECF_NO_LOGIN", "f_4");

/**
 * Customer filter (model) for document (or object) filters
 *
 */
class weDocumentCustomerFilter extends weAbstractCustomerFilter {

	/**
	 * db-id of filter
	 *
	 * @var integer
	 */
	var $_id=0;

	/**
	 * Id of model (document or object)
	 *
	 * @var integer
	 */
	var $_modelId = 0;

	/**
	 * DocumentType of model (eg. text/webEdition)
	 *
	 * @var string
	 */
	var $_modelType = "";

	/**
	 * Table where model is stored in db (eg. FILE_TABLE)
	 *
	 * @var string
	 */
	var $_modelTable = "";

	/**
	 * Flag if access control is made by template or not
	 *
	 * @var boolean
	 */
	var $_accessControlOnTemplate = false;

	/**
	 * Id of Document which is shown when customer is not logged in
	 *
	 * @var boolean
	 */
	var $_errorDocNoLogin = 0;


	/**
	 * Id of Document which is shown when customer has no acces
	 *
	 * @var boolean
	 */
	var $_errorDocNoAccess = 0;


	/**
	 * Constructor for PHP 4
	 *
	 * @param integer $id
	 * @param integer $modelId
	 * @param string $modelType
	 * @param string $modelTable
	 * @param boolean $accessControlOnTemplate
	 * @param integer $errorDocNoLogin
	 * @param integer $errorDocNoAccess
	 * @param integer $mode
	 * @param array $specificCustomers
	 * @param array $filter
	 * @param array $whiteList
	 * @param array $blackList
	 * @return weDocumentCustomerFilter
	 */
	function weDocumentCustomerFilter ($id=0, $modelId=0, $modelType="", $modelTable="", $accessControlOnTemplate=true, $errorDocNoLogin=0, $errorDocNoAccess=0, $mode=WECF_OFF, $specificCustomers=array(), $filter=array(), $whiteList=array(), $blackList=array()) {
		$this->__construct($id, $modelId, $modelType, $modelTable, $accessControlOnTemplate, $errorDocNoLogin, $errorDocNoAccess, $mode, $specificCustomers, $filter, $whiteList, $blackList);
	}

	/**
	 * Constructor for PHP 5
	 *
	 * @param integer $id
	 * @param integer $modelId
	 * @param string $modelType
	 * @param string $modelTable
	 * @param boolean $accessControlOnTemplate
	 * @param integer $errorDocNoLogin
	 * @param integer $errorDocNoAccess
	 * @param integer $mode
	 * @param array $specificCustomers
	 * @param array $filter
	 * @param array $whiteList
	 * @param array $blackList
	 * @return weDocumentCustomerFilter
	 */
	function __construct($id=0, $modelId=0, $modelType="", $modelTable="", $accessControlOnTemplate=true, $errorDocNoLogin=0, $errorDocNoAccess=0, $mode=WECF_OFF, $specificCustomers=array(), $filter=array(), $whiteList=array(), $blackList=array()) {
		parent::__construct($mode, $specificCustomers, $blackList, $whiteList, $filter);
		$this->setId($id);
		$this->setModelId($modelId);
		$this->setModelType($modelType);
		$this->setModelTable($modelTable);
		$this->setAccessControlOnTemplate($accessControlOnTemplate);
		$this->setErrorDocNoLogin($errorDocNoLogin);
		$this->setErrorDocNoAccess($errorDocNoAccess);
	}


	/**
	 * initializes and returns filter object from db object. Called after $db->query();
	 *
	 * @param we_db $db
	 * @return weDocumentCustomerFilter
	 */
	function getFilterByDbObject(&$db) {
		$_f = @unserialize($db->f('filter'));
		return new weDocumentCustomerFilter(
						abs($db->f("id")),
						abs($db->f("modelId")),
						$db->f("modelType"),
						$db->f("modelTable"),
						abs($db->f("accessControlOnTemplate")),
						abs($db->f("errorDocNoLogin")),
						abs($db->f("errorDocNoAccess")),
						abs($db->f("mode")),
						makeArrayFromCSV($db->f("specificCustomers")),
						$_f,
						makeArrayFromCSV($db->f("whiteList")),
						makeArrayFromCSV($db->f("blackList"))
					);
	}

	/**
	 * initializes and returns filter object from request
	 *
	 * param webeditionDocument or objectFile
	 * @param mixed $model
	 * @return weDocumentCustomerFilter
	 */
	function getCustomerFilterFromRequest(&$model) {

		if ($_REQUEST["wecf_mode"] == WECF_OFF ) {
			return weDocumentCustomerFilter::getEmptyDocumentCustomerFilter();
		} else {
			$_specificCustomers = weDocumentCustomerFilter::getSpecificCustomersFromRequest();
			$_blackList = weDocumentCustomerFilter::getBlackListFromRequest();
			$_whiteList = weDocumentCustomerFilter::getWhiteListFromRequest();
			$_filter = weDocumentCustomerFilter::getFilterFromRequest();


			return new weDocumentCustomerFilter(
				abs($_REQUEST["weDocumentCustomerFilter_id"]),
				abs($model->ID),
				$model->ContentType,
				$model->Table,
				($_REQUEST["wecf_accessControlOnTemplate"] == "onTemplate") ? 1 : 0,
				abs($_REQUEST["wecf_noLoginId"]),
				abs($_REQUEST["wecf_noAccessId"]),
				abs($_REQUEST["wecf_mode"]),
				$_specificCustomers,
				$_filter,
				$_whiteList,
				$_blackList
			);
		}
	}

	/**
	 * initializes and returns filter object from model
	 *
	 * @param mixed $model
	 * @return weDocumentCustomerFilter
	 */
	function getFilterOfDocument( &$model ) {
		return weDocumentCustomerFilter::getFilterByIdAndTable($model->ID, $model->Table);
	}


	/**
	 * initializes and returns filter object
	 *
	 * @param integer $id
	 * @param string $contentType
	 * @return weDocumentCustomerFilter
	 */
	function getFilterByIdAndTable($id, $table) {
		$db = new DB_WE();
		$query = "
			SELECT *
			FROM " . CUSTOMER_FILTER_TABLE . "
			WHERE modelTable='" . mysql_real_escape_string($table) . "'
				AND modelId = '" . abs($id) . "'
		";
		$db->query($query);
		if ( $db->next_record()) {
			return weDocumentCustomerFilter::getFilterByDbObject($db);
		}
		unset($db);
		return ""; // important do NOT return null
	}

	/**
	 * get additional condition for listviews
	 *
	 * @param we_listview $listview
	 * @return string
	 */
	function getConditionForListviewQuery( &$listview ) {
		
		if ( $listview->customerFilterType === 'off' || $listview->customerFilterType === 'false') {
			return '';
		}
		$_queryTail = "";
		$_allowedCTs = array("text/webedition", "objectFile");

		// if customer is not logged in, all documents/objects with filters must be hidden
		$_restrictedFilesForCustomer = weDocumentCustomerFilter::_getFilesWithRestrictionsOfCustomer($listview);
		
		if ($listview->ClassName == "we_search_listview") { // search

			// build query from restricted files, regard search and normal listview
			foreach ( $_restrictedFilesForCustomer as $ct => $_fileArray ) {

				if (in_array($ct, $_allowedCTs)) {

					if ($ct == "text/webedition") {
						$_idField = "DID";

					} else {
						$_idField = "OID";

					}
					if (sizeof($_fileArray)) {
						$_queryTail .= " AND $_idField NOT IN(" . implode(", ", $_fileArray) . ")";

					}
				}
			}

		} else {

			$_fileArray = array();
			// build query from restricted files, regard search and normal listview
			foreach ( $_restrictedFilesForCustomer as $ct => $_fileArray ) {

				if (in_array($ct, $_allowedCTs)) {

					if ($ct == "text/webedition") {
						$_idField = FILE_TABLE . ".ID";
					} else {
						$_idField = OBJECT_X_TABLE . $listview->classID . ".OF_ID";
					}
				}
			}
			if (sizeof($_fileArray)) {
				$_queryTail = " AND $_idField NOT IN(" . implode(", ", $_fileArray) . ")";

			}
		}
		return $_queryTail;

	}

	/**
	 * returns empty filter object
	 *
	 * @return weDocumentCustomerFilter
	 */
	function getEmptyDocumentCustomerFilter() {
		$_obj = new weDocumentCustomerFilter();
		return $_obj;
	}

	/**
	 * compares two filters and returns true if they have equal data
	 *
	 * @param weDocumentCustomerFilter $filter1
	 * @param weDocumentCustomerFilter $filter2
	 * @param boolean $applyCheck if also model data should be compared
	 * @static
	 * @return boolean
	 */
	function filterAreQual($filter1="", $filter2="", $applyCheck=false){

		if ($filter1 === "") {
			$filter1 = weDocumentCustomerFilter::getEmptyDocumentCustomerFilter();
		}
		if ($filter2 === "") {
			$filter2 = weDocumentCustomerFilter::getEmptyDocumentCustomerFilter();
		}

		$checkFields = array('modelTable', 'accessControlOnTemplate', 'errorDocNoLogin', 'errorDocNoAccess', 'mode', 'specificCustomers', 'filter', 'whiteList', 'blackList');
		if (!$applyCheck) {
			array_push($checkFields, "modelId");
			array_push($checkFields, "modelType");

		}
		$_length = sizeof($checkFields);

		for ($i=0; $i<$_length;$i++) {

			$_fn = "get" . ucfirst($checkFields[$i]);
			if ($filter1->$_fn($i) != $filter2->$_fn($i)) {
				return false;

			}

		}
		return true;
	}

	/**
	 * gets the right error document id
	 *
	 * @param String $errorConstant
	 * @return integer
	 */
	function getErrorDoc( $errorConstant ) {

		$_ret = 0;
		switch ($errorConstant) {

			case WECF_NO_LOGIN:
				$_ret = ($this->_errorDocNoLogin ? $this->_errorDocNoLogin : $this->_errorDocNoAccess);
				break;

			case WECF_NO_ACCESS:
				$_ret = ($this->_errorDocNoAccess ? $this->_errorDocNoAccess : $this->_errorDocNoLogin);
				break;
			default:
				break;

		}
		return $_ret;

	}

	/**
	 * saves the filter data in db. Call this on save method of model
	 *
	 * param webeditionDocument or objectFile
	 * @param mixed $model
	 */
	function saveForModel( &$model ) {

		// check if there were any changes?
		$_docCustomerFilter = $model->documentCustomerFilter; // filter of document
		$_tmp = weDocumentCustomerFilter::getFilterOfDocument($model); // filter stored in Database

		if ( !weDocumentCustomerFilter::filterAreQual( $_docCustomerFilter, $_tmp ) ) { // the filter changed

			weDocumentCustomerFilter::deleteForModel($model);

			if ($_docCustomerFilter->getMode() != WECF_OFF && $model->ID) { // only save if its is active

				$_filter = $_docCustomerFilter->getFilter();
				$_filter = !empty($_filter) ? addslashes(serialize($_filter)) : "";
				$_specificCustomers = $_docCustomerFilter->getSpecificCustomers();
				$_specificCustomers = !empty($_specificCustomers) ? addslashes(makeCSVFromArray($_specificCustomers,true)) : "";
				$_blackList = $_docCustomerFilter->getBlackList();
				$_blackList = !empty($_blackList) ? addslashes(makeCSVFromArray($_blackList,true)) : "";
				$_whiteList = $_docCustomerFilter->getWhiteList();
				$_whiteList = !empty($_whiteList) ? addslashes(makeCSVFromArray($_whiteList,true)) : "";

				$_query = "
		INSERT INTO " . CUSTOMER_FILTER_TABLE . "
		(modelId, modelType, modelTable, accessControlOnTemplate, errorDocNoLogin, errorDocNoAccess, mode, specificCustomers, filter, whiteList, blackList)
		VALUES($model->ID, '$model->ContentType', '$model->Table', '" . $_docCustomerFilter->getAccessControlOnTemplate() . "', " . $_docCustomerFilter->getErrorDocNoLogin() . ", " . $_docCustomerFilter->getErrorDocNoAccess() . ", '" . $_docCustomerFilter->getMode() . "', '" . $_specificCustomers . "', '" . $_filter . "', '" . $_whiteList . "', '" . $_blackList . "')
				";

				$_db = new DB_WE();
				$_db->query( $_query );
				unset($_db);
			}
		}
	}

	/**
	 * Call this function, when model is deleted !
	 * this function is called, when model with filter is saved (filters are resaved)
	 *
	 * param webeditionDocument or objectFile
	 * @param mixed $model
	 */
	function deleteForModel(&$model) {

		if ($model->ID) {
			$_db = new DB_WE();
			$_query = "
			DELETE FROM " . CUSTOMER_FILTER_TABLE . "
			WHERE
				modelId=" . $model->ID . "
				AND modelType=\"" . $model->ContentType . "\"
				AND modelTable=\"" . $model->Table . "\"
			";
			$_db->query($_query);
			unset($_db);
		}
	}

	/**
	 * Call this function, if customer is deleted
	 *
	 * @param weCustomer $webUser
	 */
	function deleteWebUser(&$webUser) {

		if ($webUser->ID) {
			$_db = new DB_WE();
			$_db2 = new DB_WE();

			$_db->query("SELECT id, specificCustomers, whiteList, blackList FROM " . CUSTOMER_FILTER_TABLE . " WHERE " .
				" specificCustomers like '%,".$webUser->ID.",%' OR whiteList like '%,".$webUser->ID.",%' OR blackList like '%,".$webUser->ID.",%'");

			while($_db->next_record()) {
				$_sc = $_db->f('specificCustomers');
				$_wl = $_db->f('whiteList');
				$_bl = $_db->f('blackList');

				$_sc = str_replace(",".$webUser->ID.",", ",", $_sc);
				if ($_sc == ",") $_sc = "";

				$_wl = str_replace(",".$webUser->ID.",", ",", $_wl);
				if ($_wl == ",") $_wl = "";

				$_bl = str_replace(",".$webUser->ID.",", ",", $_bl);
				if ($_bl == ",") $_bl = "";

				$_db2->query("UPDATE " . CUSTOMER_FILTER_TABLE . " SET specificCustomers='$_sc', whiteList='$_wl', blackList='$_bl' WHERE id=".intval($_db->f('id')));
			}

			unset($_db);
			unset($_db2);
		}
	}

	/**
	 * Deletes all filters for given modelIds of table
	 * call this, when several models are deleted
	 */
	function deleteModel($modelIds=array(), $table) {
		if ( sizeof($modelIds) ) {
			$_db = new DB_WE();
			$_query = "
			DELETE FROM " . CUSTOMER_FILTER_TABLE . "
			WHERE
				modelId IN (" . implode(", ", $modelIds) . ")
				AND modelTable = \"" . $table . "\"
			";
			$_db->query($_query);
			unset($_db);
		}

	}

	/**
	 * private function. gets all file ids which customer can not accesss
	 *
	 * @param we_listview $listview
	 * @return array
	 */
	function _getFilesWithRestrictionsOfCustomer(&$listview) {
		$_db = new DB_WE();
		$_cid = isset($_SESSION["webuser"]["ID"]) ? $_SESSION["webuser"]["ID"] : 0;
		$_filesWithRestrictionsForCustomer = array();
		$_defaultQuery = !weDocumentCustomerFilter::customerIsLogedIn() ? "(mode=" . WECF_ALL . ") OR " : "";
		
		$_blacklistQuery = " (mode=".WECF_FILTER." AND blackList LIKE '%,$_cid,%') ";
		$_whiteLlistQuery = " (mode=".WECF_FILTER." AND whiteList NOT LIKE '%,$_cid,%') ";
		$_specificCustomersQuery = " (mode=" . WECF_SPECIFIC . " AND specificCustomers NOT LIKE '%,$_cid,%') ";

		$_accessControlOnTemplateQuery = ( ($listview->customerFilterType != 'all' && $listview->customerFilterType != 'true') ? ' AND (accessControlOnTemplate = 0) '  :  '' );
		
		// detect all files/objects with restrictions
		if ($listview->ClassName == "we_search_listview") {
			$_queryForIds = "
					SELECT *
					FROM " . CUSTOMER_FILTER_TABLE .
					" WHERE $_defaultQuery $_blacklistQuery OR ( ($_specificCustomersQuery OR $_whiteLlistQuery) $_accessControlOnTemplateQuery)";

		} else {

			if ( $listview->ClassName == "we_listview" ) { // type="document"
				$_queryForIds = "
					SELECT *
					FROM " . CUSTOMER_FILTER_TABLE . "
					WHERE modelType='text/webedition'" .
					" AND ($_defaultQuery $_blacklistQuery OR ( ($_specificCustomersQuery OR $_whiteLlistQuery) $_accessControlOnTemplateQuery))";

			} else if ( $listview->ClassName == "we_listview_object" || $listview->ClassName == "we_listview_multiobject") { // type="object"
				$_queryForIds = "
					SELECT *
					FROM " . CUSTOMER_FILTER_TABLE . "
					WHERE modelType='objectFile'" .
					" AND ($_defaultQuery $_blacklistQuery OR ( ($_specificCustomersQuery OR $_whiteLlistQuery) $_accessControlOnTemplateQuery))";

			}
		}
		// if customer is not logged in=> return WECF_NO_LOGIN
		// else return correct filter

		// execute the query (get all existing filters)
		$_db->query($_queryForIds);

		if ( !weDocumentCustomerFilter::customerIsLogedIn() ) { // visitor is not logged in

			// Vistior is not logged in => Visitor has no Access to files with filters!
			if ($_db->num_rows()) {

				$_dummyFilters = array();
				while ($_db->next_record()) {
					$_filesWithRestrictionsForCustomer[$_db->f("modelType")][] = $_db->f("modelId");
				}
			}


		} else { // visitor has logged in


			$_filters = array();
			if ($_db->num_rows()) {

				while ($_db->next_record()) {
					$_filters[] = weDocumentCustomerFilter::getFilterByDbObject($_db);
				}
			}

			$__tmp = array();

			foreach ( $_filters as $filter ) {
				$_perm = $filter->accessForVisitor( $__tmp, array("id" => $filter->getModelId(), "contentType" => $filter->getModelType()), false, true);
				switch ( $_perm ) {
					case WECF_NO_ACCESS:
					case WECF_NO_LOGIN:
						$_filesWithRestrictionsForCustomer[$filter->getModelType()][] = $filter->getModelId();
						break;
					case WECF_CONTROLONTEMPLATE:
						if ($listview->customerFilterType == 'all' || $listview->customerFilterType == 'true') {
							$_filesWithRestrictionsForCustomer[$filter->getModelType()][] = $filter->getModelId();
						}
						break;

				}
			}
		}
		unset( $_db );
		return $_filesWithRestrictionsForCustomer;

	}

	/**
	 * checks if visitor has acces to see the document or object
	 *
	 * @param mixed $model
	 * @param array $modelHash
	 * @param boolean $_fromIfRegisteredUser
	 * @return string
	 */
	function accessForVisitor( &$model, $modelHash="", $_fromIfRegisteredUser=false, $_fromListviewCheck=false ) {
		if ( !empty($model) ) {
			$modelHash["id"] = $model->ID;
			$modelHash["contentType"] = $model->ContentType;

		}
		if ( $modelHash["id"] == $this->getModelId() && $modelHash["contentType"] == $this->getModelType() ) { // model is correct
			
			if ( !$_fromListviewCheck && $this->getAccessControlOnTemplate() && !$_fromIfRegisteredUser ) {
				// access control is on template (for we:ifregisteredUser)
				return WECF_CONTROLONTEMPLATE;

			}

			if ( !weDocumentCustomerFilter::customerIsLogedIn() ) { // no customer logged in
				// visitor is NOT logged in
				return WECF_NO_LOGIN;

			}

			if (!$this->customerHasAccess()) {
				return WECF_NO_ACCESS;
			}

		}
		return WECF_ACCESS;

	}

	/* ############################ Accessors and Mutators ###################################*/


	/**
	 * Mutator method for $this->_id
	 *
	 * @param integer $id
	 */
	function setId($id) {
		$this->_id = $id;
	}

	/**
	 * Accessor method for $this->_id
	 *
	 * @return integer
	 */
	function getId() {
		return $this->_id;
	}

	/**
	 * Mutator method for $this->_modelId
	 *
	 * @param integer $modelId
	 */
	function setModelId($modelId) {
		$this->_modelId = $modelId;
	}

	/**
	 * Accessor method for $this->_modelId
	 *
	 * @return integer
	 */
	function getModelId() {
		return $this->_modelId;
	}

	/**
	 * Mutator method for $this->_modelType
	 *
	 * @param string $modelType
	 */
	function setModelType($modelType) {
		$this->_modelType = $modelType;
	}

	/**
	 * Accessor method for $this->_modelType
	 *
	 * @return string
	 */
	function getModelType() {
		return $this->_modelType;
	}

	/**
	 * Mutator method for $this->_modelTable
	 *
	 * @param string $modelTable
	 */
	function setModelTable($modelTable) {
		$this->_modelTable = $modelTable;
	}

	/**
	 * Accessor method for $this->_modelTable
	 *
	 * @return string
	 */
	function getModelTable() {
		return $this->_modelTable;
	}

	/**
	 * Mutator method for $this->_accessControlOnTemplate
	 *
	 * @param boolean $accessControlOnTemplate
	 */
	function setAccessControlOnTemplate($accessControlOnTemplate) {
		$this->_accessControlOnTemplate = $accessControlOnTemplate;
	}

	/**
	 * Accessor method for $this->_accessControlOnTemplate
	 *
	 * @return boolean
	 */
	function getAccessControlOnTemplate() {
		return $this->_accessControlOnTemplate;
	}

	/**
	 * Mutator method for $this->_errorDocNoLogin
	 *
	 * @param integer $errorDocNoLogin
	 */
	function setErrorDocNoLogin($errorDocNoLogin) {
		$this->_errorDocNoLogin = $errorDocNoLogin;
	}

	/**
	 * Accessor method for $this->_errorDocNoLogin
	 *
	 * @return integer
	 */
	function getErrorDocNoLogin() {
		return $this->_errorDocNoLogin;
	}

	/**
	 * Mutator method for $this->_errorDocNoAccess
	 *
	 * @param integer $errorDocNoAccess
	 */
	function setErrorDocNoAccess($errorDocNoAccess) {
		$this->_errorDocNoAccess = $errorDocNoAccess;
	}

	/**
	 * Accessor method for $this->_errorDocNoAccess
	 *
	 * @return integer
	 */
	function getErrorDocNoAccess() {
		return $this->_errorDocNoAccess;
	}


}


?>