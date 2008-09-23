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


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModuleFrames.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/voting.inc.php");
include_once(WE_VOTING_MODULE_DIR."weVotingView.php");
include_once(WE_VOTING_MODULE_DIR."weVotingTree.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');

class weVotingFrames extends weModuleFrames {

	var $View;

	var $_space_size = 150;
	var $_text_size = 75;
	var $_width_size = 535;

	function weVotingFrames() {
		$this->weModuleFrames(WE_VOTING_MODULE_PATH."edit_voting_frameset.php");
		$this->Tree=new weVotingTree();
		$this->View = new weVotingView(WE_VOTING_MODULE_PATH."edit_voting_frameset.php","top.content");
		$this->setupTree(VOTING_TABLE,"top.content","top.content.resize.left.tree","top.content.cmd");
		$this->module="voting";
	}

	function getHTML($what){

		switch($what){
			case "frameset": print $this->getHTMLFrameset();break;
			case "header": print $this->getHTMLHeader();break;
			case "resize": print $this->getHTMLResize();break;
			case "left":  print $this->getHTMLLeft();break;
			case "right": print $this->getHTMLRight();break;
			case "editor": print $this->getHTMLEditor();break;
			case "edheader": print $this->getHTMLEditorHeader();break;
			case "edbody": print $this->getHTMLEditorBody(); break;
			case "edfooter": print $this->getHTMLEditorFooter();break;
			case "cmd": print $this->getHTMLCmd();break;
			case "treeheader": print $this->getHTMLTreeHeader();break;
			case "treefooter": print $this->getHTMLTreeFooter();break;
			case "export_csv": print $this->getHTMLExportCsvMessage();break;
			case "reset_ipdata": print $this->getHTMLResetIPData();break;
			case "reset_logdata": print $this->getHTMLResetLogData();break;
			case "show_log": print $this->getHTMLShowLog();break;
			case "delete_log": print $this->getHTMLDeleteLog();break;
			default:
				error_log(__FILE__ . " unknown reference: $what");
		}
	}

	function getHTMLFrameset(){
		$this->View->voting->clearSessionVars();
		return weModuleFrames::getHTMLFrameset();
	}

	function getJSCmdCode(){
		return $this->View->getJSTop() .
				we_htmlElement::jsElement($this->Tree->getJSMakeNewEntry()
		);
	}

	function getHTMLEditorHeader() {
		global $l_voting;
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");
		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#FFFFFF","background"=>"/webEdition/images/backgrounds/bgGrayLineTop.gif"),""));
		}

		$we_tabs = new we_tabs();

		$we_tabs->addTab(new we_tab("#",$l_voting['property'],'(('.$this->topFrame.'.activ_tab==1) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('1');",array("id"=>"tab_1")));
		if(!$this->View->voting->IsFolder) {
			$we_tabs->addTab(new we_tab("#",$l_voting['inquiry'],'(('.$this->topFrame.'.activ_tab==2) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('2');",array("id"=>"tab_2")));
			$we_tabs->addTab(new we_tab("#",$l_voting['options'],'(('.$this->topFrame.'.activ_tab==3) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('3');",array("id"=>"tab_3")));

			if($this->View->voting->ID) $we_tabs->addTab(new we_tab("#",$l_voting['result'],'(('.$this->topFrame.'.activ_tab==4) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('4');",array("id"=>"tab_4")));
		}

		$we_tabs->onResize();
		$tabsHead = $we_tabs->getHeader('', 22);
		$tabsBody = $we_tabs->getJS();

		$js=we_htmlElement::jsElement('

				function setTab(tab) {
					parent.edbody.toggle("tab"+'.$this->topFrame.'.activ_tab);
					parent.edbody.toggle("tab"+tab);
					'.$this->topFrame.'.activ_tab=tab;
					self.focus();
				}

				'.($this->View->voting->ID ? '' : $this->topFrame.'.activ_tab=1;').'

		');

		$tabsHead .= $js;

		$table=new we_htmlTable(array("width"=>"3000","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),3,1);

		$table->setCol(0,0,array(),getPixel(1,3));

		$table->setCol(1,0,array("valign"=>"top","class"=>"small"),
							getPixel(15,2).
							we_htmlElement::htmlB(
								($this->View->voting->IsFolder ? $l_voting['group'] : $l_voting['voting']) . ':&nbsp;'.$this->View->voting->Text.
								we_htmlElement::htmlImg(array("align"=>"absmiddle","height"=>"19","width"=>"1600","src"=>IMAGE_DIR."pixel.gif"))
							)
		);

		$extraJS = 'document.getElementById("tab_"+top.content.activ_tab).className="tabActive";';
		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"),
			'<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",($this->View->voting->IsFolder ? $l_voting['group'] : $l_voting['voting'])) . ':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$this->View->voting->Path).'</b></span></nobr></div>' . getPixel(100,3) .
			$we_tabs->getHTML() .
			'</div>' . we_htmlElement::jsElement($extraJS)
		);

		return $this->getHTMLDocument($body,$tabsHead);
	}



	function getHTMLEditorBody() {

		$hiddens=array('cmd'=>'edit_voting','pnt'=>'edbody','vernr'=>(isset($_REQUEST['vernr']) ? $_REQUEST['vernr'] : 0));

		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$hiddens["cmd"]="home";
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->View->getJSProperty();
			$GLOBALS["we_body_insert"] = we_htmlElement::htmlForm(array("name"=>"we_form"),
					$this->View->getCommonHiddens($hiddens).we_htmlelement::htmlHidden(array("name"=>"home","value"=>"0"))
			);
			$GLOBALS["mod"] = "voting";
			ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
            return
            we_htmlElement::jsElement('
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&home=1";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter&home=1";
			') . $out;

		}

		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody","onLoad"=>"loaded=1;setMultiEdits();", "onunload"=>"doUnload()"),
					we_htmlElement::htmlForm(array("name"=>"we_form","onsubmit"=>"return false"),$this->View->getCommonHiddens($hiddens).$this->getHTMLProperties())
		);

		return $this->getHTMLDocument($body,$this->View->getJSProperty());

	}

	function getHTMLEditorFooter() {

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#EFF0EF"),""));
		}

		$we_button = new we_button();

		$table1=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"3000"),1,1);
		$table1->setCol(0,0,array("nowrap"=>null,"valign"=>"top"),getPixel(1600,10));

		$table2=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"300"),1,2);
		$table2->setRow(0,array("valign"=>"middle"));
		$table2->setCol(0,0,array("nowrap"=>null),getPixel(5,5));
		$table2->setCol(0,1,array("nowrap"=>null),
					$we_button->create_button("save", "javascript:we_save()",true,100,22,'','',(!we_hasPerm('NEW_VOTING') && !we_hasPerm('EDIT_VOTING')))
		);


		return $this->getHTMLDocument(
					we_htmlElement::jsElement("
					function we_save() {
						top.content.we_cmd('save_voting');
						
					}
					") . 
					we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0"),
							we_htmlElement::htmlForm(array(),$table1->getHtmlCode().$table2->getHtmlCode())
					)
		);

	}


	function getPercent($total, $value, $precision=0){

		if ($total) {
			$result = round(($value*100)/$total,$precision);
		} else {
			$result = 0;
		}

		return weVoting::formatNumber($result,strtolower($GLOBALS['WE_LANGUAGE']),VOTING_PRECISION);
	}

	function getHTMLVariant() {
		global $l_voting;

		$we_button = new we_button();

		$del_but = addslashes(we_htmlElement::htmlImg(array('src'=>IMAGE_DIR.'/button/btn_function_trash.gif','onclick'=>'javascript:top.content.setHot();#####placeHolder#####','style'=>'cursor: pointer; width: 27px;-moz-user-select: none;')));
		$del_but1 = addslashes(we_htmlElement::htmlImg(array('src'=>IMAGE_DIR.'/button/btn_function_trash.gif','onclick'=>'javascript:top.content.setHot();if(answers_edit.itemCount>2) #####placeHolder#####; else callAnswerLimit();','style'=>'cursor: pointer; width: 27px;-moz-user-select: none;')));

		$js = we_htmlElement::jsElement('',array('src'=>JS_DIR.'utils/multi_edit.js?'.time()));

		$variant_js = '

			function callAnswerLimit() {
				' . we_message_reporting::getShowMessageCall($l_voting['answer_limit'], WE_MESSAGE_ERROR) . '
			}

			function setMultiEdits() {
		';

		if($this->View->voting->IsFolder==0){
			$variant_js .= '
				question_edit = new multi_edit("question",document.we_form,1,"",'.($this->_width_size).',true);
				answers_edit = new multi_edit("answers",document.we_form,0,"' . $del_but1 . '",'.($this->_width_size-32).',true);
			';

			for($j=0;$j<count($this->View->voting->QASet[0]['answers']);$j++){
				$variant_js .= '
					answers_edit.addItem();
				';
			}

			foreach($this->View->voting->QASet as $variant=>$value){

				$variant_js .= '
					question_edit.addVariant();
					answers_edit.addVariant();
				';
				foreach ($value as $k=>$v){
					if($k == 'question'){
						$variant_js .= '
							question_edit.setItem("'.$variant.'",0,"' . $v . '");
						';
					}
					if($k == 'answers'){
						foreach ($v as $akey=>$aval){
							$variant_js .= '
								answers_edit.setItem("'.$variant.'","'.$akey.'","' . $aval . '");
							';
						}
					}

				}
			}

			$variant_js .= '
				answers_edit.delRelatedItems=true;
				question_edit.showVariant(0);
				answers_edit.showVariant(0);
				question_edit.showVariant(' . (isset($_REQUEST['vernr']) ? $_REQUEST['vernr'] : 0) . ');
				answers_edit.showVariant(' . (isset($_REQUEST['vernr']) ? $_REQUEST['vernr'] : 0) . ');
			';
		}

		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			$variant_js .= '
				owners_label = new multi_edit("owners",document.we_form,0,"' . $del_but . '",'.($this->_width_size-10).',false);
				owners_label.addVariant();
			';
			if(is_array($this->View->voting->Owners)){
				foreach ($this->View->voting->Owners as $owner) {

					$foo = f('SELECT IsFolder FROM ' . USER_TABLE . ' WHERE ID=\'' .$owner . '\';','IsFolder',$this->db);

					$variant_js .= '
						owners_label.addItem();
						owners_label.setItem(0,(owners_label.itemCount-1),"'. ($foo ? $this->View->group_pattern : $this->View->item_pattern) . id_to_path($owner,USER_TABLE) . '");
					';

				}
			}
			$variant_js .= '
				owners_label.showVariant(0);
			';
		}

		$variant_js .= '
			iptable_label = new multi_edit("iptable",document.we_form,0,"' . $del_but . '",'.($this->_width_size-10).',false);
			iptable_label.addVariant();
		';
		if(is_array($this->View->voting->BlackList)){
			foreach ($this->View->voting->BlackList as $ip) {

				$variant_js .= '
					top.content.setHot();
					iptable_label.addItem();
					iptable_label.setItem(0,(iptable_label.itemCount-1),"'. $ip . '");
				';

			}
		}
		$variant_js .= '
			iptable_label.showVariant(0);
		';


		$variant_js .= '
			}
		';

		$js .= we_htmlElement::jsElement($variant_js);

		return $js;

	}

	function getHTMLTab1(){
		global $l_voting;

		$we_button = new we_button();
		$parts = array();
		$yuiSuggest =& weSuggest::getInstance();
		array_push($parts,array(
				'headline'=>$l_voting['property'],
				'html'=>we_htmlElement::htmlHidden(array('name'=>'owners_name','value'=>'')) .
						we_htmlElement::htmlHidden(array('name'=>'owners_count','value'=>'0')) .
						we_htmlElement::htmlHidden(array('name'=>'newone','value'=>($this->View->voting->ID==0 ? 1 : 0))) .
						htmlFormElementTable(htmlTextInput('Text','',$this->View->voting->Text,'','style="width: '.$this->_width_size.'" id="yuiAcInputPathName" onchange="top.content.setHot();" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()"'),$l_voting["headline_name"]) .
						we_htmlElement::htmlBr() .
						$this->getHTMLDirChooser() .
						$yuiSuggest->getYuiJsFiles().$yuiSuggest->getYuiCss().$yuiSuggest->getYuiJs().
						we_htmlElement::htmlBr() .
						(!$this->View->voting->IsFolder ? htmlFormElementTable(getDateInput2('PublishDate%s',$this->View->voting->PublishDate,false,'','top.content.setHot();'),$l_voting['headline_publish_date']) : ''),
				'space'=>$this->_space_size,
				'noline'=>1)
		);

		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){

			array_push($parts,array(
					'headline'=>'',
					'html'=> we_forms::checkboxWithHidden($this->View->voting->RestrictOwners ? true : false, 'RestrictOwners', $l_voting['limit_access'],false,'defaultfont','top.content.setHot(); toggle(\'ownersTable\')'),
					'space'=>$this->_space_size,
					'noline'=>1
					)
			);

			$table = new we_htmlTable(array('id'=>'ownersTable','style'=>'display: ' . ($this->View->voting->RestrictOwners ? 'block' : 'none') . ';','cellpadding' => 2,'cellspacing' => 2,"border"=>0),3,2);
			$table->setColContent(0,0,getPixel(10,5));
			$table->setCol(0,1,array('colspan'=>'2','class'=>'defaultfont'),$l_voting['limit_access_text']);
			$table->setColContent(1,1,we_htmlElement::htmlDiv(array('id'=>'owners','class'=>'blockWrapper','style'=>'width: '.($this->_width_size-10).'px; height: 60px; border: #AAAAAA solid 1px;')));
			$idname = 'owner_id';
			$textname = 'owner_text';
			$table->setCol(2,0,array('colspan'=>'2','align'=>'right'),
				we_htmlElement::htmlHidden(array('name'=>$idname,'value'=>'')) .
				we_htmlElement::htmlHidden(array('name'=>$textname,'value'=>'')) .
				$we_button->create_button("add", "javascript:top.content.setHot(); we_cmd('browse_users','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','',document.forms[0].elements['$idname'].value,'fillIDs();opener.we_cmd(\\'add_owner\\',top.allPaths,top.allIsFolder)','','',1);")
			);

			array_push($parts,array(
					'headline'=>'',
					'html'=>$table->getHtmlCode(),
					'space'=>$this->_space_size)
			);
		} else {
			array_push($parts,array(
					'headline'=>'',
					'html'=>'',
					'space'=>$this->_space_size)
			);
		}

		if($this->View->voting->IsFolder) return $parts;

		$activeTime = new we_htmlSelect(array('name'=>'ActiveTime', 'class'=>'weSelect','size'=>'1','style'=>'width:200','onchange'=>'top.content.setHot(); if(this.value!=0) setVisible(\'valid\',true); else setVisible(\'valid\',false);'));
		$activeTime->addOption((0),$l_voting['always']);
		$activeTime->addOption((1),$l_voting['until']);
		$activeTime->selectOption($this->View->voting->ActiveTime);

		$table = new we_htmlTable(array('cellpadding' => 2,'cellspacing' => 2,"border"=>0),4,2);
		$table->setCol(0,0,array('colspan'=>'2'),htmlAlertAttentionBox($l_voting['valid_txt'],2,$this->_width_size,false,133));
		$table->setCol(1,0,array('colspan'=>'2'),we_forms::checkboxWithHidden($this->View->voting->Active ? true : false, 'Active', $l_voting['active_till'],false,'defaultfont','toggle(\'activetime\');if(!this.checked) setVisible(\'valid\',false); else if(document.we_form.ActiveTime.value==1) setVisible(\'valid\',true); else setVisible(\'valid\',false);'));

		$table->setColContent(2,1,we_htmlElement::htmlDiv(array('id'=>'activetime','style'=>'display: ' . ($this->View->voting->Active ? 'block' : 'none') . ';') ,
										$activeTime->getHtmlCode()
									)
		);
		$table->setColContent(3,1,
				we_htmlElement::htmlDiv(array('id'=>'valid','style'=>'display: ' . ($this->View->voting->Active && $this->View->voting->ActiveTime ? 'block' : 'none') . ';') ,
						htmlFormElementTable(getDateInput2('Valid%s',$this->View->voting->Valid,false,'','top.content.setHot();'),"")
				)
		);

		array_push($parts,array(
				'headline'=>$l_voting['valid'],
				'html'=>$table->getHtmlCode(),
				'space'=>$this->_space_size,
				'noline'=>1)
		);


		return $parts;
	}


	function getHTMLTab2(){
		global $l_voting;

		$we_button = new we_button();
		$parts = array();

		$select = new we_htmlSelect(array('name'=>'selectVar','class'=>'weSelect','onchange'=>'top.content.setHot();question_edit.showVariant(this.value);answers_edit.showVariant(this.value);document.we_form.vernr.value=this.value;refreshTexts();','style'=>'width:'.($this->_width_size-64)));
		foreach($this->View->voting->QASet as $variant=>$value){
			$select->addOption($variant,$l_voting['variant'] . ' ' . ($variant+1));
		}
		$select->selectOption(isset($_REQUEST['vernr']) ? $_REQUEST['vernr'] : 0);

		$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),1,3);
		$table->setColContent(0,0,$select->getHtmlCode());
		$table->setColContent(0,1,$we_button->create_button("image:btn_function_plus", "javascript:top.content.setHot();question_edit.addVariant();answers_edit.addVariant();question_edit.showVariant(question_edit.variantCount-1);answers_edit.showVariant(answers_edit.variantCount-1);document.we_form.selectVar.options[document.we_form.selectVar.options.length] = new Option('" . $l_voting['variant'] . " '+question_edit.variantCount,question_edit.variantCount-1,false,true);"));
		$table->setColContent(0,2,$we_button->create_button("image:btn_function_trash", "javascript:top.content.setHot();if(question_edit.variantCount>1){ question_edit.deleteVariant(document.we_form.selectVar.selectedIndex);answers_edit.deleteVariant(document.we_form.selectVar.selectedIndex);document.we_form.selectVar.options.length--;document.we_form.selectVar.selectedIndex=question_edit.currentVariant;refreshTexts();} else {" . we_message_reporting::getShowMessageCall($l_voting['variant_limit'], WE_MESSAGE_ERROR) . "}"));
		$table->setColAttributes(0,1,array("style"=>"padding:0 5px;"));
		$selectCode = $table->getHtmlCode();

		$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),5,1);

		$table->setColContent(0,0,$selectCode);
		$table->setColContent(1,0,getPixel(10,7));
		$table->setColContent(2,0,htmlFormElementTable(we_htmlElement::htmlDiv(array('id'=>'question')),$l_voting['inquiry_question']));
		$table->setColContent(3,0,getPixel(10,7));
		$table->setColContent(4,0,htmlFormElementTable(we_htmlElement::htmlDiv(array('id'=>'answers')),$l_voting['inquiry_answers']));

		array_push($parts,array(
				'headline'=>$l_voting['headline_data'],
				'html'=>we_htmlElement::htmlHidden(array('name'=>'question_name','value'=>'')) .
						we_htmlElement::htmlHidden(array('name'=>'variant_count','value'=>'0')) .
						we_htmlElement::htmlHidden(array('name'=>'answers_name','value'=>'')) .
						we_htmlElement::htmlHidden(array('name'=>'item_count','value'=>'0')) .
						we_htmlElement::htmlHidden(array('name'=>'iptable_name','value'=>'')) .
						we_htmlElement::htmlHidden(array('name'=>'iptable_count','value'=>'0')) .
						$table->getHtmlCode() .
						$we_button->create_button("image:btn_function_plus", "javascript:top.content.setHot();answers_edit.addItem()")
				,
				'space'=>$this->_space_size
				)
		);

		return $parts;
	}

	function getHTMLTab3(){
		global $l_voting;

		$we_button = new we_button();
		$parts = array();


		$selectTime = new we_htmlSelect(array('name'=>'RevoteTime','class'=>'weSelect','size'=>'1','style'=>'width:200','onchange' => 'top.content.setHot(); if(this.value==0) setVisible(\'method_table\',false); else setVisible(\'method_table\',true);'));
		$selectTime->addOption((-1),$l_voting['never']);
		$selectTime->addOption((86400),$l_voting['one_day']);
		$selectTime->addOption((3600),$l_voting['one_hour']);
		$selectTime->addOption((1800),$l_voting['thirthty_minutes']);
		$selectTime->addOption((900),$l_voting['feethteen_minutes']);
		$selectTime->addOption((0),$l_voting['always']);
		$selectTime->selectOption($this->View->voting->RevoteTime);

		$table = new we_htmlTable(array('id' => 'method_table', 'style' => 'display: ' . ($this->View->voting->RevoteTime == 0 ? 'none' : 'block') ,'cellpadding' => 2,'cellspacing' => 1,'border' => 0),8,2);
		$table->setCol(0,0,array('colspan'=>2),
			htmlAlertAttentionBox(
				we_htmlElement::htmlB($l_voting["cookie_method"]).we_htmlElement::htmlBr().
				$GLOBALS["l_voting"]["cookie_method_help"] .
				we_htmlElement::htmlBr().we_htmlElement::htmlB($l_voting["ip_method"]).we_htmlElement::htmlBr().
				$GLOBALS["l_voting"]["ip_method_help"],
				2,($this->_width_size-3),false,100
			)
		);


		$table->setCol(2,0,array('colspan'=>2),we_forms::radiobutton(1, ($this->View->voting->RevoteControl==1 ? true : false), 'RevoteControl', $l_voting["cookie_method"] ,true, "defaultfont", "top.content.setHot();"));

		$table->setColContent(3,0,getPixel(10,5));
		$table->setColContent(3,1,we_forms::checkboxWithHidden($this->View->voting->FallbackIp ? true : false, 'FallbackIp', $l_voting['fallback'] ,false, "defaultfont", "top.content.setHot();"));

		$table->setColContent(4,0,getPixel(10,10));

		$table->setCol(5,0,array('colspan'=>2),we_forms::radiobutton(0, ($this->View->voting->RevoteControl==0 ? true : false), 'RevoteControl', $l_voting["ip_method"] ,true, "defaultfont", "top.content.setHot();"));

		$datasize = f('SELECT (LENGTH(Revote)+LENGTH(RevoteUserAgent)) AS Size FROM ' . VOTING_TABLE,'Size',$this->db);

		$table->setColContent(6,1,we_forms::checkboxWithHidden($this->View->voting->UserAgent ? true : false, 'UserAgent', $l_voting['save_user_agent'] ,false, "defaultfont", "top.content.setHot();"));

		$table->setCol(7,1,array('id'=>'delete_ip_data','style'=>'display: ' . ($datasize>0 ? 'block' : 'none')),
								htmlAlertAttentionBox(sprintf($l_voting['delete_ipdata_text'],we_htmlElement::htmlSpan(array('id'=>'ip_mem_size'),$datasize)),2,($this->_width_size-20),false,100) .
								$we_button->create_button('delete','javascript:we_cmd(\'reset_ipdata\')')
		);


		array_push($parts,array(
					'headline'=>$l_voting['headline_revote'],
					'html'=>htmlAlertAttentionBox($GLOBALS["l_voting"]["time_after_voting_again_help"], 2,$this->_width_size,false,100).
							we_htmlElement::htmlBr().
							htmlFormElementTable($selectTime->getHtmlCode(),$l_voting['time_after_voting_again']) .
							we_htmlElement::htmlBr().
							$table->getHtmlCode() ,
					'space'=>$this->_space_size
				)
		);

		$table = new we_htmlTable(array('id'=>'LogData','style'=>'display: ' . ($this->View->voting->Log ? 'block' : 'none') . ';','cellpadding' => 2,'cellspacing' => 2,"border"=>0),1,2);
		$table->setColContent(0,0,getPixel(10,5));
		$table->setColContent(0,1,
			$we_button->position_yes_no_cancel(
												$we_button->create_button('logbook','javascript:we_cmd(\'show_log\')'),
												$we_button->create_button('delete','javascript:we_cmd(\'delete_log\')'),
												null
			)
		);

		array_push($parts,array(
					'headline'=>$l_voting['control'],
					'html'=>we_forms::checkboxWithHidden($this->View->voting->Log ? true : false, 'Log', $l_voting['voting_log'],false,'defaultfont','top.content.setHot(); toggle(\'LogData\')') .
							$table->getHtmlCode(),
					'space'=>$this->_space_size,
					'noline'=>1
				)
		);

		array_push($parts,array(
				'headline'=>'',
				'html'=> we_forms::checkboxWithHidden($this->View->voting->RestrictIP ? true : false, 'RestrictIP', $l_voting['forbid_ip'],false,'defaultfont','top.content.setHot(); toggle(\'RestrictIPDiv\')'),
				'space'=>$this->_space_size,
				'noline'=>1
				)
		);


		$table = new we_htmlTable(array('id'=>'RestrictIPDiv','style'=>'display: ' . ($this->View->voting->RestrictIP ? 'block' : 'none') . ';','cellpadding' => 2,'cellspacing' => 2,"border"=>0),2,2);
		$table->setColContent(0,0,getPixel(10,5));
		$table->setColContent(0,1,we_htmlElement::htmlDiv(array('id'=>'iptable','class'=>'blockWrapper','style'=>'width: '.($this->_width_size-10).'px; height: 60px; border: #AAAAAA solid 1px;padding: 5px;')));

		$table->setCol(1,0,array('colspan'=>'2','align'=>'right'),
			$we_button->create_button_table(array(
					$we_button->create_button("delete_all", "javascript:top.content.setHot(); removeAll()"),
					$we_button->create_button("add", "javascript:top.content.setHot(); newIp()")
				)
			)
		);


		array_push($parts,array(
				'headline'=>'',
				'html'=>we_htmlElement::jsElement('

							function removeAll(){
								for(var i=0;i<iptable_label.itemCount+1;i++){
									iptable_label.delItem(i);
								}
							}

							function newIp(){
								var ip = prompt("' . $l_voting['new_ip_add'] . '","");


								var re = new RegExp("[a-zA-Z|,]");
								var m = ip.match(re);
								if(m != null){
									' . we_message_reporting::getShowMessageCall($l_voting['not_valid_ip'], WE_MESSAGE_ERROR) . '
									return;
								}

								var re = new RegExp("^(([0-2|\*]?[0-9|\*]{1,2}\.){3}[0-2|\*]?[0-9|\*]{1,2})");

								var m = ip.match(re);

								if(m != null){

									var p = ip.split(".");
									for (var i = 0; i < p.length; i++) {
								      var t = p[i];
								      t.replace("*","");
								      if(parseInt(t)>255) {
								      	' . we_message_reporting::getShowMessageCall($l_voting['not_valid_ip'], WE_MESSAGE_ERROR) . '
								      	return false;
								      }
								    }

									iptable_label.addItem();
									iptable_label.setItem(0,(iptable_label.itemCount-1),ip);
									iptable_label.showVariant(0);
								} else {
									' . we_message_reporting::getShowMessageCall($l_voting['not_valid_ip'], WE_MESSAGE_ERROR) . '
								}
							}
					').$table->getHtmlCode(),
				'space'=>$this->_space_size)
		);

		return $parts;

	}

	function getHTMLTab4(){
		$parts = array();
		global $l_voting;

	    $we_button = new we_button();
		$content = "";

		$total_score = array_sum($this->View->voting->Scores);

		$version = isset($_REQUEST['vernr']) ? $_REQUEST['vernr'] : 0;

		$table = new we_htmlTable(array('cellpadding' => 3,'cellspacing' => 0,'border'=>0,'class'=>'defaultfont','style'=>'width: '.$this->_width_size.'px'),1,5);
		$table->setCol(0,0,array('colspan'=>5,'class'=>'defaultfont'),we_htmlElement::htmlB(we_htmlElement::htmlSpan(array('id'=>'question_score'),stripslashes($this->View->voting->QASet[$version]['question']))));
		$i = 1;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");

	    foreach ($this->View->voting->QASet[$version]['answers'] as $key=>$value){
	    	if(!isset($this->View->voting->Scores[$key])) $this->View->voting->Scores[$key] = 0;

	    	$percent = weVotingFrames::getPercent($total_score,$this->View->voting->Scores[$key],2);

			$pb=new we_progressBar($percent);
 			$pb->setName('item'.$key);
 			$pb->setStudWidth(10);
            $pb->setStudLen(150);

            $table->addRow();
			$table->setRow($key+1,array("id"=>"row_scores_$key"));
	    	$table->setCol($i,0,array('style'=>'width: '.($this->_width_size-150).'px'),we_htmlElement::htmlSpan(array('id'=>'answers_score_' . $key),stripslashes($value)));
	    	$table->setColContent($i,1,$pb->getJS().$pb->getHTML());
	    	$table->setColContent($i,2,'&nbsp;');
	    	$table->setColContent($i,3,htmlTextInput('scores_'.$key,4,$this->View->voting->Scores[$key],'','id="scores_'.$key.'" onKeyUp="var r=parseInt(this.value);if(isNaN(r)) this.value='.$this->View->voting->Scores[$key].'; else{ this.value=r;document.we_form.scores_cahnged.value=1;}refreshTotal();"'));
			$i++;
	    }
	    $table->addRow();
	    $table->setColContent($i,0,we_htmlElement::htmlB($l_voting['total_voting'].':').hidden("updateScores","false",array("id"=>'updateScores')));
	    $table->setCol($i,3,array('colspan'=>3),we_htmlElement::htmlB(we_htmlElement::htmlSpan(array('id'=>'total'),$total_score)));

	    $butt = $we_button->create_button("reset_score", "javascript:top.content.setHot();resetScores();");

		$js = we_htmlElement::jsElement('
			function resetScores(){
				if(confirm("'.$l_voting["result_delete_alert"].'")) {
					for(var i=0;i<'.($i-1).';i++){
						document.we_form.elements["scores_"+i].value = 0;
					}
					document.we_form.scores_cahnged.value=1;
					refreshTotal();
				} else {}
			}

			function refreshTotal(){
				var total=0;
				for(var i=0;i<'.($i-1).';i++){
					total += parseInt(document.we_form.elements["scores_"+i].value);
				}

				var t = document.getElementById("total");
				t.innerHTML = total;

				for(var i=0;i<'.($i-1).';i++){
					if(total!=0){
						percent = Math.round((parseInt(document.we_form.elements["scores_"+i].value)/total) * 100);
					}
					else percent = 0;
					eval("setProgressitem"+i+"("+percent+");");
				}

			}

			function refreshTexts(){
				var t = document.getElementById("question_score");
				eval("t.innerHTML = document.we_form."+question_edit.name+"_item0.value");
				for(i=0;i<answers_edit.itemCount;i++){
					var t = document.getElementById("answers_score_"+i);
					eval("t.innerHTML = document.we_form."+answers_edit.name+"_item"+i+".value");
				}
			}

		');

	    array_push($parts,array(
				"headline"=>$l_voting['inquiry'],
				"html"=>$js .
						we_htmlElement::htmlHidden(array('name'=>'scores_cahnged','value'=>'0')).
						$table->getHTMLCode() .
						we_htmlElement::htmlBr() .$butt,
				"space"=>$this->_space_size)
		);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/export.inc.php");

		$ok = $we_button->create_button("export","javascript:we_cmd('export_csv')");

		$export_box=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),10,1);

		$export_box->setCol(0,0,array(),getPixel(10,10));
		$export_box->setCol(1,0,array(),htmlFormElementTable($this->formFileChooser($this->_width_size-130,'csv_dir','/','','folder'),$l_export['dir']));
		$export_box->setCol(2,0,array(),getPixel(5,5));

		$lineend = new we_htmlSelect(array('name'=>'csv_lineend','size'=>'1','class'=>'defaultfont','style'=>'width: '.$this->_width_size.'px'));
		$lineend->addOption('windows', $l_export['windows']);
		$lineend->addOption('unix', $l_export["unix"]);
		$lineend->addOption('mac', $l_export["mac"]);

		$delimiter = new we_htmlSelect(array('name'=>'csv_delimiter','size'=>'1','class'=>'defaultfont','style'=>'width: '.$this->_width_size.'px'));
		$delimiter->addOption(';',$l_export['semicolon']);
		$delimiter->addOption(',',$l_export['comma']);
		$delimiter->addOption(':',$l_export['colon']);
		$delimiter->addOption('\t',$l_export['tab']);
		$delimiter->addOption(' ',$l_export['space']);

		$enclose = new we_htmlSelect(array('name'=>'csv_enclose','size'=>'1','class'=>'defaultfont','style'=>'width: '.$this->_width_size.'px'));
		$enclose->addOption(0,$l_export['double_quote']);
		$enclose->addOption(1,$l_export['single_quote']);

		$export_box->setCol(3, 0, array("class" => "defaultfont"), htmlFormElementTable($lineend->getHtmlCode(),$l_export['csv_lineend']));
		$export_box->setColContent(4,0,getPixel(5,5));
		$export_box->setColContent(5,0, htmlFormElementTable($delimiter->getHtmlCode(),$l_export['csv_delimiter']));
		$export_box->setColContent(6,0,getPixel(5,5));
		$export_box->setColContent(7,0, htmlFormElementTable($enclose->getHtmlCode(),$l_export['csv_enclose']));
		$export_box->setColContent(8,0,getPixel(5,15));
		$export_box->setCol(9,0,array("nowrap"=>null),
						$we_button->create_button_table(array($ok))
		);



	    array_push($parts,array(
				"headline"=>$l_voting['export'],
				"html"=>htmlAlertAttentionBox($l_voting['export_txt'],2,$this->_width_size).
						$export_box->getHtmlCode(),
				"space"=>$this->_space_size)
		);

		return $parts;

	}


	function getHTMLProperties($preselect=""){

		$tabNr = isset($_REQUEST["tabnr"]) ? (($this->View->voting->IsFolder && $_REQUEST["tabnr"]!=1) ? 1 : $_REQUEST["tabnr"]) : 1;

		$out = we_htmlElement::jsElement('

			var table = "'.FILE_TABLE.'";
			var log_counter=0;
			function toggle(id){
				var elem = document.getElementById(id);
				if(elem.style.display == "none") elem.style.display = "block";
				else elem.style.display = "none";
			}
			function setVisible(id,visible){
				var elem = document.getElementById(id);
				if(visible==true) elem.style.display = "block";
				else elem.style.display = "none";
			}

		');

		include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		$out .=	we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>($tabNr==1 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab1(),30,'',-1,'','',false,$preselect)) .
				(!$this->View->voting->IsFolder ?
				(
					we_htmlElement::htmlDiv(array('id' => 'tab2','style'=>($tabNr==2 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab2(),30,'',-1,'','',false,$preselect)) .
					we_htmlElement::htmlDiv(array('id' => 'tab3','style'=>($tabNr==3 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab3(),30,'',-1,'','',false,$preselect)) .
					we_htmlElement::htmlDiv(array('id' => 'tab4','style'=>($tabNr==4 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab4(),30,'',-1,'','',false,$preselect))
				)

				: '') .
				$this->getHTMLVariant();

		return $out;
	}

	function getHTMLDirChooser(){
		global $l_voting;

		$we_button = new we_button();
		$path = id_to_path($this->View->voting->ParentID,VOTING_TABLE);
		$button = $we_button->create_button('select', "javascript:top.content.setHot(); we_cmd('openVotingDirselector',document.we_form.elements['ParentID'].value,'document.we_form.elements[\'ParentID\'].value','document.we_form.elements[\'ParentPath\'].value','')");
		$width = "416";
		
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("PathGroup");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput("ParentPath",$path,'onchange=top.content.setHot();');
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult("ParentID",(empty($this->View->voting->ParentID)?0:$this->View->voting->ParentID));
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(VOTING_TABLE);
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);
		$yuiSuggest->setLabel($l_voting['group']);
		
		return $yuiSuggest->getHTML();
	}

	function getHTMLLeft(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

   		$frameset->setAttributes(array("rows"=>"1,*,0"));
    	$frameset->addFrame(array("src"=>HTML_DIR."whiteWithTopLine.html","name"=>"treeheader","noresize"=>null,"scrolling"=>"no"));

		$frameset->addFrame(array("src"=>WEBEDITION_DIR."treeMain.php","name"=>"tree","noresize"=>null,"scrolling"=>"auto"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=treefooter","name"=>"treefooter","noresize"=>null,"scrolling"=>"no"));

		// set and return html code
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return $this->getHTMLDocument($body);
	}


	function getHTMLTreeHeader(){
		return "";
	}

	function getHTMLTreeFooter(){

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"5","marginheight"=>"0","leftmargin"=>"5","topmargin"=>"0"),
						""
		);

		return $this->getHTMLDocument($body);
	}





	function getHTMLCmd(){
		$out="";

		if(isset($_REQUEST["pid"])){
			$pid=$_REQUEST["pid"];
		}
		else exit;

		if(isset($_REQUEST["offset"])){
			$offset=$_REQUEST["offset"];
		}
		else $offset=0;

		include_once(WE_VOTING_MODULE_DIR."weVotingTreeLoader.php");

		$rootjs="";
		if(!$pid)
		$rootjs.='
		'.$this->Tree->topFrame.'.treeData.clear();
		'.$this->Tree->topFrame.'.treeData.add(new '.$this->Tree->topFrame.'.rootEntry(\''.$pid.'\',\'root\',\'root\'));
		';

		$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"cmd")).
				 	we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"no_cmd"));

		$out.=we_htmlElement::htmlBody(array("bgcolor"=>"white","marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10"),
					we_htmlElement::htmlForm(array("name"=>"we_form"),
							$hiddens.
							we_htmlElement::jsElement($rootjs.$this->Tree->getJSLoadTree(weVotingTreeLoader::getItems($pid,$offset,$this->Tree->default_segment,"")))
					)
		);

		return $this->getHTMLDocument($out);
	}

	function getHTMLExportCsvMessage($mode=0){
		global $l_voting;

		if (isset($_REQUEST["lnk"])) {
			$link=$_REQUEST["lnk"];
		}

		if (isset($link)) {
			$port = defined("HTTP_PORT") ? HTTP_PORT : 80;
			$down = getServerProtocol(true).SERVER_NAME.":".$port.$link;

			$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),7,1);

			$table->setCol(0,0,array(),getPixel(5,5));

			$table->setCol(1,0,array("class"=>"defaultfont"),sprintf($l_voting["csv_export"],$link));

			$table->setCol(2,0,array(),getPixel(5,10));

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weBrowser.class.php');

			$table->setCol(3,0,array("class"=>"defaultfont"),weBrowser::getDownloadLinkText());
			$table->setCol(4,0,array(),getPixel(5,10));
			$table->setCol(5,0,array("class"=>"defaultfont"),
				we_htmlElement::htmlA(array("href"=>$down),
					$l_voting["csv_download"]
				)
			);
			$table->setCol(6,0,array(),getPixel(100,10));


			$we_button = new we_button();


			$close = $we_button->create_button("close","javascript:self.close();");


			$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
								we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
									we_htmlElement::htmlHidden(array("name"=>"group","value"=>(isset($group) ? $group : ""))).
									htmlDialogLayout(
															$table->getHtmlCode(),
															$l_voting["csv_download"],
															$we_button->position_yes_no_cancel(null,$close,null),"100%","30",350)
									.
									we_htmlElement::jsElement("self.focus();")
								)
			);

			return $this->getHTMLDocument($body);

		}


	}

	function formFileChooser($width = "", $IDName = "ParentID", $IDValue = "/", $cmd = "", $filter = "") {
		$we_button = new we_button();
	  	$button =  $we_button->create_button("select","javascript:we_cmd('browse_server','document.we_form.elements[\\'$IDName\\'].value','$filter',document.we_form.elements['$IDName'].value);");

		return htmlFormElementTable(htmlTextInput($IDName,30,$IDValue,"",'readonly onchange="top.content.setHot();"',"text",$width,0),
			"",
			"left",
			"defaultfont",
			"",
			getPixel(20,4),
			we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $button : "");
	}

	function getHTMLResetIPData(){
		global $l_voting;

		$this->View->voting->resetIpData();

		$we_button = new we_button();
		$close = $we_button->create_button("close","javascript:self.close();");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
				htmlDialogLayout(
										we_htmlElement::htmlSpan(array('class'=>'defaultfont'),$l_voting['data_deleted_info']),
										$l_voting["voting"],
										$we_button->position_yes_no_cancel(null,$close,null)) .
				we_htmlElement::jsElement("self.focus();")

		);
		return $this->getHTMLDocument($body);

	}

	function getHTMLDeleteLog(){
		global $l_voting;

		$this->View->voting->deleteLogData();

		$we_button = new we_button();
		$close = $we_button->create_button("close","javascript:self.close();");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
				htmlDialogLayout(
										we_htmlElement::htmlSpan(array('class'=>'defaultfont'),$l_voting['data_deleted_info']),
										$l_voting["voting"],
										$we_button->position_yes_no_cancel(null,$close,null)) .
				we_htmlElement::jsElement("self.focus();")

		);
		return $this->getHTMLDocument($body);

	}

	function getHTMLShowLog(){
		global $l_voting;

		include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");

		$we_button = new we_button();

		$close = $we_button->create_button("close","javascript:self.close();");
		$refresh = $we_button->create_button("refresh","javascript:location.reload();");

		$voting = new weVoting();
		$voting->load($this->View->voting->ID);
		$log = array();
		if(!is_array($voting->LogData)) {
			$log = unserialize($voting->LogData);
			if(empty($log)) {
				$log = array();
			}
		}

		$headline = array();

		$headline[0] = array('dat' => we_htmlElement::htmlB($l_voting['time']));
		$headline[1] = array('dat' => we_htmlElement::htmlB($l_voting['ip']));
		$headline[2] = array('dat' => we_htmlElement::htmlB($l_voting['user_agent']));
		$headline[3] = array('dat' => we_htmlElement::htmlB($l_voting['cookie']));
		$headline[4] = array('dat' => we_htmlElement::htmlB($l_voting['log_fallback']));
		$headline[5] = array('dat' => we_htmlElement::htmlB($l_voting['status']));


		$content = array();

		$count = 15;
		$size = count($log);

		$nextprev = "";

		if($size>0){
			$size --;
			$start = (isset($_REQUEST['start']) ? $_REQUEST['start'] : $size);
			$start = $start < 0 ? 0 : $start;
			$start = $start>$size ? $size : $start;

			$back = $start + $count;
			$back = $back>$size ? $size : $back;

			$next = $start - $count;
			$next = $next<0 ? -1 : $next;

			$ind = 0;
			for($i=$start;$i>$next;$i--){
				if($i<0) break;
				$data = $log[$i];
				$content[$ind] = array();
				$content[$ind][0]['dat'] = date($l_we_editor_info["date_format"], $data['time']);
				$content[$ind][1]['dat'] = $data['ip'];
				$content[$ind][2]['dat'] = $data['agent'];
				$content[$ind][3]['dat'] = $data['cookie'] ? $l_voting['enabled'] : $l_voting['disabled'];
				$content[$ind][4]['dat'] = $data['fallback'] ? $GLOBALS['l_global']['yes'] : $GLOBALS['l_global']['no'];

				$mess = $l_voting['log_success'];
				if($data['status']!=VOTING_SUCCESS){
					switch ($data['status']) {
						case VOTING_ERROR :
							$mess = $l_voting['log_error'];
						break;
						case VOTING_ERROR_ACTIVE :
							$mess = $l_voting['log_error_active'];
						break;
						case VOTING_ERROR_REVOTE :
							$mess = $l_voting['log_error_revote'];
						break;
						case VOTING_ERROR_BLACKIP :
							$mess = $l_voting['log_error_blackip'];
						break;
						default:
							$mess = $l_voting['log_error'];
					}
					$mess = we_htmlElement::htmlSpan(array('style' => 'color: red;'),$mess);
				}

				$content[$ind][5]['dat'] = $mess ;
				$ind++;
			}

			$nextprev = '<table style="margin-top: 10px;" border="0" cellpadding="0" cellspacing="0"><tr><td>';
			if($start<$size){
				$nextprev .= $we_button->create_button("back", $this->frameset . "?pnt=show_log&start=".$back); //bt_back
			}else{
				$nextprev .= $we_button->create_button("back", "", false, 100, 22, "", "", true);
			}

			$nextprev .= getPixel(23,1)."</td><td align='center' class='defaultfont' width='120'><b>".($size - $start + 1)."&nbsp;-&nbsp;";

			$nextprev .= ($size - $next);

			$nextprev .= "&nbsp;".$GLOBALS["l_global"]["from"]." ".($size+1)."</b></td><td>".getPixel(23,1);

			if($next > 0){
				$nextprev .= $we_button->create_button("next", $this->frameset . "?pnt=show_log&start=".$next); //bt_next
			}else{
				$nextprev .= $we_button->create_button("next", "", "", 100, 22, "", "", true);
			}
			$nextprev .= "</td></tr></table>";

			$parts = array();

			$parts[]=array(
					'headline' => '',
					'html' => htmlDialogBorder3(730,300,$content,$headline) . $nextprev,
					'space' => 0,
					'noline'=>1

			);
		} else {
			$parts[]=array(
					'headline' => '',
					'html' => 	we_htmlElement::htmlSpan(array('class'=>'middlefontgray'), $l_voting['log_is_empty']) .
								we_htmlElement::htmlBr() .
								we_htmlElement::htmlBr() ,
					'space' => 0,
					'noline'=>1

			);

		}

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
				we_multiIconBox::getHTML("show_log_data","100%",$parts,30,$we_button->position_yes_no_cancel($refresh,$close,null),-1,'','',false,$l_voting['voting'],"",558) .
				we_htmlElement::jsElement("self.focus();")

		);
		return $this->getHTMLDocument($body);

	}

}

?>