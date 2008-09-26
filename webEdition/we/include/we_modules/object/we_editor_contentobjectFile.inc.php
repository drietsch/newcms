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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browser_check.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/SEEM/we_SEEM.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/js_gui/weOrderContainer.class.php");

if(isset($GLOBALS['we_doc']->Charset)){	//	send charset which might be determined in template
	header("Content-Type: text/html; charset=" . $GLOBALS['we_doc']->Charset);
}

$_editMode = (isset($_previewMode) && $_previewMode == 1 ? 0 : 1);

$parts = $GLOBALS["we_doc"]->getFieldsHTML($_editMode);


foreach($GLOBALS["we_doc"]->DefArray as $n=>$v) {
	if(is_array($v)){
		if(isset($v["required"]) && $v["required"] && $_editMode) {
			array_push($parts,
						array(
							"headline"=>"",
							"html"=>'*'.$GLOBALS["l_global"]["required_fields"],
							"space"=>0,
							"name"=>uniqid(""),
						)
					);
			break;
		}

	}
}


htmlTop();
if($GLOBALS['we_doc']->CSS){
	$cssArr = makeArrayFromCSV($GLOBALS['we_doc']->CSS);
	foreach($cssArr as $cs){
		print '<link href="'.id_to_path($cs).'" rel="styleSheet" type="text/css">'."\n";

	}
}

$we_doc = $GLOBALS['we_doc'];

$jsGUI = new weOrderContainer("_EditorFrame.getContentEditor()", "objectEntry");
echo $jsGUI->getJS(WEBEDITION_DIR."js");

echo we_multiIconBox::getJs();
?>

<script type="text/javascript">
<!--
function toggleObject(id) {
	var elem = document.getElementById(id);
	if(elem.style.display == "none") {
		elem.style.display = "block";
	} else {
		elem.style.display = "none";
	}
}
//-->
</script>

<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php print STYLESHEET; ?>
</head>

<body class="weEditorBody" onUnload="doUnload()">
	<form name="we_form" method="post"><?php $GLOBALS["we_doc"]->pHiddenTrans(); ?>

<?php
if($_editMode){

	echo we_multiIconBox::_getBoxStart("100%", $GLOBALS["l_we_class"]["edit"], uniqid(""),30);

	echo $jsGUI->getContainer();

	echo we_multiIconBox::_getBoxEnd("100%");

	foreach($parts as $idx => $part) {
		$uniqid = uniqid("");

		$content =		'<div id="'.$part['name'].'">'
					.	'<a name="f'.$part['name'].'"></a>'
					.	'<table cellpadding="0" cellspacing="0" border="0" width="100%">'
					.	'<tr>'
					.	'<td class="defaultfont" width="100%">'
					.	'<table style="margin-left:30px;" cellpadding="0" cellspacing="0" border="0">'
					.	'<tr>'
					.	'<td class="defaultfont">'.$part["html"].'</td>'
					.	'</tr>'
					.	'</table>'
					.	'</td>'
					.	'</tr>'
					.	'<tr>'
					.	'<td><div style="border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;"></div></td>'
					.	'</tr>'
					.	'</table>'
					.	'</div>'
					.	'<script type="text/javascript">'
					.	'objectEntry.add(document, \''.$part['name'].'\', null);'
					.	'</script>';

		echo $content;

	}

} else {
	if($_SESSION["we_mode"] == "normal"){
		$_msg = "";
	}
	print we_SEEM::parseDocument(we_multiIconBox::getHTML("","100%",$parts, 30, "", -1, "", "", false));
}


?>
	</form>
</body><script language="JavaScript" type="text/javascript">setTimeout("doScrollTo();",100);</script>

</html>