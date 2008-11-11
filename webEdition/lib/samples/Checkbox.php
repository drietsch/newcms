<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$checkbox = new we_ui_controls_Checkbox();
$checkbox->setValue('1');
$checkbox->setChecked(true);
$checkbox->setName('test');
$checkbox->setLabel('Label 1');
$checkbox->setHidden(false);
$checkbox->setDisabled(false);
$checkbox->setWidth(100);
$checkbox->setStyle('border:1px solid #ff0000;');
$checkbox->setTitle('Title');


$checkbox2 = new we_ui_controls_Checkbox(
	array(
		'value'=>'1', 
		'checked'=>false, 
		'name'=>'test2', 
		'label'=>'Label 2', 
		'hidden'=>true, 
		'disabled'=>true, 
		'title'=>'Title'
	)
);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo Welt');
$htmlPage->addHTML('<form>');
$htmlPage->addElement($checkbox);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setDisabled(&quot;'.$checkbox->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setDisabled(&quot;'.$checkbox->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setChecked(&quot;'.$checkbox->getId().'&quot;, true);">checked</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setChecked(&quot;'.$checkbox->getId().'&quot;, false);">not checked</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.hide(&quot;'.$checkbox->getId().'&quot;, true);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.show(&quot;'.$checkbox->getId().'&quot;, false);">show</a></div>');

$htmlPage->addHTML('<br/><br/>');

$htmlPage->addElement($checkbox2);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setDisabled(&quot;'.$checkbox2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setDisabled(&quot;'.$checkbox2->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setChecked(&quot;'.$checkbox2->getId().'&quot;, true);">checked</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.setChecked(&quot;'.$checkbox2->getId().'&quot;, false);">not checked</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.hide(&quot;'.$checkbox2->getId().'&quot;, true);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Checkbox.show(&quot;'.$checkbox2->getId().'&quot;, false);">show</a></div>');

$htmlPage->addHTML('</form>');

print $htmlPage->getHTML();

?>