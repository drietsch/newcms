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
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_shop.inc.php");

	// file
	$we_menu_shop["100000"]["text"] = $l_javaMenu["shop"]["menu_user"];
	$we_menu_shop["100000"]["parent"] = "000000";
	$we_menu_shop["100000"]["perm"] = "";
	$we_menu_shop["100000"]["enabled"] = "1";


		$we_menu_shop["120000"]["text"] = $l_javaMenu["shop"]["year"];
		$we_menu_shop["120000"]["parent"] = "100000";
		$we_menu_shop["120000"]["perm"] = "";
		$we_menu_shop["120000"]["enabled"] = "1";

			// first year
			$yearshop = date("Y");

			$z=1;
			while ( $yearshop >= 2002 ) {

				$menNr = "1".(20000 + $z);
				$we_menu_shop[$menNr]["text"] = $yearshop;
				$we_menu_shop[$menNr]["parent"] = "120000";
				$we_menu_shop[$menNr]["cmd"] = "year".$yearshop;
				$we_menu_shop[$menNr]["perm"] = "";
				$we_menu_shop[$menNr]["enabled"] = "1";
				$yearshop--; $z++;
			}

		$we_menu_shop["180000"]["parent"] = "100000"; // separator

		$we_menu_shop["190000"]["text"] = $l_javaMenu["shop"]["menu_exit"];
		$we_menu_shop["190000"]["parent"] = "100000";
		$we_menu_shop["190000"]["cmd"] = "exit_shop";
		$we_menu_shop["190000"]["perm"] = "";
		$we_menu_shop["190000"]["enabled"] = "1";

	// edit
	$we_menu_shop["200000"]["text"] = $l_javaMenu["shop"]["shop_edit"];
	$we_menu_shop["200000"]["parent"] = "000000";
	$we_menu_shop["200000"]["perm"] = "edit_shop";
	$we_menu_shop["200000"]["enabled"] = "1";

		$we_menu_shop["210000"]["text"] = $l_javaMenu["shop"]["shop_pref"]."...";;
		$we_menu_shop["210000"]["parent"] = "200000";
		$we_menu_shop["210000"]["cmd"] = "pref_shop";
		$we_menu_shop["210000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["210000"]["enabled"] = "1";

		$we_menu_shop["220000"]["parent"] = "200000"; // separator

		$we_menu_shop["230000"]["text"] = $l_javaMenu["shop"]["country_vat"].'...';
		$we_menu_shop["230000"]["parent"] = "200000";
		$we_menu_shop["230000"]["cmd"] = "edit_shop_vat_country";
		$we_menu_shop["230000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["230000"]["enabled"] = "1";

		$we_menu_shop["240000"]["text"] = $l_javaMenu["shop"]["edit_vats"].'...';
		$we_menu_shop["240000"]["parent"] = "200000";
		$we_menu_shop["240000"]["cmd"] = "edit_shop_vats";
		$we_menu_shop["240000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["240000"]["enabled"] = "1";

		$we_menu_shop["250000"]["text"] = $l_shop['shipping']['shipping_package'].'...';
		$we_menu_shop["250000"]["parent"] = "200000";
		$we_menu_shop["250000"]["cmd"] = "edit_shop_shipping";
		$we_menu_shop["250000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["250000"]["enabled"] = "1";

		$we_menu_shop["251000"]["text"] = $l_shop['shipping']['payment_provider'].'...';
		$we_menu_shop["251000"]["parent"] = "200000";
		$we_menu_shop["251000"]["cmd"] = "payment_val";
		$we_menu_shop["251000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["251000"]["enabled"] = "1";

		$we_menu_shop["251001"]["parent"] = "200000"; // separator

		$we_menu_shop["252000"]["text"] =  $l_shop['shipping']['revenue_view'];
		$we_menu_shop["252000"]["parent"] = "200000";
		$we_menu_shop["252000"]["cmd"] = "revenue_view";
		$we_menu_shop["252000"]["perm"] = "EDIT_SHOP_PREFS || ADMINISTRATOR";
		$we_menu_shop["252000"]["enabled"] = "1";

		$we_menu_shop["260000"]["parent"] = "200000"; // separator

		$we_menu_shop["270000"]["text"] = $l_javaMenu["shop"]["order"];
		$we_menu_shop["270000"]["parent"] = "200000";
		$we_menu_shop["270000"]["perm"] = "";
		$we_menu_shop["270000"]["enabled"] = "1";


			$we_menu_shop["271000"]["text"] = $l_javaMenu["shop"]["add_article_to_order"];
			$we_menu_shop["271000"]["parent"] = "270000";
			$we_menu_shop["271000"]["cmd"] = "new_article";
			$we_menu_shop["271000"]["perm"] = "NEW_SHOP_ARTICLE || ADMINISTRATOR";
			$we_menu_shop["271000"]["enabled"] = "1";

			$we_menu_shop["272000"]["text"] = $l_javaMenu["shop"]["delete_order"];
			$we_menu_shop["272000"]["parent"] = "270000";
			$we_menu_shop["272000"]["cmd"] = "delete_shop";
			$we_menu_shop["272000"]["perm"] = "DELETE_SHOP_ARTICLE || ADMINISTRATOR";;
			$we_menu_shop["272000"]["enabled"] = "1";

	// menu add
	$we_menu_shop["300000"]["text"] = $l_javaMenu["shop"]["menu_help"];
	$we_menu_shop["300000"]["parent"] = "000000";
	$we_menu_shop["300000"]["perm"] = "SHOW_HELP";
	$we_menu_shop["300000"]["enabled"] = "1";

	$we_menu_shop["310000"]["text"] = $l_javaMenu["shop"]["menu_help"]."...";;
	$we_menu_shop["310000"]["parent"] = "300000";
	$we_menu_shop["310000"]["cmd"] = "help_modules";
	$we_menu_shop["310000"]["perm"] = "SHOW_HELP";
	$we_menu_shop["310000"]["enabled"] = "1";

    $we_menu_shop["320000"]["text"]= $l_javaMenu["shop"]["menu_info"]."...";
    $we_menu_shop["320000"]["parent"] = "300000";
    $we_menu_shop["320000"]["cmd"] = "info_modules";
    $we_menu_shop["320000"]["enabled"] = "1";
?>