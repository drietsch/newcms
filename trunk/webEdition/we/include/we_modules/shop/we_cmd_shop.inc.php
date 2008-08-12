<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: we_cmd_shop.inc.php,v 1.11 2007/05/23 15:39:40 holger.meyer Exp $

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