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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/SEEM.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");

protect();

htmlTop();

print STYLESHEET;

$foo = f("SELECT username FROM ".USER_TABLE." WHERE ID=$_userID","username",$DB_WE);


$content = "<p class='defaultfont'>" . sprintf($l_alert["temporaere_no_access_text"], $we_doc->Text, $foo) . "</p>";

?>
<script language="JavaScript" type="text/javascript">
<!--
top.toggleBusy(0);
//-->
</script>
	</head>

    <body class="weDialogBody">
<?php

	print htmlDialogLayout($content,$l_alert["temporaere_no_access"]);

	//	For SEEM-Mode
	if($_SESSION["we_mode"] == "seem"){
		?><a href="javascript://" style="text-decoration:none" onClick="top.weNavigationHistory.navigateReload()" ><?php print $GLOBALS["l_we_SEEM"]["try_doc_again"] ?></a>
		<?php
	}
?>
    </body>
</html>
