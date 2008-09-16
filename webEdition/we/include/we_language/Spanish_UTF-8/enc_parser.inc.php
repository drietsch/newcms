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
$GLOBALS["l_parser"]["delete"] = "Delete"; // TRANSLATE
$GLOBALS["l_parser"]["wrong_type"] = "El valor de \"tipo\" es no válido!";
$GLOBALS["l_parser"]["error_in_template"] = "Error de plantilla!";
$GLOBALS["l_parser"]["start_endtag_missing"] = "A uno o más rótulos <código>&lt;we:%s&gt;</código> les faltan un rótulo inicio o un rótulo final!";
$GLOBALS["l_parser"]["tag_not_known"] = "El rótulo <código>'&lt;we:%s&gt;'</código> es desconocido!";
$GLOBALS["l_parser"]["else_start"] = "Hay un rótulo <código>&lt;we:else/&gt;</código> sin un rótulo inicio <código>&lt;we:if...&gt;</código> !";
$GLOBALS["l_parser"]["else_end"] = "Hay un rótulo <código>&lt;we:else/&gt;</código> sin un rótulo final <código>&lt;we:if...&gt;</código>!";
$GLOBALS["l_parser"]["attrib_missing"] = "El atributo '%s' del rótulo <código>&lt;we:%s&gt;</código> no se encuentra o está vacío!";
$GLOBALS["l_parser"]["attrib_missing2"] = "El atributo '%s' del rótulo <código>&lt;we:%s&gt;</código> no se encuentra!";
$GLOBALS["l_parser"]["missing_open_tag"] = "<code>&lt;%s&gt;</code>: The opening tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["missing_close_tag"] = "<code>&lt;%s&gt;</code>: The closing tag is missing."; // TRANSLATE
$GLOBALS["l_parser"]["name_empty"] = "El nombre del rótulo <código>&lt;we:%s&gt;</código> está vacío!";
$GLOBALS["l_parser"]["invalid_chars"] =  "El nombre del rótulo <código>&lt;we:%s&gt;</código> contiene carácteres no válidos. Solamente son permitidos los carácteres alfabéticos, números, '-' y '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "El nombre del rótulo <código>&lt;we:%s&gt;</código> es demasiado largo! Solamente debe contener un máximo de 255 carácteres!";
$GLOBALS["l_parser"]["name_with_space"] =  "¡El nombre del rótulo <code>&lt;we:%s&gt;</code> no debe contener espacios (tales como la tecla semejante a la tecla del ENTER, el tabulador, alimentación de linea, etc.)!";
$GLOBALS["l_parser"]["client_version"] = "La sintaxis del atributo 'versión' del rótulo <código>&lt;we:ifClient&gt;</código> es incorrecta!";
$GLOBALS["l_parser"]["html_tags"] = "La plantilla debe, o incluir los rótulos HTML <código>&lt;html&gt; &lt;head&gt; &lt;body&gt;</código> o ninguno de estos rótulos. De lo contrario, el programa analizador sintáctico no podrá trabajar correctamente!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "La etiqueta <code>&lt;we:field&gt;</code>-  tiene que estar encerrada por un <code&gt;</code>&lt;we:listview&gt;</code> o <code&gt;</code>&lt;we:object&gt;</code> comienzo- y fin de etiqueta!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "La etiqueta <code>&lt;we:setVar from=\"listview\" ... &gt;</code>- tiene que estar encerrada por un <code>&lt;we:listview&gt;</code> comienzo- y fin de etiqueta!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "El atributo jsIncludePath de la etiqueta <code>&lt;we:checkForm&gt;</code> fue dado como un número (ID). Sin embargo no hay documento con tal id!";
$GLOBALS["l_parser"]["checkForm_password"] = "El atributo contraseña de <code>&lt;we:checkForm&gt;</code> tiene que ser 3 valores separados por comas!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
$GLOBALS["l_parser"]["multi_object_name_missing_error"] = "Error: The object field &quot;%s, specified in the attribute &quot;name&quot;, does not exist!"; // TRANSLATE
$GLOBALS["l_parser"]["template_recursion_error"] = "Error: Too much recursion!"; // TRANSLATE
?>