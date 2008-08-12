// TODO: comment

function mark() {
	var elem = document.getElementById('mark');
	elem.style.display = 'inline';
}

function unmark() {
	var elem = document.getElementById('mark');
	elem.style.display = 'none';
}

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

var resizeDummy = 1;
var titlePathName='';
var titlePathGroup='';

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

function setPathName(pathName) {
	titlePathName = pathName;
}

function setPathGroup(pathGroup) {
	// DUMMY for compatibility	
	//titlePathGroup = pathGroup;
}
