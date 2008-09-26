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
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/*
 * This is the template for tab update. It contains the information screen
 * before searching for an update
 * 
 */

$we_button = new we_button();
$searchButton = $we_button->create_button('search', $_SERVER['PHP_SELF'] . '?section=update&update_cmd=update&detail=lookForUpdate');

$content = '
<table class="defaultfont" width="100%">
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['update']['actualVersion'] . '</td>
	<td>' . $GLOBALS['LU_Variables']['clientVersion'] . '</td>
</tr>
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['update']['lastUpdate'] . '</td>
	<td>' . $this->Data['lastUpdate'] . '</td>
</tr>
<tr>
	<td>
		<br />
		<br />
	</td>
</tr>
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['update']['lookForUpdate'] . '</td>
	<td>' . $searchButton . '</td>
</tr>
</table>
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['update']['headline'], $content);

?>