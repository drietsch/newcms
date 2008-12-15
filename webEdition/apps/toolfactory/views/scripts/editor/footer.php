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