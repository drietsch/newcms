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
			case "edit_banner":
			case "edit_banner_ifthere":
				new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
				break;
			case "default_banner":
				new jsWindow(url,"defaultbanner",-1,-1,500,220,true,false,true,true);
				break;
			case "banner_code":
				new jsWindow(url,"bannercode",-1,-1,500,420,true,true,true,false);
				break;
			case "new_banner":
			case "new_bannergroup":
			case "save_banner":
			case "exit_banner":
			case "delete_banner":
				var fo=false;
				for(var k=jsWindow_count-1;k>-1;k--){
					eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
					if(fo) break;
				}
				if(wind && arguments[0]!="empty_log") wind.focus();
				break;
