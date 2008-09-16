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
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
<?php print STYLESHEET; ?>
    </head>
    <?php if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"]):?>
    <frameset rows="1,*,40" framespacing="0" border="0" frameborder="NO">
    <frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no" noresize>
    <frame src="<?php print HTML_DIR?>white.html" name="user_tree" scrolling="auto" noresize>
    <frame src="<?php print WE_USERS_MODULE_PATH; ?>edit_users_search.php" name="user_search" scrolling="no" noresize>
   </frameset>
   <?php else:?>
    <frameset rows="1,*" framespacing="0" border="0" frameborder="NO">
    <frame src="<?php print HTML_DIR?>whiteWithTopLine.html" scrolling="no" noresize>
    <frame src="<?php print HTML_DIR?>white.html" name="user_tree" scrolling="auto" noresize>
   </frameset>
   <?php endif?>
   <noframes>
   <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
   </body>
   </noframes>
</html>
