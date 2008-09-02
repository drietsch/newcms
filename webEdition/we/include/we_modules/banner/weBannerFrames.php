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
include_once(WE_BANNER_MODULE_DIR."weModuleFrames.php");
include_once(WE_BANNER_MODULE_DIR."weBannerView.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/we_tabs.inc.php");

class weBannerFrames extends weModuleFrames{

	var $edit_cmd="edit_banner";

	function weBannerFrames(){
		$this->weModuleFrames("banner/edit_banner_frameset.php");
		$this->View=new weBannerView();
	}

	function getHTMLFrameset(){
		$this->getJSTreeCode();
		$this->getJSCmdCode();
 ?>
 </head>
   <frameset rows="32,*,<?php print ($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0; ?>" framespacing="0" border="0" frameborder="NO" onLoad="start();">
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/banner/"; ?>edit_banner_header.php" name="header" scrolling="NO" noresize>
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/" . $this->frameset; ?>?pnt=resize" name="resize" scrolling="NO" noresize>
   <frame src="<?php print WEBEDITION_DIR."we/include/we_modules/" . $this->frameset; ?>?pnt=cmd" name="cmd" scrolling="NO" noresize>
  </frameset>

 <body>
 </body>
</html>
<?php

	}

	function getJSTreeCode(){
		$db_tmp=new DB_WE();
		$db_tmp1=new DB_WE();
		$out=weModuleFrames::getJSTreeCode();

		$out.='
		 <script language="JavaScript">
		function loadData(){
			menuDaten.clear();';

		$startloc=0;

		$out.="startloc=".$startloc.";\n";

		$this->db->query("	SELECT ID,ParentID,Path,Text,Icon,IsFolder,abs(text) as Nr, (text REGEXP '^[0-9]') as isNr
							FROM ".BANNER_TABLE."
							ORDER BY isNr DESC,Nr,Text");
		while($this->db->next_record()){
			$ID = $this->db->f("ID");
			$ParentID = $this->db->f("ParentID");
			$Path = $this->db->f("Path");
			$Text = addslashes($this->db->f("Text"));
			$Icon = $this->db->f("Icon");
			$IsFolder = $this->db->f("IsFolder");

			if($IsFolder){
				$out.="  menuDaten.add(new dirEntry('".$Icon."','".$ID."','".$ParentID."','".$Text."',0,'folder','".BANNER_TABLE."',1));\n";
			}else{
				$out.="  menuDaten.add(new urlEntry('".$Icon."','".$ID."','".$ParentID."','".$Text."','file','".BANNER_TABLE."',1));\n";
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
			return '<body bgcolor="#F0EFF0" background="/webEdition/images/backgrounds/bgGrayLineTop.gif"></body></html>';
		}
		global $l_users,$l_banner;
		$isFolder=0;
		if(isset($_GET["isFolder"])) $isFolder=$_GET["isFolder"];

		$page=0;
		if(isset($_GET["page"])) $page=$_GET["page"];


		$headline1 = ($isFolder==1) ? $l_banner["group"] : $l_banner["banner"];
		$text="".($isFolder==1) ? $l_banner["newbannergroup"] : $l_banner["newbanner"];
		if(isset($_GET["txt"])) $text=$_GET["txt"];


		$we_tabs = new we_tabs();

		if($isFolder==0){

			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["properties"],($page==0?"TAB_ACTIVE":"TAB_NORMAL"),"setTab(0);"));
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["placement"],($page==1?"TAB_ACTIVE":"TAB_NORMAL"),"setTab(1);"));
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["statistics"],($page==2?"TAB_ACTIVE":"TAB_NORMAL"),"setTab(2);"));
		} else {

			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["properties"],"TAB_ACTIVE","setTab(0);"));
		}

		$we_tabs->onResize('header');
		$tab_head = $we_tabs->getHeader();

		$tab_body = $we_tabs->getJS();

		$out=
			$tab_head .
		'
   <script language="JavaScript">
	<!--
	function setTab(tab){
		switch(tab){
			case ' . BANNER_PAGE_PROPERTY . ':
			case ' . BANNER_PAGE_PLACEMENT . ':
			case ' . BANNER_PAGE_STATISTICS . ':
				top.content.resize.right.editor.edbody.we_cmd("switchPage",tab);
				break;
		}
	}
   top.content.hloaded=1;
//-->
   </script>
	<body bgcolor="white" background="'.IMAGE_DIR.'backgrounds/header_with_black_line.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onload="setFrameSize()" onresize="setFrameSize()">
		<div id="main" >' . getPixel(100,3).'<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",$headline1).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$text).'</b></span></nobr></div>'.getPixel(100,3).
$we_tabs->getHTML() .
'		</div>
	</body>';

		return $out;

	}

	function getHTMLEditorBody(){
		return $this->View->getProperties();
	}

	function getHTMLEditorFooter($mode=0){
		if(isset($_REQUEST["home"])){
			return '<body bgcolor="#F0EFF0"></body></html>';
		}
		$this->View->getJSFooterCode();
		$we_button = new we_button();
?>
		<script language="JavaScript">
			function sprintf(){
				if (!arguments || arguments.length < 1) return;

				var argum = arguments[0];
				var regex = /([^%]*)%(%|d|s)(.*)/;
				var arr = new Array();
				var iterator = 0;
				var matches = 0;

				while (arr=regex.exec(argum)){
                var left = arr[1];
                var type = arr[2];
                var right = arr[3];

                matches++;
                iterator++;

                var replace = arguments[iterator];

                if (type=='d') replace = parseInt(param) ? parseInt(param) : 0;
                else if (type=='s') replace = arguments[iterator];
                        argum = left + replace + right;
				}
				return argum;
			}

			function we_save() {
				var acLoopCount=0;
				var acIsRunning = false;
				if(!!top.content.resize.right.editor.edbody.YAHOO && !!top.content.resize.right.editor.edbody.YAHOO.autocoml){
					while(acLoopCount<20 && top.content.resize.right.editor.edbody.YAHOO.autocoml.isRunnigProcess()){
						acLoopCount++;
						acIsRunning = true;
						setTimeout('we_save()',100);
					}
					if(!acIsRunning) {
						if(top.content.resize.right.editor.edbody.YAHOO.autocoml.isValid()) {
							_we_save();
						} else {
							<?php echo we_message_reporting::getShowMessageCall($GLOBALS['l_alert']['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR); ?>
						}
					}				
				} else {
					_we_save();
				}
			}
			
			function _we_save() {
				top.content.we_cmd('save_banner');
			}
		</script>
	</head>
	<body bgcolor="white" background="/webEdition/images/edit/editfooterback.gif" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
    <form name="we_form">
	<table border="0" cellpadding="0" cellspacing="0" width="3000">
			<tr>
				<td valign="top" colspan="2"><?php print getPixel(1600,10) ?></td>
			</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0">
						<tr valign="middle">
							<td nowrap><?php print getPixel(15,5); ?></td>
							<td><?php print $we_button->create_button("save", "javascript:we_save();"); ?></td>
						</tr>
	</table>
    </form>
	</body>
</html>
<?php
	}

	function getHTMLCmd(){
	$this->View->getJSCmd();
?>
	</head>
	<body>
    <form name="we_form">
    <?php print $this->View->htmlHidden("ncmd","");?>
    <?php print $this->View->htmlHidden("nopt","");?>
    </form>
    </body>
    </html>
 <?php
	}

	function getHTMLDCheck(){
		print '<script>self.focus();</script>
		</head>
		<body>';
		print $this->View->getHTMLDCheck();
		print '
		</body>
		</html>';

	}


}

?>
