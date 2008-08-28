<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_messaging.inc.php");

	$we_menu_messaging['000100']['text'] = $l_javaMenu["messaging"]["file"];
	$we_menu_messaging['000100']['parent'] = '000000';
	$we_menu_messaging['000100']['enabled'] = '1';

    $we_menu_messaging['000110']['text'] = $l_javaMenu["messaging"]["new"];
    $we_menu_messaging['000110']['parent'] = '000100';
    $we_menu_messaging['000110']['enabled'] = '1';

	$we_menu_messaging['000111']['text'] = $l_javaMenu["messaging"]["message"] . "...";
	$we_menu_messaging['000111']['cmd'] = 'messaging_new_message';
	$we_menu_messaging['000111']['parent'] = '000110';
	$we_menu_messaging['000111']['enabled'] = '1';

	$we_menu_messaging['000112']['text'] = $l_javaMenu["messaging"]["todo"] . "...";
	$we_menu_messaging['000112']['cmd'] = 'messaging_new_todo';
	$we_menu_messaging['000112']['parent'] = '000110';
	$we_menu_messaging['000112']['enabled'] = '1';

	$we_menu_messaging['000113']['text'] = $l_javaMenu["messaging"]["folder"];
	$we_menu_messaging['000113']['cmd'] = 'messaging_new_folder';
	$we_menu_messaging['000113']['parent'] = '000110';
	$we_menu_messaging['000113']['enabled'] = '1';

    $we_menu_messaging['000120']['text'] = $l_javaMenu["messaging"]["delete"];
    $we_menu_messaging['000120']['parent'] = '000100';
    $we_menu_messaging['000120']['enabled'] = '1';

	$we_menu_messaging['000122']['text'] = $l_javaMenu["messaging"]["folder"];
	$we_menu_messaging['000122']['cmd'] = 'messaging_delete_mode_on';
	$we_menu_messaging['000122']['parent'] = '000120';
	$we_menu_messaging['000122']['enabled'] = '1';

    $we_menu_messaging['000190']['text'] = $l_javaMenu["messaging"]["quit"];
    $we_menu_messaging['000190']['cmd'] = 'messaging_exit';
    $we_menu_messaging['000190']['parent'] = '000100';
    $we_menu_messaging['000190']['enabled'] = '1';


	$we_menu_messaging['000200']['text'] = $l_javaMenu["messaging"]["edit"];
	$we_menu_messaging['000200']['parent'] = '000000';
	$we_menu_messaging['000200']['enabled'] = '1';

    $we_menu_messaging['000220']['text'] = $l_javaMenu["messaging"]["folder"];
    $we_menu_messaging['000220']['cmd'] = 'messaging_edit_folder';
    $we_menu_messaging['000220']['parent'] = '000200';
    $we_menu_messaging['000220']['enabled'] = '1';

    $we_menu_messaging['000230']['text'] = $l_javaMenu["messaging"]["settings"] . "...";
    $we_menu_messaging['000230']['cmd'] = 'messaging_settings';
    $we_menu_messaging['000230']['parent'] = '000200';
    $we_menu_messaging['000230']['enabled'] = '1';

    $we_menu_messaging['000240']['text'] = $l_javaMenu["messaging"]["copy"];
    $we_menu_messaging['000240']['cmd'] = 'messaging_copy';
    $we_menu_messaging['000240']['parent'] = '000200';
    $we_menu_messaging['000240']['enabled'] = '1';

    $we_menu_messaging['000250']['text'] = $l_javaMenu["messaging"]["cut"];
    $we_menu_messaging['000250']['cmd'] = 'messaging_cut';
    $we_menu_messaging['000250']['parent'] = '000200';
    $we_menu_messaging['000250']['enabled'] = '1';

    $we_menu_messaging['000260']['text'] = $l_javaMenu["messaging"]["paste"];
    $we_menu_messaging['000260']['cmd'] = 'messaging_paste';
    $we_menu_messaging['000260']['parent'] = '000200';
    $we_menu_messaging['000260']['enabled'] = '1';


	$we_menu_messaging["000300"]["text"]= $l_javaMenu["messaging"]["help"];
    $we_menu_messaging["000300"]["parent"] = "000000";
    $we_menu_messaging["000300"]["enabled"] = "1";

    $we_menu_messaging["000310"]["text"]= $l_javaMenu["messaging"]["help"]."...";
    $we_menu_messaging["000310"]["parent"] = "000300";
    $we_menu_messaging["000310"]["cmd"] = "help";
    $we_menu_messaging["000310"]["enabled"] = "1";

    $we_menu_messaging["000320"]["text"]= $l_javaMenu["messaging"]["info"]."...";
    $we_menu_messaging["000320"]["parent"] = "000300";
    $we_menu_messaging["000320"]["cmd"] = "info";
    $we_menu_messaging["000320"]["enabled"] = "1";
?>