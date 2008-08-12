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
				case "edit_voting_ifthere":
		        case "edit_voting":
		        	$mod="voting";
			        $INCLUDE = "we_modules/show_frameset.php";
			        break;
				case "openVotingDirselector":
					//$INCLUDE = "we_modules/voting/we_votingDirSelectorFrameset.php";
					break;		
	        	break;                                                                                
                }
        
 
?>
