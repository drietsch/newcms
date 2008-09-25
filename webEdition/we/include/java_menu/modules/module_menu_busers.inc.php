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


if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])){
    $we_menu_users["000300"]["text"]    = $l_javaMenu["users"]["menu_alias"];
    $we_menu_users["000300"]["parent"]  = "000150";
    $we_menu_users["000300"]["cmd"]     = "new_alias";
    $we_menu_users["000300"]["perm"]    = "NEW_USER || ADMINISTRATOR";
    $we_menu_users["000300"]["enabled"] = "0";
    
    $we_menu_users["000350"]["parent"]  = "000150"; // separator

    $we_menu_users["000400"]["text"]    = $l_javaMenu["users"]["group"];
    $we_menu_users["000400"]["parent"]  = "000150";
    $we_menu_users["000400"]["cmd"]     = "new_group";
    $we_menu_users["000400"]["perm"]    = "NEW_GROUP || ADMINISTRATOR";
    $we_menu_users["000400"]["enabled"] = "0";
}
    
?>