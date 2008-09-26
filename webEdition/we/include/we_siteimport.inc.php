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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_ContentTypes.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/siteimport.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/import.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/import_files.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/we_class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/thumbnails.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_progressBar.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/taskFragment.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_image_edit.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_import/importFunctions.class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weSuggest.class.inc.php");

protect();

class weSiteImport
{

	var $step = 0;

	var $cmd = "";

	var $from = "/";

	var $to = "";

	var $depth = -1;

	var $images = 1;

	var $htmlPages = 1;

	var $createWePages = 1;

	var $flashmovies = 1;

	var $quicktime = 1;

	var $js = 1;

	var $css = 1;

	var $text = 1;

	var $other = 1;

	var $maxSize = 1; // in Mb

	var $sameName = "overwrite";

	var $importMetadata = true;

	var $_files;

	var $_depth = 0;

	var $_slash = "/";

	var $thumbs = "";

	var $width = "";

	var $height = "";

	var $widthSelect = "pixel";

	var $heightSelect = "pixel";

	var $keepRatio = 1;

	var $quality = 8;

	var $degrees = 0;

	var $_postProcess;

	/**
	 * Constructor of Class
	 *
	 *
	 * @return weSiteImport
	 */
	function weSiteImport()
	{
		$wsa = makeArrayFromCSV(get_def_ws());
		if (sizeof($wsa)) {
			$ws = $wsa[0];
		} else {
			$ws = 0;
		}
		$this->from = isset($_REQUEST["from"]) ? $_REQUEST["from"] : ((isset($_SESSION['prefs']['import_from']) && $_SESSION['prefs']['import_from']) ? $_SESSION['prefs']['import_from'] : $this->from);
		$_SESSION['prefs']['import_from'] = $this->from;
		$this->to = isset($_REQUEST["to"]) ? $_REQUEST["to"] : (strlen($this->to) ? $this->to : $ws);
		$this->depth = isset($_REQUEST["depth"]) ? $_REQUEST["depth"] : $this->depth;
		$this->images = isset($_REQUEST["images"]) ? $_REQUEST["images"] : $this->images;
		$this->htmlPages = isset($_REQUEST["htmlPages"]) ? $_REQUEST["htmlPages"] : $this->htmlPages;
		$this->createWePages = isset($_REQUEST["createWePages"]) ? $_REQUEST["createWePages"] : $this->createWePages;
		$this->flashmovies = isset($_REQUEST["flashmovies"]) ? $_REQUEST["flashmovies"] : $this->flashmovies;
		$this->quicktime = isset($_REQUEST["quicktime"]) ? $_REQUEST["quicktime"] : $this->quicktime;
		$this->js = isset($_REQUEST["js"]) ? $_REQUEST["js"] : $this->js;
		$this->css = isset($_REQUEST["css"]) ? $_REQUEST["css"] : $this->css;
		$this->text = isset($_REQUEST["text"]) ? $_REQUEST["text"] : $this->text;
		$this->other = isset($_REQUEST["other"]) ? $_REQUEST["other"] : $this->other;
		$this->maxSize = isset($_REQUEST["maxSize"]) ? $_REQUEST["maxSize"] : $this->maxSize;
		$this->step = isset($_REQUEST["step"]) ? $_REQUEST["step"] : $this->step;
		$this->cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : $this->cmd;
		if (isset($_REQUEST["we_cmd"][0])) {
			switch ($_REQUEST["we_cmd"][0]) {
				case "siteImportSaveWePageSettings" :
					$this->cmd = "saveWePageSettings";
					break;
				case "siteImportCreateWePageSettings" :
					$this->cmd = "createWePageSettings";
					break;
				case "updateSiteImportTable" :
					$this->cmd = "updateSiteImportTable";
					break;
			}
		}
		$this->sameName = isset($_REQUEST["sameName"]) ? $_REQUEST["sameName"] : $this->sameName;
		$this->importMetadata = isset($_REQUEST["importMetadata"]) ? $_REQUEST["importMetadata"] : $this->importMetadata;
		$this->thumbs = isset($_REQUEST["thumbs"]) ? makeCSVFromArray($_REQUEST["thumbs"]) : $this->thumbs;
		$this->width = isset($_REQUEST["width"]) ? $_REQUEST["width"] : $this->width;
		$this->height = isset($_REQUEST["height"]) ? $_REQUEST["height"] : $this->height;
		$this->widthSelect = isset($_REQUEST["widthSelect"]) ? $_REQUEST["widthSelect"] : $this->widthSelect;
		$this->heightSelect = isset($_REQUEST["heightSelect"]) ? $_REQUEST["heightSelect"] : $this->heightSelect;
		$this->keepRatio = isset($_REQUEST["keepRatio"]) ? $_REQUEST["keepRatio"] : $this->keepRatio;
		$this->quality = isset($_REQUEST["quality"]) ? $_REQUEST["quality"] : $this->quality;
		$this->degrees = isset($_REQUEST["degrees"]) ? $_REQUEST["degrees"] : $this->degrees;
		
		$this->_files = array();
		if (runAtWin()) {
			$this->_slash = "\\";
		}
	}

	/**
	 * returns the right HTML for siteimport depending on $this->cmd
	 *
	 * @return         string
	 */
	function getHTML()
	{
		switch ($this->cmd) {
			case "updateSiteImportTable" :
				return $this->_updateSiteImportTable();
				break;
			case "createWePageSettings" :
				return $this->_getCreateWePageSettingsHTML();
				break;
			case "saveWePageSettings" :
				return $this->_getSaveWePageSettingsHTML();
				break;
			case "content" :
				return $this->_getContentHTML();
				break;
			case "buttons" :
				return $this->_getButtonsHTML();
				break;
			default :
				return $this->_getFrameset();
		}
	}

	/**
	 * returns the javascript needed in the main content frame
	 *
	 *  @return         string
	 */
	function _getJS()
	{
		$js = 'function we_cmd() {
					var args = "";
					var url = "' . WEBEDITION_DIR . 'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

					switch (arguments[0]) {
    					case "openDocselector":
							new jsWindow(url,"we_docselector",-1,-1,' . WINDOW_DOCSELECTOR_WIDTH . ',' . WINDOW_DOCSELECTOR_HEIGHT . ',true,true,true,true);
							break;

    					case "openDirselector":
							new jsWindow(url,"we_dirselector",-1,-1,' . WINDOW_DIRSELECTOR_WIDTH . ',' . WINDOW_DIRSELECTOR_HEIGHT . ',true,true,true,true);
							break;

						case "browse_server":
 							new jsWindow(url,"browse_server",-1,-1,800,400,true,false,true);
							break;

						case "siteImportCreateWePageSettings":
							new jsWindow(url,"siteImportCreateWePageSettings",-1,-1,520,600,true,false,true);
							break;
					}
				}

				function hideTable() {
					document.getElementById("specifyParam").style.display="none";
				}

				function displayTable() {
					if (document.we_form.templateID.value > 0) {
						document.getElementById("specifyParam").style.display="block";
						var iframeObj = document.getElementById("iloadframe");
						iframeObj.src = "/webEdition/we_cmd.php?we_cmd[0]=updateSiteImportTable&tid="+document.we_form.templateID.value;
					}
				}
				' . "\n";
		
		$js = we_htmlElement::jsElement($js) . "\n";
		$js .= we_htmlElement::jsElement("", array(
			"src" => JS_DIR . "windows.js"
		)) . "\n";
		$js .= we_htmlElement::jsElement(
				"\n" . 'function doUnload() {
					if (jsWindow_count) {
						for (i = 0; i < jsWindow_count; i++) {
							eval("jsWindow" + i + "Object.close()");
						}
					}
				}' . "\n");
		return $js;
	}

	/**
	 * returns the fields of the template with given $tid (ID of template)
	 *
	 * @param	int	$tid ID of template
	 *
	 * @return	array
	 */
	function _getFieldsFromTemplate($tid)
	{
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tagParser.inc.php");
		$sql_select = "SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . CONTENT_TABLE . "," . LINK_TABLE . " WHERE " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND " . LINK_TABLE . ".DocumentTable='" . substr(
				TEMPLATES_TABLE, 
				strlen(TBL_PREFIX)) . "' AND " . LINK_TABLE . ".DID='" . abs($tid) . "' AND " . LINK_TABLE . ".Name='completeData'";
		
		$templateCode = f($sql_select, "Dat", $GLOBALS["DB_WE"]);
		$tp = new we_tagParser();
		$tags = $tp->getAllTags($templateCode);
		$records = array();
		foreach ($tags as $tag) {
			if (eregi('<we:([^> /]+)', $tag, $regs)) {
				$tagname = $regs[1];
				if (eregi('name="([^"]+)"', $tag, $regs) && ($tagname != "var") && ($tagname != "field")) {
					$name = $regs[1];
					switch ($tagname) {
						// tags with text content, images, links and hrefs
						case "img" :
							$records[$name] = "img";
							break;
						case "href" :
							$records[$name] = "href";
							break;
						case "link" :
							$records[$name] = "link";
							break;
						case "textarea" :
							$records[$name] = "text";
							break;
						case "input" :
							$attribs = weSiteImport::_parseAttributes(preg_replace('/^<we:[^ ]+ /i', '', $tag));
							$type = isset($attribs["type"]) ? $attribs["type"] : "text";
							switch ($type) {
								case "text" :
								case "choice" :
								case "select" :
									$records[$name] = "text";
									break;
								
								case "date" :
									$records[$name] = "date";
									break;
							
							}
							break;
					}
				}
			}
		}
		$records["Title"] = "text";
		$records["Description"] = "text";
		$records["Keywords"] = "text";
		$records["Charset"] = "text";
		return $records;
	}

	/**
	 * converts attributes of an tag (string) into an hash array
	 *
	 * @param	string	$attr attributes of the tag in string form (a="b" c="d" ...)
	 *
	 * @return	array
	 */
	function _parseAttributes($attr)
	{
		$attribs = "";
		preg_match_all('/([^=]+)= *("[^"]*")/', $attr, $foo, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($foo); $i++) {
			$attribs .= '"' . trim($foo[$i][1]) . '"=>' . trim($foo[$i][2]) . ',';
		}
		$arrstr = "array(" . ereg_replace('(.+),$', "\\1", $attribs) . ")";
		eval('$arr = ' . $arrstr . ';');
		
		return $arr;
	}

	/**
	 * returns the HTML with JavasScript which updates the HTML of the site import table (its a view function called from getHTML()) via DOM (kind of AJAX)
	 *
	 * @return	string
	 */
	function _updateSiteImportTable()
	{
		
		$_templateFields = weSiteImport::_getFieldsFromTemplate($_REQUEST["tid"]);
		$hasDateFields = false;
		
		$values = array();
		
		foreach ($_templateFields as $name => $type) {
			if ($type == "date") {
				$hasDateFields = true;
			}
			switch ($name) {
				case "Title" :
					array_push($values, array(
						"name" => $name, "pre" => "<title>", "post" => "</title>"
					));
					break;
				
				case "Keywords" :
					array_push($values, array(
						"name" => $name, "pre" => '<meta name="keywords" content="', "post" => '">'
					));
					break;
				
				case "Description" :
					array_push(
							$values, 
							array(
								
									"name" => $name, 
									"pre" => '<meta name="description" content="', 
									"post" => '">'
							));
					break;
				
				case "Charset" :
					array_push(
							$values, 
							array(
								
									"name" => $name, 
									"pre" => '<meta http-equiv="content-type" content="text/html;charset=', 
									"post" => '">'
							));
					break;
				
				default :
					array_push($values, array(
						"name" => $name, "pre" => "", "post" => ""
					));
			}
		}
		
		$js = 'var tableDivObj = parent.document.getElementById("tablediv");
		tableDivObj.innerHTML = "' . str_replace(
				"\r", 
				"\\r", 
				str_replace("\n", "\\n", addslashes($this->_getSiteImportTableHTML($_templateFields, $values)))) . '"
		parent.document.getElementById("dateFormatDiv").style.display="' . ($hasDateFields ? "block" : "none") . '";
';
		
		$js = we_htmlElement::jsElement($js) . "\n";
		return $this->_getHtmlPage("", $js);
	}

	/**
	 * saves the request data in database and session and returns the HTML which closes the window
	 *
	 * @return	string
	 */
	function _getSaveWePageSettingsHTML()
	{
		$data = array();
		$data["valueCreateType"] = $_REQUEST["createType"];
		if ($data["valueCreateType"] == "specify") {
			$data["valueTemplateId"] = isset($_REQUEST["templateID"]) ? $_REQUEST["templateID"] : 0;
			$data["valueUseRegex"] = isset($_REQUEST["useRegEx"]) ? $_REQUEST["useRegEx"] : 0;
			$data["valueFieldValues"] = serialize(isset($_REQUEST["fields"]) ? $_REQUEST["fields"] : array());
			$data["valueDateFormat"] = isset($_REQUEST["dateFormat"]) ? $_REQUEST["dateFormat"] : "unix";
			$data["valueDateFormatField"] = isset($_REQUEST["dateformatField"]) ? $_REQUEST["dateformatField"] : "";
			$data["valueTemplateName"] = "neueVorlage";
			$data["valueTemplateParentID"] = "0";
		} else {
			$data["valueTemplateId"] = "0";
			$data["valueUseRegex"] = false;
			$data["valueFieldValues"] = serialize(array());
			$data["valueDateFormat"] = "unix";
			$data["valueDateFormatField"] = "";
			$data["valueTemplateName"] = isset($_REQUEST["templateName"]) ? $_REQUEST["templateName"] : "neueVorlage";
			$data["valueTemplateParentID"] = isset($_REQUEST["templateParentID"]) ? $_REQUEST["templateParentID"] : "0";
		}
		$serializedData = serialize($data);
		// update DB
		$GLOBALS['DB_WE']->query(
				"UPDATE " . PREFS_TABLE . " SET siteImportPrefs='" . addslashes($serializedData) . "' WHERE userID=" . abs(
						$_SESSION["user"]["ID"]));
		// update session
		$_SESSION["prefs"]["siteImportPrefs"] = $serializedData;
		$js = '<script type="text/javascript" language="JavaScript">parent.close();</script>';
		return $this->_getHtmlPage("", $js);
	}

	/**
	 * returns HTML of Table with fields and start and end mark
	 *
	 * @param	array	$fields array with fields
	 * @param	array	$values array with values like it comes from $_REQUEST
	 *
	 * @return	string
	 */
	function _getSiteImportTableHTML($fields, $values = array())
	{
		
		$headlines = array(
			array(
			"dat" => $GLOBALS["l_siteimport"]["fieldName"]
		), array(
			"dat" => $GLOBALS["l_siteimport"]["startMark"]
		), array(
			"dat" => $GLOBALS["l_siteimport"]["endMark"]
		)
		);
		
		$content = array();
		if (count($fields) > 0) {
			$i = 0;
			foreach ($fields as $name => $type) {
				$row = array();
				$row[0]["dat"] = htmlspecialchars($name) . '<input type="hidden" name="fields[' . $i . '][name]" value="' . htmlspecialchars(
						$name) . '">';
				$index = $this->_getIndexOfValues($values, $name);
				if ($index > -1) {
					$valpre = $values[$index]["pre"];
					$valpost = $values[$index]["post"];
				} else {
					$valpre = "";
					$valpost = "";
				}
				$row[1]["dat"] = '<textarea name="fields[' . $i . '][pre]" style="width:160px;height:80px" wrap="off">' . htmlspecialchars(
						$valpre) . '</textarea>';
				$row[2]["dat"] = '<textarea name="fields[' . $i . '][post]" style="width:160px;height:80px" wrap="off">' . htmlspecialchars(
						$valpost) . '</textarea>';
				array_push($content, $row);
				$i++;
			}
		}
		return htmlDialogBorder3(420, 270, $content, $headlines, "middlefont", "", "", "fields", "margin-top:5px;");
	}

	/**
	 * returns index of array which name is the same as $name
	 *
	 * @param	array	$values array with values
	 * @param	string	$name name to compare
	 *
	 * @return	int
	 */
	function _getIndexOfValues($values, $name)
	{
		for ($i = 0; $i < count($values); $i++) {
			if ($values[$i]["name"] == $name) {
				return $i;
			}
		}
		return -1;
	}

	/**
	 * returns HTML of the "create webEdition page" settings Dialog
	 *
	 * @return	string
	 */
	function _getCreateWePageSettingsHTML()
	{
		global $l_import, $l_alert;
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		$we_button = new we_button();
		
		$data = (isset($_SESSION["prefs"]["siteImportPrefs"]) && $_SESSION["prefs"]["siteImportPrefs"]) ? unserialize(
				$_SESSION["prefs"]["siteImportPrefs"]) : array();
		
		$_valueCreateType = isset($data["valueCreateType"]) ? $data["valueCreateType"] : "auto";
		$_valueTemplateId = isset($data["valueTemplateId"]) ? $data["valueTemplateId"] : 0;
		$_valueUseRegex = isset($data["valueUseRegex"]) ? $data["valueUseRegex"] : 0;
		$_valueFieldValues = isset($data["valueFieldValues"]) ? unserialize($data["valueFieldValues"]) : array();
		$_valueDateFormat = isset($data["valueDateFormat"]) ? $data["valueDateFormat"] : "unix";
		$_valueDateFormatField = isset($data["valueDateFormatField"]) ? $data["valueDateFormatField"] : $GLOBALS["l_siteimport"]["dateFormatString"];
		$_valueTemplateName = isset($data["valueTemplateName"]) ? $data["valueTemplateName"] : str_replace(
				" ", 
				"", 
				$GLOBALS["l_siteimport"]["newTemplate"]);
		$_valueTemplateParentID = isset($data["valueTemplateParentID"]) ? $data["valueTemplateParentID"] : "0";
		
		$_templateFields = weSiteImport::_getFieldsFromTemplate($_valueTemplateId);
		$hasDateFields = false;
		foreach ($_templateFields as $name => $type) {
			if ($type == "date") {
				$hasDateFields = true;
				break;
			}
		}
		$date_help_button = $we_button->create_button("image:btn_help", "javascript:showDateHelp();", true . -1, 22);
		$dateformatvals = array(
			"unix" => $l_import['uts'], "gmt" => $l_import['gts'], "own" => $l_import['fts']
		);
		$_dateFormatHTML = '<div id="dateFormatDiv" style="display:' . ($hasDateFields ? 'block' : 'none') . ';margin-bottom:10px;"><table style="margin:10px 0 10px 0" border="0" cellpadding="0" cellspacing="0"><tr><td style="padding-right:10px" class="defaultfont">' . htmlspecialchars(
				$GLOBALS["l_siteimport"]["dateFormat"], 
				ENT_QUOTES) . ':' . '</td><td>' . htmlSelect(
				"dateFormat", 
				$dateformatvals, 
				1, 
				$_valueDateFormat, 
				false, 
				'onchange="dateFormatChanged(this);"') . '</td><td id="ownValueInput" style="padding-left:10px;display:' . (($_valueDateFormat == "own") ? 'block' : 'none') . '">' . htmlTextInput(
				"dateformatField", 
				20, 
				$_valueDateFormatField) . '</td><td id="ownValueInputHelp" style="padding-bottom:1px;padding-left:10px;display:' . (($_valueDateFormat == "own") ? 'block' : 'none') . '">' . $date_help_button . '</td></tr></table>' . '</div>';
		
		$table = '<div style="overflow:auto;height:330px; margin-top:5px;"><div style="width:450px;" id="tablediv">' . $this->_getSiteImportTableHTML(
				$_templateFields, 
				$_valueFieldValues) . '</div></div>';
		
		$_regExCheckbox = we_forms::checkboxWithHidden(
				$_valueUseRegex, 
				"useRegEx", 
				htmlspecialchars($GLOBALS["l_siteimport"]["useRegEx"], ENT_QUOTES));
		$specifyHTML = $this->_getTemplateSelectHTML($_valueTemplateId) . '<div id="specifyParam" style="padding-top:10px;display:' . ($_valueTemplateId ? 'block' : 'none') . '">' . $_dateFormatHTML . $_regExCheckbox . $table . '</div>';
		
		$vals = array(
			
				"auto" => htmlspecialchars($GLOBALS["l_siteimport"]["cresteAutoTemplate"], ENT_QUOTES), 
				"specify" => htmlspecialchars($GLOBALS["l_siteimport"]["useSpecifiedTemplate"], ENT_QUOTES)
		);
		
		$_html = '<table style="margin-bottom:10px" border="0" cellpadding="0" cellspacing="0"><tr><td style="padding-right:10px" class="defaultfont">' . htmlspecialchars(
				$GLOBALS["l_siteimport"]["importKind"], 
				ENT_QUOTES) . ':' . '</td><td>' . htmlSelect(
				"createType", 
				$vals, 
				1, 
				$_valueCreateType, 
				false, 
				'onchange="createTypeChanged(this);"') . '</td></tr></table>' . '<div id="ctauto" style="display:' . (($_valueCreateType == "auto") ? 'block' : 'none') . '">' . htmlAlertAttentionBox(
				$GLOBALS["l_siteimport"]["autoExpl"], 
				2, 
				450) . weSiteImport::_formPathHTML($_valueTemplateName, $_valueTemplateParentID) . '</div><div id="ctspecify" style="display:' . (($_valueCreateType == "specify") ? 'block' : 'none') . '">' . '<div style="height:4px;"></div>' . $specifyHTML . '</div>';
		
		$_html = '<div style="height:480px">' . $_html . '</div>';
		
		$parts = array();
		array_push($parts, array(
			"headline" => "", "html" => $_html, "space" => 0
		));
		
		$bodyhtml = '<body class="weDialogBody">
					<iframe style="position:absolute;top:-2000px;" src="about:blank" id="iloadframe" name="iloadframe" width="400" height="200"></iframe>
					<form onsubmit="return false;" name="we_form" method="post" action="' . $_SERVER['PHP_SELF'] . '" target="iloadframe">
					<input type="hidden" name="we_cmd[0]" value="siteImportSaveWePageSettings">
					<input type="hidden" name="ok" value="1">' . we_multiIconBox::getJS();
		
		$okbutton = $we_button->create_button("ok", "javascript:if(checkForm()){document.we_form.submit();}");
		$cancelbutton = $we_button->create_button("cancel", "javascript:self.close()");
		$buttons = $we_button->position_yes_no_cancel($okbutton, null, $cancelbutton);
		$bodyhtml .= we_multiIconBox::getHTML(
				"", 
				"100%", 
				$parts, 
				30, 
				$buttons, 
				-1, 
				"", 
				"", 
				false, 
				$GLOBALS["l_siteimport"]["importSettingsWePages"]);
		$bodyhtml .= '</form></body>';
		
		$js = '<script type="text/javascript" language="JavaScript">

	function checkForm(){
		var f = document.forms[0];
		var createType = f.createType.options[f.createType.selectedIndex].value;
		if (createType == "specify") {
			// check if template is selected
			if (f.templateID.value == "0" || f.templateID.value=="") {
				' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_siteimport"]["pleaseSelectTemplateAlert"], 
				WE_MESSAGE_ERROR) . '
				return false;
			}
			// check value of fields
			var fields = new Array();
			var inputElements = f.getElementsByTagName("input");
			for (var i=0; i<inputElements.length; i++) {
				if (inputElements[i].name.indexOf("fields[") == 0) {
					var search = /^fields\[([^\]]+)\]\[([^\]]+)\]$/;
					var result = search.exec(inputElements[i].name);
					var index = parseInt(result[1]);
					var key = result[2];
					if (fields[index] == null) {
						fields[index] = new Object();
					}
					fields[index][key] = inputElements[i].value;
				}
			}
			var textareaElements = f.getElementsByTagName("textarea");
			for (var i=0; i<textareaElements.length; i++) {
				if (textareaElements[i].name.indexOf("fields[") == 0) {
					var search = /^fields\[([^\]]+)\]\[([^\]]+)\]$/;
					var result = search.exec(textareaElements[i].name);
					var index = parseInt(result[1]);
					var key = result[2];
					if (fields[index] == null) {
						fields[index] = new Object();
					}
					fields[index][key] = textareaElements[i].value;
				}
			}
			filled = 0;
			for (var i=0; i<fields.length; i++) {
				if (fields[i]["pre"].length > 0 && fields[i]["post"].length > 0) {
					filled = 1;
					break;
				}
			}
			if (filled == 0) {
				' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_siteimport"]["startEndMarkAlert"], 
				WE_MESSAGE_ERROR) . '
				return false;
			}
			if (document.getElementById("ownValueInput").style.display != "none") {
				if (f.dateformatField.value.length == 0) {
					' . we_message_reporting::getShowMessageCall(
				str_replace('"', '\"', $GLOBALS["l_siteimport"]["errorEmptyDateFormat"]), 
				WE_MESSAGE_ERROR) . '
					return false;
				}
			}
		} else {
			if (f.templateName.value.length==0) {
				' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_siteimport"]["nameOfTemplateAlert"], 
				WE_MESSAGE_ERROR) . '
				f.templateName.focus();
				f.templateName.select();
				return false;
			}
			var reg = /[^a-z0-9\._\-]/gi;
			if (reg.test(f.templateName.value)) {
				' . we_message_reporting::getShowMessageCall(
				$l_alert["we_filename_notValid"], 
				WE_MESSAGE_ERROR) . '
				f.templateName.focus();
				f.templateName.select();
				return false;
			}
		}
		return true;
	}

	function createTypeChanged(s) {
		var val = s.options[s.selectedIndex].value;
		document.getElementById("ctauto").style.display = (val == "auto") ? "block" : "none";
		document.getElementById("ctspecify").style.display = (val == "specify") ? "block" : "none";
	}

	function dateFormatChanged(s) {
		var val = s.options[s.selectedIndex].value;
		document.getElementById("ownValueInput").style.display = (val == "own") ? "block" : "none";
		document.getElementById("ownValueInputHelp").style.display = (val == "own") ? "block" : "none";
	}

	function showDateHelp() {
		// this is a real alert, dont use showMessage yet
		' . we_message_reporting::getShowMessageCall(
				$l_import['format_timestamp'], 
				WE_MESSAGE_INFO) . '
	}

</script>';
		
		return $this->_getHtmlPage($bodyhtml, $this->_getJS() . $js);
	}

	/**
	 * returns HTML of the template selector
	 *
	 * @param int $tid  ID of template
	 *
	 * @return	string
	 */
	function _getTemplateSelectHTML($tid)
	{
		$we_button = new we_button();
		$table = TEMPLATES_TABLE;
		$textname = 'templateDummy';
		$idname = 'templateID';
		$path = f("SELECT Path FROM $table WHERE ID='$tid'", "Path", $GLOBALS['DB_WE']);
		$button = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDocselector',document.we_form.elements['$idname'].value,'$table','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value','opener.displayTable();','" . session_id() . "','','text/weTmpl',1)");
		
		$foo = htmlTextInput($textname, 30, $path, "", ' readonly', "text", 320, 0);
		return htmlFormElementTable(
				$foo, 
				htmlspecialchars($GLOBALS["l_siteimport"]["template"], ENT_QUOTES), 
				"left", 
				"defaultfont", 
				we_getHiddenField($idname, $tid), 
				getPixel(20, 4), 
				$button);
	
	}

	/**
	 * returns HTML of the main dialog (contemt)
	 *
	 * @return	string
	 */
	function _getContentHTML()
	{
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		$we_button = new we_button();
		
		// Suorce Directory
		$_from_button = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button(
				"select", 
				"javascript:we_cmd('browse_server', 'document.we_form.elements[\\'from\\'].value', 'folder', document.we_form.elements['from'].value)") : "";
		
		$_input = htmlTextInput("from", 30, $this->from, "", "readonly", "text", 300);
		
		$_importFrom = htmlFormElementTable(
				$_input, 
				$GLOBALS["l_siteimport"]["importFrom"], 
				"left", 
				"defaultfont", 
				getPixel(10, 1), 
				$_from_button, 
				"", 
				"", 
				"", 
				0);
		
		// Destination Directory
		$_to_button = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDirselector',document.we_form.elements['to'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'to\\'].value','document.we_form.elements[\\'toPath\\'].value','','','0')");
		
		//$_hidden = hidden("to",$this->to);
		//$_input = htmlTextInput("toPath",30,id_to_path($this->to),"",'readonly="readonly"',"text",300);
		

		//$_importTo = htmlFormElementTable($_input, $GLOBALS["l_siteimport"]["importTo"], "left", "defaultfont", getPixel(10, 1), $_to_button, $_hidden, "", "", 0);
		

		$yuiSuggest = & weSuggest::getInstance();
		$yuiSuggest->setAcId("DirPath");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput("toPath", id_to_path($this->to));
		$yuiSuggest->setLabel($GLOBALS["l_siteimport"]["importTo"]);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(0);
		$yuiSuggest->setResult("to", $this->to);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setWidth(300);
		$yuiSuggest->setSelectButton($_to_button, 10);
		
		$_importTo = $yuiSuggest->getYuiFiles() . $yuiSuggest->getHTML() . $yuiSuggest->getYuiCode();
		
		// Checkboxes
		

		$weoncklick = "if(this.checked && (!this.form.elements['htmlPages'].checked)){this.form.elements['htmlPages'].checked = true;}";
		$weoncklick .= ((!we_hasPerm("NEW_HTML")) && we_hasPerm("NEW_WEBEDITIONSITE")) ? "if((!this.checked) && this.form.elements['htmlPages'].checked){this.form.elements['htmlPages'].checked = false;}" : "";
		
		$_images = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_GRAFIK") ? $this->images : false, 
				"images", 
				$GLOBALS["l_siteimport"]["importImages"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_GRAFIK"));
		
		$_htmlPages = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_HTML") ? $this->htmlPages : ((we_hasPerm("NEW_WEBEDITIONSITE") && $this->createWePages) ? true : false), 
				"htmlPages", 
				$GLOBALS["l_siteimport"]["importHtmlPages"], 
				false, 
				"defaultfont", 
				"if(this.checked){this.form.elements['_createWePages'].disabled=false;document.getElementById('label__createWePages').style.color='black';}else{this.form.elements['_createWePages'].disabled=true;document.getElementById('label__createWePages').style.color='gray';}", 
				!we_hasPerm("NEW_HTML"));
		$_createWePages = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_WEBEDITIONSITE") ? $this->createWePages : false, 
				"createWePages", 
				$GLOBALS["l_siteimport"]["createWePages"] . "&nbsp;&nbsp;", 
				false, 
				"defaultfont", 
				$weoncklick, 
				!we_hasPerm("NEW_WEBEDITIONSITE"));
		$_flashmovies = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_FLASH") ? $this->flashmovies : false, 
				"flashmovies", 
				$GLOBALS["l_siteimport"]["importFlashmovies"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_FLASH"));
		$_quicktime = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_QUICKTIME") ? $this->quicktime : false, 
				"quicktime", 
				$GLOBALS["l_siteimport"]["importQuicktime"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_QUICKTIME"));
		$_jss = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_JS") ? $this->js : false, 
				"j", 
				$GLOBALS["l_siteimport"]["importJS"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_JS"));
		$_css = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_CSS") ? $this->css : false, 
				"css", 
				$GLOBALS["l_siteimport"]["importCSS"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_CSS"));
		$_text = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_TEXT") ? $this->text : false, 
				"text", 
				$GLOBALS["l_siteimport"]["importText"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_TEXT"));
		$_others = we_forms::checkboxWithHidden(
				we_hasPerm("NEW_SONSTIGE") ? $this->other : false, 
				"other", 
				$GLOBALS["l_siteimport"]["importOther"], 
				false, 
				"defaultfont", 
				"", 
				!we_hasPerm("NEW_SONSTIGE"));
		
		$_wePagesOptionButton = $we_button->create_button(
				"preferences", 
				"javascript:we_cmd('siteImportCreateWePageSettings')", 
				true, 
				150, 
				22, 
				"", 
				"", 
				false, 
				true, 
				"", 
				true);
		// Depth
		$_select = htmlSelect(
				"depth", 
				array(
					
						"-1" => $GLOBALS["l_siteimport"]["nolimit"], 
						0, 
						1, 
						2, 
						3, 
						4, 
						5, 
						6, 
						7, 
						8, 
						9, 
						10, 
						11, 
						12, 
						13, 
						14, 
						15, 
						16, 
						17, 
						18, 
						19, 
						20, 
						21, 
						22, 
						23, 
						24, 
						25, 
						26, 
						27, 
						28, 
						29, 
						30
				), 
				1, 
				$this->depth, 
				false, 
				"", 
				"value", 
				150);
		
		$_depth = htmlFormElementTable($_select, $GLOBALS["l_siteimport"]["depth"]);
		$maxallowed = round(getMaxAllowedPacket($GLOBALS['DB_WE']) / (1024 * 1024));
		$maxallowed = $maxallowed ? $maxallowed : 20;
		$maxarray = array(
			"0" => $GLOBALS["l_siteimport"]["nolimit"], "0.5" => "0.5"
		);
		for ($i = 1; $i <= $maxallowed; $i++) {
			$maxarray["" . $i] = $i;
		}
		
		// maxSize
		$_select = htmlSelect("maxSize", $maxarray, 1, $this->maxSize, false, "", "value", 150);
		$_maxSize = htmlFormElementTable($_select, $GLOBALS["l_siteimport"]["maxSize"]);
		
		$thumbsarray = array();
		$GLOBALS["DB_WE"]->query("SELECT ID,Name FROM " . THUMBNAILS_TABLE . " ORDER BY Name");
		while ($GLOBALS["DB_WE"]->next_record()) {
			$thumbsarray[$GLOBALS["DB_WE"]->f("ID")] = $GLOBALS["DB_WE"]->f("Name");
		}
		$_select = htmlSelect("thumbs[]", $thumbsarray, 5, $this->thumbs, true, "", "value", 150);
		$_thumbs = htmlFormElementTable($_select, $GLOBALS["l_import_files"]["thumbnails"]);
		
		$parts = array();
		
		array_push(
				$parts, 
				array(
					
						"headline" => $GLOBALS["l_siteimport"]["dirs_headline"], 
						"html" => $_importFrom . getPixel(20, 5) . $_importTo, 
						"space" => 120
				));
		
		/* Create Main Table */
		$_attr = array(
			"border" => "0", "cellpadding" => "0", "cellspacing" => "0"
		);
		$_tableObj = new we_htmlTable($_attr, 6, 3);
		
		$_tableObj->setCol(0, 0, array(
			"colspan" => "2"
		), $_images);
		$_tableObj->setCol(1, 0, array(
			"colspan" => "2"
		), $_flashmovies);
		$_tableObj->setCol(2, 0, array(
			"colspan" => "2"
		), $_htmlPages);
		$_tableObj->setCol(3, 0, null, "");
		$_tableObj->setCol(3, 1, null, $_createWePages);
		$_tableObj->setCol(4, 1, null, $_wePagesOptionButton);
		$_tableObj->setCol(5, 0, null, getPixel(20, 1));
		$_tableObj->setCol(5, 1, null, getPixel(200, 1));
		$_tableObj->setCol(5, 2, null, getPixel(180, 1));
		$_tableObj->setCol(0, 2, null, $_jss);
		$_tableObj->setCol(1, 2, null, $_css);
		$_tableObj->setCol(2, 2, null, $_text);
		$_tableObj->setCol(3, 2, null, $_others);
		$_tableObj->setCol(4, 2, array(
			"valign" => "top"
		), $_quicktime);
		
		array_push(
				$parts, 
				array(
					
						"headline" => $GLOBALS["l_siteimport"]["import"], 
						"html" => $_tableObj->getHtmlCode(), 
						"space" => 120
				));
		
		$_tableObj = new we_htmlTable($_attr, 2, 2);
		$_tableObj->setCol(0, 0, null, $_depth);
		$_tableObj->setCol(0, 1, null, $_maxSize);
		$_tableObj->setCol(1, 0, null, getPixel(220, 1));
		$_tableObj->setCol(1, 1, null, getPixel(180, 1));
		
		array_push(
				$parts, 
				array(
					
						"headline" => $GLOBALS["l_siteimport"]["limits"], 
						"html" => $_tableObj->getHtmlCode(), 
						"space" => 120
				));
		
		$content = htmlAlertAttentionBox($GLOBALS["l_import_files"]["sameName_expl"], 2, "410");
		$content .= getPixel(200, 10);
		$content .= we_forms::radiobutton(
				"overwrite", 
				($this->sameName == "overwrite"), 
				"sameName", 
				$GLOBALS["l_import_files"]["sameName_overwrite"]);
		$content .= we_forms::radiobutton(
				"rename", 
				($this->sameName == "rename"), 
				"sameName", 
				$GLOBALS["l_import_files"]["sameName_rename"]);
		$content .= we_forms::radiobutton(
				"nothing", 
				($this->sameName == "nothing"), 
				"sameName", 
				$GLOBALS["l_import_files"]["sameName_nothing"]);
		
		array_push(
				$parts, 
				array(
					
						"headline" => $GLOBALS["l_import_files"]["sameName_headline"], 
						"html" => $content, 
						"space" => 120
				));
		
		if (we_hasPerm("NEW_GRAFIK")) {
			array_push(
					$parts, 
					array(
						
							'headline' => $GLOBALS["l_import_files"]["metadata"] . '', 
							'html' => we_forms::checkboxWithHidden(
									$this->importMetadata == true, 
									'importMetadata', 
									$GLOBALS["l_import_files"]["import_metadata"]), 
							'space' => 120
					));
			
			if (we_image_edit::gd_version() > 0) {
				
				array_push(
						$parts, 
						array(
							
								"headline" => $GLOBALS["l_import_files"]["make_thumbs"], 
								"html" => $_thumbs, 
								"space" => 120
						));
				
				$widthInput = htmlTextInput("width", "10", $this->width, "", '', "text", 60);
				$heightInput = htmlTextInput("height", "10", $this->height, "", '', "text", 60);
				
				$widthSelect = '<select size="1" class="weSelect" name="widthSelect"><option value="pixel"' . (($this->widthSelect == "pixel") ? ' selected="selected"' : '') . '>' . $GLOBALS["l_we_class"]["pixel"] . '</option><option value="percent"' . (($this->widthSelect == "percent") ? ' selected="selected"' : '') . '>' . $GLOBALS["l_we_class"]["percent"] . '</option></select>';
				$heightSelect = '<select size="1" class="weSelect" name="heightSelect"><option value="pixel"' . (($this->heightSelect == "pixel") ? ' selected="selected"' : '') . '>' . $GLOBALS["l_we_class"]["pixel"] . '</option><option value="percent"' . (($this->heightSelect == "percent") ? ' selected="selected"' : '') . '>' . $GLOBALS["l_we_class"]["percent"] . '</option></select>';
				
				$ratio_checkbox = we_forms::checkbox(
						"1", 
						$this->keepRatio, 
						"keepRatio", 
						$GLOBALS["l_thumbnails"]["ratio"]);
				
				$_resize = '<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<td class="defaultfont">' . $GLOBALS["l_we_class"]["width"] . ':</td>
					<td>' . $widthInput . '</td>
					<td>' . $widthSelect . '</td>
				</tr>
				<tr>
					<td class="defaultfont">' . $GLOBALS["l_we_class"]["height"] . ':</td>
					<td>' . $heightInput . '</td>
					<td>' . $heightSelect . '</td>
				</tr>
				<tr>
					<td colspan="3">' . $ratio_checkbox . '</td>
				</tr>
			</table>';
				
				array_push(
						$parts, 
						array(
							"headline" => $GLOBALS["l_we_class"]["resize"], "html" => $_resize, "space" => 120
						));
				
				$_radio0 = we_forms::radiobutton(
						"0", 
						$this->degrees == 0, 
						"degrees", 
						$GLOBALS["l_we_class"]["rotate0"]);
				$_radio180 = we_forms::radiobutton(
						"180", 
						$this->degrees == 180, 
						"degrees", 
						$GLOBALS["l_we_class"]["rotate180"]);
				$_radio90l = we_forms::radiobutton(
						"90", 
						$this->degrees == 90, 
						"degrees", 
						$GLOBALS["l_we_class"]["rotate90l"]);
				$_radio90r = we_forms::radiobutton(
						"270", 
						$this->degrees == 270, 
						"degrees", 
						$GLOBALS["l_we_class"]["rotate90r"]);
				
				array_push(
						$parts, 
						array(
							
								"headline" => $GLOBALS["l_we_class"]["rotate"], 
								"html" => $_radio0 . $_radio180 . $_radio90l . $_radio90r, 
								"space" => 120
						));
				
				array_push(
						$parts, 
						array(
							
								"headline" => $GLOBALS["l_we_class"]["quality"], 
								"html" => we_qualitySelect("quality", $this->quality), 
								"space" => 120
						));
			} else {
				array_push(
						$parts, 
						array(
							
								"headline" => "", 
								"html" => htmlAlertAttentionBox(
										$GLOBALS["l_import_files"]["add_description_nogdlib"], 
										2, 
										""), 
								"space" => 0
						));
			}
			$foldAT = 4;
		} else {
			$foldAT = -1;
		}
		
		$wepos = weGetCookieVariable("but_wesiteimport");
		$content = we_multiIconBox::getJS();
		$content .= we_multiIconBox::getHTML(
				"wesiteimport", 
				"100%", 
				$parts, 
				30, 
				"", 
				$foldAT, 
				$GLOBALS["l_import_files"]["image_options_open"], 
				$GLOBALS["l_import_files"]["image_options_close"], 
				($wepos == "down"), 
				$GLOBALS["l_siteimport"]["siteimport"]) . $this->_getHiddensHTML();
		
		$content = we_htmlElement::htmlForm(
				array(
					
						"action" => WEBEDITION_DIR . "we_cmd.php", 
						"name" => "we_form", 
						"method" => "post", 
						"target" => "siteimportcmd"
				), 
				$content);
		
		$body = we_htmlElement::htmlBody(array(
			"class" => "weDialogBody", "onunload" => "doUnload();"
		), $content);
		
		$js = $this->_getJS();
		
		return $this->_getHtmlPage($body, $js);
	}

	/**
	 * returns HTML of the buttons frame
	 *
	 * @return	string
	 */
	function _getButtonsHTML()
	{
		
		if ($this->step == 1) {
			$this->_fillFiles();
			if (count($this->_files) == 0) {
				$importDirectory = ereg_replace(
						"^(.*)/$", 
						'\1', 
						ereg_replace("^(.*)/$", '\1', $_SERVER["DOCUMENT_ROOT"]) . $this->from);
				if (count(scandir($importDirectory)) <= 2) {
					return '<script type="text/javascript>alert(\'' . addslashes(
							$GLOBALS["l_import_files"]["emptyDir"]) . '\');top.close()</script>';
				} else {
					return '<script type="text/javascript>alert(\'' . addslashes(
							$GLOBALS["l_import_files"]["noFiles"]) . '\');top.close()</script>';
				}
			}
			$fr = new siteimportFrag($this);
			return "";
		}
		
		$bodyAttribs = array(
			"class" => "weDialogButtonsBody"
		);
		
		$we_button = new we_button();
		$cancelButton = $we_button->create_button(
				"cancel", 
				"javascript:top.close()", 
				true, 
				100, 
				22, 
				"", 
				"", 
				false, 
				false);
		
		$js = "function back() {\n" . "	top.location.href='" . WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=import&we_cmd[1]=siteImport';\n" . "}\n\n" . 

		"function next() {\n" . "	var testvalue = 0;;\n" . "	if(!top.siteimportcontent.document.we_form.from.value  || top.siteimportcontent.document.we_form.from.value=='/'){\n" . "		testvalue += 1;\n" . "	}\n" . "	if(top.siteimportcontent.document.we_form.to.value == 0 || top.siteimportcontent.document.we_form.to.value == ''){\n" . "		testvalue += 2;\n" . "	}\n" . "	switch(testvalue){\n" . "		case 0:\n" . "			top.siteimportcontent.document.we_form.submit()\n" . "			break;\n" . "		case 1:\n" . "			if(confirm('" . $GLOBALS["l_import_files"]["root_dir_1"] . "')){\n" . "				top.siteimportcontent.document.we_form.submit()\n" . "			}\n" . "			break;\n" . "		case 2:\n" . "			if(confirm('" . $GLOBALS["l_import_files"]["root_dir_2"] . "')){\n" . "				top.siteimportcontent.document.we_form.submit()\n" . "			}\n" . "			break;\n" . "		case 3:\n" . "			if(confirm('" . $GLOBALS["l_import_files"]["root_dir_3"] . "')){\n" . "				top.siteimportcontent.document.we_form.submit()\n" . "			}\n" . "			break;\n" . "		default:\n" . "	}\n" . "}\n\n";
		
		$js = we_htmlElement::jsElement($js);
		
		$prevButton = $we_button->create_button("back", "javascript:back();", true, 100, 22, "", "", false, false);
		$nextButton = $we_button->create_button("next", "javascript:next();", true, 100, 22, "", "", false, false);
		
		$prevNextButtons = $we_button->create_button_table(array(
			$prevButton, $nextButton
		));
		
		$pb = new we_progressBar(0);
		$pb->setStudLen(200);
		$pb->addText("&nbsp;", 0, "progressTxt");
		print $pb->getJS();
		
		$table = new we_htmlTable(array(
			"border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "100%"
		), 1, 2);
		$table->setCol(0, 0, null, '<div id="progressBarDiv" style="display:none;">' . $pb->getHTML() . '</div>');
		$table->setCol(0, 1, array(
			"align" => "right"
		), $we_button->position_yes_no_cancel($prevNextButtons, null, $cancelButton, 10, '', array(), 10));
		$content = $table->getHtmlCode();
		$body = we_htmlElement::htmlBody($bodyAttribs, $content);
		return $this->_getHtmlPage($body, $js);
	}

	/**
	 * used by importFile() internal Function, dont call directly!
	 *
	 * @param $content string
	 * @param &$we_doc we_webEditionDocument
	 * @param $sourcePath string
	 * @static
	 */
	function _importWebEditionPage($content, &$we_doc, $sourcePath)
	{
		$data = (isset($_SESSION["prefs"]["siteImportPrefs"]) && $_SESSION["prefs"]["siteImportPrefs"]) ? unserialize(
				$_SESSION["prefs"]["siteImportPrefs"]) : array();
		
		$_valueCreateType = isset($data["valueCreateType"]) ? $data["valueCreateType"] : "auto";
		$_valueTemplateId = isset($data["valueTemplateId"]) ? $data["valueTemplateId"] : 0;
		$_valueUseRegex = isset($data["valueUseRegex"]) ? $data["valueUseRegex"] : 0;
		$_valueFieldValues = isset($data["valueFieldValues"]) ? unserialize($data["valueFieldValues"]) : array();
		$_valueDateFormat = isset($data["valueDateFormat"]) ? $data["valueDateFormat"] : "unix";
		$_valueDateFormatField = isset($data["valueDateFormatField"]) ? $data["valueDateFormatField"] : "d.m.Y";
		$_valueTemplateName = isset($data["valueTemplateName"]) ? $data["valueTemplateName"] : "neueVorlage";
		$_valueTemplateParentID = isset($data["valueTemplateParentID"]) ? $data["valueTemplateParentID"] : "";
		
		$content = weSiteImport::_makeAbsolutPathOfContent($content, $sourcePath, $we_doc->ParentPath);
		
		if ($_valueCreateType == "auto") {
			weSiteImport::_importAuto($content, $we_doc, $_valueTemplateName, $_valueTemplateParentID);
		} else {
			weSiteImport::_importSpecify(
					$content, 
					$we_doc, 
					$_valueTemplateId, 
					$_valueUseRegex, 
					$_valueFieldValues, 
					$_valueDateFormat, 
					$_valueDateFormatField);
		}
	}

	/**
	 * converts a relative path to an absolute path and returns it
	 *
	 * @param $path string path to convert
	 * @param $sourcePath string path of source file
	 * @param $parentPath string parent path
	 * @return string
	 * @static
	 */
	function _makeAbsolutePath($path, $sourcePath, $parentPath)
	{
		if (!preg_match('|^[a-z]+://|i', $path)) {
			if (substr($path, 0, 1) == "/") {
				// if href is an absolute URL convert it into a relative URL
				$path = makeRelativePath($sourcePath, $path);
			} else 
				if (substr($path, 0, 2) == "./") {
					// if href is a relative URL starting with "./" remove the "./"
					$path = substr($path, 2);
				}
			// Make absolute Path out of it
			while (substr($path, 0, 3) == "../" && strlen($parentPath) > 0 && $parentPath != "/") {
				$parentPath = dirname($parentPath);
				$path = substr($path, 3);
			}
			if (substr($parentPath, -1) != "/") {
				$parentPath = $parentPath . "/";
			}
			return $parentPath . $path;
		}
		return $path;
	}

	/**
	 * returns HTML for path information (in webEdition page settings dialog)
	 *
	 * @param $templateName string name of template
	 * @param $myid int id of template dir
	 * @return string
	 * @static
	 */
	function _formPathHTML($templateName = "neueVorlage", $myid = 0)
	{
		global $l_we_class;
		
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weSuggest.class.inc.php");
		
		$path = id_to_path($myid, TEMPLATES_TABLE);
		$we_button = new we_button();
		$table = TEMPLATES_TABLE;
		$textname = 'templateDirName';
		$idname = 'templateParentID';
		
		$button = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDirselector',document.forms['we_form'].elements['$idname'].value,'$table','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','','" . session_id() . "')");
		
		$yuiSuggest = & weSuggest::getInstance();
		$yuiSuggest->setAcId("TplPath");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($textname, $path);
		$yuiSuggest->setResult($idname, 0);
		$yuiSuggest->setLabel($l_we_class["dir"]);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(1);
		$yuiSuggest->setWidth(320);
		$yuiSuggest->setTable($table);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setSelectButton($button);
		$dirChooser = $yuiSuggest->getYuiFiles() . $yuiSuggest->getHTML() . $yuiSuggest->getYuiCode();
		
		/*
		
		$dirChooser = htmlFormElementTable(htmlTextInput($textname,30,$path,"",' readonly',"text",320,0),
			$l_we_class["dir"],
			"left",
			"defaultfont",
			hidden($idname,0),
			getPixel(20,4),
			$button);
*/
		
		$content = '
			<table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
				<tr>
					<td>
						' . htmlFormElementTable(
				htmlTextInput("templateName", 30, $templateName, 255, "", "text", 320), 
				$GLOBALS["l_siteimport"]["nameOfTemplate"]) . '</td>
					<td></td>
					<td>
						' . htmlFormElementTable(
				'<span class="defaultfont"><b>.tmpl</b></span>', 
				$l_we_class["extension"]) . '</td>
				</tr>
				<tr>
					<td>
						' . getPixel(20, 4) . '</td>
					<td>
						' . getPixel(20, 2) . '</td>
					<td>
						' . getPixel(100, 2) . '</td>
				</tr>
				<tr>
					<td colspan="3">
						' . $dirChooser . '</td>
				</tr>
			</table>';
		return $content;
	}

	/**
	 * converts all relative paths of a document to absolute paths and returns the converted document
	 *
	 * @param $content string document to convert
	 * @param $sourcePath string path of source file
	 * @param $parentPath string parent path
	 * @return string
	 * @static
	 */
	function _makeAbsolutPathOfContent($content, $sourcePath, $parentPath)
	{
		$sourcePath = substr($sourcePath, strlen($_SERVER['DOCUMENT_ROOT']));
		if (substr($sourcePath, 0, 1) != "/") {
			$sourcePath = "/" . $sourcePath;
		}
		
		// replace hrefs
		preg_match_all(
				'/(<[^>]+href=["\']?)([^"\' >]+)([^"\'>]?[^>]*>)/i', 
				$content, 
				$regs, 
				PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$orig_href = $regs[2][$i];
				$new_href = weSiteImport::_makeAbsolutePath($orig_href, $sourcePath, $parentPath);
				if ($new_href != $orig_href) {
					$newTag = $regs[1][$i] . $new_href . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		// replace src (same as href!!)
		preg_match_all(
				'/(<[^>]+src=["\']?)([^"\' >]+)([^"\'>]?[^>]*>)/i', 
				$content, 
				$regs, 
				PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$orig_href = $regs[2][$i];
				$new_href = weSiteImport::_makeAbsolutePath($orig_href, $sourcePath, $parentPath);
				if ($new_href != $orig_href) {
					$newTag = $regs[1][$i] . $new_href . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		// url() in styles with style=""
		preg_match_all('/(<[^>]+style=")([^"]+)("[^>]*>)/i', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				preg_match_all('/(url\(\'?)([^\'\)]+)(\'?\))/i', $style, $regs2, PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeAbsolutePath($orig_url, $sourcePath, $parentPath);
						if ($orig_url != $new_url) {
							$newStyle = str_replace($orig_url, $new_url, $newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		
		// url() in styles with style=''
		preg_match_all('/(<[^>]+style=\')([^\']+)(\'[^>]*>)/i', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				preg_match_all('/(url\("?)([^"\)]+)("?\))/i', $style, $regs2, PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeAbsolutePath($orig_url, $sourcePath, $parentPath);
						if ($orig_url != $new_url) {
							$newStyle = str_replace($orig_url, $new_url, $newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		
		// url() in <style> tags
		preg_match_all('/(<style[^>]*>)(.*)(<\/style>)/isU', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				// url() in styles with style=''
				preg_match_all(
						'/(url\([\'"]?)([^\'"\)]+)([\'"]?\))/iU', 
						$style, 
						$regs2, 
						PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeAbsolutePath($orig_url, $sourcePath, $parentPath);
						if ($orig_url != $new_url) {
							$newStyle = str_replace(
									$regs2[0][$z], 
									$regs2[1][$z] . $new_url . $regs2[3][$z], 
									$newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		return $content;
	}

	/**
	 * internal function, used by _importWebEditionPage() => don't call directly!
	 * @param $content string
	 * @param &$we_doc we_webEditionDocument
	 * @param $templateFilename string
	 * @param $templateParentID int
	 * @static
	 */
	function _importAuto($content, &$we_doc, $templateFilename, $templateParentID)
	{
		
		$textareaCode = '<we:textarea name="content" wysiwyg="true" width="800" height="600" xml="true" inlineedit="true"/>';
		$titleCode = "<we:title />";
		$descriptionCode = "<we:description />";
		$keywordsCode = "<we:keywords />";
		
		$title = "";
		$description = "";
		$keywords = "";
		$charset = "";
		
		// check if we have a body start and end tag
		if (preg_match('/<body[^>]*>(.*)<\/body>/is', $content, $regs)) {
			$bodyhtml = $regs[1];
			$templateCode = preg_replace('/(.*<body[^>]*>).*(<\/body>.*)/is', "$1$textareaCode$2", $content);
		} else {
			$bodyhtml = $content;
			$templateCode = $textareaCode;
		}
		
		// try to get title, description, keywords and charset
		if (preg_match('/<title[^>]*>(.*)<\/title>/is', $content, $regs)) {
			$title = $regs[1];
			$templateCode = preg_replace('/<title[^>]*>.*<\/title>/is', "$titleCode", $templateCode);
		}
		if (preg_match('/<meta ([^>]*)name="description"([^>]*)>/is', $content, $regs)) {
			if (preg_match('/content="([^"]+)"/is', $regs[1], $attr)) {
				$description = $attr[1];
			} else 
				if (preg_match('/content="([^"]+)"/is', $regs[2], $attr)) {
					$description = $attr[1];
				}
			$templateCode = preg_replace('/<meta [^>]*name="description"[^>]*>/is', "$descriptionCode", $templateCode);
		}
		if (preg_match('/<meta ([^>]*)name="keywords"([^>]*)>/is', $content, $regs)) {
			if (preg_match('/content="([^"]+)"/is', $regs[1], $attr)) {
				$keywords = $attr[1];
			} else 
				if (preg_match('/content="([^"]+)"/is', $regs[2], $attr)) {
					$keywords = $attr[1];
				}
			$templateCode = preg_replace('/<meta [^>]*name="keywords"[^>]*>/is', "$keywordsCode", $templateCode);
		}
		if (preg_match('/<meta ([^>]*)http-equiv="content-type"([^>]*)>/is', $content, $regs)) {
			if (preg_match('/content="([^"]+)"/is', $regs[1], $attr)) {
				if (preg_match('/charset=([^ "\']+)/is', $attr[1], $cs)) {
					$charset = $cs[1];
				}
			} else 
				if (preg_match('/content="([^"]+)"/is', $regs[2], $attr)) {
					if (preg_match('/charset=([^ "\']+)/is', $attr[1], $cs)) {
						$charset = $cs[1];
					}
				}
			$templateCode = preg_replace(
					'/<meta [^>]*http-equiv="content-type"[^>]*>/is', 
					'<we:charset defined="' . $charset . '">' . $charset . '</we:charset>', 
					$templateCode);
		}
		
		// replace external css (link rel=stylesheet)
		preg_match_all('/<link ([^>]+)>/i', $templateCode, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[1]); $i++) {
				preg_match_all('/([^= ]+)=[\'"]?([^\'" ]+)[\'"]?/is', $regs[1][$i], $regs2, PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[1]); $z++) {
						$attribs[$regs2[1][$z]] = $regs2[2][$z];
					}
					if (isset($attribs["rel"]) && $attribs["rel"] == "stylesheet") {
						if (isset($attribs["href"]) && $attribs["href"]) {
							$id = path_to_id($attribs["href"]);
							$tag = '<we:css id="' . $id . '" xml="true" ' . ((isset($attribs["media"]) && $attribs["media"]) ? ' pass_media="' . $attribs["media"] . '"' : '') . '/>';
							$templateCode = str_replace($regs[0][$i], $tag, $templateCode);
						}
					}
				}
			}
		}
		
		// replace external js scripts
		preg_match_all('/<script ([^>]+)>.*<\/script>/isU', $templateCode, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[1]); $i++) {
				preg_match('/src=["\']?([^"\']+)["\']?/is', $regs[1][$i], $regs2);
				if ($regs2 != null) {
					$id = path_to_id($regs2[1]);
					$tag = '<we:js id="' . $id . '" xml="true" />';
					$templateCode = str_replace($regs[0][$i], $tag, $templateCode);
				}
			}
		}
		
		// check if there is allready a template with the same content
		

		$newTemplateID = f(
				"SELECT " . LINK_TABLE . ".DID AS DID FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND " . CONTENT_TABLE . ".Dat='" . addslashes(
						$templateCode) . "' AND " . LINK_TABLE . ".DocumentTable='" . substr(
						TEMPLATES_TABLE, 
						strlen(TBL_PREFIX)) . "'", 
				"DID", 
				$GLOBALS['DB_WE']);
		
		if (!$newTemplateID) {
			// create Template
			

			$newTemplateFilename = $templateFilename;
			$GLOBALS['DB_WE']->query(
					"SELECT Filename FROM " . TEMPLATES_TABLE . " WHERE ParentID=" . abs($templateParentID) . " AND Filename like '" . addslashes(
							$templateFilename) . "%'");
			$result = array();
			if ($GLOBALS['DB_WE']->num_rows()) {
				while ($GLOBALS['DB_WE']->next_record()) {
					array_push($result, $GLOBALS['DB_WE']->f("Filename"));
				}
			}
			$z = 1;
			while (in_array($newTemplateFilename, $result)) {
				$newTemplateFilename = $templateFilename . $z;
				$z++;
			}
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_template.inc.php");
			$templateObject = new we_template();
			$templateObject->we_new();
			$templateObject->CreationDate = time();
			$templateObject->ID = 0;
			$templateObject->OldPath = "";
			$templateObject->Extension = ".tmpl";
			$templateObject->Filename = $newTemplateFilename;
			$templateObject->Text = $templateObject->Filename . $templateObject->Extension;
			$templateObject->setParentID($templateParentID);
			$templateObject->Path = $templateObject->ParentPath . ($templateParentID ? "/" : "") . $templateObject->Text;
			$templateObject->OldPath = $templateObject->Path;
			$templateObject->setElement("data", $templateCode, "txt");
			$templateObject->we_save();
			$templateObject->we_publish();
			$templateObject->setElement("Charset", $charset);
			$newTemplateID = $templateObject->ID;
		}
		
		$we_doc->setTemplateID($newTemplateID);
		$we_doc->setElement("content", $bodyhtml);
		$we_doc->setElement("Title", $title);
		$we_doc->setElement("Keywords", $keywords);
		$we_doc->setElement("Description", $description);
		$we_doc->setElement("Charset", $charset);
	}

	/**
	 * internal function, used by _importWebEditionPage() => don't call directly!
	 * @param $content string
	 * @param &$we_doc we_webEditionDocument
	 * @param $templateId int
	 * @param $useRegex boolean
	 * @param $fieldValues array
	 * @param $dateFormat string
	 * @param $dateFormatValue string
	 * @static
	 */
	function _importSpecify($content, &$we_doc, $templateId, $useRegex, $fieldValues, $dateFormat, $dateFormatValue)
	{
		
		// TODO width & height of image
		

		// get field infos of template
		$_templateFields = weSiteImport::_getFieldsFromTemplate($templateId);
		
		foreach ($fieldValues as $field) {
			if (isset($field["pre"]) && $field["pre"] && isset($field["post"]) && $field["post"] && isset(
					$field["name"]) && $field["name"]) {
				$fieldval = "";
				$field["pre"] = str_replace("\r\n", "\n", $field["pre"]);
				$field["pre"] = str_replace("\r", "\n", $field["pre"]);
				$field["post"] = str_replace("\r\n", "\n", $field["post"]);
				$field["post"] = str_replace("\r", "\n", $field["post"]);
				if (!$useRegex) {
					$prepos = strpos($content, $field["pre"]);
					$postpos = strpos($content, $field["post"], abs($prepos));
					if ($prepos !== false && $postpos !== false && $prepos < $postpos) {
						$prepos += strlen($field["pre"]);
						$fieldval = substr($content, $prepos, $postpos - $prepos);
					}
				} else {
					if (preg_match(
							'/' . str_replace('/', '\/', str_replace('(', '\(', $field["pre"])) . '(.+)' . str_replace(
									'/', 
									'\/', 
									str_replace('(', '\(', $field["post"])) . '/isU', 
							$content, 
							$regs)) {
						$fieldval = $regs[1];
					}
				}
				// only set field if field exists in template
				if (isset($_templateFields[$field["name"]])) {
					
					if ($_templateFields[$field["name"]] == "date") { // import date fields
						switch ($dateFormat) {
							case "unix" :
								$fieldval = abs($fieldval);
								break;
							
							case "gmt" :
								$fieldval = importFunctions::date2Timestamp(trim($fieldval), "");
								break;
							
							case "own" :
								$fieldval = importFunctions::date2Timestamp(trim($fieldval), $dateFormatValue);
								break;
						}
						$we_doc->setElement($field["name"], abs($fieldval), "date");
					} else 
						if ($_templateFields[$field["name"]] == "img") { // import image fields
							if (preg_match(
									'/<[^>]+src=["\']?([^"\' >]+)[^"\'>]?[^>]*>/i', 
									$fieldval, 
									$regs)) { // only if image tag has a src attribute
								$src = $regs[1];
								$imgId = path_to_id($src);
								$we_doc->elements[$field["name"]] = array();
								$we_doc->elements[$field["name"]]["type"] = "img";
								$we_doc->elements[$field["name"]]["bdid"] = $imgId;
							}
						} else {
							$we_doc->setElement($field["name"], trim($fieldval));
						}
				}
			}
		}
		$we_doc->setTemplateID($templateId);
	
	}

	/**
	 * converts an external  link (src or href) into an internal
	 * @param $href string
	 * @return string
	 * @static
	 */
	function _makeInternalLink($href)
	{
		$id = path_to_id_ct($href, FILE_TABLE, $ct);
		if (substr($ct, 0, 5) == "text/") {
			$href = "document:$id";
		} else 
			if ($ct == "image/*") {
				if (strpos($href, "?") === false) {
					$href .= "?id=$id";
				}
			}
		return $href;
	}

	/**
	 * converts all external links in a HTML page to internal links
	 * @param $content string
	 * @return string
	 * @static
	 */
	function _external_to_internal($content)
	{
		// replace hrefs
		preg_match_all(
				'/(<[^>]+href=["\']?)([^"\' >]+)([^"\'>]?[^>]*>)/i', 
				$content, 
				$regs, 
				PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$orig_href = $regs[2][$i];
				$new_href = weSiteImport::_makeInternalLink($orig_href);
				if ($new_href != $orig_href) {
					$newTag = $regs[1][$i] . $new_href . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		// replace src (same as href!!)
		preg_match_all(
				'/(<[^>]+src=["\']?)([^"\' >]+)([^"\'>]?[^>]*>)/i', 
				$content, 
				$regs, 
				PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$orig_href = $regs[2][$i];
				$new_href = weSiteImport::_makeInternalLink($orig_href);
				if ($new_href != $orig_href) {
					$newTag = $regs[1][$i] . $new_href . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		// url() in styles with style=""
		preg_match_all('/(<[^>]+style=")([^"]+)("[^>]*>)/i', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				preg_match_all('/(url\(\'?)([^\'\)]+)(\'?\))/i', $style, $regs2, PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeInternalLink($orig_url);
						if ($orig_url != $new_url) {
							$newStyle = str_replace($orig_url, $new_url, $newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		
		// url() in styles with style=''
		preg_match_all('/(<[^>]+style=\')([^\']+)(\'[^>]*>)/i', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				preg_match_all('/(url\("?)([^"\)]+)("?\))/i', $style, $regs2, PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeInternalLink($orig_url);
						if ($orig_url != $new_url) {
							$newStyle = str_replace($orig_url, $new_url, $newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		
		// url() in <style> tags
		preg_match_all('/(<style[^>]*>)(.*)(<\/style>)/isU', $content, $regs, PREG_PATTERN_ORDER);
		if ($regs != null) {
			for ($i = 0; $i < count($regs[2]); $i++) {
				$style = $regs[2][$i];
				$newStyle = $style;
				// url() in styles with style=''
				preg_match_all(
						'/(url\([\'"]?)([^\'"\)]+)([\'"]?\))/iU', 
						$style, 
						$regs2, 
						PREG_PATTERN_ORDER);
				if ($regs2 != null) {
					for ($z = 0; $z < count($regs2[2]); $z++) {
						$orig_url = $regs2[2][$z];
						$new_url = weSiteImport::_makeInternalLink($orig_url);
						if ($orig_url != $new_url) {
							$newStyle = str_replace(
									$regs2[0][$z], 
									$regs2[1][$z] . $new_url . $regs2[3][$z], 
									$newStyle);
						}
					}
				}
				if ($newStyle != $style) {
					$newTag = $regs[1][$i] . $newStyle . $regs[3][$i];
					$content = str_replace($regs[0][$i], $newTag, $content);
				}
			}
		}
		
		return $content;
	}

	/**
	 * this routine is called after normal import for each webEdition file. it is e.g. responsible for converting relative links to absolute links
	 *
	 * @param $path string
	 * @param $sourcePath string
	 * @param $destinationDirID int
	 * @return array
	 * @static
	 */
	function postprocessFile($path, $sourcePath, $destinationDirID)
	{
		$we_docSave = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : null;
		
		$doc = null;
		
		// preparing Paths
		$path = str_replace("\\", "/", $path); // change windoof backslashes to slashes
		$sourcePath = str_replace("\\", "/", $sourcePath); // change windoof backslashes to slashes
		$sizeofdocroot = strlen(ereg_replace("^(.*)/$", '\1', $_SERVER["DOCUMENT_ROOT"])); // make sure that no ending slash is there
		$sizeofsourcePath = strlen(ereg_replace("^(.*)/$", '\1', $sourcePath)); // make sure that no ending slash is there
		$destinationDir = id_to_path($destinationDirID);
		if ($destinationDir == "/") {
			$destinationDir = "";
		}
		$destinationPath = $destinationDir . substr($path, $sizeofdocroot + $sizeofsourcePath);
		$id = path_to_id($destinationPath);
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_webEditionDocument.inc.php");
		$GLOBALS["we_doc"] = new we_webEditionDocument();
		$GLOBALS["we_doc"]->initByID($id);
		
		// we need to get the name of the fields which needs to processed
		foreach ($GLOBALS['we_doc']->elements as $fieldname => $element) {
			if ($fieldname != "Title" && $fieldname != "Description" && $fieldname != "Keywords" && $fieldname != "Charset") {
				switch ($element["type"]) {
					case "txt" :
						$GLOBALS['we_doc']->elements[$fieldname]["dat"] = weSiteImport::_external_to_internal(
								$element["dat"]);
						break;
				}
			}
		}
		//save and publish
		if (!$GLOBALS["we_doc"]->we_save()) {
			$GLOBALS["we_doc"] = $we_docSave;
			return array(
				"filename" => $_FILES['we_File']["name"], "error" => "save_error"
			);
		}
		if (!$GLOBALS["we_doc"]->we_publish()) {
			$GLOBALS["we_doc"] = $we_docSave;
			return array(
				"filename" => $_FILES['we_File']["name"], "error" => "publish_error"
			);
		}
		
		$GLOBALS["we_doc"] = $we_docSave;
		return array();
	}

	/**
	 * this routine is called from task fragment class eaxch time a document/filder is imported
	 *
	 * @param $path string
	 * @param $contentType string
	 * @param $sourcePath string
	 * @param $destinationDirID int
	 * @param $sameName boolean
	 * @param $thumbs boolean
	 * @param $width int
	 * @param $height int
	 * @param $widthSelect string
	 * @param $heightSelect string
	 * @param $keepRatio bool
	 * @param $quality int
	 * @param $degrees int
	 * @return array
	 * @static
	 */
	function importFile($path, $contentType, $sourcePath, $destinationDirID, $sameName, $thumbs, $width, $height, $widthSelect, $heightSelect, $keepRatio, $quality, $degrees, $importMetadata = true)
	{
		
		$we_docSave = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : null;
		
		$doc = null;
		
		// preparing Paths
		$path = str_replace("\\", "/", $path); // change windoof backslashes to slashes
		$sourcePath = str_replace("\\", "/", $sourcePath); // change windoof backslashes to slashes
		$sizeofdocroot = strlen(ereg_replace("^(.*)/$", '\1', $_SERVER["DOCUMENT_ROOT"])); // make sure that no ending slash is there
		$sizeofsourcePath = strlen(ereg_replace("^(.*)/$", '\1', $sourcePath)); // make sure that no ending slash is there
		$destinationDir = id_to_path($destinationDirID);
		if ($destinationDir == "/") {
			$destinationDir = "";
		}
		$destinationPath = $destinationDir . substr($path, $sizeofdocroot + $sizeofsourcePath);
		$parentDirPath = dirname($destinationPath);
		
		$parentID = path_to_id($parentDirPath);
		$data = "";
		// get Data of File
		if (!is_dir($path) && filesize($path) > 0) {
			$fp = fopen($path, "rb");
			$data = fread($fp, filesize($path));
			fclose($fp);
		}
		
		$we_ContentType = $contentType;
		
		// initializing $we_doc
		include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_editors/we_init_doc.inc.php");
		
		// initialize Path Information
		$GLOBALS["we_doc"]->we_new();
		$GLOBALS["we_doc"]->ContentType = $contentType;
		$GLOBALS["we_doc"]->Text = basename($path);
		if ($contentType == "folder") {
			$GLOBALS["we_doc"]->Filename = $GLOBALS["we_doc"]->Text;
		} else {
			if (ereg('^(.+)(\.[^\.]+)$', $GLOBALS["we_doc"]->Text, $regs)) {
				$GLOBALS["we_doc"]->Extension = $regs[2];
				$GLOBALS["we_doc"]->Filename = $regs[1];
			} else {
				$GLOBALS["we_doc"]->Extension = "";
				$GLOBALS["we_doc"]->Filename = $GLOBALS["we_doc"]->Text;
			}
		}
		$GLOBALS["we_doc"]->Path = $destinationPath;
		$GLOBALS["we_doc"]->ParentID = $parentID;
		$GLOBALS["we_doc"]->ParentPath = $GLOBALS["we_doc"]->getParentPath();
		
		$id = path_to_id($destinationPath);
		if ($id) {
			if ($sameName == "overwrite" || $contentType == "folder") { // folders we dont have to rename => we can use the existing folder
				$GLOBALS["we_doc"]->initByID($id, FILE_TABLE);
			} else 
				if ($sameName == "rename") {
					$z = 0;
					$footext = $GLOBALS["we_doc"]->Filename . "_" . $z . $GLOBALS["we_doc"]->Extension;
					while (f(
							"SELECT ID FROM " . FILE_TABLE . " WHERE Text='$footext' AND ParentID='" . $parentID . "'", 
							"ID", 
							$GLOBALS["DB_WE"])) {
						$z++;
						$footext = $GLOBALS["we_doc"]->Filename . "_" . $z . $GLOBALS["we_doc"]->Extension;
					}
					$GLOBALS["we_doc"]->Text = $footext;
					$GLOBALS["we_doc"]->Filename = $GLOBALS["we_doc"]->Filename . "_" . $z;
					$GLOBALS["we_doc"]->Path = $GLOBALS["we_doc"]->getParentPath() . (($GLOBALS["we_doc"]->getParentPath() != "/") ? "/" : "") . $GLOBALS["we_doc"]->Text;
				} else {
					return array(
						"filename" => $GLOBALS["we_doc"]->Path, "error" => "same_name"
					);
				}
		}
		
		$GLOBALS["we_doc"]->IsSearchable = 0;
		
		// initialize Content
		switch ($contentType) {
			case "text/webedition" :
				weSiteImport::_importWebEditionPage($data, $GLOBALS["we_doc"], $sourcePath);
				$GLOBALS["we_doc"]->IsSearchable = 1;
				break;
			case "folder" :
				break;
			case "image/*" :
				// getting attributes of image
				$foo = $GLOBALS["we_doc"]->getimagesize($path);
				$GLOBALS["we_doc"]->setElement("width", $foo[0], "attrib");
				$GLOBALS["we_doc"]->setElement("height", $foo[1], "attrib");
				$GLOBALS["we_doc"]->setElement("origwidth", $foo[0]);
				$GLOBALS["we_doc"]->setElement("origheight", $foo[1]);
			// no break!! because we need to do the same after the following case
			case "application/*" :
			case "application/x-shockwave-flash" :
			case "movie/quicktime" :
				$GLOBALS["we_doc"]->setElement("data", $path, "image");
				break;
			case "text/html" :
				$GLOBALS["we_doc"]->IsSearchable = 1;
			case "text/plain" :
			case "text/js" :
			case "text/css" :
			default :
				// set Data of File
				$GLOBALS["we_doc"]->setElement("data", $data, "txt");
		}
		
		if ($contentType == "image/*") {
			$GLOBALS["we_doc"]->Thumbs = $thumbs;
			$newWidth = 0;
			$newHeight = 0;
			if ($width) {
				if ($widthSelect == "percent") {
					$newWidth = round(($GLOBALS["we_doc"]->getElement("origwidth") / 100) * $width);
				} else {
					$newWidth = $width;
				}
			}
			if ($height) {
				if ($widthSelect == "percent") {
					$newHeight = round(($GLOBALS["we_doc"]->getElement("origheight") / 100) * $height);
				} else {
					$newHeight = $height;
				}
			}
			if (($newWidth && ($newWidth != $GLOBALS["we_doc"]->getElement("origwidth"))) || ($newHeight && ($newHeight != $GLOBALS["we_doc"]->getElement(
					"origheight")))) {
				
				$GLOBALS["we_doc"]->resizeImage($newWidth, $newHeight, $quality, $keepRatio);
				$width = $newWidth;
				$height = $newHeight;
			}
			
			if ($degrees) {
				$GLOBALS["we_doc"]->rotateImage(
						($degrees % 180 == 0) ? $GLOBALS["we_doc"]->getElement("origwidth") : $GLOBALS["we_doc"]->getElement(
								"origheight"), 
						($degrees % 180 == 0) ? $GLOBALS["we_doc"]->getElement("origheight") : $GLOBALS["we_doc"]->getElement(
								"origwidth"), 
						$degrees, 
						$quality);
			}
			$GLOBALS["we_doc"]->DocChanged = true;
		}
		//save and publish
		if (!$GLOBALS["we_doc"]->we_save()) {
			$GLOBALS["we_doc"] = $we_docSave;
			return array(
				"filename" => $_FILES['we_File']["name"], "error" => "save_error"
			);
		}
		if ($contentType == "image/*" && $importMetadata) {
			$GLOBALS["we_doc"]->importMetaData();
			$GLOBALS["we_doc"]->we_save();
		}
		if (!$GLOBALS["we_doc"]->we_publish()) {
			$GLOBALS["we_doc"] = $we_docSave;
			return array(
				"filename" => $_FILES['we_File']["name"], "error" => "publish_error"
			);
		}
		$GLOBALS["we_doc"] = $we_docSave;
		return array();
	
	}

	/**
	 * this function is called right before starting to import the files
	 *
	 */
	function _fillFiles()
	{
		// directory from which we import (real path)
		$importDirectory = ereg_replace(
				"^(.*)/$", 
				'\1', 
				ereg_replace("^(.*)/$", '\1', $_SERVER["DOCUMENT_ROOT"]) . $this->from);
		
		// when running on windows we have to change slashes to backslashes
		if (runAtWin()) {
			$importDirectory = str_replace("/", "\\", $importDirectory);
		}
		$this->_files = array();
		$this->_depth = 0;
		$this->_postProcess = array();
		$this->_fillDirectories($importDirectory);
		// sort it so that webEdition files are at the end (that templates know about css and js files)
		

		$tmp = array();
		foreach ($this->_files as $e) {
			if ($e["contentType"] == "folder") {
				array_push($tmp, $e);
			}
		}
		foreach ($this->_files as $e) {
			if ($e["contentType"] != "folder" && $e["contentType"] != "text/webedition") {
				array_push($tmp, $e);
			}
		}
		foreach ($this->_files as $e) {
			if ($e["contentType"] == "text/webedition") {
				array_push($tmp, $e);
			}
		}
		
		$this->_files = $tmp;
		
		foreach ($this->_postProcess as $e) {
			array_push($this->_files, $e);
		}
	}

	/**
	 * this function fills the $this->files and $this->_postProcess arrays
	 * @param $importDirectory string
	 */
	function _fillDirectories($importDirectory)
	{
		
		@set_time_limit(60);
		
		$weDirectory = ereg_replace("^(.*)/$", '\1', $_SERVER["DOCUMENT_ROOT"]) . "/webEdition";
		if ($importDirectory == $weDirectory) { // we do not import stuff from the webEdition home dir
			return;
		}
		
		// go throuh all files of the directory
		$d = dir($importDirectory);
		while (false !== ($entry = $d->read())) {
			if ($entry == '.' || $entry == '..' || ((strlen($entry) >= 2) && substr($entry, 0, 2) == "._"))
				continue;
				// now we have to check if the file should be imported
			$PathOfEntry = $importDirectory . $this->_slash . $entry;
			if (!is_dir($PathOfEntry) && ($this->maxSize && (filesize($PathOfEntry) > (abs($this->maxSize) * 1024 * 1024))))
				continue;
			$contentType = getContentTypeFromFile($PathOfEntry);
			$importIt = false;
			
			switch ($contentType) {
				case "image/*" :
					if ($this->images) {
						$importIt = true;
					}
					break;
				case "text/html" :
					if ($this->htmlPages) {
						if ($this->createWePages) {
							$contentType = "text/webedition";
							// webEdition files needs to be post processed (external links => internal links)
							array_push(
									$this->_postProcess, 
									array(
										
											"path" => $PathOfEntry, 
											"contentType" => "post/process", 
											"sourceDir" => $this->from, 
											"destDirID" => $this->to
									));
						}
						$importIt = true;
					}
					break;
				case "application/x-shockwave-flash" :
					if ($this->flashmovies) {
						$importIt = true;
					}
					break;
				case "video/quicktime" :
					if ($this->quicktime) {
						$importIt = true;
					}
					break;
				case "text/js" :
					if ($this->js) {
						$importIt = true;
					}
					break;
				case "text/plain" :
					if ($this->text) {
						$importIt = true;
					}
					break;
				case "text/css" :
					if ($this->css) {
						$importIt = true;
					}
					break;
				case "folder" :
					$importIt = false;
					break;
				default :
					if ($this->other) {
						$importIt = true;
					}
					break;
			}
			
			if ($importIt) {
				array_push(
						$this->_files, 
						array(
							
								"path" => $PathOfEntry, 
								"contentType" => $contentType, 
								"sourceDir" => $this->from, 
								"destDirID" => $this->to, 
								"sameName" => $this->sameName, 
								"thumbs" => $this->thumbs, 
								"width" => $this->width, 
								"height" => $this->height, 
								"widthSelect" => $this->widthSelect, 
								"heightSelect" => $this->heightSelect, 
								"keepRatio" => $this->keepRatio, 
								"quality" => $this->quality, 
								"degrees" => $this->degrees, 
								"importMetadata" => $this->importMetadata
						));
			}
			if ($contentType == "folder") {
				if (($this->depth == -1) || (abs($this->depth) > $this->_depth)) {
					array_push(
							$this->_files, 
							array(
								
									"path" => $PathOfEntry, 
									"contentType" => $contentType, 
									"sourceDir" => $this->from, 
									"destDirID" => $this->to, 
									"sameName" => $this->sameName, 
									"thumbs" => "", 
									"width" => "", 
									"height" => "", 
									"widthSelect" => "", 
									"heightSelect" => "", 
									"keepRatio" => "", 
									"quality" => "", 
									"degrees" => "", 
									"importMetadata" => 0
							));
					$this->_depth++;
					$this->_fillDirectories($PathOfEntry);
					$this->_depth--;
				}
			}
		}
		$d->close();
	}

	/**
	 * returns hidden fields
	 * @return string
	 */
	function _getHiddensHTML()
	{
		$content = we_htmlElement::htmlHidden(array(
			"name" => "we_cmd[0]", "value" => "siteImport"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "cmd", "value" => "buttons"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "step", "value" => "1"
		));
		return $content;
	}

	function _getFrameset()
	{
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
		
		$frameset = new we_htmlFrameset(array(
			"framespacing" => "0", "border" => "0", "frameborder" => "no"
		));
		$noframeset = new we_baseElement("noframes");
		
		$frameset->setAttributes(array(
			"rows" => "*,40,0"
		));
		$frameset->addFrame(
				array(
					
						"src" => WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=siteImport&cmd=content", 
						"name" => "siteimportcontent", 
						"scrolling" => "auto", 
						"noresize" => null
				));
		$frameset->addFrame(
				array(
					
						"src" => WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=siteImport&cmd=buttons", 
						"name" => "siteimportbuttons", 
						"scrolling" => "no"
				));
		$frameset->addFrame(array(
			"src" => "about:blank", "name" => "siteimportcmd", "scrolling" => "no"
		));
		
		// set and return html code
		$body = $frameset->getHtmlCode() . "\n" . we_baseElement::getHtmlCode($noframeset);
		
		return $this->_getHtmlPage($body);
	}

	function _getHtmlPage($body, $js = "")
	{
		$head = WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . $js . "\n";
		return we_htmlElement::htmlHtml(we_htmlElement::htmlHead($head) . $body);
	}
}

class siteimportFrag extends taskFragment
{

	var $_obj = null;

	function siteimportFrag($obj)
	{
		$this->_obj = $obj;
		parent::taskFragment(
				"siteImport", 
				1, 
				0, 
				array(
					"marginwidth" => 15, "marginheight" => 10, "leftmargin" => 15, "topmargin" => 10
				));
	}

	function init()
	{
		$this->alldata = $this->_obj->_files;
	}

	function doTask()
	{
		$path = substr($this->data["path"], strlen($_SERVER["DOCUMENT_ROOT"]));
		$progress = (int)((100 / count($this->alldata)) * $this->currentTask);
		$progressText = shortenPath($path, 30);
		
		$code = '<script type="text/javascript" language="JavaScript">
top.siteimportbuttons.document.getElementById("progressBarDiv").style.display="block";
top.siteimportbuttons.weButton.disable("back");
top.siteimportbuttons.weButton.disable("next");
top.siteimportbuttons.setProgress(' . $progress . ');
top.siteimportbuttons.document.getElementById("progressTxt").innerHTML="' . htmlspecialchars(
				$progressText, 
				ENT_QUOTES) . '";
</script>
';
		
		if ($this->data["contentType"] == "post/process") {
			weSiteImport::postprocessFile($this->data["path"], $this->data["sourceDir"], $this->data["destDirID"]);
		} else {
			weSiteImport::importFile(
					$this->data["path"], 
					$this->data["contentType"], 
					$this->data["sourceDir"], 
					$this->data["destDirID"], 
					$this->data["sameName"], 
					$this->data["thumbs"], 
					$this->data["width"], 
					$this->data["height"], 
					$this->data["widthSelect"], 
					$this->data["heightSelect"], 
					$this->data["keepRatio"], 
					$this->data["quality"], 
					$this->data["degrees"], 
					$this->data["importMetadata"]);
		
		}
		print $code;
	}

	function finish()
	{
		print 
				"<script type=\"text/javascript\">top.siteimportbuttons.setProgress(100);</script>\n<script type=\"text/javascript\">setTimeout('" . we_message_reporting::getShowMessageCall(
						$GLOBALS["l_siteimport"]["importFinished"], 
						WE_MESSAGE_NOTICE) . "top.close();',100);top.opener.top.we_cmd('load','" . FILE_TABLE . "');</script>";
	}

	function printHeader()
	{
		print "<html>\n" . we_htmlElement::htmlHead(WE_DEFAULT_HEAD . STYLESHEET);
	}
}

function we_siteimport_sort($a, $b)
{
	if ($a["contentType"] == "text/webedition" && $b["contentType"] != "text/webedition") {
		return 1;
	} else 
		if ($a["contentType"] != "text/webedition" && $b["contentType"] == "text/webedition") {
			return -1;
		}
	return 0;
}

$import_object = new weSiteImport();

print $import_object->getHTML();

?>