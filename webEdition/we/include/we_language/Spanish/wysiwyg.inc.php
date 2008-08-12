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
 * Language file: wysiwyg.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_wysiwyg"]["no_table_selected"] = "El cursor no está dentro de la tabla!";
$GLOBALS["l_wysiwyg"]["mozilla_paste"] = "Por razones de seguridad, las funciones 'copiar', 'cortar' y 'pegar' no están trabajando en el navegador Mozilla. Por favor, use los comandos del teclado CTRL-C, CTRL-X o CTRL-V en PCs o &#x2318;-C, &#x2318;-X o &#x2318;-V en computadoras Macintosh!";
$GLOBALS["l_wysiwyg"]["nothing_selected"] = "No hay nada seleccionado!";
$GLOBALS["l_wysiwyg"]["selection_invalid"] = "La selección no es válida!";
$GLOBALS["l_wysiwyg"]["window_title"] = "Editar campo '%s'";
$GLOBALS["l_wysiwyg"]["hide_borders"] = "Ocultar bordes";

$GLOBALS["l_wysiwyg"]["removeformat_warning"] = "Estas funciones removerán el formato de todo el campo de texto! Desea realmente Ud continuar?";

$GLOBALS["l_wysiwyg"]["format"] = "Formato";
$GLOBALS["l_wysiwyg"]["fontsize"] = "Tamaño de la fuente";
$GLOBALS["l_wysiwyg"]["fontname"] = "Nombre de la fuente";

$GLOBALS["l_wysiwyg"]["css_style"] = "Estilo CSS";
$GLOBALS["l_wysiwyg"]["anchor_name"] = "Nombre del anclaje";

$GLOBALS["l_wysiwyg"]["normal"] = "Normal"; // TRANSLATE
$GLOBALS["l_wysiwyg"]["h1"] = "Encabezamiento 1";
$GLOBALS["l_wysiwyg"]["h2"] = "Encabezamiento 2";
$GLOBALS["l_wysiwyg"]["h3"] = "Encabezamiento 3";
$GLOBALS["l_wysiwyg"]["h4"] = "Encabezamiento 4";
$GLOBALS["l_wysiwyg"]["h5"] = "Encabezamiento 5";
$GLOBALS["l_wysiwyg"]["h6"] = "Encabezamiento 6";
$GLOBALS["l_wysiwyg"]["pre"] = "Formateado";
$GLOBALS["l_wysiwyg"]["address"] = "Dirección";

?>