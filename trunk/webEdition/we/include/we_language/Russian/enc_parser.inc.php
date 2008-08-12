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
$GLOBALS["l_parser"]["wrong_type"] = "Значение &quot;type&quot; недопустимо!";
$GLOBALS["l_parser"]["error_in_template"] = "Ошибка шаблона";
$GLOBALS["l_parser"]["start_endtag_missing"] = "Для одного из тегов <code>&lt;we:%s&gt;</code> не задан начальный или конечный тег!";
$GLOBALS["l_parser"]["tag_not_known"] = "Тег <code>'&lt;we:%s&gt;'</code> неизвестен!";
$GLOBALS["l_parser"]["else_start"] = "Для тега <code>&lt;we:else/&gt;</code> не задан начальный тег <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["else_end"] = "Для тега <code>&lt;we:else/&gt;</code> не задан конечный тег <code>&lt;we:if...&gt;</code>!";
$GLOBALS["l_parser"]["attrib_missing"] = "Атрибут '%s' тега <code>&lt;we:%s&gt;</code> не должен быть незаполненным!";
$GLOBALS["l_parser"]["attrib_missing2"] = "Атрибут '%s' тега <code>&lt;we:%s&gt;</code> не должен отсутствовать!";
$GLOBALS["l_parser"]["name_empty"] = "Имя тега <code>&lt;we:%s&gt;</code> не заполнено!";
$GLOBALS["l_parser"]["invalid_chars"] =  "Имя тега <code>&lt;we:%s&gt;</code> содержит недопустимые символы. Допустимыми символами являются буквы латинского алфавита, цифры, символы: '-' и '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "Имя тега <code>&lt;we:%s&gt;</code> слишком длинное! Имя не должно превышать 255 символов!";
$GLOBALS["l_parser"]["name_with_space"] =  "Имя тега <code>&lt;we:%s&gt;</code> не должно включать пробелы!";
$GLOBALS["l_parser"]["client_version"] = "Синтаксис атрибута 'version' тега  <code>&lt;we:ifClient&gt;</code> неверен!";
$GLOBALS["l_parser"]["html_tags"] = "Шаблон должен содержать либо все нижеследующие теги HTML <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> либо ни одного из них. В противном случае не обеспечивается корректная работа парсера!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "Тег <code&gt;</code>&lt;we:field&gt;</code> должен находиться между начальным и конечным тегом  <code>&lt;we:listview&gt;</code> или <code>&lt;we:object&gt;</code>!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "Тег <code>&lt;we:setVar from=\"listview\" ... &gt;</code> вкладывается с помощью начального и конечного тегов <code>&lt;we:listview&gt;</code>!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "Атрибут jsIncludePath тега  <code>&lt;we:checkForm&gt;</code> задан в виде порядкового номера (ID). Документа с таким порядковым номером не существует!";
$GLOBALS["l_parser"]["checkForm_password"] = "Пароль атрибута тега <code>&lt;we:checkForm&gt;</code> должен состоять из 3 знаков, разделенных запятыми!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
?>