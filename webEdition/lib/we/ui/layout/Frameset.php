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
 * Class to display a frameset
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_Frameset extends we_ui_abstract_AbstractElement
{

	/**
	 * _framespacing attribute
	 *
	 * @var integer
	 */
	protected $_framespacing = 0;

	/**
	 * _border attribute
	 *
	 * @var integer
	 */
	protected $_border = 0;

	/**
	 * _frameborder attribute
	 *
	 * @var string
	 */
	protected $_frameborder = 'no';

	/**
	 * _rows attribute
	 *
	 * @var integer
	 */
	protected $_rows;

	/**
	 * _cols attribute
	 *
	 * @var integer
	 */
	protected $_cols;

	/**
	 * _onLoad attribute
	 *
	 * @var string
	 */
	protected $_onLoad;

	/**
	 * _frames attribute
	 *
	 * @var array
	 */
	protected $_frames = array();

	/**
	 * add frame
	 *
	 */
	public function addFrame($attributes)
	{
		$this->_frames[] = $attributes;
	}

	/**
	 * Renders and returns HTML of frameset
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		
		$html = '<frameset' . $this->_getNonBooleanAttribs('id,framespacing,border,frameborder,rows,cols,onLoad') . ">\n";
		foreach ($this->_frames as $frame) {
			if ($frame instanceof we_ui_layout_Frameset) {
				$html .= $frame->getHTML() . "\n";
			} else {
				$html .= we_xml_Tags::createStartTag('frame', $frame, NULL, true) . "\n";
			}
		}
		$html .= '</frameset>' . "\n";
		return $html;
	}

	/**
	 * retrieve border
	 * 
	 * @return integer
	 */
	public function getBorder()
	{
		return $this->_border;
	}

	/**
	 * retrieve frameborder
	 * 
	 * @return integer
	 */
	public function getFrameborder()
	{
		return $this->_frameborder;
	}

	/**
	 * retrieve framespacing
	 * 
	 * @return integer
	 */
	public function getFramespacing()
	{
		return $this->_framespacing;
	}

	/**
	 * set border
	 * 
	 * @param integer $border
	 */
	public function setBorder($border)
	{
		$this->_border = $border;
	}

	/**
	 * set frameborder
	 * 
	 * @param integer $frameborder
	 */
	public function setFrameborder($frameborder)
	{
		$this->_frameborder = $frameborder;
	}

	/**
	 * set framespacing
	 * 
	 * @param integer $framespacing
	 */
	public function setFramespacing($framespacing)
	{
		$this->_framespacing = $framespacing;
	}

	/**
	 * retrieve cols
	 * 
	 * @return integer
	 */
	public function getCols()
	{
		return $this->_cols;
	}

	/**
	 * retrieve onLoad
	 * 
	 * @return string
	 */
	public function getOnLoad()
	{
		return $this->_onLoad;
	}

	/**
	 * retrieve rows
	 * 
	 * @return integer
	 */
	public function getRows()
	{
		return $this->_rows;
	}

	/**
	 * set cols
	 * 
	 * @param integer $cols
	 */
	public function setCols($cols)
	{
		$this->_cols = $cols;
	}

	/**
	 * set onLoad
	 * 
	 * @param string $onLoad
	 */
	public function setOnLoad($onLoad)
	{
		$this->_onLoad = $onLoad;
	}

	/**
	 * set rows
	 * 
	 * @param integer $rows
	 */
	public function setRows($rows)
	{
		$this->_rows = $rows;
	}

}

?>
