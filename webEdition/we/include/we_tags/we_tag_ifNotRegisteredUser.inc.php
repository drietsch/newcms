<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifNotRegisteredUser($attribs,$content) {

	$match = we_getTagAttribute("match", $attribs);
	$cfilter = we_getTagAttribute("cfilter", $attribs, "", true, false);

	if ($GLOBALS["we_doc"]->InWebEdition || $GLOBALS["WE_MAIN_DOC"]->InWebEdition) {
		return !(isset($_SESSION["we_set_registered"]) && $_SESSION["we_set_registered"]);

	} else {

		if ( $cfilter && defined("CUSTOMER_TABLE") && isset($GLOBALS["we_doc"]->documentCustomerFilter) && $GLOBALS["we_doc"]->documentCustomerFilter ) {
			if ( $GLOBALS["we_doc"]->documentCustomerFilter->accessForVisitor( $GLOBALS["we_doc"], array(), true ) == WECF_ACCESS ) {
				return false;

			} else {
				return true;

			}

		}

		if (isset($attribs["permission"]) && $attribs["permission"]) {
			if(!empty($match)){
				return !(isset($_SESSION["webuser"]["registered"]) && isset($_SESSION["webuser"][$attribs["permission"]]) && $_SESSION["webuser"]["registered"] &&  $_SESSION["webuser"][$attribs["permission"]]==$match);
			} else {
				return  !(isset($_SESSION["webuser"]["registered"]) && $_SESSION["webuser"]["registered"] && $_SESSION["webuser"][$attribs["permission"]]);
			}
		} else {
			return  !(isset($_SESSION["webuser"]["registered"]) && $_SESSION["webuser"]["registered"]);
		}
	}
}
?>