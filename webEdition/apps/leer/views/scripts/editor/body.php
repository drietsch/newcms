<?php
					

$appName = Zend_Controller_Front::getInstance()->getParam('appName');

$translate = we_core_Local::addTranslation('apps.xml');

$activTab = isset($_REQUEST['activTab']) ? ($_REQUEST['activTab']) : 'idPropertyTab';

$this->inputWidth = 400;

$form = new we_ui_layout_Form(array('name' => 'we_form', 'onsubmit' => 'return false', 'method' => 'post'));

$form->addHTML(we_ui_layout_Form::hidden('ID', $this->model->ID));
$form->addHTML(we_ui_layout_Form::hidden('activTab', $activTab));

$row = new we_ui_layout_HeadlineIconTableRow(array('title' => $translate->_('General')));

$label = new we_ui_controls_Label();
$label->setText($translate->_('Name'));
$label->setStyle('display:block;');
$input = new we_ui_controls_TextField();
$input->setName('Text');
$input->setValue($this->model->Text);
$input->setWidth($this->inputWidth);
$input->setOnChange('weEventController.fire("docChanged")');

$row->addElement($label);
$row->addElement($input);

$row->addElement(_setupDirChooser($this, $translate->_('Folder'), 'ParentID', 'ParentPath'));

$table = new we_ui_layout_HeadlineIconTable();
$table->setId('tab_1');
$table->setMarginLeft(30);
$table->setRows(array($row));

// create div for content of property tab
$propertyTab = new we_ui_layout_Div(array('id'=>'idPropertyTab'));
$propertyTab->addElement($table);
if($activTab!="idPropertyTab") {
	$propertyTab->setHidden(true);
}

$form->addElement($propertyTab);

$newTabText = $translate->_('This is a custom tab. You can either edit it or remove it.');

$newTab = new we_ui_layout_Div(array('id'=>'idNewTab'));
$newTab->setStyle('margin:20px;');
$newTab->addHTML($newTabText);
if($activTab!="idNewTab") {
	$newTab->setHidden(true);
}

$form->addElement($newTab);


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
		
$folderNotValidMessage = we_util_Strings::quoteForJSString($translate->_('The folder could not be saved.'), false);
		
$folderNotValidMessageCall = we_core_MessageReporting::getShowMessageCall(
				$folderNotValidMessage, 
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

	var checkACFields = function() {
		if(YAHOO && YAHOO.autocoml && YAHOO.autocoml.checkACFields()) {
			if(YAHOO.autocoml.checkACFields().running) {
				setTimeout(function(){checkACFields(), 100});
				return false;
			}
			else {
				if(YAHOO.autocoml.checkACFields().valid==false) {
					'. $folderNotValidMessageCall . '
					return false;
				}
			}
		}	
		return true;
	}
		
	var acChecked = checkACFields();
	
	if(false===acChecked) {
		return acChecked;
	}

	
	return true;
});

YAHOO.util.Event.addListener(window, "unload", function(e){
	weCmdController.unregister("save_body");
	weEventController.unregister("save", __updateIdEventHandler__);
}); 

';

$htmlPage->addElement($form);

$htmlPage->addInlineJS($js);
$htmlPage->setBodyAttributes(array('class' => 'weEditorBody', 'onLoad' => 'loaded=1;'));
$htmlPage->addJSFile('/webEdition/js/we_showMessage.js');

echo $htmlPage->getHTML();


function _setupDirChooser($view, $title, $IDName = 'ID', $PathName = 'Path') {
	
	$translate = we_core_Local::addTranslation('apps.xml');
	
	$dbTable = $view->model->getTable();
	$parentID = $view->model->ParentID;
	
	$layoutTable = new we_ui_layout_Table();
	$path = '/';
	if (isset($parentID)) {
		$path = we_util_Path::id2Path($parentID,$dbTable);
		if($parentID==0) {
			$path = '/';
		}
	}
	
	$controller = Zend_Controller_Front::getInstance();
	
	$buttonText = $translate->_('Select');
	
	$label = new we_ui_controls_Label(array('text' => $title));
	$label->setText($title);
	$label->setStyle('margin-top:15px;display:block;');

	$layoutTable->addElement($label, 0, 0);
	$layoutTable->setStyle('margin-top:0px');
	
	$ac = new we_ui_controls_ACFileSelector();
	$ac->setButtonText($buttonText);
	$ac->setButtonTitle($buttonText);
	$ac->setFolderIdName($IDName);
	$ac->setFolderIdValue($parentID);
	$ac->setFolderPathName($PathName);
	$ac->setFolderPathValue($path);
	$ac->setTable($dbTable);
	$ac->setContentType('folder');
	$ac->setWidth($view->inputWidth);
	$ac->setOnChange('weEventController.fire("docChanged")');
	$ac->setAppName($controller->getParam('appName'));
	
	$layoutTable->addElement($ac);

	return $layoutTable;
}

		?>