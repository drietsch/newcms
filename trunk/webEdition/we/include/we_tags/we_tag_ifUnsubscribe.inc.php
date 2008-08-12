<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifUnsubscribe($attribs, $content) {
	if (isset($GLOBALS["WE_REMOVENEWSLETTER_STATUS"])) {
		return (($GLOBALS["WE_REMOVENEWSLETTER_STATUS"] == 0) ? true : false);
	} else {
		return false;
	}
}

?>