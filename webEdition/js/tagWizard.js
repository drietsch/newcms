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

function weTagWizard(tagName) {
	
	this.tagName = tagName; // name of the we:tag
	
	this.allAttributes = new Array();  // all attributes of the we:tag
	this.reqAttributes = new Object();  // required attributes of the we:tag
	this.typeAttributeId = '';
	this.typeAttributeAllows = new Object(); // type depending allowed fields (id)
	this.typeAttributeRequires = new Object(); // type depending required fields (id)
	
	this.needsEndTag = false;
	
	this.missingFields = new Array(); // missing attributes -> these are genereated by method getWeTag
	
	this.changeType = function (newType) {
		
		
		// set the matching required fields.
		// 1st remove all not always needed
		for (i=0;i<this.allAttributes.length;i++) {
			
			if (this.reqAttributes[this.allAttributes[i]]) {
				// no need to change these elements
			} else if (this.typeAttributeRequires[newType] && this.inArray(this.allAttributes[i], this.typeAttributeRequires[newType])) {
				this.setLabelRequired(this.allAttributes[i], true);
			} else {
				this.setLabelRequired(this.allAttributes[i], false);
			}
		}
		
		if (this.typeAttributeAllows[newType]) { // only show selected
			
			// flag if one is visible
			var hasAttributes = false;
			
			// show the correct attributes
			for (i=0;i<this.allAttributes.length;i++) {
				
				if (this.inArray(this.allAttributes[i], this.typeAttributeAllows[newType])) {
					
					if ( this.allAttributes[i] != this.typeAttributeId ) {
						hasAttributes = true;
					}
					
					this.showAttribute(this.allAttributes[i]);
				} else {
					this.hideAttribute(this.allAttributes[i]);
				}
			}
			
			if (hasAttributes) {
				
				this.hideElement('no_attributes_for_type');
			} else {
				
				this.showElement('no_attributes_for_type');
			}
			
			this.hideElement('no_type_selected_attributes');
			
		} else { // show all
			
			for (i=0;i<this.allAttributes.length;i++) {
				this.hideAttribute(this.allAttributes[i]);
			}
			this.showElement('no_type_selected_attributes');
			this.hideElement('no_attributes_for_type');
		}
	}

	this.showElement = function(id) {
		elem = document.getElementById(id);
		if (elem) {
			elem.style.display = "";
		}
	}
	
	this.hideElement = function(id) {
		elem = document.getElementById(id);
		if (elem) {
			elem.style.display = "none";
		}
	}
	
	this.showAttribute = function(id) {
		elem = document.getElementById("li_" + id);
		if (elem) {
			elem.style.display = "";
		}
	}
	
	this.hideAttribute = function(id) {
		
		elem = document.getElementById("li_" + id);
		if (elem) {
			elem.style.display = "none";
		}
	}
	
	this.getPartFromId = function(elemIdName, getId) {
		
		if (getId) {
			return elemIdName.substr(0, elemIdName.indexOf("_"));
		} else {
			return elemIdName.substr(elemIdName.indexOf("_") + 1);
		}
	}
	
	this.setLabelRequired = function(elemIdName, required) {
		
		element = document.getElementById("label_" + elemIdName);
		
		elemName = this.getPartFromId(elemIdName);
		
		if (element) {
			
			if (required) {
				element.innerHTML = elemName + "*";
			} else {
				element.innerHTML = elemName;
			}
			
		}
	}
	
	this.inArray = function(needle, haystack) {
		
		for (var i=0; i<haystack.length; i++) {
			
			if (needle == haystack[i]) {
				return true;
			}
		}
		return false;
	}
	
	this.getWeTag = function() { // build the we:tag in this function and return it.
		
		ret = "<we:" + this.tagName;
		
		this.missingFields = new Array();
		
		// differbetween case with/without type-attribute
		
		if (this.typeAttributeId && typeAttributeAllows[document.getElementById(this.typeAttributeId).value]) {
			
			var typeValue = document.getElementById(this.typeAttributeId).value;
			
			for (var i=0; i<this.typeAttributeAllows[typeValue].length; i++) {
				
				fieldId = this.typeAttributeAllows[typeValue][i];
				fieldName = this.getPartFromId(fieldId);
				fieldValue = document.getElementById(fieldId).value;
				
				// check if attribute is required attribute of the we:tag
				if (this.reqAttributes[fieldId] && (!fieldValue) ) {
					this.missingFields.push(fieldName);
				} else {
				
					// check if attribute is required by the value of the type-Attribut
					if (this.typeAttributeRequires[typeValue] && (!fieldValue || fieldValue == '-') && this.inArray(fieldId, typeAttributeRequires[typeValue]) ) {
						this.missingFields.push(fieldName);
					}
				}
				
				// at last add attribute to the we:tag
				if ( fieldValue && !(fieldValue == '-' && this.typeAttributeId == fieldId ) ) {
					ret += " " + fieldName + "=\"" + fieldValue + "\"";
				}
			}
		
		} else if (this.typeAttributeId) {
			
			// type is not selected
			return false;
			
		} else {
			
			for ( i=0; i<this.allAttributes.length; i++) {
				
				fieldId = this.allAttributes[i];
				fieldName = this.getPartFromId(fieldId);
				fieldValue = document.getElementById(fieldId).value;
				
				if( this.reqAttributes[fieldId] && (!fieldValue || fieldValue == '-') ) {
					this.missingFields.push(fieldName); 
				}
				
				if (fieldValue) {
					ret += " " + fieldName + "=\"" + fieldValue + "\"";
				}
			}
		}
		
		if (this.needsEndTag) {
			ret += ">" + document.we_form.elements['weTagData_defaultValue'].value + "</we:" + this.tagName + ">";
		} else {
			ret += " />";
		}
		
		if (this.missingFields.length) {
			return false;
		} else {
			return ret;
		}
	}
	
	this.editMultiSelector = function(cmdObj) {
		
		selItems = cmdObj.selectedItems;
		textName = cmdObj.textName;
		
		val = weTextInput.getValue(cmdObj.textFieldId);
		
		for (selId in cmdObj.selectedItems) {
		
			selItem = cmdObj.selectedItems[selId];
			if (val) {
				val += ",";
			}
			val += selItem[textName];
		}
		weTextInput.setValue(cmdObj.textFieldId, val);
	}
}