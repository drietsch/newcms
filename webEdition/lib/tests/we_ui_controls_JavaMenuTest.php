<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_JavaMenu test case.
 */
class we_ui_controls_JavaMenuTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_JavaMenu
	 */
	private $we_ui_controls_JavaMenu;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_JavaMenu = new we_ui_controls_JavaMenu();
		$this->we_ui_controls_JavaMenu->setId('id1');
		$this->we_ui_controls_JavaMenu->setEntries(array('1','2'));
		$this->we_ui_controls_JavaMenu->setWidth(300);
		$this->we_ui_controls_JavaMenu->setHeight(50);
		$this->we_ui_controls_JavaMenu->setCmdURL('url');
		$this->we_ui_controls_JavaMenu->setCmdTarget('cmdTarget');
	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_JavaMenu = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_JavaMenu->getCmdTarget()
	 */
	public function testGetCmdTarget()
	{
		$this->assertEquals($this->we_ui_controls_JavaMenu->getCmdTarget(), 'cmdTarget');
	
	}

	/**
	 * Tests we_ui_controls_JavaMenu->getCmdURL()
	 */
	public function testGetCmdURL()
	{
		$this->assertEquals($this->we_ui_controls_JavaMenu->getCmdURL(), 'url');
	
	}

	/**
	 * Tests we_ui_controls_JavaMenu->getEntries()
	 */
	public function testGetEntries()
	{
		$this->assertEquals($this->we_ui_controls_JavaMenu->getEntries(), array('1','2'));
	
	}
}