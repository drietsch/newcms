<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifEmailNotExists($attribs, $content)
{
	if(isset($GLOBALS["WE_REMOVENEWSLETTER_STATUS"])){
		if($GLOBALS["WE_REMOVENEWSLETTER_STATUS"]==1) return true;
		else return false;
	}
	else return false;
}

?>