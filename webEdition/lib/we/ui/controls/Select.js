/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */


/**
 * Class for handling we_ui_controls_Select Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_Select = new Object();

/**
 * enables / disables Label
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select
 *@param {boolean} disabled flag that indicates if Select is disabled or not
 *@return void
 */
we_ui_controls_Select.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(disabled){
		element.className = 'we_ui_controls_Select_disabled';
	}
	else {
		element.className = 'we_ui_controls_Select';
	}
	element.disabled = disabled;
}

/**
 * hides the Select
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@return void
 */
we_ui_controls_Select.hide = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element != null){
		element.style.display = "none";
	}
}

/**
 * shows the Select
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@return void
 */
we_ui_controls_Select.show = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element != null){
		element.style.display = "";
	}
}

/**
 * insert Option Before Selected Option in Select Element
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@param string text of new option
 *@param string value of new option
 *@return void
 */
we_ui_controls_Select.insertOptionBeforeSelected = function(idOrObject, text, value)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if (element.selectedIndex >= 0) {
		var elOptNew = document.createElement('option');
		elOptNew.text = text;
		elOptNew.value = value;
		var elOptOld = element.options[element.selectedIndex];  
		try {
			element.add(elOptNew, elOptOld); // standards compliant; doesn't work in IE
		}
		catch(ex) {
			element.add(elOptNew, element.selectedIndex); // IE only
		}
	}
}

/**
 * remove Selected Option in Select Element
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@return void
 */
we_ui_controls_Select.removeOptionSelected = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var i;
  	for (i = element.length - 1; i>=0; i--) {
    	if (element.options[i].selected) {
    		element.remove(i);
		}
	}
}

/**
 * add last Option in Select Element
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@param string text of new option
 *@param string value of new option
 *@return void
 */
we_ui_controls_Select.addLastOption = function(idOrObject, text, value)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var elOptNew = document.createElement('option');
	elOptNew.text = text;
	elOptNew.value = value;	
	try {
	  element.add(elOptNew, null); // standards compliant; doesn't work in IE
	}
	catch(ex) {
	  element.add(elOptNew); // IE only
	}
}

/**
 * remove last Option in Select Element
 *
 *@static
 *@param {object|string} idOrObject id or reference of Select element
 *@return void
 */
we_ui_controls_Select.removeLastOption = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if (element.length > 0)
	{
		element.remove(element.length - 1);
	}
}
		