<?php if(isset($TABLECONSTANT) && isset($TABLENAME) && !empty($TABLECONSTANT) && !empty($TABLENAME)) {?>
define("<?php print $TABLECONSTANT;?>","<?php print $TABLENAME;?>");
<?php }?>