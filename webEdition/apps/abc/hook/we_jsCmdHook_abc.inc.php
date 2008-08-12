<?php
					

	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/conf/meta.conf.php');

	?>
        case "tool_abc_edit":
			new jsWindow(url,"tool_window",-1,-1,970,760,true,true,true,true);
		break;
		case "tool_abc_new":
		case "tool_abc_new_group":
		case "tool_abc_delete":
		case "tool_abc_save":
		case "tool_abc_exit":
			var fo=false;
			for(var k=jsWindow_count-1;k>-1;k--){
				eval("if(jsWindow"+k+"Object.ref=='tool_window'){ jsWindow"+k+"Object.wind.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
				if(fo) break;
			}
			wind.focus();
		break;
		
<?php
		?>