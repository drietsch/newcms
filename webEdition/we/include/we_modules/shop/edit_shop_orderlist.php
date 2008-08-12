<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_orderlist.php,v 1.12 2007/05/31 15:37:23 damjan.denic Exp $

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once(WE_SHOP_MODULE_DIR . 'shopFunctions.inc.php');

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
	$orderList = getCustomersOrderList($_REQUEST["cid"]);
}
?>
</head>
<body class="weEditorBody" onunload="doUnload()">
<?php print  htmlDialogLayout($orderList,$l_shop["order_liste"]."&nbsp;".$Kundenname);?>   
</body></html>
