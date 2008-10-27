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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


var we_styleSheets;
var we_classNames;
var we_styleString = "";
var we_parentRef = null;
var we_parentRef = null;
var weMainWinRef = self;
var weCssEntries = new Array();

weWysiwyg.focusedWysiwyg = null;

// windows extended chars to translate in entities
weWysiwyg.translationTable = new Array (338,339,352,353,376,381,382,402,710,732,8211,8212,8216,8217,8218,8220,8221,8222,8224,8225,8226,8230,8240,8249,8250,8364,8482);
// special chars to translate in entities
weWysiwyg.specialChars = new Array(9824,9827,9829,9830,8254,8592,8593,8594,8595,8260);

// synonym for false to use for returning in links (link click fix)
// can be better removed than just false
we_wysiwyg_false = false;

var isFullScreen = false;

if (	top.opener &&
		top.opener.top.weEditorFrameController &&
		top.opener.top.weEditorFrameController.getVisibleEditorFrame() &&
		top.opener.top.weEditorFrameController.getVisibleEditorFrame().document){

			weMainWinRef = top.opener.top.weEditorFrameController.getVisibleEditorFrame();
}else if(top.opener && top.opener.we_styleString){
	weMainWinRef = top.opener;
}

if(weMainWinRef.we_styleString){
	we_styleString = weMainWinRef.we_styleString;
}


// ###############################################################
// ############### Class weWysiwyg ###############################
// ###############################################################

function weWysiwyg(fName,hiddenName,hiddenHTML,editHTML,fullScreenRef,className,propString,bgcolor,outsideWE,path,xml,removeFirstParagraph,charset,cssClasses,language, isFrontendEdit){

	this.fName = fName;
	this.fullScreenRef = fullScreenRef;
	this.name = this.fName.replace(/[\[\]]/g,"");
	this.hiddenName = hiddenName;
	this.ref = hiddenName.replace(/[^0-9a-zA-Z_]/gi,"");
	this.propString = propString;
	this.bgcolor = bgcolor;
	this.className = className;
	this.language = language;
	this.isFrontendEdit = isFrontendEdit;
	this.range = null;
	this.outsideWE = outsideWE;
	this.xml=xml;
	this.removeFirstParagraph = removeFirstParagraph;
	this.charset = charset;
	this.cssClasses = cssClasses;
	this.showBorders = true;
	this.sourceMode = false;
	this.hasFocus = false;
	this.location = this.fullScreenRef ? top.opener.document.location  : document.location;
	this.preurl = this.location.protocol + "//" + this.location.hostname + (this.location.port ? ":"+this.location.port : "");
	this.nodeDone = null;
	this.baseUrl = path ? (this.preurl + path) : this.location.href;
	this.path = path;
	this.pre = false;
	this.editContainer = null;
	this.framewidth = null;

	this.mouseDownWasCaret = false;

	if(hiddenHTML){
		hiddenHTML = hiddenHTML.replace(/##\|n##/gi,"\n");
		hiddenHTML = hiddenHTML.replace(/##\|r##/gi,"\r");
		hiddenHTML = hiddenHTML.replace(/##scr#ipt##/g,"script");
		hiddenHTML = hiddenHTML.replace(/##Scr#ipt##/g,"Script");
		hiddenHTML = hiddenHTML.replace(/##SCR#IPT##/g,"SCRIPT");
		hiddenHTML = hiddenHTML.replace(/\|\|##\?##\|\|/gi,"<?");
		hiddenHTML = hiddenHTML.replace(/##\|\|\?\|\|##/gi,"?>");
	}

	if(editHTML){
		editHTML = editHTML.replace(/##\|n##/gi,"\n");
		editHTML = editHTML.replace(/##\|r##/gi,"\r");
		editHTML = editHTML.replace(/##scr#ipt##/g,"script");
		editHTML = editHTML.replace(/##Scr#ipt##/g,"Script");
		editHTML = editHTML.replace(/##SCR#IPT##/g,"SCRIPT");
		editHTML = editHTML.replace(/\|\|##\?##\|\|/gi,"<?");
		editHTML = editHTML.replace(/##\|\|\?\|\|##/gi,"?>");
	}

	this.hiddenHTML = hiddenHTML;
	this.editHTML = editHTML;
	this.buttons = new Array();
	this.buttons["bold"] = new weWysiwygButton("bold",this);
	this.buttons["italic"] = new weWysiwygButton("italic",this);
	this.buttons["underline"] = new weWysiwygButton("underline",this);
	this.buttons["subscript"] = new weWysiwygButton("subscript",this);
	this.buttons["superscript"] = new weWysiwygButton("superscript",this);
	this.buttons["strikethrough"] = new weWysiwygButton("strikethrough",this);
	this.buttons["removeformat"] = new weWysiwygButton("removeformat",this);
	this.buttons["insertunorderedlist"] = new weWysiwygButton("insertunorderedlist",this);
	this.buttons["insertorderedlist"] = new weWysiwygButton("insertorderedlist",this);
	this.buttons["createlink"] = new weWysiwygButton("createlink",this);
	this.buttons["unlink"] = new weWysiwygButton("unlink",this);
	this.buttons["anchor"] = new weWysiwygButton("anchor",this);
	this.buttons["justifyleft"] = new weWysiwygButton("justifyleft",this);
	this.buttons["justifycenter"] = new weWysiwygButton("justifycenter",this);
	this.buttons["justifyright"] = new weWysiwygButton("justifyright",this);
	this.buttons["justifyfull"] = new weWysiwygButton("justifyfull",this);
	this.buttons["insertimage"] = new weWysiwygButton("insertimage",this);
	this.buttons["indent"] = new weWysiwygButton("indent",this);
	this.buttons["outdent"] = new weWysiwygButton("outdent",this);
	this.buttons["inserthorizontalrule"] = new weWysiwygButton("inserthorizontalrule",this);
	this.buttons["insertspecialchar"] = new weWysiwygButton("insertspecialchar",this);
	this.buttons["inserttable"] = new weWysiwygButton("inserttable",this);
	this.buttons["edittable"] = new weWysiwygButton("edittable",this);
	this.buttons["editcell"] = new weWysiwygButton("editcell",this);
	this.buttons["insertcolumnleft"] = new weWysiwygButton("insertcolumnleft",this);
	this.buttons["insertcolumnright"] = new weWysiwygButton("insertcolumnright",this);
	this.buttons["insertrowabove"] = new weWysiwygButton("insertrowabove",this);
	this.buttons["insertrowbelow"] = new weWysiwygButton("insertrowbelow",this);
	this.buttons["deleterow"] = new weWysiwygButton("deleterow",this);
	this.buttons["deletecol"] = new weWysiwygButton("deletecol",this);
	this.buttons["increasecolspan"] = new weWysiwygButton("increasecolspan",this);
	this.buttons["decreasecolspan"] = new weWysiwygButton("decreasecolspan",this);
	this.buttons["caption"] = new weWysiwygButton("caption",this);
	this.buttons["removecaption"] = new weWysiwygButton("removecaption",this);
	this.buttons["forecolor"] = new weWysiwygButton("forecolor",this);
	this.buttons["backcolor"] = new weWysiwygButton("backcolor",this);
	this.buttons["editsource"] = new weWysiwygButton("editsource",this);
	this.buttons["visibleborders"] = new weWysiwygButton("visibleborders",this);
	this.buttons["importrtf"] = new weWysiwygButton("importrtf",this);
	this.buttons["fullscreen"] = new weWysiwygButton("fullscreen",this);

	this.buttons["spellcheck"] = new weWysiwygButton("spellcheck",this);

	this.buttons["cut"] = new weWysiwygButton("cut",this);
	this.buttons["copy"] = new weWysiwygButton("copy",this);
	this.buttons["paste"] = new weWysiwygButton("paste",this);

	this.buttons["undo"] = new weWysiwygButton("undo",this);
	this.buttons["redo"] = new weWysiwygButton("redo",this);

	this.buttons["insertbreak"] = new weWysiwygButton("insertbreak",this);
	this.buttons["acronym"] = new weWysiwygButton("acronym",this);
	this.buttons["abbr"] = new weWysiwygButton("abbr",this);
	this.buttons["lang"] = new weWysiwygButton("lang",this);

	this.stateButtons = new Array("inserttable", "acronym","abbr","lang","edittable","caption","removecaption","cut","copy","createlink","editcell","insertcolumnright","insertcolumnleft","insertrowabove","insertrowbelow","deleterow","deletecol","strikethrough","unlink", "increasecolspan","decreasecolspan");
	this.highlightButtons = new Array("justifycenter", "justifyright", "justifyleft","justifyfull","bold", "italic", "underline", "subscript", "superscript", "strikethrough", "acronym", "abbr", "lang");
	this.editTableButtons = new Array("editcell","insertcolumnleft","insertcolumnright","insertrowabove","insertrowbelow","deleterow","deletecol","increasecolspan","decreasecolspan");
	this.disableSourceButtons = new Array("cut","copy","paste","undo","redo","insertbreak","importrtf","visibleborders","forecolor","backcolor","inserttable","inserthorizontalrule","insertspecialchar","createlink","anchor","insertimage","indent","outdent","undo","redo","bold","italic","underline","subscript","superscript","strikethrough","removeformat","insertunorderedlist","insertorderedlist","justifyleft","justifycenter","justifyright","justifyfull","unlink","edittable","editcell","insertcolumnleft","insertcolumnright","insertrowabove","insertrowbelow","deleterow","deletecol","increasecolspan","decreasecolspan","acronym","abbr","lang");

	this.inlineTags = " a abbr acronym b big blink cite code del em font i ins kbd label q s samp select small span strike strong sub sup textarea tt u var ";
	this.emptyTags = " base meta link hr br basefont param img area input isindex col ";
	this.booleanAttributes = " nowrap ismap declare noshade checked disabled readonly multiple selected noresize defer";
	this.nlAfterStartTag = " table tr ul ol th tbody br ";
	this.nlAfterEndTag = " table tr td ul ol th tbody p li h1 h2 h3 h4 h5 h6 pre code div ";

	this.menus = new Array();
	this.menus["fontname"] = new weWysiwygPopupMenu("fontname",this);
	this.menus["fontsize"] = new weWysiwygPopupMenu("fontsize",this);
	this.menus["formatblock"] = new weWysiwygPopupMenu("formatblock",this);
	this.menus["applystyle"] = new weWysiwygPopupMenu("applystyle",this);

	this.selBaseNode = false;
	this.selBaseOffset = 0;
	this.selExtentNode = false;
	this.selExtentOffset = 0;

	this.dom = null;

	this.undoCircle = new weCircleStack(20);
	this.undoCircle.compareFN = function(a,b) {
		return a.content == b.content;
	}

	this.hot = false;


	this.lastKeyTime = 0;


	this.obj = "weWysiwygObject_"+this.name;
	eval(this.obj + "=this");
}

weWysiwyg.prototype.selectAll = function() {
	this.editContainer.innerHTML=this.editContainer.innerHTML.replace(/<div[^>]*><\/div>/gi,'');this.dom.window.getSelection().setBaseAndExtent(this.editContainer, 0, this.editContainer, this.editContainer.childNodes.length);
}

weWysiwyg.prototype.replaceText = function(txt) {
	this.dom.insertHTML(txt);
}

weWysiwyg.prototype.doSetFocus = function(){
	try {
		for (var i = 0; i < we_wysiwygs.length; i++) {
			we_wysiwygs[i].hasFocus = false;
		}
		this.hasFocus = true;
		weWysiwyg.focusedWysiwyg = this;
	} catch(e) {
		// Nothing
	}
}

weWysiwyg.prototype.writeHTMLDocument = function(){
	if(this.fullScreenRef){
		eval("var eobj = top.opener.weWysiwygObject_"+this.fullScreenRef);
		this.editHTML = eobj.getEditHTML();
	}

	var parentRef = null;
	var normal = false;
	if(top.opener && top.opener.top.weEditorFrameController && top.opener.top.weEditorFrameController.getVisibleEditorFrame()){  // inline
		if(top.opener.top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_"+this.hiddenName)){
			parentRef = top.opener.top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_"+this.hiddenName);
			we_parentRef = parentRef;
		}
	}else if(isFullScreen && top.opener && top.opener.document.getElementById(this.fullScreenRef+"_table")){ // fullscreen
			if(top.opener.we_parentRef != null){
				parentRef = top.opener.we_parentRef;
			}else{
				parentRef = top.opener.document.getElementById(this.fullScreenRef+"_table");
			}
	}else{ // normal
		normal = true;
		parentRef = document.getElementById(this.name+"_table");
	}
	var bodystyle = "";
	var bodyclass = "";

	var okAttribs = new Array("background","font","color","list","outline","word-spacing");

	if (!document.styleSheetsLoaded) {
		document.styleSheetsLoaded = true;
		weWysiwyg.setupSyles();
	}


	if(	parentRef ){
		var all = weWysiwyg.getParentStyles(parentRef,we_styleSheets,this.className);
		bodyclass = all[0] ? all[0] : "";
		var styles = all[1];
		for(var key in styles){
			var dontIgnore = false;
			for(var i=0;i<okAttribs.length;i++){
				if(key.substring(0,okAttribs[i].length).toLowerCase() == okAttribs[i]){
					dontIgnore = true;
					break;
				}
			}
			if(dontIgnore && styles[key]){
				bodystyle += (key+":"+styles[key]+";");
			}
		}
	}

	if(normal){
		bodystyle = bodystyle.replace(/background[^;]+;?/gi,"");
		if(!this.bgcolor){
			bodystyle += "background-color: transparent;";
		}
	}else{
		if(this.bgcolor){
			bodystyle = bodystyle.replace(/background[^;]+;?/gi,"");
		}
	}
	bodystyle = bodystyle.replace(/text\-align[^;]+;?/gi,"");
	bodyclass = this.className ? this.className : "";
	bodystyle = bodystyle.replace(/^(.+);$/,"$1");

	this.dom.document.write('<html><head>');
	this.dom.document.write('<base href="'+this.baseUrl+'">');
	this.dom.document.write('<title></title><meta http-equiv=Content-Type content=\'text/html;'+(this.charset ? ' charset=iso-8859-1' : '')+'\'>');
	this.dom.document.write('<link id="wysiwygcss" media="screen" rel="stylesheet" type="text/css" href="/webEdition/wysiwyg/borders.css" />');
	this.dom.document.write('<style type="text/css">'+we_styleString+'</style>');
	this.dom.document.write('</head>');
	this.dom.document.write('<body '+(bodystyle ? (' style="'+bodystyle+'"') : '') + ' topMargin="3" leftMargin="2" rightMargin="2" bottomMargin="2"'+(bodyclass ? ' class="'+bodyclass+'"' : '')+(this.bgcolor ? ' bgcolor="'+this.bgcolor+'"' : '')+'>');
	this.dom.document.write('</body></html>');
	this.dom.document.close();
}

weWysiwyg.prototype.windowFocus = function(){
	this.dom.window.focus();
}

weWysiwyg.prototype.start = function(){
	this.dom = new weDOM(frames[this.fName]);

	this.writeHTMLDocument();
	var sel = document.getElementById(this.ref+"_sel_applystyle");
	if (sel) {
		for(var i=0; i< we_classNames.length;i++){
			sel.options[i+1] = new Option(we_classNames[i]);
		}
	}
	document.getElementById(this.hiddenName).value = this.hiddenHTML;
	if(this.fullScreenRef){
		eval("var eobj = top.opener.weWysiwygObject_"+this.fullScreenRef);
		if(eobj.sourceMode){
			this.toggleSourceCode();
		}
	}
}

weWysiwyg.prototype.sendToEditor = function(html){
	/*
	html = html.replace(/<(\/?)ABBR/g,"<$1ACRONYM");
	html = html.replace(/<(\/?)abbr/g,"<$1acronym");
	*/
	html = html.replace(/<(\/?)STRONG>/gi,"<$1B>");
	html = html.replace(/<(\/?)strong>/gi,"<$1b>");
	html = html.replace(/<(\/?)EM>/gi,"<$1I>");
	html = html.replace(/<(\/?)em>/gi,"<$1i>");
	this.editContainer.innerHTML = html;
	var links = this.dom.document.getElementsByTagName("a");
	for (var i=0; i<links.length; i++) {
		links[i].setAttribute("onclick", "return parent.we_wysiwyg_false;" + (links[i].getAttribute("onclick") || ""));
		if (weDOM.hasAttribute(links[i],"name") && !weDOM.hasAttribute(links[i],"href")) {
			if(!links[i].innerHTML) links[i].innerHTML = '<img src="/webEdition/images/wysiwyg/anchor_small.gif">';
		}
	}
}


weWysiwyg.prototype.finalize = function(){
	this.editContainer = this.dom.document.body;
	this.editContainer.contentEditable = true;
	this.dom.document.execCommand("redo", false, null);
	var _w = this;
	this.dom.document.addEventListener("keydown", function(event){_w.keydown(event);}, true);
	this.dom.document.addEventListener("keyup", function(event){_w.keyup(event);}, true);
	this.dom.document.addEventListener("mousedown", function(event){_w.editmousedown(event);}, true);
	this.dom.document.addEventListener("mouseup", function(event){_w.editmouseup(event);_w.setButtonsState();}, true);
	this.dom.document.addEventListener("drag", function(event){_w.editdrag(event);}, true);
	this.sendToEditor(this.editHTML);
	this.editHTML = this.getEditHTML();
	this.undoSave();
}

weWysiwyg.prototype.saveSelection = function() {
	this.dom.updateRange();
	if (this.dom.range && this.dom.range.startContainer) {
		this.baseNodeBackup = this.dom.range.startContainer;
		this.baseOffsetBackup = this.dom.range.startOffset;
		this.extentNodeBackup = this.dom.range.endContainer;
		this.extentOffsetBackup = this.dom.range.endOffset;
	}
}

weWysiwyg.prototype.restoreSelection = function() {
	this.dom.window.getSelection().setBaseAndExtent(this.baseNodeBackup, this.baseOffsetBackup, this.extentNodeBackup, this.extentOffsetBackup);
}

weWysiwyg.prototype.eventFocus = function() {
	if (!this.hasFocus) {
		this.doSetFocus();
		this.windowFocus();
		this.setButtonsState();
	}
}


weWysiwyg.prototype.getButton = function(cmd){
	return this.buttons[cmd];
}


weWysiwyg.prototype.hasCmd = function(cmd){
	switch(cmd){
		case "inserttable":
		case "edittable":
		case "editcell":
		case "insertcolumnright":
		case "insertcolumnleft":
		case "insertrowabove":
		case "insertrowbelow":
		case "deleterow":
		case "deletecol":
		case "increasecolspan":
		case "decreasecolspan":
		case "caption":
		case "removecaption":
			return  (this.propString.indexOf(",table,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "cut":
		case "copy":
		case "paste":
			return  (this.propString.indexOf(",copypaste,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "forecolor":
		case "backcolor":
			return  (this.propString.indexOf(",color,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "createlink":
		case "unlink":
			return  (this.propString.indexOf(",link,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "insertunorderedlist":
		case "insertorderedlist":
		case "indent":
		case "outdent":
			return  (this.propString.indexOf(",list,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "justifyleft":
		case "justifycenter":
		case "justifyright":
		case "justifyfull":
			return  (this.propString.indexOf(",justify,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "bold":
		case "italic":
		case "underline":
		case "subscript":
		case "superscript":
		case "strikethrough":
		case "removeformat":
			return  (this.propString.indexOf(",prop,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		case "spellcheck":
			return  (this.propString.indexOf(",spellcheck,") > -1) || this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
		default:
			return  this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
	}
}


weWysiwyg.prototype.getHTML = function(){
	this.pre = false;
	this.nodeDone = null;
	var container = this.editContainer;
	var out = "";

	if(this.xml){
		this.editContainer.innerHTML = this.cleanCode(this.editContainer.innerHTML); //.replace(/\&nbsp;/gi,"<!-- ###WE_NBSP### -->");
		out = this.dom.getHTMLCode(container,false)
		//out = out.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;");
		// replace windows extended chars into entities
		for(var i=0;i<weWysiwyg.translationTable.length;i++){
			out = out.replace(new RegExp(String.fromCharCode(weWysiwyg.translationTable[i]),"g"),("&#"+weWysiwyg.translationTable[i]+";"));
		}
	} else {
		out = this.cleanCode(container.innerHTML);
	}
	out = out.replace(/<(\/?)b>/g,"<$1strong>");
	out = out.replace(/<(\/?)B>/g,"<$1STRONG>");
	out = out.replace(/<(\/?)i>/g,"<$1em>");
	out = out.replace(/<(\/?)I>/g,"<$1EM>");

	// replace special chars (from special chars dialog) which cannot be displayed into entities
	for(var i=0;i<weWysiwyg.specialChars.length;i++){
		out = out.replace(new RegExp(String.fromCharCode(weWysiwyg.specialChars[i]),"gi"),("&#"+weWysiwyg.specialChars[i]+";"));
	}

	return out.trim();
}

weWysiwyg.prototype.encodeText = function(str) {
	return str.replace(/&/ig, "&amp;").replace(/>/ig, "&gt;").replace(/</ig, "&lt;").replace(/\x22/ig, "&quot;");
};

weWysiwyg.prototype.cleanCode = function(code){

	code = this.removeHostname(code,false);
	if(this.removeFirstParagraph && code.substring(0,3).toUpperCase() == '<P>'){
		code = code.substring(3,code.length);
		code = weWysiwyg.removeAlloneEndtags(code,"P")
	}
	code = code.replace(/^<br>\n$/,"");
	code = code.replace(/_$§_WE_AMP_§$_/,"&");
	code = code.replace(/^<br>\r$/,"");
	code = code.replace(/^<br>\r\n$/,"");
	code = code.replace(/^<br>$/,"");
	code = code.replace(/return parent\.we_wysiwyg_false;/gi,"");
	code = code.replace(/ onclick=""/gi,"");
	code = code.replace(/<img src="\/webEdition\/images\/wysiwyg\/anchor_small.gif">/gi,"");
	code = code.replace(/<img src="\/webEdition\/images\/wysiwyg\/anchor_small.gif">/gi,"");
	code = code.replace(/<div style="[^"]+"><br class="khtml-block-placeholder"><\/div>/gi,"");
	var re = new RegExp(' </li',"gi");
	code = code.replace(re, '</li');
	re = new RegExp(String.fromCharCode(160)+'</li',"gi");
	code = code.replace(re, '</li');
	return code;
}

weWysiwyg.prototype.removeHostname = function(code,isurl){
	var hostname = this.location.hostname;
	var protocol = this.location.protocol;
	var port = this.location.port;
	if(isurl){
		var re = new RegExp(protocol+"//"+hostname+(port ? ":"+port : "")+"/","gi");
		return code.replace(re,"/");
	}else{
		var re = new RegExp("(['\"]?)"+protocol+"//"+hostname+(port ? ":"+port : "")+this.path+"#","gi");
		code = code.replace(re,"$1#");
		var re = new RegExp("(=['\"]?)"+protocol+"//"+hostname+(port ? ":"+port : "")+"/","gi");
		return code.replace(re,"$1/");
	}
}

weWysiwyg.prototype.cleanAnchor = function(code){
	var loc = this.fullScreenRef ? top.opener.document.location+""  : document.location+"";
	loc = loc.replace(/\//g,"\\/");
	loc = loc.replace(/\?/,"\\?");
	var re = new RegExp(loc+"(#[^>]*)","gi");
	code = code.replace(re,"$1");
	return code;
}

weWysiwyg.prototype.setHiddenText = function(){
	if(!this.fullScreenRef){
		var c1 = this.editHTML;
		c1 = c1.replace(/\n/gi,"");
		c1 = c1.replace(/\r/gi,"");
		var c2 = this.getEditHTML();
		c2 = c2.replace(/\n/gi,"");
		c2 = c2.replace(/\r/gi,"");
		if(c2=="<br>") c2="";
		var a = c1; //.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;");
		var b = c2; //.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;");
		if(a != b){
			this.hot = true;
			// in frontendedit  setEditorIsHot  does not exists
			if (this.isFrontendEdit==0 && weMainWinRef && weMainWinRef._EditorFrame && weMainWinRef._EditorFrame.setEditorIsHot) {
				weMainWinRef._EditorFrame.setEditorIsHot(true);
			}
		}
	}

	if(this.hot || this.fullScreenRef){
		var code = this.sourceMode ? document.getElementById(this.fName+"_src").value : this.getHTML();
		code = this.fullScreenRef ? code : code.replace(/(<img [^>]*)src=['"]?[^'">\? ]+\?id=([0-9]+)(['"]?[^>]*>)/gi,"$1src=\"document:$2$3");
		code = this.fullScreenRef ? code : code.replace(/(<img [^>]*)src=['"]?[^'">\? ]+\?thumb=([0-9,]+)(['"]?[^>]*>)/gi,"$1src=\"thumbnail:$2$3");
		document.getElementById(this.hiddenName).value = code;
		this.editHTML = code;
	}
}

weWysiwyg.prototype.getEditHTML = function(){
	if(this.sourceMode){
		var ta = document.getElementById(this.fName+"_src");
		return ta.value;
	}else{
		return this.getHTML();
	}
}




weWysiwyg.prototype.setEditorCSS = function(showBorders) {
	this.dom.document.getElementById('wysiwygcss').href = showBorders ? '/webEdition/wysiwyg/borders.css' : '/webEdition/wysiwyg/empty.css';
}

weWysiwyg.prototype.toggleSourceCode = function(){
	this.sourceMode = this.sourceMode ? false : true;
	var fr = document.getElementById(this.fName);
	var ta = document.getElementById(this.fName+"_src");
	if(this.sourceMode){
		for(var i=0;i<this.disableSourceButtons.length;i++){
			if(this.hasCmd(this.disableSourceButtons[i])){
				this.buttons[this.disableSourceButtons[i]].disable();
			}
		}

		for (var cmd in this.menus) {
			if(this.hasCmd(cmd)){
				this.menus[cmd].disable();
			}
		}

		this.buttons["editsource"].check();
		this.oldSourceTitle = this.buttons["editsource"].button.title;

		this.buttons["editsource"].button.src = weWysiwygImagesFolderPath + 'wysiwyg.gif';
		this.buttons["editsource"].button.title = 'Wysiwyg Editor';
		this.buttons["editsource"].button.alt = 'Wysiwyg Editor';
		fr.style.height=0;
		fr.style.visibility = "hidden";


		var eobj = null;
		if (top.opener) {
			eval("var eobj = top.opener.weWysiwygObject_"+this.fullScreenRef);
		}
		if (eobj && eobj.sourceMode) {
			ta.value = top.opener.document.getElementById(eobj.fName + "_src").value;
		}
		else {
			ta.value = this.getHTML();
		}

		ta.style.display = "block";
	}else{
		for(var i=0;i<this.disableSourceButtons.length;i++){
			if(this.hasCmd(this.disableSourceButtons[i])){
				this.buttons[this.disableSourceButtons[i]].enable();
			}
		}
		this.buttons["editsource"].uncheck();
		this.buttons["editsource"].button.src = weWysiwygImagesFolderPath + 'editsourcecode.gif';
		this.buttons["editsource"].button.title = this.oldSourceTitle;
		this.buttons["editsource"].button.alt = this.oldSourceTitle;
		this.sendToEditor(ta.value);

		if(this.hasCmd("visibleborders")) this.buttons["visibleborders"].out();
		ta.blur();
		ta.style.display = "none";
		fr.style.height=fr.height;
		fr.style.visibility = "visible";
	}

}

weWysiwyg.prototype.toggleBorders = function(){
	this.showBorders = this.showBorders ? false : true;

	this.setEditorCSS(this.showBorders);

	if(this.buttons["visibleborders"].button){
		if(this.showBorders){
			this.buttons["visibleborders"].button.title = we_wysiwyg_lng["hide_borders"];
			this.buttons["visibleborders"].button.alt = we_wysiwyg_lng["hide_borders"];
		}else{
			this.buttons["visibleborders"].button.title = we_wysiwyg_lng["visible_borders"];
			this.buttons["visibleborders"].button.alt = we_wysiwyg_lng["visible_borders"];
		}
	}

	this.editContainer.innerHTML = this.editContainer.innerHTML;
}


/****************************** Functions for updating toolbar **************************/

weWysiwyg.prototype.setButtonState = function(cmd, obj){
	if(this.hasCmd(cmd)){
		var enabled = this.queryCommandEnabled(cmd,obj);
		if(enabled){
			this.buttons[cmd].enable();
		}else{
			this.buttons[cmd].disable();
		}
	}
}

weWysiwyg.prototype.getQueryCommandOpimizedVals = function() {
	var parentNode = this.dom.getParentNodeFromSelection();
	var blockTag = false;
	var firstBlockTag = true;

	var obj = new Object();
	obj.strike = null;
	obj.a = null;
	obj.acronym = null;
	obj.abbr = null;
	obj.langspan = null;
	obj.table = null;
	obj.td = null;
	obj.tr = null;
	obj.caption = null;
	obj.blocktag = null;
	obj.parentNode = parentNode;
	obj.font = null;

	while (	(parentNode != null) &&
			(parentNode.nodeName.toLowerCase() != "body")
		) {
		if (weDOM.inlineTags.indexOf(" " + parentNode.nodeName.toLowerCase() + " ") == -1) {
			blockTag = true;
		}
		if (!blockTag) {
			switch (parentNode.nodeName.toLowerCase()) {
				case "strike":
					if (obj.strike == null) {
						obj.strike = parentNode;
					}
				break;

				case "a":
					if (obj.a == null) {
						obj.a = parentNode;
					}
				break;

				case "acronym":
					if (obj.acronym == null) {
						obj.acronym = parentNode;
					}
				break;

				case "abbr":
					if (obj.abbr == null) {
						obj.abbr = parentNode;
					}
				break;

				case "font":
					if (obj.font == null) {
						obj.font = parentNode;
					}
				break;

				case "span":
					if (obj.langspan == null && parentNode.lang) {
						obj.langspan = parentNode;
					}
				break;
			}
		} else if (firstBlockTag) {
			firstBlockTag = false;
			obj.blocktag = parentNode;
		}
		if (blockTag) {
			switch (parentNode.nodeName.toLowerCase()) {
				case "td":
				case "th":
					if (obj.td == null) {
						obj.td = parentNode;
					}
				break;

				case "tr":
					if (obj.tr == null) {
						obj.tr = parentNode;
					}
				break;

				case "table":
					if (obj.table == null) {
						obj.table = parentNode;
					}
				break;

				case "caption":
					if (obj.caption == null) {
						obj.caption = parentNode;
					}
				break;
			}
		}

		parentNode = parentNode.parentNode;
	}

	obj.align = "left";
	if (obj.blocktag && obj.blocktag.style && obj.blocktag.style.textAlign) {
		obj.align = obj.blocktag.style.textAlign.toLowerCase();
	}
	return obj;
}

weWysiwyg.prototype.getSelectedText = function() {
	return this.dom.getSelectedText();
}

weWysiwyg.prototype.queryCommandEnabled = function(cmd,obj) {
	var selText = this.dom.getSelectedText();
	switch(cmd){
		case "strikethrough":
			return obj.strike != null || selText.length > 0;
		case "edittable":
		case "caption":
			return obj.table != null;
		case "editcell":
		case "insertcolumnright":
		case "insertcolumnleft":
		case "insertrowabove":
		case "insertrowbelow":
		case "deleterow":
		case "deletecol":
			return obj.td != null;
		case "increasecolspan":
			return obj.td != null;
		case "decreasecolspan":
			return obj.td != null && obj.td.colspan && obj.td.colspan > 1;
		case "removecaption":
			return obj.caption != null;
		case "createlink":
			return obj.a != null || selText.length > 0;
		case "unlink":
			return obj.a != null;
		case "cut":
		case "copy":
			return selText.length > 0;
		case "acronym":
			return obj.acronym != null || selText.length > 0;
		case "abbr":
			return obj.abbr != null || selText.length > 0;
		case "lang":
			return obj.langspan != null || selText.length > 0;
		case "inserttable":
			if (obj.blocktag) {
				var nodeName = obj.blocktag.nodeName.toLowerCase();
				return (nodeName  != "table" && nodeName != "tbody");
			}
			return true
		case "formatblock":
			return obj.blocktag != null || (selText != null && selText.length > 0);
	}
	return true;
}

weWysiwyg.prototype.queryCommandState = function(cmd,obj) {

	switch(cmd){
		case "justifyright":
			return (obj.align == "right");
		case "justifycenter":
			return (obj.align == "center");
		case "justifyfull":
			return (obj.align == "justify");
		case "justifyleft":
			return (obj.align == "left");
		case "strikethrough":
			return obj.strike != null;
		case "acronym":
			return obj.acronym != null;
		case "abbr":
			return obj.abbr != null;
		case "lang":
			return obj.langspan != null;
 	}

	return this.dom.document.queryCommandState(cmd);
}


weWysiwyg.prototype.queryCommandValue = function(cmd,obj) {

	switch(cmd){
		case "fontname":
			return obj.font ? obj.font.face : null;
/*		case "fontsize":
			return (obj.align == "center");*/
		case "formatblock":
			return obj.blocktag ? obj.blocktag.nodeName.toLowerCase() : "";
		case "applystyle":
			return (obj && obj.parentNode && obj.parentNode.className) ? obj.parentNode.className : "";
 	}

	return this.dom.document.queryCommandValue(cmd);
}

weWysiwyg.prototype.setButtonsState = function(){
	if(!this.sourceMode){
		var obj = this.getQueryCommandOpimizedVals();

		for(var i=0;i<this.stateButtons.length;i++){
			this.setButtonState(this.stateButtons[i], obj);
		}

		for(var i=0;i<this.highlightButtons.length;i++){
			var cmd = this.highlightButtons[i];
			flag = this.queryCommandState(cmd,obj);
			if(flag && (!this.buttons[cmd].checked)){
				this.buttons[cmd].check();
			}else if((!flag) && this.buttons[cmd].checked){
				this.buttons[cmd].uncheck();
			}
		}
		if(this.showBorders && (!this.buttons["visibleborders"].checked)){
			this.buttons["visibleborders"].check();
		}else if((!this.showBorders) && this.buttons["visibleborders"].checked){
			this.buttons["visibleborders"].uncheck();
		}
		if (this.undoCircle.hasNext()) {
			this.buttons["redo"].enable();
		} else {
			this.buttons["redo"].disable();
		}
		if (this.undoCircle.hasPrevious()) {
			this.buttons["undo"].enable();
		} else {
			this.buttons["undo"].disable();
		}
		this.setMenuState("fontname",obj);
		this.setMenuState("fontsize",obj);
		this.setMenuState("formatblock",obj);
		this.setMenuState("applystyle",obj);
	}

}

weWysiwyg.prototype.setText = function(txt){
	if(this.sourceMode){
		var ta = document.getElementById(this.fName+"_src");
		ta.value = txt;
	}else{
		this.sendToEditor(txt);
		this.windowFocus();
	}
}

weWysiwyg.prototype.setMenuState = function(cmd,obj){
	if(this.hasCmd(cmd)){
		var enabled = this.queryCommandEnabled(cmd,obj);

		if(enabled){
			this.menus[cmd.toLowerCase()].enable();
		}else{
			this.menus[cmd.toLowerCase()].disable();
		}
		var newval = this.queryCommandValue(cmd,obj);
		if (newval) {
			if (cmd == "applystyle") {
				newval = "."+newval;
			}
			if (this.menus[cmd.toLowerCase()].hasValue(newval)) {
				this.menus[cmd.toLowerCase()].setValue(newval);
				return;
			}
		}
		this.menus[cmd.toLowerCase()].reset();
	}
}

/********************************* Commands ****************************************/

weWysiwyg.prototype.execCommand = function(cmd){
	if(this.sourceMode && cmd != "editsource" && cmd != "fullscreen"){
		return;
	}
	if (cmd != "undo" && cmd != "redo") {
		this.undoSave();
	}
	switch(cmd){
		case "insertspecialchar":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "specialCharDialog.php");
			dialog.open(400,300);
			break;
		case "insertimage":
			var image = this.dom.getImageFromSelection(true);
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "imageDialog.php");

			var preurl = document.location.protocol+"//"+document.location.hostname;
			if(image != null){
				if(weDOM.hasAttribute(image,"src")){
					var temp = "";
					if(image.getAttribute("src").indexOf(preurl) > -1){
						temp = image.getAttribute("src").substr(preurl.length,image.src.length);
					}else{
						temp = image.getAttribute("src");
					}
					dialog.append("src", temp);
				}
				dialog.append("width", null, image);
				dialog.append("height", null, image);
				dialog.append("hspace", null, image);
				dialog.append("vspace", null, image);
				dialog.append("class", null, image);
				dialog.append("border", null, image);
				dialog.append("alt", null, image);
				dialog.append("align", null, image);
				dialog.append("name", null, image);
				dialog.append("title", null, image);
				dialog.append("longdesc", null, image);
			}
			dialog.append("outsideWE", (this.outsideWE ? "1" : ""));
			dialog.append("cssClasses", this.cssClasses);
			dialog.open(600,550);
			break;
		case "anchor":
			this.dom.updateRange();
			var oldanchor = this.dom.isSurrounded("A");

			if( (oldanchor != null) && (weDOM.hasAttribute(oldanchor,"href")) && (!weDOM.hasAttribute(oldanchor,"name")) && (oldanchor.name.length > 0) ){
				oldanchor = null;
			}

			var anchorName = (oldanchor != null) ? oldanchor.name : "";
			anchorName = prompt(we_wysiwyg_lng["anchor_name"],anchorName);
			if(anchorName != null && anchorName.length > 0){
				anchor = oldanchor ? oldanchor : this.dom.document.createElement("A");
				if(anchor != null){
					anchor.name = anchorName;
					if(this.xml) anchor.id = anchorName;
					anchor.innerHTML = this.dom.getSelectedText();
				}
				if(oldanchor == null){
					if(!anchor.innerHTML) anchor.innerHTML = '<img src="/webEdition/images/wysiwyg/anchor_small.gif">';
					this.dom.insertNode(anchor);
				}
			}
			break;
		case "unlink":
			var link = this.dom.isSurrounded("A");
			if (link) {
				this.dom.removeParentnode(link);
			}
			break;
		case "createlink":
			var image = this.dom.getImageFromSelection(true);
			var link = this.dom.isSurrounded("A");
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "linkDialog.php");
			if(link != null){
				var link_href = this.removeHostname(link.href,true);
				var basepath = this.removeHostname(this.baseUrl,true);
				if(link_href.indexOf("#") > -1 && (link_href.length >= basepath.length && link_href.substring(0,basepath.length) == basepath)){
					link_href = link_href.substring(basepath.length,link_href.length);
				}
				var re = new RegExp("/webEdition[^\"']*/","gi");
				link_href = link_href.replace(re,"");
				var re = new RegExp("we_cmd.php[^#\"']+","gi");
				link_href = link_href.replace(re,"");

				dialog.append("href", link_href);
				dialog.append("target", null, link);
				dialog.append("class", null, link);
				dialog.append("lang", null, link);
				dialog.append("hreflang", null, link);
				dialog.append("title", null, link);
				dialog.append("accesskey", null, link);
				dialog.append("tabindex", null, link);
				dialog.append("rel", null, link);
				dialog.append("rev", null, link);
			}
			dialog.append("outsideWE", (this.outsideWE ? "1" : ""));
			dialog.append("cssClasses", this.cssClasses);
			if(link != null || this.dom.getSelectedText().length > 0 || image != null){
				dialog.open(580, 500);
			}else{
				top.we_showMessage(we_wysiwyg_lng["nothing_selected"], WE_MESSAGE_ERROR, window);
			}
			break;
		case "indent":
			this.indent();
			break;
		case "outdent":
			this.outdent();
			break;
		case "lang":

			var langspan = this.dom.getLangSpan();
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "langDialog.php");
			if(langspan != null){
				dialog.append("lang", null, langspan);
			}
			dialog.open(430, 190);
			break;

		case "acronym":
			var acronym = this.dom.isSurrounded("ACRONYM");
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "acronymDialog.php");
			if(acronym != null){
				dialog.append("title", null, acronym);
				dialog.append("lang", null, acronym);
			}
			dialog.append("language", this.language);
			dialog.open(430,190);
			break;

		case "abbr":
			var abbr = this.dom.isSurrounded("ABBR");
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "abbrDialog.php");
			if(abbr != null){
				dialog.append("title", null, abbr);
				dialog.append("lang", null, abbr);
			}
			dialog.append("language", this.language);
			dialog.open(430,190);
			break;

		case "insertunorderedlist":
			this.insertList('ul');
			break;
		case "insertorderedlist":
			this.insertList('ol');
			break;
		case "inserthorizontalrule":
			var rule = this.dom.getRuleFromSelection(true);
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "ruleDialog.php");
			if(rule != null){
				dialog.append("width", null, rule, true);
				dialog.append("height", null, rule, true);
				dialog.append("height", null, rule, true);
				dialog.append("align", null, rule);
				var html = this.dom.getHTMLCode(rule,true);
				if (html.search(/noshade/i) > -1) {
					dialog.append("noshade", 1);
				}
			}
			dialog.open(320, 240);
			break;
		case "strikethrough":
			this.dom.surroundInlineTag("strike");
			break;
		case "removeformat":
			if(confirm(we_wysiwyg_lng["removeformat_warning"])){
				var text = this.editContainer.innerHTML;

				var inlArr = this.inlineTags.trim().split(/ /);
				for(var i=0; i < inlArr.length; i++){
					var re = new RegExp("<"+inlArr[i]+" [^>]*>","gi");
					text = text.replace(re,"");
					re = new RegExp("</?"+inlArr[i]+">","gi");
					text = text.replace(re,"");
				}
				text = text.replace(/(<[^>]*)style="[^"]*"([^>]*>)/gi,"$1$2"); // remove style
				text = text.replace(/(<[^>]*)v?align="[^"]*"([^>]*>)/gi,"$1$2"); // remove align and valign
				this.editContainer.innerHTML = text;
			}
			break;
		case "insertbreak":
			this.dom.document.execCommand("InsertLineBreak", false, null);
			break;
		case "visibleborders":
			this.toggleBorders();
			break;
		case "importrtf":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "importRtfDialog.php");
			dialog.open(630, 400);
			break;
		case "fullscreen":
			var screen_height = screen.availHeight - 70;
			var screen_width = screen.availWidth-10;
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "fullscreenEditDialog.php");
			dialog.append("outsideWE", (this.outsideWE ? "1" : ""));
			dialog.append("xml", (this.xml ? "1" : ""));
			dialog.append("removeFirstParagraph", (this.removeFirstParagraph ? "1" : ""));
			dialog.append("baseHref", this.path);
			dialog.append("charset", this.charset);
			dialog.append("cssClasses", this.cssClasses);
			dialog.append("bgcolor", this.bgcolor);
			dialog.append("language", this.language);
			dialog.append("screenWidth", screen_width);
			dialog.append("screenHeight", screen_height);
			dialog.append("className", this.className);
			dialog.append("propString", this.propString);
			dialog.open(5000, 5000); // fullscreen
			break;
		case "editsource":
			this.toggleSourceCode();
			break;
		case "forecolor":
			var col = ""+this.dom.document.queryCommandValue("forecolor");
			var hexcol = (col.substring(0,1) == "#") ? col : weWysiwyg.makehexcolor(col);
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "colorDialog.php");
			dialog.append("type", "forecolor");
			dialog.append("color", hexcol);
			dialog.open(400, 380);
			break;
		case "backcolor":
			var col = ""+this.dom.document.queryCommandValue("backcolor");
			if (col.indexOf("rgba(") > -1) {
				var hexcol="";
			} else {
				var hexcol = (col.substring(0,1) == "#") ? col : weWysiwyg.makehexcolor(col);
			}
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "colorDialog.php");
			dialog.append("type", "backcolor");
			dialog.append("color", hexcol);
			dialog.open(400, 380);
			break;
		case "insertcolumnright":
			this.insertCol(true);
			break;
		case "insertcolumnleft":
			this.insertCol(false);
			break;
		case "insertrowabove":
			this.insertRow(true);
			break;
		case "insertrowbelow":
			this.insertRow(false);
			break;
		case "deleterow":
			this.deleteRow();
			break;
		case "deletecol":
			this.deleteCol();
			break;
		case "increasecolspan":
			this.colSpan(true);
			break;
		case "decreasecolspan":
			this.colSpan(false);
			break;
		case "caption":
			this.caption();
			break;
		case "removecaption":
			this.removecaption();
			break;
		case "editcell":
			var cell = this.dom.getTableCell();
			if(cell != null){
				var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "cellDialog.php");
				var isheader = (cell.nodeName.toLowerCase()=="td") ? 0 : 1;
				dialog.append("width", null, cell);
				dialog.append("height", null, cell);
				dialog.append("align", null, cell);
				dialog.append("class", null, cell);
				dialog.append("id", null, cell);
				dialog.append("headers", null, cell);
				dialog.append("scope", null, cell);
				dialog.append("valign", null, cell);
				dialog.append("bgcolor", null, cell);
				dialog.append("colspan", null, cell);
				dialog.append("cssClasses", this.cssClasses);
				dialog.append("isheader", isheader);
				dialog.open(500, 350);
			}else{
				top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
			}
			break;
		case "edittable":
			var table = this.dom.isSurrounded("TABLE",true);
			if(table != null){
				var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "tableDialog.php");
				dialog.append("border", null, table);
				dialog.append("cellpadding", null, table);
				dialog.append("cellspacing", null, table);
				dialog.append("bgcolor", null, table);
				dialog.append("class", null, table);
				dialog.append("width", null, table);
				dialog.append("height", null, table);
				dialog.append("align", null, table);
				dialog.append("background", null, table);
				dialog.append("summary", null, table);
				
	
				var rows = weDOM.getNumTableRows(table);
				var cols = weDOM.getNumTableCols(table);
				dialog.append("rows", rows);
				dialog.append("cols", cols);
				dialog.append("cssClasses", this.cssClasses);
				dialog.append("edit", 1);
				dialog.open(500, 340);
				
			}else{
				top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
			}
			break;
		case "inserttable":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "tableDialog.php");
			dialog.append("rows", 3);
			dialog.append("cols", 3);
			dialog.append("border", 1);
			dialog.append("edit", 0);
			dialog.append("cssClasses", this.cssClasses);
			dialog.open(500, 340);
			break;
		case "undo":
			this.undo();
			break;
		case "redo":
			this.redo();
			break;
		case "spellcheck":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "spellcheck.php");
			dialog.append("className", this.className);
			dialog.append("propString", this.propString);
			dialog.open(500,450);
			break;
		default:
			this.dom.document.execCommand(cmd, false, null);
	}
	if (cmd != "undo" && cmd != "redo") {
		this.undoSave();
	}
}


function weWysiwygDialog(editorName, action) {

	this.form = document.createElement('FORM');
	this.form.action = action;
	document.body.appendChild(this.form);

	this.append = function(name, value, elem, isStyle) {
		var hidden = document.createElement('INPUT');
		hidden.type="hidden";
		hidden.name = "we_dialog_args["+ name + "]";

		if (typeof(isStyle) == "undefined") {
			isStyle = false;
		}
		if (isStyle) {
			var val;
			if(we_hasAttribute(elem,"style")){
				eval('val = elem.style.'+name+';');
			}else{
				val = "";
			}
			val = val.replace(/([0-9]+)px/gi,"$1");
			hidden.value = (val) ? val : "";
		} else {
		
			if (value != null) {
				hidden.value=value;
			} else {
				hidden.value = weDOM.hasAttribute(elem,name) ? ((name == "class") ? elem.className : elem.getAttribute(name)) : "";
			}
		}
		this.form.appendChild(hidden);
	
	}
		
	this.append("editname", editorName);
	

	this.open = function(w,h) {
		var ref = "win_" + new Date().getTime();
		var win = new jsWindow("about:blank",ref,-1,-1,w,h,true,false,true,false);		
		this.form.target = ref;
		this.form.submit();
		document.body.removeChild(this.form);
	}

}


weWysiwyg.prototype.insertList = function(liType) {
	var obj = this.dom.getSelectedChildren('li');
	if (obj.parent != null) {
		var lists = new Array();
		if (obj.firstSelected != obj.firstChild && obj.firstIndex > 0) {
			var newList = this.dom.document.createElement(obj.parent.nodeName);
			for (var i=0; i< obj.firstIndex; i++) {
				if (obj.parent.childNodes[i].nodeName.toLowerCase() == "li") {
					var n = obj.parent.childNodes[i].cloneNode();
					n.innerHTML = obj.parent.childNodes[i].innerHTML;
					newList.appendChild(n);
					newList.appendChild(this.dom.createTextNode(String.fromCharCode(10)));
				}
			}
			lists.push(newList);
		}
		var maincontainer = null;
		var newContainer;
		if (obj.parent.nodeName.toLowerCase() == "ol" && liType == "ul") {
			newContainer = this.dom.document.createElement("ul");
		} else if (obj.parent.nodeName.toLowerCase() == "ul" && liType == "ol") {
			newContainer = this.dom.document.createElement("ol");
		} else if (obj.parent.nodeName.toLowerCase() == liType) {
			newContainer = this.dom.document.createDocumentFragment();
		}
		var start = (obj.firstIndex > 0) ? obj.firstIndex : 0;
		var last = (obj.lastIndex > -1 && obj.lastIndex < obj.parent.childNodes.length) ? obj.lastIndex : obj.parent.childNodes.length;

		var firstNodeToSelect = null;
		var lastNodeToSelect = null;

		for (var i=start; i<=last; i++) {
			if (obj.parent.childNodes[i].nodeName.toLowerCase() == "li") {
				var n = (newContainer.nodeType == weDOM.DOCUMENT_FRAGMENT_NODE) ? this.dom.document.createElement('div') : this.dom.document.createElement('li') ;
				n.innerHTML = obj.parent.childNodes[i].innerHTML;
				if (i == start) {
					firstNodeToSelect = n;
				}
				if (i == last) {
					lastNodeToSelect = n;
				}
				newContainer.appendChild(n);
				newContainer.appendChild(this.dom.createTextNode(String.fromCharCode(10)));
			}
		}
		lists.push(newContainer);
		maincontainer = newContainer;
		if (obj.lastIndex > -1 && obj.lastIndex+1 < obj.parent.childNodes.length && obj.lastSelected != obj.lastChild) {
			var newList = this.dom.document.createElement(obj.parent.nodeName);
			for (var i=obj.lastIndex+1; i< obj.parent.childNodes.length; i++) {
				if (obj.parent.childNodes[i].nodeName.toLowerCase() == "li") {
					var n = obj.parent.childNodes[i].cloneNode();
					n.innerHTML = obj.parent.childNodes[i].innerHTML;
					newList.appendChild(n);
					newList.appendChild(this.dom.createTextNode(String.fromCharCode(10)));
				}
			}
			lists.push(newList);
		}

		for (var i=0; i<lists.length;i++) {
			obj.parent.parentNode.insertBefore(lists[i],obj.parent);
		}
		obj.parent.parentNode.removeChild(obj.parent);
		if (firstNodeToSelect != null && lastNodeToSelect != null) {
			this.dom.selection.setBaseAndExtent(firstNodeToSelect, 0, lastNodeToSelect, 1);
		}
	} else {

		var html = this.dom.getSelectedHTML(true);

		if (! html) {
			html = '';
		}

		var container = this.dom.createElement(liType);
		container.id = "weWysiwygInsertedList";

		// get blocktags from weDOM and convert string to an array
		var blocktags = weDOM.formatblockTags.trim().split(/ /);
		// loop through all blocktags and replace blocktags with dummy
		for (var i=0; i<blocktags.length; i++) {
			var re = new RegExp('<(/?)' + blocktags[i] + '[^>]*>','gi');
			html = html.replace(re, '[##we_$1li_we##]');
		}
		if (html.match(/\[##we_/)) {
			// remove all Tags from code
			html = html.replace(/<[^>]+>/gi,'');
			// replace dummys
			html = html.replace(/\[##we_/gi, '<');
			html = html.replace(/_we##\]/gi, '>');

			var firstLi = html.indexOf("<li");
			if (firstLi > 0) {
				html = '<li>' + html.substring(0,firstLi) + '</li>' + html.substring(firstLi,html.length);
			}
			html = html.trim();
			var lastLi = html.lastIndexOf("</li>");
			if (lastLi > -1 && lastLi < (html.length - 5)) {
				html = html.substring(0,lastLi+5) + '<li>' + html.substring(lastLi+5,html.length) + "</li>";
			}

			container.innerHTML = html;
		} else {
			var li_node = this.dom.createElement("li");
			container.appendChild(li_node);
			li_node.innerHTML = html;
		}
		this.dom.insertNode(container);
		for (var i=0; i<blocktags.length; i++) {
			var re = new RegExp('<'+'?' + blocktags[i] + '[^>]*></' + blocktags[i] + '>','gi');
			this.editContainer.innerHTML = this.editContainer.innerHTML.replace(re,"");
		}
		container = this.dom.document.getElementById("weWysiwygInsertedList");
		if (container != null && container.firstChild != null) {
			this.dom.selection.setBaseAndExtent(container, 0, container, container.childNodes.length);
			container.removeAttribute("id");
		}
	}
}

weWysiwyg.prototype.indent = function() {
	var obj = this.dom.getSelectedChildren('li');
	if (obj.parent) {
		var node = this.dom.createElement(obj.parent.nodeName);
		obj.parent.insertBefore(node, obj.firstSelected);
		for (var i=0; i<obj.selectedChilds.length; i++) {
			node.appendChild(obj.selectedChilds[i]);
		}
	} else {
		var html = this.dom.getSelectedHTML();
		var blockquote;
		if (html.length) {
			blockquote = this.dom.createElement("blockquote");
			this.dom.surroundNode(blockquote);
			this.dom.selection.setBaseAndExtent(blockquote, 0, blockquote, blockquote.childNodes.length);
		}

	}
}

weWysiwyg.prototype.outdent = function() {
	var obj = this.dom.getSelectedChildren('li');
	if (obj.parent && obj.parent.parentNode && (obj.parent.parentNode.nodeName.toLowerCase()=="ul" || obj.parent.parentNode.nodeName.toLowerCase()=="ol")) {
		this.dom.removeParentnode(obj.parent);
		return;
	} else {
		var blockquote = this.dom.isSurrounded('blockquote');
		if (blockquote) {
			this.dom.removeParentnode(blockquote);
			return;
		}
	}
}

/*
*	applies a css class to the current selection
*
*/
weWysiwyg.prototype.applyClass = function(className) {
	// remove dot from className
	if(className && className.length && className.substring(0,1) == "."){
		className = className.substring(1,className.length);
	}
	// gets the selected text
	var selText = this.dom.getSelectedText();
	// gets the parent node of the selection
	var parentNode = this.dom.getParentNodeFromSelection();
	// check if we just can set the className to the parent node
	// we can do this if the selection is no range or
	// if the selections range ist the whole range of the parent node
	if (parentNode != null && (selText.length == 0 || (selText.length > 0 && parentNode.innerText == selText))) {
		parentNode.className = className;
		return;
	}
	// if there is no parent node we need to surround
	// the selection with a span tag and set the className there
	this.dom.surroundInlineTag("SPAN",{"class":className});
	return;
}

weWysiwyg.prototype.setForecolor = function(color){
	if (this.dom.getSelectedText(true).length && color) {
		this.dom.document.execCommand("forecolor", false, color);
	}else {
		var fontTag = this.dom.isSurrounded("FONT");
		if (fontTag != null) {
			if (color) {
				weDOM.setAttribute(fontTag,"color",color);
			} else {
				this.dom.removeParentnode(fontTag);
			}
		}
	}
}

weWysiwyg.prototype.setBackcolor = function(color){
	if (this.dom.getSelectedText(true).length && color) {
		this.dom.document.execCommand("backcolor", false, color);
	} else {
		var spanTag = this.dom.isSurrounded("SPAN");
		if (spanTag != null) {
			if (spanTag.className == "Apple-style-span" && spanTag.style.backgroundColor && spanTag.attributes.length == 2) {
				if (color) {
					spanTag.style.backgroundColor = color;
				} else {
					this.dom.removeParentnode(spanTag);
				}
			}
		}
	}
}

weWysiwyg.prototype.undo = function() {

	if (this.undoCircle.pointer == this.undoCircle.end) {
		this.undoSave();
	}

	var undoObj = this.undoCircle.getLastObject();


	if (undoObj != null) {
		this.editContainer.innerHTML = undoObj.content;
		var startContainer = weDOM.findNodeFromPath(this.editContainer, undoObj.startContainerPath);
		var startOffset = undoObj.startOffset;
		var endContainer = weDOM.findNodeFromPath(this.editContainer, undoObj.endContainerPath);
		var endOffset = undoObj.endOffset;
		if (startContainer != null && endContainer != null) {
			this.dom.window.getSelection().setBaseAndExtent(startContainer,startOffset,endContainer,endOffset);
		}
		this.lastKeyTime = 0;
	}
}

weWysiwyg.prototype.redo = function() {
	var undoObj = this.undoCircle.getNextObject();
	if (undoObj != null) {
		this.editContainer.innerHTML = undoObj.content;
		var startContainer = weDOM.findNodeFromPath(this.editContainer, undoObj.startContainerPath);
		var startOffset = undoObj.startOffset;
		var endContainer = weDOM.findNodeFromPath(this.editContainer, undoObj.endContainerPath);
		var endOffset = undoObj.endOffset;
		if (startContainer != null && endContainer != null) {
			this.dom.window.getSelection().setBaseAndExtent(startContainer,startOffset,endContainer,endOffset);
		}
		this.lastKeyTime = 0;
	}
}

weWysiwyg.prototype.undoSave = function() {

	this.dom.updateRange();

	// create undoObject
	var undoObj = new Object();
	undoObj.content = this.editContainer.innerHTML;
	undoObj.startContainerPath = (this.dom.range && this.dom.range.startContainer) ? weDOM.getNodePath(this.dom.range.startContainer) : null;
	undoObj.startOffset = this.dom.range ? this.dom.range.startOffset : 0;
	undoObj.endContainerPath = (this.dom.range && this.dom.range.endContainer) ? weDOM.getNodePath(this.dom.range.endContainer) : null;
	undoObj.endOffset = this.dom.range ? this.dom.range.endOffset : 0;

	this.undoCircle.appendObject(undoObj);
}

weWysiwyg.prototype.editrule = function(width,height,color,align,noshade){
	this.setEditorCSS(!this.showBorders);
	var rule = this.dom.getRuleFromSelection(true);
	var isNew = false;
	if(rule == null){
		isNew = true;
		rule = this.dom.createElement("HR");
	}
	rule.removeAttribute("style");
	if(width){
		rule.style.width = width;
	}
	if(height){
		rule.style.height = height;
	}
	if(color){
		rule.style.color = color;
		rule.style.backgroundColor = color;
		rule.style.borderColor = color;
	}
	weDOM.setRemoveAttribute(rule,"width",width);
	weDOM.setRemoveAttribute(rule,"size",height);
	weDOM.setRemoveAttribute(rule,"align",align);
	if(noshade==1) rule.setAttribute("noShade",1);
	else rule.removeAttribute("noShade");

	this.dom.insertNode(rule);
	var nextElem = this.dom.findNextNode(this.editContainer, rule);
	var elementsAfter = false;
	while (nextElem) {
		if (!(nextElem.nodeType == weDOM.TEXT_NODE && nextElem.nodeValue.length==0)){
			elementsAfter = true;
			break;
		}
		nextElem = this.dom.findNextNode(this.editContainer, nextElem);
	}
	if (!elementsAfter) {
		var space = this.dom.document.createTextNode(String.fromCharCode(160));
		rule.parentNode.appendChild(space);
		this.dom.selection.setBaseAndExtent(space,0,space,0);
	}
	this.windowFocus();
	this.setEditorCSS(this.showBorders);
}

weWysiwyg.prototype.editAcronym = function(title,lang){
	var sur_node = this.dom.isSurrounded("ACRONYM");
	if (	(sur_node != null && title.length==0) ||
			(sur_node == null)
		) {
		this.dom.surroundInlineTag("ACRONYM",{"title":title,"lang":lang});
	} else if (title.length==0) {
		return;
	} else if (sur_node != null) {
		weDOM.setAttribute(sur_node,"title",title);
		weDOM.setRemoveAttribute(sur_node,"lang",lang);
	}
}

weWysiwyg.prototype.editAbbr = function(title,lang){
	var sur_node = this.dom.isSurrounded("ABBR");
	if (	(sur_node != null && title.length==0) ||
			(sur_node == null)
		) {
		this.dom.surroundInlineTag("ABBR",{"title":title,"lang":lang});
	} else if (title.length==0) {
		return;
	} else if (sur_node != null) {
		weDOM.setAttribute(sur_node,"title",title);
		weDOM.setRemoveAttribute(sur_node,"lang",lang);
	}
}

weWysiwyg.prototype.editLang = function(lang){
	var span = this.dom.getParentNodeFromSelection();
	var selText = this.dom.getSelectedText();
	if(!(span.nodeName.toLowerCase()=="span" && span.innerHTML.replace(/<[^>]+>/g,"") == selText)){
		if(selText.length == 0){
			span = this.dom.getLangSpan();
		}else{
			if(lang.length == 0){
				return;
			}
			span = this.dom.surroundInlineTag("SPAN");
		}
	}
	if(span != null){
		weDOM.setRemoveAttribute(span,"lang",lang);
	}
	if(span.attributes.length == 0 || (span.attributes.length == 1 && span.attributes[0].value.length==0)){
		// remove empty span
		this.dom.removeParentnode(span);
	}
	if(this.showBorders){
		this.showBorders = false;
		this.toggleBorders();
	}
}

weWysiwyg.prototype.createLink = function(href,target,className,lang,hreflang,title,accesskey,tabindex,rel,rev){
	var link = this.dom.isSurrounded("A");

	this.setEditorCSS(!this.showBorders);

	if (!link) {
		link = this.dom.createElement("A");
		this.dom.surroundNode(link, true);

	}
	if(link != null){

		weDOM.setRemoveAttribute(link,"target",target);
		weDOM.setRemoveAttribute(link,"lang",lang);
		weDOM.setRemoveAttribute(link,"hrefLang",hreflang);
		weDOM.setRemoveAttribute(link,"title",title);
		weDOM.setRemoveAttribute(link,"accessKey",accesskey);
		weDOM.setRemoveAttribute(link,"tabIndex",tabindex);
		weDOM.setRemoveAttribute(link,"rel",rel);
		weDOM.setRemoveAttribute(link,"rev",rev);
		weDOM.setRemoveAttribute(link,"onclick","return parent.we_wysiwyg_false;");
		if(className.length){
			link.className = className;
		}else{
			link.removeAttribute("class");
			link.removeAttribute("className");
		}
		link.setAttribute("href",href);
		this.dom.selectNode(link);
	}
	this.windowFocus();
	this.setEditorCSS(this.showBorders);
}

weWysiwyg.prototype.insertImage = function(src,width,height,hspace,vspace,border,alt,align,name,className,title,longdesc){
	if(src && src.length > 0){
		var img = this.dom.getImageFromSelection(true);
		if (img==null) {
			img = this.dom.createElement("IMG");
			this.dom.insertNode(img);
		}
		if (img  != null) {
			img.setAttribute("src",src);
			weDOM.setRemoveAttribute(img,"width",width);
			weDOM.setRemoveAttribute(img,"height",height);
			weDOM.setRemoveAttribute(img,"hspace",hspace);
			weDOM.setRemoveAttribute(img,"vspace",vspace);
			weDOM.setRemoveAttribute(img,"border",border);
			weDOM.setRemoveAttribute(img,"alt",alt);
			weDOM.setRemoveAttribute(img,"title",title);
			weDOM.setRemoveAttribute(img,"longdesc",longdesc);
			if (className.length) {
				img.className = className;
			} else {
				img.removeAttribute("class");
				img.removeAttribute("className");
			}
			if (alt.length == 0) {
				img.setAttribute("alt","");
			}
			weDOM.setRemoveAttribute(img,"align",align);
			weDOM.setRemoveAttribute(img,"name",name);
		}
	}
	this.windowFocus();
}

weWysiwyg.prototype.edittable = function(edit,rows,cols,border,cellpadding,cellspacing,bgcolor,background,width,height,align,className,summary){
	var table;
	if(edit==false){
		table = this.dom.createElement("TABLE");
		var tbody = this.dom.createElement("TBODY");
		for(j=0; j < rows; j++){
			var mycurrent_row=this.dom.createElement("TR");
			for(i=0; i < cols; i++){
				var mycurrent_cell=this.dom.createElement("TD");
				mycurrent_cell.innerHTML = "&nbsp;";
				mycurrent_row.appendChild(mycurrent_cell);
			}
			tbody.appendChild(mycurrent_row);
		}
		table.appendChild(tbody);
	}else{
		table = this.dom.isSurrounded("TABLE",true);
	}


	if(table != null){

		if(weDOM.hasAttribute(table,"style")){
			if(weDOM.hasAttribute(table.style,"width")){
				table.style.removeAttribute("width");
			}
			if(weDOM.hasAttribute(table.style,"height")){
				table.style.removeAttribute("height");
			}
		}

		if(className.length){
			table.className = className;
		}else{
			table.removeAttribute("class");
			table.removeAttribute("className");
		}
		weDOM.setRemoveAttribute(table,"border",border);
		weDOM.setRemoveAttribute(table,"width",width);
		weDOM.setRemoveAttribute(table,"height",height);
		weDOM.setRemoveAttribute(table,"summary",summary);
		weDOM.setRemoveAttribute(table,"cellpadding",cellpadding);
		weDOM.setRemoveAttribute(table,"cellspacing",cellspacing);
		weDOM.setRemoveAttribute(table,"bgcolor",bgcolor);
		weDOM.setRemoveAttribute(table,"background",background);
		weDOM.setRemoveAttribute(table,"align",align);

		var oldrows = weDOM.getNumTableRows(table);
		var oldcols = weDOM.getNumTableCols(table);
		if(oldrows < rows){
			var rowsToAdd = rows-oldrows;
			for(var i=0;i<rowsToAdd;i++){
				this.appendTableRow(table);
			}
		}else if(oldrows > rows){
			var rowsToDel = oldrows-rows;
			for(var i=0;i<rowsToDel;i++){
				this.delTableRow(table);
			}
		}
		if(oldcols < cols){
			var colsToAdd = cols-oldcols;
			for(var i=0;i<colsToAdd;i++){
				this.appendTableCol(table,this.dom.document);
			}
		}else if(oldcols > cols){
			var colsToDel = oldcols-cols;
			for(var i=0;i<colsToDel;i++){
				this.delTableCol(table);
			}
		}

	}

	if(edit==false){
		var br = this.dom.createElement("BR");
		this.dom.insertNode(br);
		br.parentNode.insertBefore(table, br);
	}
}

weWysiwyg.prototype.editcell = function(width,height,bgcolor,align,valign,colspan,className,isheader,id,headers, scope){
	var table = this.dom.isSurrounded("TABLE");
	var cell = this.dom.getTableCell();
	if(cell != null){
		if(className != undefined && className.length){
			cell.className = className;
		}else{
			cell.removeAttribute("class");
			cell.removeAttribute("className");
		}
		weDOM.setRemoveAttribute(cell,"width",width);
		weDOM.setRemoveAttribute(cell,"height",height);
		weDOM.setRemoveAttribute(cell,"align",align);
		weDOM.setRemoveAttribute(cell,"id",id);
		weDOM.setRemoveAttribute(cell,"headers",headers);
		weDOM.setRemoveAttribute(cell,"scope",scope);
		weDOM.setRemoveAttribute(cell,"valign",valign);
		weDOM.setRemoveAttribute(cell,"bgcolor",bgcolor);

		if(colspan != "" || colspan=="0"){
			var oldcolspan = Math.max(1,(cell.getAttribute("colspan") == "") ? 1 : cell.getAttribute("colspan"));
			var tr = cell.parentNode;
			if(oldcolspan > colspan){
				var cellsToAdd = oldcolspan-colspan;
				for(var i=0; i<tr.childNodes.length;i++){
					if(tr.childNodes[i] == cell){
						if(i == (tr.childNodes.length-1)){
							for(var j=0;j<cellsToAdd;j++){
								var mycurrent_cell=this.dom.document.createElement(isheader ? "TH" : "TD");
								mycurrent_cell.innerHTML = "&nbsp;";
								tr.appendChild(mycurrent_cell);
							}
						}else{
							var node = tr.childNodes[i+1];
							for(var j=0;j<cellsToAdd;j++){
								var mycurrent_cell=this.dom.document.createElement(isheader ? "TH" : "TD");
								mycurrent_cell.innerHTML = "&nbsp;";
								tr.insertBefore(mycurrent_cell,node);
							}
						}
						break;
					}
				}
				cell.setAttribute("colspan",colspan);
			}else if(colspan > oldcolspan){
				var z=oldcolspan;
				var cellsToRemove = colspan-oldcolspan;
				for(var i=0; i<tr.childNodes.length;i++){
					if(tr.childNodes[i] == cell){
						var len = Math.min(tr.childNodes.length,i+1+cellsToRemove);
						for(var j=len-1; j >= (i+1);j--){
							tr.removeChild(tr.childNodes[j]);
							z++;
						}
						break;
					}
				}
				cell.setAttribute("colspan",z);
			}

		}
		if(isheader==1 && cell.nodeName == "TD"){
			var newTH = this.dom.document.createElement("TH");
			newTH.innerHTML = cell.innerHTML;
			weDOM.copyAttributes(cell,newTH);
			if(cell.style.cssText) newTH.style.cssText = cell.style.cssText;
			var parent = cell.parentNode;
			parent.replaceChild(newTH,cell);
		}else if(isheader==0 && cell.nodeName == "TH"){
			var newTD = this.dom.document.createElement("TD");
			newTD.innerHTML = cell.innerHTML;
			weDOM.copyAttributes(cell,newTD);
			if(cell.style.cssText) newTD.style.cssText = cell.style.cssText;
			var parent = cell.parentNode;
			parent.replaceChild(newTD,cell);
		}
	}
}

weWysiwyg.prototype.appendTableRow = function(table){
	var newrow=this.dom.document.createElement("TR");
	var numCols = weDOM.getNumTableCols(table);
	for(var i=0; i<numCols; i++){
		var mycurrent_cell=this.dom.document.createElement("TD");
		mycurrent_cell.innerHTML = "&nbsp;";
		newrow.appendChild(mycurrent_cell);
	}
	var tbody = table.firstChild;
	if(tbody != undefined && tbody.nodeName=="TBODY"){
		tbody.appendChild(newrow);
	}
}

weWysiwyg.prototype.appendTableCol = function(table){
	var tbody = weDOM.getTableBody(table);
	if(tbody.hasChildNodes()){
		for(var i=0; i< tbody.childNodes.length; i++){
			if(tbody.childNodes[i].nodeName == "TR"){
				var newcol=this.dom.document.createElement("TD");
				newcol.innerHTML = "&nbsp;";
				tbody.childNodes[i].appendChild(newcol);
			}
		}
	}
}

weWysiwyg.prototype.delTableRow = function(table,rowNr){
	var tbody = weDOM.getTableBody(table);
	if(tbody.hasChildNodes()){
		for(var i=tbody.childNodes.length-1; i>=0; i--){
			if(tbody.childNodes[i].nodeName == "TR"){
				tbody.removeChild(tbody.childNodes[i]);
				return true;
			}
		}
	}
	return false;
}

weWysiwyg.prototype.delTableCol = function(table){
	var tbody = weDOM.getTableBody(table);
	if(tbody.hasChildNodes()){
		for(var i=0; i< tbody.childNodes.length; i++){
			if(tbody.childNodes[i].nodeName == "TR"){
				var lastTD = weDOM.getLastTableCell(tbody.childNodes[i]);
				if(lastTD != null){
					var colspan = lastTD.colspan;
					if(colspan != undefined && colspan > 1){
						lastTD.setAttribute("colspan",colspan -1);
					}else{
						tbody.childNodes[i].removeChild(lastTD);
					}
				}
			}
		}
	}
}

weWysiwyg.prototype.insertCol = function(insertright){
	var td = this.dom.getTableCell();
	var tr = this.dom.isSurrounded("TR",true);
	var table = this.dom.isSurrounded("TABLE",true);
	if(td != null && tr != null && table != null){
		var foo = (tr.cells.length-1) - td.cellIndex;
		var rows = table.rows;
		for (i=0;i<rows.length;i++) {
			var count = rows[i].cells.length - 1;
			var pos = count - foo;
			pos = (pos < 0) ? 0 : pos;
			var cell = rows[i].insertCell(insertright ? (pos+1) : pos);
			cell.innerHTML = "&nbsp;";
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}
}

weWysiwyg.prototype.insertRow = function(insertabove){
	var tr = this.dom.isSurrounded("TR",true);
	var table = this.dom.isSurrounded("TABLE",true);

	if(tr != null && table != null){
		var cols_anz = 0;
		var cells = tr.cells;
		for (var i=0;i<cells.length;i++) {
			var csp = cells[i].colSpan;
			csp = csp ? csp : 1;
			cols_anz = cols_anz + csp;
		}
		var newRow = table.insertRow(insertabove ? tr.rowIndex : (tr.rowIndex+1));
		for (var i = 0; i < cols_anz; i++) {
			var cell=this.dom.document.createElement("TD");
			cell.innerHTML = "&nbsp;";
			newRow.appendChild(cell);
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}

}
weWysiwyg.prototype.deleteRow = function(){
	var tr = this.dom.isSurrounded("TR",true);
	var table = this.dom.isSurrounded("TABLE",true);
	if(tr != null && table != null){
		table.deleteRow(tr.rowIndex);
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}

}
weWysiwyg.prototype.deleteCol = function(){
	var td = this.dom.getTableCell();
	var tr = this.dom.isSurrounded("TR",true);
	var table = this.dom.isSurrounded("TABLE",true);

	if(td != null && tr != null && table != null){
		var foo = (tr.cells.length-1) - td.cellIndex;
		var rows = table.rows;
		for (var i=0; i < rows.length; i++) {
			var eor = rows[i].cells.length - 1;
			var pos = eor - foo;
			pos = (pos < 0) ? 0 : pos;
			var cells = rows[i].cells;
			if (cells[pos].colSpan > 1) {
				cells[pos].colSpan = cells[pos].colSpan - 1;
			} else {
				rows[i].deleteCell(pos);
			}

		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}

}
weWysiwyg.prototype.colSpan = function(increase){
	var td = this.dom.getTableCell();
	var tr = this.dom.isSurrounded("TR",true);
	var table = this.dom.isSurrounded("TABLE",true);
	var cells = tr.cells;
	var cellIndex = 0;
	for (var i=0; i< cells.length; i++) {
		if (cells[i] == td) {
			cellIndex = i
			break;
		}
	}
	if(td != null && tr != null && table != null){
		if(increase){
			var colspan = td.colSpan;
			colspan = colspan ? colspan : 1;
			if (cellIndex + 1 != tr.cells.length) {
				var colspan2add = cells[cellIndex+1].colSpan;
				colspan2add = colspan2add ? colspan2add : 1;
				tr.deleteCell(cellIndex+1);
				td.setAttribute("colspan",colspan + colspan2add);
			}
		}else{
			if (td.colSpan != 1) {
				var cell = tr.insertCell(cellIndex+1);
				cell.innerHTML = "&nbsp;";
				td.colSpan = td.colSpan - 1;
			}
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}
}

weWysiwyg.prototype.caption = function(){
	var table = this.dom.isSurrounded("TABLE",true);
	var newcaption=this.dom.document.createElement("CAPTION");
	newcaption.innerHTML=we_wysiwyg_lng["caption"];
	table.insertBefore(newcaption,table.firstChild);
}

weWysiwyg.prototype.removecaption = function(){
	var table = this.dom.isSurrounded("TABLE",true);
	var capts = table.getElementsByTagName("CAPTION");
	for(var i=0; i< capts.length; i++){
		table.removeChild(capts[i]);
	}
}

/********************* Event Handlers *************************/

weWysiwyg.prototype.selectChanged = function(cmd,value){
	this.menus[cmd].execCommand(value);
}

weWysiwyg.prototype.click = function(event, cmd){
	this.buttons[cmd].click();
	event.preventDefault();         // this doesn't solve the selection issue
	event.returnValue = false;      // this doesn't solve the selection issue
	return false;
}

weWysiwyg.prototype.out = function(cmd){
	this.buttons[cmd].out();
}

weWysiwyg.prototype.over = function(cmd){
	this.buttons[cmd].over();
}
weWysiwyg.prototype.check = function(cmd){
	this.buttons[cmd].check();
}

weWysiwyg.prototype.uncheck = function(cmd){
	this.buttons[cmd].uncheck();
}


weWysiwyg.prototype.keyup = function(event) {
	if (event && event.keyCode < 47) {
		this.setButtonsState();
	}
}

weWysiwyg.prototype.keydown = function(event) {
	var undoredo, paste, cut, all;
	if (event) {
		this.eventFocus();
		this.dom.updateRange();

		var date = new Date();
		var now = date.getTime();
		var keyString = String.fromCharCode(event.keyCode);

		// check if we have to save for undo
		if (event.metaKey) {
			undoredo = (keyString == 'Z');
			paste = (keyString == 'V');
			cut = (keyString == 'X');
			all = (keyString == 'A');
		}
		if (	cut || paste ||
				event.keyCode == 45 ||
				event.keyCode == 46 ||
				event.keyCode == 8 ||
				event.keyCode == 13 ||
				now >= (this.lastKeyTime + 2000) && !undoredo

			) {
			this.undoSave();
		}
		this.lastKeyTime = now;

		if (undoredo) { // check if we have to do undo or redo
			if (event.shiftKey) {
				this.redo();
			} else {
				this.undo();
			}
			we_stopEvent(event);
			return false;
		} else if (all) { // check if we have to select all
			this.selectAll();
			we_stopEvent(event);
			return false;
		}

		var li = this.dom.isSurrounded("LI");
		var cell = li ? null : this.dom.getTableCell();
		var caption = (li || cell) ? null : this.dom.isSurrounded("CAPTION");

		switch (event.keyCode) {
			case 8: // backspace
				if (li) {
					var startOfListItem = this.dom.selectionAtStartOfNode('li');
					var endOfListItem = this.dom.selectionAtEndOfNode('li');

					if (startOfListItem != null && endOfListItem != null) {
						if (this.dom.range.startOffset != this.dom.range.endOffset || this.dom.range.startContainer != this.dom.range.endContainer) { // no caret => range is selected
							// we need to delete content of the li item before
							weDOM.emptyNode(li);
							this.dom.setCaret(li, 0);
							we_stopEvent(event);
							return false;
						} else {
							// when the 2 last li items are empty and cursor is in last one
							// Safari normally deletes the whole list => fix that
							var nextListItem = weDOM.getSameNextSibling(li);
							var previousListItem = weDOM.getSamePreviousSibling(li);
							if (previousListItem == null && nextListItem == null) {
								li.parentNode.parentNode.removeChild(li.parentNode);
							} else if (previousListItem != null) {
								li.parentNode.removeChild(li);
								this.dom.setCaret(previousListItem, 1);
							}
							we_stopEvent(event);
							return false;
						}
					} else if (startOfListItem != null) { // cursor is at start of list item
						var previousListItem = weDOM.getSamePreviousSibling(li);
						for (var i=0; i<li.childNodes.length; i++) {
							previousListItem.appendChild(li.childNodes[i]);
						}
						li.parentNode.removeChild(li);
						if (previousListItem.lastChild) {
							if (previousListItem.lastChild.nodeValue) {
								this.dom.setCaret(previousListItem.lastChild, previousListItem.lastChild.nodeValue.length);
							} else {
								this.dom.setCaret(previousListItem.lastChild, 1);
							}
						} else {
							this.dom.setCaret(previousListItem, 0);
						}
						we_stopEvent(event);
						return false;
					} else if (endOfListItem != null) { // cursor is at end of list item
						var nextListItem = weDOM.getSameNextSibling(li);
						if (nextListItem == null) {
							if (li.innerText && li.innerText.trim().length == 1) {
								weDOM.emptyNode(li);
								this.dom.setCaret(li, 0);
								we_stopEvent(event);
								return false;
							}
						}
					}
				} else if (cell) {
					var prevRow = weDOM.getSamePreviousSibling(cell.parentNode);
					if (prevRow == null) {
						var prevCell = weDOM.getSamePreviousSibling(cell);
						if (prevCell == null) {
							var endOfCell = this.dom.selectionAtEndOfNode('td');
							if (endOfCell == null) {
								endOfCell = this.dom.selectionAtEndOfNode('th');
							}
							if (endOfCell != null) {
								if (cell.innerText.length == 1) {
									weDOM.emptyNode(cell);
									this.dom.setCaret(cell,0);
									we_stopEvent(event);
									return false;
								}
							}
						}
					}
				} else if (caption) {
					var startOfCaption = this.dom.selectionAtStartOfNode('caption');
					var endOfCaption = this.dom.selectionAtEndOfNode('caption');
					if (startOfCaption != null && endOfCaption != null) {
						weDOM.emptyNode(caption);
						var textNode = this.dom.createTextNode(String.fromCharCode(160));
						caption.appendChild(textNode);
						this.dom.setCaret(textNode,0);
						we_stopEvent(event);
						return false;
					} else if (endOfCaption != null) {
						if (caption.innerText.length == 1) {
							weDOM.emptyNode(caption);
							var textNode = this.dom.createTextNode(String.fromCharCode(160));
							caption.appendChild(textNode);
							this.dom.setCaret(textNode,0);
							we_stopEvent(event);
							return false;
						}
					}
				} else if (this.dom.selectionAtStartOfNode(this.editContainer.nodeName) && this.dom.selectionAtEndOfNode(this.editContainer.nodeName)) {
					this.editContainer.innerHTML = "";
					this.dom.setCaret(this.editContainer,0);
					we_stopEvent(event);
					return false;
				}
			break;

			case 13: // return;
				if (li) {
					if (event.shiftKey) {
						we_stopEvent(event);
						this.dom.document.execCommand("InsertLineBreak", false, null);
						return false;
					}
					var startOfListItem = this.dom.selectionAtStartOfNode('li');
					var endOfListItem = this.dom.selectionAtEndOfNode('li');
					var nextListItem = weDOM.getSameNextSibling(li);
					if ((li.innerText == String.fromCharCode(160) || li.innerText.length==0) && nextListItem == null) {
						var nextNodeAfterList = li.parentNode.nextSibling;
						while (nextNodeAfterList && nextNodeAfterList.nodeValue && nextNodeAfterList.nodeValue.charCodeAt(0) == 10) {
							nextNodeAfterList = nextNodeAfterList.nextSibling;
						}
						if (!nextNodeAfterList) {
							nextNodeAfterList = this.dom.document.createElement("div");
							nextNodeAfterList.innerHTML="<br>";
							li.parentNode.parentNode.appendChild(nextNodeAfterList);
						}
						li.parentNode.removeChild(li);
						this.dom.setCaret(nextNodeAfterList, 0);
						we_stopEvent(event);
						return false;
					}
					if (startOfListItem != null && endOfListItem != null) {
						if (this.dom.range.startOffset != this.dom.range.endOffset || this.dom.range.startContainer != this.dom.range.endContainer) { // no caret => range is selected
							// we need to delete content of the li item before
							weDOM.emptyNode(li);
						}
						if (nextListItem) {
							var newListElement = this.dom.document.createElement("li");
							li.parentNode.insertBefore(newListElement, nextListItem);
							this.dom.setCaret(newListElement, 0);
						}
						we_stopEvent(event);
						return false;
					} else if (endOfListItem != null) { // cursor is at end of list Item
						var newListElement = this.dom.document.createElement("li");
						var nextListItem = weDOM.getSameNextSibling(li);
						if (nextListItem) {
							li.parentNode.insertBefore(newListElement, nextListItem);
						} else {
							li.parentNode.appendChild(newListElement);
						}
						this.dom.setCaret(newListElement, 0);
						we_stopEvent(event);
						return false;
					} else if (startOfListItem != null) { // cursor is at start of list item
						var newListElement = this.dom.document.createElement("li");
						li.parentNode.insertBefore(newListElement, li);
						we_stopEvent(event);
						return false;
					}
				} else if (cell) {
					// if we are inside a table make a br when return is pressed,
					// otherwise Safari gets confused when try to edit the cell
					we_stopEvent(event);
					this.dom.document.execCommand("InsertLineBreak", false, null);
					return false;
				} else if (caption) {
					var startOfCaption = this.dom.selectionAtStartOfNode('caption');
					var endOfCaption = this.dom.selectionAtEndOfNode('caption');
					if (startOfCaption != null && endOfCaption != null) {
						weDOM.emptyNode(caption);
						var textNode = this.dom.createTextNode(String.fromCharCode(160));
						caption.appendChild(textNode);
						this.dom.setCaret(textNode,0);
						we_stopEvent(event);
						return false;
					}
				} else if (this.dom.selectionAtStartOfNode(this.editContainer.nodeName) && this.dom.selectionAtEndOfNode(this.editContainer.nodeName)) {
					this.editContainer.innerHTML = "";
					this.dom.setCaret(this.editContainer,0);
					we_stopEvent(event);
					return false;
				}
			break;

			case 37: // left arrow;
				if (li) {
					var startOfListItem = this.dom.selectionAtStartOfNode('li');
					var previousListItem = weDOM.getSamePreviousSibling(li);
					if (previousListItem && weDOM.isBreakedListNode(previousListItem)) {
						weDOM.emptyNode(previousListItem);
						this.dom.setCaret(previousListItem, 0);
						we_stopEvent(event);
						return false;
					}
				}
			break;

			case 39: // right arrow;
				if (li) {
					var endOfListItem = this.dom.selectionAtEndOfNode('li');
					var nextListItem = weDOM.getSameNextSibling(li);
					if (nextListItem && weDOM.isBreakedListNode(nextListItem)) {
						weDOM.emptyNode(nextListItem);
						this.dom.setCaret(nextListItem, 0);
						we_stopEvent(event);
						return false;
					}
				}
			break;

			case 46:
				if (this.dom.selectionAtStartOfNode(this.editContainer.nodeName) && this.dom.selectionAtEndOfNode(this.editContainer.nodeName)) {
					this.editContainer.innerHTML = "";
					this.dom.setCaret(this.editContainer,0);
					we_stopEvent(event);
					return false;
				}
			break;

			default:
				if (event.keyCode == 32 || event.keyCode > 46) {
					if (this.dom.selectionAtStartOfNode(this.editContainer.nodeName) && this.dom.selectionAtEndOfNode(this.editContainer.nodeName)) {
						this.editContainer.innerHTML = "";
						this.dom.setCaret(this.editContainer,0);
					}
					if (li) {
						var endOfListItem = this.dom.selectionAtEndOfNode('li');
						var startOfListItem = this.dom.selectionAtStartOfNode('li');
						var prevItem = weDOM.getSamePreviousSibling(li);
						var nextListItem = weDOM.getSameNextSibling(li);

						if (startOfListItem) {
							if (!prevItem) {
								if (endOfListItem && startOfListItem && li.innerText.length > 0) {
									weDOM.emptyNode(li);
								}
								var textNode = this.dom.createTextNode(String.fromCharCode(event.charCode));
								if (li.firstChild != null) {
									li.insertBefore(textNode, li.firstChild);
								} else {
									li.appendChild(textNode);
								}
								we_stopEvent(event);
								this.dom.setCaret(textNode,textNode.length);
								return false;
							} else {
								if (endOfListItem && !nextListItem) {
									var textNode = this.dom.createTextNode(String.fromCharCode(event.charCode));
									li.appendChild(textNode);
									we_stopEvent(event);
									this.dom.setCaret(textNode,textNode.length);
									return false;
								}
							}
/* 						} else if (endOfListItem) { */
/* 							if (!nextListItem) { */
/* 								var textNode = this.dom.createTextNode(String.fromCharCode((event.keyCode == 32) ? 160 : event.charCode)); */
/* 								li.appendChild(textNode); */
/* 								we_stopEvent(event); */
/* 								this.dom.setCaret(textNode,textNode.length); */
/* 								return false; */
/* 							} */
						} else if (endOfListItem) {
							var textNode = this.dom.createTextNode(String.fromCharCode(160));
							li.appendChild(textNode);
						}
					} else if (cell) {
						var prevRow = weDOM.getSamePreviousSibling(cell.parentNode);
						var nextRow = weDOM.getSameNextSibling(cell.parentNode);
						var nextCell = weDOM.getSameNextSibling(cell);
						if (nextRow == null && nextCell == null) {
							if (
								(
									(cell.lastChild && cell.lastChild == this.dom.range.endContainer) ||
									(cell.lastChild == null)
								) &&
								(
									(this.dom.range.endContainer.nodeType == weDOM.TEXT_NODE && this.dom.range.endOffset == this.dom.range.endContainer.data.length) ||
									(this.dom.range.endContainer.nodeType == weDOM.ELEMENT_NODE && this.dom.range.endOffset == 1) ||
									(this.dom.range.endContainer.nodeType == weDOM.ELEMENT_NODE && this.dom.range.endContainer == cell && cell.innerHTML.length==0)
								)
							) {
								var textNode = this.dom.createTextNode(String.fromCharCode(160));
								cell.appendChild(textNode);
							}

						} else if (prevRow == null) {
							var prevCell = weDOM.getSamePreviousSibling(cell);
							if (prevCell == null) {
								var startOfCell = this.dom.selectionAtStartOfNode('td');
								if (startOfCell == null) {
									startOfCell = this.dom.selectionAtStartOfNode('th');
								}
								if (startOfCell != null) {
									var textNode = this.dom.createTextNode(String.fromCharCode(event.charCode));
									if (cell.innerText.legth > 0) {
										this.dom.insertNode(textNode);
										this.dom.setCaret(this.dom.range.startContainer,1);
									} else {
										cell.appendChild(textNode);
										this.dom.setCaret(textNode,1);
									}
									we_stopEvent(event);
									return false;
								}
							}
						}
					} else if (caption) {
						var startOfCaption = this.dom.selectionAtStartOfNode('caption');
						var endOfCaption = this.dom.selectionAtEndOfNode('caption');
						if (startOfCaption != null && endOfCaption != null) {
							weDOM.emptyNode(caption);
							var textNode = this.dom.createTextNode(String.fromCharCode(event.charCode));
							caption.appendChild(textNode);
							this.dom.setCaret(textNode,textNode.length);
							we_stopEvent(event);
							return false;
						} else if (startOfCaption != null) {
							var textNode = this.dom.createTextNode(String.fromCharCode(event.charCode));
							if (caption.firstChild != null) {
								caption.insertBefore(textNode, caption.firstChild);
								we_stopEvent(event);
								this.dom.setCaret(textNode,textNode.length);
							}
						}
					}
				}
		}
	}
}




weWysiwyg.prototype.editmousedown = function(event) {
	this.dom.updateRange();
	this.mouseDownWasCaret = this.dom.range ? this.dom.range.collapsed : true;
	this.eventFocus();
	if (event.target) {
		if (event.target.nodeName.toLowerCase() == "table") {
			var tds = event.target.getElementsByTagName("TD");
			var nn = this.dom.findNextNode(this.dom.document.body,event.target.lastChild);
			this.dom.selection.setBaseAndExtent(tds[0].firstChild, 0, nn, 0);
			we_stopEvent(event);
			return false;
		} else if (event.target.nodeName.toLowerCase() == "li") {
			if ( weDOM.isBreakedListNode(event.target)) {
				weDOM.emptyNode(event.target);
				this.dom.selection.setBaseAndExtent(event.target, 0, event.target, 0);
				we_stopEvent(event);
				return false;
			}
		} else if (event.target.nodeName.toLowerCase() == "hr") {
			// turn content editable to false, because Safari puts cursor within hr
			this.editContainer.contentEditable = false;
		} else {
			this.editContainer.contentEditable = true;
			if (event.target.nodeName.toLowerCase() == "img") {
				this.dom.updateSelection();
				this.dom.selectNode(event.target);
				if (	event.target.parentNode &&
						(event.target.parentNode.nodeName.toLowerCase() == "a") &&
						weDOM.hasAttribute(event.target.parentNode,"name") &&
						(!weDOM.hasAttribute(event.target.parentNode,"href"))
					) {
					we_stopEvent(event);
					return false;
				}
			}
		}
	}
}

weWysiwyg.prototype.editmouseup = function(event) {
	this.dom.updateRange();
	var selNode = this.dom.getLastSurroundNode();
	// when selecting all with the mouse safari has a problem
	if (selNode == this.editContainer && this.mouseDownWasCaret) {
		if (this.dom.getSelectedHTML() == this.dom.getHTMLCode(this.editContainer,false)) {
			this.selectAll();
			we_stopEvent(event);
			return false;
		}
	}

	if (! weDOM.nodeInContainer(event.target, this.editContainer)) {
		this.selectAll();
		we_stopEvent(event);
		return false;
	}
	if (event.target && event.target.nodeName.toLowerCase() == "img") {
		we_stopEvent(event);
		return false;
	}
}

weWysiwyg.prototype.editdrag = function(event) {
	this.eventFocus();
}



// ############################# STATIC FUNCTIONS #################



weWysiwyg.dec2Hex = function(i) {
	var runningTotal = ''
	var quotient = weWysiwyg.hexQuotient(i);
	var remainder = eval(i + '-(' + quotient + '* 16)')
	runningTotal = weWysiwyg.we_charToHex(remainder) + runningTotal;
	while( quotient >= 16) {
		var savedQuotient = weWysiwyg.hexQuotient(quotient);
		remainder = eval(quotient + '-(' + savedQuotient + '* 16)');
		runningTotal = weWysiwyg.we_charToHex(remainder) + runningTotal;
		quotient = savedQuotient;
	}
	return weWysiwyg.we_charToHex(quotient) + runningTotal ;
}

weWysiwyg.hexQuotient = function(i) {
	return Math.floor(eval(i + "/16"));
}

weWysiwyg.we_charToHex = function(i){
	var hex = "0123456789ABCDEF";
	return hex.charAt(i);
}

weWysiwyg.makehexcolor = function(col){
	var hexcol = "";
		var r=col.replace(/rgb ?\((.+),.+,.+\)/,"$1")+"";
		var g=col.replace(/rgb ?\(.+,(.+),.+\)/,"$1")+"";
		var b=col.replace(/rgb ?\(.+,.+,(.+)\)/,"$1")+"";
		hexcol = "#"+weWysiwyg.dec2Hex(r.replace(/ /gi,""))+weWysiwyg.dec2Hex(g.replace(/ /gi,""))+weWysiwyg.dec2Hex(b.replace(/ /gi,""));
	return hexcol;
}


weWysiwyg.removeAlloneEndtags = function(html,tagname){
	var starttagpos = html.toUpperCase().indexOf("<"+tagname.toUpperCase());
	var endtagpos = html.toUpperCase().indexOf("</"+tagname.toUpperCase()+">");

	if(endtagpos > -1){
		if(endtagpos < starttagpos || starttagpos==-1){
			html = ((endtagpos > 0) ? html.substring(0,endtagpos) : "") +
					html.substring(endtagpos+tagname.length+3,html.length);
			html = weWysiwyg.removeAlloneEndtags(html,tagname);
		}
	}
	return html;
}

weWysiwyg.getParentStyles = function(node,styleSheets,cln){
	var ignoreParent = false;
	var parent = node.parentNode;
	var nodes = new Array();
	var i = 0;
	while(parent.nodeName.toLowerCase() != "body" && (parent != this.editContainer)){
		nodes[i] = parent;
		i++;
		parent = parent.parentNode;
	}
	nodes[i] = parent;
	var stylesArray = new Array();
	var lastClass = "";
	for(i=0; i<nodes.length; i++){
		var nn = nodes[i].nodeName.toLowerCase();
		if(nn == "td" || nn == "th" || nn == "tr" || nn == "table"){
			ignoreParent = true;
			break;
		}
	}


	for(i=(nodes.length-1); i >= 0; i--){
		var nn = nodes[i].nodeName.toLowerCase();
		if((!ignoreParent) ||
			(ignoreParent && (nn == "td" || nn == "th" || nn == "tr" || nn == "table" || nn == "body"))){
			var styles = weWysiwyg.getElementStyle(nn,styleSheets);
			for(var key in styles){
				stylesArray[key] = styles[key];
			}
		}

	}
	for(i=(nodes.length-1); i >= 0; i--){
		var nn = nodes[i].nodeName.toLowerCase();
		if((!ignoreParent) ||
			(ignoreParent && (nn == "td" || nn == "th" || nn == "tr" || nn == "table" || nn == "body"))){
			if(weDOM.hasAttribute(nodes[i],"class")){
				lastClass = nodes[i].className;
				var styles = weWysiwyg.getElementStyle("."+nodes[i].className,styleSheets);
				for(var key in styles){
					stylesArray[key] = styles[key];
				}
			}
		}

	}
	for(i=(nodes.length-1); i >= 0; i--){
		var nn = nodes[i].nodeName.toLowerCase();
		if((!ignoreParent) ||
			(ignoreParent && (nn == "td" || nn == "th" || nn == "tr" || nn == "table" || nn == "body"))){
			if(weDOM.hasAttribute(nodes[i],"id")){
				var styles = weWysiwyg.getElementStyle("#"+nodes[i].id,styleSheets);
				for(var key in styles){
					stylesArray[key] = styles[key];
				}
			}
		}

	}


	for(i=(nodes.length-1); i >= 0; i--){
		var nn = nodes[i].nodeName.toLowerCase();
		if((!ignoreParent) ||
			(ignoreParent && (nn == "td" || nn == "th" || nn == "tr" || nn == "table" || nn == "body"))){
			if(weDOM.hasAttribute(nodes[i],"style")){
				var styles = String(nodes[i].style.cssText).split(/;/);
				for (var n=0; n<styles.length; n++) {
					if (styles[n].trim().length > 0) {
						var pairs = styles[n].split(/\:/);
						var key = pairs[0].trim();
						var val = pairs[1].trim();
						stylesArray[key] = val;
					}
				}
			}
		}

	}

	if(cln){
		var styles = weWysiwyg.getElementStyle("."+cln,styleSheets);
		for(var key in styles){
			stylesArray[key] = styles[key];
		}
	}
	return new Array(lastClass,stylesArray);

}

weWysiwyg.getElementStyle = function(elementName,styleSheets){
	var styleArray = new Array();
	// loop through all styles
	for(var i=0;i<styleSheets.length;i++){
		// get the rules
		var r = styleSheets[i].cssRules;
		// loop through all rules
		for(var n=0;n<r.length;n++){
			// get selector Text (.class or elemName)
			var selectorText = r[n].selectorText;
			if(String(selectorText).length > 1 && String(selectorText).toLowerCase().indexOf(elementName.toLowerCase()) > -1){
				// loop through all selector text entries
				var v = String(selectorText).split(',');
				for(var m=0; m < v.length; m++){
					var el = elementName.toLowerCase().trim(); // element
					var selText = v[m].toLowerCase().trim(); // selector Text
					if(el == selText){
						style = r[n].style;
						if(style.cssText.length > 1){
							var properties = style.cssText.split(';');
							for (var o = 0; o < properties.length; o++) {
								if(properties[o].length > 1){
									var p = properties[o].split(':');
									if(p[1] != " null"){
										styleArray[String(p[0]).trim()] = String(p[1]).replace(/\&/g, "&amp;").replace(/</g, "&lt;").replace(/\"/g, "&quot;").trim();
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return styleArray;
}

weWysiwyg.inArray = function(needle,arr){
	for(var i=0; i< arr.length; i++){
		if(arr[i] == needle){
			return true;
		}
	}
	return false;
}

weWysiwyg.setupSyles = function() {
	if(we_styleString && we_styleString.length){
		we_classNames = weMainWinRef.we_classNames;
		we_styleSheets = weMainWinRef.we_styleSheets;
	}else{

		we_styleSheets = document.styleSheets;
		we_classNames = new Array();
		for(var i=0;i<we_styleSheets.length;i++){
			var r = we_styleSheets[i].cssRules;
			if(! we_styleSheets[i].href || we_styleSheets[i].href.indexOf("/webEdition/") == -1 || we_styleSheets[i].href==self.location.href){
				for(var n=0;n<r.length;n++){
					var s = r[n].style;
					if(r[n].selectorText && r[n].selectorText.toLowerCase().substring(1,9) != "tbbutton"){
						var styleAttr = s.cssText;
						var entry = r[n].selectorText;
						var arr = entry.split(/,/);
						for(var m=0;m<arr.length;m++){
							var e = arr[m];
							var arr2 = e.split(/ /);
							e = arr2[0];
							if(e.substring(0,1) == "."){
								if(!weWysiwyg.inArray(e,we_classNames)){
									we_classNames.push(e);
								}
							}
						}
						if((! weWysiwyg.inArray(entry,weCssEntries)) &&  entry.substring(0,4).toLowerCase() != "body"){
							we_styleString += entry + " { "+styleAttr+" }\n";
							weCssEntries.push(entry);
						}
					}
				}
			}
		}
	}
}

/*
* Class for storing objects in a circle.
* When circle is full, next storing position is the first again
*
*/

function weCircleStack(length){

	this.length = length;
	this.array = new Array();
	for (var i=0; i< length; i++) {
		this.array[i] = null;
	}
	this.pointer = -1;
	this.steps = 0;
	this.start = -1;
	this.end = -1;

	this.appendObject = function(obj) {

		// exit if new object is equal to the last
		if (this.pointer > -1) {
			if (this.compareFN == null) {
				if (this.array[this.pointer] == obj)  {
					return;
				}
			} else {
				if (this.compareFN(this.array[this.pointer],obj)) {
					return;
				}
			}
		}
		if (this.pointer != this.end) {
			this.steps = (this.start <= this.end) ? ((this.end - this.start) + 1) : ((this.length-this.start) + this.end +1);
		}


		this.pointer++;
		this.steps++;
		if (this.steps == this.length+1) {
			this.start++;
			this.start = (this.start >= this.length) ? 0 : this.start;
			this.steps = this.length;
		}
		this.pointer = (this.pointer >= this.length) ? 0 : this.pointer;
		this.array[this.pointer] = obj;
		this.end = this.pointer;
		if (this.start == -1) { this.start = 0;}

	}


	this.isInRange = function(nr) {
		if (this.start > this.end) {
			return ((nr >= this.start) && (nr <= (this.length-1))) || ((nr >= 0) && (nr <= this.end));
		} else {
			return (nr >= this.start) && (nr <= this.end);
		}
	}

	this.getObject = function() {
		return (this.pointer > -1) ? this.array[this.pointer] : null;
	}

	this.hasPrevious = function() {
		var tmp = this.pointer;
		tmp--;
		tmp = (tmp < 0) ? (this.length-1) : tmp;
		return this.isInRange(tmp) && (this.pointer != this.start);
	}

	this.hasNext = function() {
		var tmp = this.pointer;
		tmp++;
		tmp = (tmp >= this.length) ? 0 : tmp;
		return this.isInRange(tmp) && (this.pointer != this.end);
	}

	this.rewind = function() {

		if (this.hasPrevious()) {
			this.pointer--;
			this.pointer = (this.pointer < 0) ? (this.length-1) : this.pointer;
			return true;
		}
		return false;
	}

	this.forward = function() {

		if (this.hasNext()) {
			this.pointer++;
			this.pointer = (this.pointer >= this.length) ? 0 : this.pointer;
			return true;
		}
		return false;
	}

	this.getLastObject = function() {
		if (this.rewind()) {
			return this.getObject();
		}
		return null;
	}

	this.getNextObject = function() {
		if (this.forward()) {
			return this.getObject();
		}
		return null;
	}

}

// ###############################################################
// ############### Class weWysiwygPopupMenu ######################
// ###############################################################

weWysiwygPopupMenu.Count = 0;

function weWysiwygPopupMenu(cmd,editor){
	this.name = "weWysiwygPopupMenu_" + (weWysiwygPopupMenu.Count++);
	this.editor = editor;
	this.cmd = cmd;
	this.id = this.editor.ref+"_sel_"+this.cmd;
	this.disabled = false;
	this.obj = "weWysiwygPopupMenuObject_"+this.name;
	eval(this.obj + "=this");

}

weWysiwygPopupMenu.prototype.execCommand = function(value){
	if (value.length == 0)  return;
	if(this.editor.sourceMode){
		return;
	}
	this.editor.windowFocus();
	if(this.cmd == "formatblock"){
		this.editor.dom.surroundBlockTag(value);
	} else if(this.cmd=="applystyle"){
		this.editor.applyClass(value);
	}
	this.editor.dom.document.execCommand(this.cmd, false, value);
	this.editor.setMenuState(this.cmd);
}

weWysiwygPopupMenu.prototype.enable = function(){
	var sel = document.getElementById(this.id);
	sel.disabled = false;
}

weWysiwygPopupMenu.prototype.disable = function(){
	var sel = document.getElementById(this.id);
	sel.disabled = true;
}

weWysiwygPopupMenu.prototype.hasValue = function(value){
	var sel = document.getElementById(this.id);
	for (var i=0; i<sel.options.length; i++) {
		if (sel.options[i].value == value) {
			return true;
		}
	}
	return false;
}

weWysiwygPopupMenu.prototype.setValue = function(value){
	var sel = document.getElementById(this.id);
	sel.value = value;
}

weWysiwygPopupMenu.prototype.reset = function(){
	var sel = document.getElementById(this.id);
	sel.selectedIndex=0;
}

// ###############################################################
// ############### Class weWysiwygButton #########################
// ###############################################################

weWysiwygButton.Count = 0;

function weWysiwygButton(cmd,editor){

	this.name = "weWysiwygButton_" + (weWysiwygButton.Count++);
	this.cmd = cmd;
	this.editor = editor;

	this.checked = false;
	this.isover = false;
	this.disabled = false;

	this.div = document.getElementById(this.editor.fName+"_"+this.cmd+"Div");
	this.button = document.getElementById(this.editor.fName+"_"+this.cmd);

	this.obj = "weWysiwygButtonObject_"+this.name;
	eval(this.obj + "=this");
}

weWysiwygButton.prototype.click = function(){
	if(!this.disabled){
		this.execCommand();
	}
}

weWysiwygButton.prototype.over = function(){
	if(!this.disabled){
		this.isover = true;
		this.div.className = "tbButtonMouseOverUp";
		return true;
	}
}

weWysiwygButton.prototype.out = function(){
	if(!this.disabled){
		this.isover = false;
		this.div.className = this.checked ? "tbButtonDown" : "tbButton";
		return true;
	}
}

weWysiwygButton.prototype.check = function(){
	if((!this.disabled) && (!this.checked) && this.div){
		this.checked = true;
		this.div.className = "tbButtonDown";
		return true;
	}
}

weWysiwygButton.prototype.uncheck = function(){
	if((!this.disabled) && this.checked && this.div){
		this.checked = false;
		this.div.className = "tbButton";
		return true;
	}
}

weWysiwygButton.prototype.disable = function(){
	if(!this.disabled && this.div){
		this.disabled = true;
			this.div.className = "tbButton";
			var src = this.button.src;
			if(src.indexOf("_dis.gif") == -1) src = src.replace(/\.gif/,"_dis.gif");
			this.button.src = src;
	}
}

weWysiwygButton.prototype.enable = function(){
	if(this.disabled && this.div){
		this.disabled = false;

		this.div.className = "tbButton";
		var src = this.button.src;
		src = src.replace(/_dis\.gif/,".gif");
		this.button.src = src;
	}
}

weWysiwygButton.prototype.execCommand = function(){
	this.editor.execCommand(this.cmd);
	this.editor.setButtonsState();
}

/************* Functions for handling events ****************/

function we_addEvent(e, name, f) {
	e.addEventListener(name, f, true);
}

function we_stopEvent(ev) {
	ev.preventDefault();
	ev.stopPropagation();
}

function we_removeEvent(e, name, f) {
	e.removeEventListener(name, f, true);
}


/************* String extensions ****************/

String.prototype.trim=function () {
   return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.trim2=function () {
   return this.replace(/^\s{2,}|\s{2,}$/g," ");
}
