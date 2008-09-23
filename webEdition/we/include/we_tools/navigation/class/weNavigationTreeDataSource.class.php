<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolTreeDataSource.class.php');

define('NAVIGATION_ITEMS', 1);
define('NAVIGATION_SORT_ITEMS', 2);
define('ADMIN_ITEMS', 3);

class weNavigationTreeDataSource extends weToolTreeDataSource
{

	function weNavigationTreeDataSource($ds)
	{
		parent::weToolTreeDataSource($ds);
	}

	function getItemsFromDB($ParentID = 0, $offset = 0, $segment = 500, $elem = 'ID,ParentID,Path,Text,Icon,IsFolder,Ordn,Depended,Charset', $addWhere = '', $addOrderBy = '')
	{
		$db = new DB_WE();
		$table = $this->SourceName;
		
		$items = array();
		
		$wsQuery = '';
		$_aWsQuery = array();
		$parentpaths = array();
		
		if ($ws = get_ws($table)) {
			$wsPathArray = id_to_path($ws, $table, $db, false, true);
			foreach ($wsPathArray as $path) {
				$_aWsQuery[] = " Path like '$path/%' OR " . weNavigationTreeDataSource::getQueryParents($path);
				while ($path != "/" && $path != "\\" && $path) {
					array_push($parentpaths, $path);
					$path = dirname($path);
				}
			}
			$wsQuery = !empty($_aWsQuery) ? '(' . implode(' OR ', $_aWsQuery) . ') AND ' : '';
		}
		
		$prevoffset = $offset - $segment;
		$prevoffset = ($prevoffset < 0) ? 0 : $prevoffset;
		if ($offset && $segment) {
			$items[] = array(
				
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
		
		$where = " WHERE $wsQuery ParentID=$ParentID " . $addWhere;
		
		$db->query(
				"SELECT $elem, abs(text) as Nr, (text REGEXP '^[0-9]') as isNr from $table $where ORDER BY Ordn, isNr DESC,Nr,Text " . ($segment ? "LIMIT $offset,$segment;" : ";"));
		$now = time();
		
		while ($db->next_record()) {
			
			if ($db->f('IsFolder') == 1)
				$typ = array(
					'typ' => 'group'
				);
			else
				$typ = array(
					'typ' => 'item'
				);
			
			$typ['open'] = 0;
			$typ['disabled'] = 0;
			$typ['tooltip'] = $db->f('ID');
			$typ['offset'] = $offset;
			$typ['order'] = $db->f('Ordn');
			$typ['published'] = $db->f('Depended') ? 0 : 1;
			$typ['disabled'] = in_array($db->f('Path'), $parentpaths) ? 1 : 0;
			
			$fileds = array();
			
			foreach ($db->Record as $k => $v) {
				if (!is_numeric($k))
					$fileds[strtolower($k)] = $v;
			}
			
			if ($db->f('IsFolder') == 0) {
				$_charset = weNavigation::findCharset($db->f('ParentID'));
			} else {
				$_charset = $db->f('Charset');
			}
			$_textUncleaned = $db->f('Text');
			$_textUncleaned = strtr($_textUncleaned, array(
				"<br>" => " ", "<br/>" => " ", "<br />" => " "
			));
			
			$_text = str_replace('&amp;', '&', strip_tags($_textUncleaned));
			$_path = str_replace('&amp;', '&', $db->f('Path'));
			
			if (!empty($_charset) && function_exists('mb_convert_encoding')) {
				$typ['text'] = mb_convert_encoding($_text, 'HTML-ENTITIES', $_charset);
				$typ['path'] = mb_convert_encoding($_path, 'HTML-ENTITIES', $_charset);
			} else {
				$typ['text'] = $_text;
				$typ['path'] = $_path;
			}
			
			$items[] = array_merge($fileds, $typ);
		
		}
		
		$total = f("SELECT COUNT(*) as total FROM $table $where;", 'total', $db);
		$nextoffset = $offset + $segment;
		if ($segment && ($total > $nextoffset)) {
			$items[] = array(
				
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
		
		return $items;
	
	}

}

?>