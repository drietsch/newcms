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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/tree.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}

protect();

htmlTop();

print STYLESHEET;


	// grep the last element from the year-set, wich is the current year
	$DB_WE->query("SELECT DATE_FORMAT(DateOrder,'%Y') AS DateOrd FROM ".SHOP_TABLE . " ORDER BY DateOrd");
	while ($DB_WE->next_record()) {
	$strs = array($DB_WE->f("DateOrd"));
	$yearTrans = end($strs);


}
// print $yearTrans;


/// config
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));
	for ($i=0;$i<=3;$i++) {
		$feldnamen[$i] = isset($feldnamen[$i]) ? $feldnamen[$i] : '';
	}

	 $fe = explode(",",$feldnamen[3]);
	  if(empty($classid)){
	  	$classid = $fe[0];
	  }


      //$resultO = count ($fe);
       $resultO = array_shift ($fe);

    $dbTitlename="shoptitle";
    // wether the resultset ist empty?
	$DB_WE->query("SELECT count(Name) as Anzahl FROM ".LINK_TABLE." WHERE Name ='$dbTitlename'");
	$DB_WE->next_record();
	$resultD = $DB_WE->f("Anzahl");


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
 <script language="JavaScript" type="text/javascript">

 var hot = 0;
 
 parent.document.title = "<?php print $title; ?>";
 
function doUnload() {
	if (!!jsWindow_count) {
		for (i = 0; i < jsWindow_count; i++) {
			eval("jsWindow" + i + "Object.close()");
		}
	}
}
			
 function we_cmd(){
  var args = "";


  var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
  switch (arguments[0]){
		case "new_shop":
                        top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_editorFrameset.php";
			break;
		case "delete_shop":

			if ( top.content && top.content.shop_properties.edbody.hot && top.content.shop_properties.edbody.hot == 1 ) {
				if(confirm('<?php echo $l_shop["del_shop"]; ?>')){
					top.content.shop_properties.edbody.deleteorder();
				}
			} else {
				<?php print we_message_reporting::getShowMessageCall( $l_shop["nothing_to_delete"], WE_MESSAGE_NOTICE); ?>
			}

		break;
		case "new_article":
			if ( top.content && top.content.shop_properties.edbody.hot && top.content.shop_properties.edbody.hot == 1 ) {
				top.content.shop_properties.edbody.neuerartikel();
			} else {
				<?php print we_message_reporting::getShowMessageCall($l_shop["no_order_there"], WE_MESSAGE_ERROR); ?>
			}
		break;


	case "revenue_view":

			<?php	if ( ($resultD > 0) && (!empty($resultO)) ){  //docs and objects ?>
					top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_editorFramesetTop.php?typ=document";
	        <?php     }elseif(($resultD < 1) && (!empty($resultO)) ){ // no docs but objects ?>
	            	top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_editorFramesetTop.php?typ=object&ViewClass=$classid";
	        <?php    }elseif(($resultD > 0) && (empty($resultO)) ){ // docs but no objects ?>
	            	top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_editorFramesetTop.php?typ=document";
	         <?php    } ?>

		break;

<?php
    $yearshop = "2002";
   	$z=1;
	while ($yearshop <= date("Y")) {
       echo ' case "year'.$yearshop.'":
       					top.content.location="/webEdition/we/include/we_modules/show.php?mod=shop&year='.$yearshop.'";
        		break;
       ';
	   $yearshop++; $z++;
	}
?>
		case "pref_shop":
			//var wind = new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_pref.php","shoppref",-1,-1,470,600,true,true,true,false);
		break;

		case 'edit_shop_vats':
			//var wind = new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_vats.php","edit_shop_vats",-1,-1,500,450,true,false,true,false);
		break;

		case 'edit_shop_shipping':
			//var wind = new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_shipping.php","edit_shop_shipping",-1,-1,700,600,true,false,true,false);
		break;

		case 'edit_shop_vat_country':
			//var wind = new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_vat_country.php","edit_shop_vat_country",-1,-1,700,780,true,true,true,false);
		break;

		case "payment_val":
			//var wind = new jsWindow("<?php print WE_SHOP_MODULE_PATH ?>edit_shop_payment.inc.php","shoppref",-1,-1,520,720,true,false,true,false);
		break;

        default:
	        for (var i = 0; i < arguments.length; i++) {

				args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
			}
			eval('opener.top.content.we_cmd('+args+')');
		break;
	}
}



 var menuDaten = new container();var count = 0;var folder=0;
 var table="<?php print SHOP_TABLE;?>";

 function drawEintraege(){
    fr = top.content.shop_tree.window.document;
    fr.open();
    fr.writeln("<HTML><HEAD>");
    fr.writeln("<SCRIPT LANGUAGE=\"JavaScript\">");
    fr.writeln("clickCount=0;");
    fr.writeln("wasdblclick=0;");
    fr.writeln("tout=null");
    fr.writeln("function doClick(id,ct,table){");
    fr.writeln("top.content.shop_properties.location='<?php print WE_SHOP_MODULE_PATH ?>edit_shop_editorFrameset.php?bid='+id;");
    fr.writeln("}");
    fr.writeln("function doFolderClick(id,ct,table){");
    fr.writeln("top.content.shop_properties.location='<?php print WE_SHOP_MODULE_PATH ; ?>edit_shop_editorFrameset.php?mid='+id;");
    fr.writeln("}");

     fr.writeln("function doYearClick(yearView){");
    fr.writeln("top.content.shop_properties.location='<?php print WE_SHOP_MODULE_PATH ; ?>edit_shop_editorFrameset.php?ViewYear='+yearView;");
    fr.writeln("}");

    fr.writeln("</"+"SCRIPT>");
    fr.writeln('<?php print STYLESHEET_SCRIPT;?>');
    fr.write("</HEAD>\n");
    fr.write("<BODY BGCOLOR=\"#F3F7FF\" LINK=\"#000000\" ALINK=\"#000000\" VLINK=\"#000000\" leftmargin=5 topmargin=0 marginheight=0 marginwidth=5>\n");
    fr.write("<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td class=\"tree\">\n<NOBR>\n");
    fr.write("<tr><td class=\"tree\">\n<NOBR>\n<a href=javascript:// onClick=\"doYearClick("+ top.yearshop +");return true;\" title=\"Ums�tze des Gesch�ftsjahres\" ><?php print $l_shop["treeYear"];?>: <strong>" + top.yearshop + " </strong></a> <br/>\n");

    zeichne("0","");
    fr.write("</NOBR>\n</td></tr></table>\n");
    fr.write("</BODY>\n</HTML>");
    fr.close();
   }


 function zeichne(startEntry,zweigEintrag){
	var nf = search(startEntry);
	var ai = 1;
	while (ai <= nf.laenge) {
		fr.write(zweigEintrag);
		if (nf[ai].typ == 'shop') {
			if(ai == nf.laenge) fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzungend.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");
			else fr.write("&nbsp;&nbsp;<IMG SRC=<?php print TREE_IMAGE_DIR; ?>kreuzung.gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0>");

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?> // make  in tree clickable
			if(nf[ai].name != -1){
			fr.write("<a href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");
			}

<?php endif ?>

			fr.write("<IMG SRC=<?php print TREE_IMAGE_DIR; ?>icons/"+nf[ai].icon+" WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 title=\"<?php print $l_tree["edit_statustext"]; ?>\">");

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?>
			fr.write("</a>");

<?php endif ?>

fr.write("&nbsp;");

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?> // make orders in tree clickable
			fr.write("<a href=\"javascript://\" onClick=\"doClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\">");

<?php endif ?>
			fr.write("<font color=\"black\">"+(parseInt(nf[ai].published) ? " <b>" : "")+ nf[ai].text +(parseInt(nf[ai].published) ? " </b>" : "")+ "</font>");

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?>
			fr.write("</A>");

<?php endif ?>

			fr.write("&nbsp;&nbsp;<BR>\n");
		}else{
			var newAst = zweigEintrag;

			var zusatz = (ai == nf.laenge) ? "end" : "";

			if (nf[ai].offen == 0){
				fr.write("&nbsp;&nbsp;<A HREF=\"javascript:top.content.openClose('" + nf[ai].name + "',1)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>auf"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 title=\"<?php print $l_tree["open_statustext"] ?>\"></A>");
				var zusatz2 = "";
			}else{
				fr.write("&nbsp;&nbsp;<A HREF=\"javascript:top.content.openClose('" + nf[ai].name + "',0)\" BORDER=0><IMG SRC=<?php print TREE_IMAGE_DIR; ?>zu"+zusatz+".gif WIDTH=19 HEIGHT=18 align=absmiddle BORDER=0 title=\"<?php print $l_tree["close_statustext"] ?>\"></A>");
	        	var zusatz2 = "open";
	        }
<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?>
			fr.write("<a href=\"javascript://\" onClick=\"doFolderClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\" BORDER=0>");

<?php endif ?>

			fr.write("<IMG SRC=<?php print TREE_IMAGE_DIR; ?>icons/folder"+zusatz2+".gif WIDTH=16 HEIGHT=18 align=absmiddle BORDER=0 title=\"<?php print $l_tree["edit_statustext"]; ?>\">");

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?>
			fr.write("</a>");

<?php endif ?>

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?> // make the month in tree clickable
			fr.write("<A HREF=\"javascript://\" onClick=\"doFolderClick("+nf[ai].name+",'"+nf[ai].contentType+"','"+nf[ai].table+"');return true;\">");

<?php endif ?>

			fr.write("&nbsp;"+(parseInt(nf[ai].published) ? " <b>" : "") + nf[ai].text +(parseInt(nf[ai].published) ? " </b>" : ""));

<?php if(we_hasPerm("EDIT_SHOP_ORDER")): ?>

			fr.write("</a>");

<?php endif ?>

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


 function updateEntry(id,text,pub){
        var ai = 1;
        while (ai <= menuDaten.laenge) {
            if ((menuDaten[ai].typ=='folder') || (menuDaten[ai].typ=='shop'))
             if (menuDaten[ai].name==id) {
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
            if ((menuDaten[ai].typ=='folder') || (menuDaten[ai].typ=='shop'))
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

 function search(eintrag){var nf = new container();var ai = 1;while (ai <= menuDaten.laenge) {if ((menuDaten[ai].typ == 'folder') || (menuDaten[ai].typ == 'shop'))if (menuDaten[ai].vorfahr == eintrag) nf.add(menuDaten[ai]);ai++;}return nf;}

 function container(){this.laenge = 0;this.clear=containerClear;this.add = add;this.addSort = addSort;return this;}

 function add(object){this.laenge++;this[this.laenge] = object;}

 function containerClear(){this.laenge =0;}

 function addSort(object){this.laenge++;for(var i=this.laenge; i>0; i--){if(i > 1 && this[i-1].text.toLowerCase() > object.text.toLowerCase() ){this[i] = this[i-1];}else{this[i] = object;break;}}}

 function rootEntry(name,text,rootstat){this.name = name;this.text = text;this.loaded=true;this.typ = 'root';this.rootstat = rootstat;return this;}

 function dirEntry(icon,name,vorfahr,text,offen,contentType,table,published){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'folder';this.offen = (offen ? 1 : 0);this.contentType = contentType;this.table = table;this.loaded = (offen ? 1 : 0);this.checked = false;this.published = published;return this;}

 function urlEntry(icon,name,vorfahr,text,contentType,table,published){this.icon=icon;this.name = name;this.vorfahr = vorfahr;this.text = text;this.typ = 'shop';this.checked = false;this.contentType = contentType;this.table = table;this.published = published;return this;}


 function loadData(){

    menuDaten.clear();
    menuDaten.add(new self.rootEntry('0','root','root'));


    <?php

   // echo "menuDaten.add(new dirEntry('folder.gif','aaaa',0, 'Article',0,'','',".(($k>0)?1:0)."));";

    $DB_WE->query("SELECT IntOrderID,DateShipping, DATE_FORMAT(DateOrder,'".$l_global["date_format_dateonly_mysql"]."') as orddate, DATE_FORMAT(DateOrder,'%c%Y') as mdate FROM ".SHOP_TABLE." group by IntOrderID order by IntID DESC");
       while($DB_WE->next_record()){
         print "  menuDaten.add(new urlEntry('link.gif','".$DB_WE->f("IntOrderID")."',".$DB_WE->f("mdate").",'".$DB_WE->f("IntOrderID").". ".$l_shop["bestellung"]." ".$DB_WE->f("orddate")."','shop','".SHOP_TABLE."','".(($DB_WE->f("DateShipping")>0)?0:1)."'));\n";
       	 if($DB_WE->f("DateShipping")<=0){
       	    eval('if(isset($l' . $DB_WE->f("mdate") . ')) {$l'. $DB_WE->f("mdate") .'++;} else { $l'. $DB_WE->f("mdate") .' = 1;}');
       	 	//eval('$l'.$DB_WE->f("mdate")."++;");
       	 }
         eval('if(isset($v' . $DB_WE->f("mdate") . ')) {$v'. $DB_WE->f("mdate") .'++;} else { $v'. $DB_WE->f("mdate") .' = 1;}');
       	 //eval('$v'.$DB_WE->f("mdate")."++;");
       }

    ?>
        <?php $year=(empty($_REQUEST["year"]))?date("Y"):$_REQUEST["year"];
//        unset($_SESSION["year"]);
    for($f=12;$f>0;$f--){
        eval('$r = (isset($v' . $f . $year . ') ? $v' . $f . $year .' : ""); ');
    	//eval('$r = $v'.$f.$year.";");
    	eval('$k = (isset($l' . $f . $year . ') ? $l' . $f . $year .' : ""); ');
    	//eval('$k = $l'.$f.$year.";");
    	echo "menuDaten.add(new dirEntry('folder.gif',$f+''+$year,0, '".(($f<10)?"0".$f:$f).' '.$l_shop["sl"]." ".$GLOBALS["l_monthLong"][$f-1]. " (".(($k>0)?"<b>".$k."</b>":0)."/".(($r>0)?$r:0).")',0,'','',".(($k>0)?1:0)."));";
       } //'".$DB_WE->f("mdate")."'
       echo "top.yearshop = '$year';";
    ?>

 }


 function start(){loadData();drawEintraege();}
  self.focus();
</script>

	</head>
<?php if ($GLOBALS["BROWSER"] == "NN6")	{ ?>
	<frameset rows="28,38,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" border="0" frameborder="1" onLoad="start();">
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_header.php" name="shop_header" scrolling=no noresize>
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_iconbarHeader.php" name="shop_header_icons" scrolling=no noresize>

		<frameset cols="198,*"  border="1" frameborder="1">
			<frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
				<frame src="<?php print HTML_DIR?>whiteWithTopLine.html" name="shop_tree_header" scrolling="no">
				<frame src="<?php print HTML_DIR?>white.html" name="shop_tree" scrolling="auto">
			</frameset>
				<?php

				if (isset($_REQUEST['bid'])) {
					print '<frame src="' . WE_SHOP_MODULE_PATH . 'edit_shop_editorFrameset.php?bid=' . $_REQUEST['bid'] . '" name="shop_properties" scrolling=auto>';
				} else {
					print '<frame src="' . WE_SHOP_MODULE_PATH . 'edit_shop_editorFramesetTop.php?home=1" name="shop_properties" scrolling=auto>';
				}
				?>
		</frameset>
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_cmd.php" name="shop_cmd" scrolling=no noresize>
	</frameset>
<?php } else { ?>
	<frameset rows="28,38,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="NO" onLoad="start();">
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_header.php" name="shop_header" scrolling=no noresize>
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_iconbarHeader.php" name="shop_header" scrolling=no noresize>

		<frameset cols="198,*" framespacing="0" border="0" frameborder="0" id="resizeframeid">
			<frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
				<frame src="<?php print HTML_DIR?>whiteWithTopLine.html" name="shop_tree_header" scrolling="no">
				<frame src="<?php print HTML_DIR?>white.html" name="shop_tree" scrolling="auto">
			</frameset>
<?php if ($GLOBALS["BROWSER"] == "IE")	{ ?>
			<frameset cols="2,*" framespacing="0" border="0" frameborder="NO">
				<frame src="<?php print HTML_DIR; ?>whiteWithLeftLine.html" name="shop_separator_line" frameborder="0" noresize scrolling="no">
<?php } else { ?>
			<frameset cols="1,*" framespacing="0" border="0" frameborder="NO">
				<frame src="<?php print HTML_DIR; ?>safariResize.html" name="shop_separator_line" frameborder="0" noresize scrolling="no">
<?php } ?>
				<?php

				if (isset($_REQUEST['bid'])) {
					print '<frame src="' . WE_SHOP_MODULE_PATH . 'edit_shop_editorFrameset.php?bid=' . $_REQUEST['bid'] . '" name="shop_properties" scrolling=auto>';
				} else {
					print '<frame src="' . WE_SHOP_MODULE_PATH . 'edit_shop_editorFramesetTop.php?home=1" name="shop_properties" scrolling=auto>';
				}
				?>
			</frameset>
		</frameset>
		<frame src="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_cmd.php" name="shop_cmd" scrolling=no noresize>
	</frameset>
<?php } ?>
	<body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
	</body>
</html>
