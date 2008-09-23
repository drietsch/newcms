<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

$translate = we_core_Local::addTranslation('apps.xml');

$page = we_ui_layout_HTMLPage::getInstance();

$saveButton = new we_ui_controls_Button(
	array(
		'text'		=> $translate->_('Save'), 
		'onClick'	=> 'weCmdController.fire({cmdName: "app_toolfactory_save"})', 
		'type'		=> 'onClick', 
		'width'		=> 100,
		'disabled'	=> !we_core_Permissions::hasPerm('EDIT_APP_TOOLFACTORY'),
		'style'		=> 'margin:9px 0 0 15px;'
	)
);


$page->setBodyAttributes(array('class'=>'weEditorFooter'));

if(empty($this->model->ID)) {
	$page->addElement($saveButton);
	
}

echo $page->getHTML();