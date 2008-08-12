<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");


class CSV {
	var $CSVFile;
	var $CSVData;
	var $CSVError;
	var $FieldNames;
	var $Fields;
	var $FieldTypes;
	var $fetchCursor;

	var $Filter;

	function CSV() {
		$this->CSVError = array();
		$this->CSVData = "";
		$this->Filter = array();
	}


	function setFile($file) {
		$this->CSVFile = $file;
		if (file_exists($this->CSVFile) && ($this->CSVFile != "none") && !empty($this->CSVFile)) {
			$this->setData(implode("",file($this->CSVFile)));
		}
		else {
			$this->CSVError[] = "The file " . $file . " does not exist or is empty.";
			return FALSE;
		}
	}

	function setData($string) {
		$this->CSVData = $string;
		$this->Fields = array();
		$this->FieldTypes = array();
		$this->FieldNames = array();
	}

	function CSVFetchRow() {
		if ($this->fetchCursor <= $this->CSVNumRows()) {
			$r = $this->Fields[$this->fetchCursor];
			$this->fetchCursor++;
			return $r;
		}
		else {
			$this->CSVError[] = "No more data sets.";
			return FALSE;
		}
	}

	function CSVFetchArray($resultTyp = "BOTH") {
		if ($this->fetchCursor <= ($this->CSVNumRows())-1) {

			if(($resultTyp == "NUM") || ($resultTyp == "BOTH")) {
				$r = $this->CSVFetchRow();
				if($resultTyp == "NUM") return $r;

				$this->fetchCursor--;
			}
			if (($resultTyp == "ASSOC") || ($resultTyp == "BOTH")) {

				if (is_array($this->Fields[$this->fetchCursor])) {
					reset($this->Fields[$this->fetchCursor]);
					while(list($field_id, $field) = each($this->Fields[$this->fetchCursor])) {
						$r[$this->FieldNames[$field_id]] = $field;
					}
				}
			}
			$this->fetchCursor++;
			return $r;
		}
		else {
			$this->CSVError[] = "No more data sets.";
			return FALSE;
		}
	}

	function CSVFetchFieldNames() {
		return $this->FieldNames;
	}

	function CSVFieldName($field_id) {
		return $this->FieldNames[$field_id];
	}

	function CSVNumRows() {
		return count($this->Fields);
	}

	function CSVNumFields() {
		return count($this->FieldNames);
	}

	function setCursor($pos) {
		$this->fetchCursor = $pos;
	}

	function getCursor() {
		return $this->fetchCursor;
	}

	function resetCursor() {
		$this->setCursor(0);
	}

	function getFieldID($search_field) {
		if (!is_array($this->FieldNames)) return FALSE;
		foreach($this->FieldNames as $field_id => $field_name) {

			if (trim($search_field) == trim($field_name)) {
				return $field_id;
			}
		}
		return FALSE;
	}

	function echoCSVError() {
		foreach($this->CSVError as $pos => $error_str) {
			echo "- " . ($pos+1) . ". " . $error_str . "<br>";
		}
	}

	function isOK($error_output = TRUE) {
		if($error_output) $this->echoCSVError();
		return ((count($this->CSVError) > 0) ? FALSE : TRUE);
	}

	function array_merge_better($a1,$a2) {
		if(!is_array($a1)) $a1 = array();
		if(!is_array($a2)) $a2 = array();


		$newarray = $a1;

		while (list($key, $val) = each($a2)) {
			if (is_array($val) && is_array($newarray[$key])) {
				$newarray[$key] = $this->array_merge_better($newarray[$key], $val);
			}
			else {
				$newarray[$key] = $val;
			}
		}
		return $newarray;
	}

	function generateIniValue($array, $filename) {
		$handle = fopen($filename, "w");
		foreach ($array as $key=>$val) {
			fwrite($handle, "$key = $val;\n");
		}
		fclose($handle);
	}
}


class CSVImport extends CSV {
	var $FieldDelim;
	var $Enclosure;

	function CSVImport() {
		parent::CSV();
		$this->FieldDelim = ";";
	}

	function setDelim($delimiter) {
		if ($delimiter == "\\t") {
			$this->FieldDelim = "\t";
		}
		else if ($delimiter == "") {
			$this->FieldDelim = " ";
		}
		else {
			$this->FieldDelim = $delimiter;
		}
	}

	function setEnclosure($enclosure) {
		$this->Enclosure = $enclosure;
	}

	function parseCSV() {
		if ($this->CSVData) {
			$akt_line  = 0;
			$akt_field = 0;
			$akt_field_value = "";
			$last_char = "";
			$quote = 0;
			$field_input = 0;
			$head_complete = 0;

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

	function splitFile($path, $csv_fieldnames) {
		$num_files = 0;

		if ($this->isOK()) {
			$fieldnames = ($csv_fieldnames)? 0 : 1;
			$num_rows = $this->CSVNumRows();
			$num_fields = $this->CSVNumFields();
						
			createLocalFolder($path);

			for ($i = 0; $i < $num_rows + $fieldnames; $i++) {
				$data = "";
				$d[0] = $d[1] = "";
				for ($j = 0; $j < $num_fields; $j++) {
					$d[1] .= (!$fieldnames)?(($this->CSVFieldName($j) != "")?
						$this->Enclosure.str_replace($this->Enclosure,"\\".$this->Enclosure,$this->CSVFieldName($j)).$this->Enclosure:""):$this->Enclosure."f_".$j.$this->Enclosure;
					$d[0] .= ($fieldnames && $i==0)?
						(($this->CSVFieldName($j) != "")?$this->Enclosure.str_replace($this->Enclosure,"\\".$this->Enclosure,$this->CSVFieldName($j)).$this->Enclosure:""):
						(($this->Fields[(!$fieldnames)? $i : ($i-1)][$j] != "")?
							$this->Enclosure.str_replace($this->Enclosure,"\\".$this->Enclosure,$this->Fields[(!$fieldnames)? $i : ($i-1)][$j]).$this->Enclosure:"");
					if ($j+1 < $num_fields) {
						$d[1] .=  $this->FieldDelim;
						$d[0] .=  $this->FieldDelim;
					}
				}
				$data = implode("\n", $d);
				$hFile = fopen($path."/temp_".$i.".csv", "wb");
				fwrite($hFile, $data);
				fclose($hFile);
				$num_files++;
			}
			return $num_files;
		}
		else return FALSE;
	}

}

class CSVFixImport extends CSV {
	var $FieldLengths;

	function CSVFixImport() {
		parent::CSV();
		$this->FieldLengths = array();
	}

	function addCSVField($name, $length, $type = "") {
		$cursor = count($this->FieldNames);

		if(!$name) $name = "Feld " . ($cursor + 1);

		$this->FieldNames[$cursor] = $name;
		$this->FieldLengths[$cursor] = $length;
		$this->setFieldType($cursor, $type);
	}


	function setFile($file) {
		parent::setFile($file);
		$this->CSVData = explode("\n", trim($this->CSVData));
	}

	function parseCSV() {
		if ($this->CSVData) {
			if (!count($this->FieldLengths)) {
				$this->CSVError[] = "CSV fields undefined.";
				return FALSE;
			}

			$currentLine = 0;

			foreach($this->CSVData as $line) {
				$currentField = 0;
				$currentStringPos = 0;

				foreach($this->FieldLengths as $FieldLength) {
					$value = trim(substr($line, $currentStringPos, $FieldLength));

					$this->Fields[$currentLine][$currentField] = $value;
					$currentStringPos += $FieldLength;
					$currentField++;
				}

				$currentLine++;
			}

			parent::convertFieldType();
			parent::applyFilter();
			$this->fetchCursor = 0;
		}
		else {
			$this->CSVError[] = "No data for import set.";
			return FALSE;
		}
	}
}

?>