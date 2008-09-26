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
