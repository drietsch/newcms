<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_ButtonTable test case.
 */
class we_ui_layout_ButtonTableTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_ButtonTable
	 */
	private $we_ui_layout_ButtonTable;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_layout_ButtonTable = new we_ui_layout_ButtonTable();
		$this->we_ui_layout_ButtonTable->setId('id1');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_layout_ButtonTable = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{

	}

	/**
	 * Tests we_ui_layout_ButtonTable->getHorizontalPadding()
	 */
	public function testGetHorizontalPadding()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTable->getHorizontalPadding(), 10);
	
	}

	/**
	 * Tests we_ui_layout_ButtonTable->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_ButtonTable->getHTML(), '<table border="0" cellpadding="0" cellspacing="0" id="id1"></table>');
	
	}
}

