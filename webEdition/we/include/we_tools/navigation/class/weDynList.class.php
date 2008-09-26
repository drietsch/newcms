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

class weDynList
{

	function getDocuments($doctypeid, $dirid, $categories, &$sort, $count, $field)
	{
		$_select = array(
			
				FILE_TABLE . '.ID as ID', 
				FILE_TABLE . '.Text as Text', 
				LINK_TABLE . '.Name as FieldName', 
				CONTENT_TABLE . '.Dat as FieldData'
		);
		
		$_fieldset = weDynList::getDocData($_select, $doctypeid, id_to_path($dirid), $categories, 'AND', array(), array(), 0);
		$_docs = array();
		$_txt = array();
		$_fields = array();
		$_ids = array();
		
		while ($_fieldset->next_record()) {
			if (!isset($_docs[$_fieldset->Record['ID']])) {
				$_docs[$_fieldset->Record['ID']] = array();
			}
			$_docs[$_fieldset->Record['ID']][$_fieldset->Record['FieldName']] = $_fieldset->Record['FieldData'];
			
			$_txt[$_fieldset->Record['ID']] = $_fieldset->Record['Text'];
			
			if ($_fieldset->Record['FieldName'] == $field) {
				$_fields[$_fieldset->Record['ID']] = $_fieldset->Record['FieldData'];
			} else 
				if (!isset($_fields[$_fieldset->Record['ID']])) {
					$_fields[$_fieldset->Record['ID']] = $_fieldset->Record['Text'];
				}
		
		}
		
		unset($_fieldset);
		
		$_arr = array();
		$sort = is_array($sort) ? $sort : array();
		
		foreach ($sort as $_k => $_sort) {
			$_arr[$_k] = array();
			foreach ($_docs as $_id => $_doc) {
				if (in_array($_sort['field'], array_keys($_doc))) {
					$_arr[$_k]['id_' . $_id] = $_doc[$_sort['field']];
				} else {
					$_arr[$_k]['id_' . $_id] = $_fields[$_id];
				}
			}
			if ($_sort['order'] == 'DESC') {
				arsort($_arr[$_k], SORT_STRING);
			} else {
				asort($_arr[$_k], SORT_STRING);
			}
		}
		
		if (!empty($_arr)) {
			$_ids_tmp = array_keys($_arr[0]);
			
			$_ids = array();
			
			for ($_i = 0; $_i < $count; $_i++) {
				if (isset($_ids_tmp[$_i])) {
					$_id = str_replace('id_', '', $_ids_tmp[$_i]);
					$_ids[$_i] = array(
						
							'id' => str_replace('id_', '', $_id), 
							'text' => $_txt[$_id], 
							'field' => weNavigation::encodeSpecChars(isset($_fields[$_id]) ? $_fields[$_id] : '')
					);
				} else {
					break;
				}
			}
		} else {
			$_counter = 0;
			foreach ($_docs as $_id => $_doc) {
				if ($_counter < $count) {
					$_ids[] = array(
						
							'id' => $_id, 
							'field' => weNavigation::encodeSpecChars(isset($_fields[$_id]) ? $_fields[$_id] : ''), 
							'text' => $_txt[$_id]
					);
					$_counter++;
				} else {
					break;
				}
			
			}
		
		}
		
		return $_ids;
	
	}

	function getDocData($select = array(), $doctype, $dirpath = '/', $categories = array(), $catlogic = 'AND', $condition = array(), $order = array(), $offset = 0, $count = 999999999)
	{
		
		$_db = new DB_WE();
		$_cats = array();
		$categories = is_array($categories) ? $categories : makeArrayFromCSV($categories);
		foreach ($categories as $cat) {
			if (!is_numeric($cat)) {
				$cat = path_to_id($cat, CATEGORY_TABLE);
			}
			$_cats[] = '(Category LIKE "%,' . $cat . ',%")';
		}
		
		$dirpath = clearPath($dirpath . '/');
		
		$_query = 'SELECT ' . implode(',', $select) . ' FROM ' . FILE_TABLE . ',' . LINK_TABLE . ', ' . CONTENT_TABLE . ' WHERE (' . FILE_TABLE . '.ID=' . LINK_TABLE . '.DID AND ' . LINK_TABLE . '.CID=' . CONTENT_TABLE . '.ID) ' . ' AND (' . FILE_TABLE . '.IsFolder=0 AND ' . FILE_TABLE . '.Published>0) ' . ($doctype ? ' AND ' . FILE_TABLE . '.DocType=' . $doctype : '') . (count(
				$_cats) ? (' AND ' . implode(" $catlogic ", $_cats)) : '') . ($dirpath != '/' ? (' AND Path LIKE "' . $dirpath . '%"') : '') . ' ' . ($condition ? (' AND ' . implode(
				' AND ', 
				$condition)) : '') . ' ' . ($order ? (' ORDER BY ' . $order) : '') . ' ' . ' LIMIT ' . $offset . ',' . $count . ';';
		
		$_db->query($_query);
		
		return $_db;
	
	}

	function getObjects($classid, $dirid, $categories, &$sort, $count, $field)
	{
		
		$_select = array(
			'OF_ID', 'OF_Text'
		);
		
		if (!empty($field)) {
			$_select[] = $field;
		}
		
		$sort = is_array($sort) ? $sort : array();
		
		$_order = array();
		foreach ($sort as $_k => $_sort) {
			$_order[] = $_sort['field'] . ' ' . $_sort['order'];
		}
		
		$_fieldset = weDynList::getObjData(
				$_select, 
				$classid, 
				id_to_path($dirid, OBJECT_FILES_TABLE), 
				$categories, 
				'AND', 
				array(), 
				$_order, 
				0, 
				$count);
		$_ids = array();
		
		while ($_fieldset->next_record()) {
			
			$_ids[] = array(
				
					'id' => $_fieldset->Record['OF_ID'], 
					'text' => $_fieldset->Record['OF_Text'], 
					'field' => weNavigation::encodeSpecChars(
							!empty($_fieldset->Record[$field]) ? $_fieldset->Record[$field] : '')
			);
		
		}
		
		return $_ids;
	}

	function getObjData($select = array(), $classid, $dirpath = '/', $categories = array(), $catlogic = 'AND', $condition = array(), $order = array(), $offset = 0, $count = 999999999)
	{
		
		$_db = new DB_WE();
		$categories = is_array($categories) ? $categories : array();
		$_cats = array();
		foreach ($categories as $cat) {
			$_cats[] = '(OF_Category LIKE "%,' . path_to_id($cat, CATEGORY_TABLE) . ',%")';
		}
		
		$_where = array();
		
		if (count($_cats)) {
			$_where[] = implode(" $catlogic ", $_cats);
		}
		if ($condition) {
			$_where[] = implode(' AND ', $condition);
		}
		if ($dirpath != '/') {
			$_where[] = 'OF_Path LIKE "' . $dirpath . '%"';
		}
		
		$_query = 'SELECT ' . implode(',', $select) . ' FROM ' . OBJECT_X_TABLE . $classid . ' 
						WHERE OF_ID<>0 ' . (!empty($_where) ? ('AND ' . implode(
				' AND ', 
				$_where)) : '') . ($order ? (' ORDER BY ' . implode(',', $order)) : '') . ' ' . ' LIMIT ' . $offset . ',' . $count . ';';
		
		$_db->query($_query);
		
		return $_db;
	
	}

	function getCatgories($dirid, $count)
	{
		
		$_ids = array();
		$_query = 'SELECT * FROM ' . CATEGORY_TABLE . ' WHERE ParentID=' . $dirid . ' AND IsFolder=0 ' . ' LIMIT 0,' . $count . ';';
		$_fieldset = new DB_WE();
		$_fieldset->query($_query);
		
		while ($_fieldset->next_record()) {
			$_catfields = @unserialize($_fieldset->f('Catfields'));
			$_ids[] = array(
				
					'id' => $_fieldset->Record['ID'], 
					'text' => $_fieldset->Record['Text'], 
					'field' => weNavigation::encodeSpecChars(
							isset($_catfields['default']['Title']) ? $_catfields['default']['Title'] : '')
			);
		
		}
		
		return $_ids;
	
	}

	function getWorkspacesForObject($id)
	{
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_objectFile.inc.php');
		
		$_obj = new we_objectFile();
		$_obj->initByID($id, OBJECT_FILES_TABLE);
		
		$_values = array_merge(makeArrayFromCSV($_obj->Workspaces), makeArrayFromCSV($_obj->ExtraWorkspaces));
		
		$_all = makeArrayFromCSV($_obj->getPossibleWorkspaces(false));
		$_ret = array();
		foreach ($_values as $_k => $_id) {
			if (!weFileExists($_id) || !in_array($_id, $_all)) {
				unset($_values[$_k]);
			} else {
				$_ret[$_id] = id_to_path($_id);
			}
		}
		return $_ret;
	}

	function getWorkspacesForClass($id)
	{
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');
		
		$_obj = new we_object();
		$_obj->initByID($id, OBJECT_TABLE);
		
		$_values = makeArrayFromCSV($_obj->Workspaces);
		
		$_ret = array();
		foreach ($_values as $_k => $_id) {
			if (!weFileExists($_id)) {
				unset($_values[$_k]);
			} else {
				$_ret[$_id] = id_to_path($_id);
			}
		}
		return $_ret;
	}

	function getDocumentsWithWorkspacePath($ws)
	{
		$_ret = array();
		foreach ($ws as $_id => $_path) {
			$_ret[weDynList::getFirstDynDocument($_id)] = $_path;
		}
		return $_ret;
	}

	function getFirstDynDocument($id)
	{
		$_db = new DB_WE();
		$_id = f(
				'SELECT ID FROM ' . FILE_TABLE . ' WHERE ParentID=' . abs($id) . ' AND IsFolder=0 AND IsDynamic=1 AND Published<>0;', 
				'ID', 
				$_db);
		if (!$_id) {
			$_path = id_to_path($id);
			$_id = f(
					'SELECT ID FROM ' . FILE_TABLE . ' WHERE Path LIKE "' . $_path . '%" AND IsFolder=0 AND IsDynamic=1 AND Published<>0;', 
					'ID', 
					$_db);
		}
		return $_id;
	}

	function getWorkspaceFlag($id)
	{
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');
		$_clsid = f('SELECT TableID FROM ' . OBJECT_FILES_TABLE . ' WHERE ID=' . $id . ';', 'TableID', new DB_WE());
		$_cls = new we_object();
		$_cls->initByID($_clsid, OBJECT_TABLE);
		
		return $_cls->WorkspaceFlag;
	}

}

?>