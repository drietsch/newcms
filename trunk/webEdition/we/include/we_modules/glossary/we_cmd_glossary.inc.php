<?php 

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

switch($_REQUEST["we_cmd"][0]) {
	
	case "edit_glossary_acronym":
	case "edit_glossary_abbreviation":
	case "edit_glossary_foreignword":
	case "edit_glossary_link":
	case "edit_glossary_ifthere":
	case "view_folder":
	case "view_type":
	case "view_exception":
		$mod="glossary";
		$INCLUDE = "we_modules/show_frameset.php";
		break;
		
    case 'glossary_settings':
    	$INCLUDE = 'we_modules/glossary/edit_glossary_settings_frameset.php';
    	break;
		
    case 'glossary_dictionaries':
    	$INCLUDE = 'we_modules/glossary/edit_glossary_dictionaries_frameset.php';
    	break;
		
	case "check_glossary":
		$mod="glossary";
		$INCLUDE = "we_modules/glossary/add_items.inc.php";
		break;
		

}

?>