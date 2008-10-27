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

function weCombobox() {

	this.init = function(id, inputClass) {

		selectObj = document.getElementById(id);
		if(selectObj == undefined) {
			alert('weCombobox: Unkown id \'' + id + '\'');
			return false;
		}

		inputObj = document.createElement("input");
		inputObj.id = id + '_input';
		if(selectObj.style.width != undefined) {
			inputObj.style.width = selectObj.style.width;
		}
		if(inputClass != undefined) {
			inputObj.className = inputClass;

		} else if(selectObj.className != undefined) {
			inputObj.className = selectObj.className;
		}

		inputObj.value = selectObj.options[0].text;
		inputObj.style.display = 'none';

		selectObj.parentNode.insertBefore(inputObj, selectObj.nextSibling);
		inputObj = document.getElementById(id + '_input');

		selectObj.onchange = this.makeInput;
		inputObj.onblur = this.makeSelect;

	}


	this.makeInput = function() {

		// this.id is the i of the select-element
		selectObj = document.getElementById(this.id);

		inputObj = selectObj.nextSibling;
		while(inputObj.nodeType == 3) {
			inputObj = inputObj.nextSibling;
		}

		if(selectObj.selectedIndex == 1) {

			selectObj.style.display = 'none';
			inputObj.style.display = 'inline';
			inputObj.focus();

		}

	}


	this.makeSelect = function() {

		// this.id is the i of the input-element
		inputObj = document.getElementById(this.id);

		selectObj = inputObj.previousSibling;
		while(selectObj.nodeType == 3) {
			selectObj = selectObj.previousSibling;
		}

		selectObj.options[0].value = inputObj.value;
		selectObj.options[0].text = inputObj.value;
		selectObj.selectedIndex = 0;

		inputObj.style.display = 'none';
		selectObj.style.display = 'inline';

	}

}

/*
Usage:

Combobox = new weCombobox();
Combobox.init('<ID of the select you wish o have the combobox functionality>');

*/