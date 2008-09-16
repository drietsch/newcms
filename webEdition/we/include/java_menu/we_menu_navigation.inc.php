<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php');


$we_menu_navigation['000100']['text'] =$GLOBALS['l_navigation']['navigation'];
$we_menu_navigation['000100']['parent'] = '000000';
$we_menu_navigation['000100']['perm'] = '';
$we_menu_navigation['000100']['enabled'] = '1';

$we_menu_navigation['000200']['text'] = $GLOBALS['l_navigation']['menu_new'];
$we_menu_navigation['000200']['parent'] = '000100';
$we_menu_navigation['000200']['perm'] = '';
$we_menu_navigation['000200']['enabled'] = '1';

$we_menu_navigation['000300']['text'] = $GLOBALS['l_navigation']['entry'];
$we_menu_navigation['000300']['parent'] = '000200';
$we_menu_navigation['000300']['cmd'] = 'new_navigation';
$we_menu_navigation['000300']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_navigation['000300']['enabled'] = '1';

$we_menu_navigation['000400']['text'] = $GLOBALS['l_navigation']['group'];
$we_menu_navigation['000400']['parent'] = '000200';
$we_menu_navigation['000400']['cmd'] = 'new_navigation_group';
$we_menu_navigation['000400']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_navigation['000400']['enabled'] = '1';

$we_menu_navigation['000500']['text'] = $GLOBALS['l_navigation']['menu_save'];
$we_menu_navigation['000500']['parent'] = '000100';
$we_menu_navigation['000500']['cmd'] = 'save_navigation';
$we_menu_navigation['000500']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_navigation['000500']['enabled'] = '1';

$we_menu_navigation['000600']['text'] = $GLOBALS['l_navigation']['menu_delete'];
$we_menu_navigation['000600']['parent'] = '000100';
$we_menu_navigation['000600']['cmd'] = 'delete_navigation';
$we_menu_navigation['000600']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_navigation['000600']['enabled'] = '1';

$we_menu_navigation['000950']['parent'] = '000100'; // separator

$we_menu_navigation['001000']['text'] = $GLOBALS['l_navigation']['menu_exit'];
$we_menu_navigation['001000']['parent'] = '000100';
$we_menu_navigation['001000']['cmd'] = 'exit_navigation';
$we_menu_navigation['001000']['perm'] = '';
$we_menu_navigation['001000']['enabled'] = '1';
/*
$we_menu_navigation['001500']['text'] = $GLOBALS['l_navigation']['menu_options'];
$we_menu_navigation['001500']['parent'] = '000000';
$we_menu_navigation['001500']['perm'] = '';
$we_menu_navigation['001500']['enabled'] = '1';

$we_menu_navigation['001600']['text'] = $GLOBALS['l_navigation']['menu_generate'].'...';
$we_menu_navigation['001600']['parent'] = '001500';
$we_menu_navigation['001600']['cmd'] = 'generate_navigation';
$we_menu_navigation['001600']['perm'] = '';
$we_menu_navigation['001600']['enabled'] = '1';

$we_menu_navigation['001700']['text'] = $GLOBALS['l_navigation']['menu_settings'];
$we_menu_navigation['001700']['parent'] = '001500';
$we_menu_navigation['001700']['cmd'] = 'settings_navigation';
$we_menu_navigation['001700']['perm'] = '';
$we_menu_navigation['001700']['enabled'] = '1';*/

$we_menu_navigation['002000']['text'] = $GLOBALS['l_navigation']['menu_options'];
$we_menu_navigation['002000']['parent'] = '000000';
$we_menu_navigation['002000']['perm'] = '';
$we_menu_navigation['002000']['enabled'] = '1';

$we_menu_navigation['002100']['text'] = $GLOBALS['l_navigation']['menu_highlight_rules'];
$we_menu_navigation['002100']['parent'] = '002000';
$we_menu_navigation['002100']['perm'] = '';
$we_menu_navigation['002100']['cmd'] = 'navigation_rules';
$we_menu_navigation['002100']['enabled'] = '1';

$we_menu_navigation['003000']['text'] = $GLOBALS['l_navigation']['menu_help'];
$we_menu_navigation['003000']['parent'] = '000000';
$we_menu_navigation['003000']['perm'] = '';
$we_menu_navigation['003000']['enabled'] = '1';

$we_menu_navigation['003100']['text'] = $GLOBALS['l_navigation']['menu_help'].'...';
$we_menu_navigation['003100']['parent'] = '003000';
$we_menu_navigation['003100']['cmd'] = 'help_navigation';
$we_menu_navigation['003100']['perm'] = '';
$we_menu_navigation['003100']['enabled'] = '1';

$we_menu_navigation['003200']['text'] = $GLOBALS['l_navigation']['menu_info'].'...';
$we_menu_navigation['003200']['parent'] = '003000';
$we_menu_navigation['003200']['cmd'] = 'info';
$we_menu_navigation['003200']['perm'] = '';
$we_menu_navigation['003200']['enabled'] = '1';

?>