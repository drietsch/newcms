<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Base Class for div
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_Div extends we_ui_abstract_AbstractElement
{
	/*
	 * string to hold the HTML of the div
	 *
	 * @var string
	 */
	protected $_divHTML='';
	
	/**
	 * adds an element to the div.
	 *
	 * @param we_ui_abstract_AbstractElement $elem
	 * @return void
	 */
	public function addElement($elem) 
	{
		$this->addCSSFiles($elem->getCSSFiles());
		$this->addJSFiles($elem->getJSFiles());		
		$this->_divHTML .= $elem->getHTML();
	}
	
	/**
	 * adds HTML to the div.
	 *
	 * @param string $html
	 * @return void
	 */
	public function addHTML($html) 
	{
		$this->_divHTML .= $html;
	}
	
	/**
	 * Renders and returns the HTML
	 *
	 * @return string
	 */
	protected function _renderHTML() {
				
		if ($this->getHidden()) {
			$this->_style .= "display:none;";
		}
		
		return '<div' . 
			$this->_getNonBooleanAttribs('id') . 
			$this->_getComputedStyleAttrib() . 
			$this->_getComputedClassAttrib() . 
			'>' . $this->_divHTML .
			'</div>';
	}
	
	
}

?>
