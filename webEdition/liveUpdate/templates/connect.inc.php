<?php
/*
 * This is the template for tab connect. It trys to connect to the server in
 * different ways.
 */

$we_button = new we_button();
$checkButton = $we_button->create_button('next', $_SERVER['PHP_SELF'] . '?section=connect&update_cmd=checkConnection&clientLng=' . $GLOBALS['WE_LANGUAGE']);

$content = '
<div class="defaultfont">
	' . $GLOBALS['l_liveUpdate']['connect']['description'] . '
	<br />
	<br />
	' . $checkButton . '
</div>
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['connect']['headline'], $content);

?>