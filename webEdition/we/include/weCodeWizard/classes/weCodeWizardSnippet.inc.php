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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/xml_parser.inc.php");

/**
 * Code Snipptes are used in templates inside webEdition
 * 
 * @see Parser.php
 * @see dtd:http://docs.oasis-open.org/dita/v1.0.1/dtd/topic.dtd
 * 
 */
class weCodeWizardSnippet
{

	/**
	 * Name of the Snippet
	 *
	 * @var string
	 */
	var $Name = "";

	/**
	 * Description of the snippet
	 *
	 * @var string
	 */
	var $Description = "";

	/**
	 * Author of the snippet
	 *
	 * @var string
	 */
	var $Author = "";

	/**
	 * Snippet code
	 *
	 * @var string
	 */
	var $Code = "";

	/**
	 * PHP 5 constructor
	 *
	 */
	function __construct()
	{
	
	}

	/**
	 * PHP 4 constructor
	 *
	 * @return weCodeWizardSnippet
	 */
	function weCodeWizardSnippet()
	{
		$this->__construct();
	}

	/**
	 * initialize the snippet from an xml file
	 *
	 * @param string $file
	 */
	function initByXmlFile($file)
	{
		
		$Snippet = new weCodeWizardSnippet();
		$Parser = new XML_Parser($file);
		
		// set the title
		if ($Parser->execMethod_count("/topic[1]", "title") > 0) {
			$Snippet->Name = $Parser->getData("/topic[1]/title[1]");
			if (isset($GLOBALS['we_doc']->elements["Charset"]['dat']) && $GLOBALS['we_doc']->elements["Charset"]['dat'] != "UTF-8") {
				$Snippet->Name = $Snippet->Name;
			
			}
		
		}
		
		// set the short description
		if ($Parser->execMethod_count("/topic[1]", "shortdesc") > 0) {
			$Snippet->Description = $Parser->getData("/topic[1]/shortdesc[1]");
			if (isset($GLOBALS['we_doc']->elements["Charset"]['dat']) && $GLOBALS['we_doc']->elements["Charset"]['dat'] != "UTF-8") {
				$Snippet->Description = $Snippet->Description;
			
			}
		
		}
		
		// set the author
		if ($Parser->execMethod_count("/topic[1]/prolog[1]", "author") > 0) {
			$Snippet->Author = $Parser->getData("/topic[1]/prolog[1]/author[1]");
			if (isset($GLOBALS['we_doc']->elements["Charset"]['dat']) && $GLOBALS['we_doc']->elements["Charset"]['dat'] != "UTF-8") {
				$Snippet->Author = $Snippet->Author;
			
			}
		
		}
		
		// set the code
		if ($Parser->execMethod_count("/topic[1]/body[1]/p[1]", "codeblock") > 0) {
			$Snippet->Code = $Parser->getData("/topic[1]/body[1]/p[1]/codeblock[1]");
			if (isset($GLOBALS['we_doc']->elements["Charset"]['dat']) && $GLOBALS['we_doc']->elements["Charset"]['dat'] != "UTF-8") {
				$Snippet->Code = $Snippet->Code;
			
			}
		
		}
		
		return $Snippet;
	
	}

	function changeCharset($string, $charset = "")
	{
		
		if ($charset == "") {
			$charset = $GLOBALS['we_doc']->getElement('Charset');
			if ($charset == "") {
				include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/charset/charset.inc.php");
				$charset = $_language["charset"];
			
			}
		}
		
		if ($charset != "UTF-8" && $charset != "") {
			
			if (function_exists("iconv")) {
				$string = iconv("UTF-8", $charset, $string);
			
			} elseif ($charset == "ISO-8859-1") {
				$string = utf8_decode($string);
			
			}
		
		}
		
		return $string;
	
	}

	/**
	 * get the snippet name
	 *
	 * @return string
	 */
	function getName($charset = "")
	{
		return weCodeWizardSnippet::changeCharset($this->Name, $charset);
	
	}

	/**
	 * get the snippet description
	 *
	 * @return string
	 */
	function getDescription($charset = "")
	{
		return weCodeWizardSnippet::changeCharset($this->Description, $charset);
	
	}

	/**
	 * get the snippet author
	 *
	 * @return string
	 */
	function getAuthor($charset = "")
	{
		return weCodeWizardSnippet::changeCharset($this->Author, $charset);
	
	}

	/**
	 * get the snippet code
	 *
	 * @return string
	 */
	function getCode($charset = "")
	{
		return weCodeWizardSnippet::changeCharset($this->Code, $charset);
	
	}

}

/**
 * Code Sample
 * 
 * $Snippet = weCodeWizardSnippet::initByXmlFile('Contact.xml');
 * 
 * echo $Snippet->getName();
 * 
 */

?>