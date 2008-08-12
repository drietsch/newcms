<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifNotHtmlMail($attribs, $content) {
	if ((isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) || (isset($GLOBALS['we_doc']->InWebEdition) && $GLOBALS['we_doc']->InWebEdition)) {
		return true;
	}

	if (isset($GLOBALS["WE_HTMLMAIL"])) {
		if (!$GLOBALS["WE_HTMLMAIL"]) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

?>