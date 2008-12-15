<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$buttonHref = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'href', 
		'type'=>'href', 
		'href'=>'http://www.webedition.de', 
		'target'=>'_blank',
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>200
	)
);

$buttonOnClick = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'onClick / onMouseUp', 
		'onClick'=>'alert("Hallo Welt!");', 
		'type'=>'onClick', 
		'disabled'=>true, 
		'hidden'=>false, 
		'width'=>200
	)
);
$buttonHref2 = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'href2', 
		'type'=>'href', 
		'href'=>'http://www.webedition.de', 
		'target'=>'_blank',
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>200
	)
);

$buttonOnClick2 = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'onClick / onMouseUp 2', 
		'onClick'=>'alert("Hallo Welt!");', 
		'type'=>'onClick', 
		'disabled'=>true, 
		'hidden'=>false, 
		'width'=>200
	)
);

$buttonYes = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'Yes', 
		'onClick'=>'alert("yes!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>100
	)
);

$buttonNo = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'No', 
		'onClick'=>'alert("no!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>100
	)
);

$buttonCancel = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'Cancel', 
		'onClick'=>'alert("cancel!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>100
	)
);

$buttonOk = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'OK', 
		'onClick'=>'alert("ok!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>100
	)
);

$buttonCancel2 = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'Cancel', 
		'onClick'=>'alert("cancel!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>100
	)
);

$buttonTable = new we_ui_layout_ButtonTable(
	array(
		'border'=>1,
		'height'=>100
	)
);

$buttonTable2 = new we_ui_layout_ButtonTable(
	array(
		'hidden'=>false,
		'cellpadding'=>5,
		'border'=>0
	)
);

$buttonTable3 = new we_ui_layout_ButtonTableYesNo(
	array(
		'hidden'=>false,
		'horizontalPadding'=>40
	)
);

$buttonTable4 = new we_ui_layout_ButtonTableYesNo(
	array(
		'hidden'=>false
	)
);


$checkbox = new we_ui_controls_Checkbox(
	array(
		'value'=>'1', 
		'checked'=>true, 
		'name'=>'test', 
		'label'=>'Label 1', 
		'hidden'=>false, 
		'disabled'=>false,
		'width'=>100,
		'title'=>'Title'
	)
);

$radio = new we_ui_controls_RadioButton(
	array(
		'value'=>'1', 
		'checked'=>true, 
		'name'=>'test', 
		'label'=>'Label 1', 
		'hidden'=>false, 
		'disabled'=>false, 
		'width'=>100,
		'title'=>'Title of Label 1'
	)
);

$select = new we_ui_controls_Select(
	array(
		'name'=>'select', 
		'multiple'=>false, 
		//'size'=>3,
		'disabled'=>false, 
		'hidden'=>false,
		'title'=>'Titel',
		'width'=>100,
		'onChange'=>'alert("onChange!");', 
		'selectedValue'=>'3',
		'options' => array(
				'1'=>'Option 1', 
				'2'=>'Option 2',  
				'3'=>'Option 3', 
				'4'=>'Option 4',  
				'5'=>'Option 5', 
				'6'=>'Option 6'
			)
	)
);

$inp = new we_ui_controls_TextField(array('name'=>'test', 'value'=>'default', 'width'=>100));

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($buttonHref);
$buttonTable->nextColumn();
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($buttonOnClick);
$buttonTable->nextColumn();
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($inp);
$buttonTable->nextColumn();
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($checkbox);
$buttonTable->nextColumn();
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($radio);
$buttonTable->nextColumn();
$buttonTable->setCellAttributes(array('valign'=>'middle'));
$buttonTable->addElement($select);
$buttonTable->nextColumn();

$htmlPage->addElement($buttonTable);

$htmlPage->addHTML("<br/><br/><br/>");
$buttonTable2->setCellAttributes(array('valign'=>'middle'));
$buttonTable2->addElement($buttonHref);
$buttonTable2->nextRow();
$buttonTable2->setCellAttributes(array('valign'=>'middle'));
$buttonTable2->addElement($buttonOnClick);
$buttonTable2->nextRow();
$buttonTable2->setCellAttributes(array('valign'=>'middle'));
$buttonTable2->addElement($buttonHref2);
$buttonTable2->nextRow();
$buttonTable2->setCellAttributes(array('valign'=>'middle'));
$buttonTable2->addElement($buttonOnClick2);
$buttonTable2->nextRow();

$htmlPage->addElement($buttonTable2);


$htmlPage->addHTML("<br/><br/><br/>");


$buttonTable3->setYesOkButton($buttonYes);
$buttonTable3->setNoButton($buttonNo);
$buttonTable3->setCancelButton($buttonCancel);

$htmlPage->addElement($buttonTable3);

$htmlPage->addHTML("<br/><br/><br/>");



$buttonTable4->setYesOkButton($buttonOk);
$buttonTable4->setCancelButton($buttonCancel2);

$htmlPage->addElement($buttonTable4);

print $htmlPage->getHTML();

?>