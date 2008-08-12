<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_class.inc.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/shop.inc.php');

require_once(WE_SHOP_MODULE_DIR . 'weShippingControl.class.php');
require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');

protect();
htmlTop();

$we_button = new we_button();

print STYLESHEET;

$weShippingControl = weShippingControl::getShippingControl();

if (isset($_REQUEST['we_cmd'])) {

	switch ($_REQUEST['we_cmd'][0]) {

		case 'newShipping':
			$weShipping = weShippingControl::getNewEmptyShipping();
		break;

		case 'editShipping':
			$weShipping = $weShippingControl->getShippingById($_REQUEST['weShippingId']);
		break;

		case 'deleteShipping':
			$weShippingControl->delete($_REQUEST['weShippingId']);
		break;

		case 'saveShipping':
			$weShippingControl->setByRequest($_REQUEST);
			$weShippingControl->save();
			if (isset($_REQUEST['weShippingId'])) {
				$weShipping = $weShippingControl->getShippingById($_REQUEST['weShippingId']);
			}
		break;
	}
}

$jsFunction = '

		var isGecko = false;

		if (navigator.product == "Gecko") {
			isGecko = true;
		}

		if (isGecko) {
			document.addEventListener("keyup",doKeyDown,true);
		} else {
			document.onkeydown = doKeyDown;
		}

		function doKeyDown(e) {
			var key;

			if (isGecko) {
				key = e.keyCode;
			} else {
				key = event.keyCode;
			}

			switch (key) {
				case 27:
					top.close();
					break;	}
		}

		function IsDigit(e) {
			var key;

			if (isGecko) {
				key = e.charCode;
			} else {
				key = event.keyCode;
			}

			return ( (key == 46) || ((key >= 48) && (key <= 57)) || (key == 0) || (key == 13)  || (key == 8) || (key <= 63235 && key >= 63232) || (key == 63272));
		}

		function doUnload() {
			if (!!jsWindow_count) {
				for (i = 0; i < jsWindow_count; i++) {
					eval("jsWindow" + i + "Object.close()");
				}
			}
		}
			
		function we_cmd(){

            var args = "";
            var url = "/webEdition/we_cmd.php?";
            for(var i = 0; i < arguments.length; i++){
                url += "we_cmd["+i+"]="+escape(arguments[i]);
                if(i < (arguments.length - 1)){
                    url += "&";
                }
            }

            switch (arguments[0]) {

            	case "save":
            		we_submitForm("' . $_SERVER['PHP_SELF'] . '");
            	break;

            	case "close":
            		window.close();
            	break;

            	case "delete":
            		if (confirm("' . 'Möchten sie den ausgewählten Portosatz wirklich löschen?' . '")) {
            			var we_cmd_field = document.getElementById("we_cmd_field");
            			we_cmd_field.value = "deleteShipping";
            			we_submitForm("' . $_SERVER['PHP_SELF'] . '");

            		}
            	break;

            	case "newEntry":
            		document.location = "' . $_SERVER['PHP_SELF'] . '?we_cmd[0]=newShipping";
            	break;

            	case "addShippingCostTableRow":
            		addShippingCostTableRow();
            	break;

            	case "deleteShippingCostTableRow":
            		deleteShippingCostTableRow(arguments[1]);
            	break;

            	default :
				break;
            }
        }

        // this is for new entries.
        var entryPosition = 0;

        function addShippingCostTableRow() {

        	tbl = document.getElementById("shippingCostTableEntries");

        	entryId = "New" + "" + entryPosition++;

        	theNewRow = document.createElement("TR");
        	theNewRow.setAttribute("id", "weShippingId_" + entryId);

			var cell1 = document.createElement("TD");
			cell1.innerHTML=\'<input class="wetextinput" type="text" name="weShipping_cartValue[]" size="24" onblur="this.className=\\\'wetextinput\\\';" onfocus="this.className=\\\'wetextinputselected\\\'">\';
        	var cell2 = document.createElement("TD");
			var cell3 = document.createElement("TD");
			cell3.innerHTML=\'<input class="wetextinput" type="text" name="weShipping_shipping[]" size="24" onblur="this.className=\\\'wetextinput\\\';" onfocus="this.className=\\\'wetextinputselected\\\'">\';
			var cell4 = document.createElement("TD");
			var cell5 = document.createElement("TD");

			eval("cell5.innerHTML=\'<img onclick=\"we_cmd(\\\\\'deleteShippingCostTableRow\\\\\', \\\\\'weShippingId_" + entryId + "\\\\\');\" style=\"cursor: pointer;\" src=\"' . BUTTONS_DIR . 'btn_function_trash.gif\">\';");

			theNewRow.appendChild(cell1);
			theNewRow.appendChild(cell2);
			theNewRow.appendChild(cell3);
			theNewRow.appendChild(cell4);
			theNewRow.appendChild(cell5);

			// append new row
			tbl.appendChild(theNewRow);

        }

        function deleteShippingCostTableRow(rowId) {

        	tbl = document.getElementById("shippingCostTable");
        	tableRows = tbl.rows;

        	for (i=0;i<tableRows.length;i++) {

        		if(rowId == tableRows[i].id) {
        			tbl.deleteRow(i);
        		}
        	}
        }

        function we_submitForm(url){

            var f = self.document.we_form;

        	f.action = url;
        	f.method = "post";

        	f.submit();
        }
        ';


print "
	<script type='text/javascript'>
		$jsFunction
	</script>
	</head>
<body class=\"weDialogBody\" onload='window.focus();'>
<form name='we_form'>
<input type='hidden' id='we_cmd_field' name='we_cmd[0]' value='saveShipping' />
";

$parts = array();

// show shippingControl
// first show fields: country, vat, isNet?

	$customerTableFields = $DB_WE->metadata(CUSTOMER_TABLE);
	$selectFields = array();
	foreach ($customerTableFields as $tblField) {
		$selectFields[$tblField['name']] = $tblField['name'];
	}

	array_push($parts, array(
		'headline' => $l_shop['vat_country']['stateField'],
		'space' => 200,
		'html' => we_class::htmlSelect('stateField', $selectFields, 1, $weShippingControl->stateField, false, '', 'value', 200),
		'noline' => 1
		)
	);
	unset($selectFields);

	$shopVats = weShopVats::getAllShopVATs();
	$selectFields = array();
	foreach ($shopVats as $id => $shopVat ) {
		$selectFields[$id] = $shopVat->text . ' (' . $shopVat->vat . '%)';
	}
	array_push($parts, array(
		'headline' => $l_shop['mwst'],
		'space' => 200,
		'html' => we_class::htmlSelect('vatId', $selectFields, 1, $weShippingControl->vatId, false, '', 'value', 200),
		'noline' => 1
		)
	);
	array_push($parts, array(
		'headline' => $l_shop['shipping']['prices_are_net'],
		'space' => 200,
		'html' => we_class::htmlSelect('isNet', array(1=>$GLOBALS["l_global"]["true"], 0=>$GLOBALS["l_global"]["false"]), 1, $weShippingControl->isNet, false, '', 'value', 200)
		)
	);
// selectBox with all existing shippings

// select menu with all available shipping costs
	$selectFields = array();
	foreach ($weShippingControl->shippings as $key => $shipping) {
		$selectFields[$key] = $shipping->text;
	}

	array_push($parts, array(
		'headline' => $l_shop['shipping']['insert_packaging'],
		'space' => 200,
		'html' => '<table border="0" cellpadding="0" cellpsacing="0" class="defaultfont">
	<tr>
		<td>' .	we_class::htmlSelect('editShipping', $selectFields, 4, (isset($_REQUEST['weShippingId']) ? $_REQUEST['weShippingId'] : ''), false, 'onchange="document.location=\'' . $_SERVER['PHP_SELF'] . '?we_cmd[0]=editShipping&weShippingId=\' + this.options[this.selectedIndex].value;"', 'value', 200) . '</td>
		<td width="10"></td>
		<td valign="top">'
			. $we_button->create_button("new_entry", 'javascript:we_cmd(\'newEntry\');') .
			'<div style="margin:5px;"></div>' .
			$we_button->create_button('delete', 'javascript:we_cmd(\'delete\')') .
		'</td>
	</tr>
	</table>'
		)
	);


// if a shipping should be edited, show it in a form

if (isset($weShipping)) { // show the shipping which must be edited

	array_push(
		$parts,
		array(
			'headline' => 'Name',
			'space' => 150,
			'html' => we_class::htmlTextInput('weShipping_text', 24, $weShipping->text) . hidden('weShippingId', $weShipping->id),
			'noline' => 1

		)
	);
	array_push(
		$parts,
		array(
			'headline' => 'Länder',
			'space' => 150,
			'html' => we_class::htmlTextArea('weShipping_countries', 4, 20, implode("\n", $weShipping->countries)),
			'noline' => 1

		)
	);
	// foreach ...
	// form table with every value -> cost entry
	if (sizeof($weShipping->shipping)) {

		$tblPart = '';
		for ($i=0;$i<sizeof($weShipping->shipping); $i++) {

			$tblRowName = 'weShippingId_' . $i;

			$tblPart .= '
			<tr id="' . $tblRowName . '">
				<td>' . we_class::htmlTextInput('weShipping_cartValue[]', 24, $weShipping->cartValue[$i], '', 'onkeypress="return IsDigit(event);"') . '</td>
				<td></td>
				<td>' . we_class::htmlTextInput('weShipping_shipping[]', 24, $weShipping->shipping[$i], '', 'onkeypress="return IsDigit(event);"') . '</td>
				<td></td>
				<td><img style="cursor: pointer;" src="' . BUTTONS_DIR . 'btn_function_trash.gif" onclick="we_cmd(\'deleteShippingCostTableRow\',\'' . $tblRowName . '\');"></td>
			</tr>';
		}

	}
	array_push(
		$parts,
		array(
			'headline' => 'Kosten',
			'space' => 150,
			'html' =>
	'<table border="0" cellpadding="0" cellspacing="0" width="100%" class="defaultfont" id="shippingCostTable">
		<tr>
			<td><b>Bestellwert</b></td>
			<td width="10"></td>
			<td><b>Versandkosten</b></td>
			<td width="10"></td>
		</tr>
		<tbody id="shippingCostTableEntries">
	' . $tblPart . '
		</tbody>
	</table>
	' . $we_button->create_button('image:btn_function_plus', 'javascript:we_cmd(\'addShippingCostTableRow\',\'12\');'),
			'noline' => 1

		)
	);
	array_push(
		$parts,
		array(
			'headline' => 'Standard',
			'space' => 150,
			'html' => we_class::htmlSelect('weShipping_default', array(1 => $GLOBALS["l_global"]["true"], 0 => $GLOBALS["l_global"]["false"]), 1, $weShipping->default),
			'noline' => 1

		)
	);
}

print we_multiIconBox::getHTML(
	'weShipping',
	"100%",
	$parts,
	30,
	$we_button->position_yes_no_cancel(
		$we_button->create_button('save', 'javascript:we_cmd(\'save\');'),
		'',
		$we_button->create_button('close', 'javascript:we_cmd(\'close\');')
	),
	-1,
	'',
	'',
	false,
	$l_shop['shipping']['shipping_package']
);

print '
</form>
</body></html>';
?>