<?php

class weShopVats {

	// some arrays for caching results

	function getAllShopVATs() {

		if (!isset($GLOBALS['weShopVats']['getAllVats'])) {

			$query = '
				SELECT *
				FROM ' . WE_SHOP_VAT_TABLE;

			$GLOBALS['DB_WE']->query($query);

			$ret = array();

			while ( $GLOBALS['DB_WE']->next_record() ) {

				$ret[$GLOBALS['DB_WE']->f('id')] = new weShopVat(
					$GLOBALS['DB_WE']->f('id'),
					$GLOBALS['DB_WE']->f('text'),
					$GLOBALS['DB_WE']->f('vat'),
					($GLOBALS['DB_WE']->f('standard') ? 1 : 0 )
				);
			}
			$GLOBALS['weShopVats']['getAllVats'] = $ret;
		}
		return $GLOBALS['weShopVats']['getAllVats'];
	}

	function getShopVATById($id) {

		if (!isset($GLOBALS['weShopVats']['getShopVATById']["$id"])) {

			$query = '
			SELECT *
			FROM ' . WE_SHOP_VAT_TABLE . '
			WHERE id=' . addslashes($id);

			$GLOBALS['DB_WE']->query($query);

			$ret = false;

			if ($GLOBALS['DB_WE']->next_record()) {

				$ret = new weShopVat(
					$GLOBALS['DB_WE']->f('id'),
					$GLOBALS['DB_WE']->f('text'),
					$GLOBALS['DB_WE']->f('vat'),
					($GLOBALS['DB_WE']->f('standard') ? true : false )
				);
			}
			$GLOBALS['weShopVats']['getShopVATById']["$id"] = $ret;
		}
		return $GLOBALS['weShopVats']['getShopVATById']["$id"];
	}

	function getVatRateForSite($id=false, $fallBackToStandard=true, $standard='') {

		if ($id) {
			$weShopVat = weShopVats::getShopVATById($id);
		}

		if (!isset($weShopVat) || !$weShopVat) {

			$weShopVat = weShopVats::getStandardShopVat();
		}

		if ($weShopVat) {
			return $weShopVat->vat;
		}
		return $standard;
	}

	function getStandardShopVat() {

		if (!isset($GLOBALS['weShopVats']['getStandardShopVat'])) {

			$query = '
				SELECT *
				FROM ' . WE_SHOP_VAT_TABLE . '
				WHERE standard=1
			';

			$GLOBALS['DB_WE']->query($query);

			$ret = false;

			if ($GLOBALS['DB_WE']->next_record()) {

				$ret = new weShopVat(
					$GLOBALS['DB_WE']->f('id'),
					$GLOBALS['DB_WE']->f('text'),
					$GLOBALS['DB_WE']->f('vat'),
					($GLOBALS['DB_WE']->f('standard') ? true : false )
				);
			}
			$GLOBALS['weShopVats']['getStandardShopVat'] = $ret;
		}


		return $GLOBALS['weShopVats']['getStandardShopVat'];
	}

	function saveWeShopVAT($weShopVat) {

		// 1st - change standard for every entry
		if ($weShopVat->standard == 1) {

			// delete all other standard values
			$query = '
				UPDATE ' . WE_SHOP_VAT_TABLE . '
				SET standard = 0
				WHERE 1
			';
			$GLOBALS['DB_WE']->query($query);
		}

		if ($weShopVat->id == 0) { // insert a new vat

			$query = '
				INSERT INTO ' . WE_SHOP_VAT_TABLE . '
				(text, vat, standard)
				VALUES("' . addslashes($weShopVat->text) . '", "' . addslashes($weShopVat->vat) . '", ' . addslashes($weShopVat->standard) . ')
			';

			if ($GLOBALS['DB_WE']->query($query)) {
				return mysql_insert_id();
			}

		} else { // update existing vat

			$query = '
				UPDATE ' . WE_SHOP_VAT_TABLE . '
				SET text="' . addslashes($weShopVat->text) . '", vat="' . addslashes($weShopVat->vat) . '", standard=' . addslashes($weShopVat->standard) . '
				WHERE id=' . addslashes($weShopVat->id) . '
			';

			if ($GLOBALS['DB_WE']->query($query)) {
				return $weShopVat->id;
			}
		}

		return false;
	}

	function deleteVatById($id) {

		$query = '
			DELETE FROM ' . WE_SHOP_VAT_TABLE . '
			WHERE id=' . addslashes($id) . '
		';
		return $GLOBALS['DB_WE']->query($query);
	}
}

class weShopVat {

	var $id;
	var $text;
	var $vat;
	var $standard;

	function weShopVat($id, $text, $vat, $standard=false) {

		$this->id = $id;
		$this->text = $text;
		$this->vat = $vat;
		$this->standard = $standard;
	}
}
?>