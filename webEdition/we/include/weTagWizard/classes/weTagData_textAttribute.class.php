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

class weTagData_textAttribute extends weTagDataAttribute
{

	/**
	 * @param string $name
	 * @param boolean $required
	 */
	function weTagData_textAttribute($id, $name, $required = false, $module = '')
	{
		
		parent::weTagDataAttribute($id, $name, $required, $module);
	}

	/**
	 * @return string
	 */
	function getCodeForTagWizard()
	{
		
		return '
					<table class="attribute">
					<tr>
						<td class="attributeName">' . $this->getLabelCodeForTagWizard() . '</td>
						<td class="attributeField">' . we_htmlElement::htmlInput(
				array(
					
						'name' => $this->Name, 
						'id' => $this->getIdName(), 
						'value' => $this->Value, 
						'class' => 'wetextinput'
				)) . '</td>
					</tr>
					</table>';
	}
}

?>