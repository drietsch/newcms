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