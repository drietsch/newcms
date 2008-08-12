<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

header("Content-Type: text/css");
$show_stylesheet = true;

// Activate the webEdition error handler
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");

if (isset($_REQUEST["WE_LANGUAGE"]) && $_REQUEST["WE_LANGUAGE"] != "") {
	$GLOBALS["WE_LANGUAGE"] = $_REQUEST["WE_LANGUAGE"];
} else {
	$GLOBALS["WE_LANGUAGE"] = WE_LANGUAGE;
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/css/css.inc.php");

?>

.weSelect {
	border: #AAAAAA solid 1px;
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.wetextinput {
	color: black;
	border: #AAAAAA solid 1px;
	height: 20px;
	<?php print ($BROWSER == "IE") ? "" : "line-height: 18px;"; ?>
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.wetextinput[disabled] {
	background-color: #EEEEEE;
}

.weMarkInputError {background-color: #ff8888 ! important;}

.wetextinputselected {
	color: black;
	border: #888888 solid 1px;
	background-color: #dce6f2;
	height: 20px;
	<?php print ($BROWSER == "IE") ? "" : "line-height: 18px;"; ?>
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}


.wetextarea {
	color: black;
	border: #AAAAAA solid 1px;
	height: 80px;
	<?php print ($BROWSER == "IE") ? "" : "line-height: 18px;"; ?>
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.wetextareaselected {
	color: black;
	border: #888888 solid 1px;
	background-color: #dce6f2;
	height: 80px;
	<?php print ($BROWSER == "IE") ? "" : "line-height: 18px;"; ?>
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.multichooser {
	background-color:white;
	border: 1px gray solid;
}


body {
	letter-spacing: normal ! important;
}

.defaultfont {
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.defaultfont a {
	color: black;
}

.defaultfont a:visited {
	color: black;
}

.defaultfont a:active {
	color: #006DB8;
}

.objectDescription {
	padding: 4px 0 4px 0;
}

.npdefaultfont {
	color: red;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.npdefaultfont a {
	color: red;
}

.npdefaultfont a:visited {
	color: red;
}

.npdefaultfont a:active {
	color: #006DB8;
}

.shopContentfont {
	vertical-align: top;
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:center;
}
.shopContentfontSmall {
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "9px" : (($SYSTEM == "X11") ? "11px" : "10px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:center;
}
.shopContentfontAlert {
	color: #800000;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:left;
}
.shopContentfontGreySmall {
	color: #666666;
	font-size: <?php print ($SYSTEM == "MAC") ? "9px" : (($SYSTEM == "X11") ? "11px" : "10px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:left;

}
.shopContentfontR {
	vertical-align: top;
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:right;
}
.shopContentfontGR {
	color: #666666;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:right;
}
.npshopContentfontR {
	color: red;
}
.npshopContentfont {
	color: red;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:center;
}
.npshopContentfont a {
	color: red;
}

.npshopContentfont a:visited {
	color: red;
}

.npshopContentfont a:active {
	color: #006DB8;
}
.pshopContentfontR {
	color: green;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:right;

}
.pshopContentfont {
	color: green;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	text-align:center;

}
.pshopContentfont a {
	color: green;

}

.pshopContentfont a:visited {
	color: green;

}

.pshopContentfont a:active {
	color: #006DB8;

}
.pdefaultfont {
	color: green;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;

}

.pdefaultfont a {
	color: green;

}

.pdefaultfont a:visited {
	color: green;

}

.pdefaultfont a:active {
	color: #006DB8;

}






.middlefont {
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;

}

.middlefont a {
	color: black;
}

.middlefont a:visited {
	color: black;
}

.middlefont a:active {
	color: #006DB8;
}



.middlefontgray {
	color: #666666;
	font-size: <?php print ($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;

}

.middlefontgray a {
	color: #666666;
}

.middlefontgray a:visited {
	color: #666666;
}

.middlefontgray a:active {
	color: #006DB8;
}



.middlefontred {
	color: red;
	font-size: <?php print ($SYSTEM == "MAC") ? "10px" : (($SYSTEM == "X11") ? "12px" : "11px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.middlefontred a {
	color: red;
}

.middlefontred a:visited {
	color: red;
}

.middlefontred a:active {
	color: #006DB8;
}



.defaultgray {
	color: #666666;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.defaultgray a {
	color: #666666;
}

.defaultgray a:visited {
	color: #666666;
}

.defaultgray a:active {
	color: #006DB8;
}



.small {
	color: black;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "9px" : (($SYSTEM == "X11") ? "11px" : "9px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.header_small {
	color: #006699;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "11px" : (($SYSTEM == "X11") ? "10px" : "10px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}


.header_shop {
	color: #006699;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "11px" : (($SYSTEM == "X11") ? "11px" : "11px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	background-image: url(/webEdition/we/include/we_modules/shop/images/shopInfast.gif);
      background-position: bottom left;
      background-repeat: no-repeat;
}

.shop_th {
	color: #000000;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "12px" : (($SYSTEM == "X11") ? "12px" : "12px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	padding-bottom:5px;
	font-weight:bold;
}

.shop_fontView {
	color: #666666;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "12px" : (($SYSTEM == "X11") ? "12px" : "12px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}



.big {
	color: black;
	text-align: left;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "14px" : (($SYSTEM == "X11") ? "15px" : "13px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;

}



.header {
	color: black;
	font-weight: bold;
	font-size: 20px;
	font-family: <?php print $l_css["font_family"]; ?>;
}



.tree {
	color: black;
	font-size: <?php print ($BROWSER == "NN" && ($SYSTEM == "WIN") ? "10px" : (($SYSTEM == "X11") ? "11px" : "9px")); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.tree a {
	text-decoration:none;
}



.selector {
	color: black;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.selector a {
	text-decoration:none;
}



.tableHeader {
	color: #ffffff;
	font-weight: bold;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.tableHeader a {
	color: #ffffff;
	text-decoration:none;
}

.tableHeader a:visited {
	color: #ffffff;
}

.tableHeader a:active {
	color: #ff0000;
}



.todo_hist_hdr {
	color: #006DB8;
}



.defaultfontred {
	color: #6CBFF9;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
}

.blockWrapper {
	overflow: auto !important;
	display: block ;
	background-color: white;
	padding: 0px;
}

.weDefaultStyle{
	background: transparent;
	background-color: transparent;
	background-image: url(/webEdition/images/pixel.gif);
	border: 0px;
	color: #000000;
	cursor: default;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: normal;
	margin: 0px;
	padding:0px;
	text-align: left;
	text-decoration: none;
}

.navigation_normal{
	padding: 1px;
	margin: 0px;
}

.navigation_hover{
	margin: 0px;
	border-bottom:	#000000 solid 1px;
	border-left:	#CCCCCC solid 1px;
	border-right:	#000000 solid 1px;
	border-top:		#CCCCCC solid 1px;
	cursor:pointer;
}

optgroup{
  font-weight: bold;
  font-style: normal;
}

optgroup.lvl1{
  color: darkblue;
}

optgroup.lvl2{
  margin-left: 10px;
}


/*	Following: styles for accessibility	*/
.weHide{
	display:none;
}

.weDialogHeadline {
	color: #000000;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: bold;
}


.weMultiIconBoxHeadline {
	color: #6078A2;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: bold;
}

.weMultiIconBoxHeadlineThin {
	color: #6078A2;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: normal;
}

.weMultiIconBoxHeadline a {
	color: #6078A2;
}

.weDialogBody {
	margin: 0;
	padding: 0;
	background-color: #EDEDED;
}

.weEditorBody {
	margin: 0;
	padding: 10px 0px;
	background-color: #EDEDED;
}

.weDialogButtonsBody {
	margin: 0;
	padding: 10px 10px;
	background-color: #EDEDED;
	background-image: url(/webEdition/images/edit/editfooterback.gif);
}

.weTreeHeader {
	background-image: url(/webEdition/images/backgrounds/bgGrayLineTop.gif);
	margin:0;
	padding: 10px 10px;
	border-bottom: 1px solid black;
	height:129px;
}


.weTreeHeaderMove {
	background-image: url(/webEdition/images/backgrounds/bgGrayLineTop.gif);
	margin:0;
	padding: 10px 10px;
	border-bottom: 1px solid black;
	height:139px;
}

.weObjectPreviewHeadline {
	color: #6078A2;
	font-size: <?php print ($SYSTEM == "MAC") ? "11px" : (($SYSTEM == "X11") ? "13px" : "12px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: bold;
	margin-bottom:3px;
}

.weSidebarBody {
	background	: #ffffff url(/webEdition/images/backgrounds/sidebarBackground.gif) no-repeat fixed bottom right;
	margin		: 5px;
	padding		: 0px;
}

.weDocListSearchHeadline {
	color: #6078A2;
	font-size: <?php print ($SYSTEM == "MAC") ? "13px" : (($SYSTEM == "X11") ? "15px" : "14px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: bold;
	margin-top:6px;
}
.weDocListSearchHeadlineDivs {
	color: #6078A2;
	font-size: <?php print ($SYSTEM == "MAC") ? "13px" : (($SYSTEM == "X11") ? "15px" : "14px"); ?>;
	font-family: <?php print $l_css["font_family"]; ?>;
	font-weight: bold;
}
