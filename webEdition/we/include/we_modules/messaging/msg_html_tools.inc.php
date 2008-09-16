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


/**
 * This function build the sort arrow for the messaging module.
 *
 * @param          $name                                   string
 * @param          $href                                   string
 *
 * @return         string
 */

function sort_arrow($name, $href) {
	// Set path to image of arrow
	$_image_path = IMAGE_DIR . 'modules/messaging/' . $name . '.gif';

	// Check if we have to create a form or href
	if ($href) { // Return href
		return '<a href="' . $href . '"><img src="' . $_image_path . '" border="0" alt=""></a>';
	} else { // Return form
		return '<input type="image" src="' . $_image_path . '" border="0" alt="">';
	}
}

?>