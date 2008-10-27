<?php

/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * static class for various common filesystem operations
 * this is a merge of the old weFile class and the old we_live_tools.inc.php Script of webEdition 5.1.x and older
 *
 * @todo check if needed and if, then complete it and DON'T use old stuff like DB and other
 * */


class we_util_File
{

	public static function load($filename, $flags = "rb", $rsize = 8192)
	{
		if ($filename == "")
			return false;
		if (!self::hasURL($filename)) {
			if (!is_readable($filename)) {
				return false;
			}
		}
		$buffer = "";
		$fp = @fopen($filename, $flags);
		if ($fp) {
			do {
				$data = fread($fp, $rsize);
				if (strlen($data) == 0)
					break;
				$buffer .= $data;
			} while (true);
			fclose($fp);
			return $buffer;
		} else
			return false;
	}

	public static function loadLine($filename, $offset = 0, $rsize = 8192, $iscompressed = 0)
	{
		
		if ($filename == '')
			return false;
		if (self::hasURL($filename))
			return false;
		if (!is_readable($filename))
			return false;
		
		if ($iscompressed == 0) {
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
		
		$buffer = '';
		$fp = $open($filename, 'rb');
		if ($fp) {
			if ($seek($fp, $offset, SEEK_SET) == 0) {
				$buffer = $read($fp, $rsize);
				$close($fp);
				return $buffer;
			} else {
				$close($fp);
				return false;
			}
		} else
			return false;
	}

	public static function loadPart($filename, $offset = 0, $rsize = 8192, $iscompressed = 0)
	{
		
		if ($filename == '')
			return false;
		if (self::hasURL($filename))
			return false;
		if (!is_readable($filename))
			return false;
		
		if ($iscompressed == 0) {
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
		
		$buffer = '';
		$fp = $open($filename, 'rb');
		if ($fp) {
			if ($seek($fp, $offset, SEEK_SET) == 0) {
				$buffer = $read($fp, $rsize);
				$close($fp);
				return $buffer;
			} else {
				$close($fp);
				return false;
			}
		} else
			return false;
	}

	public static function save($filename, $content, $flags = "wb", $create_path = false)
	{
		if ($filename == "")
			return false;
		if (self::hasURL($filename))
			return false;
		if (file_exists($filename)) {
			if (!is_writable($filename))
				return false;
		} else {
			if ($create_path) {
				if (!self::mkpath(dirname($filename))) {
					return false;
				}
			}
			if (!is_writable(dirname($filename)))
				return false;
		}
		$written = 0;
		
		$fp = @fopen($filename, $flags);
		if ($fp) {
			$written = fwrite($fp, $content);
			@fclose($fp);
			return $written;
		}
		return false;
	}

	public static function saveTemp($content, $filename = "", $flags = "wb")
	{
		if ($filename == "")
			$filename = self::getUniqueId();
		$filename = TMP_DIR . "/" . $filename;
		if (self::save($filename, $content))
			return $filename;
		else
			return false;
	}

	public static function delete($filename)
	{
		if ($filename == "")
			return false;
		if (!self::hasURL($filename)) {
			if (is_writable($filename)) {
				if (is_dir($filename)) {
					return @rmdir($filename);
				} else {
					return @unlink($filename);
				}
			} else {
				return false;
			}
		}
		return false;
	}

	public static function hasURL($filename)
	{
		if ((strtolower(substr($filename, 0, 4)) == "http") || (strtolower(substr($filename, 0, 4)) == "ftp"))
			return true;
		else
			return false;
	}

	public static function getUniqueId($md5 = true)
	{
		// md5 encrypted hash with the start value microtime(). The function
		// uniqid() prevents from simultanious access, within a microsecond.
		if ($md5)
			return md5(uniqid(microtime()));
		else
			return uniqid(microtime());
	}

	/**
	 * split a file into various parts of a predefined size
	 */
	public static function splitFile($filename, $path, $pattern = "", $split_size = 0, $marker = "")
	{
		
		if ($pattern == "")
			$pattern = basename($filename) . "%s";
		$buff = "";
		$filename_tmp = "";
		$fh = fopen($filename, "rb");
		$num = -1;
		$open_new = true;
		$fsize = 0;
		
		$marker_size = strlen($marker);
		
		if ($fh) {
			while (!@feof($fh)) {
				@set_time_limit(60);
				$line = "";
				$findline = false;
				
				while ($findline == false && !@feof($fh)) {
					$line .= @fgets($fh, 4096);
					if (substr($line, -1) == "\n") {
						$findline = true;
					}
				}
				
				if ($open_new) {
					$num++;
					$filename_tmp = sprintf($path . $pattern, $num);
					$fh_temp = fopen($filename_tmp, "wb");
					$open_new = false;
				}
				
				if ($fh_temp) {
					$buff .= $line;
					$write = false;
					
					//print substr($buff,(0-($marker_size+1)))."<br>\n";
					

					if ($marker_size) {
						if ((substr($buff, (0 - ($marker_size + 1))) == $marker . "\n") || (substr($buff, (0 - ($marker_size + 2))) == $marker . "\r\n"))
							$write = true;
						else
							$write = false;
					} else
						$write = true;
					
					if ($write) {
						//print "WRITE<br>\n";
						$fsize += strlen($buff);
						fwrite($fh_temp, $buff);
						if (($split_size && $fsize > $split_size) || ($marker_size)) {
							$open_new = true;
							@fclose($fh_temp);
							$fsize = 0;
						}
						$buff = "";
					}
				} else {
					return -1;
				}
			}
		} else {
			return -1;
		}
		if ($fh_temp) {
			if ($buff)
				fwrite($fh_temp, $buff);
			@fclose($fh_temp);
		}
		@fclose($fh);
		
		return $num + 1;
	}

	public static function mkpath($path)
	{
		$path = str_replace("\\", "/", $path);
		if (self::hasURL($path))
			return false;
		if ($path != "") {
			return createLocalFolderByPath($path);
		}
		return false;
	}

	public static function hasGzip()
	{
		return function_exists("gzopen");
	}

	public static function hasZip()
	{
		return function_exists("zip_open");
	}

	public static function hasBzip()
	{
		return function_exists("bzopen");
	}

	public static function hasCompression($comp)
	{
		if ($comp == "gzip")
			return self::hasGzip();
		if ($comp == "zip")
			return self::hasZip();
		if ($comp == "bzip")
			return self::hasBzip();
		return false;
	}

	public static function getComPrefix($compression)
	{
		if ($compression == "gzip")
			return "gz";
		if ($compression == "zip")
			return "zip_";
		if ($compression == "bzip")
			return "bz";
		return "f";
	}

	public static function getZExtension($compression)
	{
		if ($compression == "gzip")
			return "gz";
		if ($compression == "zip")
			return "zip";
		if ($compression == "bzip")
			return "bz";
	}

	public static function getCompression($filename)
	{
		$compressions = array("gzip", "zip", "bzip");
		foreach ($compressions as $val) {
			if (eregi("." . self::getZExtension($val), basename($filename)))
				return $val;
		}
		return "none";
	
	}

	public static function compress($file, $compression = "gzip", $destination = "", $remove = true, $writemode = "wb")
	{
		
		if (!self::hasCompression($compression))
			return false;
		if ($destination == "")
			$destination = $file;
		$prefix = self::getComPrefix($compression);
		$open = $prefix . "open";
		$write = $prefix . "write";
		$close = $prefix . "close";
		
		$fp = @fopen($file, "rb");
		if ($fp) {
			$zfile = $destination . ".gz";
			$gzfp = $open($zfile, $writemode);
			if ($gzfp) {
				do {
					$data = fread($fp, 8192);
					$_data_size = strlen($data);
					if ($_data_size == 0)
						break;
					$_written = $write($gzfp, $data);
					if ($_data_size != $_written) {
						return false;
					}
				} while (true);
				$close($gzfp);
			} else {
				fclose($fp);
				return false;
			}
			fclose($fp);
		} else {
			return false;
		}
		if ($remove)
			@unlink($file);
		return $zfile;
	}

	public static function decompress($gzfile, $remove = true)
	{
		$gzfp = @gzopen($gzfile, "rb");
		if ($gzfp) {
			$file = str_replace(".gz", "", $gzfile);
			if ($file == $gzfile)
				$file = $gzfile . "xml";
			$fp = @fopen($file, "wb");
			if ($fp) {
				do {
					$data = gzread($gzfp, 8192);
					if (strlen($data) == 0)
						break;
					fwrite($fp, $data);
				} while (true);
				fclose($fp);
			} else {
				gzclose($gzfp);
				return false;
			}
			gzclose($gzfp);
		} else {
			return false;
		}
		if ($remove)
			@unlink($gzfile);
		return $file;
	}

	public static function isCompressed($file, $offset = 0)
	{
		$fh = @fopen($file, 'rb');
		if ($fh) {
			if (fseek($fh, $offset, SEEK_SET) == 0) {
				// according to rfc1952 the first two bytes identify the format
				$_id1 = fgets($fh, 2);
				$_id2 = fgets($fh, 2);
				if ((ord($_id1) == 31) && (ord($_id2) == 139)) {
					return 1;
				}
			}
			fclose($fh);
		}
		return 0;
	
	}

	public static function saveFile($file_name, $sourceCode = "")
	{
		createLocalFolderByPath(str_replace("\\", "/", dirname($file_name)));
		$fh = @fopen($file_name, "wb");
		if (!$fh) {
			return false;
		}
		if ($sourceCode) {
			$ret = fwrite($fh, $sourceCode);
		} else {
			$ret = true;
		}
		fclose($fh);
		return $ret;
	}

	public static function createLocalFolder($RootDir, $path = "")
	{
		
		$completeDirPath = $RootDir . $path;
		
		return createLocalFolderByPath($completeDirPath);
	}

	public static function createLocalFolderByPath($completeDirPath)
	{
		
		$returnValue = true;
		
		if (checkAndMakeFolder($completeDirPath))
			return $returnValue;
		
		$cf = array($completeDirPath);
		
		$parent = dirname($completeDirPath);
		$parent = str_replace("\\", "/", $parent);
		
		while (!checkAndMakeFolder($parent)) {
			array_push($cf, $parent);
			$parent = dirname($parent);
			$parent = str_replace("\\", "/", $parent);
		}
		
		for ($i = (sizeof($cf) - 1); $i >= 0; $i--) {
			$oldumask = @umask(0000);
			
			if (defined("WE_NEW_FOLDER_MOD")) {
				eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) . ';');
			} else {
				$mod = 0755;
			}
			
			if (!@mkdir($cf[$i], $mod)) {
				insertIntoErrorLog("Could not create local Folder at we_live_tools.inc.php/createLocalFolderByPath(): '" . $cf[$i] . "'");
				$returnValue = false;
			}
			@umask($oldumask);
		}
		
		return $returnValue;
	}

	public static function insertIntoCleanUp($path, $date)
	{
		/*
		$DB_WE = we_io_DB::sharedAdapter();
	
		$dateQuery = $DB_WE->query("SELECT Date FROM " . CLEAN_UP_TABLE . " WHERE Path= ?", $path);
		$date = $dateQuery->fetchColumn(0);
		if($date!='') {
			$DB_WE->query("UPDATE " . CLEAN_UP_TABLE . " SET DATE= ? WHERE  Path= ? ", array($date, $path));
		}
		else {
			$DB_WE->query("INSERT INTO " . CLEAN_UP_TABLE . " (Path,Date) VALUES (?,?)", array($date, $path));
		}
		*/

	}

	public static function checkAndMakeFolder($path, $recursive = false)
	{
		/* if the directory exists, we have nothing to do and then we return true  */
		if (file_exists($path) && is_dir($path))
			return true;
		$docroot = ereg_replace('^(.*)/$', '\1', $_SERVER["DOCUMENT_ROOT"]);
		$path2 = ereg_replace('^(.*)/$', '\1', $path);
		if (strtolower($docroot) == strtolower($path2))
			return true;
			
		// if instead of the directory a file exists, we delete the file and create the directory
		if (file_exists($path) && (!is_dir($path))) {
			if (!deleteLocalFile($path)) {
				self::insertIntoErrorLog("Could not delete File '" . $path . "'");
				error_log("Could not delete File '" . $path . "'");
			}
		}
		
		$oldumask = @umask(0000);
		
		if (defined("WE_NEW_FOLDER_MOD")) {
			eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) . ';');
		} else {
			$mod = 0755;
		}
		
		// check for directories: create it if we could no write into it:
		if (!@mkdir($path, $mod, $recursive)) {
			@umask($oldumask);
			self::insertIntoErrorLog("Could not create local Folder at 'we_util_File/checkAndMakeFolder()': '" . $path . "'");
			error_log("Could not create local Folder at 'we_util_File/checkAndMakeFolder()': '" . $path . "'");
			return false;
		}
		@umask($oldumask);
		return true;
	}

	/**
	 * checks permission to write in path $path and tries a chmod(0755)
	 */
	public static function checkWritePermissions($path, $mod = 0755, $nocreate = false)
	{
		if (is_file($path)) {
			// ok, it's a file
		} else if (is_dir($path)) {
			// ok, it's a directory
		} else {
			error_log("we_util_File/checkWritePermissions() - target " . $path . " does not exist");
			return false;
		}
		if (is_writable($path)) {
			return true;
		} else {
			$oldumask = @umask();
			@umask(0755);
			if (!@chmod($path, $mod)) {
				return false;
			} else {
				if (is_writable($path)) {
					return true;
				} else {
					return false;
				}
			}
			@umask($oldumask);
		}
	}

	public static function insertIntoErrorLog($text)
	{
		/*
		$DB_WE = we_io_DB::sharedAdapter();
		$time = time();
		$DB_WE->query("INSERT INTO " . ERROR_LOG_TABLE . " (Text,Date) VALUES(?,?)", array($text, $time));
		*/
	}

	public static function getContentDirectFromDB($id, $name, $db = "")
	{
		/*
		$db = we_io_DB::sharedAdapter();
		$query = $db->query("SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID=? AND " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND " . LINK_TABLE . ".Name=?", array($id, $name));
		$res = $query->fetchColumn(0);
		if($res!='') {
			return true;
		}
		return false;
		*/

	}

	/**
	 * @deprecated since - 05.06.2008
	 * please use moveFile() instead
	 */
	public static function renameFile($old, $new)
	{
		return rename($old, $new);
	}

	/**
	 * copy a file
	 * due to windows limitations, the file has to be copied and the old file deleted afterwards.
	 * if $new exists already, windows will not rename the file $old
	 */
	public static function copyFile($old, $new)
	{
		if (!@copy($old, $new)) {
			return false;
		}
		return true;
	}

	/**
	 * move/rename a file
	 * due to windows limitations, the file has to be copied and the old file deleted afterwards.
	 * if $new exists already, windows will not rename the file $old
	 */
	public static function moveFile($old, $new)
	{
		if (!@rename($old, $new)) {
			if (copy($old, $new)) {
				unlink($old);
				return true;
			}
			return false;
		}
		return true;
	}

	/**
	 * recursively moves a directory
	 * it will only move $dir if there is no directory in $target with the same name
	 */
	public static function moveDir($dir, $target)
	{
		$dir = self::removeTrailingSlash($dir);
		$target = self::addTrailingSlash($target);
		$dirname = substr(strrchr($dir, "/"), 1);
		//error_log("source: ".$dir);
		//error_log("destination: ".self::addTrailingSlash($target.$dirname));
		if (self::removeTrailingSlash($dir) == self::removeTrailingSlash($target)) {
			error_log("source and destination are the same.");
			return true;
		}
		if (!@rename($dir, self::addTrailingSlash($target))) {
			error_log("could not move directory " . $dir . " to " . self::addTrailingSlash($target) . ".");
			return false;
		} else {
			return true;
		}
	}

	public static function deleteLocalFolder($filename, $delAll = 0)
	{
		if (!file_exists($filename))
			return false;
		if ($delAll) {
			$foo = (substr($filename, -1) == "/") ? $filename : ($filename . "/");
			$d = dir($filename);
			while (false !== ($entry = $d->read())) {
				if ($entry != ".." && $entry != ".") {
					$path = $foo . $entry;
					if (is_dir($path)) {
						self::deleteLocalFolder($path, 1);
					} else {
						self::deleteLocalFile($path);
					}
				}
			}
			$d->close();
		}
		return @rmdir($filename);
	}

	/**
	 * recursively deletes a directory with all its contents
	 * 
	 * @param string $path path to the directory that has to be deleted
	 * @param bool $nofiles does not delete any files but only empty subdirectories
	 */
	function rmdirr($path, $nofiles = false)
	{
		error_log("trying to recursively delete " . $path);
		if (!is_dir($path)) {
			error_log("ERROR: $path is no directory");
			return false;
		}
		if (!file_exists($path)) {
			error_log("ERROR: could not find $path");
			return false;
		}
		// check if it is a file or a symbolic link;
		if (is_file($path) || is_link($path)) {
			if ($nofiles === false) {
				error_log(" -- trying to delete file " . $path);
				return @unlink($path);
			} else {
				error_log(" -- skipping file " . $path);
			}
		}
		// loop through the folder
		$dir = dir($path);
		while (false !== $entry = $dir->read()) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			// Recurse
			error_log(" -- trying to delete folder " . $path);
			self::rmdirr($path . DIRECTORY_SEPARATOR . $entry);
		}
		$dir->close();
		// error_log(" -- trying to delete folder ".$path);
		return @rmdir($path);
	}

	public static function addTrailingSlash($value)
	{
		if (substr($value, -1) != "/") {
			return $value . "/";
		} else {
			return $value;
		}
	}

	public static function removeTrailingSlash($value)
	{
		if (substr($value, -1) == "/") {
			return substr($value, 0, -1);
		} else {
			return $value;
		}
	}
}