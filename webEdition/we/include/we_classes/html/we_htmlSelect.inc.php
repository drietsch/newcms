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
 * Filename:    we_htmlSelect.inc.php
 * Directory:   /webEdition/we/include/we_classes/html
 *
 * Function:    Utility class that implements operations on selects
 *
 * Description: Provides functions for creating html tags
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_baseCollection.inc.php");

class we_htmlSelect extends we_baseCollection {

	/**
	* Constructor
	*
	* @param		$attribs								array			(optional)
	* @param		$opt_num								array			(optional)
	*
	* @return		we_htmlSelect
	*/
	function we_htmlSelect($attribs=array(),$opt_num=0) {
		$this->we_baseCollection("select",true,$attribs);
		for($i=0;$i<$opt_num;$i++)	$this->addOption();
		

	}
		
	/**
	* The function returns number of options
	*
	* @return		int
	*/	
	function getOptionNum(){
		return (count($this->childs)-1);
	}	
	
	/**
	* The function add new option to a select box
	*
	* @param		$value									string
	* @param		$text									string
	*
	* @return		void
	*/	
	function addOption($value,$text){
		$this->childs[]=new we_baseElement("option",true,array("value"=>$value),$text);
	}
		
	/**
	* The function adds one or more options to a select box
	*
	* @param		$opt_num									int				(optional)
	* @param		$values										array			(optional)
	* @param		$texts										array			(optional)
	*
	* @return		void
	*/	
	function addOptions($opt_num=1,$values=array(),$texts=array()){
		for($i=0;$i<$opt_num;$i++)	$this->childs[]=new we_baseElement("option",false,array("value"=>$values[$i]),$texts[$i]);
	}	
		
	/**
	* The function deletes option with given option value
	*
	* @param		$value										string
	*
	* @return		void
	*/	
	function delOption($value){
		
		foreach($this->childs as $k=>$v){		
			if($v->attribs["value"]==$value){
				$cid=$k;
				break;
			}
		}
		if(isset($cid))	$this->delChild($cid);
				
	}	

	/**
	* The function deletes all options from select
	*
	* @return		void
	*/	
	function delAllOptions(){		

		$this->childs=array();

	}	
	
	/**
	* The function inserts option on specified place in a select box
	* Parameter $optid defines option's place in select's child array
	* If $over is true then an option which is placed on the specified position will be overwritten
	*
	* @param		$optid									int	
	* @param		$value									string
	* @param		$text									string
	* @param		$over									string			(optional)
	*
	* @return		void
	*/	
	function insertOption($optid,$value,$text,$over=false){
		$new_opt=new we_baseElement("option",false,array("value"=>$value),$text);
		
		
		if($over){
			$this->childs[$optid]=$new_opt;
		}
		else{
			if($optid==0) $optid=-1;
			if(count($this->childs)>=$optid+1){
				$array_pre=array_slice($this->childs,0,($optid+1));
				$array_pre[]=$new_opt;
				$array_post=array_slice($this->childs,($optid+1));
				$this->childs=array_merge($array_pre,$array_post);
			}
			else{
				$this->childs[]=$new_opt;
			} 
		}
				
	}	
		
	/**
	* The function sets option attributes and content. The option is identified by optid. 
	*
	* @param		$optid									int	
	* @param		$attribs								array
	* @param		$attribs								array
	*
	* @return		void
	*/				
	function setOption($optid,$attribs=array(),$content=null){
		
		$opt=& $this->getChild($optid);
		$opt->setAttributes($attribs);		
		if($content!=null) $opt->setContent($content);
	}
	
	/**
	* The function selects option that is identified by the value. 
	*
	* @param		$value									string
	*
	* @return		void
	*/
	function selectOption($value){

		if(!in_array("multiple",array_keys($this->attribs))) $this->unselectAllOptions();
		foreach($this->childs as $k=>$v){
			if($v->attribs["value"]==$value){
				$this->setOption($k,array("selected" => null));
				break;
			}
		}

	}	
	
	/**
	* The function unsets all selected options 
	*
	*
	* @return		void
	*/	
	function unselectAllOptions(){
		foreach($this->childs as $k=>$v){
			if(in_array("selected",array_keys($v->attribs))){
				unset($this->childs[$k]->attribs["selected"]);
			} 
		}		
	}
	
	/**
	* The function sets option identified by optid with given value and text
	* @param		$optid									int
	* @param		$value									string
 	* @param		$text									string
	*
	* @return		void
	*/	
	function setOptionVT($optid,$value,$text){
		
		$opt=& $this->getChild($optid);
		$opt->setAttribute("value",$value);	
		$opt->setContent($text);
				
	}
			
	/**
	* The function generates html code
	*
	* @return		void
	*/
	function getHtmlCode(){
		return we_baseCollection::getHtmlCode($this);
	}	
	
	/**
	* The function adds a new option group to the select box
	*
	* @param  $attribs        array
	*
	* @return  void
	*/ 
	function addOptionGroup($attribs=array()){
		$this->childs[]=new we_baseCollection("optgroup",true,$attribs);
	} 

	/**
	* The function returns a new option. This function is static.
	*
	* @param  $value         string
	* @param  $text         string
	*
	* @return  we_baseElement
	*/   
	function getNewOption($value,$text) {
		return new we_baseElement("option",true,array("value"=>$value),$text);
	}

	/**
	* The function returns a new option group. This function is static.
	*
	* @param  $attribs        array
	*
	* @return  we_baseElement
	*/   
	function getNewOptionGroup($attribs=array()) {
		return new we_baseCollection("optgroup",true,$attribs);
	}
}

?>