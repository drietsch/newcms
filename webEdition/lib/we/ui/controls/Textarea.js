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
 * Class for handling we_ui_controls_Textarea Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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