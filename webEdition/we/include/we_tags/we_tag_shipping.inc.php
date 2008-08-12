<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/we_tag_ifShopPayVat.inc.php');

function we_tag_shipping($attribs, $content) {

	$foo = attributFehltError($attribs,"sum","shipping");if($foo) return $foo;

	$sumName = we_getTagAttribute('sum', $attribs);
	$num_format = we_getTagAttribute('num_format', $attribs);
	$type = we_getTagAttribute('type', $attribs, '');

	$shippingCost = 0;

	// shipping depends on total value of basket
	if (isset($GLOBALS['summe'][$sumName])) {

		require_once(WE_SHOP_MODULE_DIR . 'weShippingControl.class.php');
		require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/we_tag_ifRegisteredUser.inc.php');

		$orderVal = $GLOBALS['summe'][$sumName];

		$weShippingControl = weShippingControl::getShippingControl();

		if (we_tag_ifRegisteredUser(array(), '')) { // check if user is registered
			$customer = $_SESSION['webuser'];
		} else {
			$customer = false;
		}

		$shippingCost = $weShippingControl->getShippingCostByOrderValue($orderVal, $customer);

		// get calculated value if needed
		if ($type) {

			// if user must NOT pay vat always return net prices
			$mustPayVat = we_tag_ifShopPayVat(array(), ''); // alayways return net prices

			if ($mustPayVat) {

				switch ($type) {

					case 'net':
						if (!$weShippingControl->isNet) {
							// y = x * (100/116)
							$shippingCost = $shippingCost * (100/ ((1 + ($weShippingControl->vatRate/100)) * 100) );
						}
					break;

					case 'gros':
						if ($weShippingControl->isNet) {
							// y = x * (1.16)
							$shippingCost = $shippingCost * (1 + ($weShippingControl->vatRate/100));
						}
					break;

					case 'vat':
						if ($weShippingControl->isNet) {
							// y = x * 0.16
							$shippingCost = $shippingCost * ($weShippingControl->vatRate/100);
						} else {
							// y = x /116 * 16
							$shippingCost = $shippingCost / ( ((1 + ($weShippingControl->vatRate/100)) * 100) ) * $weShippingControl->vatRate;
						}
					break;
				}

			} else { // always return net prices
				switch ($type) {

					case 'gros':
					case 'net':
						if (!$weShippingControl->isNet) {
							// y = x * (100/116)
							$shippingCost = $shippingCost * (100/ ((1 + ($weShippingControl->vatRate/100)) * 100) );
						}
					break;

					case 'vat':
						$shippingCost = 0;
					break;
				}
			}


		}

		if($num_format=="german"){
			$shippingCost=number_format($shippingCost,2,",",".");
		}else if($num_format=="french"){
			$shippingCost=number_format($shippingCost,2,","," ");
		}else if($num_format=="english"){
			$shippingCost=number_format($shippingCost,2,".","");
		}
		return $shippingCost;
	}
	return 0;
}
?>