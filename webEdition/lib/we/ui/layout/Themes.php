<?php

define('WE_DEFAULT_THEME_NAME', 'default');
define('WE_THEMES_DIR', '/we/ui/themes');
define('WE_APP_THEMES_DIR', '/ui/themes');


if (!defined('WE_THEME_NAME')) {
	define('WE_THEME_NAME', WE_DEFAULT_THEME_NAME);
}


class we_ui_layout_Themes
{
	static public function computeCSSURL($classname, $filename='style.css') {
		if (substr($classname, 0, 3) == 'we_') {
			$relPath = WE_THEMES_DIR . '/' . WE_THEME_NAME .  '/' . $classname . '/' . $filename;
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

			$relPath = '/' . $appName . '/' . WE_APP_THEMES_DIR . '/' . WE_THEME_NAME .  '/' . $classname . '/' . $filename;	
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
