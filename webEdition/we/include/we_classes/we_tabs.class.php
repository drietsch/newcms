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

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_browserDetect.inc.php');

class we_tab {
	
	var $href;
	var $text;
	var $state;
	var $javaScript;
	
	function we_tab($href, $text, $state, $javaScript) {
		
		$this->href = $href;
		$this->text = $text;
		$this->state = $state;
		$this->javaScript = $javaScript;
	}
	
	function getJsCode() {
		
	}
}


class we_tabs {
	
	var $client ='';
	var $tabs = array();
	
	
	function we_tabs() {
		
		$detect = new we_browserDetect();
		$this->client = $detect->getBrowser();
	}
	
	function addTab($tab) {
		
		$this->tabs[] = $tab;
	}
	
	function getHeader($suffix='', $offset=15) {
		
		$hoverOff = '_normal'; // :ATTENTION: these are also defined in js-file
		$hoverTab = '_hover'; // :ATTENTION: these are also defined in js-file
		
		$strImgBg = 'tab_middle'; // :ATTENTION: these are also defined in js-file
		
		$head = we_htmlElement::jsElement("
		
			var TAB_DISABLED = 0;
			var TAB_NORMAL   = 1;
			var TAB_ACTIVE   = 2;
		
			var js_path  = '" . JS_DIR . "';
			var img_path = '" . IMAGE_DIR . "tabs/';
			var suffix   = '$suffix';
			var layerPosYOffset = $offset;

		");
		
		$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "we_tabs/images.js")) . "\n";
		$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "utils/lib.js")) . "\n";
		$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "utils/dimension.js")) . "\n";
		
		switch ($this->client) {
			case "ie":
				$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "layers/layersIE.js")) . "\n";
			break;
			
			default :
				$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "layers/layersNS6.js")) . "\n";
			break;
		}
		$head .= we_htmlElement::jsElement("", array("src" => JS_DIR . "we_tabs/tabs.js")) . "\n";

		$head .= '<link rel="stylesheet" type="text/css" href="' . CSS_DIR . 'we_tab' . $suffix . '.css" />';

		return $head;
	}
	
	function getJS() {
		
		$js = '
		var winWidth  = getWindowWidth(window);
		var winHeight = getWindowHeight(window);
	
		var we_tabs = new Array();
		';
		
		foreach ($this->tabs as $tab) {
			$js .= 'we_tabs.push(new We_Tab("' . $tab->href . '", "' . $tab->text . '",' . $tab->state .',"' . $tab->javaScript . '"));
			';
		}
		$js .= '
		we_tabInit();
		';
		return we_htmlElement::jsElement($js);
	}
	
	function getJSRebuildTabs() {
		$js = <<<JSCODE
var lastWinWidth = winWidth | 0;
function rebuildTabs() {
	winWidth  = getWindowWidth(parent.parent.window);
	winHeight = getWindowHeight(parent.parent.window);
	if(winWidth>0 && lastWinWidth != winWidth) {
		for (i=0;i<tabCtrls.length;i++) {
			document.body.removeChild(document.getElementById('tabCtrl_'+i));
		}
		we_tabInit();
		lastWinWidth = winWidth;
	}
}
JSCODE;
		return we_htmlElement::jsElement($js);
	}
}
?>