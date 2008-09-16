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

function showLayer(layer) {
	if (layer)
		layer.visibility="show";
}
function hideLayer(layer) {
	if (layer)
		layer.visibility="hide";
}
function getClientWidth(layer) {
	return layer.clip.width;
}
function getLayerById(layerID, parent) {
	var doc;
	if (parent)
		doc = parent.document;
	else
		doc = window.document;
	var i;
	if (eval("doc.layers."+layerID))
		return doc.layers[layerID];
	for (i = 0; i < doc.layers.length; i++) {
		if (doc.layers[i].id==layerID)
			return doc.layers[i];
		var ret = getLayerById(layerID, eval("doc.layers."+doc.layers[i].id));
		if (ret != null)
			return ret;
	}
	return null;
}
function getLayerWidth(layer) {
	return layer.clip.width;
}
function getLayerTop(theLayer) {
	return theLayer.top;
}
function getWindowWidth(wnd) {
	return wnd.innerWidth;
}
function getWindowHeight(wnd) {
	return wnd.innerHeight;
}
function setBackgroundColor(layer, color) {
	if (layer && color)
		layer.bgColor=color;
}
function setForegroundColor(layer, color) {
	if (layer && color)
		layer.color=color;
}
function setInnerHtml(wnd, text) {
	if (!text)
		text="";
	wnd.document.open();
	wnd.document.write(text);
	wnd.document.close();
}
function setLayerBGImage(layer, img) {
	layer.background.src=img;
}
function setLayerLeft(theLayer, left) {
	theLayer.left=left;
}
function setLayerTop(theLayer, top) {
	theLayer.top=top;
}
function setLayerWidth(layer, width) {
	layer.clip.width=width;
}
function moveLayer(layer,left,top) {
	layer.left = left;
	layer.top = top;
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
	var layer;
	if (parent) {
		layer = parent.layers[id] = new Layer(width, parent);

	} else {
		layer = document.layers[id] = new Layer(width);
		eval("document."+id+" = layer");
	}
	layer.name = id;
	layer.id=id;
	moveLayer(layer,left,top);

	if (height!=null) layer.clip.height = height;
	setBackgroundColor(layer, bgColor);
	layer.visibility = (visibility=='hidden')? 'hide' : 'show';
	if (zIndex!=null) layer.zIndex = zIndex;
	setInnerHtml(layer, content);

	return layer;
}
