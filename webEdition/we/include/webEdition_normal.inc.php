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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");

   /**
	* @return void
	* @desc prints the functions needed for the tree.
	*/
	function pWebEdition_Tree(){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weMainTree.inc.php");
		$Tree = new weMainTree("webEdition.php","top","self.Tree","top.load");
		print $Tree->getJSTreeCode();
	}

   /**
	* @return void
	* @desc prints JavaScript functions only needed in normal mode
	*/
	function pWebEdition_JSFunctions(){
		?>
function toggleBusy(w) {
	if(w == busy || firstLoad==false)
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

var widthBeforeDeleteMode = 0;
var widthBeforeDeleteModeSidebar = 0;

	<?php
	}

   /**
	* @return void
	* @desc prints the different cases for the function we_cmd
	*/
	function pWebEdition_JSwe_cmds(){
		?>
		case "new":
			treeData.unselectnode();
			if(typeof(arguments[5])!="undefined") {
				top.weEditorFrameController.openDocument(arguments[1],arguments[2],arguments[3],"",arguments[4],"",arguments[5]);
			} else if(typeof(arguments[4])!="undefined" && arguments[5]=="undefined") {
				top.weEditorFrameController.openDocument(arguments[1],arguments[2],arguments[3],"","","",arguments[5]);
			} else {
				top.weEditorFrameController.openDocument(arguments[1],arguments[2],arguments[3],"",arguments[4]);
			}
			break;

		case "load":
			if(self.Tree)
				if(self.Tree.setScrollY)
					self.Tree.setScrollY();
			we_cmd("setTab",arguments[1]);
			toggleBusy(1);
			we_repl(self.load,url,arguments[0]);
			break;
		case "clear_cache":
			if(confirm("<?php echo $GLOBALS['l_we_cache']["delete_cache"]; ?>")) {
				we_repl(top.load,url,arguments[0]);
			}
			break;
		case "exit_delete":
		case "exit_move":
			deleteMode = false;
			treeData.setstate(treeData.tree_states["edit"]);
			drawTree();

			self.rframe.bframe.document.getElementById("treeHeadFrame").rows = "1,*,40";
			var frameobj = self.rframe.document.getElementById("resizeframeid");
			if (frameobj != null) {
				frameobj.cols = widthBeforeDeleteMode + ",*, "+ widthBeforeDeleteModeSidebar;
			}
			break;
		case "delete":
			if(top.deleteMode != arguments[1]){
				top.deleteMode=arguments[1];
			}
			if(!top.deleteMode &&  treeData.state==treeData.tree_states["select"]){
				treeData.setstate(treeData.tree_states["edit"]);
				drawTree();
			}
			self.rframe.bframe.document.getElementById("treeHeadFrame").rows = "150,*,40";

			var width = top.getTreeWidth();

			widthBeforeDeleteMode = width;

			if (width < 420) {
				top.setTreeWidth(420);
				top.storeTreeWidth(420);
			}
			
			var widthSidebar = top.getSidebarWidth();

			widthBeforeDeleteModeSidebar = widthSidebar;

			if(arguments[2] != 1) we_repl(self.rframe.bframe.treeheader,url,arguments[0]);
			break;
		case "move":
			if(top.deleteMode != arguments[1]){
				top.deleteMode=arguments[1];
			}
			if(!top.deleteMode && treeData.state==treeData.tree_states["selectitem"]){
				treeData.setstate(treeData.tree_states["edit"]);
				drawTree();
			}
			self.rframe.bframe.document.getElementById("treeHeadFrame").rows = "160,*,40";

			var width = top.getTreeWidth();

			widthBeforeDeleteMode = width;

			if (width < 500) {
				top.setTreeWidth(500);
				top.storeTreeWidth(500);
			}
			
			var widthSidebar = top.getSidebarWidth();

			widthBeforeDeleteModeSidebar = widthSidebar;

			if(arguments[2] != 1) {
				we_repl(self.rframe.bframe.treeheader,url,arguments[0]);
			}
			break;

		<?php
	}


   /**
	* @return void
	* @desc the frameset for the SeeMode
	*/
	function pWebEdition_Frameset(){
		?>
<frameset rows="32,*,<?php print ( (isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0)) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="no" onUnload="doUnload()">
	<frame src="header.php" name="header" scrolling="no" noresize>
	<frame src="resizeframe.php" name="rframe" scrolling="no" noresize>
	<frameset cols="25%,25%,10%,10%,*" framespacing="0" border="0" frameborder="no">
		<frame src="<?php print HTML_DIR ?>white.html" name="load" scrolling="no" noresize>
		<frame src="<?php print HTML_DIR ?>white.html" name="load2" scrolling="no" noresize>
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>we_users_ping.php" name="ping" scrolling="no" noresize>
        <frame src="<?php print HTML_DIR ?>white.html" name="postframe" scrolling="no" noresize>
        <frame src="<?php print HTML_DIR ?>white.html" name="plugin" scrolling="no" noresize>
	</frameset>
</frameset>
	<?php
	}
?>