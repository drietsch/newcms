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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");

function we_tag_sum($attribs,$content){
    
	$foo = attributFehltError($attribs,"name","sum");if($foo) return $foo;
	$name = we_getTagAttribute("name",$attribs);
	$num_format = we_getTagAttribute("num_format",$attribs);
	if(isset($GLOBALS["summe"][$name])){
    	$result=we_util::std_numberformat($GLOBALS["summe"][$name]);
    } else {
        $result = 0;
    }
	
	if(isset($attribs["num_format"])){
    	if($attribs["num_format"]=="german"){
		    $result=number_format($result,2,",",".");
	    }else if($attribs["num_format"]=="french"){
    		$result=number_format($result,2,","," ");
    	}else if($attribs["num_format"]=="english"){
		    $result=number_format($result,2,".","");
		}else if($attribs["num_format"]=="swiss"){
	    	$result=number_format($result,2,".","'");
	    }
	}
	return $result;

}
?>