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
				case 'edit_spellchecker_ifthere':
		        case 'edit_spellchecker':
		        	$mod='spellchecker';
			        $INCLUDE = 'we_modules/spellchecker/weSpellcheckerAdmin.php';
			        break;
		}

?>