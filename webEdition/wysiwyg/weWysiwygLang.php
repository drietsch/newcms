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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg_js.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/charset/charset.inc.php");
header("Content-Type: text/html; charset=" . $_language["charset"]);

?>

<html>

<head>

<meta http-equiv="content-type" content="text/html; charset=<?php echo $_language["charset"]; ?>">

<?php

print '<script type="text/javascript">
					parent.we_wysiwyg_lng = {};
					parent.we_wysiwyg_lng["mozilla_paste"] = "'.$GLOBALS["l_wysiwyg"]["mozilla_paste"].'";
					parent.we_wysiwyg_lng["cut"] = "'.$GLOBALS["l_wysiwyg"]["cut2"].'";
					parent.we_wysiwyg_lng["copy"] = "'.$GLOBALS["l_wysiwyg"]["copy2"].'";
					parent.we_wysiwyg_lng["paste"] = "'.$GLOBALS["l_wysiwyg"]["paste2"].'";
					parent.we_wysiwyg_lng["inserttable"] = "'.$GLOBALS["l_wysiwyg"]["insert_table"].'";
					parent.we_wysiwyg_lng["edit_hyperlink"] = "'.$GLOBALS["l_wysiwyg"]["edit_hyperlink"].'";
					parent.we_wysiwyg_lng["insert_hyperlink"] = "'.$GLOBALS["l_wysiwyg"]["insert_hyperlink"].'";
					parent.we_wysiwyg_lng["insert_image"] = "'.$GLOBALS["l_wysiwyg"]["insert_image"].'";
					parent.we_wysiwyg_lng["edit_image"] = "'.$GLOBALS["l_wysiwyg"]["edit_image"].'";
					parent.we_wysiwyg_lng["inserthorizontalrule"] = "'.$GLOBALS["l_wysiwyg"]["inserthorizontalrule"].'";
					parent.we_wysiwyg_lng["insertspecialchar"] = "'.$GLOBALS["l_wysiwyg"]["insertspecialchar"].'";
					parent.we_wysiwyg_lng["insert_table"] = "'.$GLOBALS["l_wysiwyg"]["insert_table"].'";
					parent.we_wysiwyg_lng["edittable"] = "'.$GLOBALS["l_wysiwyg"]["edit_table"].'";
					parent.we_wysiwyg_lng["editcell"] = "'.$GLOBALS["l_wysiwyg"]["edit_cell"].'";
					parent.we_wysiwyg_lng["undo"] = "'.$GLOBALS["l_wysiwyg"]["undo"].'";
					parent.we_wysiwyg_lng["redo"] = "'.$GLOBALS["l_wysiwyg"]["redo"].'";
					parent.we_wysiwyg_lng["nothing_selected"] = "'.$GLOBALS["l_wysiwyg"]["nothing_selected"].'";
					parent.we_wysiwyg_lng["selection_invalid"] = "'.$GLOBALS["l_wysiwyg"]["selection_invalid"].'";
					parent.we_wysiwyg_lng["no_table_selected"] = "'.$GLOBALS["l_wysiwyg"]["no_table_selected"].'";

					parent.we_wysiwyg_lng["insertcolumnright"] = "'.$GLOBALS["l_wysiwyg"]["insertcolumnright"].'";
					parent.we_wysiwyg_lng["insertcolumnleft"] = "'.$GLOBALS["l_wysiwyg"]["insertcolumnleft"].'";
					parent.we_wysiwyg_lng["insertrowabove"] = "'.$GLOBALS["l_wysiwyg"]["insertrowabove"].'";
					parent.we_wysiwyg_lng["insertrowbelow"] = "'.$GLOBALS["l_wysiwyg"]["insertrowbelow"].'";
					parent.we_wysiwyg_lng["deleterow"] = "'.$GLOBALS["l_wysiwyg"]["deleterow"].'";
					parent.we_wysiwyg_lng["deletecol"] = "'.$GLOBALS["l_wysiwyg"]["deletecol"].'";
					parent.we_wysiwyg_lng["increasecolspan"] = "'.$GLOBALS["l_wysiwyg"]["increasecolspan"].'";
					parent.we_wysiwyg_lng["decreasecolspan"] = "'.$GLOBALS["l_wysiwyg"]["decreasecolspan"].'";
					parent.we_wysiwyg_lng["caption"] = "'.$GLOBALS["l_wysiwyg"]["caption"].'";
					parent.we_wysiwyg_lng["insert_edit_anchor"] = "'.$GLOBALS["l_wysiwyg"]["insert_edit_anchor"].'";
					parent.we_wysiwyg_lng["anchor_name"] = "'.$GLOBALS["l_wysiwyg"]["anchor_name"].'";
					parent.we_wysiwyg_lng["insert_anchor"] = "'.$GLOBALS["l_wysiwyg"]["insert_anchor"].'";
					parent.we_wysiwyg_lng["edit_anchor"] = "'.$GLOBALS["l_wysiwyg"]["edit_anchor"].'";

					parent.we_wysiwyg_lng["none"] = "'.$GLOBALS["l_wysiwyg"]["none"].'";
					parent.we_wysiwyg_lng["hide_borders"] = "'.$GLOBALS["l_wysiwyg"]["hide_borders"].'";
					parent.we_wysiwyg_lng["visible_borders"] = "'.$GLOBALS["l_wysiwyg"]["visible_borders"].'";

					parent.we_wysiwyg_lng["formatblock"] = "'.$GLOBALS["l_wysiwyg"]["format2"].'";
					parent.we_wysiwyg_lng["fontname"] = "'.$GLOBALS["l_wysiwyg"]["fontname2"].'";
					parent.we_wysiwyg_lng["fontsize"] = "'.$GLOBALS["l_wysiwyg"]["fontsize"].'";
					parent.we_wysiwyg_lng["applystyle"] = "'.$GLOBALS["l_wysiwyg"]["css_style2"].'";
					parent.we_wysiwyg_lng["removeformat_warning"] = "'.$GLOBALS["l_wysiwyg"]["removeformat_warning"].'";

				</script>';
?>

</head>
<body></body>

</html>