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

class weConfParser {

	var $_content = "";

	var $_data = array();



	function weConfParser($content) {
		$this->_content = $content;
		$this->_parse();
	}

	function getConfParserByFile($file) {
		$fileContents = implode('', file($file));
		return new weConfParser($fileContents);
	}


	function setGlobalPref($name, $value, $comment="") {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
		$file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php";
		$parser = weConfParser::getConfParserByFile($file_name);
		$settings = $parser->getData();
		if(in_array($name,array_keys($settings))) {
			$file = weConfParser::changeSourceCode("define", $parser->getContent(), $name, $value, true, $comment);
		} else {
			$file = weConfParser::changeSourceCode("add", $parser->getContent(), $name, $value, true, $comment);
		}

		return weFile::save($file_name,$file);
	}

	function setGlobalPrefInContent(&$content, $name, $value,$comment="") {
		$parser = new weConfParser($content);
		$settings = $parser->getData();
		if(in_array($name,array_keys($settings))) {
			$content = weConfParser::changeSourceCode("define", $content, $name, $value, true, $comment);
		} else {
			$content = weConfParser::changeSourceCode("add", $content, $name, $value, true, $comment);
		}

		return true;
	}

	function saveToFile($file) {
		$fp = fopen($file,"wb");
		if (!$fp) {
			return false;
		}
		if(!fwrite($fp,$this->getFileContent())) {
			return false;
		}
		fclose($fp);
		return true;
	}

	function getValue($key) {
		return isset($_data[$key]) ? $_data[$key] : "";
	}

	function setValue($key, $value) {
		$_data[$key] = $value;
	}

	function getData() {
		return $this->_data;
	}

	function getContent() {
		return $this->_content;
	}


	function changeSourceCode($type = "define", $text, $key, $value, $active = true, $comment="") {
		$_abort = false;

		switch ($type) {

			case "add":
				return substr(trim($text),0,-2) .
						weConfParser::makeDefine($key, $value, $active, $comment) . "\n\n" .
						"?>";
			case "define":
				if(preg_match('|/?/?define\(\s*("'.preg_quote($key).'")\s*,\s*([^\r\n]+)\);[\r\n]|Ui',$text,$match)) {
					return str_replace($match[0], weConfParser::makeDefine($key, $value, $active)."\n",$text);
				}
		}

		return $text;
	}

	function _addSlashes($in) {
		$out = str_replace("\\","\\\\",$in);
		$out = str_replace("\"","\\\"",$out);
		$out = str_replace("\$","\\\$",$out);
		return $out;
	}

	function _stripSlashes($in) {
		$out = str_replace("\\\\","\\",$in);
		$out = str_replace("\\\"","\"",$out);
		$out = str_replace("\\\$","\$",$out);
		return $out;
	}

	function getFileContent() {
		$out = '<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Configuration file for webEdition
 * =================================
 *
 * Holds the globals settings of webEdition.
 *
 * NOTE:
 * =====
 * Edit this file ONLY if you know exactly what you are doing!
 */

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_error_conf.inc.php")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_error_conf.inc.php");
}

';
		foreach($this->_data as $key=>$val) {
			$out .= weConfParser::makeDefine($key, $val) . "\n\n";
		}

		return $out . "?>";
	}

	function makeDefine($key, $val, $active = true, $comment="") {
		$comment = ($comment ? "//$comment\n" : "");
		if (!is_numeric($val)) {
			return $comment . ($active ? "" : "//") . 'define("'.$key.'", "' . weConfParser::_addSlashes($val) . '");';
		} else {
			return $comment . ($active ? "" : "//") . 'define("'.$key.'", '. $val . ');';
		}
	}

	function _correctMatchValue($value) {
		// remove whitespaces at beginning and end
		$value = trim($value);
		if (is_numeric($value)) {
			// convert to a real number
			$value = 1 * $value;
		} else if (strlen($value) >= 2){
			// remove starting and ending quotes
			$value = substr($value,1,strlen($value) - 2);
		} else {
			// something is not right, so  correct it as an empty string
			$value = "";
		}
		return weConfParser::_stripSlashes($value);
	}

	function _parse() {
		// reset data array
		$this->_data = array();
		if ($this->_content) {
			$pattern = '|define\(\s*"([^"]+)"\s*,\s*([^\r\n]+)\);[\r\n]|Ui';
			if (preg_match_all($pattern,$this->_content,$match, PREG_PATTERN_ORDER)) {
				for ($i=0; $i<count($match[1]);$i++) {
					$this->_data[$match[1][$i]] = weConfParser::_correctMatchValue($match[2][$i]);
				}
			}
		}
	}
}

?>