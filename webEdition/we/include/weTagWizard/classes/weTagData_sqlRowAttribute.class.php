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

class weTagData_sqlRowAttribute extends weTagData_selectAttribute
{

	/**
	 * @var string
	 */
	var $Table;

	/**
	 * @var string
	 */
	var $ValueName;

	/**
	 * @var string
	 */
	var $TextName;

	/**
	 * @param string $name
	 * @param string $table
	 * @param boolean $required
	 * @param string $valueName
	 * @param string $textName
	 * @param string $order
	 */
	function weTagData_sqlRowAttribute($id, $name, $table, $required = false, $valueName = 'ID', $textName = 'Text', $order = 'Text', $module = '')
	{
		
		global $DB_WE;
		
		$this->Table = $table;
		$this->ValueName = $valueName;
		$this->TextName = $textName ? $textName : $valueName;
		
		$options = array();
		
		// get options from choosen table
		$items = array();
		
		$DB_WE->query(
				"SELECT " . mysql_real_escape_string($this->ValueName) . "," . mysql_real_escape_string($this->TextName) . "
			 FROM " . mysql_real_escape_string($this->Table) . "
			 " . ($order ? "ORDER BY $order" : ''));
		
		while ($DB_WE->next_record()) {
			
			$options[] = new weTagDataOption($DB_WE->f($this->TextName), $DB_WE->f($this->ValueName));
		}
		parent::weTagData_selectAttribute($id, $name, $options, $required, $module);
	}
}
?>