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


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModuleFrames.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_export/"."weExportTree.inc.php");
include_once(WE_EXPORT_MODULE_DIR."weExportView.php");
include_once(WE_EXPORT_MODULE_DIR."weExportTreeMain.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');

class weExportFrames extends weModuleFrames {

	var $View;
	var $SelectionTree;
	var $editorBodyFrame;

	var $_space_size = 130;
	var $_text_size = 75;
	var $_width_size = 535;

	function weExportFrames() {
		$this->weModuleFrames(WE_EXPORT_MODULE_PATH."edit_export_frameset.php");
		$this->Tree=new weExportTreeMain();
		$this->SelectionTree=new weExportTree();
		$this->View = new weExportView(WE_EXPORT_MODULE_PATH."edit_export_frameset.php","top.content");
		$this->setupTree(EXPORT_TABLE,"top.content","top.content.resize.left.tree","top.content.cmd");
		$this->module="export";

		$this->editorBodyFrame = $this->topFrame . '.resize.right.editor.edbody';
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
			case "load":
			case "cmd": print $this->getHTMLCmd();break;
			case "treeheader": print $this->getHTMLTreeHeader();break;
			case "treefooter": print $this->getHTMLTreeFooter();break;

			default:
				error_log(__FILE__ . " unknown reference: $what");
		}
	}

	function getHTMLFrameset(){
		$this->View->export->clearSessionVars();
		return weModuleFrames::getHTMLFrameset();
	}

	function getJSCmdCode(){
		return 	$this->View->getJSTop() .
				we_htmlElement::jsElement(	$this->Tree->getJSMakeNewEntry() .
											$this->Tree->getJSUpdateItem()
				);
	}


	function getHTMLEditorHeader() {
		global $l_export;
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");
		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#FFFFFF","background"=>"/webEdition/images/backgrounds/bgGrayLineTop.gif"),""));
		}

		$we_tabs = new we_tabs();
		$we_tabs->addTab(new we_tab("#",$l_export['property'],'(('.$this->topFrame.'.activ_tab==1) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('1');", array("id"=>"tab_1")));
		if($this->View->export->IsFolder==0){
			$we_tabs->addTab(new we_tab("#",$l_export['options'],'(('.$this->topFrame.'.activ_tab==2) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('2');", array("id"=>"tab_2")));
			$we_tabs->addTab(new we_tab("#",$l_export['log'],'(('.$this->topFrame.'.activ_tab==3) ? TAB_ACTIVE : TAB_NORMAL)',"setTab('3');", array("id"=>"tab_3")));
		}

		$we_tabs->onResize();
		$tabsHead = $we_tabs->getHeader();
		$tabsBody = $we_tabs->getJS();

		$js=we_htmlElement::jsElement('
				function setTab(tab) {
					parent.edbody.toggle("tab"+'.$this->topFrame.'.activ_tab);
					parent.edbody.toggle("tab"+tab);
					'.$this->topFrame.'.activ_tab=tab;
				}

				'.($this->View->export->ID ? '' : $this->topFrame.'.activ_tab=1;').'

				' . ($this->View->export->IsFolder==1 ? $this->topFrame . '.activ_tab=1;' : '') . '

				top.content.hloaded = 1;
		');

		$tabsHead .=$js;

		$table=new we_htmlTable(array("width"=>"3000","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),3,1);

		$table->setCol(0,0,array(),getPixel(1,3));

		$table->setCol(1,0,array("valign"=>"top","class"=>"small"),
							getPixel(15,2).
							we_htmlElement::htmlB(
								$l_export['export'] . ':&nbsp;'.$this->View->export->Text.
								we_htmlElement::htmlImg(array("align"=>"absmiddle","height"=>"19","width"=>"1600","src"=>IMAGE_DIR."pixel.gif"))
							)
		);
		$text = !empty($this->View->export->Path) ? $this->View->export->Path : "/".$this->View->export->Text;
		$extraJS = 'document.getElementById("tab_"+top.content.activ_tab).className="tabActive";';
		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"),
		//	'<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;" id="headrow">&nbsp;'.we_htmlElement::htmlB($l_export['export'] . ':&nbsp;'.$this->View->export->Text).'</div>' . getPixel(100,3) .
			'<div id="main" >' . getPixel(100,3).'<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",we_htmlElement::htmlB($l_export['export'])).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$text).'</b></span></nobr></div>'.getPixel(100,3).
			$we_tabs->getHTML() .
			'</div>' . we_htmlElement::jsElement($extraJS)
//			$js.
//			$table->getHtmlCode() .
//			$tabsBody
		);

		return $this->getHTMLDocument($body,$tabsHead);
	}

	function getHTMLEditorBody() {

		$hiddens=array('cmd'=>'edit_export','pnt'=>'edbody');

		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$hiddens["cmd"]="home";
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->View->getJSProperty();
			$GLOBALS["we_body_insert"] = we_htmlElement::htmlForm(array("name"=>"we_form"),
					$this->View->getCommonHiddens($hiddens).we_htmlelement::htmlHidden(array("name"=>"home","value"=>"0"))
			);
			$GLOBALS["mod"] = "export";
			ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
		}
		$yuiSuggest =& weSuggest::getInstance();
		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody","onLoad"=>"loaded=1;start();", "onunload"=>"doUnload()"),
			$yuiSuggest->getYuiJsFiles().we_htmlElement::htmlForm(array("name"=>"we_form"),$this->View->getCommonHiddens($hiddens).$this->getHTMLProperties()).$yuiSuggest->getYuiCss().$yuiSuggest->getYuiJs()
		);
		return $this->getHTMLDocument($body,$this->View->getJSProperty());
	}

	function getHTMLEditorFooter() {

		global $l_export;

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#EFF0EF"),""));
		}

		$we_button = new we_button();

		$table1=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"3000"),1,1);
		$table1->setCol(0,0,array("nowrap"=>null,"valign"=>"top"),getPixel(1600,10));

		$table2=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"210"),1,5);
		$table2->setRow(0,array("valign"=>"middle"));
		$table2->setCol(0,0,array("nowrap"=>null),
					$we_button->create_button("save", "javascript:we_save()")
		);

		$table2->setCol(0,1,array("nowrap"=>null),getPixel(5,5));

		if($this->View->export->IsFolder==0) {
			$table2->setCol(0,2,array("nowrap"=>null),
					$we_button->create_button("export", "javascript:top.content.we_cmd('start_export')",true,100,22,'','',!we_hasPerm("MAKE_EXPORT"))
			);
		}

		$table2->setCol(0,3,array("nowrap"=>null),getPixel(290,5));

		$js = we_htmlElement::jsElement('
				function we_save() {
					top.content.we_cmd("save_export");
					
				}
				function doProgress(progress) {
					var elem = document.getElementById("progress");
					if(elem.style.display == "none") elem.style.display = "";
					setProgress(progress);
				}

				function hideProgress() {
					var elem = document.getElementById("progress");
					if(elem.style.display != "none") elem.style.display = "none";
				}

		');

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_progressBar.inc.php");

		$text = $l_export['working'];
		$progress = 0;

		if (isset($_REQUEST["current_description"]) && $_REQUEST["current_description"]) {
			$text = $_REQUEST["current_description"];
		}

		if (isset($_REQUEST["percent"]) && $_REQUEST["percent"]) {
			$progress = $_REQUEST["percent"];
		}

		$progressbar = new we_progressBar($progress);
		$progressbar->setStudLen(200);
		$progressbar->addText($text, 0, "current_description");

		$table2->setCol(0,4,array("id"=>"progress","style"=>"display: none","nowrap"=>null),$progressbar->getHtml());

		return $this->getHTMLDocument(
					we_htmlElement::htmlHead(
						WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . (isset($progressbar) ? $progressbar->getJSCode() . "\n" : "") . $js
					).
					we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"15","marginheight"=>"0","leftmargin"=>"15","topmargin"=>"0"),
							we_htmlElement::htmlForm(array(),$table1->getHtmlCode().$table2->getHtmlCode())
					)
		);

	}


	function getHTMLProperties($preselect=""){
		global $l_export;

		$this->SelectionTree->init($this->frameset,$this->editorBodyFrame,$this->editorBodyFrame,$this->cmdFrame);

		include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
		$out="";
		$tabNr = isset($_REQUEST["tabnr"]) ? $_REQUEST["tabnr"] : 1;

		$out .= we_htmlElement::jsElement('

			var log_counter=0;
			function toggle(id){
				var elem = document.getElementById(id);
				if(elem.style.display == "none") elem.style.display = "";
				else elem.style.display = "none";
			}


			function clearLog(){
				'.$this->editorBodyFrame.'.document.getElementById("log").innerHTML = "";
			}

			function addLog(text){
				'.$this->editorBodyFrame.'.document.getElementById("log").innerHTML+= text;
				'.$this->editorBodyFrame.'.document.getElementById("log").scrollTop = 50000;
			}


		');

		$out .=	we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>($tabNr==1 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab1(),30,'',-1,'','',false,$preselect)).
				we_htmlElement::htmlDiv(array('id' => 'tab2','style'=>($tabNr==2 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab2(),30,'',-1,'','',false,$preselect)).
				we_htmlElement::htmlDiv(array('id' => 'tab3','style'=>($tabNr==3 ? '' : 'display: none')), we_multiIconBox::getHTML('',"100%",$this->getHTMLTab3(),30,'',-1,'','',false,$preselect));

		return $out;
	}

	function getHTMLTab1(){
		global $l_export;
		$parts = array();
		array_push($parts,array(
				"headline"=>$GLOBALS["l_export"]["property"],
				"html"=>htmlFormElementTable(htmlTextInput("Text",'',$this->View->export->Text,'','style="width: '.$this->_width_size.'px;" id="yuiAcInputPathName" onchange="top.content.setHot();" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()" onChange="'.$this->topFrame.'.hot=1;"'),$l_export['name']).'<br>'.
						$this->getHTMLDirChooser(),
				"space"=>$this->_space_size)
		);

		if($this->View->export->IsFolder==1) return $parts;

		array_push($parts,array(
							"headline"=>$l_export["export_to"],
							"html"=>htmlFormElementTable(htmlTextInput("Filename",$this->_text_size,$this->View->export->Filename,'','style="width: '.$this->_width_size.'px;" onChange="'.$this->topFrame.'.hot=1;"'),$l_export["filename"]),
							"space"=>$this->_space_size,
							"noline"=> 1)
		);

		$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),3,1);
		$table->setColContent(0,0,htmlSelect('ExportTo',((!(defined("ISP_VERSION") && ISP_VERSION)) ? array('local'=>$l_export['export_to_local'],"server"=>$l_export["export_to_server"]) : array('local'=>$l_export['export_to_local'])),1,$this->View->export->ExportTo,false,'onChange="toggle(\'save_to\');'.$this->topFrame.'.hot=1;"','value',$this->_width_size));
		$table->setColContent(1,0,getPixel(10,10));
		if(!(defined("ISP_VERSION") && ISP_VERSION)){
			$table->setCol(2,0,array("id"=>"save_to","style"=>($this->View->export->ExportTo=='server' ? 'display: ""' : 'display: none')),htmlFormElementTable($this->formFileChooser(($this->_width_size - 120),"ServerPath",$this->View->export->ServerPath,"","folder"),$l_export["save_to"]));
		}

		array_push($parts,array(
					"headline" => "",
					"html" =>$table->getHtmlCode(),
					"space" => $this->_space_size)
		);

		$js = we_htmlElement::jsElement('

			function closeAllSelection(){
				var elem = document.getElementById("auto");
				elem.style.display = "none";
				elem = document.getElementById("manual");
				elem.style.display = "none";
			}
			function closeAllType(){
				var elem = document.getElementById("doctype");
				elem.style.display = "none";
				'.(defined("OBJECT_TABLE") ?'
				elem = document.getElementById("classname");
				elem.style.display = "none";'
				: '').'
			}

		');

		$docTypes = array();
		$q=getDoctypeQuery($this->db);
		$this->db->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
		while($this->db->next_record()){
			$docTypes[$this->db->f("ID")] = $this->db->f("DocType");
		}

		if(defined("OBJECT_TABLE")){
			$classNames = array();
			$this->db->query("SELECT ID,Text FROM ".OBJECT_TABLE);
			while($this->db->next_record()){
				$classNames[$this->db->f("ID")] = $this->db->f("Text");
			}
		}

		$FolderPath = $this->View->export->Folder ? f("SELECT Path FROM ".FILE_TABLE." WHERE ID='".$this->View->export->Folder."'","Path",$this->db) : "/";

		$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),5,1);

		$seltype = array('doctype'=>$l_export["doctypename"]);
		if(defined("OBJECT_TABLE")) $seltype['classname']=$l_export['classname'];

		$table->setColContent(0,0,htmlSelect('SelectionType',$seltype,1,$this->View->export->SelectionType,false,'onChange="closeAllType();toggle(this.value);'.$this->topFrame.'.hot=1;"','value',$this->_width_size));
		$table->setColContent(1,0,getPixel(5,5));
		$table->setCol(2,0,array("id"=>"doctype","style"=>($this->View->export->SelectionType=='doctype' ? 'display: ""' : 'display: none')),
				htmlSelect('DocType',$docTypes,1,$this->View->export->DocType,false,'onChange="'.$this->topFrame.'.hot=1;"','value',$this->_width_size).
				htmlFormElementTable($this->formWeChooser(FILE_TABLE,($this->_width_size - 120),0,'Folder',$this->View->export->Folder,'FolderPath',$FolderPath),$l_export['dir'])
		);
		if(defined("OBJECT_TABLE")){
			$table->setCol(3,0,array("id"=>"classname","style"=>($this->View->export->SelectionType=="classname" ? "display: ''" : "display: none")),
				htmlSelect('ClassName',$classNames,1,$this->View->export->ClassName,false,'onChange="'.$this->topFrame.'.hot=1;"','value',$this->_width_size)
			);
		}

		$table->setColContent(4,0,$this->getHTMLCategory());

		$selectionTypeHtml = $table->getHTMLCode();

		$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),4,1);
		$table->setColContent(0,0,htmlSelect('Selection',array('auto'=>$l_export["auto_selection"],"manual"=>$l_export["manual_selection"]),1,$this->View->export->Selection,false,'onChange="closeAllSelection();toggle(this.value);closeAllType();toggle(\'doctype\');'.$this->topFrame.'.hot=1;"','value',$this->_width_size));
		$table->setColContent(1,0,getPixel(5,5));
		$table->setCol(2,0,array("id"=>"auto","style"=>($this->View->export->Selection=='auto' ? 'display: ""' : 'display: none')),
				htmlAlertAttentionBox($l_export["txt_auto_selection"],2,$this->_width_size).
				$selectionTypeHtml
		);

		$table->setCol(3,0,array("id"=>"manual","style"=>($this->View->export->Selection=="manual" ? "display: ''" : "display: none")),
			htmlAlertAttentionBox($l_export["txt_manual_selection"]." ".$l_export["select_export"],2,$this->_width_size).
			$this->SelectionTree->getHTMLMultiExplorer($this->_width_size,200)
		);

		array_push($parts,array(
					"headline" => $l_export['selection'],
					"html" =>$js.$table->getHtmlCode(),
					"space" => $this->_space_size)
		);

		return $parts;
	}

	function getHTMLTab2(){
		global $l_export;
		$parts = array();
		$formattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 5, 1);
		$formattable->setCol(0,0,null,we_forms::checkboxWithHidden($this->View->export->HandleDefTemplates,"HandleDefTemplates",$l_export["handle_def_templates"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		$formattable->setCol(1,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleDocIncludes ? true : false),"HandleDocIncludes",$l_export["handle_document_includes"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		if(defined("OBJECT_TABLE")) $formattable->setCol(2,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleObjIncludes ? true : false),"HandleObjIncludes",$l_export["handle_object_includes"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		$formattable->setCol(3,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleDocLinked ? true : false),"HandleDocLinked",$l_export["handle_document_linked"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		$formattable->setCol(4,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleThumbnails ? true : false),"HandleThumbnails",$l_export["handle_thumbnails"],false,'defaultfont',$this->topFrame.'.hot=1;'));

		array_push($parts,array(
						"headline"=>$l_export["handle_document_options"].we_htmlElement::htmlBr().$l_export["handle_template_options"],
						"html"=>htmlAlertAttentionBox($l_export['txt_document_options'],2,$this->_width_size,true,70) . $formattable->getHtmlCode(),
						"space"=>$this->_space_size)
		);

		if(defined("OBJECT_TABLE")) {
			$formattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 3, 1);
			$formattable->setCol(0,0,array("colspan"=>"2"),we_forms::checkboxWithHidden(($this->View->export->HandleDefClasses ? true : false),"HandleDefClasses",$l_export["handle_def_classes"],false,'defaultfont',$this->topFrame.'.hot=1;'));
			$formattable->setCol(1,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleObjEmbeds ? true : false),"HandleObjEmbeds",$l_export["handle_object_embeds"],false,'defaultfont',$this->topFrame.'.hot=1;'));
			array_push($parts,array(
							"headline"=>$l_export["handle_object_options"].we_htmlElement::htmlBr().$l_export["handle_classes_options"],
							"html"=>htmlAlertAttentionBox($l_export['txt_object_options'],2,$this->_width_size,true,70) . $formattable->getHtmlCode(),
							"space"=>$this->_space_size)
			);
		}

		$formattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 3, 1);
		$formattable->setCol(0,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleDoctypes ? true : false),"HandleDoctypes",$l_export["handle_doctypes"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		$formattable->setCol(1,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleCategorys ? true : false),"HandleCategorys",$l_export["handle_categorys"],false,'defaultfont',$this->topFrame.'.hot=1;'));
		$formattable->setCol(2,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleNavigation ? true : false),"HandleNavigation",$l_export["handle_navigation"],false,'defaultfont',$this->topFrame.'.hot=1;', false, $l_export["navigation_hint"],1,509));

		array_push($parts,array(
						"headline"=>$l_export["handle_doctype_options"],
						"html"=>$formattable->getHtmlCode(),
						"space"=>$this->_space_size)
		);

		array_push($parts,array(
							"headline"=>$l_export["export_depth"],
							"html"=>htmlAlertAttentionBox($l_export['txt_exportdeep_options'],2,$this->_width_size) .'<br>'. we_htmlElement::htmlLabel(null,$l_export["to_level"]).getPixel(5,5).htmlTextInput("ExportDepth",10,$this->View->export->ExportDepth,"","onBlur=\"var r=parseInt(this.value);if(isNaN(r)) this.value=".$this->View->export->ExportDepth."; else{ this.value=r; ".$this->topFrame.".hot=1;}\"","text",50),
							"space"=>$this->_space_size)
		);

		$formattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 1, 1);
		$formattable->setCol(0,0,null,we_forms::checkboxWithHidden(($this->View->export->HandleOwners ? true : false),"HandleOwners",$l_export["handle_owners"],false,'defaultfont',$this->topFrame.'.hot=1;'));

		array_push($parts,array(
						"headline"=>$l_export["handle_owners_option"],
						"html"=>htmlAlertAttentionBox($l_export['txt_owners'],2,$this->_width_size) . $formattable->getHtmlCode(),
						"space"=>$this->_space_size)
		);


		return $parts;
	}

	function getHTMLTab3(){
		global $l_export;
		$parts = array();

		array_push($parts,array(
				"headline"=>'',
				"html"=>we_htmlElement::htmlDiv(array('class'=>'blockwrapper','style'=>'width: 650px; height: 400px; border:1px #dce6f2 solid;','id'=>'log'),''),
				"space"=>0)
		);
		return $parts;
	}

	function getHTMLDirChooser(){
		global $l_we_class;

		$we_button = new we_button();
		$path = id_to_path($this->View->export->ParentID,EXPORT_TABLE);
		$button = $we_button->create_button('select', "javascript:top.content.setHot();we_cmd('openExportDirselector',document.we_form.elements['ParentID'].value,'document.we_form.elements[\'ParentID\'].value','document.we_form.elements[\'ParentPath\'].value','top.hot=1;')");
		
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("PathGroup");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput("ParentPath",$path,array("onChange"=>$this->topFrame.'.hot=1;'));
		$yuiSuggest->setLabel($GLOBALS["l_export"]["group"]);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult("ParentID",$this->View->export->ParentID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(EXPORT_TABLE);
		$yuiSuggest->setWidth($this->_width_size - 120);
		$yuiSuggest->setSelectButton($button);
		
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
		global $l_export;
		$out = "";
		@set_time_limit(0);
		if (isset($_REQUEST["cmd"])){
			switch($_REQUEST["cmd"]){
				case "load":
					if (isset($_REQUEST["pid"])){
						$out=we_htmlElement::jsElement("self.location='/webEdition/we/include/we_export/exportLoadTree.php?we_cmd[1]=".$_REQUEST["tab"]."&we_cmd[2]=".$_REQUEST["pid"]."&we_cmd[3]=".(isset($_REQUEST["openFolders"]) ? $_REQUEST["openFolders"] : "")."&we_cmd[4]=".$this->editorBodyFrame."'");
					}
				break;
				case "mainload":
					if (isset($_REQUEST["pid"])){

						include_once(WE_EXPORT_MODULE_DIR.'weExportTreeLoader.php');
						$treeItems=weExportTreeLoader::getItems($_REQUEST["pid"]);

						$js='
							if(!'.$this->Tree->topFrame.'.treeData) {
								' . we_message_reporting::getShowMessageCall("A fatal Error ocured", WE_MESSAGE_ERROR) . '
							}';

						if(!$_REQUEST["pid"])
								$js.='
								'.$this->Tree->topFrame.'.treeData.clear();

								'.$this->Tree->topFrame.'.treeData.add(new '.$this->Tree->topFrame.'.rootEntry(\''.$_REQUEST["pid"].'\',\'root\',\'root\'));
						';

						$js.=$this->Tree->getJSLoadTree($treeItems);
						$out=we_htmlElement::jsElement($js);

					}
				break;
				case "do_export":
					if(!we_hasPerm("MAKE_EXPORT")) {
						$out = we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall( $GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}


					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");

					$_progress_update = '';
					$exports=0;
					if(!isset($_SESSION["ExImRefTable"])){

						if($this->View->export->Selection == 'manual') {
							$finalDocs = makeArrayFromCSV($this->View->export->selDocs);
							$finalTempl = makeArrayFromCSV($this->View->export->selTempl);
							$finalObjs = makeArrayFromCSV($this->View->export->selObjs);
							$finalClasses = makeArrayFromCSV($this->View->export->selClasses);
						} else {
							$finalDocs = array();
							$finalTempl = array();
							$finalObjs = array();
							$finalClasses = array();
						}
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExport.class.php");
						$xmlExIm = new weXMLExport();
						$xmlExIm->getSelectedItems($this->View->export->Selection,
													"wxml",
													"",
													$this->View->export->SelectionType,
													$this->View->export->DocType,
													$this->View->export->ClassName,
													$this->View->export->Categorys,
													$this->View->export->Folder,
													$finalDocs,$finalTempl,$finalObjs,$finalClasses);



						$xmlExIm->setOptions(array(
							"handle_def_templates"=>$this->View->export->HandleDefTemplates,
							"handle_doctypes"=>$this->View->export->HandleDoctypes,
							"handle_categorys"=>$this->View->export->HandleCategorys,
							"handle_def_classes"=>$this->View->export->HandleDefClasses,
							"handle_document_includes"=>$this->View->export->HandleDocIncludes,
							"handle_document_linked"=>$this->View->export->HandleDocLinked,
							"handle_object_includes"=>$this->View->export->HandleObjIncludes,
							"handle_object_embeds"=>$this->View->export->HandleObjEmbeds,
							"handle_class_defs"=>$this->View->export->HandleDefClasses,
							"handle_owners"=>$this->View->export->HandleOwners,
							"export_depth"=>$this->View->export->ExportDepth,
							"handle_documents"=>1,
							"handle_templates"=>1,
							"handle_classes"=>1,
							"handle_objects"=>1,
							"handle_navigation"=>$this->View->export->HandleNavigation,
							"handle_thumbnails"=>$this->View->export->HandleThumbnails
						));

						$xmlExIm->RefTable->reset();
						$xmlExIm->savePerserves();

						$all = $xmlExIm->RefTable->getLastCount();
						$hiddens = we_htmlElement::htmlHidden(array("name"=>"pnt", "value"=> "cmd")).
									we_htmlElement::htmlHidden(array("name"=>"all", "value"=> $all)).
									we_htmlElement::htmlHidden(array("name"=>"cmd", "value"=> "do_export"));

						$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead('').
								we_htmlElement::htmlBody(array("bgcolor" => "#ffffff", "marginwidth" => "5", "marginheight" => "5", "leftmargin" => "5", "topmargin" => "5", "onLoad" => "document.we_form.submit()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","action"=>$this->frameset),$hiddens)
								)
						);


					} else if($_SESSION['ExImPrepare']) {

						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weExportPreparer.class.php");
						$xmlExIm = new weExportPreparer();

						$xmlExIm->loadPerserves();
						$xmlExIm->prepareExport();
						$all = count($xmlExIm->RefTable->Storage)-1;
						$xmlExIm->prepare = ($all>$xmlExIm->RefTable->current) && ($xmlExIm->RefTable->current!=0);



						$_progress_update = '';
						if(!$xmlExIm->prepare) {
							$_progress_update =
								we_htmlElement::jsElement('
										if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(10,10)) . we_htmlElement::htmlB($l_export['start_export'] . ' - ' . date("d.m.Y H:i:s")) . '<br><br>");
										if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(20,5)) . we_htmlElement::htmlB($l_export['prepare']) . '<br>");
										if ('.$this->topFrame.'.resize.right.editor.edfooter.doProgress) '.$this->topFrame.'.resize.right.editor.edfooter.doProgress(0);
										if('.$this->topFrame.'.resize.right.editor.edfooter.setProgressText) '.$this->topFrame.'.resize.right.editor.edfooter.setProgressText("current_description","'.$l_export['working'].'");
										if ('.$this->editorBodyFrame.'.addLog){
										'.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(20,5)) . we_htmlElement::htmlB($l_export['export']) . '<br>");
									}
								');
							weFile::save($this->View->export->ExportFilename,$xmlExIm->getHeader(),"wb");
							if($this->View->export->HandleOwners) {
								include_once($_SERVER["DOCUMENT_ROOT"]. "/webEdition/we/include/we_exim/weXMLExport.class.php");
								weFile::save($this->View->export->ExportFilename,weXMLExport::exportInfoMap($xmlExIm->RefTable->Users),"ab");
							}

							$xmlExIm->RefTable->reset();
						} else {

							$percent=0;
							if($all!=0) $percent = (int)(($xmlExIm->RefTable->current / $all) * 100);

							if ($percent < 0) {
								$percent = 0;
							} else if ($percent > 100) {
								$percent = 100;
							}
							$_progress_update =
							we_htmlElement::jsElement('
									if ('.$this->topFrame.'.resize.right.editor.edfooter.doProgress) '.$this->topFrame.'.resize.right.editor.edfooter.doProgress("'.$percent.'");
									if('.$this->topFrame.'.resize.right.editor.edfooter.setProgressText) '.$this->topFrame.'.resize.right.editor.edfooter.setProgressText("current_description","'.$l_export['prepare'].'");
							');
						}

						$xmlExIm->savePerserves();

						$hiddens = we_htmlElement::htmlHidden(array("name"=>"pnt", "value"=> "cmd")).
									we_htmlElement::htmlHidden(array("name"=>"all", "value"=> $all)).
									we_htmlElement::htmlHidden(array("name"=>"cmd", "value"=> "do_export"));

						$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead('').
								we_htmlElement::htmlBody(array("bgcolor" => "#ffffff", "marginwidth" => "5", "marginheight" => "5", "leftmargin" => "5", "topmargin" => "5", "onLoad" => "document.we_form.submit()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","action"=>$this->frameset),$hiddens) . $_progress_update
								)
						);

					} else {

						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExport.class.php");
						$xmlExIm = new weXMLExport();
						$xmlExIm->loadPerserves();
						$exports=0;

						$all = count($xmlExIm->RefTable->Storage);

						$ref=$xmlExIm->RefTable->getNext();

						if(!empty($ref->ID) && !empty($ref->ContentType)){

							$table = $ref->Table;

							$exists = f('SELECT ID FROM ' . $table . ' WHERE ID=\'' . $ref->ID . '\'','ID',$this->db) || ($ref->ContentType == "weBinary");

							if($exists){
								$xmlExIm->export($ref->ID,$ref->ContentType,$this->View->export->ExportFilename);
								$exports = $xmlExIm->RefTable->current;
								include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");

								if($ref->ContentType == "weBinary") {
									$_progress_update .= "\n".
										we_htmlElement::jsElement('
											if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(50,5)) . we_htmlElement::htmlB($l_export['weBinary']) . '&nbsp;&nbsp;' . $ref->ID . '<br>");
										')."\n";
								} else {
									if($ref->ContentType == 'doctype') {
										$_path = f('SELECT DocType FROM ' . $table . ' WHERE ID = ' . $ref->ID,'DocType',$this->db);
									} else if($ref->ContentType == 'weNavigationRule'){
										$_path = f('SELECT NavigationName FROM ' . $table . ' WHERE ID = ' . $ref->ID,'NavigationName',$this->db);
									} else if($ref->ContentType == 'weThumbnail'){
										$_path = f('SELECT Name FROM ' . $table . ' WHERE ID = ' . $ref->ID,'Name',$this->db);
									} else {
										$_path = id_to_path($ref->ID,$table);
									}

									$_progress_text = we_htmlElement::htmlB(isset($l_contentTypes[$ref->ContentType]) ? $l_contentTypes[$ref->ContentType] : (isset($l_export[$ref->ContentType]) ? $l_export[$ref->ContentType] : '')) . '&nbsp;&nbsp;' . $_path;

									if(strlen($_path)>75){
										$_progress_text = addslashes(substr($_progress_text,0,65) . '<acronym title="' . $_path . '">...</acronym>' . substr($_progress_text,-10));
									}

									$_progress_update .= "\n".
										we_htmlElement::jsElement('
											if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(50,5)) . $_progress_text . '<br>");
										');
								}
							}
						}

						$percent=0;
						if($all!=0) $percent = (int)(($exports / $all) * 100);

						if ($percent < 0) {
							$percent = 0;
						} else if ($percent > 100) {
							$percent = 100;
						}
						$_progress_update .= "\n".
								we_htmlElement::jsElement('
									if ('.$this->topFrame.'.resize.right.editor.edfooter.doProgress) '.$this->topFrame.'.resize.right.editor.edfooter.doProgress(' . $percent . ');
						')."\n";
						$_SESSION["ExImCurrentRef"]=$xmlExIm->RefTable->current;

						$hiddens = we_htmlElement::htmlHidden(array("name"=>"pnt", "value"=> "cmd")).
									we_htmlElement::htmlHidden(array("name"=>"all", "value"=> $all)).
									we_htmlElement::htmlHidden(array("name"=>"cmd", "value"=> "do_export"));

						$head = WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n";

						if ($all > $exports) {
							$out=we_htmlElement::htmlHtml(
									we_htmlElement::htmlHead($head).
									we_htmlElement::htmlBody(array("bgcolor" => "#ffffff", "marginwidth" => "5", "marginheight" => "5", "leftmargin" => "5", "topmargin" => "5", "onLoad" => "document.we_form.submit()"),
										we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","action"=>$this->frameset),$hiddens) . $_progress_update
									)
							);
						} else {
							if(is_writable($this->View->export->ExportFilename)){
								weFile::save($this->View->export->ExportFilename,$xmlExIm->getFooter(),"ab");
							}
							$_progress_update .= "\n".
								we_htmlElement::jsElement('
									if ('.$this->topFrame.'.resize.right.editor.edfooter.doProgress) '.$this->topFrame.'.resize.right.editor.edfooter.doProgress(100);
									if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("<br>' . addslashes(getPixel(10,10)) . we_htmlElement::htmlB($l_export['end_export'] . ' - ' . date("d.m.Y H:i:s")) . '<br><br>");
							')."\n".
							($this->View->export->ExportTo == 'local' ?
									we_htmlElement::jsElement($this->editorBodyFrame.'.addLog(\'' .
										we_htmlElement::htmlSpan(array("class" => "defaultfont"),
												addslashes(getPixel(10,1)) .$l_export["backup_finished"] . "<br>" .
												addslashes(getPixel(10,1)) .$l_export["download_starting2"] . "<br><br>" .
												addslashes(getPixel(10,1)) .$l_export["download_starting3"] . "<br>" .
												addslashes(getPixel(10,1)) .we_htmlElement::htmlB(we_htmlElement::htmlA(array("href" => $this->frameset . "?pnt=cmd&cmd=upload&exportfile=" . urlencode($this->View->export->ExportFilename)), $l_export["download"])) ."<br><br>"
										).
									'\');')
									:
								''
							);

							$out=we_htmlElement::htmlHtml(
									we_htmlElement::htmlHead($head.$_progress_update).
									we_htmlElement::htmlBody(
										array(
											"bgcolor" => "#ffffff",
											"marginwidth" => "5",
											"marginheight" => "5",
											"leftmargin" => "5",
											"topmargin" => "5",
											"onLoad" => ($this->View->export->ExportTo == 'local'
															? ($this->cmdFrame . ".location='" . $this->frameset . "?pnt=cmd&cmd=upload&exportfile=" . urlencode($this->View->export->ExportFilename) . "';")
															: ( we_message_reporting::getShowMessageCall( $l_export["server_finished"], WE_MESSAGE_NOTICE) )).$this->topFrame.".resize.right.editor.edfooter.hideProgress();")
														),
										null
							);
							$xmlExIm->unsetPerserves();

						}
				}
				break;
				case 'upload':
					@set_time_limit(0);
					$prot = getServerProtocol();
					$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://".$_SERVER["HTTP_HOST"] : "";
					if (isset($_GET["exportfile"])) {
						$_filename = basename(urldecode($_GET["exportfile"]));

						if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp/".$_filename)								// Does file exist?
							&& !eregi("p?html?", $_filename) && !eregi("inc", $_filename) && !eregi("php3?", $_filename)) {		// Security check
							$_size = filesize($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp/".$_filename);

							if (we_isHttps()) {																		// Additional headers to make downloads work using IE in HTTPS mode.
								header("Pragma: ");
								header("Cache-Control: ");
								header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
								header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
								header("Cache-Control: no-store, no-cache, must-revalidate");									// HTTP 1.1
								header("Cache-Control: post-check=0, pre-check=0", false);
							} else {
								header("Cache-control: private");
							}

							header("Content-Type: application/force-download");
							header("Content-Disposition: attachment; filename=\"" . trim(htmlentities($_filename)) . "\"");
							header("Content-Description: " . trim(htmlentities($_filename)));
							header("Content-Length: " . $_size);

							$_filehandler = readfile($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp/".$_filename);
							exit;
						} else {

							header("Location: " . $preurl . $this->frameset . "?pnt=cmd&cmd=upload_failed");
							exit;
						}
					} else {
						header("Location: " . $preurl . $this->frameset . "?pnt=cmd&cmd=error=upload_failed");
						exit;
					}

				break;
				case 'upload_failed':
					$out = we_htmlElement::jsElement(
						we_message_reporting::getShowMessageCall($l_export["error_download_failed"], WE_MESSAGE_ERROR)
					);
				break;
			}
		}
		return $out;
	}

	/* creates the FileChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formFileChooser($width = "", $IDName = "ParentID", $IDValue = "/", $cmd = "", $filter = "") {

	  	$js=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
	  			we_htmlElement::jsElement('
				function formFileChooser() {
					var args = "";
					var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if (i < (arguments.length - 1)){ url += "&"; }}
					switch (arguments[0]) {
						case "browse_server":
							new jsWindow(url,"server_selector",-1,-1,660,330,true,false,true);
						break;
					}
				}
		');

		$we_button = new we_button();
	  	$button =  $we_button->create_button("select","javascript:top.content.setHot();formFileChooser('browse_server','document.we_form.elements[\\'$IDName\\'].value','$filter',document.we_form.elements['$IDName'].value);");
		
		return $js.htmlFormElementTable(htmlTextInput($IDName,42,$IDValue,"",' readonly onChange="'.$this->topFrame.'.hot=1;"',"text",$width,0),
			"",
			"left",
			"defaultfont",
			"",
			getPixel(20,4),
			we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $button : "");
	}

	function formWeChooser($table = FILE_TABLE, $width = "", $rootDirID = 0, $IDName = "ID", $IDValue = "0",$Pathname="Path", $Pathvalue = "/", $cmd = "") {
		if ($Pathvalue == "") {
			$Pathvalue = f("SELECT Path FROM $table WHERE ID='" . $IDValue."';", "Path", $this->db);
		}
		
		$we_button = new we_button();
		$button =  $we_button->create_button("select","javascript:top.content.setHot();we_cmd('openDirselector',document.we_form.elements['$IDName'].value,'$table','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','".session_id()."','$rootDirID')");
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("SelPath");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($Pathname,$Pathvalue,array("onChange"=>$this->topFrame.'.hot=1;'));
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($IDName,$IDValue);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(FILE_TABLE);
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);
		
		return $yuiSuggest->getHTML();
	}


	function getHTMLCategory() {
		global $l_export;
		if (isset($_REQUEST["cmd"])){
				switch($_REQUEST["cmd"]){
					case "add_cat":
						$arr=makeArrayFromCSV($this->View->export->Categorys);
						if (isset($_REQUEST["cat"])){
							$ids = makeArrayFromCSV($_REQUEST["cat"]);
							foreach($ids as $id){
								if (strlen($id) && (!in_array($id,$arr))) {
									array_push($arr,$id);
								}
							}
							$this->View->export->Categorys=makeCSVFromArray($arr,true);
						}
				break;
				case "del_cat":
					$arr=makeArrayFromCSV($this->View->export->Categorys);
					if (isset($_REQUEST["cat"])){
						foreach($arr as $k=>$v){
							if ($v==$_REQUEST["cat"]) array_splice($arr,$k,1);
						}
						$this->View->export->Categorys=makeCSVFromArray($arr,true);
					}
				break;
				case "del_all_cats":
					$this->View->export->Categorys="";
				break;
				default:
			}
		}


		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		$hiddens =	we_htmlElement::htmlHidden(array("name"=>"Categorys","value"=>$this->View->export->Categorys)).
					we_htmlElement::htmlHidden(array("name"=>"cat","value"=>(isset($_REQUEST["cat"]) ? $_REQUEST["cat"] :"")));

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:top.content.setHot(); we_cmd('del_all_cats')",true,-1,-1,"","",(isset($this->View->export->Categorys) ? false : true));
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot(); we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.".$this->editorBodyFrame.".we_cmd(\\'add_cat\\',top.allIDs);')");
		//$addbut    = $we_button->create_button("add", "javascript:we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.".$this->editorBodyFrame.".addCat(top.allIDs,top.allPaths);')");

		$cats = new MultiDirChooser($this->_width_size,$this->View->export->Categorys,"del_cat", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path", CATEGORY_TABLE);

		if (!we_hasPerm("EDIT_KATEGORIE")) {
			$cats->isEditable=false;
		}
		return $hiddens.htmlFormElementTable($cats->get(),$l_export["categories"], "left", "defaultfont");
	}
}
?>