<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");

protect();

htmlTop();

print STYLESHEET . "\n";

if(isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="save_last") {
	$_SESSION["user"]["LastDir"]=$last;
}
?>
<?php if(!isset($_REQUEST["cmd"]) || (isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]!="save_last")):?>
<script language="JavaScript" type="text/javascript"><!--

	function drawNewFolder() {
		for(var i=0; i<top.allentries.length;i++){
			top.fsbody.document.getElementById(top.allentries[i]).style.backgroundColor = 'white';
		}
		drawDir(top.currentDir,"new_folder");
	}

	function setFilter(filter) {
		top.currentFilter=filter;
		drawDir(top.currentDir);
	}

	function setDir(dir) {
		var a=top.fsheader.document.forms["we_form"].elements["lookin"].options;
		if(a.length-2>-1) {
			for(j=0;j<a.length;j++) {
				if(a[j].value==dir) {
					a.length=j+1;a[j].selected=true;
				}
			}
			<?php if(  isset($_REQUEST["filter"]) && ($_REQUEST["filter"]=="folder" || $_REQUEST["filter"]=="filefolder")): ?>
			selectFile(dir);
			<?php endif; ?>
			top.currentDir=dir;
			selectDir();
		}
		else {
			<?php print we_message_reporting::getShowMessageCall($l_fileselector["already_root"], WE_MESSAGE_ERROR); ?>
		}
	}

	function goUp() {
		var a=top.fsheader.document.forms["we_form"].elements["lookin"].options;
		if(a.length-2>-1)
			setDir(a[a.length-2].value);
		else
			<?php print we_message_reporting::getShowMessageCall($l_fileselector["already_root"], WE_MESSAGE_ERROR); ?>
	}

	function selectFile(fid) {
		if(fid != "/") {
			top.currentID=top.sitepath+top.rootDir+top.currentDir+((top.currentDir != "/") ? "/" : "")+fid;
		top.currentName=fid;
			top.fsfooter.document.forms["we_form"].elements["fname"].value=fid;
			if(top.fsbody.document.getElementById(fid)) {
				for(var i=0; i<top.allentries.length;i++){
					if(top.fsbody.document.getElementById(top.allentries[i])) top.fsbody.document.getElementById(top.allentries[i]).style.backgroundColor = 'white';
				}
				top.fsbody.document.getElementById(fid).style.backgroundColor = '#DFE9F5';
			}
		} else {
			top.currentID=top.sitepath;
			top.currentName=fid;
			top.fsfooter.document.forms["we_form"].elements["fname"].value=fid;
			if(top.fsbody.document.getElementById(fid)) {
				for(var i=0; i<top.allentries.length;i++){
					if(top.fsbody.document.getElementById(top.allentries[i])) top.fsbody.document.getElementById(top.allentries[i]).style.backgroundColor = 'white';
				}
				top.fsbody.document.getElementById(fid).style.backgroundColor = '#DFE9F5';
			}
		}
	}

	function selectDir() {


		if(arguments[0]) {
			<?php if(isset($_REQUEST["filter"]) && $_REQUEST["filter"]=="folder"): ?>
			//selectFile(arguments[0],true);
			<?php endif; ?>
			if(top.currentDir=="/")
				top.currentDir=top.currentDir+arguments[0];
			else
				top.currentDir=top.currentDir+"/"+arguments[0];
			top.fsheader.addOption(arguments[0],top.currentDir);
		}

		if (top.currentDir.substring(0,12) == "/webEdition/" || top.currentDir=="/webEdition") {
			top.fsheader.weButton.disable("btn_new_dir_ss");
			top.fsheader.weButton.disable("btn_add_file_ss");
			top.fsheader.weButton.disable("btn_function_trash_ss");
		} else {
			top.fsheader.weButton.enable("btn_new_dir_ss");
			top.fsheader.weButton.enable("btn_add_file_ss");
			top.fsheader.weButton.enable("btn_function_trash_ss");
		}

		drawDir(top.currentDir);

	}

	function reorderDir(dir,order) {
		setTimeout('top.fsbody.location="we_sselector_body.php?dir='+dir+'&ord='+order+'&fil='+top.currentFilter+'&curID='+escape(top.currentID)+'"',100);
	}

	function drawDir(dir) {
		if((arguments[1]=="new_folder")||(arguments[1]=="rename_folder")||(arguments[1]=="rename_file")) {
			if(arguments[1]=="new_folder") {
				top.fsbody.location="we_sselector_body.php?dir="+escape(top.rootDir+dir)+"&nf=new_folder&fil="+top.currentFilter+"&curID="+escape(top.currentID);
			} else if(arguments[1]=="rename_folder") {
				if(arguments[2]) {
					top.fsbody.location="we_sselector_body.php?dir="+escape(top.rootDir+dir)+"&nf=rename_folder&sid="+escape(arguments[2])+"&fil="+top.currentFilter+"&curID="+escape(top.currentID);
				}
			} else if(arguments[1]=="rename_file") {
				if(arguments[2]) {
					top.fsbody.location="we_sselector_body.php?dir="+escape(top.rootDir+dir)+"&nf=rename_file&sid="+escape(arguments[2])+"&fil="+top.currentFilter+"&curID="+escape(top.currentID);
				}
			}
		} else {

			setTimeout('top.fsbody.location="we_sselector_body.php?dir='+escape(top.rootDir+dir)+'&fil='+top.currentFilter+'&curID='+escape(top.currentID)+'"',100);
		}
	}

	function delFile() {
		if((top.currentID!="")&&(top.fsfooter.document.forms["we_form"].elements["fname"].value!=""))
			top.fscmd.location="we_sselector_cmd.php?cmd=delete_file&fid="+top.currentID+"&ask="+arguments[0];
		else
			<?php print we_message_reporting::getShowMessageCall($l_fileselector["edit_file_nok"], WE_MESSAGE_ERROR); ?>
	}

	<?php

		function delDir($dir) {
			global $l_alert;

			$d = dir($dir);
			while (false !== ($entry=$d->read())) {
				if($entry!="." && $entry!="..") {
					if(is_dir($dir."/".$entry)) {
						delDir($dir."/".$entry);
					}
					else if(is_file($dir."/".$entry)) {
						if (!@unlink($dir."/".$entry))
							print we_message_reporting::getShowMessageCall(sprintf($l_alert["delete_nok_file"],$entry), WE_MESSAGE_ERROR);
					}
					else
						print we_message_reporting::getShowMessageCall(sprintf($l_alert["delete_nok_noexist"],$entry), WE_MESSAGE_ERROR);
				}
			}
			if(!@rmdir($dir)) {
				print we_message_reporting::getShowMessageCall(sprintf($l_alert["delete_nok_folder"],$dir), WE_MESSAGE_ERROR);
			}
		}

		if(isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="new_folder") {
			print "drawDir(top.currentDir);\n";
			if($_REQUEST["txt"]=="") {
				print we_message_reporting::getShowMessageCall($l_alert["we_filename_empty"], WE_MESSAGE_ERROR);
			} else if(eregi('[\'"<>/]',$_REQUEST["txt"])) {
				print we_message_reporting::getShowMessageCall($l_alert["name_nok"], WE_MESSAGE_ERROR);
			} else {
				$path=eregi_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]."/".$_REQUEST["txt"]);
				if(!@is_dir($path)) {
					$oldumask = @umask(0000);

					if (defined("WE_NEW_FOLDER_MOD")){
						eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) .';');
					} else {
						$mod = 0755;
					}

					if(!createLocalFolder($path)) {
						print we_message_reporting::getShowMessageCall($l_alert["create_folder_nok"], WE_MESSAGE_ERROR);
					}else{
						print 'selectFile("'.$_REQUEST["txt"].'");top.currentID="'.$path.'";';
					}
					@umask($oldumask);
				} else {
					$we_responseText = sprintf($l_alert["path_exists"],str_replace($_SERVER['DOCUMENT_ROOT'],'',$path));
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR) . "\n";
				}

			}
		}

		if (isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="rename_folder") {
			if ($_REQUEST["txt"]=="") {
				print we_message_reporting::getShowMessageCall($l_alert["we_filename_empty"], WE_MESSAGE_ERROR);
				print "drawDir(top.currentDir);\n";
			} else if(eregi('[\'"<>/]',$_REQUEST["txt"])) {
				print we_message_reporting::getShowMessageCall($l_alert["name_nok"], WE_MESSAGE_ERROR);
				print "drawDir(top.currentDir);\n";
			} else {
				$old = eregi_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]."/".$_REQUEST["sid"]);
				$new = eregi_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]."/".$_REQUEST["txt"]);
				if ($old!=$new) {
					if (!@is_dir($new)) {
						if (!rename($old,$new)) {
							print we_message_reporting::getShowMessageCall($l_alert["rename_folder_nok"], WE_MESSAGE_ERROR);
						} else {
							print 'selectFile("'.$_REQUEST["txt"].'");'."\n";
						}
					} else {
						$we_responseText = sprintf($l_alert["path_exists"],str_replace($_SERVER['DOCUMENT_ROOT'],'',$new));
						print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
					}
				}
				print "drawDir(top.currentDir);\n";
			}
		} else if(isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="rename_file") {
			if ($_REQUEST["txt"]=="") {
				print we_message_reporting::getShowMessageCall($l_alert["we_filename_empty"], WE_MESSAGE_ERROR);
				print "drawDir(top.currentDir);\n";
			} else if(eregi('[\'"<>/]',$_REQUEST["txt"])) {
				print we_message_reporting::getShowMessageCall($l_alert["name_nok"], WE_MESSAGE_ERROR);
				print "drawDir(top.currentDir);\n";
			} else {
				$old=eregi_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]."/".$_REQUEST["sid"]);
				$new=eregi_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]."/".$_REQUEST["txt"]);
				if($old!=$new) {
					if (!@file_exists($new)) {
						if (!rename($old,$new)) {
							print we_message_reporting::getShowMessageCall($l_alert["rename_file_nok"], WE_MESSAGE_ERROR);
						} else {
							print 'selectFile("'.$_REQUEST["txt"].'");'."\n";
						}
					} else {
						$we_responseText = sprintf($l_alert["path_exists"],str_replace($_SERVER['DOCUMENT_ROOT'],'',$new));
						print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
					}
				}
				print "drawDir(top.currentDir);selectFile(top.currentName);\n";
			}
		} else if(isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="delete_file") {
			if(isset($_REQUEST["fid"])) {
				$foo=0;
				$foo=f("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$_REQUEST["fid"]."';",0,$DB_WE);
				if(ereg($_SERVER["DOCUMENT_ROOT"]."/webEdition/",$_REQUEST["fid"]) || ($_REQUEST["fid"] == $_SERVER["DOCUMENT_ROOT"]."/webEdition") || strpos("..",$_REQUEST["fid"]) || $foo || $_REQUEST["fid"]==$_SERVER["DOCUMENT_ROOT"] || $_REQUEST["fid"]."/"==$_SERVER["DOCUMENT_ROOT"]) {
					print we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR);
				} else {
					if (is_dir($_REQUEST["fid"]) && ($_REQUEST["ask"])) {
						print "if (confirm(\"".$l_alert["delete_folder"]."\")) delFile(0);\n";
					} else if (is_file($_REQUEST["fid"]) && ($_REQUEST["ask"])) {
						print "if (confirm(\"".$l_alert["delete"]."\")) delFile(0);\n";
					} else if (is_dir($_REQUEST["fid"])) {
						delDir($_REQUEST["fid"]);
					} else if (!@unlink($_REQUEST["fid"])) {
						print we_message_reporting::getShowMessageCall(sprintf($l_alert["delete_nok_error"],$_REQUEST["fid"]), WE_MESSAGE_ERROR);
					}
					print "selectFile('');drawDir(top.currentDir);\n";
				}
			}
		}


	?>

//-->
</script>
<?php endif?>
</head>

	<body>
	</body>

</html>