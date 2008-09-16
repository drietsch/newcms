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

include_once($_SERVER['DOCUMENT_ROOT']. '/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/shop.inc.php');

$variantFields = $we_doc->getVariantFields();

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

$parts = weShopVariants::getVariantsEditorMultiBoxArrayObjectFile($we_doc);
print we_multiIconBox::getHTML("","100%",$parts,30,"",-1,"","",false);
?>