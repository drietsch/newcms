<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

htmlTop();

?>

	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>

<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php");

	print STYLESHEET;

?>

</head>

<body class="weEditorBody">
	<form name="we_form" method="post" onsubmit="return false;">
		<?php $we_doc->pHiddenTrans(); ?>
		<?php


		$parts = array();
		array_push($parts,array("icon"=>"upload.gif", "headline"=>"","html"=>$GLOBALS['we_doc']->formUpload(),"space"=>140));
		if (method_exists($GLOBALS['we_doc'],"formProperties")) array_push($parts,array("icon"=>"attrib.gif", "headline"=>$GLOBALS["l_we_class"]["attribs"],"html"=>$GLOBALS['we_doc']->formProperties(),"space"=>140));
		array_push($parts,array("icon"=>"meta.gif", "headline"=>$GLOBALS["l_we_class"]["metadata"],"html"=>$GLOBALS['we_doc']->formMetaInfos().$GLOBALS['we_doc']->formMetaData(),"space"=>140));
		print we_multiIconBox::getJS();
		print we_multiIconBox::getHTML("weImgProp","100%",$parts,20);

		?>
	</form>
</body>

</html>