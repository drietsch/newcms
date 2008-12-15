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
 * @subpackage we_ui_dialog
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_layout_Dialog
 */
Zend_Loader::loadClass('we_ui_layout_Dialog');

/**
 * Class to build a Dialog with a Yes, No and Cancel Button.
 * The position of the buttons depends on the used OS
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_dialog
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_dialog_YesNoCancelDialog extends we_ui_layout_Dialog
{

	/**
	 * yesAction attribute
	 *
	 * @var string
	 */
	protected $_yesAction = '';

	/**
	 * noAction attribute
	 *
	 * @var string
	 */
	protected $_noAction = '';

	/**
	 * cancelAction attribute
	 *
	 * @var string
	 */
	protected $_cancelAction = '';

	/**
	 * message attribute
	 *
	 * @var string
	 */
	protected $_message = '';

	/**
	 * encodeMessage attribute
	 *
	 * @var boolean
	 */
	protected $_encodeMessage = true;

	/**
	 * Renders and returns HTML of YesNoCancelDialog
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		
		$translate = we_core_Local::addTranslation('apps.xml');
		
		$table = new we_ui_layout_Table(array('cellPadding' => 10));
		$table->addHTML('<img src="/webEdition/images/alert.gif" alt="" />');
		$table->nextColumn();
		$table->addHTML('<div>' . nl2br($this->_encodeMessage ? htmlspecialchars($this->_message) : $this->_message) . '</div>');
		$this->addElement($table);
		
		// TODO localize buttons
		$buttonYes = new we_ui_controls_Button(array('text' => $translate->_('Yes'), 'onClick' => $this->_yesAction . ';top.close()', 'type' => 'onClick', 'width' => 100));
		
		$buttonNo = new we_ui_controls_Button(array('text' => $translate->_('No'), 'onClick' => $this->_noAction . ';top.close()', 'type' => 'onClick', 'width' => 100));
		
		$buttonCancel = new we_ui_controls_Button(array('text' => $translate->_('Cancel'), 'onClick' => 'top.close()', 'type' => 'onClick', 'width' => 100));
		
		$buttonTable = new we_ui_layout_ButtonTableYesNo();
		$buttonTable->setYesOkButton($buttonYes);
		$buttonTable->setNoButton($buttonNo);
		$buttonTable->setCancelButton($buttonCancel);
		$buttonTable->setStyle('margin-top:10px;margin-right:10px;margin-left:auto;');
		
		$buttonsHTML = '<div style="left:0;height:40px;background-image: url(/webEdition/images/edit/editfooterback.gif);position:absolute;bottom:0;width:100%">' . $buttonTable->getHTML() . '</div>';
		$this->addCSSFiles($buttonTable->getCSSFiles());
		$this->addJSFiles($buttonTable->getJSFiles());
		$this->addHTML($buttonsHTML);
		
		return parent::_renderHTML();
	}

	/**
	 * retrieve cancelAction
	 * 
	 * @return string
	 */
	public function getCancelAction()
	{
		return $this->_cancelAction;
	}

	/**
	 * retrieve message
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->_message;
	}

	/**
	 * retrieve noAction
	 * 
	 * @return string
	 */
	public function getNoAction()
	{
		return $this->_noAction;
	}

	/**
	 * retrieve yesAction
	 * 
	 * @return string
	 */
	public function getYesAction()
	{
		return $this->_yesAction;
	}

	/**
	 * set cancelAction
	 * 
	 * @param string $cancelAction
	 */
	public function setCancelAction($cancelAction)
	{
		$this->_cancelAction = $cancelAction;
	}

	/**
	 * set message
	 * 
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->_message = $message;
	}

	/**
	 * set noAction
	 * 
	 * @param string $noAction
	 */
	public function setNoAction($noAction)
	{
		$this->_noAction = $noAction;
	}

	/**
	 * set yesAction
	 * 
	 * @param string $yesAction
	 */
	public function setYesAction($yesAction)
	{
		$this->_yesAction = $yesAction;
	}

	/**
	 * retrieve encodeMessage
	 * 
	 * @return string
	 */
	public function getEncodeMessage()
	{
		return $this->_encodeMessage;
	}

	/**
	 * set encodeMessage
	 * 
	 * @param string $encodeMessage
	 */
	public function setEncodeMessage($encodeMessage)
	{
		$this->_encodeMessage = $encodeMessage;
	}

}

?>