<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$IDValue = '0';
if ($IDValue == '0') {
	$_path = '/';
} else {
	$_path = we_util_Path::id2Path($IDValue,$table);
	
}

$ac = new we_ui_controls_ACFileSelector();
$ac->setButtonText('Select');
$ac->setButtonTitle('Select');
$ac->setFolderIdValue($IDValue);
$ac->setFolderPathValue($_path);
$ac->setTable('tblfile');
$ac->setContentType('folder');
$ac->setWidth(300);
//$ac->setOnChange('');
//$ac->setMayBeEmpty(false);
//$ac->setAppName('');
//$ac->setDisabled(false);
//$ac->setHidden(false);


$ac2 = new we_ui_controls_ACFileSelector();
$ac2->setButtonText('Select');
$ac2->setButtonTitle('Select');
$ac2->setFolderIdValue($IDValue);
$ac2->setFolderPathValue($_path);
$ac2->setTable('tbltemplates');
$ac2->setContentType('folder');
$ac2->setWidth(310);
//$ac2->setOnChange('');
//$ac2->setMayBeEmpty(false);
//$ac2->setAppName('');
//$ac2->setDisabled(false);
//$ac2->setHidden(false);


$ac3 = new we_ui_controls_ACFileSelector();
$ac3->setButtonText('Select');
$ac3->setButtonTitle('Select');
$ac3->setFolderIdValue($IDValue);
$ac3->setFolderPathValue($_path);
$ac3->setTable('tbltemplates');
$ac3->setContentType('folder');
$ac3->setWidth(320);
//$ac3->setOnChange('');
$ac3->setMayBeEmpty(true);
//$ac3->setAppName('');
//$ac3->setDisabled(false);
//$ac3->setHidden(false);

$ac4 = new we_ui_controls_ACFileSelector();
$ac4->setButtonText('Select');
$ac4->setButtonTitle('Select');
$ac4->setFolderIdValue($IDValue);
$ac4->setFolderPathValue($_path);
$ac4->setTable('tblobject');
$ac4->setContentType('object');
$ac4->setWidth(330);
//$ac4->setOnChange('');
//$ac4->setMayBeEmpty(true);
//$ac4->setAppName('');
//$ac4->setDisabled(false);
//$ac4->setHidden(false);

$ac5 = new we_ui_controls_ACFileSelector();
$ac5->setButtonText('Select');
$ac5->setButtonTitle('Select');
$ac5->setFolderIdValue($IDValue);
$ac5->setFolderPathValue($_path);
$ac5->setTable('tblobjectfiles');
$ac5->setContentType('objectfile');
$ac5->setWidth(340);
//$ac5->setOnChange('');
//$ac5->setMayBeEmpty(true);
//$ac5->setAppName('');
//$ac5->setDisabled(false);
//$ac5->setHidden(false);

$ac6 = new we_ui_controls_ACFileSelector();
$ac6->setButtonText('Select');
$ac6->setButtonTitle('Select');
$ac6->setFolderIdValue($IDValue);
$ac6->setFolderPathValue($_path);
$ac6->setTable('tblobjectfiles');
$ac6->setContentType('folder');
$ac6->setWidth(350);
//$ac6->setOnChange('');
//$ac6->setMayBeEmpty(true);
//$ac6->setAppName('');
//$ac6->setDisabled(false);
//$ac6->setHidden(false);


$ac7 = new we_ui_controls_ACFileSelector();
$ac7->setButtonText('Select');
$ac7->setButtonTitle('Select');
$ac7->setFolderIdValue($IDValue);
$ac7->setFolderPathValue($_path);
$ac7->setTable('tblFile');
$ac7->setContentType('folder,image/*');
$ac7->setWidth(360);
//$ac7->setOnChange('');
//$ac7->setMayBeEmpty(true);
//$ac7->setAppName('');
//$ac7->setDisabled(false);
//$ac7->setHidden(false);

$ac8 = new we_ui_controls_ACFileSelector();
$ac8->setButtonText('Select');
$ac8->setButtonTitle('Select');
$ac8->setFolderIdValue($IDValue);
$ac8->setFolderPathValue($_path);
$ac8->setTable('leer');
$ac8->setContentType('folder');
$ac8->setWidth(370);
//$ac8->setOnChange('');
//$ac8->setMayBeEmpty(true);
$ac8->setAppName('leer');
//$ac8->setDisabled(false);
//$ac8->setHidden(false);



$ac9 = new we_ui_controls_ACFileSelector();
$ac9->setButtonText('Select');
$ac9->setButtonTitle('Select');
$ac9->setFolderIdValue($IDValue);
$ac9->setFolderPathValue($_path);
$ac9->setTable('tblfile');
$ac9->setContentType('folder,image/*');
$ac9->setWidth(380);
//$ac9->setOnChange('');
//$ac9->setMayBeEmpty(true);
//$ac9->setAppName('leer');
//$ac9->setDisabled(false);
//$ac9->setHidden(false);


$ac10 = new we_ui_controls_ACFileSelector();
$ac10->setButtonText('Select');
$ac10->setButtonTitle('Select');
$ac10->setFolderIdValue($IDValue);
$ac10->setFolderPathValue($_path);
$ac10->setTable('tblNavigation');
$ac10->setContentType('folder');
$ac10->setWidth(390);
//$ac10->setOnChange('');
//$ac10->setMayBeEmpty(true);
$ac10->setAppName('navigation');
//$ac10->setDisabled(false);
//$ac10->setHidden(false);


$htmlPage = we_ui_layout_HTMLPage::getInstance();
$htmlPage->setTitle('Samples Autocompleter');
$htmlPage->addJSFile('/webEdition/js/windows.js');
$htmlPage->addInlineCSS('
body { 
	padding:10px !important;
}
');
$htmlPage->addHTML('<span style="font-size:16px;font-weight:bold;">ACs nur benutzbar wenn an webEdition angemeldet!</span><br/><br/>');


$htmlPage->addHTML('<br>Dokumentverzeichnis-Selektor');
$htmlPage->addElement($ac);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac->getId().'&quot;, false);">enable</a></div>');


$htmlPage->addHTML('<br><br>Templateverzeichnis-Selektor<br>');
$htmlPage->addElement($ac2);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac2->getId().'&quot;, false);">enable</a></div>');


$htmlPage->addHTML('<br><br>Template-Selektor (mayBeEmpty=true)<br>');
$htmlPage->addElement($ac3);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac3->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac3->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Klassen-Selektor<br>');
$htmlPage->addElement($ac4);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac4->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac4->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Objekt-Selektor<br>');
$htmlPage->addElement($ac5);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac5->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac5->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Objektverzeichnis-Selektor<br>');
$htmlPage->addElement($ac6);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac6->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac6->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Grafik-Selektor (ContentType=folder,image/*)<br>');
$htmlPage->addElement($ac7);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac7->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac7->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Toolverzeichnis-Selektor (toolname=leer)<br>');
$htmlPage->addElement($ac8);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac8->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac8->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Grafik-Selektor 2 (ContentType=folder,image/*)<br>');
$htmlPage->addElement($ac9);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac9->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac9->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<br><br>Navigation-Selektor<br>');
$htmlPage->addElement($ac10);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac10->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_ACFileSelector.setDisabled(&quot;'.$ac10->getId().'&quot;, false);">enable</a></div>');


print $htmlPage->getHTML();

?>