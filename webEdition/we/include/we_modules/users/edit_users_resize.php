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
  include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");

  htmlTop();
?>
</head>

<?php if ($GLOBALS["BROWSER"] == "NN6"){ ?>
	<frameset cols="170,*" border="1" id="resizeframeid">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_left.php" name="user_left" scrolling="no">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_right.php" name="user_right">
	</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="170,*" framespacing="0" border="0" frameborder="0" id="resizeframeid">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_left.php" name="user_left" scrolling="no">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_right.php" name="user_right">
	</frameset>
<?php } else { //IE ?>
	<frameset cols="170,*" framespacing="0" border="0" frameborder="0" id="resizeframeid">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_left.php" name="user_left" scrolling="no" frameborder="0">
		<frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_right.php" name="user_right">
	</frameset>
<?php } ?>
<noframes>
 <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</noframes>
</html>
