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


		switch($_REQUEST["we_cmd"][0]){
			case 'tool_navigation_rules':
        		$toolInclude = 'navigation/edit_navigation_rules_frameset.php';
        	break;
			case 'tool_navigation_edit':
				$toolInclude = 'tools_frameset.php';
			break;
			case 'tool_navigation_edit_navi':
				$toolInclude = 'navigation/weNaviEditor.php';
			break;
			case 'tool_navigation_do_reset_customer_filter':
				$toolInclude = 'navigation/reset_customerFilter.php';
			break;
		}

		if(isset($toolInclude)) {
        	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $toolInclude);
        }
 
?>
