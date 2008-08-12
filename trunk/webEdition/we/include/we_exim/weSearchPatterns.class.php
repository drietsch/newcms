<?php

	
	class weSearchPatterns {
		
		var $doc_patterns=array("id"=>array(),"path"=>array());
		var $obj_patterns=array("id"=>array(),"path"=>array());
		var $class_patterns=array();
		var $ext_patterns=array();
		var $wysiwyg_patterns=array();
		var $navigation_patterns=array();
		var $thumbnail_patterns = array();
		var $tmpl_patterns = array();
		var $special_patterns = array();
	
		
		function weSearchPatterns(){
			$this->doc_patterns=array("id"=>array(),"path"=>array());
			$this->obj_patterns=array("id"=>array(),"path"=>array());
			$this->class_patterns=array();
			$this->ext_patterns=array();
			$this->wysiwyg_patterns=array();
			$this->special_patterns=array();
		
			$spacer = "[\040|\n|\t|\r]*";
			
			$_pats = array(
				'a' => 'id',
				'addDelNewsletterEmail' => array('id','mailid'),
				'css' => 'id',
				'a' => 'id',
				'form' => array('id','onsuccess','onerror','onmailerror'),
				'icon' => 'id',
				'img' => 'id',
				'js' => 'id',
				'linkToSeeMode' => 'id',
				'url' => 'id',
				'ifSelf' => 'id',
				'listview' => array('id','triggerid','workspaceID'),
				'sessionLogout' => 'id',
				'field' => 'id'
			);		
			
			foreach($_pats as $tag=>$attribut) {
				if(is_array($attribut)) {
					foreach($attribut as $attrib) {
						$this->doc_patterns["id"][] = "/<(we:".$tag.$spacer."[^>]*[\040|\n|\t|\r]+".$attrib.$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
					}
				} else {
					$this->doc_patterns["id"][] = "/<(we:".$tag.$spacer."[^>]*[\040|\n|\t|\r]+".$attribut.$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
				}
			}
			
			$this->doc_patterns["id"][] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+type".$spacer."=".$spacer."[\"|\'|\\\\]+document[\"|\']+".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			$this->doc_patterns["id"][] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]+".$spacer."type".$spacer."=".$spacer."[\"|\'|\\\\]+document[\"|\']+".$spacer."[^>]*)>/sie";
			
			$this->doc_patterns["id"][] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)[^>]*>/sie";
						
			// serach for documents after path
			$this->doc_patterns["path"][] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+path".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			
			//search for objects
			$this->obj_patterns["id"][] ="/<(we:object".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			$this->obj_patterns["id"][] ="/<(we:form".$spacer."[^>]*[\040|\n|\t|\r]+type".$spacer."=".$spacer."[\"|\'|\\\\]+object[\"|\']+".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";			
			$this->obj_patterns["id"][] ="/<(we:form".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*[\040|\n|\t|\r]+type".$spacer."=".$spacer."[\"|\'|\\\\]+object[\"|\']+".$spacer."[^>]*)>/sie";

			// search for classes			
			$_pats = array(
				'form' => 'classid',
				'listview' => 'classid'
			);					
			foreach($_pats as $tag=>$attribut) {
				$this->class_patterns[] = "/<(we:".$tag.$spacer."[^>]*[\040|\n|\t|\r]+".$attribut.$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			}
			
			// search for external files
			$_pats = array(
				'img' => 'src',
				'a' => 'href',
				'body' => 'background',
				'table' => 'background',
				'td' => 'background'
			);					
			foreach($_pats as $tag=>$attribut) {
				$this->ext_patterns[] ="/<(".$tag.$spacer."[^>]*[\040|\n|\t|\r]+".$tag.$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";				
			}
			
			// search wysiwyg textareas
			$this->wysiwyg_patterns["doc"][] = "/([src|href]+".$spacer."=".$spacer."\"document:)([0-9]+)(\")/sie";
			$this->wysiwyg_patterns["obj"][] = "/(href".$spacer."=".$spacer."\"object:)([0-9]+)(\")/sie";
		
			// handle templates			
			$_tmpl_pats = array(
				'ifTemplate' => 'id'
			);
			
			foreach($_tmpl_pats as $tag=>$attribut) {
				$this->tmpl_patterns[] = "/<(we:".$tag.$spacer."[^>]*[\040|\n|\t|\r]+".$attribut.$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			}
			
			$this->tmpl_patterns[] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+type".$spacer."=".$spacer."[\"|\'|\\\\]+template[\"|\']+".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			$this->tmpl_patterns[] ="/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]+".$spacer."type".$spacer."=".$spacer."[\"|\'|\\\\]+template[\"|\']+".$spacer."[^>]*)>/sie";
			$this->tmpl_patterns[] = "/<(we:field".$spacer."[^>]*[\040|\n|\t|\r]+tid".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			
			// search for navigation
			$this->navigation_patterns[] = "/<(we:navigation[^>]*[\040|\n|\t|\r]+id".$spacer."[=\"|=\'|=\\\\|=]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			$this->navigation_patterns[] = "/<(we:navigation[^>]*[\040|\n|\t|\r]+parentid".$spacer."[=\"|=\'|=\\\\|=]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			
			// search for thumbnails
			$this->thumbnail_patterns[] = "/<(we:img[^>]*[\040|\n|\t|\r]+thumbnail".$spacer."[=\"|=\'|=\\\\|=]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			$this->thumbnail_patterns[] = "/<(we:field[^>]*[\040|\n|\t|\r]+thumbnail".$spacer."[=\"|=\'|=\\\\|=]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			
			// some special patterns
			$this->special_patterns[] = "/<(we:include".$spacer."[^>]*[\040|\n|\t|\r]+id".$spacer."=".$spacer."[\"|\'|\\\\]*".$spacer.")([^\'\">\040? \\\]*)(".$spacer."[^>]*)>/sie";
			
		}
		
		
	}
	
?>