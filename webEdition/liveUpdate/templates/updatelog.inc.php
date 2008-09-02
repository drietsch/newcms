<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/*
 * This is the template for tab updatelog. It does not connect to the
 * updateserver
 *
 * This template need the following variables -> set in liveUpdateFunctions
 * 
 * allEntries -> amount of all entries, not regarding the filter
 * amountEntries -> amount of all entries regarding the filter
 * amountPerPage -> amount of entries to be shwon on page
 * logEntries -> array of entries for this page
 * amountMessages -> amount of entries of type message
 * amountNotices -> amount of entries of type notice
 * amountErrors -> amount of entries of type notice
 * 
 * and in addition the following request variables
 *
 * $_REQUEST['start']
 * $_REQUEST['messages']
 * $_REQUEST['notices']
 * $_REQUEST['errors']
 * 
 */

$content = $GLOBALS['l_liveUpdate']['updatelog']['logIsEmpty'];
$buttons = '';

/*
 * items found - show them in table
 */
if ( $this->Data['allEntries'] ) { // entries exist
	
	// there are entries available -> show them in table
	$content = '
<form name="we_form">
<input type="hidden" name="section" value="' . $_REQUEST['section'] .'" />
<input type="hidden" name="log_cmd" value="dummy" />
<input type="hidden" name="start" value="' . $_REQUEST['start'] .'" />
<table class="defaultfont" width="100%">
<tr>
	<td>' . $GLOBALS['l_liveUpdate']['updatelog']['entriesTotal'] . ': ' . $this->Data['amountEntries'] . '</td>
	<td class="alignRight">' . $GLOBALS['l_liveUpdate']['updatelog']['page'] . ' ' . (($_REQUEST['start'] / $this->Data['amountPerPage']) +1) . '/ ' . ((ceil($this->Data['amountEntries']/$this->Data['amountPerPage'])) ? ceil($this->Data['amountEntries']/$this->Data['amountPerPage']) : 1) . '</td>
</tr>
</table>
<div class="defaultfont">
	' .	we_forms::checkbox(1, isset($_REQUEST['messages']), 'messages', "<span class=\"logMessage\">" . $GLOBALS['l_liveUpdate']['updatelog']['legendMessages'] . " (" . $this->Data['amountMessages'] . ")</span>", false, "small", "document.we_form.submit();") . '
	' .	we_forms::checkbox(1, isset($_REQUEST['notices']), 'notices', "<span class=\"logNotice\">" . $GLOBALS['l_liveUpdate']['updatelog']['legendNotices'] . " (" . $this->Data['amountNotices'] . ")</span>", false, "small", "document.we_form.submit();") . '
	' .	we_forms::checkbox(1, isset($_REQUEST['errors']), 'errors', "<span class=\"logError\">" . $GLOBALS['l_liveUpdate']['updatelog']['legendErrors'] . " (" . $this->Data['amountErrors'] . ")</span>", false, "small", "document.we_form.submit();") . '
</div>
<br />
';

	if (sizeof($this->Data['logEntries'])) { // entries match filter
		
		$content .= '
<table width="100%" class="defaultfont updateContent" id="updateLogTable">
<tr>
	<th>' . $GLOBALS['l_liveUpdate']['updatelog']['date'] . '</th>
	<th>' . $GLOBALS['l_liveUpdate']['updatelog']['action'] . '</th>
	<th>' . $GLOBALS['l_liveUpdate']['updatelog']['version'] . '</th>
</tr>';
		
		foreach ($this->Data['logEntries'] as $logEntry) {
		
			$classStr =  ' class="logMessage"';
			if ($logEntry['state'] == 1) {
				$classStr = ' class="logError"';
			} else if ($logEntry['state'] == 2) {
				$classStr = ' class="logNotice"';
			}
			
			$content .= "
	<tr$classStr>
		<td valign=\"top\">" . $logEntry['date'] . "</td>
		<td>" . $logEntry['action'] . "</td>
		<td valign=\"top\">" . $logEntry['version'] . "</td>
	</tr>";
		}
		
		/*
		 * Add buttons for next, back and delete
		 */
			$we_button = new we_button();
		
			if( $_REQUEST['start'] > 0 ){	//	backbutton
				$backButton = $we_button->create_button("back", "javascript:lastEntries();");
			} else {
				$backButton = $we_button->create_button("back", "#", true, 100, 22, "", "", true);
			} 
			
			if( $this->Data['amountEntries'] <= $_REQUEST['start'] + $this->Data['amountPerPage'] ){	//	next_button
				$nextButton = $we_button->create_button("next", "#", true, 100, 22, "", "", true);
			} else {
				$nextButton = $we_button->create_button("next", "javascript:nextEntries();");
			}
			
			$deleteButton = $we_button->create_button("delete", "javascript:confirmDelete();");
			
			$buttons = "<table><tr><td>$deleteButton</td><td>$backButton</td><td>$nextButton</td></tr></table>";
		
			$content .= '
</table>';
	
	} else {
		$content .= '
<table class="defaultfont">
<tr>
	<td><br />
		' . $GLOBALS['l_liveUpdate']['updatelog']['noEntriesMatchFilter'] . '</td>
</tr>
</table>';
	}
	$content .= '
</form>';
}

$jsHead = '
<script type="text/javascript">
	
	function confirmDelete() {
		if (confirm("' . $GLOBALS['l_liveUpdate']['updatelog']['confirmDelete'] . '")) {
			deleteEntries();
		}
	}
	
	function deleteEntries() {
		document.we_form.log_cmd.value = "deleteEntries";
		document.we_form.submit();
	}
	
	function lastEntries() {
		document.we_form.log_cmd.value = "lastEntries";
		document.we_form.submit();
	}
	
	function nextEntries() {
		document.we_form.log_cmd.value = "nextEntries";
		document.we_form.submit();
	}
	</script>';


print liveUpdateTemplates::getHtml($GLOBALS['l_liveUpdate']['updatelog']['headline'], $content, $jsHead, $buttons);

?>