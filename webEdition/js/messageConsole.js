/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * Controller of the messageconsole in the menu frame of the mainwindow and in
 * module and tools window
 *
 * implements observer pattern
 * - the console is the subject
 * - the consoleViews in the different windows are observers
 * uses messageConsoleView.php
 */
var messageConsole = new function() {
	
	this.observers = new Array();
	
	this.maxAmount	= 35;
	this.messages	= new Array();
	
	this.addMessage = function(prio, message) {
		if (this.messages.length > 35) { // remove one message
			this.messages.shift();
			
		}
		this.messages.push(
			new Object({"prio":prio, "message": message})
			
		);
		this.notifyObservers();
		
	}
	
	this.removeMessages = function() {
		this.messages	= new Array();
		
	}
	
	this.getMessages = function(type) {
		return this.messages;
		
	}
	
	this.getLastMessage = function(type) {
		if (this.messages.length) {
			return this.messages[(this.messages.length-1)];
		}
		return null;
		
	}
	
	this.notifyObservers = function() {
		for (i=0;i<this.observers.length;i++) {
			try { // must try this - perhaps a frame of an observer is reloaded
				this.observers[i].notify( this.getLastMessage() );
			} catch (exc) {
				
			}
			
		}
	}
	
	this.addObserver = function(observer) {
		this.removeObserver(observer); // debug reasons, remove before adding
		this.observers.push(observer);
		
	}
	
	this.removeObserver = function(observer) {
		_newObservers = new Array();
		for (i=0;i<this.observers.length;i++) {
			if ( this.observers[i].name != observer.name ) {
				_newObservers.push( this.observers[i] );
			} 
		}
		this.observers = _newObservers;
	}
	
	this.openMessageConsole = function() {
		top.we_cmd("show_message_console");
		
	}
}