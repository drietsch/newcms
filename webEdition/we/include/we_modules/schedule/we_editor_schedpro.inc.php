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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/schedpro.inc.php");
include_once(WE_SCHEDULE_MODULE_DIR."we_schedpro.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

if(defined("SCHEDULE_TABLE")){
	trigger_schedule();
}

htmlTop();
?>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php print STYLESHEET; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
	</head>
	<body  class="weEditorBody" onunload="doUnload()">
<form name="we_form" onsubmit="return false"><?php $we_doc->pHiddenTrans(); ?>
<?php

$parts = array();
$we_button = new we_button();

foreach($we_doc->schedArr as $i=>$sched){
	$schedObj = new we_schedpro($sched,$i);

	$ofT = defined("OBJECT_FILES_TABLE") ? OBJECT_FILES_TABLE : "";

	array_push($parts, array(	"headline"=>"",
								"html"=>$schedObj->getHTML($GLOBALS["we_doc"]->Table==$ofT),
								"space"=>0
							)
				);

}
array_push($parts, array(		"headline"=>"",
								"html"=>htmlAlertAttentionBox($GLOBALS["l_schedpro"]["descriptiontext"],2,"700").'<br><br>'. $we_button->create_button("image:btn_add_schedule", "javascript:we_cmd('add_schedule')"),
								"space"=>0
						)
				);
print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("","100%",$parts,20,"",-1,"","",false);

?>

</form>
	</body>
</html>