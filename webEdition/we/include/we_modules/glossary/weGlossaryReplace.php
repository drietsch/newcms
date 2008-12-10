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

	class weGlossaryReplace {
		
		
		/**
		 * defines the start of the content which have to be replaced
		 *
		 */
		function start() {
			
			$configFile = WE_GLOSSARY_MODULE_DIR . "/we_conf_glossary_settings.inc.php";
			if(!file_exists($configFile) || !is_file($configFile)) {
				include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossarySettingControl.class.php");
				weGlossarySettingControl::saveSettings(true);
			}
			include($configFile);
			
			if(isset($GLOBALS['weGlossaryAutomaticReplacement']) && $GLOBALS['weGlossaryAutomaticReplacement']) {
				ob_start();
				
			}
			
		}
		
		
		/**
		 * finish the output buffering and do the replacements
		 *
		 * @param unknown_type $language
		 */
		function end($language) {
			
			$configFile = WE_GLOSSARY_MODULE_DIR . "/we_conf_glossary_settings.inc.php";
			if(!file_exists($configFile) || !is_file($configFile)) {
				include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossarySettingControl.class.php");
				weGlossarySettingControl::saveSettings(true);
			}
			include($configFile);
			
			if(isset($GLOBALS['weGlossaryAutomaticReplacement']) && $GLOBALS['weGlossaryAutomaticReplacement']) {
				$content = ob_get_contents();
				ob_end_clean();
				echo weGlossaryReplace::doReplace($content, $language);
			
			}
				
		}
		
		
		/**
		 * replace the content
		 *
		 * @param unknown_type $content
		 * @param unknown_type $language
		 */
		function replace($content, $language) {
			
			$configFile = WE_GLOSSARY_MODULE_DIR . "/we_conf_glossary_settings.inc.php";
			if(!file_exists($configFile) || !is_file($configFile)) {
				include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossarySettingControl.class.php");
				weGlossarySettingControl::saveSettings(true);
			}
			include($configFile);
			if(isset($GLOBALS['weGlossaryAutomaticReplacement']) && $GLOBALS['weGlossaryAutomaticReplacement']) {
				return weGlossaryReplace::doReplace($content, $language);
				
			} else {
				return $content;
				
			}
			
				
		}
		
		
		/**
		 * replace all glossary items for the requested language in the
		 * given source code
		 *
		 * @param string $src
		 * @param string $language
		 * @return string
		 */
		function doReplace($src, $language) {
			
			if($language == "") {
				we_loadLanguageConfig();
				$language = $GLOBALS['weDefaultFrontendLanguage'];
			}
			
			// get the words to replace
			$cache = new weGlossaryCache($language);
			$cache->write();
			$foreignword = $cache->get('foreignword');
			$abbreviation = $cache->get('abbreviation');
			$acronym = $cache->get('acronym');
			$link = $cache->get('link');
			unset($cache);
			// first check if there is a body tag inside the sourcecode
			preg_match("/<body(.*)>(.*)<\/body>/siU", $src, $matches);
			
			if(isset($matches[0])) {
				// take the code between the body-tags
				$srcBody = $replBody = $matches[0];
				
			} else {
				// take the whole code
				$srcBody = $replBody = $src;
				
			}
			/*
			This is the fastest variant
			*/
			// split the source into tag and non-tag pieces
			$pieces = preg_split('!(<[^>]*>)!', $replBody, -1, PREG_SPLIT_DELIM_CAPTURE);
			// replace words in non-tag pieces
			$replBody = "";
			$before = "";
			foreach($pieces as $piece) {
				if (!ereg("^<", $piece) && !eregi("<script", $before)) {
					$piece = str_replace('&quot;', '"', $piece);
					if(!eregi("<a ", $before)) {
						$piece = weGlossaryReplace::doReplaceWords($piece, $link);
					}
					if(!eregi("<abbr ", $before)) {
						$piece = weGlossaryReplace::doReplaceWords($piece, $abbreviation);
					}
					if(!eregi("<acronym ", $before)) {
						$piece = weGlossaryReplace::doReplaceWords($piece, $acronym);
					}
					if(!eregi("<span ", $before)) {
						$piece = weGlossaryReplace::doReplaceWords($piece, $foreignword);
					}
				}
				$replBody .= $piece;
				$before = $piece;
			}
			
			/*
			this is slower then the code before
			$replBody = GlossaryReplace::doReplaceWords($replBody, $link);
			$replBody = GlossaryReplace::doReplaceWords($replBody, $acronym);
			$replBody = GlossaryReplace::doReplaceWords($replBody, $abbreviation);
			$replBody = GlossaryReplace::doReplaceWords($replBody, $foreign);
			*/
			
			$replBody = str_replace("@@@we@@@", "'", $replBody);
			if(isset($matches[0])) {
				return str_replace($srcBody, $replBody, $src);
				
			} else {
				return $replBody;
				
			}
			
		}
		
		
		/**
		 * replace just the given replacements in the given source
		 *
		 * @param string $src
		 * @param array $replacements
		 * @return string
		 */
		function doReplaceWords($src, $replacements = array()) {
			if ($src === "") {
				return "";
			}
			@set_time_limit(0);
			if(sizeof($replacements)>0) {
				foreach($replacements as $k => $rep) {
					//forbid self-reference links
					if(stristr($rep,'"\2"=="\1"?"\1":"\3<a href=\"'.$GLOBALS["we_doc"]->Path.'')) { 
						unset($replacements[$k]);	
					}
				}
				
				// add spaces before and after and replace the words
				$src = preg_replace(array_keys($replacements), $replacements, "$src");
				// remove added spaces
				$return = preg_replace("/^ (.+) $/", "$1", $src);
				// remove added slashes
				return stripslashes($return);
			} else {
				
				return $src;
			}
			
		}
		
		
	}
	

?>