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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weCustomerFilterView.class.php");


/**
 *  view class for document customer filters
 *
 */
class weNavigationCustomerFilterView extends weCustomerFilterView {


	/**
	 * Gets the HTML and Javascript for the filter
	 *
	 * @return string
	 */
	function getFilterHTML($isDynamic=false) {
		$_filter = $this->getFilter();
		return we_forms::checkboxWithHidden(
			$_filter->getUseDocumentFilter(),
			'wecf_useDocumentFilter',
			$GLOBALS['l_navigation']['useDocumentFilter'],
			false,
			'defaultfont',
			'updateView();',
			$isDynamic
		) . $this->getDiv(
			'<div style="border-top: 1px solid #AFB0AF;margin-bottom: 5px;"></div>' . parent::getFilterHTML(),
			'MainFilterDiv',
			!$_filter->getUseDocumentFilter()
		);
	}


	/**
	 * Creates the content for the JavaScript updateView() function
	 *
	 * @return string
	 */
	function createUpdateViewScript() {
		return parent::createUpdateViewScript() . <<<EOF
	var wecf_useDocumentFilterCheckbox = f._wecf_useDocumentFilter;  // with underscore (_) its the checkbox, otherwise the hidden field
	$('MainFilterDiv').style.display = wecf_useDocumentFilterCheckbox.checked ? 'none' : 'block';
EOF;
	}

}



?>