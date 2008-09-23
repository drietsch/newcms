/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @subpackage we_app_js
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

 /**
 * mark application entry
 *
 * @return void
 */
function mark() {
	var elem = document.getElementById('mark');
	elem.style.display = 'inline';
}

 /**
 * unmark application entry
 *
 * @return void
 */
function unmark() {
	var elem = document.getElementById('mark');
	elem.style.display = 'none';
}

 /**
 * set the frame size after resizing 
 *
 * @return void
 */
function setFrameSize(){
	if(document.getElementById('we_ui_controls_Tabs_Container').offsetWidth > 0) {
		var fs = parent.document.getElementsByTagName("FRAMESET")[0];
		var tabsHeight = document.getElementById('main').offsetHeight;
		var fsRows = fs.rows.split(',');
		fsRows[0] = tabsHeight;
		fs.rows =  fsRows.join(",");
	} else {
		setTimeout("setFrameSize()",100);
	}
}
 /**
 * var resizeDummy
 */
var resizeDummy = 1;

 /**
 * name of the title path
 */
var titlePathName='';

 /**
 * group of the title path
 */
var titlePathGroup='';
 
 /**
 * set the title path of the entry
 *
 * @static
 * @param {string} group 
 * @param {string} name 
 * @return void
 */
function setTitlePath(group, name){
	if (group){
		titlePathGroup = group;
	}
	if (name){
		titlePathName = name;
	}
	
	var titlePathGroupElem = document.getElementById('titlePathGroup');
	var titlePathNameElem = document.getElementById('titlePathName');
	
	
	if(titlePathGroupElem) {
		if (titlePathGroup ==="") {
			titlePathGroup = titlePathGroupElem.innerHTML
		}
		titlePathGroupElem.innerHTML = titlePathGroup;
	}
	if(titlePathNameElem) {
		if (titlePathName ==="") {
			titlePathName = titlePathNameElem.innerHTML
		}
		titlePathNameElem.innerHTML = titlePathName;
	}
}

 /**
 * set the path name
 *
 * @static
 * @param {string} pathName 
 * @return void
 */
function setPathName(pathName) {
	titlePathName = pathName;
}

 /**
 * set the path group
 *
 * @static
 * @param {string} pathGroup 
 * @return void
 */
function setPathGroup(pathGroup) {
	//DUMMY for compatibility	
	//titlePathGroup = pathGroup;
}