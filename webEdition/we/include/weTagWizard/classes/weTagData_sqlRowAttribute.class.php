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
				"SELECT " . $this->ValueName . "," . $this->TextName . "
			 FROM " . $this->Table . "
			 " . ($order ? "ORDER BY $order" : ''));
		
		while ($DB_WE->next_record()) {
			
			$options[] = new weTagDataOption($DB_WE->f($this->TextName), $DB_WE->f($this->ValueName));
		}
		parent::weTagData_selectAttribute($id, $name, $options, $required, $module);
	}
}
?>