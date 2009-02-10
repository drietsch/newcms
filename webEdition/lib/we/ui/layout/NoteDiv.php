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
 * Class to display info-divs
 * 
 * If the type is setted a icon on the left side will be displayed
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_NoteDiv extends we_ui_layout_Div
{

	/**
	 * @var string 
	 * depend on the type ('' | 'info' | 'warning' | 'alert') a icon will be setted
	 */
	protected $type = "";
	
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
	 * Renders and returns the HTML
	 *
	 * @return string
	 */
	protected function _renderHTML() {
				
		if ($this->getHidden()) {
			$this->_style .= "display:none;";
		}
		$_style = "";
		
		switch ($this->type) {
			case "info":  // set info icon
				$_iconpath = WE_THEMES_DIR . "/" . WE_THEME_NAME . "/we_ui_layout_NoteDiv/info_small.gif";
				if (file_exists($GLOBALS['__WE_LIB_PATH__'] . $_iconpath)) {
					$_imagesize = getimagesize($GLOBALS['__WE_LIB_PATH__'] . $_iconpath);
					$_style  = array("background-image"=>"url(" . $GLOBALS['__WE_LIB_URL__'] . $_iconpath. ")",
									"padding-left" => ($_imagesize[0] + 10) . "px",
									"height: " => ($_imagesize[1]) . "px");
									
				}				
				break;
			case "warning": // set warning / alert icon 
			case "alert": 
				$_iconpath = WE_THEMES_DIR . "/" . WE_THEME_NAME . "/we_ui_layout_NoteDiv/alert_small.gif";
				if (file_exists($GLOBALS['__WE_LIB_PATH__'] . $_iconpath)) {
					$_imagesize = getimagesize($GLOBALS['__WE_LIB_PATH__'] . $_iconpath);
					$_style  = array("background-image"=>"url(" . $GLOBALS['__WE_LIB_URL__'] . $_iconpath. ")",
								"padding-left" => ($_imagesize[0] + 10) . "px",
								"height" => ($_imagesize[1]) . "px",
								"overflow" => "auto");
				}				
				break;
			case "question": // set qestionmark icon
				$_iconpath = WE_THEMES_DIR . "/" . WE_THEME_NAME . "/we_ui_layout_NoteDiv/question_small.gif";
				if (file_exists($GLOBALS['__WE_LIB_PATH__'] . $_iconpath)) {
					$_imagesize = getimagesize($GLOBALS['__WE_LIB_PATH__'] . $_iconpath);
					$_style  = array("background-image" => "url(" . $GLOBALS['__WE_LIB_URL__'] . $_iconpath. ")",
								"padding-left" => ($_imagesize[0] + 10) . "px",
								"height" => ($_imagesize[1]) . "px",
								"overflow2" => "auto");
				}				
				break;
			default:
				$_icon = "";
				$_style = "";
				
		}
		return '<div' . 
			$this->_getNonBooleanAttribs('id') . 
			($_style != "" ? $this->_getComputedStyleAttrib($_style) : "") . 
			$this->_getComputedClassAttrib('we_ui_layout_NoteDiv') . 
			'>' . $this->_divHTML .
			'</div>';
	}
	
	/**
	 * @param string $type
	 * 
	 * @return void
	 */
	public function setType($type){
		$this->type = $type;
		return true;
	}
	
	/**
	 * @param string $text
	 * @return void
	 */
	public function addText($text){
		if ($this->_divHTML .= nl2br($text)) {
			return true;
		} else {
			return false;
		}		
	}
}

?>
