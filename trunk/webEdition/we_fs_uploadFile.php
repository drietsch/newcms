<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/metadata.inc.php");

protect();

htmlTop($l_newFile["import_File_from_hd_title"]);
$parts = array();

print STYLESHEET;

$we_ContentType = isset($_REQUEST["ct"]) ? $_REQUEST["ct"] : "image/*";

$allowedContentTypes = "";

switch ($we_ContentType) {
	case "image/*";
		$allowedContentTypes = IMAGE_CONTENT_TYPES;
		break;
	case "application/*";
		break;
	default:
		$allowedContentTypes = $we_ContentType;
}

$we_alerttext = "";
$we_button = new we_button();

if (isset($_FILES['we_uploadedFile'])){
	$ct = getContentTypeFromFile($_FILES['we_uploadedFile']["name"]);
	if(!we_hasPerm($GLOBALS["WE_CONTENT_TYPES"][$ct]["Permission"])){
		$we_alerttext=$l_alert["upload_notallowed"];
	}
}

if ((!$we_alerttext) && isset($_FILES['we_uploadedFile']) && $_FILES['we_uploadedFile']["type"] && (($allowedContentTypes == "") || (!(strpos($allowedContentTypes,$_FILES['we_uploadedFile']["type"]) === false)))) {
	if (!$we_ContentType) {
		$we_ContentType = getContentTypeFromFile($_FILES['we_uploadedFile']["name"]);
	}
	// initializing $we_doc
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_init_doc.inc.php");
	$pid = $_REQUEST["pid"];
	$overwrite = $_REQUEST["overwrite"];

	// creating a temp name and copy the file to the we tmp directory with the new temp name
	$tempName = TMP_DIR."/".md5(uniqid(rand(),1));
	move_uploaded_file($_FILES['we_uploadedFile']["tmp_name"],$tempName);

	$tmp_Filename = preg_replace("/[^A-Za-z0-9._-]/", "", $_FILES["we_uploadedFile"]["name"]);

	$we_doc->Filename = eregi_replace('^(.+)\..+$',"\\1",$tmp_Filename);

	$we_doc->Extension = (strpos($tmp_Filename,".") > 0) ? eregi_replace('^.+(\..+)$',"\\1",$tmp_Filename) : "";

	$we_doc->Text = $we_doc->Filename.$we_doc->Extension;
    $we_doc->setParentID($pid);
    $we_doc->Path=$we_doc->getParentPath().(($we_doc->getParentPath() != "/") ? "/" : "").$we_doc->Text;

    // if file exists we have to see if we should create a new one or overwrite it!
    if($file_id = f("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$we_doc->Path."'","ID",$DB_WE)){
		if($overwrite=="yes"){
			eval('$we_doc=new '.$we_doc->ClassName.'();');
			$we_doc->initByID($file_id,FILE_TABLE);
		}else{
			$z=0;
			$footext = $we_doc->Filename."_".$z.$we_doc->Extension;
			while(f("SELECT ID FROM ".FILE_TABLE." WHERE Text='$footext' AND ParentID='$pid'","ID",$DB_WE)){
				$z++;
				$footext = $we_doc->Filename."_".$z.$we_doc->Extension;
			}
			$we_doc->Text = $footext;
			$we_doc->Filename = $we_doc->Filename."_".$z;
			$we_doc->Path=$we_doc->getParentPath().(($we_doc->getParentPath() != "/") ? "/" : "").$we_doc->Text;
		}

	}


	$we_doc->setElement("type",$ct,"attrib");

	$foo = explode("/",$_FILES["we_uploadedFile"]["type"]);
	$we_doc->setElement("data",$tempName,$foo[0]);

	if ($we_ContentType == "image/*") {
		$we_size = $we_doc->getimagesize($tempName);
		$we_doc->setElement("width",$we_size[0],"attrib");
		$we_doc->setElement("height",$we_size[1],"attrib");
		$we_doc->setElement("origwidth",$we_size[0]);
		$we_doc->setElement("origheight",$we_size[1]);
		if(isset($_REQUEST["import_metadata"]) && !empty($_REQUEST["import_metadata"])) {
			$we_doc->importMetaData();
		}
	}

	$we_doc->setElement("filesize",$_FILES['we_uploadedFile']["size"],"attrib");
	if(isset($_REQUEST["img_title"])){
		$we_doc->setElement("title",$_REQUEST["img_title"]);
	}
	if(isset($_REQUEST["img_alt"])){
		$we_doc->setElement("alt",$_REQUEST["img_alt"],"attrib");
	}
	if(isset($_REQUEST["Thumbnails"])){
		if(is_array($_REQUEST["Thumbnails"])){
			$we_doc->Thumbs = makeCSVFromArray($_REQUEST["Thumbnails"],true);
		}else{
			$we_doc->Thumbs = $_REQUEST["Thumbnails"];
		}
	}
	$we_doc->Table=$_REQUEST["tab"];
	$we_doc->Published=time();
	$we_doc->we_save();
	$id=$we_doc->ID;

} else if(isset($_FILES['we_uploadedFile'])){
	if (we_filenameNotValid($_FILES['we_uploadedFile']['name'])) {
		$we_alerttext=$l_alert["we_filename_notValid"];
	} else {
		$we_alerttext=$l_alert["wrong_file"][$we_ContentType];
	}
}

// find out the smallest possible upload size

$maxsize = getUploadMaxFilesize(false);


$yes_button = $we_button->create_button("upload", "javascript:document.forms[0].submit();");
$cancel_button = $we_button->create_button("cancel", "javascript:self.close();");
$buttons = we_button::position_yes_no_cancel($yes_button, null, $cancel_button);

if($maxsize){
	array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox(
				sprintf($GLOBALS["l_newFile"]["max_possible_size"],round($maxsize / (1024*1024),3)."MB"),
				1,390),"space"=>0,"noline"=>1));

}

array_push($parts,array("headline"=>"","html"=>'<input name="we_uploadedFile" TYPE="file"'.($allowedContentTypes ? ' ACCEPT="'.$allowedContentTypes.'"' : '').' size="35">',"space"=>0));
array_push($parts,array("headline"=>"","html"=>$GLOBALS["l_newFile"]["caseFileExists"].'<br>'.we_forms::radiobutton("yes", true, "overwrite", $GLOBALS["l_newFile"]["overwriteFile"]).
we_forms::radiobutton("no", false, "overwrite", $GLOBALS["l_newFile"]["renameFile"]),"space"=>0));

if($we_ContentType == "image/*"){
	$_thumbnails = new we_htmlSelect(array("multiple" => "multiple", "name" => "Thumbnails[]", "id" => "Thumbnails", "class" => "defaultfont", "size" => "6", "style" => "width: 330px;"));
	$DB_WE->query("SELECT ID,Name FROM " . THUMBNAILS_TABLE . " ORDER BY Name");



	$selectedID=0;
	$_enabled_buttons = false;
	while($DB_WE->next_record()) {
		$_enabled_buttons = true;
		$_thumbnail_counter = $DB_WE->f("ID");

		$_thumbnails->addOption($DB_WE->f("ID"), $DB_WE->f("Name"));

	}

	array_push($parts,array("headline"=>"","html"=>we_forms::checkbox("1", true, "import_metadata", $l_metadata["import_metadata_at_upload"]),"space"=>0));
	array_push($parts,array("headline"=>"","html"=>$GLOBALS["l_thumbnails"]["create_thumbnails"]."<br>".$_thumbnails->getHtmlCode(),"space"=>0));
	array_push($parts,array("headline"=>"","html"=>$GLOBALS["l_global"]["title"]."<br>".htmlTextInput("img_title",24,"","","","text",330),"space"=>0));
	array_push($parts,array("headline"=>"","html"=>$GLOBALS["l_we_class"]["alt"]."<br>".htmlTextInput("img_alt",24,"","","","text",330),"space"=>0));
}




?>
<script language="JavaScript" type="text/javascript"><!--
<?php if($we_alerttext):
	print we_message_reporting::getShowMessageCall($we_alerttext, WE_MESSAGE_ERROR);
endif ?>

<?php if(isset($_FILES['we_uploadedFile']) && (!$we_alerttext)): ?>
<?php if($we_doc->ID):?>
	var ref;
	if(opener.top.opener && opener.top.opener.top.makeNewEntry) ref = opener.top.opener.top;
	else if(opener.top.opener && opener.top.opener.top.opener && opener.top.opener.top.opener.top.makeNewEntry) ref = opener.top.opener.top.opener.top;
	else if(opener.top.opener && opener.top.opener.top.opener && opener.top.opener.top.opener.top.opener && opener.top.opener.top.opener.top.opener.top.makeNewEntry) ref = opener.top.opener.top.opener.top.opener.top;


	if (ref.makeNewEntry) {
		ref.makeNewEntry("<?php print $we_doc->Icon?>","<?php print $we_doc->ID?>","<?php print $we_doc->ParentID?>","<?php print $we_doc->Text?>",1,"<?php print $we_doc->ContentType?>","<?php print $we_doc->Table?>");
	}
	opener.top.reloadDir();
	opener.top.unselectAllFiles();
	opener.top.addEntry("<?php print $we_doc->ID?>","<?php print $we_doc->Icon?>","<?php print $we_doc->Text?>","<?php print $we_doc->IsFolder?>","<?php print $we_doc->Path?>");
	opener.top.doClick(<?php print  $we_doc->ID; ?>,0);
	setTimeout('opener.top.selectFile(<?php print  $we_doc->ID; ?>)',200);
<?php endif?>
	setTimeout('self.close()',250);
<?php endif ?>
//-->
</script>
</head>
<body class="weDialogBody" onload="self.focus();" ><center>
<form method="post" enctype="multipart/form-data">
   <input type="hidden" name="table" value="<?php print $_REQUEST["tab"]; ?>">
   <input type="hidden" name="pid" value="<?php print $_REQUEST["dir"]; ?>">
   <input type="hidden" name="ct" value="<?php print $we_ContentType; ?>">
	<?php print we_multiIconBox::getHTML("","100%",$parts,30,$buttons,-1,"","",false,$l_newFile["import_File_from_hd_title"], "", 560); ?>
</form></center>
</body>
</html>
