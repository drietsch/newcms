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

$SAFARI_WYSIWYG = false;
$SAFARI_3 = false;

$_SERVER["HTTP_USER_AGENT"] = (isset($_REQUEST["WE_HTTP_USER_AGENT"]) && $_REQUEST["WE_HTTP_USER_AGENT"]) ? $_REQUEST["WE_HTTP_USER_AGENT"] : (isset(
		$_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "");

if (eregi("(ozilla.[23]|MSIE.3)", $_SERVER["HTTP_USER_AGENT"])) {
	$BROWSER3 = true;
}
if (eregi("safari", $_SERVER["HTTP_USER_AGENT"])) {
	$BROWSER = "SAFARI";
	if (eregi('AppleWebKit/([^ ]+)', $_SERVER["HTTP_USER_AGENT"], $regs)) {
		$v = $regs[1];
		if ((abs($v) > 311 && abs($v) < 400) || (abs($v) > 411)) {
			$SAFARI_WYSIWYG = true;
		}
		if (abs($v) > 522) {
			$SAFARI_3 = true;
		}
	}
} else 
	if (eregi("opera", $_SERVER["HTTP_USER_AGENT"])) {
		$BROWSER = "OPERA";
	} else 
		if (eregi("MSIE", $_SERVER["HTTP_USER_AGENT"])) {
			$BROWSER = "IE";
		} else 
			if (eregi("mozilla", $_SERVER["HTTP_USER_AGENT"])) {
				$BROWSER = "NN";
				if (eregi("gecko", $_SERVER["HTTP_USER_AGENT"])) {
					$BROWSER = "NN6";
				}
			} else {
				$BROWSER = "UNKNOWN";
			}
$OSX = false;
if (eregi("X11", $_SERVER["HTTP_USER_AGENT"])) {
	$SYSTEM = "X11";
} else 
	if (eregi("Win", $_SERVER["HTTP_USER_AGENT"])) {
		$SYSTEM = "WIN";
	} else 
		if (eregi("Mac", $_SERVER["HTTP_USER_AGENT"])) {
			$SYSTEM = "MAC";
			if (eregi("os x", $_SERVER["HTTP_USER_AGENT"])) {
				$OSX = true;
			}
		} else {
			$SYSTEM = "UNKNOWN";
		}

if (($BROWSER == "IE") && ($SYSTEM == "WIN")) {
	$foo = explode(";", $_SERVER["HTTP_USER_AGENT"]);
	$foo = abs(eregi_replace("[^0-9\\.]", "", $foo[1]));
	if ($foo >= 5.5) {
		$IE55 = true;
	}
	if ($foo < 5) {
		$IE4 = true;
	}
}

#### Erkennung fuer Mozilla >= 1.3


$MOZ13 = false;

if (($BROWSER == "NN6")) {
	if (ereg('.*; ?rv:([0-9\.]+).*', $_SERVER["HTTP_USER_AGENT"], $regs)) {
		if (abs($regs[1]) >= 1.3) {
			$MOZ13 = true;
		}
	}
}

#### Erkennung fuer Netscape >= 6.0


$NET6 = false;
$FF = ""; 
if (($BROWSER == "NN6")) {
	if (ereg('.*Netscape.*', $_SERVER["HTTP_USER_AGENT"], $regs)) {
		$NET6 = true;
	} elseif (ereg('.*Firefox*', $_SERVER["HTTP_USER_AGENT"], $regs)) {
		$BROWSERVERSION = substr(strstr($_SERVER["HTTP_USER_AGENT"], "Firefox/"),8);
		$_bvArray=explode(".",$BROWSERVERSION);
		$FF = $_bvArray[0];		
	}
}

#### Erkennung fuer ActiveX kompatible Mozilla Browser


$MOZ_AX = false;

?>