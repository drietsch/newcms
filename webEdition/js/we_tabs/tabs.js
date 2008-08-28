/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

function We_TabCtrl() {
	this.tabs = new Array(arguments.length);
	for(i=0; i<arguments.length; i++) {
		this.tabs[i] = arguments[i];
	}

	this.addTab = new Function("we_tab","this.tabs.push(we_tab)"); 

	this.getTabCtrls = function() {
		var tabRowWidth = 0;
		var currCtrl = 0;
		var ctrls = new Array();

		for (var i=0; i<this.tabs.length; i++) {
			tabRowWidth += this.tabs[i].width+20;
			if (tabRowWidth >= winWidth) {
				tabRowWidth = this.tabs[i].width+20;
				currCtrl++;
			}
			if (typeof(ctrls[currCtrl]) == 'undefined')
				ctrls[currCtrl] = new Array();
			ctrls[currCtrl].push(this.tabs[i]);
		}
		return ctrls;
	}

	this.getActiveTab = function() {
		for (var i=0; i<this.tabs.length; i++) {
			if (this.tabs[i].state == 2)
				return i;
		}
		return 0;
	}

	this.setActiveTab = function(activeTab) {
		for (i=0; i<tabCtrl.tabs.length; i++) {
			var overOff   = hoveroff;
			var state     = TAB_NORMAL;
			var newSuffix = "";

			if (i == activeTab) {
				overOff = hovertab;
				newSuffix = suffix;
				state  = TAB_ACTIVE;
			}
			eval("tab["+i+"].setStyleClass('tab"+overOff+"');");
			document.images["tab_left" +i].src = eval(strImgLeft  + newSuffix + overOff + ".src");
			document.images["tab_right"+i].src = eval(strImgRight + newSuffix + overOff + ".src");
			tabCtrl.tabs[i].setState(state);
		}
		this.setActiveCtrl(activeTab);
		// workarround for mozilla mac
		document.getElementById("tabs_table").style.display = "none";
		document.getElementById("tabs_table").style.display = "";
	}

	this.setActiveCtrl = function(activeTab) {
		var activeCtrl;
		var currLayer = 0;
		var tabCtrls;

		tabCtrls = this.getTabCtrls();
		for (var i=0; i<tabCtrls.length; i++) {
			for (var y=0; y<tabCtrls[i].length; y++) {
				if (tabCtrls[i][y].id == activeTab) {
					activeCtrl = i;
				}
			}
			if (i == activeCtrl) {
				setLayerTop(theTabLayer[i],(tabCtrls.length-1)*19 + layerPosYOffset);
			}
			else {
				setLayerTop(theTabLayer[i], (currLayer*19 + layerPosYOffset));
				currLayer++;
			}
		}
	}
}

function We_Tab(href, title, state, jscode) {
	this.href  = href;
	this.title = title;
	this.state = state;
	this.jscode = jscode;

	this.getId = function() {
		return we_tabs.length;
	}
	this.id = this.getId();

	this.width = getDimension(this.title, 'tab_normal').width;

	this.setState = function(state) {
		this.state = state;
	}
}

var tab = new Array();
var tabContent = "";

function addTab(el) {
	var global_suffix = suffix;
	var _suffix = hoveroff;

	if (el.id == tabCtrl.getActiveTab())
		_suffix = hovertab;
	tabContent += '<td width="10">'
				+ '<img name="tab_left'+el.id+'" src="'+img_path+strImgLeft+global_suffix+_suffix+'.gif" '
				+ 'onClick="'+el.jscode+';tabCtrl.setActiveTab('+el.id+');" style="cursor:pointer;">'
				+ '</td>';
	classElement = new CSSClassElement(el, 'tab'+_suffix);
	tabContent += '<td width="10">'
				+ '<img name="tab_right'+el.id+'" src="'+img_path+strImgRight+global_suffix+_suffix+'.gif" '
				+ 'onClick="'+el.jscode+';tabCtrl.setActiveTab('+el.id+');" style="cursor:pointer;">'
				+ '</td>';
	return classElement;
}

function CSSClassElement(el, className, block) {
	this.id = el.id;
	this.title = el.title;
	this.width = el.width;
	this.jscode = el.jscode;
	this.className = className || '';
	this.block = block ? true : false;
	this.cssClassElementId = CSSClassElements.length;
	this.elementID = 'CSSClassElement' + this.cssClassElementId;
	CSSClassElements[CSSClassElements.length] = this;
	this.writeElement();
}

function CSSClassElement_writeElement() {
	tabContent += '<TD align="center" width="'+this.width+'" id="'+this.elementID
				+ '" onClick="' + this.jscode + ';tabCtrl.setActiveTab('+this.id+');" '
				+ this.createClassStyle()+' nowrap unselectable="on">'+this.title+'<\/TD>\n';

}

CSSClassElement.prototype.writeElement = CSSClassElement_writeElement;

function CSSClassElement_createClassStyle() {
	return this.className ? ' class="' + this.className + '"' : '';
}

CSSClassElement.prototype.createClassStyle = 
	CSSClassElement_createClassStyle;

function CSSClassElement_setStyleClass(className) {
	this.className = className;
	if (document.layers) {
		if (!this.layer)
		this.layer = document[this.elementID];
		var html = '';
		html += '<span '+this.createClassStyle()+'>'+this.content+'<\/span>';
		this.layer.document.open();
		this.layer.document.write(html);
		this.layer.document.close();
	}
	else { 
		if (!this.layer)
			this.layer = document.all ? document.all[this.elementID] :
				document.getElementById(this.elementID);
	}
	this.layer.className = className;
}

CSSClassElement.prototype.setStyleClass = CSSClassElement_setStyleClass;

CSSClassElements = new Array();

var theTabLayer = new Array();

we_tabInit = function() {
	tabCtrl = new We_TabCtrl();
	var id = 0;
	for (var i=0; i<we_tabs.length; i++) {
		if (we_tabs[i].state != 0) {
			tabCtrl.addTab(we_tabs[id]);
			id++;
		}
	}
	var count = 0;

	tabCtrls = tabCtrl.getTabCtrls();

	if (parent.frames.length > 0) {
		var frmRows = parent.document.body.rows;
		var rows = frmRows.split(",");

		var newFrmRows = 18 + ((tabCtrls.length-1)*19) + layerPosYOffset;
		for (var i=1; i<rows.length; i++) {
			newFrmRows += ","+rows[i];
		}
		if (frmRows != newFrmRows) {
			parent.document.body.rows = newFrmRows;
		}
	}
	for (var i=0; i<tabCtrls.length; i++) {
		var activeCtrl = false;
		var rowWidth = 0;
		var layerPosY = 0;

		tabContent = "";
		tabContent = '<table id="tabs_table" width="'+winWidth+'" border="0" cellpadding="0" cellspacing="0" style="-moz-user-select: none;"><tr>';
 		for (var y=0; y<tabCtrls[i].length; y++) {
			if (tabCtrls[i][y].id == tabCtrl.getActiveTab()) {
				activeCtrl = true;
			}
			tab[tabCtrls[i][y].id] = addTab(tabCtrls[i][y]);
			rowWidth += tabCtrls[i][y].width+20;
		}
		
  		tabContent += '<td width="'+(winWidth-rowWidth)+'">'
			+ '<img src="'+img_tabline+'" width="'+(winWidth-rowWidth)+'" height="18"></td>';
		tabContent += '</tr></table>';

		if (activeCtrl) {
			layerPosY = (tabCtrls.length-1)*19+layerPosYOffset;
			activeCtrl = false;
		}
		else {
			layerPosY = count*19+layerPosYOffset;
			count++;
		}

		theTabLayer[i] = createLayer("tabCtrl_"+i, null,
						0, layerPosY,
						winWidth, 18,
						tabContent,
    					"", "visible", i);
 	}
}
