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
