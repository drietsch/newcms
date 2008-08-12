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
 * @version    $Id: ACFileSelector.js,v 1.1 2008/05/14 13:41:29 thomas.kneip Exp $
 */


/**
 * Class for handling we_ui_controls_ACFileSelector Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
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