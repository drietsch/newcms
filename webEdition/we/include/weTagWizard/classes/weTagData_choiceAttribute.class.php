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

class weTagData_choiceAttribute extends weTagDataAttribute
{

	/**
	 * @var array
	 */
	var $Options;

	/**
	 * @var boolean
	 */
	var $Multiple;

	/**
	 * @param string $name
	 * @param array $options
	 * @param boolean $required
	 */
	function weTagData_choiceAttribute($id, $name, $options = array(), $required = false, $multiple = true, $module = '')
	{
		
		parent::weTagDataAttribute($id, $name, $required, $module);
		$this->Options = $this->getUseOptions($options);
		$this->Multiple = $multiple;
	}

	/**
	 * @return string
	 */
	function getCodeForTagWizard()
	{
		
		$texts = array();
		$values = array();
		
		$texts[] = '----';
		$values[] = '';
		
		foreach ($this->Options as $option) {
			
			$texts[] = $option->getName();
			$values[] = htmlentities($option->Value);
		}
		
		// get html for choice box
		

		if ($this->Multiple) {
			$jsSelect = 'var valSel=this.options[this.selectedIndex].value; var valTa = document.getElementById(\'' . $this->getIdName() . '\').value; document.getElementById(\'' . $this->getIdName() . '\').value=((valTa==\'\' || (valSel==\'\')) ? valSel : (valTa+\',\'+valSel));';
		} else {
			$jsSelect = 'document.getElementById(\'' . $this->getIdName() . '\').value=this.options[this.selectedIndex].value;';
		}
		
		$select = new we_htmlSelect(array(
			'onchange' => $jsSelect, 'class' => 'defaultfont selectinput'
		));
		$select->addOptions(sizeof($texts), $values, $texts);
		
		return '
					<table class="attribute">
					<tr>
						<td class="attributeName">' . $this->getLabelCodeForTagWizard() . '</td>
						<td class="attributeField">' . we_htmlElement::htmlInput(
				array(
					
						'name' => $this->Name, 
						'value' => $this->Value, 
						'id' => $this->getIdName(), 
						'class' => 'wetextinput'
				)) . '</td>
						<td class="attributeButton">' . $select->getHtmlCode() . '</td>
					</tr>
					</table>';
	}
}
?>