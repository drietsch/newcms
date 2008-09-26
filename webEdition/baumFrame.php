<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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