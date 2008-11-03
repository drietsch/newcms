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
 * Utility class for string manipulation and creation
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_util_Strings
{

	/**
	 * Returns an unique ID
	 *
	 * @param integer $length  length of generated ID
	 * @return string
	 */
	static function createUniqueId($length = 32)
	{
		return substr(md5(uniqid(time())), 0, $length);
	}

	/**
	 * Returns cvs of array values
	 *
	 * @param string $arr
	 * @param string $prePostKomma
	 * @param string $sep
	 * @return string
	 */
	static function makeCSVFromArray($arr, $prePostKomma = false, $sep = ",")
	{
		if (!sizeof($arr))
			return "";
		
		$replaceKomma = (count($arr) > 1) || ($prePostKomma == true);
		
		if ($replaceKomma) {
			for ($i = 0; $i < sizeof($arr); $i++) {
				$arr[$i] = str_replace($sep, "###komma###", $arr[$i]);
			}
		}
		$out = implode($sep, $arr);
		if ($prePostKomma) {
			$out = $sep . $out . $sep;
		}
		if ($replaceKomma) {
			$out = str_replace("###komma###", "\\$sep", $out);
		}
		return $out;
	}

	/**
	 * Returns an array of cvs values
	 *
	 * @param string $csv
	 * @return array
	 */
	static function makeArrayFromCSV($csv)
	{
		
		$csv = str_replace("\\,", "###komma###", $csv);
		
		if (substr($csv, 0, 1) == ",") {
			$csv = substr($csv, 1);
		}
		if (substr($csv, -1) == ",") {
			$csv = substr($csv, 0, strlen($csv) - 1);
		}
		if ($csv == "" && $csv != "0") {
			$foo = array();
		} else {
			$foo = explode(",", $csv);
			for ($i = 0; $i < sizeof($foo); $i++) {
				$foo[$i] = str_replace("###komma###", ",", $foo[$i]);
			}
		}
		return $foo;
	}

	/**
	 * Returns a quoted string
	 *
	 * @param string $text
	 * @param boolean $quoteForSingle
	 * @return string
	 */
	static function quoteForJSString($text, $quoteForSingle = true)
	{
		if ($quoteForSingle) {
			return str_replace('\'', '\\\'', str_replace('\\', '\\\\', $text));
		} else {
			return str_replace("\"", "\\\"", str_replace("\\", "\\\\", $text));
		}
	}

	/**
	 * Returns a shortened string
	 *
	 * @param string $path
	 * @param integer $len
	 * @return string
	 */
	static function shortenPath($path, $len)
	{
		if (strlen($path) <= $len || strlen($path) < 10)
			return $path;
		$l = ($len / 2) - 2;
		return substr($path, 0, $l) . "...." . substr($path, $l * -1);
	}

}
