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


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once(WE_CUSTOMER_MODULE_DIR."weCustomer.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");

	
	class weCustomerEI{
			
		//var $customer;
		//var $customer_fileds=array();
	
		//function weCustomerEI(){
		//	$this->customer=new weCustomer();
		//	$this->customer_fileds=$this->customer->getFieldsDbProperties();
		//}

		//option
		//  - offset
		//  - count
		//  - filename (path and name)
		//  - format
		//  - csv_		
		
		function exportCustomers($options=array()){
			$code="";
			if($options["format"]=="gxml") $code=weCustomerEI::exportXML($options);
			if($options["format"]=="csv") $code=weCustomerEI::exportCSV($options);
			// write to file
			if($code!=""){
				weCustomerEI::save2File($options["filename"],$code);
			}
		}
		
		function getDataset($type,$filename,$arrgs=array()){		
			if($type=="gxml"){
				return weCustomerEI::getXMLDataset($filename,$arrgs["dataset"]);
			}
			if($type=="csv"){
				return weCustomerEI::getCSVDataset($filename,$arrgs["delimiter"],$arrgs["enclose"],$arrgs["lineend"],$arrgs["fieldnames"]);
			}						
		}
		
		function save2File($filename,$code="",$flags="ab"){
				$fp=fopen($filename,$flags);
				if($fp){
					fwrite($fp,$code);
					fclose($fp);
					return true;
				}
				return false;
		}
		
		function getCustomersFieldset(){
			include_once(WE_CUSTOMER_MODULE_DIR."weCustomer.php");
			$customer=new weCustomer();
			return $customer->getFieldset();
		}
		

		function exportXML($options=array()){
			global $_language;
			
			if(isset($options["customers"]) && is_array($options["customers"])){
				
				$customer=new weCustomer();
				$fields=$customer->getFieldsDbProperties();
				
				if(isset($options["firstexec"]) && $options["firstexec"]==-999){
					$xml_out='<?xml version="1.0" encoding="'.$_language["charset"].'" standalone="yes" ?>'."\n";
					$xml_out.='<webEdition>'."\n";
				}
				else $xml_out="";
				
				foreach($options["customers"] as $cid){					
					if($cid){
						$customer_xml=new we_baseCollection("customer");
						$customer=new weCustomer($cid);
						if($customer->ID){
							foreach($fields as $k=>$v){
								if(!$customer->isProtected($k)){
									$value="";
									eval('$value=$customer->'.$k.';');
									if($value!="") $value=($options["cdata"] ? "<![CDATA[".$value."]]>" : htmlentities($value));
									$customer_xml->addChild(new we_baseElement($k,true,null,$value));					
								}
							}
						}
						$xml_out.=$customer_xml->getHtmlCode($customer_xml).we_htmlElement::htmlComment("webackup")."\n";
					}
				}
				return $xml_out;
			}
			return "";
		}
		
		/* Function creates new xml element. 
		* 
		* element - [name] - element name
		*				 [attributes] - atributes array in form arry["attribute_name"]=attribute_value 
		*				 [content] - if array childs otherwise some content
		*
		*/
		function buildXMLElement($elements){
							$out="";
							$content="";
							foreach($elements as $element){
								if(is_array($element["content"])){									
									$content=weCustomerEI::buildXMLElement($element["content"]);
								}
								else $content=$element["content"];
								$element=new we_baseElement($element["name"],true,$element["attributes"],$content);
								$out.=$element->getHtmlCode($element);
							}
							return $out;
		}
				
		
		function getXMLDataset($filename,$dataset){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_parser.inc.php");
			$xp = new XML_Parser($_SERVER["DOCUMENT_ROOT"].$filename);
			$nodeSet = $xp->evaluate($xp->root.'/'.$dataset.'[1]/child::*');
			$nodes = array();
			$attrs = array();

			foreach ($nodeSet as $node) {
				$nodeName = $xp->nodeName($node);				
				$nodeattribs=array();				
				if ($xp->hasAttributes($node)) {
					$attrs = $attrs + array("@n:"=>$l_customer["none"]);
					$attributes = $xp->getAttributes($node);
					foreach ($attributes as $name=>$value) {
						$nodeattribs[$name] = $value;						
					}
				}
				$nodes[$nodeName]=$nodeattribs;
			}			
			return $nodes;						
		}	
	
		function exportCSV($options=array()){
			global $l_customer;
			
			if(isset($options["customers"]) && is_array($options["customers"])){
				$customer_csv=array();
				$customer=new weCustomer();
				$fields=$customer->getFieldsDbProperties();
				foreach($options["customers"] as $cid){
					if($cid){
						$customer=new weCustomer($cid);
						if($customer->ID){
							$customer_csv[$cid]=array();
							foreach($fields as $k=>$v){								
								if(!$customer->isProtected($k)){
									$value="";
									eval('$value=$customer->'.$k.';');
									$customer_csv[$cid][]=$value;					
								}
							}
						}
					}
				}
				
				$field_names=array();
				foreach($fields as $k=>$v){
						if(!$customer->isProtected($k)) $field_names[]=$k;
				}
				
				$csv_out="";
				$enclose=trim($options["csv_enclose"]);
				$lineend=trim($options["csv_lineend"]);
				$delimiter=$enclose.($options["csv_delimiter"]=="\\t" ? "\t" : trim($options["csv_delimiter"])).$enclose;
				
				if($options["csv_fieldnames"]){
					$csv_out.=$enclose.implode($delimiter,$field_names).$enclose.($lineend==$l_customer["unix"] ? "\n" : ($lineend==$l_customer["mac"] ? "\r" : "\r\n"));
				}
				
				foreach($customer_csv as $ck=>$cv){
						$csv_out.=$enclose.implode($delimiter,$cv).$enclose.($lineend==$l_customer["unix"] ? "\n" : ($lineend==$l_customer["mac"] ? "\r" : "\r\n"));	
				}
				
				return $csv_out;
				
				//return weCustomerEI::buildCSVRow($customer_csv,$options);
			}
			return "";	
		}
		
		
		function buildCSVRow($data,$options){
				$csv_out="";
				$enclose=trim($options["csv_enclose"]);
				$lineend=trim($options["csv_lineend"]);
				$delimiter=$enclose.($options["csv_delimiter"]=="\\t" ? "\t" : trim($options["csv_delimiter"])).$enclose;
				
				if($options["csv_fieldnames"]){
					$csv_out.=$enclose.implode($delimiter,$field_names).$enclose.($lineend==$l_customer["unix"] ? "\n" : ($lineend==$l_customer["mac"] ? "\r" : "\r\n"));
				}
				
				foreach($customer_csv as $ck=>$cv){
						$csv_out.=$enclose.implode($delimiter,$cv).$enclose.($lineend==$l_customer["unix"] ? "\n" : ($lineend==$l_customer["mac"] ? "\r" : "\r\n"));	
				}

				return $csv_out;
		}
		
		
		function getCSVDataset($filename,$delimiter,$enclose,$lineend,$fieldnames){
			global $l_customer;		
			if($delimiter=="\\t") $delimiter="\t";
			$csvFile=$_SERVER["DOCUMENT_ROOT"].$filename;
			$nodes = array();
					
			if (file_exists($csvFile) && is_readable($csvFile)) {
				$recs = array();

				if ($lineend=="mac") {
					weCustomerEI::massReplace("\r", "\n", $csvFile);
				}


				$cp = new CSVImport;
				$cp->setFile($csvFile);
				$cp->setDelim($delimiter);
				$cp->setEnclosure(($enclose=="")? "\"" : $enclose);
				$cp->parseCSV();
				$num = count($cp->FieldNames);
				$recs = array();
				for ($c=0; $c < $num; $c++) {
					$recs[$c] = $cp->CSVFieldName($c);
				}
				for ($i=0; $i < count($recs); $i++) {
						if ($fieldnames) $nodes[$recs[$i]] = array();
						else $nodes[$l_customer["record_field"]." ".($i+1)] = array();
				}
			}
			
			return $nodes;						
		}
		
		function massReplace($string1, $string2, $file) {
				$fp = fopen($file,"r");
				$contents = fread($fp, filesize($file));
				fclose($fp);
				$replacement = preg_replace("/$string1/i", $string2, $contents);
				$fp = fopen($file,"w");
				fputs($fp, $replacement);
				fclose($fp);
		}
		
		function getUniqueId() {
			// md5 encrypted hash with the start value microtime(). The function
			// uniqid() prevents from simultanious access, within a microsecond.
			return md5(uniqid(microtime()));
		}
		
		function prepareImport($options) {
				global $l_customer,$_language;

				$ret=array();
				$ret["tmp_dir"]="";
				$ret["file_count"]="";
									
				$type=$options["type"];
				$filename=$options["filename"];

				if ($type == "gxml") {
						$dataset=$options["dataset"];
						$xml_from=$options["xml_from"];
						$xml_to=$options["xml_to"];
					
												
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_parser.inc.php");
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_splitFile.inc.php");
						
						$parse = new XML_SplitFile($_SERVER["DOCUMENT_ROOT"].$filename);
						$parse->splitFile("*/".$dataset, $xml_from, $xml_to);
												
						$ret["tmp_dir"]=str_replace(TMP_DIR."/","",$parse->path);
						$ret["file_count"]=$parse->fileId;
						
				}
				else if ($type == "csv") {
						$csv_delimiter=$options["csv_delimiter"];
						$csv_enclose=$options["csv_enclose"];						
						$csv_fields=$options["csv_fieldnames"];
						$exim=$options["exim"];

						$csvFile = $_SERVER["DOCUMENT_ROOT"].$filename;
						
						if (file_exists($csvFile) && is_readable($csvFile)) {
							
							$row = 0;
							$data=array();
							$names=array();			
							$rows=array();
							
							// create temp dir							
							$unique=weCustomerEI::getUniqueId();
							$path=TMP_DIR."/".$unique;
							
							createLocalFolder($path);
							$path.="/";
							
							$fcount=0;
							$rootnode=array(
								"name"=>"customer",
								"attributes"=>null,
								"content"=>array()
							);	

							$csv=new weCustomerCSVImport();
							
							$csv->setDelim($csv_delimiter);
							$csv->setEnclosure($csv_enclose);
							$csv->setHeader($csv_fields);
							$csv->setFile($csvFile);														
							$csv->parseCSV();							
							$data = $csv->CSVFetchRow();
							while ($data!=FALSE){
									$value=array();
									foreach($data as $kdat=>$vdat){
											$value[]=array(
												"name"=>($csv_fields ? $csv->FieldNames[$kdat] : (str_replace(" ","",$l_customer["record_field"]).($kdat+1))),
												"attributes"=>null,
												"content"=>'<![CDATA[' . $vdat . ']]>'
											);
									}
									$rootnode["content"]=$value;
									$code='<?xml version="1.0" encoding="'.$_language["charset"].'" standalone="yes" ?>'."\n";														
									$code.=weCustomerEI::buildXMLElement(array($rootnode));
									weCustomerEI::save2File($path."temp_$fcount.xml",$code,"wb");
									$fcount++;

									$data = $csv->CSVFetchRow();
							}
							$ret["tmp_dir"]=$unique;
							$ret["file_count"]=$fcount;
						}
					}
					
					return $ret;

			}
		
			function importCustomers($options=array()){
					global $l_customer;
					
					$ret=false;
					$xmlfile=isset($options["xmlfile"]) ? $options["xmlfile"] : "";
					$field_mappings=isset($options["field_mappings"]) ? $options["field_mappings"] : array();
					$attrib_mappings=isset($options["attrib_mappings"]) ? $options["attrib_mappings"] : array();
					
					$same=isset($options["same"]) ? $options["same"] : "";
					$logfile=isset($options["logfile"]) ? $options["logfile"] : "";
					
					
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_parser.inc.php");
					
					$db=new DB_WE();
					
					$customer=new weCustomer();					
					$xp = new XML_Parser($xmlfile);

					$fields = array_flip($field_mappings);					
					$nodeSet = $xp->evaluate($xp->root.'/*');
					foreach($nodeSet as $node){
						$node_name=$xp->nodeName($node);
						$node_value=$xp->getData($node);
						if(isset($fields[$node_name])) eval('$customer->'.$fields[$node_name].'=\''.addslashes($node_value).'\';');
					}

					$existid=f("SELECT ID FROM ".CUSTOMER_TABLE." WHERE Username='".$customer->Username."' AND ID<>'".$customer->ID."'","ID",$db);
					if($existid){
						if($same=="rename"){
							$exists=true;
							$count=0;
							$oldname=$customer->Username;
							while($exists){
								$count++;
								$new_name=$customer->Username.$count;
								$exists=f("SELECT ID FROM ".CUSTOMER_TABLE." WHERE Username='".$new_name."' AND ID<>'".$customer->ID."'","ID",$db);
							}
							$customer->Username=$new_name;
							$customer->save();
							weCustomerEI::save2File($logfile,sprintf($l_customer["rename_customer"],$oldname,$customer->Username)."\n");
							$ret=true;
						}
						else if($same=="overwrite"){
							$oldcustomer=new weCustomer($existid);
							$oldcustomer->delete();
							$customer->save();
							weCustomerEI::save2File($logfile,sprintf($l_customer["overwrite_customer"],$customer->Username)."\n");
							$ret=true;
						}
						else if($same=="skip"){
							weCustomerEI::save2File($logfile,sprintf($l_customer["skip_customer"],$customer->Username)."\n");
						}
					}
					else{
						$ret=true;
						$customer->save();
					}
					
					unlink($xmlfile);						
					return $ret;

		}		
		
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/csv.inc.php");

class weCustomerCSVImport extends CSVImport{
	
	var $hasHeader=0;
	
	function setHeader($hasheader){
		$this->hasHeader=$hasheader;
	}
	
	function parseCSV() {
		if ($this->CSVData) {
			$akt_line  = 0;
			$akt_field = 0;
			$akt_field_value = "";
			$last_char = "";
			$quote = 0;
			$field_input = 0;
			
			if($this->hasHeader) $head_complete = 0;
			else $head_complete = 1;

			$end_cc = strlen($this->CSVData);

			for($cc = 0; $cc < $end_cc; $cc++) {
				$akt_char = substr($this->CSVData,$cc,1);

				if (($akt_char == $this->Enclosure) && ($last_char != "\\")) {
					$quote = !$quote;
					$akt_char = "";
				}

				if (!$quote) {
					if ($akt_char == $this->FieldDelim) {
						$field_input = !$field_input;
						$akt_char = "";
						$akt_field++;
						$akt_field_value = "";
					}
					else if (($akt_char == "\\") && $field_input) {
						$field_input++;
						$quote++;
					}
					else if ($akt_char == $this->Enclosure) {
						$quote--;

						if ($field_input) $field_input--;
						else $field_input++;
					}
					else if ($akt_char == "\n") {
						if ($head_complete && (($akt_field+1) > $this->CSVNumFields())) {
							$this->CSVError[] = "Fehler in <b>Zeile " . ($akt_line + 2) . "</b>";
						}
						$akt_line++;
						$akt_field = 0;
						if (!$head_complete) $akt_line = 0;
						$head_complete = 1;
						$akt_char = "";
						$akt_field_value = "";
					}
				}

				$last_char = $akt_char;
				if ($akt_char == "\\") $akt_char = "";				
				$akt_field_value .= $akt_char;

				if ($head_complete) {
					$this->Fields[$akt_line][$akt_field] = trim($akt_field_value);
				}
				else {
					$this->FieldNames[$akt_field] = trim($akt_field_value);					
				}
			}

			if (!$akt_field) {
				unset($this->Fields[$akt_line]);
			}

			$this->fetchCursor = 0;
	
		}
		else {
			$this->CSVError[] = "CSV data empty.";
			return FALSE;
		}
	}

	function CSVFetchRow() {
		if ($this->fetchCursor < $this->CSVNumRows()) {
			$r = $this->Fields[$this->fetchCursor];
			$this->fetchCursor++;
			return $r;
		}
		else {
			$this->CSVError[] = "No more data sets.";
			return FALSE;
		}
	}
		
}


?>