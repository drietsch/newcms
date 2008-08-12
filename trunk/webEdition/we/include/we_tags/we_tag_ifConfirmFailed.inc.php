<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifConfirmFailed($attribs, $content)
{
	if(isset($GLOBALS["WE_WRITENEWSLETTER_STATUS"])){
		if($GLOBALS["WE_WRITENEWSLETTER_STATUS"]==3) return true;
		else return false;
	}
	else return false;
}

?>