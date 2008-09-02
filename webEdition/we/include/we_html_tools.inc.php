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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_browser_check.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/global.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/charset/charset.inc.php");

/**
 * This function creates a table.
 *
 * @param          string                                  $element
 * @param          string                                  $text
 * @param          string                                  $textalign          (optional)
 * @param          string                                  $textclass          (optional)
 * @param          string                                  $col2               (optional)
 * @param          string                                  $col3               (optional)
 * @param          string                                  $col4               (optional)
 * @param          string                                  $col5               (optional)
 * @param          string                                  $col6               (optional)
 * @param          int                                     $abstand            (optional)
 *
 * @return         string
 */

function htmlFormElementTable($element, $text, $textalign = "left", $textclass = "defaultfont", $col2 = "", $col3 = "", $col4 = "", $col5 = "", $col6 = "", $abstand = 1)
{
	$colspan = 1;
	$elemOut = "<td";
	if (is_array($element)) {
		foreach ($element as $key => $val) {
			$key == "text" ? $colText = $val : $elemOut .= " $key='$val'";
		}
	} else {
		$colText = $element;
	}
	$elemOut .= ">" . $colText . "</td>";
	
	if ($col2) {
		$col2out = "<td";
		if (is_array($col2)) {
			foreach ($col2 as $key => $val) {
				$key == "text" ? $colText = $val : $col2out .= " $key='$val'";
			}
		} else {
			$colText = $col2;
		}
		$col2out .= ">" . $colText . "</td>";
		$colspan++;
	}
	
	if ($col3) {
		$col3out = "<td";
		if (is_array($col3)) {
			foreach ($col3 as $key => $val) {
				$key == "text" ? $colText = $val : $col3out .= " $key='$val'";
				;
			}
		} else {
			$colText = $col3;
		}
		$col3out .= ">" . $colText . "</td>";
		$colspan++;
	}
	
	if ($col4) {
		$col4out = "<td";
		if (is_array($col4)) {
			foreach ($col4 as $key => $val) {
				$key == "text" ? $colText = $val : $col4out .= " $key='$val'";
				;
			}
		} else {
			$colText = $col4;
		}
		$col4out .= ">" . $colText . "</td>";
		$colspan++;
	}
	
	if ($col5) {
		$col5out = "<td";
		if (is_array($col5)) {
			foreach ($col5 as $key => $val) {
				$key == "text" ? $colText = $val : $col5out .= " $key='$val'";
				;
			}
		} else {
			$colText = $col5;
		}
		$col5out .= ">" . $colText . "</td>";
		$colspan++;
	}
	
	if ($col6) {
		$col6out = "<td";
		if (is_array($col6)) {
			foreach ($col6 as $key => $val) {
				$key == "text" ? $colText = $val : $col6out .= " $key='$val'";
				;
			}
		} else {
			$colText = $col6;
		}
		$col6out .= ">" . $colText . "</td>";
		$colspan++;
	}
	return '<table cellpadding="0" cellspacing="0" border="0">' . ($text ? '<tr><td class="' . trim($textclass) . '" align="' . trim(
			$textalign) . '" colspan="' . $colspan . '">' . $text . '</td></tr>' : '') . ($abstand ? ('<tr><td colspan="' . $colspan . '">' . getPixel(
			2, 
			$abstand) . '</td></tr>') : '') . '<tr>' . $elemOut . ($col2 ? $col2out : "") . ($col3 ? $col3out : "") . ($col4 ? $col4out : "") . ($col5 ? $col5out : "") . ($col6 ? $col6out : "") . '</tr></table>';
}

function targetBox($name, $size, $width = "", $id = "", $value = "", $onChange = "", $abstand = 8, $selectboxWidth = "", $disabled = false)
{
	$jsvarname = str_replace("[", "_", $name);
	$jsvarname = str_replace("]", "_", $jsvarname);
	$_inputs = array(
		
			"class" => "weSelect", 
			"name" => "sel_" . $name, 
			"onfocus" => "change$jsvarname=1;", 
			"onchange" => "if(change$jsvarname) this.form.elements['$name'].value = this.options[this.selectedIndex].text; change$jsvarname=0; this.selectedIndex = 0;" . $onChange, 
			"style" => (($selectboxWidth != "") ? ("width: " . $selectboxWidth . "px;") : "")
	);
	
	if ($disabled) {
		$_inputs = array_merge($_inputs, array(
			"disabled" => "true"
		));
	}
	
	$_target_box = new we_htmlSelect($_inputs, 0);
	$_target_box->addOptions(5, array(
		"", "_top", "_parent", "_self", "_blank"
	), array(
		"", "_top", "_parent", "_self", "_blank"
	));
	
	$_table = new we_htmlTable(array(
		"cellpadding" => 0, "cellspacing" => 0, "border" => 0
	), 1, 3);
	
	$_inputs = array(
		"name" => $name, "class" => "defaultfont"
	);
	
	if ($width) {
		$_inputs = array_merge($_inputs, array(
			"style" => "width: " . $width . "px;"
		));
	}
	
	if ($id) {
		$_inputs = array_merge($_inputs, array(
			"id" => $id
		));
	}
	
	if ($value) {
		$_inputs = array_merge($_inputs, array(
			"value" => htmlspecialchars($value)
		));
	}
	
	if ($onChange) {
		$_inputs = array_merge($_inputs, array(
			"onchange" => $onChange
		));
	}
	
	$_table->setCol(
			0, 
			0, 
			array(
				"class" => "defaultfont"
			), 
			htmlTextInput(
					$name, 
					$size, 
					$value, 
					"", 
					(!empty($onChange) ? 'onchange="' . $onChange . '"' : ''), 
					"text", 
					$width, 
					0, 
					"", 
					$disabled));
	
	$_table->setCol(0, 1, null, getPixel($abstand, 1));
	
	$_table->setCol(0, 2, array(
		"class" => "defaultfont"
	), $_target_box->getHtmlCode());
	$js = <<<HTS
<script type="testjavascript">
 var change$jsvarname = 0;
</script>
	
HTS;
	
	return $_table->getHtmlCode();
}

function htmlTextInput($name, $size = 24, $value = "", $maxlength = "", $attribs = "", $type = "text", $width = "0", $height = "0", $markHot = "", $disabled = false)
{
	$style = ($width || $height) ? (' style="' . ($width ? ('width: ' . $width . ((strpos($width, "px") || strpos(
			$width, 
			"%")) ? "" : "px") . ';') : '') . ($height ? ('height: ' . $height . ((strpos($height, "px") || strpos(
			$height, 
			"%")) ? "" : "px") . ';') : '') . '"') : '';
	return '<input' . ($markHot ? ' onchange="if(_EditorFrame){_EditorFrame.setEditorIsHot(true);}' . $markHot . '.hot=1;"' : '') . (strstr(
			$attribs, 
			"class=") ? "" : ' class="wetextinput"') . ' type="' . trim($type) . '" name="' . trim($name) . '" size="' . abs(
			$size) . '" value="' . htmlspecialchars($value) . '"' . ($maxlength ? (' maxlength="' . abs($maxlength) . '"') : '') . ($attribs ? " $attribs" : '') . $style . ' onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'"' . ($disabled ? (' disabled="true"') : '') . '>';
}

function htmlMessageBox($w, $h, $content, $headline = "", $buttons = "")
{
	
	$_out = '<div style="width:' . $w . 'px;height:' . $h . 'px;background-color:#F7F5F5;border: 2px solid #D7D7D7;padding:20px;">';
	
	if ($headline) {
		$_out .= '<h1 class="header">' . $headline . '</h1>';
	}
	
	$_out .= '<div>' . $content . '</div><div style="margin-top:20px;">' . $buttons . '</div></div>';
	
	return $_out;
}

function htmlDialogLayout($content, $headline, $buttons = "", $width = "100%", $marginLeft = "30", $height = "", $overflow = "auto")
{
	include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
	$parts = array(
		array(
		"html" => $content, "headline" => "", "space" => 0
	)
	);
	
	if ($buttons) {
		$buttons = '<div align="right" style="margin-left:10px;">' . $buttons . '</div>';
	}
	return we_multiIconBox::getHTML(
			"", 
			$width, 
			$parts, 
			$marginLeft, 
			$buttons, 
			-1, 
			"", 
			"", 
			false, 
			$headline, 
			"", 
			$height, 
			$overflow);
}

function htmlDialogBorder3Row($content, $class = "middlefont", $bgColor = "")
{
	$anz = sizeof($content);
	$out = '<td style="border-bottom: 1px solid silver;background-image:url(' . IMAGE_DIR . 'box/shaddowBox3_l.gif);">' . getPixel(
			8, 
			isset($content[0]["height"]) ? $content[0]["height"] : 1) . '</td>';
	
	for ($f = 0; $f < $anz; $f++) {
		$bgcol = $bgColor ? $bgColor : ((isset($content[$f]["bgcolor"]) && $content[$f]["bgcolor"]) ? $content[$f]["bgcolor"] : "white");
		$out .= '<td class="' . $class . '" style="padding:2px 5px 2px 5px;' . (($f != 0) ? "border-left:1px solid silver;" : "") . 'border-bottom: 1px solid silver;background-color:' . $bgcol . ';" ' . ((isset(
				$content[$f]["align"])) ? 'align="' . $content[$f]["align"] . '"' : "") . ' ' . ((isset(
				$content[$f]["height"])) ? 'height="' . $content[$f]["height"] . '"' : "") . '>' . ((isset(
				$content[$f]["dat"]) && $content[$f]["dat"]) ? $content[$f]["dat"] : "&nbsp;") . '</td>';
	}
	$out .= '
					<td style="border-bottom: 1px solid silver;background-image:url(' . IMAGE_DIR . 'box/shaddowBox3_r.gif);">' . getPixel(
			8, 
			isset($content[0]["height"]) ? $content[0]["height"] : 1) . '</td>

				';
	return $out;
}

function htmlDialogBorder3($w, $h, $content, $headline, $class = "middlefont", $bgColor = "", $buttons = "", $id = "", $style = "")
{ //content && headline are arrays
	$anz = sizeof($headline);
	$out = '<table' . ($id ? ' id="' . $id . '"' : '') . ($style ? ' style="' . $style . '"' : '') . ' border="0" cellpadding="0" cellspacing="0" width="' . $w . '">
		<tr>
		<td width="8" style="background-image:url(' . IMAGE_DIR . 'box/box_header_ol2.gif);">' . getPixel(
			8, 
			21) . '</td>';
	// HEADLINE
	for ($f = 0; $f < $anz; $f++) {
		$out .= '<td class="' . $class . '" style="padding:1px 5px 1px 5px;background-image:url(' . IMAGE_DIR . 'box/box_header_bg2.gif);">' . $headline[$f]["dat"] . '</td>';
	}
	$out .= '<td width="8" style="background-image:url(' . IMAGE_DIR . 'box/box_header_or2.gif);">' . getPixel(8, 21) . '</td>
				</tr>';
	
	//CONTENT
	$zn1 = sizeof($content);
	for ($i = 0; $i < $zn1; $i++) {
		$out .= '<tr>' . htmlDialogBorder3Row($content[$i], $class, $bgColor) . '</tr>';
	}
	
	$out .= '</table>';
	
	if ($buttons) {
		$attribs = array(
			"border" => "0", "cellpadding" => "0", "cellspacing" => "0"
		);
		$_table = new we_htmlTable($attribs, 3, 1);
		$_table->setCol(0, 0, array(
			"colspan" => "2"
		), $out);
		$_table->setCol(1, 0, null, getPixel($w, 5)); // row for gap between buttons and dialogborder
		$_table->setCol(2, 0, array(
			"align" => "right"
		), $buttons);
		return $_table->getHtmlCode();
	} else {
		return $out;
	}
}

function html_select($name, $size, $vals, $value = "", $onchange = "")
{
	$out = '<select class="weSelect" name="' . $name . '" size="' . $size . '"' . ($onchange ? ' onChange="' . $onchange . '"' : '') . ">\n";
	reset($vals);
	while (list($v, $t) = each($vals)) {
		$out .= '<option value="' . htmlspecialchars($v) . '"' . (($v == $value) ? ' selected' : '') . '>' . "$t\n";
	}
	return "$out</select>\n";
}

function gifButton($name, $href, $language = "Deutsch", $alt = "", $width = "", $height = "", $onClick = "", $bname = "", $target = "", $disabled = false)
{
	
	$img = '<img src="' . IMAGE_DIR . 'buttons/' . $name . ($disabled ? "_d" : "") . ($language ? '_' : '') . $language . '.gif"' . ($width ? ' width="' . $width . '"' : '') . ($height ? ' height="' . $height . '"' : '') . ($bname ? ' name="' . $bname . '"' : '') . ' border="0" alt="' . $alt . '">';
	
	if ($disabled)
		return $img;
	if ($href) {
		return '<a href="' . $href . '" onMouseOver="window.status=\'' . $alt . '\';return true;" onMouseOut="window.status=\'\';return true;"' . ($onClick ? ' onClick="' . $onClick . '"' : '') . ($target ? (' target="' . $target . '"') : '') . '>' . $img . '</a>';
	} else {
		return '<input type="image" src="' . IMAGE_DIR . 'buttons/' . $name . ($language ? '_' : '') . $language . '.gif"' . ($width ? ' width="' . $width . '"' : '') . ($height ? ' height="' . $height . '"' : '') . ' border="0" alt="' . $alt . '"' . ($onClick ? ' onClick="' . $onClick . '"' : '') . ($bname ? ' name="' . $bname . '"' : '') . '>';
	}
}

function getExtensionPopup($name, $selected, $extensions, $width = "", $attribs = "")
{
	
	if ((isset($extensions)) && (sizeof($extensions) > 1)) {
		$out = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . htmlTextInput(
				$name, 
				5, 
				$selected, 
				"", 
				$attribs, 
				"text", 
				$width / 2, 
				"0", 
				"top") . '</td><td><select class="weSelect" name="wetmp_' . $name . '" size=1' . ($width ? ' style="width: ' . ($width / 2) . 'px"' : '') . ' onChange="if(typeof(_EditorFrame) != \'undefined\'){_EditorFrame.setEditorIsHot(true);}if(this.options[this.selectedIndex].text){this.form.elements[\'' . $name . '\'].value=this.options[this.selectedIndex].text;};this.selectedIndex=0"><option>';
		for ($i = 0; $i < sizeof($extensions); $i++) {
			$out .= '<option>' . $extensions[$i] . "\n";
		}
		$out .= "</select></td></tr></table>\n";
	} else {
		$_ext = $extensions[0];
		$out = hidden($name, $_ext) . '<b class="defaultfont">' . $_ext . '</b>';
	}
	return $out;
}

function pExtensionPopup($name, $selected, $extensions)
{
	print getExtensionPopup($name, $selected, $extensions);
}

function getPixel($w, $h, $border = 0)
{
	return "<img src=\"" . IMAGE_DIR . "pixel.gif\" width=\"$w\" height=\"$h\" border=\"$border\">";
}

function pPixel($w, $h)
{
	print getPixel($w, $h);
}

function hidden($name, $value, $attribs = null)
{
	$attribute = "";
	if (isset($attribs) && is_array($attribs)) {
		foreach ($attribs as $key => $val) {
			$attribute .= $key . '="' . $val . '" ';
		}
	}
	return '<input type="hidden" value="' . $value . '" name="' . $name . '" ' . $attribute . '>';
}

function we_getDayPos($format)
{
	return max(findChar($format, "d"), findChar($format, "D"), findChar($format, "j"));
}

function we_getMonthPos($format)
{
	return max(findChar($format, "m"), findChar($format, "M"), findChar($format, "n"), findChar($format, "F"));
}

function we_getYearPos($format)
{
	return max(findChar($format, "y"), findChar($format, "Y"));
}

function we_getHourPos($format)
{
	return max(findChar($format, "g"), findChar($format, "G"), findChar($format, "h"), findChar($format, "H"));
}

function we_getMinutePos($format)
{
	return findChar($format, "i");
}

function findChar($in, $searchChar)
{
	$backslash = false;
	for ($i = 0; $i < strlen($in); $i++) {
		$char = substr($in, $i, 1);
		if ($backslash == false && $char == $searchChar) {
			return $i;
		}
		$backslash = ($char == "\\") ? true : false;
	}
	return -1;
}

function getDateInput2($name, $time = "", $setHot = false, $format = "", $onchange = "", $class = "weSelect", $xml = "", $minyear = "", $maxyear = "")
{
	global $l_global;
	
	$_attsSelect = array();
	$_attsOption = array();
	$_attsHidden = array();
	
	if ($xml != "") {
		$_attsSelect['xml'] = $xml;
		$_attsOption['xml'] = $xml;
		$_attsHidden['xml'] = $xml;
	}
	if ($class != '') {
		$_attsSelect['class'] = 'weSelect';
	}
	$_attsSelect['size'] = '1';
	
	if ($onchange || $setHot) {
		$_attsSelect['onchange'] = (($setHot ? '_EditorFrame.setEditorIsHot(true);' : '') . $onchange);
	}
	
	if ($time) {
		$day = abs(date("j", $time));
		$month = abs(date("n", $time));
		$year = abs(date("Y", $time));
		$hour = abs(date("G", $time));
		$minute = abs(date("i", $time));
	}
	
	$_dayPos = we_getDayPos($format);
	$_monthPos = we_getMonthPos($format);
	$_yearPos = we_getYearPos($format);
	$_hourPos = we_getHourPos($format);
	$_minutePos = we_getMinutePos($format);
	
	$_showDay = true;
	$_showMonth = true;
	$_showYear = true;
	$_showHour = true;
	$_showMinute = true;
	
	$name = ereg_replace('^(.+)]$', '\1%s]', $name);
	if (($format == "") || $_dayPos > -1) {
		$days = '';
		for ($i = 1; $i <= 31; $i++) {
			if ($time && $day == $i) {
				$_atts2 = array(
					'selected' => 'selected'
				);
			} else {
				$_atts2 = array();
			}
			$days .= getHtmlTag('option', array_merge($_attsOption, $_atts2), sprintf("%02d", $i));
		}
		$daySelect = getHtmlTag(
				'select', 
				array_merge($_attsSelect, array(
					'name' => sprintf($name, "_day"), 'id' => sprintf($name, "_day")
				)), 
				$days, 
				true) . '&nbsp;';
	} else {
		$daySelect = getHtmlTag(
				'input', 
				array_merge(
						$_attsHidden, 
						array(
							
								'type' => 'hidden', 
								'name' => sprintf($name, "_day"), 
								'id' => sprintf($name, "_day"), 
								'value' => $day
						)));
		$_showDay = false;
	}
	
	if (($format == "") || $_monthPos > -1) {
		$months = '';
		for ($i = 1; $i <= 12; $i++) {
			if ($time && $month == $i) {
				$_atts2 = array(
					'selected' => 'selected'
				);
			} else {
				$_atts2 = array();
			}
			$months .= getHtmlTag('option', array_merge($_attsOption, $_atts2), sprintf("%02d", $i));
		}
		$monthSelect = getHtmlTag(
				'select', 
				array_merge($_attsSelect, array(
					'name' => sprintf($name, "_month"), 'id' => sprintf($name, "_month")
				)), 
				$months, 
				true) . '&nbsp;';
	} else {
		$monthSelect = getHtmlTag(
				'input', 
				array_merge(
						$_attsHidden, 
						array(
							
								'type' => 'hidden', 
								'name' => sprintf($name, "_month"), 
								'id' => sprintf($name, "_month"), 
								'value' => $month
						)));
		$_showMonth = false;
	}
	
	if (($format == "") || $_yearPos > -1) {
		$years = '';
		if ($minyear == "") {
			$minyear = 1970;
		}
		if ($maxyear == "") {
			$maxyear = abs(date("Y") + 8);
		}
		for ($i = $minyear; $i <= $maxyear; $i++) {
			if ($time && $year == $i) {
				$_atts2 = array(
					'selected' => 'selected'
				);
			} else {
				$_atts2 = array();
			}
			$years .= getHtmlTag('option', array_merge($_attsOption, $_atts2), sprintf("%02d", $i));
		}
		$yearSelect = getHtmlTag(
				'select', 
				array_merge($_attsSelect, array(
					'name' => sprintf($name, "_year"), 'id' => sprintf($name, "_year")
				)), 
				$years, 
				true) . '&nbsp;';
	} else {
		$yearSelect = getHtmlTag(
				'input', 
				array_merge(
						$_attsHidden, 
						array(
							
								'type' => 'hidden', 
								'name' => sprintf($name, "_year"), 
								'id' => sprintf($name, "_year"), 
								'value' => $year
						)));
		$_showYear = false;
	}
	
	if (($format == "") || $_hourPos > -1) {
		$hours = '';
		for ($i = 0; $i <= 23; $i++) {
			if ($time && $hour == $i) {
				$_atts2 = array(
					'selected' => 'selected'
				);
			} else {
				$_atts2 = array();
			}
			$hours .= getHtmlTag('option', array_merge($_attsOption, $_atts2), sprintf("%02d", $i));
		}
		$hourSelect = getHtmlTag(
				'select', 
				array_merge($_attsSelect, array(
					'name' => sprintf($name, "_hour"), 'id' => sprintf($name, "_hour")
				)), 
				$hours, 
				true) . '&nbsp;';
	} else {
		$hourSelect = getHtmlTag(
				'input', 
				array_merge(
						$_attsHidden, 
						array(
							
								'type' => 'hidden', 
								'name' => sprintf($name, "_hour"), 
								'id' => sprintf($name, "_hour"), 
								'value' => $hour
						)));
		$_showHour = false;
	}
	
	if (($format == "") || $_minutePos > -1) {
		$minutes = '';
		for ($i = 0; $i <= 59; $i++) {
			if ($time && $minute == $i) {
				$_atts2 = array(
					'selected' => 'selected'
				);
			} else {
				$_atts2 = array();
			}
			$minutes .= getHtmlTag('option', array_merge($_attsOption, $_atts2), sprintf("%02d", $i));
		}
		$minSelect = getHtmlTag(
				'select', 
				array_merge($_attsSelect, array(
					'name' => sprintf($name, "_minute"), 'id' => sprintf($name, "_minute")
				)), 
				$minutes, 
				true) . '&nbsp;';
	} else {
		$minSelect = getHtmlTag(
				'input', 
				array_merge(
						$_attsHidden, 
						array(
							
								'type' => 'hidden', 
								'name' => sprintf($name, "_minute"), 
								'id' => sprintf($name, "_minute"), 
								'value' => $minute
						)));
		$_showMinute = false;
	}
	
	$_datePosArray = array(
		
			($_dayPos == -1) ? "d" : $_dayPos => $daySelect, 
			($_monthPos == -1) ? "m" : $_monthPos => $monthSelect, 
			($_yearPos == -1) ? "y" : $_yearPos => $yearSelect
	);
	
	$_timePosArray = array(
		($_hourPos == -1) ? "h" : $_hourPos => $hourSelect, ($_minutePos == -1) ? "i" : $_minutePos => $minSelect
	);
	
	ksort($_datePosArray);
	ksort($_timePosArray);
	
	$retVal = '<table cellpadding="0" cellspacing="0" border="0">
';
	if ($_showDay || $_showMonth || $_showYear) {
		
		$retVal .= '<tr>
	<td>';
		foreach ($_datePosArray as $foo) {
			$retVal .= $foo;
		}
		$retVal .= '</td>
</tr>
';
	} else {
		foreach ($_datePosArray as $foo) {
			$retVal .= $foo;
		}
		$retVal .= "\n";
	}
	if ($_showHour || $_showMinute) {
		$retVal .= '<tr>
	<td>';
		foreach ($_timePosArray as $foo) {
			$retVal .= $foo;
		}
		$retVal .= '</td>
</tr>
';
	} else {
		foreach ($_timePosArray as $foo) {
			$retVal .= $foo;
		}
		$retVal .= "\n";
	}
	$retVal .= '</table>
';
	return $retVal;
}

function htmlTop($title = "webEdition (c) living-e AG", $charset = "")
{
	print getHtmlTop($title, $charset);
}

function getHtmlTop($title = "webEdition (c) living-e AG", $charset = "", $useMessageBox = true)
{
	
	$_title = we_htmlElement::htmlTitle($title);
	$_meta_expires = we_htmlElement::htmlMeta(array(
		"http-equiv" => "expires", "content" => 0
	));
	$_meta_no_cache = we_htmlElement::htmlMeta(array(
		"http-equiv" => "pragma", "content" => "no-cache"
	));
	$_meta_content_type = we_htmlElement::htmlMeta(
			array(
				
					"http-equiv" => "content-type", 
					"content" => "text/html; charset=" . ($charset ? $charset : $GLOBALS["_language"]["charset"])
			));
	$_meta_imagetoolbar_type = we_htmlElement::htmlMeta(array(
		"http-equiv" => "imagetoolbar", "content" => "no"
	));
	$_meta_generator = we_htmlElement::htmlMeta(
			array(
				"name" => "generator", "content" => "webEdition Version " . WE_VERSION
			));
	$_showMessage = $useMessageBox ? we_htmlElement::jsElement("", array(
		"src" => JS_DIR . "we_showMessage.js"
	)) . we_htmlElement::jsElement("", array(
		"src" => JS_DIR . "attachKeyListener.js"
	)) : "";
	
	return " <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
            <html>
				<head>
					$_title
					$_meta_expires
					$_meta_no_cache
					$_meta_content_type
					$_meta_imagetoolbar_type
					$_meta_generator
					$_showMessage
	";
}

/**
 * Enter description here...
 *
 * @param string $text
 * @param string $img
 * @param bool $yes
 * @param bool $no
 * @param bool $cancel
 * @param string $yesHandler
 * @param string $noHandler
 * @param string $cancelHandler
 * @param string $script
 * @return string
 */
function htmlYesNoCancelDialog($text = "", $img = "", $yes = "", $no = "", $cancel = "", $yesHandler = "", $noHandler = "", $cancelHandler = "", $script = "")
{
	$we_button = new we_button();
	
	$cancelButton = ($cancel != "" ? $we_button->create_button("cancel", "javascript:$cancelHandler") : "");
	$noButton = ($no != "" ? $we_button->create_button("no", "javascript:$noHandler") : "");
	$yesButton = ($yes != "" ? $we_button->create_button("yes", "javascript:$yesHandler") : "");
	
	$out = "";
	
	if ($script != "") {
		$out .= we_htmlElement::jsElement($script);
	}
	
	$content = new we_htmlTable(array(
		"cellpadding" => 10, "cellspacing" => 0, "border" => 0
	), 1, ($img != "" ? 2 : 1));
	
	if ($img != "") {
		if (file_exists($_SERVER["DOCUMENT_ROOT"] . $img)) {
			$size = getimagesize($_SERVER["DOCUMENT_ROOT"] . $img);
			$content->setCol(
					0, 
					0, 
					array(
						"valign" => "top"
					), 
					we_htmlElement::htmlImg(
							array(
								"src" => $img, "border" => 0, "width" => $size[0], "height" => $size[1]
							)));
		}
	}
	
	$content->setCol(0, ($img != "" ? 1 : 0), array(
		"class" => "defaultfont"
	), $text);
	//$content->setCol(1, 0, array("colspan" => ($img != "" ? 2 : 1),  "align" => "center"), $we_button->position_yes_no_cancel($yesButton, $noButton, $cancelButton));
	

	$out .= $content->getHtmlCode();
	
	return htmlDialogLayout(
			$out, 
			"", 
			$we_button->position_yes_no_cancel($yesButton, $noButton, $cancelButton), 
			"99%", 
			"0");
	
	return $out;
}

function htmlSelect($name, $values, $size = 1, $selectedIndex = "", $multiple = false, $attribs = "", $compare = "value", $width = "", $cls = "defaultfont", $htmlspecialchars = true)
{
	$ret = '<select class="weSelect ' . $cls . '" name="' . trim($name) . '" size="' . abs($size) . '"' . ($multiple ? " multiple" : "") . ($attribs ? " $attribs" : "") . ($width ? ' style="width: ' . $width . 'px"' : '') . '>' . "\n";
	$selIndex = makeArrayFromCSV($selectedIndex);
	$optgroup = false;
	foreach ($values as $value => $text) {
		if ($text == '<!--we_optgroup-->') {
			if ($optgroup) {
				$ret .= '</optgroup>' . "\n";
			}
			$optgroup = true;
			$ret .= '<optgroup label="' . ($htmlspecialchars ? htmlspecialchars($value) : $value) . '">' . "\n";
		} else {
			$ret .= '<option value="' . ($htmlspecialchars ? htmlspecialchars($value) : $value) . '"' . (in_array(
					(($compare == "value") ? $value : $text), 
					$selIndex) ? " selected" : "") . '>' . ($htmlspecialchars ? htmlspecialchars($text) : $text) . "</option>\n";
		}
	}
	if ($optgroup) {
		$ret .= '</optgroup>' . "\n";
	}
	$ret .= "</select>";
	return $ret;
}

/* displays a grey box with text and an icon

$text: Text to display
$type: 0=no icon
       1=Alert icon
       2=Info icon
       3=Question icon
$width: width of box
$useHtmlSpecialChars: true or false
*/
function htmlAlertAttentionBox($text, $type = 0, $width = 0, $useHtmlSpecialChars = true, $clip = 0)
{
	switch ($type) {
		case 1 :
			$icon = "alert";
			break;
		case 2 :
			$icon = "info";
			break;
		case 3 :
			$icon = "question";
			break;
		default :
			$icon = "";
	}
	
	$text = ($useHtmlSpecialChars) ? htmlspecialchars($text) : $text;
	$js = '';
	
	if ($clip > 0) {
		$unique = md5(uniqid(microtime()));
		$smalltext = substr($text, 0, $clip) . ' ... ';
		$js = we_htmlElement::jsElement(
				'
			function clip_' . $unique . '(){
					var text = document.getElementById("' . $unique . '");
					var btn = document.getElementById("btn_' . $unique . '");

					if(state_' . $unique . '==0){
						text.innerHTML = text_' . $unique . ';
						btn.innerHTML = "<a href=\'javascript:clip_' . $unique . '();\'><img src=\'' . IMAGE_DIR . '/button/btn_direction_down.gif\' border=\'0\'></a>";
						state_' . $unique . '=1;
					}else {
						text.innerHTML = textsmall_' . $unique . ';
						btn.innerHTML = "<a href=\'javascript:clip_' . $unique . '();\'><img src=\'' . IMAGE_DIR . '/button/btn_direction_right.gif\' border=\'0\'></a>";
						state_' . $unique . '=0;
					}
			}
		var state_' . $unique . '=0;
		var text_' . $unique . ' = "' . addslashes($text) . '";
		var textsmall_' . $unique . ' = "' . addslashes($smalltext) . '";
		');
		$text = $smalltext;
	}
	
	if (strpos($width, "%") === false) {
		$width = abs($width);
		if ($GLOBALS['BROWSER'] != "IE") {
			$width -= 10;
		}
	}
	
	return $js . '<div style="background-color:#dddddd;padding:5px;' . ($width ? ' width:' . $width . 'px;' : '') . '"><table border="0" cellpadding="2" width="100%">' . '<tr>' . ($icon ? '<td style="padding-right:10px;" valign="top"><img src="' . IMAGE_DIR . $icon . '_small.gif" width="20" height="22"></td>' : '') . '<td class="middlefont" ' . ($clip > 0 ? 'id="' . $unique . '"' : '') . '>' . $text . '</td>' . ($clip > 0 ? '<td valign="top" align="right" id="btn_' . $unique . '"><a href="javascript:clip_' . $unique . '();"><img src="' . IMAGE_DIR . '/button/btn_direction_right.gif" border="0"></a><td>' : '') . '</tr></table></div>';
}

?>