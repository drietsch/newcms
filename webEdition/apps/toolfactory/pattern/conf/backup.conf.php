
include_once('define.conf.php');

$toolTables = array();
<?php if(isset($TABLECONSTANT) && !empty($TABLECONSTANT)) {?>
$toolTables['tool_table_<?php print $TOOLNAME;?>_1'] = <?php print $TABLECONSTANT;?>;
<?php }?>
// additional table can be specified here
// $toolTables['tool_table_<?php print $TOOLNAME;?>_2'] = '';
// $toolTables['tool_table_<?php print $TOOLNAME;?>_3'] = '';