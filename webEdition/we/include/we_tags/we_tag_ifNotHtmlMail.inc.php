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