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
 * Class for handling we_ui_controls_ACFileSelector Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
we_ui_controls_ACFileSelector = new Object();

/**
 * enables / disables TextInput and Button of AC element
 *
 *@static
 *@param {object|string} idOrObject id or reference of input element
 *@param {boolean} disabled flag that indicates if text field is disabled or not
 *@return void
 */
we_ui_controls_ACFileSelector.setDisabled = function(idOrObject, disabled) 
{
	if (document.getElementById('yuiAcInput_'+idOrObject)) {
		we_ui_controls_TextField.setDisabled('yuiAcInput_'+idOrObject, disabled);
	}
	if (document.getElementById('yuiAcButton_'+idOrObject)) {
		we_ui_controls_Button.setDisabled('yuiAcButton_'+idOrObject, disabled);
	}
}

/**
 * opens the selector window
 *
 *@static
 *@return void
 */
we_ui_controls_ACFileSelector.openSelector = function() 
{
	var args = "";
	var url = "/webEdition/we_cmd.php?"; 
	for(var i = 0; i < arguments.length; i++){ 
		url += "we_cmd["+i+"]="+escape(arguments[i]); 
		if(i < (arguments.length - 1)) { 
			url += "&"; 
		}
	}
	switch (arguments[0]) {
		case "openDocselector":
			new jsWindow(url,"we_docselector",-1,-1,900,685,true,true,true,true);
			break;
		case "openDirselector":
			new jsWindow(url,"we_selector",-1,-1,900,600,true,true,true,true);
			break;
	}
}

/**
 * opens the selector window for a tool
 *
 *@static
 *@return void
 */
we_ui_controls_ACFileSelector.openToolSelector = function() 
{
	var args = "";
	var url = "/webEdition/we_cmd.php?"; 
	for(var i = 0; i < arguments.length; i++){ 
		url += "we_cmd["+i+"]="+escape(arguments[i]); 
		if(i < (arguments.length - 1)) { 
			url += "&"; 
		}
	}
	switch (arguments[0]) {
		case "open"+arguments[5]+"Dirselector":
			url = "/webEdition/apps/"+arguments[5]+"/we_"+arguments[5]+"DirSelect.php?";
			for(var i = 0; i < arguments.length; i++){
				url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }
			}
			new jsWindow(url,"we_"+arguments[5]+"_dirselector",-1,-1,600,400,true,true,true);
			break;
	}
}