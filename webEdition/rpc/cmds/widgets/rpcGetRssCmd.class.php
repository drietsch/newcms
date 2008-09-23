<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cockpit.inc.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/PEAR.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Parser.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/RSS.php");

$GLOBALS["l_cockpit"] = $l_cockpit;

class rpcGetRssCmd extends rpcCmd {
	
	function execute() {
		
		$sRssUri = $_REQUEST["we_cmd"][0];
		$sCfgBinary = $_REQUEST["we_cmd"][1];
		$bCfgTitle = (bool) $sCfgBinary{0};
		$bCfgLink = (bool) $sCfgBinary{1};
		$bCfgDesc = (bool) $sCfgBinary{2};
		$bCfgContEnc = (bool) $sCfgBinary{3};
		$bCfgPubDate = (bool) $sCfgBinary{4};
		$bCfgCategory = (bool) $sCfgBinary{5};
		$iNumItems = $_REQUEST["we_cmd"][2];
		switch($iNumItems){
			case 11: $iNumItems = 15; break;
			case 12: $iNumItems = 20; break;
			case 13: $iNumItems = 25; break;
			case 14: $iNumItems = 50; break;
		}
		$sTbBinary = $_REQUEST["we_cmd"][3];
		$bTbLabel = (bool) $sTbBinary{0};
		$bTbTitel = (bool) $sTbBinary{1};
		$bTbDesc = (bool) $sTbBinary{2};
		$bTbLink = (bool) $sTbBinary{3};
		$bTbPubDate = (bool) $sTbBinary{4};
		$bTbCopyright = (bool) $sTbBinary{5};
		
		$oRssParser =& new XML_RSS($sRssUri,$GLOBALS["_language"]["charset"]);
		$oRssParser->parse();
		$sRssOut = "";
		
		$iCurrItem = 0;
		foreach ($oRssParser->getItems() as $item) {
			$bShowTitle = ($bCfgTitle && isset($item['title']))? true : false;
			$bShowLink = ($bCfgLink && isset($item['link']))? true : false;
			$bShowDesc = ($bCfgDesc && isset($item['description']))? true : false;
			$bShowContEnc = ($bCfgContEnc && isset($item['content:encoded']))? true : false;
			$bShowPubdate = ($bCfgPubDate && isset($item['pubdate']))? true : false;
			$bShowCategory = ($bCfgCategory && isset($item['category']))? true : false;
			if ($bShowTitle) {
				$sRssOut .= ($bShowLink)? we_htmlElement::htmlA(array("href"=>$item['link'],"target"=>"_blank"),we_htmlElement::htmlB($item['title'])) :
					we_htmlElement::htmlB($item['title']);
				$sRssOut .= we_htmlElement::htmlBr().getPixel(1,5).(($bShowDesc || $bShowContEnc)? we_htmlElement::htmlBr() : "");
			}
			if ($bShowPubdate) {
				$sRssOut .= $GLOBALS["l_cockpit"]["published"].": ".date($GLOBALS["l_global"]["date_format"], strtotime($item['pubdate']));
			}
			if ($bShowCategory) {
				$sRssOut .= ($bShowPubdate)? we_htmlElement::htmlBr().getPixel(1,2).we_htmlElement::htmlBr() : "";
				$sRssOut .= $GLOBALS["l_cockpit"]["category"].": ".$item['category'];
			}
			if ($bShowPubdate || $bShowCategory) {
				$sRssOut .= we_htmlElement::htmlBr().getPixel(1,5).we_htmlElement::htmlBr();
			}
			$sLink = (($bCfgLink && isset($item['link']))&&!$bShowTitle)? " &nbsp;".
				we_htmlElement::htmlA(array("href"=>$item['link'],"target"=>"_blank","style"=>"text-decoration:underline;"),$GLOBALS["l_cockpit"]['more']) : "";
			$sRssOut .= ($bShowDesc)? $item['description'].$sLink.we_htmlElement::htmlBr() : "";
			if ($bShowContEnc) {
				$contEnc = new we_htmlTable(array("border"=>"0","cellpadding" =>"0","cellspacing"=>"0"),1,1);
				$contEnc->setCol(0,0,null,$item['content:encoded'].((!$bCfgDesc)? $sLink : ""));
				$sRssOut .= $contEnc->getHTMLCode();
			} else if(!$bShowDesc) {
				$sRssOut .= $sLink.we_htmlElement::htmlBr();
			}
			$sRssOut .= ($bShowDesc || $bShowContEnc)? getPixel(1,10).we_htmlElement::htmlBr() : "";
			if ($iNumItems) {
				$iCurrItem++;
				if ($iCurrItem==$iNumItems) {
					break;
				}
			}
		}
		
		$aTb = array();
		if ($bTbLabel) $aTb[] = $GLOBALS["l_cockpit"]['rss_feed'];
		if ($bTbTitel) $aTb[] = (isset($_REQUEST["we_cmd"][4]) && $_REQUEST["we_cmd"][4] != "")? $_REQUEST["we_cmd"][4] :
			((isset($oRssParser->channel["title"]))? $oRssParser->channel["title"] : "");
		if ($bTbDesc) $aTb[] = (isset($oRssParser->channel["description"]))? ereg_replace("(\r\n|\n|\r)","",$oRssParser->channel["description"]) : "";
		if ($bTbLink) $aTb[] = (isset($oRssParser->channel["link"]))? $oRssParser->channel["link"] : "";
		if ($bTbPubDate) $aTb[] = (isset($oRssParser->channel["pubdate"]))? (date($GLOBALS["l_global"]["date_format"], strtotime($oRssParser->channel["pubdate"]))) : "";
		if ($bTbCopyright) $aTb[] = (isset($oRssParser->channel["copyright"]))? $oRssParser->channel["copyright"] : "";
		
		$resp = new rpcResponse();
		$resp->setData("data", $sRssOut);
		
		// title
		$_title = implode(" - ", $aTb);
		if (strlen($_title) > 50) {
			$_title = substr($_title, 0, 50) . "...";
		}
		$resp->setData("titel", $_title);
		$resp->setData("widgetType", "rss");
		$resp->setData("widgetId", $_REQUEST["we_cmd"][5]);
		
		return $resp;
	}
}

?>