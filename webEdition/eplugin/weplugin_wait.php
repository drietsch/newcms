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


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");	
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/eplugin.inc.php");
	protect();
	
	$_callback = getRequestVar('callback','');
	
	$js=we_htmlElement::jsElement('
		
		var wait_count = 0;
		var wait_retry = 40;
	
		function nojava() {
				alert("'.$l_eplugin['no_java'].'");
				top.opener.top.plugin.location="' .WEBEDITION_DIR . '/html/white.html";	
				self.close();
		}
	
		function checkPlugin() {
			if(top.opener.top.plugin.isLoaded && typeof(top.opener.top.plugin.document.WePlugin)!="undefined") {
				if(typeof(top.opener.top.plugin.document.WePlugin.isLive)!="undefined") {
					' . (!empty($_callback) ? ('eval("top.opener.' . $_callback . '");') : '') . '
					self.close();
				} else {
					nojava();
				}
			} else {
				wait_count ++;
				if(wait_count<wait_retry) {
					setTimeout("checkPlugin()",1000);
				} else {
					nojava();
				}
			}

		}
		
		function initPlugin() {
			top.opener.top.plugin.location="' .WEBEDITION_DIR . '/eplugin/weplugin.inc.php";
		}
	
		self.focus();
	');	
	$css='<link href="/webEdition/css/global.php?WE_LANGUAGE='.$GLOBALS["WE_LANGUAGE"].'" rel="styleSheet" type="text/css">';
		
	print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead($css."\n".$js).
			we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","leftmargin"=>"20","topmargin"=>"20","marginheight"=>"20","marginwidth"=>"20","onload"=>"initPlugin();checkPlugin()"),
							we_htmlElement::htmlForm(array("name"=>"we_form"),
									we_htmlElement::htmlCenter(
										we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."/spinner.gif")).
										we_htmlElement::htmlBr().
										we_htmlElement::htmlBr().
										we_htmlElement::htmlDiv(array("class"=>"header_small"),$l_eplugin["initialisation"])
									)
							)
			)
	);

?>