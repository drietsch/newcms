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
protect();
htmlTop("webEdition ".$l_global["modules_and_tools"]);
print we_htmlElement::jsElement('
	function toggleBusy(){
	}
	var makeNewEntry = 0;
	var publishWhenSave = 0;
	var weModuleWindow = true;
');
print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js"));
if(isset($_REQUEST['mod']) && !isset($mod)) {
	$mod = $_REQUEST['mod'];
}
?>
	</head>
	<frameset rows="26,*" border="0" framespacing="0" frameborder="no">;
		<frame src="<?php print WE_MODULE_PATH; ?>navi.php?mod=<?php echo $mod ?>" name="navi" noresize scrolling="no">
		<frame src="<?php print WE_MODULE_PATH; ?>show.php?mod=<?php echo $mod . (empty($_REQUEST["we_cmd"][1]) ? '' : "&msg_param=" . $_REQUEST["we_cmd"][1]) . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : '') . (isset($_REQUEST['bid']) ? '&bid=' . $_REQUEST['bid'] : ''); ?>" name="content" noresize scrolling="no">
	</frameset>
	<body bgcolor="#ffffff"></body>
</html>