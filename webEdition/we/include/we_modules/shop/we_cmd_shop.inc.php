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

switch ($_REQUEST["we_cmd"][0]) {
	
	case "edit_shop_ifthere":
	case "edit_shop":
		$mod="shop";
		$INCLUDE = "we_modules/show_frameset.php";
	break;
	
	case 'shop_insert_variant':
	case 'shop_move_variant_up':
	case 'shop_move_variant_down':
	case 'shop_remove_variant':
	case 'shop_preview_variant':
		$INCLUDE = 'we_editors/we_editor.inc.php';
	break;
}

?>