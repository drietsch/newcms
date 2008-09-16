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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
include_once(WE_OBJECT_MODULE_DIR."we_object.inc.php");
include_once(WE_OBJECT_MODULE_DIR."we_objectFile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_webEditionDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_template.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

class we_makenewtemplate extends we_template
{

	function formDirChooser($width="",$rootDirID=0,$table=TEMPLATES_TABLE,$Pathname="ParentPath",$IDName="ParentID",$cmd=""){

		global $l_we_class;

		$we_button = new we_button();
		if(!$table) $table = $this->Table;
		$textname = 'we_'.$this->Name.'_'.$Pathname;
		$idname = 'we_'.$this->Name.'_'.$IDName;
		eval('$path = $this->'.$Pathname.';');
		eval('$myid = $this->'.$IDName.';');
		$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector',document.forms['we_form'].elements['$idname'].value,'$table','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','','".session_id()."')");
		return $this->htmlFormElementTable($this->htmlTextInput($textname,30,$path,"",' readonly',"text",$width,0),
			$l_we_class["dir"],
			"left",
			"defaultfont",
			$this->htmlHidden($idname,0),//$myid
			getPixel(20,4),
			$button);
	}

	function formExtension2(){
		return $this->htmlFormElementTable("<b class='defaultfont'>".$this->Extension."</b>",$GLOBALS["l_we_class"]["extension"]);
	}
}

function getObjectTags($id,$isField=false){
	$tableInfo = we_objectFile::getSortedTableInfo($id,true);
	$content = '		<table cellpadding="2" cellspacing="0" border="1" width="400">
';

	for($i=0;$i<sizeof($tableInfo);$i++){
		if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
			$content .= getTmplTableRow($regs[1],$regs[2],$isField);
		}
	}
	$content .= '		</table>
';
	return $content;
}

function getMultiObjectTags($name){
	if(isset($_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["multiobject_".$name."class"]["dat"])) {
		$id = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["multiobject_".$name."class"]["dat"];
	} else {
		return "";
		$newfields = explode(",", $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["neuefelder"]["dat"]);
		foreach ($newfields as $tempname) {
			if($tempname != "") {
				if($_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$tempname]["dat"] == $name) {
					$temp = $tempname;
					break;
				}
			}
		}
		if(!isset($temp)) {
			return "";
		}
		$id = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$temp."class"]["dat"];
	}

	$tableInfo = we_objectFile::getSortedTableInfo($id,true);
	$content = '		<table cellpadding="2" cellspacing="0" border="1" width="400">
';

	for($i=0;$i<sizeof($tableInfo);$i++){
		if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
			$content .= getTmplTableRow($regs[1],$regs[2],true);
		}
	}
	$content .= '		</table>
';
	return $content;
}

function getTemplTag($type,$name,$isField=false){
	switch($type){
		case "meta":
			return $isField ? '<we:field type="select" name="'.$name.'">' : '<we:var type="select" name="'.$name.'">';
		case "input":
		case "text":
		case "int":
		case "float":
			return $isField ? '<we:field name="'.$name.'">' : '<we:var name="'.$name.'">';
		case "link":
			return $isField ? '<we:field type="link" name="'.$name.'">' : '<we:var type="link" name="'.$name.'">';
		case "href":
			return $isField ? '<we:field type="href" name="'.$name.'">' : '<we:var type="href" name="'.$name.'">';
		case "img":
			return $isField ? '<we:field type="img" name="'.$name.'">' : '<we:var type="img" name="'.$name.'">';
		case "checkbox":
			return $isField ? '<we:field type="checkbox" name="'.$name.'">' : '<we:var type="checkbox" name="'.$name.'">';
		case "date":
			return $isField ? '<we:field type="date" name="'.$name.'">' : '<we:var type="date" name="'.$name.'">';
		case "object":
			if(!in_array($name,$GLOBALS["usedIDs"])){
				return getObjectTags($name,$isField);
			}
		case "multiobject":
			return getMultiObjectTags($name);
	}
	return "";
}


function getTmplTableRow($type,$name,$isField=false){
	if($type == "multiobject") {
		if($isField) {
			$open = '<we:ifFieldNotEmpty match="'.$name.'" type="'.$type.'">';
			$close = "</we:ifFieldNotEmpty>";
		} else {
			$open = '<we:ifVarNotEmpty match="'.$name.'" type="'.$type.'">';
			$close = "</we:ifVarNotEmpty>";
		}
		return '			<tr>
				<td width="100"><b>'.$name.'</b></td>
				<td width="300">
					'.$open.'
					<we:listview type="multiobject" name="'.$name.'">
						<we:repeat>'.getTemplTag($type,$name).'</we:repeat>
					</we:listview>
					<we:else>
						'.$GLOBALS["l_global"]["no_entries"].'
					'.$close.'
				</td>
			</tr>
';
	} else {
		return '			<tr>
				<td width="100"><b>'.(($type != "object") ? $name : "").'</b></td>
				<td width="300">'.getTemplTag($type,$name,$isField).'</td>
			</tr>
';
	}
}

htmlTop($GLOBALS['l_we_class']['generateTemplate']);
echo "<script language='JavaScript' type='text/javascript' src='".WEBEDITION_DIR."js/windows.js'></script>";

print STYLESHEET;

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php");

echo "</head><body class='weDialogBody'><form name='we_form'>";
$tmpl = new we_makenewtemplate();
$tmpl->we_new();

$tmpl->Filename = isset($filename) ? $filename : "";
$tmpl->Extension =  ".tmpl";

$tmpl->setParentID( isset($pid)? $pid : "" );
$tmpl->Path = $tmpl->ParentPath. (isset($filename) ? $filename : "") .".tmpl";

$usedIDs = array();
array_push($usedIDs,$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["ID"]);

$sort = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["we_sort"]["dat"];

$count = (count($sort)) ? $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["Sortgesamt"]["dat"] : 0;

$content= '<html>
	<head>
		<we:title></we:title>
		<we:description></we:description>
		<we:keywords></we:keywords>
	</head>
	<body>
		<table cellpadding="2" cellspacing="0" border="1" width="400">
';

if(!empty($sort)) {
	foreach($sort as $key => $val) {
		$name = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["wholename".$key]["dat"]]["dat"];
		$type = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["wholename".$key]["dat"]."dtype"]["dat"];

		$content .= getTmplTableRow($type,$name);
	}
}

$content .= '		</table>
';
if($_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["ID"]){
	$content .= '
		<p>
		<we:listview type="object" classid="'.$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["ID"].'" rows="10">
			<we:repeat>
		<p><table cellpadding="2" cellspacing="0" border="1" width="400">
';


if(!empty($sort)) {
	foreach($sort as $key => $val) {
		$name = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["wholename".$key]["dat"]]["dat"];
		$type = $_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"][$_SESSION["we_data"][$_REQUEST["we_cmd"][3]][0]["elements"]["wholename".$key]["dat"]."dtype"]["dat"];

	$content .= getTmplTableRow($type,$name,true);
	}
}

$content .= '		</table></p>
			</we:repeat>
			<we:ifFound>
				<p><table border="0" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<we:ifBack>
							<td><we:back>back</we:back></td>
						</we:ifBack>
						<we:ifNext>
							<td align="right"><we:next>next</we:next></td>
						</we:ifNext>
					</tr>
				</table></p>
			<we:else/>
				'.$GLOBALS["l_global"]["no_entries"].'
			</we:ifFound>
		</we:listview>
';
}
$content .= '
	</body>
</html>
';


//  $_SESSION["content"] is only used for generating a default template, it is
//  used only in WE_OBJECT_MODULE_DIR/we_object_createTemplatecmd.php
$_SESSION["content"] = $content;

$we_button = new we_button();

$buttons = $we_button->position_yes_no_cancel(
		$we_button->create_button("save", "javascript:if(document.forms['we_form'].we_".$tmpl->Name."_Filename.value != ''){ document.forms['we_form'].action='".WE_OBJECT_MODULE_PATH."we_object_createTemplatecmd.php';document.forms['we_form'].submit();}else{ " . we_message_reporting::getShowMessageCall($l_alert['input_file_name'], WE_MESSAGE_ERROR) . " }"),
		null,
		$we_button->create_button("cancel", "javascript:self.close();")
											);


echo htmlDialogLayout($tmpl->formPath(),$GLOBALS['l_we_class']['generateTemplate'],$buttons);
echo '<input type="hidden" name="SID" value="'.$tmpl->Name.'">';
echo '<input type="hidden" name="we_cmd[3]" value="'.$_REQUEST["we_cmd"][3].'">';
echo '<input type="hidden" name="we_cmd[2]" value="'.$_REQUEST["we_cmd"][2].'">';
echo "</form>";
echo "</body></html>";

?>