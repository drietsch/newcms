<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/workpermissions.inc.php");

$perm_group_name="workpermissions";

$perm_group_title[$perm_group_name] = $l_perm[$perm_group_name]["perm_group_title"];
 
$perm_values[$perm_group_name] = array(
	"NEW_WEBEDITIONSITE",
	"NEW_GRAFIK",
	"NEW_HTML",
	"NEW_FLASH",
	"NEW_QUICKTIME",
	"NEW_JS",
	"NEW_CSS",
	"NEW_TEXT",
	"NEW_SONSTIGE",
	"NEW_TEMPLATE",
	"NEW_DOC_FOLDER",
	"CHANGE_DOC_FOLDER_PATH",
	"NEW_TEMP_FOLDER",
	"CAN_SEE_DOCUMENTS",
	"CAN_SEE_TEMPLATES",
	"SAVE_DOCUMENT_TEMPLATE",
	"DELETE_DOC_FOLDER",
	"DELETE_TEMP_FOLDER",
	"DELETE_DOCUMENT",
	"DELETE_TEMPLATE",   
	"MOVE_DOCUMENT",
	"MOVE_TEMPLATE",        
	"BROWSE_SERVER",
	"EDIT_DOCTYPE",
	"EDIT_KATEGORIE",
	"EXPORT",
	"IMPORT",
	"FORMMAIL",
	"CAN_SEE_PROPERTIES",
	"CAN_SEE_INFO",
	"CAN_SEE_QUICKSTART",
	"CAN_SELECT_OTHER_USERS_FILES",
	"CAN_SELECT_EXTERNAL_FILES",
	"NO_DOCTYPE",
	"CAN_COPY_FOLDERS",
    "CAN_SEE_VALIDATION",
	"CAN_EDIT_VALIDATION",
	"CAN_SEE_ACCESSIBLE_PARAMETERS",	
	"EDIT_NAVIGATION"
	);


//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name]=array(
	
	"NEW_WEBEDITIONSITE"=>1,
	"NEW_GRAFIK"=>1,
	"NEW_HTML"=>1,
	"NEW_FLASH"=>1,
	"NEW_QUICKTIME"=>1,
	"NEW_JS"=>1,
	"NEW_CSS"=>1,
	"NEW_TEXT"=>1,
	"NEW_SONSTIGE"=>1,
	"NEW_TEMPLATE"=>0,
	"NEW_DOC_FOLDER"=>1,
	"CHANGE_DOC_FOLDER_PATH"=>0,
	"NEW_TEMP_FOLDER"=>0,
	"CAN_SEE_DOCUMENTS"=>1,
	"CAN_SEE_TEMPLATES"=>0,
	"SAVE_DOCUMENT_TEMPLATE"=>1,
	"DELETE_DOC_FOLDER"=>1,
	"DELETE_TEMP_FOLDER"=>0,
	"DELETE_DOCUMENT"=>1,
	"DELETE_TEMPLATE"=>0,
	"MOVE_DOCUMENT"=>1,
	"MOVE_TEMPLATE"=>0,
	"BROWSE_SERVER"=>0,
	"EDIT_DOCTYPE"=>0,
	"EDIT_KATEGORIE"=>1,
	"EXPORT"=>0,
	"IMPORT"=>0,
	"FORMMAIL"=>0,
	"CAN_SEE_PROPERTIES"=>1,
	"CAN_SEE_INFO"=>1,
	"CAN_SEE_QUICKSTART"=>1,
	"CAN_SELECT_OTHER_USERS_FILES"=>1,
	"CAN_SELECT_EXTERNAL_FILES"=>1,
	"NO_DOCTYPE"=>1,
	"CAN_COPY_FOLDERS"=>0,
    "CAN_SEE_VALIDATION"=>1,
	"CAN_EDIT_VALIDATION"=>0,
	"CAN_SEE_ACCESSIBLE_PARAMETERS"=>1,
	"EDIT_NAVIGATION"=>1
	);
?>