<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */
	
header("Content-type: text/css");


if(eregi("X11",$_SERVER["HTTP_USER_AGENT"])) {

	$System = "X11";
} else if(eregi("Win",$_SERVER["HTTP_USER_AGENT"])) {
	$System = "WIN";

} else if(eregi("Mac",$_SERVER["HTTP_USER_AGENT"])) {
	$System = "MAC";

} else {
	$System = "UNKNOWN";

}

?>
body {
	background-color	: #378AC7;
	padding				: 0px;
	margin				: 0px;
	font-size			: 12px;
	font-family			: Verdana, Arial, Helvetica, sans-serif;
}

#leWizardTitle {
	position			: absolute;
	height				: 30px;
	width				: 890px;
	margin				: -338px 0px 0px -435px;
	top					: 50%;
	left				: 50%;
	overflow			: hidden;
	color				: #ffffff;
	font-style			: italic;
	font-weight			: bold;
	font-size			: <?php print ($System == "MAC") ? "22px" : (($System == "X11") ? "24px" : "23px"); ?>;
	line-height			: <?php print ($System == "MAC") ? "24px" : (($System == "X11") ? "26px" : "25px"); ?>;
	z-index				: 3;
}

#leWizardStatus {
	position			: absolute;
	height				: 50px;
	width				: 890px;
	margin				: -290px 0px 0px -435px;
	top					: 50%;
	left				: 50%;
	overflow			: hidden;
	font-size			: <?php print ($System == "MAC") ? "9px" : (($System == "X11") ? "11px" : "10px"); ?>;
	line-height			: <?php print ($System == "MAC") ? "15px" : (($System == "X11") ? "17px" : "16px"); ?>;
	z-index				: 3;
}

#leWizard {
	position			: absolute;
	height				: 600px;
	width				: 890px;
	margin				: -274px 0px 0px -445px;
	top					: 50%;
	left				: 50%;
	overflow			: hidden;
	z-index				: 3;
}

#leWizardBorderLeft {
	float 				: left;
	width				: 9px;
	height				: 602px;
	background-image	: url('/webEdition/images/first_steps_wizard/left.gif');
	z-index				: 3;
}

#leWizardContentLeft {
	padding				: 10px 0px 22px 22px;
	float 				: left;
	width				: 585px;
	height				: 570px;
	background-color	: #ffffff;
	z-index				: 3;
}

#leWizardHeadline {
	margin				: 0px 0px 0px 0px;
	padding				: 0px;
	width				: 585px;
	height				: 52px;
	line-height			: 52px;
	vertical-align		: bottom;
	overflow			: hidden;
	border-width		: 0px 0px 1px 0px;
	border-style		: none none solid none;
	border-color		: #000000;
	color				: #378AC7;
	text-transform		: uppercase;
	font-size			: <?php print ($System == "MAC") ? "18px" : (($System == "X11") ? "20px" : "19px"); ?>;
	z-index				: 3;
}

#leWizardContent {
	float				: left;
	margin				: 10px 0px 15px 0px;
	padding				: 0px;
	width				: 575px;
	height				: 475px;
	background-color	: #ffffff;
	overflow			: auto;
	z-index				: 3;
}

#leWizardPostContent {
	float				: left;
	margin				: 0px 10px 15px 0px;
	padding				: 0px;
	width				: 565px;
	height				: 30px;
	overflow			: hidden;
	z-index				: 3;
}

#leWizardProgress {
	float				: left;
	margin				: 4px 20px 0px 0px;
	width				: 500px;
	display				: block;
	z-index				: 3;
}

#function_reload {
	float				: right;
	margin				: 0px 0px 0px 0px;
	z-index				: 3;
}

#leWizardContentRight {
	padding				: 10px 22px 22px 0px;
	float 				: left;
	width				: 243px;
	height				: 570px;
	background-color	: #f1f6fb;
	z-index				: 3;
}

#leWizardEmoticon {
	margin				: 0px;
	padding				: 0px;
	width				: 243px;
	height				: 52px;
	line-height			: 52px;
	font-weight			: bold;
	vertical-align		: bottom;
	overflow			: hidden;
	border-width		: 0px 0px 1px 0px;
	border-style		: none none solid none;
	border-color		: #000000;
	background-image	: url('/webEdition/images/first_steps_wizard/emoticon.gif');
	background-position	: right;
	background-repeat	: no-repeat;
	z-index				: 3;
}

#leWizardDescription {
	float				: left;
	margin				: 10px 0px 15px 10px;
	padding				: 0px;
	width				: 233px;
	height				: 475px;
	overflow			: hidden;
	text-align			: left;
	overflow			: hidden;
	color				: #000000;
	font-size			: <?php print ($System == "MAC") ? "9px" : (($System == "X11") ? "11px" : "10px"); ?>;
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	line-height			: <?php print ($System == "MAC") ? "15px" : (($System == "X11") ? "17px" : "16px"); ?>;
	z-index				: 3;
}

#back {
	float				: left;
	margin				: 0px 0px 0px 10px;
	z-index				: 3;
}

#next {
	float				: left;
	margin				: 0px 0px 0px 20px;
	z-index				: 3;
}

#leWizardBorderRight {
	float 				: left;
	width				: 9px;
	height				: 602px;
	background-image	: url('/webEdition/images/first_steps_wizard/right.gif');
	z-index				: 3;
}



/**
 *	Fonts
 */
.defaultfont {
	color				: #000000;
	font-size			: <?php print ($System == "MAC") ? "9px" : (($System == "X11") ? "11px" : "10px"); ?>;
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	line-height			: <?php print ($System == "MAC") ? "15px" : (($System == "X11") ? "17px" : "16px"); ?>;
}

.defaultfont a {
	color				: #000000;
}

.defaultfont a:visited {
	color				: #000000;
}

.defaultfont a:active {
	color				: #006DB8;
}



#leWizardContent .table {
	width				: 550px;
	color				: #000000;
	font-size			: <?php print ($System == "MAC") ? "9px" : (($System == "X11") ? "11px" : "10px"); ?>;
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	line-height			: <?php print ($System == "MAC") ? "15px" : (($System == "X11") ? "17px" : "16px"); ?>;
}

#leWizardContent .cell {
	width				: 263px;
	padding				: 5px;
	border				: 1px solid #FFFFFF;
	background-color	: #FFFFFF;
}

#leWizardContent .cellspacer {
	width				: 263px;
	height				: 10px;
}

#leWizardContent .cellselected {
	width				: 263px;
	padding				: 5px;
	border				: 1px solid #D3E2F7;
	background-color	: #F1F6FB;
}

#leWizardContent .cellover {
	width				: 263px;
	padding				: 5px;
	border				: 1px solid #D3E2F7;
	background-color	: #ffffff;
}

#leWizardContent .screenshotborder {
	width				: 263px;
	align				: center;
	border				: 1px solid #000000;
}

#leWizardContent .screenshot  {
	align				: center;
}


#leWizardPreviewContainer {
	display				: none;
	position			: absolute;
	margin				: 0px;
	top					: 0;
	left				: 0;
	width				: 100%;
	height				: 100%;
	filter				: Alpha(opacity=50);
	-moz-opacity		: 0.5;
	opacity				: 0.5;
	z-index				: 1;
	background-color	: #000000;
}

#leWizardPreview {
	display				: none;
	position			: absolute;
	margin				: 0px;
	padding				: 5px;
	top					: 50%;
	left				: 50%;
	height				: 0px;
	width				: 0px;
	z-index				: 2;
	background-color	: #FFFFFF;
	border-width		: 2px;
	border-style		: solid;
	border-color		: #000000;
}

#leWizardPreviewText {
	height				: 50px;
	overflow			: auto;
	margin				: 5px;
	padding				: 5px;
}

#leWizardPreviewImageContainer {
}

#direction_left {
	float				: left;
	margin				: 0px 0px 0px 0px;
}

#direction_right {
	float				: left;
	margin				: 0px 0px 0px 0px;
}

#close {
	float				: right;
}