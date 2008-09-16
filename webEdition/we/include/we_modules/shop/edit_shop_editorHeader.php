<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or higher                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | shopModule by Jan Gorba                   |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_editorHeader.php,v 1.17 2007/07/13 10:34:27 alexander.lindenstruth Exp $

if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
	print '<body bgcolor="#FFFFFF" background="/webEdition/images/backgrounds/bgGrayLineTop.gif"></body></html>';
	exit;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop_month.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

protect();

htmlTop();

print STYLESHEET;

if (!isset($l_shop["lastOrd"])){
	$l_shop["lastOrd"] = "";
}
if (!isset($l_shop["lastNo"])){
	$l_shop["lastNo"] = "";
}

$bid = isset($_REQUEST["bid"]) ? $_REQUEST["bid"] : 0;

$cid = f("SELECT IntCustomerID FROM ".SHOP_TABLE." WHERE IntOrderID = ".$bid,"IntCustomerID",$DB_WE);
$DB_WE->query("SELECT IntOrderID,DATE_FORMAT(DateOrder,'".$l_global["date_format_dateonly_mysql"]."') as orddate FROM ".SHOP_TABLE." group by IntOrderID order by IntID DESC");
if ($DB_WE->next_record()) {
	$headline = $l_shop["lastOrd"]." ".$l_shop["lastNo"]." ". $DB_WE->f("IntOrderID")."&nbsp;&raquo; ".$l_shop["bestellung"]." ".$DB_WE->f("orddate");
	$textPost = sprintf($l_shop["orderNo"],$_REQUEST['bid'],$DB_WE->f("orddate")); 
} else {
	$headline = "";
	$textPost = ""; 
}


$we_tabs = new we_tabs();

if (isset($_REQUEST["mid"]) && $_REQUEST["mid"] && $_REQUEST["mid"] != '00'){

	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["overview"], "TAB_ACTIVE","0"));

} else {

	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["orderdata"], "TAB_ACTIVE","setTab(0);"));
	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["orderlist"], "TAB_NORMAL","setTab(1);"));
	/*
	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["addtab1"], "TAB_NORMAL","setTab(2);"));
	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["addtab2"], "TAB_NORMAL","setTab(3);"));
	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["addtab3"], "TAB_NORMAL","setTab(4);"));
	$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["addtab4"], "TAB_NORMAL","setTab(5);"));
	*/
}

$textPre = isset($_REQUEST['bid']) && $_REQUEST['bid'] > 0 ? $l_shop['orderList']['order'] : $l_shop["order_view"];
$textPost = isset($_REQUEST['mid']) && $_REQUEST['mid'] > 0 ? (strlen($_REQUEST['mid'])>5 ? $l_shop_month[substr($_REQUEST['mid'],0,-5)] . " " . substr($_REQUEST['mid'],-5,4): substr($_REQUEST['mid'],1)) : $textPost;
//$textPost = sprintf($l_shop["orderNo"],$_REQUEST['bid'],"post"); 
$we_tabs->onResize();
$tab_head = $we_tabs->getHeader();

$tab_body = '<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",$textPre) . ':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">' . str_replace(" ","&nbsp;",$textPost) . '</b></span></nobr></div>' .getPixel(100,3) .
			$we_tabs->getHTML() . 
			'</div>';
?>
   <script language="JavaScript">
	<!--
    function setTab(tab){
        	switch(tab){
			case 0:
				parent.edbody.document.location = 'edit_shop_properties.php?bid=<?php print $bid; ?>';
			break;
			case 1:
				parent.edbody.document.location = 'edit_shop_orderlist.php?cid=<?php print $cid; ?>';
			break;
		}
	}

   top.content.hloaded=1;
	//-->
   </script>
   <?php
   print $tab_head;
   ?>
   <body bgcolor="white" background="<?php print IMAGE_DIR; ?>backgrounds/header_with_black_line.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onload="setFrameSize()" onresize="setFrameSize()">
		<?php
		print $tab_body;
		?>
		
	</body>
</html>