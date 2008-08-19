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
 * Language: Deutsch
 */
$GLOBALS["l_parser"]["delete"] = "Löschen";
$GLOBALS["l_parser"]["wrong_type"] = "Der Wert von \"type\" ist nicht zul&auml;ssig!";
$GLOBALS["l_parser"]["error_in_template"] = "Fehler in der Vorlage";
$GLOBALS["l_parser"]["start_endtag_missing"] = "Bei einem <code>&lt;we:%s&gt;</code> Tag fehlt entweder das Start- oder das Endtag!";
$GLOBALS["l_parser"]["tag_not_known"] = "Das Tag <code>'&lt;we:%s&gt;'</code> ist nicht bekannt!";
$GLOBALS["l_parser"]["else_start"] = "Bei einem <code>&lt;we:else/&gt;</code> Tag fehlt das dazugeh&ouml;rige <code>&lt;we:if...&gt;</code> Starttag!";
$GLOBALS["l_parser"]["else_end"] = "Bei einem <code>&lt;we:else/&gt;</code> Tag fehlt das dazugeh&ouml;rige <code>&lt;/we:if...&gt;</code> Endtag!";
$GLOBALS["l_parser"]["attrib_missing"] = "Das Attribut '%s' im Tag <code>&lt;we:%s&gt;</code> darf nicht fehlen oder leer sein!";
$GLOBALS["l_parser"]["attrib_missing2"] = "Das Attribut '%s' im Tag <code>&lt;we:%s&gt;</code> darf nicht fehlen!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: Das öffnende Tag fehlt.";
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: Das schließende Tag fehlt.";
$GLOBALS["l_parser"]["name_empty"] = "Der Name des Tags <code>&lt;we:%s&gt;</code> ist leer!";
$GLOBALS["l_parser"]["invalid_chars"] =  "Der Name des Tags <code>&lt;we:%s&gt;</code> enth&auml;lt ung&uuml;ltige Zeichen. Erlaubt sind nur Buchstaben, Zahlen, '-' und '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "Der Name des Tags we:%s ist zu lang! Er darf maximal nur 255 Zeichen lang sein!";
$GLOBALS["l_parser"]["name_with_space"] =  "Der Name des Tags we:%s darf kein Leerzeichen enthalten!";
$GLOBALS["l_parser"]["client_version"] = "Die Syntax des Attributs 'version' im Tag <code>&lt;we:ifClient&gt;</code> ist falsch!";
$GLOBALS["l_parser"]["html_tags"] = "Die Vorlage mu&szlig; entweder die HTML-Tags <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> enthalten oder keine dieser Tags, damit der Parser korrekt arbeitet!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "Das Tag <code>&lt;we:field&gt;</code> muss sich innerhalb eines <code>&lt;we:listview&gt;</code> oder <code>&lt;we:object&gt;</code> Start- und Endtags befinden!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "Das Tag <code>&lt;we:setVar from=\"listview\" ... &gt;</code> muss sich innerhalb eines <code>&lt;we:listview&gt;</code> Start- und Endtags befinden!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "Das Attribut jsIncludePath des Tags <code>&lt;we:checkForm&gt;</code> wurde als Zahl (ID) angegeben. Ein Dokument mit dieser ID konnte aber nicht gefunden werden!";
$GLOBALS["l_parser"]["checkForm_password"] = "Das Attribut password des Tags <code>&lt;we:checkForm&gt;</code> erwartet 3 kommaseparierte Werte!";
$GLOBALS["l_parser"]["missing_createShop"] = "Der Tag <code>&lt;we:%s&gt;</code> kann nur nach <code>&lt;we:createShop&gt;</code> eingesetzt werdern.";
$GLOBALS["l_parser"]["multi_object_name_missing_error"] = "Fehler: Das im we:listview Attribut &quot;name&quot; angegebene Objektfeld &quot;%s&quot; existiert nicht!";
$GLOBALS["l_parser"]["template_recursion_error"] = "Fehler: Zu viel Rekursion!";

?>