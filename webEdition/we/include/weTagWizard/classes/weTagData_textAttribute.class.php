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