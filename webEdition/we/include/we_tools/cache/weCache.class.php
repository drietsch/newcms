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
 * this class implements the basic functions for caching
 *
 * @category   webEdition
 * @package    webEdition_base
 * @uses weCacheHelper
 */
class weCache
{

	/**
	 * Output whiche have to be cached
	 *
	 * @var string
	 * @access private
	 */
	var $_cache;

	/**
	 * Id of the cacheable block
	 *
	 * @var string
	 * @access private
	 */
	var $Id = "";

	/**
	 * Id of the content
	 *
	 * @var integer
	 * @access private
	 */
	var $ContentId = 0;

	/**
	 * Type of content (document|object)
	 *
	 * @var string
	 * @access private
	 */
	var $ContentType = "";

	/**
	 * lifetime in seconds of the cache
	 *
	 * @var integer
	 * @access private
	 */
	var $lifeTime = 0;

	/**
	 * Constructor for PHP4
	 *
	 * @param integer $lifeTime
	 * @return weCache
	 * @access public
	 */
	function weCache($lifeTime = 0)
	{
		
		$this->__construct($lifeTime);
	
	}

	/**
	 * Constructor for PHP5
	 *
	 * @param integer $lifeTime
	 * @access public
	 */
	function __construct($lifeTime = 0)
	{
		
		$this->lifeTime = $lifeTime;
		
		if (!isset($GLOBALS["WE_MAIN_DOC"]) && isset($_REQUEST["we_objectID"])) {
			$this->ContentId = $_REQUEST["we_objectID"];
			$this->ContentType = 'object';
		
		} elseif (isset($_REQUEST["we_cmd"][1])) {
			$this->ContentId = $_REQUEST["we_cmd"][1];
			$this->ContentType = 'document';
		
		} else {
			$this->ContentId = isset($GLOBALS["WE_MAIN_DOC"]->ID) ? $GLOBALS["WE_MAIN_DOC"]->ID : $GLOBALS["we_doc"]->ID;
			$this->ContentType = 'document';
		
		}
	
	}

	/**
	 * Destructor
	 *
	 * @access private
	 */
	function __destruct()
	{
	
	}

	/**
	 * adds some content to the cache
	 *
	 * @param string $content
	 * @access protected
	 */
	function _addToCache($content)
	{
		
		// Bug Fix #8727
		// replace <?xml when short_open_tags are allowed.
		if (ini_get("short_open_tag") == 1) {
			$content = str_replace("<?xml", '<?php print "<?php print \'<?xml\'; ?>"; ?>', $content);
		}
		$this->_cache .= $content;
	
	}

	/**
	 * check if a cache is not valid. if so, cache the whole output 
	 * since the method end() is called
	 *
	 * @return boolean
	 * @access public
	 */
	function start()
	{
		
		if ($this->isValid()) {
			return false;
		
		}
		
		ignore_user_abort(true);
		
		ob_start();
		return true;
	
	}

	/**
	 * defines the end of a cacheable block an write the content to the 
	 * cache file
	 *
	 * @return boolean
	 * @access public
	 */
	function end()
	{
		
		$this->_addToCache(ob_get_contents());
		ob_end_clean();
		
		if ($this->write()) {
			return true;
		
		}
		
		return false;
	
	}

	/**
	 * create a unique identifier
	 *
	 * @param array $cacheIdentifier
	 * @return string
	 * @access protected
	 */
	function _createCacheId($cacheIdentifier = array())
	{
		
		$temp = array(
			
				'DocumentID' => (isset($_REQUEST['we_cmd'][1]) ? $_REQUEST['we_cmd'][1] : null), 
				'TemplateID' => (isset($_REQUEST['we_cmd'][4]) ? $_REQUEST['we_cmd'][4] : null), 
				'objectID' => (isset($_REQUEST['we_objectID']) ? $_REQUEST['we_objectID'] : null), 
				'uri' => WE_SERVER_REQUEST_URI, 
				'method' => (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null)
		);
		
		$this->Id = md5('weCache_' . serialize(array_merge($cacheIdentifier, $temp)));
		
		return $this->Id;
	
	}

	/**
	 * get the cache identifier
	 *
	 * @return string
	 * @access public
	 */
	function getCacheId()
	{
		
		return $this->Id;
	
	}

	/**
	 * get the cache filename of a given cache id
	 *
	 * @param string $id
	 * @return string
	 * @access private
	 * @abstract 
	 */
	function _cacheIdToFilename($id)
	{
		
		return "cache_" . $id . ".php";
	
	}

	/**
	 * get the cache id of a given cache filename
	 *
	 * @param string $filename
	 * @return string
	 * @access private
	 * @abstract 
	 */
	function _filenameToCacheId($filename)
	{
		
		return ereg_replace("^cache_", ereg_replace(".php$", $filename));
	
	}

	/**
	 * write the cahce file
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
		
		fputs($fh, $this->_cache);
		
		return fclose($fh);
	
	}

	/**
	 * get the content of the cache
	 *
	 * @return string
	 * @access public
	 */
	function get()
	{
		
		$cacheFile = $this->getCacheFilename();
		
		if (!file_exists($cacheFile) || !$this->write()) {
			return $this->_cache;
		
		}
		
		return implode("", file($cacheFile));
	
	}

	/**
	 * delete the cache file
	 *
	 * @return boolean
	 * @access public
	 */
	function delete()
	{
		
		$cacheFile = $this->getCacheFilename();
		
		if (file_exists($cacheFile) && is_file($cacheFile)) {
			return unlink($cacheFile);
		
		}
		return true;
	
	}

	/**
	 * check if the cache is valid or not
	 *
	 * @return boolean
	 * @access public
	 */
	function isValid()
	{
		
		$cacheFile = $this->getCacheFilename();
		
		if (!file_exists($cacheFile)) {
			return false;
		
		}
		
		if (filemtime($cacheFile) + $this->lifeTime >= time()) {
			return true;
		
		}
		return false;
	
	}

	/**
	 * get the whole cachefilename including path
	 *
	 * @return string
	 * @access public
	 */
	function getCacheFilename()
	{
		
		$filename = weCacheHelper::getCacheDir() . $this->ContentType;
		
		if (!file_exists($filename)) {
			createLocalFolder($filename);
		
		}
		
		$filename .= DIRECTORY_SEPARATOR . $this->ContentId;
		
		if (!file_exists($filename)) {
			createLocalFolder($filename);
		
		}
		
		$filename .= DIRECTORY_SEPARATOR . $this->_cacheIdToFilename($this->getCacheId());
		
		return $filename;
	
	}

}

?>