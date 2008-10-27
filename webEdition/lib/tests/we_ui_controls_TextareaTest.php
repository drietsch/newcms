<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Textarea test case.
 */
class we_ui_controls_TextareaTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Textarea
	 */
	private $we_ui_controls_Textarea;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Textarea = new we_ui_controls_Textarea();
		$this->we_ui_controls_Textarea->setId('id1');
		$this->we_ui_controls_Textarea->setRows(30);
		$this->we_ui_controls_Textarea->setCols(10);
		$this->we_ui_controls_Textarea->setName('check1');
		$this->we_ui_controls_Textarea->setTitle('This is the title!');
		$this->we_ui_controls_Textarea->setText('text');
		$this->we_ui_controls_Textarea->setOnBlur('alert("onBlur");');
		$this->we_ui_controls_Textarea->setOnFocus('alert("onFocus");');
		$this->we_ui_controls_Textarea->setOnChange('alert("onChange");');
		$this->we_ui_controls_Textarea->setDisabled(false);
		$this->we_ui_controls_Textarea->setHidden(false);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Textarea = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}
	
	/**
	 * Tests we_ui_controls_Textarea->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getHTML(),'<textarea id="id1" name="check1" rows="30" cols="10" onChange="alert(&quot;onChange&quot;);" class="we_ui_controls_Textarea" onFocus="this.className=&quot;we_ui_controls_Textarea_Selected&quot;;alert(&quot;onFocus&quot;);" onBlur="this.className=&quot;we_ui_controls_Textarea&quot;;alert(&quot;onBlur&quot;);">text</textarea>');
	}

	/**
	 * Tests we_ui_controls_Textarea->getCols()
	 */
	public function testGetCols()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getCols(), 10);
	}

	/**
	 * Tests we_ui_controls_Textarea->getOnBlur()
	 */
	public function testGetOnBlur()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getOnBlur(), 'alert("onBlur");');
	}

	/**
	 * Tests we_ui_controls_Textarea->getOnChange()
	 */
	public function testGetOnChange()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getOnChange(), 'alert("onChange");');
	}

	/**
	 * Tests we_ui_controls_Textarea->getOnFocus()
	 */
	public function testGetOnFocus()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getOnFocus(), 'alert("onFocus");');
	}

	/**
	 * Tests we_ui_controls_Textarea->getRows()
	 */
	public function testGetRows()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getRows(), 30);
	}

	/**
	 * Tests we_ui_controls_Textarea->getText()
	 */
	public function testGetText()
	{
		$this->assertEquals($this->we_ui_controls_Textarea->getText(), 'text');
	}


}

