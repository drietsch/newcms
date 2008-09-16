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
 * Class for handling we_ui_controls_RadioButton Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_RadioButton = new Object();

/**
 * enables / disables RadioButton
 *
 *@static
 *@param {object|string} idOrObject id or reference of RadioButton
 *@param {boolean} disabled flag that indicates if checkbox is disabled or not
 *@return void
 */
we_ui_controls_RadioButton.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	element.disabled = disabled;
	if(document.getElementById("label_"+element.id)) {
		we_ui_controls_Label.setDisabled("label_"+element.id, disabled);
	}
}

/**
 * checks RadioButton
 *
 *@static
 *@param {object|string} idOrObject id or reference of RadioButton
 *@param {boolean} disabled flag that indicates if checkbox is disabled or not
 *@return void
 */
we_ui_controls_RadioButton.setChecked = function(idOrObject, checked) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(!element.disabled) {
		element.checked = checked;
	}
}

/**
 * hides the RadioButton
 *
 *@static
 *@param {object|string} idOrObject id or reference of RadioButton element
 *@return void
 */
we_ui_controls_RadioButton.hide = function(idOrObject)
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
 * shows the RadioButton
 *
 *@static
 *@param {object|string} idOrObject id or reference of RadioButton element
 *@return void
 */
we_ui_controls_RadioButton.show = function(idOrObject)
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
		