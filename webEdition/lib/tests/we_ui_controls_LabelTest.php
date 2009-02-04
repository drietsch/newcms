<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Label test case.
 */
class we_ui_controls_LabelTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Label
	 */
	private $we_ui_controls_Label;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Label = new we_ui_controls_Label();
		$this->we_ui_controls_Label->setClass('testClass');
		$this->we_ui_controls_Label->setId('label_id');
		$this->we_ui_controls_Label->setFor('for_id');
		$this->we_ui_controls_Label->setText('Label 1');
		$this->we_ui_controls_Label->setStyle('testStyle;');
		$this->we_ui_controls_Label->setDisabled(true);
		$this->we_ui_controls_Label->setHidden(false);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Label = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_Label->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_Label->getHTML(), '<label style="testStyle;" class="we_ui_controls_Label_disabled testClass" id="label_id" for="for_id">Label 1</label>');
	}

	/**
	 * Tests we_ui_controls_Label->getId()
	 */
	public function testGetId()
	{
		$this->assertEquals($this->we_ui_controls_Label->getId(), 'label_id');
	}

	/**
	 * Tests we_ui_controls_Label->getDisabled()
	 */
	public function testGetDisabled()
	{
		$this->assertEquals($this->we_ui_controls_Label->getDisabled(), true);
	}
	
	/**
	 * Tests we_ui_controls_Label->getDisabled()
	 */
	public function testGetHidden()
	{
		$this->assertEquals($this->we_ui_controls_Label->getHidden(), false);
	}

	/**
	 * Tests we_ui_controls_Label->getFor()
	 */
	public function testGetFor()
	{
		$this->assertEquals($this->we_ui_controls_Label->getFor(), 'for_id');
	}

	/**
	 * Tests we_ui_controls_Label->getText()
	 */
	public function testGetText()
	{
		$this->assertEquals($this->we_ui_controls_Label->getText(), 'Label 1');
	}
}

