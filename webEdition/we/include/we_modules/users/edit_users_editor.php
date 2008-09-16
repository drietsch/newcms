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
   <frameset rows="40,*,40" framespacing="0" border="0" frameborder="no">
    <frame src="<?php print WEBEDITION_DIR."html/"; ?>grayWithTopLine.html" name="user_edheader" noresize scrolling=no>
    <frame src="<?php print WEBEDITION_DIR; ?>we_cmd.php?we_cmd[0]=mod_home&mod=users" name="user_properties" scrolling=auto>
    <frame src="<?php print WEBEDITION_DIR."html/"; ?>gray.html" name="user_edfooter" scrolling=no>

   </frameset>
<noframes>
 <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</noframes>
</html>
