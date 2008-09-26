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

define("WECF_OFF", 0);
define("WECF_ALL", 1);
define("WECF_SPECIFIC", 2);
define("WECF_FILTER", 3);

/**
 * Base Class for all Customer Filters (Model)
 *
 */
class weAbstractCustomerFilter {
	/**
	 * Mode. Can be WECF_OFF, WECF_ALL, WECF_SPECIFIC, WECF_FILTER
	 *
	 * @var integer
	 */
	var $_mode = WECF_OFF;

	/**
	 * Array with customer ids. Only relevant when $_mode is WECF_SPECIFIC
	 *
	 * @var array
	 */
	var $_specificCustomers = array();

	/**
	 * Array with customer ids. Only relevant when $_mode is WECF_FILTER
	 *
	 * @var array
	 */
	var $_blackList = array();

	/**
	 * Array with customer ids. Only relevant when $_mode is WECF_FILTER
	 *
	 * @var array
	 */
	var $_whiteList = array();

	/**
	 * Array with filter Settings
	 *
	 * @var array
	 */
	var $_filter = array();

	/*################### CONSTRUCTOR ####################*/

	/**
	 * Constructor for PHP4
	 *
	 * @param integer $mode
	 * @param array $specificCustomers
	 * @param array $blackList
	 * @param array $whiteList
	 * @param array $filter
	 * @return weAbstractCustomerFilter
	 */
	function weAbstractCustomerFilter($mode=WECF_OFF, $specificCustomers=array(), $blackList=array(), $whiteList=array(), $filter=array()) {
		$this->setMode($mode);
		$this->setSpecificCustomers($specificCustomers);
		$this->setBlackList($blackList);
		$this->setWhiteList($whiteList);
		$this->setFilter($filter);
	}

	/**
	 * Constructor for PHP5
	 *
	 * @param integer $mode
	 * @param array $specificCustomers
	 * @param array $blackList
	 * @param array $whiteList
	 * @param array $filter
	 * @return weAbstractCustomerFilter
	 */
	function __construct($mode=WECF_OFF, $specificCustomers=array(), $blackList=array(), $whiteList=array(), $filter=array()) {
		$this->weAbstractCustomerFilter($mode, $specificCustomers, $blackList, $whiteList, $filter);
	}

	/*##################### End of constructor ################################*/


	/**
	 * checks if customer has access with the actual filter object
	 *
	 * @return boolean
	 */
	function customerHasAccess() {
		switch ($this->_mode) {
			case WECF_OFF:
				return true;
			case WECF_ALL:
				return weAbstractCustomerFilter::customerIsLogedIn();
			case WECF_SPECIFIC:
				if (!weAbstractCustomerFilter::customerIsLogedIn()) {
					return false;
				}
				return in_array($_SESSION["webuser"]["ID"], $this->_specificCustomers);
			case WECF_FILTER:
				if (!( isset($_SESSION) && isset($_SESSION["webuser"]) && isset($_SESSION["webuser"]["ID"]) )) {
					return false;
				}
				return weAbstractCustomerFilter::customerHasFilterAccess();
		}
		return false;
	}

	/**
	 * Checks if customer matches $this->_filter array
	 *
	 * @return boolean
	 */
	function customerHasFilterAccess() {

		if (in_array($_SESSION["webuser"]["ID"], $this->_blackList)) {
			return false;
		} else if (in_array($_SESSION["webuser"]["ID"], $this->_whiteList)) {
			return true;
		}

		$_filter_op = array(
			'0'=>'%s==%s',
			'1'=>'%s<>%s',
			'2'=>'%s<%s',
			'3'=>'%s<=%s',
			'4'=>'%s>%s',
			'5'=>'%s>=%s',
			'6'=>'weAbstractCustomerFilter::startsWith(%s,%s)',
			'7'=>'weAbstractCustomerFilter::endsWith(%s,%s)',
			'8'=>'weAbstractCustomerFilter::contains(%s,%s)',
			'9'=>'weAbstractCustomerFilter::in(%s,%s)'

		);

		$_conditions = array();

		$_flag = false;
		foreach ( $this->_filter as $_filter ) {
			$_conditions[] = (($_filter["logic"] && $_flag) ? ($_filter["logic"]=="AND" ? " && " : " || ") : "") . sprintf(
				$_filter_op[$_filter["operation"]],
				weAbstractCustomerFilter::quote4Eval($_SESSION["webuser"][$_filter["field"]]),
				weAbstractCustomerFilter::quote4Eval($_filter["value"])
			);
			$_flag = true;
		}

		$_hasPermission = false;
		$_cond = "if (" . implode("", $_conditions) . ") { \$_hasPermission = true; }";
		eval( $_cond );

		return $_hasPermission;
	}

	/*#########################################################################################
	#################################### static methods #######################################
	#########################################################################################*/

	/**
	 * Creates and returns the filter array from $_REQUEST
	 *
	 * @static
	 * @return array
	 */
	function getFilterFromRequest() {
		$_filter = array();

		if(isset($_REQUEST['filterSelect_0'])) {


			$_parse = true;
			$_count = 0;

			while ($_parse) {
				if(isset($_REQUEST['filterSelect_'.$_count])) {

					if(isset($_REQUEST['filterLogic_'.$_count]) && $_REQUEST['filterLogic_'.$_count]=='OR') {
						$_logic = 'OR';
					} else {
						$_logic = 'AND';
					}
					if(isset($_REQUEST['filterValue_'.$_count]) && trim($_REQUEST['filterValue_'.$_count])<>'') {
						$_filter[] = array(
								'logic' => $_logic,
								'field' => $_REQUEST['filterSelect_'.$_count],
								'operation' => $_REQUEST['filterOperation_'.$_count],
								'value' => $_REQUEST['filterValue_'.$_count]

						);
					}
					$_count++;
				} else {
					$_parse = false;
				}
			}
		}
		return $_filter;
	}

	/**
	 * Creates and returns the specificCustomers array from $_REQUEST
	 *
	 * @static
	 * @return array
	 */
	function getSpecificCustomersFromRequest() {
		$_customers = array();

		if (isset($_REQUEST['specificCustomersEditControl'])){
			$i = 0;
			while (true){
				if(isset($_REQUEST[$_REQUEST['specificCustomersEditControl'] . '_variant0_' . $_REQUEST['specificCustomersEditControl'] . '_item' . $i])){
					$_customers[] = $_REQUEST[$_REQUEST['specificCustomersEditControl'] . '_variant0_' . $_REQUEST['specificCustomersEditControl'] . '_item' . $i];
					$i++;
				} else {
					break;
				}
			}
		}
		return weConvertToIds($_customers, CUSTOMER_TABLE);
	}

	/**
	 * Creates and returns the black list array from $_REQUEST
	 *
	 * @static
	 * @return array
	 */
	function getBlackListFromRequest() {
		$_blackList = array();

		if (isset($_REQUEST['blackListEditControl'])){
			$i = 0;
			while (true){
				if(isset($_REQUEST[$_REQUEST['blackListEditControl'] . '_variant0_' . $_REQUEST['blackListEditControl'] . '_item' . $i])){
					$_blackList[] = $_REQUEST[$_REQUEST['blackListEditControl'] . '_variant0_' . $_REQUEST['blackListEditControl'] . '_item' . $i];
					$i++;
				} else {
					break;
				}
			}
		}
		return weConvertToIds($_blackList, CUSTOMER_TABLE);
	}

	/**
	 * Creates and returns the white list array from $_REQUEST
	 *
	 * @static
	 * @return array
	 */
	function getWhiteListFromRequest() {
		$_whiteList = array();

		if (isset($_REQUEST['whiteListEditControl'])){
			$i = 0;
			while (true){
				if(isset($_REQUEST[$_REQUEST['whiteListEditControl'] . '_variant0_' . $_REQUEST['whiteListEditControl'] . '_item' . $i])){
					$_whiteList[] = $_REQUEST[$_REQUEST['whiteListEditControl'] . '_variant0_' . $_REQUEST['whiteListEditControl'] . '_item' . $i];
					$i++;
				} else {
					break;
				}
			}
		}
		return weConvertToIds($_whiteList, CUSTOMER_TABLE);
	}

	/**
	 * Checks if $haystack starts with $needle. If so, returns true, otherwise false
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @static
	 * @return boolean
	 */
	function startsWith($haystack, $needle) {
		return (strpos($haystack, $needle) === 0);
	}

	/**
	 * Checks if $haystack ends with $needle. If so, returns true, otherwise false
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @static
	 * @return boolean
	 */
	function endsWith($haystack, $needle) {
		$pos = strlen($haystack) - strlen($needle);
		return (strpos($haystack, $needle) === $pos);
	}

	/**
	 * Checks if $haystack contains $needle. If so, returns true, otherwise false
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @static
	 * @return boolean
	 */
	function contains($haystack, $needle) {
		return (strpos($haystack, $needle) !== false);
	}

	/**
	 * Checks if $value is one of the CSV Values of $comp
	 *
	 * @param string $value
	 * @param string $comp (CSV)
	 * @static
	 * @return boolean
	 */
	function in($value, $comp) {
		$comp = str_replace("\\,", "__WE_COMMA__", $comp);
		$arr = explode(",", $comp);
		$l = count($arr);
		for ($i=0; $i<$l; $i++) {
			$arr[$i] = str_replace("__WE_COMMA__", ",", $arr[$i]);
		}
		return in_array($value, $arr);
	}

	/**
	 * Checks if Customer is logged in. Returns true or f alse
	 *
	 * @return boolean
	 */
	function customerIsLogedIn() {
		return isset($_SESSION) && isset($_SESSION["webuser"]) && isset($_SESSION["webuser"]["ID"]);
	}

	/**
	 * Quotes strings for use in eval statements
	 *
	 * @param string $in
	 * @static
	 * @return string
	 */
	function quote4Eval($in) {
		if (is_numeric($in)) {
			return $in;
		} else {
			return '"' . str_replace("\\'", "'", addslashes($in)) . '"';
		}
	}

	/*#########################################################################################
	############################### mutator and accessor methods ##############################
	#########################################################################################*/

	/**
	 * mutator method for $this->_mode
	 *
	 * @param integer $mode
	 */
	function setMode($mode) {
		$this->_mode = $mode;
	}

	/**
	 * accessor method for $this->_mode
	 *
	 * @return integer
	 */
	function getMode() {
		return $this->_mode;
	}

	/**
	 * mutator method for $this->_specificCustomers
	 *
	 * @param array $mode
	 */
	function setSpecificCustomers($specificCustomers) {
		$this->_specificCustomers = $specificCustomers;
	}

	/**
	 * accessor method for $this->_specificCustomers
	 *
	 * @return array
	 */
	function getSpecificCustomers() {
		return $this->_specificCustomers;
	}

	/**
	 * mutator method for $this->_blackList
	 *
	 * @param array $mode
	 */
	function setBlackList($blackList) {
		$this->_blackList = $blackList;
	}

	/**
	 * accessor method for $this->_blackList
	 *
	 * @return array
	 */
	function getBlackList() {
		return $this->_blackList;
	}

	/**
	 * mutator method for $this->_whiteList
	 *
	 * @param array $mode
	 */
	function setWhiteList($whiteList) {
		$this->_whiteList = $whiteList;
	}

	/**
	 * accessor method for $this->_whiteList
	 *
	 * @return array
	 */
	function getWhiteList() {
		return $this->_whiteList;
	}

	/**
	 * mutator method for $this->_filter
	 *
	 * @param array $mode
	 */
	function setFilter($filter) {
		$this->_filter = $filter;
	}

	/**
	 * accessor method for $this->_filter
	 *
	 * @return array
	 */
	function getFilter() {
		return $this->_filter;
	}


}


?>