<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
$wepos = "";
$parts = array();

if($GLOBALS["we_doc"]->EditPageNr != WE_EDITPAGE_WORKSPACE){
	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["path"],
						"html"=>$GLOBALS['we_doc']->formPath(),
						"space"=>140,
						"icon"=>"path.gif")
				);

	if($_SESSION["we_mode"] == "seem" || !we_hasPerm('CAN_SEE_OBJECTS')){	// No link to class in normal mode
		array_push($parts,array(
						"headline"=>$GLOBALS["l_object"]["class"],
						"html"=>$GLOBALS['we_doc']->formClass(),
						"space"=>140,
						'noline' => true,
						"icon"=>"class.gif")
				);

	} else if($_SESSION["we_mode"] == "normal"){	//	Link to class in normal mode
		$_html = '<div class="weMultiIconBoxHeadline" style="margin-bottom:5px;">'.'<a href="javascript:top.weEditorFrameController.openDocument(\'' . OBJECT_TABLE . '\','.$GLOBALS['we_doc']->TableID.',\'object\');">' . $GLOBALS["l_object"]["class"].'</a>'.'</div>' .
		'<div style="margin-bottom:12px;">' . $GLOBALS['we_doc']->formClass() . '</div>';
		$_html .= '<div class="weMultiIconBoxHeadline" style="margin-bottom:5px;">'.$GLOBALS['l_object']['class_id'].'</div>' .
		'<div style="margin-bottom:12px;">' . $GLOBALS['we_doc']->formClassId() . '</div>';


		array_push($parts,array(
						"headline"=>"",
						"html"=>$_html,
						"space"=>140,
						"forceRightHeadline"=>1,
						"icon"=>"class.gif")
				);

	}

	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["language"],
						"html"=>$GLOBALS['we_doc']->formLanguage(),
						"space"=>140,
						"icon"=>"lang.gif")
				);


	array_push($parts,array(
						"headline"=>$GLOBALS["l_global"]["categorys"],
						"html"=>$GLOBALS['we_doc']->formCategory(),
						"space"=>140,
						"icon"=>"cat.gif")
				);


	array_push($parts,array(
						"headline"=>$GLOBALS["l_object"]["copyObject"],
						"html"=>$GLOBALS['we_doc']->formCopyDocument(),
						"space"=>140,
						"icon"=>"copy.gif")
	);


	array_push($parts,array(
							"headline"=>$GLOBALS["l_we_class"]["owners"],
							"html"=>$GLOBALS['we_doc']->formCreatorOwners(),
							"space"=>140,
							"icon"=>"user.gif")
	);


	array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["Charset"],
						"html"=>$GLOBALS['we_doc']->formCharset(),
						"space"=>140,
						"icon"=>"charset.gif")
				);
} else {

	if($GLOBALS['we_doc']->hasWorkspaces()){	//	Show workspaces
		array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["workspaces"],
						"html"=>$GLOBALS['we_doc']->formWorkspaces(),
						"space"=>140,
						"noline"=>1,
						"icon"=>"workspace.gif")
				);
		array_push($parts,array(
						"headline"=>$GLOBALS["l_we_class"]["extraWorkspaces"],
						"html"=>$GLOBALS['we_doc']->formExtraWorkspaces(),
						"space"=>140,
						"forceRightHeadline"=>1)
				);
				$we_button = new we_button();

				$button = $we_button->create_button("ws_from_class","javascript:we_cmd('ws_from_class');_EditorFrame.setEditorIsHot(true);");
				
				array_push($parts,array(
						"headline"=>"",
						"html"=>$button,
						"space"=>140)
				);
	} else {									//	No workspaces defined

		array_push($parts,array(
						"headline"=> "",
						"html"    => $GLOBALS['l_object']["no_workspace_defined"],
						"space"   => 0)
				);
	}

}
print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("weOjFileProp","100%",$parts,30);


?>