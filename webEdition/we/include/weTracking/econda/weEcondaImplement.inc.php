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

/**
 * ECONDA implementation
 * 
 * In /webEdition/we/include/weClasses/we_template.inc.php is checked if ECONDA is activated and if the ECONDA-JS file is integrated. 
 * If it is done the code to include this file in each template before the body-tag will be executed.
 */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/weTracking/econda/weEmos.class.inc.php");
$emos = new weEmos();
$emosJsCode = "";
//if (isset($_REQUEST["we_oid"]) ||) ) {
if ( isset($_REQUEST["we_oid"]) ||  (!isset($GLOBALS["WE_MAIN_DOC"]) && isset($_REQUEST["we_objectID"])) || (isset($_REQUEST["type"]) && $_REQUEST["type"] == "o") ) {
	// object
	$emosType = "obj";
	
} else {
	// document
	$emosType = "doc";
}

switch (true){
	
	case isset($GLOBALS["we_".$emosType]->elements["price"]) : 
		// view article
		$emos->weViewArticle($emosType);
		break;
	
	case isset($_REQUEST["shop_artikelid"]) : 
		// add/remove article quanitity to/from shopping cart	
		$emos->weAddRemoveArticle($emosType);                
		break;
	
	case isset($_REQUEST["del_shop_artikelid"]) :
		// remove complete article from shopping cart
		$emos->weAddRemoveArticle($emosType, true);
		break;
		
	case isset($_SESSION['webuser']) && isset($_SESSION['webuser']['MemberSince']) && $_SESSION['webuser']['MemberSince']<1 :
		// user registration
		//$emos->emosRegister();
		break;

	case isset($_REQUEST['s']) && isset($_REQUEST['s']['Username']) :
		// login
		$emos->emosLogin();
		break;
	case isset($_GLOBALS['weEconda']) && isset($_GLOBALS['weEconda']['emosBasket']):
		// shoping basket
		$emos->emosShopingBasket();
		break;
		

	/**
	 * @todo billing
	 */
}

?>
<?php 
echo $emos->getEmosHTMLFooter(); 
?>
<script type="text/javascript">
//<!--
var emosPageId = "<?php echo $GLOBALS["WE_DOC_ID"]; ?>";
<?php 
echo $emos->getEmosJsFooter(); 
?>
//-->
</script>
<script type="text/javascript" src="<?php print id_to_path(WE_ECONDA_ID); ?>"></script>