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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModuleFrames.php");
include_once(WE_NEWSLETTER_MODULE_DIR . "weNewsletterView.php");
include_once(WE_NEWSLETTER_MODULE_DIR . "weNewsletterTree.php");
include_once(WE_NEWSLETTER_MODULE_DIR . "weNewsletterDirSelector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');

class weNewsletterFrames extends weModuleFrames {

	var $multibox_width = 650;
	var $def_width = 450;
	var $weAutoColpleter;

	function weNewsletterFrames() {
		weModuleFrames::weModuleFrames(WE_NEWSLETTER_MODULE_PATH."edit_newsletter_frameset.php");
		$this->View = new weNewsletterView();
		$this->View->setFrames("top.content","top.content.resize.left.tree","top.content.cmd");

		$this->Tree=new weNewsletterTree();
		$this->setupTree(NEWSLETTER_TABLE,"top.content","top.content.resize.left.tree","top.content.cmd");

		$this->module="newsletter";
		$this->weAutoColpleter =& weSuggest::getInstance();
	}


	function getHTMLFrameset() {

		$js=we_htmlElement::jsElement('
			var hot = 0;
			var scrollToVal = 0;
		');

		$frameset=weModuleFrames::getHTMLFrameset();

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"#bfbfbf","background"=>IMAGE_DIR."backgrounds/aquaBackground.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0"),"");

		return $this->getHTMLDocument($frameset.$body,$js);

	}


	function getJSCmdCode() {
		print $this->View->getJSTopCode();
	}

	/**
	 * Modul Header
	 * 
	 * @package weModules
	 * @subpackage Newsletter
	 * @param Integer $mode
	 * @return String
	 */
	function getHTMLEditorHeader($mode = 0) {
		global $l_users,$l_newsletter;

		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#FFFFFF","background"=>"/webEdition/images/backgrounds/bgGrayLineTop.gif"),""));
		}

		$group=0;
		if(isset($_REQUEST["group"])){
			$group=$_REQUEST["group"];
		}

		$page = 0;
		if($group){
			$page = 0;
		}
		else	if (isset($_REQUEST["page"])) {
			$page=$_REQUEST["page"];
		}


		if($group) $textPre = $l_newsletter["group"];
		else $textPre = $l_newsletter["newsletter"];

		if (isset($_REQUEST["txt"])) $textPost=$_REQUEST["txt"];
		else $textPost=$l_newsletter["new_newsletter"];

		$js=we_htmlElement::jsElement('
				function setTab(tab) {
					switch (tab) {
						case 0:
							top.content.resize.right.editor.edbody.we_cmd("switchPage",0);
							break;

						case 1:
							top.content.resize.right.editor.edbody.we_cmd("switchPage",1);
							break;

						case 2:
							top.content.resize.right.editor.edbody.we_cmd("switchPage",2);
							break;
					}

				}
				top.content.hloaded = 1;
		');

		$we_tabs = new we_tabs();

		$we_tabs->addTab(new we_tab("#", $l_newsletter["property"],(($page==0) ? "TAB_ACTIVE" : "TAB_NORMAL"),"self.setTab(0);"));

		if (!$group) {
			$we_tabs->addTab(new we_tab("#", sprintf($l_newsletter["mailing_list"],""),(($page==1) ? "TAB_ACTIVE" : "TAB_NORMAL"),"self.setTab(1);"));
			$we_tabs->addTab(new we_tab("#", $l_newsletter["edit"],(($page==2) ? "TAB_ACTIVE" : "TAB_NORMAL"),"self.setTab(2);"));
		}

		$we_tabs->onResize('header');
		$tabHead = $we_tabs->getHeader() . $js;
		$tabBody = $we_tabs->getJS();

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0", "topmargin"=>"0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"),
			'<div id="main" >' . getPixel(100,3) . '<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",$textPre).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$textPost).'</b></span></nobr></div>' . getPixel(100,3) .
			$we_tabs->getHTML() .
			'</div>'
		);

		return $this->getHTMLDocument($body,$tabHead);
	}

	/**
	 * Modul Body
	 *
	 * @package weModules
	 * @subpackage Newsletter
	 * @return String
	 */
	function getHTMLEditorBody() {
		return $this->getHTMLProperties();
	}

	/**
	 * Modul Footer
	 *
	 * @package weModules
	 * @subpackage Newsletter
	 * @param Integer $mode
	 * @return String
	 */
	function getHTMLEditorFooter($mode = 0) {
		global $l_newsletter;

		if(isset($_REQUEST["home"])){
			return $this->getHTMLDocument(we_htmlElement::htmlBody(array("bgcolor"=>"#EFF0EF"),""));
		}

		$group=0;
		if(isset($_REQUEST["group"])){
			$group=$_REQUEST["group"];
		}

		$js=$this->View->getJSFooterCode();

		$js.=we_htmlElement::jsElement('
			function sprintf() {
				if (!arguments || arguments.length < 1) {
					return;
				}

				var argum = arguments[0];
				var regex = /([^%]*)%(%|d|s)(.*)/;
				var arr = new Array();
				var iterator = 0;
				var matches = 0;

				while (arr = regex.exec(argum)) {
					var left = arr[1];
					var type = arr[2];
					var right = arr[3];

					matches++;
					iterator++;

					var replace = arguments[iterator];

					if (type == "d") {
						replace = parseInt(param) ? parseInt(param) : 0;
					} else if (type == "s") {
						replace = arguments[iterator];
					}

					argum = left + replace + right;
				}
				return argum;
			}

			function addGroup(text, val) {
			   '.($group ?  '' : 'document.we_form.gview[document.we_form.gview.length] = new Option(text,val);'  ).'
			}

			function delGroup(val) {
			   document.we_form.gview[val] = null;
			}

			function populateGroups() {
				if (top.content.resize.right.editor.edbody.getGroupsNum) {

					if (top.content.resize.right.editor.edbody.loaded) {
						var num=top.content.resize.right.editor.edbody.getGroupsNum();

							if (!num) {
								num = 1;
							} else {
								num++;
							}

							addGroup(sprintf("'.$l_newsletter["all_list"].'",0),0);

							for (i = 1; i < num; i++) {
								addGroup(sprintf("'.$l_newsletter["mailing_list"].'",i),i);
							}
					} else {
						setTimeout("populateGroups()",100);
					}
				} else {
					setTimeout("populateGroups()",100);
				}
			}
			
			function we_save() {
			    setTimeout(\'top.content.we_cmd("save_newsletter")\',100);
				
			}
			
		');

		$select=new we_htmlSelect(array("name"=>"gview"));

		$we_button = new we_button();

		$table1=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"3000"),1,1);
		$table1->setCol(0,0,array("nowrap"=>null,"valign"=>"top"),getPixel(1600,10));

		$table2=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"300"),1,10);
		if ($mode==0) {
			$table2->setRow(0,array("valign"=>"middle"));

			$table2->setCol(0,0,array("nowrap"=>null),getPixel(15,5));

			$table2->setCol(0,1,array("nowrap"=>null),
						((we_hasPerm("NEW_NEWSLETTER") || we_hasPerm("EDIT_NEWSLETTER")) ?
							$we_button->create_button("save", "javascript:we_save()")
							:
							""
						)
			);

			if(!$group){

				$table2->setCol(0,2,array("nowrap"=>null),getPixel(70,5));

				$table2->setCol(0,3,array("nowrap"=>null),
						$select->getHtmlCode()
				);

				$table2->setCol(0,4,array("nowrap"=>null),getPixel(5,5));

				$table2->setCol(0,5,array("nowrap"=>null),
						we_forms::checkbox(0,false,"htmlmail_check",$l_newsletter["html_preview"],false,"defaultfont","if(document.we_form.htmlmail_check.checked) { document.we_form.hm.value=1;top.opener.top.nlHTMLMail=1; } else { document.we_form.hm.value=0;top.opener.top.nlHTMLMail=0; }")
				);

				$table2->setCol(0,6,array("nowrap"=>null),getPixel(5,5));

				$table2->setCol(0,7,array("nowrap"=>null),
						$we_button->create_button("preview", "javascript:we_cmd('popPreview')")
				);

				$table2->setCol(0,8,array("nowrap"=>null),getPixel(5,5));

				$table2->setCol(0,9,array("nowrap"=>null),
						(we_hasPerm("SEND_NEWSLETTER") ?
							$we_button->create_button("send", "javascript:we_cmd('popSend')")
							:
							""
						)
				);
			}
		}

		$post_js ='
		<script type="text/javascript">
		<!--
		if(typeof(self.document.we_form.htmlmail_check)!="undefined") {
			if(top.opener.top.nlHTMLMail) {
				self.document.we_form.htmlmail_check.checked = true;
				document.we_form.hm.value=1;
			}
			else {
				self.document.we_form.htmlmail_check.checked = false;
				document.we_form.hm.value=0;
			}
		}
		//-->
		</script>
		';

		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>"/webEdition/images/edit/editfooterback.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0","onload"=>"setTimeout('populateGroups()',100)"),
								we_htmlElement::htmlForm(array(),
								we_htmlElement::htmlHidden(array("name"=>"hm","value"=>"0")).
								$table1->getHtmlCode().
								$table2->getHtmlCode().
								$post_js
							)
		);

		return $this->getHTMLDocument($body,$js);

	}

	function getHTMLLog() {
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");

		global $l_newsletter;

		$content="";
		$this->View->db->query("SELECT * FROM ".NEWSLETTER_LOG_TABLE." WHERE NewsletterID=".$this->View->newsletter->ID." ORDER BY LogTime DESC");

		while ($this->View->db->next_record()) {
			$log=$l_newsletter[$this->View->db->f("Log")];
			$param=$this->View->db->f("Param");
			$content.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),date($l_we_editor_info["date_format_sec"],$this->View->db->f("LogTime")).'&nbsp;'.($param ? sprintf($log,$param) : $log));
		}

		$js=we_htmlElement::jsElement("self.focus();");
		$we_button = new we_button();
		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
			we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
				htmlDialogLayout(
					we_htmlElement::htmlDiv(null,getPixel(10,5)).
					we_htmlElement::htmlDiv(array("class"=>"blockwrapper","style"=>"width: 588px; height: 500px; border:1px #dce6f2 solid;"),$content).
					we_htmlElement::htmlDiv(null,getPixel(10,15)),
					$l_newsletter["show_log"],
					$we_button->create_button("close","javascript:self.close();")
				)

			)
		);

		//we_htmlElement::htmlTextarea(array("cols"=>"65","rows"=>"30","name"=>"check_report"),
		//	$content
		//).

		return $this->getHTMLDocument($body,$js);

	}

	function getHTMLCmd() {


		global $l_newsletter;
		$out="";

		if(isset($_REQUEST["pid"])){
			$pid=$_REQUEST["pid"];
		}
		else exit;

		include_once(WE_NEWSLETTER_MODULE_DIR."weNewsletterTreeLoader.php");

		$rootjs="";
		if(!$pid)
		$rootjs.='
		'.$this->Tree->topFrame.'.treeData.clear();
		'.$this->Tree->topFrame.'.treeData.add(new '.$this->Tree->topFrame.'.rootEntry(\''.$pid.'\',\'root\',\'root\'));
		';

		$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"cmd")).
					we_htmlElement::htmlHidden(array("name"=>"ncmd","value"=>"")).
				 	we_htmlElement::htmlHidden(array("name"=>"nopt","value"=>""));


		$out.=we_htmlElement::htmlBody(array("bgcolor"=>"white","marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10"),
					we_htmlElement::htmlForm(array("name"=>"we_form"),
							$hiddens.
							we_htmlElement::jsElement($rootjs.$this->Tree->getJSLoadTree(weNewsletterTreeLoader::getItems($pid)))
					)
		);


		return $this->getHTMLDocument($out);

	}

	function getHTMLSendQuestion() {
		global $l_newsletter;

		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody" ,"onblur"=>"self.focus","onunload"=>"doUnload()"),
							htmlYesNoCancelDialog($l_newsletter["continue_camp"],"/webEdition/images/alert.gif","ja","nein","abbrechen","opener.yes();self.close();","opener.no();self.close();","opener.cancel();self.close();")
		);

		return $this->getHTMLDocument($body);

	}

	function getHTMLSaveQuestion1() {
		global $l_newsletter;

		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody" ,"onblur"=>"self.focus","onunload"=>"doUnload()"),
							htmlYesNoCancelDialog($l_newsletter["ask_to_preserve"],"/webEdition/images/alert.gif","ja","nein","","opener.document.we_form.ask.value=0;opener.we_cmd('save_newsletter');self.close();","self.close();")
		);

		return $this->getHTMLDocument($body);

	}

	function getHTMLPrintLists() {
		global $l_newsletter;

		$we_button = new we_button();

		print we_htmlElement::jsElement("self.focus();");

		$emails=array();
		$out="";
		$count=count($this->View->newsletter->groups)+1;

		$tab1="&nbsp;&nbsp;&nbsp;";
		$tab2=$tab1.$tab1;
		$tab3=$tab1.$tab1.$tab1;
		$c=0;
		for ($k = 1; $k < $count; $k++) {
			$out.=we_htmlElement::htmlBr();
			$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab1.we_htmlElement::htmlB(sprintf($l_newsletter["mailing_list"],$k)));
			$gc=0;
			if (defined("CUSTOMER_TABLE")) {
				$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab2.$l_newsletter["customers"]);
				$emails=$this->View->getEmails($k,1,1);

				foreach ($emails as $email) {
					$gc++;
					$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab3.$email);
				}
			}

			$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab2.$l_newsletter["emails"]);

         	$emails=$this->View->getEmails($k,2,1);
			foreach($emails as $email){
				$gc++;
				$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab3.$email);
			}

			$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab2.$l_newsletter["file_email"]);

			$emails=$this->View->getEmails($k,3,1);
			foreach($emails as $email){
					$gc++;
					$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab3.$email);
			}
			$c+=$gc;
			$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab1.we_htmlElement::htmlB(sprintf($l_newsletter["sum_group"],$k).":".$gc));
		}

		$out.=we_htmlElement::htmlBr();
		$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab1.we_htmlElement::htmlB($l_newsletter["sum_all"].":".$c));
		$out.=we_htmlElement::htmlBr();
		print '</head><body class="weDialogBody">';
		print we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","onload"=>"self.focus()"),
				htmlDialogLayout(
					we_htmlElement::htmlBr().
					we_htmlElement::htmlDiv(array("class"=>"blockwrapper","style"=>"width: 588px; height: 500px; border:1px #dce6f2 solid;"),$out).
					we_htmlElement::htmlBr(),
					$l_newsletter["lists_overview"],
					$we_button->create_button("close","javascript:self.close();")
				)
		);
		print '</body></html>';
		flush();
	}


	function getHTMLDCheck() {
		global $l_newsletter;

		print we_htmlElement::jsElement("self.focus();");

		$we_button = new we_button();

		$tab1="&nbsp;&nbsp;&nbsp;";
		$tab2=$tab1.$tab1;
		$tab3=$tab1.$tab1.$tab1;

		$emails=array();
		$out="";
		$count=count($this->View->newsletter->groups)+1;

		$out.=we_htmlElement::htmlBr();
		$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab1.we_htmlElement::htmlB($l_newsletter["domain_check_begins"]));
		$out.=we_htmlElement::htmlBr();

		for ($k = 1; $k < $count; $k++) {

			$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab2.sprintf($l_newsletter["domain_check_list"],$k));

			$emails=$this->View->getEmails($k,0,1);

			foreach ($emails as $email) {
				if($this->View->newsletter->check_email($email)){
					$domain="";

					if(!$this->View->newsletter->check_domain($email,$domain)){
						$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab3.sprintf($l_newsletter["domain_nok"],$domain));
					}
				} else {
					$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab3.sprintf($l_newsletter["email_malformed"],$email));
				}
			}
		}
		$out.=we_htmlElement::htmlBr();
		$out.=we_htmlElement::htmlDiv(array("class"=>"defaultfont"),$tab1.we_htmlElement::htmlB($l_newsletter["domain_check_ends"]));
		$out.=we_htmlElement::htmlBr();
		print '</head><body class="weDialogBody">';
		print we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","onload"=>"self.focus()"),
				htmlDialogLayout(
					we_htmlElement::htmlBr().
					we_htmlElement::htmlDiv(array("class"=>"blockwrapper","style"=>"width: 588px; height: 500px; border:1px #dce6f2 solid;"),$out).
					we_htmlElement::htmlBr(),
					$l_newsletter["lists_overview"],
					$we_button->create_button("close","javascript:self.close();")
				)
		);
		print we_htmlElement::jsElement("self.focus();");
		print '</body></html>';
		flush();

	}

	function getHTMLSettings() {
		global $l_newsletter;

		$settings=$this->View->getSettings();

		$closeflag = false;

		if (isset($_REQUEST["ncmd"])) {

			if ($_REQUEST["ncmd"] == "save_settings") {
				$this->View->processCommands();
				$closeflag=true;
			}

		}


		$js=we_htmlElement::jsElement('
			self.focus();
		').$this->View->getJSProperty();

		$texts=array('send_step','send_wait','test_account','default_sender','default_reply','female_salutation','male_salutation');
		$radios=array('reject_malformed','reject_not_verified','reject_save_malformed','log_sending','default_htmlmail','title_or_salutation','additional_clp','use_https_refer','use_port');
		$extra_radio_text=array('use_port');
		$defaults=array('reject_save_malformed'=>'1','use_https_refer'=>'0','send_wait'=>'0','use_port'=>'0','use_port_check'=>'80','additional_clp'=>'0');

		$table=new we_htmlTable(array('border'=>'0','cellpadding'=>'0','cellspacing'=>'0'),1,3);
		$c=0;

		foreach ($texts as $text) {

			if(!isset($settings[$text])){
				$this->View->putSetting($text,(isset($defaults[$text]) ? $defaults[$text] : "0"));
				$settings=$this->View->getSettings();
			}

			$table->setCol($c,0,array("class"=>"defaultfont"),$l_newsletter[$text].":&nbsp;");
			$table->setCol($c,1,array(),getPixel(5,5));
			$table->setCol($c,2,array("class"=>"defaultfont"),htmlTextInput($text,40,$settings[$text],"","","text","308"));

			$table->addRow();
			$c++;
			if ($text == 'default_reply' || $text == 'male_salutation') {
				$table->setCol($c,0,array('colspan'=>'3'),getPixel(5,10));
			} else {
				$table->setCol($c,0,array('colspan'=>'3'),getPixel(5,3));
			}
			$c++;
			$table->addRow();
		}

		if (defined('CUSTOMER_TABLE')) {
			$custfields=array();

			foreach ($this->View->customers_fields as $fk=>$fv) {
				$custfields[$fv]=$fv;
			}

			$table->addRow(11);

			$table->setCol($c,0,array("class"=>"defaultfont"),$l_newsletter["customer_email_field"].":&nbsp;");
			$table->setCol($c,1,array("class"=>"defaultfont"),getPixel(5,5));
			$table->setCol($c,2,array("class"=>"defaultfont"),htmlSelect("customer_email_field",$custfields,1,$settings["customer_email_field"],false,'',"value","308"));

			$table->setCol($c+1,0,array('colspan'=>'3'),getPixel(5,3));

			$table->setCol($c+2,0,array('class'=>'defaultfont'),$l_newsletter['customer_html_field'].':&nbsp;');
			$table->setCol($c+2,1,array('class'=>'defaultfont'),getPixel(5,5));
			$table->setCol($c+2,2,array('class'=>'defaultfont'),htmlSelect('customer_html_field',$custfields,1,$settings['customer_html_field'],false,'','value','308'));

			$table->setCol($c+3,0,array('colspan'=>'3'),getPixel(5,3));

			$table->setCol($c+4,0,array('class'=>'defaultfont'),$l_newsletter['customer_salutation_field'].':&nbsp;');
			$table->setCol($c+4,1,array('class'=>'defaultfont'),getPixel(5,5));
			$table->setCol($c+4,2,array('class'=>'defaultfont'),htmlSelect('customer_salutation_field',$custfields,1,$settings['customer_salutation_field'],false,'','value','308'));

			$table->setCol($c+5,0,array('colspan'=>'3'),getPixel(5,3));

			$table->setCol($c+6,0,array('class'=>'defaultfont'),$l_newsletter['customer_title_field'].':&nbsp;');
			$table->setCol($c+6,1,array('class'=>'defaultfont'),getPixel(5,5));
			$table->setCol($c+6,2,array('class'=>'defaultfont'),htmlSelect('customer_title_field',$custfields,1,$settings['customer_title_field'],false,'','value','308'));

			$table->setCol($c+7,0,array('colspan'=>'3'),getPixel(5,3));

			$table->setCol($c+8,0,array('class'=>'defaultfont'),$l_newsletter['customer_firstname_field'].':&nbsp;');
			$table->setCol($c+8,1,array('class'=>'defaultfont'),getPixel(5,5));
			$table->setCol($c+8,2,array('class'=>'defaultfont'),htmlSelect('customer_firstname_field',$custfields,1,$settings['customer_firstname_field'],false,'','value','308'));

			$table->setCol($c+9,0,array('colspan'=>'3'),getPixel(5,3));

			$table->setCol($c+10,0,array('class'=>'defaultfont'),$l_newsletter['customer_lastname_field'].':&nbsp;');
			$table->setCol($c+10,1,array('class'=>'defaultfont'),getPixel(5,5));
			$table->setCol($c+10,2,array('class'=>'defaultfont'),htmlSelect('customer_lastname_field',$custfields,1,$settings['customer_lastname_field'],false,'','value','308'));

			$table->setCol($c+11,0,array('colspan'=>'3'),getPixel(5,3));
		}

		$we_button = new we_button();

		$close = $we_button->create_button('close','javascript:self.close();');
		$save = $we_button->create_button('save', "javascript:we_cmd('save_settings')");

		$radios_code='';
		foreach ($radios as $radio) {
			if(!isset($settings[$radio])){

				$this->View->putSetting($radio,(isset($defaults[$radio]) ? $defaults[$radio] : "1"));
				$settings=$this->View->getSettings();
			}
			if(in_array($radio,$extra_radio_text)){
				$radios_code.= we_forms::checkbox($settings[$radio], (($settings[$radio]>0) ? true : false ), $radio."_check", $l_newsletter[$radio."_check"], false,"defaultfont", "if(document.we_form.".$radio."_check.checked) document.we_form.".$radio.".value=".(isset($defaults[$radio."_check"]) ? $defaults[$radio."_check"] : "0")."; else document.we_form.".$radio.".value=0;");

				$radio_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),1,4);
				$radio_table->setCol(0,0,array("class"=>"defaultfont"),getPixel(25,5));
				$radio_table->setCol(0,1,array("class"=>"defaultfont"),$l_newsletter[$radio].":&nbsp;");
				$radio_table->setCol(0,2,array(),getPixel(5,5));
				$radio_table->setCol(0,3,array("class"=>"defaultfont"),htmlTextInput($radio,5,$settings[$radio],"","OnChange='if(document.we_form.".$radio.".value!=0) document.we_form.".$radio."_check.checked=true; else document.we_form.".$radio."_check.checked=false;'"));
				$radios_code.=$radio_table->getHtmlCode();
			}
			else{
				$radios_code.=we_forms::checkbox($settings[$radio], (($settings[$radio]==1) ? true : false ), $radio, $l_newsletter[$radio], false,"defaultfont", "if(document.we_form.".$radio.".checked) document.we_form.".$radio.".value=1; else document.we_form.".$radio.".value=0;");
			}
		}

		$deselect = $we_button->create_button("reset", "javascript:document.we_form.global_mailing_list.value=''");

		$gml_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),5,1);
		$gml_table->setCol(0,0,array("class"=>"defaultfont"),$l_newsletter["global_mailing_list"]);
		$gml_table->setCol(1,0,array(),getPixel(5,5));
		$gml_table->setCol(2,0,array(),$this->View->formFileChooser("420","global_mailing_list",$settings["global_mailing_list"]));
		$gml_table->setCol(3,0,array(),getPixel(5,5));
		$gml_table->setCol(4,0,array('align'=>'right'),$deselect);

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form"),
								$this->View->getHiddens().
								htmlDialogLayout(
									$table->getHtmlCode().
									getPixel(5,10).
									$radios_code.
									getPixel(5,15).
									$gml_table->getHtmlCode().
									getPixel(5,10),
									$l_newsletter["settings"],
									$we_button->position_yes_no_cancel($save,$close)
								)
							)
							.($closeflag ? we_htmlElement::jsElement('top.close();') : "")
		);

		return $this->getHTMLDocument($body,$js);


	}

	function getHTMLBlockType($name, $selected = 1) {
		global $l_newsletter;

		$out="";

		$values=array();
		$values[WENBLOCK_DOCUMENT]=$l_newsletter["newsletter_type_0"];
		$values[WENBLOCK_DOCUMENT_FIELD]=$l_newsletter["newsletter_type_1"];

		if (defined("OBJECT_TABLE")) {
			$values[WENBLOCK_OBJECT]=$l_newsletter["newsletter_type_2"];
			$values[WENBLOCK_OBJECT_FIELD]=$l_newsletter["newsletter_type_3"];
		}

		if (we_hasPerm("NEWSLETTER_FILES")){
			$values[WENBLOCK_FILE]=$l_newsletter["newsletter_type_4"];
		}
		$values[WENBLOCK_TEXT]=$l_newsletter["newsletter_type_5"];
		$values[WENBLOCK_ATTACHMENT]=$l_newsletter["newsletter_type_6"];
		$values[WENBLOCK_URL]=$l_newsletter["newsletter_type_7"];

		return htmlSelect($name,$values,1,$selected,false,'style="width:440;" onChange="we_cmd(\'switchPage\',2);"',"value","315","defaultfont");
	}

	function getHTMLBox($w, $h, $content, $headline = "", $width = 120,$height = 2) {
		$out="";
		$headline = ereg_replace(" ","&nbsp;",$headline);

		if ($headline) {
			$out='
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="24" height="'.$height.'"></td>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="'.$width.'" height="'.$height.'"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="top" class="defaultgray">
							'.$headline.'</td>
						<td>
							'.$content.'</td>
					</tr>
					<tr>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="24" height="'.$height.'"></td>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="'.$width.'" height="'.$height.'"></td>
						<td></td>
					</tr>
				</table>';
		} else {
			$out='
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="24" height="'.$height.'"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>
							'.$content.'</td>
					</tr>
					<tr>
						<td>
							<img src="'.IMAGE_DIR.'pixel.gif" width="24" height="'.$height.'"></td>
						<td></td>
					</tr></table>';
		}
		return $out;
	}

	function getHTMLCopy() {

		$we_button = new we_button();
		$out="";
		$IDName="copyid";
		$Pathname="copyid_text";

		$out.=$this->View->htmlHidden($IDName,0);
		$out.=$this->View->htmlHidden($Pathname,"");

		$out .= $we_button->create_button("select","javascript:we_cmd('openSelector',document.we_form.elements['$IDName'].value,'".NEWSLETTER_TABLE."','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','opener.we_cmd(\\'copy_newsletter\\');','".session_id()."','".get_ws(NEWSLETTER_TABLE)."')");

		return $out;
	}

	function getHTMLCustomer($group) {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		global $l_newsletter;

		$out="";

		$out.=we_forms::checkbox($this->View->newsletter->groups[$group]->SendAll, (($this->View->newsletter->groups[$group]->SendAll==0) ? false : true), "sendallcheck_$group", $l_newsletter["send_all"], false,"defaultfont","we_cmd('switch_sendall',$group);");

		if ($this->View->newsletter->groups[$group]->SendAll == 0) {
			$delallbut="";
			$addbut="";

			$we_button = new we_button();

			$delallbut = $we_button->create_button("delete_all","javascript:we_cmd('del_all_customers',".$group.")");
			$addbut = $we_button->create_button("add", "javascript:we_cmd('openSelector','','".CUSTOMER_TABLE."','','','fillIDs();opener.we_cmd(\\'add_customer\\',top.allIDs,".$group.");','','','',1)");

			$cats = new MultiDirChooser($this->def_width,$this->View->newsletter->groups[$group]->Customers,"del_customer",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CUSTOMER_TABLE);
			$cats->extraDelFn="document.we_form.ngroup.value=$group";
			$out.=$cats->get();
		}

		$out.=$this->getHTMLCustomerFilter($group);

		return $out;
	}


   function getHTMLExtern($group){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiFileChooser.inc.php");
		global $l_newsletter;

		$we_button = new we_button();

		$out="";
		$delallbut="";
		$addbut="";

		$delallbut = $we_button->create_button("delete_all","javascript:we_cmd('del_all_files',".$group.")");
		$addbut = $we_button->create_button("add", "javascript:we_cmd('browse_server','fileselect','','/','opener.we_cmd(\\'add_file\\',top.currentID,$group);');");


		$buttons=array();
		if(we_hasPerm("CAN_SELECT_EXTERNAL_FILES"))
			$buttons=array($delallbut, $addbut);
		else
			$buttons=array($delallbut);
		$cats = new MultiFileChooser($this->def_width,$this->View->newsletter->groups[$group]->Extern,"del_file",$we_button->create_button_table($buttons),"edit_file");

		$cats->extraDelFn="document.we_form.ngroup.value=$group";
		$out.=$this->View->htmlHidden("fileselect","");
		$out.=$cats->get();

		return $out;
   }


	function getHTMLCustomerFilter($group) {
		global $l_newsletter;

		$custfields=array();

		foreach ($this->View->customers_fields as $fk=>$fv) {
			if ($fv != "ParentID" && $fv != "IsFolder" && $fv != "Path" && $fv != "Text" && $fv != "Icon") {
				$custfields[$fv]=$fv;
			}
		}

		$operators=array("0"=>"=","1"=>"<>","2"=>"<","3"=>"<=","4"=>">","5"=>">=","7"=>$l_newsletter["operator"]['contains'],"8"=>$l_newsletter["operator"]['startWith'],"9"=>$l_newsletter["operator"]['endsWith'],"6"=>"LIKE",);
		$logic=array("AND"=>$l_newsletter["logic"]['and'],"OR"=>$l_newsletter["logic"]['or']);

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),1,3);
		$colspan="3";
		$table->setCol(0,0,((count($this->View->newsletter->groups[$group]->aFilter) && is_array($this->View->newsletter->groups[$group]->aFilter)) ? array("colspan"=>$colspan) : array()),
			we_forms::checkbox(((count($this->View->newsletter->groups[$group]->aFilter) && is_array($this->View->newsletter->groups[$group]->aFilter)) ? "1" : "0"), ((count($this->View->newsletter->groups[$group]->aFilter) && is_array($this->View->newsletter->groups[$group]->aFilter)) ? true : false),"filtercheck_$group", $l_newsletter["filter"],false,"defaultfont","if(document.we_form.filtercheck_$group.checked) we_cmd('add_filter',$group); else we_cmd('del_all_filters',$group);")
		);


		$c=1;
		if (is_array($this->View->newsletter->groups[$group]->aFilter)) {
			foreach ($this->View->newsletter->groups[$group]->aFilter as $k=>$v) {
				if ($k!=0) {
					$table->addRow();
					$table->setCol($c,0,array("colspan"=>$colspan),htmlSelect("filter_logic_".$group."_".$k,$logic,1,$v["logic"],false,'',"value","70"));
					$c++;
				}

				$table->addRow();
				$table->setCol($c,0,array(),htmlSelect("filter_fieldname_".$group."_".$k,$custfields,1,$v["fieldname"],false,'onChange="top.content.hot=1;"',"value","170"));
				$table->setCol($c,1,array(),htmlSelect("filter_operator_".$group."_".$k,$operators,1,$v["operator"],false,'onChange="top.content.hot=1;"',"value","80"));
				$table->setCol($c,2,array(),htmlTextInput("filter_fieldvalue_".$group."_".$k,16,$v["fieldvalue"],"",'onKeyUp="top.content.hot=1;"',"text","200"));
				$c++;
			}
		}

		if (is_array($this->View->newsletter->groups[$group]->aFilter) && count($this->View->newsletter->groups[$group]->aFilter)) {
			$table->addRow();
			$table->setCol($c,0,array("colspan"=>$colspan),getPixel(5,5));

			$we_button = new we_button();
			$plus = $we_button->create_button("image:btn_function_plus", "javascript:we_cmd('add_filter',$group)");
			$trash = $we_button->create_button("image:btn_function_trash","javascript:we_cmd('del_filter',$group)");

			$c++;
			$table->addRow();
			$table->setCol($c,0,array("colspan"=>$colspan),$we_button->create_button_table(array($plus,$trash)));
		}

		return $this->View->htmlHidden("filter_".$group,count($this->View->newsletter->groups[$group]->aFilter)).
					$table->getHtmlCode();
	}

	/**
	 * Mailing list - block Emails
	 * 
	 * @package weModules
	 * @subpackage Newsletter
	 *
	 * @param unknown_type $group
	 * @return unknown
	 */
	function getHTMLEmails($group) {
		global $l_newsletter;

		$we_button = new we_button();

		$arr=array();
		$arr=$this->View->newsletter->getEmailsFromList(htmlspecialchars($this->View->newsletter->groups[$group]->Emails),1);
		// Buttons to handle the emails in  the email list
		$buttons_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),7,1);
		$buttons_table->setCol(0,0,array(),$we_button->create_button("add", "javascript:we_cmd('add_email', " . $group . ");"));
		$buttons_table->setCol(1,0,array(),getPixel(1,5));
		$buttons_table->setCol(2,0,array(),$we_button->create_button("edit", "javascript:we_cmd('edit_email', " . $group . ");"));
		$buttons_table->setCol(3,0,array(),getPixel(1,5));
		$buttons_table->setCol(4,0,array(),$we_button->create_button("delete", "javascript:deleteit(" . $group . ")"));
		$buttons_table->setCol(5,0,array(),getPixel(1,5));
		$buttons_table->setCol(6,0,array(),$we_button->create_button("delete_all", "javascript:deleteall(" . $group . ")"));

		// Dialog table for the email block
		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),6,3);
		
		// 1. ROW: select status
		$selectStatus = we_htmlElement::htmlB($l_newsletter["status"])." ".htmlSelect("weEmailStatus",array($l_newsletter["statusAll"],$l_newsletter["statusInvalid"]),"",(isset($_REQUEST['weEmailStatus'])?$_REQUEST['weEmailStatus']:"0"),"","onchange='weShowMailsByStatus(this.value, $group);' id='weViewByStatus'","value","150");
		$table->setCol(0,0,array("valign"=>"middle","colspan"=>"3","class"=>"defaultfont"),$selectStatus);		
		$table->setCol(1,0,array("colspan"=>"3"),getPixel(5,10));
		
		// 2. ROW: Mail list with handling buttons
		$table->setCol(2,0,array("valign"=>"top"),$this->View->newsletter->htmlSelectEmailList("we_recipient".$group,$arr,10,"",false,'style="width:'.($this->def_width-110).'px; height:140px" id="we_recipient'.$group.'"',"value","600"));
		$table->setCol(2,1,array("valign"=>"middle"),getPixel(10,12));
		$table->setCol(2,2,array("valign"=>"top"),$buttons_table->getHtmlCode());
		$table->setCol(3,0,array("colspan"=>"3"),getPixel(5,10));

		// 3. ROW: Buttons for email import and export  
		$importbut = $we_button->create_button("import","javascript:we_cmd('set_import',".$group.")");
		$exportbut = $we_button->create_button("export", "javascript:we_cmd('set_export',".$group.")");

		$table->setCol(4,0,array("colspan"=>"3"),
				$we_button->create_button_table(array($importbut, $exportbut))
		);

		// Import dialog
		if ($this->View->show_import_box==$group) {
			$import_options=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),14,3);

			$import_options->setCol(0,0,array("class"=>"defaultfont"),$l_newsletter["csv_delimiter"].":&nbsp;");
			$import_options->setCol(0,1,array(),htmlTextInput("csv_delimiter".$group,1,","));

			$import_options->setCol(2,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(3,0,array("class"=>"defaultfont"),$l_newsletter["csv_col"].":&nbsp;");
			$import_options->setCol(3,1,array(),htmlTextInput("csv_col".$group,2,"1"));

			$import_options->setCol(4,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(5,0,array("class"=>"defaultfont"),$l_newsletter["csv_hmcol"].":&nbsp;");
			$import_options->setCol(5,1,array(),htmlTextInput("csv_hmcol".$group,2,"2"));
			$import_options->setCol(5,2,array("class"=>"defaultgray"),"&nbsp;".$l_newsletter["csv_html_explain"]);

			$import_options->setCol(6,0,array("colspan"=>"3"),getPixel(5,5));


			$import_options->setCol(7,0,array("class"=>"defaultfont"),$l_newsletter["csv_salutationcol"].":&nbsp;");
			$import_options->setCol(7,1,array(),htmlTextInput("csv_salutationcol".$group,2,"3"));
			$import_options->setCol(7,2,array("class"=>"defaultgray"),"&nbsp;".$l_newsletter["csv_salutation_explain"]);

			$import_options->setCol(8,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(9,0,array("class"=>"defaultfont"),$l_newsletter["csv_titlecol"].":&nbsp;");
			$import_options->setCol(9,1,array(),htmlTextInput("csv_titlecol".$group,2,"4"));
			$import_options->setCol(9,2,array("class"=>"defaultgray"),"&nbsp;".$l_newsletter["csv_title_explain"]);

			$import_options->setCol(10,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(11,0,array("class"=>"defaultfont"),$l_newsletter["csv_firstnamecol"].":&nbsp;");
			$import_options->setCol(11,1,array(),htmlTextInput("csv_firstnamecol".$group,2,"5"));
			$import_options->setCol(11,2,array("class"=>"defaultgray"),"&nbsp;".$l_newsletter["csv_firstname_explain"]);

			$import_options->setCol(12,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(13,0,array("class"=>"defaultfont"),$l_newsletter["csv_lastnamecol"].":&nbsp;");
			$import_options->setCol(13,1,array(),htmlTextInput("csv_lastnamecol".$group,2,"6"));
			$import_options->setCol(13,2,array("class"=>"defaultgray"),"&nbsp;".$l_newsletter["csv_lastname_explain"]);


			$import_box=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),8,1);

			$import_box->setCol(0,0,array(),getPixel(10,10));
			$import_box->setCol(1,0,array(),$this->View->formFileChooser(200,"csv_file".$group,"/",""));
			$import_box->setCol(2,0,array(),getPixel(5,5));

			$import_box->setCol(3,0,array(),$we_button->create_button("upload","javascript:we_cmd('upload_csv',$group)"));

			$import_box->setCol(4,0,array(),getPixel(5,5));

			$import_box->setCol(5,0,array(),$import_options->getHtmlCode());

			$import_box->setCol(6,0,array(),getPixel(10,10));

			$ok = $we_button->create_button("ok","javascript:we_cmd('import_csv')");
			$cancel = $we_button->create_button("cancel", "javascript:we_cmd('reset_import');");

			$import_box->setCol(7,0,array("nowrap"=>null),
							$we_button->create_button_table(array($ok, $cancel))
			);

			$table->setCol(5,0,array("colspan"=>"3"),$this->View->htmlHidden("csv_import",$group).$import_box->getHtmlCode());

		}

		// Export dialog
		if ($this->View->show_export_box==$group) {

			$ok = $we_button->create_button("ok","javascript:we_cmd('export_csv')");
			$cancel = $we_button->create_button("cancel", "javascript:we_cmd('reset_import');");
			$export_box=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),4,1);



			$export_box->setCol(0,0,array(),getPixel(10,10));
			$export_box->setCol(1,0,array(),$this->View->formFileChooser(200,"csv_dir".$group,"/","","folder"));
			$export_box->setCol(2,0,array(),getPixel(5,5));

			$export_box->setCol(3,0,array("nowrap"=>null),
							$we_button->create_button_table(array($ok, $cancel))
			);

			$table->setCol(3,0,array("colspan"=>"3"),$this->View->htmlHidden("csv_export",$group).$export_box->getHtmlCode());

		}

		return $table->getHtmlCode();

	}

	function getHTMLNewsletterBlocks() {
		global $l_newsletter,$IE55,$MOZ13;

		$out = "";
		$counter = 0;

		$parts=array();
		array_push($parts,array("headline"=>"","html"=>$this->View->htmlHidden("blocks",count($this->View->newsletter->blocks)),"space"=>140,"noline"=>1));


		foreach ($this->View->newsletter->blocks as $block) {
			$content="";

			$content.=htmlFormElementTable($this->getHTMLBlockType("block".$counter."_Type",$block->Type),$l_newsletter["name"]);

			$values=array();
			$count=count($this->View->newsletter->groups)+1;

			for ($i = 1; $i < $count; $i++) {
				$values[$i]=sprintf($l_newsletter["mailing_list"],$i);
			}

			$selected=$block->Groups ? $block->Groups : "1";
			$content.=$this->View->htmlHidden("block".$counter."_Groups",$selected);
			$content.=$this->View->htmlHidden("block".$counter."_Pack",$block->Pack);

			$content.=htmlFormElementTable(htmlSelect("block".$counter."_GroupsSel",$values,5,$selected,true,"style='width:440' onChange='PopulateMultipleVar(document.we_form.block".$counter."_GroupsSel,document.we_form.block".$counter."_Groups);top.content.hot=1'"),$l_newsletter["block_lists"]);

			if ($block->Type == WENBLOCK_DOCUMENT) {
				$content.=htmlFormElementTable($this->View->formWeDocChooser(FILE_TABLE,"320",0,"block".$counter."_LinkID",$block->LinkID,"block".$counter."_LinkPath","","opener.top.content.hot=1;","text/webedition",$this->weAutoColpleter),$l_newsletter["block_document"]);
				$content.=htmlFormElementTable(we_forms::checkbox((($block->Field) ? "0" : "1"),(($block->Field) ? false : true),"block".$counter."_use_def_template",$l_newsletter["use_default"],false,"defaultfont","top.content.hot=1;if(document.we_form.block".$counter."_use_def_template.checked){ document.we_form.block".$counter."_Field.value=0; document.we_form.block".$counter."_FieldPath.value='';}"),"&nbsp;&nbsp;&nbsp;");
				$content.=htmlFormElementTable($this->View->formWeChooser(TEMPLATES_TABLE,"320",0,"block".$counter."_Field",(!is_numeric($block->Field) ? 0 : $block->Field),"block".$counter."_FieldPath","","if(opener.document.we_form.block".$counter."_use_def_template.checked) opener.document.we_form.block".$counter."_use_def_template.checked=false;opener.top.content.hot=1;","",$this->weAutoColpleter,"folder,text/weTmpl"),$l_newsletter["block_template"]);
			}

			if ($block->Type == WENBLOCK_DOCUMENT_FIELD) {
				$content.=htmlFormElementTable($this->View->formWeChooser(FILE_TABLE,"320",0,"block".$counter."_LinkID",$block->LinkID,"block".$counter."_LinkPath","","opener.we_cmd(\'switchPage\',2);opener.top.content.hot=1;","",$this->weAutoColpleter,"folder,text/webedition"),$l_newsletter["block_document"]);

				if ($block->LinkID) {
					$values=$this->View->getFields($block->LinkID,FILE_TABLE);

					if (count($values)) {
						$content.=htmlFormElementTable(htmlSelect("block".$counter."_Field",$values,1,$block->Field,"","style='width:440' OnKeyUp='top.content.hot=1;'"),$l_newsletter["block_document_field"]);
					} else {
						$content.=htmlFormElementTable(we_htmlelement::htmlDiv(array("class"=>"defaultgray"),$l_newsletter["none"]),$l_newsletter["block_document_field"]);
					}
				}
			}

			if ($block->Type == WENBLOCK_OBJECT) {
				$content.=htmlFormElementTable($this->View->formWeChooser(OBJECT_FILES_TABLE,"320",0,"block".$counter."_LinkID",$block->LinkID,"block".$counter."_LinkPath","","opener.top.content.hot=1;",(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1),$this->weAutoColpleter,"folder,objectFile"),$l_newsletter["block_object"]);
				$content.=htmlFormElementTable($this->View->formWeChooser(TEMPLATES_TABLE,"320",0,"block".$counter."_Field",(!is_numeric($block->Field) ? 0 : $block->Field),"block".$counter."_FieldPath","","opener.top.content.hot=1;","",$this->weAutoColpleter,"folder,text/weTmpl"),$l_newsletter["block_template"]);
			}

			if ($block->Type == WENBLOCK_OBJECT_FIELD) {
				$content.=htmlFormElementTable($this->View->formWeChooser(OBJECT_FILES_TABLE,"320",0,"block".$counter."_LinkID",$block->LinkID,"block".$counter."_LinkPath","","opener.we_cmd(\'switchPage\',2);opener.top.content.hot=1;",(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1),$this->weAutoColpleter,"folder,objectFile"),$l_newsletter["block_object"]);

				if ($block->LinkID) {
					$values=$this->View->getFields($block->LinkID,OBJECT_FILES_TABLE);

					if (count($values)) {
						$content.=htmlFormElementTable(htmlSelect("block".$counter."_Field",$values,1,$block->Field,false,'OnChange="top.content.hot=1;"'),$l_newsletter["block_object_field"]);
					} else {
						$content.=htmlFormElementTable(we_htmlelement::htmlDiv(array("class"=>"defaultgray"),$l_newsletter["none"]),$l_newsletter["block_document_field"]);
					}
				}
			}

			if ($block->Type == WENBLOCK_FILE) {
				$content.=htmlFormElementTable($this->View->formFileChooser("320","block".$counter."_Field",(is_numeric($block->Field) ? "" : ((substr($block->Field,0,1)!="/") ? "" : $block->Field))),$l_newsletter["block_file"]);
			}

			if ($block->Type == WENBLOCK_TEXT) {
				$attribs=array();
				$attribs["wysiwyg"] = "on";
				$attribs["width"] = 430;
				$attribs["height"] = 200;
				$attribs["rows"] = 10;
				$attribs["cols"] = 40;
				$attribs["cols"] = 40;
				$attribs["style"] = "width:440";
				$attribs["inlineedit"] = "true";
				$attribs["bgcolor"] = "white";

				$content.=htmlFormElementTable(we_htmlElement::htmlTextArea(array("cols"=>"40","rows"=>"10","name"=>"block".$counter."_Source","onChange"=>"top.content.hot=1;","style"=>"width:440"),htmlspecialchars($block->Source)),$l_newsletter["block_plain"]);
				$content.=we_htmlelement::jsElement('',array("src"=>JS_DIR."we_textarea.js"));
				$content.=htmlFormElementTable(we_forms::weTextarea("block".$counter."_Html",$block->Html,$attribs,"","",true,"",true,true,false,true,$this->View->newsletter->Charset),$l_newsletter["block_html"]);

				$content.=we_htmlelement::jsElement('
					function extraInit(){
							if(weWysiwygInitializeIt){
								weWysiwygInitializeIt();
							}
							loaded = 1;
						}
						window.onload=extraInit;
				');

			}

			if ($block->Type == WENBLOCK_ATTACHMENT) {
				$content.=htmlFormElementTable($this->View->formWeChooser(FILE_TABLE,"320",0,"block".$counter."_LinkID",$block->LinkID,"block".$counter."_LinkPath","","","",$this->weAutoColpleter,"folder,text/xml,text/webedition,image/*,text/html,application/*,application/x-shockwave-flash,video/quicktime"),$l_newsletter["block_attachment"]);
			}

			if ($block->Type == WENBLOCK_URL) {
				$content.=htmlFormElementTable(htmlTextInput("block".$counter."_Field",49,(is_numeric($block->Field) ? "" : $block->Field),"","style='width:440'","text","0","0","top.content"),$l_newsletter["block_url"]);
			}


			if ($block->Type == WENBLOCK_URL || $block->Type == WENBLOCK_DOCUMENT || $block->Type == WENBLOCK_OBJECT) {
				$content.=htmlFormElementTable(we_forms::checkbox((($block->Pack) ? "1" : "0"),(($block->Pack) ? true : false),"block".$counter."_send_images",$l_newsletter["send_images"],false,"defaultfont","top.content.hot=1;if(document.we_form.block".$counter."_send_images.checked){ document.we_form.block".$counter."_Pack.value=1; }else{ document.we_form.block".$counter."_Pack.value=0; }"),"&nbsp;&nbsp;&nbsp;");
			}

			$we_button = new we_button();
			$buttons=getPixel(440,1);

			$plus = $we_button->create_button("image:btn_function_plus", "javascript:we_cmd('addBlock','".$counter."')");
			$trash = $we_button->create_button("image:btn_function_trash","javascript:we_cmd('delBlock','".$counter."')");

			if(sizeof($this->View->newsletter->blocks) > 1) $buttons.=$we_button->position_yes_no_cancel($plus ,$trash);
			else $buttons.=$we_button->position_yes_no_cancel($plus);

			array_push($parts,array("headline"=>sprintf($l_newsletter["block"],($counter+1)),"html"=>$content,"space"=>140));
			array_push($parts,array("headline"=>"","html"=>$buttons,"space"=>140));

			$counter++;
		}

		return we_multiIconBox::getHTML("newsletter_header","100%",$parts,30,"",-1,"","",false);
	}

	function getHTMLNewsletterGroups() {
		global $l_newsletter;

		$out="";
		$content="";
		$count=count($this->View->newsletter->groups);

		$we_button = new we_button();

		$out.=we_multiIconBox::getJS();

		for ($i = 0; $i < $count; $i++) {

			$parts = array();

			if (defined("CUSTOMER_TABLE")) {
				array_push($parts,array("headline"=>$l_newsletter["customers"],"html"=>$this->getHTMLCustomer($i),"space"=>140));
			}

			array_push($parts,array("headline"=>$l_newsletter["file_email"],"html"=>$this->getHTMLExtern($i),"space"=>140));
			array_push($parts,array("headline"=>$l_newsletter["emails"],"html"=>$this->getHTMLEmails($i),"space"=>140));


			if($i==$count-1) $plus = $we_button->create_button("image:btn_function_plus", "javascript:we_cmd('addGroup')");
			else $plus=null;
			if($count > 1)	$trash = $we_button->create_button("image:btn_function_trash","javascript:we_cmd('delGroup',".$i.")");
			else $trash=null;

			$buttons=$we_button->create_button_table(array($plus,$trash),"10",array("align"=>"right"));

			$wepos = weGetCookieVariable("but_newsletter_group_box_$i");

			$out.=	we_multiIconBox::getHTML("newsletter_group_box_$i","100%",$parts,30,"",0,"","",(($wepos=="down") || ($count<2 ? true : false)),sprintf($l_newsletter["mailing_list"],($i+1))).
						we_htmlElement::htmlBr().'<div style="margin-right:30px;">' . $buttons . '</div>';


		}

		return $out;

	}

	function getHTMLNewsletterHeader() {
		global $l_we_class,$l_newsletter;
		$parts=array();

		array_push($parts,array("headline"=>"","html"=>"","space"=>140,"noline"=>1));

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),3,1);
		$table->setCol(0,0,array(),htmlFormElementTable(htmlTextInput("Text",37,stripslashes($this->View->newsletter->Text),"",'onKeyUp="top.content.hot=1;" id="yuiAcInputPathName" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()"','text',$this->def_width),$l_newsletter["name"]));
		$table->setCol(1,0,array(),getPixel(10,10));

		$table->setCol(2,0,array(),htmlFormElementTable($this->View->formNewsletterDirChooser(($this->def_width-120),0,"ParentID",$this->View->newsletter->ParentID,"Path",dirname($this->View->newsletter->Path),"opener.top.content.hot=1;",$this->weAutoColpleter),$l_newsletter["dir"]));

		//$table->setCol(2,0,array(),htmlFormElementTable($this->View->formWeDocChooser(NEWSLETTER_TABLE,"320",0,"ParentID",$this->View->newsletter->ParentID,"Path",dirname($this->View->newsletter->Path),"opener.top.content.hot=1;","folder"),$l_newsletter["dir"]));

		array_push($parts,array("headline"=>$l_newsletter["path"],"html"=>$table->getHtmlCode(),"space"=>140));

		if(!$this->View->newsletter->IsFolder){
			$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),7,1);
			$table->setCol(0,0,array(),htmlFormElementTable(htmlTextInput("Subject",37,stripslashes($this->View->newsletter->Subject),"","onKeyUp='top.content.hot=1;'",'text',$this->def_width),$l_newsletter["subject"]));
			$table->setCol(1,0,array(),getPixel(10,10));
			$table->setCol(2,0,array(),htmlFormElementTable(htmlTextInput("Sender",37,$this->View->newsletter->Sender,"","onKeyUp='top.content.hot=1;'",'text',$this->def_width),$l_newsletter["sender"]));
			$table->setCol(3,0,array(),getPixel(10,10));

			$chk="";
			if($this->View->newsletter->Sender==$this->View->newsletter->Reply)
				$chk=we_htmlElement::htmlInput(array("type"=>"checkbox","value"=>"1","checked"=>null,"name"=>"reply_same","onClick"=>$this->topFrame.".hot=1;if(document.we_form.reply_same.checked) document.we_form.Reply.value=document.we_form.Sender.value"));
			else
				$chk=we_htmlElement::htmlInput(array("type"=>"checkbox","value"=>"0","name"=>"reply_same","onClick"=>$this->topFrame.".hot=1;if(document.we_form.reply_same.checked) document.we_form.Reply.value=document.we_form.Sender.value"));

			$table->setCol(4,0,array(),htmlFormElementTable(htmlTextInput("Reply",37,$this->View->newsletter->Reply,"","onKeyUp='top.content.hot=1;'")."&nbsp;&nbsp;".$chk."&nbsp;".we_htmlElement::htmlLabel(array("class"=>"defaultfont","onClick"=>$this->topFrame.".hot=1;if(document.we_form.reply_same.checked){document.we_form.reply_same.checked=false;}else{document.we_form.Reply.value=document.we_form.Sender.value;document.we_form.reply_same.checked=true;}",'text',$this->def_width),$l_newsletter["reply_same"]),$l_newsletter["reply"]));
			$table->setCol(5,0,array(),getPixel(10,10));

			$table->setCol(6,0,array(),htmlFormElementTable(htmlTextInput("Test",37,$this->View->newsletter->Test,"","onKeyUp='top.content.hot=1;'"),$l_newsletter["test_email"]));


			array_push($parts,array("headline"=>$l_newsletter["newsletter"],"html"=>$table->getHtmlCode(),"space"=>140));

			array_push($parts,array("headline"=>$l_newsletter["charset"],"html"=>$this->getHTMLCharsetTable(),"space"=>140));

			array_push($parts,array("headline"=>$l_newsletter["copy_newsletter"],"html"=>$this->getHTMLCopy(),"space"=>140,"noline"=>1));
		}

		return we_multiIconBox::getHTML("newsletter_header","100%",$parts,30,"",-1,"","",false).

		we_htmlElement::htmlBr();

	}

	/**
	 * Generates the body for modul frame
	 *
	 * @package weModules
	 * @subpackage Newsletter
	 * @return unknown
	 */
	function getHTMLProperties() {
		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->View->getJSProperty();
			$GLOBALS["we_body_insert"] = we_htmlElement::htmlForm(array("name"=>"we_form"),
					$this->View->getHiddens(array("ncmd"=>"home")).$this->View->htmlHidden("home","0")
			);
			$GLOBALS["mod"] = "newsletter";
			ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
		}

		$js = $this->View->getJSProperty();
		$js .=we_htmlElement::jsElement( '
					if (top.content.get_focus) {
						self.focus();
					} else {
						top.content.get_focus=1;
					}

					var countSetTitle = 0;
					function setHeaderTitle() {
						if(parent.edheader && parent.edheader.setTitlePath) {
							if(preObj  = document.getElementById("yuiAcInputPathGroup")) {
								parent.edheader.hasPathGroup = true; 
								parent.edheader.setPathGroup(preObj.value); 
							} else {
								parent.edheader.hasPathGroup = false; 
							}

							if(postObj = document.getElementById("yuiAcInputPathName")) {
								parent.edheader.hasPathName = true; 
								parent.edheader.setPathName(postObj.value); 
							} else {
								parent.edheader.hasPathName = false; 
							}
							parent.edheader.setTitlePath();
							countSetTitle = 0;
						} else {
							if(countSetTitle < 30) {
								setTimeout("setHeaderTitle()",100);
								countSetTitle++;
							/* @dd: code from version 5.0.0.7, generated on bugfix merge: */
							/* please remove if not needed any more */
							/*
							var elem1 = document.getElementById("fieldPathGroup");
							var elem2 = document.getElementById("fieldPathName");
							if (elem1 && elem2) {
								pre = document.getElementById("fieldPathGroup").value;
								post = document.getElementById("fieldPathName").value;
								if(parent.edheader && parent.edheader.setTitlePath) {
									parent.edheader.hasPathGroup = true;
									parent.edheader.setPathGroup(pre);
									parent.edheader.hasPathName = true;
									parent.edheader.setPathName(post);
									parent.edheader.setTitlePath();
									countSetTitle = 0;
								} else {
									if(countSetTitle < 30) {
										setTimeout("setHeaderTitle()",100);
										countSetTitle++;
									}
								}
							*/
							}
						}
					}
					
					function weShowMailsByStatus(status, group) {
						var maillist = document.getElementById("we_recipient"+group).options;
						switch(status) {
							case "0":
								for(var i=0; i<maillist.length; i++) {
									maillist[i].style.display="";
								}
								break;
							case "1":
								for(var i=0; i<maillist.length; i++) {
									if (maillist[i].className == "markValid") {
										maillist[i].style.display="none";
									}
								}
								break;
							default :
								//alert(status);
						}
					}
		');
		
		$css = we_htmlElement::cssElement("
	.markNotValid { background: #FFCCCC }
	.markValid { background: #FFFFFF }
");
		$out=$this->View->getHiddens();
		$out.=$this->View->newsletterHiddens();
		$out.=$this->View->getHiddensProperty();

		if($this->View->page == 0) {
			$out.=$this->weAutoColpleter->getYuiJsFiles();
			$out.=$this->View->htmlHidden("home","0");
			$out.=$this->View->htmlHidden("fromPage","0");
			
			if($this->View->newsletter->IsFolder==0){
				$out.=$this->View->getHiddensMailingPage();
				$out.=$this->View->getHiddensContentPage();
			}

			$out.=$this->getHTMLNewsletterHeader();
			$out.=$this->weAutoColpleter->getYuiCss();
			$out.=$this->weAutoColpleter->getYuiJs();

		}else if($this->View->page == 1) {
			$out.=$this->View->getHiddensPropertyPage();
			$out.=$this->View->getHiddensContentPage();

			$out.=$this->View->htmlHidden("fromPage","1");
			$out.=$this->View->htmlHidden("ncustomer","");
			$out.=$this->View->htmlHidden("nfile","");
			$out.=$this->View->htmlHidden("ngroup","");

			$out.=$this->getHTMLNewsletterGroups();
		} else {
			$out.=$this->weAutoColpleter->getYuiJsFiles();
			$out.=$this->View->getHiddensMailingPage();
			$out.=$this->View->getHiddensPropertyPage();

			$out.=$this->View->htmlHidden("fromPage","2");
			$out.=$this->View->htmlHidden("blockid",0);

			$out.=$this->getHTMLNewsletterBlocks();
			$out.=$this->weAutoColpleter->getYuiCss();
			$out.=$this->weAutoColpleter->getYuiJs();
		}

		$body=we_htmlElement::htmlBody(array("onload"=>"self.loaded=1;if(self.doScrollTo){self.doScrollTo();}; setHeaderTitle();","class"=>"weEditorBody","onunload"=>"doUnload()"),
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","onsubmit"=>"return false;"),
										$out
							)
		);

		return $this->getHTMLDocument($body,$js.$css);

	}

	function getHTMLEmailEdit() {
		global $l_newsletter;

		$vars=array("grp"=>"group","email"=>"email","htmlmail"=>"htmlmail","salutation"=>"salutation","title"=>"title","firstname"=>"firstname","lastname"=>"lastname","etyp"=>"type","eid"=>"id");

		foreach ($vars as $k=>$v) {
			if (isset($_REQUEST[$k])) {
				$$v=$_REQUEST[$k];
			} else if ($v == "htmlmail") {
				$$v=f("SELECT  pref_value FROM ".NEWSLETTER_PREFS_TABLE." WHERE pref_name='default_htmlmail'","pref_value",$this->db);
			} else {
				$$v="";
			}
		}

		$salutation=str_replace("[:plus:]","+",$salutation);
		$title=str_replace("[:plus:]","+",$title);
		$firstname=str_replace("[:plus:]","+",$firstname);
		$lastname=str_replace("[:plus:]","+",$lastname);

		$salutation=rawurldecode($salutation);
		$title=rawurldecode($title);
		$firstname=rawurldecode($firstname);
		$lastname=rawurldecode($lastname);


		$out="";
		$content="";

		$js='
			function save(){
		';

		if ($type==2) {
				$js.='opener.setAndSave(document.we_form.id.value,document.we_form.emailfield.value,document.we_form.htmlmail.value,document.we_form.salutation.value,document.we_form.title.value,document.we_form.firstname.value,document.we_form.lastname.value);
					close();';
		}else if ($type==1) {
			$js.='
				opener.editIt(document.we_form.group.value,document.we_form.id.value,document.we_form.emailfield.value,document.we_form.htmlmail.value,document.we_form.salutation.value,document.we_form.title.value,document.we_form.firstname.value,document.we_form.lastname.value);
				close();';
		} else {
			$js.='
				opener.add(document.we_form.group.value,document.we_form.emailfield.value,document.we_form.htmlmail.value,document.we_form.salutation.value,document.we_form.title.value,document.we_form.firstname.value,document.we_form.lastname.value);
				close();';
		}
		$js.='}';

		$js=we_htmlElement::jsElement($js);

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),12,3);

		$table->setCol(0,0,array("class"=>"defaultgray"),$l_newsletter["email"]);
		$table->setCol(0,1,array(),getPixel(15,10));
		$table->setCol(0,2,array(),htmlTextInput("emailfield",32,$email,"","","text",310));

		$table->setCol(1,2,array(),getPixel(2,3));

		$table->setCol(2,2,array(),we_forms::checkbox($htmlmail,(($htmlmail) ? true : false),"htmlmail",$l_newsletter["edit_htmlmail"],false,"defaultfont","if(document.we_form.htmlmail.checked) document.we_form.htmlmail.value=1; else document.we_form.htmlmail.value=0;"));

		$table->setCol(3,2,array(),getPixel(2,3));

		$salut_select=new we_htmlSelect(array("name"=>"salutation","style"=>"width: 310px"));
		$salut_select->addOption("","");
		if(!empty($this->View->settings["female_salutation"])) $salut_select->addOption($this->View->settings["female_salutation"],$this->View->settings["female_salutation"]);
		if(!empty($this->View->settings["male_salutation"])) $salut_select->addOption($this->View->settings["male_salutation"],$this->View->settings["male_salutation"]);
		$salut_select->selectOption($salutation);

		$table->setCol(4,0,array("class"=>"defaultgray"),$l_newsletter["salutation"]);
		$table->setCol(4,1,array(),getPixel(15,10));
		$table->setCol(4,2,array(),$salut_select->getHtmlCode());

		$table->setCol(5,2,array(),getPixel(2,3));

		$table->setCol(6,0,array("class"=>"defaultgray"),$l_newsletter["title"]);
		$table->setCol(6,1,array(),getPixel(15,10));
		$table->setCol(6,2,array(),htmlTextInput("title",32,$title,"","","text",310));

		$table->setCol(7,2,array(),getPixel(2,3));

		$table->setCol(8,0,array("class"=>"defaultgray"),$l_newsletter["firstname"]);
		$table->setCol(8,1,array(),getPixel(15,10));
		$table->setCol(8,2,array(),htmlTextInput("firstname",32,$firstname,"","","text",310));

		$table->setCol(9,2,array(),getPixel(2,3));

		$table->setCol(10,0,array("class"=>"defaultgray"),$l_newsletter["lastname"]);
		$table->setCol(10,1,array(),getPixel(15,10));
		$table->setCol(10,2,array(),htmlTextInput("lastname",32,$lastname,"","","text",310));

		$table->setCol(11,2,array(),getPixel(2,3));

		$we_button = new we_button();
		$close = $we_button->create_button("close","javascript:self.close();");
		$save = $we_button->create_button("save", "javascript:save();");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>"document.we_form.emailfield.select();document.we_form.emailfield.focus();"),
							we_htmlElement::htmlForm(array("name"=>"we_form","onsubmit"=>"save();return false;"),
								we_htmlElement::htmlHidden(array("name"=>"group","value"=>$group)).
								($type ?
									we_htmlElement::htmlHidden(array("name"=>"id","value"=>$id))
									:
									""
								).
								htmlDialogLayout(
									$table->getHtmlCode(),
									$type ? $l_newsletter["edit_email"] : $l_newsletter["add_email"],
									$we_button->position_yes_no_cancel($save,$close)
								)
							)
		);

		return $this->getHTMLDocument($body,$js);
	}

	function getHTMLPreview() {
		global $l_newsletter;

		$gview=0;

		if (isset($_REQUEST["gview"])) {
			$gview=$_REQUEST["gview"];
		}

		$hm=0;

		if (isset($_REQUEST["hm"])) {
			$hm=$_REQUEST["hm"];
		}

		$content="";
		$count=count($this->View->newsletter->blocks);
		for($i=0;$i<$count;$i++) $content.=$this->View->getContent($i,$gview,$hm);

		header("Pragma: no-cache;");
		header("Cache-Control: post-check=0, post-check=0, false");
		header("Content-Type: text/html; charset= " . ($this->View->newsletter->Charset!="" ? $this->View->newsletter->Charset : $GLOBALS["_language"]["charset"]) . ";");


		if (!$hm) {
			print '
				<html>
					<head>
					</head>

					<body>
						<form>
							<textarea name="foo" style="width:100%;height:95%" cols="80" rows="40">'.
								htmlspecialchars($content).
							'</textarea>
						</form>
					</body>

				</html>';
		} else {
			print $content;
		}
	}

	function getHTMLBlackList() {
		global $l_newsletter;

		$we_button = new we_button();

		$arr=array();

		if (isset($_REQUEST["black_list"])) {
			$this->View->settings["black_list"]=$_REQUEST["black_list"];
		}

		if (isset($_REQUEST["ncmd"])) {
			if($_REQUEST["ncmd"]=="save_black") $this->View->processCommands();
			$close=true;
		}


		$js=$this->View->getJSProperty().
				we_htmlElement::jsElement('
			function addBlack() {
				var p=document.forms[0].elements["blacklist_sel"];
				var newRecipient=prompt("'.$l_newsletter["add_email"].'","");

				if (newRecipient != null) {
					if (newRecipient.length > 0) {
						if (newRecipient.length > 255 ) {
							' . we_message_reporting::getShowMessageCall( $l_newsletter["email_max_len"], WE_MESSAGE_ERROR ) . '
							return;
						}

						if (!inSelectBox(p,newRecipient)) {
							addElement(p,"#",newRecipient,true);
						} else {
							' . we_message_reporting::getShowMessageCall( $l_newsletter["email_exists"], WE_MESSAGE_ERROR ) . '
						}
					} else {
						' . we_message_reporting::getShowMessageCall( $l_newsletter["no_email"], WE_MESSAGE_ERROR ) . '
					}
				}
			}

			function deleteBlack() {
				var p=document.forms[0].elements["blacklist_sel"];

				if (p.selectedIndex >= 0) {
					if (confirm("'.$l_newsletter["email_delete"].'")) {
						p.options[p.selectedIndex] = null;
					}
				}
			}

			function deleteallBlack() {
				var p=document.forms[0].elements["blacklist_sel"];

				if (confirm("'.$l_newsletter["email_delete_all"].'")) {
					p.options.length = 0;
				}
			}

			function editBlack() {
				var p=document.forms[0].elements["blacklist_sel"];
				var index=p.selectedIndex;

				if (index >= 0) {
					var editRecipient=prompt("'.$l_newsletter["edit_email"].'",p.options[index].text);

					if (editRecipient != null) {
						if (editRecipient != "") {
							if (editRecipient.length > 255 ) {
								' . we_message_reporting::getShowMessageCall( $l_newsletter["email_max_len"], WE_MESSAGE_ERROR ) . '
								return;
							}
							p.options[index].text = editRecipient;
						} else {
							' . we_message_reporting::getShowMessageCall( $l_newsletter["no_email"], WE_MESSAGE_ERROR ) . '
						}
					}
				}
			}

			function set_import(val) {
				document.we_form.sib.value=val;

				if (val == 1) {
					document.we_form.seb.value=0;
				}

				PopulateVar(document.we_form.blacklist_sel,document.we_form.black_list);
				submitForm("black_list");
			}

			function set_export(val) {
				document.we_form.seb.value=val;

				if (val == 1) {
					document.we_form.sib.value=0;
				}

				PopulateVar(document.we_form.blacklist_sel,document.we_form.black_list);
				submitForm("black_list");
			}

			self.focus();
		');

		if (isset($_REQUEST["ncmd"])) {
			if ($_REQUEST["ncmd"] == "import_black") {
				$filepath=$_REQUEST["csv_file"];
				$delimiter=$_REQUEST["csv_delimiter"];
				$col=$_REQUEST["csv_col"];

				if ($col) {
					$col--;
				}


				if(ereg("\.\.",$filepath)){
					print we_htmlElement::jsElement(
						we_message_reporting::getShowMessageCall( $l_newsletter["path_not_valid"], WE_MESSAGE_ERROR )
					);
				}
				else{
					$fh = @fopen($_SERVER["DOCUMENT_ROOT"].$filepath,"rb");
					if ($fh) {
						while ($dat = fgetcsv($fh, 1000, $delimiter)) {
							$_alldat = implode("",$dat);
							if (str_replace(" ", "", $_alldat)=="") {
								continue;
							}							
							$row[]=	$dat[$col];
						}

						fclose($fh);

						if(!empty($row)) {
							if ($this->View->settings["black_list"] == "") {
								$this->View->settings["black_list"]=makeCSVFromArray($row);
							} else {
								$this->View->settings["black_list"].=",".makeCSVFromArray($row);
							}
						}
					}
					else{
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall( $l_newsletter["path_not_valid"], WE_MESSAGE_ERROR )
						);
					}
				}

			}
		}

		if (isset($_REQUEST["ncmd"])) {
			if ($_REQUEST["ncmd"] == "export_black") {
				if ($_REQUEST["csv_dir"] == "/") {
					$fname="/blacklist_export_".time().".csv";
				} else {
					$fname=$_REQUEST["csv_dir"]."/blacklist_export_".time().".csv";
				}
				weFile::save($_SERVER["DOCUMENT_ROOT"].$fname,str_replace(",","\n",$this->View->settings["black_list"]));

				$js.=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));
				$js.=we_htmlElement::jsElement('
						new jsWindow("'.$this->frameset.'?pnt=export_csv_mes&lnk='.$fname.'","edit_email",-1,-1,440,250,true,true,true,true);'
				);

			}
		}

		$arr=makeArrayFromCSV($this->View->settings["black_list"]);


		$buttons_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),7,1);
		$buttons_table->setCol(0,0,array(),$we_button->create_button("add", "javascript:addBlack();"));
		$buttons_table->setCol(1,0,array(),getPixel(1,5));
		$buttons_table->setCol(2,0,array(),$we_button->create_button("edit", "javascript:editBlack();"));
		$buttons_table->setCol(3,0,array(),getPixel(1,5));
		$buttons_table->setCol(4,0,array(),$we_button->create_button("delete", "javascript:deleteBlack()"));
		$buttons_table->setCol(5,0,array(),getPixel(1,5));
		$buttons_table->setCol(6,0,array(),$we_button->create_button("delete_all", "javascript:deleteallBlack()"));


		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),5,3);
		$table->setCol(0,0,array("valign"=>"middle"),htmlSelect("blacklist_sel",$arr,10,"",false,'style="width:388px"',"value","600"));
		$table->setCol(0,1,array("valign"=>"middle"),getPixel(10,12));
		$table->setCol(0,2,array("valign"=>"top"),$buttons_table->getHtmlCode());

		$table->setCol(1,0,array("colspan"=>"3"),getPixel(5,10));

		$importbut = $we_button->create_button("import","javascript:set_import(1)");
		$exportbut = $we_button->create_button("export", "javascript:set_export(1)");

		$table->setCol(2,0,array("colspan"=>"3"),
				$we_button->create_button_table(array($importbut, $exportbut))
		);

		if (isset($_REQUEST["sib"])) {
			$sib=$_REQUEST["sib"];
		} else {
			$sib=0;
		}

		if (isset($_REQUEST["seb"])) {
			$seb=$_REQUEST["seb"];
		} else {
			$seb=0;
		}

		if ($sib) {

			$import_options=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),5,2);

			$import_options->setCol(0,0,array("class"=>"defaultfont"),$l_newsletter["csv_delimiter"].":&nbsp;");
			$import_options->setCol(0,1,array(),htmlTextInput("csv_delimiter",1,","));

			$import_options->setCol(2,0,array("colspan"=>"3"),getPixel(5,5));

			$import_options->setCol(3,0,array("class"=>"defaultfont"),$l_newsletter["csv_col"].":&nbsp;");
			$import_options->setCol(3,1,array(),htmlTextInput("csv_col",2,"1"));

			$import_options->setCol(4,0,array("colspan"=>"3"),getPixel(5,5));


			$import_box=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),8,1);

			$import_box->setCol(0,0,array(),getPixel(10,10));
			$import_box->setCol(1,0,array(),$this->View->formFileChooser(200,"csv_file","/",""));
			$import_box->setCol(2,0,array(),getPixel(5,5));

			$import_box->setCol(3,0,array(),$we_button->create_button("upload","javascript:we_cmd('upload_black')"));

			$import_box->setCol(4,0,array(),getPixel(5,5));

			$import_box->setCol(5,0,array(),$import_options->getHtmlCode());

			$import_box->setCol(6,0,array(),getPixel(10,10));

			$ok = $we_button->create_button("ok","javascript:document.we_form.sib.value=0;we_cmd('import_black');");
			$cancel = $we_button->create_button("cancel", "javascript:set_import(0);");

			$import_box->setCol(7,0,array("nowrap"=>null),
							$we_button->create_button_table(array($ok, $cancel))
			);

			$table->setCol(3,0,array("colspan"=>"3"),
					$this->View->htmlHidden("csv_import","1").
					$import_box->getHtmlCode()
			);
		}

		if ($seb) {

			$ok = $we_button->create_button("ok","javascript:document.we_form.seb.value=0;we_cmd('export_black');");
			$cancel = $we_button->create_button("cancel", "javascript:set_export(0);");
			$export_box=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),4,1);

			$export_box->setCol(0,0,array(),getPixel(10,10));
			$export_box->setCol(1,0,array(),$this->View->formFileChooser(200,"csv_dir","/","","folder"));
			$export_box->setCol(2,0,array(),getPixel(5,5));

			$export_box->setCol(3,0,array("nowrap"=>null),
							$we_button->create_button_table(array($ok, $cancel))
			);

			$table->setCol(3,0,array("colspan"=>"3"),
				$this->View->htmlHidden("csv_export","1").
				$export_box->getHtmlCode()
			);
		}

		$out=$this->View->htmlHidden("sib",$sib);
		$out.=$this->View->htmlHidden("seb",$seb);


		$we_button = new we_button();
		$cancel = $we_button->create_button("cancel","javascript:self.close();");
		$save = $we_button->create_button("save", "javascript:we_cmd('save_black')");


		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form","onsubmit"=>"save();return false;"),
								$this->View->getHiddens().
								$this->View->htmlHidden("black_list",$this->View->settings["black_list"]).
								$this->View->htmlHidden("sib",$sib).
								$this->View->htmlHidden("seb",$seb).
								htmlDialogLayout(
									$table->getHtmlCode(),
									$l_newsletter["black_list"],
									$we_button->position_yes_no_cancel($save,null,$cancel)
								)
							)
		);

		return $this->getHTMLDocument($body,$js);


	}

	function getHTMLUploadCsv($js = "javascript:we_cmd('do_upload_csv');") {
		global $l_newsletter;

		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");

		$we_button = new we_button();
		$cancel = $we_button->create_button("cancel","javascript:self.close();");
		$upload = $we_button->create_button("upload", $js);

		$buttons = $we_button->create_button_table(array($cancel, $upload));

		$js=$this->View->getJSProperty();
		$js.=we_htmlElement::jsElement('
					self.focus();
		');

		$maxsize = getUploadMaxFilesize(true);

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),4,1);
		if($maxsize){
			$table->setCol(0,0,array("style"=>"padding-right:30px"),htmlAlertAttentionBox(sprintf($l_newFile["max_possible_size"],round($maxsize / (1024*1024),3)."MB"),1));
			$table->setCol(1,0,array(),getPixel(2,10));
		}else{
			$table->setCol(0,0,array(),getPixel(2,10));
			$table->setCol(1,0,array(),getPixel(2,10));
		}
		$table->setCol(2,0,array("valign"=>"middle"),we_htmlElement::htmlInput(array("name"=>"we_File","TYPE"=>"file","size"=>"35")));

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form", "method"=>"post","enctype"=>"multipart/form-data"),
								we_htmlElement::htmlCenter(
									$this->View->getHiddens().
									(isset($_REQUEST["grp"]) ? $this->View->htmlHidden("group",$_REQUEST["grp"]) : "").
									$this->View->htmlHidden("MAX_FILE_SIZE","8388608").
									htmlDialogLayout($table->getHtmlCode(),$l_newsletter["csv_upload"],$buttons,"100%","30","","hidden")
								)
							)
		);

		return $this->getHTMLDocument($body,$js);

	}

	function getHTMLExportCsvMessage($mode=0){
		global $l_newsletter;

		if (isset($_REQUEST["lnk"])) {
			$link=$_REQUEST["lnk"];
		}

		if (isset($link)) {
			$port = defined("HTTP_PORT") ? HTTP_PORT : 80;
			$down = getServerProtocol(true).SERVER_NAME.":".$port.$link;

			$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),7,1);

			$table->setCol(0,0,array(),getPixel(5,5));

			$table->setCol(1,0,array("class"=>"defaultfont"),sprintf($l_newsletter["csv_export"],$link));

			$table->setCol(2,0,array(),getPixel(5,10));

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weBrowser.class.php');


			$table->setCol(3,0,array("class"=>"defaultfont"),weBrowser::getDownloadLinkText());
			$table->setCol(4,0,array(),getPixel(5,10));
			$table->setCol(5,0,array("class"=>"defaultfont"),
				we_htmlElement::htmlA(array("href"=>$down),
					$l_newsletter["csv_download"]
				)
			);
			$table->setCol(6,0,array(),getPixel(100,5));

		if($mode==1){

			$table->addRow(3);
			$table->setCol(7,0,array(),getPixel(100,10));
			$table->setCol(8,0,array("class"=>"defaultfont"),
				we_htmlElement::htmlB($l_newsletter["clearlog_note"])
			);
			$table->setCol(9,0,array(),getPixel(100,15));

		}

		$we_button = new we_button();

		if($mode==1){
			$cancel = $we_button->create_button("cancel","javascript:self.close();");
			$ok = $we_button->create_button("ok", "javascript:clearLog();");
		}else{
			$close = $we_button->create_button("close","javascript:self.close();");
		}


		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
								we_htmlElement::htmlHidden(array("name"=>"group","value"=>(isset($group) ? $group : ""))).


								(($mode==1) ?
										$this->View->htmlHidden("pnt","clear_log").
										$this->View->htmlHidden("ncmd","do_clear_log").
										htmlDialogLayout(
														$table->getHtmlCode(),
														$l_newsletter["clear_log"],
														$we_button->position_yes_no_cancel($ok,null,$cancel),"100%","30","","hidden")
									:
										htmlDialogLayout(
														$table->getHtmlCode(),
														$l_newsletter["csv_download"],
														$we_button->position_yes_no_cancel(null,$close,null),"100%","30","","hidden")
								).
								we_htmlElement::jsElement("self.focus();")
							)
		);

		if($mode==1)
			return $body;
		else
			return $this->getHTMLDocument($body);

		}


	}

	/**
	 * Edit csv mail list
	 *
	 * @package weModules
	 * @subpackage Newsletter
	 * @param String $open_file
	 * @return String
	 */
	function getHTMLEditFile($open_file=""){
		global $l_newsletter;
		$db=new DB_WE;

		$out="";
		$we_button = new we_button();

		$headlines=array();
		$content=array();

		$headlines[0]["dat"]=$l_newsletter["email"];
		$headlines[1]["dat"]=$l_newsletter["edit_htmlmail"];
		$headlines[2]["dat"]=$l_newsletter["salutation"];
		$headlines[3]["dat"]=$l_newsletter["title"];
		$headlines[4]["dat"]=$l_newsletter["firstname"];
		$headlines[5]["dat"]=$l_newsletter["lastname"];
		$headlines[6]["dat"]=$l_newsletter["edit"];
		$headlines[7]["dat"]=$l_newsletter["status"];


		$csv_file = isset($_REQUEST["csv_file"]) ? $_REQUEST["csv_file"] : "";
		$emails=array();
		$emailkey=array();
		if(!ereg("\.\.",$csv_file)){
			if($csv_file) $emails=weNewsletter::getEmailsFromExtern2($csv_file,null,null,null,(isset($_REQUEST['weEmailStatus'])?$_REQUEST['weEmailStatus']:0),$emailkey);
		}
		else{
			print we_htmlElement::jsElement(
				we_message_reporting::getShowMessageCall( $l_newsletter["path_not_valid"], WE_MESSAGE_ERROR )
			);
		}

		$offset = isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0;
		$art = isset($_REQUEST["art"]) ? $_REQUEST["art"] : "";
		$order = isset($_REQUEST["order"]) ? $_REQUEST["order"] : "";
		$numRows = isset($_REQUEST["numRows"]) ? $_REQUEST["numRows"] : 15;

		$anz = count($emails);


		if($offset<0) $offset=0;
		$endRow=$offset+$numRows;
		if($endRow>$anz) $endRow=$anz;

		$counter=0;
		$emails = array_reverse($emails, true);
		foreach($emails as $k=>$cols){
			if($k>=$offset && $k<$endRow){

				$edit = $we_button->create_button("image:btn_edit_edit", "javascript:editEmailFile(".$emailkey[$k].",'".$cols[0]."','".$cols[1]."','".$cols[2]."','".$cols[3]."','".$cols[4]."','".$cols[5]."')");
				$trash = $we_button->create_button("image:btn_function_trash","javascript:delEmailFile(".$emailkey[$k].",'".$cols[0]."')");

				$content[$counter]=array();
				$content[$counter][0]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[0]?$cols[0]:"&nbsp;"));
				$content[$counter][0]["height"]="";
				$content[$counter][0]["align"]="";

				$content[$counter][1]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[1] ? $l_newsletter["yes"] : $l_newsletter["no"]));
				$content[$counter][1]["height"]="";
				$content[$counter][1]["align"]="";

				$content[$counter][2]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[2]?$cols[2]:"&nbsp;"));
				$content[$counter][2]["height"]="";
				$content[$counter][2]["align"]="right";

				$content[$counter][3]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[3]?$cols[3]:"&nbsp;"));
				$content[$counter][3]["height"]="";
				$content[$counter][3]["align"]="left";

				$content[$counter][4]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[4]?$cols[4]:"&nbsp;"));
				$content[$counter][4]["height"]="";
				$content[$counter][4]["align"]="left";

				$content[$counter][5]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),($cols[5]?$cols[5]:"&nbsp;"));
				$content[$counter][5]["height"]="";
				$content[$counter][5]["align"]="left";

				$content[$counter][6]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),$we_button->create_button_table(array($edit, $trash)));
				$content[$counter][6]["height"]="";
				$content[$counter][6]["align"]="left";

				$iconFolder = "/webEdition/images/icons/";
				$content[$counter][7]["dat"]=we_htmlElement::htmlDiv(array("class"=>"middlefont"),we_htmlElement::htmlImg(array("src"=>$iconFolder.(we_check_email($cols[0]) ? "valid.gif" : "invalid.gif"))));
				$content[$counter][7]["height"]="";
				$content[$counter][7]["align"]="center";

				$counter++;
			}
		}

		$js=$this->View->getJSProperty();
		$js.=we_htmlElement::jsElement('
			self.focus();
			function editEmailFile(eid,email,htmlmail,salutation,title,firstname,lastname){
				new jsWindow("'.$this->frameset.'?pnt=eemail&eid="+eid+"&etyp=2&email="+email+"&htmlmail="+htmlmail+"&salutation="+salutation+"&title="+title+"&firstname="+firstname+"&lastname="+lastname,"edit_email",-1,-1,430,270,true,true,true,true);
			}

			function setAndSave(eid,email,htmlmail,salutation,title,firstname,lastname){

				var fr=document.we_form;
				fr.nrid.value=eid;
				fr.email.value=email;
				fr.htmlmail.value=htmlmail;
				fr.salutation.value=salutation;
				fr.title.value=title;
				fr.firstname.value=firstname;
				fr.lastname.value=lastname;

				fr.ncmd.value="save_email_file";

				submitForm("edit_file");

			}

			function listFile(){
				var fr=document.we_form;
				fr.nrid.value="";
				fr.email.value="";
				fr.htmlmail.value="";
				fr.salutation.value="";
				fr.title.value="";
				fr.firstname.value="";
				fr.lastname.value="";
				fr.offset.value=0;

				submitForm("edit_file");
			}

			function delEmailFile(eid,email){
				var fr=document.we_form;
				if(confirm(sprintf("'.$l_newsletter["del_email_file"].'",email))){
					fr.nrid.value=eid;
					fr.ncmd.value="delete_email_file";
					submitForm("edit_file");
				}
			}
			
			function postSelectorSelect(wePssCmd) {
				switch(wePssCmd) {
					case "selectFile":
						listFile();
						break;
				}
			}
		');


		$close = $we_button->create_button("close", "javascript:self.close()");
		$edit = $we_button->create_button("edit","javascript:listFile()");


		$chooser=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),2,1);
		$chooser->setCol(0,0,array(),getPixel(10,10));
		$chooser->setCol(1,0,array(),$this->View->formFileChooser(420,"csv_file",($open_file!="" ? $open_file : ($csv_file ? $csv_file : "/")),"","",'readonly="readonly" onchange="alert(100)"'));
		//$chooser->setCol(2,0,array(),getPixel(5,15));
		//$chooser->setCol(3,0,array(),$we_button->create_button_table(array($close,$edit)));
		//$chooser->setCol(4,0,array(),getPixel(5,15));


		$nextprev=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),1,5);

		if($offset){
			$colcontent=$we_button->create_button("back", "javascript:document.we_form.offset.value=".($offset-$numRows).";submitForm('edit_file');");
		}else{
			$colcontent=$we_button->create_button("back", "#", false, 100, 22, "", "", true);
		}


		$nextprev->setCol(0,0,array(),$colcontent);

		$nextprev->setCol(0,1,array(),getPixel(10,5));


		if( ($anz-$offset) < $numRows){
			$colcontent=( $anz ? $offset+1 : 0 )."-".$anz.
								getPixel(5,1).
								$GLOBALS["l_global"]["from"].
								getPixel(5,1).
								$anz;
		}else{
			$colcontent=( $anz ? $offset+1 : 0 )."-".$offset+$numRows.
								getPixel(5,1).
								$GLOBALS["l_global"]["from"].
								getPixel(5,1).
								$anz;
		}

		$nextprev->setCol(0,2,array("class"=>"defaultfont"),
					we_htmlElement::htmlB($colcontent)
		);

		$nextprev->setCol(0,3,array(),getPixel(10,5));

		if(($offset+$numRows) < $anz){
			$colcontent=$we_button->create_button("next", "javascript:document.we_form.offset.value=".($offset+$numRows).";submitForm('edit_file');");
		}else{
			$colcontent=$we_button->create_button("next", "#", false, 100, 22, "", "", true);
		}


		$nextprev->setCol(0,4,array(),
					$colcontent
		);
		if(count($emails)){
			$add = $we_button->create_button("image:function_plus", "javascript:editEmailFile(".count($emails).",'','','','','','')");
			$end=$nextprev->getHtmlCode();

			$nextprev->addCol(6);

			$nextprev->setCol(0,5,array(),getPixel(20,1));
			$nextprev->setCol(0,6,array("class"=>"defaultfont"),
					we_htmlElement::htmlB($l_newsletter["show"])." ".htmlTextInput("numRows",5,$numRows)
			);
			$selectStatus = we_htmlElement::htmlB($l_newsletter["status"])." ".htmlSelect("weEmailStatus",array($l_newsletter["statusAll"],$l_newsletter["statusInvalid"]),"",(isset($_REQUEST['weEmailStatus'])?$_REQUEST['weEmailStatus']:"0"),"","onchange='listFile();'","value","150");
			$nextprev->setCol(0,7,array(),getPixel(20,1));
			$nextprev->setCol(0,8,array("class"=>"defaultfont"),$selectStatus);
			$nextprev->setCol(0,9,array(),getPixel(20,1));
			$nextprev->setCol(0,10,array("class"=>"defaultfont"),
					$add
			);

			$out=	$nextprev->getHtmlCode().
						getPixel(5,5).
						htmlDialogBorder3(650,300,$content,$headlines).
						getPixel(5,5).
						$end;
		} else {
		    $_nlMessage = (!$csv_file && empty($csv_file) && strlen($csv_file)<4) ? $l_newsletter["no_file_selected"] : $l_newsletter["file_is_empty"];
			$out=we_htmlElement::htmlDiv(array("class"=>"middlefontgray","align"=>"center"),"--&nbsp;".$_nlMessage."&nbsp;--");
		}


		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>($open_file!="" ?  "submitForm('edit_file')" : "" )),
							we_htmlElement::htmlForm(array("name"=>"we_form"),
									$this->View->htmlHidden("ncmd","edit_file").
									$this->View->htmlHidden("pnt","edit_file").
									$this->View->htmlHidden("order",$order).
									$this->View->htmlHidden("offset",$offset).
									$this->View->htmlHidden("nrid","").
									$this->View->htmlHidden("email","").
									$this->View->htmlHidden("htmlmail","").
									$this->View->htmlHidden("salutation","").
									$this->View->htmlHidden("title","").
									$this->View->htmlHidden("firstname","").
									$this->View->htmlHidden("lastname","").
									$this->View->htmlHidden("etyp","").
									$this->View->htmlHidden("eid","").

									//$we_button->create_button_table(array($close,$edit)).

									htmlDialogLayout($chooser->getHtmlCode().'<br>'.$out,$l_newsletter["select_file"],$we_button->create_button_table(array($close,$edit)),"100%","30","597")


							)
		);

		return $this->getHTMLDocument($body,$js);

	}

	function getHTMLClearLog(){
		global $l_newsletter;

		protect();

		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");

		if(isset($_REQUEST["ncmd"])){
			if($_REQUEST["ncmd"]=="do_clear_log"){
				$this->View->db->query("DELETE FROM ".NEWSLETTER_LOG_TABLE);
				return
					we_htmlElement::jsElement("", array("src" => JS_DIR . "we_showMessage.js")) .
					we_htmlElement::jsElement(
						we_message_reporting::getShowMessageCall( $l_newsletter["log_is_clear"], WE_MESSAGE_NOTICE )
						. 'self.close();'
					);
			}
		}

		$js=we_htmlElement::jsElement('
			function clearLog(){
					var f = self.document.we_form;
					f.action = "'.$this->frameset.'";
					f.method = "post";
					f.submit();
			}
		');

		$csv="";
		$this->View->db->query("SELECT ".NEWSLETTER_TABLE.".Text as NewsletterName, ".NEWSLETTER_LOG_TABLE.".* FROM ".NEWSLETTER_TABLE.",".NEWSLETTER_LOG_TABLE." WHERE ".NEWSLETTER_TABLE.".ID=".NEWSLETTER_LOG_TABLE.".NewsletterID;");
		while($this->View->db->next_record()){
			$csv.=$this->View->db->f("NewsletterName").",".date($l_we_editor_info["date_format"],$this->View->db->f("LogTime")).",".(isset($l_newsletter[$this->View->db->f("Log")]) ? (sprintf($l_newsletter[$this->View->db->f("Log")],$this->View->db->f("Param"))) : $this->View->db->f("Log"))."\n";
		}

		$link="/webEdition/we_backup/download/log_".time().".csv";
		if(!weFile::save($_SERVER["DOCUMENT_ROOT"].$link,$csv)) $link="";

		$_REQUEST["lnk"]=$link;

		return $this->getHTMLDocument( $this->getHTMLExportCsvMessage(1),$js);


	}

	function getHTMLSendWait(){
		global $l_newsletter;

		if(isset($_REQUEST["nid"])) $nid=$_REQUEST["nid"];
		else $nid=0;
		if(isset($_REQUEST["test"])) $test=$_REQUEST["test"];
		else $test=0;

		$js=we_htmlElement::jsElement('
			self.focus();
		');
		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>"setTimeout('document.we_form.submit()',200)"),
							we_htmlElement::htmlForm(array("name"=>"we_form"),
									$this->View->htmlHidden("pnt","send_frameset").
									$this->View->htmlHidden("nid",$nid).
									$this->View->htmlHidden("test",$test).
									we_htmlElement::htmlCenter(
										we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."/e_busy.gif")).
										we_htmlElement::htmlBr().
										we_htmlElement::htmlBr().
										we_htmlElement::htmlDiv(array("class"=>"header_small"),$l_newsletter["prepare_newsletter"])
									)
							)
		);
		return $this->getHTMLDocument($body,$js);
	}


	function getHTMLSendFrameset(){


		if(isset($_REQUEST["nid"])) $nid=$_REQUEST["nid"];
		else $nid=0;

		if(isset($_REQUEST["test"])) $test=$_REQUEST["test"];
		else $test=0;

		$this->View->newsletter=new weNewsletter($nid);
		$ret=$this->View->cacheNewsletter();


		$_offset = 	($this->View->newsletter->Offset!=0) ? ($this->View->newsletter->Offset+1) : 0;
		$_step = $this->View->newsletter->Step;

		if($this->View->settings['send_step'] <= $_offset){
			$_step++;
			$_offset=0;
		}


		$head=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));
		$head.=we_htmlElement::jsElement('
			function yes(){
				doSend('. $_offset .','. $_step .');
			}

			function no(){
				doSend(0,0);
			}
			function cancel(){
				self.close();
			}

			function ask(start,group){
				new jsWindow("'.$this->View->frameset.'?pnt=qsend&start="+start+"&grp="+group,"send_question",-1,-1,400,200,true,true,true,false);
			}

			function doSend(start,group){
				self.focus();
				top.send_cmd.location="'.$this->frameset.'?pnt=send_cmd&nid='.$nid.'&test='.$test.'&blockcache='.$ret["blockcache"].'&emailcache='.$ret["emailcache"].'&ecount='.$ret["ecount"].'&gcount='.$ret["gcount"].'&start="+start+"&egc="+group;
			}
			self.focus();
		');

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

		$frameset->setAttributes(array("rows"=>(($_SESSION["prefs"]["debug_normal"] != 0) ? "*,80,80" : "*,0,0"),"onLoad"=>(($this->View->newsletter->Step!=0 || $this->View->newsletter->Offset!=0) ? "ask(".$this->View->newsletter->Step.",".$this->View->newsletter->Offset.");" : "no();")));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=send_body&test=$test","name"=>"send_body","scrolling"=>"no","noresize"=>null));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=send_cmd","name"=>"send_cmd","scrolling"=>"no"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=send_control&nid=$nid&test=$test&blockcache=".$ret["blockcache"]."&emailcache=".$ret["emailcache"]."&ecount=".$ret["ecount"]."&gcount=".$ret["gcount"],"name"=>"send_control","scrolling"=>"no"));

		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return $this->getHTMLDocument($body,$head);

	}


	function getHTMLSendBody(){
			global $l_newsletter;

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");

			$details="";

			if(isset($_REQUEST["pro"]))  $pro=$_REQUEST["pro"];
			else $pro=0;

			$pb=new we_progressBar((int)$pro);
			$pb->setStudLen(400);
			$pb->addText($l_newsletter["sending"],0,"title");

			$we_button = new we_button();

			$_textarea = we_htmlElement::htmlTextarea(array("name"=>"details","cols"=>"60","rows"=>"15","style"=>"width:530px;height:300px;"),
						htmlspecialchars($details)
					);
			$_footer = 	'<table width="580" border="0" cellpadding="0" cellspacing="0"><tr><td align="left">' .
							$pb->getHTML(). '</td><td align="right">' .
							$we_button->create_button("close","javascript:top.close();") .
							'</td></tr></table>';

			$_content = htmlDialogLayout($_textarea,$l_newsletter["details"],$_footer);


			if(isset($_REQUEST["test"])){
				if($_REQUEST["test"])	$details=$l_newsletter["test_no_mail"];
				else $details=$l_newsletter["sending"];
			}
			else $details=$l_newsletter["sending"];

			$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
								$pb->getJS().
								$_content
							).
							we_htmlElement::jsElement('
									document.we_form.details.value="'.$details.'";
									document.we_form.details.value=document.we_form.details.value+"\n"+"'.$l_newsletter["campaign_starts"].'";
							')
			);


			return $this->getHTMLDocument($body);

	}


	//---------------------------------------------------------------------------------------


	function getHTMLSendCmd(){
		global $l_newsletter;
		include_once(WE_NEWSLETTER_MODULE_DIR . "weNewsletterMailer.php");

		if(isset($_REQUEST["nid"])) $nid=$_REQUEST["nid"];
		else return;

		if(isset($_REQUEST["test"])) $test=$_REQUEST["test"];
		else $test=0;

		if(isset($_REQUEST["start"])) $start=$_REQUEST["start"];
		else $start=0;

		// to calc progress ------------------
		// total number of emails
		if(isset($_REQUEST["ecount"]))  $ecount=$_REQUEST["ecount"];
		else $ecount=0;
		// counter
		if(isset($_REQUEST["ecs"])) $ecs=$_REQUEST["ecs"];
		else $ecs=0;
		//-----------------------------------

		if(isset($_REQUEST["blockcache"])) $blockcache=$_REQUEST["blockcache"];
		else $blockcache=0;

		// emails cache -----------------------
		if(isset($_REQUEST["emailcache"])) $emailcache=$_REQUEST["emailcache"];
		else $emailcache=0;
		//
		if(isset($_REQUEST["egc"])) $egc=$_REQUEST["egc"];
		else $egc=0;
		//
		if(isset($_REQUEST["gcount"])) $gcount=$_REQUEST["gcount"];
		else $gcount=0;
		//-----------------------------------

		if(isset($_REQUEST["reload"])) $reload=$_REQUEST["reload"];
		else $reload=0;

		if(isset($_REQUEST["retry"])) $retry=$_REQUEST["retry"];
		else $retry=0;


		$this->View->newsletter=new weNewsletter($nid);
		if($retry){
			$egc=$this->View->newsletter->Step;
			$start=$this->View->newsletter->Offset;
			if($start) $start++;
			$this->View->newsletter->addLog("retry");
			print "RETRY $nid: $egc-$ecs<br>";flush();
		}


		$js=we_htmlElement::jsElement('
			function updateText(text){
				top.send_body.document.we_form.details.value=top.send_body.document.we_form.details.value+"\n"+text;
			}

			function checkTimeout(){
				return document.we_form.ecs.value;
			}

			function initControl(){
				if(top.send_control.init) top.send_control.init();
			}

			self.focus();

		');

		$body=we_htmlElement::htmlBody(array("marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10","onLoad"=>"initControl()"),
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
						we_htmlElement::htmlHidden(array("name"=>"nid","value"=>$nid)).
						we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"send_cmd")).
						we_htmlElement::htmlHidden(array("name"=>"test","value"=>$test)).
						we_htmlElement::htmlHidden(array("name"=>"blockcache","value"=>$blockcache)).
						we_htmlElement::htmlHidden(array("name"=>"emailcache","value"=>$emailcache)).
						we_htmlElement::htmlHidden(array("name"=>"ecount","value"=>$ecount)).
						we_htmlElement::htmlHidden(array("name"=>"gcount","value"=>$gcount)).
						we_htmlElement::htmlHidden(array("name"=>"egc","value"=>$egc+1)).
						we_htmlElement::htmlHidden(array("name"=>"ecs","value"=>$ecs)).
						we_htmlElement::htmlHidden(array("name"=>"reload","value"=>1))
					)
		);
		print $this->getHTMLDocument($body,$js);
		flush();

		if($gcount<=$egc){
			$cc=0;
			while(true){
				if(file_exists(WE_NEWSLETTER_CACHE_DIR . $blockcache."_p_".$cc)) weFile::delete(WE_NEWSLETTER_CACHE_DIR . $blockcache."_p_".$cc);
				else break;
				if(file_exists(WE_NEWSLETTER_CACHE_DIR . $blockcache."_h_".$cc)) {
					$_buffer = @unserialize(weFile::load(WE_NEWSLETTER_CACHE_DIR . $blockcache."_h_".$cc));
					if(is_array($_buffer) && isset($_buffer['inlines'])) {
						foreach ($_buffer['inlines'] as $_fn) {
							if(file_exists($_fn)) {
								weFile::delete($_fn);
							}
						}
					}
					weFile::delete(WE_NEWSLETTER_CACHE_DIR . $blockcache."_h_".$cc);
				}
				else break;
				$cc++;
			}
			print we_htmlElement::jsElement('
				top.send_control.location="'.WEBEDITION_DIR.'/html/blank.html";
				top.send_body.setProgress(100);
				top.send_body.setProgressText("title","<font color=\"#006699\"><b>'.$l_newsletter["finished"].'</b></font>",2);
				updateText("'.$l_newsletter["campaign_ends"].'");
			');
			$this->View->db->query("UPDATE ".NEWSLETTER_TABLE." SET Step='0',Offset='0' WHERE ID=".$this->View->newsletter->ID);
			if(!$test) $this->View->newsletter->addLog("log_end_send");
			return;
		}

		if($start && !$test && !$reload){
			$this->View->newsletter->addLog("log_continue_send");
		}
		else if(!$test && !$reload){
			$this->View->newsletter->addLog("log_start_send");
		}

		$content="";

		$emails=$this->View->getFromCache($emailcache."_".$egc);
		$end=count($emails);

		for($j=$start;$j<$end;$j++){
			$email=$emails[$j][0];

			$user_groups=explode(",",$emails[$j][6]);
			$user_blocks=$emails[$j][7];

			sort($user_blocks);
			$user_blocks=array_unique($user_blocks);

			$htmlmail=isset($emails[$j][1]) ? str_replace("\r","",str_replace("\n","",$emails[$j][1])) : "";
			$salutation=isset($emails[$j][2]) ? str_replace("\r","",str_replace("\n","",$emails[$j][2])) : "";
			$title=isset($emails[$j][3]) ? str_replace("\r","",str_replace("\n","",$emails[$j][3])) : "";
			$firstname=isset($emails[$j][4]) ? str_replace("\r","",str_replace("\n","",$emails[$j][4])) : "";
			$lastname=isset($emails[$j][5]) ? str_replace("\r","",str_replace("\n","",$emails[$j][5])) : "";

			$contentDefault="";
			$content_plainDefault="";
			$contentF="";
			$contentF_plain="";
			$contentM="";
			$contentM_plain="";
			$contentTFL="";
			$contentTFL_plain="";
			$contentTL="";
			$contentTL_plain="";
			$contentFL="";
    		$contentFL_plain="";
			$contentLN="";
			$contentLN_plain="";
			$contentFN="";
			$contentFN_plain="";

			$atts=array();

			foreach($user_groups as $user_group){
				$atts=array_merge($atts,$this->View->getAttachments($user_group));
			}

			$inlines=array();

			foreach($user_blocks as $user_block){

				$html_block=$this->View->getFromCache($blockcache."_h_".$user_block);
				$plain_block=$this->View->getFromCache($blockcache."_p_".$user_block);

				$contentDefault.=$html_block["default"];
				$content_plainDefault.=$plain_block["default"];

				$contentF.=$html_block["female"];
				$contentF_plain.=$plain_block["female"];

				$contentM.=$html_block["male"];
				$contentM_plain.=$plain_block["male"];

				$contentTFL.=$html_block["title_firstname_lastname"];
				$contentTFL_plain.=$plain_block["title_firstname_lastname"];

				$contentTL.=$html_block["title_lastname"];
				$contentTL_plain.=$plain_block["title_lastname"];

				$contentFL.=$html_block["firstname_lastname"];
				$contentFL_plain.=$plain_block["firstname_lastname"];

				$contentLN.=$html_block["lastname"];
				$contentLN_plain.=$plain_block["lastname"];

				$contentFN.=$html_block["firstname"];
				$contentFN_plain.=$plain_block["firstname"];

				foreach($html_block["inlines"] as $k=>$v)
				if(!in_array($k,array_keys($inlines))) $inlines[$k]=$v;
			}

			if($salutation && $lastname &&  ($salutation == $this->View->settings["female_salutation"]) && ((!$this->View->settings["title_or_salutation"]) ||  (!$title))){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentF);
				$content = str_replace('###LASTNAME###',$lastname,$content);
				if($title){
				$content = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content);
				}
				$content = str_replace('###TITLE###',$title,$content);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentF_plain);
				$content_plain = str_replace('###LASTNAME###',$lastname,$content_plain);
				if($title){
				$content_plain = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content_plain);
				}
				$content_plain = str_replace('###TITLE###',$title,$content_plain);
			}else if($salutation && $lastname && ($salutation == $this->View->settings["male_salutation"]) && ((!$this->View->settings["title_or_salutation"]) ||  (!$title))){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentM);
				$content = str_replace('###LASTNAME###',$lastname,$content);
				if($title){
					$content = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content);
				}
				$content = str_replace('###TITLE###',$title,$content);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentM_plain);
				$content_plain = str_replace('###LASTNAME###',$lastname,$content_plain);
				if($title){
					$content_plain = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content_plain);
				}
				$content_plain = str_replace('###TITLE###',$title,$content_plain);

			}else if($title && $firstname && $lastname){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentTFL);
				$content = str_replace('###LASTNAME###',$lastname,$content);
				$content = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content);
				$content = str_replace('###TITLE###',$title,$content);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentTFL_plain);
				$content_plain = str_replace('###LASTNAME###',$lastname,$content_plain);
				$content_plain = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content_plain);
				$content_plain = str_replace('###TITLE###',$title,$content_plain);

			}else if($title && $lastname){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentTL);
				$content = str_replace('###LASTNAME###',$lastname,$content);
				$content = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content);
				$content = str_replace('###TITLE###',$title,$content);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentTL_plain);
				$content_plain = str_replace('###LASTNAME###',$lastname,$content_plain);
				$content_plain = eregi_replace('([^ ])###TITLE###','\1 '.$title,$content_plain);
				$content_plain = str_replace('###TITLE###',$title,$content_plain);

			}else if($lastname && $firstname){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentFL);
				$content = str_replace('###LASTNAME###',$lastname,$content);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentFL_plain);
				$content_plain = str_replace('###LASTNAME###',$lastname,$content_plain);

			}else if($firstname){

				$content = str_replace('###FIRSTNAME###',$firstname,$contentFN);
				$content_plain = str_replace('###FIRSTNAME###',$firstname,$contentFN_plain);

			}else if($lastname){

				$content = str_replace('###LASTNAME###',$lastname,$contentLN);
				$content_plain = str_replace('###LASTNAME###',$lastname,$contentLN_plain);

			}else{

				$content = $contentDefault;
				$content_plain = $content_plainDefault;
			}

			$content_plain = str_replace('###EMAIL###',$email,$content_plain);
			$content = str_replace('###EMAIL###',$email,$content);

			// damd: Newsletter Platzhalter ersetzten 
			$this->replacePlaceholder($content, $content_plain, $emails[$j]);
			
            $_clean = $this->View->getCleanMail($this->View->newsletter->Reply);
			$mail= new weNewsletterMailer(
				$email,
				$this->View->newsletter->Subject,
				($htmlmail ? $content : $content_plain),
				$this->View->newsletter->Sender,
				$this->View->newsletter->Reply,
				$htmlmail ? WE_MAIL_TEXT_AND_HTML : WE_MAIL_TEXT_ONLY,
				($this->View->newsletter->Charset!="" ? $this->View->newsletter->Charset : $GLOBALS["_language"]["charset"]),
				"",
				$content_plain,
				(($this->View->settings['additional_clp'] && !empty($_clean)) ? ('-f' .$_clean) : '')
			);

			if($htmlmail) foreach($inlines as $name=>$ins){
				$cont=weFile::load($ins);
				$mail->embed($cont,$name);
			}
			foreach($atts as $att){ $mail->attachFile($att); }

			$not_malformed=true;
			$verified=true;
			$domain="";

			if($this->View->settings["reject_malformed"]) $not_malformed=$this->View->newsletter->check_email($email);
			if($this->View->settings["reject_not_verified"]) $verified=$this->View->newsletter->check_domain($email,$domain);
			$not_black=!$this->View->isBlack($email);
            if($verified && $not_malformed && $not_black){
							if(!$test){
                        		if($mail->send()){
									if($this->View->settings["log_sending"]) $this->View->newsletter->addLog("mail_sent",$email);
								}
								else{
									if($this->View->settings["log_sending"]) $this->View->newsletter->addLog("mail_failed",$email);
									print we_htmlElement::jsElement('
										updateText("'.addslashes(sprintf($l_newsletter["error"].": ".$l_newsletter["mail_failed"],$email)).'");
									');
									flush();
								}
								$this->View->db->query("UPDATE ".NEWSLETTER_TABLE." SET Step='$egc',Offset='$j' WHERE ID=".$this->View->newsletter->ID);
							}
			}
			elseif(!$not_malformed){
							if(!$test && $this->View->settings["log_sending"]) $this->View->newsletter->addLog("email_malformed",$email);
                     		print we_htmlElement::jsElement('
								updateText("'.addslashes(sprintf($l_newsletter["error"].": ".$l_newsletter["email_malformed"],$email)).'");
								updateText("'.addslashes(sprintf($l_newsletter["mail_not_sent"],$email)).'");
							');
							flush();

			}
			elseif(!$verified){
							if(!$test && $this->View->settings["log_sending"]) $this->View->newsletter->addLog("domain_nok",$email);
                     		print we_htmlElement::jsElement('
								updateText("'.addslashes(sprintf($l_newsletter["warning"].": ".$l_newsletter["domain_nok"],$domain)).'");
								updateText("'.addslashes(sprintf($l_newsletter["mail_not_sent"],$email)).'");
							');
							flush();

			}
			elseif(!$not_black){
							if(!$test && $this->View->settings["log_sending"]) $this->View->newsletter->addLog("email_is_black",$email);
                     		print we_htmlElement::jsElement('
								updateText("'.addslashes(sprintf($l_newsletter["warning"].": ".$l_newsletter["email_is_black"],$email)).'");
								updateText("'.addslashes(sprintf($l_newsletter["mail_not_sent"],$email)).'");
							');
							flush();

			}
			$ecs++;

			print we_htmlElement::jsElement('
				document.we_form.ecs.value='.$ecs.';
				top.send_control.document.we_form.ecs.value='.$ecs.';
			');

			if($ecount) $pro=($ecs/$ecount)*100;
			else $pro=0;

			print we_htmlElement::jsElement('top.send_body.setProgress('.((int)$pro).');');
			flush();
		}

		weFile::delete(WE_NEWSLETTER_CACHE_DIR . $emailcache."_".$egc);
		$laststep = ceil($_REQUEST["ecount"] / $this->View->settings["send_step"]);
		if(isset($this->View->settings["send_wait"]) && is_numeric($this->View->settings["send_wait"]) && $this->View->settings["send_wait"] && $_REQUEST['egc'] > 0 && isset($this->View->settings["send_step"]) && is_numeric($this->View->settings["send_step"]) && $_REQUEST['egc'] < ceil($_REQUEST["ecount"] / $this->View->settings["send_step"])){
			print we_htmlElement::jsElement('
				setTimeout("document.we_form.submit()",'.$this->View->settings["send_wait"].');
			');
		}
		else{
			print we_htmlElement::jsElement('
				document.we_form.submit();
			');
		}
		flush();

	}

	function getHTMLSendControl(){
		global $l_newsletter;

		if(isset($_REQUEST["nid"])) $nid=$_REQUEST["nid"];
		else $nid=0;

		if(isset($_REQUEST["test"])) $test=$_REQUEST["test"];
		else $test=0;

		if(isset($_REQUEST["gcount"])) $gcount=$_REQUEST["gcount"];
		else $gcount=0;

		if(isset($_REQUEST["ecount"]))  $ecount=$_REQUEST["ecount"];
		else $ecount=0;

		if(isset($_REQUEST["blockcache"])) $blockcache=$_REQUEST["blockcache"];
		else $blockcache=0;

		if(isset($_REQUEST["ecs"]))  $ecs=$_REQUEST["ecs"];
		else $ecs=0;

		if(isset($_REQUEST["emailcache"])) $emailcache=$_REQUEST["emailcache"];
		else $emailcache=0;

		$to = is_numeric($this->View->settings["send_wait"]) ? $this->View->settings["send_wait"] : 0;
		$to += 40000;

		$js=we_htmlElement::jsElement('
			var to=0;
			var param=0;

			function reinit(){
				top.send_body.document.we_form.details.value=top.send_body.document.we_form.details.value+"\n"+"'.$l_newsletter["retry"].'...";
				document.we_form.submit();
				startTimeout();
			}

			function init(){
				document.we_form.ecs.value=top.send_cmd.document.we_form.ecs.value;
				startTimeout();
			}

			function startTimeout(){
				if(to) stopTimeout();
				to=setTimeout("reload()",'.$to.');
			}

			function stopTimeout(){
				clearTimeout(to);
			}

			function reload(){
				chk=document.we_form.ecs.value;
				if(parseInt(chk)>parseInt(param) && parseInt(chk)!=0){
					param=chk;
					startTimeout();
				}
				else{
					reinit();
				}
			}

			self.focus();
		');

		$body=we_htmlElement::htmlBody(array("marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10","onLoad"=>"startTimeout()"),
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"send_cmd","action"=>$this->frameset),
						we_htmlElement::htmlHidden(array("name"=>"nid","value"=>$nid)).
						we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"send_cmd")).
						we_htmlElement::htmlHidden(array("name"=>"retry","value"=>"1")).
						we_htmlElement::htmlHidden(array("name"=>"test","value"=>"0")).
						we_htmlElement::htmlHidden(array("name"=>"blockcache","value"=>$blockcache)).
						we_htmlElement::htmlHidden(array("name"=>"emailcache","value"=>$emailcache)).
						we_htmlElement::htmlHidden(array("name"=>"ecount","value"=>$ecount)).
						we_htmlElement::htmlHidden(array("name"=>"gcount","value"=>$gcount)).
						we_htmlElement::htmlHidden(array("name"=>"ecs","value"=>$ecs)).
						we_htmlElement::htmlHidden(array("name"=>"reload","value"=>"0"))
					)
		);
		print $this->getHTMLDocument($body,$js);
		flush();
	}


	/**
	 * returns	a select menu within a html table. to ATTENTION this function is also used in classes object and objectFile !!!!
	 *			when $withHeadline is true, a table with headline is returned, default is false
	 * 
	 * @package weModules
	 * @subpackage Newsletter
	 * @return	select menue to determine charset
	 * @param	boolean
	 */
	function getHTMLCharsetTable(){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/charsetHandler.class.php");

		$value = (isset($this->View->newsletter->Charset) ? $this->View->newsletter->Charset : "");

		$charsetHandler = new charsetHandler();

		$charsets = $charsetHandler->getCharsetsForTagWizzard();
		asort($charsets);
		reset($charsets);

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"2","cellspacing"=>"0"),1,2);
		$table->setCol(0,0,null,htmlTextInput("Charset", 15, $value,'','','text',100));
		$table->setCol(0,1,null,htmlSelect("CharsetSelect", $charsets, 1, $value, false, "onblur='document.forms[0].elements[\"Charset\"].value=this.options[this.selectedIndex].value;' onchange='document.forms[0].elements[\"Charset\"].value=this.options[this.selectedIndex].value;'",'value','text',($this->def_width-120),false));

		return $table->getHtmlCode();
	}

	/**
	 * Ersetzt die Newsletter Platzthalter
	 *
	 * @author damd
	 * @package weModules
	 * @subpackage Newsletter
	 * @param String $content
	 * @param String $content_plain
	 * @param Array $customerInfos
	 */
	function replacePlaceholder(&$content, &$content_plain, $customerInfos){
		$pattern = "/####PLACEHOLDER:DB::CUSOMER_TABLE:(.[^#]{1,200})####/";
		preg_match_all($pattern,$content,$placeholderfieldsmatches);
		$placeholderfields = $placeholderfieldsmatches[1];
		unset($placeholderfieldsmatches);

		$fromCustomer = false;
		$placeholderReplaceValue = "";
		if (is_array($customerInfos) && isset($customerInfos[8]) && isset($customerInfos[9]) && $customerInfos[9]=='customer') {
			$fromCustomer = true;
			$this->View->db->query("SELECT * FROM ".CUSTOMER_TABLE." WHERE ID=".$customerInfos[8]);
			$this->View->db->next_record();
		}
		
		foreach ($placeholderfields as $phf) {				
			$placeholderReplaceValue = $fromCustomer ? $this->View->db->f($phf) : "";
			$content = str_replace('####PLACEHOLDER:DB::CUSOMER_TABLE:'.$phf.'####',$placeholderReplaceValue,$content);
			$content_plain = str_replace('####PLACEHOLDER::DB:CUSOMER_TABLE:'.$phf.'####',$this->View->db->f($phf),$content_plain);
		}
	}

}
  
?>