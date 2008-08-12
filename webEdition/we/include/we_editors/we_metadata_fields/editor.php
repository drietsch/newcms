<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_delete_fn.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/weMetaData/classes/Exif.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/weMetaData/classes/IPTC.class.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/metadata.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/


protect();

/*****************************************************************************
 * FUNCTIONS
 *****************************************************************************/

/**
 * This function returns the HTML code of a dialog.
 *
 * @param          string                                  $name
 * @param          string                                  $title
 * @param          array                                   $content
 * @param          int                                     $expand             (optional)
 * @param          string                                  $show_text          (optional)
 * @param          string                                  $hide_text          (optional)
 * @param          bool                                    $cookie             (optional)
 * @param          string                                  $JS                 (optional)
 *
 * @return         string
 */

function create_dialog($name, $title, $content, $expand = -1, $show_text = "", $hide_text = "", $cookie = false, $JS = "") {
	$_output = "";

	// Check, if we need to write some JavaScripts
	if ($JS != "") {
		$_output .= $JS;
	}

	if ($expand != -1) {
		$_output .= we_multiIconBox::getJS();
	}

	// Return HTML code of dialog
	return $_output . we_multiIconBox::getHTML($name, "100%", $content, 30, "", $expand, $show_text, $hide_text, $cookie != false ? ($cookie == "down") : $cookie, $title);
}

/**
 * This functions saves all options.
 *
 * @return         void
 */

function save_all_values() {
	global $DB_WE, $BROWSER, $SYSTEM;

	/*************************************************************************
	 * SAVE METADATA FIELDS TO DB
	 *************************************************************************/
	if (we_hasPerm("ADMINISTRATOR")) {
		// save all fields
		$_definedFields = array();
		if (isset($_REQUEST["metadataTag"]) && is_array($_REQUEST["metadataTag"])) {
			foreach($_REQUEST["metadataTag"] as $key => $value) {
				$_definedFields[] = array(
					"id" => "", // will be genereated by rdbms (autoincrement pk)
					"tag" => $value,
					"type" => (isset($_REQUEST["metadataType"][$key])) ? $_REQUEST["metadataType"][$key] : "",
					"importFrom" => (isset($_REQUEST["metadataImportFrom"][$key])) ? $_REQUEST["metadataImportFrom"][$key] : ""
				);
			}
		}
		$truncateQuery = "truncate table ".METADATA_TABLE.";";
		$_insertQuery = array();
		foreach($_definedFields as $key => $value) {
			$_insertQuery[] = "insert into ".METADATA_TABLE." 	values('','".$value['tag']."','".$value['type']."','".$value['importFrom']."');";
		}

		$DB_WE->query($truncateQuery);
		foreach($_insertQuery as $value) {
			$DB_WE->query($value);
		}
	}

}

function build_dialog($selected_setting = "ui") {
	global $l_alert, $l_metadata, $DB_WE, $BROWSER, $SYSTEM, $MOZ_AX, $MOZ13, $NET6;

	$we_button = new we_button();

	switch ($selected_setting) {
		// save dialog:
		case "save":
			$_settings = array();
			array_push($_settings, array("headline" => "", "html" => $l_metadata["save"], "space" => 0));
			$_dialog = create_dialog("", $l_metadata["save_wait"], $_settings);
			break;

		// SAVED SUCCESSFULLY DIALOG:
		case "saved":
			$_content = array();
			array_push($_content, array("headline" => "", "html" => $l_metadata["saved"], "space" => 0));
			// Build dialog element if user has permission
			$_dialog = create_dialog("", $l_metadata["saved_successfully"], $_content);
			break;

		// THUMBNAILS
		case "dialog":
			global $l_navigation, $DB_WE;
			$_headline = we_htmlElement::htmlDiv(array("class" => "weDialogHeadline", "style" => "padding:10 25 5 25;"),$l_metadata["headline"]);
			$we_button = new we_button();

			// read already defined metadata fields from db:
			$_defined_fields = array();
			$DB_WE->query("SELECT * FROM " . METADATA_TABLE);
			while ($DB_WE->next_record()) {
				$_defined_fields[] = array(
					"id" => $DB_WE->f("id"),
					"tag" => $DB_WE->f("tag"),
					"type" => $DB_WE->f("type"),
					"importFrom" => $DB_WE->f("importFrom")
				);
			}
			//error_log(print_r($_defined_fields,true));

			// identifying all available metadata readers:
//			$_types = array();
//			$_metadata_implementation_dir = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/classes/";
//			$dl = dir($_metadata_implementation_dir);
//			while (false !== ($entry = $dl->read())) {
//				if(is_file($_metadata_implementation_dir.$entry)) {
//					$entry = substr($entry,0,-10);
//					if(substr($entry,0,1) != "." && eregi("^[A-Za-z0-9]+$", $entry))
//					$_types[] = $entry;
//				}
//			}
//			$dl->close();
//			$_metadata_types = array("" => "");
//			foreach($_types as $key => $value) {
//				$_metadata_types[$value] = $value;
//			}
			//array_unshift(,"");
			//error_log(print_r($_metadata_types,true));

			$_metadata_types = array(
				"textfield" => "textfield",
				"textarea" 	=> "textarea",
				//"wysiwyg" 	=> "wysiwyg",
				"date" 		=> "date"
			);

			$_metadata_fields = array('' => '-- '.$l_metadata['add'].' --','Exif'=>'<!--we_optgroup-->');
			$_tmp = weMetaData_Exif::getUsedFields();
			foreach($_tmp as $key) {
				$_metadata_fields[$key] = $key;
			}
			$_tmp = weMetaData_IPTC::getUsedFields();
			$_metadata_fields['IPTC'] = '<!--we_optgroup-->';
			foreach($_tmp as $key) {
				$_metadata_fields[$key] = $key;
			}

			$_onChange="";


			$_i = 0;
			$_adv_row = '';
			$_first = 0;

			$fieldcount = sizeof($_defined_fields);
			foreach($_defined_fields as $key => $value) {
				$_adv_row .= '
				<tr id="metadataRow_'.$key.'">
					<td width="210" style="padding-right:5px;">
						'.htmlTextInput('metadataTag['.$key.']',24,$value['tag'],255,"","text",205).'
					</td>
					<td width="200">
						'.
						htmlSelect('metadataType['.$key.']',$_metadata_types,1,$value['type'],false,'class="defaultfont" ')
						.'
					</td>
					<td align="right" width="30">
						'.
						$we_button->create_button("image:btn_function_trash", "javascript:delRow(".$_i.")")
						.'
					</td>
				</tr>
				<tr id="metadataRow2_'.$key.'">
					<td style="padding-bottom:10px;padding-right:5px;">
						<div class="small">' . htmlspecialchars($l_metadata["import_from"]) . '</div>'.htmlTextInput('metadataImportFrom['.$key.']',24,$value['importFrom'],255,"","text",205).'
					</td>
					<td colspan="2" style="padding-bottom:10px;">
						<div class="small">' . htmlspecialchars($l_metadata["fields"]) . '</div>'.
						htmlSelect('add_'.$key,$_metadata_fields,1,"",false,'class="defaultfont" style="width:100%" onchange="addFieldToInput(this,'.$key.')"')
						.'
					</td>
				</tr>
				';
				$_i++;
			}

			$_metadataTable ='
			<table border="0" cellpadding="0" cellspacing="0" width="440">
				<tbody id="metadataTable">
					<tr>
						<td class="defaultfont" style="width:210px;"><strong>'.$l_metadata["tagname"].'</strong></td>
						<td class="defaultfont" style="width:110px;" colspan="2"><strong>'.$l_metadata["type"].'</strong></td>
					</tr>
					'.$_adv_row.'
				</tbody>
			</table>
			';

			$js = we_htmlElement::jsElement('

				function addRow() {

					var tagInp = "' . addslashes(htmlTextInput('metadataTag[__we_new_id__]',24,"",255,"","text",210)) . '";
					var importInp = "' . addslashes(htmlTextInput('metadataImportFrom[__we_new_id__]',24,"",255,"","text",210)) . '";
					var typeSel = "' . str_replace("\n","\\n",addslashes(htmlSelect('metadataType[__we_new_id__]',$_metadata_types,1,"textfield",false,'class="defaultfont"'))) . '";
					var fieldSel = "' . str_replace("\n","\\n",addslashes(htmlSelect('metadataType[__we_new_id__]',$_metadata_fields,1,"",false,'class="defaultfont" style="width:100%"  onchange="addFieldToInput(this,__we_new_id__)"'))) . '";

					var elem = document.getElementById("metadataTable");
					newID = (elem.rows.length-1) / 2;
					if(elem){

						var newRow = document.createElement("TR");
	        			newRow.setAttribute("id", "metadataRow_" + newID);

						cell = document.createElement("TD");
	        			cell.innerHTML=tagInp.replace(/__we_new_id__/,newID);
	        			cell.width="210";
	        			newRow.appendChild(cell);

	        			cell = document.createElement("TD");
	        			cell.innerHTML=typeSel.replace(/__we_new_id__/,newID);
	        			cell.width="200";
	        			newRow.appendChild(cell);

	        			cell = document.createElement("TD");
	        			cell.width="30";
	        			cell.align="right"
	        			cell.innerHTML=\''.$we_button->create_button("image:btn_function_trash", "javascript:delRow('+newID+')").'\';
	        			newRow.appendChild(cell);

	        			elem.appendChild(newRow);

	        			newRow = document.createElement("TR");
	        			newRow.setAttribute("id", "metadataRow2_" + newID);

						cell = document.createElement("TD");
						cell.style.paddingBottom="10px";
	        			cell.innerHTML=\'<div class="small">'.htmlspecialchars($l_metadata["import_from"]).'</div>\'+importInp.replace(/__we_new_id__/,newID);
	        			newRow.appendChild(cell);
						cell = document.createElement("TD");
						cell.setAttribute("colspan",2);
						cell.style.paddingBottom="10px";
	        			cell.innerHTML=\'<div class="small">' . htmlspecialchars($l_metadata["fields"]) . '</div>\'+fieldSel.replace(/__we_new_id__/g,newID);
	        			newRow.appendChild(cell);
	        			elem.appendChild(newRow);
					}
				}

				function delRow(id) {
					var elem = document.getElementById("metadataTable");
					if(elem){
						var trows = elem.rows;
						var rowID = "metadataRow_" + id;
						var rowID2 = "metadataRow2_" + id;

			        	for (i=trows.length-1;i>=0;i--) {
			        		if(rowID == trows[i].id || rowID2 == trows[i].id) {
			        			elem.deleteRow(i);
			        		}
			        	}

					}
				}
				function init() {
					self.focus();
				}

				function addFieldToInput(sel, inpNr) {
					if (sel && sel.selectedIndex >= 0 && sel.options[sel.selectedIndex].parentNode.nodeName.toLowerCase() == "optgroup") {
						var _inpElem = document.forms[0].elements["metadataImportFrom["+inpNr+"]"];
						var _metaType = sel.options[sel.selectedIndex].parentNode.label.toLowerCase();
						var _str = _metaType + "/" + sel.options[sel.selectedIndex].value;
						_inpElem.value = _inpElem.value ? _inpElem.value + (","+_str) : _str;
					}
					sel.selectedIndex = 0;
				}

			');

			$_hint = htmlAlertAttentionBox($l_metadata['fields_hint'], 1, 440,false);


			$_metadata = new we_htmlTable(array('border'=>'1','cellpadding'=>'0','cellspacing'=>'2','width'=>'440','height'=>'50'),4,3);

			$_content = $_hint . '<div style="height:20px"></div>' .$_metadataTable .  $we_button->create_button("image:btn_function_plus", "javascript:addRow()");
			//echo $_content;
			//$_dialog = create_dialog("settings_predefined", $l_metadata["thumbnails"], $_content, -1, "", "", false, $js);
			$_contentFinal = array();
			array_push($_contentFinal, array("headline" => "", "html" => $_content, "space" => 0));
			// Build dialog element if user has permission
			$_dialog = create_dialog("settings_predefined", $l_metadata["headline"], $_contentFinal, -1, "", "", false, $js);
			//$_dialog = create_dialog("", $l_metadata["saved_successfully"], $_content);
			break;
	}
	if (isset($_dialog)) {
		return $_dialog;
	} else {
		return "";
	}
}

/**
 * This functions renders the complete dialog.
 *
 * @return         string
 */

function render_dialog() {
	// Render setting groups
	$_output  = we_htmlElement::htmlDiv(array("id" => "metadatafields_dialog"), build_dialog("dialog"));

	// Render save screen
	$_output .= we_htmlElement::htmlDiv(array("id" => "metadatafields_save", "style" => "display: none;"), build_dialog("save"));

	return $_output;
}

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

htmlTop();
$save_javascript ="";
// Check if we need to save settings
if (isset($_REQUEST["save_metadatafields"]) && $_REQUEST["save_metadatafields"] == "true") {

	if (isset($_REQUEST["metadatafields_name"]) && (strpos($_REQUEST["metadatafields_name"],"'") !== false || strpos($_REQUEST["metadatafields_name"],",") !== false)) {
		$save_javascript =  we_htmlElement::jsElement(we_message_reporting::getShowMessageCall($l_alert["metadatafields_hochkomma"], WE_MESSAGE_ERROR).
							'history.back()');
	} else {
		save_all_values();


		$save_javascript = we_htmlElement::jsElement("

							   " . $save_javascript . "
								" . we_message_reporting::getShowMessageCall($l_metadata["saved"], WE_MESSAGE_NOTICE) . "

							   top.close();

					   ");
	}

	print STYLESHEET . $save_javascript . "</head>";

	print we_htmlElement::htmlBody(array( "class" => "weDialogBody"), build_dialog("saved")) . "</html>";
} else {
	$_form = we_htmlElement::htmlForm(array("name" => "we_form", "method" => "get", "action" => $_SERVER["PHP_SELF"]), we_htmlElement::htmlHidden(array("name" => "save_metadatafields", "value" => "false")) . render_dialog());

	print STYLESHEET . "</head>";

	print we_htmlElement::htmlBody(array("class" => "weDialogBody", "onload"=>"init()"), $_form) . "</html>";
}

?>