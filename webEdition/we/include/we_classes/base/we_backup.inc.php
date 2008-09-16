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


/**
 * Class we_backup
 *
 * Provides functions for exporting and importing backups.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_updater.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");

define("BACKUP_TABLE",TBL_PREFIX . "tblbackup");

class we_backup {

	/*************************************************************************
	 * VARIABLES
	 *************************************************************************/

	var $backup_db;

	var $errors=array();
	var $warnings=array();
	var $extables=array();

	var $mysql_max_packet=1048576;

	var $dumpfilename="";
	var $tempfilename="";


	var $handle_options=array();

	var $default_backup_steps=30;
	var $default_backup_len=150000;
	var $default_offset=100000;
	var $default_split_size=150000;

	var $backup_step;
	var $backup_steps;

	var $backup_phase=0;
	var $backup_extern=0;

	var $export2server=0;
	var $export2send=0;

	var $partial;
	var $current_insert="";
	var $table_end=0;
	var $description=array();
	var $current_description="";

	var $offset=0;

	var $dummy=array();

	var $table_map=array(
			"tblbackup"=>BACKUP_TABLE,
			"tblcategorys"=>CATEGORY_TABLE,
			"tblcleanup"=>CLEAN_UP_TABLE,
			"tblcontent"=>CONTENT_TABLE,
			"tbldoctypes"=>DOC_TYPES_TABLE,
			"tblerrorlog"=>ERROR_LOG_TABLE,
			"tblfile"=>FILE_TABLE,
			"tbllink"=>LINK_TABLE,
			"tbltemplates"=>TEMPLATES_TABLE,
			"tbltemporarydoc"=>TEMPORARY_DOC_TABLE,
			"tblindex"=>INDEX_TABLE,
			"tblpasswd"=>PASSWD_TABLE,
			"tblprefs"=>PREFS_TABLE,
			"tblrecipients"=>RECIPIENTS_TABLE,
			"tblupdatelog"=>UPDATE_LOG_TABLE,
			"tblfailedlogins"=>FAILED_LOGINS_TABLE,
			"tblthumbnails"=>THUMBNAILS_TABLE,
			"tblvalidationservices"=>VALIDATION_SERVICES_TABLE
	);

	var $fixedTable=array(
			"tblbackup","tblhelpindex","tblhelptopic","tblhelplink",
			"tblerrorlog","tblcleanup", "tbllock",
			"tblfailedlogins","tblupdatelog");

	var $tables=array();

	var $properties=array(
			"default_backup_steps","backup_step","backup_steps","backup_phase","backup_extern",
			"export2server","export2send","partial","current_insert","table_end","current_description","offset"
	);


	/*************************************************************************
	 * CONSTRUCTOR
	 *************************************************************************/

	/**
	 * Constructor of class.
	 *
	 * @param      $handle_users                           bool
	 * @param      $handle_customers                       bool
	 * @param      $handle_shop                            bool
	 * @param      $handle_workflow                        bool
	 * @param      $handle_todo                            bool
	 * @param      $handle_newsletter                      bool
	 *
	 * @return     we_backup
	 */

	//function we_backup($handle_users=false,$handle_customers=false,$handle_shop=false,$handle_workflow=false,$handle_todo=false,$handle_newsletter=false) {
	function we_backup($handle_options=array()){
		global $l_backup;

		$this->backup_db = new DB_WE();
		$this->backup_steps=$this->default_backup_steps;
		$this->partial=false;

		$this->handle_options=$handle_options;

		$this->backup_db->query("SHOW VARIABLES");
		while($this->backup_db->next_record()){
			if($this->backup_db->f("Variable_name")=="max_allowed_packet") $this->mysql_max_packet=$this->backup_db->f("Value");
		}

		$this->table_map=array_merge($this->table_map,array("tbluser"=>USER_TABLE,"tbllock"=>LOCK_TABLE));

		if(defined("SCHEDULE_TABLE")) $this->table_map=array_merge($this->table_map,array("tblschedule"=>SCHEDULE_TABLE));

		if(defined("CUSTOMER_TABLE")) $this->table_map=array_merge($this->table_map,array("tblwebuser"=>CUSTOMER_TABLE,"tblwebadmin"=>CUSTOMER_ADMIN_TABLE));

		if(defined("OBJECT_TABLE")) $this->table_map=array_merge($this->table_map,array("tblobject"=>OBJECT_TABLE,"tblobjectfiles"=>OBJECT_FILES_TABLE,"tblobject_"=>OBJECT_X_TABLE));

		if(defined("SHOP_TABLE")) $this->table_map=array_merge($this->table_map,array("tblanzeigeprefs"=>ANZEIGE_PREFS_TABLE,"tblorders"=>SHOP_TABLE));

		if(defined("WORKFLOW_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tblworkflowdef"=>WORKFLOW_TABLE,
					"tblworkflowstep"=>WORKFLOW_STEP_TABLE,
					"tblworkflowtask"=>WORKFLOW_TASK_TABLE,
					"tblworkflowdoc"=>WORKFLOW_DOC_TABLE,
					"tblworkflowdocstep"=>WORKFLOW_DOC_STEP_TABLE,
					"tblworkflowdoctask"=>WORKFLOW_DOC_TASK_TABLE,
					"tblworkflowlog"=>WORKFLOW_LOG_TABLE
				)
			);

		if(defined("MSG_TODO_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tbltodo"=>MSG_TODO_TABLE,
					"tbltodohistory"=>MSG_TODOHISTORY_TABLE,
					"tblmessages"=>MESSAGES_TABLE,
					"tblmsgaccounts"=>MSG_ACCOUNTS_TABLE,
					"tblmsgaddrbook"=>MSG_ADDRBOOK_TABLE,
					"tblmsgfolders"=>MSG_FOLDERS_TABLE,
					"tblmsgsettings"=>MSG_SETTINGS_TABLE
				)
			);

		if(defined("NEWSLETTER_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tblnewsletter"=>NEWSLETTER_TABLE,
					"tblnewslettergroup"=>NEWSLETTER_GROUP_TABLE,
					"tblnewsletterblock"=>NEWSLETTER_BLOCK_TABLE,
					"tblnewsletterlog"=>NEWSLETTER_LOG_TABLE,
					"tblnewsletterprefs"=>NEWSLETTER_PREFS_TABLE,
					"tblnewsletterconfirm"=>NEWSLETTER_CONFIRM_TABLE
				)
			);

		if(defined("BANNER_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tblbanner"=>BANNER_TABLE,
					"tblbannerclicks"=>BANNER_CLICKS_TABLE,
					"tblbannerprefs"=>BANNER_PREFS_TABLE,
					"tblbannerviews"=>BANNER_VIEWS_TABLE
				)
			);

		if(defined("EXPORT_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tblexport"=>EXPORT_TABLE
				)
			);

		if(defined("VOTING_TABLE")) $this->table_map=array_merge($this->table_map,
				array(
					"tblvoting"=>VOTING_TABLE
				)
			);

		$this->tables["settings"]=array("tblprefs","tblrecipients","tblvalidationservices");
		$this->tables["configuration"]=array();

		$this->tables["users"]=array(
				"tblpasswd","tbluser"
		);
		$this->tables["customers"]=array("tblwebuser","tblwebadmin");
		$this->tables["shop"]=array("tblanzeigeprefs","tblorders");
		$this->tables["workflow"]=array(
				"tblworkflowdef","tblworkflowstep","tblworkflowtask",
				"tblworkflowdoc","tblworkflowdocstep","tblworkflowdoctask",
				"tblworkflowlog"
		);
		$this->tables["todo"]=array(
				"tbltodo","tbltodohistory","tblmessages","tblmsgaccounts",
				"tblmsgaddrbook","tblmsgfolders","tblmsgsettings"
		);
		$this->tables["newsletter"]=array(
				"tblnewsletter","tblnewslettergroup",
				"tblnewsletterblock","tblnewsletterlog",
				"tblnewsletterprefs","tblnewsletterconfirm"
		);
		$this->tables["temporary"]=array("tbltemporarydoc");

		$this->tables["banner"]=array(
				"tblbanner","tblbannerclicks",
				"tblbannerprefs","tblbannerviews"
		);

		$this->tables["schedule"]=array(
				"tblschedule"
		);

		$this->tables["export"]=array(
				"tblexport"
		);

		$this->tables["voting"]=array(
				"tblvoting"
		);

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

		$this->clearOldTmp();
	}

	/*************************************************************************
	 * FUNCTIONS
	 *************************************************************************/

	/**
	 * This function checks if a given path exists in the database.
	 *
	 * @param      $path                                   string
	 *
	 * @see        putFileInDB()
	 * @see        putDirInDB()
	 *
	 * @return     bool
	 */

	function isPathExist($path) {
		$tmp_db = new DB_WE;
		$this->backup_db->query("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$path."'");
		$tmp_db->query("SELECT ID FROM ".TEMPLATES_TABLE." WHERE Path='".$path."'");
		if(($this->backup_db->next_record())||($tmp_db->next_record()))
			return true;
		else
			return false;
	}

	/**
	 * This function puts a given file into the database.
	 *
	 * @param      $file                                   string
	 *
	 * @see        isPathExist()
	 *
	 * @return     bool
	 */

	function putFileInDB($file) {
		@set_time_limit(80);
		$nl = "\n";
		$rootdir = $_SERVER["DOCUMENT_ROOT"];
		$rootdir = str_replace("\\","/",$rootdir);
		if(substr($rootdir,-1) == "/")
			$rootdir = substr($rootdir,0,strlen($rootdir)-1);
		$path = substr($file,strlen($rootdir),strlen($file)-strlen($rootdir));
		$ok=true;
		if(!$this->isPathExist($path)) {
			$fd = @fopen ($file, "rb");
			if($fd)
				if(@filesize($file)>$this->mysql_max_packet) {
					$ok=false;
					$this->setWarning(sprintf($GLOBALS["l_backup"]["too_big_file"],$file));
				}
				else {
					$contents = @fread ($fd, filesize ($file));
				}
			else {
				$this->setError(sprintf($GLOBALS["l_backup"]["can_not_open_file"],$file));
				$ok=false;
				return false;
			}
			@fclose ($fd);
			if($ok) {
				$contents=addslashes($contents);
				$contents=str_replace("\n","\\n",$contents);
				$contents=str_replace("\r","\\r",$contents);
				$q="INSERT INTO ".BACKUP_TABLE." (Path,Data,IsFolder) VALUES ('".addslashes($path)."','".$contents."',0)";
				$fh=fopen($this->dumpfilename,"ab");
				fwrite($fh,$q.";".$nl);
				fclose($fh);
				$this->backup_db->query($q);
			}
		}
		return true;
	}

	/**
	 * This function puts a given directory completely into the
	 * database by partly using the function putFileInDB.
	 *
	 * @param      $dir                                    string
	 *
	 * @see        isPathExist()
	 *
	 * @return     bool
	 */

	function putDirInDB($dir) {
		@set_time_limit(80);
		$nl = "\n";
		$rootdir = $_SERVER["DOCUMENT_ROOT"];
		$rootdir = str_replace("\\","/",$rootdir);
		if(substr($rootdir,-1) == "/")
			$rootdir = substr($rootdir,0,strlen($rootdir)-1);
		$path = substr($dir,strlen($rootdir),strlen($dir)-strlen($rootdir));
		if(!$this->isPathExist($path)) {
			$q="INSERT INTO ".BACKUP_TABLE." (Path,Data,IsFolder) VALUES ('".addslashes($path)."','',1)";
			$fh=fopen($this->dumpfilename,"ab");
			fwrite($fh,$q.";".$nl);
			fclose($fh);
			$this->backup_db->query($q);
		}
		$dir = str_replace("\\","/",$dir);
		if(substr($dir,-1) != "/")
			$dir .= "/";
		$d = @dir($dir);
		if($d) {
			while (false !== ($entry=$d->read())) {
				if($entry != "." && $entry != "..") {
					if(is_dir($dir.$entry)) {
						if($entry != "." && $entry != "..") $this->putDirInDB($dir.$entry);
					}
					else {
						if(!$this->putFileInDB($dir.$entry))
							return false;
					}
				}
			}
			$d->close();
		}
		return true;
	}

	/**
	 * This function returns the definition (paramaters) of a
	 * given table.
	 *
	 * @param      $table                                  string
	 * @param      $nl                                     string
	 *
	 * @return     string
	 */

	function tableDefinition($table, $nl,$noprefix) {
		$foo = "";
		$foo .= "DROP TABLE IF EXISTS $noprefix;$nl";
		$foo .= "CREATE TABLE $noprefix ($nl";
		$this->backup_db->query("SHOW FIELDS FROM $table");
		while($this->backup_db->next_record()) {
			$row = $this->backup_db->Record;
			$foo .= "   $row[Field] $row[Type]";
			if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0")) {
				$foo .= " DEFAULT '$row[Default]'";
			}
			if($row["Null"] != "YES") {
				$foo .= " NOT NULL";
			}
			if($row["Extra"] != "") {
				$foo .= " $row[Extra]";
			}
			$foo .= ",$nl";
		}
		$foo = ereg_replace(",".$nl."$", "", $foo);
		$this->backup_db->query("SHOW KEYS FROM $table");
		while($this->backup_db->next_record()) {
			$row = $this->backup_db->Record;
			$key=$row['Key_name'];
			if(($key != "PRIMARY") && ($row['Non_unique'] == 0)) {
				$key="UNIQUE|$key";
			}
			if(!isset($index[$key])) {
				$index[$key] = array();
			}
			$index[$key][] = $row['Column_name'];
		}
		while(list($k, $v) = @each($index)) {
			$foo .= ",$nl";
			if($k == "PRIMARY") {
				$foo .= "   PRIMARY KEY (" . implode($v, ", ") . ")";
			}
			else if (substr($k,0,6) == "UNIQUE") {
				$foo .= "   UNIQUE ".substr($k,7)." (" . implode($v, ", ") . ")";
			}
			else {
				$foo .= "   KEY $k (" . implode($v, ", ") . ")";
			}
		}
		$foo .= "$nl)";
		return stripslashes($foo);
	}

#==============================================================================#

	/**
	 * Function: makeBackup
	 *
	 * Description: This function initializes the creation of a backup.
	 */

	function makeBackup() {
		$nl = "\n";
		$phase_start=false;
		$ret=0;
		if(!$this->tempfilename) {
			$this->tempfilename=md5(uniqid(time())).".php";
			$this->dumpfilename=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp/".$this->tempfilename;
			$this->backup_step=0;
			$this->backup_steps=$this->default_backup_steps;
			$fh=@fopen($this->dumpfilename,"ab");
			if($fh) {
				@fwrite($fh,"#<?php exit();?>\n");
				@fwrite($fh,"# webEdition MySQL-Dump$nl");
				@fwrite($fh,"# http://www.webedition.de$nl");
				@fwrite($fh,"#$nl");
				@fwrite($fh,"# Host: ".SERVER_NAME."   Datenbank: ".$this->backup_db->Database.";$nl");
				@fwrite($fh,"# webEdition version: ".WE_VERSION.$nl);
				@fwrite($fh,"# Date: ".date("d.M.Y H:i:s").$nl);
				@fclose($fh);
			}
			else {
				$this->setError(sprintf($GLOBALS["l_backup"]["can_not_open_file"],$this->dumpfilename));
				return -1;
			}
		}
		if($this->backup_extern==1) {
			if($this->backup_phase==0) {
				$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);
				$this->backup_db->query("CREATE TABLE ".BACKUP_TABLE." (ID bigint(20) NOT NULL auto_increment,Path varchar(255) NOT NULL,Data longblob NOT NULL,IsFolder tinyint(1) DEFAULT '0' NOT NULL,PRIMARY KEY (ID),UNIQUE ID (ID),KEY ID_2 (ID));");
				$fh=@fopen($this->dumpfilename,"ab");
				@fwrite($fh,$nl);
				@fwrite($fh,"#############################################################$nl");
				@fwrite($fh,"#$nl");
				@fwrite($fh,"# Tablestructure '".BACKUP_TABLE."'$nl");
				@fwrite($fh,"#$nl");
				@fwrite($fh,$nl);
				@fwrite($fh,$this->tableDefinition(BACKUP_TABLE, $nl,BACKUP_TABLE).";$nl$nl");
				@fwrite($fh,"#$nl");
				@fwrite($fh,"# dumping Data '".BACKUP_TABLE."'$nl");
				@fwrite($fh,"#$nl");
				@fwrite($fh,$nl);
				@fclose($fh);
			}
			$phase_start=true;
			$this->backup_phase=1;
			$ret=$this->buildBackupTable();
			if($ret==0) {
				$this->backup_extern=0;
				$ret=1;
			}
		}
		if((!$phase_start)) {
			$this->backup_phase=2;
			$ret=$this->exportTables();
		}
		return $ret;
	}

#==============================================================================#

	/**
	 * Function: buildBackupTable
	 *
	 * Description: This function builds the table if the users chooses to
	 * backup external files.
	 */

	function buildBackupTable() {
		global $l_backup;
		$this->current_description=$l_backup["external_backup"];
		$rootdir = $_SERVER["DOCUMENT_ROOT"];
		$rootdir = str_replace("\\","/",$rootdir);
		if(substr($rootdir,-1) != "/")
			$rootdir .= "/";
		$count=0;
		$done=0;
		$len=0;
		$finish=0;
		$d = @dir($rootdir);
		while (false !== ($entry=$d->read())) {
			$count++;
			if($entry != "." && $entry != ".." && $entry != "CVS" && $entry != "webEdition" && $this->backup_step<$count) {
				if(is_dir($rootdir.$entry)) {
					if(!$this->putDirInDB($rootdir.$entry))
						return -1;
				}
				else {
					if(!$this->putFileInDB($rootdir.$entry))
						return -1;
				}
				$len=$len+filesize($rootdir.$entry);
				$done++;
				if(($done==$this->backup_steps)||($len>$this->default_backup_len)) {
					$finish=1;
					break;
				}
			}
		}
		$d->close();
		$this->backup_step=$count;
		return $finish;
	}

#==============================================================================#

	/**
	 * Function: exportTables
	 *
	 * Description: This function saves the files in the previously builded
	 * table if the users chose to backup external files.
	 */

	function exportTables() {
		global $l_backup;
		$nl = "\n";
		$len=0;
		$tab=array();
		$tabtmp=array();
		$tables=array();
		$tab=$this->backup_db->table_names();
		$insert = "";
		foreach($tab as $k=>$v) {
			if($v["table_name"] && $this->isWeTable($v["table_name"]))
				array_push($tabtmp,$v["table_name"]);
		}
		$tables = $this->arraydiff($tabtmp,$this->extables);
		$num_tables = sizeof($tables);
		if($num_tables) {
			$i = 0;
			$fh=@fopen($this->dumpfilename,"ab");
			if($fh){
				while($i < $num_tables) {
					$exp=0;
					$table = $tables[$i];
					//$noprefix = $this->rmTablePrefix($table);
					$noprefix = $this->getDefaultTableName($table);
					if(!$this->isFixed($noprefix)) {
						$metadata = $this->backup_db->metadata($table);
						if(!$this->partial) {
							@fwrite($fh,$nl);
							@fwrite($fh,"#############################################################$nl");
							@fwrite($fh,"#$nl");
							@fwrite($fh,"# Tablestructure '$noprefix'$nl");
							@fwrite($fh,"#$nl");
							@fwrite($fh,$nl);
							@fwrite($fh,$this->tableDefinition($table, $nl,$noprefix).";$nl$nl");
							@fwrite($fh,"#$nl");
							@fwrite($fh,"# dumping Data '$noprefix'$nl");
							@fwrite($fh,"#$nl");
							@fwrite($fh,$nl);
							$this->backup_step=0;
							$this->table_end=0;
							$this->backup_db->query("SELECT COUNT(*) AS Count FROM $table");
							if($this->backup_db->next_record())
								$this->table_end=$this->backup_db->f("Count");
							$fieldnames = "(";
							for($k=0; $k<sizeof($metadata); $k++) {
								$fieldnames .= $metadata[$k]["name"].", ";
							}
							$fieldnames = substr($fieldnames,0,-2);
							$fieldnames .= ")";
							$this->current_insert = "INSERT INTO $noprefix $fieldnames VALUES (";
							if (isset($this->description["export"][strtolower($noprefix)])) {
									$this->current_description = $this->description["export"][strtolower($noprefix)];
							} else {
									$this->current_description = $l_backup["working"];
							}
						}
						$this->partial=false;
						$limit=$this->backup_steps;
						$this->backup_db->query("SELECT * FROM $table LIMIT ".$this->backup_step.",".$limit);
						while($this->backup_db->next_record()) {
							if(strtolower($table)==strtolower(CONTENT_TABLE)) {
								$db = new DB_WE;
								$siz = f("SELECT LENGTH(Dat) as Dat FROM ".CONTENT_TABLE." WHERE ID=" .$this->backup_db->f("ID"),"Dat",$db);
							}
							else {
								$siz = 0;
							}
							@set_time_limit(80);
							if (!$this->offset) {
								$insert=$this->current_insert;
							}
							for ($j = 0; $j < sizeof($metadata); $j++) {
								if (strtolower($table) == strtolower(CONTENT_TABLE) && $metadata[$j]["name"] == "Dat") {
									if($siz > ($this->offset + $this->default_offset) || $this->offset) {
										if (!$this->offset) {
											$insert .= " '";
										}
										$new =substr($this->backup_db->f($metadata[$j]["name"]), $this->offset, $this->default_offset);
										$new = addslashes($new);
										if($siz < ($this->offset + $this->default_offset)) {
											$this->offset = 0;
										} else {
											$this->offset = $this->offset + $this->default_offset;
										}
										$insert .= $new;
										if($this->offset) {
											break;
										} else {
											$insert .="',";
										}
									} else {
										$new = addslashes($this->backup_db->f($metadata[$j]["name"]));
										$insert .= " '".$new."',";
									}
								}
								else if(!$this->offset) {
									$new = addslashes($this->backup_db->f($metadata[$j]["name"]));
									$insert .= " '".$new."',";
								}
							}
							$insert=str_replace("\n","\\n",$insert);
							$insert=str_replace("\r","\\r",$insert);
							$insert = ereg_replace(",$", "", $insert);
							if(!$this->offset)
								$insert .= ");$nl";
							@fwrite($fh,$insert);
							$len=$len+strlen($insert);
							if(!$this->offset)
								$exp++;
							$insert="";
							if($len>$this->default_backup_len || $this->offset) {
								$this->partial=true;
								break;
							}
						}
					}
					$i++;
					$this->backup_step=$this->backup_step+$exp;
					if($this->backup_step<$this->table_end) {
						$this->partial=true;
						break;
					}
					else {
						$this->partial=false;
					}
					if(!$this->partial) {
						if(!in_array($table,$this->extables))
							array_push($this->extables,$table);
						@fwrite($fh,$nl);
					}
				}
				@fclose($fh);
			}
			else {
				$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);
				$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);
				$this->setError(sprintf($GLOBALS["l_backup"]["can_not_open_file"],$this->dumpfilename));
				return -1;
			}
		}
		if($this->partial) {
			return 1;
		}
		$res=array();
		$res=$this->arraydiff($tab,$this->extables);
		if(sizeof($res)==0) {
			$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);
			$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);
		}
		return 0;
	}

#==============================================================================#

	/**
	 * Function: printDump
	 *
	 * Description: This function saves a given file into the dump.
	 */

	function printDump() {
		$fh=@fopen($this->dumpfilename,"rb");
		if($fh) {
			while (!@feof ($fh)) {
				print @fread($fh,52428);
				@set_time_limit(80);
			}
			@fclose($fh);
		}
		else {
			$this->setError(sprintf($GLOBALS["l_backup"]["can_not_open_file"],$this->dumpfilename));
			return false;
		}
		return true;
	}

#==============================================================================#

	/**
	 * Function: printDump2BackupDir
	 *
	 * Description: This function saves the dump to the backup directory.
	 */

	function printDump2BackupDir() {
		if($this->export2server==1) {
			$backupfilename=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."weBackup_".time().".php";
			return @copy($this->dumpfilename,$backupfilename);
		}
		return true;
	}

#==============================================================================#

	/**
	 * Function: setTmpFilename
	 *
	 * Description: This function sets the output filename of the backup if the
	 * user chose to save it on the server.
	 */

	function setTmpFilename($filename) {
		if($this->isFileInTmpDir($filename)) {
			if(is_file(TMP_DIR."/".$filename)) {
				$this->tempfilename=$filename;
				$this->dumpfilename=TMP_DIR."/".$filename;
				return true;
			}
			else
				return false;
		}
		else
			return false;
	}

#==============================================================================#

	/**
	 * Function: isFileInTmpDir
	 *
	 * Description: This function checks if a file is in the temporary
	 * directory used for backups.
	 */

	function isFileInTmpDir($file_name) {
		$dir=TMP_DIR."/";
		$d = @dir($dir);
		$ret=false;
		if($d) {
			while (false !== ($entry=$d->read())) {
				if($entry==$file_name)
					$ret=true;
			}
			$d->close();
		}
		return $ret;
	}

#==============================================================================#

	/**
	 * Function: getTmpFilename
	 *
	 * Description: This function returns the filename of a file located in the
	 * temporary directory used for backups.
	 */

	function getTmpFilename() {
		return $this->tempfilename;
	}

#==============================================================================#

	/**
	 * Function: removeDumpFile
	 *
	 * Description: This function deletes a database dump.
	 */

	function removeDumpFile() {
		if(is_file($this->dumpfilename)) @unlink($this->dumpfilename);

		$this->dumpfilename="";
		$this->tempfilename="";
	}

#==============================================================================#

	/**
	 * Function: restoreFiles
	 *
	 * Description: This function initializes the import of a backup.
	 */

	function restoreFiles() {
		global $l_backup;
		$exist=false;
		$tab=@mysql_list_tables($this->backup_db->Database);
		while (list($tname)=@mysql_fetch_array($tab)) {
			if(strtolower($tname)==strtolower(BACKUP_TABLE))
				$exist=true;
		}
		if($exist) {
			$link = mysql_connect($this->backup_db->Host, $this->backup_db->User, $this->backup_db->Password);
			mysql_select_db($this->backup_db->Database);
			$query = "SELECT * FROM ".BACKUP_TABLE." ORDER BY IsFolder DESC, Path ASC";
			$result = mysql_unbuffered_query($query);
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
				@set_time_limit(80);
				if($line["IsFolder"]) {
					$dir=$_SERVER["DOCUMENT_ROOT"].$line["Path"];
					$sdir=dirname($dir);
					$sdir = str_replace("\\","/",$sdir);
					while((!file_exists($sdir))&&($sdir!="/")) {
						createLocalFolder($sdir);
						$sdir=dirname($sdir);
						$sdir = str_replace("\\","/",$sdir);
					}
					if (!file_exists($dir)) {
						createLocalFolder($dir);
					}
				}
				else {
					$sdir=dirname($_SERVER["DOCUMENT_ROOT"].$line["Path"]);
					$sdir = str_replace("\\","/",$sdir);
					$fh=@fopen($_SERVER["DOCUMENT_ROOT"].$line["Path"],"wb");
					if($fh) {
						@fwrite($fh,$line["Data"]);
						@fclose($fh);
					}
					else {
						$this->setError($l_backup["can_not_open_file"],$line["Path"]);
						return false;
					}
				}
			}
			mysql_free_result($result);
			mysql_close($link);
		}
		return true;
	}

#==============================================================================#

	/**
	 * Function: splitFile
	 *
	 * Description: This function splits a file.
	 */

	function splitFile($backup_select) {
		global $l_backup;

		$buff = "";

		$this->current_description=$l_backup["preparing_file"];

		$filename=$backup_select;
		$backup_select=uniqid(rand());

		$filename_tmp="";
		$fh = fopen ($filename, "rb");
		$num=-1;
		$open_new=true;
		$fsize=0;

		if($fh) {

			while (!@feof ($fh)) {
				@set_time_limit(60);
				$line = "";
				$findline = false;

				while($findline == false && !@feof ($fh)) {
					$line .= @fgets($fh,4096);
					if(substr($line,-1) == "\n") {
						$findline = true;
					}
				}

				if($open_new) {
					$num++;
					$filename_tmp=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."/tmp/".basename($filename)."_".$num;
					$fh_temp=fopen($filename_tmp,"wb");
					$open_new=false;
				}
				if($fh_temp) {
					if(substr($line,0,1) != "#") {
						$buff.=$line;
						if((substr($buff,-2) == ";\n")||(substr($buff,-3) == ";\r\n")) {
							$fsize+=strlen($buff);
							fwrite($fh_temp,$buff);
							if($fsize>$this->default_split_size) {
								$open_new=true;
								@fclose ($fh_temp);
								$fsize=0;
							}
							$buff="";
						}
					}
				}
				else {
					$this->setError($l_backup["can_not_open_file"],basename($filename)."_".$num);
					return -1;
				}
			}
		}
		else {
			$this->setError($l_backup["can_not_open_file"],basename($filename)."_".$num);
			return -1;
		}
		if($fh_temp) @fclose ($fh_temp);
		@fclose ($fh);
		if(defined("WORKFLOW_TABLE")) {
			$this->backup_db->query("DELETE FROM ".WORKFLOW_DOC_TABLE);
			$this->backup_db->query("DELETE FROM ".WORKFLOW_DOC_STEP_TABLE);
			$this->backup_db->query("DELETE FROM ".WORKFLOW_DOC_TASK_TABLE);
			$this->backup_db->query("DELETE FROM ".WORKFLOW_LOG_TABLE);
		}
		return $num+1;
	}


#==============================================================================#

	/**
	 * Function: restoreFromBackup
	 *
	 * Description: This function restores a backup.
	 */

	function restoreFromBackup($filename,$restore_extra=0) {
		global $l_backup;

		$buff="";
		$fh = fopen ("$filename", "rb");

		if($fh) {
			while (!@feof ($fh)) {
				@set_time_limit(60);
				$line = "";
				$findline = false;

				while($findline == false && !@feof ($fh)) {
					$line .= @fgets($fh,4096);
					if(substr($line,-1) == "\n") {
						$findline = true;
					}
				}

				if(substr($line,0,1) != "#") {
					$buff.=$line;
					if((substr($buff,-2) == ";\n")||(substr($buff,-3) == ";\r\n")) {
						if(ereg(";\r?\n.?$",$buff)) {
							$buff = preg_replace("/\r?\n/"," ",$buff);
						}
						$buff=trim($buff);

						$ctbl=$this->isCreateQuery($buff);
						$itbl=$this->isInsertQuery($buff);
						if($itbl!="")
							$ctbl="";
						else if($ctbl!="")
							$itbl="";
						$upd=array();
						if(($ctbl!="")||($itbl!=""))  {
							if(strlen($buff)<$this->mysql_max_packet) {
								if((!$this->isFixed($ctbl.$itbl))||((strtolower($ctbl.$itbl)==strtolower(BACKUP_TABLE))&&($restore_extra))) {
									$clear_name=$this->fixTableName($ctbl.$itbl);
									if(trim($clear_name)!=""){
										$buff=str_replace($ctbl.$itbl,$clear_name,$buff);
										if(($ctbl!="") && (strtolower(substr($buff,0,6))=="create")) {
											if(defined("OBJECT_X_TABLE") && substr(strtolower($ctbl),0,10)!=strtolower(OBJECT_X_TABLE)) $this->getDiff($buff,$clear_name,$upd);
											$this->backup_db->query("DROP TABLE IF EXISTS $clear_name;");
											$this->backup_db->query($buff);
										}
										if(($itbl!="") && (strtolower(substr($buff,0,6))=="insert")){
											if(defined("OBJECT_X_TABLE") && substr(strtolower($itbl),0,10)==strtolower(OBJECT_X_TABLE)){
												if(eregi("VALUES[[:space:]]*\([[:space:]]*\'?0\'?[[:space:]]*,[[:space:]]*\'?0\'?[[:space:]]*,",$buff)) $this->dummy[]=$buff;
												else $this->backup_db->query($buff);
											}
											else $this->backup_db->query($buff);
										}

										foreach($upd as $k=>$v) {
											$this->backup_db->query($v);
										}
									}
								}
							}
							else {
								$this->setWarning($l_backup["query_is_too_big"],$this->mysql_max_packet);
							}
						}

						$buff="";
					}
				}
			}

		}
		else {
			$this->setError(sprintf($l_backup["can_not_open_file"],$filename));
			return false;
		}
		@fclose ($fh);
		unlink($filename);
		$tn=strtolower($ctbl.$itbl);

		if (isset($this->description["import"]["$tn"]) && $this->description["import"]["$tn"]) {
				$this->current_description = $this->description["import"]["$tn"];
		} else {
				$this->current_description = $l_backup["working"];
		}

		if($restore_extra)
			if(!$this->restoreFiles()) {
				return false;
			}
		return true;
	}

#==============================================================================#

	/**
	 * Function: removeBackup
	 *
	 * Description: This function removes a backup from the database.
	 */

	function removeBackup() {

		$updater=new we_updater();

		$this->backup_db->query("DROP TABLE IF EXISTS ".BACKUP_TABLE);

		//import dummys
		if(is_array($this->dummy)){
			foreach($this->dummy as $query){
				$this->backup_db->query($query);

			}
		}

		$updater->updateTables();
		if($this->handle_options["users"]) {
			$updater->updateUsers();
		}
		if($this->handle_options["customers"]){
			$updater->updateCustomers();
		}
		if(!$this->handle_options["temporary"]){
			$this->backup_db->query("DELETE FROM ".TEMPORARY_DOC_TABLE);
		}
		$updater->updateScheduler();
		$updater->updateNewsletter();
	}

#==============================================================================#

	/**
	 * Function: getDiff
	 *
	 * Description: This function checks for differences between the table
	 * structure of the current database and the table structure of the
	 * backup file.
	 */

	function getDiff(&$q,$tab,&$fupdate) {
		$fnames=array();
		$fields="";
		$parts=array();
		$sub_parts=array();
		$len=strlen($q);
		$br=0;
		$run=0;
		for($i=0;$i<$len;$i++) {
			if($q[$i]=="(") {
				$run=1;
				$br++;
			}
			else if($q[$i]==")")
				$br--;
			else if($br>0)
				$fields.=$q[$i];
			if($br==0 && $run)
				break;
		}
		$parts=explode(",",$fields);
		foreach($parts as $k=>$v) {
			$sub_parts=explode(" ",trim($v));
			if($sub_parts[0]!="" && $sub_parts[0]!="PRIMARY" && $sub_parts[0]!="UNIQUE" && $sub_parts[0]!="KEY") {
				array_push($fnames,strtolower($sub_parts[0]));
			}
		}

		$this->backup_db->query("SHOW TABLES LIKE '".$tab."';");
		if($this->backup_db->next_record()) {
			$this->backup_db->query("SHOW COLUMNS FROM ".$tab.";");
			while($this->backup_db->next_record()) {
				if(!in_array(strtolower($this->backup_db->f("Field")),$fnames)) {
					array_push($fupdate,"ALTER TABLE ".$tab." ADD ".$this->backup_db->f("Field")." ".$this->backup_db->f("Type")." DEFAULT '".$this->backup_db->f("Default")."'".($this->backup_db->f("Null")=="YES" ? " NOT NULL" :"").";");
				}
			}
		}
		return true;
	}

#==============================================================================#

	/**
	 * Function: isCreateQuery
	 *
	 * Description: This function returns whether the given query is a "CREATE"
	 * query or not.
	 */

	function isCreateQuery($q) {
		$m=array();
		if(preg_match("/CREATE[[:space:]]+TABLE[[:space:]]+([a-zA-Z0-9_-]+)/",$q,$m)) {
			return $m[1];
		}
		else
			return "";
	}

#==============================================================================#

	/**
	 * Function: fixTableNames
	 *
	 * Description: The function convert default table names to
	 * real table names
	 */

	function fixTableNames(&$arr) {
		foreach($arr as $key=>$val) {
			$name=$this->fixTableName($val);
			$arr[$key]=$name;
		}
		array_unique($arr);
	}

	/**
	 * Function: fixTableName
	 *
	 * Description: This function checks and returns the real name of a
	 * given default table name.
	 */

	function fixTableName($tabname) {
		$tabname=strtolower($tabname);

		if(substr($tabname,0,10)=="tblobject_" && defined("OBJECT_X_TABLE")) {
			return eregi_replace("tblobject_",OBJECT_X_TABLE,$tabname);
		}

		foreach($this->table_map as $k=>$v) {
			if($tabname==strtolower($k))	return $v;
		}

		return $tabname;
	}

	/**
	 * Function: getDefaultTableName
	 *
	 * Description: The function returns default name for given
	 * real table name
	 */
	function getDefaultTableName($tabname){

		$tabname=strtolower($tabname);
		if(defined("OBJECT_X_TABLE") &&  eregi(OBJECT_X_TABLE,$tabname)) {
			return eregi_replace(OBJECT_X_TABLE,"tblobject_",$tabname);
		}

		foreach($this->table_map as $k=>$v) {
			if($tabname==strtolower($v)) return $k;
		}

		return $tabname;

	}

	/**
	 * Function: isWeTable
	 *
	 * Description: The function checks if given  name
	 * is webEdition table name
	 */
	function isWeTable($tabname){
		if(in_array(strtolower($tabname),array_keys($this->table_map))) return true;
		if(defined("OBJECT_X_TABLE")){

			if(defined("TBL_PREFIX") && TBL_PREFIX!="") $object_x_table=eregi_replace(TBL_PREFIX,"",OBJECT_X_TABLE);
			else $object_x_table=OBJECT_X_TABLE;

		 	if(eregi($object_x_table,$tabname)) return true;
		}
		return false;
	}

	/**
	 * Function: rmTablePrefix
	 *
	 * Description: The function removes table prefix from table name
	 */

	function rmTablePrefix($tabname) {
		$len=strlen(TBL_PREFIX);
		if(substr($tabname,0,$len)==TBL_PREFIX) return substr_replace($tabname,"",0,$len);
	}

#==============================================================================#

	/**
	 * Function: isFixed
	 *
	 * Description: This function checks if a table name has its correct value.
	 */

	function isFixed($tab) {
		$table=strtolower($tab);
		$fixTable=array();
		$fixTable=$this->fixedTable;

		foreach($this->handle_options as $hok=>$hov){
			if(!$hov) $fixTable=array_merge($fixTable,$this->tables[$hok]);
		}

		if (in_array($table,$fixTable)){
			return true;
		}else{
			return false;
		}
	}

#==============================================================================#

	/**
	 * Function: isInsertQuery
	 *
	 * Description: This function returns whether the given query is a "INSERT"
	 * query or not.
	 */

	function isInsertQuery($q) {
		$m=array();
		if(preg_match("/INSERT[[:space:]]+INTO[[:space:]]+([a-zA-Z0-9_-]+)/",$q,$m))
			return $m[1];
		else
			return "";
	}

#==============================================================================#

	/**
	 * Function: setError
	 *
	 * Description: This function sets a value for an error.
	 */

	function setError($errtxt) {
		array_push($this->errors,$errtxt);
	}

#==============================================================================#

	/**
	 * Function: setWarning
	 *
	 * Description: This function sets a value for a warning.
	 */

	function setWarning($wartxt) {
		array_push($this->warnings,$wartxt);
	}

#==============================================================================#

	/**
	 * Function: getErrors
	 *
	 * Description: This function returns errors if any were set.
	 */

	function getErrors() {
		return $this->errors;
	}

#==============================================================================#

	/**
	 * Function: getWarnings
	 *
	 * Description: This function returns warnings if any were set.
	 */

	function getWarnings() {
		return $this->warnings;
	}
#==============================================================================#

	/**
	 * Function: arrayintersect
	 *
	 * Description:
	 */

	function arrayintersect($array1,$array2) {
		$ret=array();
		foreach($array1 as $k=>$v) {
			if(!is_array($v)) {
				if(in_array($v,$array2))
					array_push($ret,$v);
			}
		}
		return $ret;
	}

#==============================================================================#

	/**
	 * Function: arraydiff
	 *
	 * Description:
	 */

	function arraydiff($array1,$array2) {
		$ret=array();
		foreach($array1 as $k=>$v) {
			if(!is_array($v) && !in_array($v,$ret)) {
				if(!in_array($v,$array2))
					array_push($ret,$v);
			}
		}
		return $ret;
	}

#==============================================================================#

	/**
	 * Function: saveState
	 *
	 * Description:
	 */

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

		if($of=="") $of=md5(uniqid(time()));
		$fp = fopen($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp/"."$of", "wb");
		fputs($fp, $save);
		fclose($fp);
		return $of;
	}

#==============================================================================#

	/**
	 * Function: restoreState
	 *
	 * Description:
	 */

	function restoreState($temp_filename) {
		$_filename = fopen($_SERVER["DOCUMENT_ROOT"] . BACKUP_DIR . "tmp/" . $temp_filename, "rb");
		if ($_filename) {
			while (!feof($_filename)) {
				if (!isset($save)) {
					$save = fread($_filename, 4096);
				} else {
					$save .= fread($_filename, 4096);
				}
			}
			fclose($_filename);
			eval($save);
			return $temp_filename;
		} else {
			return 0;
		}
	}

#==============================================================================#

	/**
	 * Function: getDownloadFile
	 *
	 * Description: This function copies a backup file to the download directory
	 * and returns its filename plus location.
	 */

	function getDownloadFile() {
		$download_filename= "weBackup_".$_SESSION["user"]["Username"].".sql";
		if(copy($this->dumpfilename,$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."download/".$download_filename)) {
			$this->backup_db->query("INSERT INTO ".CLEAN_UP_TABLE."(Path,Date) Values ('".$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."download/".$download_filename."','".time()."')");
			return $download_filename;
		}
		else
			return "";
	}

	function clearOldTmp(){
		global $DB_WE;

		if(!is_writable($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp")){
			$this->setError(sprintf($GLOBALS["l_backup"]["cannot_save_tmpfile"],BACKUP_DIR));
			return -1;
		}

		$d = dir($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp");
		$co=-1;
		$limit=time();
		$limit=$limit-86400;
		while (false !== ($entry=$d->read())){
			if($entry!="." && $entry!=".." && $entry!="CVS" && !@is_dir($entry)){
			if(filemtime($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."/tmp/".$entry)<$limit){
				unlink($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."/tmp/".$entry);
			}
		}
		}
		$d->close();
	}

}
?>