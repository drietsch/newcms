<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/versions.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/version_wizard/versionFragment.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersionsSearch.class.inc.php");


/**
* Class which contains all functions for the
* rebuild dialog and the rebuild function
* @static
*/
class we_versions_wizard{

	/**
	* Dummy function for stupid people who want to call the constructor for this static class
	*
	* @return we_versions_wizard
	*/
	function we_versions_wizard(){
		exit("This is a static class! Don't call the constructor directly!");
	}

	/**
	* returns HTML for the Body Frame
	*
	* @return string
	*/
	function getBody(){
		$step = isset($_REQUEST["step"]) ? $_REQUEST["step"] : "0";
		eval('$contents = we_versions_wizard::getStep'.$step.'();');
		return we_versions_wizard::getPage($contents);
	}

	/**
	* returns HTML for the Frame with the progress bar
	*
	* @return string
	*/
	function getBusy(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");
		$dc = isset($_REQUEST["dc"]) ? $_REQUEST["dc"] : 0;
		
		$WE_PB = new we_progressBar(0,0,true);
		$WE_PB->setStudLen($dc ? 490 : 200);
		$WE_PB->addText("",0,"pb1");
		$js = $WE_PB->getJSCode();
		$pb = $WE_PB->getHTML();

		$js .= 		'<script type="text/javascript">'
				.	'function showRefreshButton() {'
				.	'  prevBut = document.getElementById(\'prev\');'
				.	'  nextBut = document.getElementById(\'nextCell\');'
				.	'  refrBut = document.getElementById(\'refresh\');'
				.	'  prevBut.style.display = \'none\';'
				.	'  nextBut.style.display = \'none\';'
				.	'  refrBut.style.display = \'\';'
				.	'}'
				.	'function showPrevNextButton() {'
				.	'  prevBut = document.getElementById(\'prev\');'
				.	'  nextBut = document.getElementById(\'next\');'
				.	'  refrBut = document.getElementById(\'refresh\');'
				.	'  refrBut.style.display = \'none\';'
				.	'  prevBut.style.display = \'\';'
				.	'  nextBut.style.display = \'\';'
				.	'}'
				.	'</script>';

		$WE_BTN = new we_button();
		$cancelButton = $WE_BTN->create_button("cancel","javascript:top.close();");
		$refreshButton = $WE_BTN->create_button("refresh","javascript:parent.wizcmd.location.reload();", true, -1, -1, "", "", false, false);

		$nextbutdisabled = !(we_hasPerm("REBUILD_ALL") || we_hasPerm("REBUILD_FILTERD") || we_hasPerm("REBUILD_OBJECTS") || we_hasPerm("REBUILD_INDEX") || we_hasPerm("REBUILD_THUMBS") || we_hasPerm("REBUILD_META"));
		
		if($dc){
			$buttons = $WE_BTN->create_button_table(array($refreshButton, $cancelButton), 10);
			$pb = htmlDialogLayout($pb,$GLOBALS["l_rebuild"]["rebuild"],$buttons);
		}else{
			$prevButton = $WE_BTN->create_button("back","javascript:parent.wizbody.handle_event('previous');", true, -1, -1, "", "", true, false);
			$nextButton = $WE_BTN->create_button("next","javascript:parent.wizbody.handle_event('next');", true, -1, -1, "", "", $nextbutdisabled, false);

			$content2 = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0"), 1, 4);
			$content2->setCol(0, 0, array("id" => "prev", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $prevButton);
			$content2->setCol(0, 1, array("id" => "nextCell", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $nextButton);
			$content2->setCol(0, 2, array("id" => "refresh", "style"=>"display:none; padding-left:10px;", "align" => "right"), $refreshButton);
			$content2->setCol(0, 3, array("id" => "cancel", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $cancelButton);

			$content = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "100%"), 1, 2);
			$content->setCol(0, 0, array("id"=>"progr", "style"=>"display:none", "align"=>"left"), $pb);
			$content->setCol(0, 1, array("align" => "right"), $content2->getHtmlCode());

		}


		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET.
				($dc ? "" : we_htmlElement::jsElement($WE_BTN->create_state_changer(false))).$js).
			we_htmlElement::htmlBody(array("class"=>($dc ? "weDialogBody" : "weDialogButtonsBody")), ($dc ? $pb : $content->getHtmlCode())
			)
		);

	}

	/**
	* returns HTML for the Cmd Frame
	*
	* @return string for now it is an empty page
	*/
	function getCmd(){
		return we_versions_wizard::getPage(array("",""));
	}

	/**
	* returns the HTML for the First Step (0) of the wizard
	*
	* @return string
	*/
	function getStep0() {
		
		$version=new weVersions();
	
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";
		
		$version_delete = array();
		$version_reset = array();
		
		foreach ($version->contentTypes as $k) {
			$version_delete[$k] = isset($_REQUEST["version_delete_".$k.""]) ? 1 : 0;
			$version_reset[$k] = isset($_REQUEST["version_reset_".$k.""]) ? 1 : 0;
		}
		
		$version_delete['delete_date'] = isset($_REQUEST["delete_date"]) ? $_REQUEST["delete_date"] : "";
		$version_delete['delete_hours'] = isset($_REQUEST["delete_hours"]) ? $_REQUEST["delete_hours"] : 0;
		$version_delete['delete_minutes'] = isset($_REQUEST["delete_minutes"]) ? $_REQUEST["delete_minutes"] : 0;
		$version_delete['delete_seconds'] = isset($_REQUEST["delete_seconds"]) ? $_REQUEST["delete_seconds"] : 0;
				
		$version_reset['reset_date'] = isset($_REQUEST["reset_date"]) ? $_REQUEST["reset_date"] : "";
		$version_reset['reset_hours'] = isset($_REQUEST["reset_hours"]) ? $_REQUEST["reset_hours"] : 0;
		$version_reset['reset_minutes'] = isset($_REQUEST["reset_minutes"]) ? $_REQUEST["reset_minutes"] : 0;
		$version_reset['reset_seconds'] = isset($_REQUEST["reset_seconds"]) ? $_REQUEST["reset_seconds"] : 0;

		if(isset($_REQUEST["reset_doPublish"])) {
			$version_reset['reset_doPublish'] = 1;
		}
		elseif(isset($_REQUEST["type"]) && $_REQUEST["type"]=="reset_versions") {
			$version_reset['reset_doPublish'] = 0;
		}
		else {
			$version_reset['reset_doPublish'] = 1;
		}
		

		$parts = array();
		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("delete_versions", ($type=="delete_versions"), "type", $GLOBALS["l_versions"]["delete_versions"], true, "defaultfont", "",false, $GLOBALS["l_versions"]["txt_delete_versions"], 0, 495),
			"space"		=> 0)
		);
		
		
		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("reset_versions", ($type=="reset_versions"), "type", $GLOBALS["l_versions"]["reset_versions"], true, "defaultfont", "", false, $GLOBALS["l_versions"]["txt_reset_versions"], 0, 495),
			"space"		=> 0)
		);

		


		$js = 	"\n".
				'window.onload = function(){top.focus();}'."\n".
				'function handle_event(what){'."\n".
				'	f = document.we_form;'."\n".
				'	switch(what){'."\n".
				'		case "previous":'."\n".
				'			break;'."\n".
				'		case "next":'."\n".
				'			selectedValue="";'."\n".
				'			for(var i=0;i<f.type.length;i++){'."\n".
				'				if(f.type[i].checked){;'."\n".
				'					selectedValue = f.type[i].value;'."\n".
						'		}'."\n".
				'			}'."\n".
				'			goTo(selectedValue)'."\n".
				'			break;'."\n".
				'	}'."\n".
				'}'."\n".

				'function goTo(where){'."\n".
				'	f = document.we_form;'."\n".
				'	switch(where){'."\n".
				'		case "rebuild_thumbnails":'."\n".
				'		case "delete_versions":'."\n".
				'			f.target="wizbody";'."\n".
				'			break;'."\n".
				'		case "rebuild_objects":'."\n".
				'		case "rebuild_index":'."\n".
				'		case "rebuild_navigation":'."\n".
				'			set_button_state(1);'."\n".
				'			f.target="wizcmd";'."\n".
				'			f.step.value="2";'."\n".
				'			break;'."\n".
				'	}'."\n".
				'	f.submit();'."\n".
				'}'."\n".

				'function set_button_state(alldis) {'."\n" .
				'	if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){'."\n" .
				'		top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "disabled");'."\n" .
				'		if(alldis){'."\n" .
				'			top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "disabled");'."\n" .
				'			top.frames["wizbusy"].showRefreshButton();'."\n" .
				'		}else{'."\n" .
				'			top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");'."\n" .
				'		}'."\n" .
				'	}else{'."\n" .
				'		setTimeout("set_button_state("+(alldis ? 1 : 0)+")",300);'."\n" .
				'	}'."\n" .
				'}'."\n".
				'set_button_state(false);'."\n";

		$js .= '

';
		$hiddenFields = "";
		foreach($version_delete as $k => $v) {
				$hiddenFields .= we_htmlElement::htmlHidden(array("name" => $k, "value" => $v));
		}

		foreach($version_reset as $k => $v) {
				$hiddenFields .= we_htmlElement::htmlHidden(array("name" => $k, "value" => $v));
		}


		return array($js,we_multiIconBox::getHTML("", "100%", $parts, 40,"", -1, "", "", false, $GLOBALS["l_versions"]["versioning"]).

						
							$hiddenFields.
							
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).

							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "versions_wizard")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "1")));
	}

	/**
	* returns the HTML for the Second Step (1) of the wizard
	*
	* @return string
	*/
	function getStep1() {
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";

		switch($type){
			case "delete_versions":
				return we_versions_wizard::getDelete1();
			case "reset_versions":
				return we_versions_wizard::getReset1();

		}

	}
	
	function getDelete1() {
		
		$version=new weVersions();
		$button = new we_button();

		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";
		
		
		$versions_delete_all = isset($_REQUEST["version_delete_all"]) ? 1 : 0;	
		$version_delete_date = isset($_REQUEST["delete_date"]) ? $_REQUEST["delete_date"] : "";
		$version_delete_hours = isset($_REQUEST["delete_hours"]) ? $_REQUEST["delete_hours"] : 0;
		$version_delete_minutes = isset($_REQUEST["delete_minutes"]) ? $_REQUEST["delete_minutes"] : 0;
		$version_delete_seconds = isset($_REQUEST["delete_seconds"]) ? $_REQUEST["delete_seconds"] : 0;

		$parts = array();
		
		array_push($parts, array(
						'html' => htmlAlertAttentionBox($GLOBALS["l_versions"]['ct_delete_text'],2,520), 
						'noline'=>1, 
						'space' => 0)
					);
		
		$content = "";
		foreach ($version->contentTypes as $k) {
			$txt = $k;
			$name = "version_delete_".$k;
			$val = "version_delete_".$k;
			$checked = isset($_REQUEST[$k]) ? $_REQUEST[$k] : 0;
			if($k=="all") {
				$jvs = "checkAll(this);";
				$content .= we_forms::checkbox($val, $checked, $name, $GLOBALS["l_versions"]['versions_all'], false, "defaultfont", $jvs)."<br/>";
			}
			else {
				$jvs = "checkAllRevert(this);";
				$content .= we_forms::checkbox($val, $checked, $name, $GLOBALS["l_contentTypes"][$txt], false, "defaultfont", $jvs)."<br/>";
			}
			
		}
					
		array_push($parts, array(
				'headline' => $GLOBALS["l_versions"]['ContentType'],
				'space' => 170,
				'html' => $content,
				'noline' => 1)
		);
					
		$versions_delete_date = weVersionsSearch::getDateSelector("","delete_date","_1",$version_delete_date);

		$reset_hours = new we_htmlSelect(array("id" => "delete_hours", "name" => "delete_hours","style"=>"","class"=>"weSelect", "onChange"=>""));

		for($x = 0; $x<=23; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_hours->addOption($x,$txt);
		}
		
		$reset_hours->selectOption($version_delete_hours);

		
		$reset_minutes = new we_htmlSelect(array("id" => "delete_minutes","name" => "delete_minutes","style"=>"","class"=>"weSelect", "onChange"=>""));


		for($x = 0; $x<=59; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_minutes->addOption($x,$txt);
		}

		$reset_minutes->selectOption($version_delete_minutes);
		
		$reset_seconds = new we_htmlSelect(array("id" => "delete_seconds","name" => "delete_seconds","style"=>"","class"=>"weSelect", "onChange"=>""));


		for($x = 0; $x<=59; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_seconds->addOption($x,$txt);
		}

		$reset_seconds->selectOption($version_delete_seconds);
		
		array_push($parts, array(
						'html' => htmlAlertAttentionBox($GLOBALS["l_versions"]['date_delete_text'],2,520), 
						'noline'=>1, 
						'space' => 0)
					);

		$clearDate = $button->create_button("reset","javascript:document.getElementById('delete_date').value='';", true, -1, -1, "", "","", false);
		
		
		array_push($parts, array(
			'headline'=>$GLOBALS["l_versions"]['time'], 
			'html' => "<div style='padding-bottom:3px;'>".$GLOBALS["l_versions"]['day'].":</div><div style='float:left;'>".$versions_delete_date."</div><div style='float:left;margin: 0px 0px 10px 10px;'>".$clearDate."</div><br style='clear:left;' /><div style='padding-bottom:3px;'>".$GLOBALS["l_versions"]['clocktime'].":</div>".$reset_hours->getHtmlCode()." h : ".$reset_minutes->getHtmlCode()." m: ".$reset_seconds->getHtmlCode()." s", 
			'noline'=>1, 
			'space'=>170)
		);

		//js
		$jsCheckboxCheckAll = '';
		$jsCheckboxCtIf = '';

		$jsCheckboxArgs = '';
		foreach ($version->contentTypes as $k) {
			if($k!="all") {
				$jsCheckboxCheckAll .= 'document.getElementById("version_delete_'.$k.'").checked = checked;';
			}
			if($jsCheckboxCtIf!="") $jsCheckboxCtIf .= " && ";
			$jsCheckboxCtIf .= 'document.getElementById("version_delete_'.$k.'").checked==0';
			$jsCheckboxArgs .= 'args += "&ct['.$k.']="+escape(document.getElementById("version_delete_'.$k.'").checked);';
	
		}
		
		
		
		$nextButton = $button->create_button("next","javascript:parent.wizbody.handle_event(\"next\");", true, -1, -1, "", "","", false);
				


		$js = 	'window.onload = function(){
					top.focus();
				}
				function handle_event(what){
					f = document.we_form;
					switch(what){
						case "previous":
							f.step.value=0
							f.target="wizbody";
							f.submit();
							break;
						case "next":
							var date = document.getElementById("delete_date").value;
							var hour = document.getElementById("delete_hours").value;
							var minutes = document.getElementById("delete_minutes").value;
							var seconds = document.getElementById("delete_seconds").value;
							if('.$jsCheckboxCtIf.') {
								' . we_message_reporting::getShowMessageCall($GLOBALS['l_versions']['notCheckedContentType'], WE_MESSAGE_NOTICE) . '
							}
							else {
								selectedValue="";
								for(var i=0;i<f.type.length;i++){
									if(f.type[i].checked){;
										selectedValue = f.type[i].value;
									}
								}
								goTo(selectedValue);
							}
						break;
					}
				}
				
				function checkAll(val) {
						
		            	if(val.checked) {
		            		checked = 1;
		            	}
		            	else {
		            		checked = 0;
		            	}
						'.$jsCheckboxCheckAll.';
		            	
					}
	            	
	            	function checkAllRevert() {
	            	
	            		var checkbox = document.getElementById("version_delete_all");
						checkbox.checked = false;
	            	}
	            
		            function calendarSetup(){
	
		            	if(document.getElementById("date_picker_1") != null) {
							Calendar.setup({inputField:"delete_date",ifFormat:"%d.%m.%Y",button:"date_picker_1",align:"Tl",singleClick:true});
						}
						
					}

				function goTo(where){
					f = document.we_form;
					switch(where){
						case "delete_versions":
							f.target="wizbody";
							break;
					}
					f.submit();
				}
				
				

				function set_button_state(alldis) {
					if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){
						top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "enabled");
						if(alldis){
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							top.frames["wizbusy"].showRefreshButton();
						}else{
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							var nextBut = top.frames["wizbusy"].document.getElementById(\'nextCell\');
				  			nextBut.innerHTML = \''.$nextButton.'\';
						}
					}else{
						setTimeout("set_button_state("+(alldis ? 1 : 0)+")",300);
					}
				}
				set_button_state(false);';

		

	$calendar = we_htmlElement::jsElement("calendarSetup();");
					
					array_push($parts, array(
						'html' => $calendar, 
						'noline'=>0, 
						'space' => 0)
					);

		return array($js,we_multiIconBox::getHTML("", "100%", $parts, 40,"", -1, "", "", false, $GLOBALS["l_versions"]["delete_versions"]." - ".$GLOBALS["l_versions"]["step"]." 1 ".$GLOBALS["l_versions"]["of"]." 2").

							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).

							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "versions_wizard")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "2")));
	}
	
	function getReset1() {
		
		$version=new weVersions();
		$button = new we_button();
		
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "reset_versions";
		
		
		$versions_reset_all = isset($_REQUEST["version_reset_all"]) ? 1 : 0;	
		$version_reset_date = isset($_REQUEST["reset_date"]) ? $_REQUEST["reset_date"] : "";
		$version_reset_hours = isset($_REQUEST["reset_hours"]) ? $_REQUEST["reset_hours"] : 0;
		$version_reset_minutes = isset($_REQUEST["reset_minutes"]) ? $_REQUEST["reset_minutes"] : 0;
		$version_reset_seconds = isset($_REQUEST["reset_seconds"]) ? $_REQUEST["reset_seconds"] : 0;
		$version_reset_doPublish = isset($_REQUEST["reset_doPublish"]) && $_REQUEST["reset_doPublish"] ? 1 : 0;

		$parts = array();
		
		array_push($parts, array(
						'html' => htmlAlertAttentionBox($GLOBALS["l_versions"]['ct_reset_text'],2,520), 
						'noline'=>1, 
						'space' => 0)
					);
		
		$content = "";
		foreach ($version->contentTypes as $k) {
			
			$txt = $k;
			$name = "version_reset_".$k;
			$val = "version_reset_".$k;
			$checked = isset($_REQUEST[$k]) ? $_REQUEST[$k] : 0;
			if($k=="all") {
				$jvs = "checkAll(this);";
				$content .= we_forms::checkbox($val, $checked, $name, $GLOBALS["l_versions"]['versions_all'], false, "defaultfont", $jvs)."<br/>";
			}
			else {
				$jvs = "checkAllRevert(this);";
				$content .= we_forms::checkbox($val, $checked, $name, $GLOBALS["l_contentTypes"][$txt], false, "defaultfont", $jvs)."<br/>";
			}
		}		
					
		array_push($parts, array(
				'headline' => $GLOBALS["l_versions"]['ContentType'],
				'space' => 170,
				'html' => $content,
				'noline' => 1)
		);
					
		$versions_reset_date = weVersionsSearch::getDateSelector("","reset_date","_1",$version_reset_date);
		
		
		array_push($parts, array(
						'html' => htmlAlertAttentionBox($GLOBALS["l_versions"]['doPublish_text'],2,520), 
						'noline'=>1, 
						'space' => 0)
					);
		
		$doPublish = we_forms::checkbox($version_reset_doPublish, $version_reset_doPublish, "reset_doPublish", $GLOBALS['l_versions']['publishIfReset'], false, "defaultfont", "");
		
		array_push($parts, array(
			'headline'=>"", 
			'html' => $doPublish,
			'noline'=>1, 
			'space'=>1)
		);
		

		$reset_hours = new we_htmlSelect(array("id" => "reset_hours", "name" => "reset_hours","style"=>"","class"=>"weSelect", "onChange"=>""));

		for($x = 0; $x<=23; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_hours->addOption($x,$txt);
		}
		
		$reset_hours->selectOption($version_reset_hours);

		
		$reset_minutes = new we_htmlSelect(array("id" => "reset_minutes","name" => "reset_minutes","style"=>"","class"=>"weSelect", "onChange"=>""));

		for($x = 0; $x<=59; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_minutes->addOption($x,$txt);
		}

		$reset_minutes->selectOption($version_reset_minutes);
		
		$reset_seconds = new we_htmlSelect(array("id" => "reset_seconds","name" => "reset_seconds","style"=>"","class"=>"weSelect", "onChange"=>""));

		for($x = 0; $x<=59; $x++) {
			$txt = $x;
			if($x<=9) {
				$txt = "0".$x;
			}
			$reset_seconds->addOption($x,$txt);
		}

		$reset_seconds->selectOption($version_reset_seconds);
		
		array_push($parts, array(
						'html' => htmlAlertAttentionBox($GLOBALS["l_versions"]['date_reset_text'],2,520), 
						'noline'=>1, 
						'space' => 0)
					);
					
		$clearDate = $button->create_button("reset","javascript:document.getElementById('reset_date').value='';", true, -1, -1, "", "","", false);
		
		array_push($parts, array(
			'headline'=>$GLOBALS["l_versions"]['time'], 
			'html' => "<div style='padding-bottom:3px;'>Tag:</div><div style='float:left;'>".$versions_reset_date."</div><div style='float:left;margin:0px 0px 10px 10px;'>".$clearDate."</div><br style='clear:left;' /><div style='padding-bottom:3px;'>Uhrzeit:</div>".$reset_hours->getHtmlCode()." h : ".$reset_minutes->getHtmlCode()." m: ".$reset_seconds->getHtmlCode()." s ", 
			'noline'=>1, 
			'space'=>170)
		);

		//js
		$jsCheckboxCheckAll = '';
		$jsCheckboxCtIf = '';

		$jsCheckboxArgs = '';
		foreach ($version->contentTypes as $k) {
			if($k!="all") {
				$jsCheckboxCheckAll .= 'document.getElementById("version_reset_'.$k.'").checked = checked;';
			}
			if($jsCheckboxCtIf!="") $jsCheckboxCtIf .= " && ";
			$jsCheckboxCtIf .= 'document.getElementById("version_reset_'.$k.'").checked==0';
			$jsCheckboxArgs .= 'args += "&ct['.$k.']="+escape(document.getElementById("version_reset_'.$k.'").checked);';
	
		}

			
		$nextButton = $button->create_button("next","javascript:parent.wizbody.handle_event(\"next\");", true, -1, -1, "", "","", false);
		

		$js = 	'window.onload = function(){
					top.focus();
				}
				function handle_event(what){
					f = document.we_form;
					switch(what){
						case "previous":
							f.step.value=0
							f.target="wizbody";
							f.submit();
							break;
						case "next":
							var date = document.getElementById("reset_date").value;
							var hour = document.getElementById("reset_hours").value;
							var minutes = document.getElementById("reset_minutes").value;
							var seconds = document.getElementById("reset_seconds").value;
							if('.$jsCheckboxCtIf.') {
								' . we_message_reporting::getShowMessageCall($GLOBALS['l_versions']['notCheckedContentType'], WE_MESSAGE_NOTICE) . '
							}
							else if(date=="") {
								' . we_message_reporting::getShowMessageCall($GLOBALS['l_versions']['notCheckedDate'], WE_MESSAGE_NOTICE) . '
							}
							else {
								selectedValue="";
								for(var i=0;i<f.type.length;i++){
									if(f.type[i].checked){;
										selectedValue = f.type[i].value;
									}
								}
								goTo(selectedValue);
							}
						break;
					}
				}
				
				function checkAll(val) {
						
		            	if(val.checked) {
		            		checked = 1;
		            	}
		            	else {
		            		checked = 0;
		            	}
						'.$jsCheckboxCheckAll.';
		            	
					}
	            	
	            	function checkAllRevert() {
	            	
	            		var checkbox = document.getElementById("version_reset_all");
						checkbox.checked = false;
	            	}
	            
		            function calendarSetup(){
	
		            	if(document.getElementById("date_picker_1") != null) {
							Calendar.setup({inputField:"reset_date",ifFormat:"%d.%m.%Y",button:"date_picker_1",align:"Tl",singleClick:true});
						}
						
					}

				function goTo(where){
					f = document.we_form;
					switch(where){
						case "reset_versions":
							f.target="wizbody";
							break;
					}
					f.submit();
				}

				function set_button_state(alldis) {
					if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){
						top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "enabled");
						if(alldis){
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							top.frames["wizbusy"].showRefreshButton();
						}else{
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							var nextBut = top.frames["wizbusy"].document.getElementById(\'nextCell\');
				  			nextBut.innerHTML = \''.$nextButton.'\';
						}
					}else{
						setTimeout("set_button_state("+(alldis ? 1 : 0)+")",300);
					}
				}
				set_button_state(false);';

		

	$calendar = we_htmlElement::jsElement("calendarSetup();");
					
					array_push($parts, array(
						'html' => $calendar, 
						'noline'=>0, 
						'space' => 0)
					);
					
					
		

		return array($js,we_multiIconBox::getHTML("", "100%", $parts, 40,"", -1, "", "", false, $GLOBALS["l_versions"]["reset_versions"]." - ".$GLOBALS["l_versions"]["step"]." 1 ".$GLOBALS["l_versions"]["of"]." 2").

							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).

							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "versions_wizard")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "2")));
	}

	/**
	* returns the HTML for the Third Step (2) of the wizard. - Here the real work (loop) is done - it should be displayed in the cmd frame
	*
	* @return string
	*/
	
	function getStep2() {
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";

		switch($type){
			case "delete_versions":
				return we_versions_wizard::getDelete2();
			case "reset_versions":
				return we_versions_wizard::getReset2();
		}

	}
	
	function getStep3() {
		
		$version=new weVersions();
	
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";

		
		$version_delete = array();
		$version_reset = array();
		
		foreach ($version->contentTypes as $k) {
			$version_delete[$k] = isset($_REQUEST["version_delete_".$k.""]) ? 1 : 0;
			$version_reset[$k] = isset($_REQUEST["version_reset_".$k.""]) ? 1 : 0;
		}
		
		$version_delete['delete_date'] = isset($_REQUEST["delete_date"]) ? $_REQUEST["delete_date"] : "";
		$version_delete['delete_hours'] = isset($_REQUEST["delete_hours"]) ? $_REQUEST["delete_hours"] : 0;
		$version_delete['delete_minutes'] = isset($_REQUEST["delete_minutes"]) ? $_REQUEST["delete_minutes"] : 0;
		$version_delete['delete_seconds'] = isset($_REQUEST["delete_seconds"]) ? $_REQUEST["delete_seconds"] : 0;
		
		$version_reset['reset_date'] = isset($_REQUEST["reset_date"]) ? $_REQUEST["reset_date"] : "";
		$version_reset['reset_hours'] = isset($_REQUEST["reset_hours"]) ? $_REQUEST["reset_hours"] : 0;
		$version_reset['reset_minutes'] = isset($_REQUEST["reset_minutes"]) ? $_REQUEST["reset_minutes"] : 0;
		$version_reset['reset_seconds'] = isset($_REQUEST["reset_seconds"]) ? $_REQUEST["reset_seconds"] : 0;
		if(isset($_REQUEST["reset_doPublish"])) {
			$version_reset['reset_doPublish'] = 1;
		}
		elseif(isset($_REQUEST["type"]) && $_REQUEST["type"]=="reset_versions") {
			$version_reset['reset_doPublish'] = 0;
		}
		else {
			$version_reset['reset_doPublish'] = 1;
		}
		
		$taskname = md5(session_id()."_version_wizard");
		$currentTask = isset($_GET["fr_".$taskname."_ct"]) ? $_GET["fr_".$taskname."_ct"] : 0;
		$taskFilename = FRAGMENT_LOCATION.$taskname;


		$js = "";
		if(!(file_exists($taskFilename) && $currentTask)){
			switch($type){
				case "delete_versions":
					$data = we_version::getDocuments($type,$version_delete);
					break;
				case "reset_versions":
					$data = we_version::getDocuments($type,$version_reset);
					break;
				
			}
			if(count($data)){
				$fr = new versionFragment($taskname,1,0,array(),$data);

				return array();
			}else{
				return array($js.we_message_reporting::getShowMessageCall($GLOBALS["l_versions"]["deleteNothingFound"],1).'top.wizbusy.showPrevNextButton();', "");
			}
		}else{
				$fr = new versionFragment($taskname,1,0,array());

				return array();
		}

	}

	

	/**
	* returns Array with javascript (array[0]) and HTML Content (array[1]) for the rebuild document page
	*
	* @return array
	*/
	function getDelete2(){
		
		$version=new weVersions();
				
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "delete_versions";
		
		$version_delete = array();
		
		foreach ($version->contentTypes as $k) {
			$version_delete[$k] = isset($_REQUEST["version_delete_".$k.""]) ? 1 : 0;
		}
		
		$version_delete['delete_date'] = isset($_REQUEST["delete_date"]) ? $_REQUEST["delete_date"] : "";
		$version_delete['delete_hours'] = isset($_REQUEST["delete_hours"]) ? $_REQUEST["delete_hours"] : 0;
		$version_delete['delete_minutes'] = isset($_REQUEST["delete_minutes"]) ? $_REQUEST["delete_minutes"] : 0;
		$version_delete['delete_seconds'] = isset($_REQUEST["delete_seconds"]) ? $_REQUEST["delete_seconds"] : 0;
		
		$timestamp = "";
		$timestampWhere = 1;
		if($version_delete['delete_date']!="") {
			$date = explode(".", $_REQUEST["delete_date"]);
			$day = $date[0];
			$month = $date[1];
			$year = $date[2];
			$hour = $version_delete['delete_hours'];
			$minutes = $version_delete['delete_minutes'];
			$seconds = $version_delete['delete_seconds'];
			$timestamp = mktime($hour, $minutes, $seconds, $month, $day, $year);
			
			$timestampWhere = " timestamp< '".$timestamp."' ";
		}
		
		
		$parts = array();
		
		$whereCt = "";
		foreach($version_delete as $k => $v) {
			
			if($k!="all" && $k!="delete_date" && $k!="delete_hours" && $k!="delete_minutes" && $k!="delete_seconds") {
				if($v) {
					if($whereCt!="") $whereCt .= ",";
					$whereCt .= "'".$k."'";
				}
			}
		}
		if($whereCt!="") {
			$whereCt = " ContentType IN (".$whereCt.")";
		}
		else {
			$whereCt = "1";
		}
		
		$cont = array();
		$docIds = array();
		$query = "SELECT ID,documentID,documentTable,Text,Path,ContentType,binaryPath,timestamp,version FROM ". VERSIONS_TABLE . " WHERE ". $whereCt." AND ".$timestampWhere." ORDER BY ID";
		$_SESSION['versions']['deleteWizardWhere'] = $whereCt." AND ".$timestampWhere;
		$GLOBALS["DB_WE"]->query($query);
		
		$_SESSION['versions']['logDeleteIds'] = array();

		while($GLOBALS["DB_WE"]->next_record()){
				if(!in_array($GLOBALS["DB_WE"]->f("documentID"), $docIds)) {
					$docIds[$GLOBALS["DB_WE"]->f("documentID")]["Path"] = $GLOBALS["DB_WE"]->f("Path");
					$docIds[$GLOBALS["DB_WE"]->f("documentID")]["ContentType"] = $GLOBALS["DB_WE"]->f("ContentType");
				}
				array_push($cont,array(	"ID"=>$GLOBALS["DB_WE"]->f("ID"),
										"documentID"=>$GLOBALS["DB_WE"]->f("documentID"),
										"version"=>$GLOBALS["DB_WE"]->f("version"),
										"text"=>$GLOBALS["DB_WE"]->f("Text"),
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"table"=>$GLOBALS["DB_WE"]->f("documentTable"),
										"contentType"=>$GLOBALS["DB_WE"]->f("ContentType"),
										"timestamp"=>$GLOBALS["DB_WE"]->f("timestamp")
										));
				$_SESSION['versions']['logDeleteIds'][$GLOBALS["DB_WE"]->f('ID')]['Text'] = $GLOBALS["DB_WE"]->f('Text');	
				$_SESSION['versions']['logDeleteIds'][$GLOBALS["DB_WE"]->f('ID')]['ContentType'] = $GLOBALS["DB_WE"]->f('ContentType');	
				$_SESSION['versions']['logDeleteIds'][$GLOBALS["DB_WE"]->f('ID')]['Path'] = $GLOBALS["DB_WE"]->f('Path');		
				$_SESSION['versions']['logDeleteIds'][$GLOBALS["DB_WE"]->f('ID')]['Version'] = $GLOBALS["DB_WE"]->f('version');	
				$_SESSION['versions']['logDeleteIds'][$GLOBALS["DB_WE"]->f('ID')]['documentID'] = $GLOBALS["DB_WE"]->f('documentID');		
				if($GLOBALS["DB_WE"]->f("binaryPath")!="") {
					$_SESSION['versions']['deleteWizardbinaryPath'][] = $GLOBALS["DB_WE"]->f("binaryPath");
				}
		}
		
		$out = '<div style="width:520px;">';
		$out .= $GLOBALS["l_versions"]['step2_txt1'];
		
		if($timestamp!="") {
			$date = date("d.m.y - H:i:s",$timestamp);
			$out .= sprintf($GLOBALS["l_versions"]['step2_txt2_delete'],$date);
		}
		$out .= $GLOBALS["l_versions"]['step2_txt3'];
		$out .= '</div>';
		
		$out .= '<div style="background-color:#fff;width:520px;margin-top:20px;">';
		$out .= '<table border="0" cellpadding="2" cellspacing="0" width="100%">';
		
		$out .= '<tr class="defaultfont" style="height:30px;">';

		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["_id"];
		$out .= '</th>';
		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["path"];
		$out .= '</th>';
		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["ContentType"];
		$out .= '</th>';
		
			
		$out .= '</tr>';
		
		foreach($docIds as $k => $v) {
			$out .= '<tr class="defaultfont">';
			$out .= '<td align="center">';
			$out .= $k;
			$out .= '</td>';
			$out .= '<td align="center">';
			$out .= shortenPath($v['Path'], 55);
			$out .= '</td>';
			$out .= '<td align="center">';
			$out .= $v['ContentType'];
			$out .= '</td>';
			$out .= '</tr>';
		}
		$out .= '</table>';
		$out .= "</div>";
	
		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $out,
			"space"		=> 0)
		);
		
		$hiddenFields = "";
		foreach($version_delete as $k => $v) {
				$hiddenFields .= we_htmlElement::htmlHidden(array("name" => $k, "value" => $v));
		}
				
				
		return array(we_versions_wizard::getPage2Js(empty($cont),"delete"),we_multiIconBox::getHTML("", "100%", $parts, 40, "", -1, "", "", false, $GLOBALS["l_versions"]["delete_versions"]." - ".$GLOBALS["l_versions"]["step"]." 2 ".$GLOBALS["l_versions"]["of"]." 2").

							$hiddenFields.
		
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "versions_wizard")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "3")));
	}
	
	
	function getReset2(){

		$version=new weVersions();
				
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "reset_versions";
		
		$_SESSION['versions']['logResetIds'] = array();
		
		$version_reset = array();
		
		foreach ($version->contentTypes as $k) {
			$version_reset[$k] = isset($_REQUEST["version_reset_".$k.""]) ? 1 : 0;
		}
		
		$version_reset['reset_date'] = isset($_REQUEST["reset_date"]) ? $_REQUEST["reset_date"] : "";
		$version_reset['reset_hours'] = isset($_REQUEST["reset_hours"]) ? $_REQUEST["reset_hours"] : 0;
		$version_reset['reset_minutes'] = isset($_REQUEST["reset_minutes"]) ? $_REQUEST["reset_minutes"] : 0;
		$version_reset['reset_seconds'] = isset($_REQUEST["reset_seconds"]) ? $_REQUEST["reset_seconds"] : 0;
		if(isset($_REQUEST["reset_doPublish"])) {
			$version_reset['reset_doPublish'] = 1;
		}
		elseif(isset($_REQUEST["type"]) && $_REQUEST["type"]=="reset_versions") {
			$version_reset['reset_doPublish'] = 0;
		}
		else {
			$version_reset['reset_doPublish'] = 1;
		}
		$timestamp = "";
		$timestampWhere = 1;
		if($version_reset['reset_date']!="") {
			$date = explode(".", $_REQUEST["reset_date"]);
			$day = $date[0];
			$month = $date[1];
			$year = $date[2];
			$hour = $version_reset['reset_hours'];
			$minutes = $version_reset['reset_minutes'];
			$seconds = $version_reset['reset_seconds'];
			$timestamp = mktime($hour, $minutes, $seconds, $month, $day, $year);
			
			$timestampWhere = " timestamp< '".$timestamp."' ";
		}
		
		
		$parts = array();
		
		$w = "";
		foreach($version_reset as $k => $v) {
			
			if($k!="all" && $k!="reset_date" && $k!="reset_hours" && $k!="reset_minutes" && $k!="reset_seconds" && $k!="reset_doPublish") {
				if($v) {
					if($w!="") $w .= " || ";
					$wHelp = " ContentType = '".$k."' ";
					if($k=="text/webedition" || $k=="text/html" || $k=="objectFile") {
						$wHelp = $wHelp. " AND status='published' ";
					}
					$w .= "(".$wHelp.")";
				}
			}
		}
		if($w!="") {
			$w = "(".$w.") ";
		}
		else {
			$w = "1";
		}
		

		
		$cont = array();
		$docIds = array();
		$query = "SELECT ID,documentID,documentTable,Text,Path,ContentType,timestamp,MAX(version) as version FROM " . VERSIONS_TABLE . " WHERE timestamp<='".$timestamp."'  ";
		$query .= " AND ".$w." ";
		$query .= " GROUP BY  documentTable,documentID ";
		$query .= " ORDER BY version DESC ";
		

		$_SESSION['versions']['query'] = $query;
		$GLOBALS["DB_WE"]->query($query);
		while($GLOBALS["DB_WE"]->next_record()){
				if(!in_array($GLOBALS["DB_WE"]->f("documentID"), $docIds)) {
					$docIds[$GLOBALS["DB_WE"]->f("documentID")]["Path"] = $GLOBALS["DB_WE"]->f("Path");
					$docIds[$GLOBALS["DB_WE"]->f("documentID")]["ContentType"] = $GLOBALS["DB_WE"]->f("ContentType");
				}
				array_push($cont,array(	"ID"=>$GLOBALS["DB_WE"]->f("ID"),
										"documentID"=>$GLOBALS["DB_WE"]->f("documentID"),
										"version"=>$GLOBALS["DB_WE"]->f("version"),
										"text"=>$GLOBALS["DB_WE"]->f("Text"),
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"table"=>$GLOBALS["DB_WE"]->f("documentTable"),
										"contentType"=>$GLOBALS["DB_WE"]->f("ContentType"),
										"timestamp"=>$GLOBALS["DB_WE"]->f("timestamp")
										));
		}
	
		
		
		$date = date("d.m.y - H:i:s",$timestamp);
		$out = '<div style="width:520px;">';
		$out .= sprintf($GLOBALS["l_versions"]['step2_txt_reset'],$date);
		$out .= '</div>';
		$out .= '<div style="background-color:#fff;width:520px;margin-top:20px;">';
		$out .= '<table border="0" cellpadding="2" cellspacing="0" width="100%">';
		
		$out .= '<tr class="defaultfont" style="height:30px;">';

		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["_id"];
		$out .= '</th>';
		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["path"];
		$out .= '</th>';
		$out .= '<th style="border-bottom:1px solid #B7B5B6;">';
		$out .= $GLOBALS["l_versions"]["ContentType"];
		$out .= '</th>';
		
			
		$out .= '</tr>';
		
		foreach($docIds as $k => $v) {
			$out .= '<tr class="defaultfont">';
			$out .= '<td align="center">';
			$out .= $k;
			$out .= '</td>';
			$out .= '<td align="center">';
			$out .= shortenPath($v['Path'], 55);
			$out .= '</td>';
			$out .= '<td align="center">';
			$out .= $v['ContentType'];
			$out .= '</td>';
			$out .= '</tr>';
		}
		$out .= '</table>';
		$out .= "</div>";
		
		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $out,
			"space"		=> 0)
		);
		
		$hiddenFields = "";
		foreach($version_reset as $k => $v) {
				$hiddenFields .= we_htmlElement::htmlHidden(array("name" => $k, "value" => $v));
		}

		
		
		return array(we_versions_wizard::getPage2Js(empty($cont),"reset"),we_multiIconBox::getHTML("", "100%", $parts, 40, "", -1, "", "", false, $GLOBALS["l_versions"]["reset_versions"]." - ".$GLOBALS["l_versions"]["step"]." 2 ".$GLOBALS["l_versions"]["of"]." 2").

							$hiddenFields.
		
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "versions_wizard")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "3")));
	}


	

	/**
	* returns HTML for the frameset
	*
	* @return string
	*/
	function getFrameset(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");

		$tail = "";
		if(isset($_REQUEST["btype"])){
			$tail .= "&amp;btype=".rawurlencode($_REQUEST["btype"]);
		}
		if(isset($_REQUEST["type"])){
			$tail .= "&amp;type=".rawurlencode($_REQUEST["type"]);
		}
		if(isset($_REQUEST["templateID"])){
			$tail .= "&amp;templateID=".rawurlencode($_REQUEST["templateID"]);
		}
		if(isset($_REQUEST["step"])){
			$tail .= "&amp;step=".rawurlencode($_REQUEST["step"]);
		}
		if(isset($_REQUEST["responseText"])){
			$tail .= "&amp;responseText=".rawurlencode($_REQUEST["responseText"]);
		}



		$taskname = md5(session_id()."_version_wizard");
		$taskFilename = FRAGMENT_LOCATION.$taskname;
		if(file_exists($taskFilename)){
			@unlink($taskFilename);
		}

		$cmdFrameHeight =   (isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0) ? 30 : 0;

		if($tail){
			$fst = new we_htmlFrameset(array(
				"rows" => "*,$cmdFrameHeight",
				"framespacing" => 0,
				"border" => 0,
				"frameborder" => "no")
			);

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=versions_wizard&amp;fr=busy&amp;dc=1", "name" => "wizbusy"));
			$fst->setFrameAttributes(0, array("scrolling" => "no","onload"=>"wizcmd.location='".WEBEDITION_DIR."we_cmd.php?we_cmd[0]=versions_wizard&amp;fr=body".$tail."';"));

			$fst->addFrame(array("src" => HTML_DIR."white.html", "name" => "wizcmd"));
			$fst->setFrameAttributes(1, array("scrolling" => "no"));

		}else{
			$fst = new we_htmlFrameset(array(
				"rows" => "*,40,$cmdFrameHeight",
				"framespacing" => 0,
				"border" => 0,
				"frameborder" => "no")
			);

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=versions_wizard&amp;fr=body", "name" => "wizbody"));
			$fst->setFrameAttributes(0, array("scrolling" => "auto"));

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=versions_wizard&amp;fr=busy", "name" => "wizbusy"));
			$fst->setFrameAttributes(1, array("scrolling" => "no"));

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=versions_wizard&amp;fr=cmd", "name" => "wizcmd"));
			$fst->setFrameAttributes(2, array("scrolling" => "no"));

		}


		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				we_htmlElement::jsElement("", array("src" => JS_DIR . "we_showMessage.js")) .
				we_htmlElement::htmlTitle($GLOBALS["l_versions"]["versioning"])).$fst->getHtmlCode());


	}

	/**
	* returns Javascript for step 2 (1)
	*
	* @return string
	* @param string $folders csv value with directory IDs
	*/
	function getPage2Js($cont, $action, $folders="folders"){
		
		$button = new we_button();
		$disabled = false;
		if($cont) {
			$disabled = true;
		}
		//reset
		$act = 1;
		if($action=="delete") {
			//delete
			$act = 0;
		}
		
		$nextButton = $button->create_button("go","javascript:parent.wizbody.handle_event(\"next\");", true, -1, -1, "","",$disabled, false);
		$publish = isset($_REQUEST['reset_doPublish']) && $_REQUEST['reset_doPublish'] ? 1 : 0;
		$we_transaction = $GLOBALS['we_transaction'];
		$js = 	'window.onload = function(){
					top.focus();
				}
				function handle_event(what){
					f = document.we_form;
					switch(what){
						case "previous":
							f.step.value=1
							f.target="wizbody";
							f.submit();
							break;
						case "next":
						
								selectedValue="";
								for(var i=0;i<f.type.length;i++){
									if(f.type[i].checked){;
										selectedValue = f.type[i].value;
									}
								}
								goTo(selectedValue);
							
						break;
					}
				}
				
				var ajaxURL = "/webEdition/rpc/rpc.php";
				
				var ajaxCallbackDeleteVersionsWizard = {
					success: function(o) {
					if(typeof(o.responseText) != "undefined" && o.responseText != "") {
						parent.wizbusy.document.getElementById("progr").innerHTML = o.responseText;
						' . we_message_reporting::getShowMessageCall( addslashes($GLOBALS["l_versions"]["deleteDateVersionsOK"] ? $GLOBALS["l_versions"]["deleteDateVersionsOK"] : ""), WE_MESSAGE_NOTICE ) . '
						// reload current document => reload all open Editors on demand
						
						var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
						for (frameId in _usedEditors) {
			
							if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
								_usedEditors[frameId].setEditorReloadAllNeeded(true);
								_usedEditors[frameId].setEditorIsActive(true);
			
							} else {
								_usedEditors[frameId].setEditorReloadAllNeeded(true);
							}
						}
						_multiEditorreload = true;
			
						//reload tree
						top.opener.we_cmd("load", top.opener.treeData.table ,0);
						top.close();
					}
				},
					failure: function(o) {
					}
				}
				
				var ajaxCallbackResetVersionsWizard = {
					success: function(o) {
					if(typeof(o.responseText) != "undefined" && o.responseText != "") {
						parent.wizbusy.document.getElementById("progr").innerHTML = o.responseText;
						' . we_message_reporting::getShowMessageCall( addslashes($GLOBALS["l_versions"]["resetAllVersionsOK"] ? $GLOBALS["l_versions"]["resetAllVersionsOK"] : ""), WE_MESSAGE_NOTICE ) . '
			
						top.close();
					}
				},
					failure: function(o) {
					}
				}

				function goTo(where){
				
					if('.$act.') {
						f = document.we_form;
						switch(where){
							case "delete_versions":
								f.target="wizbody";
								break;
						}
						f.submit();
						
//						parent.wizbusy.document.getElementById("progr").style.display = "block";
//
//						YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackResetVersionsWizard, "protocol=json&publish='.$publish.'&we_transaction='.$we_transaction.'&cns=versionlist&cmd=ResetVersionsWizard");
//					
					}	
					else {
						parent.wizbusy.document.getElementById("progr").style.display = "block";
						//parent.wizbusy.document.getElementById("progr").innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=\'' . IMAGE_DIR . 'busy2.gif\' /></td></tr></table>";  

						YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackDeleteVersionsWizard, "protocol=json&cns=versionlist&cmd=DeleteVersionsWizard");
					
					}
					

				}
				
				

				function set_button_state(alldis) {
					if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){
						top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "enabled");
						if(alldis){
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							top.frames["wizbusy"].showRefreshButton();
						}else{
							top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");
							var nextBut = top.frames["wizbusy"].document.getElementById(\'nextCell\');
				  			nextBut.innerHTML = \''.$nextButton.'\';
						}
					}else{
						setTimeout("set_button_state("+(alldis ? 1 : 0)+")",300);
					}
				}
				set_button_state(false);';
				
		return $js;
	}

	/**
	* returns Javascript for step 2 (1)
	*
	* @return string
	* @param array first element (array[0]) must be a javascript, second element (array[1]) must be the Body HTML
	*/
	function getPage($contents){
		if(!sizeof($contents)){
			return "";
		}
		$headCal = we_htmlElement::linkElement(array("rel"=>"stylesheet","type"=>"text/css","href"=>JS_DIR."jscalendar/skins/aqua/theme.css","title"=>"Aqua")).
			we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar.js")).
			we_htmlElement::jsElement("",array("src"=>WEBEDITION_DIR."we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/calendar.js")).
			we_htmlElement::jsElement("",array("src"=>JS_DIR."jscalendar/calendar-setup.js"));
			
		$headCal .= '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>
					<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>
					<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>
					<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>';
			
		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				$headCal.
				STYLESHEET . "\n" . '<script src="'.JS_DIR.'windows.js" language="JavaScript" type="text/javascript"></script>'."\n".
								($contents[0] ?
								we_htmlElement::jsElement("<!--\n".$contents[0]."\n//-->") :
								"")).
			we_htmlElement::htmlBody(array(
				"class"=>"weDialogBody"

				),
				we_htmlElement::htmlForm(array("name" => "we_form", "method" => "post", "action" => WEBEDITION_DIR . "we_cmd.php"),$contents[1])
			)
		);

	}
}

?>