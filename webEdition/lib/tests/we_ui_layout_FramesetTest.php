<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_Frameset test case.
 */
class we_ui_layout_FramesetTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_Frameset
	 */
	private $we_ui_layout_Frameset;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_layout_Frameset = new we_ui_layout_Frameset();
		$this->we_ui_layout_Frameset->setId('id1');
		$this->we_ui_layout_Frameset->setBorder(1);
		$this->we_ui_layout_Frameset->setCols(20);
		$this->we_ui_layout_Frameset->setFrameborder(5);
		$this->we_ui_layout_Frameset->setFramespacing(2);
		$this->we_ui_layout_Frameset->setOnLoad('c=2');
		$this->we_ui_layout_Frameset->setRows(55);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_layout_Frameset = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}


	/**
	 * Tests we_ui_layout_Frameset->getBorder()
	 */
	public function testGetBorder()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getBorder(), 1);
	
	}

	/**
	 * Tests we_ui_layout_Frameset->getCols()
	 */
	public function testGetCols()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getCols(), 20);
	
	}

	/**
	 * Tests we_ui_layout_Frameset->getFrameborder()
	 */
	public function testGetFrameborder()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getFrameborder(), 5);
	
	}

	/**
	 * Tests we_ui_layout_Frameset->getFramespacing()
	 */
	public function testGetFramespacing()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getFramespacing(), 2);
	
	}

	/**
	 * Tests we_ui_layout_Frameset->getOnLoad()
	 */
	public function testGetOnLoad()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getOnLoad(), 'c=2');
	
	}

	/**
	 * Tests we_ui_layout_Frameset->getRows()
	 */
	public function testGetRows()
	{
		$this->assertEquals($this->we_ui_layout_Frameset->getRows(), 55);
	
	}

}

