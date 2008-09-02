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

/**
 * Converts the date from ##-##-#### to ##.##.####
 *
 * @param unknown_type $date
 * @return unknown
 */
function convertDate($date)
{
	return implode('.', array_reverse(explode('-', $date)));
}

/**
 * Creates the HTML code for the date picker button
 *
 * @param unknown_type $_label
 * @param unknown_type $_name
 * @param unknown_type $_btn
 * @return unknown
 */
function getDateSelector($_label, $_name, $_btn)
{
	global $l_cockpit;
	$we_button = new we_button();
	$btnDatePicker = $we_button->create_button(
			"image:date_picker", 
			"javascript:", 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			false, 
			$_btn);
	$oSelector = new we_htmlTable(array(
		"cellpadding" => "0", "cellspacing" => "0", "border" => "0", "id" => $_name . "_cell"
	), 1, 5);
	$oSelector->setCol(0, 0, array(
		"class" => "middlefont"
	), $_label);
	$oSelector->setCol(0, 1, null, getPixel(5, 1));
	$oSelector->setCol(
			0, 
			2, 
			null, 
			htmlTextInput(
					$name = $_name, 
					$size = 55, 
					$value = "", 
					$maxlength = 10, 
					$attribs = 'id="' . $_name . '" readonly="1"', 
					$type = "text", 
					$width = 70, 
					$height = 0));
	$oSelector->setCol(0, 3, null, getPixel(5, 1));
	$oSelector->setCol(0, 4, null, we_htmlElement::htmlA(array(
		"href" => "#"
	), $btnDatePicker));
	return $oSelector->getHTMLCode();
}

/**
 * Creates the HTML code with the note list
 *
 * @param unknown_type $_sql
 * @param unknown_type $bDate
 * @return unknown
 */
function getNoteList($_sql, $bDate, $bDisplay)
{
	global $DB_WE;
	$DB_WE->query($_sql);
	$_notes = '<table width="100%" cellspacing="0" cellpadding="0" border="0">';
	$_rcd = 0;
	$_fields = array(
		
			'ID', 
			'WidgetName', 
			'UserID', 
			'CreationDate', 
			'Title', 
			'Text', 
			'Priority', 
			'Valid', 
			'ValidFrom', 
			'ValidUntil'
	);
	while ($DB_WE->next_record()) {
		foreach ($_fields as $_fld) {
			//$_notes .= we_htmlElement::htmlSpan(array('id'=>$_rcd.'_'.$_fld,'style'=>'display:none;'),$DB_WE->f($_fld));
			if ($_fld == 'ValidUntil' && ($DB_WE->f('ValidUntil') == "3000-01-01" || $DB_WE->f(
					'ValidUntil') == "0000-00-00")) {
				$_fldValue = "";
			} else {
				$_fldValue = $DB_WE->f($_fld);
			}
			$_fldValue = str_replace('<', '&lt;', $_fldValue);
			$_fldValue = str_replace('>', '&gt;', $_fldValue);
			$_fldValue = str_replace("'", '&#039;', $_fldValue);
			$_fldValue = str_replace('"', '&quot;', $_fldValue);
			$_notes .= we_htmlElement::htmlHidden(
					array(
						'id' => $_rcd . '_' . $_fld, 'style' => 'display:none;', 'value' => ($_fldValue)
					));
		}
		
		$validity = $DB_WE->f("Valid");
		switch ($bDate) {
			case 1 :
				if ($validity == 'always') {
					$showDate = '-';
				} else {
					$showDate = convertDate($DB_WE->f("ValidFrom"));
				}
				break;
			case 2 :
				if ($validity == 'always' || $validity == 'date') {
					$showDate = '-';
				} else {
					$showDate = convertDate($DB_WE->f("ValidUntil"));
				}
				break;
			default :
				$showDate = convertDate($DB_WE->f("CreationDate"));
		}
		
		$today = date("Ymd");
		$vFrom = str_replace("-", "", $DB_WE->f("ValidFrom"));
		$vTill = str_replace("-", "", $DB_WE->f("ValidUntil"));
		if ($bDisplay == 1 && $DB_WE->f("Valid") != 'always') {
			if ($DB_WE->f("Valid") == 'date') {
				if ($today < $vFrom) {
					continue;
				}
			} else {
				if ($today < $vFrom || $today > $vTill) {
					continue;
				}
			}
		}
		$showTitle = $DB_WE->f("Title");
		$showTitle = str_replace('<', '&lt;', $showTitle);
		$showTitle = str_replace('>', '&gt;', $showTitle);
		$showTitle = str_replace("'", '&#039;', $showTitle);
		$showTitle = str_replace('"', '&quot;', $showTitle);
		$_notes .= '<tr style="cursor:pointer;" id="' . $_rcd . '_tr" onmouseover="fo=document.forms[0];if(fo.elements[\'mark\'].value==\'\'){setColor(this,' . $_rcd . ',\'#EDEDED\');}" onmouseout="fo=document.forms[0];if(fo.elements[\'mark\'].value==\'\'){setColor(this,' . $_rcd . ',\'#FFFFFF\');}" onmousedown="selectNote(' . $_rcd . ');">';
		$_notes .= '<td width="5">' . getPixel(5, 1) . '</td>';
		$_notes .= '<td width="15" height="20" valign="middle" nowrap>' . we_htmlElement::htmlImg(
				array(
					
						"src" => IMAGE_DIR . "pd/prio_" . $DB_WE->f("Priority") . ".gif", 
						"width" => 13, 
						"height" => 14
				)) . '</td>';
		$_notes .= '<td width="5">' . getPixel(5, 1) . '</td>';
		$_notes .= '<td width="60" valign="middle" class="middlefont" align="center">' . $showDate . '</td>';
		$_notes .= '<td width="5">' . getPixel(5, 1) . '</td>';
		$_notes .= '<td valign="middle" class="middlefont">' . $showTitle . '</td>';
		$_notes .= '<td width="5">' . getPixel(5, 1) . '</td>';
		$_notes .= '</tr>';
		$_rcd++;
	}
	$_notes .= '</table>';
	return $_notes;
}

function getCSS()
{
	global $BROWSER, $SYSTEM, $l_css;
	$_css = "
	body{
		background-color:transparent;
	}
	.cl_notes{
		background-color:#FFFFFF;
	}
	#notices{
		position:relative;
		top:0px;
		display:block;
		height:250px;
		overflow:auto;
	}
	#props{
		position:absolute;
		bottom:0px;
		display:none;
	}
	#view{
		position:absolute;
		bottom:0px;
		display:block;
		height:22px;
	}
	.wetextinput{
		color:black;
		border:#AAAAAA solid 1px;
		height:18px;
		vertical-align:middle;
		" . (($BROWSER == "IE") ? "" : "line-height:normal;") . ";
		font-size:" . (($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px")) . ";
		font-family:" . $l_css["font_family"] . ";
	}
	.wetextinputselected{
		color:black;
		border:#888888 solid 1px;
		background-color:#DCE6F2;
		height:18px;
		" . (($BROWSER == "IE") ? "" : "line-height:normal;") . ";
		font-size:" . (($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px")) . ";
		font-family:" . $l_css["font_family"] . ";
	}
	.wetextarea{
		color:black;
		border:#AAAAAA solid 1px;
		height:80px;
		" . (($BROWSER == "IE") ? "" : "line-height:normal;") . ";
		font-size:" . (($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px")) . ";
		font-family:" . $l_css["font_family"] . ";
	}
	.wetextareaselected{
		color:black;
		border:#888888 solid 1px;
		background-color:#DCE6F2;
		height:80px;
		" . (($BROWSER == "IE") ? "" : "line-height:normal;") . ";
		font-size:" . (($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px")) . ";
		font-family:" . $l_css["font_family"] . ";
	}
	select{
		border:#AAAAAA solid 1px;
	}";
	
	return $_css;
}
?>