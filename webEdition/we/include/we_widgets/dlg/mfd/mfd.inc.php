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
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/date.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_history.class.php");

protect();

$sTypeBinary = $_REQUEST["we_cmd"][0];
$bTypeDoc = (bool)$sTypeBinary{0};
$bTypeTpl = (bool)$sTypeBinary{1};
$bTypeObj = (bool)$sTypeBinary{2};
$bTypeCls = (bool)$sTypeBinary{3};
$iDate = $_REQUEST["we_cmd"][1];
switch ($iDate) {
	case 1 :
		$timestamp = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		break;
	case 2 :
		$iTime = time() - (7 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
	case 3 :
		$iTime = time() - (30 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
	case 4 :
		$iTime = time() - (365 * 24 * 60 * 60);
		$timestamp = mktime(
				date('H', $iTime), 
				date('i', $iTime), 
				date('s', $iTime), 
				date('m', $iTime), 
				date('d', $iTime), 
				date('Y', $iTime));
		break;
}
$iNumItems = $_REQUEST["we_cmd"][2];
switch ($iNumItems) {
	case 0 :
		$iMaxItems = 200;
		break;
	case 11 :
		$iMaxItems = 15;
		break;
	case 12 :
		$iMaxItems = 20;
		break;
	case 13 :
		$iMaxItems = 25;
		break;
	case 14 :
		$iMaxItems = 50;
		break;
	default :
		$iMaxItems = $iNumItems;
}
$sDisplayOpt = $_REQUEST["we_cmd"][3];
$bMfdBy = $sDisplayOpt{0};
$bDateLastMfd = $sDisplayOpt{1};
$aUsers = makeArrayFromCSV($_REQUEST["we_cmd"][4]);

$sJsCode = "
var _sObjId='" . $_REQUEST["we_cmd"][5] . "';
var _sType='mfd';
var _sTb='" . $l_cockpit['last_modified'] . "';

function init(){
	parent.rpcHandleResponse(_sType,_sObjId,document.getElementById(_sType),_sTb);
}
";

$_where = array();
$_ws = array();
$_users_where = array();
foreach ($aUsers as $uid) {
	$_users_where[] = '"' . basename(id_to_path($uid, USER_TABLE)) . '"';
}

if ($bTypeDoc && we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', FILE_TABLE) . '"';
	$_ws[FILE_TABLE] = get_ws(FILE_TABLE);
}
if ($bTypeObj && we_hasPerm('CAN_SEE_OBJECTS')) {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', OBJECT_FILES_TABLE) . '"';
	$_ws[OBJECT_FILES_TABLE] = get_ws(OBJECT_FILES_TABLE);
}
if ($bTypeTpl && we_hasPerm('CAN_SEE_TEMPLATES') && $_SESSION["we_mode"] != "seem") {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', TEMPLATES_TABLE) . '"';
}
if ($bTypeCls && we_hasPerm('CAN_SEE_CLASSES') && $_SESSION["we_mode"] != "seem") {
	$_where[] = '"' . str_replace(TBL_PREFIX, '', OBJECT_TABLE) . '"';
}

$lastModified = '';
$lastModified .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
$_count = 10;
$i = $j = $k = 0;
while ($j < $iMaxItems) {
	$_query = "SELECT * FROM " . HISTORY_TABLE . (!empty($_where) ? (' WHERE ' . ((count($_users_where) > 0) ? 'UserName IN (' . implode(
			',', 
			$_users_where) . ') AND ' : '') . 'DocumentTable IN(' . implode(',', $_where) . ')') : '') . (($iDate) ? ' AND ModDate >' . $timestamp : '') . ' ORDER BY ModDate DESC LIMIT ' . ($k * $_count) . " , " . $_count . ";";
	$k++;
	$DB_WE->query($_query);
	$_db = new DB_WE();
	$num_rows = $DB_WE->num_rows();
	if ($num_rows == 0) {
		break;
	}
	while ($DB_WE->next_record()) {
		$_table = TBL_PREFIX . $DB_WE->f("DocumentTable");
		$_paths = array();
		$_bool_ot = (defined("OBJECT_TABLE")) ? (($_table != OBJECT_TABLE) ? true : false) : true;
		if (!we_hasPerm('ADMINISTRATOR') || ($_table != TEMPLATES_TABLE && $_bool_ot)) {
			if (isset($_ws[$_table])) {
				$_wsa = makeArrayFromCSV($_ws[$_table]);
				foreach ($_wsa as $_id) {
					$_paths[] = 'Path LIKE ("' . id_to_path($_id, $_table) . '%")';
				}
			}
		}
		$_hash = getHash(
				"SELECT ID,Path,Icon,Text,ContentType,ModDate,CreatorID,Owners,RestrictOwners FROM " . $_table . " WHERE ID = '" . $DB_WE->f(
						"DID") . "'" . (!empty($_paths) ? (' AND (' . implode(' OR ', $_paths) . ')') : '') . ";", 
				$_db);
		if (!empty($_hash)) {
			$_show = true;
			$_bool_oft = (defined("OBJECT_FILES_TABLE")) ? (($_table == OBJECT_FILES_TABLE) ? true : false) : true;
			
			if ($_table == FILE_TABLE || $_bool_oft) {
				$_show = we_history::userHasPerms($_hash['CreatorID'], $_hash['Owners'], $_hash['RestrictOwners']);
			}
			if ($_show) {
				if ($i + 1 <= $iMaxItems) {
					$i++;
					$j++;
					$lastModified .= '<tr>';
					$lastModified .= '<td width="20" height="20" valign="middle" nowrap><img src="' . ICON_DIR . $_hash['Icon'] . '">' . getpixel(
							4, 
							1) . '</td>';
					$lastModified .= '<td valign="middle" class="middlefont">';
					$lastModified .= '<a href="' . 'javascript:top.weEditorFrameController.openDocument(\'' . $_table . '\',\'' . $_hash['ID'] . '\',\'' . $_hash['ContentType'] . '\');"' . ' title="' . $_hash['Path'] . '" style="color:#000000;text-decoration:none;">' . $_hash['Path'] . "</a></td>";
					if ($bMfdBy)
						$lastModified .= '<td>' . getpixel(5, 1) . '</td><td class="middlefont" nowrap>' . $DB_WE->f(
								"UserName") . (($bDateLastMfd) ? ',' : '') . '</td>';
					if ($bDateLastMfd)
						$lastModified .= '<td>' . getpixel(5, 1) . '</td><td class="middlefont" nowrap>' . date(
								$GLOBALS["l_global"]["date_format"], 
								$_hash['ModDate']) . '</td>';
					$lastModified .= "</tr>\n";
				} else {
					break;
				}
			} else {
				$j++;
			}
		} else {
			break;
		}
	}
}

$lastModified .= "</table>\n";

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['last_modified']) . STYLESHEET . we_htmlElement::jsElement(
								$sJsCode)) . we_htmlElement::htmlBody(
						array(
							
								"marginwidth" => "15", 
								"marginheight" => "10", 
								"leftmargin" => "15", 
								"topmargin" => "10", 
								"onload" => "if(parent!=self)init();"
						), 
						we_htmlElement::htmlDiv(array(
							"id" => "mfd"
						), $lastModified)));

?>
