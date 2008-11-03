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

class we_browserDetect
{

	var $br = "unknown";

	var $ua = "";

	var $v = 0;

	var $sys = "unknown";

	function we_browserDetect($ua = "")
	{
		
		$this->ua = $ua ? $ua : $_SERVER["HTTP_USER_AGENT"];
		$regs = array();
		if (eregi('^([^ ]+) ([^\(]*)(\([^\)]+\))(.*)$', $this->ua, $regs)) {
			$pre = $regs[1];
			$mid = $regs[2];
			$bracket = $regs[3];
			$bracket = ereg_replace('[\(\)]', '', $bracket);
			$brArr = explode(";", $bracket);
			$post = $regs[4];
			
			list($bez, $prever) = explode("/", $pre);
			
			if (strtolower($bez) == "lynx") {
				$this->br = "lynx";
			} else 
				if (strtolower($bez) == "mozilla") {
					if (eregi('msie (.*)$', trim($brArr[1]), $regs) && (trim($post) == "" || eregi('.net', $post))) {
						$this->br = "ie";
						$this->v = $regs[1];
						$this->_getSys($bracket);
					} else 
						if (eregi('konqueror/(.*)$', trim($brArr[1]), $regs)) {
							$this->br = "konqueror";
							$this->v = $regs[1];
							$this->_getSys($bracket);
						} else 
							if (eregi('galeon/(.*)$', trim($brArr[1]), $regs)) {
								$this->br = "unknown";
								$this->v = $regs[1];
								$this->_getSys($bracket);
							} else {
								if (eregi('netscape6', $post)) {
									$this->br = "nn";
									if (eregi('netscape6/(.+)', $post, $regs)) {
										$this->v = trim($regs[1]);
									} else {
										$this->v = 6;
									}
									$this->_getSys($bracket);
								} else 
									if (eregi('netscape/7', $post)) {
										$this->br = "nn";
										if (eregi('netscape/(7.+)', $post, $regs)) {
											$this->v = trim($regs[1]);
										} else {
											$this->v = 7;
										}
										$this->_getSys($bracket);
									} else 
										if (eregi(' AppleWebKit/([0-9\.]+)', $post, $regs)) {
											$this->v = $regs[1];
											$this->br = "appleWebKit";
											$this->_getSys($bracket);
										} else 
											if (eregi('safari', $post)) {
												if (eregi('safari/([0-9\.]+)', $post, $regs)) {
													$this->v = substr($regs[1] / 100, 0, 3);
												} else {
													$this->v = "1";
												}
												$this->br = "safari";
												
												$this->_getSys($bracket);
											} else 
												if (eregi(' firefox/([0-9\.]+)', $post, $regs)) {
													$this->v = $regs[1];
													$this->br = "firefox";
													$this->_getSys($bracket);
												} else 
													if (eregi('gecko', $post)) {
														$this->br = "mozilla";
														if (eregi('rv:([0-9\.]*)', $bracket, $regs)) {
															$this->v = $regs[1];
														}
														$this->_getSys($bracket);
													} else 
														if (eregi('opera ([^ ]+)', $post, $regs)) {
															$this->br = "opera";
															$this->v = $regs[1];
															$this->_getSys($bracket);
														} else 
															if ($brArr[0] == "compatible") {
																$this->br = "unknown";
																/*if(eregi('eudoraweb',$bracket)){
						$this->br="unknown";
						#list($foo,$this->v) = explode(" ",trim($brArr[1]));
						#if($brArr[3]) $this->sys = $brArr[3];
						}else if(eregi('powermarks',$bracket)){
						$this->br="unknown";
						#list($this->br,$this->v) = explode("/",$brArr[1]);
						}else{
						$this->br = "mozilla_compatible";
						$this->v = $prever;
						}*/
															} else 
																if (!eregi('msie', $bracket)) {
																	$this->br = "nn";
																	$this->v = ereg_replace(
																			'[^0-9\.]', 
																			'', 
																			$prever);
																	$this->_getSys($bracket);
																}
							}
				} else 
					if (strtolower($bez) == "opera") {
						$this->br = "opera";
						$this->v = $prever;
						$this->_getSys($bracket);
					} else 
						if (strtolower($bez) == "googlebot") {
							$this->br = "unknown";
							#$this->v=$prever;
						} else 
							if (strtolower($bez) == "nokia-communicator-www-Browser") {
								$this->br = "unknown";
							}
			if ($this->sys == "unknown") {
				if (eregi('webtv', $this->ua)) {
					$this->sys = "webtv";
				}
			}
		} else 
			if (eregi('^lynx([^a-zA-Z]+)[a-zA-Z].*', $ua, $regs)) {
				$this->br = "lynx";
				$this->v = str_replace('/', '', $regs[1]);
				/*}else if(eregi('wget/([0-9\.]+)',$this->ua,$regs)){
			$this->br="wget";
			$this->v=$regs[1];
			}else if(eregi('gulliver/([0-9\.]+)',$this->ua,$regs)){
			$this->br="gulliver";
			$this->v=$regs[1];
			}else if(eregi('w3m/([0-9\.]+)',$this->ua,$regs)){
			$this->br="w3m";
			$this->v=$regs[1];
			}else if(eregi('fireball/([0-9\.]+)',$this->ua,$regs)){
			$this->br="fireball";
			$this->v=$regs[1];
			}else if(eregi('scooter-w([0-9\.-]+)',$this->ua,$regs)){
			$this->br="scooter";
			$this->v=$regs[1];
			}else if(eregi('scooter[/-]([0-9\.]+)',$this->ua,$regs)){
			$this->br="scooter";
			$this->v=$regs[1];
			}else if(eregi('scooter_trk2-([0-9\.]+)',$this->ua,$regs)){
			$this->br="scooter";
			$this->v=$regs[1];
			}else if(eregi('java([0-9\.]+)',$this->ua,$regs)){
			$this->br="java";
			$this->v=$regs[1];*/
			} else {
				$this->br = "unknown";
			}
	}

	function _getSys($bracket)
	{
		if (eregi('mac', $bracket)) {
			$this->sys = "mac";
		} else 
			if (eregi('win', $bracket)) {
				$this->sys = "win";
			} else 
				if (eregi('linux', $bracket) || eregi('x11', $bracket) || eregi('sun', $bracket)) {
					$this->sys = "unix";
				}
	}

	function getBrowser()
	{
		return $this->br;
	}

	function getBrowserVersion()
	{
		return trim($this->v);
	}

	function getSystem()
	{
		return $this->sys;
	}

	function getUserAgent()
	{
		return $this->ua;
	}

}

?>