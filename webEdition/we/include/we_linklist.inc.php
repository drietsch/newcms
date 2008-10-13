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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_db.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tagParser.inc.php");
if (!isset($GLOBALS["WE_IS_DYN"])) {
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
}
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_imageDocument.inc.php");

class we_linklist
{

	var $name = "";

	var $sString = "";

	var $listArray;

	var $db;

	var $rollScript = "";

	var $rollAttribs = array();

	var $cache = array();

	function we_linklist($sString)
	{
		
		$this->sString = $sString;
		$this->listArray = $sString ? unserialize($sString) : array();
		if (!is_array($this->listArray)) {
			$this->listArray = array();
		}
		$this->db = new DB_WE();
	}

	function getID($nr)
	{
		return isset($this->listArray[$nr]["id"]) ? $this->listArray[$nr]["id"] : null;
	}

	function getObjID($nr)
	{
		return isset($this->listArray[$nr]["obj_id"]) ? $this->listArray[$nr]["obj_id"] : "";
	}

	function getLink($nr)
	{
		$id = $this->getID($nr);
		$link = "";
		if ($this->getType($nr) == "int") {
			$link = $this->getUrl($nr);
		} else 
			if ($this->getType($nr) == "ext") {
				$link = $this->getHref($nr);
			} else 
				if ($this->getType($nr) == "mail") {
					$link = $this->getHref($nr);
				} else 
					if ($this->getType($nr) == "obj") {
						$link = getHrefForObject(
								$this->getObjID($nr), 
								$GLOBALS["WE_MAIN_DOC"]->ParentID, 
								$GLOBALS["WE_MAIN_DOC"]->Path, 
								$this->db);
						if (isset($GLOBALS["we_link_not_published"])) {
							unset($GLOBALS["we_link_not_published"]);
						}
					}
		return $link;
	}

	function getHref($nr)
	{
		return $this->listArray[$nr]["href"];
	}

	function getAttribs($nr)
	{
		return isset($this->listArray[$nr]["attribs"]) ? $this->listArray[$nr]["attribs"] : "";
	}

	function getTarget($nr)
	{
		return $this->listArray[$nr]["target"];
	}

	function getTitle($nr)
	{
		return isset($this->listArray[$nr]["title"]) ? $this->listArray[$nr]["title"] : "";
	}

	function getLinktag($nr, $link = "", $tagAttr = "")
	{
		if (!$link)
			$link = getLink($nr);
		$target = $this->getTarget($nr);
		$attribs = $this->getAttribs($nr);
		$anchor = $this->getAnchor($nr);
		$accesskey = $this->getAccesskey($nr);
		$tabindex = $this->getTabindex($nr);
		$lang = $this->getLang($nr);
		$hreflang = $this->getHreflang($nr);
		$rel = $this->getRel($nr);
		$rev = $this->getRev($nr);
		$params = $this->getParams($nr);
		$title = $this->getTitle($nr);
		$jswinAttribs = $this->getJsWinAttribs($nr);
		$js = "var we_winOpts = '';";
		
		$lattribs = makeArrayFromAttribs($attribs);
		
		$lattribs['target'] = $target;
		$lattribs['title'] = $title;
		$lattribs['accesskey'] = $accesskey;
		$lattribs['tabindex'] = $tabindex;
		$lattribs['lang'] = $lang;
		$lattribs['hreflang'] = $hreflang;
		$lattribs['rel'] = $rel;
		$lattribs['rev'] = $rev;
		
		$lattribs = removeEmptyAttribs($lattribs, array());
		
		$rollOverAttribsArr = $this->rollAttribs;
		
		if (is_array($tagAttr)) {
			foreach ($tagAttr as $n => $v) {
				$lattribs[$n] = $v;
			}
		}
		
		// overwrite rolloverattribs
		foreach ($rollOverAttribsArr as $n => $v) {
			$lattribs[$n] = $v;
		}
		
		if (isset($jswinAttribs) && is_array($jswinAttribs) && isset($jswinAttribs["jswin"])) { //popUp
			if ($jswinAttribs["jscenter"] && $jswinAttribs["jswidth"] && $jswinAttribs["jsheight"]) {
				$js .= 'if (window.screen) {var w = ' . $jswinAttribs["jswidth"] . ';var h = ' . $jswinAttribs["jsheight"] . ';var screen_height = screen.availHeight - 70;var screen_width = screen.availWidth-10;var w = Math.min(screen_width,w);var h = Math.min(screen_height,h);var x = (screen_width - w) / 2;var y = (screen_height - h) / 2;we_winOpts = \'left=\'+x+\',top=\'+y;}else{we_winOpts=\'\';};';
			} else 
				if ($jswinAttribs["jsposx"] != "" || $jswinAttribs["jsposy"] != "") {
					if ($jswinAttribs["jsposx"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'left=' . $jswinAttribs["jsposx"] . '\';';
					}
					if ($jswinAttribs["jsposy"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'top=' . $jswinAttribs["jsposy"] . '\';';
					}
				}
			if ($jswinAttribs["jswidth"] != "") {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'width=' . $jswinAttribs["jswidth"] . '\';';
			}
			if ($jswinAttribs["jsheight"] != "") {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'height=' . $jswinAttribs["jsheight"] . '\';';
			}
			if ($jswinAttribs["jsstatus"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=no\';';
			}
			if ($jswinAttribs["jsscrollbars"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=no\';';
			}
			if ($jswinAttribs["jsmenubar"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=no\';';
			}
			if ($jswinAttribs["jsresizable"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=no\';';
			}
			if ($jswinAttribs["jslocation"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=no\';';
			}
			if ($jswinAttribs["jstoolbar"]) {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=yes\';';
			} else {
				$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=no\';';
			}
			$foo = $js . "var we_win = window.open('','" . "we_ll_" . $nr . "',we_winOpts);";
			
			$lattribs = removeAttribs($lattribs, array(
				'name', 'target', 'href', 'onClick', 'onclick'
			));
			
			$lattribs['target'] = 'we_ll_' . $nr;
			$lattribs['onclick'] = $foo;
		} else { //  no popUp
			$lattribs = removeAttribs($lattribs, array(
				'name', 'href'
			));
		}
		$lattribs['href'] = $link . str_replace('&', '&amp;', $params . $anchor);
		
		if (isset($lattribs['only'])) {
			return $lattribs[$lattribs['only']];
		}
		
		return $this->rollScript . getHtmlTag('a', $lattribs, '', false, true);
	}

	function getUrl($nr, $params = "")
	{
		$id = $this->getID($nr);
		if ($id == "")
			return "http://";
		if (isset($this->cache[$id])) {
			$row = $this->cache[$id];
		} else {
			$row = getHash("SELECT IsDynamic,Path FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", $this->db);
			$this->cache[$id] = $row;
		}
		return (isset($row["Path"]) ? $row["Path"] : '') . ($params ? ("?" . $params) : "");
	
	}

	function getImageID($nr)
	{
		return isset($this->listArray[$nr]["img_id"]) ? $this->listArray[$nr]["img_id"] : "";
	}

	function getImageAttribs($nr)
	{
		return isset($this->listArray[$nr]["img_attribs"]) ? $this->listArray[$nr]["img_attribs"] : array();
	}

	function getImageAttrib($nr, $key)
	{
		$foo = $this->getImageAttribs($nr);
		return isset($foo[$key]) ? $foo[$key] : "";
	}

	function getJsWinAttrib($nr, $key)
	{
		$foo = $this->getJsWinAttribs($nr);
		return isset($foo[$key]) ? $foo[$key] : "";
	}

	function getJsWinAttribs($nr)
	{
		return isset($this->listArray[$nr]["jswin_attribs"]) ? $this->listArray[$nr]["jswin_attribs"] : array();
	}

	function getImageSrc($nr)
	{
		return isset($this->listArray[$nr]["img_src"]) ? $this->listArray[$nr]["img_src"] : "";
	}

	function getText($nr)
	{
		return $this->listArray[$nr]["text"];
	}

	function getAnchor($nr)
	{
		return (isset($this->listArray[$nr]["anchor"]) ? $this->listArray[$nr]["anchor"] : "");
	}

	function getAccesskey($nr)
	{
		return (isset($this->listArray[$nr]["accesskey"]) ? $this->listArray[$nr]["accesskey"] : "");
	}

	function getTabindex($nr)
	{
		return (isset($this->listArray[$nr]["tabindex"]) ? $this->listArray[$nr]["tabindex"] : "");
	}

	function getLang($nr)
	{
		return (isset($this->listArray[$nr]["lang"]) ? $this->listArray[$nr]["lang"] : "");
	}

	function getRel($nr)
	{
		return (isset($this->listArray[$nr]["rel"]) ? $this->listArray[$nr]["rel"] : "");
	}

	function getRev($nr)
	{
		return (isset($this->listArray[$nr]["rev"]) ? $this->listArray[$nr]["rev"] : "");
	}

	function getHreflang($nr)
	{
		return (isset($this->listArray[$nr]["hreflang"]) ? $this->listArray[$nr]["hreflang"] : "");
	}

	function getParams($nr)
	{
		return (isset($this->listArray[$nr]["params"]) ? $this->listArray[$nr]["params"] : "");
	}

	function getHrefInt($nr)
	{
		$id = $this->getID($nr);
		return $id ? f("SELECT Path FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", "Path", $this->db) : "";
	}

	function getHrefObj($nr)
	{
		$id = $this->getObjID($nr);
		return $id ? f("SELECT Path FROM " . OBJECT_FILES_TABLE . " WHERE ID=".abs($id)."", "Path", $this->db) : "";
	}

	function getImageSrcInt($nr)
	{
		$id = $this->getImageID($nr);
		return $id ? f("SELECT Path FROM " . FILE_TABLE . " WHERE ID=".abs($id)."", "Path", $this->db) : "";
	}

	function getString()
	{
		if (sizeof($this->listArray) == 0)
			return "";
		return serialize($this->listArray);
	}

	function setID($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["id"] = $val;
		}
	}

	function setObjID($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["obj_id"] = $val;
		}
	}

	function setHref($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["href"] = $val;
		}
	}

	function setAnchor($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["anchor"] = $val;
		}
	}

	function setAccesskey($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["accesskey"] = $val;
		}
	}

	function setTabindex($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["tabindex"] = $val;
		}
	}

	function setLang($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["lang"] = $val;
		}
	}

	function setRel($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["rel"] = $val;
		}
	}

	function setRev($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["rev"] = $val;
		}
	}

	function setHreflang($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["hreflang"] = $val;
		}
	}

	function setParams($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["params"] = $val;
		}
	}

	function setAttribs($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["attribs"] = $val;
		}
	}

	function setTarget($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["target"] = $val;
		}
	}

	function setImageID($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["img_id"] = $val;
		}
	}

	function setTitle($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["title"] = $val;
		}
	}

	function setImageSrc($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["img_src"] = $val;
		}
	}

	function setText($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["text"] = $val;
		}
	}

	function setImageAttribs($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["img_attribs"] = $val;
		}
	}

	function setImageAttrib($nr, $key, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["img_attribs"][$key] = $val;
		}
	}

	function setJsWinAttribs($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["jswin_attribs"] = $val;
		}
	}

	function setJsWinAttrib($nr, $key, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["jswin_attribs"][$key] = $val;
		}
	}

	function correctContent($content)
	{
		$ipos = strpos($content, '<we_:_linklist');
		$start = $ipos;
		$starttag = 1;
		while ($starttag && (!($ipos === false))) {
			$starttagpos = strpos($content, '<we_:_linklist', $ipos + 1);
			$endtagpos = strpos($content, '</we_:_linklist', $ipos + 1);
			if ((!($starttagpos === false)) && ($starttagpos < $endtagpos)) {
				$ipos = $starttagpos;
				$starttag++;
			} else 
				if (!($endtagpos === false)) {
					$starttag--;
					$ipos = $endtagpos;
				} else 
					if (!($starttagpos === false)) {
						$ipos = $starttagpos;
					}
		}
		$end = $endtagpos ? $endtagpos + 15 : strlen($content);
		
		$search = substr($content, $start, $end - $start);
		
		$repl = str_replace("we_:_linklist", "we__:__linklist", $search);
		$repl = str_replace("<we_:_", "<we_#:#_", $repl);
		$repl = str_replace("</we_:_", "</we_#:#_", $repl);
		$repl = str_replace("we__:__linklist", "we:linklist", $repl);
		
		return str_replace($search, $repl, $content);
	
	}

	function getHTML($editmode, $attribs, $content, $docName)
	{
		$linklistRef = $attribs["name"] . "_TAGS_";
		$limit = 0;
		if (isset($attribs['limit']) && $attribs['limit'] > 0) {
			$limit = $attribs['limit'];
		}
		$out = "";
		
		if (!isset($GLOBALS["WE_IS_DYN"])) {
			$we_button = new we_button();
		}
		$tp = new we_tagParser();
		
		if (!(strpos($content, '<we:') === false)) {
			$content = str_replace("<we:target", "<we_:_target", $content);
			$content = str_replace("<we:field", "<we_:_field", $content);
			$content = str_replace("<we:path", "<we_:_path", $content);
			$content = eregi_replace("<we:ifSelf[^>]*>", "<we_:_ifSelf>", $content);
			$content = eregi_replace("<we:ifNotSelf[^>]*>", "<we_:_ifNotSelf>", $content);
			$content = str_replace("<we:prelink", "<we_:_prelink", $content);
			$content = str_replace("<we:postlink", "<we_:_postlink", $content);
			$content = str_replace("</we:ifSelf", "</we_:_ifSelf", $content);
			$content = str_replace("</we:ifNotSelf", "</we_:_ifNotSelf", $content);
			$content = str_replace("</we:prelink", "</we_:_prelink", $content);
			$content = str_replace("</we:postlink", "</we_:_postlink", $content);
		
		}
		
		$ipos = strpos($content, '<we_:_linklist');
		while (!($ipos === false)) {
			$content = $this->correctContent($content);
			$ipos = strpos($content, '<we_:_linklist');
		}
		
		$tags = $tp->getAllTags($content);
		$names = implode(",", $tp->getNames($tags));
		$tp->parseTags($tags, $content, '<we_:_linklistRef>', array(
			'we:ifVar'
		));
		
		if (!$editmode) {
			$show = $this->listArray;
			if ($limit > 0 && $this->listArray > $limit) {
				$show = $limit;
			}
		}
		$j = 0;
		$disabled = false;
		foreach ($this->listArray as $i => $val) {
			$j++;
			if (!$editmode && $j > $show) {
				break;
			}
			
			if (abs($i) || $i == "0") {
				$foo = $content;
				
				$link = $this->getLink($i);
				$linkcontent = $this->getLinkContent($i);
				if ($linkcontent) {
					
					$buts = "";
					
					if ($editmode) {
						// Create button object
						$we_button = new we_button();
						
						// Create buttons
						$disabled = false;
						if ($limit > 0 && $this->length() >= $limit) {
							$disabled = true;
						}
						$plusbut = $we_button->create_button(
								"image:btn_add_link", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('insert_link_at_linklist','" . $attribs["name"] . "','" . $i . "')", 
								true, 
								100, 
								22, 
								"", 
								"", 
								$disabled);
						$upbut = $we_button->create_button(
								"image:btn_direction_up", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('up_link_at_list','" . $attribs["name"] . "','" . $i . "')", 
								true, 
								-1, 
								-1, 
								"", 
								"", 
								!($i > 0));
						$downbut = $we_button->create_button(
								"image:btn_direction_down", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('down_link_at_list','" . $attribs["name"] . "','" . $i . "')", 
								true, 
								-1, 
								-1, 
								"", 
								"", 
								!($i < (sizeof($this->listArray) - 1)));
						$editbut = $we_button->create_button(
								"image:btn_edit_link", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('edit_linklist','" . $attribs["name"] . "','" . $i . "')", 
								true);
						$trashbut = $we_button->create_button(
								"image:btn_function_trash", 
								"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('delete_linklist','" . $attribs["name"] . "','" . $i . "','" . $names . "')", 
								true);
						$buts = $we_button->create_button_table(
								array(
									$plusbut, $upbut, $downbut, $editbut, $trashbut
								), 
								5);
					}
					
					if ($i == (sizeof($this->listArray) - 1)) {
						$foo = eregi_replace('<we_:_postlink>.*</we_:_postlink>', '', $foo);
					} else {
						$foo = str_replace('<we_:_postlink>', '', $foo);
						$foo = str_replace('</we_:_postlink>', '', $foo);
					}
					if ($i == 0) {
						$foo = eregi_replace('<we_:_prelink>.*</we_:_prelink>', '', $foo);
					} else {
						$foo = str_replace('<we_:_prelink>', '', $foo);
						$foo = str_replace('</we_:_prelink>', '', $foo);
					}
					
					//	handle we:ifPosition - if available
					if (strpos($foo, 'position') || strpos($foo, 'ifPosition') || strpos(
							$foo, 
							'ifNotPosition')) {
						$foo = '<?php $GLOBALS[\'we_position\'][\'linklist\'][\'' . $this->name . '\'] = array(\'size\'=> ' . sizeof(
								$this->listArray) . ',\'position\'=>' . ($i + 1) . '); ?>' . $foo . '<?php unset($GLOBALS[\'we_position\'][\'linklist\'][\'' . $this->name . '\']); ?>';
					}
					//	handle we:ifPosition - if available
					

					$lnr = $this->listArray[$i]["nr"];
					
					$foo = eregi_replace('<we_:_target */? *>', $this->getTarget($i), $foo);
					$foo = eregi_replace('<we_:_field */? *>', $linkcontent, $foo);
					$foo = eregi_replace('<we_:_path */? *>', $link . $this->getParams($i), $foo);
					$foo = str_replace(
							'<we_:_ifSelf>', 
							'<?php if("' . $GLOBALS["WE_MAIN_DOC"]->Path . '" == "' . $this->getLink($i) . '"): ?>', 
							$foo);
					$foo = str_replace('</we_:_ifSelf>', '<?php endif ?>', $foo);
					$foo = str_replace(
							'<we_:_ifNotSelf>', 
							'<?php if("' . $GLOBALS["WE_MAIN_DOC"]->Path . '" != "' . $this->getLink($i) . '"): ?>', 
							$foo);
					$foo = str_replace('</we_:_ifNotSelf>', '<?php endif ?>', $foo);
					
					if (!isset($this->listArray[$i]["nr"])) {
						$nr = $i;
						$this->listArray[$i]["nr"] = $nr;
					} else {
						$nr = $this->listArray[$i]["nr"];
					}
					$foo = str_replace('<we_:_linklistRef>', $linklistRef . $nr, $foo);
					
					if (preg_match_all('/<we_:_link([^>\/]*)\/?>/', $foo, $regs, PREG_SET_ORDER)) {
						
						foreach ($regs as $reg) {
							
							$attrArr = makeArrayFromAttribs(trim($reg[1]));
							
							$xml = getXmlAttributeValueAsBoolean(we_getTagAttribute("xml", $attrArr));
							$_content = $linkcontent;
							
							if (isset($attrArr['only'])) {
								$foo = str_replace($reg[0], $this->getLinktag($i, $link, $attrArr) . $buts, $foo);
							} else {
								if ($link) {
									$linktag = $this->getLinktag($i, $link, $attrArr);
									$foo = str_replace($reg[0], $linktag . $_content . '</a>' . $buts, $foo);
								} else {
									$foo = str_replace($reg[0], $_content . $buts, $foo);
								}
							}
						}
					}
					$out .= $foo;
				}
			}
			$this->rollScript = "";
			$this->rollAttribs = array();
		}
		if ($editmode) {
			
			if (isset($GLOBALS["we_list_inserted"]) && isset($GLOBALS["we_list_inserted"]) && ($GLOBALS["we_list_inserted"] == $attribs["name"])) {
				$out .= '<script language="JavaScript" type="text/javascript">we_cmd(\'edit_linklist\',\'' . $attribs["name"] . '\',\'' . ((isset(
						$GLOBALS["we_list_insertedNr"]) && ($GLOBALS["we_list_insertedNr"] != "")) ? $GLOBALS["we_list_insertedNr"] : $this->getMaxListNrID()) . '\');</script>';
			}
			$clearContent = eregi_replace('^[^<]+', '', $content);
			$clearContent = eregi_replace('>[^<]+$', '>', $clearContent);
			$clearContent = eregi_replace('>[^<]+$', '>', $clearContent);
			$clearContent = eregi_replace('>[^<]+$', '>', $clearContent);
			$clearContent = strip_tags($clearContent, "<we_:_link>,<we_:_link/>,<table><tbody><tr><td><p><br>");
			$clearContent = eregi_replace('^[^<]+', '', $clearContent); //	Added this line t remove unnecessary stuff written before the we:link
			$clearContent = eregi_replace('>[^<]+<', '><', $clearContent);
			$clearContent = eregi_replace('^[^<]*(<we_:_link ?/?>)[^<]*$', '\1', $clearContent);
			if ($limit == 0 || ($limit != 0 && $this->length() < $limit)) {
				$plusbut = "<br>" . $we_button->create_button(
						"image:btn_add_link", 
						"javascript:setScrollTo();_EditorFrame.setEditorIsHot(1);we_cmd('add_link_to_linklist','" . $attribs["name"] . "')", 
						true, 
						100, 
						22, 
						"", 
						"", 
						$disabled);
				$out .= '<input type="hidden" name="we_' . $docName . '_linklist[' . $attribs["name"] . ']" value="' . htmlspecialchars(
						$this->getString()) . '">' . eregi_replace(
						'(.*)<we_:_link[^>/]*/?>(.*)', 
						'\1' . $plusbut . '\2' . "\n", 
						$clearContent);
			}
		}
		
		$out = str_replace("<we_#:#_", "<we:", $out);
		$out = str_replace("</we_#:#_", "</we:", $out);
		return $out;
	}

	function getType($nr)
	{
		return isset($this->listArray[$nr]["type"]) ? $this->listArray[$nr]["type"] : "";
	}

	function getCType($nr)
	{
		return isset($this->listArray[$nr]["ctype"]) ? $this->listArray[$nr]["ctype"] : "";
	}

	function setType($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["type"] = $val;
		}
	}

	function setCType($nr, $val)
	{
		if ($nr == "0" || $nr) {
			$this->listArray[$nr]["ctype"] = $val;
		}
	}

	function addLink()
	{
		array_push($this->listArray, $this->getRawLink());
	}

	function length()
	{
		return sizeof($this->listArray);
	}

	function upLink($nr)
	{
		$temp = $this->listArray[$nr - 1];
		$this->listArray[$nr - 1] = $this->listArray[$nr];
		$this->listArray[$nr] = $temp;
	}

	function downLink($nr)
	{
		$temp = $this->listArray[$nr + 1];
		$this->listArray[$nr + 1] = $this->listArray[$nr];
		$this->listArray[$nr] = $temp;
	}

	function insertLink($nr)
	{
		$l = $this->getRawLink();
		for ($i = 0; $i < sizeof($this->listArray); $i++) {
			$lnr = $this->listArray[$i]["nr"];
			if (!isset($this->listArray[$i]["nr"])) {
				$this->listArray[$i]["nr"] = $i;
			}
		}
		for ($i = sizeof($this->listArray); $i > $nr; $i--) {
			$this->listArray[$i] = $this->listArray[$i - 1];
		}
		$this->listArray[$nr] = $l;
	}

	function removeLink($nr, $names = "", $name = "")
	{
		$realNr = $this->listArray[$nr]["nr"];
		$namesArray = $names ? explode(",", $names) : array();
		foreach ($namesArray as $n) {
			unset($GLOBALS["we_doc"]->elements[$n . $name . "_TAGS_" . $realNr]);
		}
		array_splice($this->listArray, $nr, 1);
	}

	/* ##### private Functions##### */
	function getMaxListNr()
	{
		$n = 0;
		for ($i = 0; $i < sizeof($this->listArray); $i++) {
			$n = max($this->listArray[$i]["nr"], $n);
		}
		return $n;
	}

	function getMaxListNrID()
	{
		$n = 0;
		$out = 0;
		for ($i = 0; $i < sizeof($this->listArray); $i++) {
			if ($this->listArray[$i]["nr"] > $n) {
				$n = $this->listArray[$i]["nr"];
				$out = $i;
			}
		}
		return $out;
	}

	function getRawLink()
	{
		$foo = array();
		$foo["href"] = "http://";
		$foo["text"] = $GLOBALS["l_global"]["new_link"];
		$foo["target"] = "";
		$foo["type"] = "ext";
		$foo["ctype"] = "text";
		$foo["nr"] = $this->getMaxListNr() + 1;
		return $foo;
	}

	function getLinkContent($nr)
	{
		if ($this->getCType($nr) == "int") {
			return $this->makeImgTag($nr);
		} else 
			if ($this->getCType($nr) == "ext") {
				return $this->makeImgTagFromSrc($this->getImageSrc($nr), $this->getImageAttribs($nr));
			} else 
				if ($this->getCType($nr) == "text") {
					return $this->getText($nr);
				}
		return "";
	}

	function makeImgTag($nr, $attribs = "")
	{
		$id = $this->getImageID($nr);
		if (!$attribs)
			$attribs = $this->getImageAttribs($nr);
		$img = new we_imageDocument();
		$img->initByID($id);
		$img->initByAttribs($attribs);
		//	name in linklist is generated from linklistname
		$img->elements['name']['dat'] = $this->name . "_img" . $nr;
		$this->rollScript = $img->getRollOverScript();
		$this->rollAttribs = $img->getRollOverAttribsArr();
		
		return $img->getHtml(false, false);
	}

	function makeImgTagFromSrc($src, $attribs)
	{
		
		$attribs = removeEmptyAttribs($attribs, array(
			'alt'
		));
		$attribs['src'] = $src;
		return getHtmlTag('img', $attribs);
	}

	function mta($hash, $key)
	{
		return (isset($hash[$key]) && $hash[$key] != "") ? (' ' . $key . '="' . $hash[$key] . '"') : '';
	}

}

?>