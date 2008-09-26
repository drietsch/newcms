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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browser_check.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");

protect();

htmlTop();

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
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>md5.js"></script>
<script language="JavaScript" type="text/javascript">
	var loaded=0;
	var hot=0;
	var hloaded=0;
	
	parent.document.title = "<?php print $title; ?>";
	
	<?php
		if($_SESSION["user"]["ID"] && isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])) {
			$DB_WE->query("SELECT ParentID FROM ".USER_TABLE." WHERE ID=".$_SESSION["user"]["ID"]);
			if($DB_WE->next_record())
				print "var cgroup=".$DB_WE->f("ParentID").";\n";
			else
				print "var cgroup=0;\n";
		}
		else
			print "var cgroup=0;\n";
		if(isset($_SESSION["user_session_data"]))
			unset($_SESSION["user_session_data"]);
	?>

	function doUnload() {
		if (!!jsWindow_count) {
			for (i = 0; i < jsWindow_count; i++) {
				eval("jsWindow" + i + "Object.close()");
			}
		}
	}

	function we_cmd() {
		var args = "";
		var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?";

		for(var i = 0; i < arguments.length; i++) {
			url += "we_cmd["+i+"]="+escape(arguments[i]);
			if(i < (arguments.length - 1)) {
				url += "&";
			}
		}

		if(hot == "1" && arguments[0] != "save_user") {
			if(confirm("<?php print $l_users["save_changed_user"]?>")) {
				arguments[0] = "save_user";
			} else {
				top.content.usetHot();
			}
		}
		switch (arguments[0]) {
	        case "exit_users":
				if(hot != "1") {
					eval('top.opener.top.we_cmd(\'exit_modules\')');
				}
		        break;
			case "new_user":
				top.content.user_resize.user_right.user_editor.user_properties.focus();
				if(hot==1 && top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd) {
					if(confirm("<?php print $l_users["save_changed_user"]?>")) {
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.sd.value=1;
					} else {
						top.content.usetHot();
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="new_user";
					}
					if(arguments[1])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.uid.value=arguments[1];
					if(arguments[2])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctype.value=arguments[2];
					if(arguments[3])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctable.value=arguments[3];
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				} else {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php?ucmd=new_user&cgroup='+cgroup;
				}
				break;
			case "check_user_display":
				top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php?ucmd=check_user_display&uid='+arguments[1];
				break;
			case "display_user":
				top.content.user_resize.user_right.user_editor.user_properties.focus();
				if(hot==1 && top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd) {
					if(confirm("<?php print $l_users["save_changed_user"]?>")) {
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.sd.value=1;
					}
					else {
						top.content.usetHot();
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="display_user";
					}
					if(arguments[1])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.uid.value=arguments[1];
					if(arguments[2])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctype.value=arguments[2];
					if(arguments[3])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctable.value=arguments[3];
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				}
				else {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH ?>edit_users_cmd.php?ucmd=display_user&uid='+arguments[1];
				}
				break;
			case "display_alias":
				top.content.user_resize.user_right.user_editor.user_properties.focus();
				top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="display_user";
				if(hot==1 && top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd) {
					if(confirm("<?php print $l_users["save_changed_user"]?>")) {
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.sd.value=1;
					}
					else {
						top.content.usetHot();
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="display_user";
					}
					if(arguments[1])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.uid.value=arguments[1];
					if(arguments[2])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctype.value=arguments[2];
					if(arguments[3])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctable.value=arguments[3];
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				}
				else {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH ?>edit_users_cmd.php?ucmd=display_user&uid='+arguments[1];
				}
				break;
			case "new_group":
				if(hot==1 && top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd) {
					if(confirm("<?php print $l_users["save_changed_user"]?>")) {
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.sd.value=1;
					} else {
						top.content.usetHot();
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="new_group";
					}
					if(arguments[1])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.uid.value=arguments[1];
					if(arguments[2])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctype.value=arguments[2];
					if(arguments[3])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctable.value=arguments[3];
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				} else {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php?ucmd=new_group&cgroup='+cgroup;
				}
				break;
			case "new_alias":
				if(hot==1 && top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd) {
					if(confirm("<?php print $l_users["save_changed_user"]?>")) {
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.sd.value=1;
					} else {
						top.content.usetHot();
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="new_alias";
					}
					if(arguments[1])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.uid.value=arguments[1];
					if(arguments[2])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctype.value=arguments[2];
					if(arguments[3])
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ctable.value=arguments[3];
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				} else {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php?ucmd=new_alias&cgroup='+cgroup;
				}
				break;
			case "save_user":
				if(top.content.user_resize.user_right.user_editor.user_properties.document.we_form) {
					top.content.user_resize.user_right.user_editor.user_properties.document.we_form.ucmd.value="save_user";
					top.content.usetHot();
					top.content.user_resize.user_right.user_editor.user_properties.we_submitForm("user_cmd","<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php");
				}
				break;
			case "delete_user":
				top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php?ucmd=delete_user';
				break;
			case "search":
				new jsWindow('<?php print WE_USERS_MODULE_PATH; ?>edit_users_sresults.php?kwd='+arguments[1],"customer_settings",-1,-1,580,400,true,false,true);
				break;
			case "new_organization":
				var orgname = prompt("<?php print $l_users["give_org_name"]; ?>","");
				if(orgname!= null) {
					top.content.user_cmd.location='<?php print WE_USERS_MODULE_PATH ?>edit_users_cmd.php?ucmd=new_organization&orn='+orgname;
				}
				break;
			default:
				for(var i = 0; i < arguments.length; i++) {
					args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
				}
				eval('opener.top.content.we_cmd('+args+')');
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
	var table="<?php print USER_TABLE; ?>";

	function drawEintraege() {
		fr = top.content.user_resize.user_left.user_tree.window.document;
		fr.open();
		fr.writeln("<HTML><HEAD>");
		fr.writeln("<SCRIPT LANGUAGE=\"JavaScript\">");
		fr.writeln("clickCount=0;");
		fr.writeln("wasdblclick=0;");
		fr.writeln("tout=null");
		fr.writeln("function doClick(id,ct,table){");
		fr.writeln("top.content.we_cmd('display_user',id,ct,table);");
		fr.writeln("}");
		fr.writeln("top.content.loaded=1;");
		fr.writeln("</"+"SCRIPT>");
		fr.writeln('<?php print STYLESHEET_SCRIPT; ?>');
		fr.write("</HEAD>\n");
		fr.write("<BODY BGCOLOR=\"#F3F7FF\" LINK=\"#000000\" ALINK=\"#000000\" VLINK=\"#000000\" leftmargin=5 topmargin=5 marginheight=5 marginwidth=5>\n");
		fr.write("<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td class=\"tree\">\n<NOBR>\n");
		zeichne(top.content.startloc,"");
		fr.write("</NOBR>\n</td></tr></table>\n");
		fr.write("</BODY>\n</HTML>");
		fr.close();
	}

	function zeichne(startEntry,zweigEintrag) {
		var nf = search(startEntry);
		var ai = 1;
		while (ai <= nf.laenge) {
			fr.write(zweigEintrag);
			if (nf[ai].typ == 'user') {
				if(ai == nf.laenge)
					fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzungend.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
				else
					fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzung.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
				if(nf[ai].name != -1) {
					fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
				}
				fr.write("<IMG SRC=<?php print ICON_DIR;?>"+nf[ai].icon+" WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["edit_statustext"]; ?>\">");
				fr.write("</a>");
				fr.write("&nbsp;<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\"><font color=\""+((nf[ai].contentType=="alias") ? "#006DB8" : "black") +"\">"+(parseInt(nf[ai].published) ? "<b>" : "") + "<label title='"+nf[ai].name+"'>" + nf[ai].text + "</label>" +(parseInt(nf[ai].published) ? "</b>" : "")+ "</font></A>&nbsp;&nbsp;<BR>\n");
			}
			else {
				var newAst = zweigEintrag;
				var zusatz = (ai == nf.laenge) ? "end" : "";

				if (nf[ai].offen == 0) {
					fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',1)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>auf"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["open_statustext"] ?>\"></A>");
					var zusatz2 = "";
				}
				else {
					fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',0)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>zu"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["close_statustext"] ?>\"></A>");
					var zusatz2 = "open";
				}
				fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
				fr.write("<IMG SRC=<?php print ICON_DIR;?>usergroup"+zusatz2+".gif WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["edit_statustext"]; ?>\">");
				fr.write("</a>");
				fr.write("<A name='_"+nf[ai].name+"' HREF=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\">");
				fr.write("&nbsp;<b><label title='"+nf[ai].name+"'>" + nf[ai].text + "</label></b>");
				fr.write("</a>");
				fr.write("&nbsp;&nbsp;<BR>\n");
				if (nf[ai].offen) {
					if(ai == nf.laenge)
						newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>leer.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
					else
						newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>strich2.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
					zeichne(nf[ai].name,newAst);
				}
			}
			ai++;
		}
	}

	function makeNewEntry(icon,id,pid,txt,offen,ct,tab,pub) {
		if(table == tab) {
			<?php if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])):?>
				if(ct=="folder")
					menuDaten.addSort(new dirEntry(icon,id,pid,txt,offen,ct,tab));
				else
					menuDaten.addSort(new urlEntry(icon,id,pid,txt,ct,tab,pub));
			<?php else:?>
				menuDaten.addSort(new urlEntry(icon,id,0,txt,ct,tab,pub));
			<?php endif?>
			drawEintraege();
		}
	}

	function updateEntry(id,pid,text,pub) {
		var ai = 1;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ=='folder') || (menuDaten[ai].typ=='user'))
				if (menuDaten[ai].name==id) {
					menuDaten[ai].vorfahr=<?php if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])):?>pid<?php else:?>0<?php endif?>;
					menuDaten[ai].text=text;
					menuDaten[ai].published=pub;
				}
			ai++;
		}
		drawEintraege();
	}

	function deleteEntry(id) {
		var ai = 1;
		var ind=0;
		while (ai <= menuDaten.laenge) {
			if ((menuDaten[ai].typ=='folder') || (menuDaten[ai].typ=='user'))
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
			if ((menuDaten[ai].typ == 'root') || (menuDaten[ai].typ == 'folder'))
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
			if ((menuDaten[ai].typ == 'folder') || (menuDaten[ai].typ == 'user'))
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

	function containerClear() {
		this.laenge =0;
	}

	function addSort(object) {
		this.laenge++;
		for(var i=this.laenge; i>0; i--) {
			if(i > 1 && this[i-1].text.toLowerCase() > object.text.toLowerCase() ) {
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

	function dirEntry(icon,name,vorfahr,text,offen,contentType,table) {
		this.icon=icon;
		this.name = name;
		this.vorfahr = vorfahr;
		this.text = text;
		this.typ = 'folder';
		this.offen = (offen ? 1 : 0);
		this.contentType = contentType;
		this.table = table;
		this.loaded = (offen ? 1 : 0);
		this.checked = false;
		return this;
	}

	function urlEntry(icon,name,vorfahr,text,contentType,table,published) {
		this.icon=icon;
		this.name = name;
		this.vorfahr = vorfahr;
		this.text = text;
		this.typ = 'user';
		this.checked = false;
		this.contentType = contentType;
		this.table = table;
		this.published = published;
		return this;
	}

	function loadData() {
		menuDaten.clear();
		<?php
			function readChilds($pid) {
				global $entries;

				$db_temp=new DB_WE();
				$db_temp->query("SELECT ID,username,ParentID,Type,Permissions FROM ".USER_TABLE." WHERE Type=1 AND ParentID='".$pid."' ORDER BY username ASC");
				while($db_temp->next_record()) {
					$entries[$db_temp->f("ID")]["username"]=$db_temp->f("username");
					$entries[$db_temp->f("ID")]["ParentID"]=$db_temp->f("ParentID");
					$entries[$db_temp->f("ID")]["Type"]=$db_temp->f("Type");
					$entries[$db_temp->f("ID")]["Permissions"]=substr($db_temp->f("Permissions"),0,1);
					if($db_temp->f("Type")=="1") {
						readChilds($db_temp->f("ID"));
					}
				}
			}

			if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])) {
				$entries=array();
				if($_SESSION["perms"]["NEW_USER"] || $_SESSION["perms"]["NEW_GROUP"] || $_SESSION["perms"]["SAVE_USER"] || $_SESSION["perms"]["SAVE_GROUP"] || $_SESSION["perms"]["DELETE_USER"] || $_SESSION["perms"]["DELETE_GROUP"] || $_SESSION["perms"]["ADMINISTRATOR"]) {
					$foo=getHash("SELECT Path,ParentID FROM ".USER_TABLE." WHERE ID='".$_SESSION["user"]["ID"]."'",$DB_WE);
					$parent_path=dirname($foo["Path"]);
					$parent_path = str_replace("\\","/",$parent_path);
					$startloc=$foo["ParentID"];
					if($_SESSION["perms"]["ADMINISTRATOR"]) {
						$parent_path="/";$startloc=0;
					}

					print "startloc=".$startloc.";\n";

					$DB_WE->query("SELECT * FROM ".USER_TABLE." WHERE Path LIKE '$parent_path%' ORDER BY Text ASC");

					while($DB_WE->next_record()) {
						if($DB_WE->f("Type")==1) {
							print "  menuDaten.add(new dirEntry('folder','".$DB_WE->f("ID")."','".$DB_WE->f("ParentID")."','".addslashes($DB_WE->f("Text"))."',false,'group','".USER_TABLE."',1));\n";
						}
						else {
							$p=unserialize($DB_WE->f("Permissions"));
							print "  menuDaten.add(new urlEntry('".($DB_WE->f("Type")==2 ? 'user_alias.gif' : 'user.gif')."','".$DB_WE->f("ID")."','".$DB_WE->f("ParentID")."','".addslashes($DB_WE->f("Text"))."','".($DB_WE->f("Type")==2 ? 'alias' : 'user')."','".USER_TABLE."','".$p["ADMINISTRATOR"]."'));\n";
						}
					}
				}
			}
			else {
				$DB_WE->query("SELECT * FROM ".USER_TABLE." ORDER BY username ASC");
				while($DB_WE->next_record()) {
					$p=unserialize($DB_WE->f("Permissions"));
					print "  menuDaten.add(new urlEntry('user.gif','".$DB_WE->f("ID")."',0,'".$DB_WE->f("username")."','user','".USER_TABLE."','".$p["ADMINISTRATOR"]."'));\n";
				}
			}
		?>
	}

	function start() {
		loadData();
		drawEintraege();
	}

	var startloc=0;

	self.focus();

</script>
</head>

<frameset rows="32,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="NO" onLoad="start();">
	<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_header.php" name="user_header" scrolling=no noresize>
	<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_resize.php" name="user_resize" scrolling=no>
	<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_cmd.php" name="user_cmd" scrolling=no noresize>
</frameset>

<body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
</body>

</html>