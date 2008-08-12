<?php

// +---------------------------------------------------------+
// | webEdition
// +---------------------------------------------------------+
// | PHP version 5.1 or greater
// +---------------------------------------------------------+
// |Copyright (c) 2000 - 2008 living-e AG  
// +---------------------------------------------------------+

/**
* @author Thomas Kneip
* @copyright living-e AG
*/


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLog.class.php");
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/logging.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/contenttypes.inc.php');

class versionsLogView {
	
	public $db;
	public $actionView;
	public $versionPerPage = 10;
	
	
	function __construct() {
		
		$this->db = new DB_WE ( );
		$this->Model = new versionsLog();

	}
	
	function getJS() {
				
		$js = we_htmlElement::jsElement('
		
			var ajaxURL = "/webEdition/rpc/rpc.php";
			
			var currentId = 0;
			
			var ajaxCallbackDetails = {
				success: function(o) {
				if(typeof(o.responseText) != "undefined" && o.responseText != "") {
					document.getElementById("dataContent_"+currentId+"").innerHTML = o.responseText;
				}
			},
				failure: function(o) {
				}
			}
			
			function openDetails(id) {
				currentId = id;
				var dataContent = document.getElementById("dataContent_"+id+"");
				dataContent.innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /></td></tr></table>";  
				var otherdataContents = document.getElementsByName("dataContent");
				for(var i=0;i<otherdataContents.length;i++) {
					if(otherdataContents[i].id != "dataContent_"+id+""){
						otherdataContents[i].innerHTML = "";
					}
				}
				
				
				YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackDetails, "protocol=json&cns=logging/versions&cmd=GetLogVersionDetails&id="+id+"");
				
			}
			
			function showAll(id) {
				var Elements = document.getElementsByName(id+"_list");
				for(var i=0;i<Elements.length;i++) {
					Elements[i].style.display = "";
				}
				
				var newstartNumber = 1;
				document.getElementById("startNumber_"+id).innerHTML = newstartNumber;

				var newshowNumber = Elements.length;
				document.getElementById("showNumber_"+id).innerHTML = newshowNumber;
				
				document.getElementById("showAll_"+id).innerHTML = "'.$GLOBALS['l_logging']['defaultView'].'";
				document.getElementById("showAll_"+id).onclick = function(){
					showDefault(id);
				};
				document.getElementById("back_"+id).style.display = "none";
				document.getElementById("next_"+id).style.display = "none";
			
			}
			
			function showDefault(id) {
				var Elements = document.getElementsByName(id+"_list");
				for(var i=0;i<Elements.length;i++) {
					if(i>='.$this->versionPerPage.') {
						Elements[i].style.display = "none";
					}
					else {
						Elements[i].style.display = "";
					}				
				}
				
				var newstartNumber = 1;
				document.getElementById("startNumber_"+id).innerHTML = newstartNumber;

				var newshowNumber = '.$this->versionPerPage.';
				document.getElementById("showNumber_"+id).innerHTML = newshowNumber;
				
				document.getElementById("back_"+id).style.display = "none";
				document.getElementById("next_"+id).style.display = "inline";
				
				document.getElementById("showAll_"+id).innerHTML = "'.$GLOBALS['l_logging']['all'].'";
				document.getElementById("showAll_"+id).onclick = function(){
					showAll(id);
				};
				
				document.getElementsByName("start_"+id)[0].value = 0;

			}
			
			function next(id) {
				var start = document.getElementsByName("start_"+id)[0].value;
				var newStart = parseInt(start) + '.$this->versionPerPage.';

				var Elements = document.getElementsByName(id+"_list");
				for(var i=0;i<Elements.length;i++) {
					if(i>=newStart && i<(newStart + '.$this->versionPerPage.')) {
						Elements[i].style.display = "";
					}
					else {
						Elements[i].style.display = "none";
					}
					
				}
				
				if(newStart>(Elements.length-'.$this->versionPerPage.')) {
					document.getElementById("next_"+id).style.display = "none";
				}
				else {
					document.getElementById("next_"+id).style.display = "inline";
				}
				document.getElementById("back_"+id).style.display = "inline";
				
				var newstartNumber = newStart+1;
				document.getElementById("startNumber_"+id).innerHTML = newstartNumber;
				
				var newshowNumber = Elements.length;
				if(Elements.length>(newStart+'.$this->versionPerPage.')) {
					newshowNumber = (newStart+'.$this->versionPerPage.');
				}
				
				document.getElementById("showNumber_"+id).innerHTML = newshowNumber;
				
				document.getElementsByName("start_"+id)[0].value = parseInt(newStart);
				
				
			}
			
			function back(id) {
				var start = document.getElementsByName("start_"+id)[0].value;
				var newStart = parseInt(start) - '.$this->versionPerPage.';

				var Elements = document.getElementsByName(id+"_list");
				for(var i=0;i<Elements.length;i++) {
					if(i>=newStart && i<(newStart + '.$this->versionPerPage.')) {
						Elements[i].style.display = "";
					}
					else {
						Elements[i].style.display = "none";
					}
					
				}
				
				
				if(newStart==0) {
					document.getElementById("back_"+id).style.display = "none";
				}
				else {
					document.getElementById("back_"+id).style.display = "inline";
				}
				document.getElementById("next_"+id).style.display = "inline";
				
				var newstartNumber = newStart+1;
				document.getElementById("startNumber_"+id).innerHTML = newstartNumber;
				
				
				newshowNumber = (newstartNumber+'.$this->versionPerPage.');
				document.getElementById("showNumber_"+id).innerHTML = newshowNumber;
				
				document.getElementsByName("start_"+id)[0].value = parseInt(newStart);
				
			}
		
		
		');
		
		return $js;
		
	}
	
	function getContent() {
		
		$content = $this->Model->load();
		
		return $content;
	}
	
	function printContent($content) {
		
		$out = "";

		$out .= '<table width="570" border="0" cellpadding="3" cellspacing="0" class="middlefont">';
//		$out .= '<thead>';
//		$out .= '<tr>';
//		$out .= '<th style="width:150px;">';
//		$out .= $GLOBALS['l_logging']['date'];
//		$out .= '</th>';
//		$out .= '<th style="width:100px;">';
//		$out .= $GLOBALS['l_logging']['user'];
//		$out .= '</th>';
//		$out .= '<th style="width:350px;">';
//		$out .= $GLOBALS['l_logging']['logEntry'];
//		$out .= '</th>';
//		$out .= '</tr>';
//		$out .= '</thead>';
		$anz = count($content);

		for($i=0;$i<$anz;$i++) {
			$out .= '<tr>';
			$out .= '<td style="font-weight:bold;width:100px;">';
			$out .= $GLOBALS['l_logging']['date'].":";
			$out .= '</td>';
			$out .= '<td>';
			$out .= date("d.m.y - H:i:s",$content[$i]['timestamp']);
			$out .= '</td>';
			$out .= '</tr>';
			$out .= '<tr>';
			$out .= '<td style="font-weight:bold;">';
			$out .= $GLOBALS['l_logging']['user'].":";
			$out .= '</td>';
			$out .= '<td>';
			$out .= f("SELECT Text FROM `".USER_TABLE."` WHERE ID='".$content[$i]['userID']."'","Text", new DB_WE());
			$out .= '</td>';
			$out .= '</tr>';
			$out .= '<tr>';
			$out .= '<td style="font-weight:bold;">';
			$out .= $GLOBALS['l_logging']['logEntry'].":";
			$out .= '</td>';
			$out .= '<td>';
			$showLog = $this->showLog($content[$i]['action'],$content[$i]['ID']);
			$out .= $showLog;
			$out .= '</td>';
			$out .= '</tr>';
			$out .= '<tr>';
			$out .= '<td colspan="2">';
			$out .= '<div id="dataContent_'.$content[$i]['ID'].'" name="dataContent">';
			$out .= $this->handleData($content[$i]['ID'],0,$this->versionPerPage);
			$out .= '</div>';
			$out .= '<div style="border-top:1px solid #000;margin-top:20px;margin-bottom:20px;">';
			$out .= getPixel(1,1);
			$out .= '</div>';
			$out .= '<td>';
			$out .= '</tr>';
			
		}
		
		$out .= '</table>';
		
		
		return $out;
		
	}
	
	function showLog($action,$logID) {
		

		$out = "";
		
		switch($action) {
			
			case WE_LOGGING_VERSIONS_DELETE:
				
				$title = $GLOBALS['l_logging']['versions']." ".$GLOBALS['l_logging']['deleted'];
				
			break;
			
			case WE_LOGGING_VERSIONS_RESET:
				
				$title = $GLOBALS['l_logging']['versions']." ".$GLOBALS['l_logging']['reset'];
				
			break;
			
			case WE_LOGGING_VERSIONS_PREFS:
				
				$title = $GLOBALS['l_logging']['prefsVersionChanged'];
				
			break;
			
		}
		
		$out .= $title.".";		
				
		return $out;
		
	}
	
	function handleData($logId, $start, $anzahl) {
		
		$db = new DB_WE();
				
		$db->query("SELECT data,action FROM `".VERSIONS_TABLE_LOG."` WHERE ID='".$logId."'");
		while($db->next_record()){
			$data = $db->f("data");
			$action = $db->f("action");
		}
		
		$data = unserialize($data);
		
		$out = "";

		if($action==WE_LOGGING_VERSIONS_DELETE || $action==WE_LOGGING_VERSIONS_RESET) {
								
			$out .= '<table cellpadding="3" cellspacing="0" border="0" style="border:1px solid #BBBAB9;" width="570" class="middlefont">';
			$out .= '<thead>';
			$out .= '<tr style="background-color:#dddddd;font-weight:bold;">';
			$out .= '<td>';
			$out .= getPixel(1,1);
			$out .= '</td>';
			$out .= '<td>';
			$out .= $GLOBALS['l_logging']['ID']."";
			$out .= '</td>';
			$out .= '<td style="width:100px;">';
			$out .= $GLOBALS['l_logging']['name']."";
			$out .= '</td>';
			$out .= '<td style="width:230px;">';
			$out .= $GLOBALS['l_logging']['path'];
			$out .= '</td>';
			$out .= '<td style="width:50px;">';
			$out .= $GLOBALS['l_logging']['version'];
			$out .= '</td>';
			$out .= '<td style="width:100px;">';
			$out .= $GLOBALS['l_logging']['contenttype'];
			$out .= '</td>';
			$out .= '</tr>';
			$out .= '</thead>';
			
			$anzGesamt = count($data);

			$orderedArray = array();		
			foreach($data as $k=>$v) {
				$orderedArray[] = $v;
			}

			$showNumber = 0;
			//for($i=$start;$i<$anzahl;$i++) {
			foreach($orderedArray as $k=>$v) {
	
				$display = "none";
				$m = $k+1;
				$name = $logId.'_list';
				if($k>=$start && $k<$anzahl) {
					$display = "";
					$showNumber++;
				}
				$out .= '<tr id="'.$name.'" name="'.$name.'" style="display:'.$display.';">';
				$out .= '<td align="right">';
				$out .= $m.".";
				$out .= '</td>';
				$out .= '<td align="left">';
				$out .= $v['documentID'];
				$out .= '</td>';
				$out .= '<td align="left">';
				$out .= shortenPath($v['Text'], 18);
				$out .= '</td>';
				$out .= '<td align="left">';
				$out .= shortenPath($v['Path'],40);
				$out .= '</td>';
				$out .= '<td align="left">';
				$out .= $v['Version'];
				$out .= '</td>';
				$out .= '<td align="left">';
				$out .= $v['ContentType'];
				$out .= '</td>';
				$out .= '</tr>';

			}
			$out .= '<tr style="background-color:#dddddd;">';
			$out .= '<td style="border-top:1px solid #BBBAB9;padding:3px 5px 3px 3px;" align="right" colspan="6">';
			$out .= '<span id="startNumber_'.$logId.'">'.($start+1).'</span> - <span id="showNumber_'.$logId.'">'.$showNumber.'</span> <span>'.$GLOBALS['l_logging']['of'].'</span> <span style="margin-right:20px;">'.$anzGesamt.'</span>';
			$out .= ($anzGesamt>$this->versionPerPage) ? '<span style="margin-right:20px;"><a id="showAll_'.$logId.'" href="#" onclick="showAll('.$logId.');">'.$GLOBALS['l_logging']['all'].'</a></span>' : "";
			$out .= '<span style="margin-right:5px;"><a title="'.$GLOBALS['l_logging']['back'].'" href="#" onclick="back('.$logId.');"><img src=\'' . IMAGE_DIR . 'navigation/button_arrow_left.gif\' id="back_'.$logId.'" style="display:none;border:2px solid #DDD;"  /></a></span>';
			$out .= ($anzGesamt>$this->versionPerPage) ? '<span style="margin-right:5px;"><a title="'.$GLOBALS['l_logging']['next'].'" href="#" onclick="next('.$logId.');"><img src=\'' . IMAGE_DIR . 'navigation/button_arrow_right.gif\' id="next_'.$logId.'" style="border:2px solid #DDD;" /></a></span>' : "";
			$out .= hidden("start_".$logId ,$start);
			$out .= '</td>';
			$out .= '</tr>';
				
			$out .= '</table>';
			
		}
		elseif($action==WE_LOGGING_VERSIONS_PREFS) {
			
			$secondsDay = 86400;
			$secondsWeek = 604800;	
			$secondsYear = 31449600;

			foreach($data as $k=>$v) {
				
				switch($k) {
					case "version_image/*":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['image/*'].": ".$val;
					break;
					case "version_text/html":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/html'].": ".$val;
					break;
					case "version_text/webedition":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/webedition'].": ".$val;
					break;
					case "version_text/js":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/js'].": ".$val;
					break;
					case "version_text/css":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/css'].": ".$val;
					break;
					case "version_text/plain":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/plain'].": ".$val;
					break;
					case "version_application/x-shockwave-flash":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['application/x-shockwave-flash'].": ".$val;
					break;
					case "version_video/quicktime":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['video/quicktime'].": ".$val;
					break;
					case "version_application/*":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['application/*'].": ".$val;
					break;
					case "version_text/xml":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['text/xml'].": ".$val;
					break;
					case "version_objectFile":
						$val = (isset($v) && $v) ? $GLOBALS['l_logging']['activated'] : $GLOBALS['l_logging']['deactivated'] ;
						$out .= "-> ".$GLOBALS['l_logging']['contenttype']." ".$GLOBALS['l_contentTypes']['objectFile'].": ".$val;
					break;
					case "versions_time_days":
						$val = (isset($v) && $v!="" && $v!=-1) ? ($v/$secondsDay) : "" ;
						$out .= "-> ".$GLOBALS['l_logging']['zeitraum']." ".$GLOBALS['l_logging']['days'].": ".$val;
					break;
					case "versions_time_weeks":
						$val = (isset($v) && $v!="" && $v!=-1) ? ($v/$secondsWeek) : "" ;
						$out .= "-> ".$GLOBALS['l_logging']['zeitraum']." ".$GLOBALS['l_logging']['weeks'].": ".$val;
					break;
					case "versions_time_years":
						$val = (isset($v) && $v!="" && $v!=-1) ? ($v/$secondsYear) : "" ;
						$out .= "-> ".$GLOBALS['l_logging']['zeitraum']." ".$GLOBALS['l_logging']['years'].": ".$val;
					break;
					case "versions_anzahl":
						$val = (isset($v) && $v!="") ? $v : "" ;
						$out .= "-> ".$GLOBALS['l_logging']['anzahlVersions'].": ".$val;
					break;
				}
				$out .= "<br/>";
			}
			
			
			$out .= "<br/>";	

			
		}
				
		return $out;
		
	}
	
	function __destruct() {
		

	}

	
}
	
?>