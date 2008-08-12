<script language="JavaScript" type="text/javascript">
<?php
	
	// $_REQUEST["we_cmd"][1] is the url
	
    //	The following will translate a given URL to a we_cmd.
    //	When pressing a link in edit-mode this functionality
    //	is needed to reopen the document (if possible) with webEdition
    
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");
	print we_SEEM::getJavaScriptCommandForOneLink("<a href=\"" . $_REQUEST["we_cmd"][1] . "\">");
?>
</script>