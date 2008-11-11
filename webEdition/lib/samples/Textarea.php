<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');


$textarea = new we_ui_controls_Textarea();
$textarea->setTitle('Title');
$textarea->setName('textarea');
$textarea->setText('Hallo...');
$textarea->setDisabled(false);
$textarea->setHidden(false);
$textarea->setOnBlur('alert("onBlur");');
$textarea->setCols(50);
$textarea->setRows(5);

$textarea2 = new we_ui_controls_Textarea(
	array(
		'title'=>'This is the title of the textarea!',
		'name'=>'textarea2', 
		'text'=>'Hallo...', 
		'disabled'=>true, 
		'hidden'=>false, 
		'width'=>300,
		'height'=>300
	)
);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo Welt');

$htmlPage->addElement($textarea);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.setDisabled(&quot;'.$textarea->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.setDisabled(&quot;'.$textarea->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.hide(&quot;'.$textarea->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.show(&quot;'.$textarea->getId().'&quot;);">show</a></div>');

$htmlPage->addHTML("<br/>--------------<br/><br/>");

$htmlPage->addElement($textarea2);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.setDisabled(&quot;'.$textarea2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.setDisabled(&quot;'.$textarea2->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.hide(&quot;'.$textarea2->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Textarea.show(&quot;'.$textarea2->getId().'&quot;);">show</a></div>');


print $htmlPage->getHTML();

?>