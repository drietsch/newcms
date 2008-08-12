<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Class weBackup
 *
 * Provides functions for exporting and importing backups. Extends we_backup.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_backup.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weContentProvider.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/"."weTable.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/"."weTableItem.class.php");


class weBackup extends we_backup{

	var $header;
	var $footer;
	var $nl;

	var $mode="sql";
	var $filename;
	var $compress="none";

	var $rebuild;

	var $file_list=array();

	var $file_counter=0;
	var $file_end=0;

	var $backup_dir;
	var $backup_dir_tmp;

	var $row_count=0;
	var $file_list_count=0;

	var $old_objects_deleted=0;

	var $backup_binary=1;

	function weBackup($handle_options=array()){
		global $_language;
		$this->nl="\n";

		$isp_header="";
		if(defined("ISP_VERSION") && ISP_VERSION){
			if(defined("ISP_VERSION_NUMBER")) $isp_header=' ispversion="'.ISP_VERSION_NUMBER.'"';
			if(defined("ISP_TYPE")) $isp_header.=(strlen($isp_header)!=0 ? " " : "").'isptype="'.ISP_TYPE.'"';
		}

		$this->header="<?xml version=\"1.0\" encoding=\"".$_language["charset"]."\" standalone=\"yes\"?>".$this->nl.
					 "<webEdition version=\"".WE_VERSION."\"$isp_header xmlns:we=\"we-namespace\">".$this->nl;
		$this->footer=$this->nl."</webEdition>";

		$this->properties[]="mode";
		$this->properties[]="filename";
		$this->properties[]="compress";
		$this->properties[]="backup_binary";
		$this->properties[]="rebuild";
		$this->properties[]="file_counter";
		$this->properties[]="file_end";
		$this->properties[]="row_count";
		$this->properties[]="file_list_count";
		$this->properties[]="old_objects_deleted";

		we_backup::we_backup($handle_options);

		if(defined("ISP_VERSION") && ISP_VERSION){
			$this->fixedTable[]="tbltemplates";
		}

		$this->tables["core"]=array("tblfile","tbllink","tbltemplates","tblindex","tblcontent","tblcategorys","tbldoctypes","tblthumbnails");
		$this->tables["object"]=array("tblobject","tblobjectfiles","tblobject_");

		$this->mode="xml";

		$this->backup_dir=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR;
		$this->backup_dir_tmp=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp/";

	}


	function splitFile2() {
		global $_language;

		if($this->filename=="") return -1;
		if($this->mode=="sql") return we_backup::splitFile($this->filename);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExIm.class.php");

		return weXMLExIm::splitFile($this->filename,$this->backup_dir_tmp,$this->backup_steps);

		$path=$this->backup_dir_tmp;
		$marker="<!-- webackup -->";
		$pattern=basename($this->filename)."_%s";


		if($this->isCompressed($this->filename)){
			$this->compress="gzip";
		}
		else $this->compress="none";


		$header=$this->header;

		$buff = "";
		$filename_tmp="";

		if($this->compress!="none")
			$fh = @gzopen($this->filename, "rb");
		else
			$fh = @fopen($this->filename, "rb");

		$num=-1;
		$open_new=true;
		$fsize=0;

		$elnum=0;

		$marker_size=strlen($marker);

		if($fh) {
			while (!@feof ($fh)) {
				@set_time_limit(240);
				$line = "";
				$findline = false;

				while($findline == false && !@feof ($fh)) {

					if($this->compress!="none")
						$line .= @gzgets($fh,4096);
					else
						$line .= @fgets($fh,4096);

					if(substr($line,-1) == "\n") {
						$findline = true;
					}
				}

				if($open_new) {
					$num++;
					$filename_tmp=sprintf($path.$pattern,$num);
					$fh_temp=fopen($filename_tmp,"wb");
					fwrite($fh_temp,$header);
					if($num==0) $header="";
					$open_new=false;
				}

				if($fh_temp) {
					if((substr($line,0,2) != "<?") && (substr($line,0,11) != "<webEdition") && (substr($line,0,12) != "</webEdition")){

						$buff.=$line;
						$write=false;
						if($marker_size){
							if((substr($buff,(0-($marker_size+1)))==$marker."\n") || (substr($buff,(0-($marker_size+2)))==$marker."\r\n")) $write=true;
							else  $write=false;
						}
						else	$write=true;

						if($write) {
							$fsize+=strlen($buff);
							fwrite($fh_temp,$buff);
							if($marker_size) {
								$elnum++;
								if($elnum>=$this->backup_steps){
									$elnum=0;
									$open_new=true;
									fwrite($fh_temp,$this->footer);
									@fclose ($fh_temp);
								}
								$fsize=0;
							}
							$buff="";
						}
					}
					else{
						if(((substr($line,0,2) == "<?") || (substr($line,0,11) == "<webEdition")) && $num==0){
							$header.=$line;
						}
					}
				}
				else {
					return -1;
				}
			}
		}
		else {
			return -1;
		}
		if($fh_temp){
			if($buff){
				fwrite($fh_temp,$buff);
				fwrite($fh_temp,$this->footer);
			}
			@fclose ($fh_temp);
		}
		if($this->compress!="none") @gzclose ($fh);
		else @fclose ($fh);

		return $num+1;
	}

	function recoverTable($nodeset,&$xmlBrowser){
			global $l_backup;

			$attributes=$xmlBrowser->getAttributes($nodeset);

			$tablename=$attributes["name"];
			if(!$this->isFixed($tablename) && $tablename!=""){
				$tablename=$this->fixTableName($tablename);
				if (isset($this->description["import"][strtolower($tablename)]) && $this->description["import"][strtolower($tablename)]) $this->current_description = $this->description["import"][strtolower($tablename)];
				else $this->current_description = $l_backup["working"];

				$object=weContentProvider::getInstance("weTable",0,$tablename);
				$node_set2=$xmlBrowser->getSet($nodeset);
				foreach($node_set2 as $set2){
					$node_set3=$xmlBrowser->getSet($set2);
					foreach($node_set3 as $nsv){
						$tmp=$xmlBrowser->nodeName($nsv);
						if($tmp=="Field") $name=$xmlBrowser->getData($nsv);
						$object->elements[$name][$tmp]=$xmlBrowser->getData($nsv);
					}
				}

				if(!$this->ispRecoverTable($object->table)){

					if(
					((defined("OBJECT_TABLE") && $object->table==OBJECT_TABLE) ||
					(defined("OBJECT_FILES_TABLE") && $object->table==OBJECT_FILES_TABLE))
					 && $this->old_objects_deleted==0){
					 	$this->delOldTables();
						$this->old_objects_deleted=1;

					}
					$object->save();
				}
			}
	}

	function recoverTableItem($nodeset,&$xmlBrowser){
			$content=array();
			$node_set2=$xmlBrowser->getSet($nodeset);
			$classname="weTableItem";

			foreach($node_set2 as $nsk=>$nsv){
				$index=$xmlBrowser->nodeName($nsv);
				if(weContentProvider::needCoding($classname,$index)) $content[$index]=weContentProvider::decode($xmlBrowser->getData($nsv));
				else $content[$index]=$xmlBrowser->getData($nsv);
			}
			$attributes=$xmlBrowser->getAttributes($nodeset);

			$tablename=$attributes["table"];
			if(!$this->isFixed($tablename) && $tablename!=""){
				$tablename=$this->fixTableName($tablename);


				if($tablename==FILE_TABLE && defined("ISP_VERSION") && ISP_VERSION && in_array(substr($content["Path"],0,15),$GLOBALS["_isp_hide_files"]) && !$this->handle_options["configuration"]) return;
				//if($tablename==DOC_TYPES_TABLE && defined("ISP_VERSION") && ISP_VERSION && in_array($content["DocType"],$GLOBALS["_isp_hide_doctypes"])) return;

				$object=weContentProvider::getInstance($classname,0,$tablename);
				weContentProvider::populateInstance($object,$content);

				$object->save(true);
			}
	}


	function recoverBinary($nodeset,&$xmlBrowser){
			$content=array();
			$node_set2=$xmlBrowser->getSet($nodeset);
			$classname=weContentProvider::getContentTypeHandler("weBinary");
			foreach($node_set2 as $nsk=>$nsv){
				$index=$xmlBrowser->nodeName($nsv);
				if(weContentProvider::needCoding($classname,$index)) $content[$index]=weContentProvider::decode($xmlBrowser->getData($nsv));
				else $content[$index]=$xmlBrowser->getData($nsv);
			}
			$object=weContentProvider::getInstance($classname,0);
			weContentProvider::populateInstance($object,$content);

			if($object->ID && $this->backup_binary)	{
				$object->save(true);
			}
			else if($this->handle_options["settings"] && $object->Path=="/webEdition/we/include/conf/we_conf_global.inc.php"){
				weBackup::recoverPrefs($object);
			}
			else if(!$object->ID && $this->backup_extern){
				$object->save(true);
			}
	}

	function recoverPrefs(&$object){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weConfParser.class.php");
		$file="/webEdition/we/tmp/we_conf_global.inc.php";
		$object->Path=$file;
		$object->save(true);
		$parser = weConfParser::getConfParserByFile($_SERVER["DOCUMENT_ROOT"] . $file);

		$newglobals = $parser->getData();

		foreach ($newglobals as $k=>$v){
			 if ($v!='') {
			 	weConfParser::setGlobalPref($k,$v);
			 }
		}
		@unlink($_SERVER["DOCUMENT_ROOT"].$file);
	}

	function recoverInfo($nodeset,&$xmlBrowser){
			$content=array();
			$node_set2=$xmlBrowser->getSet($nodeset);

			$classname=weContentProvider::getContentTypeHandler("weBinary");
			$db2=new DB_WE();
			foreach($node_set2 as $nsk=>$nsv){
				$index=$xmlBrowser->nodeName($nsv);
				if($index=="we:map"){
					$attributes=$xmlBrowser->getAttributes($nsv);
					$tablename=$attributes["table"];
					if($tablename==$this->getDefaultTableName(TEMPLATES_TABLE)){
						$id=$attributes["ID"];
						$path=$attributes["Path"];
						//$this->backup_db->query("SELECT ".FILE_TABLE.".ID AS ID,".FILE_TABLE.".TemplateID AS TemplateID,".TEMPLATES_TABLE.".Path AS TemplatePath FROM ".FILE_TABLE.",".TEMPLATES_TABLE." WHERE ".FILE_TABLE.".TemplateID=".TEMPLATES_TABLE.".ID;");
						$this->backup_db->query("SELECT ID FROM ".TEMPLATES_TABLE." WHERE Path=".$path.";");
						if($this->backup_db->next_record()){
							if($this->backup_db->f("ID")!=$id) $db2->query("UPDATE ".FILE_TABLE." SET TemplateID=".$this->backup_db->f("ID")." WHERE TemplateID=".$id);
						}
					}
				}

			}
	}


	function recover($chunk_file){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLBrowser.class.php");
			if(!is_readable($chunk_file)) return false;
			@set_time_limit(240);

			$xmlBrowser=new weXMLBrowser($chunk_file);
			$xmlBrowser->mode="backup";

			foreach($xmlBrowser->nodes as $key=>$val){
				$name=$xmlBrowser->nodeName($key);
				if($name=="we:table"){
					weBackup::recoverTable($key,$xmlBrowser);
				}
				else if($name=="we:tableitem"){
					weBackup::recoverTableItem($key,$xmlBrowser);
				}
				if($name=="we:binary"){
					weBackup::recoverBinary($key,$xmlBrowser);
				}
				if($name=="we:info" && defined("ISP_VERSION") && ISP_VERSION){
					weBackup::recoverInfo($key,$xmlBrowser);
				}
			}
			return true;
	}

	function backup($id){

	}

	/**
	 * Function: makeBackup
	 *
	 * Description: This function initializes the creation of a backup.
	 */

	function makeBackup() {
		global $l_backup;

		$phase_start=false;
		$ret=0;
		if(!$this->tempfilename) {
			$this->tempfilename=$this->filename;
			$this->dumpfilename=$this->backup_dir_tmp.$this->tempfilename;
			$this->backup_step=0;

			if(!weFile::save($this->dumpfilename,$this->header)){
				$this->setError(sprintf($GLOBALS["l_backup"]["can_not_open_file"],$this->dumpfilename));
				return -1;
			}
		}

		if($this->backup_extern==1 && $this->backup_phase==0) {
			$this->exportExtern();
			$ret=true;
		}
		else{
			$ret=$this->exportTables();
		}
		return $ret;
	}


	/**
	 * Function: exportTables
	 *
	 * Description: This function saves the files in the previously builded
	 * table if the users chose to backup external files.
	 */

	function exportTables() {
		global $l_backup;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExIm.class.php");

		$tab=array();
		$tabtmp=array();
		$tables=array();
		$tab=$this->backup_db->table_names();

		$xmlExport=new weXMLExIm();
		$xmlExport->setBackupProfle();

		foreach($tab as $k=>$v) {
			$noprefix = $this->getDefaultTableName($v["table_name"]);
			if($noprefix && $this->isWeTable($noprefix)) array_push($tabtmp,$v["table_name"]);
		}

		$tables = $this->arraydiff($tabtmp,$this->extables);
		$num_tables = sizeof($tables);
		if($num_tables) {
				$i = 0;
				while($i < $num_tables) {

					$table = $tables[$i];
					$noprefix = $this->getDefaultTableName($table);

					if(!$this->isFixed($noprefix)) {

						//$metadata = $this->backup_db->metadata($table);

						if(!$this->partial) {
							$xmlExport->exportChunk(0,"weTable",$this->dumpfilename,$table,$this->backup_binary);

							$this->backup_step=0;
							$this->table_end=0;

							$this->table_end = f("SELECT COUNT(*) AS Count FROM $table","Count",$this->backup_db);
							/*$this->backup_db->query("SELECT COUNT(*) AS Count FROM $table");
							if($this->backup_db->next_record()) $this->table_end=$this->backup_db->f("Count");*/

						}

						if (isset($this->description["export"][strtolower($table)])) $this->current_description = $this->description["export"][strtolower($table)];
						else $this->current_description = $l_backup["working"];

						$keys=weTableItem::getTableKey($table);
						$this->partial=false;

						$query=$this->getBackupQuery($table,$keys);
						$this->backup_db->query($query);

						while($this->backup_db->next_record()) {

							$keyvalue=array();
							foreach($keys as $key) $keyvalue[]=$this->backup_db->f($key);

							$this->row_count++;

							$xmlExport->exportChunk(implode(",",$keyvalue),"weTableItem",$this->dumpfilename,$table,$this->backup_binary);
							$this->backup_step++;
						}
					}
					$i++;
					if($this->backup_step<$this->table_end && $this->backup_db->num_rows()!=0) {

						$this->partial=true;
						break;
					}
					else {
						$this->partial=false;
					}
					if(!$this->partial) {
						if(!in_array($table,$this->extables)) array_push($this->extables,$table);
					}
				}
		}
		if($this->partial) return 1;
		//$res=array();
		//$res=$this->arraydiff($tab,$this->extables);
		unset($xmlExport);
		return 0;
	}


	/**
	 * Function: exportMapper
	 *
	 * Description: This function exports the fields from table
	 */



	function exportInfo($filename,$table,$fields){
		if(!is_array($fields)) return false;
		// remve $res=array(); from exportTables function
		$out="<we:info>";
		$this->backup_db->query("SELECT ".implode(",",$fields)." FROM $table;");
		while ($this->backup_db->next_record()) {
			$out.='<we:map table="'.$this->getDefaultTableName($table).'"';
			foreach ($fields as $field) {
				$out.=' '.$field.'="'.$this->backup_db->f($field).'"';
			}
			$out.=">";
		}
		$out.="</we:info>";
		$out.=we_htmlElement::htmlComment("webackup")."\n";
		weFile::save($filename,$out,"ab");

	}


	/**
	 * Function: printDump2BackupDir
	 *
	 * Description: This function saves the dump to the backup directory.
	 */

	function printDump2BackupDir() {
		global $l_backup;

		@set_time_limit(240);
		$backupfilename=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR.$this->filename;
		if($this->compress!="none" && $this->compress!=""){
				$this->dumpfilename=weFile::compress($this->dumpfilename,$this->compress);
				$this->filename=$this->filename.".".weFile::getZExtension($this->compress);
		}

		if($this->export2server==1) {
			$backupfilename=$this->backup_dir.$this->filename;
			return @copy($this->dumpfilename,$backupfilename);
		}

		return true;
	}

	/**
	 * Function: removeDumpFile
	 *
	 * Description: This function deletes a database dump.
	 */

	function removeDumpFile() {
		if($this->export2send && !$this->export2server){
			insertIntoCleanUp($this->dumpfilename, time());
		}
		else if(is_file($this->dumpfilename)){
			@unlink($this->dumpfilename);
			$this->dumpfilename="";
			$this->tempfilename="";
		}

	}



	/**
	 * Function: restoreFromBackup
	 *
	 * Description: This function restores a backup.
	 */

	function restoreChunk($filename) {
		global $l_backup;

		if(!is_readable($filename)){
			$this->setError(sprintf($l_backup["can_not_open_file"],$filename));
			return false;
		}

		if($this->mode=="sql") return we_backup::restoreFromBackup($filename,$this->backup_extern);
		return $this->recover($filename);

	}

	function getVersion($file){
		if($this->isOldVersion($file)) $this->mode="sql";
		else $this->mode="xml";
	}

	function isOldVersion($file){
		$part=weFile::loadPart($file,0,512);
		if(eregi("# webEdition version:",$part) && eregi("DROP TABLE",$part) && eregi("CREATE TABLE",$part)) return true;
		else return false;
	}

	function isCompressed($file){
		$part=weFile::loadPart($file,0,512);
		if(eregi("<?xml version=",$part)) return false;
		else return true;
	}

	function getDownloadFile() {
		if($this->export2server) return $this->backup_dir.$this->filename;
		else return $this->dumpfilename;
	}

	#==============================================================================#

	/**
	 * Function: isFixed
	 *
	 * Description: This function checks if a table name has its correct value.
	 */

	function isFixed($tab) {
		if(defined("OBJECT_X_TABLE")){
			if(eregi(strtolower(OBJECT_X_TABLE),strtolower($tab))){
				if(isset($this->handle_options["object"]) && $this->handle_options["object"]) return false;
				else return true;
			}
		}
		else if(eregi("tblobject",strtolower($tab))){
			return true;
		}
		return we_backup::isFixed($tab) || !$this->isWeTable($tab);
	}

#==============================================================================#

	function getFileList($dir="",$with_dirs=false,$rem_doc_root=true){
		if($dir=="") $dir=$_SERVER["DOCUMENT_ROOT"];

		$d=dir($dir);
		while (false !== ($entry=$d->read())) {
			if(defined("ISP_VERSION") && ISP_VERSION && !$this->handle_options["configuration"]){
				$skip=false;
				foreach ($GLOBALS["_isp_hide_files"] as $hide){
					if(strpos("/".$entry,$hide)!==false){
						$skip=true;
					}
				}
				if($skip) continue;
			}
			if($entry != "." && $entry != ".." && $entry != "CVS" && $entry != "webEdition" && $entry != "sql_dumps" && $entry!=".project" && $entry!=".trustudio.dbg.php" && $entry!="LanguageChanges.csv") {
				$file=$dir."/".$entry;
				if(!$this->isPathExist(str_replace($_SERVER["DOCUMENT_ROOT"],"",$file))){
					if(is_dir($file)){
						if($with_dirs){
							$this->addToFileList($file,$rem_doc_root);
						}
						$this->getFileList($file,$with_dirs,$rem_doc_root);
					}
					else{
						$this->addToFileList($file,$rem_doc_root);
					}
				}
			}
		}
		$d->close();
		$this->file_list_count=count($this->file_list);
	}

	function addToFileList($file,$rem_doc_root=true){
		if($rem_doc_root){
			$this->file_list[]=str_replace($_SERVER["DOCUMENT_ROOT"],"",$file);
		} else {
			$this->file_list[]=$file;
		}
	}

	function getSiteFiles() {
		$this->getFileList($_SERVER["DOCUMENT_ROOT"].'/webEdition/site',true,false);
		$out = array();
		foreach ($this->file_list as $file) {
			$ct = f('SELECT ContentType FROM ' . FILE_TABLE . ' WHERE Path="' . str_replace($_SERVER['DOCUMENT_ROOT'].'/webEdition/site' , '' , $file) . '";','ContentType',$this->backup_db);
			if($ct) {
				if($ct != 'image/*' && $ct != 'application/*' && $ct != 'application/x-shockwave-flash') $out[]=$file;
			} else {
				$out[]=$file;
			}
		}
		$this->file_list = $out;
	}


	/**
	 * Function: exportExtern
	 *
	 * Description: This function backup external files.
	 *
	 */
	function exportExtern() {
		global $l_backup;

		$this->current_description=$l_backup['external_backup'];

		if(isset($this->file_list[0])){
				if(is_readable($_SERVER['DOCUMENT_ROOT'] . $this->file_list[0])){

					$this->exportFile($this->file_list[0]);

				}
				array_shift($this->file_list);
		}

		if(!count($this->file_list)){
			$this->backup_phase=1;
		}

	}

	/**
	 * Function: exportExtern
	 *
	 * Description: This function backup  given file to backup.
	 *
	 */
	function exportFile($file) {

		$fh = fopen($this->dumpfilename,'ab');
		if($fh){

			$bin=weContentProvider::getInstance('weBinary',0);
			$bin->Path = $file;

			weContentProvider::binary2file($bin,$fh,false);
			fclose($fh);
		}

	}

	function saveState($of="") {

		// Initialize variable
		$save = '';

		foreach($this->errors as $k=>$v) {
			$tmp=addslashes($v);
			$save.='$this->errors['.$k.']=\''.$tmp.'\''.";\n";
		}
		foreach($this->warnings as $k=>$v) {
			$tmp=addslashes($v);
			$save.='$this->warnings['.$k.']=\''.$tmp.'\''.";\n";
		}
		foreach($this->extables as $k=>$v) {
			$tmp=addslashes($v);
			$save.='$this->extables['.$k.']=\''.$tmp.'\''.";\n";
		}
		$tmp=addslashes($this->dumpfilename);
		$save.='$this->dumpfilename=\''.$tmp.'\''.";\n";

		$tmp=addslashes($this->tempfilename);
		$save.='$this->tempfilename=\''.$tmp.'\''.";\n";

		foreach($this->handle_options as $k=>$v) {
			$save.='$this->handle_options["'.$k.'"]=\''.$v.'\''.";\n";
		}

		foreach($this->properties as $prop) {
			$tmp=addslashes($this->$prop);
			$save.='$this->'.$prop.'=\''.$tmp.'\''.";\n";
		}

		foreach($this->dummy as $k=>$v) {
			$tmp=addslashes($v);
			$save.='$this->dummy['.$k.']=\''.$tmp.'\''.";\n";
		}

		foreach($this->file_list as $k=>$v) {
			$tmp=addslashes($v);
			$save.='$this->file_list['.$k.']=\''.$tmp.'\''.";\n";
		}

		if($of=="") $of=weFile::getUniqueId();
		weFile::save($this->backup_dir_tmp."$of",$save);
		return $of;
	}

	function getExportPercent(){
		$all = 0;
		$db=new DB_WE();
		$ver = getMysqlVer();
		if ($ver>3230 || $ver==3230) {
			$db->query("SHOW TABLE STATUS");
			while ($db->next_record()) {
				$noprefix = $this->getDefaultTableName($db->f("Name"));
				if(!$this->isFixed($noprefix)) $all += $db->f("Rows");
			}

			$ex_files=((int)$this->file_list_count)-((int)count($this->file_list));
			$all+=(int)$this->file_list_count;
			$done=((int)$this->row_count)+((int)$ex_files);
			$percent = (int)(($done / $all) * 100);
			if ($percent < 0) {
				$percent = 0;
			} else if ($percent > 100) {
				$percent = 100;
			}
		}
		return $percent;
	}

	function getImportPercent(){
		$file_list_count=(int)($this->file_list_count-count($this->file_list))/100;
		$percent = (int)((($this->file_counter + $file_list_count) / (($this->file_list_count/100) + $this->file_end)) * 100);
		if ($percent > 100) {
				$percent = 100;
		} else if ($percent < 0) {
				$percent = 0;
		}
		return $percent;
	}

	function setDescriptions(){
		global $l_backup;

		$this->description["import"][strtolower(CONTENT_TABLE)]=$l_backup["import_content"];
		$this->description["import"][strtolower(FILE_TABLE)]=$l_backup["import_files"];
		$this->description["import"][strtolower(DOC_TYPES_TABLE)]=$l_backup["import_doctypes"];
		if(isset($this->handle_options["users"]) && $this->handle_options["users"]) $this->description["import"][strtolower(USER_TABLE)]=$l_backup["import_user_data"];
		if(defined("CUSTOMER_TABLE") && isset($this->handle_options["customers"]) && $this->handle_options["customers"]) $this->description["import"][strtolower(CUSTOMER_TABLE)]=$l_backup["import_customers_data"];
		if(defined("SHOP_TABLE") && isset($this->handle_options["shop"]) && $this->handle_options["shop"]) $this->description["import"][strtolower(SHOP_TABLE)]=$l_backup["import_shop_data"];
		if(defined("ANZEIGE_PREFS_TABLE") && isset($this->handle_options["shop"]) && $this->handle_options["shop"]) $this->description["import"][strtolower(ANZEIGE_PREFS_TABLE)]=$l_backup["import_prefs"];
		$this->description["import"][strtolower(TEMPLATES_TABLE)]=$l_backup["import_templates"];
		$this->description["import"][strtolower(TEMPORARY_DOC_TABLE)]=$l_backup["import_temporary_data"];
		$this->description["import"][strtolower(BACKUP_TABLE)]=$l_backup["external_backup"];
		$this->description["import"][strtolower(LINK_TABLE)]=$l_backup["import_links"];
		$this->description["import"][strtolower(INDEX_TABLE)]=$l_backup["import_indexes"];

		$this->description["export"][strtolower(CONTENT_TABLE)]=$l_backup["export_content"];
		$this->description["export"][strtolower(FILE_TABLE)]=$l_backup["export_files"];
		$this->description["export"][strtolower(DOC_TYPES_TABLE)]=$l_backup["export_doctypes"];
		if(isset($this->handle_options["users"]) && $this->handle_options["users"]) $this->description["export"][strtolower(USER_TABLE)]=$l_backup["export_user_data"];
		if(defined("CUSTOMER_TABLE") && isset($this->handle_options["customers"]) && $this->handle_options["customers"]) $this->description["export"][strtolower(CUSTOMER_TABLE)]=$l_backup["export_customers_data"];
		if(defined("SHOP_TABLE") && isset($this->handle_options["shop"]) && $this->handle_options["shop"]) $this->description["export"][strtolower(SHOP_TABLE)]=$l_backup["export_shop_data"];
		if(defined("ANZEIGE_PREFS_TABLE") && isset($this->handle_options["shop"]) && $this->handle_options["shop"]) $this->description["export"][strtolower(ANZEIGE_PREFS_TABLE)]=$l_backup["export_prefs"];
		$this->description["export"][strtolower(TEMPLATES_TABLE)]=$l_backup["export_templates"];
		$this->description["export"][strtolower(TEMPORARY_DOC_TABLE)]=$l_backup["export_temporary_data"];
		$this->description["export"][strtolower(BACKUP_TABLE)]=$l_backup["external_backup"];
		$this->description["export"][strtolower(LINK_TABLE)]=$l_backup["export_links"];
		$this->description["export"][strtolower(INDEX_TABLE)]=$l_backup["export_indexes"];

	}

	function exportGlobalPrefs(){
		$file='/webEdition/we/include/conf/we_conf_global.inc.php';
		if(is_readable($_SERVER['DOCUMENT_ROOT'].$file)) {
			$this->exportFile($file);
		}

	}

	function writeFooter(){

		if(defined("ISP_VERSION") && ISP_VERSION){
			$this->exportInfo($this->dumpfilename,TEMPLATES_TABLE,array("ID","Path"));
		}
		if($this->handle_options["settings"]) $this->exportGlobalPrefs();
		weFile::save($this->dumpfilename,$this->footer,"ab");
	}

	//---------------------------------------------------------------------------------

	function getISPWheres($kind,$operator="LIKE",$logic="AND"){
				if(defined("ISP_VERSION") && ISP_VERSION && !$this->handle_options["configuration"]){
					if($kind=="file"){
						$_file_sql_arr=array();
						foreach($GLOBALS["_isp_hide_files"] as $_file){
							$_file_sql_arr[]=FILE_TABLE.".Path $operator '".$_file."%'";
						}
						return implode(" $logic ",$_file_sql_arr);
					}
					if($kind=="doctype"){
						$_doctype_sql_arr=array();
						foreach($GLOBALS["_isp_hide_doctypes"] as $_doctype) $_doctype_sql_arr[]=DOC_TYPES_TABLE.".DocType $operator '$_doctype'";
						return implode(" $logic ",$_doctype_sql_arr);
					}
				}
				return "";
	}


	function getBackupQuery($table,$keys){
				if($table==CONTENT_TABLE && defined("ISP_VERSION") && ISP_VERSION){
					$_file_sql=$this->getISPWheres("file","NOT LIKE");
					return

						"SELECT $table.ID as ID FROM $table,".LINK_TABLE.",".FILE_TABLE.
						" WHERE $table.ID=".LINK_TABLE.".CID AND ".LINK_TABLE.".DID=".FILE_TABLE.".ID AND ".
						LINK_TABLE.".DocumentTable<>'".substr(TEMPLATES_TABLE, strlen(TBL_PREFIX))."' ".(!empty($_file_sql) ? " AND ".$_file_sql : "").
						" LIMIT ".$this->backup_step.",".$this->backup_steps;

				}else if($table==LINK_TABLE && defined("ISP_VERSION") && ISP_VERSION){
					$_file_sql=$this->getISPWheres("file","NOT LIKE");
					//$keys=weTableItem::getTableKey($table);
					return
						"SELECT ".implode(",",$keys)." FROM $table,".FILE_TABLE.
						" WHERE $table.DID=".FILE_TABLE.".ID AND DocumentTable<>'".substr(TEMPLATES_TABLE, strlen(TBL_PREFIX))."' ".
						(!empty($_file_sql) ? " AND ".$_file_sql : "")." LIMIT ".$this->backup_step.",".$this->backup_steps;

				}else if($table==FILE_TABLE && defined("ISP_VERSION") && ISP_VERSION){
					$_file_sql=$this->getISPWheres("file","NOT LIKE");
					return "SELECT ID FROM $table WHERE $_file_sql LIMIT ".$this->backup_step.",".$this->backup_steps;
				}else{
					//$keys=weTableItem::getTableKey($table);
					return "SELECT ".implode(",",$keys)." FROM $table LIMIT ".$this->backup_step.",".$this->backup_steps;
				}
	}


	function ispRecoverTable($table){
				if(!defined("ISP_VERSION")) return false;
				if(!ISP_VERSION) return false;

				if($table==TEMPLATES_TABLE && defined("ISP_VERSION") && ISP_VERSION){
						return true;

				}
				/*
				else if($table==CONTENT_TABLE && defined("ISP_VERSION") && ISP_VERSION && weDBUtil::isTabExist(CONTENT_TABLE)){
						$_file_sql=$this->getISPWheres("file");
						$_file_sql="";
						$this->backup_db->query("SELECT ".CONTENT_TABLE.".ID AS ccid FROM ".CONTENT_TABLE.",".LINK_TABLE.",".FILE_TABLE." WHERE ".CONTENT_TABLE.".ID=".LINK_TABLE.".CID AND ".LINK_TABLE.".DID=".FILE_TABLE.".ID AND ".LINK_TABLE.".DocumentTable='".substr(FILE_TABLE, strlen(TBL_PREFIX))."'".($_file_sql!="" ? " AND ".$_file_sql : ""));
						$ids="";
						while($this->backup_db->next_record()){
							if($ids=="") $ids=$this->backup_db->f("ccid");
							else $ids.=",".$this->backup_db->f("ccid");
						}
						$this->backup_db->query("SELECT ".CONTENT_TABLE.".ID AS ccid FROM ".CONTENT_TABLE.",".LINK_TABLE.",".TEMPLATES_TABLE." WHERE ".CONTENT_TABLE.".ID=".LINK_TABLE.".CID AND ".LINK_TABLE.".DID=".TEMPLATES_TABLE.".ID AND  ".LINK_TABLE.".DocumentTable='".substr(TEMPLATES_TABLE, strlen(TBL_PREFIX))."';");
						while($this->backup_db->next_record()){
							if($ids=="") $ids=$this->backup_db->f("ccid");
							else $ids.=",".$this->backup_db->f("ccid");
						}
						if(!empty($ids)) $this->backup_db->query("DELETE FROM ".CONTENT_TABLE." WHERE ID NOT IN (".$ids.");");
						return true;
				}else if($table==LINK_TABLE && defined("ISP_VERSION") && ISP_VERSION && weDBUtil::isTabExist(LINK_TABLE)){
					$_file_sql=$this->getISPWheres("file");
					$_file_sql="";
					$this->backup_db->query("SELECT ".LINK_TABLE.".DID AS did FROM ".LINK_TABLE.",".FILE_TABLE." WHERE ".LINK_TABLE.".DID=".FILE_TABLE.".ID  AND ".LINK_TABLE.".DocumentTable='".substr(FILE_TABLE, strlen(TBL_PREFIX))."'".($_file_sql!="" ? " AND ".$_file_sql : ""));
					$ids="";
					while($this->backup_db->next_record()){
							if($ids=="") $ids=$this->backup_db->f("did");
							else $ids.=",".$this->backup_db->f("did");
					}
					$this->backup_db->query("SELECT ".LINK_TABLE.".DID AS did FROM ".LINK_TABLE.",".TEMPLATES_TABLE." WHERE ".LINK_TABLE.".DID=".TEMPLATES_TABLE.".ID  AND ".LINK_TABLE.".DocumentTable='".substr(TEMPLATES_TABLE, strlen(TBL_PREFIX))."';");
					while($this->backup_db->next_record()){
							if($ids=="") $ids=$this->backup_db->f("did");
							else $ids.=",".$this->backup_db->f("did");
					}
					if(!empty($ids)) $this->backup_db->query("DELETE FROM ".LINK_TABLE." WHERE DID NOT IN (".$ids.");");

					return true;
				}else if($table==FILE_TABLE && defined("ISP_VERSION") && ISP_VERSION && weDBUtil::isTabExist(FILE_TABLE)){
						$_file_sql=$this->getISPWheres("file","NOT LIKE");
						$this->backup_db->query("DELETE FROM ".FILE_TABLE." WHERE $_file_sql;");
						return true;
				//}else if($table==DOC_TYPES_TABLE && defined("ISP_VERSION") && ISP_VERSION && weDBUtil::isTabExist(DOC_TYPES_TABLE)){
				//		$_doctype_sql=$this->getISPWheres("doctype","=");
				//		$this->backup_db->query("DELETE FROM ".DOC_TYPES_TABLE.($_doctype_sql!="" ? " WHERE $_doctype_sql;" :""));
				//		return true;

				}
				*/

				return false;

	}

	function delOldTables(){
		if(!defined("OBJECT_X_TABLE")) return;
		if(!isset($this->handle_options["object"])) return;
		if(!$this->handle_options["object"]) return;
		$this->backup_db->query("SHOW TABLE STATUS");
		while ($this->backup_db->next_record()) {
			$table=$this->backup_db->f("Name");
			$name=substr($this->backup_db->f("Name"), strlen(TBL_PREFIX));
			if(substr(strtolower($name),0,10)==strtolower(substr(OBJECT_X_TABLE, strlen(TBL_PREFIX))) && is_numeric(str_replace(strtolower(OBJECT_X_TABLE),"",strtolower($table)))){
				weDBUtil::delTable($table);
			}

		}
	}

	function doUpdate(){
		$updater=new we_updater();
		$updater->doUpdate();
	}

	function clearTemporaryData($docTable){
		$this->backup_db->query("DELETE FROM ".TEMPORARY_DOC_TABLE." WHERE DocTable='$docTable';");
	}


}
?>