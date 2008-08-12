<?php
					
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/meta.conf.php');

		switch($_REQUEST["we_cmd"][0]){
			case 'tool_weSearch_edit':
				$toolInclude = 'tools_frameset.php';
			break;
		}

		if(isset($toolInclude)) {
        	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $toolInclude);
        }
 
?>