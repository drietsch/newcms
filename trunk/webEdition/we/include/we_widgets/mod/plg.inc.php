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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_widgets/inc/plg/chart.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cockpit.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"].WE_TRACKER_DIR."/includes/showme.inc.php");

protect();

$_url = getServerProtocol(true) . $_SERVER['SERVER_NAME'] . (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT']!= 80 ?
	':'.$_SERVER['SERVER_PORT'] : '')."/webEdition/we/include/we_widgets/inc/plg/";

$_isPrev = !isset($aProps);

list($_pLogCsv,$_pLogUrl64) = explode(";",(($_isPrev)? $_REQUEST["we_cmd"][0] : $aProps[3]));
$_pLogUrl = base64_decode($_pLogUrl64);

$_pLog_[] = array('visitors_data_today','visitors_today_total','visitors_today_unique','lateral_entry_today','pages_today','transfer_today');
$_pLog_[] = array('visitors_data_yesterday','visitors_yesterday_total','visitors_yesterday_unique','lateral_entry_yesterday','pages_yesterday','transfer_yesterday');
$_pLog_[] = array('visitors_data_this_month','visitors_this_month_total','visitors_this_month_unique','lateral_entry_this_month','pages_this_month','transfer_this_month');
$_pLog_[] = array('visitors_behaviour_today','visitors_avg_hour_today','retention_avg_visitor_today','showtime_avg_page_today','impressions_per_visitor_today');
$_pLog_[] = array('Snapshot','usercount','bot_visits','downloads','visitor_per_hour');
$_pLog_[] = array('top_visiting_periods','strongest_visitor_hour','lowest_visitor_hour','strongest_visitor_day','lowest_visitor_day');
$_pLog_[] = array('visitors_forecast','forecast_today');
$_pLog_[] = array('avg_amount_visitors','avg_visitors_hour','avg_visitors_day','avg_visitors_month');
$_pLog_[] = array('promo_value_tai','promo_value_today','promo_value_this_month','promo_value_this_year');

$_pLogOut = we_htmlElement::cssElement("TD{font-family:arial,verdana;color:#2f2f2f;font-size:11px;line-height:16px}
.tablehead{padding-left:2px;background-color:#cccccc;font-size:10px;color:#000000;font-weight:bold;}
.boxbg{padding-left:5px;font-size:10px;color:black;background-color:#F8F8F8;}
.resbg{padding-left:5px;font-size:10px;color:black;background-color:#EFEFEF;}
.bulletCircle{width:7px;height:7px;}
.finelinebox{border-right:#666666 1px solid;border-top:#666666 1px solid;border-left:#666666 1px solid;border-bottom:#666666 1px solid;}");

$_gap = false;
for($i = 0;$i <= 10;$i++) {
	if ($_pLogCsv[$i]) {
		if ($_gap) {
			$_pLogOut .= getPixel(1,8).we_htmlElement::htmlBr();
		}
		else {
			$_gap = true;
		}
		if ($i <= 8) {
			$_pLogChart = getPLogChart($_pLog_[$i]);
			$_pLogOut .= $_pLogChart->getHTMLCode();
		}
		else {
			switch ($i) {
				case 9:
					$_gf = "graph_visitors_today";
					break;
				case 10:
					$_gf = "graph_impressions_today";
					break;
			}
			$_pLogGraph = getPLogGraph($_gf);
			$_pLogOut .= $_pLogGraph->getHTMLCode();
		}
	}
}

if ($_isPrev) {
	$sJsCode = "
	var _sObjId='".$_REQUEST["we_cmd"][5]."';
	var _sType='plg';
	var _sTb='".$l_cockpit['pagelogger'].($_pLogUrl != ''? ' - '.$_pLogUrl : $_pLogUrl)."';

	function init(){
		parent.rpcHandleResponse(_sType,_sObjId,document.getElementById(_sType),_sTb);
	}
	";

	print we_htmlElement::htmlHtml(
		we_htmlElement::htmlHead(
			we_htmlElement::htmlTitle($l_cockpit['pagelogger']).
			STYLESHEET.
			we_htmlElement::jsElement($sJsCode)
		).
		we_htmlElement::htmlBody(array(
			"marginwidth" => "15",
			"marginheight" => "10",
			"leftmargin" => "15",
			"topmargin" => "10",
			"onload" => "if(parent!=self)init();"
			),we_htmlElement::htmlDiv(array("id"=>"plg"),$_pLogOut)
		)
	);
} else {
	$_pLog = new we_htmlTable(array("width"=>"100%","border"=>"0","cellpadding" =>"0","cellspacing"=>"0"),1,1);
	$_pLog->setCol(0,0,null,$_pLogOut);
}

?>
