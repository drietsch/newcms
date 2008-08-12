<?php
					
$translate = we_core_Local::addTranslation('apps.xml');
we_core_Local::addTranslation('default.xml', 'leer');

include_once ('meta.conf.php');

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');

$we_menu_leer['000100']['text'] = $translate->_('leer');
$we_menu_leer['000100']['parent'] = '000000';
$we_menu_leer['000100']['perm'] = '';
$we_menu_leer['000100']['enabled'] = '1';

$we_menu_leer['000200']['text'] = $translate->_('New');
$we_menu_leer['000200']['parent'] = '000100';
$we_menu_leer['000200']['perm'] = '';
$we_menu_leer['000200']['enabled'] = '1';

$we_menu_leer['000300']['text'] = $translate->_('New Entry');
$we_menu_leer['000300']['parent'] = '000200';
$we_menu_leer['000300']['cmd'] = 'app_' . $appName . '_new';
$we_menu_leer['000300']['perm'] = 'NEW_APP_LEER || ADMINISTRATOR';
$we_menu_leer['000300']['enabled'] = '1';

$we_menu_leer['000400']['text'] = $translate->_('New Folder');
$we_menu_leer['000400']['parent'] = '000200';
$we_menu_leer['000400']['cmd'] = 'app_' . $appName . '_new_folder';
$we_menu_leer['000400']['perm'] = 'NEW_APP_LEER || ADMINISTRATOR';
$we_menu_leer['000400']['enabled'] = '1';

$we_menu_leer['000500']['text'] = $translate->_('Save');
$we_menu_leer['000500']['parent'] = '000100';
$we_menu_leer['000500']['cmd'] = 'app_' . $appName . '_save';
$we_menu_leer['000500']['perm'] = 'EDIT_APP_LEER || ADMINISTRATOR';
$we_menu_leer['000500']['enabled'] = '1';

$we_menu_leer['000600']['text'] = $translate->_('Delete');
$we_menu_leer['000600']['parent'] = '000100';
$we_menu_leer['000600']['cmd'] = 'app_' . $appName . '_delete';
$we_menu_leer['000600']['perm'] = 'DELETE_APP_LEER || ADMINISTRATOR';
$we_menu_leer['000600']['enabled'] = '1';

$we_menu_leer['000950']['parent'] = '000100'; // separator


$we_menu_leer['001000']['text'] = $translate->_('Close');
$we_menu_leer['001000']['parent'] = '000100';
$we_menu_leer['001000']['cmd'] = 'app_' . $appName . '_exit';
$we_menu_leer['001000']['perm'] = '';
$we_menu_leer['001000']['enabled'] = '1';

$we_menu_leer['003000']['text'] = $translate->_('Help');
$we_menu_leer['003000']['parent'] = '000000';
$we_menu_leer['003000']['perm'] = '';
$we_menu_leer['003000']['enabled'] = '1';

$we_menu_leer['003100']['text'] = $translate->_('Help') . '...';
$we_menu_leer['003100']['parent'] = '003000';
$we_menu_leer['003100']['cmd'] = 'app_' . $appName . '_help';
$we_menu_leer['003100']['perm'] = '';
$we_menu_leer['003100']['enabled'] = '1';

$we_menu_leer['003200']['text'] = $translate->_('Info') . '...';
$we_menu_leer['003200']['parent'] = '003000';
$we_menu_leer['003200']['cmd'] = 'app_' . $appName . '_info';
$we_menu_leer['003200']['perm'] = '';
$we_menu_leer['003200']['enabled'] = '1';

		?>