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

/**
 * this class implements the functionality for caching block we:tags
 *
 * @category   webEdition
 * @package    webEdition_base
 * @package weCache
 */
class weTagListviewCache extends weCache
{

	var $Counter = null;

	function init(&$obj, $weTag, $params, $content, $lifeTime)
	{
		
		// if not caching started create new instance
		if (!isset($GLOBALS["weTagListviewCacheActive"]) || !$GLOBALS["weTagListviewCacheActive"]) {
			$obj = new weTagListviewCache($weTag, $params, $content, $lifeTime);
			$GLOBALS["weTagListviewCacheActive"] = false;
		}
	
	}

	/**
	 * Constructor for PHP4
	 *
	 * @param array $params
	 * @param string $content
	 * @param integer $lifeTime
	 * @return weTagLBlockCache
	 * @access public
	 */
	function weTagListviewCache($weTag, $params, $content, $lifeTime)
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
		
		if (!isset($GLOBALS['weTagListviewCacheCounter'])) {
			$GLOBALS['weTagListviewCacheCounter'] = 0;
		}
		$GLOBALS['weTagListviewCacheCounter']++;
		
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

	function increase()
	{
		
		$this->Counter++;
	
	}

	function decrease()
	{
		
		$this->Counter--;
	
	}

	function start()
	{
		
		if ($GLOBALS["weTagListviewCacheActive"]) {
			$this->increase();
		
		} else 
			if (!$GLOBALS["weTagListviewCacheActive"] && parent::start()) {
				$this->Counter = 1;
				$GLOBALS["weTagListviewCacheActive"] = true;
				
				return true;
			
			}
		return false;
	
	}

	function end()
	{
		
		if ($GLOBALS["weTagListviewCacheActive"] == true) {
			$this->decrease();
			if ($this->Counter === 0) {
				$GLOBALS["weTagListviewCacheActive"] = false;
				return parent::end();
			
			}
		
		}
		return true;
	
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
			"we:" . $weTag => $GLOBALS['weTagListviewCacheCounter'], 'params' => $params, 'content' => $content
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
		
		return "weTagListview_" . $id . ".php";
	
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
		
		return ereg_replace("^weTagListview_", ereg_replace(".php$", $filename));
	
	}

	function isCacheable()
	{
		
		if ($GLOBALS["weTagListviewCacheActive"]) {
			$this->increase();
		
		}
		
		if ($this->lifeTime > 0 && !$GLOBALS["weTagListviewCacheActive"]) {
			return true;
		
		}
		
		return false;
	
	}

}

?>