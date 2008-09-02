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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");

htmlTop($l_global["select_color"]);

print STYLESHEET;

$we_button = new we_button();
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>we_colors2.js"></script>
<script language="JavaScript" type="text/javascript">

function selectColor(c){
	document.we_form.colorvalue.value = c;
}
function setColor(){
<?php if($_REQUEST["we_cmd"][0]): ?>
	opener.document.we_form.elements["<?php print $_REQUEST["we_cmd"][1]; ?>"].value = document.we_form.colorvalue.value;
	
	<?php if (isset($_REQUEST["we_cmd"][3]) && $_REQUEST["we_cmd"][3]) { ?>
	
		<?php print $_REQUEST["we_cmd"][3]; ?>
		
	<?php } else { ?>
	
		opener._EditorFrame.setEditorIsHot(true);
		opener.we_cmd("reload_editpage");
		
	<?php } ?>
	
<?php else: ?>
	window.returnValue = document.we_form.colorvalue.value;
<?php endif ?>
	window.close();
}
function init(){
	top.focus();
<?php if($_REQUEST["we_cmd"][0]): ?>
	document.we_form.colorvalue.value = "<?php print $_REQUEST["we_cmd"][2]; ?>";
<?php else: ?>
	document.we_form.colorvalue.value = window.dialogArguments["bgcolor"];
<?php endif ?>
}
</script>
	</head>


<body class="weDialogBody"<?php if($_REQUEST["we_cmd"][0]): ?> onLoad="init()"<?php endif ?>>
<form name="we_form" onSubmit="<?php if(!$_REQUEST["we_cmd"][0]): ?>setColor();<?php endif ?>return false">
		<?php
$colortable = '<table border="1" bordercolor="SILVER" bordercolorlight="WHITE" bordercolordark="BLACK" cellspacing="0" cellpadding="0">
<script language="JavaScript" type="text/javascript">
var z=0;
for ( col in we_color2 ){
	if(z == 0){
		document.writeln(\'<tr>\');
	}

document.writeln(\'<td bgcolor="\'+col+\'"><a href="#" onClick="selectColor(\\\'\'+col+\'\\\');"><img src="'.IMAGE_DIR.'pixel.gif" width="15" height="15" border="0" alt="\'+we_color2[col]+\'"></a></td>\');

if(z==17){
		document.writeln(\'</tr>\');
		z = 0;
	}else{
		z++;
	}
}
if(z != 0){
	for(var i=z;i<18;i++){
		document.writeln(\'<td></td>\');
	}
	document.writeln(\'</tr>\');
}
</SCRIPT>
		</table>
	';

	$foo = '<input type="text" size="20" name="colorvalue" class="defaultfont" style="width:150px">';
	$color = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["color"]);

if($_REQUEST["we_cmd"][0]){
	$buttons =
		$we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:setColor();"),
											"",
											$we_button->create_button("cancel", "javascript:window.close()")
										  );
}else{
	$buttons =
		$we_button->position_yes_no_cancel(	$we_button->create_button("ok", "form:submit:we_form"),
											"",
											$we_button->create_button("cancel", "javascript:window.close()")
										  );
}
	$table = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$colortable.'</td>
	</tr>
	<tr>
		<td>'.getPixel(2,10).'</td>
	</tr>
	<tr>
		<td>'.$color.'</td>
	</tr>
</table>
';

	print htmlDialogLayout($table,$l_global["select_color"], $buttons);
	?>
		</form>
	</body>

</html>