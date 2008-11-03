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

function Browser() {
	var ua = navigator.userAgent.toLowerCase(); 

	this.isGecko     = (ua.indexOf('gecko') != -1 && ua.indexOf('safari') == -1);
	this.isMozilla   = (this.isGecko && ua.indexOf('gecko/') + 14 == ua.length);
	this.isNS6       = ((this.isGecko) ? (ua.indexOf('netscape') != -1) : ((ua.indexOf('mozilla') != -1) && (ua.indexOf('spoofer') == -1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) && (ua.indexOf('hotjava') == -1)));
	this.isIE        = ((ua.indexOf('msie') != -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1)); 
	this.isSafari    = (ua.indexOf('safari') != - 1);
	this.isOpera     = (ua.indexOf('opera') != -1); 
	this.isKonqueror = (ua.indexOf('konqueror') != -1 && !this.isSafari); 
	this.isIcab      = (ua.indexOf('icab') != -1); 
	this.isAol       = (ua.indexOf('aol') != -1); 
}

var bw = new Browser();
var scriptsuffix = "NS6";

if (bw.isIE || bw.isOpera) scriptsuffix = "IE";
else if (bw.isNS6 || bw.isSafari || bw.isKonqueror) scriptsuffix = "NS6";

document.write("<script src='" + js_path + "layers/layers" + scriptsuffix + ".js'></script>");
