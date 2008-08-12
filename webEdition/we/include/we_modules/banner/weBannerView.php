<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/* the parent class of storagable webEdition classes */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once(WE_BANNER_MODULE_DIR."weBanner.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/banner.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/we_listview_banner.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');

class weBannerView extends weBannerBase{

	// settings array; format settings[setting_name]=settings_value
	var $settings=array();

	//default banner
	var $banner;

	//wat page is currentlly displed 0-properties(default);1-stat;
	var $page=0;
	var $UseFilter = 0;
	var $FilterDate = -1;
	var $FilterDateEnd = -1;
	var $Order = "views";

	var $pageFields = array();

   function weBannerView(){
		weBannerBase::weBannerBase();
		$this->banner=new weBanner();
		$this->page=0;
		$this->settings=$this->getSettings();
		$this->pageFields[BANNER_PAGE_PROPERTY] = array("Text","ParentID","bannerID","bannerUrl","bannerIntID","IntHref","IsDefault","IsActive","StartOk","EndOk","StartDate","EndDate");
		$this->pageFields[BANNER_PAGE_PLACEMENT] = array("DoctypeIDs","TagName");
		$this->pageFields[BANNER_PAGE_STATISTICS] = array();
		$yuiSuggest =& weSuggest::getInstance();
	}


	function getHiddens(){
		$out=$this->htmlHidden("home","0");
		$out.=$this->htmlHidden("ncmd","new_banner");
		$out.=$this->htmlHidden("ncmdvalue","");
		$out.=$this->htmlHidden("bid",$this->banner->ID);
		$out.=$this->htmlHidden("pnt",$_REQUEST["pnt"]);
		$out.=$this->htmlHidden("page",$this->page);
		$out.=$this->htmlHidden("bname",$this->uid);
		$out.=$this->htmlHidden("order",$this->Order);
		$out.=$this->htmlHidden($this->uid."_IsFolder",$this->banner->IsFolder);
		foreach($this->banner->persistents as $p){
			if(!in_array($p,$this->pageFields[$this->page])){
				eval('$v=$this->banner->'.$p.';');
				$out.=$this->htmlHidden($this->uid."_$p",$v);
			}
		}
		return $out;
	}

   	function htmlHidden($name,$value="",$id=""){
		return '<input type="hidden" name="'.trim($name).'" value="'.htmlspecialchars($value).'"' .(empty($id)?"":' id="'.$id.'"').'>';
	}

	function getProperties(){
		$yuiSuggest =& weSuggest::getInstance();
		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->getJSProperty();
			$GLOBALS["we_body_insert"] = '<form name="we_form">'."\n";
			$GLOBALS["we_body_insert"] .= $this->getHiddens().'</form>'."\n";
			$GLOBALS["mod"] = "banner";
			ob_start();

			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
		}else{
			include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
			$out =$this->getJSProperty(). $yuiSuggest->getYuiJsFiles().'
				</head>
				<body class="weEditorBody" onload="loaded=1;" onunload="doUnload()">
				<form name="we_form" onsubmit="return false;">'."\n";
			$out.=$this->getHiddens();
			$parts = array();
			$headline ="";
			$znr = -1;
			$openText="";
			$closeText="";
			$wepos = "";
			$itsname="";
			switch($this->page){
				case BANNER_PAGE_PROPERTY:
					$out .= $this->htmlHidden("UseFilter",$this->UseFilter);
					$out .= $this->htmlHidden("FilterDate",$this->FilterDate);
					$out .= $this->htmlHidden("FilterDateEnd",$this->FilterDateEnd);
					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["path"],
								"html"=>$this->formPath(),
								"space"=>120)
							);
					$znr = -1;
					if(!$this->banner->IsFolder){
						array_push($parts,array(
									"headline"=>$GLOBALS["l_banner"]["banner"],
									"html"=>$this->formBanner(),
									"space"=>120)
								);
						array_push($parts,array(
									"headline"=>$GLOBALS["l_banner"]["period"],
									"html"=>$this->formPeriod(),
									"space"=>120)
								);
					$znr = 2;
					}
					if(defined("CUSTOMER_TABLE")){
						array_push($parts,array(
									"headline"=>$GLOBALS["l_banner"]["customers"],
									"html"=>$this->formCustomer(),
									"space"=>120)
								);
					}
					$headline = $GLOBALS["l_tabs"]["module"]["properties"];
					$itsname = "weBannerProp";
					$openText=$GLOBALS["l_we_class"]["moreProps"];
					$closeText=$GLOBALS["l_we_class"]["lessProps"];
					$wepos = weGetCookieVariable("but_weBannerProp");
					break;
				case BANNER_PAGE_PLACEMENT:
					$out .= $this->htmlHidden("UseFilter",$this->UseFilter);
					$out .= $this->htmlHidden("FilterDate",$this->FilterDate);
					$out .= $this->htmlHidden("FilterDateEnd",$this->FilterDateEnd);
					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["tagname"],
								"html"=>$this->formTagName(),
								"space"=>120)
							);

					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["pages"],
								"html"=>$this->formFiles(),
								"space"=>120)
							);

					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["dirs"],
								"html"=>$this->formFolders(),
								"space"=>120)
							);

					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["categories"],
								"html"=>$this->formCategories(),
								"space"=>120)
							);

					array_push($parts,array(
								"headline"=>$GLOBALS["l_banner"]["doctypes"],
								"html"=>$this->formDoctypes(),
								"space"=>120)
							);
					$headline = $GLOBALS["l_tabs"]["module"]["placement"];
					$znr = 3;
					$itsname = "weBannerPlace";
					$openText=$GLOBALS["l_we_class"]["moreProps"];
					$closeText=$GLOBALS["l_we_class"]["lessProps"];
					$wepos = weGetCookieVariable("but_$itsname");
					break;
				case BANNER_PAGE_STATISTICS:
					$headline = $GLOBALS["l_tabs"]["module"]["statistics"];
					array_push($parts,array(
								"headline"=>"",
								"html"=>$this->formStat(),
								"space"=>0)
							);
					break;
			}

			$out.= we_multiIconBox::getJS();
			$out.= we_multiIconBox::getHTML($itsname,"100%",$parts,30,"",$znr,$openText,$closeText,($wepos=="down"));

			$out .= "\n</form>\n";
			$out .= $yuiSuggest->getYuiCss();
			$out .= $yuiSuggest->getYuiJs();
			$out .= '</body></html>';
		}
		return $out;

	}

	function previewBanner(){
		global $l_banner;
		$content = "";
		$ID = $this->banner->bannerID;
		if($ID){
			$ct = f("SELECT ContentType FROM ".FILE_TABLE." WHERE ID='".$ID."'","ContentType",$this->db);
			switch($ct){
				case "image/*";
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_imageDocument.inc.php");
					$img = new we_imageDocument();
					$img->initByID($ID,FILE_TABLE);
					$content = $img->getHTML();
					break;
			}
		}


		return $content;
	}


	function getJSTopCode(){
		global $l_banner;
?>
	<script language="JavaScript">

			var hot = 0;
			
			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			 
			function setHot() {
				hot = "1";
			}
			
			function usetHot() {
				hot = "0";
			}
			
			function we_cmd(){
				var args = "";
				var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				if(hot == "1" && arguments[0] != "save_banner") {
					if(confirm("<?php print $l_banner["save_changed_banner"]?>")) {
						arguments[0] = "save_banner";
					} else {
						top.content.usetHot();
					}
				}
				switch (arguments[0]){
					case "exit_banner":
						if(hot != "1") {
							eval('top.opener.top.we_cmd(\'exit_modules\')');
						}
						break;
					case "new_banner":
						if(top.content.resize.right.editor.edbody.loaded){
							top.content.resize.right.editor.edbody.document.we_form.ncmd.value=arguments[0];
							top.content.resize.right.editor.edbody.submitForm();
						}
						else setTimeout('we_cmd("new_banner");',10);
					break;
					case "new_bannergroup":
						if(top.content.resize.right.editor.edbody.loaded){
							top.content.resize.right.editor.edbody.document.we_form.ncmd.value=arguments[0];
							top.content.resize.right.editor.edbody.submitForm();
						}
						else setTimeout('we_cmd("new_bannergroup");',10);
					break;
					case "delete_banner":
						<?php if(!we_hasPerm("DELETE_BANNER")):
							print we_message_reporting::getShowMessageCall($l_banner["no_perms"], WE_MESSAGE_ERROR);
						else: ?>
						if(top.content.resize.right.editor.edbody.loaded && top.content.resize.right.editor.edbody.we_is_home==undefined){
							if(!confirm("<?php print $l_banner["delete_question"]?>")) return;
						}
						else {
							<?php print we_message_reporting::getShowMessageCall($l_banner["nothing_to_delete"], WE_MESSAGE_WARNING); ?>
							return;
						}
						top.content.resize.right.editor.edbody.document.we_form.ncmd.value=arguments[0];
						top.content.resize.right.editor.edbody.submitForm();
						<?php endif?>
						break;
					case "save_banner":
						<?php if(we_hasPerm("EDIT_BANNER") || we_hasPerm("NEW_BANNER")):?>
						if(top.content.resize.right.editor.edbody.loaded && top.content.resize.right.editor.edbody.we_is_home==undefined){
							if(!top.content.resize.right.editor.edbody.checkData()){
								return;
							}
						}else{
							<?php print we_message_reporting::getShowMessageCall($l_banner["nothing_to_save"], WE_MESSAGE_WARNING); ?>
							return;
						}

						top.content.resize.right.editor.edbody.document.we_form.ncmd.value=arguments[0];
						top.content.resize.right.editor.edbody.submitForm();
						<?php endif?>
						top.content.usetHot();
						break;
					case "edit_banner":
						top.content.resize.right.editor.edbody.document.we_form.ncmd.value=arguments[0];
						top.content.resize.right.editor.edbody.document.we_form.bid.value=arguments[1];
						top.content.resize.right.editor.edbody.submitForm();
						break;
        			default:
        				for(var i = 0; i < arguments.length; i++) {
							args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
						}
						eval('top.opener.top.we_cmd('+args+')');
				}
			}
	</script>
	<?php
	}

	function getJSFooterCode(){
	global $l_banner;
	?>
	<script language="JavaScript">

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}

			function we_cmd(){
				var args = "";
				var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]){
					case "empty_log":
					break;
        			default:
        					for(var i = 0; i < arguments.length; i++){
							args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
					}
					eval('parent.edbody.we_cmd('+args+')');
				}
			}
	</script>
	<?php
	}

	function getJSCmd(){
	?>
		<script language="JavaScript">
				function submitForm(){
					var f = self.document.we_form;
					f.target = "cmd";
					f.method = "post";
					f.submit();
			}
		</script>
	<?php
	}

	function getJSProperty(){
		global $l_banner;
	?>
		<script language="JavaScript" src="<?php print JS_DIR; ?>windows.js"></script>
		<script language="JavaScript">
			var loaded;

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}

			function we_cmd(){
				var args = "";
				var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]){
					case "openSelector":
						new jsWindow(url,"we_selector",-1,-1,<?php echo WINDOW_SELECTOR_WIDTH . "," . WINDOW_SELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openCatselector":
						new jsWindow(url,"we_catselector",-1,-1,<?php echo WINDOW_CATSELECTOR_WIDTH . "," . WINDOW_CATSELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openDocselector":
						new jsWindow(url,"we_docselector",-1,-1,<?php echo WINDOW_DOCSELECTOR_WIDTH . "," . WINDOW_DOCSELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openDirselector":
						new jsWindow(url,"we_dirselector",-1,-1,<?php echo WINDOW_DIRSELECTOR_WIDTH . "," . WINDOW_DIRSELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openBannerDirselector":
						new jsWindow(url,"we_bannerselector",-1,-1,600,350,true,true,true);
						break;
					case "switchPage":
						document.we_form.ncmd.value=arguments[0];
						document.we_form.page.value=arguments[1];
						submitForm();
						break;
					case "add_cat":
					case "del_cat":
					case "del_all_cats":
					case "add_file":
					case "del_file":
					case "del_all_files":
					case "add_folder":
					case "del_folder":
					case "del_customer":
					case "del_all_customers":
					case "del_all_folders":
					case "add_customer":
						document.we_form.ncmd.value=arguments[0];
						document.we_form.ncmdvalue.value=arguments[1];
						submitForm();
						break;
					case "delete_stat":
						if(confirm("<?php print $l_banner["deleteStatConfirm"]; ?>")){
							document.we_form.ncmd.value=arguments[0];
							submitForm();
						}
						break;
               default:
					for(var i = 0; i < arguments.length; i++){
						args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
					}
					eval('top.content.we_cmd('+args+')');
				}
			}

			function submitForm(){
					var f = self.document.we_form;
					if(arguments[0]) f.target = arguments[0];
					else f.target = "edbody";
					if(arguments[1]) f.action = arguments[1];
					else f.action = "";
					if(arguments[2]) f.method = arguments[2];
					else f.method = "post";

               f.submit();
			}
			function checkData(){

            return true;
			}

			self.focus();
		</script>
	<?php
	}

	function processCommands(){
		global $l_banner;
		if(isset($_REQUEST["ncmd"]))
		switch($_REQUEST["ncmd"]){
			case "delete_stat":
				$this->banner->views = 0;
				$this->banner->clicks = 0;
				$this->db->query("UPDATE ".BANNER_TABLE." SET views=0,clicks=0 WHERE ID='".$this->banner->ID."'");
				$this->db->query("DELETE FROM ".BANNER_CLICKS_TABLE." WHERE ID='".$this->banner->ID."'");
				$this->db->query("DELETE FROM ".BANNER_VIEWS_TABLE." WHERE ID='".$this->banner->ID."'");
				break;
			case "new_banner":
				$this->page = 0;
				$this->banner=new weBanner();
				print '<script language="JavaScript">
					top.content.resize.right.editor.edheader.location="edit_banner_frameset.php?pnt=edheader&page='.$this->page.'&txt='.$this->banner->Path.'&isFolder='.$this->banner->IsFolder.'";
					top.content.resize.right.editor.edfooter.location="edit_banner_frameset.php?pnt=edfooter";
					</script>';
				break;
			case "new_bannergroup":
				$this->page = 0;
				$this->banner=new weBanner(0,1);
				print '<script language="JavaScript">
					top.content.resize.right.editor.edheader.location="edit_banner_frameset.php?pnt=edheader&page='.$this->page.'&txt='.$this->banner->Path.'&isFolder='.$this->banner->IsFolder.'";
					top.content.resize.right.editor.edfooter.location="edit_banner_frameset.php?pnt=edfooter";
					</script>';
				break;
			case "reload":
					print '<script language="JavaScript">
					top.content.resize.right.editor.edheader.location="edit_banner_frameset.php?pnt=edheader&page='.$this->page.'&txt='.$this->banner->Path.'&isFolder='.$this->banner->IsFolder.'";
					top.content.resize.right.editor.edfooter.location="edit_banner_frameset.php?pnt=edfooter";
					</script>
					</head>
					<body></body>
					</html>';
				break;
			case "edit_banner":
				if(isset($_REQUEST["bid"])){
					$this->banner = new weBanner($_REQUEST["bid"]);
				}
				if($this->banner->IsFolder){
					$this->page = 0;
				}
				$_REQUEST["ncmd"]="reload";
				$this->processCommands();

				break;
			case "add_cat":
				$arr=makeArrayFromCSV($this->banner->CategoryIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					$ids = makeArrayFromCSV($_REQUEST["ncmdvalue"]);
					foreach($ids as $id){
						if($id && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->banner->CategoryIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "del_cat":
				$arr=array();
				$arr=makeArrayFromCSV($this->banner->CategoryIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["ncmdvalue"]) array_splice($arr,$k,1);
					}
					$this->banner->CategoryIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "del_all_cats":
				$this->banner->CategoryIDs="";
				break;
			case "add_file":
				$arr=makeArrayFromCSV($this->banner->FileIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					$ids = makeArrayFromCSV($_REQUEST["ncmdvalue"]);
					foreach($ids as $id){
						if($id && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->banner->FileIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "del_file":
				$arr=array();
				$arr=makeArrayFromCSV($this->banner->FileIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["ncmdvalue"]) array_splice($arr,$k,1);
					}
					$this->banner->FileIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "del_all_files":
				$this->banner->FileIDs="";
				break;
			case "add_folder":
				$arr=makeArrayFromCSV($this->banner->FolderIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					$ids = makeArrayFromCSV($_REQUEST["ncmdvalue"]);
					foreach($ids as $id){
						if(strlen($id) && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->banner->FolderIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "add_customer":
				$arr=makeArrayFromCSV($this->banner->Customers);
				if(isset($_REQUEST["ncmdvalue"])){
					$ids = makeArrayFromCSV($_REQUEST["ncmdvalue"]);
					foreach($ids as $id){
						if($id && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->banner->Customers=makeCSVFromArray($arr,true);
				}
				break;
			case "del_customer":
				$arr=array();
				$arr=makeArrayFromCSV($this->banner->Customers);
				if(isset($_REQUEST["ncmdvalue"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["ncmdvalue"]) array_splice($arr,$k,1);
					}
					$this->banner->Customers=makeCSVFromArray($arr,true);
				}
				break;
			case "del_all_customers":
				$this->banner->Customers="";
				break;
			case "del_folder":
				$arr=array();
				$arr=makeArrayFromCSV($this->banner->FolderIDs);
				if(isset($_REQUEST["ncmdvalue"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["ncmdvalue"]) array_splice($arr,$k,1);
					}
					$this->banner->FolderIDs=makeCSVFromArray($arr,true);
				}
				break;
			case "del_all_folders":
				$this->banner->FolderIDs="";
				break;
			case "switchPage":
				if(isset($_REQUEST["page"])){
					$this->page=$_REQUEST["page"];
				}
				break;
			case "save_banner":
				if(isset($_REQUEST["bid"])){
					$newone=false;
					if(!$this->banner->ID){
						$newone=true;
					}
					$exist=false;
					$double = 0;
					if($newone)
						$this->db->query("SELECT COUNT(*) AS Count FROM ".BANNER_TABLE." WHERE Text='".addslashes($this->banner->Text)."' AND ParentID='".$this->banner->ParentID."'");
					else
						$this->db->query("SELECT COUNT(*) AS Count FROM ".BANNER_TABLE." WHERE Text='".addslashes($this->banner->Text)."' AND ParentID='".$this->banner->ParentID."' AND ID<>".$this->banner->ID."");

					if($this->db->next_record()){
						$double = $this->db->f("Count");
					}
					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php');
					$acQuery = new  weSelectorQuery();
					if(!we_hasPerm("EDIT_BANNER") && !we_hasPerm("NEW_BANNER")){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif($newone && !we_hasPerm("NEW_BANNER")){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif($this->banner->Text==""){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_text"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif(ereg('[%/\\\"\']',$this->banner->Text)){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["wrongtext"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif(!$this->banner->bannerID && !$this->banner->IsFolder){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_bannerid"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif($this->banner->ID && ($this->banner->ID == $this->banner->ParentID)){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_group_in_group"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}elseif($double){
						if($double){
							print '<script language="JavaScript">';
							print we_message_reporting::getShowMessageCall($l_banner["double_name"], WE_MESSAGE_ERROR);
							print '</script>';
							return;
						}
					}
					
					if($this->banner->ParentID>0){
						$acResult = $acQuery->getItemById($this->banner->ParentID, BANNER_TABLE, "IsFolder");
						if(!$acResult || (isset($acResult[0]['IsFolder']) && $acResult[0]['IsFolder']==0)) {
							print '<script language="JavaScript">';
							print we_message_reporting::getShowMessageCall($l_banner["error_ac_field"], WE_MESSAGE_ERROR);
							print '</script>';
							return;
						}						
					}
					if($this->banner->IntHref){
						$acResult = $acQuery->getItemById($this->banner->bannerIntID, FILE_TABLE, array("IsFolder"));
						if(!$acResult || $acResult[0]['IsFolder']==1) {
							print '<script language="JavaScript">';
							print we_message_reporting::getShowMessageCall($l_banner["error_ac_field"], WE_MESSAGE_ERROR);
							print '</script>';
							return;
						}
					}
					if($this->banner->bannerID>0){
						$acResult = $acQuery->getItemById($this->banner->bannerID, FILE_TABLE, array("ContentType"));
						if(!$acResult || $acResult[0]['ContentType']!='image/*') {
							print '<script language="JavaScript">';
							print we_message_reporting::getShowMessageCall($l_banner["error_ac_field"], WE_MESSAGE_ERROR);
							print '</script>';
							return;
						}
					}
					
												
					$childs="";
					$message="";
					$this->banner->save($message);
					print '<script language="JavaScript">';
						if($newone) print 'top.content.makeNewEntry("'.$this->banner->Icon.'",'.$this->banner->ID.','.$this->banner->ParentID.',"'.$this->banner->Text.'",true,"'.($this->banner->IsFolder ? 'folder' : 'file').'","weBanner",1);';
						else print 'top.content.updateEntry('.$this->banner->ID.','.$this->banner->ParentID.',"'.$this->banner->Text.'",1);';
						print $childs;
						print we_message_reporting::getShowMessageCall( ($this->banner->IsFolder ? $l_banner["save_group_ok"] : $l_banner["save_ok"]), WE_MESSAGE_NOTICE );
						print '</script>';

				}
				break;
			case "delete_banner":
				if(isset($_REQUEST["bid"])){
					if(!we_hasPerm("DELETE_BANNER")){
						print '<script language="JavaScript">';
						print we_message_reporting::getShowMessageCall($l_banner["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}
					else{

						$this->banner = new weBanner($_REQUEST["bid"]);
						if($this->banner->delete()){
							$this->banner = new weBanner(0,$this->banner->IsFolder);
							print '<script language="JavaScript">
							top.content.deleteEntry('.$_REQUEST["bid"].',"'.($this->banner->IsFolder ? 'folder' : 'file').'");
							' . we_message_reporting::getShowMessageCall( ($this->banner->IsFolder ? $l_banner["delete_group_ok"] : $l_banner["delete_ok"]), WE_MESSAGE_NOTICE ) . '
							top.content.we_cmd("new_banner");
							</script>';
						}else{
							print '<script language="JavaScript">
							' . we_message_reporting::getShowMessageCall( ($this->banner->IsFolder ? $l_banner["delete_group_nok"] : $l_banner["delete_nok"]), WE_MESSAGE_ERROR ) . '
							</script>';
						}
					}
				}
				break;
			case "reload_table":
				$this->page=1;
				break;
			default:
		}
	}

	function processVariables(){
		if(isset($_REQUEST["bname"])){
			$this->uid=$_REQUEST["bname"];
		}
		if(isset($_REQUEST["bid"])){
			$this->banner->ID=$_REQUEST["bid"];
		}
		if(isset($_REQUEST["page"])){
			$this->page=$_REQUEST["page"];
		}
		if(isset($_REQUEST["order"])){
			$this->Order=$_REQUEST["order"];
		}
		if(isset($_REQUEST["DoctypeIDs"]) && is_array($_REQUEST["DoctypeIDs"])){
			$this->banner->DoctypeIDs=makeCSVFromArray($_REQUEST["DoctypeIDs"],true);
		}
		if(isset($_REQUEST["UseFilter"])){
			$this->UseFilter=$_REQUEST["UseFilter"];
		}
		if(isset($_REQUEST["Customers"])){
			$this->banner->Customers=$_REQUEST["Customers"];
		}
		if(is_array($this->banner->persistents)){
			foreach($this->banner->persistents as $key=>$val){
				$varname=$this->uid."_".$val;
				if(isset($_REQUEST[$varname])){
					eval('$this->banner->'.$val.'="'.str_replace("\"","\\\"",$_REQUEST[$varname]).'";');
				}
			}
		}

		if(isset($_REQUEST["dateFilter_day"])){
			$this->FilterDate = mktime(	0,
							0,
							0,
							$_REQUEST["dateFilter_month"],
							$_REQUEST["dateFilter_day"],
							$_REQUEST["dateFilter_year"]);
		}else if(isset($_REQUEST["FilterDate"])){
			$this->FilterDate = $_REQUEST["FilterDate"];
		}
		if(isset($_REQUEST["dateFilter2_day"])){
			$this->FilterDateEnd = mktime(	0,
							0,
							0,
							$_REQUEST["dateFilter2_month"],
							$_REQUEST["dateFilter2_day"],
							$_REQUEST["dateFilter2_year"]);
		}else if(isset($_REQUEST["FilterDateEnd"])){
			$this->FilterDateEnd = $_REQUEST["FilterDateEnd"];
		}

		if(isset($_REQUEST["we__From_day"])){
			$this->banner->StartDate = mktime(	$_REQUEST["we__From_hour"],
							$_REQUEST["we__From_minute"],
							0,
							$_REQUEST["we__From_month"],
							$_REQUEST["we__From_day"],
							$_REQUEST["we__From_year"]);
			$this->banner->EndDate = mktime(	$_REQUEST["we__To_hour"],
							$_REQUEST["we__To_minute"],
							0,
							$_REQUEST["we__To_month"],
							$_REQUEST["we__To_day"],
							$_REQUEST["we__To_year"]);
		}
	}

	// Static function - Settings

	function getSettings(){
		$db=new DB_WE();
		$ret=array();
		$db->query("SELECT * FROM ".BANNER_PREFS_TABLE);
		while($db->next_record()) $ret[$db->f("pref_name")]=$db->f("pref_value");
		return $ret;

	}

	function saveSettings($settings){
		$db=new DB_WE();
		$db->query("DELETE FROM ".BANNER_PREFS_TABLE);
		foreach($settings as $key=>$value){
			$db->query("INSERT INTO ".BANNER_PREFS_TABLE."(pref_name,pref_value) VALUES '$key','$value'");
		}
	}

	############### form functions #################

	function formTagName(){
		global $l_banner;

		$tagnames = array();
		$query = "SELECT ".CONTENT_TABLE.".Dat AS templateCode, ".LINK_TABLE.".DID AS DID FROM ".CONTENT_TABLE.",".LINK_TABLE." WHERE ".LINK_TABLE.".DocumentTable='".substr(TEMPLATES_TABLE, strlen(TBL_PREFIX))."' AND ".LINK_TABLE.".CID=".CONTENT_TABLE.".ID AND ".CONTENT_TABLE.".Dat like '%<we:banner %'  ";
		$this->db->query($query);
		while($this->db->next_record()){
			preg_match_all ("|(<we:banner [^>]+>)|U",$this->db->f("templateCode"),$foo, PREG_SET_ORDER);
			for($i=0;$i<sizeof($foo);$i++){
				$wholeTag = $foo[$i][1];
				$name = eregi_replace('.+name="([^"]+)".*','\1',$wholeTag);
				if($name && (!in_array($name,$tagnames))){
					array_push($tagnames,$name);
				}
			}

		}
		sort($tagnames);
		
		$code = '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="defaultfont">'.
		htmlTextInput($this->uid."_TagName",50,$this->banner->TagName,"",'style="width:250px" onchange="top.content.setHot();"').
		'</td>
<td class="defaultfont">'.getPixel(10,2).'</td>
<td class="defaultfont"><select style="width:240px" class="weSelect" name="'.$this->uid.'_TagName_tmp" size="1" onchange="top.content.setHot(); this.form.elements[\''.$this->uid.'_TagName\'].value=this.options[this.selectedIndex].value;this.selectedIndex=0">'."\n";
		$code .= '<option value=""></option>'."\n";
		foreach($tagnames as $tagname){
			$code .= '<option value="'.$tagname.'">'.$tagname.'</option>'."\n";
		}
		$code .= '</select></td></tr></table>';
		return $code;

	}

	function formFiles(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_banner;
		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:top.content.setHot(); we_cmd('del_all_files')");
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot(); we_cmd('openDocselector','','".FILE_TABLE."','','','fillIDs();opener.we_cmd(\\'add_file\\',top.allIDs);','','','text/webedition','',1)");

		$dirs = new MultiDirChooser(495,$this->banner->FileIDs,"del_file",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",FILE_TABLE);

		return $dirs->get();

	}

	function formFolders(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_banner;

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:top.content.setHot();we_cmd('del_all_folders')");
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openDirselector','','".FILE_TABLE."','','','fillIDs();opener.we_cmd(\\'add_folder\\',top.allIDs);','','','',1)");

		$dirs = new MultiDirChooser(495,$this->banner->FolderIDs,"del_folder",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",FILE_TABLE);

		return $dirs->get();

	}

	function formCategories(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_banner;

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:top.content.setHot();we_cmd('del_all_cats')");
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openCatselector','','".CATEGORY_TABLE."','','','fillIDs();opener.we_cmd(\'add_cat\',top.allIDs);')");

		$cats = new MultiDirChooser(495,$this->banner->CategoryIDs,"del_cat",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CATEGORY_TABLE);

		return $cats->get();

	}
	function formDoctypes(){
		global $l_banner;

		$dt = '<select name="DoctypeIDs[]" size="10" multiple="multiple" style="width:495" onchange="top.content.setHot();">
';
		$this->db->query("SELECT DocType,ID FROM ".DOC_TYPES_TABLE." ORDER BY DocType");

		$doctypesArr= makeArrayFromCSV($this->banner->DoctypeIDs);
		while($this->db->next_record()){
			$dt .= '<option value="'.$this->db->f("ID").'"'.(in_array($this->db->f("ID"),$doctypesArr) ? ' selected' : '').'>'.$this->db->f("DocType").'</option>'."\n";
		}
		$dt .= '</select>
';


		return $dt;

	}

	function formStat($class="middlefont"){

		$datefilterCheck = we_forms::checkboxWithHidden($this->UseFilter, "UseFilter", $GLOBALS["l_banner"]["datefilter"],false,"defaultfont","top.content.setHot(); we_cmd('switchPage','".$this->page."')");
		$datefilter = getDateInput2("dateFilter%s",($this->FilterDate == -1 ? time() : $this->FilterDate),false,"dmy","top.content.setHot(); we_cmd('switchPage','".$this->page."');",$class);
		$datefilter2 = getDateInput2("dateFilter2%s",($this->FilterDateEnd == -1 ? time() : $this->FilterDateEnd),false,"dmy","top.content.setHot(); we_cmd('switchPage','".$this->page."');",$class);

		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2">'.$datefilterCheck.'</td>
	</tr>
	<tr>
		<td>'.getPixel(20,5).'</td><td>'.getPixel(500,2).'</td>
	</tr>
	<tr>
		<td colspan="2"><table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_global"]["from"].':&nbsp;</td>
		<td>'.$datefilter.'</td>
		<td class="defaultfont">'.$GLOBALS["l_global"]["to"].':&nbsp;</td>
		<td>'.$datefilter2.'</td>
	</tr>
</table></td>
	</tr>
</table>
';

		$GLOBALS["lv"] = new we_listview_banner("0",99999999,$this->Order,$this->banner->ID,$this->UseFilter,$this->FilterDate,$this->FilterDateEnd+86399);
		$pathlink = '<a href="javascript:top.content.setHot();if(this.document.we_form.elements[\'order\'].value==\'path\'){this.document.we_form.elements[\'order\'].value=\'path desc\';}else{this.document.we_form.elements[\'order\'].value=\'path\';}we_cmd(\'switchPage\',\''.$this->page.'\');">'.$GLOBALS["l_banner"]["page"].'</a>';
		$viewslink = '<a href="javascript:top.content.setHot();if(this.document.we_form.elements[\'order\'].value==\'views desc\'){this.document.we_form.elements[\'order\'].value=\'views\';}else{this.document.we_form.elements[\'order\'].value=\'views desc\';}we_cmd(\'switchPage\',\''.$this->page.'\');">'.$GLOBALS["l_banner"]["views"].'</a>';
		$clickslink = '<a href="javascript:top.content.setHot();if(this.document.we_form.elements[\'order\'].value==\'clicks desc\'){this.document.we_form.elements[\'order\'].value=\'clicks\';}else{this.document.we_form.elements[\'order\'].value=\'clicks desc\';}we_cmd(\'switchPage\',\''.$this->page.'\');">'.$GLOBALS["l_banner"]["clicks"].'</a>';
		$ratelink = '<a href="javascript:top.content.setHot();if(this.document.we_form.elements[\'order\'].value==\'rate desc\'){this.document.we_form.elements[\'order\'].value=\'rate\';}else{this.document.we_form.elements[\'order\'].value=\'rate desc\';}we_cmd(\'switchPage\',\''.$this->page.'\');">'.$GLOBALS["l_banner"]["rate"].'</a>';
		$headline = array(
							array("dat"=>$pathlink),
							array("dat"=>$viewslink),
							array("dat"=>$clickslink),
							array("dat"=>$ratelink)
						);
		$rows = array(
							array(
								array("dat"=>$GLOBALS["l_banner"]["all"]),
								array("dat"=>$GLOBALS["lv"]->getAllviews()),
								array("dat"=>$GLOBALS["lv"]->getAllclicks()),
								array("dat"=>$GLOBALS["lv"]->getAllrate()."%","align"=>"right")
								)
						);
		while($GLOBALS["lv"]->next_record()){
			array_push($rows, array(array("dat"=>($GLOBALS["lv"]->f("page") ? '' : '<a href="'.$GLOBALS["lv"]->f("WE_PATH").'" target="_blank">').$GLOBALS["lv"]->f("WE_PATH").($GLOBALS["lv"]->f("page") ? '' : '</a>'),FILE_TABLE),array("dat"=>$GLOBALS["lv"]->f("views")),array("dat"=>$GLOBALS["lv"]->f("clicks")),array("dat"=>$GLOBALS["lv"]->f("rate")."%","align"=>"right")));
		}

		$table = htmlDialogBorder3(650, 0,  $rows ,$headline,$class);
		$we_button = new we_button();
		$delbut = $we_button->create_button("delete", "javascript:top.content.setHot();we_cmd('delete_stat')");

		return  $content.getPixel(2,10).$table.getPixel(2,10)."<br>".$delbut;
	}

	function formBanner($leftsize=120){
		global $l_banner;
		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$this->formBannerChooser(388,$this->uid."_bannerID",$this->banner->bannerID,$l_banner["imagepath"],"opener.we_cmd(\\'switchPage\\',\\'".$this->page."\\')").'</td>
	</tr>
';
		if($this->banner->bannerID){
			$content .= '	<tr>
		<td>'.getPixel(20,10).'</td>
	</tr>
	<tr>
		<td>'.$this->previewBanner().'</td>
	</tr>
';
		}
		$content .= '	<tr>
		<td>'.getPixel(20,10).'</td>
	</tr>
	<tr>
		<td>'.$this->formBannerHref().'</td>
	</tr>
	<tr>
		<td>'.getPixel(20,10).'</td>
	</tr>
	<tr>
		<td>'.$this->formBannerNumbers().'</td>
	</tr>
</table>
';
		return $content;
	}

	function formPeriod(){
		global $l_banner;

		$now = time();
		$from = $this->banner->StartOk ? $this->banner->StartDate : $now;
		$to = $this->banner->EndOk ? $this->banner->EndDate : $now + 3600;

		$checkStart = we_forms::checkboxWithHidden($this->banner->StartOk, $this->uid.'_StartOk', $l_banner["from"],false,"defaultfont","top.content.setHot();");
		$checkEnd = we_forms::checkboxWithHidden($this->banner->EndOk, $this->uid.'_EndOk', $l_banner["to"],false,"defaultfont","top.content.setHot();");


		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$checkStart.'</td>
		<td></td>
		<td>'.$checkEnd.'</td>
	</tr>
	<tr>
		<td></td>
		<td>'.getPixel(20,2).'</td>
		<td></td>
	</tr>
	<tr>
		<td>'.getDateInput2("we__From%s",$from,false,"","top.content.setHot();").'</td>
		<td></td>
		<td>'.getDateInput2("we__To%s",$to,false,"","top.content.setHot();").'</td>
	</tr>
</table>
';


		return $content;

	}

   function formCustomer(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_banner;
		$we_button = new we_button();
		$delallbut = $we_button->create_button("delete_all","javascript:top.content.setHot();we_cmd('del_all_customers')");
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openSelector','','".CUSTOMER_TABLE."','','','fillIDs();opener.we_cmd(\\'add_customer\\',top.allIDs);','','','',1)");
 		$obj = new MultiDirChooser(508,$this->banner->Customers,"del_customer",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CUSTOMER_TABLE);
		return $obj->get();
	}

	function formPath($leftsize=120){
		global $l_banner;
		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.htmlFormElementTable(htmlTextInput($this->uid."_Text",37,$this->banner->Text,"",'style="width:388px" id="yuiAcInputPathName" onchange="top.content.setHot();" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()"'),$l_banner["name"]).'</td>
	</tr>
	<tr>
		<td>'.getPixel(20,10).'</td>
	</tr>
	<tr>
		<td>'.$this->formDirChooser(388,BANNER_TABLE,$this->banner->ParentID,$this->uid."_ParentID",$l_banner["group"],"","PathGroup").'</td>
	</tr>
</table>
';
		return $content;
	}

	function getHTMLParentPath(){
		$out="";
		$IDName="ParentID";
		$Pathname="ParentPath";

		$out.=$this->htmlHidden($IDName,0);
		$out.=$this->htmlHidden($Pathname,"");

		$we_button = new we_button();
		$out.= $we_button->create_button("select", "javascript:top.content.setHot();we_cmd('openSelector',document.we_form.elements['$IDName'].value,'".BANNER_TABLE."','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','opener.we_cmd(\\'copy_banner\\');','".session_id()."','$rootDirID')");

		return $out;
	}


	/* creates the DocumentChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formBannerChooser($width="",$IDName="bannerID",$IDValue="0",$title="",$cmd=""){
		$yuiSuggest =& weSuggest::getInstance();
		$Pathvalue=$IDValue ? id_to_path($IDValue,FILE_TABLE,$this->db) : "";
		$Pathname = md5(uniqid(rand()));
		$we_button = new we_button();
		$button = $we_button->create_button("select", "javascript:top.content.setHot();we_cmd('openDocselector',((document.we_form.elements['$IDName'].value != 0) ? document.we_form.elements['$IDName'].value : ''),'".FILE_TABLE."','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','',0,'image/*')");

		$yuiSuggest->setAcId("Image");
		$yuiSuggest->setContentType("folder,image/*,application/*,application/x-shockwave-flash,video/quicktime");
		$yuiSuggest->setInput($Pathname,$Pathvalue,"onchange=\"top.content.setHot();\"",true);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($IDName,$IDValue);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);
		
		return $yuiSuggest->getHTML();
	}

	function formDirChooser($width="",$table=FILE_TABLE,$idvalue,$idname,$title="",$cmd="", $acID=""){
		$yuiSuggest =& weSuggest::getInstance();
		$path=id_to_path($idvalue,$table,$this->db);
		$textname = md5(uniqid(rand()));
		$we_button = new we_button();
		$button = $we_button->create_button("select", "javascript:top.content.setHot();we_cmd('openBannerDirselector',document.we_form.elements['$idname'].value,'document.we_form.elements[\'$idname\'].value','document.we_form.elements[\'$textname\'].value','".$cmd."')");

		$yuiSuggest->setAcId($acID);
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($textname,$path,"onchange=\"top.content.setHot();\"",true);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(false);
		$yuiSuggest->setResult($idname,$idvalue);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable($table);
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);
		
		return $yuiSuggest->getHTML();
	}

	function formBannerNumbers(){
		global $l_banner;
		$cn = md5(uniqid(rand()));
		$activeCheckbox = we_forms::checkboxWithHidden($this->banner->IsActive, $this->uid.'_IsActive', $l_banner["active"],false,"defaultfont","top.content.setHot();");
		$maxShow = htmlFormElementTable(htmlTextInput($this->uid."_maxShow",10,$this->banner->maxShow,"","onchange=\"top.content.setHot();\"","text","100",0),
			$l_banner["max_show"],
			"left",
			"defaultfont");
		$maxClicks = htmlFormElementTable(htmlTextInput($this->uid."_maxClicks",10,$this->banner->maxClicks,"","onchange=\"top.content.setHot();\"","text","100",0),
			$l_banner["max_clicks"],
			"left",
			"defaultfont");
		$weight = htmlFormElementTable(htmlSelect(	$this->uid."_weight",
													array("8"=>"1 (".$l_banner["infrequent"].")", "7"=>"2", "6"=>"3", "5"=>"4", "4"=>"5 (".$l_banner["normal"].")", "3"=>"6", "2"=>"7", "1"=>"8", "0"=>"9 (".$l_banner["frequent"].")") ,
													1,
													$this->banner->weight) ,
			$l_banner["weight"],
			"left",
			"defaultfont");

		return '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$activeCheckbox.'</td>
		<td>'.getPixel(40,2).'</td>
		<td>'.$maxShow.'</td>
		<td>'.getPixel(40,2).'</td>
		<td>'.$maxClicks.'</td>
		<td>'.getPixel(40,2).'</td>
		<td>'.$weight.'</td>
	</tr>
</table>
';
	}

	function formBannerHref(){
		$idvalue = $this->banner->bannerIntID;
		$idname = $this->uid."_bannerIntID";

		$Pathvalue=$idvalue ? id_to_path($idvalue,FILE_TABLE,$this->db) : "";
		$Pathname = md5(uniqid(rand()));

		$cmd = "opener.document.we_form.elements[\\'".$this->uid."_IntHref\\'][1].checked=true";
		
		$onkeydown = "self.document.we_form.elements['".$this->uid."_IntHref'][0].checked=true; YAHOO.autocoml.setValidById('yuiAcInputInternalURL'); document.getElementById('yuiAcInputInternalURL').value=''; document.getElementById('yuiAcResultInternalURL').value=''";
		$onkeydown2 = "self.document.we_form.elements['".$this->uid."_IntHref'][1].checked=true; document.getElementById('".$this->uid."_bannerUrl"."').value='';";
		$width = 388;
		
		$title1 = $GLOBALS["l_banner"]["ext_url"];
		$title2 = $GLOBALS["l_banner"]["int_url"];

		$title1 = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><input type="radio" name="'.$this->uid.'_IntHref" id="'.$this->uid.'_IntHref0" value="0"'.($this->banner->IntHref ? "" : " checked").'></td>
		<td class="defaultfont">&nbsp;<label for="'.$this->uid.'_IntHref0">'.$title1.'</label></td>
	</tr>
</table>';

		$title2 = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><input type="radio" name="'.$this->uid.'_IntHref" id="'.$this->uid.'_IntHref1" value="1"'.($this->banner->IntHref ? " checked" : "").'></td>
		<td class="defaultfont">&nbsp;<label for="'.$this->uid.'_IntHref1">'.$title2.'</label></td>
	</tr>
</table>';

		$we_button = new we_button();
		$button = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.we_form.elements['$idname'].value,'".FILE_TABLE."','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','',0,'')");
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("InternalURL");
		$yuiSuggest->setContentType("folder,text/xml,text/webedition,image/*,text/html,application/*,application/x-shockwave-flash,video/quicktime");
		$yuiSuggest->setInput($Pathname,$Pathvalue,"onchange=\"top.content.setHot();\"",true);
		$yuiSuggest->setLabel($title2);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($idname,$idvalue);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);
		
		return htmlFormElementTable(htmlTextInput($this->uid."_bannerUrl",30,$this->banner->bannerUrl,"",'id="'.$this->uid.'_bannerUrl" onkeydown="'.$onkeydown.'"',"text",$width,0),
			$title1,
			"left",
			"defaultfont","","","","","",0).getPixel(10,5).$yuiSuggest->getHTML();
	}

}

?>

