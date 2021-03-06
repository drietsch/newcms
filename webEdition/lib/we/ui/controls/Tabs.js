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
 * Class for handling we_ui_controls_Tabs Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
we_ui_controls_Tabs = new Object();


/**
 * toggles tab status
 *
 *@static
 *@param {object|string} idOrObject id or reference of tabContainer
 *@param string tab id or reference of tab
 *@return void
 */
we_ui_controls_Tabs.toggle = function(idOrObject, tab, frame) 
{
	var activTab = tab;
	if (typeof(activTab) != "object") {
		activTab = eval(frame+"document.getElementById(tab)");
	}
	
	var elementContainer = idOrObject;
	if (typeof(elementContainer) != "object") {
		elementContainer = document.getElementById(idOrObject);
	}
	
	activTabInputField = eval(frame+"document.getElementsByName('activTab')[0]");
	activTabInputField.value = activTab.id;
	
	for(var i=0; i<elementContainer.childNodes.length; i++){
		if(elementContainer.childNodes[i].id) {
			var id = elementContainer.childNodes[i].id;
			var divId = id.substr(5, id.length);
			var div = eval(frame+"document.getElementById(divId)");
			if(elementContainer.childNodes[i].id=="Tabs_"+activTab.id) {
				div.style.display = "";
			}
			else {
				div.style.display = "none";
			}
		}
	}
}

/**
 * set class for tab
 *
 *@static
 *@param {object|string} idOrObject id or reference of tabContainer
 *@param string tab id or reference of tab
 *@return void
 */
we_ui_controls_Tabs.setTabClass = function(idOrObject, tab) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var bottomline = false;
	for(var i=0; i<element.childNodes.length; i++){
		if(element.childNodes[i].className == "we_ui_controls_Tab_Active_Bottomline") {
			bottomline = true;
		}
		if(element.childNodes[i].className == "we_ui_controls_Tab_Active" || element.childNodes[i].className == "we_ui_controls_Tab_Active_Bottomline"){
			element.childNodes[i].className = "we_ui_controls_Tab_Normal";
		}
	}
	var activTab = tab;
	if (typeof(activTab) != "object") {
		activTab = document.getElementById("Tabs_"+tab);
	}
	if(activTab.id) {
		var _tab = document.getElementById(activTab.id);
		if(bottomline) {
			_tab.className = "we_ui_controls_Tab_Active_Bottomline";
		}
		else {
			_tab.className = "we_ui_controls_Tab_Active";
		}
	}
}

/**
 * set active tab
 *
 *@static
 *@param {object|string} idOrObject id or reference of tabContainer
 *@param string tab id or reference of tab
 *@return void
 */
we_ui_controls_Tabs.setTab = function(idOrObject,tab,frame) 
{
	var element = tab;
	if (typeof(element) != "object") {
		element = eval(frame+"document.getElementById(tab)");
	}

	we_ui_controls_Tabs.toggle(idOrObject,element.id,frame);
	
}

/**
 * close tab
 *
 *@static
 *@param {object|string} idOrObject id or reference of tabContainer
 *@param string tab id or reference of tab
 *@return void
 */
we_ui_controls_Tabs.close = function(idOrObject,tab) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	var closeTab = document.getElementById("Tabs_"+tab);

  	var doit = element.removeChild(closeTab);
  	
  	var div = document.getElementById(tab);
	var parent = div.offsetParent;
	if(parent) parent.removeChild(div);

}

/**
 * check valid input fields
 *
 *@static
 *@return boolean
 */
we_ui_controls_Tabs.allowed_change_edit_page = function() 
{
	if(top.opener) {
		if(top.opener.top.opener) {
			if(top.opener.top.opener.top.weEditorFrameController) {
				var contentEditor = top.opener.top.opener.top.weEditorFrameController.getVisibleEditorFrame();
			}
		}
		else if(top.opener.top.weEditorFrameController) {
			var contentEditor =  top.opener.top.weEditorFrameController.getVisibleEditorFrame(); 
		}
	}
	else if(top.weEditorFrameController) {
		var contentEditor = top.weEditorFrameController.getVisibleEditorFrame()
	}
	if ( contentEditor && contentEditor.fields_are_valid ) {
		return contentEditor.fields_are_valid();
	}
	return true;
}

