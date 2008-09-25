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

function jsWindow(url, ref, x, y, w, h, openAtStartup, scroll, hideMenue, resizable, noPopupErrorMsg, noPopupLocation, BrowserCrashedErrorMsg) {

	var foo_w = w;
	var foo_h = h;
	
	if (window.screen) {
		var screen_height = ((screen.height - 50) > screen.availHeight ) ? screen.height - 50 : screen.availHeight;
		screen_height = screen_height - 40;
		var screen_width = screen.availWidth-10;
		w = Math.min(screen_width, w);
		h = Math.min(screen_height, h);
		if(x == -1) x = Math.round((screen_width - w) / 2);
		if(y == -1) y = Math.round((screen_height - h) / 2);
	}

	this.name = "jsWindow" + (jsWindow_count++);
	this.url = url;
	this.ref = ref;
	this.x = x;
	this.y = y;
	this.w = w;
	this.h = h;
	this.scroll = (foo_w != w || foo_h != h) ? true : scroll;
	this.hideMenue = hideMenue;
	this.resizable = resizable;
	this.wind = null;
	this.open = jsWindowOpen;
	this.close = jsWindowClose;
	this.obj = this.name + "Object";
	eval(this.obj + "=this");
	if (openAtStartup) {
		this.open(noPopupErrorMsg, noPopupLocation);
	}
}

function  jsWindowOpen(noPopupErrorMsg, noPopupLocation) {
	var properties = (this.hideMenue ? "menubar=no," : "menubar=yes,")+(this.resizable ? "resizable=yes," : "resizable=no,")+((this.scroll) ? "scrollbars=yes," : "scrollbars=no,")+"width="+this.w+",height="+this.h;
	properties += ",left="+this.x+",top="+this.y;
	try{
		this.wind = window.open(this.url, this.ref, properties);
		this.wind.moveTo(this.x,this.y);
		this.wind.focus();
		
	}catch(e) {
	 	if (noPopupErrorMsg != undefined &&  noPopupErrorMsg.length) {
			if (!this.wind) {
				top.we_showMessage(noPopupErrorMsg, WE_MESSAGE_ERROR, window);
				//  disabled See Bug#1335
				if (noPopupLocation != undefined) {
					//document.location = noPopupLocation;
				}
			}
		}
	}

}

function  jsWindowClose(){
	if(!this.wind.closed) this.wind.close();
}

jsWindow_count = 0;