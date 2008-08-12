<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifMailingListEmpty($attribs, $content) {
	if (isset($GLOBALS["WE_MAILING_LIST_EMPTY"])) {
		return (($GLOBALS["WE_MAILING_LIST_EMPTY"]==1) ? true : false);
	} else {
		return false;
	}
}

?>