<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */



	class RefData{
			var $ID;
			var $ParentID;
			var $TemplateID;
			var $Table;
			var $Path;
			var $ContentType;
			var $DocType;
			var $Category;
			var $OldID;
			var $OldParentID;
			var $OldPath;
			var $OldTemplatePath;
			var $Eximed=0;
			var $elements=0;

			var $slots=array("ID","ParentID","Path","Table","ContentType","TemplateID","DocType","Category");

			function init($object,$extra=array()){
				foreach($this->slots as $slot) eval('if(isset($object->'.$slot.')) $this->'.$slot.'=$object->'.$slot.';');
				foreach($extra as $ek=>$ev) eval('$this->'.$ek.'="'.$ev.'";');
			}

			function match($param){
				$match=true;
				foreach($param as $k=>$v) if($k!="level" && $this->$k!=$v) $match=false;
				return $match;
			}


	}

	class RefTable{

		var $Storage=array();
		var $current=0;
		var $Users=array(); // username => id

		function add($object,$extra=array()){
			$rd=new RefData();
			$rd->init($object,$extra);
			if($this->hasPerms($rd)){
				$this->Storage[]=$rd;
			}
		}

		function add2($properties){
			$rd=new RefData();
			foreach($properties as $k=>$v) $rd->$k=$v;
/*			if($handle_owners){
				if(isset($properties['Table'])) $table = $properties['Table'];
				else $table = weXMLExIm::getTableForCT($properties['ContentType']);
				$db = new DB_WE();
				$metadata = $db->metadata($table);
				$tables = array(FILE_TABLE);
				if(defined('OBJECT_TABLE')){
					$tables[] = OBJECT_FILES_TABLE;
					$tables[] = OBJECT_TABLE;
				}
				if(in_array($table,$tables)){
					$fields = getHash('SELECT CreatorID,Owners FROM '.$table.' WHERE ID=\''.$properties['ID'].'\'',$db);
					$ids = array($fields['CreatorID']);
					$ids = array_merge($ids,makeArrayFromCSV($fields['Owners']));
					$this->addToUsers($ids);
				}

			}*/
			$rd->Table = weXMLExIm::getTableForCT($rd->ContentType,(isset($rd->Table)) ? $rd->Table : '');
			if($this->hasPerms($rd)){
				$this->Storage[]=$rd;
			}

		}

		function addToUsers($ids){
			foreach($ids as $id){
				$key=basename(id_to_path($id,USER_TABLE));
				if($key) $this->Users[$key] = array('user'=>$key,'id'=>$id);
			}
		}

		function hasPerms($rd){
			if($rd->Table){
				$allowed = true;
				if($rd->Table != DOC_TYPES_TABLE && $rd->Table != CATEGORY_TABLE){
					$q = weXMLExIm::queryForAllowed($rd->Table);
					$id = f('SELECT ID FROM '.$rd->Table.' WHERE ID=\''.$rd->ID.'\' '.$q,'ID',new DB_WE());
					$allowed = $id ? true : false;
				}
				if($rd->Table == FILE_TABLE) return $allowed && we_hasPerm('CAN_SEE_DOCUMENTS');
				if($rd->Table == TEMPLATES_TABLE) return $allowed && we_hasPerm('CAN_SEE_TEMPLATES');

				if(defined('OBJECT_TABLE') && $rd->Table == OBJECT_TABLE) return $allowed && we_hasPerm('CAN_SEE_OBJECTS');
				if(defined('OBJECT_FILES_TABLE') && $rd->Table == OBJECT_FILES_TABLE) return $allowed && we_hasPerm('CAN_SEE_OBJECTFILES');

				if($rd->Table == DOC_TYPES_TABLE) return $allowed && we_hasPerm('EDIT_DOCTYPE');
				if($rd->Table == CATEGORY_TABLE) return $allowed && we_hasPerm('EDIT_KATEGORIE');

				if($rd->Table == NAVIGATION_TABLE) return $allowed && we_hasPerm('EDIT_NAVIGATION');

			}
			if($rd->ContentType == 'weBinary' || $rd->ContentType == 'weNavigationRule' || $rd->ContentType == 'weThumbnail'){
				return true;
			}

			return false;
		}


		function moveItemsToEnd($ct) {
			$regular = array();
			$moved = array();
			for($i=0;$i<count($this->Storage);$i++) {
				if($this->Storage[$i]->ContentType == $ct){
					$moved[] = $this->Storage[$i];
				} else {
					$regular[] = $this->Storage[$i];
				}

			}
			$this->Storage = array_merge($regular,$moved);

		}

		function update($object){
			$param=array(
					"ID"=>$object->ID,
					"ContentType"=>$object->ContentType
			);
			foreach($this->Storage as $k=>$ref){
				if($ref->match($param)){
					$this->Storage[$k]->init($object);
				}
			}
		}


		function exists($params){
			foreach($this->Storage as $ref){
				if($ref->match($params)) return true;
			}
			return false;
		}

		function setProp($id,$name,$value){
			foreach($this->Storage as $ref){
				if($ref->match($id)){
					eval('$this->'.$name.'="'.addslashes($value).'";');
					return true;
				}
			}
			return false;
		}

		function reset(){
				$this->current=0;
		}

		function getNext(){
				if(isset($this->Storage[$this->current])){
					$id=$this->current;
					$this->current++;
					return $this->Storage[$id];
				}
				else{
					$this->reset();
					return null;
				}
		}

		function getLast() {
			if(count($this->Storage)) return $this->Storage[count($this->Storage)-1];
			return null;
		}

		function getLastCount() {
			return count($this->Storage);
		}


		function getRef($param){
			foreach($this->Storage as $ref){
				if($ref->match($param)) return $ref;
			}
			return false;
		}

		function RefTable2Array(){
			$out=array();
			foreach($this->Storage as $ref){
				$item=array();
				$vars=array_keys(get_object_vars($ref));
				foreach($vars as $prop){
					$item[$prop]=$ref->$prop;
				}
				$out[]=$item;
			}

			return $out;
		}

		function Array2RefTable($RefArray,$update=false){
			if(!$update) $this->Storage=array();
			foreach ($RefArray as $ref){
				$data=new RefData();
				foreach($ref as $k=>$v){
						$data->$k=$v;
				}
				$this->Storage[]=$data;
			}
		}

		function getNewOwnerID($id){
			foreach ($this->Users as $user){
				if($user['id']==$id){
					$newid = f('SELECT ID FROM '.USER_TABLE.' WHERE Username=\''.$user['user'].'\'','ID',new DB_WE());

					if($newid){
						return $newid;
					}
				}
			}
			return 0;
		}
	}



?>