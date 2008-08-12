<?php
					
include_once('meta.conf.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/language/language_' . $GLOBALS['WE_LANGUAGE'] . '.inc.php');


$we_menu_abc['000100']['text'] = $GLOBALS['l_' . $metaInfo['name']]['abc'];
$we_menu_abc['000100']['parent'] = '000000';
$we_menu_abc['000100']['perm'] = '';
$we_menu_abc['000100']['enabled'] = '1';

$we_menu_abc['000200']['text'] = $GLOBALS['l_tools']['menu_new'];
$we_menu_abc['000200']['parent'] = '000100';
$we_menu_abc['000200']['perm'] = '';
$we_menu_abc['000200']['enabled'] = '1';

$we_menu_abc['000300']['text'] = $GLOBALS['l_tools']['menu_new_entry'];
$we_menu_abc['000300']['parent'] = '000200';
$we_menu_abc['000300']['cmd'] = 'tool_' . $metaInfo['name'] .  '_new';
$we_menu_abc['000300']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_abc['000300']['enabled'] = '1';

$we_menu_abc['000400']['text'] = $GLOBALS['l_tools']['menu_new_group'];
$we_menu_abc['000400']['parent'] = '000200';
$we_menu_abc['000400']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_group';
$we_menu_abc['000400']['perm'] = 'EDIT_abc || ADMINISTRATOR';
$we_menu_abc['000400']['enabled'] = '1';

$we_menu_abc['000500']['text'] = $GLOBALS['l_tools']['menu_save'];
$we_menu_abc['000500']['parent'] = '000100';
$we_menu_abc['000500']['cmd'] = 'tool_' . $metaInfo['name'] . '_save';
$we_menu_abc['000500']['perm'] = 'EDIT_abc || ADMINISTRATOR';
$we_menu_abc['000500']['enabled'] = '1';

$we_menu_abc['000600']['text'] = $GLOBALS['l_tools']['menu_delete'];
$we_menu_abc['000600']['parent'] = '000100';
$we_menu_abc['000600']['cmd'] = 'tool_' . $metaInfo['name'] . '_delete';
$we_menu_abc['000600']['perm'] = 'EDIT_abc || ADMINISTRATOR';
$we_menu_abc['000600']['enabled'] = '1';

$we_menu_abc['000950']['parent'] = '000100'; // separator

$we_menu_abc['001000']['text'] = $GLOBALS['l_tools']['menu_exit'];
$we_menu_abc['001000']['parent'] = '000100';
$we_menu_abc['001000']['cmd'] = 'tool_' . $metaInfo['name'] .  '_exit';
$we_menu_abc['001000']['perm'] = '';
$we_menu_abc['001000']['enabled'] = '1';

$we_menu_abc['003000']['text'] = $GLOBALS['l_tools']['menu_help'];
$we_menu_abc['003000']['parent'] = '000000';
$we_menu_abc['003000']['perm'] = '';
$we_menu_abc['003000']['enabled'] = '1';

$we_menu_abc['003100']['text'] = $GLOBALS['l_tools']['menu_help'].'...';
$we_menu_abc['003100']['parent'] = '003000';
$we_menu_abc['003100']['cmd'] = 'help';
$we_menu_abc['003100']['perm'] = '';
$we_menu_abc['003100']['enabled'] = '1';

$we_menu_abc['003200']['text'] = $GLOBALS['l_tools']['menu_info'].'...';
$we_menu_abc['003200']['parent'] = '003000';
$we_menu_abc['003200']['cmd'] = 'info';
$we_menu_abc['003200']['perm'] = '';
$we_menu_abc['003200']['enabled'] = '1';
		?>