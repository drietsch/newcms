<?php
					
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/conf/meta.conf.php');

		switch($_REQUEST["we_cmd"][0]){
			case 'tool_abc_edit':
				$toolInclude = 'we_tools/tools_frameset.php';
			break;
		}

		if(isset($toolInclude)) {
        	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/' . $toolInclude);
        }
 


		?>