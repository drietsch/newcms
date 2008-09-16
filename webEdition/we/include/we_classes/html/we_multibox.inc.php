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


include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");

class we_multiIconBox{

	function we_multiIconBox(){
		exit( "This is a static class, it doesn't make sence to call the cunstructor of this class!");
	}

   /**
	* @desc 	Get HTML-Code of the multibox
	* @param	$name				string
	* @param	$width				int
	* @param	$content			array
	* @param	$buttons			string
	* @param	$foldAtNr			int
	* @param	$foldRight			unknown
	* @param	$foldDown			unknown
	* @param	$displayAtStartup	bool
	* @param	$headline			string
	* @return	string
 	*/
	function getHTML($name,$width, $content, $marginLeft="0", $buttons="", $foldAtNr=-1, $foldRight="", $foldDown="", $displayAtStartup=false, $headline = "", $delegate = "", $height = "", $overflow = "auto"){
		$we_button = new we_button();
		$uniqname = $name ? $name : md5(uniqid(rand(), true));

		if(isset($headline) && $headline != ""){
			$out = we_multiIconBox::_getBoxStartHeadline($width, $headline, $uniqname, $marginLeft,$overflow);
		} else {
			$out = we_multiIconBox::_getBoxStart($width, $uniqname);
		}


		foreach($content as $i => $c){

			if($i==$foldAtNr && $foldAtNr < sizeof($content)){ // only if the folded items contain stuff.
				$but = we_multiIconBox::_getButton($uniqname,($delegate ? $delegate : "" ). ";weToggleBox('$uniqname','".addslashes($foldDown)."','".addslashes($foldRight)."')",($displayAtStartup ? "down" : "right"),$GLOBALS["l_global"]["openCloseBox"]);
				$out .= $we_button->create_button_table(
												array(
													$but,
														'<span style="cursor: pointer;-moz-user-select: none;" class="defaultfont" id="text_'.$uniqname.'" onClick="'.($delegate ? $delegate : "" ).';weToggleBox(\''.$uniqname.'\',\''.addslashes($foldDown).'\',\''.addslashes($foldRight).'\');" unselectable="on">'.($displayAtStartup ? $foldDown : $foldRight).'</span>'
													), 10, array('style'=>'margin-left:'.$marginLeft.'px;')

														);
				$out .= '<br><table id="table_'.$uniqname.'" width="100%" cellpadding="0" cellspacing="0" border="0" style="display:'.($displayAtStartup ? "" : "none").'"><tr><td>';
			}

			$_forceRightHeadline = (isset($c["forceRightHeadline"]) && $c["forceRightHeadline"]);

			$icon = (isset($c["icon"]) && $c["icon"])  ?
						('<img src="'.IMAGE_DIR . 'icons/' . $c["icon"].'" alt="" style="margin-left:20px;">')
						:
						 "";
			$headline = (isset($c["headline"]) && $c["headline"]) ?
							('<div  id="'.$uniqname.'_headline_'.$i.'" class="weMultiIconBoxHeadline" style="margin-bottom:10px;">'.$c["headline"].'</div>')
							:
							"";


			$mainContent = (isset($c["html"]) && $c["html"]) ? $c["html"] : "";

			$leftWidth = (isset($c["space"]) && $c["space"]) ? abs($c["space"]) : 0;

			$leftContent = $icon ? $icon : (($leftWidth && (!$_forceRightHeadline)) ? $headline : "");

			$rightContent = '<div style="float:left;" class="defaultfont">' . ((($icon && $headline) || ($leftContent === "") || $_forceRightHeadline) ? ($headline . '<div>' . $mainContent . '</div>') : '<div>' . $mainContent . '</div>')  . '</div>';

			$out .= '<div style="margin-left:'.$marginLeft.'px" id="'.$uniqname.'_div_'.$i.'">';

			if ($leftContent || $leftWidth) {
				if ((!$leftContent) && $leftWidth) {
					$leftContent = "&nbsp;";
				}
				$out .= '<div style="float:left;width:'.$leftWidth.'px">' . $leftContent . '</div>';
			}

			$out .=	$rightContent ;
			$out .= '<br style="clear:both;">';


			$out .= '</div>'. (($GLOBALS["BROWSER"] == "IE") ? '<br>' : '');

			if($i < (count($content) - 1) && (!isset($c["noline"]))){
				$out .= '<div style="border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;"></div>';
			} else {
				$out .= '<div style="margin:10px 0;clear:both;"></div>';
			}



		}

		if($foldAtNr >= 0  && $foldAtNr < sizeof($content)){
			$out .= '</td></tr></table>';
		}

		$boxHTML = $out.we_multiIconBox::_getBoxEnd($width);

		if($buttons){
			$buttonsHTML = '<div style="left:0;height:40px;background-image: url(/webEdition/images/edit/editfooterback.gif);position:absolute;bottom:0;width:100%"><div style="padding: 10px 10px 0 0;">'.$buttons . '</div></div>';
			return '<div style="overflow:'.$overflow.';position:absolute;width:100%;'.($height ? 'height:'.$height.'px;' : '').'top:0;left:0;">'. $boxHTML . '</div>' . $buttonsHTML;
		}else{
			return $boxHTML;
		}

	}

	function getJS(){
		return '

		<script language="JavaScript" type="text/javascript"><!--

			function weToggleBox(name,textDown,textRight){
				var t = document.getElementById(\'table_\'+name);
				var s = document.getElementById(\'text_\'+name);
				var b = document.getElementById(\'btn_direction_\'+name+\'_middle\');
				if(t.style.display == "none"){
					t.style.display = "";
					s.innerHTML = textDown;
					b.style.background="url('.BUTTONS_DIR.'btn_direction_down.gif)";
					weSetCookieVariable("but_"+name,"down")
				}else{
					t.style.display = "none";
					s.innerHTML = textRight;
					b.style.background="url('.BUTTONS_DIR.'btn_direction_right.gif)";
					weSetCookieVariable("but_"+name,"right")
				}
			}

			function weGetCookieVariable(name){
				var c = weGetCookie("we' . session_id() . '");
				var vals = new Array();
				if(c != null){
					var parts = c.split(/&/);
					for(var i=0; i<parts.length; i++){
						var foo = parts[i].split(/=/);
						vals[unescape(foo[0])]=unescape(foo[1]);
					}
					return vals[name];
				}
				return null;
			}
			function weGetCookie(name){
				var cname = name + "=";
				var doc = (top.name == "edit_module") ? top.opener.top.document : top.document;
				var dc = doc.cookie;
				if (dc.length > 0) {
					begin = dc.indexOf(cname);
					if (begin != -1) {
						begin += cname.length;
						end = dc.indexOf(";", begin);
						if (end == -1) {
							end = dc.length;
						}
						return unescape(dc.substring(begin, end));
					}
				}
				return null;
			}

			function weSetCookieVariable(name,value){
				var c = weGetCookie("we'. session_id() .'");
				var vals = new Array();
				if(c != null){
					var parts = c.split(/&/);
					for(var i=0; i<parts.length; i++){
						var foo = parts[i].split(/=/);
						vals[unescape(foo[0])]=unescape(foo[1]);
					}
				}
				vals[name] = value;
				c = "";
				for (var i in vals) {
					c += escape(i)+"="+escape(vals[i])+"&";
				}
				if(c.length > 0){
					c=c.substring(0,c.length-1);
				}
				weSetCookie("we' . session_id() .'", c);
			}
			function weSetCookie(name, value, expires, path, domain){
				var doc = (top.name == "edit_module") ? top.opener.top.document : top.document;
				doc.cookie = name + "=" + escape(value) +
				((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
				((path == null)    ? "" : "; path=" + path) +
				((domain == null)  ? "" : "; domain=" + domain);
			}

		//-->
		</script>';

	}

	function getDynJS($uniqname="", $marginLeft="0"){
		return '<script language="JavaScript" type="text/javascript"><!--
			if(navigator.product == "Gecko"){
				var CELLPADDING = "cellpadding";
				var CELLSPACING = "cellspacing";
				var CLASSNAME = "classname";
				var VALIGN = "valign";
			}else{
				var CELLPADDING = "cellPadding";
				var CELLSPACING = "cellSpacing";
				var CLASSNAME = "className";
				var VALIGN = "vAlign";
			}

			function weGetMultiboxLength(){

				var divs = document.getElementsByTagName("DIV");
				var prefix =  "'.$uniqname.'_div_";
				var z = 0;
				for(var i = 0; i<divs.length; i++){
					if(divs[i].id.length > prefix.length && divs[i].id.substring(0,prefix.length) == prefix){
						z++;
					}
				}
				return z;
			}
			function weGetLastMultiboxNr(){

				var divs = document.getElementsByTagName("DIV");
				var prefix =  "'.$uniqname.'_div_";
				var num = -1;
				for(var i = 0; i<divs.length; i++){
					if(divs[i].id.length > prefix.length && divs[i].id.substring(0,prefix.length) == prefix){
						num = divs[i].id.substring(prefix.length,divs[i].id.length);
					}
				}
				return parseInt(num);
			}

			function weDelMultiboxRow(nr){
				var div = document.getElementById("'.$uniqname.'_div_"+nr);
				var mainTD = document.getElementById("'.$uniqname.'_td");
				mainTD.removeChild(div);
			}

			function weAppendMultiboxRow(content,headline,icon,space,insertRuleBefore){
				var lastNum = weGetLastMultiboxNr();
				var i = (lastNum + 1);
				icon = icon  ? (\'<img src="'.IMAGE_DIR . 'icons/\' + icon + \'" width="64" height="64" alt="" style="margin-left:20px;">\') : "";
				headline = headline ? (\'<div  id="'.$uniqname.'_headline_\'+ i + \'" class="weMultiIconBoxHeadline" style="margin-bottom:10px;">\' + headline + \'</div>\') : "";

				var mainContent = content ? content : "";
				var leftWidth = space ? space : 0;
				var leftContent = icon ? icon : (leftWidth ? headline : "");
				var rightContent = \'<div style="float:left;" class="defaultfont">\' + (((icon && headline) || (leftContent == "")) ? (headline + \'<div>\' + mainContent + \'</div>\') : mainContent)  + \'</div>\';

				var mainDiv = document.createElement("DIV");
				mainDiv.style.cssText = \'margin-left:'.$marginLeft.'px\';
				mainDiv.id="'.$uniqname.'_div_" + i;
				var innerHTML = "";

				if (leftContent || leftWidth) {
					if ((!leftContent) && leftWidth) {
						leftContent = "&nbsp;";
					}
					innerHTML += \'<div style="float:left;width:\' + leftWidth + \'px">\' + leftContent + \'</div>\';
				}
				innerHTML += rightContent;
				innerHTML += \'<br style="clear:both;">\';
				mainDiv.innerHTML = innerHTML;

				var mainTD = document.getElementById("'.$uniqname.'_td");
				mainTD.appendChild(mainDiv);

' . (($GLOBALS["BROWSER"] == "IE") ? 'mainTD.appendChild(document.createElement("BR"));' : '') . '

				var lastDiv = document.createElement("DIV");
				lastDiv.style.cssText = "margin:10px 0;clear:both;";
				mainTD.appendChild(lastDiv);

				if(insertRuleBefore && (lastNum != -1)){
					var rule = document.createElement("DIV");
					rule.style.cssText = "border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;";
					var preDIV = document.getElementById("'.$uniqname.'_div_"+lastNum);
					preDIV.appendChild(rule);
				}

			}
		//-->
		</script>
';
	}

function _getBoxStartHeadline($width, $headline, $uniqname, $marginLeft="0", $overflow="auto"){
		return '<table width="'.$width.'" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;width:'.$width.'; overflow:'.$overflow.'">
	<tr>
		<td style="padding-left:'.$marginLeft.'px;padding-bottom:10px;" class="weDialogHeadline">'.$headline.'</td>
	</tr>
	<tr>
		<td>'.getPixel(2,8).'</td>
	</tr>
	<tr>
		<td id="'.$uniqname.'_td">';
	}

	function _getBoxStart($w, $uniqname){
			if (strpos($w,"%") === false) {
				$wp = abs($w) . "px";
			} else {
				$wp = $w;
			}
			return '<table width="'.$w.'" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;width:'.$wp.';">
	<tr>
		<td class="defaultfont"><b>'.getPixel($w,2).'</b></td>
	</tr>
	<tr>
		<td id="'.$uniqname.'_td">';
	}


	function _getBoxEnd($w){
		return '</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
';
	}

	function _getButton($name, $cmd, $state="right", $title=""){
		return '<script language="JavaScript" type="text/javascript">weSetCookieVariable("but_'.$name.'","'.$state.'");var btn_direction_'.$name.'_mouse_event = false;</script><table cellpadding="0" cellspacing="0" border="0" style="cursor: pointer; width: 21px;" id="btn_direction_'.$name.'_table" onmouseover="window.status=\'\';return true;"  onmouseup="document.getElementById(\'btn_direction_'.$name.'_middle\').style.background = \'url('.BUTTONS_DIR.'btn_direction_\'+weGetCookieVariable(\'but_'.$name.'\')+\'.gif)\';btn_direction_'.$name.'_mouse_event = false;'.$cmd.';"><tr title="'.$title.'" style="height: 22px;"><td align="center" id="btn_direction_'.$name.'_middle" style="background-image:url('.BUTTONS_DIR.'/btn_direction_'.$state.'.gif);width: 21px;" nowrap="nowrap">'.getPixel(21,22).'</td></tr></table>';
	}


}

?>