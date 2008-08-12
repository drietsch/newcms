<?php

/* this file contains vertical tabs
 * it has variables:
 * - $allTabs => array of all tabnames
 * - $activeTab => current selected tab
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

// initialise tabs
$tabs = new we_tabs();
foreach ($this->Data['allTabs'] as $tabname) {
	
	$tabs->addTab(new we_tab("#", $GLOBALS['l_liveUpdate']['tabs'][$tabname], ($this->Data['activeTab'] == $tabname ? "TAB_ACTIVE" : "TAB_NORMAL"), "top.frames.updatecontent.location='?section=$tabname';"));
}


// get output
$tabs->onResize();
$_tabHead  = $tabs->getHeader();
$_tabJs = $tabs->getJS();

$bodyContent =	'<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;" id="headrow">' . getPixel(100,10) . '</div>' . getPixel(100,3) .
			$tabs->getHTML() . 
			'</div>';

$_body = we_htmlElement::htmlBody(	array(	"bgcolor"    => "#ffffff",
											"topmargin"  => "0",
											"background" => IMAGE_DIR . "backgrounds/header.gif",
											"onload"=>"setFrameSize();", 
											"onresize"=>"setFrameSize()"),
									$bodyContent);
									
print we_htmlElement::htmlHtml(we_htmlElement::htmlHead($_tabHead) . "\n" . $_body);

?>