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

   if(defined("OBJECT_TABLE")){
   	
   	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_object.inc.php");

	// File > unpublished objects
	$we_menu["1115000"]["text"] = $l_we_javaMenu["object"]["unpublished_objects"] . "...";
	$we_menu["1115000"]["parent"] = "1000000";
	$we_menu["1115000"]["cmd"] = "openUnpublishedObjects";
	$we_menu["1115000"]["perm"] = "CAN_SEE_OBJECTFILES || ADMINISTRATOR";
	$we_menu["1115000"]["enabled"] = "1";

//  File > open

	// File > open > Object
	$we_menu["1030300"]["text"] = $l_we_javaMenu["object"]["open_object"] . "...";
	$we_menu["1030300"]["parent"] = "1030000";
	$we_menu["1030300"]["cmd"] = "open_objectFile";
	$we_menu["1030300"]["perm"] = "CAN_SEE_OBJECTFILES || ADMINISTRATOR";
	$we_menu["1030300"]["enabled"] = "1";

	if ($_SESSION["we_mode"] == "normal") {

		// File > Open > Class
		$we_menu["1030400"]["text"] = $l_we_javaMenu["object"]["open_class"] . "...";
		$we_menu["1030400"]["parent"] = "1030000";
		$we_menu["1030400"]["cmd"] = "open_object";
		$we_menu["1030400"]["perm"] = "CAN_SEE_OBJECTS || ADMINISTRATOR";
		$we_menu["1030400"]["enabled"] = "1";
	}
	
	
//  File > new
	
	if ($_SESSION["we_mode"] == "normal") {
		
		// File > new > Class
		$we_menu["1010700"]["text"] = $l_we_javaMenu["object"]["class"];
		$we_menu["1010700"]["parent"] = "1010000";
		$we_menu["1010700"]["cmd"] = "new_object";
		$we_menu["1010700"]["perm"] = "NEW_OBJECT || ADMINISTRATOR";
		$we_menu["1010700"]["enabled"] = "1";
		
		// File > new > directory > objectfolder
		$we_menu["1011003"]["text"] = $l_we_javaMenu["object"]["object_directory"];
		$we_menu["1011003"]["parent"] = "1011000";
		$we_menu["1011003"]["cmd"] = "new_objectfile_folder";
		$we_menu["1011003"]["perm"] = "NEW_OBJECTFILE_FOLDER || ADMINISTRATOR";
		$we_menu["1011003"]["enabled"] = "1";
	}
	
	// File > new > Object
	$we_menu["1010800"]["text"] = $l_we_javaMenu["object"]["object"];
    $we_menu["1010800"]["parent"] = "1010000";
    $we_menu["1010800"]["perm"] = "NEW_OBJECTFILE || ADMINISTRATOR";
    $we_menu["1010800"]["enabled"] = "0";
    
    // object from which class
    $ac = makeCSVFromArray(getAllowedClasses($DB_WE));
    if($ac){
		$DB_WE->query("SELECT ID,Text FROM " . OBJECT_TABLE . " ".($ac ? " WHERE ID IN($ac) " : "")."ORDER BY Text");
		$nr = 801;
		while($DB_WE->next_record()){
			
			$we_menu["1010800"]["enabled"] = "1";
			
			$foo = $DB_WE->f("Text");
			$foo = str_replace('"',"",$foo);
			$foo = str_replace("'","",$foo);

			$we_menu["1010" . $nr]["text"] = $foo;
			$we_menu["1010" . $nr]["text"] = $foo;
			
			$we_menu["1010" . $nr]["parent"] = "1010800";
			$we_menu["1010" . $nr]["cmd"] = "new_ClObjectFile".$DB_WE->f("ID");
			$we_menu["1010" . $nr]["perm"] = "NEW_OBJECTFILE || ADMINISTRATOR";
			$we_menu["1010" . $nr]["enabled"] = "1";
			$nr++;
			if($nr == 999) {
				break;
			}
		}
	}
	
	
	if ($_SESSION["we_mode"] == "normal") {
		// separator
		$we_menu["1010999"]["parent"] = "1010000"; // separator
	}
		
// File > Delete
	if ($_SESSION["we_mode"] == "normal") {
		
		// File > Delete > Objects
		$we_menu["1080300"]["text"] = $l_we_javaMenu["object"]["objects"];
		$we_menu["1080300"]["parent"] = "1080000";
		$we_menu["1080300"]["cmd"] = "delete_objectfile";
		$we_menu["1080300"]["perm"] = "DELETE_OBJECTFILE || ADMINISTRATOR";
		$we_menu["1080300"]["enabled"] = "1";
		
		// File > Delete > Classes
		$we_menu["1080400"]["text"] = $l_we_javaMenu["object"]["classes"];
		$we_menu["1080400"]["parent"] = "1080000";
		$we_menu["1080400"]["cmd"] = "delete_object";
		$we_menu["1080400"]["perm"] = "DELETE_OBJECT || ADMINISTRATOR";
		$we_menu["1080400"]["enabled"] = "1";
		
		// File > Delete > Objectscache
		if(we_hasPerm("ADMINISTRATOR")){
			$we_menu["1080600"]["text"] = $l_javaMenu["cache"] . " (".$l_we_javaMenu["object"]["objects"] . ")";
			$we_menu["1080600"]["parent"] = "1080000";
			$we_menu["1080600"]["cmd"] = "delete_objectfile_cache";
	        $we_menu["1080600"]["perm"] = "ADMINISTRATOR";
			$we_menu["1080600"]["enabled"] = "1";
		}
		// File > move
		if ($_SESSION["we_mode"] == "normal") {
			$we_menu["1090300"]["text"] = $l_we_javaMenu["object"]["objects"];
			$we_menu["1090300"]["parent"] = "1090000";
			$we_menu["1090300"]["cmd"] = "move_objectfile";
			$we_menu["1090300"]["perm"] = "MOVE_OBJECTFILE || ADMINISTRATOR";
			$we_menu["1090300"]["enabled"] = "1";
		}
	}

	
  }
?>
