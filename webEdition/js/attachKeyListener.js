function enableKeyboardShortCuts() {
	
	if ( typeof(top.dealWithKeyboardShortCut) != "undefined" && typeof(document.attachedKeyListeners) == "undefined" ) {
		
		document.attachedKeyListeners = true;
		
		if ( document.addEventListener ) {
			document.addEventListener( "keydown", top.dealWithKeyboardShortCut, true );
			
		} else if ( document.attachEvent ) {
			// important "onkeydown" IE will ignore ctrl klicks otherwise
			// it is not possible to prevent F5 (reload) from bubbling :-(
			document.attachEvent( "onkeydown", top.dealWithKeyboardShortCut );
			
		}
	}
}

if ( window.addEventListener ) {
	window.addEventListener( "load", enableKeyboardShortCuts, true );
	
} else if ( window.attachEvent ) {
	window.attachEvent( "onload", enableKeyboardShortCuts );
	
}