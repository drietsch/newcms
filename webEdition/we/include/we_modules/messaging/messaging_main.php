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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");

htmlTop();

?>
	</head>

<?php if ($GLOBALS["BROWSER"] == "NN6"){ ?>
	<frameset cols="180,*" border="1" frameborder="1" id="resizeframeid">
		<frameset rows="0,*" framespacing="0" border="1" frameborder="1">
			<frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no">
			<frame src="<?php print HTML_DIR?>white.html" name="messaging_tree"  scrolling="aoto">
		</frameset>
		<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_right.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="messaging_right">
	</frameset>SAFARI
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="180,*" border="0" frameborder="0" id="resizeframeid">
		<frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
			<frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no" noresize>
			<frame src="<?php print HTML_DIR?>white.html" name="messaging_tree" scrolling="no">
		</frameset>
		<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_right.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="messaging_right">
	</frameset>
<?php } else { //IE ?>
	<frameset cols="180,*" border="0" frameborder="0" id="resizeframeid">
		<frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
			<frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no">
			<frame src="<?php print HTML_DIR?>white.html" name="messaging_tree" scrolling="no" frameborder="0">
		</frameset>
		<frame src="<?php print WE_MESSAGING_MODULE_PATH ?>messaging_right.php?we_transaction=<?php echo $_REQUEST['we_transaction']?>" name="messaging_right">
	</frameset>
<?php } ?>

	<noframes>
		<body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
    	</body>
	</noframes>

</html>