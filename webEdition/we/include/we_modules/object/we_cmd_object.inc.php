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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */




switch ($_REQUEST["we_cmd"][0]) {
//	case "edit_object_ifthere":
//	case "edit_object":
//		$mod="object";
//		$INCLUDE = "we_modules/show_frameset.php";
//		break;
		
	case "delete_entry_at_class":
	case "up_entry_at_class":
	case "down_entry_at_class":
	case "insert_entry_at_class":
	case "reload_entry_at_class":
	case "down_meta_at_class":
	case "insert_meta_at_class":
	case "delete_meta_class":
	case "up_meta_at_class":
	case "add_user_to_field":
	case "del_user_from_field":
	case "del_all_users":
	case "remove_image_at_class":
	case "delete_link_at_class":
	case "change_link_at_class":
	case "change_multiobject_at_class":
		$INCLUDE = "we_modules/object/we_editor_contentobject_load.inc.php";
		break;
		
	case "reload_entry_at_object":
	case "down_meta_at_object":
	case "insert_meta_at_object":
	case "delete_meta_at_object":
	case "up_meta_at_object":
	case "change_objectlink":
	case "remove_image_at_object":
	case "delete_link_at_object":
	case "change_link_at_object":
		$INCLUDE = "we_modules/object/we_editor_contentobjectFile_load.inc.php";
		break;
		
	case "add_css":      
 	case "del_css":
	case "add_workspace":
	case "del_workspace":
	case "add_extraworkspace":
	case "del_extraworkspace":
	case "changeTempl_ob":
	case "ws_from_class":
//	In this file we cant work with WE_OBJECT_MODULE_DIR, because a prefix is already set in : we_cmd.php
		$INCLUDE = "we_editors/we_editor.inc.php";
		break;

	case "toggleExtraWorkspace":
		$INCLUDE = "we_modules/object/we_object_cmds.inc.php";
		break;

	case "obj_search":
		$INCLUDE = "we_modules/object/search_submit.php";
		break;

	case "preview_objectFile":
		$INCLUDE = "we_modules/object/we_object_showDocument.inc.php";
		break;

	case "create_tmpfromClass":
		$INCLUDE = "we_modules/object/we_object_createTemplate.inc.php";
		break;
		
	case "editObjectTextArea":
		$INCLUDE = "we_editors/we_editta.inc.php";
		break;

}

?>