<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

class weModuleFrames{

	var $db;
	var $View;
	var $frameset;
	var $edit_cmd="edit_newsletter";

	function weModuleFrames($frameset){
		$this->db=new DB_WE();
		$this->frameset=$frameset;
	}

	function getJSTreeCode(){
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>md5.js"></script>
<script language="javascript" type="text/javascript">

 var loaded=0;
 var hot=0;
 var hloaded=0;

 function setHot(){
    hot=1;
 }

 function usetHot(){
    hot=0;
 }

 var menuDaten = new container();var count = 0;var folder=0;
 var table="<?php print BANNER_TABLE; ?>";

 function drawEintraege(){
    fr = top.content.resize.left.tree.document;
    fr.open();
    fr.writeln("<HTML><HEAD>");
    fr.writeln("<SCRIPT LANGUAGE=\"JavaScript\">");
    fr.writeln("clickCount=0;");
    fr.writeln("wasdblclick=0;");
    fr.writeln("tout=null");
    fr.writeln("function doClick(id,ct,table){");
    //fr.writeln("if(ct=='folder') top.content.we_cmd('edit_newsletter',id,ct,table); else if(ct=='file') top.content.we_cmd('show_document',id,ct,table);");
	 fr.writeln("top.content.we_cmd('<?php print $this->edit_cmd; ?>',id,ct,table);");
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


 function zeichne(startEntry,zweigEintrag){
	var nf = search(startEntry);
	var ai = 1;
        while (ai <= nf.laenge) {
		fr.write(zweigEintrag);

                if (nf[ai].typ == 'file') {
			if(ai == nf.laenge) fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzungend.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
			else fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzung.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
			if(nf[ai].name != -1){
				fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
			}
			fr.write("<IMG SRC=<?php print TREE_IMAGE_DIR;?>icons/"+nf[ai].icon+" WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 alt=\"<?php #print $GLOBALS["l_tree"]["edit_statustext"]; ?>\">");
			fr.write("</a>");
			fr.write("&nbsp;<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\">"+(parseInt(nf[ai].published) ? "" : "")+ nf[ai].text +(parseInt(nf[ai].published) ? "" : "")+ "</A>&nbsp;&nbsp;<BR>\n");
		}else{
			var newAst = zweigEintrag;

			var zusatz = (ai == nf.laenge) ? "end" : "";

			if (nf[ai].offen == 0){
				fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',1)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>auf"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php #print $l_tree["open_statustext"] ?>\"></A>");
				var zusatz2 = "";
			}else{
				fr.write("&nbsp;&nbsp;<A href=\"javascript:top.content.openClose('" + nf[ai].name + "',0)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>zu"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php #print $l_tree["close_statustext"] ?>\"></A>");
	        	var zusatz2 = "open";
	        }
			fr.write("<a name='_"+nf[ai].name+"' href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
			fr.write("<IMG SRC=<?php print TREE_IMAGE_DIR;?>icons/"+nf[ai].icon.replace(/\.gif/,"")+zusatz2+".gif WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 Alt=\"<?php #print $l_tree["edit_statustext"]; ?>\">");
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
        if(ct=="folder")
          menuDaten.addSort(new dirEntry(icon,id,pid,txt,offen,ct,tab,pub));
        else
          menuDaten.addSort(new urlEntry(icon,id,pid,txt,ct,tab,pub));
	drawEintraege();
 }

 function updateEntry(id,pid,text,pub){
        var ai = 1;
        while (ai <= menuDaten.laenge) {
            if (menuDaten[ai].name==id) {
                 menuDaten[ai].vorfahr=pid;
                 menuDaten[ai].text=text;
                 menuDaten[ai].published=1;
             }
             ai++;
        }
        drawEintraege();
 }

 function deleteEntry(id,type){
        var ai = 1;
        var ind=0;
        while (ai <= menuDaten.laenge) {
            if ((menuDaten[ai].typ==type))
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

 function search(eintrag){var nf = new container();var ai = 1;while (ai <= menuDaten.laenge) {if ((menuDaten[ai].typ == 'folder') || (menuDaten[ai].typ == 'file'))if (menuDaten[ai].vorfahr == eintrag) nf.add(menuDaten[ai]);ai++;}return nf;}

 function container(){this.laenge = 0;this.clear=containerClear;this.add = add;this.addSort = addSort;return this;}

 function add(object){this.laenge++;this[this.laenge] = object;}

 function containerClear(){this.laenge =0;}

 function addSort(object){this.laenge++;for(var i=this.laenge; i>0; i--){if(i > 1 && this[i-1].text.toLowerCase() > object.text.toLowerCase() ){this[i] = this[i-1];}else{this[i] = object;break;}}}

 function rootEntry(name,text,rootstat){this.name = name;this.text = text;this.loaded=true;this.typ = 'root';this.rootstat = rootstat;return this;}

 function dirEntry(icon,name,vorfahr,text,offen,contentType,table,published){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'folder';this.offen = (offen ? 1 : 0);this.contentType = contentType;this.table = table;this.loaded = (offen ? 1 : 0);this.checked = false;this.published = published;return this;}

 function urlEntry(icon,name,vorfahr,text,contentType,table,published){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'file';this.checked = false;this.contentType = contentType;this.table = table;this.published = published;return this;}

 function start(){loadData();drawEintraege();}

 var startloc=0;

 self.focus();
 </script>
 <?php
 }

 function getHTMLFrameset(){
	$this->getJSTreeCode();
 ?>
 </head>
   <frameset rows="32,*,0" framespacing="0" border="0" frameborder="NO" onLoad="start();">
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=header" name="header" scrolling=no noresize>
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=resize" name="resize" scrolling=no>
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=cmd" name="cmd" scrolling=no noresize>
  </frameset>

 <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html>
<?php

	}

	function getHTMLHeader(){
?>
</head>
 <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
	HEADER
 </body>
</html>
<?php

	}

	function getHTMLResize(){
?>
</head>
<?php if ($GLOBALS["BROWSER"] == "NN6"){ ?>
	<frameset cols="170,*" border="1" id="resizeframeid">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=left" name="left" scrolling="no">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=right" name="right">
	</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="170,*" framespacing="0" border="0" frameborder="0" id="resizeframeid">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=left" name="left" scrolling="no">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=right" name="right">
	</frameset>
<?php } else { //IE ?>
	<frameset cols="170,*" framespacing="0" border="0" frameborder="0" id="resizeframeid">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=left" name="left" scrolling="no" frameborder="0">
		<frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=right" name="right">
	</frameset>
<?php } ?>
<noframes>
 <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</noframes>
</html>
<?php

	}

	function getHTMLLeft(){

?>
    </head>
    <frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
    <frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no" noresize>
    <frame src="<?php print HTML_DIR?>white.html" name="tree" scrolling="auto" noresize>
   </frameset>
   <noframes>
   <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
   </body>
   </noframes>
</html>
<?php

	}

	function getHTMLRight(){

?>
</head>
<?php if ($GLOBALS["BROWSER"] == "NN6")	{ ?>
	<frameset cols="*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=editor" scrolling="no" noresize name="editor">
	</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="1,*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print HTML_DIR; ?>safariResize.html" name="separator" noresize scrolling="no">
        <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=editor" noresize name="editor" scrolling="no">
	</frameset>
<?php } else { ?>
	<frameset cols="2,*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print HTML_DIR; ?>ieResize.html" name="separator" noresize scrolling="no">
        <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=editor" noresize name="editor" scrolling="no">
	</frameset>
<?php } ?>
	<noframes>
    <body bgcolor="#ffffff">
		<p></p>
	</body>
	</noframes>
</html>

<?php

	}

	function getHTMLEditor(){
?>
</head>
   <frameset rows="40,*,40" framespacing="0" border="0" frameborder="no">
    <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=edheader&home=1" name="edheader" noresize scrolling=no>
    <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=edbody&home=1" name="edbody" scrolling=auto>
    <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/"?><?php print $this->frameset?>?pnt=edfooter&home=1" name="edfooter" scrolling=no>

   </frameset>
<noframes>
 <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</noframes>
</html>
<?php
	}


}

?>
