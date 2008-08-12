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
 * Language file: enc_parser.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_parser"]["wrong_type"] = "Warto¶æ \"type\" jest niedozwolona!";
$GLOBALS["l_parser"]["error_in_template"] = "B³±d w szablonie";
$GLOBALS["l_parser"]["start_endtag_missing"] = "W <code>&lt;we:%s&gt;</code> brakuje tagu pocz±tkowego albo koñcowego!";
$GLOBALS["l_parser"]["tag_not_known"] = "Tag <code>'&lt;we:%s&gt;'</code> nie jest znany!";
$GLOBALS["l_parser"]["else_start"] = "W <code>&lt;we:else/&gt;</code> brakuje wymaganego tagu startowego <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["else_end"] = "W <code>&lt;we:else/&gt;</code> brakuje wymaganego tagu koñcowego <code>&lt;/we:if...&gt;</code>!";
$GLOBALS["l_parser"]["attrib_missing"] = "Atrybut '%s' w tagu <code>&lt;we:%s&gt;</code> nie mo¿e byæ pusty!";
$GLOBALS["l_parser"]["attrib_missing2"] = "Atrybut '%s' w tagu <code>&lt;we:%s&gt;</code> nie mo¿e byæ pusty!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: The opening tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: The closing tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["name_empty"] = "Nazwa tagu  <code>&lt;we:%s&gt;</code> jest pusta!";
$GLOBALS["l_parser"]["invalid_chars"] =  "Nazwa tagu<code>&lt;we:%s&gt;</code> zawiera niedozwolone znaki. Dozwolone s± jedynie litery, cyfry, '-' i '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "Nazwa tagu we:%s jest za d³uga! Mo¿e mieæ maksymalnie 255 znaków!";
$GLOBALS["l_parser"]["name_with_space"] =  "Nazwa tagu we:%s nie mo¿e byæ pusta!";
$GLOBALS["l_parser"]["client_version"] = "Sk³adnia atrybutu 'version' w tagu <code>&lt;we:ifClient&gt;</code> jest b³êdna!";
$GLOBALS["l_parser"]["html_tags"] = "Szablon musi zawieraæ tagi HTML <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> albo ¿adnych, tak aby fraza by³a poprawna!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "Tag <code>&lt;we:field&gt;</code> musi znajdowaæ siê w obrêbie <code>&lt;we:listview&gt;</code> lub <code>&lt;we:object&gt;</code> tagu startowego i koñcowego!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "Tag <code>&lt;we:setVar from=\"listview\" ... &gt;</code> musi znajdowaæ siê w obrêbie <code>&lt;we:listview&gt;</code> tagu startowego i koñcowego!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "Atrybut jsIncludePath tagu <code>&lt;we:checkForm&gt;</code> zosta³ podany jako liczba (ID). Dokument z tym ID nie móg³ jednak zostaæ znaleziony!";
$GLOBALS["l_parser"]["checkForm_password"] = "Atrubut password tagu <code>&lt;we:checkForm&gt;</code> wymaga 3 oddzielonych przecinkami warto¶ci!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
?>