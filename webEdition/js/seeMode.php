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

header("Content-Type: text/javascript");
include_once( $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_defines.inc.php" );

$useSeeModeJS = array(
	"text/webedition" => array(WE_EDITPAGE_CONTENT),
	"text/weTmpl" => array(WE_EDITPAGE_PREVIEW, WE_EDITPAGE_PREVIEW_TEMPLATE)
	
);
$includeJs = false;


if ( isset($_REQUEST["EditPage"]) && isset($_REQUEST["ContentType"]) ) {
	
	if (isset($useSeeModeJS[$_REQUEST["ContentType"]])) {
		if ( in_array( $_REQUEST["EditPage"], $useSeeModeJS[$_REQUEST["ContentType"]] ) ) {
			$includeJs = true;
			
		}
	}
}
unset($useSeeModeJS);

if (!$includeJs) {
	exit;
}
?>

function seeMode_dealWithLinks() {
	
	var _aTags = document.getElementsByTagName("a");
	
	for (i=0; i<_aTags.length; i++) {
		
		var _href = _aTags[i].href;
		
		if (	!(	_href.indexOf("javascript:") === 0
					|| _href.indexOf("#") === 0
					|| _href.indexOf("mailto:") === 0
					|| _href.indexOf("document:") === 0
					|| _href.indexOf("object:") === 0
					|| _href.indexOf("?") === 0
				)
		){
			_aTags[i].href = "javascript:seeMode_clickLink('" + _aTags[i].href + "')";
			
		}
	}
}

function seeMode_clickLink ( url ) {
	top.we_cmd("open_url_in_editor", url);
	
} 

// add event-Handler, replace links after load
if ( window.addEventListener ) {
	window.addEventListener("load", seeMode_dealWithLinks, false);
} else if ( window.attachEvent ){
	window.attachEvent("onload", seeMode_dealWithLinks);
}