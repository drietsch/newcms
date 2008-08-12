<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/we_class.inc.php");

protect();
$ok = false;

if($_SESSION["perms"]["ADMINISTRATOR"]){
	$we_transaction = $_REQUEST["we_cmd"][1];
	// init document
	$we_dt = $_SESSION["we_data"][$we_transaction];

	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

	$ok = $we_doc->changeLanguageRecursive();
	
}

htmlTop();
?>
<script language="JavaScript" type="text/javascript"><!--
	<?php
	
	if ($ok) {
		print we_message_reporting::getShowMessageCall($GLOBALS["l_we_class"]["grant_language_ok"], WE_MESSAGE_NOTICE);
	} else {
		print we_message_reporting::getShowMessageCall($GLOBALS["l_we_class"]["grant_language_notok"], WE_MESSAGE_ERROR);
	}
	?>
//-->
</script>
</head>

<body>
</body>

</html>