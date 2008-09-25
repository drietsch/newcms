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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

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