<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: charset.inc.php
 * Provides language strings.
 * Language: Dutch
 */

/*	To complete the localisation kit, it is necceessary to have the possibility
 *	to change the charset as well, and use different stylesheets as well
 *	In this file all these language specific characteristica are set.
 */
 
//	This is for the charset of webEdition itself.
$_language["charset"] = "ISO-8859-1";

$_charset["error"]["no_charset_tag"] = "Geen we:charset-tag in sjabloon";
$_charset["error"]["no_charset_available"] = "--geen--";

//	These values are for templates used in webEdition
//	we/include/charset.inc.php

$_charset["titles"]["west_european"]    = "West Europees";		// ISO-8859-1
$_charset["titles"]["central_european"] = "Centraal Europees";		// ISO-8859-2
$_charset["titles"]["south_european"]   = "Zuid Europees";		// ISO-8859-3
$_charset["titles"]["north_european"]   = "Noord Europees";		// ISO-8859-4
$_charset["titles"]["cyrillic"]         = "Cyrilisch";				// ISO-8859-5
$_charset["titles"]["arabic"]           = "Arabisch";					// ISO-8859-6
$_charset["titles"]["greek"]            = "Grieks";					// ISO-8859-7
$_charset["titles"]["hebrew"]           = "Hebreeuws";					// ISO-8859-8
$_charset["titles"]["turkish"]          = "Turks";				// ISO-8859-9
$_charset["titles"]["nordic"]           = "Noors";					// ISO-8859-10
$_charset["titles"]["thai"]             = "Thais";					// ISO-8859-11
$_charset["titles"]["baltic"]           = "Baltisch";					// ISO-8859-13
$_charset["titles"]["keltic"]           = "Keltisch";					// ISO-8859-14
$_charset["titles"]["extended_european"] = "Europees (uitgebreid)";   // ISO-8859-15

$_charset["titles"]["unicode"]          = "Unicode";				// UTF-8
$_charset["titles"]["windows_1251"]     = "Windows-1251"; 		// Windows-1251
$_charset["titles"]["windows_1252"]     = "Windows-1252"; 		// Windows-1251
?>