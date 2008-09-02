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
 * Language file: enc_parser.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_parser"]["wrong_type"] = "Wartość \"type\" jest niedozwolona!";
$GLOBALS["l_parser"]["error_in_template"] = "Błąd w szablonie";
$GLOBALS["l_parser"]["start_endtag_missing"] = "W <code>&lt;we:%s&gt;</code> brakuje tagu początkowego albo końcowego!";
$GLOBALS["l_parser"]["tag_not_known"] = "Tag <code>'&lt;we:%s&gt;'</code> nie jest znany!";
$GLOBALS["l_parser"]["else_start"] = "W <code>&lt;we:else/&gt;</code> brakuje wymaganego tagu startowego <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["else_end"] = "W <code>&lt;we:else/&gt;</code> brakuje wymaganego tagu końcowego <code>&lt;/we:if...&gt;</code>!";
$GLOBALS["l_parser"]["attrib_missing"] = "Atrybut '%s' w tagu <code>&lt;we:%s&gt;</code> nie może być pusty!";
$GLOBALS["l_parser"]["attrib_missing2"] = "Atrybut '%s' w tagu <code>&lt;we:%s&gt;</code> nie może być pusty!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: The opening tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: The closing tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["name_empty"] = "Nazwa tagu  <code>&lt;we:%s&gt;</code> jest pusta!";
$GLOBALS["l_parser"]["invalid_chars"] =  "Nazwa tagu<code>&lt;we:%s&gt;</code> zawiera niedozwolone znaki. Dozwolone są jedynie litery, cyfry, '-' i '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "Nazwa tagu we:%s jest za długa! Może mieć maksymalnie 255 znaków!";
$GLOBALS["l_parser"]["name_with_space"] =  "Nazwa tagu we:%s nie może być pusta!";
$GLOBALS["l_parser"]["client_version"] = "Składnia atrybutu 'version' w tagu <code>&lt;we:ifClient&gt;</code> jest błędna!";
$GLOBALS["l_parser"]["html_tags"] = "Szablon musi zawierać tagi HTML <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> albo żadnych, tak aby fraza była poprawna!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "Tag <code>&lt;we:field&gt;</code> musi znajdować się w obrębie <code>&lt;we:listview&gt;</code> lub <code>&lt;we:object&gt;</code> tagu startowego i końcowego!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "Tag <code>&lt;we:setVar from=\"listview\" ... &gt;</code> musi znajdować się w obrębie <code>&lt;we:listview&gt;</code> tagu startowego i końcowego!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "Atrybut jsIncludePath tagu <code>&lt;we:checkForm&gt;</code> został podany jako liczba (ID). Dokument z tym ID nie mógł jednak zostać znaleziony!";
$GLOBALS["l_parser"]["checkForm_password"] = "Atrubut password tagu <code>&lt;we:checkForm&gt;</code> wymaga 3 oddzielonych przecinkami wartości!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
?>