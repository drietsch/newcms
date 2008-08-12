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
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: AbstractElement.php,v 1.15 2008/06/16 13:15:36 holger.meyer Exp $
 */

/**
 * @see we_core_AbstractObject
 */
Zend_Loader::loadClass('we_core_AbstractObject');

/**
 * Base class for all kind of html elements
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
abstract class we_ui_abstract_AbstractElement extends we_core_AbstractObject
{
	/**
	 * id attribute
	 *
	 * @var string
	 */
	protected $_id = '';

	/**
	 * width of element. Will be inserted into style attribute
	 * @see we_ui_abstractElement::_getStyleAttrib()
	 *
	 * @var integer|string
	 */
	protected $_width = '';

	/**
	 * height of element. Will be inserted into style attribute
	 * @see we_ui_abstractElement::_getStyleAttrib()
	 *
	 * @var integer|string
	 */
	protected $_height = '';
	
	/**
	 * left position of element. Will be inserted into style attribute
	 * @see we_ui_abstractElement::_getStyleAttrib()
	 *
	 * @var integer|string
	 */
	protected $_left = '';
	
	/**
	 * top position of element. Will be inserted into style attribute
	 * @see we_ui_abstractElement::_getStyleAttrib()
	 *
	 * @var integer|string
	 */
	protected $_top = '';
	
	/**
	 * type of position of element. Will be inserted into style attribute
	 * @see we_ui_abstractElement::_getStyleAttrib()
	 *
	 * @var string
	 */
	protected $_position = '';

	/**
	 * overflow style
	 *
	 * @var string
	 */
	protected $_overflow = '';
	
	/**
	 * style attribute
	 *
	 * @var string
	 */
	protected $_style = '';

	/**
	 * class attribute
	 *
	 * @var string
	 */
	protected $_class = '';

	/**
	 * disabled attribute
	 *
	 * @var boolean
	 */
	protected $_disabled = false;
	
	/**
     * hidden attribute
     *
     * @var boolean
     */
	protected $_hidden = false;

	/**
	 * title attribute or title tag
	 *
	 * @var string
	 */
	protected $_title = '';

	/**
	 * lang attribute
	 *
	 * @var string
	 */
	protected $_lang = '';

	
	/**
	 * array to hold all needed JS files
	 *
	 * @var array
	 */
	protected $_JSFiles = array();
	
	/**
	 * array to hold all needed CSS files 
	 *
	 * @var array
	 */
	protected $_CSSFiles = array();
	
	
	/**
	 * Computes the default JavaScript URL for the given Class Name
	 *
	 * @param string $classname
	 * @return string
	 */
	public static function computeJSURL($classname) {
		if (substr($classname, 0, 3) == 'we_') {
			return $GLOBALS['__WE_LIB_URL__'] . '/' . join('/', explode('_', $classname)) . '.js';
		} else {
			return $GLOBALS['__WE_APP_URL__'] . '/' . join('/', explode('_', $classname)) . '.js';
		}
		return '';
	}
	
	/**
	 * Retrieve HTML of ui element
	 *
	 * @return string
	 */
	public function getHTML()
	{
		$this->_willRenderHTML();
		$html = $this->_renderHTML();
		$this->_didRenderHTML();
		return $html;
	}

	/**
	 * Retrieve HTML of ui element for use in 
	 * JavaScript
	 *
	 * @return string
	 */
	public function getJSHTML() {
		$html = $this->getHTML();
		return str_replace('\'', '\\\'', str_replace('\\', '\\\\', $html));
	}
	/**
	 * Renders and returns HTML of ui element
	 *
	 * @return string
	 */
	abstract protected function _renderHTML();

	/**
	 * Returns the computed style attrib as text to insert into the HTML tag
	 *
	 * @param array $additionalStyles
	 * @param integer $widthOffset value to add to width, can also be negative. Used for box model problems
	 * @param integer $heightOffset value to add to height, can also be negative. Used for box model problems
	 * @return string
	 */
	protected function _getComputedStyleAttrib($additionalStyles=array(), $widthOffset=0, $heightOffset=0, $leftOffset=0, $topOffset=0)
	{
		$style = '';
		$w = abs($this->_width) + $widthOffset;
		$wUnit = (strpos($this->_width,"%") === false) ? 'px' : '%';
		
		$h = abs($this->_height) + $heightOffset;
		$hUnit = (strpos($this->_height,"%") === false) ? 'px' : '%';
				
		$top = abs($this->_top) + $topOffset;;
		$topUnit = (strpos($this->_top,"%") === false) ? 'px' : '%';
		
		$left = abs($this->_left) + $leftOffset;;
		$leftUnit = (strpos($this->_left,"%") === false) ? 'px' : '%';
				
		if ($w > 0) {
			$style .= "width:{$w}$wUnit;";
		}
		
		if ($h > 0) {
			$style .= "height:{$h}$hUnit;";
		}
		
		if ($top > 0) {
			$style .= "top:{$top}$topUnit;";
		}
		
		if ($left > 0) {
			$style .= "left:{$left}$leftUnit;";
		}
		
		if ($this->_overflow !== '') {
			$style .= "overflow:$this->_overflow;";
		}
		
		if ($this->_position !== '') {
			$style .= "position:$this->_position;";
		}
		
		foreach ($additionalStyles as $n=>$k) {
			$style .= "$n:$k;";
		}
		
		$style .= $this->getStyle();
		if ($style !== '') {
			return ' style="' . htmlspecialchars($style) . '"';
		}
		return '';
	}

	/**
	 * Returns the computed class attrib as text to insert into the HTML tag
	 *
	 * @param string $class  default class name for element
	 * @return string
	 */
	protected function _getComputedClassAttrib($class = '')
	{
		if ($this->getClass() !== '') {
			if ($class !== '') {
				$class .= ' ' . $this->getClass();
			} else {
				$class = $this->getClass();
			}
		}
		if ($class !== '') {
			$class = ' class="' . htmlspecialchars($class) . '"';
		}
		return $class;
	}

	/**
	 * Returns string with non boolean attribs to insert into html tag
	 *
	 * @param string $attribsString comma separated string with attribute names
	 * @return string
	 */
	protected function _getNonBooleanAttribs($attribsString)
	{
		$arr = explode(',', $attribsString);
		$attribs = '';
		foreach ($arr as $attribName) {
			$internalName = "_$attribName";
			if (isset($this->$internalName) && $this->$internalName !== '') {
				$attribs .= ' ' . htmlspecialchars($attribName) . '="' . htmlspecialchars($this->$internalName) . '"';
			}
		}
		return $attribs;
	}

	/**
	 * Returns string with  boolean attribs to insert into html tag
	 *
	 * @param string $attribsString comma separated string with attribute names
	 * @return string
	 */
	protected function _getBooleanAttribs($attribsString)
	{
		$arr = explode(',', $attribsString);
		$attribs = '';
		foreach ($arr as $attribName) {
			$internalName = "_$attribName";
			if (isset($this->$internalName) && $this->$internalName === true) {
				$attribs .= ' ' . htmlspecialchars($attribName) . '="' . htmlspecialchars($attribName) . '"';
			}
		}
		return $attribs;
	}

	/**
	 * called before _renderHTML() is called
	 *
	 * @return void
	 */
	protected function _willRenderHTML()
	{
		if ($this->getId() === '') {
			$this->setId(we_util_Strings::createUniqueId());
		}
	}

	/**
	 * called after _renderHTML() is called
	 *
	 * @return void
	 */
	protected function _didRenderHTML()
	{
		// overwrite
	}

		
	/**
	 * Adds an  array with CSS file to the page. 
	 * Will be inserted into the header section of the page
	 * using the <link> tag
	 *
	 * @param string $path path to file relative to DOCUMENT_ROOT, starting with a slash or class name of element
	 * @return void
	 */
	public function addCSSFiles($files) {
		foreach ($files as $file) {
			$this->addCSSFile($file['path'], $file['media']);
		}
	}
	
	/**
	 * Adds a CSS file to the page. 
	 * Will be inserted into the header section of the page
	 * using the <link> tag
	 *
	 * @param string $path path to file relative to DOCUMENT_ROOT, starting with a slash or class name of element
	 * @return void
	 */
	public function addCSSFile($path, $media = 'all')
	{
		if ($path) {
			$elem = array('media' => $media, 'path' => $path);
			if (!in_array($elem, $this->_CSSFiles)) {
				$this->_CSSFiles[] = array('media' => $media, 'path' => $path);
			}
		}
	}

	/**
	 * Adds a JS file to the page. 
	 * Will be inserted into the header section of the document
	 * using the <script> tag
	 *
	 * @param string $path path to file relative to DOCUMENT_ROOT, starting with a slash or class name of element
	 * @return void
	 */
	public function addJSFile($path)
	{
		if ($path && !in_array($path, $this->_JSFiles)) {
			$this->_JSFiles[] = $path;
		}
	}
	
	/**
	 * Adds an array with JS files to the page. 
	 * Will be inserted into the header section of the document
	 * using the <script> tag
	 *
	 * @param string $path path to file relative to DOCUMENT_ROOT, starting with a slash or class name of element
	 * @return void
	 */
	public function addJSFiles($files) {
		$this->_JSFiles = array_unique(array_merge($this->_JSFiles, $files));
	}
	
	/**
	 * Retrieves all needed JS files for the element
	 *
	 * @return array
	 */
	public function getJSFiles() {
		
		return $this->_JSFiles;
	}
	
	/**
	 * Retrieves all needed CSS files for the element
	 *
	 * @return array
	 */
	public function getCSSFiles() {
		
		return $this->_CSSFiles;
	}
	
	/**
	 * Retrieve class attribute
	 * 
	 * @return string
	 */
	public function getClass()
	{
		return $this->_class;
	}

	/**
	 * Retrieve disabled attribute
	 * 
	 * @return boolean
	 */
	public function getDisabled()
	{
		return $this->_disabled;
	}
	
	/**
	 * Retrieve hidden attribute
	 * 
	 * @return boolean
	 */
	public function getHidden() 
	{
		return $this->_hidden;
	}
	
	/**
	 * Set hidden attribute
	 * 
	 * @param boolean $hidden
	 * @return void
	 */
	public function setHidden($hidden) 
	{
		$this->_hidden = $hidden;
	}

	/**
	 * Retrieve height property.
	 * 
	 * @return integer
	 */
	public function getHeight()
	{
		return $this->_height;
	}

	/**
	 * Retrieve id attribute
	 * 
	 * @return string
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * Retrieve lang attribute
	 * 
	 * @return string
	 */
	public function getLang()
	{
		return $this->_lang;
	}

	/**
	 * Retrieve left property
	 * 
	 * @return integer|string
	 */
	public function getLeft()
	{
		return $this->_left;
	}

	/**
	 * Retrieve overflow 
	 * 
	 * @return string
	 */
	public function getOverflow()
	{
		return $this->_overflow;
	}

	/**
	 * Retrieve position property
	 * 
	 * @return string
	 */
	public function getPosition()
	{
		return $this->_position;
	}

	/**
	 * Retrieve style attribute
	 * 
	 * @return string
	 */
	public function getStyle()
	{
		return $this->_style;
	}

	/**
	 * Retrieve title property
	 * 
	 * @return s
	 */
	public function getTitle()
	{
		return $this->_title;
	}

	/**
	 * Retrieve top property
	 * 
	 * @return integer|string
	 */
	public function getTop()
	{
		return $this->_top;
	}

	/**
	 * Retrieve width property
	 * 
	 * @return integer|string
	 */
	public function getWidth()
	{
		return $this->_width;
	}

	/**
	 * Set class attribute
	 * 
	 * @param string $class
	 * @return void
	 */
	public function setClass($class)
	{
		$this->_class = $class;
	}

	/**
	 * Set disabled attribute
	 * 
	 * @param boolean $disabled
	 * @return void
	 */
	public function setDisabled($disabled)
	{
		$this->_disabled = $disabled;
	}

	/**
	 * Set height attribute
	 * 
	 * @param integer $height
	 * @return void
	 */
	public function setHeight($height)
	{
		$this->_height = $height;
	}

	/**
	 * Set id attribute
	 * 
	 * @param string $id
	 * @return void
	 */
	public function setId($id)
	{
		$this->_id = $id;
	}

	/**
	 * Set lang attribute
	 * 
	 * @param string $lang
	 * @return void
	 * 	 */
	public function setLang($lang)
	{
		$this->_lang = $lang;
	}

	/**
	 * Set left attribute
	 * 
	 * @param integer|string $left
	 * @return void
	 * 	 */
	public function setLeft($left)
	{
		$this->_left = $left;
	}

	/**
	 * Set overflow attribute
	 * 
	 * @param string $overflow
	 * @return void
	 */
	public function setOverflow($overflow)
	{
		$this->_overflow = $overflow;
	}
	
	/**
	 * Set position attribute
	 * 
	 * @param string $position
	 * @return void
	 */
	public function setPosition($position)
	{
		$this->_position = $position;
	}
	
	/**
	 * Set style attribute
	 * 
	 * @param string $style
	 * @return void
	 */
	public function setStyle($style)
	{
		$this->_style = $style;
	}

	/**
	 * Set title attribute
	 * 
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->_title = $title;
	}

	/**
	 * Set top attribute
	 * 
	 * @param integer|string $top
	 * @return void
	 * 	 */
	public function setTop($top)
	{
		$this->_top = $top;
	}

	
	/**
	 * Set width attribute
	 * 
	 * @param integer|string $width
	 * @return void
	 */
	public function setWidth($width)
	{
		$this->_width = $width;
	}
	
}
