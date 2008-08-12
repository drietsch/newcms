// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


    case "edit_object_ifthere":
    case "edit_object":
        new jsWindow(url,"edit_module",-1,-1,380,250,true,true,true,true);
		break;
	case "new_objectFile":
		we_cmd("new","<?php print OBJECT_FILES_TABLE; ?>","","objectFile");
		break;
	case "new_objectfile_folder":
		we_cmd("new","<?php print OBJECT_FILES_TABLE; ?>","","folder");
		break;

	case "new_object":
		we_cmd("new","<?php print OBJECT_TABLE; ?>","","object");
		break;
	case "new_object_folder":
		we_cmd("new","<?php print OBJECT_TABLE; ?>","","folder");
		break;

	case "change_link_at_class":
		top.load.location = url;
		break;

	case "insert_entry_at_class":
	case "delete_entry_at_class":
	case "up_entry_at_class":
	case "down_entry_at_class":
	case "up_meta_at_class":
	case "down_meta_at_class":
	case "insert_meta_at_class":
	case "delete_meta_class":
	case "reload_entry_at_class":
	case "add_user_to_field":
	case "del_user_from_field":
	case "del_all_users":
	case "remove_image_at_class":
	case "delete_link_at_class":
	case "change_multiobject_at_class":
		url += "#f"+(parseInt(arguments[1])-1);
		we_sbmtFrm(top.load,url);
		break;

	case "change_link_at_object":
		top.load.location = url;
		break;

	case "remove_image_at_object":
	case "up_meta_at_object":
	case "down_meta_at_object":
	case "insert_meta_at_object":
	case "delete_meta_at_object":
	case "reload_entry_at_object":
	case "change_objectlink":
	case "delete_link_at_object":
		url += "#f"+(parseInt(arguments[1])-1);
		we_sbmtFrm(top.load,url);
		break;

	case "add_workspace":
	case "del_workspace":
	case "add_css":
	case "del_css":
	case "add_extraworkspace":
	case "del_extraworkspace":
	case "changeTempl_ob":
	case "ws_from_class":
		if(!we_sbmtFrm(top.weEditorFrameController.getActiveDocumentReference().frames["1"],url)){
			url += "&we_transaction="+arguments[2];
			we_repl(top.weEditorFrameController.getActiveDocumentReference().frames["1"],url,arguments[0]);
		}
		break;
	case "toggleExtraWorkspace":
	case "obj_search":
		we_repl(self.load,url,arguments[0]);
		break;
	case "delete_object":
		top.we_cmd("del",1,"<?php print OBJECT_TABLE; ?>");
		break;
	case "delete_objectfile":
		top.we_cmd("del",1,"<?php print OBJECT_FILES_TABLE; ?>");
		break;
	case "delete_objectfile_cache":
		top.we_cmd("del",1,"<?php print OBJECT_FILES_TABLE; ?>_cache");
		break;
	case "move_objectfile":
		top.we_cmd("mv",1,"<?php print OBJECT_FILES_TABLE; ?>");
		break;
    case "preview_objectFile":
        new jsWindow(url,"preview_object",-1,-1,1600,1200,true,true,true,true);
		break;
	case "create_tmpfromClass":
        new jsWindow(url,"tmpfromClass",-1,-1,580,200,true,false,true,false);
		break;
	case "open_object":
		we_cmd("load","<?php print OBJECT_TABLE; ?>");
		url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=openDocselector&we_cmd[8]=object&we_cmd[1]=&we_cmd[2]=<?php print OBJECT_TABLE; ?>&we_cmd[5]=<?php print rawurlencode("opener.top.weEditorFrameController.openDocument(table,currentID,currentType)"); ?>&we_cmd[9]=1";
		new jsWindow(url,"we_dirChooser",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . "," . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true);
		break;
	case "open_objectFile":
		we_cmd("load","<?php print OBJECT_FILES_TABLE; ?>");
		url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=openDocselector&we_cmd[8]=objectFile&we_cmd[2]=<?php print OBJECT_FILES_TABLE; ?>&we_cmd[5]=<?php print rawurlencode("opener.top.weEditorFrameController.openDocument(table,currentID,currentType)"); ?>&we_cmd[9]=1";
		new jsWindow(url,"we_dirChooser",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . "," . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true);
		break;
