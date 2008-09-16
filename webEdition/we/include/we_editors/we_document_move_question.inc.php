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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

htmlTop($l_global["question"]);

$yesCmd = "url = '" . WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_filter';new jsWindow(url,'templateMoveQuestion',-1,-1,600,135,true,false,true);opener.top.toggleBusy(1);self.close();";
$noCmd = "self.close();opener.top.toggleBusy(0);";
$cancelCmd = "self.close();opener.top.toggleBusy(0);";

$alerttext = $l_alert["document_move_warning"];

?>
<script language="JavaScript" type="text/javascript" src="<?php echo JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
self.focus();
//-->
</script>
<?php print STYLESHEET; ?>
	</head>
	<body class="weEditorBody" onBlur="self.focus()">
	  <?php print htmlYesNoCancelDialog($alerttext,IMAGE_DIR."alert.gif",true,true,true,$yesCmd,$noCmd,$cancelCmd); ?>
	</body>

</html>
