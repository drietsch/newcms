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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/messageConsole.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

htmlTop($l_messageConsole["headline"]);
print STYLESHEET;

$we_button = new we_button();

$deleteAllButton = $we_button->create_button("delete", "javascript:messageConsoleWindow.removeMessages();");
$closeButton = $we_button->create_button("close", "javascript:window.close();");

$_buttons = $we_button->position_yes_no_cancel(	$deleteAllButton,
												null,
												$closeButton);

?>
<style type="text/css">
#jsMessageUl {
	border-top			: 1px solid black;
	background			: #fff;
	list-style-type		: none;
	margin				: 0;
	padding				: 0;
	
}

#jsMessageUl li {
	border-bottom		: 1px solid black;
	margin				: 0 0 0 0;
	padding				: 8px 0 8px 35px;
	background-repeat	: no-repeat;
	background-position	: 6 50%;
}

#headlineDiv {
	height				: 40px;
}
#headlineDiv div {
	padding				: 10px 0 0 10px;
}

#messageDiv {
	background			: #fff;
	overflow			: auto;
	height				: 420px ! important;
}

.dialogButtonDiv {
	left				: 0;
	height				: 40px;
	background-image	: url(/webEdition/images/edit/editfooterback.gif);
	position			: absolute;
	bottom				: 0;
	width				: 100%;
}

li.msgNotice {
	background			: url(/webEdition/images/messageConsole/noticeActive.gif);
	color				: black;
}
li.msgWarning {
	background			: url(/webEdition/images/messageConsole/warningActive.gif);
	color				: darkgray;
}
li.msgError {
	background			: url(/webEdition/images/messageConsole/errorActive.gif);
	color				: red;
}
</style>
<script type="text/javascript" src="<?php print JS_DIR; ?>messageConsoleImages.js"></script>
<script type="text/javascript" src="<?php print JS_DIR; ?>messageConsoleWindow.js"></script>

</head>

<body onload="messageConsoleWindow.init();" onunload="messageConsoleWindow.remove();" class="weDialogBody" style="overflow:hidden;">



<div id="headlineDiv">
	<div class="weDialogHeadline">
		<?php print $l_messageConsole["headline"] ?>
	</div>
</div>
<div id="messageDiv">
	<ul id="jsMessageUl"></ul>
</div>
<div class="dialogButtonDiv">
	<div style="padding: 10px 10px 0 0;">
		<?php print $_buttons; ?>
	</div>
</div>
</body>
</html>