<?php
	$_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php";
	$_temp_file_name = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/tmp_we_conf_global.inc.php";
	if (file_exists($_temp_file_name)) {
		
		$couter = 0;
		while ($counter < 1000) {
			if (copy($_temp_file_name, $_file_name)) {
				$counter = 1000;
			} 
			$counter++;
		}
	}

?>