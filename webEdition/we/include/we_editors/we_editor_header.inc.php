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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/weModuleInfo.class.php");

protect();
htmlTop();

// init document
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

$z=0;
$tab_head = "var weTabs;\n";
$tab_js = '';

if ($_SESSION["we_mode"] != "seem"){	//	No tabs in Super-Easy-Edit_mode

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

	$we_tabs = new we_tabs();
	// user has no access to file - only preview mode.
	if( $we_doc->userHasAccess() != 1 && $we_doc->userHasAccess() != -4) {
		if(in_array(WE_EDITPAGE_PREVIEW,$we_doc->EditPageNrs)){
			$we_tabs->addTab(new we_tab("#", $l_we_class["preview"],(($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_PREVIEW)));
		}
	} else {	//	show tabs according to permissions
		if(in_array(WE_EDITPAGE_PROPERTIES,$we_doc->EditPageNrs)){
			if(we_hasPerm("CAN_SEE_PROPERTIES")){

				$we_tabs->addTab(new we_tab("#", $l_we_class["tab_properties"],(($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_PROPERTIES . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_PROPERTIES)));
			}
		}
		if(in_array(WE_EDITPAGE_CONTENT,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["edit"],(($we_doc->EditPageNr == WE_EDITPAGE_CONTENT) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_CONTENT . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_CONTENT)));

		}

		if(in_array(WE_EDITPAGE_IMAGEEDIT,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["edit_image"],(($we_doc->EditPageNr == WE_EDITPAGE_IMAGEEDIT) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_IMAGEEDIT . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_IMAGEEDIT)));
		}

		if(in_array(WE_EDITPAGE_THUMBNAILS,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["thumbnails"],(($we_doc->EditPageNr == WE_EDITPAGE_THUMBNAILS) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_THUMBNAILS . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_THUMBNAILS)));
		}

		if(in_array(WE_EDITPAGE_WORKSPACE,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["workspace"],(($we_doc->EditPageNr == WE_EDITPAGE_WORKSPACE) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_WORKSPACE . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_WORKSPACE)));
		}

		// Bug Fix #6062
		if(in_array(WE_EDITPAGE_CFWORKSPACE,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["workspace"],(($we_doc->EditPageNr == WE_EDITPAGE_CFWORKSPACE) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_CFWORKSPACE . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_CFWORKSPACE)));
		}

		if(in_array(WE_EDITPAGE_INFO,$we_doc->EditPageNrs)){
			if(we_hasPerm("CAN_SEE_INFO")){
				$we_tabs->addTab(new we_tab("#", $l_we_class["information"],(($we_doc->EditPageNr == WE_EDITPAGE_INFO) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_INFO . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_INFO)));
			}
		}

		if(in_array(WE_EDITPAGE_PREVIEW,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", ($we_doc->ContentType == "text/weTmpl" ? $l_we_class["previeweditmode"] : $l_we_class["preview"]),(($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_PREVIEW)));
		}

		if(in_array(WE_EDITPAGE_PREVIEW_TEMPLATE,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["preview"],(($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW_TEMPLATE) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW_TEMPLATE . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_PREVIEW_TEMPLATE)));
		}

		if(in_array(WE_EDITPAGE_METAINFO,$we_doc->EditPageNrs)){
			$we_tabs->addTab(new we_tab("#", $l_we_class["metainfos"],(($we_doc->EditPageNr == WE_EDITPAGE_METAINFO) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_METAINFO . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_METAINFO)));
		}

		if(in_array(WE_EDITPAGE_FIELDS,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["fields"],(($we_doc->EditPageNr == WE_EDITPAGE_FIELDS) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_FIELDS . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_FIELDS)));
		}

		if(in_array(WE_EDITPAGE_SEARCH,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["search"],(($we_doc->EditPageNr == WE_EDITPAGE_SEARCH) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_SEARCH . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_SEARCH)));
		}

		// Bug Fix #6062
		/*
		if(in_array(WE_EDITPAGE_CFSEARCH,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["search"],(($we_doc->EditPageNr == WE_EDITPAGE_CFSEARCH) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_CFSEARCH . ",'" . $we_transaction . "');"));
		}
		*/

		if(we_hasPerm("CAN_SEE_SCHEDULER") && weModuleInfo::isActiv("schedule") && in_array(WE_EDITPAGE_SCHEDULER,$we_doc->EditPageNrs) && $we_doc->ContentType != "folder"){

			$we_tabs->addTab(new we_tab("#", $l_we_class["schedpro"],(($we_doc->EditPageNr == WE_EDITPAGE_SCHEDULER) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_SCHEDULER . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_SCHEDULER)));
		}
		if(in_array(WE_EDITPAGE_VALIDATION,$we_doc->EditPageNrs) && ($we_doc->ContentType == 'text/webedition' || $we_doc->ContentType == 'text/css' || $we_doc->ContentType == 'text/html' )){
		    if (we_hasPerm("CAN_SEE_VALIDATION")) {

		    	$we_tabs->addTab(new we_tab("#", $l_we_class["validation"],(($we_doc->EditPageNr == WE_EDITPAGE_VALIDATION) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_VALIDATION . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_VALIDATION)));
		    }
		}

		if (in_array(WE_EDITPAGE_WEBUSER, $we_doc->EditPageNrs) && (we_hasPerm("CAN_EDIT_CUSTOMERFILTER") || we_hasPerm("CAN_CHANGE_DOCS_CUSTOMER"))) {
			$we_tabs->addTab(new we_tab("#", $l_we_class["webUser"],(($we_doc->EditPageNr == WE_EDITPAGE_WEBUSER) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_WEBUSER . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_WEBUSER)));

		}
		
		if(we_hasPerm("ADMINISTRATOR") || we_hasPerm("SEE_VERSIONS")) {
			if (in_array(WE_EDITPAGE_VERSIONS, $we_doc->EditPageNrs)) {
				$we_tabs->addTab(new we_tab("#", $l_we_class["version"],(($we_doc->EditPageNr == WE_EDITPAGE_VERSIONS) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_VERSIONS . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_VERSIONS)));
	
			}
		}

		$we_doc->we_initSessDat($we_dt);

		if( in_array(WE_EDITPAGE_VARIANTS, $we_doc->EditPageNrs) && ($we_doc->canHaveVariants( ($we_doc->ContentType == 'text/webedition' || $we_doc->ContentType == 'objectFile') ) )){
		    if (we_hasPerm("CAN_EDIT_VARIANTS")) {
		    	$we_tabs->addTab(new we_tab("#", $l_we_class["variants"],(($we_doc->EditPageNr == WE_EDITPAGE_VARIANTS) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_VARIANTS . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_VARIANTS)));
		    }
		}

		if(in_array(WE_EDITPAGE_DOCLIST,$we_doc->EditPageNrs)){

			$we_tabs->addTab(new we_tab("#", $l_we_class["docList"],(($we_doc->EditPageNr == WE_EDITPAGE_DOCLIST) ? "TAB_ACTIVE" : "TAB_NORMAL"),"we_cmd('switch_edit_page'," . WE_EDITPAGE_DOCLIST . ",'" . $we_transaction . "');",array("id"=>"tab_".WE_EDITPAGE_DOCLIST)));
		}
	}

	$we_tabs->onResize('editHeader');
	$tab_head = $we_tabs->getHeader();
	$tab_js   = $we_tabs->getJS();
	$tab_js  .= $we_tabs->getJSRebuildTabs();

} else {
	$tab_head = we_htmlElement::jsElement("function setFrameSize(){}");
}

if ($tab_head) {
	print $tab_head;
}



$_js_we_setPath = "
function we_setPath(path, text) {

	// update document-tab
	_EditorFrame.initEditorFrameData({\"EditorDocumentText\":text,\"EditorDocumentPath\":path});


	path = '<b><font color=\'#006699\'>'+path+'</font></b>';
	if(document.getElementById) {
		var div = document.getElementById('h_path');
		div.innerHTML = path;
	}
	else if(document.all) {
		var div = document.all['h_path'];
		div.innerHTML = path;
	}
}

";

$_js_we_cmd = "
function we_cmd() {

" . ($GLOBALS['we_doc']->ContentType != "text/weTmpl" ? "
	parent.openedWithWE = 1;" : "") ."

	var args = '';
	var url = '" . WEBEDITION_DIR . "we_cmd.php?';
	for(var i = 0; i < arguments.length; i++){
		url += 'we_cmd['+i+']='+escape(arguments[i]);
		if(i < (arguments.length - 1)){
			url += '&';
		}
	}
	for(var i = 0; i < arguments.length; i++) {
		args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
	}

	switch ( arguments[0] ) {

		case 'switch_edit_page':
			_EditorFrame.setEditorEditPageNr(arguments[1]);
			eval('parent.we_cmd('+args+')');
		break;
	}

}
";

$_js_code = "
<!--

var _EditorFrame = top.weEditorFrameController.getEditorFrame(parent.name);
_EditorFrame.setEditorEditPageNr(" . $we_doc->EditPageNr . ");

$_js_we_setPath
$_js_we_cmd

//-->
";
print we_htmlElement::jsElement($_js_code);

//	Stylesheet and image pre�pader for buttons
print STYLESHEET;

?>
</head>
<body id='eHeaderBody' bgcolor="white" background="<?php print IMAGE_DIR; ?>backgrounds/header.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onload="setFrameSize()" onresize="setFrameSize()">
<div id="main" ><?php
print getPixel(100,3).'<div style="margin:0px;" id="headrow">&nbsp;'.we_htmlElement::htmlB(str_replace(" ","&nbsp;",$l_contentTypes[$we_doc->ContentType])).': <span id="h_path"></span></div>'.getPixel(100,3);

if ($_SESSION["we_mode"] != "seem") {
	print $we_tabs->getHTML();

}
?></div>
</body>
</html>
<script type="text/javascript">

<?php

$_path = $we_doc->Path;
$_text = ($we_doc->Filename ? $we_doc->Filename . (isset($we_doc->Extension) ? $we_doc->Extension : '') : $we_doc->Text);

?>

we_setPath("<?php print $_path; ?>", "<?php print $_text; ?>");

</script>