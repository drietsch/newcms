<?php


	/**
	 * this class implements the functionality for caching documents
	 *
	 * @author Björn Böttle, bjoern.boettle@living-e.com
	 * @copyright living-e AG, 2000-2006
	 * @package weCache
	 */
	class weDocumentCache extends weCache {
		
		
		/**
		 * Constructor for PHP4
		 *
		 * @param string $weDoc
		 * @param integer $lifeTime
		 * @return weTagCache
		 * @access public
		 */
		function weDocumentCache($weDoc, $lifeTime) {
			
			$this->__construct($weDoc, $lifeTime);
			
		}
		
		
		/**
		 * Constructor for PHP5
		 *
		 * @param string $weDoc
		 * @param integer $lifeTime
		 * @access public
		 */
		function __construct($weDoc, $lifeTime) {
			
			if(!isset($GLOBALS['weDocCache']["weDoc:" . $weDoc])) {
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
		function __destruct() {
			
			parent::__destruct();
			
		}
		
		function start() {
			
			if($this->isValid()) {
				return false;
				
			}
			
			ignore_user_abort(true);
			
			ob_start();
			
			if($GLOBALS['we_doc']->CacheType != "full") {
				echo	 '<?php
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
		function _createCacheId($weDoc) {
			
			$cacheIdentifier = array(
				"we:" . $weDoc => $GLOBALS['weDocCache']["weDoc:" . $weDoc],
				'params' => isset($_REQUEST) ? $_REQUEST : array(),
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
		function _cacheIdToFilename($id) {
			
			return "document_" . $id . ".php";
			
		}
		
		
		/**
		 * get the cache id of a given cache filename
		 *
		 * @param string $filename
		 * @return string
		 * @access private
		 */
		function _filenameToCacheId($filename) {
			
			return ereg_replace("^document_", ereg_replace(".php$", $filename));
			
		}
		
		
	}
	
?>