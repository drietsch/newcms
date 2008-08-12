<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_xml
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Tags.php,v 1.1 2008/05/15 12:07:15 holger.meyer Exp $
 */

/**
 * Utility class for creating XML Tags
 * 
 * @category   we
 * @package    we_xml
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_xml_Tags
{

	/**
	 * Returns attribute string to insert in any XML tag
	 *
	 * @param string $attribArray associative array with attributes
	 * @param string $excludeAttribs comma separated list of attributes which should not be included in generated string
	 * @return string
	 */
	static function createAttributeStringFromArray($attribArray, $excludeAttribs = NULL)
	{
		$excludeArr = is_null($excludeAttribs) ? array() : explode(',', $excludeAttribs);
		$attribString = '';
		foreach ($attribArray as $n => $v) {
			if (!in_array($n, $excludeArr)) {
				$attribString .= ' ' . htmlspecialchars($n) . '="' . htmlspecialchars($v) . '"';
			}
		}
		return $attribString;
	}

	/**
	 * Returns XML tag with given tagName and attributes
	 *
	 * @param string $tagName name of tag
	 * @param string $attribArray associative array with attributes
	 * @param string $excludeAttribs comma separated list of attributes which should not be included in generated string
	 * @param boolean $endSlash flag which controls if tag should have an end slash or not 
	 * @return string
	 */
	static function createStartTag($tagName, $attribArray = array(), $excludeAttribs = NULL, $endSlash = false)
	{
		return '<' . strtolower($tagName) . we_xml_Tags::createAttributeStringFromArray($attribArray, $excludeAttribs) . ($endSlash ? ' /' : '') . '>';
	}

}
