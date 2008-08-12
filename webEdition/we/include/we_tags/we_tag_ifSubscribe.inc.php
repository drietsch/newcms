<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifSubscribe($attribs, $content) {
	if (isset($GLOBALS["WE_WRITENEWSLETTER_STATUS"])) {
		return (($GLOBALS["WE_WRITENEWSLETTER_STATUS"] == 0) ? true : false);
	} else {
		return false;
	}
}

?>