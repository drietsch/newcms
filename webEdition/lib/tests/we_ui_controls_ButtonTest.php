<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Button test case.
 */
class we_ui_controls_ButtonTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Button
	 */
	private $we_ui_controls_Button;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Button = new we_ui_controls_Button();
		$this->we_ui_controls_Button->setClass('testClass');
		$this->we_ui_controls_Button->setId('test_id');
		$this->we_ui_controls_Button->setText('onClick / onMouseUp');
		$this->we_ui_controls_Button->setType('onClick');
		$this->we_ui_controls_Button->setTitle('This is the title of the button!');
		$this->we_ui_controls_Button->setDisabled(false);
		$this->we_ui_controls_Button->setHidden(false);
		$this->we_ui_controls_Button->setWidth(200);
		$this->we_ui_controls_Button->setHeight(22);
		$this->we_ui_controls_Button->setOnClick('alert("Hallo Welt!");');
		$this->we_ui_controls_Button->setHref('http://www.webedition.de');

	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Button = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_Button->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_Button->getHTML(),'<div id="test_id" title="This is the title of the button!" onClick="if(we_ui_controls_Button.up(&quot;test_id&quot;)) {alert(&quot;Hallo Welt!&quot;);}" onMouseUp="if(we_ui_controls_Button.up(&quot;test_id&quot;)) {}" onMouseDown="if(we_ui_controls_Button.down(&quot;test_id&quot;)) {}" onMouseOut="if(we_ui_controls_Button.out(&quot;test_id&quot;)) {}" style="width:200px;height:22px;" class="we_ui_controls_Button testClass"><div class="we_ui_controls_Button_Left testClass" style="height:22px"></div><div style="width:200px;height:22px;" class="we_ui_controls_Button_Middle testClass" unselectable="on"><table border="0" id="table_test_id" cellpadding="0" cellspacing="0" class="we_ui_controls_Button_InnerTable"><tr><td>onClick / onMouseUp</td></tr></table></div><div class="we_ui_controls_Button_Right testClass" style="height:22px"></div></div>');
	}

	/**
	 * Tests we_ui_controls_Button->getId()
	 */
	public function testGetId()
	{
		$this->assertEquals($this->we_ui_controls_Button->getId(), 'test_id');
	}

	/**
	 * Tests we_ui_controls_Button->getDisabled()
	 */
	public function testGetDisabled()
	{
		$this->assertEquals($this->we_ui_controls_Button->getDisabled(), false);
	}

	/**
	 * Tests we_ui_controls_Button->getDisabled()
	 */
	public function testGetHidden()
	{
		$this->assertEquals($this->we_ui_controls_Button->getHidden(), false);
	}

	/**
	 * Tests we_ui_controls_Button->getHref()
	 */
	public function testGetHref()
	{
		$this->assertEquals($this->we_ui_controls_Button->getHref(), 'http://www.webedition.de');
	}

	/**
	 * Tests we_ui_controls_Button->getOnClick()
	 */
	public function testGetOnClick()
	{
		$this->assertEquals($this->we_ui_controls_Button->getOnClick(), 'alert("Hallo Welt!");');
	}

	/**
	 * Tests we_ui_controls_Button->getText()
	 */
	public function testGetText()
	{
		$this->assertEquals($this->we_ui_controls_Button->getText(), 'onClick / onMouseUp');
	}

	/**
	 * Tests we_ui_controls_Button->getType()
	 */
	public function testGetType()
	{
		$this->assertEquals($this->we_ui_controls_Button->getType(), 'onClick');
	}
}

