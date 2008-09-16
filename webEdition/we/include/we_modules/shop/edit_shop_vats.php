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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/shop.inc.php');

require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');

protect();
htmlTop();

print STYLESHEET;

if (isset($_REQUEST['we_cmd'])) {

	switch ($_REQUEST['we_cmd'][0]) {

		case 'saveVat':

			$weShopVat = new weShopVat(
				$_REQUEST['weShopVatId'],
				$_REQUEST['weShopVatText'],
				$_REQUEST['weShopVatVat'],
				$_REQUEST['weShopVatStandard']
			);

			if ($newId = weShopVats::saveWeShopVAT($weShopVat)) {
				$weShopVat->id = $newId;
				unset($newId);
				$jsMessage = $l_shop['vat']['save_success'];
				$jsMessageType = WE_MESSAGE_NOTICE;
			} else {
				$jsMessage = $l_shop['vat']['save_error'];
				$jsMessageType = WE_MESSAGE_ERROR;
			}

		break;

		case 'deleteVat':

			if (weShopVats::deleteVatById($_REQUEST['weShopVatId'])) {
				$jsMessage = $l_shop['vat']['delete_success'];
				$jsMessageType = WE_MESSAGE_NOTICE;
			} else {
				$jsMessage = $l_shop['vat']['delete_error'];
				$jsMessageType = WE_MESSAGE_ERROR;
			}
		break;
	}
}

if (!isset($weShopVat)) {
	$weShopVat = new weShopVat(
		0,
		$l_shop['vat']['new_vat_name'],
		19,
		0
	);
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


		function changeFormTextField(theId, newVal) {
			document.getElementById(theId).value = newVal;
		}

		function changeFormSelect(theId, newVal) {

			elem = document.getElementById(theId);


			for (i=0; i<elem.options.length; i++) {
				if ( elem.options[i].value == newVal ) {
					elem.selectedIndex = i;
				}
			}
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

            	case "edit":

            		elem = document.getElementById("editShopVatForm");
            		if (elem.style.display == "none") {
            			elem.style.display = "";
            		}

            		if (theVat = allVats["vat_" + arguments[1]]) {
            			changeFormTextField("weShopVatId", theVat["id"]);
            			changeFormTextField("weShopVatText", theVat["text"]);
            			changeFormTextField("weShopVatVat", theVat["vat"]);
            			changeFormSelect("weShopVatStandard", theVat["standard"]);
            		}
            	break;

            	case "delete":
            		if (confirm("' . $l_shop['vat']['js_confirm_delete'] . '")) {
            			document.location = "' . $_SERVER['PHP_SELF'] . '?we_cmd[0]=deleteVat&weShopVatId=" + arguments[1];
            		}
            	break;

            	case "addVat":
            		elem = document.getElementById("editShopVatForm");
            		if (elem.style.display == "none") {
            			elem.style.display = "";
            		}
            		if (theVat = allVats["vat_0"]) {
            			changeFormTextField("weShopVatId", theVat["id"]);
            			changeFormTextField("weShopVatText", theVat["text"]);
            			changeFormTextField("weShopVatVat", theVat["vat"]);
            			changeFormSelect("weShopVatStandard", theVat["standard"]);
            		}

            	break;

            	default :
				break;
            }
        }

        function we_submitForm(url){

            var f = self.document.we_form;

        	f.action = url;
        	f.method = "post";

        	f.submit();
        }
        ';



// at top of page show a table with all actual vats
$allVats = weShopVats::getAllShopVATs();

$we_button = new we_button();

$parts = array();
$vatJavaScript = '';
$vatTable = '';

$vatJavaScript = '
	var allVats = new Object();
	allVats["vat_0"] = {"id":"0","text":"' . $l_shop['vat']['new_vat_name'] . '","vat":"19","standard":"0"};';

if (sizeof($allVats) > 0) {

	$vatTable = '
	<table class="defaultfont" width="400">
	<tr>
		<td><strong>Id</strong></td>
		<td><strong>' . $l_shop['vat']['vat_form_name'] . '</strong></td>
		<td><strong>' . $l_shop['vat']['vat_form_vat'] . '</strong></td>
		<td><strong>' . $l_shop['vat']['vat_form_standard'] . '</strong></td>
	</tr>
	';

	foreach ($allVats as $_weShopVat) {

		$vatJavaScript .='
	allVats["vat_' . $_weShopVat->id . '"] = {"id":"' . $_weShopVat->id . '","text":"' . $_weShopVat->text . '","vat":"' . $_weShopVat->vat . '","standard":"' . ($_weShopVat->standard ? 1 : 0) . '"};';

		$vatTable .= '
	<tr>
		<td>' . $_weShopVat->id . '</td>
		<td>' . $_weShopVat->text . '</td>
		<td>' . $_weShopVat->vat . '%</td>
		<td>' . ($_weShopVat->standard ? $GLOBALS["l_global"]["yes"] : $GLOBALS["l_global"]["no"]) . '</td>
		<td>' . $we_button->create_button('image:btn_edit_edit', 'javascript:we_cmd(\'edit\',\'' . $_weShopVat->id . '\');') . '</td>
		<td>' . $we_button->create_button('image:btn_function_trash', 'javascript:we_cmd(\'delete\',\'' . $_weShopVat->id . '\');') . '</td>
	</tr>';
		unset($_weShopVat);
	}

	$vatTable .= '
	</table>
	';
}

$plusBut = $we_button->create_button('image:btn_function_plus', 'javascript:we_cmd(\'addVat\')');

print "
	<script type='text/javascript'>
		$vatJavaScript
		$jsFunction
		" . (isset($jsMessage)
			? we_message_reporting::getShowMessageCall($jsMessage, $jsMessageType)
			: '') . "
	</script>
	</head>
<body class=\"weDialogBody\" onload='window.focus();'>
";

array_push($parts, array(
	'space' => 0,
	'html' => $vatTable
	)
);
array_push($parts, array(
	'space' => 0,
	'html' => $plusBut
	)
);

// formular to edit the vats
$formVat = '
<form name="we_form" method="post">
<input type="hidden" name="weShopVatId" id="weShopVatId" value="' . $weShopVat->id . '" />
<input type="hidden" name="we_cmd[0]" value="saveVat" />
<table class="defaultfont" id="editShopVatForm" style="display:none;">
<tr>
	<td colspan="2"><strong>' . $l_shop['vat']['vat_edit_form_headline'] . '</strong></td>
</tr>
<tr>
	<td height="10"></td>
</tr>
<tr>
	<td width="100">' . $l_shop['vat']['vat_form_name'] . ':</td>
	<td><input class="wetextinput" type="text" id="weShopVatText" name="weShopVatText" value="' . $weShopVat->text . '" /></td>
	<td>' . $we_button->create_button('save', 'javascript:we_cmd(\'save\');') . '</td>
</tr>
<tr>
	<td>' . $l_shop['vat']['vat_form_vat'] . ':</td>
	<td><input class="wetextinput" type="text" id="weShopVatVat" name="weShopVatVat" value="' . $weShopVat->vat . '" onkeypress="return IsDigit(event);" />%</td>
</tr>
<tr>
	<td>' . $l_shop['vat']['vat_form_standard'] . ':</td>
	<td><select id="weShopVatStandard" name="weShopVatStandard">
			<option value="1"' . ($weShopVat->standard ? ' selected="selected"' : '') . '>' . $l_shop['vat']['vat_edit_form_yes'] . '</option>
			<option value="0"' . ($weShopVat->standard ? '' : ' selected="selected"') . '>' . $l_shop['vat']['vat_edit_form_no'] . '</option>
		</select>
	</td>
</tr>
</table>
</form>
';

array_push($parts, array(
	'html' => $formVat,
	'space' => 0
	)
);

print we_multiIconBox::getHTML(
	'weShopVates',
	"100%",
	$parts,
	30,
	$we_button->position_yes_no_cancel(
		'',
		'',
		$we_button->create_button('close', 'javascript:we_cmd(\'close\');')
	),
	-1,
	'',
	'',
	false,
	$l_shop['vat']['vat_edit_form_headline_box'],
	"",
	409
);

print '
</body></html>';
?>