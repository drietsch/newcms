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
 * This is the template for tab languages. It contains the information screen
 * before deleting or installing languages
 */

$we_button = new we_button();
$nextButton = $we_button->create_button('next', $_SERVER['PHP_SELF'] . '?section=languages&update_cmd=languages&detail=selectLanguages');
$deleteButton = $we_button->create_button('delete', 'javascript:document.we_form.submit()');

$languages = liveUpdateFunctions::getInstalledLanguages();

$languagesStr = '';
foreach ($languages as $lng) {
	
	if (WE_LANGUAGE == $lng) {
		$lngBox = we_forms::checkbox($lng, false, 'deleteLanguages[]', "<i>$lng (" . $GLOBALS['l_liveUpdate']['languages']['systemLanguage'] . ")</i>", false, 'defaultfont', '', true);
	} else if ($GLOBALS['WE_LANGUAGE'] == $lng) {
		$lngBox = we_forms::checkbox($lng, false, 'deleteLanguages[]', "<i>$lng (" . $GLOBALS['l_liveUpdate']['languages']['usedLanguage'] . ")</i>", false, 'defaultfont', '', true);
	} else {
		$lngBox = we_forms::checkbox($lng, false, 'deleteLanguages[]', $lng, true);
	}
		$languagesStr .= "
	$lngBox";
		
}

$deletedLngs = $this->getData('deletedLngs');
$notDeletedLngs = $this->getData('notDeletedLngs');
$jsAlert = '';
if (sizeof($deletedLngs)) {
	$jsAlert .= $GLOBALS['l_liveUpdate']['languages']['languagesDeleted'] . '\n';
	foreach ($deletedLngs as $lng) {
		$jsAlert .= $lng . '\n';
	}
}
if (sizeof($notDeletedLngs)) {
	$jsAlert .= $GLOBALS['l_liveUpdate']['languages']['languagesNotDeleted'] . '\n';
	foreach ($notDeletedLngs as $lng) {
		$jsAlert .= $lng . '\n';
	}
}

if ($jsAlert) {
	$jsAlert = "<script type=\"text/JavaScript\">alert(\"$jsAlert\")</script>";
}

$content = '
<div>
<form name="we_form">
' . hidden('section', 'languages') . '
' . $GLOBALS['l_liveUpdate']['languages']['installedLngs'] . '
<br />
' . $languagesStr . '
<br />
<table class="defaultfont" width="100%">
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['languages']['showLanguages'] . '</td>
	<td>' . $nextButton . '</td>
</tr>
<tr>
	<td><br /></td>
</tr>
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['languages']['deleteSelectedLanguages'] . '</td>
	<td>' . $deleteButton . '</td>
</tr>
</table>
</form>
' . $jsAlert . '
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['languages']['headline'], $content);

?>