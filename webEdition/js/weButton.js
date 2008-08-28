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

function weButton() {}

weButton.down = function(el){
	if (el.className != "weBtnDisabled"){
		var tds = el.getElementsByTagName("TD");
		el.className = "weBtnClicked";
		tds[0].className = "weBtnLeftClicked";
		tds[1].className = "weBtnMiddleClicked";
		tds[2].className = "weBtnRightClicked";
	}
}


weButton.up = function(el){
	if (el.className != "weBtnDisabled") {
		weButton.out(el);
		return true;
	}
	return false;
}


weButton.out = function(el){
	if (el.className != "weBtnDisabled" && el.className != "weBtn") {
		var tds = el.getElementsByTagName("TD");
		el.className = "weBtn";
		tds[0].className = "weBtnLeft";
		tds[1].className = "weBtnMiddle";
		tds[2].className = "weBtnRight";
	}
}


weButton.disable = function(id){
	var el = document.getElementById(id);
	if(el != null){
		el.className = "weBtnDisabled";
		var tds = el.getElementsByTagName("TD");
		tds[0].className = "weBtnLeftDisabled";
		tds[1].className = "weBtnMiddleDisabled";
		tds[2].className = "weBtnRightDisabled";
		var img = document.getElementById(el.id + "_img");
		if(img != null && img.src.indexOf("Disabled.gif") == -1){
			img.src = img.src.replace(/\.gif/, "Disabled.gif");
		}
	}
}


weButton.enable = function(id){
	var el = document.getElementById(id);
	if(el != null){
		el.className = "weBtn";
		var tds = el.getElementsByTagName("TD");
		tds[0].className = "weBtnLeft";
		tds[1].className = "weBtnMiddle";
		tds[2].className = "weBtnRight";
		var img = document.getElementById(el.id + "_img");
		if(img != null){
			img.src = img.src.replace(/\Disabled.gif/, ".gif");
		}
	}
}


weButton.hide = function(id){
	var el = document.getElementById(id);
	if(el != null){
		el.style.display = "none";
	}
}


weButton.show = function(id){
	var el = document.getElementById(id);
	if(el != null){
		el.style.display = "block";
	}
}


weButton.isDisabled = function(id) {
	var el = document.getElementById(id);
	if(el != null && el.className == "weBtnDisabled") {
		return true

	} else {
		return false;

	}

}


weButton.isEnabled = function(id) {
	return !this.isDisabled(id);

}