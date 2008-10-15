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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");

if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop_month.inc.php");
}

protect();

htmlTop();

print STYLESHEET;

/// config
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));

$waehr="&nbsp;".$feldnamen[0];
$dbPreisname="Preis";
$numberformat= $feldnamen[2];
$mwst= (!empty($feldnamen[1]))?(($feldnamen[1]/100)+1):"";
$year=abs(substr($_REQUEST["mid"],-4));
$month=abs(str_replace($year,"",$_REQUEST["mid"]));

$bezahlt = 0;
$unbezahlt = 0;

$r = 0;

$f = 0;


  $DB_WE->query("SELECT IntOrderID, Price, IntQuantity, DateShipping,DatePayment FROM ".SHOP_TABLE." where DateOrder >= '$year".(($month<10)?"0".$month:$month)."01000000' and DateOrder <= '$year".(($month<10)?"0".$month:$month).date("t", mktime(0,0,0,$month,1,$year))."000000' order by IntOrderID");
     while($DB_WE->next_record()){
     	if($DB_WE->f("DatePayment")!=0){
     	    if(!isset($bezahlt)){
     	        $bezahlt = 0;
     	    }
     		$bezahlt += ($DB_WE->f("IntQuantity")*$DB_WE->f("Price")); //bezahlt
     	}else{
     	    if(!isset($unbezahlt)){
     	        $unbezahlt = 0;
     	    }
     		$unbezahlt += ($DB_WE->f("IntQuantity")*$DB_WE->f("Price")); //unbezahlt
     	}

     	if(isset($orderid) ? $DB_WE->f("IntOrderID") != $orderid : $DB_WE->f("IntOrderID")){
	     	if($DB_WE->f("DateShipping")!=0){
	     		$r++; //bearbeitet
	     	}else{
	     		$f++; //unbearbeitet
	     	}
     	}
     	$orderid=$DB_WE->f("IntOrderID");
     }


function numfom($result){
global $numberformat;
     if($numberformat=="german"){
			$result=number_format($result,2,",",".");
		}else if($numberformat=="french"){
			$result=number_format($result,2,","," ");
		}else if($numberformat=="swiss"){
			$result=number_format($result,2,".","'");
		}else if($numberformat=="english"){
			$result=number_format($result,2,".","");
		}
		return $result;
}

$mwst = (!empty($mwst))?$mwst:1;
$info = $l_shop["anzahl"].": <b>".($f+$r)."</b><br>".$l_shop["unbearb"].": ".(($f)?$f:"0");
$stat = $l_shop["umsatzgesamt"].": <b>".numfom(($bezahlt+$unbezahlt)*$mwst)." $waehr </b><br><br>".$l_shop["schonbezahlt"].": ".numfom($bezahlt*$mwst)." $waehr <br>".$l_shop["unbezahlt"].": ".numfom($unbezahlt*$mwst)." $waehr";
?>
    <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>


	</head>

<body class="weEditorBody" onunload="doUnload()">

<?php

$parts = array();

array_push($parts,
			array(
				"headline"=>$l_shop_month[$month]." ".$year,
				"html"=>$info,
				"space"=>170
				)
		);


array_push($parts,
			array(
				"headline"=>$l_shop["stat"],
				"html"=>$stat,
				"space"=>170
				)
		);

print we_multiIconBox::getHTML("","100%",$parts,30,"",-1,"","",false,$GLOBALS["l_tabs"]["module"]["overview"]);

?>



 </body></html>