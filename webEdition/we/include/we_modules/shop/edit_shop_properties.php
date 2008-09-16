<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or higher                                          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   			  |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_properties.php,v 1.60 2007/10/23 14:59:54 damjan.denic Exp $


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browserDetect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customer.inc.php");

if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}

	protect();

	htmlTop();
	print STYLESHEET;

$we_button = new we_button();

function getFieldFromShoparticle($array, $name, $length=0) {

	$val = ( isset($array["we_$name"]) ? $array["we_$name"] : (isset($array[$name]) ? $array[$name] : '' ) );

	if ($length && ($length < strlen($val)) ) {

		return substr($val, 0, $length) . '...';
	}
	return $val;
}

function getOrderCustomerData($orderId, $orderData=false, $customerId=false, $strFelder=array()) {

	global $DB_WE;

	if (!$customerId) {

		// get customerID from order
		$query = '
			SELECT IntCustomerID, strSerialOrder
			FROM ' . SHOP_TABLE . '
			WHERE IntOrderID=' . addslashes($orderId)
		;

		$DB_WE->query($query);

		if ($DB_WE->next_record()) {
			$customerId = $DB_WE->f('IntCustomerID');
			$strSerialOrder = $DB_WE->f('strSerialOrder');
			$orderData = @unserialize($strSerialOrder);
		}
	}

	// get Customer
	$query = '
		SELECT *
		FROM ' . CUSTOMER_TABLE . '
		WHERE ID=' . addslashes($customerId);

	$customerDb = array();
	$DB_WE->query($query);

	if ($DB_WE->next_record()) {
		$customerDb = $DB_WE->Record;
	}

	$customerOrder = (isset($orderData[WE_SHOP_CART_CUSTOMER_FIELD]) ? $orderData[WE_SHOP_CART_CUSTOMER_FIELD] : array());

	// default values are fields saved with order
	$tmpCustomer = array_merge($customerDb, $customerOrder);

	// only fields explicity set with the order are shown here
	if (isset($strFelder) && isset($strFelder['customerFields'])) {

		foreach ($strFelder['customerFields'] as $k) {

			if ( isset($customerDb[$k]) ) {
				$tmpCustomer[$k] = $customerDb[$k];
			}
		}
	}

	$_customer = array();

	foreach ($tmpCustomer as $k => $v) {

		if (!is_int($k)) {
			$_customer[$k] = $v;
		}
	}
	return $_customer;
}

function getFieldFromOrder($bid,$field) {

	global $DB_WE;

	$query = "
		SELECT $field
		FROM " . SHOP_TABLE . "
		WHERE IntOrderID=" . addslashes($_REQUEST['bid']);

	$DB_WE->query($query);

	if ($GLOBALS['DB_WE']->next_record()) {

		return $DB_WE->f($field);
	} else {
		return '';
	}
}

function updateFieldFromOrder($orderId, $fieldname, $value) {

	global $DB_WE;

	$upQuery = '
		UPDATE ' . SHOP_TABLE . '
		SET ' . $fieldname . '="' . addslashes($value) . '"
		WHERE IntOrderID=' . addslashes($_REQUEST['bid']);

	if ($DB_WE->query($upQuery)) {
		return true;
	} else {
		return false;
	}
}

// config
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));

		$waehr="&nbsp;".$feldnamen[0];
		$dbTitlename="shoptitle";
		$dbPreisname="price";
		$numberformat= $feldnamen[2];
		$classid= (isset($feldnamen[3]) ? $feldnamen[3] : '');
		$classIds = makeArrayFromCSV($classid);
		$mwst = (!empty($feldnamen[1]))?(($feldnamen[1])):'';
		$notInc ="tblTemplates";

		$da = "%d.%m.%Y";
		$dateform = "00.00.0000";

// determine the number format
function numfom($result){
	global $numberformat;
	$result = we_util::std_numberformat($result);
	if($numberformat=="german"){
		$result=number_format($result,2,",",".");
	}else if($numberformat=="french"){
		$result=number_format($result,2,",","&nbsp;");
	}else if($numberformat=="english"){
		$result=number_format($result,2,".","");
	}else if($numberformat=="swiss"){
	    $result=number_format($result,2,".","'");
	}
	return $result;
}
if (isset($_REQUEST['we_cmd'][0])) {

	switch ($_REQUEST['we_cmd'][0]) {

		case 'add_article':

			if ($_REQUEST["anzahl"] > 0) {

				// add complete article / object here - inclusive request fields
				$_strSerialOrder = getFieldFromOrder($_REQUEST["bid"], 'strSerialOrder');

				$tmp = explode("_",$_REQUEST["add_article"]);
				$isObj = ($tmp[1] == "o");

				$id = $tmp[0];

				// check for variant or customfields
				$customFieldsTmp = array();
				if (strlen($_REQUEST['we_customField'])) {

					$fields = explode(';', trim($_REQUEST['we_customField']));

					if (is_array($fields)) {
						foreach ($fields as $field) {

							$fieldData = explode('=',$field);

							if (is_array($fieldData) && sizeof($fieldData) == 2) {
								$customFieldsTmp[trim($fieldData[0])] = trim($fieldData[1]);
							}
							unset($fieldData);
						}
					}
					unset($fields);
				}


				if ($isObj) {
					$serialDoc = Basket::getserial($id, 'o', $_REQUEST['we_variant'], $customFieldsTmp);
				} else {
					$serialDoc = Basket::getserial($id, 'w', $_REQUEST['we_variant'], $customFieldsTmp);
				}

				unset($customFieldsTmp);

				// shop vats must be calculated
				require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
				$standardVat = weShopVats::getStandardShopVat();

				if (isset($serialDoc[WE_SHOP_VAT_FIELD_NAME])) {
					$shopVat = weShopVats::getShopVATById($serialDoc[WE_SHOP_VAT_FIELD_NAME]);
				}

				if (isset($shopVat) && $shopVat) {
					$serialDoc[WE_SHOP_VAT_FIELD_NAME] = $shopVat->vat;
				} else {
					if ($standardVat) {
						$serialDoc[WE_SHOP_VAT_FIELD_NAME] = $standardVat->vat;
					}
				}

				$preis = getFieldFromShoparticle($serialDoc,'price');

				// now insert article to order:
				$DB_WE->query("SELECT IntOrderID, IntCustomerID, DateOrder, DateShipping, Datepayment,IntPayment_Type FROM ".SHOP_TABLE." WHERE IntOrderID = ".$_REQUEST["bid"]);
				$DB_WE->next_record();

				$sql="
					INSERT INTO ".SHOP_TABLE."
						(IntArticleID,IntQuantity,Price,IntOrderID, IntCustomerID, DateOrder, DateShipping, Datepayment,IntPayment_Type,strSerial,strSerialOrder)
					VALUES
						(\"$id\", \"" . $_REQUEST["anzahl"] . "\",\"" . $preis . "\", \"" . $DB_WE->f("IntOrderID") . "\", \"".$DB_WE->f("IntCustomerID")."\",\"".$DB_WE->f("DateOrder")."\",\"".$DB_WE->f("DateShipping")."\",\"".$DB_WE->f("Datepayment")."\",\"".$DB_WE->f("IntPayment_Type")."\",'" . addslashes(serialize($serialDoc)) . "', '$_strSerialOrder')";
				$DB_WE->query($sql);
			}

		break;

		case 'add_new_article':

			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_class.inc.php');

			$shopArticles = array();
			$shopArticlesSelect = array();
			$parts = array();

			$we_button = new we_button();

			$saveBut   = '';
			$cancelBut = $we_button->create_button('cancel', "javascript:window.close();");
			$searchBut = $we_button->create_button('search', "javascript:searchArticles();");

			// first get all shop documents
			$query = '
				SELECT ' . CONTENT_TABLE . '.dat AS shopTitle, ' . LINK_TABLE . '.DID AS documentId
				FROM ' . CONTENT_TABLE . ', ' . LINK_TABLE . ', ' . FILE_TABLE . '
				WHERE ' . FILE_TABLE . '.ID = ' . LINK_TABLE . '.DID
					AND ' . LINK_TABLE . '.CID = ' . CONTENT_TABLE . '.ID
					AND ' . LINK_TABLE . '.Name = "shoptitle"
					AND ' . LINK_TABLE . '.DocumentTable != "tblTemplates"
			';

			if ( isset($_REQUEST['searchArticle']) && $_REQUEST['searchArticle'] ) {
				$query .= '
					AND ' . CONTENT_TABLE . '.Dat LIKE "%' . addslashes($_REQUEST['searchArticle']) . '%"';
			}

			$DB_WE->query($query);

			while ($DB_WE->next_record()) {
				$shopArticles[$DB_WE->f('documentId') . '_d'] = $DB_WE->f("shopTitle").' ['.$DB_WE->f("documentId").']'.$l_shop["isDoc"];
			}

			if (defined('OBJECT_TABLE')) {
				// now get all shop objects
				foreach ($classIds as $_classId) {

					$query = '
						SELECT  ' . OBJECT_X_TABLE . $_classId . '.input_shoptitle as shopTitle, ' . OBJECT_X_TABLE . $_classId . '.OF_ID as objectId
						FROM ' . OBJECT_X_TABLE . $_classId . ', ' . OBJECT_FILES_TABLE . '
						WHERE ' . OBJECT_X_TABLE . $_classId . '.OF_ID = ' . OBJECT_FILES_TABLE . '.ID
							AND ' . OBJECT_X_TABLE . $_classId . '.ID = ' . OBJECT_FILES_TABLE . '.ObjectID
					';

					if ( isset($_REQUEST['searchArticle']) && $_REQUEST['searchArticle'] ) {
						$query .= '
							AND ' . OBJECT_X_TABLE . $_classId . '.input_shoptitle  LIKE "%' . addslashes($_REQUEST['searchArticle']) . '%"';
					}

					$DB_WE->query($query);
					while ($DB_WE->next_record()) {
						$shopArticles[$DB_WE->f('objectId') . '_o'] = $DB_WE->f('shopTitle') . ' [' . $DB_WE->f('objectId') . ']' . $l_shop['isObj'];
					}
				}
				unset($_classId);
			}

			unset($query);

			// <<< determine which articles should be shown ...

			asort($shopArticles);
			$MAX_PER_PAGE = 15;
			$AMOUNT_ARTICLES = sizeof($shopArticles);



			$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;

			$shopArticlesParts = array_chunk($shopArticles, $MAX_PER_PAGE, true);

			$start_entry = $page * $MAX_PER_PAGE + 1;
			$end_entry   = (($page * $MAX_PER_PAGE + $MAX_PER_PAGE < $AMOUNT_ARTICLES) ? ($page * $MAX_PER_PAGE + $MAX_PER_PAGE) : $AMOUNT_ARTICLES );

			if ($start_entry - $MAX_PER_PAGE > 0) {
				$backBut = $we_button->create_button('back', "javascript:switchEntriesPage(" . ($page-1) . ");");
			} else {
				$backBut = $we_button->create_button('back', "#", true, 100, 22, '', '', true);
			}

			if ( ($end_entry) < $AMOUNT_ARTICLES) {
				$nextBut = $we_button->create_button('next', "javascript:switchEntriesPage(" . ($page+1) . ");");
			} else {
				$nextBut = $we_button->create_button('next', "#", true, 100, 22, '', '', true);
			}

			$shopArticlesSelect = $shopArticlesParts[$page];
			asort($shopArticlesSelect);

			// determine which articles should be shown >>>


			print '
	<script type="text/javascript">
		self.focus();

		function selectArticle(articleInfo) {

			document.location = "?we_cmd[0]=' . $_REQUEST['we_cmd'][0] . '&bid=' . $_REQUEST['bid'] .'&page=' . $page .  (isset($_REQUEST['searchArticle']) ? '&searchArticle=' . $_REQUEST['searchArticle'] : '') .  '&add_article=" + articleInfo;
		}

		function switchEntriesPage(pageNum) {

			document.location = "?we_cmd[0]=' . $_REQUEST['we_cmd'][0] . '&bid=' . $_REQUEST['bid'] . (isset($_REQUEST['searchArticle']) ? '&searchArticle=' . $_REQUEST['searchArticle'] : '') . '&page=" + pageNum;
		}

		function searchArticles() {

			field = document.getElementById("searchArticle");
			document.location = "?we_cmd[0]=' . $_REQUEST['we_cmd'][0] . '&bid=' . $_REQUEST['bid'] . '&searchArticle=" + field.value;
		}

	</script>
</head>
<body class="weDialogBody">
			';

			if ( $AMOUNT_ARTICLES > 0) {

				array_push($parts, array(
				    'headline' => $l_shop["Artikel"],
				    'space' => 100,
					'html' => '<form name="we_intern_form">' . hidden('bid', $_REQUEST['bid']) . hidden("we_cmd[]", 'add_new_article') . '
					<table border="0" cellpadding="0" cellspacing="0">
					<tr><td>' . we_class::htmlSelect("add_article", $shopArticlesSelect, 15, (isset($_REQUEST['add_article']) ? $_REQUEST['add_article'] : ''), false, 'onchange="selectArticle(this.options[this.selectedIndex].value);"', 'value', '380') . '</td>
					<td>' . getPixel(10,1) . '</td>
					<td valign="top">' . $backBut . '<div style="margin:5px 0"></div>' . $nextBut . '</td>
					</tr>
					<tr>
						<td class="small">' . sprintf($l_shop['add_article']['entry_x_to_y_from_z'], $start_entry, $end_entry, $AMOUNT_ARTICLES) . '</td>
					</tr>
					</table>',
					'noline' => 1
					)
				);

			} else {
				array_push($parts, array(
			    	'headline' => $l_shop["Artikel"],
				    'space' => 100,
					'html' => $l_shop['add_article']['empty_articles']
					)
				);
			}

			if ($AMOUNT_ARTICLES > 0 || isset($_REQUEST['searchArticle'])) {
				array_push($parts, array(
				    'headline' => $GLOBALS['l_global']['search'],
				    'space' => 100,
					'html' => '<table border="0" cellpadding="0" cellspacing="0">
					<tr><td>' . we_class::htmlTextInput('searchArticle', 24, ( isset($_REQUEST['searchArticle']) ? $_REQUEST['searchArticle'] : '' ), '', 'id="searchArticle"', 'text', 380  ) . '</td>
					<td>' . getPixel(10,1) . '</td>
					<td>' . $searchBut . '</td>
					</tr>
					</table>
					</form>'
				)
			);
			}

			if (isset($_REQUEST['add_article']) && $_REQUEST['add_article'] != '0') {

				$saveBut = $we_button->create_button('save', "javascript:document.we_form.submit();window.close();");

				require_once(WE_SHOP_MODULE_DIR . 'weShopVariants.inc.php');

				$articleInfo = explode('_', $_REQUEST['add_article']);

				$id = $articleInfo[0];
				$type = $articleInfo[1];

				$variantData = array();

				$variantOptions = array();
				$variantOptions['-'] = '-';

				if ($type == 'o') {

					require_once(WE_OBJECT_MODULE_DIR . 'we_objectFile.inc.php');

					$model = new we_objectFile();
					$model->initByID($id, OBJECT_FILES_TABLE);

					$variantData = weShopVariants::getVariantData($model, '-');

				} else {

					require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_webEditionDocument.inc.php');

					$model = new we_webEditionDocument();
					$model->initByID($id);

					$variantData = weShopVariants::getVariantData($model, '-');

				}

				for ( $i=0; $i<sizeof($variantData); $i++ ) {
					list($key, $varData) = each($variantData[$i]);
					if ($key != '-') {
						$variantOptions[$key] = $key;
					}
				}

				array_push($parts, array(
				    'headline' => $l_shop["Artikel"],
				    'space' => 100,
					'html' => '
					<form name="we_form" target="edbody">
					' . hidden('bid', $_REQUEST['bid']) .
					hidden("we_cmd[]", 'add_article') .
					hidden("add_article", $_REQUEST['add_article']) .
					'
					<b>' . $model->elements['shoptitle']['dat'] . '</b>',
					'noline' => 1
					)
				);

				unset($model);

				array_push($parts, array(
				    'headline' => $l_shop["Anzahl"],
				    'space' => 100,
					'html' => we_class::htmlTextInput('anzahl', 24, '', '', '', 'text', 380),
					'noline' => 1
					)
				);

				array_push($parts, array(
				    'headline' => $l_shop["variant"],
				    'space' => 100,
					'html' => we_class::htmlSelect('we_variant', $variantOptions, 1, '', false, '', 'value', 380),
					'noline' => 1
					)
				);

				array_push($parts, array(
				    'headline' => $l_shop["customField"],
				    'space' => 100,
					'html' =>	we_class::htmlTextInput('we_customField', 24, '', '', '', 'text', 380) .
								'<br /><span class="small">Eingabe in der Form: <i>name1=wert1;name2=wert2</i></span></form>',
					'noline' => 1
					)
				);

				unset($id);
				unset($type);
				unset($variantData);
				unset($model);

	}


	print we_multiIconBox::getHTML("","100%",$parts,30,we_button::position_yes_no_cancel($saveBut,'',$cancelBut),-1,"","",false,$l_shop['add_article']['title']);
	print '
</form>
</body>
</html>';
			unset($saveBut);
			unset($cancelBut);
			unset($selectBut);
			unset($parts);
			unset($shopArticles);
		exit;
		break;

		case 'payVat':

			$strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');

			$serialOrder = @unserialize($strSerialOrder);
			$serialOrder[WE_SHOP_CALC_VAT] = $_REQUEST['pay'] == '1' ? 1 : 0;

			// update all orders with this orderId
			if(updateFieldFromOrder($_REQUEST['bid'], 'strSerialOrder', serialize($serialOrder))) {
				$alertMessage = $l_shop['edit_order']['js_saved_calculateVat_success'];
				$alertType = WE_MESSAGE_NOTICE;
			} else {
				$alertMessage = $l_shop['edit_order']['js_saved_calculateVat_error'];
				$alertType = WE_MESSAGE_ERROR;
			}
			unset($serialOrder);
			unset($strSerialOrder);
		break;

		case 'delete_shop_cart_custom_field':

			if (isset($_REQUEST['cartfieldname']) && $_REQUEST['cartfieldname']) {

				$strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');

				$serialOrder = @unserialize($strSerialOrder);
				unset($serialOrder[WE_SHOP_CART_CUSTOM_FIELD][$_REQUEST['cartfieldname']]);

				// update all orders with this orderId
				if(updateFieldFromOrder($_REQUEST['bid'], 'strSerialOrder', serialize($serialOrder))) {
					$alertMessage = sprintf($l_shop['edit_order']['js_delete_cart_field_success'], $_REQUEST['cartfieldname']);
					$alertType = WE_MESSAGE_NOTICE;
				} else {
					$alertMessage = sprintf($l_shop['edit_order']['js_delete_cart_field_error'], $_REQUEST['cartfieldname']);
					$alertType = WE_MESSAGE_ERROR;
				}
			}
			unset($strSerialOrder);
			unset($serialOrder);
		break;

		case 'edit_shop_cart_custom_field':

			print '
			' . we_htmlElement::jsElement('
	function we_submit() {
		elem = document.getElementById("cartfieldname");

		if (elem && elem.value) {
			document.we_form.submit();
		} else {
			' . we_message_reporting::getShowMessageCall( $l_shop['field_empty_js_alert'], WE_MESSAGE_ERROR) . '
		}

	}
			') . '
			</head>
<body class="weDialogBody">
<form name="we_form">
<input type="hidden" name="bid" value="' . $_REQUEST['bid'] . '" />
<input type="hidden" name="we_cmd[0]" value="save_shop_cart_custom_field" />
';
			$saveBut = $we_button->create_button('save', "javascript:we_submit();");
			$cancelBut = $we_button->create_button('cancel', "javascript:self.close();");

			$parts = array();

			$val = '';

			if (isset($_REQUEST['cartfieldname']) && $_REQUEST['cartfieldname']) {

				$strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');
				$serialOrder = @unserialize($strSerialOrder);

				$val = $serialOrder[WE_SHOP_CART_CUSTOM_FIELD][$_REQUEST['cartfieldname']] ? $serialOrder[WE_SHOP_CART_CUSTOM_FIELD][$_REQUEST['cartfieldname']] : '';

				$fieldHtml = $_REQUEST['cartfieldname'] . '<input type="hidden" name="cartfieldname" id="cartfieldname" value="' . $_REQUEST['cartfieldname'] . '" />';
			} else {
				$fieldHtml = htmlTextInput('cartfieldname', 24, '', '', 'id="cartfieldname"');
			}

			// make input field, for name or textfield
			array_push($parts, array(
				'headline' => $l_shop['field_name'],
				'html' => $fieldHtml,
				'space' => 120,
				'noline' => 1
				)
			);
			array_push($parts, array(
				'headline' => $l_shop['field_value'],
				'html' => '<textarea name="cartfieldvalue" style="width: 350; height: 150">' . $val . '</textarea>',
				'space' => 120
				)
			);

			print we_multiIconBox::getHTML("","100%",$parts,30,we_button::position_yes_no_cancel($saveBut,'',$cancelBut),-1,"","",false,$l_shop['add_shop_field']);
			unset($saveBut);
			unset($canelBut);
			unset($parts);
			unset($val);
			unset($fieldHtml);
			print '
				</form></body>
</html>';
			exit;
		break;

		case 'save_shop_cart_custom_field':

			if (isset($_REQUEST['cartfieldname']) && $_REQUEST['cartfieldname']) {

				$strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');

				$serialOrder = @unserialize($strSerialOrder);
				$serialOrder[WE_SHOP_CART_CUSTOM_FIELD][$_REQUEST['cartfieldname']] = htmlentities($_REQUEST['cartfieldvalue']);

				// update all orders with this orderId
				if(updateFieldFromOrder($_REQUEST['bid'], 'strSerialOrder', serialize($serialOrder))) {
					$jsCmd = '
					top.opener.top.content.shop_tree.doClick(' . $_REQUEST['bid'] . ',"shop","' . SHOP_TABLE . '");
					' . we_message_reporting::getShowMessageCall( sprintf($l_shop['edit_order']['js_saved_cart_field_success'], $_REQUEST['cartfieldname']), WE_MESSAGE_NOTICE) . '
					window.close();
					';
				} else {
					$jsCmd = we_message_reporting::getShowMessageCall( sprintf($l_shop['edit_order']['js_saved_cart_field_error'], $_REQUEST['cartfieldname']), WE_MESSAGE_ERROR) . '
					window.close();
					';
				}

			} else {

				$jsCmd = we_message_reporting::getShowMessageCall( $l_shop['field_empty_js_alert'], WE_MESSAGE_ERROR) . '
					window.close();
					';
			}



			print '
			' . we_htmlElement::jsElement($jsCmd) . '
			</head>
<body></body>
</html>';
			unset($serialOrder);
			unset($strSerialOrder);
			exit;
		break;

		case 'edit_shipping_cost':

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");
			require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');

			$shopVats = weShopVats::getAllShopVATs();
			$shippingVats = array();

			foreach ($shopVats as $k => $shopVat) {
				if (strlen($shopVat->vat . ' - ' . $shopVat->text) > 20) {
					$shippingVats[$shopVat->vat] = substr($shopVat->vat . ' - ' . $shopVat->text, 0, 16) . ' ...';
				} else {
					$shippingVats[$shopVat->vat] = $shopVat->vat . ' - ' . $shopVat->text;
				}
			}

			unset($shopVat);
			unset($shopVats);
			$we_button = new we_button();
			$saveBut = $we_button->create_button('save', "javascript:document.we_form.submit();self.close();");
			$cancelBut = $we_button->create_button('cancel', "javascript:self.close();");

			$strSerialOrder = getFieldFromOrder($_REQUEST['bid'],'strSerialOrder');

			if ($strSerialOrder) {

				$serialOrder = @unserialize($strSerialOrder);

				$shippingCost  = $serialOrder[WE_SHOP_SHIPPING]['costs'];
				$shippingIsNet = $serialOrder[WE_SHOP_SHIPPING]['isNet'];
				$shippingVat   = $serialOrder[WE_SHOP_SHIPPING]['vatRate'];

			} else {

				$shippingCost  = '0';
				$shippingIsNet = '1';
				$shippingVat   = '19';
			}

			$parts = array();
			array_push($parts, array(
			    'headline' => $l_shop['edit_order']['shipping_costs'],
			    'space' => 150,
				'html' => we_class::htmlTextInput("weShipping_costs", 24, $shippingCost),
				'noline' => 1
				)
			);

			array_push($parts, array(
			    'headline' => $l_shop['edit_shipping_cost']['isNet'],
			    'space' => 150,
				'html' => we_class::htmlSelect("weShipping_isNet", array('1'=>$GLOBALS['l_global']['yes'], '0'=>$GLOBALS['l_global']['no']), 1, $shippingIsNet),
				'noline' => 1
				)
			);

			array_push($parts, array(
			    'headline' => $l_shop['edit_shipping_cost']['vatRate'],
			    'space' => 150,
				'html' => we_getInputChoiceField("weShipping_vatRate", $shippingVat, $shippingVats, array(), '', true),
				'noline' => 1
				)
			);


			print '
				</head>
				<body class="weDialogBody">
				<form name="we_form" target="edbody">
				' . hidden('bid', $_REQUEST['bid']) .
				hidden("we_cmd[]", 'save_shipping_cost');
				print we_multiIconBox::getHTML("","100%",$parts,30,we_button::position_yes_no_cancel($saveBut,'',$cancelBut),-1,"","",false,$l_shop['edit_shipping_cost']['title']);
				print '
				</form>
				</body>
				</html>';
			exit;
		break;

		case 'save_shipping_cost':

			$strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');
			$serialOrder = @unserialize($strSerialOrder);

			if ($serialOrder) {

				$weShippingCosts = str_replace(",", ".",$_REQUEST['weShipping_costs']);
			    $serialOrder[WE_SHOP_SHIPPING]['costs'] = $weShippingCosts;
				$serialOrder[WE_SHOP_SHIPPING]['isNet'] = $_REQUEST['weShipping_isNet'];
				$serialOrder[WE_SHOP_SHIPPING]['vatRate'] = $_REQUEST['weShipping_vatRate'];

				// update all orders with this orderId
				if(updateFieldFromOrder($_REQUEST['bid'], 'strSerialOrder', serialize($serialOrder))) {
					$alertMessage = $l_shop['edit_order']['js_saved_shipping_success'];
					$alertType = WE_MESSAGE_NOTICE;
				} else {
					$alertMessage = $l_shop['edit_order']['js_saved_shipping_error'];
					$alertType = WE_MESSAGE_ERROR;
				}
			}

			unset($strSerialOrder);
			unset($serialOrder);
		break;

		case 'edit_order_customer'; // edit data of the saved customer.

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");

			$we_button = new we_button();
			$saveBut = $we_button->create_button('save', "javascript:document.we_form.submit();self.close();");
			$cancelBut = $we_button->create_button('cancel', "javascript:self.close();");

			// 1st get the customer for this order
			$_customer = getOrderCustomerData($_REQUEST['bid']);
			ksort($_customer);

			$dontEdit = array('ID', 'Username', 'Password', 'MemberSince','LastLogin','LastAccess','ParentID','Path','IsFolder','Icon','Text', 'Forename', 'Surname');

			$parts = array();
			array_push($parts,array(
					'html' => htmlAlertAttentionBox($l_shop['preferences']['explanation_customer_odercustomer'], 2,470),
					'space' => 0
				)
			);
			$editFields = array();


			array_push($parts,array(
					'headline' => $l_customer['Forname'].": ",
					'space' => 150,
					'html' => we_class::htmlTextInput("weCustomerOrder[Forename]", 44, $_customer['Forename']),
					'noline' => 1
				)
			);
			$editFields[] = 'Forename';

			array_push($parts,array(
					'headline' => $l_customer['Surname'].": ",
					'space' => 150,
					'html' => we_class::htmlTextInput("weCustomerOrder[Surname]", 44, $_customer['Surname']),
					'noline' => 1
				)
			);
			$editFields[] = 'Surname';

			foreach ($_customer as $k => $v) {
				if (!in_array($k, $dontEdit)) {
					array_push($parts,array(
							'headline' => "$k: ",
							'space' => 150,
							'html' => we_class::htmlTextInput("weCustomerOrder[$k]", 44, $v),
							'noline' => 1
						)
					);
					$editFields[] = $k;
				}
			}

			print '
				</head>
				<body class="weDialogBody">
				<form name="we_form" target="edbody">
				' . hidden('bid', $_REQUEST['bid']) .
				hidden("we_cmd[]", 'save_order_customer');
				print we_multiIconBox::getHTML("","100%",$parts,30,we_button::position_yes_no_cancel($saveBut,'',$cancelBut),-1,"","",false,$l_shop['preferences']['customerdata'],"",560);
				print '
				</form>
				</body>
				</html>';
			exit;
		break;

		case 'save_order_customer':

			// just get this order and save this userdata in there.

			$_strSerialOrder = getFieldFromOrder($_REQUEST['bid'], 'strSerialOrder');

			$_orderData = @unserialize($_strSerialOrder);
			$_customer = $_REQUEST['weCustomerOrder'];

			$_orderData[WE_SHOP_CART_CUSTOMER_FIELD] = $_customer;


			if (updateFieldFromOrder($_REQUEST['bid'], 'strSerialOrder', serialize($_orderData))) {
				$alertMessage = $l_shop['edit_order']['js_saved_customer_success'];
				$alertType = WE_MESSAGE_NOTICE;
			} else {
				$alertMessage = $l_shop['edit_order']['js_saved_customer_error'];
				$alertType = WE_MESSAGE_ERROR;
			}

			unset($query);
			unset($upQuery);
			unset($_customer);
			unset($_orderData);
			unset($_strSerialOrder);
		break;
	}
}


htmlTop();

print STYLESHEET;


if(isset($_REQUEST["deletethisorder"])){

	$DB_WE->query("DELETE FROM ".SHOP_TABLE." where IntOrderID = ".$_REQUEST["bid"]);
	echo '
	<script language="JavaScript" type="text/javascript">top.content.deleteEntry('.$_REQUEST["bid"].')</script>
	</head>
	<body class="weEditorBody" onunload="doUnload()">
	<table border="0" cellpadding="0" cellspacing="2" width="300">
      <tr>
        <td colspan="2" class="defaultfont">'.htmlDialogLayout("<span class='defaultfont'>".$l_shop["geloscht"]."</span>",$l_shop["loscht"]).'</td>
      </tr>
      </table></html>';
      exit;
}

if(isset($_REQUEST["deleteaartikle"])){
	
	$DB_WE->query("DELETE FROM ".SHOP_TABLE." where IntID = ".$_REQUEST["deleteaartikle"]);
	$DB_WE->query("SELECT IntID from ".SHOP_TABLE." where IntOrderID = ".$_REQUEST["bid"]);
	$l=$DB_WE->num_rows();
	if( $l<1 ) {
		$letzerartikel=1;
	}
}

if(isset($_REQUEST["DatePayment"])){
	
	$DateOrder_ARR = explode(".", $_REQUEST["DatePayment"]);
	$DateOrder1 = $DateOrder_ARR[2] . "-" . $DateOrder_ARR[1] . "-" . $DateOrder_ARR[0] . " 00:00:00";
	
	$DB_WE->query("update ".SHOP_TABLE." SET DatePayment='". $DateOrder1 . "' where IntOrderID = ".$_REQUEST["bid"]);
}


if(isset($_REQUEST["article"])){
	if(isset($_REQUEST["preis"])){
		$DB_WE->query("update ".SHOP_TABLE." SET Price='" . $_REQUEST["preis"] . "' where IntID = ".$_REQUEST["article"]);
	}else if(isset($_REQUEST["anzahl"])){
		$DB_WE->query("update ".SHOP_TABLE." SET IntQuantity='" . $_REQUEST["anzahl"] . "' where IntID = ".$_REQUEST["article"]);
	} else if (isset($_REQUEST['vat'])) {

		$DB_WE->query('SELECT strSerial FROM ' . SHOP_TABLE . ' WHERE IntID = ' . addslashes($_REQUEST["article"]));

		if ($DB_WE->num_rows() == 1) {

			$DB_WE->next_record();

			$strSerial = $DB_WE->f('strSerial');
			$tmpDoc = @unserialize($strSerial);
			$tmpDoc[WE_SHOP_VAT_FIELD_NAME] = $_REQUEST['vat'];

			$DB_WE->query("update ".SHOP_TABLE." SET strSerial='" . addslashes(serialize($tmpDoc)) . "' where IntID = " . addslashes($_REQUEST["article"]));
			unset($strSerial);
			unset($tmpDoc);
		}
	}
}

if(isset($_REQUEST["DateOrder"])){
	
	$DateOrder_ARR = explode(".", $_REQUEST["DateOrder"]);
	$DateOrder1 = $DateOrder_ARR[2] . "-" . $DateOrder_ARR[1] . "-" . $DateOrder_ARR[0] . " 00:00:00";
					
	$DB_WE->query("update ".SHOP_TABLE." SET DateOrder='$DateOrder1' where IntOrderID = ".$_REQUEST["bid"]);
	$DB_WE->query("SELECT IntOrderID,DateShipping, DATE_FORMAT(DateOrder,'".$da."') as orddate FROM ".SHOP_TABLE." group by IntOrderID order by intID DESC");
    $DB_WE->next_record();
    
}

if(isset($_REQUEST["DateShipping"])){ // ist bearbeitet
	
	$DateOrder_ARR = explode(".", $_REQUEST["DateShipping"]);
	$DateOrder1 = $DateOrder_ARR[2] . "-" . $DateOrder_ARR[1] . "-" . $DateOrder_ARR[0] . " 00:00:00";
	
	$DB_WE->query("update ".SHOP_TABLE." SET DateShipping='" . $DateOrder1 . "' where IntOrderID = ".$_REQUEST["bid"]);
	$DB_WE->query("SELECT IntOrderID, DATE_FORMAT(DateOrder,'".$da."') as orddate FROM ".SHOP_TABLE." group by IntOrderID order by intID DESC");
    $DB_WE->next_record();
}


if( !isset($letzerartikel) ){ // order has still articles - get them all

	// ********************************************************************************
	// first get all information about orders, we need this for the rest of the page
	//
	$query = "
		SELECT IntID, IntCustomerID, IntArticleID, strSerial, strSerialOrder, IntQuantity, Price, DATE_FORMAT(DateShipping,'".$da."') as DateShipping, DATE_FORMAT(DatePayment,'".$da."') as DatePayment, DATE_FORMAT(DateOrder,'".$da."') as DateOrder
		FROM ".SHOP_TABLE."
		WHERE IntOrderID = ".$_REQUEST["bid"];

    $DB_WE->query($query);

    // loop through all articles
	while ( $DB_WE->next_record() ) {

		// get all needed information for order-data
		$_REQUEST["cid"] = $DB_WE->f("IntCustomerID");
		$SerialOrder[] = $DB_WE->f("strSerialOrder");
		$_REQUEST["DateOrder"] = $DB_WE->f("DateOrder");
		$_REQUEST["DatePayment"] = $DB_WE->f("DatePayment");
		$_REQUEST["DateShipping"] = $DB_WE->f("DateShipping");

		// all information for article
		$ArticleId[] = $DB_WE->f("IntArticleID"); // id of article (object or document) in shopping cart
		$tblOrdersId[] = $DB_WE->f("IntID");
		$Quantity[] = $DB_WE->f("IntQuantity");
		$Serial[] = $DB_WE->f("strSerial"); // the serialised doc
		$Price[] = str_replace(',', '.', $DB_WE->f("Price") ); // replace , by . for float values
	}
	if ( !isset( $ArticleId ) ) {
		
		echo '
	<script language="JavaScript" type="text/javascript">
		parent.parent.frames.shop_header_icons.location.reload();
	</script>
	</head>
	<body class="weEditorBody" onunload="doUnload()">
	<table border="0" cellpadding="0" cellspacing="2" width="300">
      <tr>
        <td colspan="2" class="defaultfont">'.htmlDialogLayout("<span class='defaultfont'>" . $l_shop["orderDoesNotExist"] . "</span>",$l_shop["loscht"]).'</td>
      </tr>
      </table></html>';
      exit;
	}
	//
	// first get all information about orders, we need this for the rest of the page
	// ********************************************************************************

	// ********************************************************************************
	// no get information about complete order
	// - pay VAT?
	// - prices are net?
	if (sizeof($ArticleId)) {

		// first unserialize order-data
		if (!empty($SerialOrder[0])) {

			$orderData = @unserialize($SerialOrder[0]);
			$customCartFields = isset($orderData[WE_SHOP_CART_CUSTOM_FIELD]) ? $orderData[WE_SHOP_CART_CUSTOM_FIELD] : array();
		} else {
			$orderData = array();
			$customCartFields = array();
		}

		// prices are net?
		$pricesAreNet = true;
		if ( isset($orderData[WE_SHOP_PRICE_IS_NET_NAME]) ) {
			$pricesAreNet = $orderData[WE_SHOP_PRICE_IS_NET_NAME];
		}

		// must calculate vat?
		$calcVat = true;
		if (isset($orderData[WE_SHOP_CALC_VAT])) {
			$calcVat = $orderData[WE_SHOP_CALC_VAT];
		}
	}
	//
	// no get information about complete order
	// ********************************************************************************



	// ********************************************************************************
	// Building table with customer and order data fields - start
	//
	$customerFieldTable = '';

	// determine all fields for order head

	$DB_WE->query(
		'SELECT strFelder
		FROM ' . ANZEIGE_PREFS_TABLE . '
		WHERE strDateiname = "edit_shop_properties"'
	);

	$DB_WE->next_record();

	$strFelder = $DB_WE->f("strFelder");

	if ($fields = @unserialize($strFelder)) {
		// we have an array with following syntax:
		// array ( 'customerFields' => array('fieldname ...',...)
		//         'orderCustomerFields' => array('fieldname', ...) )

	} else {

		$fields['customerFields'] = array();
		$fields['orderCustomerFields'] = array();

		// the save format used to be ...
		// Vorname:tblWebUser||Forename,Nachname:tblWebUser||Surname,Contact/Address1:tblWebUser||Contact_Address1,Contact/Address1:tblWebUser||Contact_Address1,...
		$_fieldInfos = explode(",",$strFelder);

		foreach ($_fieldInfos as $_fieldInfo) {

			$tmp1 = explode('||', $_fieldInfo);
			$tmp2 = explode(':',$tmp1[0]);

			$_fieldname = $tmp1[1];
			$_titel = $tmp2[0];
			$_tbl = $tmp2[1];

			if ($_tbl != 'webE') {
				$fields['customerFields'][] = $_fieldname;
			}

		}
		$fields['customerFields'] = array_unique($fields['customerFields']);

		unset($_tmpEntries);
	}

	// >>>> Getting customer data
	$_customer = getOrderCustomerData(0, $orderData, $_REQUEST['cid'], $fields);
	// <<<< End of getting customer data

    $fl=0;


    // first show fields Forename and surname
    if(isset($_customer['Forename'])) {
    	$customerFieldTable .=
    		'	<tr height="25">
											<td class="defaultfont" width="86" valign="top" height="25">' . $l_customer['Forname'] . ':</td>
											<td class="defaultfont" valign="top" width="40" height="25"></td>
											<td width="20" height="25"></td>
											<td class="defaultfont" valign="top" colspan="6" height="25">' . $_customer['Forename'] . '</td>
				</tr>';
    }
    if(isset($_customer['Surname'])) {
		$customerFieldTable .=
    		'	<tr height="25">
											<td class="defaultfont" width="86" valign="top" height="25">' . $l_customer['Surname'] . ':</td>
											<td class="defaultfont" valign="top" width="40" height="25"></td>
											<td width="20" height="25"></td>
											<td class="defaultfont" valign="top" colspan="6" height="25">' . $_customer['Surname'] . '</td>
				</tr>';
    }

    foreach ($_customer as $key => $value) {

    	if (in_array($key, $fields['customerFields']) || in_array($key, $fields['orderCustomerFields'])) {

    		$customerFieldTable .=
    		'	<tr height="25">
											<td class="defaultfont" width="86" valign="top" height="25">'.$key.':</td>
											<td class="defaultfont" valign="top" width="40" height="25"></td>
											<td width="20" height="25"></td>
											<td class="defaultfont" valign="top" colspan="6" height="25">' . $value . '</td>
				</tr>
											';

    	}
    }



	$orderDataTable = '
	<table cellpadding="0" cellspacing="0" border="0" width="99%" class="defaultfont">
											<tr height="25">

												<td class="defaultfont" width="86" valign="top" height="25">'.$l_shop["bestellnr"].'</td>
												<td class="defaultfont" valign="top" width="40" height="25"><b>'.$_REQUEST["bid"].'</b></td>
												<td width="20" height="25">'.getPixel(34,15).'</td>
												<td width="98" class="defaultfont" height="25">'.$l_shop["bestelldatum"].'</td>
												<td height="25">'.getPixel(14,15).'</td>
												<td width="14" class="defaultfont" align="right" height="25">
													<div id="div_Calendar_DateOrder">' . (($_REQUEST["DateOrder"]==$dateform) ? "-" : $_REQUEST["DateOrder"]) . '</div>
													<input type="hidden" name="DateOrder" id="hidden_Calendar_DateOrder" value="' . (($_REQUEST["DateOrder"]==$dateform) ? "-" : $_REQUEST["DateOrder"]) . '" />
												</td>
												<td height="25">'.getPixel(10,15).'</td>
												<td width="102" valign="top" height="25">
													' . $we_button->create_button("image:date_picker","javascript:",null,null,null,null,null,null,false,"button_Calendar_DateOrder") . '
												</td>
												<td width="300" height="25">'.getPixel(30,15).'</td>
											</tr>
											<tr height="25">

												<td class="defaultfont" width="86"  height="25"></td>
												<td class="defaultfont" valign="top" width="40" height="25"></td>
												<td width="20" height="25"></td>
												<td width="98" class="defaultfont" height="25">'.$l_shop["bearbeitet"].'</td>
												<td height="25">'.getPixel(14,15).'</td>
												<td width="14" class="defaultfont" align="right" height="25">
													<div id="div_Calendar_DateShipping">' . (($_REQUEST["DateShipping"]==$dateform) ? "-" : $_REQUEST["DateShipping"]) . '</div>
													<input type="hidden" name="DateShipping" id="hidden_Calendar_DateShipping" value="' . (($_REQUEST["DateShipping"]==$dateform) ? "-" : $_REQUEST["DateShipping"]) . '" />
												</td>
												<td height="25">'.getPixel(10,15).'</td>
												<td width="102" valign="top" height="25">
													' . $we_button->create_button("image:date_picker","javascript:",null,null,null,null,null,null,false,"button_Calendar_DateShipping") . '
												</td>
												<td width="30" height="25">'.getPixel(30,15).'</td>
											</tr>
											<tr height="25">

												<td class="defaultfont" width="86" valign="top" height="25"></td>
												<td class="defaultfont" valign="top" width="40" height="25"></td>
												<td width="20" height="25"></td>
												<td width="98" class="defaultfont" height="25">'.$l_shop["bezahlt"].'</td>
												<td height="25">'.getPixel(14,15).'</td>
												<td width="14" class="defaultfont" align="right" height="25">
													<div id="div_Calendar_DatePayment">' . (($_REQUEST["DatePayment"]==$dateform) ? "-" : $_REQUEST["DatePayment"]) . '</div>
													<input type="hidden" name="DatePayment" id="hidden_Calendar_DatePayment" value="' . (($_REQUEST["DatePayment"]==$dateform) ? "-" : $_REQUEST["DatePayment"]) . '" />
												<td height="25">'.getPixel(10,15).'</td>
												<td width="102" valign="top" height="25">
													' . $we_button->create_button("image:date_picker","javascript:",null,null,null,null,null,null,false,"button_Calendar_DatePayment") . '
												</td>
												<td width="30" height="25">'.getPixel(30,15).'</td>
											</tr>
											<tr height="5">
												<td class="defaultfont" width="86" valign="top" height="5"></td>
												<td class="defaultfont" valign="top" height="5" width="40"></td>
												<td height="5" width="20"></td>
												<td width="98" class="defaultfont" valign="top" height="5"></td>
												<td height="5"></td>
												<td width="14" class="defaultfont" align="right" valign="top" height="5"></td>
												<td height="5"></td>
												<td width="102" valign="top" height="5"></td>
												<td width="30" height="5">'.getPixel(30,5).'</td>
											</tr>
											<tr height="1">
												<td class="defaultfont" valign="top" colspan="9" bgcolor="gray" height="1">'.getPixel(14,1).'</td>

											</tr>
											<tr>
												<td class="defaultfont" width="86" valign="top"></td>
												<td class="defaultfont" valign="top" width="40"></td>
												<td width="20"></td>
												<td width="98" class="defaultfont" valign="top"></td>
												<td></td>
												<td width="14" class="defaultfont" align="right" valign="top"></td>
												<td></td>
												<td width="102" valign="top"></td>
												<td width="30">'.getPixel(30,5).'</td>
											</tr>
' . $customerFieldTable . '
                                            <tr>
                                            	<td colspan="9"><a href="javascript:we_cmd(\'edit_order_customer\');">' . $l_shop['order']['edit_order_customer'] . '</a></td>
                                            </tr>
                                            <tr>
                                            	<td colspan="9"><a href="javascript:we_cmd(\'edit_customer\');">' . $l_shop['order']['open_customer'] . '</a> </td>
                                            </tr>
										</table>';
	//
	// end of "Building table with customer fields"
	// ********************************************************************************




	// ********************************************************************************
	// "Building the order infos"
	//

	// headline here - these fields are fix.
	$pixelImg = getPixel(14,15);
	$orderTable = '
	<table border="0" cellpadding="0" cellspacing="0" width="99%" class="defaultfont">
	<tr>
		<th class="defaultgray" height="25">' . $l_shop['Anzahl'] . '</th>
		<td>' . $pixelImg . '</td>
		<th class="defaultgray" height="25">' . $l_shop['Titel'] . '</th>
		<td>' . $pixelImg . '</td>
		<th class="defaultgray" height="25">' . $l_shop['Beschreibung'] . '</th>
		<td>' . $pixelImg . '</td>
		<th class="defaultgray" height="25">' . $l_shop['Preis'] . '</th>
		<td>' . $pixelImg . '</td>
		<th class="defaultgray" height="25">' . $l_shop['Gesamt'] . '</th>
		' . ($calcVat ? '<td>' . $pixelImg . '</td>
		<th class="defaultgray" height="25">' . $l_shop['MwSt'] . '</th>' : '' ) . '
	</tr>';


	$articlePrice = 0;
	$totalPrice   = 0;
	$articleVatArray = array();
	// now loop through all articles in this order
	for ($i=0; $i<sizeof($ArticleId);$i++) {

		// now init each article
		if (empty($Serial[$i])) { // output 'document-articles' if $Serial[$d] is empty. This is when an order has been extended
			// this should not happen any more
			$shopArticleObject = Basket::getserial($ArticleId[$i],'w');
		} else {   // output if $Serial[$i] is not empty. This is when a user ordered an article online
			$shopArticleObject = @unserialize($Serial[$i]);
		}

		// determine taxes - correct price, etc.
		$articlePrice = $Price[$i] * $Quantity[$i];
		$totalPrice += $articlePrice;

		// calculate individual vat for each article
		if ($calcVat) {

			// now determine VAT
			if (isset($shopArticleObject[WE_SHOP_VAT_FIELD_NAME])) {
				$articleVat = $shopArticleObject[WE_SHOP_VAT_FIELD_NAME];
			} else if (isset($mwst)) {
				$articleVat = $mwst;
			} else {
				$articleVat = 0;
			}

			if ($articleVat > 0) {

				if (!isset($articleVatArray[$articleVat])) { // avoid notices
					$articleVatArray[$articleVat] = 0;
				}

				if ($pricesAreNet) {
					$articleVatArray[$articleVat] += ($articlePrice*$articleVat/100);
				} else {
					$articleVatArray[$articleVat] += ($articlePrice*$articleVat/(100 + $articleVat));
				}
			}
		}

		// table row of one article
		$orderTable .= '
	<tr>
		<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td class="shopContentfontR">' . "<a href=\"javascript:var anzahl=prompt('".$l_shop["jsanz"]."','".$Quantity[$i]."'); if(anzahl != null){if(anzahl.search(/\d.*/)==-1){" . we_message_reporting::getShowMessageCall("'" . $l_shop['keinezahl'] . "'", WE_MESSAGE_ERROR, true) . ";}else{document.location='".$_SERVER["PHP_SELF"]."?bid=".$_REQUEST["bid"]."&article=$tblOrdersId[$i]&anzahl='+anzahl;}}\">" . $Quantity[$i] . "</a>" . '</td>
		<td></td>
		<td>' . getFieldFromShoparticle($shopArticleObject, 'shoptitle', 35) . '</td>
		<td></td>
		<td>' . getFieldFromShoparticle($shopArticleObject, 'shopdescription', 45) . '</td>
		<td></td>
		<td class="shopContentfontR">' . "<a href=\"javascript:var preis = prompt('".$l_shop["jsbetrag"]."','".$Price[$i]."'); if(preis != null ){if(preis.search(/\d.*/)==-1){" . we_message_reporting::getShowMessageCall("'" . $l_shop['keinezahl'] . "'", WE_MESSAGE_ERROR, true) . "}else{document.location='".$_SERVER["PHP_SELF"]."?bid=".$_REQUEST["bid"]."&article=$tblOrdersId[$i]&preis=' + preis; } }\">" . numfom($Price[$i]) . "</a>" . $waehr . '</td>
		<td></td>
		<td class="shopContentfontR">' . numfom($articlePrice) . $waehr . '</td>
		' . ($calcVat ? '
			<td></td>
			<td class="shopContentfontR small">(' . "<a href=\"javascript:var vat = prompt('".$l_shop["jsbetrag"]."','".$articleVat."'); if(vat != null ){if(vat.search(/\d.*/)==-1){" . we_message_reporting::getShowMessageCall("'" . $l_shop['keinezahl'] . "'", WE_MESSAGE_ERROR, true) . ";}else{document.location='".$_SERVER["PHP_SELF"]."?bid=".$_REQUEST["bid"]."&article=$tblOrdersId[$i]&vat=' + vat; } }\">" . numfom($articleVat) . "</a>" . '%)</td>'
			: '') . '
		<td>' . $pixelImg . '</td>
		<td>' . $we_button->create_button("image:btn_function_trash", "javascript:check=confirm('".$l_shop["jsloeschen"]."'); if (check){document.location.href='".$_SERVER["PHP_SELF"]."?bid=".$_REQUEST["bid"]."&deleteaartikle=".$tblOrdersId[$i]."';}", true, 100, 22, "", "", !we_hasPerm("DELETE_SHOP_ARTICLE")) . '</td>
	</tr>
		';
		// if this article has custom fields or is a variant - we show them in a extra rows
		// add variant.
		if (isset($shopArticleObject['WE_VARIANT']) && $shopArticleObject['WE_VARIANT']) {

			$orderTable .='
	<tr>
		<td colspan="4"></td>
		<td class="small" colspan="6">' . $l_shop["variant"] . ': ' . $shopArticleObject['WE_VARIANT'] . '</td>
	</tr>
			';
		}
		// add custom fields
		if (isset($shopArticleObject[WE_SHOP_ARTICLE_CUSTOM_FIELD]) && is_array($shopArticleObject[WE_SHOP_ARTICLE_CUSTOM_FIELD]) && sizeof($shopArticleObject[WE_SHOP_ARTICLE_CUSTOM_FIELD])) {

			$caField = '';
			foreach ($shopArticleObject[WE_SHOP_ARTICLE_CUSTOM_FIELD] as $key => $value) {
				$caField .= "$key: $value; ";
			}

			$orderTable .='
	<tr>
		<td colspan="4"></td>
		<td class="small" colspan="6">' . $caField . '</td>
	</tr>
			';
		}
	}

	// ********************************************************************************
	// "Sum of order"
	//

	// add shipping to costs
	if (isset($orderData[WE_SHOP_SHIPPING])) {

		// just calculate netPrice, gros, and taxes

		if (!isset($articleVatArray[$orderData[WE_SHOP_SHIPPING]['vatRate']])) {
			$articleVatArray[$orderData[WE_SHOP_SHIPPING]['vatRate']] = 0;
		}

		if ($orderData[WE_SHOP_SHIPPING]['isNet']) { // all correct here
			$shippingCostsNet  = $orderData[WE_SHOP_SHIPPING]['costs'];
			$shippingCostsVat  = $orderData[WE_SHOP_SHIPPING]['costs'] * $orderData[WE_SHOP_SHIPPING]['vatRate'] / 100;
			$shippingCostsGros = $shippingCostsNet + $shippingCostsVat;

			$articleVatArray[$orderData[WE_SHOP_SHIPPING]['vatRate']] += $shippingCostsVat;
		} else {

			$shippingCostsGros = $orderData[WE_SHOP_SHIPPING]['costs'];
			$shippingCostsVat  = $orderData[WE_SHOP_SHIPPING]['costs'] / ($orderData[WE_SHOP_SHIPPING]['vatRate'] + 100)  * $orderData[WE_SHOP_SHIPPING]['vatRate'];
			$shippingCostsNet  = $orderData[WE_SHOP_SHIPPING]['costs'] / ($orderData[WE_SHOP_SHIPPING]['vatRate'] + 100)  * 100;

			$articleVatArray[$orderData[WE_SHOP_SHIPPING]['vatRate']] += $shippingCostsVat;
		}
	}

	$orderTable .= '
	<tr>
		<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td colspan="5" class="shopContentfontR">' . $l_shop["Preis"] . ':</td>
		<td colspan="4" class="shopContentfontR"><strong>' . numfom($totalPrice) . $waehr . '</strong></td>
	</tr>
	';

	if ($calcVat) { // add Vat to price

		$totalPriceAndVat = $totalPrice;

		if ($pricesAreNet) { // prices are net

			$orderTable .= '
				<tr>
					<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
				</tr>';

			if (isset($orderData[WE_SHOP_SHIPPING]) && isset($shippingCostsNet)) {

				$totalPriceAndVat += $shippingCostsNet;
				$orderTable .= '
					<tr>
						<td colspan="5" class="shopContentfontR">' . $l_shop['shipping']['shipping_package'] . ':</td>
						<td colspan="4" class="shopContentfontR"><strong><a href="javascript:we_cmd(\'edit_shipping_cost\');">' . numfom($shippingCostsNet) . $waehr . '</a></strong></td>
					</tr>
					<tr>
						<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
					</tr>';
			}
			$orderTable .='
	<tr>
		<td colspan="5" class="shopContentfontR"><label style="cursor: pointer" for="checkBoxCalcVat">' . $l_shop["plusVat"] . '</label>:</td>
		<td colspan="7"></td>
		<td colspan="1"><input id="checkBoxCalcVat" onclick="document.location=\'' . $_SERVER['PHP_SELF'] . '?bid=' . $_REQUEST['bid'] . '&we_cmd[0]=payVat&pay=0\';" type="checkbox" name="calculateVat" value="1" checked="checked" /></td>
	</tr>
	';
			foreach ($articleVatArray as $vatRate => $sum) {

				if ($vatRate) {

					$totalPriceAndVat += $sum;
					$orderTable .= '
	<tr>
		<td colspan="5" class="shopContentfontR">' . $vatRate . ' %:</td>
		<td colspan="4" class="shopContentfontR">' . numfom($sum) . $waehr . '</td>
	</tr>
					';
				}
			}
			$orderTable .= '
	<tr>
		<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td colspan="5" class="shopContentfontR">' . $l_shop["gesamtpreis"] . ':</td>
		<td colspan="4" class="shopContentfontR"><strong>' . numfom($totalPriceAndVat) . $waehr . '</strong></td>
	</tr>
			';

		} else { // prices are gros

				$orderTable .= '
	<tr>
		<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
	</tr>';

			if (isset($orderData[WE_SHOP_SHIPPING]) && isset($shippingCostsGros)) {

				$totalPrice += $shippingCostsGros;
				$orderTable .= '
					<tr>
						<td colspan="5" class="shopContentfontR">' . $l_shop['shipping']['shipping_package'] . ':</td>
						<td colspan="4" class="shopContentfontR"><a href="javascript:we_cmd(\'edit_shipping_cost\');">' . numfom($shippingCostsGros) . $waehr . '</a></td>
					</tr>
					<tr>
						<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
					</tr>
					<tr>
						<td colspan="5" class="shopContentfontR">' . $l_shop["gesamtpreis"] . ':</td>
						<td colspan="4" class="shopContentfontR"><strong>' . numfom($totalPrice) . $waehr . '</strong></td>
					</tr>
					<tr>
						<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
					</tr>';
			}

			$orderTable .= '

	<tr>
		<td colspan="5" class="shopContentfontR"><label style="cursor: pointer" for="checkBoxCalcVat">' . $l_shop["includedVat"] . '</label>:</td>
		<td colspan="7"></td>
		<td colspan="1"><input id="checkBoxCalcVat" onclick="document.location=\'' . $_SERVER['PHP_SELF'] . '?bid=' . $_REQUEST['bid'] . '&we_cmd[0]=payVat&pay=0\';" type="checkbox" name="calculateVat" value="1" checked="checked" /></td>
	</tr>
			';
			foreach ($articleVatArray as $vatRate => $sum) {
				if ($vatRate) {
					$orderTable .= '
	<tr>
		<td colspan="5" class="shopContentfontR">' . $vatRate . ' %:</td>
		<td colspan="4" class="shopContentfontR">' . numfom($sum) . $waehr . '</td>
	</tr>
					';
				}
			}
		}
	} else {

		if (isset($shippingCostsNet)) {

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");
			$totalPrice += $shippingCostsNet;

			$orderTable .= '
	<tr>
		<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td colspan="5" class="shopContentfontR">' . $l_shop['shipping']['shipping_package'] . ':</td>
		<td colspan="4" class="shopContentfontR"><a href="javascript:we_cmd(\'edit_shipping_cost\')">' . numfom($shippingCostsNet) . $waehr . '</a></td>
	</tr>
	<tr>
		<td height="1" colspan="11"><hr size="1" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td colspan="5" class="shopContentfontR"><label style="cursor: pointer" for="checkBoxCalcVat">' . $l_shop['edit_order']['calculate_vat'] . '</label></td>
		<td colspan="7"></td>
		<td colspan="1"><input id="checkBoxCalcVat" onclick="document.location=\'' . $_SERVER['PHP_SELF'] . '?bid=' . $_REQUEST['bid'] . '&we_cmd[0]=payVat&pay=1\';" type="checkbox" name="calculateVat" value="1" /></td>
	</tr>
	<tr>
		<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
	</tr>
	<tr>
		<td colspan="5" class="shopContentfontR">' . $l_shop["gesamtpreis"] . ':</td>
		<td colspan="4" class="shopContentfontR"><strong>' . numfom($totalPrice) . $waehr . '</strong></td>
	</tr>
	<tr>
		<td height="1" colspan="11"><hr size="2" style="color: black" noshade /></td>
	</tr>
				';
		} else {

			$orderTable .= '
	<tr>
		<td colspan="5" class="shopContentfontR"><label style="cursor: pointer" for="checkBoxCalcVat">' . $l_shop['edit_order']['calculate_vat'] . '</label></td>
		<td colspan="7"></td>
		<td colspan="1"><input id="checkBoxCalcVat" onclick="document.location=\'' . $_SERVER['PHP_SELF'] . '?bid=' . $_REQUEST['bid'] . '&we_cmd[0]=payVat&pay=1\';" type="checkbox" name="calculateVat" value="1" /></td>
	</tr>';
		}
	}
	$orderTable .= '</table>';
	//
	// "Sum of order"
	// ********************************************************************************


	// ********************************************************************************
	// "Additional fields in shopping basket"
	//

	// at last add custom shopping fields to order

// table with orders ends here

	$customCartFieldsTable = '<table cellpadding="0" cellspacing="0" border="0" width="99%">
			<tr>
				<th colspan="3" class="defaultgray" height="30">' . $l_shop["order_comments"] . '</th>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>';

	if (sizeof($customCartFields)) {

		foreach ($customCartFields as $key => $value) {
					$customCartFieldsTable .= '
			<tr>
				<td class="defaultfont" valign="top"><b>' . $key . ':</b></td>
				<td>' . $pixelImg . '</td>
				<td class="defaultfont" valign="top">' . nl2br($value) . '</td>
				<td>' . $pixelImg . '</td>
				<td valign="top">' . $we_button->create_button('image:btn_edit_edit', "javascript:we_cmd('edit_shop_cart_custom_field','" . $key . "');") . '</td>
				<td>' . $pixelImg . '</td>
				<td valign="top">' . $we_button->create_button('image:btn_function_trash', "javascript:check=confirm('".sprintf($l_shop['edit_order']['js_delete_cart_field'], $key)."'); if (check) { document.location.href='".$_SERVER["PHP_SELF"]."?we_cmd[0]=delete_shop_cart_custom_field&bid=".$_REQUEST["bid"]."&cartfieldname=" . $key . "'; }") . '</td>
			</tr>
			<tr>
				<td height="10"></td>
			</tr>';
		}
	}
	$customCartFieldsTable .= '
			<tr>
				<td>' . $we_button->create_button('image:btn_function_plus', "javascript:we_cmd('edit_shop_cart_custom_field');") . '</td>
			</tr>
			</table>';


	//
	// "Additional fields in shopping basket"
	// ********************************************************************************

	//
	// "Building the order infos"
	// ********************************************************************************


	// ********************************************************************************
	// "Html output for order with articles"
	//
?>
	<script type="text/javascript" src="<?php print JS_DIR."jscalendar/calendar.js"; ?>"></script>
	<script type="text/javascript" src="<?php print JS_DIR."jscalendar/calendar-setup.js"; ?>"></script>
	<script type="text/javascript" src="<?php print WEBEDITION_DIR."we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/calendar.js"; ?>"></script>
	<link type="text/css" rel="stylesheet" href="<?php print JS_DIR."jscalendar/skins/aqua/theme.css"; ?>" title="Aqua" />
	
    <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
	<script language="JavaScript" type="text/javascript">

	function doUnload() {
		if (!!jsWindow_count) {
			for (i = 0; i < jsWindow_count; i++) {
				eval("jsWindow" + i + "Object.close()");
			}
		}
	}
	
	function we_cmd(){

        var args = "";
        var url = "<?php print $_SERVER['PHP_SELF']; ?>?";

        for(var i = 0; i < arguments.length; i++){
            url += "we_cmd["+i+"]="+escape(arguments[i]);
            if(i < (arguments.length - 1)){
                url += "&";
            }
        }

        switch (arguments[0]) {

        	case "edit_shipping_cost":
        		var wind = new jsWindow(url + "&bid=<?php echo $_REQUEST["bid"]; ?>","edit_shipping_cost",-1,-1,545,205,true,true,true,false);
        	break;

        	case "edit_shop_cart_custom_field":
        		var wind = new jsWindow(url + "&bid=<?php echo $_REQUEST["bid"]; ?>&cartfieldname="+ (arguments[1] ? arguments[1] : ''),"edit_shop_cart_custom_field",-1,-1,545,300,true,true,true,false);
        	break;

			case "edit_order_customer":
				var wind = new jsWindow(url + "&bid=<?php echo $_REQUEST["bid"]; ?>","edit_order_customer",-1,-1,545,600,true,true,true,false);
			break;
			case "edit_customer":
				top.document.location = '/webEdition/we/include/we_modules/show_frameset.php?mod=customer&sid=<?php print $_REQUEST["cid"]; ?>';
			break;
			case "add_new_article":
				var wind = new jsWindow(url + "&bid=<?php echo $_REQUEST["bid"]; ?>","add_new_article",-1,-1,650,600,true,false,true,false);
			break;
		}
	}

	function neuerartikel(){
		we_cmd("add_new_article");
	}

	function deleteorder(){
		top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_properties.php?deletethisorder=1&bid=<?php echo $_REQUEST["bid"]; ?>";
		top.content.deleteEntry(<?php echo $_REQUEST["bid"]; ?>);
	}

	hot = 1;
<?php
	if (isset($alertMessage)) {

		print we_message_reporting::getShowMessageCall($alertMessage, $alertType);
	}
?>
	</script>

	</head>
<body class="weEditorBody" onunload="doUnload()">

<?php

	$parts = array();

	array_push($parts,
				array(
					"html"=>$orderDataTable,
					"space"=>0
					)
			);

	array_push($parts,
				array(
					"html"=>$orderTable,
					"space"=>0

					)
			);
	if ($customCartFieldsTable) {

		array_push($parts,
				array(
					"html"=>$customCartFieldsTable,
					"space"=>0
					)
			);
	}

	print we_multiIconBox::getHTML("","100%",$parts,30);

	//
	// "Html output for order with articles"
	// ********************************************************************************


} else { // This order has no more entries
?>
	<script language="JavaScript" type="text/javascript">
		top.content.shop_properties.location="<?php print WE_SHOP_MODULE_PATH; ?>edit_shop_properties.php?deletethisorder=1&bid=<?php echo $_REQUEST["bid"]; ?>";
		top.content.deleteEntry(<?php echo $_REQUEST["bid"]; ?>);
	</script>
</head>
<body bgcolor="#ffffff">
<?php
}
?>
	<script type="text/javascript">
	// init the used calendars
	
	function CalendarChanged(calObject) {
		// field:
		_field = calObject.params.inputField;
		document.location = "<?php print $_SERVER["PHP_SELF"] . "?bid=".$_REQUEST["bid"]; ?>&" + _field.name + "=" + _field.value;
		
	}
	
	// Calender for order date
	Calendar.setup(
		{
			"inputField" : "hidden_Calendar_DateOrder",
			"displayArea" : "div_Calendar_DateOrder",
			"button" : "date_pickerbutton_Calendar_DateOrder",
			"ifFormat" : "<?php print $da; ?>",
			"daFormat" : "<?php print $da; ?>",
			"onUpdate" : CalendarChanged
		}
	);
	
	Calendar.setup(
		{
			"inputField" : "hidden_Calendar_DateShipping",
			"displayArea" : "div_Calendar_DateShipping",
			"button" : "date_pickerbutton_Calendar_DateShipping",
			"ifFormat" : "<?php print $da; ?>",
			"daFormat" : "<?php print $da; ?>",
			"onUpdate" : CalendarChanged
		}
	);
	
	Calendar.setup(
		{
			"inputField" : "hidden_Calendar_DatePayment",
			"displayArea" : "div_Calendar_DatePayment",
			"button" : "date_pickerbutton_Calendar_DatePayment",
			"ifFormat" : "<?php print $da; ?>",
			"daFormat" : "<?php print $da; ?>",
			"onUpdate" : CalendarChanged
		}
	);
	
	
	</script>
</body>
</html>