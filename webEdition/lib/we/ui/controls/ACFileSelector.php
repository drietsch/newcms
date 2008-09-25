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
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractFormElement');

/**
 * @see we_ui_controls_ACSuggest
 */
Zend_Loader::loadClass('we_ui_controls_ACSuggest');

/**
 * Class to display an Aucompleter with FileSelector
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_ACFileSelector extends we_ui_abstract_AbstractFormElement
{

	/**
	 * object of the suggestClass
	 *
	 * @var object
	 */
	protected $_suggestObj;

	/**
	 * object of the we_ui_controls_button class
	 *
	 * @var object
	 */
	protected $_buttonObj;

	/**
	 * ac may be empty 
	 *
	 * @var boolean
	 */
	protected $_mayBeEmpty = false;

	/**
	 * name of the application whose directories are selectable
	 *
	 * @var string
	 */
	protected $_appName = '';

	/**
	 * name attribute for folder Id
	 *
	 * @var string
	 */
	protected $_folderIdName = '';

	/**
	 * button text
	 *
	 * @var string
	 */
	protected $_buttonText = '';

	/**
	 * button onClick attribute
	 *
	 * @var string
	 */
	protected $_buttonOnClick = '';

	/**
	 * button title
	 *
	 * @var string
	 */
	protected $_buttonTitle = '';

	/**
	 * name attribute for folder Path
	 *
	 * @var string
	 */
	protected $_folderPathName = '';

	/**
	 * value attribute for folder Id
	 *
	 * @var string
	 */
	protected $_folderIdValue = '';

	/**
	 * value attribute for folder Path
	 *
	 * @var string
	 */
	protected $_folderPathValue = '';

	/**
	 * table from which the autocompleter choose files
	 *
	 * @var string
	 */
	protected $_table = '';

	/**
	 * kind of selector
	 *
	 * @var string
	 */
	protected $_selector = '';

	/**
	 * content type of files
	 *
	 * @var string
	 */
	protected $_contentType = '';

	/**
	 * onChange attribute
	 *
	 * @var string
	 */
	protected $_onChange = '';

	/**
	 * Constructor
	 * 
	 * Sets object properties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	function __construct($properties = null)
	{
		//get instance from an autocompleter
		$this->_suggestObj = &we_ui_controls_ACSuggest::getInstance();
		//get object from a button
		$this->_buttonObj = new we_ui_controls_Button();
		
		//set properties
		parent::__construct($properties);
		
		// add needed CSS files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL('we_ui_controls_Textfield'));
		$this->addCSSFiles($this->_buttonObj->getCSSFiles());
		
		// add needed JS Files
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL(__CLASS__));
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL('we_ui_controls_Textfield'));
		$this->addJSFiles($this->_buttonObj->getJSFiles());
		
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/yahoo-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/event-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/connection-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/json-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/dom-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/animation-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/autocomplete-min.js');
		
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/lib/we/core/JsonRpc.js');
	}

	/**
	 * Retrieve name of the application whose directories are selectable
	 * 
	 * @return string
	 */
	public function getAppName()
	{
		return $this->_appName;
	}

	/**
	 * Retrieve value if ac may be empty
	 * 
	 * @return boolean
	 */
	public function getMayBeEmpty()
	{
		return $this->_mayBeEmpty;
	}

	/**
	 * Retrieve onChange attribute
	 * 
	 * @return string
	 */
	public function getOnChange()
	{
		return $this->_onChange;
	}

	/**
	 * Retrieve button text
	 * 
	 * @return string
	 */
	public function getButtonText()
	{
		return $this->_buttonText;
	}

	/**
	 * Retrieve button title 
	 * 
	 * @return string
	 */
	public function getButtonTitle()
	{
		return $this->_buttonTitle;
	}

	/**
	 * Retrieve selector 
	 * 
	 * @return string
	 */
	public function getSelector()
	{
		return $this->_selector;
	
	}

	/**
	 * Retrieve contentTypes 
	 * 
	 * @return string
	 */
	public function getContentType()
	{
		return $this->_contentType;
	}

	/**
	 * Retrieve table 
	 * 
	 * @return string
	 */
	public function getTable()
	{
		return $this->_table;
	}

	/**
	 * Retrieve folderIdName 
	 * 
	 * @return string
	 */
	public function getFolderIdName()
	{
		return $this->_folderIdName;
	}

	/**
	 * Retrieve folderIdValue 
	 * 
	 * @return string
	 */
	public function getFolderIdValue()
	{
		return $this->_folderIdValue;
	}

	/**
	 * Retrieve folderPathName 
	 * 
	 * @return string
	 */
	public function getFolderPathName()
	{
		return $this->_folderPathName;
	}

	/**
	 * Set name of the application whose directories are selectable
	 * 
	 * @param boolean $_appName
	 */
	public function setAppName($_appName)
	{
		$this->_appName = $_appName;
	}

	/**
	 * Set if ac may be empty
	 * 
	 * @param boolean $_mayBeEmpty
	 */
	public function setMayBeEmpty($_mayBeEmpty)
	{
		$this->_mayBeEmpty = $_mayBeEmpty;
	}

	/**
	 * Set onChange attribute
	 * 
	 * @param string $_onChange
	 */
	public function setOnChange($_onChange)
	{
		$this->_onChange = $_onChange;
	}

	/**
	 * Set button text
	 * 
	 * @param string $_buttonText
	 */
	public function setButtonText($_buttonText)
	{
		$this->_buttonText = $_buttonText;
	}

	/**
	 * Set button onClick attribute
	 * 
	 * @param string $_buttonOnClick
	 */
	public function setButtonOnClick($_buttonOnClick)
	{
		$this->_buttonOnClick = $_buttonOnClick;
	}

	/**
	 * Set button title
	 * 
	 * @param string $_buttonTitle
	 */
	public function setButtonTitle($_buttonTitle)
	{
		$this->_buttonTitle = $_buttonTitle;
	}

	/**
	 * Set folderIdName
	 * 
	 * @param string $_folderIdName
	 */
	public function setFolderIdName($_folderIdName)
	{
		$this->_folderIdName = $_folderIdName;
	}

	/**
	 * Set folderPathName
	 * 
	 * @param string $_folderPathName
	 */
	public function setFolderPathName($_folderPathName)
	{
		$this->_folderPathName = $_folderPathName;
	}

	/**
	 * Set folderIdValue
	 * 
	 * @param string $_folderIdValue
	 */
	public function setFolderIdValue($_folderIdValue)
	{
		$this->_folderIdValue = $_folderIdValue;
	}

	/**
	 * Retrieve folderPathValue 
	 * 
	 * @return string
	 */
	public function getFolderPathValue()
	{
		return $this->_folderPathValue;
	}

	/**
	 * Set folderPathValue
	 * 
	 * @param string $_folderPathValue
	 */
	public function setFolderPathValue($_folderPathValue)
	{
		$this->_folderPathValue = $_folderPathValue;
	}

	/**
	 * Set table
	 * 
	 * @param string $_table
	 */
	public function setTable($_table)
	{
		$this->_table = $_table;
	}

	/**
	 * Set contentType
	 * 
	 * @param string $_contentType
	 */
	public function setContentType($_contentType)
	{
		$this->_contentType = $_contentType;
	}

	/**
	 * Set selector
	 * 
	 * @param string $_selector
	 */
	public function setSelector($_selector)
	{
		$this->_selector = $_selector;
	}

	/**
	 * Retrieve button onClick attribute
	 * 
	 * @return string
	 */
	public function getButtonOnClick()
	{
		
		$idFieldNameInteger = 'document.getElementById("yuiAcResult_' . $this->getId() . '").value';
		$idFieldNameString = '"document.getElementById(\\\'yuiAcResult_' . $this->getId() . '\\\').value"';
		$pathFieldName = '"document.getElementById(\\\'yuiAcInput_' . $this->getId() . '\\\').value"';
		//TODO
		$onChange = '"opener.weEventController.fire(\'docChanged\')"';
		$onChange = '""';
		
		$contentTypes = array();
		$contentTypesString = $this->getContentType();
		$contentTypesArray = explode(",", $contentTypesString);
		$countCTs = count($contentTypesArray);
		if ($countCTs === 1 && $contentTypesArray[0] === 'folder') {
			$this->setSelector('dirSelector');
			$selector = '"openDirselector"';
		} else {
			$this->setSelector('docSelector');
			$selector = '"openDocselector"';
		}
		
		if ($this->getAppName() !== '') {
			$appname = $this->getAppName();
			$this->setSelector('Dirselector');
			$selector = '"open' . $appname . 'Dirselector"';
			return 'we_ui_controls_ACFileSelector.openToolSelector(' . $selector . ',' . $idFieldNameInteger . ',' . $idFieldNameString . ',' . $pathFieldName . ', ' . $onChange . ', "' . $appname . '")';
		}
		
		$table = '"' . $this->getTable() . '"';
		$onClick = 'we_ui_controls_ACFileSelector.openSelector(' . $selector . ',' . $idFieldNameInteger . ',' . $table . ',' . $idFieldNameString . ',' . $pathFieldName . ', ' . $onChange . ',"","","' . $contentTypesString . '");';
		
		return $onClick;
	}

	/**
	 * Get HTML of InputField
	 * 
	 * @return string
	 */
	public function getInputField()
	{
		$this->_suggestObj->setAcId('_' . $this->getId());
		$this->_suggestObj->setContentType($this->getContentType());
		$this->_suggestObj->setInput($this->getFolderPathName(), $this->getFolderPathValue());
		$this->_suggestObj->setMaxResults(20);
		$this->_suggestObj->setMayBeEmpty($this->getMayBeEmpty());
		$this->_suggestObj->setResult($this->getFolderIdName(), $this->getFolderIdValue());
		$this->_suggestObj->setSelectButton($this->getButton());
		$this->_suggestObj->setSelector($this->getSelector());
		$this->_suggestObj->setTable($this->getTable());
		$this->_suggestObj->setWidth($this->getWidth());
		$this->_suggestObj->setInputDisabled($this->getDisabled());
		$this->_suggestObj->setOnChange($this->getOnChange());
		$this->_suggestObj->setMayBeEmpty($this->getMayBeEmpty());
		
		$weAutoCompleter = $this->_suggestObj->getHTML();
		
		return $weAutoCompleter;
	}

	/**
	 * Get HTML of Button
	 * 
	 * @return string
	 */
	public function getButton()
	{
		$this->_buttonObj->setId('yuiAcButton_' . $this->getId());
		$this->_buttonObj->setText($this->getButtonText());
		$this->_buttonObj->setType('onClick');
		$this->_buttonObj->setTitle($this->getButtonTitle());
		$this->_buttonObj->setDisabled($this->getDisabled());
		$this->_buttonObj->setHidden($this->getHidden());
		$this->_buttonObj->setWidth(120);
		$this->_buttonObj->setOnClick($this->getButtonOnClick());
		
		return $this->_buttonObj->getHTML();
	}

	/**
	 * called before _renderHTML() is called
	 *
	 * @return void
	 */
	protected function _willRenderHTML()
	{
		$uid = we_util_Strings::createUniqueId();
		
		if ($this->getFolderIdName() === '') {
			$this->setFolderIdName($uid . "_FolderIdName");
		}
		if ($this->getFolderPathName() === '') {
			$this->setFolderPathName($uid . "_FolderPathName");
		}
		parent::_willRenderHTML();
	}

	/**
	 * Renders and returns HTML of ACFileSelector
	 *
	 * @return string
	 */
	public function _renderHTML()
	{
		$ac = $this->getInputField();
		
		$page = we_ui_layout_HTMLPage::getInstance();
		$page->addInlineCSS($this->_suggestObj->getYuiCss());
		
		if ($this->getHidden()) {
			$this->_style .= 'display:none;';
		}
		
		return '<div' . $this->_getComputedStyleAttrib() . '>' . $ac . '</div>' . $this->_suggestObj->getYuiJs();
	}
}