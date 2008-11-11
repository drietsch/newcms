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
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/newsletter.inc.php");
    
    $we_menu_newsletter["000100"]["text"]=$l_newsletter["newsletter"];
    $we_menu_newsletter["000100"]["parent"] = "000000";
    $we_menu_newsletter["000100"]["enabled"]  = "1";

	$we_menu_newsletter["000200"]["text"]= $l_newsletter["new"];
    $we_menu_newsletter["000200"]["parent"] = "000100";
    $we_menu_newsletter["000200"]["enabled"] = "0";
    
    $we_menu_newsletter["000230"]["text"]= $l_newsletter["newsletter"];
    $we_menu_newsletter["000230"]["cmd"] = "new_newsletter";
    $we_menu_newsletter["000230"]["perm"] = "NEW_NEWSLETTER || ADMINISTRATOR";
    $we_menu_newsletter["000230"]["parent"] = "000200";
    $we_menu_newsletter["000230"]["enabled"] = "0";
    
    $we_menu_newsletter["000260"]["text"]= $l_newsletter["group"];
    $we_menu_newsletter["000260"]["cmd"] = "new_newsletter_group";
    $we_menu_newsletter["000260"]["perm"] = "NEW_NEWSLETTER || ADMINISTRATOR";
    $we_menu_newsletter["000260"]["parent"] = "000200";
    $we_menu_newsletter["000260"]["enabled"] = "0";

    $we_menu_newsletter["000300"]["text"]= $l_newsletter["save"];
    $we_menu_newsletter["000300"]["parent"] = "000100";
    $we_menu_newsletter["000300"]["cmd"] = "save_newsletter";
    $we_menu_newsletter["000300"]["perm"] = "NEW_NEWSLETTER || EDIT_NEWSLETTER || ADMINISTRATOR";
    $we_menu_newsletter["000300"]["enabled"] = "0";

    $we_menu_newsletter["000400"]["text"]= $l_newsletter["delete"];
    $we_menu_newsletter["000400"]["parent"] = "000100";
    $we_menu_newsletter["000400"]["cmd"] = "delete_newsletter";
    $we_menu_newsletter["000400"]["perm"] = "DELETE_NEWSLETTER || ADMINISTRATOR";
    $we_menu_newsletter["000400"]["enabled"] = "0";

	 $we_menu_newsletter["000500"]["parent"] = "000100"; // separator

    $we_menu_newsletter["000600"]["text"]= $l_newsletter["send"]."...";
    $we_menu_newsletter["000600"]["parent"] = "000100";
    $we_menu_newsletter["000600"]["cmd"] = "send_newsletter";
    $we_menu_newsletter["000600"]["perm"] = "SEND_NEWSLETTER || ADMINISTRATOR";
    $we_menu_newsletter["000600"]["enabled"] = "0";	 

    $we_menu_newsletter["000700"]["parent"] = "000100"; // separator

    $we_menu_newsletter["000800"]["text"] = $l_newsletter["quit"];
    $we_menu_newsletter["000800"]["parent"] = "000100";
    $we_menu_newsletter["000800"]["cmd"] = "exit_newsletter";
    $we_menu_newsletter["000800"]["enabled"] = "1";

    $we_menu_newsletter["002000"]["text"] = $l_newsletter["options"];
    $we_menu_newsletter["002000"]["parent"] = "000000";
    $we_menu_newsletter["002000"]["enabled"] = "1";

    $we_menu_newsletter["002100"]["text"] = $l_newsletter["domain_check"]."...";
    $we_menu_newsletter["002100"]["parent"] = "002000";
    $we_menu_newsletter["002100"]["cmd"] = "domain_check";
    $we_menu_newsletter["002100"]["enabled"] = "1";

    $we_menu_newsletter["002200"]["text"] = $l_newsletter["lists_overview_menu"]."...";
    $we_menu_newsletter["002200"]["parent"] = "002000";
    $we_menu_newsletter["002200"]["cmd"] = "print_lists";
    $we_menu_newsletter["002200"]["enabled"] = "1";

    $we_menu_newsletter["002300"]["text"] = $l_newsletter["show_log"]."...";
    $we_menu_newsletter["002300"]["parent"] = "002000";
    $we_menu_newsletter["002300"]["cmd"] = "show_log";
    $we_menu_newsletter["002300"]["enabled"] = "1";

	 $we_menu_newsletter["002400"]["parent"] = "002000"; // separator

    $we_menu_newsletter["002500"]["text"] = $l_newsletter["newsletter_test"]."...";
    $we_menu_newsletter["002500"]["parent"] = "002000";
    $we_menu_newsletter["002500"]["cmd"] = "test_newsletter";
    $we_menu_newsletter["002500"]["enabled"] = "1";

    $we_menu_newsletter["002600"]["text"] = $l_newsletter["preview"]."...";
    $we_menu_newsletter["002600"]["parent"] = "002000";
    $we_menu_newsletter["002600"]["cmd"] = "preview_newsletter";
    $we_menu_newsletter["002600"]["enabled"] = "1";

    $we_menu_newsletter["002700"]["text"] = $l_newsletter["send_test"];
    $we_menu_newsletter["002700"]["parent"] = "002000";
    $we_menu_newsletter["002700"]["cmd"] = "send_test";
    $we_menu_newsletter["002700"]["perm"] = "SEND_TEST_EMAIL || ADMINISTRATOR";
    $we_menu_newsletter["002700"]["enabled"] = "0";

    $we_menu_newsletter["002800"]["text"] = $l_newsletter["search_email"];
    $we_menu_newsletter["002800"]["parent"] = "002000";
    $we_menu_newsletter["002800"]["cmd"] = "search_email";    
    $we_menu_newsletter["002800"]["enabled"] = "1";
    
    $we_menu_newsletter["002900"]["parent"] = "002000"; // separator	 
	
    $we_menu_newsletter["003000"]["text"] = $l_newsletter["edit_file"]."...";
    $we_menu_newsletter["003000"]["parent"] = "002000";
    $we_menu_newsletter["003000"]["cmd"] = "edit_file";
    $we_menu_newsletter["003000"]["enabled"] = "1";	 

    $we_menu_newsletter["003100"]["text"] = $l_newsletter["black_list"]."...";
    $we_menu_newsletter["003100"]["parent"] = "002000";
    $we_menu_newsletter["003100"]["cmd"] = "black_list";
    $we_menu_newsletter["003100"]["enabled"] = "1";	 

    $we_menu_newsletter["003200"]["text"] = $l_newsletter["clear_log"]."...";
    $we_menu_newsletter["003200"]["parent"] = "002000";
    $we_menu_newsletter["003200"]["cmd"] = "clear_log";
	$we_menu_newsletter["003200"]["perm"] = "NEWSLETTER_SETTINGS || ADMINISTRATOR";
    $we_menu_newsletter["003200"]["enabled"] = "1";

    $we_menu_newsletter["003300"]["text"] = $l_newsletter["settings"]."...";
    $we_menu_newsletter["003300"]["parent"] = "002000";
    $we_menu_newsletter["003300"]["cmd"] = "newsletter_settings";
	$we_menu_newsletter["003300"]["perm"] = "NEWSLETTER_SETTINGS || ADMINISTRATOR";
    $we_menu_newsletter["003300"]["enabled"] = "1";

    $we_menu_newsletter["004000"]["text"] = $l_newsletter["help"];
    $we_menu_newsletter["004000"]["parent"] = "000000";
    $we_menu_newsletter["004000"]["enabled"] = "1";
    
    $we_menu_newsletter["004100"]["text"] = $l_newsletter["help"]."...";
    $we_menu_newsletter["004100"]["parent"] = "004000";
    $we_menu_newsletter["004100"]["cmd"] = "help_modules";
    $we_menu_newsletter["004100"]["enableadd"] = "1";
    
    $we_menu_newsletter["004200"]["text"] = $l_newsletter["info"]."...";
    $we_menu_newsletter["004200"]["parent"] = "004000";
    $we_menu_newsletter["004200"]["cmd"] = "info_modules";
    $we_menu_newsletter["004200"]["enabled"] = "1";


?>