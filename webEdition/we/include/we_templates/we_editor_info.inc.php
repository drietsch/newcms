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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


if(defined("WORKFLOW_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
}
htmlTop();

$we_button = new we_button();

?>
<?php print STYLESHEET; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<script type="text/javascript">
	function revertToPublished() {
		if (confirm("<?php print addslashes($GLOBALS["l_we_editor_info"]["revert_publish_question"]); ?>")) {
			top.we_cmd("revert_published");
		}
	}


<?php if (isset($_REQUEST['we_cmd'][0]) && $_REQUEST['we_cmd'][0] == 'revert_published') { ?>

var _EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction("<?php print $GLOBALS['we_transaction']; ?>");

_EditorFrame.setEditorIsHot(false);

<?php print $GLOBALS["we_doc"]->getUpdateTreeScript(true); ?>

_EditorFrame.getDocumentReference().frames[3].location.reload();


<?php } ?>

</script>
	</head>
	<body class="weEditorBody">
<?php

$parts = array();

	$_html = '<div class="weMultiIconBoxHeadline" style="margin-bottom:5px;">ID</div>' .
		'<div style="margin-bottom:10px;">' . ($GLOBALS['we_doc']->ID ?  $GLOBALS['we_doc']->ID : "-") . '</div>';

	$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["content_type"].'</div>' .
		'<div style="margin-bottom:10px;">' . $GLOBALS["l_we_editor_info"][$GLOBALS["we_doc"]->ContentType] .'</div>';


if($GLOBALS['we_doc']->ContentType != "folder"){

	$fs = $GLOBALS["we_doc"]->getFilesize();

	$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["file_size"].'</div>' .
		'<div style="margin-bottom:10px;">' . round(($fs / 1024),2)."&nbsp;KB&nbsp;(".$fs."&nbsp;Byte)" .'</div>';
}

array_push($parts, array(	"headline"=>"",
							"html"=>$_html,
							"space"=>140,
							"icon" => "doclist/" . we_getIcon($GLOBALS['we_doc']->ContentType, isset($GLOBALS['we_doc']->Extension) ? $GLOBALS['we_doc']->Extension : "")
						)
			);

if($GLOBALS['we_doc']->ContentType != "folder"){

	$_html = '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["creation_date"].'</div>' .
		'<div style="margin-bottom:10px;">' . date($GLOBALS["l_we_editor_info"]["date_format"], $GLOBALS["we_doc"]->CreationDate) .'</div>';




	if($GLOBALS["we_doc"]->CreatorID){
		$GLOBALS["DB_WE"]->query("SELECT First,Second,username FROM " . USER_TABLE . " WHERE ID=".$GLOBALS["we_doc"]->CreatorID);
		if ($GLOBALS["DB_WE"]->next_record()) {
			$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_users"]["created_by"].'</div>' .
				'<div style="margin-bottom:10px;">' . $GLOBALS["DB_WE"]->f("First").' '.$GLOBALS["DB_WE"]->f("Second").' ('.$GLOBALS["DB_WE"]->f("username").')' .'</div>';
		}
	}

	$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["changed_date"].'</div>' .
		'<div style="margin-bottom:10px;">' . date($GLOBALS["l_we_editor_info"]["date_format"], $GLOBALS["we_doc"]->ModDate) .'</div>';


	if($GLOBALS["we_doc"]->ModifierID){
		$GLOBALS["DB_WE"]->query("SELECT First,Second,username FROM " . USER_TABLE . " WHERE ID=".$GLOBALS["we_doc"]->ModifierID);
		if ($GLOBALS["DB_WE"]->next_record()) {
			$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_users"]["changed_by"].'</div>' .
				'<div style="margin-bottom:10px;">' . $GLOBALS["DB_WE"]->f("First").' '.$GLOBALS["DB_WE"]->f("Second").' ('.$GLOBALS["DB_WE"]->f("username").')' .'</div>';

		}
	}

	if($GLOBALS["we_doc"]->ContentType == "text/html" || $GLOBALS["we_doc"]->ContentType == "text/webedition"){
		$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["lastLive"].'</div>' .
			'<div style="margin-bottom:10px;">' . ($GLOBALS['we_doc']->Published ? date($l_we_editor_info["date_format"],$GLOBALS['we_doc']->Published) : "-") .'</div>';

		if ($GLOBALS['we_doc']->Published && $GLOBALS["we_doc"]->ModDate > $GLOBALS['we_doc']->Published) {
			$_html .= '<div style="margin-bottom:10px;">' . $we_button->create_button('revert_published','javascript:revertToPublished();',true,280) .'</div>';
		}

	}

	array_push($parts, array(	"headline"=>"",
							"html"=>$_html,
							"space"=>140,
							"icon" => "cal.gif"
						)
			);
	if($GLOBALS['we_doc']->Table != TEMPLATES_TABLE){

		$rp = $GLOBALS['we_doc']->getRealPath();
		$http = $GLOBALS['we_doc']->getHttpPath();
		$showlink = ($GLOBALS['we_doc']->ContentType=="text/html"||
					$GLOBALS['we_doc']->ContentType=="text/webedition" ||
					$GLOBALS['we_doc']->ContentType=="image/*"  ||
					$GLOBALS['we_doc']->ContentType=="application/x-shockwave-flash"  ||
					$GLOBALS['we_doc']->ContentType=="video/quicktime");

		$published = true;
		if(($GLOBALS['we_doc']->ContentType == "text/html" || $GLOBALS['we_doc']->ContentType == "text/webedition") && $GLOBALS['we_doc']->Published == 0) {
			$published = false;
		}

		$_html = '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["local_path"].'</div>' .
			'<div style="margin-bottom:10px;">' . ($GLOBALS['we_doc']->ID == 0 || !$published ? '-' : '<span title="'.htmlspecialchars($rp).'">'.htmlspecialchars(shortenPath($rp,74)).'</span>') .'</div>';
		$_html .= '<div class="weMultiIconBoxHeadline" style="padding-bottom:5px;">'.$GLOBALS["l_we_editor_info"]["http_path"].'</div>' .
			'<div style="margin-bottom:10px;">' . ($GLOBALS['we_doc']->ID == 0 || !$published ? '-' : ($showlink ? '<a href="'.$http.'" target="_blank" title="'.htmlspecialchars($http).'">' : '').shortenPath($http,74).($showlink ? '</a>' : '')) .'</div>';

		array_push($parts, array(	"headline"=>"",
								"html"=>$_html,
								"space"=>140,
								"icon" => "path.gif"
							)
				);
	}
	if(defined("WORKFLOW_TABLE") && $GLOBALS["we_doc"]->ContentType == "text/webedition"){
		if(weWorkflowUtility::inWorkflow($GLOBALS["we_doc"]->ID,$GLOBALS["we_doc"]->Table)){
			$anzeige = weWorkflowUtility::getDocumentStatusInfo($GLOBALS["we_doc"]->ID,$GLOBALS["we_doc"]->Table);
		}else{
			$anzeige = weWorkflowUtility::getLogButton($GLOBALS["we_doc"]->ID,$GLOBALS["we_doc"]->Table);
		}
		array_push($parts,array(	"headline"=>$l_workflow["workflow"],
									"html"=>$anzeige,
									"space"=>140,
									"forceRightHeadline"=>1,
									"icon"=>"workflow.gif"
								)
				);
	}

	if ($GLOBALS['we_doc']->ContentType == "image/*") {

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/metadata.inc.php");

		$_metaData = $GLOBALS['we_doc']->getMetaData();

		$_metaDataTable = '<table border="0" cellpadding="0" cellspacing="0">
';

		$_metaDataTable .= '<tr><td style="padding-bottom: 5px;" class="weMultiIconBoxHeadline" colspan="2">' . $l_metadata['info_exif_data'] . '</td></tr>
';
		if (isset($_metaData["exif"])) {
			foreach ($_metaData["exif"] as $_key => $_val) {
				$_metaDataTable .= '<tr><td style="padding:0px 5px 5px 0px;" class="defaultfont">' . htmlspecialchars($_key) . ':</td><td style="padding:0px 5px 5px 0px;" class="defaultfont">' . htmlspecialchars($_val) . '</td></tr>
';
			}
		}
		if (!isset($_metaData["exif"]) || count($_metaData["exif"]) == 0) {
				$_metaDataTable .= '<tr><td style="padding:0px 5px 5px 0px;" class="defaultfont" colspan="2">' . (is_callable("exif_read_data") ? $l_metadata['no_exif_data'] : $l_metadata['no_exif_installed']) . '</td></tr>
';
		}

		$_metaDataTable .= '<tr><td style="padding:10px 0 5px 0;" class="weMultiIconBoxHeadline" colspan="2">' . $l_metadata['info_iptc_data'] . '</td></tr>
';
		if (isset($_metaData["iptc"])) {
			foreach ($_metaData["iptc"] as $_key => $_val) {
				$_metaDataTable .= '<tr><td style="padding:0px 5px 5px 0px;" class="defaultfont">' . htmlspecialchars($_key) . ':</td><td style="padding:0px 5px 5px 0px;" class="defaultfont">' . htmlspecialchars($_val) . '</td></tr>
';
			}
		}
		if (!isset($_metaData["iptc"]) || count($_metaData["iptc"]) == 0) {
				$_metaDataTable .= '<tr><td style="padding:0px 5px 5px 0px;" class="defaultfont" colspan="2">' . $l_metadata['no_iptc_data'] . '</td></tr>
';
		}
		$_metaDataTable .= '</table>';
		array_push($parts,array(	"headline"=>"",
									"html"=>$_metaDataTable,
									"space"=>140,
									"forceRightHeadline"=>1,
									"icon"=>"meta.gif"
								)
				);
	} else if ($GLOBALS['we_doc']->IsBinary) {
		array_push($parts,array(	"headline"=>"Metadaten",
									"html"=>$l_metadata['no_metadata_supported'],
									"space"=>140,
									"forceRightHeadline"=>1,
									"icon"=>"meta.gif"
								)
				);
	}
}

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("","100%",$parts,20,"",-1,"","",false);
?>
	</body>
</html>
