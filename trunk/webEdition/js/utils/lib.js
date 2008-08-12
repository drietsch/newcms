// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: lib.js,v 1.6 2007/05/23 15:39:32 holger.meyer Exp $

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