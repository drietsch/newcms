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
 * Filename:    we_baseCollection.inc.php
 * Directory:   /webEdition/we/include/we_classes/html
 *
 * Function:    Utility class that implements basic html collection operations
 *
 * Description: Provides functions for creating html tags
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_baseElement.inc.php");

class we_baseCollection extends we_baseElement{

	var $childs=array();

	/**
	* Constructor
	*
	* @param		$tagname								string
	* @param		$need_end_tag							bool
	* @param		$attribs								array
	* @param		$childs_num								int					(optional)
	*
	* @return		we_baseCollection
	*/	
	function we_baseCollection($tagname="",$need_end_tag=true,$attribs=array(),$childs_num=0){
		$this->we_baseElement($tagname,$need_end_tag,$attribs);
		
		for($i=0;$i<$childs_num;$i++) $this->addChild(new we_baseElement()); 		
	}
		
	/**
	* Function adds new element to the collection
	*
	* @param		$child									we_baseElement
	*
	* @return		void
	*/	
	function addChild($child){
		$this->childs[]=$child;
	}

	/**
	* Function dels element from the collection
	* Parameter $childid is a sequence number in the childs array
	*
	* @param		$childid									int
	*
	* @return		void
	*/	
	function delChild($childid){
		array_splice($this->childs,$childid,1);
	}	

	/**
	* Function sets child wit specified childid with given child object
	*
	* @param		$childid									int
	* @param		$child										we_baseElement
	*
	* @return		void
	*/		
	function setChild($childId,$child){
		$this->childs[$childId]=$child;
	}

	/**
	* Function gives reference on child object back
	*
	* @param		$childid									int
	*
	* @return		we_baseElement
	*/
	function &getChild($childId){			
		return $this->childs[$childId]; 
	}				
		
	/**
	* Function generate collection HTML code 
	*
	* @param		$object										we_baseElement
	*
	* @return		string
	*/
	function getHtmlCode($object){
		$childs_content="";
		foreach($object->childs as $kc=>$vc){						
			$childs_content.=$object->childs[$kc]->getHtmlCode($object->childs[$kc]);
		}
		$object->setContent($childs_content);
		return we_baseElement::getHtmlCode($object);
	}
	
	
	
}

?>