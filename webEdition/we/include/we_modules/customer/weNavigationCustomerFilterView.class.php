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