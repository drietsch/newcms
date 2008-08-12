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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

print STYLESHEET;

$we_button = new we_button();

$_select ='<select name="search_results" size="20" style="width:520px;height:220px;" ondblclick="opener.top.content.we_cmd(\'check_user_display\',document.we_form.search_results.value)">';
  $_kwd = isset($_REQUEST["kwd"]) ? $_REQUEST["kwd"] : "";
  $arr = explode(" ", strToLower($_kwd));
  $sWhere="";
  $ranking = "0";

  $first="";
  $array_and=array();
  $array_or=array();
  $array_not=array();
  $array_and[0]=$arr[0];

  for ($i=1; $i<count($arr); $i++) {
    if (($arr[$i]=='and')||($arr[$i]=='or')||($arr[$i]=='not')) {

      if ($arr[$i]=='not') {
        $i++;
        $array_not[count($array_not)]=$arr[$i];
      }
      else if ($arr[$i]=='and') {
        $i++;
        $array_and[count($array_and)]=$arr[$i];
      }
      else if ($arr[$i]=='or') {
        $i++;
        $array_or[count($array_or)]=$arr[$i];
      }

    } else {

       $array_and[count($array_and)]=$arr[$i];
    }
  }
  $condition="";

  foreach($array_and as $k => $value){
      if($condition!="") $condition.=" AND (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
      else $condition.=" (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
  }
  foreach($array_or as $k => $value){
      if($condition!="") $condition.=" OR (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
      else $condition.=" (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
  }
  foreach($array_not as $k => $value){
      if($condition!="") $condition.=" AND NOT (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
      else $condition.=" (First LIKE '%$value%' OR Second LIKE '%$value%' OR username LIKE '%$value%' OR Address LIKE '%$value%' OR City LIKE '%$value%' OR State LIKE '%$value%' OR Country LIKE '%$value%' OR Tel_preselection LIKE '%$value%' OR Fax_preselection LIKE '%$value%' OR Telephone LIKE '%$value%' OR Fax LIKE '%$value%' OR Description LIKE '%$value%')";
  }

  if($condition!="") $condition=" WHERE ".$condition." ORDER BY Text";
  $DB_WE->query("SELECT * FROM ".USER_TABLE.$condition);

  while($DB_WE->next_record()){
      $_select.='<option value="'.$DB_WE->f("ID").'">'.$DB_WE->f("Text");
  }


  $_buttons = $we_button->position_yes_no_cancel(
  	$we_button->create_button("edit", "javascript:opener.top.content.we_cmd('check_user_display',document.we_form.search_results.value)"),
  	null,
  	$we_button->create_button("cancel", "javascript:self.close();")

  );

 $_select.='</select>';


 $_content = htmlFormElementTable(
 	htmlTextInput('kwd', 24, $_kwd,"","","text", 485),
 	$l_users["search_for"],
 	"left",
 	"defaultfont",
 	getPixel(10,1),
 	$we_button->create_button("image:btn_function_search", "javascript:document.we_form.submit();")
 ) . '<div style="height:20px;"></div>' .

 htmlFormElementTable(
 	$_select,
 	$l_users["search_result"]
 )

 ;

?>
</head>
<body class="weEditorBody" style="margin:10px 20px;">
<form name="we_form" method="post">
	<?php print htmlDialogLayout($_content, $l_users["search"], $_buttons); ?>
</form>
</body>
