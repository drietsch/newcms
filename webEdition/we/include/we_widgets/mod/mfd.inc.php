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

// widget LAST MODIFIED


include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/date.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_history.class.php");
protect();
$sCsv = $aProps[3];
$aCols = explode(";", $sCsv);
$sTypeBinary = $aCols[0];
$bTypeDoc = (bool)$sTypeBinary{0};
$bTypeTpl = (bool)$sTypeBinary{1};
$bTypeObj = (bool)$sTypeBinary{2};
$bTypeCls = (bool)$sTypeBinary{3};
$iDate = $aCols[1];
switch ($iDate) {
	case 1 :
		$timestamp = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		break;
	case 2 :
		$iTime = time() - (7 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
	case 3 :
		$iTime = time() - (30 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
	case 4 :
		$iTime = time() - (365 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
}
$iNumItems = $aCols[2];
switch ($iNumItems) {
	case 0 :
		$iMaxItems = 200;
		break;
	case 11 :
		$iMaxItems = 15;
		break;
	case 12 :
		$iMaxItems = 20;
		break;
	case 13 :
		$iMaxItems = 25;
		break;
	case 14 :
		$iMaxItems = 50;
		break;
	default :
		$iMaxItems = $iNumItems;
}
$sDisplayOpt = $aCols[3];
$bMfdBy = $sDisplayOpt{0};
$bDateLastMfd = $sDisplayOpt{1};
$aUsers = makeArrayFromCSV($aCols[4]);

$_where = array();
$_ws = array();
$_users_where = array();
foreach ($aUsers as $uid) {
	$_users_where[] = '"' . basename(id_to_path($uid, USER_TABLE)) . '"';
}

if ($bTypeDoc && we_hasPerm('CAN_SEE_DOCUMENTS') && defined("FILE_TABLE")) {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', FILE_TABLE) . '"';
	$_ws[FILE_TABLE] = get_ws(FILE_TABLE);
}
if ($bTypeObj && we_hasPerm('CAN_SEE_OBJECTFILES') && defined("OBJECT_FILES_TABLE")) {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', OBJECT_FILES_TABLE) . '"';
	$_ws[OBJECT_FILES_TABLE] = get_ws(OBJECT_FILES_TABLE);
}
if ($bTypeTpl && we_hasPerm('CAN_SEE_TEMPLATES') && defined("TEMPLATES_TABLE") && $_SESSION["we_mode"] != "seem") {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', TEMPLATES_TABLE) . '"';
}
if ($bTypeCls && we_hasPerm('CAN_SEE_OBJECTS') && defined("OBJECT_TABLE") && $_SESSION["we_mode"] != "seem") {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', OBJECT_TABLE) . '"';
}
if ($_SESSION["we_mode"] == "seem") {
	$_whereSeem = " AND ContentType!='folder' ";
} else {
	$_whereSeem = "";
}

$lastModified = '';
$lastModified .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
$_count = 10;
$i = $j = $k = 0;
while ($j < $iMaxItems) {
	$_query = "SELECT * FROM " . HISTORY_TABLE . (!empty($_where) ? (' WHERE ' . ((count($_users_where) > 0) ? 'UserName IN (' . implode(
			',', 
			$_users_where) . ') AND ' : '') . 'DocumentTable IN(' . implode(',', $_where) . ')') : '') . (($iDate) ? ' AND ModDate >' . abs($timestamp) : '') . $_whereSeem . ' ORDER BY ModDate DESC LIMIT ' . ($k * $_count) . " , " . $_count . ";";
	$k++;
	$DB_WE->query($_query);
	$_db = new DB_WE();
	$num_rows = $DB_WE->num_rows();
	if ($num_rows == 0) {
		break;
	}
	while ($DB_WE->next_record()) {
		$_table = TBL_PREFIX . $DB_WE->f("DocumentTable");
		$_paths = array();
		$_bool_ot = (defined("OBJECT_TABLE")) ? (($_table != OBJECT_TABLE) ? true : false) : true;
		if (!we_hasPerm('ADMINISTRATOR') || ($_table != TEMPLATES_TABLE && $_bool_ot)) {
			if (isset($_ws[$_table])) {
				$_wsa = makeArrayFromCSV($_ws[$_table]);
				foreach ($_wsa as $_id) {
					$_paths[] = 'Path LIKE ("' . mysql_real_escape_string(id_to_path($_id, $_table)) . '%")';
				}
			}
		}
		$_hash = getHash(
				"SELECT ID,Path,Icon,Text,ContentType,ModDate,CreatorID,Owners,RestrictOwners FROM " . mysql_real_escape_string($_table) . " WHERE ID = '" . abs($DB_WE->f(
						"DID")) . "'" . (!empty($_paths) ? (' AND (' . implode(' OR ', $_paths) . ')') : '') . ";", 
				$_db);
		if (!empty($_hash)) {
			$_show = true;
			$_bool_oft = (defined("OBJECT_FILES_TABLE")) ? (($_table == OBJECT_FILES_TABLE) ? true : false) : true;
			
			if ($_table == FILE_TABLE || $_bool_oft) {
				$_show = we_history::userHasPerms($_hash['CreatorID'], $_hash['Owners'], $_hash['RestrictOwners']);
			}
			if ($_show) {
				if ($i + 1 <= $iMaxItems) {
					$i++;
					$j++;
					$lastModified .= '<tr>';
					$lastModified .= '<td width="20" height="20" valign="middle" nowrap><img src="' . ICON_DIR . $_hash['Icon'] . '">' . getpixel(
							4, 
							1) . '</td>';
					$lastModified .= '<td valign="middle" class="middlefont">';
					$lastModified .= '<a href="' . 'javascript:top.weEditorFrameController.openDocument(\'' . $_table . '\',\'' . $_hash['ID'] . '\',\'' . $_hash['ContentType'] . '\')"' . ' title="' . $_hash['Path'] . '" style="color:#000000;text-decoration:none;">' . $_hash['Path'] . "</a></td>";
					if ($bMfdBy)
						$lastModified .= '<td>' . getpixel(5, 1) . '</td><td class="middlefont" nowrap>' . $DB_WE->f(
								"UserName") . (($bDateLastMfd) ? ',' : '') . '</td>';
					if ($bDateLastMfd)
						$lastModified .= '<td>' . getpixel(5, 1) . '</td><td class="middlefont" nowrap>' . date(
								$GLOBALS["l_global"]["date_format"], 
								$_hash['ModDate']) . '</td>';
					$lastModified .= "</tr>\n";
				} else {
					break;
				}
			} else {
				$j++;
			}
		} else {
			break;
		}
	}
}

$lastModified .= "</table>\n";

?>