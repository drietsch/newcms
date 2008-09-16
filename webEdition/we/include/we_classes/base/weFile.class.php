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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");

class weFile{

	function load($filename,$flags="rb",$rsize=8192){
			if($filename=="") return false;
			if(!weFile::hasURL($filename)){
				if(!is_readable($filename)){
					return false;}
			}
			$buffer="";
			$fp=@fopen($filename,$flags);
			if($fp){
				do {
   					$data = fread($fp,$rsize);
   					if (strlen($data) == 0) break;
   					$buffer .= $data;
				} while (true);
				fclose($fp);
				return $buffer;
			}
			else return false;
	}

	function loadLine($filename,$offset=0,$rsize=8192,$iscompressed=0){

			if($filename=='') return false;
			if(weFile::hasURL($filename)) return false;
			if(!is_readable($filename)) return false;

			if($iscompressed==0){
				$open = 'fopen';
				$seek = 'fseek';
				$tell = 'ftell';
				$read = 'fgets';
				$close = 'fclose';

			} else {
				$open = 'gzopen';
				$seek = 'gzseek';
				$tell = 'gztell';
				$read = 'gzgets';
				$close = 'gzclose';

			}

			$buffer='';
			$fp=$open($filename,'rb');
			if($fp){
				if($seek($fp,$offset,SEEK_SET)==0){
   					$buffer = $read($fp,$rsize);
   					$close($fp);
					return $buffer;
				}
				else{
					$close($fp);
					return false;
				}
			}
			else return false;
	}

	function loadPart($filename,$offset=0,$rsize=8192,$iscompressed=0){

			if($filename=='') return false;
			if(weFile::hasURL($filename)) return false;
			if(!is_readable($filename)) return false;

			if($iscompressed==0){
				$open = 'fopen';
				$seek = 'fseek';
				$tell = 'ftell';
				$read = 'fread';
				$close = 'fclose';

			} else {
				$open = 'gzopen';
				$seek = 'gzseek';
				$tell = 'gztell';
				$read = 'gzread';
				$close = 'gzclose';

			}

			$buffer='';
			$fp=$open($filename,'rb');
			if($fp){
				if($seek($fp,$offset,SEEK_SET)==0){
   					$buffer = $read($fp,$rsize);
   					$close($fp);
					return $buffer;
				}
				else{
					$close($fp);
					return false;
				}
			}
			else return false;
	}


	function save($filename,$content,$flags="wb",$create_path=false){
			if($filename=="") return false;
			if(weFile::hasURL($filename)) return false;
			if(file_exists($filename)){
				if(!is_writable($filename)) return false;
			}
			else{
				if($create_path) {
					if(!weFile::mkpath(dirname($filename))) {
						return false;
					}
				}
				if(!is_writable(dirname($filename))) return false;
			}
			$written=0;

			$fp=@fopen($filename,$flags);
			if($fp){
				$written=fwrite($fp,$content);
				@fclose($fp);
				return $written;
			}
			return false;
	}


	function saveTemp($content,$filename="",$flags="wb"){
			if($filename=="") $filename=weFile::getUniqueId();
			$filename = TMP_DIR."/".$filename;
			if(weFile::save($filename,$content)) return $filename;
			else return false;
	}

	function delete($filename){
		if($filename=="") return false;
		if(!weFile::hasURL($filename)){
			if(is_writable($filename)){
				if(is_dir($filename)){
					return @rmdir($filename);
				}
				else{
					return @unlink($filename);
				}
			}
			else{
				return false;
			}
		}
		return false;
	}


	function hasURL($filename){
		if((strtolower(substr($filename,0,4))=="http") || (strtolower(substr($filename,0,4))=="ftp")) return true;
		else return false;
	}

	function getUniqueId($md5=true) {
		// md5 encrypted hash with the start value microtime(). The function
		// uniqid() prevents from simultanious access, within a microsecond.
		if($md5) return md5(uniqid(microtime()));
		else return uniqid(microtime());
	}


	/**
	 * Function: splitFile
	 *
	 * Description: This function splits a file.
	 */

	function splitFile($filename,$path,$pattern="",$split_size=0,$marker="") {

		if($pattern=="") $pattern=basename($filename)."%s";
		$buff = "";
		$filename_tmp="";
		$fh = fopen ($filename, "rb");
		$num=-1;
		$open_new=true;
		$fsize=0;

		$marker_size=strlen($marker);

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
					$filename_tmp=sprintf($path.$pattern,$num);
					$fh_temp=fopen($filename_tmp,"wb");
					$open_new=false;
				}

				if($fh_temp) {
						$buff.=$line;
						$write=false;

						//print substr($buff,(0-($marker_size+1)))."<br>\n";

						if($marker_size){
							if((substr($buff,(0-($marker_size+1)))==$marker."\n") || (substr($buff,(0-($marker_size+2)))==$marker."\r\n")) $write=true;
							else  $write=false;
						}
						else	$write=true;

						if($write) {
							//print "WRITE<br>\n";
							$fsize+=strlen($buff);
							fwrite($fh_temp,$buff);
							if(($split_size && $fsize>$split_size) || ($marker_size)) {
								$open_new=true;
								@fclose ($fh_temp);
								$fsize=0;
							}
							$buff="";
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
			if($buff) fwrite($fh_temp,$buff);
			@fclose ($fh_temp);
		}
		@fclose ($fh);

		return $num+1;
	}

	function mkpath($path){
		$path=str_replace("\\","/",$path);
		if(weFile::hasURL($path)) return false;
		if($path!=""){
			return createLocalFolderByPath($path);
		}
		return false;
	}

	function hasGzip(){
		return function_exists("gzopen");
	}

	function hasZip(){
		return function_exists("zip_open");
	}

	function hasBzip(){
		return function_exists("bzopen");
	}

	function hasCompression($comp){
		if($comp=="gzip") return weFile::hasGzip();
		if($comp=="zip") return weFile::hasZip();
		if($comp=="bzip") return weFile::hasBzip();
		return false;
	}

	function getComPrefix($compression){
		if($compression=="gzip") return "gz";
		if($compression=="zip") return "zip_";
		if($compression=="bzip") return "bz";
		return "f";
	}

	function getZExtension($compression){
		if($compression=="gzip") return "gz";
		if($compression=="zip") return "zip";
		if($compression=="bzip") return "bz";
	}

	function getCompression($filename){
		$compressions=array("gzip","zip","bzip");
		foreach($compressions as $val){
   			if(eregi(".".weFile::getZExtension($val),basename($filename))) return $val;
		}
		return "none";

	}

	function compress($file,$compression="gzip",$destination="",$remove=true,$writemode="wb"){

		if(!weFile::hasCompression($compression)) return false;
		if($destination=="") $destination=$file;
		$prefix=weFile::getComPrefix($compression);
		$open=$prefix."open";
		$write=$prefix."write";
		$close=$prefix."close";

		$fp=@fopen($file,"rb");
		if($fp){
			$zfile=$destination.".gz";
			$gzfp=$open($zfile,$writemode);
			if($gzfp){
				do {
   					$data = fread($fp,8192);
   					$_data_size = strlen($data);
   					if ($_data_size == 0) break;
   					$_written = $write($gzfp,$data);
   					if($_data_size!=$_written) {
   						return false;
   					}
				} while (true);
				$close($gzfp);
			}
			else{
				fclose($fp);
				return false;
			}
			fclose($fp);
		}
		else{
				return false;
		}
		if($remove) @unlink($file);
		return $zfile;
	}

	function decompress($gzfile,$remove=true){
		$gzfp=@gzopen($gzfile,"rb");
		if($gzfp){
			$file=str_replace(".gz","",$gzfile);
			if($file==$gzfile) $file=$gzfile."xml";
			$fp=@fopen($file,"wb");
			if($fp){
				do {
   					$data = gzread($gzfp,8192);
   					if (strlen($data) == 0) break;
   					fwrite($fp,$data);
				} while (true);
				fclose($fp);
			}
			else{
				gzclose($gzfp);
				return false;
			}
			gzclose($gzfp);
		}
		else{
				return false;
		}
		if($remove) @unlink($gzfile);
		return $file;
	}

	function isCompressed($file,$offset=0){
		$fh = @fopen($file,'rb');
		if($fh){
			if(fseek($fh,$offset,SEEK_SET)==0){
				// according to rfc1952 the first two bytes identify the format
				$_id1 = fgets($fh,2);
				$_id2 = fgets($fh,2);
				if((ord($_id1) == 31) && (ord($_id2) == 139)) {
					return 1;
				}
			}
			fclose($fh);
		}
		return 0;

	}


}


?>