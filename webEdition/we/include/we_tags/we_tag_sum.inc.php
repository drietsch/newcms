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