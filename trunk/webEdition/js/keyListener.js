/**
 * parent class for the keylistener, this is implemented with the design pattern:
 * "chain of responsibility"
 */
function keyBoardListener( _successor ) {
	
	/**
	 * element of type keyBoardListener to forward action if needed
	 */
	this.successor = (_successor ? _successor : null);
	
	/**
	 * abstract function overwrite this!!!
	 * @param {Event} evt
	 */
	this.dealEvent = function(evt) {
		alert( "You MUST overwrite the function dealEvent!!" );
		this.next(evt);
		
	}
	/**
	 * 
	 * @param {Event} evt
	 */
	this.next = function(evt) {
		if (this.successor != null) {
			this.successor.dealEvent(evt);
			
		}
	}
	
	/**
	 * cancels an event if possible
	 * @param {Event} evt
	 */
	this.cancelEvent = function(evt) {

		if ( document.attachEvent ) {
			evt.returnValue = false;
			
		} else {
			evt.preventDefault();
			evt.stopPropagation();
			
		}
	}
}


/**
 * member of CoR
 * This Object closes a popup-Window, when the "ESCAPE" key is pressed
 *
 * On ESCAPE, top.closeOnEscape() is called, depending on the return value, the
 * dialog is closed and the event killed(true) or the event is fowrarded (false)
 * If the function does not exist, the window is NOT closed, the function
 * top.closeOnEscape() allows a user confirmation, which can be useful for
 * several dialogs
 * 
 * On ENTER, top.applyOnEnter(), if exists, with the current event as parameter
 * is called. Each dialog can be forwarded to the original "Ok"-Functions. 
 * Furthermore some checks about the context of the event are possible. If the
 * function does not exist, nothing happens. Depending on the return value of
 * this function, the event is cancelled (true) or not (false)
 * 
 * otherwise forwards the event to successor
 * 
 * @param {keyBoardListener} _successor
 */
function keyDialogListener( _successor ){

	this.successor = (_successor ? _successor : null);
	this.dealEvent = function(evt) {
		
		_next = true;
		
		// does function closeOnEscape exist!!
		if ( typeof( top.closeOnEscape ) == "function" && evt.keyCode == "27") {	// ESCAPE
			
			if ( top.closeOnEscape() ) {
				this.cancelEvent(evt);
				_next = false;
				top.close();
				
			}
		}
		
		// does function applyOnEnter exist?
		if ( typeof( top.applyOnEnter ) == "function" && evt.keyCode == "13") {	// ENTER
			
			if ( top.applyOnEnter( evt ) ) {
				this.cancelEvent(evt);
				_next = false;
				
			}
			
		}
		
		if (_next) {
			this.next(evt);
			
		}
	}
};
keyDialogListener.prototype = new keyBoardListener();

/**
 * member of CoR
 * This Object closes a popup-Window, when the "ESCAPE" key is pressed
 *
 * On STRG-S, top.saveOnKeyboard(), if exists, is called. This function can save
 * the model. Depending on the return value, the event is cancelled (true) or
 * forwarded (false)
 * 
 * @param {keyBoardListener} _successor
 */
function keyDialogSaveListener( _successor ){

	this.successor = (_successor ? _successor : null);
	this.dealEvent = function(evt) {
		
		_next = true;
		if ( evt["ctrlKey"] ) {
			if ( typeof( top.saveOnKeyBoard ) == "function" && evt["keyCode"] == 83 ) { // S (Save)
				if ( top.saveOnKeyBoard() ) {
					this.cancelEvent(evt);
					_next = false;
					
				}
			}
		}
		
		if (_next) {
			this.next(evt);
			
		}
	}
};
keyDialogSaveListener.prototype = new keyBoardListener();

/**
 * member of CoR
 * defines several actions for the current active editor, if possible
 * - save (STR+S)
 * - publish (STRG-SHIFT-S)
 * - close current Tab (STR+F4)
 * 
 * otherwise forwards the event to successor
 * 
 * @param {keyBoardListener} _successor
 */
function keyEditorListener( _successor ) {
	this.successor = (_successor ? _successor : null);
	
	this.dealEvent = function(evt) {
		
		_editor = false;
		
		// check if an editor is open
		if ( typeof( top.weEditorFrameController ) != "undefined" ) {
			_activeEditorFrame = top.weEditorFrameController.getActiveEditorFrame();
			if(top.weEditorFrameController.getActiveDocumentReference()) {
				if ( _activeEditorFrame.getEditorType() == "model" ) {
					_editor = true;
				}
			}
		}
		
		if ( _editor && ( evt["ctrlKey"] ) ) { // || evt["metaKey"] when target bug is solved by Safari
			if ( evt["keyCode"] == 83 && evt["shiftKey"] ) { // SHIFT + S (Publish)
				self.focus(); // focus, to avoid a too late onchange of editor
				this.cancelEvent(evt);
				_activeEditorFrame.setEditorPublishWhenSave(true);
				if (typeof(_activeEditorFrame.getEditorFrameWindow().frames[3].we_save_document) == "function") {
					_activeEditorFrame.getEditorFrameWindow().frames[3].we_save_document();
				}
			
			} else if ( evt["keyCode"] == 83 ) { // S (Save)
				self.focus();  // focus, to avoid a too late onchange of editor
				this.cancelEvent(evt);
				_activeEditorFrame.setEditorPublishWhenSave(false);
				if (typeof(_activeEditorFrame.getEditorFrameWindow().frames[3].we_save_document) == "function") {
					_activeEditorFrame.getEditorFrameWindow().frames[3].we_save_document();
				}
			
			} else if ( evt["keyCode"] == 87 || evt["keyCode"] == 115 ) { // W, F4 (closing a tab)
				self.focus();  // focus, to avoid a too late onchange of editor
				this.cancelEvent(evt);
				top.weEditorFrameController.closeDocument( _activeEditorFrame.getFrameId() );
			
			} else {
				this.next(evt);
				
			}
			
		} else {
			this.next(evt);
			
		}
	}
}
keyEditorListener.prototype = new keyBoardListener();

/**
 * member of CoR
 * defines several actions for the modules
 * - save (STR+S)
 * 
 * otherwise forwards the event to successor
 * 
 * @param {keyBoardListener} _successor
 */
function keyModuleListener( _successor ) {
	this.successor = (_successor ? _successor : null);
	
	this.dealEvent = function(evt) {
		
		if ( typeof( top.weModuleWindow ) != "undefined" && ( evt["ctrlKey"] ) ) { // || evt["metaKey"] when target bug is solved by Safari
			
			if ( evt["keyCode"] == 83 ) { // S (Save)
				if (	top.content &&
						top.content.resize &&
						top.content.resize.right &&
						top.content.resize.right.editor &&
						top.content.resize.right.editor.edfooter &&
						typeof(top.content.resize.right.editor.edfooter.we_save ) == "function" ) {
					
					this.cancelEvent(evt);
					top.content.resize.right.editor.edfooter.we_save();
					
				} else {
					this.next(evt);
				}
				
			} else {
				this.next(evt);
				
			}
			
		} else {
			this.next(evt);
			
		}
	}
}
keyModuleListener.prototype = new keyBoardListener();


/**
 * member of CoR
 * defines several actions for the tools
 * - save (STR+S)
 * 
 * otherwise forwards the event to successor
 * 
 * @param {keyBoardListener} _successor
 */
 
function keyToolListener( _successor ) {
	this.successor = (_successor ? _successor : null);
	
	this.dealEvent = function(evt) {
		if ( typeof( top.weToolWindow ) != "undefined" && ( evt["ctrlKey"] ) ) { // || evt["metaKey"] when target bug is solved by Safari
			if ( evt["keyCode"] == 83 ) { // S (Save)
				if (	top.content &&
						top.content.resize &&
						top.content.resize.right &&
						top.content.resize.right.editor &&
						top.content.resize.right.editor.edfooter &&
						typeof(top.content.resize.right.editor.edfooter.we_save ) == "function" ) {
					
					this.cancelEvent(evt);
					top.content.resize.right.editor.edfooter.we_save();
					
				} else if (	top.content &&
							top.content.resize &&
							top.content.resize.right &&
							top.content.resize.right.editor &&
							top.content.resize.right.editor.edfooter &&
							top.content.weCmdController) {
						top.content.weCmdController.fire({"cmdName": "app_" + top.content.appName + "_save"});
					
				} else {
					this.next(evt);
				}
				
			} else {
				this.next(evt);
				
			}
			
		} else {
			this.next(evt);
			
		}
	}
}
keyToolListener.prototype = new keyBoardListener();

/**
 * member of CoR
 * - opens a prompt to input a tagname, this is opened with Tag-Wizard then
 * 
 * @param {keyBoardListener} _successor
 */
function keyTagWizardListener( _successor ) {
	this.successor = (_successor ? _successor : null);
	this.dealEvent = function(evt) {
		
		if ( evt["keyCode"] == 73 ) { // I (Open Tag-Wizard Prompt)
			
			if ( typeof( top.weEditorFrameController ) != "undefined" ) {
				_activeEditorFrame = top.weEditorFrameController.getActiveEditorFrame();
				
				if (_activeEditorFrame.getEditorContentType() == "text/weTmpl" &&
					typeof(_activeEditorFrame.getEditorFrameWindow().frames[3].tagGroups['alltags']) != "undefined" ) {
						
						_activeEditorFrame.getEditorFrameWindow().frames[3].openTagWizardPrompt();
						this.cancelEvent(evt);
					
				} else {
					this.next(evt);
					
				}
			} else {
				this.next(evt);
			}
			
		} else {
			this.next(evt);
		}
	}
}
keyTagWizardListener.prototype = new keyBoardListener();

/**
 * member of CoR
 * trys to avoid the reload button in the main window, if possible
 * - F5
 * 
 * otherwise forwards the event to successor
 * 
 * @param {keyBoardListener} _successor
 */
function keyReloadListener( _successor ) {
	this.successor = (_successor ? _successor : null);
	this.dealEvent = function(evt) {
		
		if ( typeof( top.weEditorFrameController ) != "undefined" ) {
			if ( evt["ctrlKey"] || evt["metaKey"] ) {
				
				if ( evt["keyCode"] == 82 ) { // R Reload
					this.cancelEvent(evt);
					
				}
			}
			if ( evt["keyCode"]	== 116) { // F5
				this.cancelEvent(evt);
				
			}

		} else {
			this.next(evt);
			
		}
	}
}
keyReloadListener.prototype = new keyBoardListener();


// build the CoR
var keyListener = new keyEditorListener( new keyModuleListener( new keyToolListener( new keyDialogListener( new keyDialogSaveListener( new keyTagWizardListener( new keyReloadListener( ) ) ) ) ) ) );

/**
 * Receives all Keyboard Events and forwards them, if required
 * 
 * @param {Event} evt
 */
 
function dealWithKeyboardShortCut(evt) {
	// This function receives all events, when a key is pressed and forwards the event to
	// the first keyboardlistener ("chain of responsibility")
	if ( 
			evt["keyCode"]	== "27"		||	// ESCAPE
			evt["keyCode"]	== "13"		||	// ENTER
			evt["keyCode"]	== "116"	||	// F5 - works only in FF
			
			( 	 // ctrl-key for windows, meta-key for mac 
				( evt["ctrlKey"] ||	evt["metaKey"] )
			)
			&& ( evt["keyCode"] != 17) // don't forward only CTRL
	 	) {
			keyListener.dealEvent( evt );

	} else {
		// event is NOT forwarded
	}
}
top.dealWithKeyboardShortCut = dealWithKeyboardShortCut;