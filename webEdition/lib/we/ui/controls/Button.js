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
 * @version    $Id: Button.js,v 1.1 2008/05/14 13:41:29 thomas.kneip Exp $
 */


/**
 * Class for handling we_ui_controls_Button Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
we_ui_controls_Button = new Object();

/**
 * disables / enables Button element, hidden input element of button = submit and <a> tag of button=href
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return void
 */
we_ui_controls_Button.setDisabled = function(idOrObject, disabled) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(disabled) {
		element.className = "we_ui_controls_Disabled_Button";
		if(element.childNodes[0].className=="we_ui_controls_Clicked_Button_Left" || element.childNodes[0].className=="we_ui_controls_Button_Left") {
			element.childNodes[0].className = "we_ui_controls_Disabled_Button_Left";
			element.childNodes[1].className = "we_ui_controls_Disabled_Button_Middle";
			element.childNodes[2].className = "we_ui_controls_Disabled_Button_Right";
			var img = document.getElementById(element.id + "_img");
			if(img != null && img.src.indexOf("Disabled.gif") == -1){
				img.src = img.src.replace(/\.gif/, "Disabled.gif");
			}
		}
			
		if(document.getElementById("input_"+element.id)) {
			var input = document.getElementById("input_"+element.id);
			input.disabled = true;
		}
		if(document.getElementById("a_"+element.id)) {
			var a = document.getElementById("a_"+element.id);
			a.onclick = function(){return false;};
		}
		if(document.getElementById("table_"+element.id)) {
			var table = document.getElementById("table_"+element.id);
			table.className = "we_ui_controls_Disabled_Button_InnerTable";
		}
		
	}
	else {
		element.className = "we_ui_controls_Button";
		if(element.childNodes[0].className=="we_ui_controls_Clicked_Button_Left" || element.childNodes[0].className=="we_ui_controls_Disabled_Button_Left") {
			element.childNodes[0].className = "we_ui_controls_Button_Left";
			element.childNodes[1].className = "we_ui_controls_Button_Middle";
			element.childNodes[2].className = "we_ui_controls_Button_Right";
			var img = document.getElementById(element.id + "_img");
			if(img != null && img.src.indexOf("Disabled.gif") == -1){
				img.src = img.src.replace(/\Disabled.gif/, ".gif");
			}
		}
		if(document.getElementById("input_"+element.id)) {
			var input = document.getElementById("input_"+element.id);
			input.disabled = false;
		}
		if(document.getElementById("a_"+element.id)) {
			var a = document.getElementById("a_"+element.id);
			a.onclick = function(){return true;};
		}
		if(document.getElementById("table_"+element.id)) {
			var table = document.getElementById("table_"+element.id);
			table.className = "we_ui_controls_Button_InnerTable";
		}
	}
}

/**
 * marks the Button after mouseDown event as clicked
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return void
 */
we_ui_controls_Button.down = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element.childNodes[0].className=="we_ui_controls_Clicked_Button_Left" || element.childNodes[0].className=="we_ui_controls_Button_Left") {
		if (element.className != "we_ui_controls_Disabled_Button"){
			element.className = "we_ui_controls_Clicked_Button";
			element.childNodes[0].className = "we_ui_controls_Clicked_Button_Left";
			element.childNodes[1].className = "we_ui_controls_Clicked_Button_Middle";
			element.childNodes[2].className = "we_ui_controls_Clicked_Button_Right";
		}
	}
}

/**
 * marks the Button after mouseOut event as default
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return void
 */
we_ui_controls_Button.out = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element.childNodes[0].className=="we_ui_controls_Clicked_Button_Left" || element.childNodes[0].className=="we_ui_controls_Button_Left") {
		if (element.className != "we_ui_controls_Disabled_Button" && element.className != "we_ui_controls_Button") {
			element.className = "we_ui_controls_Button";
			element.childNodes[0].className = "we_ui_controls_Button_Left";
			element.childNodes[1].className = "we_ui_controls_Button_Middle";
			element.childNodes[2].className = "we_ui_controls_Button_Right";
		}
	}
}

/**
 * marks the Button after mouseUp event as default
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return boolean
 */
we_ui_controls_Button.up = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if (element.className != "we_ui_controls_Disabled_Button") {
		we_ui_controls_Button.out(element);
		return true;
	}
	return false;
}

/**
 * hides the Button
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return void
 */
we_ui_controls_Button.hide = function(idOrObject)
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
 * shows the Button
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return void
 */
we_ui_controls_Button.show = function(idOrObject)
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element != null){
		element.style.display = "";
	}
}

/**
 * checks if the Button is disabled
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return boolean
 */
we_ui_controls_Button.isDisabled = function(idOrObject) 
{
	var element = idOrObject;
	if (typeof(element) != "object") {
		element = document.getElementById(idOrObject);
	}
	if(element != null && element.className == "we_ui_controls_Disabled_Button") {
		return true
	} else {
		return false;
	}
}

/**
 * checks if the Button is enabled
 *
 *@static
 *@param {object|string} idOrObject id or reference of button element
 *@return boolean
 */
we_ui_controls_Button.isEnabled = function(idOrObject) 
{
	return !this.isDisabled(idOrObject);
}

/**
 * adds a Button
 *
 *@static
 *@param string buttonId id of button element
 *@param string buttonHTML html code of button element
 *@param string positionID id of element within the button should be added
 *@return void
 */
we_ui_controls_Button.addButton = function(buttonId, buttonHTML, positionID) 
{
	var container = positionID;
	if (typeof(container) != "object") {
		container = document.getElementById(positionID);
	}
	if(container) {
		var desc = "added__ButtonDiv__";
		var count = 0;
		if(container.hasChildNodes) {
			var kids = container.childNodes;
			for (i=0; i < kids.length; i++) {
				if(kids[i].id && kids[i].id.substring(0,18) == desc) {
					count++;
				}
			}
		}
		var id = buttonId.replace(/__INDEX__/g, '');	
		var mainDiv = document.createElement("DIV");
		mainDiv.id = desc+id;
		mainDiv.innerHTML = buttonHTML;
		container.appendChild(mainDiv);
	}
	
}