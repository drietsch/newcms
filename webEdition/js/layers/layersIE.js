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

function showLayer(layer) {
	if (layer)
		layer.style.visibility="visible";
}
function hideLayer(layer) {
	if (layer)
		layer.style.visibility="hidden";
}
function getClientWidth(layer) {
	return layer.clientWidth;
}
function getLayerById(layerID, parent) {
	var doc;
	if (parent)
		doc = parent.document;
	else
		doc = window.document;
   return eval("doc.all."+layerID);
}
function getLayerWidth(layer) {
	return layer.clientWidth;
}
function getLayerTop(theLayer) {
	return theLayer.style.pixelTop;
}
function getWindowWidth(wnd) {
	//return wnd.document.body.offsetWidth;
	return wnd.document.body.clientWidth;
}
function getWindowHeight(wnd) {
	return wnd.document.body.offsetHeight;
}
function setBackgroundColor(layer, color) {
	if (layer && color)
		layer.style.backgroundColor=color;
}
function setForegroundColor(layer, color) {
	if (layer && color)
		layer.style.color=color;
}
function setInnerHtml(wnd,text) {
	if (!text)
		text="";
	wnd.innerHTML=text;
}
function setLayerBGImage(layer, img) {
	layer.style.backgroundImage='url('+img+')';
}
function setLayerLeft(theLayer, left) {
	theLayer.style.left=left;
}
function setLayerTop(theLayer, top) {
	theLayer.style.top=top;
}
function setLayerWidth(layer, width) {
	layer.style.width=width;
}
function moveLayer(layer,left,top) {
	layer.style.left = left;
	layer.style.top = top;
}
function createLayer(id,parent,left,top,width,height,content,bgColor,visibility,zIndex) {
	if (width < 0) {
		width = getWindowWidth(window) + (width+1) - left;
	}
	if (height < 0) {
		height = getWindowHeight(window) + (height+1) - top;
	}
	if (left < 0) {
		left = getWindowWidth(window) + (left+1) - width;
	}
	
	var str = '\n<DIV id='+id+' style="position:absolute; left:'+left+'; top:'+top+'; width:'+width + ";";

	if (height!=null) {
		str += '; height:'+height;
		str += '; clip:rect(0,'+width+','+height+',0)';
	}

	if (bgColor) str += '; background-color:'+bgColor	;
	if (zIndex!=null) str += '; z-index:'+zIndex;
	if (visibility)
		str += '; visibility:'+visibility;
	else
		str +=	'; visibility:visible';
	str += ';">'+((content)?content:'')+'</DIV>';
	if (parent) {
		parent.insertAdjacentHTML("BeforeEnd",str);
	} else {
		document.body.insertAdjacentHTML("BeforeEnd",str);
	}
	return getLayerById(id);
}
