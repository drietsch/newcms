// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/conf/meta.conf.php');
?>

        case "tool_<?php print $metaInfo['name']?>_edit":
			new jsWindow(url,"tool_window_<?php print $metaInfo['name']?>",-1,-1,970,760,true,true,true,true);
		break;
		case "tool_<?php print $metaInfo['name']?>_new":
		case "tool_<?php print $metaInfo['name']?>_new_group":
		case "tool_<?php print $metaInfo['name']?>_delete":
		case "tool_<?php print $metaInfo['name']?>_save":
		case "tool_<?php print $metaInfo['name']?>_exit":
		case "tool_navigation_reset_customer_filter":
			var fo=false;
			for(var k=jsWindow_count-1;k>-1;k--){
				eval("if(jsWindow"+k+"Object.ref=='tool_window_<?php print $metaInfo['name']?>'){ jsWindow"+k+"Object.wind.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
				if(fo) break;
			}
			wind.focus();
		break;
		case "tool_navigation_rules":
			new jsWindow("/webEdition/we/include/we_tools/navigation/edit_navigation_rules_frameset.php","tool_navigation_rules",-1,-1,680,580,true,true,true,true);
		break;
		case "tool_navigation_edit_navi":
			new jsWindow("/webEdition/we/include/we_tools/navigation/weNaviEditor.php?we_cmd[1]="+arguments[1],"we_navieditor",-1,-1,600,350,true,false,true,true);
		break;
		
		case "tool_navigation_do_reset_customer_filter":
			we_repl(self.load,url,arguments[0]);
		break;