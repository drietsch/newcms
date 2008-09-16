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

if (document.layers) {
	var out = '';
	out += '<style>';
	out += '.cl_rewrite { position: absolute; }';
	out += '.cl_spacer { position: relative; visibility: hidden; }';
	out += '<\/style>\n';
	document.write(out);
}
function we_element(content, id, className) {
	this.id = we_element.cnt++;
	we_element.elements[this.id] = this;
	this.layerId = id; 
	this.content = content;
	this.className = className || '';
	this.writeElement();
}
function we_element_writeElement() {
	var out = '';
	if (document.layers) {
		out += '<span id="' + this.layerId + '" class="cl_rewrite">';
		out += this.getContent();
		out += '<\/span>';
		out += '<span id="' + this.layerId + 'Rel" class="cl_spacer">';
		out += this.getContent();
		out += '<\/span>';
	}
	else {
		out += '<span id="' + this.layerId + '">';
		out += this.getContent();
		out += '<\/span>';
	}
	document.write(out);
}
we_element.prototype.writeElement = we_element_writeElement;
function we_element_rewrite(content, className) {
	if (className)
		this.className = className;
	this.content = content;
	var out = this.getContent();
	if (document.layers) {
		var l = this.layer;
		l.document.open();
		l.document.write(out);
		l.document.close();
	}
	else if (document.all) {
		document.all[this.layerId].innerHTML = out;
	}
	else if (document.getElementById) {
		var l = document.getElementById(this.layerId);
		while (l.hasChildNodes())
			l.removeChild(l.lastChild);
		var range = document.createRange();
		range.setStartAfter(l);
		var docFrag = range.createContextualFragment(out);
		l.appendChild(docFrag);
	}
}
we_element.prototype.rewrite = we_element_rewrite;
function we_element_init() {
	var l = this.layer = document[this.layerId];
	l.we_element = this;
}
we_element.prototype.init = we_element_init;
function we_element_getContent() {
	var out = '';
	out += '<span';
	out += this.className ? ' class="' + this.className + '"' : '';
	out += '>';
	out += this.content;
	out += '<\/span>';
	return out;
}
we_element.prototype.getContent = we_element_getContent;
we_element.cnt = 0;
we_element.elements = new Array();
we_element.init = function() {
	if (document.layers)
	for (var l = 0; l < we_element.elements.length; l++)
		we_element.elements[l].init();
}