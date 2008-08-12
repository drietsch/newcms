<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weAbstractCustomerFilter.class.php");

/**
 * Filter model class for navigation tool
 *
 */
class weNavigationCustomerFilter extends weAbstractCustomerFilter {


	var $_useDocumentFilter = true;

	/**
	 * initialize object with a naviagtion model
	 *
	 * @param weNavigation $navModel
	 */
	function initByNavModel(&$navModel) {
		// convert navigation data into data the filter model needs

		$_custFilter = $navModel->CustomerFilter;
		$_useDocumentFilter = $navModel->UseDocumentFilter;

		$this->updateCustomerFilter($_custFilter);

		$_specCust = (isset($navModel->Customers) && is_array($navModel->Customers)) ? $navModel->Customers : array();

		$_mode = WECF_OFF;


		if ($navModel->LimitAccess && $navModel->ApplyFilter) {
			$_mode = WECF_FILTER;
		} else if ($navModel->LimitAccess && $navModel->AllCustomers == 1) {
			$_mode = WECF_ALL;
		} else if ($navModel->LimitAccess && count($_specCust) > 0) {
			$_mode = WECF_SPECIFIC;
		}

		// end convert data

		$_whitelist = isset($navModel->WhiteList) && is_array($navModel->WhiteList)  ? $navModel->WhiteList : array();
		$_blacklist = isset($navModel->BlackList) && is_array($navModel->BlackList)  ? $navModel->BlackList : array();

		$this->setBlackList($_blacklist);
		$this->setWhiteList($_whitelist);
		$this->setFilter($_custFilter);
		$this->setMode($_mode);
		$this->setSpecificCustomers($_specCust);
		$this->setUseDocumentFilter($_useDocumentFilter);
	}

	/**
	 * initialize object with a navigation item
	 *
	 * @param weNavigationItem $navItem
	 */
	function initByNavItem(&$navItem) {

		if ($navItem->limitaccess == 0) {
			$this->setMode(WECF_OFF);
		} else {
			if (isset($navItem->customers['filter']) && is_array($navItem->customers['filter']) && count($navItem->customers['filter'])) {
				$this->setMode(WECF_FILTER);
				$_custFilter = $navItem->customers['filter'];
				$this->updateCustomerFilter($_custFilter);
				$this->setFilter($_custFilter);

				if (isset($navItem->customers['blacklist']) && is_array($navItem->customers['blacklist']) && count($navItem->customers['blacklist'])) {
					$this->setBlackList($navItem->customers['blacklist']);
				}
				if (isset($navItem->customers['whitelist']) && is_array($navItem->customers['whitelist']) && count($navItem->customers['whitelist'])) {
					$this->setWhiteList($navItem->customers['whitelist']);
				}

			} else if (isset($navItem->customers['id']) && is_array($navItem->customers['id']) && count($navItem->customers['id'])) {
				$this->setMode(WECF_SPECIFIC);
				$this->setSpecificCustomers($navItem->customers['id']);
			} else {
				$this->setMode(WECF_ALL);
			}
		}
	}

	/**
	 * converts old style (prior we 5.1) navigation filters to new format
	 *
	 * @param array $_custFilter
	 */
	function updateCustomerFilter(&$_custFilter) {
		if (isset($_custFilter['AND']) && isset($_custFilter['OR'])) {  // old style filter => convert into new style
			$_newFilter = array();
			foreach($_custFilter['AND'] as $_f) {
				$_newFilter[] = array(
					'logic'		=>'AND',
					'field'		=> $_f['operand1'],
					'operation' => $_f['operator'],
					'value'		=> $_f['operand2']
				);
			}
			foreach($_custFilter['OR'] as $_f) {
				$_newFilter[] = array(
					'logic'		=>'OR',
					'field'		=> $_f['operand1'],
					'operation' => $_f['operator'],
					'value'		=> $_f['operand2']
				);
			}
			$_custFilter = $_newFilter;
		}

	}

	function getUseDocumentFilter() {
		return $this->_useDocumentFilter;
	}

	function setUseDocumentFilter($useDocumentFilter) {
		$this->_useDocumentFilter = $useDocumentFilter;
	}


	function getUseDocumentFilterFromRequest() {
		return (isset($_REQUEST['wecf_useDocumentFilter']) && $_REQUEST['wecf_useDocumentFilter']);
	}

	function translateModeToNavModel($mode, &$model) {
		switch($mode) {

			case WECF_FILTER:
				$model->LimitAccess = 1;
				$model->ApplyFilter = 1;
				$model->AllCustomers = 1;
			break;

			case WECF_SPECIFIC:
				$model->LimitAccess = 1;
				$model->ApplyFilter = 0;
				$model->AllCustomers = 0;
			break;

			case WECF_ALL:
				$model->LimitAccess = 1;
				$model->ApplyFilter = 0;
				$model->AllCustomers = 1;
			break;

			default:
				$model->LimitAccess = 0;
		}
	}

	function updateByFilter(&$filterObj, $id, $table) {
		$_limitAccess = 0;
		$_applyFilter = 0;
		$_allCustomers = 0;
		switch($filterObj->getMode()) {

			case WECF_FILTER:
				$_limitAccess = 1;
				$_applyFilter = 1;
				$_allCustomers = 1;
			break;

			case WECF_SPECIFIC:
				$_limitAccess = 1;
				$_applyFilter = 0;
				$_allCustomers = 0;
			break;

			case WECF_ALL:
				$_limitAccess = 1;
				$_applyFilter = 0;
				$_allCustomers = 1;
			break;
		}


		$_customers = makeCSVFromArray($filterObj->getSpecificCustomers(),true);
		$_whiteList = makeCSVFromArray($filterObj->getWhiteList(),true);
		$_blackList = makeCSVFromArray($filterObj->getBlackList(),true);
		$_filter = serialize($filterObj->getFilter());

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');

		$this->DB_WE->query('UPDATE ' . NAVIGATION_TABLE .
					' SET LimitAccess='.$_limitAccess.
					', ApplyFilter='.$_applyFilter.
					', AllCustomers='.$_allCustomers.
					', Customers="'.$_customers.
					'", CustomerFilter="'.addslashes($_filter).
					'", BlackList="'.$_blackList.
					'", WhiteList="'.$_whiteList.
					'"  WHERE UseDocumentFilter=1 AND ' . weNavigation::getNavCondition($id, $table));

	}


}

?>