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
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "You have selected a link which points to a document that is not administered by webEdition. Continue?"; // TRANSLATE
$l_we_SEEM["ext_document_on_other_server_selected"] = "Ud ha seleccionado un vínculo que apunta a un documento en otro servidor Web.\\nEsto abrirá una nueva ventana del navegador. Continuar?";
$l_we_SEEM["ext_form_target_other_server"] = "Ud está a punto de someter una forma a otro servidor Web.\\nEsto abrirá una nueva ventana del navegador. Continuar? ";
$l_we_SEEM["ext_form_target_we_server"] = "El formulario enviará data a un documento, el cual no es administrado por webEdition.\\nContinuar?";

$l_we_SEEM["ext_doc"] = "El documento actual: <b>%s</b> es <u>no</u> editable con webEdition.";
$l_we_SEEM["ext_doc_not_found"] = "No se pudo encontrar la página selecioanda <b>%s</b>.";
$l_we_SEEM["ext_doc_tmp"] = "Este documento no fue abierto correctamente por webEdition. Por favor, use la navegación normal del sitio Web para alcanzar su documento deseado.";

$l_we_SEEM["info_ext_doc"] = "Sin vínculo webEdition";
$l_we_SEEM["info_doc_with_parameter"] = "Vínculo con parámetro";
$l_we_SEEM["link_does_not_work"] = "El vínculo está desactivado en el modo vista previa. Por favor, use la navegación principal para moverse por la página.";
$l_we_SEEM["info_link_does_not_work"] = "Desactivado.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "UD está a punto de cambiar el contenido de la ventana principal de webEdition. Esta ventana se cerrará. Continuar?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Modo";
$l_we_SEEM["start_mode_normal"] = "Normal"; // TRANSLATE
$l_we_SEEM["start_mode_seem"] = "seeMode"; // TRANSLATE

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Ningún documento de inicio válido ha sido asignado.\nSu Administrador debe ajustar su documento de inicio.";
$l_we_SEEM["only_seem_mode_allowed"] = "Ud no tiene los permisos requeridos para iniciar webEdition en modo normal.\\nIniciando seeMode ...";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Documento inicio<br>para seeMode";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Intentelo nuevamente";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Ud no tiene permiso para editar este documento.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Ningún documento de inicio válido ha sido asignado.\\nDesea Ud escoger ahora un documento de inicio en el diálogo Preferencias?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Ud no tiene permiso para editar este documento.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Desea Ud cambiar a la vista previa?";

$l_we_SEEM["alert"]["changed_include"] = "Un archivo adjunto ha sido cambiado. El documento principal es recargado.";
$l_we_SEEM["alert"]["close_include"] = "Este archivo no es un documento webEdition. La ventana de adjunto es cerrada.";
?>