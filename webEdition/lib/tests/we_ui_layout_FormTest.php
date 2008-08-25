<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_Form test case.
 */
class we_ui_layout_FormTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_Form
	 */
	private $we_ui_layout_Form;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$inp = new we_ui_controls_TextField(array('id'=>'textFieldId','name'=>'test', 'value'=>'default', 'width'=>100));
		
		$this->we_ui_layout_Form = new we_ui_layout_Form(array('action'=>'testAction','method'=>'post', 'id'=>'testID', 'onSubmit'=>'var a=1;'));
		$this->we_ui_layout_Form->addElement($inp);
	
	}


	/**
	 * Tests we_ui_layout_Form->getAction()
	 */
	public function testGetAction()
	{
		$this->assertEquals($this->we_ui_layout_Form->getAction(), 'testAction');	
	}

	/**
	 * Tests we_ui_layout_Form->getMethod()
	 */
	public function testGetMethod()
	{
		$this->assertEquals($this->we_ui_layout_Form->getMethod(), 'post');	
	}

	/**
	 * Tests we_ui_layout_Form->getOnSubmit()
	 */
	public function testGetOnSubmit()
	{
		$this->assertEquals($this->we_ui_layout_Form->getOnSubmit(), 'var a=1;');	
	}

	/**
	 * Tests we_ui_layout_Form::hidden()
	 */
	public function testHidden()
	{
		$this->assertEquals(we_ui_layout_Form::hidden('test<Name', 'testValue'), '<input type="hidden" name="test&lt;Name" value="testValue"  />');	
	}

	/**
	 * Tests we_ui_layout_Form->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_Form->getHTML(), '<form id="testID" method="post" onSubmit="var a=1;" action="testAction"><input id="textFieldId" name="test" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/></form>');
	}
}

