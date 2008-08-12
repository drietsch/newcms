<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$radio = new we_ui_controls_RadioButton();
$radio->setValue('1');
$radio->setChecked(true);
$radio->setName('testCheckbox');
$radio->setLabel('Label 1');
$radio->setHidden(false);
$radio->setDisabled(false);
$radio->setTitle('Title of Label 1');



$radio2 = new we_ui_controls_RadioButton(
	array(
		'value'=>'1', 
		'checked'=>false, 
		'name'=>'test2', 
		'label'=>'Label 2', 
		'hidden'=>true, 
		'disabled'=>true, 
		'title'=>'Title of Label 2'
	)
);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo Welt');

$htmlPage->addElement($radio);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setDisabled(&quot;'.$radio->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setDisabled(&quot;'.$radio->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setChecked(&quot;'.$radio->getId().'&quot;, true);">checked</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setChecked(&quot;'.$radio->getId().'&quot;, false);">not checked</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.hide(&quot;'.$radio->getId().'&quot;, true);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.show(&quot;'.$radio->getId().'&quot;, false);">show</a></div>');

$htmlPage->addHTML('<br/><br/>');

$htmlPage->addElement($radio2);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setDisabled(&quot;'.$radio2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setDisabled(&quot;'.$radio2->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setChecked(&quot;'.$radio2->getId().'&quot;, true);">checked</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.setChecked(&quot;'.$radio2->getId().'&quot;, false);">not checked</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.hide(&quot;'.$radio2->getId().'&quot;, true);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_RadioButton.show(&quot;'.$radio2->getId().'&quot;, false);">show</a></div>');


print $htmlPage->getHTML();

?>