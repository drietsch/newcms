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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

protect();

htmlTop();

print STYLESHEET;

$content = "<p class=\"defaultfont\">".$l_alert["noResource"]."</p>";

?>
<script language="JavaScript" type="text/javascript">
top.toggleBusy(0);
var _EditorFrame = top.weEditorFrameController.getEditorFrame(window.name);
_EditorFrame.setEditorIsLoading(false);
</script>
	</head>

    <body class="weDialogBody">
<?php
print htmlDialogLayout($content,$l_alert["noResourceTitle"] );
?>
    </body>
</html>
