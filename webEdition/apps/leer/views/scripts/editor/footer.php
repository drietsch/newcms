<?php
					

$translate = we_core_Local::addTranslation('apps.xml');

$page = we_ui_layout_HTMLPage::getInstance();

$saveButton = new we_ui_controls_Button(
	array(
		'text'		=> $translate->_('Save'), 
		'onClick'	=> 'weCmdController.fire({cmdName: "app_leer_save"})', 
		'type'		=> 'onClick', 
		'width'		=> 100,
		'disabled'	=> !we_core_Permissions::hasPerm('EDIT_APP_LEER'),
		'style'		=> 'margin:9px 0 0 15px;'
	)
);


$page->setBodyAttributes(array('class'=>'weEditorFooter'));
$page->addElement($saveButton);

echo $page->getHTML();

		?>