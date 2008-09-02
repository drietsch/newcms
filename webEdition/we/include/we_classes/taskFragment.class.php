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


define("FRAGMENT_LOCATION",$_SERVER["DOCUMENT_ROOT"]."/webEdition/fragments/");

/**
* Class taskFragment()
*
* This class offers methods to split tasks in more than one fragment.
* It is needed if you need to do a lot of work, which takes time
* longer than the timeout of some servers
*/
class  taskFragment{
	
	/**
	 * Number of all tasks.
	 * @var        int
	 */
	var $numberOfTasks = 1;
	/**
	 * Number of current tasks.
	 * @var        int
	 */
	var $currentTask = 0;
	/**
	 * Number of tasks per fragment.
	 * @var        int
	 */
	var $taskPerFragment = 1;
	/**
	 * Array of the data.
	 * @var        array
	 */
	var $alldata = array();
	/**
	 * Data for the current task.
	 * @var        mixed
	 */
	var $data = null;
	/**
	 * Name for the whole fragment action. 
	 * This variable is used for a reference, so it must be unique
	 * @var        string
	 */
	var $name;
	/**
	 * Pause for each task in ms. 
	 * @var        int
	 */
	var $pause;
		
	var $initdata = null;
	/**
	 * init Data. 
	 * @var        array
	 */

	/**
	 * This is the constructor of the class. Everything will be done here.
	 *
	 * @param      string $name
	 * @param      int $taskPerFragment
	 * @param      array $bodyAttributes
	 * @param      int $pause
	 * @param      array $initdata
	 */
	function taskFragment($name,$taskPerFragment,$pause=1,$bodyAttributes="",$initdata=""){
		$this->name = $name;
		$this->taskPerFragment = $taskPerFragment;
		$this->pause = $pause;
		if($initdata){
			$this->initdata = $initdata;
		}
		$filename = FRAGMENT_LOCATION.$this->name;
		$this->currentTask = isset($_GET["fr_".$this->name."_ct"]) ? $_GET["fr_".$this->name."_ct"] : 0;
		if(file_exists($filename) && $this->currentTask){
			$fp = fopen($filename,"rb");
			$ser = fread($fp,filesize($filename));
			if (!$ser) {
				exit ("Could not read: ".$filename);	
			}
			fclose($fp);
			$this->alldata = unserialize($ser);
		}else{
			$this->taskPerFragment = $taskPerFragment;
			$this->init();
			$ser = serialize($this->alldata);
			$fp = fopen($filename,"wb");
			if (!fwrite($fp,$ser)) {
				exit("Could not write: ".$filename);	
			}
			fclose($fp);
		}
		$this->numberOfTasks = sizeof($this->alldata);
		$this->printHeader();
		$this->printBodyTag($bodyAttributes);
		for ($i = 0; $i < $this->taskPerFragment; $i++) {
			if($i>0) $this->currentTask ++; // before: currentTask was incremented with $i;
			if ($this->currentTask == $this->numberOfTasks) {
				unlink($filename);
				$this->finish();
				break;
			}else{
				$this->data = $this->alldata[$this->currentTask];
				$this->doTask();
			}
		}
		$this->printFooter();
	}
	
	/**
	 * Prints the body tag.
	 *
	 * @param      array $attributes
	 */
	function printBodyTag($attributes=""){
		$nextTask = $this->currentTask + $this->taskPerFragment;
		$attr = "";
		if ($attributes) {
			foreach($attributes as $k=>$v){
				$attr .= " $k=\"$v\"";
			}
		}
		$tail = "";
		foreach ($_GET as $i=>$v) {
			if (is_array($v)) {
				foreach($v as $k => $av){
					if(get_magic_quotes_gpc() == 1){
						$av = stripslashes($av);	
					}
					$tail .= "&".rawurlencode($i)."[".rawurlencode($k)."]=".rawurlencode($av);
				}
			} else {
				if ($i != "fr_".rawurlencode($this->name)."_ct") {
					if(get_magic_quotes_gpc() == 1){
						$v = stripslashes($v);	
					}
					$tail .= "&".rawurlencode($i)."=".rawurlencode($v);
				}
			}
		}
		foreach ($_POST as $i=>$v) {
			if (is_array($v)) {
				foreach($v as $k => $av){
					if(get_magic_quotes_gpc() == 1){
						$av = stripslashes($av);	
					}
					$tail .= "&".$i."[".rawurlencode($k)."]=".rawurlencode($av);
				}
			} else {
				if ($i != "fr_".rawurlencode($this->name)."_ct") {
					if(get_magic_quotes_gpc() == 1){
						$v = stripslashes($v);	
					}
					$tail .= "&".rawurlencode($i)."=".rawurlencode($v);
				}
			}
		}
		
		$onload = "document.location='".$_SERVER["PHP_SELF"]."?fr_".rawurlencode($this->name)."_ct=".($nextTask).$tail."';";
		
		if ($this->pause) {
			$onload = "setTimeout('".addslashes($onload)."',".$this->pause.");";
		}
		print "<body".
			$attr.
			(($nextTask <= $this->numberOfTasks) ? 
				(' onload="'.$onload.'"') : 
				"").
			">";
	}
	/**
	 * Prints a javascript for reloading next task.
	 *
	 * @param      array $attributes
	 */
	function printJSReload(){
		$nextTask = $this->currentTask + $this->taskPerFragment;
		$tail = "";
		foreach ($_GET as $i=>$v) {
			if (is_array($v)) {
				foreach($v as $k => $av){
					if(get_magic_quotes_gpc() == 1){
						$av = stripslashes($av);	
					}
					$tail .= "&".rawurlencode($i)."[".rawurlencode($k)."]=".rawurlencode($av);
				}
			} else {
				if ($i != "fr_".rawurlencode($this->name)."_ct") {
					if(get_magic_quotes_gpc() == 1){
						$v = stripslashes($v);	
					}
					$tail .= "&".rawurlencode($i)."=".rawurlencode($v);
				}
			}
		}
		foreach ($_POST as $i=>$v) {
			if (is_array($v)) {
				foreach($v as $k => $av){
					if(get_magic_quotes_gpc() == 1){
						$av = stripslashes($av);	
					}
					$tail .= "&".$i."[".rawurlencode($k)."]=".rawurlencode($av);
				}
			} else {
				if ($i != "fr_".rawurlencode($this->name)."_ct") {
					if(get_magic_quotes_gpc() == 1){
						$v = stripslashes($v);	
					}
					$tail .= "&".rawurlencode($i)."=".rawurlencode($v);
				}
			}
		}
		
		$onload = "document.location='".$_SERVER["PHP_SELF"]."?fr_".rawurlencode($this->name)."_ct=".($nextTask).$tail."';";
		
		if ($this->pause) {
			$onload = "setTimeout('".addslashes($onload)."',".$this->pause.");";
		}
		if(($nextTask <= $this->numberOfTasks)){
			print '<script language="JavaScript" type="text/javascript">'.$onload.'</script>';
		}
	}
	/**
	 * Prints the Footer.
	 *
	 */
	function printFooter(){
		print "</body>\n</html>\n";
	}
	
	// overwrite the following functions
	
	/**
	 * Prints the header.
	 * This Function should be overwritten
	 *
	 */
	function printHeader(){
		print "<html>\n<head></head>\n";
	}
	/**
	 * Overwrite this function to initialize the array taskFragment::alldata.
	 *
	 */
	function init(){
		$this->alldata = $this->initdata;
	}
	
	/**
	 * Overwrite this function to do the work for each task.
	 *
	 */
	function doTask(){}
	
	/**
	 * Overwrite this function to do the work when everything is finished.
	 *
	 */
	function finish(){}
	
}

/*
  //EXAMPLE:

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");

class myFrag extends taskFragment{
	
	function init(){
		$this->alldata = array(
							array("color"=>"red","size"=>30),
							array("color"=>"green","size"=>10),
							array("color"=>"blue","size"=>20),
							array("color"=>"yellow","size"=>50)
							);
	}
	
	function doTask(){
		$id = $this->data;
		print "Color:".$this->data["color"]."<br>";
		print "Size:".$this->data["size"]."<br><br>";
	}
	
	function finish(){
		print "FINISHED!";	
	}
	
	function printHeader(){
		print "<html><head><title>myFragment</title></head>";	
	}
}

$fr = new myFrag("holeg",1,800,array("bgcolor"=>"silver"));


*/

?>