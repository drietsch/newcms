<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_Table test case.
 */
class we_ui_layout_TableTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_Table
	 */
	private $we_ui_layout_Table;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		$this->we_ui_layout_Table = new we_ui_layout_Table(array('id' => 'tableId', 'border' => 1, 'cellPadding' => 2, 'cellSpacing' => 3));
		$this->we_ui_layout_Table->addHTML("1.1");
		$this->we_ui_layout_Table->nextColumn();
		$this->we_ui_layout_Table->addHTML("1.2");
		$this->we_ui_layout_Table->nextColumn();
		$this->we_ui_layout_Table->addHTML("1.3");
		$this->we_ui_layout_Table->nextRow(true);
		$this->we_ui_layout_Table->addHTML("2.1");
		$this->we_ui_layout_Table->nextColumn();
		$this->we_ui_layout_Table->addHTML("2.2");
		$this->we_ui_layout_Table->nextColumn();
		$this->we_ui_layout_Table->addHTML("2.3");
	
	}

	/**
	 * Tests we_ui_layout_Table->getBorder()
	 */
	public function testGetBorder()
	{
		$this->assertEquals($this->we_ui_layout_Table->getBorder(), 1);
	}

	/**
	 * Tests we_ui_layout_Table->getCellPadding()
	 */
	public function testGetCellPadding()
	{
		$this->assertEquals($this->we_ui_layout_Table->getCellPadding(), 2);
	}

	/**
	 * Tests we_ui_layout_Table->getCellSpacing()
	 */
	public function testGetCellSpacing()
	{
		$this->assertEquals($this->we_ui_layout_Table->getCellSpacing(), 3);
	}

	/**
	 * Tests we_ui_layout_Table->getColumn()
	 */
	public function testGetColumn()
	{
		$this->assertEquals($this->we_ui_layout_Table->getColumn(), 2);
	}

	/**
	 * Tests we_ui_layout_Table->getRow()
	 */
	public function testGetRow()
	{
		$this->assertEquals($this->we_ui_layout_Table->getRow(), 1);
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->hasLine()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_Table->getHTML(), '<table border="1" cellpadding="2" cellspacing="3" id="tableId"><tr><td valign="top">1.1</td><td valign="top">1.2</td><td valign="top">1.3</td></tr><tr><td valign="top">2.1</td><td valign="top">2.2</td><td valign="top">2.3</td></tr></table>');
	}

}

