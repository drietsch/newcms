<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");

class weImageDialog extends weDialog{

##################################################################################################

	var $ClassName = "weImageDialog";
	var $changeableArgs = array(	"type",
									"extSrc",
									"fileID",
									"src",
									"fileSrc",
									"width",
									"height",
									"hspace",
									"vspace",
									"border",
									"alt",
									"align",
									"name",
									"thumbnail",
									"ratiow",
									"class",
									"title",
									"longdescid",
									"longdescsrc",
									"longdesc"
								);

##################################################################################################

	function weImageDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["edit_image"];
	}

##################################################################################################

	function initBySrc($src,$width="",$height="",$hspace="",$vspace="",$border="",$alt="",$align="",$name="",$class="",$title="",$longdesc=""){
		if($src){
			$this->args["src"] = $src;
			$tokkens = explode("?",$src);
			$id = "";
			$thumb=0;
			if(sizeof($tokkens) == 2){
				$foo = explode("=",$tokkens[1]);
				if(sizeof($foo) == 2){
					if($foo[0]=="id"){
						$id = $foo[1];
					}else if($foo[0]=="thumb"){
						$foo = explode(",",$foo[1]);
						$id = $foo[0];
						$thumb = $foo[1];
					}
				}
			}
			if($id){
				$this->args["type"] = "int";
				$this->args["extSrc"] = "";
				$this->args["fileID"] = $id;
				$this->args["fileSrc"] = $tokkens[0];
				$this->args["thumbnail"] = $thumb;
				//$this->args["src"] .= "?id=".$id;
			}else{
				$this->args["type"] = "ext";
				$this->args["extSrc"] = ereg_replace('^/webEdition/','',ereg_replace('^/webEdition/we_cmd.php[^"\'#]+(#.*)$','\1',eregi_replace('^https?://'.SERVER_NAME.'(/.*)$','\1', $this->args["src"])));
				$this->args["fileID"] = "";
				$this->args["fileSrc"] = "";
				$this->args["thumbnail"] = 0;
			}
		}else{
			$this->args["type"] = "ext";
			$this->args["extSrc"] = "http://";
		}
		$this->initAttributes($width,$height,$hspace,$vspace,$border,$alt,$align,$name,$class,$title,$longdesc);
	}

##################################################################################################

	function initAttributes($width="",$height="",$hspace="",$vspace="",$border="",$alt="",$align="",$name="",$class="",$title="",$longdesc=""){
		$tokkens = explode("?",$longdesc);
		$longdescid = "";
		if(sizeof($tokkens) == 2){
			$foo = explode("=",$tokkens[1]);
			if(sizeof($foo) == 2){
				if($foo[0]=="id"){
					$longdescid = $foo[1];
				}
			}
		}

		$this->args["width"] = $width;
		$this->args["height"] = $height;
		$this->args["hspace"] = $hspace;
		$this->args["vspace"] = $vspace;
		$this->args["border"] = $border;
		$this->args["alt"] = $alt;
		$this->args["align"] = $align;
		$this->args["name"] = $name;
		$this->args["class"] = $class;
		$this->args["title"] = $title;
		$this->args["longdesc"] = $longdesc;
		$this->args["longdescid"] = $longdescid;
		if($longdescid){
			$this->args["longdescsrc"] = $tokkens[0];
		}else{
			$this->args["longdescsrc"] = "";
		}
		$this->args["ratio"] = isset($_REQUEST["we_dialog_args"]["ratio"]) ? $_REQUEST["we_dialog_args"]["ratio"] : 1;
	}

##################################################################################################

	function initByFileID($fileID,$width="",$height="",$hspace="",$vspace="",$border="",$alt="",$align="",$name="",$thumb="",$class="",$title="",$longdesc=""){
		if($fileID){
			$this->args["type"] = "int";
			$this->args["extSrc"] = "";
			$this->args["fileID"] = $fileID;
			if($thumb){
				$thumbObj = new we_thumbnail();
				$thumbObj->initByImageIDAndThumbID($fileID,$thumb);
				$thumbpath = $thumbObj->getOutputPath();
				$this->args["thumbnail"] = $thumb;
				$this->args["fileSrc"] = id_to_path($fileID);
				$this->args["src"] = $thumbpath."?thumb=".$fileID.",".$thumb;
				$width = $thumbObj->getOutputWidth();
				$height = $thumbObj->getOutputHeight();
				unset($thumbObj);
			}else{
				$this->args["thumbnail"] = "";
				$this->args["fileSrc"] = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".$this->args["fileID"]."'","Path",$this->db);
				$this->args["src"] = $this->args["fileSrc"]."?id=".$fileID;
			}
			$this->args["ratio"] = "1";
		}
		$this->initAttributes($width,$height,$hspace,$vspace,$border,$alt,$align,$name,$class,$title,$longdesc);
	}

##################################################################################################

	function initByHttp(){
		weDialog::initByHttp();
		$src = $this->getHttpVar("src");
		$width = $this->getHttpVar("width");
		$height = $this->getHttpVar("height");
		$hspace = $this->getHttpVar("hspace");
		$vspace = $this->getHttpVar("vspace");
		$class = $this->getHttpVar("class");
		$title = $this->getHttpVar("title");
		$longdescsrc = $this->getHttpVar("longdescsrc");
		$longdescid = $this->getHttpVar("longdescid");
		if($longdescsrc && $longdescid){
			$longdesc = $longdescsrc."?id=".$longdescid;
		}else{
			$longdesc = $this->getHttpVar("longdesc");
		}
		$border = $this->getHttpVar("border");
		$alt = $this->getHttpVar("alt");
		$align = $this->getHttpVar("align");
		$name = $this->getHttpVar("name");
		$type = $this->getHttpVar("type");
		$thumbnail = $this->getHttpVar("thumbnail");

		if(!$type) $type = "ext";
		if($src && !$thumbnail){
			$this->initBySrc($src,$width,$height,$hspace,$vspace,$border,$alt,$align,$name,$class,$title,$longdesc);
		}else if($type){
			$fileID = $this->getHttpVar("fileID");

			switch($type){
				case "ext":
					$extSrc = $this->getHttpVar("extSrc","");
					$this->initBySrc($extSrc,$width,$height,$hspace,$vspace,$border,$alt,$align,$name,$class,$title,$longdesc);
					break;
				case "int":
					if(isset($_REQUEST["imgChangedCmd"]) && $_REQUEST["imgChangedCmd"] && $fileID){
						$imgpath = $_SERVER['DOCUMENT_ROOT']. id_to_path($fileID);
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_imageDocument.inc.php");
						$imgObj = new we_imageDocument();
						$imgObj->initByID($fileID);
						$width = $imgObj->getElement("width");
						$height = $imgObj->getElement("height");
						$alt = $_REQUEST["wasThumbnailChange"] ? $alt : $imgObj->getElement("alt");
						$hspace = $_REQUEST["wasThumbnailChange"] ? $hspace : $imgObj->getElement("hspace");
						$vspace = $_REQUEST["wasThumbnailChange"] ? $vspace : $imgObj->getElement("vspace");
						$title = $_REQUEST["wasThumbnailChange"] ? $title : $imgObj->getElement("title");
						$name = $_REQUEST["wasThumbnailChange"] ? $name : $imgObj->getElement("name");
						$align = $_REQUEST["wasThumbnailChange"] ? $align : $imgObj->getElement("align");
						$border = $_REQUEST["wasThumbnailChange"] ? $border : $imgObj->getElement("border");
						$longdesc = $_REQUEST["wasThumbnailChange"] ? $longdesc : ($imgObj->getElement("longdescid") ? (id_to_path($imgObj->getElement("longdescid"))."?id=".$imgObj->getElement("longdescid")) : $longdesc);
		 				$alt = $_REQUEST["wasThumbnailChange"] ? $alt : f("SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . CONTENT_TABLE . "," . LINK_TABLE . " WHERE " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND " . LINK_TABLE . ".DocumentTable='" . substr(FILE_TABLE, strlen(TBL_PREFIX)) . "' AND " . LINK_TABLE . ".DID='".$fileID."' AND " . LINK_TABLE . ".Name='alt'","Dat",$this->db);
					}
					$this->initByFileID($fileID,$width,$height,$hspace,$vspace,$border,$alt,$align,$name,$thumbnail,$class,$title,$longdesc);
					break;
			}
		}else{
			$this->defaultInit();
		}
	}

##################################################################################################

	function defaultInit(){
		$this->args["src"] = "";
		$this->args["width"] = "";
		$this->args["height"] = "";
		$this->args["hspace"] = "";
		$this->args["vspace"] = "";
		$this->args["class"] = "";
		$this->args["title"] = "";
		$this->args["longdesc"] = "";
		$this->args["border"] = "";
		$this->args["alt"] = "";
		$this->args["align"] = "";
		$this->args["name"] = "";
		$this->args["type"] = "ext";
		$this->args["ratio"] = "1";
	}

##################################################################################################
	function getFormHTML() {
		$hiddens = "";
		if(isset($_REQUEST["we_cmd"]) && is_array($_REQUEST["we_cmd"])){
			foreach($_REQUEST["we_cmd"] as $k=>$v){
				$hiddens .= "<input type=\"hidden\" name=\"we_cmd[$k]\" value=\"".rawurlencode($v)."\">";
			}
		}
		$target = '';
		if(!$this->JsOnly) {
			$target = ' target="we_'.$this->ClassName.'_cmd_frame"';
		}
		return '<form name="we_form" action="'.$_SERVER["PHP_SELF"].'" method="post"' . $target . ' onsubmit="return fsubmit(this)">'.$hiddens;
	}

	function getDialogContentHTML(){
		global $BROWSER;
		$yuiSuggest =& weSuggest::getInstance();
		$we_button = new we_button();

		if($this->args["outsideWE"] == "1"){
			$extSrc = htmlFormElementTable(htmlTextInput("we_dialog_args[extSrc]",30,(isset($this->args["extSrc"]) ? $this->args["extSrc"] : ""),"","","text",410),
											"src",
											"left",
											"defaultfont",
											getPixel(10,2),
											"",
											"","","",0
										);
			$intSrc = "";
			$thumbnails="";

			$_longdesc   = htmlFormElementTable(htmlTextInput("we_dialog_args[longdesc]",30,str_replace('"','&quot;',(isset($this->args["longdesc"]) ? $this->args["longdesc"] : "") ),"",'',"text",520),
												$GLOBALS["l_we_class"]["longdesc_text"]);

		}else{
			$but = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ?
				$we_button->create_button(	"select",
											"javascript:we_cmd('browse_server','document.we_form.elements[\\'we_dialog_args[extSrc]\\'].value','',document.we_form.elements['we_dialog_args[extSrc]'].value,'opener.document.we_form.elements[\\'we_dialog_args[type]\\'][0].checked=true;opener.imageChanged();')"
										  )
					: "";

			$radioBut = we_forms::radiobutton(	"ext",
												(isset($this->args["type"]) && $this->args["type"] =="ext"),
												"we_dialog_args[type]",
												$GLOBALS["l_wysiwyg"]["external_image"],true,"defaultfont","imageChanged();"
											  );

			$extSrc = htmlFormElementTable(htmlTextInput("we_dialog_args[extSrc]",30,(isset($this->args["extSrc"]) ? $this->args["extSrc"] : ""),"",' onfocus="if(this.form.elements[\'we_dialog_args[type]\'][1].checked) { this.form.elements[\'we_dialog_args[type]\'][0].checked=true;imageChanged();}" onChange="this.form.elements[\'we_dialog_args[type]\'][0].checked=true;imageChanged();"',"text",300),
											$radioBut,
											"left",
											"defaultfont",
											getPixel(20,2),
											$but,
											"","","",0
										);

			$but      = $we_button->create_button(	"select",
													"javascript:we_cmd('openDocselector',document.we_form.elements['we_dialog_args[fileID]'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'we_dialog_args[fileID]\\'].value','document.we_form.elements[\\'we_dialog_args[fileSrc]\\'].value','opener.document.we_form.elements[\\'we_dialog_args[type]\\'][1].checked=true;opener.imageChanged();','','','image/*',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");"
													);

			$radioBut = we_forms::radiobutton(	"int",
												(isset($this->args["type"]) && $this->args["type"]=="int"),
												"we_dialog_args[type]",
												$GLOBALS["l_wysiwyg"]["internal_image"],true,"defaultfont","imageChanged();");
		
			$yuiSuggest->setAcId("Image");
			$yuiSuggest->setContentType("folder,image/*");
			$yuiSuggest->setInput("we_dialog_args[fileSrc]",str_replace('"','&quot;',(isset($this->args["fileSrc"]) ? $this->args["fileSrc"] : "")),array("onfocus"=>"document.we_form.elements[2].checked=true;","onchange"=>"imageChanged()"));
			$yuiSuggest->setLabel($radioBut);
			$yuiSuggest->setMaxResults(10);
			$yuiSuggest->setMayBeEmpty(true);
			$yuiSuggest->setResult("we_dialog_args[fileID]",str_replace('"','&quot;',(isset($this->args["fileID"]) ? $this->args["fileID"] : "") ));
			$yuiSuggest->setSelector("Docselector");
			$yuiSuggest->setWidth(300);
			$yuiSuggest->setSelectButton($but);
			
			$intSrc = $yuiSuggest->getHTML();

			$thumbdata = (isset($this->args["thumbnail"]) ? $this->args["thumbnail"] : "");

			$_p = (isset($this->args["fileSrc"]) ? $this->args["fileSrc"] : "");
			$extension = $_p ? ereg_replace('^.+(\.[^\.]+)$','\1',$_p) : "";
			unset($_p);

			if(we_image_edit::gd_version() > 0 && we_image_edit::is_imagetype_supported(isset($GLOBALS['GDIMAGE_TYPE'][strtolower($extension)]) ? $GLOBALS['GDIMAGE_TYPE'][strtolower($extension)] : "") && (isset($this->args["type"]) && $this->args["type"]=="int")){

				$thumbnails = '<select name="we_dialog_args[thumbnail] size="1" onchange="imageChanged(true);">'."\n";
				$thumbnails .= '<option value="0"'.(($thumbdata==0) ? (' selected="selected"') : "").'>'.$GLOBALS["l_wysiwyg"]["nothumb"].'</option>'."\n";
				$this->db->query("SELECT ID,Name FROM " . THUMBNAILS_TABLE . " ORDER BY Name");
				while($this->db->next_record()){
					$thumbnails .= '<option value="'.$this->db->f("ID").'"'.(($thumbdata==$this->db->f("ID")) ? (' selected="selected"') : "").'>'.$this->db->f("Name").'</option>'."\n";
				}
				$thumbnails .= '</select>';

				$thumbnails = htmlFormElementTable($thumbnails,$GLOBALS["l_wysiwyg"]["thumbnail"]);
			}else{
				$thumbnails = "";
			}
			$but      = $we_button->create_button(	"select", "javascript:we_cmd('openDocselector',document.we_form.elements['we_dialog_args[longdescid]'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'we_dialog_args[longdescid]\\'].value','document.we_form.elements[\\'we_dialog_args[longdescsrc]\\'].value','','','','',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");");
			$but2     = $we_button->create_button("image:btn_function_trash", "javascript:document.we_form.elements['we_dialog_args[longdescid]'].value='';document.we_form.elements['we_dialog_args[longdescsrc]'].value='';");

			$yuiSuggest->setAcId("Longdesc");
			$yuiSuggest->setContentType("folder,text/webedition,text/html");
			$yuiSuggest->setInput("we_dialog_args[longdescsrc]",str_replace('"','&quot;',(isset($this->args["longdescsrc"]) ? $this->args["longdescsrc"] : "") ));
			$yuiSuggest->setLabel($GLOBALS["l_we_class"]["longdesc_text"]);
			$yuiSuggest->setMaxResults(7);
			$yuiSuggest->setMayBeEmpty(true);
			$yuiSuggest->setResult("we_dialog_args[longdescid]",(isset($this->args["longdescid"]) ? $this->args["longdescid"] : ""));
			$yuiSuggest->setSelector("Docselector");
			$yuiSuggest->setWidth(363);
			$yuiSuggest->setSelectButton($but);
			$yuiSuggest->setTrashButton($but2);
			
			$_longdesc   =  $yuiSuggest->getHTML();
		}

		$foo = htmlTextInput("we_dialog_args[width]", 5, (isset($this->args["width"]) ? $this->args["width"] :""), "", ' onkeypress="return IsDigitPercent(event);" onkeyup="return checkWidthHeight(this);"', "text" , 50 );

		$width = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["width"]);

		$foo = htmlTextInput("we_dialog_args[height]", 5, (isset($this->args["height"]) ? $this->args["height"] :""), "", ' onkeypress="return IsDigitPercent(event);" onkeyup="return checkWidthHeight(this);"', "text" , 50 );
		$height = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["height"]);

		$foo = htmlTextInput("we_dialog_args[hspace]", 5, (isset($this->args["hspace"]) ? $this->args["hspace"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );
		$hspace = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["hspace"]);

		$foo = htmlTextInput("we_dialog_args[vspace]", 5, (isset($this->args["vspace"]) ? $this->args["vspace"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );
		$vspace = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["vspace"]);

		$foo = htmlTextInput("we_dialog_args[border]", 5, (isset($this->args["border"]) ? $this->args["border"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );
		$border = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["border"]);

		$foo = htmlTextInput("we_dialog_args[alt]", 5, (isset($this->args["alt"]) ? $this->args["alt"] :""), "", "", "text" , 200 );
		$alt = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["altText"]);

		$foo = htmlTextInput("we_dialog_args[title]", 5, (isset($this->args["title"]) ? $this->args["title"] :""), "", "", "text" , 200 );
		$title = htmlFormElementTable($foo,$GLOBALS["l_global"]["title"]);


		$foo = '<select class="defaultfont" name="we_dialog_args[align]" size="1">
							<option value="">Default</option>
							<option value="top"'.(($this->args["align"] == "top") ? "selected" : "").'>Top</option>
							<option value="middle"'.(($this->args["align"] == "middle") ? "selected" : "").'>Middle</option>
							<option value="bottom"'.(($this->args["align"] == "bottom") ? "selected" : "").'>Bottom</option>
							<option value="left"'.(($this->args["align"] == "left") ? "selected" : "").'>Left</option>
							<option value="right"'.(($this->args["align"] == "right") ? "selected" : "").'>Right</option>
							<option value="texttop"'.(($this->args["align"] == "texttop") ? "selected" : "").'>Text Top</option>
							<option value="absmiddle"'.(($this->args["align"] == "absmiddle") ? "selected" : "").'>Abs Middle</option>
							<option value="baseline"'.(($this->args["align"] == "baseline") ? "selected" : "").'>Baseline</option>
							<option value="absbottom"'.(($this->args["align"] == "absbottom") ? "selected" : "").'>Abs Bottom</option>
						</select>';
		$align = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["alignment"]);

		$foo = htmlTextInput("we_dialog_args[name]", 30, (isset($this->args["name"]) ? $this->args["name"] :""), "", '', "text" , 200 );
		$name = htmlFormElementTable($foo,"Name");

		$srctable = '<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="defaultgray" valign="top">'.$GLOBALS["l_wysiwyg"]["image_url"].'</td><td>'.$extSrc.'</td>
	</tr>
';
		if($intSrc){
			$srctable .= '	<tr>
		<td>'.getPixel(100,4).'</td><td>'.getPixel(10,4).'</td>
	</tr>
	<tr>
		<td></td><td>'.$intSrc.'</td>
	</tr>
';
			if($thumbnails){
				$srctable .= '	<tr>
		<td>'.getPixel(100,4).'</td><td>'.getPixel(10,4).'</td>
	</tr>
	<tr>
		<td></td><td>'.$thumbnails.'</td>
	</tr>
';
			}
		}
			$srctable .= '	<tr>
		<td>'.getPixel(100,4).'</td><td>'.getPixel(10,4).'</td>
	</tr>
	</table>
';

	$foo = '<script language="JavaScript" type="text/javascript">showclasss("we_dialog_args[class]","'.(isset($this->args["class"]) ? $this->args["class"] : "") .'","");</script>';
	$classSelect = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["css_style"]);

	$onclick = "checkWidthHeight(document.we_form.elements['we_dialog_args[width]']);";

	$ratio = we_forms::checkboxWithHidden((isset($this->args["ratio"]) ? $this->args["ratio"] : false),"we_dialog_args[ratio]",$GLOBALS["l_thumbnails"]["ratio"],false,"defaultfont",$onclick);

	$parts = array();

	$parts[] = array("html"=>$srctable);

	$table = '<table cellpadding="0" cellspacing="0" border="0" width="400">
<tr><td>'.$width.'</td><td>'.$height.'</td><td>'.$ratio.'</td></tr>
</table>';
	$parts[] = array("html"=>$table);

	$table = '<table cellpadding="0" cellspacing="0" border="0" width="560">
<tr><td>'.$hspace.'</td><td>'.$vspace.'</td><td>'.$border.'</td><td>'.$align.'</td></tr>
</table><div></div>';
	$parts[] = array("html"=>$table);

	$table = '<div style="height:240px"><table cellpadding="0" cellspacing="0" border="0" width="380">
<tr><td colspan="2">'.$name.'</td><td colspan="2">'.$alt.'</td></tr>
<tr><td colspan="4">'.getPixel(150,15).'</td></tr>
<tr><td colspan="2">'.$classSelect.'</td><td colspan="2">'.$title.'</td></tr>
<tr><td>'.getPixel(160,15).'</td><td>'.getPixel(160,4).'</td><td>'.getPixel(100,4).'</td><td>'.getPixel(100,4).'</td></tr>
<tr><td colspan="4">'.$_longdesc.'</td></tr>
<tr><td colspan="4">'.getPixel(150,15).'</td></tr>

</table></div>
'.hidden("imgChangedCmd","0").hidden("wasThumbnailChange","0");
	$thisPart  = $table;
	$thisPart .= $yuiSuggest->getYuiCss();
	$thisPart .= $yuiSuggest->getYuiJs();
	$parts[] = array("html"=>$thisPart);
	return $parts;

	}

##################################################################################################

	function getJs(){
		$yuiSuggest =& weSuggest::getInstance();
		$js = weDialog::getJs(). '	<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>
	<script language=javascript>
function we_cmd(){
	var args = "";
	var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
	switch (arguments[0]){
    case "openDocselector":
		new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_DOCSELECTOR_WIDTH.','.WINDOW_DOCSELECTOR_HEIGHT.',true,true,true,true);
		break;
	case "browse_server":
		new jsWindow(url,"browse_server",-1,-1,840,400,true,false,true);
		break;
	}
}

function imageChanged(wasThumbnailChange){
	if(wasThumbnailChange != null && wasThumbnailChange){
		document.we_form.wasThumbnailChange.value="1";
	}
	document.we_form.target="we_weImageDialog_edit_area";
	document.we_form.we_what.value="dialog";
	document.we_form.imgChangedCmd.value="1";
	document.we_form.submit();

}

function checkWidthHeight(field){
	var ratioCheckBox = document.getElementById("_we_dialog_args[ratio]");
	if(ratioCheckBox.checked){
		if(field.value.indexOf("%") == -1){
			if(ratiow && ratioh){
				if(field.name=="we_dialog_args[height]"){
					field.form.elements["we_dialog_args[width]"].value = Math.round(field.value * ratioh);
				}else{
					field.form.elements["we_dialog_args[height]"].value = Math.round(field.value * ratiow);
				}
			}
		}else{
			ratioCheckBox.checked=false;
		}
	}
	return true;
}

				function showclasss(name, val, onCh) {
';
			if(isset($this->args["cssClasses"]) && $this->args["cssClasses"]){
				$js .= '					var classCSV = "'.$this->args["cssClasses"].'";
					classNames = classCSV.split(/,/);';
			}else{
				$js .= '					classNames = top.opener.we_classNames;';
			}
				$js .= '
					document.writeln(\'<select class="defaul	qqtfont" style="width:200px" name="\'+name+\'" id="\'+name+\'" size="1"\'+(onCh ? \' onChange="\'+onCh+\'"\' : \'\')+\'>\');
					document.writeln(\'<option value="">'.$GLOBALS["l_wysiwyg"]["none"].'\');

					for (var i = 0; i < classNames.length; i++) {
						var foo = classNames[i].substring(0,1) == "." ?
							classNames[i].substring(1,classNames[i].length) :
							classNames[i];
						document.writeln(\'<option value="\'+foo+\'"\'+((val==foo) ? \' selected\' : \'\')+\'>.\'+foo);
					}
					document.writeln(\'</select>\');
				}

var ratioh = '.(($this->args["width"] && $this->args["height"]) ? ($this->args["width"]/$this->args["height"]) : "0").';
var ratiow = '.(($this->args["width"] && $this->args["height"]) ? ($this->args["height"]/$this->args["width"]) : "0").';

function fsubmit(e) {
	return false;
}
	</script>
';
		$js .= $yuiSuggest->getYuiJsFiles();
		$js .= $yuiSuggest->getYuiCssFiles();
		return $js;
	}

##################################################################################################

}