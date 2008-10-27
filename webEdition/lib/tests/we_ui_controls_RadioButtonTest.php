<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_RadioButton test case.
 */
class we_ui_controls_RadioButtonTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_RadioButton
	 */
	private $we_ui_controls_RadioButton;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_RadioButton = new we_ui_controls_RadioButton(/* parameters */);
		$this->we_ui_controls_RadioButton->setId('id1');
		$this->we_ui_controls_RadioButton->setValue('1');
		$this->we_ui_controls_RadioButton->setChecked(true);
		$this->we_ui_controls_RadioButton->setName('radio1');
		$this->we_ui_controls_RadioButton->setLabel('Label');
		$this->we_ui_controls_RadioButton->setTitle('This is the title!');
		$this->we_ui_controls_RadioButton->setDisabled(false);
		$this->we_ui_controls_RadioButton->setHidden(false);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_RadioButton = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}
	
	/**
	 * Tests we_ui_controls_RadioButton->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_RadioButton->getHTML(),'<table id="table_id1" ><tr><td><input id="id1" name="radio1" value="1" type="radio" title="This is the title!" checked="checked"/></td><td style="padding-top:4px;"><label class="we_ui_controls_Label" id="label_id1" for="id1" title="This is the title!">Label</label></td></tr></table>');
	}

	/**
	 * Tests we_ui_controls_RadioButton->getChecked()
	 */
	public function testGetChecked()
	{
		$this->assertEquals($this->we_ui_controls_RadioButton->getChecked(), true);
	}
	
	/**
	 * Tests we_ui_controls_RadioButton->getLabel()
	 */
	public function testGetLabel() {
		$this->assertEquals($this->we_ui_controls_RadioButton->getLabel(), "Label");
	}
}

