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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

htmlTop($l_global["question"]);

$_we_cmd6 = "";
if (isset($_REQUEST["we_cmd"][6])) {
	$_we_cmd6 = $_REQUEST["we_cmd"][6];
	
}

if ($nrTemplatesUsedByThisTemplate) {
	$alerttext = $l_alert["template_save_warning2"];
} else {
	$alerttext = sprintf((($nrDocsUsedByThisTemplate==1) ? $l_alert["template_save_warning1"] : $l_alert["template_save_warning"]),$nrDocsUsedByThisTemplate);
}
?>
<script type="text/javascript" src="<?php print JS_DIR; ?>keyListener.js"></script>
<script language="JavaScript" type="text/javascript">

// functions for keyBoard Listener
	function applyOnEnter() {
		pressed_yes_button();
	
	}
	
	// functions for keyBoard Listener
	function closeOnEscape() {
		pressed_cancel_button();
		
	}

function pressed_yes_button() {
	opener.top.we_cmd('save_document','<?php print $we_transaction; ?>',0,1,1,'<?php print str_replace("'","\\'",$_REQUEST["we_cmd"][5]); ?>',"<?php print $_we_cmd6; ?>");
	opener.top.toggleBusy(1);
	self.close();

}

function pressed_no_button() {
	opener.top.we_cmd('save_document','<?php print $we_transaction; ?>',0,1,0,'<?php print str_replace("'","\\'",$_REQUEST["we_cmd"][5]) ?>',"<?php print $_we_cmd6; ?>");
	opener.top.toggleBusy(1);
	self.close();
	
}

function pressed_cancel_button() {
	self.close();
	opener.top.toggleBusy(0);
	
}
self.focus();

</script>
<?php print STYLESHEET; ?>
	</head>
	<body class="weEditorBody" onBlur="self.focus()">
	  <?php print htmlYesNoCancelDialog($alerttext,IMAGE_DIR."alert.gif",true,true,true,"pressed_yes_button()","pressed_no_button()","pressed_cancel_button()"); ?>
	</body>

</html>
