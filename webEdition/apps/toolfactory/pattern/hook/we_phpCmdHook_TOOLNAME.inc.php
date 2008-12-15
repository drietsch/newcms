 
switch($_REQUEST["we_cmd"][0]){
	case 'tool_<?php print $TOOLNAME; ?>_edit':
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/tools_frameset.php');
	break;
}