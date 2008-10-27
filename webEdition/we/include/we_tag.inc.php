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

if (!isset($GLOBALS["WE_IS_DYN"])) {
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/SEEM/we_SEEM.class.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/global.inc.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/linklist_edit.inc.php");
}

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/date.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/parser.inc.php");

// Tag and TagBlock Cache
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCache.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weTagCache.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weTagBlockCache.class.php");

include_once $_SERVER['DOCUMENT_ROOT'].'/webEdition/lib/we/core/autoload.php';

include_once (WE_USERS_MODULE_DIR . "we_users_util.php");

function we_tag($name, $attribs, $content = "")
{
	
	if ($content) {
		$content = str_replace("we_:_", "we:", $content);
	}
	$edMerk = isset($GLOBALS["we_editmode"]) ? $GLOBALS["we_editmode"] : "";
	if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) {
		if (isset($attribs["user"]) && $attribs["user"]) {
			$uAr = makeArrayFromCSV($attribs["user"]);
			$userIds = array();
			foreach ($uAr as $u) {
				$i = f("SELECT ID FROM " . USER_TABLE . " WHERE Username='" . mysql_real_escape_string($u) . "'", "ID", $GLOBALS["DB_WE"]);
				if ($i) {
					array_push($userIds, $i);
				}
			}
			if (!isUserInUsers($_SESSION["user"]["ID"], $userIds) && (!$_SESSION["perms"]["ADMINISTRATOR"])) {
				$GLOBALS["we_editmode"] = false;
			}
		}
	}
	
	// as default: all tag_functions are in this file.
	$fn = "we_tag_$name";
	if (isset($GLOBALS['weNoCache']) && $GLOBALS['weNoCache'] == true) {
		$attribs['cachelifetime'] = 0;
		$CacheType = 'none';
	} else {
		$CacheType = $GLOBALS["we_doc"]->CacheType;
	}
	
	if ($name == "navigation") {
		$configFile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/conf/we_conf_navigation.inc.php";
		if (!file_exists($configFile) || !is_file($configFile)) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/class/weNavigationSettingControl.class.php");
			weNavigationSettingControl::saveSettings(true);
		}
		include ($configFile);
		$lifeTime = isset($attribs['cachelifetime']) ? $attribs['cachelifetime'] : ($GLOBALS['weDefaultNavigationCacheLifetime'] != '' && $GLOBALS['weDefaultNavigationCacheLifetime'] != '0' ? $GLOBALS['weDefaultNavigationCacheLifetime'] : $GLOBALS["we_doc"]->CacheLifeTime);
	} else {
		$lifeTime = isset($attribs['cachelifetime']) ? $attribs['cachelifetime'] : $GLOBALS["we_doc"]->CacheLifeTime;
	}
	
	$attribs = removeAttribs($attribs, array(
		'cachelifetime'
	));
	$OtherCacheActive = (isset($GLOBALS["weTagListviewCacheActive"]) && $GLOBALS["weTagListviewCacheActive"]) || (isset(
			$GLOBALS["weTagBlockCache"]) && $GLOBALS["weTagBlockCache"] >= 1);
	$toolinc = '';
	
	if (function_exists($fn)) {
		// do noting
	} else 
		if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tags/" . "we_tag_$name.inc.php")) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tags/" . "we_tag_$name.inc.php");
		
		} else 
			if ($fn == "we_tag_noCache") {
			
			} else 
				if (file_exists(
						$_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/custom_tags/' . "we_tag_$name.inc.php")) {
					include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/custom_tags/' . "we_tag_$name.inc.php");
				} else {
					include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/tools/weToolLookup.class.php");
					if (weToolLookup::getToolTag($name, $toolinc)) {
						include_once ($toolinc);
					} else {
						if (strpos(trim($name), "if") === 0) { // this ifTag does not exist
							print parseError(sprintf($GLOBALS["l_parser"]["tag_not_known"], trim($name)));
							return false;
						}
						return parseError(sprintf($GLOBALS["l_parser"]["tag_not_known"], trim($name)));
					}
				
				}
	
	if ($name == "block" || $name == "list" || $name == "linklist") {
		$weTagCache = new weTagBlockCache($name, $attribs, $content, $lifeTime);
	
	} else {
		$weTagCache = new weTagCache($name, $attribs, $content, $lifeTime);
	}
	
	$foo = "";
	
	if ($fn == "we_tag_setVar") {
		$fn($attribs, $content);
	}
	
	// Use Document Cache
	if ($CacheType == 'document' && (!isset($GLOBALS['weNoCache']) || !$GLOBALS['weNoCache']) && (!isset(
			$GLOBALS['weCacheOutput']) || !$GLOBALS['weCacheOutput'])) {
		
		// Cache LifeTime > 0
		if ($GLOBALS["we_doc"]->CacheLifeTime > 0 && get_class($weTagCache) != "weTagBlockCache") {
			
			if ($fn == "we_tag_noCache") {
				echo $content;
				ob_start();
				$GLOBALS['weNoCache'] = true;
				eval("?>" . $content);
				$GLOBALS['weNoCache'] = false;
				ob_end_clean();
				
			// Tag is cacheable
			} else 
				if ($weTagCache->isCacheable()) {
					//echo $fn($attribs, $content);
					$foo = $fn($attribs, $content); // Bug Fix #8250
				

				// Tag is not cacheable
				} else {
					if (eregi("^we_tag_if", $fn)) {
						if (isset($GLOBALS["weTagListviewCacheActive"]) && $GLOBALS["weTagListviewCacheActive"] == true) {
							$foo = $fn($attribs, $content);
						
						} else {
							$foo = "<?php if(we_tag('$name', unserialize('" . serialize($attribs) . "'))) {\n$content ?>";
						
						}
					
					} else {
						echo "<?php printElement(we_tag('$name', unserialize('" . serialize($attribs) . "'), '$content')); ?>";
					
					}
				
				}
			
		// normal use
		} else {
			if ($fn == "we_tag_noCache") {
				$GLOBALS['weNoCache'] = true;
				$foo = eval("?>" . $content);
				$GLOBALS['weNoCache'] = false;
			
			} else {
				$foo = $fn($attribs, $content);
			
			}
		
		}
	
	} else 
		if ($CacheType == 'full' && $weTagCache->lifeTime > 0) {
			$foo = $fn($attribs, $content);
		
		} else {
			
			// Use Tag Cache
			if ($CacheType == 'tag' || $weTagCache->lifeTime > 0) {
				
				// Tag is cacheable
				if ($weTagCache->isCacheable()) { // lifeTime is checked in isCacheable()
					

					// generate the cache
					if ($weTagCache->start()) {
						echo $fn($attribs, $content);
						$weTagCache->end();
					
					}
					$foo = $weTagCache->get();
					
				// Tag is not cacheable
				} else {
					
					if ($fn == "we_tag_noCache") {
						echo $content;
						ob_start();
						$GLOBALS['weNoCache'] = true;
						eval("?>" . $content);
						$GLOBALS['weNoCache'] = false;
						ob_end_clean();
					
					} else {
						$foo = $fn($attribs, $content);
					
					}
				
				}
				
			// Do not use Cache
			} else {
				if ($fn == "we_tag_noCache") {
					$GLOBALS['weNoCache'] = true;
					$foo = eval("?>" . $content);
					$GLOBALS['weNoCache'] = false;
				
				} else {
					$foo = $fn($attribs, $content);
				
				}
			
			}
		
		}
	$GLOBALS["we_editmode"] = $edMerk;
	
	return $foo;

}

### tag utility functions ###
function mta($hash, $key)
{
	return (isset($hash[$key]) && ($hash[$key] != "" || $key == "alt")) ? (' ' . $key . '="' . $hash[$key] . '"') : '';
}

function printElement($code)
{
	if (isset($code)) {
		$code = str_replace("<?php", "<?php ", $code);
		$code = str_replace("?>", " ?>", $code);
		eval('?>' . $code);
	}
}

function makeEmptyTable($in)
{
	preg_match_all("/<[^>]+>/i", $in, $result, PREG_SET_ORDER);
	
	$out = "";
	for ($i = 0; $i < sizeof($result); $i++) {
		$tag = $result[$i][0];
		
		if (eregi("< ?td", $tag) || eregi("< ?/ ?td", $tag) || eregi("< ?tr", $tag) || eregi("< ?/ ?tr", $tag) || eregi(
				"< ?table", 
				$tag) || eregi("< ?/ ?table", $tag) || eregi("< ?tbody", $tag) || eregi("< ?/ ?tbody", $tag)) {
			$out .= $tag;
		}
	
	}
	return $out;
}

function we_cmpText($a, $b)
{
	$x = strtolower(correctUml($a["properties"]["Text"]));
	$y = strtolower(correctUml($b["properties"]["Text"]));
	if ($x == $y)
		return 0;
	return ($x < $y) ? -1 : 1;
}

function we_cmpTextDesc($a, $b)
{
	$x = strtolower(correctUml($a["properties"]["Text"]));
	$y = strtolower(correctUml($b["properties"]["Text"]));
	if ($x == $y)
		return 0;
	return ($x > $y) ? -1 : 1;
}

function we_cmpField($a, $b)
{
	$x = strtolower(correctUml($a["sort"]));
	$y = strtolower(correctUml($b["sort"]));
	if ($x == $y)
		return 0;
	return ($x < $y) ? -1 : 1;
}

function we_cmpFieldDesc($a, $b)
{
	$x = strtolower(correctUml($a["sort"]));
	$y = strtolower(correctUml($b["sort"]));
	if ($x == $y)
		return 0;
	return ($x > $y) ? -1 : 1;
}

function we_tag_path_hasIndex($path, $indexArray)
{
	foreach ($indexArray as $index) {
		if (file_exists($path . $index)) {
			return true;
		}
	}
	return false;
}

function makeArrayFromAttribs($attr)
{
	$attribs = "";
	preg_match_all('/([^=]+)= *("[^"]*")/', $attr, $foo, PREG_SET_ORDER);
	for ($i = 0; $i < sizeof($foo); $i++) {
		$attribs .= '"' . trim($foo[$i][1]) . '"=>' . trim($foo[$i][2]) . ',';
	}
	$arrstr = "array(" . ereg_replace('(.+),$', "\\1", $attribs) . ")";
	eval('$arr = ' . $arrstr . ';');
	return $arr;
}

function correctDateFormat($format, $t = "")
{
	global $l_dayShort, $l_monthLong, $l_dayLong, $l_monthShort;
	if (!$t)
		$t = time();
	
	$format = str_replace('\B', '%%%4%%%', $format);
	$format = str_replace('\I', '%%%5%%%', $format);
	$format = str_replace('\L', '%%%6%%%', $format);
	$format = str_replace('\T', '%%%8%%%', $format);
	$format = str_replace('\U', '%%%9%%%', $format);
	$format = str_replace('\Z', '%%%10%%%', $format);
	
	$format = str_replace('B', '\\B', $format);
	$format = str_replace('I', '\\I', $format);
	$format = str_replace('L', '\\L', $format);
	$format = str_replace('T', '\\T', $format);
	$format = str_replace('U', '\\U', $format);
	$format = str_replace('Z', '\\Z', $format);
	
	$format = str_replace('%%%4%%%', '\B', $format);
	$format = str_replace('%%%5%%%', '\I', $format);
	$format = str_replace('%%%6%%%', '\L', $format);
	$format = str_replace('%%%8%%%', '\T', $format);
	$format = str_replace('%%%9%%%', '\U', $format);
	$format = str_replace('%%%10%%%', '\Z', $format);
	
	$format = str_replace('D', '%%%0%%%', $format);
	$format = str_replace('F', '%%%1%%%', $format);
	$format = str_replace('l', '%%%2%%%', $format);
	$format = str_replace('M', '%%%3%%%', $format);
	
	$foo = $l_dayShort[date("w", $t)];
	$foo = ereg_replace('([a-zA-Z])', '\\\1', $foo);
	$format = str_replace('%%%0%%%', $foo, $format);
	$foo = $l_monthLong[date("n", $t) - 1];
	$foo = ereg_replace('([a-zA-Z])', '\\\1', $foo);
	$format = str_replace('%%%1%%%', $foo, $format);
	$foo = $l_dayLong[date("w", $t)];
	$foo = ereg_replace('([a-zA-Z])', '\\\1', $foo);
	$format = str_replace('%%%2%%%', $foo, $format);
	$foo = $l_monthShort[date("n", $t) - 1];
	$foo = ereg_replace('([a-zA-Z])', '\\\1', $foo);
	$format = str_replace('%%%3%%%', $foo, $format);
	return $format;
}

function cutText($text, $max = 0)
{
	if (!$max)
		return $text;
	if (!strlen($text))
		return "";
	if (strlen($text) <= $max)
		return $text;
	
	$text = strip_tags($text, '<b>,<i>,<em>,<strong>,<a>,<u>,<br>,<div>,<span>');
	$htmlfree = strip_tags($text);
	$text = we_html2uml($text);
	$htmlfree = we_html2uml($htmlfree);
	$left = substr($htmlfree, 0, $max);
	$left = ereg_replace('^(.+)[ \.,].*$', '\1', $left);
	$lastword = ereg_replace('^.+[ \.,;\r\n](.+)$', '\1', $left);
	$orgpos = @strpos($text, $lastword);
	if ($orgpos) {
		$foo = substr($text, 0, $orgpos + strlen($lastword));
		$foo = strip_tags($foo);
	} else {
		$foo = $text;
	}
	$cutpos = $max;
	while ($orgpos && (strlen($foo) < $max)) {
		$cutpos = $orgpos + strlen($lastword);
		$orgpos = @strpos($text, $lastword, $orgpos + 1);
		$foo = substr($text, 0, $orgpos + strlen($lastword));
		$foo = strip_tags($foo);
	}
	$text = substr($text, 0, $cutpos);
	if (eregi('^(.+)(<)(a|b|em|strong|b|i|u|div|span)([ >][^<]*)$', $text, $regs)) {
		$text = $regs[1] . $regs[2] . $regs[3] . $regs[4] . '</' . $regs[3] . '>';
	} else 
		if (eregi('^(.+)(<)(a|em|strong|b|i|u|br|div|span)([^>]*)$', $text, $regs)) {
			$text = $regs[1];
		}
	return $text . "...";
}

function arrayKeyExists($key, $search)
{
	if (in_array($key, array_keys($search))) {
		return true;
	} else {
		return false;
	}
}

function we_isVarSet($name, $type, $docAttr, $property = false, $formname = "", $shopname = '')
{
	switch ($type) {
		case "request" :
			return isset($_REQUEST[$name]);
			break;
		case "global" :
			return isset($GLOBALS[$name]);
			break;
		case "session" :
			return isset($_SESSION[$name]);
			break;
		case "sessionfield" :
			return isset($_SESSION["webuser"][$name]);
			break;
		case 'shopField' :
			if (isset($GLOBALS[$shopname])) {
				return isset($GLOBALS[$shopname]->CartFields[$name]);
			}
			break;
		case 'sum' :
			return (isset($GLOBALS['summe']) && isset($GLOBALS['summe'][$name]));
			break;
		default :
			$doc = false;
			switch ($docAttr) {
				case "object" :
				case "document" :
					$doc = isset($GLOBALS["we_" . $docAttr][$formname]) ? $GLOBALS["we_" . $docAttr][$formname] : false;
					break;
				case "top" :
					$doc = isset($GLOBALS["WE_MAIN_DOC"]) ? $GLOBALS["WE_MAIN_DOC"] : false;
					break;
				default :
					$doc = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : false;
			}
			if ($doc) {
				if ($property) {
					eval('$retval = isset($doc->' . $name . ');');
					return $retval;
				} else {
					if ($type == "href") {
						if ($doc->elements[$name . "_we_jkhdsf_int"]["dat"]) {
							return isset($doc->elements[$name . "_we_jkhdsf_intPath"]["dat"]);
						}
					}
					$fieldType = isset($doc->elements[$name]["type"]) ? $doc->elements[$name]["type"] : "";
					$issetElemNameDat = isset($doc->elements[$name]["dat"]);
					if ($fieldType == "checkbox_feld" && $issetElemNameDat && $doc->elements[$name]["dat"] == 0)
						return false;
					return $issetElemNameDat;
				}
			} else {
				return false;
			}
	}
}

function we_isVarNotEmpty($attribs)
{
	
	$docAttr = we_getTagAttribute("doc", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$match = we_getTagAttribute("match", $attribs);
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs, "txt");
	$formname = we_getTagAttribute("formname", $attribs, "we_global_form");
	$property = we_getTagAttribute("property", $attribs, "", true);
	
	if (!we_isVarSet($match, $type, $docAttr, $property, $formname))
		return false;
	
	switch ($type) {
		case "request" :
			return (strlen($_REQUEST[$match]) > 0);
			break;
		case "global" :
			return (strlen($GLOBALS[$match]) > 0);
			break;
		case "session" :
			$foo = isset($_SESSION[$match]) ? $_SESSION[$match] : "";
			return (strlen($foo) > 0);
			break;
		case "sessionfield" :
			return (strlen($_SESSION["webuser"][$match]) > 0);
			break;
		default :
			$doc = false;
			switch ($docAttr) {
				case "object" :
				case "document" :
					$doc = isset($GLOBALS["we_" . $docAttr][$formname]) ? $GLOBALS["we_" . $docAttr][$formname] : false;
					break;
				case "top" :
					$doc = isset($GLOBALS["WE_MAIN_DOC"]) ? $GLOBALS["WE_MAIN_DOC"] : false;
					break;
				default :
					$doc = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : false;
			}
			if ($doc) {
				if ($property) {
					eval('$retVal = isset($doc->' . $match . ') ? $doc->' . $match . ' : "";');
					return $retVal;
				} else {
					$name = $match;
					switch ($type) {
						case "href" :
							$attribs["name"] = $match;
							$foo = $doc->getField($attribs, $type, true);
							break;
						case "multiobject" :
							$attribs["name"] = $match;
							$data = unserialize($doc->getField($attribs, $type, true));
							if (!is_array($data['objects'])) {
								$data['objects'] = array();
							}
							include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/object/we_listview_multiobject.class.php");
							$temp = new we_listview_multiobject($match);
							if (sizeof($temp->Record) > 0) {
								return true;
							} else {
								return false;
							}
						default :
							$foo = $doc->getElement($match);
					}
					return (strlen($foo) > 0);
				}
			} else {
				return false;
			}
	}
}

function we_isNotEmpty($attribs)
{
	$docAttr = we_getTagAttribute("doc", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$match = we_getTagAttribute("match", $attribs);
	$doc = we_getDocForTag($docAttr, false);
	
	switch ($type) {
		case "object" :
			return $doc->getElement($match);
		case "binary" :
		case "img" :
		case "flashmovie" :
			return $doc->getElement($match, "bdid");
		case "href" :
			if (isset($doc->TableID) && $doc->TableID) {
				$hrefArr = $doc->getElement($match) ? unserialize($doc->getElement($match)) : array();
				if (!is_array($hrefArr))
					$hrefArr = array();
				$hreftmp = trim(we_document::getHrefByArray($hrefArr));
				if (substr($hreftmp, 0, 1) == "/" && (!file_exists($_SERVER["DOCUMENT_ROOT"] . $hreftmp))) {
					return false;
				}
				return $hreftmp ? true : false;
			}
			$int = ($doc->getElement($match . "_we_jkhdsf_int") == "") ? 0 : $doc->getElement(
					$match . "_we_jkhdsf_int");
			if ($int) { // for type = href int
				$intID = $doc->getElement($match . "_we_jkhdsf_intID");
				if ($intID > 0) {
					return strlen(id_to_path($intID)) > 0;
				}
				return false;
			} else {
				$hreftmp = $doc->getElement($match);
				if (substr($hreftmp, 0, 1) == "/" && (!file_exists($_SERVER["DOCUMENT_ROOT"] . $hreftmp))) {
					return false;
				}
			}
		default :
			
			if (isset($doc)) {
				//   #3938 added this - some php version crashed, when unserialize started with a ?,?,?
				

				if ((substr($doc->getElement($match), 0, 2) == "a:")) { //  only unserialize, when $match cluld be an array
					// Added @-operator in front of the unserialze function because there
					// were some PHP notices that had no effect on the output of the function
					// remark holeg: when it is a serialized array, the function looks if it is not empty
					if (is_array(
							$arr = @unserialize($doc->getElement($match)))) {
						return sizeof($arr) ? true : false;
					}
				}
				//   end of #3938
			}
	
	}
	return ($doc->getElement($match) != "") || $doc->getElement($match, "bdid");
}

function we_isFieldNotEmpty($attribs)
{
	$type = we_getTagAttribute("type", $attribs);
	$match = we_getTagAttribute("match", $attribs);
	switch ($type) {
		case "calendar" :
			if (isset($GLOBALS["lv"]->calendar_struct)) {
				if ($GLOBALS["lv"]->calendar_struct["date"] < 0)
					return false;
				if (count($GLOBALS["lv"]->calendar_struct["storage"]) < 1)
					return false;
				if ($match == "day") {
					$sd = mktime(
							0, 
							0, 
							0, 
							$GLOBALS["lv"]->calendar_struct["month_human"], 
							$GLOBALS["lv"]->calendar_struct["day_human"], 
							$GLOBALS["lv"]->calendar_struct["year_human"]);
					$ed = mktime(
							23, 
							59, 
							59, 
							$GLOBALS["lv"]->calendar_struct["month_human"], 
							$GLOBALS["lv"]->calendar_struct["day_human"], 
							$GLOBALS["lv"]->calendar_struct["year_human"]);
				} else 
					if ($match == "month") {
						$sd = mktime(
								0, 
								0, 
								0, 
								$GLOBALS["lv"]->calendar_struct["month_human"], 
								1, 
								$GLOBALS["lv"]->calendar_struct["year_human"]);
						$ed = mktime(
								23, 
								59, 
								59, 
								$GLOBALS["lv"]->calendar_struct["month_human"], 
								$GLOBALS["lv"]->calendar_struct["numofentries"], 
								$GLOBALS["lv"]->calendar_struct["year_human"]);
					} else 
						if ($match == "year") {
							$sd = mktime(0, 0, 0, 1, 1, $GLOBALS["lv"]->calendar_struct["year_human"]);
							$sd = mktime(23, 59, 59, 12, 31, $GLOBALS["lv"]->calendar_struct["year_human"]);
						}
				if (isset($sd) && isset($ed)) {
					foreach ($GLOBALS["lv"]->calendar_struct["storage"] as $entry) {
						if ($sd < $entry && $ed > $entry)
							return true;
					}
				}
				return false;
			}
			return false;
			break;
		case "multiobject" :
			if (isset($GLOBALS["lv"])) {
				if (isset($GLOBALS["lv"]->object)) {
					$data = unserialize($GLOBALS['lv']->object->DB_WE->Record['we_' . $match]);
				} else {
					$data = unserialize($GLOBALS['lv']->DB_WE->Record['we_' . $match]);
				}
			} else {
				$data = unserialize($GLOBALS['we_doc']->getElement($match));
			}
			if (isset($data['objects']) && is_array($data['objects']) && sizeof($data['objects']) > 0) {
				$test = array_count_values($data['objects']);
				if (sizeof($test) > 1 || (sizeof($test) == 1 && !isset($test['']))) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		
		case "object" :
		case "binary" :
		case "img" :
		case "flashmovie" :
			return $GLOBALS["lv"]->f($match);
		case "href" :
			if ($GLOBALS["lv"]->ClassName == "we_listview_object" || $GLOBALS["lv"]->ClassName == "we_objecttag") {
				$hrefArr = $GLOBALS["lv"]->f($match) ? unserialize($GLOBALS["lv"]->f($match)) : array();
				if (!is_array($hrefArr))
					$hrefArr = array();
				$hreftmp = trim(we_document::getHrefByArray($hrefArr));
				if (substr($hreftmp, 0, 1) == "/" && (!file_exists($_SERVER["DOCUMENT_ROOT"] . $hreftmp))) {
					return false;
				}
				return $hreftmp ? true : false;
			}
			$int = ($GLOBALS["lv"]->f($match . "_we_jkhdsf_int") == "") ? 0 : $GLOBALS["lv"]->f(
					$match . "_we_jkhdsf_int");
			if ($int) { // for type = href int
				$intID = $GLOBALS["lv"]->f($match . "_we_jkhdsf_intID");
				if ($intID > 0) {
					return strlen(id_to_path($intID)) > 0;
				}
				return false;
			} else {
				$hreftmp = $GLOBALS["lv"]->f($match);
				if (substr($hreftmp, 0, 1) == "/" && (!file_exists($_SERVER["DOCUMENT_ROOT"] . $hreftmp))) {
					return false;
				}
			}
		default :
			$_tmp = @unserialize($GLOBALS["lv"]->f($match));
			if (is_array($_tmp)) {
				return sizeof($_tmp) > 0;
			}
	}
	return $GLOBALS["lv"]->f($match) != "";
}

function we_isUserInputNotEmpty($attribs)
{
	
	$formname = we_getTagAttribute("formname", $attribs, "we_global_form");
	$match = we_getTagAttribute("match", $attribs);
	return (isset($_REQUEST["we_ui_" . $formname][$match]) && strlen($_REQUEST["we_ui_" . $formname][$match]));

}

function we_getDocForTag($docAttr, $maindefault = false)
{
	if ($maindefault) {
		switch ($docAttr) {
			case "self" :
				return $GLOBALS["we_doc"];
			default :
				return $GLOBALS["WE_MAIN_DOC"];
		}
	} else {
		switch ($docAttr) {
			case "top" :
				return $GLOBALS["WE_MAIN_DOC"];
			default :
				return $GLOBALS["we_doc"];
		}
	}
}

/*  **************************************************
    *	we:tags										 *
/*  **************************************************/

function we_tag_a($attribs, $content)
{
	global $we_editmode;
	
	// check for id attribute
	$foo = attributFehltError($attribs, "id", "a");
	if ($foo)
		return $foo;
		
	// get attributes
	$id = we_getTagAttribute("id", $attribs);
	if ($id == "self") {
		$id = $GLOBALS["WE_MAIN_DOC"]->ID;
	}
	$confirm = we_getTagAttribute("confirm", $attribs);
	$button = we_getTagAttribute("button", $attribs, "", true);
	$hrefonly = we_getTagAttribute("hrefonly", $attribs, "", true);
	$return = we_getTagAttribute("return", $attribs, "", true);
	$target = we_getTagAttribute("target", $attribs, "");
	
	$shop = we_getTagAttribute("shop", $attribs, "", true);
	$amount = we_getTagAttribute("amount", $attribs, 1);
	$delarticle = we_getTagAttribute("delarticle", $attribs, "", true);
	$delshop = we_getTagAttribute("delshop", $attribs, "", true);
	
	$edit = we_getTagAttribute("edit", $attribs);
	
	if (!$edit && ($shop || $delarticle || $delshop)) {
		$edit = "shop";
	}
	
	if ($edit) {
		$delete = we_getTagAttribute("delete", $attribs, "", true);
		$editself = we_getTagAttribute("editself", $attribs, "", true);
		$listview = isset($GLOBALS["lv"]);
	}
	
	// init variables
	$db = new DB_WE();
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", $db);
	$url = (isset($row["Path"]) ? $row["Path"] : "") . ((isset($row["IsFolder"]) && $row["IsFolder"]) ? "/" : "");
	
	$urladd = "";
	
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_tagParser.inc.php");
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	$tp->parseTags($tags, $content);
	
	if ((!$url) && ($GLOBALS["WE_MAIN_DOC"]->ClassName != "we_template")) {
		if ($we_editmode) {
			return parseError("in we:a attribute id not exists!");
		} else {
			return "";
		}
	}
	
	if ($edit == "shop") {
		
		$amount = we_getTagAttribute("amount", $attribs, 1);
		
		if (isset($GLOBALS["lv"])) {
			$foo = $GLOBALS["lv"]->count - 1;
		} else {
			$foo = -1;
		}
		
		// get ID of element
		$customReq = '';
		if (isset($GLOBALS["lv"]) && get_class($GLOBALS["lv"]) == 'shop') {
			
			$idd = $GLOBALS["lv"]->ActItem['id'];
			$type = $GLOBALS["lv"]->ActItem['type'];
			$customReq = $GLOBALS["lv"]->getCustomFieldsAsRequest();
		
		} else {
			$idd = ((isset($GLOBALS["lv"]) && isset($GLOBALS["lv"]->IDs[$foo])) && $GLOBALS["lv"]->IDs[$foo] != "") ? $GLOBALS["lv"]->IDs[$foo] : ((isset(
					$GLOBALS["lv"]->classID)) ? $GLOBALS["lv"]->DB_WE->Record["OF_ID"] : ((isset(
					$GLOBALS["we_obj"]->ID)) ? $GLOBALS["we_obj"]->ID : $GLOBALS["WE_MAIN_DOC"]->ID));
			$type = (isset($GLOBALS["lv"]) && isset($GLOBALS["lv"]->IDs[$foo]) && $GLOBALS["lv"]->IDs[$foo] != "") ? ((isset(
					$GLOBALS["lv"]->classID) || isset($GLOBALS["lv"]->Record["OF_ID"])) ? "o" : "w") : ((isset(
					$GLOBALS["lv"]->classID)) ? "o" : ((isset($GLOBALS["we_obj"]->ID)) ? "o" : "w"));
		}
		
		// is it a shopVariant ????
		$variant = '';
		// normal variant on document
		if (isset($GLOBALS['we_doc']->Variant)) { // normal listView or document
			$variant = '&' . WE_SHOP_VARIANT_REQUEST . '=' . $GLOBALS['we_doc']->Variant;
		}
		// variant inside shoplistview!
		if (isset($GLOBALS["lv"]) && $GLOBALS["lv"]->f('WE_VARIANT')) {
			$variant = '&' . WE_SHOP_VARIANT_REQUEST . '=' . $GLOBALS["lv"]->f('WE_VARIANT');
		}
		
		//	preview mode in seem
		if (isset($_REQUEST["we_transaction"]) && isset(
				$_SESSION["we_data"][$_REQUEST["we_transaction"]]["0"]["ClassName"]) && $_SESSION["we_data"][$_REQUEST["we_transaction"]]["0"]["ClassName"] == "we_objectFile") {
			$type = "o";
		}
		
		$shopname = we_getTagAttribute("shopname", $attribs, "");
		$ifShopname = $shopname == "" ? "" : "&shopname=" . $shopname;
		if ($delarticle) { // delarticle
			

			// is it a shopVariant ????
			$variant = '';
			// normal variant on document
			if (isset($GLOBALS['we_doc']->Variant)) { // normal listView or document
				$variant = '&' . WE_SHOP_VARIANT_REQUEST . '=' . $GLOBALS['we_doc']->Variant;
			}
			// variant inside shoplistview!
			if (isset($GLOBALS["lv"]) && $GLOBALS["lv"]->f('WE_VARIANT')) {
				$variant = '&' . WE_SHOP_VARIANT_REQUEST . '=' . $GLOBALS["lv"]->f('WE_VARIANT');
			}
			
			$foo = $GLOBALS["lv"]->count - 1;
			
			$customReq = '';
			if (isset($GLOBALS["lv"]) && get_class($GLOBALS["lv"]) == 'shop') {
				
				$idd = $GLOBALS["lv"]->ActItem['id'];
				$type = $GLOBALS["lv"]->ActItem['type'];
				$customReq = $GLOBALS["lv"]->getCustomFieldsAsRequest();
			} else {
				$idd = (isset($GLOBALS["lv"]->IDs[$foo]) && $GLOBALS["lv"]->IDs[$foo] != "") ? $GLOBALS["lv"]->IDs[$foo] : ((isset(
						$GLOBALS["lv"]->classID)) ? $GLOBALS["lv"]->DB_WE->Record["OF_ID"] : ((isset(
						$GLOBALS["we_obj"]->ID)) ? $GLOBALS["we_obj"]->ID : $GLOBALS["WE_MAIN_DOC"]->ID));
				$type = (isset($GLOBALS["lv"]) && isset($GLOBALS["lv"]->IDs[$foo]) && $GLOBALS["lv"]->IDs[$foo] != "") ? ((isset(
						$GLOBALS["lv"]->classID) || isset($GLOBALS["lv"]->Record["OF_ID"])) ? "o" : "w") : ((isset(
						$GLOBALS["lv"]->classID)) ? "o" : ((isset($GLOBALS["we_obj"]->ID)) ? "o" : "w"));
			}
			//	preview mode in seem
			if (isset($_REQUEST["we_transaction"]) && isset(
					$_SESSION["we_data"][$_REQUEST["we_transaction"]]["0"]["ClassName"]) && $_SESSION["we_data"][$_REQUEST["we_transaction"]]["0"]["ClassName"] == "we_objectFile") {
				$type = "o";
			}
			$urladd = ($urladd ? $urladd . "&" : '?') . 'del_shop_artikelid=' . $idd . '&type=' . $type . '&t=' . time() . $variant . $customReq . $ifShopname;
		
		} else 
			if ($delshop) { // emptyshop
				

				$foo = attributFehltError($attribs, "shopname", "a");
				if ($foo)
					return $foo;
				$urladd = ($urladd ? $urladd . "&" : '?') . 'deleteshop=1' . $ifShopname . '&t=' . time();
			
			} else { // increase/decrease amount of articles
				

				$urladd = ($urladd ? $urladd . "&" : '?') . 'shop_artikelid=' . $idd . '&shop_anzahl=' . $amount . '&type=' . $type . '&t=' . time() . $variant . ($customReq ? $customReq : '') . $ifShopname;
			}
	
	} else 
		if ($edit == "object") {
			if ($listview) {
				$oid = (isset($GLOBALS["lv"]) && $GLOBALS["lv"]->f("WE_ID")) ? $GLOBALS["lv"]->f("WE_ID") : 0;
			} else {
				$oid = (isset($GLOBALS["we_obj"]) && isset($GLOBALS["we_obj"]->ID) && $editself) ? $GLOBALS["we_obj"]->ID : 0;
			}
			if ($delete) {
				if ($oid) {
					$urladd = ($urladd ? $urladd . "&" : '?') . "we_delObject_ID=" . $oid;
				}
			} else {
				if ($oid) {
					$urladd = ($urladd ? $urladd . "&" : '?') . "we_editObject_ID=" . $oid;
				} else {
					$urladd = ($urladd ? $urladd . "&" : '?') . "edit_object=1";
				}
			}
		} else 
			if ($edit == "document") {
				
				if ($listview) {
					$did = (isset($GLOBALS["lv"]) && $GLOBALS["lv"]->f("WE_ID")) ? $GLOBALS["lv"]->f("WE_ID") : 0;
				} else {
					$did = (isset($GLOBALS["we_doc"]) && isset($GLOBALS["we_doc"]->ID) && $editself) ? $GLOBALS["we_doc"]->ID : 0;
				}
				if ($delete) {
					if ($did) {
						$urladd = ($urladd ? $urladd . "&" : '?') . "we_delDocument_ID=" . $did;
					}
				} else {
					
					if ($did) {
						$urladd = ($urladd ? $urladd . "&" : '?') . "we_editDocument_ID=" . $did;
					} else {
						$urladd = ($urladd ? $urladd . "&" : '?') . "edit_document=1";
					}
				}
			}
	
	if ($return) {
		$urladd = ($urladd ? $urladd . "&" : '?') . "we_returnpage=" . rawurlencode(
				$_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"]);
	}
	
	if ($hrefonly) {
		return $url . $urladd;
	}
	
	//	remove unneeded attributes from array
	$attribs = removeAttribs(
			$attribs, 
			array(
				
					"id", 
					"shop", 
					"amount", 
					"delshop", 
					"delarticle", 
					"shopname", 
					"return", 
					"edit", 
					"type", 
					"button", 
					"hrefonly", 
					"confirm", 
					"editself", 
					"delete"
			));
	
	if ($button) { //	show button
		

		$attribs["type"] = "button";
		$attribs["value"] = htmlspecialchars($content);
		$attribs["onclick"] = ($target ? ("var wind=window.open('','$target');wind") : "self") . ".document.location='$url" . htmlspecialchars(
				$urladd) . "';";
		
		$attribs = removeAttribs($attribs, array(
			"target"
		)); //	not html - valid
		

		if ($confirm) {
			$confirm = str_replace("'", "\\'", $confirm);
			$attribs["onclick"] = "if(confirm('$confirm')){" . $attribs["onclick"] . "}";
			return getHtmlTag("input", $attribs);
		} else {
			return getHtmlTag("input", $attribs);
		}
	} else { //	show normal link
		

		$attribs["href"] = $url . ($urladd ? htmlspecialchars($urladd) : '');
		
		if ($confirm) {
			
			$attribs["onclick"] = "if(confirm('$confirm')){return true;}else{return false;}";
			return getHtmlTag("a", $attribs, $content, true);
		} else {
			return getHtmlTag("a", $attribs, $content, true);
		}
	}
}

function we_tag_author($attribs, $content)
{
	// attributes
	$type = we_getTagAttribute("type", $attribs);
	$creator = we_getTagAttribute("creator", $attribs, '', true);
	$docAttr = we_getTagAttribute("doc", $attribs);
	
	$doc = we_getDocForTag($docAttr, true);
	
	$foo = getHash(
			"SELECT Username,First,Second FROM " . USER_TABLE . " WHERE ID='" . abs($creator ? $doc->CreatorID : $doc->ModifierID) . "'", 
			new DB_WE());
	
	switch ($type) {
		case "name" :
			$out = trim(($foo["First"] ? ($foo["First"] . " ") : "") . $foo["Second"]);
			if (!$out) {
				$out = $foo["Username"];
			}
			return $out;
		case "initials" :
			$out = trim(
					($foo["First"] ? substr($foo["First"], 0, 1) : "") . ($foo["Second"] ? substr(
							$foo["Second"], 
							0, 
							1) : ""));
			if (!$out) {
				$out = $foo["Username"];
			}
			return $out;
		default :
			return $foo["Username"];
	}
}

function we_tag_back($attribs, $content)
{
	if (isset($GLOBALS["_we_voting_list"]))
		return $GLOBALS["_we_voting_list"]->getBackLink($attribs);
	else
		return $GLOBALS["lv"]->getBackLink($attribs);
}

function we_tag_block($attribs, $content)
{
	global $we_editmode;
	
	if ($we_editmode) {
		$we_button = new we_button();
	}
	
	$foo = attributFehltError($attribs, "name", "block");
	if ($foo)
		return $foo;
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_tagParser.inc.php");
	
	$name = we_getTagAttribute("name", $attribs);
	$showselect = we_getTagAttribute("showselect", $attribs, "", true, true);
	
	$isInListview = isset($GLOBALS["lv"]);
	
	if ($isInListview) {
		$list = $GLOBALS["lv"]->f($name);
	} else {
		$list = $GLOBALS["we_doc"]->getElement($name);
	}
	
	// Bug Fix #1909 and #415
	$start = we_getTagAttribute("start", $attribs);
	$limit = we_getTagAttribute("limit", $attribs);
	if (!$list && $start) {
		$listarray = array();
		if ($limit && $limit > 0 && $limit < $start) {
			$start = $limit;
		}
		for ($i = 0; $i < $start; $i++) {
			$listarray[$i] = "_" . ($i + 1);
		}
		$list = serialize($listarray);
	}
	// Bug Fix #1909 and #415
	

	$blkPreName = "blk_" . $name . "_";
	
	$content = str_replace('<we:ref', '<we_:_ref', $content);
	
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	
	$names = implode(",", $tp->getNames($tags));
	
	if (strpos($content, "<we:object") === false && strpos($content, "<we:metadata") === false && strpos($content, "<we:listview") === false) { //	no we:object is used
		//	parse name of we:field
		$tp->parseTags($tags, $content, '<we_:_ref>', array());
	} else { //	we:object is used
		//	dont parse name of we:field !!!
		$tp->parseTags(
				$tags, 
				$content, 
				'<we_:_ref>', 
				array(
					'we:field', 'we:ifFieldNotEmpty', 'we:ifFieldEmpty'
				));
	}
	$out = "";
	
	$tmpname = md5(uniqid(time()));
	
	$noButCode = "";
	if ($list) {
		
		$listarray = unserialize($list);
		$listlen = sizeof($listarray);
		
		if ($listlen != 0) {
			
			if (!$we_editmode) {
				if ($limit > 0 && $listlen > $limit) {
					$listlen = $limit;
				}
			}
			
			for ($i = 0; $i < $listlen; $i++) {
				$listRef = $blkPreName . $listarray[$i];
				$foo = $content;
				$foo = str_replace('<we_:_ref>', $listRef, $foo);
				
				//	handle we:ifPosition:
				if (strpos($foo, 'position') || strpos($foo, 'ifPosition') || strpos(
						$foo, 
						'ifNotPosition')) { //	set information for ifPosition
					

					$foo = '<?php $GLOBALS[\'we_position\'][\'block\'][\'' . $name . '\'] = array(\'position\' => ' . ($i + 1) . ', \'size\'=>' . $listlen . '); ?>' . $foo . '<?php unset($GLOBALS[\'we_position\'][\'block\'][\'' . $name . '\']); ?>';
				}
				
				$noButCode .= $foo;
				if ($we_editmode) {
					
					$show = 10;
					if ($limit && $limit > 0) {
						$diff = $limit - $listlen;
						if ($diff > 0) {
							$show = min($show, $diff);
						} else {
							$show = 0;
						}
					}
					$selectb = '<select name="' . $tmpname . '_' . $i . '">';
					for ($j = 0; $j < $show; $j++) {
						$selectb .= "		<option value=\"" . ($j + 1) . "\">" . ($j + 1) . "</option>\n";
					}
					$selectb .= "</select>";
					
					$upbut = $we_button->create_button(
							"image:btn_direction_up", 
							"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('up_entry_at_list','$name','$i')");
					$upbutDis = $we_button->create_button("image:btn_direction_up", "", true, 21, 22, "", "", true);
					$downbut = $we_button->create_button(
							"image:btn_direction_down", 
							"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('down_entry_at_list','$name','$i')");
					$downbutDis = $we_button->create_button(
							"image:btn_direction_down", 
							"", 
							true, 
							21, 
							22, 
							"", 
							"", 
							true);
					if ($showselect && $show > 0) {
						$plusbut = $we_button->create_button(
								"image:btn_add_listelement", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('insert_entry_at_list','$name','$i',document.we_form.elements['" . $tmpname . "_" . $i . "'].options[document.we_form.elements['" . $tmpname . "_" . $i . "'].selectedIndex].text)", 
								true, 
								100, 
								22, 
								"", 
								"", 
								($show > 0 ? false : true));
					} else {
						$plusbut = $we_button->create_button(
								"image:btn_add_listelement", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('insert_entry_at_list','$name','$i',1)", 
								true, 
								100, 
								22, 
								"", 
								"", 
								($show > 0 ? false : true));
					}
					$trashbut = $we_button->create_button(
							"image:btn_function_trash", 
							"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('delete_list','$name','$i','$names',1)");
					$buts = "";
					
					if (!$isInListview) {
						
						if ($showselect) {
							
							$buts = $we_button->create_button_table(
									array(
										
											$plusbut, 
											$selectb, 
											(($i > 0) ? $upbut : $upbutDis), 
											(($i < ($listlen - 1)) ? $downbut : $downbutDis), 
											$trashbut
									), 
									5);
						} else {
							$buts = $we_button->create_button_table(
									array(
										
											$plusbut, 
											(($i > 0) ? $upbut : $upbutDis), 
											(($i < ($listlen - 1)) ? $downbut : $downbutDis), 
											$trashbut
									), 
									5);
						}
					}
					if (eregi('^< ?td', trim($foo)) || eregi('^< ?tr', trim($foo))) {
						$foo = str_replace('=>', '#####PHPCALSSARROW####', $foo);
						$foo = str_replace('?>', '#####PHPENDBRACKET####', $foo);
						$foo = eregi_replace('(< ?td[^>]*>)(.*)(< ?/ ?td[^>]*>)', '\1' . $buts . '\2\3', $foo);
						$foo = str_replace('#####PHPCALSSARROW####', '=>', $foo);
						$foo = str_replace('#####PHPENDBRACKET####', '?>', $foo);
					} else {
						$foo = $buts . $foo;
					}
				}
				$out .= $foo;
			}
		}
	}
	if ($we_editmode) {
		
		$show = 10;
		if ($limit && $limit > 0) {
			$diff = $limit - (isset($listlen) ? $listlen : 0);
			if ($diff > 0) {
				$show = min($show, $diff);
			} else {
				$show = 0;
			}
		}
		
		if ($show > 0) {
			$selectb = '<select name="' . $tmpname . '_00">';
			for ($j = 0; $j < $show; $j++) {
				$selectb .= "		<option value=\"" . ($j + 1) . "\">" . ($j + 1) . "</option>\n";
			}
			$selectb .= "</select>";
			
			if ($showselect) {
				$plusbut = $we_button->create_button(
						"image:btn_add_listelement", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('add_entry_to_list','$name',document.we_form.elements['" . $tmpname . "_00'].options[document.we_form.elements['" . $tmpname . "_00'].selectedIndex].text)", 
						true, 
						100, 
						22, 
						"", 
						"", 
						($show > 0 ? false : true));
				$plusbut = $we_button->create_button_table(array(
					$plusbut, $selectb
				));
			} else {
				$plusbut = $we_button->create_button(
						"image:btn_add_listelement", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('add_entry_to_list','$name',1)", 
						true, 
						100, 
						22, 
						"", 
						"", 
						($show > 0 ? false : true));
			}
			
			if (eregi('^< ?td', $content) || eregi('^< ?tr', $content)) {
				$foo = makeEmptyTable(rmPhp($content));
				$plusbut = eregi_replace('(< ?td[^>]*>)(.*)(< ?/ ?td[^>]*>)', '\1\2' . $plusbut . '\3', $foo);
			} else {
				$plusbut = "<p>" . $plusbut;
			}
			$out .= (!$isInListview) ? ('<input type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_list[' . $name . ']" value="' . htmlentities(
					$list) . '"><input type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_list[' . $name . '#content]" value="' . htmlspecialchars(
					$content) . '">' . $plusbut) : '';
		}
	
	}
	
	//	When in SEEM - Mode add edit-Button to tag - textarea
	return $out;
}

function we_tag_calculate($attribs, $content)
{
	
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tagParser.inc.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_util.inc.php");
	
	$sum = we_getTagAttribute("sum", $attribs);
	$num_format = we_getTagAttribute("num_format", $attribs);
	$print = we_getTagAttribute("print", $attribs, "", true, true);
	
	$zahl = "";
	$content1 = "";
	
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	
	$GLOBALS["calculate"] = 1;
	$tp->parseTags($tags, $content);
	$GLOBALS["calculate"] = 0;
	//echo "content : ".htmlentities($content)."<br>";
	

	for ($x = 0; $x < strlen($content); $x++) {
		if (ereg("[0-9|\.|,]", substr($content, $x, 1))) {
			$zahl .= substr($content, $x, 1);
		} else {
			
			$content1 .= we_util::std_numberformat($zahl) . substr($content, $x, 1);
			//echo "<br><br>".$x."..". $content1."<br><br>";
			$zahl = "";
		}
	}
	$content1 .= we_util::std_numberformat($zahl) . substr($content, $x, 1);
	$content = $content1;
	
	@eval('$result = (' . $content . ') ;');
	
	if (!isset($result)) {
		$result = 0;
	}
	
	if (!empty($sum)) {
		if (!isset($GLOBALS["summe"][$sum])) {
			$GLOBALS["summe"][$sum] = 0;
		}
		$GLOBALS["summe"][$sum] += $result;
	}
	if ($num_format == "german") {
		$result = number_format($result, 2, ",", ".");
	} else 
		if ($num_format == "french") {
			$result = number_format($result, 2, ",", " ");
		} else 
			if ($num_format == "english") {
				$result = number_format($result, 2, ".", "");
			} else 
				if ($num_format == "swiss") {
					$result = number_format($result, 2, ".", "'");
				}
	if ($print) {
		return $result;
	} else {
		return;
	}
}

function we_tag_category($attribs, $content)
{
	
	// initialize possible Attributes
	$delimiter = we_getTagAttribute("delimiter", $attribs, "");
	if ($delimiter === "") {
		$delimiter = we_getTagAttribute("tokken", $attribs, "-");
	}
	
	$rootdir = we_getTagAttribute("rootdir", $attribs, "");
	$showpath = we_getTagAttribute("showpath", $attribs, false, true);
	$docAttr = we_getTagAttribute("doc", $attribs);
	$field = we_getTagAttribute("field", $attribs, "");
	$id = abs(we_getTagAttribute("id", $attribs));
	$separator = we_getTagAttribute("separator", $attribs, "/");
	
	// end initialize possible Attributes
	if ($id) {
		$category = str_replace(
				"\\,", 
				",", 
				we_getCatsFromIDs($id, $delimiter, $showpath, $GLOBALS["DB_WE"], $rootdir, $field));
		return str_replace("/", $separator, $category);
	}
	
	$isInListview = isset($GLOBALS["lv"]) && (!$docAttr);
	
	if ($isInListview) {
		// get cats from listview object
		switch ($GLOBALS["lv"]->ClassName) {
			case "we_listview_object" :
				$catIDs = $GLOBALS["lv"]->f("wedoc_Category");
				break;
			case "we_search_listview" :
				$catIDs = $GLOBALS["lv"]->f("wedoc_Category");
				break;
			default :
				$catIDs = $GLOBALS["lv"]->f("wedoc_Category");
		}
		
		$category = $catIDs ? str_replace(
				"\\,", 
				",", 
				we_getCatsFromIDs($catIDs, $delimiter, $showpath, $GLOBALS["DB_WE"], $rootdir, $field)) : "";
		return str_replace("/", $separator, $category);
	
	} else {
		$doc = we_getDocForTag($docAttr, false);
		$category = str_replace(
				"\\,", 
				",", 
				we_getCatsFromDoc($doc, $delimiter, $showpath, $GLOBALS["DB_WE"], $rootdir, $field));
		return str_replace("/", $separator, $category);
	}
}

function we_tag_categorySelect($attribs, $content)
{
	$name = we_getTagAttribute("name", $attribs);
	$isuserinput = (strlen($name) == 0);
	$name = $isuserinput ? "we_ui_" . $GLOBALS["WE_FORM"] . "_categories" : $name;
	
	$type = we_getTagAttribute("type", $attribs);
	$rootdir = we_getTagAttribute("rootdir", $attribs, "/");
	$firstentry = we_getTagAttribute("firstentry", $attribs);
	$showpath = we_getTagAttribute("showpath", $attribs, "", true);
	$indent = we_getTagAttribute("indent", $attribs, "");
	
	$values = "";
	if ($isuserinput && $GLOBALS["WE_FORM"]) {
		$objekt = isset($GLOBALS["we_object"][$GLOBALS["WE_FORM"]]) ? $GLOBALS["we_object"][$GLOBALS["WE_FORM"]] : (isset(
				$GLOBALS["we_document"][$GLOBALS["WE_FORM"]]) ? $GLOBALS["we_document"][$GLOBALS["WE_FORM"]] : (isset(
				$GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : false));
		if ($objekt) {
			$values = $objekt->Category;
		}
		$valuesArray = makeArrayFromCSV(id_to_path($values, CATEGORY_TABLE));
	} else {
		if ($type == "request") {
			// Bug Fix #750
			if (isset($_REQUEST[$name])) {
				if (is_array($_REQUEST[$name])) {
					$values = implode(",", $_REQUEST[$name]);
				} else {
					$values = $_REQUEST[$name];
				}
			} else {
				$values = "";
			}
		} else {
			// Bug Fix #750
			if (isset($GLOBALS[$name]) && is_array($GLOBALS[$name])) {
				$values = implode(",", $GLOBALS[$name]);
			} else {
				$values = $GLOBALS[$name];
			}
		}
		$valuesArray = makeArrayFromCSV($values, CATEGORY_TABLE);
	}
	
	$attribs["name"] = $name;
	
	// Bug Fix #750
	if (isset($attribs["multiple"]) && $attribs["multiple"] == "true") {
		$attribs["name"] .= "[]";
		$attribs["multiple"] = "multiple";
	} else {
		$attribs = removeAttribs($attribs, array(
			'size', 'multiple'
		));
	}
	
	$attribs = removeAttribs($attribs, array(
		'showpath', 'rootdir', 'firstentry', 'type'
	));
	
	if (!$content) {
		if ($firstentry) {
			$content .= getHtmlTag('option', array(
				'value' => ''
			), $firstentry) . "\n";
		}
		$db = new DB_WE();
		$dbfield = $showpath ? "Path" : "Category";
		$db->query("SELECT Path,Category FROM " . CATEGORY_TABLE . " WHERE Path like '".mysql_real_escape_string($rootdir)."%' ORDER BY $dbfield");
		while ($db->next_record()) {
			$deep = sizeof(explode("/", $db->f('Path'))) - 2;
			$field = $db->f($dbfield);
			if ($rootdir && $rootdir != "/" && $showpath) {
				$field = ereg_replace('^' . quotemeta($rootdir) . '(.*)$', '\1', $field);
			}
			if ($field) {
				if (in_array($db->f("Path"), $valuesArray)) {
					$content .= getHtmlTag(
							'option', 
							array(
								'value' => $db->f("Path"), 'selected' => 'selected'
							), 
							str_repeat($indent, $deep) . $field) . "\n";
				} else {
					$content .= getHtmlTag('option', array(
						'value' => $db->f("Path")
					), str_repeat($indent, $deep) . $field) . "\n";
				}
			}
		}
	} else {
		foreach ($valuesArray as $catPaths) {
			if (eregi("<option>", $content)) {
				$content = eregi_replace(
						'<option>' . quotemeta($catPaths) . '( ?[<\n\r\t])', 
						'<option selected="selected">' . $catPaths . '\1', 
						$content);
			}
			$content = str_replace(
					'<option value="' . $catPaths . '">', 
					'<option value="' . $catPaths . '" selected="selected">', 
					$content);
		}
	}
	return getHtmlTag('select', $attribs, $content, true) . "\n";
}

function we_tag_condition($attribs, $content)
{
	
	$name = we_getTagAttribute("name", $attribs, "we_lv_condition");
	
	$GLOBALS["we_lv_conditionCount"] = isset($GLOBALS["we_lv_conditionCount"]) ? abs($GLOBALS["we_lv_conditionCount"]) : 0;
	
	if ($GLOBALS["we_lv_conditionCount"] == 0) {
		$GLOBALS["we_lv_conditionName"] = $name;
		$GLOBALS[$GLOBALS["we_lv_conditionName"]] = "(";
	} else {
		$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= "(";
	}
	$GLOBALS["we_lv_conditionCount"]++;
	return "";
}

function we_tag_conditionAdd($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "field", "conditionAdd");
	if ($foo)
		return $foo;
		
	// initialize possible Attributes
	$field = we_getTagAttribute("field", $attribs);
	$value = we_getTagAttribute("value", $attribs);
	$compare = we_getTagAttribute("compare", $attribs, "=");
	$var = we_getTagAttribute("var", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$property = we_getTagAttribute("property", $attribs, "", true);
	$docAttr = we_getTagAttribute("doc", $attribs);
	// end initialize possible Attributes
	

	$value = str_replace('&gt;', '>', $value);
	$value = str_replace('&lt;', '<', $value);
	
	$regs = array();
	if ($var && $compare == "like") {
		if (ereg('^(%)?([^%]+)(%)?$', $var, $regs)) {
			$var = $regs[2];
		}
	}
	switch (strtolower($type)) {
		case "now" :
			$value = time();
		case "sessionfield" :
			if ($var && isset($_SESSION["webuser"][$var])) {
				$value = $_SESSION["webuser"][$var];
			}
			break;
		case "document" :
			if ($var) {
				$doc = we_getDocForTag($docAttr, false);
				if ($property) {
					eval('$value = $doc->' . $var . ';');
				} else {
					$value = $doc->getElement($var);
				}
			}
			break;
		case "request" :
			if ($var && isset($_REQUEST[$var])) {
				$value = $_REQUEST[$var];
			}
			break;
		default :
			if ($var && isset($GLOBALS[$var])) {
				$value = $GLOBALS[$var];
			}
	}
	
	$value = (isset($regs[1]) ? $regs[1] : "") . $value . (isset($regs[3]) ? $regs[3] : "");
	
	if (strlen($field) && isset($GLOBALS["we_lv_conditionName"]) && isset($GLOBALS[$GLOBALS["we_lv_conditionName"]])) {
		$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= " ($field $compare '" . addslashes($value) . "') ";
	} else {
		if (eregi('^(.*)AND ?$', $GLOBALS[$GLOBALS["we_lv_conditionName"]])) {
			$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= "1 ";
		} else {
			$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= "0 ";
		}
	}
	return "";
}

function we_tag_conditionAND($attribs, $content)
{
	if (isset($GLOBALS["we_lv_conditionName"]) && isset($GLOBALS[$GLOBALS["we_lv_conditionName"]])) {
		$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= " AND ";
	}
	return "";
}

function we_tag_conditionOR($attribs, $content)
{
	if (isset($GLOBALS["we_lv_conditionName"]) && isset($GLOBALS[$GLOBALS["we_lv_conditionName"]])) {
		$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= " OR ";
	}
	return "";
}

function we_tag_css($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "id", "css");
	if ($foo)
		return $foo;
	$id = we_getTagAttribute("id", $attribs);
	$rel = we_getTagAttribute("rel", $attribs, "stylesheet");
	
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
	if (count($row)) {
		$url = $row["Path"] . ($row["IsFolder"] ? "/" : "");
		
		//	remove not needed elements
		$attribs = removeAttribs($attribs, array(
			"id", "rel"
		));
		
		$attribs["rel"] = $rel;
		$attribs["type"] = "text/css";
		$attribs["href"] = $url;
		
		return getHtmlTag("link", $attribs);
	}
	return "";
}

function we_tag_date($attribs, $content)
{
	global $l_dayShort, $l_monthLong, $l_dayLong, $l_monthShort;
	
	$type = we_getTagAttribute("type", $attribs);
	$format = we_getTagAttribute("format", $attribs, $GLOBALS["l_global"]["date_format"]);
	
	$xml = we_getTagAttribute("xml", $attribs, "");
	
	if (strtolower($type) == "js") {
		$js = "\nheute = new Date();\n";
		$js .= 'function getDateS(d){' . "\n";
		$js .= '	switch(d){' . "\n";
		$js .= '		case 1:' . "\n";
		$js .= '		case 21:' . "\n";
		$js .= '		case 31:' . "\n";
		$js .= '			return "st";' . "\n";
		$js .= '		case 2:' . "\n";
		$js .= '		case 22:' . "\n";
		$js .= '			return "nd";' . "\n";
		$js .= '		case 3:' . "\n";
		$js .= '		case 23:' . "\n";
		$js .= '			return "rd";' . "\n";
		$js .= '		default:' . "\n";
		$js .= '			return "th";' . "\n";
		$js .= '	}' . "\n";
		$js .= '}' . "\n";
		
		$js .= 'function getDateWord(f,dateObj){' . "\n";
		$js .= '	var l_day_Short = new Array(';
		foreach ($l_dayShort as $d) {
			$js .= '"' . $d . '",';
		}
		$js = ereg_replace('^(.+),$', '\1', $js);
		$js .= ');' . "\n";
		
		$js .= '	var l_monthLong = new Array(';
		foreach ($l_monthLong as $d) {
			$js .= '"' . $d . '",';
		}
		$js = ereg_replace('^(.+),$', '\1', $js);
		$js .= ');' . "\n";
		
		$js .= '	var l_dayLong = new Array(';
		foreach ($l_dayLong as $d) {
			$js .= '"' . $d . '",';
		}
		$js = ereg_replace('^(.+),$', '\1', $js);
		$js .= ');' . "\n";
		
		$js .= '	var l_monthShort = new Array(';
		foreach ($l_monthShort as $d) {
			$js .= '"' . $d . '",';
		}
		$js = ereg_replace('^(.+),$', '\1', $js);
		$js .= ');' . "\n";
		
		$js .= '	switch(f){' . "\n";
		$js .= '		case "D":' . "\n";
		$js .= '			return l_day_Short[dateObj.getDay()];' . "\n";
		$js .= '		case "F":' . "\n";
		$js .= '			return l_monthLong[dateObj.getMonth()];' . "\n";
		$js .= '		case "l":' . "\n";
		$js .= '			return l_dayLong[dateObj.getDay()];' . "\n";
		$js .= '		case "M":' . "\n";
		$js .= '			return l_monthShort[dateObj.getMonth()];' . "\n";
		$js .= '	}' . "\n";
		$js .= '}' . "\n";
		
		$f = $format;
		
		if (ereg('[^\\]Y', $f) || ereg('^Y', $f))
			$js .= "var Y = heute.getYear();Y = (Y < 1900) ? (Y + 1900) : Y;\n";
		if (ereg('[^\\]y', $f) || ereg('^y', $f))
			$js .= "var y = heute.getYear();y = (y < 1900) ? (y + 1900) : y;y=y.substring(2,4);\n";
		;
		
		if (ereg('[^\\]a', $f) || ereg('^a', $f))
			$js .= "var a = (heute.getHours() > 11) ? 'pm' : 'am';\n";
		if (ereg('[^\\]A', $f) || ereg('^A', $f))
			$js .= "var A = (heute.getHours() > 11) ? 'PM' : 'AM';\n";
		if (ereg('[^\\]s', $f) || ereg('^s', $f))
			$js .= "var s = heute.getSeconds();\n";
		if (ereg('[^\\]m', $f) || ereg('^m', $f))
			$js .= "var m = heute.getMonth()+1;m = '00'+m;m=m.substring(m.length-2,m.length);\n";
		if (ereg('[^\\]n', $f) || ereg('^n', $f))
			$js .= "var n = heute.getMonth()+1;\n";
		if (ereg('[^\\]d', $f) || ereg('^d', $f))
			$js .= "var d = heute.getDate();d = '00'+d;d=d.substring(d.length-2,d.length);\n";
		if (ereg('[^\\]j', $f) || ereg('^j', $f))
			$js .= "var j = heute.getDate();\n";
		if (ereg('[^\\]h', $f) || ereg('^h', $f))
			$js .= "var h = heute.getHours();if(h > 12){h -= 12;};h = '00'+h;h=h.substring(h.length-2,h.length);\n";
		if (ereg('[^\\]H', $f) || ereg('^H', $f))
			$js .= "var H = heute.getHours();H = '00'+H;H=H.substring(H.length-2,H.length);\n";
		if (ereg('[^\\]g', $f) || ereg('^g', $f))
			$js .= "var g = heute.getHours();if(g > 12){ g -= 12;};\n";
		if (ereg('[^\\]G', $f) || ereg('^G', $f))
			$js .= "var G = heute.getHours();\n";
		if (ereg('[^\\]i', $f) || ereg('^i', $f))
			$js .= "var i = heute.getMinutes();i = '00'+i;i=i.substring(i.length-2,i.length);\n";
		if (ereg('[^\\]S', $f) || ereg('^S', $f))
			$js .= "var S = getDateS(heute.getDate());\n";
		
		if (ereg('[^\\]D', $f) || ereg('^D', $f))
			$js .= "var D = getDateWord('D',heute);\n";
		if (ereg('[^\\]F', $f) || ereg('^F', $f))
			$js .= "var F = getDateWord('F',heute);\n";
		if (ereg('[^\\]l', $f) || ereg('^l', $f))
			$js .= "var l = getDateWord('l',heute);\n";
		if (ereg('[^\\]M', $f) || ereg('^M', $f))
			$js .= "var M = getDateWord('M',heute);\n";
		
		$f = ereg_replace('([^\\])(Y)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(y)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(m)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(n)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(d)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(j)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(H)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(i)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(h)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(G)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(g)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(S)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(D)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(F)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(l)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(M)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(s)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(a)', '\1"+\2+"', $f);
		$f = ereg_replace('([^\\])(A)', '\1"+\2+"', $f);
		
		$f = ereg_replace('^([SYymndjHihGgDFlMsaA])', '"+\1+"', $f);
		$f = stripslashes($f);
		
		$js .= 'document.write("' . $f . '");' . "\n";
		
		$atts['language'] = 'JavaScript';
		$atts['type'] = 'text/javascript';
		$atts['xml'] = $xml;
		
		return getHtmlTag('script', $atts, $js);
	} else {
		return date(correctDateFormat($format));
	}
}

function we_tag_dateSelect($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "dateSelect");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$class = we_getTagAttribute("class", $attribs);
	
	$tmp_from = we_getTagAttribute("start", $attribs, "");
	$tmp_to = we_getTagAttribute("end", $attribs, "");
	
	$from = array();
	$to = array();
	$js = "";
	$checkDate = "";
	$minyear = "";
	$maxyear = "";
	if ($tmp_from != "" && $tmp_to != "") {
		$from = array(
			
				'year' => substr($tmp_from, 0, 4), 
				'month' => (substr($tmp_from, 5, 2)) - 1, 
				'day' => substr($tmp_from, 8, 2), 
				'hour' => strlen($tmp_from) == 16 ? substr($tmp_from, 11, 2) : 0, 
				'minute' => strlen($tmp_from) == 16 ? substr($tmp_from, 14, 2) : 0
		);
		$to = array(
			
				'year' => substr($tmp_to, 0, 4), 
				'month' => (substr($tmp_to, 5, 2)) - 1, 
				'day' => substr($tmp_to, 8, 2), 
				'hour' => strlen($tmp_to) == 16 ? substr($tmp_to, 11, 2) : 0, 
				'minute' => strlen($tmp_to) == 16 ? substr($tmp_to, 14, 2) : 0
		);
		$minyear = $from['year'];
		$maxyear = $to['year'];
		
		$js = '<script type="text/javascript">
<!--

function WE_checkDate_' . $name . '() {

	var name = \'' . $name . '\';

	var from = new Date(' . $from['year'] . ', ' . $from['month'] . ', ' . $from['day'] . ', ' . $from['hour'] . ', ' . $from['minute'] . ', 0);
	var to   = new Date(' . $to['year'] . ', ' . $to['month'] . ', ' . $to['day'] . ', ' . $to['hour'] . ', ' . $to['minute'] . ', 59);

	var now = new Date();

	var year = now.getFullYear();
	var month = now.getMonth();
	var day = now.getDate();
	var hour = now.getHours();
	var minute = now.getMinutes();
	var second = 30;

	for (i = 0; i < document.getElementById(name + \'_month\').length; ++i) {
		if (document.getElementById(name + \'_month\').options[i].selected == true) {
			month = document.getElementById(name + \'_month\').options[i].value-1;
		}
	}
	for (i = 0; i < document.getElementById(name + \'_year\').length; ++i) {
		if (document.getElementById(name + \'_year\').options[i].selected == true) {
			year = document.getElementById(name + \'_year\').options[i].value;
		}
	}
	for (i = 0; i < document.getElementById(name + \'_day\').length; ++i) {
		if (document.getElementById(name + \'_day\').options[i].selected == true) {
			day = document.getElementById(name + \'_day\').options[i].value;
		}
	}
	if(document.getElementById(name + \'_hour\').type == \'select-one\') {
		for (i = 0; i < document.getElementById(name + \'_hour\').length; ++i) {
			if (document.getElementById(name + \'_hour\').options[i].selected == true) {
				hour = document.getElementById(name + \'_hour\').options[i].value;
			}
		}
	}
	if(document.getElementById(name + \'_minute\').type == \'select-one\') {
		for (i = 0; i < document.getElementById(name + \'_minute\').length; ++i) {
			if (document.getElementById(name + \'_minute\').options[i].selected == true) {
				minute = document.getElementById(name + \'_minute\').options[i].value;
			}
		}
	}

	var test = new Date(year, month, day, hour, minute, second);

	if(!(test.getTime() >= from.getTime() && test.getTime() < to.getTime())) {
		if(test.getTime() < from.getTime()) {
			correct = from;
		} else {
			correct = to;
		}
	} else {
		correct = test;
		while(correct.getMonth() != month) {
			correct.setDate(correct.getDate()-1);
		}
	}
	for (i = 0; i < document.getElementById(name + \'_year\').length; ++i) {
		if (document.getElementById(name + \'_year\').options[i].value == correct.getFullYear()) {
			document.getElementById(name + \'_year\').options[i].selected = true;
		}
	}
	for (i = 0; i < document.getElementById(name + \'_month\').length; ++i) {
		if (document.getElementById(name + \'_month\').options[i].value == correct.getMonth()+1) {
			document.getElementById(name + \'_month\').options[i].selected = true;
		}
	}
	for (i = 0; i < document.getElementById(name + \'_day\').length; ++i) {
		if (document.getElementById(name + \'_day\').options[i].value == correct.getDate()) {
			document.getElementById(name + \'_day\').options[i].selected = true;
		}
	}
	if(document.getElementById(name + \'_hour\').type == \'select-one\') {
		for (i = 0; i < document.getElementById(name + \'_hour\').length; ++i) {
			if (document.getElementById(name + \'_hour\').options[i].value == correct.getHours()) {
				document.getElementById(name + \'_hour\').options[i].selected = true;
			}
		}
	}
	if(document.getElementById(name + \'_minute\').type == \'select-one\') {
		for (i = 0; i < document.getElementById(name + \'_minute\').length; ++i) {
			if (document.getElementById(name + \'_minute\').options[i].value == correct.getMinutes()) {
				document.getElementById(name + \'_minute\').options[i].selected = true;
			}
		}
	}

}
WE_checkDate_' . $name . '();

//-->
</script>';
		
		$checkDate = "WE_checkDate_" . $name . "();";
	}
	
	$submitonchange = we_getTagAttribute("submitonchange", $attribs, "", true);
	return getDateInput2(
			"$name%s", 
			(((!isset($_REQUEST[$name])) || $_REQUEST[$name] == -1) ? time() : $_REQUEST[$name]), 
			false, 
			"dmy", 
			$submitonchange ? $checkDate . "we_submitForm();" : $checkDate, 
			$class, 
			"", 
			$minyear, 
			$maxyear) . $js;
}

function we_tag_delete($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "document");
	$userid = we_getTagAttribute("userid", $attribs); // deprecated  use protected=true instead
	$protected = we_getTagAttribute("protected", $attribs, "", true);
	$admin = we_getTagAttribute("admin", $attribs);
	$mail = we_getTagAttribute("mail", $attribs);
	$mailfrom = we_getTagAttribute("mailfrom", $attribs);
	$charset = we_getTagAttribute("charset", $attribs, "iso-8859-1");
	$doctype = we_getTagAttribute("doctype", $attribs);
	$classid = we_getTagAttribute("classid", $attribs);
	$pid = we_getTagAttribute("pid", $attribs);
	$forceedit = we_getTagAttribute("forceedit", $attribs, "", true);
	
	if ($type == "document") {
		if (!isset($_REQUEST["we_delDocument_ID"])) {
			return "";
		}
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_classes/we_webEditionDocument.inc.php");
		$docID = $_REQUEST["we_delDocument_ID"];
		$doc = new we_webEditionDocument();
		$doc->initByID($docID);
		$table = FILE_TABLE;
		if ($doctype) {
			$doctypeID = f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType like '".mysql_real_escape_string($doctype)."'", "ID", new DB_WE());
			if ($doc->DocType != $doctypeID) {
				$GLOBALS["we_" . $type . "_delete_ok"] = false;
				return "";
			}
		}
	} else {
		if (!isset($_REQUEST["we_delObject_ID"])) {
			return "";
		}
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_modules/object/we_objectFile.inc.php");
		$docID = $_REQUEST["we_delObject_ID"];
		$doc = new we_objectFile();
		$doc->initByID($docID, OBJECT_FILES_TABLE);
		$table = OBJECT_FILES_TABLE;
		if ($classid) {
			if ($doc->TableID != $classid) {
				$GLOBALS["we_" . $type . "_delete_ok"] = false;
				return "";
			}
		}
	}
	
	if ($pid) {
		if ($doc->ParentID != $pid) {
			$GLOBALS["we_" . $type . "_delete_ok"] = false;
			return "";
		}
	}
	
	$isOwner = false;
	if ($protected) {
		$isOwner = ($_SESSION["webuser"]["ID"] == $doc->WebUserID);
	} else 
		if ($userid) {
			$isOwner = ($_SESSION["webuser"]["ID"] == $doc->getElement($userid));
		}
	$isAdmin = false;
	if ($admin) {
		$isAdmin = isset($_SESSION["webuser"][$admin]) && $_SESSION["webuser"][$admin];
	}
	
	if ($isAdmin || $isOwner || $forceedit) {
		$GLOBALS["NOT_PROTECT"] = true;
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_delete_fn.inc.php");
		deleteEntry($docID, $table);
		$GLOBALS["we_" . $type . "_delete_ok"] = true;
		if ($mail) {
			if (!$mailfrom) {
				$mailfrom = "dontReply@" . $GLOBALS["SERVER_NAME"];
			}
			if ($type == "object") {
				$mailtext = sprintf($GLOBALS["l_global"]["std_mailtext_delObj"], $doc->Path) . "\n";
				$subject = $GLOBALS["l_global"]["std_subject_delObj"];
			} else {
				$mailtext = sprintf($GLOBALS["l_global"]["std_mailtext_delDoc"], $doc->Path) . "\n";
				$subject = $GLOBALS["l_global"]["std_subject_delDoc"];
			}
			$phpmail = new we_util_Mailer($mail, $subject, $mailfrom);
			$phpmail->setCharSet($charset);
			$phpmail->addTextPart(trim($mailtext));				
			$phpmail->buildMessage();
			$phpmail->Send();
		}
	} else {
		$GLOBALS["we_" . $type . "_delete_ok"] = false;
	}
	return "";
}

function we_tag_description($attribs, $content)
{
	global $DESCRIPTION;
	$htmlspecialchars = we_getTagAttribute("htmlspecialchars", $attribs, "", true);
	$attribs = removeAttribs($attribs, array(
		'htmlspecialchars'
	));
	
	if ($GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PROPERTIES && $GLOBALS["we_doc"]->InWebEdition) { //	normally meta tags are edited on property page
		

		return '<?php	$GLOBALS["meta"]["Description"]["default"] = "' . str_replace('"', '\"', $content) . '"; ?>';
	} else {
		
		$descr = $DESCRIPTION ? $DESCRIPTION : $content;
		
		$attribs["name"] = "description";
		$attribs["content"] = $htmlspecialchars ? htmlspecialchars(strip_tags($descr)) : strip_tags($descr);
		
		return getHtmlTag("meta", $attribs) . "\n";
	}
}

function we_tag_DID($attribs, $content)
{
	$docAttr = we_getTagAttribute("doc", $attribs);
	if (!$docAttr) {
		$docAttr = we_getTagAttribute("type", $attribs); // for Compatibility Reasons
	}
	
	switch ($docAttr) {
		case "top" :
			return $GLOBALS["WE_MAIN_DOC"]->ID;
		case "listview" :
			return $GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count - 1];
		case "self" :
		default :
			return $GLOBALS["we_doc"]->ID;
	}
}

function we_tag_docType($attribs, $content)
{
	$docAttr = we_getTagAttribute("doc", $attribs);
	$doctype = "";
	switch ($docAttr) {
		case "self" :
			if ($GLOBALS["we_doc"]->DocType) {
				$doctype = f(
						"SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID = " . mysql_real_escape_string($GLOBALS["we_doc"]->DocType), 
						"DocType", 
						new DB_WE());
			}
			break;
		case "top" :
		default :
			if (isset($GLOBALS["WE_MAIN_DOC"])) {
				if ($GLOBALS["WE_MAIN_DOC"]->DocType) {
					$doctype = f(
							"SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID = " . mysql_real_escape_string($GLOBALS["WE_MAIN_DOC"]->DocType), 
							"DocType", 
							new DB_WE());
				}
			} elseif ($GLOBALS["we_doc"]->DocType) { // if we_doc is the "top-document"
				$doctype = f(
						"SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID = " . mysql_real_escape_string($GLOBALS["we_doc"]->DocType), 
						"DocType", 
						new DB_WE());
			}
			break;
	}
	return $doctype;
}

function we_tag_field($attribs, $content)
{
	
	$name = we_getTagAttribute("name", $attribs);
	$href = we_getTagAttribute("href", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$alt = we_getTagAttribute("alt", $attribs);
	$value = we_getTagAttribute("value", $attribs);
	$max = we_getTagAttribute("max", $attribs);
	$format = we_getTagAttribute("format", $attribs);
	$target = we_getTagAttribute("target", $attribs);
	$tid = we_getTagAttribute("tid", $attribs);
	$class = we_getTagAttribute("class", $attribs);
	$classid = we_getTagAttribute("classid", $attribs);
	$style = we_getTagAttribute("style", $attribs);
	$hyperlink = we_getTagAttribute("hyperlink", $attribs, "", true);
	$src = we_getTagAttribute("src", $attribs);
	$winprops = we_getTagAttribute("winprops", $attribs);
	$id = we_getTagAttribute("id", $attribs);
	$xml = we_getTagAttribute("xml", $attribs, "");
	$striphtml = we_getTagAttribute("striphtml", $attribs, false, true);
	
	$out = "";
	
	$seeMode = we_getTagAttribute("seeMode", $attribs, true, true, true);
	
	if (!isset($GLOBALS["lv"])) {
		return parseError($GLOBALS["l_parser"]["field_not_in_lv"]);
	}
	$lvname = isset($GLOBALS["lv"]->name) ? $GLOBALS["lv"]->name : "";
	
	if ($alt == "we_path")
		$alt = "WE_PATH";
	if ($alt == "we_text")
		$alt = "WE_TEXT";
	if ($name == "we_path")
		$name = "WE_PATH";
	if ($name == "we_text")
		$name = "WE_TEXT";
	
	if (isset($attribs["winprops"])) {
		unset($attribs["winprops"]);
	}
	$classid = $classid ? $classid : (isset($GLOBALS["lv"]) ? (isset($GLOBALS["lv"]->object->classID) ? $GLOBALS["lv"]->object->classID : (isset(
			$GLOBALS["lv"]->classID) ? $GLOBALS["lv"]->classID : "")) : (isset($GLOBALS["we_doc"]->TableID) ? $GLOBALS["we_doc"]->TableID : 0));
	$isImageDoc = false;
	if (isset($GLOBALS["lv"]->Record["wedoc_ContentType"]) && $GLOBALS["lv"]->Record["wedoc_ContentType"] == "image/*") {
		$isImageDoc = true;
	}
	
	$isCalendar = false;
	if (isset($GLOBALS["lv"]->calendar_struct["calendar"]) && $GLOBALS["lv"]->calendar_struct["calendar"] != "" && $GLOBALS["lv"]->isCalendarField(
			$type)) {
		$isCalendar = true;
	}
	
	if (!$GLOBALS["lv"]->f("WE_ID") && $GLOBALS["lv"]->calendar_struct["calendar"] == "") {
		return "";
	}
	switch ($type) {
		
		case "binary" :
			$t = we_document::getFieldByVal(
					$GLOBALS["lv"]->f($name), 
					$type, 
					$attribs, 
					false, 
					$GLOBALS["we_doc"]->ParentID, 
					$GLOBALS["we_doc"]->Path, 
					$GLOBALS["DB_WE"], 
					$classid, 
					'$GLOBALS["lv"]->f');
			$out = $t[0];
			$href = (empty($href) ? $t[1] : $href);
			break;
		case "link" :
			if ($GLOBALS["lv"]->ClassName) {
				$out = we_document::getFieldByVal(
						$GLOBALS["lv"]->f($name), 
						"link", 
						$attribs, 
						false, 
						$GLOBALS["we_doc"]->ParentID, 
						$GLOBALS["we_doc"]->Path, 
						$GLOBALS["DB_WE"], 
						$classid, 
						'$GLOBALS["lv"]->f');
				$href = (empty($href) ? $out : $href);
				break;
			}
		case "href" :
			if (isset($GLOBALS["lv"]) && ($GLOBALS["lv"]->ClassName == "we_listview_multiobject" || $GLOBALS["lv"]->ClassName == "we_listview_object" || $GLOBALS["lv"]->ClassName == "we_objecttag")) {
				$hrefArr = $GLOBALS["lv"]->f($name) ? unserialize($GLOBALS["lv"]->f($name)) : array();
				if (!is_array($hrefArr))
					$hrefArr = array();
				$out = sizeof($hrefArr) ? we_document::getHrefByArray($hrefArr) : "";
				break;
			}
		case "date" :
		case "img" :
		case "int" :
		case "float" :
		case "checkbox" :
			
			if ($src && $type == "img") {
				
				$_imgAtts['alt'] = ''; //  alt must be set
				$_imgAtts['src'] = $src; //  src
				$_imgAtts['xml'] = $xml; //  xml
				
				$_imgAtts = array_merge(
						$_imgAtts, 
						useAttribs(
								$attribs, 
								array(
									'alt', 'width', 'height', 'border', 'hspace', 'align', 'vspace'
								))); //  use some atts form attribs array
				$_imgAtts = removeEmptyAttribs($_imgAtts, array(
					'alt'
				));
				
				$out = getHtmlTag('img', $_imgAtts);
			
			} else {
				
				$out = we_document::getFieldByVal(
						($isImageDoc && $type == "img") ? $GLOBALS["lv"]->Record["wedoc_ID"] : $GLOBALS["lv"]->f(
								$name), 
						$type, 
						$attribs, 
						false, 
						$GLOBALS["we_doc"]->ParentID, 
						$GLOBALS["we_doc"]->Path, 
						$GLOBALS["DB_WE"], 
						$classid, 
						'$GLOBALS["lv"]->f');
			}
			break;
		case "day" :
		case "dayname" :
		case "dayname_long" :
		case "dayname_short" :
		case "month" :
		case "monthname" :
		case "monthname_long" :
		case "monthname_short" :
		case "year" :
		case "hour" :
		case "week" :
			$out = listviewBase::getCalendarField($GLOBALS["lv"]->calendar_struct["calendar"], $type);
			break;
		
		case "multiobject" :
			$temp = unserialize($GLOBALS["lv"]->DB_WE->Record['we_' . $name]);
			if (isset($temp['objects']) && sizeof($temp['objects']) > 0) {
				$out = implode(",", $temp['objects']);
			} else {
				$out = "";
			}
			break;
		
		case 'shopVat' :
			
			if (defined('SHOP_TABLE')) {
				
				$normVal = we_document::getFieldByVal(
						$GLOBALS["lv"]->f(WE_SHOP_VAT_FIELD_NAME, 'txt'), 
						$type, 
						$attribs, 
						false, 
						$GLOBALS["we_doc"]->ParentID, 
						$GLOBALS["we_doc"]->Path, 
						$GLOBALS["DB_WE"], 
						$classid, 
						'$GLOBALS["lv"]->getElement');
				
				require_once (WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
				$out = weShopVats::getVatRateForSite($normVal);
			}
			break;
		
		default :
			$normVal = we_document::getFieldByVal(
					$GLOBALS["lv"]->f($name), 
					$type, 
					$attribs, 
					false, 
					$GLOBALS["we_doc"]->ParentID, 
					$GLOBALS["we_doc"]->Path, 
					$GLOBALS["DB_WE"], 
					$classid, 
					'$GLOBALS["lv"]->getElement');
			// bugfix 7557
			// wenn die Abfrage im Aktuellen Objekt kein Erg�bnis liefert
			// wird in den eingebundenen Objekten �berpr�ft ob das Feld existiert
			if ($type == "select" && $normVal == "") {
				
				foreach ($GLOBALS["lv"]->DB_WE->Record as $_glob_key => $_val) {
					
					if (substr($_glob_key, 0, 13) == "we_we_object_") {
						
						$normVal = we_document::getFieldByVal(
								$GLOBALS["lv"]->f($name), 
								$type, 
								$attribs, 
								false, 
								$GLOBALS["we_doc"]->ParentID, 
								$GLOBALS["we_doc"]->Path, 
								$GLOBALS["DB_WE"], 
								substr($_glob_key, 13), 
								'$GLOBALS["lv"]->getElement');
					}
					
					if ($normVal != "")
						break;
				}
			}
			// EOF bugfix 7557
			

			if ($name && $name != 'we_href') {
				
				if ($normVal == "") {
					$altVal = we_document::getFieldByVal(
							$GLOBALS["lv"]->f($alt), 
							$type, 
							$attribs, 
							false, 
							$GLOBALS["we_doc"]->ParentID, 
							$GLOBALS["we_doc"]->Path, 
							$GLOBALS["DB_WE"], 
							$classid, 
							'$GLOBALS["lv"]->getElement');
					if ($altVal == "")
						return "";
					$out = cutText($altVal, $max);
				} else {
					$out = cutText($normVal, $max);
				}
			
			} else 
				if ($value) {
					$out = $value;
				}
			if ($striphtml) {
				$out = strip_tags($out);
			}
	}
	
	if ($hyperlink || $name == 'we_href') {
		
		$_linkAttribs['xml'] = $xml;
		if ($target && !$winprops) { //  save atts in array
			$_linkAttribs['target'] = $target;
		}
		if ($class) {
			$_linkAttribs['class'] = $class;
		}
		if ($style) {
			$_linkAttribs['style'] = $style;
		}
		
		if ($winprops) {
			
			if (!$GLOBALS['we_doc']->InWebEdition) { //	we are NOT in webEdition open new window
				

				$js = "";
				$newWinProps = "";
				$winpropsArray = array();
				$probsPairs = makeArrayFromCSV($winprops);
				
				foreach ($probsPairs as $pair) {
					$foo = explode("=", $pair);
					if (isset($foo[0]) && $foo[0]) {
						$winpropsArray[$foo[0]] = isset($foo[1]) ? $foo[1] : "";
					}
				}
				
				if (isset($winpropsArray["left"]) && ($winpropsArray["left"] == -1) && isset($winpropsArray["width"]) && $winpropsArray["width"]) {
					$js .= 'if (window.screen) {' . 'var screen_width = screen.availWidth;' . 'var w = Math.min(screen_width, ' . $winpropsArray["width"] . ');' . '}' . 'var x = Math.round((screen_width - w) / 2);';
					
					$newWinProps .= "width='+w+',left='+x+',";
					unset($winpropsArray["left"]);
					unset($winpropsArray["width"]);
				} else {
					if (isset($winpropsArray["left"])) {
						$newWinProps .= 'left=' . $winpropsArray["left"] . ',';
						unset($winpropsArray["left"]);
					}
					if (isset($winpropsArray["width"])) {
						$newWinProps .= 'width=' . $winpropsArray["width"] . ',';
						unset($winpropsArray["width"]);
					}
				}
				if (isset($winpropsArray["top"]) && ($winpropsArray["top"] == -1) && isset($winpropsArray["height"]) && $winpropsArray["height"]) {
					$js .= 'if (window.screen) {' . 'var screen_height = ((screen.height - 50) > screen.availHeight ) ? screen.height - 50 : screen.availHeight;screen_height = screen_height - 40;' . 'var h = Math.min(screen_height, ' . $winpropsArray["height"] . ');' . '}' . 'var y = Math.round((screen_height - h) / 2);';
					
					$newWinProps .= "height='+h+',top='+y+',";
					unset($winpropsArray["top"]);
					unset($winpropsArray["height"]);
				} else {
					if (isset($winpropsArray["top"])) {
						$newWinProps .= 'top=' . $winpropsArray["top"] . ',';
						unset($winpropsArray["top"]);
					}
					if (isset($winpropsArray["height"])) {
						$newWinProps .= 'height=' . $winpropsArray["height"] . ',';
						unset($winpropsArray["height"]);
					}
				}
				foreach ($winpropsArray as $k => $v) {
					if ($k && $v) {
						$newWinProps .= "$k=$v,";
					}
				}
				$newWinProps = ereg_replace('^(.+),$', '\1', $newWinProps);
				
				$_linkAttribs['onclick'] = $js . ';var we_win = window.open(\'\',\'win_' . $name . '\',\'' . $newWinProps . '\');';
				$_linkAttribs['target'] = 'win_' . $name;
			
			} else { // we are in webEdition
				if ($_SESSION['we_mode'] == 'seem') { //	we are in seeMode -> open in edit_include ?....
				

				}
			}
		}
		
		if ($href) {
			$_linkAttribs['href'] = $href;
			$out = getHtmlTag('a', $_linkAttribs, $out);
		} else {
			
			if ($id && $isCalendar) {
				if (isset($GLOBALS["lv"]->calendar_struct["storage"]) && count(
						$GLOBALS["lv"]->calendar_struct["storage"])) {
					$found = false;
					foreach ($GLOBALS["lv"]->calendar_struct["storage"] as $date) {
						if ((($GLOBALS["lv"]->calendar_struct["calendarCount"] > 0 || ($GLOBALS["lv"]->calendar_struct["calendar"] == "day" && $GLOBALS["lv"]->calendar_struct["calendarCount"] >= 0)) && $GLOBALS["lv"]->calendar_struct["calendarCount"] <= $GLOBALS["lv"]->calendar_struct["numofentries"]) && ((int)$date >= (int)$GLOBALS["lv"]->calendar_struct["start_date"] && (int)$date <= (int)$GLOBALS["lv"]->calendar_struct["end_date"])) {
							$found = true;
							break;
						}
					}
					if ($found) {
						if ($GLOBALS["lv"]->calendar_struct["calendar"] == "year")
							$show = "month";
						else
							$show = "day";
						$listviewname = we_getTagAttribute("listviewname", $attribs, $lvname);
						
						$_linkAttribs['href'] = id_to_path($id) . '?' . (isset($GLOBALS["lv"]->contentTypes) && $GLOBALS["lv"]->contentTypes ? ('we_lv_ct_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->contentTypes) . '&amp;') : '') . ($GLOBALS["lv"]->order ? ('we_lv_order_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->order) . '&amp;') : '') . ($GLOBALS["lv"]->desc ? ('we_lv_desc_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->desc) . '&amp;') : '') . ($GLOBALS["lv"]->cats ? ('we_lv_cats_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->cats) . '&amp;') : '') . ($GLOBALS["lv"]->catOr ? ('we_lv_catOr_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->catOr) . '&amp;') : '') . ($GLOBALS["lv"]->workspaceID ? ('we_lv_ws_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->workspaceID) . '&amp;') : '') . ((isset(
								$GLOBALS["lv"]->searchable) && !$GLOBALS["lv"]->searchable) ? ('we_lv_se_' . $listviewname . '=0&amp;') : '') . ('we_lv_calendar_' . $listviewname . '=' . rawurlencode(
								$show) . '&amp;') . ($GLOBALS["lv"]->calendar_struct["datefield"] != "" ? ('we_lv_datefield_' . $listviewname . '=' . rawurlencode(
								$GLOBALS["lv"]->calendar_struct["datefield"]) . '&amp;') : '') . ($GLOBALS["lv"]->calendar_struct["date"] >= 0 ? ('we_lv_date_' . $listviewname . '=' . rawurlencode(
								date("Y-m-d", $GLOBALS["lv"]->calendar_struct["date"]))) : '');
						
						$out = getHtmlTag('a', $_linkAttribs, $out);
					}
				}
			} else 
				if ($id && $isImageDoc) {
					$_linkAttribs['href'] = id_to_path($id) . '?' . ($GLOBALS["lv"]->contentTypes ? ('we_lv_ct_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->contentTypes) . '&amp;') : '') . ($GLOBALS["lv"]->order ? ('we_lv_order_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->order) . '&amp;') : '') . ($GLOBALS["lv"]->desc ? ('we_lv_desc_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->desc) . '&amp;') : '') . ($GLOBALS["lv"]->cats ? ('we_lv_cats_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->cats) . '&amp;') : '') . ($GLOBALS["lv"]->catOr ? ('we_lv_catOr_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->catOr) . '&amp;') : '') . ($GLOBALS["lv"]->workspaceID ? ('we_lv_ws_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->workspaceID) . '&amp;') : '') . ((!$GLOBALS["lv"]->searchable) ? ('we_lv_se_' . $lvname . '=0&amp;') : '') . (isset(
							$GLOBALS["lv"]->condition) && $GLOBALS["lv"]->condition != "" ? ('we_lv_condition_' . $lvname . '=' . rawurlencode(
							$GLOBALS["lv"]->condition) . '&amp;') : '') . 'we_lv_start_' . $lvname . '=' . (($GLOBALS["lv"]->count + $GLOBALS["lv"]->start) - 1) . '&amp;we_lv_pend_' . $lvname . '=' . ($GLOBALS["lv"]->start + $GLOBALS["lv"]->anz) . '&amp;we_lv_pstart_' . $lvname . '=' . ($GLOBALS["lv"]->start);
					
					$out = getHtmlTag('a', $_linkAttribs, $out);
				
				} else {
					
					if ($tid) {
						$GLOBALS["lv"]->tid = $tid;
					}
					
					if (isset($GLOBALS["lv"]->ClassName) && $GLOBALS["lv"]->ClassName == "we_search_listview" && $GLOBALS["lv"]->f(
							"OID")) {
						if ($tid) {
							$tail = "&amp;we_objectTID=" . $tid;
						} else {
							$tail = "";
						}
						$_linkAttribs['href'] = $_SERVER["PHP_SELF"] . '?we_objectID=' . $GLOBALS["lv"]->f("OID") . '&amp;pid=' . $GLOBALS["lv"]->f(
								"WorkspaceID") . $tail;
						
						if ($name == 'we_href') {
							$out = $_linkAttribs['href'];
						} else {
							$out = getHtmlTag('a', $_linkAttribs, $out); //  output of link-tag
						}
					} else 
						if (isset($GLOBALS["lv"]->ClassName) && $GLOBALS["lv"]->ClassName == "we_catListview" && we_tag_ifHasChildren(
								array(), 
								"")) {
							$parentidname = we_getTagAttribute('parentidname', $attribs, 'we_parentid');
							$_linkAttribs['href'] = $_SERVER["PHP_SELF"] . '?' . $parentidname . '=' . $GLOBALS["lv"]->f(
									"ID");
							
							if ($name == 'we_href') {
								$out = $_linkAttribs['href'];
							} else {
								$out = getHtmlTag('a', $_linkAttribs, $out); //  output of link-tag
							}
						} else {
							
							$showlink = (!isset($GLOBALS["lv"]->ClassName) || $GLOBALS["lv"]->ClassName == "" || $GLOBALS["lv"]->ClassName == "we_listview") || ($GLOBALS["lv"]->ClassName == "we_search_listview") || ($GLOBALS["lv"]->ClassName == "we_listview_shopVariants") || ($GLOBALS["lv"]->ClassName == "we_listview_shoppingCart") || ($GLOBALS["lv"]->ClassName == "we_objecttag") || ($GLOBALS["lv"]->ClassName == "we_customertag") || ($GLOBALS["lv"]->ClassName == "we_listview_customer") || ($tid && $GLOBALS["lv"]->ClassName == "we_listview_object") || ($GLOBALS["lv"]->ClassName == "we_listview_object" && ($GLOBALS["lv"]->DB_WE->f(
									"OF_Templates") || $GLOBALS["lv"]->docID)) || ($GLOBALS["lv"]->ClassName == "we_listview_multiobject" && ($GLOBALS["lv"]->DB_WE->f(
									"OF_Templates") || $GLOBALS["lv"]->docID));
							
							if ($showlink) {
								
								if ($tid && $GLOBALS["lv"]->ClassName == "we_listview_object") {
									$tail = "&amp;we_objectTID=$tid";
								} else {
									$tail = '';
								}
								
								if (($GLOBALS['we_doc']->ClassName == 'we_objectFile') && ($GLOBALS['we_doc']->InWebEdition)) {
									$_linkAttribs['href'] = $GLOBALS["lv"]->f("wedoc_lastPath") . $tail;
								} else {
									$_linkAttribs['href'] = $GLOBALS["lv"]->f("WE_PATH") . $tail;
								}
								
								if ($name == 'we_href') { //  return href for this object
									$out = $_linkAttribs['href'];
								} else {
									$out = getHtmlTag('a', $_linkAttribs, $out);
								}
							}
						}
				}
		}
	
	}
	
	if ($isImageDoc && isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem" && $GLOBALS["we_doc"]->InWebEdition && $GLOBALS["we_doc"]->ContentType != "text/weTmpl") {
		$out .= '<a href="' . $GLOBALS['lv']->f('WE_ID') . '" seem="edit_image"></a>';
	}
	
	//	Add a anchor to tell seeMode that this is an object.
	if (isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem" && (isset($GLOBALS["lv"]->ClassName) && $GLOBALS["lv"]->ClassName == "we_listview_object") && isset(
			$GLOBALS["_we_listview_object_flag"]) && $GLOBALS["_we_listview_object_flag"] && $GLOBALS["we_doc"]->InWebEdition && $GLOBALS["we_doc"]->ContentType != "text/weTmpl" && $GLOBALS["lv"]->seeMode && $seeMode) {
		
		$out = '<a href="' . $GLOBALS["lv"]->DB_WE->Record["OF_ID"] . '" seem="object"></a>
		<?php $GLOBALS["_we_listview_object_flag"] = false; ?>
		' . $out;
	
	}
	return $out;
}

function we_tag_flashmovie($attribs, $content)
{
	// Include Flash class
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_flashDocument.inc.php");
	
	// Define globals
	global $we_editmode;
	
	$foo = attributFehltError($attribs, "name", "flashmovie");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$id = $GLOBALS["we_doc"]->getElement($name, "bdid");
	$id = $id ? $id : we_getTagAttribute("id", $attribs);
	$fname = 'we_' . $GLOBALS["we_doc"]->Name . '_img[' . $name . '#bdid]';
	
	$showcontrol = we_getTagAttribute("showcontrol", $attribs, "true", true, true);
	$showflash = we_getTagAttribute("showflash", $attribs, "true", true, true);
	
	$attribs = removeAttribs($attribs, array(
		'showcontrol', 'showflash'
	));
	
	if ($we_editmode && !$showflash) {
		$out = '';
	} else {
		$out = $GLOBALS["we_doc"]->getField($attribs, "flashmovie");
	}
	
	if ($showcontrol && $we_editmode) {
		// Include button class
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		
		// Create new button object
		$we_button = new we_button();
		
		// Create "Edit Flash" button
		$flash_button = $we_button->create_button(
				"image:btn_edit_flash", 
				"javascript:we_cmd('openDocselector','" . $id . "', '" . FILE_TABLE . "', 'document.forms[\'we_form\'].elements[\'" . $fname . "\'].value', '', 'opener.setScrollTo();opener.top.we_cmd(\'reload_editpage\');opener._EditorFrame.setEditorIsHot(true);', '" . session_id() . "', 0, 'application/x-shockwave-flash', " . (we_hasPerm(
						"CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ")", 
				true);
		
		// Create "Delete/Clear Flash" button
		$clear_button = $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:we_cmd('remove_image', '" . $name . "')", 
				true);
		
		// Create HTML output
		

		$out = "
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"2\" background=\"" . IMAGE_DIR . "backgrounds/aquaBackground.gif\" style=\"border: solid #006DB8 1px;\">
				<tr>
					<td class=\"weEditmodeStyle\">$out
						<input type=\"hidden\" name=\"$fname\" value=\"" . $GLOBALS["we_doc"]->getElement(
				$name, 
				"bdid") . "\"></td>
				</tr>
				<tr>
					<td class=\"weEditmodeStyle\" align=\"center\">";
		$out .= $we_button->create_button_table(array(
			$flash_button, $clear_button
		), 5) . "</td></tr></table>";
	}
	//	When in SEEM - Mode add edit-Button to tag - textarea
	return $out;
}

function we_tag_formfield($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "name", "formfield");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	
	$types = makeArrayFromCSV(we_getTagAttribute("type", $attribs, "textinput"));
	$attrs = makeArrayFromCSV(we_getTagAttribute("attribs", $attribs));
	
	$type_sel = $GLOBALS["we_doc"]->getElement($name, 'fftype');
	$ffname = $GLOBALS["we_doc"]->getElement($name, 'ffname');
	
	$type_sel = $type_sel ? $type_sel : (sizeof($types) ? $types[0] : "textinput");
	
	$nameprefix = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . '#';
	
	$xml = we_getTagAttribute("xml", $attribs, "");
	$ff = array();
	
	$ret = "";
	
	// here add some mandatory fields
	$mandatoryFields = array();
	if (getXmlAttributeValueAsBoolean($xml)) {
		$mandatoryFields = array(
			'textarea_cols', 'textarea_rows'
		);
	}
	
	foreach ($attribs as $k => $v) {
		if (preg_match("/^([^_]+)_([^_]+)$/", $k, $m) && ($m[1] == $type_sel)) {
			if (in_array($k, $attrs)) {
				if (isset($GLOBALS["we_doc"]->elements[$name]['ff_' . $type_sel . '_' . $m[2]])) {
					$ff[$m[2]]['value'] = $GLOBALS["we_doc"]->getElement($name, 'ff_' . $type_sel . '_' . $m[2]);
				}
				$ff[$m[2]]['default'] = $attribs[$k];
			} else {
				/*$ff[$m[2]] = array('change' => 0, 'default' => $attribs[$k]);*/
				$ff[$m[2]]['change'] = 0;
				$ff[$m[2]]['default'] = $attribs[$k];
			}
			if (in_array($m[0], $mandatoryFields)) {
				for ($i = (sizeof($mandatoryFields) - 1); $i >= 0; $i--) {
					if ($mandatoryFields[$i] == $m[0]) {
						unset($mandatoryFields[$i]);
					}
				}
			}
		}
	}
	
	$attrs = array_merge($attrs, $mandatoryFields);
	
	foreach ($attrs as $a) {
		if (preg_match("/^([^_]+)_([^_]+)$/", $a, $m) && ($m[1] == $type_sel)) {
			
			//$ff[$m[2]] = array('change' => 1);
			$ff[$m[2]]['change'] = 1;
			
			if (isset($GLOBALS["we_doc"]->elements[$name]['ff_' . $type_sel . '_' . $m[2]])) {
				$t = $GLOBALS["we_doc"]->getElement($name, 'ff_' . $type_sel . '_' . $m[2]);
				if (!empty($t)) {
					$ff[$m[2]]['value'] = $t;
				}
			}
		}
	}
	
	if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) {
		$tmp_select = '<select name="' . $nameprefix . 'fftype]" onchange="setScrollTo();we_cmd(\'reload_editpage\');">' . "\n";
		foreach ($types as $k) {
			$tmp_select .= '<option value="' . $k . '"' . (($k == $type_sel) ? ' selected="selected"' : '') . '>' . $k . '</option>' . "\n";
		}
		$tmp_select .= '</select>';
		$tbl = '<table width="223" border="0" cellspacing="0" cellpadding="4" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif">
	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["name"] . ':&nbsp;</nobr></td>
		<td class=\"weEditmodeStyle\" width="161"><input type="text" name="' . $nameprefix . 'ffname]' . '" value="' . $ffname . '" size="24"></td>
	</tr>
	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["type"] . ':&nbsp;</nobr></td>
		<td class=\"weEditmodeStyle\" width="161">' . $tmp_select . '</td>
	</tr>
';
		
		if (sizeof($ff)) {
			$tbl .= '	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["attributes"] . ':&nbsp;</nobr></td>
		<td class=\"weEditmodeStyle\" width="161">
			<table border="0" cellspacing="0">
				<tr>
';
			
			foreach ($ff as $f => $m) {
				$tbl .= '<td class=\"weEditmodeStyle\" style="color: black; font-size: 10px; font-family: Verdana, sans-serif"><nobr><b>' . $f . ':</b><span style="color: black; font-size: 12px; font-family: Verdana, sans-serif">&nbsp;';
				$val = arrayKeyExists('value', $m) ? $m['value'] : '';
				
				$default = arrayKeyExists('default', $m) ? makeArrayFromCSV($m['default']) : array();
				
				if ($m['change'] == 1) {
					$valselect = "";
					if (sizeof($default) > 1) {
						$valselect = '<select name="' . $name . 'tmp" size="1" onchange="this.form.elements[\'' . $nameprefix . 'ff_' . $type_sel . '_' . $f . ']\'].value=this.options[this.selectedIndex].value;">' . "\n";
						$valselect .= '<option value=""></option>' . "\n";
						foreach ($default as $v) {
							$valselect .= '<option value="' . $v . '">' . $v . '</option>' . "\n";
						}
						$valselect .= '</select>' . "\n";
					}
					if ((!arrayKeyExists('value', $m)) && sizeof($default) == 1) {
						$val = $default[0];
					}
					$tbl .= '<input type="text" name="' . $nameprefix . 'ff_' . $type_sel . '_' . $f . ']" size="7" border="0"' . ($val ? ' value="' . $val . '"' : '') . '>' . $valselect;
				} else {
					if (sizeof($default) > 1) {
						$val = $GLOBALS["we_doc"]->getElement($name, 'ff_' . $type_sel . '_' . $f);
						$valselect = "";
						if (sizeof($default) > 1) {
							$valselect = '<select name="' . $nameprefix . 'ff_' . $type_sel . '_' . $f . ']" size="1">' . "\n";
							foreach ($default as $v) {
								$valselect .= '<option value="' . $v . '"' . (($v == $val) ? " selected" : "") . '>' . $v . '</option>' . "\n";
							}
							$valselect .= '</select>' . "\n";
						}
						$tbl .= $valselect;
					} else {
						$foo = sizeof($default) ? $default[0] : "";
						$tbl .= $foo . '<input type="hidden" name="' . $nameprefix . 'ff_' . $type_sel . '_' . $f . ']" value="' . $foo . '">';
					}
				}
				$tbl .= '</span></nobr></td><td class=\"weEditmodeStyle\">' . getPixel(5, 2) . "</td>\n";
			}
			$tbl .= '				</tr>
			</table>
		</td>
	</tr>
';
		}
		if ($type_sel == "select") {
			$tbl .= '	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["values"] . ':</nobr></td>
		<td class=\"weEditmodeStyle\" width="161"><textarea name="' . $nameprefix . 'ffvalues]" cols="30" rows="5">' . $GLOBALS["we_doc"]->getElement(
					$name, 
					'ffvalues') . '</textarea></td>
	</tr>
	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["default"] . ':</nobr></td>
		<td class=\"weEditmodeStyle\" width="161"><input type="text" name="' . $nameprefix . 'ffdefault]" size="24" value="' . $GLOBALS["we_doc"]->getElement(
					$name, 
					'ffdefault') . '"></td>
	</tr>
';
		
		} else 
			if ($type_sel == 'file') {
				$tbl .= '	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["max_file_size"] . ':</nobr></td>
		<td class=\"weEditmodeStyle\" width="161"><input type="text" name="' . $nameprefix . 'ffmaxfilesize]" size="24" value="' . $GLOBALS["we_doc"]->getElement(
						$name, 
						'ffmaxfilesize') . '"></td>
	</tr>
';
			} else 
				if ($type_sel == 'radio' || $type_sel == 'checkbox') {
					$tbl .= '	<tr>
		<td class=\"weEditmodeStyle\" width="62" style="color: black; font-size: 12px; font-family: Verdana, sans-serif" align="right"><nobr>' . $GLOBALS["l_global"]["checked"] . ':</nobr></td>
		<td class=\"weEditmodeStyle\" width="161"><select name="' . $nameprefix . 'ffchecked]" size="1"><option value="0"' . ($GLOBALS["we_doc"]->getElement(
							$name, 
							'ffchecked') ? "" : " selected") . '>' . $GLOBALS["l_global"]["no"] . '</option><option value="1"' . ($GLOBALS["we_doc"]->getElement(
							$name, 
							'ffchecked') ? " selected" : "") . '>' . $GLOBALS["l_global"]["yes"] . '</option></select></td>
	</tr>
';
				}
		$tbl .= '</table>
';
		$ret .= $tbl;
	} else {
		
		$tagEndTag = false;
		
		$tagName = '';
		$tagAtts = array(
			
		'xml' => $xml, 'name' => htmlspecialchars($GLOBALS["we_doc"]->getElement($attribs["name"], 'ffname'))
		);
		$tagContent = '';
		
		switch ($type_sel) {
			case "textarea" :
			case "select" :
				$tagName = $type_sel;
				break;
			default :
				$tagName = 'input';
				$tagAtts['type'] = $type_sel;
		}
		
		foreach ($ff as $f => $arr) {
			
			if (!((($f == 'value') && ($type_sel == 'textarea')) || $f == 'type')) {
				
				$val = $GLOBALS["we_doc"]->getElement($name, 'ff_' . $type_sel . '_' . $f);
				if ($val) {
					$tagAtts[$f] = htmlspecialchars($val);
				}
			}
		}
		
		if ($type_sel == 'textinput') { // correct input type="text"
			$tagAtts['type'] = 'text';
		}
		
		if (($type_sel == 'checkbox' || $type_sel == 'radio') && $GLOBALS["we_doc"]->getElement($name, 'ffchecked')) {
			$tagAtts['checked'] = 'checked';
		}
		
		if ($type_sel == 'textarea') {
			$tagEndTag = true;
			if (arrayKeyExists('value', $ff)) {
				$tagContent = htmlspecialchars($ff['value']['value']);
			}
			if (!array_key_exists('cols', $tagAtts)) {
				$tagAtts['cols'] = 20;
			}
			if (!array_key_exists('rows', $tagAtts)) {
				$tagAtts['rows'] = 5;
			}
		
		} else 
			if ($type_sel == 'select') {
				$selected = $GLOBALS["we_doc"]->getElement($name, 'ffdefault');
				$foo = $GLOBALS["we_doc"]->getElement($name, 'ffvalues');
				$foo = str_replace("\r\n", "<_BR_>", $foo);
				$foo = str_replace("\r", "<_BR_>", $foo);
				$foo = str_replace("\n", "<_BR_>", $foo);
				$foo = explode("<_BR_>", $foo);
				foreach ($foo as $v) {
					$_atts = array(
						'value' => htmlspecialchars($v)
					);
					if ($selected == $v) {
						$_atts['selected'] = 'selected';
					}
					$tagContent .= getHtmlTag('option', $_atts, htmlspecialchars($v));
				}
			} else 
				if ($type_sel == 'file') {
					$ret .= getHtmlTag(
							'input', 
							array(
								
									'type' => 'hidden', 
									'name' => 'MAX_FILE_SIZE', 
									'value' => htmlspecialchars(
											$GLOBALS["we_doc"]->getElement($name, 'ffmaxfilesize')), 
									'xml' => $xml
							));
				}
		return getHtmlTag($tagName, $tagAtts, $tagContent, $tagEndTag) . $ret;
	}
	return $ret;

}

function we_tag_hidden($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "name", "hidden");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs, '');
	$xml = we_getTagAttribute("xml", $attribs);
	
	$value = '';
	switch ($type) {
		case 'session' :
			
			$value = $_SESSION[$name];
			break;
		case 'request' :
			$value = removePHP(isset($_REQUEST[$name]) ? $_REQUEST[$name] : "");
			break;
		default :
			$value = $GLOBALS[$name];
			break;
	}
	
	return getHtmlTag('input', array(
		'type' => 'hidden', 'name' => $name, 'value' => $value, 'xml' => $xml
	));
}

function we_tag_href($attribs, $content)
{
	// Define globals
	global $we_editmode, $l_global;
	
	if ($we_editmode) {
		// Include files
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/tags.inc.php");
	}
	
	$foo = attributFehltError($attribs, "name", "href");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$include = we_getTagAttribute("include", $attribs, '', true);
	$reload = we_getTagAttribute("reload", $attribs, '', true);
	$rootdir = we_getTagAttribute("rootdir", $attribs, '/');
	if (substr($rootdir, 0, 1) != "/") {
		$rootdirid = $rootdir;
		$rootdir = id_to_path($rootdir, FILE_TABLE);
	} else {
		if (strlen($rootdir) > 1) {
			$rootdir = ereg_replace("/$", "", $rootdir);
		}
		$rootdirid = path_to_id($rootdir, FILE_TABLE);
	}
	// Bug Fix #7045
	if (strlen($rootdir) == 1 && $rootdir == "/") {
		$rootdir = "";
	}
	
	$file = we_getTagAttribute("file", $attribs, '', true, true);
	$directory = we_getTagAttribute("directory", $attribs, '', true);
	
	$attribs = removeAttribs($attribs, array(
		"rootdir"
	));
	
	if ($GLOBALS["we_doc"]->ClassName == "we_objectFile") {
		$hrefArr = $GLOBALS["we_doc"]->getElement($name) ? unserialize($GLOBALS["we_doc"]->getElement($name)) : array();
		if (!is_array($hrefArr)) {
			$hrefArr = array();
		}
		return sizeof($hrefArr) ? we_document::getHrefByArray($hrefArr) : "";
	}
	
	$nint = $name . "_we_jkhdsf_int";
	$nintID = $name . "_we_jkhdsf_intID";
	$nintPath = $name . "_we_jkhdsf_intPath";
	$extPath = $GLOBALS["we_doc"]->getElement($name);
	
	// we have to use a html_entity_decode first in case a user has set &amp, &uuml; by himself
	// as html_entity_decode is only available php > 4.3 we use a custom function
	$extPath = !empty($extPath) ? htmlspecialchars(unhtmlentities($extPath)) : $extPath;
	
	if ($we_editmode) {
		// Init we_button class
		$we_button = new we_button();
		
		$int_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nint . ']';
		$intPath_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nintPath . ']';
		$intID_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nintID . ']';
		$ext_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']';
		
		$trashbut = $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:document.we_form.elements['" . $intID_elem_Name . "'].value = ''; document.we_form.elements['" . $intPath_elem_Name . "'].value = ''; _EditorFrame.setEditorIsHot(true);" . (($include || $reload) ? "setScrollTo(); top.we_cmd('reload_editpage');" : ""), 
				true);
		$span = '<span style="color: black;font-size:' . (($GLOBALS["SYSTEM"] == "MAC") ? "11px" : (($GLOBALS["SYSTEM"] == "X11") ? "13px" : "12px")) . ';font-family:' . $GLOBALS["l_css"]["font_family"] . ';">';
	}
	
	if (!$type || $type == "all") {
		
		$int = ($GLOBALS["we_doc"]->getElement($nint) == "") ? 0 : $GLOBALS["we_doc"]->getElement($nint);
		$intID = $GLOBALS["we_doc"]->getElement($nintID);
		if (!$intID && $rootdirid) {
			$intID = $rootdirid;
		}
		$intPath = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".abs($intID)."'", "Path", $GLOBALS["DB_WE"]);
		
		if ($int) {
			$href = $intPath;
			$include_path = $href ? $_SERVER["DOCUMENT_ROOT"] . "/" . $href : "";
		} else {
			//if (!$we_editmode) {
			//	$extPath = htmlspecialchars($extPath);
			//}
			$href = $extPath;
			$include_path = $href;
		}
		
		$int_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nint . ']';
		$intPath_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nintPath . ']';
		$intID_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $nintID . ']';
		$ext_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']';
		
		$attr = we_make_attribs($attribs, "name,value,type,onkeydown,onKeyDown");
		
		if ($we_editmode) {
			if (($directory && $file) || $file) {
				$but = $we_button->create_button(
						"select", 
						"javascript:we_cmd('openDocselector', document.forms[0].elements['$intID_elem_Name'].value, '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'$intID_elem_Name\\'].value', 'document.forms[\\'we_form\\'].elements[\\'$intPath_elem_Name\\'].value', 'opener._EditorFrame.setEditorIsHot(true); opener.document.we_form.elements[\'$int_elem_Name\'][0].checked = true;" . (($include || $reload) ? "opener.setScrollTo(); opener.top.we_cmd(\'reload_editpage\');" : "") . "', '" . session_id() . "', '" . $rootdirid . "', '', " . (we_hasPerm(
								"CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ",''," . ($directory ? 1 : 0) . ");");
				$but2 = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button(
						"select", 
						"javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'$ext_elem_Name\\'].value', '" . (($directory && $file) ? "filefolder" : "") . "', document.forms[0].elements['$ext_elem_Name'].value, 'opener._EditorFrame.setEditorIsHot(true); opener.document.we_form.elements[\'$int_elem_Name\'][1].checked = true;','" . $rootdir . "')") : "";
			} else {
				$but = $we_button->create_button(
						"select", 
						"javascript:we_cmd('openDirselector', document.forms[0].elements['$intID_elem_Name'].value, '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'$intID_elem_Name\\'].value', 'document.forms[\\'we_form\\'].elements[\\'$intPath_elem_Name\\'].value', 'opener._EditorFrame.setEditorIsHot(true); opener.document.we_form.elements[\'$int_elem_Name\'][0].checked = true;" . (($include || $reload) ? "opener.setScrollTo(); opener.top.we_cmd(\'reload_editpage\');" : "") . "', '" . session_id() . "', '" . $rootdirid . "');");
				$but2 = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button(
						"select", 
						"javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'$ext_elem_Name\\'].value', 'folder', document.forms[0].elements['$ext_elem_Name'].value, 'opener._EditorFrame.setEditorIsHot(true); opener.document.we_form.elements[\'$int_elem_Name\'][1].checked = true;','" . $rootdir . "')") : "";
			}
			$trashbut2 = $we_button->create_button(
					"image:btn_function_trash", 
					"javascript:document.we_form.elements['" . $ext_elem_Name . "'].value = ''; _EditorFrame.setEditorIsHot(true);", 
					true);
			$out = '
				<table border="0" cellpadding="0" cellspacing="2" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif" style="border: solid #006DB8 1px;">
					<tr>
						<td class="weEditmodeStyle">
							' . we_forms::radiobutton(
					1, 
					$int, 
					$int_elem_Name, 
					$span . $GLOBALS["l_tags"]["int_href"] . ":</span>") . '</td>
						<td class="weEditmodeStyle">
							<input type="hidden" name="' . $intID_elem_Name . '" value="' . $intID . '">
							<input type="text" name="' . $intPath_elem_Name . '" value="' . $intPath . '" ' . $attr . ' readonly></td>
						<td class="weEditmodeStyle">
							' . getPixel(8, 1) . '</td>
						<td class="weEditmodeStyle">
							' . $but . '</td>
						<td class="weEditmodeStyle">
							' . $trashbut . '</td>
					</tr>
					<tr>
						<td class="weEditmodeStyle">
							' . we_forms::radiobutton(
					0, 
					!$int, 
					$int_elem_Name, 
					$span . $GLOBALS["l_tags"]["ext_href"] . ":</span>") . '</td>
						<td class="weEditmodeStyle">
							<input onchange="this.form.elements[\'' . $int_elem_Name . '\'][1].checked = true;" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $extPath . '" ' . $attr . '></td>
						<td class="weEditmodeStyle">
							' . getPixel(8, 1) . '</td>
						<td class="weEditmodeStyle">
							' . $but2 . '</td>
						<td class="weEditmodeStyle">
							' . $trashbut2 . '</td>
					</tr>
				</table>';
			
			if ($include) {
				$out .= $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
			}
			return $out;
		} else {
			if ($include) {
				return $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
			} else {
				return $href;
			}
		}
	} else 
		if ($type == "int") {
			$intID = $GLOBALS["we_doc"]->getElement($nintID);
			$intPath = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".abs($intID)."'", "Path", $GLOBALS["DB_WE"]);
			$href = $intPath;
			$include_path = $href ? $_SERVER["DOCUMENT_ROOT"] . "/" . $href : "";
			
			if ($we_editmode) {
				if (($directory && $file) || $file) {
					$but = $we_button->create_button(
							"select", 
							"javascript:we_cmd('openDocselector', document.forms[0].elements['$intID_elem_Name'].value, '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'$intID_elem_Name\\'].value', 'document.forms[\\'we_form\\'].elements[\\'$intPath_elem_Name\\'].value', 'opener._EditorFrame.setEditorIsHot(true); " . (($include || $reload) ? "opener.setScrollTo(); opener.top.we_cmd(\'reload_editpage\');" : "") . "', '" . session_id() . "', '" . $rootdirid . "', '', " . (we_hasPerm(
									"CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ",''," . ($directory ? 1 : 0) . ");");
				} else {
					$but = $we_button->create_button(
							"select", 
							"javascript:we_cmd('openDirselector', document.forms[0].elements['$intID_elem_Name'].value, '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'$intID_elem_Name\\'].value', 'document.forms[\\'we_form\\'].elements[\\'$intPath_elem_Name\\'].value', 'opener._EditorFrame.setEditorIsHot(true); " . (($include || $reload) ? "opener.setScrollTo(); opener.top.we_cmd(\'reload_editpage\');" : "") . "', '" . session_id() . "', '" . $rootdirid . "');");
				}
				
				$attr = we_make_attribs($attribs, "name,value,type,onkeydown,onKeyDown");
				$out = '
				<table border="0" cellpadding="0" cellspacing="2" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif" style="border: solid #006DB8 1px;">
					<tr>
						<td class="weEditmodeStyle defaultfont" nowrap="nowrap">
							<input type="hidden" name="' . $int_elem_Name . '" value="1">
							' . $span . $GLOBALS["l_tags"]["int_href"] . ':</span></td>
						<td class="weEditmodeStyle">
							<input type="hidden" name="' . $ext_elem_Name . '" />
							<input type="hidden" name="' . $intID_elem_Name . '" value="' . $intID . '">
							<input type="text" name="' . $intPath_elem_Name . '" value="' . $intPath . '" ' . $attr . ' readonly></td>
						<td class="weEditmodeStyle">
							' . getPixel(8, 1) . '</td>
						<td class="weEditmodeStyle">
							' . $but . '</td>
						<td class="weEditmodeStyle">
							' . $trashbut . '</td>
					</tr>
				</table>';
				if ($include) {
					$out .= $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
				}
				return $out;
			} else {
				if ($include) {
					return $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
				} else {
					return $href;
				}
			}
		} else {
			//if (!$we_editmode) {
			//	$extPath = htmlspecialchars($extPath);
			//}
			$href = $extPath;
			$include_path = $href ? $_SERVER["DOCUMENT_ROOT"] . "/" . $href : "";
			
			if ($we_editmode) {
				$ext_elem_Name = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']';
				
				$trashbut2 = $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:document.we_form.elements['" . $ext_elem_Name . "'].value = ''; _EditorFrame.setEditorIsHot(true)", 
						true);
				
				if (($directory && $file) || $file) {
					$but2 = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button(
							"select", 
							"javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'$ext_elem_Name\\'].value', '" . (($directory && $file) ? "filefolder" : "") . "', document.forms[0].elements['$ext_elem_Name'].value, 'opener._EditorFrame.setEditorIsHot(true);', '" . $rootdir . "')") : "";
				} else {
					$but2 = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button(
							"select", 
							"javascript:we_cmd('browse_server', 'document.forms[0].elements[\\'$ext_elem_Name\\'].value', 'folder', document.forms[0].elements['$ext_elem_Name'].value, 'opener._EditorFrame.setEditorIsHot(true);', '" . $rootdir . "')") : "";
				}
				
				$attr = we_make_attribs($attribs, "name,value,type,onkeydown,onKeyDown");
				
				$out = '
				<table border="0" cellpadding="0" cellspacing="2" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif" style="border: solid #006DB8 1px;">
					<tr>
						<td class="weEditmodeStyle defaultfont" nowrap="nowrap">
							<input type="hidden" name="' . $int_elem_Name . '" value="0">
							' . $span . $GLOBALS["l_tags"]["ext_href"] . ':</span></td>
						<td class="weEditmodeStyle">
							<input type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $extPath . '" ' . $attr . '></td>
						<td class="weEditmodeStyle">
							' . getPixel(8, 1) . '</td>
						<td class="weEditmodeStyle">
							' . $but2 . '</td>
						<td class="weEditmodeStyle">
							' . $trashbut2 . '</td>
					</tr>
				</table>';
				if ($include) {
					$out .= $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
				}
				return $out;
			} else {
				if ($include) {
					return $include_path ? '<?php if(file_exists("' . $include_path . '")) include("' . $include_path . '"); ?>' : '';
				} else {
					return $href;
				}
			}
		}
}

function we_tag_icon($attribs, $content)
{
	$foo = attributFehltError($attribs, "id", "a");
	if ($foo)
		return $foo;
	$xml = we_getTagAttribute("xml", $attribs, "");
	$id = we_getTagAttribute("id", $attribs);
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
	if (count($row)) {
		$url = $row["Path"] . ($row["IsFolder"] ? "/" : "");
		return getHtmlTag('link', array(
			'rel' => 'shortcut icon', 'href' => $url, 'xml' => $xml
		));
	}
	return "";
}

//
// Tags for the Sidebar
//


function we_tag_ifSidebar($attribs, $content)
{
	return defined("WE_SIDEBAR");
}

function we_tag_ifNotSidebar($attribs, $content)
{
	return !we_tag_ifSidebar($attribs, $content);
}

function we_tag_sidebar($attribs, $content)
{
	$_out = "";
	
	if (we_tag_ifNotSidebar($attribs, $content) && we_tag_ifEditmode($attribs, $content)) {
		
		$id = we_getTagAttribute("id", $attribs, 0);
		$file = we_getTagAttribute("file", $attribs, "");
		$url = we_getTagAttribute("url", $attribs, "");
		$width = we_getTagAttribute("width", $attribs, (defined("WE_SIDEBAR_WIDTH") ? WE_SIDEBAR_WIDTH : 300));
		
		removeAttribs($attribs, array(
			'id', 'file', 'url', 'width', 'href'
		));
		
		if (trim($content) == "") {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/tags.inc.php");
			$content = $GLOBALS["l_tags"]["open_sidebar"];
		
		}
		
		$href = "#";
		if ($id == 0 && $file != "") {
			
			$href = "javascript:top.weSidebar.load('" . $file . "');top.weSidebar.resize(" . $width . ");";
		
		} else 
			if ($id == 0 && $url != "") {
				$href = "javascript:top.weSidebar.load('" . $url . "');top.weSidebar.resize(" . $width . ");";
			
			} else {
				$href = "javascript:top.weSidebar.open('" . $id . "', " . $width . ");";
			
			}
		$attribs['href'] = $href;
		
		$_out .= getHtmlTag("a", $attribs, $content);
	
	}
	return $_out;

}

//
// /End Tags for the Sidebar
//


function we_tag_ifBack($attribs, $content)
{
	if (isset($GLOBALS['_we_voting_list']))
		return $GLOBALS['_we_voting_list']->hasPrevPage();
	$useparent = we_getTagAttribute("useparent", $attribs, '', true);
	return $GLOBALS["lv"]->hasPrevPage($useparent);
}

function we_tag_ifCaptcha($attribs, $content)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/captcha/captchaImage.class.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/captcha/captchaMemory.class.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/captcha/captcha.class.php");
	
	$name = we_getTagAttribute("name", $attribs);
	$formname = we_getTagAttribute("formname", $attribs, "");
	
	if (!empty($formname) && isset($_REQUEST['we_ui_' . $formname][$name])) {
		return Captcha::check($_REQUEST['we_ui_' . $formname][$name]);
	} else 
		if (empty($formname) && isset($_REQUEST['we_ui_we_global_form'][$name])) {
			return Captcha::check($_REQUEST['we_ui_we_global_form'][$name]);
		} else 
			if (empty($formname) && isset($_REQUEST[$name])) {
				return Captcha::check($_REQUEST[$name]);
			} else {
				return false;
			}
}

function we_tag_ifCat($attribs, $content)
{
	
	$categories = we_getTagAttribute("categories", $attribs);
	$category = we_getTagAttribute("category", $attribs);
	
	if (strlen($categories) == 0 && strlen($category) == 0) {
		$foo = attributFehltError($attribs, "categories", "ifCat");
		if ($foo) {
			print($foo);
			return "";
		}
	}
	
	$parent = we_getTagAttribute("parent", $attribs, "", true);
	
	$docAttr = we_getTagAttribute("doc", $attribs, "self");
	
	$match = $categories ? $categories : $category;
	$db = new DB_WE();
	$matchArray = makeArrayFromCSV($match);
	
	if ($docAttr == 'listview' && isset($GLOBALS['lv'])) {
		$DocCatsPaths = id_to_path($GLOBALS['lv']->f('wedoc_Category'), CATEGORY_TABLE, $db, true, false, $parent);
	} else {
		$doc = we_getDocForTag($docAttr);
		$DocCatsPaths = id_to_path($doc->Category, CATEGORY_TABLE, $db, true, false, $parent);
	}
	
	foreach ($matchArray as $match) {
		
		if (substr($match, 0, 1) != "/") {
			$match = "/" . $match;
		}
		if ($parent) {
			if (!(strpos($DocCatsPaths, "," . $match) === false)) {
				return true;
			}
		} else {
			if (!(strpos($DocCatsPaths, "," . $match . ",") === false)) {
				return true;
			}
		}
	}
	return false;
}

function we_tag_ifHasChildren($attribs, $content)
{
	
	if (isset($GLOBALS["lv"])) {
		if (abs($GLOBALS["lv"]->f("ID")) > 0) {
			return abs(
					f(
							"SELECT COUNT(ID) AS ID FROM " . CATEGORY_TABLE . " WHERE ParentID='" . abs(
									$GLOBALS["lv"]->f("ID")) . "'", 
							"ID", 
							new DB_WE())) > 0;
		}
	}
	return false;
}

function we_tag_ifClient($attribs, $content)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_browserDetect.inc.php");
	
	$version = we_getTagAttribute("version", $attribs);
	$browser = we_getTagAttribute("browser", $attribs);
	$system = we_getTagAttribute("system", $attribs);
	
	if ($version) {
		if (!(ereg('up[0-9\.]+', $version) || ereg('down[0-9\.]+', $version) || ereg('eq[0-9\.]+', $version))) {
			exit(parseError($GLOBALS["l_parser"]["client_version"]));
		}
	}
	
	$br = new we_browserDetect();
	if ($browser) {
		$bro = explode(",", $browser);
		$_browserOfClient = $br->getBrowser();
		$foo_br = in_array($_browserOfClient, $bro);
		// for backwards compatibility
		if (!$foo_br && $_browserOfClient == "firefox" && in_array("mozilla", $bro)) {
			$foo_br = true;
		} else 
			if (!$foo_br && $_browserOfClient == "appleWebKit" && in_array("safari", $bro)) {
				$foo_br = true;
			}
	} else {
		$foo_br = true;
	}
	
	$brv = $br->getBrowserVersion();
	$foo_v = true;
	$ver = str_replace('up', '>=', $version);
	$ver = str_replace('down', '<', $ver);
	$ver = str_replace('eq', '==', $ver);
	
	if (ereg("==", $ver)) {
		eval('$foo_v = (floor($brv)' . $ver . ');');
	} else {
		eval('$foo_v = ($brv' . $ver . ');');
	}
	if ($system) {
		$sys = explode(",", $system);
		$foo_sys = in_array($br->getSystem(), $sys);
	} else {
		$foo_sys = true;
	}
	return $foo_br && $foo_v && $foo_sys;
}

function we_tag_ifDeleted($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "document");
	return isset($GLOBALS["we_" . $type . "_delete_ok"]) && ($GLOBALS["we_" . $type . "_delete_ok"] == true);
}

function we_tag_ifDemo($attribs, $content)
{
	return !defined("UID");
}

function we_tag_ifDoctype($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "doctypes", "ifDoctype");
	if ($foo) {
		print($foo);
		return "";
	}
	$match = we_getTagAttribute("doctypes", $attribs);
	
	$docAttr = we_getTagAttribute("doc", $attribs, "self");
	
	if ($docAttr == "listview" && isset($GLOBALS['lv'])) {
		$doctype = $GLOBALS['lv']->f('wedoc_DocType');
	} else {
		$doc = we_getDocForTag($docAttr);
		if ($doc->ClassName == "we_template") {
			return false;
		}
		$doctype = $doc->DocType;
	}
	$matchArr = makeArrayFromCSV($match);
	
	if (isset($doctype)) {
		foreach ($matchArr as $match) {
			$matchID = f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='".mysql_real_escape_string($match)."'", "ID", new DB_WE());
			if ($matchID == $doctype) {
				return true;
			}
		}
	}
	return false;
}

function we_tag_ifEditmode($attribs, $content)
{
	global $we_editmode, $WE_MAIN_EDITMODE, $we_doc, $WE_MAIN_DOC;
	$doc = we_getTagAttribute("doc", $attribs);
	switch ($doc) {
		case "self" :
			return $WE_MAIN_DOC == $we_doc && $we_editmode;
		default :
			return $we_editmode || $WE_MAIN_EDITMODE/* || (isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem")*/;
	}
}

function we_tag_ifSeeMode($attribs, $content)
{
	
	if (we_tag_ifWebEdition($attribs, $content)) {
		return (isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem");
	} else {
		return false;
	}
}

function we_tag_ifTemplate($attribs, $content)
{
	$id = we_getTagAttribute("id", $attribs);
	$path = we_getTagAttribute("path", $attribs);
	
	if (isset($GLOBALS['we_doc']->TemplateID) && $id !== "") {
		$idArray = makeArrayFromCSV($id);
		return in_array($GLOBALS['we_doc']->TemplateID, $idArray);
	} else {
		if ($path === "") {
			return true;
		}
		if (isset($GLOBALS['we_doc']->TemplatePath)) {
			$pathReg = "|^" . str_replace("\\*", ".*", preg_quote($path, "|")) . "\$|";
			return preg_match($pathReg, $GLOBALS['we_doc']->TemplatePath);
		}
	}
	return false;
}

function we_tag_ifTdEmpty($attribs, $content)
{
	return $GLOBALS["lv"]->tdEmpty();
}

function we_tag_ifTdNotEmpty($attribs, $content)
{
	return !$GLOBALS["lv"]->tdEmpty();
}

function we_tag_ifTop($attribs, $content)
{
	if ($GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"]) {
		return true;
	} else {
		return false;
	}
}

function we_tag_ifNotSeeMode($attribs, $content)
{
	
	if (we_tag_ifWebEdition($attribs, $content)) {
		return !(we_tag_ifSeeMode($attribs, $content));
	} else {
		return true;
	}
}

function we_tag_ifEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) {
		return true;
	}
	return !we_isNotEmpty($attribs);
}

function we_tag_ifEqual($attribs, $content)
{
	global $we_editmode;
	$foo = attributFehltError($attribs, "name", "ifEqual");
	if ($foo) {
		print($foo);
		return "";
	}
	$name = we_getTagAttribute("name", $attribs);
	$eqname = we_getTagAttribute("eqname", $attribs);
	$value = we_getTagAttribute("value", $attribs);
	
	if (!$eqname) {
		$foo = attributFehltError($attribs, "value", "ifEqual");
		if ($foo) {
			print($foo);
			return "";
		}
		return ($GLOBALS["we_doc"]->getElement($name) == $value);
	}
	
	$foo = attributFehltError($attribs, "eqname", "ifEqual");
	if ($foo) {
		print($foo);
		return "";
	}
	if ($GLOBALS["we_doc"]->getElement($name) && $GLOBALS["WE_MAIN_DOC"]->getElement($eqname)) {
		return ($GLOBALS["we_doc"]->getElement($name) == $GLOBALS["WE_MAIN_DOC"]->getElement($eqname));
	} else {
		if (isset($GLOBALS[$eqname])) {
			return $GLOBALS[$eqname] == $GLOBALS["we_doc"]->getElement($name);
		} else {
			return false;
		}
	}

}

function we_tag_ifFieldEmpty($attribs, $content)
{
	global $we_editmode;
	$foo = attributFehltError($attribs, "match", "ifFieldNotEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	return !we_isFieldNotEmpty($attribs);

}

function we_tag_ifFieldNotEmpty($attribs, $content)
{
	global $we_editmode;
	
	$foo = attributFehltError($attribs, "match", "ifFieldNotEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	
	return we_isFieldNotEmpty($attribs);

}

function we_tag_ifField($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "name", "ifField");
	if ($foo) {
		print($foo);
		return "";
	}
	$foo = attributFehltError($attribs, "match", "ifField", true);
	if ($foo) {
		print($foo);
		return "";
	}
	$foo = attributFehltError($attribs, "type", "ifField", true);
	if ($foo) {
		print($foo);
		return "";
	}
	
	$match = we_getTagAttribute("match", $attribs);
	
	$matchArray = makeArrayFromCSV($match);
	
	$realvalue = we_tag_field($attribs, "");
	return $realvalue == $match;
}

function we_tag_ifNotField($attribs, $content)
{
	return !we_tag_ifField($attribs, $content);
}

function we_tag_ifFound($attribs, $content)
{
	return $GLOBALS["lv"]->anz ? true : false;
}

function we_tag_ifIsDomain($attribs, $content)
{
	global $we_editmode;
	$foo = attributFehltError($attribs, "domain", "ifIsDomain");
	if ($foo) {
		print($foo);
		return "";
	}
	$domain = we_getTagAttribute("domain", $attribs);
	return $we_editmode || ($domain == $_SERVER["SERVER_NAME"]);
}

function we_tag_ifIsNotDomain($attribs, $content)
{
	global $we_editmode;
	$foo = attributFehltError($attribs, "domain", "ifIsNotDomain");
	if ($foo) {
		print($foo);
		return "";
	}
	$domain = we_getTagAttribute("domain", $attribs);
	return $we_editmode || (!($domain == $_SERVER["SERVER_NAME"]));
}

function we_tag_ifLastCol($attribs, $content)
{
	return $GLOBALS["lv"]->shouldPrintEndTR();
}

function we_tag_ifNew($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs);
	return !(isset($_REQUEST["we_edit" . (($type == "object") ? "Object" : "Document") . "_ID"]) && $_REQUEST["we_edit" . (($type == "object") ? "Object" : "Document") . "_ID"]);
}

function we_tag_ifNext($attribs, $content)
{
	if (isset($GLOBALS['_we_voting_list']))
		return $GLOBALS['_we_voting_list']->hasNextPage();
	$useparent = we_getTagAttribute("useparent", $attribs, '', true);
	return $GLOBALS["lv"]->hasNextPage($useparent);
}

function we_tag_ifNoJavaScript($attribs, $content)
{
	$foo = attributFehltError($attribs, "id", "ifNoJavaScript");
	if ($foo) {
		print($foo);
		return "";
	}
	$id = we_getTagAttribute("id", $attribs);
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
	$url = $row["Path"] . ($row["IsFolder"] ? "/" : "");
	$attr = we_make_attribs($attribs, "id");
	return '<noscript><meta http-equiv="refresh" content="0;URL=' . $url . '"></noscript>';
}

function we_tag_ifNotCaptcha($attribs, $content)
{
	return !we_tag_ifCaptcha($attribs, $content);
}

function we_tag_ifNotDeleted($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "document");
	return isset($GLOBALS["we_" . $type . "_delete_ok"]) && ($GLOBALS["we_" . $type . "_delete_ok"] == false);
}

function we_tag_ifNotEditmode($attribs, $content)
{
	global $we_editmode, $WE_MAIN_EDITMODE, $we_doc, $WE_MAIN_DOC;
	$doc = we_getTagAttribute("doc", $attribs);
	switch ($doc) {
		case "self" :
			return !($WE_MAIN_DOC == $we_doc && $we_editmode);
		default :
			return !($we_editmode || $WE_MAIN_EDITMODE);
	}
}

function we_tag_ifNotEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifNotEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) {
		return true;
	}
	return we_isNotEmpty($attribs);
}

function we_tag_ifNotEqual($attribs, $content)
{
	global $we_editmode;
	$foo = attributFehltError($attribs, "name", "ifNotEqual");
	if ($foo) {
		print($foo);
		return "";
	}
	
	$name = we_getTagAttribute("name", $attribs);
	$eqname = we_getTagAttribute("eqname", $attribs);
	$value = we_getTagAttribute("value", $attribs);
	
	if (!$eqname) {
		$foo = attributFehltError($attribs, "value", "ifEqual");
		if ($foo) {
			print($foo);
			return "";
		}
		return ($GLOBALS["we_doc"]->getElement($name) != $value);
	}
	$foo = attributFehltError($attribs, "eqname", "ifNotEqual");
	if ($foo) {
		print($foo);
		return "";
	}
	return ($GLOBALS["we_doc"]->getElement($name) != $GLOBALS["WE_MAIN_DOC"]->getElement($eqname));
}

function we_tag_ifNotFound($attribs, $content)
{
	return $GLOBALS["lv"]->anz ? false : true;
}

function we_tag_ifNotNew($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs);
	return (isset($_REQUEST["we_edit" . (($type == "object") ? "Object" : "Document") . "_ID"]) && $_REQUEST["we_edit" . (($type == "object") ? "Object" : "Document") . "_ID"]);
}

function we_tag_ifNotReturnPage($attribs, $content)
{
	return !(isset($_REQUEST["we_returnpage"]) && ($_REQUEST["we_returnpage"]));
}

function we_tag_ifNotSearch($attribs, $content)
{
	return !we_tag_ifSearch($attribs, $content);
}

function we_tag_ifNotSelf($attribs, $content)
{
	return !we_tag_ifSelf($attribs, $content);
}

function we_tag_ifNotTop($attribs, $content)
{
	return !we_tag_ifTop($attribs, $content);
}

function we_tag_ifNotVar($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "ifNotVar");
	if ($foo) {
		print($foo);
		return "";
	}
	$foo = attributFehltError($attribs, "match", "ifNotVar", true);
	if ($foo) {
		print($foo);
		return "";
	}
	return !we_tag_ifVar($attribs, $content);
}

function we_tag_ifNotVarSet($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "ifNotVarSet");
	if ($foo) {
		print($foo);
		return "";
	}
	$type = we_getTagAttribute("var", $attribs);
	$type = $type ? $type : we_getTagAttribute("type", $attribs);
	$doc = we_getTagAttribute("doc", $attribs);
	$name = we_getTagAttribute("name", $attribs);
	$formname = we_getTagAttribute("formname", $attribs, "we_global_form");
	$property = we_getTagAttribute("property", $attribs, "", true);
	$shopname = we_getTagAttribute("shopname", $attribs, "");
	
	return !we_isVarSet($name, $type, $doc, $property, $formname, $shopname);
}

function we_tag_ifNotWebEdition($attribs, $content)
{
	return !$GLOBALS["WE_MAIN_DOC"]->InWebEdition;
}

function we_tag_ifNotWorkspace($attribs, $content)
{
	return !we_tag_ifWorkspace($attribs, $content);
}

function we_tag_ifNotWritten($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "");
	$type = $type ? $type : we_getTagAttribute("var", $attribs, "");
	$type = $type ? $type : we_getTagAttribute("doc", $attribs, "document");
	return isset($GLOBALS["we_" . $type . "_write_ok"]) && ($GLOBALS["we_" . $type . "_write_ok"] == false);
}

function we_tag_ifPosition($attribs, $content)
{
	global $lv;
	//	content is not needed in this tag
	

	$missingAttrib = attributFehltError($attribs, "type", "ifPosition");
	if ($missingAttrib) {
		print $missingAttrib;
		return "";
	}
	
	$missingAttrib = attributFehltError($attribs, "position", "ifPosition");
	if ($missingAttrib) {
		print $missingAttrib;
		return "";
	}
	
	$type = we_getTagAttribute("type", $attribs);
	$position = we_getTagAttribute("position", $attribs);
	
	$positionArray = explode(',', $position);
	
	$_size = sizeof($positionArray);
	
	for ($i = 0; $i < $_size; $i++) {
		
		$_position = $positionArray[$i];
		
		switch ($type) {
			
			case "listview" : //	inside a listview, we take direct global listview object
				

				switch ($_position) {
					case "first" :
						if ($lv->count == 1) {
							return true;
						}
						;
						break;
					case "last" :
						if ($lv->count == $lv->anz) {
							return true;
						}
						break;
					case "odd" :
						if ($lv->count % 2 != 0) {
							return true;
						}
						break;
					case "even" :
						if ($lv->count % 2 == 0) {
							return true;
						}
						break;
					
					default :
						$_position += 0; // Umwandeln in integer
						if ($lv->count == $_position) {
							return true;
						}
						break;
				}
				break;
			
			case "linklist" : //	look in fkt we_tag_linklist and callss we_linklist for details
				

				//	first we must get right array !!!
				$missingAttrib = attributFehltError($attribs, "reference", "ifPosition");
				if ($missingAttrib) {
					print $missingAttrib;
					return "";
				}
				$_reference = we_getTagAttribute("reference", $attribs);
				
				foreach ($GLOBALS['we_position']['linklist'] as $name => $arr) {
					
					if (strpos($name, $_reference) === 0) {
						if (is_array($arr)) {
							$_content = $arr;
						}
					}
				}
				
				if (isset($_content) && $_content['position']) {
					
					switch ($_position) {
						//	$_content is the actual listview object !!!!!!
						case "first" :
							if ($_content['position'] == 1) {
								return true;
							}
							break;
						
						case "last" :
							if ($_content['position'] == $_content['size']) {
								return true;
							}
							break;
						
						case "odd" :
							if ($_content['position'] % 2 != 0) {
								return true;
							}
							break;
						
						case "even" :
							if ($_content['position'] % 2 == 0) {
								return true;
							}
							break;
						
						default :
							$_position += 0; // Umwandeln in integer
							if ($_content['position'] == $_position) {
								return true;
							}
							break;
					}
				}
				break;
			
			case "block" : //	look in function we_tag_block for details
				

				$missingAttrib = attributFehltError($attribs, "reference", "ifPosition");
				if ($missingAttrib) {
					print $missingAttrib;
					return "";
				}
				
				$_reference = we_getTagAttribute("reference", $attribs);
				
				foreach ($GLOBALS['we_position']['block'] as $name => $arr) {
					if (strpos($name, $_reference) === 0) {
						$_content = $arr;
					}
				}
				
				if (isset($_content) && $_content['position']) {
					
					switch ($_position) {
						//	$_content is an array containing position and size !!!!!!
						case "first" :
							if ($_content["position"] == 1) {
								return true;
							}
							break;
						
						case "last" :
							if ($_content["position"] == $_content["size"]) {
								return true;
							}
							break;
						
						case "odd" :
							if ($_content["position"] % 2 != 0) {
								return true;
							}
							break;
						
						case "even" :
							if ($_content["position"] % 2 == 0) {
								return true;
							}
							break;
						
						default :
							$_position += 0; // Umwandeln in integer
							if ($_content["position"] == $_position) {
								return true;
							}
							break;
					}
				}
				break;
			case "listdir" : //	inside a listview
				

				if (isset($GLOBALS['we_position']['listdir'])) {
					$_content = $GLOBALS['we_position']['listdir'];
				}
				if (isset($_content) && $_content['position']) {
					switch ($_position) {
						case "first" :
							if ($_content["position"] == 1) {
								return true;
							}
							break;
						
						case "last" :
							if ($_content["position"] == $_content["size"]) {
								return true;
							}
							break;
						
						case "odd" :
							if ($_content["position"] % 2 != 0) {
								return true;
							}
							break;
						
						case "even" :
							if ($_content["position"] % 2 == 0) {
								return true;
							}
							break;
						
						default :
							$_position += 0; // Umwandeln in integer
							if ($_content["position"] == $_position) {
								return true;
							}
							break;
					}
				}
				break;
			
			default :
				return false;
				break;
		}
	}
	return false;
}

function we_tag_ifNotPosition($attribs, $content)
{
	
	return !we_tag_ifPosition($attribs, $content);
}

function we_tag_position($attribs, $content)
{
	
	global $lv;
	
	//	type is required !!!
	$missingAttrib = attributFehltError($attribs, "type", "position");
	if ($missingAttrib) {
		print $missingAttrib;
		return "";
	}
	
	//	here we get the needed attributes
	$type = we_getTagAttribute("type", $attribs);
	$_reference = we_getTagAttribute("reference", $attribs);
	$format = we_getTagAttribute("format", $attribs, 1);
	
	//	this value we will return later
	$_retPos = "";
	
	switch ($type) {
		
		case "listview" : //	inside a listview, we take direct global listview object
			$_retPos = ($lv->start + $lv->count);
			break;
		
		case "listdir" : //	inside a listview
			if (isset($GLOBALS['we_position']['listdir'])) {
				$_content = $GLOBALS['we_position']['listdir'];
			}
			if (isset($_content) && $_content['position']) {
				$_retPos = $_content['position'];
			}
			break;
		
		case "linklist" : //	look in fkt we_tag_linklist and class we_linklist for details
		case "block" : //	look in function we_tag_block for details
			//	first we must get right array !!!
			$missingAttrib = attributFehltError($attribs, "reference", "position");
			if ($missingAttrib) {
				print $missingAttrib;
				return "";
			}
			foreach ($GLOBALS['we_position'][$type] as $name => $arr) {
				
				if (strpos($name, $_reference) === 0) {
					if (is_array($arr)) {
						$_content = $arr;
					}
				}
			}
			if (isset($_content) && $_content['position']) {
				$_retPos = $_content['position'];
			}
			break;
	}
	
	//	convert to desired format
	switch ($format) {
		
		case "a" :
			return number2System($_retPos);
			break;
		
		case "A" :
			return strtoupper(number2System($_retPos));
			break;
		
		default :
			return $_retPos;
			break;
	}
}

function we_tag_ifRegisteredUserCanChange($attribs, $content)
{
	$admin = we_getTagAttribute("admin", $attribs);
	$userid = we_getTagAttribute("userid", $attribs); // deprecated  use protected=true instead
	$protected = we_getTagAttribute("protected", $attribs, "", true);
	if (!(isset($_SESSION["webuser"]) && isset($_SESSION["webuser"]["ID"]))) {
		return false;
	}
	if ($admin) {
		if (isset($_SESSION["webuser"][$admin]) && $_SESSION["webuser"][$admin])
			return true;
	}
	
	$listview = isset($GLOBALS["lv"]);
	
	if ($listview) {
		if ($protected) {
			return $GLOBALS["lv"]->f("wedoc_WebUserID") == $_SESSION["webuser"]["ID"];
		} else {
			return $GLOBALS["lv"]->f($userid) == $_SESSION["webuser"]["ID"];
		}
	} else {
		if ($protected) {
			return $GLOBALS["we_doc"]->WebUserID == $_SESSION["webuser"]["ID"];
		} else {
			return $GLOBALS["we_doc"]->getElement($userid) == $_SESSION["webuser"]["ID"];
		}
	}
}

function we_tag_ifReturnPage($attribs, $content)
{
	return isset($_REQUEST["we_returnpage"]) && ($_REQUEST["we_returnpage"]);
}

function we_tag_ifSearch($attribs, $content)
{
	$name = we_getTagAttribute("name", $attribs, "0");
	$set = we_getTagAttribute("set", $attribs, 1, true);
	
	if ($set) {
		return isset($_REQUEST["we_lv_search_" . $name]);
	} else {
		return isset($_REQUEST["we_lv_search_" . $name]) && strlen(
				str_replace(
						"\"", 
						"", 
						str_replace(
								"\\\"", 
								"", 
								(isset($_REQUEST["we_lv_search_" . $name]) ? trim(
										$_REQUEST["we_lv_search_" . $name]) : ""))));
	}
}

function we_tag_ifSelf($attribs, $content)
{
	
	$id = we_getTagAttribute("id", $attribs);
	
	if (!$id) {
		if (isset($GLOBALS["we_obj"])) {
			$id = $GLOBALS["we_obj"]->ID;
		} else {
			$id = $GLOBALS["WE_MAIN_DOC"]->ID;
		}
	}
	$type = we_getTagAttribute("doc", $attribs);
	$type = $type ? $type : we_getTagAttribute("type", $attribs);
	
	$ids = makeArrayFromCSV($id);
	
	switch ($type) {
		case "listview" :
			if ($GLOBALS["lv"]->ClassName == "we_listview_object") {
				return in_array($GLOBALS["lv"]->DB_WE->f("OF_ID"), $ids);
			} else 
				if ($GLOBALS["lv"]->ClassName == "we_search_listview") {
					return in_array($GLOBALS["lv"]->DB_WE->f("WE_ID"), $ids);
				} else 
					if ($GLOBALS["lv"]->ClassName == "we_listview_shopVariants") {
						reset($GLOBALS['lv']->Record);
						$key = key($GLOBALS['lv']->Record);
						if (isset($GLOBALS['we_doc']->Variant)) {
							
							if ($key == $GLOBALS['we_doc']->Variant) {
								return true;
							}
						} else {
							if ($key == $GLOBALS['lv']->DefaultName) {
								return true;
							}
						}
						return false;
					} else {
						return in_array($GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count - 1], $ids);
					}
		case "self" :
			return in_array($GLOBALS["we_doc"]->ID, $ids);
		default :
			return in_array($GLOBALS["WE_MAIN_DOC"]->ID, $ids);
	}
}

function we_tag_ifUserInputEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifUserInputEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	return !we_isUserInputNotEmpty($attribs);
}

function we_tag_ifUserInputNotEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifUserInputNotEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	return we_isUserInputNotEmpty($attribs);
}

function we_tag_ifVar($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "ifVar");
	if ($foo) {
		print($foo);
		return "";
	}
	$foo = attributFehltError($attribs, "match", "ifVar", true);
	if ($foo) {
		print($foo);
		return "";
	}
	
	$match = we_getTagAttribute("match", $attribs);
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	
	$matchArray = makeArrayFromCSV($match);
	
	switch ($type) {
		case "customer" :
		case "sessionfield" :
			return (isset($_SESSION["webuser"][$name]) && in_array($_SESSION["webuser"][$name], $matchArray));
		case "global" :
			return (isset($GLOBALS[$name]) && in_array($GLOBALS[$name], $matchArray));
		case "request" :
			if (isset($_REQUEST[$name])) {
				return (isset($_REQUEST[$name]) && in_array($_REQUEST[$name], $matchArray));
			} else {
				return "";
			}
		case "session" :
			if (isset($_SESSION[$name])) {
				return (isset($_SESSION[$name]) && in_array($_SESSION[$name], $matchArray));
			} else {
				return "";
			}
		case "property" :
			$docAttr = we_getTagAttribute("doc", $attribs);
			$doc = we_getDocForTag($docAttr, true);
			eval('$var = $doc->' . $name . ';');
			return in_array($var, $matchArray);
		case "document" :
		default :
			$docAttr = we_getTagAttribute("doc", $attribs);
			$doc = we_getDocForTag($docAttr, true);
			return in_array($doc->getElement($name), $matchArray);
	}
}

function we_tag_ifVarEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifVarEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	return !we_isVarNotEmpty($attribs);
}

function we_tag_ifVarNotEmpty($attribs, $content)
{
	$foo = attributFehltError($attribs, "match", "ifVarNotEmpty");
	if ($foo) {
		print($foo);
		return "";
	}
	return we_isVarNotEmpty($attribs);
}

function we_tag_ifVarSet($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "name", "ifVarSet");
	if ($foo) {
		print($foo);
		return "";
	}
	
	$type = we_getTagAttribute("var", $attribs);
	$type = $type ? $type : we_getTagAttribute("type", $attribs);
	$doc = we_getTagAttribute("doc", $attribs);
	$name = we_getTagAttribute("name", $attribs);
	$formname = we_getTagAttribute("formname", $attribs, "we_global_form");
	$property = we_getTagAttribute("property", $attribs, "", true);
	$shopname = we_getTagAttribute('shopname', $attribs, '');
	
	return we_isVarSet($name, $type, $doc, $property, $formname, $shopname);
}

function we_tag_ifWebEdition($attribs, $content)
{
	return $GLOBALS["WE_MAIN_DOC"]->InWebEdition;
}

function we_tag_ifWorkspace($attribs, $content)
{
	
	$required_path = we_getTagAttribute('path', $attribs, "");
	$docAttr = we_getTagAttribute("doc", $attribs, "self");
	$doc = we_getDocForTag($docAttr);
	$id = we_getTagAttribute('id', $attribs);
	
	if (!$required_path) {
		$required_path = id_to_path($id);
	
	}
	
	if (substr($required_path, 0, 1) != '/') {
		$required_path = '/' . $required_path;
	}
	
	return (strpos($doc->Path, $required_path) === 0);
}

function we_tag_ifWritten($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "");
	$type = $type ? $type : we_getTagAttribute("var", $attribs, "document");
	return isset($GLOBALS["we_" . $type . "_write_ok"]) && ($GLOBALS["we_" . $type . "_write_ok"] == true);
}

function we_tag_img($attribs, $content)
{
	// Define globals
	global $we_editmode;
	
	if ($we_editmode) {
		// Include we_button class
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/css/css.inc.php');
		include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/we_class.inc.php');
	}
	
	$foo = attributFehltError($attribs, "name", "img");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$startid = we_getTagAttribute("startid", $attribs, "");
	$parentid = we_getTagAttribute("parentid", $attribs, "0");
	$showcontrol = we_getTagAttribute("showcontrol", $attribs, "", true, true);
	$showimage = we_getTagAttribute("showimage", $attribs, "true", true, true);
	$showinputs = we_getTagAttribute(
			"showinputs", 
			$attribs, 
			0, 
			true, 
			defined("SHOWINPUTS_DEFAULT") ? SHOWINPUTS_DEFAULT : true);
	
	$id = $GLOBALS["we_doc"]->getElement($name, "bdid");
	$id = $id ? $id : $GLOBALS["we_doc"]->getElement($name);
	$id = $id ? $id : we_getTagAttribute("id", $attribs);
	
	//look if image exists in tblfile
	$imgExists = f("SELECT ID FROM " . FILE_TABLE . " WHERE ID='" . abs($id) . "'", "ID", new DB_WE());
	if ($imgExists == "") {
		$id = 0;
	}
	
	// images can now have custom attribs ...
	$alt = '';
	$title = '';
	
	$altField = $name . '_img_custom_alt';
	$titleField = $name . '_img_custom_title';
	
	$fname = 'we_' . $GLOBALS["we_doc"]->Name . '_img[' . $name . '#bdid]';
	$altname = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $altField . ']';
	$titlename = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $titleField . ']';
	
	if ($id) {
		$img = new we_imageDocument();
		$img->initByID($id);
		
		$alt = $img->getElement('alt');
		$title = $img->getElement('title');
	}
	
	// images can now have custom attribs ...
	if (!(isset($_REQUEST['we_cmd'][0]) && $_REQUEST['we_cmd'][0] == 'reload_editpage' && (isset(
			$_REQUEST['we_cmd'][1]) && $name == $_REQUEST['we_cmd'][1]) && isset($_REQUEST['we_cmd'][2]) && $_REQUEST['we_cmd'][2] == 'change_image') && isset(
			$GLOBALS['we_doc']->elements[$altField])) { // if no other image is selected.
		$alt = $GLOBALS['we_doc']->getElement($altField);
		$title = $GLOBALS['we_doc']->getElement($titleField);
	} elseif (isset($GLOBALS['we_doc'])) {
		$altattr = $GLOBALS['we_doc']->getElement($altField);
		$titleattr = $GLOBALS['we_doc']->getElement($titleField);
		$altattr == "" ? "" : $attribs['alt'] = $altattr;
		$titleattr == "" ? "" : $attribs['title'] = $titleattr;
	}
	
	if ($we_editmode && !$showimage) {
		$out = '';
	} elseif (!$id) {
		$out = '<img src="' . IMAGE_DIR . 'icons/no_image.gif" width="64" height="64" border="0" alt="">';
	} else {
		$out = $GLOBALS["we_doc"]->getField($attribs, "img");
	}
	
	if (!$id && (!$we_editmode)) {
		return "";
	} else 
		if (!$id) {
			$id = "";
		}
	
	if ($showcontrol && $we_editmode) {
		// Create object of we_button class
		$we_button = new we_button();
		
		$out = "
			<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\" background=\"" . IMAGE_DIR . "backgrounds/aquaBackground.gif\" style=\"border: solid #006DB8 1px;\">
				<tr>
					<td class=\"weEditmodeStyle\" colspan=\"2\" align=\"center\">$out
						<input type=\"hidden\" name=\"$fname\" value=\"$id\"></td>
				</tr>";
		if ($showinputs) { //  only when wanted
			$out .= "
		        <tr>
		            <td class=\"weEditmodeStyle\" align=\"center\" style=\"width: 180px;\">
		            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                        <td class=\"weEditmodeStyle\" style=\"color: black; font-size: 12px; font-family: " . $l_css["font_family"] . ";\">" . $l_we_class["alt_kurz"] . ":&nbsp;</td>
                        <td class=\"weEditmodeStyle\">" . htmlTextInput($altname, 16, $alt) . "</td>
                    </tr>
					<tr>
						<td class=\"weEditmodeStyle\"></td>
					</tr>
				    <tr>
		                <td class=\"weEditmodeStyle\" style=\"color: black; font-size: 12px; font-family: " . $l_css["font_family"] . ";\">" . $l_we_class["title"] . ":&nbsp;</td>
		                <td class=\"weEditmodeStyle\">" . htmlTextInput($titlename, 16, $title) . "</td>
                    </tr>
		            </table>
                </tr>";
		}
		
		$out .= "
				<tr>
					<td class=\"weEditmodeStyle\" colspan=\"2\" align=\"center\">";
		
		if ($id == "") { // disable edit_image_button
			$_editButton = $we_button->create_button("image:btn_edit_image", "#", false, 100, 20, "", "", true);
		} else { //	show edit_image_button
			//	we use hardcoded Content-Type - because it must be an image -> <we:img ... >
			$_editButton = $we_button->create_button(
					"image:btn_edit_image", 
					"javascript:top.doClickDirect($id,'image/*', '" . FILE_TABLE . "'  )");
		}
		$out .= $we_button->create_button_table(
				array(
					
						$_editButton, 
						$we_button->create_button(
								"image:btn_select_image", 
								"javascript:we_cmd('openDocselector', '" . ($id != "" ? $id : $startid) . "', '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'" . $fname . "\\'].value', '', 'opener.setScrollTo(); opener.top.we_cmd(\\'reload_editpage\\',\\'" . $name . "\\',\\'change_image\\'); opener.top.hot = 1;', '" . session_id() . "', " . $parentid . ", 'image/*', " . (we_hasPerm(
										"CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ")", 
								true), 
						$we_button->create_button(
								"image:btn_function_trash", 
								"javascript:we_cmd('remove_image', '" . $name . "')", 
								true)
				), 
				5) . "</td></tr></table>";
	}
	return $out;
}

function we_tag_input($attribs, $content)
{
	// Define globals
	global $we_editmode, $l_global;
	
	$foo = attributFehltError($attribs, "name", "input");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$value = we_getTagAttribute("value", $attribs);
	$values = we_getTagAttribute("values", $attribs);
	$mode = we_getTagAttribute("mode", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$format = we_getTagAttribute("format", $attribs);
	
	$seperator = we_getTagAttribute("seperator", $attribs, "|");
	$reload = we_getTagAttribute("reload", $attribs, "", true);
	
	$spellcheck = we_getTagAttribute('spellcheck', $attribs, 'false');
	
	$val = htmlspecialchars(
			isset($GLOBALS["we_doc"]->elements[$name]["dat"]) ? $GLOBALS["we_doc"]->getElement($name) : $value);
	
	if ($type == "date") {
		if ($we_editmode) {
			$d = abs($GLOBALS["we_doc"]->getElement($name));
			return getDateInput2(
					"we_" . $GLOBALS["we_doc"]->Name . "_date[" . $name . "]", 
					($d ? $d : time()), 
					true, 
					$format);
		} else {
			return $GLOBALS["we_doc"]->getField($attribs, "date");
		}
	} else 
		if ($type == "checkbox") {
			if ($we_editmode) {
				$attr = we_make_attribs($attribs, "name,value,type");
				return '<input onclick="_EditorFrame.setEditorIsHot(true);this.form.elements[\'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']\'].value=(this.checked ? 1 : \'\');' . ($reload ? (';setScrollTo();top.we_cmd(\'reload_editpage\');') : '') . '" type="checkbox" name="we_' . $GLOBALS["we_doc"]->Name . '_attrib_' . $name . '" value="1"' . ($attr ? " $attr" : "") . ($val ? " checked" : "") . '><input type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '">';
			} else {
				return ($GLOBALS["we_doc"]->getElement($name));
			}
		} else 
			if ($type == "choice") {
				if ($we_editmode) {
					
					if ($values) {
						
						$tagname = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']';
						$vals = explode($seperator, $values);
						
						if ($mode == "add") {
							$onChange = "this.form.elements['$tagname'].value += ((this.form.elements['$tagname'].value ? ' ' : '')+this.options[this.selectedIndex].text);";
						} else {
							$onChange = "this.form.elements['$tagname'].value = this.options[this.selectedIndex].text;";
						}
						if ($reload) {
							$onChange .= 'setScrollTo();top.we_cmd(\'reload_editpage\');';
						}
						$sel = '<select  class="defaultfont" name="we_choice_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" size="1" onchange="' . $onChange . ';this.selectedIndex=0;_EditorFrame.setEditorIsHot(true);"><option>';
						
						for ($i = 0; $i < sizeof($vals); $i++) {
							$sel .= '<option>' . $vals[$i] . "\n";
						}
						$sel .= "</select>\n";
					}
					$attr = we_make_attribs($attribs, "name,value,type,onchange,mode,values");
					
					return '<input onchange="_EditorFrame.setEditorIsHot(true);" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>' . "&nbsp;" . (isset(
							$sel) ? $sel : "");
				} else {
					return ($GLOBALS["we_doc"]->getElement($name));
				}
			} else 
				if ($type == "select") {
					return $GLOBALS["we_doc"]->getField($attribs, "select");
				} else {
					if ($we_editmode) {
						$we_button = new we_button();
						$attr = we_make_attribs($attribs, "name,value,type,html");
						
						if (defined('SPELLCHECKER') && $spellcheck == 'true') {
							return '<table border="0" cellpadding="0" cellspacing="0" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif">
	<tr>
			<td class="weEditmodeStyle"><input onchange="_EditorFrame.setEditorIsHot(true);" class="wetextinput" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '></td>
			<td class="weEditmodeStyle">' . getPixel(6, 4) . '</td>
			<td class="weEditmodeStyle">' . $we_button->create_button(
									'image:spellcheck', 
									'javascript:we_cmd("spellcheck","we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']")') . '</td>
	</tr>
</table>';
						} else {
							return '<input onchange="_EditorFrame.setEditorIsHot(true);" class="wetextinput" type="text" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" value="' . $val . '"' . ($attr ? " $attr" : "") . '>';
						}
					
					} else {
						return $GLOBALS["we_doc"]->getField($attribs);
					}
				}
}

function we_tag_js($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "id", "js");
	if ($foo)
		return $foo;
	$id = we_getTagAttribute("id", $attribs);
	$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
	
	if (count($row)) {
		
		$url = $row["Path"] . ($row["IsFolder"] ? "/" : "");
		
		$attribs["type"] = "text/javascript";
		$attribs["src"] = $url;
		
		$attribs = removeAttribs($attribs, array(
			"id"
		));
		
		//	prepare $attribs for output:
		return getHtmlTag("script", $attribs, "", true) . "\n";
	
	}
	return "";
}

function we_tag_keywords($attribs, $content)
{
	$htmlspecialchars = we_getTagAttribute("htmlspecialchars", $attribs, "", true);
	$attribs = removeAttribs($attribs, array(
		'htmlspecialchars'
	));
	
	if ($GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PROPERTIES && $GLOBALS["we_doc"]->InWebEdition) { //	normally meta tags are edited on property page
		

		return '<?php	$GLOBALS["meta"]["Keywords"]["default"] = "' . str_replace('"', '\"', $content) . '"; ?>';
	}
	$keys = $GLOBALS['KEYWORDS'] ? $GLOBALS['KEYWORDS'] : $content;
	
	$attribs["name"] = "keywords";
	$attribs["content"] = $htmlspecialchars ? htmlspecialchars(strip_tags($keys)) : strip_tags($keys);
	return getHtmlTag("meta", $attribs) . "\n";
}

function we_tag_link($attribs, $content)
{
	// Define globals
	global $we_editmode, $l_global, $l_linklist_edit;
	
	$name = we_getTagAttribute("name", $attribs);
	$xml = getXmlAttributeValueAsBoolean(we_getTagAttribute("xml", $attribs, ""));
	$text = we_getTagAttribute("text", $attribs, "");
	$imageid = we_getTagAttribute("imageid", $attribs, 0);
	$id = we_getTagAttribute("id", $attribs);
	
	// check if target document exists (Bug #7167)
	if ($id != 0) {
		$row = getHash("SELECT count(*) as tmp FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
		if ($row['tmp'] == 0) {
			$link = array();
			$id = 0;
		}
	}
	if ($imageid != 0) {
		$row = getHash("SELECT count(*) as tmp FROM " . FILE_TABLE . " WHERE ID=".abs($imageid)."", new DB_WE());
		if ($row['tmp'] == 0) {
			$link = array();
			$imageid = 0;
			if (isset($id))
				$id = 0;
		}
	}
	
	$attribs = removeAttribs($attribs, array(
		'text', 'id', 'imageid'
	));
	
	$link = $GLOBALS["we_doc"]->getElement($name) ? unserialize($GLOBALS["we_doc"]->getElement($name)) : array();
	if (!$we_editmode) {
		return $GLOBALS["we_doc"]->getField($attribs, "link");
	} else {
		if (is_array($link)) {
			if (!sizeof($link)) {
				$link = array(
					
						"id" => (isset($id) ? $id : ""), 
						'width' => '', 
						'height' => '', 
						'border' => '', 
						'hspace' => '', 
						'vspace' => '', 
						'align' => '', 
						'alt' => '', 
						'ctype' => ((isset($imageid) && $imageid != 0) ? "int" : "text"), 
						'img_id' => ((isset($imageid) && $imageid != 0) ? $imageid : ""), 
						'type' => (isset($id) ? "int" : "ext"), 
						'href' => (isset($id) ? "" : "http://"), 
						'text' => ((isset($imageid) && $imageid != 0 ? "" : (isset($text) && $text != "" ? $text : $GLOBALS["l_global"]["new_link"])))
				);
				
				// Link should only displayed if it's a preset link
				if ($id != "" || $imageid != 0 || $text != "") {
					$_SESSION["WE_LINK"] = serialize($link);
					$GLOBALS['we_doc']->changeLink($name);
					$GLOBALS['we_doc']->saveInSession($_SESSION["we_data"][$GLOBALS['we_transaction']]);
				}
			}
			
			// Include we_imageDocument class
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_imageDocument.inc.php");
			
			$img = new we_imageDocument();
			$content = we_document::getLinkContent(
					$link, 
					$GLOBALS["we_doc"]->ParentID, 
					$GLOBALS["we_doc"]->Path, 
					$GLOBALS["DB_WE"], 
					$img, 
					$xml);
			
			$startTag = $GLOBALS["we_doc"]->getLinkStartTag(
					$link, 
					$attribs, 
					$GLOBALS["WE_MAIN_DOC"]->ParentID, 
					$GLOBALS["WE_MAIN_DOC"]->Path, 
					$GLOBALS["DB_WE"], 
					$img);
			
			// Include we_button class
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
			
			$we_button = new we_button();
			
			$editbut = $we_button->create_button(
					"image:btn_edit_link", 
					"javascript:setScrollTo(); we_cmd('edit_link', '" . $name . "')", 
					true);
			$delbut = $we_button->create_button(
					"image:btn_function_trash", 
					"javascript:setScrollTo(); we_cmd('delete_link', '" . $name . "')", 
					true);
			
			if (!$content) {
				$content = $text;
			}
			if ($startTag) {
				return $we_button->create_button_table(
						array(
							$startTag . $content . "</a>", $editbut, $delbut
						), 
						5);
			} else {
				return $we_button->create_button_table(array(
					$content, $editbut, $delbut
				), 5);
			}
		}
	}
	return "";
}

function we_tag_linkToSEEM($attribs, $content)
{
	return we_tag_linkToSeeMode($attribs, $content);
}

function we_tag_linkToSeeMode($attribs, $content)
{
	
	$id = we_getTagAttribute('id', $attribs); //	if a document-id is selected go to that document
	$oid = we_getTagAttribute('oid', $attribs); //	if an object-id is selected go to that object
	$permission = we_getTagAttribute("permission", $attribs);
	$docAttr = we_getTagAttribute("doc", $attribs, "top");
	
	$xml = we_getTagAttribute("xml", $attribs, "");
	
	// check for value attribute
	$foo = attributFehltError($attribs, "value", "linkToSeeMode");
	if ($foo)
		return $foo;
	
	$value = we_getTagAttribute("value", $attribs);
	
	if (isset($id) && !empty($id)) {
		
		$type = 'document';
	} else 
		if (isset($GLOBALS['we_obj']) || $oid) { // use object if possible
			

			$type = 'object';
			if ($oid) {
				$id = $oid;
			} else {
				if (isset($GLOBALS['we_obj'])) {
					$id = $GLOBALS['we_obj']->ID;
				}
			}
		} else {
			
			$type = 'document';
			$doc = we_getDocForTag($docAttr, true); // check if we should use the top document or the  included document
			$id = $doc->ID;
		}
	
	if (isset($_SESSION["webuser"]) && isset($_SESSION["webuser"]) && $_SESSION["webuser"]["registered"] && !isset(
			$_REQUEST["we_transaction"])) {
		if ($permission == "" || isset($_SESSION["webuser"][$permission]) && $_SESSION["webuser"][$permission]) { // Has webUser the right permissions??
			//	check if the customer is a user, too.
			$tmpDB = new DB_WE();
			
			$tmpDB->query(
					"SELECT ID FROM " . USER_TABLE . " WHERE username=\"" . $_SESSION["webuser"]["Username"] . "\" AND (UseSalt=0 AND passwd=\"" . md5(
							$_SESSION["webuser"]["Password"]) . "\") OR UseSalt=1 AND passwd=\"" . md5(
							$_SESSION["webuser"]["Password"] . md5($_SESSION["webuser"]["Username"])) . "\"");
			
			if ($tmpDB->num_rows() == 1) { // customer is also a user
				$retStr = getHtmlTag(
						'form', 
						array(
							
								'method' => 'post', 
								'name' => 'startSeeMode_' . $type . '_' . $id, 
								'target' => '_parent', 
								'action' => '/webEdition/loginToSuperEasyEditMode.php'
						), 
								getHtmlTag(
								'input', 
								array(
									
										'type' => 'hidden', 
										'name' => 'username', 
										'value' => $_SESSION["webuser"]["Username"], 
										'xml' => $xml
								)) . getHtmlTag(
								'input', 
								array(
									'type' => 'hidden', 'name' => 'type', 'value' => $type, 'xml' => $xml
								)) . getHtmlTag(
								'input', 
								array(
									'type' => 'hidden', 'name' => 'id', 'value' => $id, 'xml' => $xml
								)) . getHtmlTag(
								'input', 
								array(
									
										'type' => 'hidden', 
										'name' => 'path', 
										'value' => WE_SERVER_REQUEST_URI, 
										'xml' => $xml
								))) . getHtmlTag(
						'a', 
						array(
							
								'href' => 'javascript:document.forms[\'startSeeMode_' . $type . '_' . $id . '\'].submit();', 
								'xml' => $xml
						), 
						$value);
			} else { //	customer is no user
				$retStr = "<!-- ERROR: CUSTOMER IS NO USER! -->";
			}
			unset($tmpDB);
		} else { // User has not the right permissions.
			$retStr = "<!-- ERROR: USER DOES NOT HAVE REQUIRED PERMISSION! -->";
		}
	} else { //	webUser is not registered, show nothing
		$retStr = "<!-- ERROR: USER HAS NOT BEEN LOGGED IN! -->";
	}
	return $retStr;
}

function we_tag_linklist($attribs, $content)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_linklist.inc.php");
	$name = we_getTagAttribute("name", $attribs);
	$content = str_replace("we:link", "we_:_link", $content);
	$foo = attributFehltError($attribs, "name", "linklist");
	if ($foo)
		return $foo;
	$isInListview = isset($GLOBALS["lv"]);
	
	if ($isInListview) {
		$linklist = $GLOBALS["lv"]->f($name);
	} else 
		if (isset($GLOBALS["we_doc"])) {
			$linklist = $GLOBALS["we_doc"]->getElement($name);
		}
	$ll = new we_linklist($linklist);
	$ll->name = $name;
	
	$out = $ll->getHTML(
			(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] && (!$isInListview)), 
			$attribs, 
			$content, 
			$GLOBALS["we_doc"]->Name);
	return $out;
}

function we_tag_list($attribs, $content)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_tagParser.inc.php");
	global $we_editmode;
	
	if ($we_editmode)
		$we_button = new we_button();
	
	$foo = attributFehltError($attribs, "name", "list");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$content = eregi_replace('<we:ref ?/?>', '<we_:_ref>', $content);
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	$names = implode(",", $tp->getNames($tags));
	$isInListview = isset($GLOBALS["lv"]);
	if ($isInListview) {
		$list = $GLOBALS["lv"]->f($name);
	} else {
		$list = $GLOBALS["we_doc"]->getElement($name);
	}
	$out = "";
	if ($list) {
		$listarray = unserialize($list);
		$listlen = sizeof($listarray);
		for ($i = 0; $i < $listlen; $i++) {
			$listRef = $listarray[$i];
			$foo = $content;
			
			$foo = eregi_replace('<we_:_ref>', $listRef, $foo);
			$tp->parseTags($tags, $foo, $listRef);
			
			$buts = "";
			if ($we_editmode) {
				$upbut = $we_button->create_button(
						"image:btn_direction_up", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('up_entry_at_list','$name','$i');");
				$upbutDis = $we_button->create_button("image:btn_direction_up", "#", true, 21, 22, "", "", true);
				$downbut = $we_button->create_button(
						"image:btn_direction_down", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('down_entry_at_list','$name','$i');");
				$downbutDis = $we_button->create_button("image:btn_direction_down", "", true, 21, 22, "", "", true);
				$plusbut = $we_button->create_button(
						"image:btn_add_listelement", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('insert_entry_at_list','$name','$i');");
				$trashbut = $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('delete_list','$name','$i','$names');");
				
				if (!$isInListview) {
					
					$buts = $we_button->create_button_table(
							array(
								
									$plusbut, 
									(($i > 0) ? $upbut : $upbutDis), 
									(($i < ($listlen - 1)) ? $downbut : $downbutDis), 
									$trashbut
							), 
							5);
				}
			}
			
			if (eregi('^< ?td', $foo) || eregi('^< ?tr', $foo)) {
				$foo = eregi_replace('(< ?td[^>]*>)(.*)(< ?/ ?td[^>]*>)', '\1' . $buts . '\2\3', $foo);
			} else {
				$foo = $buts . $foo;
			}
			$out .= $foo;
		
		}
	}
	if ($we_editmode) {
		$plusbut = $we_button->create_button(
				"image:btn_add_listelement", 
				"javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('add_entry_to_list','$name')");
		
		if (eregi('^< ?td', $content) || eregi('^< ?tr', $content)) {
			$foo = makeEmptyTable($content);
			$plusbut = eregi_replace('(< ?td[^>]*>)(.*)(< ?/ ?td[^>]*>)', '\1\2' . $plusbut . '\3', $foo);
		} else {
			$plusbut = "<p>" . $plusbut;
		}
	}
	
	$out .= ((!$isInListview) && $we_editmode) ? ('<input type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_list[' . $name . ']" value="' . htmlspecialchars(
			$list) . '"><input type="hidden" name="we_' . $GLOBALS["we_doc"]->Name . '_list[' . $name . '#content]" value="' . htmlspecialchars(
			$content) . '">' . $plusbut) : '';
	//	When in SEEM - Mode add edit-Button to tag - textarea
	return $out;
}

function we_tag_listdir($attribs, $content)
{
	global $we_editmode;
	
	$dirID = we_getTagAttribute("id", $attribs, $GLOBALS["we_doc"]->ParentID);
	
	$foo = we_getTagAttribute("index", $attribs, "index.html,index.htm,index.php,default.htm,default.html,default.php");
	$index = explode(",", $foo);
	
	$name = we_getTagAttribute("field", $attribs);
	
	$dirfield = we_getTagAttribute("dirfield", $attribs, $name);
	$sort = we_getTagAttribute("order", $attribs, $name);
	
	$desc = we_getTagAttribute("desc", $attribs, "", true);
	
	$q = "";
	foreach ($index as $i => $v) {
		$q .= " Text='$v' OR ";
	}
	$q = ereg_replace("(.*) OR ", '\1', $q);
	
	$files = array();
	
	$db = new DB_WE();
	$db2 = new DB_WE();
	$db3 = new DB_WE();
	
	$db->query(
			"SELECT ID,Text,IsFolder,Path FROM " . FILE_TABLE . " WHERE ((Published > 0 AND IsSearchable = 1) OR (IsFolder = 1)) AND ParentID='".abs($dirID)."'");
	
	while ($db->next_record()) {
		$sortfield = "";
		$namefield = "";
		
		if ($db->f("IsFolder")) {
			$db2->query(
					"SELECT ID FROM " . FILE_TABLE . " WHERE ParentID='" . abs($db->f("ID")) . "' AND IsFolder = 0 AND ($q) AND (Published > 0 AND IsSearchable = 1)");
			if ($db2->next_record()) {
				if ($sort) {
					$db3->query(
							"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='" . abs($db2->f(
									"ID")) . "' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($sort)."' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID");
					if ($db3->next_record()) {
						$sortfield = $db3->f("Dat");
					} else {
						$sortfield = $db->f("Text");
					}
				} else {
					$sortfield = $db->f("Text");
				}
				if ($dirfield) {
					$db3->query(
							"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='" . abs($db2->f(
									"ID")) . "' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($dirfield)."' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID");
					if ($db3->next_record()) {
						$namefield = $db3->f("Dat");
					} else {
						$namefield = $db->f("Text");
					}
				} else {
					$namefield = $db->f("Text");
				}
				array_push(
						$files, 
						array(
							"properties" => $db->Record, "sort" => $sortfield, "name" => $namefield
						));
			}
		
		} else {
			if ($sort) {
				$db2->query(
						"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='" . abs($db->f(
								"ID")) . "' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($sort)."' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID");
				if ($db2->next_record()) {
					$sortfield = $db2->f("Dat");
				} else {
					$sortfield = $db->f("Text");
				}
			} else {
				$sortfield = $db->f("Text");
			}
			if ($name) {
				$db2->query(
						"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='" . abs($db->f(
								"ID")) . "' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($name)."' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID");
				if ($db2->next_record()) {
					$namefield = $db2->f("Dat");
				} else {
					$namefield = $db->f("Text");
				}
			} else {
				$namefield = $db->f("Text");
			}
			array_push(
					$files, 
					array(
						"properties" => $db->Record, "sort" => $sortfield, "name" => $namefield
					));
		}
	}
	
	if ($sort) {
		if ($desc) {
			usort($files, "we_cmpFieldDesc");
		} else {
			usort($files, "we_cmpField");
		}
	} else {
		if ($desc) {
			usort($files, "we_cmpTextDesc");
		} else {
			usort($files, "we_cmpText");
		}
	}
	$out = "";
	
	foreach ($files as $i => $v) {
		
		$field = $v["name"];
		$id = $v["properties"]["ID"];
		$path = $v["properties"]["Path"];
		$foo = ereg_replace('<we:field([^>]*)>', $field, $content);
		$foo = ereg_replace('<we:id([^>]*)>', $id, $foo);
		$foo = ereg_replace('<we:path([^>]*)>', $path, $foo);
		$foo = ereg_replace('<we:a([^>]*)>', '<a href="' . $path . '"\1>', $foo);
		$foo = ereg_replace('</we:a[^>]*>', '</a>', $foo);
		$foo = ereg_replace(
				'<we:ifSelf[^>]*>', 
				'<?php if("' . $GLOBALS["WE_MAIN_DOC"]->ID . '" == "' . $id . '"): ?>', 
				$foo);
		$foo = ereg_replace('</we:ifSelf[^>]*>', '<?php endif ?>', $foo);
		$foo = ereg_replace(
				'<we:ifNotSelf[^>]*>', 
				'<?php if("' . $GLOBALS["WE_MAIN_DOC"]->ID . '" != "' . $id . '"): ?>', 
				$foo);
		$foo = ereg_replace('</we:ifNotSelf[^>]*>', '<?php endif ?>', $foo);
		$foo = ereg_replace('</we:else[^>]*>', '<?php else: ?>', $foo);
		$foo = ereg_replace('<we:else[^/]*/>', '<?php else: ?>', $foo);
		
		//	parse we:ifPosition
		if (strpos($foo, 'setVar') || strpos($foo, 'position') || strpos($foo, 'ifPosition') || strpos(
				$foo, 
				'ifNotPosition')) {
			$tp = new we_tagParser();
			$tags = $tp->getAllTags($foo);
			
			$tp->parseTags($tags, $foo);
			$foo = '<?php $GLOBALS[\'we_position\'][\'listdir\'] = array(\'position\' => ' . ($i + 1) . ', \'size\' => ' . sizeof(
					$files) . ', \'field\' => \'' . $field . '\', \'id\' => \'' . $id . '\', \'path\' => \'' . $path . '\'); ?>' . $foo . '<?php unset($GLOBALS[\'we_position\'][\'listdir\']); ?>';
		}
		
		$out .= $foo . "\n";
	}
	return $out . "\n";
}

function we_tag_listviewEnd($attribs, $content)
{
	return $GLOBALS["lv"]->rows ? min(
			($GLOBALS["lv"]->start - abs($GLOBALS["lv"]->offset)) + $GLOBALS["lv"]->rows, 
			($GLOBALS["lv"]->anz_all - abs($GLOBALS["lv"]->offset))) : ($GLOBALS["lv"]->anz_all - abs(
			$GLOBALS["lv"]->offset));
}

function we_tag_listviewPageNr($attribs, $content)
{
	return $GLOBALS["lv"]->rows ? (((abs($GLOBALS["lv"]->start) - abs($GLOBALS["lv"]->offset)) / $GLOBALS["lv"]->rows) + 1) : 1;
}

function we_tag_listviewPages($attribs, $content)
{
	return $GLOBALS["lv"]->rows ? ceil(
			((float)$GLOBALS["lv"]->anz_all - abs($GLOBALS["lv"]->offset)) / (float)$GLOBALS["lv"]->rows) : 1;
}

function we_tag_listviewRows($attribs, $content)
{
	return $GLOBALS["lv"]->anz_all - abs($GLOBALS["lv"]->offset);
}

function we_tag_listviewStart($attribs, $content)
{
	return $GLOBALS["lv"]->start + 1 - abs($GLOBALS["lv"]->offset);
}

function we_tag_makeMail($attribs, $content)
{
	return "";
}

function we_tag_next($attribs, $content)
{
	if (isset($GLOBALS["_we_voting_list"]))
		return $GLOBALS["_we_voting_list"]->getNextLink($attribs);
	else
		return $GLOBALS["lv"]->getNextLink($attribs);
}

function we_tag_options($attribs, $content)
{
	$name = we_getTagAttribute("name", $attribs);
	$classid = we_getTagAttribute("classid", $attribs);
	$field = we_getTagAttribute("field", $attribs);
	
	$o = "";
	if ($classid && $field) {
		if (!isset($GLOBALS["WE_OBJECT_DEFARRAY"])) {
			$GLOBALS["WE_OBJECT_DEFARRAY"] = array();
		}
		if (!isset($GLOBALS["WE_OBJECT_DEFARRAY"]["cid_$classid"])) {
			$db = new DB_WE();
			$GLOBALS["WE_OBJECT_DEFARRAY"]["cid_$classid"] = unserialize(
					f("SELECT DefaultValues FROM " . OBJECT_TABLE . " WHERE ID='$classid'", "DefaultValues", $db));
		}
		$foo = $GLOBALS["WE_OBJECT_DEFARRAY"]["cid_$classid"]["meta_$field"]["meta"];
		foreach ($foo as $key => $val) {
			$o .= '<option value="' . $key . '"' . ((($GLOBALS[$name] == $key) && strlen($GLOBALS[$name]) != 0) ? " selected" : "") . '>' . $val . '</option>' . "\n";
		}
		return $o;
	}
	return "";
}

function we_tag_path($attribs, $content)
{
	$db = new DB_WE();
	$field = we_getTagAttribute("field", $attribs);
	$dirfield = we_getTagAttribute("dirfield", $attribs, $field);
	$index = we_getTagAttribute("index", $attribs);
	$htmlspecialchars = we_getTagAttribute("htmlspecialchars", $attribs, "", true);
	
	$docAttr = we_getTagAttribute("doc", $attribs);
	$doc = we_getDocForTag($docAttr, true);
	
	$pID = $doc->ParentID;
	
	$indexArray = $index ? explode(",", $index) : array(
		"index.html", "index.htm", "index.php", "default.htm", "default.html", "default.php"
	);
	
	$sep = we_getTagAttribute("separator", $attribs, "/");
	$home = we_getTagAttribute("home", $attribs, "home");
	$hidehome = we_getTagAttribute("hidehome", $attribs, false, true);
	
	$class = we_getTagAttribute("class", $attribs);
	$style = we_getTagAttribute("style", $attribs);
	
	$class = $class ? ' class="' . $class . '"' : '';
	$style = $style ? ' style="' . $style . '"' : '';
	
	$path = "";
	$q = "";
	foreach ($indexArray as $i => $v) {
		$q .= " Text='$v' OR ";
	}
	$q = ereg_replace("(.*) OR ", '\1', $q);
	$id = $doc->ID;
	$show = $doc->getElement($field);
	if (!in_array($doc->Text, $indexArray)) {
		if (!$show)
			$show = $doc->Text;
		$path = $htmlspecialchars ? htmlspecialchars($sep . $show) : $sep . $show;
	}
	while ($pID) {
		$db->query(
				"SELECT ID,Path FROM " . FILE_TABLE . " WHERE ParentID='".abs($pID)."' AND IsFolder = 0 AND ($q) AND (Published > 0 AND IsSearchable = 1)");
		$db->next_record();
		$fileID = $db->f("ID");
		$filePath = $db->f("Path");
		if ($fileID) {
			$show = f(
					"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='".abs($fileID)."' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($dirfield)." ' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID", 
					"Dat", 
					$db);
			if (!$show)
				$show = f("SELECT Text FROM " . FILE_TABLE . " WHERE ID='".abs($pID)."'", "Text", $db);
			
			if ($fileID != $doc->ID) {
				$link_pre = '<a href="' . $filePath . '"' . $class . $style . '>';
				$link_post = '</a>';
			} else {
				$link_pre = '';
				$link_post = '';
			}
		} else {
			$link_pre = '';
			$link_post = '';
			$show = f("SELECT Text FROM " . FILE_TABLE . " WHERE ID='".abs($pID)."'", "Text", $db);
		}
		$pID = f("SELECT ParentID from " . FILE_TABLE . " WHERE ID='".abs($pID)."'", "ParentID", $db);
		if (!$pID && $hidehome) {
			$path = $link_pre . ($htmlspecialchars ? htmlspecialchars($show) : $show) . $link_post . $path;
		} else {
			$path = $sep . $link_pre . ($htmlspecialchars ? htmlspecialchars($show) : $show) . $link_post . $path;
		}
	}
	$show = "";
	$db->query(
			"SELECT ID,Path FROM " . FILE_TABLE . " WHERE ParentID='0' AND IsFolder = 0 AND ($q) AND (Published > 0 AND IsSearchable = 1)");
	$db->next_record();
	$fileID = $db->f("ID");
	$filePath = $db->f("Path");
	if ($fileID) {
		$show = f(
				"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID='".abs($fileID)."' AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($field)."' AND " . CONTENT_TABLE . ".ID = " . LINK_TABLE . ".CID", 
				"Dat", 
				$db);
		if (!$show) {
			$show = $home;
		}
		$link_pre = '<a href="' . $filePath . '"' . $class . $style . '>';
		$link_post = '</a>';
	} else {
		$link_pre = '';
		$link_post = '';
		$show = $home;
	}
	if ($hidehome) {
		$show = "";
	} else {
		$show = $link_pre . ($htmlspecialchars ? htmlspecialchars($show) : $show) . $link_post;
	}
	return $show . $path;
}

function we_tag_printVersion($attribs, $content)
{
	$foo = attributFehltError($attribs, "tid", "printVersion");
	if ($foo)
		return $foo;
	
	$tid = we_getTagAttribute("tid", $attribs);
	$triggerID = we_getTagAttribute("triggerID", $attribs); // :ATTENTION: difference between tag wizzard and program
	$triggerID = $triggerID ? $triggerID : we_getTagAttribute("triggerid", $attribs);
	
	$docAttr = we_getTagAttribute("doc", $attribs);
	if (!$docAttr) {
		$docAttr = we_getTagAttribute("type", $attribs);
	}
	
	$link = isset($attribs["Link"]) ? $attribs["Link"] : "";
	if (!$link) {
		$link = isset($attribs["link"]) ? $attribs["link"] : "";
	}
	
	$doc = we_getDocForTag($docAttr);
	
	$id = isset($doc->OF_ID) ? $doc->OF_ID : $doc->ID;
	
	$_query_string = "";
	
	$hideQuery = array(
		"we_objectID", "tid", "id", "pv_tid", "pv_id", "we_cmd", "responseText", "we_mode", "btype"
	);
	if (isset($_SESSION)) {
		array_push($hideQuery, session_name());
	}
	if (isset($_POST)) {
		foreach ($_POST as $k => $v) {
			if ((!is_array($v)) && (!in_array($k, $hideQuery))) {
				$_query_string .= "&" . rawurlencode($k) . "=" . rawurlencode($v);
			}
		}
	}
	if (isset($_GET)) {
		foreach ($_GET as $k => $v) {
			if ((!is_array($v)) && (!in_array($k, $hideQuery))) {
				$_query_string .= "&" . rawurlencode($k) . "=" . rawurlencode($v);
			}
		}
	}
	if ($_query_string) {
		$_query_string = htmlspecialchars($_query_string);
	}
	
	if (isset($doc->TableID)) {
		if ($triggerID) {
			$url = id_to_path($triggerID) . "?we_objectID=$id&amp;tid=$tid" . $_query_string;
		} else {
			$url = "/webEdition/we_cmd.php?we_cmd[0]=preview_objectFile&amp;we_objectID=$id&amp;we_cmd[2]=$tid" . $_query_string;
		}
	} else {
		if ($triggerID) {
			$loc = id_to_path($triggerID) . "?";
			$url = $loc . 'pv_id=' . $id . '&amp;pv_tid=' . $tid . $_query_string;
		} else {
			$loc = "/webEdition/we_cmd.php?we_cmd[0]=show&amp;";
			$url = $loc . 'we_cmd[1]=' . $id . '&amp;we_cmd[4]=' . $tid . $_query_string;
		}
	}
	$attr = we_make_attribs($attribs, "tid,doc,link,Link,triggerid");
	
	if ($link == "off" || $link == "false") {
		return $url;
	} else {
		$GLOBALS["we_tag_start_printVersion"] = 1;
		return '<a href="' . $url . '"' . ($attr ? " $attr" : '') . '>';
	}
}

function we_tag_processDateSelect($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "dateSelect");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$endofday = we_getTagAttribute("endofday", $attribs, "", true);
	$GLOBALS[$name] = $_REQUEST[$name] = mktime(
			$endofday ? 23 : 0, 
			$endofday ? 59 : 0, 
			$endofday ? 59 : 0, 
			isset($_REQUEST[$name . "_month"]) ? $_REQUEST[$name . "_month"] : 0, 
			isset($_REQUEST[$name . "_day"]) ? $_REQUEST[$name . "_day"] : 0, 
			isset($_REQUEST[$name . "_year"]) ? $_REQUEST[$name . "_year"] : 0);
}

function we_tag_quicktime($attribs, $content)
{
	// Include Quicktime class
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_quicktimeDocument.inc.php");
	
	// Define globals
	global $we_editmode;
	
	$foo = attributFehltError($attribs, "name", "quicktime");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$id = $GLOBALS["we_doc"]->getElement($name, "bdid");
	$id = $id ? $id : we_getTagAttribute("id", $attribs);
	$fname = 'we_' . $GLOBALS["we_doc"]->Name . '_img[' . $name . '#bdid]';
	
	$showcontrol = we_getTagAttribute("showcontrol", $attribs, "true", true, true);
	$showquicktime = we_getTagAttribute("showquicktime", $attribs, "true", true, true);
	
	$attribs = removeAttribs($attribs, array(
		'showcontrol', 'showquicktime'
	));
	
	if ($we_editmode && !$showquicktime) {
		$out = '';
	} else {
		$out = $GLOBALS["we_doc"]->getField($attribs, "quicktime");
	}
	
	if ($showcontrol && $we_editmode) {
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		$we_button = new we_button();
		$quicktime_button = $we_button->create_button(
				"image:btn_edit_quicktime", 
				"javascript:we_cmd('openDocselector','" . $id . "', '" . FILE_TABLE . "', 'document.forms[\'we_form\'].elements[\'" . $fname . "\'].value', '', 'opener.setScrollTo();opener.top.we_cmd(\'reload_editpage\');opener._EditorFrame.setEditorIsHot(true);', '" . session_id() . "', 0, 'video/quicktime', " . (we_hasPerm(
						"CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ")", 
				true);
		$clear_button = $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:we_cmd('remove_image', '" . $name . "')", 
				true);
		
		$out = "
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"2\" background=\"" . IMAGE_DIR . "backgrounds/aquaBackground.gif\" style=\"border: solid #006DB8 1px;\">
				<tr>
					<td class=\"weEditmodeStyle\">$out
						<input type=\"hidden\" name=\"$fname\" value=\"" . $GLOBALS["we_doc"]->getElement(
				$name, 
				"bdid") . "\"></td>
				</tr>
				<tr>
					<td class=\"weEditmodeStyle\" align=\"center\">";
		$out .= $we_button->create_button_table(array(
			$quicktime_button, $clear_button
		), 5) . "</td></tr></table>";
	}
	//	When in SEEM - Mode add edit-Button to tag - textarea
	return $out;
}

function we_tag_registeredUser($attribs, $content)
{
	
	$id = we_getTagAttribute("id", $attribs);
	$show = we_getTagAttribute("show", $attribs);
	$docAttr = we_getTagAttribute("doc", $attribs);
	
	if (ereg("^field:(.+)$", $id, $regs)) {
		$doc = we_getDocForTag($docAttr);
		$field = $regs[1];
		if (strlen($field))
			$id = $doc->getElement($field);
	}
	if ($id) {
		$db = new DB_WE();
		$h = getHash("SELECT * FROM " . CUSTOMER_TABLE . " WHERE id='$id'", $db);
		if ($show) {
			preg_match_all("|%([^ ]+) ?|i", $show, $foo, PREG_SET_ORDER);
			for ($i = 0; $i < sizeof($foo); $i++) {
				$show = str_replace("%" . $foo[$i][1], $h[$foo[$i][1]], $show);
			}
			return $show;
		} else {
			return $h["Username"];
		}
	}
	return "";
}

function we_tag_returnPage($attribs, $content)
{
	
	$xml = we_getTagAttribute("xml", $attribs, "");
	
	return isset($_REQUEST["we_returnpage"]) ? (getXmlAttributeValueAsBoolean($xml) ? htmlspecialchars(
			$_REQUEST["we_returnpage"]) : $_REQUEST["we_returnpage"]) : "";
}

function we_tag_search($attribs, $content)
{
	
	$name = we_getTagAttribute("name", $attribs, "0");
	$type = we_getTagAttribute("type", $attribs);
	$xml = we_getTagAttribute("xml", $attribs, "");
	$value = we_getTagAttribute("value", $attribs, "");
	
	$searchValue = htmlspecialchars(
			str_replace(
					"\"", 
					"", 
					str_replace(
							"\\\"", 
							"", 
							(isset($_REQUEST["we_lv_search_" . $name]) ? trim($_REQUEST["we_lv_search_" . $name]) : $value))));
	if ($type == "print") {
		return $searchValue;
	} else {
		
		$attsHidden = array(
			
				'type' => 'hidden', 
				'xml' => $xml, 
				'name' => 'we_from_search_' . $name, 
				'value' => (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] ? 0 : 1)
		);
		
		$hidden = getHtmlTag('input', $attsHidden);
		if ($type == "textinput") {
			
			$atts = removeAttribs($attribs, array(
				'type', 'onchange', 'name', 'cols', 'rows'
			));
			$atts = array_merge(
					$atts, 
					array(
						
					'name' => "we_lv_search_$name", 'type' => 'text', 'value' => $searchValue, 'xml' => $xml
					));
			return getHtmlTag('input', $atts) . $hidden;
		
		} else 
			if ($type == "textarea") {
				
				$atts = removeAttribs(
						$attribs, 
						array(
							'type', 'onchange', 'name', 'size', 'maxlength', 'value'
						));
				$atts = array_merge(
						$atts, 
						array(
							'class' => 'defaultfont', 'name' => "we_lv_search_$name", 'xml' => $xml
						));
				
				return getHtmlTag('textarea', $atts, $searchValue, true) . $hidden;
			}
	}
}

function we_tag_select($attribs, $content)
{
	global $we_editmode, $l_global;
	$foo = attributFehltError($attribs, "name", "select");
	if ($foo)
		return $foo;
	$name = we_getTagAttribute("name", $attribs);
	$onchange = we_getTagAttribute("onchange", $attribs);
	$reload = we_getTagAttribute("reload", $attribs, "", true);
	
	if ($we_editmode) {
		$val = $GLOBALS["we_doc"]->getElement($name);
		$attr = we_make_attribs($attribs, "name,value,onchange");
		if ($val) {
			$content = eregi_replace("<(option[^>]*) selected>", "<\\1>", $content);
			if (eregi("<option>", $content))
				$content = eregi_replace(
						'<option>' . quotemeta($val) . "( ?[<\n\r\t])", 
						'<option selected>' . $val . '\1', 
						$content);
			if (eregi('<option value=[\'"]?.*[\'"]?>', $content))
				$content = eregi_replace(
						'<option value=[\'"]?' . quotemeta($val) . '[\'"]?>', 
						'<option value="' . $val . '" selected>', 
						$content);
		}
		return '<select onchange="_EditorFrame.setEditorIsHot(true);' . ($onchange ? $onchange : "") . ';' . ($reload ? (';setScrollTo();top.we_cmd(\'reload_editpage\');') : '') . '" class="defaultfont" name="we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']" ' . ($attr ? " $attr" : "") . '>' . $content . '</select>';
	} else {
		return ($GLOBALS["we_doc"]->getElement($name));
	}
}

function we_tag_sendMail($attribs, $content)
{
	global $DB_WE;
	
	$foo = attributFehltError($attribs, "recipient", "sendMail");
	if ($foo)
		return $foo;
	$foo = attributFehltError($attribs, "from", "sendMail");
	if ($foo)
		return $foo;
	
	if (!$GLOBALS["we_doc"]->InWebEdition) {
		
		$DB_WE = !isset($DB_WE) ? new DB_WE() : $DB_WE;
		$id = we_getTagAttribute("id",$attribs, ( isset($_REQUEST["ID"])? $_REQUEST["ID"] : "" ) );
		$from = we_getTagAttribute("from",$attribs);
		$reply = we_getTagAttribute("reply",$attribs);
		$recipient = we_getTagAttribute("recipient",$attribs);
		$mimetype = we_getTagAttribute("mimetype",$attribs);
		$subject = we_getTagAttribute("subject",$attribs);
		$charset = we_getTagAttribute("charset",$attribs,"UTF-8");

		if (!empty($id)) {
			
			$codes = we_getDocumentByID($id);
		    $to = explode(",",$recipient);

		    $we_recipient = array();
			for ($l=0;$l < sizeof($to);$l++) {

		    	if (!eregi("@",$to[$l])) {
		    		if (isset($_SESSION["webuser"]["registered"]) && $_SESSION["webuser"]["registered"] && eregi("@",$_SESSION["webuser"][$to[$l]])) { //wenn man registireten Usern was senden moechte
		    			$we_recipient[] = $_SESSION["webuser"][$to[$l]];
		    		} else if(isset($_REQUEST[$to[$l]]) && eregi("@",$_REQUEST[$to[$l]])) {	//email to friend test
		    			$we_recipient[] = $_REQUEST[$to[$l]];
		    		}
		    	} else {
					$we_recipient[] = $to[$l];
		    	}
			}
		    $phpmail = new we_util_Mailer($we_recipient,$subject,$from,$from,$reply);
		    $phpmail->setCharSet($charset);
			if ($mimetype != "text/html") {
				$phpmail->addTextPart(strip_tags(str_replace("&nbsp;"," ",str_replace("<br />","\n",str_replace("<br>","\n",$codes)))));
			} else {
				$phpmail->addHTMLPart($codes);
			}
		    $phpmail->buildMessage();
		    $phpmail->Send();
		}
	}
	return;
}

function we_tag_sessionStart($attribs, $content)
{
	$GLOBALS["WE_SESSION_START"] = true;
	if (defined("CUSTOMER_TABLE")) {
		if (isset($_REQUEST["we_webUser_logout"]) && $_REQUEST["we_webUser_logout"]) {
			
			if (!isset($_SESSION))
				@session_start();
			unset($_SESSION["webuser"]);
			session_unregister("s");
			unset($_REQUEST["s"]);
			$_SESSION["webuser"] = array(
				"registered" => false
			);
		
		} else {
			if (!isset($_SESSION))
				@session_start();
			if (isset($_REQUEST["we_set_registeredUser"]) && $GLOBALS["we_doc"]->InWebEdition) {
				$_SESSION["we_set_registered"] = $_REQUEST["we_set_registeredUser"];
			}
			if (!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]) {
				if (!isset($_SESSION["webuser"])) {
					$_SESSION["webuser"] = array(
						"registered" => false
					);
				}
				if (isset($_REQUEST["s"]["Username"]) && isset($_REQUEST["s"]["Password"]) && !(isset(
						$_REQUEST["s"]["ID"]))) {
					$u = getHash(
							'SELECT * from ' . CUSTOMER_TABLE . ' WHERE Username="' . mysql_real_escape_string($_REQUEST['s']["Username"]) . '"', 
							$GLOBALS["DB_WE"]);
					if (isset($u["Password"]) && $u["LoginDenied"] != 1) {
						if ($_REQUEST['s']["Username"] == $u["Username"] && $_REQUEST['s']["Password"] == $u["Password"]) {
							$_SESSION["webuser"] = $u;
							$_SESSION["webuser"]["registered"] = true;
							$GLOBALS["DB_WE"]->query(
									"UPDATE " . CUSTOMER_TABLE . " SET LastLogin='" . time() . "' WHERE ID='" . abs($_SESSION["webuser"]["ID"]) . "'");
						} else {
							$_SESSION["webuser"] = array(
								"registered" => false, "loginfailed" => true
							);
						}
					
					} else {
						$_SESSION["webuser"] = array(
							"registered" => false, "loginfailed" => true
						);
					}
				}
				
				if (isset($_SESSION["webuser"]["registered"]) && isset($_SESSION["webuser"]["ID"]) && $_SESSION["webuser"]["registered"] && $_SESSION["webuser"]["ID"]) {
					$lastAccessExists = false;
					$foo = $GLOBALS["DB_WE"]->metadata(CUSTOMER_TABLE);
					for ($i = 0; $i < sizeof($foo); $i++) {
						if ($foo[$i]["name"] == "LastAccess") {
							$lastAccessExists = true;
							break;
						}
					}
					if ($lastAccessExists) {
						$GLOBALS["DB_WE"]->query(
								"UPDATE " . CUSTOMER_TABLE . " SET LastAccess='" . time() . "' WHERE ID='" . mysql_real_escape_string($_SESSION["webuser"]["ID"]) . "'");
					}
				}
			
			}
		}
		return "";
	
	} else {
		if (!isset($_SESSION))
			@session_start();
	}
	return "";
}

function we_tag_setVar($attribs, $content)
{
	$foo = attributFehltError($attribs, "nameto", "setVar");
	if ($foo)
		return $foo;
	$foo = attributFehltError($attribs, "to", "setVar");
	if ($foo)
		return $foo;
	
	$nameFrom = we_getTagAttribute("namefrom", $attribs);
	$nameTo = we_getTagAttribute("nameto", $attribs);
	$typeFrom = we_getTagAttribute("typefrom", $attribs, "text");
	$to = we_getTagAttribute("to", $attribs);
	$from = we_getTagAttribute("from", $attribs);
	$propertyTo = we_getTagAttribute("propertyto", $attribs, "", true);
	$propertyFrom = we_getTagAttribute("propertyfrom", $attribs, "", true);
	$formnameTo = we_getTagAttribute("formnameto", $attribs, "we_global_form");
	$formnameFrom = we_getTagAttribute("formnamefrom", $attribs, "we_global_form");
	if (isset($attribs["value"])) {
		$valueFrom = we_getTagAttribute("value", $attribs);
	} else {
		
		$valueFrom = "";
		switch ($from) {
			case "request" :
				$valueFrom = isset($_REQUEST[$nameFrom]) ? $_REQUEST[$nameFrom] : "";
				break;
			case "global" :
				$valueFrom = isset($GLOBALS[$nameFrom]) ? $GLOBALS[$nameFrom] : "";
				break;
			case "session" :
				$valueFrom = isset($_SESSION[$nameFrom]) ? $_SESSION[$nameFrom] : "";
				break;
			case "top" :
				if ($propertyFrom) {
					eval(
							'$valueFrom = isset($GLOBALS["WE_MAIN_DOC"]->' . $nameFrom . ') ? $GLOBALS["WE_MAIN_DOC"]->' . $nameFrom . ' : "";');
				} else {
					if ($typeFrom == "href") {
						$valueFrom = isset($GLOBALS["WE_MAIN_DOC"]->elements[$nameFrom . '_we_jkhdsf_int']) ? $GLOBALS["WE_MAIN_DOC"]->getField(
								array(
									"name" => $nameFrom
								), 
								$typeFrom, 
								true) : "";
					} else {
						$valueFrom = isset($GLOBALS["WE_MAIN_DOC"]->elements[$nameFrom]) ? $GLOBALS["WE_MAIN_DOC"]->getField(
								array(
									"name" => $nameFrom
								), 
								$typeFrom, 
								true) : "";
					}
				}
				break;
			case "self" :
				if ($propertyFrom) {
					eval(
							'$valueFrom = isset($GLOBALS["we_doc"]->' . $nameFrom . ') ? $GLOBALS["we_doc"]->' . $nameFrom . ' : "";');
				} else {
					if ($typeFrom == "href") {
						$valueFrom = isset($GLOBALS["we_doc"]->elements[$nameFrom . '_we_jkhdsf_int']) ? $GLOBALS["we_doc"]->getField(
								array(
									"name" => $nameFrom
								), 
								$typeFrom, 
								true) : "";
					} else {
						$valueFrom = isset($GLOBALS["we_doc"]->elements[$nameFrom]) ? $GLOBALS["we_doc"]->getField(
								array(
									"name" => $nameFrom
								), 
								$typeFrom, 
								true) : "";
					}
				}
				break;
			case "object" :
			case "document" :
				if ($propertyFrom) {
					eval(
							'$valueFrom = isset($GLOBALS["we_' . $from . '"][$formnameFrom]->' . $nameFrom . ') ? $GLOBALS["we_' . $from . '"][$formnameFrom]->' . $nameFrom . ' : "";');
				} else {
					$valueFrom = isset($GLOBALS["we_" . $from][$formnameFrom]->elements[$nameFrom]) ? $GLOBALS["we_" . $from][$formnameFrom]->getElement(
							$nameFrom) : "";
				}
				break;
			case "sessionfield" :
				$valueFrom = isset($_SESSION["webuser"][$nameFrom]) ? $_SESSION["webuser"][$nameFrom] : "";
				break;
			case "calendar" :
				$valueFrom = listviewBase::getCalendarFieldValue($GLOBALS["lv"]->calendar_struct, $nameFrom);
				break;
			case "listview" :
				if (!isset($GLOBALS["lv"])) {
					return parseError($GLOBALS["l_parser"]["setVar_lv_not_in_lv"]);
				}
				$valueFrom = we_tag_field(array(
					'name' => $nameFrom, 'type' => $typeFrom
				), "");
				break;
			case "block" :
				
				if ($typeFrom == "href") {
					
					if ($GLOBALS["we_doc"]->elements[$nameFrom . "_we_jkhdsf_int"]["dat"]) {
						$nameFrom .= "_we_jkhdsf_intPath";
					}
				}
				$valueFrom = isset($GLOBALS["WE_MAIN_DOC"]->elements[$nameFrom]) ? $GLOBALS["WE_MAIN_DOC"]->getField(
						array(
							"name" => $nameFrom
						), 
						$typeFrom, 
						true) : "";
				break;
			case "listdir" :
				$valueFrom = isset($GLOBALS['we_position']['listdir'][$nameFrom]) ? $GLOBALS['we_position']['listdir'][$nameFrom] : "";
				break;
		
		}
	}
	
	switch ($to) {
		case "request" :
			$_REQUEST[$nameTo] = $valueFrom;
			break;
		case "global" :
			$GLOBALS[$nameTo] = $valueFrom;
			break;
		case "session" :
			$_SESSION[$nameTo] = $valueFrom;
			break;
		case "top" :
			if ($propertyTo) {
				eval('$GLOBALS["WE_MAIN_DOC_REF"]->' . $nameTo . ' = $valueFrom;');
			} else {
				$GLOBALS["WE_MAIN_DOC_REF"]->setElement($nameTo, $valueFrom);
			}
			break;
		case "block" :
		case "self" :
			if ($propertyTo) {
				eval('$GLOBALS["we_doc"]->' . $nameTo . ' = $valueFrom;');
			} else {
				$GLOBALS["we_doc"]->setElement($nameTo, $valueFrom);
			}
			break;
		case "object" :
		case "document" :
			if ($propertyTo) {
				if (isset($GLOBALS["we_$to"][$formnameTo]))
					eval('$GLOBALS["we_$to"][$formnameTo]->' . $nameTo . ' = $valueFrom;');
			} else {
				if (isset($GLOBALS["we_$to"][$formnameTo]))
					$GLOBALS["we_$to"][$formnameTo]->setElement($nameTo, $valueFrom);
			}
			break;
		case "sessionfield" :
			if (isset($_SESSION["webuser"][$nameTo]))
				$_SESSION["webuser"][$nameTo] = $valueFrom;
	}

}

function we_tag_textarea($attribs, $content)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
	global $we_editmode, $we_transaction, $IE55, $MOZ13;
	$foo = attributFehltError($attribs, "name", "textarea");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$xml = we_getTagAttribute("xml", $attribs, "");
	$removeFirstParagraph = we_getTagAttribute("removefirstparagraph", $attribs, 0, true, true);
	$attribs = removeAttribs($attribs, array(
		'removefirstparagraph'
	));
	
	$html = we_getTagAttribute("html", $attribs, "", true, true);
	$autobrAttr = we_getTagAttribute("autobr", $attribs, "", true);
	$spellcheck = we_getTagAttribute('spellcheck', $attribs, 'true');
	
	$autobr = $GLOBALS["we_doc"]->getElement($name, "autobr");
	if (strlen($autobr) == 0) {
		$autobr = $autobrAttr ? "on" : "off";
	}
	$showAutobr = isset($attribs["autobr"]);
	if (!$showAutobr && $we_editmode) {
		$autobr = "off";
		$GLOBALS["we_doc"]->elements[$name]["autobr"] = "off";
		$GLOBALS["we_doc"]->saveInSession($_SESSION["we_data"][$we_transaction]);
	}
	
	$autobrName = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . '#autobr]';
	$fieldname = 'we_' . $GLOBALS["we_doc"]->Name . '_txt[' . $name . ']';
	$value = $GLOBALS["we_doc"]->getElement($name) ? $GLOBALS["we_doc"]->getElement($name) : $content;
	
	if ($we_editmode && (!$GLOBALS["we_doc"]->getElement($name)) && $value) { // when not inlineedit, we need to save the content in the object, if the field is empty
		$GLOBALS["we_doc"]->setElement($name, $value);
		$GLOBALS["we_doc"]->saveInSession($_SESSION["we_data"][$we_transaction]);
	}
	if ($we_editmode) {
		return we_forms::weTextarea(
				$fieldname, 
				$value, 
				$attribs, 
				$autobr, 
				$autobrName, 
				$showAutobr, 
				$GLOBALS["we_doc"]->getHttpPath(), 
				false, 
				false, 
				getXmlAttributeValueAsBoolean($xml), 
				$removeFirstParagraph, 
				'', 
				($spellcheck == 'true'));
	} else {
		$ret = $GLOBALS["we_doc"]->getField($attribs);
		return $ret;
	}
}

function we_tag_title($attribs, $content)
{
	global $TITLE;
	$htmlspecialchars = we_getTagAttribute("htmlspecialchars", $attribs, "", true);
	$attribs = removeAttribs($attribs, array(
		'htmlspecialchars'
	));
	if ($GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PROPERTIES && $GLOBALS["we_doc"]->InWebEdition) { //	normally meta tags are edited on property page
		

		return '<?php	$GLOBALS["meta"]["Title"]["default"] = "' . str_replace('"', '\"', $content) . '"; ?>';
	} else {
		
		$title = $TITLE ? $TITLE : $content;
		return getHtmlTag(
				"title", 
				$attribs, 
				$htmlspecialchars ? htmlspecialchars(strip_tags($title)) : strip_tags($title), 
				true) . "\n";
	}
}

function we_tag_pagelogger($attribs, $content)
{
	return we_tag_tracker($attribs, $content);
}

function we_tag_tracker($attribs, $content)
{
	if ($GLOBALS["we_doc"]->InWebEdition) {
		return "";
	}
	$type = we_getTagAttribute("type", $attribs, "standard");
	$ssl = we_getTagAttribute("ssl", $attribs, "", true);
	$websitename = we_getTagAttribute("websitename", $attribs, $_SERVER['SERVER_NAME']);
	$trackname = we_getTagAttribute("trackname", $attribs);
	
	if ($trackname == "WE_PATH") {
		if (isset($_REQUEST['we_objectID'])) {
			$trackname = "/object" . id_to_path($_REQUEST['we_objectID'], OBJECT_FILES_TABLE);
		} else {
			$trackname = $GLOBALS["WE_MAIN_DOC"]->Path;
		}
	} else 
		if ($trackname == "WE_TITLE") {
			$trackname = $GLOBALS["WE_MAIN_DOC"]->getElement("Title");
		}
	
	if (!defined("WE_TRACKER_DIR")) {
		define("WE_TRACKER_DIR", "/pageLogger");
	}
	
	$trackerurl = ($ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . WE_TRACKER_DIR;
	
	if ($type == 'standard') {
		return '<!-- pageLogger Code BEGIN -->
<script type="text/javascript" src="' . $trackerurl . '/scripts/picmodejs.js"></script>
<script type="text/javascript">
<!--
_my_stat_write(\'' . $websitename . '\',\'' . $trackerurl . '\'' . ($trackname ? (",'" . addslashes(
				$trackname) . "'") : "") . ');
//-->
</script>
<noscript>
<img width="1" height="1"  alt="" src="' . $trackerurl . '/connector.php?' . $websitename . '&amp;mode=NOSCRIPT' . ($trackname ? ("&amp;trackname=" . rawurlencode(
				$trackname)) : "") . '" />
</noscript>
<!-- pageLogger Code END -->
';
	} else 
		if ($type == 'robot') {
			include ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/spidertracker.php");
			@logspider($websitename);
		} else 
			if ($type == 'fileserver') {
				@include_once ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/service/fileserver.php");
			} else 
				if ($type == 'downloads') {
					@include_once ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/includes/showcat.inc.php");
					$category = we_getTagAttribute("category", $attribs);
					$order = we_getTagAttribute("order", $attribs, "FILETITLE");
					$desc = we_getTagAttribute("desc", $attribs, "", true, true);
					$rows = we_getTagAttribute("rows", $attribs, "10");
					showcat($category, $order, $desc ? "DESC" : "ASC", $rows, $websitename);
				}
}

function we_tag_url($attribs, $content)
{
	$foo = attributFehltError($attribs, "id", "url");
	if ($foo)
		return $foo;
	static $urls = array();
	$id = we_getTagAttribute("id", $attribs);
	if (isset($urls[$id])) { // do only work you have never done before
		return $urls[$id];
	}
	if ($id == 0) {
		$url = "/";
	} else {
		$row = getHash("SELECT Path,IsFolder,IsDynamic FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", new DB_WE());
		$url = isset($row["Path"]) ? ($row["Path"] . ($row["IsFolder"] ? "/" : "")) : "";
	}
	$urls[$id] = $url;
	return $url;

}

function we_tag_userInput($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "userInput");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	$property = we_getTagAttribute("property", $attribs, "", true);
	$format = we_getTagAttribute("format", $attribs);
	$checked = we_getTagAttribute("checked", $attribs, "", true);
	$value = we_getTagAttribute("value", $attribs);
	$editable = we_getTagAttribute("editable", $attribs, "", true, true);
	$autobrAttr = we_getTagAttribute("autobr", $attribs, "", true, true);
	$hidden = we_getTagAttribute("hidden", $attribs, "", true);
	$size = we_getTagAttribute("size", $attribs);
	$values = we_getTagAttribute("values", $attribs);
	$xml = we_getTagAttribute("xml", $attribs, "");
	$removeFirstParagraph = we_getTagAttribute("removefirstparagraph", $attribs, 0, true, true);
	
	if ($hidden && ($type != "date")) {
		$type = "hidden";
	}
	
	$fieldname = $property ? ("we_ui_" . (isset($GLOBALS["WE_FORM"]) ? $GLOBALS["WE_FORM"] : "") . "_" . $name) : ("we_ui_" . (isset(
			$GLOBALS["WE_FORM"]) ? $GLOBALS["WE_FORM"] : "") . "[" . $name . "]");
	
	$objekt = (isset($GLOBALS["WE_FORM"]) ? (isset($GLOBALS["we_object"][$GLOBALS["WE_FORM"]]) ? $GLOBALS["we_object"][$GLOBALS["WE_FORM"]] : (isset(
			$GLOBALS["we_document"][$GLOBALS["WE_FORM"]]) ? $GLOBALS["we_document"][$GLOBALS["WE_FORM"]] : (isset(
			$GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : false))) : 

	"");
	
	if ($objekt) {
		if ($property) {
			eval('$isset = isset($objekt->' . $name . ');');
			eval('$orgVal = $isset ? $objekt->' . $name . ' : $value;');
		} else {
			if (!$objekt->ID && $objekt->getElement($name) === "") {
				$isset = false;
			} else {
				$isset = $objekt->issetElement($name);
			}
			$orgVal = $isset ? $objekt->getElement($name) : $value;
		}
		$object_pid = $objekt->ParentID;
		$object_path = $objekt->Path;
		$object_tableID = isset($objekt->TableID) ? $objekt->TableID : "";
	} else {
		$orgVal = $value;
		$object_pid = 0;
		$object_path = "";
		$object_tableID = "";
		$isset = false;
	}
	
	$content = "";
	
	$content = we_document::getFieldByVal(
			$orgVal, 
			$type, 
			$attribs, 
			true, 
			$object_pid, 
			$object_path, 
			$GLOBALS["DB_WE"], 
			$object_tableID);
	
	if ($type == "date") {
		if ($orgVal == 0) {
			$orgVal = time();
		}
	}
	if (!$editable && $type !== "img") {
		$_hidden = getHtmlTag(
				'input', 
				array(
					
				'type' => 'hidden', 'name' => $fieldname, 'value' => htmlspecialchars($orgVal), 'xml' => $xml
				));
		return (($type != "hidden") ? $content : "") . $_hidden;
	} else {
		switch ($type) {
			case "img" :
				
				$_imgDataId = isset($_REQUEST['WE_UI_IMG_DATA_ID_' . $name]) ? $_REQUEST['WE_UI_IMG_DATA_ID_' . $name] : md5(
						uniqid(rand()));
				
				$we_button = new we_button();
				
				if ($editable) {
					
					include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/parser.inc.php");
					
					$foo = attributFehltError($attribs, "parentid", "userInput");
					if ($foo)
						return $foo;
					
					if (!isset($_SESSION[$_imgDataId])) {
						$_SESSION[$_imgDataId] = array();
					}
					$_SESSION[$_imgDataId]["parentid"] = we_getTagAttribute("parentid", $attribs, "0");
					//$_SESSION[$_imgDataId]["maxfilesize"] = we_getTagAttribute("maxfilesize",$attribs);
					$_SESSION[$_imgDataId]["width"] = we_getTagAttribute(
							"width", 
							$attribs, 
							0);
					$_SESSION[$_imgDataId]["height"] = we_getTagAttribute("height", $attribs, 0);
					$_SESSION[$_imgDataId]["quality"] = we_getTagAttribute("quality", $attribs, "8");
					$_SESSION[$_imgDataId]["keepratio"] = we_getTagAttribute("keepratio", $attribs, "", true, true);
					$_SESSION[$_imgDataId]["maximize"] = we_getTagAttribute("maximize", $attribs, "", true);
					$_SESSION[$_imgDataId]["id"] = $orgVal ? $orgVal : '';
					
					$bordercolor = we_getTagAttribute("bordercolor", $attribs, "#006DB8");
					$checkboxstyle = we_getTagAttribute("checkboxstyle", $attribs);
					$inputstyle = we_getTagAttribute("inputstyle", $attribs);
					$checkboxclass = we_getTagAttribute("checkboxclass", $attribs);
					$inputclass = we_getTagAttribute("inputclass", $attribs);
					$checkboxtext = we_getTagAttribute("checkboxtext", $attribs, $GLOBALS["l_parser"]["delete"]);
					
					if ($_SESSION[$_imgDataId]["id"]) {
						$attribs["id"] = $_SESSION[$_imgDataId]["id"];
					}
					
					if (isset($_SESSION[$_imgDataId]["serverPath"])) {
						$src = substr($_SESSION[$_imgDataId]["serverPath"], strlen($_SERVER['DOCUMENT_ROOT']));
						if (substr($src, 0, 1) !== "/") {
							$src = "/" . $src;
						}
						
						$imgTag = '<img src="' . $src . '" alt="" width="' . $_SESSION[$_imgDataId]["imgwidth"] . '" height="' . $_SESSION[$_imgDataId]["imgheight"] . '" />';
					} else {
						unset($attribs["width"]);
						unset($attribs["height"]);
						$imgTag = $GLOBALS["we_doc"]->getField($attribs, "img");
					}
					
					if (isset($_SESSION[$_imgDataId]["doDelete"]) && $_SESSION[$_imgDataId]["doDelete"]) {
						$checked = ' checked';
					} else {
						$checked = '';
					}
					
					return '<table border="0" cellpadding="2" cellspacing="2" style="border: solid ' . $bordercolor . ' 1px;">
						<tr>
							<td class="weEditmodeStyle" colspan="2" align="center">' . $imgTag . '
								<input type="hidden" name="WE_UI_IMG_DATA_ID_' . $name . '" value="' . $_imgDataId . '" /></td>
						</tr>
						<tr>
							<td class="weEditmodeStyle" colspan="2" align="left">
								<input' . ($size ? ' size="' . $size . '"' : '') . ' name="' . $fieldname . '" type="file" accept="' . IMAGE_CONTENT_TYPES . '"' . ($inputstyle ? (' style="' . $inputstyle . '"') : '') . ($inputclass ? (' class="' . $inputclass . '"') : '') . '/>
							</td>
						</tr>
						<tr>
							<td class="weEditmodeStyle" colspan="2" align="left">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding-right: 5px;">
											<input style="border:0px solid black;" type="checkbox" id="WE_UI_DEL_CHECKBOX_' . $name . '" name="WE_UI_DEL_CHECKBOX_' . $name . '" value="1" ' . $checked . '/>
										</td>
										<td>
											<label for="WE_UI_DEL_CHECKBOX_' . $name . '"' . ($checkboxstyle ? (' style="' . $checkboxstyle . '"') : '') . ($checkboxclass ? (' class="' . $checkboxclass . '"') : '') . '>' . $checkboxtext . '</label>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';
				} else {
					$hidden = '<input type="hidden" name="WE_UI_IMG_DATA_ID_' . $name . '" value="' . $_imgDataId . '" />';
					
					if (isset($_SESSION[$_imgDataId]["serverPath"])) {
						$src = substr($_SESSION[$_imgDataId]["serverPath"], strlen($_SERVER['DOCUMENT_ROOT']));
						if (substr($src, 0, 1) !== "/") {
							$src = "/" . $src;
						}
						
						return '<img src="' . $src . '" alt="" width="' . $_SESSION[$_imgDataId]["imgwidth"] . '" height="' . $_SESSION[$_imgDataId]["imgheight"] . '" />' . $hidden;
					} else 
						if (isset($_SESSION[$_imgDataId]["id"]) && $_SESSION[$_imgDataId]["id"]) {
							
							if (isset($_SESSION[$_imgDataId]["doDelete"]) && $_SESSION[$_imgDataId]["doDelete"]) {
								return $hidden;
							}
							
							unset($attribs["width"]);
							unset($attribs["height"]);
							$attribs["id"] = $_SESSION[$_imgDataId]["id"];
							return $GLOBALS["we_doc"]->getField($attribs, "img") . $hidden;
						
						} else {
							return '';
						}
				}
			
			case "textarea" :
				$attribs['inlineedit'] = "true"; // bugfix: 7276
				$pure = we_getTagAttribute("pure", $attribs, "", true);
				if ($pure) {
					$atts = removeAttribs(
							$attribs, 
							array(
								
									'wysiwyg', 
									'commands', 
									'pure', 
									'type', 
									'value', 
									'checked', 
									'autobr', 
									'name', 
									'values', 
									'hidden', 
									'editable', 
									'format', 
									'property', 
									'size', 
									'maxlength', 
									'width', 
									'height', 
									'fontnames', 
									'bgcolor'
							));
					return we_getTextareaField($fieldname, $content, $atts);
				} else {
					include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
					include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/js/we_textarea_include.inc.php");
					$autobr = $autobrAttr ? "on" : "off";
					$showAutobr = isset($attribs["autobr"]);
					$charset = we_getTagAttribute("charset", $attribs, "iso-8859-1");
					return we_forms::weTextarea(
							$fieldname, 
							$content, 
							$attribs, 
							$autobr, 
							"autobr", 
							$showAutobr, 
							$GLOBALS["we_doc"]->getHttpPath(), 
							false, 
							false, 
							getXmlAttributeValueAsBoolean($xml), 
							$removeFirstParagraph, 
							$charset, 
							false, 
							true);
				}
			case "checkbox" :
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'cols', 
								'rows', 
								'width', 
								'height', 
								'bgcolor', 
								'fontnames'
						));
				if ((!$isset) && $checked) {
					$content = 1;
				}
				return we_getInputCheckboxField($fieldname, $content, $atts);
			case "date" :
				$currentdate = we_getTagAttribute("currentdate", $attribs, "", true);
				if ($currentdate) {
					$orgVal = time();
				}
				if ($hidden) {
					
					$attsHidden['type'] = 'hidden';
					$attsHidden['name'] = $fieldname;
					$attsHidden['value'] = $orgVal ? $orgVal : time();
					$attsHidden['xml'] = $xml;
					return getHtmlTag('input', $attsHidden);
				} else {
					return getDateInput2(
							"we_ui_" . (isset($GLOBALS["WE_FORM"]) ? $GLOBALS["WE_FORM"] : "") . "[we_date_" . $name . "]", 
							($orgVal ? $orgVal : time()), 
							false, 
							$format, 
							'', 
							'', 
							$xml);
				}
				break;
			case "select" :
				$options = '';
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'rows', 
								'cols', 
								'fontnames', 
								'bgcolor', 
								'width', 
								'height', 
								'maxlength'
						));
				if ($values) {
					
					$values = explode(',', $values);
					
					foreach ($values as $txt) {
						
						if ($txt == $orgVal) {
							$attsOption = array(
								'selected' => 'selected'
							);
						} else {
							$attsOption = array();
						}
						$options .= getHtmlTag('option', $attsOption, trim($txt), true) . "\n";
					}
				} else 
					if ($objekt && isset($objekt->DefArray["meta_" . $name])) {
						foreach ($objekt->DefArray["meta_" . $name]["meta"] as $key => $val) {
							
							if ($orgVal == $key) {
								$atts2 = array(
									'value' => $key, 'selected' => 'selected'
								);
							} else {
								$atts2 = array(
									'value' => $key
								);
							}
							$attsOption = array_merge($atts, $atts2);
							$attsOption = removeAttribs($attsOption, array(
								'class'
							));
							$options .= getHtmlTag('option', $attsOption, $val, true) . "\n";
						}
					}
				$atts['size'] = (isset($atts['size']) ? $atts['size'] : 1);
				$atts['name'] = $fieldname;
				return getHtmlTag('select', $atts, $options, true) . "\n";
				break;
			case "radio" :
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'rows', 
								'cols', 
								'width', 
								'height', 
								'bgcolor', 
								'fontnames'
						));
				if (!$isset) {
					return we_getInputRadioField($fieldname, ($checked ? $value : $value . "dummy"), $value, $atts);
				} else {
					return we_getInputRadioField($fieldname, $content, $orgVal, $atts);
				}
			case "hidden" :
				$attsHidden['type'] = 'hidden';
				$attsHidden['name'] = $fieldname;
				$attsHidden['value'] = htmlspecialchars($content);
				$attsHidden['xml'] = $xml;
				return getHtmlTag('input', $attsHidden);
			case "choice" :
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'cols', 
								'rows', 
								'width', 
								'height', 
								'bgcolor', 
								'fontnames', 
								'maxlength'
						));
				$mode = we_getTagAttribute("mode", $attribs);
				return we_getInputChoiceField($fieldname, $orgVal, $values, $atts, $mode);
				break;
			case "password" :
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'cols', 
								'rows', 
								'width', 
								'height', 
								'bgcolor', 
								'fontnames'
						));
				return we_getInputPasswordField($fieldname, $orgVal, $atts);
				break;
			case "textinput" :
			default :
				$atts = removeAttribs(
						$attribs, 
						array(
							
								'wysiwyg', 
								'commands', 
								'pure', 
								'type', 
								'value', 
								'checked', 
								'autobr', 
								'name', 
								'values', 
								'hidden', 
								'editable', 
								'format', 
								'property', 
								'cols', 
								'rows', 
								'width', 
								'height', 
								'bgcolor', 
								'fontnames'
						));
				return we_getInputTextInputField($fieldname, $orgVal, $atts);
		}
	}
}

function we_tag_var($attribs, $content)
{
	$foo = attributFehltError($attribs, "name", "var");
	if ($foo)
		return $foo;
	$docAttr = we_getTagAttribute("doc", $attribs);
	$name = we_getTagAttribute("name", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	
	$doc = we_getDocForTag($docAttr, false);
	
	switch ($type) {
		case "session" :
			return $_SESSION[$name];
		case "request" :
			return removePHP(isset($_REQUEST[$name]) ? $_REQUEST[$name] : "");
		case "global" :
			if (isset($GLOBALS[$name])) {
				return $GLOBALS[$name];
			} else {
				return "";
			}
		case 'multiobject' :
			$data = unserialize($doc->getField($attribs, $type, true));
			if (isset($data['objects']) && sizeof($data['objects']) > 0) {
				$out = implode(",", $data['objects']);
			} else {
				$out = "";
			}
			return $out;
		
		case "property" :
			if (isset($GLOBALS["we_obj"])) {
				eval('$var = $GLOBALS["we_obj"]->' . $name . ';');
			} else {
				eval('$var = $doc->' . $name . ';');
			}
			return $var;
		case 'shopVat' :
			if (defined('SHOP_TABLE')) {
				
				require_once (WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
				$vatId = $GLOBALS['we_doc']->getElement(WE_SHOP_VAT_FIELD_NAME);
				return weShopVats::getVatRateForSite($vatId);
			}
		
		default :
			$normVal = $doc->getField($attribs, $type, true);
			// bugfix 7557
			// wenn die Abfrage im Aktuellen Objekt kein Erg�bnis liefert
			// wird in den eingebundenen Objekten �berpr�ft ob das Feld existiert
			if ($type == "select" && $normVal == "") {
				if (isset($doc->DefArray) && is_array($doc->DefArray)) {
					foreach ($doc->DefArray as $_glob_key => $_val) {
						
						if (substr($_glob_key, 0, 7) == "object_") {
							
							$normVal = we_document::getFieldByVal(
									$doc->getElement($name), 
									$type, 
									$attribs, 
									false, 
									$GLOBALS["we_doc"]->ParentID, 
									$GLOBALS["we_doc"]->Path, 
									$GLOBALS["DB_WE"], 
									substr($_glob_key, 7));
						}
						
						if ($normVal != "")
							break;
					}
				} else {
					
					if (isset($doc->elements) && is_array($doc->elements)) {
						foreach ($doc->elements as $_glob_key => $_val) {
							
							if (substr($_glob_key, 0, 10) == "we_object_") {
								$normVal = we_document::getFieldByVal(
										$doc->getElement($name), 
										$type, 
										$attribs, 
										false, 
										$GLOBALS["we_doc"]->ParentID, 
										$GLOBALS["we_doc"]->Path, 
										$GLOBALS["DB_WE"], 
										substr($_glob_key, 10));
							}
							if ($normVal != "")
								break;
						}
					}
				}
			}
			// EOF bugfix 7557
			

			return $normVal;
			break;
	}
	return $var;

}

function we_tag_write($attribs, $content)
{
	$type = we_getTagAttribute("type", $attribs, "document");
	
	if ($type == "object") {
		$foo = attributFehltError($attribs, "classid", "write");
		if ($foo)
			return $foo;
	} else {
		$foo = attributFehltError($attribs, "doctype", "write");
		if ($foo)
			return $foo;
	}
	
	$name = we_getTagAttribute(
			"formname", 
			$attribs, 
			((isset($GLOBALS["WE_FORM"]) && $GLOBALS["WE_FORM"]) ? $GLOBALS["WE_FORM"] : "we_global_form"));
	
	$publish = we_getTagAttribute("publish", $attribs, "", true);
	$triggerid = we_getTagAttribute("triggerid", $attribs, 0);
	$charset = we_getTagAttribute("charset", $attribs, "iso-8859-1");
	$doctype = we_getTagAttribute("doctype", $attribs);
	$tid = we_getTagAttribute("tid", $attribs);
	$categories = we_getTagAttribute("categories", $attribs);
	$classid = we_getTagAttribute("classid", $attribs);
	$parentid = we_getTagAttribute("parentid", $attribs);
	$userid = we_getTagAttribute("userid", $attribs); // deprecated  use protected=true instead
	$protected = we_getTagAttribute("protected", $attribs, "", true);
	$admin = we_getTagAttribute("admin", $attribs);
	$mail = we_getTagAttribute("mail", $attribs);
	$mailfrom = we_getTagAttribute("mailfrom", $attribs);
	$forceedit = we_getTagAttribute("forceedit", $attribs, "", true);
	$workspaces = we_getTagAttribute("workspaces", $attribs);
	
	if (isset($_REQUEST["edit_$type"]) && $_REQUEST["edit_$type"]) {
		
		if ($type == "document") {
			$ok = initDocument($name, $tid, $doctype, $categories);
		} else {
			$ok = initObject($classid, $name, $categories, $parentid);
		}
		
		if ($ok) {
			$isOwner = false;
			if ($protected && isset($_SESSION["webuser"]["ID"])) {
				$isOwner = ($_SESSION["webuser"]["ID"] == $GLOBALS["we_$type"][$name]->WebUserID);
			} else 
				if ($userid) {
					$isOwner = ($_SESSION["webuser"]["ID"] == $GLOBALS["we_$type"][$name]->getElement($userid));
				}
			$isAdmin = false;
			if ($admin) {
				$isAdmin = isset($_SESSION["webuser"][$admin]) && $_SESSION["webuser"][$admin];
			}
			
			if ($isAdmin || ($GLOBALS["we_$type"][$name]->ID == 0) || $isOwner || $forceedit) {
				
				$GLOBALS["we_" . $type . "_write_ok"] = true;
				$newObject = ($GLOBALS["we_$type"][$name]->ID) ? false : true;
				if ($protected) {
					if (!isset($_SESSION["webuser"]["ID"]))
						return;
					if (!$GLOBALS["we_$type"][$name]->WebUserID) {
						$GLOBALS["we_$type"][$name]->WebUserID = $_SESSION["webuser"]["ID"];
					}
				} else 
					if ($userid) {
						if (!isset($_SESSION["webuser"]["ID"]))
							return;
						if (!$GLOBALS["we_$type"][$name]->getElement($userid)) {
							$GLOBALS["we_$type"][$name]->setElement($userid, $_SESSION["webuser"]["ID"]);
						}
					}
				
				checkAndCreateImage($name, ($type == "document") ? "we_document" : "we_object");
				
				$GLOBALS["we_$type"][$name]->i_checkPathDiffAndCreate();
				$GLOBALS["we_$type"][$name]->i_correctDoublePath();
				$_WE_DOC_SAVE = $GLOBALS["we_doc"];
				$GLOBALS["we_doc"] = &$GLOBALS["we_$type"][$name];
				if (strlen($workspaces) > 0 && $type == "object") {
					$wsArr = makeArrayFromCSV($workspaces);
					$tmplArray = array();
					foreach ($wsArr as $wsId) {
						array_push($tmplArray, $GLOBALS["we_$type"][$name]->getTemplateFromWs($wsId));
					}
					$GLOBALS["we_$type"][$name]->Workspaces = makeCSVFromArray($wsArr, true);
					$GLOBALS["we_$type"][$name]->Templates = makeCSVFromArray($tmplArray, true);
				}
				
				$GLOBALS["we_$type"][$name]->Path = $GLOBALS["we_$type"][$name]->getPath();
				if (defined("OBJECT_FILES_TABLE") && $type == "object" && $GLOBALS["we_$type"][$name]->Text == "") {
					$GLOBALS["we_$type"][$name]->Text = 1 + abs(
							f("SELECT max(ID) as ID FROM " . OBJECT_FILES_TABLE, "ID", new DB_WE()));
				}
				$GLOBALS["we_$type"][$name]->we_save();
				if ($publish) {
					if ($type == "document" && (!$GLOBALS["we_$type"][$name]->IsDynamic) && isset(
							$GLOBALS["we_doc"])) { // on static HTML Documents we have to do it different
						$GLOBALS["we_doc"]->we_publish();
					} else {
						$GLOBALS["we_$type"][$name]->we_publish();
					}
				}
				unset($GLOBALS["we_doc"]);
				$GLOBALS["we_doc"] = $_WE_DOC_SAVE;
				unset($_WE_DOC_SAVE);
				$_REQUEST["we_returnpage"] = $GLOBALS["we_$type"][$name]->getElement("we_returnpage");
				
				if ($mail) {
					if (!$mailfrom) {
						$mailfrom = "dontReply@" . $GLOBALS["SERVER_NAME"];
					}
					$path = $GLOBALS["we_$type"][$name]->Path;
					if ($type == "object") {
						$classname = f(
								"SELECT Text FROM " . OBJECT_TABLE . " WHERE ID='" . abs($classid) . "'", 
								"Text", 
								$GLOBALS["DB_WE"]);
						if ($triggerid) {
							$port = (defined("HTTP_PORT")) ? (":" . HTTP_PORT) : "";
							$mailtext = sprintf($GLOBALS["l_global"]["std_mailtext_newObj"], $path, $classname) . "\n" . "http://" . $GLOBALS["SERVER_NAME"] . $port . id_to_path(
									$triggerid) . "?we_objectID=" . $GLOBALS["we_object"][$name]->ID;
						} else {
							$mailtext = sprintf($GLOBALS["l_global"]["std_mailtext_newObj"], $path, $classname) . "\n" . "ObjectID: " . $GLOBALS["we_object"][$name]->ID;
						}
						$subject = $GLOBALS["l_global"]["std_subject_newObj"];
					} else {
						$mailtext = sprintf($GLOBALS["l_global"]["std_mailtext_newDoc"], $path) . "\n" . $GLOBALS["we_$type"][$name]->getHttpPath();
						$subject = $GLOBALS["l_global"]["std_subject_newDoc"];
					}
					$phpmail = new we_util_Mailer($mail, $subject, $mailfrom);
					$phpmail->setCharSet($charset);
					$phpmail->addTextPart($mailtext);
					$phpmail->buildMessage();
					$phpmail->Send();
				}
			} else {
				$GLOBALS["we_object_write_ok"] = false;
			}
		}
	}
	if (isset($GLOBALS["WE_SESSION_START"]) && $GLOBALS["WE_SESSION_START"]) {
		
		unset($_SESSION['we_' . $type . '_session_' . $name]);
		$GLOBALS['we_' . $type . '_session_' . $name] = array();
	}
}

/**
 * @return string
 * @param array $attribs
 * @param string $content
 * @desc Beschreibung eingeben...
 */
function we_tag_checkForm($attribs, $content)
{
	
	//  dont make this in editMode
	if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) {
		return "";
	}
	
	//  check required Fields
	$missingAttrib = attributFehltError($attribs, "match", "we_tag_checkForm");
	if ($missingAttrib) {
		print $missingAttrib;
		return "";
	}
	
	$missingAttrib = attributFehltError($attribs, "type", "we_tag_checkForm");
	if ($missingAttrib) {
		print $missingAttrib;
		return "";
	}
	
	// get fields of $attribs
	$match = we_getTagAttribute("match", $attribs);
	$type = we_getTagAttribute("type", $attribs);
	
	$mandatory = we_getTagAttribute("mandatory", $attribs);
	$email = we_getTagAttribute("email", $attribs);
	$password = we_getTagAttribute("password", $attribs);
	
	$onError = we_getTagAttribute("onError", $attribs);
	$jsIncludePath = we_getTagAttribute("jsIncludePath", $attribs);
	
	$xml = we_getTagAttribute("xml", $attribs, "");
	
	//  then lets parse the content
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	$tp->parseTags($tags, $content);
	
	//  Generate errorHandler:
	if ($onError) {
		$jsOnError = '
            if(self.' . $onError . '){
                ' . $onError . '(formular,missingReq,wrongEmail,pwError);
            } else {
            	' . we_message_reporting::getShowMessageCall(
				$content, 
				WE_MESSAGE_FRONTEND) . '
            }
        ';
	} else {
		$jsOnError = we_message_reporting::getShowMessageCall($content, WE_MESSAGE_FRONTEND);
	}
	
	//  Generate mandatory array
	if ($mandatory) {
		$_fields = explode(',', $mandatory);
		$jsMandatory = '//  check mandatory
        var required = new Array("' . implode('", "', $_fields) . '");
        missingReq = weCheckFormMandatory(formular, required);';
	} else {
		$jsMandatory = '';
	}
	
	if ($email) { //  code to check Emails
		$_emails = explode(',', $email);
		$jsEmail = '//  validate emails
        var email = new Array("' . implode('", "', $_emails) . '");
        wrongEmail = weCheckFormEmail(formular, email);';
	} else {
		$jsEmail = '';
	}
	
	if ($password) {
		$_pwFields = explode(',', $password);
		if (sizeof($_pwFields) != 3) {
			$jsPasword = '';
			return parseError($GLOBALS["l_parser"]["checkForm_password"]);
		}
		$jsPasword = '//  check passwords
        var password = new Array("' . implode('", "', $_pwFields) . '");
        pwError = weCheckFormPassword(formular, password);
        ';
	} else {
		$jsPasword = '';
	}
	
	//  deal with alwasy needed stuff - "class weCheckFormEvent"
	if ($jsIncludePath) {
		
		if (is_numeric($jsIncludePath)) {
			$jsTag = we_tag_js(array(
				'id' => $jsIncludePath, 'xml' => $xml
			));
			if ($jsTag) {
				$jsEventHandler = $jsTag;
			} else {
				$jsEventHandler = '';
				return parseError($GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"]);
			}
		
		} else {
			$jsEventHandler = '
    <script type="text/javascript" src="' . $jsIncludePath . '"></script>
            ';
		}
	
	} else {
		$jsEventHandler = '
    <script type="text/javascript" src="' . JS_DIR . '/external/weCheckForm.js"></script>
    ';
	}
	
	switch ($type) {
		
		case "id" : //  id of formular is given
			

			$initFunction = '
    weCheckFormEvent.addEvent( window, "load", function(){
        initWeCheckForm_by_id("' . $match . '");
        }
    );
            ';
			$checkFunction = '
    function weCheckForm_id_' . $match . '(ev){

        var missingReq = new Array(0);
        var wrongEmail = new Array(0);
        var pwError    = false;

        formular = document.getElementById("' . $match . '");

        ' . $jsMandatory . '

        ' . $jsEmail . '

        ' . $jsPasword . '

        //  return true or false depending on errors
        if( (wrongEmail.length>0) || (missingReq.length>0) || pwError){

            ' . $jsOnError . '
            weCheckFormEvent.stopEvent(ev);
            return false;
        } else {
            return true;
        }
    }
            ';
			
			$function = '
    <script type="text/javascript">
    <!--
    ' . $initFunction . '
    ' . $checkFunction . '
    //-->
    </script>';
			break;
		
		case "name" : //  name of formular is given
			

			$initFunction = '
    weCheckFormEvent.addEvent( window, "load", function(){
        initWeCheckForm_by_name("' . $match . '");
        }
    );
            ';
			$checkFunction = '
    function weCheckForm_n_' . $match . '(ev){


        var missingReq = new Array(0);
        var wrongEmail = new Array(0);
        var pwError    = false;

        formular = document.forms["' . $match . '"];

        ' . $jsMandatory . '

        ' . $jsEmail . '

        ' . $jsPasword . '

        //  return true or false depending on errors
        if( wrongEmail.length || missingReq.length || pwError){

            ' . $jsOnError . '
            weCheckFormEvent.stopEvent(ev);
            return false;
        } else {
            return true;
        }
    }
            ';
			
			$function = '
    <script type="text/javascript">
    <!--
    ' . $initFunction . '
    ' . $checkFunction . '
    //-->
    </script>';
			break;
	}
	
	return "
            $jsEventHandler
            $function
           ";
}

/**
 * @return string
 * @param array $attribs
 * @param string $content
 * @desc Beschreibung eingeben...
 */
function we_tag_xmlfeed($attribs, $content)
{
	
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/weFile.class.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_exim/weXMLBrowser.class.php");
	
	$foo = attributFehltError($attribs, "name", "xmlfeed");
	if ($foo)
		return $foo;
	$foo = attributFehltError($attribs, "url", "xmlfeed");
	if ($foo)
		return $foo;
	
	$name = we_getTagAttribute("name", $attribs);
	$url = we_getTagAttribute("url", $attribs);
	
	if (isset($attribs["refresh"]) && is_numeric($attribs["refresh"]))
		$refresh = $attribs["refresh"] * 60;
	else
		$refresh = 0;
	
	if (!isset($GLOBALS["xmlfeeds"]))
		$GLOBALS["xmlfeeds"] = array();
	
	$GLOBALS["xmlfeeds"][$name] = new weXMLBrowser();
	$cache = $_SERVER["DOCUMENT_ROOT"] . WEBEDITION_DIR . "xmlfeeds/" . $name;
	
	$do_refresh = true;
	
	if (is_file($cache) && $refresh > 0) {
		$now = time();
		$stat = stat($cache);
		$exp = $stat["mtime"] + $refresh;
		$do_refresh = ($exp < $now);
	}
	
	if (!is_file($cache) || $do_refresh) {
		$GLOBALS["xmlfeeds"][$name]->getFile($url);
		$GLOBALS["xmlfeeds"][$name]->saveCache($cache, $refresh);
	} else {
		$GLOBALS["xmlfeeds"][$name]->loadCache($cache);
	}
}

/**
 * @return boolean
 * @param array $attribs
 * @param string $content
 * @desc returns true if calendar date is same with current date
 */
function we_tag_ifCurrentDate($attribs, $content)
{
	if (isset($GLOBALS["lv"]->calendar_struct)) {
		switch ($GLOBALS["lv"]->calendar_struct["calendar"]) {
			case "day" :
				return (date("d-m-Y H", $GLOBALS["lv"]->calendar_struct["date"]) == date("d-m-Y H"));
				break;
			case "month" :
			case "month_table" :
				return (date("d-m-Y", $GLOBALS["lv"]->calendar_struct["date"]) == date("d-m-Y"));
				break;
			case "year" :
				return (date("m-Y", $GLOBALS["lv"]->calendar_struct["date"]) == date("m-Y"));
				break;
		}
	}
	return false;
}

/**
 * @return boolean
 * @param array $attribs
 * @param string $content
 * @desc returns true if voting was successful
 */
function we_tag_ifVote($attribs, $content)
{
	
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/voting/weVoting.php');
	return (isset($GLOBALS["_we_voting_status"]) && $GLOBALS["_we_voting_status"] == VOTING_SUCCESS);
}

/**
 * @return boolean
 * @param array $attribs
 * @param string $content
 * @desc returns true if voting was unsuccessful
 */
function we_tag_ifNotVote($attribs, $content)
{
	
	$foo = attributFehltError($attribs, "type", "ifNotVote");
	if ($foo)
		return $foo;
	$type = we_getTagAttribute("type", $attribs, "error");
	
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/voting/weVoting.php');
	
	if (isset($GLOBALS["_we_voting_status"])) {
		switch ($type) {
			case "error" :
				return ($GLOBALS["_we_voting_status"] == VOTING_ERROR);
				break;
			case "revote" :
				return ($GLOBALS["_we_voting_status"] == VOTING_ERROR_REVOTE);
				break;
			case "active" :
				return ($GLOBALS["_we_voting_status"] == VOTING_ERROR_ACTIVE);
				break;
			case "forbidden" :
				return ($GLOBALS["_we_voting_status"] == VOTING_ERROR_BLACKIP);
				break;
			default :
				return ($GLOBALS["_we_voting_status"] > 0);
		
		}
	}
	
	return false;
}

/**
 * @return boolean
 * @param array $attribs
 * @param string $content
 * @desc returns true if voting was successful
 */
function we_tag_ifVoteActive($attribs, $content)
{
	$id = we_getTagAttributeTagParser('id', $attribs, 0);
	
	if (isset($GLOBALS['_we_voting']) && $id == 0) {
		return $GLOBALS['_we_voting']->isActive();
	}
	
	if ($id == 0)
		return false;
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/voting/weVoting.php');
	$voting = new weVoting($id);
	return $voting->isActive();
}

// navigation tags
function we_tag_navigation($attribs, $content = '')
{
	
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationItems.class.php');
	
	$parentid = we_getTagAttribute("parentid", $attribs, -1);
	$id = we_getTagAttribute("id", $attribs, 0);
	$name = we_getTagAttribute("navigationname", $attribs, "default");
	
	if (isset($GLOBALS['initNavigationFromSession']) && $GLOBALS['initNavigationFromSession']) {
		
		$GLOBALS['we_navigation'][$name] = new weNavigationItems();
		$GLOBALS['we_navigation'][$name]->initByNavigationObject($parentid == -1 ? true : false);
	
	} else {
		
		$GLOBALS['we_navigation'][$name] = new weNavigationItems();
		
		if (!$GLOBALS['we_navigation'][$name]->initFromCache(($id ? $id : ($parentid != -1 ? $parentid : 0)), false)) {
			
			$GLOBALS['we_navigation'][$name]->initById(
					$id ? $id : ($parentid != -1 ? $parentid : 0), 
					false, 
					$id ? true : ($parentid != -1 ? false : true));
		}
	
	}

}

function we_tag_navigationEntry($attribs, $content = '')
{
	
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationItems.class.php');
	
	$foo = attributFehltError($attribs, 'type', 'navigation');
	if ($foo)
		return $foo;
	
	$navigationName = we_getTagAttribute('navigationname', $attribs, "default");
	$type = we_getTagAttribute('type', $attribs);
	$level = we_getTagAttribute('level', $attribs, 'defaultLevel');
	$current = we_getTagAttribute('current', $attribs, 'defaultCurrent');
	$position = we_getTagAttribute('position', $attribs, 'defaultPosition');
	
	$tp = new we_tagParser();
	$tags = $tp->getAllTags($content);
	
	$tp->parseTags($tags, $content);
	
	$_positions = makeArrayFromCSV($position);
	
	for ($i = 0; $i < sizeof($_positions); $i++) {
		$position = $_positions[$i];
		if ($position == 'first') {
			$position = 1;
		}
		$GLOBALS['we_navigation'][$navigationName]->setTemplate($content, $type, $level, $current, $position);
	}
}

function we_tag_navigationWrite($attribs, $content = '')
{
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationItems.class.php');
	
	$name = we_getTagAttribute("navigationname", $attribs, "default");
	$depth = we_getTagAttribute("depth", $attribs);
	
	if (!$depth) {
		$depth = false;
	}
	
	if (isset($GLOBALS['we_navigation'][$name])) {
		
		$GLOBALS['weNavigationDepth'] = $depth;
		print $GLOBALS['we_navigation'][$name]->writeNavigation($depth);
		unset($GLOBALS['weNavigationDepth']);
	}
}

function we_tag_ifHasEntries($attribs = array(), $content = '')
{
	
	if (isset($GLOBALS['weNavigationItemArray']) && is_array($GLOBALS['weNavigationItemArray'])) {
		
		$element = $GLOBALS['weNavigationItemArray'][(sizeof($GLOBALS['weNavigationItemArray']) - 1)];
		
		if (sizeof($element->items)) {
			return true;
		}
		return false;
	}
}

function we_tag_ifNotHasEntries($attribs = array(), $content = '')
{
	
	return !we_tag_ifHasEntries();
}

function we_tag_ifHasCurrentEntry($attribs = array(), $content = '')
{
	if (isset($GLOBALS['weNavigationItemArray']) && is_array($GLOBALS['weNavigationItemArray'])) {
		
		$element = $GLOBALS['weNavigationItemArray'][(sizeof($GLOBALS['weNavigationItemArray']) - 1)];
		
		if (sizeof($element->items)) {
			foreach ($element->items as $key => $value) {
				if ($value->containsCurrent == 'true') {
					return true;
				}
			}
		}
		return false;
	}
}

function we_tag_ifNotHasCurrentEntry($attribs = array(), $content = '')
{
	
	return !we_tag_ifHasCurrentEntry();
}

function we_tag_navigationField($attribs, $content = '')
{
	
	if (isset($GLOBALS['weNavigationItemArray']) && is_array($GLOBALS['weNavigationItemArray'])) {
		
		$element = $GLOBALS['weNavigationItemArray'][(sizeof($GLOBALS['weNavigationItemArray']) - 1)];
		return $element->getNavigationField($attribs);
	}
}

function we_tag_navigationEntries($attribs, $content = '')
{
	
	if (isset($GLOBALS['weNavigationItemArray']) && is_array($GLOBALS['weNavigationItemArray'])) {
		$element = $GLOBALS['weNavigationItemArray'][(sizeof($GLOBALS['weNavigationItemArray']) - 1)];
		$code = '';
		
		foreach ($element->items as $item) {
			$code .= $item->writeItem($GLOBALS['weNavigationObject'], $GLOBALS['weNavigationDepth']);
		}
		
		return $code;
	}
}

?>