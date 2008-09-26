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

require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagDataAttribute.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagDataOption.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

class weTagData_sqlColAttribute extends weTagData_selectAttribute
{

	/**
	 * @var string
	 */
	var $Table;

	/**
	 * @param string $name
	 * @param string $table
	 * @param boolean $required
	 * @param array $filter
	 */
	function weTagData_sqlColAttribute($id, $name, $table, $required = false, $filter = array(), $module = '')
	{
		
		$this->Table = $table;
		
		global $DB_WE;
		
		$options = array();
		
		// get options from choosen table
		$items = array();
		$tableInfo = $DB_WE->metadata($this->Table);
		
		for ($i = 0; $i < sizeof($tableInfo); $i++) {
			
			if (!in_array($tableInfo[$i]['name'], $filter)) {
				$options[] = new weTagDataOption($tableInfo[$i]['name']);
			}
		}
		parent::weTagData_selectAttribute($id, $name, $options, $required, $module);
	}
}
?>