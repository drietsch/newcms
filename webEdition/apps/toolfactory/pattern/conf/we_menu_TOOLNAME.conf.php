
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
include_once ('meta.conf.php');

$translate = we_core_Local::addTranslation('apps.xml');
we_core_Local::addTranslation('default.xml', '<?php print $TOOLNAME; ?>');

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');

$_tool = weToolLookup::getToolProperties($appName);

$we_menu_<?php print $TOOLNAME; ?>['000100']['text'] = we_util_Strings::shortenPath($_tool['text'], 40);
$we_menu_<?php print $TOOLNAME; ?>['000100']['parent'] = '000000';
$we_menu_<?php print $TOOLNAME; ?>['000100']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['000100']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000200']['text'] = $translate->_('New');
$we_menu_<?php print $TOOLNAME; ?>['000200']['parent'] = '000100';
$we_menu_<?php print $TOOLNAME; ?>['000200']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['000200']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000300']['text'] = $translate->_('New Entry');
$we_menu_<?php print $TOOLNAME; ?>['000300']['parent'] = '000200';
$we_menu_<?php print $TOOLNAME; ?>['000300']['cmd'] = 'app_' . $appName . '_new';
$we_menu_<?php print $TOOLNAME; ?>['000300']['perm'] = 'NEW_APP_<?php print strtoupper($TOOLNAME); ?> || ADMINISTRATOR';
$we_menu_<?php print $TOOLNAME; ?>['000300']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000400']['text'] = $translate->_('New Folder');
$we_menu_<?php print $TOOLNAME; ?>['000400']['parent'] = '000200';
$we_menu_<?php print $TOOLNAME; ?>['000400']['cmd'] = 'app_' . $appName . '_new_folder';
$we_menu_<?php print $TOOLNAME; ?>['000400']['perm'] = 'NEW_APP_<?php print strtoupper($TOOLNAME); ?> || ADMINISTRATOR';
$we_menu_<?php print $TOOLNAME; ?>['000400']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000500']['text'] = $translate->_('Save');
$we_menu_<?php print $TOOLNAME; ?>['000500']['parent'] = '000100';
$we_menu_<?php print $TOOLNAME; ?>['000500']['cmd'] = 'app_' . $appName . '_save';
$we_menu_<?php print $TOOLNAME; ?>['000500']['perm'] = 'EDIT_APP_<?php print strtoupper($TOOLNAME); ?> || ADMINISTRATOR';
$we_menu_<?php print $TOOLNAME; ?>['000500']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000600']['text'] = $translate->_('Delete');
$we_menu_<?php print $TOOLNAME; ?>['000600']['parent'] = '000100';
$we_menu_<?php print $TOOLNAME; ?>['000600']['cmd'] = 'app_' . $appName . '_delete';
$we_menu_<?php print $TOOLNAME; ?>['000600']['perm'] = 'DELETE_APP_<?php print strtoupper($TOOLNAME); ?> || ADMINISTRATOR';
$we_menu_<?php print $TOOLNAME; ?>['000600']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['000950']['parent'] = '000100'; // separator

$we_menu_<?php print $TOOLNAME; ?>['001000']['text'] = $translate->_('Close');
$we_menu_<?php print $TOOLNAME; ?>['001000']['parent'] = '000100';
$we_menu_<?php print $TOOLNAME; ?>['001000']['cmd'] = 'app_' . $appName . '_exit';
$we_menu_<?php print $TOOLNAME; ?>['001000']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['001000']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['003000']['text'] = $translate->_('Help');
$we_menu_<?php print $TOOLNAME; ?>['003000']['parent'] = '000000';
$we_menu_<?php print $TOOLNAME; ?>['003000']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['003000']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['003100']['text'] = $translate->_('Help') . '...';
$we_menu_<?php print $TOOLNAME; ?>['003100']['parent'] = '003000';
$we_menu_<?php print $TOOLNAME; ?>['003100']['cmd'] = 'app_' . $appName . '_help';
$we_menu_<?php print $TOOLNAME; ?>['003100']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['003100']['enabled'] = '1';

$we_menu_<?php print $TOOLNAME; ?>['003200']['text'] = $translate->_('Info') . '...';
$we_menu_<?php print $TOOLNAME; ?>['003200']['parent'] = '003000';
$we_menu_<?php print $TOOLNAME; ?>['003200']['cmd'] = 'app_' . $appName . '_info';
$we_menu_<?php print $TOOLNAME; ?>['003200']['perm'] = '';
$we_menu_<?php print $TOOLNAME; ?>['003200']['enabled'] = '1';
