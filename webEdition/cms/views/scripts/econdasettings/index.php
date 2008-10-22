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
 * @package    webEdition_cms
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

// alerts a message and exits when a user is not logged in or when the session is expired
we_core_Permissions::protect();

$translate = we_core_Local::addTranslation('econda.xml');

$htmlPage = we_ui_dialog_OkCancelDialog::getInstance();
$htmlPage->addJSFile('/webEdition/js/windows.js');
$htmlPage->setTopClose(false);
$htmlPage->setTitle($translate->_("Econda Settings"));
$htmlPage->setHeadline($translate->_("Econda Settings"));

$htmlPage->addInlineCSS('
body { 
	padding:10px !important;
}
');

// show econda infos
$info = new we_ui_layout_NoteDiv();
$info->setType("info");
$info->addHTML($translate->_('EcondaDialogInfo'));
$htmlPage->addElement($info);

if (we_core_Permissions::hasPerm("ADMINISTRATOR")) {
	// show settings dialog only for admins
	
	$htmlPage->setOkAction("submitForm('we_form')"); // do on ok clicked 
	
	// set form
	$form = new we_ui_layout_Form(); 
	$form->setName('we_form'); 
	$form->setEnctype("multipart/form-data");
	$form->setOnSubmit('return false');  
	$form->setMethod('post'); 
	$form->setAction($GLOBALS['__WE_CMS_URL__'] . '/index.php/econdasettings/safeupload'); 
	$form->setTitle("test form");
	
	// set checkbox for activate econda and add to form
	$checkbox = new we_ui_controls_Checkbox();
	$checkbox->setChecked($this->activateEconda == '1' ? true : false);
	$checkbox->setName('activate');
	$checkbox->setLabel('<nobr>'.$translate->_('activate ECONDA').'</nobr>');
	$checkbox->setHidden(false);
	$checkbox->setDisabled(false);
	$checkbox->setWidth(100);
	$checkbox->setTitle('Title');
	$form->addElement($checkbox);
	$form->addHTML("<br />");
	
	// set autocompleter for parent path of the econda file
	$label = new we_ui_controls_Label();
	$label->setText($translate->_('Directory'));
	$form->addElement($label);
	$ac = new we_ui_controls_ACFileSelector();
	$ac->setId("emos");
	$ac->setButtonText('Select');
	$ac->setButtonTitle('Select');
	$ac->setFolderIdName("econdaParentId");
	$ac->setFolderIdValue($this->econdaParentId);
	$ac->setFolderPathName("econdaParentPath");
	$ac->setFolderPathValue($this->econdaParentPath);
	$ac->setTable('tblfile');
	$ac->setContentType('folder');
	$ac->setWidth(333);
	$ac->setScope($htmlPage);
	$ac->setMayBeEmpty(true);
	$form->addElement($ac);
	$form->addHTML("<br />");

	// show econda file name
	$label = new we_ui_controls_Label();
	$label->setText($translate->_('ECONDA File'));
	$form->addElement($label);
	$div = new we_ui_layout_Div();
	$div->addHTML($this->econdaFileName);
	$form->addElement($div);
	$form->addHTML("<br />");

	// set upload field for econda file
	$label = new we_ui_controls_Label();
	$label->setText($translate->_('Upload ECONDA JS file'));
	$form->addElement($label);
	$form->addHTML("<input type='file' size='46' style='width:504px;' accept='text/javascript' name='emosfile'>");
	$form->addHTML("<br />");
	$form->addHTML("<br />");
	
	// add js for messaging, submit form and close dialog on seccess
	$inlineJS = "";	
	if (isset($this->msg)) {
		switch ($this->prio){
			case 4:
				$inlineJS .= "top.opener.top.showMessage('".$this->msg."', ".$this->prio.", window);\n";
				break;
			case '-1':
				$inlineJS .= "top.opener.top.drawTree();\n";
				$inlineJS .= 'top.opener.top.showMessage("'.addslashes($this->msg).'", "-1", window);'."\n";
				$inlineJS .= "top.close();\n";
		}
	}
	$htmlPage->addInlineJs('
function submitForm(formName){
	document.forms[formName].submit();
}
'.$inlineJS);
	$htmlPage->addElement($form);
	
} else {
	
	// show info for none admins
	$noperm = new we_ui_layout_NoteDiv();
	$noperm->setType("alert");
	$noperm->addHTML($this->msg);
	$htmlPage->addElement($noperm);
}


print $htmlPage->getHTML();

