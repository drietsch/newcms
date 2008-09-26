<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_live_tools.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weFile.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationItems.class.php');

class weNavigationCache
{

	function createCacheDir()
	{
		
		$_cacheDir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/cache/';
		if (!is_dir($_cacheDir)) {
			createLocalFolder($_cacheDir);
		}
		return $_cacheDir;
	}

	function cacheNavigationTree($id)
	{
		
		weNavigationCache::cacheNavigationBranch($id);
		weNavigationCache::cacheRootNavigation();
	
	}

	function cacheNavigationBranch($id)
	{
		
		$_cacheDir = weNavigationCache::createCacheDir();
		
		$_id = $id;
		$_c = 0;
		while ($_id != 0) {
			weNavigationCache::cacheNavigation($_id);
			$_id = f('SELECT ParentID FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $_id . ';', 'ParentID', new DB_WE());
			$_c++;
			if ($_c > 99999) {
				break;
			}
		}
	
	}

	function cacheRootNavigation()
	{
		
		$_cacheDir = weNavigationCache::createCacheDir();
		
		$_naviItemes = new weNavigationItems();
		
		$_naviItemes->initById(0);
		
		$_content = serialize($_naviItemes->items);
		
		weFile::save($_cacheDir . 'navigation_0.php', $_content);
		
		$_content = serialize($_naviItemes->currentRules);
		
		weFile::save($_cacheDir . 'rules.php', $_content);
	
	}

	function cacheNavigation($id)
	{
		
		$_cacheDir = weNavigationCache::createCacheDir();
		
		$_naviItemes = new weNavigationItems();
		
		$_naviItemes->initById($id);
		
		$_content = serialize($_naviItemes->items);
		
		weFile::save($_cacheDir . 'navigation_' . $id . '.php', $_content);
	
	}

}

?>