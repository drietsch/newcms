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
 * This is the template for tab connect. It trys to connect to the server in
 * different ways.
 */

$we_button = new we_button();
$nextButton = $we_button->create_button('next', $_SERVER['PHP_SELF'] . '?update_cmd=register&detail=registerForm');

$content = '
<div class="defaultfont">
	' . $GLOBALS['l_liveUpdate']['register']['description'] . '
	<br />
	<br />
	' . $nextButton . '
</div>
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['register']['headline'], $content);

?>