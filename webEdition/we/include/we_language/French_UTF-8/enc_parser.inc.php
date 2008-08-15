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
$GLOBALS["l_parser"]["delete"] = "Delete"; // TRANSLATE
$GLOBALS["l_parser"]["wrong_type"] = "La valeur du \"type\" n'est pas licite!";
$GLOBALS["l_parser"]["error_in_template"] = "Erreur dans le modèle";
$GLOBALS["l_parser"]["start_endtag_missing"] = "Un ou plusiers <code>&lt;we:%s&gt;</code> Tags manquent d'un repère d'ouverture ou repère de fermeture!";
$GLOBALS["l_parser"]["tag_not_known"] = "Le Tag <code>'&lt;we:%s&gt;'</code> est inconnu!";
$GLOBALS["l_parser"]["else_start"] = "Il y a un <code>&lt;we:else/&gt;</code> Tag  sans  <code>&lt;we:if...&gt;</code> un repère d'ouverture!";
$GLOBALS["l_parser"]["else_end"] = "Il y a un <code>&lt;we:else/&gt;</code> Tag sans <code>&lt;/we:if...&gt;</code> un repère de fermeture!";
$GLOBALS["l_parser"]["attrib_missing"] = "L'attribut '%s' dans le Tag <code>&lt;we:%s&gt;</code> ne doit pas manquer ou être vide!";
$GLOBALS["l_parser"]["attrib_missing2"] = "L'attribut '%s' dans le Tag <code>&lt;we:%s&gt;</code> ne doit pas manquer!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: The opening tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: The closing tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["name_empty"] = "Le nom du Tag <code>&lt;we:%s&gt;</code> est vide!";
$GLOBALS["l_parser"]["invalid_chars"] =  "Le nom du Tag <code>&lt;we:%s&gt;</code> contient des signe illicite. Permit sont les lettres, chiffres, '-' et '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "Le nom du Tag we:%s est trop long! Langeur maximale est 255 chiffres!";
$GLOBALS["l_parser"]["name_with_space"] =  "Le nom du Tag we:%s ne doit pas contenir des éspace!";
$GLOBALS["l_parser"]["client_version"] = "La syntax de l'attribut 'version' dans le Tag <code>&lt;we:ifClient&gt;</code> n'est pas correcte!";
$GLOBALS["l_parser"]["html_tags"] = "Le modèle doit ou contenir les Tags-HTML <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> ou aucun de ces Tags, pour que l'nalyseur syntaxique travaille correctement!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "Le Tag <code>&lt;we:field&gt;</code> doit être entre des rèperes d'ouverture et de fermeture de <code>&lt;we:listview&gt;</code> ou <code>&lt;we:object&gt;</code>!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "Le Tag <code>&lt;we:setVar from=\"listview\" ... &gt;</code> doit être entre des rèperes d'ouverture et de fermeture de <code>&lt;we:listview&gt;</code>!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "L'attribut jsIncludePath du Tag <code>&lt;we:checkForm&gt;</code> a été saisi comme nombre (ID). Un document avec cette ID n'a pas été trouvé!";
$GLOBALS["l_parser"]["checkForm_password"] = "L'attribut password du Tag <code>&lt;we:checkForm&gt;</code> attend 3 valeurs séparées par des virgules!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
$GLOBALS["l_parser"]["multi_object_name_missing_error"] = "Error: The object field &quot;%s, specified in the attribute &quot;name&quot;, does not exist!"; // TRANSLATE
$GLOBALS["l_parser"]["template_recursion_error"] = "Error: Too much recursion!"; // TRANSLATE
?>