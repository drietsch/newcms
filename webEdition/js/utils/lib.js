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

function copy() {
	var loop;
	var tempArray = new Array();
	for (loop = 0; loop < this.length; loop++) {
		tempArray[loop] = this[loop];
	}
	return tempArray;
}

Array.prototype.copy = copy;

function pop() {
	var lastItem = this[this.length-1];
	this.length--;
	return lastItem;
}

Array.prototype.pop = pop;

function push(item) {
	this[this.length] = item;
	return this.length;
}

Array.prototype.push = push;

function concat(secondArray) {
	var firstArray = this.copy();

	for (loop = 0; loop<secondArray.length; loop++) {
		firstArray[firstArray.length] = secondArray[loop];
	}
	return firstArray;
}

Array.prototype.concat = concat;

function shift() {
	var newValue = this[0];
	var origLength = this.length;
	for (loop = 0; loop<this.length-1; loop++) {
		this[loop] = this[loop+1];
	}
	this.length--;
	return newValue;
}

Array.prototype.shift = shift;

function unshift(item) {
	for (loop = this.length-1; loop >= 0; loop--) {
		this[loop+1] = this[loop];
	}
	this[0] = item;
	return this.length;
}

Array.prototype.unshift = unshift;

function permute(theArray) {
	var tempArray = this.copy();
	var newArray = new Array();
	var randomNum = 0;
	for (loop = 0; loop < this.length; loop++) {
		randomNum = Math.round(Math.random() * (tempArray.length-1));
		newArray[loop] = tempArray[randomNum];
		tempArray[randomNum] = tempArray[tempArray.length-1];
		tempArray.length--;
	}
	return newArray;
}

Array.prototype.permute = permute;