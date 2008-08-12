<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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