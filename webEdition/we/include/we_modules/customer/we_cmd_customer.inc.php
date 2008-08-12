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
				case "edit_customer_ifthere":
		        case "edit_customer":
		        	$mod="customer";
			        $INCLUDE = "we_modules/show_frameset.php";
	        	break;
		        case "applyWeDocumentCustomerFilterFromFolder":
		        	$INCLUDE = "we_editors/we_editor.inc.php";
		        	break;
                }


?>
