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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_pager_class.inc.php");


if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}


/* ************* fuction for orders  ************** */
$typeObj = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'object';
$typeDoc = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'document';
$actPage = isset($_REQUEST['actPage']) ? $_REQUEST['actPage'] : '0';

function orderBy($a, $b) {

	$true = true;
	$false = false;

	if (isset($_REQUEST['orderDesc'])) { // turn order!
		$true = false;
		$false = true;
	}

	if ($a[$_REQUEST['orderBy']] >= $b[$_REQUEST['orderBy']]) {
		return $true;
	} else {
		return $false;
	}
}

function getTitleLinkObj($text, $orderKey) {

	global $typeObj, $actPage, $classid, $orderBy;

	$_href =	$_SERVER['PHP_SELF'] .
				'?typ=' . $typeObj .
				'&orderBy=' . $orderKey .
				'&ViewClass=' . $classid .
				'&actPage=' . $actPage .
				( ($orderBy == $orderKey && !isset($_REQUEST['orderDesc'])) ? '&orderDesc=true' : '' );

	$arrow = '';

	if ($orderBy == $orderKey) {

		if (isset($_REQUEST['orderDesc'])) {
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_desc.gif" />';
		} else {
			$arrow = ' &darr; ';
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_asc.gif" />';
		}

	}

	return '<a href="' . $_href . '">' . $text . '</a>' . $arrow;
}

function getPagerLinkObj() {

	global $typeObj, $actPage, $classid, $orderBy;

	return 	$_SERVER['PHP_SELF'] .
			'?typ=' . $typeObj .
			'&orderBy=' . $orderBy .
			'&ViewClass=' . $classid .
			'&actPage=' . $actPage .
			(isset($_REQUEST['orderdesc']) ? '&orderDesc=true' : '' );
}

function getTitleLinkDoc($text, $orderKey) {

	global $typeDoc, $actPage, $orderBy;

	$_href =	$_SERVER['PHP_SELF'] .
				'?typ=' . $typeDoc .
				'&orderBy=' . $orderKey .
				'&actPage=' . $actPage .
				( ($orderBy == $orderKey && !isset($_REQUEST['orderDesc'])) ? '&orderDesc=true' : '' );

	$arrow = '';

	if ($orderBy == $orderKey) {

		if (isset($_REQUEST['orderDesc'])) {
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_desc.gif" />';
		} else {
			$arrow = ' &darr; ';
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_asc.gif" />';
		}

	}

	return '<a href="' . $_href . '">' . $text . '</a>' . $arrow;
}

function getPagerLinkDoc() {

	global $typeDoc, $actPage, $orderBy;

	return 	$_SERVER['PHP_SELF'] .
			'?typ=' . $typeDoc .
			'&orderBy=' . $orderBy .
			'&actPage=' . $actPage .
			(isset($_REQUEST['orderdesc']) ? '&orderDesc=true' : '' );
}



/* ************* fuction for orders  ************** */



protect();

htmlTop();


print STYLESHEET;

print '
<script type="text/javascript">

	function we_submitDateform() {
		elem = document.forms[0];
		elem.submit();
	}

</script>
<style type="text/css">
	table.revenueTable {
		border-collapse: collapse;
	}
	table.revenueTable th,
	table.revenueTable td {
		padding: 8px;
		border: 1px solid #666666;
	}
</style>
</head>
<body class="weEditorBody" onload="self.focus();" onunload="">
<form>';



$we_button = new we_button();

   /* ************* some config  ************** */
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
$DB_WE->next_record();
$feldnamen = explode("|",$DB_WE->f("strFelder"));
$waehr="&nbsp;".$feldnamen[0];
$dbTitlename="shoptitle";
$dbPreisname="Preis";
$numberformat= $feldnamen[2];
$notInc ="tblTemplates";

if (isset($feldnamen[3])) {
	$fe = explode(",",$feldnamen[3]); //determine more than just one class-ID
} else {
	$fe = array(0);
}

if(empty($classid)){
  	$classid = $fe[0];
}
if (!isset($nrOfPage)) {
	$nrOfPage = isset($feldnamen[4]) ? $feldnamen[4] : 20;
}
if ($nrOfPage=="default"){
	$nrOfPage =20;
}
if (!isset($val)){ $val = ""; }
if (!isset($varies)){ $varies = ""; }
if (isset($varies)){ $varies= "variant_".WE_SHOP_VARIANTS_ELEMENT_NAME;	}

/* ************* some config  ************** */
$parts	= array();
$daten =  "";
if (isset($daten)){

    /* ************* some initialisation  ************** */
    $mwst= (!empty($feldnamen[1]))?(($feldnamen[1]/100)+1):"";
    $da = ( $GLOBALS["WE_LANGUAGE"] == "Deutsch" )?"%d.%m.%y":"%m/%d/%y";
    $dateform = ( $GLOBALS["WE_LANGUAGE"] == "Deutsch" )?"00.00.00":"00/00/00";
    $datereg = ( $GLOBALS["WE_LANGUAGE"] == "Deutsch" ) ? "/\d\d\.\d\d\.\d\d/":"/\d\d\\/\d\d\\/\d\d/";
    if (!isset($_REQUEST['sort'])){ $_REQUEST['sort'] = ""; }
    /* ************* some initialisation  ************** */

    /* ************* number format ************** */
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
            $result=number_format($result,2,",","'");
        }
        return $result;
    }
    /* ************* number format ************** */


    /* ************* selectbox function ************** */
    function array_select($arr_value, $select_name, $label) {  // function for a selectbox for the purpose of selecting a class..
        global $DB_WE;
        global $feldnamen;
        global $classid;
        if (isset($feldnamen[3])) {
            $fe = explode(",",$feldnamen[3]); //determine more than just one class-ID
        } else {
            $fe = array(0);
        }
        $menu = "<label for=\"".$select_name."\">".$label."</label>\n";
        $menu .="<select name=\"".$select_name."\" onChange=\"document.location.href='".$_SERVER['PHP_SELF']."?typ=object&ViewClass='+ this.options[this.selectedIndex].value\">\n";

        foreach($fe as $key => $val) {
			if ($val!="") {			
	            $menu .= "  <option value=\"". $val."\"";
	            $menu .= (isset($_REQUEST[$select_name])  && $val == $_REQUEST[$select_name]) ? " selected=\"selected\"" : "";
	            $sql_merge = "SELECT ".OBJECT_TABLE.".Text as ClassIDName, ".OBJECT_TABLE.".ID as SerID FROM ".OBJECT_TABLE." WHERE ".OBJECT_TABLE.".ID = $val";
	            $DB_WE->query($sql_merge);
	            $DB_WE->next_record();
	            $menu .= ">" .$DB_WE->f("ClassIDName").  "\n";
			}
        }
        $menu .= "</select>\n";
        $menu .= '<input type="hidden" name="typ" value="object">';
        return $menu;
    }
    /* ************* selectbox function ************** */

    $selClass = array_select("$val", "ViewClass", $l_shop["classSel"]);  // displays a selectbox for the purpose of selecting a class..



    /* ********* START PROCESS THE OUTPUT IF OPTED FOR AN OBJECT *********** */

    if ($_REQUEST['typ'] == "object"){ //start output object
      	$orderBy = isset($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : 'obTitle';
        $entries = 0;
        $count_expression = "";
        $from_expression = "";
        $where_expression = "";
      	if(count($fe)>0){
      	    $fe_count = 0;

            foreach ($fe as $clId) {
                if($fe_count>0) {
                    $count_expression .= " + ";
                    $from_expression .= ", ";
                    $where_expression .= " AND ";
                }
                $count_expression .= "COUNT(DISTINCT ".OBJECT_X_TABLE."$clId.OF_ID)";
                $from_expression .= OBJECT_X_TABLE.$clId;
                $where_expression .= OBJECT_X_TABLE."$clId.OF_ID !=0";
                $fe_count++;
            }
      	} else {
            $count_expression = "COUNT(".OBJECT_X_TABLE."$classid.OF_ID)";
            $from_expression = OBJECT_X_TABLE.$classid;
            $where_expression = OBJECT_X_TABLE."$classid.OF_ID !=0";
      	}
        $DB_WE->query("SELECT $count_expression as dbEntries FROM $from_expression WHERE $where_expression");
        while($DB_WE->next_record()){					// Pager: determine the number of records;
        	$entries += $DB_WE->f("dbEntries");
        }
        $active_page = !empty($_GET['page']) ? $_GET['page'] : 0; // Pager: determine the current page
        $docType2 = isset($docType2) ? $docType2 = "objectFile" : $docType2 = "objectFile"; // Pager: determine the current page
        $typeAlias = isset($typeAlias) ? $typeAlias = "object" : $typeAlias = "object"; // Pager: determine the current page
        if(!isset($classSelectTable)) {
        	$classSelectTable = "";
        }
        if($entries !=0) {   // Pager: Number of records not empty?
            $topInfo = ($entries>0) ? $entries : $l_shop["noRecord"];

            $classid = $_REQUEST["ViewClass"]; // gets the value from the selectbox;

            $classSelectTable .= '<table cellpadding="2" cellspacing="0" width="600" border="0">
    <tr>
        <td colspan="2" class="defaultfont">'.$selClass.'</td>
    </tr>
</table>
';
            array_push($parts, array(
                    'html' => $classSelectTable,
                    'space'=> 0
                )
            );

            // :: then do the query for objects
            $queryCondition = OBJECT_X_TABLE."$classid.OF_ID = ".OBJECT_FILES_TABLE.".ID AND ".OBJECT_X_TABLE."$classid.ID = ".OBJECT_FILES_TABLE.".ObjectID";
            $queryFrom = OBJECT_X_TABLE."$classid,".OBJECT_FILES_TABLE." ";
            $queryObjects = "SELECT ".OBJECT_X_TABLE."$classid.input_shoptitle as obTitle,".OBJECT_X_TABLE."$classid.OF_ID as obID,".OBJECT_FILES_TABLE.".CreationDate as cDate,".OBJECT_FILES_TABLE.".Published as cPub,".OBJECT_FILES_TABLE.".ModDate  as cMob
                    FROM ". $queryFrom . "
                    WHERE ". $queryCondition . "
                    ORDER BY obID";
            $DB_WE->query($queryObjects);    // get the shop-objects from DB;
            // build the table
            $nr = 0;
            $orderRows = array();

            while ($DB_WE->next_record()) {

                // for the articlelist, we need also all these article, so sve them in array

                $orderRows[$nr]['articleArray'] = unserialize($DB_WE->f('strSerial'));

                // initialize all data saved for an article
                $shopArticleObject = $orderRows[$nr]['articleArray'];



                // save all data in array
                $orderRows[$nr]['obTitle'] = $DB_WE->f('obTitle'); // also for ordering
                $orderRows[$nr]['obID'] = $DB_WE->f('obID');       // also for ordering
                $orderRows[$nr]['cDate'] = $DB_WE->f('cDate');     // also for ordering
                $orderRows[$nr]['cPub'] = $DB_WE->f('cPub');       // also for ordering
                $orderRows[$nr]['cMob'] = $DB_WE->f('cMob');       // also for ordering
                //$orderRows[$nr]['type'] = "Objekt";       // also for ordering

                $orderRows[$nr]['orderArray'] = array();
                $nr++;
            }

            // build the headline
            $headline[0]["dat"] = getTitleLinkObj($l_shop["ArtName"], 'obTitle');
            $headline[1]["dat"] = getTitleLinkObj($l_shop["ArtID"], 'obID');
            //$headline[2]["dat"] = getTitleLinkObj($l_shop["docType"], $typeAlias);
            $headline[2]["dat"] = getTitleLinkObj($l_shop["artCreate"], 'cDate');
            $headline[3]["dat"] = getTitleLinkObj($l_shop["artPub"], 'cPub');
            $headline[4]["dat"] = getTitleLinkObj($l_shop["artMod"], 'cMob');

            // we need functionalitty to order these

            if (isset($_REQUEST['orderBy']) && $_REQUEST['orderBy']) {
                usort($orderRows, 'orderBy');
            }

            if(!isset($content)) {
                $content = array();
            }

            for ($nr=0,$i=($actPage*$nrOfPage); $i<sizeof($orderRows) && $i<($actPage*$nrOfPage + $nrOfPage); $i++, $nr++ ) {
                $isPublished = $orderRows[$i]['cPub'] > 0 ? true : false;
                $publishedStylePre = $isPublished ? "" : '<span style="color: red">';
                $publishedStylePost = $isPublished ? "" : "</span>";
                $publishedLinkStyle = $isPublished ? "" : ' style="color: red"';

                $content[$nr][0]['dat'] = '<a href="javascript:top.opener.top.weEditorFrameController.openDocument(\''. OBJECT_FILES_TABLE .'\' ,\''.$orderRows[$i]['obID'].'\',\''.$docType2.'\');");"'.$publishedLinkStyle.'>'.substr($orderRows[$i]['obTitle'],0,25)."..".'</a>';
                $content[$nr][1]['dat'] = $publishedStylePre . $orderRows[$i]['obID'] . $publishedStylePost;
                //$content[$nr][2]['dat'] = $orderRows[$i]['type'];
                $content[$nr][2]['dat'] = $publishedStylePre . ($orderRows[$i]['cDate'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['cDate']) : "") . $publishedStylePost;
                $content[$nr][3]['dat'] = $orderRows[$i]['cPub'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['cPub']) : "";
                $content[$nr][4]['dat'] = $publishedStylePre . ($orderRows[$i]['cMob'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['cMob']) : "") . $publishedStylePost;
            }

			array_push($parts, array(
				'html' => htmlDialogBorder3(670,100,$content, $headline),
				'space' => 0,
				'noline' => true
				)
			);

            // now the pager class at last:
            // Pager: Zweite Linkliste zeigen

            $pager = blaettern::getStandardPagerHTML(getPagerLinkObj(),$actPage,$nrOfPage,count($orderRows));

            array_push($parts, array(
                    'html' => $pager,
                    'space' => 0
                )
            );


            print we_multiIconBox::getHTML("revenues", "100%", $parts, 30, "", -1,"","",false, sprintf($GLOBALS['l_tabs']['module']['artList'], $topInfo));


        }else{ // if there is an empty result form the object table

            $parts = array();

            $out = 		'<table cellpadding="2" cellspacing="0" width="100%" border="0">'
                .	'<tr><td class="defaultfont">'.$l_shop["noRecordAlert"].'</td></tr>'
                .	'<tr><td class="defaultfont">'.$we_button->create_button("image:btn_shop_pref", "javascript:top.opener.top.we_cmd('pref_shop')", true, -1, -1, "", "", !we_hasPerm("NEW_USER")).'</td></tr>'
                .	'</table>';

            array_push($parts, array(
                        'html' => $out,
                        'space' => 0
                )
            );


            print we_multiIconBox::getHTML("revenues", "100%", $parts, 30, "", -1,"","",false, sprintf($GLOBALS['l_tabs']['module']['artList'], $l_shop["noRecord"]));

        }

        /* ********* END PROCESS THE OUTPUT IF OPTED FOR AN OBJECT *********** */


        /* ********* START PROCESS THE OUTPUT IF OPTED FOR A DOCUMENT *********** */

    }elseif($_REQUEST['typ'] == "document"){  //start output doc
        $orderBy = isset($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : 'sql';
        $DB_WE->query("SELECT count(Name) as Anzahl FROM ".LINK_TABLE." WHERE Name ='$dbTitlename'");
        while($DB_WE->next_record()){				          // Pager: determine the number of records;
            $entries = $DB_WE->f("Anzahl");
        }
        $active_page = !empty($_GET['page']) ? $_GET['page'] : 0; // Pager: determine the number of records;
        $docType = isset($docType) ? $docType = "text/webedition" : $docType = "text/webedition"; // Pager: determine the current page
        $typeAlias = isset($typeAlias) ? $typeAlias = "document" : $typeAlias = "document"; // Pager: determine the current page

        if($entries !=0){  // Pager: Number of records not empty?
            $topInfo = ($entries>0) ? $entries : $l_shop["noRecord"];
            // :: then do the query for documents
            $queryCondition = FILE_TABLE.".ID = ".LINK_TABLE.".DID AND ".LINK_TABLE.".CID = ".CONTENT_TABLE.".ID AND ".LINK_TABLE.".Name = \"".$dbTitlename."\" ";
            $queryFrom = CONTENT_TABLE.", ".LINK_TABLE.",".FILE_TABLE." ";
            $queryDocuments = "SELECT ".CONTENT_TABLE.".dat as sqlDat, ".LINK_TABLE.".DID as dd, ".FILE_TABLE.".CreationDate as dDate,".FILE_TABLE.".Published as dPub,".FILE_TABLE.".ModDate as dMod
            FROM ". $queryFrom . "
            WHERE ". $queryCondition . "
            ORDER BY dd";

            $DB_WE->query($queryDocuments);    // get the shop-documents from DB;

            //print $queryDocuments;

            // build the table
            $nr = 0;
            $orderRows = array();
            while ($DB_WE->next_record()) {

                // for the articlelist, we need also all these article, so sve them in array

                $orderRows[$nr]['articleArray'] = unserialize($DB_WE->f('strSerial'));

                // initialize all data saved for an article
                $shopArticleObject = $orderRows[$nr]['articleArray'];


                // save all data in array
                $orderRows[$nr]['sql'] = $DB_WE->f('sqlDat'); // also for ordering
                $orderRows[$nr]['dd'] = $DB_WE->f('dd');       // also for ordering
                $orderRows[$nr]['dDate'] = $DB_WE->f('dDate');     // also for ordering
                $orderRows[$nr]['dPub'] = $DB_WE->f('dPub');       // also for ordering
                $orderRows[$nr]['dMod'] = $DB_WE->f('dMod');       // also for ordering
                //$orderRows[$nr]['type'] = "Doc";       // also for ordering

                $orderRows[$nr]['orderArray'] = array();
                $nr++;
            }
            $typeAlias = "document";
            // build the headline
            $headline[0]["dat"] = getTitleLinkDoc($l_shop["ArtName"], 'sql');
            $headline[1]["dat"] = getTitleLinkDoc($l_shop["ArtID"], 'dd');
            //$headline[2]["dat"] = getTitleLinkDoc($l_shop["docType"], $typeAlias);
            $headline[2]["dat"] = getTitleLinkDoc($l_shop["artCreate"], 'dDate');
            $headline[3]["dat"] = getTitleLinkDoc($l_shop["artPub"], 'dPub');
            $headline[4]["dat"] = getTitleLinkDoc($l_shop["artMod"], 'dMod');

            // we need functionalitty to order these

            if (isset($_REQUEST['orderBy']) && $_REQUEST['orderBy']) {
                usort($orderRows, 'orderBy');
            }

            for ($nr=0,$i=($actPage*$nrOfPage); $i<sizeof($orderRows) && $i<($actPage*$nrOfPage + $nrOfPage); $i++, $nr++ ) {

                $isPublished = $orderRows[$i]['dPub'] > 0 ? true : false;
                $publishedStylePre = $isPublished ? "" : '<span style="color: red">';
                $publishedStylePost = $isPublished ? "" : "</span>";
                $publishedLinkStyle = $isPublished ? "" : ' style="color: red"';
                $content[$nr][0]['dat'] = $publishedStylePre . ('<a href="javascript:top.opener.top.weEditorFrameController.openDocument(\''. FILE_TABLE .'\' ,\''.$orderRows[$i]['dd'].'\',\''.$docType.'\');");"'.$publishedLinkStyle.'>'.substr($orderRows[$i]['sql'],0,25)."..".'</a>') . $publishedStylePost;
                $content[$nr][1]['dat'] = $publishedStylePre . ($orderRows[$i]['dd']);
                //$content[$nr][2]['dat'] = $orderRows[$i]['type'];
                $content[$nr][2]['dat'] = $publishedStylePre . ($orderRows[$i]['dDate'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['dDate']) : "") . $publishedStylePost;
                $content[$nr][3]['dat'] = $orderRows[$i]['dPub'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['dPub']) : "";
                $content[$nr][4]['dat'] = $publishedStylePre . ($orderRows[$i]['dMod'] > 0 ? date ("d.m.Y - H:m:s" , $orderRows[$i]['dMod']) : "") . $publishedStylePost;

            }
            if(!isset($content)) $content = array();
            array_push($parts, array(
                    'html' => htmlDialogBorder3(670,100,$content, $headline),
                    'space' => 0,
                    'noline' => true
                )
            );

            $pager = blaettern::getStandardPagerHTML(getPagerLinkDoc(),$actPage,$nrOfPage,count($orderRows));


            array_push($parts, array(
                    'html' => $pager,
                    'space' => 0
                )
            );

            print we_multiIconBox::getHTML("revenues", "100%", $parts, 30, "", -1,"","",false, sprintf($GLOBALS['l_tabs']['module']['artList'], $topInfo));
        }

/* ********* END PROCESS THE OUTPUT IF OPTED FOR A DOCUMENT *********** */

    }else{

        print"	Die von Ihnen gew�nschte Seite kann nicht angezeigt werden!"; //if ($_REQUEST['typ'] == "doc")

    }

}

?>
</body>
</html>
