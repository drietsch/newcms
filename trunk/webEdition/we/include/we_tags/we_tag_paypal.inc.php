<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
//



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");

// Setup class
require_once(WE_SHOP_MODULE_DIR . "paypal.class.php");  // include the class file

/**
 * This function writes the shop data (order) to the database and send values to paypal
 *
 * @param          $attribs array
 *
 * @return         void
 */
function we_tag_paypal($attribs) {
	global $DB_WE;
	$name = we_getTagAttribute("name",$attribs);
	$foo = attributFehltError($attribs,"pricename","PayPal");
	if($foo)
	    return $foo;
	if(!$name)
		$foo = attributFehltError($attribs,"shopname","PayPal");
	if($foo)
		return $foo;

	$shopname = we_getTagAttribute("shopname",$attribs);
	$shopname = $shopname ? $shopname : $name;
	$pricename = we_getTagAttribute("pricename",$attribs);



	$netprices = we_getTagAttribute("netprices",$attribs,'true', true, true);

		$useVat = we_getTagAttribute("usevat",$attribs,'true', true);

	if ($useVat) {
		require_once(WE_SHOP_MODULE_DIR . 'weShopVatRule.class.php');

		if (isset($_SESSION['webuser'])) {
			$_customer = $_SESSION['webuser'];
		} else {
			$_customer = false;
		}

		$weShopVatRule = weShopVatRule::getShopVatRule();
		$calcVat = $weShopVatRule->executeVatRule($_customer);
	}



    // var_dump($attribs);
     if (isset($GLOBALS[$shopname])) {
     		$basket = $GLOBALS[$shopname];

		$shoppingItems = $basket->getShoppingItems();
		$cartFields = $basket->getCartFields();

		if (sizeof($shoppingItems) == 0) {
			return;
		}

/*  PHP Paypal IPN Integration Class Demonstration File
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
*/


     $DB_WE = !isset($DB_WE) ? new DB_WE : $DB_WE;

	//	NumberFormat - currency and taxes
	$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));
	if( isset($feldnamen[0])){  // determine the currency
		if($feldnamen[0]=="$" || $feldnamen[0]=="USD"){
		   $currency = "USD";
	    }elseif ($feldnamen[0]=="?" || $feldnamen[0]=="EUR"){
		   $currency = "EUR";
	    }elseif ($feldnamen[0]=="£" || $feldnamen[0]=="GBP"){
		   $currency = "GBP";
		}elseif ($feldnamen[0]=="AUD"){
		   $currency = "AUD";
	    }else{
	       $currency = "EUR";
	    }
	}else{
		$currency = "EUR";
	}

	$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'payment_details'");
	$DB_WE->next_record();
	$formField = explode("|",$DB_WE->f("strFelder"));
	if( isset($formField[0])){  // determine the Forename
		$sendForename = $_SESSION['webuser'][$formField[0]];
	}
	if( isset($formField[1])){  // determine the Surename
		$sendSurname = $_SESSION['webuser'][$formField[1]];
	}
	if( isset($formField[2])){  // determine the Street
		$sendStreet = $_SESSION['webuser'][$formField[2]];
	}
	if( isset($formField[3])){  // determine the Zip
		$sendZip = $_SESSION['webuser'][$formField[3]];
	}
	if( isset($formField[4])){  // determine the City
		$sendCity = $_SESSION['webuser'][$formField[4]];
	}
	if( isset($formField[18]) && $formField[18]){  // determine the City
		$sSendEmail = $_SESSION['webuser'][$formField[18]];
	}
	
	if( isset($formField[5])){  // determine the country code
		$lc = $formField[5];
	}

	if( isset($formField[6])){  // determine the paypal business email
		$paypalEmail = $formField[6];
	}
	if( isset($formField[7])){  // todo

		if ($formField[7]=="default"){
			$paypalURL = "https://www.paypal.com/cgi-bin/webscr";

		}else{
			$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}
	}else{
		    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
	}

// Setup class
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = $paypalURL;   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url

// setup a variable for this script (ie: 'http://www.webEdition.de/shop/paypal.php')
$this_script = getServerProtocol(true) . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';

switch ($_GET['action']) {

   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.

      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.

      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);





	$i = 0;
	$summit = 0;
	foreach ( $shoppingItems as $key => $item) {
		$i++;   //  loop through basket

      $p->add_field('business', $paypalEmail);
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('currency_code', $currency);
      $p->add_field('lc', $lc);
           // get user details
      $p->add_field('first_name', $sendForename);
      $p->add_field('last_name', $sendSurname);
      $p->add_field('address1', $sendStreet);
      $p->add_field('zip', $sendZip);
      $p->add_field('city', $sendCity);
      $p->add_field('country', $lc);
      
      if (isset($sSendEmail) && we_check_email($sSendEmail)) {
		$p->add_field('email', $sSendEmail);
		$p->add_field('receiver_email', $sSendEmail);
      }
      
      //  determine the basket data
      $p->add_field('item_name_'.$i, $itemTitle = (isset($item['serial']['we_shoptitle']) ? $item['serial']['we_shoptitle'] : $item['serial']['shoptitle']) );
      $p->add_field('quantity_'.$i, $item['quantity']);
      
      $itemPrice = (isset($item['serial']["we_".$pricename]) ? $item['serial']["we_".$pricename] : $item['serial'][$pricename]);
      
      // correct price, if it has more than one "."
      // bug #8717
      $itemPrice = we_util::std_numberformat($itemPrice);
      
      $p->add_field('amount_'.$i, $itemPrice);

        // foreach article we must determine the correct tax-rate
			require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
			$vatId = isset($item['serial'][WE_SHOP_VAT_FIELD_NAME]) ? $item['serial'][WE_SHOP_VAT_FIELD_NAME] : 0;
			$shopVat = weShopVats::getVatRateForSite($vatId, true, false);
			if ($shopVat) { // has selected or standard shop rate
				$item['serial'][WE_SHOP_VAT_FIELD_NAME] = $shopVat;
			} else { // could not find any shoprates, remove field if necessary
				if (isset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME])) {
					unset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME]);
				}
			}


	 if($netprices){
	 	  $totalVat = $itemPrice / 100 * $shopVat;
	 	  $totalVats = number_format($totalVat,2);
			     // add the polychronic taxes
      $p->add_field('tax_'.$i, $totalVats);
	 }

           // determine the shipping cost by accumulating the total
      $summit += ($itemPrice*$item['quantity']);

    }


	       //get the shipping costs
	        require_once(WE_SHOP_MODULE_DIR . 'weShippingControl.class.php');
	        require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/we_tag_ifRegisteredUser.inc.php');

			$weShippingControl = weShippingControl::getShippingControl();

			if (we_tag_ifRegisteredUser(array(), '')) { // check if user is registered
			 $customer = $_SESSION['webuser'];
		    } else {
			 $customer = false;
		    }
			$cartField[WE_SHOP_SHIPPING] = array(
				'costs'   => $weShippingControl->getShippingCostByOrderValue($summit, $customer),
				'isNet'   => $weShippingControl->isNet,
				'vatRate' => $weShippingControl->vatRate
			    );

			        $shippingCosts = $cartField[WE_SHOP_SHIPPING]['costs'];
		        	$isNet = $cartField[WE_SHOP_SHIPPING]['isNet'];
		        	$vatRate = $cartField[WE_SHOP_SHIPPING]['vatRate'];
		        	$shippingCostVat =  $shippingCosts / 100 * $vatRate;
		        	$shippingFee = $shippingCosts + $shippingCostVat;
		        	
					if ($isNet) { // net prices
						$shippingCostVat =  $shippingCosts / 100 * $vatRate;
						$shippingFee = $shippingCosts + $shippingCostVat;
						
					} else {
						$shippingFee = $shippingCosts;
						
					}
						/*
	   					if($isNet != 0){
	  					$p->add_field('shipping_1', $shippingCosts);
       					}else{
       					print " null ";
					    }
   						 */
	   $p->add_field('shipping_1', $shippingFee);
	   $p->add_field('upload', 1);


	 //p_r($p);
	// var_dump($shopVat);

	// exit;
 
    	$p->submit_paypal_post(); // submit the fields to paypal
      break;

   case 'success':      // Order was successful...

      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.
      include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tags/we_tag_writeShopData.inc.php");

      we_tag_writeShopData($attribs);

      // You could also simply re-direct them to another page, or your own
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code
      // below).



      break;

   case 'cancel':       // Order was canceled...

      // The order was canceled before being completed.



      break;

   case 'ipn':          // Paypal is calling page for IPN validation...

      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.

      if ($p->validate_ipn()) {

         // Payment has been recieved and IPN is verified.  This is where you
         // update your database to activate or process the order, or setup
         // the database with the user's order details, email an administrator,
         // etc.  You can access a slew of information via the ipn_data() array.

         // Check the paypal documentation for specifics on what information
         // is available in the IPN POST variables.  Basically, all the POST vars
         // which paypal sends, which we send back for validation, are now stored
         // in the ipn_data() array.

         // For this example, we'll just email ourselves ALL the data.
         /*$subject = 'Instant Payment Notification - Recieved Payment';
         $to = 'jan.gorba@webedition.de';    //  your email
         $body =  "An instant payment notification was successfully recieved\n";
         $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
         $body .= " at ".date('g:i A')."\n\nDetails:\n";
         foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
         mail($to, $subject, $body);*/
      }
      break;
     }

	}
	return;
}
?>