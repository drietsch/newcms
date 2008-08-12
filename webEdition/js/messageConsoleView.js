function messageConsoleView( conName, win ) {
	
	this.name = conName;
	this.win  = win;
	
	// for disabling/hiding the messages the boxes
	this.calls = new Array();
	this.currentPrio = null;
	
	/**
	 * function is called from the subject
	 * @param {object} _lastMessage
	 */
	this.notify = function(_lastMessage) {
		
		if (this.win && this.win.document) {
		
			if (_lastMessage) { // if there is a lastMessage show it in the console window
				this.currentPrio = _lastMessage["prio"];
				
				/*
				 1 => see Notices
				 2 => see Warnings
				 4 => see Errors
				*/
				switch ( _lastMessage["prio"] ) {
					
					case 1:
						this.win.document.getElementById("messageConsoleMessage" + this.name).innerHTML = this.win._msgNotice;
					break;
					case 2:
						this.win.document.getElementById("messageConsoleMessage" + this.name).innerHTML = this.win._msgWarning;
					break;
					case 4:
						this.win.document.getElementById("messageConsoleMessage" + this.name).innerHTML = this.win._msgError;
					break;
					default:
						this.win.document.getElementById("messageConsoleMessage" + this.name).innerHTML = this.win._msgNotice;
					break;
				}
				this.win.document.getElementById("messageConsoleMessage" + this.name).style.display = "block";
				this.switchImage(_lastMessage["prio"], true);
				this.calls.push(null);
				
				this.win.setTimeout("_console_" + this.name + ".hideMessage()", 5000);
			}
		}
	}
	
	/**
	 * switches image depending on the prio of the message
	 *
	 * @param {integer} prio
	 * @param {boolean} active
	 */
	this.switchImage = function(prio, active) {
		
		if (!active) {
			active = false;
		}
		
		var _img;
		switch (prio) {
			case 2:
				if (active) {
					_img = this.win._imgWarningActive;
				} else {
					_img = this.win._imgWarning;
				}
			break;
			case 4:
				if (active) {
					_img = this.win._imgErrorActive;
				} else {
					_img = this.win._imgError;
				}
			break;
			default:
				if (active) {
					_img = this.win._imgNoticeActive;
				} else {
					_img = this.win._imgNotice;
				}
			break;
		}
		this.win.document.getElementById("messageConsoleImage" + this.name ).src = _img.src;
		
		
	}
	
	/**
	 * Disabled the message after a certain time
	 */
	this.hideMessage = function() {
		this.calls.pop();
		
		if (this.calls.length == 0) {
			this.win.document.getElementById("messageConsoleMessage" + this.name).style.display = "none";
			this.switchImage(this.currentPrio);
		}
		
	}
	
	/**
	 * registers this console to the messageConsole in mainWindow of webEdition
	 */
	this.register = function() {
		if ( typeof(top.messageConsole) != "undefined" ) {
			top.messageConsole.addObserver(this);
			
		} else {
			top.opener.top.messageConsole.addObserver(this);
			
		}
	}
	
	this.unregister = function() {
		if ( typeof(top.messageConsole) != "undefined" ) {
			top.messageConsole.removeObserver(this);
			
		} else {
			top.opener.top.messageConsole.removeObserver(this);
			
		}
		
	}
	
	/**
	 * opens the message console in a new window
	 */
	this.openMessageConsole = function() {
		if ( typeof(top.messageConsole) != "undefined" ) {
			top.messageConsole.openMessageConsole();
			
		} else {
			top.opener.top.messageConsole.openMessageConsole();
			
		}
	}
}