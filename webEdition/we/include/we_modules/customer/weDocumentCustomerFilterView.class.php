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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weCustomerFilterView.class.php");
include_once( $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php" );


/**
 *  view class for document customer filters
 *
 */
class weDocumentCustomerFilterView extends weCustomerFilterView {


	/**
	 * Gets the HTML and Javascript for the filter
	 *
	 * @return string
	 */
	function getFilterHTML() {
		return parent::getFilterHTML() . '<div style="height: 20px;"></div>' .
		$this->getAccessControlHTML() .

		(($GLOBALS['we_doc']->ContentType=="folder") ? ('<div style="height: 20px;"></div>' . $this->getFolderApplyHTML()) : "");
	}

	/**
	 * Gets the HTML and Javascript for the access control ui
	 *
	 * @return string
	 */
	function getAccessControlHTML() {

		$we_button = new we_button();

		$_filter = $this->getFilter();

		$yuiSuggest =& weSuggest::getInstance();

		/**** AUTOSELECTOR FOR ErrorDocument, Customer is not logged in ****/
		$_id_selectorNoLoginId = $_filter->getErrorDocNoLogin();
		$_path_selectorNoLoginId = $_id_selectorNoLoginId ? id_to_path( $_id_selectorNoLoginId ) : "";
		if (!$_path_selectorNoLoginId) {
			$_id_selectorNoLoginId = "";
		}

		$selectorNoLoginId = "wecf_noLoginId";
		$selectorNoLoginText = "wecf_InputNoLoginText";
		$selectorNoLoginError = "wecf_ErrorMarkNoLoginText";
		$selectorNoLoginButton = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.we_form.elements['$selectorNoLoginId'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'$selectorNoLoginId\\'].value','document.we_form.elements[\\'$selectorNoLoginText\\'].value','opener." . $this->getHotScript() . ";','".session_id()."','','text/webedition',1)") . "<div id=\"wecf_container_noLoginId\"></div>";

		$yuiSuggest->setAcId("NoLogin");
		$yuiSuggest->setContentType("folder,text/webedition");
		$yuiSuggest->setInput($selectorNoLoginText,$_path_selectorNoLoginId);
		$yuiSuggest->setLabel($GLOBALS['l_customerFilter']['documentNoLogin']);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($selectorNoLoginId,$_id_selectorNoLoginId);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth(409);
		$yuiSuggest->setSelectButton($selectorNoLoginButton);

		$weAcSelector = $yuiSuggest->getHTML();

		/**** AUTOSELECTOR FOR ErrorDocument, Customer might be logged in, but has no access ****/
		$_id_selectorNoAccessId = $_filter->getErrorDocNoAccess();
		$_path_selectorNoAccessId = $_id_selectorNoAccessId ? id_to_path( $_id_selectorNoAccessId ) : "";
		if (!$_path_selectorNoAccessId) {
			$_id_selectorNoAccessId = "";
		}

		$selectorNoAccessId = "wecf_noAccessId";
		$selectorNoAccessText = "wecf_InputNoAccessText";
		$selectorNoAccessError = "wecf_ErrorMarkNoAccessText";
		$selectorNoAccessButton = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.we_form.elements['$selectorNoAccessId'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'$selectorNoAccessId\\'].value','document.we_form.elements[\\'$selectorNoAccessText\\'].value','opener.". $this->getHotScript() ."','".session_id()."','','text/webedition',1)");

		$yuiSuggest->setAcId("NoAccess");
		$yuiSuggest->setContentType("folder,text/webedition");
		$yuiSuggest->setInput($selectorNoAccessText,$_path_selectorNoAccessId);
		$yuiSuggest->setLabel($GLOBALS['l_customerFilter']['documentNoAccess']);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($selectorNoAccessId,$_id_selectorNoAccessId);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth(409);
		$yuiSuggest->setSelectButton($selectorNoAccessButton);

		$weAcSelector2 = $yuiSuggest->getHTML();

		$_accesControl = '<div class="weMultiIconBoxHeadline">' .
			$GLOBALS['l_customerFilter']['accessControl'] . '</div>' .
			we_forms::radiobutton(
			"onTemplate",
			$_filter->getAccessControlOnTemplate(),
			"wecf_accessControlOnTemplate",
			$GLOBALS['l_customerFilter']["accessControlOnTemplate"],
			true, "defaultfont", "updateView();" . $this->getHotScript()
		) .

		we_forms::radiobutton(
			"errorDoc",
			!$_filter->getAccessControlOnTemplate(),
			"wecf_accessControlOnTemplate",
			$GLOBALS['l_customerFilter']["accessControlOnErrorDoc"],
			true, "defaultfont", "updateView();" . $this->getHotScript()
		) .

		weDocumentCustomerFilterView::getDiv(
			$weAcSelector . "\n" .
			$weAcSelector2 . "\n" ,

			'accessControlSelectorDiv', (!$_filter->getAccessControlOnTemplate()), 25
		);



		return	$yuiSuggest->getYuiFiles() . "\n"  .
			$this->getDiv($_accesControl, 'accessControlDiv',$_filter->getMode()!==WECF_OFF, 0);


	}

	/**
	 * Gets the HTML and Javascript for the folder apply ui (copy filter)
	 *
	 * @return string
	 */
	function getFolderApplyHTML() {
		$we_button = new we_button();
		$_ok_button = $we_button->create_button("ok", "javascript:if (_EditorFrame.getEditorIsHot()) { " . we_message_reporting::getShowMessageCall($GLOBALS['l_customerFilter']['apply_filter_isHot'], WE_MESSAGE_INFO) . " } else { we_cmd('copyWeDocumentCustomerFilter', '" . $GLOBALS['we_doc']->ID . "', '" . $GLOBALS['we_doc']->Table . "');}");

		return "
			<div class=\"weMultiIconBoxHeadline paddingVertical\">" . $GLOBALS['l_customerFilter']['apply_filter'] . "</div>
			<table>
			<tr>
				<td>" . htmlAlertAttentionBox($GLOBALS['l_customerFilter']['apply_filter_info'],2,432,false) . "</td>
				<td style=\"padding-left:17px;\">" . $_ok_button . "</td>
			</tr>
			</table>
		";

	}

	/**
	 * Creates the content for the JavaScript updateView() function
	 *
	 * @return string
	 */
	function createUpdateViewScript() {
		return parent::createUpdateViewScript() . <<<EOF
	var r2 = f.wecf_accessControlOnTemplate;
	var wecf_onTemplateRadio 	= r2[0];
	var wecf_errorDocRadio 		= r2[1];

	$('accessControlSelectorDiv').style.display = wecf_errorDocRadio.checked ? "block" : "none";
	$('accessControlDiv').style.display = modeRadioOff.checked ? "none" : "block";

EOF;
	}

}



?>