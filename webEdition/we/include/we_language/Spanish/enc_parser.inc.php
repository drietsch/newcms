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
$GLOBALS["l_parser"]["wrong_type"] = "El valor de \"tipo\" es no v�lido!";
$GLOBALS["l_parser"]["error_in_template"] = "Error de plantilla!";
$GLOBALS["l_parser"]["start_endtag_missing"] = "A uno o m�s r�tulos <c�digo>&lt;we:%s&gt;</c�digo> les faltan un r�tulo inicio o un r�tulo final!";
$GLOBALS["l_parser"]["tag_not_known"] = "El r�tulo <c�digo>'&lt;we:%s&gt;'</c�digo> es desconocido!";
$GLOBALS["l_parser"]["else_start"] = "Hay un r�tulo <c�digo>&lt;we:else/&gt;</c�digo> sin un r�tulo inicio <c�digo>&lt;we:if...&gt;</c�digo> !";
$GLOBALS["l_parser"]["else_end"] = "Hay un r�tulo <c�digo>&lt;we:else/&gt;</c�digo> sin un r�tulo final <c�digo>&lt;we:if...&gt;</c�digo>!";
$GLOBALS["l_parser"]["attrib_missing"] = "El atributo '%s' del r�tulo <c�digo>&lt;we:%s&gt;</c�digo> no se encuentra o est� vac�o!";
$GLOBALS["l_parser"]["attrib_missing2"] = "El atributo '%s' del r�tulo <c�digo>&lt;we:%s&gt;</c�digo> no se encuentra!";
$GLOBALS["l_parser"]["name_empty"] = "El nombre del r�tulo <c�digo>&lt;we:%s&gt;</c�digo> est� vac�o!";
$GLOBALS["l_parser"]["invalid_chars"] =  "El nombre del r�tulo <c�digo>&lt;we:%s&gt;</c�digo> contiene car�cteres no v�lidos. Solamente son permitidos los car�cteres alfab�ticos, n�meros, '-' y '_'!";
$GLOBALS["l_parser"]["name_to_long"] =  "El nombre del r�tulo <c�digo>&lt;we:%s&gt;</c�digo> es demasiado largo! Solamente debe contener un m�ximo de 255 car�cteres!";
$GLOBALS["l_parser"]["name_with_space"] =  "�El nombre del r�tulo <code>&lt;we:%s&gt;</code> no debe contener espacios (tales como la tecla semejante a la tecla del ENTER, el tabulador, alimentaci�n de linea, etc.)!";
$GLOBALS["l_parser"]["client_version"] = "La sintaxis del atributo 'versi�n' del r�tulo <c�digo>&lt;we:ifClient&gt;</c�digo> es incorrecta!";
$GLOBALS["l_parser"]["html_tags"] = "La plantilla debe, o incluir los r�tulos HTML <c�digo>&lt;html&gt; &lt;head&gt; &lt;body&gt;</c�digo> o ninguno de estos r�tulos. De lo contrario, el programa analizador sint�ctico no podr� trabajar correctamente!";
$GLOBALS["l_parser"]["field_not_in_lv"] = "La etiqueta <code>&lt;we:field&gt;</code>-  tiene que estar encerrada por un <code&gt;</code>&lt;we:listview&gt;</code> o <code&gt;</code>&lt;we:object&gt;</code> comienzo- y fin de etiqueta!";
$GLOBALS["l_parser"]["setVar_lv_not_in_lv"] = "La etiqueta <code>&lt;we:setVar from=\"listview\" ... &gt;</code>- tiene que estar encerrada por un <code>&lt;we:listview&gt;</code> comienzo- y fin de etiqueta!";
$GLOBALS["l_parser"]["checkForm_jsIncludePath_not_found"] = "El atributo jsIncludePath de la etiqueta <code>&lt;we:checkForm&gt;</code> fue dado como un n�mero (ID). Sin embargo no hay documento con tal id!";
$GLOBALS["l_parser"]["checkForm_password"] = "El atributo contrase�a de <code>&lt;we:checkForm&gt;</code> tiene que ser 3 valores separados por comas!";
$GLOBALS["l_parser"]["missing_createShop"] = "The tag <code>&lt;we:%s&gt;</code> can only be used after<code>&lt;we:createShop&gt;</code>."; // TRANSLATE
?>