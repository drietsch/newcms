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
				case "edit_export_ifthere":
		        case "edit_export":
		        	$mod="export";
			        $INCLUDE = "we_modules/show_frameset.php";
			        break;
				case "openExportDirselector":
					$INCLUDE = "we_modules/export/we_exportDirSelectorFrameset.php";
					break;		
	        	break;                                                                                
                }
        
 
?>
