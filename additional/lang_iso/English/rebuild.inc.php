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
$GLOBALS["l_rebuild"]["rebuild_documents"] = "Rebuild - documents";
$GLOBALS["l_rebuild"]["rebuild_maintable"] = "Resave main table";
$GLOBALS["l_rebuild"]["rebuild_tmptable"] = "Resave temporary table";
$GLOBALS["l_rebuild"]["rebuild_objects"] = "Objects";
$GLOBALS["l_rebuild"]["rebuild_index"] = "Index-table";
$GLOBALS["l_rebuild"]["rebuild_all"] = "All documents and templates";
$GLOBALS["l_rebuild"]["rebuild_templates"] = "All templates";
$GLOBALS["l_rebuild"]["rebuild_filter"] = "Static webEdition pages";
$GLOBALS["l_rebuild"]["rebuild_thumbnails"] = "Rebuild - generate thumbnails";
$GLOBALS["l_rebuild"]["txt_rebuild_documents"] = "With this option the documents and templates saved in the data base will be written to the file system.";
$GLOBALS["l_rebuild"]["txt_rebuild_objects"] = "Choose this option to rewrite the object tables. This is only necessary if the object tables are incorrect.";
$GLOBALS["l_rebuild"]["txt_rebuild_index"] = "If in search some documents can not be found or are being found several times, you can rewrite the index table thus the search index here.";
$GLOBALS["l_rebuild"]["txt_rebuild_thumbnails"] = "Here you can rewrite the thumbnails of your graphics.";
$GLOBALS["l_rebuild"]["txt_rebuild_all"] = "With this option all documents and templates will be rewritten.";
$GLOBALS["l_rebuild"]["txt_rebuild_templates"] = "With this option all templates will be rewritten.";
$GLOBALS["l_rebuild"]["txt_rebuild_filter"] = "Here you can specify which static webEdition pages should be rewritten. If you don't select a criteria all static webEdition pages will be rewritten.";
$GLOBALS["l_rebuild"]["rebuild"] = "Rebuild";
$GLOBALS["l_rebuild"]["dirs"] = "Directories";
$GLOBALS["l_rebuild"]["thumbdirs"] = "For graphics in the following directories";
$GLOBALS["l_rebuild"]["thumbnails"] = "Generate thumbnails";
$GLOBALS["l_rebuild"]["documents"] = "Documents and templates";
$GLOBALS["l_rebuild"]["catAnd"] = "AND concatenation";
$GLOBALS["l_rebuild"]["finished"] = "The rebuild was successful!";
$GLOBALS["l_rebuild"]["nothing_to_rebuild"] = "There are no documents that correspond to the criteria!";
$GLOBALS["l_rebuild"]["no_thumbs_selected"] = "Please, choose at least one thumbnail!";
$GLOBALS["l_rebuild"]["savingDocument"] = "Saving document: ";
$GLOBALS["l_rebuild"]["navigation"] = "Navigation";
$GLOBALS["l_rebuild"]["rebuild_navigation"] = "Rebuild - Navigation";
$GLOBALS["l_rebuild"]["txt_rebuild_navigation"] = "Here you can rewrite the navigation cache.";
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviCheck"] = 'Rebuild static documents afterwards.';
$GLOBALS["l_rebuild"]["rebuildStaticAfterNaviHint"] = 'For static navigation entries a rebuild of the corresponding documents is necessary, in addition.';
$GLOBALS["l_rebuild"]["metadata"] = 'Meta data fields';
$GLOBALS["l_rebuild"]["txt_rebuild_metadata"] = 'To import the meta data of your images subsequently, choose this option.';  // TRANSLATE
$GLOBALS["l_rebuild"]["rebuild_metadata"] = 'Rebuild - meta data fields';
$GLOBALS["l_rebuild"]["onlyEmpty"] = 'Import only empty meta data fields';
$GLOBALS["l_rebuild"]["expl_rebuild_metadata"] = 'Select the meta data fields you want to import. To import only fields which already have no content, select the option "Import only empty meta data fields".'; // TRANSLATE
$GLOBALS["l_rebuild"]["noFieldsChecked"] = "Al least one meta data field must be selected!"; // TRANSLATE

?>