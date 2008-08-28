<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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