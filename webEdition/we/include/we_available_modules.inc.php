<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


$_we_available_modules = array();

//  Names of modules are now stored in extra file, so webEdition can easy be translated
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/javaMenu/module_information.inc.php");

$_we_available_modules["users"] = array(
	"name"=>"users",
	"perm"=>"NEW_USER || NEW_GROUP || SAVE_USER || SAVE_GROUP || DELETE_USER || DELETE_GROUP || ADMINISTRATOR",
	"text"=>$l_javaMenu["module_information"]["users"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["users"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["users"]["not_installed"],
	"inModuleMenu"=>true,
	"integrated" => true,
	"alwaysActive" => true,
	"hasSettings" => false
);

$_we_available_modules["customer"] = array(
	"name"=>"customer",
	"perm"=>"SHOW_CUSTOMER_ADMIN || DELETE_CUSTOMER || EDIT_CUSTOMER || NEW_CUSTOMER || ADMINISTRATOR",
	"text"=>$l_javaMenu["module_information"]["customer"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["customer"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["customer"]["not_installed"],
	"inModuleMenu"=>true,
	"integrated" => false,
	"hasSettings" => true
);

$_we_available_modules["schedule"] = array(
	"name"=>"schedule",
	"text"=>$l_javaMenu["module_information"]["schedule"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["schedule"]["text_short"],
	"notInstalled" => $l_javaMenu["module_information"]["schedule"]["not_installed"],
	"inModuleMenu"=>false,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => false
);

$_we_available_modules["shop"] = array(
	"name"=>"shop",
	"text"=>$l_javaMenu["module_information"]["shop"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["shop"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["shop"]["not_installed"],
	"perm"=>"NEW_SHOP_ARTICLE || DELETE_SHOP_ARTICLE || EDIT_SHOP_ORDER || DELETE_SHOP_ORDER || EDIT_SHOP_PREFS || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => false,
	"hasSettings" => true
);


$_we_available_modules["editor"] = array(
	"name"=>"editor",
	"text"=>$l_javaMenu["module_information"]["editor"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["editor"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["editor"]["not_installed"],
	"perm"=>"NEW_SHOP_ARTICLE || DELETE_SHOP_ARTICLE || EDIT_SHOP_ORDER || DELETE_SHOP_ORDER || EDIT_SHOP_PREFS || ADMINISTRATOR",
	"inModuleMenu"=>false,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => true
);

$_we_available_modules["object"] = array(
	"name"=>"object",
	"text"=>$l_javaMenu["module_information"]["object"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["object"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["object"]["not_installed"],
	"inModuleMenu"=>false,
	"integrated" => false,
	"hasSettings" => false
);


$_we_available_modules["messaging"] = array(
	"name"=>"messaging",
	"text"=>$l_javaMenu["module_information"]["messaging"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["messaging"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["messaging"]["not_installed"],
	"inModuleMenu"=>true,
	"integrated" => false,
	"hasSettings" => true
);

$_we_available_modules["workflow"] = array(
	"name"=>"workflow",
	"text"=>$l_javaMenu["module_information"]["workflow"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["workflow"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["workflow"]["not_installed"],
	"perm"=>"NEW_WORKFLOW || DELETE_WORKFLOW || EDIT_WORKFLOW || EMPTY_LOG || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => false,
	"hasSettings" => false
);


$_we_available_modules["newsletter"] = array(
	"name"=>"newsletter",
	"text"=>$l_javaMenu["module_information"]["newsletter"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["newsletter"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["newsletter"]["not_installed"],
	"perm"=>"NEW_NEWSLETTER || DELETE_NEWSLETTER || EDIT_NEWSLETTER || SEND_NEWSLETTER || SEND_TEST_EMAIL || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => false,
	"hasSettings" => true
);

$_we_available_modules["banner"] = array(
	"name"=>"banner",
	"text"=>$l_javaMenu["module_information"]["banner"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["banner"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["banner"]["not_installed"],
	"perm"=>"NEW_BANNER || DELETE_BANNER || EDIT_BANNER || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => true
);

$_we_available_modules["export"] = array(
	"name"=>"export",
	"text"=>$l_javaMenu["module_information"]["export"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["export"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["export"]["not_installed"],
	"perm"=>"NEW_EXPORT || DELETE_EXPORT || EDIT_EXPORT || MAKE_EXPORT || ADMINISTRATOR",
	"inModuleMenu"=> true,
	"integrated" => true,
	"alwaysActive" => true,
	"hasSettings" => false,
	"inModuleWindow" => true
);

$_we_available_modules["voting"] = array(
	"name"=>"voting",
	"text"=>$l_javaMenu["module_information"]["voting"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["voting"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["voting"]["not_installed"],
	"perm"=>"NEW_VOTING || DELETE_VOTING || EDIT_VOTING || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => false
);

$_we_available_modules["spellchecker"] = array(
	"name"=>"spellchecker",
	"text"=>$l_javaMenu["module_information"]["spellchecker"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["spellchecker"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["spellchecker"]["not_installed"],
	"perm"=>"SPELLCHECKER_ADMIN || ADMINISTRATOR",
	"inModuleMenu"=>false,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => true
);

$_we_available_modules["glossary"] = array(
	"name"=>"glossary",
	"text"=>$l_javaMenu["module_information"]["glossary"]["text"],
	"text_short"=>$l_javaMenu["module_information"]["glossary"]["text_short"],
	"notInstalled"=>$l_javaMenu["module_information"]["glossary"]["not_installed"],
	"perm"=>"NEW_GLOSSARY || DELETE_GLOSSARY || EDIT_GLOSSARY || ADMINISTRATOR",
	"inModuleMenu"=>true,
	"integrated" => true,
	"alwaysActive" => false,
	"hasSettings" => true
);

// as default installed pro-modules
$we_pro_modules_available = array("busers");

?>