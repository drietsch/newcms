<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

protect();

$_cmd_string = '';

if (isset($_REQUEST['SEEM_edit_include']) && $_REQUEST['SEEM_edit_include']) {
	for ($i=1; $i<4; $i++) {
		$_cmd_string .= ",'" . $_REQUEST['we_cmd'][$i] . "'";

	}
	$_cmd_string .= ",'SEEM_edit_include'";
}

?><html>
<head>
<script type="text/javascript">
	function we_cmd(){
		var args = "";
		for(var i = 0; i < arguments.length; i++){
			args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
		}
		eval('parent.we_cmd('+args+')');
	}

	function doSafariLoad() {
		window.frames["multiEditorDocumentControllerFrame"].document.location = "<?php print WEBEDITION_DIR ?>/multiEditor/EditorFrameController.php";

	}

	function startMultiEditor() {
		we_cmd('start_multi_editor'<?php print $_cmd_string; ?>);

	}

</script>
</head>
<?php if ($GLOBALS["BROWSER"] == "NN6")	{ ?>
<frameset cols="*" framespacing="0" border="0" frameborder="NO">

	<frameset onload="startMultiEditor();" rows="22,*,0" id="multiEditorContainer">
		<frame name="multiEditorDocumentTabsFrame" id="multiEditorDocumentTabsFrame" scrolling="No" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiTabs.php" />
		<frame name="multiEditorEditorFramesets" id="multiEditorEditorFramesets" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiEditorFrameset.php" />
		<frame name="multiEditorDocumentControllerFrame" id="multiEditorDocumentControllerFrame" src="<?php print WEBEDITION_DIR ?>/multiEditor/EditorFrameController.php" />
	</frameset>

</frameset>

<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
<frameset cols="1,*,1" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print HTML_DIR ?>safariResize.html" name="bm_resize" scrolling="no" noresize>

	<frameset rows="22,*,0" id="multiEditorContainer"  border="0" frameborder="NO">
		<frame name="multiEditorDocumentTabsFrame" id="multiEditorDocumentTabsFrame" scrolling="No" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiTabs.php" />
		<frame onload="doSafariLoad();" name="multiEditorEditorFramesets" id="multiEditorEditorFramesets" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiEditorFrameset.php" />
		<frame onload="startMultiEditor();" name="multiEditorDocumentControllerFrame" id="multiEditorDocumentControllerFrame" />
	</frameset>
	<frame src="<?php print HTML_DIR ?>whiteWithLeftLine.html" name="bm_resize" scrolling="no" noresize>

</frameset>
<?php } else { ?>
<frameset cols="2,*,2" framespacing="0" border="0" frameborder="NO">
	<frame src="<?php print HTML_DIR ?>ieResize.html" name="bm_resize" scrolling="no" noresize>
	<frameset onload="startMultiEditor();" rows="22,*,0" border="1" id="multiEditorContainer" noresize>
		<frame name="multiEditorDocumentTabsFrame" id="multiEditorDocumentTabsFrame" scrolling="No" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiTabs.php" noresize />
		<frame name="multiEditorEditorFramesets" id="multiEditorEditorFramesets" src="<?php print WEBEDITION_DIR ?>/multiEditor/multiEditorFrameset.php" />
		<frame name="multiEditorDocumentControllerFrame" id="multiEditorDocumentControllerFrame" src="<?php print WEBEDITION_DIR ?>/multiEditor/EditorFrameController.php" />
	</frameset>
	<frame src="<?php print HTML_DIR ?>ieResize.html" name="bm_resize" scrolling="no" noresize>
</frameset>
<?php } ?>




</html>