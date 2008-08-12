<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
	* @return void
	* @desc only used in normal mode
	*/
function pWebEdition_Tree(){
}


/**
	* @return void
	* @desc prints JavaScript functions only needed in SeeMode
	*/
function pWebEdition_JSFunctions(){
		?>
function makeNewEntry(icon,id,pid,txt,open,typ,tab){
}
function drawTree(){
}

function info(text){
}

function toggleBusy(w) {
	if(w == busy)
		return;
	if(self.header) {
		if(self.header.toggleBusy) {
			busy=w;
			self.header.toggleBusy(w);
			return;
		}
	}
	setTimeout("toggleBusy("+w+");",300);
}

function doUnload(whichWindow) {
	
	// unlock all open documents
	var _usedEditors = top.weEditorFrameController.getEditorsInUse();
	
	var docIds = "";
	var docTables = "";

	for (frameId in _usedEditors) {
		
		if (_usedEditors[frameId].EditorType != "cockpit") {
		
			docIds += _usedEditors[frameId].getEditorDocumentId() + ",";
			docTables += _usedEditors[frameId].getEditorEditorTable() + ",";
		}
	}
	
	if (docIds) {
		
		top.we_cmd('unlock',docIds,'<?php print $_SESSION["user"]["ID"]; ?>',docTables);
		
		if(top.opener){
			top.opener.focus();
			
		}
	}
    //  close the SEEM-edit-include when exists
    if(top.edit_include){
        top.edit_include.close();
    }
    try{
        if(jsWindow_count) {
            for(i=0;i<jsWindow_count;i++){
        	   eval("jsWindow"+i+"Object.close()");
        	}
        }
		if(browserwind){
			browserwind.close();
		}
    } catch(e){

    }

    //  only when no SEEM-edit-include window is closed
    if(whichWindow != "include"){
        if(opener) {
            opener.location.replace('<?php print WEBEDITION_DIR; ?>we_loggingOut.php');
        }
    }
}
		<?php
}

/**
	* @return void
	* @desc prints the different cases for the function we_cmd
	*/
function pWebEdition_JSwe_cmds(){
		?>
		case "new":
			top.weEditorFrameController.openDocument(arguments[1],arguments[2],arguments[3],"",arguments[4],"",arguments[5]);
			break;
		case "load":
			toggleBusy(1);
			break;
		case "exit_delete":
		case "exit_move":
			deleteMode = false;
		case "delete":
		case "move":
			if(top.deleteMode != arguments[1]){
				top.deleteMode=arguments[1];
			}
			if(arguments[2] != 1) we_repl(top.weEditorFrameController.getActiveDocumentReference(),url,arguments[0]);
			break;
		<?php
}

/**
	* @return void
	* @desc the frameset for the SeeMode
	*/
function pWebEdition_Frameset(){

	if(isset($GLOBALS["SEEM_edit_include"]) && $GLOBALS["SEEM_edit_include"]){	// edit include file
		$we_cmds = "we_cmd[0]=edit_document&";

		for($i=1; $i<sizeof($_REQUEST["we_cmd"]); $i++){
			$we_cmds .= "we_cmd[" . $i . "]=" . $_REQUEST["we_cmd"][$i] . "&";
		}
			?>
<frameset rows="32,*,<?php print (isset($_SESSION["prefs"]["debug_seem"]) && $_SESSION["prefs"]["debug_seem"] != 0) ? "100,100" : "0,0"; ?>" framespacing="0" border="0" frameborder="no" onUnload="doUnload('include')">
	<frame src="header.php?SEEM_edit_include=true" name="header" scrolling="no" noresize>
	<frame src="resizeframe.php?<?php print $we_cmds ?>SEEM_edit_include=true" name="rframe" scrolling="no" noresize>
	<frame src="<?php print HTML_DIR ?>white.html" name="load" scrolling="no" noresize>
	<frame src="<?php print HTML_DIR ?>white.html" name="load2" scrolling="no" noresize>
</frameset>
			<?php

	} else if ($_SESSION["we_mode"] == "seem"){ //	normal SeeMode
			?>
<frameset rows="32,*,<?php print (isset($_SESSION["prefs"]["debug_seem"]) && $_SESSION["prefs"]["debug_seem"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="no" onUnload="doUnload()">
	<frame src="header.php" name="header" scrolling="no" noresize>
	<frame src="resizeframe.php" name="rframe" scrolling="no" noresize>
	<frameset cols="25%,25%,30%,10%,10%" framespacing="0" border="0" frameborder="no">
		<frame src="<?php print HTML_DIR ?>white.html" name="load" scrolling="no" noresize>
		<frame src="<?php print HTML_DIR ?>white.html" name="load2" scrolling="no" noresize>
		<frame src="<?php print WE_USERS_MODULE_PATH ?>we_users_ping.php" name="ping" scrolling="no" noresize>
        <frame src="<?php print HTML_DIR ?>white.html" name="postframe" scrolling="no" noresize>
        <frame src="<?php print HTML_DIR ?>white.html" name="plugin" scrolling="no" noresize>
	</frameset>
</frameset>
			<?php
	}
}

?>