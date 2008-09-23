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


require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_class.inc.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/shop.inc.php');

require_once(WE_SHOP_MODULE_DIR . 'weShopVatRule.class.php');

protect();
htmlTop();

print STYLESHEET;

$jsFunction = '

	function we_submitForm(url){

        var f = self.document.we_form;

    	f.action = url;
    	f.method = "post";

    	f.submit();
    }

	function doUnload() {
		if (!!jsWindow_count) {
			for (i = 0; i < jsWindow_count; i++) {
				eval("jsWindow" + i + "Object.close()");
			}
		}
	}
			
	function we_cmd(){

		switch (arguments[0]) {

			case "close":
				window.close();
			break;

			case "save":
				we_submitForm("' . $_SERVER['PHP_SELF'] . '");
			break;
		}
	}
';



// initialise the vatRuleObject
if (isset($_REQUEST['we_cmd']) && $_REQUEST['we_cmd'][0] == 'saveVatRule') {

	// initialise the vatRule by request
	$weShopVatRule = weShopVatRule::initByRequest($_REQUEST);
	$weShopVatRule->save();

} else {

	$weShopVatRule = weShopVatRule::getShopVatRule();
}

// array with all rules
$we_button = new we_button();

$customerTableFields = $DB_WE->metadata(CUSTOMER_TABLE);
foreach ($customerTableFields as $tblField) {
	$selectFields[$tblField['name']] = $tblField['name'];
}

$parts = array();

// default value f�r mwst
	$defaultInput = we_class::htmlSelect('defaultValue', array('true'=>'true', 'false' => 'false'), 1, $weShopVatRule->defaultValue);
	array_push($parts, array(
			'headline' => $l_shop['vat_country']['defaultReturn'],
			'space' => 300,
			'html' => $defaultInput,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'html' => htmlAlertAttentionBox($l_shop['vat_country']['defaultReturn_desc'], 2,600),
			'space' => 0
		)
	);

// select field containing land
	$countrySelect = we_class::htmlSelect('stateField', $selectFields, 1, $weShopVatRule->stateField);
	array_push($parts, array(
			'headline' => $l_shop['vat_country']['stateField']. ':',
			'space' => 300,
			'html' => $countrySelect,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'html' => htmlAlertAttentionBox($l_shop['vat_country']['stateField_desc'], 2,600),
			'space' => 0
		)
	);


// states which must always pay vat

	$textAreaLiableStates = we_class::htmlTextArea('liableToVat', 3, 30, implode("\n", $weShopVatRule->liableToVat));

	array_push($parts, array(
			'headline' => $l_shop['vat_country']['statesLiableToVat'] . ':',
			'space' => 300,
			'html' => $textAreaLiableStates,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'html' => htmlAlertAttentionBox($l_shop['vat_country']['statesLiableToVat_desc'],2,600),
			'space' => 0
		)
	);

// states which must never pay vat

	$textAreaNotLiableStates = we_class::htmlTextArea('notLiableToVat', 3, 30, implode("\n", $weShopVatRule->notLiableToVat));

	array_push($parts, array(
			'headline' => $l_shop['vat_country']['statesNotLiableToVat'] . ':',
			'space' => 300,
			'html' => $textAreaNotLiableStates,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'html' => htmlAlertAttentionBox($l_shop['vat_country']['statesNotLiableToVat_desc'],2,600),
			'space' => 0
		)
	);


// states which must only pay under certain circumstances

	// if we make more rules possible - adjust here
	$actCondition = $weShopVatRule->conditionalRules[0];

	$conditionTextarea = we_class::htmlTextArea('conditionalStates[]', 3, 30, implode("\n", $actCondition['states']));
	$conditionField = we_class::htmlSelect('conditionalCustomerField[]', $selectFields, 1, $actCondition['customerField']);
	$conditionSelect = we_class::htmlSelect('conditionalCondition[]', array('is_empty' => $l_shop['vat_country']['condition_is_empty'], 'is_set' => $l_shop['vat_country']['condition_is_set']), 1, $actCondition['condition']);
	$conditionReturn = we_class::htmlSelect('conditionalReturn[]', array('false' => 'false', 'true' => 'true'), 1, $actCondition['returnValue']);

	array_push($parts, array(
			'headline' => $l_shop['vat_country']['statesSpecialRules'] .':',
			'space' => 300,
			'html' => $conditionTextarea,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'html' => htmlAlertAttentionBox($l_shop['vat_country']['statesSpecialRules_desc'],2,600),
			'space' => 0,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'headline' => $l_shop['vat_country']['statesSpecialRules_condition'],
			'space' => 300,
			'html' =>  $conditionField . ' ' . $conditionSelect,
			'noline' => 1
		)
	);
	array_push($parts, array(
			'headline' => $l_shop['vat_country']['statesSpecialRules_result'],
			'space' => 300,
			'html' => $conditionReturn
		)
	);

print "
	<script type=\"text/javascript\">
		$jsFunction
	</script>
";


print '</head>
<body class="weDialogBody" onload="window.focus();">
	<form name="we_form" method="post">
	<input type="hidden" name="we_cmd[0]" value="saveVatRule" />
';

print we_multiIconBox::getHTML(
	'weShopCountryVat',
	"100%",
	$parts,
	30,
	$we_button->position_yes_no_cancel(
		$we_button->create_button('save', 'javascript:we_cmd(\'save\');'),
		'',
		$we_button->create_button('cancel', 'javascript:we_cmd(\'close\');')
	),
	-1,
	'',
	'',
	false,
	$l_shop['vat_country']['box_headline'],'',741
);


print '
	</form>
</body>
</html>';

?>