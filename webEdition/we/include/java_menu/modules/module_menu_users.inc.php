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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_users.inc.php");

$we_menu_users["000100"]["text"] = $l_javaMenu["users"]["menu_user"];
$we_menu_users["000100"]["parent"] = "000000";    
$we_menu_users["000100"]["enabled"]  = "0";             

$we_menu_users["000150"]["text"] = $l_javaMenu["users"]["menu_new"];
$we_menu_users["000150"]["parent"] = "000100";
$we_menu_users["000150"]["enabled"] = "0";             

$we_menu_users["000200"]["text"] = $l_javaMenu["users"]["menu_user"];
$we_menu_users["000200"]["parent"] = "000150";
$we_menu_users["000200"]["cmd"] = "new_user";
$we_menu_users["000200"]["perm"] = "NEW_USER || ADMINISTRATOR";
$we_menu_users["000200"]["enabled"] = "0";             
    
$we_menu_users["000600"]["text"] = $l_javaMenu["users"]["menu_save"];
$we_menu_users["000600"]["parent"] = "000100";
$we_menu_users["000600"]["cmd"] = "save_user";
$we_menu_users["000600"]["perm"] = "NEW_GROUP || NEW_USER || SAVE_USER || SAVE_GROUP || ADMINISTRATOR";
$we_menu_users["000600"]["enabled"] = "0";             

$we_menu_users["000700"]["text"] = $l_javaMenu["users"]["menu_delete"];
$we_menu_users["000700"]["parent"] = "000100";
$we_menu_users["000700"]["cmd"] = "delete_user";
$we_menu_users["000700"]["perm"] = "DELETE_USER || DELETE_GROUP || ADMINISTRATOR";
$we_menu_users["000700"]["enabled"] = "0";             

$we_menu_users["000800"]["parent"] = "000100"; // separator

$we_menu_users["000900"]["text"] = $l_javaMenu["users"]["menu_exit"];
$we_menu_users["000900"]["parent"] = "000100";
$we_menu_users["000900"]["cmd"] = "exit_users";
$we_menu_users["000900"]["enabled"] = "1";             

$we_menu_users["001500"]["text"] = $l_javaMenu["users"]["menu_help"];
$we_menu_users["001500"]["parent"] = "000000";
$we_menu_users["001500"]["enabled"] = "1";             
             
$we_menu_users["001600"]["text"] = $l_javaMenu["users"]["menu_help"]."...";
$we_menu_users["001600"]["parent"] = "001500";
$we_menu_users["001600"]["cmd"] = "help_users";
$we_menu_users["001600"]["enabled"] = "1";

$we_menu_users["001700"]["text"] = $l_javaMenu["users"]["menu_info"]."...";
$we_menu_users["001700"]["parent"] = "001500";
$we_menu_users["001700"]["cmd"] = "info";
$we_menu_users["001700"]["enabled"] = "1";
?>