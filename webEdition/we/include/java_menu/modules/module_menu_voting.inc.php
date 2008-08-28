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


if (defined("VOTING_TABLE")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/voting.inc.php");
}

$we_menu_voting["000100"]["text"] =$GLOBALS["l_voting"]["voting"];
$we_menu_voting["000100"]["parent"] = "000000";
$we_menu_voting["000100"]["perm"] = "";
$we_menu_voting["000100"]["enabled"] = "1";

$we_menu_voting["000200"]["text"] = $GLOBALS["l_voting"]["menu_new"];
$we_menu_voting["000200"]["parent"] = "000100";
$we_menu_voting["000200"]["perm"] = "";
$we_menu_voting["000200"]["enabled"] = "1";

$we_menu_voting["000300"]["text"] = $GLOBALS["l_voting"]["voting"];
$we_menu_voting["000300"]["parent"] = "000200";
$we_menu_voting["000300"]["cmd"] = "new_voting";
$we_menu_voting["000300"]["perm"] = "NEW_VOTING || ADMINISTRATOR";
$we_menu_voting["000300"]["enabled"] = "1";

$we_menu_voting["000400"]["text"] = $GLOBALS["l_voting"]["group"];
$we_menu_voting["000400"]["parent"] = "000200";
$we_menu_voting["000400"]["cmd"] = "new_voting_group";
$we_menu_voting["000400"]["perm"] = "NEW_VOTING || ADMINISTRATOR";
$we_menu_voting["000400"]["enabled"] = "1";

$we_menu_voting["000500"]["text"] = $GLOBALS["l_voting"]["menu_save"];
$we_menu_voting["000500"]["parent"] = "000100";
$we_menu_voting["000500"]["cmd"] = "save_voting";
$we_menu_voting["000500"]["perm"] = "EDIT_VOTING || NEW_VOTING || ADMINISTRATOR";
$we_menu_voting["000500"]["enabled"] = "1";

$we_menu_voting["000600"]["text"] = $GLOBALS["l_voting"]["menu_delete"];
$we_menu_voting["000600"]["parent"] = "000100";
$we_menu_voting["000600"]["cmd"] = "delete_voting";
$we_menu_voting["000600"]["perm"] = "DELETE_VOTING || ADMINISTRATOR";
$we_menu_voting["000600"]["enabled"] = "1";

$we_menu_voting["000950"]["parent"] = "000100"; // separator

$we_menu_voting["001000"]["text"] = $GLOBALS["l_voting"]["menu_exit"];
$we_menu_voting["001000"]["parent"] = "000100";
$we_menu_voting["001000"]["cmd"] = "exit_voting";
$we_menu_voting["001000"]["perm"] = "";
$we_menu_voting["001000"]["enabled"] = "1";

$we_menu_voting["001100"]["text"] = $GLOBALS["l_voting"]["menu_help"];
$we_menu_voting["001100"]["parent"] = "000000";
$we_menu_voting["001100"]["perm"] = "";
$we_menu_voting["001100"]["enabled"] = "1";

$we_menu_voting["001200"]["text"] = $GLOBALS["l_voting"]["menu_help"]."...";;
$we_menu_voting["001200"]["parent"] = "001100";
$we_menu_voting["001200"]["cmd"] = "help_voting";
$we_menu_voting["001200"]["perm"] = "";
$we_menu_voting["001200"]["enabled"] = "1";

$we_menu_voting["001300"]["text"] = $GLOBALS["l_voting"]["menu_info"]."...";;
$we_menu_voting["001300"]["parent"] = "001100";
$we_menu_voting["001300"]["cmd"] = "info";
$we_menu_voting["001300"]["perm"] = "";
$we_menu_voting["001300"]["enabled"] = "1";

?>
