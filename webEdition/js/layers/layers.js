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
