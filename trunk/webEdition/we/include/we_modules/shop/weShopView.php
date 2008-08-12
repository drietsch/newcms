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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
include_once(WE_SHOP_MODULE_DIR."weShop.php");

class weShopView {

	var $db;
	var $frameset;

	var $topFrame;
	var $raw;


	function weShopView($frameset="",$topframe="top.content") {
		$this->db = new DB_WE();
		$this->setFramesetName($frameset);
		$this->setTopFrame($topframe);
		$this->raw=new weShop();

	}

	//----------- Utility functions ------------------

	function htmlHidden($name, $value = "") {
		return we_htmlElement::htmlHidden(array("name"=>trim($name),"value"=>htmlspecialchars($value)));
	}


	//-----------------Init -------------------------------

	function setFramesetName($frameset){
		$this->frameset=$frameset;
	}

	function setTopFrame($frame){
		$this->topFrame=$frame;
	}

	//------------------------------------------------


	function getCommonHiddens($cmds=array()){
		$out=$this->htmlHidden("cmd",(isset($cmds["cmd"]) ? $cmds["cmd"] : ""));
		$out.=$this->htmlHidden("cmdid",(isset($cmds["cmdid"]) ? $cmds["cmdid"] : ""));
		$out.=$this->htmlHidden("pnt", (isset($cmds["pnt"]) ? $cmds["pnt"] : ""));
		$out.=$this->htmlHidden("tabnr",(isset($cmds["tabnr"]) ? $cmds["tabnr"] : ""));
		return $out;
	}

	function getJSTop(){

		$js='
			var get_focus = 1;
			var activ_tab = 1;
			var hot= 0;
			var scrollToVal=0;

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]) {
					case "new_raw":
						if('.$this->topFrame.'.resize.right.editor.edbody.loaded) {
							'.$this->topFrame.'.hot = 1;
							'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value = arguments[0];
							'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmdid.value = arguments[1];
							'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.tabnr.value = 1;
							'.$this->topFrame.'.resize.right.editor.edbody.submitForm();
						} else {
							setTimeout(\'we_cmd("new_raw");\', 10);
						}
						break;

					case "delete_raw":
						if(top.content.resize.right.editor.edbody.document.we_form.cmd.value=="home") return;
						'.(!we_hasPerm("DELETE_RAW") ?
						(	we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["no_perms"], WE_MESSAGE_ERROR))
						:
						('
								if ('.$this->topFrame.'.resize.right.editor.edbody.loaded) {
									if (confirm("'.$GLOBALS["l_raw"]["delete_alert"].'")) {
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value=arguments[0];
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
										'.$this->topFrame.'.resize.right.editor.edbody.submitForm();
									}
								} else {
									' . we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["nothing_to_delete"], WE_MESSAGE_ERROR) . '
								}

						')).'
						break;

					case "save_raw":
						if(top.content.resize.right.editor.edbody.document.we_form.cmd.value=="home") return;


								if ('.$this->topFrame.'.resize.right.editor.edbody.loaded) {
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value=arguments[0];
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;

										'.$this->topFrame.'.resize.right.editor.edbody.submitForm();
								} else {
									' . we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["nothing_to_save"], WE_MESSAGE_ERROR) . '
								}

						break;

					case "edit_raw":
						'.$this->topFrame.'.hot=0;
						'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value=arguments[0];
						'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmdid.value=arguments[1];
						'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
						'.$this->topFrame.'.resize.right.editor.edbody.submitForm();
					break;
					case "load":
						'.$this->topFrame.'.cmd.location="'.$this->frameset.'?pnt=cmd&pid="+arguments[1]+"&offset="+arguments[2]+"&sort="+arguments[3];
					break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("top.opener.top.we_cmd(" + args + ")");
				}
			}
			';

			return we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).we_htmlElement::jsElement($js);
	}

	function getJSProperty(){

		$out="";
		$out.=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));

		$js='
			var loaded=0;

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]) {
					case "switchPage":
						document.we_form.cmd.value=arguments[0];
						document.we_form.tabnr.value=arguments[1];
						submitForm();
						break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("top.content.we_cmd("+args+")");
				}
			}


			'.$this->getJSSubmitFunction().'

		';

		$out.=we_htmlElement::jsElement($js);
		return $out;
	}



function getJSTreeHeader(){
	return '

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd(){
				var args = "";
				var url = "'.$this->frameset.'?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]) {
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
						}
						eval(\'top.content.we_cmd(\'+args+\')\');
				}
			}

	'.$this->getJSSubmitFunction("cmd");
}



function getJSSubmitFunction($def_target="edbody",$def_method="post"){
	return '
			function submitForm() {
				var f = self.document.we_form;

				if (arguments[0]) {
					f.target = arguments[0];
				} else {
					f.target = "'.$def_target.'";
				}

				if (arguments[1]) {
					f.action = arguments[1];
				} else {
					f.action = "'.$this->frameset.'";
				}

				if (arguments[2]) {
					f.method = arguments[2];
				} else {
					f.method = "'.$def_method.'";
				}

				f.submit();
			}

	';

}

function processCommands() {
		if (isset($_REQUEST["cmd"])) {
			switch ($_REQUEST["cmd"]) {
				case "new_raw":
					$this->raw = new weShop();
					print we_htmlElement::jsElement('
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->raw->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
					');
					break;
				case "edit_raw":
					$this->raw = new weShop($_REQUEST["cmdid"]);
					print we_htmlElement::jsElement('
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->raw->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
					');
					break;
				case "save_raw":
						$js="";

						if($this->raw->filenameNotValid()){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["we_filename_notValid"], WE_MESSAGE_ERROR)
							);
							break;
						}


						$newone=true;
						if($this->raw->ID) $newone=false;

						$this->raw->save();

						$tt="";
						$ttrow=getHash("SELECT * FROM ".RAW_TABLE." WHERE ID='".$this->raw->ID."';",$this->db);
						$tt=addslashes($tt!="" ? $tt : $this->raw->Text);
						if ($newone) {
							$js='
									var attribs = new Array();
									attribs["icon"]=\''.$this->raw->Icon.'\';
									attribs["id"]=\''.$this->raw->ID.'\';
									attribs["typ"]=\'item\';
									attribs["parentid"]=\'0\';
									attribs["text"]=\''.$tt.'\';
									attribs["disable"]=\'0\';
									attribs["tooltip"]=\'\';

									'.$this->topFrame.'.treeData.addSort(new '.$this->topFrame.'.node(attribs));
							'. $this->topFrame.'.drawTree();';
						} else {
							$js=''.$this->topFrame.'.updateEntry('.$this->raw->ID.',"'.$tt.'");'."\n";
						}
						print we_htmlElement::jsElement(
							$js .
							we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["raw_saved_ok"], WE_MESSAGE_NOTICE)
						);
					break;
				case "delete_raw":

						$js=''.$this->topFrame.'.deleteEntry('.$this->raw->ID.');'."\n";

						$this->raw->delete();
						$this->raw=new weShop();

						print we_htmlElement::jsElement(
							$js .
							we_message_reporting::getShowMessageCall( $GLOBALS["l_raw"]["raw_deleted"], WE_MESSAGE_NOTICE)
						);
				break;
				case "switchPage":

				break;

				default:
			}
		}

		$_SESSION["raw_session"]=serialize($this->raw);
	}


	function processVariables() {

		if(isset($_SESSION["raw_session"])){

			$this->raw=unserialize($_SESSION["raw_session"]);

		}

		if (is_array($this->raw->persistent_slots)) {
			foreach ($this->raw->persistent_slots as $key=>$val) {
				$varname=$val;
				if (isset($_REQUEST[$varname])) {
					eval('$this->raw->'.$val.'="'.addslashes($_REQUEST[$varname]).'";');
				}
			}
		}

		if(isset($_REQUEST["page"]))
		if (isset($_REQUEST["page"])) {
			$this->page=$_REQUEST["page"];
		}

	}


	function new_array_splice(&$a,$start,$len=1){
		$ks=array_keys($a);
		$k=array_search($start,$ks);
		if($k!==false){
			$ks=array_splice($ks,$k,$len);
			foreach($ks as $k) unset($a[$k]);
		}
	}


}

?>