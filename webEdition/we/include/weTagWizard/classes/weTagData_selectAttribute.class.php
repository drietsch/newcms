<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagDataAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagDataOption.class.php');

class weTagData_selectAttribute
extends weTagDataAttribute {
	
	/**
	 * @var array
	 */
	var $Options; 
	
	/**
	 * @param string $name
	 * @param array $options
	 * @param boolean $required
	 */
	function weTagData_selectAttribute($id, $name, $options=array(), $required=false, $module='') {
		
		$this->weTagDataAttribute($id, $name, $required, $module);
		$this->Options = $this->getUseOptions($options);
	}
	
	/**
	 * @return string
	 */
	function getCodeForTagWizard() {
		
		$keys = array();
		$values = array();
		
		if (!$this->Required) {
			$keys[] = '';
			$values[] = '';
		}
		
		foreach ($this->Options as $option) {
			
			$keys[] = $option->Value;
			$values[] = $option->getName();
		}
		
		$select = new we_htmlSelect(array('name' => $this->Name, 'id' => $this->getIdName(), 'class' => 'defaultfont selectinput'));
		$select->addOptions(sizeof($values), $keys, $values);
		
		$select->selectOption($this->Value);
		
		return '
					<table class="attribute">
					<tr>
						<td class="attributeName">' . $this->getLabelCodeForTagWizard() . '</td>
						<td class="attributeField">' . $select->getHtmlCode() . '</td>
					</tr>
					</table>';
	}
}

?>