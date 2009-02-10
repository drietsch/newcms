<?php
include_once('webEdition/lib/we/core/autoload.php');

require_once 'webEdition/lib/we/ui/dialog/OkCancelDialog.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_dialog_OkCancelDialog test case.
 */
class we_ui_dialog_OkCancelDialogTest extends PHPUnit_Framework_TestCase 
{
	
	/**
	 * @var we_ui_dialog_OkCancelDialog
	 */
	private $we_ui_dialog_OkCancelDialog;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() 
	{
		parent::setUp ();
		$this->we_ui_dialog_OkCancelDialog = new we_ui_dialog_OkCancelDialog(/* parameters */);
		$this->we_ui_dialog_OkCancelDialog->setId('id1');
		$this->we_ui_dialog_OkCancelDialog->setCancelAction('cancel');
		$this->we_ui_dialog_OkCancelDialog->setOkAction('ok');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->we_ui_dialog_OkCancelDialog = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() 
	{
	}
		
	/**
	 * Tests we_ui_dialog_OkCancelDialog->getCancelAction()
	 */
	public function testGetCancelAction() {
		$this->assertEquals($this->we_ui_dialog_OkCancelDialog->getCancelAction(),'cancel');
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog::getInstance()
	 */
	public function testGetInstance() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest::testGetInstance()
		$this->markTestIncomplete ( "getInstance test not implemented" );
		
		we_ui_dialog_OkCancelDialog::getInstance(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->getMessage()
	 */
	public function testGetMessage() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testGetMessage()
		$this->markTestIncomplete ( "getMessage test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->getMessage(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->getOkAction()
	 */
	public function testGetOkAction() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testGetOkAction()
		$this->markTestIncomplete ( "getOkAction test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->getOkAction(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->setCancelAction()
	 */
	public function testSetCancelAction() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testSetCancelAction()
		$this->markTestIncomplete ( "setCancelAction test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->setCancelAction(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->setEncodeMessage()
	 */
	public function testSetEncodeMessage() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testSetEncodeMessage()
		$this->markTestIncomplete ( "setEncodeMessage test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->setEncodeMessage(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->setMessage()
	 */
	public function testSetMessage() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testSetMessage()
		$this->markTestIncomplete ( "setMessage test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->setMessage(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->setOkAction()
	 */
	public function testSetOkAction() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testSetOkAction()
		$this->markTestIncomplete ( "setOkAction test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->setOkAction(/* parameters */);
	
	}
	
	/**
	 * Tests we_ui_dialog_OkCancelDialog->setTopClose()
	 */
	public function testSetTopClose() {
		// TODO Auto-generated we_ui_dialog_OkCancelDialogTest->testSetTopClose()
		$this->markTestIncomplete ( "setTopClose test not implemented" );
		
		$this->we_ui_dialog_OkCancelDialog->setTopClose(/* parameters */);
	
	}

}

