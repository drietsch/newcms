<?php

$translate = we_core_Local::addTranslation('apps.xml');
we_core_Local::addTranslation('default.xml', 'toolfactory');


include_once ('meta.conf.php');

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');

$we_menu_toolfactory['000100']['text'] = $translate->_('toolfactory');
$we_menu_toolfactory['000100']['parent'] = '000000';
$we_menu_toolfactory['000100']['perm'] = '';
$we_menu_toolfactory['000100']['enabled'] = '1';

$we_menu_toolfactory['000200']['text'] = $translate->_('New Entry');
$we_menu_toolfactory['000200']['parent'] = '000100';
$we_menu_toolfactory['000200']['cmd'] = 'app_' . $appName . '_new';
$we_menu_toolfactory['000200']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_toolfactory['000200']['enabled'] = '1';

$we_menu_toolfactory['000800']['parent'] = '000100'; // separator

$we_menu_toolfactory['001000']['text'] = $translate->_('Close');
$we_menu_toolfactory['001000']['parent'] = '000100';
$we_menu_toolfactory['001000']['cmd'] = 'app_' . $appName . '_exit';
$we_menu_toolfactory['001000']['perm'] = '';
$we_menu_toolfactory['001000']['enabled'] = '1';

$we_menu_toolfactory['003000']['text'] = $translate->_('Help');
$we_menu_toolfactory['003000']['parent'] = '000000';
$we_menu_toolfactory['003000']['perm'] = '';
$we_menu_toolfactory['003000']['enabled'] = '1';

$we_menu_toolfactory['003100']['text'] = $translate->_('Help') . '...';
$we_menu_toolfactory['003100']['parent'] = '003000';
$we_menu_toolfactory['003100']['cmd'] = 'app_' . $appName . '_help';
$we_menu_toolfactory['003100']['perm'] = '';
$we_menu_toolfactory['003100']['enabled'] = '1';

$we_menu_toolfactory['003200']['text'] = $translate->_('Info') . '...';
$we_menu_toolfactory['003200']['parent'] = '003000';
$we_menu_toolfactory['003200']['cmd'] = 'app_' . $appName . '_info';
$we_menu_toolfactory['003200']['perm'] = '';
$we_menu_toolfactory['003200']['enabled'] = '1';
?>