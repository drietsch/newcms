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

if(typeof(window.top.pb_vars) == 'undefined') {
	var imgDir = "/webEdition/images";
	var colorCont = "#ffffff";
	var colorUnloaded = "#e6e8fa";
	var bgImgUnloaded = "balken_bg.gif";
	var colorLoaded = "000080";
	var bgImgLoaded = "balken.gif";
} else {
	window.pb_vars = window.top.pb_vars;
	document.write(pb_vars);
}

var pb_style = '';

pb_style += '<style type="text/css">';
pb_style += '#divCont {'
	+'position:absolute; left:0px; top:0px;'
	+'width:150; height:98; clip:rect(0px 150 150 0px);'
	+'background-color:'+colorCont+';'
	+'layer-background-color:'+colorCont+';'
	+'}';
pb_style += '#divLoaded {'
	+'position:absolute;'
	+'layer-background-color:'+colorUnloaded+';'
	+'background-color:'+colorUnloaded+';'
	+'background-image:url('+imgDir+'/'+bgImgUnloaded+');'
	+'layer-background-image:url('+imgDir+'/'+bgImgUnloaded+');'
	+'}';
pb_style += '#divUnloaded {'
	+'position:absolute; left:0px; top:0px;'
	+'layer-background-color:'+colorLoaded+';'
	+'background-color:'+colorLoaded+';'
	+'background-image:url('+imgDir+'/'+bgImgLoaded+');'
	+'layer-background-image:url('+imgDir+'/'+bgImgLoaded+');'
	+'}';
pb_style += '#divText {'
	+'position:absolute; background-color:transparent; font-family:Verdana;'
	+'color:#006699; font-size:9px; font-weight:bold;'
	+'}';
pb_style += '</style>';

document.write(pb_style);

function bw_check() {
	this.ver = navigator.appVersion;
	this.agent = navigator.userAgent;
	this.dom = document.getElementById? 1 : 0;
	this.opera5 = this.agent.indexOf('Opera 5') > -1;
	this.ie5 = (this.ver.indexOf('MSIE 5') > -1 && this.dom && !this.opera5)? 1 : 0;
	this.ie6 = (this.ver.indexOf('MSIE 6') > -1 && this.dom && !this.opera5)? 1 : 0;
	this.ie4 = (document.all && !this.dom && !this.opera5)? 1 : 0;
	this.ie = this.ie4 || this.ie5 || this.ie6;
	this.mac = this.agent.indexOf('Mac') > -1;
	this.ns6 = (this.dom && parseInt(this.ver) >= 5)? 1 : 0;
	this.ns4 = (document.layers && !this.dom)? 1 : 0;
	this.bw = (this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5);
	return this;
}
bw = new bw_check();

var px = bw.ns4 || window.opera? '' : 'px';

function pb_scale(maximum) {
	this.maximum = maximum;
	this.current = 0;
	this.loaderWidth = 100;
	this.loaderHeight = 10;
}

function pb_docsize() {
	this.x = 0; this.x2 = bw.ie && document.body.offsetWidth-20 || innerWidth || 0;
	this.y = 0; this.y2 = bw.ie && document.body.offsetHeight-5 || innerHeight || 0;
	if(!this.x2 || !this.y2) return;
	this.x50 = this.x2/2;
	this.y50 = this.y2/2;
	return this;
}

function pb_object(obj,nest) {
	nest = (!nest)? '' : 'document.'+nest+'.';
	this.evnt = bw.dom? document.getElementById(obj) : bw.ie4?
		document.all[obj] : bw.ns4? eval(nest+'document.layers.'+obj) : 0;
	this.css = bw.dom || bw.ie4? this.evnt.style : this.evnt;
	this.ref = this.css;
	this.w = this.evnt.offsetWidth || this.css.clip.width ||
		this.ref.width || this.css.pixelWidth || 0;
	return this;
}

pb_object.prototype.pb_move = function(x,y) {
	this.x = x;
	this.y = y;
	this.css.left = x+px;
	this.css.top = y+px;
}

pb_object.prototype.pb_clip = function(t,r,b,l,setwidth) {
	this.ct = t; this.cr = r; this.cb = b; this.cl = l;
	if(bw.ns4) {
		this.css.clip.top = t;
		this.css.clip.right = r;
		this.css.clip.bottom = b;
		this.css.clip.left = l;
	} else {
		if(t < 0) t = 0; if(r < 0) r = 0; if(b < 0) b = 0; if(b < 0) b = 0;
		this.css.clip = 'rect('+t+'px '+r+'px '+b+'px '+l+'px)';
		if (setwidth) {
			this.css.pixelWidth = r;
			this.css.pixelHeight = b;
			this.css.width = r+px;
			this.css.height = b+px;
		}
	}
}

pb_object.prototype.pb_write = function(text,startHTML,endHTML) {
	if(bw.ns4) {
		if(!startHTML) startHTML = ''; endHTML = '';
		this.ref.open('text/html');
		this.ref.write(startHTML+text+endHTML);
		this.ref.close();
	} else this.evnt.innerHTML = text;
}

var oLoad2;

function pb_init(maximum,xPos,yPos) {
	scale = new pb_scale(maximum);
	oLoadCont = new pb_object('divCont');
	oLoad = new pb_object('divLoaded','divCont');
	oLoad2 = new pb_object('divUnloaded','divCont.document.divLoaded');
	oLoadText = new pb_object('divText');

	hsp = 7; vsp = 1;
	if(xPos!=-1 && yPos!=-1) {
		oLoad.pb_move(xPos,yPos+2);
		oLoadText.pb_move(xPos+scale.loaderWidth+hsp,yPos);
	} else {
		page = new pb_docsize();
		oLoad.pb_move(page.x50-scale.loaderWidth/2,page.y50-20);
		oLoadText.pb_move(page.x50-scale.loaderWidth/2+scale.loaderWidth+hsp,page.y50-20-vsp);
	}
	oLoad.pb_clip(0,scale.loaderWidth,scale.loaderHeight,0,1);
	oLoad2.percent = scale.loaderWidth/scale.maximum;
	oLoadText.pb_write('0%');
}

function pb_increment() {
	scale.current++;
	if(oLoad2) {
		oLoad2.pb_clip(0,oLoad2.percent*scale.current,40,0,1);
		oLoadText.pb_write(Math.floor(oLoad2.percent*scale.current)+'%');
	}
	if(scale.current >= scale.maximum) setTimeout('pb_destroy()',500);
}

function pb_destroy() {
	oLoadCont.css.visibility = 'hidden';
	oLoadCont = null;
	oLoad1 = null;
	oLoad2 = null;
	oLoadText = null;
	scale = null;
}

function pb_display() {
	scale.current++;
	if(oLoad2) {
		oLoad2.pb_clip(0,oLoad2.percent*scale.current,40,0,1);
		oLoadText.pb_write(Math.floor(oLoad2.percent*scale.current)+'%');
	}
	if(scale.current <= scale.maximum) setTimeout('pb_display()',200);
	else oLoadCont.css.visibility = 'hidden';
}
