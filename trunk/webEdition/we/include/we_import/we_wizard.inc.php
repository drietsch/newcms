<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/importFunctions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");


class we_wizard {

	var $path = "";

	function we_wizard() {
		$this->path = WEBEDITION_DIR . "we/include/we_import/we_wiz_frameset.php";
	}

	function getWizFrameset() {
		global $l_import;
		$args = "pnt=wizbody";
		if (isset($_REQUEST['we_demo']) && $_REQUEST['we_demo']) {
			$args .= '&we_demo=1';
		}
		if (isset($_REQUEST["we_cmd"][1])) $args .= "&we_cmd[1]=".$_REQUEST["we_cmd"][1];

		$fst = new we_htmlFrameset(array(
			"rows" => (isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0) ? "*,40,60" : "*,40,0" ,
			"framespacing" => 0,
			"border" => 0,
			"frameborder" => "no",
			"onload" => "wiz_next('wizbody', '".$this->path."?".$args."');")
		);

		$fst->addFrame(array("src" => HTML_DIR."blank.html", "name" => "wizbody"));
		$fst->setFrameAttributes(0, array("scrolling" => "auto"));

		$fst->addFrame(array("src" => HTML_DIR."blank.html", "name" => "wizbusy"));
		$fst->setFrameAttributes(1, array("scrolling" => "no"));

		$fst->addFrame(array("src" => $this->path."?pnt=wizcmd", "name" => "wizcmd"));
		$fst->setFrameAttributes(2, array("scrolling" => "no"));

		$addJS = (defined("OBJECT_TABLE"))?
			"			self.frames['wizbody'].document.forms['we_form'].elements['v[import_type]'][0].checked=true;\n":"";
		$weSessionId = session_id();

		
		$ajaxJS = <<<HTS
		
var ajaxUrl = "/webEdition/rpc/rpc.php";

var weGetCategoriesHandleSuccess = function(o){
	if(o.responseText !== undefined){
		var json = eval('('+o.responseText+')');
	
		for(var elemNr in json.elemsById){
			for(var propNr in json.elemsById[elemNr].props){
				var propval = json.elemsById[elemNr].props[propNr].val;
				propval = propval.replace(/\\\'/g,"'");
				propval = propval.replace(/'/g,"\\\'");
				var eId = json.elemsById[elemNr].elemId;
				eval("self.frames['wizbody'].document.getElementById(json.elemsById["+elemNr+"].elemId)."+json.elemsById[elemNr].props[propNr].prop+"='"+propval+"'");
			}
		}
	}
}

var weGetCategoriesHandleFailure = function(o){
	alert("failure");
}

var weGetCategoriesCallback = {
	success: weGetCategoriesHandleSuccess,
	failure: weGetCategoriesHandleFailure,
	scope: self.frame,
	timeout: 1500
};

function weGetCategories(obj,cats,part,target) {
	ajaxData = 'protocol=json&cmd=GetCategory&weSessionId={$weSessionId}&obj='+obj+'&cats='+cats+'&part='+part+'&targetId=docCatTable&catfield=v['+obj+'Categories]';
	_executeAjaxRequest('POST',ajaxUrl, weGetCategoriesCallback, ajaxData);
}

function _executeAjaxRequest(method, aUrl, callback, ajaxData){
	return YAHOO.util.Connect.asyncRequest(method, aUrl, callback, ajaxData);
}

HTS;

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				we_htmlElement::htmlTitle($l_import["title"]) .
				we_htmlElement::jsElement("", array("src" => WEBEDITION_DIR."js/windows.js")).
				we_htmlElement::jsElement("",array("src"=>JS_DIR."we_showMessage.js")) .
				we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/yahoo-min.js")). 
				we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/event-min.js")).
				we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/json-min.js")).
				we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/connection-min.js")). 
				we_htmlElement::jsElement("<!--\n".
					"function wiz_next(frm, url) {\n".
					"	eval('window.'+frm+'.location.href=\"'+url+'\"');\n".
					"}\n".
					"function we_cmd() {\n" .
					"	var args = '';\n" .
					"	var url = '".WEBEDITION_DIR."we_cmd.php?';\n" .
					"	for(var i = 0; i < arguments.length; i++) {\n" .
					"		url += 'we_cmd['+i+']='+escape(arguments[i]);\n" .
					"		if(i < (arguments.length - 1)) {\n" .
					"			url += '&';\n" .
					"		}\n" .
					"	}\n" .
					"	switch (arguments[0]) {\n" .
					"		case 'openDirselector':\n".
					"		case 'openDocselector':\n".
					"			new jsWindow(url,'we_fileselector',-1,-1,".WINDOW_DOCSELECTOR_WIDTH.",".WINDOW_DOCSELECTOR_HEIGHT.",true,true,true);\n".
					"			break;\n".
					"		case 'browse_server':\n".
					"			new jsWindow(url,'browse_server',-1,-1,840,400,true,false,true);\n".
					"			break;\n".
					"		case 'openCatselector':\n" .
					"			new jsWindow(url,'we_catselector',-1,-1,".WINDOW_CATSELECTOR_WIDTH.",".WINDOW_CATSELECTOR_HEIGHT.",true,true,true);\n" .
					"			break;\n" .
					"		case 'add_docCat':\n" . $addJS .
					"			if(self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value.indexOf(','+arguments[1]+',') == -1) {\n" .
					"				var cats = arguments[1].split(/,/);\n" .
					"				for(var i=0; i<cats.length; i++) {\n" .
					"					if(cats[i] && (self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value.indexOf(','+cats[i]+',') == -1)) {\n" .
					"						if(self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value) {\n" .
					"							self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value=self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value+cats[i]+',';\n" .
					"						} else {\n" .
					"							self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value=','+cats[i]+',';\n" .
					"						}\n" .
					"						setTimeout(\"weGetCategories('doc',self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value,'rows')\",100);\n" .
					"					}\n" .
					"				}\n" .
					"			}\n" .
					"			break;\n" .
					"		case 'delete_docCat':\n" .
					"			if(self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value.indexOf(','+arguments[1]+',') != -1) {\n" .
					"				if(self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value) {\n" .
					"					re = new RegExp(','+arguments[1]+',');\n" .
					"					self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value = self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value.replace(re,',');\n" .
					"					if(self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value == ',') {\n" .
					"						self.frames['wizbody'].document.forms['we_form'].elements['v[docCategories]'].value = '';\n" .
					"					}\n" .
					"				}\n" .
					"				self.frames['wizbody'].we_submit_form(self.frames['wizbody'].document.forms['we_form'], 'wizbody', '".$this->path."');" .
					"			}\n" .
					"			break;\n" .
					"		case 'add_objCat':\n" .
					"			self.frames['wizbody'].document.forms['we_form'].elements['v[import_type]'][1].checked=true;\n" .
					"			if(self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value.indexOf(','+arguments[1]+',') == -1) {\n" .
					"				var cats = arguments[1].split(/,/);\n" .
					"				for(var i=0; i<cats.length; i++) {\n" .
					"					if(cats[i] && (self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value.indexOf(','+cats[i]+',') == -1)) {\n" .
					"						if(self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value) {\n" .
					"							self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value=self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value+cats[i]+',';\n" .
					"						} else {\n" .
					"							self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value=','+cats[i]+',';\n" .
					"						}\n" .
					"						setTimeout(\"weGetCategories('obj',self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value,'rows')\",100);\n" .
					"					}\n" .
					"				}\n" .
					"			}\n" .
					"			break;\n" .
					"		case 'delete_objCat':\n" .
					"			if(self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value.indexOf(','+arguments[1]+',') != -1) {\n" .
					"				if(self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value) {\n" .
					"					re = new RegExp(','+arguments[1]+',');\n" .
					"					self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value = self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value.replace(re,',');\n" .
					"					if(self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value == ',') {\n" .
					"						self.frames['wizbody'].document.forms['we_form'].elements['v[objCategories]'].value = '';\n" .
					"					}\n" .
					"				}\n" .
					"				self.frames['wizbody'].we_submit_form(self.frames['wizbody'].document.forms['we_form'], 'wizbody', '".$this->path."');" .
					"			}\n" .
					"			break;\n" .
					"		case 'reload_editpage':\n" .
					"			break;\n" .
					"		default:\n" .
					"			for (var i=0; i < arguments.length; i++) {\n" .
					"				args += 'arguments['+i+']' + ((i < (arguments.length-1))? ',' : '');\n" .
					"			}\n" .
					"			eval('top.opener.top.we_cmd('+args+')');\n" .
					"	}\n" .
					"}\n" . $ajaxJS . 
					"//-->")).
				$fst->getHtmlCode()
		);
	}

	function getWizBody($type = "", $step = 0, $mode = 0) {
		@set_time_limit(0);
		$a = array();
		$a["name"] = "we_form";
		if ($type=="GXMLImport" && $step==1) {
			$a["onSubmit"] = "return false;"; 
		}
		if ($step==1) $a["enctype"] = "multipart/form-data";
		eval('list($js, $content)=$this->get'.$type.'Step'.$step.'();');
		$doOnLoad = isset($_REQUEST['noload']) ? false : true;
		$we_demo = (isset($_REQUEST['we_demo']) && $_REQUEST['we_demo']) ? 1 : 0;
		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET .
				we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")) .
				we_htmlElement::jsElement("<!--\n".$js."\n//-->")).
			we_htmlElement::htmlBody(array(
				"class"=>"weDialogBody",
				"onLoad" => $doOnLoad ? "parent.wiz_next('wizbusy', '".$this->path."?we_demo=".$we_demo."&pnt=wizbusy&mode=".$mode."&type=".(isset($_REQUEST['type']) ? $_REQUEST['type'] : '')."'); self.focus();" : "if(set_button_state) set_button_state();"
			), we_htmlElement::htmlForm($a,
					we_htmlElement::htmlHidden(array("name" => "pnt", "value" => "wizbody")) .
					we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)) .
					we_htmlElement::htmlHidden(array("name" => "v[type]", "value" => $type)) .
					we_htmlElement::htmlHidden(array("name" => "step", "value" => $step)) .
					we_htmlElement::htmlHidden(array("name" => "we_demo", "value" => $we_demo)) .
					we_htmlElement::htmlHidden(array("name" => "mode", "value" => $mode)) .
					we_htmlElement::htmlHidden(array("name" => "button_state", "value" => 0)) .
					$content
				)
			)
		);
	}

	function getWizBusy() {
		global $l_import;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");

		$pb = $js = "";
		if ($this->getPostGetVar("mode",0)==1) {
			$WE_PB = new we_progressBar(0,0,true);
			$WE_PB->setStudLen(200);
			$WE_PB->addText($text=$l_import["import_progress"],0,"pb1");
			$pb = $WE_PB->getJSCode();
			$pb.= we_htmlElement::htmlDiv(array('id'=>'progress'),$WE_PB->getHTML());
			$js = we_htmlElement::jsElement('

					function finish(rebuild) {
						var std = top.frames["wizbusy"].document.getElementById("standardDiv");
						if(typeof(std)!="undefined"){
							std.style.display = "none";
						}
						var cls = top.frames["wizbusy"].document.getElementById("closeDiv");
						if(typeof( cls)!="undefined"){
							 cls.style.display = "block";
						}
						if(rebuild) {
							top.opener.top.openWindow("' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_all&responseText=' . $l_import['finished_success'] . '","rebuildwin",-1,-1,600,130,0,true);
						}
					}

					top.frames["wizcmd"].cycle();
					top.frames["wizcmd"].we_import(1,-2' . ((isset($_REQUEST['type']) && $_REQUEST['type']=='WXMLImport') ? ',1' : '') . ');
			'
			);
		}

		$WE_BTN = new we_button();
		$cancelButton = $WE_BTN->create_button("cancel","javascript:parent.wizbody.handle_event('cancel');",false,-1,-1,'','',false,false);
		$prevButton = $WE_BTN->create_button("back","javascript:parent.wizbody.handle_event('previous');", true, -1, -1, "", "",true, false);
		$nextButton = $WE_BTN->create_button("next","javascript:parent.wizbody.handle_event('next');", true, -1, -1, "", "", false, false);
		$closeButton = $WE_BTN->create_button("close","javascript:parent.wizbody.handle_event('cancel');", true, -1, -1, "", "", false, false);

		$prevNextButtons= $prevButton ? $WE_BTN->create_button_table(array($prevButton,$nextButton)) : null;

		$content = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "100%"), 1, 2);
		$content->setCol(0, 0, null, $pb);
		$content->setCol(0, 1, array("align" => "right"),
				'
				<div id="standardDiv">' . $WE_BTN->position_yes_no_cancel($prevNextButtons, null, $cancelButton, 10, "", array(), 10) .'</div>
				<div id="closeDiv" style="display:none;">' . $closeButton .'</div>
				'
		);

		print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET.
				we_htmlElement::jsElement($WE_BTN->create_state_changer(false))).
			we_htmlElement::htmlBody(array(
				"class" => "weDialogButtonsBody",
				"onload" => "top.frames['wizbody'].set_button_state();"
				), $content->getHtmlCode().$js
			)
		);
	}

	function getWizCmd($type = "normal") {
		global $l_import;
		@set_time_limit(0);
		$out = "";
		$mode = $this->getPostGetVar("mode", 0);
		if ($mode=="") $mode = 0;
		$numFiles = $this->getPostGetVar("numFiles", -1);
		$uniquePath	= $this->getPostGetVar("uniquePath", "");
		$currFileId	= $this->getPostGetVar("currFileId", -1);
		if (isset($_REQUEST["v"])) $v = $_REQUEST["v"];

		if (isset($v["mode"]) && $v["mode"] == 1) {
			$records = isset($_REQUEST["records"]) ? $_REQUEST["records"] : array();
			$we_flds = isset($_REQUEST["we_flds"]) ? $_REQUEST["we_flds"] : array();
			$attrs = $this->getPostGetVar("attrs", array());
			$attributes = $this->getPostGetVar("attributes", array());

			switch ($v["cid"]) {
				case -2:
					$h = $this->getHdns("v",$v);
					if ($v["type"]!="" && $v["type"]!="WXMLImport"){
						$h.=$this->getHdns("records",$records)."\n".$this->getHdns("we_flds",$we_flds)."\n";

					}
					if ($v["type"]=="GXMLImport") $h.=$this->getHdns("attributes",$attributes)."\n".$this->getHdns("attrs",$attrs)."\n";

					if($type == "first_steps_wizard") {
						$JScript	=	"top.leWizardProgress.set(0)\n"
									.	"top.leWizardProgress.show()\n"
									.	"top.weButton.disable('next')\n"
									.	"top.weButton.disable('back')\n"
									.	"top.weButton.enable('reload')\n"
									.	"function we_import_handler(e) { we_import(1,-2); }\n"
									.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n";


					} else {
						$JScript	=	"top.frames[\"wizbusy\"].setProgressText(\"pb1\",\"".$l_import["prepare_progress"]."\");\n";
					}

					$out .= we_htmlElement::htmlForm(array("name"=>"we_form"),$h).we_htmlElement::jsElement(
								"<!--\n".
								$JScript .
								"setTimeout(\"we_import(1,-1);\",15);\n" .
								"//-->\n"
							);
					break;

				case -1:
					if ($v["type"]=="WXMLImport") {

						if($type != "first_steps_wizard") {
							print we_htmlElement::jsElement(
								'<!--
								if (top.frames["wizbody"] && top.frames["wizbody"].addLog){
									top.frames["wizbody"].addLog("' . addslashes(getPixel(10,10)) . '<br>");
									top.frames["wizbody"].addLog("' . addslashes(getPixel(10,10)) . we_htmlElement::htmlB($l_import['start_import'] . ' - ' . date("d.m.Y H:i:s")) . '<br><br>");
									top.frames["wizbody"].addLog("' . addslashes(getPixel(20,5)) . we_htmlElement::htmlB($l_import['prepare']) . '<br>");
									top.frames["wizbody"].addLog("' . addslashes(getPixel(20,5)) . we_htmlElement::htmlB($l_import['import']) . '<br>");
								}
								//-->');
							flush();
						}

						$path=TMP_DIR."/".weFile::getUniqueId()."/";
						createLocalFolder($path);

						if(is_dir($path)){
							include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLImport.class.php');
							$path .= '/';
							$num_files=weXMLImport::splitFile($_SERVER['DOCUMENT_ROOT'] . $v['import_from'],$path,1);
							$num_files++;
						}
					}
					else if ($v["type"]=="GXMLImport") {
						$parse = new XML_SplitFile($_SERVER["DOCUMENT_ROOT"].$v["import_from"]);
						$parse->splitFile(($v["type"]=="GXMLImport")? "*/".$v["rcd"] : "*/child::*",
							(isset($v["from_elem"]))? $v["from_elem"] : FALSE, (isset($v["to_elem"]))? $v["to_elem"] : FALSE,1);
					}
					else if ($v["type"]=="CSVImport") {
						switch ($v["csv_enclosed"]) {
							case "double_quote": $encl = "\""; break; case "single_quote": $encl = "'"; break; case "none": $encl = ""; break;
						}
						$cp = new CSVImport;
						$cp->setFile($_SERVER["DOCUMENT_ROOT"].$v["import_from"]);
						$del = ($v["csv_seperator"]!="\\t")? (($v["csv_seperator"]!="")? $v["csv_seperator"] : " ") : "	";
						$cp->setDelim($del);
						$cp->setEnclosure($encl);
						$cp->parseCSV();
						$num_files = 0;
						$unique_id = md5(uniqid(microtime()));

						$path = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp/".$unique_id;
						createLocalFolder($path);

						if ($cp->isOK()) {
							$fieldnames = ($v["csv_fieldnames"])? 0 : 1;
							$num_rows = $cp->CSVNumRows();
							$num_fields = $cp->CSVNumFields();

							for ($i = 0; $i < $num_rows + $fieldnames; $i++) {
								$data = "";
								$d[0] = $d[1] = "";
								for ($j = 0; $j < $num_fields; $j++) {
									$d[1] .= (!$fieldnames)? (($cp->CSVFieldName($j) != "")?
										$encl.str_replace($encl,"\\".$encl,$cp->CSVFieldName($j)).$encl:""):$encl."f_".$j.$encl;
									$d[0] .= ($fieldnames && $i==0)?
										(($cp->CSVFieldName($j) != "")? $encl.str_replace($encl,"\\".$encl,$cp->CSVFieldName($j)).$encl:""):
										(($cp->Fields[(!$fieldnames)? $i : ($i-1)][$j] != "")?
										$encl.str_replace($encl,"\\".$encl,$cp->Fields[(!$fieldnames)? $i : ($i-1)][$j]).$encl:"");
									if ($j+1 < $num_fields) {
										$d[1] .= "$del";
										$d[0] .= "$del";
									}
								}
								$data = implode("\n", $d);
								$hFile = fopen($path."/temp_".$i.".csv", "wb");
								fwrite($hFile, $data);
								fclose($hFile);
								$num_files++;
							}
						}
					}

					$h = $this->getHdns("v",$v)."\n";
					if ($v["type"]!="WXMLImport") $h.=$this->getHdns("records",$records)."\n".$this->getHdns("we_flds",$we_flds)."\n";
					if ($v["type"]=="GXMLImport") $h.=$this->getHdns("attributes",$attributes)."\n".$this->getHdns("attrs",$attrs)."\n";
					$h .= we_htmlElement::htmlHidden(array("name"=>"v[numFiles]","value"=>($v["type"]!="GXMLImport")? $num_files : $parse->fileId))."\n".
							we_htmlElement::htmlHidden(array("name"=>"v[uniquePath]","value"=>($v["type"]!="GXMLImport")? $path : $parse->path));

					$out .= we_htmlElement::htmlForm(array("name"=>"we_form"),$h).we_htmlElement::jsElement("<!--\n".
							"setTimeout(\"we_import(1,0);\",15);\n".
							"//-->\n");
					break;

				case $v["numFiles"]:
						if($type == "first_steps_wizard") {
							$JScript	=	"top.leWizardProgress.set(100);\n"
										.	"top.leWizardProgress.hide();\n"
										.	"top.weButton.enable('next');\n"
										.	"top.opener.top.we_cmd('load', top.opener.top.treeData.table ,0);\n"
										.	"top.opener.top.header.location.reload();\n"
										.	"function we_import_handler(e) { we_import(1,".$v["numFiles"]."); }\n"
										.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n";

						} else {
							$JScript	=	"top.frames['wizbusy'].setProgressText('pb1','" . $l_import['finish_progress'] . "');\n"
										.	"top.frames['wizbusy'].setProgress(100);\n"
										.	"top.opener.top.we_cmd('load', top.opener.top.treeData.table ,0);\n"
										.	"top.opener.top.header.location.reload();\n"
										.	"if(top.opener.top.top.weEditorFrameController.getActiveDocumentReference().quickstart && typeof(top.opener.top.weEditorFrameController.getActiveDocumentReference().quickstart) != 'undefined') top.opener.top.weEditorFrameController.getActiveDocumentReference().location.reload();\n"
										.	"if(top.frames['wizbusy'] && top.frames['wizbusy'].document.getElementById('progress')) {\n"
										.	"	progress = top.frames['wizbusy'].document.getElementById('progress');\n"
										.	"	if(typeof(progress)!='undefined'){\n"
										.	"		progress.style.display = 'none';\n"
										.	"	}\n"
										.	"}\n";
							if($v['type']=='WXMLImport') {
								$JScript	.=	"if (top.frames['wizbody'] && top.frames['wizbody'].addLog) {\n"
											.	"	top.frames['wizbody'].addLog(\"<br>" . addslashes(getPixel(10,10)) . we_htmlElement::htmlB($l_import['end_import'] . " - " . date("d.m.Y H:i:s")) . "<br><br>\");\n"
											.	"}\n";
							} else {
								$JScript	.=	we_message_reporting::getShowMessageCall($l_import['finish_import'], WE_MESSAGE_NOTICE) . 'setTimeout("top.close()",100);';
							}

						}

						$out .= we_htmlElement::jsElement($JScript);

					break;

				default:
					$fields = array();
					if ($v["type"]=="WXMLImport") {

						$hiddens = $this->getHdns("v",$v);

						if((int)$v['cid']==0){
							include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExIm.class.php");
							// clear session data
							weXMLExIm::unsetPerserves();
						}

						$ref=false;
						if($v["cid"]>=$v["numFiles"]-1){ // finish import
							include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weImportUpdater.class.php");
							$xmlExIm=new weImportUpdater();
							$xmlExIm->loadPerserves();
							$xmlExIm->setOptions(array(
									"handle_documents"=>$v["import_docs"],
									"handle_templates"=>$v["import_templ"],
									"handle_objects"=>isset($v["import_objs"]) ? $v["import_objs"] : 0,
									"handle_classes"=>isset($v["import_classes"]) ? $v["import_classes"] : 0,
									"handle_doctypes"=>$v["import_dt"],
									"handle_categorys"=>$v["import_ct"],
									"handle_binarys"=>$v["import_binarys"],
									"document_path"=>$v["doc_dir_id"],
									"template_path"=>$v["tpl_dir_id"],
									"handle_collision"=>$v["collision"],
									"restore_doc_path"=>$v["restore_doc_path"],
									"restore_tpl_path"=>$v["restore_tpl_path"],
									"handle_owners"=>$v["import_owners"],
									"owners_overwrite"=>$v["owners_overwrite"],
									"owners_overwrite_id"=>$v["owners_overwrite_id"],
									"handle_navigation"=>$v["import_navigation"],
									"navigation_path"=>$v["navigation_dir_id"],
									"handle_thumbnails"=>$v["import_thumbnails"],
									"rebuild"=>$v["rebuild"]
							));

							if($xmlExIm->RefTable->current==0){
								if($type != "first_steps_wizard") {
									print we_htmlElement::jsElement('
										if (top.frames["wizbody"].addLog){
											top.frames["wizbody"].addLog("' . addslashes(getPixel(20,5)) . we_htmlElement::htmlB($l_import['update_links']) . '");
										}
									');
									flush();
								}
							}

							$ref=null;

							for($i=0;$i<$xmlExIm->UpdateItemsCount;$i++){
								$ref=$xmlExIm->RefTable->getNext();
								if(!empty($ref)){
									if(isset($ref->ContentType) && isset($ref->ID)){
										$doc=weContentProvider::getInstance($ref->ContentType,$ref->ID,$ref->Table);
									}
									$xmlExIm->updateObject($doc);
								} else {
									break;
								}
							}

							if(!empty($ref)){
								$xmlExIm->savePerserves();

								if($type == "first_steps_wizard") {
									$JScript	=	"top.leWizardProgress.set(Math.floor(((".(int)($v['cid'] + $xmlExIm->RefTable->current)."+1)/".(int)($xmlExIm->RefTable->getLastCount() + $v["numFiles"]).")*100));\n"
												.	"function we_import_handler(e) { we_import(1," . ($v['cid']-1) . "); }\n"
												.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n";;

								} else {
									$JScript	=	"top.frames['wizbusy'].setProgressText('pb1','" . $l_import['update_links'] . $xmlExIm->RefTable->current . '/' . count($xmlExIm->RefTable->Storage) . "');\n"
												.	"top.frames['wizbusy'].setProgress(Math.floor(((".(int)($v['cid'] + $xmlExIm->RefTable->current)."+1)/".(int)($xmlExIm->RefTable->getLastCount() + $v["numFiles"]).")*100));\n";

								}

								$out .= we_htmlElement::htmlForm(array("name"=>"we_form"), $hiddens.we_htmlElement::jsElement(
												"<!--\n"
											.	$JScript
											.	"setTimeout('we_import(1," . $v['cid'] . ");',15);\n"
											.	"//-->\n"
										));

							} else {

								if($type == "first_steps_wizard") {
									$_SESSION['fsw_importRefTable'] = isset($_SESSION["ExImRefTable"]) ? $_SESSION["ExImRefTable"] : array();

									$JScript	=	""
												.	"function we_import_handler(e) { we_import(1," . ($v['numFiles']-1) . "); }\n"
												.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n"
												.	"setTimeout('we_import(1," . $v['numFiles'] . ");',15);\n";

								} else {

									$JScript	=	"top.frames['wizbusy'].finish(" . $xmlExIm->options['rebuild'] . ");\n"
												.	"setTimeout('we_import(1," . $v['numFiles'] . ");',15);\n";

								}
								$out .= we_htmlElement::htmlForm(array("name"=>"we_form"), $hiddens.we_htmlElement::jsElement(
												"<!--\n"
											.	$JScript
											.	"//-->\n"
										));

								$xmlExIm->unsetPerserves();

							}

						} else { // do import

							include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLImport.class.php");
							$xmlExIm=new weXMLImport();
							$chunk=$v["uniquePath"].basename($v["import_from"])."_".$v["cid"];
							if(file_exists($chunk)){
								$xmlExIm->loadPerserves();
								$xmlExIm->setOptions(array(
									"handle_documents"=>$v["import_docs"],
									"handle_templates"=>$v["import_templ"],
									"handle_objects"=>isset($v["import_objs"]) ? $v["import_objs"] : 0,
									"handle_classes"=>isset($v["import_classes"]) ? $v["import_classes"] : 0,
									"handle_doctypes"=>$v["import_dt"],
									"handle_categorys"=>$v["import_ct"],
									"handle_binarys"=>$v["import_binarys"],
									"document_path"=>$v["doc_dir_id"],
									"template_path"=>$v["tpl_dir_id"],
									"handle_collision"=>$v["collision"],
									"restore_doc_path"=>$v["restore_doc_path"],
									"restore_tpl_path"=>$v["restore_tpl_path"],
									"handle_owners"=>$v["import_owners"],
									"owners_overwrite"=>$v["owners_overwrite"],
									"owners_overwrite_id"=>$v["owners_overwrite_id"],
									"handle_navigation"=>$v["import_navigation"],
									"navigation_path"=>$v["navigation_dir_id"],
									"handle_thumbnails"=>$v["import_thumbnails"],
									"rebuild"=>$v["rebuild"]
								));

								$imported = $xmlExIm->import($chunk);
								$xmlExIm->savePerserves();
								if($imported){
									$ref = $xmlExIm->RefTable->getLast();
									include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");

									$_status = $l_import['import'];

									if($ref->ContentType == 'weBinary' || $ref->ContentType == 'category' || $ref->ContentType == 'objectFile') {
										$_path_info = $ref->Path;
									} else if($ref->ContentType == 'doctype') {
										$_path_info = f('SELECT DocType FROM ' . $ref->Table . ' WHERE ID = ' . $ref->ID,'DocType',new DB_WE());
									} else if($ref->ContentType == 'weNavigationRule') {
										$_path_info = f('SELECT NavigationName FROM ' . $ref->Table . ' WHERE ID = ' . $ref->ID,'NavigationName',new DB_WE());
									} else if($ref->ContentType == 'weThumbnail') {
										$_path_info = f('SELECT Name FROM ' . $ref->Table . ' WHERE ID = ' . $ref->ID,'Name',new DB_WE());
									} else {
										$_path_info = id_to_path($ref->ID,$ref->Table);
									}

									$_progress_text = we_htmlElement::htmlB(
															isset($l_contentTypes[$ref->ContentType]) ?
															$l_contentTypes[$ref->ContentType] :
															(isset($l_import[$ref->ContentType]) ?
																$l_import[$ref->ContentType] : ''
															)
														) . '&nbsp;&nbsp;' . $_path_info;

									if(strlen($_progress_text)>75){
										$_progress_text = addslashes(substr($_progress_text,0,65) . '<acronym title="' . $_path_info . '">...</acronym>' . substr($_progress_text,-10));
									}

									if($type != "first_steps_wizard") {
										print we_htmlElement::jsElement('
											if (top.frames["wizbody"].addLog){
												top.frames["wizbody"].addLog("' . addslashes(getPixel(50,5)) . $_progress_text . '<br>");
											}
										');
										flush();

									}

								} else {
									$_status = $l_import['skip'];
								}

								$_counter_text = $l_import['item'] . ' ' . $v['cid'] . '/' . ($v['numFiles']-2) . '';

								if($type == "first_steps_wizard") {
									$JScript	=	"top.leWizardProgress.set(Math.floor(((" . $v['cid'] . "+1)/" . (int)(2*$v["numFiles"]) . ")*100));\n"
												.	"function we_import_handler(e) { we_import(1," . $v["cid"] . "); }\n"
												.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n";

								} else {
									$JScript	=	"top.frames['wizbusy'].setProgressText('pb1','" . $_status . " - " . $_counter_text . "');\n"
												.	"top.frames['wizbusy'].setProgress(Math.floor(((" . $v['cid'] . "+1)/" . (int)(2*$v["numFiles"]) . ")*100));\n";

								}

								$out .= we_htmlElement::htmlForm(array("name"=>"we_form"), $hiddens.we_htmlElement::jsElement(
												"<!--\n"
											.	$JScript
											.	"setTimeout('we_import(1," . ($v["cid"]+1) . ");',15);\n"
											.	"//-->\n"
										));

							}
						}
						break;
					}
					else if ($v["type"]== "GXMLImport") {
						$hiddens = $this->getHdns("v",$v).$this->getHdns("records",$records).$this->getHdns("we_flds",$we_flds).$this->getHdns("attributes",$attributes);
						$xp = new XML_Parser($v["uniquePath"]."/temp_".$v["cid"].".xml");

						for($c = 0; $c < sizeOf($records); $c++) {
							$nodeSet = $xp->evaluate($xp->root."/".$we_flds[$records[$c]]);
							$xPath = "";
							$loop = 0;
							$firstNode = "";
							foreach ($nodeSet as $node) {
								if ($loop == 0) $firstNode = $node; $loop++;
								$list = $xp->getAttributes($node);
								$flag = true;
								$decAttrs = $this->parseAttributes(base64_decode($attributes[$records[$c]]));
								foreach ($decAttrs as $key=>$value) {
									if (!isset($list[$key]) || $list[$key] != $value) $flag = false;
								}
								if ($flag) {
									$xPath = $node;
									break;
								}
							}
							if ($xPath == "") $xPath = $firstNode;
							$fields = $fields + array($records[$c] => $xp->getData($xPath));
						}
						if ($v["pfx_fn"] == 1) {
							$v["rcd_pfx"] = $xp->getData($xp->root."/".$v["rcd_pfx"]."[1]");
							if ($v["rcd_pfx"] == "") {
								$v["rcd_pfx"] = ($v["import_type"] == "documents")? $l_import["pfx_doc"] : $l_import["pfx_obj"];
							}
						}
					}
					else if ($v["type"]=="CSVImport") {
						$hiddens = $this->getHdns("v", $v) . $this->getHdns("records", $records) .$this->getHdns("we_flds", $we_flds);
						switch ($v["csv_enclosed"]) {
							case "double_quote": $encl = "\""; break; case "single_quote": $encl = "'"; break; case "none": $encl = ""; break;
						}
						$cp = new CSVImport;
						$cp->setFile($v["uniquePath"]."/temp_".$v["cid"].".csv");
						$cp->setDelim($v["csv_seperator"]);
						$cp->setEnclosure($encl);
						$cp->parseCSV();
						$recs = array();
						$names = array();
						for ($i = 0; $i < $cp->CSVNumFields(); $i++) {
							$names[$i] = $cp->CSVFieldName($i);
							$recs[$names[$i]] = $cp->Fields[0][$i];
						}
						foreach ($we_flds as $name=>$value) {
							if(isset($recs[$value])) $fields[$name] = $recs[$value];
							else $fields[$name] = "";
						}
						if ($v["pfx_fn"] == 1) {
							$v["rcd_pfx"] = $recs[$v["rcd_pfx"]];

							if ($v["rcd_pfx"] == "") {
								$v["rcd_pfx"] = ($v["import_type"] == "documents")? $l_import["pfx_doc"] : $l_import["pfx_obj"];
							}
						}
					}

					if ($v["type"]!="WXMLImport") {
						if (isset($v["dateFields"])) {
							$dateFields = makeArrayFromCSV($v["dateFields"]);
							if (($v["sTimeStamp"]=="Format" && $v["timestamp"]!="")||($v["sTimeStamp"]=="GMT")) {
								foreach ($dateFields as $dateField) {
									$fields[$dateField] = importFunctions::date2Timestamp($fields[$dateField],($v["sTimeStamp"]!="GMT")?$v["timestamp"]:"");
								}
							}
						}

						$rcd_name = ($v["pfx_fn"] == 1)? $v["rcd_pfx"] : $v["asoc_prefix"];
						if ($v["import_type"] == "documents") {
    					    $_isSelectable = f('SELECT IsSearchable FROM ' . DOC_TYPES_TABLE . ' WHERE ID = ' . $v["docType"] ,'IsSearchable',new DB_WE());
							importFunctions::importDocument($v["store_to_id"], $v["we_TemplateID"], $fields, $v["docType"], $v["docCategories"],
    						$rcd_name, $v["is_dynamic"], $v["we_Extension"],true,$_isSelectable,$v['collision']);
						}
						else if ($v["import_type"] == "objects") {
							importFunctions::importObject($v["classID"], $fields, $v["objCategories"], $rcd_name,true,$v['collision']);
						}
					}


					if($type == "first_steps_wizard") {
						$JScript	=	"top.leWizardProgress.set(Math.floor(((" . $v["cid"] . "+1)/" . $v["numFiles"] . ")*100));\n"
									.	"function we_import_handler(e) { we_import(1," . $v["cid"] . "); }\n"
									.	"top.document.getElementById('function_reload').onmouseup = we_import_handler;\n";

					} else {
						$JScript	=	"top.frames['wizbusy'].setProgressText('pb1','" . $l_import["import"] . "');\n"
									.	"top.frames['wizbusy'].setProgress(Math.floor(((" . $v["cid"] . "+1)/" . $v["numFiles"] . ")*100));\n";

					}

					$out .= we_htmlElement::htmlForm(array("name"=>"we_form"), $hiddens.we_htmlElement::jsElement(
									"<!--\n"
								.	$JScript
								.	"setTimeout('we_import(1," . ($v["cid"]+1) . ");',15);\n"
								.	"//-->\n"
							));
					break;
			} // end switch
		} else if ($mode != 1) {
			$out .= we_htmlElement::htmlForm(array("name"=>"we_form"),
				we_htmlElement::htmlHidden(array("name"=>"v[mode]","value"=>""))."\n".
				we_htmlElement::htmlHidden(array("name"=>"v[cid]","value"=>""))."\n".
				we_htmlElement::htmlHidden(array("name"=>"mode","value"=>""))."\n".
				we_htmlElement::htmlHidden(array("name"=>"type","value"=>""))."\n".
				we_htmlElement::htmlHidden(array("name"=>"cid","value"=>"")));
		}

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				we_htmlElement::jsElement("<!--\n".
					"function addField(form, fieldType, fieldName, fieldValue) {\n" .
					"	if (document.getElementById) {\n" .
					"		var input = document.createElement('INPUT');\n" .
					"		if (document.all) {\n" .
					"			input.type = fieldType;\n" .
					"			input.name = fieldName;\n" .
					"			input.value = fieldValue;\n" .
					"		}\n" .
					"		else if (document.getElementById) {\n" .
					"			input.setAttribute('type', fieldType);\n" .
					"			input.setAttribute('name', fieldName);\n" .
					"			input.setAttribute('value', fieldValue);\n" .
					"		}\n" .
					"		form.appendChild(input);\n" .
					"	}\n" .
					"}\n" .
					"function getField(form, fieldName) {\n" .
					"	if (!document.all)\n" .
					"		return form[fieldName];\n" .
					"	else\n" .
					"		for (var e = 0; e < form.elements.length; e++)\n" .
					"			if (form.elements[e].name == fieldName)\n" .
					"				return form.elements[e];\n" .
					"		return null;\n" .
					"}\n" .
					"function removeField(form, fieldName) {\n" .
					"	var field = getField (form, fieldName);\n" .
					"	if (field && !field.length)\n" .
					"		field.parentNode.removeChild(field);\n" .
					"}\n" .
					"function toggleField (form, fieldName, value) {\n" .
					"	var field = getField (form, fieldName);\n" .
					"	if (field)\n" .
					"		removeField (form, fieldName);\n" .
					"	else\n" .
					"		addField (form, 'hidden', fieldName, value);\n" .
					"}\n" .
					"function cycle() {\n" .
					"	var test = '';\n" .
					"	var cf = self.document.forms['we_form'];\n" .
					"	var bf = top.frames['wizbody'].document.forms['we_form'];\n" .
					"	for (var i = 0; i < bf.elements.length; i++) {\n" .
					"		if ((bf.elements[i].name.indexOf('v') > -1) || (bf.elements[i].name.indexOf('records') > -1) ||\n" .
					"			(bf.elements[i].name.indexOf('we_flds') > -1) || (bf.elements[i].name.indexOf('attributes') > -1)) {\n" .
					"			addField(cf, 'hidden', bf.elements[i].name, bf.elements[i].value);\n" .
					"		}\n" .
					"	}\n" .
					"}\n" .
					"function we_import(mode, cid) {\n" .
					"	if(arguments[2]==1){ " .
					"		top.frames['wizbody'].location = '".$this->path."?pnt=wizbody&step=3&type=WXMLImport&noload=1';\n" .
					"	};\n" .
					"	var we_form = self.document.forms['we_form'];\n" .
					"	we_form.elements['v[mode]'].value = mode;\n" .
					"	we_form.elements['v[cid]'].value = cid;\n" .
					"	we_form.target = '" . ($type == "first_steps_wizard" ? "_self" : "wizcmd" ) ."';\n" .
					"	we_form.action = '" . ($type == "first_steps_wizard" ? $_SERVER['PHP_SELF'] . "?leWizard=" . $_REQUEST['leWizard'] . "&leStep=" . $_REQUEST['leStep'] . "&we_cmd[0]=" . $_REQUEST['we_cmd'][0] : $this->path."?pnt=wizcmd" ) . "';\n" .
					"	we_form.method = 'post';\n" .
					"	we_form.submit();\n" .
					"}\n" .
					"//-->")).
					we_htmlElement::htmlBody(array(), $out));

	}

	function getPostGetVar($var, $def) {
		if (isset($_POST[$var])) $ret = $_POST[$var];
		else if (isset($_GET[$var])) $ret = $_GET[$var];
		else $ret = $def;
		return $ret;
	}
}

?>