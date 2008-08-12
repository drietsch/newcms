<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/banner.inc.php");

    $we_menu_banner["000100"]["text"]=$l_banner["banner"];
    $we_menu_banner["000100"]["parent"] = "000000";
    $we_menu_banner["000100"]["enabled"]  = "1";

	$we_menu_banner["000200"]["text"]= $l_banner["new"];
	$we_menu_banner["000200"]["parent"] = "000100";
	$we_menu_banner["000200"]["enabled"] = "1";

    $we_menu_banner["000250"]["text"]= $l_banner["banner"];
    $we_menu_banner["000250"]["cmd"] = "new_banner";
    $we_menu_banner["000250"]["perm"] = "NEW_BANNER || ADMINISTRATOR";
    $we_menu_banner["000250"]["parent"] = "000200";
    $we_menu_banner["000250"]["enabled"] = "0";

    $we_menu_banner["000251"]["text"]= $l_banner["bannergroup"];
    $we_menu_banner["000251"]["cmd"] = "new_bannergroup";
    $we_menu_banner["000251"]["perm"] = "NEW_BANNER || ADMINISTRATOR";
    $we_menu_banner["000251"]["parent"] = "000200";
    $we_menu_banner["000251"]["enabled"] = "0";

    $we_menu_banner["000300"]["text"]= $l_banner["save"];
    $we_menu_banner["000300"]["parent"] = "000100";
    $we_menu_banner["000300"]["cmd"] = "save_banner";
    $we_menu_banner["000300"]["perm"] = "EDIT_BANNER || ADMINISTRATOR";
    $we_menu_banner["000300"]["enabled"] = "0";

    $we_menu_banner["000400"]["text"]= $l_banner["delete"];
    $we_menu_banner["000400"]["parent"] = "000100";
    $we_menu_banner["000400"]["cmd"] = "delete_banner";
    $we_menu_banner["000400"]["perm"] = "DELETE_BANNER || ADMINISTRATOR";
    $we_menu_banner["000400"]["enabled"] = "0";

	$we_menu_banner["000500"]["parent"] = "000100"; // separator
	$we_menu_banner["000800"]["text"]= $l_banner["quit"];
    $we_menu_banner["000800"]["parent"] = "000100";
    $we_menu_banner["000800"]["cmd"] = "exit_banner";
    $we_menu_banner["000800"]["enabled"] = "1";

	$we_menu_banner["002000"]["text"]= $l_banner["options"];
    $we_menu_banner["002000"]["parent"] = "000000";
    $we_menu_banner["002000"]["enabled"] = "1";

	$we_menu_banner["002900"]["text"]= $l_banner["defaultbanner"]."...";
    $we_menu_banner["002900"]["parent"] = "002000";
    $we_menu_banner["002900"]["cmd"] = "default_banner";
    $we_menu_banner["002900"]["perm"] = "EDIT_BANNER || ADMINISTRATOR";
    $we_menu_banner["002900"]["enabled"] = "0";

	$we_menu_banner["003000"]["text"]= $l_banner["bannercode"]."...";
    $we_menu_banner["003000"]["parent"] = "002000";
    $we_menu_banner["003000"]["cmd"] = "banner_code";
    $we_menu_banner["003000"]["perm"] = "EDIT_BANNER || ADMINISTRATOR";
    $we_menu_banner["003000"]["enabled"] = "0";


	$we_menu_banner["004000"]["text"]= $l_banner["help"];
    $we_menu_banner["004000"]["parent"] = "000000";
    $we_menu_banner["004000"]["enabled"] = "1";

    $we_menu_banner["004100"]["text"]= $l_banner["help"]."...";;
    $we_menu_banner["004100"]["parent"] = "004000";
    $we_menu_banner["004100"]["cmd"] = "help_users";
    $we_menu_banner["004100"]["enabled"] = "1";

    $we_menu_banner["004200"]["text"]= $l_banner["info"]."...";;
    $we_menu_banner["004200"]["parent"] = "004000";
    $we_menu_banner["004200"]["cmd"] = "info";
    $we_menu_banner["004200"]["enabled"] = "1";
?>