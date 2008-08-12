// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: layers.js,v 1.6 2007/05/23 15:39:31 holger.meyer Exp $

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
