<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

include_once (dirname(dirname(__FILE__)) . '/../we/core/autoload.php');

include_once('Zend/Log.php');

/**
 * static logging class for logging messages
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Log
{
	
	const ENABLE_LOGGING = true;
	
	/**
	 * @var Zend_Log object for syslog.php 
	 */
	protected static $_syslog = null;
	
	/**
	 * @var Zend_Log object for other logfiles than syslog.php 
	 */
	protected static $_logfile = null;
	
	/**
	 * logs messages with debuglevel via Zend_Log to webEdition logfile "syslog.php"
	 * @param string $message message to write to log file
	 * @param $filename optional parameter to write the message to another file than "syslog.php"
	 * @param int $errorlevel priority code defined in Zend_Log:
	 * 			EMERG   = 0;  // Emergency: system is unusable
	 * 			ALERT   = 1;  // Alert: action must be taken immediately
	 * 			CRIT    = 2;  // Critical: critical conditions
	 * 			ERR     = 3;  // Error: error conditions
	 * 			WARN    = 4;  // Warning: warning conditions
	 * 			NOTICE  = 5;  // Notice: normal but significant condition
	 * 			INFO    = 6;  // Informational: informational messages
	 * 			DEBUG   = 7;  // Debug: debug messages
	 * @return bool false if logging to file fails (mostly because of insufficient file access rights)
	 */
	public static function log($message = "",$errorlevel = 7, $filename = "syslog")
	{
		
		if(!self::isActive()) {
			return false;
		}
		if($filename != "syslog") {
			self::$_logfile = null;
		}
		if(is_null(self::$_syslog)) {
			//$writer = new Zend_Log_Writer_Stream('php://output');
			$logCheck = self::checkCreateLog($filename);
			if($logCheck === false) {
				error_log("could write to syslog");
				return false;
			} else {
				$writer = new Zend_Log_Writer_Stream($logCheck);
				if($filename == "syslog") {
					self::$_syslog = new Zend_Log($writer);
				} else {
					self::$_logfile = new Zend_Log($writer);
				}
			}
		}
		if($filename == "syslog") {
			self::$_syslog->log($message,$errorlevel);
		} else {
			self::$_logfile->log($message,$errorlevel);
		}
	}
	
	/**
	 * static function to log messages with errorlevel to the system's syslog.
	 * @param string $message message to write to log file
	 * @param int $errorlevel priority code defined in Zend_Log:
	 * 			LOG_EMERG   = 0;  // Emergency: system is unusable
	 * 			LOG_ALERT   = 1;  // Alert: action must be taken immediately
	 * 			LOG_CRIT    = 2;  // Critical: critical conditions
	 * 			LOG_ERR     = 3;  // Error: error conditions
	 * 			LOG_WARNING = 4;  // Warning: warning conditions
	 * 			LOG_NOTICE  = 5;  // Notice: normal but significant condition
	 * 			LOG_INFO    = 6;  // Informational: informational messages
	 * 			LOG_DEBUG   = 7;  // Debug: debug messages
	 * @return bool status ofs yslog()
	 * @uses syslog http://de.php.net/manual/de/function.syslog.php
	 */
	public static function syslog($message = "",$errorlevel = 7)
	{
		if(!self::isActive()) {
			return false;
		}
		$errorcodes = array(LOG_EMERG, LOG_ALERT, LOG_CRIT, LOG_ERR, LOG_WARNING, LOG_NOTICE, LOG_INFO, LOG_DEBUG);
		$errorcode = $errorcodes[$errorlevel];
		return syslog($errorcode,$message);
	}
	
	/**
	 * logs messages to php errorlog
	 * @param mixed $message message to write to errorlog
	 * 			$message can be a string as well as an array or an object
	 */
	public static function errorLog($message = "")
	{
		if(!self::isActive()) {
			return false;
		}
		switch($message) {
			case "":
				error_log("undefined error");
				break;
			case is_array($message):
				error_log(print_r($message,true));
				break;
			case is_object($message):
				error_log(print_r($message,true));
				break;
			default:
				error_log(print_r($message,true));
				break;
		}
	}
	
	/**
	 * logs current memory usage to syslog
	 * @param string $message optional text message for description
	 */
	public static function memusage($message = "")
	{
		if(!self::isActive()) {
			return false;
		}
		if(!empty($message)) {
			$message .= ": ";
		} else {
			$message = "used: ";
		}
		error_log($message . round(((memory_get_usage()/1024)/1024),3) . " MB, limit: ".ini_get('memory_limit'));
	}
	
	/**
	 * checks if the used log file already exists.
	 * creates the missinglog file in webEdition/log/ with php exit statement at the beginning and .php suffix
	 * if it does not exist already.
	 */
	public static function checkCreateLog($filename = "")
	{
		if(empty($filename) || ctype_alnum($filename) === false) return false;
		$logPath = $_SERVER["DOCUMENT_ROOT"].'/webEdition/log/';
		$file = $logPath.$filename.".php";
		if(is_file($file) && is_writable($file)) {
			return $file;
		} else {
			if(!is_dir($logPath)) {
				if(!@mkdir($logPath)) {
					error_log("log directory not found, could not create it due to insufficient accesss rights.");
					return false;
				}
			}
			$exitCode = "<?php\n exit(); \n ?>\n";
			if(!@file_put_contents($file, $exitCode)) {
				error_log("could not create logfile due to insufficient accesss rights.");
			} else {
				return $file;
			}
		}
	}
	
	/**
	 * checks if either the system wide constant ENABLE_LOGGING or the class constant SELF::ENABLE_LOGGING is set to (bool)true
	 * @return bool true/false
	 */
	public static function isActive()
	{
		if(@constant("self::ENABLE_LOGGING") === true || @constant("ENABLE_LOGGING") === true) {
			return true;
		}
		return false;
	}
}