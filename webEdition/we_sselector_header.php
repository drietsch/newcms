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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");

protect();

htmlTop();

print STYLESHEET;

$we_button = new we_button();
?>

<script language="JavaScript" type="text/javascript" src="<?php print WEBEDITION_DIR; ?>js/windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
  var name_ord=0;
  var type_ord=0;
  var date_ord=0;
  var size_ord=0;

  function addOption(txt,id){
      var a=document.forms["we_form"].elements["lookin"];
      a.options[a.options.length]=new Option(txt,id);
      if(a.options.length>0) a.selectedIndex=a.options.length-1;
      else a.selectedIndex=0;

  }

  function openFile(){
      url="we_sselector_uploadFile.php?pat="+top.currentDir;
      new jsWindow(url,"we_fsuploadImage",-1,-1,450,240,true,false,true);
  }

  function reorder(name){
      var order=0;
      if(name=="name") if(name_ord==1) {order=10;name_ord=0;} else {order=11;name_ord=1;}
      if(name=="type") if(type_ord==1) {order=20;type_ord=0;} else {order=21;type_ord=1;}
      if(name=="date") if(date_ord==1) {order=30;date_ord=0;} else {order=31;date_ord=1;}
	  if(name=="size") if(size_ord==1) {order=40;size_ord=0;} else {order=41;size_ord=1;}

      top.fscmd.reorderDir(top.currentDir,order);
  }

  function setLookin(){
		var dirs=new Array();
		var foo=new Array();
		var a=document.forms["we_form"].elements["lookin"];
		var c=0;

		a.options.length=0;
		foo=top.currentDir.split("/");
		for(j=0;j<foo.length;j++){
			if(foo[j]!=""){
				dirs[c]=foo[j];
				c++;
			}
		}
		foo=top.rootDir.split("/");
		root = "/";
		for(j=0;j<foo.length;j++){
			if(foo[j]!=""){
				root = foo[j];
			}
		}

		addOption(root,"/");
		for(i=0;i<dirs.length;i++){
				if(a.options[i].value=="/")
					addOption(dirs[i],a.options[i].value+dirs[i]);
				else
					addOption(dirs[i],a.options[i].value+"/"+dirs[i]);
		}

  }


//-->
</script>
</head>
 <body background="<?php print IMAGE_DIR ?>backgrounds/radient.gif" bgcolor="#bfbfbf"  LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" onLoad="setLookin();self.focus()">
	 <form name="we_form" method="post">
 		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr valign="middle">
				<td width="10"><?php print getPixel(10,49); ?></td>
				<td width="70" class="defaultfont"><b><?php print $l_fileselector["lookin"]?></b></td>
				<td width="10"><?php print getPixel(10,29); ?></td>
				<td><select name="lookin" size="1" onchange="top.fscmd.setDir(lookin.options[lookin.selectedIndex].value);" class="defaultfont" style="width:100%">
						<option value="/">/</option>
					</select><?php print getPixel(1,1); ?></td>
 				<td width="10"><?php print getPixel(10,29); ?></td>
				<td width="40">
					<?php print $we_button->create_button("root_dir", "javascript:top.fscmd.setDir('/');"); ?>
				</td>
				<td width="10"><?php print getPixel(10,29); ?></td>
				<td width="40">
					<?php print $we_button->create_button("image:btn_fs_back", "javascript:top.fscmd.goUp();"); ?>
				</td>
<?php if(!$_REQUEST["ret"]){ ?>
				<td width="10"><?php print getPixel(10,29); ?></td>
				<td width="40">
					<?php print $we_button->create_button("image:btn_new_dir", "javascript:top.fscmd.drawNewFolder();",true,100,22,"","",false,false,"_ss"); ?>
				</td>
 				<td width="10"><?php print getPixel(10,29); ?></td>
                <td width="40">
                   <?php print $we_button->create_button("image:btn_add_file", "javascript:javascript:openFile();",true,100,22,"","",false,false,"_ss"); ?>
                </td>
				<td width="10"><?php print getPixel(10,29); ?></td>
                <td width="25">
                   <?php print $we_button->create_button("image:btn_function_trash", "javascript:top.fscmd.delFile();",true,100,22,"","",false,false,"_ss"); ?>
                </td>
<?php  }   ?>
 				<td width="10"><?php print getPixel(10,29); ?></td>
			</tr>
		</table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td><img src="<?php print IMAGE_DIR?>umr_h_small.gif" width="100%" height="2" border="0"></td>
         </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td><?php print getPixel(25,20)?></td>
            <td class="selector"><b><a href="#" onclick="reorder('name');"><?php print $l_fileselector["filename"]?></a></b></td>
            <td class="selector"><b><a href="#" onclick="reorder('type');"><?php print $l_fileselector["type"]?></b></a></td>
            <td class="selector"><b><a href="#" onclick="reorder('date');"><?php print $l_fileselector["modified"]?></b></a></td>
            <td class="selector"><b><a href="#" onclick="reorder('size');"><?php print $l_fileselector["filesize"]?></b></a></td>
         </tr>
         <tr>
            <td width="25"><?php print getPixel(25,1)?></td>
            <td width="200"><?php print getPixel(200,1)?></td>
            <td width="150"><?php print getPixel(150,1)?></td>
            <td width="200"><?php print getPixel(200,1)?></td>
            <td><?php print getPixel(15,1)?></td>
         </tr>
        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td><img src="<?php print IMAGE_DIR?>umr_h_small.gif" width="100%" height="2" border="0"></td>
         </tr>
        </table>

      </form>
      </body>

</html>
