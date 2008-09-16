<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

define('WE_DEFAULT_THEME_NAME', 'default');
define('WE_THEMES_DIR', '/we/ui/themes');
define('WE_APP_THEMES_DIR', '/ui/themes');

if (!defined('WE_THEME_NAME')) {
	define('WE_THEME_NAME', WE_DEFAULT_THEME_NAME);
}

/**
 * Class to handle the themes
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_layout_Themes
{

	/**
	 * return css theme url
	 *
	 * @var string
	 */
	static public function computeCSSURL($classname, $filename = 'style.css')
	{
		if (substr($classname, 0, 3) == 'we_') {
			$relPath = WE_THEMES_DIR . '/' . WE_THEME_NAME . '/' . $classname . '/' . $filename;
			if (file_exists($GLOBALS['__WE_LIB_PATH__'] . $relPath)) {
				return $GLOBALS['__WE_LIB_URL__'] . $relPath;
			}
			
			$relPath = WE_THEMES_DIR . '/' . WE_DEFAULT_THEME_NAME . '/' . $classname . '/' . $filename;
			if (file_exists($GLOBALS['__WE_LIB_PATH__'] . $relPath)) {
				return $GLOBALS['__WE_LIB_URL__'] . $relPath;
			}
		
		} else {
			$parts = explode('_', $classname);
			$appName = $parts[0];
			
			$relPath = '/' . $appName . '/' . WE_APP_THEMES_DIR . '/' . WE_THEME_NAME . '/' . $classname . '/' . $filename;
			if (file_exists($GLOBALS['__WE_APP_PATH__'] . $relPath)) {
				return $GLOBALS['__WE_APP_URL__'] . $relPath;
			}
			
			$relPath = '/' . $appName . '/' . WE_APP_THEMES_DIR . '/' . WE_DEFAULT_THEME_NAME . '/' . $classname . '/' . $filename;
			if (file_exists($GLOBALS['__WE_APP_PATH__'] . $relPath)) {
				return $GLOBALS['__WE_APP_URL__'] . $relPath;
			}
		}
		return '';
	}
}
