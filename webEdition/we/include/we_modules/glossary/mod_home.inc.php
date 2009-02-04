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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

$we_button = new we_button();

$createAbbreviation = $we_button->create_button("new_glossary_abbreviation", "javascript:top.opener.top.we_cmd('new_glossary_abbreviation');", true, -1, -1, "", "", !we_hasPerm("NEW_GLOSSARY"));
$createAcronym = $we_button->create_button("new_glossary_acronym", "javascript:top.opener.top.we_cmd('new_glossary_acronym');", true, -1, -1, "", "", !we_hasPerm("NEW_GLOSSARY"));
$createForeignWord = $we_button->create_button("new_glossary_foreignword", "javascript:top.opener.top.we_cmd('new_glossary_foreignword');", true, -1, -1, "", "", !we_hasPerm("NEW_GLOSSARY"));
$createLink = $we_button->create_button("new_glossary_link", "javascript:top.opener.top.we_cmd('new_glossary_link');", true, -1, -1, "", "", !we_hasPerm("NEW_GLOSSARY"));

$content	=		$createAbbreviation
				.	getPixel(2,14)
				.	$createAcronym
				.	getPixel(2,14)
				.	$createForeignWord
				.	getPixel(2,14)
				.	$createLink;

$modimage = "glossary.gif";

?>