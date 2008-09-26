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

define("WE_EDIT_IMAGE",true);

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

htmlTop();

if(isset($_REQUEST["we_cmd"][0]) && substr($_REQUEST["we_cmd"][0],0,15) == "doImage_convert"){
	print '<script language="JavaScript" type="text/javascript">parent.frames[0].we_setPath("'.$we_doc->Path.'","' . $we_doc->Text . '");</script>'."\n";
}

?>

	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>

<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php");

	print STYLESHEET;

?>
</head>

<body class="weEditorBody" style="padding:20px;">

	<form name="we_form" method="post" onsubmit="return false;">
		<?php $we_doc->pHiddenTrans(); ?>
		<?php
				$_headline = $GLOBALS["l_we_class"]["image"];
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_image_edit.class.php");

				$_gdtype = $we_doc->getGDType();

				$editselect = '<select name="editmenue" size="1" onchange="var cmnd = this.options[this.selectedIndex].value; if(cmnd){if(cmnd==\'doImage_convertPNG\' || cmnd==\'doImage_convertGIF\'){_EditorFrame.setEditorIsHot(true);};we_cmd(cmnd,\''.$we_transaction.'\');}this.selectedIndex=0"'.(($we_doc->getElement("data") && we_image_edit::is_imagetype_read_supported($_gdtype) && we_image_edit::gd_version() > 0) ? "" : ' disabled="disabled"').'>
<option value="">'.$l_we_class["edit"].'</option>
<option value="image_resize">'.$l_we_class["resize"].'...</option>
<option value="image_rotate">'.$l_we_class["rotate"].'...</option>
<option value="image_crop">'.$l_we_class["crop"].'...</option>
<option value="" disabled="disabled" style="color:gray">'.$l_we_class["convert"].'</option>
'.((in_array("jpg", we_image_edit::supported_image_types())) ? '<option value="image_convertJPEG">&nbsp;&nbsp;'.$l_we_class["convert_jpg"].'...</option>' : '').'
'.(($_gdtype != "gif" && in_array("gif", we_image_edit::supported_image_types())) ? '<option value="doImage_convertGIF">&nbsp;&nbsp;'.$l_we_class["convert_gif"].'</option>' : '').'
'.(($_gdtype != "png" && in_array("png", we_image_edit::supported_image_types())) ? '<option value="doImage_convertPNG">&nbsp;&nbsp;'.$l_we_class["convert_png"].'</option>' : '').'
</select>';
				$_html = '<table cellpadding="0" cellspacing="0" border="0">
';
				if($we_doc->EditPageNr==15) {
					$_html .= '<tr>
								<td>' . $editselect . '</td>
							</tr>
							<tr>
									<td>' . getPixel(2, 10) . '</td>
							</tr>
							<tr>
									<td>' . getPixel(2, 10) . '</td>
							</tr>
							';
				}

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/crop.inc.php");
			$_html .= '
                        <tr>
							<td>' . $we_doc->getHtml(true) .  '</td>
						</tr>

			';

			$_html .= '</table>';

			print $_html;
?>
