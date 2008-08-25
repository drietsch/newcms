<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Select test case.
 */
class we_ui_controls_SelectTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Select
	 */
	private $we_ui_controls_Select;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Select = new we_ui_controls_Select();
		$this->we_ui_controls_Select->setId('id1');
		$this->we_ui_controls_Select->setSelectedValue('1');
		$this->we_ui_controls_Select->setMultiple(true);
		$this->we_ui_controls_Select->setSize(5);
		$this->we_ui_controls_Select->setName('check1');
		$this->we_ui_controls_Select->setOnChange('alert("hello world");');
		$this->we_ui_controls_Select->setTitle('This is the title!');
		$this->we_ui_controls_Select->setDisabled(false);
		$this->we_ui_controls_Select->setHidden(false);
		$this->we_ui_controls_Select->setOptions(array(
											'1'=>'Option 1', 
											'2'=>'Option 2',  
											'3'=>'Option 3', 
											'4'=>'Option 4',  
											'5'=>'Option 5', 
											'6'=>'Option 6'
										));
		$this->we_ui_controls_Select->setOptGroups(array(
						'optgroups'=>array(
										array(
											'label' => 'group 1',
											'options' => array(
														'7'=>'Option 7', 
														'8'=>'Option 8',  
														'9'=>'Option 9', 
														'10'=>'Option 10',  
														'11'=>'Option 11', 
														'12'=>'Option 12'
													),
											'disabled' =>false
										),
										array(
											'label' => 'group 2',
											'options' => array(
														'13'=>'Option 13', 
														'14'=>'Option 14',  
														'15'=>'Option 15'
													),
											'disabled' =>true
										)
									)
								)
					)
						;
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Select = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}
	
	/**
	 * Tests we_ui_controls_Select->getHTML()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_controls_Select->getHTML(),'<select class="we_ui_controls_Select" id="id1" size="5" name="check1" onChange="alert(&quot;hello world&quot;);" multiple="multiple"><option value="1" selected="selected">Option 1</option><option value="2" >Option 2</option><option value="3" >Option 3</option><option value="4" >Option 4</option><option value="5" >Option 5</option><option value="6" >Option 6</option><optgroup label=""></optgroup></select>');
	}

	/**
	 * Tests we_ui_controls_Select->getMultiple()
	 */
	public function testGetMultiple()
	{
		$this->assertEquals($this->we_ui_controls_Select->getMultiple(), true);
	}

	/**
	 * Tests we_ui_controls_Select->getOnChange()
	 */
	public function testGetOnChange()
	{
		$this->assertEquals($this->we_ui_controls_Select->getOnChange(), 'alert("hello world");');
	}

	/**
	 * Tests we_ui_controls_Select->getOptGroups()
	 */
	public function testGetOptGroups()
	{
		$this->assertEquals($this->we_ui_controls_Select->getOptGroups(), array(
														'optgroups'=>array(
																		array(
																			'label' => 'group 1',
																			'options' => array(
																						'7'=>'Option 7', 
																						'8'=>'Option 8',  
																						'9'=>'Option 9', 
																						'10'=>'Option 10',  
																						'11'=>'Option 11', 
																						'12'=>'Option 12'
																					),
																			'disabled' =>false
																		),
																		array(
																			'label' => 'group 2',
																			'options' => array(
																						'13'=>'Option 13', 
																						'14'=>'Option 14',  
																						'15'=>'Option 15'
																					),
																			'disabled' =>true
																		)
																	)
																));
	}

	/**
	 * Tests we_ui_controls_Select->getOptionNum()
	 */
	public function testGetOptionNum()
	{
		$this->assertEquals($this->we_ui_controls_Select->getOptionNum(), 6);
	}

	/**
	 * Tests we_ui_controls_Select->getOptions()
	 */
	public function testGetOptions()
	{
		$this->assertEquals($this->we_ui_controls_Select->getOptions(), array(
																		'1'=>'Option 1', 
																		'2'=>'Option 2',  
																		'3'=>'Option 3', 
																		'4'=>'Option 4',  
																		'5'=>'Option 5', 
																		'6'=>'Option 6'
																	));
	}

	/**
	 * Tests we_ui_controls_Select->getOptionsHTML()
	 */
	public function testGetOptionsHTML()
	{
		$this->assertEquals($this->we_ui_controls_Select->getOptionsHTML(), '<option value="1" selected="selected">Option 1</option><option value="2" >Option 2</option><option value="3" >Option 3</option><option value="4" >Option 4</option><option value="5" >Option 5</option><option value="6" >Option 6</option><optgroup label=""></optgroup>');
	}

	/**
	 * Tests we_ui_controls_Select->getSelectedValue()
	 */
	public function testGetSelectedValue()
	{
		$this->assertEquals($this->we_ui_controls_Select->getSelectedValue(), "1");
	}

	/**
	 * Tests we_ui_controls_Select->getSize()
	 */
	public function testGetSize()
	{
		$this->assertEquals($this->we_ui_controls_Select->getSize(), 5);
	
	}

}

