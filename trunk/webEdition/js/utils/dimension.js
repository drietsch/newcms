// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: dimension.js,v 1.6 2007/05/23 15:39:32 holger.meyer Exp $

function getDimension(theString, styleClassElement) {
	var dim = new Object();

	if (document.getElementById && document.createElement) {
		var span = document.createElement('span');
		span.id = 'newSpan';
		span.style.position = 'absolute';
		span.style.visibility = 'hidden';
		if (styleClassElement) {
			span.className = styleClassElement;
		}
		span.appendChild(document.createTextNode(theString));
		document.body.appendChild(span);
		dim.height = span.offsetHeight;
		dim.width = span.offsetWidth;
		document.body.removeChild(span);
	}
	else if (document.all && document.body.insertAdjacentHTML) {
		var html = '';
		html += '<span id="newSpan" ';
		html += 'style="position: absolute; visibility: hidden;"';
		if (styleClassElement) {
			html += ' class="' + styleClassElement + '"';
		}
		html += '>';
		html += theString;
		html += '<\/span>';
		document.body.insertAdjacentHTML('beforeEnd', html);
		dim.height = document.all.newSpan.offsetHeight;
		dim.width = document.all.newSpan.offsetWidth;
		document.all.newSpan.outerHTML = '';
	}
	else if (document.layers) {
		var lr = new Layer(window.innerWidth);
		lr.document.open();
		if (styleClassElement) {
			lr.document.write('<span class="' + styleClassElement + '">'
				+ theString + '<\/span>');
		}
		else {
			lr.document.write(theString);
		}
		lr.document.close();
		dim.height = lr.document.height;
		dim.width = lr.document.width;
	}

	return dim;
}