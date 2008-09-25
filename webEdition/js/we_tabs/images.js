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