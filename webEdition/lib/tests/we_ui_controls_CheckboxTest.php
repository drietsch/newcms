<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Checkbox test case.
 */
class we_ui_controls_CheckboxTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Checkbox
	 */
	private $we_ui_controls_Checkbox;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Checkbox = new we_ui_controls_Checkbox();
		$this->we_ui_controls_Checkbox->setId('id1');
		$this->we_ui_controls_Checkbox->setValue('1');
		$this->we_ui_controls_Checkbox->setChecked(true);
		$this->we_ui_controls_Checkbox->setName('check1');
		$this->we_ui_controls_Checkbox->setLabel('Label');
		$this->we_ui_controls_Checkbox->setTitle('This is the title!');
		$this->we_ui_controls_Checkbox->setDisabled(false);
		$this->we_ui_controls_Checkbox->setHidden(false);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		
		$this->we_ui_controls_Checkbox = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_Checkbox->getChecked()
	 */
	public function testGetChecked()
	{
		$this->assertEquals($this->we_ui_controls_Checkbox->getChecked(), true);
	
	}

	/**
	 * Tests we_ui_controls_Checkbox->getLabel()
	 */
	public function testGetLabel()
	{
		$this->assertEquals($this->we_ui_controls_Checkbox->getLabel(), "Label");
	}
}

