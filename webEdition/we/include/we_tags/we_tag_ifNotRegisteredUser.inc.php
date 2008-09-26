<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


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