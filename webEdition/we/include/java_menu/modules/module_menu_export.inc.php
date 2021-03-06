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


	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/export.inc.php");

    $we_menu_export["000100"]["text"]=$l_export["export"];
    $we_menu_export["000100"]["parent"] = "000000";
    $we_menu_export["000100"]["enabled"]  = "1";

	$we_menu_export["000200"]["text"]= $l_export["new"];
    $we_menu_export["000200"]["parent"] = "000100";
    $we_menu_export["000200"]["enabled"] = "0";

    $we_menu_export["000230"]["text"]= $l_export["export"];
    $we_menu_export["000230"]["cmd"] = "new_export";
    $we_menu_export["000230"]["perm"] = "NEW_EXPORT || ADMINISTRATOR";
    $we_menu_export["000230"]["parent"] = "000200";
    $we_menu_export["000230"]["enabled"] = "0";

    $we_menu_export["000260"]["text"]= $l_export["group"];
    $we_menu_export["000260"]["cmd"] = "new_export_group";
    $we_menu_export["000260"]["perm"] = "NEW_EXPORT || ADMINISTRATOR";
    $we_menu_export["000260"]["parent"] = "000200";
    $we_menu_export["000260"]["enabled"] = "0";

    $we_menu_export["000300"]["text"]= $l_export["save"];
    $we_menu_export["000300"]["parent"] = "000100";
    $we_menu_export["000300"]["cmd"] = "save_export";
    $we_menu_export["000300"]["perm"] = "NEW_EXPORT || EDIT_EXPORT || ADMINISTRATOR";
    $we_menu_export["000300"]["enabled"] = "0";

    $we_menu_export["000400"]["text"]= $l_export["delete"];
    $we_menu_export["000400"]["parent"] = "000100";
    $we_menu_export["000400"]["cmd"] = "delete_export";
    $we_menu_export["000400"]["perm"] = "DELETE_EXPORT || ADMINISTRATOR";
    $we_menu_export["000400"]["enabled"] = "0";

	$we_menu_export["000500"]["parent"] = "000100"; // separator

    $we_menu_export["000600"]["text"] = $l_export["quit"];
    $we_menu_export["000600"]["parent"] = "000100";
    $we_menu_export["000600"]["cmd"] = "exit_export";
    $we_menu_export["000600"]["enabled"] = "1";

	$we_menu_export["004000"]["text"]= $l_export["help"];
    $we_menu_export["004000"]["parent"] = "000000";
    $we_menu_export["004000"]["enabled"] = "1";

    $we_menu_export["004100"]["text"]= $l_export["help"]."...";
    $we_menu_export["004100"]["parent"] = "004000";
    $we_menu_export["004100"]["cmd"] = "help_modules";
    $we_menu_export["004100"]["enabled"] = "1";

    $we_menu_export["004200"]["text"]= $l_export["info"]."...";
    $we_menu_export["004200"]["parent"] = "004000";
    $we_menu_export["004200"]["cmd"] = "info_modules";
    $we_menu_export["004200"]["enabled"] = "1";


?>