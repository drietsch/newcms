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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_browserDetect.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_tab.class.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/"."we.inc.php");

class we_tabs {

	var $heightPlus;
	var $textvalign;
	var $imgmargintop;
	var $imgvalign;
	var $frameDefaultHeight;
	var $tabBorder;
	var $tabBG;
	var $containerStart;
	var $container;
	var $containerEnd;
	var $head;
	var $bodyAttribs;
	var $JSonResize;

	function we_tabs() {
		global $BROWSER, $SYSTEM;
		$this->containerStart = '<div id="tabContainer" name="tabContainer">';
		$this->containerEnd   = "</div>\n";

		switch ($BROWSER) {
			case "SAFARI":
				$this->heightPlus = "";
				$this->textvalign = "top";
				$this->frameDefaultHeight = 21;
				$this->tabBorder = "border:0px;";
				$this->tabBG ="";
				break;
			case "IE":
				$this->heightPlus = "";
				$this->textvalign = "middle";
				$this->frameDefaultHeight = 21;
				$this->tabBorder = "border:0px;";
				$this->tabBG ="background-position:bottom; ";
				break;
			default:
				$this->heightPlus = "";
				$this->textvalign = "top";
				$frameDefaultHeight = 21;
				$this->tabBorder = "border: 0px;";
		}
	}

	function addTab($tab) {
		$this->container .= $tab->getHTML();
	}

	function getHeader() {
		$tabBorder = $this->tabBorder;
		$tabBG = $this->tabBG;
		$styles = <<<HTS
body {
	margin:0px; padding:0px;
	border: 0px;
	font-family: Verdana, Arial, sans-serif;
	font-size: 10px;
	color: #000000;
}
#tabContainer{
	width:100%;
	margin: 0px; padding: 0;
	border: 0px;
	background-image:url(/webEdition/images/multiTabs/tabsBG_border.gif);
	overflow:hidden;
}
div.tabNormal {
	margin: 0px; padding: 0;
	$tabBorder
	float:left;
	display: inline;
	background-image:url(/webEdition/images/multiTabs/tabsBG_normal.gif);
	background-repeat: repeat-x;
	$tabBG
	line-height:21px;
	font-size:17px;
	cursor:pointer;
}
div.tabActive {
	margin: 0px; padding: 0;
	$tabBorder
	float:left;
	display: inline;
	background-image:url(/webEdition/images/multiTabs/tabsBG_active2.gif);
	background-repeat: repeat-x;
	$tabBG
	line-height:21px;
	font-size:17px;
	cursor:pointer;
}
span.text{
	margin:0px; padding:0px;
	font-size: 10px;
	vertical-align:{$this->textvalign};
}
span.spacer{
	font-size: 17px;
	vertical-align:{$this->textvalign};
}

HTS;

		$script = <<<HTS

var resizeDummy = 1;
var titlePathName="";
var titlePathGroup="";
var hasPathName=false;
var hasPathGroup=false;

function setActiveTab(tab) {
	var tabCon = document.getElementById('tabContainer');
	docTabs = tabCon.getElementsByTagName('DIV');
	for(i=0; i<docTabs.length; i++) {
		docTabs[i].className = "tabNormal";
	}
	document.getElementById(tab).className = "tabActive";
}


function setTabClass(elem) {
		var arr = new Array();
		var els = document.getElementsByTagName("*");
		for(var i=0; i<els.length; i++){
			if(els[i].className == "tabActive"){
				els[i].className = "tabNormal";
			}
		}
		elem.className = "tabActive";
}

function allowed_change_edit_page() {
	try	{
		var contentEditor = top.opener.top.opener && top.opener.top.opener.top.weEditorFrameController ? top.opener.top.opener.top.weEditorFrameController.getVisibleEditorFrame() : top.opener && top.opener.top.weEditorFrameController ? top.opener.top.weEditorFrameController.getVisibleEditorFrame() : top.weEditorFrameController.getVisibleEditorFrame();
		if ( contentEditor && contentEditor.fields_are_valid ) {
			return contentEditor.fields_are_valid();
		
		}
	}
	catch(e) {
		// Nothing
	}
	return true;
}

function setTitlePath(){
	if(titleElem = document.getElementById('titlePath')) {
		titlePathName = titlePathName.replace(/</g,"&lt;");
		titlePathName = titlePathName.replace(/>/g,"&gt;");
		titlePathGroup = titlePathGroup.replace(/</g,"&lt;");
		titlePathGroup = titlePathGroup.replace(/>/g,"&gt;");
		titleElem.innerHTML = titlePathGroup + ((titlePathGroup == "/" || titlePathName=="") ? "" : "/") + titlePathName;
	}
}

function setPathName(pathName) {
	if(hasPathName) titlePathName = pathName;
}

function setPathGroup(pathGroup) {	
	if(hasPathGroup) titlePathGroup = pathGroup;
}

var __weEditorFrameController = (top.opener.top.opener && top.opener.top.opener.top.weEditorFrameController) ? top.opener.top.opener.top.weEditorFrameController : (top.opener && top.opener.top.weEditorFrameController) ? top.opener.top.weEditorFrameController : top.weEditorFrameController; 

if (__weEditorFrameController.getVisibleEditorFrame() || (parent.frames && parent.frames[1])) {
	setTimeout("getPathInfos()",250);
}

var loop = 0;

function getPathInfos(){
	try	{
		var contentEditor = __weEditorFrameController.getVisibleEditorFrame();
		
		if (contentEditor == null && parent.frames) {
			contentEditor = parent.frames[1];
		}
	
		if(contentEditor.loaded) {
			if(pathNameElem = contentEditor.document.getElementById('yuiAcInputPathName')) {
				hasPathName   = true;
				titlePathName = pathNameElem.value;
			}
			if(pathGroupElem = contentEditor.document.getElementById('yuiAcInputPathGroup')) {
				hasPathGroup   = true;
				titlePathGroup = pathGroupElem.value;
			}
			loop=0;
		} else if(loop<10) {
			loop++;
			setTimeout("getPathInfos()",250);
		}
	}
	catch(e) {
		// Nothing
	}
}

{$this->JSonResize}

HTS;

		$out = we_htmlElement::cssElement($styles);
		$out.= we_htmlElement::jsElement($script);
		$out.= we_htmlElement::jsElement("", array("src" => JS_DIR . "attachKeyListener.js"));

		return $out;
	}

	function getHTML() {
		return $this->containerStart . $this->container . $this->containerEnd;
	}

	/***********************************************************************************************/


	function getJS() {

	}

	function getJSRebuildTabs() {

	}

	/***********************************************************************************************/


	function onResize() {
		$heightPlus = $this->heightPlus;
		$this->JSonResize = <<<HTS

function setFrameSize(){
	if(document.getElementById('tabContainer').offsetWidth > 0) {
		var fs = parent.document.getElementsByTagName("FRAMESET")[0];
		//document.getElementById('main').style.overflow = "hidden";
		var tabsHeight = document.getElementById('main').offsetHeight $heightPlus;
		var fsRows = fs.rows.split(',');
		fsRows[0] = tabsHeight;
		fs.rows =  fsRows.join(",");
	} else {
		setTimeout("setFrameSize()",100);
	}
}

HTS;

	}

	function addJS() {

	}

	function addCSS() {

	}

}
?>