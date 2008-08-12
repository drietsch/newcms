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

class XML_Import extends XML_Parser {
	
	var $current_table = "";
	var $attribs = array();

	var $element_id = 0;
	var $content_id = 0;
	var $db;
	
	var $store_docs = 0;
	var $store_templ = 0;

	function XML_Import($file) {
		$this->getFile($file);
		$this->db = new DB_WE();

		$node_set = $this->evaluate("*/child::*");
		foreach($node_set as $node) $this->import($node);
	}

	function import($absoluteXPath) {
		$this->updateFlds($absoluteXPath);
		$this->importElement($absoluteXPath);
		if ($this->current_table != "" && count($this->attribs) > 0) {
			if ($this->current_table == CONTENT_TABLE) $this->content_id = $this->flushCurrent();
			else $this->element_id = $this->flushCurrent();
		}
		$this->updateIDs();
	}

	function setImportDirs($doc_id = 0,$temp_id = 0) {		
		$this->store_docs = $doc_id;
		$this->store_templ = $temp_id;
	}

	function importElement($absoluteXPath) {
		if ($this->current_table != "" && count($this->attribs) > 0) {
			if ($this->current_table == CONTENT_TABLE)
				$this->content_id = $this->flushCurrent();
			else
				$this->element_id = $this->flushCurrent();
		}

		if ($this->nodeName($absoluteXPath) == "template") $this->current_table = TEMPLATES_TABLE;
		elseif ($this->nodeName($absoluteXPath) == "document") $this->current_table = FILE_TABLE;

		$node_set = $this->evaluate($absoluteXPath."/child::*");
		foreach($node_set as $node) {
			if ($this->nodeName($node) == "attrib") {
				$this->importAttrib($this->getAttributes($node), $this->getData($node));
			}
			if ($this->nodeName($node) == "content") {
				$this->importContent($this->getAttributes($node), $node);
				if ($this->current_table != "" && count($this->attribs) > 0) {
					if ($this->current_table == CONTENT_TABLE) {
						$this->content_id = $this->flushCurrent();
					}
					else {
						$this->element_id = $this->flushCurrent();
					}
				}
			}
		}
	}

	function importAttrib($attribute, $data) {
		$new = array();
		foreach($attribute as $k=>$v) {
			$new[$k] = $v;
		}
		$new["data"] = $data;
		$this->attribs[] = $new;
	}

	function flushCurrent(){
		$insert = "";
		$insert_arr = array();
		$retID = 0;

		foreach($this->attribs as $att) {
			if ($att["name"] == "ID") $oldid = $att["data"];
			else $insert_arr[$att["name"]] = $att["data"];
		}

		$insert = "INSERT INTO ".$this->current_table."(".implode(",", array_keys($insert_arr)).") VALUES ('".implode("','", $insert_arr)."');";

		$this->db->query($insert);
		if ($this->current_table == FILE_TABLE || $this->current_table == TEMPLATES_TABLE  || $this->current_table == CONTENT_TABLE)
			$retID = f("SELECT MAX(LAST_INSERT_ID()) as LastID FROM ".$this->current_table,"LastID",$this->db);		

		$this->idTable[$this->current_table][(isset($oldid))?$oldid:0] = $retID;
		$this->attribs = array();

		return $retID;
	}

	function importContent($link, $absoluteXPath) {
		if ($this->current_table != "" && count($this->attribs) > 0) {
			if ($this->current_table == CONTENT_TABLE) {
				$this->content_id = $this->flushCurrent();
			}
			else {
				$this->element_id = $this->flushCurrent();
			}
		}
		$this->current_table = CONTENT_TABLE;

		$node_set = $this->evaluate($absoluteXPath."/child::*");
		foreach($node_set as $node) {
			if ($this->nodeName($node) == "attrib") {
				$attrs = $this->getAttributes($node);
				if ($attrs["name"] == "Dat") {
					$this->importAttrib($attrs, addslashes(base64_decode($this->getData($node))));
				}
				else $this->importAttrib($attrs, $this->getData($node));
			}
		}

		$this->content_id = $this->flushCurrent();

		$this->current_table = "tblLink";

		$this->importAttrib(array("name"=>"DID"), $this->element_id);
		$this->importAttrib(array("name"=>"CID"), $this->content_id);
		foreach($link as $k=>$v) {
			$this->importAttrib(array("name"=>$k), $v);
		}

		$this->content_id=$this->flushCurrent();
	}

	function queryPath($absoluteXPath) {
		global $DB_WE;
		$path = $this->getData($absoluteXPath."/attrib[9]");
		$parent = $this->nodeName($absoluteXPath);
		$this->db->query("SELECT ID FROM ".(($parent=="document")? FILE_TABLE : TEMPLATES_TABLE)." WHERE Path='".$path."'");
		return ($this->db->num_rows());
	}

	function updateFlds($XPath) {
		$id = 1;
		while ($this->queryPath($XPath)!=0) {
			$list = array("Text", "Path", "Filename");
			$s = array();
			$node_set = $this->evaluate($XPath."/child::*");

			foreach($node_set as $node) {
				$attrs = $this->getAttributes($node);
				foreach ($attrs as $k=>$v) {
					if ($k=="name") {
						if ($v==$list[0]||$v==$list[1]||$v==$list[2]) {
							$s[$v]["node"] = $node;
							$s[$v]["data"] = $this->getData($node);
						}
					}
				}
			}

			$dat = $s[$list[2]]["data"];
			$arr = explode("_",$dat);

			if (count($arr)!=1) $arr[count($arr)-1] = "_".$id;
			else $arr[0].= "_".$id;

			foreach($list as $item) {
				$this->replaceData($s[$item]["node"],str_replace($dat,implode("",$arr),$s[$item]["data"]));
			}
			$id++;
		}
	}

	function updateIDs() {
		global $DB_WE;

		foreach($this->idTable as $key=>$val) {
			$ids = implode(",", $val);
			if ($key == FILE_TABLE || $key == TEMPLATES_TABLE) {
				$store = $key == FILE_TABLE ?  $this->store_docs : $this->store_templ;
				if ($ids!="") $this->db->query("UPDATE $key SET ParentID=".$store." WHERE ID IN($ids);");

				if ($key==FILE_TABLE || $key == TEMPLATES_TABLE) {
					foreach($val as $k=>$v) {								
						if ($key == TEMPLATES_TABLE) {
							$this->db->query("SELECT ID FROM ".FILE_TABLE." WHERE TemplateID=".$k);
							while($this->db->next_record()) {
								$DB_WE->query("UPDATE ".FILE_TABLE." SET TemplateID='$v' WHERE ID='".$this->db->f("ID")."';");
							}
						}

                        $new_path = f("SELECT Path FROM $key WHERE ID=".$store,"Path",$this->db);
                        $text = f("SELECT Text FROM $key WHERE ID=".$v,"Text",$this->db);

                        $this->db->query("UPDATE $key SET Path='".($new_path!="" ? $new_path : "/").$text."' WHERE ID=$v;");
					}
				}

			}
		}
	}

}

?>
