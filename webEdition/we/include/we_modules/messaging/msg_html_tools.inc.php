<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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