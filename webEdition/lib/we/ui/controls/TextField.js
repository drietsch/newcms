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
 * @version    $Id: TextField.js,v 1.3 2008/05/26 06:49:22 holger.meyer Exp $
 */


/**
 * Class for handling we_ui_controls_TextField Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_TextField = new Object();

/**
 * enables / disables TextInput element
 *
 *@static
 *@param {object|string} idOrObject id or reference of input element
 *@param {boolean} disabled flag that indicates if text field is disabled or not
 *@return void
 */
we_ui_controls_TextField.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	element.disabled = disabled;
}