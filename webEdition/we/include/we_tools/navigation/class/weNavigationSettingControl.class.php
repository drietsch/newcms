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

class weNavigationSettingControl
{

	function saveSettings($default = false)
	{
		if ($_SESSION["perms"]["ADMINISTRATOR"]) {
			if ($default) {
				$CacheLifeTime = '';
				$Add = 'true';
				$Edit = 'true';
				$Delete = 'true';
			
			} else {
				$CacheLifeTime = (int)str_replace("'", "", $_REQUEST['CacheLifeTime']);
				
				$Add = 'false';
				if ($_REQUEST['NavigationCacheAdd'] == 1) {
					$Add = 'true';
				}
				
				$Edit = 'false';
				if ($_REQUEST['NavigationCacheEdit'] == 1) {
					$Edit = 'true';
				}
				
				$Delete = 'false';
				if ($_REQUEST['NavigationCacheDelete'] == 1) {
					$Delete = 'true';
				}
			
			}
			
			$code = <<<EOF
<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

\$GLOBALS['weDefaultNavigationCacheLifetime'] = '{$CacheLifeTime}';

\$GLOBALS['weNavigationCacheDeleteAfterAdd'] = {$Add};
\$GLOBALS['weNavigationCacheDeleteAfterEdit'] = {$Edit};
\$GLOBALS['weNavigationCacheDeleteAfterDelete'] = {$Delete};

?>
EOF;
			
			$languageFile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/conf/we_conf_navigation.inc.php";
			$fh = fopen($languageFile, "w+");
			if (!$fh) {
				return false;
			}
			fputs($fh, $code);
			return fclose($fh);
		
		}
	}

}

?>