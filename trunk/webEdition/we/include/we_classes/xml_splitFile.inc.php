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


/**
* Class XML_SplitFile()
*
* This class offers methods to split a XML document using the XPath language.
* The xml document will be split into self-contained XML files.
*/
class XML_SplitFile extends XML_Parser {

	/**
	 * Number of exported XML files.
	 * @var        int
	 */
	var $fileId = 0;

	/**
	 * The path consists of the temporary directory and the uniqueId.
	 * @var        string
	 */
	var $path = "";

	/**
	 * Allow the file locking. This variable will be set to FALSE if the OS does
	 * not support file locking. This will surpress the file locking error for
	 * win 98 users when exportToFile() is called.
	 * @var        bool
	 */
	var $lockFile = TRUE;

	/**
	 * The indentation, i.e. number of whitespaces preceding the XML elements.
	 * @var        int
	 */
	var $indent = 4;

	/**
	 * Constructor of the class.
	 *
	 * This constructor initializes the class and when a file is given, tries to
	 * read and parse it. Otherwise, call the XML_Parser::getFile() method to
	 * load and parse a file.
	 *
	 * @param      string $file
	 * @see        XML_Parser::getFile()
	 */
	function XML_SplitFile($file = "") {
		if (!empty($file)) {
			// Read and try to parse the given file.
			$this->getFile($file);
		}
	}

	/**
	 * Split the given XML file into self-contained XML files whenever a child
	 * node is found. Make sure the XML document was already loaded by the
	 * parser before calling this method.
	 *
	 * @throws     FALSE on error
	 * @see        XML_Parser::parserHasContent(), XML_Parser::hasChildNodes(),
	 *             XML_Parser::evaluate(), getUniqueId(), exportAsXML()
	 */
	function splitFile($absoluteXPath="*/descendant::*", $start=false, $end=false, $dpth=1) {
		// Check if a XML file was loaded, either by the constructor or by the
		// getFile method.
		if (!$this->parserHasContent()) return FALSE;
		
		// Save the path consisting of the temporary directory and a unique id.
		$this->path = (defined("TMP_DIR"))? TMP_DIR : $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/tmp";
		$this->path .= "/".$this->getUniqueId();
		
		// Make the current directory.
		createLocalFolder($this->path);
		
		// Node-set with paths of the descendant nodes.
		$nodeSet = $this->evaluate($absoluteXPath);
		$desc = 0;
		
		// Run through the descendant nodes.
		foreach ($nodeSet as $node) {
			// Split the XML data at each node that has children.
			if ($this->hasChildNodes($node)) {
				$desc++;
				if ((!$start || ($desc>=$start)) && (!$end || ($desc<=$end))) {
					$xml = "";
					// Add the XML declaration.
					$xml .= "<?xml version=\"1.0\" " . ($this->mainXmlEncoding ? "encoding=\"" . $this->mainXmlEncoding . "\"" : "sandalone=\"yes\"") . "?>\n";
					// Add the XML data containing all nodes till to the given depth.
					$xml .= $this->exportAsXML($node, $dpth);				
					// Write the XML data to a file.
					$this->exportToFile($xml);
				}
			}
		}
	}

	/**
	 * Use the given node to generate and export self-contained XML data.
	 *
	 * @param      string $node
	 * @param      int $dpth
	 * @param      int $lvl
	 * @return     string The returned string contains the XML data
	 */
	function exportAsXML($node, $dpth, $lvl = 1) {
		$xml="";
		// Calculate the indentation.
		$indent = "";
		for($i=0; $i < (($lvl-1)*$this->indent); $i++) $indent .= " ";
		
		// Add the start tag of the new root element.
		$root = $this->nodes[$node];
		$xml .= $indent."<".$root["name"].$this->getAttributeString($root).">\n";
		
		// Run through the child nodes.
		foreach ($this->nodes[$node]["children"] as $tagname => $id) {
			
			// Run through all siblings with the same name.
			for ($sibl = 1; $sibl <= $id; $sibl++) {
				
				// Leave out the child nodes which will be processed in the
				// next call of this method.
				$absoluteXPath = $node."/".$tagname."[".$sibl."]";
				
				$sibling = $this->nodes[$absoluteXPath];
				if (!$this->hasChildNodes($absoluteXPath)) {

					// Add the additional indentation.
					for($i=0; $i < $this->indent; $i++) $xml .= " ";
					// Add the start tag of the element.
					$xml .= "<".$tagname.$this->getAttributeString($sibling);
					$hasText = $this->hasCdata($absoluteXPath);
					if ($hasText) {
						$xml .= ">";
						// Add the character data and insert it within a CDATA
						// section if necessary.
						$hasSection = $this->hasCdataSection($absoluteXPath);
						$text = stripslashes($sibling["data"]);
						$xml .= (!$hasSection)? $this->replaceEntities($text) : "<![CDATA[".$text."]]>";
						
						// Add the end tag of the element.
						if ($hasText) $xml .= "</".$tagname.">\n";
					}
					else {
						// Auto-close the tag.
						$xml .= "/>\n";
					}
				}
				else if ($dpth > $lvl) {
					$xml .= $this->exportAsXML($absoluteXPath, $dpth, $lvl+1)."\n";
				}
			}
		}
		// Add the end tag of the new root element.
		$xml .= $indent."</".$root["name"].">";
		
		return $xml;
	}

	/**
	 * Generates a XML file with the content of the current node of the XML
	 * document. The given parameter contains the XML node beeing modified by
	 * this class before.
	 *
	 * @param      string $data
	 * @throws     FALSE on error
	 * @see        exportAsXML()
	 */
	function exportToFile($data) {
		// The current file.
		$file = "temp_".$this->fileId.".xml";
		
		// Open the file.
		$hFile = fopen($this->path."/".$file, "wb");
		
		// Check if the file was opened correctly.
		if (!$hFile) return FALSE;
		else {
			// Acquire an exclusive lock.
			flock($hFile, LOCK_EX);
			
			// Write the xml data to the file.
			if (!fwrite($hFile, $data)) return FALSE;
			
			// Flush the output to the file.
			fflush($hFile);
			// Release the lock.
			flock($hFile, LOCK_UN);
			
			// Close the file.
			if (!fclose($hFile)) return FALSE;
		}
		// Increase the number of exported xml files.
		$this->fileId++;
	}

	/**
	 * Returns a unique code with the given length.
	 *
	 * @deprecated Use getUniqueId() instead
	 * @param      integer $len
	 * @return     string The returned string contains alphanumeric code
	 */
	 function getUniqueString($len = 8) {
	 	$str = "";
		$set = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$set .= "abcdefghijklmnopqrstuvwxyz";
		$set .= "0123456789";
		// Seed with microseconds since last 'whole' second.
		srand((double)microtime()*1234567);
		for($i = 0; $i < $len; $i++) {
			$str .= substr($set, (rand()%(strlen($set))), 1);
		}
		return $str;
	}

	/**
	 * Returns a random hex code consisting of 32 characters.
	 *
	 * @return     string The returned string contains hexadecimal code
	 */
	function getUniqueId() {
		// md5 encrypted hash with the start value microtime(). The function
		// uniqid prevents from simultanious access, within a microsecond.
		return md5(uniqid(microtime()));
	}

	/**
	 * Replaces the XML entities for not beeing recognized as markup. 
	 *
	 * @param      string $text
	 * @return     string
	 */
	function replaceEntities($text) {
		$text = str_replace("<","&lt;",$text);
		$text = str_replace(">","&gt;",$text);
		$text = str_replace("&nbsp;","&amp;nbsp;",$text);
		return $text;
	}

}

?>
