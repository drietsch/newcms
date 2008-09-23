<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

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
	
	/**
	 * Article content page
	 *
	 * @param String $type (doc|ojb)
	 */
	function weViewArticle($type){
				$this->emosJsFooter .= "
emosECPageArray['event'] 	= 'view';
emosECPageArray['id']		= 'd_" . $GLOBALS["we_".$type]->ID . "';
emosECPageArray['name']		= '" . urlencode($GLOBALS["we_".$type]->elements["shoptitle"]["dat"]) . "';
emosECPageArray['preis']	= '" . $GLOBALS["we_".$type]->elements["price"]["dat"] . "';
emosECPageArray['group']	= '" . urlencode(isset($_REQUEST['catId']) ? id_to_path($_REQUEST['catId'],CATEGORY_TABLE) :  $GLOBALS["we_".$type]->ParentPath ) . "';
emosECPageArray['anzahl']	= '1';
emosECPageArray['var1']		= '" . urlencode(isset($GLOBALS["we_".$type]->Variant) ? $GLOBALS["we_".$type]->Variant : "NULL") . "';
emosECPageArray['var2']		= 'NULL';
emosECPageArray['var3']		= 'NULL';
";
		
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
emosECPageArray['event'] 	= '" . $emosEvent . "';
emosECPageArray['id']		= 'd_" . $_REQUEST["shop_artikelid"] . "';
emosECPageArray['name']		= '" . urlencode($emosName) . "';
emosECPageArray['preis']	= '" . $emosPreis . "';
emosECPageArray['group']	= '" . urlencode(isset($_REQUEST['catId']) ? id_to_path($_REQUEST['catId'],CATEGORY_TABLE) :  $article->ParentPath ) . "';
emosECPageArray['anzahl']	= '" . $emosAnzahl . "';
emosECPageArray['var1']		= '" . urlencode(isset($GLOBALS["we_".$type]->Variant) ? $GLOBALS["we_".$type]->Variant : "NULL") . "';
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