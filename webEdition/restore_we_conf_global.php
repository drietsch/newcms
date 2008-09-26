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

	$_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php";
	$_temp_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/def_we_conf_global.inc.php";
	if (file_exists($_temp_file_name)) {
		
		$couter = 0;
		while ($counter < 1000) {
			if (copy($_temp_file_name, $_file_name)) {
				$counter = 1000;
			} 
			$counter++;
		}
	}

?>