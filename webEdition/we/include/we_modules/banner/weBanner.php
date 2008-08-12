<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once(WE_BANNER_MODULE_DIR."weBannerBase.php");

define("BANNER_PAGE_PROPERTY",0);
define("BANNER_PAGE_PLACEMENT",1);
define("BANNER_PAGE_STATISTICS",2);

/**
* General Definition of WebEdition Banner
*
*/
class weBanner extends weBannerBase{
	//properties
	var $ID;
	var $Text;
	var $ParentID;
	var $bannerID;
	var $bannerUrl;
	var $bannerIntID;
	var $maxShow;
	var $maxClicks;
	var $IsDefault;
	var $clickPrice;
	var $showPrice;
	var $IsFolder=0;
	var $Icon="banner.gif";
	var $Path="";
	var $IntHref=0;
	var $FileIDs;
	var $FolderIDs;
	var $CategoryIDs;
	var $DoctypeIDs;
	var $IsActive=1;
	var $StartDate=0;
	var $EndDate=0;
	var $StartOk=0;
	var $EndOk=0;
	var $clicks=0;
	var $views=0;
	var $Customers=0;
	var $TagName="";
	var $weight=4;

	/**
	* steps for WorkFlow Definition
	* this is array of weBannerStep objects
	*/
	var $steps = array();
	// default document object
	var $documentDef;
	// documents array; format document[documentID]=document_name
	// don't create array of objects 'cos whant to save some memory
	var $documents = array();

	/**
	* Default Constructor
	* Can load or create new Banner Definition depends of parameter
	*/

	function weBanner($bannerID = 0,$IsFolder=0){
		$this->weBannerBase();
		$this->table=BANNER_TABLE;

		$this->persistents=array(	"ID",
									"Text",
									"ParentID",
									"bannerID",
									"bannerUrl",
									"bannerIntID",
									"maxShow",
									"maxClicks",
									"IsDefault",
									"clickPrice",
									"showPrice",
									"IsFolder",
									"Icon",
									"Path",
									"IntHref",
									"FileIDs",
									"FolderIDs",
									"CategoryIDs",
									"DoctypeIDs",
									"StartDate",
									"EndDate",
									"StartOk",
									"EndOk",
									"IsActive",#
									"clicks",
									"views",
									"Customers",
									"TagName",
									"weight"

								);

		$this->ID = 0;
		$this->ParentID = 0;
		$this->bannerID = 0;
		$this->bannerUrl = "";
		$this->bannerIntID = 0;
		$this->maxShow = 10000;
		$this->weight = 4;
		$this->maxClicks = 1000;
		$this->IsDefault = 0;
		$this->clickPrice = 0;
		$this->showPrice = 0;
		$this->IsActive = 1;
		$this->IsFolder = $IsFolder;
		$this->TagName = "";
		$this->Customers = "";

		if($this->IsFolder){
			$this->Icon="banner_folder.gif";
			$this->Text = $GLOBALS["l_banner"]["newbannergroup"];
			$this->Path = "/".$GLOBALS["l_banner"]["newbannergroup"];
		}else{
			$this->Text = $GLOBALS["l_banner"]["newbanner"];
			$this->Path = "/".$GLOBALS["l_banner"]["newbanner"];
		}

		if ($bannerID){
			$this->ID=$bannerID;
			$this->load($bannerID);
		}
	}

	/**
	* Load banner definition from database
	*/
	function load($id=0)
	{
		if($id){
			$this->ID=$id;
		}
		if ($this->ID){
			weBannerBase::load();
			$ppath = id_to_path($this->ParentID,BANNER_TABLE);
			$this->Path=($ppath=="/") ? $ppath.$this->Text : $ppath."/".$this->Text;
			return true;

		}else{
			return false;
		}

	}


	/**
	* get all banners from database (STATIC)
	*/
	function getAllBanners()
	{

		$this->db->query("	SELECT ID,abs(text) as Nr, (text REGEXP '^[0-9]') as isNr
							FROM ".$this->table."
							ORDER BY isNr DESC,Nr,Text"
						);

		$out = array();
		while ($this->db->next_record()){
			array_push($out, new weBanner($this->db->f("ID")));
		}
		return $out;
	}

	/**
	* save complete banner definition in database
	*/
	function save(){
		$ppath = id_to_path($this->ParentID,BANNER_TABLE);
		$this->Path=($ppath=="/") ? $ppath.$this->Text : $ppath."/".$this->Text;
		weBannerBase::save();
	}

	/**
	* delete banner from database
	*/
	function delete()
	{
		if (!$this->ID){
			return false;
		}

		weBannerBase::delete();
		$this->db->query("DELETE FROM ".BANNER_VIEWS_TABLE." WHERE ID='".$this->ID."'");
		$this->db->query("DELETE FROM ".BANNER_CLICKS_TABLE." WHERE ID='".$this->ID."'");
		if($this->IsFolder){
			$db2 = new DB_WE();
			$path = (substr($this->Path,-1) == "/") ? $this->Path : $this->Path."/";
			$this->db->query("SELECT ID FROM ".BANNER_TABLE." WHERE Path LIKE '$path%'");
			$ids = array();
			while($this->db->next_record()){
				array_push($ids,$this->db->f("ID"));
			}
			foreach($ids as $id){
				if($id){
					$db2->query("DELETE FROM ".BANNER_VIEWS_TABLE." WHERE ID='$id'");
					$db2->query("DELETE FROM ".BANNER_CLICKS_TABLE." WHERE ID='$id'");
					$db2->query("DELETE FROM ".BANNER_TABLE." WHERE ID='$id'");
				}
			}
		}

		return true;
	}


	function getBannerData($did,$paths,$dt,$cats,$bannername){
		$db = new DB_WE();

		$parents = array();

		we_readParents($did,$parents,FILE_TABLE);

		$where = "IsActive=1 AND IsFolder=0 AND ( FileIDs LIKE '%,$did,%' OR FileIDs='' )";
		$foo = "";
		foreach($parents as $p){
			$foo .= " FolderIDs LIKE '%,$p,%' OR ";
		}
		$where = " $where AND (  $foo  FolderIDs='' ) ";

		$dtArr = makeArrayFromCSV($dt);

		$foo = "";
		foreach($dtArr as $d){
			$foo .= " DoctypeIDs LIKE '%,$d,%' OR ";
		}
		$where = " $where AND (  $foo  DoctypeIDs='' ) ";

		$catArr = makeArrayFromCSV($cats);

		$foo = "";
		foreach($catArr as $c){
			$foo .= " CategoryIDs LIKE '%,$c,%' OR ";
		}
		$where = " $where AND (  $foo  CategoryIDs='' ) ";

		if($paths){
			$pathsArray = makeArrayFromCsv($paths);
			foreach($pathsArray as $p){
				$foo .= " Path LIKE '$p/%' OR Path = '$p' OR ";
			}
			$foo  =  eregi_replace('(.* )OR $','\1',$foo);
			$where = " $where AND ( $foo ) ";
		}

		$where .= ' AND ( (StartOk=0 OR StartDate <= '.time().') AND (EndOk=0 OR EndDate > '.time().') ) AND (maxShow=0 OR views<maxShow) AND (maxClicks=0 OR clicks<=maxClicks) ';

		$bannerID = 0;

		$maxweight = f("SELECT MAX(weight) as maxweight FROM ".BANNER_TABLE,"maxweight",$db);

		srand ((double) microtime ()* 1000000 );
		$weight = rand (0,abs($maxweight));
		$anz = 0;

		while($anz == 0 && $weight <= $maxweight){
			$db->query("SELECT ID, bannerID FROM ".BANNER_TABLE." WHERE $where AND weight <= $weight AND (TagName='' OR TagName='".$bannername."')");
			$anz = $db->num_rows();
			if($anz == 0) $weight++;
		}

		if($anz > 0){
			if($anz > 1){
				srand ((double) microtime () * 1000000 );
				$offset = rand (0,$anz-1);
				$db->seek($offset);
			}
			if($db->next_record()){
				return $db->Record;
			}
		}

		return array("ID"=>0,"bannerID"=>0);
	}
	
	function getImageInfos($fileID){
		$imgAttr = array();
		$db = new DB_WE();
		$db2 = new DB_WE();
		$db->query("SELECT CID, Name FROM " . LINK_TABLE . " WHERE Type='attrib' AND DID=" . $fileID);
		while ($db->next_record(MYSQL_ASSOC)){
			$imgAttr[$db->f('Name')] = f("SELECT Dat FROM " . CONTENT_TABLE . " WHERE ID=" . $db->f("CID"),"Dat",$db2);
		}
		$db->free();
		$db2->free();
		return ($imgAttr);
	}

	function getBannerCode($did,$paths,$target,$width,$height,$dt,$cats,$bannername,$link=true,$referer="",$bannerclick="/webEdition/bannerclick.php",$getbanner="/webEdition/getBanner.php",$type="",$page="",$nocount=false,$xml=false){
		$bannerData = weBanner::getBannerData($did,$paths,$dt,$cats,$bannername);
		$uniq = md5 (uniqid (rand()));
		$showlink = true;
		$db = new DB_WE();
		$prot = getServerProtocol();
		$attsImage['border'] = 0;
		$attsImage['alt'] = '';
		
		if($bannerData["ID"]){
			$id = $bannerData["ID"];
			if($bannerData["bannerID"]){
				$bannersrc = $prot."://".SERVER_NAME.(defined("HTTP_PORT") ? (":".HTTP_PORT) : "").id_to_path($bannerData["bannerID"]);
				$attsImage = array_merge($attsImage,weBanner::getImageInfos($bannerData["bannerID"]));
				if (isset($attsImage['longdescid'])) unset($attsImage['longdescid']);				
			}else{
				$bannersrc = $getbanner."?".($nocount ? 'nocount='.$nocount.'&amp;' : '')."u=$uniq&amp;bannername=".rawurlencode($bannername)."&amp;id=".$bannerData["ID"]."&amp;bid=".$bannerData["bannerID"]."&amp;did=".$did."&amp;page=".rawurlencode($page);
			}
			$bannerlink = $bannerclick."?".($nocount ? 'nocount='.$nocount.'&amp;' : '')."u=$uniq&amp;bannername=".rawurlencode($bannername)."&amp;id=".$bannerData["ID"]."&amp;did=".$did."&amp;page=".rawurlencode($page);
		}else{
			$id=f("SELECT pref_value FROM ".BANNER_PREFS_TABLE." WHERE pref_name='DefaultBannerID'","pref_value",$db);

			$bannerID=f("SELECT bannerID FROM ".BANNER_TABLE." WHERE ID='$id'","bannerID",$db);
			if($bannerID){
				$bannersrc = $prot."://".SERVER_NAME.(defined("HTTP_PORT") ? (":".HTTP_PORT) : "").id_to_path($bannerID);
				$attsImage = array_merge($attsImage,weBanner::getImageInfos($bannerID));
				if (isset($attsImage['longdescid'])) unset($attsImage['longdescid']);				
			}else{
				$bannersrc = $getbanner."?".($nocount ? 'nocount='.$nocount.'&amp;' : '')."u=$uniq&amp;bannername=".rawurlencode($bannername)."&amp;id=".$id."&amp;bid=".$bannerID."&amp;did=".$did;
				$showlink = false;
			}
			$bannerlink = $bannerclick."?".($nocount ? 'nocount='.$nocount.'&amp;' : '')."u=$uniq&amp;bannername=".rawurlencode($bannername)."&amp;id=".$id."&amp;did=".$did."&amp;page=".rawurlencode($page);
		}
		if(!$nocount){
			$db->query("INSERT INTO ".BANNER_VIEWS_TABLE." (ID,Timestamp,IP,Referer,DID,Page) VALUES('$id',".time().",'".$_SERVER["REMOTE_ADDR"]."','".($referer ? $referer : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] :  ""))."','".$did."','".$page."')");
			$db->query("UPDATE ".BANNER_TABLE." SET views=views+1 WHERE ID='$id'");
		}

		$attsImage['xml'] = $xml ? "true" : "false";

		$attsImage['src'] = $bannersrc;
		if($width){
		    $attsImage['width'] = $width;
		}
		if($height){
		    $attsImage['height'] = $height;
		}

		$img = getHtmlTag('img', $attsImage);

		if($showlink){

		    $linkAtts['href'] = $bannerlink;
		    if($target){
		        $linkAtts['target'] = $target;
		    } else if($type=='iframe'){
		        $linkAtts['target'] = '_parent';
		    }

		    return getHtmlTag('a',$linkAtts,$img);

		} else {
		    return $img;
		}
	}

	function getBannerURL($bid){
		$h = getHash("SELECT IntHref,bannerIntID,bannerURL FROM ".BANNER_TABLE." WHERE ID='$bid'",$GLOBALS["DB_WE"]);
		$prot = getServerProtocol(true);
		$url = $h["IntHref"] ? $prot.SERVER_NAME.(defined("HTTP_PORT") ? (":".HTTP_PORT) : "").id_to_path($h["bannerIntID"],FILE_TABLE) : $h["bannerURL"];
		return $url;
	}


	//static function
	function customerOwnsBanner($customerID,$bannerID){
		$db = new DB_WE;
		$res = getHash("SELECT Customers,ParentID FROM ".BANNER_TABLE." WHERE ID='".$bannerID."'",$db);
		if(strstr($res["Customers"],",".$customerID.",") != false){
			return true;
		}else{
			if($res["ParentID"] != 0){
				return weBanner::customerOwnsBanner($customerID,$res["ParentID"]);
			}else{
				return false;
			}
		}
	}
}


?>
