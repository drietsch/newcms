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

class weTagData_typeAttribute extends weTagDataAttribute
{

	/**
	 * @var array
	 */
	var $Options;

	/**
	 * @param string $name
	 * @param array $options
	 * @param boolean $required
	 */
	function weTagData_typeAttribute($id, $name, $options = array(), $required = true, $module = '')
	{
		
		parent::weTagDataAttribute($id, $name, $required, $module);
		$this->Options = $this->getUseOptions($options);
		
		// overwrite value if needed
		if ($this->Value === false) {
			$this->Value = '-';
		}
	}

	/**
	 * @return string
	 */
	function getCodeForTagWizard()
	{
		
		$keys = array();
		$values = array();
		
		$keys[] = '';
		$values[] = $GLOBALS['l_taged']['select_type'];
		
		foreach ($this->Options as $option) {
			
			$keys[] = $option->Value;
			
			if ($option->getName() == '-') {
				$values[] = '';
			} else {
				$values[] = $option->getName();
			}
		}
		
		$js = "we_cmd('switch_type', this.value);";
		
		$select = new we_htmlSelect(
				array(
					
						'name' => $this->Name, 
						'id' => $this->getIdName(), 
						'onchange' => $js, 
						'class' => 'defaultfont selectinput'
				));
		$select->addOptions(sizeof($values), $keys, $values);
		
		return '
					<table class="attribute">
					<tr>
						<td class="attributeName">' . $this->getLabelCodeForTagWizard() . '</td>
						<td class="attributeField">' . $select->getHtmlCode() . '</td>
					</tr>
					</table>';
	}

	/**
	 * @return array
	 */
	function getOptions()
	{
		return $this->Options;
	}
}

?>