<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_TextField test case.
 */
class we_ui_controls_TextFieldTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_TextField
	 */
	private $we_ui_controls_TextField;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		
		$this->we_ui_controls_TextField = new we_ui_controls_TextField();
		$this->we_ui_controls_TextField->setClass('testClass');
		$this->we_ui_controls_TextField->setDisabled(true);
		$this->we_ui_controls_TextField->setHeight(20);
		$this->we_ui_controls_TextField->setId('testID');
		$this->we_ui_controls_TextField->setMaxlength(30);
		$this->we_ui_controls_TextField->setName('testName');
		$this->we_ui_controls_TextField->setOnBlur('testOnBlur');
		$this->we_ui_controls_TextField->setOnChange('testOnChange');
		$this->we_ui_controls_TextField->setOnFocus('testOnFocus');
		$this->we_ui_controls_TextField->setReadonly(true);
		$this->we_ui_controls_TextField->setSize(45);
		$this->we_ui_controls_TextField->setStyle('testStyle;');
		$this->we_ui_controls_TextField->setType('testType');
		$this->we_ui_controls_TextField->setValue('testValue');
		$this->we_ui_controls_TextField->setWidth(100);
	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		
		$this->we_ui_controls_TextField = null;
		
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	
	}

	/**
	 * Tests we_ui_controls_TextField->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getHTML(), '<input id="testID" name="testName" value="testValue" maxlength="30" size="45" type="testType" onChange="testOnChange" disabled="disabled" readonly="readonly" style="width:96px;height:15px;testStyle;" class="we_ui_controls_TextInput testClass" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);testOnFocus" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);testOnBlur"/>');
	}

	/**
	 * Tests we_ui_controls_TextField->getClass()
	 */
	public function testGetClass()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getClass(), 'testClass');
	}

	/**
	 * Tests we_ui_controls_TextField->getDisabled()
	 */
	public function testGetDisabled()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getDisabled(), true);
	}

	/**
	 * Tests we_ui_controls_TextField->getHeight()
	 */
	public function testGetHeight()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getHeight(), 20);
	}

	/**
	 * Tests we_ui_controls_TextField->getId()
	 */
	public function testGetId()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getId(), 'testID');
	}

	/**
	 * Tests we_ui_controls_TextField->getMaxlength()
	 */
	public function testGetMaxlength()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getMaxlength(), 30);
	}

	/**
	 * Tests we_ui_controls_TextField->getName()
	 */
	public function testGetName()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getName(), 'testName');
	}

	/**
	 * Tests we_ui_controls_TextField->getOnBlur()
	 */
	public function testGetOnBlur()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getOnBlur(), 'testOnBlur');
	}

	/**
	 * Tests we_ui_controls_TextField->getOnChange()
	 */
	public function testGetOnChange()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getOnChange(), 'testOnChange');
	}

	/**
	 * Tests we_ui_controls_TextField->getOnFocus()
	 */
	public function testGetOnFocus()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getOnFocus(), 'testOnFocus');
	}

	/**
	 * Tests we_ui_controls_TextField->getReadonly()
	 */
	public function testReadonly()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getReadonly(), true);
	}

	/**
	 * Tests we_ui_controls_TextField->getSize()
	 */
	public function testGetSize()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getSize(), 45);
	}

	/**
	 * Tests we_ui_controls_TextField->getStyle()
	 */
	public function testGetStyle()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getStyle(), 'testStyle;');
	}

	/**
	 * Tests we_ui_controls_TextField->getType()
	 */
	public function testGetType()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getType(), 'testType');
	}

	/**
	 * Tests we_ui_controls_TextField->getValue()
	 */
	public function testGetValue()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getValue(), 'testValue');
	}

	/**
	 * Tests we_ui_controls_TextField->getWidth()
	 */
	public function testGetWidth()
	{
		$this->assertEquals($this->we_ui_controls_TextField->getWidth(), 100);
	}

}

