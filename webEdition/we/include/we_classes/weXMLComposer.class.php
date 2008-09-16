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


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");


	class weXMLComposer{
		
		function we_xmlElement($name,$content="",$attributes=null){																											 
			$element=new we_baseElement($name,true,(isset($attributes) && is_array($attributes) ? $attributes : null),$content);
			return $element->getHtmlCode($element);

		}
		
		
		/* Function creates new xml element. 
		* 
		* element - [name] - element name
		*				 [attributes] - atributes array in form arry["attribute_name"]=attribute_value 
		*				 [content] - if array childs otherwise some content
		*
		*/
		function buildXMLElements($elements){
							$out="";
							$content="";
							foreach($elements as $element){
								if(is_array($element["content"])){									
									$content=weXMLComposer::buildXMLElements($element["content"]);
								}
								else $content=$element["content"];
								$element=new we_baseElement($element["name"],true,$element["attributes"],$content);
								$out.=$element->getHtmlCode($element);
							}
							return $out;
		}		
		
		function buildAttributesFromArray($attribs) {
			
			if(!is_array($attribs)){
				return '';
			}
			$out = '';
			foreach($attribs as $k=>$v){ 
				if($v==null && $v!=""){
					$out.=' '.$k; 
				} else {
					$out.=' '.$k.'="'.$v.'"';
				}
			}
			
			return $out;
			
		}
		
	
	}

?>