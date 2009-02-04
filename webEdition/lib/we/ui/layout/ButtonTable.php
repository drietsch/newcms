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
 * @see we_ui_layout_Table
 */
Zend_Loader::loadClass('we_ui_layout_Table');

/**
 * Class to display a ButtonTable
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_ButtonTable extends we_ui_layout_Table
{

	/**
	 * Default class name for button
	 */
	const kButtonTableClassNormal = 'we_ui_layout_ButtonTable';

	/**
	 * horizontal padding between the button
	 *
	 * @var integer
	 */
	protected $_horizontalPadding = 10;

	/**
	 * Retrieve the horizontal padding
	 *
	 * @return integer
	 */
	public function getHorizontalPadding()
	{
		return $this->_horizontalPadding;
	}

	/**
	 * Sets the horizontalPadding
	 *
	 * @param $horizontalPadding
	 * @return void
	 */
	public function setHorizontalPadding($horizontalPadding)
	{
		$this->_horizontalPadding = $horizontalPadding;
	}

	/**
	 * called before _renderHTML() is called
	 * for HTMLDocuments we don't need to do anything here, 
	 * so we overwrite it with an empty function
	 *
	 * @return void
	 */
	protected function _willRenderHTML()
	{
		if ($this->getHorizontalPadding()) {
			foreach ($this->_cellHTML as $rowIndex => $cols) {
				foreach (array_keys($cols) as $colIndex) {
					$columns = count($cols) - 1;
					if ($columns !== $colIndex) {
						$this->setCellAttributes(array('style' => 'padding-right:' . $this->getHorizontalPadding() . 'px'), $colIndex, $rowIndex);
					}
				}
			}
		}
		
		parent::_willRenderHTML();
	}
}