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
