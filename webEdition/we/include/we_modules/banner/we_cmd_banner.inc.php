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