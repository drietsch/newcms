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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolTreeDataSource.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/searchtool.inc.php');

class searchtoolTreeDataSource extends weToolTreeDataSource
{

	var $treeItems = array();

	function searchtoolTreeDataSource($ds)
	{
		weToolTreeDataSource::weToolTreeDataSource($ds);
	}

	function getItemsFromDB($ParentID = 0, $offset = 0, $segment = 500, $elem = 'ID,ParentID,Path,Text,Icon,IsFolder', $addWhere = '', $addOrderBy = '')
	{
		$db = new DB_WE();
		$table = $this->SourceName;
		$openFolders = array();
		
		if (isset($_SESSION["weSearch"]["modelidForTree"])) {
			$id = $_SESSION["weSearch"]["modelidForTree"];
			$pid = f("
        SELECT ParentID
        FROM " . mysql_real_escape_string($table) . "
        WHERE ID='".abs($id)."'", "ParentID", $db);
			$openFolders[] = $pid;
			while ($pid > 0) {
				$pid = f("
          SELECT ParentID
          FROM ".mysql_real_escape_string($table)."
          WHERE ID='" . abs($pid) . "'", "ParentID", $db);
				$openFolders[] = $pid;
			}
		}
		
		$wsQuery = '';
		$prevoffset = $offset - $segment;
		$prevoffset = ($prevoffset < 0) ? 0 : $prevoffset;
		if ($offset && $segment) {
			$this->treeItems[] = array(
				
					'icon' => 'arrowup.gif', 
					'id' => 'prev_' . $ParentID, 
					'parentid' => $ParentID, 
					'text' => 'display (' . $prevoffset . '-' . $offset . ')', 
					'contenttype' => 'arrowup', 
					'table' => $table, 
					'typ' => 'threedots', 
					'open' => 0, 
					'published' => 0, 
					'disabled' => 0, 
					'tooltip' => '', 
					'offset' => $prevoffset
			);
		}
		
		$where = " WHERE $wsQuery ParentID=".abs($ParentID)." " . $addWhere;
		
		$db->query(
				"SELECT $elem, LOWER(Text) AS lowtext, abs(Text) as Nr, (Text REGEXP '^[0-9]') as isNr from ".mysql_real_escape_string($table)." $where ORDER BY isNr DESC,Nr,lowtext,Text " . ($segment ? "LIMIT ".abs($offset).",".abs($segment).";" : ";"));
		
		while ($db->next_record()) {
			if (($db->f('ID') == 3 || $db->f('ID') == 7) && (!defined('OBJECT_FILES_TABLE') || !defined(
					'OBJECT_TABLE') || !we_hasPerm('CAN_SEE_OBJECTFILES'))) {
			} elseif (($db->f('ID') == 2 || $db->f('ID') == 4 || $db->f('ID') == 5 || $db->f('ID') == 6) && !we_hasPerm(
					'CAN_SEE_DOCUMENTS')) {
			} elseif (($db->f('Path') == '/Versionen' || $db->f('Path') == '/Versionen/Dokumente' || $db->f('Path') == '/Versionen/Objekte' || $db->f(
					'Path') == '/Versionen/Dokumente/gel�schte Dokumente' || $db->f('Path') == '/Versionen/Objekte/gel�schte Objekte') && !we_hasPerm(
					'SEE_VERSIONS')) {
			} else {
				if (in_array($db->f('ID'), $openFolders))
					$OpenCloseStatus = 1;
				else
					$OpenCloseStatus = 0;
				
				if ($db->f('IsFolder') == 1)
					$typ = array(
						'typ' => 'group'
					);
				else
					$typ = array(
						'typ' => 'item'
					);
				
				$typ['icon'] = $db->f('Icon');
				$typ['open'] = $OpenCloseStatus;
				$typ['disabled'] = 0;
				$typ['tooltip'] = $db->f('ID');
				$typ['offset'] = $offset;
				$typ['order'] = $db->f('Ordn');
				$typ['published'] = 1;
				$typ['disabled'] = 0;
				
				$fields = array();
				
				foreach ($db->Record as $k => $v) {
					if (!is_numeric($k))
						$fields[strtolower($k)] = $v;
				}
				
				global $l_weSearch;

				$_text = htmlspecialchars(searchtool::getLangText($db->f('Path'), $db->f('Text')));
			
				$typ['text'] = $_text;
				
				$this->treeItems[] = array_merge($fields, $typ);
				
				if ($typ['typ'] == "group" && $OpenCloseStatus == 1)
					$this->getItemsFromDB($db->f('ID'), 0, $segment);
			}
		}
		
		$total = f("SELECT COUNT(*) as total FROM ".mysql_real_escape_string($table)." $where;", 'total', $db);
		$nextoffset = $offset + $segment;
		if ($segment && ($total > $nextoffset)) {
			$this->treeItems[] = array(
				
					'icon' => 'arrowdown.gif', 
					'id' => 'next_' . $ParentID, 
					'parentid' => $ParentID, 
					'text' => 'display (' . $nextoffset . '-' . ($nextoffset + $segment) . ')', 
					'contenttype' => 'arrowdown', 
					'table' => $table, 
					'typ' => 'threedots', 
					'open' => 0, 
					'disabled' => 0, 
					'tooltip' => '', 
					'offset' => $nextoffset
			);
		}
		
		return $this->treeItems;
	}
}
?>
