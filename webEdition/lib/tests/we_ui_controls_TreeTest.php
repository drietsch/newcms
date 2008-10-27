<?php

include_once('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_controls_Tree test case.
 */
class we_ui_controls_TreeTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_controls_Tree
	 */
	private $we_ui_controls_Tree;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->we_ui_controls_Tree = new we_ui_controls_Tree();
		$this->we_ui_controls_Tree->setId('id1');
		$this->we_ui_controls_Tree->setNodes(array('1'=>1,'2'=>2));
		$this->we_ui_controls_Tree->setOpenNodes(array('1'=>1));
		$this->we_ui_controls_Tree->setTable('tblfile');

	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->we_ui_controls_Tree = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{

	}

	/**
	 * Tests we_ui_controls_Tree->getNodeObject()
	 */
	public function testGetNodeObject()
	{
		$this->assertEquals($this->we_ui_controls_Tree->getNodeObject(1,'text'), 'var myobj = { label: "<span title=\"1\" id=\"spanText_id1_1\">text</span>",id: "1",text: "text",title: "1"}; ');
	
	}

	/**
	 * Tests we_ui_controls_Tree->getNodes()
	 */
	public function testGetNodes()
	{
		$this->assertEquals($this->we_ui_controls_Tree->getNodes(), array('1'=>1,'2'=>2));
	
	}

	/**
	 * Tests we_ui_controls_Tree->getOpenNodes()
	 */
	public function testGetOpenNodes()
	{
		$this->assertEquals($this->we_ui_controls_Tree->getOpenNodes(), array('1'=>1));
	
	}

	/**
	 * Tests we_ui_controls_Tree->getTable()
	 */
	public function testGetTable()
	{
		$this->assertEquals($this->we_ui_controls_Tree->getTable(), 'tblfile');
	
	}

	/**
	 * Tests we_ui_controls_Tree::getTreeIconClass()
	 */
	public function testGetTreeIconClass()
	{
		$this->assertEquals($this->we_ui_controls_Tree->getTreeIconClass('image/*'), 'image');
	
	}
	

}

