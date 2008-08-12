<html>
<head>
</head>
<body>
<script language="JavaScript" type="text/javascript">
<?php
	
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");

	// build url from REQUEST ...
	$paraStr = we_SEEM::arrayToParameters($_REQUEST, "", array("we_cmd", "original_action") );
	$action = $_REQUEST['original_action'] . "?1" . $paraStr;

    //	The following will translate a given URL to a we_cmd.
    //	When pressing a link in edit-mode this functionality
    //	is needed to reopen the document (if possible) with webEdition
	
	print we_SEEM::getJavaScriptCommandForOneLink("<a href=\"" . str_replace(" ", "+", $action) . "\">");
?>
</script>
</body>
</html>