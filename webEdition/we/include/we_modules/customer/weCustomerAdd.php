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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customer.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

class weCustomerAdd{

	var $db;

	function weCustomerAdd(){
		global $l_customer;


	}

	function getHTMLSortEditor(&$pob){
		global $l_customer;

		$we_button=new we_button();
		$branch=$pob->getHTMLBranchSelect();
		$branch->setOptionVT(1,$l_customer["other"],$l_customer["other"]);


		$order=new we_htmlSelect(array("name"=>"order","style"=>"width:90"));
		foreach($pob->View->settings->OrderTable as $ord) $order->addOption($ord,$ord);

		$function=new we_htmlSelect(array("name"=>"function","style"=>"width:130"));

		$counter=0;
		$fhidden="";
		$sort_code="";

		$_parts = array();
		foreach($pob->View->settings->SortView as $k=>$sorts){
			$fcounter=0;
			$row_num=0;
			$sort_field_code="";

			$sort_table=new we_htmlTable(array("border"=>"0","cellpadding"=>"2","cellspacing"=>"1","width"=>"400","height"=>"50"),1,5);
			$sort_table->setCol(0,0,array("class"=>"defaultfont"),we_htmlElement::htmlB($l_customer["sort_branch"]));
			$sort_table->setCol(0,1,array("class"=>"defaultfont"),we_htmlElement::htmlB($l_customer["sort_field"]));
			$sort_table->setCol(0,2,array("class"=>"defaultfont"),we_htmlElement::htmlB($l_customer["sort_function"]));
			$sort_table->setCol(0,3,array("class"=>"defaultfont"),we_htmlElement::htmlB($l_customer["sort_order"]));


			foreach($sorts as $sort){

				if(!$sort["branch"]){
					$branches_names=$pob->View->customer->getBranchesNames();
					if(isset($branches_names[0])) $sort["branch"]=$branches_names[0];
					else $sort["branch"]=$l_customer["common"];
				}

				$branch->setAttributes(array("name"=>"branch_".$counter."_".$fcounter,"class"=>"weSelect","onChange"=>"we_cmd('selectBranch')","style"=>"width:180"));
				$branch->selectOption($sort["branch"]);

				$field=$pob->getHTMLFieldsSelect($sort["branch"]);
				$field->setAttributes(array("name"=>"field_".$counter."_".$fcounter,"style"=>"width:180","class"=>"weSelect","onChange"=>"we_cmd('selectBranch')"));

				$fields_names=array();
				$fields_names=array_keys($this->View->customer->getFieldsNames($sort["branch"]));
				if($sort["branch"]==$l_customer["common"] ||  $sort["branch"]==$l_customer["other"]){
					foreach($fields_names as $fnk=>$fnv) $fields_names[$fnk]=str_replace($sort["branch"]."_","",$fields_names[$fnk]);
				}

				if(!isset($sort["field"])) $sort["field"]="";

				if(is_array($fields_names))
					if(!in_array($sort["field"],$fields_names)) $sort["field"]=array_shift($fields_names);

				if($sort["branch"]==$l_customer["common"] && isset($sort["field"]))
					$field->selectOption($l_customer["common"]."_".$sort["field"]);
				else if(isset($sort["field"]))
					$field->selectOption($sort["field"]);

				$function->setAttributes(array("name"=>"function_".$counter."_".$fcounter,"class"=>"weSelect",));

				$function->delAllOptions();
				$function->addOption("","");
				foreach($pob->View->settings->FunctionTable as $ftk=>$ftv)
					if(isset($sort["field"]) && $pob->View->settings->isFunctionForField($ftk,$sort["field"])) $function->addOption($ftk,$ftk);

				if(isset($sort["function"])) $function->selectOption($sort["function"]);

				$order->setAttributes(array("name"=>"order_".$counter."_".$fcounter,"class"=>"weSelect",));
				$order->selectOption($sort["order"]);

				$row_num=$fcounter+1;
				$sort_table->addRow();
				$sort_table->setCol($row_num,0,array("class"=>"defaultfont"),$branch->getHtmlCode());
				$sort_table->setCol($row_num,1,array("class"=>"defaultfont"),$field->getHtmlCode());
				$sort_table->setCol($row_num,2,array("class"=>"defaultfont"),$function->getHtmlCode());
				$sort_table->setCol($row_num,3,array("class"=>"defaultfont"),$order->getHtmlCode());
				$sort_table->setCol($row_num,4,array("class"=>"defaultfont"),$we_button->create_button("image:btn_function_trash", "javascript:we_cmd('del_sort_field','$k',$fcounter)",true,30));

				$fcounter++;

			}

			$sort_table->addRow();
			$row_num++;
			$sort_table->setCol($row_num,0,array("class"=>"defaultfont"),getPixel(180,5));
			$sort_table->setCol($row_num,1,array("class"=>"defaultfont"),getPixel(180,5));
			$sort_table->setCol($row_num,2,array("class"=>"defaultfont"),getPixel(130,5));
			$sort_table->setCol($row_num,3,array("class"=>"defaultfont"),getPixel(90,5));
			$sort_table->setCol($row_num,4,array("class"=>"defaultfont"),getPixel(22,5));

			$sort_table->addRow();
			$row_num++;
			$sort_table->setCol($row_num,4,array(),getPixel(2,5).$we_button->create_button("image:btn_function_plus", "javascript:we_cmd('add_sort_field',document.we_form.sort_".$counter.".value)",true,30));


			$fhidden.=we_htmlElement::htmlHidden(array("name"=>"fcounter_".$counter,"value"=>"$fcounter"));

			$_htmlCode = 	$pob->getHTMLBox(we_htmlElement::htmlInput(array("name"=>"sort_".$counter,"value"=>$k,"size"=>"40")),$l_customer["name"],100,50,25,0,0,50).
							$sort_table->getHtmlCode() .
							$we_button->create_button("image:btn_function_trash", "javascript:we_cmd('del_sort','$k')");

			$_parts[] = array('html'=>$_htmlCode,'headline'=>$k);

			$counter++;
		}

		$cancel = $we_button->create_button("cancel","javascript:self.close();");
		$save = $we_button->create_button("save", "javascript:we_cmd('save_sort')");

		$_buttons = $we_button->position_yes_no_cancel($save,null,$cancel);

		$add_button= $we_button->create_button_table(array($we_button->create_button("image:btn_function_plus", "javascript:we_cmd('add_sort')"),we_htmlElement::htmlDiv(array("class"=>"defaultgray"),$l_customer["add_sort_group"])));
		$_parts[] = array('html'=>$add_button);

		$sort_code = we_multiIconBox::getHTML("","100%",$_parts,30,$_buttons,-1,"","",false,"","",459);

		$hiddens="\n".we_htmlElement::htmlComment("hiddens start")."\n".
				we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"sort_admin")).
		 		we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"")).
		 		we_htmlElement::htmlHidden(array("name"=>"counter","value"=>"$counter")).
		 		we_htmlElement::htmlHidden(array("name"=>"sortindex","value"=>"")).
		 		we_htmlElement::htmlHidden(array("name"=>"fieldindex","value"=>"")).
		 		$fhidden.
		 		"\n".we_htmlElement::htmlComment("hiddens ends")."\n";


		$sort_code .= $hiddens;


		$out=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>"doScrollTo()"),
					we_htmlElement::jsElement($pob->View->getJSSortAdmin()).
					we_htmlElement::htmlForm(array("name"=>"we_form"),
						$sort_code
					)
		);

		return $pob->getHTMLDocument($out);
	}

	function getJSSortAdmin(&$pob){
			global $l_customer;
			return
			'

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd(){
				var args = "";
				var url = "'.$pob->frameset.'?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

				switch (arguments[0]) {

					case "add_sort_field":
						if(arguments[1]==""){
							' . we_message_reporting::getShowMessageCall($l_customer["sortname_empty"], WE_MESSAGE_ERROR) . '
							break;
						}
						document.we_form.sortindex.value=arguments[1];
					case "add_sort":
						document.we_form.cmd.value=arguments[0];
						submitForm();
					break;
					case "del_sort_field":
						document.we_form.fieldindex.value=arguments[2];
					case "del_sort":
						if(arguments[1]=="'.$pob->settings->Prefs["default_sort_view"].'"){
							' . we_message_reporting::getShowMessageCall($l_customer["default_soting_no_del"], WE_MESSAGE_ERROR) . '
						}
						else{
							document.we_form.cmd.value=arguments[0];
							document.we_form.sortindex.value=arguments[1];
							submitForm();
						}
					break;
					case "save_sort":
					case "selectBranch":
						document.we_form.cmd.value=arguments[0];
						submitForm();
					break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
						}
						eval(\'top.content.we_cmd(\'+args+\')\');
				}
				setScrollTo();
			}

			function doScrollTo(){
				if(opener.'.$this->topFrame.'.scrollToVal){
					window.scrollTo(0,opener.'.$this->topFrame.'.scrollToVal);
					opener.'.$this->topFrame.'.scrollToVal=0;
				}
			}

			function setScrollTo(){
   				opener.'.$this->topFrame.'.scrollToVal='.(($GLOBALS["BROWSER"] == "IE") ? 'document.body.scrollTop' : 'pageYOffset').';
			}

			'.$pob->getJSSubmitFunction("sort_admin");


	}

	function getJSSearch(&$pob){

		return '

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd(){
				var args = "";
				var url = "'.$pob->frameset.'?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				if(document.we_form.mode.value=="1") transferDateFields();
				switch (arguments[0]) {
					case "selectBranch":
						document.we_form.cmd.value=arguments[0];
						submitForm();
					break;
					case "add_search":
						document.we_form.count.value++;
						submitForm();
					break;
					case "del_search":
						if(document.we_form.count.value>0) document.we_form.count.value--;
						submitForm();
					break;
					case "search":
						document.we_form.search.value=1;
						submitForm();
					break;
					case "switchToAdvance":
						document.we_form.mode.value="1";
						submitForm();
					break;
					case "switchToSimple":
						document.we_form.mode.value="0";
						submitForm();
					break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
						}
						eval(\'top.content.we_cmd(\'+args+\')\');
				}
			}
		'.$pob->getJSSubmitFunction("search");

	}


	function getHTMLSearch(&$pob,&$search,&$select){
			global $l_customer;

			$count=$_REQUEST["count"];

			$operators=array("=","<>","<","<=",">",">=","LIKE");
			$logic=array("AND"=>"AND","OR"=>"OR");

			$search_arr=array();

		 	$we_button=new we_button();
			$search_but=$we_button->create_button("image:btn_function_search", "javascript:we_cmd('search')");
		 	$colspan=4;

			for($i=0;$i<$count;$i++){
				if(isset($_REQUEST["branch_".$i])) $search_arr["branch_".$i]=$_REQUEST["branch_".$i];
				if(isset($_REQUEST["field_".$i])) $search_arr["field_".$i]=$_REQUEST["field_".$i];
				if(isset($_REQUEST["operator_".$i])) $search_arr["operator_".$i]=$_REQUEST["operator_".$i];
				if(isset($_REQUEST["value_".$i])) $search_arr["value_".$i]=$_REQUEST["value_".$i];
				if(isset($_REQUEST["logic_".$i])) $search_arr["logic_".$i]=$_REQUEST["logic_".$i];
			}


			$advsearch=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"3"),1,4);
			$branch=$pob->getHTMLBranchSelect();
			$branch->setOptionVT(1,$l_customer["other"],$l_customer["other"]);

			$field=$pob->getHTMLFieldsSelect($l_customer["common"]);

			$c=0;

			for($i=0;$i<$count;$i++){

					if(isset($search_arr["branch_".$i])){
						$branch->selectOption($search_arr["branch_".$i]);
						if($search_arr["branch_".$i]=="")
							$field=$pob->getHTMLFieldsSelect($l_customer["common"]);
						else
							$field=$pob->getHTMLFieldsSelect($search_arr["branch_".$i]);
					}

					if(isset($search_arr["field_".$i])) $field->selectOption($search_arr["field_".$i]);

					$branch->setAttributes(array("name"=>"branch_".$i,"onChange"=>"we_cmd('selectBranch')","style"=>"width:145px"));
					$field->setAttributes(array("name"=>"field_".$i,"style"=>"width:145px","onChange"=>"isDateField($i)"));

					if ($i!=0) {
						$advsearch->addRow();
						$advsearch->setCol($c,0,array("colspan"=>$colspan),htmlSelect("logic_".$i,$logic,1,(isset($search_arr["logic_".$i]) ? $search_arr["logic_".$i] : ""),false,'',"value","70"));
						$c++;
					}
					$value_i = htmlTextInput("value_".$i,20,(isset($search_arr["value_".$i]) ? $search_arr["value_".$i] : ""),"","id='value_$i'","text","185");
					$value_date_i = htmlTextInput("value_date_$i",20,"","","id='value_date_$i' style='display:none; width:150' readonly","text",""); // empty field to display the timestemp in date formate - handeld on the client in js
					$btnDatePicker = $we_button->create_button("image:date_picker","javascript:",null,null,null,null,null,null,false,"_$i");
					$advsearch->addRow();
					$advsearch->setCol($c,0,array(),$branch->getHtmlCode());
					$advsearch->setCol($c,1,array(),$field->getHtmlCode());
					$advsearch->setCol($c,2,array(),htmlSelect("operator_".$i,$operators,1,(isset($search_arr["operator_".$i]) ? $search_arr["operator_".$i] : ""),false,'',"value","60"));
					$advsearch->setCol($c,3,array("width"=>"190"),
						"<table border='0' cellpadding='0' cellspacing='0'><tr><td>".$value_i.$value_date_i."</td><td>".getPixel(3,1)."</td><td id='dpzell_$i' style='display:none' align='right'>$btnDatePicker</td></tr></table>");
					$c++;

			}

			$advsearch->addRow();
			$advsearch->setCol($c,0,array("colspan"=>$colspan),getPixel(5,5));

			$c++;
			$advsearch->addRow();
			$advsearch->setCol($c,0,array("colspan"=>$colspan),
						$we_button->create_button_table(array(
								$we_button->create_button("image:btn_function_plus", "javascript:we_cmd('add_search')"),
								$we_button->create_button("image:btn_function_trash","javascript:we_cmd('del_search')")
							)
						)
			);

			$search->setCol(1,0,array(),
				we_htmlElement::htmlHidden(array("name"=>"count","value"=>$count)).
				$advsearch->getHtmlCode()

			);
			$search->setCol(2,0,array(),getPixel(5,5));
			$search->setCol(3,0,array("align"=>"right","colspan"=>$colspan),
									"<table border='0' cellpadding='0' cellspacing='0'><tr><td>".$we_button->create_button_table(
										array(
											we_htmlElement::htmlDiv(array("class"=>"defaultgray"),$l_customer["simple_search"]),
											$we_button->create_button("image:btn_direction_left", "javascript:we_cmd('switchToSimple')"),
											$search_but
										)
									)."</td><td>&nbsp;</td></tr></table>"
			);
			$max_res=$pob->View->settings->getMaxSearchResults();
			$result=array();
			if(count($search_arr) && $_REQUEST["search"]) $result=weCustomerAdd::getAdvSearchResults($search_arr,$count,$max_res);
			foreach($result as $id=>$text) $select->addOption($id,$text);

	}

	function getAdvSearchResults($keywords,$count,$res_num){
		global $l_customer;

		$operators=array("0"=>"=",
									"1"=>"<>",
									"2"=>"<",
									"3"=>"<=",
									"4"=>">",
									"5"=>">=",
									"6"=>"LIKE"
		);

		$select=" ID,Text";
		$where="";
		$condition="";

		for($i=0;$i<$count;$i++){
				if(isset($keywords["field_".$i])){
					$keywords["field_".$i]=str_replace($l_customer["common"]."_","",$keywords["field_".$i]);
					$select.=",".$keywords["field_".$i];
				}
				if(isset($keywords["field_".$i]) && isset($keywords["operator_".$i]) && isset($keywords["value_".$i])) $where.=(isset($keywords["logic_".$i]) ? " ".$keywords["logic_".$i]." " : "").$keywords["field_".$i]." ".$operators[$keywords["operator_".$i]]." '".$keywords["value_".$i]."'";
		}

		if($where=="") $where=0;

		$this->db->query("SELECT $select FROM ".CUSTOMER_TABLE." WHERE $where ORDER BY Text LIMIT 0,$res_num");

		$result=array();
		while($this->db->next_record()){
			$result[$this->db->f("ID")]=$this->db->f("Text");
		}

 		return $result;

	}

	function getHTMLTreeHeader(&$pob){
		global $l_customer;

		$we_button=new we_button();

		$select=$pob->getHTMLSortSelect();
		$select->setAttributes(array("OnChange"=>"applySort();","style"=>"width:150px"));
		$select->selectOption($pob->View->settings->Prefs["default_sort_view"]);

		$table1=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"3000"),1,1);
		$table1->setCol(0,0,array("nowrap"=>null,"class"=>"small"),getPixel(300,1));

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"3"),1,3);
		$table->setRow(0,array("valign"=>"bottom"));

		$table->setCol(0,0,array("nowrap"=>null,"class"=>"small"),$select->getHtmlCode());
		$table->setCol(0,1,array("nowrap"=>null,"class"=>"small"),$we_button->create_button("image:btn_function_reload", "javascript:applySort();"));
		$table->setCol(0,2,array("nowrap"=>null,"class"=>"small"),$we_button->create_button("image:btn_edit_edit", "javascript:we_cmd('show_sort_admin')"));

		$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"treeheader")).
					we_htmlElement::htmlHidden(array("name"=>"pid","value"=>"0")).
				 	we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"no_cmd"));


		$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5"),
					we_htmlElement::jsElement($pob->View->getJSTreeHeader()).
					we_htmlElement::htmlForm(array("name"=>"we_form"),
						$hiddens.
						$table1->getHtmlCode().
						$table->getHtmlCode()
					)
		);

		return $pob->getHTMLDocument($body);
	}


}
?>
