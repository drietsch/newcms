<?php

class rpcChangeDocTypeCmd extends rpcCmd {
	
	function execute() {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import.inc.php");
		$resp = new rpcResponse();
		$categories = "<tr><td style='font-size:8px'>&nbsp;</td></tr>";
		//$categories = "";
		if (isset($_REQUEST['docType'])) {
			if ($_REQUEST['docType'] >= 0) {
				$values = getHash("SELECT * FROM ".DOC_TYPES_TABLE." WHERE ID='".$_REQUEST['docType']."'",$GLOBALS["DB_WE"]);	
				
				$ids_arr = makeArrayFromCSV($values["Templates"]);
				
				$paths_arr = id_to_path($values["Templates"],TEMPLATES_TABLE,"",false,true);
				$TPLselect = new we_htmlSelect(array(
					"name"		=> "docTypeTemplateId",
					"size"		=> "1",
					"class"		=> "weSelect",
					"onClick"	=> (defined("OBJECT_TABLE"))?"self.document.forms['we_form'].elements['v[import_type]'][0].checked=true;":"",
					//"onChange"  => "we_submit_form(self.document.forms['we_form'], 'wizbody', '".$this->path."');",
					"style"		=> "width: 300px")
				);

				$optid = 0;
				while (list(, $templateID) = each($ids_arr)) {
					$TPLselect->insertOption($optid, $templateID, $paths_arr[$optid]);
					$optid++;
				}

				$templateElement = htmlFormElementTable($TPLselect->getHTMLCode(), $l_import['template'], "left", "defaultfont");
				if ($values["Category"]!="") {
					$categories = $this->getCategories("doc",$values["Category"],'v[docCategories]');
				}
				$categories = strtr($categories, array("\r" => "","\n"=>""));
				if (count($ids_arr)) {
					$_docTypeLayerDisplay="block";
					$_noDocTypeLayerDisplay="none";
				} else {
					$_docTypeLayerDisplay="none";
					$_noDocTypeLayerDisplay="block";
				}
				$_templateName = "";
				if (isset($values["TemplateID"]) && $values["TemplateID"]>0) {
					$_templateName = f("SELECT Path FROM " . TEMPLATES_TABLE . " WHERE ID=" . $values["TemplateID"], "Path" ,$GLOBALS["DB_WE"]);
				}
				$resp->setData("elements",
						array(
							"self.document.forms['we_form'].elements['v[store_to_id]']"      => array("value"=>$values["ParentID"]|0),
							"self.document.forms['we_form'].elements['v[store_to_path]']"    => array("value"=>$values["ParentPath"]|"/"),
							"self.document.forms['we_form'].elements['v[we_TemplateID]']"    => array("value"=>$values["TemplateID"]|0),
							"self.document.forms['we_form'].elements['v[we_TemplateName]']"  => array("value"=>$_templateName|""),
							"self.document.forms['we_form'].elements['v[we_Extension]']"     => array("value"=>$values["Extension"]|""),
							"self.document.forms['we_form'].elements['v[is_dynamic]']"       => array("value"=>$values["IsDynamic"]|0),
							"self.document.forms['we_form'].elements['chbxIsDynamic']"       => array("checked"=>$values["IsDynamic"]|0),
							"self.document.forms['we_form'].elements['v[docCategories]']"    => array("value"=>$values["Category"]|""),
							"self.document.forms['we_form'].elements['noDocTypeTemplateId']" => array("value"=>0),
							"document.getElementById('docTypeLayer')"                        => array("innerHTML"=>addslashes($templateElement), "style.display"=>$_docTypeLayerDisplay), 
							"document.getElementById('noDocTypeLayer')"                      => array("style.display"=>$_noDocTypeLayerDisplay),
							"document.getElementById('docCatTable')"                         => array("innerHTML"=>addslashes($categories)
						)
					)
				);
		
			} else {
				$resp->setData("elements",
						array(
							"self.document.forms['we_form'].elements['v[store_to_id]']"      => array("value"=>0),
							"self.document.forms['we_form'].elements['v[store_to_path]']"    => array("value"=>"/"),
							"self.document.forms['we_form'].elements['v[we_TemplateID]']"    => array("value"=>0),
							"self.document.forms['we_form'].elements['v[we_TemplateName]']"  => array("value"=>"/"),
							"self.document.forms['we_form'].elements['v[we_Extension]']"     => array("value"=>""),
							"self.document.forms['we_form'].elements['v[is_dynamic]']"       => array("value"=>0),
							"self.document.forms['we_form'].elements['chbxIsDynamic']"       => array("checked"=>0),
							"self.document.forms['we_form'].elements['v[docCategories]']"    => array("value"=>""),
							"self.document.forms['we_form'].elements['noDocTypeTemplateId']" => array("value"=>0),
							"document.getElementById('docTypeLayer')"                        => array("innerHTML"=>"", "style.display"=>"none"), 
							"document.getElementById('noDocTypeLayer')"                      => array("style.display"=>"block"),
							"document.getElementById('docCatTable')"                         => array("innerHTML"=>$categories
						)
					)
				);
						
			}
		}
		return $resp;
	}
	
	function getCategories($obj, $categories, $catField="") {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser2.inc.php");
		$cats = new MultiDirChooser2(410,$categories,"delete_".$obj."Cat","","","Icon,Path",CATEGORY_TABLE);
		$cats->setRowPrefix($obj);
		$cats->setCatField($catField);
		return $cats->getTableRows();
	}	
}
?>