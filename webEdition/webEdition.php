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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/SEEM.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] .  '/multiEditor.inc.php');


//	we need some different functions for normal mode and seeMode
//	these function all have the same name: pWebEditionXXXX() and
//	are located in 2 different files. Depending on mode the correct
//	file is included and the matching functions are included.

if($_SESSION["we_mode"]         == "normal"){	//	working in normal mode
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/webEdition_normal.inc.php");
} else if ($_SESSION["we_mode"] == "seem"){		//	working in super-easy-edit-mode
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/webEdition_seem.inc.php");
}


if(!isset($SEEM_edit_include) || !$SEEM_edit_include){

    if(defined("SCHEDULE_TABLE")) {
    	// convert old schedule data to new format
    	check_and_convert_to_sched_pro();
    	trigger_schedule();

    }
	// make the we_backup dir writable for all, so users can copy backupfiles with ftp in it
    @chmod($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_backup",0777);
}


//	check session
protect();

cleanTempFiles();
$sn = SERVER_NAME;

if(ereg('@',$sn)) {
	list($foo,$sn) = explode('@',$sn);
}

//	unlock everything, when a new window is opened.
if(!isset($_REQUEST["we_cmd"][0]) || $_REQUEST["we_cmd"][0] != "edit_include_document"){
	$DB_WE->query("
		DELETE
		FROM ".LOCK_TABLE."
		WHERE UserID='".abs($_SESSION["user"]["ID"])."'
	");
}
$DB_WE->query("
	UPDATE ".USER_TABLE."
	SET Ping=0
	WHERE Ping < ".(time() - (PING_TIME+PING_TOLERANZ))
);



htmlTop("webEdition - ".$sn." - ".$_SESSION["user"]["Username"]);

$online_help=true;

?>
<link rel="SHORTCUT ICON" href="/webEdition/images/webedition.ico">
<script src="<?php print JS_DIR; ?>windows.js" language="JavaScript" type="text/javascript"></script>
<script type="text/javascript" src="<?php print JS_DIR . "weJsStrings.php"; ?>"></script>
<script src="<?php print JS_DIR; ?>md5.js" language="JavaScript" type="text/javascript"></script>
<script src="<?php print JS_DIR; ?>weNavigationHistory.php" type="text/javascript"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>keyListener.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>messageConsole.js"></script>

<script language="JavaScript" type="text/javascript">

self.focus();

var Header = null;
var Tree = null;
var Vtabs = null;
var TreeInfo = null;

var busy = 0;
var balken=null;
var firstLoad = false;
var hot = 0;
var last=0;
var lastUsedLoadFrame = null;

var we_demo = false;

var nlHTMLMail = 0;
var browserwind = null;
var makefocus = null;

var weplugin_wait=null;

// is set in headermenu.php
var weSidebar = null;

// seeMode
var seeMode = <?php print ($_SESSION["we_mode"] == "seem") ? "true" : "false";  ?>; // in seeMode
var seeMode_edit_include = <?php print (isset($SEEM_edit_include) && $SEEM_edit_include) ? "true" : "false";  ?>; // in edit_include mode of seeMode

var wePerms = {
	"ADMINISTRATOR"      : <?php echo $_SESSION["perms"]["ADMINISTRATOR"]; ?>,
	"DELETE_DOCUMENT"    : <?php echo $_SESSION["perms"]["DELETE_DOCUMENT"]; ?>,
	"DELETE_TEMPLATE"    : <?php echo $_SESSION["perms"]["DELETE_TEMPLATE"]; ?>,
	"DELETE_OBJECT"      : <?php echo $_SESSION["perms"]["DELETE_OBJECT"]; ?>,
	"DELETE_OBJECTFILE"  : <?php echo $_SESSION["perms"]["DELETE_OBJECTFILE"]; ?>,
	"DELETE_DOC_FOLDER"  : <?php echo $_SESSION["perms"]["DELETE_DOC_FOLDER"]; ?>,
	"DELETE_TEMP_FOLDER" : <?php echo $_SESSION["perms"]["DELETE_TEMP_FOLDER"]; ?>
}
/*##################### messaging function #####################*/

// this variable contains settings how to deal with settings
// it has to be set when changing the preferences
/**
 * setting integer, any sum of 1,2,4
 */
var messageSettings = <?php print (isset($_SESSION["prefs"]["message_reporting"]) && $_SESSION["prefs"]["message_reporting"] > 0  ? $_SESSION["prefs"]["message_reporting"] : (WE_MESSAGE_ERROR + WE_MESSAGE_WARNING + WE_MESSAGE_NOTICE)); ?>;


var weEditorWasLoaded = false;

function reload_weJsStrings(newLng) {
	if (!newLng) {
		newLng = "<?php print $GLOBALS['WE_LANGUAGE'] ?>";
	}
	var newSrc = "<?php print JS_DIR; ?>weJsStrings.php?lng=" + newLng;
	var elem = document.createElement("script");
	elem.src = newSrc;
	document.getElementsByTagName("head")[0].appendChild( elem );

}

var setPageNrCallback = {
	success: function(o) {
	},
	failure: function(o) {
		alert("Error: Unable to call RPC: setPageNr!");
	}
}

/**
 * setting is built like the unix file system privileges with the 3 options
 * see notices, see warnings, see errors
 *
 * 1 => see Notices
 * 2 => see Warnings
 * 4 => see Errors
 *
 * @param message string
 * @param prio integer one of the values 1,2,4
 * @param win object reference to the calling window
 */
function showMessage(message, prio, win){

	if (!win) {
		win = window;
	}
	if (!prio) { // default is error, to avoid missing messages
		prio = 4;
	}

	// always show in console !
	messageConsole.addMessage( prio, message );

	if (prio & messageSettings) { // show it, if you should

		// the used vars are in file JS_DIR . "weJsStrings.php";
		switch (prio) {
			// Notice
			case 1:
				win.alert(we_string_message_reporting_notice + ":\n" + message);
				break;

			// Warning
			case 2:
				win.alert(we_string_message_reporting_warning + ":\n" + message);
				break;

			// Error
			case 4:
				win.alert(we_string_message_reporting_error + ":\n" + message);
				break;
		}
	}
}

/*##############################################################*/

function weDummy(o) { // AJAX Requests
	// dummy
}

if(self.location != top.location) {
	top.location = self.location;
}

// new functions
function doClickDirect(id,ct,table,fenster){
	if(!fenster){
		fenster = window;
	}
	//  the actual position is the top-window, nmaybe the first window was closed
	if(!fenster.top.opener || fenster.top.opener.win || fenster.top.opener.closed){
		top.weEditorFrameController.openDocument(table,id,ct);

	} else {
		//  If a include-file is edited and another link is chosen, it will appear on the main window. And the pop-up will be closed.
		<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_we_SEEM"]["open_link_in_SEEM_edit_include"], WE_MESSAGE_WARNING); ?>
		top.opener.top.doClickDirect(id,ct,table,top.opener);
		// clean session
		// get the EditorFrame - this is important due to edit_include_mode!!!!
		var _ActiveEditor = top.weEditorFrameController.getActiveEditorFrame();
		if (_ActiveEditor) {
			top.we_cmd('unlock',_ActiveEditor.getEditorDocumentId(),'<?php print $_SESSION["user"]["ID"]; ?>',_ActiveEditor.getEditorEditorTable(), _ActiveEditor.getEditorTransaction());
		}
		top.close();
	}
}

function doClickWithParameters(id,ct,table,parameters){
	top.weEditorFrameController.openDocument(table,id,ct,'','','','','',parameters);

}

function doExtClick(url){

	// split url in url and parameters !!!
	var parameters = "";
	if ( (_position = url.indexOf("?")) != -1 ) {
		parameters = url.substring(_position);
		url = url.substring(0, _position);
	}

	top.weEditorFrameController.openDocument('','','','','',url,'','',parameters);

}

<?php
if (defined('MESSAGING_SYSTEM')) {
?>
	function update_msg_quick_view() {
		header.header_msg.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>header_msg.php?r=<?php srand ((double) microtime() * 1000000);echo rand();?>";
	}

	function msg_update() {
	    try{
    		var fo=false;
    		for(var k=jsWindow_count-1;k>-1;k--) {
    			eval("if((jsWindow"+k+"Object.ref=='edit_module') && !jsWindow"+k+"Object.wind.closed && (typeof(jsWindow" + k + "Object.wind.content.update_messaging) == 'function')){ jsWindow"+k+"Object.wind.content.update_messaging(); fo=true}");
    			if(fo)
    				break;
    		}
	    } catch(e){

        }
	}
<?php
}
?>


function weSetCookie(name, value, expires, path, domain){
	var doc = self.document;
	doc.cookie = name + "=" + escape(value) +
	((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
	((path == null)    ? "" : "; path=" + path) +
	((domain == null)  ? "" : "; domain=" + domain);
}

function treeResized() {
	if (navigator.appVersion.indexOf("Safari") == -1) {
		var treeWidth = getTreeWidth();
		if (treeWidth <= 22) {
			setTreeArrow("right");
		} else {
			setTreeArrow("left");
		}
		storeTreeWidth(treeWidth);
	}
}

function setTreeArrow(direction) {
	self.rframe.bframe.bm_vtabs.document.getElementById("arrowImg").src = "<?php print IMAGE_DIR ?>button/icons/direction_" + direction+ ".gif";
}

function getTreeWidth() {
	if (navigator.appVersion.indexOf("MSIE")) {
		return self.rframe.bframe.document.body.offsetWidth-4;
	}
	var frameobj = self.rframe.document.getElementById("resizeframeid");
	var cols = frameobj.cols;
	var pairs = cols.split(",");
	return pairs[0];
}

function getSidebarWidth() {

	var frameobj = self.rframe.document.getElementById("resizeframeid");
	var cols = frameobj.cols;
	var pairs = cols.split(",");
	return pairs[2];
}


function setTreeWidth(w) {
	var frameobj = self.rframe.document.getElementById("resizeframeid");
	var split = new Array;
	split = frameobj.cols.split(',');
	frameobj.cols = w + ",*," + split[2];
}

function storeTreeWidth(w) {
	var ablauf = new Date();
	var newTime = ablauf.getTime() + 30758400000;
	ablauf.setTime(newTime);
	weSetCookie("treewidth_main",w,ablauf,"/");
}

function focusise(){
	setTimeout("self.makefocus.focus();self.makefocus=null;",200);
}

function we_repl(target,url) {
	if(target) {
		try {
			// use 2 loadframes to avoid missing cmds
			if (target.name == "load" || target.name == "load2") {
	
				if (top.lastUsedLoadFrame == target.name) {
	
					if (target.name == "load") {
						target = self.load2;
					} else {
						target = self.load;
					}
				}
				top.lastUsedLoadFrame = target.name;
			}
		}
		catch(e) {
			// Nothing	
		}
		target.location.replace(url);
	}
}

function submit_we_form(formlocation, target, url){
	try{
		if(formlocation){
			if(formlocation.we_submitForm){
				formlocation.we_submitForm(target.name, url);
				return true;
			}
		}
	} catch(e){

	}
	return false;
}

function we_sbmtFrm(target,url, source) {
	if (typeof(source) == "undefined") {
		source = top.weEditorFrameController.getVisibleEditorFrame();
	}
	return submit_we_form(source, target, url);

}

function we_sbmtFrmC(target,url) {
	return submit_we_form(top.weEditorFrameController.getActiveDocumentReference(), target, url);
}

function we_setEditorWasLoaded(flag) {
	self.weEditorWasLoaded = flag;
}

function we_setEditorHot() {
	self.weEditorWasLoaded = flag;
}

function we_cmd() {
    var hasPerm = 0;
	var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?";
	var cmsurl = "<?php print WEBEDITION_DIR;?>cms/index.php/";
	for(var i = 0; i < arguments.length; i++) {
		url += "we_cmd["+i+"]="+escape(arguments[i]);
		if(i < (arguments.length - 1))
			url += "&";
	}

	if (window.screen) {
		h = ((screen.height - 100) > screen.availHeight ) ? screen.height - 100 : screen.availHeight;
		//h = screen.availHeight - <?php print ($BROWSER == "IE" && $SYSTEM == "WIN") ? 73 : (($BROWSER == "NN" && $SYSTEM == "WIN") ? 50: 40) ?>;
		w = screen.availWidth; // - <?php print ($SYSTEM == "WIN") ? 10 : 20 ?>;
	}

	//	When coming from a we_cmd, always mark the document as opened with we !!!!
	if( top.weEditorFrameController &&
		top.weEditorFrameController.getActiveDocumentReference
	){
		try {
			var _string = ',edit_document,new_document,open_extern_document,edit_document_with_parameters,new_folder,edit_folder';
			if ( _string.indexOf("," + arguments[0] + ",") == -1 ) {
				top.weEditorFrameController.getActiveDocumentReference().openedWithWE = true;
			}
		} catch (exp) {

		}
	}
	switch (arguments[0]) {
		case "exit_modules":
	        if(jsWindow_count){
				for(i=0;i<jsWindow_count;i++){
					eval("if(jsWindow"+i+"Object.ref=='edit_module') jsWindow"+i+"Object.close()");
				}
			}
        	break;
		<?php

			//	In we.inc.php all names of the installed modules have already been searched
			//	so we only have to use the array $_we_active_modules

			for($i=0;$i<sizeof($_we_active_modules);$i++){

				if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/" . $_we_active_modules[$i] . "/we_webEditionCmd_" . $_we_active_modules[$i] . ".inc.php")){

					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/" . $_we_active_modules[$i] . "/we_webEditionCmd_" . $_we_active_modules[$i] . ".inc.php");
				}

			}

			{ // deal with uninstalled modules
				foreach($_we_available_modules as $m) {
					print 'case "edit_'.$m["name"].'_ifthere":';
				}
				print '
						new jsWindow(url,"module_info",-1,-1,380,250,true,true,true);
							break;';
			}
		?>
		<?php
			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
			$_jsincludes = weToolLookup::getJsCmdInclude();
			if(!empty($_jsincludes)) {
				foreach ($_jsincludes as $_jsinclude) {
					include_once($_jsinclude);
				}
			}
		?>
		case "we_tracker":
			new jsWindow("<?php print defined('WE_TRACKER_DIR') ? WE_TRACKER_DIR : '/pageLogger'; ?>/controlcenter.php","we_tracker",-1,-1,1024,768,true,true,true);
			break;
		case "openFirstStepsWizardMasterTemplate":
		case "openFirstStepsWizardDetailTemplates":
			new jsWindow(url,"we_firststepswizard",-1,-1,1024,768,true,true,true);
			break;

		case "openUnpublishedObjects":
			we_cmd("tool_weSearch_edit","", 3, 7);
			break;

		case "openUnpublishedPages":
			we_cmd("tool_weSearch_edit","", 3, 4);
			break;

		case "openCatselector":
			new jsWindow(url,"we_cateditor",-1,-1,<?php echo WINDOW_CATSELECTOR_WIDTH . ',' .WINDOW_CATSELECTOR_HEIGHT;?>,true,true,true,true);
			break;

		case "openSidebar":
			top.weSidebar.open("default");
			break;

		case "loadSidebarDocument":
			top.frames["rframe"].frames["sidebar"].frames["weSidebarContent"].location.href = url;
			break;
		
		case "versions_preview":
			new jsWindow(url,"version_preview",-1,-1,1000,750,true,true,true,true);
			break;
		case "versions_wizard":
			new jsWindow(url,"versions_wizard",-1,-1,600,620,true,false,true);
			break;
		
		case "versioning_log":
			new jsWindow(url,"versioning_log",-1,-1,600,500,true,false,true);
			break;

		case "delete_single_document_question":
			var cType    = top.weEditorFrameController.getActiveEditorFrame().getEditorContentType();
			var eTable   = top.weEditorFrameController.getActiveEditorFrame().getEditorEditorTable();
			var isFolder = cType == "folder" ? 1 : 0;
			var hasPerm = 0;
			
			if(wePerms.ADMINISTRATOR) {
				hasPerm = 1;
			} else if(isFolder) {
				if(eTable == "<?php echo FILE_TABLE; ?>"  && wePerms.DELETE_DOC_FOLDER) {
					hasPerm = 1;
				} else if(eTable == "<?php echo TEMPLATES_TABLE; ?>"  && wePerms.DELETE_TEMP_FOLDER) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_FILES_TABLE; ?>"  && wePerms.DELETE_OBJECTFILE) {
					hasPerm = 1;
				} else {
					hasPerm = 0;
				}
			} else {
				if(eTable == "<?php echo FILE_TABLE; ?>"  && wePerms.DELETE_DOCUMENT) {
					hasPerm = 1;
				} else if(eTable == "<?php echo TEMPLATES_TABLE; ?>"  && wePerms.DELETE_TEMPLATE) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_FILES_TABLE; ?>"  && wePerms.DELETE_OBJECTFILE) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_TABLE; ?>"  && wePerms.DELETE_OBJECT) {
					hasPerm = 1;
				} else {
					hasPerm = 0;
				}
			}

			toggleBusy(1);
			if (weEditorFrameController.getActiveDocumentReference()) {
				if(!hasPerm) {
					<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["no_perms_action"], WE_MESSAGE_ERROR); ?>
				} else if (window.confirm("<?php print $l_alert['delete_single']['confirm_delete'];?>")) {
					url2 = url.replace(/we_cmd\[0\]=delete_single_document_question/g, "we_cmd[0]=delete_single_document");
					submit_we_form(top.weEditorFrameController.getActiveDocumentReference().frames["3"], self.load, url2 + "&we_cmd[2]=" + top.weEditorFrameController.getActiveEditorFrame().getEditorEditorTable());
				}
			} else {
				<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_global"]["no_document_opened"], WE_MESSAGE_ERROR); ?>
			}
			break;
			
		case "delete_single_document":
			var cType    = top.weEditorFrameController.getActiveEditorFrame().getEditorContentType();
			var eTable   = top.weEditorFrameController.getActiveEditorFrame().getEditorEditorTable();
			var isFolder = cType == "folder" ? 1 : 0;
			var hasPerm = 0;
			
			if(wePerms.ADMINISTRATOR) {
				hasPerm = 1;
			} else if(isFolder) {
				if(eTable == "<?php echo FILE_TABLE; ?>"  && wePerms.DELETE_DOC_FOLDER) {
					hasPerm = 1;
				} else if(eTable == "<?php echo TEMPLATES_TABLE; ?>"  && wePerms.DELETE_TEMP_FOLDER) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_FILES_TABLE; ?>"  && wePerms.DELETE_OBJECTFILE) {
					hasPerm = 1;
				} else {
					hasPerm = 0;
				}
			} else {
				if(eTable == "<?php echo FILE_TABLE; ?>"  && wePerms.DELETE_DOCUMENT) {
					hasPerm = 1;
				} else if(eTable == "<?php echo TEMPLATES_TABLE; ?>"  && wePerms.DELETE_TEMPLATE) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_FILES_TABLE; ?>"  && wePerms.DELETE_OBJECTFILE) {
					hasPerm = 1;
				} else if(eTable == "<?php echo OBJECT_TABLE; ?>"  && wePerms.DELETE_OBJECT) {
					hasPerm = 1;
				} else {
					hasPerm = 0;
				}
			}

			toggleBusy(1);
			if (weEditorFrameController.getActiveDocumentReference()) {
				if(!hasPerm) {
					<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["no_perms_action"], WE_MESSAGE_ERROR); ?>
				} else {
					submit_we_form(top.weEditorFrameController.getActiveDocumentReference().frames["3"], self.load, url + "&we_cmd[2]=" + top.weEditorFrameController.getActiveEditorFrame().getEditorEditorTable());
				}
			} else {
				<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_global"]["no_document_opened"], WE_MESSAGE_ERROR); ?>
			}
			break;
		case "do_delete":
			toggleBusy(1);
			submit_we_form(self.rframe.bframe.treeheader, self.load,url)
			//we_sbmtFrmC(self.load,url);
			break;
		case "move_single_document":
			toggleBusy(1);
			submit_we_form(top.weEditorFrameController.getActiveDocumentReference().frames["3"], self.load, url);
			break;
		case "do_move":
			toggleBusy(1);
			submit_we_form(self.rframe.bframe.treeheader, self.load,url)
			//we_sbmtFrmC(self.load,url);
			break;
		case "open_document":
			we_cmd("load","<?php print FILE_TABLE; ?>");
			url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=openDocselector&we_cmd[1]=&we_cmd[2]=<?php print FILE_TABLE; ?>&we_cmd[5]=<?php print rawurlencode("opener.top.weEditorFrameController.openDocument(table,currentID,currentType)"); ?>&we_cmd[9]=1";
			new jsWindow(url,"we_dirChooser",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . "," . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true,true);
			break;
		case "open_template":
			we_cmd("load","<?php print TEMPLATES_TABLE; ?>");
			url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=openDocselector&we_cmd[8]=text/weTmpl&we_cmd[2]=<?php print TEMPLATES_TABLE; ?>&we_cmd[5]=<?php print rawurlencode("opener.top.weEditorFrameController.openDocument(table,currentID,currentType)"); ?>&we_cmd[9]=1";
			new jsWindow(url,"we_dirChooser",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . "," . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true,true);
			break;
		case "change_passwd":
			new jsWindow(url,"we_change_passwd",-1,-1,250,220,true,false,true,false);
			break;
		case "update":
			new jsWindow("<?php print WEBEDITION_DIR; ?>/liveUpdate/liveUpdate.php?active=update","we_update_<?php print session_id(); ?>",-1,-1, 600,500,true,true,true);
			break;
		case "upgrade":
			new jsWindow("<?php print WEBEDITION_DIR; ?>/liveUpdate/liveUpdate.php?active=upgrade","we_update_<?php print session_id(); ?>",-1,-1, 600,500,true,true,true);
			break;
		case "moduleinstallation":
			new jsWindow("<?php print WEBEDITION_DIR; ?>/liveUpdate/liveUpdate.php?active=modules","we_update_<?php print session_id(); ?>",-1,-1, 600,500,true,true,true);
			break;
		case "languageinstallation":
			new jsWindow("<?php print WEBEDITION_DIR; ?>/liveUpdate/liveUpdate.php?active=languages","we_update_<?php print session_id(); ?>",-1,-1, 600,500,true,true,true);
			break;
		case "del":
			we_cmd('delete',1,arguments[2]);
			treeData.setstate(treeData.tree_states["select"]);
			top.treeData.unselectnode();
			top.drawTree();
			break;
		case "mv":
			we_cmd('move',1,arguments[2]);
			treeData.setstate(treeData.tree_states["selectitem"]);
			top.treeData.unselectnode();
			top.drawTree();
			break;
        case "changeLanguageRecursive":
			we_repl(self.load,url,arguments[0]);
			break;
		case "logout":
			we_repl(self.load,url,arguments[0]);
			break;
		case "dologout":
			// before the command 'logout' is executed, ask if unsaved changes should be saved
			if ( top.weEditorFrameController.doLogoutMultiEditor() ) {
				we_cmd('logout');

			}
			break;
		case "exit_multi_doc_question":
			new jsWindow(url,"exit_multi_doc_question",-1,-1,500,300,true,false,true);
			break;
		case "loadFolder":
		case "closeFolder":
			we_repl(self.load,url,arguments[0]);
			break;
		case "reload_editfooter":
			we_repl(top.weEditorFrameController.getActiveDocumentReference().frames[3],url,arguments[0]);
			break;
		case "rebuild":
			new jsWindow(url,"rebuild",-1,-1,609,645,true,false,true);
			break;
		case "clear_cache":
			if(confirm("<?php echo $l_we_cache["delete_cache"]; ?>")) {
				we_repl(top.load,url,arguments[0]);
			}
			break;
		case "openPreferences":
			new jsWindow(url,"preferences", -1, -1, 540, 670, true, true, true, true);
			break;
		case "editCat":
			we_cmd('openCatselector','','<?php print CATEGORY_TABLE; ?>','','','','','',1);
			break;
		case "editThumbs":
			new jsWindow(url, "thumbnails", -1, -1, 500, 550, true, true, true);
			break;
		case "editMetadataFields":
			new jsWindow(url, "metadatafields", -1, -1, 500, 550, true, true, true);
			break;
		case "doctypes":
			new jsWindow(url,"doctypes",-1,-1,800,670,true,true,true);
			break;
		case "info":
			new jsWindow(url,"info",-1,-1,432,350,true,false,true);
			break;
		case "webEdition_online":
			new jsWindow("http://www.living-e.com/webEdition/","webEditionOnline",-1,-1,960,700,true,true,true,true);
			break;
		case "snippet_shop":
			alert("Es gibt noch keine URL f�r die Snippets Seite");
			break;
		case "help_modules":
            var fo=false;
            for(var k=jsWindow_count-1;k>-1;k--){
              eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
              if(fo) break;
		    }
		    wind.focus();
            url="/webEdition/getHelp.php";
            new jsWindow(url,"help",-1,-1,800,600,true,false,true,true);
            break;
        case "info_modules":
            var fo=false;
            for(var k=jsWindow_count-1;k>-1;k--){
              eval("if(jsWindow"+k+"Object.ref=='edit_module'){ fo=true;wind=jsWindow"+k+"Object.wind}");
              if(fo) break;
		    }
		    wind.focus();
            url="/webEdition/we_cmd.php?we_cmd[0]=info";
            new jsWindow(url,"info",-1,-1,432,350,true,false,true);
            break;
		case "help_tools":
            var fo=false;
            for(var k=jsWindow_count-1;k>-1;k--){
              eval("if(jsWindow"+k+"Object.ref=='tool_window' || jsWindow"+k+"Object.ref=='tool_window_navigation' || jsWindow"+k+"Object.ref=='tool_window_weSearch'){ fo=true;wind=jsWindow"+k+"Object.wind}");
              if(fo) break;
		    }
		    wind.focus();
            url="/webEdition/getHelp.php";
            new jsWindow(url,"help",-1,-1,800,600,true,false,true,true);
            break;
        case "info_tools":
            var fo=false;
            for(var k=jsWindow_count-1;k>-1;k--){
              eval("if(jsWindow"+k+"Object.ref=='tool_window' || jsWindow"+k+"Object.ref=='tool_window_navigation' || jsWindow"+k+"Object.ref=='tool_window_weSearch'){ fo=true;wind=jsWindow"+k+"Object.wind}");
              if(fo) break;
		    }
		    wind.focus();
            url="/webEdition/we_cmd.php?we_cmd[0]=info";
            new jsWindow(url,"info",-1,-1,432,350,true,false,true);
            break;
		case "help":
			<?php if($online_help):?>
				if(arguments[1])
					url="/webEdition/getHelp.php?hid="+arguments[1];
				else
					url="/webEdition/getHelp.php";
				new jsWindow(url,"help",-1,-1,720,600,true,false,true,true);
			<?php else:?>
				url="/webEdition/noAvailable.php";
				new jsWindow(url,"help_no_available",-1,-1,380,140,true,false,true);
			<?php endif?>
			break;
		case "help_isp":
			<?php
			if(defined("ISP_VERSION") && ISP_VERSION){
			?>
			we_repl(self.load,"/_configuration/help/index.php",arguments[0]);
			<?php
			}
			?>
			break;
		case "openSelector":
			new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_SELECTOR_WIDTH . ',' .WINDOW_SELECTOR_HEIGHT;?>,true,true,true,true);
			break;
		case "openDirselector":
			new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_DIRSELECTOR_WIDTH . ',' .WINDOW_DIRSELECTOR_HEIGHT;?>,true,true,true,true);
			break;
		case "openDocselector":
			new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . ',' .WINDOW_DOCSELECTOR_HEIGHT;?>,true,true,true,true);
			break;
		case "setTab":
			if(self.Vtabs)
				if(self.Vtabs.setTab){
					self.Vtabs.setTab(arguments[1]);
					treeData.table=arguments[1];
				}
				else
					setTimeout('we_cmd("setTab","'+arguments[1]+'")',500);
			else
				setTimeout('we_cmd("setTab","'+arguments[1]+'")',500);
			break;
		case "showLoadInfo":
			we_repl(self.Tree,url,arguments[0]);
			break;
		case "update_image":
		case "update_file":
		case "copyDocument":
		case "insert_entry_at_list":
		case "edit_list":
		case "delete_list":
		case "down_entry_at_list":
		case "up_entry_at_list":
		case "down_link_at_list":
		case "up_link_at_list":
		case "add_entry_to_list":
		case "add_link_to_linklist":
		case "change_link":
		case "change_linklist":
		case "delete_linklist":
		case "insert_link_at_linklist":
		case "change_doc_type":
		case "doctype_changed":
		case "remove_image":
		case "delete_link":
		case "delete_cat":
		case "add_cat":
		case "delete_all_cats":
        case "add_schedule":
        case "del_schedule":
		case "add_schedcat":
		case "delete_all_schedcats":
		case "delete_schedcat":
		case "template_changed":
		case "add_navi":
		case "delete_navi":
		case "delete_all_navi":
			// set Editor hot
			_EditorFrame = top.weEditorFrameController.getActiveEditorFrame();
			_EditorFrame.setEditorIsHot(true);
		case "reload_editpage":
		case "wrap_on_off":
		case "restore_defaults":
		case "do_add_thumbnails":
		case "del_thumb":
		case "resizeImage":
		case "rotateImage":
		case "doImage_convertGIF":
		case "doImage_convertPNG":
		case "doImage_convertJPEG":
		case "doImage_crop":
		case "revert_published":
			
			// get editor root frame of active tab
			var _currentEditorRootFrame = top.weEditorFrameController.getActiveDocumentReference();

			// get visible frame for displaying editor page
			var _visibleEditorFrame = top.weEditorFrameController.getVisibleEditorFrame();
						
			// if cmd equals "reload_editpage" and there are parameters, attach them to the url
			if(arguments[0] == "reload_editpage" && _currentEditorRootFrame.parameters){
				url += _currentEditorRootFrame.parameters;
			}
			
			// attach necessary parameters if available 
			if ( arguments[0] == "reload_editpage" && arguments[1]){
				url += '#f'+arguments[1];
			}else if (arguments[0] == "remove_image" && arguments[2]){
				url += '#f'+arguments[2];
			}
			
			// focus visible editor frame
        	if(_visibleEditorFrame){
                _visibleEditorFrame.focus();
        	}

        	if ( _currentEditorRootFrame ) {
 				if (!we_sbmtFrm(_visibleEditorFrame,url,_visibleEditorFrame)) {
					if (arguments[0] != "update_image"){
						// add we_transaction, if not set
						if (!arguments[2]) {
							arguments[2] = top.weEditorFrameController.getActiveEditorFrame().getEditorTransaction();
						}
						url += "&we_transaction="+arguments[2];
					}
					we_repl(_visibleEditorFrame,url,arguments[0]);
					
				}
        	}

			break;
		case "switch_edit_page":
			
			// get editor root frame of active tab
			var _currentEditorRootFrame = top.weEditorFrameController.getActiveDocumentReference();
			
			// get visible frame for displaying editor page
			var _visibleEditorFrame = top.weEditorFrameController.getVisibleEditorFrame();
			
			// frame where the form should be sent from
			var _sendFromFrame = _visibleEditorFrame;
			
			// set flag to true if active frame is frame nr 2 (frame for displaying editor page 1 with content editor)
			var _isEditpageContent = _visibleEditorFrame == _currentEditorRootFrame.frames[2];
			
			// if we switch from WE_EDITPAGE_CONTENT to another page
			if (_isEditpageContent && arguments[1] != <?php print WE_EDITPAGE_CONTENT; ?>) {
				// clean body to avoid flickering
				_currentEditorRootFrame.frames[1].document.body.innerHTML = "";
				// switch to normal frame
				top.weEditorFrameController.switchToNonContentEditor();
				// set var to new active editor frame
				_visibleEditorFrame = _currentEditorRootFrame.frames[1];
				
				// set flag to false
				_isEditpageContent = false;
				
			// if we switch to WE_EDITPAGE_CONTENT from another page
			} else if (!_isEditpageContent && arguments[1] == <?php print WE_EDITPAGE_CONTENT; ?>) {
				// switch to content editor frame
				top.weEditorFrameController.switchToContentEditor();
				// set var to new active editor frame
				_visibleEditorFrame = _currentEditorRootFrame.frames[2];
				// set flag to false
				_isEditpageContent = true;
			}
			
			// frame where the form should be sent to
			var _sendToFrame = _visibleEditorFrame;
			
			// get active transaction		
			var _we_activeTransaction = top.weEditorFrameController.getActiveEditorFrame().getEditorTransaction();

			// if there are parameters, attach them to the url
			if(_currentEditorRootFrame.parameters){
				url += _currentEditorRootFrame.parameters;
			}
			
			// focus the frame
        	if(_visibleEditorFrame){
                _visibleEditorFrame.focus();
        	}
			// if visible frame equals to editpage content and there is already content loaded
			if (_isEditpageContent && typeof(_visibleEditorFrame.weIsTextEditor) != "undefined" && _currentEditorRootFrame.frames[2].location != "about:blank") {
				// tell the backend the right edit page nr and break (don't send the form)
				//YAHOO.util.Connect.setForm(_sendFromFrame.document.we_form);
				YAHOO.util.Connect.asyncRequest('POST', "/webEdition/rpc/rpc.php", setPageNrCallback, 'protocol=json&cmd=SetPageNr&transaction='+_we_activeTransaction+"&editPageNr="+arguments[1]);
				break;
			}


        	if (_currentEditorRootFrame) {
  
  				if (!we_sbmtFrm(_sendToFrame,url,_sendFromFrame)) {
 					// add we_transaction, if not set
					if (!arguments[2]) {
						arguments[2] = _we_activeTransaction;
					}
					url += "&we_transaction="+arguments[2];
					we_repl(_sendToFrame,url,arguments[0]);
					
				}
        	}

			break;
		case "edit_document_with_parameters":
		case "edit_document":
			toggleBusy(1);
			try{
				if(treeData){
					treeData.unselectnode();
					if(arguments[1]) treeData.selection_table=arguments[1];
					if(arguments[2]) treeData.selection=arguments[2];
					if(treeData.selection_table==treeData.table) treeData.selectnode(treeData.selection);
				}
			} catch(e){
			}

			if (nextWindow = top.weEditorFrameController.getFreeWindow() ) {

				_nextContent = nextWindow.getDocumentReference();

				// activate tab and set state to loading
				top.weMultiTabs.addTab( nextWindow.getFrameId() , nextWindow.getFrameId(), nextWindow.getFrameId());

				// use Editor Frame
				nextWindow.initEditorFrameData(
					{
						"EditorType":"model",
						"EditorEditorTable":arguments[1],
						"EditorDocumentId":arguments[2],
						"EditorContentType":arguments[3]
					}
				);

				// set Window Active and show it
				top.weEditorFrameController.setActiveEditorFrame(nextWindow.FrameId);
				top.weEditorFrameController.toggleFrames();

				if(_nextContent.frames && _nextContent.frames["1"]){
					if(!we_sbmtFrm(_nextContent,url)) {
						we_repl(_nextContent,url+"&frameId="+nextWindow.getFrameId());
					}
				}
				else {
					we_repl(_nextContent,url+"&frameId="+nextWindow.getFrameId());
				}

			} else {
				alert("<?php print $l_multiEditor["no_editor_left"]; ?>");

			}
			break;
		case "open_extern_document":
		case "new_document":

			if (nextWindow = top.weEditorFrameController.getFreeWindow() ) {

				_nextContent = nextWindow.getDocumentReference();

				// activate tab and set it status loading ...
				top.weMultiTabs.addTab( nextWindow.getFrameId(), nextWindow.getFrameId(), nextWindow.getFrameId());
				nextWindow.updateEditorTab();

				// set Window Active and show it
				top.weEditorFrameController.setActiveEditorFrame(nextWindow.getFrameId());
				top.weEditorFrameController.toggleFrames();

				// load new document editor
				we_repl(_nextContent,url+"&frameId="+nextWindow.getFrameId());

			} else {
				alert("<?php print $l_multiEditor["no_editor_left"]; ?>");

			}
			break;
		case "close_document":
			if (arguments[1]) { // close special tab
				top.weEditorFrameController.closeDocument( arguments[1] );

			} else if (_currentEditor = top.weEditorFrameController.getActiveEditorFrame()) {
				// close active tab
				top.weEditorFrameController.closeDocument( _currentEditor.getFrameId() );

			}
			break;
		case "close_all_documents":
			top.weEditorFrameController.closeAllDocuments();
			break;
		case "close_all_but_active_document":

			activeId = null;
			if ( arguments[1] ) {
				activeId = arguments[1];
			}
			top.weEditorFrameController.closeAllButActiveDocument(activeId);

			break;
		case "open_url_in_editor":
			we_repl(self.load,url,arguments[0]);
			break;
		case "publish":
		case "unpublish":
			toggleBusy(1);
			doPublish(url,arguments[1],arguments[0]);
			break;
		case "save_document":
			
		
			var _EditorFrame = top.weEditorFrameController.getActiveEditorFrame();

			if( _EditorFrame && _EditorFrame.getEditorFrameWindow().frames && _EditorFrame.getEditorFrameWindow().frames["1"]) {
				_EditorFrame.getEditorFrameWindow().frames["1"].focus();
			}

			toggleBusy(1);

			if ( !arguments[1] ) {
				arguments[1] = _EditorFrame.getEditorTransaction();
			}

			doSave(url,arguments[1],arguments[0]);
			break;
		case "exit_doc_question":
			// return !! important for multiEditor
			return new jsWindow(url,"exit_doc_question",-1,-1,380,130,true,false,true);
			break;
		case "openDelSelector":
			new jsWindow(url,"we_del_selector",-1,-1,<?php echo WINDOW_DELSELECTOR_WIDTH . ',' .WINDOW_DELSELECTOR_HEIGHT;?>,true,true,true,true);
			break;
		case "browse":
			openBrowser();
			break;
		case "home":
			if(top.treeData) {
				top.treeData.unselectnode();
			}
			top.weEditorFrameController.openDocument('','','','open_cockpit');
			break;
		case "browse_server":
            new jsWindow(url,"browse_server",-1,-1,840,400,true,false,true);
			break;
		case "make_backup":
            new jsWindow(url,"export_backup",-1,-1,680,600,true,true,true);
			break;
		case "recover_backup":
			if (we_demo){
				<?php print we_message_reporting::getShowMessageCall($l_global["we_alert"], WE_MESSAGE_ERROR); ?>
			} else {
            	new jsWindow(url,"recover_backup",-1,-1,680,600,true,true,true);
            }
			break;
		case "import_docs":
			new jsWindow(url,"import_docs",-1,-1,480,390,true,false,true);
			break;
		case "import":
			if (we_demo) {
				url += "&we_demo=1"
			}
			new jsWindow(url,"import",-1,-1,600,620,true,false,true);
			break;
		case "export":
			new jsWindow(url,"export",-1,-1,600,540,true,false,true);
			break;
		case "copyWeDocumentCustomerFilter":
			new jsWindow(url,"copyWeDocumentCustomerFilter",-1,-1,400,115,true,true,true);
			break;
		case "copyFolder":
			new jsWindow(url,"copyfolder",-1,-1,550,320,true,true,true);
			break;
		case "del_frag":
			new jsWindow("<?php print WEBEDITION_DIR; ?>delFrag.php?currentID="+arguments[1],"we_del",-1,-1,600,130,true,true,true);
			break;
		case "open_wysiwyg_window":
			if(top.weEditorFrameController.getActiveDocumentReference()){
				top.weEditorFrameController.getActiveDocumentReference().openedWithWE = false;
			}
			var wyw = Math.max(arguments[2],arguments[9]);
			wyw = wyw ? wyw : 800;
			var wyh = parseInt(arguments[3]) +parseInt(arguments[10]);
			wyh = wyh ? wyh : 600;

			if (window.screen) {
				var screen_height = ((screen.height - 50) > screen.availHeight ) ? screen.height - 50 : screen.availHeight;
				screen_height = screen_height - 40;
				var screen_width = screen.availWidth-10;
				wyw = Math.min(screen_width, wyw);
				wyh = Math.min(screen_height, wyh);
			}
			// set new width & height
			
			url = url.replace(/we_cmd\[2\]=[^&]+/, 'we_cmd[2]=' + wyw);
			url = url.replace(/we_cmd\[3\]=[^&]+/, 'we_cmd[3]='+ (wyh-arguments[10]));

			new jsWindow(url,"we_wysiwygWin",-1,-1,Math.max(220,wyw+(document.all ? 0 : ((navigator.userAgent.toLowerCase().indexOf('safari') > -1) ? 20 : 4))),Math.max(100,wyh+60),true,false,true);
			//doPostCmd(arguments,"we_wysiwygWin");
			break;
		case "not_installed_modules":
			we_repl(self.load,url,arguments[0]);
			break;
		case "start_multi_editor":
			we_repl(self.load, url, arguments[0]);
			break;
		case "customValidationService":
			new jsWindow(url,"we_customizeValidation",-1,-1,700,700,true,false,true);
			break;
		
		case "reset_home":

			var _currEditor = top.weEditorFrameController.getActiveEditorFrame();

			if ( _currEditor && _currEditor.getEditorType() == "cockpit" ) {
				if( confirm('<?php print $l_alert['cockpit_reset_settings']; ?>') ){
					top.weEditorFrameController.getActiveDocumentReference().location='<?php print WEBEDITION_DIR; ?>we/include/home.inc.php?we_cmd[0]='+arguments[0];
					if(treeData){
						treeData.unselectnode();
					}
				}
			} else {
				<?php print we_message_reporting::getShowMessageCall( $l_alert['cockpit_not_activated'], WE_MESSAGE_NOTICE); ?>
			}

			break;
		case "edit_home":
			if(arguments[1]=='add'){
				self.load.location='<?php print WEBEDITION_DIR; ?>we/include/we_widgets/cmd.inc.php?we_cmd[0]='+arguments[1]+'&we_cmd[1]='+arguments[2]+'&we_cmd[2]='+arguments[3];
			}
			break;
		case "edit_navi":
			new jsWindow(url,"we_navieditor",-1,-1,400,360,true,true,true,true);
			break;
		case "new_widget_sct":
		case "new_widget_rss":
		case "new_widget_msg":
		case "new_widget_usr":
		case "new_widget_mfd":
		case "new_widget_upb":
		case "new_widget_mdc":
		case "new_widget_pad":
		case "new_widget_plg":
			if(top.weEditorFrameController.getActiveDocumentReference()&&top.weEditorFrameController.getActiveDocumentReference().quickstart){
				top.weEditorFrameController.getActiveDocumentReference().createWidget(arguments[0].substr(arguments[0].length-3),1,1);
			}
			else {
				<?php print we_message_reporting::getShowMessageCall($l_alert['cockpit_not_activated'], WE_MESSAGE_ERROR); ?>
			}
			break;
 		case "initPlugin":
            	weplugin_wait=new jsWindow("<?php print WEBEDITION_DIR?>/eplugin/weplugin_wait.php?callback="+arguments[1],"weplugin_wait",-1,-1,300,100,true,false,true);
			break;
		case "edit_settings_newsletter":
			new jsWindow("<?php print WEBEDITION_DIR?>/we/include/we_modules/newsletter/edit_newsletter_frameset.php?pnt=newsletter_settings","newsletter_settings",-1,-1,600,750,true,false,true);
			break;
        case "edit_settings_customer":
			new jsWindow("<?php print WEBEDITION_DIR?>/we/include/we_modules/customer/edit_customer_frameset.php?pnt=settings","customer_settings",-1,-1,520,300,true,false,true);
			break;
		case "edit_settings_shop":
<?php
			if(defined("WE_SHOP_MODULE_PATH")) {
?>
			new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_pref.php","shoppref",-1,-1,470,600,true,false,true);
<?php
			}
?>
			break;
		case "edit_settings_messaging":
<?php
			if(defined("WE_MESSAGING_MODULE_PATH")) {
?>
			new jsWindow("<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_settings.php?mode=1", "messaging_settings",-1,-   1,280,200,true,false,true);
<?php
			}
?>
			break;
		case "edit_settings_spellchecker":
			we_cmd("edit_spellchecker");
			break;
		case "edit_settings_banner":
			we_cmd("default_banner");
			break;
		case "edit_settings_editor":
			if(top.plugin.editSettings){
				top.plugin.editSettings();
			} else {
				we_cmd("initPlugin","top.plugin.editSettings()");
			}
			break;
		case "edit_settings_glossary":
			we_cmd("glossary_settings");
			break;
		case "sysinfo":
			new jsWindow("<?php print WEBEDITION_DIR; ?>sysinfo.php","we_sysinfo",-1,-1,720,660,true,false,true);
			break;
		case "show_message_console":
			new jsWindow("<?php print WEBEDITION_DIR; ?>/we/include/jsMessageConsole/messageConsole.php","we_jsMessageConsole",-1,-1,600,500,true,false,true,false);
			break;
		case "remove_from_editor_plugin":
			if(arguments[1] && top.plugin && top.plugin.remove){
				top.plugin.remove(arguments[1]);
			}
			break;
		case "eplugin_exit_doc" :
			if(typeof(top.plugin.document.WePlugin)!="undefined") {
				if(top.plugin.isInEditor(arguments[1])) {
					return confirm("<?php echo $GLOBALS['l_alert']['eplugin_exit_doc']; ?>");
				}
			}
			return true;
			break;
		case "editor_plugin_doc_count":
			if(typeof(top.plugin.document.WePlugin)!="undefined") {
				return top.plugin.getDocCount();
			}
			return 0;
			break;
		case "setEconda":
			new jsWindow(cmsurl+"econdasettings","setEconda",-1,-1,500,400,true,false,true);
			break;
		<?php
		pWebEdition_JSwe_cmds();
		?>
		default:
			if (nextWindow = top.weEditorFrameController.getFreeWindow() ) {

				_nextContent = nextWindow.getDocumentReference();
				we_repl(_nextContent,url,arguments[0]);

				// activate tab
				top.weMultiTabs.addTab( nextWindow.getFrameId(), " ... ", " ... ");

				// set Window Active and show it
				top.weEditorFrameController.setActiveEditorFrame(nextWindow.FrameId);
				top.weEditorFrameController.toggleFrames();

			} else {
				<?php we_message_reporting::getShowMessageCall($l_multiEditor["no_editor_left"], WE_MESSAGE_INFO); ?>
			}
	}

}
// use this to submit a cmd with post (if you have much data, which is to long for the url);  // not testet very much!!!
function doPostCmd(cmds,target){
	var doc = self.postframe.document;
	if(doc.forms[0]){
		doc.body.removeChild(doc.forms[0]);
	}
	var formElement = doc.createElement("FORM");
	formElement.action = '<?php print WEBEDITION_DIR; ?>we_cmd.php';
	formElement.method = "post";
	formElement.target = target;

	var hiddens = new Array();
	for(var i=0; i< cmds.length; i++){
		var hid = doc.createElement("INPUT");
		hid.name = "we_cmd["+i+"]";
		hid.value = cmds[i];
		formElement.appendChild(hid);
	}
	doc.body.appendChild(formElement);
	formElement.submit();
}

function doSave(url,trans,cmd) {
	_EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction(trans);
	// _EditorFrame.setEditorIsHot(false);
	if( _EditorFrame.getEditorAutoRebuild() )
		url += "&we_cmd[8]=1";
	if(!we_sbmtFrm(self.load,url)) {
		url += "&we_transaction="+trans;
		we_repl(self.load,url,cmd);
	}
}

function doPublish(url,trans,cmd) {
	if(!we_sbmtFrm(self.load,url)) {
		url += "&we_transaction="+trans;
		we_repl(self.load,url,cmd);
	}
}

function openWindow(url,ref,x,y,w,h,scrollbars,menues) {
	new jsWindow(url,ref,x,y,w,h,true,scrollbars,menues);
}

function start() {
	self.Header = self.header.header_menu ? self.header.header_menu : self.header;
	self.Tree = self.rframe.bframe.bm_main;
	self.Vtabs = self.rframe.bframe.bm_vtabs;
	self.TreeInfo = self.rframe.bframe.infoFrame;
	<?php
		$_table_to_load = "";
		if (we_hasPerm("CAN_SEE_DOCUMENTS")) {
			$_table_to_load = FILE_TABLE;
		} else if (we_hasPerm("CAN_SEE_TEMPLATES")) {
			$_table_to_load = TEMPLATES_TABLE;
		} else if (defined("OBJECT_FILES_TABLE") && we_hasPerm("CAN_SEE_OBJECTFILES")) {
			$_table_to_load = OBJECT_FILES_TABLE;
		} else if (defined("OBJECT_TABLE") && we_hasPerm("CAN_SEE_OBJECTS")) {
			$_table_to_load = OBJECT_TABLE;
		}

		if ($_table_to_load) {
			print 'we_cmd("load","'.$_table_to_load.'");' . "\n";
		}
	?>
}

function openBrowser(url) {
	if (!url){
		url = "/";
	}
	try{
		browserwind = window.open("/webEdition/openBrowser.php?url="+escape(url),"browser","menubar=yes,resizable=yes,scrollbars=yes,location=yes,status=yes,toolbar=yes");
	}catch(e) {
		<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["browser_crashed"], WE_MESSAGE_ERROR); ?>
	}
}
<?php
if(!isset($SEEM_edit_include) || !$SEEM_edit_include){
	?>
function register() {

	if(we_demo) {
		new jsWindow("<?php print WEBEDITION_DIR; ?>registerScreen.php","register",-1,-1, 530,260,true,false,true);
	}
}

register();
	<?php
}

	pWebEdition_JSFunctions();
?>
var cockpitFrame;
</script>
<?php
	//	get the Treefunctions for docselector
	pWebEdition_Tree();
?>
</head>
<?php
//	get the frameset for the actual mode.
pWebEdition_Frameset();
?>
<body bgcolor="gray">
</body>
</html>