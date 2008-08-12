<?php
					
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolTreeDataSource.class.php');

class abcTreeDataSource extends weToolTreeDataSource {
	
	function abcTreeDataSource($ds) {
		weToolTreeDataSource::weToolTreeDataSource($ds);
	}
	
}
		?>