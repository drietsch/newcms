	
	include_once('define.conf.php');
	
	$metaInfo = array(
		'name' => '<?php print $TOOLNAME;?>',
		'realname' => '<?php print $TOOLREALNAME;?>',
		'classname'=>'<?php print $CLASSNAME; ?>',
		'maintable'=><?php print (isset($TABLECONSTANT) && !empty($TABLECONSTANT)) ? $TABLECONSTANT : '""'; ?>,
		'datasource'=><?php if($DATASOURCE=='table:') print "'table:'.$TABLECONSTANT"; else print "'$DATASOURCE'"?>,
		'startpermission'=>'<?php print $PERMISSIONCONDITION; ?>'
	);