<?php 

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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
