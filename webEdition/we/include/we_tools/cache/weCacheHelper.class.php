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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_live_tools.inc.php");

/**
 * this class implements some helper functions for caching
 * like deleting cache, 
 *
 * @category   webEdition
 * @package    webEdition_base
 */
class weCacheHelper
{

	/**
	 * static function
	 * get the directory name of the cache
	 *
	 * @return string
	 * @access public
	 */
	function getCacheDir()
	{
		
		if (defined("CACHING_INSIDE_WEBEDITION")) {
			$WE_CACHE_DIR = TMP_DIR . "/cache/";
		
		} else {
			$WE_CACHE_DIR = $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/cache/";
		
		}
		$dirname = $WE_CACHE_DIR;
		
		if (!file_exists($dirname)) {
			createLocalFolder($dirname);
		
		}
		
		if (!eregi("/$", $dirname)) {
			$dirname .= DIRECTORY_SEPARATOR;
		}
		
		return $dirname;
	
	}

	/**
	 * static function
	 * get the directory name of the document cache
	 *
	 * @param string $type
	 * @param integer $id
	 * @return string
	 * @access public
	 */
	function getDocumentCacheDir($id = 0)
	{
		
		$dirname = weCacheHelper::getCacheDir();
		
		$dirname .= "document" . DIRECTORY_SEPARATOR;
		
		if ($id == 0) {
			return $dirname;
		
		} else {
			return $dirname . $id . DIRECTORY_SEPARATOR;
		}
	
	}

	/**
	 * static function
	 * get the directory name of the object cache
	 *
	 * @param string $type
	 * @param integer $id
	 * @return string
	 * @access public
	 */
	function getObjectCacheDir($id = 0)
	{
		
		$dirname = weCacheHelper::getCacheDir();
		
		$dirname .= "object" . DIRECTORY_SEPARATOR;
		
		if ($id == 0) {
			return $dirname;
		
		} else {
			return $dirname . $id . DIRECTORY_SEPARATOR;
		}
	
	}

	/**
	 * static function
	 * calculate the size of the cache directory
	 *
	 * @param string $dir
	 * @return float
	 * @access public
	 */
	function getCacheSize($dir = "")
	{
		
		if ($dir == "") {
			$dir = weCacheHelper::getCacheDir();
		
		}
		
		$size = 0;
		
		$dir .= !eregi("/$", $dir) ? DIRECTORY_SEPARATOR : "";
		
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry != '..') {
				if (is_dir($dir . $entry)) {
					$size += weCacheHelper::getSize($dir . $entry . '/');
				
				} else {
					$size += filesize($dir . $entry);
				
				}
			
			}
		}
		
		$d->close();
		return $size;
	
	}

	/**
	 * static function
	 * delete all cachefiles from the given directory
	 *
	 * @param string $dir
	 * @return boolean
	 * @access public
	 */
	function clearCache($dir = "")
	{
		
		if ($dir == "") {
			$dir = weCacheHelper::getCacheDir();
		
		}
		
		$dir .= !eregi("/$", $dir) ? DIRECTORY_SEPARATOR : "";
		if (!file_exists($dir) || !is_dir($dir)) {
			return true;
		}
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry != '..') {
				if (is_dir($dir . $entry)) {
					if (!weCacheHelper::clearCache($dir . $entry . '/')) {
						return false;
					
					}
				
				} else {
					if (!unlink($dir . $entry)) {
						return false;
					
					}
				
				}
			
			}
		
		}
		
		$d->close();
		
		return rmdir($dir);
	
	}

	/**
	 * static function
	 * optimize the cache dir, deletes old cache files 
	 *
	 * @param string $dir
	 * @param string $maxCacheSize
	 * @return boolean
	 * @access public
	 * @todo not completely implemented yet
	 */
	function optimizeCache($dir = "", $maxCacheSize = "1mb")
	{
		
		if ($dir == "") {
			$dir = weCacheHelper::getCacheDir();
		
		}
		
		preg_match_all("/(.*[0-9])+(.*[b|kb|mb|gb])/", $maxCacheSize, $matches);
		
		if ($matches[2][0] == "kb") {
			$maxCacheSize = $matches[1][0] * 1024;
		
		} else 
			if ($matches[2][0] == "mb") {
				$maxCacheSize = $matches[1][0] * 1024 * 1024;
			
			} else 
				if ($matches[2][0] == "gb") {
					$maxCacheSize = $matches[1][0] * 1024 * 1024 * 1024;
				
				} else {
					$maxCacheSize = $matches[1][0];
				
				}
		
		$size = weCacheHelper::getCacheSize($dir);
	
	}

}

?>