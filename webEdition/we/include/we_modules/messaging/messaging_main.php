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