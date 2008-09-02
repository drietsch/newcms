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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");

protect();

$_binary = $_REQUEST["we_cmd"][0];
$bSort = $_binary{0};
$bDisplay = $_binary{1};
$bDate = $_binary{2};
$bPrio = $_binary{3};
$bValid = $_binary{4};

$_title = $_REQUEST["we_cmd"][4];

$js = "
var _sObjId='" . $_REQUEST["we_cmd"][5] . "';
var _sType='pad';
var _sTb='" . $_title . "';

function init(){
	parent.rpcHandleResponse(_sType,_sObjId,document.getElementById(_sType),_sTb);
}
";

///////////////////////////////////////////////////////////////////
// SORTIERUNG                                                    //
///////////////////////////////////////////////////////////////////
$out_bSort = 'ERROR bSort';
$q_sort = '';

switch ($bSort) {
	case 0 :
		// nach Erstelldatum
		$out_bSort = 'nach Erstelldatum';
		$q_sort = 'CreationDate,Title';
		break;
	case 1 :
		// nach Priorit�t
		$out_bSort = 'nach Priorit�t';
		$q_sort = 'Priority, Title';
		break;
	case 2 :
		// nach g�ltig ab
		$out_bSort = 'nach g�ltig ab';
		$q_sort = 'ValidFrom, Title';
		break;
	case 3 :
		// alphabetisch
		$out_bSort = 'alphabetisch';
		$q_sort = 'Title';
		break;
	case 4 :
		// nach g�ltig bis
		$out_bSort = 'nach g�ltig bis';
		$q_sort = 'ValidUntil, Title';
		break;
}

///////////////////////////////////////////////////////////////////
// ANZEIGE                                                       //
///////////////////////////////////////////////////////////////////
if ($bDisplay == 0) {
	// alle Notizen
	$out_bDisplay = 'alle Notizen';
	$q_display = '';
} else 
	if ($bDisplay == 1) {
		// nur g�ltige
		$out_bDisplay = 'nur g�ltige';
		$q_display = '';
	}

///////////////////////////////////////////////////////////////////
// ANZEIGE DATUM                                                 //
///////////////////////////////////////////////////////////////////
switch ($bDate) {
	case 0 :
		// nach Erstelldatum
		$out_bDate = 'nach Erstelldatum';
		break;
	case 1 :
		// nach g�ltig ab
		$out_bDate = 'nach g�ltig ab';
		break;
	case 2 :
		// nach g�ltig bis
		$out_bDate = 'nach g�ltig bis';
		break;
}

///////////////////////////////////////////////////////////////////
// DEFAULT-PRIORIT�T                                             //
///////////////////////////////////////////////////////////////////
switch ($bPrio) {
	case 0 :
		// hoch
		$out_bPrio = 'high';
		break;
	case 1 :
		// mittel
		$out_bPrio = 'medium';
		break;
	case 2 :
		// niedrig
		$out_bPrio = 'low';
		break;
}

///////////////////////////////////////////////////////////////////
// DEFAULT-G�LTIGKEIT                                            //
///////////////////////////////////////////////////////////////////
switch ($bValid) {
	case 0 :
		// immer
		$out_bValid = 'always';
		break;
	case 1 :
		// ab Zeitpunkt
		$out_bValid = 'date';
		break;
	case 2 :
		// Zeitraum
		$out_bValid = 'period';
		break;
}

/*$pad = '<pre>';
$pad .= 'bSort: '.$out_bSort."\n";
$pad .= 'bDisplay: '.$out_bDisplay."\n";
$pad .= 'bDate: '.$out_bDate."\n";
$pad .= 'bPrio: '.$out_bPrio."\n";
$pad .= 'bValid: '.$out_bValid."\n";
$pad .= '_title: '.$_title."\n";
$pad .= '</pre>';*/

////////////////////////////////////////////////////////
$_get_title = 'title 1';
$_get_text = 'Text 1';
$_get_valid = 'always';
$_get_valid_from = '2006-12-22';
$_get_valid_until = '2006-12-28';
$_get_prio = 'high';
////////////////////////////////////////////////////////


$_table = TBL_PREFIX . 'tblwidgetnotepad';

$_sql = "INSERT INTO
	" . $_table . " 
(
	WidgetName,
	UserID,
	CreationDate,
	Title,
	Text,
	Priority,
	Valid,
	ValidFrom,
	ValidUntil
) VALUES (
	'" . $_title . "',
	" . $_SESSION['user']['ID'] . ",
	DATE_FORMAT(NOW(), \"%Y-%m-%d\"),
	'" . $_get_title . "',
	'" . $_get_text . "',
	'" . $_get_prio . "',
	'" . $_get_valid . "',
	'" . $_get_valid_from . "',
	'" . $_get_valid_until . "'
)
";
$DB_WE = new DB_WE();
//$DB_WE->query($_sql);


if ($bDisplay) {
	$_sql = "SELECT * FROM " . $_table . " WHERE 
	WidgetName = '" . $_title . "' AND 
	UserID = " . $_SESSION['user']['ID'] . " 
	ORDER BY " . $q_sort;
} else {
	$_sql = "SELECT * FROM " . $_table . " WHERE 
	WidgetName = '" . $_title . "' AND 
	UserID = " . $_SESSION['user']['ID'] . " AND
	(
		Valid = 'always' OR
		(
			Valid = 'date' AND
			ValidFrom = DATE_FORMAT(NOW(), \"%Y-%m-%d\")
		) OR
		(
			Valid = 'period' AND
			ValidFrom >= DATE_FORMAT(NOW(), \"%Y-%m-%d\") AND
			ValidUntil <= DATE_FORMAT(NOW(), \"%Y-%m-%d\")
		)
	)
	ORDER BY " . $q_sort;
}
$DB_WE->query($_sql);
$pad .= '<table cellspacing="0" cellpadding="0" border="0">';
while ($DB_WE->next_record()) {
	$pad .= '<tr>';
	$pad .= '<td width="20" height="20" valign="middle" nowrap>' . we_htmlElement::htmlImg(
			array(
				"src" => IMAGE_DIR . "pd/prio_" . $DB_WE->f("Priority") . ".gif", "width" => 13, "height" => 14
			)) . '</td>';
	$pad .= '<td valign="middle" class="middlefont">' . we_htmlElement::htmlA(
			array(
				"href" => "javascript:void(0)", "title" => "", "style" => "color:#000000;text-decoration:none;"
			), 
			$DB_WE->f("Title")) . '</td>';
	$pad .= '</tr>';
	// $DB_WE->f("Text")
}

$pad .= '</table>';

/*$we_button = new we_button();
$pad .= '<div style="background-color:#CFCFCF;">';
$pad .= $we_button->create_button("image:btn_add_field","javascript:void(0);",false,-1,-1);
$pad .= '</div>';

$pad .= '<form action="#" method="get">
<table cellspacing="0" cellpadding="0" style="border-collapse: collapse"><tr>
 <td><input type="text" name="date" id="f_date" readonly="1" /></td>
 <td>'.we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/date_selector.gif","id"=>"f_trigger","width"=>20,"height"=>14,"title"=>"Date selector")).'</td>
</table>
</form>

<script type="text/javascript">
Calendar.setup({
	inputField:"f_date",
	ifFormat:"%B %e, %Y",
	button:"f_trigger",
	align:"Tl",
	singleClick:true
});
</script>';


$pad .= '
	<link rel="stylesheet" type="text/css" media="all" href="'.JS_DIR.'jscalendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="'.JS_DIR.'jscalendar/calendar.js"></script>
  <script type="text/javascript" src="'.JS_DIR.'jscalendar/lang/calendar-de.js"></script>
  <script type="text/javascript" src="'.JS_DIR.'jscalendar/calendar-setup.js"></script>

<table cellspacing="0" cellpadding="0" style="border-collapse: collapse"><tr>
 <td><input type="text" name="date" id="f_date" readonly="1" /></td>
 <td><img src="'.JS_DIR.'jscalendar/img.gif" id="f_trigger" title="Date selector"></td>
</table>


<script type="text/javascript">
Calendar.setup({
	inputField:"f_date",
	ifFormat:"%B %e, %Y",
	button:"f_trigger",
	align:"Tl",
	singleClick:true
});
</script>';
*/
print "hello";
//$ifr = "<iframe allowtransparency=\"true\" src=\"".WEBEDITION_DIR."we/include/we_widgets/mod/pad1.inc.php\"\" id=\"\" style=\"width:430px;height:100px\" scrolling=\"auto\" marginheight=\"0\" marginwidth=\"0\" frameborder=\"0\"></iframe>\n";
print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['notepad']) . STYLESHEET . //'<link rel="stylesheet" type="text/css" media="all" href="'.JS_DIR.'jscalendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />'.
						//we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/test.js")).
						//we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar.js")).
						//we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/lang/calendar-de.js")).
						//we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar-setup.js")).
						we_htmlElement::jsElement(
								$js)) . we_htmlElement::htmlBody(
						array(
							
								"marginwidth" => "15", 
								"marginheight" => "10", 
								"leftmargin" => "15", 
								"topmargin" => "10", 
								"onload" => "if(parent!=self)init();"
						), 
						we_htmlElement::htmlDiv(array(
							"id" => "pad"
						), $pad)));

?>
