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
 * @version    $Id: HeadlineIconTableRow.php,v 1.3 2008/06/13 16:59:17 holger.meyer Exp $
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Class which creates a row to display in a we_ui_layout_HeadlineIconTable
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @see we_ui_layout_HeadlineIconTable
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_layout_HeadlineIconTableRow extends we_ui_abstract_AbstractElement
{

	/*
	 * Path for Attributes Icon
	 */
	const kIconAttributes = '/webEdition/images/icons/attrib.gif';

	/*
	 * Path for Cache Icon
	 */
	const kIconCache = '/webEdition/images/icons/cache.gif';

	/*
	 * Path for Calendar Icon
	 */
	const kIconCalendar = '/webEdition/images/icons/cal.gif';

	/*
	 * Path for Category Icon
	 */
	const kIconCategory = '/webEdition/images/icons/cat.gif';

	/*
	 * Path for Charset Icon
	 */
	const kIconCharset = '/webEdition/images/icons/charset.gif';

	/*
	 * Path for Class Icon
	 */
	const kIconClass = '/webEdition/images/icons/class.gif';

	/*
	 * Path for Classes Icon
	 */
	const kIconClasses = '/webEdition/images/icons/classes.gif';

	/*
	 * Path for Copy Icon
	 */
	const kIconCopy = '/webEdition/images/icons/copy.gif';

	/*
	 * Path for CSS Icon
	 */
	const kIconCSS = '/webEdition/images/icons/css.gif';

	/*
	 * Path for Default Icon
	 */
	const kIconDefault = '/webEdition/images/icons/default.gif';

	/*
	 * Path for Display Icon
	 */
	const kIconDisplay = '/webEdition/images/icons/display.gif';

	/*
	 * Path for Document Icon
	 */
	const kIconDocument = '/webEdition/images/icons/doc.gif';

	/*
	 * Path for Hyperlink Icon
	 */
	const kIconHyperLink = '/webEdition/images/icons/hyperlink.gif';

	/*
	 * Path for Language Icon
	 */
	const kIconLanguage = '/webEdition/images/icons/lang.gif';

	/*
	 * Path for Master Template Icon
	 */
	const kIconMasterTemplate = '/webEdition/images/icons/mastertemplate.gif';

	/*
	 * Path for Meta Fields Icon
	 */
	const kIconMetaFields = '/webEdition/images/icons/meta.gif';

	/*
	 * Path for Navigation Icon
	 */
	const kIconNavgation = '/webEdition/images/icons/navi.gif';

	/*
	 * Path for Owner Icon
	 */
	const kIconOwner = '/webEdition/images/icons/owner.gif';

	/*
	 * Path for Path Icon
	 */
	const kIconPath = '/webEdition/images/icons/path.gif';

	/*
	 * Path for Upload Icon
	 */
	const kIconUpload = '/webEdition/images/icons/upload.gif';

	/*
	 * Path for User Icon
	 */
	const kIconUser = '/webEdition/images/icons/user.gif';

	/*
	 * Path for Workflow Icon
	 */
	const kIconWorkflow = '/webEdition/images/icons/workflow.gif';

	/*
	 * Path for Workspace Icon
	 */
	const kIconWorkspace = '/webEdition/images/icons/workspace.gif';

	/*
	 * buffer to store the content HTML
	 * 
	 * @var string
	 */
	protected $_contentHTML = "";

	/*
	 * position where the title should displays. 
	 * Possible values are "left" and "right"
	 * 
	 * @var string
	 */
	protected $_titlePosition = 'left';

	/*
	 * path (src) where the icon is stored
	 * 
	 * @var string
	 */
	protected $_iconPath = '';

	/*
	 * width of the left column
	 * 
	 * @var integer
	 */
	protected $_leftWidth = 150;

	/*
	 * If set to true a line will be inserted at the end of the row
	 * 
	 * @var boolean
	 */
	protected $_line = true;

	/**
	 * adds an element to the table row. The elements HTML
	 * will be added to the right columns innerHTML
	 *
	 * @param we_ui_abstract_AbstractElement $elem
	 * @return void
	 */
	public function addElement($elem)
	{
		$this->addCSSFiles($elem->getCSSFiles());
		$this->addJSFiles($elem->getJSFiles());		
		$this->_contentHTML .= $elem->getHTML();
	}

	/**
	 * adds HTML to the right columns innerHTML
	 *
	 * @param string $html
	 * @return void
	 */
	public function addHTML($html)
	{
		$this->_contentHTML .= $html;
	}

	/**
	 * Renders and returns HTML of table
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$iconHTML = ($this->_iconPath !== '') ? ('<img src="' . htmlspecialchars($this->_iconPath) . '" alt="" />') : "";
		$headlineHTML = ($this->_title !== '') ? ('<div class="' . we_ui_layout_HeadlineIconTable::kRowTitle . '" style="margin-bottom:10px;">' . htmlspecialchars($this->_title) . '</div>') : "";
		
		$leftContent = ($iconHTML !== '') ? $iconHTML : (($this->_leftWidth && ($this->_titlePosition == 'left')) ? $headlineHTML : "");
		
		$rightContent = '<div style="float:left;">' . ((($iconHTML && $headlineHTML) || ($leftContent === "") || ($this->_titlePosition != 'left')) ? ($headlineHTML . '<div>' . $this->_contentHTML . '</div>') : '<div>' . $this->_contentHTML . '</div>') . '</div>';
		
		$html = '';
		
		if ($leftContent || $this->_leftWidth) {
			if ((!$leftContent) && $this->_leftWidth) {
				$leftContent = "&nbsp;";
			}
			$html .= '<div style="float:left;width:' . $this->_leftWidth . 'px">' . $leftContent . '</div>';
		}
		
		$html .= $rightContent;
		$html .= '<br style="clear:both;">';
		
		return $html;
	}

	/**
	 * Retrieve line attribute
	 * 
	 * @return boolean
	 */
	public function getLine()
	{
		return $this->_line;
	}

	/**
	 * Retrieve iconPath attribute
	 * 
	 * @return string
	 */
	public function getIconPath()
	{
		return $this->_iconPath;
	}

	/**
	 * Retrieve leftWidth attribute
	 * 
	 * @return integer
	 */
	public function getLeftWidth()
	{
		return $this->_leftWidth;
	}

	/**
	 * Retrieve line attribute => Alias for getLine()
	 * 
	 * @return boolean
	 */
	public function hasLine()
	{
		return $this->getLine();
	}

	/**
	 * Set line attribute => Alias for getLine()
	 * 
	 * @param string $iconPath
	 * @return void
	 */
	public function setIconPath($iconPath)
	{
		$this->_iconPath = $iconPath;
	}

	/**
	 * Set leftWidth attribute
	 * 
	 * @param integer $leftWidth
	 * @return void
	 */
	public function setLeftWidth($leftWidth)
	{
		$this->_leftWidth = $leftWidth;
	}

	/**
	 * Set line attribute
	 * 
	 * @param boolean $line
	 * @return void
	 */
	public function setLine($line)
	{
		$this->_line = $line;
	}

	/**
	 * Set titlePosition attribute
	 * 
	 * @param string $titlePosition possible values are "right" and "left"
	 * @return void
	 */
	public function setTitlePosition($titlePosition)
	{
		$this->_titlePosition = $titlePosition;
	}
}
