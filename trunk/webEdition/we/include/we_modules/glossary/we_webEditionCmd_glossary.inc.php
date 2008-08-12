<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

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
			new jsWindow(url,"edit_glossary_settings",-1,-1,490,250,true,true,true,true);
			break;

		case "glossary_dictionaries":
			new jsWindow(url,"edit_glossary_dictionaries",-1,-1,490,250,true,true,true,true);
			break;

		case "help_glossary":
			var fo=false;
			for(var k=jsWindow_count-1;k>-1;k--){
				eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
				if(fo) {
					break;
				}
			}
			wind.focus();
<?php if($online_help):?>
			if(arguments[1]) url="/webEdition/getHelp.php?hid="+arguments[1];
			else url="/webEdition/getHelp.php";
			new jsWindow(url,"help",-1,-1,800,600,true,false,true,true);
<?php else:?>
			url="/webEdition/noAvailable.php";
			new jsWindow(url,"help_no_available",-1,-1,380,140,true,false,true);
<?php endif?>
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



