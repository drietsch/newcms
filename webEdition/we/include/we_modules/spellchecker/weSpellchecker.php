<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_html_tools.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/spellchecker.inc.php');
include_once($_SERVER['DOCUMENT_ROOT']. '/webEdition/we/include/we_classes/html/we_multibox.inc.php');

include_once(WE_SPELLCHECKER_MODULE_DIR . '/spellchecker.conf.inc.php');

protect();

htmlTop();

print STYLESHEET;

	if(!isset($_SESSION['dictLang'])) {
		$_SESSION['dictLang'] = $spellcheckerConf['default'];
	}

	$_username = $_SESSION['user']['Username'];
	$_replacement = array('\\','/',':','*','?','<','>','|','"');
	for($_i=0;$_i<count($_replacement);$_i++) {
		$_username = str_replace($_replacement[$_i],'MASK'.$_i,$_username);
	}

	$_user_dict = WE_SPELLCHECKER_MODULE_DIR . '/dict/' . $_username . '@'.$SERVER_NAME. '.dict';

	if(!file_exists($_user_dict ) && file_exists(WE_SPELLCHECKER_MODULE_DIR . '/dict/default.inc.php')) {
			copy(WE_SPELLCHECKER_MODULE_DIR . '/dict/default.inc.php',$_user_dict);
	}

	$_width = 600;
	$space = 5;

	$_mode = 'normal';
	$_editname = '';

	$_applet_code = '<applet name="spellchecker" code="LeSpellchecker.class" archive="lespellchecker.jar" codebase="http://'.$SERVER_NAME.(isset($SERVER_PORT) ? ':'.$SERVER_PORT : ''). WE_SPELLCHECKER_MODULE_PATH . '" width="20" height="20" scriptable mayscript><param name="CODE" value="LeSpellchecker.class"><param name="ARCHIVE" value="lespellchecker.jar"><param name="type" value="application/x-java-applet;version=1.1"><param name="dictBase" value="http://'.$SERVER_NAME.(isset($SERVER_PORT) ? ':'.$SERVER_PORT : ''). WE_SPELLCHECKER_MODULE_PATH . '/dict/"><param name="dictionary" value="'.(isset($_SESSION['dictLang']) ? $_SESSION['dictLang'] : 'Deutsch').'"><param name="debug" value="off"><param name="user" value="'.$_username.'@'.$SERVER_NAME.'"><param name="udSize" value="'.(is_file($_user_dict) ? filesize($_user_dict) : '0').'"></applet>';

	if(isset($_REQUEST['we_dialog_args']['editname'])) {
		$_mode = 'wysiwyg';
		$_editname = $_REQUEST['we_dialog_args']['editname'];


	} else {
		if(isset($_REQUEST['editname'])) {
			$_editname = $_REQUEST['editname'];
		}
	}


?>

<style type="text/css">


#mainPanel {
	width: 100%;
	height: 380px;
}

#previewPanel {
	width: 450px;
	height: 100px;
	margin-bottom: 10px;
}

#spellcheckPanel{
	width: 460px;
	height: 150px;
	padding: 5px;
	margin-bottom: 5px;
}

#preview {
	overflow: auto !important;
	border: 1px solid #AAAAAA;
	background: #EEEEEE;
	width: 450px;
	height: 120px;
	margin-bottom: 5px;
}

#searchPanel {
	float: left;
	width: 340px;
	height: 150px;
}

#search {
	float: left;
	width: 330px;
}

#suggestion {
	width: 330px;
	height: 100px;
	border: 1px solid gray;
	z-index: 3;
}

#buttonPanel {
	float:right;
}

#appletPanel {
	display: block;
}

#dictPanel {
	width: 464px;
	height: 40px;
	padding: 3px;
}

#dictSelect {
	width: 350px;
}

#spinner {
	width: 500px;
	height: 450px;
	z-index: 1;
	position: absolute;
	left:0px;
	top:0px;
	background: white;
	<?php if($BROWSER=='IE') {?>
	filter: alpha(opacity=80);
	<?php }else if($BROWSER=='SAFARI') {?>
	KhtmlOpacity: .8;
	<?php } else {?>
	opacity: .8;
	<?php }?>
}

.highlight {
	color:blue;
	background-color:yellow;
}

</style>

  <script type="text/javascript">

  	var orginal;
  	var editPanel;
  	var to;
  	var found;
  	var editorObj;
  	var rangeSelection = false;
  	var currentWord="";
  	var retry = 0;
  	var retryjava = 0;

  	function customAdapter() {

  		this.innerHTML;

  		this.getSelectedText = function(){

  		}

  	}

  	function setDialog() {
  		<?php if($_mode=='wysiwyg'):?>
  		editorObj = top.opener.weWysiwygObject_<?php print $_editname?>;
  		var text = getTextFromWysiwyg();

  		<?php else:?>

  		var elements = top.opener.document.getElementsByName("<?php print $_editname?>");

  		if(elements[0]) {
  			editorObj = elements[0];
  			var text = editorObj.value;
  		}

  		<?php endif?>

  		orginal = text;
  		editPanel = document.getElementById('preview');
  		editPanel.innerHTML = text;
  		setTimeout("setAppletCode()",1000);
  	}

  	function getTextFromWysiwyg() {
  		var text = "";
  		<?php if($_mode=='wysiwyg'):?>
  		editorObj = top.opener.weWysiwygObject_<?php print $_editname?>;
  		<?php else:?>
  		var elements = top.opener.document.getElementsByName("<?php print $_editname?>");
  		if(elements[0]) {
  			editorObj = elements[0];
  		}
  		<?php endif?>

  		if(editorObj.getSelectedText) {
  			text = editorObj.getSelectedText();
  			rangeSelection = true;
  		} else if(editorObj.dom.getSelectedText) {
  			text = editorObj.dom.getSelectedText();
  			rangeSelection = true;

  		}

  		if(text=="") {
  			text = editorObj.getHTML();
  			rangeSelection = false;
  		}

  		return text;
  	}

	function fade(id,opacity) {
		var styleObj = document.getElementById(id).style;
	    styleObj.opacity = (opacity / 100);
	    styleObj.MozOpacity = (opacity / 100);
	    styleObj.KhtmlOpacity = (opacity / 100);
	    styleObj.filter = "alpha(opacity=" + opacity + ")";
	}

	function fadeout(id,from,step,speed) {
		fade(id,from);
		if(from==0) {
			document.getElementById(id).style.display="none";
		} else {
			setTimeout("fadeout(\""+id+"\","+(from-step)+","+step+","+speed+")",speed);
		}
	}

	function apply() {
		<?php if($_mode=='wysiwyg'){?>
		 if(rangeSelection) {
		 	editorObj.replaceText(orginal);
		 } else {
		 	editorObj.setText(orginal);
		 }
		 <?php }else{?>
		 editorObj.value = orginal;
		 <?php }?>
	}

	function spellcheck() {
		retry = 0;
		if(document.spellchecker.isReady) {
			document.getElementById("statusText").innerHTML = "<?php print $l_spellchecker['checking'];?>";
			var text = getTextOnly(orginal);
			document.spellchecker.check(text);
			setTimeout("findNext()",2000);
		} else {
			if(retryjava<5) {
				setTimeout("spellcheck()",1000);
				retryjava++;
			} else {
				<?php print we_message_reporting::getShowMessageCall( $l_spellchecker['no_java'], WE_MESSAGE_ERROR); ?>
				self.close();
			}
		}
	}


	function findNext() {
			if(document.spellchecker.isReady) {

				if(document.spellchecker.isReady()) {

					if(document.spellchecker.nextSuggestion()) {

							fadeout("spinner",80,10,10);

							document.we_form.search.value = document.spellchecker.getMisspelledWord();
							currentWord = document.we_form.search.value;
							markWord(document.we_form.search.value);
							found = document.we_form.search.value;
							var suggs = document.spellchecker.getSuggestions();
							suggs = suggs + "";
							var suggA = suggs.split("|");
							document.we_form.suggestion.options.length = 0;
							if(suggA.length>1) {
								for(var i=0;i<suggA.length;i++) {
									document.we_form.suggestion.options[document.we_form.suggestion.options.length] = new Option(suggA[i],suggA[i]);
									if(i==0) {
										document.we_form.suggestion.options.selectedIndex = 0;
										document.we_form.search.value = suggA[i];
									}
								}
							}
							enableButtons();
						} else {
							disableButtons();

							if(document.spellchecker.isWorking()) {
								clearTimeout(to);
								to = setTimeout("findNext()",500);
							} else {
								removeHighlight();
								if(document.getElementById("spinner").style.display!="none") {
									fadeout("spinner",80,10,10);
								}
								weButton.enable("check");
								<?php print we_message_reporting::getShowMessageCall( $l_spellchecker['finished'], WE_MESSAGE_NOTICE); ?>
							}
					}
			} else {
				setTimeout("spellcheck()",500);
			}
		}
	}

	function add() {
		if(document.spellchecker.isReady) {
			document.spellchecker.addWord(currentWord);
			hiddenCmd.dispatch("addWord",currentWord);
			findNext();
		} else {
			<?php print we_message_reporting::getShowMessageCall( "A fatal error occured", WE_MESSAGE_ERROR); ?>
		}
	}


	function markWord(word){
		editPanel.innerHTML = orginal;
		editPanel.innerHTML = replaceWord(editPanel.innerHTML,word);

		var first = document.getElementById("highlight0");
		if(first) {
			if(first.offsetTop-30>0) {
				editPanel.scrollTop = first.offsetTop-30;
			} else {
				editPanel.scrollTop = 0;
			}
		}
	}

	function changeWord() {
		if(document.spellchecker.isReady) {
			editPanel.innerHTML = orginal;
			editPanel.innerHTML = replaceWord(editPanel.innerHTML,found,document.we_form.search.value);
			orginal = editPanel.innerHTML;
			findNext();
		}
	}

	function removeHighlight() {
		editPanel.innerHTML = orginal;
	}

	function replaceWord(text, search) {

	  var replacement = "";
	  var i = -1;
	  var c = 0;
	  var searchsmall = search.toLowerCase();
	  var textsmall = text.toLowerCase();

	  while (text.length > 0) {

	    i = textsmall.indexOf(searchsmall, i+1);
	    if (i < 0) {
	      replacement += text;
	      text = "";
	    } else {

	    	var next = textsmall.substr(i + searchsmall.length,1);
          	var last = textsmall.substr(i-1,1);

			if(next.search("[a-zA-Z0-9]")==-1 && last.search("[a-zA-Z0-9]")==-1) {

		      if (text.lastIndexOf(">", i) >= text.lastIndexOf("<", i)) {
		        if (textsmall.lastIndexOf("/script>", i) >= textsmall.lastIndexOf("<script", i)) {

		        	if(arguments[2]) {
		        		replacement += text.substring(0, i) +  arguments[2];
		        	} else {
		        		replacement += text.substring(0, i) + "<span class='highlight' id='highlight"+c+"'>" + text.substr(i, search.length) + "</span>";
		        		c++;
		        	}

		        	text = text.substr(i + search.length);
					textsmall = text.toLowerCase();
					i = -1;
		        }
		      }
	      }
	    }
	  }

	  return replacement;
	}



	function getTextOnly(text) {

		var newtext  = text.replace(/(<([^>]+)>)/ig," ");
		newtext  = newtext.replace(/\&([^; ]+);/ig," ");
		newtext  = newtext.replace("&amp;","&");
		return newtext;

	}

	function selectDict(dict) {
		hiddenCmd.dispatch("setLangDict",dict);
	}

	function reloadDoc() {
		location.reload();
	}

	function enableButtons() {
		weButton.enable("ignore");
		weButton.enable("change");
		weButton.enable("add");
	}

	function disableButtons() {
		weButton.disable("ignore");
		weButton.disable("change");
		weButton.disable("add");
		weButton.disable("check");
	}

	function setAppletCode() {
		retryjava = 0;
		document.getElementById('appletPanel').innerHTML = '<?php print addslashes($_applet_code)?>';
		setTimeout("spellcheck()",1000);
	}

<?php
	$we_button = new we_button();
	print $we_button->create_state_changer(false);

?>

  </script>


	</head>

	<body class="weDialogBody" onload="setDialog()">

<?php

	$_preview = '
		<div id="preview" class="defaultfont">
		</div>
	';


	$_leftPanel = '
	<div id="searchPanel">
		<input class="wetextinput" name="search" id="search" />
		<br />
		<label for="suggestion" class="defaultfont">'.$l_spellchecker['suggestion'].'</label>
		<select name="suggestion" id="suggestion" size="5" class="wetextinput" onchange="document.we_form.search.value=this.value;">
		</select>

	</div>
	';


	$_buttonsleft[] = $we_button->create_button("ignore", "javascript:findNext();",true,100,22,'','',true,false);
	$_buttonsleft[] = $we_button->create_button("change", "javascript:changeWord();",true,100,22,'','',true,false);
	$_buttonsleft[] = $we_button->create_button("add", "javascript:add();",true,100,22,'','',true,false);
	$_buttonsleft[] = $we_button->create_button("check", "javascript:weButton.disable(\"check\");setTimeout(\"spellcheck();\",100);",true,100,22,'','',true,false);




	$_applet =
	'
		<div id="appletPanel" style="position: absolute; left:0px; top:900px; display: block; border: 0px; width: 0px; height 0px;">

		</div>
		'
	;

	$_buttons = array();
	$_buttons[] = $we_button->create_button("apply", "javascript:apply();self.close();");
	$_buttons[] = $we_button->create_button("cancel", "javascript:self.close();");
	$_buttons_bottom = $we_button->position_yes_no_cancel($_buttons[0], null, $_buttons[1]);

	$_parts = array();


	$_parts[] =  array(
		'headline' => '',
		'html' => $_preview ,
		'space' => 0
	);

	$_parts[] =  array(
		'headline' => '',
		'html' => $_leftPanel . implode('<div style="margin:5px;"></div>',$_buttonsleft) ,
		'space' => 0
	);


	$_selectCode = '
		<select name="dictSelect" id="dictSelect" size="1" onchange="selectDict(this.value)">
	';

	$_dir = dir(WE_SPELLCHECKER_MODULE_DIR . 'dict');
	$_i = 0;
	while (false !== ($entry = $_dir->read())) {
		if($entry != '.' && $entry != '..' && ereg('.zip',$entry)){
			$_name = str_replace('.zip','',$entry);
			if(in_array($_name,$spellcheckerConf['active'])) {
				$_selectCode .= '<option value="'.$_name.'" '.((isset($_SESSION['dictLang']) && $_SESSION['dictLang']==$_name) ? 'selected' : '').'>'.$_name.'</option>';
			}
		}
	}
	$_dir->close();

	$_selectCode .= '
		</select>
	';

	$_parts[] =  array(
		'headline' => $l_spellchecker['dictionary'],
		'html' => $_selectCode,
		'space' => 100

	);


	print '
	<div id="spinner">
		<center>
			<div style="padding-top: 30%;">
				<img src="'.IMAGE_DIR.'/spinner.gif"/><br />
				<div id="statusText" class="small" style="color: black;">'.$l_spellchecker['download'].'</div>
			</div>
		</center>
	</div>

	<form name="we_form" action="'.WE_SPELLCHECKER_MODULE_PATH.'weSpellchecker.php" method="post" target="_self">

	<input name="' . ($_mode=='wysiwyg' ? 'we_dialog_args[editname]': 'editname') . '" value="'.$_editname.'" type="hidden">
	<div id="mainPanel">
	'.

	we_multiIconBox::getHTML('',"100%",$_parts,30,$_buttons_bottom,-1,'','',false, $l_spellchecker['spellchecker'])
	.
	'
	</div>
	</form>
	' . $_applet .
	'<iframe name="hiddenCmd" id="hiddenCmd" style="position: absolute; left:0px; top:800px; display: block; border: 0px; width: 0px; height 0px;" src="'.WE_SPELLCHECKER_MODULE_PATH.'weSpellcheckerCmd.php"></iframe>'
	;


?>

	</body>

</html>