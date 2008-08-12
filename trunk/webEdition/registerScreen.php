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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/register.inc.php");

protect();

htmlTop();
$we_button = new we_button();
print STYLESHEET;

$_width_left   = 310;
$_width_middle = 20;
$_width_right  = 100;

$_table = new we_htmlTable(	array(	"border"      => 0,
									"cellpadding" => 2,
									"cellspacing" => 0,
									"width"       => ($_width_left + $_width_middle + $_width_right)),
							4,
							3);

$_table->setCol(0,0, array("colspan" => 3, "class" => "middlefont"), $l_register["regtext"]);

$_table->setCol(1,0, array( "width" => $_width_left), getPixel($_width_left,50));
$_table->setCol(1,1, array( "width" => $_width_middle), getPixel($_width_middle,50));
$_table->setCol(1,2, array( "width" => $_width_right), getPixel($_width_right,50));

$_table->setCol(2,0, array( "align" => "right", "class" => "middlefont"), $l_register["to_demo"]);
$_table->setColContent(2,1, getPixel($_width_middle,5));
$_table->setCol(2,2, array( "width" => $_width_right), $we_button->create_button("demoversion", "javascript:window.close()"));

$_table->setCol(3,0, array( "align" => "right", "class" => "middlefont"), "<b>" . $l_register["regist"] . "</b>");
$_table->setColContent(3,1, getPixel($_width_middle,5));
$_table->setCol(3,2, array( "width" => $_width_right), $we_button->create_button("register", "javascript:opener.we_cmd('update');window.close();"));

?>
	<script language="javascript">
	<!--
	function focusOnMe(){

		window.focus();
		window.setTimeout("focusOnMe()", 3000);
	}
	//-->
	</script>
	</head>

	<body class="weDialogBody" onload="window.setTimeout('focusOnMe()', 2000);">
		<center>
		<?php print htmlDialogLayout($_table->getHtmlCode(), $l_register["register"]); ?>
		</center>
	</body>
</html>