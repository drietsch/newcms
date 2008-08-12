<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');

	class weXMLParser{
		
		
		var $parseError;
		
		
		var $Nodes = array();
		
		var $Indexes = array();
		
		var $Handle=0;
		
		var $Mark;
		
		var $XPaths = array();
		
		function weXMLParser(){

		}
		
		
		function parse(&$data,$encoding='ISO-8859-1') {
			if (!empty($data)) {
				// Initialize the parser
				$parser = xml_parser_create($encoding);
	
				xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
				
				//  XML_OPTION_SKIP_WHITE has to be set to 0
				// in php4 if the option is set to 1, all new line characters
				// will be removed from node content, even from a CDATA section
				xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 0);
   
				if (!xml_parse_into_struct($parser, $data, $this->Nodes, $this->Indexes)) {
						$this->parseError = xml_get_current_line_number($parser). ': ' . xml_Error_string(xml_get_error_code($parser));
						return FALSE;
				}

				xml_parser_free($parser);
				//$this->normalize();
			}
			else {
				return FALSE;
			}
		}
		
		function normalize() {

			$newNodes = array();
			
			$count = 0;
			$level = array();
			$level_prefix = 'l';
			
			foreach ($this->Nodes as $k=>$v) {

				if($v['type'] == 'open' || $v['type'] == 'complete'){
									
					$new = array();
					
					$new['name'] = $v['tag'];
					
					if(isset($v['attributes'])){
						$new['attributes'] = $v['attributes'];
					}
					
					if(isset($v['value'])){
						$new['value'] = $v['value'];
					}
					
					if($count && isset($level[$level_prefix.$v['level']])) {						
						$newNodes[$level[$level_prefix.$v['level']]]['next'] = $count;						
					}
					
					$level[$level_prefix.$v['level']] = $count;
					
					$newNodes[$count] = $new;
					$count++;

				}
				
				if($v['type'] == 'close'){					
					array_pop($level);
				}
				
			}

			unset($this->Nodes);
			$this->Nodes = $newNodes;

		}		
		
		
		function normalizeWithXpaths() {

			$newNodes = array();
			
			$_xpaths = array();
			$_parent_xpaths = array();
			$_element_counter = array();
			
			
			
			$count = 0;
			$level = array();
			
			foreach ($this->Nodes as $k=>$v) {

				if($v['type'] == 'open' || $v['type'] == 'complete'){
									
					$new = array();
					
					$new['name'] = $v['tag'];
					
					if(isset($v['attributes'])){
						$new['attributes'] = $v['attributes'];
					}
					
					if(isset($v['value'])){
						$new['value'] = $v['value'];
					}
					
					
					if($count && isset($level[$v['level']])) {
						$newNodes[$level[$v['level']]]['next'] = $count;						
					}
					
					// xpath --------------------
					$_parent = ($v['level']>1 ? $_parent_xpaths[$v['level']-1] : '') . '/';
					
					if(!isset($_element_counter[$v['level']])){
						$_element_counter[$v['level']] = array();
					}
					
					if(isset($_element_counter[$v['level']][$v['tag']])){
						$_element_counter[$v['level']][$v['tag']]++;
					} else {
						$_element_counter[$v['level']][$v['tag']] = 1;
					}
					
					$_xpath = $_parent . $v['tag'] . '[' . $_element_counter[$v['level']][$v['tag']] . ']'; 
					
					//$_xpaths[$_xpath] = $count;
					$_xpaths[$count] = $_xpath;
					
					if($v['type'] == 'open') {
						$_parent_xpaths[$v['level']] = $_xpath;
					}
					// xpath ends -----------------------------
					
					
					$level[$v['level']] = $count;
					
					$newNodes[$count] = $new;
					$count++;

				}
				
				if($v['type'] == 'close'){
					array_pop($level);
					// xpath --------------
					array_pop($_parent_xpaths);
					array_pop($_element_counter);
					// xpath ends ---------
				}
				
			}

			unset($this->Nodes);
			$this->Nodes = $newNodes;

		}
		

		function next() {
			if($this->Handle < (count($this->Nodes)-1)){
				$this->Handle++;			
			} else {
				return null;
			}
		}
		
		
		function nextSibling() {
			
			if(isset($this->Nodes[$this->Handle]['next'])) {
				$this->Handle = $this->Nodes[$this->Handle]['next'];
				return true;
			} else {
				return false;
			}

		}
		
		function seek($position){
			$this->Handle = $position;
		}
	
		
		function getNodeName() {
			return isset($this->Nodes[$this->Handle]['name']) ? $this->Nodes[$this->Handle]['name'] : '';
		}
		
		function getNodeData() {
			return (isset($this->Nodes[$this->Handle]['value'])) ?
				$this->Nodes[$this->Handle]['value']
				:
				null;
		}

		function getNodeAttributes() {
			return (isset($this->Nodes[$this->Handle]['attributes'])) ?
				$this->Nodes[$this->Handle]['attributes']
				:
				null;
		}
		
		function addMark($name) {
			
			$this->Mark[$name] = $this->Handle;
			
		}
		
		function gotoMark($name){
			
			if(isset($this->Mark[$name])) {
				$this->Handle = $this->Mark[$name];
				return true;
			}
			
			return false;
			
		}
		
		function deleteMark($name){
			if(isset($this->Mark[$name])) {
				unset($this->Mark[$name]);
				return true;
			}
			return false;
		}
		
		function getChildren($node_id,&$children) {
			
			$this->addMark('getChildren');
			
			$this->seek($node_id);
			
			$this->next();
			$children[] = $this->Handle;
			while ($this->nextSibling()) {
				$children[] = $this->Handle;
			}
			
			$this->gotoMark('getChildren');
			$this->deleteMark('getChildren');
			
			if(count($children)){
				return true;
			}
			return false;
		}
		
		function hasChildren($node_id){
			
			$_return = false;
			$this->addMark('hasChildern');
			$this->seek($node_id);
			$_next_id  = 0;
			$_next_sibling_id = 0;
						
			
			if($this->next()) {
				$_next_id = $this->Handle;
			}
			
			$this->seek($node_id);
			if($this->nextSibling()) {
				$_next_sibling_id = $this->Handle;
			}
			
			if($next_id!=$_next_sibling_id){
				$_return = true;
			}

			$this->gotoMark('hasChildern');
			$this->deleteMark('hasChildern');
			return false;

		}
		
		
		
	}
	
?>