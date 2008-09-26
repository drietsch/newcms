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


require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/shop.inc.php');

// check if there are variation fields defined
$variationFields = $we_doc->getVariantFields();

// need many buttons here
$we_button = new we_button();

// if editing data the class weShopVariants must do some stuff
// add, move, delete
// :TODO: decide where to put this
switch ($_REQUEST['we_cmd'][0]) {
	case 'shop_insert_variant':
		weShopVariants::insertVariant($we_doc, $_REQUEST['we_cmd'][1]);
	break;
	case "shop_move_variant_up":
		weShopVariants::moveVariant($we_doc, $_REQUEST['we_cmd'][1], 'up');
	break;
	case "shop_move_variant_down":
		weShopVariants::moveVariant($we_doc, $_REQUEST['we_cmd'][1], 'down');
	break;
	case "shop_remove_variant":
		weShopVariants::removeVariant($we_doc, $_REQUEST['we_cmd'][1]);
	break;
	case "shop_preview_variant":
		weShopVariants::correctModelFields($we_doc, false);
		require($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/show_variant.inc.php');
		exit;
	break;
}


$we_editmode = true;
$parts = weShopVariants::getVariantsEditorMultiBoxArray($we_doc);

print we_multiIconBox::getHTML("","100%",$parts,30,"",-1,"","",false);
?>