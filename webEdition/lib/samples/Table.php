<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$inp1 = new we_ui_controls_TextField(array('style'=>'margin:0 10px 10px 0', 'name'=>'test1', 'value'=>'default1', 'width'=>100));
$inp11 = new we_ui_controls_TextField(array('style'=>'margin:0 10px 10px 0', 'name'=>'test11', 'value'=>'default11', 'width'=>100));
$inp2 = new we_ui_controls_TextField(array('name'=>'test2', 'value'=>'default2', 'width'=>100));
$inp3 = new we_ui_controls_TextField(array('name'=>'test3', 'value'=>'default3', 'width'=>100));
$inp4 = new we_ui_controls_TextField(array('name'=>'test4', 'value'=>'default4', 'width'=>100));

$checkbox = new we_ui_controls_Checkbox(
	array(
		'value'=>'1', 
		'checked'=>true, 
		'name'=>'test', 
		'label'=>'Label 1', 
		'hidden'=>false, 
		'disabled'=>false, 
		'title'=>'Title of Label 1'
	)
);

$checkbox2 = new we_ui_controls_Checkbox(
	array(
		'value'=>'1', 
		'checked'=>false, 
		'name'=>'test2', 
		'label'=>'Label 2', 
		'hidden'=>false, 
		'disabled'=>true, 
		'title'=>'Title of Label 2'
	)
);


$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');

$table2 = new we_ui_layout_Table();
$table2->addElement($checkbox, 0, 0);
$table2->addElement($checkbox2, 1, 0);


$table = new we_ui_layout_Table(array('style'=>'margin:10px 0 0 10px;', 'width'=>500));

$table->setCellAttributes(array('width'=>110));
$table->addElement($inp1);
$table->addElement($inp11);
$table->nextColumn();
$table->addElement($inp2);
$table->nextRow(true);
$table->addElement($inp3);
$table->nextColumn();
$table->addElement($inp4);
$table->nextRow();
$table->addHTML('Hallo Welt');

$table->nextRow();
$table->addElement($table2);

$htmlPage->addElement($table);

print $htmlPage->getHTML();

?>