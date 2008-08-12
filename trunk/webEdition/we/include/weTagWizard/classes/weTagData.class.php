<?php

class weTagData {
	
	/**
	 * @var string
	 */
	var $Name;
	/**
	 * @var string
	 */
	var $TypeAttribute = null;
	/**
	 * @var array
	 */
	var $Attributes;
	/**
	 * @var string
	 */
	var $Description;
	/**
	 * @var string
	 */
	var $DefaultValue;
	/**
	 * @var string
	 */
	var $NeedsEndTag;
	
	/**
	 * @param string $name
	 * @param weTagDataAttribute $typeAttribute
	 * @param array $attributes
	 * @param string $description
	 * @param boolean $needsendtag
	 * @param string $defaultvalue
	 */
	function weTagData($name, $attributes = array(), $description='', $needsendtag=false, $defaultvalue='') {
		
		// only use attributes allowed regarding the installed modules
		
		// set attributes for this tag
		
		$attribs = array();
		foreach ($attributes as $attribute) {
			
			if ($attribute->useAttribute()) {
				
				if (strtolower(get_class($attribute)) == strtolower("weTagData_typeAttribute")) {
					
					$this->TypeAttribute = $attribute;
				}
				$attribs[] = $attribute;
			}
		}
		
		$this->Name = $name;
		$this->Attributes = $attribs;
		$this->Description = $description;
		$this->NeedsEndTag = $needsendtag;
		$this->DefaultValue = $defaultvalue;
	}
	
	/**
	 * @return string
	 */
	function getName() {
		return $this->Name;
	}
	
	/**
	 * @return string
	 */
	function getDescription() {
		return $this->Description;
	}
	
	/**
	 * @param string $tagName
	 * @return weTagData
	 */
	function getTagData($tagName) {
		
		// include the selected tag, its either normal, or custom tag
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/we_tag_' . $tagName . '.inc.php')) {
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/we_tag_' . $tagName . '.inc.php');
		} else if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/custom_tags/we_tag_' . $tagName . '.inc.php')) {
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/custom_tags/we_tag_' . $tagName . '.inc.php');
		} else {
			return false;
		}
		
		return new weTagData(
			$tagName,
			isset($GLOBALS['weTagWizard']['attribute']) ? $GLOBALS['weTagWizard']['attribute'] : array(),
			$GLOBALS['l_we_tag'][$tagName]['description'],
			$GLOBALS['weTagWizard']['weTagData']['needsEndtag'],
			isset($GLOBALS['l_we_tag'][$tagName]['defaultvalue']) ? $GLOBALS['l_we_tag'][$tagName]['defaultvalue'] : ''
		);
	}
	
	/**
	 * @return boolean
	 */
	function needsEndTag() {
		return $this->NeedsEndTag;
	}
	
	/**
	 * @return array
	 */
	function getAllAttributes($idPrefix = false) {
		
		$attribs = array();
		
		foreach ($this->Attributes as $attrib) {
			
			if ($idPrefix) {
				$attribs[] = $attrib->getIdName();
			} else {
				$attribs[] = $attrib->getName();
			}
		}
		return $attribs;
	}
	
	/**
	 * @return mixed
	 */
	function getTypeAttribute() {
		
		return $this->TypeAttribute;
	}
	
	/**
	 * @return array
	 */
	function getRequiredAttributes() {
		
		$req = array();

		foreach ($this->Attributes as $attrib) {
			if ($attrib->IsRequired()) {
				$req[] = $attrib->getIdName();
			}
		}
		return $req;
	}
	
	/**
	 * @return array
	 */
	function getTypeAttributeOptions() {
		
		if ($this->TypeAttribute) {
			return $this->TypeAttribute->getOptions();
		}
		return null;
	}
	
	
	/**
	 * @return string
	 */
	function getAttributesCodeForTagWizard() {
		
		$ret = '';
		
		$typeAttrib = $this->getTypeAttribute();
		
		if ( sizeof($this->Attributes) > 1 || (sizeof($this->Attributes) && !$typeAttrib) ) {
			
			$ret = '
		<ul>';
			foreach ($this->Attributes as $attribute) {
				
				if ($attribute != $this->TypeAttribute) {
					$ret .= '
			<li ' . ($typeAttrib ? 'style="display:none;"' : '') . ' id="li_' . $attribute->getIdName() . '">' . $attribute->getCodeForTagWizard() . '
			</li>';
				}
			}
			$ret .= '
		</ul>';
		}
		return $ret;
	}
	
	/**
	 * @return string
	 */
	function getTypeAttributeCodeForTagWizard() {
		
		$ret = '';
		
		if ($this->TypeAttribute) {
			
			$ret = '
			<ul>';
			
			$ret .= '
				<li>' . $this->TypeAttribute->getCodeForTagWizard() . '
				</li>';
			$ret .='
			</ul>';
			
		}
		
		return $ret;
	}
	
	/**
	 * @return string
	 */
	function getDefaultValueCodeForTagWizard() {
		
		return we_htmlElement::htmlTextArea(
			array(	'name' => 'weTagData_defaultValue',
					'id' => 'weTagData_defaultValue',
					'class' => 'wetextinput wetextarea')
			, $this->DefaultValue);
	}
}
?>