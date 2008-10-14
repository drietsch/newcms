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
 * Emos code generator
 *
 */
class weEmos{
	/**
	 * Emos JavaScript Code
	 * The Emos JavaScript code whitch is plased on the bottom of the page befor the body-end-tag
	 *
	 * @var String
	 */
	private $emosJsFooter;
	/**
	 * Emos HTML Code
	 * The Emos HTML (a-tags) code whitch is plased on the bottom of the page befor the body-end-tag
	 * @var String
	 */
	private $emosHTMLFooter;
	
	function __construct(){
		
		$this->emosJsFooter = $GLOBALS["weEconda"]["JS"];
		$this->emosHTMLFooter = $GLOBALS["weEconda"]["HTML"];
/*
		if (isset($GLOBALS["we_doc"]) && isset($GLOBALS["we_doc"]["Language"])) {
			$this->emosHTMLFooter .= '<a name="emos_name" title="langid" rel="'.substr($GLOBALS["we_doc"]["Language"],0,2).'" rev=""></a>'."\n";	
		}
*/
		if (isset($_REQUEST['emosScontact']) && $_REQUEST['emosScontact'] != "") {
			$subject = urldecode($_REQUEST['emosScontact']);
			$subject = strip_tags($subject);
			$subject = addslashes(rawurlencode($subject));
			$this->emosHTMLFooter .= '<a name="emos_name" title="scontact" rel="'.$subject.'" rev=""></a>';
		}
		if (isset($GLOBALS["weEconda"]["content"]["from"])) {
			switch ($GLOBALS["weEconda"]["content"]["from"]){
				case 'path':
					$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
					break;
				case 'navigation':
					if(isset($GLOBALS["we_doc"]->NavigationItems) && $GLOBALS["we_doc"]->NavigationItems != "") {
						$navItems = explode(",",$GLOBALS["we_doc"]->NavigationItems);
						$contentLabel = $navItems[1]; 
						$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($contentLabel,1).'" rev=""></a>';
					} else {
						$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
					}
					break;
				case 'category':
					if(isset($GLOBALS["we_doc"]->Category) && $GLOBALS["we_doc"]->Category != "") {
						$catIds = explode(",",$GLOBALS["we_doc"]->Category); 
						$contentLabel = f("SELECT Path FROM " . CATEGORY_TABLE . " WHERE ID=" . abs($catIds[1]), "Path", $GLOBALS["DB_WE"]);
						$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($contentLabel,1).'" rev=""></a>';
					} else {
						$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
					}
					break;
				case 'input':
//					$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
					break;
				case 'hidden':
//					$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
					break;
				default:
					$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="'.substr($GLOBALS["we_doc"]->Path,1).'" rev=""></a>';
			}
			$this->emosHTMLFooter .= "\n";
		}
	}
	
	/**
	 * Article content page
	 *
	 * @param String $type (doc|ojb)
	 */
	function weViewArticle($type){
		$this->emosJsFooter .= "
if(typeof emosECPageArray == 'undefined') var emosECPageArray = new Array();
emosECPageArray['event'] 	= 'view';
emosECPageArray['id']		= 'd_" . $GLOBALS["we_".$type]->ID . "';
emosECPageArray['name']		= '" . rawurlencode($GLOBALS["we_".$type]->elements["shoptitle"]["dat"]) . "';
emosECPageArray['preis']	= '" . $GLOBALS["we_".$type]->elements["price"]["dat"] . "';
emosECPageArray['group']	= '" . rawurlencode(isset($_REQUEST['catId']) ? substr(id_to_path($_REQUEST['catId'],CATEGORY_TABLE),1) :  substr($GLOBALS["we_".$type]->ParentPath,1) ) . "';
emosECPageArray['anzahl']	= '1';
emosECPageArray['var1']		= '" . rawurlencode(isset($GLOBALS["we_".$type]->Variant) ? rawurlencode($GLOBALS["we_".$type]->Variant) : "NULL") . "';
emosECPageArray['var2']		= 'NULL';
emosECPageArray['var3']		= 'NULL';
";
		
		//$this->emosHTMLFooter .= '<a name="emos_name" title="content" rel="Katalog/" rev=""';
	}
	
	/**
	 * Add/remove article to/from shopping basket
	 *
	 * @param String $type (doc|obj)
	 * @param Boolean $complete
	 */
	function weAddRemoveArticle($type, $complete=false){
		if ($type=="doc") {
			$article = new we_document();
			$article->initByID($_REQUEST["shop_artikelid"]);
		} else {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
			$article = new we_objectFile();
			$article->initByID($_REQUEST["shop_artikelid"], OBJECT_FILES_TABLE);			
		}		
		
		if (isset($_REQUEST['we_variant']) && count($article->elements['weInternVariantElement']['dat'])>0) {
			$weInternVariantElements = unserialize($article->elements['weInternVariantElement']['dat']);
			$weVariants = array();
			foreach ($weInternVariantElements as $weInternVariantElement) {
				$weVariants[key($weInternVariantElement)] = current($weInternVariantElement);
			}
			$emosName  = $weVariants["shoptitle"]["dat"];
			$emosPreis = $weVariants["price"]["dat"];
		} else {
			$emosName  = $article->elements["shoptitle"]["dat"];
			$emosPreis = $article->elements["price"]["dat"];
		}
		
		if ($_REQUEST['shop_anzahl']>0){
			$emosEvent  = "c_add";
			$emosAnzahl = $_REQUEST['shop_anzahl'];
		} else {
			$emosEvent  =  "c_rmv";
			$emosAnzahl = $_REQUEST['shop_anzahl']*(-1);
		}
		
		if ($complete) {
			$emosEvent  =  "c_rmv";
			$emosAnzahl = "0";
		}
		
		$this->emosJsFooter .= "
if(typeof emosECPageArray == 'undefined') var emosECPageArray = new Array();
emosECPageArray['event'] 	= '" . $emosEvent . "';
emosECPageArray['id']		= 'd_" . $_REQUEST["shop_artikelid"] . "';
emosECPageArray['name']		= '" . rawurlencode($emosName) . "';
emosECPageArray['preis']	= '" . $emosPreis . "';
emosECPageArray['group']	= '" . rawurlencode(isset($_REQUEST['catId']) ? id_to_path($_REQUEST['catId'],CATEGORY_TABLE) :  $article->ParentPath ) . "';
emosECPageArray['anzahl']	= '" . $emosAnzahl . "';
emosECPageArray['var1']		= '" . rawurlencode(isset($GLOBALS["we_".$type]->Variant) ? $GLOBALS["we_".$type]->Variant : "NULL") . "';
emosECPageArray['var2']		= 'NULL';
emosECPageArray['var3']		= 'NULL';
";		
	}
	
	/**
	 * User registration
	 *
	 */
	function emosRegister(){
		$userID = "";
		$eventNr = 1;
		if ($_SESSION['webuser']['ID']) {
			$userID = md5($_SESSION['webuser']['ID']);
			$eventNr = 0;
		}
		$this->emosHTMLFooter .= "<a name='emos_name' title='register' rel='$userID' rev='$eventNr' ></a>\n";
	}
	
	/**
	 * User Login
	 *
	 */
	function emosLogin(){
		$userID = "";
		$eventNr = 1;
		if ($_SESSION['webuser']['ID']) {
			$userID = md5($_SESSION['webuser']['ID']);
			$eventNr = 0;
		}
		$this->emosHTMLFooter .= "<a name='emos_name' title='login' rel='$userID' rev='$eventNr' ></a>\n";
	}
	
	function emosShopingBasket(){
		$this->emosJsFooter .= $_GLOBALS['weEconda']['emosBasket'];
	}
	
	
	/**
	 * Returns the emos HTML code
	 *
	 * @return String
	 */
	function getEmosHTMLFooter(){
		return $this->emosHTMLFooter;
	}
	
	/**
	 * Returns the emos JS code
	 *
	 * @return String
	 */
	function getEmosJsFooter(){
		return $this->emosJsFooter;	
	}
}


?>