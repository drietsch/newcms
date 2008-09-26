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
