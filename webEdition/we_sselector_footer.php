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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");

htmlTop();

print STYLESHEET;

$we_button = new we_button();
?>
<script language="JavaScript" type="text/javascript" src="<?php print WEBEDITION_DIR; ?>js/windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
   function addOption(txt,id){
      var a=document.forms["we_form"].elements["filter"];
      a.options[a.options.length]=new Option(txt,id);
      a.selectedIndex=0;

  }
  function editFile(){
     if(!top.dirsel){
      if((top.currentID!="")&&(document.forms["we_form"].elements["fname"].value!="")){
       if(document.forms["we_form"].elements["fname"].value!=top.currentName) top.currentID=top.sitepath+top.rootDir+top.currentDir+"/"+document.forms["we_form"].elements["fname"].value;
       url="we_sselector_editFile.php?id="+top.currentID;
       new jsWindow(url,"we_fseditFile",-1,-1,600,500,true,false,true);
      }
      else {
      	<?php print we_message_reporting::getShowMessageCall( $l_fileselector["edit_file_nok"], WE_MESSAGE_ERROR); ?>
     	}
     }
     else{
     	<?php print we_message_reporting::getShowMessageCall( $l_fileselector["edit_file_is_folder"], WE_MESSAGE_ERROR ); ?>
     }
  }

  function doUnload(){
      if(jsWindow_count) {
            for(i=0;i<jsWindow_count;i++){
        	   eval("jsWindow"+i+"Object.close()");
        	}
        }
  }
//-->
</script>
</head>
<body background="<?php print IMAGE_DIR ?>backgrounds/radient.gif" bgcolor="#bfbfbf" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" onUnload="doUnload();">
     <form name="we_form" target="fscmd">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="5"><img src="<?php print IMAGE_DIR ?>umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
				<tr>
					<td colspan="5"><?php print getPixel(5,5); ?></td>
				</tr>
<?php

if($_REQUEST["ret"]==1){
		$cancel_button = $we_button->create_button("cancel", "javascript:top.close();");
		$yes_button = $we_button->create_button("ok", "javascript:top.exit_close();");
}else{
		$cancel_button = $we_button->create_button("close", "javascript:top.exit_close();");
		$yes_button = $we_button->create_button("edit", "javascript:editFile();");
}
		$buttons = $we_button->position_yes_no_cancel(
												$yes_button,
												null,
												$cancel_button);
?>
<?php if($_REQUEST["filter"] == "all_Types"){ ?>
				<tr>
					<td></td>
					<td class="defaultfont">
						<b><?php print $GLOBALS["l_fileselector"]["type"]; ?></b></td>
					<td></td>
					<td class="defaultfont">
						<select name="filter" class="weSelect" size="1" onchange="top.fscmd.setFilter(document.forms['we_form'].elements['filter'].options[document.forms['we_form'].elements['filter'].selectedIndex].value)" style="width:100%">
                      <option value="<?php print ereg_replace(" ","%20",$l_contentTypes["all_Types"]); ?>"><?php print $l_contentTypes["all_Types"]; ?></option>
                      <?php
                        foreach($GLOBALS["WE_CONTENT_TYPES"] as $key=>$value){
                        	if($value["IsRealFile"]){
								print '<option value="'.rawurlencode($l_contentTypes[$key]).'">'.$l_contentTypes[$key].'</option>'."\n";
                        	}
                        }
             ?>
 					</select></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5"><?php print getPixel(5,5); ?></td>
				</tr>
<?php } ?>
				<tr>
					<td></td>
					<td class="defaultfont">
						<b><?php if($_REQUEST["filter"] == "folder"){print $l_fileselector["name"];}else{print $l_fileselector["name"];} ?></b>
					</td>
					<td></td>
					<td class="defaultfont" align="left"><?php print htmlTextInput("fname",24,$_REQUEST["currentName"],"","style=\"width:100%\" readonly=\"readonly\""); ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td width="10"><?php print getPixel(10,5); ?></td>
					<td width="70"><?php print getPixel(70,5); ?></td>
					<td width="10"><?php print getPixel(10,5); ?></td>
					<td><?php print getPixel(5,5); ?></td>
					<td width="10"><?php print getPixel(10,5); ?></td>
				</tr>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right"><?php print $buttons; ?></td>
					<td width="10"><?php print getPixel(10,5); ?></td>
				</tr>
			</table>
      </form>
	</body>

</html>
