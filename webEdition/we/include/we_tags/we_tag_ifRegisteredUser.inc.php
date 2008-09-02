<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


function we_tag_ifRegisteredUser($attribs, $content) {

	$permission = we_getTagAttribute("permission", $attribs);
	$match = we_getTagAttribute("match", $attribs);
	$cfilter = we_getTagAttribute("cfilter", $attribs, "", true);

	$userid = we_getTagAttribute("userid", $attribs, "");
	$userid = makeArrayFromCSV($userid);

	if ($GLOBALS["we_doc"]->InWebEdition || $GLOBALS["WE_MAIN_DOC"]->InWebEdition) {
		return isset($_SESSION["we_set_registered"]) && $_SESSION["we_set_registered"];

	} else {

		if ( $cfilter && defined("CUSTOMER_TABLE") && isset($GLOBALS["we_doc"]->documentCustomerFilter) && $GLOBALS["we_doc"]->documentCustomerFilter ) {
			if ( $GLOBALS["we_doc"]->documentCustomerFilter->accessForVisitor( $GLOBALS["we_doc"], array(), true ) == WECF_ACCESS ) {
				return true;
			} else {
				return false;
			}

		}

		if(sizeof($userid) > 0) {
			if(!isset($_SESSION["webuser"]['ID'])) {
				return false;
			} else if(!in_array($_SESSION["webuser"]['ID'], $userid)) {
				return false;
			}
		}

		if($permission) {
			if(!empty($match)){
				return isset($_SESSION["webuser"]["registered"]) && isset($_SESSION["webuser"][$permission]) && $_SESSION["webuser"]["registered"] && $_SESSION["webuser"][$permission]==$match;
			} else {
				return isset($_SESSION["webuser"]["registered"]) && isset($_SESSION["webuser"][$permission]) && $_SESSION["webuser"]["registered"] && $_SESSION["webuser"][$permission];
			}

		} else {
			return isset($_SESSION["webuser"]["registered"]) && $_SESSION["webuser"]["registered"];
		}
	}
}
?>