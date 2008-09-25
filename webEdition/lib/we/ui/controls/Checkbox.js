/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */


/**
 * Class for handling we_ui_controls_Checkbox Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
		