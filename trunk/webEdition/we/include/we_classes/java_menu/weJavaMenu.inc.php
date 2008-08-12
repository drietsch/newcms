<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");

class weJavaMenu {
	var $entries;
	var $lcmdFrame = "";
	var $protocol = "http";
	var $SERVER_NAME = "";
	var $width = 200;
	var $height = 30;
	var $port = "";
	var $prename = "";

	function weJavaMenu($entries, $SERVER_NAME, $lcmdFrame="top.load", $protocol="http", $port="", $width=200, $height=30, $prename="") {
		$this->prename = $prename;
		if($entries){
			$this->entries = $entries;
			if($GLOBALS["BROWSER"] == "NN6"){
				$_SESSION[$prename."menuentries"] = $this->entries;
			}
		}else if(isset($_SESSION[$prename."menuentries"])){
			$this->entries = $_SESSION[$prename."menuentries"];
			unset($_SESSION[$prename."menuentries"]);
		}
		$this->SERVER_NAME = $SERVER_NAME;
		$this->lcmdFrame = $lcmdFrame;
		$this->protocol = $protocol;
		$this->width = $width;
		$this->height = $height;
		$this->port = $port;
	}

	function printMenu() {
		print $this->getCode();
	}
	
	function getCode() {
		
		$ffJavaMenu = false;
		if (preg_match('@gecko/([^ ]+)@i',$_SERVER["HTTP_USER_AGENT"],$regs)) {
			if (abs($regs[1]) > 20070309) {
				$ffJavaMenu = true;
			}
		}

		return $this->getJS() . ( (!$ffJavaMenu && $GLOBALS["BROWSER"] == "NN6") ? $this->getMozillaMenuHTML() : $this->getHTML() );
	}
	function getMozillaMenuHTML(){
		return '<iframe src="'.WEBEDITION_DIR.'mozillamenu.php?wecharset='.rawurlencode($GLOBALS["_language"]["charset"]).($this->prename != "" ? "&pre=".$this->prename : "").'" frameborder="0" style="position:absolute;left:0px;top:5px; width:' . $this->width . '"px"></iframe>';
	}
	function getJS() {
		
		$portVar = (
			($this->port==80 && $this->protocol=="http") || 
			($this->port==443 && $this->protocol=="https") ||
			(!$this->port)
		) ? "" : ":".$this->port;
		return '
			<script type="text/javascript" src="' . JS_DIR . 'attachKeyListener.js"></script>
			<script language="JavaScript" type="text/javascript"><!--
				function menuaction(cmd) {
					'.$this->lcmdFrame.'.location.replace("'.$this->protocol.'://'.$this->SERVER_NAME.$portVar.'/webEdition/we_lcmd.php?we_cmd[0]="+cmd);
				}
			//-->
			</script>';
	}
	function getXUL($charset="iso-8859-1"){

		$out = '<?xml version="1.0" encoding="'.$charset.'"?>

<?xml-stylesheet href="/webEdition/css/mozillamenu.php" type="text/css"?>

<window xmlns:html="http://www.w3.org/1999/xhtml"
        xmlns="http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul">
<hbox align="top">
    <toolbar id="a-toolbar" grippyhidden="true">
 ';
		$menus = array();

		$i=0;
		foreach ($this->entries as $id=>$e) {

			if ($e["parent"] == "000000") {
				if(is_array($e["text"])) {
					$mtext = ($e["text"][$GLOBALS["WE_LANGUAGE"]] ? $e["text"][$GLOBALS["WE_LANGUAGE"]] : "");
				}
				else {
					$mtext = ($e["text"] ? $e["text"] : "");
				}
				$menus[$i]["id"] = $id;
				$menus[$i]["code"] = '<toolbarseparator /><toolbarbutton label="'.$mtext.'" type="menu"><menupopup>'."\n";
				$i++;
			}
		}

		for ($i=0;$i<sizeof($menus);$i++) {
			$foo = $menus[$i]["code"];
			$this->h_pXUL($this->entries,$foo,$menus[$i]["id"],"");
			$foo .= "</menupopup></toolbarbutton>\n";
			$out .= $foo;
		}

  $out .=    '</toolbar>

</hbox>

</window>
';
  		return $out;
	}
	function getHTML() {
		$showAltMenu = (isset($_SESSION['weShowAltMenu']) && $_SESSION['weShowAltMenu']) || (isset($_REQUEST["showAltMenu"]) && $_REQUEST["showAltMenu"]);
		$_SESSION['weShowAltMenu'] = $showAltMenu;
		// On Mozilla OSX, when the Java Menu is loaded, it is not possible to make any text input (java steels focus from input fields or e.g) so we dont show the applet.

		$out = '';

		if(!$showAltMenu) {
			$out .= '
				<div id="divForSelectMenu"></div>
				<applet name="weJavaMenuApplet" code="menuapplet"  archive="menuapplet.zip"  codebase="'.$this->protocol.'://'.$this->SERVER_NAME.($this->port ? (":".$this->port) : "").'/webEdition/menuapplet" align="baseline" width="'.$this->width.'" height="'.$this->height.'" mayscript scriptable>
					<param name="cabbase" value="menuapplet.cab">
					<param name="phpext" value=".php">';
			$i=0;
			foreach ($this->entries as $id=>$m) {
				if(we_hasPerm('ADMINISTRATOR')) {
					$m['enabled'] = 1;
				}
				if (!we_hasPerm('ADMINISTRATOR') && (isset($m["perm"]) && $m["perm"]) != "") {
					$set=array();
					$or=explode("||",$m["perm"]);
					foreach ($or as $k=>$v) {
						$and=explode("&&",$v);
						$one=true;
						foreach($and as $key=>$val) {
							array_push($set,'isset($_SESSION["perms"]["'.trim($val).'"])');
							//$and[$key]='$_SESSION["perms"]["'.trim($val).'"]';
							$and[$key]='(isset($_SESSION["perms"]["'.trim($val).'"]) && $_SESSION["perms"]["'.trim($val).'"])';
							$one=false;
						}
						$or[$k]=implode(" && ",$and);
						if($one && !in_array('isset($_SESSION["perms"]["'.trim($v).'"])',$set))
							array_push($set,'isset($_SESSION["perms"]["'.trim($v).'"])');
					}
					$set_str=implode(" || ",$set);
					$condition_str=implode(" || ",$or);
					eval('if('.$set_str.'){ if('.$condition_str.') $m["enabled"]=1; else $m["enabled"]=0;}');
				}
				if (isset($m["text"]) && is_array($m["text"])) {
					$mtext = ($m["text"][$GLOBALS["WE_LANGUAGE"]] ? $m["text"][$GLOBALS["WE_LANGUAGE"]] : "#");
				}else{
					$mtext = (isset($m["text"]) ? $m["text"] : "#");
				}
				if (!isset($m["cmd"])) {
					$m["cmd"] = "#";
				}
				$out .= "\n" . '				<param name="entry'.$i.'" value="'.$id.','.$m["parent"].','.$m["cmd"].','.$mtext.','.( (isset($m["enabled"]) && $m["enabled"] ) ? $m["enabled"] : "0").'">'."\n";
				$i++;
			}
		}

		$menus = array();

		$onCh = '
			var si=this.selectedIndex;
			if(this.options[si].value) {
				menuaction(this.options[si].value);
			}
			this.selectedIndex=0;';
		$i=0;
		foreach ($this->entries as $id=>$e) {
			if ($e["parent"] == "000000") {
				if(is_array($e["text"])) {
					$mtext = ($e["text"][$GLOBALS["WE_LANGUAGE"]] ? $e["text"][$GLOBALS["WE_LANGUAGE"]] : "");
				}
				else {
					$mtext = ($e["text"] ? $e["text"] : "");
				}
				$menus[$i]["id"] = $id;
				$menus[$i]["code"] = '<select class="defaultfont" style="font-size: 9px;font-family:arial;" onChange="'.$onCh.'" size="1"><option value="">'.$mtext."\n";
				$i++;
			}
		}

		$out .= '
			<div id="divWithSelectMenu">
			<table cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td><form></td>';
		for ($i=0;$i<sizeof($menus);$i++) {
			$foo = $menus[$i]["code"];
			$this->h_pOption($this->entries,$foo,$menus[$i]["id"],"");
			$foo .= "</select>\n";
			$out .= '<td>'.(($GLOBALS["BROWSER"]!="NN") ? (getPixel(2,3).'<br>') : '').$foo.'</td>'.(($i<(sizeof($menus)-1)) ? '<td>&nbsp;&nbsp;</td>' : '');
		}
		$out .= '
					</tr>
				</table>
			</div>
			' . ($GLOBALS["BROWSER"] == "NN6"
					? '
			<script type="text/javascript">
			
			// BUGFIX #1831,
			// Alternate txt does not work in firefox. Therefore, the select-menu is copied to another visible div ONLY in firefox
			// Only script elements work: look at https://bugzilla.mozilla.org/show_bug.cgi?id=60724 for details
			
			if ( !navigator.javaEnabled() ) {
				document.getElementById("divForSelectMenu").innerHTML = document.getElementById("divWithSelectMenu").innerHTML;
				
			}
			</script>'
					: '' ) . '
			</form>';

		if(!$showAltMenu) {
			$out .= '</applet>'."\n";
		}
		return $out;
	}

	function h_search($men,$p) {
		$container = array();
		foreach($men as $id=>$e) {
			if($e["parent"] == $p) {
				$container[$id] =$e;
			}
		}
		return $container;
	}

	function h_pOption($men,&$opt,$p,$zweig) {
		global $BROWSER;
		$nf = $this->h_search($men,$p);
		if(sizeof($nf)) {
			foreach($nf as $id=>$e) {
				$newAst = $zweig;
				$e["enabled"]=1;
				if(isset($e["perm"])) {
					$set=array();
					$or=explode("||",$e["perm"]);
					foreach($or as $k=>$v) {
						$and=explode("&&",$v);
						$one=true;
						foreach($and as $key=>$val) {
							array_push($set,'isset($_SESSION["perms"]["'.trim($val).'"])');
							//$and[$key]='$_SESSION["perms"]["'.trim($val).'"]';
							$and[$key]='(isset($_SESSION["perms"]["'.trim($val).'"]) && $_SESSION["perms"]["'.trim($val).'"])';
							$one=false;
						}
						$or[$k]=implode(" && ",$and);
						if($one && !in_array('isset($_SESSION["perms"]["'.trim($v).'"])',$set))
							array_push($set,'isset($_SESSION["perms"]["'.trim($v).'"])');
					}
					$set_str=implode(" || ",$set);
					$condition_str=implode(" || ",$or);
					eval('if('.$set_str.'){ if('.$condition_str.') $e["enabled"]=1; else $e["enabled"]=0;}');
				}
				if( isset($e["text"]) && is_array($e["text"]) ) {
					$mtext = ($e["text"][$GLOBALS["WE_LANGUAGE"]] ? $e["text"][$GLOBALS["WE_LANGUAGE"]] : "");
				}
				else {
					$mtext = ( isset($e["text"]) ? $e["text"] : "");
				}
				if((!isset($e["cmd"])) && $mtext) {
					$opt .=  '<option value="" disabled>&nbsp;&nbsp;'.$newAst."".$mtext."&nbsp;&gt;\n";
					$newAst = $newAst . "&nbsp;&nbsp;";
					$this->h_pOption($men,$opt,$id,$newAst);
				}
				else if($mtext) {
					$opt .=  '<option'.(($e["enabled"]==0) ? (' value="" style="{color:\'gray\'}" disabled') : (' value="'.$e["cmd"].'"')).'>&nbsp;&nbsp;'.$newAst.(($BROWSER=="NN" && $e["enabled"]==0) ? "(" : "").$mtext.(($BROWSER=="NN" && $e["enabled"]==0) ? ")" : "")."\n";
				}
				else {
					$opt .=  '<option value="" disabled>&nbsp;&nbsp;'.$newAst."--------\n";
				}
			}
		}
	}
	function h_pXUL($men,&$opt,$p,$zweig) {
		global $BROWSER;
		$nf = $this->h_search($men,$p);
		if(sizeof($nf)) {
			foreach($nf as $id=>$e) {
				$newAst = $zweig;
				//$e["enabled"]=1;
				if(isset($e["perm"]) && $e["perm"]) {
					$set=array();
					$or=explode("||",$e["perm"]);
					foreach($or as $k=>$v) {
						$and=explode("&&",$v);
						$one=true;
						foreach($and as $key=>$val) {
							array_push($set,'isset($_SESSION["perms"]["'.trim($val).'"])');
							//$and[$key]='$_SESSION["perms"]["'.trim($val).'"]';
							$and[$key]='(isset($_SESSION["perms"]["'.trim($val).'"]) && $_SESSION["perms"]["'.trim($val).'"])';
							$one=false;
						}
						$or[$k]=implode(" && ",$and);
						if($one && !in_array('isset($_SESSION["perms"]["'.trim($v).'"])',$set))
							array_push($set,'isset($_SESSION["perms"]["'.trim($v).'"])');
					}
					$set_str=implode(" || ",$set);
					$condition_str=implode(" || ",$or);
					eval('if('.$set_str.'){ if('.$condition_str.') $e["enabled"]=1; else $e["enabled"]=0;}');
				}
				if( isset($e["text"]) && is_array($e["text"]) ) {
					$mtext = ($e["text"][$GLOBALS["WE_LANGUAGE"]] ? $e["text"][$GLOBALS["WE_LANGUAGE"]] : "");
				}
				else {
					$mtext = ( isset($e["text"]) ? $e["text"] : "");
				}
				if((!isset($e["cmd"])) && $mtext) {
					$opt .= '<menu label="'.htmlspecialchars($mtext).'"><menupopup>'."\n";
					$this->h_pXUL($men,$opt,$id,$newAst);
					$opt .= '</menupopup></menu>'."\n";
				}
				else if($mtext) {
					$opt .= '<menuitem label="'.htmlspecialchars($mtext).'" oncommand="parent.menuaction(\''.$e["cmd"].'\')"'.((isset($e["enabled"]) && $e["enabled"]==0) ? ' disabled="true"' : '').' />';
				}
				else {
					$opt .=  '<menuseparator />';
				}
			}
		}
	}
}

?>