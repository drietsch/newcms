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
$GLOBALS["l_parser"]["delete"] = "Delete";
$GLOBALS["l_parser"]["wrong_type"] = "Value of \"type\" is invalid!";
$GLOBALS["l_parser"]["error_in_template"] = "Template error!";
$GLOBALS["l_parser"]["start_endtag_missing"] = "One or more <code>&lt;we:%s&gt;</code> tags are missing a  start or end tag!";
$GLOBALS["l_parser"]["tag_not_known"] = "The tag <code>'&lt;we:%s&gt;'</code> is unknown!";
$GLOBALS["l_parser"]["else_start"] = "There is a <code>&lt;we:else/&gt;</code> tag without <code>&lt;we:if...&gt;</code> a start tag!";
$GLOBALS["l_parser"]["else_end"] = "There is a <code>&lt;we:else/&gt;</code> tag without <code>&lt;/we:if...&gt;</code> an end tag!";
$GLOBALS["l_parser"]["attrib_missing"] = "The attribute '%s' of the tag <code>&lt;we:%s&gt;</code> is missing or empty!";
$GLOBALS["l_parser"]["attrib_missing2"] = "The attribute '%s' of the tag <code>&lt;we:%s&gt;</code> is missing!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: The opening tag is missing.";
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: The closing tag is missing.";
$GLOBALS["l_parser"]["name_empty"] = "The name of the tag <code>&lt;we:%s&gt;</code> is empty!";
$GLOBALS["l_parser"]["invalid_chars"] =  "The name of the tag <code>&lt;we:%s&gt;</code> contains invalid characters. Only alphabetic characters, numbers, '-' and '_' are allowed!";
$GLOBALS["l_parser"]["name_to_long"] =  "The name of the tag <code>&lt;we:%s&gt;</code> is too long! It may only contain a maximum of 255 characters!";
$GLOBALS["l_parser"]["name_with_space"] =  "The name of the tag <code>&lt;we:%s&gt;</code> may not contain any blank characters!";
$GLOBALS["l_parser"]["client_version"] = "The syntax of the attribute 'version' of the tag <code>&lt;we:ifClient&gt;</code> is wrong!";
$GLOBALS["l_parser"]["html_tags"] = "The template must either include the HTML tags <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> or none of these tags. Otherwise, the parser cannot work correctly!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "The  <code>&lt;we:field&gt;</code>-tag has to be enclosed by a <code>&gt;</code>&lt;we:listview&gt;</code> or <code&gt;</code>&lt;we:object&gt;</code> start- and endtag!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "The <code>&lt;we:setVar from=\"listview\" ... &gt;</code>-tag has to be enclosed by a <code>&lt;we:listview&gt;</code> start- and endtag!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "The attribute jsIncludePath of the tag <code>&lt;we:checkForm&gt;</code> was given as number(ID). But there is no document with such id!";
$GLOBALS["l_parser"]["checkForm_password"] = "The attribute password of the <code>&lt;we:checkForm&gt;</code> must be 3 values separated by commas!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>.";
$GLOBALS["l_parser"]["multi_object_name_missing_error"] = "Error: The object field &quot;%s, specified in the attribute &quot;name&quot;, does not exist!";
$GLOBALS["l_parser"]["template_recursion_error"] = "Error: Too much recursion!";
?>