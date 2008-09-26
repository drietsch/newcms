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

//document.write('<textarea id="debug" name="debug" rows="10" cols="70"></textarea>');
String.prototype.trim=function () {
   return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.trim2=function () {
   return this.replace(/^\s{2,}|\s{2,}$/g," ");
}

//Detect IE5.5+
var weIE55=false;
if (navigator.appVersion.indexOf("MSIE")!=-1){
	var temp=navigator.appVersion.split("MSIE");
	weIE55= parseFloat(temp[1]) < 6;
}


var we_styleSheets;
var we_classNames;
var we_styleString = "";
var we_parentRef = null;

var weMainWinRef = self;
var weCssEntries = new Array();

var isFullScreen = false;

	try{
		if (top.weEditorFrameController) {
			weMainWinRef = top.weEditorFrameController.getVisibleEditorFrame();
		} else if(top.opener && top.opener.top.weEditorFrameController && top.opener.top.weEditorFrameController.getVisibleEditorFrame() && top.opener.top.weEditorFrameController.getVisibleEditorFrame().document){
			weMainWinRef = top.opener.top.weEditorFrameController.getVisibleEditorFrame();
		}else if(top.opener && top.opener.we_styleString){
			weMainWinRef = top.opener;
		}
	}catch(e){}




if(isGecko){
	try{
		we_styleString = weMainWinRef.we_styleString;
	}catch(e) {}
}else{
	if(weMainWinRef.we_styleString){
		we_styleString = weMainWinRef.we_styleString;
	}
}

if(we_styleString && we_styleString.length){
	we_classNames = weMainWinRef.we_classNames;
	we_styleSheets = weMainWinRef.we_styleSheets;
}else{

	we_styleSheets = document.styleSheets;
	we_classNames = new Array();
	if(isGecko){
		for(var i=0;i<we_styleSheets.length;i++){
			var r = we_styleSheets[i].cssRules;
			if(! we_styleSheets[i].href || we_styleSheets[i].href.indexOf("/webEdition/") == -1 || we_styleSheets[i].href==self.location.href){
				for(var n=0;n<r.length;n++){
					var s = r[n].style;

					if(r[n].selectorText && r[n].selectorText.substring(1,9) != "tbButton"){
						var styleAttr = s.cssText;
						var entry = r[n].selectorText;
						var arr = entry.split(/,/);
						for(var m=0;m<arr.length;m++){
							var e = arr[m];
							var arr2 = e.split(/ /);

							// Bug Fix 7419
							for(var x = 0; x < arr2.length; x++) {
								if(arr2[x].trim() != "") {
									e = arr2[x];
								}
							}

							if(e.substring(0,1) == "."){
								if(!weWysiwygInArray(e,we_classNames)){
									we_classNames.push(e);
								}
							}
						}
						if((! weWysiwygInArray(entry,weCssEntries)) &&  entry.substring(0,4).toLowerCase() != "body"){
							we_styleString += entry + " { "+styleAttr+" }\n";
							weCssEntries.push(entry);
						}
					}
				}
			}
		}
	}else{
		for(var i=0;i<we_styleSheets.length;i++){
			var r = we_styleSheets(i).rules;
			if(! we_styleSheets(i).href || we_styleSheets(i).href.indexOf("/webEdition/") == -1 || we_styleSheets[i].href==self.location.href){
				for(var n=0;n<r.length;n++){
					var s = r(n).style;
					if(r(n).selectorText.substring(1,9) != "tbButton"){
						var styleAttr = s.cssText;
						var entry = r(n).selectorText;
						var arr = entry.split(/ /);
						var e = arr[0];
						if(e.substring(0,1) == "."){
							if(!weWysiwygInArray(e,we_classNames)){
								we_classNames.push(e);
							}
						}
						if((! weWysiwygInArray(entry,weCssEntries)) &&  entry.substring(0,4).toLowerCase() != "body"){
							we_styleString += entry + " { "+styleAttr+" }\n";
							weCssEntries.push(entry);
						}
					}
				}
			}

		}
	}
}

function weWysiwygInArray(needle,arr){
	for(var i=0; i< arr.length; i++){
		if(arr[i] == needle){
			return true;
		}
	}
	return false;
}

// ###############################################################
// ############### Class weWysiwyg ###############################
// ###############################################################

function weWysiwyg(fName,hiddenName,hiddenHTML,editHTML,fullScreenRef,className,propString,bgcolor,outsideWE,path,xml,removeFirstParagraph,charset,cssClasses,Language, isFrontendEdit){
	this.fName = fName;
	this.fullScreenRef = fullScreenRef;
	this.name = this.fName.replace(/[\[\]]/g,"");
	this.hiddenName = hiddenName;
	this.ref = hiddenName.replace(/[^0-9a-zA-Z_]/gi,"");
	this.propString = propString;
	this.bgcolor = bgcolor;
	this.className = className;
	this.language = Language
	this.range = null;
	this.selection = null;
	this.showBorderStyle = "#CCCCCC 1px dotted";
	this.outsideWE = outsideWE;
	this.xml=xml;
	this.removeFirstParagraph = removeFirstParagraph;
	this.charset = charset;
	this.cssClasses = cssClasses;
	this.isFrontendEdit = isFrontendEdit;
	this.showBorders = false;
	this.sourceMode = false;
	this.hasFocus = false;
	this.location = this.fullScreenRef ? top.opener.document.location  : document.location;
	this.preurl = this.location.protocol + "//" + this.location.hostname + (this.location.port ? ":"+this.location.port : "");
	this.nodeDone = null;
	this.baseUrl = path ? (this.preurl + path) : this.location.href;
	this.path = path;
	this.pre = false;
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

	this.highlightButtons = new Array("forecolor","backcolor","cut","copy","paste","undo","redo","bold","italic","underline","subscript","superscript","strikethrough","removeformat","insertunorderedlist","insertorderedlist","justifyleft","justifycenter","justifyright","justifyfull");
	this.editTableButtons = new Array("editcell","insertcolumnleft","insertcolumnright","insertrowabove","insertrowbelow","deleterow","deletecol","increasecolspan","decreasecolspan");
	this.disableSourceButtons = new Array("cut","copy","paste","undo","redo","insertbreak","importrtf","visibleborders","forecolor","backcolor","inserttable","inserthorizontalrule","insertspecialchar","createlink","unlink","anchor","insertimage","indent","outdent","undo","redo","bold","italic","underline","subscript","superscript","strikethrough","removeformat","insertunorderedlist","insertorderedlist","justifyleft","justifycenter","justifyright","justifyfull","unlink","edittable","editcell","insertcolumnleft","insertcolumnright","insertrowabove","insertrowbelow","deleterow","deletecol","increasecolspan","decreasecolspan","acronym","abbr","lang");

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

	this.hot = false;

	// Functions
	this.timeout = weWysiwyg_timeout;
	this.windowFocus = weWysiwyg_windowFocus;
	this.getSelection = weWysiwyg_getSelection;
	this.setHiddenText = weWysiwyg_setHiddenText;
	this.click = weWysiwyg_click;
	this.out = weWysiwyg_out;
	this.over = weWysiwyg_over;
	this.check = weWysiwyg_check;
	this.uncheck = weWysiwyg_uncheck;
	this.start = weWysiwyg_start;
	this.createLink = weWysiwyg_createLink;
	this.insertImage = weWysiwyg_insertImage;
	this.finalize = we_wysiwyg_finalize;

	this.edittable = weWysiwyg_edittable;
	this.editcell = weWysiwyg_editcell;
	this.insertCol = weWysiwyg_insertCol;
	this.insertRow = weWysiwyg_insertRow;
	this.deleteRow = weWysiwyg_deleteRow;
	this.deleteCol = weWysiwyg_deleteCol;
	this.colSpan = weWysiwyg_colSpan;
	this.caption = weWysiwyg_caption;
	this.removecaption = weWysiwyg_removecaption;

	this.setForecolor = weWysiwyg_setForecolor;
	this.setBackcolor = weWysiwyg_setBackcolor;
	this.setText = weWysiwyg_setText;
	this.getEditHTML = weWysiwyg_getEditHTML;
	this.showContextMenu = weWysiwyg_showContextMenu;
	this.getButton = weWysiwyg_getButton;
	this.cleanCode = weWysiwyg_cleanCode;
	this.writeHTMLDocument = weWysiwyg_writeHTMLDocument;
	this.geckoStart = weWysiwyg_geckoStart;
	this.IEStart = weWysiwyg_IEStart;
	this.getImage = weWysiwyg_getImage;
	this.getNodeUnderInsertionPoint = weWysiwyg_getNodeUnderInsertionPoint;
	this.getNodeUnderInsertionPoint2 = weWysiwyg_getNodeUnderInsertionPoint2;
	this.insertContent = weWysiwyg_insertContent;
	this.execCommand = weWysiwyg_execCommand;
	this.hasCmd = weWysiwyg_hasCmd;
	this.replaceText = weWysiwyg_replaceText;
	this.removeHostname = weWysiwyg_removeHostname;
	this.showPopupmenu = weWysiwyg_showPopupmenu;
	this.setPopupmenu = weWysiwyg_setPopupmenu;
	this.setButtonState = weWysiwyg_setButtonState;
	this.setButtonsState = weWysiwyg_setButtonsState;
	this.setMenuState = weWysiwyg_setMenuState;
	this.getLangSpan = weWysiwyg_getLangSpan;
	this.getParentElementFromRange = weWysiwyg_getParentElementFromRange;
	this.decodeUmlautDomain = weWysiwyg_decodeUmlautDomain;
	this.decodeDomainUmlautsOfUrl = weWysiwyg_decodeDomainUmlautsOfUrl;
	
	this.doStyle = weWysiwyg_doStyle;
	this.doStyleIE = weWysiwyg_doStyleIE;
	this.doStyleGecko = weWysiwyg_doStyleGecko;

	this.getSelectedText = weWysiwyg_getSelectedText;
	this.toggleBorders = weWysiwyg_toggleBorders;

	this.appendTableRow = weWysiwyg_appendTableRow;
	this.appendTableCol = weWysiwyg_appendTableCol;
	this.delTableRow = weWysiwyg_delTableRow;
	this.delTableCol = weWysiwyg_delTableCol;

	this.toggleSourceCode = we_wysiwyg_toggleSourceCode;
	this.cleanAnchor = weWysiwyg_cleanAnchor;

	this.editrule = weWysiwyg_editrule;
	this.editAbbr = weWysiwyg_editAbbr;
	this.editAcronym = weWysiwyg_editAcronym;
	this.editLang = weWysiwyg_editLang;
	this.getRule = weWysiwyg_getRule;

	this.getHTML = weWysiwyg_getHTML;
	this.getHTMLCode = weWysiwyg_getHTMLCode;
	this.encodeText = weWysiwyg_encodeText;

	this.sendToEditor = we_wysiwyg_sendToEditor;

	this.doSetFocus = weWysiwyg_doSetFocus;

	this.obj = "weWysiwygObject_"+this.name;
	eval(this.obj + "=this");
}


function weWysiwyg_doSetFocus(){
	try {
		for (var i = 0; i < we_wysiwygs.length; i++) {
			we_wysiwygs[i].hasFocus = false;
		}
		this.hasFocus = true;

	} catch(e) {
		// Nothing
	}
}


function weWysiwyg_replaceText(txt){
	this.getSelection();
	if(isGecko){
		this.buffer.innerHTML = txt;
		var bufferRange = document.createRange();
		bufferRange.selectNodeContents(this.buffer );
		var elem =bufferRange.extractContents();
		this.insertContent(elem,true);
	}else{
		document.frames(this.fName).focus();
		document.frames(this.fName).document.selection.createRange().pasteHTML(txt);
	}
}


function weWysiwyg_getParentElementFromRange(){
	var obj = null;

	this.getSelection();

	if(isGecko){
		if (this.range) {
			var frag = this.range.cloneContents();
			var span = this.eDocument.createElement('SPAN');
			
			span.appendChild(frag);
			
			var firstChild = weGetFirstRealChildNode(span);
			var lastChild = weGetLastRealChildNode(span);
			
			
			
			obj = this.range.commonAncestorContainer;
			if (obj.nodeName == "#text") 
				obj = obj.parentNode;
		}


	}else{
		if(this.selection.type=="Control"){
			obj = this.range(0);
		}else{
			obj = this.range.parentElement();
		}
	}
	return obj;
}


function weWysiwyg_getNodeUnderInsertionPoint(nName,tdstop,mustHaveClass){
	var obj = this.getParentElementFromRange();

	while (obj && obj.nodeName != 'BODY'){
		if(((obj.nodeName == "TD" || obj.nodeName == "TH") && tdstop == true)
			|| ((obj.nodeName == "P"
				|| obj.nodeName == "DIV"
				|| obj.nodeName == "H1"
				|| obj.nodeName == "H2"
				|| obj.nodeName == "H3"
				|| obj.nodeName == "H4"
				|| obj.nodeName == "H5"
				|| obj.nodeName == "H6"
				|| obj.nodeName == "ADDR"
				|| obj.nodeName == "PRE") && nName!="TABLE" && nName!="TD" && nName!="TH" && nName!="TR" && nName!="TBODY")){
				if(obj.nodeName == nName && ((mustHaveClass && obj.className != "") || (!mustHaveClass))){
					return obj;
				}else{
					return null;
				}
		}
		if(obj.nodeName == nName && ((mustHaveClass && obj.className != "") || (!mustHaveClass))){
			return obj;
		}
		obj = obj.parentNode;
	}
	return null;
}

function weWysiwyg_getNodeUnderInsertionPoint2(nName,tdstop,mustHaveClass){  // use this to check more Nodes => slower

	var nNames = nName.split(/,/);

	var obj = this.getParentElementFromRange();

	while (obj && obj.nodeName != 'BODY'){
		if(((obj.nodeName == "TD" || obj.nodeName == "TH") && tdstop == true)
			|| ((obj.nodeName == "P"
				|| obj.nodeName == "DIV"
				|| obj.nodeName == "H1"
				|| obj.nodeName == "H2"
				|| obj.nodeName == "H3"
				|| obj.nodeName == "H4"
				|| obj.nodeName == "H5"
				|| obj.nodeName == "H6"
				|| obj.nodeName == "ADDR"
				|| obj.nodeName == "PRE") && (!weWysiwygInArray("TABLE", nNames)) && (!weWysiwygInArray("TD", nNames)) && (!weWysiwygInArray("TH", nNames)) && (!weWysiwygInArray("TR", nNames)) && (!weWysiwygInArray("TBODY", nNames)))){
				if(weWysiwygInArray(obj.nodeName, nNames) && ((mustHaveClass && obj.className != "") || (!mustHaveClass))){
					return obj;
				}else{
					return null;
				}
		}
		if(weWysiwygInArray(obj.nodeName, nNames) && ((mustHaveClass && obj.className != "") || (!mustHaveClass))){
			return obj;
		}
		obj = obj.parentNode;
	}
	return null;
}

function weWysiwyg_getImage(){
	this.getSelection();
	if(isGecko){
		if (this.range) {
			var frag = this.range.cloneContents();
			if (frag.firstChild && frag.firstChild.nodeName == "IMG") {
				return frag.firstChild;
			}
		}
	}else{
		return this.getNodeUnderInsertionPoint("IMG",true,false);
	}
	return null;
}

function weWysiwyg_getRule(){
	this.getSelection();
	if(isGecko){
		var frag = this.range.cloneContents();
		if(frag.firstChild && frag.firstChild.nodeName=="HR"){
			return frag.firstChild;
		}
	}else{
		return this.getNodeUnderInsertionPoint("HR",true,false);
	}
	return null;
}

function weWysiwyg_writeHTMLDocument(){
	if(this.fullScreenRef){
		eval("var eobj = top.opener.weWysiwygObject_"+this.fullScreenRef);
		this.editHTML = eobj.getEditHTML();
	}

	var parentRef = null;
	var normal = false;
	if(top.weEditorFrameController && top.weEditorFrameController.getVisibleEditorFrame()){  // inline
		if (top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_" + this.hiddenName)) {
			parentRef = top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_" + this.hiddenName);
			we_parentRef = parentRef;
		}
	} else if(top.opener && top.opener.top.weEditorFrameController && top.opener.top.weEditorFrameController.getVisibleEditorFrame()){  // inline
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

	if(	parentRef ){
		var all = weGetParentStyles(parentRef,we_styleSheets,this.className);
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
	//bodystyle = bodystyle.replace(/text\-align[^;]+;?/gi,"");
	bodyclass = this.className ? this.className : "";
	bodystyle = bodystyle.replace(/^(.+);$/,"$1");
	this.eDocument.write('<html><head>');
	this.eDocument.write('<base href="'+this.baseUrl+'">');
	this.eDocument.write('<title></title><meta http-equiv=Content-Type content=\'text/html;'+(this.charset ? ' charset=' + this.charset : ' charset=iso-8859-1')+'\'>');
	this.eDocument.write('<style type="text/css">'+we_styleString+'</style>');
	this.eDocument.write('</head>');
	this.eDocument.write('<body '+(bodystyle ? (' style="'+bodystyle+'"') : '') + ' topMargin="2" leftMargin="2" rightMargin="2" bottomMargin="2"'+(bodyclass ? ' class="'+bodyclass+'"' : '')+(this.bgcolor ? ' bgcolor="'+this.bgcolor+'"' : '')+'>');
	this.eDocument.write('</body></html>');
	this.eDocument.close();
}

function weWysiwyg_start(){
	this.buffer = document.getElementById(this.fName+"_buffer");
	if(isGecko){
		this.geckoStart();
	}else{
		this.IEStart();
	}
	eval('we_addEvent(this.eDocument.body, "contextmenu", '+this.fName+'ShowContextMenu);');
	eval('we_addEvent(this.eDocument, "mouseup", '+this.fName+'onmouseup);');
	if(this.fullScreenRef){
		eval("var eobj = top.opener.weWysiwygObject_"+this.fullScreenRef);
		if(eobj.sourceMode){
			this.toggleSourceCode();
		}
	}
	var fr = document.getElementById(this.fName);
	if(isGecko){
		setTimeout(this.obj+'.timeout()', 1000);
		this.eDocument.defaultView.stop(); // stops eDocument from loading important for spinning wheel => #977

	}
}

function we_wysiwyg_sendToEditor(html){
	/*
	html = html.replace(/<(\/?)ABBR/g,"<$1ACRONYM");
	html = html.replace(/<(\/?)abbr/g,"<$1acronym");
	*/
	return html;
}

function we_wysiwyg_finalize(){
	this.eDocument.body.innerHTML = this.sendToEditor(this.editHTML);
	if (!isGecko) { // IE Workarround Mantis Bug # 1257
		var merk = this.showBorders;
		this.showBorders = true;
		this.toggleBorders();
		this.showBorders = merk;
	}
	this.editHTML = this.getEditHTML();
	if (isGecko) {
		try {
			this.eDocument.designMode = "on";
		} 
		catch (e) {
		
		}
	}
	this.showBorders = false;
	this.toggleBorders();
}

function weWysiwyg_timeout(){
	if(isGecko){
		if(this.hasFocus){
			this.setButtonsState();
		}
		setTimeout(this.obj+'.timeout()', 1000);
	}
}

function weWysiwyg_geckoStart(){
	this.eFrame = document.getElementById(this.fName);
	this.eDocument = this.eFrame.contentDocument;
	this.eWindow = this.eFrame.contentWindow;
	this.writeHTMLDocument();
	document.getElementById(this.hiddenName).value = this.hiddenHTML;
	eval('we_addEvent(this.eDocument, "keyup", '+this.fName+'onkeyup);');
}

function weWysiwyg_IEStart(){
	this.eFrame = frames[this.fName];
	this.eDocument = this.eFrame.document;
	this.eWindow = this.eFrame;
	this.eDocument.designMode = 'on';
	this.writeHTMLDocument();
	document.getElementById(this.hiddenName).value = this.hiddenHTML;
	eval('we_addEvent(this.eDocument, "keyup", '+this.fName+'onkeyup);');
	eval('we_addEvent(this.eDocument, "keydown", '+this.fName+'onkeydown);');
	eval('we_addEvent(this.eFrame, "focus", '+this.fName+'onfocus);');
	eval('we_addEvent(this.eFrame, "blur", '+this.fName+'onblur);');
}



function weWysiwyg_getButton(cmd){
	return this.buttons[cmd];
}
function weWysiwyg_getSelectedText(){
	this.getSelection();
	if(isGecko){
		return this.range ? this.range.toString() : "";
	}else{
		return this.range.text ? this.range.text : "";
	}
}

function weWysiwyg_doStyleIE(className){
    var elem = this.getParentElementFromRange();
	if (elem.nodeName == 'CAPTION') {
		if (className) {
			elem.className = className;
		} else {
			elem.removeAttribute("className");
		}
		return;
	}
	if(this.selection.type == "Control"){
		elem = this.range(0);
		if(elem.nodeName.toUpperCase() == "TABLE"){
			if(className.length > 0){
				elem.className = className;
			}else{
				elem.removeAttribute("className");
			}
		}
		return;
	}else if(this.getSelectedText().length == 0){
		top.we_showMessage(we_wysiwyg_lng["nothing_selected"], WE_MESSAGE_ERROR, window);
		return;
	}

	var parentElem = this.range.parentElement();
	var parentHTML = parentElem.outerHTML.replace(/[\r\n]/gi,"");
	var rangeHTML = this.range.htmlText.replace(/[\r\n]/gi,"");
	var bodyHTML = this.eDocument.body.innerHTML.replace(/[\r\n]/gi,"");

	if(parentHTML != rangeHTML && bodyHTML != rangeHTML){
		this.range.pasteHTML(weParseStyles(rangeHTML,className));
	}else if(bodyHTML == rangeHTML){
		this.eDocument.body.innerHTML = weParseStyles(rangeHTML,className);
	}else{
		this.range.pasteHTML(weParseStyles(rangeHTML,""));
		if(className.length > 0){
			parentElem.setAttribute("className",className);
		}else{
			parentElem.removeAttribute("className");
			if(parentElem.outerHTML.toUpperCase().substring(0,6) == "<SPAN>")
			parentElem.removeNode(false);
		}
	}
}
function weWysiwyg_doStyleGecko(className){
	var _elem = this.getParentElementFromRange();

	if(this.getSelectedText().length == 0 && (_elem==null || _elem.nodeName != 'CAPTION')){
		top.we_showMessage(we_wysiwyg_lng["nothing_selected"], WE_MESSAGE_ERROR, window);
		return;
	}

	if (_elem.nodeName == 'CAPTION') {
		if (className) {
			_elem.className = className;
		} else {
			_elem.removeAttribute('class');
		}
		return;
	}
	var stCont = we_getMozillaParentElement(this.range);
	var endCont = we_getMozillaParentElement(this.range,true);

	if((stCont.nodeName.toUpperCase() == "LI" || endCont.nodeName.toUpperCase() == "LI") && (stCont.nodeName.toUpperCase() != endCont.nodeName.toUpperCase())){
		top.we_showMessage(we_wysiwyg_lng["selection_invalid"], WE_MESSAGE_ERROR, window);
		return;
	}
	if(className && className.length && className.substring(0,1) == "."){
		className = className.substring(1,className.length);
	}
	if(stCont==endCont && stCont.nodeName.toUpperCase()=="SPAN"){
		var parTxt = stCont.innerHTML.replace(/<[^>]+>/g,"");
		parTxt = parTxt.replace(/\n/,"");
		parTxt = parTxt.replace(/\r/,"");
		var rangeTxt = this.range.toString();
		rangeTxt = rangeTxt.replace(/\n/,"");
		rangeTxt = rangeTxt.replace(/\r/,"");
		if(rangeTxt == parTxt){
			this.range.selectNode(stCont);
		}
	}
	if(stCont==endCont && stCont.nodeName.toUpperCase()=="TR"){
		if(stCont.hasChildNodes()){
			var foo = stCont.childNodes[this.range.startOffset];
			if(foo){
				this.range.selectNodeContents(foo);
			}
		}
	}
	var frag;

	if(this.range.commonAncestorContainer.nodeName.toUpperCase() == "UL" || this.range.commonAncestorContainer.nodeName.toUpperCase() == "OL"){
		this.range.selectNode(this.range.commonAncestorContainer);
	}
	frag = this.range.extractContents();
	var span = this.eDocument.createElement('SPAN');
	span.appendChild(frag);
	we_deleteStyleNodes(span);
	if(className.length > 0){
		if(span.hasChildNodes() && span.firstChild.nodeName.toUpperCase()=="SPAN"){
			span.firstChild.setAttribute("class",className);
		}else{
			span.setAttribute("class",className);
		}
		if(span.hasChildNodes() && span.firstChild.nodeName.toUpperCase()=="SPAN"){
			span = span.firstChild;
		}
	}else{
		var bufferRange = this.eDocument.createRange();
		bufferRange.selectNodeContents(span);
		span=bufferRange.extractContents();
	}

	var newNode = this.insertContent(span,false);
}

function weWysiwyg_doStyle(className){
	this.getSelection();
	if(className && className.length && className.substring(0,1) == "."){
		className = className.substring(1,className.length);
	}
	if(isGecko){
		this.doStyleGecko(className);
	}else{
		this.doStyleIE(className);
	}
   	this.windowFocus();
}

function weWysiwyg_insertContent(content, doNoCollapse) {
    var StartContainer = this.range.startContainer;
    var StartPosition = this.range.startOffset;

	this.selection.removeAllRanges();
	try {
		this.range.deleteContents();
	} catch(e) {}


    var startOffBefore = this.range.startOffset;

    if (StartContainer.nodeType==StartContainer.TEXT_NODE && content.nodeType==content.TEXT_NODE) {
        StartContainer.insertData(StartPosition, content.nodeValue );
        if (startOffBefore == range.startOffset) {
            this.range.setEnd(BX_range.endContainer, this.range.endOffset +1);
            this.range.collapse(false);
        }
    } else {

        this.range.we_insertNode = we_InsertNodeAtRange;
        content.normalize();
        try {
            this.range.we_insertNode(content);
        } catch(e) {}
        ;

        if (startOffBefore ==this.range.startOffset) {
            try { this.range.setEnd(this.range.endContainer, this.range.endOffset +1);}
			catch(e) {};
        }

        if (!doNoCollapse) {
            this.range.collapse(false);
        }
    }
    this.selection.addRange(this.range);
    return content;
}

function weWysiwyg_hasCmd(cmd){
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
		default:
			return  this.propString.length == 0 || (this.propString.indexOf(","+cmd+",") > -1);
	}
}


function weWysiwyg_showContextMenu(event){

	we_GeneralContextMenu[0] = new we_ContextMenuItem(we_wysiwyg_lng["cut"], "cut");
	we_GeneralContextMenu[1] = new we_ContextMenuItem(we_wysiwyg_lng["copy"], "copy");
	we_GeneralContextMenu[2] = new we_ContextMenuItem(we_wysiwyg_lng["paste"], "paste");
	
	we_TableContextMenu[0] = new we_ContextMenuItem(we_wysiwyg_lng["edittable"]+"...", "edittable");
	we_TableContextMenu[1] = new we_ContextMenuItem(we_wysiwyg_lng["editcell"]+"...", "editcell");
	we_TableContextMenu[2] = new we_ContextMenuItem("", "");
	we_TableContextMenu[3] = new we_ContextMenuItem(we_wysiwyg_lng["insertcolumnright"], "insertcolumnright");
	we_TableContextMenu[4] = new we_ContextMenuItem(we_wysiwyg_lng["insertcolumnleft"], "insertcolumnleft");
	we_TableContextMenu[5] = new we_ContextMenuItem("", "");
	we_TableContextMenu[6] = new we_ContextMenuItem(we_wysiwyg_lng["insertrowabove"], "insertrowabove");
	we_TableContextMenu[7] = new we_ContextMenuItem(we_wysiwyg_lng["insertrowbelow"], "insertrowbelow");
	we_TableContextMenu[8] = new we_ContextMenuItem("", "");
	we_TableContextMenu[9] = new we_ContextMenuItem(we_wysiwyg_lng["deleterow"], "deleterow");
	we_TableContextMenu[10] = new we_ContextMenuItem(we_wysiwyg_lng["deletecol"], "deletecol");
	we_TableContextMenu[11] = new we_ContextMenuItem("", "");
	we_TableContextMenu[12] = new we_ContextMenuItem(we_wysiwyg_lng["increasecolspan"], "increasecolspan");
	we_TableContextMenu[13] = new we_ContextMenuItem(we_wysiwyg_lng["decreasecolspan"], "decreasecolspan");

	we_lastEditor = this;
	editor = frames[this.fName];
	if(isGecko){
		if(we_oPopup == null){
			we_oPopup = new wePopUpFrame();
		}
		we_oPopup.document.getElementsByTagName("HEAD")[0].style.innerHTML = '';
	}else{
		we_oPopup = editor.createPopup();
	}
	we_oPopupBody = we_oPopup.document.body;
	we_oPopupBody.style.backgroundImage = "url("+document.location.protocol+"//"+document.location.hostname+weWysiwygBgGifPath+")";
	we_oPopupBody.style.border = "outset 2px";
	we_oPopupBody.style.fontFamily = "Verdana,Arial,Helvetica"
	we_oPopupBody.style.fontSize = "11px";

	var menuStrings = new Array();
	var menuStates = new Array();
	var z = 0;

	we_ContextMenu = new Array();
	we_contextCount = 0;

	for(var i=0; i< we_GeneralContextMenu.length; i++){
		we_ContextMenu[z++] = we_GeneralContextMenu[i];
	}

	if(this.hasCmd("createlink") || this.hasCmd("insertimage") || this.hasCmd("inserthorizontalrule")  || this.hasCmd("insertspecialchar")){
		we_ContextMenu[z++] = new we_ContextMenuItem("","");
	}

	if(this.hasCmd("createlink")){
		var link = this.getNodeUnderInsertionPoint("A",true,false);
		we_ContextMenu[z++] = new we_ContextMenuItem(we_wysiwyg_lng[((link==null) ? "insert_hyperlink" : "edit_hyperlink")] + "...","createlink");
	}
	if(this.hasCmd("insertimage")){
		var image = this.getImage();
		we_ContextMenu[z++] = new we_ContextMenuItem(we_wysiwyg_lng[((image==null) ? "insert_image" : "edit_image")] + "...","insertimage");
	}
	if(this.hasCmd("inserthorizontalrule")){
		we_ContextMenu[z++] = new we_ContextMenuItem(we_wysiwyg_lng["inserthorizontalrule"] + "...","inserthorizontalrule");
	}
	if(this.hasCmd("insertspecialchar")){
		we_ContextMenu[z++] = new we_ContextMenuItem(we_wysiwyg_lng["insertspecialchar"] + "...","insertspecialchar");
	}
	if(this.hasCmd("edittable") || this.hasCmd("inserttable")){
		we_ContextMenu[z++] = new we_ContextMenuItem("","");
	}
	if(this.hasCmd("inserttable")){
		we_ContextMenu[z++] = new we_ContextMenuItem(we_wysiwyg_lng["insert_table"] + "...","inserttable");
	}
	if(this.hasCmd("edittable")){
		var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
		if(table != null){
			for(var i=0; i< we_TableContextMenu.length; i++){
				we_ContextMenu[z++] = we_TableContextMenu[i];
			}
		}
	}

	for(var i=0; i< we_ContextMenu.length; i++){
		var cmd = we_ContextMenu[i].cmdId;
		var enabled = true;
		if(isGecko){
			try {
				enabled = this.eDocument.queryCommandEnabled(cmd);
			}catch (e) {}
		}else{
			if(cmd && weWysiwygInArray(cmd,this.highlightButtons)) enabled = this.eDocument.queryCommandEnabled(cmd);
		}

		we_addContextItem(we_ContextMenu[i].string, (!enabled));
	}

	if(isGecko){
		var h = (we_contextCount * 21) + 5;
		var ifrpos = we_getElemPos(document.getElementById(this.fName));
		var x = event.clientX + ifrpos.x;
		var y = event.clientY + ifrpos.y;
		if((x+240) > (window.innerWidth+window.scrollX)){
			x = (window.innerWidth+window.scrollX) - (240 + 5);
			if ((x - window.scrollX) < 0) x = window.scrollX;
		}
		if((y+h) > (window.innerHeight+window.scrollY)){
			y = (window.innerHeight+window.scrollY) - (h + 5);
			if (y < 0) y = 0;
			if ((y - window.scrollY) < 0) y = window.scrollY;
		}
		we_stopEvent(event);
		we_oPopup.show(x,y,240,h,editor.document.body);
		this.eDocument.addEventListener("mousedown",we_docClick,true);
		document.addEventListener("mousedown",we_docClick,true);
		this.eDocument.addEventListener("keypress",we_keyPress,true);
		document.addEventListener("keypress",we_keyPress,true);
	}else{
		var h = (we_contextCount * 17) + 5;
		we_oPopup.show(event.clientX+2,event.clientY+2,240,h,editor.document.body);
	}
	return false;
}

function weWysiwyg_windowFocus(){
	this.eWindow.focus();
}


function weWysiwyg_getSelection() {
	if(isGecko){
		this.eFrame = document.getElementById(this.fName);
		this.eDocument = this.eFrame.contentDocument;
		this.eWindow = this.eFrame.contentWindow;
		this.selection = this.eWindow.getSelection();
		this.range = this.selection ? this.selection.getRangeAt(0) : null;
	}else{
		this.eFrame = frames[this.fName];
		this.eDocument = this.eFrame.document;
    	this.selection = frames[this.fName].document.selection;
    	this.range = frames[this.fName].document.selection.createRange();
    }
}

function weWysiwyg_setButtonState(cmd){
	if(this.hasCmd(cmd)){
		var enabled = true;
		if(isGecko){
			try {
				enabled = this.eDocument.queryCommandEnabled(cmd);
			}catch (e) {}
		}else{
			enabled = this.eDocument.queryCommandEnabled(cmd);
		}
		if(enabled){
			this.buttons[cmd].enable();
			var flag = false;
			if(isGecko){
				try {
					flag = this.eDocument.queryCommandState(cmd);
				}catch (e) {}
			}else{
				flag = this.eDocument.queryCommandState(cmd);
			}
			if(flag && (!this.buttons[cmd].checked)){
				this.buttons[cmd].check();
			}else if((!flag) && this.buttons[cmd].checked){
				this.buttons[cmd].uncheck();
			}
		}else{
			this.buttons[cmd].disable();
		}
	}
}

function weWysiwyg_getLangSpan(){
	var obj = this.getParentElementFromRange();
	while (obj && obj.nodeName != 'BODY'){
		if((obj.nodeName == "TD" || obj.nodeName == "TH")
			|| (obj.nodeName == "P"
				|| obj.nodeName == "DIV"
				|| obj.nodeName == "H1"
				|| obj.nodeName == "H2"
				|| obj.nodeName == "H3"
				|| obj.nodeName == "H4"
				|| obj.nodeName == "H5"
				|| obj.nodeName == "H6"
				|| obj.nodeName == "ADDR"
				|| obj.nodeName == "PRE")){
				return null;
		}
		if(obj.nodeName == "SPAN" && obj.lang){
			return obj;
		}
		obj = obj.parentNode;
	}
	return null;
}

function weWysiwyg_setButtonsState(){
	if(!this.sourceMode){
		for(var i=0;i<this.highlightButtons.length;i++){
			this.setButtonState(this.highlightButtons[i]);
		}
		var image = this.getImage();
		var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
		var link = this.getNodeUnderInsertionPoint("A",true,false);
		var acronym = this.getNodeUnderInsertionPoint("ACRONYM",true,false);
		var abbr = this.getNodeUnderInsertionPoint("ABBR",true,false);
		var langspan = this.getLangSpan();
		var length = this.getSelectedText().length;
		if(table != null){
			var capts = table.getElementsByTagName("CAPTION");
			if(capts.length){
				this.buttons["caption"].disable();
				this.buttons["removecaption"].enable();
			}else{
				this.buttons["caption"].enable();
				this.buttons["removecaption"].disable();
			}
			this.buttons["edittable"].enable();
			var td = this.getNodeUnderInsertionPoint2("TD,TH",false,false);
			if(td){
				for(var i=0; i<this.editTableButtons.length;i++){
					this.buttons[this.editTableButtons[i]].enable();
				}
			}else{
				for(var i=0; i<this.editTableButtons.length;i++){
					this.buttons[this.editTableButtons[i]].disable();
				}
			}
		}else{
			this.buttons["caption"].disable();
			this.buttons["removecaption"].disable();
			this.buttons["edittable"].disable();
			for(var i=0; i<this.editTableButtons.length;i++){
				this.buttons[this.editTableButtons[i]].disable();
			}
		}

		if((link != null && we_hasAttribute(link,"href")) || length > 0 || image != null){
			this.buttons["createlink"].enable();
		}else{
			this.buttons["createlink"].disable();
		}

		if((link != null && we_hasAttribute(link,"href"))){
			this.buttons["unlink"].enable();
		}else{
			this.buttons["unlink"].disable();
		}

		if(acronym != null || length > 0){
			this.buttons["acronym"].enable();
		}else{
			this.buttons["acronym"].disable();
		}
		if(acronym == null){
			this.buttons["acronym"].uncheck();
		}else{
			this.buttons["acronym"].check();
		}

		if(abbr != null || length > 0){
			this.buttons["abbr"].enable();
		}else{
			this.buttons["abbr"].disable();
		}
		if(abbr == null){
			this.buttons["abbr"].uncheck();
		}else{
			this.buttons["abbr"].check();
		}

		if(langspan != null || length > 0){
			this.buttons["lang"].enable();
		}else{
			this.buttons["lang"].disable();
		}
		if(langspan == null){
			this.buttons["lang"].uncheck();
		}else{
			this.buttons["lang"].check();
		}


		if(this.showBorders && (!this.buttons["visibleborders"].checked)){
			this.buttons["visibleborders"].check();
		}else if((!this.showBorders) && this.buttons["visibleborders"].checked){
			this.buttons["visibleborders"].uncheck();
		}

		this.setMenuState("fontname");
		this.setMenuState("fontsize");
		this.setMenuState("formatblock");
		this.setMenuState("applystyle");
	}
}

function weWysiwyg_setMenuState(cmd){
	if(this.hasCmd(cmd)){
		var enabled = true;
		if(cmd == "applystyle"){
			if (this.range) {
				var _elem = this.getParentElementFromRange();
				enabled = this.getSelectedText().length > 0 || _elem.nodeName == 'CAPTION';
			} else {
				enabled = false;
			}
		}else{
			if(isGecko){
				try {
					enabled = this.eDocument.queryCommandEnabled(cmd);
				}catch (e) {}
			}else{
				enabled = this.eDocument.queryCommandEnabled(cmd);
			}
		}
		if(enabled){
			this.menus[cmd.toLowerCase()].enable();
		}else{
			this.menus[cmd.toLowerCase()].disable();
		}
		if(isGecko){
			// IE disables the undo cmd when changing the value of the select boxes
			// have I said that i hate internet explorer?
			var newval = "";
			if(cmd == "applystyle"){
					var span_node = this.getNodeUnderInsertionPoint("SPAN",true,true);
					if(span_node){
						if(span_node.className){
							newval = span_node.className;
						}
					} else {
						var _elem = this.getParentElementFromRange();
						if (_elem && _elem.nodeName == 'CAPTION') {
							newval = _elem.className;
						}

					}
			}else{
				try {
					newval = this.eDocument.queryCommandValue(cmd);
				} catch (e) {

				}
			}
			var oldval = this.menus[cmd.toLowerCase()].getValue();
			if(newval){
				if (oldval != newval) {
					switch(cmd){
						case "fontname":
							newval = newval.toLowerCase();
							newval = newval.replace(/,([^ ])/gi,", $1");
							break;
						case "formatblock":
							if(isGecko){
								newval = wePopupMenuArray[this.name][cmd][newval];
							}
							break;
					}
					if(newval && newval != "undefined" && newval != undefined){
						this.menus[cmd.toLowerCase()].setValue(newval);
					}else{
						this.menus[cmd.toLowerCase()].setValue(we_wysiwyg_lng[cmd]);
					}
				}
			}else{
				this.menus[cmd.toLowerCase()].setValue(we_wysiwyg_lng[cmd]);
			}
		}
	}
}


function weWysiwyg_getHTML(){
	this.pre = false;
	var out = "";
	//document.forms[0].debug.value="";
	this.nodeDone = null;
	if(this.xml){
		this.eDocument.body.innerHTML = this.cleanCode(this.eDocument.body.innerHTML); //.replace(/\&nbsp;/gi,"<!-- ###WE_NBSP### -->");
		out =  this.getHTMLCode(this.eDocument.body,false);
		//out = out.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;");
		if(!isGecko){
			out = out.replace(/<\!><\/\!>/gi, "&nbsp;");  // IE 55 Fix
			out = this.cleanCode(out);
		}
		for(var i=0;i<weWysiwyg_translationTable.length;i++){
			out = out.replace(new RegExp(String.fromCharCode(weWysiwyg_translationTable[i]),"g"),("&#"+weWysiwyg_translationTable[i]+";"));
		}
	} else {
		out = this.cleanCode(this.eDocument.body.innerHTML);

	}
	return out.trim();
}

function weWysiwyg_getHTMLCode(rootNode, outputRootNode){

	//document.forms[0].debug.value += "type:"+rootNode.nodeName+"\n\n";


	var html = "";
	switch (rootNode.nodeType) {
	    case 1: // element
	    case 11: // document fragment
	    		//document.forms[0].debug.value += "Inner:"+rootNode.innerHTML+"\n\n";
			var closed;
			var i;
			var root_tag = (rootNode.nodeType == 1) ? rootNode.tagName.toLowerCase() : '';

			if(root_tag == "pre"){
				this.pre = true;
			}
			if(this.pre && root_tag == "br"){
				html += "\n";
				break;
			}
			if (rootNode.nodeName == "/EMBED") { // IE BUG
				break;
			}
			if (outputRootNode) {
				closed = (!(rootNode.hasChildNodes() || (this.emptyTags.indexOf(" " + root_tag + " ") == -1)));
				html += "<" + rootNode.tagName.toLowerCase();
				var attrs = rootNode.attributes;
				for(i = 0; i < attrs.length; ++i){
					var a = attrs.item(i);
					var name=a.nodeName.toLowerCase();
					if(root_tag == "area" && a.nodeValue){
						// do nothing
					}else if (!a.specified) {
						continue;
					}
					if (/_moz|contenteditable|_msh/.test(name)) {
						continue;
					}
					var value;
					if (name != "style") {
						if(this.booleanAttributes.indexOf(" " + name + " ") > -1){
							value=name;
						}else{
							if (typeof rootNode[a.nodeName] != "undefined" && name != "href" && name != "src") {
								value = rootNode[a.nodeName];
							} else {
								value = a.nodeValue;
							}
						}
						if(name=="shape"){
							value = value.toLowerCase();
						}
						if(!isNaN(value)){
							value = rootNode.getAttribute(name);
						}
						if(!isGecko && root_tag=="img"){
							// Workarround for width & height BUG
							if(name=="width" && !value){
								var re = new RegExp("width=[\"']?([^ '\">]+)","g");
								var m = re.exec(rootNode.outerHTML);
								if(m!=null){
									value =m[1];
								}
							}else if(name=="height" && !value){
								var re = new RegExp("height=[\"']?([^ '\">]+)","g");
								var m = re.exec(rootNode.outerHTML);
								if(m!=null){
									value =m[1];
								}
							}
						}
					}else{
						if(rootNode.style.cssText.length > 1){
							value = "";
							var properties = rootNode.style.cssText.split(';');
							for (var n = 0; n < properties.length; n++) {
								if(properties[n].length > 1){
									var v = properties[n].split(':');
									if(v[1] != " null" &&
											((this.showBorders && v[1] != " 1px dotted rgb(204, 204, 204)" && v[1] != " #cccccc 1px dotted")
												|| (!this.showBorders))  && v[0].substr(0,5) != " mso-" && v[0].substr(0,4) != "mso-"){
										value += (v[0].toLowerCase() + ':');
										value += String(v[1]).replace(/\&/g, "&amp;").replace(/</g, "&lt;").replace(/\"/g, "&quot;") + ';';
									}
								}
							}
						}
					}
					if (/(_moz|^$)/.test(value) && name!="alt") {
						continue;
					}

					html += " " + name + '="' + this.encodeText(value).trim2() + '"';
				}
				html += closed ? " />" : ">";
			}
			if(this.nlAfterStartTag.indexOf(" " + root_tag + " ") > -1){
				html += "\n";
			}
			if (rootNode.nodeName.toLowerCase() == 'script') {
				html += "\n" + rootNode.innerHTML.trim() + "\n";
			} else {
				for (i = rootNode.firstChild; i; i = i.nextSibling) {
					html += this.getHTMLCode(i, true);
				}
			}
			// Ende Tag
			if (outputRootNode && !closed) {
				html += "</" + rootNode.tagName.toLowerCase() + ">";
				if(this.nlAfterEndTag.indexOf(" " + root_tag + " ") > -1){
					html += "\n";
				}
			}
			if(root_tag == "pre"){
				this.pre = false;
			}
			break;
	    case 3: // Text
	    	if(rootNode.nodeValue){
	    		//document.forms[0].debug.value += "Text:"+this.encodeText(rootNode.nodeValue)+"\n\n";

	    		if(this.nodeDone == rootNode){
	    			this.nodeDone = null;
	    			break;
	    		}
	    		if(!isGecko){
	    			this.nodeDone = rootNode;
	    		}
	    		if(rootNode.nodeValue == "\n"){
	    			break;
	    		}
				html = this.encodeText(rootNode.nodeValue).trim2();
			}
			break;
	    case 8: // Comment
			html = "<!--" + rootNode.data + "-->";
			break;
	}

	html = weCorrectListTags(html,"ul");
	html = weCorrectListTags(html,"ol");


	return html;
}

function weWysiwyg_encodeText(str) {
	str = "" + str;
	var re = new RegExp(String.fromCharCode(160),"gi");
	return str.replace(/&/ig, "&amp;").replace(/>/ig, "&gt;").replace(/</ig, "&lt;").replace(/\x22/ig, "&quot;").replace(re, "&#160;").replace(/&nbsp;/, "&#160;");
};

function weWysiwyg_cleanCode(code){
	code = this.removeHostname(code,false);
	re = /<([\w]+) class=["']?Mso([^ |>]*)([^>]*)/gi;if(code.search(re) != -1) code = code.replace(re, "<$1$3")
	re = /<\\?\??xml[^>]*>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	re = /<\?xml[^>]*>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	re = /<\/?\w+:[^>]*>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	re = /<p([^>])*>(&nbsp;)*\s*<\/p>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	re = /<div([^>])*>(&nbsp;)*\s*<\/div>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	re = /<span([^>])*>(&nbsp;)*\s*<\/span>/gi;if(code.search(re) != -1) code = code.replace(re, "")
	if(code.indexOf('DESIGNTIMESP="') > -1){
		code = code.replace(/ DESIGNTIMESP="[^"]+"/gi,'');
	}
	if(code.indexOf('DESIGNTIMEURL="') > -1){
		code = code.replace(/ DESIGNTIMEURL="[^"]+"/gi,'');
	}
	code = code.replace(/ style="margin:[^"]+"/gi,"");
	code = code.replace(/ style="mso-[^"]+"/gi,"");
	//code = code.replace(/td style="[^"]+"/gi,"td");

	code = code.replace(/ ?BORDER-BOTTOM: medium none;?/gi,"");
	code = code.replace(/ ?BORDER-LEFT: medium none;?/gi,"");
	code = code.replace(/ ?BORDER-TOP: medium none;?/gi,"");
	code = code.replace(/ ?BORDER-RIGHT: medium none;?/gi,"");
	code = code.replace(/style=" +/gi,"style=\"");
	
	
	if(this.removeFirstParagraph && code.substring(0,3).toUpperCase() == '<P>'){
		code = code.substring(3,code.length);
		code = weRemoveAlloneEndtags(code,"P")
	}
	if(isGecko){
		code = code.replace(/border: 1px dotted rgb\(204, 204, 204\);/gi, "");
		code = code.replace(/ ?style=['"]["']/gi, "");
		code = code.replace(/<(a)( name="[^"]+")( style="[^"]+")>/gi, "<$1$2>");
		code = this.cleanAnchor(code);
		code = this.decodeUmlautDomain(code);
	}else{
		code = code.replace(/border-[^:]+: #cccccc 1px dotted;? ?/gi, "");
		code = code.replace(/ ?style=['"]["']/gi, "");
		code = code.replace(/<(a)( style="[^"]+")( name=[^>]+)/gi, "<$1$3");
		code = this.cleanAnchor(code);
	}
	var re = new RegExp("(<a href=\")/webEdition[^\"']*/([^\"']+)","gi");
	code = code.replace(re,"$1$2");
	var re = new RegExp("(<a href=\")we_cmd.php[^#\"']+(#[^\"']*)","gi");
	code = code.replace(re,"$1$2");
	var re = new RegExp("(<img src=\")/webEdition[^\"']*/([^\"']+)","gi");
	code = code.replace(re,"$1$2");
	code = code.replace(/^<br>\n$/,"");
	code = code.replace(/^<br>\r$/,"");
	code = code.replace(/^<br>\r\n$/,"");
	code = code.replace(/^<br>$/,"");
	return code;
}


function weWysiwyg_decodeDomainUmlautsOfUrl(url) {
	var regex = /(http:\/\/)([^\?\/]+)([\?\/]?.*)/gi;
	var found = regex.exec(url);
	if (found==null) found = regex.exec(url);

	if (found) {
		var hostname = found[2];
		return found[1] + decodeURIComponent(found[2]) + found[3];
	}
	return url;
	
}


function weWysiwyg_decodeUmlautDomain(code) {
	// correct umlauts und co (IDN Domains)
	var regex = /(<[^>]+=[\'"]?http:\/\/)([^"\'\/\?]*%{1,2}[^"\'\/\?]*)(["\'\/\?]?)/gi;
	var found = regex.exec(code);
	while(found){
		try {
			code = code.replace(regex, found[1] + decodeURIComponent(found[2]) + found[3]);
		} catch (e) {
			break;
		}
		found = regex.exec(code);
	}
	return code;
}

function weWysiwyg_removeHostname(code,isurl){
	var hostname = this.location.hostname;
	var protocol = this.location.protocol;
	var port = this.location.port;
	if(isurl){
		var re = new RegExp(protocol+"//"+hostname+(port ? ":"+port : "")+"/","gi");
		code = code.replace(re,"/");
	}else{
		var re = new RegExp("(['\"]?)"+protocol+"//"+hostname+(port ? ":"+port : "")+this.path+"#","gi");
		code = code.replace(re,"$1#");
		var re = new RegExp("(=['\"]?)"+protocol+"//"+hostname+(port ? ":"+port : "")+"/","gi");
		code = code.replace(re,"$1/");
	}
	return code;

}

function weWysiwyg_cleanAnchor(code){
	var loc = this.fullScreenRef ? top.opener.document.location+""  : document.location+"";
	loc = loc.replace(/\//g,"\\/");
	loc = loc.replace(/\?/,"\\?");
	var re = new RegExp(loc+"(#[^>]*)","gi");
	code = code.replace(re,"$1");
	return code;
}

function weWysiwyg_setHiddenText(){
	var sb = this.showBorders;
	if(sb && (!this.sourceMode)){
		this.toggleBorders();
	}
	if(!this.fullScreenRef){
		var c1 = this.editHTML;
		c1 = c1.replace(/\n/gi,"");
		c1 = c1.replace(/\r/gi,"");
		var c2 = this.getEditHTML();
		c2 = c2.replace(/\n/gi,"");
		c2 = c2.replace(/\r/gi,"");
		if(c2=="<br>") c2="";
		//if(c1.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;") != c2.replace(/<\!-- ###WE_NBSP### -->/gi, "&nbsp;")){
		c1 = c1.replace(/<br ?\/?>[\n\r ]*<\/td/gi,"</td");
		c2 = c2.replace(/<br ?\/?>[\n\r ]*<\/td/gi,"</td");
		if(c1 != c2){
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
	if(sb && (!this.sourceMode)){
		this.toggleBorders();
	}
}

function weWysiwyg_setText(txt){
	if(this.sourceMode){
		var ta = document.getElementById(this.fName+"_src");
		ta.value = txt;
	}else{
		this.eDocument.body.innerHTML = this.sendToEditor(txt);
		this.windowFocus();
	}
}
function weWysiwyg_getEditHTML(){
	if(this.sourceMode){
		var ta = document.getElementById(this.fName+"_src");
		return ta.value;
	}else{
		return this.getHTML();
	}
}
function weWysiwyg_click(cmd){
	this.buttons[cmd].click();
}

function weWysiwyg_out(cmd){
	this.buttons[cmd].out();
}

function weWysiwyg_over(cmd){
	this.buttons[cmd].over();
}
function weWysiwyg_check(cmd){
	this.buttons[cmd].check();
}

function weWysiwyg_uncheck(cmd){
	this.buttons[cmd].uncheck();
}

function weWysiwyg_setPopupmenu(cmd,val){
	this.menus[cmd].execCommand(unescape(val));
}

function weWysiwyg_showPopupmenu(cmd){
	if(weLastPopupMenu != null){
		weLastPopupMenu.hide();
	}
	var ifr = document.getElementById(this.name+"_"+cmd);
	weLastPopupMenu = new wePopUpFrame(ifr);
	weLastPopupMenu._iframe.style.backgroundImage = "url("+document.location.protocol+"//"+document.location.hostname+(document.location.port ? ":"+document.location.port : "")+weWysiwygBgGifPath+")";
	weLastPopupMenu._iframe.style.border = "1px solid #A5ACB2";
	weLastPopupMenu.document.body.style.fontFamily = "Verdana,Arial,Helvetica";
	weLastPopupMenu.document.body.innerHTML = isGecko ? '<style type="text/css">'+we_styleString+'</style>' : "";
	switch(cmd){
		case "formatblock":
			for(var i in wePopupMenuArray[this.name][cmd]){
				var tagname = (i.toLowerCase()!="normal") ? i : 'div';
				var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\''+escape(i)+'\');"';
				weLastPopupMenu.document.body.innerHTML +='<'+tagname+' style="padding-left:10px;margin-top:8px;margin-bottom:8px;cursor:pointer;color:black;" '+popattr+' unselectable="on">' + wePopupMenuArray[this.name][cmd][i].replace(/ /,"&nbsp;") + '</'+tagname+'>';
			}
			break;
		case "fontname":
			for(var i in wePopupMenuArray[this.name][cmd]){
				var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\''+escape(i)+'\');"';
				weLastPopupMenu.document.body.innerHTML +='<div style="position:relative;border:0px;'+( (i.toLowerCase() != "wingdings") ? ('font-family:'+i+';'): "")+'padding-bottom:3px;padding-top:3px;padding-left:10px;color:black;"'+popattr+' unselectable="on">' + wePopupMenuArray[this.name][cmd][i].replace(/ /,"&nbsp;") + '</div>';
			}
			break;
		case "fontsize":
			weLastPopupMenu._iframe.style.width = "100px";
			for(var i in wePopupMenuArray[this.name][cmd]){
				var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\''+escape(i)+'\');"';
				weLastPopupMenu.document.body.innerHTML +='<div style="position:relative;border:0px;padding-bottom:3px;padding-top:3px;padding-left:10px;color:black;"'+popattr+'><font size="'+i+'" unselectable="on">' + wePopupMenuArray[this.name][cmd][i].replace(/ /,"&nbsp;") + '</font></div>';
			}
			break;
		case "applystyle":
				//weLastPopupMenu.document.body.innerHTML +='<div class="' + we_classNames[i].substring(1,we_classNames[i].length) +'" style="position:relative;border:0px;padding-bottom:3px;padding-top:3px;padding-left:10px;"'+popattr+'>' + we_classNames[i] + '</div>';

			var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\'\');"';
			weLastPopupMenu.document.body.innerHTML +='<div style="position:relative;border:0px;padding-bottom:3px;padding-top:3px;padding-left:10px;color:black;"'+popattr+' unselectable="on">' + we_wysiwyg_lng["none"] + '</div>';

			var cssArr = new Array();
			if(this.cssClasses.length){
				cssArr = this.cssClasses.split(",");
				for(var i=0; i< cssArr.length;i++){
					var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\''+escape("."+cssArr[i])+'\');"';
					weLastPopupMenu.document.body.innerHTML +='<div class="' + cssArr[i] +'" style="position:relative;left:0px;top:0px;width:100%;height:10%;border:0px;padding-bottom:3px;padding-top:3px;padding-left:10px;"'+popattr+' unselectable="on">.' + cssArr[i].replace(/ /,"&nbsp;") + '</div>';
				}
			}else{
				for(var i=0; i< we_classNames.length;i++){
					var classNameWithoutDot=we_classNames[i].substring(1,we_classNames[i].length);
					var popattr = 'onmouseover="parent.we_popupMenuOver(this)"  onmouseout="parent.we_popupMenuOut(this)" onclick="parent.we_hidePopupmenu();parent.'+this.obj+'.setPopupmenu(\''+cmd+'\',\''+escape(we_classNames[i])+'\');"';
					weLastPopupMenu.document.body.innerHTML +='<div class="' + classNameWithoutDot +'" style="position:relative;left:0px;top:0px;width:100%;height:10%;border:0px;padding-bottom:3px;padding-top:3px;padding-left:10px;"'+popattr+' unselectable="on">' + we_classNames[i].replace(/ /,"&nbsp;") + '</div>';
				}
			}
			weLastPopupMenu._iframe.style.width = "120px";

			break;
	}
	we_lastEditor = this;
	we_addEvent(this.eDocument, "mousedown",we_docClick);
	we_addEvent(document, "mousedown",we_docClick);
	we_addEvent(this.eDocument, "keypress",we_keyPress);
	we_addEvent(document, "keypress",we_keyPress);
	weLastPopupMenu.show();
}

function we_popupMenuOver(obj){
	obj.style.backgroundColor = "highlight";
}

function we_popupMenuOut(obj){
	obj.style.backgroundColor = "";
}

function we_hidePopupmenu(){
	if(weLastPopupMenu != null){
		weLastPopupMenu.hide();
		weLastPopupMenu = null;
		we_removeEvent(document, "mousedown", we_docClick);
		we_removeEvent(we_lastEditor.eDocument, "mousedown", we_docClick);
		we_removeEvent(we_lastEditor.eDocument, "keypress", we_keyPress);
		we_removeEvent(document, "keypress", we_keyPress);
	}
}

function weWysiwyg_setForecolor(color){
	this.eDocument.execCommand("forecolor",false,color)	;
}

function weWysiwyg_setBackcolor(color){
	if(isGecko){
		this.eDocument.execCommand("hilitecolor",false,color)	;
	}else{
		this.eDocument.execCommand("backcolor",false,color)	;
	}
}

function weWysiwyg_createLink(href,target,className,lang,hreflang,title,accesskey,tabindex,rel,rev){
	var link = null;
	var maillink = false;
	if(isGecko){
		link = this.getNodeUnderInsertionPoint("A",true,false);
		if(!link){
			if(href.indexOf("mailto:") != -1){
				maillink = true;
				href = href.replace(/mailto:/g,"");
				href = href.replace(/\@/g,"WEhjdAT");
			}
			this.eDocument.execCommand("createlink",false,href + "WEhjdAfgkh");
			var all_links = this.eDocument.getElementsByTagName('A');
			for(var i=0; i < all_links.length; i++){
				if(all_links[i].getAttribute('href')){
					if(all_links[i].getAttribute('href').search('WEhjdAfgkh') != -1){
						href = href.replace(/WEhjdAT/g,"@");
						if(maillink){
							href = "mailto:"+href;
						}
						all_links[i].setAttribute('href',href);
						link = all_links[i];
						break;
					}
				}
			}
		}

	}else{
		this.eDocument.execCommand("createlink",false,href)	;
		link = this.getNodeUnderInsertionPoint("A",true,false);
	}
	if(link != null){
		we_setRemoveAttribute(link,"target",target);
		we_setRemoveAttribute(link,"lang",lang);
		we_setRemoveAttribute(link,"hrefLang",hreflang);
		we_setRemoveAttribute(link,"title",title);
		we_setRemoveAttribute(link,"accessKey",accesskey);
		we_setRemoveAttribute(link,"tabIndex",tabindex);
		we_setRemoveAttribute(link,"rel",rel);
		we_setRemoveAttribute(link,"rev",rev);
		if(className.length){
			link.className = className;
		}else{
			link.removeAttribute("class");
			link.removeAttribute("className");
		}
		link.setAttribute("href",href);
	}
	this.windowFocus();
}
function weWysiwyg_insertImage(src,width,height,hspace,vspace,border,alt,align,name,className,title,longdesc){
	if(src && src.length > 0){
		var randstring = "weWysiwygImage_"+Math.random(1000000000);
		this.eDocument.execCommand("insertimage",false,randstring);
		var images = this.eDocument.getElementsByTagName("img");
		var img = null;
		for(var i=0; i< images.length; i++){
			if(images[i].getAttribute("src").substr(images[i].getAttribute("src").length-randstring.length,images[i].getAttribute("src").length) == randstring){
				img = images[i];
			}
		}
		if(img  != null){
			img.setAttribute("src",src);
			we_setRemoveAttribute(img,"width",width);
			we_setRemoveAttribute(img,"height",height);
			we_setRemoveAttribute(img,"hspace",hspace);
			we_setRemoveAttribute(img,"vspace",vspace);
			we_setRemoveAttribute(img,"border",border);
			we_setRemoveAttribute(img,"alt",alt);
			we_setRemoveAttribute(img,"title",title);
			we_setRemoveAttribute(img,"longdesc",longdesc);
			if(className.length){
				img.className = className;
			}else{
				img.removeAttribute("class");
				img.removeAttribute("className");
			}
			if(alt.length == 0){
				img.setAttribute("alt","");
			}
			we_setRemoveAttribute(img,"align",align);
			we_setRemoveAttribute(img,"name",name);
		}
	}
	this.windowFocus();
}

function weWysiwyg_editrule(width,height,color,align,noshade){
	var rule = this.getRule();
	var isNew = false;
	if(rule == null){
		isNew = true;
		rule = this.eDocument.createElement("HR");
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
	}
	we_setRemoveAttribute(rule,"width",width);
	we_setRemoveAttribute(rule,"size",height);
	we_setRemoveAttribute(rule,"align",align);
	if(noshade==1) rule.setAttribute("noShade",1);
	else rule.removeAttribute("noShade");

	if(isNew && (!isGecko)){
		this.range.pasteHTML(rule.outerHTML);
		this.range.select();
	}else if(isGecko){
		this.insertContent(rule, !isNew);
	}
	this.windowFocus();
}

function weWysiwyg_editAcronym(title,lang){

	var oldacronym = this.getNodeUnderInsertionPoint("ACRONYM",true,false);
	if(oldacronym != null && title.length==0){
		var inner = oldacronym.innerHTML;
		oldacronym.parentNode.removeChild(oldacronym);
		this.replaceText(inner);
		return;
	}else if(title.length==0){
		return;
	}
	var acronym = oldacronym ? oldacronym : this.eDocument.createElement("ACRONYM");
	if(acronym != null){
		we_setRemoveAttribute(acronym,"title",title);
		we_setRemoveAttribute(acronym,"lang",lang);
		acronym.innerHTML = acronym.innerHTML ? acronym.innerHTML : this.getSelectedText();
	}
	if(oldacronym == null){
		if(this.showBorders){
			acronym.style.border = this.showBorderStyle;
		}
		if(isGecko){
			this.insertContent(acronym,true);
		}else{
			this.range.pasteHTML(acronym.outerHTML);
		}
	}

}

function weWysiwyg_editAbbr(title,lang){

	var oldabbr = this.getNodeUnderInsertionPoint("ABBR",true,false);
	if(oldabbr != null && title.length==0){
		var inner = oldabbr.innerHTML;
		oldabbr.parentNode.removeChild(oldabbr);
		this.replaceText(inner);
		return;
	}else if(title.length==0){
		return;
	}
	var abbr = oldabbr ? oldabbr : this.eDocument.createElement("ABBR");
	if(abbr != null){
		we_setRemoveAttribute(abbr,"title",title);
		we_setRemoveAttribute(abbr,"lang",lang);
		abbr.innerHTML = abbr.innerHTML ? abbr.innerHTML : this.getSelectedText();
	}
	if(oldabbr == null){
		if(this.showBorders){
			abbr.style.border = this.showBorderStyle;
		}
		if(isGecko){
			this.insertContent(abbr,true);
		}else{
			this.range.pasteHTML(abbr.outerHTML);
		}
	}

}


function weWysiwyg_editLang(lang){

	var span = this.getParentElementFromRange();
	var selText = this.getSelectedText();
	var insertSpan = false;

	if(!(span.nodeName=="SPAN" && span.innerHTML.replace(/<[^>]+>/g,"") == this.getSelectedText())){

		if(selText.length == 0){
			span = this.getLangSpan();
		}else{
			if(lang.length == 0){
				return;
			}
			span = this.eDocument.createElement("SPAN");
			if(span != null){
				if(this.range.htmlText){
					span.innerHTML = this.range.htmlText;
				}else{
					span.appendChild(this.range.cloneContents());
				}
				insertSpan = true;
			}
		}
	}

	if(span != null){
		we_setRemoveAttribute(span,"lang",lang);
	}
	if(lang.length && span != null){
		span.style.border = this.showBorderStyle;
	}else{
		span.style.border = "";
	}

	if(span.attributes.length == 0 || (span.attributes.length == 1 && span.attributes[0].value.length==0)){
		var inner = span.innerHTML;
		span.parentNode.removeChild(span);
		this.replaceText(inner);
	}else if(insertSpan){
		if(isGecko){
			this.insertContent(span,true);
		}else{
			this.range.pasteHTML(span.outerHTML);
		}
	}

}

function weWysiwyg_edittable(edit,rows,cols,border,cellpadding,cellspacing,bgcolor,background,width,height,align,className,summary){
	var table;
	if(edit==false){
		table = this.eDocument.createElement("TABLE");
		if(this.showBorders && (border == 0 || border == "")){
			table.style.border = this.showBorderStyle;
		}
		var tbody = this.eDocument.createElement("TBODY");
		for(j=0; j < rows; j++){
			var mycurrent_row=this.eDocument.createElement("TR");
			for(i=0; i < cols; i++){
				var mycurrent_cell=this.eDocument.createElement("TD");
				mycurrent_cell.innerHTML = "&nbsp;";
				if(this.showBorders && (border == 0 || border == "")){
					mycurrent_cell.style.border = this.showBorderStyle;
				}
				mycurrent_row.appendChild(mycurrent_cell);
			}
			tbody.appendChild(mycurrent_row);
		}
		table.appendChild(tbody);
	}else{
		table = this.getNodeUnderInsertionPoint("TABLE",false,false);
	}

	var oldborder = null;

	if(table != null){
		oldborder = table.border;

		if(we_hasAttribute(table,"style")){
			if(we_hasAttribute(table.style,"width")){
				table.style.removeAttribute("width");
			}
			if(we_hasAttribute(table.style,"height")){
				table.style.removeAttribute("height");
			}
		}

		if(className.length){
			table.className = className;
		}else{
			table.removeAttribute("class");
			table.removeAttribute("className");
		}
		we_setRemoveAttribute(table,"border",border);
		we_setRemoveAttribute(table,"width",width);
		we_setRemoveAttribute(table,"height",height);
		we_setRemoveAttribute(table,"summary",summary);
		if(isGecko){
			we_setRemoveAttribute(table,"cellpadding",cellpadding);
			we_setRemoveAttribute(table,"cellspacing",cellspacing);
			we_setRemoveAttribute(table,"bgcolor",bgcolor);
		}else{
			we_setRemoveAttribute(table,"cellPadding",cellpadding);
			we_setRemoveAttribute(table,"cellSpacing",cellspacing);
			we_setRemoveAttribute(table,"bgColor",bgcolor);
		}
		we_setRemoveAttribute(table,"background",background);
		we_setRemoveAttribute(table,"align",align);

		var oldrows = we_getNumTableRows(table);
		var oldcols = we_getNumTableCols(table);
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
				this.appendTableCol(table,this.eDocument);
			}
		}else if(oldcols > cols){
			var colsToDel = oldcols-cols;
			for(var i=0;i<colsToDel;i++){
				this.delTableCol(table);
			}
		}

	}

	if(edit==false){
 		if(isGecko){
			this.range.extractContents();
			this.insertContent(table, false);
		}else{
			this.range.pasteHTML(table.outerHTML);
		}

	}else{
		if(oldborder != null && oldborder != border){
			this.showBorders = this.showBorders ? false : true;
			this.toggleBorders();
		}
	}
}


function weWysiwyg_editcell(width,height,bgcolor,align,valign,colspan,className,isheader,id,headers,scope){
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
	var cell = this.getNodeUnderInsertionPoint2("TD,TH",false,false);
	if(cell != null){
		if(className != undefined && className.length){
			cell.className = className;
		}else{
			cell.removeAttribute("class");
			cell.removeAttribute("className");
		}
		we_setRemoveAttribute(cell,"width",width);
		we_setRemoveAttribute(cell,"height",height);
		we_setRemoveAttribute(cell,"align",align);
		we_setRemoveAttribute(cell,"id",id);
		we_setRemoveAttribute(cell,"headers",headers);
		we_setRemoveAttribute(cell,"scope",scope);
		if(isGecko){
			we_setRemoveAttribute(cell,"valign",valign);
			we_setRemoveAttribute(cell,"bgcolor",bgcolor);
		}else{
			we_setRemoveAttribute(cell,"vAlign",valign);
			we_setRemoveAttribute(cell,"bgColor",bgcolor);
		}

		var colspanname;
		if(isGecko){
			colspanname = "colspan";
		}else{
			colspanname = "colSpan";
		}

		if(colspan != "" || colspan=="0"){
			var oldcolspan = Math.max(1,(cell.getAttribute(colspanname) == "") ? 1 : cell.getAttribute(colspanname));
			var tr = cell.parentNode;
			if(oldcolspan > colspan){
				var cellsToAdd = oldcolspan-colspan;
				for(var i=0; i<tr.childNodes.length;i++){
					if(tr.childNodes[i] == cell){
						if(i == (tr.childNodes.length-1)){
							for(var j=0;j<cellsToAdd;j++){
								var mycurrent_cell=this.eDocument.createElement(isheader ? "TH" : "TD");
								mycurrent_cell.innerHTML = "&nbsp;";
								if(this.showBorders && (table.border == 0 || table.border == "")){
									mycurrent_cell.style.border = this.showBorderStyle;
								}
								tr.appendChild(mycurrent_cell);
							}
						}else{
							var node = tr.childNodes[i+1];
							for(var j=0;j<cellsToAdd;j++){
								var mycurrent_cell=this.eDocument.createElement(isheader ? "TH" : "TD");
								mycurrent_cell.innerHTML = "&nbsp;";
								if(this.showBorders && (table.border == 0 || table.border == "")){
									mycurrent_cell.style.border = this.showBorderStyle;
								}
								tr.insertBefore(mycurrent_cell,node);
							}
						}
						break;
					}
				}
				cell.setAttribute(colspanname,colspan);
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
				cell.setAttribute(colspanname,z);
			}

		}
		if(isheader==1 && cell.nodeName == "TD"){
			var newTH = this.eDocument.createElement("TH");
			newTH.innerHTML = cell.innerHTML;
			weCopyAttributes(cell,newTH);
			if(cell.style.cssText) newTH.style.cssText = cell.style.cssText;
			var parent = cell.parentNode;
			parent.replaceChild(newTH,cell);
			if(isGecko) this.range.selectNode(newTH);
		}else if(isheader==0 && cell.nodeName == "TH"){
			var newTD = this.eDocument.createElement("TD");
			newTD.innerHTML = cell.innerHTML;
			weCopyAttributes(cell,newTD);
			if(cell.style.cssText) newTD.style.cssText = cell.style.cssText;
			var parent = cell.parentNode;
			parent.replaceChild(newTD,cell);
			if(isGecko) this.range.selectNode(newTD);
		}
	}
}

function weCopyAttributes(from,to){
	var attr = from.attributes;
	for(var i=0;i< attr.length;i++){
		if(attr[i].specified){
			to.setAttribute(attr[i].nodeName,attr[i].nodeValue);
		}
	}
}

function weWysiwyg_appendTableRow(table){
	var newrow=this.eDocument.createElement("TR");
	var numCols = we_getNumTableCols(table);
	for(var i=0; i<numCols; i++){
		var mycurrent_cell=this.eDocument.createElement("TD");
		mycurrent_cell.innerHTML = "&nbsp;";
		if(this.showBorders && (table.border == 0 || table.border == "")){
			mycurrent_cell.style.border = this.showBorderStyle;
		}
		newrow.appendChild(mycurrent_cell);
	}
	var tbody = table.firstChild;
	if(tbody != undefined && tbody.nodeName=="TBODY"){
		tbody.appendChild(newrow);
	}
}

function weWysiwyg_appendTableCol(table){
	var tbody = we_getTableBody(table);
	if(tbody.hasChildNodes()){
		for(var i=0; i< tbody.childNodes.length; i++){
			if(tbody.childNodes[i].nodeName == "TR"){
				var newcol=this.eDocument.createElement("TD");
				newcol.innerHTML = "&nbsp;";
				if(this.showBorders && (table.border == 0 || table.border == "")){
					newcol.style.border = this.showBorderStyle;
				}
				tbody.childNodes[i].appendChild(newcol);
			}
		}
	}
}

function weWysiwyg_delTableRow(table,rowNr){
	var tbody = we_getTableBody(table);
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

function weWysiwyg_delTableCol(table){
	var tbody = we_getTableBody(table);
	if(tbody.hasChildNodes()){
		for(var i=0; i< tbody.childNodes.length; i++){
			if(tbody.childNodes[i].nodeName == "TR"){
				var lastTD = we_getLastTableCell(tbody.childNodes[i]);
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

function weWysiwyg_insertCol(insertright){
	var td = this.getNodeUnderInsertionPoint2("TD,TH",false,false);
	var tr = this.getNodeUnderInsertionPoint("TR",false,false);
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);

	if(td != null && tr != null && table != null){
		var foo = (tr.cells.length-1) - td.cellIndex;
		var rows = table.rows;
		for (i=0;i<rows.length;i++) {
			var count = rows[i].cells.length - 1;
			var pos = count - foo;
			pos = (pos < 0) ? 0 : pos;
			var cell = rows[i].insertCell(insertright ? (pos+1) : pos);
			cell.innerHTML = "&nbsp;";
			if(this.showBorders && (table.border == 0 || table.border == "")){
				cell.style.border = this.showBorderStyle;
			}
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}
}
function weWysiwyg_insertRow(insertabove){
	var tr = this.getNodeUnderInsertionPoint("TR",false,false);
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);

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
			var cell=this.eDocument.createElement("TD");
			cell.innerHTML = "&nbsp;";
			if(this.showBorders && (table.border == 0 || table.border == "")){
				cell.style.border = this.showBorderStyle;
			}
			newRow.appendChild(cell);
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}

}
function weWysiwyg_deleteRow(){
	var tr = this.getNodeUnderInsertionPoint("TR",false,false);
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
	if(tr != null && table != null){
		table.deleteRow(tr.rowIndex);
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}

}
function weWysiwyg_deleteCol(){
	var td = this.getNodeUnderInsertionPoint2("TD,TH",false,false);
	var tr = this.getNodeUnderInsertionPoint("TR",false,false);
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);

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
function weWysiwyg_colSpan(increase){
	var td = this.getNodeUnderInsertionPoint2("TD,TH",false,false);
	var tr = this.getNodeUnderInsertionPoint("TR",false,false);
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);

	if(td != null && tr != null && table != null){
		if(increase){
			var colspan = td.colSpan;
			colspan = colspan ? colspan : 1;
			var cells = tr.cells;
			if (td.cellIndex + 1 != tr.cells.length) {
				var colspan2add = cells[td.cellIndex+1].colSpan;
				colspan2add = colspan2add ? colspan2add : 1;
				td.colSpan = colspan + colspan2add;
				tr.deleteCell(td.cellIndex+1);
			}
		}else{
			if (td.colSpan != 1) {
				var cell = tr.insertCell(td.cellIndex+1);
				cell.innerHTML = "&nbsp;";
				td.colSpan = td.colSpan - 1;
				if(this.showBorders && (table.border == 0 || table.border == "")){
					cell.style.border = this.showBorderStyle;
				}
			}
		}
	}else{
		top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
	}
}

function weWysiwyg_caption(){
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
	var newcaption=this.eDocument.createElement("CAPTION");
	newcaption.innerHTML=we_wysiwyg_lng["caption"];
	table.insertBefore(newcaption,table.firstChild);
}

function weWysiwyg_removecaption(){
	var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
	var capts = table.getElementsByTagName("CAPTION");
	for(var i=0; i< capts.length; i++){
		table.removeChild(capts[i]);
	}
}


function we_wysiwyg_toggleSourceCode(){
	this.sourceMode = this.sourceMode ? false : true;
	var fr = document.getElementById(this.fName);
	var ta = document.getElementById(this.fName+"_src");
	if(this.sourceMode){
		for(var i=0;i<this.disableSourceButtons.length;i++){
			if(this.hasCmd(this.disableSourceButtons[i])){
				this.buttons[this.disableSourceButtons[i]].disable();
			}
		}
		for(var i in this.menus){
			if(this.hasCmd(i)){
				this.menus[i].disable();
			}
		}
		this.buttons["editsource"].check();
		this.oldSourceTitle = this.buttons["editsource"].button.title;

		this.buttons["editsource"].button.src = weWysiwygImagesFolderPath + 'wysiwyg.gif';
		this.buttons["editsource"].button.title = 'Wysiwyg Editor';
		this.buttons["editsource"].button.alt = 'Wysiwyg Editor';
		fr.style.display="none";
		var merk = this.showBorders;
		this.showBorders = true;
		this.toggleBorders();
		this.showBorders = merk;

		// Bug Fix #8457
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
		ta.focus();
	}else{
		for(var i=0;i<this.disableSourceButtons.length;i++){
			if(this.hasCmd(this.disableSourceButtons[i])){
				this.buttons[this.disableSourceButtons[i]].enable();
			}
		}
		for(var i in this.menus){
			if(this.hasCmd(i)){
				this.menus[i].enable();
			}
		}
		this.buttons["editsource"].uncheck();
		this.buttons["editsource"].button.src = weWysiwygImagesFolderPath + 'editsourcecode.gif';
		this.buttons["editsource"].button.title = this.oldSourceTitle;
		this.buttons["editsource"].button.alt = this.oldSourceTitle;
		this.eDocument.body.innerHTML = this.sendToEditor(ta.value);
		if(this.showBorders){
			this.showBorders = false;
			this.toggleBorders();
		}

		if(this.hasCmd("visibleborders")) this.buttons["visibleborders"].out();

		ta.style.display = "none";
		fr.style.display="block";
		this.eDocument.designMode = 'on';
		this.windowFocus();
	}

}

function weCorrectListTags(invalue,tagname){
	var found = null;
	var regex = new RegExp("</li>[ \n\r\t]*<"+tagname,"gi");
	while(found = invalue.match(regex)){
		var repl = found[0];

		var pos = invalue.indexOf(repl);
		// suche ul endtag
		var posULStartTag = invalue.indexOf("<"+tagname,pos+1);
		var posULStartTag2 = invalue.indexOf("<"+tagname,posULStartTag+1);
		var posULEndTag = invalue.indexOf("</"+tagname,posULStartTag+1);
		var endtagcount = 0;
		var starttagposFinal = posULStartTag;
		while((posULStartTag2 > -1) && (posULEndTag >  posULStartTag2)){
			posULStartTag = posULStartTag2;
			posULStartTag2 = invalue.indexOf("<"+tagname,posULStartTag+1);
			endtagcount++;
		}
		while(endtagcount){
			posULEndTag = invalue.indexOf("</"+tagname,posULEndTag+1);
			endtagcount--;
		}
		invalue = (pos ? invalue.substring(0,pos) : "") + invalue.substring(pos+5,posULEndTag+5) + "</li>" + (((posULEndTag+5) < invalue.length) ? invalue.substring(posULEndTag+5,invalue.length) : "");
	}

	return invalue;

}

function weWysiwyg_toggleBorders(){
	this.showBorders = this.showBorders ? false : true;
	var tables = this.eDocument.body.getElementsByTagName("TABLE");
	var links = this.eDocument.body.getElementsByTagName("A");
	var acronyms = this.eDocument.body.getElementsByTagName("ACRONYM");
	var abbrs = this.eDocument.body.getElementsByTagName("ABBR");
	var spans = this.eDocument.body.getElementsByTagName("SPAN");

	for (var i=0; i < tables.length; i++) {
		if((tables[i].border == 0 || tables[i].border == "")){
			if(this.showBorders){
				tables[i].style.border = this.showBorderStyle;
			}else{
				var st = we_getMainStyles(tables[i]);
				tables[i].style.border = ""; // removeAttribute("style");
				we_setMainStyles(tables[i],st);
			}
			var rows = tables[i].rows;
			for (n=0; n < rows.length; n++) {
				var cells = rows[n].cells;
				for (m=0; m < cells.length; m++) {
					if (this.showBorders) {
						cells[m].style.border = this.showBorderStyle;
					} else {
						var st = we_getMainStyles(cells[m]);
						cells[m].style.border = ""; // removeAttribute("style");
						we_setMainStyles(cells[m],st);
					}
				}
			}
		}
	}
	for(var i=0; i < links.length; i++){
		if(this.showBorders){
			if(!we_hasAttribute(links[i],"href")){
				we_applyBorderToAnchor(links[i],this.showBorderStyle);
			}
		}else{
			if(!we_hasAttribute(links[i],"href")){
				links[i].removeAttribute("style");
				if(links[i].innerHTML == "&nbsp;&nbsp;") links[i].innerHTML = "";
			}
		}
	}
	for(var i=0; i < spans.length; i++){
		if(this.showBorders){
			if(we_hasAttribute(spans[i],"lang")){
				spans[i].style.border = this.showBorderStyle;
			}
		}else{
			spans[i].style.border = "";
		}
	}
	for(var i=0; i < acronyms.length; i++){
		if(this.showBorders){
			acronyms[i].style.border = this.showBorderStyle;
		}else{
			acronyms[i].removeAttribute("style");
		}
	}
	for(var i=0; i < abbrs.length; i++){
		if(this.showBorders){
			abbrs[i].style.border = this.showBorderStyle;
		}else{
			abbrs[i].removeAttribute("style");
		}
	}

	if(this.buttons["visibleborders"].button){
		if(this.showBorders){
			this.buttons["visibleborders"].button.title = we_wysiwyg_lng["hide_borders"];
			this.buttons["visibleborders"].button.alt = we_wysiwyg_lng["hide_borders"];
		}else{
			this.buttons["visibleborders"].button.title = we_wysiwyg_lng["visible_borders"];
			this.buttons["visibleborders"].button.alt = we_wysiwyg_lng["visible_borders"];
		}
	}

	this.eDocument.body.innerHTML = this.eDocument.body.innerHTML;
}

function we_applyBorderToAnchor(anchor,border){
	anchor.style.border = border;
	anchor.style.width = "12px";
	anchor.style.height = "8px";
	anchor.style.backgroundColor = "#CCCCFF";
	if(!anchor.innerHTML) anchor.innerHTML = "&nbsp;&nbsp;"
}

function weWysiwyg_execCommand(cmd){
	this.windowFocus();
	if(this.sourceMode && cmd != "editsource" && cmd != "fullscreen"){
		return;
	}
	if(cmd != "editsource" && cmd != "fullscreen"){
		this.getSelection();
	}

	switch(cmd){
		case "lang":

			
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "langDialog.php");
			
 			var langspan = this.getLangSpan();
			if(langspan != null){
				dialog.append("lang", null, langspan);
			}			
			dialog.open(430, 190);
			return;
		case "acronym":
			
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "acronymDialog.php");

			var acronym = this.getNodeUnderInsertionPoint("ACRONYM",true,false);
			if(acronym != null){
				dialog.append("title", null, acronym);
				dialog.append("lang", null, acronym);
			}
			dialog.append("language", this.language);
			dialog.open(430,190);
			return;

		case "abbr":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "abbrDialog.php");

			var abbr = this.getNodeUnderInsertionPoint("ABBR",true,false);
			if(abbr != null){
				dialog.append("title", null, abbr);
				dialog.append("lang", null, abbr);
			}
			dialog.append("language", this.language);
			dialog.open(430,190);
			return;

		case "removeformat":
			if(confirm(we_wysiwyg_lng["removeformat_warning"])){
				var text = this.eDocument.body.innerHTML;

				var inlArr = this.inlineTags.trim().split(/ /);
				for(var i=0; i < inlArr.length; i++){
					var re = new RegExp("<"+inlArr[i]+" [^>]*>","gi");
					text = text.replace(re,"");
					re = new RegExp("</?"+inlArr[i]+">","gi");
					text = text.replace(re,"");
				}
				text = text.replace(/(<[^>]*)style="[^"]*"([^>]*>)/gi,"$1$2"); // remove style
				text = text.replace(/(<[^>]*)v?align="[^"]*"([^>]*>)/gi,"$1$2"); // remove align and valign
				this.eDocument.body.innerHTML = text;
			}
			break;
		case "insertbreak":
			if(!isGecko){
				this.range.pasteHTML("<br>");
				this.range.select();
			}
			break;
		case "anchor":
			var oldanchor = this.getNodeUnderInsertionPoint("A",true,false);

			if( (oldanchor != null) && (we_hasAttribute(oldanchor,"href")) && (!we_hasAttribute(oldanchor,"name")) && (oldanchor.name.length > 0) ){
				oldanchor = null;
			}

			var anchorName = (oldanchor != null) ? oldanchor.name : "";
			anchorName = prompt(we_wysiwyg_lng["anchor_name"],anchorName);
			if(anchorName != null && anchorName.length > 0){
				anchor = oldanchor ? oldanchor : this.eDocument.createElement("A");
				if(anchor != null){
					anchor.name = anchorName;
					if(this.xml) anchor.id = anchorName;
					anchor.innerHTML = this.getSelectedText();
				}
				if(oldanchor == null){
					if(this.showBorders){
						we_applyBorderToAnchor(anchor,this.showBorderStyle);
					}
					if(isGecko){
						this.insertContent(anchor,true);
					}else{
						this.range.pasteHTML(anchor.outerHTML);
					}
				}
			}
			break;

		case "visibleborders":
			this.toggleBorders();
			break;
		case "unlink":
			if(isGecko){
				var link = this.getNodeUnderInsertionPoint("A",true,false);
				if(link != null){
					we_deleteTag(link);
				}
			}else{
				this.eDocument.execCommand("unlink");
			}
			break;
		case "importrtf":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "importRtfDialog.php");
			dialog.open(630, 400);
			return;
		case "fullscreen":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "fullscreenEditDialog.php");

			var screen_height = screen.availHeight - 70;
			var screen_width = screen.availWidth-10;
			
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
			return;
		case "editsource":
			this.toggleSourceCode();
			return;
		case "forecolor":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "colorDialog.php");
			var col = ""+this.eDocument.queryCommandValue("forecolor");
			var hexcol = (col.substring(0,1) == "#") ? col : we_makehexcolor(col);
			dialog.append("type", "forecolor");
			dialog.append("color", hexcol);
			dialog.open(400, 380);
			return;
		case "backcolor":
			if(isGecko){
				var col = ""+this.eDocument.queryCommandValue("hilitecolor");
			}else{
				var col = ""+this.eDocument.queryCommandValue("backcolor");
			}
			if(col != "transparent"){
				var hexcol = (col.substring(0,1) == "#") ? col : we_makehexcolor(col);
			}else{
				var hexcol = "";
			}
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "colorDialog.php");
			dialog.append("type", "backcolor");
			dialog.append("color", hexcol);
			dialog.open(400, 380);
			return;
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
			

			var cell = this.getNodeUnderInsertionPoint2("TD,TH",false,false);

			if(cell != null){
				var isheader = (cell.nodeName=="TD") ? 0 : 1;
				var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "cellDialog.php");
				dialog.append("width", null, cell);
				dialog.append("height", null, cell);
				dialog.append("align", null, cell);
				dialog.append("class", null, cell);
				dialog.append("id", null, cell);
				dialog.append("headers", null, cell);
				dialog.append("scope", null, cell);

				if(isGecko){
					dialog.append("valign", null, cell);
					dialog.append("bgcolor", null, cell);
					dialog.append("colspan", null, cell);
				}else{
					dialog.append("vAlign", null, cell);
					dialog.append("bgColor", null, cell);
					dialog.append("colSpan", null, cell);
				}
				dialog.append("cssClasses", this.cssClasses);
				dialog.append("isheader", isheader);
				dialog.open(500, 350);
			}else{
				top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
			}
			return;
		case "edittable":
			

			var table = this.getNodeUnderInsertionPoint("TABLE",false,false);
			if(table != null){
				var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "tableDialog.php");
				dialog.append("border", null, table);

				if(isGecko){
					dialog.append("cellpadding", null, table);
					dialog.append("cellspacing", null, table);
					dialog.append("bgcolor", null, table);
				}else{
					dialog.append("cellPadding", null, table);
					dialog.append("cellSpacing", null, table);
					dialog.append("bgColor", null, table);
				}
				
				dialog.append("class", null, table);
				dialog.append("width", null, table);
				dialog.append("height", null, table);
				dialog.append("align", null, table);
				dialog.append("background", null, table);
				dialog.append("summary", null, table);
				
				var rows = we_getNumTableRows(table);
				var cols = we_getNumTableCols(table);
				dialog.append("rows", rows);
				dialog.append("cols", cols);
				dialog.append("cssClasses", this.cssClasses);
				dialog.append("edit", 1);
				dialog.open(500, 340);
			}else{
				top.we_showMessage(we_wysiwyg_lng["no_table_selected"], WE_MESSAGE_ERROR, window);
			}
			return;
		case "inserttable":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "tableDialog.php");
			dialog.append("rows", 3);
			dialog.append("cols", 3);
			dialog.append("border", 1);
			dialog.append("edit", 0);
			dialog.append("cssClasses", this.cssClasses);
			dialog.open(500, 340);
			return;
		case "insertimage":
			var image = this.getImage();
			var preurl = document.location.protocol+"//"+document.location.hostname;
			if (document.location.port) {
				preurl += ":" + document.location.port;
			}
			
			
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "imageDialog.php");
			
			if(image != null){
				if(we_hasAttribute(image,"src")){
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
					
			return;
		case "createlink":
			var image = this.getImage();
			var link = this.getNodeUnderInsertionPoint("A",true,false);
			if(!isGecko && link != null){
				if(link.tabIndex != null && link.tabIndex){ // IE Fix
					link.tabindex = link.tabIndex;
				}
				if(link.accessKey != null && link.accessKey){ // IE Fix
					link.accesskey = link.accessKey;
				}
				if(link.hrefLang != null && link.hrefLang){ // IE Fix
					link.hreflang = link.hrefLang;
				}
			}

			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "linkDialog.php");

			if(link != null){
				var link_href = this.removeHostname(link.href,true);
				var basepath = this.removeHostname(this.baseUrl,true);
				if(link_href.indexOf("#") > -1 && (link_href.length >= basepath.length && link_href.substring(0,basepath.length) == basepath)){
					link_href = link_href.substring(basepath.length,link_href.length);
				}
				var re = new RegExp("/webEdition[^\"']*/","gi");
				link_href = link_href.replace(re,"");
				re = new RegExp("we_cmd.php[^#\"']+","gi");
				link_href = link_href.replace(re,"");
				
				link_href = this.decodeDomainUmlautsOfUrl(link_href);
				
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
			
			if(link != null || this.getSelectedText().length > 0 || image != null){
				dialog.open(580, 500);
			}else{
				top.we_showMessage(we_wysiwyg_lng["nothing_selected"], WE_MESSAGE_ERROR, window);
			}
			return;
		case "inserthorizontalrule":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "ruleDialog.php");

			var rule = this.getRule();
			var tail = "";
			if(rule != null){
						
				dialog.append("width", null, rule, true);
				dialog.append("height", null, rule, true);
				dialog.append("height", null, rule, true);
				dialog.append("align", null, rule);
				
				var html = weGetOuterHTML(rule);
				if (html.search(/noshade/i) > -1) {
					dialog.append("noshade", 1);
				}
			}
			dialog.open(320, 240);
			
			return;
		case "insertspecialchar":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "specialCharDialog.php");
			dialog.open(400,300);
			return;
		case "paste":
		case "copy":
		case "cut":
			if(isGecko){
				top.we_showMessage(we_wysiwyg_lng["mozilla_paste"], WE_MESSAGE_ERROR, window);
			}else{
				this.eDocument.execCommand(cmd, false, null);
			}
			break;
		case "spellcheck":
			var dialog = new weWysiwygDialog(this.name, weWysiwygFolderPath + "spellcheck.php");
			dialog.append("className", this.className);
			dialog.append("propString", this.propString);
			dialog.open(500,450);
			return;
		default:
			this.eDocument.execCommand(cmd, false, null);
	}
	this.windowFocus();
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
				hidden.value = we_hasAttribute(elem,name) ? ((name == "class") ? elem.className : elem.getAttribute(name)) : "";
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

// ###############################################################
// ############### Class weWysiwygPopupMenu ######################
// ###############################################################

var weWysiwygPopupMenu_Count = 0;

function weWysiwygPopupMenu(cmd,editor){
	this.name = "weWysiwygPopupMenu_" + (weWysiwygPopupMenu_Count++);
	this.editor = editor;
	this.cmd = cmd;
	this.disabled = false;
	this.disable = weWysiwygPopupMenu_disable;
	this.enable = weWysiwygPopupMenu_enable;
	this.getValue = weWysiwygPopupMenu_getValue;
	this.setValue = weWysiwygPopupMenu_setValue;
	this.execCommand = weWysiwygPopupMenu_execCommand;
	this.applyStyle = weWysiwygPopupMenu_applyStyle;
	this.obj = "weWysiwygPopupMenuObject_"+this.name;
	eval(this.obj + "=this");

}

function weWysiwygPopupMenu_execCommand(value){
	if(this.editor.sourceMode){
		return;
	}
	if(this.cmd=="applystyle"){
		this.applyStyle(value);
		this.editor.setMenuState(this.cmd);
		return;
	}
	this.editor.windowFocus();
	if(this.cmd == "formatblock" && isGecko==false){
		if(value=="normal"){
			value = "Normal";
		}else{
			value = "<"+value+">";
		}
	}
	this.editor.eDocument.execCommand(this.cmd, false, value);
	this.editor.setMenuState(this.cmd);
}


function weWysiwygPopupMenu_enable(){
	var p = document.getElementById(this.editor.ref+"_sel_"+this.cmd);
	var inp = document.getElementById(this.editor.ref+"_seli_"+this.cmd);
	if(p){

		var tds = p.getElementsByTagName("TD");
		var img = p.getElementsByTagName("IMG");
		inp.style.color="black";
		tds[0].style.backgroundImage="url(/webEdition/images/wysiwyg/menuback.gif)";
		img[0].src = "/webEdition/images/wysiwyg/menudown.gif";

		p.style.cursor = weIE55 ? "hand" : "pointer";

		if (!isGecko) {
			inp.style.color="black";
			inp.style.cursor = weIE55 ? "hand" : "pointer";
		}
		this.disabled = false;
	}
}

function weWysiwygPopupMenu_disable(){
	var p = document.getElementById(this.editor.ref+"_sel_"+this.cmd);
	var inp = document.getElementById(this.editor.ref+"_seli_"+this.cmd);
	if(p){

		var tds = p.getElementsByTagName("TD");
		var img = p.getElementsByTagName("IMG");

		tds[0].style.backgroundImage="url(/webEdition/images/wysiwyg/menuback_dis.gif)";
		img[0].src = "/webEdition/images/wysiwyg/menudown_dis.gif";
		p.style.cursor = "default";

		if (!isGecko) {
			inp.style.color="silver";
			inp.style.cursor = "default";
		}
		this.disabled = true;
	}

}

function weWysiwygPopupMenu_applyStyle(value){
	this.editor.doStyle(value);
}

function weWysiwygPopupMenu_getValue(){
	var p = document.getElementById(this.editor.ref+"_seli_"+this.cmd);
	if(p){
		return p.value;
	}else{
		return "";
	}
}

function weWysiwygPopupMenu_setValue(val){
	var p = document.getElementById(this.editor.ref+"_seli_"+this.cmd);
	if(p){
		if(p.value != val) p.value=val;
	}
}

// ###############################################################
// ############### Class weWysiwygButton #########################
// ###############################################################
var weWysiwygButton_Count = 0;

function weWysiwygButton(cmd,editor){

	this.name = "weWysiwygButton_" + (weWysiwygButton_Count++);
	this.cmd = cmd;
	this.editor = editor;

	this.checked = false;
	this.isover = false;
	this.disabled = false;

	this.div = document.getElementById(this.editor.fName+"_"+this.cmd+"Div");
	this.button = document.getElementById(this.editor.fName+"_"+this.cmd);

	this.click = weWysiwygButton_click;
	this.over = weWysiwygButton_over;
	this.out = weWysiwygButton_out;
	this.check = weWysiwygButton_check;
	this.uncheck = weWysiwygButton_uncheck;
	this.disable = weWysiwygButton_disable;
	this.enable = weWysiwygButton_enable;
	this.execCommand = weWysiwygButton_execCommand;
	this.obj = "weWysiwygButtonObject_"+this.name;
	eval(this.obj + "=this");
}

function weWysiwygButton_click(){
	if(!this.disabled){
		this.execCommand();
	}
}

function weWysiwygButton_over(){
	if(!this.disabled){
		this.isover = true;
		this.div.className = this.checked ? "tbButtonMouseOverDown" : "tbButtonMouseOverUp";
		return true;
	}
}

function weWysiwygButton_out(){
	if(!this.disabled){
		this.isover = false;
		this.div.className = this.checked ? "tbButtonDown" : "tbButton";
		return true;
	}
}

function weWysiwygButton_check(){
	if((!this.disabled) && (!this.checked) && this.div){
		this.checked = true;
		this.div.className = this.isover ? "tbButtonMouseOverDown" : "tbButtonDown";
		return true;
	}
}

function weWysiwygButton_uncheck(){
	if((!this.disabled) && this.checked && this.div){
		this.checked = false;
		this.div.className = this.isover ? "tbButtonMouseOverUp" : "tbButton";
		return true;
	}
}

function weWysiwygButton_disable(){
	if(!this.disabled && this.div){
		this.disabled = true;
			this.div.className = "tbButton";
			var src = this.button.src;
			if(src.indexOf("_dis.gif") == -1) src = src.replace(/\.gif/,"_dis.gif");
			this.button.src = src;
	}
}

function weWysiwygButton_enable(){
	if(this.disabled && this.div){
		this.disabled = false;

		this.div.className = "tbButton";
		var src = this.button.src;
		src = src.replace(/_dis\.gif/,".gif");
		this.button.src = src;
	}
}

function weWysiwygButton_execCommand(){
	this.editor.execCommand(this.cmd);
	this.editor.setButtonsState();
}



// ############################# STATIC FUNCTIONS #################


function we_isStopFormatTag(elem){
	switch(elem.nodeName.toUpperCase()){
		case "TD":
		case "TH":
		case "BODY":
			return true;
		default:
			return false;
	}
}

function we_getMozillaParentElement(range,isEnd){

	if(isEnd == undefined) isEnd == false;

	var obj =  isEnd ? range.endContainer : range.startContainer;

	while(obj.nodeName == "#text"){
		obj = obj.parentNode;
	}
	return obj;
}

function we_deleteStyleNodes(elem){
	if(elem.hasChildNodes()){
		for(var i=0; i< elem.childNodes.length;i++){
			if(elem.childNodes[i].nodeName.toUpperCase() != 'TABLE') we_deleteStyleNodes(elem.childNodes[i]);
			if((elem.childNodes[i].nodeName.toUpperCase() == "SPAN" || elem.childNodes[i].nodeName.toUpperCase() == "A") && we_hasAttribute(elem.childNodes[i],"class")){
				if(elem.childNodes[i].attributes.length > 1 || elem.childNodes[i].nodeName.toUpperCase() != 'SPAN'){
					elem.childNodes[i].removeAttribute("class");
				}else{
					we_deleteTag(elem.childNodes[i]);
				}
			}
		}
	}
	return false;
}

function we_getNumTableRows(table){
	var _rows = table.getElementsByTagName('tr');
	return _rows.length;
}

function we_getNumTableCols(table){
	var _rows = table.getElementsByTagName('tr');
	if (_rows.length) {
		var tr = _rows[0];
		var z = 0;
		var _tagName = "";
		for(var i=0; i< tr.childNodes.length; i++){
			_tagName = tr.childNodes[i].nodeName.toLowerCase();
			if (_tagName=='td' || _tagName=='th') {
				if (we_hasAttribute(tr, 'colspan')) {
					z += parseInt(""+tr.childNodes[i].getAttribute('colspan'));
				} else {
					z++;
				}
			}
		}
		return z;
	}
	return 0;
}


function we_getLastTableCell(row){
	if(row.hasChildNodes()){
		for(var i=row.childNodes.length-1; i>=0; i--){
			if(row.childNodes[i].nodeName=="TD" || row.childNodes[i].nodeName=="TH"){
				return row.childNodes[i];
			}
		}
	}
	return null;
}

function we_getTableBody(table){
	if(table.hasChildNodes()){
		for(var i=0; i< table.childNodes.length; i++){
			if(table.childNodes[i].nodeName=="TBODY"){
				return table.childNodes[i];
			}
		}
	}
	return table;
}

function we_setRemoveAttribute(elem,name,val){
	if(val.length){
		elem.setAttribute(name,val);
	}else{
		if(we_hasAttribute(elem,name)){
			elem.removeAttribute(name);
		}
	}
}


function we_hasAttribute(elem,name){
	if(isGecko){
		if(elem && elem.hasAttribute){
			return elem.hasAttribute(name);
		}else{
			return false;
		}
	}else{
		if(name=="class") name = "className";
		if(name=="colspan") name = "colSpan";
		eval("var attr=elem."+name);

		if(attr != "" && attr != undefined && attr != null){
			return true;
		}else{
			return false;
		}
	}
}



function we_dec2Hex(i) {
	var runningTotal = ''
	var quotient = we_hexQuotient(i);
	var remainder = eval(i + '-(' + quotient + '* 16)')
	runningTotal = we_charToHex(remainder) + runningTotal;
	while( quotient >= 16) {
		var savedQuotient = we_hexQuotient(quotient);
		remainder = eval(quotient + '-(' + savedQuotient + '* 16)');
		runningTotal = we_charToHex(remainder) + runningTotal;
		quotient = savedQuotient;
	}
	return we_charToHex(quotient) + runningTotal ;
}

function we_hexQuotient(i) {
	return Math.floor(eval(i + "/16"));
}

function we_charToHex(i){
	var hex = "0123456789ABCDEF";
	return hex.charAt(i);
}

function we_makehexcolor(col){
	var hexcol = "";
	if(isGecko){
		var r=col.replace(/rgb ?\((.+),.+,.+\)/,"$1")+"";
		var g=col.replace(/rgb ?\(.+,(.+),.+\)/,"$1")+"";
		var b=col.replace(/rgb ?\(.+,.+,(.+)\)/,"$1")+"";
		hexcol = "#"+we_dec2Hex(r.replace(/ /gi,""))+we_dec2Hex(g.replace(/ /gi,""))+we_dec2Hex(b.replace(/ /gi,""));
	}else{
		var tmp = we_dec2Hex(col);
		var tmp2 = '';
		if(tmp.length < 6){
			var tmplen = 6-tmp.length;
			for(var j=0; j< tmplen;j++){
				tmp2 += "0";
			}
		}
		hexcol = tmp2+tmp;
		hexcol = "#"+hexcol.substring(4,6)+hexcol.substring(2,4)+hexcol.substring(0,2);
	}
	return hexcol;
}

function we_deleteTag(node) {
    var childsLen = node.childNodes.length;
    var child = node.firstChild;
    var newchild;
    do {
        newchild = child.nextSibling;
        try {
            var newNode = node.parentNode.insertBefore(child,node);
        } catch(e) { }
        ;
    } while (child = newchild )
        node.parentNode.removeChild(node);
    return newNode;
}


// ### Range Extension
function we_InsertNodeAtRange(newNode) {
    var node=newNode;
    switch( node.nodeType ) {
		case Node.DOCUMENT_NODE:
		case Node.ATTRIBUTE_NODE:
		case Node.ENTITY_NODE:
		case Node.NOTATION_NODE:
			throw new Error("INVALID_NODE_TYPE_ERR")
			break;
		case Node.DOCUMENT_FRAGMENT_NODE:
			var firstChild = node.firstChild;
    }
    if( this.startContainer.nodeType == Node.TEXT_NODE) {
         this.startContainer.parentNode.insertBefore(node, this.startContainer.splitText( this.startOffset));
    } else if( this.startOffset == this.startContainer.childNodes.length) {
        this.startContainer.appendChild( node );
    } else {
        this.startContainer.insertBefore(node, this.startContainer.childNodes.item(this.startOffset) );
    }
    if( node.nodeType == Node.DOCUMENT_FRAGMENT_NODE)
        node = firstChild;
    try {
        this.setStart( node, 0 );
    } catch(err) {}
}



// ### Context Menu Functions

var we_oPopup = null;
var we_oPopupBody = null;
var we_contextCount = 0;
var we_lastEditor = null;
var we_ContextMenu = new Array();
var we_GeneralContextMenu = new Array();
var we_TableContextMenu = new Array();

function we_ContextMenuItem(string, cmdId) {
  this.string = string;
  this.cmdId = cmdId;
}

function we_contextHighlight(event){
	var s = isGecko ? event.target : event.srcElement;
	var st = isGecko ? s.style : s.runtimeStyle;
	st.backgroundColor = "Highlight";
	if(s.state){
		st.color = "GrayText";
	}else{
		st.color = "HighlightText";
	}
}

function we_contextDelete(event){
	var s = isGecko ? event.target : event.srcElement;
	var st = isGecko ? s.style : s.runtimeStyle;
	st.backgroundColor = "";
	st.color = "";
}

function we_addContextItem(text,state){
	if(we_contextCount == 0){
		we_oPopupBody.innerHTML = "";
	}
	var e = isGecko ? we_oPopup.document.createElement("div") : we_oPopup.document.createElement("<div>");
	e.style.cursor = 'default';
	if(!isGecko) e.style.width = '100%';
	e.style.align = 'center';
	e.style.height = '17px';
	e.unselectable="on";
	if(text == ""){
		e.innerHTML = '&nbsp;';
		e.style.padding = '2px';
		e.style.margin = '0px';
		e.style.overflow = 'hidden';
	}else{
		e.innerHTML = text;
		e.style.padding = '2px 20px';
		e.style.margin = '0px 1px';

		if(!state){
			we_addEvent(e, "mouseover", we_contextHighlight);
			we_addEvent(e, "mouseout", we_contextDelete);
			we_addEvent(e, "click", we_contextOnClick);
		}
	}
	we_oPopupBody.appendChild(e);
	if(state || text == ""){
		e.state = true;
		e.style.color="GrayText";
	}else{
		e.style.color="MenuText";
	}
	e.item = we_contextCount;
	we_contextCount++;
}

function we_contextOnClick(event){
	var s = isGecko ? event.target : event.srcElement;
	if(s.state){
		return false;
	}else{
		we_hideContextmenu(event);
		var cmd = we_ContextMenu[s.item].cmdId;
		we_lastEditor.execCommand(cmd);
		we_lastEditor.setButtonsState();
	}
}


function we_docClick(event){

	var e = event.target;
	var weLastPopupMenuBody = (weLastPopupMenu ? weLastPopupMenu.document.body : null);
	for (; e != null && e != we_oPopupBody && e != weLastPopupMenuBody; e = e.parentNode);
	if (e == null){
		if(weLastPopupMenu != null){
			we_hidePopupmenu();
		}else{
			we_hideContextmenu(event);
		}
		return false;
	}
}

function we_keyPress(event){
	event || (event = window.event);
	we_stopEvent(event);
	if (event.keyCode == 27) {
		if(weLastPopupMenu != null){
			we_hidePopupmenu();
		}else{
			we_hideContextmenu(event);
		}
		return false;
	}
}



function we_hideContextmenu(event){

	if(we_oPopup) we_oPopup.hide();
	we_removeEvent(document, "mousedown", we_docClick);
	we_removeEvent(we_lastEditor.eDocument, "mousedown", we_docClick);
	we_removeEvent(we_lastEditor.eDocument, "keypress", we_keyPress);
	we_removeEvent(document, "keypress", we_keyPress);
}


function weParseStyles(html,className){
	var spl = weSplitTables(html);
	var out = "";
	for(var i=0; i< spl.length; i++){
		if(spl[i].toUpperCase().substring(0,6) != "<TABLE"){
			spl[i] = spl[i].replace(/class=['"]?[^ '">]*['"]?/gi,"");
			spl[i] = spl[i].replace(/<span ?>/gi,"");
			spl[i] = spl[i].replace(/<span[ \r\n]+>/gi,"");
			spl[i] = weRemoveAlloneEndtags(spl[i],"SPAN");
		}
		out += spl[i];
	}
	if(className.length > 0){
		out = '<span class="'+className+'">'+out+'</span>';
	}

	return out;
}

function weSearchEndTag(tagname,html,start){
	if(start < 0 && start >= html.length) return -1;
	tagname = tagname.toUpperCase();
	var tagStart = html.toUpperCase().indexOf("<"+tagname,start);
	var tagEnd = html.toUpperCase().indexOf("</"+tagname+">",start);
	if(tagEnd > -1 && (tagStart == -1 || tagStart > tagEnd)) return tagEnd;
	if(tagEnd == -1) return -1;
	var z = 0;
	while(tagStart < tagEnd && tagStart > -1){
		z++;
		tagStart = html.toUpperCase().indexOf("<"+tagname,tagStart+1);
	}
	var ez = 1;
	while(tagEnd > -1 && ez < z){
		ez++;
		tagEnd = html.toUpperCase().indexOf("</"+tagname+">",tagEnd+1);
	}
	if(tagEnd == -1) return -1;
	return tagEnd;
}
function weRemoveAlloneEndtags(html,tagname){
	var starttagpos = html.toUpperCase().indexOf("<"+tagname.toUpperCase());
	var endtagpos = html.toUpperCase().indexOf("</"+tagname.toUpperCase()+">");

	if(endtagpos > -1){
		if(endtagpos < starttagpos || starttagpos==-1){
			html = ((endtagpos > 0) ? html.substring(0,endtagpos) : "") +
					html.substring(endtagpos+tagname.length+3,html.length);
			html = weRemoveAlloneEndtags(html,tagname);
		}
	}
	return html;
}
function weSplitTables(html){
	var retArr = new Array();
	var z = 0;
	var start = 0;
	var tableStart = html.toUpperCase().indexOf("<TABLE");

	if(tableStart > -1){
		while(tableStart >= start){
			if(start < tableStart) retArr[z++] = html.substring(start,tableStart);
			start = weSearchEndTag("TABLE",html,tableStart);
			if(start != -1){
				start += 8;
			}else{
				start = html.length;
			}
			retArr[z++] = html.substring(tableStart,start);
			if(start < html.length){
				tableStart = html.toUpperCase().indexOf("<TABLE",start);
			}else{
				tableStart = -1;
			}
		}
		if(start < html.length){
			retArr[z++] = html.substring(start,html.length);
		}
	}else{
		retArr[z] = html;
	}

	return retArr;
}

function weGetOuterHTML(elem){
	if(isGecko){
		var div = document.createElement("DIV");
		div.appendChild(elem.cloneNode(true));
		return div.innerHTML;
	}else{
		return elem.outerHTML;
	}
}

function we_on_key_down(obj){
		if(!isGecko){
			if (obj.eFrame.event.keyCode == 9) { // TAB
				obj.getSelection();
				obj.range.pasteHTML(" &nbsp;&nbsp;&nbsp; ");
				obj.range.select();
				obj.range.moveEnd("character", 1);
				obj.range.moveStart("character", 1);
				obj.range.collapse(false);
				return false;
			}
		}
		return true;
}

function we_on_key_up(obj){
	if(isGecko && (!obj.hasFocus)){
		obj.doSetFocus();
	}
	if(!isGecko){
		obj.setButtonsState();
	}
	return true;
}

function we_on_mouse_up(obj){
	if(isGecko && (!obj.hasFocus)){
		obj.doSetFocus();
	}
	obj.setButtonsState();
	return true;
}
function we_on_focus(obj){
	obj.hasFocus = true;
	return true;
}
function we_on_blur(obj){
	obj.hasFocus = false;
	return true;
}

function weGetFirstRealChildNode(node){
	for(var i=0; i<node.childNodes.length;i++){
		if(node.childNodes[i].nodeType!=3 || node.childNodes[i].nodeValue.length > 0){
			return node.childNodes[i];
		}
	}
}

function weGetLastRealChildNode(node){
	for(var i=node.childNodes.length-1; i>=0;i--){
		if(node.childNodes[i].nodeType!=3 || node.childNodes[i].nodeValue.length > 0){
			return node.childNodes[i];
		}
	}
	return null;
}

function weGetParentStyles(node,styleSheets,cln){

	var ignoreParent = false;
	var parent = node.parentNode;
	var nodes = new Array();
	var i = 0;
	while(parent.nodeName.toLowerCase() != "body"){
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
			var styles = weGetElementStyle(nn,styleSheets);
			for(var key in styles){
				stylesArray[key] = styles[key];
			}
		}

	}
	for(i=(nodes.length-1); i >= 0; i--){
		var nn = nodes[i].nodeName.toLowerCase();
		if((!ignoreParent) ||
			(ignoreParent && (nn == "td" || nn == "th" || nn == "tr" || nn == "table" || nn == "body"))){
			if(we_hasAttribute(nodes[i],"class")){
				lastClass = nodes[i].className;
				var styles = weGetElementStyle("."+nodes[i].className,styleSheets);
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
			if(we_hasAttribute(nodes[i],"id")){
				var styles = weGetElementStyle("#"+nodes[i].id,styleSheets);
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
			if(we_hasAttribute(nodes[i],"style")){
				var styles = nodes[i].style;
				for(var key in styles){
					stylesArray[key] = styles[key];
				}
			}
		}

	}

	if(cln){
		var styles = weGetElementStyle("."+cln,styleSheets);
		for(var key in styles){
			stylesArray[key] = styles[key];
		}
	}
	return new Array(lastClass,stylesArray);

}

function weGetElementStyle(elementName,styleSheets){
	var styleArray = new Array();
	// loop through all styles
	for(var i=0;i<styleSheets.length;i++){
		// get the rules
		var r = isGecko ? styleSheets[i].cssRules : styleSheets(i).rules;
		// loop through all rules
		for(var n=0;n<r.length;n++){
			// get selector Text (.class or elemName)
			var selectorText = isGecko ? r[n].selectorText : r(n).selectorText;
			if(String(selectorText).length > 1 && String(selectorText).toLowerCase().indexOf(elementName.toLowerCase()) > -1){
				// loop through all selector text entries
				var v = String(selectorText).split(',');
				for(var m=0; m < v.length; m++){
					var el = elementName.toLowerCase().trim(); // element
					var selText = v[m].toLowerCase().trim(); // selector Text
					if(el == selText){
						style = isGecko ? r[n].style : r(n).style;
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

function we_addEvent(e, name, f) {
	if (isGecko) {
		e.addEventListener(name, f, true);
	} else {
		e.attachEvent("on" + name, f);
	}
}

function we_stopEvent(ev) {
	if (isGecko) {
		ev.preventDefault();
		ev.stopPropagation();
	} else {
		ev.cancelBubble = true;
		ev.returnValue = false;
	}
}

function we_removeEvent(e, name, f) {
	if (isGecko) {
		e.removeEventListener(name, f, true);
	} else {
		e.detachEvent("on" + name, f);
	}
}

function we_getElemPos(el) {
	var arr = { x: el.offsetLeft, y: el.offsetTop };
	if (el.offsetParent) {
		var tmp = we_getElemPos(el.offsetParent);
		arr.x += tmp.x;
		arr.y += tmp.y;
	}
	return arr;
}

function we_getMainStyles(obj){
	var styles = new Array();
	styles["with"] = obj.style.width;
	styles["height"] = obj.style.height;
	styles["backgroundColor"] = obj.style.backgroundColor;
	styles["color"] = obj.style.color;
	styles["font"] = obj.style.font;
	styles["textDecoration"] = obj.style.textDecoration;
	return styles;
}

function we_setMainStyles(obj,styles){
	if(styles["with"]) obj.style.width = styles["with"];
	if(styles["height"]) obj.style.height = styles["height"];
	if(styles["backgroundColor"]) obj.style.backgroundColor = styles["backgroundColor"];
	if(styles["color"]) obj.style.color = styles["color"];
	if(styles["font"]) obj.style.font = styles["font"];
	if(styles["textDecoration"]) obj.style.textDecoration = styles["textDecoration"];
}

function wePopUpFrame(fr){
	this._iframe = fr ? fr : document.createElement("iframe");
	this._iframe.style.display='none';
	this._iframe.style.position='absolute';
	this._iframe.style.border='0px';
	if(fr == null) document.body.appendChild(this._iframe);
	this.document = isGecko ? this._iframe.contentDocument : this._iframe.contentWindow.document;
	if(!isGecko){
		this.document.open();
		this.document.write('<html><head><style type="text/css">'+we_styleString+'</style></head><body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" unselectable="on"></body></html>');
		this.document.close();
	}
}

wePopUpFrame.prototype.show = function(x,y,w,h,obj){ // obj only for compatibility reasons with IE

	if(x) this._iframe.style.left = x;
	if(y) this._iframe.style.top = y;
	if(w) this._iframe.style.width = w;
	if(h) this._iframe.style.height = h;
	this._iframe.style.display="block";
};

wePopUpFrame.prototype.hide = function(){
	this._iframe.style.display="none";
};

function weWysiwygUrlEncode(str) {
	if (encodeURIComponent) {
		return encodeURIComponent(str);
	}
	str = str.replace(/\+/,"##_WE_PLUS_##");
	str = escape(str);
	str = str.replace(/##WE_PLUS##/,"%2B");
	return str;
}


var weWysiwyg_translationTable = new Array (338,339,352,353,376,381,382,402,710,732,8211,8212,8216,8217,8218,8220,8221,8222,8224,8225,8226,8230,8240,8249,8250,8364,8482);
