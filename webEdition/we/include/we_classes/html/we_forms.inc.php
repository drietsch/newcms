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


/**
 * Class we_forms
 *
 * Provides functions for creating html tags used in forms.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");

if (isset($GLOBALS["WE_LANGUAGE"]) && $GLOBALS["WE_LANGUAGE"]) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/html_forms.inc.php");
}

class we_forms {

	/**
	 * @param      $value                                  string
	 * @param      $checked                                bool
	 * @param      $name                                   string
	 * @param      $text                                   string
	 * @param      $uniqid                                 bool                (optional)
	 * @param      $class                                  string              (optional)
	 * @param      $onClick                                string              (optional)
	 * @param      $disabled                               bool                (optional)
	 *
	 * @return     string
	 */

	function checkbox($value,$checked,$name,$text,$uniqid=false,$class="defaultfont",$onClick="",$disabled=false,$description="",$type=0,$width=0,$html="") {
		// Get global variables
		global $l_html_forms;

		// Check if we have to create a uniqe id
		if ($uniqid) {
			$_id = uniqid($name . "_");
		} else {
			$_id = $name;
		}

		$labelonclick = "";
		if($GLOBALS['BROWSER'] == "SAFARI" && !$GLOBALS['SAFARI_3']){

			if($onClick){
				$labelonclick = str_replace("this.",'document.getElementById(\''.$_id.'\').',$onClick).";";
			}
		}

		// Create HTML tags
		$foo = '
			<table cellpadding="0" border="0" cellspacing="0">
				<tr>
					<td'.($description ? ' valign="top"' : '').'>
						<input type="checkbox" name="'.$name.'" id="'.$_id.'" value="'.$value.'" style="cursor: pointer;-moz-outline: none;" hidefocus="hidefocus" '.($checked ? " checked=\"checked\"" : "").($onClick ? " onclick=\"$onClick\"" : "").($disabled ? " disabled=\"disabled\"" : "").'></td>
					<td>
						'.getPixel(4,2).'</td>
					<td class="'.$class.'" nowrap="nowrap"><label'.(($GLOBALS['BROWSER'] == "SAFARI" && !$GLOBALS['SAFARI_3']) ? ' onclick="if(!document.getElementById(\''.$_id.'\').disabled){document.getElementById(\''.$_id.'\').checked=(document.getElementById(\''.$_id.'\').checked ? false : true);'.$labelonclick.'}"' : '').' id="label_'.$_id.'" for="'.$_id.'" style="'.($disabled ? 'color: gray; ' : 'cursor: pointer;').'-moz-user-select: none;-moz-outline: none;" hidefocus="hidefocus" unselectable="on">'.$text.'</label>'.($description ? "<br>".getPixel(1,3)."<br>".htmlAlertAttentionBox($description, $type, $width) : "").($html ? $html : "").'</td>
				</tr>
			</table>';

		// Return generated tags
		return $foo;
	}

	/**
	 * @param      $checked                                bool
	 * @param      $name                                   string
	 * @param      $text                                   string
	 * @param      $uniqid                                 bool                (optional)
	 * @param      $class                                  string              (optional)
	 * @param      $onClick                                string              (optional)
	 * @param      $disabled                               bool                (optional)
	 *
	 * @return     string
	 */

	 function checkboxWithHidden($checked, $name, $text, $uniqid = false, $class = "defaultfont", $onClick="", $disabled=false, $description="",$type=0,$width=0){
		$onClick = "this.form.elements['$name'].value=this.checked ? 1 : 0;".$onClick;
		return '<input type="hidden" name="'.$name.'" value="'.($checked ? 1 : 0).'">'.we_forms::checkbox(1, $checked, "_".$name, $text, $uniqid, $class, $onClick, $disabled, $description,$type, $width);
	}

	/**
	 * @param      $value                                  string
	 * @param      $checked                                bool
	 * @param      $name                                   string
	 * @param      $text                                   string
	 * @param      $uniqid                                 bool                (optional)
	 * @param      $class                                  string              (optional)
	 * @param      $onClick                                string              (optional)
	 * @param      $disabled                               bool                (optional)
	 *
	 * @return     string
	 */

	function radiobutton($value,$checked,$name,$text,$uniqid=true,$class="defaultfont",$onClick="",$disabled=false,$description="",$type=0,$width=0,$onMouseUp="",$extra_content="") {
		// Get global variables
		global $l_html_forms;

		// Check if we have to create a uniqe id
		if ($uniqid) {
			$_id = $name . "_" . uniqid(rand());
		} else {
			$_id = $name;
		}
		$labelonclick = "";
		if($GLOBALS['BROWSER'] == "SAFARI" && !$GLOBALS['SAFARI_3']){

			if($onClick){
				$labelonclick = str_replace("this.",'document.getElementById(\''.$_id.'\').',$onClick).";";
			}
		}

		// Create HTML tags
		$foo = '
			<table cellpadding="0" border="0" cellspacing="0">
				<tr>
					<td class="weEditmodeStyle"'.($description ? ' valign="top"' : '').'>
						<input type="radio" name="'.$name.'" id="'.$_id.'" value="'.$value.'" style="cursor: pointer;-moz-outline: none;" hidefocus="hidefocus" '.($checked ? " checked=\"checked\"" : "").($onMouseUp ? " onmouseup=\"$onMouseUp\"" : "").($onClick ? " onclick=\"$onClick\"" : "").($disabled ? " disabled=\"disabled\"" : "").'></td>
					<td class="weEditmodeStyle">
						'.getPixel(4,2).'</td>
					<td class="weEditmodeStyle '.$class.'" nowrap="nowrap"><label'.(($GLOBALS['BROWSER'] == "SAFARI" && !$GLOBALS['SAFARI_3']) ? ' onclick="if(!document.getElementById(\''.$_id.'\').disabled){document.getElementById(\''.$_id.'\').checked=true;'.$labelonclick.'}"' : '').' id="label_'.$_id.'" for="'.$_id.'" style="'.($disabled ? 'color: gray; ' : 'cursor: pointer;').'-moz-user-select: none;-moz-outline: none;" hidefocus="hidefocus" unselectable="on"'.($onMouseUp ? " onmouseup=\"".str_replace("this.","document.getElementById('".$_id."').",$onMouseUp)."\"" : "").'>'.$text.'</label>'.($description ? "<br>".getPixel(1,3)."<br>".htmlAlertAttentionBox($description, $type, $width) : "").
				($extra_content ? ("<br>".getPixel(1,3)."<br>". $extra_content) : "").'</td>
				</tr>
			</table>';
		// Return generated tags
		return $foo;
	}

	/**
	* returns the HTML Code for a webEdition Textarea (we:textarea we:sessionfield ...)
	*
	* @return string
	* @param string $name
	* @param string $value
	* @param array $attribs
	* @param string $autobr
	* @param string $autobrName
	* @param boolean $showAutobr
	* @param string $path
	* @param boolean $hidestylemenu
	* @param boolean $forceinwebedition
	* @param boolean $xml
	* @param boolean $removeFirstParagraph
	* @param string $charset
	*
	*/
	function weTextarea($name,$value,$attribs,$autobr,$autobrName,$showAutobr=true,$path="",$hidestylemenu=false,$forceinwebedition=false,$xml=false,$removeFirstParagraph=true,$charset="",$showSpell=true, $isFrontendEdit=false){
		global $IE55,$MOZ13,$SAFARI_WYSIWYG;
		if($charset == ""){
			if(isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"]->getElement("Charset")){
				$charset = $GLOBALS["we_doc"]->getElement("Charset");
			}
		}

		$out = "";
		$dhtmledit = we_getTagAttribute("dhtmledit",$attribs,"",true);	//	deprecated use wysiwyg instead
		$wysiwyg = we_getTagAttribute("wysiwyg",$attribs,"",true);

		$wysiwyg = ($dhtmledit || $wysiwyg) && ($IE55 || $MOZ13 || ($SAFARI_WYSIWYG && (defined("SAFARI_WYSIWYG") && SAFARI_WYSIWYG)));
		$cols = we_getTagAttribute("cols",$attribs);
		$rows = we_getTagAttribute("rows",$attribs);
		$width = we_getTagAttribute("width",$attribs);
		$height = we_getTagAttribute("height",$attribs);
		$commands = we_getTagAttribute("commands",$attribs);
		$bgcolor = we_getTagAttribute("bgcolor",$attribs);
		$wrap = we_getTagAttribute("wrap",$attribs);
		$hideautobr = we_getTagAttribute("hideautobr",$attribs,0,true);
		$class = we_getTagAttribute("class",$attribs);
		$style = we_getTagAttribute("style",$attribs);
		$id = we_getTagAttribute("id",$attribs);
		$inlineedit = we_getTagAttribute("inlineedit",$attribs,0,true,defined("INLINEEDIT_DEFAULT") ? INLINEEDIT_DEFAULT : true);
		$tabindex = we_getTagAttribute("tabindex",$attribs);

		$buttonpos = we_getTagAttribute("buttonpos",$attribs);

		$cssClasses = we_getTagAttribute("classes",$attribs);

		$buttonTop = false;
		$buttonBottom = false;

		if($buttonpos){
			$foo = makeArrayFromCSV($buttonpos);
			foreach($foo as $p){
				switch($p){
					case "top":
						$buttonTop = true;
						break;
					case "bottom":
						$buttonBottom = true;
						break;
				}
			}
		}
		if($buttonTop == false && $buttonBottom == false){
			$buttonBottom = true;
		}

		if($style){
			$style = eregi_replace('width:[^;"]+[;"]?','',$style);
			$style = eregi_replace('height:[^;"]+[;"]?','',$style);
			$style = trim($style);
		}
		$fontnames = we_getTagAttribute("fontnames",$attribs);
		$showmenues = we_getTagAttribute("showmenus",$attribs,"",true,true);
		if(isset($attribs["showMenues"])){ // old style compatibility
			if($attribs["showMenues"] == "off" || $attribs["showMenues"] == "false"){
				$showmenues = false;
			}
		}else if(isset($attribs["showmenues"])){ // old style compatibility
			if($attribs["showmenues"] == "off" || $attribs["showmenues"] == "false"){
				$showmenues = false;
			}
		}
		$importrtf = we_getTagAttribute("importrtf",$attribs,"",true);
		if (isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"] !="" && $GLOBALS["we_doc"]->ClassName == "we_objectFile") {
			$inwebedition = $forceinwebedition ? $forceinwebedition : (isset($GLOBALS["we_doc"]->InWebEdition) && $GLOBALS["we_doc"]->InWebEdition);
		} else {
			$inwebedition = $forceinwebedition ? $forceinwebedition : (isset($GLOBALS["WE_MAIN_DOC"]->InWebEdition) && $GLOBALS["WE_MAIN_DOC"]->InWebEdition);
		}

		$value = we_forms::removeBrokenInternalLinksAndImages($value);

		if($wysiwyg) {
			$width = $width ? $width : (abs($cols) ? (abs($cols) * 5.5) : "520");
			$height = $height ? $height : (abs($rows) ? (abs($rows) * 8) : "200");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_wysiwyg.class.inc.php");
			if(!$showmenues && (strlen($commands)==0)){
				$commands = implode(",",we_wysiwyg::getAllCmds());
				$commands = str_replace('formatblock,','',$commands);
				$commands = str_replace('fontname,','',$commands);
				$commands = str_replace('fontsize,','',$commands);
				if($hidestylemenu){
					$commands = str_replace('applystyle,','',$commands);
				}
			}
			if($hidestylemenu && (strlen($commands)==0)){
				$commands = implode(",",we_wysiwyg::getAllCmds());
				$commands = str_replace('applystyle,','',$commands);
			}


			$out .= we_wysiwyg::getHeaderHTML();

			$_lang = (isset($GLOBALS['we_doc']) && isset($GLOBALS['we_doc']->Language)) ? $GLOBALS['we_doc']->Language : WE_LANGUAGE;

			if($inlineedit){

				$e = new we_wysiwyg($name,$width,$height,$value,$commands,$bgcolor,"",$class,$fontnames,(!$inwebedition),$xml,$removeFirstParagraph,$inlineedit,"",$charset,$cssClasses,$_lang,'',$showSpell,$isFrontendEdit);
				$out .= $e->getHTML();
			}else{
				$e = new we_wysiwyg($name,$width,$height,"",$commands,$bgcolor,"",$class,$fontnames,(!$inwebedition),$xml,$removeFirstParagraph,$inlineedit,"",$charset,$cssClasses,$_lang,'',$showSpell,$isFrontendEdit);

				$fieldName = ereg_replace('^.+_txt\[(.+)\]$','\1',$name);

				// Bugfix => Workarround Bug # 7445
				if(isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"]->ClassName != "we_objectFile" && $GLOBALS["we_doc"]->ClassName != "we_object"){
					$value = $GLOBALS["we_doc"]->getField($attribs);
				} else {
					$value = parseInternalLinks($value,0);
				}
				// Ende Bugfix

				$value = str_replace("##|r##","\r",str_replace("##|n##","\n",$value));
				$out .= ($buttonTop ? '<div class="tbButtonWysiwygBorder" style="width:25;border-bottom:0px;background-image: url('.IMAGE_DIR . 'backgrounds/aquaBackground.gif);">'.$e->getHTML().'</div>' : '').'<div class="tbButtonWysiwygBorder" id="wysiwyg_div_'.$name.'">'.$value.'</div>'.($buttonBottom ? '<div class="tbButtonWysiwygBorder" style="width:25;border-top:0px;background-image: url('.IMAGE_DIR . 'backgrounds/aquaBackground.gif);">'.$e->getHTML().'</div>' : '');
			}
		} else {
			if($style && substr($style,-1) != ";"){
				$style .= ";";
			}
			if($width){
				$style .= "width:$width;";
			}
			if($height){
				$style .= "height:$height;";
			}

			if($showAutobr || $showSpell){
				$clearval = $value;
				$value = str_replace("<?","##|lt;?##",$value);
				$value = eregi_replace("<script","<##scr#ipt##",$value);
				$value = eregi_replace("</script","</##scr#ipt##",$value);
				$value = str_replace("\\","\\\\",$value);
				$value = str_replace("\n","\\n",$value);
				$value = str_replace("\r","\\r",$value);
				$value = str_replace('"',"\\\"",$value);
				$out .= '<script language="JavaScript" type="text/javascript">
	new we_textarea("'.$name.'","'.$value.'","'.$cols.'","'.$rows.'","'.$width.'","'.$height.'","'.$autobr.'","'.$autobrName.'",'.($showAutobr ? ($hideautobr ? "false" : "true") : "false").','.($importrtf ? "true" : "false").',"'.$GLOBALS["WE_LANGUAGE"].'","'.$class.'","'.$style.'","'.$wrap.'","'.(($GLOBALS["BROWSER"]=="SAFARI") ? "onkeydown" : "onchange").'","'.($xml ? "true" : "false").'","'.$id.'",'.((defined('SPELLCHECKER') && $showSpell) ? "true" : "false").');</script>'.
	'<noscript><textarea name="'.$name.'"'.($tabindex ? ' tabindex="'.$tabindex.'"' : '').($cols ? ' cols="'.$cols.'"' : '').($rows ? ' rows="'.$rows.'"' : '').($style ? ' style="'.$style.'"' : '').($class ? ' class="'.$class.'"' : '').($id ? ' id="' . $id . '"' : '').'>'.htmlspecialchars($clearval).'</textarea></noscript>';
			}else{
				$out .= '<textarea name="'.$name.'"'.($tabindex ? ' tabindex="'.$tabindex.'"' : '').($cols ? ' cols="'.$cols.'"' : '').($rows ? ' rows="'.$rows.'"' : '').($style ? ' style="'.$style.'"' : '').($class ? ' class="'.$class.'"' : '').($id ? ' id="'.$id.'"' : '').'>'.htmlspecialchars($value).'</textarea>';
			}
		}
		return $out;
	}


	function removeBrokenInternalLinksAndImages(&$text) {
		$DB_WE = new DB_WE();
		if(preg_match_all('/(href|src)="document:([^" \?#]+)/i',$text,$regs,PREG_SET_ORDER)){
			for($i=0;$i<sizeof($regs);$i++) {
				$foo = getHash("
						SELECT Path
						FROM " . FILE_TABLE . "
						WHERE ID='".$regs[$i][2]."'",$DB_WE);
				if(!$foo["Path"]){
					$text = eregi_replace('<a [^>]*href="document:'.$regs[$i][2].'"[^>]*>([^<]+)</a>','\1',$text);
					$text = eregi_replace('<a [^>]*href="document:'.$regs[$i][2].'"[^>]*>','',$text);
					$text = eregi_replace('<img [^>]*src="document:'.$regs[$i][2].'"[^>]*>','',$text);
				}
			}
		}
		if(preg_match_all('/src="thumbnail:([^" ]+)/i',$text,$regs,PREG_SET_ORDER)){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
			for($i=0;$i<sizeof($regs);$i++) {
				list($imgID,$thumbID) = explode(",",$regs[$i][1]);
				$thumbObj = new we_thumbnail();
				if(!$thumbObj->initByImageIDAndThumbID($imgID,$thumbID)){
					$text = eregi_replace('<img[^>]+src="thumbnail:'.$regs[$i][1].'[^>]+>','',$text);
				}
			}
		}
		if(defined("OBJECT_TABLE")){
			if(preg_match_all('/href="object:([^" \?#]+)(\??)/i',$text,$regs,PREG_SET_ORDER)){
				for($i=0;$i<sizeof($regs);$i++) {
					if(!id_to_path($regs[$i][1],OBJECT_FILES_TABLE)){ // if object doesn't exists, remove the link
						$text = eregi_replace('<a [^>]*href="object:'.$regs[$i][1].'"[^>]*>([^<]+)</a>','\1',$text);
						$text = eregi_replace('<a [^>]*href="object:'.$regs[$i][1].'"[^>]*>','',$text);
					}
				}
			}
		}

		return $text;
	}
}

?>