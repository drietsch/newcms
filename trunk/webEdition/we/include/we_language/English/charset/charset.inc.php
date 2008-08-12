<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: charset.inc.php,v 1.9 2007/05/23 15:39:35 holger.meyer Exp $

/**
 * Language file: charset.inc.php
 * Provides language strings.
 * Language: English
 */

/*	To complete the localisation kit, it is necceessary to have the possibility
 *	to change the charset as well, and use different stylesheets as well
 *	In this file all these language specific characteristica are set.
 */
 
//	This is for the charset of webEdition itself.
$_language["charset"] = "ISO-8859-1";

$_charset["error"]["no_charset_tag"] = "No we:charset-tag in template";
$_charset["error"]["no_charset_available"] = "--none--";

//	These values are for templates used in webEdition
//	we/include/charset.inc.php

$_charset["titles"]["west_european"]    = "Western European";		// ISO-8859-1
$_charset["titles"]["central_european"] = "Central European";		// ISO-8859-2
$_charset["titles"]["south_european"]   = "Southern European";		// ISO-8859-3
$_charset["titles"]["north_european"]   = "Northern European";		// ISO-8859-4
$_charset["titles"]["cyrillic"]         = "Cyrillic";				// ISO-8859-5
$_charset["titles"]["arabic"]           = "Arabia";					// ISO-8859-6
$_charset["titles"]["greek"]            = "Greek";					// ISO-8859-7
$_charset["titles"]["hebrew"]           = "Hebrew";					// ISO-8859-8
$_charset["titles"]["turkish"]          = "Turkish";				// ISO-8859-9
$_charset["titles"]["nordic"]           = "Nordic";					// ISO-8859-10
$_charset["titles"]["thai"]             = "Thai";					// ISO-8859-11
$_charset["titles"]["baltic"]           = "Baltic";					// ISO-8859-13
$_charset["titles"]["keltic"]           = "Keltic";					// ISO-8859-14
$_charset["titles"]["extended_european"] = "European (extended)";   // ISO-8859-15

$_charset["titles"]["unicode"]          = "Unicode";				// UTF-8
$_charset["titles"]["windows_1251"]     = "Windows-1251";		// Windows-1251
$_charset["titles"]["windows_1252"]     = "Windows-1252";		// Windows-1251
?>