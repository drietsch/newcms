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
 * Class for handling we_ui_controls_Textarea Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_Textarea = new Object();

/**
 * enables / disables Textarea element
 *
 *@static
 *@param {object|string} idOrObject id or reference of Textarea element
 *@param {boolean} disabled flag that indicates if text field is disabled or not
 *@return void
 */
we_ui_controls_Textarea.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	element.disabled = disabled;
}

/**
 * hides the Textarea
 *
 *@static
 *@param {object|string} idOrObject id or reference of Textarea element
 *@return void
 */
we_ui_controls_Textarea.hide = function(idOrObject)
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
 * shows the Textarea
 *
 *@static
 *@param {object|string} idOrObject id or reference of Textarea element
 *@return void
 */
we_ui_controls_Textarea.show = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element != null){
		element.style.display = "";
	}
}