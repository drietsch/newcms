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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
include_once(WE_GLOSSARY_MODULE_DIR."weGlossary.php");

/**
 * this class implements the cache functionality for the glossary
 * 
 */
class weGlossaryCache {
	
	/**
	 * language of the cache
	 *
	 * @var string
	 */
	var $language = "";
	
	/**
	 * internal id of the cache
	 *
	 * @var string
	 */
	var $_cacheId = "";
	
	
	/**
	 * PHP5 Constructor
	 *
	 * @param string $language
	 */
	function __construct($language) {
		
		$this->weGlossaryCache($language);
		
	}
	
	
	/**
	 * PHP4 Constructor
	 *
	 * @param string $language
	 * @return GlossaryCache
	 */
	function weGlossaryCache($language) {
		
		$this->language = $language;
		
		$this->_createCacheId();
		
	}
	
	
	/**
	 * Create the cache identifier
	 *
	 * @access private
	 */
	function _createCacheId() {
		
		$this->_cacheId = $this->language;
		
	}
	
	
	/**
	 * get the cache filename of a given cache id
	 *
	 * @param string $id
	 * @return string
	 * @access public
	 * @abstract 
	 */
	function cacheIdToFilename($id) {
		
		return WE_GLOSSARY_MODULE_DIR . "cache/cache_" . $id . ".php";
		
	}
	
	
	/**
	 * get the cache id of a given cache filename
	 *
	 * @param string $filename
	 * @return string
	 * @access public
	 * @abstract 
	 */
	function filenameToCacheId($filename) {
		
		return ereg_replace("^" . WE_GLOSSARY_MODULE_DIR . "data/cache_", ereg_replace(".php$", $filename));
		
	}
	
	
	/**
	 * checks if the cache file is valid
	 *
	 * @return boolean
	 */
	function isValid() {
		
		$cacheFilename = weGlossaryCache::cacheIdToFilename($this->_cacheId);
		
		return file_exists($cacheFilename) && is_file($cacheFilename);
		
	}
	
	
	/**
	 * deletes the cache file
	 *
	 * @return boolean
	 */
	function clear() {
		
		if($this->isValid()) {
			return unlink(weGlossaryCache::cacheIdToFilename($this->_cacheId));
			
		}
		return true;
		
	}
	
	
	/**
	 * write the given entries into the cache file
	 *
	 * @return boolean
	 */
	function write() {
		
		$DB_WE = new DB_WE();
		
		$query = "SELECT Text, Type, Language, Title, Attributes, LENGTH(Text) as Length FROM " . GLOSSARY_TABLE . " WHERE Language = '" . $this->language . "' AND Published > 0 ORDER BY Length DESC";
		
		$DB_WE->query($query);
		$Items = array();
		
		while($DB_WE->next_record()) {
			$Text = $DB_WE->f('Text');
			$Type = $DB_WE->f('Type');
			$Title = $DB_WE->f('Title');
			$Attributes = unserialize($DB_WE->f('Attributes'));
		
			$temp = array();

			if(stristr($GLOBALS['WE_LANGUAGE'], '_UTF-8') === TRUE && isset($GLOBALS['we_doc']->elements['Charset']['dat']) && $GLOBALS['we_doc']->elements['Charset']['dat']!='UTF-8') {
				$Text = utf8_decode($Text);
				$Title = utf8_decode($Title);
			}

			$Text = htmlspecialchars($Text, ENT_NOQUOTES);

			$Text = weGlossary::escapeChars($Text);
			
			$Title = htmlspecialchars($Title, ENT_QUOTES);
			
			if(trim($Title) != "") {
				$temp['title'] = trim($Title);
			}
			
			// Language
			if(isset($Attributes['lang']) && trim($Attributes['lang']) != "") {
				$temp['lang'] = trim($Attributes['lang']);
				$temp['xml:lang'] = trim($Attributes['lang']);
			}
			
			$attributes = "";
			
			// Language
			if($Type == 'link') {
				
				$urladd = "";
				
				// External Link
				if(isset($Attributes['mode']) && trim($Attributes['mode']) == "extern") {
					
					// Href
					$temp['href'] = "";
					if(isset($Attributes['ExternUrl']) && trim($Attributes['ExternUrl']) != ""&& trim($Attributes['ExternUrl']) != "http://") {
						$temp['href'] .= trim($Attributes['ExternUrl']);
					}
					
					// Parameter
					if(isset($Attributes['ExternParameter']) && trim($Attributes['ExternParameter']) != "") {
						$urladd .= ($urladd ? $urladd . '&' : '?') . trim($Attributes['ExternParameter']);
					}
					
				// Internal Link
				} else if(isset($Attributes['mode']) && trim($Attributes['mode']) == "intern") {
											
					// LinkID
					$temp['href'] = "";
					if(isset($Attributes['InternLinkID']) && trim($Attributes['InternLinkID']) != 0) {
						$temp['href'] .= id_to_path($Attributes['InternLinkID']);
					}
					
					// Parameter
					if(isset($Attributes['InternParameter']) && trim($Attributes['InternParameter']) != "") {
						$urladd = ($urladd ? $urladd . '&' : '?') . trim($Attributes['InternParameter']);
					}
					
				// Object Link
				} else if(isset($Attributes['mode']) && trim($Attributes['mode']) == "object") {
					
					// LinkID
					$temp['href'] = "";
					if(isset($Attributes['ObjectLinkPath']) && trim($Attributes['ObjectLinkPath']) != "") {
						$temp['href'] .= trim($Attributes['ObjectLinkPath']);
					}
					
					if(isset($Attributes['ObjectLinkID']) && trim($Attributes['ObjectLinkID']) != "") {
						$urladd = ($urladd ? $urladd . '&' : '?') . 'we_objectID=' . trim($Attributes['ObjectLinkID']);
					}
					
					// Parameter
					if(isset($Attributes['ObjectParameter']) && trim($Attributes['ObjectParameter']) != "") {
						$urladd = ($urladd ? $urladd . '&' : '?') . trim($Attributes['ObjectParameter']);
					}
					
				// Category Link
				} else if(isset($Attributes['mode']) && trim($Attributes['mode']) == "category") {
					
					$temp['href'] = "";
					if(isset($Attributes['modeCategory']) && trim($Attributes['modeCategory']) == "intern") {
												
						// LinkID
						if(isset($Attributes['CategoryInternLinkID']) && trim($Attributes['CategoryInternLinkID']) != "") {
							$temp['href'] .= id_to_path($Attributes['CategoryInternLinkID']);
						}
						
					} else {
						
						// Href
						if(isset($Attributes['CategoryUrl']) && trim($Attributes['CategoryUrl']) != "") {
							$temp['href'] .= trim($Attributes['CategoryUrl']);
						}
						
					}
						
					// Cat Parameter & Cat ID
					if(isset($Attributes['CategoryCatParameter']) && trim($Attributes['CategoryCatParameter']) != ""
						&& isset($Attributes['CategoryLinkID']) && trim($Attributes['CategoryLinkID']) != "") {
						$urladd = ($urladd ? $urladd . '&' : '?') . trim($Attributes['CategoryCatParameter']) . "=" . trim($Attributes['CategoryLinkID']);
						
					}
						
					// Parameter
					if(isset($Attributes['CategoryParameter']) && trim($Attributes['CategoryParameter']) != "") {
						$urladd = ($urladd ? $urladd . '&' : '?') . trim($Attributes['CategoryParameter']);
					}
					
				}
					
				// Attribute
				if(isset($Attributes['attribute']) && trim($Attributes['attribute']) != "") {
					$temp['attribute'] = " ".addslashes(trim($Attributes['attribute']) . " ");
				}
					
				// Anchor
				if(isset($Attributes['anchor']) && trim($Attributes['anchor']) != "") {
					$urladd .= '#' . trim($Attributes['anchor']);
				}
					
				// Target
				if(isset($Attributes['target']) && trim($Attributes['target']) != "") {
					$temp['target'] = trim($Attributes['target']);
				}
					
				// hreflang
				if(isset($Attributes['hreflang']) && trim($Attributes['hreflang']) != "") {
					$temp['hreflang'] = trim($Attributes['hreflang']);
				}
					
				// Accesskey
				if(isset($Attributes['accesskey']) && trim($Attributes['accesskey']) != "") {
					$temp['accesskey'] = trim($Attributes['accesskey']);
				}
					
				// tabindex
				if(isset($Attributes['tabindex']) && trim($Attributes['tabindex']) != "") {
					$temp['tabindex'] = trim($Attributes['tabindex']);
				}
					
				// rel
				if(isset($Attributes['rel']) && trim($Attributes['rel']) != "") {
					$temp['rel'] = trim($Attributes['rel']);
				}
					
				// rev
				if(isset($Attributes['rev']) && trim($Attributes['rev']) != "") {
					$temp['rev'] = trim($Attributes['rev']);
				}
				
				$temp['href'] .= $urladd;
				
				// popup_open
				if(isset($Attributes['popup_open']) && $Attributes['popup_open'] == 1) {
					
					$temp['onclick'] = "var we_winOpts = '';";
						
					// popup_width
					if(isset($Attributes['popup_width']) && trim($Attributes['popup_width']) != "") {
						$width = trim($Attributes['popup_width']);
					} else {
						$width = 100;
					}
					
					// popup_height
					if(isset($Attributes['popup_height']) && trim($Attributes['popup_height']) != "") {
						$height = trim($Attributes['popup_height']);
					} else {
						$height = 100;
					}
					
					// popup_center
					if(isset($Attributes['popup_center']) && trim($Attributes['popup_center']) != "") {
						$temp['onclick'] .= 		"if (window.screen) {"
											.	"var w=" . $width . ";"
											.	"var h=" . $height . ";"
											.	"var screen_height = screen.availHeight - 70;"
											.	"var screen_width = screen.availWidth-10;"
											.	"var w = Math.min(screen_width,w);"
											.	"var h = Math.min(screen_height,h);"
											.	"var h = Math.min(screen_height,h);"
											.	"var x = (screen_width - w) / 2;"
											.	"var y = (screen_height - h) / 2;"
											.	"we_winOpts = 'left='+x+',top='+y;"
											.	"} else {"
											.	"we_winOpts='';"
											.	"}";
						
					} else {
						
						// popup_xposition
						if(isset($Attributes['popup_xposition']) && trim($Attributes['popup_xposition']) != "") {
							$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'left=" . trim($Attributes['popup_xposition']) ."';";
						}
							
						// popup_yposition
						if(isset($Attributes['popup_yposition']) && trim($Attributes['popup_yposition']) != "") {
							$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'top=" . trim($Attributes['popup_yposition']) ."';";
						}
				
					}
					
					// popup_width
					$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'width=" . $width ."';";
						
					// popup_height
					$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'height=" . $height ."';";
						
					// popup_status
					if(isset($Attributes['popup_status']) && $Attributes['popup_status'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'status=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'stytus=no';";
					}
						
					// popup_scrollbars
					if(isset($Attributes['popup_scrollbars']) && $Attributes['popup_scrollbars'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'scrollbars=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'scrollbars=no';";
					}
						
					// popup_menubar
					if(isset($Attributes['popup_menubar']) && $Attributes['popup_menubar'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'menubar=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'menubar=no';";
					}
						
					// popup_resizable
					if(isset($Attributes['popup_resizable']) && $Attributes['popup_resizable'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'resizable=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'resizable=no';";
					}
						
					// popup_location
					if(isset($Attributes['popup_location']) && $Attributes['popup_location'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'location=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'location=no';";
					}
						
					// popup_toolbar
					if(isset($Attributes['popup_toolbar']) && $Attributes['popup_toolbar'] == 1) {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'toolbar=yes';";
					} else {
						$temp['onclick'] .= "we_winOpts += (we_winOpts ? ',' : '')+'toolbar=no';";
					}
					
					$temp['onclick'] .= "var we_win = window.open('" . $temp['href'] . "','we_test',we_winOpts);";
					
					$temp['onclick'] = str_replace("'", "@@@we@@@", $temp['onclick']);
				
					$temp['href'] = "#";
					
				}
				
			}
			
			$Items[$Text][$Type] = $temp;
			
		}
	
		$Link = 	"\n"
				.	"\$link = array(\n";
					
		$Acronym = 		"\n"
					.	"\$acronym = array(\n";
					
		$Abbreviation =		"\n"
						.	"\$abbreviation = array(\n";
					
		$ForeignWord =  	"\n"
						.	"\$foreignword = array(\n";
		
		foreach($Items as $Text => $Value) {
			
			$prefix = "";
			$postfix = "";
			foreach($Value as $Type => $AttributeList) {
			
				switch($Type) {
					
					case 'link':
						$Tag = 'a';
						$PushTo = 'Link';
						break;
						
					case 'acronym':
						$Tag = 'acronym';
						$PushTo = 'Acronym';
						break;
						
					case 'abbreviation':
						$Tag = 'abbr';
						$PushTo = 'Abbreviation';
						break;
						
					case 'foreignword':
						$Tag = 'span';
						$PushTo = 'ForeignWord';
						break;
						
				}
				
				$prefix .= "<" . $Tag;
				foreach($AttributeList as $Attribute => $Val) {
					if($Attribute == 'attribute') {
						$prefix .= $Val;
						
					} else {
						$prefix .= ' ' . $Attribute . '=\"' . $Val . '\"';
						
					}
											
				}
				$prefix .= '>';
				$postfix = '</' . $Tag . '>' . $postfix;

				
			}
			$$PushTo	.=	'"/((<[^>]*)|([^[:alnum:]])('.$Text.')([^[:alnum:]]))/e" => \'"\2"=="\1"?"\1":"\3' . $prefix . '\4' . $postfix . '\5"\'' . ",\n";

		}
		
		$Link	.=		");\n"
					.	"";
		
		$Acronym	.=		");\n"
						.	"";
		
		$Abbreviation	.=		");\n"
							.	"";
		
		$ForeignWord	.=		");\n"
							.	"";
										
		$cacheFilename = weGlossaryCache::cacheIdToFilename($this->_cacheId);
		
		// Create Cache Directory if it not exists
		if(!is_dir(dirname($cacheFilename))) {
			if(!createLocalFolder(dirname($cacheFilename))) {
				return false;
				
			}
			
		}
		
		$fh = fopen($cacheFilename, "w+");
		if(!$fh) {
			return false;
		}
		
		if(!fputs($fh, "<?php\n" . $Link . "\n" . $Acronym . "\n" . $Abbreviation . "\n" . $ForeignWord . "\n?>")) {
			return false;
			
		}
		
		fclose($fh);
		
		return true;
		
	}
	
	
	/**
	 * get all entries from the cache
	 *
	 * @return array
	 */
	function get($type) {
		$cacheFilename = weGlossaryCache::cacheIdToFilename($this->_cacheId);
		
		if(!file_exists($cacheFilename) || !is_file($cacheFilename)) {
			if(!weGlossaryCache::write()) {
				return array();
			}
		}
		include($cacheFilename);
		
		if(isset($$type)) {
			return $$type;
			
		}
		return array();
		
	}
	
	
}


?>