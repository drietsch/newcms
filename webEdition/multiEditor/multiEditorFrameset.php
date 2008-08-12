<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

protect();

$cols = array();
$frames = "";

for ($i=0;$i<MULTIEDITOR_AMOUNT;$i++) {
	
	$cols[] = "*";
	$frames .= '	<frame src="about:blank" name="multiEditFrame_' . $i . '" id="multiEditFrame_' . $i . '"  noresize />'."\n";
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
</script>

</head>
<frameset id="multiEditorFrameset" cols="<?php print implode(",", $cols); ?>" border="0" frameborder="no" framespacing="0" noresize>
<?php

print $frames;

?>
</frameset>
</html>