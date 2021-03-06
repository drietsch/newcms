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



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/handle_shop_dbitemConnect.php");

protect();

$home = isset($_REQUEST["home"]) ? $_REQUEST["home"] : 0;
$mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : 0;
$bid = isset($_REQUEST["bid"]) ? $_REQUEST["bid"] : 0;
/// config
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'shop_pref'");
	$DB_WE->next_record();
	$feldnamen = explode("|",$DB_WE->f("strFelder"));
	for ($i=0;$i<=3;$i++) {
		$feldnamen[$i] = isset($feldnamen[$i]) ? $feldnamen[$i] : '';
	}
	 $fe = explode(",",$feldnamen[3]);
	  if(empty($classid)){
	  	$classid = $fe[0];
	  }
      $fe = explode(",",$feldnamen[3]);
     // $resultO = count ($fe);
      $resultO = array_shift ($fe);

      $dbTitlename="shoptitle";


		// wether the resultset ist empty?
	$DB_WE->query("SELECT count(Name) as Anzahl FROM ".LINK_TABLE." WHERE Name ='".mysql_real_escape_string($dbTitlename)."'");
	$DB_WE->next_record();
	$resultD = $DB_WE->f("Anzahl");

?>
<html>
<head>
</head>
   <frameset rows="40,*" framespacing="0" border="0" frameborder="no">
    <frame src="edit_shop_editorHeaderTop.php?mid=<?php print $mid; ?>&bid=<?php print $bid; ?>&home=<?php print $home; ?>&typ=object&ViewClass=<?php print $classid; ?>" name="edheader" noresize scrolling=no>
   <?php if($home) {
     print "<frame src='/webEdition/we_cmd.php?we_cmd[0]=mod_home&mod=shop' name='edbody' scrolling=auto>";
     } else if($mid) {
     	// TODO::WANN UND VON WEM WIRD DAS AUFGERUFEN ????
     	print "<frame src='edit_shop_overviewTop.php?mid=\"$mid\"' name='edbody' scrolling=auto>";
    } else {
        if ( ($resultD > 0) && (empty($resultO)) ){  // docs but no objects
        print "<frame src='edit_shop_article_extend.php?typ=document' name='edbody' scrolling=auto>";
        }elseif( ($resultD < 1) && (!empty($resultO))   ){  // no docs but objects
        print "<frame src='edit_shop_article_extend.php?typ=object&ViewClass=$classid' name='edbody' scrolling=auto>";
       }elseif( ($resultD > 0) && (!empty($resultO)) ){
        print "<frame src='edit_shop_article_extend.php?typ=document' name='edbody' scrolling=auto>";
       }
      } ?>
   </frameset>
  <body bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html