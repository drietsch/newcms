<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weTree.inc.php");

class weModuleFrames{

	var $module;
	var $db;	
	var $frameset;
	var $Tree;
	
	var $topFrame;
	var $treeFrame;
	var $cmdFrame;
			
	function weModuleFrames($frameset){
		$this->db=new DB_WE();
		$this->frameset=$frameset;
		$this->Tree=new weTree();
	}
 	
 	function setFrames($topFrame,$treeFrame,$cmdFrame){
 		$this->topFrame=$topFrame;
 		$this->treeFrame=$treeFrame;
 		$this->cmdFrame=$cmdFrame;
 	}
 	
 	public function setupTree($table, $topFrame, $treeFrame, $cmdFrame){
 		$this->setFrames($topFrame,$treeFrame,$cmdFrame);
 		$this->Tree->init($this->frameset,$topFrame,$treeFrame,$cmdFrame);
 	}
 	
 	function getJSStart(){
		
		if($this->Tree->initialized)
			return 'function start(){startTree();}';
		else
			return 'function start(){}';
	}
	
	
	//----------HTML functions -----------------	
			
	
	function getHTMLDocument($body,$head=""){
		$head=WE_DEFAULT_HEAD."\n" . STYLESHEET . "\n".$head;
		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
				);
	}
	
	function getJSCmdCode(){
		return we_htmlElement::jsElement('function we_cmd(){}');	
	}
 	
 	function getHTMLFrameset(){
		
		$js=$this->getJSCmdCode();
		$js.=$this->Tree->getJSTreeCode();
		$js.=we_htmlElement::jsElement($this->getJSStart());
		$js.=we_htmlElement::jsElement('',array('src'=>JS_DIR . 'we_showMessage.js'));

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");
					
		$frameset->setAttributes(array("rows"=>((isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0) ? "32,*,100" : "32,*,0" ),"onLoad"=>"start();"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=header","name"=>"header","scrolling"=>"no","noresize"=>null));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=resize" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"resize","scrolling"=>"no"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=cmd","name"=>"cmd","scrolling"=>"no","noresize"=>null));
		
		// set and return html code
		$head=$js;
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);
		
		return $this->getHTMLDocument($body,$head);
			
	}

	function getHTMLHeader(){
		global $l_customer;
		
		//	Include the menu.
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/java_menu/weJavaMenu.inc.php");		
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/java_menu/modules/module_menu_".$this->module.".inc.php");
		include_once( $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/jsMessageConsole/messageConsole.inc.php" );
		
		$port = defined("HTTP_PORT") ? HTTP_PORT : "";
		$lang_arr="we_menu_".$this->module;
		$jmenu = new weJavaMenu($$lang_arr,SERVER_NAME,"top.opener.top.load",getServerProtocol(),$port,350,30);
		
		$menu = $jmenu->getCode();
		
		$table=new we_htmlTable(array("width"=>"100%","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,2);		
		$table->setCol(0,0,array("align"=>"left","valign"=>"top"),$menu);
		$table->setCol(0,1,array("align"=>"right","valign"=>"top"),createMessageConsole("moduleFrame"));

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"#bfbfbf","background"=>IMAGE_DIR."java_menu/background.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0"),						
						$table->getHtmlCode()
		);
				
		return $this->getHTMLDocument($body);
		
	}

	function getHTMLResize(){
		
		if ($GLOBALS["BROWSER"] == "NN6"){
			$frameset=new we_htmlFrameset(array("cols"=>"200,*", "border"=>"1", "id"=>"resizeframeid"));
		} else {
			$frameset=new we_htmlFrameset(array("cols"=>"200,*", "border"=>"0", "frameborder"=>"0", "framespacing"=>"0", "id"=>"resizeframeid"));
		}
		if($GLOBALS["BROWSER"] == "IE") {
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=left","name"=>"left","scrolling"=>"no","frameborder"=>"no"));
		} else {
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=left","name"=>"left","scrolling"=>"no"));
		}
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=right" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"right"));		
		
		$noframeset=new we_baseElement("noframes");		
				
		// set and return html code		
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);
		
		return $this->getHTMLDocument($body);		
		
	}

	function getHTMLLeft(){
		
		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");
		
		$frameset->setAttributes(array("rows"=>"1,*"));
		$frameset->addFrame(array("src"=>HTML_DIR."whiteWithTopLine.html","name"=>"treeheader","noresize"=>null,"scrolling"=>"no"));
		$frameset->addFrame(array("src"=>WEBEDITION_DIR."treeMain.php","name"=>"tree","noresize"=>null,"scrolling"=>"auto"));
		
		// set and return html code		
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);
		
		return $this->getHTMLDocument($body);		
	}

	function getHTMLRight(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		if ($GLOBALS["BROWSER"] == "NN6")	{
			$frameset->setAttributes(array("cols"=>"*"));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=editor" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"editor","noresize"=>null,"scrolling"=>"no"));
		} else if($GLOBALS["BROWSER"] == "SAFARI") {
			$frameset->setAttributes(array("cols"=>"1,*"));
			$frameset->addFrame(array("src"=>HTML_DIR."safariResize.html","name"=>"separator","noresize"=>null,"scrolling"=>"no"));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=editor" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"editor","noresize"=>null,"scrolling"=>"no"));
		} else {
			$frameset->setAttributes(array("cols"=>"2,*"));
			$frameset->addFrame(array("src"=>HTML_DIR."ieResize.html","name"=>"separator","noresize"=>null,"scrolling"=>"no"));
			$frameset->addFrame(array("src"=>$this->frameset."?pnt=editor" . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : ''),"name"=>"editor","noresize"=>null,"scrolling"=>"no"));
		}
		$noframeset=new we_baseElement("noframes");		
		// set and return html code		
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);
		
		return $this->getHTMLDocument($body);

	}

	function getHTMLEditor(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");
		
		$frameset->setAttributes(array("rows"=>"40,*,40"));
		$frameset->addFrame(array('src'=>$this->frameset.(isset($_REQUEST['sid']) ? '?sid=' . $_REQUEST['sid'] : '?home=1').'&pnt=edheader','name'=>'edheader','noresize'=>null,'scrolling'=>'no'));
		$frameset->addFrame(array('src'=>$this->frameset.(isset($_REQUEST['sid']) ? '?sid=' . $_REQUEST['sid'] : '?home=1').'&pnt=edbody','name'=>'edbody','scrolling'=>'auto'));
		$frameset->addFrame(array('src'=>$this->frameset.(isset($_REQUEST['sid']) ? '?sid=' . $_REQUEST['sid'] : '?home=1').'&pnt=edfooter','name'=>'edfooter','scrolling'=>'no'));
			
		// set and return html code		
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);
		
		return $this->getHTMLDocument($body);
	}
	
	function getHTMLCmd(){		
		// set and return html code
		$head=$this->Tree->getJSLoadTree();
		$body=we_htmlElement::htmlBody();
		
		return $this->getHTMLDocument($body,$head);
	}
	
	
	function getHTMLBox($content,$headline="",$width="100",$height="50",$w="25",$vh="0",$ident="0",$space="5",$headline_align="left",$content_align="left"){
		$out="";
		$headline = ereg_replace(" ","&nbsp;",$headline);
		if($ident) $pix1=new we_baseElement("img",false,array("src"=>IMAGE_DIR."pixel.gif","width"=>"$ident","height"=>"$vh"));
		if($w){
			if(!$vh) $vh=1;
			$pix2=new we_baseElement("img",false,array("src"=>IMAGE_DIR."pixel.gif","width"=>"$w","height"=>"$vh"));
		}
		
		$pix3=new we_baseElement("img",false,array("src"=>IMAGE_DIR."pixel.gif","width"=>"$space","height"=>"1"));
		
		$table=new we_htmlTable(array("width"=>"$width","height"=>"$height","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),3,4);
					
		if($ident) $table->setCol(0,0,array("valign"=>"top"),we_baseElement::getHtmlCode($pix1));
		if($w) $table->setCol(0,1,array("valign"=>"top"),we_baseElement::getHtmlCode($pix2));
		$table->setCol(1,1,array("valign"=>"middle","class"=>"defaultgray","align"=>$headline_align),$headline);
		$table->setCol(1,2,array(),we_baseElement::getHtmlCode($pix3));
		$table->setCol(1,3,array("valign"=>"middle","align"=>$content_align),$content);
		if($w && $headline!="") $table->setCol(2,1,array("valign"=>"top"),we_baseElement::getHtmlCode($pix2));
									
		$out=$table->getHtmlCode();
			

		return $out;
	}		
	
}

?>