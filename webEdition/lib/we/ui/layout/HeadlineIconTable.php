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
 * Class which creates a table to display several rows with ui elements separated by a rule
 * For each row an icon can be provided together with a headline (title) 
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_HeadlineIconTable extends we_ui_abstract_AbstractElement
{

	/*
	 * Class for main title of table
	 */
	const kTableTitle = 'we_ui_layout_HeadlineIconTable_Title';

	/*
	 * Class for title of a row
	 */
	const kRowTitle = 'we_ui_layout_HeadlineIconTable_RowTitle';

	/**
	 * width of table is 100% per default
	 * @see we_ui_abstractElement
	 *
	 * @var integer|string
	 */
	protected $_width = '100%';

	/*
	 * Array to hold the rows of the table
	 */
	protected $_rows = array();

	/*
	 * Button Table object; will be inserted direct under the table
	 * 
	 * @var we_ui_layout_ButtonTable
	 */
	protected $_buttonTable = NULL;

	/*
	 * Index where to put the triangle button
	 * for folding the rest of the table
	 * 
	 * @var integer
	 */
	protected $_foldAtIndex = -1;

	/*
	 * Text which will be shown next to the triangle button
	 * when the table is folded
	 * 
	 * @var string
	 */
	protected $_foldedText = '';

	/*
	 * Text which will be shown next to the triangle button
	 * when the table is unfolded
	 *
	 * @var string
	 */
	protected $_unfoldedText = '';

	/*
	 * Flag which controls if the table should be 
	 * unfolded or not when it renders its HTML
	 *
	 * @var string
	 */
	protected $_unfoldWhenRenders = false;

	/*
	 * left margin
	 * 
	 * @var integer
	 */
	protected $_marginLeft = 0;

	/**
	 * Constructor
	 * 
	 * Sets object properties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	public function __construct($properties = null)
	{
		parent::__construct($properties);
		
		// add needed CSS files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
		
		// add needed JS Files
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL(__CLASS__));
	
	}

	/**
	 * Retrieve ButtonTable
	 * 
	 * @return we_ui_layout_ButtonTable
	 */
	public function getButtonTable()
	{
		return $this->_buttonTable;
	}

	/**
	 * Retrieve foldAtIndex property
	 * 
	 * @return integer
	 */
	public function getFoldAtIndex()
	{
		return $this->_foldAtIndex;
	}

	/**
	 * Retrieve foldedText property
	 * 
	 * @return string
	 */
	public function getFoldedText()
	{
		return $this->_foldedText;
	}

	/**
	 * Retrieve marginLeft property
	 * 
	 * @return integer
	 */
	public function getMarginLeft()
	{
		return $this->_marginLeft;
	}

	/**
	 * Retrieve array with we_ui_layout_HeadlineIconTableRow objects
	 * 
	 * @return array
	 */
	public function getRows()
	{
		return $this->_rows;
	}

	/**
	 * Retrieve unfoldedText property
	 * 
	 * @return string
	 */
	public function getUnfoldedText()
	{
		return $this->_unfoldedText;
	}

	/**
	 * Retrieve unfoldWhenRenders property
	 * 
	 * @return boolean
	 */
	public function getUnfoldWhenRenders()
	{
		return $this->_unfoldWhenRenders;
	}

	/**
	 * @param we_ui_layout_ButtonTable $buttonTable
	 * 
	 * @return void
	 */
	public function setButtonTable($buttonTable)
	{
		$this->_buttonTable = $buttonTable;
	}

	/**
	 * @param integer $foldAtIndex
	 * 
	 * @return void
	 */
	public function setFoldAtIndex($foldAtIndex)
	{
		$this->_foldAtIndex = $foldAtIndex;
	}

	/**
	 * @param string $foldedText
	 * 
	 * @return void
	 */
	public function setFoldedText($foldedText)
	{
		$this->_foldedText = $foldedText;
	}

	/**
	 * @param integer $marginLeft
	 * 
	 * @return void
	 */
	public function setMarginLeft($marginLeft)
	{
		$this->_marginLeft = $marginLeft;
	}

	/**
	 * Set the rows array
	 * 
	 * @param array $rows
	 */
	public function setRows($rows)
	{
		$this->_rows = $rows;
		foreach ($this->_rows as $elem) {
			$this->addCSSFiles($elem->getCSSFiles());
			$this->addJSFiles($elem->getJSFiles());
		}
	
	}

	/**
	 * @param string $unfoldedText
	 * 
	 * @return void
	 */
	public function setUnfoldedText($unfoldedText)
	{
		$this->_unfoldedText = $unfoldedText;
	}

	/**
	 * @param boolean $unfoldWhenRenders
	 * 
	 * @return void
	 */
	public function setUnfoldWhenRenders($unfoldWhenRenders)
	{
		$this->_unfoldWhenRenders = $unfoldWhenRenders;
	}

	/**
	 * Renders and returns the HTML
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$html = $this->_getHeader();
		$client = we_ui_Client::getInstance();
		
		foreach ($this->_rows as $i => $row) {
			
			$rowHTML = '<div style="margin-left:' . $this->_marginLeft . 'px" id="' . $this->_id . '_div_' . $i . '">' . $row->getHTML() . '</div>' . (($client->getBrowser() == we_ui_Client::kBrowserIE) ? '<br>' : '');
			$html .= $rowHTML;
			if ($i < (count($this->_rows) - 1) && ($row->hasLine())) {
				$html .= '<div class="we_ui_layout_HeadlineIconTable_Rule"></div>';
			} else {
				$html .= '<div class="we_ui_layout_HeadlineIconTable_Space"></div>';
			}
		}
		return $html . $this->_getFooter();
	}

	/**
	 * gets the header HTML for the table
	 *
	 * @return string
	 */
	protected function _getHeader()
	{
		
		$tableTag = '<table' . $this->_getNonBooleanAttribs('id') . $this->_getComputedStyleAttrib(array('margin-top' => '10px')) . ' border="0" cellspacing="0" cellpadding="0">';
		
		if ($this->getTitle() !== '') {
			
			return $tableTag . '
	<tr>
		<td style="padding-left:' . $this->_marginLeft . 'px;padding-bottom:10px;" class="' . htmlspecialchars(self::kTableTitle) . '">' . htmlspecialchars($this->getTitle()) . '</td>
	</tr>
	<tr>
		<td>' . we_ui_layout_Image::getPixel(2, 8) . '</td>
	</tr>
	<tr>
		<td id="' . htmlspecialchars($this->getId()) . '_td">';
		
		} else {
			
			return $tableTag . '
	<tr>
		<td class="defaultfont"><b>' . we_ui_layout_Image::getPixel($this->getWidth(), 2) . '</b></td>
	</tr>
	<tr>
		<td id="' . htmlspecialchars($this->getId()) . '_td">';
		
		}
	}

	/**
	 * gets the footer HTML for the table
	 *
	 * @return string
	 */
	protected function _getFooter()
	{
		
		return '</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
';
	}

}
