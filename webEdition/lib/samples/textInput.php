<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');


$inp = new we_ui_controls_TextField();
$inp->setName('test');
$inp->setValue('default');
$inp->setWidth(100);

$inp2 = new we_ui_controls_TextField(array('name'=>'test2', 'value'=>'default', 'width'=>100));

$but = new we_ui_controls_Button(
	array(
		'title'=>'This is the title of the button!',
		'text'=>'onClick / onMouseUp', 
		'onClick'=>'alert("Hello!");', 
		'type'=>'onClick', 
		'disabled'=>false, 
		'hidden'=>false, 
		'width'=>200
	)
);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');


$table = new we_ui_layout_Table(array('style'=>'margin:20px;','border'=>0));
$table->setCellAttributes(array('valign'=>'middle'),0, 0);
$table->addElement($inp,0,0);
$table->setCellAttributes(array('valign'=>'middle'),1, 0);
$table->addElement($but,1,0);
$htmlPage->addElement($table);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_TextField.setDisabled(&quot;'.$inp->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_TextField.setDisabled(&quot;'.$inp->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addElement($inp2);

print $htmlPage->getHTML();
/*
		if (!$_SERVER['DOCUMENT_ROOT']) {
			$_SERVER['DOCUMENT_ROOT'] = '../../../';
		}

include_once('webEdition/lib/we/core/autoload.php');

$textInput = new we_ui_controls_TextField();
		$textInput->setName('test');
		
		$p = new we_ui_layout_HTMLPage();
		$p->addBodyAttribute('onload', 'alert(999);');
		$p->addBodyAttribute('onunload', 'alert(998);');
		$p->addCSSFile('we_ui_controls_TextInput');
		$p->addElement($textInput);
		$p->addHTML('<pre>TEST</pre>');
		$p->addInlineCSS('a {border: 1px solid black;}');
		$p->addInlineJS('alert("TEST");');
		$p->setCharset('ISO-8859-1');
		$p->setLang('de');
		$p->setTitle('My Title');
		print $p->getHTML();*/

?>