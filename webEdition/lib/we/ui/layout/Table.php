<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Table Class to layout elements. It renders a normal HTML table
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_layout_Table extends we_ui_abstract_AbstractElement
{

	/**
	 * Two dimensional array to hold the HTML for the cells
	 *
	 * @var array
	 */
	protected $_cellHTML = array();

	/**
	 * Two dimensional array to hold the attributes for the cells
	 *
	 * @var array
	 */
	protected $_cellAttributes = array();

	/**
	 * border attribute of the table
	 *
	 * @var integer
	 */
	protected $_border = 0;

	/**
	 * cellpadding attribute of the table
	 *
	 * @var integer
	 */
	protected $_cellPadding = 0;

	/**
	 * cellspacing attribute of the table
	 *
	 * @var integer
	 */
	protected $_cellSpacing = 0;

	/**
	 * Pointer to the current row
	 *
	 * @var integer
	 */
	protected $_row = 0;

	/**
	 * Pointer to the current column
	 *
	 * @var integer
	 */
	protected $_column = 0;

	/**
	 * Adds an Element to the current cell,
	 * which is defined by the row and column pointer.
	 * If the $column or $row parameter is set, 
	 * the column pointers will be updated before inserting the element
	 *
	 * @param we_ui_abstract_AbstractElement $elem element to insert
	 * @param integer $column
	 * @param integer $row
	 * @return void
	 */
	public function addElement($elem, $column = -1, $row = -1)
	{
		$this->addCSSFiles($elem->getCSSFiles());
		$this->addJSFiles($elem->getJSFiles());
		
		if ($column == -1) {
			$column = $this->_column;
		} else {
			$this->_column = $column;
		}
		if ($row == -1) {
			$row = $this->_row;
		} else {
			$this->_row = $row;
		}
		if (!isset($this->_cellHTML[$row])) {
			$this->_cellHTML[$row] = array();
		}
		if (!isset($this->_cellHTML[$row][$column])) {
			$this->_cellHTML[$row][$column] = $elem->getHTML();
		} else {
			$this->_cellHTML[$row][$column] .= $elem->getHTML();
		}
	
	}

	/**
	 * Adds HTML to the current cell,
	 * which is defined by the row and column pointer.
	 * If the $column or $row parameter is set, 
	 * the column pointers will be updated before inserting the HTML
	 *
	 * @param string $html element to insert
	 * @param integer $column
	 * @param integer $row
	 * @return void
	 */
	public function addHTML($html, $column = -1, $row = -1)
	{
		if ($column == -1) {
			$column = $this->_column;
		} else {
			$this->_column = $column;
		}
		if ($row == -1) {
			$row = $this->_row;
		} else {
			$this->_row = $row;
		}
		if (!isset($this->_cellHTML[$row])) {
			$this->_cellHTML[$row] = array();
		}
		if (!isset($this->_cellHTML[$row][$column])) {
			$this->_cellHTML[$row][$column] = $html;
		} else {
			$this->_cellHTML[$row][$column] .= $html;
		}
	}

	/**
	 * Sets the attributes for the current cell,
	 * which is defined by the row and column pointer.
	 * If the $column or $row parameter is set, 
	 * the column pointers will be updated before setting the attributes
	 *
	 * @param array $attributes associative array with attributes to insert
	 * @param integer $column
	 * @param integer $row
	 * @return void
	 */
	public function setCellAttributes($attributes, $column = -1, $row = -1)
	{
		if ($column == -1) {
			$column = $this->_column;
		} else {
			$this->_column = $column;
		}
		if ($row == -1) {
			$row = $this->_row;
		} else {
			$this->_row = $row;
		}
		if (!isset($this->_cellAttributes[$row])) {
			$this->_cellAttributes[$row] = array();
		}
		if (!isset($this->_cellAttributes[$row][$column])) {
			$this->_cellAttributes[$row][$column] = $attributes;
		} else {
			$this->_cellAttributes[$row][$column] = array_merge($this->_cellAttributes[$row][$column], $attributes);
		}
	}

	/**
	 * Sets the row pointer to the next row
	 *
	 * @param boolean $resetColumn if set to true the column pointer will be reset to 0
	 * @return void
	 */
	public function nextRow($resetColumn = false)
	{
		$this->_row = $this->_row + 1;
		if ($resetColumn) {
			$this->resetColumn();
		}
	}

	/**
	 * Sets the column pointer to the next column
	 *
	 * @return void
	 */
	public function nextColumn()
	{
		$this->_column = $this->_column + 1;
	}

	/**
	 * Reset the row pointer to 0
	 *
	 * @return void
	 */
	public function resetRow()
	{
		$this->_row = 0;
	}

	/**
	 * Reset the column pointer to 0
	 *
	 * @return void
	 */
	public function resetColumn()
	{
		$this->_column = 0;
	}

	/**
	 * Retrieve the column pointer
	 *
	 * @return integer
	 */
	public function getColumn()
	{
		return $this->_column;
	}

	/**
	 * Retrieve the row pointer
	 *
	 * @return integer
	 */
	public function getRow()
	{
		return $this->_row;
	}

	/**
	 * Sets the column pointer
	 *
	 * @param $column integer
	 * @return void
	 */
	public function setColumn($column)
	{
		$this->_column = $column;
	}

	/**
	 * Sets the row pointer
	 *
	 * @param $row integer
	 * @return void
	 */
	public function setRow($row)
	{
		$this->_row = $row;
	}

	/**
	 * Renders and returns the HTML
	 *
	 * @return string
	 */
	public function _renderHTML()
	{
		$html = '<table border="' . htmlspecialchars($this->_border) . '"' . ' cellpadding="' . htmlspecialchars($this->_cellPadding) . '"' . ' cellspacing="' . htmlspecialchars($this->_cellSpacing) . '"' . $this->_getNonBooleanAttribs('id') . $this->_getComputedStyleAttrib() . $this->_getComputedClassAttrib() . '>';
		
		$maxRowIndex = -1;
		$maxColIndex = -1;
		foreach ($this->_cellHTML as $rowIndex => $cols) {
			$maxRowIndex = max($maxRowIndex, $rowIndex);
			foreach ($cols as $colIndex => $col) {
				$maxColIndex = max($maxColIndex, $colIndex);
			}
		}
		
		$colspan = 1;
		
		for ($row = 0; $row <= $maxRowIndex; $row++) {
			$html .= '<tr>';
			for ($col = 0; $col <= $maxColIndex; $col++) {
				if ($colspan < 2) {
					if (isset($this->_cellAttributes[$row][$col])) {
						if (isset($this->_cellAttributes[$row][$col]['colspan'])) {
							$colspan = abs($this->_cellAttributes[$row][$col]['colspan']);
						}
						$attribs = $this->_cellAttributes[$row][$col];
						if (!isset($attribs['valign'])) {
							$attribs['valign'] = 'top';
						}
						$html .= we_xml_Tags::createStartTag('td', $attribs);
					} else {
						$html .= '<td valign="top">';
					}
					if (isset($this->_cellHTML[$row][$col])) {
						$html .= $this->_cellHTML[$row][$col];
					}
					$html .= '</td>';
				} else {
					$colspan--;
				}
			}
			$html .= '</tr>';
		}
		
		$html .= '</table>';
		return $html;
	}

	/**
	 * Retrieve border attribute
	 * 
	 * @return integer
	 */
	public function getBorder()
	{
		return $this->_border;
	}

	/**
	 * Retrieve cellpadding attribute
	 * 
	 * @return integer
	 */
	public function getCellPadding()
	{
		return $this->_cellPadding;
	}

	/**
	 * Retrieve cellspacing attribute
	 * 
	 * @return integer
	 */
	public function getCellSpacing()
	{
		return $this->_cellSpacing;
	}

	/**
	 * Sets the border attribute
	 * 
	 * @param integer $border
	 * @return void
	 */
	public function setBorder($border)
	{
		$this->_border = $border;
	}

	/**
	 * Sets the cellpadding attribute
	 * 
	 * @param integer $cellPadding
	 * @return void
	 */
	public function setCellPadding($cellPadding)
	{
		$this->_cellPadding = $cellPadding;
	}

	/**
	 * Sets the cellspaceing attribute
	 * 
	 * @param integer $cellSpacing
	 * @return void
	 */
	public function setCellSpacing($cellSpacing)
	{
		$this->_cellSpacing = $cellSpacing;
	}
}
