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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/parser.inc.php");

// Tag and TagBlock Cache
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCache.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weTagCache.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weTagListviewCache.class.php");

class we_tagParser
{

	var $DB_WE;

	var $lastpos = 0;

	var $tags = array();

	var $ipos = 0;

	function we_tagParser()
	{
	}

	function getNames($tags)
	{
		$names = array();
		$ll = 0;
		$l = 0;
		$b = 0;
		for ($i = 0; $i < sizeof($tags); $i++) {
			if ($ll == 0 && $l == 0 && $b == 0) {
				if (eregi('name ?= ?"([^"]+)"', $tags[$i], $regs)) {
					if (!in_array($regs[1], $names))
						array_push($names, $regs[1]);
				}
			}
			if (eregi('< ?we:linklist', $tags[$i])) {
				$ll++;
			} else 
				if (eregi('< ?we:list', $tags[$i])) {
					$l++;
				} else 
					if (eregi('< ?we:block', $tags[$i])) {
						$b++;
					} else 
						if (eregi('< ?/ ?we:linklist', $tags[$i])) {
							$ll--;
						} else 
							if (eregi('< ?/ ?we:list', $tags[$i])) {
								$l--;
							} else 
								if (eregi('< ?/ ?we:block', $tags[$i])) {
									$b--;
								}
		}
		return $names;
	}

	function getAllTags($code)
	{
		$tags = array();
		$foo = array();
		preg_match_all("|(</?we:[^><]+[<>])|U", $code, $foo, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($foo); $i++) {
			if (substr($foo[$i][1], -1) == "<") {
				$foo[$i][1] = substr($foo[$i][1], 0, strlen($foo[$i][1]) - 1);
			}
			array_push($tags, $foo[$i][1]);
		
		}
		return $tags;
	}

	/**
	 * @return	array
	 * @param	string $tagname
	 * @param	string $code
	 * @param	bool   $hasEndtag
	 * @desc		function separates a complete XML tag in several pieces
	 *			returns array with this information
	 *			tagname without <> .. for example "we:hidePages"
	 *			[0][x] = complete Tag
	 *			[1][x] = start tag
	 *			[2][x] = parameter as string
	 */
	function itemize_we_tag($tagname, $code)
	{
		
		preg_match_all('/(<' . $tagname . '([^>]*)>)/U', $code, $_matches);
		return $_matches;
	}

	/**
	 * @return string of code with all required tags
	 * @param $code Src Code
	 * @desc Searches for all meta-tags in a given template (title, keyword, description, charset)
	 */
	function getMetaTags($code)
	{
		
		$_tmpTags = array();
		$_foo = array();
		$_rettags = array();
		
		preg_match_all("|(</?we:[^><]+[<>])|U", $code, $_foo, PREG_SET_ORDER);
		
		for ($_i = 0; $_i < sizeof($_foo); $_i++) {
			if (substr($_foo[$_i][1], -1) == "<") {
				$_foo[$_i][1] = substr($_foo[$_i][1], 0, strlen($_foo[$_i][1]) - 1);
			}
			array_push($_tmpTags, $_foo[$_i][1]);
		}
		
		//	only Meta-tags, description, keywords, title and charset
		$_tags = array();
		for ($_i = 0; $_i < sizeof($_tmpTags); $_i++) {
			
			if (strpos($_tmpTags[$_i], "we:title") || strpos($_tmpTags[$_i], "we:description") || strpos(
					$_tmpTags[$_i], 
					"we:keywords") || strpos($_tmpTags[$_i], "we:charset")) {
				
				$_tags[] = $_tmpTags[$_i];
			}
		}
		//	now we need all between these tags - beware of selfclosing tags
		

		for ($i = 0; $i < sizeof($_tags);) {
			
			if (eregi("<we:(.*)/(.*)>", $_tags[$i])) { //  selfclosing xhtml-we:tag
				

				$_start = strpos($code, $_tags[$i]);
				$_starttag = $_tags[$i];
				
				$_endtag = "";
				$i++;
			
			} else { //  "normal" we:tag
				$_start = strpos($code, $_tags[$i]);
				$_starttag = $_tags[$i];
				$i++;
				
				$_end = strpos($code, $_tags[$i]) - $_start + strlen($_tags[$i]);
				$_endtag = isset($_tags[$i]) ? $_tags[$i] : "";
				$i++;
			}
			array_push($_rettags, array(
				array(
				$_starttag, $_endtag
			), $_endtag ? substr($code, $_start, $_end) : ""
			));
		}
		return $_rettags;
	}

	function parseTags($tags, &$code, $postName = "", $ignore = array())
	{
		
		if (!defined("DISABLE_TEMPLATE_TAG_CHECK") || !DISABLE_TEMPLATE_TAG_CHECK) {
			if (!$this->checkOpenCloseTags($tags, $code)) {
				return;
			}
		}
		
		$this->lastpos = 0;
		$this->tags = $tags;
		$this->ipos = 0;
		while ($this->ipos < sizeof($this->tags)) {
			$this->lastpos = 0;
			
			if (in_array(substr(ereg_replace("[>/ ].*", "", $this->tags[$this->ipos]), 1), $ignore)) {
				$this->parseTag($code); //	dont add postname tagname in ignorearray
			} else {
				$this->parseTag($code, $postName);
			}
		}
	
	}

	function checkOpenCloseTags($TagsInTemplate = array(), &$code)
	{
		
		$CloseTags = array(
			'listview', 'listdir', 'block'
		);
		
		$Counter = array();
		
		foreach ($TagsInTemplate as $_tag) {
			if (preg_match_all("/<(\/|)we:([a-z]*)(.*)>/si", $_tag, $_matches)) {
				if (!is_null($_matches[2][0]) && in_array($_matches[2][0], $CloseTags)) {
					if (!isset($Counter[$_matches[2][0]])) {
						$Counter[$_matches[2][0]] = 0;
					}
					if ($_matches[1][0] == "/") {
						$Counter[$_matches[2][0]]--;
					
					} else {
						$Counter[$_matches[2][0]]++;
					
					}
				}
			}
		}
		
		$ErrorMsg = "";
		$isError = false;
		foreach ($Counter as $_tag => $_counter) {
			if ($_counter < 0) {
				$ErrorMsg .= parseError(sprintf($GLOBALS["l_parser"]["missing_open_tag"], 'we:' . $_tag));
				$isError = true;
			
			} else 
				if ($_counter > 0) {
					$ErrorMsg .= parseError(sprintf($GLOBALS["l_parser"]["missing_close_tag"], 'we:' . $_tag));
					$isError = true;
				
				}
		
		}
		if ($isError) {
			$code = $ErrorMsg;
		}
		return !$isError;
	
	}

	function searchEndtag($code, $tagPos)
	{
		
		eregi("we:([^ >]+)", $this->tags[$this->ipos], $regs);
		$tagname = $regs[1];
		
		if ($tagname != "back" && $tagname != "next" && $tagname != "printVersion" && $tagname != "listviewOrder") {
			$tagcount = 0;
			$endtags = array();
			
			$endtagpos = $tagPos;
			
			for ($i = $this->ipos + 1; $i < sizeof($this->tags); $i++) {
				if (eregi("(< ?/ ?we ?: ?$tagname)", $this->tags[$i], $regs)) {
					array_push($endtags, $regs[1]);
					if ($tagcount) {
						$tagcount--;
					} else {
						// found endtag
						$this->ipos = $i + 1;
						for ($n = 0; $n < sizeof($endtags); $n++) {
							
							$endtagpos = strpos($code, $endtags[$n], $endtagpos + 1);
						}
						$this->ipos = $i + 1;
						return $endtagpos;
					}
				} else 
					if (eregi("< ?we ?: ?$tagname", $this->tags[$i])) {
						$tagcount++;
					}
			
			}
		}
		$this->ipos++;
		return -1;
	
	}

	function getNameAndAttribs($tag)
	{
		if (preg_match('/<we:([^ ]+) ([^>]+)>/i', $tag, $_regs)) {
			$_attribsString = $_regs[2];
			$_tmpAttribs = "";
			$_attribs = array();
			if (preg_match_all('/([^=]+)= *("[^"]*")/', $_attribsString, $foo, PREG_SET_ORDER)) {
				for ($i = 0; $i < sizeof($foo); $i++) {
					$_tmpAttribs .= '"' . trim($foo[$i][1]) . '"=>' . trim($foo[$i][2]) . ',';
				}
				eval("\$_attribs = array(" . preg_replace('/(.+),$/', "\$1", $_tmpAttribs) . ");");
			}
			return array(
				$_regs[1], $_attribs
			);
		}
		return null;
	}

	function parseTag(&$code, $postName = "")
	{
		
		$tag = $this->tags[$this->ipos];
		if (!$tag)
			return;
		$tagPos = -1;
		
		$endTag = false;
		eregi("<(/?)we:(.+)>?", $tag, $regs);
		if ($regs[1]) { ### its an end-tag
			$endTag = true;
		}
		$foo = $regs[2] . "/";
		eregi("([^ >/]+) ?(.*)", $foo, $regs);
		$tagname = $regs[1];
		$attr = trim(ereg_replace("(.*)/$", "\\1", $regs[2]));
		
		if (eregi('name="([^"]*)"', $attr, $regs)) {
			if (!$regs[1]) {
				print parseError(sprintf($GLOBALS["l_parser"]["name_empty"], $tagname));
			} else 
				if (strlen($regs[1]) > 255) {
					print parseError(sprintf($GLOBALS["l_parser"]["name_to_long"], $tagname));
				}
		}
		
		$attribs = "";
		preg_match_all('/([^=]+)= *("[^"]*")/', $attr, $foo, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($foo); $i++) {
			$attribs .= '"' . trim($foo[$i][1]) . '"=>' . trim($foo[$i][2]) . ',';
		}
		
		if (!$endTag) {
			$arrstr = "array(" . ereg_replace('(.+),$', "\\1", $attribs) . ")";
			
			@eval('$arr = ' . ereg_replace('"\$([^"]+)"', '"$GLOBALS[\1]"', $arrstr) . ';');
			if (!isset($arr)) {
				$arr = array();
			}
			
			switch ($tagname) {
				case "content" :
				case "master" :
					// don't parse it
					$code = str_replace($tag, '', $code);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "form" :
					$code = $this->parseFormTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "repeat" :
					$code = $this->parseRepeatTag($tag, $code);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "listview" :
					$code = $this->parseListviewTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "object" :
					$code = $this->parseObjectTag($tag, $code, $attribs, $postName);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "metadata" :
					$code = $this->parseMetadataTag($tag, $code, $attribs, $postName);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "customer" :
					$code = $this->parseCustomerTag($tag, $code, $attribs, $postName);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "repeatShopItem" :
					$code = $this->parserepeatShopitem($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "createShop" :
					$code = $this->parsecreateShop($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "addDelShopItem" :
					$code = $this->parseadddelShopitem($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "deleteShop" :
					$code = $this->parsedeleteShop($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "include" :
					$code = $this->parseIncludeTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "controlElement" :
					$code = $this->parseRemoveTags($tag, $code);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "hidePages" :
					$code = $this->parseRemoveTags($tag, $code);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "tr" :
					$code = $this->parseTrTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "xmlnode" :
					$code = $this->parseXMLNode($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "answers" :
					$code = $this->parseAnswersTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "voting" :
					$code = $this->parseVotingTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "votingList" :
					$code = $this->parseVotingListTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "captcha" :
					$code = $this->parseCaptchaTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				case "formmail" :
					$code = $this->parseFormmailTag($tag, $code, $attribs);
					$this->ipos++;
					$this->lastpos = 0;
					break;
				
				default :
					
					$attribs = "array(" . ereg_replace('(.+),$', "\\1", $attribs) . ")";
					$attribs = str_replace('=>"\$', '=>"$', $attribs); // workarround Bug Nr 6318
					

					if ($tagname == "ifHasEntries" || $tagname == "ifNotHasEntries" || $tagname == "ifHasCurrentEntry" || $tagname == "ifNotHasCurrentEntry") {
						$code = str_replace(
								$tag, 
								'<?php if(we_tag("' . $tagname . '", ' . $attribs . ')): ?>', 
								$code);
						$this->ipos++;
						$this->lastpos = 0;
					
					} else 
						if ($tagname == "ifshopexists") {
							$code = str_replace($tag, '<?php if(defined("SHOP_TABLE")): ?>', $code);
							$this->ipos++;
							$this->lastpos = 0;
						} else 
							if ($tagname == "ifobjektexists") {
								$code = str_replace($tag, '<?php if(defined("OBJECT_TABLE")): ?>', $code);
								$this->ipos++;
								$this->lastpos = 0;
							} else 
								if ($tagname == "ifnewsletterexists") {
									$code = str_replace(
											$tag, 
											'<?php if(defined("NEWSLETTER_TABLE")): ?>', 
											$code);
									$this->ipos++;
									$this->lastpos = 0;
								} else 
									if ($tagname == "ifcustomerexists") {
										$code = str_replace(
												$tag, 
												'<?php if(defined("CUSTOMER_TABLE")): ?>', 
												$code);
										$this->ipos++;
										$this->lastpos = 0;
									} else 
										if ($tagname == "ifbannerexists") {
											$code = str_replace(
													$tag, 
													'<?php if(defined("BANNER_TABLE")): ?>', 
													$code);
											$this->ipos++;
											$this->lastpos = 0;
										} else 
											if ($tagname == "ifvotingexists") {
												$code = str_replace(
														$tag, 
														'<?php if(defined("VOTING_TABLE")): ?>', 
														$code);
												$this->ipos++;
												$this->lastpos = 0;
											} else 
												if (substr($tagname, 0, 2) == "if" && $tagname != "ifNoJavaScript") {
													/*$code = str_replace($tag,'<?php echo \'<?php if(we_tag("'.$tagname.'", '.$attribs.')): ?>\'; ?>',$code);*/
													$code = str_replace(
															$tag, 
															$this->parseCacheIfTag(
																	'<?php if(we_tag("' . $tagname . '", ' . $attribs . ')): ?>'), 
															$code);
													$this->ipos++;
													$this->lastpos = 0;
												} else 
													if ($tagname == "condition") {
														$code = str_replace(
																$tag, 
																'<?php we_tag("' . $tagname . '", ' . $attribs . '); ?>', 
																$code);
														$this->ipos++;
														$this->lastpos = 0;
													} else {
														$tagPos = strpos($code, $tag, $this->lastpos);
														$endeStartTag = $tagPos + strlen($tag);
														$endTagPos = $this->searchEndtag($code, $tagPos);
														if ($endTagPos > -1) {
															$endeEndTagPos = strpos(
																	$code, 
																	">", 
																	$endTagPos) + 1;
															if ($endTagPos > $endeStartTag) {
																$content = substr(
																		$code, 
																		$endeStartTag, 
																		($endTagPos - $endeStartTag));
																
																if ($tagname == "noCache") {
																	$tp = new we_tagParser();
																	$tags = $tp->getAllTags($content);
																	$tp->parseTags($tags, $content);
																}
																
																if ($tagname == "block") {
																	$content = str_replace(
																			"\n", 
																			"\\n", 
																			$content);
																	$content = trim(
																			str_replace(
																					"\r", 
																					"\\r", 
																					$content));
																	$content = str_replace(
																			'"', 
																			'\"', 
																			$content);
																} else 
																	if ($tagname != "noCache") {
																		$content = str_replace(
																				"\n", 
																				"", 
																				$content);
																		$content = trim(
																				str_replace(
																						"\r", 
																						"", 
																						$content));
																		$content = str_replace(
																				'"', 
																				'\"', 
																				$content);
																	}
																$content = str_replace(
																		'we:', 
																		'we_:_', 
																		$content);
																$content = str_replace(
																		'$GLOBALS[\"lv\"]', 
																		'\$GLOBALS[\"lv\"]', 
																		$content); //	this must be slashed inside blocks (for objects)!!!!
																$content = str_replace(
																		'$GLOBALS[\"we_lv_array\"]', 
																		'\$GLOBALS[\"we_lv_array\"]', 
																		$content); //	this must be slashed inside blocks (for objects)!!!!
															} else {
																$content = "";
															}
															
															if ($tagname == "noCache") {
																// Tag besitzt Endtag
																$code = substr(
																		$code, 
																		0, 
																		$tagPos) . $this->parseNoCacheTag(
																		$content) . substr(
																		$code, 
																		$endeEndTagPos);
																//neu
															} else {
																// Tag besitzt Endtag
																$we_tag = 'we_tag("' . $tagname . '", ' . $attribs . ', "' . $content . '")';
																$code = substr($code, 0, $tagPos) . '<?php printElement( ' . $we_tag . '); ?>' . substr(
																		$code, 
																		$endeEndTagPos);
																//neu
															

															}
														
														} else 
															if ($tagname == "else") {
																$code = substr($code, 0, $tagPos) . $this->parseCacheIfTag(
																		'<?php else: ?>') . substr(
																		$code, 
																		$endeStartTag);
															
															} else 
																if (isset($GLOBALS["calculate"]) && $GLOBALS["calculate"] == 1) { //neu
																	$we_tag = 'we_tag("' . $tagname . '", ' . $attribs . ')';
																	eval(
																			'$code = str_replace($tag,std_numberformat(' . $we_tag . '),$code);');
																	//neu
																} else {
																	$we_tag = 'we_tag("' . $tagname . '", ' . $attribs . ', "")';
																	$code = substr($code, 0, $tagPos) . '<?php printElement( ' . $we_tag . '); ?>' . substr(
																			$code, 
																			$endeStartTag);
																}
														$this->lastpos = 0;
													}
					if ($postName) {
						
						$code = preg_replace(
								'/("name"=>")(' . (isset($arr["name"]) ? $arr["name"] : "") . ')(")/i', 
								'\1\2' . $postName . '\3', 
								$code);
						if ($tagname == 'setVar') {
							if (isset($arr['from']) && $arr['from'] == "block") {
								$code = preg_replace(
										'/("namefrom"=>")(' . (isset($arr["namefrom"]) ? $arr["namefrom"] : "") . ')(")/i', 
										'\1\2' . $postName . '\3', 
										$code);
							}
							if (isset($arr['to']) && $arr['to'] == "block") {
								$code = preg_replace(
										'/("nameto"=>")(' . (isset($arr["nameto"]) ? $arr["nameto"] : "") . ')(")/i', 
										'\1\2' . $postName . '\3', 
										$code);
							}
						} else {
							$code = preg_replace(
									'/("namefrom"=>")(' . (isset($arr["namefrom"]) ? $arr["namefrom"] : "") . ')(")/i', 
									'\1\2' . $postName . '\3', 
									$code);
						}
						//$code = preg_replace('/("namefrom"=>")('. ( isset($arr["namefrom"]) ? $arr["namefrom"] : "" ) .')(")/i','\1\2'.$postName.'\3',$code);
						if (!in_array($tagname, array(
							'ifVar', 'ifNotVar'
						))) { // ifVar and ifNotVar contains a value, NO fieldname herefore don't change match!
							$code = preg_replace(
									'/("match"=>")(' . (isset($arr["match"]) ? $arr["match"] : "") . ')(")/i', 
									'\1\2' . $postName . '\3', 
									$code);
						}
					}
			}
		} else {
			
			$this->ipos++;
			if ($tagname == "ifHasEntries" || $tagname == "ifNotHasEntries" || $tagname == "ifHasCurrentEntry" || $tagname == "ifNotHasCurrentEntry" || $tagname == "ifshopexists" || $tagname == "ifobjektexists" || $tagname == "ifnewsletterexists" || $tagname == "ifcustomerexists" || $tagname == "ifbannerexists" || $tagname == "ifvotingexists") {
				$code = str_replace($tag, '<?php endif ?>', $code);
			
			} else 
				if (substr($tagname, 0, 2) == "if" && $tagname != "ifNoJavaScript") {
					/*$code = str_replace($tag,'<?php echo "<?php endif ?>"; ?>',$code);*/
					$code = str_replace($tag, $this->parseCacheIfTag('<?php endif ?>'), $code);
				} else 
					if ($tagname == "printVersion") {
						$code = str_replace(
								$tag, 
								'<?php if(isset($GLOBALS["we_tag_start_printVersion"]) && $GLOBALS["we_tag_start_printVersion"]){ $GLOBALS["we_tag_start_printVersion"]=0; ?></a><?php } ?>', 
								$code);
					} else 
						if ($tagname == "next") {
							if (isset($GLOBALS["_we_voting_list_active"]))
								$code = str_replace(
										$tag, 
										'<?php if($GLOBALS["_we_voting_list"]->hasNextPage() ): ?></a><?php endif ?>', 
										$code);
							else
								$code = str_replace(
										$tag, 
										'<?php if($GLOBALS["lv"]->hasNextPage() && $GLOBALS["lv"]->close_a() ): ?></a><?php endif ?>', 
										$code);
						} else 
							if ($tagname == "back") {
								if (isset($GLOBALS["_we_voting_list_active"]))
									$code = str_replace(
											$tag, 
											'<?php if($GLOBALS["_we_voting_list"]->hasPrevPage() ): ?></a><?php endif ?>', 
											$code);
								else
									$code = str_replace(
											$tag, 
											'<?php if($GLOBALS["lv"]->hasPrevPage()  && $GLOBALS["lv"]->close_a() ): ?></a><?php endif ?>', 
											$code);
							} else 
								if ($tagname == "form") {
									$code = str_replace(
											$tag, 
											'<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?></form><?php endif ?><?php $GLOBALS["WE_FORM"] = ""; if (isset($GLOBALS["we_form_action"])) {unset($GLOBALS["we_form_action"]);} ?>', 
											$code);
								} else 
									if ($tagname == "repeat") {
										if (isset($GLOBALS['_we_voting_list_active'])) {
											$code = str_replace($tag, '<?php } ?>', $code);
										} else {
											$code = str_replace(
													$tag, 
													'<?php } unset($GLOBALS["_we_listview_object_flag"]); ?>', 
													$code);
										}
									
									} else 
										if ($tagname == "listview") {
											$code = str_replace(
													$tag, 
													'<?php
if ( isset( $GLOBALS["we_lv_array"] ) ) {
	array_pop($GLOBALS["we_lv_array"]);
	if (count($GLOBALS["we_lv_array"])) {
		$GLOBALS["lv"] = clone($GLOBALS["we_lv_array"][count($GLOBALS["we_lv_array"])-1]);
	} else {
		unset($GLOBALS["lv"]);unset($GLOBALS["we_lv_array"]);
	}
}?>' . $this->getEndCacheCode($tag), 
													$code);
										
										} else 
											if ($tagname == "object" || $tagname == "customer" || $tagname == "metadata") {
												$code = str_replace(
														$tag, 
														'<?php endif ?><?php
if ( isset( $GLOBALS["we_lv_array"] ) ) {
	array_pop($GLOBALS["we_lv_array"]);
	if (count($GLOBALS["we_lv_array"])) {
		$GLOBALS["lv"] = clone($GLOBALS["we_lv_array"][count($GLOBALS["we_lv_array"])-1]);
	} else {
		unset($GLOBALS["lv"]);unset($GLOBALS["we_lv_array"]);
	}
} ?>' . $this->getEndCacheCode($tag), 
														$code);
											
											} else 
												if ($tagname == "listviewOrder") {
													$code = str_replace($tag, '</a>', $code);
												} else 
													if ($tagname == "condition") {
														$code = str_replace(
																$tag, 
																'<?php $GLOBALS["we_lv_conditionCount"]--;$GLOBALS[$GLOBALS["we_lv_conditionName"]] .= ")"; ?>', 
																$code);
													} else 
														if ($tagname == "tr") {
															$code = str_replace(
																	$tag, 
																	'<?php if($GLOBALS["lv"]->shouldPrintEndTR()): ?></tr><?php endif ?>', 
																	$code);
														} else 
															if ($tagname == "repeatShopItem") {
																$code = str_replace(
																		$tag, 
																		'<?php } unset($GLOBALS["lv"]); ?>', 
																		$code);
															} else 
																if ($tagname == "xmlnode") {
																	$code = str_replace(
																			$tag, 
																			'<?php }} array_pop($GLOBALS["xstack"]); ?>', 
																			$code);
																} else 
																	if ($tagname == "voting") {
																		$code = str_replace(
																				$tag, 
																				'<?php if(isset($GLOBALS[\'_we_voting\'])) unset($GLOBALS[\'_we_voting\']); ?>', 
																				$code);
																	} else 
																		if ($tagname == "votingList") {
																			unset(
																					$GLOBALS['_we_voting_list_active']);
																			$code = str_replace(
																					$tag, 
																					'<?php unset($GLOBALS[\'_we_voting_list\']); ?>', 
																					$code);
																		} else 
																			if ($tagname == "answers") {
																				$code = str_replace(
																						$tag, 
																						'<?php } if(isset($GLOBALS[\'_we_voting\'])) $GLOBALS[\'_we_voting\']->resetSets();?>', 
																						$code);
																			} else 
																				if ($tagname == "content") {
																					$code = str_replace(
																							$tag, 
																							'', 
																							$code);
																				}
			
			$this->lastpos = 0;
		}
	}

	/* ############### parse individual Tags ########## */
	
	##########################################################################################
	##########################################################################################
	

	function getStartCacheCode($tag, $attribs)
	{
		
		if (!isset($GLOBALS['weListviewCacheStarted'])) {
			$GLOBALS['weListviewCacheStarted'] = array();
		}
		
		eregi("<we:(.+)>?", $tag, $regs);
		$foo = $regs[1] . "/";
		eregi("([^ >/]+) ?(.*)", $foo, $regs);
		$tagname = $regs[1];
		
		eval('$arr = array(' . $attribs . ');');
		$lifeTime = we_getTagAttributeTagParser("cachelifetime", $arr, 0);
		$type = we_getTagAttributeTagParser("type", $arr, '');
		
		$code = "";
		if (!$GLOBALS['we_doc']->IsFolder && ($GLOBALS['we_doc']->CacheLifeTime <= 0 || $GLOBALS['we_doc']->CacheType == "none") && $lifeTime == 0) {
			$GLOBALS['weListviewCacheStarted'][] = false;
			return $code;
		
		}
		
		switch ($tagname) {
			case 'listview' :
				if ($type == 'search') {
					$GLOBALS['weListviewCacheStarted'][] = false;
					break;
				}
			case 'object' :
				$code .= '<?php

// initialize the cache
weTagListviewCache::init($weTagListviewCache, "' . $tagname . '", unserialize(\'' . serialize(
						$attribs) . '\'), \'\', $GLOBALS[\'we_doc\']->CacheType == \'document\' ? $GLOBALS[\'we_doc\']->CacheLifeTime : ' . $lifeTime . ');

// check if the followed code must be executed or could come from cache
if(!$weTagListviewCache->isCacheable() || ($weTagListviewCache->isCacheable() && $weTagListviewCache->start())) {
?>';
				if (!isset($GLOBALS["weListviewCacheActiveIf"])) {
					$GLOBALS["weListviewCacheActiveIf"] = 0;
				
				}
				$GLOBALS["weListviewCacheActiveIf"]++;
				$GLOBALS['weListviewCacheStarted'][] = true;
				break;
			
			case 'form' : // not needed
			case 'repeat' : // not needed
			case 'tr' : // not needed
				break;
			
			default :
				$GLOBALS['weListviewCacheStarted'][] = false;
				break;
		
		}
		
		return $code;
	
	}

	##########################################################################################
	##########################################################################################
	

	function getEndCacheCode($tag)
	{
		$temp = isset($GLOBALS['weListviewCacheStarted']) && is_array($GLOBALS['weListviewCacheStarted']) ? array_pop(
				$GLOBALS['weListviewCacheStarted']) : false;
		$code = "";
		if (!$temp) {
			return $code;
		
		}
		$GLOBALS["weListviewCacheActiveIf"]--;
		
		$code = '<?php

	// write the cache file if needed
	if(isset($weTagListviewCache)) {
		$weTagListviewCache->end();
	}
}
// Output the cached content
if(isset($weTagListviewCache)) {
	if(file_exists($weTagListviewCache->getCacheFilename()) && $weTagListviewCache->isValid()) {
		include($weTagListviewCache->getCacheFilename());
		unset($weTagListviewCache);
	}
}

?>';
		
		return $code;
	
	}

	##########################################################################################
	##########################################################################################
	

	function replaceTag($tag, $code, $str)
	{
		$tagPos = strpos($code, $tag, $this->lastpos);
		$endeEndTagPos = $tagPos + strlen($tag);
		return substr($code, 0, $tagPos) . $str . substr($code, $endeEndTagPos);
	}

	##########################################################################################
	##########################################################################################
	

	function parseIncludeTag($tag, $code, $attribs = "")
	{
		
		eval('$arr = array(' . $attribs . ');');
		
		$id = we_getTagAttributeTagParser("id", $arr);
		$path = we_getTagAttributeTagParser("path", $arr);
		$name = we_getTagAttributeTagParser("name", $arr, '');
		
		$php = '';
		
		if ((!$id) && (!$path) && (!$name)) {
			$php = "<!-- we:include - missing id, path or name !!-->";
			return str_replace($tag, $php, $code);
		}
		
		if ($name && !($id || $path)) {
			
			$php .= '<?php

    	if ( isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"])  {

    		$_tmpspan = \'<span style="color: white;font-size:\'.
								(($GLOBALS["SYSTEM"] == "MAC") ? "11px" : (($GLOBALS["SYSTEM"] == "X11") ? "13px" : "12px")). \';font-family:\'.
								$GLOBALS["l_css"]["font_family"].\';">\';

    		print "<table style=\"background: #006DB8;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"padding: 3px;\">" . $_tmpspan . "&nbsp;" . $GLOBALS["l_tags"]["include_file"] . "</span></td></tr><tr><td>";
    		printElement( we_tag("href", array("name"=>"' . $name . '"), ""));
    		print  "</td></tr></table>";

    	} else {
    		$path = we_tag("href", array("name"=>"' . $name . '"), "");
    	}
    	?>';
		}
		
		$gethttp = we_getTagAttributeTagParser("gethttp", $arr, "", true);
		if (isset($arr["seem"])) {
			$seeMode = we_getTagAttributeTagParser("seem", $arr, "", true, true); //	backwards compatibility
		} else {
			$seeMode = we_getTagAttributeTagParser("seeMode", $arr, "", true, true);
		}
		
		$we_unique = md5(uniqid(rand(), 1));
		if ($id || $path || $name) {
			$php .= '<?php
				if( ("' . $id . '" && ($GLOBALS["we_doc"]->ContentType != "text/webedition" || $GLOBALS["WE_MAIN_DOC"]->ID != "' . $id . '")) || "' . $path . '" != "" || "$path" != "" ){
					if (!isset($we_backVars) || !is_array($we_backVars)) {
						$we_backVars = array();
					}

					$GLOBALS["we_backVars"]["' . $we_unique . '"]["we_doc"] = clone($GLOBALS["we_doc"]);
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_IS_DYN"] = isset($GLOBALS["WE_IS_DYN"]) ? 1 : 0;
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_ID"] = $GLOBALS["WE_DOC_ID"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_ParentID"] = $GLOBALS["WE_DOC_ParentID"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_Path"] = $GLOBALS["WE_DOC_Path"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_IsDynamic"] = $GLOBALS["WE_DOC_IsDynamic"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_FILENAME"] = $GLOBALS["WE_DOC_FILENAME"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_Category"] = $GLOBALS["WE_DOC_Category"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_EXTENSION"] = $GLOBALS["WE_DOC_EXTENSION"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["TITLE"] = $GLOBALS["TITLE"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["KEYWORDS"] = $GLOBALS["KEYWORDS"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["DESCRIPTION"] = $GLOBALS["DESCRIPTION"];
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["we_cmd"] = isset($_REQUEST["we_cmd"]) ? $_REQUEST["we_cmd"] : "";
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["FROM_WE_SHOW_DOC"] = isset($GLOBALS["FROM_WE_SHOW_DOC"]) ? $GLOBALS["FROM_WE_SHOW_DOC"] : "";
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["we_transaction"] = isset($GLOBALS["we_transaction"]) ? $GLOBALS["we_transaction"] : "";
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["we_editmode"] = isset($GLOBALS["we_editmode"]) ? $GLOBALS["we_editmode"] : null;
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["we_ContentType"] = isset($GLOBALS["we_ContentType"]) ? $GLOBALS["we_ContentType"] : "text/webedition";
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["pv_id"] = isset($_REQUEST["pv_id"]) ? $_REQUEST["pv_id"] : "";
					$GLOBALS["we_backVars"]["' . $we_unique . '"]["pv_tid"] = isset($_REQUEST["pv_tid"]) ? $_REQUEST["pv_tid"] : "";
					if(isset($GLOBALS["WE_IS_DYN"])){
						unset($GLOBALS["WE_IS_DYN"]);
					}
					unset($_REQUEST["pv_id"]);
					unset($_REQUEST["pv_tid"]);

					if("' . $path . '"){
						$foo = "' . $path . '";
					}else if("' . $id . '"){
						$__id__ = ' . ($id==""?'""':$id) . ';
						$GLOBALS["DB_WE"]->query("SELECT Path,IsDynamic FROM ".FILE_TABLE." WHERE ID=".abs($__id__));
						$GLOBALS["DB_WE"]->next_record();
						$foo = $GLOBALS["DB_WE"]->f("Path");
					}elseif("' . $name . '"){
						$foo = $path;
					}else{
						$foo = "";
					}
					if ($foo) {
						if ("' . $gethttp . '") {
							$foo = getHTTP(SERVER_NAME, $foo, "", defined("HTTP_USERNAME") ? HTTP_USERNAME : "", defined("HTTP_PASSWORD") ? HTTP_PASSWORD : "");
						} else {
							$foo = $_SERVER["DOCUMENT_ROOT"] . $foo;
							if (file_exists($foo) && filesize($foo) > 0) {
								$fp = fopen($foo, "rb");
								$foo = fread($fp, filesize($foo));
								fclose($fp);
							} else {
								$foo = "";
							}
						}
						if (isset($_SESSION["we_mode"]) && ($_SESSION["we_mode"] == "seem") && isset($GLOBALS["we_doc"]->InWebEdition) && $GLOBALS["we_doc"]->InWebEdition) {
                        ';
			
			if ($seeMode) { //	only show link to seeMode, when id is given
				if ($id) {
					$php .= '
                            $foo .= <<< ENDOF_OF_FILE
<a href="' . $id . '" seem="include"></a>
ENDOF_OF_FILE;
';
				}
				if ($path) {
					$_tmpID = path_to_id($path);
					$php .= '
                            $foo .= "<a href=\"' . $_tmpID . '\" seem=\"include\"></a>";';
				}
			}
			$php .= '
                            if (eregi(\'< ?form\', $foo)) {
								$foo = eregi_replace(\'< ?form[^>]*>\',\'\', $foo);
								$foo = eregi_replace(\'< ?/ ?form[^>]*>\',\'\', $foo);
							}
						}
						eval("?>".$foo);
					}

					$GLOBALS["we_doc"] = clone($GLOBALS["we_backVars"]["' . $we_unique . '"]["we_doc"]);
					$GLOBALS["WE_DOC_ID"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_ID"];
					$GLOBALS["WE_DOC_ParentID"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_ParentID"];
					$GLOBALS["WE_DOC_Path"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_Path"];
					$GLOBALS["WE_DOC_IsDynamic"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_IsDynamic"];
					$GLOBALS["WE_DOC_FILENAME"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_FILENAME"];
					$GLOBALS["WE_DOC_Category"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_Category"];
					$GLOBALS["WE_DOC_EXTENSION"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_DOC_EXTENSION"];
					$GLOBALS["TITLE"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["TITLE"];
					$GLOBALS["KEYWORDS"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["KEYWORDS"];
					$GLOBALS["DESCRIPTION"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["DESCRIPTION"];
					$_REQUEST["we_cmd"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["we_cmd"];
					$GLOBALS["we_cmd"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["we_cmd"];
					$GLOBALS["FROM_WE_SHOW_DOC"]= $GLOBALS["we_backVars"]["' . $we_unique . '"]["FROM_WE_SHOW_DOC"];
					$GLOBALS["we_transaction"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["we_transaction"];
					$GLOBALS["we_editmode"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["we_editmode"];
					$GLOBALS["we_ContentType"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["we_ContentType"];
					$_REQUEST["pv_id"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["pv_id"];
					$_REQUEST["pv_tid"] = $GLOBALS["we_backVars"]["' . $we_unique . '"]["pv_tid"];

					if(isset($GLOBALS["WE_IS_DYN"])){
						unset($GLOBALS["WE_IS_DYN"]);
					}
					if($GLOBALS["we_backVars"]["' . $we_unique . '"]["WE_IS_DYN"]){
						$GLOBALS["WE_IS_DYN"] = 1;
					}
					unset($GLOBALS["we_backVars"]["' . $we_unique . '"]);
				}
			?>';
		} else {
			$php = "";
		}
		
		if (isset($GLOBALS['we_doc']) && !$GLOBALS['we_doc']->IsFolder && $GLOBALS['we_doc']->CacheType == "document" && $GLOBALS['we_doc']->CacheLifeTime > 0) {
			$slashedPHP = str_replace("'", "\'", $php);
			//$slashedPHP = str_replace("\$", "\\\$", $slashedPHP);
			$php = <<<EOF
<?php
ob_start();
?>
{$php}
<?php
ob_end_clean();
echo '{$slashedPHP}';
?>
EOF;
		
		}
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	function parseRepeatTag($tag, $code, $attribs = "")
	{
		
		if (isset($GLOBALS['_we_voting_list_active'])) {
			$str = '<?php
			while(isset($GLOBALS["_we_voting_list"]) && $GLOBALS["_we_voting_list"]->getNext()){

			?>';
		
		} else {
			
			$str = '<?php while(isset($GLOBALS["lv"]) && $GLOBALS["lv"]->next_record()){

			$GLOBALS["we_lv_array"][(sizeof($GLOBALS["we_lv_array"])-1)] = clone($GLOBALS["lv"]);
			if($GLOBALS["lv"]->ClassName == "we_listview_object"){

				$GLOBALS["_we_listview_object_flag"] = true;
			}
			?>';
		}
		
		return $this->replaceTag($tag, $code, $str);
	}

	##########################################################################################
	##########################################################################################
	function parseListviewTag($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		
		$name = we_getTagAttributeTagParser("name", $arr, "0");
		$doctype = we_getTagAttributeTagParser("doctype", $arr);
		$class = we_getTagAttributeTagParser("classid", $arr, "0");
		$categories = we_getTagAttributeTagParser("categories", $arr);
		$categoryids = we_getTagAttributeTagParser("categoryids", $arr);
		$catOr = we_getTagAttributeTagParser("catOr", $arr, "", true);
		$rows = we_getTagAttributeTagParser("rows", $arr, "100000000");
		$order = we_getTagAttributeTagParser("order", $arr);
		$id = we_getTagAttributeTagParser("id", $arr);
		$cond = we_getTagAttributeTagParser("condition", $arr);
		$type = we_getTagAttributeTagParser("type", $arr, "document");
		$desc = we_getTagAttributeTagParser("desc", $arr, "");
		if ($desc == "false") {
			$desc = "";
		}
		$offset = we_getTagAttributeTagParser("offset", $arr);
		$workspaceID = we_getTagAttributeTagParser("workspaceID", $arr);
		$workspaceID = $workspaceID ? $workspaceID : we_getTagAttributeTagParser("workspaceid", $arr, "");
		
		$triggerid = we_getTagAttributeTagParser("triggerid", $arr, "0");
		$docid = we_getTagAttributeTagParser("docid", $arr, "0");
		$customers = we_getTagAttributeTagParser("customers", $arr); // csv value of Ids
		$casesensitive = we_getTagAttributeTagParser("casesensitive", $arr, "", true);
		$customer = we_getTagAttributeTagParser("customer", $arr, "", true);
		$contentTypes = we_getTagAttributeTagParser("contenttypes", $arr);
		$cols = we_getTagAttributeTagParser("cols", $arr);
		$searchable = we_getTagAttributeTagParser("searchable", $arr, "", true, true);
		if (isset($arr["seem"])) {
			$seeMode = we_getTagAttributeTagParser("seem", $arr, "", true, true); //	backwards compatibility
		} else {
			$seeMode = we_getTagAttributeTagParser("seeMode", $arr, "", true, true);
		}
		$calendar = we_getTagAttributeTagParser("calendar", $arr, "");
		$datefield = we_getTagAttributeTagParser("datefield", $arr, "");
		$date = we_getTagAttributeTagParser("date", $arr, "");
		$weekstart = we_getTagAttributeTagParser("weekstart", $arr, "monday");
		
		if (isset($arr['recursive'])) {
			$subfolders = !we_getTagAttributeTagParser("recursive", $arr, "", true);
		} else {
			// deprecated, because subfolders acts the other way arround as it should
			$subfolders = we_getTagAttributeTagParser("subfolders", $arr, "", true, false);
		}
		$subfolders = (strlen($workspaceID) && $subfolders) ? "true" : "false";
		
		$cfilter = we_getTagAttributeTagParser("cfilter", $arr, "off");
		
		$php = '<?php


if (!isset($GLOBALS["we_lv_array"])) {
	$GLOBALS["we_lv_array"] = array();
}

$we_lv_catOr = (isset($_REQUEST["we_lv_catOr_' . $name . '"]) ? $_REQUEST["we_lv_catOr_' . $name . '"] : "' . $catOr . '") ? true : false;
$we_lv_desc = (isset($_REQUEST["we_lv_desc_' . $name . '"]) ? $_REQUEST["we_lv_desc_' . $name . '"] : "' . $desc . '") ? true : false;
$we_lv_se = (isset($_REQUEST["we_lv_se_' . $name . '"]) ? $_REQUEST["we_lv_se_' . $name . '"] : "' . $searchable . '") ? true : false;
$we_lv_ct = isset($_REQUEST["we_lv_ct_' . $name . '"]) ? $_REQUEST["we_lv_ct_' . $name . '"] : "' . $contentTypes . '";
$we_lv_order = isset($_REQUEST["we_lv_order_' . $name . '"]) ? $_REQUEST["we_lv_order_' . $name . '"] : "' . $order . '";
$we_lv_ws = isset($_REQUEST["we_lv_ws_' . $name . '"]) ? $_REQUEST["we_lv_ws_' . $name . '"] : "' . $workspaceID . '";
$we_lv_cats = isset($_REQUEST["we_lv_cats_' . $name . '"]) ? $_REQUEST["we_lv_cats_' . $name . '"] : "' . $categories . '";
$we_lv_categoryids = isset($_REQUEST["we_lv_categoryids_' . $name . '"]) ? $_REQUEST["we_lv_categoryids_' . $name . '"] : "' . $categoryids . '";

$we_lv_calendar = isset($_REQUEST["we_lv_calendar_' . $name . '"]) ? $_REQUEST["we_lv_calendar_' . $name . '"] : "' . $calendar . '";
$we_lv_datefield = isset($_REQUEST["we_lv_datefield_' . $name . '"]) ? $_REQUEST["we_lv_datefield_' . $name . '"] : "' . $datefield . '";
$we_lv_date = isset($_REQUEST["we_lv_date_' . $name . '"]) ? $_REQUEST["we_lv_date_' . $name . '"] : ' . ($date != "" ? ('"' . $date . '"') : 'date("Y-m-d")') . ';
$we_lv_weekstart = isset($_REQUEST["we_lv_weekstart_' . $name . '"]) ? $_REQUEST["we_lv_weekstart_' . $name . '"] : "' . $weekstart . '";

if($we_lv_cats == "we_doc"){
	$we_lv_cats = we_getCatsFromDoc($we_doc,",",true,$DB_WE);
}
$we_offset = "' . $offset . '";
$we_offset = $we_offset ? abs($we_offset) : 0;
$we_rows = ' . $rows . ';
$we_rows = abs($we_rows);
';
		
		if ($type == "document" || $type == "search") {
			$php .= '$we_lv_doctype = "' . $doctype . '";
if($we_lv_doctype=="we_doc"){
	if($GLOBALS["we_doc"]->DocType){
		$we_lv_doctype=f("SELECT DocType FROM ".DOC_TYPES_TABLE." WHERE ID=\'".$GLOBALS["we_doc"]->DocType."\'","DocType",$GLOBALS["DB_WE"]);
	}
}
';
		}
		if ($type == "document") {
			$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/we_listview.class.php");
$GLOBALS["lv"] = new we_listview("' . $name . '", $we_rows, $we_offset, $we_lv_order , $we_lv_desc, "' . $doctype . '", $we_lv_cats, $we_lv_catOr, ' . ($casesensitive ? "true" : "false") . ', $we_lv_ws, $we_lv_ct, "' . $cols . '", $we_lv_se,"' . $cond . '",$we_lv_calendar,$we_lv_datefield,$we_lv_date,$we_lv_weekstart, $we_lv_categoryids, "' . $cfilter . '", ' . $subfolders . ', "' . $customers . '", "' . $id . '");
';
		
		} else 
			if ($type == "search") {
				$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/we_search_listview.class.php");
$GLOBALS["lv"] = new we_search_listview("' . $name . '", $we_rows, $we_offset, $we_lv_order , $we_lv_desc, "' . $doctype . '", "' . $class . '", $we_lv_cats, $we_lv_catOr, ' . ($casesensitive ? "true" : "false") . ', $we_lv_ws, "' . $cols . '", "' . $cfilter . '");
$GLOBALS["weEconda"]["HTML"] .= \'<a name="emos_name" title="search" rel="\'.$GLOBALS["lv"]->search.\'" rev="\'.$GLOBALS["lv"]->anz_all.\'" >\';
';
			} else 
				if ($type == "object") {
					if (defined("OBJECT_TABLE")) {
						$foo = attributFehltError($arr, "classid", "listview");
						if ($foo)
							return str_replace($tag, $foo, $code);
						$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_listview_object.class.php");
$GLOBALS["lv"] = new we_listview_object("' . $name . '", $we_rows, $we_offset, $we_lv_order, $we_lv_desc,"' . $class . '", $we_lv_cats, $we_lv_catOr, "' . $cond . '", ' . $triggerid . ', "' . $cols . '", ' . ($seeMode ? "true" : "false") . ',$we_lv_se,$we_lv_calendar,$we_lv_datefield,$we_lv_date,$we_lv_weekstart, $we_lv_categoryids, $we_lv_ws, "' . $cfilter . '", "' . $docid . '", "' . $customers . '", "' . $id . '");
';
					}
				
				} else 
					if ($type == "customer") {
						if (defined("CUSTOMER_TABLE")) {
							$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/we_listview_customer.class.php");
$GLOBALS["lv"] = new we_listview_customer("' . $name . '", $we_rows, $we_offset, $we_lv_order, $we_lv_desc, "' . $cond . '", "' . $cols . '", "' . $docid . '");
';
						
						}
					} else 
						if ($type == "multiobject") {
							if (defined("OBJECT_TABLE")) {
								$foo = attributFehltError($arr, "name", "listview");
								if ($foo)
									return str_replace($tag, $foo, $code);
								$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_listview_multiobject.class.php");
$GLOBALS["lv"] = new we_listview_multiobject("' . $name . '", $we_rows, $we_offset, $we_lv_order, $we_lv_desc, $we_lv_cats, $we_lv_catOr, "' . $cond . '", ' . $triggerid . ', "' . $cols . '", ' . ($seeMode ? "true" : "false") . ',$we_lv_se,$we_lv_calendar,$we_lv_datefield,$we_lv_date,$we_lv_weekstart, $we_lv_categoryids, "' . $cfilter . '", "' . $docid . '");
';
							
							}
						} else 
							if ($type == "banner") {
								if (defined("BANNER_TABLE")) {
									$foo = attributFehltError($arr, "path", "listview");
									if ($foo)
										return $foo;
									$php .= 'include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/we_listview_banner.inc.php");
';
									$usefilter = we_getTagAttributeTagParser("usefilter", $arr);
									$path = we_getTagAttributeTagParser("path", $arr);
									$filterdatestart = we_getTagAttributeTagParser(
											"filterdatestart", 
											$arr, 
											"-1");
									$filterdateend = we_getTagAttributeTagParser("filterdateend", $arr, "-1");
									
									$php .= '$customer=' . ($customer ? "true" : "false") . ';
$bannerid = f("SELECT ID FROM ".BANNER_TABLE." WHERE PATH=\'' . mysql_real_escape_string($path) . '\'","ID",new DB_WE());
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/weBanner.php");
if($customer && defined("CUSTOMER_TABLE") && (!weBanner::customerOwnsBanner($_SESSION["webuser"]["ID"],$bannerid))){
	$bannerid=0;
}
$GLOBALS["lv"] = new we_listview_banner("' . $name . '", $we_rows, "' . $order . '", $bannerid, ("' . $usefilter . '" == "true" || "' . $usefilter . '" == "on" || "' . $usefilter . '" == "1" || "' . $usefilter . '" == "usefilter") ? true : false, ' . $filterdatestart . ', ' . $filterdateend . ');
';
								}
							} else 
								if ($type == "shopVariant") {
									
									if (defined("SHOP_TABLE")) {
										
										$defaultname = we_getTagAttributeTagParser("defaultname", $arr, '');
										$docId = we_getTagAttributeTagParser("documentid", $arr, '');
										$objId = we_getTagAttributeTagParser("objectid", $arr, '');
										
										$php .= '
$docId = "' . $docId . '";
$objectId = "' . $objId . '";
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_listview_shopVariants.class.php");
$GLOBALS["lv"] = new we_listview_shopVariants("' . $name . '", $we_rows, "' . $defaultname . '", $docId, $objectId, $we_offset);
';
									}
								
								} else 
									if ($type == "category") {
										
										$categoryids = we_getTagAttributeTagParser("categoryids", $arr, 0);
										$parentid = we_getTagAttributeTagParser("parentid", $arr, 0);
										$parentidname = we_getTagAttributeTagParser('parentidname', $arr);
										
										$php .= '
$categoryids="' . $categoryids . '";
$parentid="' . $parentid . '";
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/we_catListview.class.php");
$GLOBALS["lv"] = new we_catListview("' . $name . '", $we_rows, $we_offset, $we_lv_order , $we_lv_desc, $parentid, $categoryids, "default", "' . $cols . '"' . ($parentidname ? ',"' . $parentidname . '"' : '') . ');
';
									
									} else {
										return $this->replaceTag(
												$tag, 
												$code, 
												parseError(
														sprintf(
																$GLOBALS["l_parser"]["wrong_type"], 
																"listview")));
									}
		$php .= '$lv = clone($GLOBALS["lv"]); // for backwards compatibility
		//prevent error if $GLOBALS["we_lv_array"] is no array
		if (!isset($GLOBALS["we_lv_array"]) || !is_array($GLOBALS["we_lv_array"])) {
			$GLOBALS["we_lv_array"] = array();
		}
		
if(is_array($GLOBALS["we_lv_array"])) array_push($GLOBALS["we_lv_array"],clone($GLOBALS["lv"]));

?>
';
		
		$pre = $this->getStartCacheCode($tag, $attribs);
		$ret = $this->replaceTag($tag, $code, $pre . $php) ;
		return $ret;
	}

	function parseObjectTag($tag, $code, $attribs = "", $postName = "")
	{
		
		if (defined("WE_OBJECT_MODULE_DIR")) {
			
			eval('$arr = array(' . $attribs . ');');
			
			$we_button = new we_button();
			
			$condition = we_getTagAttributeTagParser("condition", $arr, 0);
			$classid = we_getTagAttributeTagParser("classid", $arr);
			$we_oid = we_getTagAttributeTagParser("id", $arr, 0);
			$name = we_getTagAttributeTagParser("name", $arr) . $postName;
			$_showName = we_getTagAttributeTagParser("name", $arr);
			$size = we_getTagAttributeTagParser("size", $arr, 30);
			$triggerid = we_getTagAttributeTagParser("triggerid", $arr, "0");
			$searchable = we_getTagAttributeTagParser("searchable", $arr, "", true);
			
			$php = '<?php

if (!isset($GLOBALS["we_lv_array"])) {
	$GLOBALS["we_lv_array"] = array();
}

include_once(WE_OBJECT_MODULE_DIR . "we_objecttag.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
';
			if ($classid) {
				$php .= '$__id__='.$classid.';$classPath = f("SELECT Path FROM ".OBJECT_TABLE." WHERE ID=".abs($__id__),"Path",$GLOBALS["DB_WE"]);
$rootDirID = f("SELECT ID FROM ".OBJECT_FILES_TABLE." WHERE Path=\'$classPath\'","ID",$GLOBALS["DB_WE"]);
';
			} else {
				$php .= '$rootDirID = 0;
';
			}
			if ($name) {
				if (strpos($name, " ") !== false) {
					return parseError(sprintf($GLOBALS["l_parser"]["name_with_space"], "object"));
				}
				
				$php .= '
		$we_doc = $GLOBALS["we_doc"];
		$we_oid = $we_doc->getElement("' . $name . '") ? $we_doc->getElement("' . $name . '") : ' . $we_oid . ';
		$path = f("SELECT Path FROM ".OBJECT_FILES_TABLE." WHERE ID=\'$we_oid\'","Path",$GLOBALS["DB_WE"]);
		$textname = \'we_\'.$we_doc->Name.\'_txt[' . $name . '_path]\';
		$idname = \'we_\'.$we_doc->Name.\'_txt[' . $name . ']\';
		$table = OBJECT_FILES_TABLE;
		$we_button = new we_button();
		$delbutton = $we_button->create_button("image:btn_function_trash", "javascript:document.forms[0].elements[\'$idname\'].value=0;document.forms[0].elements[\'$textname\'].value=\'\';_EditorFrame.setEditorIsHot(false);we_cmd(\'reload_editpage\');");
		$button    = $we_button->create_button("select", "javascript:we_cmd(\'openDocselector\',document.forms[0].elements[\'$idname\'].value,\'$table\',\'document.forms[\\\'we_form\\\'].elements[\\\'$idname\\\'].value\',\'document.forms[\\\'we_form\\\'].elements[\\\'$textname\\\'].value\',\'opener.we_cmd(\\\'reload_editpage\\\');opener._EditorFrame.setEditorIsHot(true);\',\'".session_id()."\',\'$rootDirID\',\'objectFile\',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).")");

?><?php if($GLOBALS["we_editmode"]): ?>
<table border="0" cellpadding="0" cellspacing="0" background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif">
	<tr>
		<td style="padding:0 6px;"><span style="color: black; font-size: 12px; font-family: Verdana, sans-serif"><b>' . $_showName . '</b></span></td>
		<td><?php print hidden($idname,$we_oid) ?></td>
		<td><?php print htmlTextInput($textname,' . $size . ',$path,"",\' readonly\',"text",0,0); ?></td>
		<td>' . getPixel(6, 4) . '</td>
		<td><?php print $button; ?></td>
		<td>' . getPixel(6, 4) . '</td>
		<td><?php print $delbutton; ?></td>
	</tr>
</table><?php endif ?><?php
';
			} else {
				$php .= '$we_oid=' . $we_oid . ';
$we_oid = $we_oid ? $we_oid : (isset($_REQUEST["we_oid"]) ? $_REQUEST["we_oid"] : 0);
';
			}
			$searchable = empty($searchable) ? 'false' : $searchable;
			$php .= '$GLOBALS["lv"] = new we_objecttag("' . $classid . '",$we_oid,' . $triggerid . ',' . $searchable . ', "' . $condition . '");
$lv = clone($GLOBALS["lv"]); // for backwards compatibility
if(is_array($GLOBALS["we_lv_array"])) array_push($GLOBALS["we_lv_array"],clone($GLOBALS["lv"]));
?><?php if($GLOBALS["lv"]->avail): ?>';
			
			//	Add a sign for Super-Easy-Edit-Mode. to edit an Object.
			$php .= '<?php
		if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem"){
			print "<a href=\"$we_oid\" seem=\"object\"></a>";
		}
		?>';
			
			if ($postName != "") {
				$content = str_replace('$', '\$', $php); //	to test with blocks ...
			}
			
			$pre = $this->getStartCacheCode($tag, $attribs);
			
			return $this->replaceTag($tag, $code, $pre . $php);
		}
	}

	function parseMetadataTag($tag, $code, $attribs = "", $postName = "")
	{
		
		eval('$arr = array(' . $attribs . ');');
		
		$name = we_getTagAttributeTagParser("name", $arr) . $postName;
		
		$foo = attributFehltError($arr, 'name', 'metadata');
		if ($foo)
			return str_replace($tag, $foo, $code);
		
		$php = '<?php

if (!isset($GLOBALS["we_lv_array"])) {
	$GLOBALS["we_lv_array"] = array();
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/metadatatag.class.php");
';
		
		$php .= '$GLOBALS["lv"] = new metadatatag("' . $name . '");
$lv = clone($GLOBALS["lv"]); // for backwards compatibility
if(is_array($GLOBALS["we_lv_array"])) array_push($GLOBALS["we_lv_array"],clone($GLOBALS["lv"]));
?><?php if($GLOBALS["lv"]->avail): ?>';
		
		$pre = $this->getStartCacheCode($tag, $attribs);
		
		return $this->replaceTag($tag, $code, $pre . $php);
	
	}

	function parseCustomerTag($tag, $code, $attribs = "", $postName = "")
	{
		
		if (defined("WE_CUSTOMER_MODULE_DIR")) {
			
			eval('$arr = array(' . $attribs . ');');
			
			$we_button = new we_button();
			
			$condition = we_getTagAttributeTagParser("condition", $arr, 0);
			$we_cid = we_getTagAttributeTagParser("id", $arr, 0);
			$name = we_getTagAttributeTagParser("name", $arr) . $postName;
			$_showName = we_getTagAttributeTagParser("name", $arr);
			$size = we_getTagAttributeTagParser("size", $arr, 30);
			
			$php = '<?php

if (!isset($GLOBALS["we_lv_array"])) {
	$GLOBALS["we_lv_array"] = array();
}

include_once(WE_CUSTOMER_MODULE_DIR . "we_customertag.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
';
			
			if ($name) {
				if (strpos($name, " ") !== false) {
					return parseError(sprintf($GLOBALS["l_parser"]["name_with_space"], "object"));
				}
				
				$php .= '
		$we_doc = $GLOBALS["we_doc"];
		$we_cid = $we_doc->getElement("' . $name . '") ? $we_doc->getElement("' . $name . '") : ' . $we_cid . ';
		$we_cid = $we_cid ? $we_cid : (isset($_REQUEST["we_cid"]) ? $_REQUEST["we_cid"] : 0);
		$path = f("SELECT Path FROM ".CUSTOMER_TABLE." WHERE ID=".abs($we_cid),"Path",$GLOBALS["DB_WE"]);
		$textname = \'we_\'.$we_doc->Name.\'_txt[' . $name . '_path]\';
		$idname = \'we_\'.$we_doc->Name.\'_txt[' . $name . ']\';
		$table = CUSTOMER_TABLE;
		$we_button = new we_button();
		$delbutton = $we_button->create_button("image:btn_function_trash", "javascript:document.forms[0].elements[\'$idname\'].value=0;document.forms[0].elements[\'$textname\'].value=\'\';_EditorFrame.setEditorIsHot(false);we_cmd(\'reload_editpage\');");
		$button    = $we_button->create_button("select", "javascript:we_cmd(\'openSelector\',document.forms[0].elements[\'$idname\'].value,\'$table\',\'document.forms[\\\'we_form\\\'].elements[\\\'$idname\\\'].value\',\'document.forms[\\\'we_form\\\'].elements[\\\'$textname\\\'].value\',\'opener.we_cmd(\\\'reload_editpage\\\');opener._EditorFrame.setEditorIsHot(true);\',\'".session_id()."\',0,\'\',1)");

?><?php if($GLOBALS["we_editmode"]): ?>
<table border="0" cellpadding="0" cellspacing="0" background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif">
	<tr>
		<td style="padding:0 6px;"><span style="color: black; font-size: 12px; font-family: Verdana, sans-serif"><b>' . $_showName . '</b></span></td>
		<td><?php print hidden($idname,$we_cid) ?></td>
		<td><?php print htmlTextInput($textname,' . $size . ',$path,"",\' readonly\',"text",0,0); ?></td>
		<td>' . getPixel(6, 4) . '</td>
		<td><?php print $button; ?></td>
		<td>' . getPixel(6, 4) . '</td>
		<td><?php print $delbutton; ?></td>
	</tr>
</table><?php endif ?><?php
';
			} else {
				$php .= '$we_cid=' . $we_cid . ';
$we_cid = $we_cid ? $we_cid : (isset($_REQUEST["we_cid"]) ? $_REQUEST["we_cid"] : 0);
';
			}
			
			$php .= '$GLOBALS["lv"] = new we_customertag($we_cid,"' . $condition . '");
$lv = clone($GLOBALS["lv"]); // for backwards compatibility
if(is_array($GLOBALS["we_lv_array"])) array_push($GLOBALS["we_lv_array"],clone($GLOBALS["lv"]));
?><?php if($GLOBALS["lv"]->avail): ?>';
			
			if ($postName != "") {
				$content = str_replace('$', '\$', $php); //	to test with blocks ...
			}
			
			$pre = $this->getStartCacheCode($tag, $attribs);
			
			return $this->replaceTag($tag, $code, $pre . $php);
		}
	}

	##########################################################################################
	##########################################################################################
	

	function parserepeatShopitem($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		
		$shopname = we_getTagAttributeTagParser("shopname", $arr);
		
		$php = '<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");
	$_SESSION["we_shopname"]="' . $shopname . '";

    if (!isset($GLOBALS["' . $shopname . '"])||empty($GLOBALS["' . $shopname . '"])) {
    	echo parseError(sprintf($GLOBALS["l_parser"]["missing_createShop"],\'repeatShopItem\'));
    	return;
    }


	$GLOBALS["lv"] = new shop($GLOBALS["' . $shopname . '"]);

	while($GLOBALS["lv"]->next_record()) {
?>';
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	function parsedeleteShop($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		$shopname = we_getTagAttributeTagParser("shopname", $arr);
		
		$php = '<?php
			unset($_SESSION["' . $shopname . '_save"]);
		?>';
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	

	function parsecreateShop($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		$deleteshop = we_getTagAttributeTagParser("deleteshop", $arr);
		$shopname = we_getTagAttributeTagParser("shopname", $arr);
		
		$php = '<?php
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");

			$deleteshop_now = "' . $deleteshop . '";
			if(!isset($_SESSION)) @session_start();

			if(isset($_SESSION["' . $shopname . '_save"]) && (isset($_REQUEST["deleteshop"]) && $_REQUEST["deleteshop"]==1 || $deleteshop_now =="1")) { // delete shop
				unset($_SESSION["' . $shopname . '_save"]);
				if(isset($follow) && (!empty($follow))) {  // we have to check where $follow is set ????
					header("Location: ".$follow);
					exit;
				}
			}

			$GLOBALS["' . $shopname . '"] = new Basket;
			$GLOBALS["' . $shopname . '"]->Basket();
			$GLOBALS["' . $shopname . '"]->setCartProperties( (isset($_SESSION["' . $shopname . '_save"]) ? $_SESSION["' . $shopname . '_save"] : array() ) );
			$GLOBALS["' . $shopname . '"]->initCartFields();
			$' . $shopname . ' = $GLOBALS["' . $shopname . '"];
			$_SESSION["' . $shopname . '_save"] = $' . $shopname . '->getCartProperties();
		?>';
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	function parseadddelShopitem($tag, $code, $attribs = "")
	{
		
		$php = '';
		
		if (defined('SHOP_TABLE')) {
			
			eval('$arr = array(' . $attribs . ');');
			
			$shopname = we_getTagAttributeTagParser("shopname", $arr);
			
			$php = '<?php
		
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");
	
			if((isset($_REQUEST["shopname"]) && $_REQUEST["shopname"]=="' . $shopname . '") || !isset($_REQUEST["shopname"]) || $_REQUEST["shopname"]==""){
				if ( isset($_REQUEST["shop_cart_id"]) && is_array($_REQUEST["shop_cart_id"]) ) {
					if($_REQUEST["t"] > (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
						if($_REQUEST["t"] != (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
							foreach ($_REQUEST["shop_cart_id"] as $cart_id => $cart_amount) {
								$' . $shopname . '->Set_Cart_Item($cart_id, $cart_amount);
								$_SESSION["' . $shopname . '_save"] = $' . $shopname . '->getCartProperties();
							}
						}
					}
				}
				else if(isset($_REQUEST["shop_anzahl_und_id"]) && is_array($_REQUEST["shop_anzahl_und_id"])) {
					if($_REQUEST["t"] > (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
						if($_REQUEST["t"] != (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
							//	reset the Array
							reset($_REQUEST["shop_anzahl_und_id"]);
							while(list($shop_articleid_variant,$shop_anzahl)=each($_REQUEST["shop_anzahl_und_id"])) {
								$articleInfo = explode("_",$shop_articleid_variant);
								$shop_artikelid = $articleInfo[0];
								$shop_artikeltype = $articleInfo[1];
								$shop_variant = (isset($articleInfo[2]) ? $articleInfo[2] : "");
								$' . $shopname . '->Set_Item($shop_artikelid,$shop_anzahl,$shop_artikeltype, $shop_variant);
								$_SESSION["' . $shopname . '_save"] = $' . $shopname . '->getCartProperties();
								unset($articleInfo);
							}
						}
						$_SESSION["tb"]=$_REQUEST["t"];
					}
				}
				else if(isset($_REQUEST["shop_artikelid"]) && $_REQUEST["shop_artikelid"] != "" && isset($_REQUEST["shop_anzahl"]) && $_REQUEST["shop_anzahl"] != 0) {
					if($_REQUEST["t"] > (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0) ) {
						if($_REQUEST["t"] != (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0) ) {
							$' . $shopname . '->Add_Item($_REQUEST["shop_artikelid"],$_REQUEST["shop_anzahl"], $_REQUEST["type"], (isset($_REQUEST["' . WE_SHOP_VARIANT_REQUEST . '"]) ? $_REQUEST["' . WE_SHOP_VARIANT_REQUEST . '"] : ""), ( ( isset($_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"]) && is_array($_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"]) ) ? $_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"] : array() ) );
							$_SESSION["' . $shopname . '_save"] = $' . $shopname . '->getCartProperties();
						}
						$_SESSION["tb"]=$_REQUEST["t"];
					}
				}
				else if(isset($_REQUEST["del_shop_artikelid"]) && $_REQUEST["del_shop_artikelid"] != "") {
					if($_REQUEST["t"] > (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
						if($_REQUEST["t"] != (isset($_SESSION["tb"]) ? $_SESSION["tb"] : 0 ) ) {
							$' . $shopname . '->Del_Item($_REQUEST["del_shop_artikelid"], $_REQUEST["type"], (isset($_REQUEST["' . WE_SHOP_VARIANT_REQUEST . '"]) ? $_REQUEST["' . WE_SHOP_VARIANT_REQUEST . '"] : ""), ( ( isset($_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"]) && is_array($_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"]) ) ? $_REQUEST["' . WE_SHOP_ARTICLE_CUSTOM_FIELD . '"] : array() ) );
							$_SESSION["' . $shopname . '_save"] = $' . $shopname . '->getCartProperties();
						}
						$_SESSION["tb"]=$_REQUEST["t"];
					}
				}
			}
			?>';
		}
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	

	function parseFormmailTag($tag, $code, $attribs = "")
	{
		
		eval('$arr = array(' . $attribs . ');');
		$filename = (WEBEDITION_DIR . "we_formmail.php");
		$php = '<?php
		include($_SERVER["DOCUMENT_ROOT"] . "' . $filename . '");
	?>';
		return $this->replaceTag($tag, $code, $php);
	
	}

	##########################################################################################
	##########################################################################################
	

	function parseFormTag($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		
		$method = we_getTagAttributeTagParser("method", $arr, "post");
		$id = we_getTagAttributeTagParser("id", $arr);
		$action = we_getTagAttributeTagParser("action", $arr);
		$classid = we_getTagAttributeTagParser("classid", $arr);
		$parentid = we_getTagAttributeTagParser("parentid", $arr);
		$doctype = we_getTagAttributeTagParser("doctype", $arr);
		$type = we_getTagAttributeTagParser("type", $arr);
		$tid = we_getTagAttributeTagParser("tid", $arr);
		$categories = we_getTagAttributeTagParser("categories", $arr);
		$onsubmit = we_getTagAttributeTagParser("onsubmit", $arr);
		$onsubmit = we_getTagAttributeTagParser("onSubmit", $arr, $onsubmit);
		$onsuccess = we_getTagAttributeTagParser("onsuccess", $arr);
		$onerror = we_getTagAttributeTagParser("onerror", $arr);
		$onmailerror = we_getTagAttributeTagParser("onmailerror", $arr);
		$confirmmail = we_getTagAttributeTagParser("confirmmail", $arr);
		$preconfirm = we_getTagAttributeTagParser("preconfirm", $arr);
		$postconfirm = we_getTagAttributeTagParser("postconfirm", $arr);
		$order = we_getTagAttributeTagParser("order", $arr);
		$required = we_getTagAttributeTagParser("required", $arr);
		$remove = we_getTagAttributeTagParser("remove", $arr);
		$subject = we_getTagAttributeTagParser("subject", $arr);
		$recipient = we_getTagAttributeTagParser("recipient", $arr);
		$mimetype = we_getTagAttributeTagParser("mimetype", $arr);
		$from = we_getTagAttributeTagParser("from", $arr);
		$charset = we_getTagAttributeTagParser("charset", $arr);
		$xml = we_getTagAttributeTagParser("xml", $arr);
		$formname = we_getTagAttributeTagParser("name", $arr, "we_global_form");
		$onrecipienterror = we_getTagAttributeTagParser("onrecipienterror", $arr);
		$forcefrom = we_getTagAttributeTagParser("forcefrom", $arr, "", false);
		$captchaname = we_getTagAttributeTagParser("captchaname", $arr);
		$oncaptchaerror = we_getTagAttributeTagParser("oncaptchaerror", $arr);
		$enctype = we_getTagAttributeTagParser("enctype", $arr);
		
		$formAttribs = removeAttribs(
				$arr, 
				array(
					
						'onsubmit', 
						'onSubmit', 
						'name', 
						'method', 
						'xml', 
						'charset', 
						'id', 
						'action', 
						'order', 
						'required', 
						'onsuccess', 
						'onerror', 
						'type', 
						'recipient', 
						'mimetype', 
						'subject', 
						'onmailerror', 
						'preconfirm', 
						'postconfirm', 
						'from', 
						'confirmmail', 
						'classid', 
						'doctype', 
						'remove', 
						'onrecipienterror', 
						'tid', 
						'forcefrom', 
						'categories'
				));
		
		$formAttribs['xml'] = $xml;
		$formAttribs['method'] = $method;
		
		if ($id && ($id != "self")) {
			$php = '<?php $__id__ = ' . $id . ';$GLOBALS["we_form_action"] = f("SELECT Path FROM ".FILE_TABLE." WHERE ID=".abs($__id__),"Path",$GLOBALS["DB_WE"]); ?>
';
		} else 
			if ($action) {
				$php = '<?php $GLOBALS["we_form_action"] = "' . $action . '"; ?>
';
			} else {
				$php = '<?php $GLOBALS["we_form_action"] = $_SERVER["PHP_SELF"]; ?>
';
			}
		if ($type != "search") {
			if (eregi('^(.*)return (.+)$', $onsubmit, $regs)) {
				$onsubmit = $regs[1] . ';if(self.weWysiwygSetHiddenText){weWysiwygSetHiddenText();};return ' . $regs[2];
			} else {
				$onsubmit .= ';if(self.weWysiwygSetHiddenText){weWysiwygSetHiddenText();};return true;';
			}
		}
		switch ($type) {
			case "shopliste" :
				$formAttribs['action'] = '<?php print $GLOBALS["we_form_action"]; ?>';
				$formAttribs['name'] = 'form<?php print (isset($GLOBALS["lv"]) && isset($GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1]) && strlen($GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1])) ? $GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1] : $we_doc->ID; ?>';
				$php .= '<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]) : ?>' . getHtmlTag(
						'form', 
						$formAttribs, 
						'', 
						false, 
						true) . getHtmlTag(
						'input', 
						array(
							
								'xml' => $xml, 
								'type' => 'hidden', 
								'name' => 'type', 
								'value' => '<?php if( isset($GLOBALS["lv"]->classID) ){ echo "o"; }else if( isset($GLOBALS["lv"]->ID) ){ echo "w"; }else if( (isset($GLOBALS["we_doc"]->ClassID) || isset($GLOBALS["we_doc"]->ObjectID) )){echo "o";}else if($GLOBALS["we_doc"]->ID){ echo "w"; } ?>'
						)) . getHtmlTag(
						'input', 
						array(
							
								'xml' => $xml, 
								'type' => 'hidden', 
								'name' => 'shop_artikelid', 
								'value' => '<?php if(isset($GLOBALS["lv"]->classID) || isset($GLOBALS["we_doc"]->ClassID) || isset($GLOBALS["we_doc"]->ObjectID)){ echo (isset($GLOBALS["lv"]) && $GLOBALS["lv"]->DB_WE->Record["OF_ID"]!="") ? $GLOBALS["lv"]->DB_WE->Record["OF_ID"] : (isset($we_doc->DB_WE->Record["OF_ID"]) ? $we_doc->DB_WE->Record["OF_ID"] : (isset($we_doc->OF_ID) ? $we_doc->OF_ID : $we_doc->ID)); }else { echo (isset($GLOBALS["lv"]) && isset($GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1]) && $GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1]!="") ? $GLOBALS["lv"]->IDs[$GLOBALS["lv"]->count-1] : $we_doc->ID; } ?>'
						)) . getHtmlTag(
						'input', 
						array(
							
								'xml' => $xml, 
								'type' => 'hidden', 
								'name' => 'we_variant', 
								'value' => '<?php print (isset($GLOBALS["we_doc"]->Variant) ? $GLOBALS["we_doc"]->Variant : ""); ?>'
						)) . getHtmlTag(
						'input', 
						array(
							
								'xml' => $xml, 
								'type' => 'hidden', 
								'name' => 't', 
								'value' => '<?php echo time(); ?>'
						)) . '<?php endif ?>';
				break;
			case "object" :
			case "document" :
				$php .= '<?php if(!isset($_REQUEST["edit_' . $type . '"])): ?><?php if(isset($GLOBALS["WE_SESSION_START"]) && $GLOBALS["WE_SESSION_START"]){ unset($_SESSION["we_' . $type . '_session_' . $formname . '"] );} ?><?php endif ?>
';
				$formAttribs['onsubmit'] = $onsubmit;
				$formAttribs['name'] = $formname;
				$formAttribs['action'] = '<?php print $GLOBALS["we_form_action"]; ?>';
				
				if ($enctype) {
					$formAttribs['enctype'] = $enctype;
				}
				
				if ($classid || $doctype) {
					$php .= '<?php $GLOBALS["WE_FORM"] = "' . $formname . '"; ?>';
					$php .= '<?php
if (!$GLOBALS["we_doc"]->InWebEdition) {
';
					if ($type == "object") {
						
						$php .= 'initObject(' . $classid . ',"' . $formname . '","' . $categories . '","' . $parentid . '");
';
					} else {
						$php .= 'initDocument("' . $formname . '","' . $tid . '","' . $doctype . '","' . $categories . '");
';
					}
					$php .= '
}
?>
';
					$typetmp = (($type == "object") ? "Object" : "Document");
					
					$php .= '<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?>' . getHtmlTag(
							'form', 
							$formAttribs, 
							'', 
							false, 
							true) . getHtmlTag(
							'input', 
							array(
								'type' => 'hidden', 'name' => 'edit_' . $type, 'value' => 1, 'xml' => $xml
							)) . getHtmlTag(
							'input', 
							array(
								
									'type' => 'hidden', 
									'name' => 'we_edit' . $typetmp . '_ID', 
									'value' => '<?php print isset($_REQUEST["we_edit' . $typetmp . '_ID"]) ? ($_REQUEST["we_edit' . $typetmp . '_ID"]) : 0; ?>', 
									'xml' => $xml
							)) . '<?php endif ?>';
				} else {
					$php .= '<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?>' . getHtmlTag(
							'form', 
							$formAttribs, 
							'', 
							false, 
							true) . '<?php endif ?>';
				}
				break;
			case "formmail" :
				$successpage = $onsuccess ? '<?php print f("SELECT Path FROM ".FILE_TABLE." WHERE ID=' . $onsuccess . '","Path",$GLOBALS["DB_WE"]); ?>' : '';
				$errorpage = $onerror ? '<?php print f("SELECT Path FROM ".FILE_TABLE." WHERE ID=' . $onerror . '","Path",$GLOBALS["DB_WE"]); ?>' : '';
				$mailerrorpage = $onmailerror ? '<?php print f("SELECT Path FROM ".FILE_TABLE." WHERE ID=' . $onmailerror . '","Path",$GLOBALS["DB_WE"]); ?>' : '';
				$recipienterrorpage = $onrecipienterror ? '<?php print f("SELECT Path FROM ".FILE_TABLE." WHERE ID=' . $onrecipienterror . '","Path",$GLOBALS["DB_WE"]); ?>' : '';
				$captchaerrorpage = $oncaptchaerror ? '<?php print f("SELECT Path FROM ".FILE_TABLE." WHERE ID=' . $oncaptchaerror . '","Path",$GLOBALS["DB_WE"]); ?>' : '';
				
				if ($confirmmail == "true") {
					$confirmmail = true;
					$preconfirm = $preconfirm ? '<?php print str_replace("\'","\\\'",$we_doc->getElement("' . $preconfirm . '")); ?>' : '';
					$postconfirm = $postconfirm ? '<?php print str_replace("\'","\\\'",$we_doc->getElement("' . $postconfirm . '")); ?>' : '';
				} else {
					$confirmmail = false;
					$postconfirm = '';
					$preconfirm = '';
				}
				
				$formAttribs['name'] = $formname;
				$formAttribs['onsubmit'] = $onsubmit;
				/*				$formAttribs['action'] = '<?php print WEBEDITION_DIR ?>we_formmail.php';  */
				$formAttribs['action'] = '<?php print WEBEDITION_DIR ?>we_formmail.php';
				$formAttribs['action'] = ($id && ($id != "self")) ? '<?php print(f("SELECT Path FROM ".FILE_TABLE." WHERE ID=\'' . $id . '\'","Path",$GLOBALS["DB_WE"])); ?>' : '<?php print isset($GLOBALS["we_form_action"]) && $GLOBALS["we_form_action"] ? $GLOBALS["we_form_action"] : (WEBEDITION_DIR."we_formmail.php"); ?>';
				/*
				if($id && ($id != "self")){
					$php = '<?php $action = f("SELECT Path FROM ".FILE_TABLE." WHERE ID=\''.$id.'\'","Path",$GLOBALS["DB_WE"]); ?>';
				}
*/
				
				//  now prepare all needed hidden-fields:
				$php = '<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?>
				            ' . getHtmlTag('form', $formAttribs, "", false, true) . '
				            <?php
				            	$_recipientString = "' . $recipient . '";
				            	$_recipientArray = explode(",", $_recipientString);
				            	foreach ($_recipientArray as $_key=>$_val) {
				            		$_recipientArray[$_key] = "\"" . trim($_val) . "\"";
				            	}
				            	$_recipientString = implode(",", $_recipientArray);
				           		
				            	$_ids = array();
				            	$GLOBALS["DB_WE"]->query("SELECT * FROM " . RECIPIENTS_TABLE . " WHERE Email IN(" . $_recipientString . ")");
				            	while ($GLOBALS["DB_WE"]->next_record()) {
				            		$_ids[] = $GLOBALS["DB_WE"]->f("ID");
				            	}
				            	
				            	$_recipientIdString = "";
				            	if (count($_ids)) {
				            		$_recipientIdString = implode(",", $_ids);
				            	}
				            
				            ?>
				            <div class="weHide" style="display: none;">
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'order', 
								'value' => '<?php print "' . $order . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'required', 
								'value' => '<?php print "' . $required . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'subject', 
								'value' => '<?php print "' . $subject . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'recipient', 
								'value' => '<?php print $_recipientIdString; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'mimetype', 
								'value' => '<?php print "' . $mimetype . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'from', 
								'value' => '<?php print "' . $from . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							'type' => 'hidden', 'name' => 'error_page', 'value' => $errorpage, 'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'mail_error_page', 
								'value' => $mailerrorpage, 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'recipient_error_page', 
								'value' => $recipienterrorpage, 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							'type' => 'hidden', 'name' => 'ok_page', 'value' => $successpage, 'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'charset', 
								'value' => '<?php print "' . $charset . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'confirm_mail', 
								'value' => '<?php print "' . $confirmmail . '"; ?>', 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'pre_confirm', 
								'value' => $preconfirm, 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'post_confirm', 
								'value' => $postconfirm, 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							'type' => 'hidden', 'name' => 'we_remove', 'value' => $remove, 'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							'type' => 'hidden', 'name' => 'forcefrom', 'value' => $forcefrom, 'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'captcha_error_page', 
								'value' => $captchaerrorpage, 
								'xml' => $xml
						)) . '
                                ' . getHtmlTag(
						'input', 
						array(
							
								'type' => 'hidden', 
								'name' => 'captchaname', 
								'value' => $captchaname, 
								'xml' => $xml
						)) . '
			                 </div>
				        <?php endif ?>';
				break;
			default :
				
				$formAttribs['name'] = $formname;
				$formAttribs['onsubmit'] = $onsubmit;
				$formAttribs['action'] = '<?php print $GLOBALS["we_form_action"]; ?>';
				
				$php .= '<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?>' . getHtmlTag(
						'form', 
						$formAttribs, 
						"", 
						false, 
						true) . "<?php endif ?>\n";
		}
		
		$pre = $this->getStartCacheCode($tag, $attribs);
		
		return $this->replaceTag($tag, $code, $pre . $php);
	}

	/**
	 * @return string
	 * @param string $tag
	 * @param string $code
	 * @desc removes the complete tag from the template. Information is only saved in database
	 *		used to remove we:hidePages and we:controlElement
	 */
	function parseRemoveTags($tag, $code)
	{
		
		return $this->replaceTag($tag, $code, '');
	}

	function parseTrTag($tag, $code, $attribs = "")
	{
		eval('$arr = array(' . $attribs . ');');
		
		$php = '<?php if($GLOBALS["lv"]->shouldPrintStartTR()): ?>' . getHtmlTag('tr', $arr, "", false, true) . '<?php endif ?>';
		
		$pre = $this->getStartCacheCode($tag, $attribs);
		
		return $this->replaceTag($tag, $code, $pre . $php);
	
	}

	function parseXMLNode($tag, $code, $attribs)
	{
		
		eval('$attr = array(' . $attribs . ');');
		
		$foo = attributFehltError($attr, "xpath", "xmlnode");
		if ($foo)
			return str_replace($tag, $foo, $code);
		
		$php = "<?php ";
		
		$unq = uniqid(rand());
		
		$feed_name = "feed_" . $unq;
		$got_name = "got_" . $unq;
		$c_name = "c_" . $unq;
		$otac_name = "otac_" . $unq;
		$nodes_name = "nodes_" . $unq;
		$out_name = "node_" . $unq;
		$ind_name = "ind_" . $unq;
		$node_name = "node_" . $unq;
		$parent_name = "parent_" . $unq;
		$pind_name = "pind_" . $unq;
		
		$php .= '
		$' . $out_name . '="";
		if(!isset($GLOBALS["xpaths"])) $GLOBALS["xpaths"]=array();
		if(!isset($GLOBALS["xstack"])) $GLOBALS["xstack"]=array();
		$' . $pind_name . '=count($GLOBALS["xstack"])-1;
		if($' . $pind_name . '<0){
			$' . $pind_name . '=0;
			$' . $parent_name . '="";
		}
		else{
			$' . $parent_name . '=$GLOBALS["xstack"][$' . $pind_name . '];
		}

		$' . $ind_name . '=count($GLOBALS["xpaths"])+1;
		$GLOBALS["xpaths"][$' . $ind_name . ']=array();
		$GLOBALS["xpaths"][$' . $ind_name . ']["xpath"]="' . $attr["xpath"] . '";
		$GLOBALS["xpaths"][$' . $ind_name . ']["parent"]=$' . $parent_name . ' ;

		$' . $got_name . '=false;

		';
		
		// find feed
		if (isset($attr["url"])) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_exim/weXMLBrowser.class.php");
			$php .= '
			$' . $feed_name . '=new weXMLBrowser("' . $attr["url"] . '");
			$GLOBALS["xpaths"][$' . $ind_name . ']["url"]="' . $attr["url"] . '";
			$' . $got_name . '=true;
			';
		} else 
			if (isset($attr["feed"])) {
				$php .= '
			$' . $feed_name . '=$GLOBALS["xmlfeeds"]["' . $attr["feed"] . '"];
			$GLOBALS["xpaths"][$' . $ind_name . ']["feed"]="' . $attr["feed"] . '";
			$' . $got_name . '=true;
			';
			} else {
				$php .= '
			$' . $got_name . '=false;
			$' . $c_name . '=0;

			if(!empty($' . $parent_name . ')){
				for($' . $c_name . '=$' . $pind_name . ';$' . $c_name . '>-1;$' . $c_name . '--){
					$' . $otac_name . '=$GLOBALS["xstack"][$' . $c_name . '];
					if(isset($GLOBALS["xpaths"][$' . $otac_name . '])){
						if(isset($GLOBALS["xpaths"][$' . $otac_name . ']["url"]) && !empty($GLOBALS["xpaths"][$' . $otac_name . ']["url"])){
							$' . $feed_name . '=new weXMLBrowser($GLOBALS["xpaths"][$' . $otac_name . ']["url"]);
							$GLOBALS["xpaths"][$' . $ind_name . ']["url"]=$GLOBALS["xpaths"][$' . $otac_name . ']["url"];
							$' . $got_name . '=true;
						}
						if(isset($GLOBALS["xpaths"][$' . $otac_name . ']["feed"]) && !empty($GLOBALS["xpaths"][$' . $otac_name . ']["feed"])){
							$' . $feed_name . '=$GLOBALS["xmlfeeds"][$GLOBALS["xpaths"][$' . $otac_name . ']["feed"]];
							$GLOBALS["xpaths"][$' . $ind_name . ']["feed"]=$GLOBALS["xpaths"][$' . $otac_name . ']["feed"];
							$' . $got_name . '=true;
						}
					}
				}
			}
			';
			}
		
		$php .= '
		$' . $nodes_name . '=array();
		if($' . $got_name . '){
			if(isset($GLOBALS["xsuperparent"])){
				$' . $nodes_name . '=$' . $feed_name . '->evaluate($GLOBALS["xsuperparent"]."/".$GLOBALS["xpaths"][$' . $ind_name . ']["xpath"]);
			}
			if(count($' . $nodes_name . ')==0){
				$' . $nodes_name . '=$' . $feed_name . '->evaluate($GLOBALS["xpaths"][$' . $ind_name . ']["xpath"]);
			}
			if(count($' . $nodes_name . ')==0){
				if(!empty($' . $parent_name . ')){
					for($' . $c_name . '=$' . $pind_name . ';$' . $c_name . '>-1;$' . $c_name . '--){
						$' . $otac_name . '=$GLOBALS["xstack"][$' . $c_name . '];
						if(isset($GLOBALS["xpaths"][$' . $otac_name . '])){
							if(isset($GLOBALS["xpaths"][$' . $otac_name . ']["xpath"]) && !empty($GLOBALS["xpaths"][$' . $otac_name . ']["xpath"])){
								$GLOBALS["xpaths"][$' . $ind_name . ']["xpath"]=$GLOBALS["xpaths"][$' . $otac_name . ']["xpath"]."/".$GLOBALS["xpaths"][$' . $ind_name . ']["xpath"];
								$' . $nodes_name . '=$' . $feed_name . '->evaluate($GLOBALS["xpaths"][$' . $ind_name . ']["xpath"]);
							}
						}
					}
				}
			}
			if(count($' . $nodes_name . ')!=0) $' . $got_name . '=true;
			else  $' . $got_name . '=true;
		}

		array_push($GLOBALS["xstack"],$' . $ind_name . ');

		foreach ($' . $nodes_name . ' as $' . $node_name . '){
			if(!$' . $feed_name . '->hasChildNodes($' . $node_name . ')){
				print $' . $feed_name . '->getData($' . $node_name . ');
			}else{
				$GLOBALS["xsuperparent"]=$' . $node_name . ';

		';
		
		return $this->replaceTag($tag, $code, $php . ' ?>');
	
	}

	function parseVotingTag($tag, $code, $attribs)
	{
		eval('$arr = array(' . $attribs . ');');
		
		$id = we_getTagAttributeTagParser("id", $arr, 0);
		$name = we_getTagAttributeTagParser("name", $arr, '');
		$version = we_getTagAttributeTagParser("version", $arr, 0);
		
		$foo = attributFehltError($arr, 'name', 'voting');
		if ($foo)
			return str_replace($tag, $foo, $code);
		
		$version = ($version > 0) ? ($version - 1) : 0;
		
		$php = '<?php
					include_once($_SERVER["DOCUMENT_ROOT"] . \'/webEdition/we/include/we_modules/voting/weVoting.php\');

					$GLOBALS["_we_voting_namespace"] = "' . $name . '";
					$GLOBALS[\'_we_voting\'] = new weVoting();

					if(isset($GLOBALS[\'we_doc\']->elements[$GLOBALS[\'_we_voting_namespace\']][\'dat\'])) {
						$GLOBALS[\'_we_voting\'] = new weVoting($GLOBALS[\'we_doc\']->elements[$GLOBALS[\'_we_voting_namespace\']][\'dat\']);
					} else if(' . $id . '!=0) {
						$GLOBALS[\'_we_voting\'] = new weVoting(' . $id . ');
					} else {
						$__voting_matches = array();
						if(preg_match_all(\'/_we_voting_answer_([0-9]+)_?([0-9]+)?/\', implode(\',\',array_keys($_REQUEST)), $__voting_matches)){
							$GLOBALS[\'_we_voting\'] = new weVoting($__voting_matches[1][0]);
						}
					}
					if(isset($GLOBALS[\'_we_voting\'])) $GLOBALS[\'_we_voting\']->setDefVersion(' . $version . ');
				?>';
		
		return $this->replaceTag($tag, $code, $php);
	
	}

	function parseVotingListTag($tag, $code, $attribs)
	{
		eval('$arr = array(' . $attribs . ');');
		
		$name = we_getTagAttributeTagParser('name', $arr, '');
		$groupid = we_getTagAttributeTagParser('groupid', $arr, 0);
		$rows = we_getTagAttributeTagParser('rows', $arr, 0);
		$desc = we_getTagAttributeTagParser('desc', $arr, "false");
		$order = we_getTagAttributeTagParser('order', $arr, 'PublishDate');
		$subgroup = we_getTagAttributeTagParser("subgroup", $arr, "false");
		$version = we_getTagAttributeTagParser("version", $arr, 1);
		$offset = we_getTagAttributeTagParser("offset", $arr, 0);
		
		$foo = attributFehltError($arr, 'name', 'votingList');
		if ($foo)
			return str_replace($tag, $foo, $code);
		
		$version = ($version > 0) ? ($version - 1) : 0;
		$GLOBALS['_we_voting_list_active'] = 1;
		
		$php = '<?php
			include_once($_SERVER["DOCUMENT_ROOT"] . \'/webEdition/we/include/we_modules/voting/weVotingList.php\');
			$GLOBALS[\'_we_voting_list\'] = new weVotingList(\'' . $name . '\',' . $groupid . ',' . $version . ',' . $rows . ', ' . $offset . ',' . $desc . ',"' . $order . '",' . $subgroup . ');
		?>';
		
		return $this->replaceTag($tag, $code, $php);
	}

	function parseAnswersTag($tag, $code, $attribs)
	{
		
		$php = '<?php
			while(isset($GLOBALS["_we_voting"]) && $GLOBALS["_we_voting"]->getNext()){

		?>';
		
		return $this->replaceTag($tag, $code, $php);
	}

	##########################################################################################
	##########################################################################################
	function parseCaptchaTag($tag, $code, $attribs = "")
	{
		eval('$attribs = array(' . $attribs . ');');
		
		$width = we_getTagAttributeTagParser('width', $attribs, 100);
		$height = we_getTagAttributeTagParser('height', $attribs, 25);
		$path = we_getTagAttributeTagParser('path', $attribs, '/');
		
		$maxlength = we_getTagAttributeTagParser('maxlength', $attribs, 5);
		$type = we_getTagAttributeTagParser('type', $attribs, 'gif');
		
		$font = we_getTagAttributeTagParser('font', $attribs, '');
		$fontpath = we_getTagAttributeTagParser('fontpath', $attribs, '');
		$fontsize = we_getTagAttributeTagParser('fontsize', $attribs, '14');
		$fontcolor = we_getTagAttributeTagParser('fontcolor', $attribs, '#000000');
		
		$angle = we_getTagAttributeTagParser('angle', $attribs, '0');
		
		$subset = we_getTagAttributeTagParser('subset', $attribs, 'alphanum');
		$case = we_getTagAttributeTagParser('case', $attribs, 'mix');
		$skip = we_getTagAttributeTagParser('skip', $attribs, 'i,I,l,L,0,o,O,1,g,9');
		
		$valign = we_getTagAttributeTagParser('valign', $attribs, 'random');
		$align = we_getTagAttributeTagParser('align', $attribs, 'random');
		
		$bgcolor = we_getTagAttributeTagParser('bgcolor', $attribs, '#ffffff');
		$transparent = we_getTagAttributeTagParser('transparent', $attribs, false, true);
		
		$style = we_getTagAttributeTagParser('style', $attribs, '');
		$stylecolor = we_getTagAttributeTagParser('stylecolor', $attribs, '#cccccc');
		$stylenumber = we_getTagAttributeTagParser('stylenumber', $attribs, '5,10');
		$xml = we_getTagAttributeTagParser('xml', $attribs, '5,10');
		
		// writing the temporary document
		$file = $path . "we_captcha_" . $GLOBALS['we_doc']->ID . ".php";
		
		$fh = fopen($_SERVER['DOCUMENT_ROOT'] . $file, "w+");
		$php = '<?php' . "\n" . "\n" . 'require_once($_SERVER["DOCUMENT_ROOT"]."' . WEBEDITION_DIR . 'we/include/we_classes/captcha/captchaImage.class.php");' . "\n" . 'require_once($_SERVER["DOCUMENT_ROOT"]."' . WEBEDITION_DIR . 'we/include/we_classes/captcha/captchaMemory.class.php");' . "\n" . 'require_once($_SERVER["DOCUMENT_ROOT"]."' . WEBEDITION_DIR . 'we/include/we_classes/captcha/captcha.class.php");' . "\n" . "\n" . "\$image = new CaptchaImage(" . $width . ", " . $height . ", " . $maxlength . ");\n";
		if ($fontpath != "") {
			$php .= "\$image->setFontPath('" . $fontpath . "');\n";
		}
		$php .= "\$image->setFont('" . $font . "', '" . $fontsize . "', '" . $fontcolor . "');\n" . "\$image->setCharacterSubset('" . $subset . "', '" . $case . "', '" . $skip . "');\n" . "\$image->setAlign('" . $align . "');\n" . "\$image->setVerticalAlign('" . $valign . "');\n";
		if (isset($bgcolor) && $transparent) {
			$php .= "\$image->setBackground('" . $bgcolor . "', true);\n";
			$type = "gif";
		} else {
			$php .= "\$image->setBackground('" . $bgcolor . "');\n";
		}
		$php .= "\$image->setStyle('" . $style . "', '" . $stylecolor . "', '" . $stylenumber . "');\n" . "\$image->setAngleRange('" . $angle . "');\n" . "Captcha::display(\$image, '" . $type . "');\n" . "\n" . "?>";
		fputs($fh, $php);
		fclose($fh);
		
		// clean attribs
		$attribs = removeAttribs(
				$attribs, 
				array(
					
						'path', 
						'maxlength', 
						'type', 
						'font', 
						'fontpath', 
						'fontsize', 
						'fontcolor', 
						'angle', 
						'subset', 
						'case', 
						'skip', 
						'align', 
						'valign', 
						'bgcolor', 
						'transparent', 
						'style', 
						'stylecolor', 
						'stylenumber'
				));
		
		$attribs['src'] = $file . "?r=" . md5(md5(time()) . session_id());
		
		return $this->replaceTag($tag, $code, getHtmlTag("img", $attribs));
	
	}

	function parseCacheIfTag($content)
	{
		
		$notInListview = !isset($GLOBALS["weListviewCacheActiveIf"]) || $GLOBALS["weListviewCacheActiveIf"] <= 0;
		
		// caching type
		if (isset($GLOBALS['we_doc']) && $notInListview && isset($GLOBALS['we_doc']->CacheType) && $GLOBALS['we_doc']->CacheType == "document" && $GLOBALS['we_doc']->CacheLifeTime > 0) {
			return "<?php echo '" . $content . "'; ?>";
			
		// caching disabled
		} else {
			return $content;
		
		}
	
	}

	function parseNoCacheTag($content)
	{
		
		if ($GLOBALS['we_doc']->CacheType == "document" && $GLOBALS['we_doc']->CacheLifeTime > 0) {
			$content = str_replace("\$", "\\\$", $content);
			
			return "<?php
\$temp = <<<NOCACHE
$content
NOCACHE;

we_tag(\"noCache\", array(), \$temp);

?>
";
		} else {
			return $content;
		
		}
	
	}

}

?>