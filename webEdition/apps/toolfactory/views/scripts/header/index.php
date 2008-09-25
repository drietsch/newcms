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

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');
$appDir = $controller->getParam('appDir');

//	Include the menu config
include ($appName . '/conf/we_menu_' . $appName . '.conf.php');
		
$lang_arr = 'we_menu_' . $appName;

$menu = new we_ui_controls_JavaMenu(array(
	'entries'   => $$lang_arr,
	'width'     => 350,
	'height'    => 30,
	'cmdURL'    => $appDir . '/index.php/cmd/menu/name/',
	'cmdTarget'	=> 'cmd_' . $appName
));
		
$messageConsole = new we_ui_controls_MessageConsole(array('consoleName' => 'toolFrame'));
$table = new we_ui_layout_Table();
$table->setWidth('100%');

$table->addElement($menu, 0, 0);
$table->setCellAttributes(array('align' => 'left', 'valign' => 'top'));
$table->addElement($messageConsole, 1, 0);
$table->setCellAttributes(array('style'=>'padding-right:10px;', 'align' => 'right', 'valign' => 'bottom'));

$page = we_ui_layout_HTMLPage::getInstance();
$page->setBodyAttributes(array('class'=>'weMenuBody'));
$page->addElement($table);
		
// needed for menu !!
$page->addJSFile('/webEdition/js/attachKeyListener.js');

echo $page->getHTML();
