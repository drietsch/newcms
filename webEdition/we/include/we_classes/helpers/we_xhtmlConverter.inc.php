<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Filename:    we_xhtmlConverter.inc.php
 * Directory:   /webEdition/we/include/we_classes/helpers
 *
 * Function:    XHTML parsing and  converting class of webEdition
 *
 * Description: Provides functions to parse and convert HTML source of the
 *              wysiwyg control of webEdition to XHTML 1.0.
 */

class we_xhtmlConverter {

	
	function we_xhtmlConverter(){
		exit( "Do not call this function directly! This is a static class!!!" );	
	}
	
	/**
	 * @return string
	 * @param string $code
	 * @param boolean $xml
	 * @desc parse and convert HTML source to html4 or xhtml
	*/
	function correct_HTML_source($code,$xml=false) {
		
		// convert <?tags to  be sure that the following regex will work correct
		$code = str_replace("/<?","WE##[?",$code);
		$code = str_replace("/?>","WE##?]",$code);
		
		// find the tags and process them
		$code = preg_replace ("/<([^> ]+)([^>]*)>/e","we_xhtmlConverter::_corrTag('\\1','\\2',$xml)", $code);

		// correct wrong <ul> Tags
		$code = we_xhtmlConverter::_correctListTags($code,"ul");
		// correct wrong <ol> Tags
		$code = we_xhtmlConverter::_correctListTags($code,"ol");
		
		// convert back
		$code = str_replace("WE##[?","/<?",$code);
		$code = str_replace("WE##?]","/?>",$code);
		
		
		return $code;
		
	}
	
	
	function _correctListTags($code,$name="ul"){
		while(eregi("</li>[ \n\r\t]*<$name",$code,$regs)){
			$repl = $regs[0];
			
			$pos = strpos($code,$repl);
			// suche ul endtag
			$posULStartTag = strpos($code,"<$name",$pos+1);
			$posULStartTag2 = strpos($code,"<$name",$posULStartTag+1);
			$posULEndTag = strpos($code,"</$name",$posULStartTag+1);
			$endtagcount = 0;
			$starttagposFinal = $posULStartTag;
			while(($posULStartTag2 !== false) && ($posULEndTag >  $posULStartTag2)){
				$posULStartTag = $posULStartTag2;
				$posULStartTag2 = strpos($code,"<$name",$posULStartTag+1);
				$endtagcount++;
			}
			while($endtagcount){
				$posULEndTag = strpos($code,"</$name",$posULEndTag+1);
				$endtagcount --;
			}
			$code = ($pos ? substr($code,0,$pos) : "") . substr($code,$pos+5,($posULEndTag - $pos)) . "</li>" . ((strlen($code)-($posULEndTag+5)) ? substr($code,$posULEndTag+5,strlen($code)-($posULEndTag+5)) : "");
			
			
		}
		return $code;
	}

	/**
	* @return string
	* @param string $tagname
	* @param string $attr
	* @param boolean $xml
	* @desc correct a tag
	*/
	function  _corrTag($tagname, $attr,$xml){
		// only if attribs exists
		if(strlen($attr)){
			$attr = stripslashes(trim($attr));
			
			//remove existing slash at the end
			$l =  strlen($attr);
			if($attr[$l-1] == "/"){
				if($attr == "/"){
					$attr = "";
				}else{
					$attr = trim(substr($attr,0,$l-2));
				}
			}
			// correct attribs in the form of attrib='attrib'			
			$attr = preg_replace("/([^> ]+)='([^']+)'/e", "we_xhtmlConverter::_corrAttr('\\1','\\2')", $attr);
			// replace "=" within attribs to  be sure that the following regex will work correct
			while(eregi(" ?= ?\"[^\"]*=[^\"]*\"",$attr)){
				$attr = preg_replace("/( ?= ?\"[^\"]*)=([^\"]*\")/","\\1WE##ISTGLEICH\\2", $attr);
			}
			// convert attribs in the form of attrib=attrib
			$attr = preg_replace("/([^> ]+)=([^> \"']+)/e", "we_xhtmlConverter::_corrAttr('\\1','\\2')", $attr);
			// convert back
			$attr = " " . str_replace("WE##ISTGLEICH","=",$attr);

		}
		//correct tagname to lowercase
		$tagname = trim(strtolower($tagname));
		
		if($tagname == "img"){
			if(!ereg('alt="',$attr)){
				$attr .= ' alt=""';	
			}
		}
		
		// detect if a slash should be added
		$slash = "";
		if($xml){
			switch($tagname){
				case "br":
				case "input":
				case "meta":
				case "link":
				case "img":
				case "hr":
					$slash = " /";
					break;
					
			}
		}
		// return the tag
		return '<' . $tagname . $attr . $slash . '>';
	}
	
	/**
	 * @return string
	 * @param string $key
	 * @param string $val
	 * @desc correct an attrib
	*/
	function _corrAttr($key, $val){
		// correct an attrib
		return  strtolower($key) . "=" . '"' . str_replace("\"","&quot;",$val) . '"';
	}
	
}

?>