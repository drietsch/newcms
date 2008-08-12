<?php

class we_ui_layout_Frameset extends we_ui_abstract_AbstractElement 
{


	protected $_framespacing=0;
	protected $_border=0;
	protected $_frameborder='no';
	protected $_rows;
	protected $_cols;
	protected $_onLoad;
	
	
	protected $_frames=array();

	public function addFrame($attributes) {
		$this->_frames[] = $attributes;
	}
	
	protected function _renderHTML() {
		
		$html = '<frameset' .$this->_getNonBooleanAttribs('id,framespacing,border,frameborder,rows,cols,onLoad') . ">\n";
		foreach ($this->_frames as $frame) {
			if ($frame instanceof we_ui_layout_Frameset ) {
				$html .= $frame->getHTML() . "\n";
			} else {
				$html .= we_xml_Tags::createStartTag('frame',$frame,NULL,true) . "\n";
			}
		}
		$html .= '</frameset>' . "\n";
		return $html;
	}
	
	/**
	 * @return unknown
	 */
	public function getBorder()
	{
		return $this->_border;
	}

	/**
	 * @return unknown
	 */
	public function getFrameborder()
	{
		return $this->_frameborder;
	}

	/**
	 * @return unknown
	 */
	public function getFramespacing()
	{
		return $this->_framespacing;
	}

	/**
	 * @param unknown_type $border
	 */
	public function setBorder($border)
	{
		$this->_border = $border;
	}

	/**
	 * @param unknown_type $frameborder
	 */
	public function setFrameborder($frameborder)
	{
		$this->_frameborder = $frameborder;
	}

	/**
	 * @param unknown_type $framespacing
	 */
	public function setFramespacing($framespacing)
	{
		$this->_framespacing = $framespacing;
	}

	/**
	 * @return unknown
	 */
	public function getCols()
	{
		return $this->_cols;
	}

	/**
	 * @return unknown
	 */
	public function getOnLoad()
	{
		return $this->_onLoad;
	}

	/**
	 * @return unknown
	 */
	public function getRows()
	{
		return $this->_rows;
	}

	/**
	 * @param unknown_type $cols
	 */
	public function setCols($cols)
	{
		$this->_cols = $cols;
	}

	/**
	 * @param unknown_type $onLoad
	 */
	public function setOnLoad($onLoad)
	{
		$this->_onLoad = $onLoad;
	}

	/**
	 * @param unknown_type $rows
	 */
	public function setRows($rows)
	{
		$this->_rows = $rows;
	}


}

?>
