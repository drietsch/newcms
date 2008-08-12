<?php

require_once ('we/ui/abstract/AbstractElement.php');

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
