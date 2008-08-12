<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                                            |
// +----------------------------------------------------------------------+
//


function we_tag_newsletterField($attribs, $content){
	$fieldName = we_getTagAttribute("fieldName",$attribs);
	return empty($fieldName) ? "" : "####PLACEHOLDER:DB::CUSOMER_TABLE:".$fieldName."####";
}
?>