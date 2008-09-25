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


/**
* Class XML_Parser()
*
* This class offers methods to read and parse a XML document and to access the
* XML data by the XPath language.
*/
class XML_Parser {

	/**
	 * Name of the file to read and parse, used by the error handler.
	 * @var        string
	 */
	var $fileName = '';

	/**
	 * The absolute location path of the document root.
	 * @var        string
	 */
	var $root = '';

	/**
	 * This array contains information about the XML-declaration,
	 * DTD-declaration and the XML nodes.
	 * @var        array
	 */
	var $nodes = array();

	/**
	 * This array contains the absolute location paths of all nodes with
	 * different names and the number of nodes with the same name.
	 * @var        array
	 */
	var $nodeIds = array();

	/**
	 * The current location path.
	 * @var        string
	 */
	var $path = '';

	/**
	 * The current context position while traversing the xml document.
	 * @var        int
	 */
	var $position = 0;

	/**
	 * The current XPath expression.
	 * @var        string
	 */
	var $xPath = '';

	/**
	 * This array contains the XPath functions that can be evaluated by an
	 * XPath expression. XPath functions are composed of node-set functions,
	 * string functions, number functions and boolean functions.
	 * @var        array
	 */
	var $XPathFunctions = array(
	    'count', 'id', 'last', 'name', 'position',
	    'concat', 'contains', 'starts-with', 'string', 'string-length',
		'substring', 'substring-after', 'substring-before', 'translate',
		'ceiling', 'floor', 'number', 'round', 'sum',
        'boolean', 'false', 'lang', 'not', 'true'
	);

	/**
	 * This variable will be modified by the default handler when a CDATA
	 * section is being parsed.
	 * @var        int
	 */
	var $cdataSection = 0;

	/**
	 * Parse error.
	 * @var        string
	 */
	var $parseError = '';

	/**
	 * Allows only files with the extension xml if set to TRUE.
	 * @var        bool
	 */
	var $xmlExt = true;

	/**
	 * Defined if parser is used by backup
	 * @var        string
	 */
	var $mode = "exim";

	var $mainXmlEncoding = null;
	/**
	 * Constructor of the class.
	 * This constructor initializes the class and when a file is given,
	 * tries to read and parse it.
	 *
	 * @param      string $file
	 * @see        getFile()
	 */
	function XML_Parser($file = '') {
		if(!empty($file)) {
			// Read and try to parse the given file.
			$this->getFile($file);
		}
	}

	/**
	 * This method checks the given url or file and reads the XML data.
	 *
	 * @param      string $file
	 * @throws     FALSE on error
	 * @see        parserHasContent(), parseXML(), addWarning()
	 */
	function getFile($file,$force_encoding='') {
		// Save the file name which is used by the error handler.
		$f = pathinfo($file);
		$this->fileName = $f['basename'];
		// Check if the parser object has any content.
		if ($this->parserHasContent()) {
			//addWarning(ERROR_PARSER_OBJECT_HAS_CONTENT);
			return FALSE;
		}
		// Only permit files with the extension 'xml'.
		if ($this->xmlExt && strtolower($f['extension']) != 'xml') {
			//$this->addWarning(ERROR_FILE_EXTENSION, __LINE__, $this->fileName, $f['extension']);
			return FALSE;
		}
		// Check if the given parameter is a url.
		if (preg_match("/^(((f|ht){1}tp:\/\/)".
			"[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i", $file)) {
			// Read the content of the url.
			$data = @implode('', @file($file));			
			if (empty($data)) {
				//$this->addWarning(ERROR_FILE_EMPTY, __LINE__, $this->fileName);
				return FALSE;
			}
		}
		// Check if the file exists and is readable.
		else if (file_exists($file) && is_readable($file)) {
			// Read the file.
			$data = implode('', file($file));
		}
		else {
			if (!is_dir($file)) {
				//$this->addWarning(ERROR_FILE_NOT_FOUND, __LINE__, $this->fileName);
				return FALSE;
			}
			else {
				//$this->addWarning(ERROR_IS_DIR, __LINE__, $this->fileName);
				return FALSE;
			}
		}

		if(empty($force_encoding)) {
			
			$head = substr($data,0,250); 
			$encoding = $this->getEncoding('',$head);
			
		} else {

			$encoding = $force_encoding;

		}
		$this->mainXmlEncoding = $encoding;

		return $this->parseXML($data,$encoding);
	}

	/**
	 * This method tries to parse the content of the given string and on success
	 * stores the information retrieved into an array.
	 *
	 * @param      string $data
	 * @throws     FALSE on error
	 * @see        openElementHandler(), closeElementHandler(),
	 *             characterDataHandler(), defaultHandler(), addWarning()
	 */
	function parseXML($data,$charset='ISO-8859-1') {
		if (!empty($data)) {
			// Initialize the expat parser, resource id #5.
			$parser = xml_parser_create($charset);

			// Allow the parser to skip space characters.
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
			// Disable case-folding. When it comes to XML, case-folding means
			// uppercasing.
			xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);

			// Associate the expat parser with the class.
			xml_set_object($parser, $this);

			// Set expat callback functions.
			// Element events are issued whenever the XML parser encounters
			// opening or closing XML tags.
			xml_set_element_handler($parser, 'openElementHandler',
				'closeElementHandler');
			// Character data is all the non-markup contents of XML documents.
			xml_set_character_data_handler($parser,
				'characterDataHandler');
			// What doesn't go to another handler goes to the default handler.
			xml_set_default_handler($parser, 'defaultHandler');

			// Define the array of the document node.
			$this->nodes['xml-declaration'] = '';
			$this->nodes['dtd-declaration'] = '';

			// Add a warning and return FALSE if the parse was not successful.
			if (!xml_parse($parser, $data, TRUE)) {
				$this->parseError = xml_get_current_line_number($parser).
					xml_Error_string(xml_get_error_code($parser));
				return FALSE;
			}

			// All done, clean up.
			xml_parser_free($parser);
		}
		else {
			// Add a warning and return FALSE if the given string is empty.
			$this->addWarning(ERROR_XML_FILE_EMPTY, $this->fileName);
			return FALSE;
		}
	}

	/**
	 * Run when a opening XML tag is found while parsing. Adds the element name
	 * and attributes to the tree of document nodes.
	 *
	 * @param      resource $parser
	 * @param      string $elementName
	 * @param      array $attrs
	 * @see        parseXML(), appendChild(), setAttributes()
	 */
	function openElementHandler($parser, $elementName, $attrs) {
		// Add a new node to the tree of nodes.
		$this->path = $this->appendChild($this->path, $elementName);

		// Set the attributes.
		$this->setAttributes($this->path, $attrs);
	}

	/**
	 * Run when a closing XML tag is found while parsing.
	 *
	 * @param      resource $parser
	 * @param      string $elementName
	 * @see        parseXML()
	 */
	function closeElementHandler($parser, $elementName) {
		// Set the location path to the parent element.
		$this->path = substr($this->path, 0, strrpos($this->path, '/'));
	}

	/**
	 * Run when CDATA is found while parsing.
	 *
	 * @param      recource $parser
	 * @param      string $data
	 * @see        parseXML(), appendData()
	 */
	function characterDataHandler($parser, $data) {
		// Replace the entities.
		//$data = $this->replaceEntities($data); // auskommentiert v. Holeg

		// Add the character data.
		if($this->mode=="backup")
			$this->appendData($this->path, addslashes($data));
		else
			$this->appendData($this->path, addslashes(trim($data)));
	}

	/**
	 * All events not covered by the preceding handlers will be trapped and
	 * resolved by this handler.
	 *
	 * @param      recource $parser
	 * @param      string $data
	 * @see        parseXML()
	 */
	function defaultHandler($parser, $data) {
		do {
			if ($this->path) {
				// Increment the flag if the XML data contains a CDATA section.
				if (!strcmp($data, '<![CDATA[')) $this->cdataSection++;
				// Decrement the flag if the CDATA section is closed.
				else if (!strcmp($data, ']]>')) $this->cdataSection--;
				break;
			}

			// Add the DTD-declaration if the XML-declaration is processed.
			if (!empty($this->nodes['xml-declaration']) ) {
				$this->nodes['dtd-declaration'] .= $data;
				break;
			}

			// Add the XML-declaration.
			if (trim($data)) {
				preg_match_all('/ (\w+=".+")/U', $data, $matches);
				// Run through the attributes.
				foreach ($matches[1] as $match) {
					list($name, $value) = (explode('=', $match));
					$value = str_replace('"', '', $value);

					// Add this attribute to the XML-declaration.
					$this->nodes['xml-declaration'][$name] = $value;
				}
			}

		} while (FALSE);
	}

	/**
	 * This method returns FALSE if the object has no content. After a
	 * successfull parse TRUE will be returned.
	 *
	 * @return     TRUE if the object has content, FALSE if not
	 * @see        parseXML()
	 */
	function parserHasContent() {
		return (!empty($this->root)? TRUE : FALSE);
	}

	/**
	 * This method returns TRUE if the document node has child nodes.
	 *
	 * @param      string $absoluteXPath
	 * @return     TRUE if the document node has child nodes, FALSE if not
	 */
	function hasChildNodes($absoluteXPath) {
		if (!isset($this->nodes[$absoluteXPath]['children'])) return FALSE;
		return ((count($this->nodes[$absoluteXPath]['children']) > 0)? TRUE : FALSE);
	}

	/**
	 * This method returns FALSE if the object has no content. After a
	 * successfull parse TRUE will be returned.
	 *
	 * @return     TRUE if the object has content, FALSE if not
	 * @see        parseXML()
	 */
	function hasAttributes($absoluteXPath) {
		if (!isset($this->nodes[$absoluteXPath]['attributes'])) return FALSE;
		return ((count($this->nodes[$absoluteXPath]['attributes']) > 0)? TRUE : FALSE);
	}

	/**
	 * This method adds a new node to the tree of nodes of the XML document.
	 *
	 * @param      string $context
	 * @param      string $nodeName
	 * @return     string The new location path of the added node
	 * @see        openElementHandler()
	 */
	function appendChild($context, $nodeName) {
		// Check if a name for the document root is set.
		if (empty($this->root)) {
			// Save this tag as the document root.
			$this->root = '/'.$nodeName.'[1]';
		}

		// The location path for this element.
		$path = $context.'/'.$nodeName;

		// Set the position and the relative context.
		if (!isset($this->nodeIds[$path])) $this->nodeIds[$path] = 0;
		$position = ++$this->nodeIds[$path];
		$relative = $nodeName.'['.$position.']';

		// Set the new location path.
		$newPath = $context.'/'.$relative;

		// Set the context position, which is the position of this element
		// within elements of the same name in the parent node.
		$this->nodes[$newPath]['context-position'] = $position;

		// Set the position for the following and preceding axis.
		if (!isset($this->nodes[$context]['document-position']))
			$this->nodes[$context]['document-position'] = 0;

		$this->nodes[$newPath]['document-position'] =
			$this->nodes[$context]['document-position'] + 1;

		// Save the information about the node.
		$this->nodes[$newPath]['name'] = $nodeName;
		$this->nodes[$newPath]['data'] = '';
		$this->nodes[$newPath]['cdata-section'] = 0;
		$this->nodes[$newPath]['parent'] = $context;

		// Add this element to the element count array.
		if (!isset($this->nodes[$context]['children'][$nodeName]))
			$this->nodes[$context]['children'][$nodeName] = 0;

		if (!$this->nodes[$context]['children'][$nodeName]) {
			// Set the default name.
			$this->nodes[$context]['children'][$nodeName] = 1;
		}
		else {
			// Calculate the name.
			$this->nodes[$context]['children'][$nodeName] =
				$this->nodes[$context]['children'][$nodeName] + 1;
		}

		return $newPath;
	}

	/**
	 * This method removes a node from the tree of nodes of the XML document.
	 *
	 * @param      string $absoluteXPath
	 */
	function removeChild($absoluteXPath) {
		// Check if the node is an attribute node.
		if (ereg("/attribute::", $node)) {
			// Get the location path to the attribute nodes' parent.
			$parent = $this->prestr($node, '/attribute::');

			// Get the name of the attribute.
			$attribute = $this->poststr($node, '/attribute::');

			// Check if the attribute exists.
			if (isset($this->nodes[$parent]['attributes'][$attribute])) {
				$new = array();

				// Run through the existing attributes.
				foreach ($this->nodes[$parent]['attributes'] as $key => $value) {
					// Check if the attribute should be removed.
					if ($key != $attribute) {
						// Add it to the new array again.
						$new[$key] = $value;
					}
				}

				// Save the new attributes.
				$this->nodes[$parent]['attributes'] = $new;
			}
		}
		else {
			// Nodes to be renamed.
			$rename = array();

			// Get the name, the parent and the siblings of the current node.
			$name = $this->nodes[$node]['name'];
			$parent = $this->nodes[$node]['parent'];
			$siblings = $this->nodes[$parent]['children'][$name];

			// Decrease the number of children.
			$this->nodes[$parent]['children'][$name]--;
			$counter = 1;

			// Run through the siblings.
			for ($i = 1; $i <= $siblings; $i++) {
				// Name of the sibling.
				$sibling = $parent.'/'.$name.'['.$i.']';

				// Check if it is the name of the current node.
                if ($sibling != $node) {
					// New name for the sibling.
					$new = $parent.'/'.$name.'['.$counter.']';

					$counter++;

					// Add the old and new name to the list of nodes
					// to be renamed.
					$rename[$sibling] = $new;
				}
			}

			$nodes = array();

			// Run through the existing nodes.
			foreach ($this->nodes as $name => $values) {
				// Check the position of the path of the node to be deleted
				// in the path of the current node.
				$position = strpos($name, $node);

				// Check if it is not the node to be deleted.
				if ($position === FALSE) {
					// Run through the array of nodes to be renamed.
                    foreach ($rename as $old => $new) {
						// Rename this node and its' parent if necessary.
						$name = str_replace($old, $new, $name);
						$values['parent'] = str_replace($old, $new,
							$values['parent']);
					}

					// Add the node to the list of nodes.
					$nodes[$name] = $values;
				}
			}

			// Save the new array of nodes.
			$this->nodes = $nodes;
		}
	}

	/**
	 * This method returns TRUE if the node has CDATA, i.e. text that does not
	 * form markup.
	 *
	 * @param      string $absoluteXPath
	 * @return     TRUE if the node has CDATA, FALSE if not
	 */
	function hasCdata($absoluteXPath) {
		return (($this->nodes[$absoluteXPath]['data'] != '')? TRUE : FALSE);
	}

	/**
	 * This method returns TRUE if the CDATA of the node has a CDATA section.
	 *
	 * @param      string $absoluteXPath
	 * @return     TRUE if CDATA has a CDATA section, FALSE if not
	 */
	function hasCdataSection($absoluteXPath) {
		if (!isset($this->nodes[$absoluteXPath])) return FALSE;
		return (($this->nodes[$absoluteXPath]['cdata-section'] > 0)? TRUE : FALSE);
	}

	/**
	 * This method adds content to a node.
	 *
	 * @param      string $absoluteXPath
	 * @param      string $value
	 */
	function appendData($absoluteXPath, $value) {
		// Check if it is an attribute node.
		if (ereg("/attribute::", $absoluteXPath)) {
			// Get the path to the attribute node's parent.
			$parent = $this->prestr($absoluteXPath, '/attribute::');

			// Get the parent node.
			$parent = $this->nodes[$parent];

			// Get the name of the attribute.
			$attribute = $this->poststr($absoluteXPath, '/attribute::');

			// Set the attribute.
			$parent['attributes'][$attribute] .= $value;
		}
		else {
			// Set the character data of the node.
			$this->nodes[$absoluteXPath]['data'] .= $value;
			if ($this->nodes[$absoluteXPath]['cdata-section']!=1) {
				$this->nodes[$absoluteXPath]['cdata-section'] = $this->cdataSection;
			}
		}
	}

	/**
	 * This method replaces the content of a node.
	 *
	 * @param      string $absoluteXPath
	 * @param      string $value
	 */
	function replaceData($absoluteXPath, $value) {
		// Check if it is an attribute node.
		if (ereg("/attribute::", $absoluteXPath)) {
			// Get the path to the attribute node's parent.
			$parent = $this->prestr($absoluteXPath, '/attribute::');

			// Get the parent node.
			$parent = $this->nodes[$parent];

			// Get the name of the attribute.
			$attribute = $this->poststr($absoluteXPath, '/attribute::');

			// Set the attribute.
			$parent['attributes'][$attribute] = $value;
		}
		else {
			// Set the character data of the node.
			$this->nodes[$absoluteXPath]['data'] = $value;
		}
	}

	/**
	 * This method retrieves dependend on the given absolute XPath either the
	 * character data of a node if necessary including a CDATA section or the
	 * value of the attribute.
	 *
	 * @param      string $absoluteXPath
	 */
	function getData($absoluteXPath) {
		// Check if the given absolute XPath is an attribute node.
		if (ereg("/attribute::", $absoluteXPath)) {
			// Retrieve the absolute XPath to the attributes' parent node.
			$absoluteXPathParent = $this->prestr($absoluteXPath, '/attribute::');

			// Store the information about the parent node into an array.
			$parentNode = $this->nodes[$absoluteXPathParent];

			// Get the attribute name.
			$attributeName = $this->poststr($absoluteXPath, '/attribute::');

			// Retrieve the value of the attribute.
			$attributeValue = $parentNode['attributes'][$attributeName];

			return $attributeValue;
		}
		else {
			// Return the character data of the node.
			return stripslashes(isset($this->nodes[$absoluteXPath]['data']) ? $this->nodes[$absoluteXPath]['data'] : "");
		}
	}

	/**
	 * Adds attributes to a node. Existing attributes will not be overwritten.
	 *
	 * @param      string $absoluteXPath
	 * @param      array $attributes
	 */
	function addAttributes($absoluteXPath, $attributes) {
		// Add the attributes to the node.
		$this->nodes[$absoluteXPath]['attributes'] = array_merge($attributes,
			$this->nodes[$absoluteXPath]['attributes']);
	}

	/**
	 * Sets the attributes of a node and owerwrites existing attributes.
	 *
	 * @param      string $absoluteXPath
	 * @param      array $attributes
	 */
	function setAttributes($absoluteXPath, $attributes) {
		// Set the attributes of the node.
		$this->nodes[$absoluteXPath]['attributes'] = $attributes;
	}

	/**
	 * Returns a list of all attributes of a node.
	 *
	 * @param      string $absoluteXPath
	 * @return     array The array of attributes
	 */
	function getAttributes($absoluteXPath) {
		// Return all attributes of the node.
		return $this->nodes[$absoluteXPath]['attributes'];
	}

	/**
	 * Returns a string with the elements' attributes.
	 *
	 * @param      array $element
	 * @return     string The returned string contains the attributes
	 */
	function getAttributeString($element) {
		$attrString = '';
		if (count($element['attributes']) > 0) {
			// Add each attribute name and value.
			while (list($name, $value) = each($element['attributes'])) {
				$attrString .= ' '.$name.'="'.$value.'"';
			}
		}
		return $attrString;
	}

	/**
	 * Returns the name of the document node.
	 *
	 * @param      string $absoluteXPath
	 * @return     string Name of the node
	 */
	function nodeName($absoluteXPath) {
		// Name of the node.
		return isset($this->nodes[$absoluteXPath]['name']) ? $this->nodes[$absoluteXPath]['name'] : "";
	}

	/**
	 * This method evaluates an XPath expression.
	 *
	 * @param      string $xPath
	 * @param      string $context
	 * @return     array Returns the evaluated node-set
	 */
	function evaluate($xPath, $context = '') {
		// Remove slashes, single and double quotes.
		$xPath = stripslashes($xPath);
		$xPath = str_replace('"', '', $xPath);
		$xPath = str_replace("'", '', $xPath);

		// Split the paths that are separated by a '|' character.
		$xPaths = $this->splitPaths($xPath);

		$nodeSet = array();

		// Run through all paths.
		foreach ($xPaths as $xPath) {
			// Trim the path.
			$xPath = trim($xPath);

			// Save the current path.
			$this->xPath = $xPath;

			// Replace all entities.
			if(!function_exists("rhtmlentities")) {
				$xPath = $this->replaceEntities($xPath);
			} else {
				$xPath = rhtmlentities($xPath);
				
			}

			// Split the XPath at every slash.
			$steps = $this->splitSteps($xPath);

			// Removes the first element if it is empty.
			if (empty($steps[0])) array_shift($steps);

			// Start to evaluate the steps.
			$nodes = $this->evaluateStep($context, $steps);

			// Remove double entries.
			$nodes = array_unique($nodes);

			// Add the nodes to the result.
			$nodeSet = array_merge($nodeSet, $nodes);
		}

		return $nodeSet;
	}

	/**
	 * Splits an XPath expression into several expressions. Expressions can be
	 * separated by a pipe '|'.
	 *
	 * @param      string $expression
	 * @return     array
	 * @see        evaluate(), inString()
	 */
	function splitPaths($expression) {
		$paths = array();

		// Define the position of the pipe '|'. The expression will be split into
		// a left and right part at this position.
		$splitPos = -1;

		// Split the expression.
		do {
			// The position of the pipe '|' or -1.
			$splitPos = $this->inString($expression, '|');

			// Check if a pipe '|' was found.
			if ($splitPos >= 0) {
				// Extract the left and right part of the expression.
				$left  = substr($expression, 0, $splitPos);
				$right = substr($expression, $splitPos+1);

				// Add the left part to the paths array.
				$paths[] = $left;

				// The new expression now contains the right part.
				$expression = $right;
			}
		}
		while ($splitPos > -1);

		// Add the remaining expression to the paths array.
		$paths[] = $expression;

		return $paths;
	}

	/**
	 * Splits an XPath expression. Each expression can consist of a list of steps
	 * seperated by a slash '/'.
	 *
	 * @param      string $expression
	 * @return     array
	 * @see        evaluate(), inString()
	 */
	function splitSteps($expression) {
		$steps = array();

		// Replace double slashes.
		$expression = str_replace("//@", "/descendant::*/@", $expression);
		$expression = str_replace("//", "/descendant::", $expression);

		// Define the position of the slash '/'. The expression will be split into
		// a left and right part at this position.
		$splitPos = -1;

		// Split the expression.
		do {
			// The position of the slash '/' or -1.
			$splitPos = $this->inString($expression, '/');

			// Check if a '/' character was found.
			if ($splitPos >= 0) {
				// Extract the left and right part of the expression.
				$left  = substr($expression, 0, $splitPos);
				$right = substr($expression, $splitPos+1);

				// Add the left substring to the steps.
				$steps[] = $left;

				// The new expression now contains the right part.
				$expression = $right;
			}
		}
		while($splitPos > -1);

		// Add the remaining expression to the steps array.
		$steps[] = $expression;

		return $steps;
	}

	/**
	 * This method retrieves the axis information from the XPath expression step.
	 * The axis defines the relationship between the current node and the nodes
	 * to be selected.
	 *
	 * @param      string $step
	 * @param      string $node
	 * @see        evaluateStep(), prestr(), poststr(), inString(), isMethod()
	 */
	function getAxis($step, $node) {
		// This array contains the XPath axes defined in the XPath specification.
		$axesSpecifiers = array(
			'self', 'parent', 'child', 'attribute', 'ancestor', 'descendant',
			'ancestor-or-self', 'descendant-or-self', 'following-sibling',
			'preceding-sibling', 'following', 'preceding', 'namespace'
		);

		$axis = array(
			'axis'      => '',
			'node-test' => '',
			'predicate' => array()
		);

		// Check if there are predicates.
		if (ereg("\[", $step)) {
			// Get the predicates.
			$predicates = substr($step, strpos($step, '['));

			// Reduce the step.
			$step = $this->prestr($step, '[');

			// Split the predicates.
			$predicates = str_replace('][', ']|[', $predicates);
			$predicates = explode('|', $predicates);

			// Run through all predicates.
			foreach ($predicates as $predicate) {
				// Remove the brackets.
				$predicate = substr($predicate, 1, strlen($predicate)-2);

				// Add the predicate to the list of predicates.
				$axis['predicate'][] = $predicate;
			}
		}

		// Check if the axis is given in plain text.
		if ($this->inString($step, '::') > -1) {
			// Split the step to extract the axis and the node-test.
			$axis['axis']      = $this->prestr($step, '::');
			$axis['node-test'] = $this->poststr($step, '::');
		}
		else {
			// Check if the step is empty.
			if (empty($step)) {
				// Set it to the default value.
				$step = '.';
			}

			// Check if it is an abbreviated syntax.
			if ($step == '*') {
				// Use the child axis and select all children.
				$axis['axis']      = 'child';
				$axis['node-test'] = '*';
			}
			else if (ereg("\(", $step)) {
				// Check if it is a method.
				if ($this->isMethod($this->prestr($step, '('))) {
					// Get the position of the first bracket.
					$start = strpos($step, '(');
					$end   = strpos($step, ')', $start);

					// Get everything before, between and after the brackets.
					$before  = substr($step, 0, $start);
					$between = substr($step, $start+1, $end - $start-1);
					$after   = substr($step, $end+1);

					// Trim each string.
					$before  = trim($before);
					$between = trim($between);
					$after   = trim($after);

					// Save the evaluated function.
					$axis['axis']      = 'method';
					$axis['node-test'] = $this->evaluateMethod($before, $between,
						$node);
				}
				else {
					// Use the child axis and a function.
					$axis['axis']      = 'child';
					$axis['node-test'] = $step;
				}
			}
			else if (eregi('^@', $step)) {
				// Use the attribute axis and select the attribute.
				$axis['axis']      = 'attribute';
				$axis['node-test'] = substr($step, 1);
			}
			else if (eregi('\]$', $step)) {
				// Use the child axis and select a position.
				$axis['axis']      = 'child';
				$axis['node-test'] = substr($step, strpos($step, '['));
			}
			else if ($step == '.') {
				// Select the self axis.
				$axis['axis']      = 'self';
				$axis['node-test'] = '*';
			}
			else if ($step == '..') {
				// Select the parent axis.
				$axis['axis']      = 'parent';
				$axis['node-test'] = '*';
			}
			else if (ereg("^[a-zA-Z0-9\_-]+$", $step)) { 
				// Select the child axis and the child.
				$axis['axis']      = 'child';
				$axis['node-test'] = $step;
			}
			else {
				// Use the child axis and a name.
				$axis['axis']      = 'child';
				$axis['node-test'] = $step;
			}
		}

		// Check if the axis specifier exists.
		if (!in_array($axis['axis'], array_merge($axesSpecifiers,
			array('method')))) {
				//$this->error_handler($l_xml_xpath['TYPE'].
				//	$l_xml_xpath['AXIS_UNDEF'], $axis['axis'], $step);
				return FALSE;
		}

		return $axis;
	}

	/**
	 * This method searches a string within another string outside of brackets.
	 *
	 * @param      string $term
	 * @param      string $expression
	 * @throws     FALSE on error
	 * @return     int Returns -1 if no string was found, otherwise the position
	 *             the string was found is returned.
	 * @see        splitPaths(), splitSteps(), getAxis(), evaluatePredicate()
	 */
	function inString($term, $expression) {
		// The number of brackets.
		$brackets = 0;

		// Run through each character.
		for ($pos = 0; $pos < strlen($term); $pos++) {
			// Character at the current position.
			$char = substr($term, $pos, 1);

			// Check if char is a bracket.
			if (($char == '(') || ($char == '[')) {
				// Increase the number of brackets.
				$brackets++;
			}
			else if (($char == ')') || ($char == ']')) {
				// Decrease the number of brackets.
				$brackets--;
			}
			else if ($brackets == 0) {
				// Check if the term contains an expression at the current
				// position.
				if (substr($term, $pos, strlen($expression)) == $expression) {
					// Return the position.
					return $pos;
				}
			}
		}

		// Check the number of opening and closing brackets.
		if ($brackets != 0) {
			//$this->error_handler($l_xml_xpath['TYPE'].
			//	$l_xml_xpath['BRACKET_MISMATCH'], $term);
			return FALSE;
		}

		return (-1);
	}

	/**
	 * Check if the expression contains a defined name of an XPath method.
	 *
	 * @param      string $expression
	 * @see        evaluatePredicate(), getAxis()
	 */
	function isMethod($expression) {
		if (in_array($expression, $this->XPathFunctions)) return TRUE;
		else return FALSE;
	}

	/**
	 * Evaluate the step of the XPath expression at a specific context.
	 *
	 * @param      string $context
	 * @param      string $steps
	 * @see
	 */
	function evaluateStep($context, $steps) {
		$nodes = array();

		// Check if the context is an array of contexts.
		if (is_array($context)) {
			// Run through the array.
			foreach ($context as $path) {
				// Call this method for this single path.
				$nodes = array_merge($nodes,
					$this->evaluateStep($path, $steps));
			}
		}
		else {
			// Get this step.
			$step = array_shift($steps);

			$contexts = array();

			// Get the axis of the current step.
			$axis = $this->getAxis($step, $context);

			// Check if it is a function.
			if ($axis['axis'] == 'function') {
				// Check if an array was returned.
				if (is_array($axis['node-test'])) {
					// Add the results to the list of contexts.
					$contexts = array_merge($contexts, $axis['node-test']);
				}
				else {
					// Add the result to the list of contexts.
					$contexts[] = $axis['node-test'];
				}
			}
			else {
				// The name of the method.
				$method = 'execAxis_'.str_replace('-', '_', $axis['axis']);

				// Check if the axis method is defined.
				if (!method_exists($this, $method)) {
					//$this->error_handler($l_xml_xpath['TYPE'].
					//	$l_xml_xpath['AXIS_NOT_IMPL'], $axis['axis']);
					return FALSE;
				}

				// Perform an axis action.
				$contexts = call_user_func(array(&$this, $method), $axis, $context);

				// Check if there are predicates.
				if (count($axis['predicate']) > 0) {
					// Check if each node fits the predicates.
					$contexts = $this->checkPredicates($contexts,
						$axis['predicate']);
				}
			}

			// Check if there are more steps left.
			if (count($steps) > 0) {
				// Continue the evaluation with the next steps.
				$nodes = $this->evaluateStep($contexts, $steps);
			}
			else {
				// Save contexts to the list of nodes.
				$nodes = $contexts;
			}
		}

		return $nodes;
	}

	/**
	 * Evaluates a given XPath method with its arguments on a specific node of
	 * the document.
	 *
	 * @param      string $function
	 * @param      array $args
	 * @param      array $node
	 * @see
	 */
	function evaluateMethod($function, $args, $node) {
		// Remove the whitespaces.
		$function  = trim($function);
		$args = trim($args);

		// Name of the method exec_method.
		$method = 'execMethod_'.str_replace('-', '_', $function);

		// Check if the method exec_method is defined.
		if (!method_exists($this, $method)) {
			//$this->error_handler($l_xml_xpath['TYPE'].
			//	$l_xml_xpath['FUNC_UNDEF'], $function);
			return FALSE;
		}

		// Return the result of the method.
		return call_user_func(array(&$this, $method),  $node, $args);
	}

	/**
	 * This method evaluates a predicate on a given node.
	 *
	 * @param      string $node
	 * @param      string $predicate
	 * @see
	 */
	function evaluatePredicate($node, $predicate) {
		$operators	= array(' or ', ' and ', '=', '!=', '<=', '<', '>=', '>',
			'+', '-', '*', ' div ', ' mod ');
		$operator = '';
		$position = 0;
		
		// Run through all operators.
		foreach ($operators as $expression) {
			// Check if a position was already found.
			if ($position <= 0) {
				// Try to find the operator.
				$position = $this->inString($predicate, $expression);

				// Check if an operator was found.
				if ($position > 0) {
					// Save the operator.
					$operator = $expression;

					// Check if it is the equal operator.
					if ($operator == '=') {
						// Also look for other operators containing the equal
						// sign.
						if ($this->inString($predicate, '!=') ==
							($position-1)) {
							// Get the new position.
							$position = $this->inString($predicate, '!=');

							// Save the new operator.
							$operator = '!=';
						}
						if ($this->inString($predicate, '<=') ==
							($position-1)) {
							// Get the new position.
							$position = $this->inString($predicate, '<=');

							// Save the new operator.
							$operator = '<=';
						}
						if ($this->inString($predicate, '>=') ==
							($position-1)) {
							// Get the new position.
							$position = $this->inString($predicate, '>=');

							// Save the new operator.
							$operator = '>=';
						}
					}
				}
			}
		}

		// Check if the operator is a '-' sign.
		if ($operator == '-') {
			// Check if it is not a method containing a '-' sign.
			foreach ($this->XPathFunctions as $function) {
				// Check if there is a - sign in the function name.
				if (ereg("-", $function)) {
					// Get the position of the - in the function name.
					$sign = strpos($function, '-');

					// Extract a substring from the predicate.
					$sub = substr($predicate, $position - $sign,
						strlen($function));

					// Check if it is the function.
					if ($sub == $function) {
						// Don't use the operator.
						$operator = '';
						$position = -1;
					}
				}
			}
		}
		else if ($operator == '*') {
			$character = substr($predicate, $position-1, 1);
			$attribute = substr($predicate, $position-11, 11);

			// Check if it is an attribute selection.
			if (($character == '@') || ($attribute == 'attribute::')) {
				// Don't use the operator.
				$operator = '';
				$position = -1;
			}
		}

		// Check if an operator was found.
		if ($position > 0) {
			// Get the left and the right part of the expression.
			$left  = substr($predicate, 0, $position);
			$right = substr($predicate, $position + strlen($operator));

			// Remove the whitespaces.
			$left  = trim($left);
			$right = trim($right);

			// Evaluate the left and the right part.
			$left  = $this->evaluatePredicate($node, $left);
			$right = $this->evaluatePredicate($node, $right);

			// check the kind of operator.
			switch($operator) {
				case ' or ':
					// Return the two results connected by an 'or'.
					return ($left or $right);

				case ' and ':
					// Return the two results connected by an 'and'.
					return ($left + $right);

				case '=':
					// Compare the two results.
					return ($left == $right);

				case '!=':
					// Check if the two results are not equal.
					return ($left != $right);

				case '<=':
					// Compare the two results.
					return($left <= $right);

				case '<':
					// Compare the two results.
					return ($left < $right);

				case '>=':
					// Compare the two results.
					return ($left >= $right);

				case '>':
					// Compare the two results.
					return ($left > $right);

				case '+':
					// Return the result by adding one result to the other.
					return ($left + $right);

				case '-':
					// Return the result by decreasing one result by the other.
					return ($left - $right);

				case '*':
					// Return a multiplication of the two results.
					return ($left * $right);

				case ' div ':
					// Return a division of the two results.
					if ($right == 0) {
						//$this->error_handler($l_xml_xpath['TYPE'].
						//	$l_xml_xpath['DIV_BY_ZERO'], $predicate);
						return FALSE;
					}
					else {
						// Return the result of the division.
						return ($left / $right);
					}
				break;

				case ' mod ':
					// Return the modulo of the two results.
					return ($left % $right);
			}
		}

		// Check if the predicate is a function.
		if (ereg("\(", $predicate)) {
			// Get the position of the first bracket.
			$start = strpos($predicate, '(');
			$end   = strpos($predicate, ')', $start);

			// Get everything before, between and after the brackets.
			$before  = substr($predicate, 0, $start);
			$between = substr($predicate, $start+1, $end-$start-1);
			$after   = substr($predicate, $end+1);

			// Trim each string.
			$before  = trim($before);
			$between = trim($between);
			$after   = trim($after);

			// Check if there is text after the bracket.
			if (!empty($after)) {
				//$this->error_handler($l_xml_xpath['TYPE'].
				//	$l_xml_xpath['JUNK_AFTER_BRACKET'], $predicate);
				return FALSE;
			}

			// Check if it is a function.
			if (empty($before) && empty($after)) {
				// Evaluate the content within the brackets.
				return $this->evaluatePredicate($node, $between);
			}
			else if ($this->isMethod($before)) {
				// Return the evaluated method.
				return $this->evaluateMethod($before, $between, $node);
			}
			else {
				//$this->error_handler($l_xml_xpath['TYPE'].
				//	$l_xml_xpath['FUNC_UNDEF_IN_EXPR'],
				//	$before, $this->xPath);
				return FALSE;
			}
		}

		// Check if the predicate is a digit.
		if (ereg("^[0-9]+(\.[0-9]+)?$", $predicate) ||
			ereg("^\.[0-9]+$", $predicate)) {
			// Return the value of the digit.
			return doubleval($predicate);
		}

		// Examine if it is an XPath expression.
		$result = $this->evaluate($predicate, $node);
		if (count($result) > 0) {
			// Convert the array.
			$result = explode('|', implode('|', $result));

			// Get the value of the first result.
			$value = $this->getData($result[0]);

			return $value;
		}

		return $predicate;
	}

	/**
	 * This method checks if the given list of nodes match the list of
	 * predicates passed to this method.
	 *
	 * @param      array $nodes
	 * @param      array $predicates
	 * @see        evaluateStep(), evaluatePredicate(), execMethod_position()
	 */
	function checkPredicates($nodes, $predicates) {
		$result = array();

		// Run through the list of nodes.
		foreach ($nodes as $node) {
			// Add this node to the nodes.
			$add = TRUE;

			// Run through the list of predicates.
			foreach ($predicates as $predicate) {
				// Check if the predicate is a number.
				if (ereg("^[0-9]+$", $predicate)) {
					// Enhance the predicate.
					$predicate .= '=position()';
				}

				// Evaluate the predicate.
				$check = $this->evaluatePredicate($node, $predicate);

				// Check if it is a string.
				if (is_string($check) && (($check == '') ||
					($check == $predicate))) {
					$check = FALSE;
				}

				// Check if it is an integer.
				if (is_int($check)) {
					// Check if it is the current position.
					if ($check == $this->execMethod_position($node, ''))
						$check = TRUE;
					else $check = FALSE;
				}

				// Check if the predicate is ok for this node.
				$add = $add && $check;
			}

			// Check if this node should be added to the list of nodes.
			if ($add) {
				// Add the node to the list of nodes.
				$result[] = $node;
			}
		}

		return $result;
	}

	/**
	 * This method checks if a node matches a given node-test.
	 *
	 * @param      string $context
	 * @param      string $nodeTest
	 * @return     bool TRUE if the node matches the node-test, FALSE if not.
	 * @see        execAxis_child(), execAxis_parent(), execAxis_self(),
	 *             execAxis_descendant(), execAxis_ancestor(),
	 *             execAxis_following(), execAxis_preceding(),
	 *             execAxis_following_sibling(), execAxis_preceding_sibling(),
	 *             prestr(), poststr(), addWarning()
	 */
	function checkNodeTest($context, $nodeTest) {
		// Check if it is a method.
		if (ereg("\(", $nodeTest)) {
			// Get the type of method to use.
			$method = $this->prestr($nodeTest, '(');

			// Check if the node suits the method.
			switch($method) {
				case 'node':
					// Add this node to the list of nodes.
					return TRUE;

				case 'text':
					// Check if the node contains text.
					if (!empty($this->nodes[$context]['data'])) {
						// Add this node to the list of nodes.
						return TRUE;
					}
				break;

				case 'comment':
					// Check if the node contains comments.
					if (!empty($this->nodes[$context]['comment'])) {
						// Add this node to the list of nodes.
						return TRUE;
					}
				break;

				case 'processing-instruction':
					// Get the literal argument.
					$literal = $this->poststr($axis['node-test'], '(');

					// Cut off the literal.
					$literal = substr($literal, 0, strlen($literal) - 1);

					// Check if a literal is given.
					if (!empty($literal)) {
						// Check if the nodes' processing instructions match
						// the literals
						if ($this->nodes[$context]['processing-instructions'] ==
							$literal) {
							// Add this node to the list of nodes.
							return TRUE;
						}
					}
					else {
						// Check if the node has processing instructions.
						if (!empty($this->nodes[$context]
							['processing-instructions'])) {
							// Add this node to the list of nodes.
							return TRUE;
						}
					}
				break;

				default:
					//$this->error_handler($l_xml_xpath['TYPE'].
					//	$l_xml_xpath['FUNC_UNDEF_IN_EXPR'],
					//	$method, $this->xpath);
					return FALSE;
			}
		}
		else if ($nodeTest == '*') {
			// Add this node to the list of nodes.
			return TRUE;
		}
		else if (ereg("^[a-zA-Z0-9\_-]+", $nodeTest)) { // bugfix #1665 for php 4.1.2: "-" moved to the end of the regex-pattern
			// Check if the node-test is succesfull.
			if ($this->nodes[$context]['name'] == $nodeTest) {
				// Add this node to the list of nodes.
				return TRUE;
			}
		}
		else {
			//$this->error_handler($l_xml_xpath['TYPE'].
			//	$l_xml_xpath['EMPTY_NODE_TEST'], $this->xPath);
			return FALSE;
		}

		return FALSE;
	}

	////////////////////////////////////////////////////////////////////////////
	// Methods that handle the XPath axes defined by the XPath specification.
	//
	// An axis defines the relationship between the current node and the nodes
	// to be selected - whether, for example, they are children of the current
	// node, siblings of the current node, or the parent of the current node.

	/**
	 * This method handles the XPath 'self' axis. The 'self' axis refers to the
	 * context node itself.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	 function execAxis_self($axis, $contextNode) {
		$selectedNodes = array();

		// Check if the context matches the node-test.
		if ($this->checkNodeTest($contextNode, $axis['node-test'])) {
			// Add this node to the list of selected nodes.
			$selectedNodes[] = $contextNode;
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'parent' axis. The 'parent' axis selects
	 * the parent of the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	function execAxis_parent($axis, $contextNode) {
		$selectedNodes = array();

		// Check if the parent matches the node-test.
		if ($this->checkNodeTest($this->nodes[$contextNode]['parent'],
			$axis['node-test'])) {
			// Add this node to the list of selected nodes.
			$selectedNodes[] = $this->nodes[$contextNode]['parent'];
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'child' axis. The 'child' axis selects the
	 * children of the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	 function execAxis_child($axis, $contextNode) {
		$selectedNodes = array();

		// Get a list of all children.

		if(isset($this->nodes[$contextNode]['children'])) $children = $this->nodes[$contextNode]['children'];

		// Check if there are children.
		if (!empty($children)) {
			// Run through all children.
			foreach ($children as $childName => $childPosition) {
				// Run through all children with the same name.
				for ($i = 1; $i <= $childPosition; $i++) {
					// The path of the child node.
					$child = $contextNode.'/'.$childName.'['.$i.']';

					if ($this->checkNodeTest($child, $axis['node-test'])) {
						// Add the child to the list of selected nodes.
						$selectedNodes[] = $child;
					}
				}
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method executes the XPath attribute. The 'attribute' axis refers to
	 * the attributes of the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	 function execAxis_attribute($axis, $contextNode) {
		$selectedNodes = array();

		// Check if all nodes should be selected.
		if ($axis['node-test'] == '*') {
			// Check if there are attributes.
			if (count($this->nodes[$contextNode]['attributes']) > 0) {
				// Run through the attributes.
				foreach ($this->nodes[$contextNode]['attributes'] as
					$key => $value) {
					// Add this node to the list of selected nodes.
					$selectedNodes[] = $contextNode.'/attribute::'.$key;
				}
			}
		}
		else if (!empty($this->nodes[$contextNode]['attributes']
			[$axis['node-test']])) {
			// Add this node to the list of selected nodes.
			$selectedNodes[] = $contextNode.'/attribute::'.$axis['node-test'];
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'ancestor' axis. The 'ancestor' axis selects
	 * the parent, grandparent, great-grandparent and all other ancestors of the
	 * context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest(), execAxis_ancestor()
	 */
	 function execAxis_ancestor($axis, $contextNode) {
		$selectedNodes = array();

		// Get the parent of the current node.
		$parent = $this->nodes[$contextNode]['parent'];

		// Check if the parent is not empty.
		if (!empty($parent)) {
			// Check if the parent matches the node-test.
			if ($this->checkNodeTest($parent, $axis['node-test'])) {
				// Add the parent to the list of selected nodes.
				$selectedNodes[] = $parent;
			}

			// Process all other ancestors.
			$nodes = array_merge($selectedNodes,
				$this->execAxis_ancestor($axis, $parent));
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'descendant' axis. The opposite of the
	 * 'ancestor' axis, this axis selects the children and childrens' children
	 * of the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest(), execAxis_descendant()
	 */
	 function execAxis_descendant($axis, $contextNode) {
		$selectedNodes = array();

		// Check if the current node has children.
		if ($this->hasChildNodes($contextNode)) {
			// Get a list of children.
			$children = $this->nodes[$contextNode]['children'];

			// Run through all children.
			foreach ($children as $childName => $childPosition) {
				// Run through all children of this name.
				for ($i = 1; $i <= $childPosition; $i++) {
					// New path for the children.
					$child = $contextNode.'/'.$childName.'['.$i.']';

					// Check if the child matches the node-test.
					if ($this->checkNodeTest($child, $axis['node-test'])) {
						// Add the child to the list of selected nodes.
						$selectedNodes[] = $child;
					}

					// Proceed with the next level.
					$selectedNodes = array_merge($selectedNodes,
						$this->execAxis_descendant($axis, $child));
				}
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'ancestor-or-self' axis. This variant of
	 * the 'ancestor' axis selects all ancestors of the context node as well as
	 * the node itself.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), execAxis_ancestor(), execAxis_self()
	 */
	function execAxis_ancestor_or_self($axis, $contextNode) {
		$selectedNodes = array();

		// Read the nodes.
		$selectedNodes = array_merge(
			$this->execAxis_ancestor($axis, $contextNode),
			$this->execAxis_self($axis, $contextNode)
		);

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'descendant-or-self' axis. This variant of
	 * the 'descendant' axis selects all descendants of the context node as well
	 * as the node itself.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), execAxis_descendant(), execAxis_self()
	 */
	function execAxis_descendant_or_self($axis, $contextNode) {
		$selectedNodes = array();

		// Read the nodes.
		$selectedNodes = array_merge(
			$this->execAxis_descendant($axis, $contextNode),
			$this->execAxis_self($axis, $contextNode));

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'following-sibling' axis. The 'following
	 * sibling' axes contains the nodes at the same level in the document tree
	 * as the context node. You get a collection of siblings which are after
	 * the context node, in document order.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	function execAxis_following_sibling($axis, $contextNode) {
		$selectedNodes = array();

		// Get all children from the parent.
		$siblings = $this->execAxis_child($axis,
			$this->nodes[$contextNode]['parent']);

		// Found the context node.
		$flag = FALSE;

		// Run through all siblings.
		foreach ($siblings as $sibling) {
			// Check if the context node was already found.
			if ($flag) {
				// Check if the sibling is a real sibling.
				if ($this->nodes[$sibling]['name'] ==
					$this->nodes[$contextNode]['name']) {
					// Check if the sibling matches the node-test.
					if ($this->checkNodeTest($sibling, $axis['node-test'])) {
						// Add the sibling to the list of selected nodes.
						$selectedNodes[] = $sibling;
					}
				}
			}

			// Check if this is the context node.
			if ($sibling == $contextNode) {
				// Continue with next siblings.
				$flag = TRUE;
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'following-sibling' axis. The 'preceding
	 * sibling' axes contains the nodes at the same level in the document tree
	 * as the context node. You get a collection of siblings which are before
	 * the context node, in document order.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	function execAxis_preceding_sibling($axis, $contextNode) {
		$selectedNodes = array();

		// Get all children from the parent.
		$siblings = $this->execAxis_child($axis,
			$this->nodes[$contextNode]['parent']);

		// Found the context node.
		$flag = TRUE;

		// Run through all siblings.
		foreach ($siblings as $sibling) {
			// Check if this is the context node.
			if ($sibling == $contextNode) {
				// Don't continue with siblings.
				$flag = FALSE;
			}

			// Check if the context node was found.
			if ($flag) {
				// Check if the sibling is a real sibling.
				if ($this->nodes[$sibling]['name'] ==
					$this->nodes[$contextNode]['name']) {
					// Check if the sibling matches the node-test.
					if ($this->checkNodeTest($sibling, $axis['node-test'])) {
						// Add the sibling to the list of selected nodes.
						$selectedNodes[] = $sibling;
					}
				}
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'following' axis. The 'following' axis
	 * selects all nodes within the document tree which follow (are placed
	 * after) the context node, while the 'preceding' axis selects all nodes
	 * which come before the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	function execAxis_following($axis, $contextNode) {
		$selectedNodes = array();

		// Get the current document position.
		$position = $this->nodes[$contextNode]['document-position'];

		$flag = FALSE;

		// Run through all nodes of the document.
		foreach ($this->nodes as $node => $data) {
			// Check if the context node has already been found.
			if ($flag) {
				// Check if the position is correct.
				if ($this->nodes[$node]['document-position'] == $position) {
					// Check if the node fits the node-test.
					if ($this->checkNodeTest($node, $axis['node-test'])) {
						// Add the node to the list of selected nodes.
						$selectedNodes[] = $node;
					}
				}
			}

			// Check if this node is the context node.
			if ($node == $contextNode) {
				$flag = TRUE;
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'preceding' axis. The 'following' axis
	 * selects all nodes within the document tree which follow (are placed
	 * after) the context node, while the 'preceding' axis selects all nodes
	 * which come before the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep(), checkNodeTest()
	 */
	function execAxis_preceding($axis, $contextNode) {
		$selectedNodes = array();

		// Get the current document position.
		$position = $this->nodes[$contextNode]['document-position'];

		// Found the context node.
		$flag = TRUE;

		// Run through all nodes of the document.
		foreach ($this->nodes as $node => $data) {
			// Check if this is the context node.
			if ($node == $contextNode) {
				// Afterwards do not look for more nodes
				$flag = FALSE;
			}

			// Check if the context node was found.
			if ($flag) {
				// Check if the position is correct.
				if ($this->nodes[$node]['document-position'] == $position) {
					// Check if the node passes the node-test.
					if ($this->checkNodeTest($node, $axis['node-test'])) {
						// Add the node to the list of selected nodes.
						$selectedNodes[] = $node;
					}
				}
			}
		}

		return $selectedNodes;
	}

	/**
	 * This method handles the XPath 'namespace' axis. The 'namespace' axis
	 * selects all the nodes in the same namespace as the context node.
	 *
	 * @param      string $axis
	 * @param      string $contextNode
	 * @return     array
	 * @see        evaluateStep()
	 */
	function execAxis_namespace($axis, $contextNode) {
		$selectedNodes = array();

		// Check if all nodes should be selected.
		if (!empty($this->nodes[$contextNode]['namespace'])) {
			// Add this node to the list of selected nodes.
			$selectedNodes[] = $contextNode;
		}

		return $selectedNodes;
	}

	////////////////////////////////////////////////////////////////////////////
	// Methods that handle the XPath core functions for converting and
	// translating data.

	////////////////////////////////////////////////////////////////////////////
	// Node-set functions.

	/**
	 * This method handles the XPath function 'count'. The function 'count'
	 * returns the number of nodes in a node-set.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_count($node, $args) {
		// Evaluate the argument as an XPath and return the number of nodes in
		// a node-set.
		return count($this->evaluate($args, $node));
	}

	/**
	 * This method handles the XPath function 'id'. The function 'id' selects
	 * elements by their unique id.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     array
	 * @see        evaluate()
	 */
	function execMethod_id($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Save the arguments to an array.
		$args = explode(' ', $args);

		$nodes = array();

		// Run through all document nodes.
		foreach ($this->nodes as $node => $position) {
			// Check if the node has a unique id.
			if (in_array($this->nodes[$node]['attributes']['id'], $args)) {
				// Add this node to the list of nodes.
				$nodes[] = $node;
			}
		}

		return $nodes;
	}

	/**
	 * This method handles the XPath function 'last'. The function 'last' returns
	 * the position number of the last node in the processed node list.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate()
	 */
	function execMethod_last($node, $args) {
		// Retrieve the context.
		$parent   = $this->nodes[$node]['parent'];
		$children = $this->nodes[$parent]['children'];
		$context  = $children[$this->nodes[$node]['name']];

		return $context;
	}

	/**
	 * This method handles the XPath function 'name'. The function 'name' returns
	 * the name of a node.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate()
	 */
	function execMethod_name($node, $args) {
		// Return the name of the node.
		return $this->nodes[$node]['name'];
	}

	/**
	 * This method handles the XPath function 'position'.
	 *
	 * The XPath function 'position' returns the position in the node list of
	 * the node that is currently beeing processed.
	 * 
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_position($node, $args) {
		// Return the context position.
		return $this->nodes[$node]['context-position'];
	}

	////////////////////////////////////////////////////////////////////////////
	// String functions.

	/**
	 * This method handles the XPath function 'concat'.
	 *
	 * The XPath function 'concat' returns the concatenation of all its
	 * arguments. Example: concat('The', ' ', 'XML'); Result: The XML.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate(), evaluatePredicate()
	 */
	function execMethod_concat($node, $args) {
		// Save the arguments to an array.
		$args = explode(',', $args);

		// Evaluate each argument.
		for ($i = 0; $i < sizeof($args); $i++) {
			// Trim each argument.
			$args[$i] = trim($args[$i]);

			// Evaluate the predicate.
			$args[$i] = $this->evaluatePredicate($node, $args[$i]);
		}
		$args = implode('', $args);

		// Return the concatenation of all arguments.
		return $args;
	}

	/**
	 * This method handles the XPath function 'contains'.
	 *
	 * The Xpath function 'contains' returns TRUE if the second string is
	 * contained within the first string, otherwise it returns FALSE.
	 * Example: contains('XML', 'X'); Result: TRUE.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool TRUE if the second string is contained within the first
	 *             string, otherwise FALSE.
	 * @see        evaluate(), prestr(), poststr(), evaluatePredicate()
	 */
	function execMethod_contains($node, $args) {
		// Retrieve the pre- and poststr of the arguments.
		$firstString  = trim($this->prestr($args, ','));
		$secondString = trim($this->poststr($args, ','));

		// Evaluate the pre- and poststr.
		$firstString  = $this->evaluatePredicate($node, $firstString);
		$secondString = $this->evaluatePredicate($node, $secondString);

		// Check if the second string is contained within the first string.
		if (ereg($firstString, $secondString)) return TRUE;
		else return FALSE;
	}

	/**
	 * This method handles the XPath function 'starts-with'.
	 *
	 * The XPath function 'starts-with' returns TRUE if the first string starts
	 * with the second string, otherwise it returns FALSE.
	 * Example: starts-with('XML', 'X'); Result: TRUE.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool TRUE if the first string starts with the second string,
	 *             otherwise FALSE.
	 * @see        evaluate(), prestr(), poststr(), evaluatePredicate()
	 */
	function execMethod_starts_with($node, $args) {
		// Retrieve the first- and secondString of the arguments.
		$firstString = trim($this->prestr($args, ','));
		$secondString = trim($this->poststr($args, ','));

		// Evaluate the first- and secondString.
		$firstString  = $this->evaluatePredicate($node, $firstString);
		$secondString = $this->evaluatePredicate($node, $secondString);

		// Check if the first string starts with the second string.
        if (ereg("^".$secondString, $firstString)) return TRUE;
		else return FALSE;
	}

	/**
	 * This method handles the XPath function 'string'.
	 *
	 * The XPath function 'string' converts the value argument to a string.
	 * Example: string(314); Result '314'.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate()
	 */
	function execMethod_string($node, $args) {
		// Check what type of parameter is given.
		if (ereg("^[0-9]+(\.[0-9]+)?$", $args) || ereg("^\.[0-9]+$", $args)) {
			// Convert the variable to a float value.
			$value = doubleval($args);
			// Return the string value
			return strval($value);
		}
		else if (is_bool($args)) {
			if ($args == TRUE) return 'TRUE';
			else return 'FALSE';
		}
		else if (!empty($args)) {
			// Evaluate the argument as an XPath expression.
			$nodeSet = $this->evaluate($args, $node);

			// Get the first argument.
			$nodeSet = explode('|', implode('|', $nodeSet));

			// Return the first result as a string.
			return $nodeSet[0];
		}
		else if (empty($args)) return $node;
		else return '';
	}

	/**
	 * This method handles the XPath function 'string-length'.
	 *
	 * The XPath function 'string-length' returns the number of characters in a
	 * string. Example: string-length('NodeSet'); Result: 7.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate(), evaluatePredicate()
	 */
	function execMethod_string_length($node, $args) {
		// Trim the argument.
		$args = trim($args);

		// Evaluate the argument.
		$args = $this->evaluatePredicate($node, $args);

		return strlen(strval($args));
	}

	/**
	 * This method handles the XPath function 'substring'.
	 *
	 * The XPath function 'substring' returns a part of the string in the string
	 * argument. Example: substring('NodeSet', 1, 4); Result: 'Node'.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate(), evaluatePredicate()
	 */
	function execMethod_substring($node, $args) {
		// Save arguments to array.
		$args = explode(',', $args);

		// Run through all arguments.
		for ($i = 0; $i < sizeof($args); $i++) {
			// Trim the string.
			$args[$i] = trim($args[$i]);

			// Evaluate each argument.
			$args[$i] = $this->evaluatePredicate($node, $args[$i]);
		}

		// Check if a third argument is given.
		if (!empty($args[2])) {
			// Return the substring.
			return substr(strval($args[0]), $args[1]-1, $args[2]);
		}
		else {
			// Return the substring.
			return substr(strval($args[0]), $args[1]-1);
		}
	}

	/**
	 * This method handles the XPath function 'substring-after'.
	 *
	 * The XPath function 'substring-after' returns the part of the string
	 * argument that occurs after the substring in the substr argument.
	 * Example: substring-after('12/10','/'); Result: '10'.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate(), prestr(), poststr(), evaluatePedicate()
	 */
	function execMethod_substring_after($node, $args) {
		// Get the arguments.
		$pre  = trim($this->prestr($args, ','));
		$post = trim($this->poststr($args, ','));

		// Evaluate the pre- and poststr.
		$pre  = $this->evaluatePredicate($node, $pre);
		$post = $this->evaluatePredicate($node, $post);

		// Return the substring-after.
		return $this->poststr(strval($pre), strval($post));
	}

	/**
	 * This method handles the XPath function 'substring-before'.
	 *
	 * The XPath function 'substring-before' returns the part of the string in
	 * the string argument that occurs before the substring in the substr
	 * argument. Example: substring-before('12/10','/'); Result '12'.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     string
	 * @see        evaluate(), prestr(), poststr(), evaluatePredicate()
	 */
	function execMethod_substring_before($node, $args) {
		// Retrieve the pre- and poststr of the arguments.
		$pre  = trim($this->prestr($args, ','));
		$post = trim($this->poststr($args, ','));

		// Evaluate the pre- and poststr.
		$pre  = $this->evaluatePredicate($node, $pre);
		$post = $this->evaluatePredicate($node, $post);

		// Return the substring-before.
		return $this->prestr(strval($pre), strval($post));
	}

	/**
	 * This method handles the XPath function 'translate'.
	 *
	 * The XPath function 'translate' performs a character by character
	 * replacement. It looks in the value argument for characters contained in
	 * string1, and replaces each character for the one in the same position in
	 * the string2. Examples: translate('12:30', '30', '45'); Result: '12:45'.
	 * translate('12:30', '03', '54'); Result: '12:45'.
	 * translate('12:30', '0123', 'abcd'); Result: 'bc:da'.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     array
	 * @see        evaluate(), evaluatePredicate()
	 */
	function execMethod_translate($node, $args) {
		// Save arguments to array.
		$args = explode(',', $args);

		// Run through all arguments.
		for ($i = 0; $i < sizeof($args); $i++) {
			// Trim the argument.
			$args[$i] = trim($args[$i]);

			// Evaluate the argument.
			$args[$i] = $this->evaluatePredicate($node, $args[$i]);
		}

		return strtr($args[0], $args[1], $args[2]);
	}

	////////////////////////////////////////////////////////////////////////////
	// Number functions.

	/**
	 * This method handles the XPath function 'ceiling'.
	 *
	 * The XPath function 'ceiling' returns the smallest integer that is not
	 * less than the number argument. Example: ceiling(3.14); Result: 4.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_ceiling($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Convert the arguments to float value.
		$args = doubleval($args);

		return ceil($args);
	}

	/**
	 * This method handles the XPath function 'floor'.
	 *
	 * The XPath function 'floor' returns the largest integer that is not
	 * greater than the number argument. Example: floor(3.14); Result: 3.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_floor($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Convert the arguments to a number.
		$args = doubleval($args);

		return floor($args);
	}

	/**
	 * This method handles the XPath function 'number'.
	 *
	 * The XPath function 'number' converts the value argument to a number.
	 * Example: number('100'); Result: 100
	 *
	 * @param      string $node
	 * @param      mixed $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_number($node, $args) {
		// Check the type of argument.
		if (ereg("^[0-9]+(\.[0-9]+)?$", $args) ||
			ereg("^\.[0-9]+$", $args)) {
			// Return the argument as a number.
			return doubleval($args);
		}
		else if (is_bool($args)) {
			if ($args == TRUE) return 1;
			else return 0;
		}
	}

	/**
	 * This method handles the XPath function 'round'.
	 *
	 * The XPath function 'round' rounds the number argument to the nearest
	 * integer. Example: round(3.14); Result: 3.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate()
	 */
	function execMethod_round($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Convert the arguments to a number.
		$args = doubleval($args);

		return round($args);
	}

	/**
	 * This method handles the XPath function 'sum'.
	 *
	 * The XPath function 'sum' returns the total value of a set of numeric
	 * values in a node-set. Example: sum('/document/content');
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     int
	 * @see        evaluate(), getData()
	 */
	function execMethod_sum($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Evaluate the arguments as an XPath expression.
		$results = $this->evaluate($args, $node);

		$sum = 0;

		// Run through all results.
		foreach ($results as $result) {
			// Get the value of the node.
			$result = $this->getData($result);

			// Add the value of the node to the sum.
			$sum += doubleval($result);
		}

		return $sum;
	}

	////////////////////////////////////////////////////////////////////////////
	// Boolean functions.

	/**
	 * This method handles the XPath function 'boolean'.
	 *
	 * The XPath function 'boolean' converts the value argument to boolean and
	 * returns TRUE or FALSE.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool
	 * @see        evaluate()
	 */
	function execMethod_boolean($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Check the type of parameter.
		if (ereg("^[0-9]+(\.[0-9]+)?$", $args) || ereg("^\.[0-9]+$", $args)) {
			// Convert the digits to a number.
			$number = doubleval($args);

			// Check if the number is 0.
			if ($number == 0) return FALSE;
			else return TRUE;
		}
		else if (empty($args)) return FALSE;
		else {
			// Evaluate the argument as XPath expression.
			$result = $this->evaluate($args, $node);

			if (count($result) > 0) return TRUE;
			else return FALSE;
		}
	}

	/**
	 * This method handles the XPath function 'false'.
	 *
	 * The XPath function 'false' returns FALSE. Example: number(false());
	 * Result 0.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool
	 * @see        evaluate()
	 */
	function execMethod_false($node, $args) {
		return FALSE;
	}

	/**
	 * This method handles the XPath function 'lang'.
	 *
	 * The XPath function 'lang' returns TRUE if the language argument matches
	 * the language of the xsl:lang element, otherwise it returns FALSE.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool
	 * @see        evaluate()
	 */
	function execMethod_lang($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Check if the node has an language attribute.
		if (empty($this->nodes[$node]['attributes']['xml:lang'])) {
			// Run through the ancestors.
			while(!empty($node)) {
				// Select the parent node.
				$node = $this->nodes[$node]['parent'];

				// Check if there is a language definition.
				if (!empty($this->nodes[$node]['attributes']['xml:lang'])) {
					// Check if it is the requested language.
					if (eregi("^".$args, $this->nodes[$node]
						['attributes']['xml:lang'])) return TRUE;
					else return FALSE;
				}
			}

			return FALSE;
		}
		else {
			// Check if it is the requested language.
			if (eregi("^".$args, $this->nodes[$node]['attributes']
				['xml:lang'])) return TRUE;
			else return FALSE;
		}
	}

	/**
	 * This method handles the XPath function 'not'.
	 *
	 * The XPath function 'not' returns TRUE if the condition argument is FALSE,
	 * and FALSE if the condition argument is TRUE. Example: not(false());
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool
	 * @see        evaluate(), evaluatePredicate()
	 */
	function execMethod_not($node, $args) {
		// Trim the arguments.
		$args = trim($args);

		// Return TRUE if the condition argument is FALSE.
		return !$this->evaluatePredicate($node, $args);
	}

	/**
	 * This method handles the XPath function 'true'.
	 *
	 * This XPath function 'true' returns TRUE. Example: number(true());
	 * Result: 1.
	 *
	 * @param      string $node
	 * @param      string $args
	 * @return     bool
	 * @see        evaluate()
	 */
	function execMethod_true($node, $args) {
		return TRUE;
	}

	/**
	 * This method returns a substring before a seperator.
	 *
	 * @param      string $str
	 * @param      string $seperator
	 * @return     string
	 */
	function prestr($str, $seperator) {
		return substr($str, 0, strlen($str)-strlen(strstr($str, "$seperator")));
	}

	/**
	 * This method returns a substring after a seperator.
	 *
	 * @param      string $str
	 * @param      string $seperator
	 * @return     string
	 */
	function poststr($str, $seperator) {
		return substr($str, strpos($str, $seperator)+strlen($seperator));
	}

	/**
	 * This method replaces the entities in the given string.
	 *
	 * @param      string $str
	 * @return     string
	 * @see        characterDataHandler(), evaluate()
	 */
	function replaceEntities($str) {
		// The list of entities to be replaced.
		$entities = array('&'=>'&amp;', '<'=>'&lt;', '>'=>'&gt;', "'"=>'&apos;',
			'"'=>'&quot;');
		return strtr($str, $entities);
	}

	/**
	 * This method resets the parser object properties to their default values.
	 * After the reset a new XML string or file can be read and parsed.
	 */
	function resetParser() {
		$this->fileName     = '';
		$this->root         = '';
		$this->nodes        = array();
		$this->nodeIds      = array();
		$this->path         = '';
		$this->position     = 0;
		$this->xPath        = '';
		$this->cdataSection	= 0;
	}

	function error_handler($errtxt) {
		// check if more than one argument is given
		if(func_num_args() > 1) {
			// read all arguments
			$args = func_get_args();

			// format string
			$str = "\$errtxt = sprintf(\$errtxt, ";

			// run through the array of arguments
			for($i = 1; $i < sizeof($args); $i++) {
				// add arguments to the format string
				$str .= "\$args[".$i."], ";
			}

			// replace the last separator
			$str = eregi_replace(", $", ");", $str);

			eval($str);
		}

		// show error message
		//echo "<pre><br><b>XML error</b>: ".$errtxt."</pre>";

		// exit the script
		exit;
	}
	
	/**
	 * The method gets defined encoding from file or from data
	 *
	 * @param      string $file
	 * @param      string $data
	 * @return     string
	 * @see        parseXML()
	 */	
	function getEncoding($file='',$data=''){

			if(!empty($file)) {
				$data = weFile::loadPart($file,0,256);
			}

			if(empty($data)) {
				return false;
			}

			$match = array();
			$encoding = 'ISO-8859-1';
			$trenner = "[\040|\n|\t|\r]*";
			$pattern ="(encoding".$trenner."=".$trenner."[\"|\'|\\\\]".$trenner.")([^\'\">\040? \\\]*)";

			if(eregi($pattern,$data,$match)){
				if(strtoupper($match[2])!='ISO-8859-1'){
					$encoding = 'UTF-8';
				}
			}
			
			return $encoding;
	}

}

?>