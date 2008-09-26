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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/users/we_users.inc.php");
?>
<?php
	print STYLESHEET;

	$we_button = new we_button();
?>
<?php
     if(isset($_SESSION["user_session_data"])){
         $user_object=new we_user();
         $user_object->setState($_SESSION["user_session_data"]);
     }
?> 
	</head>
    <?php if(isset($user_object)):?> 
	<body bgcolor="white" background="/webEdition/images/edit/editfooterback.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">    
     <table border="0" cellpadding="0" cellspacing="0" width="3000">
			<tr>
				<td></td>
				<td valign="top"><img align="absmiddle" height="10" width="1600" src="<?php print IMAGE_DIR ?>pixel.gif"></td>
			</tr>
			<tr>
				<td width="16"></td>
				<td><?php print $we_button->create_button("save", "javascript:top.content.we_cmd('save_user');"); ?></td>
			</tr>
		</table>
    
	</body>
    <?php endif?> 
</html>

