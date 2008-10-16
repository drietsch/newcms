

			case "edit_newsletter":
			case "edit_newsletter_ifthere":
				new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
			break;
			case "new_user":
			case "save_newsletter":
			case "new_newsletter":
			case "new_newsletter_group":
			case "send_newsletter":
			case "preview_newsletter":
			case "delete_newsletter":
			case "send_test":
			case "domain_check":
			case "test_newsletter":
			case "show_log":
			case "print_lists":
			case "newsletter_settings":
			case "black_list":
			case "search_email":
			case "edit_file":
			case "clear_log":
			case "exit_newsletter":
				var fo=false;
				for(var k=jsWindow_count-1;k>-1;k--){
					eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
					if(fo) break;
				}
				<?php if(isset($GLOBALS['BROWSER']) && $GLOBALS['BROWSER']=='IE') print "wind.focus()"; ?>;
				break;
