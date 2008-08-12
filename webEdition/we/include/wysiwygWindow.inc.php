<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

@header("Content-Type: text/html; charset=" . ($_REQUEST["we_cmd"][15] ? $_REQUEST["we_cmd"][15] : "ISO-8859-1") );
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_wysiwyg.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


protect();

$we_button = new we_button();

$we_dt = isset($_SESSION["we_data"][$_REQUEST["we_cmd"][4]]) ? $_SESSION["we_data"][$_REQUEST["we_cmd"][4]] : "";
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

if (eregi('^.+_te?xt\[.+\]$',$_REQUEST["we_cmd"][1])) {
	$fieldName = ereg_replace('^.+_te?xt\[(.+)\]$','\1',$_REQUEST["we_cmd"][1]);
} else if (eregi('^.+_input\[.+\]$',$_REQUEST["we_cmd"][1])) {
	$fieldName = ereg_replace('^.+_input\[(.+)\]$','\1',$_REQUEST["we_cmd"][1]);
}

htmlTop(sprintf($GLOBALS["l_wysiwyg"]["window_title"],$fieldName),($_REQUEST["we_cmd"][15] ? $_REQUEST["we_cmd"][15] : "ISO-8859-1"));

if(isset($fieldName) && isset($_REQUEST["we_okpressed"]) && $_REQUEST["we_okpressed"]){
	if (eregi('^(.+_te?xt)\[.+\]$',$_REQUEST["we_cmd"][1])) {
		$reqName = ereg_replace('^(.+_te?xt)\[.+\]$','\1',$_REQUEST["we_cmd"][1]);
	} else if (eregi('^(.+_input)\[.+\]$',$_REQUEST["we_cmd"][1])) {
		$reqName = ereg_replace('^(.+_input)\[.+\]$','\1',$_REQUEST["we_cmd"][1]);
	}
	$we_doc->setElement($fieldName,$_REQUEST[$reqName][$fieldName],"input");
	$we_doc->saveInSession($_SESSION["we_data"][$_REQUEST["we_cmd"][4]]);
	$newHTML = $we_doc->getField(array("name"=>$fieldName));


?>
<script language="JavaScript" type="text/javascript">
	if(top.opener && top.opener.top.weEditorFrameController.getVisibleEditorFrame()){
		if(top.opener.top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_<?php print $_REQUEST["we_cmd"][1]; ?>")){
			top.opener.top.weEditorFrameController.getVisibleEditorFrame().document.getElementById("wysiwyg_div_<?php print $_REQUEST["we_cmd"][1]; ?>").innerHTML = "<?php print preg_replace('|script|i', 'scr"+"ipt',str_replace("\"","\\\"",str_replace("\r","\\r",str_replace("\n","\\n",$newHTML)))); ?>";
		}

		//top.opener.we_cmd("reload_editpage");
	}
	top.close();
</script>

</head>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
<?php

}else{
	$cancelBut = $we_button->create_button("cancel","javascript:top.close()");
	$okBut = $we_button->create_button("ok","javascript:weWysiwygSetHiddenText();document.we_form.submit();");

	print STYLESHEET;
?>
<script src="<?php print JS_DIR; ?>windows.js" language="JavaScript" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">top.focus();</script>
</head>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" background="<?php print IMAGE_DIR . 'backgrounds/aquaBackground.gif'; ?>">
<form action="<?php print $_SERVER['PHP_SELF']; ?>" name="we_form" method="post">
<input type="hidden" name="we_okpressed" value="1">
<?php

	foreach($_REQUEST["we_cmd"] as $i=>$v){
		print '<input type="hidden" name="we_cmd['.$i.']" value="'.$_REQUEST["we_cmd"][$i].'">'."\n";
	}


/*
1 = name
2 = width
3 = height
4 = transaction
5 = propstring
6 = classname
7 = fontnames
8 = outsidewe
9 = tbwidth (toolbar width)
10 = tbheight
11 = xml
12 = remove first paragraph
13 = bgcolor
14 = baseHref
15 = charset
16 = cssClasses
17 = Language

*/


	$e = new we_wysiwyg(	$_REQUEST["we_cmd"][1],
							$_REQUEST["we_cmd"][2],
							$_REQUEST["we_cmd"][3],
							$we_doc->getElement($fieldName),
							$_REQUEST["we_cmd"][5],
							$_REQUEST["we_cmd"][13],
							"",
							$_REQUEST["we_cmd"][6],
							$_REQUEST["we_cmd"][7],
							$_REQUEST["we_cmd"][8],
							$_REQUEST["we_cmd"][11],
							$_REQUEST["we_cmd"][12],
							true,
							$_REQUEST["we_cmd"][14],
							$_REQUEST["we_cmd"][15],
							$_REQUEST["we_cmd"][16],
							$_REQUEST["we_cmd"][17]
						);

	print we_wysiwyg::getHeaderHTML().$e->getHTML();
	print '<div style="height:8px"></div>' .$we_button->position_yes_no_cancel($okBut, $cancelBut);


?>
</form>
<?php

}

?>
</body>
</html>
