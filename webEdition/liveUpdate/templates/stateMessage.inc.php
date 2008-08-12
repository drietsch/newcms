<?php
/*
 * This is the template for tab connect. It trys to connect to the server in
 * different ways.
 */

if ($this->State == 'true') {
	$description = $GLOBALS['l_liveUpdate']['state']['descriptionTrue'];
} else {
	$description = $GLOBALS['l_liveUpdate']['state']['descriptionError'];
}



$content = '
<div class="defaultfont">
	' . $description . '
	<div class="errorDiv">
		<code>' . $this->Message . '</code>
	</div>
</div>
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['state']['headline'], $content);

?>