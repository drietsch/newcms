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
 * Class for handling we_ui_controls_Checkbox Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_Checkbox = new Object();

/**
 * enables / disables Checkbox
 *
 *@static
 *@param {object|string} idOrObject id or reference of checkbox
 *@param {boolean} disabled flag that indicates if checkbox is disabled or not
 *@return void
 */
we_ui_controls_Checkbox.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var checkbox = document.getElementById("_"+element.id);
	checkbox.disabled = disabled;
	if(document.getElementById("label_"+element.id)) {
		we_ui_controls_Label.setDisabled("label_"+element.id, disabled);
	}
}

/**
 * checks Checkbox
 *
 *@static
 *@param {object|string} idOrObject id or reference of checkbox
 *@param {boolean} disabled flag that indicates if checkbox is disabled or not
 *@return void
 */
we_ui_controls_Checkbox.setChecked = function(idOrObject, checked) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var checkbox = document.getElementById("_"+element.id);
	if(!checkbox.disabled) {
		checkbox.checked = checked;
	}
}

/**
 * hides the Checkbox
 *
 *@static
 *@param {object|string} idOrObject id or reference of Checkbox element
 *@return void
 */
we_ui_controls_Checkbox.hide = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(document.getElementById("table_"+element.id)) {
		var table = document.getElementById("table_"+element.id);
		table.style.display = "none";
	}
}

/**
 * shows the Checkbox
 *
 *@static
 *@param {object|string} idOrObject id or reference of Checkbox element
 *@return void
 */
we_ui_controls_Checkbox.show = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(document.getElementById("table_"+element.id)) {
		var table = document.getElementById("table_"+element.id);
		table.style.display = "";
	}
}
		