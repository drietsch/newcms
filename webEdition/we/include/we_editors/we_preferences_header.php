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


/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/prefs.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

print STYLESHEET;

$tabname = isset($_REQUEST["tabname"]) && $_REQUEST["tabname"]!="" ? $_REQUEST["tabname"] : "setting_ui";
/*****************************************************************************
 * GENERATE JAVASCRIPT
 *****************************************************************************/


// generate the tabs

$we_tabs = new we_tabs();

$we_tabs->addTab(new we_tab("#", $l_prefs["tab_ui"], ($tabname=="setting_ui" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('ui');"));


if (we_hasPerm("ADMINISTRATOR") || we_hasPerm("NEW_TEMPLATE")) {
	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_cache"], ($tabname=="setting_cache" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('cache');"));
}

if (we_hasPerm("EDIT_SETTINGS_DEF_EXT") && !(defined("ISP_VERSION") && ISP_VERSION)) {
	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_extensions"], ($tabname=="setting_extensions" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('extensions');"));
}

if( !(defined("ISP_VERSION") && ISP_VERSION) ){
	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_editor"], ($tabname=="setting_editor" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('editor');"));
}

if (we_hasPerm("ADMINISTRATOR")) {
    if( !(defined("ISP_VERSION") && ISP_VERSION) ){
		$we_tabs->addTab(new we_tab("#", $l_prefs["tab_proxy"], ($tabname=="setting_proxy" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('proxy');"));
    }
    $we_tabs->addTab(new we_tab("#", $l_prefs["tab_advanced"], ($tabname=="setting_advanced" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('advanced');"));
    $we_tabs->addTab(new we_tab("#", $l_prefs["tab_system"], ($tabname=="setting_system" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('system');"));
    $we_tabs->addTab(new we_tab("#", $l_prefs["module_activation"]["headline"], ($tabname=="setting_active_integrated_modules" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('active_integrated_modules');"));
	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_language"], ($tabname=="setting_language" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('language');"));

 	if( !(defined("ISP_VERSION") && ISP_VERSION) ){
		$we_tabs->addTab(new we_tab("#", $l_prefs["tab_error_handling"], ($tabname=="tab_error_handling" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('error_handling');"));
	}
	if( !(defined("ISP_VERSION") && ISP_VERSION) ){
		$we_tabs->addTab(new we_tab("#", $l_prefs["backup"], ($tabname=="setting_backup" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('backup');"));
	}
	if( !(defined("ISP_VERSION") && ISP_VERSION) ){
		$we_tabs->addTab(new we_tab("#", $l_prefs["validation"], ($tabname=="setting_validation" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('validation');"));
	}
	if(we_hasPerm("ADMINISTRATOR")) {
    	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_email"], ($tabname=="setting_email" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('email');"));
	}
	
}
// add message_reporting tab
	$we_tabs->addTab(new we_tab("#", $l_prefs["message_reporting"]["headline"], ($tabname=="setting_message_reporting" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('message_reporting');"));

if(we_hasPerm("FORMMAIL")) {
    $we_tabs->addTab(new we_tab("#", $l_prefs["tab_formmail"], ($tabname=="setting_recipients" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('recipients');"));
}
if(we_hasPerm("ADMINISTRATOR")) {
    	$we_tabs->addTab(new we_tab("#", $l_prefs["tab_versions"], ($tabname=="setting_versions" ? 'TAB_ACTIVE' : 'TAB_NORMAL'), "top.we_cmd('versions');"));
}
$we_tabs->onResize('we_preferences_header');
$tab_head = $we_tabs->getHeader('', 1);
$tab_js = $we_tabs->getJS();

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/
$bodyContent = '<div id="main" >' . $we_tabs->getHTML() . '</div>';

print $tab_head . '</head>';
print we_htmlElement::htmlBody(array("bgcolor" => "#ffffff", "background" => IMAGE_DIR . "backgrounds/header.gif", "marginwidth" => "0", "marginheight" => "0", "leftmargin" => "0", "topmargin" => "0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"), $bodyContent);

?></html>