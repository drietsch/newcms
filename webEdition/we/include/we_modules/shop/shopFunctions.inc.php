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


function getCustomersOrderList($customerId, $sameModul=true) {
	
	global $DB_WE;
	
	require($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/modules/shop.inc.php');
	
	$orderStr = '
		<table class="defaultfont" width="600">
	';
	
	$we_button = new we_button();
	
	// get orderdata of user here
	$da = ( $GLOBALS['WE_LANGUAGE'] == "Deutsch" )?"%d.%m.%y":"%m/%d/%y";
	
	$query = '
		SELECT IntOrderID, DateOrder, DATE_FORMAT(DateOrder,"' . $da . '") AS formatDateOrder, DateShipping, DATE_FORMAT(DateShipping,"' . $da . '") AS formatDateShipping, DatePayment, DATE_FORMAT(DatePayment,"' . $da . '") AS formatDatePayment
		FROM ' . SHOP_TABLE . '
		WHERE IntCustomerID=' . addslashes($customerId) . '
		GROUP BY IntOrderId
		ORDER BY IntID DESC
	';
	
 	$DB_WE->query($query);
	
	if ($DB_WE->num_rows()) {
		
		$orderStr .='
		<tr>
			<td><b>' . $l_shop['orderList']['order'] . '</b></td>
			<td><b>' . $l_shop['orderList']['orderDate'] . '</b></td>
			<td><b>' . $l_shop['orderList']['orderEdited'] . '</b></td>
			<td><b>' . $l_shop['orderList']['orderPayed'] . '</b></td>
			<td></td>
		</tr>';
		
		while ($GLOBALS['DB_WE']->next_record()) {
			
			$orderStr .= '
		<tr>
			<td>' . $DB_WE->f('IntOrderID') . '. ' . $l_shop['orderList']['order'] . '</td>
			<td>' . ( $DB_WE->f('DateOrder') > 0 ? $DB_WE->f('formatDateOrder') : '-'  ) . '</td>
			<td>' . ( $DB_WE->f('DateShipping') > 0  ? $DB_WE->f('formatDateShipping') : '-' ) . '</td>
			<td>' . ( $DB_WE->f('DatePayment') > 0  ? $DB_WE->f('formatDatePayment') : '-' ) . '</td>
			' . 
				($sameModul ?
					('<td>' . $we_button->create_button('image:btn_edit_edit', 'javascript:top.content.shop_properties.location = \'' . WE_SHOP_MODULE_PATH . 'edit_shop_editorFrameset.php?bid=' . $DB_WE->f('IntOrderID') . '\';' ) . '</td>') :
					('<td>' . $we_button->create_button('image:btn_edit_edit', 'javascript:top.document.location = \'' . WE_MODULE_PATH . 'show_frameset.php?mod=shop&bid=' . $DB_WE->f('IntOrderID') . '\';' ) . '</td>')
              	)
			. '
		</tr>';
		}
	} else {
		$orderStr .= '
		<tr>
			<td>' . $l_shop['orderList']['noOrders'] . '</td>
		</tr>';
	}
	$orderStr .= '
		</table>
		';
	
	return $orderStr;
}

?>