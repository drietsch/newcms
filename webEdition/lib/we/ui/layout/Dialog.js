/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * Class for handling we_ui_layout_Dialog Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
function we_ui_layout_Dialog(url, w, h, args) {
	
	var foo_w = w;
	var foo_h = h;
	var x = 0;
	var y = 0;
	
	if (window.screen) {
		var screen_height = ((screen.height - 50) > screen.availHeight ) ? screen.height - 50 : screen.availHeight;
		screen_height = screen_height - 40;
		var screen_width = screen.availWidth-10;
		w = Math.min(screen_width, w);
		h = Math.min(screen_height, h);
		x = Math.round((screen_width - w) / 2);
		y = Math.round((screen_height - h) / 2);
	}

	this.name = "we_ui_layout_Dialog_" + (we_ui_layout_Dialog.count++);
	this.url = url;
	this.x = x;
	this.y = y;
	this.w = w;
	this.h = h;
	this.win = null;
	this.args = args;
	
	this.open = function() {
		var properties = "menubar=no,resizable=no,scrollbars=no," +"width="+this.w+",height="+this.h+",left="+this.x+",top="+this.y;
		this.win = window.open(this.url, this.name, properties);
		this.win.moveTo(this.x,this.y);
		this.win.focus();
			
	}
	
	this.close = function() {
		if(!this.win.closed) this.wind.close();
	}

	this.obj = this.name + "_Object";
	eval(this.obj + "=this");
}


we_ui_layout_Dialog.count = 0;
