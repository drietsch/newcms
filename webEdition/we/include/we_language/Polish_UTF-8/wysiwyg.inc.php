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

/**
 * Language file: wysiwyg.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));
include_once(dirname(__FILE__)."/enc_wysiwyg_js.inc.php");

$GLOBALS["l_wysiwyg"]["window_title"] = "Edytuj pole '%s'";

$GLOBALS["l_wysiwyg"]["format"] = "Styl";
$GLOBALS["l_wysiwyg"]["fontsize"] = "Wilekość czcionki";
$GLOBALS["l_wysiwyg"]["fontname"] = "Nazwa czcionki";
$GLOBALS["l_wysiwyg"]["css_style"] = "Styl CSS";

$GLOBALS["l_wysiwyg"]["normal"] = "Normal"; // TRANSLATE
$GLOBALS["l_wysiwyg"]["h1"] = "Nagłówek 1";
$GLOBALS["l_wysiwyg"]["h2"] = "Nagłówek 2";
$GLOBALS["l_wysiwyg"]["h3"] = "Nagłówek 3";
$GLOBALS["l_wysiwyg"]["h4"] = "Nagłówek 4";
$GLOBALS["l_wysiwyg"]["h5"] = "Nagłówek 5";
$GLOBALS["l_wysiwyg"]["h6"] = "Nagłówek 6";
$GLOBALS["l_wysiwyg"]["pre"] = "Sformatowano";
$GLOBALS["l_wysiwyg"]["address"] = "Adres";

$GLOBALS['l_wysiwyg']['spellcheck'] = 'Spellchecking'; // TRANSLATE
?>