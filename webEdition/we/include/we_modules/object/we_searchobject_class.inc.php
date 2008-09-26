<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_search.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/object.inc.php");

class objectsearch extends we_search {
	var $height;
	var $searchname;
	var $searchlocation;
	var $searchfield;
	var $searchstart=0;
	var $show;

	function objectsearch() {
	    if(isset($sessDat) && is_array($sessDat) ){
		    for($i=0;$i<=sizeof($sessDat);$i++) {
    			if(isset($sessDat[$i])) {
				    $v=$sessDat[$i];
				    $v = (get_magic_quotes_gpc() == 1) ? stripslashes($v) : $v;
				    eval('$this->'.$sessDat[$i].'=$v;');
			    }
		    }
		}
	}

	function init($sessDat="") {
		for($i=0;$i<=sizeof($sessDat);$i++) {
			if(isset($sessDat[$i])) {
				$v=$sessDat[$i];
				$v = (get_magic_quotes_gpc() == 1) ? stripslashes($v) : $v;
				eval('$this->'.$sessDat[$i].'=$v;');
			}
		}
	}

	function getFields($name="obj_searchField",$size=1,$select="",$Path,$multi="") {
		global $l_object;

		$objID = f("SELECT ID FROM ".OBJECT_TABLE." WHERE Path='".$Path."'","ID",$GLOBALS["DB_WE"]);
		$opts = '';
		$tableInfo =  $GLOBALS["DB_WE"]->metadata(OBJECT_X_TABLE.$objID);
		$all = "";

		for($i=0;$i<sizeof($tableInfo);$i++) {
			if($tableInfo[$i]["name"] != "ID" && substr($tableInfo[$i]["name"],0,3) != "OF_" && !eregi("^multiobject", $tableInfo[$i]["name"]) && !eregi("^object", $tableInfo[$i]["name"])) {
				if(ereg('^(.*)_(.*)$',$tableInfo[$i]["name"],$regs)) {
					$opts .= '<option value="'.$tableInfo[$i]["name"].'" '
					      .(($select==$tableInfo[$i]["name"])?"selected":"").'>'
					      . $regs[2] .'</option>'."\n";
				}
				$all .= $tableInfo[$i]["name"].",";
			}
			else if($tableInfo[$i]["name"] == "OF_Text") {
				$opts .= '<option value="'.$tableInfo[$i]["name"].'" '.(($select==$tableInfo[$i]["name"])?"selected":"").'>'.$l_object["objectname"].'</option>'."\n";
				$all .= $tableInfo[$i]["name"].",";
			}
			else if($tableInfo[$i]["name"] == "OF_Path") {
				$opts .= '<option value="'.$tableInfo[$i]["name"].'" '.(($select==$tableInfo[$i]["name"])?"selected":"").'>'.$l_object["objectpath"].'</option>'."\n";
				$all .= $tableInfo[$i]["name"].",";
			}
		}
		$all = ereg_replace('^(.*),$','\1',$all);
		$opts = '<option value="'.$all.'">'.$l_object["allFields"].'</option>'."\n".$opts;
		$onchange = (substr($select,0,4)!="meta"&&substr($select,0,4)!="date"&&substr($select,0,8)!="checkbox"?'onChange="changeit(this.value);"':'onChange="changeitanyway(this.value);"');
		return '<select name="'.$name.'" class="weSelect" size="'.$size.'" '.$multi.' '.$onchange.'>'.$opts.'</select>';
	}

	function getJSinWEsearchobj($name) {
		return $this->getJSinWElistnavigation($name).$this->getJSinWEworkspace($name).$this->getJSinWEshowVisible($name);
	}

	function getJSinWEworkspace($name) {
		return '
			<script language="JavaScript" type="text/javascript"><!--
				function setWs(path,id) {
					document.we_form.elements[\'we_'.$name.'_WorkspacePath\'].value=path;
					document.we_form.elements[\'we_'.$name.'_WorkspaceID\'].value=id;
					top.we_cmd("reload_editpage");
				}
			//-->
			</script>';
	}

	function getJSinWEshowVisible($name) {
		return '
			<script language="JavaScript" type="text/javascript"><!--
				function toggleShowVisible(c) {
					c.value=(c.checked ? 1 : 0);
					document.we_form.elements[\'SearchStart\'].value = 0;
					top.we_cmd(\'reload_editpage\');
				}
			//-->
			</script>';
	}

	function greenOnly($GreenOnly,$pid,$cid) {
		global $DB_WE;
		if($GreenOnly) {
			$pid_tail = makePIDTail($pid,$cid,$DB_WE,FILE_TABLE);
			return ' AND '.OBJECT_X_TABLE.$cid.'.OF_Published > 0 AND '.$pid_tail;
		}
	}

	function getExtraWorkspace($exws,$we_extraWsLength,$id,$userWSArray) {
		if(sizeof($exws)) {
			$out = '<table border="0" cellpadding="0" cellspacing="0">';
			for($i=0;$i < sizeof($exws); $i++) {
				if($exws[$i] != "") {
					if($_SESSION["perms"]["ADMINISTRATOR"]) {
						$foo = true;
					}
					else {
						$foo = in_workspace($exws[$i],$userWSArray);
					}
					if($foo) {
						$checkbox = '<a href="javascript:we_cmd(\'toggleExtraWorkspace\',\''.$GLOBALS["we_transaction"].'\',\''.$this->f("ID").'\',\''.$exws[$i].'\',\''.$id.'\')"><img name="check_'.$id.'_'.$this->f("ID").'" src="'.TREE_IMAGE_DIR.'check'.(strstr($this->f("OF_ExtraWorkspacesSelected"),",".$exws[$i].",") ? "1" : "0").'.gif" width="16" height="18" border="0"></a>';
					}
					else {
						$checkbox = '<img name="check_'.$id.'_'.$this->f("ID").'" src="'.TREE_IMAGE_DIR.'check'.(strstr($this->f("OF_ExtraWorkspacesSelected"),",".$exws[$i].",") ? "1" : "0").'_disabled.gif" width="16" height="18" border="0">';
					}
					$p = id_to_path($exws[$i]);
					$out .= '
						<tr>
							<td>
								'.$checkbox.'</td>
							<td>
								'.getPixel(5,2).'</td>
							<td class="middlefont">
								&nbsp;<a href="javascript:setWs(\''.$p.'\',\''.$exws[$i].'\')" style="text-decoration:none" class="middlefont" title="'.$p.'">'.shortenPath($p,$we_extraWsLength).'</a><td>
						</tr>';
				}
			}
			$out .= '</table>';
		}
		else {
			$out = "-";
		}
		return $out;
	}

	function getWorkspaces($foo,$we_wsLength) {
		if(sizeof($foo)) {
			$out = '<table border="0" cellpadding="0" cellspacing="0">';
			for($i=0;$i < sizeof($foo); $i++) {
				if($foo[$i] != "") {
					$p = id_to_path($foo[$i]);
					$pl = strlen($p);
					$out .= '
						<tr>
							<td class="middlefont">
								&nbsp;<a href="javascript:setWs(\''.$p.'\',\''.$foo[$i].'\')" style="text-decoration:none" class="middlefont" title="'.$p.'">'.shortenPath($p,$we_wsLength).'</a><td>
						</tr>';
				}
			}
			$out .= '</table>';
		}
		else {
			$out = "-";
		}
		return $out;
	}
	
	
	function removeFilter($position) {
		
		foreach ($this->objsearch as $idx => $value) {
			if($idx == $position) {
				unset($this->objsearch[$position]);
			} elseif($idx >= $position) {
				if(!isset($this->objsearch[($idx-1)])) {
					$this->objsearch[($idx-1)] = "";
				}
				$this->objsearch[($idx-1)] = $this->objsearch[$idx];
				unset($this->objsearch[$idx]);
			}
		}
		
		foreach ($this->objsearchField as $idx => $value) {
			if($idx == $position) {
				unset($this->objsearchField[$position]);
			} elseif($idx >= $position) {
				if(!isset($this->objsearchField[($idx-1)])) {
					$this->objsearchField[($idx-1)] = "";
				}
				$this->objsearchField[($idx-1)] = $this->objsearchField[$idx];
				unset($this->objsearchField[$idx]);
			}
		}
		
		foreach ($this->objlocation as $idx => $value) {
			if($idx == $position) {
				unset($this->objlocation[$position]);
			} elseif($idx >= $position) {
				if(!isset($this->objlocation[($idx-1)])) {
					$this->objlocation[($idx-1)] = "";
				}
				$this->objlocation[($idx-1)] = $this->objlocation[$idx];
				unset($this->objlocation[$idx]);
			}
		}
		
		$this->height--;
	}
}

?>