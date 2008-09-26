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