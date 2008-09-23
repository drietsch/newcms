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
 * Filename:    we_baseElement.inc.php
 * Directory:   /webEdition/we/include/we_classes/html
 *
 * Function:    Utility class that implements basic html elements operations
 *
 * Description: Provides functions for creating html tags
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

class we_baseElement {

	var $uid;
	var $tag_name="";
	var $need_end_tag=true;

	var $attribs=array();
	var $content="";


	/**
	* Constructor
	* @param		$attribs								array
	* @param		$content								string
	*
	* @return		we_baseElement
	*/
	function we_baseElement($tagname="",$need_end_tag=true,$attribs=array(),$content="") {
		$this->setTagName($tagname);
		$this->setNeedEndTag($need_end_tag);

		if(is_array($attribs)) $this->setAttributes($attribs);
		$this->setContent($content);

	}


	/**
	* Function fills uniquie id attribute with random value
	*
	* @return	void
	*/
	function setUniquieID($secure=true){
		if($secure)	$this->uid=md5(uniqid(rand()));
		else $this->uid=uniqid(rand());
	}


	/**
	* Function returns copy of object
	*
	* @return     we_baseElement
	*/
	function copy() {

		$copy=unserialize(serialize($this));

		return $copy;
	}

	/**
	* Function sets tag name
	*
	* @param		$tagname								string
	*
	* @return		void
	*/
	function setTagName($tagname){
		$this->tag_name=$tagname;
	}

	/**
	* Function sets need_end_tag element attribute. Attribute need_end_tag indicates when the element needs end tag.
	*
	* @param		$need_end_tag							bool
	*
	* @return		void
	*/
	function setNeedEndTag($need_end_tag){
		$this->need_end_tag=$need_end_tag;
	}

	/*
	* Function sets element attributes
	*
	* @param		$attribs								array
	*
	* @return		void
	*/
	function setAttributes($attribs){
		if(is_array($attribs)){
			foreach($attribs as $k=>$v){
				$this->attribs[$k]=$v;
			}
		}
	}

	/**
	* Function sets element attribute
	*
	* @param		$attrib_name							string
	* @param		$attrib_value							string
	*
	* @return		void
	*/
	function setAttribute($attrib_name,$attrib_value){
		$this->attribs[$attrib_name]=$attrib_value;
	}


	/**
	* Function gets element attribute
	*
	* @param		$attrib_name							string
	*
	* @return		string
	*/
	function getAttribute($attrib_name){
		return $this->attribs[$attrib_name];
	}

	/**
	* Function sets element content
	*
	* @param		$content							string
	*
	* @return		void
	*/
	function setContent($content){
		$this->content=$content;
	}

	/**
	* Function append content
	*
	* @param		$content							string
	*
	* @return		void
	*/
	function appendContent($content){
		$this->content.=$content;
	}

	/**
	* The function generate HTML code for the tag
	*
	* @param		$object								we_baseElement
	*
	* @return		string
	*/
	function getHtmlCode($object){

		$out='<'.$object->tag_name;
		foreach($object->attribs as $k=>$v){
			if (!isset($v)) {
				$out.=' '.$k;
			} else {
				$out.=' '.$k.'="'.$v.'"';
			}
		}
		$out.=">".$object->content;
		if($object->need_end_tag) $out.="</".$object->tag_name.">";
		return $out;
	}

	function getHTML(){

		$out='<'.$this->tag_name;
		foreach($this->attribs as $k=>$v){
			if($v==null && $v!="") $out.=' '.$k;
			else $out.=' '.$k.'="'.$v.'"';
		}
		$out.=">".$this->content;
		if($this->need_end_tag) $out.="</".$this->tag_name.">\n";
		return $out;
	}

}

?>