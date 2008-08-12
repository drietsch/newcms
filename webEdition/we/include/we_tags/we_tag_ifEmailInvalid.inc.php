<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifEmailInvalid($attribs, $content)
{
	if(isset($GLOBALS["WE_REMOVENEWSLETTER_STATUS"])){
		if($GLOBALS["WE_REMOVENEWSLETTER_STATUS"]==2) return true;
		else return false;
	}else if(isset($GLOBALS["WE_WRITENEWSLETTER_STATUS"])){
		if($GLOBALS["WE_WRITENEWSLETTER_STATUS"]==2) return true;
		else return false;
	}else{
		return false;
	}
}
?>