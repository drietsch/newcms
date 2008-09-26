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

class weTagData_selectorAttribute extends weTagDataAttribute
{

	/**
	 * @var string
	 */
	var $Table;

	/**
	 * @var string
	 */
	var $Selectable;

	/**
	 * @param string $name
	 * @param string $table
	 * @param string $selectable
	 * @param boolean $required
	 */
	function weTagData_selectorAttribute($id, $name, $table, $selectable, $required = false, $module = '')
	{
		
		$this->Table = $table;
		$this->Selectable = $selectable;
		
		parent::weTagDataAttribute($id, $name, $required, $module);
	}

	/**
	 * @return string
	 */
	function getCodeForTagWizard()
	{
		
		global $we_button;
		
		$weCmd = 'openDocselector';
		
		if ($this->Selectable == 'folder') {
			$weCmd = 'openDirselector';
		}
		
		if ($this->Table == CATEGORY_TABLE) {
			$weCmd = 'openCatselector';
			$this->Selectable = '';
		}
		
		if ($this->Table == NAVIGATION_TABLE) {
			$weCmd = 'openSelector';
		}
		
		$input = we_htmlElement::htmlInput(
				array(
					
						'name' => $this->Name, 
						'value' => $this->Value, 
						'id' => $this->getIdName(), 
						'class' => 'wetextinput'
				));
		$button = $we_button->create_button(
				"select", 
				"javascript:we_cmd('" . $weCmd . "', document.getElementById('" . $this->getIdName() . "').value, '" . $this->Table . "', 'document.getElementById(\\'" . $this->getIdName() . "\\').value', '', '', '" . session_id() . "', '', '" . $this->Selectable . "')");
		
		return '
					<table class="attribute">
					<tr>
						<td class="attributeName">' . $this->getLabelCodeForTagWizard() . '</td>
						<td class="attributeField">' . $input . '</td>
						<td class="attributeButton">' . $button . '</td>
					</tr>
					</table>';
	}
}

?>