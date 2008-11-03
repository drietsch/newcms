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

?>
			case "edit_banner":
			case "edit_banner_ifthere":
				new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
				break;
			case "default_banner":
				var fo=false;
				for(var k=jsWindow_count-1;k>-1;k--){
	            	eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
	            	if(fo) break;
			    }
			   	if(typeof(wind) != "undefined") {
			    	wind.focus();
			    }
				new jsWindow(url,"defaultbanner",-1,-1,500,220,true,false,true,true);
				break;
			case "banner_code":
				var fo=false;
				for(var k=jsWindow_count-1;k>-1;k--){
	            	eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
	            	if(fo) break;
			    }
			   	wind.focus();
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
