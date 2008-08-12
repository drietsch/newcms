<?php


// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or higher                                          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | shopModule by Jan Gorba                                              |
// +----------------------------------------------------------------------+
//
// $Id: edit_shop_editorFrameset.php,v 1.9 2007/04/25 15:23:01 holger.meyer Exp $

$bid = isset($_REQUEST["bid"]) ? $_REQUEST["bid"] : 0;
$mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : 0;
$yearView = isset($_REQUEST["ViewYear"]) ? $_REQUEST["ViewYear"] : 0;
$home = isset($_REQUEST["home"]) ? $_REQUEST["home"] : 0;
?>
<html>
<head>
</head>
   <frameset rows="40,*" framespacing="0" border="0" frameborder="no">
    <frame src="edit_shop_editorHeader.php?home=<?php print $home; ?>&mid=<?php print $mid . $yearView; ?>&bid=<?php print $bid; ?>" name="edheader" noresize scrolling=no>
   <?php if($home){ ?>

      <frame src="/webEdition/we_cmd.php?we_cmd[0]=mod_home&mod=shop" name="edbody" scrolling=auto>,

   <!--
    <frame src="edit_shop_pref.php?bid=<?php print $bid; ?>" name="edbody" scrolling=auto>
    -->

	<?php }elseif($mid){

		$year = substr($mid, (strlen($mid)-4));
		$month = str_replace($year,'',$_REQUEST["mid"]);

		print "<frame src=\"edit_shop_revenueTop.php?ViewYear=$year&ViewMonth=$month\" name=\"edbody\" scrolling=auto>";

	?>
	
	<?php }elseif($yearView){

		$year = $yearView;
		

		print "<frame src=\"edit_shop_revenueTop.php?ViewYear=$year\" name=\"edbody\" scrolling=auto>";

	?>

   <?php }else{ ?>
    <frame src="edit_shop_properties.php?bid=<?php print $bid; ?>" name="edbody" scrolling=auto>
   <?php } ?>
   </frameset>
  <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html