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


if (defined("GLOSSARY_TABLE")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");
}

//
// ---> Menu File / Glossary
//

$we_menu_glossary["001000"]["text"] = $GLOBALS["l_glossary"]["glossary"];
$we_menu_glossary["001000"]["parent"] = "000000";
$we_menu_glossary["001000"]["perm"] = "";
$we_menu_glossary["001000"]["enabled"] = "1";

$we_menu_glossary["002000"]["text"] = $GLOBALS["l_glossary"]["menu_new"];
$we_menu_glossary["002000"]["parent"] = "001000";
$we_menu_glossary["002000"]["perm"] = "";
$we_menu_glossary["002000"]["enabled"] = "1";

$nr = 300;
foreach ($GLOBALS['weFrontendLanguages'] as $key => $language) {

	$we_menu_glossary["00".$nr."0"]["text"] = $language;
	$we_menu_glossary["00".$nr."0"]["parent"] = "002000";
	$we_menu_glossary["00".$nr."0"]["perm"] = "NEW_GLOSSARY || ADMINISTRATOR";
	$we_menu_glossary["00".$nr."0"]["enabled"] = "0";

	$parent = "00".$nr."0";

	$we_menu_glossary["00".$nr."1"]["text"] = $GLOBALS["l_glossary"]["abbreviation"];
	$we_menu_glossary["00".$nr."1"]["parent"] = $parent;
	$we_menu_glossary["00".$nr."1"]["cmd"] = "Glossary:new_glossary_abbreviation:$key";
	$we_menu_glossary["00".$nr."1"]["perm"] = "NEW_GLOSSARY || ADMINISTRATOR";
	$we_menu_glossary["00".$nr."1"]["enabled"] = "1";

	$we_menu_glossary["00".$nr."2"]["text"] = $GLOBALS["l_glossary"]["acronym"];
	$we_menu_glossary["00".$nr."2"]["parent"] = $parent;
	$we_menu_glossary["00".$nr."2"]["cmd"] = "Glossary:new_glossary_acronym:$key";
	$we_menu_glossary["00".$nr."2"]["perm"] = "NEW_GLOSSARY || ADMINISTRATOR";
	$we_menu_glossary["00".$nr."2"]["enabled"] = "1";

	$we_menu_glossary["00".$nr."3"]["text"] = $GLOBALS["l_glossary"]["foreignword"];
	$we_menu_glossary["00".$nr."3"]["parent"] = $parent;
	$we_menu_glossary["00".$nr."3"]["cmd"] = "Glossary:new_glossary_foreignword:$key";
	$we_menu_glossary["00".$nr."3"]["perm"] = "NEW_GLOSSARY || ADMINISTRATOR";
	$we_menu_glossary["00".$nr."3"]["enabled"] = "1";

	$we_menu_glossary["00".$nr."4"]["text"] = $GLOBALS["l_glossary"]["link"];
	$we_menu_glossary["00".$nr."4"]["parent"] = $parent;
	$we_menu_glossary["00".$nr."4"]["cmd"] = "Glossary:new_glossary_link:$key";
	$we_menu_glossary["00".$nr."4"]["perm"] = "NEW_GLOSSARY || ADMINISTRATOR";
	$we_menu_glossary["00".$nr."4"]["enabled"] = "1";

	$nr++;

}

$we_menu_glossary["005000"]["text"] = $GLOBALS["l_glossary"]["menu_save"];
$we_menu_glossary["005000"]["parent"] = "001000";
$we_menu_glossary["005000"]["cmd"] = "save_glossary";
$we_menu_glossary["005000"]["perm"] = "EDIT_GLOSSARY || NEW_GLOSSARY || ADMINISTRATOR";
$we_menu_glossary["005000"]["enabled"] = "1";

$we_menu_glossary["006000"]["text"] = $GLOBALS["l_glossary"]["menu_delete"];
$we_menu_glossary["006000"]["parent"] = "001000";
$we_menu_glossary["006000"]["cmd"] = "delete_glossary";
$we_menu_glossary["006000"]["perm"] = "DELETE_GLOSSARY || ADMINISTRATOR";
$we_menu_glossary["006000"]["enabled"] = "1";

$we_menu_glossary["009500"]["parent"] = "001000"; // separator

$we_menu_glossary["020000"]["text"] = $GLOBALS["l_glossary"]["menu_exit"];
$we_menu_glossary["020000"]["parent"] = "001000";
$we_menu_glossary["020000"]["cmd"] = "exit_glossary";
$we_menu_glossary["020000"]["perm"] = "";
$we_menu_glossary["020000"]["enabled"] = "1";

//
// ---> Menu Options
//

$we_menu_glossary["010000"]["text"] = $GLOBALS["l_glossary"]["menu_options"];
$we_menu_glossary["010000"]["parent"] = "000000";
$we_menu_glossary["010000"]["perm"] = "ADMINISTRATOR";
$we_menu_glossary["010000"]["enabled"] = "1";

	$we_menu_glossary["012000"]["text"] = $GLOBALS["l_glossary"]["menu_settings"];
	$we_menu_glossary["012000"]["parent"] = "010000";
	$we_menu_glossary["012000"]["cmd"] = "glossary_settings";
	$we_menu_glossary["012000"]["perm"] = "ADMINISTRATOR";
	$we_menu_glossary["012000"]["enabled"] = "1";

//
// ---> Menu Help
//

$we_menu_glossary["021000"]["text"] = $GLOBALS["l_glossary"]["menu_help"];
$we_menu_glossary["021000"]["parent"] = "000000";
$we_menu_glossary["021000"]["perm"] = "";
$we_menu_glossary["021000"]["enabled"] = "1";

	$we_menu_glossary["022000"]["text"] = $GLOBALS["l_glossary"]["menu_help"]."...";
	$we_menu_glossary["022000"]["parent"] = "021000";
	$we_menu_glossary["022000"]["cmd"] = "help_glossary";
	$we_menu_glossary["022000"]["perm"] = "";
	$we_menu_glossary["022000"]["enabled"] = "1";

	$we_menu_glossary["023000"]["text"] = $GLOBALS["l_glossary"]["menu_info"]."...";
	$we_menu_glossary["023000"]["parent"] = "021000";
	$we_menu_glossary["023000"]["cmd"] = "info";
	$we_menu_glossary["023000"]["perm"] = "";
	$we_menu_glossary["023000"]["enabled"] = "1";

?>
