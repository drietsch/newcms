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
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryView.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryTree.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditor.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditorHome.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditorFolder.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditorType.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditorException.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryFrameEditorItem.php");


class weGlossaryFrames extends weModuleFrames {

	var $View;
	var $Tree;

	var $_space_size = 150;
	var $_text_size = 75;
	var $_width_size = 535;

	
	function weGlossaryFrames() {
		
		$this->weModuleFrames(WE_GLOSSARY_MODULE_PATH."edit_glossary_frameset.php");
		
		$this->Tree = new weGlossaryTree();
		$this->View = new weGlossaryView(WE_GLOSSARY_MODULE_PATH."edit_glossary_frameset.php","top.content");
		
		$this->setupTree(GLOSSARY_TABLE,"top.content","top.content.resize.left.tree","top.content.cmd");
		
		$this->module="glossary";
		
	}

	
	function getHTML($what) {

		switch($what){
			
			case "frameset":
				print $this->getHTMLFrameset();
				break;
				
			case "header":
				print $this->getHTMLHeader();
				break;
				
			case "resize":
				print $this->getHTMLResize();
				break;
				
			case "left":
				print $this->getHTMLLeft();
				break;
				
			case "right":
				print $this->getHTMLRight();
				break;
				
			case "editor":
				print $this->getHTMLEditor();
				break;
				
			case "edheader":
				print $this->getHTMLEditorHeader();
				break;
				
			case "edbody":
				print $this->getHTMLEditorBody();
				break;
				
			case "edfooter":
				print $this->getHTMLEditorFooter();
				break;
				
			case "cmd":
				print $this->getHTMLCmd();
				break;
				
			case "treeheader":
				print $this->getHTMLTreeHeader();
				break;
				
			case "treefooter":
				print $this->getHTMLTreeFooter();
				break;
				
			default:
				error_log(__FILE__ . " unknown reference: $what");
		}
	}

	
	function getHTMLFrameset() {
		
		return weModuleFrames::getHTMLFrameset();
		
	}
	
	
	function getJSCmdCode() {
		
		return $this->View->getJSTop() . we_htmlElement::jsElement($this->Tree->getJSMakeNewEntry());
		
	}
	
	
	function getHTMLEditorHeader() {
		
		if(isset($_REQUEST['home']) && $_REQUEST["home"]) {
			return weGlossaryFrameEditorHome::Header($this);
			
		}
		
		if(isset($_REQUEST['cmd'])) {
			switch($_REQUEST['cmd']) {
				
				// Folder View
				case 'view_folder':
					return weGlossaryFrameEditorFolder::Header($this);
					break;
				
				// Type View
				case 'view_type':
					return weGlossaryFrameEditorType::Header($this);
					break;
				
				// Exception View
				case 'view_exception':
				case 'save_exception':
					return weGlossaryFrameEditorException::Header($this);
					break;
				
				// Item View
				default:
					return weGlossaryFrameEditorItem::Header($this);
					break;
					
			}
			
			if(isset($_REQUEST['cmdid']) && !eregi("^[0-9]", $_REQUEST['cmdid'])) {
				$this->View->Glossary->Language = substr($_REQUEST['cmdid'], 0, 5);
				
			}
			
		} else {
			return weGlossaryFrameEditorItem::Header($this);
			
		}
		
	}
		
	
	
	function getHTMLEditorBody() {
		
		if(isset($_REQUEST['home']) && $_REQUEST["home"]) {
			return weGlossaryFrameEditorHome::Body($this);
			
		}
		
		if(isset($_REQUEST['cmd'])) {
			switch($_REQUEST['cmd']) {
				
				// Folder View
				case 'view_folder':
					return weGlossaryFrameEditorFolder::Body($this);
					break;
				
				// Type View
				case 'view_type':
					return weGlossaryFrameEditorType::Body($this);
					break;
				
				// Exception View
				case 'view_exception':
				case 'save_exception':
					return weGlossaryFrameEditorException::Body($this);
					break;
				
				// Item View
				default:
					return weGlossaryFrameEditorItem::Body($this);
					break;
					
			}
			
			if(isset($_REQUEST['cmdid']) && !eregi("^[0-9]", $_REQUEST['cmdid'])) {
				$this->View->Glossary->Language = substr($_REQUEST['cmdid'], 0, 5);
				
			}
			
		} else {
			return weGlossaryFrameEditorItem::Body($this);
			
		}

	}
	
	
	function getHTMLEditorFooter() {

		if(isset($_REQUEST["home"])){
			return weGlossaryFrameEditorHome::Footer($this);
			
		}
		
		if(isset($_REQUEST['cmd'])) {
			switch($_REQUEST['cmd']) {
				
				// Folder View
				case 'view_folder':
					return weGlossaryFrameEditorFolder::Footer($this);
					break;
				
				// Type View
				case 'view_type':
					return weGlossaryFrameEditorType::Footer($this);
					break;
				
				// Exception View
				case 'view_exception':
				case 'save_exception':
					return weGlossaryFrameEditorException::Footer($this);
					break;
				
				// Item View
				default:
					return weGlossaryFrameEditorItem::Footer($this);
					break;
					
			}
			
			if(isset($_REQUEST['cmdid']) && !eregi("^[0-9]", $_REQUEST['cmdid'])) {
				$this->View->Glossary->Language = substr($_REQUEST['cmdid'], 0, 5);
				
			}
			
		} else {
			return weGlossaryFrameEditorItem::Footer($this);
			
		}

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

		include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryTreeLoader.php");

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
							we_htmlElement::jsElement($rootjs.$this->Tree->getJSLoadTree(weGlossaryTreeLoader::getItems($pid,$offset,$this->Tree->default_segment,"")))
					)
		);

		return $this->getHTMLDocument($out);
		
	}
	

}

?>