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
 * @package    webEdition_class
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


class we_docTypes_isp extends we_docTypes {
	
	
	/**
	* Forms a multiple Select-Box with all existing DocTypes for the editpage of doctypes.
	*
	* @return string
	* 
	*/
	function formDocTypeHeader() {
		
		$we_table = new we_htmlTable(	array(	'border'      => 0,
												'cellpadding' => 0,
												'cellspacing' => 0
												),
										1,
										1
										);
		$we_table->setColContent(	0,
									0,
									$this->formDocTypes2($GLOBALS["_isp_hide_doctypes"])
								);
		
		return $we_table->getHtmlCode();
	}
	
	/**
	* returns HTML-Code for a disabled Input-Field with the name of the ContentType
	* @return string
	*/
	function formName() {
		
		return $this->formInputField("","DocType","",24,520,255, 'readonly="readonly"');
	}
	
	
	/**
	* returns all templates associated with this doctype in separate lines
	* @return string
	*/
	function formDocTypeTemplates() {
		
		$_templateIds = makeArrayFromCSV($this->Templates);
		
		$_templates = id_to_path( $_templateIds, TEMPLATES_TABLE, '', false, true);
		
		$_ret = '';
		
		$_size = sizeof($_templates);
		
		for($i=0;$i<$_size;$i++){
			$_ret .= $_templates[$i] . "<br>\n";
		}
		return $_ret;
	}
	
	/**
	* Returns the HTML-Code needed to generate the template select for the ISP-version. In fact it returns an empty string
	* @return string
	* @param int $width
	*/
	function formTemplatePopup($width=0) {
		
		return '';
	}
	
	/**
	* Returns the HTML-Code needed to generate the subdir select for the ISP-version. In fact it returns an empty string
	* @return string
	* @param int $width
	*/
	function formSubDir($width=0){
		
		return '';
	}
	
	/**
	* Returns the HTML-Code needed to generate the Extension select for the ISP-version. In fact it returns an empty string
	* @return string
	* @param int $width
	*/
	function formExtension($width=0){
		return '';
	}
	
	function formIsDynamic(){
		return '';
	}
	
	function formIsSearchable(){
		return '';
	}
	
	function formCategory(){
		return '';
	}
}

?>