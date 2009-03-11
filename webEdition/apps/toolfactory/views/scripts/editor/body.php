<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

$appName = Zend_Controller_Front::getInstance()->getParam('appName');
$translate = we_core_Local::addTranslation('apps.xml');
we_core_Local::addTranslation('default.xml', 'toolfactory');

$activTab = isset($_REQUEST['activTab']) ? ($_REQUEST['activTab']) : 'idPropertyTab';

$this->inputWidth = 400;

$form = new we_ui_layout_Form(array('name' => 'we_form', 'onsubmit' => 'return false', 'method' => 'post'));

$form->addHTML(we_ui_layout_Form::hidden('ID', $this->model->ID));
$form->addHTML(we_ui_layout_Form::hidden('activTab', $activTab));

$rowGeneral = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('General')));

$labelName = new we_ui_controls_Label();
$labelName->setStyle('display:block;');
$labelName->setText($translate->_('Name'). ($this->model->isRequiredField('Text') ? ' ['.$translate->_('Mandatory field').']' : ''));
$inputName = new we_ui_controls_TextField();
$inputName->setName('Text');
if(!empty($this->model->ID)) {
	$inputName->setDisabled(true);
}
$inputName->setValue($this->model->Text);
$inputName->setWidth($this->inputWidth);
$inputName->setOnChange('weEventController.fire("docChanged");setClassField(this.value);');
$inputName->setOnBlur('setClassField(this.value);');
$rowGeneral->addElement($labelName);
$rowGeneral->addElement($inputName);

$labelClass = new we_ui_controls_Label();
$labelClass->setStyle('margin-top:20px;display:block;');
$labelClass->setText($translate->_('Name of the model class'). ($this->model->isRequiredField('classname') ? ' ['.$translate->_('Mandatory field').']' : ''));
$inputClass = new we_ui_controls_TextField();
$inputClass->setName('classname');

if(!empty($this->model->ID)) {
	$inputClass->setDisabled(true);
}
$inputClass->setValue($this->model->classname);
$inputClass->setWidth($this->inputWidth);
$inputClass->setOnChange('weEventController.fire("docChanged");');
$rowGeneral->addElement($labelClass);
$rowGeneral->addElement($inputClass);

$labelDatasource = new we_ui_controls_Label();
$labelDatasource->setText($translate->_('Datasource'). ($this->model->isRequiredField('datasource') ? ' ['.$translate->_('Mandatory field').']' : ''));
$labelDatasource->setStyle('margin-top:20px;display:block;');
if(!empty($this->model->ID)) {
	$labelDatasource->setHidden(true);
}
$selectDatasource = new we_ui_controls_Select();
$optDatasource = array(
		'custom:'=>'custom', 
		'table:'=>$translate->_('Maintable')
);
$selectDatasource->setOptions($optDatasource);
$selectDatasource->setSelectedValue($this->model->datasource);
$selectDatasource->setName('datasource');
$selectDatasource->setWidth($this->inputWidth);
$selectDatasource->setOnChange('weEventController.fire("docChanged");if(this.value==\'table:\') document.getElementById(\'datasourceConf\').style.display=\'block\'; else  document.getElementById(\'datasourceConf\').style.display=\'none\';');
$selectDatasource->setWidth($this->inputWidth);
if(empty($this->model->ID)) {
	$rowGeneral->addElement($labelDatasource);
	$rowGeneral->addElement($selectDatasource);
}

$divMaintable = new we_ui_layout_Div();
$divMaintable->setId('datasourceConf');
if(empty($this->model->ID)) {
	$divMaintable->setStyle('margin-left: 10px;');
}
if(substr($this->model->datasource, 0, 6) !='table:') {
	$divMaintable->setHidden(true);
}

$labelMaintable = new we_ui_controls_Label();
$labelMaintable->setText($translate->_('Maintable'));
$labelMaintable->setStyle('margin-top:20px;display:block;');
$inputMaintable = new we_ui_controls_TextField();
$inputMaintable->setName('maintable');
if(!empty($this->model->ID)) {
	$inputMaintable->setDisabled(true);
}
$inputMaintable->setValue($this->model->maintable);
$inputMaintable->setWidth($this->inputWidth - 10);
if(!empty($this->model->ID)) {
	$inputMaintable->setWidth($this->inputWidth);
}
$inputMaintable->setOnChange('weEventController.fire("docChanged")');
$divMaintable->addElement($labelMaintable);
$divMaintable->addElement($inputMaintable);


$rowGeneral->addElement($divMaintable);


if(empty($this->model->ID)) {
	$checkboxMakeTags = new we_ui_controls_Checkbox();
	$checkboxMakeTags->setId('makeTags');
	$checkboxMakeTags->setName('makeTags');
	$checkboxMakeTags->setOnClick('weEventController.fire("docChanged")');
	$checkboxMakeTags->setChecked(($this->model->makeTags) ? true : false);
	$checkboxMakeTags->setValue($this->model->makeTags);
	$checkboxMakeTags->setLabel($translate->_('Create Support for webEdition-Tags and the Pattern-Tag'));
	$checkboxMakeTags->setStyle('margin-top:20px;');
	$rowGeneral->addElement($checkboxMakeTags);
	
	$checkboxMakeServices = new we_ui_controls_Checkbox();
	$checkboxMakeServices->setId('makeServices');
	$checkboxMakeServices->setName('makeServices');
	$checkboxMakeServices->setOnClick('weEventController.fire("docChanged")');
	$checkboxMakeServices->setChecked(($this->model->makeServices) ? true : false);
	$checkboxMakeServices->setValue($this->model->makeServices);
	$checkboxMakeServices->setLabel($translate->_('Create Support for webEdition-Services and the Pattern-Service'));
	$rowGeneral->addElement($checkboxMakeServices);
	
	$checkboxMakePerms = new we_ui_controls_Checkbox();
	$checkboxMakePerms->setId('makePerms');
	$checkboxMakePerms->setName('makePerms');
	$checkboxMakePerms->setOnClick('weEventController.fire("docChanged")');
	$checkboxMakePerms->setChecked(($this->model->makePerms) ? true : false);
	$checkboxMakePerms->setValue($this->model->makePerms);
	$checkboxMakePerms->setLabel($translate->_('Create Support for webEdition-Permissions and the Pattern-Permission'));
	$rowGeneral->addElement($checkboxMakePerms);
	
	$checkboxMakeBackup = new we_ui_controls_Checkbox();
	$checkboxMakeBackup->setId('makeBackup');
	$checkboxMakeBackup->setName('makeBackup');
	$checkboxMakeBackup->setOnClick('weEventController.fire("docChanged")');
	$checkboxMakeBackup->setChecked(($this->model->makeBackup) ? true : false);
	$checkboxMakeBackup->setValue($this->model->makeBackup);
	$checkboxMakeBackup->setLabel($translate->_('Create Support for webEdition-Backupsystem'));
	$rowGeneral->addElement($checkboxMakeBackup);
}

// create div for content of property tab
$propertyTab = new we_ui_layout_Div(array('id'=>'idPropertyTab'));

$tableGeneral = new we_ui_layout_HeadlineIconTable();
$tableGeneral->setId('tab_1');
$tableGeneral->setMarginLeft(30);
$tableGeneral->setRows(array($rowGeneral));

$propertyTab->addElement($tableGeneral);

if(!empty($this->model->ID)) {
	$rowTags = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('Tags')));
	$html = '';
	foreach ($this->model->tags as $_tag=>$_incfile) {
		$html .= '<strong>'. $_tag .'</strong>';
		$html .= '<br/>';
		$html .= str_replace($_SERVER['DOCUMENT_ROOT'] ,'',$_incfile);
		$html .= '<br/><br/>';
	}
	$rowTags->addHTML($html);
	$tableTags = new we_ui_layout_HeadlineIconTable();
	$tableTags->setId('tabTags');
	$tableTags->setMarginLeft(30);
	$tableTags->setRows(array($rowTags));
	$propertyTab->addElement($tableTags);
	
	$rowServices = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('Services')));
	$html = '';
	foreach ($this->model->services as $_service=>$_incfile) {
		$html .= '<strong>'. $_service .'</strong>';
		$html .= '<br/>';
		$html .= str_replace($_SERVER['DOCUMENT_ROOT'] ,'',$_incfile);
		$html .= '<br/><br/>';
	}
	$rowServices->addHTML($html);
	$tableServices = new we_ui_layout_HeadlineIconTable();
	$tableServices->setId('tabServices');
	$tableServices->setMarginLeft(30);
	$tableServices->setRows(array($rowServices));
	$propertyTab->addElement($tableServices);
	
	$rowLanguage = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('Language')));
	$html = '';
	foreach ($this->model->languages as $_lan=>$_incfile) {
		$html .= '<strong>'. $_lan .'</strong>';
		$html .= '<br/>';
		$html .= str_replace($_SERVER['DOCUMENT_ROOT'] ,'',$_incfile);
		$html .= '<br/><br/>';
	}
	$rowLanguage->addHTML($html);
	$tableLanguage = new we_ui_layout_HeadlineIconTable();
	$tableLanguage->setId('tabLanguage');
	$tableLanguage->setMarginLeft(30);
	$tableLanguage->setRows(array($rowLanguage));
	$propertyTab->addElement($tableLanguage);
	
	$rowPermissions = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('Permissions')));
	$html = '';
	foreach ($this->model->permissions as $_key=>$_value) {
		$html .= '<strong>'. $_key .'</strong>';
		$html .= '<br/>';
		$html .= $translate->_('default') . ':&nbsp;' . $_value;
		$html .= '<br/><br/>';
	}
	$rowPermissions->addHTML($html);
	$tablePermissions = new we_ui_layout_HeadlineIconTable();
	$tablePermissions->setId('tabPermissions');
	$tablePermissions->setMarginLeft(30);
	$tablePermissions->setRows(array($rowPermissions));
	$propertyTab->addElement($tablePermissions);
	
	$rowBackupTable = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('Backup table')));
	$html = '';
	foreach ($this->model->backupTables as $_table) {
		$html .= $_table;
		$html .= '<br/>';
	}
	$rowBackupTable->addHTML($html);
	$tableBackupTable = new we_ui_layout_HeadlineIconTable();
	$tableBackupTable->setId('tabBackupTable');
	$tableBackupTable->setMarginLeft(30);
	$tableBackupTable->setRows(array($rowBackupTable));
	$propertyTab->addElement($tableBackupTable);
}



$form->addElement($propertyTab);

$tabNr = isset($_REQUEST['tabnr']) ? ($_REQUEST['tabnr']) : 1;

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->addJSFile('/webEdition/js/windows.js');
$htmlPage->addJSFile('/webEdition/js/we_showMessage.js');
$htmlPage->addJSFile('/webEdition/js/images.js');
$htmlPage->addJSFile('/webEdition/js/libs/yui/yahoo-min.js');
$htmlPage->addJSFile('/webEdition/js/libs/yui/event-min.js');
$htmlPage->addJSFile('/webEdition/js/libs/yui/connection-min.js');
$htmlPage->addJSFile('/webEdition/js/libs/yui/json-min.js');
$htmlPage->addJSFile('/webEdition/lib/we/core/JsonRpc.js');


$filenameEmptyMessage = we_util_Strings::quoteForJSString($translate->_('The name must not be empty!'), false);
$filenameEmptyMessageCall = we_core_MessageReporting::getShowMessageCall(
				$filenameEmptyMessage, 
				we_core_MessageReporting::kMessageWarning
	);
	
$classnameEmptyMessage = we_util_Strings::quoteForJSString($translate->_('The name of the model class could not be empty!'), false);
$classnameEmptyMessageCall = we_core_MessageReporting::getShowMessageCall(
				$classnameEmptyMessage, 
				we_core_MessageReporting::kMessageWarning
	);

$noTablenameMessage = we_util_Strings::quoteForJSString($translate->_('The tablename is missing.'), false);
$noTablenameMessageCall = we_core_MessageReporting::getShowMessageCall(
			$noTablenameMessage, 
			we_core_MessageReporting::kMessageWarning
	);


$js = '

function submitForm(target, action, method) {
	
	var f = self.document.we_form;
	if (target) {
		f.target = target;
	}

	if (action) {
		f.action = action;
	}

	if (method) {
		f.method = method;
	}
	
	f.submit();
}


/* update id hidden field */
function __updateIdEventHandler__(data, sender) {
	var form = document.we_form;
	form.ID.value = data.model.ID;
}
weEventController.register("save", __updateIdEventHandler__);


weCmdController.register("save_body", "app_'.$appName.'_save", null, self, function(cmdObj) 
{

	var form = document.we_form;
		
	if (form.Text.value === "") {
		'. $filenameEmptyMessageCall . '
		form.Text.focus();
		form.Text.select();
		return false;
	}
	
	if (form.classname.value === "") {
		'. $classnameEmptyMessageCall . '
		form.classname.focus();
		form.classname.select();
		return false;
	}

	if (form.datasource.value=="table:" && form.maintable.value=="") {
		'.$noTablenameMessageCall.'
		form.maintable.focus();
		form.maintable.select();
		return false;
	}


	return true;
});

YAHOO.util.Event.addListener(window, "unload", function(e){
	weCmdController.unregister("save_body");
	weEventController.unregister("save", __updateIdEventHandler__);
}); 

function setClassField(classname) {

	var form = document.we_form;
	var newClassname = classname.toLowerCase();
	newClassname = newClassname.replace(/[^a-z0-9]/g, \'\'); 
	var firstCharIsNum = false;
	if(newClassname!="") {
		firstCharIsNum = firstCharNum(newClassname);
	}
	if(firstCharIsNum) {
		newClassname = newClassname.replace(/[^a-z]/g, \'\'); 
	}
	form.classname.value = newClassname;
}

function firstCharNum(str) {

   var numbers = "0123456789";
   var IsNumber=true;
   var char;

   char = str.charAt(0); 
   if (numbers.indexOf(char) == -1) {
       IsNumber = false;
   }

   return IsNumber;
}


';

$cssLoadingWheel = '
.weLoadingWheelDiv {
	display:block;
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:100%;
	opacity:0.75;
	filter:alpha(opacity=75);
	background-color:#EDEDED;
	background-position:center center;
	background-repeat:no-repeat;
	text-align:center;
	margin:0px;
	padding:0px;
}
.weLoadingWheel {
	position:absolute;
	top:50%;
	left:50%;
	width:20px;
	height:19px;
}
';

$containerDiv = new we_ui_layout_Div();
$containerDiv->setId('containerDivBody');

$containerDiv->addElement($form);

$htmlPage->addElement($containerDiv);

$htmlPage->addInlineJS($js);
$htmlPage->setBodyAttributes(array('class' => 'weEditorBody', 'onLoad' => 'loaded=1;'));
$htmlPage->addJSFile('/webEdition/js/we_showMessage.js');

$htmlPage->addInlineCSS($cssLoadingWheel);


echo $htmlPage->getHTML();

