<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$form = new we_ui_layout_Form();  
$form->setName('we_form');  
$form->setOnSubmit('return false');  
$form->setMethod('post'); 
$form->setAction('/form.php'); 

$inp = new we_ui_controls_TextField();
$inp->setName('test');
$inp->setValue('default');
$inp->setWidth(100);

$form->addElement($inp);

$htmlPage = we_ui_layout_HTMLPage::getInstance();
$htmlPage->setTitle('Samples Form');
$htmlPage->addInlineCSS('
body { 
	padding:10px !important;
}
');


$htmlPage->addElement($form);


print $htmlPage->getHTML();

?>