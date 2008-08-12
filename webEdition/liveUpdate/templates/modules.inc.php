<?php
/*
 * This is the template for tab update. It contains the information screen
 * before searching for an update
 * 
 */

$we_button = new we_button();
$nextButton = $we_button->create_button('next', $_SERVER['PHP_SELF'] . '?section=modules&update_cmd=modules&detail=selectModules');

require($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . LIVEUPDATE_LANGUAGE . '/javaMenu/module_information.inc.php');

if (sizeof($GLOBALS['LU_Variables']['clientInstalledModules'])) {
	
	$moduleString = "<ul>";
	foreach ($GLOBALS['LU_Variables']['clientInstalledModules'] as $moduleKey) {
		
		if ( isset($l_javaMenu["module_information"][$moduleKey]["text"]) ) {
			
			$moduleString .= "
			<li>" . $l_javaMenu["module_information"][$moduleKey]["text"] . "</li>";
		}
	}
	$moduleKey .= '</ul>';
	
} else {
	
	$moduleString = $GLOBALS['l_liveUpdate']['modules']['noModulesInstalled'];
}


$content = '
<table class="defaultfont" width="100%">
<tr class="valignTop">
	<td>' . $GLOBALS['l_liveUpdate']['modules']['installedModules'] . '</td>
	<td>' . $moduleString . '</td>
</tr>
<tr>
	<td>
		<br />
		<br />
	</td>
</tr>
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['modules']['showModules'] . '</td>
	<td>' . $nextButton . '</td>
</tr>
</table>
';

print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['modules']['headline'], $content);

?>