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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");


//	send charset, if one is set:
if(isset($we_doc->elements["Charset"]["dat"]) && $we_doc->elements["Charset"]["dat"] && $we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES ){
	header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
}

htmlTop();
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php print STYLESHEET; ?>
	</head>
	<body bgcolor="white" marginwidth="15" marginheight="15" leftmargin="15" topmargin="15" onUnload="doUnload()">
			<form name="we_form" method="post" onsubmit="return false;"><?php $we_doc->pHiddenTrans(); ?>
<?php

	$fields = $we_doc->getVariantFieldNames();

	$headline = array();

	$headline[0] = array(
		'dat'=>$l_we_class["variant_fields"]
	);


	$content = array();
	foreach($fields  as $ind=>$field){
		$element = $we_doc->getElement('variant_'.$field);
		$content[$ind] = array();
		$content[$ind][0]['dat'] = we_forms::checkboxWithHidden($element ? true : false,'we_' . $we_doc->Name . "_variant[variant_$field]",$field,false,'middlefont','_EditorFrame.setEditorIsHot(true);');
	}

	$parts = array();

	$parts[]=array(
			'headline' => '',
			'html' => htmlAlertAttentionBox($l_we_class['variant_info'],2,620, false),
			'space' => 0,
			'noline'=>1
	);

	$parts[]=array(
			'headline' => '',
			'html' => htmlDialogBorder3(600,0, $content ,$headline),
			'space' => 0,
			'noline'=>1

	);


	print we_multiIconBox::getHTML("template_variant", "100%", $parts,30,'',-1,'','',false);

?>
		</form>
	</body>
</html>