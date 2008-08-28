<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

protect();
htmlTop();

$table = isset($table) ? $table : FILE_TABLE;
?>
<script language="JavaScript" type="text/javascript">
function we_cmd(){
	var args = "";
	for(var i = 0; i < arguments.length; i++){
		args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
	}
	eval('parent.we_cmd('+args+')');
}

</script>
</head>

<frameset cols="24,*" framespacing="0" border="0" frameborder="NO" onload="top.start()">
	<frame src="<?php print WEBEDITION_DIR ?>we_vtabs.php" name="bm_vtabs"  scrolling="no" noresize>
	<frameset id="treeHeadFrame" rows="1,*,40" framespacing="0" border="0" frameborder="NO">
		<frame src="<?php print HTML_DIR ?>frameheader.html" name="treeheader" scrolling="NO" noresize>
		<frame src="treeMain.php" name="bm_main"">
		<frame src="treeInfo.php" name="infoFrame" scrolling="NO">
	</frameset>
</frameset>

<noframes>
	<body>
	</body>
</noframes>

</html>