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
	 * if hook execution is enabled this function will be executed 
	 * when publishing a document, template, object or class
	 * The array $param has all information about the respective document.
	 * 
	 * @param array $param
	 */	
	function weCustomHook_publish($param) {
		
		/**
		 * e.g.:
		 * 
		 * ob_start("error_log");
		 * print_r($param);
		 * ob_end_clean();
		 */

	}


?>