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
 * Language file: rebuild.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_rebuild"]["rebuild_documents"] = "Rebuild - documents"; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_maintable"] = "Salvar nuevamente la tabla principal";
$GLOBALS["l_rebuild"]["rebuild_tmptable"] = "Salvar nuevamente la tabla temporal";
$GLOBALS["l_rebuild"]["rebuild_objects"] = "Objetos";
$GLOBALS["l_rebuild"]["rebuild_index"] = "Tabla-índice";
$GLOBALS["l_rebuild"]["rebuild_all"] = "Todos documentos y plantillas";
$GLOBALS["l_rebuild"]["rebuild_templates"] = "Todos plantillas";
$GLOBALS["l_rebuild"]["rebuild_filter"] = "Páginas webEdition estáticas";
$GLOBALS["l_rebuild"]["rebuild_thumbnails"] = "Reconstruir - generar imágenes en miniatura";
$GLOBALS["l_rebuild"]["txt_rebuild_documents"] = "With this option the documents and templates saved in the data base will be written to the file system."; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_objects"] = "Escoja esta opción para reescribir las tablas de objetos. Esto es solamente necesario si las tablas de objetos son incorrectas.";
$GLOBALS["l_rebuild"]["txt_rebuild_index"] = "If in search some documents can not be found or are being found several times, you can rewrite the index table thus the search index here."; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_thumbnails"] = "Aquí Ud puede reescribir las imágenes en miniatura de sus gráficos.";
$GLOBALS["l_rebuild"]["txt_rebuild_all"] = "Con esta opción serán reescritos todos los documentos y plantillas.";
$GLOBALS["l_rebuild"]["txt_rebuild_templates"] = "Con esta opción serán reescritos todos los plantillas.";
$GLOBALS["l_rebuild"]["txt_rebuild_filter"] = "Aquí Ud puede especificar cuales páginas webEdition estáticas deben ser reescritas. Si Ud no selecciona un criterio, todas las páginas webEdition estáticas serán reescritas.";
$GLOBALS["l_rebuild"]["rebuild"] = "Reconstruir";
$GLOBALS["l_rebuild"]["dirs"] = "Directorios";
$GLOBALS["l_rebuild"]["thumbdirs"] = "Para los gráficos en los siguientes directorios";
$GLOBALS["l_rebuild"]["thumbnails"] = "Generar imágenes en miniatura";
$GLOBALS["l_rebuild"]["documents"] = "Documents and templates"; // TRANSLATE
$GLOBALS["l_rebuild"]["catAnd"] = "Concatenación Y";
$GLOBALS["l_rebuild"]["finished"] = "La reconstrucción fue exitosa!";
$GLOBALS["l_rebuild"]["nothing_to_rebuild"] = "No hay documentos que se correspondan al criterio!";
$GLOBALS["l_rebuild"]["no_thumbs_selected"] = "Por favor, escoja al menos una imagen en miniatura!";
$GLOBALS["l_rebuild"]["savingDocument"] = "Salvando documento: ";
$GLOBALS["l_rebuild"]["navigation"] = "Navigation"; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_navigation"] = "Rebuild - Navigation"; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_navigation"] = "Here you can rewrite the navigation cache."; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviCheck"] = 'Rebuild static documents afterwards.'; // TRANSLATE
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviHint"] = 'For static navigation entries a rebuild of the corresponding documents is necessary, in addition.'; // TRANSLATE
$GLOBALS["l_rebuild"]["metadata"] = 'Meta data fields'; // TRANSLATE
$GLOBALS["l_rebuild"]["txt_rebuild_metadata"] = 'To import the meta data of your images subsequently, choose this option.'; // TRANSLATE  // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_metadata"] = 'Rebuild - meta data fields'; // TRANSLATE
$GLOBALS["l_rebuild"]["onlyEmpty"] = 'Import only empty meta data fields'; // TRANSLATE
$GLOBALS["l_rebuild"]["expl_rebuild_metadata"] = 'Select the meta data fields you want to import. To import only fields which already have no content, select the option "Import only empty meta data fields".'; // TRANSLATE // TRANSLATE
$GLOBALS["l_rebuild"]["noFieldsChecked"] = "Al least one meta data field must be selected!"; // TRANSLATE // TRANSLATE

?>