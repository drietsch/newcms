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
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_import/importFunctions.class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/import_files.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/we_class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/thumbnails.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_image_edit.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/" . "weSuggest.class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_browser_check.inc.php");

protect();

class we_import_files
{

	var $importToID = 0;

	var $step = 0;

	var $sameName = "overwrite";

	var $importMetadata = true;

	var $cmd = "";

	var $thumbs = "";

	var $width = "";

	var $height = "";

	var $widthSelect = "pixel";

	var $heightSelect = "pixel";

	var $keepRatio = 1;

	var $quality = 8;

	var $degrees = 0;

	var $categories = '';

	function we_import_files()
	{
		
		if (isset($_REQUEST['categories'])) {
			$_catarray = makeArrayFromCSV($_REQUEST['categories']);
			$_cats = array();
			foreach ($_catarray as $_cat) {
				// bugfix Workarround #700
				if (is_numeric($_cat)) {
					$_cats[] = $_cat;
				} else {
					$_cats[] = path_to_id($_cat, CATEGORY_TABLE);
				}
			}
			$_REQUEST['categories'] = makeCSVFromArray($_cats);
		}
		
		$this->categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : $this->categories;
		$this->importToID = isset($_REQUEST["importToID"]) ? $_REQUEST["importToID"] : $this->importToID;
		$this->sameName = isset($_REQUEST["sameName"]) ? $_REQUEST["sameName"] : $this->sameName;
		$this->importMetadata = isset($_REQUEST["importMetadata"]) ? $_REQUEST["importMetadata"] : $this->importMetadata;
		$this->step = isset($_REQUEST["step"]) ? $_REQUEST["step"] : $this->step;
		$this->cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : $this->cmd;
		$this->thumbs = isset($_REQUEST["thumbs"]) ? $_REQUEST["thumbs"] : $this->thumbs;
		$this->width = isset($_REQUEST["width"]) ? $_REQUEST["width"] : $this->width;
		$this->height = isset($_REQUEST["height"]) ? $_REQUEST["height"] : $this->height;
		$this->widthSelect = isset($_REQUEST["widthSelect"]) ? $_REQUEST["widthSelect"] : $this->widthSelect;
		$this->heightSelect = isset($_REQUEST["heightSelect"]) ? $_REQUEST["heightSelect"] : $this->heightSelect;
		$this->keepRatio = isset($_REQUEST["keepRatio"]) ? $_REQUEST["keepRatio"] : $this->keepRatio;
		$this->quality = isset($_REQUEST["quality"]) ? $_REQUEST["quality"] : $this->quality;
		$this->degrees = isset($_REQUEST["degrees"]) ? $_REQUEST["degrees"] : $this->degrees;
	
	}

	function getHTML()
	{
		switch ($this->cmd) {
			case "content" :
				return $this->_getContent();
				break;
			case "buttons" :
				return $this->_getButtons();
				break;
			default :
				return $this->_getFrameset();
		}
	}

	function _getJS($fileinput)
	{
		$js = "
				function makeArrayFromCSV(csv) {
					if(csv.length && csv.substring(0,1)==\",\"){csv=csv.substring(1,csv.length);}
					if(csv.length && csv.substring(csv.length-1,csv.length)==\",\"){csv=csv.substring(0,csv.length-1);}
					if(csv.length==0){return new Array();}else{return csv.split(/,/);};
				}

				function inArray(needle,haystack){
					for(var i=0;i<haystack.length;i++){
						if(haystack[i] == needle){return true;}
					}
					return false;
				}

				function makeCSVFromArray(arr) {
					if(arr.length == 0){return \"\";};
					return \",\"+arr.join(\",\")+\",\";
				}
				function we_cmd(){
					var args = '';
					var url = '" . WEBEDITION_DIR . "we_cmd.php?'; for(var i = 0; i < arguments.length; i++){ url += 'we_cmd['+i+']='+escape(arguments[i]); if(i < (arguments.length - 1)){ url += '&'; }}

					switch (arguments[0]){
						case 'openDirselector':
							new jsWindow(url,'we_fileselector',-1,-1," . WINDOW_DIRSELECTOR_WIDTH . "," . WINDOW_DIRSELECTOR_HEIGHT . ",true,true,true,true);
							break;
						case 'openCatselector':
							new jsWindow(url,'we_catselector',-1,-1," . WINDOW_CATSELECTOR_WIDTH . "," . WINDOW_CATSELECTOR_HEIGHT . ",true,true,true,true);
						break;
					}
				}";
		
		$js .= 'var we_fileinput = \'<form name="we_upload_form_WEFORMNUM" method="post" action="' . WEBEDITION_DIR . 'we_cmd.php" enctype="multipart/form-data" target="imgimportbuttons">' . ereg_replace(
				"[\n\r]", 
				" ", 
				$this->_getHiddens("buttons", $this->step + 1)) . $fileinput . '</form>\';
				function checkFileinput(){
					var prefix =  "trash_";
					var imgs = document.getElementsByTagName("IMG");
					if(document.forms[document.forms.length-1].name.substring(0,14) == "we_upload_form" && document.forms[document.forms.length-1].elements["we_File"].value){
						for(var i = 0; i<imgs.length; i++){
							if(imgs[i].id.length > prefix.length && imgs[i].id.substring(0,prefix.length) == prefix){
									imgs[i].style.display="";
							}
						}
						//weAppendMultiboxRow(we_fileinput.replace(/WEFORMNUM/g,weGetLastMultiboxNr()),\'' . $GLOBALS["l_import_files"]["file"] . '\' + \' \' + (parseInt(weGetMultiboxLength())),80,1);
						var fi = we_fileinput.replace(/WEFORMNUM/g,weGetLastMultiboxNr());
						fi = fi.replace(/WE_FORM_NUM/g,(document.forms.length));
						weAppendMultiboxRow(fi,"",0,1);
						window.scrollTo(0,1000000);
					}
				}

				function we_trashButDown(but){
					if(but.src.indexOf("disabled") == -1){
						but.src = "' . IMAGE_DIR . '/button/btn_function_trash_down.gif";
					}
				}
				function we_trashButUp(but){
					if(but.src.indexOf("disabled") == -1){
						but.src = "' . IMAGE_DIR . '/button/btn_function_trash.gif";
					}
				}

				function wedelRow(nr,but){
					if(but.src.indexOf("disabled") == -1){
						var prefix =  "uploadFiles_div_";
						var num = -1;
						var z = 0;
						weDelMultiboxRow(nr);
						var divs = document.getElementsByTagName("DIV");
						for(var i = 0; i<divs.length; i++){
							if(divs[i].id.length > prefix.length && divs[i].id.substring(0,prefix.length) == prefix){
								num = divs[i].id.substring(prefix.length,divs[i].id.length);
								if(parseInt(num)){
									var sp = document.getElementById("uploadFiles_headline_"+(num-1));
									if(sp){
										sp.innerHTML = z;
									}
								}
								z++;
							}
						}
					}
				}

				function setApplet() {

					var descDiv = document.getElementById("desc");
					if(descDiv.style.display!="none"){
						var descJUDiv = document.getElementById("descJupload");
						var buttDiv = top.imgimportbuttons.document.getElementById("normButton");
						var buttJUDiv = top.imgimportbuttons.document.getElementById("juButton");

						descDiv.style.display="none";
						buttDiv.style.display="none";
						descJUDiv.style.display="block";
						buttJUDiv.style.display="block";
					}

					setTimeout("document.JUpload.jsRegisterUploaded(\"refreshTree\");",3000);
				}

				function refreshTree() {
					top.opener.top.we_cmd("load","' . FILE_TABLE . '");
				}

				function uploadFinished() {
					refreshTree();
					' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_import_files"]["finished"], 
				WE_MESSAGE_NOTICE) . '
				}

				';
		
		$js = we_htmlElement::jsElement($js) . "\n";
		$js .= we_htmlElement::jsElement("", array(
			"src" => JS_DIR . "windows.js"
		)) . "\n";
		return $js;
	}

	function _getContent()
	{
		
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		$_funct = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
		$_funct = 'getStep' . $_funct;
		
		return $this->$_funct();
	
	}

	function getStep1()
	{
		global $BROWSER;
		$yuiSuggest = & weSuggest::getInstance();
		$this->loadPropsFromSession();
		unset($_SESSION["WE_IMPORT_FILES_ERRORs"]);
		
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		// create Start Screen ##############################################################################
		

		$we_button = new we_button();
		
		$parts = array();
		$selectorSpace = $BROWSER == "IE" ? 16 : 280;
		$wsA = makeArrayFromCSV(get_def_ws());
		$ws = sizeof($wsA) ? $wsA[0] : 0;
		$store_id = $this->importToID ? $this->importToID : $ws;
		
		$path = id_to_path($store_id);
		
		$button = $we_button->create_button(
				"select", 
				"javascript:we_cmd('openDirselector',document.we_startform.importToID.value,'" . FILE_TABLE . "','document.we_startform.importToID.value','document.we_startform.egal.value','','','0')");
		$content = hidden('we_cmd[0]', 'import_files') . hidden('cmd', 'content') . hidden('step', '2'); // fix for categories require reload!
		$content .= we_htmlElement::htmlHidden(array(
			'name' => 'categories', 'value' => ''
		));
		
		$yuiSuggest->setAcId("Dir");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput("egal", $path);
		$yuiSuggest->setLabel($GLOBALS["l_we_class"]["path"]);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult("importToID", $store_id);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setWidth(260);
		$yuiSuggest->setSelectButton($button);
		
		$content .= $yuiSuggest->getHTML();
		
		array_push(
				$parts, 
				array(
					
						"headline" => $GLOBALS["l_import_files"]["destination_dir"], 
						"html" => $content, 
						"space" => 150
				));
		
		$content = htmlAlertAttentionBox($GLOBALS["l_import_files"]["sameName_expl"], 2, 380);
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
						"space" => 150
				));
		
		// categoryselector
		

		if (we_hasPerm("EDIT_KATEGORIE")) {
			
			array_push(
					$parts, 
					array(
						
							'headline' => $GLOBALS["l_global"]["categorys"] . '', 
							'html' => $this->getHTMLCategory(), 
							'space' => 150
					));
		
		}
		
		if (we_hasPerm("NEW_GRAFIK")) {
			
			array_push(
					$parts, 
					array(
						
							'headline' => $GLOBALS["l_import_files"]["metadata"] . '', 
							'html' => we_forms::checkboxWithHidden(
									$this->importMetadata == true, 
									'importMetadata', 
									$GLOBALS["l_import_files"]["import_metadata"]), 
							'space' => 150
					));
			
			if (we_image_edit::gd_version() > 0) {
				$GLOBALS["DB_WE"]->query("SELECT ID,Name FROM " . THUMBNAILS_TABLE . " Order By Name");
				$Thselect = $GLOBALS["l_import_files"]["thumbnails"] . "<br>" . getPixel(1, 3) . "<br>" . '<select class="defaultfont" name="thumbs_tmp" size="5" multiple style="width: 260px" onchange="this.form.thumbs.value=\'\';for(var i=0;i<this.options.length;i++){if(this.options[i].selected){this.form.thumbs.value +=(this.options[i].value+\',\');}};this.form.thumbs.value=this.form.thumbs.value.replace(/^(.+),$/,\'$1\');">' . "\n";
				
				$thumbsArray = makeArrayFromCSV($this->thumbs);
				while ($GLOBALS["DB_WE"]->next_record()) {
					$Thselect .= '<option value="' . $GLOBALS["DB_WE"]->f("ID") . '"' . (in_array(
							$GLOBALS["DB_WE"]->f("ID"), 
							$thumbsArray) ? " selected" : "") . '>' . $GLOBALS["DB_WE"]->f("Name") . "</option>\n";
				}
				$Thselect .= "</select>\n" . '<input type="hidden" name="thumbs" value="' . $this->thumbs . '">' . "\n";
				
				if (!(defined("ISP_VERSION") && ISP_VERSION)) {
					
					array_push(
							$parts, 
							array(
								
									"headline" => $GLOBALS["l_import_files"]["make_thumbs"], 
									"html" => $Thselect, 
									"space" => 150
							));
				}
				
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
							"headline" => $GLOBALS["l_we_class"]["resize"], "html" => $_resize, "space" => 150
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
								"space" => 150
						));
				
				array_push(
						$parts, 
						array(
							
								"headline" => $GLOBALS["l_we_class"]["quality"], 
								"html" => we_qualitySelect("quality", $this->quality), 
								"space" => 150
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
			$foldAt = 3;
		} else {
			$foldAt = -1;
		}
		$wepos = weGetCookieVariable("but_weimportfiles");
		$content = we_multiIconBox::getJS();
		$content .= we_multiIconBox::getHTML(
				"weimportfiles", 
				"99%", 
				$parts, 
				30, 
				"", 
				$foldAt, 
				$GLOBALS["l_import_files"]["image_options_open"], 
				$GLOBALS["l_import_files"]["image_options_close"], 
				($wepos == "down"), 
				$GLOBALS["l_import_files"]["step1"]);
		$startsrceen = we_htmlElement::htmlDiv(
				array(
					"id" => "start"
				), 
				we_htmlElement::htmlForm(
						array(
							
								"action" => WEBEDITION_DIR . "we_cmd.php", 
								//"action"=>WEBEDITION_DIR."/we/include/we_import_files.inc.php",
								"name" => "we_startform", 
								"method" => "post"
						), 
						$content));
		
		$body = we_htmlElement::htmlBody(array(
			"class" => "weDialogBody"
		), $startsrceen . $yuiSuggest->getYuiCss() . $yuiSuggest->getYuiJs());
		
		return $this->_getHtmlPage($body, $this->_getJS(''));
	
	}

	function getStep2()
	{
		
		$this->savePropsInSession();
		
		// create Second Screen ##############################################################################
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		$but = we_htmlElement::htmlImg(
				array(
					
						"src" => IMAGE_DIR . "pixel.gif", 
						"width" => "10", 
						"height" => "22", 
						"border" => "0", 
						"align" => "absmiddle"
				));
		$but .= we_htmlElement::htmlImg(
				array(
					
						"src" => IMAGE_DIR . '/button/btn_function_trash.gif', 
						"width" => "27", 
						"height" => "22", 
						"border" => "0", 
						"align" => "absmiddle", 
						"onMouseDown" => "we_trashButDown(this)", 
						"onMouseUp" => "we_trashButUp(this)", 
						"onMouseOut" => "we_trashButUp(this)", 
						"unselectable" => "on", 
						"style" => "-moz-user-select: none;display: none;cursor:pointer;", 
						"id" => "trash_WEFORMNUM", 
						"onclick" => "wedelRow(WEFORMNUM + 1,this)"
				));
		$but = ereg_replace("[\n\r]", " ", $but);
		
		$parts = array();
		$maxsize = getUploadMaxFilesize(false, $GLOBALS["DB_WE"]);
		$maxsize = round($maxsize / (1024 * 1024), 3) . "MB";
		
		$content = hidden('we_cmd[0]', 'import_files') . hidden('cmd', 'content') . hidden('step', '2') . we_htmlElement::htmlDiv(
				array(
					'id' => 'desc'
				), 
				htmlAlertAttentionBox(sprintf($GLOBALS["l_import_files"]["import_expl"], $maxsize), 2, "520", false)) . we_htmlElement::htmlDiv(
				array(
					'id' => 'descJupload', 'style' => 'display:none;'
				), 
				htmlAlertAttentionBox(
						sprintf($GLOBALS["l_import_files"]["import_expl_jupload"], $maxsize), 
						2, 
						"520", 
						false));
		
		array_push(
				$parts, 
				array(
					"headline" => "", "html" => $content, "space" => 0
				));
		
		$fileinput = we_htmlElement::htmlInput(
				array(
					
						"name" => "we_File", 
						"type" => "file", 
						"size" => "40", 
						"onclick" => "checkFileinput();", 
						"onchange" => "checkFileinput();"
				)) . $but;
		
		$fileinput = '<table><tr><td valign="top" class="weMultiIconBoxHeadline">' . $GLOBALS["l_import_files"]["file"] . '&nbsp;<span id="uploadFiles_headline_WEFORMNUM">WE_FORM_NUM</span></td><td>' . getPixel(
				35, 
				5) . '</td><td>' . $fileinput . '</td></tr></table>';
		
		$form_content = $this->_getHiddens("buttons", $this->step);
		$form_content .= str_replace("WE_FORM_NUM", "1", $fileinput);
		$form_content = str_replace("WEFORMNUM", "0", $form_content);
		$formhtml = we_htmlElement::htmlForm(
				array(
					
						"action" => WEBEDITION_DIR . "we_cmd.php", 
						"name" => "we_upload_form_0", 
						"method" => "post", 
						"enctype" => "multipart/form-data", 
						"target" => "imgimportbuttons"
				), 
				$form_content);
		
		// JUpload part0
		

		if (getPref('use_jupload') && file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/jupload/jupload.jar')) {
			
			include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/jupload/weJUpload.class.php');
			
			$_param = array(
				
					'actionURL' => '/webEdition/jupload/import.php?jupl=1&csid=' . session_id(), 
					'maxTotalRequestSize' => getUploadMaxFilesize(false, $GLOBALS["DB_WE"]), 
					'showTabViews' => 'list,details', 
					'leftSplitpaneLocation' => '200', 
					'hideStopButton' => 'true', 
					'localeCountry' => 'DE', 
					'localeLanguage' => 'de', 
					'realTimeResponse' => 'false', 
					//'completeURL'=>'javascript:top.imgimportcontent.uploadFinished();'
					'completeURL' => 'we_cmd.php?we_cmd[0]=import_files&step=3'
			)
			;
			
			if (($GLOBALS["BROWSER"] == "NN6" && $GLOBALS["SYSTEM"] == 'MAC')) {
				// in FF Mac java upload replaces location of frame
				$_param['completeURL'] = 'we_cmd.php?we_cmd[0]=import_files&cmd=content&step=3';
			}
			
			if (defined('HTTP_USERNAME')) {
				$_ecnode = HTTP_USERNAME;
				if (defined('HTTP_PASSWORD')) {
					$_ecnode .= ':' . HTTP_PASSWORD;
				}
				$_param['usePresetAuthentification'] = base64_encode($_ecnode);
			}
			
			$_weju = new weJUpload($_param, $GLOBALS['WE_LANGUAGE']);
			$formhtml = $_weju->getAppletTag($formhtml, 530, 300);
		}
		
		// ---
		

		array_push(
				$parts, 
				array(
					"headline" => '', "html" => $formhtml, "space" => 0
				));
		
		$content = we_htmlElement::htmlDiv(
				array(
					"id" => "forms", "style" => "display:block"
				), 
				
				(getPref('use_jupload') ? we_htmlElement::htmlForm(array(
					"name" => "JUploadForm"
				), "") : "") . we_htmlElement::htmlForm(
						array(
							
								"action" => WEBEDITION_DIR . "we_cmd.php", 
								"name" => "we_startform", 
								"method" => "post"
						), 
						$this->_getHiddens()) . we_multiIconBox::getHTML(
						"uploadFiles", 
						"100%", 
						$parts, 
						30, 
						"", 
						-1, 
						"", 
						"", 
						"", 
						$GLOBALS["l_import_files"]["step2"]));
		
		$body = we_htmlElement::htmlBody(
				array(
					
						"class" => "weDialogBody", 
						"onMouseMove" => "if(typeof(document.JUpload)=='undefined') checkFileinput(); else setApplet();", 
						"onload" => "if(typeof(document.JUpload)!='undefined') setApplet();"
				), 
				$content);
		
		$js = $this->_getJS($fileinput) . "\n" . we_multiIconBox::getDynJS("uploadFiles", "30");
		
		return $this->_getHtmlPage($body, $js);
	
	}

	function getStep3()
	{
		
		// create Second Screen ##############################################################################
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		$parts = array();
		
		if (isset($_SESSION["WE_IMPORT_FILES_ERRORs"])) {
			
			$filelist = "";
			foreach ($_SESSION["WE_IMPORT_FILES_ERRORs"] as $err) {
				$filelist .= "- " . $err["filename"] . " => " . $GLOBALS["l_import_files"][$err["error"]] . '<br>';
			}
			unset($_SESSION["WE_IMPORT_FILES_ERRORs"]);
			
			$parts[] = array(
				
					'html' => htmlAlertAttentionBox(
							sprintf(str_replace('\n', '<br>', $GLOBALS["l_import_files"]["error"]), $filelist), 
							1, 
							"520", 
							false)
			);
		
		} else {
			
			$parts[] = array(
				'html' => htmlAlertAttentionBox($GLOBALS["l_import_files"]["finished"], 2, "520", false)
			);
		
		}
		
		$content = we_htmlElement::htmlForm(
				array(
					"action" => WEBEDITION_DIR . "we_cmd.php", "name" => "we_startform", "method" => "post"
				), 
				we_htmlElement::htmlHidden(array(
					'name' => 'step', 'value' => '3'
				)) . we_multiIconBox::getHTML(
						"uploadFiles", 
						"100%", 
						$parts, 
						30, 
						"", 
						-1, 
						"", 
						"", 
						"", 
						$GLOBALS["l_import_files"]["step3"]))// bugfix 1001
;
		
		$body = we_htmlElement::htmlBody(array(
			"class" => "weDialogBody"
		), $content);
		return $this->_getHtmlPage($body);
	}

	function _getButtons()
	{
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_progressBar.inc.php");
		
		$bodyAttribs = array(
			"class" => "weDialogButtonsBody"
		);
		
		if ($this->step == 1) {
			$bodyAttribs["onload"] = "next();";
			$error = $this->importFile();
			if (sizeof($error)) {
				if (!isset($_SESSION["WE_IMPORT_FILES_ERRORs"])) {
					$_SESSION["WE_IMPORT_FILES_ERRORs"] = array();
				}
				array_push($_SESSION["WE_IMPORT_FILES_ERRORs"], $error);
			}
		}
		
		$we_button = new we_button();
		
		$cancelButton = $we_button->create_button("cancel", "javascript:top.close()");
		$closeButton = $we_button->create_button("close", "javascript:top.close()");
		
		$progressbar = "";
		$formnum = (isset($_REQUEST["weFormNum"]) ? $_REQUEST["weFormNum"] : 0);
		$formcount = (isset($_REQUEST["weFormCount"]) ? $_REQUEST["weFormCount"] : 0);
		$js = $we_button->create_state_changer(false) . "\n";
		
		$js .= 'var weFormNum = ' . $formnum . ';
	var weFormCount = ' . $formcount . ';

	function back() {
		if(top.imgimportcontent.document.we_startform.step.value=="2") {
			top.location.href="' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=import&we_cmd[1]=import_files";
		} else {
			top.location.href="' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=import_files";
		}

	}
	
	function weCheckAC(j){
		if(top.imgimportcontent.YAHOO.autocoml){
			feld = top.imgimportcontent.YAHOO.autocoml.checkACFields();
			if(j<30){
				if(feld.running) {
					setTimeout("weCheckAC(j++)",100);
				} else {
					return feld.valid
				}
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	function next() {
		if(!weCheckAC(1)) return false;
		if (top.imgimportcontent.document.getElementById("start") && top.imgimportcontent.document.getElementById("start").style.display != "none") {
			' . (we_hasPerm(
				'EDIT_KATEGORIE') ? 'top.imgimportcontent.selectCategories();' : '') . '
			top.imgimportcontent.document.we_startform.submit();
		} else {
			if(weFormNum == weFormCount && weFormNum != 0){
				document.getElementById("progressbar").style.display = "none";
';
		
		if (isset($_SESSION["WE_IMPORT_FILES_ERRORs"]) && $formnum == $formcount && $formnum != 0) {
			
			$filelist = "";
			foreach ($_SESSION["WE_IMPORT_FILES_ERRORs"] as $err) {
				$filelist .= "- " . $err["filename"] . " => " . $GLOBALS["l_import_files"][$err["error"]] . "\\n";
			}
			unset($_SESSION["WE_IMPORT_FILES_ERRORs"]);
			$js .= "			" . we_message_reporting::getShowMessageCall(
					sprintf($GLOBALS["l_import_files"]["error"], $filelist), 
					WE_MESSAGE_ERROR) . "\n";
		} else {
			$js .= "			" . we_message_reporting::getShowMessageCall(
					$GLOBALS["l_import_files"]["finished"], 
					WE_MESSAGE_NOTICE) . "\n";
		}
		
		$js .= "			top.opener.top.we_cmd('load','" . FILE_TABLE . "');\n" . "			top.close();\n" . "			return;\n" . "		}\n" . "		forms = top.imgimportcontent.document.forms;\n" . "		var z=0;\n" . "		var sameName=top.imgimportcontent.document.we_startform.sameName.value;\n" . "		var prefix =  'trash_';\n" . "		var imgs = top.imgimportcontent.document.getElementsByTagName('IMG');\n" . "		for(var i = 0; i<imgs.length; i++){\n" . "			if(imgs[i].id.length > prefix.length && imgs[i].id.substring(0,prefix.length) == prefix){\n" . "					imgs[i].src='" . IMAGE_DIR . "/button/btn_function_trash_dis.gif';\n" . "					imgs[i].style.cursor='default';\n" . "			}\n" . "		}\n" . "		for(var i=0; i<forms.length;i++){\n" . "			if(forms[i].name.substring(0,14) == 'we_upload_form') {\n" . "				if(z == weFormNum && forms[i].we_File.value != ''){\n" . "					forms[i].importToID.value = top.imgimportcontent.document.we_startform.importToID.value;\n" . ((we_image_edit::gd_version() > 0) ? ("					forms[i].thumbs.value = top.imgimportcontent.document.we_startform.thumbs.value;\n" . "					forms[i].width.value = top.imgimportcontent.document.we_startform.width.value;\n" . "					forms[i].height.value = top.imgimportcontent.document.we_startform.height.value;\n" . "					forms[i].widthSelect.value = top.imgimportcontent.document.we_startform.widthSelect.value;\n" . "					forms[i].heightSelect.value = top.imgimportcontent.document.we_startform.heightSelect.value;\n" . "					forms[i].keepRatio.value = top.imgimportcontent.document.we_startform.keepRatio.checked ? 1 : 0;\n" . "					forms[i].quality.value = top.imgimportcontent.document.we_startform.quality.value;\n" . "					for(var n=0;n<top.imgimportcontent.document.we_startform.degrees.length;n++){\n" . "						if(top.imgimportcontent.document.we_startform.degrees[n].checked){\n" . "							forms[i].degrees.value = top.imgimportcontent.document.we_startform.degrees[n].value;\nbreak;\n" . "						}\n" . "					}\n") : "") . "					forms[i].sameName.value = sameName;\n" . "					forms[i].weFormNum.value = weFormNum + 1;\n" . "					forms[i].weFormCount.value = forms.length - 2;\n" . "					back_enabled = switch_button_state('back', 'back_enabled', 'disabled');\n" . "					next_enabled = switch_button_state('next', 'next_enabled', 'disabled');\n" . "					document.getElementById('progressbar').style.display = '';\n" . "					forms[i].submit();\n" . "					return;\n" . "				}\n" . "				z++;\n" . "			}\n" . "		}\n" . "	}\n" . "}\n\n";
		
		$js = we_htmlElement::jsElement($js);
		
		$prevButton = $we_button->create_button("back", "javascript:back();", true, -1, -1, "", "", false);
		$prevButton2 = $we_button->create_button("back", "javascript:back();", true, -1, -1, "", "", false, false);
		$nextButton = $we_button->create_button(
				"next", 
				"javascript:next();", 
				true, 
				-1, 
				-1, 
				"", 
				"", 
				$this->step > 0, 
				false);
		
		$prog = ($formcount == 0) ? 0 : (($this->step == 0) ? 0 : ((int)((100 / $formcount) * ($formnum + 1))));
		$pb = new we_progressBar($prog);
		$pb->setStudLen(200);
		$pb->addText(sprintf($GLOBALS["l_import_files"]["import_file"], $formnum + 1), 0, "title");
		$progressbar = '<span id="progressbar"' . (($this->step == 0) ? 'style="display:none' : '') . '">' . $pb->getHTML() . '</span>';
		$js .= $pb->getJSCode();
		
		$prevNextButtons = $prevButton ? $we_button->create_button_table(array(
			$prevButton, $nextButton
		)) : null;
		
		$table = new we_htmlTable(array(
			"border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "100%"
		), 1, 2);
		$table->setCol(0, 0, null, $progressbar);
		$table->setCol(
				0, 
				1, 
				array(
					"align" => "right"
				), 
				we_htmlElement::htmlDiv(array(
					'id' => 'normButton'
				), $we_button->position_yes_no_cancel($prevNextButtons, null, $cancelButton, 10, '', array(), 10)) . we_htmlElement::htmlDiv(
						array(
							'id' => 'juButton', 'style' => 'display:none;'
						), 
						$we_button->position_yes_no_cancel($prevButton2, null, $closeButton, 10, '', array(), 10)));
		
		if ($this->step == 3) {
			$table->setCol(0, 0, null, '');
			$table->setCol(
					0, 
					1, 
					array(
						"align" => "right"
					), 
					we_htmlElement::htmlDiv(array(
						'id' => 'normButton'
					), $we_button->position_yes_no_cancel($prevButton2, null, $closeButton, 10, '', array(), 10)));
		}
		
		$content = $table->getHtmlCode();
		$body = we_htmlElement::htmlBody($bodyAttribs, $content);
		return $this->_getHtmlPage($body, $js);
	}

	function importFile()
	{
		if (isset($_FILES['we_File']) && strlen($_FILES['we_File']["tmp_name"])) {
			$ct = getContentTypeFromFile($_FILES['we_File']["name"]);
			if (!we_hasPerm($GLOBALS["WE_CONTENT_TYPES"][$ct]["Permission"])) {
				return array(
					"filename" => $_FILES['we_File']["name"], "error" => "no_perms"
				);
			}
			$we_ContentType = getContentTypeFromFile($_FILES['we_File']["name"]);
			// initializing $we_doc
			include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_editors/we_init_doc.inc.php");
			$tempName = TMP_DIR . "/" . md5(uniqid(rand(), 1));
			if (!@move_uploaded_file($_FILES['we_File']["tmp_name"], $tempName)) {
				return array(
					"filename" => $_FILES['we_File']["name"], "error" => "move_file_error"
				);
			}
			
			// setting Filename, Path ...
			$_fn = importFunctions::correctFilename($_FILES['we_File']["name"]);
			
			$we_doc->Filename = eregi_replace('^(.+)\..+$', "\\1", $_fn);
			if (stristr($_fn, ".")) {
				$we_doc->Extension = eregi_replace('^.+(\..+)$', "\\1", $_fn);
			} else {
				$we_doc->Extension = "";
			}
			$we_doc->Text = $we_doc->Filename . $we_doc->Extension;
			$we_doc->setParentID($this->importToID);
			$we_doc->Path = $we_doc->getParentPath() . (($we_doc->getParentPath() != "/") ? "/" : "") . $we_doc->Text;
			
			// if file exists we have to see if we should create a new one or overwrite it!
			if ($file_id = f(
					"SELECT ID FROM " . FILE_TABLE . " WHERE Path='" . mysql_real_escape_string($we_doc->Path) . "'", 
					"ID", 
					$GLOBALS["DB_WE"])) {
				if ($this->sameName == "overwrite") {
					eval('$we_doc=new ' . $we_doc->ClassName . '();');
					$we_doc->initByID($file_id, FILE_TABLE);
				} else 
					if ($this->sameName == "rename") {
						$z = 0;
						$footext = $we_doc->Filename . "_" . $z . $we_doc->Extension;
						while (f(
								"SELECT ID FROM " . FILE_TABLE . " WHERE Text='".mysql_real_escape_string($footext)."' AND ParentID='" . abs($this->importToID) . "'", 
								"ID", 
								$GLOBALS["DB_WE"])) {
							$z++;
							$footext = $we_doc->Filename . "_" . $z . $we_doc->Extension;
						}
						$we_doc->Text = $footext;
						$we_doc->Filename = $we_doc->Filename . "_" . $z;
						$we_doc->Path = $we_doc->getParentPath() . (($we_doc->getParentPath() != "/") ? "/" : "") . $we_doc->Text;
					} else {
						return array(
							"filename" => $_FILES['we_File']["name"], "error" => "same_name"
						);
					}
			}
			// now change the category
			$we_doc->Category = $this->categories;
			if ($we_ContentType == "image/*") {
				$we_size = $we_doc->getimagesize($tempName);
				if (is_array($we_size) && count($we_size) >= 2) {
					$we_doc->setElement("width", $we_size[0], "attrib");
					$we_doc->setElement("height", $we_size[1], "attrib");
					$we_doc->setElement("origwidth", $we_size[0]);
					$we_doc->setElement("origheight", $we_size[1]);
				}
			}
			$we_doc->setElement("type", $ct, "attrib");
			$fh = @fopen($tempName, "rb");
			if($_FILES['we_File']["size"]<=0) {
				$_FILES['we_File']["size"] = 1;
			}
			if ($fh) {
				$we_fileData = fread($fh, $_FILES['we_File']["size"]);
				fclose($fh);
			} else {
				return array(
					"filename" => $_FILES['we_File']["name"], "error" => "read_file_error"
				);
			}
			
			$foo = explode("/", $_FILES["we_File"]["type"]);
			if (isset($we_doc->IsBinary) && $we_doc->IsBinary) {
				$we_doc->setElement("data", $tempName);
			} else {
				$we_doc->setElement("data", $we_fileData, $foo[0]);
			}
			
			$we_doc->setElement("filesize", $_FILES['we_File']["size"], "attrib");
			$we_doc->Table = FILE_TABLE;
			$we_doc->Published = time();
			if ($we_ContentType == "image/*") {
				$we_doc->Thumbs = $this->thumbs;
				
				$newWidth = 0;
				$newHeight = 0;
				if ($this->width) {
					if ($this->widthSelect == "percent") {
						$newWidth = round(($we_doc->getElement("origwidth") / 100) * $this->width);
					} else {
						$newWidth = $this->width;
					}
				}
				if ($this->height) {
					if ($this->widthSelect == "percent") {
						$newHeight = round(($we_doc->getElement("origheight") / 100) * $this->height);
					} else {
						$newHeight = $this->height;
					}
				}
				if (($newWidth && ($newWidth != $we_doc->getElement("origwidth"))) || ($newHeight && ($newHeight != $we_doc->getElement(
						"origheight")))) {
					
					$we_doc->resizeImage($newWidth, $newHeight, $this->quality, $this->keepRatio);
					$this->width = $newWidth;
					$this->height = $newHeight;
				}
				
				if ($this->degrees) {
					$we_doc->rotateImage(
							($this->degrees % 180 == 0) ? $we_doc->getElement("origwidth") : $we_doc->getElement(
									"origheight"), 
							($this->degrees % 180 == 0) ? $we_doc->getElement("origheight") : $we_doc->getElement(
									"origwidth"), 
							$this->degrees, 
							$this->quality);
				}
				$we_doc->DocChanged = true;
			
			}
			if (!$we_doc->we_save()) {
				return array(
					"filename" => $_FILES['we_File']["name"], "error" => "save_error"
				);
			}
			if ($we_ContentType == "image/*" && $this->importMetadata) {
				$we_doc->importMetaData();
				$we_doc->we_save();
			}
			if (!$we_doc->we_publish()) {
				return array(
					"filename" => $_FILES['we_File']["name"], "error" => "publish_error"
				);
			}
			if ($we_ContentType == "image/*" && $this->importMetadata) {
				$we_doc->importMetaData();
			}
			return array();
		} else {
			return array(
				"filename" => $_FILES['we_File']["name"], "error" => "php_error"
			);
		}
	}

	function _getHiddens()
	{
		$content = we_htmlElement::htmlHidden(array(
			"name" => "we_cmd[0]", "value" => "import_files"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "cmd", "value" => "buttons"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "step", "value" => "1"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "weFormNum", "value" => "0"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "weFormCount", "value" => "0"
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "importToID", "value" => $this->importToID
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "sameName", "value" => $this->sameName
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "thumbs", "value" => $this->thumbs
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "width", "value" => $this->width
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "height", "value" => $this->height
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "widthSelect", "value" => $this->widthSelect
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "heightSelect", "value" => $this->heightSelect
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "keepRatio", "value" => $this->keepRatio
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "degrees", "value" => $this->degrees
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "quality", "value" => $this->quality
		));
		$content .= we_htmlElement::htmlHidden(array(
			"name" => "categories", "value" => $this->categories
		));
		
		return $content;
	}

	function _getFrameset()
	{
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
		
		$_step = isset($_REQUEST['step']) ? $_REQUEST['step'] : -1;
		
		$frameset = new we_htmlFrameset(array(
			"framespacing" => "0", "border" => "0", "frameborder" => "no"
		));
		$noframeset = new we_baseElement("noframes");
		
		$frameset->setAttributes(array(
			"rows" => "*,40"
		));
		$frameset->addFrame(
				array(
					
						"src" => WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=import_files&cmd=content" . ($_step > -1 ? '&step=' . $_step : ''), 
						"name" => "imgimportcontent", 
						"scrolling" => "auto", 
						"noresize" => null
				));
		$frameset->addFrame(
				array(
					
						"src" => WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=import_files&cmd=buttons" . ($_step > -1 ? '&step=' . $_step : ''), 
						"name" => "imgimportbuttons", 
						"scrolling" => "no"
				));
		
		// set and return html code
		$body = $frameset->getHtmlCode() . "\n" . we_baseElement::getHtmlCode($noframeset);
		
		return $this->_getHtmlPage($body);
	}

	function _getHtmlPage($body, $js = "")
	{
		$yuiSuggest = & weSuggest::getInstance();
		$head = WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . $js . "\n";
		$head .= $yuiSuggest->getYuiCssFiles();
		$head .= $yuiSuggest->getYuiJsFiles();
		return we_htmlElement::htmlHtml(we_htmlElement::htmlHead($head) . $body);
	}

	function getHTMLCategory()
	{
		global $l_navigation;
		
		$we_button = new we_button();
		
		$_width_size = 300;
		
		$addbut = $we_button->create_button(
				"add", 
				"javascript:we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.addCat(top.allPaths);')");
		$del_but = addslashes(
				we_htmlElement::htmlImg(
						array(
							
								'src' => IMAGE_DIR . '/button/btn_function_trash.gif', 
								'onclick' => 'javascript:#####placeHolder#####;', 
								'style' => 'cursor: pointer; width: 27px;-moz-user-select: none;'
						)));
		
		$js = we_htmlElement::jsElement('', array(
			'src' => JS_DIR . 'utils/multi_edit.js?' . time()
		));
		
		$variant_js = '
			var categories_edit = new multi_edit("categoriesDiv",document.we_startform,0,"' . $del_but . '",' . ($_width_size - 10) . ',false);
			categories_edit.addVariant();

		';
		
		$_cats = makeArrayFromCSV($this->categories);
		if (is_array($_cats)) {
			foreach ($_cats as $cat) {
				$variant_js .= '
					categories_edit.addItem();
					categories_edit.setItem(0,(categories_edit.itemCount-1),"' . id_to_path(
						$cat, 
						CATEGORY_TABLE) . '");
				';
			
			}
		}
		
		$variant_js .= '
			categories_edit.showVariant(0);
		';
		
		$js .= we_htmlElement::jsElement($variant_js);
		
		$table = new we_htmlTable(
				array(
					
						'id' => 'CategoriesBlock', 
						'style' => 'display: block;', 
						'cellpadding' => 0, 
						'cellspacing' => 0, 
						'border' => 0
				), 
				4, 
				1);
		
		$table->setColContent(0, 0, getPixel(5, 5));
		$table->setColContent(
				1, 
				0, 
				we_htmlElement::htmlDiv(
						array(
							
								'id' => 'categoriesDiv', 
								'class' => 'blockWrapper', 
								'style' => 'width: ' . ($_width_size) . 'px; height: 60px; border: #AAAAAA solid 1px;'
						)));
		$table->setColContent(2, 0, getPixel(5, 5));
		$table->setCol(
				3, 
				0, 
				array(
					'colspan' => '2', 'align' => 'right'
				), 
				$we_button->create_button_table(
						array(
							$we_button->create_button("delete_all", "javascript:removeAllCats()"), $addbut
						)));
		
		return $table->getHtmlCode() . $js . we_htmlElement::jsElement(
				'

							function removeAllCats(){
								if(categories_edit.itemCount>0){
									while(categories_edit.itemCount>0){
										categories_edit.delItem(categories_edit.itemCount);
									}
									categories_edit.showVariant(0);
								}
							}

							function addCat(paths){
								var path = paths.split(",");
								for (var i = 0; i < path.length; i++) {
									if(path[i]!="") {
										categories_edit.addItem();
										categories_edit.setItem(0,(categories_edit.itemCount-1),path[i]);
									}
								}
								categories_edit.showVariant(0);
							}

							function selectCategories() {
								var cats = new Array();
								for(var i=0;i<categories_edit.itemCount;i++){
									cats.push(categories_edit.form.elements[categories_edit.name+"_variant0_"+categories_edit.name+"_item"+i].value);
								}
								categories_edit.form.categories.value=makeCSVFromArray(cats);
							}

					');
	}

	function savePropsInSession()
	{
		$_SESSION['_we_import_files'] = array();
		$_vars = get_object_vars($this);
		foreach ($_vars as $_name => $_value) {
			$_SESSION['_we_import_files'][$_name] = $_value;
		}
	}

	function loadPropsFromSession()
	{
		if (isset($_SESSION['_we_import_files'])) {
			foreach ($_SESSION['_we_import_files'] as $_name => $_var) {
				$this->$_name = $_var;
			}
		}
	}

}

$yuiSuggest = & weSuggest::getInstance();

$import_object = new we_import_files();

print $import_object->getHTML();

?>