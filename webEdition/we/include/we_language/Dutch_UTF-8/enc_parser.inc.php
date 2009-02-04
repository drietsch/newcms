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
 * Language file: enc_parser.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_parser"]["delete"] = "Delete"; // TRANSLATE
$GLOBALS["l_parser"]["wrong_type"] = "Waarde van \"type\" is ongeldig!";
$GLOBALS["l_parser"]["error_in_template"] = "sjabloon fout!";
$GLOBALS["l_parser"]["start_endtag_missing"] = "Eén of meerdere <code>&lt;we:%s&gt;</code> tags missen een begin of eind tag!";
$GLOBALS["l_parser"]["tag_not_known"] = "The tag <code>'&lt;we:%s&gt;'</code> is onbekend!";
$GLOBALS["l_parser"]["else_start"] = "Er is een <code>&lt;we:else/&gt;</code> tag zonder <code>&lt;we:if...&gt;</code> een begin tag!";
$GLOBALS["l_parser"]["else_end"] = "Er is een <code>&lt;we:else/&gt;</code> tag zonder <code>&lt;/we:if...&gt;</code> een eind tag!";
$GLOBALS["l_parser"]["attrib_missing"] = "Het attribuut '%s' van de tag <code>&lt;we:%s&gt;</code> ontbreekt of is leeg!";
$GLOBALS["l_parser"]["attrib_missing2"] = "Het attribuut '%s' van de tag <code>&lt;we:%s&gt;</code> ontbreekt!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: De openings tag ontbreekt.";
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: De sluit tag ontbreekt.";
$GLOBALS["l_parser"]["name_empty"] = "De naam van de tag <code>&lt;we:%s&gt;</code> is leeg!";
$GLOBALS["l_parser"]["invalid_chars"] =  "De naam van de tag <code>&lt;we:%s&gt;</code> bevat ongeldige karakters. Alleen alphabetische karakters, nummers, '-' en '_' zijn toegestaan!";
$GLOBALS["l_parser"]["name_to_long"] =  "De naam van de tag <code>&lt;we:%s&gt;</code> is te lang! Deze mag maximaal 255 karakters bevatten!";
$GLOBALS["l_parser"]["name_with_space"] =  "De naam van de tag <code>&lt;we:%s&gt;</code> mag geen blanco karakters bevatten!";
$GLOBALS["l_parser"]["client_version"] = "De syntax van het attribuut 'version' van de tag <code>&lt;we:ifClient&gt;</code> is verkeerd!";
$GLOBALS["l_parser"]["html_tags"] = "Het sjabloon moet of HTML tags bevatten <code>&lt;html&gt; &lt;head&gt; &lt;body&gt;</code> of geen van deze tags. Anders functioneert de parser niet correct!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "De  <code>&lt;we:field&gt;</code>-tag moet omsloten worden door <code>&gt;</code>&lt;we:listview&gt;</code> of <code&gt;</code>&lt;we:object&gt;</code> begin- en eindtag!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "De <code>&lt;we:setVar from=\"listview\" ... &gt;</code>-tag moet omsloten worden door een <code>&lt;we:listview&gt;</code> begin- en eindtag!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "Aan het attribuut 'jsIncludePath' van de tag <code>&lt;we:checkForm&gt;</code> is een nummer toegekend(ID). Maar er is geen document met dit ID!";
$GLOBALS["l_parser"]["checkForm_password"] = "Het attribuut wachtwoord van de <code>&lt;we:checkForm&gt;</code> moet 3 komma gescheiden waardes bevatten!";
$GLOBALS["l_parser"]["missing_createShop"] = "De tag <code>&lt;we:%s&gt;</code> kan alleen gebruikt worden na<code>&lt;we:createShop&gt;</code>.";
$GLOBALS["l_parser"]["multi_object_name_missing_error"] = "Error: The object field &quot;%s, specified in the attribute &quot;name&quot;, does not exist!"; // TRANSLATE
$GLOBALS["l_parser"]["template_recursion_error"] = "Error: Too much recursion!"; // TRANSLATE
?>