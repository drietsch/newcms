<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/versions.inc.php');
protect();

$_db = new DB_WE();

$ID = $_REQUEST["we_cmd"][1];

$newDoc = weVersions::loadVersion(" WHERE ID='".$ID."' ");

$compareID = "";
if(isset($_REQUEST["we_cmd"][2])) {
	$compareID = $_REQUEST["we_cmd"][2];
	$oldDoc = weVersions::loadVersion(" WHERE ID='".$compareID."' ");
}
else {
	$oldDoc = weVersions::loadVersion(" WHERE version < '".$newDoc['version']."' AND documentTable='".$newDoc['documentTable']."' AND documentID='".$newDoc['documentID']."' ORDER BY version DESC limit 1 ");
}

$isObj = false;
if($newDoc['ContentType']=="objectFile") {
	$isObj = true;
}
else {
	//get path of preview-file
	$binaryPathNew = $newDoc['binaryPath'];
	if($binaryPathNew == "") {
		$binaryPathNew = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE binaryPath!='' AND version<'".$newDoc['version']."' AND documentTable='".$newDoc['documentTable']."' AND documentID='".$newDoc['documentID']."'  ORDER BY version DESC limit 1 ","binaryPath",$_db);
	}
	

	if(!empty($oldDoc)) {
		$binaryPathOld = $oldDoc['binaryPath'];
		if($binaryPathOld == "") {
			$binaryPathOld = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE binaryPath!='' AND version<'".$oldDoc['version']."' AND documentTable='".$oldDoc['documentTable']."' AND documentID='".$oldDoc['documentID']."'  ORDER BY version DESC limit 1 ","binaryPath",$_db);
		}
	}
	
	$prot = getServerProtocol();
	$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://".$_SERVER["HTTP_HOST"] : "";
	
	$filePathNew = $_SERVER["DOCUMENT_ROOT"].$binaryPathNew;
	if(!empty($oldDoc)) {
		$filePathOld = $_SERVER["DOCUMENT_ROOT"].$binaryPathOld;
	}
	$fileNew = $preurl.$binaryPathNew;
	if(!empty($oldDoc)) {
		$fileOld = $preurl.$binaryPathOld;
	}
	
	if(!file_exists($filePathNew) && isset($fileOld)) {
		$fileNew = $fileOld;
	}
}

$we_button = new we_button();

//close button
$_button = $we_button->create_button("close", "javascript:self.close();");

//tabs
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

$we_tabs = new we_tabs();

$we_tabs->addTab(new we_tab("#",$GLOBALS['l_versions']['versionDiffs'],'((activ_tab==1) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('1');", array("id"=>"tab_1")));

if(!$isObj) {
	$we_tabs->addTab(new we_tab("#",$GLOBALS['l_versions']['previewVersionNew'],'((activ_tab==2) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('2');", array("id"=>"tab_2")));
}
if(!empty($oldDoc) && !$isObj) {
	$we_tabs->addTab(new we_tab("#",$GLOBALS['l_versions']['previewVersionOld'],'((activ_tab==3) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('3');", array("id"=>"tab_3")));
}

$js=$we_tabs->getHeader() . we_htmlElement::jsElement('
		function setTab(tab) {
			toggle("tab"+activ_tab);
			toggle("tab"+tab);
			activ_tab=tab;
		}

');

function doNotShowFields($k) {
	
	$notshow = array(
		"ID", 
		"documentElements", 
		"documentScheduler", 
		"documentCustomFilter", 
		"documentTable", 
		"binaryPath",
		"ContentType",
		"modifications",
		"IP", 
		"Browser", 
		"Icon", 
		"CreationDate", 
		"Path", 
		"ClassName", 
		"TableID",
		"ObjectID",
		"IsClassFolder",
		"IsNotEditable",
		"Charset",
		"active"
	);
	
	if (in_array($k, $notshow)) {
		return false;
	}
	
	return true;
	
}

function doNotMarkFields($k) {
	
	$notmark = array(
		"timestamp", 
		"version"
	);
	
	if (in_array($k, $notmark)) {
		return false;
	}
	
	return true;
	
}

$pathLength = 40;

$tabsBody = $we_tabs->getHTML().we_htmlElement::jsElement('
						if(!activ_tab) activ_tab = 1; 
						document.getElementById("tab_"+activ_tab).className="tabActive";
					');

$contentNew = "";
$contentOld = "";
$contentDiff = "";

if(!$isObj) {
	$contentNew = '<iframe name="previewNew" src="'.$fileNew.'" width="100%" height="100%" frameborder="no" border="0"></iframe>';
}
if(!empty($oldDoc) && !$isObj) {
	$contentOld = '<iframe name="previewOld" src="'.$fileOld.'" width="100%" height="100%" frameborder="no" border="0"></iframe>';
}

$_versions_time_days = new we_htmlSelect(array(
	"name" => "versions_time_days",
	"style"=>"",
	"class"=>"weSelect",
	"onChange"=>'previewVersion('.$ID.', this.value);'
	)
);	

$versionOld = "";
if(!empty($oldDoc)) {
	$versionOld = " AND version!='".$oldDoc['version']."'";
}
$versions = array();
$query = "SELECT ID,version, timestamp FROM " . VERSIONS_TABLE . " WHERE documentID='".$newDoc['documentID']."' AND documentTable='".$newDoc['documentTable']."' AND version!='".$newDoc['version']."' ".$versionOld."  ORDER BY version ASC";
$_db->query($query);
while($_db->next_record()){
	$versions[$_db->f("ID")]['version'] = $_db->f("version");
	$versions[$_db->f("ID")]['timestamp'] = date("d.m.y - H:i:s",$_db->f("timestamp"));
}

$_versions_time_days->addOption("",$GLOBALS['l_versions']['pleaseChoose']);				
foreach($versions as $k => $v) {
	$txt = $GLOBALS['l_versions']['version']." ". $v['version']. " ".$GLOBALS['l_versions']['from'] ." ".$v['timestamp'];
	$_versions_time_days->addOption($k,$txt);
}

$contentDiff = '<div style="margin-left:20px;" id="top">'.$GLOBALS['l_versions']['VersionChangeTxt'].'<br/><br/>'.
			$GLOBALS['l_versions']['VersionNumber']." ".$_versions_time_days->getHtmlCode().'
			<div style="margin:20px 0px 0px 0px;" class="defaultfont"><a href="javascript:window.print()">'.$GLOBALS['l_versions']["printPage"].'</a></div>
			</div>
			<div style="margin:0px 0px 0px 20px;" id="topPrint">
					<strong>'.$GLOBALS['l_versions']['versionDiffs'].':</strong><br/>
					<br/><strong>'.$GLOBALS['l_versions']["Text"].':</strong> '.$newDoc["Text"].'
					<br/><strong>'.$GLOBALS['l_versions']["documentID"].':</strong> '.$newDoc["documentID"].'
					<br/><strong>'.$GLOBALS['l_versions']["path"].':</strong> '.$newDoc["Path"].'
			</div>
			<table cellpadding="2" cellspacing="0" border="0" width="100%" style="background-color:#EFEFEF;margin-top:15px;">
			<thead>
			<tr>
			<th width="30%">			
			</th>
	  		<th width="35%" style="border-right:1px solid #000;">'.$GLOBALS['l_versions']['VersionNew'].'</th>';

if(!empty($oldDoc)) {
	 $contentDiff .= '<th width="35%">'.$GLOBALS['l_versions']['VersionOld'].'</th>';
}
$contentDiff .= '</tr></thead>';

foreach($newDoc as $k => $v) {
	if(doNotShowFields($k)) {
		$name = $GLOBALS['l_versions'][$k];
		$oldVersion = true;
		if($k=="ParentID") {
			$newVal = $newDoc['Path'];
		}
		else {
			$newVal = weVersions::showValue($k, $newDoc[$k], $newDoc['documentTable']);
		}

		$mark = "border-bottom:1px solid #B8B8B7; ";
		if(!empty($oldDoc)) {
			if($k=="ParentID") {
				$oldVal = $oldDoc['Path'];
			}
			else {
				$oldVal = weVersions::showValue($k, $oldDoc[$k], $oldDoc['documentTable']);
			}
			if(doNotMarkFields($k)) {
				if($newVal!=$oldVal) {
					$mark .= "background-color:#D1FF5F;";
				}
			}
		}
		else {
			$oldVersion = false;
		}

		$contentDiff .= '<tr>';
		$contentDiff .= '<td class="middlefont" style="'.$mark.'"><strong>'.$name.'</strong></td>';
		$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;">'.$newVal.'</td>';
		if($oldVersion) {
			$contentDiff .= '<td class="middlefont" style="'.$mark.'">'.$oldVal.'</td>';
		}
		$contentDiff .= '</tr>';
	}
}	
	
$contentDiff .= '</table>';
	
	
	//elements
	
		$contentDiff .= '<table cellpadding="2" cellspacing="0" border="0" width="100%" style="background-color:#EFEFEF;margin-top:15px;">
				<thead>
				<tr>
				<th width="100%" align="left" colspan="3" style="padding:5px;background-color:#BCBBBB;">'.$GLOBALS['l_versions']['contentElementsMod'].'</th>';
	
		$contentDiff .= '</tr></thead>';
	
			$newDocElements = unserialize(html_entity_decode(urldecode($newDoc['documentElements']), ENT_QUOTES));
			
			if(isset($oldDoc['documentElements'])) {
				$oldDocElements = unserialize(html_entity_decode(urldecode($oldDoc['documentElements']), ENT_QUOTES));
			}
			if(!empty($newDocElements)) {
				foreach($newDocElements as $k => $v) {
					$name = $k;
					$oldVersion = true;
					
					$newVal = (isset($v['dat']) && $v['dat'] != "") ? $v['dat'] : getPixel(1,1);
				
					
					$mark = "border-bottom:1px solid #B8B8B7; ";
					if(!empty($oldDoc)) {
						
						if(isset($oldDocElements[$k]['dat']) && $oldDocElements[$k]['dat']!="") {
							$oldVal = $oldDocElements[$k]['dat'];
						}
						else {
							$oldVal = getPixel(1,1);
						}
		
						if($newVal!=$oldVal) {
							$mark .= "background-color:#D1FF5F;";
						}
						
					}
					else {
						$oldVersion = false;
					}
		
					$newVal = shortenPathSpace($newVal, $pathLength);
					if($oldVersion) {
						$oldVal = shortenPathSpace($oldVal, $pathLength);
					}
		
					$contentDiff .= '<tr>';
					$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$name.'</strong></td>';
					$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.$newVal.'</td>';
					if($oldVersion) {
						$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.$oldVal.'</td>';
					}
					$contentDiff .= '</tr>';
					
				}	
			}
				
	
		$contentDiff .= '</table>';
	
	
	
	//scheduler
	$contentDiff .= '<table cellpadding="2" cellspacing="0" border="0" width="100%" style="background-color:#EFEFEF;margin-top:15px;">
			<thead>
			<tr>
			<th width="100%" align="left" colspan="3" style="padding:5px;background-color:#BCBBBB;">'.$GLOBALS['l_versions']['schedulerMod'].'</th>';

	$contentDiff .= '</tr></thead>';

		$newDocScheduler = unserialize(html_entity_decode(urldecode($newDoc['documentScheduler']), ENT_QUOTES));
		if(isset($oldDoc['documentScheduler'])) {
			$oldDocScheduler = unserialize(html_entity_decode(urldecode($oldDoc['documentScheduler']), ENT_QUOTES));
		}

		$mark = "border-bottom:1px solid #B8B8B7; ";
		
		if(empty($newDocScheduler) && empty($oldDocScheduler)) {
			$contentDiff .= '';
		}
		elseif(empty($newDocScheduler) && !empty($oldDocScheduler)) {

			foreach($oldDocScheduler as $k => $v) {
				$number = $k;
				$markGreen = $mark."background-color:#D1FF5F;";
				$contentDiff .= '<tr>';
				$contentDiff .= '<td class="middlefont" style="width:30%;'.$markGreen.'"><strong>'.$GLOBALS['l_versions']['scheduleTask'].' '.$number.'</strong></td>';
				$contentDiff .= '<td class="middlefont" style="'.$markGreen.'border-right:1px solid #000;width:35%;">'.getPixel(1,1).'</td>';
				$contentDiff .= '<td class="middlefont" style="'.$markGreen.'width:35%;">'.getPixel(1,1).'</td>';
				$contentDiff .= '</tr>';
			
				foreach($v as $key => $val) {
					
					$name = $GLOBALS['l_versions'][$key];
					$newVal = getPixel(1,1);
					if(!is_array($val)) {
						$oldVal = weVersions::showValue($key,$val,$oldDoc['documentTable']);
					}
					else {
						$oldVal = "";
					}
					
					$contentDiff .= '<tr>';
					$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$name.'</strong></td>';
					$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.$newVal.'</td>';
					$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.$oldVal.'</td>';
					$contentDiff .= '</tr>';
					
				}
				
			}
		}
		else {
			foreach($newDocScheduler as $k => $v) {
				$number = $k;

				$contentDiff .= '<tr>';
				$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$GLOBALS['l_versions']['scheduleTask'].' '.$number.'</strong></td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.getPixel(1,1).'</td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.getPixel(1,1).'</td>';
				$contentDiff .= '</tr>';
			
				foreach($v as $key => $val) {
					
					$name = $GLOBALS['l_versions'][$key];
					
					if(!is_array($val)) {
						$newVal = weVersions::showValue($key,$val,$newDoc['documentTable']);
						if(!empty($oldDocScheduler)) {
							if(!is_array($oldDocScheduler[$k][$key])) {
								$oldVal = weVersions::showValue($key,$oldDocScheduler[$k][$key],$oldDoc['documentTable']);
							}
							else {
								$oldVal = getPixel(1,1);
							}
						}
						else {
							$oldVal = getPixel(1,1);
						}
					}
					else {
						$newVal = getPixel(1,1);
						$oldVal = getPixel(1,1);
					}
					
					$contentDiff .= '<tr>';
					$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$name.'</strong></td>';
					$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.$newVal.'</td>';
					$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.$oldVal.'</td>';
					$contentDiff .= '</tr>';
					
				}
			}
		}
			

	$contentDiff .= '</table>';
	
	
	//customfilter
	$contentDiff .= '<table cellpadding="2" cellspacing="0" border="0" width="100%" style="background-color:#EFEFEF;margin-top:15px;">
			<thead>
			<tr>
			<th width="100%" align="left" colspan="3" style="padding:5px;background-color:#BCBBBB;">'.$GLOBALS['l_versions']['customerMod'].'</th>';

	$contentDiff .= '</tr></thead>';

		$newCustomFilter = unserialize(html_entity_decode(urldecode($newDoc['documentCustomFilter']), ENT_QUOTES));
		if(isset($oldDoc['documentCustomFilter'])) {
			$oldCustomFilter = unserialize(html_entity_decode(urldecode($oldDoc['documentCustomFilter']), ENT_QUOTES));
		}

		$mark = "border-bottom:1px solid #B8B8B7; ";

		if(empty($newCustomFilter) && empty($oldCustomFilter)) {
			$contentDiff .= '';
		}
		elseif(empty($newCustomFilter) && !empty($oldCustomFilter)) {

			foreach($oldCustomFilter as $key => $val) {
				
				$name = $GLOBALS['l_versions'][$key];
				$newVal = getPixel(1,1);
				if(!is_array($val)) {
					$oldVal = weVersions::showValue($key,$val,$oldDoc['documentTable']);
				}
				else {
					$oldVal = "";
				}
				
				$contentDiff .= '<tr>';
				$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$name.'</strong></td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.$newVal.'</td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.$oldVal.'</td>';
				$contentDiff .= '</tr>';
				
			}
				
			
		}
		else {

			foreach($newCustomFilter as $key => $val) {
				
				$name = $GLOBALS['l_versions'][$key];
				
				$mark = "border-bottom:1px solid #B8B8B7; ";

				if(!is_array($val)) {
					$newVal = weVersions::showValue($key,$val,$newDoc['documentTable']);
					if(!empty($oldCustomFilter)) {
						if(!is_array($oldCustomFilter[$key])) {
							$oldVal = weVersions::showValue($key,$oldCustomFilter[$key],$oldDoc['documentTable']);
						}
						else {
							$oldVal = getPixel(1,1);
						}
					}
					else {
						$oldVal = getPixel(1,1);
					}
				}
				else {
					$newVal = getPixel(1,1);
					$oldVal = getPixel(1,1);
				}
				

				if($newVal!=$oldVal) {
					$mark .= "background-color:#D1FF5F;";
				}
				$contentDiff .= '<tr>';
				$contentDiff .= '<td class="middlefont" style="width:30%;'.$mark.'"><strong>'.$name.'</strong></td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'border-right:1px solid #000;width:35%;">'.$newVal.'</td>';
				$contentDiff .= '<td class="middlefont" style="'.$mark.'width:35%;">'.$oldVal.'</td>';
				$contentDiff .= '</tr>';
				
			}
			
		}
			

	$contentDiff .= '</table>';

	if(!$isObj) {
		$_tab_1 = $contentDiff;
		$_tab_2 = $contentNew;
		$_tab_3 = $contentOld;
		$activTab = 1;
	}
	else {
		$_tab_1 = $contentDiff;
		$_tab_2 = "";
		$_tab_3 = "";
		$activTab = 1;
	}
	
	htmlTop();
	
	print STYLESHEET;
	


?>

<script type="text/javascript">

var activ_tab = <?php print $activTab;?>;

function toggle(id){
	var elem = document.getElementById(id);
	if(elem.style.visibility == "hidden") elem.style.visibility = "visible";
	else elem.style.visibility = "hidden";
}

function previewVersion(ID, newID) {
	top.opener.top.we_cmd("versions_preview", ID, newID);
	//new jsWindow("<?php print WEBEDITION_DIR; ?>we/include/we_versions/weVersionsPreview.php?ID="+ID+"&newCompareID="+newID+"", "version_preview",-1,-1,1000,750,true,true,true,true);
				
}

</script>
<script src="<?php print JS_DIR; ?>windows.js" language="JavaScript" type="text/javascript"></script>
<?php print $js;?>
<style type="text/css" media="screen"> 
#tab1 {position:absolute;overflow:auto; }
#topPrint {display: none;}
</style>

<style type="text/css" media="print"> 
#tab1 {position:relative;overflow: visible; }
#tab2 {display: none}
#tab3 {display: none}
#mytabs {display: none}
#top {display: none}
#topPrint {display: block}
</style>
</head>

<body class="weDialogBody">
<div id="mytabs">
<?php print $tabsBody;?>
</div>
	<div id="content" style="margin: 0px; width: 100%;height: 90%;">
		<div id="tab1" style="visibility:visible;top:30px;left:0px;height:90%;width: 100%;">

				<?php print $_tab_1?>

			
		</div>
		<div id="tab2" style="position:absolute;visibility:hidden;top:30px;left:0px;height:90%;overflow:auto;width: 100%;">

				<?php print $_tab_2?>
		
		
		</div>
		<div id="tab3" style="position:absolute;visibility:hidden;top:30px;left:0px;height:90%;overflow:auto;width: 100%;">

				<?php print $_tab_3?>
			
			
		</div>
	</div>
	
	<div style="left:0;height:40px;background-image: url(/webEdition/images/edit/editfooterback.gif);position:absolute;bottom:0;width:100%">
		<div align="right" style="padding: 10px 10px 0 0;"><?php echo $_button; ?></div>
	</div>

	

</body>

</html>

