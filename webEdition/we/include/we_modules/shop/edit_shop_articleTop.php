<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_articleTop.php,v 1.8 2007/05/31 15:40:22 damjan.denic Exp $

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}

protect();

htmlTop();

print STYLESHEET;

$da = ( $GLOBALS["WE_LANGUAGE"] == "Deutsch" )?"%d.%m.%y":"%m/%d/%y";
if(isset($_REQUEST["cid"])){
$foo = getHash("SELECT Forename,Surname FROM ".CUSTOMER_TABLE." WHERE ID='" . $_REQUEST["cid"] . "'",$DB_WE);
$Kundenname = $foo["Forename"]." ".$foo["Surname"];

//$DB_WE->query("SELECT IntOrderID, Price, IntQuantity, DateShipping,DatePayment FROM ".SHOP_TABLE." where IntCustomerID=$cid group by IntOrderID order by IntOrderID");

$Bestelldaten = '<table border="0" cellpadding="2" cellspacing="6" width="300">
				<tr><td class="defaultfont" colspan="2"><b>'.$l_shop["bestellung"].'</b></td>
				<td class="defaultfont"><b>'.$l_shop["datum"].'</b></td>
				</tr>
				<tr><td colspan=3></tr>';

$DB_WE->query("SELECT IntOrderID,DateShipping, DATE_FORMAT(DateOrder,'".$da."') as orddate, DATE_FORMAT(DateOrder,'%c%Y') as mdate FROM ".SHOP_TABLE." where IntCustomerID=" . $_REQUEST["cid"] . " group by IntOrderID order by IntID DESC");
while($DB_WE->next_record()){
//echo "<br>".$DB_WE->f("Price");
 $Bestelldaten .= "<tr><td class='defaultfont'><a href='" . WE_SHOP_MODULE_PATH . "edit_shop_properties.php?bid=".$DB_WE->f("IntOrderID")."' class=\"defaultfont\"><b>".$DB_WE->f("IntOrderID").".</b></a></td>";
 
 
 $Bestelldaten .= "<td class='defaultgray'>".$l_shop["bestellungvom"]."</td>";
 $Bestelldaten .= "<td class='defaultfont'><a href='" . WE_SHOP_MODULE_PATH . "edit_shop_editorFrameset.php?bid=".$DB_WE->f("IntOrderID")."' class=\"defaultfont\" target=\"shop_properties\"><b>".$DB_WE->f("orddate")."</b></a></td></tr>";
       	 
}
$Bestelldaten .= "</table>";
}else{

$Bestelldaten = $l_shop["keinedaten"];

}
?>
</head>
<body class="weEditorBody" onunload="doUnload()">
<?php print  htmlDialogLayout($Bestelldaten,$l_shop["order_liste"]."&nbsp;".$Kundenname);?>   
</body></html>
