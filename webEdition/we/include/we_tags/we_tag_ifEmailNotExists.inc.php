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


function we_tag_ifEmailNotExists($attribs, $content)
{
	if(isset($GLOBALS["WE_REMOVENEWSLETTER_STATUS"])){
		if($GLOBALS["WE_REMOVENEWSLETTER_STATUS"]==1) return true;
		else return false;
	}
	else return false;
}

?>