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
 * this class implements the functionality for caching documents
 *
 * @category   webEdition
 * @package    webEdition_base
 *
 */
class weDocumentCache extends weCache
{

	/**
	 * Constructor for PHP4
	 *
	 * @param string $weDoc
	 * @param integer $lifeTime
	 * @return weTagCache
	 * @access public
	 */
	function weDocumentCache($weDoc, $lifeTime)
	{
		
		$this->__construct($weDoc, $lifeTime);
	
	}

	/**
	 * Constructor for PHP5
	 *
	 * @param string $weDoc
	 * @param integer $lifeTime
	 * @access public
	 */
	function __construct($weDoc, $lifeTime)
	{
		
		if (!isset($GLOBALS['weDocCache']["weDoc:" . $weDoc])) {
			$GLOBALS['weDocCache']["weDoc:" . $weDoc] = 0;
		}
		$GLOBALS['weDocCache']["weDoc:" . $weDoc]++;
		
		parent::__construct($lifeTime);
		
		$this->_createCacheId($weDoc);
	
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

	function start()
	{
		
		if ($this->isValid()) {
			return false;
		
		}
		
		ignore_user_abort(true);
		
		ob_start();
		
		if ($GLOBALS['we_doc']->CacheType != "full") {
			echo '<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tag.inc.php");
?>';
		}
		
		return true;
	
	}

	/**
	 * creates an unique id
	 *
	 * @param string $weDoc
	 * @return string
	 * @access private
	 */
	function _createCacheId($weDoc)
	{
		
		$cacheIdentifier = array(
			
				"we:" . $weDoc => $GLOBALS['weDocCache']["weDoc:" . $weDoc], 
				'params' => isset($_REQUEST) ? $_REQUEST : array()
		);
		return parent::_createCacheId($cacheIdentifier);
	
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
		
		return "document_" . $id . ".php";
	
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
		
		return ereg_replace("^document_", ereg_replace(".php$", $filename));
	
	}

}

?>