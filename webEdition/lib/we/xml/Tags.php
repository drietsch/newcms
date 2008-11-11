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
 * @package    we_xml
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * Utility class for creating XML Tags
 * 
 * @category   we
 * @package    we_xml
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
