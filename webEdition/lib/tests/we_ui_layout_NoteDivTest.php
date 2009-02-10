<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_NoteDiv test case.
 */
class we_ui_layout_NoteDivTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var we_ui_layout_NoteDiv
	 */
	private $we_ui_layout_NoteDiv;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() 
	{
		parent::setUp ();
		$this->we_ui_layout_NoteDiv = new we_ui_layout_NoteDiv();
		$this->we_ui_layout_NoteDiv->setId('id1');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() 
	{
		$this->we_ui_layout_NoteDiv = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() 
	{
	}
	
	/**
	 * Tests we_ui_layout_NoteDiv->setType()
	 */
	public function testsetType()
	{
		$this->assertTrue($this->we_ui_layout_NoteDiv->setType('info'));
	}
	
	/**
	 * Tests we_ui_layout_NoteDiv->addText();
	 */
	public function testaddText()
	{
		$this->assertTrue($this->we_ui_layout_NoteDiv->addText('some text'));
	}
}

