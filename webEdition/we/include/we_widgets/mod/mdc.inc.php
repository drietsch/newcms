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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

// widget MY DOCUMENTS
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
protect();
$mdc = "";
$ct["image"] = true;
$aCsv = explode(";", $aProps[3]);
$_binary = $aCsv[1];
$_table = ($_binary{1}) ? OBJECT_FILES_TABLE : FILE_TABLE;
$_csv = $aCsv[2];

if ($_binary{0} && !empty($_csv)) {
	$_ids = explode(",", $_csv);
	$_paths = makeArrayFromCSV(id_to_path($_ids, $_table));
	$_where = array();
	foreach ($_paths as $_path) {
		$_where[] = 'Path LIKE "' . $_path . '%" ';
	}
	$_query = "SELECT ID,Path,Icon,Text,ContentType FROM " . $_table . ' WHERE (' . implode(' OR ', $_where) . ') AND IsFolder=0' . ((!$ct["image"]) ? ' AND ContentType<>"image/*"' : '') . ';';
} else 
	if (!$_binary{0} && !empty($_csv)) {
		list($folderID, $folderPath) = explode(",", $_csv);
		$q_path = 'Path LIKE "' . $folderPath . '%"';
		$q_dtTid = ($aCsv[3] != 0) ? (!$_binary{1} ? 'DocType' : 'TableID') . '="' . $aCsv[3] . '"' : '';
		if ($aCsv[4] != "") {
			$_cats = explode(",", $aCsv[4]);
			$_categories = array();
			foreach ($_cats as $_myCat) {
				$_id = f(
						'SELECT ID FROM ' . CATEGORY_TABLE . ' WHERE Path="' . base64_decode($_myCat) . '";', 
						'ID', 
						$DB_WE);
				$_categories[] = 'Category LIKE ",' . $_id . ',"';
			}
		}
		$_query = 'SELECT ID,Path,Icon,Text,ContentType FROM ' . $_table . ' WHERE ' . $q_path . (($q_dtTid) ? ' AND ' . $q_dtTid : '') . ((isset(
				$_categories)) ? ' AND (' . implode(' OR ', $_categories) . ')' : '') . ' AND IsFolder=0;';
	}
if (!empty($_csv) && $DB_WE->query($_query)) {
	$mdc .= '<table cellspacing="0" cellpadding="0" border="0">';
	while ($DB_WE->next_record()) {
		$mdc .= '<tr><td width="20" height="20" valign="middle" nowrap>' . we_htmlElement::htmlImg(
				array(
					"src" => ICON_DIR . $DB_WE->f("Icon")
				)) . getpixel(4, 1) . '</td><td valign="middle" class="middlefont">' . we_htmlElement::htmlA(
				array(
					
						"href" => 'javascript:top.weEditorFrameController.openDocument(\'' . $_table . '\',\'' . $DB_WE->f(
								"ID") . '\',\'' . $DB_WE->f("ContentType") . '\')"', 
						"title" => $DB_WE->f("Path"), 
						"style" => "color:#000000;text-decoration:none;"
				), 
				$DB_WE->f("Path")) . '</td></tr>';
	}
	$mdc .= '</table>';
}

?>