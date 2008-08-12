<?php
 
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");

define("SHOP_TABLE", TBL_PREFIX . "tblOrders");
define("ANZEIGE_PREFS_TABLE", TBL_PREFIX . "tblAnzeigePrefs");
define('WE_SHOP_VAT_TABLE', TBL_PREFIX . 'tblshopvats');
define("WE_SHOP_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/");
define("WE_SHOP_MODULE_PATH","/webEdition/we/include/we_modules/shop/");

define('WE_SHOP_VARIANTS_PREFIX', 'we__intern_variant___');
define('WE_SHOP_VARIANTS_ELEMENT_NAME', 'weInternVariantElement');
define('WE_SHOP_VARIANT_REQUEST', 'we_variant');

// name of request array for shopping items
define('WE_SHOP_ARTICLE_CUSTOM_FIELD', 'we_sacf');
define('WE_SHOP_CART_CUSTOM_FIELD', 'we_sscf');
define('WE_SHOP_CART_CUSTOMER_FIELD', 'we_shopCustomer');
define('WE_SHOP_VAT_FIELD_NAME', 'shopvat'); // due to the names of old fields (shoptitle, shopdescription) - we must name shopvat
define('WE_SHOP_PRICE_IS_NET_NAME', 'we_shopPriceIsNet');
define('WE_SHOP_SHIPPING', 'we_shopPriceShipping');
define('WE_SHOP_CALC_VAT', 'we_shopCalcVat');

class shop{
	
	var $ClassName = "we_listview_shoppingCart";
	
	var $DB_WE;
	var $IDs = array();
	var $count=0;
	var $Record = array();
	var $anz = 0;
	
	var $type;
	
	var $ShoppingCart;
	var $ShoppingCartItems;
	var $ShoppingCartKey = '';
	var $ActItem;
	
	function shop($shoppingCart) {
		
		$this->ShoppingCart = $shoppingCart;
		$this->ShoppingCartItems = $shoppingCart->getShoppingItems();
		
		$this->IDs = array_keys($this->ShoppingCartItems);
	}
	
	function next_record(){
		
		$shoppingCartItems = $this->ShoppingCartItems;
		
	    $this->anz = count($this->IDs);
	    
		if($this->count < count($this->IDs)){
			
			$cartKey = $this->IDs[$this->count];
			$this->ShoppingCartKey = $cartKey;
			
			$shoppingItem = $shoppingCartItems[$cartKey];
			$this->ActItem = $shoppingItem;
			
			$this->Record = array();
			foreach ($shoppingItem['serial'] as $key => $value) {
				if ( !is_int($key) ) {
					if ($key == WE_SHOP_VAT_FIELD_NAME) {
						$this->Record[$key] = $value;
					} else {
						$this->Record[ereg_replace("^we_","",$key)] = $value;
					}
					
				}
			}
			$this->count++;
			return true;
		}
		return false;
	}
	
	function f($key){
		if (isset($this->Record[$key])) {
			return $this->Record[$key];
		}
		return '';
	}
	
	function getCustomFieldsAsRequest() {
		
		$ret = '';
		
		foreach ($this->ActItem['customFields'] as $key => $value) {
			$ret .= "&" . WE_SHOP_ARTICLE_CUSTOM_FIELD . "[$key]=$value";
		}
		
		return $ret;
	}
}



class Basket {
	
	/**
	 *	this array contains all shopping items
	 *	a shopping item is an associated array containining
	 *	'id'       => integer
	 *	'type'     => w | o
	 *	'variant'  => string
	 *	'quantity' => integer
	 *	'serial'   => string
	 *  'customFields' => array
	 *
	 * @var array
	 */
	var $ShoppingItems = array();
	
	/**
	 * user can define custom fields saved with the order.
	 *
	 * @var array
	 */
	var $CartFields = array();
	
	/**
	 * constructor
	 *
	 * @return Basket
	 */
	function Basket() {
		$this->ShoppingItems = array();
		$this->CartFields = array();
	}
	
	function initCartFields() {
		
		if (isset($_REQUEST[WE_SHOP_CART_CUSTOM_FIELD]) && is_array($_REQUEST[WE_SHOP_CART_CUSTOM_FIELD])) {
			$this->CartFields = $_REQUEST[WE_SHOP_CART_CUSTOM_FIELD];
		}
	}
	
	/**
	 * returns array of shoppingItems
	 *
	 * @return array
	 */
	function getShoppingItems() {
		return $this->ShoppingItems;
	}
	
	/**
	 * returns array of all shopping cartfields
	 *
	 * @return array
	 */
	function getCartFields() {
		return $this->CartFields;
	}
	
	/**
	 * returns the items in the shopping cart and all custom cart fields
	 * former getProperties
	 *
	 * @return array
	 */
	function getCartProperties() {
		
		return array(
			'shoppingItems' => $this->getShoppingItems(),
			'cartFields' => $this->getCartFields()
		);
	}
	

	/**
	 * initialies the shoppingCart
	 * former name setProperties
	 *
	 * @param array $array
	 */
	function setCartProperties($array) {
		
		if ( isset($array['shoppingItems']) && isset($array['cartFields'])) {
			$this->ShoppingItems = $array['shoppingItems'];
			$this->CartFields = $array['cartFields'];
		} else {
			$this->ShoppingItems = array();
			$this->CartFields = array();
		}
	}
	
	/**
	 * add an item to the array
	 *
	 * @param integer $id
	 * @param integer $quantity
	 * @param string $type
	 * @param string $variant
	 */
	function Add_Item($id, $quantity=1, $type='w', $variant='', $customFields=array() ) {
		
		// check if this item is already in the shoppingCart
		if ( $key = $this->getShoppingItemIndex($id, $type, $variant, $customFields) ) { // item already exists
			
			if ($this->ShoppingItems[$key]['quantity'] + $quantity > 0) {
				$this->ShoppingItems[$key]['quantity'] += $quantity;
			} else {
				$this->Del_Item($id, $type, $variant, $customFields);
			}
			
		} else { // add the item
			
			$key = uniqid('we_cart_');
			
			if ($quantity > 0) { // only add new item with positive number
				
				$item = array(
					'id' => $id,
					'type' => $type,
					'variant' => $variant,
					'quantity' => $quantity,
					'serial' => $this->getserial($id, $type, $variant, $customFields),
					'customFields' => $customFields
				);
				
				$this->ShoppingItems[$key] = $item;
			}
		}
	}
	
        
    /**
     * returns size of shoppingCart
     *
     * @return integer
     */
    function Get_Basket_Count() {
		return sizeof($this->ShoppingItems);
	}
	
	/**
	 * returns shoppingItems
	 *
	 * @return array
	 */
	function Get_All_Data () {
		return $this->getCartProperties();
	}
	
	/**
	 * returns shoppingItem - serial
	 *
	 * @param integer $id
	 * @param string $type
	 * @param string $variant
	 * @return string
	 */
	function getserial($id,$type,$variant=false,$customFields=array()){
		
		$DB_WE = new DB_WE;
		
		$Record = array();
		
			if($type == "w"){
				
				// unfortunately this is not made with initDocById,
				// but its much faster -> so we use it
			$DB_WE->query("SELECT ".CONTENT_TABLE.".BDID as BDID, ".CONTENT_TABLE.".Dat as Dat, ".LINK_TABLE.".Name as Name FROM ".LINK_TABLE.",".CONTENT_TABLE." WHERE ".LINK_TABLE.".DID=$id AND ".LINK_TABLE.".CID=".CONTENT_TABLE.".ID AND ".LINK_TABLE.".DocumentTable='".substr(FILE_TABLE, strlen(TBL_PREFIX))."'");
			while($DB_WE->next_record()){
				if($DB_WE->f("BDID")){
						$Record[$DB_WE->f("Name")] = $DB_WE->f("BDID");
				}else{
					$Record[$DB_WE->f("Name")] = $DB_WE->f("Dat");
				}
			}
			
			if ($variant) {
				require_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
				weShopVariants::useVariantForShop($Record, $variant);
			}
			
			
			$DB_WE->query("SELECT * FROM ".FILE_TABLE." WHERE ID=$id");
			if($DB_WE->next_record()){
				foreach($DB_WE->Record as $key=>$val){
					$Record["wedoc_$key"] = $val;
				}
			}
			
			$Record["WE_PATH"] = f("SELECT Path FROM ".FILE_TABLE." WHERE ID=$id","Path",$DB_WE) . ($variant ? '?' . WE_SHOP_VARIANT_REQUEST . '=' . $variant : '');
			$Record["WE_TEXT"] = f("SELECT Text FROM ".INDEX_TABLE." WHERE DID=$id","Text",$DB_WE);
			$Record["WE_VARIANT"] = $variant;
			$Record["WE_ID"] = $id;
			
			// at last add custom fields to record and to path
			if (sizeof($customFields)) {
				
				if ($variant) {
					$Record['WE_PATH'] .= '&amp;';
				} else {
					$Record['WE_PATH'] .= '?';
				}
				
				foreach ($customFields as $name => $value) {
					$Record[$name] = $value;
					$Record['WE_PATH'] .= WE_SHOP_ARTICLE_CUSTOM_FIELD . "[$name]=$value&amp;";
				}
			}
			
		} else if($type == "o") {
			
			include_once(WE_OBJECT_MODULE_DIR."we_listview_object.class.php");
			
			$classArray = getHash("SELECT * FROM ".OBJECT_FILES_TABLE." WHERE ID=".$id,$DB_WE);
			
			$olv = new we_listview_object("0",1,0,"",0,$classArray["TableID"],"",""," ".OBJECT_X_TABLE.$classArray["TableID"].".ID=".$classArray["ObjectID"]);
			$olv->next_record();
			
			$Record = $olv->DB_WE->Record;
			
			if ($variant) {
				
				// init model to detect variants
				// :TODO: change this to match above version
				$obj = new we_objectFile();
				$obj->initByID($id, OBJECT_FILES_TABLE);
				
				require_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
				weShopVariants::useVariantForShopObject($Record, $variant, $obj);
				
				// add variant to path ...
				$Record['we_WE_PATH'] = $Record['we_WE_PATH'] . '&amp;' . WE_SHOP_VARIANT_REQUEST . '=' . $variant;
			}
			$Record['WE_VARIANT'] = $variant;
			$Record['we_obj'] = $id;
			
			// at last add custom fields to record and to path
			if (sizeof($customFields)) {
				foreach ($customFields as $name => $value) {
					$Record[$name] = $value;
					$Record['we_WE_PATH'] .= '&amp;' . WE_SHOP_ARTICLE_CUSTOM_FIELD . "[$name]=$value";
				}
			}
			
			// when using objects all fields have 'we_' as prename
			if (isset($Record['we_' . WE_SHOP_VAT_FIELD_NAME])) {
				$Record[WE_SHOP_VAT_FIELD_NAME] = $Record['we_' . WE_SHOP_VAT_FIELD_NAME];
				unset($Record['we_' . WE_SHOP_VAT_FIELD_NAME]);
			}
		}
		
		// at last add custom fields and vat to shopping card
		$Record[WE_SHOP_ARTICLE_CUSTOM_FIELD] = $customFields;
		
		return $Record;
	}
	
	/**
	 * returns amount of shopping items by key
	 *
	 * @param string $key
	 * @return integer
	 */
	function Get_Item_Quantity($key) {
		
		return $this->ShoppingItems[$key]['quantity'];
	}
	
	/**
	 * remove item from shop
	 *
	 * @param integer $id
	 * @param string $type
	 * @param string $variant
	 */
	function Del_Item($id, $type, $variant='', $customFields=array()) {
		
		if ($key = $this->getShoppingItemIndex($id, $type, $variant, $customFields)) {
			unset($this->ShoppingItems[$key]);
		}
	}
	
	
	/**
	 * resets the shoppingCart
	 *
	 */
	function Empty_Basket() {
		$this->ShoppingItems = array();
		$this->CartFields = array();
	}
	

  	/**
  	 * changes abilities of item in the shoppingCart
  	 *
  	 * @param integer $id
  	 * @param integer $quantity
  	 * @param string $type
  	 * @param string $variant
  	 */
  	function Set_Item($id, $quantity=1, $type="w", $variant='', $customFields=array()) {
  		
  		if ($key = $this->getShoppingItemIndex($id, $type, $variant, $customFields)) { // item already in cart
  			
  			if ($quantity > 0) {
  				$this->ShoppingItems[$key]['quantity'] = $quantity;
  			} else {
  				$this->Del_Item($id, $type, $variant, $customFields);
  			}
  			
  		} else { // new item
  			$this->Add_Item($id, $quantity, $type, $variant, $customFields);
  		}
    }
    
    
    /**
     * set cart item by the assoc array
     *
     * @param string $cart_id
     * @param integer $cart_amount
     */
    function Set_Cart_Item($cart_id, $cart_amount) {
    	
    	if (isset($this->ShoppingItems[$cart_id])) {
    		
    		$item = $this->ShoppingItems[$cart_id];
    		$this->Set_Item($item['id'], $cart_amount, $item['type'], $item['variant'], $item['customFields']);
    	}
    }
        
	/**
	 * returns key for shoppingItem or false
	 *
	 * @param integer $id
	 * @param string $type
	 * @param string $variant
	 * @return mixed
	 */
	function getShoppingItemIndex($id, $type='w', $variant='', $customFields=array()) {
		
		foreach ($this->ShoppingItems as $index => $item) {
			if ($item['id'] == $id && $item['type'] == $type && $item['variant'] == $variant && $customFields == $item['customFields']) {
				return $index;
			}
		}
		return false;
	}
}
?>