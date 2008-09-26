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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");

if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}

function prepareFieldname($str){

	if(strpos($str, '_')){
		return substr_replace($str, "/", strpos($str, '_'),1);
	} else {
		return $str;
	}

}

protect();

htmlTop();

print STYLESHEET;

$we_button = new we_button();

if(!empty($_REQUEST["format"])){	//	save data in arrays ..


	$_REQUEST['classID'] = isset($_REQUEST['classID']) ? $_REQUEST['classID'] : '';

	// check if field exists
	$q = 'SELECT * FROM ' . ANZEIGE_PREFS_TABLE . ' WHERE strDateiname="shop_pref"';
	$DB_WE->query($q);
	if ( $DB_WE->num_rows() > 0) {
		$DB_WE->query("UPDATE ".ANZEIGE_PREFS_TABLE." SET strFelder= '" . $_REQUEST["waehr"] . "|" . $_REQUEST["mwst"] . "|" . $_REQUEST["format"] . "|" . $_REQUEST["classID"]. "|" . $_REQUEST["pag"] . "' where strDateiname = 'shop_pref'");
	} else {
		$DB_WE->query("INSERT INTO ".ANZEIGE_PREFS_TABLE." (strFelder, strDateiname) VALUES ('" . $_REQUEST["waehr"] . "|" . $_REQUEST["mwst"] . "|" . $_REQUEST["format"] . "|" . $_REQUEST["classID"]. "|" . $_REQUEST["pag"] . "','shop_pref')" );

	}

	$fields['customerFields']      = isset($_REQUEST['orderfields']) ? $_REQUEST['orderfields'] : array();
	$fields['orderCustomerFields'] = isset($_REQUEST['ordercustomerfields']) ? $_REQUEST['ordercustomerfields'] : array();

	// check if field exists
	$q = 'SELECT * FROM ' . ANZEIGE_PREFS_TABLE . ' WHERE strDateiname="edit_shop_properties"';
	$DB_WE->query($q);
	if ( $DB_WE->num_rows() > 0) {
		$DB_WE->query("UPDATE " . ANZEIGE_PREFS_TABLE . " SET strFelder = '" . addslashes(serialize($fields)) . "' WHERE strDateiname ='edit_shop_properties'");
	} else {
		$DB_WE->query("INSERT INTO " . ANZEIGE_PREFS_TABLE . " (strFelder,strDateiname) VALUES('" . addslashes(serialize($fields)) . "','edit_shop_properties')") ;
	}
	//	Close window when finished
	echo '<script type="text/javascript">self.close();</script>';
	exit;
}

	//	generate html-output table
	$_htmlTable = new we_htmlTable(	array(	'border'      => 0,
											'cellpadding' => 0,
											'cellspacing' => 0,
											'width' => "410"),
									35,
									3);


	//	NumberFormat - currency and taxes
	$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));

	if (isset($feldnamen[3])) {
		$fe = explode(",",$feldnamen[3]);
	} else {
		$fe = array();
	}
	if (!isset($feldnamen[4])){
	 $feldnamen[4]= "-";
	  }




	$_row = 0;
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["waehrung"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlTextInput("waehr",6,$feldnamen[0],"","","text",50) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));


	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont', 'valign'=>'top'), $l_shop["mwst"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setCol($_row++, 2, array('class'=>'defaultfont'), htmlTextInput("mwst",6,$feldnamen[1],"","","text",50) . '&nbsp%');
	$_htmlTable->setCol($_row++, 0, array('colspan' => 3), getPixel(5,5));
	$_htmlTable->setCol($_row++, 0, array('colspan' => 3, 'class' => 'small'), htmlAlertAttentionBox($l_shop["mwst_expl"], 2, "100%" , false, 100));
	$_htmlTable->setCol($_row++, 0, array('colspan' => 3), getPixel(20,15));

	$list = array("german" => "german","english" => "english","french" => "french", "swiss"=>"swiss");
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["format"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('format', $list, 1, $feldnamen[2]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));


	$pager = array("default" => "-", "5" => "5", "10" => "10", "15" => "15" , "20" => "20", "25" => "25" ,"30" => "30", "35" => "35", "40" =>"40", "45" =>"45", "50" => "50");

	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["pageMod"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('pag', $pager, 1, $feldnamen[4]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));


	if (defined('OBJECT_TABLE')) {

		$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["classID"]);
		$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
		$_htmlTable->setColContent($_row++, 2, htmlTextInput("classID",6,(isset($feldnamen[3]) ? $feldnamen[3] : ''),"","","text",50). '<span class="small">&nbsp'. $l_shop["classIDext"].' </span>' );
		$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));

	} else {


		$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));
	}

	// look for all available fields in tblCustomer
	$DB_WE->query('SHOW FIELDS FROM ' . CUSTOMER_TABLE);
	$_availFields = array();
	$ignoreFields = array('ID', 'Forename', 'Surname', 'Password', 'Username', 'ParentID', 'Path' ,'IsFolder', 'Icon', 'Text');
	while ($DB_WE->next_record()) {

		if (!in_array($DB_WE->f('Field'), $ignoreFields)) {
			$_availFields[$DB_WE->f('Field')] = prepareFieldname($DB_WE->f('Field'));
		}
	}
	asort($_availFields);

	//	get the already selected fields ...
	$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'edit_shop_properties'");
	$DB_WE->next_record();
	$_entry = $DB_WE->f("strFelder");

	// ...
	if ($fields = @unserialize($_entry)) {
		// we have an array with following syntax:
		// array ( 'customerFields' => array('fieldname ...',...)
		//         'orderCustomerFields' => array('fieldname', ...) )

	} else {

		$fields['customerFields'] = array();
		$fields['orderCustomerFields'] = array();

		// the save format used to be ...
		// Vorname:tblWebUser||Forename,Nachname:tblWebUser||Surname,Contact/Address1:tblWebUser||Contact_Address1,Contact/Address1:tblWebUser||Contact_Address1,...
		$_fieldInfos = explode(",",$_entry);

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

	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont', 'valign' => 'top'), $l_shop['preferences']['customerFields']);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('orderfields[]', $_availFields, (sizeof($_availFields) > 5 ? '5' : sizeof($_availFields)), implode(",", $fields['customerFields']), true, "", "value", 280 ) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));

	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));


	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont', 'valign' => 'top'), $l_shop['preferences']['orderCustomerFields']);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('ordercustomerfields[]', $_availFields, (sizeof($_availFields) > 5 ? '5' : sizeof($_availFields)), implode(",", $fields['orderCustomerFields']), true, "", "value", 280 ) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));



	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));




	$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("save", "javascript:document.we_form.submit();"),
													"",
													$we_button->create_button("cancel", "javascript:self.close();")
													);

	$frame = htmlDialogLayout($_htmlTable->getHtmlCode(), $l_shop["pref"], $_buttons);


echo '<script type="text/javascript">self.focus();</script>
	</head>
	<body class="weDialogBody">
	<form name="we_form" method="post" style="margin-left:8; margin-top:16px;">
	' . $frame. '</form>


 	</body></html>';


?>