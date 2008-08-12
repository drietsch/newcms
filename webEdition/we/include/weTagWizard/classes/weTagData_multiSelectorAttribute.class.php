<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagDataAttribute.class.php');

class weTagData_multiSelectorAttribute
extends weTagDataAttribute {
	
	/**
	 * @var string
	 */
	var $Table;
	/**
	 * @var string
	 */
	var $Selectable;
	/**
	 * @var string
	 */
	var $TextName = 'text';
	
	/**
	 * @param string $name
	 * @param string $table
	 * @param string $selectable
	 * @param string $textName
	 * @param boolean $required
	 */
	function weTagData_multiSelectorAttribute($id, $name, $table, $selectable, $textName='path', $required=false, $module='') {
		
		$this->Table = $table;
		$this->Selectable = $selectable;
		$this->TextName = $textName;
		
		parent::weTagDataAttribute($id, $name, $required, $module);
	}
	
	/**
	 * @return string
	 */
	function getCodeForTagWizard() {
		
		global $we_button;
		
		$we_cmd = 'openSelector';
		
		switch ($this->Table) {
			case USER_TABLE:
				$we_cmd = 'browse_users';
			break;
			case CATEGORY_TABLE:
				$we_cmd = 'openCatselector';
			break;
		}
		
		$input = we_htmlElement::htmlTextArea(array('name' => $this->Name, 'id' => $this->getIdName(), 'class' => 'wetextinput wetextarea' ));
		$button = $we_button->create_button("select", "javascript:we_cmd('" . $we_cmd . "', '', '" . $this->Table . "', '', '', 'fillIDs();var foo2=\\'\\'; if(all" . $this->TextName . "s.length>=2){foo2=all" . $this->TextName . "s.substring(1,all" . $this->TextName . "s.length-1)};var foo=opener.document.getElementById(\\'" . $this->getIdName() . "\\'); if(foo.value){foo.value WE_PLUS= \\',\\'WE_PLUS foo2;}else{foo.value = foo2;};')");
		
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