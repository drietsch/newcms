<?php

class we_ui_controls_JavaMenu extends we_ui_abstract_AbstractElement
{

	protected $_entries;

	protected $_cmdURL='';
	protected $_cmdTarget='';
	
	protected function _renderHTML()
	{
		$lang = we_core_Local::getComputedUILang();
		$showAltMenu = (isset($_SESSION['weShowAltMenu']) && $_SESSION['weShowAltMenu']) || (isset($_REQUEST["showAltMenu"]) && $_REQUEST["showAltMenu"]);
		$_SESSION['weShowAltMenu'] = $showAltMenu;
		
		$out = '';
		
		if (!$showAltMenu) {
			$out .= '
				<div id="divForSelectMenu"></div>
				<applet name="weJavaMenuApplet" code="menuapplet"  archive="JavaMenu.jar"  codebase="' . we_util_Sys_Server::getHostUri('/webEdition/lib/we/ui/controls') . '" align="baseline" width="' . $this->_width . '" height="' . $this->_height . '" mayscript scriptable>
					<param name="cabbase" value="menuapplet.cab">
					<param name="phpext" value=".php">';
			if ($this->_cmdTarget !== '') {
				$out .= "\n" . '				<param name="cmdTarget" value="'.htmlspecialchars($this->_cmdTarget).'">';
			}
			if ($this->_cmdURL !== '') {
				$out .= "\n" . '				<param name="cmdURL" value="'.htmlspecialchars($this->_cmdURL).'">';
			}
			$i = 0;
			foreach ($this->_entries as $id => $m) {
				if (we_core_Permissions::hasPerm('ADMINISTRATOR')) {
					$m['enabled'] = 1;
				}
				if (!we_core_Permissions::hasPerm('ADMINISTRATOR') && (isset($m["perm"]) && $m["perm"]) != "") {
					$set = array();
					$or = explode("||", $m["perm"]);
					foreach ($or as $k => $v) {
						$and = explode("&&", $v);
						$one = true;
						foreach ($and as $key => $val) {
							array_push($set, 'isset($_SESSION["perms"]["' . trim($val) . '"])');
							//$and[$key]='$_SESSION["perms"]["'.trim($val).'"]';
							$and[$key] = '(isset($_SESSION["perms"]["' . trim($val) . '"]) && $_SESSION["perms"]["' . trim($val) . '"])';
							$one = false;
						}
						$or[$k] = implode(" && ", $and);
						if ($one && !in_array('isset($_SESSION["perms"]["' . trim($v) . '"])', $set))
							array_push($set, 'isset($_SESSION["perms"]["' . trim($v) . '"])');
					}
					$set_str = implode(" || ", $set);
					$condition_str = implode(" || ", $or);
					eval('if(' . $set_str . '){ if(' . $condition_str . ') $m["enabled"]=1; else $m["enabled"]=0;}');
				}
				if (isset($m["text"]) && is_array($m["text"])) {
					$mtext = ($m["text"][$lang] ? $m["text"][$lang] : "#");
				} else {
					$mtext = (isset($m["text"]) ? $m["text"] : "#");
				}
				if (!isset($m["cmd"])) {
					$m["cmd"] = "#";
				}
				$out .= "\n" . '				<param name="entry' . $i . '" value="' . $id . ',' . $m["parent"] . ',' . $m["cmd"] . ',' . $mtext . ',' . ((isset($m["enabled"]) && $m["enabled"]) ? $m["enabled"] : "0") . '">' . "\n";
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
		$i = 0;
		foreach ($this->_entries as $id => $e) {
			if ($e["parent"] == "000000") {
				if (is_array($e["text"])) {
					$mtext = ($e["text"][$lang] ? $e["text"][$lang] : "");
				} else {
					$mtext = ($e["text"] ? $e["text"] : "");
				}
				$menus[$i]["id"] = $id;
				$menus[$i]["code"] = '<select class="defaultfont" style="font-size: 9px;font-family:arial;" onChange="' . $onCh . '" size="1"><option value="">' . $mtext . "\n";
				$i++;
			}
		}
		
		$out .= '
			<div id="divWithSelectMenu">
			<table cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td><form></td>';
		for ($i = 0; $i < sizeof($menus); $i++) {
			$foo = $menus[$i]["code"];
			self::_computeOption($this->_entries, $foo, $menus[$i]["id"], "");
			$foo .= "</select>\n";
			$out .= '<td>'  . $foo . '</td>' . (($i < (sizeof($menus) - 1)) ? '<td>&nbsp;&nbsp;</td>' : '');
		}
		$out .= '
					</tr>
				</table>
			</div>
			' . (we_ui_Client::getInstance()->getBrowser() == we_ui_Client::kBrowserGecko ? '
			<script type="text/javascript">
			
			// BUGFIX #1831,
			// Alternate txt does not work in firefox. Therefore, the select-menu is copied to another visible div ONLY in firefox
			// Only script elements work: look at https://bugzilla.mozilla.org/show_bug.cgi?id=60724 for details
			
			if ( !navigator.javaEnabled() ) {
				document.getElementById("divForSelectMenu").innerHTML = document.getElementById("divWithSelectMenu").innerHTML;
				
			}
			</script>' : '') . '
			</form>';
		
		if (!$showAltMenu) {
			$out .= '</applet>' . "\n";
		}
		return $out;
	
	}

	protected static function _computeOption($men, &$opt, $p, $zweig)
	{
		$lang = we_core_Local::getComputedUILang();
		$nf = self::_search($men, $p);
		if (sizeof($nf)) {
			foreach ($nf as $id => $e) {
				$newAst = $zweig;
				$e["enabled"] = 1;
				if (isset($e["perm"])) {
					$set = array();
					$or = explode("||", $e["perm"]);
					foreach ($or as $k => $v) {
						$and = explode("&&", $v);
						$one = true;
						foreach ($and as $key => $val) {
							array_push($set, 'isset($_SESSION["perms"]["' . trim($val) . '"])');
							//$and[$key]='$_SESSION["perms"]["'.trim($val).'"]';
							$and[$key] = '(isset($_SESSION["perms"]["' . trim($val) . '"]) && $_SESSION["perms"]["' . trim($val) . '"])';
							$one = false;
						}
						$or[$k] = implode(" && ", $and);
						if ($one && !in_array('isset($_SESSION["perms"]["' . trim($v) . '"])', $set))
							array_push($set, 'isset($_SESSION["perms"]["' . trim($v) . '"])');
					}
					$set_str = implode(" || ", $set);
					$condition_str = implode(" || ", $or);
					eval('if(' . $set_str . '){ if(' . $condition_str . ') $e["enabled"]=1; else $e["enabled"]=0;}');
				}
				if (isset($e["text"]) && is_array($e["text"])) {
					$mtext = ($e["text"][$lang] ? $e["text"][$lang] : "");
				} else {
					$mtext = (isset($e["text"]) ? $e["text"] : "");
				}
				if ((!isset($e["cmd"])) && $mtext) {
					$opt .= '<option value="" disabled>&nbsp;&nbsp;' . $newAst . "" . $mtext . "&nbsp;&gt;\n";
					$newAst = $newAst . "&nbsp;&nbsp;";
					self::_computeOption($men, $opt, $id, $newAst);
				} else if ($mtext) {
					$opt .= '<option' . (($e["enabled"] == 0) ? (' value="" style="{color:\'gray\'}" disabled') : (' value="' . $e["cmd"] . '"')) . '>&nbsp;&nbsp;' . $newAst . $mtext . "\n";
				} else {
					$opt .= '<option value="" disabled>&nbsp;&nbsp;' . $newAst . "--------\n";
				}
			}
		}
	}

	protected static function _search($men, $p)
	{
		$container = array();
		foreach ($men as $id => $e) {
			if ($e["parent"] == $p) {
				$container[$id] = $e;
			}
		}
		return $container;
	}

	/**
	 * @return unknown
	 */
	public function getEntries()
	{
		return $this->_entries;
	}

	/**
	 * @param unknown_type $entries
	 */
	public function setEntries($entries)
	{
		$this->_entries = $entries;
	}

	/**
	 * @return unknown
	 */
	public function getCmdTarget()
	{
		return $this->_cmdTarget;
	}

	/**
	 * @return unknown
	 */
	public function getCmdURL()
	{
		return $this->_cmdURL;
	}

	/**
	 * @param unknown_type $cmdTarget
	 */
	public function setCmdTarget($cmdTarget)
	{
		$this->_cmdTarget = $cmdTarget;
	}

	/**
	 * @param unknown_type $cmdURL
	 */
	public function setCmdURL($cmdURL)
	{
		$this->_cmdURL = $cmdURL;
	}
	
}
