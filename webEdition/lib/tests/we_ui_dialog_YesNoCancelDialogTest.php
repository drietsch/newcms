<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_dialog_YesNoCancelDialog test case.
 */
class we_ui_dialog_YesNoCancelDialogTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_dialog_YesNoCancelDialog
	 */
	private $we_ui_dialog_YesNoCancelDialog;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_dialog_YesNoCancelDialog = new we_ui_dialog_YesNoCancelDialog();
		$this->we_ui_dialog_YesNoCancelDialog->setId('id1');
		$this->we_ui_dialog_YesNoCancelDialog->setCancelAction('cancel');
		$this->we_ui_dialog_YesNoCancelDialog->setNoAction('no');
		$this->we_ui_dialog_YesNoCancelDialog->setYesAction('yes');

	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_dialog_YesNoCancelDialog = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_dialog_YesNoCancelDialog->getCancelAction()
	 */
	public function testGetCancelAction()
	{
		$this->assertEquals($this->we_ui_dialog_YesNoCancelDialog->getCancelAction(), 'cancel');
	
	}

	/**
	 * Tests we_ui_dialog_YesNoCancelDialog->getEncodeMessage()
	 */
	public function testGetEncodeMessage()
	{
		$this->assertEquals($this->we_ui_dialog_YesNoCancelDialog->getEncodeMessage(), true);
	
	}

	/**
	 * Tests we_ui_dialog_YesNoCancelDialog->getNoAction()
	 */
	public function testGetNoAction()
	{
		$this->assertEquals($this->we_ui_dialog_YesNoCancelDialog->getNoAction(), 'no');
	
	}

	/**
	 * Tests we_ui_dialog_YesNoCancelDialog->getYesAction()
	 */
	public function testGetYesAction()
	{
		$this->assertEquals($this->we_ui_dialog_YesNoCancelDialog->getYesAction(), 'yes');
	
	}

}

