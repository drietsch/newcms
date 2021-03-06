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
htmlTop();
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></SCRIPT>
<script language="JavaScript" type="text/javascript"><!--

//-->
</script>
<?php
	print STYLESHEET;

	$we_button = new we_button();
	?>
	</head>
    <body bgcolor="white" background="/webEdition/images/edit/editfooterback.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
     <form name="we_form" onsubmit="top.content.we_cmd('search',document.we_form.keyword.value); return false;">
        <table border="0" cellpadding="0" cellspacing="0" width="3000">
			<tr>
				<td></td>
				<td colspan="2" valign="top"><img align="absmiddle" height="10" width="1600" src="<?php print IMAGE_DIR ?>pixel.gif"></td>
			</tr>
			<tr>
				<td><img width="5" src="<?php print IMAGE_DIR ?>pixel.gif"></td>
				<td><?php print
				$we_button->create_button_table(array(htmlTextInput("keyword",14,"","","","text",120), $we_button->create_button("image:btn_function_search", "javascript:top.content.we_cmd('search',document.we_form.keyword.value);")), 5);
				?></td>
			</tr>
		</table>
     </form>
	</body>
</html>
