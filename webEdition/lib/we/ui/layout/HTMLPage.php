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
 * Class to build a HTML page
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_HTMLPage extends we_ui_abstract_AbstractElement
{

	/*
	 * Static variable to hold singleton instance
	 */
	private static $__instance = NULL;

	/**
	 * title tag
	 *
	 * @var string
	 */
	protected $_title = 'webEdition (c) 2008 living-e AG (http://www.living-e.com)';

	/**
	 * array that holds internal css code to include into page
	 *
	 * @var array
	 */
	protected $_inlineCSS = array();

	/*
	 * Holds the HTML for a frameset
	 * 
	 * @var string 
	 */
	protected $_framesetHTML = '';

	/**
	 * array that holds internal js code to include into page
	 *
	 * @var array
	 */
	protected $_inlineJS = array();

	/**
	 * string with innerHTML of the <body> Tag
	 *
	 * @var string
	 */
	protected $_bodyHTML = '';

	/**
	 * string with name of charset
	 *
	 * @var string
	 */
	protected $_charset = '';

	/**
	 * string with doctype tag
	 *
	 * @var string
	 */
	protected $_doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

	/**
	 * array with attributes to insert in the body tag
	 *
	 * @var string
	 */
	protected $_bodyAttributes = array();

	protected $_isTopFrame = false;

	/**
	 * adds HTML Code to innerHTML of body tag
	 *
	 * @param string $html
	 * @return void
	 */
	public function addHTML($html)
	{
		$this->_bodyHTML .= $html;
	}

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$charset = we_core_Local::getComputedUICharset();
		$this->setCharset($charset);
		
		$controller = Zend_Controller_Front::getInstance();
		if ($controller->getResponse()) {
			$controller->getResponse()->setHeader('Content-Type', 'text/html; charset=' . $charset, true);
		} else {
			header('Content-Type: text/html; charset=' . $charset);
		}
		parent::__construct();
		$this->addCSSFile(we_ui_layout_Themes::computeCSSUrl(__CLASS__));
	}

	/*
	 * gets a singleton instance.
	 * 
	 * @return we_ui_layout_HTMLPage
	 */
	public static function getInstance()
	{
		
		if (self::$__instance === NULL) {
			self::$__instance = new self();
		}
		return self::$__instance;
	}

	/*
    * avoid calling clone()
    */
	private function __clone()
	{
	}

	/**
	 * adds an element to the page. The elements HTML
	 * will be added to the innerHTML of the body tag
	 *
	 * @param we_ui_abstract_AbstractElement $elem
	 * @return void
	 */
	public function addElement($elem)
	{
		$this->addCSSFiles($elem->getCSSFiles());
		$this->addJSFiles($elem->getJSFiles());
		$this->_bodyHTML .= $elem->getHTML();
	}

	/**
	 * adds CSS code to the page 
	 * Will be inserted into the header section of the page
	 * using the <style> tag
	 *
	 * @param string $css CSS code to add
	 * @return void
	 */
	public function addInlineCSS($css)
	{
		if ($css) {
			$this->_inlineCSS[] = $css;
		}
	}

	/**
	 * adds JavaScript code to the page 
	 * Will be inserted into the header section of the page
	 * using the <script> tag
	 *
	 * @param string $js JavaScript code to add
	 * @return void
	 */
	public function addInlineJS($js)
	{
		if ($js) {
			$this->_inlineJS[] = $js;
		}
	}

	/**
	 * adds body attribute 
	 *
	 * @param string $name  name of attribute
	 * @param string $value value of attribute
	 * @return void
	 */
	public function addBodyAttribute($name, $value)
	{
		$this->_bodyAttributes[$name] = $value;
	}

	/**
	 * renders and returns the HTML code of the page
	 * will be called from getHTML()
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		
		$this->addJSFile('/webEdition/js/attachKeyListener.js');
		
		$js = '';
		if (!$this->_isTopFrame) {
			$js = <<<EOS

function weGetTop() {
	if (self != parent && typeof(parent.weGetTop) != "undefined") {
		return parent.weGetTop();
	} else {
		return parent;
	}
}

function weCC() {
	if (typeof(weGetTop().we_core_CmdController) != "undefined") {
		return weGetTop().we_core_CmdController.getInstance();
	} else if (opener){
		if (typeof(opener.we_core_CmdController) != "undefined") {
			return opener.we_core_CmdController.getInstance(); 
		} else if (typeof(opener.weCC) != "undefined"){
			return opener.weCC(); 
		}
	}
	return null;
}

function weEC() {
	var topFrame = weGetTop();
	if (typeof(topFrame.weEventController) !== "undefined") {
		return topFrame.weEventController;
	} else if (opener){
		if (typeof(opener.weEventController) != "undefined") {
			return opener.weEventController; 
		} else if (typeof(opener.weEC) != "undefined"){
			return opener.weEC(); 
		}
	}
	return null;
}

var weCmdController = weCC();
var weEventController = weEC();

EOS;
		
		} else {
			$this->addJSFile('/webEdition/lib/we/core/CmdController.js');
			$this->addJSFile('/webEdition/lib/we/core/EventController.js');
			
			$js = <<<EOS

var weCmdController = we_core_CmdController.getInstance();
var weEventController = new we_core_EventController();
EOS;
		
		}
		$html = '';
		
		// add d octype tag if not empty
		if ($this->getDoctype() !== '') {
			$html .= $this->getDoctype() . "\n";
		}
		
		// add <html> tag
		if ($this->getLang() !== '') {
			$html .= '<html lang="' . $this->getLang() . '">';
		} else {
			$html .= '<html>';
		}
		
		// add <header> tag
		$html .= "\n";
		$html .= "<head>\n";
		
		// add meta tag for charset if not empty
		if ($this->getCharset() !== '') {
			$html .= "\t" . '<meta http-equiv="content-type" content="text/html; charset=' . $this->getCharset() . '">' . "\n";
		}
		
		// add title tag if not empty
		if ($this->getTitle() !== '') {
			$html .= "\t" . '<title>' . $this->getTitle() . '</title>' . "\n";
		}
		
		// add link tags for external CSS files
		foreach ($this->_CSSFiles as $file) {
			$html .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $file['path'] . '" media="' . $file['media'] . '" />' . "\n";
		}
		
		// add inline CSS
		if (count($this->_inlineCSS) > 0) {
			$html .= "\t<style>\n";
			foreach ($this->_inlineCSS as $code) {
				$html .= $code . "\n";
			}
			$html .= "\t</style>\n";
		}
		
		// add javascript tags for external JavaScript files
		foreach ($this->_JSFiles as $file) {
			$html .= "\t" . '<script type="text/javascript" language="JavaScript" src="' . $file . '"></script>' . "\n";
		}
		
		$html .= "\t<script type=\"text/javascript\" language=\"JavaScript\">\n";
		$html .= $js . "\n";
		// add inline JavaScript
		foreach ($this->_inlineJS as $code) {
			$html .= $code . "\n";
		}
		$html .= "\t</script>\n";
		
		// add head end tag
		$html .= "</head>\n";
		if ($this->_framesetHTML !== '') {
			$out = $html . $this->_framesetHTML . '</html>';
		} else {
			$body = we_xml_Tags::createStartTag('body', $this->_bodyAttributes) . "\n" . $this->getBodyHTML() . "\n</body>\n";
			$out = $html . $body . '</html>';
		}
		return $out;
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
	}

	/**
	 * Retrieve body attributes as an associative array
	 * 
	 * @return array
	 */
	public function getBodyAttributes()
	{
		return $this->_bodyAttributes;
	}

	/**
	 * Retrieve innerHTML of body tag
	 *
	 * @return string
	 */
	public function getBodyHTML()
	{
		return $this->_bodyHTML;
	}

	/**
	 * Retrieve charset of page
	 *
	 * @return string
	 */
	public function getCharset()
	{
		return $this->_charset;
	}

	/**
	 * Retrieve doctype tag of page
	 *
	 * @return string
	 */
	public function getDoctype()
	{
		return $this->_doctype;
	}

	/**
	 * Retrieve frameset HTML
	 *
	 * @return string
	 */
	public function getFramesetHTML()
	{
		return $this->_framesetHTML;
	}

	/**
	 * set body attributes
	 * 
	 * @param array $bodyAttributes
	 * @return void
	 */
	public function setBodyAttributes($bodyAttributes)
	{
		$this->_bodyAttributes = $bodyAttributes;
	}

	/**
	 * set innerHTML of body tag
	 *
	 * @param string $bodyHTML
	 * @return void
	 */
	public function setBodyHTML($bodyHTML)
	{
		$this->_bodyHTML = $bodyHTML;
	}

	/**
	 * set charset of page
	 *
	 * @param string $charset
	 * @return void
	 */
	public function setCharset($charset)
	{
		$this->_charset = $charset;
	}

	/**
	 * set doctype tag of page
	 *
	 * @param string $doctype
	 * @return void
	 */
	public function setDoctype($doctype)
	{
		$this->_doctype = $doctype;
	}

	/**
	 * Set frameset HTML of page
	 *
	 * @param string $frameset
	 * @return void
	 */
	public function setFramesetHTML($frameset)
	{
		$this->_framesetHTML = $frameset;
	}

	/**
	 * set frameset  for page
	 *
	 * @param we_ui_layout_Frameset $frameset
	 * @return void
	 */
	public function setFrameset($frameset)
	{
		$this->_framesetHTML = $frameset->getHTML();
	}

	/**
	 * @return unknown
	 */
	public function getIsTopFrame()
	{
		return $this->_isTopFrame;
	}

	/**
	 * @return unknown
	 */
	public function isTopFrame()
	{
		return $this->getIsTopFrame();
	}

	/**
	 * @param unknown_type $isTopFrame
	 */
	public function setIsTopFrame($isTopFrame)
	{
		$this->_isTopFrame = $isTopFrame;
	}
}
