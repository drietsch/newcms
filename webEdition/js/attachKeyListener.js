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