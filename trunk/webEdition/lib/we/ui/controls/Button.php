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
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Button.php,v 1.1 2008/05/14 13:41:29 thomas.kneip Exp $
 */

/**
 * @see we_ui_abstract_AbstractFormElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractFormElement');

/**
 * Class to display a button
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_Button extends we_ui_abstract_AbstractFormElement
{

	/*
	 * Path for Add Category Icon
	 */
	const kIconAddCat = '/webEdition/images/button/icons/add_cat.gif';

	/*
	 * Path for Add Document Type Icon
	 */
	const kIconAddDoc = '/webEdition/images/button/icons/add_doc.gif';

	/*
	 * Path for Add Field Icon
	 */
	const kIconAddField = '/webEdition/images/button/icons/add_field.gif';

	/*
	 * Path for Add File Icon
	 */
	const kIconAddFile = '/webEdition/images/button/icons/add_file.gif';

	/*
	 * Path for Add Flash Icon
	 */
	const kIconAddFlash = '/webEdition/images/button/icons/add_flash.gif';

	/*
	 * Path for Add Image Icon
	 */
	const kIconAddImage = '/webEdition/images/button/icons/add_image.gif';

	/*
	 * Path for Add Link Icon
	 */
	const kIconAddLink = '/webEdition/images/button/icons/add_link.gif';

	/*
	 * Path for Add Listelement Icon
	 */
	const kIconAddListElement = '/webEdition/images/button/icons/add_listelement.gif';

	/*
	 * Path for Add Note Icon
	 */
	const kIconAddNote = '/webEdition/images/button/icons/add_note.gif';

	/*
	 * Path for Add Quicktime Icon
	 */
	const kIconAddQuicktime = '/webEdition/images/button/icons/add_quicktime.gif';

	/*
	 * Path for Add Schedule Icon
	 */
	const kIconAddSchedule = '/webEdition/images/button/icons/add_schedule.gif';

	/*
	 * Path for Add Template Icon
	 */
	const kIconAddTemplate = '/webEdition/images/button/icons/add_template.gif';

	/*
	 * Path for Add Thumbnail Icon
	 */
	const kIconAddThumbnail = '/webEdition/images/button/icons/add_thumbnail.gif';

	/*
	 * Path for date picker Icon
	 */
	const kIconDatePicker = '/webEdition/images/button/icons/date_picker.gif';

	/*
	 * Path for direction down Icon
	 */
	const kIconDirectionDown = '/webEdition/images/button/icons/direction_down.gif';

	/*
	 * Path for direction left Icon
	 */
	const kIconDirectionLeft = '/webEdition/images/button/icons/direction_left.gif';

	/*
	 * Path for direction right Icon
	 */
	const kIconDirectionRight = '/webEdition/images/button/icons/direction_right.gif';

	/*
	 * Path for direction up Icon
	 */
	const kIconDirectionUp = '/webEdition/images/button/icons/direction_up.gif';

	/*
	 * Path for edit Icon
	 */
	const kIconEdit = '/webEdition/images/button/icons/edit_edit.gif';

	/*
	 * Path for edit flash Icon
	 */
	const kIconEditFlash = '/webEdition/images/button/icons/edit_flash.gif';

	/*
	 * Path for edit image Icon
	 */
	const kIconEditImage = '/webEdition/images/button/icons/edit_image.gif';

	/*
	 * Path for edit include Icon
	 */
	const kIconEditInclude = '/webEdition/images/button/icons/edit_include.gif';

	/*
	 * Path for edit link Icon
	 */
	const kIconEditLink = '/webEdition/images/button/icons/edit_link.gif';

	/*
	 * Path for edit list Icon
	 */
	const kIconEditList = '/webEdition/images/button/icons/edit_list.gif';

	/*
	 * Path for edit object Icon
	 */
	const kIconEditObject = '/webEdition/images/button/icons/edit_object.gif';

	/*
	 * Path for edit pdf Icon
	 */
	const kIconEditPDF = '/webEdition/images/button/icons/edit_pdf.gif';

	/*
	 * Path for edit quicktime Icon
	 */
	const kIconEditQuicktime = '/webEdition/images/button/icons/edit_quicktime.gif';

	/*
	 * Path for edit real Icon
	 */
	const kIconEditReal = '/webEdition/images/button/icons/edit_real.gif';

	/*
	 * Path for edit wmp Icon
	 */
	const kIconEditWMP = '/webEdition/images/button/icons/edit_wmp.gif';

	/*
	 * Path for folder back Icon
	 */
	const kIconFolderBack = '/webEdition/images/button/icons/fs_back.gif';

	/*
	 * Path for plus Icon
	 */
	const kIconPlus = '/webEdition/images/button/icons/function_plus.gif';

	/*
	 * Path for publish Icon
	 */
	const kIconPublish = '/webEdition/images/button/icons/function_publish.gif';

	/*
	 * Path for reload Icon
	 */
	const kIconReload = '/webEdition/images/button/icons/function_reload.gif';

	/*
	 * Path for search Icon
	 */
	const kIconSearch = '/webEdition/images/button/icons/function_search.gif';

	/*
	 * Path for trash Icon
	 */
	const kIconTrash = '/webEdition/images/button/icons/function_trash.gif';

	/*
	 * Path for unpublish Icon
	 */
	const kIconUnpublish = '/webEdition/images/button/icons/function_unpublish.gif';

	/*
	 * Path for view Icon
	 */
	const kIconView = '/webEdition/images/button/icons/function_view.gif';

	/*
	 * Path for help Icon
	 */
	const kIconHelp = '/webEdition/images/button/icons/help.gif';

	/*
	 * Path for iconview Icon
	 */
	const kIconIconView = '/webEdition/images/button/icons/iconview.gif';

	/*
	 * Path for listview Icon
	 */
	const kIconListview = '/webEdition/images/button/icons/listview.gif';

	/*
	 * Path for messages copy Icon
	 */
	const kIconMessagesCopy = '/webEdition/images/button/icons/messages_copy.gif';

	/*
	 * Path for messages create Icon
	 */
	const kIconMessagesCreate = '/webEdition/images/button/icons/messages_create.gif';

	/*
	 * Path for messages cut Icon
	 */
	const kIconMessagesCut = '/webEdition/images/button/icons/messages_cut.gif';

	/*
	 * Path for messages paste Icon
	 */
	const kIconMessagesPaste = '/webEdition/images/button/icons/messages_paste.gif';

	/*
	 * Path for messages reply Icon
	 */
	const kIconMessagesReply = '/webEdition/images/button/icons/messages_reply.gif';

	/*
	 * Path for messages tasks Icon
	 */
	const kIconMessagesTasks = '/webEdition/images/button/icons/messages_tasks.gif';

	/*
	 * Path for messages trash Icon
	 */
	const kIconMessagesTrash = '/webEdition/images/button/icons/messages_trash.gif';

	/*
	 * Path for messages update Icon
	 */
	const kIconMessagesUpdate = '/webEdition/images/button/icons/messages_update.gif';

	/*
	 * Path for new bannergroup Icon
	 */
	const kIconNewBannergroup = '/webEdition/images/button/icons/new_bannergroup.gif';

	/*
	 * Path for new directory Icon
	 */
	const kIconNewDirectory = '/webEdition/images/button/icons/new_dir.gif';

	/*
	 * Path for payment val Icon
	 */
	const kIconPaymentVal = '/webEdition/images/button/icons/payment_val.gif';

	/*
	 * Path for select image Icon
	 */
	const kIconSelectImage = '/webEdition/images/button/icons/select_image.gif';

	/*
	 * Path for shop add new article Icon
	 */
	const kIconShopAddNew = '/webEdition/images/button/icons/shop_addnew.gif';

	/*
	 * Path for shop delete article Icon
	 */
	const kIconShopDelArt = '/webEdition/images/button/icons/shop_delArt.gif';

	/*
	 * Path for shop delete Icon
	 */
	const kIconShopDelOrd = '/webEdition/images/button/icons/shop_delOrd.gif';

	/*
	 * Path for shop extern article Icon
	 */
	const kIconShopExtArt = '/webEdition/images/button/icons/shop_extArt.gif';

	/*
	 * Path for shop preferences Icon
	 */
	const kIconShopPrefs = '/webEdition/images/button/icons/shop_pref.gif';

	/*
	 * Path for shop sum Icon
	 */
	const kIconShopSum = '/webEdition/images/button/icons/shop_sum.gif';

	/*
	 * Path for shop variants Icon
	 */
	const kIconShopVariants = '/webEdition/images/button/icons/shop_variants.gif';

	/*
	 * Path for spellcheck Icon
	 */
	const kIconSpellcheck = '/webEdition/images/button/icons/spellcheck.gif';

	/*
	 * Path for task copy Icon
	 */
	const kIconTaskCopy = '/webEdition/images/button/icons/task_copy.gif';

	/*
	 * Path for task create Icon
	 */
	const kIconTaskCreate = '/webEdition/images/button/icons/task_create.gif';

	/*
	 * Path for task cut Icon
	 */
	const kIconTaskCut = '/webEdition/images/button/icons/task_cut.gif';

	/*
	 * Path for task forward Icon
	 */
	const kIconTaskForward = '/webEdition/images/button/icons/task_forward.gif';

	/*
	 * Path for task messages Icon
	 */
	const kIconTaskMessages = '/webEdition/images/button/icons/task_messages.gif';

	/*
	 * Path for task paste Icon
	 */
	const kIconTaskPaste = '/webEdition/images/button/icons/task_paste.gif';

	/*
	 * Path for task reject Icon
	 */
	const kIconTaskReject = '/webEdition/images/button/icons/task_reject.gif';

	/*
	 * Path for task status Icon
	 */
	const kIconTaskStatus = '/webEdition/images/button/icons/task_status.gif';

	/*
	 * Path for task trash Icon
	 */
	const kIconTaskTrash = '/webEdition/images/button/icons/task_trash.gif';

	/*
	 * Path for task update Icon
	 */
	const kIconTaskUpdate = '/webEdition/images/button/icons/task_update.gif';

	/**
	 * Default class name for button
	 */
	const kButtonClassNormal = 'we_ui_controls_Button';

	/**
	 * class name for left part of button
	 */
	const kButtonClassLeft = 'we_ui_controls_Button_Left';

	/**
	 * class name for middle part of button
	 */
	const kButtonClassMiddle = 'we_ui_controls_Button_Middle';

	/**
	 * class name for right part of button
	 */
	const kButtonClassRight = 'we_ui_controls_Button_Right';

	/**
	 * Default class name for disabled button
	 */
	const kButtonClassDisabledNormal = 'we_ui_controls_Disabled_Button';

	/**
	 * class name for left part of disabled button
	 */
	const kButtonClassDisabledLeft = 'we_ui_controls_Disabled_Button_Left';

	/**
	 * class name for middle part of disabled button
	 */
	const kButtonClassDisabledMiddle = 'we_ui_controls_Disabled_Button_Middle';

	/**
	 * class name for right part of disabled button
	 */
	const kButtonClassDisabledRight = 'we_ui_controls_Disabled_Button_Right';

	/**
	 * class name for table position within the button
	 */
	const kButtonClassInnerTable = 'we_ui_controls_Button_InnerTable';

	/**
	 * class name for table position within the button if disabled
	 */
	const kButtonClassDisabledInnerTable = 'we_ui_controls_Disabled_Button_InnerTable';

	/**
	 * text attribute
	 *
	 * @var string
	 */
	protected $_text = '';
	
	/**
	 * width attribute
	 *
	 * @var string
	 */
	protected $_width = '150';
	
	/**
	 * type of button
	 *
	 * @var string
	 */
	protected $_type = 'onClick';

	/**
	 * name of internal icon image
	 *
	 * @var string
	 */
	protected $_icon = '';

	/**
	 * path of external button image
	 *
	 * @var string
	 */
	protected $_imagePath = '';

	/**
	 * position attribute
	 * possible values are: left,right
	 *
	 * @var string
	 */
	protected $_textPosition = 'right';

	/**
	 * href attribute
	 *
	 * @var string
	 */
	protected $_href = '';

	/**
	 * target attribute
	 *
	 * @var string
	 */
	protected $_target = '';

	/**
	 * height of button
	 * will be used for button type=submit for the hidden input type=image
	 *
	 * @var integer
	 */
	protected $_height = 22;

	/**
	 * onMouseOut attribute
	 *
	 * @var string
	 */
	protected $_onMouseOut = '';

	/**
	 * onMouseDown attribute
	 *
	 * @var string
	 */
	protected $_onMouseDown = '';

	/**
	 * onMouseUp attribute
	 *
	 * @var string
	 */
	protected $_onMouseUp = '';

	/**
	 * onClick attribute
	 *
	 * @var string
	 */
	protected $_onClick = '';
	
	/**
	 * Constructor
	 * 
	 * Sets object propeties if set in $properties array
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
	 * Retrieve text of button
	 * 
	 * @return string
	 */
	public function getText()
	{
		return $this->_text;
	}

	/**
	 * Set text of button
	 * 
	 * @param string $_text
	 */
	public function setText($_text)
	{
		$this->_text = $_text;
	}

	/**
	 * Retrieve href link of button
	 * 
	 * @return string
	 */
	public function getHref()
	{
		return $this->_href;
	}

	/**
	 * Set href of button
	 * 
	 * @param string $_href
	 */
	public function setHref($_href)
	{
		$this->_href = $_href;
	}

	/**
	 * Retrieve target of button = href
	 * 
	 * @return string
	 */
	public function getTarget()
	{
		return $this->_target;
	}

	/**
	 * Set target of button
	 * 
	 * @param string $_target
	 */
	public function setTarget($_target)
	{
		$this->_target = $_target;
	}

	/**
	 * Retrieve type of button
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}

	/**
	 * Set type of button
	 * 
	 * @param string $_type
	 */
	public function setType($_type)
	{
		$this->_type = $_type;
	}

	/**
	 * Retrieve onMouseOut attribute
	 * 
	 * @return string
	 */
	public function getOnMouseOut()
	{
		return $this->_onMouseOut;
	}

	/**
	 * Set onMouseOut attribute
	 * 
	 * @param string $_onMouseOut
	 */
	public function setOnMouseOut($_onMouseOut)
	{
		$this->_onMouseOut = $_onMouseOut;
	}

	/**
	 * Retrieve onMouseDown attribute
	 * 
	 * @return string
	 */
	public function getOnMouseDown()
	{
		return $this->_onMouseDown;
	}

	/**
	 * Set onMouseDown attribute
	 * 
	 * @param string $_onMouseDown
	 */
	public function setOnMouseDown($_onMouseDown)
	{
		$this->_onMouseDown = $_onMouseDown;
	}

	/**
	 * Retrieve onMouseUp attribute
	 * 
	 * @return string
	 */
	public function getOnMouseUp()
	{
		return $this->_onMouseUp;
	}

	/**
	 * Set onMouseUp attribute
	 * 
	 * @param string $_onMouseUp
	 */
	public function setOnMouseUp($_onMouseUp)
	{
		$this->_onMouseUp = $_onMouseUp;
	}

	/**
	 * Retrieve onClick attribute
	 * 
	 * @return string
	 */
	public function getOnClick()
	{
		return $this->_onClick;
	}

	/**
	 * Set onClick attribute
	 * 
	 * @param string $_onClick
	 */
	public function setOnClick($_onClick)
	{
		$this->_onClick = $_onClick;
	}

	/**
	 * Retrieve icon of internal button
	 * 
	 * @return string
	 */
	public function getIcon()
	{
		return $this->_icon;
	}

	/**
	 * Set icon of internal button
	 * 
	 * @param string $_icon
	 */
	public function setIcon($_icon)
	{
		$this->_icon = $_icon;
	}

	/**
	 * Retrieve imagePath of external button
	 * 
	 * @return string
	 */
	public function getImagePath()
	{
		return $this->_imagePath;
	}

	/**
	 * Set imagePath of external button
	 * 
	 * @param string $_imagePath
	 */
	public function setImagePath($_imagePath)
	{
		$this->_imagePath = $_imagePath;
	}

	/**
	 * Retrieve textPosition of text
	 * 
	 * @return string
	 */
	public function getTextPosition()
	{
		return $this->_textPosition;
	}

	/**
	 * Set textPosition of text
	 * 
	 * @param string $_textPosition
	 */
	public function setTextPosition($_textPosition)
	{
		$this->_textPosition = $_textPosition;
	}

	/**
	 * Retrieve start tag <a> if button is type = href or <div> if button is type = submit 
	 *
	 * @return string
	 */
	public function _getWrapperStart()
	{
		if ($this->getType() == "href") {
			
			if ($this->getDisabled()) {
				$onClick = "return false;";
			} else {
				$onClick = "return true;";
			}
			return '<div style="width:' . $this->getWidth() . 'px;
			height:' . $this->getHeight() . 'px;"><a onClick="' . $onClick . '" id="a_' . $this->getId() . '" border="0" style="text-decoration:none;"  ' . $this->_getNonBooleanAttribs('href,target,title') . '>';
		}
		if ($this->getType() == "submit") {
			return '<div style="position:relative;z-index:1;width:' . $this->getWidth() . 'px;
				height:' . $this->getHeight() . 'px;">
				<input id="input_' . $this->getId() . '" ' . $this->_getBooleanAttribs('disabled') . ' ' . $this->_getNonBooleanAttribs('onMouseDown,onMouseOut') . ' 
				style="position:absolute;z-index:2;width:' . $this->getWidth() . 'px;
				height:' . $this->getHeight() . 'px;" 
				type="image" src="/webedition/images/pixel.gif" title="' . $this->getTitle() . '">';
		}
		
		return "";
	}

	/**
	 * Returns end tag </a> if button is type = href or </div> if button is type = submit 
	 *
	 * @return string
	 */
	public function _getWrapperEnd()
	{
		if ($this->getType() == "href") {
			return '</a></div>';
		}
		if ($this->getType() == "submit") {
			return '</div>';
		}
		
		return "";
	}

	/**
	 * Returns button content, image or text or both 
	 *
	 * @return string
	 */
	public function _getButtonContent()
	{
		$buttonHTML = '';
		
		if ($this->getDisabled()) {
			$classLeft = self::kButtonClassDisabledLeft;
			$classMiddle = self::kButtonClassDisabledMiddle;
			$classRight = self::kButtonClassDisabledRight;
			$tblClass = self::kButtonClassDisabledInnerTable;
		} else {
			$classLeft = self::kButtonClassLeft;
			$classMiddle = self::kButtonClassMiddle;
			$classRight = self::kButtonClassRight;
			$tblClass = self::kButtonClassInnerTable;
		}
		if ($this->getImagePath() === "") {
			$buttonHTML .= '<div' . $this->_getComputedClassAttrib($classLeft) . ' style="height:'.$this->_height.'px"></div>' . '<div style="width:' . $this->getWidth() . 'px;height:' . $this->getHeight() . 'px;"' . $this->_getComputedClassAttrib($classMiddle) . ' unselectable="on">';
		}
		$buttonHTML .= '<table border="0" id="table_' . $this->getId() . '" cellpadding="0" cellspacing="0" class="' . $tblClass . '"><tr>';
		
		if ($this->getIcon() !== '' || $this->getImagePath() !== '') {
			$image = '';
			if ($this->getImagePath() !== '') {
				$image = $this->getImagePath();
			} elseif ($this->getIcon() !== '') {
				$image = $this->getIcon();
			}
			$imagePath = $_SERVER['DOCUMENT_ROOT'] . $image;
			if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image) && is_readable($imagePath)) {
				$button = '<img src="' . $image . '" border="0" style="-khtml-user-select: none;padding:0px 5px 0px 5px;" />';
				if ($this->getText() !== "") {
					$text = $this->getText();
					switch ($this->getTextPosition()) {
						case "left" :
							$buttonHTML .= '<td>' . $text . '</td><td>' . $button . '</td>';
							break;
						case "right" :
							$buttonHTML .= '<td>' . $button . '</td><td>' . $text . '</td>';
							break;
					}
				} else {
					$buttonHTML .= '<td>' . $button . '</td>';
				}
			
			}
		} else {
			$buttonHTML .= '<td>' . $this->getText() . '</td>';
		}
		$buttonHTML .= '</tr></table>';
		if ($this->getImagePath() === "") {
			$buttonHTML .= '</div><div' . $this->_getComputedClassAttrib($classRight) . ' style="height:'.$this->_height.'px"></div>';
		}
		
		return $buttonHTML;
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
			if ($internalName === "_onMouseDown") {
				$attribs .= ' ' . htmlspecialchars($attribName) . '="if(we_ui_controls_Button.down(&quot;' . $this->getId() . '&quot;)) {' . htmlspecialchars($this->$internalName) . '}"';
			}
			if ($internalName === "_onMouseUp") {
				$attribs .= ' ' . htmlspecialchars($attribName) . '="if(we_ui_controls_Button.up(&quot;' . $this->getId() . '&quot;)) {' . htmlspecialchars($this->$internalName) . '}"';
			}
			if ($internalName === "_onMouseOut") {
				$attribs .= ' ' . htmlspecialchars($attribName) . '="if(we_ui_controls_Button.out(&quot;' . $this->getId() . '&quot;)) {' . htmlspecialchars($this->$internalName) . '}"';
			}
			if (isset($this->$internalName) && $this->$internalName !== '') {
				if ($internalName === "_onClick") {
					$attribs .= ' ' . htmlspecialchars($attribName) . '="if(we_ui_controls_Button.up(&quot;' . $this->getId() . '&quot;)) {' . htmlspecialchars($this->$internalName) . '}"';
				} else {
					$attribs .= ' ' . htmlspecialchars($attribName) . '="' . htmlspecialchars($this->$internalName) . '"';
				}
			}
		}
		return $attribs;
	}

	/**
	 * Renders and returns HTML of button
	 *
	 * @return string
	 */
	public function _renderHTML()
	{
		
		if ($this->getDisabled()) {
			$classNormal = self::kButtonClassDisabledNormal;
		} else {
			$classNormal = self::kButtonClassNormal;
		}
		
		if ($this->getHidden()) {
			$this->_style .= 'display:none;';
		}
		
		return $this->_getWrapperStart() . '<div' . $this->_getNonBooleanAttribs('id,title,onClick,onMouseUp,onMouseDown,onMouseOut') . $this->_getComputedStyleAttrib() . $this->_getComputedClassAttrib($classNormal) . '>' . $this->_getButtonContent() . '</div>' . $this->_getWrapperEnd();
	}
}