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
		<?php if(isset($GLOBALS['BROWSER']) && $GLOBALS['BROWSER']=='IE') print "wind.focus()"; ?>;
        break;
