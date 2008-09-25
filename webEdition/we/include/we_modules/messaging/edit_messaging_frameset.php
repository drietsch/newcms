<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");
protect();
htmlTop('Messaging System');
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR?>images.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR?>windows.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR?>we_showMessage.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR?>messaging_std.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR?>messaging_hl.js"></script>
<?php
$cmd_params = '';

$messaging = new we_messaging($_SESSION["we_data"][$we_transaction]);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);

if (!$messaging->check_folders()) {
	include_once(WE_MESSAGING_MODULE_DIR."messaging_interfaces.inc.php");
	if (!msg_create_folders($_SESSION["user"]["ID"])) {
?>
		<script language="JavaScript" type="text/javascript"><!--
			<?php print we_message_reporting::getShowMessageCall($l_messaging['cant_create_folders'], WE_MESSAGE_ERROR); ?>
		//-->
		</script>
<?php
	}
}

$messaging->init($_SESSION["we_data"][$we_transaction]);

$messaging->add_msgobj('we_message', 0);
$messaging->add_msgobj('we_todo', 0);
$messaging->add_msgobj('we_msg_email', 0);

$messaging->saveInSession($_SESSION["we_data"][$we_transaction]);

print STYLESHEET;

$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : '';
$title = '';
foreach($GLOBALS["_we_available_modules"] as $modData){
	if($modData["name"] == $mod){
		$title	= "webEdition " . $GLOBALS["l_global"]["modules"] . ' - ' .$modData["text"];
		break;
	}
}

?>

<script language="JavaScript" type="text/javascript">
<!--
	var loaded = 0;
	var hot = 0;
	var multi_select = 0;
	var startloc=0;
	loaded_thr = 2;
	load_state = 0;
	loaded = false;
	deleteMode = false;
	entries_selected = new Array();
	del_parents = new Array();
	open_folder = -1;
	viewclass ="message";
	mode = "show_folder_content";
	
	parent.document.title = "<?php echo $title; ?>";

	we_transaction = "<?php echo $we_transaction?>";

	check0_img = new Image();
	check1_img = new Image();
	check0_img.src = "<?php echo TREE_IMAGE_DIR?>check0.gif";
	check1_img.src = "<?php echo TREE_IMAGE_DIR?>check1.gif";

	// message folders
	f1_img = new Image();
	f3_img = new Image();
	f5_img = new Image();

	f1_o_img = new Image();
	f3_o_img = new Image();
	f5_o_img = new Image();

	f1_img.src = "<?php echo ICON_DIR?>msg_folder.gif";
	f3_img.src = "<?php echo ICON_DIR?>msg_in_folder.gif";
	f5_img.src = "<?php echo ICON_DIR?>msg_sent_folder.gif";

	f1_o_img.src = "<?php echo ICON_DIR?>msg_folder_open.gif";
	f3_o_img.src = "<?php echo ICON_DIR?>msg_in_folder_open.gif";
	f5_o_img.src = "<?php echo ICON_DIR?>msg_sent_folder_open.gif";

	// todo folders
	tf1_img = new Image();
	tf3_img = new Image();
	tf13_img = new Image();
	tf11_img = new Image();

	tf1_o_img = new Image();
	tf3_o_img = new Image();
	tf13_o_img = new Image();
	tf11_o_img = new Image();

	tf1_img.src = "<?php echo ICON_DIR?>todo_folder.gif";
	tf3_img.src = "<?php echo ICON_DIR?>todo_in_folder.gif";
	tf13_img.src = "<?php echo ICON_DIR?>todo_done_folder.gif";
	tf11_img.src = "<?php echo ICON_DIR?>todo_reject_folder.gif";

	tf1_o_img.src = "<?php echo ICON_DIR?>todo_folder_open.gif";
	tf3_o_img.src = "<?php echo ICON_DIR?>todo_in_folder_open.gif";
	tf13_o_img.src = "<?php echo ICON_DIR?>todo_done_folder_open.gif";
	tf11_o_img.src = "<?php echo ICON_DIR?>todo_reject_folder_open.gif";

	function check(img) {
		var i;
		var tarr = img.split('_');
		var id = tarr[1];
		for (i = 1; i <= menuDaten.laenge; i++) {
			if (menuDaten[i].name == id) {
				if (menuDaten[i].checked) {
					if (messaging_main.messaging_tree.document.images) {
						if (messaging_main.messaging_tree.document.images[img]) {
							messaging_main.messaging_tree.document.images[img].src = check0_img.src;
						}
					}
					menuDaten[i].checked = false;
					unSelectMessage(img, 'elem', '', 1);
					break;
				}
				else {
					if (messaging_main.messaging_tree.document.images) {
						if (messaging_main.messaging_tree.document.images[img]) {
							messaging_main.messaging_tree.document.images[img].src = check1_img.src;
						}
					}
					menuDaten[i].checked = true;
					doSelectMessage(img, 'elem', '', 1);
					break;
				}
			}
		}
		if (!messaging_main.messaging_tree.document.images) {
			drawEintraege();
		}
	}

	function cb_incstate() {
		load_state++;
		if (!loaded && load_state >= loaded_thr) {
			loaded = true;
			loadData();
				<?php
					if (isset($_REQUEST['msg_param'])) {
						if ($_REQUEST['msg_param'] == 'todo') {
							$f = $messaging->get_inbox_folder('we_todo');
						}
						else if ($_REQUEST['msg_param'] == 'message') {
							$f = $messaging->get_inbox_folder('we_message');
						}
						echo 'r_tree_open(' . $f['ID'] . ");\n";
					}
				?>
				<?php
					if (isset($f)) {
						echo 'we_cmd(\'show_folder_content\', ' . $f['ID'] . ");\n";
					}
					else {
						echo "drawEintraege();\n";
					}
				?>
		}
	}

	function r_tree_open(id) {
		ind = indexOfEntry(id);
		if (ind != -1) {
			menuDaten[ind].offen = 1;
			if (menuDaten[ind].vorfahr >= 1) {
				r_tree_open(menuDaten[ind].vorfahr);
			}
		}
	}

	function update_msg_quick_view() {
		top.opener.update_msg_quick_view();
	}

	function update_messaging() {
		if (!deleteMode && (mode == "show_folder_content") && (load_state >= loaded_thr)) {
			if (top.content.messaging_main.messaging_right.msg_work.entries_selected && top.content.messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
				ent_str = "&entrsel=" + top.content.messaging_main.messaging_right.msg_work.entries_selected.join(',');
			}
			else {
				ent_str = "";
			}
			messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $we_transaction?>&mcmd=update_msgs" + ent_str;
		}
	}

	function update_icon(fid) {
		var s = 0;
		var ai = 1;
		if (fid == open_folder) {
			return 1;
		}
		while (ai <= menuDaten.laenge) {
			if (menuDaten[ai].name == fid) {
				menuDaten[ai].icon = menuDaten[ai].iconbasename + "_open.gif";
				if (++s == 2) {
					break;
				}
			}
			if (menuDaten[ai].name == open_folder) {
				menuDaten[ai].icon = menuDaten[ai].iconbasename + ".gif";
				if (++s == 2) {
					break;
				}
			}
			ai++;
		}
		open_folder = fid;
		drawEintraege();
	}

	function get_mentry_index(name) {
		var ai = 1;
		while (ai <= menuDaten.laenge) {
			if (menuDaten[ai].name == name)
				return ai;
			ai++;
		}
		return -1;
	}

	function set_frames(vc) {
		if (vc == "message") {
			top.content.messaging_iconbar.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_iconbar.php?we_transaction=<?php echo $we_transaction?>";
			top.content.messaging_main.messaging_right.msg_work.messaging_search.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_search_frame.php?we_transaction=<?php echo $we_transaction?>";
			top.content.messaging_main.messaging_right.msg_work.messaging_fv_headers.location="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_fv_headers.php?viewclass=message&we_transaction=<?php echo $we_transaction?>";
		}
		else if (vc == "todo") {
			top.content.messaging_iconbar.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>todo_iconbar.php?we_transaction=<?php echo $we_transaction?>";
			top.content.messaging_main.messaging_right.msg_work.messaging_search.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>todo_search_frame.php?we_transaction=<?php echo $we_transaction?>";
			top.content.messaging_main.messaging_right.msg_work.messaging_fv_headers.location="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_fv_headers.php?viewclass=todo&we_transaction=<?php echo $we_transaction?>";
		}
		viewclass= vc;
	}

	function doUnload() {
		if (!!jsWindow_count) {
			for (i = 0; i < jsWindow_count; i++) {
				eval("jsWindow" + i + "Object.close()");
			}
		}
	}
			
	function we_cmd() {
		var args = "";
		var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_transaction=<?php echo $we_transaction?>&";
		for(var i = 0; i < arguments.length; i++) {
			url += "we_cmd["+i+"]="+escape(arguments[i]);
			if(i < (arguments.length - 1)) {
				url += "&";
			}
		}
		
		if(hot == "1" && arguments[0] != "messaging_start_view") {
			if(confirm("<?php print $l_messaging["save_changed_folder"];?>")) {
				top.content.messaging_main.messaging_right.msg_work.document.edit_folder.submit();
			} else {
				top.content.usetHot();
			}
		}
		switch (arguments[0]) {
			case "messaging_exit":
				if(hot != "1") {
					eval('top.opener.top.we_cmd("exit_modules")');
				}
				break;
			case "show_folder_content":
				ind = get_mentry_index(arguments[1]);
				if (ind > -1) {
					update_icon(arguments[1]);
					if (top.content.viewclass != menuDaten[ind].viewclass) {
						set_frames(menuDaten[ind].viewclass);
					}
					top.content.viewclass = menuDaten[ind].viewclass;
				}
				messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $we_transaction?>&mcmd=show_folder_content&id=' + arguments[1];
				break;
			case "edit_folder":
				update_icon(arguments[1]);
				top.content.messaging_cmd.location = '<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=<?php echo $we_transaction?>&mcmd=edit_folder&mode=edit&fid=' + arguments[1];
				break;
			case "folder_new":
				break;
			case "messaging_new_message":
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=new_message&mode=new";
				break;
			case "messaging_new_todo":
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=new_todo";
				break;
			case "messaging_start_view":
				deleteMode = false;
				mode = "show_folder_content";
				entries_selected = new Array();
				drawEintraege();
				top.content.messaging_main.messaging_right.msg_work.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_work.php?we_transaction=" + we_transaction;
				top.content.usetHot();
				break;
			case "messaging_new_folder":
				mode = "folder_new";
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=edit_folder&mode=new";
				break;
			case "messaging_delete_mode_on":
				deleteMode = true;
				drawEintraege();
				top.content.messaging_main.messaging_right.msg_work.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_delete_folders.php?we_transaction=" + we_transaction;
				break;
			case "messaging_delete_folders":
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=delete_folders&folders=" + entries_selected.join(',');
				break;
			case "messaging_edit_folder":
				mode = "edit_folder";
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=edit_folder&mode=edit&fid=" + open_folder;
				break;
			case "messaging_settings":
				messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=edit_settings&mode=new";
				break;
			case "messaging_copy":
				if (messaging_main && messaging_main.messaging_right && messaging_main.messaging_right.msg_work && messaging_main.messaging_right.msg_work.entries_selected && messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
					messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=copy_msg&entrsel=" + messaging_main.messaging_right.msg_work.entries_selected.join(',');
				}
				break;
			case "messaging_cut":
				if (messaging_main && messaging_main.messaging_right && messaging_main.messaging_right.msg_work && messaging_main.messaging_right.msg_work.entries_selected && messaging_main.messaging_right.msg_work.entries_selected.length > 0) {
					messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=cut_msg&entrsel=" + messaging_main.messaging_right.msg_work.entries_selected.join(',');
				}
				break;
			case "messaging_paste":
				top.content.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php?we_transaction=" + we_transaction + "&mcmd=paste_msg";
				break;
			default:
				for(var i = 0; i < arguments.length; i++) {
					args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
				}
				eval('top.opener.top.we_cmd('+args+')');
		}
	}

	function setHot() {
		hot=1;
	}

	function usetHot() {
		hot=0;
	}

	var menuDaten = new container();
	var count = 0;
	var folder=0;
	var table="<?php print MESSAGES_TABLE; ?>";
	var mode = "show_folder_content";

	function drawEintraege() {
		fr = top.content.messaging_main.messaging_tree.window.document;
		fr.open();
		fr.writeln('<html><head>');
		fr.writeln('<script language="JavaScript" type="text/javascript">');

		fr.writeln("clickCount=0;");
		fr.writeln("wasdblclick=0;");
		fr.writeln("tout=null");
		fr.writeln("function doClick(id) {");
		fr.writeln("top.content.we_cmd(top.content.mode,id);");
		fr.writeln("}");

		fr.writeln('top.content.loaded=1;');
		fr.writeln('</' + 'script>');
		fr.writeln('<?php print STYLESHEET_SCRIPT; ?>');
		fr.writeln('</head>');
		fr.writeln('<body bgcolor="#F3F7FF" link="#000000" alink="#000000" vlink="#000000" leftmargin=5 topmargin=5 marginheight=5 marginwidth=5 >');
		fr.writeln('<table border=0 cellpadding=0 cellspacing=0 width="100%"><tr><td class="tree"><nobr>');

		zeichne(top.content.startloc, "");

		fr.writeln("</nobr></td></tr></table>");
		fr.writeln("</body></html>");
		fr.close();
	}

	function zeichne(startEntry, zweigEintrag) {
		var nf = search(startEntry);
		var ai = 1;
		while (ai <= nf.laenge) {
			fr.write(zweigEintrag);
			if (nf[ai].typ == "leaf_Folder") {
				if (ai == nf.laenge){
					fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzungend.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
				} else {
					fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzung.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
				}
				if (nf[ai].name != -1) {
					fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+");return true;\" BORDER=0>");
				}
				if (deleteMode) {
					if(nf[ai].name != -1) {
						trg = "javascript:top.content.check('img_" + nf[ai].name + "');"
						if(nf[ai].checked) {
							fr.write("<a href=\"" + trg + "\"><img src=\"<?php print TREE_IMAGE_DIR; ?>check1.gif\"WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["select_statustext"]; ?>\" name=\"img_"+nf[ai].name+"\"></a>");
						}
						else {
							fr.write("<a href=\"" + trg + "\"><img src=\"<?php print TREE_IMAGE_DIR; ?>check0.gif\"WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["select_statustext"]; ?>\" name=\"img_"+nf[ai].name+"\"></a>");
						}
					}
				} else {
					fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+");return true;\" BORDER=0>");
					fr.write("<IMG SRC=<?php print ICON_DIR; ?>"+nf[ai].icon+" WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree['edit_statustext']; ?>\">");
					fr.write("</a>");
					trg = "doClick("+nf[ai].name+");return true;"
				}
				fr.write("&nbsp;<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"" + trg + "\"><font color=\"black\">"+(parseInt(nf[ai].published) ? " <b>" : "")+ translate(nf[ai].text) +(parseInt(nf[ai].published) ? " </b>" : "")+ "</font></A>&nbsp;&nbsp;<BR>\n");
			} else {
				var newAst = zweigEintrag;
				var zusatz = (ai == nf.laenge) ? "end" : "";
				if (nf[ai].offen == 0) {
					fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',1)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>auf"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree['open_statustext'] ?>\"></A>");
					var zusatz2 = '';
				} else {
					fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',0)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>zu"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree['close_statustext'] ?>\"></A>");
					var zusatz2 = "open";
				}
				if(deleteMode) {
					if(nf[ai].name != -1) {
						trg = "javascript:top.content.check('img_" + nf[ai].name + "');";
						if(nf[ai].checked) {
							fr.write("<a href=\"" + trg + "\"><img src=\"<?php print TREE_IMAGE_DIR; ?>check1.gif\"WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["select_statustext"]; ?>\" name=\"img_"+nf[ai].name+"\"></a>");
						} else {
							fr.write("<a href=\"" + trg + "\"><img src=\"<?php print TREE_IMAGE_DIR; ?>check0.gif\"WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["select_statustext"]; ?>\" name=\"img_"+nf[ai].name+"\"></a>");
						}
					}
				} else {
					trg = "doClick("+nf[ai].name+");return true;"
				}

				fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"" + trg + "\" BORDER=0>");
				fr.write("<IMG SRC=<?php print ICON_DIR;?>" + nf[ai].icon + " WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["edit_statustext"]; ?>\">");
				fr.write("</a>");

				fr.write("<A name='_"+nf[ai].name+"' HREF=\"javascript://\" onClick=\"" + trg + "\">");
				fr.write("&nbsp;" + translate(nf[ai].text));
				fr.write("</a>");
				fr.write("&nbsp;&nbsp;<BR>\n");
				if (nf[ai].offen) {
					if(ai == nf.laenge) {
						newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>leer.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
					} else {
						newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>strich2.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
					}
					zeichne(nf[ai].name,newAst);
				}
			}
			ai++;
		}
	}

	function translate(inp){
		if(inp.substring(0,12).toLowerCase() == "messages - ("){
			return "<?php print $GLOBALS["l_messaging"]["Mitteilungen"]; ?> - ("+inp.substring(12,inp.length);
		}else if(inp.substring(0,8).toLowerCase() == "task - ("){
			return "<?php print $GLOBALS["l_messaging"]["ToDo"]; ?> - ("+inp.substring(8,inp.length);
		}else if(inp.substring(0,8).toLowerCase() == "todo - ("){
			return "<?php print $GLOBALS["l_messaging"]["ToDo"]; ?> - ("+inp.substring(8,inp.length);
		}else if(inp.substring(0,8).toLowerCase() == "done - ("){
			return "<?php print $GLOBALS["l_messaging"]["Erledigt"]; ?> - ("+inp.substring(8,inp.length);
		}else if(inp.substring(0,12).toLowerCase() == "rejected - ("){
			return "<?php print $GLOBALS["l_messaging"]["Zurueckgewiesen"]; ?> - ("+inp.substring(12,inp.length);
		}else if(inp.substring(0,8).toLowerCase() == "sent - ("){
			return "<?php print $GLOBALS["l_messaging"]["Gesendet"]; ?> - ("+inp.substring(8,inp.length);
		}else{
			return inp;
		}

	 }


	function updateEntry(id,pid,text,pub,redraw) {
		var ai = 1;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ=='parent_Folder') || (menuDaten[ai].typ=='leaf_Folder'))
				if (menuDaten[ai].name==id) {
					if (pid != -1) {
						menuDaten[ai].vorfahr=pid;
					}
					menuDaten[ai].text=text;
					if (pub != -1) {
						menuDaten[ai].published=pub;
					}
					break;
				}
				ai++;
			}
			if (redraw == 1) {
			drawEintraege();
		}
	}

	function deleteEntry(id) {
		var ai = 1;
		var ind=0;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ=='parent_Folder') || (menuDaten[ai].typ=='leaf_Folder'))
				if (menuDaten[ai].name==id) {
					ind=ai;
					break;
				}
			ai++;
		}
		if(ind!=0) {
			ai = ind;
			while (ai <= menuDaten.laenge-1) {
				menuDaten[ai]=menuDaten[ai+1];
				ai++;
			}
			menuDaten.laenge[menuDaten.laenge]=null;
			menuDaten.laenge--;
			drawEintraege();
		}
	}

	function openClose(name,status) {
		var eintragsIndex = indexOfEntry(name);
		menuDaten[eintragsIndex].offen = status;
		if(status) {
			if(!menuDaten[eintragsIndex].loaded) {
				drawEintraege();
			}
			else {
				drawEintraege();
			}
		}
		else {
			drawEintraege();
		}
	}

	function indexOfEntry(name) {
		var ai = 1;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ == 'root') || (menuDaten[ai].typ == 'parent_Folder'))
				if (menuDaten[ai].name == name)
					return ai;
			ai++;
		}
		return -1;
	}

	function search(eintrag) {
		var nf = new container();
		var ai = 1;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ == 'parent_Folder') || (menuDaten[ai].typ == 'leaf_Folder'))
				if (menuDaten[ai].vorfahr == eintrag)
					nf.add(menuDaten[ai]);
			ai++;
		}
		return nf;
	}

	function container() {
		this.laenge = 0;
		this.clear=containerClear;
		this.add = add;
		this.addSort = addSort;
		return this;
	}

	function add(object) {
		this.laenge++;
		this[this.laenge] = object;
	}

	function update_Node(id) {
		var i;
		var off = -1;
		for (i = 1; i < menuDaten.laenge; i++) {
			if (menuDaten[i].name == id) {
				off = i;
				break;
			}
		}
	}

	function get_index(id) {
		var i;
		for (i = 1; i <= menuDaten.laenge; i++) {
			if (menuDaten[i].name == id) {
				return i;
			}
		}
		return -1;
	}

	function folder_added(parent_id) {
		var ind = get_index(parent_id);
		if (ind > -1) {
			if (menuDaten[ind].typ == 'leaf_Folder') {
				menuDaten[ind].typ = 'parent_Folder';
				menuDaten[ind].offen = 0;
				menuDaten[ind].leaf_count = 1;
			}
			else {
				menuDaten[ind].leaf_count++;
			}
		}
	}

	function folders_removed() {
		var ind;
		var i;
		for (i = 0; i < del_parents.length; i++) {
			if ((ind = get_index(del_parents[i])) < 0) {
				continue;
			}
			menuDaten[ind].leaf_count--;
			if (menuDaten[ind].leaf_count <= 0) {
				menuDaten[ind].typ = 'leaf_Folder';
			}
		}
	}

	function delete_menu_entries(ids) {
		var i, done = 0;
		var t = menuDaten;
		var cont = new container();
		del_parents = new Array();
		for (i = 1; i <= t.laenge; i++) {
			if (array_search(t[i].name, ids) == -1) {
				cont.add(t[i]);
			}
			else {
				del_parents = del_parents.concat(new Array(String(t[i].vorfahr)));
			}
		}
		menuDaten = cont;
	}

	function containerClear() {
		this.laenge =0;
	}

	function addSort(object) {
		this.laenge++;
		for(var i=this.laenge; i > 0; i--) {
			if(i > 1 && this[i-1].text.toLowerCase() > object.text.toLowerCase()) {
				this[i] = this[i-1];
			}
			else {
				this[i] = object;
				break;
			}
		}
	}

	function rootEntry(name,text,rootstat) {
		this.name = name;
		this.text = text;
		this.loaded=true;
		this.typ = 'root';
		this.rootstat = rootstat;
		return this;
	}

	function dirEntry(icon,name,vorfahr,text,offen,contentType,table,leaf_count,iconbasename,viewclass) {
		this.icon=icon;
		this.iconbasename=iconbasename;
		this.name = name;
		this.vorfahr = vorfahr;
		this.text = text;
		this.typ = 'parent_Folder';
		this.offen = (offen ? 1 : 0);
		this.contentType = contentType;
		this.leaf_count = leaf_count;
		this.table = table;
		this.loaded = (offen ? 1 : 0);
		this.checked = false;
		this.viewclass = viewclass;
		return this;
	}

	function urlEntry(icon,name,vorfahr,text,contentType,table,iconbasename,viewclass) {
		this.icon=icon;
		this.iconbasename=iconbasename;
		this.name = name;
		this.vorfahr = vorfahr;
		this.text = text;
		this.typ = 'leaf_Folder';
		this.checked = false;
		this.contentType = contentType;
		this.table = table;
		this.viewclass = viewclass;
		return this;
	}

	function loadData() {
		menuDaten.clear();
		<?php
			$entries=array();
			print "startloc=0;\n";
			print "menuDaten.add(new self.rootEntry('0','root','root'));\n";
			foreach ($messaging->available_folders as $folder) {
				switch ($folder['obj_type']) {
					case MSG_FOLDER_INBOX:
						$iconbasename = $folder['ClassName'] == 'we_todo' ? 'todo_in_folder' : 'msg_in_folder';
						$folder['Name'] = $folder['ClassName'] == 'we_todo' ? $l_messaging['ToDo'] : $l_messaging['Mitteilungen'];
						break;
					case MSG_FOLDER_SENT:
						$iconbasename = 'msg_sent_folder';
						$folder['Name'] = $l_messaging['Gesendet'];
						break;
					case MSG_FOLDER_DONE:
						$iconbasename = 'todo_done_folder';
						$folder['Name'] = $l_messaging['Erledigt'];
						break;
					case MSG_FOLDER_REJECT:
						$iconbasename = 'todo_reject_folder';
						$folder['Name'] = $l_messaging['Zurueckgewiesen'];
						break;
					default:
						$iconbasename = $folder['ClassName'] == 'we_todo' ? 'todo_folder' : 'msg_folder';
						break;
				}
				if (($sf_cnt = $messaging->get_subfolder_count($folder['ID'], '')) >= 0) {
					print "  menuDaten.add(new dirEntry('$iconbasename.gif','" . $folder['ID']."','" . $folder['ParentID'] . "','" . $folder['Name'] . ' - (' . $messaging->get_message_count($folder['ID'], '') . ")',false,'parent_Folder','".MESSAGES_TABLE."', " . $sf_cnt . ", '$iconbasename', '" . $folder['view_class'] . "'));\n";
				}
				else {
					print "  menuDaten.add(new urlEntry('$iconbasename.gif','" . $folder['ID'] . "','" . $folder['ParentID'] . "','" . $folder['Name'] . ' - (' . $messaging->get_message_count($folder['ID'], '') . ")','leaf_Folder','".MESSAGES_TABLE."', '$iconbasename', '" . $folder['view_class'] . "'));\n";
				}
			}
		?>
	}

	function msg_start() {
		loadData();
		drawEintraege();
	}

//-->
</script>
</head>

<frameset rows="32,40,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_header.php" name="messaging_header" scrolling="no" noresize>
	<frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_iconbar.php?we_transaction=<?php echo $we_transaction?>" name="messaging_iconbar" scrolling="no" noresize>
	<frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_main.php?we_transaction=<?php echo $we_transaction?>" name="messaging_main" scrolling="no" noresize>
	<frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_cmd.php" name="messaging_cmd" scrolling="yes" noresize>
</frameset>

<body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0"></body>

</html>