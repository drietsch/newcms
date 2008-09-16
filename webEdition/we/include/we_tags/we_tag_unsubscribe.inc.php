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


function we_tag_unsubscribe($attribs, $content)
{

	$attribs['type'] = 'text';
	$attribs['name'] = 'we_unsubscribe_email__';
	
	if(isset($_REQUEST["we_unsubscribe_email__"])){
	    $attribs['value'] = htmlspecialchars($_REQUEST["we_unsubscribe_email__"]);
	} else {
	    $attribs['value'] = "";
	}	
	
	return getHtmlTag('input', $attribs);
}
?>