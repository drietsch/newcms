/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

function messageConsoleWindow(win){
	
	this.win = win;
	this.doc = win.document;
	this.name = "messageConsoleWindow";
	
	this.notify = function(lastMessage) {
		this.addMessage(lastMessage);
		
	};
	
	/**
	 * registers this console to the messageConsole in mainWindow of webEdition
	 */
	this.register = function() {
		top.opener.top.messageConsole.addObserver(this);
		
	};
	
	this.remove = function() {
		top.opener.top.messageConsole.removeObserver(this);
		
	}
	this.addMessage = function(msg) {
		
		var _className = "msgNotice";
		var _theImg    = this.win._imgNoticeActive.src;
		
		switch ( msg["prio"] ) {
			
			case 2:
				_className = "msgWarning";
				_theImg    = this.win._imgWarningActive.src;
			break;
			case 4:
				_className = "msgError";
				_theImg    = this.win._imgErrorActive.src;
			break;

		}
		
		var _li = this.doc.createElement("li");
			_li.className = "defaultfont " + _className;
			_txt = this.doc.createTextNode( msg["message"] );
			_li.appendChild( _txt );
		
		var _pElem = this.doc.getElementById("jsMessageUl");
		if ( _pElem.childNodes.length ) {
			this.doc.getElementById("jsMessageUl").insertBefore(_li, _pElem.childNodes[0] );
			
		} else {
			this.doc.getElementById("jsMessageUl").appendChild(_li);
			
		}
	}
	
	this.init = function() {
		_messages = top.opener.top.messageConsole.getMessages();
		for ( i=0; i<_messages.length; i++ ) {
			this.addMessage( _messages[i] );
			
		}
		
	};
	
	this.removeMessages = function() {
		top.opener.top.messageConsole.removeMessages();
		this.doc.getElementById("jsMessageUl").innerHTML = "";
		
	}
	
};

messageConsoleWindow = new messageConsoleWindow(window);
messageConsoleWindow.register();