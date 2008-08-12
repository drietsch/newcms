<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

?>

        case "in_workflow":
        case "pass":
        case "decline":
            new jsWindow(url,"choose_workflow",-1,-1,420,320,true,true,true,true);
			break;
        case "finish_workflow":
			we_repl(self.load,url,arguments[0]);
			break;
        case "edit_workflow":
        case "edit_workflow_ifthere":
            new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
			break;
	        case "new_user":
	    case "exit_workflow":
        case "save_workflow":
        case "new_workflow":
        case "delete_workflow":
	case "empty_log":
		var fo=false;
		for(var k=jsWindow_count-1;k>-1;k--){
			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
			if(fo) break;
		}
		if(wind && arguments[0]!="empty_log") wind.focus();
        break;
