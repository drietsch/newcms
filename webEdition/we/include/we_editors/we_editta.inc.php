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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

protect();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/object.inc.php");


$nr = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "";
$name = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : "";
$we_transaction = isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : "";

$we_dt = isset($_SESSION["we_data"][$we_transaction]) ? $_SESSION["we_data"][$we_transaction] : "";
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

if(isset($_REQUEST["ok"])){
	$we_doc->elements[$name."inlineedit"]["dat"] = isset($_REQUEST["inlineedit"]) ? $_REQUEST["inlineedit"] : "";
	$we_doc->elements[$name."forbidphp"]["dat"] = isset($_REQUEST["forbidphp"]) ? $_REQUEST["forbidphp"] : "";
	$we_doc->elements[$name."forbidhtml"]["dat"] = isset($_REQUEST["forbidhtml"]) ? $_REQUEST["forbidhtml"] : false;
	$we_doc->elements[$name."removefirstparagraph"]["dat"] = isset($_REQUEST["removefirstparagraph"]) ? $_REQUEST["removefirstparagraph"] : "";
	$we_doc->elements[$name."xml"]["dat"] = isset($_REQUEST["xml"]) ? $_REQUEST["xml"] : "";
	$we_doc->elements[$name."dhtmledit"]["dat"] = isset($_REQUEST["dhtmledit"]) ? $_REQUEST["dhtmledit"] : "";
	$we_doc->elements[$name."showmenus"]["dat"] = isset($_REQUEST["showmenus"]) ? $_REQUEST["showmenus"] : "";
	$we_doc->elements[$name."commands"]["dat"] = isset($_REQUEST["commands"]) ? $_REQUEST["commands"] : "";
	$we_doc->elements[$name."height"]["dat"] = isset($_REQUEST["height"]) ? $_REQUEST["height"] : 50;
	$we_doc->elements[$name."width"]["dat"] = isset($_REQUEST["width"]) ? $_REQUEST["width"] : 200;
	$we_doc->elements[$name."cssClasses"]["dat"] = isset($_REQUEST["cssClasses"]) ? $_REQUEST["cssClasses"] : "";
	$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
}

if(isset($_REQUEST["ok"])){
	$js =		'<script language="JavaScript" type="text/javascript">'
			.	'opener._EditorFrame.setEditorIsHot(true);'
			.	'opener.we_cmd("reload_entry_at_class","'.$we_transaction.'", "'.$nr.'");'
			.	'top.close();'
			.	'</script>';
}else{
	$js = 		'<script language="JavaScript" type="text/javascript">'
			.	'function okFn(){'
			.	'document.forms[0].submit();'
			.	'}'
			.	'</script>';
}

print "<html>\n".we_htmlElement::htmlHead(WE_DEFAULT_HEAD.$js.STYLESHEET);

$out = '<body onload="top.focus();" class="weDialogBody"><form name="we_form" method="post" action="'.$_SERVER['PHP_SELF'].'"><input type="hidden" name="ok" value="1">';

foreach($_REQUEST["we_cmd"] as $k=>$v){
	$out .= '<input type="hidden" name="we_cmd['.$k.']" value="'.$v.'">';
}

$parts  = array();

// WYSIWYG && FORBIDHTML && FORBIDPHP
$vals = array('off' => 'false', 'on' => 'true');
$selected = (isset ($we_doc->elements[$name."dhtmledit"]) && isset ($we_doc->elements[$name."dhtmledit"]["dat"]) && $we_doc->elements[$name."dhtmledit"]["dat"]=="on") ? 'on' : 'off';
$wysiwyg = htmlSelect("dhtmledit",$vals,1,$selected,false,'class="defaultfont"','value',60);

$vals = array('off' => 'false', 'on' => 'true');
$selected =  (isset ($we_doc->elements[$name."forbidhtml"]) && isset ($we_doc->elements[$name."forbidhtml"]["dat"]) && $we_doc->elements[$name."forbidhtml"]["dat"]=="on") ? 'on' : 'off';
$forbidhtml = htmlSelect("forbidhtml",$vals,1,$selected,false,'class="defaultfont"','value',60);

$vals = array('off' => 'false', 'on' => 'true');
$selected = ( (!isset ($we_doc->elements[$name."forbidphp"]["dat"])) || $we_doc->elements[$name."forbidphp"]["dat"]=="on" ? 'on' : 'off');
$forbidphp = htmlSelect("forbidphp",$vals,1,$selected,false,'class="defaultfont"','value',60);

$table = 	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" align="right">wysiwyg&nbsp;</td><td>'.$wysiwyg.'</td>'
		.	'	<td class="defaultfont" align="right">forbidphp&nbsp;</td><td>'.$forbidphp.'</td>'
		.	'	<td class="defaultfont" align="right">forbidhtml&nbsp;</td><td>'.$forbidhtml.'</td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(95,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(140,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline"=>"",
						"html"=>$table,
						"space"=>0,
					)
			);

// XML && REMOVEFIRSTPARAGRAPH
$vals = array('off' => 'false', 'on' => 'true');
$selected = ( (!isset ($we_doc->elements[$name."xml"]["dat"])) || $we_doc->elements[$name."xml"]["dat"]=="on" ? 'on' : 'off');
$xml = htmlSelect("xml",$vals,1,$selected,false,'class="defaultfont"','value',60);

$vals = array('off' => 'false', 'on' => 'true');
$selected = ( (!isset ($we_doc->elements[$name."removefirstparagraph"]["dat"])) || $we_doc->elements[$name."removefirstparagraph"]["dat"]=="on" ? 'on' : 'off');
$removefirstparagraph = htmlSelect("removefirstparagraph",$vals,1,$selected,false,'class="defaultfont"','value',60);

$table =	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" align="right">xml&nbsp;</td><td>'.$xml.'</td>'
		.	'	<td class="defaultfont" align="right"></td><td></td>'
		.	'	<td class="defaultfont" align="right">removefirstparagraph&nbsp;</td><td>'.$removefirstparagraph.'</td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(95,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(140,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline"=>"",
						"html"=>$table,
						"space"=>0,
					)
			);


// INLINEEDIT && SHOWMENUS
$vals = array('off' => 'false', 'on' => 'true');
$selected = ( (!isset ($we_doc->elements[$name."inlineedit"]["dat"])) || $we_doc->elements[$name."inlineedit"]["dat"]=="on" ? 'on' : 'off');
$inlineedit = htmlSelect("inlineedit",$vals,1,$selected,false,'class="defaultfont"','value',60);

$vals = array('off' => 'false', 'on' => 'true');
$selected = ( (!isset ($we_doc->elements[$name."showmenus"]["dat"])) || $we_doc->elements[$name."showmenus"]["dat"]=="on" ? 'on' : 'off');
$showmenus = htmlSelect("showmenus",$vals,1,$selected,false,'class="defaultfont"','value',60);

$table = 	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" align="right">inlineedit&nbsp;</td><td>'.$inlineedit.'</td>'
		.	'	<td class="defaultfont" align="right"></td><td></td>'
		.	'	<td class="defaultfont" align="right">showmenus&nbsp;</td><td>'.$showmenus.'</td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(95,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(140,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline"=>"",
						"html"=>$table,
						"space"=>0,
					)
			);


// WIDTH & HEIGHT
$table = 	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" align="right">width&nbsp;</td><td>'.htmlTextInput('width',24,$we_doc->elements[$name."width"]["dat"],3,'','text',60,0).'</td>'
		.	'	<td class="defaultfont" align="right">height&nbsp;</td><td>'.htmlTextInput('height',24,$we_doc->elements[$name."height"]["dat"],3,'','text',60,0).'</td>'
		.	'	<td class="defaultfont" align="right"></td><td></td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(95,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'	<td>'.getPixel(140,1).'</td>'
		.	'	<td>'.getPixel(60,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline"=>"",
						"html"=>$table,
						"space"=>0,
					)
			);


// CLASSES
$table = 	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" valign="top" align="right">classes&nbsp;</td><td colspan="5">'
		.	we_class::htmlTextArea("cssClasses",3,30,htmlspecialchars((isset($we_doc->elements[$name."cssClasses"]["dat"]) ? $we_doc->elements[$name."cssClasses"]["dat"] : "")),'style="width:415px;height:50px"')
		.	'</td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(415,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline" => "",
						"html" => $table,
						"space" => 0,
					)
			);

// COMMANDS
$vals = makeArrayFromCSV(",,".WE_WYSIWYG_COMMANDS);
sort($vals);
$select = htmlSelect("tmp_commands",$vals,1,"",false,'onchange="var elem=document.getElementById(\'commands\'); var txt = this.options[this.selectedIndex].text; if(elem.value.indexOf(txt)==-1){elem.value=(elem.value) ? (elem.value + \',\' + txt) : txt;}this.selectedIndex=-1"');

$table = 	'<table border="0" cellpadding="0" cellspacing="0">'
		.	'<tr>'
		.	'	<td class="defaultfont" valign="top" align="right">commands&nbsp;</td><td colspan="5">'.$select.'<br>'
		.	we_class::htmlTextArea("commands",3,30,htmlspecialchars((isset($we_doc->elements[$name."commands"]["dat"]) ? $we_doc->elements[$name."commands"]["dat"] : "")),'id="commands" style="width:415px;height:50px"')
		.	'</td>'
		.	'</tr>'
		.	'<tr>'
		.	'	<td>'.getPixel(70,1).'</td>'
		.	'	<td>'.getPixel(415,1).'</td>'
		.	'</tr>'
		.	'</table>';

array_push($parts, array(
						"headline" => "",
						"html" => $table,
						"space" => 0,
					)
			);

$we_button = new we_button();
$cancel_button = $we_button->create_button("cancel","javascript:top.close()");
$okbut = $we_button->create_button("ok","javascript:okFn();");
$buttons = $we_button->position_yes_no_cancel($okbut,null,$cancel_button);
$out .= we_multiIconBox::getHTML("","100%",$parts,30,$buttons,-1,"","","",$l_object["textarea_field"] . ' "' . $we_doc->elements[$name]['dat'] . '" - ' . $l_object["attributes"]);
$out .= '</form></body></html>';

print $out;

?>