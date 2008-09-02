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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/banner.inc.php");
protect();
htmlTop($GLOBALS["l_banner"]["bannercode"]);
print STYLESHEET;

$code = '';
$ok = isset($_REQUEST["ok"]) ? $_REQUEST["ok"] : "";
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";
$tagname = isset($_REQUEST["tagname"]) ? $_REQUEST["tagname"] : "";
$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : "";
$target = isset($_REQUEST["target"]) ? $_REQUEST["target"] : "";
$width = isset($_REQUEST["width"]) ? $_REQUEST["width"] : 468;
$height = isset($_REQUEST["height"]) ? $_REQUEST["height"] : 60;
$paths = isset($_REQUEST["paths"]) ? $_REQUEST["paths"] : "";
$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
$prot = getServerProtocol();
$getscript = isset($_REQUEST["getscript"]) ? $_REQUEST["getscript"] : $prot."://".SERVER_NAME.$port."/webEdition/getBanner.php";
$clickscript = isset($_REQUEST["clickscript"]) ? $_REQUEST["clickscript"] : $prot."://".SERVER_NAME.$port."/webEdition/bannerclick.php";

if($ok){

	if($type=="js"){
		$code = '<script language="JavaScript" type="text/javascript">
<!--
r = Math.random();
document.write ("<" + "script language=\"JavaScript\" type=\"text/javascript\" src=\"'.$getscript.'?r="+r+"&amp;bannername='.rawurlencode($tagname).'&amp;paths='.rawurlencode($paths).'&amp;type=js&amp;target='.rawurlencode($target).'&amp;bannerclick='.rawurlencode($clickscript).'&amp;height='.rawurlencode($height).'&amp;width='.rawurlencode($width).'&amp;page='.rawurlencode($page).'"+(document.referer ? ("&amp;referer="+escape(document.referer)) : "")+"\"><" + "/script>");
//-->
</script><noscript><a href="'.$clickscript.'?u='.md5(uniqid(rand(0,99999))).'&amp;bannername='.rawurlencode($tagname).'&amp;page='.rawurlencode($page).'" target="'.$target.'"><img src="'.$getscript.'?bannername='.rawurlencode($tagname).'&amp;paths='.rawurlencode($paths).'&amp;page='.rawurlencode($page).'&amp;bannerclick='.rawurlencode($clickscript).'&amp;c=1" border="0" alt="" width="'.$width.'" height="'.$height.'"></a></noscript>';
	}else{
		$code = '<iframe
	src="'.$getscript.'?bannername='.rawurlencode($tagname).'&amp;type=iframe&amp;target='.rawurlencode($target).'&amp;bannerclick='.rawurlencode($clickscript).'&amp;width='.rawurlencode($width).'&amp;height='.rawurlencode($height).'&amp;page='.rawurlencode($page).'"
	width="'.$width.'"
	height="'.$height.'"
	vspace=0
	frameborder=0
	scrolling=no
	align=center
><ilayer
	src="'.$getscript.'?bannername='.rawurlencode($tagname).'&amp;type=iframe&amp;target='.rawurlencode($target).'&amp;bannerclick='.rawurlencode($clickscript).'&amp;width='.rawurlencode($width).'&amp;height='.rawurlencode($height).'&amp;page='.rawurlencode($page).'"
	width="'.$width.'"
	height="'.$height.'"
></ilayer><nolayer><a href="'.$clickscript.'?u='.md5(uniqid(rand(0,99999))).'&amp;bannername='.rawurlencode($tagname).'&amp;page='.rawurlencode($page).'" target="'.$target.'"><img src="'.$getscript.'?bannername='.rawurlencode($tagname).'&amp;paths='.rawurlencode($paths).'&amp;page='.rawurlencode($page).'&amp;bannerclick='.rawurlencode($clickscript).'" border="0" alt="" width="'.$width.'" height="'.$height.'"></a></a>
</nolayer>
</iframe>';
	}
}

?>

		<script language="JavaScript">

			self.focus();


function checkForm(f){
	if(f.tagname.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_tagname_empty"], WE_MESSAGE_ERROR); ?>
		f.tagname.focus();
		f.tagname.select();
		return false;
	}
	if(f.page.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_page_empty"], WE_MESSAGE_ERROR); ?>
		f.page.focus();
		f.page.select();
		return false;
	}
	if(f.width.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_width_empty"], WE_MESSAGE_ERROR); ?>
		f.width.focus();
		f.width.select();
		return false;
	}
	if(f.height.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_height_empty"], WE_MESSAGE_ERROR); ?>
		f.height.focus();
		f.height.select();
		return false;
	}
	if(f.getscript.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_getscript_empty"], WE_MESSAGE_ERROR); ?>
		f.getscript.focus();
		f.getscript.select();
		return false;
	}
	if(f.clickscript.value==""){
		<?php print we_message_reporting::getShowMessageCall($l_banner["error_clickscript_empty"], WE_MESSAGE_ERROR); ?>
		f.clickscript.focus();
		f.clickscript.select();
		return false;
	}
	return true;
}
		</script>


	</head>
	<body class="weDialogBody"<?php if($ok){ ?> onload="document.we_form.code.focus();document.we_form.code.select();"<?php } ?>>
	<form onsubmit="return checkForm(this);" name="we_form" action="<?php print $_SERVER["PHP_SELF"]; ?>" method="get"><input type="hidden" name="ok" value="1"><input type="hidden" name="we_cmd[0]" value="<?php print $_REQUEST["we_cmd"][0]; ?>">
<?php


$typeselect = '<select name="type" size="1">
<option'.(($type == "js") ? " selected" : "").'>js</option>
<option'.(($type == "iframe") ? " selected" : "").'>iframe</option>
</select>';

$content = '<table border="0" cellpadding="0" cellspacing="0">
';
if(!$ok){
	$content.= '	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["type"].'</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.$typeselect.'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["tagname"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("tagname",40,$tagname,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["pageurl"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("page",40,$page,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["target"].'</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("target",40,$target,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["width"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("width",40,$width,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["height"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("height",40,$height,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["paths"].'</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("paths",40,$paths,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["getscript"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("getscript",40,$getscript,"","","text",300).'</td>
	</tr>
	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_banner"]["clickscript"].'*</td><td>'.getPixel(10,2).'</td><td class="defaultfont">'.htmlTextInput("clickscript",40,$clickscript,"","","text",300).'</td>
	</tr>
';
}
if($ok){
	$content .= '	<tr>
		<td colspan="3">'.getPixel(10,10).'</td>
	</tr>
	<tr>
		<td colspan="3" class="defaultfont"><textarea name="code" rows="8" cols="40" style="width:430px;height:300px">'.htmlspecialchars($code).'</textarea></td>
	</tr>
';
}
$we_button = new we_button();
$content .= '</table>'.(($ok) ? "" : '<p class="defaultfont">*'.$l_banner["required"]).'</p>';
$cancel_button = $we_button->create_button("cancel", "javascript:top.close();");
$ok_button = $we_button->create_button("ok", "form:submit:we_form");
$back_button = $we_button->create_button("back", "javascript:history.back();");
$close_button = $we_button->create_button("close", "javascript:top.close();");

$buttons = $ok ? $we_button->position_yes_no_cancel($close_button,null,$back_button) : $we_button->position_yes_no_cancel($ok_button,null,$cancel_button);

print  htmlDialogLayout($content,$ok ? $GLOBALS["l_banner"]["bannercode_copy"] : $GLOBALS["l_banner"]["bannercode_ext"],$buttons);
?>
	</form>
	</body>
</html>
