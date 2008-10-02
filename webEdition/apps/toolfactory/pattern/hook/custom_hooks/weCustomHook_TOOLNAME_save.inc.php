
/**
 * if hook execution is enabled this function will be executed 
 * when saving an entry or folder in the application <?php print $TOOLNAME; ?> 
 * The object $we_doc has all information about the respective entry or folder.
 * The string of $appName is equal to the application name, in this case it
 * has to be '<?php print $TOOLNAME; ?>'.
 * 
 * @param object $we_doc
 * @param $appName string
 */	
function weCustomHook_<?php print $TOOLNAME; ?>_save($we_doc, $appName='') {
	
	/**
	 * e.g.:
	 * 
	 * ob_start("error_log");
	 * print_r($we_doc);
	 * ob_end_clean();
	 */

}