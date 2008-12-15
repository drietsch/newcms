<?php


/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

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