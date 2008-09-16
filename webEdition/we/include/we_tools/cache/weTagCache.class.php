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
 * this class implements the functionality for caching we:tags
 *
 * @category   webEdition
 * @package    webEdition_base
 */
class weTagCache extends weCache
{

	/**
	 * weTag which have to be cached
	 *
	 * @var string
	 */
	var $_weTag = "";

	/**
	 * Attributes of the we:tag which have to be cached
	 *
	 * @var array
	 */
	var $_params = array();

	/**
	 * Constructor for PHP4
	 *
	 * @param string $weTag
	 * @param array $params
	 * @param string $content
	 * @param integer $lifeTime
	 * @return weTagCache
	 * @access public
	 */
	function weTagCache($weTag, $params, $content, $lifeTime)
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
		
		if ($GLOBALS['we_doc']->CacheType == "none") {
			$lifeTime = 0;
		}
		
		if (!isset($GLOBALS['weTagCache']["we:" . $weTag])) {
			$GLOBALS['weTagCache']["we:" . $weTag] = 0;
		}
		$GLOBALS['weTagCache']["we:" . $weTag]++;
		
		// The we:navigation-tags are special, so we have to do some extra
		// work
		

		// override the cachelifetime of the actual we:tag with the cachelifetime of
		// the corresponding we:navigation-tag
		if (strtolower($weTag) == 'navigationwrite' || strtolower($weTag) == 'navigationentry') {
			$GLOBALS['weTagCache']['navigation']['navigationname'] = isset($params['navigationname']) ? $params['navigationname'] : "default";
			$lifeTime = $GLOBALS['weTagCache']['navigation'][$GLOBALS['weTagCache']['navigation']['navigationname']]['cachelifetime'];
			
		// override the cachelifetime of the actual we:tag with the cachelifetime of
		// the corresponding we:navigation-tag
		} else 
			if (strtolower($weTag) == 'navigationentries' || strtolower($weTag) == 'navigationfield') {
				
				$params['navigationname'] = $GLOBALS['weTagCache']['navigation']['navigationname'];
				$lifeTime = $GLOBALS['weTagCache']['navigation'][$params['navigationname']]['cachelifetime'];
				
			// save the the cachelifetime we:navigation-tag for the other we:navigationXXX-tags, because
			// every we:navigationXXX-tag have the same lifetime as the we:navigation-tag
			} else 
				if (strtolower($weTag) == 'navigation') {
					$navigationname = isset($params['navigationname']) ? $params['navigationname'] : "default";
					$GLOBALS['weTagCache'][$weTag][$navigationname] = array(
						'navigationname' => $navigationname, 'cachelifetime' => $lifeTime
					)
					;
				
				}
		
		parent::__construct($lifeTime);
		
		$this->_weTag = $weTag;
		
		$this->_params = $params;
		
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
	 * @param string $weTag
	 * @param array $params
	 * @param string $content
	 * @return string
	 * @access private
	 */
	function _createCacheId($weTag, $params = array(), $content)
	{
		
		$cacheIdentifier = array(
			"we:" . $weTag => $GLOBALS['weTagCache']["we:" . $weTag], 'params' => $params, 'content' => $content
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
		
		return "weTag_" . $id . ".php";
	
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
		
		return ereg_replace("^weTag_", ereg_replace(".php$", $filename));
	
	}

	/**
	 * check if the Tag is cacheable
	 *
	 * @param string $weTag
	 * @return boolean
	 * @access public
	 */
	function isCacheable()
	{
		
		/*
			if(eregi("^if", $this->_weTag)) {
				$this->lifeTime = 0;
				return true;
			}
			*/
		
		if ($this->lifeTime < 1) {
			return false;
		
		}
		
		// the following tags are cacheable, to add a cacheable tag, only
		// put the tagname to this array
		$cacheableTags = array(
			
				'a', 
				'author', 
				'banner', 
				'bannerSelect', 
				'calculate', 
				'category', 
				'categorySelect', 
				'charset', 
				'checkForm', 
				'colorChooser', 
				'css', 
				'date', 
				'dateSelect', 
				'description', 
				'DID', 
				'docType', 
				'flashmovie', 
				'formfield', 
				'href', 
				'icon', 
				'img', 
				'input', 
				'js', 
				'keywords', 
				'link', 
				'listdir', 
				'navigation', 
				'navigationEntries', 
				'navigationEntry', 
				'navigationField', 
				'navigationWrite', 
				'path', 
				'printVersion', 
				'quicktime', 
				'registeredUser', 
				'returnPage', 
				'search', 
				'select', 
				'shopVat', 
				'subscribe', 
				'sum', 
				'target', 
				'textarea', 
				'title', 
				'url', 
				'userInput', 
				'var', 
				'xmlfeed', 
				
				// the following tags could be chached but we don't have to do so
				'addPercent', 
				'back', 
				'bannerSum', 
				'category', 
				'controlElement', 
				'field', 
				'hidePages', 
				'listviewEnd', 
				'listviewPageNr', 
				'listviewPages', 
				'listviewRows', 
				'listviewStart', 
				'position', 
				'postlink', 
				'prelink', 
				'sendMail'
		);
		
		// check if the tag is cacheable
		if (in_array($this->_weTag, $cacheableTags)) {
			return true;
		
		}
		
		// some tags have specific types which couldn't be cached. The following
		// array specifies which of these tags could be cached.
		// the first dimension specifies the tagname nad the second dimension which
		// type attribute of this tag is cacheable
		$cacheableTypeTags = array(
			
				'hidden' => array(
					'', 'request'
				), 
				'pagelogger' => array(
					'standard', 'fileseerver', 'download'
				), 
				'var' => array(
					
						'date', 
						'document', 
						'href', 
						'img', 
						'link', 
						'multiobject', 
						'property', 
						'request', 
						'select', 
						'shopVat'
				)
		);
		
		// check if the tag with the give type-attribute is cacheable
		if (array_key_exists($this->_weTag, $cacheableTypeTags)) {
			$type = isset($this->_params['type']) ? $this->_params['type'] : '';
			return in_array($type, $cacheableTypeTags[$this->_weTag]);
		
		}
		
		if ($this->_weTag == "setVar" && isset($this->_params['from']) && $this->_params['from'] == "listview") {
			return true;
		
		}
		
		return false;
	
	}

}

?>