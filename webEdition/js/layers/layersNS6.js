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
	return layer.offsetWidth;
}
function getLayerById(layerID, parent) {
	var doc;
	if (parent)
		doc = parent.document;
	else
		doc = window.document;
	return doc.getElementById(layerID);
}
function getLayerWidth(layer) {
	return layer.offsetWidth;
}
function getLayerTop(theLayer) {
	return parseInt(theLayer.style.top);
}
function getWindowWidth(wnd) {
    wnd.parent.innerWidth;  //  Don't delete this, is needed for v-tabs and safari Bug #4121
    return wnd.innerWidth;
}
function getWindowHeight(wnd) {
	return wnd.innerHeight;
}
function setBackgroundColor(layer, color) {
	if (layer && color)
		layer.style.backgroundColor=color;
}
function setForegroundColor(layer, color) {
	if (layer && color)
		layer.style.color=color;
}
function setInnerHtml(wnd, text) {
	if (!text)
		text="";

	var oldDisp = wnd.parentNode.style.display;
	wnd.parentNode.style.display='none';
	wnd.innerHTML=text;
	wnd.parentNode.style.display=oldDisp;
}
function setLayerBGImage(layer, img) {
	layer.style.backgroundImage='url('+img+')';
}
function setLayerLeft(theLayer, left) {
	theLayer.style.left=left+"px";
}
function setLayerTop(theLayer, top) {
	theLayer.style.top=top+"px";
}
function setLayerWidth(layer, width) {
	layer.style.width=width+"px";
}
function moveLayer(layer,left,top) {
	layer.style.left = left+"px";
	layer.style.top = top+"px";
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
	var div = document.createElement("DIV");
	div.id = id;
	div.style.position = "absolute";
	div.style.left = left+"px";
	div.style.top = top+"px";
	div.style.width = width+"px";
	if(height != null) {
		div.style.height = height+"px";
		div.style.clip = "rect(0," + width + "," + height + ",0)";
	}
	if(bgColor != null)
		div.style.backgroundColor = bgColor;

	if(zIndex != null)
		div.style.zIndex = zIndex;

	if(visibility != null && (visibility == "hidden" || visibility == "hide"))
		div.style.visibility = "hidden";
	else
		div.style.visibility = "visible";

	if(content != null)
		div.innerHTML = content;

	if(parent != null)
		parent.appendChild(div);
	else
		document.body.appendChild(div);

	return div;
}
