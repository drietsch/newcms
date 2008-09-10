/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */
function we_core_JsonRpc(url, callback) {

	this.url = url;
	this.callback = callback;
	this.form = null;
	
	
	
	this.setForm = function(form) {
		this.form = form;
	};
	
	this.call = function(service, method, args) {
		
		// create json object
		var json = {
			service:service,
			method:method,
			params: [],
			id: new Date().getTime()
		}
	
		// Data of form should be included
		if (this.form !== null) {
			
			// extract form data
			var formElements = {};
			var len = this.form.elements.length;
			for (var key in this.form.elements) {
				var elem = this.form.elements[key];
				if (elem!=null && typeof(elem.nodeName) !== "undefined" && elem.name !== "") {
					var tag = elem.nodeName.toLowerCase();
					switch (tag) {
						case "textarea":
							formElements[elem.name] = elem.value;
							break;
						case "input":
							var type = elem.type.toLowerCase();
							switch (type) {
								//case "checkbox":
									
								case "radio":
									if (elem.checked) {
										formElements[elem.name] = elem.value;
									}
									break;
								case "button":
								case "file":
								case "image":
								case "reset":
								case "submit":
									// do nothing
									break;
								default:		
									formElements[elem.name] = elem.value;
							}
							break;
						case "select":
							if (elem.size && elem.size > 1) {
								formElements[elem.name] = [];
								for (var i=0; i<elem.length; i++) {
									if (elem.options[i].selected) {
										formElements[elem.name].push(elem.options[i].value);
									}
								}
							} else {
								formElements[elem.name] = elem.options[elem.selectedIndex].value;
							}
							break;
					}
				}
			}
			
			// push form elements as first argument
			json.params.push(formElements);
			
		} 

		// push additional arguments
		if (typeof(args) == "object" && args.length) {
			var l = args.length;
			for (var i=0; i<l; i++) {
				json.params.push(args[i]);
			}
		}
		
		// create json string from object
		var jsonString = YAHOO.lang.JSON.stringify(json);
		// set content type
		YAHOO.util.Connect.initHeader("content-type", "application/json"); 
		// send request
		var cObj = YAHOO.util.Connect.asyncRequest('POST', this.url, this.callback, jsonString);
	};
	
}

we_core_JsonRpc.callMethod = function(cmdObj, url, service, method) {

	
	var form = null;
	var args = null;
	
	// arguments handling
	if (typeof(arguments[4]) == "object" && typeof(arguments[4].nodeName) != "undefined" && arguments[4].nodeName == "FORM") {
		//5th argument is a form, so we need to set the rpcs form variable
		form = arguments[4];
		// look if there are additional parameters
		if (arguments.length > 5) {
			args = new Array();
			for (var i=5; i<arguments.length; i++) {
				args.push(arguments[i]);
			}
		}
	} else if (arguments.length > 4) {
		args = new Array();
		for (var i=4; i<arguments.length; i++) {
			args.push(arguments[i]);
		}
	}
	
	var rpc = new we_core_JsonRpc(url, { 
		success: function(o) {
			var jsonString = o.responseText;
			var obj = null;
			try { 
				obj = YAHOO.lang.JSON.parse(o.responseText); 
				if (obj.result != null && obj.error == null) {
					// tell the command controller that the command was ok. Needed to check if there is a following command
					weCmdController.cmdOk(cmdObj);
					// fire save Event
					weEventController.fire(method, obj.result);
				} else if (obj.error != null) {
					// tell the command controller that the command was not ok.
					cmdObj.errorMessage = obj.error.message;
					cmdObj.errorType = obj.error.type;
					weCmdController.cmdError(cmdObj);
				} else {
					// tell the command controller that the command was not ok.
					cmdObj.errorMessage = "Unknown Error.";
					weCmdController.cmdError(cmdObj);
				}
			} catch (e) { 
				// tell the command controller that the command was not ok.
				cmdObj.errorMessage = "Invalid JSON data!";
				weCmdController.cmdError(cmdObj);
			}
		}, 
		failure: function(o) {
			// tell the command controller that the command was not ok.
			cmdObj.errorMessage = "Communication failure!";
			weCmdController.cmdError(cmdObj);
		}, 
		argument: [] 
	});
	
	if (form) {
		rpc.setForm(form);
	}
	if (args !== null && typeof(args) == "object" && typeof(args.length) != "undefined") {
		rpc.call(service, method, args);
	} else {
		rpc.call(service, method);
	}
}