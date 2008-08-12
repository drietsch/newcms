<?php
						
	include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/weSearch/conf/define.conf.php");
	
	$metaInfo = array(
		'name' => 'weSearch',
		'realname' => 'weSearch',
		'classname'=>'searchtool',
		'maintable'=>SUCHE_TABLE,
		'datasource'=>'table:'.SUCHE_TABLE,
		'startpermission'=>''
	);
	
?>