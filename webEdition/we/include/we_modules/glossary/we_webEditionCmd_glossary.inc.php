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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");

?>

		// Glossary
		case "check_glossary":

			var _EditorFrame = top.weEditorFrameController.getActiveEditorFrame();
			if(		_EditorFrame != false
				&&	_EditorFrame.getEditorType() == "model"
				&&	(
							_EditorFrame.getEditorContentType() == "text/webedition"
						||	_EditorFrame.getEditorContentType() == "objectFile"
					)
				) {

				var transaction = _EditorFrame.getEditorTransaction();
				url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=check_glossary&we_cmd[2]=" + transaction + "&we_cmd[3]=checkOnly";
				new jsWindow(url,"check_glossary",-1,-1,730,400,true,false,true);

			} else {
				<?php print we_message_reporting::getShowMessageCall($l_glossary["glossary_check_not_avalaible"], WE_MESSAGE_ERROR); ?>

			}
			break;

        case "edit_glossary_acronym":
        case "edit_glossary_abbreviation":
        case "edit_glossary_foreignword":
        case "edit_glossary_link":
        case "edit_glossary_ifthere":
        	new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
        	break;

		case "glossary_settings":
			var fo=false;
				for(var k=jsWindow_count-1;k>-1;k--){
	            	eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
	            	if(fo) break;
			    }
			   	wind.focus();
			new jsWindow(url,"edit_glossary_settings",-1,-1,490,250,true,true,true,true);
			break;

		case "glossary_dictionaries":
			new jsWindow(url,"edit_glossary_dictionaries",-1,-1,490,250,true,true,true,true);
			break;


<?php
	if(sizeof($GLOBALS['weFrontendLanguages'])>0) {

		echo '	case ((arguments[0].substr(0, 13) == "Glossary:new_") ? arguments[0] : false):' . "\n";
		echo "		tempargs = arguments[0].split(\"\:\");\n";
		echo "		var fo=false;\n";
		echo "		for(var k=jsWindow_count-1;k>-1;k--) {\n";
		echo "			eval(\"if(jsWindow\"+k+\"Object.ref=='edit_module'){ jsWindow\"+k+\"Object.wind.content.we_cmd('\"+tempargs[1]+\"','\"+tempargs[2]+\"');fo=true;wind=jsWindow\"+k+\"Object.wind}\");\n";
		echo "			if(fo) {\n";
		echo "				break;\n";
		echo "			}\n";
		echo "		}\n";
		echo "		wind.focus();\n";
		echo "		break;\n";

	}
?>
        case "new_glossary_acronym":
        case "new_glossary_abbreviation":
        case "new_glossary_foreignword":
        case "new_glossary_link":
        case "exit_glossary":

        case "save_exception":
        case "save_glossary":
        case "delete_glossary":
        	var fo=false;
        	for(var k=jsWindow_count-1;k>-1;k--) {
        		if(arguments[1] != undefined) {
        			eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"','"+arguments[1]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
        			} else {
        				eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
        			}
        			if(fo) {
        			break;
        		}
        	}
        	wind.focus();
        	break;

        case "unlock":
        	we_repl(self.load,url,arguments[0]);
        	break;



