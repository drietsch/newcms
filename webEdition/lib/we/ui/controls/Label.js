/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Label.js,v 1.1 2008/05/14 13:41:29 thomas.kneip Exp $
 */


/**
 * Class for handling we_ui_controls_Label Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_Label = new Object();

/**
 * enables / disables Label
 *
 *@static
 *@param {object|string} idOrObject id or reference of Label
 *@param {boolean} disabled flag that indicates if Label is disabled or not
 *@return void
 */
we_ui_controls_Label.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(disabled) {
		element.className = "we_ui_controls_Label_disabled";
	}
	else {
		element.className = "we_ui_controls_Label";
	}
}


		