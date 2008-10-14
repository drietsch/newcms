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
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_docTypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

protect();
$parts = array();


if(defined('ISP_VERSION') && ISP_VERSION){	//	for isp version we use derived class and overwrite some functions
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_docTypes_isp.inc.php");
	$we_doc = new we_docTypes_isp();
} else {
	$we_doc = new we_docTypes();
}


// Initialize variables
$we_show_response = 0;

switch ($_REQUEST["we_cmd"][0]) {
	case "save_docType":
		if (!we_hasPerm("EDIT_DOCTYPE")) {
			$we_responseText = $l_we_class["no_perms"];
			$we_response_type = WE_MESSAGE_ERROR;
			break;
		}
		$we_doc->we_initSessDat($_SESSION["we_data"][$we_transaction]);
		if (ereg("'",$we_doc->DocType) || ereg(",",$we_doc->DocType) || ereg("\"",$we_doc->DocType)) {
			$we_responseText = $l_alert["doctype_hochkomma"];
			$we_response_type = WE_MESSAGE_ERROR;
			$we_JavaScript = "";
			$we_show_response = 1;
		} else if (strlen($we_doc->DocType)==0) {
			$we_responseText = $l_alert["doctype_empty"];
			$we_response_type = WE_MESSAGE_ERROR;
			$we_JavaScript = "";
			$we_show_response = 1;
		} else {
			$DB_WE->query("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='".addslashes($we_doc->DocType)."'");
			if (($DB_WE->next_record())&&($we_doc->ID!=$DB_WE->f("ID"))) {
				$we_responseText = sprintf($l_we_class["doctype_save_nok_exist"],$we_doc->DocType);
				$we_response_type = WE_MESSAGE_ERROR;
				$we_JavaScript = "";
				$we_show_response = 1;
			} else {
				$we_JavaScript = "opener.top.makefocus = self;\n";
				$we_JavaScript .= "opener.top.header.document.location.reload();\n";
				if ($we_doc->we_save()) {
					$we_responseText = sprintf($l_we_class["doctype_save_ok"],$we_doc->DocType);
					$we_response_type = WE_MESSAGE_NOTICE;
					$we_show_response = 1;
				} else {
					print "ERROR";
				}
			}
		}
		break;
	case "newDocType":
		if ($_REQUEST["we_cmd"][1]) {
			$we_doc->DocType=$_REQUEST["we_cmd"][1];
			$we_doc->we_save();
		}
		break;
	case "deleteDocTypeok":
		if (!we_hasPerm("EDIT_DOCTYPE")) {
			$we_responseText = $l_alert["no_perms"];
			$we_response_type = WE_MESSAGE_ERROR;
			break;
		}
		$DB_WE->query("SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID=".abs($_REQUEST["we_cmd"][1]));
		$del=false;
		if ($DB_WE->next_record()) {
			$name=$DB_WE->f("DocType");
			$DB_WE->query("SELECT ID FROM " . FILE_TABLE . " WHERE DocType=".abs($_REQUEST["we_cmd"][1])." OR temp_doc_type=".mysql_real_escape_string($_REQUEST["we_cmd"][1]));
			if (!$DB_WE->next_record()) {
				$DB_WE->query("DELETE FROM " . DOC_TYPES_TABLE . " WHERE ID=".abs($_REQUEST["we_cmd"][1]));
				$we_responseText = $l_we_class["doctype_delete_ok"];
				$we_response_type = WE_MESSAGE_NOTICE;
				$we_responseText = sprintf($we_responseText,$name);
				unset($_REQUEST["we_cmd"][1]);
				$del=true;
			} else {
				$we_responseText = $l_we_class["doctype_delete_nok"];
				$we_response_type = WE_MESSAGE_ERROR;
				$we_responseText = sprintf($we_responseText,$name);
			}
			if ($del) {
				$DB_WE->query("SELECT ID FROM " . DOC_TYPES_TABLE . " ORDER BY DocType");
				if($DB_WE->next_record())
					$we_doc->initByID($DB_WE->f("ID"),DOC_TYPES_TABLE);
			} else {
				$we_doc->initByID($_REQUEST["we_cmd"][1],DOC_TYPES_TABLE);
			}
		}
		break;
	case "add_dt_template":
		$we_doc->we_initSessDat($_SESSION["we_data"][$we_transaction]);
		$foo = makeArrayFromCSV($we_doc->Templates);
		$ids = makeArrayFromCSV($_REQUEST["we_cmd"][1]);
		foreach($ids as $id){
			if (!in_array($id,$foo)) {
				array_push($foo,$id);
			}
		}
		$we_doc->Templates = makeCSVFromArray($foo);
		break;
	case "delete_dt_template":
		$we_doc->we_initSessDat($_SESSION["we_data"][$we_transaction]);
		$foo = makeArrayFromCSV($we_doc->Templates);
		if ($_REQUEST["we_cmd"][1] && (in_array($_REQUEST["we_cmd"][1],$foo))) {
			$pos = getArrayKey($_REQUEST["we_cmd"][1],$foo);
			if ($pos != "" || $pos == "0") {
				array_splice($foo,$pos,1);
			}
		}
		if ($we_doc->TemplateID == $_REQUEST["we_cmd"][1]) {
			if (count($foo)) {
				$we_doc->TemplateID = $foo[0];
			} else {
				$we_doc->TemplateID = 0;
			}
		}
		$we_doc->Templates = makeCSVFromArray($foo);
		break;
	case "dt_add_cat":
		$we_doc->we_initSessDat($_SESSION["we_data"][$we_transaction]);
		if ($_REQUEST["we_cmd"][1])
			$we_doc->addCat($_REQUEST["we_cmd"][1]);
		break;
	case "dt_delete_cat":
		$we_doc->we_initSessDat($_SESSION["we_data"][$we_transaction]);
		if ($_REQUEST["we_cmd"][1]) {
			$we_doc->delCat($_REQUEST["we_cmd"][1]);
		}
		break;
	default:
		if (isset($_REQUEST["we_cmd"][1])) {
			$id = $_REQUEST["we_cmd"][1];
		} else {
			$q=getDoctypeQuery($DB_WE);
			$q = "SELECT ID FROM " . DOC_TYPES_TABLE . " $q";
			$id = f($q,"ID",$DB_WE);
		}
		if ($id) {
			$we_doc->initByID($id,DOC_TYPES_TABLE);
		}
}

htmlTop($l_we_class["doctypes"]);
$yuiSuggest =& weSuggest::getInstance();
echo $yuiSuggest->getYuiCssFiles();
echo $yuiSuggest->getYuiJsFiles();

print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js"));
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
	<?php if($we_show_response): ?>
		<?php print $we_JavaScript ?>;
		<?php if($we_responseText): ?>
			opener.top.toggleBusy(0);
			<?php print we_message_reporting::getShowMessageCall($we_responseText, $we_response_type); ?>

		<?php endif ?>
	<?php endif ?>
	<?php if($_REQUEST["we_cmd"][0] == "deleteDocType"): ?>
		<?php if(!we_hasPerm("EDIT_DOCTYPE")):?>
			<?php print we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR); ?>
		<?php else:?>
			if(confirm("<?php printf($l_we_class["doctype_delete_prompt"],$we_doc->DocType); ?>")) {
				we_cmd("deleteDocTypeok","<?php print $_REQUEST["we_cmd"][1]; ?>");
			}
		<?php endif ?>
	<?php endif ?>
	<?php if($_REQUEST["we_cmd"][0] == "deleteDocTypeok"): ?>
		opener.top.makefocus = self;
		opener.top.header.document.location.reload();
		<?php print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_NOTICE); ?>
	<?php endif ?>

	var countSaveLoop = 0;

	function we_save_docType(doc,url) {
		acStatus = '';
		invalidAcFields = false;
		if(YAHOO && YAHOO.autocoml) {
			 acStatus = YAHOO.autocoml.checkACFields();
		} else {
			we_submitForm(doc,url);
			return;
		}
		acStatusType = typeof acStatus;
		if (countSaveLoop > 10) {
			<?php print we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) ?>;
			countSaveLoop = 0;
		} else if(acStatusType.toLowerCase() == 'object') {
			if(acStatus.running) {
				countSaveLoop++;
				setTimeout('we_save_docType(doc,url)',100);
			} else if(!acStatus.valid) {
				<?php print we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) ?>;
				countSaveLoop=0;
			} else {
				countSaveLoop=0;
				we_submitForm(doc,url);
			}
		} else {
			<?php print we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) ?>;
		}
	}

	function we_cmd() {
		var args = "";
		var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
		switch (arguments[0]) {
			case "openDocselector":
			case "openDirselector":
				new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . ',' . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true,true);
				break;
			case "openCatselector":
				new jsWindow(url,"we_catselector",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . ',' . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true,true);
				break;
			case "add_dt_template":
			case "delete_dt_template":
			case "dt_add_cat":
			case "dt_delete_cat":
			case "save_docType":
				we_save_docType(self.name,url)
				break;
			case "newDocType":
				<?php
					$dtNames = "";
					$DB_WE->query("SELECT DocType FROM " . DOC_TYPES_TABLE);
					while($DB_WE->next_record()) {
						$dtNames .= "'".str_replace("'","\'",$DB_WE->f("DocType")) . "',";
					}
					$dtNames = ereg_replace('(.),$','\1',$dtNames);
					print 'var docTypeNames = new Array('.$dtNames.');';
				?>
				var name = prompt("<?php print $l_we_class["newDocTypeName"]; ?>","");
				if(name != null) {
					if((name.indexOf("<") != -1) || (name.indexOf(">") != -1)) {
						<?php print we_message_reporting::getShowMessageCall($l_alert["name_nok"], WE_MESSAGE_ERROR); ?>
						return;
					}
					if(name.indexOf("'") != -1 || name.indexOf('"') != -1 || name.indexOf(',') != -1) {
						<?php print we_message_reporting::getShowMessageCall($l_alert["doctype_hochkomma"], WE_MESSAGE_ERROR); ?>
					}
					else if(name=="") {
						<?php print we_message_reporting::getShowMessageCall($l_alert["doctype_empty"], WE_MESSAGE_ERROR); ?>
					}
					else if(in_array(docTypeNames,name)) {
						<?php print we_message_reporting::getShowMessageCall($l_alert["doctype_exists"], WE_MESSAGE_ERROR); ?>
					}
					else {
						if (top.opener.top.header) {
							top.opener.top.header.location.reload();
						}
						self.location = "<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=newDocType&we_cmd[1]="+name;
					}
				}
				break;
			case "change_docType":
			case "deleteDocType":
			case "deleteDocTypeok":
				self.location = url;
				break;
			default:
				for(var i = 0; i < arguments.length; i++) {
					args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
				}
				eval('opener.top.we_cmd('+args+')');
		}
	}


	function we_submitForm(target,url) {
		var f = self.document.we_form;
		f.target = target;
		f.action = url;
		f.method = "post";
		f.submit();
	}

	function doUnload() {
		if(jsWindow_count) {
			for(i=0;i<jsWindow_count;i++) {
				eval("jsWindow"+i+"Object.close()");
			}
		}
		opener.top.dc_win_open=false;
	}

	function in_array(haystack, needle) {
		for(var i=0;i<haystack.length;i++) {
			if(haystack[i] == needle)
				return true;
		}
		return false;
	}

	function makeNewEntry(icon,id,pid,txt,offen,ct,tab) {
		opener.top.makeNewEntry(icon,id,pid,txt,offen,ct,tab);
	}

	function updateEntry(id,text,pid,tab) {
		opener.top.updateEntry(id,text,pid,tab);
	}
//-->
</script>
<?php
	print STYLESHEET;

	$we_button = new we_button();
?>
</head>

<body class="weDialogBody" style="overflow:hidden;" onUnload="doUnload()" onload="self.focus();">
	<form name="we_form" method="post" onsubmit="return false">
	<?php $we_doc->pHiddenTrans(); ?>
		<center>
<?php

if($we_doc->ID){

	array_push($parts, array(	"headline"=>$GLOBALS["l_we_class"]["doctypes"],
								"html"=>$GLOBALS["we_doc"]->formDocTypeHeader(),
								"space"=>120
							)
				);

	array_push($parts, array(	"headline"=>$GLOBALS["l_we_class"]["name"],
								"html"=>$GLOBALS["we_doc"]->formName(),
								"space"=>120
							)
				);

	array_push($parts, array(	"headline"=>$GLOBALS["l_global"]["templates"],
								"html"=>$GLOBALS["we_doc"]->formDocTypeTemplates(),
								"space"=>120
							)
				);

	array_push($parts, array(	"headline"=>$GLOBALS["l_we_class"]["defaults"],
								"html"=>$GLOBALS["we_doc"]->formDocTypeDefaults(),
								"space"=>120
							)
				);

}else{
	array_push($parts, array(	"headline"=>"",
								"html"=>$GLOBALS["we_doc"]->formNewDocType(),
								"space"=>0
							)
				);
}

$cancelbut = $we_button->create_button("close", "javascript:self.close();if(top.opener.we_cmd){top.opener.we_cmd('switch_edit_page',0);}");

if($we_doc->ID){
	$buttons = $we_button->position_yes_no_cancel(
							$we_button->create_button("save", "javascript:we_cmd('save_docType', '$we_transaction')"),
							"",
							$cancelbut
							);
}else{
	$buttons = '<div align="right">' . $cancelbut . '</div>';
}

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("","100%",$parts,30, $buttons,-1,"","",false, "", "", 630);
print $yuiSuggest->getYuiCss();
print $yuiSuggest->getYuiJs();
?>
		</center>
	</form>
</body>

</html>

<?php
$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
?>