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


//
//	---> Includes
//
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browser_check.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tag.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/SEEM/we_SEEM.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/js_gui/weOrderContainer.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_objectFile.inc.php");

protect();
//
//	---> Initalize the document
//

$cmd	 		= isset($_REQUEST['we_cmd'][0]) ? $_REQUEST['we_cmd'][0] : "";
$we_transaction	= isset($_REQUEST['we_cmd'][1]) ? $_REQUEST['we_cmd'][1] : "";
$identifier		= isset($_REQUEST['we_cmd'][2]) ? $_REQUEST['we_cmd'][2] : false;

$jsGUI = new weOrderContainer("_EditorFrame.getContentEditor()", "objectEntry");

$we_doc = new we_objectFile();

$we_dt = $_SESSION["we_data"][$we_transaction];
$we_doc->we_initSessDat($we_dt);

//
//	---> Setting the Content-Type
//

if(isset($we_doc->elements["Charset"]["dat"])){	//	send charset which might be determined in template
	header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
}


//
//	---> Output the HTML Header
//

htmlTop();


//
//	---> Loading the Stylesheets
//

if($we_doc->CSS){
	$cssArr = makeArrayFromCSV($we_doc->CSS);
	foreach($cssArr as $cs){
		print '<link href="'.id_to_path($cs).'" rel="styleSheet" type="text/css">'."\n";

	}
}
print STYLESHEET;

?>

<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php"); ?>
</head>

<body>

<?php

switch($cmd) {
	case "reload_entry_at_object":
	case 'up_meta_at_object':
	case 'down_meta_at_object':
	case 'insert_meta_at_object':
	case 'delete_meta_at_object':
	case 'change_objectlink':
	case 'remove_image_at_object':
	case 'delete_link_at_object':
	case 'change_link_at_object':
		$temp = explode("_", $identifier);
		$type = array_shift($temp);
		$name = implode("_", $temp);

		$db = new DB_WE();
		$we_button = new we_button();
		$table = OBJECT_FILES_TABLE;

		if($cmd == "insert_meta_at_object") {
			$we_doc->addMetaToObject($name,$_REQUEST["we_cmd"][3]);

		} elseif($cmd == "delete_meta_at_object") {
			$we_doc->removeMetaFromObject($name,$_REQUEST["we_cmd"][3]);

		} elseif($cmd == "down_meta_at_object") {
			$we_doc->downMetaAtObject($name,$_REQUEST["we_cmd"][3]);

		} elseif($cmd == "up_meta_at_object") {
			$we_doc->upMetaAtObject($name,$_REQUEST["we_cmd"][3]);

		} elseif($cmd == "change_objectlink") {
			$we_doc->i_getLinkedObjects();

		} elseif($cmd == "remove_image_at_object") {
			$we_doc->remove_image($name);

		} elseif($cmd == "delete_link_at_object") {
			if(isset($we_doc->elements[$name])) unset($we_doc->elements[$name]);

		} elseif($cmd == "change_link_at_object") {
			$we_doc->changeLink($name);

		}

		$content =		'<div id="'.$identifier.'">'
					.	'<a name="f'.$identifier.'"></a>'
					.	'<table cellpadding="0" cellspacing="0" border="0" width="100%">'
					.	'<tr>'
					.	'<td class="defaultfont" width="100%">'
					.	'<table style="margin-left:30px;" cellpadding="0" cellspacing="0" border="0">'
					.	'<tr>'
					.	'<td class="defaultfont">'
					.	$we_doc->getFieldHTML($name,$type,array())
					.	'</td>'
					.	'</tr>'
					.	'</table>'
					.	'</td>'
					.	'</tr>'
					.	'<tr>'
					.	'<td><div style="border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;"></div></td>'
					.	'</tr>'
					.	'</table>'
					.	'</div>';

		echo $jsGUI->getResponse('reload', $identifier, $content);

		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
		break;

	default:
		break;

}
?>

</body>

</html>