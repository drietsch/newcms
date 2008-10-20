<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once(WE_WORKFLOW_MODULE_DIR."weModuleFrames.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowView.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

class weWorkflowFrames extends weModuleFrames{

	function weWorkflowFrames(){
		weModuleFrames::weModuleFrames();
		$this->View=new weWorkflowView();
	}

	function getHTMLFrameset(){
		$this->getJSTreeCode();
		$this->getJSCmdCode();
 ?>
 </head>
   <frameset rows="32,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="NO" onLoad="start();">
   <frame src="<?php print WE_WORKFLOW_MODULE_PATH; ?>edit_workflow_header.php" name="header" scrolling=no noresize>
   <frame src="<?php print WE_WORKFLOW_MODULE_PATH; ?>edit_workflow_frameset.php?pnt=resize" name="resize" scrolling=no>
   <frame src="<?php print WE_WORKFLOW_MODULE_PATH; ?>edit_workflow_frameset.php?pnt=cmd" name="cmd" scrolling=no noresize>
  </frameset>

 <body background="<?php print IMAGE_DIR ?>backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html>
<?php

	}

	function getJSTreeCode(){
		$db_tmp=new DB_WE();
		$db_tmp1=new DB_WE();
		$out=weModuleFrames::getJSTreeCode();

		$out.='
		 <script language="JavaScript" type="text/javascript">
		function loadData(){
			menuDaten.clear();';

		$startloc=0;

		$out.="startloc=".$startloc.";\n";
		$this->db->query("SELECT * FROM ".WORKFLOW_TABLE." ORDER BY Text ASC");
		while($this->db->next_record()){
			$this->View->workflowDef=new weWorkflow();
			$this->View->workflowDef->load($this->db->f("ID"));
			$out.="  menuDaten.add(new dirEntry('folder','".$this->View->workflowDef->ID."','0','".htmlspecialchars(addslashes($this->View->workflowDef->Text))."',false,'folder','workflowDef','".$this->View->workflowDef->Status."'));\n";

			foreach($this->View->workflowDef->documents as $k=>$v){
				$out.="  menuDaten.add(new urlEntry('".$v["Icon"]."','".$v["ID"]."','".$this->View->workflowDef->ID."','".htmlspecialchars(addslashes($v["Text"]))."','file','".FILE_TABLE."',1));\n";
			}
		}

		$out.='}
			</script>';
		print $out;

	}

	function getJSCmdCode(){
		print $this->View->getJSTopCode();
	}

	function getHTMLEditorHeader($mode=0){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

		if(isset($_REQUEST["home"])){
			return '<body bgcolor="#FFFFFF" background="/webEdition/images/backgrounds/bgGrayLineTop.gif"></body></html>';
		}
		global $l_users,$l_workflow;

		if(isset($_GET["art"])){
		    $mode = $_GET["art"];
		}

		$page=0;
		if(isset($_GET["page"])){
		    $page = $_GET["page"];
		}

		$text = $l_workflow["new_workflow"];
		if(isset($_GET["txt"])){
		    $text = $_GET["txt"];
		}

		$we_tabs = new we_tabs();

		if($mode==0){

			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["properties"], "TAB_NORMAL", "setTab(0);", array("id"=>"tab_0")));
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["overview"], "TAB_NORMAL", "setTab(1);", array("id"=>"tab_1")));

		} else {
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["editor"]["information"], "TAB_ACTIVE", "//", array("id"=>"tab_0")));
		}

		$we_tabs->onResize();
		$tab_header = $we_tabs->getHeader('', 22);
		$tab_body = $we_tabs->getJS();
		if (empty($page)) $page=0;
		 $textPre= ($mode==1 ? $l_workflow["document"] : $l_workflow["workflow"]);
		 $textPost = "/".$text;

		$out='
   <script language="JavaScript" type="text/javascript">
	<!--
    function setTab(tab){
        	switch(tab){
			case 0:
				top.content.resize.right.editor.edbody.we_cmd("switchPage",0);
			break;
			case 1:
				top.content.resize.right.editor.edbody.we_cmd("switchPage",1);
			break;
		}
	}

   top.content.hloaded=1;
	//-->
   </script>
   ' . $tab_header . '
   </head>
   <body bgcolor="white" background="'.IMAGE_DIR.'backgrounds/header_with_black_line.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onload="setFrameSize()", onresize="setFrameSize()">
		<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.htmlspecialchars(str_replace(" ","&nbsp;",$textPre)).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.htmlspecialchars(str_replace(" ","&nbsp;",$textPost)).'</b></span></nobr></div>' . getPixel(100,3) .
			$we_tabs->getHTML() .
			'</div>' . we_htmlElement::jsElement('document.getElementById("tab_'.$page.'").className="tabActive";') . '
	</body>';


		return $out;

	}

	function getHTMLEditorBody(){
		return $this->View->getProperties();
	}

	function getHTMLEditorFooter($mode=0){
		if(isset($_REQUEST["home"])){
			return '<body bgcolor="#EFF0EF"></body></html>';
		}

		$we_button = new we_button();
?>

		<script language="JavaScript" type="text/javascript">
			 function setStatusCheck(){
			 	var a=document.we_form._status_workflow;
				var b;
				if(top.content.resize.right.editor.edbody.loaded) b=top.content.resize.right.editor.edbody.getStatusContol();
				else setTimeout("setStatusCheck()",100);

				if(b==1) a.checked=true;
				else a.checked=false;

			}
			function we_save() {
				top.content.we_cmd('save_workflow');
				
			}
	</script>
	</head>
	<body bgcolor="white" background="/webEdition/images/edit/editfooterback.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0"<?php if($mode==0):?> onload="setStatusCheck()"<?php endif?>>
    <form name="we_form">
	<table border="0" cellpadding="0" cellspacing="0" width="3000">
			<tr>
				<td valign="top" colspan="2"><?php print getPixel(1600,10) ?></td>
			</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="300">
	<?php if($mode==0):?>
			<tr>
				<td><?php print getPixel(15,5)?></td>
				<td><?php print $we_button->create_button("save", "javascript:we_save();") ?></td>
				<td class="defaultfont"><?php print $this->View->getStatusHTML();?></td>
			</tr>
	<?php endif?>
	</table>
    </form>
	</body>
</html>
<?php
	}

	function getHTMLLog($docID,$type=0){
		print '<script>self.focus();</script>
		</head>
		<body class="weDialogBody">';
		print $this->View->getLogForDocument($docID,$type);
		print '
		</body>
		</html>';

	}

	function getHTMLCmd(){
	$this->View->getCmdJS();
?>
	</head>
	<body>
    <form name="we_form">
    <?php print $this->View->htmlHidden("wcmd","");?>
    <?php print $this->View->htmlHidden("wopt","");?>
    </form>
    </body>
    </html>
 <?php
	}

	function getHTMLLogQuestion(){
?>
	</head>
	<body class="weDialogBody">
    <form name="we_form">
    <?php print $this->View->getLogQuestion();?>
    </form>
    </body>
    </html>
 <?php
	}

}

?>