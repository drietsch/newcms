<?php


// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModuleFrames.php");
include_once(WE_CUSTOMER_MODULE_DIR."weCustomerView.php");
include_once(WE_CUSTOMER_MODULE_DIR."weCustomerTree.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");

class weCustomerFrames extends weModuleFrames {

	var $View;
	var $jsOut_fieldTypesByName;

	function weCustomerFrames() {
		weModuleFrames::weModuleFrames(WE_CUSTOMER_MODULE_PATH."edit_customer_frameset.php");
		$this->Tree=new weCustomerTree();
		$this->View = new weCustomerView(WE_CUSTOMER_MODULE_PATH."edit_customer_frameset.php","top.content");
		$this->setupTree(CUSTOMER_TABLE,"top.content","top.content.resize.left.tree","top.content.cmd");
		$this->module="customer";
	}

	function getHTMLFrameset(){
		$this->View->customer->clearSessionVars();
		//$this->View->settings->clearSessionVars();
		$this->View->settings->load(false);
		return weModuleFrames::getHTMLFrameset();
	}

	function getHTMLResize(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

		if($GLOBALS["BROWSER"] == "NN"){
			$frameset->setAttributes(array("cols"=>'220,*'));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=left","name"=>"left","noresize"=>null));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=right" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"right","noresize"=>null));
		}
		else{
			$frameset->setAttributes(array("cols"=>'220,*',"border"=>"1","frameborder"=>"yes"));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=left","name"=>"left"));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=right" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"right"));
		}

		// set and return html code
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return $this->getHTMLDocument($body);

	}

	function getJSCmdCode(){
		return $this->View->getJSTop();
	}

	function getHTMLBranchSelect($with_common=true,$with_other=true){
		global $l_customer;

		$branches_names=array();
		$branches_names=$this->View->customer->getBranchesNames();

		$select=new we_htmlSelect(array("name"=>"branch"));

		if($with_common) $select->addOption($l_customer["common"],$l_customer["common"]);
		if($with_other) $select->addOption($l_customer["other"],$l_customer["other"]);

		foreach($branches_names as $branch){
			$select->addOption($branch,$branch);
		}


		return $select;
	}

	function getHTMLFieldsSelect($branch){
		global $l_customer;

		$select=new we_htmlSelect(array("name"=>"branch"));

		$fields_names=array();
		$fields_names=$this->View->customer->getFieldsNames($branch);
		$this->jsOut_fieldTypesByName = "\tvar fieldTypesByName = new Array();\n";
		foreach ($fields_names as $val) {
			$tmp = $this->View->getFieldProperties($val);
			$this->jsOut_fieldTypesByName .= "\tfieldTypesByName['$val'] = '" . (isset($tmp['type']) ? $tmp['type'] : "") . "';\n";
		}
		if(is_array($fields_names)){
			foreach($fields_names as $k=>$field){
				if($this->View->customer->isProperty($field)) $select->addOption($k,$this->View->settings->getPropertyTitle($field));
				else $select->addOption($k,$field);
			}
		}

		return $select;
	}

	function getHTMLSortSelect($include_no_sort=true){
		global $l_customer;

		$sort=new we_htmlSelect(array('name'=>'sort','class'=>'weSelect'));

		$sort_names=array_keys($this->View->settings->SortView);

		if($include_no_sort) $sort->addOption($l_customer["no_sort"],$l_customer["no_sort"]);

		foreach($sort_names as $k=>$v){
			$sort->addOption($v,$v);
		}


		return $sort;
	}

	function getHTMLFieldControl($field,$value=null){
		$props=$this->View->getFieldProperties($field);
		if($props['type']!='select' && !$this->View->customer->ID && $value==null){
			$value=$props['default'];
		}
		switch($props["type"]){
			case "input":
				return htmlTextInput($field,32,stripslashes($value),"","onchange=\"top.content.setHot();\" style='{width:240}'");
			break;
			case "select":

				$defs=explode(',',$props['default']);
				if(!in_array($value,$defs)){
					$defs = array_merge(array($value),$defs);
				}

				$select=new we_htmlSelect(array("name"=>$field,"size"=>"1","style"=>"{width:240;}","class"=>"wetextinput","onblur"=>"this.className='wetextinput'","onfocus"=>"this.className='wetextinputselected'", "id"=>($field=="Gruppe" ? "yuiAcInputPathGroupX" : ""), "onchange"=> ($field=="Gruppe" ? "top.content.setHot();" : "top.content.setHot();")));
				foreach($defs as $def) $select->addOption($def,$def);
				$select->selectOption($value);
				return $select->getHtmlCode();
			break;
			case "textarea":
				return  we_htmlElement::htmlTextArea(array("name"=>$field,"style"=>"{width:240}","class"=>"wetextarea","onblur"=>"this.className='wetextarea'","onfocus"=>"this.className='wetextareaselected'"),stripslashes($value));
			break;
			case "date":
				include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
				$out="";
				$out=we_htmlElement::htmlHidden(array("name"=>$field,"value"=>$value));

				if(empty($value)) {
					$value = $this->View->settings->Prefs["start_year"] . '-01-01';
				}
				$value=$this->View->settings->getDate($value);

				$out.=we_htmlElement::jsElement('
					function populateDate_'.$field.'(){
						var year=document.we_form.'.$field.'_select_year.options[document.we_form.'.$field.'_select_year.selectedIndex].text;
						var month=document.we_form.'.$field.'_select_month.options[document.we_form.'.$field.'_select_month.selectedIndex].text;
						var day=document.we_form.'.$field.'_select_day.options[document.we_form.'.$field.'_select_day.selectedIndex].text;

						var datevar=new Date();
						datevar.setFullYear(year);
						datevar.setDate(day);
						datevar.setMonth(month-1);

						'.(we_getHourPos($l_we_editor_info["date_format"])!=-1 ?
						'datevar.setHours(document.we_form.'.$field.'_select_hour.options[document.we_form.'.$field.'_select_hour.selectedIndex].text);'
						:
						'')
						.'

						'.(we_getMinutePos($l_we_editor_info["date_format"])!=-1 ?
						'datevar.setMinutes(document.we_form.'.$field.'_select_minute.options[document.we_form.'.$field.'_select_minute.selectedIndex].text);'
						:
						'')
						.'

						document.we_form.'.$field.'.value=formatDate(datevar,\''.addslashes(DATE_FORMAT).'\');

					}
				');
				$out.=getPixel(5,5).$this->getDateInput2($field."_select%s",$value,false,$l_we_editor_info["date_format"],"populateDate_$field()","defaultfont",$this->View->settings->Prefs["start_year"]).getPixel(5,5);
				return $out;
			break;
			case "password":
				return  htmlTextInput($field,32,$value,"","onchange=\"top.content.setHot();\" style='{width:240}'","password");
			break;
			case "img":

				$imgId = abs($value);

				$we_button = new we_button();
				include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/"."we_classes/we_document.inc.php");
				$out = we_document::getFieldByVal($imgId, "img");



				$out = "
					<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\" background=\"" . IMAGE_DIR . "backgrounds/aquaBackground.gif\" style=\"border: solid #006DB8 1px;\">
						<tr>
							<td class=\"weEditmodeStyle\" colspan=\"2\" align=\"center\">$out
								<input type=\"hidden\" name=\"$field\" value=\"$imgId\"></td>
						</tr>
						<tr>
							<td class=\"weEditmodeStyle\" colspan=\"2\" align=\"center\">";

							$out .= $we_button->create_button_table(array($we_button->create_button("image:btn_select_image", "javascript:we_cmd('openDocselector', '" . $imgId . "', '".FILE_TABLE."', 'document.forms[\\'we_form\\'].elements[\\'" . $field . "\\'].value', '', 'opener.refreshForm()', '" . session_id() . "', '', 'image/*', " . (we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ")", true), $we_button->create_button("image:btn_function_trash", "javascript:document.we_form.elements['$field'].value='';refreshForm();", true)), 5) .
							"</td>
						</tr>
					</table>";

				return  $out;

			break;

			default: return htmlTextInput($field,32,stripslashes($value),"","onchange=\"top.content.setHot();\" style='{width:240}'");
		}
		return null;
	}

	function getHTMLEditorHeader() {
		global $l_customer;
		$extraJS = "var aTabs=new Array;\n";

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#FFFFFF","background"=>"/webEdition/images/backgrounds/bgGrayLineTop.gif"),""));
		}

		$tabs = new we_tabs();

		$branches_names=array();
		$branches_names=$this->View->customer->getBranchesNames();

		$tabs->addTab(new we_tab("#",$l_customer["common"],'TAB_NORMAL',"setTab('" . $l_customer["common"] . "');",array("id"=>"common")));
		$extraJS .= "aTabs['".$l_customer["common"]."']='common';\n";
		$branchCount = 0;
		foreach($branches_names as $branch){
			$tabs->addTab(new we_tab("#",$branch,'TAB_NORMAL',"setTab('" . $branch . "');",array("id"=>"branch_".$branchCount)));
			$extraJS .= "aTabs['".$branch."']='branch_".$branchCount."';\n";
			$branchCount++;
		}
		$tabs->addTab(new we_tab("#",$l_customer["other"],'TAB_NORMAL',"setTab('" . $l_customer["other"] . "');",array("id"=>"other")));
		$extraJS .= "aTabs['".$l_customer["other"]."']='other';\n";
		$tabs->addTab(new we_tab("#",$l_customer["all"],'TAB_NORMAL',"setTab('" . $l_customer["all"] . "');", array("id"=>"all")));
		$extraJS .= "aTabs['".$l_customer["all"]."']='all';\n";
//((top.content.activ_tab=="' . $l_customer["other"] . '") ? TAB_ACTIVE : TAB_NORMAL)
		$js=we_htmlElement::jsElement('
				function setTab(tab) {
					'.$this->topFrame.'.activ_tab=tab;
					parent.edbody.we_cmd(\'switchPage\',tab);
				}
				top.content.hloaded = 1;
		');

		if (defined('SHOP_TABLE')) {
			$tabs->addTab(new we_tab("#",$l_customer["orderTab"],'TAB_NORMAL',"setTab('" . $l_customer["orderTab"] . "');", array("id"=>"orderTab")));
			$extraJS .= "aTabs['".$l_customer["orderTab"]."']='orderTab';\n";
		}

		$tabs->onResize();
		$tabsHead = $tabs->getHeader();
		$tabsBody = $tabs->getJS();
		$tabsHead .= $js;
//		$js.= $tabsHead;


		$table=new we_htmlTable(array("width"=>"3000","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),3,1);

		$table->setCol(0,0,array(),getPixel(1,3));

		$table->setCol(1,0,array("valign"=>"top","class"=>"small"),
							getPixel(15,2).
							we_htmlElement::htmlB(
								$l_customer["customer"].":&nbsp;". $this->View->customer->Username .
								we_htmlElement::htmlImg(array("align"=>"absmiddle","height"=>"19","width"=>"1600","src"=>IMAGE_DIR."pixel.gif"))
							)
		);

		$extraJS .= 'if(top.content.activ_tab) document.getElementById(aTabs[top.content.activ_tab]).className="tabActive"; else document.getElementById("common").className="tabActive"';

		//$text = ($this->View->customer->Gruppe ? "/".$this->View->customer->Gruppe : "") . $this->View->customer->Path;
		$text = $this->View->customer->Username;
		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"),
			'<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",we_htmlElement::htmlB($l_customer["customer"])).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'. str_replace(" ","&nbsp;",$text) .'</b></span></nobr></div>' . getPixel(100,3) .
	 		$tabs->getHTML() .
			'</div>' . we_htmlElement::jsElement($extraJS)
			//$js.
			//$table->getHtmlCode() .
			//$tabsBody
		);

		return $this->getHTMLDocument($body,$tabsHead);
	}

	function getHTMLEditorBody() {
		global $l_customer;

		$hiddens=array("cmd"=>"edit_customer","pnt"=>"edbody","activ_sort"=>"0");

		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$hiddens["cmd"]="home";
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->View->getJSProperty();
			$GLOBALS["we_body_insert"] = we_htmlElement::htmlForm(array("name"=>"we_form"),
					$this->View->getCommonHiddens($hiddens).we_htmlelement::htmlHidden(array("name"=>"home","value"=>"0"))
			);
			$GLOBALS["mod"] = "customer";
			ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
		}

		if(isset($_REQUEST["branch"])) {
			if($_REQUEST["branch"]!="") {
				$branch=$_REQUEST["branch"];
			} else { $branch=$l_customer["common"];
			}
		} else {
			$branch=$l_customer["common"];
		}

		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody","onLoad"=>"loaded=1", "onunload"=>"doUnload()"),
			we_htmlElement::htmlForm(array("name"=>"we_form"),$this->View->getCommonHiddens($hiddens).$this->getHTMLProperties($branch))
		);

		return $this->getHTMLDocument($body,$this->View->getJSProperty());

	}

	function getHTMLEditorFooter() {
		global $l_newsletter;

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#EFf0EF"),""));
		}

		$we_button = new we_button();

		$table1=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"300"),1,1);
		$table1->setCol(0,0,array("nowrap"=>null,"valign"=>"top"),getPixel(1600,10));

		$table2=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"300"),1,2);
		$table2->setRow(0,array("valign"=>"middle"));
		$table2->setCol(0,0,array("nowrap"=>null),getPixel(5,5));
		$table2->setCol(0,1,array("nowrap"=>null),
					$we_button->create_button("save", "javascript:we_save();")
		);


		return $this->getHTMLDocument(
					we_htmlElement::jsElement("
					function we_save() {
						top.content.we_cmd('save_customer');

					}
					") .
					we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0"),
							we_htmlElement::htmlForm(array(),$table1->getHtmlCode().$table2->getHtmlCode())
					)
		);

	}


	function getHTMLProperties($preselect=""){
		global $l_customer;



		include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		$parts = array();

		$out="";
		$entry="";
		$branches=array();
		$common=array();
		$other=array();

		$common['ID'] = $this->View->customer->ID;
		$this->View->customer->getBranches($branches,$common,$other);

		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");


		if($preselect==$l_customer["common"] || $preselect==$l_customer["all"]){
			$table=new we_htmlTable(array("width"=>"300","height"=>"50","cellpadding"=>"10","cellspacing"=>"0","border"=>"0"),1,2);
			$r=0;
			$c=0;
			$table->setRow(0,array("valign"=>"top"));
			foreach($common as $pk=>$pv){
				$pv=stripslashes($pv);

				if($this->View->customer->isInfoDate($pk)){
					$pv = ($pv=='' || !is_numeric($pv)) ? 0 : $pv;
					$table->setCol($r,$c,array("class"=>"defaultfont"),htmlFormElementTable(($pv!="0" ? we_htmlElement::htmlDiv(array("class"=>"defaultgray"),date($l_we_editor_info["date_format"],$pv)) : "-".getPixel(100,5)),$this->View->settings->getPropertyTitle($pk)));
				}else if($pk=="ID"){
					$table->setCol($r,$c,array("class"=>"defaultfont"),htmlFormElementTable(($pv!="0" ? we_htmlElement::htmlDiv(array("class"=>"defaultgray"),$pv) : "-".getPixel(100,5)),$this->View->settings->getPropertyTitle($pk)));
					$c++;
					$table->setCol($r,$c,array("class"=>"defaultfont"),"");
				}else if($pk=="LoginDenied"){
					$table->setCol($r,$c,array("class"=>"defaultfont"),htmlFormElementTable(we_htmlElement::htmlDiv(array("class"=>"defaultgray"), we_forms::checkbox(1, $pv, "LoginDenied", $GLOBALS['l_customer']['login_denied'],false,"defaultfont","top.content.setHot();")), $this->View->settings->getPropertyTitle($pk)));
				}else if($pk=="Password"){
					$table->setCol($r,$c,array(),htmlFormElementTable(htmlTextInput($pk,32,$pv,"","onchange=\"top.content.setHot();\" ",(we_hasPerm('CUSTOMER_PASSWORD_VISIBLE') ? 'text' : 'password' ),"240px"),$this->View->settings->getPropertyTitle($pk)));
				}else{
					if($pk=="Username") $inputattribs = ' id="yuiAcInputPathName" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()"';
					else if ($pk=="xxx") $inputattribs = "";
					else $inputattribs = "";
					$table->setCol($r,$c,array(),htmlFormElementTable(htmlTextInput($pk,32,$pv,"","onchange=\"top.content.setHot();\" ".$inputattribs,"text","240px"),$this->View->settings->getPropertyTitle($pk)));
				}

				$c++;
				if($c>1){
					$r++;
					$table->addRow();
					$table->setRow($r,array("valign"=>"top"));
				}
				if($c>1) $c=0;

			}

			array_push($parts,array(
				"headline"=>($preselect==$l_customer["all"] ? $l_customer["common"] : $l_customer["data"]),
				"html"=>$table->getHtmlCode(),
				"space"=>120)
			);

		}
		if($preselect==$l_customer["orderTab"]){

			include_once(WE_SHOP_MODULE_DIR . 'shopFunctions.inc.php');

			$orderStr = getCustomersOrderList($this->View->customer->ID, false);

			array_push( $parts, array(
					"html"=>$orderStr,
					"space"=>0
				)
			);
		}
		if($preselect==$l_customer["other"] || $preselect==$l_customer["all"]){

			$table=new we_htmlTable(array("width"=>"500","height"=>"50","cellpadding"=>"10","cellspacing"=>"0","border"=>"0"),1,2);
			$r=0;
			$c=0;
			$table->setRow(0,array("valign"=>"top"));
			foreach($other as $k=>$v){
				$control=$this->getHTMLFieldControl($k,$v);
				if($control!=""){
					$table->setCol($r,$c,array(),htmlFormElementTable($control,$k));
					$c++;
					if($c>1){
						$r++;
						$table->addRow();
						$table->setRow($r,array("valign"=>"top"));
					}
					if($c>1) $c=0;
				}
			}
			array_push($parts,array(
				"headline"=>($preselect==$l_customer["all"] ? $l_customer["other"] : $l_customer["data"]),
				"html"=>$table->getHtmlCode(),
				"space"=>120)
			);

		}

		foreach($branches as $bk=>$branch){
			if($preselect!="" && $preselect!=$l_customer["all"]){
				if($bk!=$preselect) continue;
			}
			$table=new we_htmlTable(array("width"=>"500","height"=>"50","cellpadding"=>"10","cellspacing"=>"0","border"=>"0"),1,2);
			$r=0;
			$c=0;
			$table->setRow(0,array("valign"=>"top"));
			foreach($branch as $k=>$v){
				$control=$this->getHTMLFieldControl($bk."_".$k,$v);
				if($control!=""){

					$table->setCol($r,$c,array(),htmlFormElementTable($control,$k));

					$c++;
					if($c>1){
						$r++;
						$table->addRow();
						$table->setRow($r,array("valign"=>"top"));
					}
					if($c>1) $c=0;
				}
			}
			array_push($parts,array(
				"headline"=>($preselect==$l_customer["all"] ? $bk : $l_customer["data"]),
				"html"=>$table->getHtmlCode(),
				"space"=>120)
			);
		}
		$out=we_multiIconBox::getHTML("",680,$parts,30);

		return $out;
	}

	function getHTMLLeft(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

		$frameset->setAttributes(array("rows"=>"40,*,40"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=treeheader","name"=>"treeheader","noresize"=>null,"scrolling"=>"no"));

		$frameset->addFrame(array("src"=>WEBEDITION_DIR."treeMain.php","name"=>"tree","noresize"=>null,"scrolling"=>"auto"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=treefooter","name"=>"treefooter","noresize"=>null,"scrolling"=>"no"));

		// set and return html code
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return $this->getHTMLDocument($body);
	}


	function getHTMLTreeHeader(){

		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerAdd.php");
		return weCustomerAdd::getHTMLTreeHeader($this);
	}

	function getHTMLTreeFooter(){

		$we_button=new we_button();

		$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"treefooter")).
			we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"show_search"));

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"3000"),2,1);
		$table->setCol(0,0,array("valign"=>"top"),we_htmlElement::htmlImg(array("align"=>"absmiddle","height"=>"10","width"=>"1600","src"=>IMAGE_DIR."pixel.gif")));
		$table->setCol(1,0,array("nowrap"=>null,"class"=>"small"),
				we_htmlElement::jsElement($this->View->getJSSubmitFunction("treefooter")).
				$hiddens.
				$we_button->create_button_table(
									array(
										htmlTextInput("keyword",10,"","","","text","150px"),
										$we_button->create_button("image:btn_function_search", "javascript:submitForm()")
									)
				)
		);

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"5","marginheight"=>"0","leftmargin"=>"5","topmargin"=>"0"),
						we_htmlElement::htmlForm(array("name"=>"we_form"),$table->getHtmlCode())
		);

		return $this->getHTMLDocument($body);
	}


	function getHTMLCustomerAdmin(){
		global $l_customer;

		if (isset($_REQUEST["branch"])) $branch=$_REQUEST["branch"];
		else $branch=$l_customer["other"];
		if (isset($_REQUEST["branch_select"])) $branch_select=$_REQUEST["branch"];
		else $branch_select=$l_customer["other"];

		$we_button=new we_button();

		$select=$this->getHTMLBranchSelect(false);
		$select->setAttributes(array("name"=>"branch_select","class"=>"weSelect","onChange"=>"selectBranch()","style"=>"width:150"));
		$select->selectOption($branch_select);

		$fields=$this->getHTMLFieldsSelect($branch);
		$fields->setAttributes(array("name"=>"fields_select","size"=>"15","onChange"=>"","style"=>"width:310;height:250"));
		$hiddens=we_htmlElement::htmlHidden(array("name"=>"field","value"=>""));

		$buttons_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),5,1);
		$buttons_table->setCol(0,0,array(),$we_button->create_button("add", "javascript:we_cmd('open_add_field')"));
		$buttons_table->setCol(1,0,array(),getPixel(1,5));
		$buttons_table->setCol(2,0,array(),$we_button->create_button("edit", "javascript:we_cmd('open_edit_field')"));
		$buttons_table->setCol(3,0,array(),getPixel(1,5));
		$buttons_table->setCol(4,0,array(),$we_button->create_button("delete", "javascript:we_cmd('delete_field')"));

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"500"),5,5);

		$table->setCol(0,0,array("class"=>"defaultgray"),$l_customer["branch"]);
		$table->setCol(0,1,array(),getPixel(10,10));
		$table->setCol(0,2,array("class"=>"defaultgray"),$l_customer["branch_select"]);
		$table->setCol(1,0,array(),htmlTextInput("branch",48,$branch,"",'style="width:310"'));
		$table->setCol(1,1,array(),getPixel(10,10));
		$table->setCol(1,2,array(),$select->getHtmlCode());
		$table->setCol(1,3,array(),getPixel(10,10));
		$table->setCol(1,4,array(),$we_button->create_button("image:btn_edit_edit", "javascript:we_cmd('open_edit_branch')"));

		$table->setCol(2,0,array(),getPixel(10,10));

		$table->setCol(3,0,array("class"=>"defaultgray","valign"=>"top"),$l_customer["fields"]);
		$table->setCol(4,0,array("valign"=>"top"),$fields->getHtmlCode());
		$table->setCol(4,1,array("valign"=>"top"),getPixel(10,10));
		$table->setCol(4,2,array("valign"=>"top"),$buttons_table->getHtmlCode());

		$out=we_htmlElement::htmlBody(array("class"=>"weDIalogBody"),
						we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
						we_htmlElement::jsElement("self.focus();").
						we_htmlElement::jsElement($this->View->getJSAdmin()).
						we_htmlElement::htmlForm(array("name"=>"we_form"),
							we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"switchBranch")).
							we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"customer_admin")).
							htmlDialogLayout($table->getHtmlCode(),$l_customer["field_admin"],$we_button->create_button("close", "javascript:self.close()"))
						)
		);

		return $this->getHTMLDocument($out);
	}

	function getHTMLFieldEditor($type,$mode){
		global $l_customer;

		if (isset($_REQUEST["field"])) $field=$_REQUEST["field"];
		else $field="";

		if (isset($_REQUEST["branch"])) $branch=$_REQUEST["branch"];
		else $branch=$l_customer["other"];


		$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"field_editor")).
				 we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"no_cmd")).
				 we_htmlElement::htmlHidden(array("name"=>"branch","value"=>"$branch")).
				 we_htmlElement::htmlHidden(array("name"=>"art","value"=>"$mode")).
				 ($type=="field" ? we_htmlElement::htmlHidden(array("name"=>"field","value"=>"$field")) : "");

		$we_button = new we_button();
		$cancel = $we_button->create_button("cancel","javascript:self.close();");

		if($type=="branch"){
			$hiddens.=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"branch_editor"));
			$edit=new we_htmlTable(array("border"=>"0","cellpadding"=>"3","cellspacing"=>"3","width"=>"300"),1,2);
			$edit->setCol(0,0,array("valign"=>"middle","class"=>"defaultgray"),$l_customer["field_name"]);
			$edit->setCol(0,1,array("valign"=>"middle","class"=>"defaultfont"),htmlTextInput("name",26,$branch,'',''));

			$save = $we_button->create_button("save", "javascript:we_cmd('save_branch')");
		}else{
			$field_props=$this->View->getFieldProperties($field);

			$types=new we_htmlSelect(array("name"=>"field_type","class"=>"weSelect","style"=>"width:200"));
			$types->addOptions(count($this->View->settings->field_types),array_keys($this->View->settings->field_types),array_keys($this->View->settings->field_types));
			if(isset($field_props["type"])) $types->selectOption($field_props["type"]);

			$hiddens.=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"field_editor"));

			$edit=new we_htmlTable(array("border"=>"0","cellpadding"=>"3","cellspacing"=>"3","width"=>"300"),4,2);

			$edit->setCol(0,0,array("valign"=>"middle","class"=>"defaultgray"),$l_customer["branch"]);
			$edit->setCol(0,1,array("valign"=>"middle","class"=>"defaultfont"),$branch);

			$edit->setCol(1,0,array("valign"=>"middle","class"=>"defaultgray"),$l_customer["field_name"]);
			$edit->setCol(1,1,array("valign"=>"middle","class"=>"defaultfont"),htmlTextInput("name",26,(isset($field_props["name"]) ? $field_props["name"] : ""),"",'' ));

			$edit->setCol(2,0,array("valign"=>"middle","class"=>"defaultgray"),$l_customer["field_type"]);

			$edit->setCol(2,1,array("valign"=>"middle","class"=>"defaultfont"),$types->getHtmlCode());

			$edit->setCol(3,0,array("valign"=>"middle","class"=>"defaultgray"),$l_customer["field_default"]);
			$edit->setCol(3,1,array("valign"=>"middle","class"=>"defaultfont"),htmlTextInput("field_default",26,(isset($field_props["default"]) ? $field_props["default"] : ""),"",''));

			$save = $we_button->create_button("save", "javascript:we_cmd('save_field')");
		}

		$out=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
					we_htmlElement::jsElement($this->View->getJSAdmin()).
					we_htmlElement::jsElement("self.focus();").
					we_htmlElement::htmlForm(array("name"=>"we_form"),
						$hiddens.
						htmlDialogLayout($edit->getHtmlCode(),(
							$type=="branch" ?
									($l_customer["edit_branche"])
							:
									($mode=="edit" ? $l_customer["edit_field"] : $l_customer["add_field"])
							),
							$we_button->position_yes_no_cancel($save,null,$cancel)
						)

					)
		);

		return $this->getHTMLDocument($out);
	}


	function getHTMLCmd(){
		global $l_customer;
		$out="";

		if(isset($_REQUEST["pid"])){
			$pid=$_REQUEST["pid"];
		}
		else exit;

		if(isset($_REQUEST["sort"]))
			if($_REQUEST["sort"]==$l_customer["no_sort"]) $sort=0;
			else $sort=1;
		else{
			if($this->View->settings->Prefs["default_sort_view"]!=$l_customer["no_sort"]){
				$sort=1;
				$_REQUEST["sort"]=$this->View->settings->Prefs["default_sort_view"];
			}
			else $sort=0;
		}

		if(isset($_REQUEST["offset"])){
			$offset=$_REQUEST["offset"];
		}
		else $offset=0;

		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerTreeLoader.php");

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
							we_htmlElement::jsElement($rootjs.$this->Tree->getJSLoadTree(weCustomerTreeLoader::getItems($pid,$offset,$this->Tree->default_segment,($sort ? $_REQUEST["sort"] : ""))))
					)
		);

		return $this->getHTMLDocument($out);
	}

	function getHTMLSortEditor(){
		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerAdd.php");
		return weCustomerAdd::getHTMLSortEditor($this);
	}

	function getHTMLSearch(){
		global $l_customer;

		$we_button=new we_button();
		$colspan=4;

		$mode=isset($_REQUEST["mode"]) ? $_REQUEST["mode"] : 0;

		$hiddens=	we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"search")).
							we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"search")).
							we_htmlElement::htmlHidden(array("name"=>"search","value"=>"1")).
							we_htmlElement::htmlHidden(array("name"=>"mode","value"=>$mode));

		$search_but=$we_button->create_button("image:btn_function_search", "javascript:we_cmd('search')");

		$search=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"550","height"=>"50"),4,3);
		$search->setRow(0,array("valign"=>"top"));
		$search->setCol(0,0,array("class"=>"defaultfont","colspan"=>"3", "style" => "padding-bottom: 3px;"), $l_customer["search_for"]);

		$select=new we_htmlSelect(array("name"=>"search_result","style"=>"width:550px","onDblClick"=>"opener.".$this->topFrame.".we_cmd('edit_customer',document.we_form.search_result.options[document.we_form.search_result.selectedIndex].value)","size"=>20));

		if($mode){
			include_once(WE_CUSTOMER_MODULE_DIR."weCustomerAdd.php");
			weCustomerAdd::getHTMLSearch($this,$search,$select);
		}
		else{
			$search->setCol(1,0,array(),
										htmlTextInput("keyword",80,(isset($_REQUEST["keyword"]) ? $_REQUEST["keyword"] : ""),"",'onchange=""',"text","550px")
			);

			$sw=null;
			$sw=$we_button->create_button("image:btn_direction_right", "javascript:we_cmd('switchToAdvance')");

			$search->setCol(2,0,array(),getPixel(5,5));
			$search->setCol(3,0,array("align"=>"right","colspan"=>$colspan),
						$we_button->create_button_table(
								array(
									we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$l_customer["advanced_search"]),
									$sw,
									$search_but
								)
						)
			);
			$hiddens.=we_htmlElement::htmlHidden(array("name"=>"count","value"=>1));

			$max_res=$this->View->settings->getMaxSearchResults();
			$result=array();
			if(isset($_REQUEST["keyword"]) && isset($_REQUEST["search"]) && $_REQUEST["keyword"] && $_REQUEST["search"]) $result=$this->View->getSearchResults($_REQUEST["keyword"],$max_res);
			foreach($result as $id=>$text) $select->addOption($id,$text);

		}

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"2","cellspacing"=>"0","width"=>"550","height"=>"50"),3,1);
		$table->setCol(0,0,array(),$search->getHtmlCode());
		$table->setCol(1,0,array("class"=>"defaultfont"),$l_customer["search_result"]);
		$table->setCol(2,0,array(),$select->getHtmlCode());
		$calenderJS =
		$out=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onLoad"=>($mode ? "" : "document.we_form.keyword.focus();")),
					we_htmlElement::linkElement(array("rel"=>"stylesheet","type"=>"text/css","href"=>JS_DIR."jscalendar/skins/aqua/theme.css","title"=>"Aqua")).
					we_htmlElement::jsElement("",array("src"=>JS_DIR."utils/weDate.js")).
					//we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/lang/calendar.js")).
					we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar.js")).
					we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar-setup.js")).
					we_htmlElement::jsElement("",array("src"=>WEBEDITION_DIR."we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/calendar.js")).
					we_htmlElement::jsElement($this->View->getJSSearch()).
					we_htmlElement::jsElement("$this->jsOut_fieldTypesByName
	var date_format_dateonly = '" . $GLOBALS["l_global"]["date_format_dateonly_mysql"] . "';
	var fieldDate = new weDate(date_format_dateonly);

	function showDatePickerIcon(fieldNr) {
		document.getElementsByName('value_'+fieldNr)[0].style.display = 'none';
		document.getElementsByName('value_date_'+fieldNr)[0].style.display = '';
		document.getElementById('date_picker_'+fieldNr).style.display = '';
		document.getElementById('dpzell_'+fieldNr).style.display = '';
	}

	function hideDatePickerIcon(fieldNr) {
		document.getElementsByName('value_'+fieldNr)[0].style.display = '';
		document.getElementsByName('value_date_'+fieldNr)[0].style.display = 'none';
		document.getElementById('date_picker_'+fieldNr).style.display = 'none';
		document.getElementById('dpzell_'+fieldNr).style.display = 'none';
	}

	function isDateField(fieldNr){
		selBranch = document.getElementsByName('branch_'+fieldNr)[0].value;
		selField  = document.getElementsByName('field_'+fieldNr)[0].value;
		selField  = selField.substring(selBranch.length+1,selField.length);
		if(fieldTypesByName[selField] == 'date') showDatePickerIcon(fieldNr);
		else hideDatePickerIcon(fieldNr);
	}

	function lookForDateFields(){
		for(i = 0; i < document.getElementsByName('count')[0].value; i++){
			selBranch = document.getElementsByName('branch_'+i)[0].value;
			selField  = document.getElementsByName('field_'+i)[0].value;
			selField  = selField.substring(selBranch.length+1,selField.length);
			if(fieldTypesByName[selField] == 'date') {
				if(document.getElementsByName('value_'+i)[0].value != '') {
					document.getElementById('value_date_'+i).value = fieldDate.timestempToDate(document.getElementsByName('value_'+i)[0].value);

				}
				showDatePickerIcon(i);
			}
			Calendar.setup({inputField:'value_date_'+i,ifFormat:date_format_dateonly,button:'date_picker_'+i,align:'Tl',singleClick:true});
		}
	}

	function transferDateFields() {
		for(i = 0; i < document.getElementsByName('count')[0].value; i++){
			selBranch = document.getElementsByName('branch_'+i)[0].value;
			selField  = document.getElementsByName('field_'+i)[0].value;
			selField  = selField.substring(selBranch.length+1,selField.length);
			if(fieldTypesByName[selField] == 'date' && document.getElementById('value_date_'+i).value != '') {
				document.getElementsByName('value_'+i)[0].value = fieldDate.dateToTimestemp(document.getElementById('value_date_'+i).value);
			}
		}
	}
	"
					).
					we_htmlElement::htmlForm(array("name" => "we_form"),
						$hiddens.
						htmlDialogLayout(
							$table->getHtmlCode(),
							$l_customer["search"],
							$we_button->position_yes_no_cancel(null,$we_button->create_button("close","javascript:self.close();")),
							"100%",
							"30",
							"558"
						)
					).
					((isset($_REQUEST['mode']) && $_REQUEST['mode']) ? we_htmlElement::jsElement("
	setTimeout('lookForDateFields()', 1);
					"):"")

		);
		return $this->getHTMLDocument($out);

	}


	function getHTMLSettings() {
		global $l_customer;

		$closeflag = false;

		if (isset($_REQUEST["cmd"])) {
			if ($_REQUEST["cmd"] == "save_settings") {
				$this->View->processCommands();
				$closeflag = true;
			}
		}

		$default_sort_view_select=$this->getHTMLSortSelect();
		$default_sort_view_select->setAttributes(array("name"=>"default_sort_view","style","width:200px"));
		$default_sort_view_select->selectOption($this->View->settings->Prefs["default_sort_view"]);

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),4,3);

		$table->setCol(0,0,array("class"=>"defaultfont"),$l_customer["default_sort_view"].":&nbsp;");
		$table->setCol(0,1,array(),getPixel(5,30));
		$table->setCol(0,2,array("class"=>"defaultfont"),$default_sort_view_select->getHtmlCode());

		$table->setCol(1,0,array("class"=>"defaultfont"),$l_customer["start_year"].":&nbsp;");
		$table->setCol(1,1,array(),getPixel(5,30));
		$table->setCol(1,2,array("class"=>"defaultfont"),htmlTextInput("start_year",32,$this->View->settings->Prefs["start_year"],""));

		$table->setCol(2,0,array("class"=>"defaultfont"),$l_customer["treetext_format"].":&nbsp;");
		$table->setCol(2,1,array(),getPixel(5,30));
		$table->setCol(2,2,array("class"=>"defaultfont"),htmlTextInput("treetext_format",32,$this->View->settings->Prefs["treetext_format"],""));


		$default_order = new we_htmlSelect(array('name'=>'default_order','style'=>'width:250px;','class'=>'weSelect'));
		$default_order->addOption('',$l_customer['none']);
		foreach($this->View->settings->OrderTable as $ord){
			$default_order->addOption($ord,$ord);
		}
		$default_order->selectOption($this->View->settings->Prefs['default_order']);

		$table->setCol(3,0,array('class'=>'defaultfont'),$l_customer['default_order'].':&nbsp;');
		$table->setCol(3,1,array(),getPixel(5,30));
		$table->setCol(3,2,array('class'=>'defaultfont'),$default_order->getHtmlCode());

		$we_button = new we_button();
		$close = $we_button->create_button("close","javascript:self.close();");
		$save = $we_button->create_button("save", "javascript:we_cmd('save_settings')");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form"),
								htmlDialogLayout(
									we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"settings")).
									we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"")).
									$table->getHtmlCode().
									getPixel(5,10),
									$l_customer["settings"],
									$we_button->position_yes_no_cancel($save,$close)
								)
							)
							.($closeflag ? we_htmlElement::jsElement('top.close();') : "")
		);

		return $this->getHTMLDocument($body,we_htmlElement::jsElement($this->View->getJSSettings()));

	}


	function getDateInput2($name,$time="",$setHot=false,$format="",$onchange="",$class="defaultfont",$from_year=1970){
	global $l_global;

	// removed attribute setHot

	if(is_array($time)){
		$day = isset($time["day"]) ? $time["day"] : date("d");
		$month = isset($time["month"]) ? $time["month"] : date("m") ;
		$year = isset($time["year"]) ?  $time["year"] : date("Y") ;
		$hour = isset($time["hours"]) ?  $time["hours"] : date("H") ;
		$minute = isset($time["minutes"]) ?  $time["minutes"] : date("i") ;
	}
	else return "";

	$name = ereg_replace('^(.+)]$','\1%s]',$name);
	if(($format == "") || we_getDayPos($format)!=-1){
		$daySelect = '<select class="weSelect" name="'.sprintf($name,"_day").'" size="1" onChange="'.$onchange.'">';
		for($i=1;$i<=31;$i++){
			$daySelect .= "<option".($time ? (($day==$i) ? " selected" : "") : "").">".sprintf("%02d",$i);
		}
		$daySelect .= '</select>';
	}else{
		$daySelect = "";
	}

	if(($format == "") || we_getMonthPos($format)!=-1){
		$monthSelect = '<select class="weSelect" name="'.sprintf($name,"_month").'" size="1" onChange="'.$onchange.'">';
		for($i=1;$i<=12;$i++){
			$monthSelect .= "<option".($time ? (($month==$i) ? " selected" : "") : "").">".sprintf("%02d",$i);
		}
		$monthSelect .= '</select>';
	}else{
		$monthSelect = "";
	}

	if(($format == "") ||we_getYearPos($format)!=-1){
		$yearSelect = '<select class="weSelect" name="'.sprintf($name,"_year").'" size="1" onChange="'.$onchange.'">';
		for($i=$from_year;$i<=abs(date("Y")+8);$i++){
			$yearSelect .= "<option".($time ? (($year==$i) ? " selected" : "") : "").">".sprintf("%04d",$i);
		}
		$yearSelect .= '</select>';
	}else{
		$yearSelect = "";
	}

	if(($format == "") ||we_getHourPos($format)!=-1){
		$hourSelect = '<select class="weSelect" name="'.sprintf($name,"_hour").'" size="1" onChange="'.$onchange.'">';
		for($i=0;$i<=23;$i++){
			$hourSelect .= "<option".($time ? (($hour==$i) ? " selected" : "") : "").">".sprintf("%02d",$i);
		}
		$hourSelect .= '</select>';
	}else{
		$hourSelect = "";
	}

	if(($format == "") ||we_getMinutePos($format)!=-1){
		$minSelect = '<select class="weSelect" name="'.sprintf($name,"_minute").'" size="1" onChange="'.$onchange.'">';
		for($i=0;$i<=59;$i++){
			$minSelect .= "<option".($time ? (($minute==$i) ? " selected" : "") : "").">".sprintf("%02d",$i);
		}
		$minSelect .= '</select>';
	}else{
		$minSelect = "";
	}


	$retVal = '<table cellpadding=0 cellspacing=0 border=0>
';
	if($daySelect || $monthSelect || $yearSelect){
		$retVal .= '<tr>
	<td>
		'.($daySelect ? $daySelect."&nbsp;" : hidden(sprintf($name,"_day"),$day)).
		($monthSelect ? $monthSelect."&nbsp;" : hidden(sprintf($name,"_month"),$month)).
		($yearSelect ? $yearSelect."&nbsp;" : hidden(sprintf($name,"_year"),$year)).'
	</td>
</tr>
';
	}else{
		$retVal .= hidden(sprintf($name,"_day"),$day).
		hidden(sprintf($name,"_month"),$month).
		hidden(sprintf($name,"_year"),$year).'
';
	}
	if($hourSelect || $minSelect){
		$retVal .= '<tr>
	<td>
		'.($hourSelect ? $hourSelect."&nbsp;" : hidden(sprintf($name,"_hour"),$hour)).
		($minSelect ? $minSelect."&nbsp;" : hidden(sprintf($name,"_minute"),$minute)).'
	</td>
</tr>
';
	}else{
		$retVal .= hidden(sprintf($name,"_hour"),(isset($hour) ? $hour : 0)).
		hidden(sprintf($name,"_minute"),(isset($minute) ? $minute : 0)).'
';
	}
	$retVal .= '</table>
	';
	return $retVal;
	}

}
?>