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

<?php if ($GLOBALS["BROWSER"] == "NN6")	{ ?>
	<frameset cols="*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_editor.php" scrolling="no" noresize name="user_editor">
	</frameset>
<?php } else if($GLOBALS["BROWSER"] == "SAFARI") { ?>
	<frameset cols="1,*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print HTML_DIR; ?>safariResize.html" name="user_separator" noresize scrolling="no">
        <frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_editor.php" noresize name="user_editor" scrolling="no">
	</frameset>
<?php } else { ?>
	<frameset cols="2,*" framespacing="0" border="0" frameborder="NO">
        <frame src="<?php print HTML_DIR; ?>ieResize.html" name="user_separator" noresize scrolling="no">
        <frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_editor.php" noresize name="user_editor" scrolling="no">
	</frameset>
<?php } ?>
	<noframes>
    <body bgcolor="#ffffff">
		<p></p>
	</body>
	</noframes>
</html>

