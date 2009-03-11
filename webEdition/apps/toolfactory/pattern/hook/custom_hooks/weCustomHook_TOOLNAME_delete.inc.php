
/**
 * if hook execution is enabled this function will be executed 
 * when deleting an entry or folder in the application <?php print $TOOLNAME; ?> 
 * The array $param has all information about the respective entry or folder.
 * 
 * @param array $param
 */	
 
function weCustomHook_<?php print $TOOLNAME; ?>_delete($param) {
	
	/**
	 * e.g.:
	 * 
	 * ob_start("error_log");
	 * print_r($param);
	 * ob_end_clean();
	 */

}