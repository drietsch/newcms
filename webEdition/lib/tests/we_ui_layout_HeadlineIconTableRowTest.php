<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_HeadlineIconTableRow test case.
 */
class we_ui_layout_HeadlineIconTableRowTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_HeadlineIconTableRow
	 */
	private $we_ui_layout_HeadlineIconTableRow;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		
		$inp = new we_ui_controls_TextField(array('id' => 'test', 'name'=>'test', 'value'=>'default', 'width'=>100));
		$inp1 = new we_ui_controls_TextField(array('id' => 'test1', 'name'=>'test1', 'value'=>'default', 'width'=>100));

		$this->we_ui_layout_HeadlineIconTableRow = new we_ui_layout_HeadlineIconTableRow(
			array(
				'title' => 'Input 1', 
				'iconPath' => we_ui_layout_HeadlineIconTableRow::kIconAttributes,
				'leftWidth' => 155,
				'id' => 'rowid'
			)
		);
		
		$this->we_ui_layout_HeadlineIconTableRow->addElement($inp);
		$this->we_ui_layout_HeadlineIconTableRow->addElement($inp1);
		
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->getIconPath()
	 */
	public function testGetIconPath()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTableRow->getIconPath(), we_ui_layout_HeadlineIconTableRow::kIconAttributes);
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->getLeftWidth()
	 */
	public function testGetLeftWidth()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTableRow->getLeftWidth(), 155);
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->getLine()
	 */
	public function testGetLine()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTableRow->getLine(), true);
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->hasLine()
	 */
	public function testHasLine()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTableRow->hasLine(), true);
	}


	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->hasLine()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTableRow->getHTML(), '<div style="float:left;width:155px"><img src="/webEdition/images/icons/attrib.gif" alt="" /></div><div style="float:left;"><div class="we_ui_layout_HeadlineIconTable_RowTitle" style="margin-bottom:10px;">Input 1</div><div><input id="test" name="test" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/><input id="test1" name="test1" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/></div></div><br style="clear:both;">');
	}


}

