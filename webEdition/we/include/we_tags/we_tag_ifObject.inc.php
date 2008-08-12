<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifObject($attribs,$content) {
	return (($GLOBALS["lv"]->ClassName == "we_listview_object") || ($GLOBALS["lv"]->ClassName=="we_search_listview" && $GLOBALS["lv"]->f("OID")));
}

?>