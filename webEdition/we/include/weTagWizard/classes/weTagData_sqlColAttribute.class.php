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