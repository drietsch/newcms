
<script language="JavaScript" type="text/javascript"><!--
var _EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction("<?php print $GLOBALS['we_transaction']; ?>");
var _EditorFrameDocumentRef = _EditorFrame.getDocumentReference();
<?php print $we_JavaScript ?>;
<?php if($we_responseText): ?>top.toggleBusy(0);<?php print we_message_reporting::getShowMessageCall($we_responseText, $we_responseTextType); endif ?>
<?php 
protect();
if(isset($_REQUEST["we_cmd"][5]) && $_REQUEST["we_cmd"][5] != "") {
	print $_REQUEST["we_cmd"][5];
}
?>
top.toggleBusy(0);
//-->
</script>