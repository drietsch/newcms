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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browser_check.inc.php");

if(($SYSTEM == "MAC" && $BROWSER == "IE") || $BROWSER="NN"){
	$mheight = "marginheight=4 topMargin=4";
}else{
	$mheight = "marginheight=1 topMargin=1";
}

?>
<HTML>
<?php print WE_DEFAULT_HEAD."\n" . STYLESHEET; ?>
<BODY bgcolor="white" background="<?php print EDIT_IMAGE_DIR ?>editfooterback.gif" <?php print $mheight ?> topMargin=1 leftMargin=0>
	<div id="infoField" style="margin:5px; display: none;" class="defaultfont"></div>
	<form name="we_form" onsubmit="top.we_cmd('tool_weSearch_edit',document.we_form.keyword.value, top.treeData.table); return false;">
		<div id="search" style="margin: 10px 0 0 10px;">
			<?php
			$we_button=new we_button();
			print $we_button->create_button_table(
					array(
						htmlTextInput('keyword',10,(isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : ''),'','','text','120px'),
						$we_button->create_button('image:btn_function_search', "javascript:top.we_cmd('tool_weSearch_edit',document.we_form.keyword.value, top.treeData.table);",true,40)
					)
			);
			?>
		</div>
	</form>
</BODY>
</HTML>
