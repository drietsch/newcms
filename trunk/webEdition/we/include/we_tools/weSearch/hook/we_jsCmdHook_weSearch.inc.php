<?php
					
include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/meta.conf.php');

?>
    case "tool_weSearch_edit":
		new jsWindow(url,"tool_window_weSearch",-1,-1,970,760,true,true,true,true);
	break;
	case "tool_weSearch_new_forDocuments":
    case "tool_weSearch_new_forTemplates":
    case "tool_weSearch_new_forObjects":
    case "tool_weSearch_new_advSearch":
	case "tool_weSearch_delete":
	case "tool_weSearch_save":
	case "tool_weSearch_exit":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='tool_window_weSearch'){ jsWindow"+k+"Object.wind.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		wind.focus();
	break;