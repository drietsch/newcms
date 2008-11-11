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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */



/*	To complete the localisation kit, it is necceessary to have the possibility
 *	to change the charset as well, and use different stylesheets as well
 *	In this file all these language specific characteristica are set.
 */

//	This is for the charset of webEdition itself.
$_language["charset"] = "UTF-8";

$_charset["error"]["no_charset_tag"] = "Kein we:charset-Tag in der Vorlage";
$_charset["error"]["no_charset_available"] = "--Ohne--";


//	These values are for templates used in webEdition
//	we/include/charset.inc.php
// :ATTENTION: this code is used independent from charset, therefore we use htmlentities

$_charset["titles"]["west_european"]     = "Westeurop&auml;isch";		// ISO-8859-1
$_charset["titles"]["central_european"]  = "Mitteleurop&auml;isch";	// ISO-8859-2
$_charset["titles"]["south_european"]    = "S&uml;deurop&amul;isch";		// ISO-8859-3
$_charset["titles"]["north_european"]    = "Nordeurop&auml;isch";		// ISO-8859-4
$_charset["titles"]["cyrillic"]          = "Kyrillisch";			// ISO-8859-5
$_charset["titles"]["arabic"]            = "Arabisch";			// ISO-8859-6
$_charset["titles"]["greek"]             = "Griechisch";			// ISO-8859-7
$_charset["titles"]["hebrew"]            = "Hebr&auml;isch";			// ISO-8859-8
$_charset["titles"]["turkish"]           = "T&uuml;rkisch";			// ISO-8859-9
$_charset["titles"]["nordic"]            = "Nordisch";			// ISO-8859-10
$_charset["titles"]["thai"]              = "Thail&auml;ndisch";		// ISO-8859-11
$_charset["titles"]["baltic"]            = "Baltisch";			// ISO-8859-13
$_charset["titles"]["keltic"]            = "Keltisch";			// ISO-8859-14
$_charset["titles"]["extended_european"] = "Europ&auml;isch (erweitert)";    // ISO-8859-15

$_charset["titles"]["unicode"]           = "Unicode";			// UTF-8
$_charset["titles"]["windows_1251"]      = "Windows-1251";		// Windows-1251
$_charset["titles"]["windows_1252"]      = "Windows-1252";		// Windows-1251

?>