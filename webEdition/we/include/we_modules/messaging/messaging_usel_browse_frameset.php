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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browserDetect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");


protect();

htmlTop();

print STYLESHEET;

$browser = new we_browserDetect();

?>
 <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
 <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
 <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>messaging_hl.js"></script>
 <script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR?>messaging_std.js"></script>
 <script language="JavaScript" type="text/javascript">

 var loaded=0;
 var hot=0;
 var i;
 entries_selected = new Array();
 last_entry_selected = -1;
 multi_select = 1;

 for (i = 0; i < opener.current_sel.length; i++) {
    if (opener.current_sel[i][0] != 'we_message') {
	continue;
    }
    entries_selected = entries_selected.concat(new Array(opener.current_sel[i][1] + '&' + opener.current_sel[i][2]));
 }

 function setHot(){
    hot=1;
 }

 function usetHot(){
    hot=0;
 }

 var menuDaten = new container();var count = 0;var folder=0;
 var table="<?php print USER_TABLE; ?>";
 NN4 = <?php echo $browser->getBrowser() == 'nn' && $browser->getBrowserVersion() <= 4 ? 'true' : 'false'?>;

 check0_img = new Image();
 check1_img = new Image();
 check0_img.src = "<?php echo TREE_IMAGE_DIR?>check0.gif";
 check1_img.src = "<?php echo TREE_IMAGE_DIR?>check1.gif";

 function do_selupdate() {
    opener.delta_sel = entries_selected;
    opener.delta_sel_add('we_message', '&');
    window.close();
 }

 function drawEintraege() {
    fr = messaging_usel_main.window.document;
    fr.open();
    fr.writeln("<HTML><HEAD>");
    fr.writeln("<script language=\"JavaScript\" src=\"<?php echo JS_DIR?>messaging_std.js\"></" + "script>");

    fr.writeln("<SCRIPT LANGUAGE=\"JavaScript\">");
    fr.writeln("clickCount=0;");
    fr.writeln("wasdblclick=0;");
    fr.writeln("tout=null");
    fr.writeln("top.loaded=1;");
    fr.writeln("</"+"SCRIPT>");
    fr.writeln('<?php print STYLESHEET_SCRIPT;?>');
    fr.write("</HEAD>\n");
    fr.write("<BODY class=\"weEditorBody\" LINK=\"#000000\" ALINK=\"#000000\" VLINK=\"#000000\" leftmargin=\"10\" topmargin=\"0\" marginheight=\"0\" marginwidth=\"10\" onunload=\"doUnload()\">");
    fr.write("<table border=\"0\" cellpadding=0 cellspacing=0 width=100%><tr><td class=\"tree\">\n<NOBR>\n");
    zeichne(top.startloc,"");
    fr.write("</NOBR>\n</td></tr></table>\n");
	fr.writeln("  <script language=\"JavaScript\">");
	fr.writeln("    var k;");

	fr.writeln("for (k = 0; k < parent.entries_selected.length; k++) {");
	fr.writeln("  parent.highlight_Elem(parent.entries_selected[k], parent.sel_color, parent.messaging_usel_main);");
	fr.writeln("}");
	fr.writeln("</" + "script>");
    fr.write("</BODY>\n</HTML>");

    fr.close();
   }

    function check(entry){
	var i;
	var tarr = entry.split('&');
	var id = tarr[0];
	var img = "img_" + id;

       for(i=1;i<=menuDaten.laenge;i++){
	  if(menuDaten[i].name == id){
	     if(menuDaten[i].checked){
		if(document.images){
		   if(messaging_usel_main.document.images[img])
		      messaging_usel_main.document.images[img].src=check0_img.src;
		}
		menuDaten[i].checked=false;
		unSelectMessage(entry, 'elem', messaging_usel_main, NN4);
		break;
	     }else{
		if(document.images){
		   if(messaging_usel_main.document.images[img])
		      messaging_usel_main.document.images[img].src=check1_img.src;
		}
		menuDaten[i].checked=true;
		doSelectMessage(entry, 'elem', messaging_usel_main, NN4);
		break;
	     }
	  }
       }
       if(!document.images){
	  drawEintraege();
       }
    }

 function zeichne(startEntry,zweigEintrag){
	var nf = search(startEntry);
	var ai = 1;
        while (ai <= nf.laenge) {
		fr.write(zweigEintrag);
		if (nf[ai].typ == 'user') {
			if(ai == nf.laenge) fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzungend.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
			else fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzung.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
			if(nf[ai].name != -1){
				fr.write("<a name='_"+nf[ai].name+"' href=\"javascript:doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=\"0\">");
			}
			fr.write("<IMG SRC=<?php print ICON_DIR; ?>"+nf[ai].icon+" WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php print $l_tree["edit_statustext"]; ?>\">");
			fr.write("</a>");

			if (nf[ai].checked) {
			    checkpic = "check1.gif";
			} else {
			    checkpic = "check0.gif";
			}

			fr.write("<a href=\"javascript:top.check('" + nf[ai].name + '&' + nf[ai].text + "')\"><img src=\"<?php echo TREE_IMAGE_DIR?>" + checkpic + "\" \"width=\"16\" height=\"18\" align=\"absmiddle\" border=\"0\" alt=\"\" name=\"img_" + nf[ai].name + "\"></a>");
			fr.write("&nbsp;<a name='_"+nf[ai].name+"' href=\"javascript:top.check('" + nf[ai].name + '&' + nf[ai].text + "')\"><span id=\"" + nf[ai].name + '&' + nf[ai].text + "\" class=\"u_tree_entry\">"+(parseInt(nf[ai].published) ? " <b>" : "")+ nf[ai].text +(parseInt(nf[ai].published) ? " </b>" : "")+ "</span></A>&nbsp;&nbsp;<BR>\n");
		}else{
			var newAst = zweigEintrag;

			var zusatz = (ai == nf.laenge) ? "end" : "";

			if (nf[ai].offen == 0){
				fr.write("&nbsp;&nbsp;<A href=\"javascript:top.openClose('" + nf[ai].name + "',1)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>auf"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["open_statustext"] ?>\"></A>");
				var zusatz2 = "";
			}else{
				fr.write("&nbsp;&nbsp;<A href=\"javascript:top.openClose('" + nf[ai].name + "',0)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>zu"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["close_statustext"] ?>\"></A>");
	        	var zusatz2 = "open";
	        }
			fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
			fr.write("<IMG SRC=<?php print ICON_DIR;?>usergroup"+zusatz2+".gif WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php print $l_tree["edit_statustext"]; ?>\">");
			fr.write("</a>");
			fr.write("<A name='_"+nf[ai].name+"' HREF=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\">");
			fr.write("&nbsp;<b>" + nf[ai].text + "</b>");
			fr.write("</a>");
			fr.write("&nbsp;&nbsp;<BR>\n");
			if (nf[ai].offen){
				if(ai == nf.laenge) newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>leer.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
				else newAst = newAst + "<IMG SRC=<?php print TREE_IMAGE_DIR; ?>strich2.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>";
				zeichne(nf[ai].name,newAst);
			}
		}
		ai++;
	}
 }


 function makeNewEntry(icon,id,pid,txt,offen,ct,tab,pub){

    if(table == tab){
     if(menuDaten[indexOfEntry(pid)]){
        if(ct=="folder")
          menuDaten.addSort(new dirEntry(icon,id,pid,txt,offen,ct,tab));
        else
          menuDaten.addSort(new urlEntry(icon,id,pid,txt,ct,tab,pub));
       drawEintraege();
     }
    }
 }


 function updateEntry(id,pid,text,pub){
        var ai = 1;
        while (ai <= menuDaten.laenge) {
            if ((menuDaten[ai].typ=='folder') || (menuDaten[ai].typ=='user'))
             if (menuDaten[ai].name==id) {
                 menuDaten[ai].vorfahr=pid;
                 menuDaten[ai].text=text;
                 menuDaten[ai].published=pub;
             }
             ai++;
        }
        drawEintraege();
 }

 function deleteEntry(id){
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
        if(ind!=0){
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

 function openClose(name,status){
	var eintragsIndex = indexOfEntry(name);
	menuDaten[eintragsIndex].offen = status;
	if(status){
		if(!menuDaten[eintragsIndex].loaded){
            drawEintraege();
		}else{
			drawEintraege();
		}
	}else{
		drawEintraege();
	}
 }

 function indexOfEntry(name){var ai = 1;while (ai <= menuDaten.laenge) {if ((menuDaten[ai].typ == 'root') || (menuDaten[ai].typ == 'folder'))if (menuDaten[ai].name == name) return ai;ai++;}return -1;}

 function search(eintrag){var nf = new container();var ai = 1;while (ai <= menuDaten.laenge) {if ((menuDaten[ai].typ == 'folder') || (menuDaten[ai].typ == 'user'))if (menuDaten[ai].vorfahr == eintrag) nf.add(menuDaten[ai]);ai++;}return nf;}

 function container(){this.laenge = 0;this.clear=containerClear;this.add = add;this.addSort = addSort;return this;}

 function add(object){this.laenge++;this[this.laenge] = object;}

 function containerClear(){this.laenge =0;}

 function addSort(object){this.laenge++;for(var i=this.laenge; i>0; i--){if(i > 1 && this[i-1].text.toLowerCase() > object.text.toLowerCase() ){this[i] = this[i-1];}else{this[i] = object;break;}}}

 function rootEntry(name,text,rootstat){this.name = name;this.text = text;this.loaded=true;this.typ = 'root';this.rootstat = rootstat;return this;}

 function dirEntry(icon,name,vorfahr,text,offen,contentType,table){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'folder';this.offen = (offen ? 1 : 0);this.contentType = contentType;this.table = table;this.loaded = (offen ? 1 : 0);this.checked = false;return this;}

 function urlEntry(icon,name,vorfahr,text,contentType,table,published,checked){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'user';this.contentType = contentType;this.table = table;this.published = published;this.checked=checked;return this;}

 function loadData(){

    menuDaten.clear();

    <?php

    function readChilds($pid){
          global $entries;

          $db_temp=new DB_WE();
          $db_temp->query("SELECT ID,username,ParentID,Type,Permissions FROM ".USER_TABLE." WHERE  ParentID='".abs($pid)."' ORDER BY username ASC");
          while($db_temp->next_record()){
              $entries[$db_temp->f("ID")]["username"]=$db_temp->f("username");
              $entries[$db_temp->f("ID")]["ParentID"]=$db_temp->f("ParentID");
              $entries[$db_temp->f("ID")]["Type"]=$db_temp->f("Type");
              $entries[$db_temp->f("ID")]["Permissions"]=substr($db_temp->f("Permissions"),0,1);
              if($db_temp->f("Type")=="1"){
                 readChilds($db_temp->f("ID"));
              }
          }

      }

      $entries=array();
        $DB_WE->query("SELECT * FROM ".USER_TABLE." ORDER BY username ASC");
        print "startloc=0 ;\n";
        print "menuDaten.add(new self.rootEntry('0','root','root'));\n";
        while($DB_WE->next_record()){
         if($DB_WE->f("Type")==1){
                print "  menuDaten.add(new dirEntry('folder','".$DB_WE->f("ID")."','".$DB_WE->f("ParentID")."','".$DB_WE->f("username")."',false,'user','".USER_TABLE."','".$p[0]."'));\n";
         }
         else{
               $p=$DB_WE->f("Permissions");

		print "checked = (user_array_search(\"" . $DB_WE->f('ID') . "\", opener.current_sel, \"1\", 'we_message') != -1) ? 1 : 0;";
                print "  menuDaten.add(new urlEntry('user.gif','".$DB_WE->f("ID")."','".$DB_WE->f("ParentID")."','".$DB_WE->f("username")."','user','".USER_TABLE."','".$p[0]."', checked));\n";
         }
        }
    ?>
 }

 function init_check() {
    var i;
    for (i = 0; i < opener.current_sel.length; i++) {
	if (opener.current_sel[i][0] != 'we_message') {
	    continue;
	}
	check(opener.current_sel[i][1] + '&' + opener.current_sel[i][2]);
    }
 }

 function start() {
    loadData();
    drawEintraege();
 }

 var startloc=0;


	sel_color = "#697ace";
	default_color = "#000000";

	function showContent(id) {
		top.messaging_cmd.location = "<?php print WE_MESSAGING_MODULE_PATH;  ?>messaging_cmd.php?we_transaction=<?php echo $we_transaction?>&mcmd=show_message&id=" + id;
	}

	function array_search(needle, haystack) {
		var i;

		for (i = 0; i < haystack.length; i++) {
			if (needle == haystack[i])
				return i;
		}

		return -1;
	}


 self.focus();
</script>

 </script>
 </head>
  <frameset rows="*,40" framespacing="0" border="0" frameborder="NO" onLoad=" start();">
   <frame src="<?php print HTML_DIR?>white.html" name="messaging_usel_main" scrolling="auto">
   <frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_usel_iconbar.php" name="user_cmd" scrolling=no noresize marginwidth="0" marginheight="0">
  </frameset>

 <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html>
