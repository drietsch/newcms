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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");

protect();

htmlTop();

print STYLESHEET;

$content = "<p class=\"defaultfont\">" . $l_alert["noResource"] . "</p>";

?>
<script language="JavaScript" type="text/javascript">
top.toggleBusy(0);
var _EditorFrame = top.weEditorFrameController.getEditorFrame(window.name);
_EditorFrame.setEditorIsLoading(false);
</script>
</head>

<body class="weDialogBody">
<?php
print htmlDialogLayout($content, $l_alert["noResourceTitle"]);
?>
    </body>
</html>
