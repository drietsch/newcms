<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
$supportDebuggingFile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we_sselector_inc.php";
$supportDebugging = false;
if (file_exists($supportDebuggingFile)) {

	include($supportDebuggingFile);
	if(defined('SUPPORT_IP') && defined('SUPPORT_DURATION') && defined('SUPPORT_START')) {
		if (SUPPORT_IP==$_SERVER['REMOTE_ADDR'] && (time()-SUPPORT_DURATION) < SUPPORT_START){
			$supportDebugging = true;
		}
	}
}

htmlTop();
print STYLESHEET . "\n";

function _cutText($text,$l){
	if (strlen($text) > $l) {
		return substr($text,0,$l-8) . '...' . substr($text,strlen($text)-5,5);
	}else{
		return $text;
	}
}

?>
<script language="JavaScript" type="text/javascript"><!--
var clickCount=0;
var wasdblclick=0;
var tout=null;
var mk=null;
var old=0;

function doClick(id,ct,indb){
    if(ct==1){
        if(wasdblclick){
         top.fscmd.selectDir(id);
         if(top.filter != "folder" && top.filter !="filefolder") top.fscmd.selectFile("");
         setTimeout('wasdblclick=0;',400);
        }else{
         if((top.filter == "folder" || top.filter =="filefolder") && (!indb)){
         	top.fscmd.selectFile(id);
         }
        }
        if((old==id)&&(!wasdblclick)){
        	clickEdit(id);
        }
    }
    else{
       top.fscmd.selectFile(id);
        top.dirsel=0;
    }
    old=id;
}

function doSelectFolder(entry,indb){
 	if(top.filter == "folder" || top.filter =="filefolder" || (top.filter =="all_Types" && top.browseServer)) {
    	if(!indb) top.fscmd.selectFile(entry);
    	top.dirsel=1;
 	}
}

function clickEdit(dir){
 	if(top.filter != "folder" && top.filter !="filefolder") {
 		setScrollTo();
    	top.fscmd.drawDir(top.currentDir,"rename_folder",dir);
 	}
}

function clickEditFile(file){
	setScrollTo();
	top.fscmd.drawDir(top.currentDir,"rename_file",file);
}

function doScrollTo(){
	if(parent.scrollToVal){
		window.scrollTo(0,parent.scrollToVal);
		parent.scrollToVal=0;
	}
}

function setScrollTo(){
   parent.scrollToVal=<?php if($GLOBALS["BROWSER"] == "IE"): ?>document.body.scrollTop<?php else: ?>pageYOffset<?php endif ?>;
}

function keypressed(e) {
	if (e.keyCode == 13) { // RETURN KEY => valid for all Browsers
		setTimeout('document.we_form.txt.blur()',30);  
		//document.we_form
	}
}

//-->
</SCRIPT>

</head>
<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" onload="doScrollTo();">
<form name="we_form" target="fscmd" action="we_sselector_cmd.php" method="post" onsubmit="return false;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">

<?php

function getDataType($dat){
	global $l_contentTypes;
	$ct = getContentTypeFromFile($dat);
	if (isset($l_contentTypes[$ct])) {
		return $l_contentTypes[$ct];
	}
	return "";
}

 $arDir=array();
 $arFile=array();
 $ordDir=array();
 $ordFile=array();
 $final=array();

 if($_REQUEST["dir"]==""){
    $org="/";
} else {
    $org=$_REQUEST["dir"];
}

 $dir=$_SERVER["DOCUMENT_ROOT"].$_REQUEST["dir"];
 if($dir != "/") $dir = ereg_replace("(.)/$",'\1',$dir);
 if(!isset($_REQUEST["ord"]))
    $_REQUEST["ord"]=10;
 @chdir($dir);
 $dir_obj=@dir($dir);

 if($dir_obj){
		while (false !== ($entry = $dir_obj->read())) {
			if($entry != '.' && $entry != '..'){
				if(is_dir($dir."/".$entry)){
					array_push($arDir,$entry);
					switch($_REQUEST["ord"]){
						case 10:
						case 11:array_push($ordDir,$entry);break;
						case 20:
						case 21:array_push($ordDir,getDataType($dir."/".$entry));break;
						case 30:
						case 31:array_push($ordDir,filectime($dir."/".$entry));break;
						case 40:
						case 41:array_push($ordDir,filesize($dir."/".$entry));break;
					}
				}
				else{
					array_push($arFile,$entry);
					switch($_REQUEST["ord"]){
						case 10:
						case 11:array_push($ordFile,$entry);break;
						case 20:
						case 21:array_push($ordFile,getDataType($dir."/".$entry));break;
						case 30:
						case 31:array_push($ordFile,filectime($dir."/".$entry));break;
						case 40:
						case 41:array_push($ordFile,filesize($dir."/".$entry));break;
					}
				}
			}
		}
		$dir_obj->close();
 }
 else{
	print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script><br><br><div class="middlefontgray" align="center">-- '.$l_alert["access_denied"].' --</div>';
 }

 switch($_REQUEST["ord"]){
   case 10:
   case 20:
   case 30:
   case 40:asort($ordDir);asort($ordFile);break;
   case 11:
   case 21:
   case 31:
   case 41:arsort($ordDir);arsort($ordFile);break;
 }



foreach ($ordDir as $key => $value) {
	array_push($final,$arDir[$key]);
}
foreach ($ordFile as $key => $value) {
	array_push($final,$arFile[$key]);
}

print '<script language="JavaScript">
top.allentries = new Array();
var i = 0;
';
foreach ($final as $key => $entry) {
	print 'top.allentries[i++] = "'.$entry.'"'."\n";
}
print '</script>
';
$set_rename=false;

if( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="new_folder"){ ?>
   <tr style="background-color:#DFE9F5;">
   <td align="center" width="25"><img src="<?php print ICON_DIR?>folder.gif" width="16" height="18" border="0"></td>
   <td class="selector" width="200"><?php print htmlTextInput("txt",20,$l_fileselector["new_folder_name"],"",'id="txt" onblur="setScrollTo();we_form.submit();" onkeypress="keypressed(event)"',"text","100%"); ?></td>
   <td class="selector" width="150"><?php print $l_fileselector["folder"]?></td>
   <td class="selector"><?php print date("d-m-Y H:i:s")?></td>
   <td class="selector"></td>
   </tr>
<?php }

foreach ($final as $key => $entry) {
	$name=ereg_replace("//","/",$org."/".$entry);
	$DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE Path='$name'");

	$isfolder = is_dir($dir."/".$entry) ? true : false;

	$type = $isfolder ? $l_contentTypes["folder"] : getDataType($dir."/".$entry);

	$indb = $DB_WE->next_record() ? true : false;
	if($entry=="webEdition") $indb = true;
	if((ereg('^'.$_SERVER["DOCUMENT_ROOT"].'/?webEdition/',$dir) || ereg('^'.$_SERVER["DOCUMENT_ROOT"].'/?webEdition$',$dir)) && (!ereg('^'.$_SERVER["DOCUMENT_ROOT"].'/?webEdition/we_backup',$dir) || $entry=="download" || $entry=="tmp")) $indb = true;
	if($supportDebugging) $indb = false;
	$show = ($entry!=".") && ($entry!="..") && (($_REQUEST["fil"]==$l_contentTypes["all_Types"])||($type==$l_contentTypes["folder"])||($type==$_REQUEST["fil"] || $_REQUEST["fil"]==""));
	$bgcol = ($_REQUEST["curID"] == ($dir."/".$entry) && (!( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="new_folder"))) ? "#DFE9F5" : "white";
	$onclick = "";
	$ondblclick = "";
	$_cursor = "cursor:default;";
	if(!(( isset($_REQUEST["nf"]) && ($_REQUEST["nf"]=="rename_folder" || $_REQUEST["nf"]=="rename_file"))&&($entry==$_REQUEST["sid"])&&($isfolder))){
		if ($indb && $isfolder) {
			$onclick = ' onClick="tout=setTimeout(\'if(wasdblclick==0){doClick(\\\''.$entry.'\\\',1,'.($indb ?  "1" : "0").');}else{wasdblclick=0;}\',300);return true;"';
			$ondblclick = ' onDblClick="wasdblclick=1;clearTimeout(tout);doClick(\''.$entry.'\',1,'.($indb ?  "1" : "0").');return true;"';
			$_cursor = "cursor:pointer;";
		} else if(!$indb){
			if($isfolder){
				$onclick = ' onClick="if(old==\''.$entry.'\') mk=setTimeout(\'if(!wasdblclick) clickEdit(old);\',500); old=\''.$entry.'\';doSelectFolder(\''.$entry.'\','.($indb ?  "1" : "0").');"';
				$ondblclick = ' onDblClick="wasdblclick=1;clearTimeout(tout);clearTimeout(mk);doClick(\''.$entry.'\',1,0);return true;"';
			}else{
				$onclick = ' onClick="if(old==\''.$entry.'\') mk=setTimeout(\'if(!wasdblclick) clickEditFile(old);\',500); old=\''.$entry.'\';doClick(\''.$entry.'\',0,0);return true;"';
			}
			$_cursor = "cursor:pointer;";
		}
	}

	$icon = $isfolder ? "folder.gif" : "link.gif";
	$filesize = filesize($dir."/".$entry);
	$_size = "";
	if(!$isfolder){
		if($filesize >=  1024 && $filesize   < (1024*1024)){
			$_size = round($filesize /  1024,1)." KB";
		}else if ($filesize >=(1024*1024)){
			$_size = round($filesize /  (1024*1024),1)." MB";
		}else{
			$_size = $filesize . " Byte";
		}
		$_size = '<span'.($indb ? ' style="color:#006699"' : '').' title="'.htmlspecialchars($_size).'">'. $_size . '</span>';
	}
	if(( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="rename_folder")&&($entry==$_REQUEST["sid"])&&($isfolder)&&(!$indb)){
		$_text_to_show = htmlTextInput("txt",20,$entry,"",'onblur="setScrollTo();we_form.submit();" onkeypress="keypressed(event)"',"text","100%");
		$set_rename=true;
		$_type = $l_contentTypes["folder"];
		$_date = date("d-m-Y H:i:s");
	}else if(( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="rename_file")&&($entry==$_REQUEST["sid"])&&(!$indb)){
		$_text_to_show = htmlTextInput("txt",20,$entry,"",'onblur="setScrollTo();we_form.submit();" onkeypress="keypressed(event)"',"text","100%");
		$set_rename=true;
		$_type = '<span'.($indb ? ' style="color:#006699"' : '').' title="'.htmlspecialchars($type).'">'.htmlspecialchars(_cutText($type,17)).'</span>';
		$_date = date("d-m-Y H:i:s");
	}else{
		$_text_to_show = '<span'.($indb ? ' style="color:#006699"' : '').' title="'.htmlspecialchars($entry).'">'.
					((strlen($entry)>24) ? htmlspecialchars(_cutText($entry,24)) : htmlspecialchars($entry)).
					'</span>';
		$_type = '<span'.($indb ? ' style="color:#006699"' : '').' title="'.htmlspecialchars($type).'">'.htmlspecialchars(_cutText($type,17)).'</span>';
		$_date = '<span'.($indb ? ' style="color:#006699"' : '').'>'.date("d-m-Y H:i:s",filectime($dir."/".$entry)).'<span>';
	}

	if($show){
		print '<tr id="'.htmlspecialchars($entry).'"'.$ondblclick.$onclick.' style="background-color:'.$bgcol.';'.$_cursor.($set_rename ? "" : "-moz-user-select: none;").'"'.($set_rename ? '' : 'unselectable="on"').'>
	<td class="selector" align="center" width="25"><img src="'.ICON_DIR.$icon.'" width="16" height="18" border="0"></td>
	<td class="selector" width="200">'.$_text_to_show.'</td>
	<td class="selector" width="150">'.$_type.'</td>
	<td class="selector" width="200">'.$_date.'</td>
	<td class="selector">'.$_size.'</td>
 </tr>
';
?>
   <tr>
     <td width="25"><?php print getPixel(25,1)?></td>
     <td width="200"><?php print getPixel(200,1)?></td>
     <td width="150"><?php print getPixel(150,1)?></td>
     <td width="200"><?php print getPixel(200,1)?></td>
     <td><?php print getPixel(10,1)?></td>
   </tr>
<?php
	}
}

?>

</table>
<?php if(( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="new_folder")||(( isset($_REQUEST["nf"]) && ($_REQUEST["nf"]=="rename_folder" || $_REQUEST["nf"]=="rename_file"))&&($set_rename))):?>
   <input type="hidden" name="cmd" value="<?php print $_REQUEST["nf"];?>">
   <?php if($_REQUEST["nf"]=="rename_folder" || $_REQUEST["nf"]=="rename_file"):?><input type="hidden" name="sid" value="<?php print $_REQUEST["sid"]?>">
   <input type="hidden" name="oldtxt" value=""><?php endif?>
   <input type="hidden" name="pat" value="<?php print isset($_REQUEST["pat"]) ? $_REQUEST["pat"] : "" ?>">
<?php endif?>
</form>

<?php if(( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="new_folder")||(( isset($_REQUEST["nf"]) && ($_REQUEST["nf"]=="rename_folder" || $_REQUEST["nf"]=="rename_file"))&&($set_rename))):?>
    <script language="JavaScript" type="text/javascript">
     document.forms["we_form"].elements["txt"].focus();
     document.forms["we_form"].elements["txt"].select();
     <?php if($_REQUEST["nf"]=="rename_folder" || $_REQUEST["nf"]=="rename_file"):?>
     document.forms["we_form"].elements["oldtxt"].value=document.forms["we_form"].elements["txt"].value;
     <?php endif?>
     document.forms["we_form"].elements["pat"].value=top.currentDir;
    </script>
<?php endif?>
<?php if(( isset($_REQUEST["nf"]) && $_REQUEST["nf"]=="new_folder")||(( isset($_REQUEST["nf"]) && ($_REQUEST["nf"]=="rename_folder" ||  $_REQUEST["nf"]=="rename_file"))&&($set_rename))):?>
<?php endif?>
</body>
</html>