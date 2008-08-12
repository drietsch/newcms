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
 * @subpackage we_ui_dialog
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: YesNoCancelDialog.php,v 1.3 2008/07/01 14:49:05 holger.meyer Exp $
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
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_dialog_YesNoCancelDialog extends we_ui_layout_Dialog
{
	
	protected $_yesAction='';
	protected $_noAction='';
	protected $_cancelAction='';
	protected $_message='';
	protected $_encodeMessage=true;
	
	protected function _renderHTML() {
		
		$translate = we_core_Local::addTranslation('apps.xml');
		
		$table = new we_ui_layout_Table(array('cellPadding'=>10));
		$table->addHTML('<img src="/webEdition/images/alert.gif" alt="" />');
		$table->nextColumn();
		$table->addHTML('<div>' . nl2br($this->_encodeMessage ? htmlspecialchars($this->_message) : $this->_message) . '</div>');
		$this->addElement($table);
		
		// TODO localize buttons
		$buttonYes = new we_ui_controls_Button(
			array(
				'text'=>$translate->_('Yes'), 
				'onClick'=>$this->_yesAction . ';top.close()', 
				'type'=>'onClick', 
				'width'=>100
			)
		);
		
		$buttonNo = new we_ui_controls_Button(
			array(
				'text'=>$translate->_('No'), 
				'onClick'=>$this->_noAction . ';top.close()', 
				'type'=>'onClick', 
				'width'=>100
			)
		);
		
		$buttonCancel = new we_ui_controls_Button(
			array(
				'text'=>$translate->_('Cancel'), 
				'onClick'=>'top.close()', 
				'type'=>'onClick', 
				'width'=>100
			)
		);
		
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
	 * @return unknown
	 */
	public function getCancelAction()
	{
		return $this->_cancelAction;
	}

	/**
	 * @return unknown
	 */
	public function getMessage()
	{
		return $this->_message;
	}

	/**
	 * @return unknown
	 */
	public function getNoAction()
	{
		return $this->_noAction;
	}

	/**
	 * @return unknown
	 */
	public function getYesAction()
	{
		return $this->_yesAction;
	}

	/**
	 * @param unknown_type $cancelAction
	 */
	public function setCancelAction($cancelAction)
	{
		$this->_cancelAction = $cancelAction;
	}

	/**
	 * @param unknown_type $message
	 */
	public function setMessage($message)
	{
		$this->_message = $message;
	}

	/**
	 * @param unknown_type $noAction
	 */
	public function setNoAction($noAction)
	{
		$this->_noAction = $noAction;
	}

	/**
	 * @param unknown_type $yesAction
	 */
	public function setYesAction($yesAction)
	{
		$this->_yesAction = $yesAction;
	}

	/**
	 * @return unknown
	 */
	public function getEncodeMessage()
	{
		return $this->_encodeMessage;
	}

	/**
	 * @param unknown_type $encodeMessage
	 */
	public function setEncodeMessage($encodeMessage)
	{
		$this->_encodeMessage = $encodeMessage;
	}


}

?>
