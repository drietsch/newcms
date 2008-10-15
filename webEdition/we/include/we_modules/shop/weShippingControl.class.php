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

require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');

class weShippingControl {

	var $stateField = '';
	var $isNet = true;
	var $vatId = 0;
	var $shippings = array();
	var $vatRate = 0;


	function weShippingControl($stateField, $isNet, $vatId, $shippings) {

		$this->stateField = $stateField;
		$this->isNet = $isNet;
		$this->vatId = $vatId;
		$this->shippings = $shippings;

		$this->vatRate = weShopVats::getVatRateForSite($vatId);
	}

	function getShippingControl() {

		global $DB_WE;

		$query = 'SELECT * FROM ' . ANZEIGE_PREFS_TABLE . ' WHERE strDateiname="weShippingControl"';

		$DB_WE->query($query);

		if ($DB_WE->next_record()) {
			
			$shippingControl = unserialize($DB_WE->f('strFelder'));
			$shippingControl->vatRate = weShopVats::getVatRateForSite($shippingControl->vatId);
			
			return $shippingControl;
			
		} else {
			return new weShippingControl(
				'',
				1,
				1,
				array(
				)
			);
		}
	}

	function setByRequest($req) {

		// this function inits a new entry, also it could change existing items
		$this->stateField = $req['stateField'];
		$this->isNet = $req['isNet'];
		$this->vatId = $req['vatId'];

		if (isset($req['weShippingId'])) {

			$newShipping = new weShipping(
				$req['weShippingId'],
				$req['weShipping_text'],
				weShippingControl::makeArrayFromReq($req['weShipping_countries']),
				$req['weShipping_cartValue'],
				$req['weShipping_shipping'],
				($req['weShipping_default'] == '1' ? 1 : 0)
			);
			$this->shippings[$req['weShippingId']] = $newShipping;

			if ($newShipping->default) {

				foreach ($this->shippings as $id => $shipping) {
					if ($id != $req['weShippingId']) {
						$this->shippings[$id]->default = 0;
					}
				}
			}
		}
	}

	function getNewEmptyShipping() {
		return new weShipping(
			uniqid('weShipping_'),
			$GLOBALS['l_shop']['new_entry'],
			array('Deutschland'),
			array('10','20','100'),
			array('15','5','0'),
			0
		);
	}

	function save() {

		global $DB_WE;
		// check if already inserted
		$query = 'SELECT * FROM ' . ANZEIGE_PREFS_TABLE . ' WHERE strDateiname="weShippingControl"';

		$DB_WE->query($query);

		if ($DB_WE->num_rows() > 0) {

			$query = 'UPDATE ' . ANZEIGE_PREFS_TABLE . ' set strFelder="' . mysql_real_escape_string(serialize($this)) . '" WHERE strDateiname="weShippingControl"';

		} else {
			$query = 'INSERT INTO ' . ANZEIGE_PREFS_TABLE . ' (strDateiname, strFelder) VALUES ("weShippingControl", "' . mysql_real_escape_string(serialize($this)) . '")
			';
		}

		if ($DB_WE->query($query)) {
			return true;
		} else {
			return false;
		}
	}

	function delete($id) {

		if (isset($this->shippings[$id])) {
			unset($this->shippings[$id]);
		}
		$this->save();
	}

	function getShippingById($id) {
		return $this->shippings[$id];
	}

	function getDefaultShipping() {

		foreach ($this->shippings as $shipping) {
			if ($shipping->default) {
				return $shipping;
			}
		}
		return false;
	}

	function getShippingCostByOrderValue($orderValue, $customer=false) {

		if ($customer) {
			// foreach, search the shipping

			if (isset($customer[$this->stateField])) {

				foreach ($this->shippings as $key => $tmpShipping) {
					if (in_array($customer[$this->stateField], $tmpShipping->countries)) {
						$shipping = $tmpShipping;
						continue;
					}
				}
			}
		}
		if (!isset($shipping)) { // take default shipping
			$shipping = $this->getDefaultShipping();
		}

		if ($shipping) {

			$shippingId = 0;

			for ($i=0; $i<sizeof($shipping->cartValue);$i++) {

				if ($shipping->cartValue[$i] > $orderValue) {
					continue;
				} else {
					$shippingId = $i;
				}
			}
			return $shipping->shipping[$shippingId];
		}
		return 0;
	}

	function makeArrayFromReq($req) {

		$entries = explode("\n", $req);
		$retArr = array();

		foreach ($entries as $entry) {
			if (trim($entry)) {
				$retArr[] = trim($entry);
			}
		}
		array_unique($retArr);
		return $retArr;
	}
}

class weShipping {

	var $id = '';
	var $text = '';
	var $countries = array();
	var $cartValue = array();
	var $shipping = array();
	var $default = false;

	function weShipping ($id='', $text='', $countries, $cartValue, $shipping, $default) {

		$this->id = $id;
		$this->text = $text;
		$this->countries = $countries;
		$this->cartValue = $cartValue;
		$this->shipping = $shipping;
		$this->default = $default;
	}
}
?>