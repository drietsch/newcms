<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

class weDialog{

	/*************************************************************************
	 * VARIABLES
	 *************************************************************************/

	var $db = "";
	var $what = "";
	var $args = array();
	var $cmdFN = "";
	var $okJsFN = "";
	var $dialogTitle = "";
	var $ClassName = "weDialog";
	var $changeableArgs = array();
	var $pageNr = 1;
	var $numPages = 1;
	var $JsOnly = false;
	var $dialogWidth = 350;
	var $charset = "";

	/*************************************************************************
	 * CONSTRUCTOR
	 *************************************************************************/

	/**
	 * Constructor of class.
	 *
	 * @return     weDialog
	 */

	function weDialog() {
		$this->db = new DB_WE();
	}

	/*************************************************************************
	 * FUNCTIONS
	 *************************************************************************/

	function setTitle($title) {
		$this->dialogTitle = $title;
	}

	function registerOkJsFN($fnName) {
		$this->okJsFN = $fnName;
	}

	function registerCmdFn($fnName) {
		$this->cmdFN = $fnName;
	}

	function initByHttp() {
		$this->what = isset($_REQUEST["we_what"]) ? $_REQUEST["we_what"] : "";

		if (isset($_REQUEST["we_dialog_args"]) && is_array($_REQUEST["we_dialog_args"])) {
			$this->args = $_REQUEST["we_dialog_args"];
			foreach($this->args as $key => $value) {
				$this->args[$key] = urldecode($value);
			}
		}

		if (isset($_REQUEST["we_pageNr"])) {
			$this->pageNr = $_REQUEST["we_pageNr"];
		}
	}

	function getHTML() {
		if ($this->JsOnly) {
			$this->what="dialog";
		}

		switch ($this->what) {
			case "dialog":
				return  $this->getHeaderHTML(true).
						$this->getBodyTagHTML().
						$this->getDialogHTML().
						$this->getFooterHTML();
			case "cmd":
				return  $this->getCmdHTML();

			default:

				return  $this->getHeaderHTML().
						$this->getFramesetHTML().
						$this->getBodyTagHTML().
						$this->getFooterHTML();
		}
	}

	function getCmdHTML(){
		$fn = $this->cmdFN;
		$send = array();

		// " quote for correct work within ""
		foreach ($this->args as $k => $v){
			$send[$k]=str_replace('"','\"',$v);
		}
		if($this->cmdFN) {
			return $fn($send);
		}else{
			return $this->cmdFunction($send);
		}
	}

	function cmdFunction($args){
		// overwrite
	}

	function getOkJs(){
		if($this->okJsFN) {
			$fn = $this->okJsFN;
			return $fn();
		}
	}

	function getQueryString($what=""){
		$query = "";
		if(isset($_REQUEST["we_cmd"]) && is_array($_REQUEST["we_cmd"])){
			foreach($_REQUEST["we_cmd"] as $k=>$v){
				$query .= "we_cmd[".rawurlencode($k)."]=".rawurlencode($v)."&";
			}
		}
		if (isset($this->args) && is_array($this->args)) {
			foreach($this->args as $k=>$v){
				$query .= "we_dialog_args[".rawurlencode($k)."]=".rawurlencode($v)."&";
			}
		}
		return eregi_replace('^(.+)&$','\1',$query).($what ? "&we_what=".rawurlencode($what) : "");
	}

	function getFramesetHTML() {
		return '
			<script language="JavaScript" type="text/javascript"><!--
				var isGecko = false;

				if (navigator.product == \'Gecko\') {
					isGecko = true;
				}

				if (!isGecko) {
					document.onkeydown = doKeyDown;
				}

				function doKeyDown() {
					var key = event.keyCode;

					switch(key) {
						case 27:
							top.close();
							break;

						case 13:
							self.we_' . $this->ClassName . '_edit_area.weDoOk();
							break;
					}
				}

			//-->
			</script>

			<frameset rows="*,0" framespacing="0" border="0" frameborder="no">
				<frame src="' . $_SERVER["PHP_SELF"] . '?' . $this->getQueryString("dialog") . '" name="we_' . $this->ClassName . '_edit_area" scrolling="no" noresize="noresize">
				<frame src="/webEdition/html/white.html" name="we_'.$this->ClassName.'_cmd_frame" scrolling="no" noresize="noresize">
			</frameset>';
	}

	function getNextBut() {
		$we_button = new we_button();
		return $we_button->create_button("next", "javascript:document.forms['0'].submit();");
	}

	function getOkBut() {
		$we_button = new we_button();
		return $we_button->create_button("ok", "javascript:weDoOk();");
	}

	function getbackBut() {
		$we_button = new we_button();
		return ($this->pageNr > 1) ? $we_button->create_button("back", "javascript:history.back();") . getPixel(10,2) : "";
	}

	function getDialogHTML() {

		include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

		$dc = $this->getDialogContentHTML();

		if (is_array($dc)) {
			$dialogContent = we_multiIconBox::getHTML("","100%",$dc,30,$this->getDialogButtons(),-1,"","",false,$this->dialogTitle,"",$this->getDialogHeight());
		} else {
			$dialogContent = htmlDialogLayout($dc, $this->dialogTitle, $this->getDialogButtons());
		}
		return $this->getFormHTML() . $dialogContent .
			'<input type="hidden" name="we_what" value="cmd">' . $this->getHiddenArgs() . '</form>';
	}

	function getDialogHeight() {
		return "";
	}

	function getDialogButtons(){
		$we_button = new we_button();

		if ($this->pageNr == $this->numPages && $this->JsOnly == false) {
			$okBut = ($this->getBackBut() != "") ? $we_button->create_button_table(array($this->getBackBut(), $we_button->create_button("ok", "form:we_form"))) : $we_button->create_button("ok", "form:we_form");
		} else if ($this->pageNr < $this->numPages) {
			$okBut = (($this->getBackBut() != "") && ($this->getNextBut()) != "") ? $we_button->create_button_table(array($this->getBackBut(), $this->getNextBut())) : (($this->getBackBut() == "") ? $this->getNextBut() : $this->getBackBut());
		} else {
			$okBut = (($this->getBackBut() != "") && ($this->getOkBut()) != "") ? $we_button->create_button_table(array($this->getBackBut(), $this->getOkBut())) : (($this->getBackBut() == "") ? $this->getOkBut() : $this->getBackBut());
		}

		return $we_button->position_yes_no_cancel(	$okBut,
														"",
														$we_button->create_button("cancel", "javascript:top.close();"));
	}

	function getFormHTML() {
		$hiddens = "";
		if(isset($_REQUEST["we_cmd"]) && is_array($_REQUEST["we_cmd"])){
			foreach($_REQUEST["we_cmd"] as $k=>$v){
				$hiddens .= "<input type=\"hidden\" name=\"we_cmd[$k]\" value=\"".rawurlencode($v)."\">";
			}
		}
		$target = '';
		if(!$this->JsOnly) {
			$target = ' target="we_'.$this->ClassName.'_cmd_frame"';
		}
		return '<form name="we_form" action="'.$_SERVER["PHP_SELF"].'" method="post"' . $target . '>'.$hiddens;
	}

	function getHiddenArgs() {
		$hiddenArgs = "";

		foreach ($this->args as $k=>$v) {
			if (!in_array($k,$this->changeableArgs)) {
				$hiddenArgs .= '<input type="hidden" name="we_dialog_args['.$k.']" value="'.htmlspecialchars($v).'">';
			}
		}
		return $hiddenArgs;
	}

	function getDialogContentHTML() {
		return ""; // overwrite !!
	}

	function getHeaderHTML($printJS_Style=false) {
		$out = htmlTop($this->dialogTitle,$this->charset);

		if ($printJS_Style) {
			$out .= "\n". STYLESHEET ."\n";
			$out .= $this->getJs();
		}

		$out .= '</head>';
		return $out;
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

						if ($this->pageNr == $this->numPages && $this->JsOnly) {
							$js .= '
								case 13:
									if (!textareaFocus) {
										weDoOk();
									}
									break;';
						}
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

				function IsDigit(e) {
					var key;

					if (e.charCode == undefined) {
						key = event.keyCode;
					} else {
						key = e.charCode;
					}

					return (((key >= 48) && (key <= 57)) || (key == 0) || (key == 13)  || (key == 8) || (key <= 63235 && key >= 63232) || (key == 63272));
				}

				function openColorChooser(name,value) {
					var win = new jsWindow("colorDialog.php?we_dialog_args[type]=dialog&we_dialog_args[name]="+escape(name)+"&we_dialog_args[color]="+escape(value),"colordialog",-1,-1,400,380,true,false,true,false);
				}

				function IsDigitPercent(e) {
					var key;
					if (e.charCode == undefined) {
						key = event.keyCode;
					} else {
						key = e.charCode;
					}

					return (((key >= 48) && (key <= 57)) || (key == 37) || (key == 0) || (key == 46)  || (key == 101)  || (key == 109)  || (key == 13)  || (key == 8) || (key <= 63235 && key >= 63232) || (key == 63272));
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

	function formColor($size, $name, $value, $width="") {
		return '<input size="'.$size.'" type="text" name="'.$name.'" style="'.($width ? 'width:'.$width.'px;' : '').'background-color:'.$value.'" value="'.$value.'" onclick="openColorChooser(\''.$name.'\',this.value);" readonly>';
	}

	function getBodyTagHTML() {
		return '<body class="weDialogBody" onUnload="doUnload()">';
	}

	function getFooterHTML(){
		return '</body></html>'."\n";
	}

	function getHttpVar($name, $alt="") {
		return isset($_REQUEST["we_dialog_args"][$name]) ? $_REQUEST["we_dialog_args"][$name] : $alt;
	}

	function getLangField($name,$title,$width){
		$foo = htmlTextInput("we_dialog_args[".$name."]", 15, (isset($this->args[$name]) ? $this->args[$name] :""), "", '', "text" , $width-50 );
		$foo2 = '<select style="width:50px;" class="defaultfont" name="'.$name.'_select" size="1" onchange="this.form.elements[\'we_dialog_args['.$name.']\'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;">
							<option value=""></option>
							<option value="en">en</option>
							<option value="de">de</option>
							<option value="es">es</option>
							<option value="fi">fi</option>
							<option value="ru">ru</option>
							<option value="fr">fr</option>
							<option value="nl">nl</option>
							<option value="pl">pl</option>
						</select>';
		return htmlFormElementTable($foo,$title,"left","defaultfont",$foo2);
	}

}