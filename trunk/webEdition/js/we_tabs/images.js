// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: images.js,v 1.6 2007/05/23 15:39:32 holger.meyer Exp $

var hoveroff    = "_normal";
var hovertab    = "_hover";

var strImgLeft  = "tab_left";
var strImgBg    = "tab_middle";
var strImgRight = "tab_right";

var img_left_hoveroff  = img_path + strImgLeft  + hoveroff + ".gif";
var img_left_hovertab  = img_path + strImgLeft  + suffix + hovertab + ".gif";

var img_bg_hoveroff    = img_path + strImgBg    + hoveroff + ".gif";
var img_bg_hovertab    = img_path + strImgBg    + suffix + hovertab + ".gif";

var img_right_hoveroff = img_path + strImgRight + hoveroff + ".gif";
var img_right_hovertab = img_path + strImgRight + suffix + hovertab + ".gif";

var img_tabline        = img_path + "tab_line.gif";

function getId(path) {
	var pattern=/-/;
	var id = path.substring(path.lastIndexOf("/")+1, path.lastIndexOf("."));
	while (pattern.test(id))
		id = id.replace(pattern, "_");
	return id;
}
function preload() {
	for(var i=0; i < arguments.length; i++) {
		var temp = getId(arguments[i]);
		eval(temp+"=new Image()");
		eval(temp+".src='"+arguments[i]+"'");
	}
}
preload(
	img_left_hoveroff,
	img_left_hovertab,
	img_bg_hoveroff,
	img_bg_hovertab,
	img_right_hoveroff,
	img_right_hovertab,
	img_tabline
);