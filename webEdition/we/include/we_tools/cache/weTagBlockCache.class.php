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

/**
 * this class implements the functionality for caching we:block
 *
 * @category   webEdition
 * @package    webEdition_base
 */
class weTagBlockCache extends weCache
{

	/**
	 * Constructor for PHP4
	 *
	 * @param array $params
	 * @param string $content
	 * @param integer $lifeTime
	 * @return weTagBlockCache
	 * @access public
	 */
	function weTagBlockCache($weTag, $params, $content, $lifeTime)
	{
		
		$this->__construct($weTag, $params, $content, $lifeTime);
	
	}

	/**
	 * Constructor for PHP5
	 *
	 * @param string $weTag
	 * @param array $params
	 * @param string $content
	 * @param integer $lifeTime
	 * @access public
	 */
	function __construct($weTag, $params, $content, $lifeTime = 0)
	{
		
		// increment a counter foreach time this cache type is used
		if (!isset($GLOBALS['weTagBlockCacheCounter'])) {
			$GLOBALS['weTagBlockCacheCounter'] = 0;
		}
		$GLOBALS['weTagBlockCacheCounter']++;
		
		if (!isset($GLOBALS['weTagBlockCache'])) {
			$GLOBALS['weTagBlockCache'] = 0;
		}
		
		parent::__construct($lifeTime);
		
		$this->_createCacheId($weTag, $params, $content);
	
	}

	/**
	 * Destructor
	 *
	 * @access private
	 */
	function __destruct()
	{
		
		parent::__destruct();
	}

	/**
	 * creates an unique id
	 *
	 * @param array $params
	 * @param string $content
	 * @return string
	 * @access private
	 */
	function _createCacheId($weTag, $params = array(), $content)
	{
		
		$cacheIdentifier = array(
			"we:" . $weTag => $GLOBALS['weTagBlockCacheCounter'], 'params' => $params, 'content' => $content
		);
		
		parent::_createCacheId($cacheIdentifier);
	
	}

	/**
	 * get the cache filename of a given cache id
	 *
	 * @param string $id
	 * @return string
	 * @access private
	 */
	function _cacheIdToFilename($id)
	{
		
		return "weTagBlock_" . $id . ".php";
	
	}

	/**
	 * get the cache id of a given cache filename
	 *
	 * @param string $filename
	 * @return string
	 * @access private
	 */
	function _filenameToCacheId($filename)
	{
		
		return ereg_replace("^weTagBlock_", ereg_replace(".php$", $filename));
	
	}

	/**
	 * defines the end of a cacheable block an write the content to the 
	 * cache file
	 *
	 * @return boolean
	 */
	function start()
	{
		
		$GLOBALS['weTagBlockCache']++;
		return parent::start();
	
	}

	/**
	 * check if a cache is not valid. if so, cache the whole output 
	 * since the method end() is called
	 *
	 * @return booelan
	 */
	function end()
	{
		
		$retVal = parent::end();
		$GLOBALS['weTagBlockCache']--;
		return $retVal;
	
	}

	/**
	 * write the cache file
	 *
	 * @return boolean
	 * @access public
	 */
	function write()
	{
		
		if ($this->isValid()) {
			return true;
		
		}
		$this->delete();
		
		$cacheFile = $this->getCacheFilename();
		
		$fh = fopen($cacheFile, "w+");
		
		if (!$fh)
			return false;
		
		ob_start();
		eval("?>" . $this->_cache);
		$content = ob_get_contents();
		ob_end_clean();
		
		fputs($fh, $content);
		
		return fclose($fh);
	
	}

	function isCacheable()
	{
		
		if ($this->lifeTime < 1 || $GLOBALS['weTagBlockCache'] > 0) {
			return false;
		
		}
		return true;
	
	}

}

?>