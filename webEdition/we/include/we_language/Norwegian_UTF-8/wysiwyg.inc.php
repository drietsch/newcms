<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * Language file: wysiwyg.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));
include_once(dirname(__FILE__)."/enc_wysiwyg_js.inc.php");

$GLOBALS["l_wysiwyg"]["window_title"] = "Edit field '%s'";

$GLOBALS["l_wysiwyg"]["format"] = "Format";
$GLOBALS["l_wysiwyg"]["fontsize"] = "Font size";
$GLOBALS["l_wysiwyg"]["fontname"] = "Font name";
$GLOBALS["l_wysiwyg"]["css_style"] = "CSS style";

$GLOBALS["l_wysiwyg"]["normal"] = "Normal";
$GLOBALS["l_wysiwyg"]["h1"] = "Heading 1";
$GLOBALS["l_wysiwyg"]["h2"] = "Heading 2";
$GLOBALS["l_wysiwyg"]["h3"] = "Heading 3";
$GLOBALS["l_wysiwyg"]["h4"] = "Heading 4";
$GLOBALS["l_wysiwyg"]["h5"] = "Heading 5";
$GLOBALS["l_wysiwyg"]["h6"] = "Heading 6";
$GLOBALS["l_wysiwyg"]["pre"] = "Formatted";
$GLOBALS["l_wysiwyg"]["address"] = "Address";

$GLOBALS['l_wysiwyg']['spellcheck'] = 'Spellchecking';
?>