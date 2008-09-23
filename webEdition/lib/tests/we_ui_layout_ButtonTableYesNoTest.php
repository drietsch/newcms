<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_ButtonTableYesNo test case.
 */
class we_ui_layout_ButtonTableYesNoTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_ButtonTableYesNo
	 */
	private $we_ui_layout_ButtonTableYesNo;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_layout_ButtonTableYesNo = new we_ui_layout_ButtonTableYesNo();
		$this->we_ui_layout_ButtonTableYesNo->setId('id1');
		$this->we_ui_layout_ButtonTableYesNo->setCancelButton('cancel');
		$this->we_ui_layout_ButtonTableYesNo->setNoButton('no');
		$this->we_ui_layout_ButtonTableYesNo->setYesOkButton('yes');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_layout_ButtonTableYesNo = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_layout_ButtonTableYesNo->getCancelButton()
	 */
	public function testGetCancelButton()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTableYesNo->getCancelButton(), 'cancel');
	
	}

	/**
	 * Tests we_ui_layout_ButtonTableYesNo->getNoButton()
	 */
	public function testGetNoButton()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTableYesNo->getNoButton(), 'no');
	
	}

	/**
	 * Tests we_ui_layout_ButtonTableYesNo->getYesOkButton()
	 */
	public function testGetYesOkButton()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTableYesNo->getYesOkButton(), 'yes');
	
	}

	/**
	 * Tests we_ui_layout_ButtonTableYesNo->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTableYesNo->getHTML(), '<table border="0" cellpadding="0" cellspacing="0" id="id1"></table>');
	
	}
}