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
