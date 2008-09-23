<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/"."listviewBase.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");

/**
* class    we_listview_banner
* @desc    class for tag <we:listview type="banner">
*
*/

class we_listview_banner extends listviewBase {

	var $ClassName = "we_listview_banner";
	var $allviews=0;
	var $allclicks=0;
	var $UseFilter=0;
	var $FilterDate=0;
	var $FilterDateEnd=0;
	var $docs;

	/**
	 * we_listview_object()
	 * @desc    constructor of class
	 *
	 * @param   name          string - name of listview
	 * @param   rows          integer - number of rows to display per page
	 * @param   order         string - field name(s) to order by
	 * @param   bannerID      integer - ID of banner
	 * @param   UseFilter     integer - 0 or 1
	 * @param   FilterDate    integer - Unix Timestamp
	 * @param   FilterDateEnd integer - Unix Timestamp
	 *
	 */

	function we_listview_banner($name="0", $rows=999999, $order="views DESC",$bannerID="",$UseFilter=false,$FilterDate=0,$FilterDateEnd=0){

		listviewBase::listviewBase($name, $rows, 0, $order);

		$this->bannerID = $bannerID;
		$this->UseFilter = $UseFilter;
		$this->FilterDate = $FilterDate;
		$this->FilterDateEnd = $FilterDateEnd;
		$this->allviews = 0;
		$this->allclicks = 0;

		$this->count = $this->start;

		$this->docs = array();

		$tempArray = array();;
		$tempArray2 = array();;

			$ord = eregi("^views",$this->order) ? "ORDER BY ".$this->order : "";
			$this->DB_WE->query("

SELECT DID, COUNT( ID )  AS views
FROM ".BANNER_VIEWS_TABLE." WHERE DID != 0 AND (Page='' OR page='0') AND ID='".$this->bannerID."' ".($this->UseFilter ? " AND (Timestamp>='".$this->FilterDate."' AND Timestamp<'".($this->FilterDateEnd)."')" : "")."
GROUP  BY DID
");
			while($this->DB_WE->next_record()){

				$tempArray[$this->DB_WE->f("DID")] = array();
				$tempArray[$this->DB_WE->f("DID")]["views"] = $this->DB_WE->f("views");
				$this->allviews += abs($this->DB_WE->f("views"));
			}

			$this->DB_WE->query("

SELECT DID, COUNT( ID )  AS clicks
FROM ".BANNER_CLICKS_TABLE." WHERE DID != 0 AND (Page='' OR page='0') AND ID='".$this->bannerID."' ".($this->UseFilter ? " AND (Timestamp>='".$this->FilterDate."' AND Timestamp<'".($this->FilterDateEnd)."')" : "")."
GROUP  BY DID
");
			while($this->DB_WE->next_record()){
				$tempArray[$this->DB_WE->f("DID")]["clicks"] = $this->DB_WE->f("clicks");
				$this->allclicks += abs($this->DB_WE->f("clicks"));
			}



			$this->DB_WE->query("
SELECT Page, COUNT( ID )  AS views
FROM ".BANNER_VIEWS_TABLE." WHERE  Page != '' AND Page != '0' AND ID='".$this->bannerID."' ".($this->UseFilter ? " AND (Timestamp>='".$this->FilterDate."' AND Timestamp<'".($this->FilterDateEnd)."')" : "")."
GROUP  BY Page
");
			while($this->DB_WE->next_record()){

				$tempArray2[$this->DB_WE->f("Page")] = array();
				$tempArray2[$this->DB_WE->f("Page")]["views"] = $this->DB_WE->f("views");
				$this->allviews += abs($this->DB_WE->f("views"));
			}
			$this->DB_WE->query("

SELECT Page, COUNT( ID )  AS clicks
FROM ".BANNER_CLICKS_TABLE." WHERE  Page != '' AND Page != '0' AND ID='".$this->bannerID."' ".($this->UseFilter ? " AND (Timestamp>='".$this->FilterDate."' AND Timestamp<'".($this->FilterDateEnd)."')" : "")."
GROUP  BY Page
");
			while($this->DB_WE->next_record()){
				$tempArray2[$this->DB_WE->f("Page")]["clicks"] = $this->DB_WE->f("clicks");
				$this->allclicks += abs($this->DB_WE->f("clicks"));
			}

			// correct views entry on main banner table
			$allviews = f("SELECT COUNT(ID) AS views FROM ".BANNER_VIEWS_TABLE." WHERE ID='".$this->bannerID."'","views",$this->DB_WE);
			$this->DB_WE->query("UPDATE ".BANNER_TABLE." SET views=".$allviews." WHERE ID='".$this->bannerID."'");


			foreach($tempArray as $did=>$vals){
				array_push($this->docs, array("did" => $did, "views" => (isset($vals["views"]) ? $vals["views"] : 0), "clicks" => (isset($vals["clicks"]) ? $vals["clicks"] : 0), "page" => ""));
			}

			foreach($tempArray2 as $page=>$vals){
				array_push($this->docs, array("did" => 0, "views" => isset( $vals["views"]) ? $vals["views"] : 0, "clicks" => isset($vals["clicks"]) ? $vals["clicks"] : 0, "page" => $page));
			}


			if(eregi("^path",$this->order)){
				if(eregi("^path +desc",$this->order)){
					usort($this->docs,"we_sort_banners_path_desc");
				}else{
					usort($this->docs,"we_sort_banners_path");
				}
			}else if(eregi("^clicks",$this->order)){
				if(eregi("^clicks +desc",$this->order)){
					usort($this->docs,"we_sort_banners_clicks_desc");
				}else{
					usort($this->docs,"we_sort_banners_clicks");
				}
			}else if(eregi("^views",$this->order)){
				if(eregi("^views +desc",$this->order)){
					usort($this->docs,"we_sort_banners_views_desc");
				}else{
					usort($this->docs,"we_sort_banners_views");
				}
			}else if(eregi("^rate",$this->order)){
				if(eregi("^rate +desc",$this->order)){
					usort($this->docs,"we_sort_banners_rate_desc");
				}else{
					usort($this->docs,"we_sort_banners_rate");
				}
			}
		$this->anz_all = sizeof($this->docs);
		$this->anz = min($this->rows,$this->anz_all - $this->start);

	}

	function next_record(){
		if($this->count < min($this->start+$this->rows,$this->anz_all)){
			$keys = array_keys($this->docs);
			$id = abs($this->docs[$this->count]["did"]);
			$path = $id ? id_to_path($id,FILE_TABLE) : $this->docs[$this->count]["page"];
			$this->Record["WE_PATH"] = $this->Record["path"] = $path;
			$this->Record["WE_ID"] = $this->Record["id"] = $id;
			$this->Record["views"] = abs($this->docs[$this->count]["views"]);
			$this->Record["page"] = $this->docs[$this->count]["page"];
			$this->Record["clicks"] = abs($this->docs[$this->count]["clicks"]);
			$this->Record["rate"] = round($this->Record["views"] ? (100 *($this->Record["clicks"]/$this->Record["views"])) : 0,1);
			$this->count++;
			return true;
		}
		return false;
	}

	function f($key){
		return $this->Record[$key];
	}

	function getAllviews(){
		return abs($this->allviews);
	}
	function getAllclicks(){
		return abs($this->allclicks);
	}
	function getAllrate(){
		return round($this->getAllviews() ? (100 *($this->getAllclicks()/$this->getAllviews())) : 0,1);
	}

}

function we_sort_banners_path($a,$b){
	$aa = $a["did"] ? id_to_path($a["did"],FILE_TABLE) : $a["page"];
	$bb = $b["did"] ? id_to_path($b["did"],FILE_TABLE) : $b["page"];
	return strcmp($aa, $bb);
}

function we_sort_banners_path_desc($a,$b){
	$aa = $a["did"] ? id_to_path($a["did"],FILE_TABLE) : $a["page"];
	$bb = $b["did"] ? id_to_path($b["did"],FILE_TABLE) : $b["page"];

	return strcmp($aa, $bb) * -1;
}

function we_sort_banners_clicks($a,$b){
	if(abs($a["clicks"]) == abs($b["clicks"])) return 0;
	return (abs($a["clicks"]) > abs($b["clicks"])) ? 1 : -1;
}

function we_sort_banners_clicks_desc($a,$b){
	if(abs($a["clicks"]) == abs($b["clicks"])) return 0;
	return (abs($a["clicks"]) > abs($b["clicks"])) ? -1 : 1;
}

function we_sort_banners_views($a,$b){
	if(abs($a["views"]) == abs($b["views"])) return 0;
	return (abs($a["views"]) > abs($b["views"])) ? 1 : -1;
}

function we_sort_banners_views_desc($a,$b){
	if(abs($a["views"]) == abs($b["views"])) return 0;
	return (abs($a["views"]) > abs($b["views"])) ? -1 : 1;
}

function we_sort_banners_rate($a,$b){
	$rate_a = round($a["views"] ? (100 *($a["clicks"]/$a["views"])) : 0,1);
	$rate_b = round($b["views"] ? (100 *($b["clicks"]/$b["views"])) : 0,1);
	if($rate_a == $rate_b) return 0;
	return ($rate_a > $rate_b) ? 1 : -1;
}

function we_sort_banners_rate_desc($a,$b){
	$rate_a = round($a["views"] ? (100 *($a["clicks"]/$a["views"])) : 0,1);
	$rate_b = round($b["views"] ? (100 *($b["clicks"]/$b["views"])) : 0,1);
	if($rate_a == $rate_b) return 0;
	return ($rate_a > $rate_b) ? -1 : 1;
}


?>