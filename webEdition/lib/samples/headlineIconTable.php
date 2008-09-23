<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$inp = new we_ui_controls_TextField(array('name'=>'test', 'value'=>'default', 'width'=>100));
$inp1 = new we_ui_controls_TextField(array('name'=>'test1', 'value'=>'default', 'width'=>100));
$inp2 = new we_ui_controls_TextField(array('name'=>'test2', 'value'=>'default', 'width'=>100));



$rows = array();
$row = new we_ui_layout_HeadlineIconTableRow(array('title' => 'Input 1', 'iconPath' => we_ui_layout_HeadlineIconTableRow::kIconAttributes));
$row->addElement($inp);
$row->addElement($inp1);
$rows[] = $row;

$row = new we_ui_layout_HeadlineIconTableRow(array('title' => 'Input 2', 'iconPath' => we_ui_layout_HeadlineIconTableRow::kIconCache));
$row->addElement($inp2);
$rows[] = $row;


$table = new we_ui_layout_HeadlineIconTable();
$table->setTitle('TEST Titel');
$table->setWidth('100%');
$table->setRows($rows);
$table->setMarginLeft(40);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');

$htmlPage->addElement($table);

$htmlPage->addHTML('<div><a href="javascript:appendRow();">append row</a></div>');

$inp3 = new we_ui_controls_TextField(array('name'=>'input___INDEX__', 'id'=>'input___INDEX__', 'value'=>'default', 'width'=>100));

$row = new we_ui_layout_HeadlineIconTableRow();
$row->setTitle('Dynamic with Index: __INDEX__');
$row->setIconPath(we_ui_layout_HeadlineIconTableRow::kIconAttributes);
$row->addElement($inp3);


$js = <<<endOfScript

function appendRow() {
	html = '{$row->getJSHTML()}';
	table = new we_ui_layout_HeadlineIconTable("{$table->getId()}");
	table.appendRow(html, 40, true);
}

endOfScript;

$htmlPage->addInlineJS($js);

print $htmlPage->getHTML();
