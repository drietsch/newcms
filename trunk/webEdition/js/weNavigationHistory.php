<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] .  '/alert.inc.php');

header("Content-Type: text/javascript");

?>
function weNavigationHistory() {

	this.documentHistory	= new Array();
	this.currentIndex		= -1;
	this.saveInHistory		= true;
	
	this.addDocToHistory = function(table, id, ct, editcmd, url, parameters) {
		
		if (this.saveInHistory) {
		
			if ( this.currentIndex != (this.documentHistory.length - 1) ) { // reset navigation History when needed
				
				do {
					this.documentHistory.pop();
					
				} while ( this.currentIndex < (this.documentHistory.length - 1) );
				
				// resave document array
				var newDocumentHistory = new Array();
				
			}
			
			this.documentHistory.push( new weNavigationHistoryEntry( table, id, ct, editcmd, url, parameters ) );
			
			while ( this.documentHistory.length > 50 ) {
				this.documentHistory.shift();
				
			}
			
			this.currentIndex = (this.documentHistory.length - 1);
			
		}
		this.saveInHistory = true;
		
	}
	
	this.navigateBack = function() {
		
		if (this.documentHistory.length) {
		
			if (this.currentIndex > 0) {
			
				this.saveInHistory = false;
				this.currentIndex--;
				
				
				if ( !this.documentHistory[this.currentIndex].executeHistoryEntry() ) {
					this.navigateBack();
				}
				
			} else {
				<?php
					print we_message_reporting::getShowMessageCall($l_alert['navigation']['first_document'], WE_MESSAGE_NOTICE);
				?>
			}
		} else {
			this.getNoDocumentMessage();
		}
		
	}
	
	this.navigateNext = function() {
		
		if (this.documentHistory.length) {
	
			if (this.currentIndex < (this.documentHistory.length - 1)) {
			
				this.currentIndex++;
				this.saveInHistory = false;
				
				if ( !this.documentHistory[this.currentIndex].executeHistoryEntry() ) {
					this.navigateNext();
				}
				
				
			} else {
				<?php
					print we_message_reporting::getShowMessageCall($l_alert['navigation']['last_document'], WE_MESSAGE_NOTICE);
				?>
			}
		} else {
			this.getNoDocumentMessage();
		}
	}
	
	this.navigateReload = function() {
	
		if (this.documentHistory.length) {
			
			if ( _currentEditor = top.weEditorFrameController.getActiveEditorFrame() ) { // reload current Editor
				_currentEditor.setEditorReloadAllNeeded(true);
				_currentEditor.setEditorIsActive(true);
				
			} else { // reopen current Editor
				<?php
					print we_message_reporting::getShowMessageCall($l_alert['navigation']['no_open_document'], WE_MESSAGE_NOTICE);
				?>
				
				// this.saveInHistory = false;
				// this.documentHistory[this.currentIndex].executeHistoryEntry();
				
			}
			
		} else {
			this.getNoDocumentMessage();
		}
	}
	
	this.getNoDocumentMessage = function() {
		<?php
			print we_message_reporting::getShowMessageCall($l_alert['navigation']['no_entry'], WE_MESSAGE_NOTICE);
		?>
	}
}

function weNavigationHistoryEntry(table, id, ct, editcmd, url, parameters) {
	
	this.table		= table;
	this.id			= id;
	this.ct			= ct;
	this.editcmd	= editcmd;
	this.url		= url;
	this.parameters	= parameters;
	
	this.executeHistoryEntry = function() {
	
		if ( this.editcmd || (this.id && this.id != "0") ) {
	
			top.weEditorFrameController.openDocument(
				this.table,
				this.id,
				this.ct,
				this.editcmd,
				'',
				this.url,
				'',
				'',
				this.parameters
			);
			return true;
		} else {
			return false;
		}
	}
}

top.weNavigationHistory = new weNavigationHistory();