<?php
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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/versions.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLogView.class.php");

protect();

$versionsLogView = new versionsLogView();
$content = $versionsLogView->getContent();
$out = $versionsLogView->printContent($content);

htmlTop($GLOBALS["l_versions"]["versions_log"]);

print STYLESHEET;

echo '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>';
echo '<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>';

print $versionsLogView->getJS();

$we_button = new we_button();

$closeButton = $we_button->create_button("close", "javascript:window.close();");


?>
<style type="text/css">

#headlineDiv {
	height				: 40px;
}
#headlineDiv div {
	padding				: 10px 0 0 15px;
}

#versionsDiv {
	background			: #fff;
	overflow			: auto;
	height				: 420px ! important;
	margin				: 0px ! important;
}

.dialogButtonDiv {
	left				: 0;
	height				: 40px;
	background-image	: url(/webEdition/images/edit/editfooterback.gif);
	position			: absolute;
	bottom				: 0;
	width				: 100%;
}


</style>

</head>

<body class="weDialogBody">

<div id="headlineDiv">
	<div class="weDialogHeadline">
		<?php print $GLOBALS["l_versions"]["versions_log"] ?>
	</div>
</div>
<div id="versionsDiv">
	<?php 
	
	print $out;
	
	?>
	
</div>
<div class="dialogButtonDiv">
	<div style="position:absolute;top:10px;right:20px;">
		<?php print $closeButton; ?>
	</div>
</div>
</body>
</html>