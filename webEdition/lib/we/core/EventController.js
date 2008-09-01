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
function we_core_EventController() {
	this.events = new Object();
	
	this.fire = function(eventName, data) {
		if (typeof(this.events[eventName]) !== "undefined") {
			this.events[eventName].fire(data);
		}
	}
	
	this.register = function(eventName, callbackFn, scope) {
		if (typeof(this.events[eventName]) == "undefined") {
			this.events[eventName] = new YAHOO.util.CustomEvent(eventName, scope, false, YAHOO.util.CustomEvent.FLAT);
		}
		this.events[eventName].subscribe(callbackFn, self);
	}
	
	this.unregister = function(eventName, callbackFn) {
		if (typeof(this.events[eventName]) != "undefined") {
			this.events[eventName].unsubscribe(callbackFn);
		}
	}
}
