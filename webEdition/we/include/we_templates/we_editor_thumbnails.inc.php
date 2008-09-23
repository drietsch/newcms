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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_image_edit.class.php");


htmlTop();
?>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php print STYLESHEET; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
	</head>
	<body class="weEditorBody">
<form name="we_form"><?php $we_doc->pHiddenTrans(); ?>
		<table cellpadding="6" cellspacing="0" border="0">
<?php


$parts = array();
$we_button = new we_button();


if(we_image_edit::gd_version() > 0){

	$_doc = $we_doc->getDocument();
	$imgType = we_image_edit::detect_image_type("",$_doc);

	if(!$we_doc->getDocument()){
		array_push($parts, array(		"headline"=>"",
										"html"=>htmlAlertAttentionBox($GLOBALS["l_thumbnails"]["no_image_uploaded"],2,"700"),
										"space"=>0
								)
						);
	}else if(we_image_edit::is_imagetype_read_supported($imgType)){

		// look if the fields origwidth & origheight exixts. If not get and set the values
		if((!isset($we_doc->elements["origwidth"]["dat"])) || (!isset($we_doc->elements["origheight"]["dat"]))){
			$arr = $we_doc->getOrigSize();
			$we_doc->setElement("origwidth",$arr[0],"attrib");
			$we_doc->setElement("origheight",$arr[1],"attrib");
			unset($arr);
		}

		$thumbs = $we_doc->getThumbs();

		foreach($thumbs as $thumbid){


			$thumbObj = new we_thumbnail();
			$thumbObj->initByThumbID(	$thumbid,
										$we_doc->ID,
										$we_doc->Filename,
										$we_doc->Path,
										$we_doc->Extension,
										$we_doc->getElement("origwidth"),
										$we_doc->getElement("origheight"),
										$we_doc->getDocument());


			srand ((double)microtime()*1000000);
			$randval = rand();


			$useOrig = $thumbObj->isOriginal();

			if((!$useOrig) && $we_doc->ID && ($we_doc->DocChanged==false) && file_exists($thumbObj->getOutputPath(true))){
					$src = $thumbObj->getOutputPath(false).'?rand='.$randval;
			}else{
					$src = WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=show_binaryDoc&amp;we_cmd[1]='.
								$we_doc->ContentType.'&amp;we_cmd[2]='.
								$we_transaction.'&amp;we_cmd[3]='.($useOrig ? "" : $thumbid).'&amp;rand='.$randval;
			}


			$delbut = $we_button->create_button("image:btn_function_trash","javascript:_EditorFrame.setEditorIsHot(true);we_cmd('del_thumb','".$thumbid."');",true,30);


			$thumbnail = '<table border="0" cellpadding="0" cellspacing="0" width="570"><tr><td width="538"><img src="'.$src.'" width="'.$thumbObj->getOutputWidth().
						'" height="'.$thumbObj->getOutputHeight().'" border="0"></td><td width="10">'.getPixel(10,2).'</td><td width="22">'.$delbut.'</td></tr></table>';

			array_push($parts, array(	"headline"=>$thumbObj->getThumbName(),
										"html"=>$thumbnail,
										"space"=>120
									)
						);

		}
		array_push($parts, array(		"headline"=>"",
										"html"=>htmlAlertAttentionBox($GLOBALS["l_thumbnails"]["add_descriptiontext"],2,"700").'<br><br>'. $we_button->create_button("image:btn_add_thumbnail", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('add_thumbnail','".$we_transaction."');"),
										"space"=>0
								)
						);
	}else{
		array_push($parts, array(		"headline"=>"",
										"html"=>htmlAlertAttentionBox($GLOBALS["l_thumbnails"]["format_not_supported"],2,"700"),
										"space"=>0
								)
						);
	}
}else{
	array_push($parts, array(		"headline"=>"",
									"html"=>htmlAlertAttentionBox($GLOBALS["l_thumbnails"]["add_description_nogdlib"],2,"700"),
									"space"=>0
							)
					);

}
print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("","100%",$parts,20);

?>

</form>
	</body>
</html>