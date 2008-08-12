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
 * Language: English
 */

/*	To complete the localisation kit, it is necceessary to have the possibility
 *	to change the charset as well, and use different stylesheets as well
 *	In this file all these language specific characteristica are set.
 */
 
//	This is for the charset of webEdition itself.
$_language["charset"] = "ISO-8859-1"; // TRANSLATE

$_charset["error"]["no_charset_tag"] = "No hay rótulo we:charset en la plantilla";
$_charset["error"]["no_charset_available"] = "--ninguno--";

//	These values are for templates used in webEdition
//	we/include/charset.inc.php

$_charset["titles"]["west_european"]    = "Europeo oriental";		// ISO-8859-1
$_charset["titles"]["central_european"] = "Europeo central";		// ISO-8859-2
$_charset["titles"]["south_european"]   = "Europeo del Sur";		// ISO-8859-3
$_charset["titles"]["north_european"]   = "Europeo del Norte";		// ISO-8859-4
$_charset["titles"]["cyrillic"]         = "Cirílico";				// ISO-8859-5
$_charset["titles"]["arabic"]           = "Arabico";					// ISO-8859-6
$_charset["titles"]["greek"]            = "Griego";					// ISO-8859-7
$_charset["titles"]["hebrew"]           = "Hebreo";					// ISO-8859-8
$_charset["titles"]["turkish"]          = "Turco";				// ISO-8859-9
$_charset["titles"]["nordic"]           = "Nórdico";					// ISO-8859-10
$_charset["titles"]["thai"]             = "Tailandés";					// ISO-8859-11
$_charset["titles"]["baltic"]           = "Báltico";					// ISO-8859-13
$_charset["titles"]["keltic"]           = "Celta";					// ISO-8859-14
$_charset["titles"]["extended_european"] = "Europeo";   // ISO-8859-15

$_charset["titles"]["unicode"]          = "Unicode"; // TRANSLATE				// UTF-8
$_charset["titles"]["windows_1251"]     = "Windows-1251"; // TRANSLATE		// Windows-1251
$_charset["titles"]["windows_1252"]     = "Windows-1252"; // TRANSLATE		// Windows-1251
?>