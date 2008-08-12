<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


switch ($_REQUEST["we_cmd"][0]) {
	case "edit_banner_ifthere":
	case "edit_banner":
		$mod="banner";
		$INCLUDE = "we_modules/show_frameset.php";
		break;                                                                                
	case "openBannerDirselector":
		$INCLUDE = "we_modules/banner/we_bannerDirSelectorFrameset.php";
		break;		
	case "openBannerSelector":
		$INCLUDE = "we_modules/banner/we_bannerSelectorFrameset.php";
		break;		
	case "default_banner":
		$INCLUDE = "we_modules/banner/we_defaultbanner.php";
		break;		
	case "banner_code":
		$INCLUDE = "we_modules/banner/we_bannercode.php";
		break;		
}
        
 
?>