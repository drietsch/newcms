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


function we_tag_createShop($attribs, $content) {
	$foo = attributFehltError($attribs, "shopname", "createShop");
	if ($foo) {
		return $foo;
	}
}

?>