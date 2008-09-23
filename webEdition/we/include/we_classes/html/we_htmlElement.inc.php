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


/**
 * Filename:    we_htmlElement.inc.php
 * Directory:   /webEdition/we/include/we_classes/html
 *
 * Function:    Class to create html tags
 *
 * Description: Provides functions for creating html tags
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_htmlTable.inc.php");

class we_htmlElement {

	/**
	* Function generates html code for html form
	*
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/ 	
	function htmlForm($attribs=array(),$content=""){
		
		if(!isset($attribs["name"])) $attribs["name"]="we_form";
		return we_baseElement::getHtmlCode(new we_baseElement("form",true,$attribs,$content));
		
	}

	/**
	* Function generates html code for html input element
	*
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function htmlInput($attribs=array()){
		
		if(!isset($attribs["class"])) $attribs["class"]="defaultfont";
		return we_baseElement::getHtmlCode(new we_baseElement("input",false,$attribs));
		
	}
	
	/**
	* Function generates html code for html radio-checkbox input element
	*
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function htmlRadioCheckbox($attribs=array()){
			// Get global variables
			global $l_html_forms;

			$attribs["type"]="checkbox"; 

			$table=new we_htmlTable(array("cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,3);
			$table->setColContent(0,0,we_htmlElement::htmlInput($attribs));
			$table->setColContent(0,1,getPixel(4,2));
			$table->setColContent(0,2,we_htmlElement::htmlLabel(array("for"=>"$name","title"=>sprintf($l_html_forms["click_here"], $attribs["title"]),$attribs["title"])));
			
			return $table->getHtmlCode();
		
	}

	/**
	* Function generates css code
	*
	* @param		$content								string			(optional)	 
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function cssElement($content="",$attribs=array()){
		$attribs["type"]="text/css";
		return we_baseElement::getHtmlCode(new we_baseElement("style",true,$attribs,$content));
	}

	/**
	* Function generates js code
	*
	* @param		$content								string			(optional)	 
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function jsElement($content="",$attribs=array()){
		$attribs["language"]="JavaScript";
		$attribs["type"]="text/javascript";
		return we_baseElement::getHtmlCode(new we_baseElement("script",true,$attribs,$content));
	}

	/**
	* Function generates link code
	*
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function linkElement($attribs=array()){
		return we_baseElement::getHtmlCode(new we_baseElement("link",false,$attribs));
	}

	/**
	* Function generates html code for html font element 
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlFont($attribs=array(),$content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("font",true,$attribs,$content));
	}

	/**
	* Function generates html code for html div elements
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlSpan($attribs=array(),$content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("span",true,$attribs,$content));
	}

	/**
	* Function generates html code for html div elements
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlDiv($attribs=array(),$content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("div",true,$attribs,$content));
	}
	
	/**
	* Function generates html code for html b element
	*	 
	* @param		$content								string
	*
	* @return		string
	*/	
	function htmlB($content){
		return we_baseElement::getHtmlCode(new we_baseElement("b",true,array(),$content));
	}

	/**
	* Function generates html code for html i element
	*	 
	* @param		$content								string
	*
	* @return		string
	*/	
	function htmlI($content){
		return we_baseElement::getHtmlCode(new we_baseElement("i",true,array(),$content));
	}

	/**
	* Function generates html code for html u element
	*	 
	* @param		$content								string
	*
	* @return		string
	*/	
	function htmlU($content){
		return we_baseElement::getHtmlCode(new we_baseElement("u",true,array(),$content));
	}

	/**
	* Function generates html code for html image element 
	*	 
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function htmlImg($attribs=array()){
		return we_baseElement::getHtmlCode(new we_baseElement("img",false,$attribs));
	}

	/**
	* Function generates html code for html body element 
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlBody($attribs=array(),$content=""){		
		if(!isset($attribs["marginwidth"])) $attribs["marginwidth"]="0";
		if(!isset($attribs["marginheight"])) $attribs["marginheight"]="0";
		if(!isset($attribs["leftmargin"])) $attribs["leftmargin"]="0";
		if(!isset($attribs["topmargin"])) $attribs["topmargin"]="0";
		
		return "\n".we_baseElement::getHtmlCode(new we_baseElement("body",true,$attribs,"\n".$content."\n"));
	}

	/**
	* Function generates html code for html label element 
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlLabel($attribs=array(),$content=""){		
		return we_baseElement::getHtmlCode(new we_baseElement("label",true,$attribs,$content));
	}
	
	/**
	* Function generates html code for html hidden element 
	*	 
	* @param		$attribs								array			(optional)
	*
	* @return		string
	*/	
	function htmlHidden($attribs=array()){
		$attribs["type"]="hidden";
		return we_baseElement::getHtmlCode(new we_baseElement("input",false,$attribs));
	}
	
	/**
	* Function generates html code for html a element 
	*	 
	* @param		$attribs								array			(optional)
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlA($attribs=array(),$content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("a",true,$attribs,$content));
	}

	/**
	* Function generates html code for html br element	 
	*
	* @return		string
	*/		
	function htmlBr(){
		return we_baseElement::getHtmlCode(new we_baseElement("br",false,array(),""));
	}

	/**
	* Function generates html code for html nobr element	 
	*
	* @return		string
	*/		
	function htmlNobr($content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("nobr",true,array(),$content));
	}

	/**
	* Function generates html code for html br element	 
	*
	* @param		$content								string			(optional)
	*
	* @return		string
	*/	
	function htmlComment($content){
		return we_baseElement::getHtmlCode(new we_baseElement("!-- $content --",false));
	}
	
	/**
	* Function generates html code for html document
	*
	* @return		string
	*/	
	function htmlHtml($content){
		return we_baseElement::getHtmlCode(new we_baseElement("html",true,array(),$content));
	}	
	
	/**
	* Function generates html code for document head
	*
	* @return		string
	*/	
	function htmlHead($content){
		return we_baseElement::getHtmlCode(new we_baseElement("head", true, array(),$content));
	}
	
	function htmlMeta($attribs = array()){
		
		return we_baseElement::getHtmlCode(new we_baseElement("meta", false, $attribs));
	}
	
	function htmlTitle($content){
		return we_baseElement::getHtmlCode(new we_baseElement("title", true, array(), $content));
	}

	/**
	* Function generates html code for textarea tag
	*
	* @return		string
	*/	
	function htmlTextArea($attribs=array(),$content=""){
		return we_baseElement::getHtmlCode(new we_baseElement("textarea",true,$attribs,$content));
	}
	
	/**
	* Function generates html code for p tag
	*
	* @return		string
	*/		
	function htmlP($attribs = array(),$content){
		return we_baseElement::getHtmlCode(new we_baseElement("p",true,$attribs,$content));
	}	
	
	/**
	* Function generates html code for center tag
	*
	* @return		string
	*/		
	function htmlCenter($content){
		return we_baseElement::getHtmlCode(new we_baseElement("center",true,array(),$content));
	}	
		
/**
	* Function generates html code for center tag
	*
	* @return		string
	*/		
	function htmlApplet($attribs = array(),$content){
		return we_baseElement::getHtmlCode(new we_baseElement("applet",true,$attribs,$content));
	}	

	/**
	* Function generates html code for center tag
	*
	* @return		string
	*/		
	function htmlParam($attribs = array()){
		return we_baseElement::getHtmlCode(new we_baseElement("param",false,$attribs));
	}		
		
	
	
}

?>
