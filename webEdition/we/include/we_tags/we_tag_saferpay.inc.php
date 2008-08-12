<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");



/**
 * This function writes the shop data (order) to the database and send values to saferpay
 *
 * @param          $attribs array
 *
 * @return         void
 */
function we_tag_saferpay($attribs) {
	global $DB_WE;
	$name = we_getTagAttribute("name",$attribs);
	$foo = attributFehltError($attribs,"pricename","saferpay");
	if($foo)
	    return $foo;	
	if(!$name)
		$foo = attributFehltError($attribs,"shopname","saferpay");
	if($foo)
		return $foo;
	
	$shopname = we_getTagAttribute("shopname",$attribs);
	$shopname = $shopname ? $shopname : $name;
	$pricename = we_getTagAttribute("pricename",$attribs);

	$onsuccess = we_getTagAttribute("onsuccess",$attribs);
	$onfailure = we_getTagAttribute("onfailure",$attribs);
	$onabortion = we_getTagAttribute("onabortion",$attribs);
	
	
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
/* ****** get the currency ******* */
        $DB_WE = !isset($DB_WE) ? new DB_WE : $DB_WE;
			$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
			$DB_WE->next_record();
			$feldnamen = explode("|",$DB_WE->f("strFelder"));
			if( isset($feldnamen[0])){  // determine the currency 
				if($feldnamen[0]=="$" || $feldnamen[0]=="USD"){
		   			$currency = "USD";
	    		}elseif ($feldnamen[0]=="£" || $feldnamen[0]=="GBP"){
		   			$currency = "GBP";
				}elseif ($feldnamen[0]=="AUD"){
		   			$currency = "AUD";
				}elseif ($feldnamen[0]=="CHF" || $feldnamen[0]=="SFR"){
		   			$currency = "CHF";
				}elseif ($feldnamen[0]=="CAD"){
		   			$currency = "CAD";
	    		}else{
	       			$currency = "EUR";	
	    		}
			}else{
					$currency = "EUR";
			}
/* ****** get the currency ******* */  
      
/* ***** get the preferences ***** */ 
        $DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'payment_details'");
		$DB_WE->next_record();
		$formField = explode("|",$DB_WE->f("strFelder"));
		if( isset($formField[8])){  // determine the language
			$langID = $formField[8];
		}
		if( isset($formField[9])){  // determine the Notify-Email 
			$accountID = $formField[9];
		}
		if( isset($formField[10])){  // determine the Notify-Email 
			$notifyAddr = $formField[10];
		}
		if( isset($formField[11])){  // determine the  notify-Email
                $allowColl = $formField[11];
		}
		if( isset($formField[12])){  // determine the delivery if yes or no 
                $delivery = $formField[12];
		}
		if( isset($formField[13])){  // determine the user notify if yes or no 
                $userNotify = $formField[13];
		}
		if( isset($formField[14])){  // determine the providerset
                $providerset = $formField[14]; 
		}
        if( isset($formField[15])){  // determine the cmd path
                $execPath = $formField[15]; 
    	}
        if( isset($formField[16])){  // determine the conf path
                $confPath = $formField[16]; 
    	}
        if( isset($formField[17])){  // determine the conf path
                $desc = $formField[17]; 
 		} 
/* ***** get the preferences ***** */ 

/* ***** get the further links ***** */ 
				$successprelink= id_to_path($onsuccess);
                $successlink = "http://".$_SERVER['SERVER_NAME'].$successprelink;
                //print $successlink;
       
                $failureprelink= id_to_path($onfailure);
                $failurelink = "http://".$_SERVER['SERVER_NAME'].$failureprelink;
                //print $failurelink;
        
                $abortionprelink= id_to_path($onabortion);
                $abortionlink = "http://".$_SERVER['SERVER_NAME'].$abortionprelink;
                //print $failurelink;
/* ***** get the further links ***** */ 

 	
	$summit = 0;
	foreach ( $shoppingItems as $key => $item) {
	
      $itemTitle = (isset($item['serial']['we_shoptitle']) ? $item['serial']['we_shoptitle'] : $item['serial']['shoptitle']) ;
      $itemPrice = (isset($item['serial']["we_".$pricename]) ? $item['serial']["we_".$pricename] : $item['serial'][$pricename]);
      
        // foreach article we must determine the correct tax-rate
			require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
			$vatId = isset($item['serial'][WE_SHOP_VAT_FIELD_NAME]) ? $item['serial'][WE_SHOP_VAT_FIELD_NAME] : 0;
			$shopVat = weShopVats::getVatRateForSite($vatId, true, false);
			if ($shopVat) { // has selected or standard shop rate
				$$item['serial'][WE_SHOP_VAT_FIELD_NAME] = $shopVat;
			} else { // could not find any shoprates, remove field if necessary
				if (isset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME])) {
					unset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME]);
				}
			}
			
       
	 if($netprices){
	 	  $totalVat = $itemPrice / 100 * $shopVat;
	 	  $totalVats = number_format($totalVat,2,'.',''); 
			     // add the polychronic taxes
      // $totalVats;
	 }  
			      
      			// determine the shipping cost by accumulating the total  
      $summit += ($itemPrice*$item['quantity']+$totalVats);
      
   
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

           // sum all costs
		   $totalSum = $summit+$shippingFee;  
		   // to be reserved in minor currency unit e.g. EUR 1.35 must be passed as 135   	
		   $strAmount = str_replace("-","",number_format( $totalSum, 2, '-', ''));
		   
########################################################################
########################### submit starts here #########################
########################################################################		   		   
	
			$attributes = array("-a", "AMOUNT", (int) $strAmount,
		    "-a", "CURRENCY", $currency,
		    "-a", "DESCRIPTION",$desc ,
		    "-a", "ALLOWCOLLECT", $allowColl,
		    "-a", "DELIVERY", $delivery,
		    "-a", "ACCOUNTID", $accountID,
		    "-a", "BACKLINK", $abortionlink,
		    "-a", "FAILLINK", $failurelink,
		    "-a", "SUCCESSLINK", $successlink,
		    "-a", "ORDERID", $_SESSION['webuser']['ID'],
		    "-a", "PROVIDERSET", $providerset,
		    "-a", "LANGID", $langID,
		    "-a", "NOTIFYADDRESS", $notifyAddr
		    );
		    
			
			$_SESSION['strAmount'] = $strAmount;
			$strAttributes = join(" ", $attributes);
		     
			/* *** debugging *** */
		     //print $strAttributes."\n<br/>";
		    // print "<br/>".$execPath;
		    // print "<br/>".$confPath;
		    // var_dump($attribs);
		    // print $langID;
		     /* *** debugging *** */
		     
		     switch($langID){
		     	case "de" :
		     	   $processOK = 'Bitte haben Sie einen Moment Geduld.<br>Falls sich kein Fenster &ouml;ffnet klicken Sie bitte <a href="' . $payinit_url . '" onclick="OpenSaferpayTerminal(\'' . $payinit_url . '\', this, \'LINK\');">hier</a>'; 
		           $processError = 'Leider gab es Probleme mit der Abbuchung. Bitte versuchen Sie es sp&auml;ter erneut.'; 
		     	 break;
		        case "en" :
		     	   $processOK = 'This will take some seconds.<br>If no window opens please click <a href="' . $payinit_url . '" onclick="OpenSaferpayTerminal(\'' . $payinit_url . '\', this, \'LINK\');">here</a>';
		     	   $processError = 'A major problem occured. Please try again later.';
		     	  break;
		     	case "fr" :
		     	   $processOK = 'Soyez patient, cela prendra quelques secondes.<br>Si aucune  fenÕtre s affiche, cliquez <a href="' . $payinit_url . '" onclick="OpenSaferpayTerminal(\'' . $payinit_url . '\', this, \'LINK\');">ici</a>';
		     	   $processError = 'Une erreur Une erreur s est produite. S il vous pla”t, essayez de nouveau ult»rieurement..';
		     	  break; 
		     	case "it" :
		     	   $processOK = 'Sia prego paziente.<br>Se nessuna finestra apre, clicca <a href="' . $payinit_url . '" onclick="OpenSaferpayTerminal(\'' . $payinit_url . '\', this, \'LINK\');">prego qui</a>';
		     	   $processError = 'Un errore grave À occorso. Prego prova ancora successivamente..';
		     	  break;
		     	default:
                   $processOK = 'Bitte haben Sie einen Moment Geduld.<br>Falls sich kein Fenster &ouml;ffnet klicken Sie bitte <a href="' . $payinit_url . '" onclick="OpenSaferpayTerminal(\'' . $payinit_url . '\', this, \'LINK\');">hier</a>'; 
		           $processError = 'Leider gab es Probleme mit der Abbuchung. Bitte versuchen Sie es sp&auml;ter erneut.';   
		     } 
		     
	
/* command line */
$command = $execPath."saferpay -payinit -p $confPath $strAttributes";

 if (!$execPath || !$confPath ){
 	 print $GLOBALS["l_shop"]["saferpayError"];
 	 print $strAttributes;
     exit;
 }else{

/* get the payinit URL */
$fp = popen($command, "r");
$payinit_url = str_replace("\n","",fread($fp, 4096));
$payinit_url = str_replace("\r","",$payinit_url);
 }

if($payinit_url){
	print $processOK;
 
 	echo '<script LANGUAGE="JAVASCRIPT">
	<!--
	OpenSaferpayWindowJScript(\'' . $payinit_url . '\');
	//-->
	</script>
	';
}else{
	print $processError;
} 		    

//data in DB
 include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tags/we_tag_writeShopData.inc.php");
      
      we_tag_writeShopData($attribs);


 	}
	return;
}
?>
