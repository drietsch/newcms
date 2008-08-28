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
$checkButton = $we_button->create_button('next', $_SERVER['PHP_SELF'] . '?section=connect&update_cmd=checkConnection');

if ($errorMessage) { // servers response is error string
	$content = '
<div class="defaultfont">
	' . $GLOBALS['l_liveUpdate']['connect']['connectionSuccessError'] . '
	<div class="errorDiv">
		<code>' . $errorMessage . '</code>
	</div>
</div>
';
} else {
	$content = '
<div class="defaultfont">
	' . $GLOBALS['l_liveUpdate']['connect']['connectionSuccess'] . '
</div>
';
}

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['connect']['headline'], $content);

?>