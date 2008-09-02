

		case "messaging_start":
		case "edit_messaging_ifthere":
		    new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
		    break;
		case "messaging_new_message":
		case "messaging_new_todo":
		case "messaging_start_view":
		case "messaging_new_folder":
		case "messaging_delete_mode_on":
		case "messaging_delete_folders":
		case "messaging_edit_folder":
        case "messaging_exit":
		case "messaging_new_account":
		case "messaging_edit_account":
		case "messaging_copy":
		case "messaging_cut":
		case "messaging_paste":
		case "messaging_settings":
		     var fo=false;
		     for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		     }
			     wind.focus();
		    break;
