<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_Div test case.
 */
class we_ui_layout_DivTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_Div
	 */
	private $we_ui_layout_Div;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_layout_Div = new we_ui_layout_Div();
		$this->we_ui_layout_Div->setId('id1');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_layout_Div = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_layout_Div->getHTML()
	 */
	public function testgetHTML()
	{
		$this->assertEquals($this->we_ui_layout_Div->getHTML(), '<div id="id1"></div>');
	}
}

