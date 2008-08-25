<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_ACFileSelector test case.
 */
class we_ui_controls_ACFileSelectorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_ACFileSelector
	 */
	private $we_ui_controls_ACFileSelector;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_ACFileSelector = new we_ui_controls_ACFileSelector();
		$this->we_ui_controls_ACFileSelector->setId('test_id');
		$this->we_ui_controls_ACFileSelector->setContentType('image/*');
		$this->we_ui_controls_ACFileSelector->setFolderIdName('idname');
		$this->we_ui_controls_ACFileSelector->setFolderIdValue('idvalue');
		$this->we_ui_controls_ACFileSelector->setFolderPathName('pathname');
		$this->we_ui_controls_ACFileSelector->setFolderPathValue('pathvalue');
		$this->we_ui_controls_ACFileSelector->setTable('tblfile');
		$this->we_ui_controls_ACFileSelector->setSelector('docSelector');
		
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_ACFileSelector = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getContentType()
	 */
	public function testGetContentType()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getContentType(), 'image/*');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getFolderIdName()
	 */
	public function testGetFolderIdName()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getFolderIdName(), 'idname');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getFolderIdValue()
	 */
	public function testGetFolderIdValue()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getFolderIdValue(), 'idvalue');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getFolderPathName()
	 */
	public function testGetFolderPathName()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getFolderPathName(), 'pathname');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getFolderPathValue()
	 */
	public function testGetFolderPathValue()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getFolderPathValue(), 'pathvalue');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getSelector()
	 */
	public function testGetSelector()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getSelector(), 'docSelector');
	
	}

	/**
	 * Tests we_ui_controls_ACFileSelector->getTable()
	 */
	public function testGetTable()
	{
		$this->assertEquals($this->we_ui_controls_ACFileSelector->getTable(), 'tblfile');
	
	}

}

