<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_objectFile.inc.php");

class exportFunctions {

	/*************************************************************************
	 * CONSTRUCTOR
	 *************************************************************************/

	/**
	 * Don't call this function directly. This is a static class!
	 *
	 * @return     exportFunctions
	 */

	function exportFunctions() {
		die("Don't call this function directly. This is a static class!");
	}

	/*************************************************************************
	 * HELPER FUNCTIONS
	 *************************************************************************/

	/**
	 * Creates the export file.
	 *
	 * @param      $format                                 string              (optional)
	 * @param      $filename                               string
	 * @param      $path                                   string
	 *
	 * @see        exportDocument
	 * @see        exportObject
	 *
	 * @return     bool
	 */

	function fileCreate($format = "gxml", $filename, $path) {
		switch ($format) {
			case "gxml":
				$_file_name = $_SERVER["DOCUMENT_ROOT"] . ($path == "###temp###" ? "/webEdition/we/tmp/" : $path) . $filename;

				$_continue = true;

				// Check if have to delete an existing file first
				if (file_exists($_file_name)) {
					$_continue = unlink($_file_name);
				}

				// Check if can create the file now
				if (!$_continue === false) {
					$_text  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
					$_text .= "<webEdition>\n";

					$_file_handler = fopen($_file_name, "wb");
					fwrite($_file_handler, $_text);
					fclose($_file_handler);
				}

				break;
			case "csv":
				$_file_name = $_SERVER["DOCUMENT_ROOT"] . ($path == "###temp###" ? "/webEdition/we/tmp/" : $path) . $filename;

				$_continue = true;

				// Check if have to delete an existing file first
				if (file_exists($_file_name)) {
					$_continue = unlink($_file_name);
				}

				// Check if can create the file now
				if ($_continue) {
					$_text = "";

					$_file_handler = fopen($_file_name, "wb");
					fwrite($_file_handler, $_text);
					fclose($_file_handler);
				}

				break;
		}

		return ((isset($_continue) && $_continue === false) ? false : (isset($_continue) ? true : false));
	}

	/**
	 * Completes the export file.
	 *
	 * @param      $format                                 string              (optional)
	 * @param      $text                                   string
	 * @param      $filename                               string
	 *
	 * @see        exportDocument
	 * @see        exportObject
	 *
	 * @return     void
	 */

	function fileComplete($format = "gxml", $filename) {
		switch ($format) {
			case "gxml":
				$text = "</webEdition>";

				$_file_handler = fopen($filename, "ab");
				fwrite($_file_handler, $text);
				fclose($_file_handler);

				break;
		}
	}

	/**
	 * Inits the export file (resuming supported).
	 *
	 * @param      $format                                 string              (optional)
	 * @param      $filename                               string
	 * @param      $path                                   string
	 * @param      $doctype                                string              (optional)
	 * @param      $tableid                                string              (optional)
	 *
	 * @see        exportDocument
	 * @see        exportObject
	 *
	 * @return     array
	 */

	function fileInit($format = "gxml", $filename, $path, $doctype = null, $tableid = null) {
		switch ($format) {
			case "gxml":
				$_file = "";

				// Get a matching doctype or classname
				if (($doctype != null) && ($doctype != "") && ($doctype != 0)) {
					$_doctype = f("SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID = '".abs($doctype)."'", "DocType", new DB_WE());
				} else if (($tableid != null) && ($tableid != "") && ($tableid != 0)) {
					$_tableid = f("SELECT Text FROM " . OBJECT_TABLE . " WHERE ID = '".abs($tableid)."'", "Text", new DB_WE());
				}

				if ($doctype != null) {
					$_doctype = exportFunctions::correctTagname((isset($_doctype) ? $_doctype : $doctype), "document");
				} else if ($tableid != null) {
					$_tableid = exportFunctions::correctTagname($_tableid, "object");
				}

				// Open document tag
				if ($doctype != null) {
					$_file .= "\t<" . $_doctype . ">\n";
				} else if ($tableid != null) {
					$_file .= "\t<" . $_tableid . ">\n";
				}

				break;
			case "csv":
				$_file = "";

				// Get a matching classname
				if (($tableid != null) && ($tableid != "") && ($tableid != 0)) {
					$_tableid = f("SELECT Text FROM " . OBJECT_TABLE . " WHERE ID = '".abs($tableid)."'", "Text", new DB_WE());
				}

				if ($tableid != null) {
					$_tableid = exportFunctions::correctTagname($_tableid, "object");
				}

				break;
		}

		return array("file" => $_file, "filename" => ($_SERVER["DOCUMENT_ROOT"] . ($path == "###temp###" ? "/webEdition/we/tmp/" : $path) . $filename), "doctype" => ((isset($doctype) && $doctype != null) ? $_doctype : ""), "tableid" => (($tableid != null) ? $_tableid : ""));
	}

	/**
	 * Writes the final output file.
	 *
	 * @param      $format                                 string              (optional)
	 * @param      $text                                   string
	 * @param      $doctype                                string
	 * @param      $filename                               string
	 *
	 * @see        exportDocument
	 * @see        exportObject
	 *
	 * @return     void
	 */

	function fileFinish($format = "gxml", $text, $doctype, $filename, $csv_lineend = "\\n") {
		switch ($format) {
			case "gxml":
				// Close document tag
				$text .= "\t</" . $doctype . ">\n";

				$_file_handler = fopen($filename, "ab");
				fwrite($_file_handler, $text);
				fclose($_file_handler);

				break;
			case "csv":
				// New linebreak
				switch ($csv_lineend) {
					case "windows":
						$text .= "\r\n";

						break;
					case "unix":
						$text .= "\n";

						break;
					case "mac":
						$text .= "\r";

						break;
				}

				$_file_handler = fopen($filename, "ab");
				fwrite($_file_handler, $text);
				fclose($_file_handler);

				break;
		}
	}

	/**
	 * This function corrects the name of a XML tag.
	 *
	 * @param      $tagname                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function correctTagname($tagname, $alternative_name, $alternative_number = -1) {
		if ($tagname != "") {
			// Remove spaces
			$tagname = preg_replace("/\40+/", "_", $tagname);

			// Remove special characters
			$tagname = preg_replace("/[^a-zA-Z0-9_]+/", "", $tagname);
		}

		// Set alternative name if no name is now present present
		if ($tagname == "") {
			$tagname = ($alternative_number != -1) ? $alternative_name . $alternative_number : $alternative_name;
		}

		return $tagname;
	}

	/**
	 * This function checks for the need of a CSV encloser to be set.
	 *
	 * @param      $content                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function checkCompatibility($content, $csv_delimiter = ",", $csv_enclose = "'", $type = "escape") {
		switch ($type) {
			case "escape":
				$_check = array("\\");

				break;
			case "enclose":
				$_check = array($csv_enclose);

				break;
			case "delimiter":
				$_check = array($csv_delimiter);

				break;
			case "lineend":
				$_check = array("\r\n", "\n", "\r");

				break;
		}

		$_encloser_needed = false;

		for ($i = 0; $i < count($_check); $i++) {
			if (strpos($content, $_check[$i]) !== false) {
				$_encloser_needed = true;
			}
		}

		return $_encloser_needed;
	}

	/**
	 * This function checks for the need of a CSV escape character to be set.
	 *
	 * @param      $content                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function correctEscape($content) {
		return str_replace("\\", "\\\\", $content);
	}

	/**
	 * This function checks for the need of a CSV escape character to be set.
	 *
	 * @param      $content                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function correctEnclose($content, $csv_enclose = "'") {
		return str_replace($csv_enclose, ("\\" . $csv_enclose), $content);
	}

	/**
	 * This function checks for the need of a CSV escape character to be set.
	 *
	 * @param      $content                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function correctLineend($content, $csv_lineend = "windows") {
		switch ($csv_lineend) {
			case "windows":
			default:
				$_corrected_content = str_replace("\n", "\\r\\n", $content);
				$_corrected_content = str_replace("\r", "\\r\\n", $content);

				break;
			case "unix":
			default:
				$_corrected_content = str_replace("\r\n", "\\n", $content);
				$_corrected_content = str_replace("\r", "\\n", $content);

				break;
			case "mac":
			default:
				$_corrected_content = str_replace("\r\n", "\\r", $content);
				$_corrected_content = str_replace("\n", "\\r", $content);

				break;
		}

		return $_corrected_content;
	}

	/**
	 * This function sets a CSV encloder if it is needed.
	 *
	 * @param      $content                                string
	 * @param      $alternative_name                       string
	 * @param      $alternative_number                     int                 (optional)
	 *
	 * @see        exportDocument
	 *
	 * @return     string
	 */

	function correctCSV($content, $csv_delimiter = ",", $csv_enclose = "'", $csv_lineend = "windows") {
		$_encloser_corrected = false;
		$_delimiter_corrected = false;
		$_lineend_corrected = false;

		// Escape
		if (exportFunctions::checkCompatibility($content, $csv_delimiter, $csv_enclose, "escape")) {
			$_corrected_content = exportFunctions::correctEscape($content);
		} else {
			$_corrected_content = $content;
		}

		// Enclose
		if (exportFunctions::checkCompatibility($_corrected_content, $csv_delimiter, $csv_enclose, "enclose")) {
			$_encloser_corrected = true;

			$_corrected_content = exportFunctions::correctEnclose($_corrected_content, $csv_enclose);
		} else {
			$_corrected_content = $content;
		}

		// Delimiter
		if (exportFunctions::checkCompatibility($_corrected_content, $csv_delimiter, $csv_enclose, "delimiter")) {
			$_delimiter_corrected = true;
		}

		// Lineend
		if (exportFunctions::checkCompatibility($_corrected_content, $csv_delimiter, $csv_enclose, "lineend")) {
			$_lineend_corrected = true;

			$_corrected_content = exportFunctions::correctLineend($_corrected_content, $csv_lineend);
		} else {
			$_corrected_content = $_corrected_content;
		}

		if ($_encloser_corrected || $_delimiter_corrected || $_lineend_corrected) {
			$_corrected_content = $csv_enclose . $_corrected_content . $csv_enclose;
		}

		return $_corrected_content;
	}

	/**
	 * This functions formats the output of a single element of an export.
	 *
	 * @param      $tagname                                string
	 * @param      $content                                string
	 * @param      $format                                 string              (optional)
	 * @param      $tabs                                   string              (optional)
	 * @param      $fix_content                            bool                (optional)
	 * @param      $csv_delimiter                          string              (optional)
	 * @param      $csv_enclose                            string              (optional)
	 *
	 * @see        exportDocument
	 * @see        correctXMLContent
	 *
	 * @return     string
	 */

	function formatOutput($tagname, $content, $format = "gxml", $tabs = 2, $cdata = false, $fix_content = false, $csv_delimiter = ",", $csv_enclose = "'", $csv_lineend = "windows") {
		switch ($format) {
			case "gxml":
				// Generate intending tabs
				for ($i = 0; $i < $tabs; $i++) {
					if (!isset($_tabs)) {
						$_tabs = "\t";
					} else {
						$_tabs .= "\t";
					}
				}

				// Generate XML output if content is given
				if ($content != "") {
					$_output = (isset($_tabs) ? $_tabs : "") . "<" . $tagname . ">" . ($fix_content ? ($cdata ? ("<![CDATA[" . $content . "]]>") : htmlspecialchars($content, ENT_QUOTES)) : $content) . "</" . $tagname . ">\n";
				} else {
					$_output = (isset($_tabs) ? $_tabs : "") . "<" . $tagname . "/>\n";
				}

				break;
			case "csv":
				// Generate XML output if content is given
				if ($content != "") {
					$_output = exportFunctions::correctCSV($content, $csv_delimiter, $csv_enclose, $csv_lineend) . $csv_delimiter;
				} else {
					$_output = $csv_delimiter;
				}

				break;
			case "cdata":
				// Generate CDATA XML output if content is given
				if ($content != "") {
					$_output = "<![CDATA[" . $content . "]]>";
				} else {
					$_output = "";
				}

				break;
		}

		return $_output;
	}

	/**
	 * Helper function to detect empty xml tags to be written.
	 *
	 * @param      $check_array                            array
	 * @param      $tagname                                string
	 *
	 * @see        exportDocument
	 *
 	 * @return     array
	 */

	function remove_from_check_array($check_array, $tagname) {
		for ($i = 0; $i < count($check_array); $i++) {
			if (isset($check_array[$i])) {
				if ($check_array[$i] == $tagname) {
					array_splice($check_array, $i, 1);
				}
			}
		}

		return $check_array;
	}

	/*************************************************************************
	 * EXPORT FUNCTIONS
	 *************************************************************************/

	/**
	 * Imports a document into webEdition.
	 *
	 * @param      $ID                                     int
	 * @param      $format                                 string              (optional)
	 * @param      $filename                               string
	 * @param      $path                                   string
	 * @param      $file_create                            bool                (optional)
	 * @param      $file_complete                          bool                (optional)
	 *
	 * @see        correctTagname
	 * @see        formatOutput
	 * @see        remove_from_check_array
	 * @see        fileCreate
	 * @see        fileComplete
	 *
	 * @return     bool
	 */

	function exportDocument($ID, $format = "gxml", $filename, $path, $file_create = false, $file_complete = false, $cdata = false) {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_webEditionDocument.inc.php");

		$_export_success = false;

		// Create a new webEdition document object
		$we_doc = new we_webEditionDocument();

		$we_doc->initByID($ID);

		if ($file_create) {
			exportFunctions::fileCreate($format, $filename, $path);
		}
		// Read content
		if ($we_doc->ContentType == "text/webedition") {
			$DB_WE = new DB_WE();

			$_sql_select = "SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . CONTENT_TABLE . "," . LINK_TABLE . " WHERE " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND ".
							LINK_TABLE . ".DocumentTable='" . substr(TEMPLATES_TABLE, strlen(TBL_PREFIX)) . "' AND " . LINK_TABLE . ".DID='" . abs($we_doc->TemplateID) . "' AND " . LINK_TABLE . ".Name='completeData'";

			$_template_code = f($_sql_select, "Dat", $DB_WE);
			$_tag_parser = new we_tagParser();
			$_tags = $_tag_parser->getAllTags($_template_code);
			$_records = array();

			foreach ($_tags as $_tag) {
				if (eregi('<we:([^> /]+)', $_tag, $_regs)) {
					$_tag_name = $_regs[1];
					if (eregi('name="([^"]+)"', $_tag, $_regs) && ($_tag_name != "var")) {
						$_name = $_regs[1];
						switch ($_tag_name) {
							// tags with text content, links and hrefs
							case "input":
							case "textarea":
							case "href":
							case "link":
								array_push($_records, $_name);
							break;
						}
					}
				}
			}

			$hrefs = array();

			$_file_values = exportFunctions::fileInit($format, $filename, $path, ((isset($we_doc->DocType) && ($we_doc->DocType != "") && ($we_doc->DocType != 0)) ? $we_doc->DocType : "document"));

			$_file = $_file_values["file"];
			$_file_name = $_file_values["filename"];
			$_doctype = $_file_values["doctype"];

			$_tag_counter = 0;

			foreach ($we_doc->elements as $k=>$v) {
				$_tag_counter++;

				if (isset($v["type"])) {
					switch($v["type"]) {
						case "date": // is a date field
							$_tag_name = exportFunctions::correctTagname($k, "date", $_tag_counter);
							$_file .= exportFunctions::formatOutput($_tag_name, abs($we_doc->elements[$k]["dat"]), $format, 2, $cdata);

							// Remove tagname from array
							if (isset($_records)) {
								$_records = exportFunctions::remove_from_check_array($_records, $_tag_name);
							}

							break;
						case "txt":
							if(ereg("(.+)_we_jkhdsf_(.+)",$k,$regs)){  // is a we:href field
								if (!in_array($regs[1], $hrefs)) {
									array_push($hrefs, $regs[1]);

									$_int = ((!isset($we_doc->elements[$regs[1] . "_we_jkhdsf_int"]["dat"])) || $we_doc->elements[$regs[1] . "_we_jkhdsf_int"]["dat"] == "") ? 0 : $we_doc->elements[$regs[1] . "_we_jkhdsf_int"]["dat"];

									if ($_int) {
										$_intID = $we_doc->elements[$regs[1] . "_we_jkhdsf_intID"]["dat"];

										$_tag_name = exportFunctions::correctTagname($k, "link", $_tag_counter);
										$_file .= exportFunctions::formatOutput($_tag_name, id_to_path($_intID, FILE_TABLE, $DB_WE), $format, 2, $cdata);

										// Remove tagname from array
										if (isset($_records)) {
											$_records = exportFunctions::remove_from_check_array($_records, $_tag_name);
										}
									} else {
										$_tag_name = exportFunctions::correctTagname($k, "link", $_tag_counter);
										$_file .= exportFunctions::formatOutput($_tag_name, $we_doc->elements[$regs[1]]["dat"], $format, 2, $cdata);

										// Remove tagname from array
										if (isset($_records)) {
											$_records = exportFunctions::remove_from_check_array($_records, $_tag_name);
										}
									}
								}
							} else if (substr($we_doc->elements[$k]["dat"], 0, 2) == "a:" && is_array(unserialize($we_doc->elements[$k]["dat"]))) { // is a we:link field
								$_tag_name = exportFunctions::correctTagname($k, "link", $_tag_counter);
								$_file .= exportFunctions::formatOutput($_tag_name, exportFunctions::formatOutput("", $we_doc->getFieldByVal($we_doc->elements[$k]["dat"], "link"), "cdata"), $format, 2, $cdata);

								// Remove tagname from array
								if (isset($_records)) {
									$_records = exportFunctions::remove_from_check_array($_records, $_tag_name);
								}
							} else { // is a normal text field
								$_tag_name = exportFunctions::correctTagname($k, "text", $_tag_counter);
								$_file .= exportFunctions::formatOutput($_tag_name, parseInternalLinks($we_doc->elements[$k]["dat"], $we_doc->ParentID), $format, 2, $cdata, $format == "gxml");

								// Remove tagname from array
								if (isset($_records)) {
									$_records = exportFunctions::remove_from_check_array($_records, $_tag_name);
								}
							}

							break;
					}
				}
			}

			if (isset($_records) && is_array($_records)) {
				for ($i = 0; $i < count($_records); $i++) {
					if (isset($_records[$i])) {
						$_file .= exportFunctions::formatOutput($_records[$i], "", $format, 2, $cdata);
					}
				}
			}

			exportFunctions::fileFinish($format, $_file, $_doctype, $_file_name);

		}
		$_tmp_file_name = $_SERVER["DOCUMENT_ROOT"] . ($path == "###temp###" ? "/webEdition/we/tmp/" : $path) . $filename;

		if ($file_complete) {
			exportFunctions::fileComplete($format, $_tmp_file_name);
		}

		// Return success of export
		return $_export_success;
	}

	/**
	 * Imports a document into webEdition.
	 *
	 * @param      $ID                                     int
	 * @param      $format                                 string              (optional)
	 * @param      $filename                               string
	 * @param      $path                                   string
	 * @param      $file_create                            bool                (optional)
	 * @param      $file_complete                          bool                (optional)
	 * @param      $csv_delimiter                          string              (optional)
	 * @param      $csv_enclose                            string              (optional)
	 * @param      $csv_lineend                            string              (optional)
	 * @param      $csv_fieldnames                         string              (optional)
	 *
	 * @see        correctTagname
	 * @see        formatOutput
	 * @see        remove_from_check_array
	 * @see        fileCreate
	 * @see        fileComplete
	 *
	 * @return     bool
	 */

	function exportObject($ID, $format = "gxml", $filename, $path, $file_create = false, $file_complete = false, $cdata = false, $csv_delimiter = ",", $csv_enclose = "'", $csv_lineend = "\\n", $csv_fieldnames = false) {
		$_export_success = false;

		//if ($csv_fieldnames) {
		//	exportFunctions::exportObjectFieldNames($ID, $filename, $path, $file_create, $csv_delimiter, $csv_enclose, $csv_lineend);
		//}

		if ($csv_delimiter == "\\t") {
			$csv_delimiter = "\t";
		}

		// Create a new webEdition object object
		$we_obj = new we_objectFile();

		$we_obj->initByID($ID, OBJECT_FILES_TABLE);

		$DB_WE = new DB_WE();

		$foo = getHash("SELECT strOrder, DefaultValues FROM " . OBJECT_TABLE . " WHERE ID='" . abs($we_obj->TableID) . "'", $DB_WE);

		$dv = $foo["DefaultValues"] ? unserialize($foo["DefaultValues"]) : array();

		if (!is_array($dv)) {
			$dv = array();
		}

		$tableInfo_sorted = $we_obj->getSortedTableInfo($we_obj->TableID, true, $DB_WE);

		$fields = array();

		for ($i = 0; $i < sizeof($tableInfo_sorted); $i++) {
			//if (ereg('^(.+)_(.+)$', $tableInfo_sorted[$i]["name"], $regs)) {
			// bugfix 8141
			$regs = array();
			if (ereg('^([^_]+)_(.+)$',$tableInfo_sorted[$i]["name"],$regs)) {
				array_push($fields, array("name" => $regs[2], "type" => $regs[1]));
			}
		}

		if ($file_create && !$csv_fieldnames) {
			exportFunctions::fileCreate($format, $filename, $path);
		}

		$_file_values = exportFunctions::fileInit($format, $filename, $path, null, $we_obj->TableID);

		$_file = $_file_values["file"];
		$_file_name = $_file_values["filename"];
		$_tableid = $_file_values["tableid"];

		for ($i = 0; $i < sizeof($fields); $i++) {
			if (($fields[$i]["type"] != "object") &&
					($fields[$i]["type"] != "img") &&
					($fields[$i]["type"] != "binary")) {
				$realName = $fields[$i]["type"] . "_" . $fields[$i]["name"];

				switch ($format) {
					case "gxml":
						$_tag_name = exportFunctions::correctTagname($fields[$i]["name"], "value", $i);
						$_content = $we_obj->getElementByType($fields[$i]["name"], $fields[$i]["type"], $dv[$realName]);
						$_file .= exportFunctions::formatOutput($_tag_name, parseInternalLinks($_content, 0), $format, 2, $cdata, (($format == "gxml") && ($fields[$i]["type"] != "date") && ($fields[$i]["type"] != "int") && ($fields[$i]["type"] != "float")));

						break;
					case "csv":
						$_content = $we_obj->getElementByType($fields[$i]["name"], $fields[$i]["type"], $dv[$realName]);
						$_file .= exportFunctions::formatOutput("", parseInternalLinks($_content, 0), $format, 2, false, (($format == "gxml") && ($fields[$i]["type"] != "date") && ($fields[$i]["type"] != "int") && ($fields[$i]["type"] != "float")), $csv_delimiter, $csv_enclose, $csv_lineend);

						break;
				}
			}
		}

		exportFunctions::fileFinish($format, $_file, $_tableid, $_file_name, ($format == "csv" ? $csv_lineend : ""));

		if ($file_complete) {
			exportFunctions::fileComplete($format, $_file_name);
		}

		// Return success of export
		return $_export_success;
	}

	/**
	 * Imports a document into webEdition.
	 *
	 * @param      $ID                                     int
	 * @param      $format                                 string              (optional)
	 * @param      $filename                               string
	 * @param      $path                                   string
	 * @param      $file_create                            bool                (optional)
	 * @param      $file_complete                          bool                (optional)
	 * @param      $csv_delimiter                          string              (optional)
	 * @param      $csv_enclose                            string              (optional)
	 * @param      $csv_lineend                            string              (optional)
	 * @param      $csv_fieldnames                         string              (optional)
	 *
	 * @see        correctTagname
	 * @see        formatOutput
	 * @see        remove_from_check_array
	 * @see        fileCreate
	 * @see        fileComplete
	 *
	 * @return     bool
	 */

	function exportObjectFieldNames($ID, $filename, $path, $file_create = false, $csv_delimiter = ",", $csv_enclose = "'", $csv_lineend = "windows") {
		$_export_success = false;

		if ($csv_delimiter == "\\t") {
			$csv_delimiter = "\t";
		}

		// Create a new webEdition object object
		$we_obj = new we_objectFile();

		$we_obj->initByID($ID, OBJECT_FILES_TABLE);

		$DB_WE = new DB_WE();

		$foo = getHash("SELECT strOrder, DefaultValues FROM " . OBJECT_TABLE . " WHERE ID='" . abs($we_obj->TableID) . "'", $DB_WE);

		$dv = $foo["DefaultValues"] ? unserialize($foo["DefaultValues"]) : array();

		if (!is_array($dv)) {
			$dv = array();
		}

		$tableInfo_sorted = $we_obj->getSortedTableInfo($we_obj->TableID, true, $DB_WE);

		$fields = array();

		for ($i = 0; $i < sizeof($tableInfo_sorted); $i++) {
			//if (ereg('^(.+)_(.+)$', $tableInfo_sorted[$i]["name"], $regs)) {
			// bugfix 8141
			if (ereg('^([^_]+)_(.+)$', $tableInfo_sorted[$i]["name"], $regs)) {
				array_push($fields, array("name" => $regs[2], "type" => $regs[1]));
			}
		}

		if ($file_create) {
			exportFunctions::fileCreate("csv", $filename, $path);
		}

		$_file_values = exportFunctions::fileInit("csv", $filename, $path, null, $we_obj->TableID);

		$_file = $_file_values["file"];
		$_file_name = $_file_values["filename"];
		$_tableid = $_file_values["tableid"];

		for ($i = 0; $i < sizeof($fields); $i++) {
			if (($fields[$i]["type"] != "object") &&
					($fields[$i]["type"] != "img") &&
					($fields[$i]["type"] != "binary")) {
				$realName = $fields[$i]["type"] . "_" . $fields[$i]["name"];

				$_tag_name = exportFunctions::correctTagname($fields[$i]["name"], "value", $i);
				$_file .= exportFunctions::formatOutput("", $_tag_name, "csv", 2, false, false, $csv_delimiter, $csv_enclose, $csv_lineend);
			}
		}

		exportFunctions::fileFinish("csv", $_file, $_tableid, $_file_name, $csv_lineend);

		// Return success of export
		return $_export_success;
	}
}

?>