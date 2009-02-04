<?php

include_once ('webEdition/lib/we/core/autoload.php');

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * we_ui_layout_HeadlineIconTable test case.
 */
class we_ui_layout_HeadlineIconTableTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var we_ui_layout_HeadlineIconTable
	 */
	private $we_ui_layout_HeadlineIconTable;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		
		$inp = new we_ui_controls_TextField(array('id' => 'test', 'name' => 'test', 'value' => 'default', 'width' => 100));
		$inp1 = new we_ui_controls_TextField(array('id' => 'test1', 'name' => 'test1', 'value' => 'default', 'width' => 100));
		$inp2 = new we_ui_controls_TextField(array('id' => 'test2', 'name' => 'test2', 'value' => 'default', 'width' => 100));
		
		$rows = array();
		$row = new we_ui_layout_HeadlineIconTableRow(array('id' => 'rowid1', 'title' => 'Input 1', 'iconPath' => we_ui_layout_HeadlineIconTableRow::kIconAttributes));
		$row->addElement($inp);
		$row->addElement($inp1);
		$rows[] = $row;
		
		$row = new we_ui_layout_HeadlineIconTableRow(array('id' => 'rowid2', 'title' => 'Input 2', 'iconPath' => we_ui_layout_HeadlineIconTableRow::kIconCache));
		$row->addElement($inp2);
		$rows[] = $row;
		
		$this->we_ui_layout_HeadlineIconTable = new we_ui_layout_HeadlineIconTable(array('id' => 'tableId', 'foldedText' => 'hello', 'unfoldedText' => 'mytext', 'unfoldWhenRenders' => 'unfold', 'rows' => $rows, 'width' => '100%', 'title' => 'TEST Titel'));
		$this->we_ui_layout_HeadlineIconTable->setMarginLeft(40);
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getButtonTable()
	 */
	public function testGetButtonTable()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getButtonTable(), '');
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getFoldAtIndex()
	 */
	public function testGetFoldAtIndex()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getFoldAtIndex(), -1);
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getFoldedText()
	 */
	public function testGetFoldedText()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getFoldedText(), 'hello');
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getMarginLeft()
	 */
	public function testGetMarginLeft()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getMarginLeft(), 40);
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getRows()
	 */
	public function testGetRows()
	{
		$this->assertEquals(count($this->we_ui_layout_HeadlineIconTable->getRows()), 2);
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getUnfoldedText()
	 */
	public function testGetUnfoldedText()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getUnfoldedText(), 'mytext');
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTable->getUnfoldWhenRenders()
	 */
	public function testGetUnfoldWhenRenders()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getUnfoldWhenRenders(), 'unfold');
	
	}

	/**
	 * Tests we_ui_layout_HeadlineIconTableRow->hasLine()
	 */
	public function testGetHTML()
	{
		$this->assertEquals($this->we_ui_layout_HeadlineIconTable->getHTML(), '<table id="tableId" style="width:100%;margin-top:10px;" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left:40px;padding-bottom:10px;" class="we_ui_layout_HeadlineIconTable_Title">TEST Titel</td>
	</tr>
	<tr>
		<td><img src="/webEdition/lib/we/ui/layout/img/pixel.gif" width="2" height="8" alt=""/></td>
	</tr>
	<tr>
		<td id="tableId_td"><div style="margin-left:40px" id="tableId_div_0"><div style="float:left;width:150px"><img src="/webEdition/images/icons/attrib.gif" alt="" /></div><div style="float:left;"><div class="we_ui_layout_HeadlineIconTable_RowTitle" style="margin-bottom:10px;">Input 1</div><div><input id="test" name="test" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/><input id="test1" name="test1" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/></div></div><br style="clear:both;"></div><div class="we_ui_layout_HeadlineIconTable_Rule"></div><div style="margin-left:40px" id="tableId_div_1"><div style="float:left;width:150px"><img src="/webEdition/images/icons/cache.gif" alt="" /></div><div style="float:left;"><div class="we_ui_layout_HeadlineIconTable_RowTitle" style="margin-bottom:10px;">Input 2</div><div><input id="test2" name="test2" value="default" type="text" style="width:96px;height:17px;" class="we_ui_controls_TextInput" onFocus="YAHOO.util.Dom.addClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);" onBlur="YAHOO.util.Dom.removeClass(this, &quot;we_ui_controls_TextInput_Selected&quot;);"/></div></div><br style="clear:both;"></div><div class="we_ui_layout_HeadlineIconTable_Space"></div></td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
');
	}
}

