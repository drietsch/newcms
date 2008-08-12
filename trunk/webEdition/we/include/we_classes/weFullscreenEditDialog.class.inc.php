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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_wysiwyg.class.inc.php");


class weFullscreenEditDialog extends weDialog{

##################################################################################################

	var $JsOnly = true;
	var $ClassName = "weFullscreenEditDialog";
	var $changeableArgs = array("src");

##################################################################################################

	function weFullscreenEditDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["fullscreen_editor"];
		$this->args["src"] = "";
	}

##################################################################################################

	function getDialogContentHTML(){
		$js = '<script language="JavaScript" type="text/javascript">isFullScreen = true;</script>';
		$e = new we_wysiwyg("we_dialog_args[src]",$this->args["screenWidth"]-90,$this->args["screenHeight"]-200,'',$this->args["propString"],$this->args["bgcolor"],$this->args["editname"],$this->args["className"],"",$this->args["outsideWE"],$this->args["xml"],$this->args["removeFirstParagraph"],true,$this->args["baseHref"],$this->args["charset"],$this->args["cssClasses"],$this->args['language']);
		return we_wysiwyg::getHeaderHTML().$js.$e->getHTML();
	}


##################################################################################################

	function getBodyTagHTML(){
		return '<body class="weDialogBody" onUnload="doUnload()"">
';
	}

	function getJs() {
		$js = '
			<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>
			<script language="JavaScript" type="text/javascript"><!--
				var isGecko = false;
				var textareaFocus = false;

				if (navigator.product == \'Gecko\') {
					isGecko = true;
				}

				if (isGecko) {
					document.addEventListener("keyup",doKeyDown,true);
				} else {
					document.onkeydown = doKeyDown;
				}

				function doKeyDown(e) {
					var key;

					if (isGecko) {
						key = e.keyCode;
					} else {
						key = event.keyCode;
					}

					switch (key) {
						case 27:
							top.close();
							break;';

		$js .= '	}
				}

				function weDoOk() {';
					if ($this->pageNr == $this->numPages && $this->JsOnly) {
						$js .= '
							if (!textareaFocus) {
								' . $this->getOkJs() . '
							}';
					}
		$js .= '
				}
				';

		$js .= '
				function IsDigit(e) {
					var key;

					if (isGecko) {
						key = e.charCode;
					} else {
						key = event.keyCode;
					}

					return (((key >= 48) && (key <= 57)) || (key == 0) || (key == 13));
				}

				function openColorChooser(name,value) {
					var win = new jsWindow("colorDialog.php?we_dialog_args[type]=dialog&we_dialog_args[name]="+escape(name)+"&we_dialog_args[color]="+escape(value),"colordialog",-1,-1,400,380,true,false,true,false);
				}

				function IsDigitPercent(e) {
					var key;

					if (isGecko) {
						key = e.charCode;
					} else {
						key = event.keyCode;
					}

					return (((key >= 48) && (key <= 57)) || (key == 37) || (key == 0)  || (key == 13));
				}

				function doUnload() {
					if (jsWindow_count) {
						for (i = 0; i < jsWindow_count; i++) {
							eval("jsWindow" + i + "Object.close()");
						}
					}
				}

				self.focus();
			//-->
			</script>';

		return $js;
	}


##################################################################################################
}