<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_global.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_defines.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."define_styles.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");


    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/SEEM.inc.php");

    //	footer for a none webEdition-Document opened with webEdition
    //	the back button is only activated when there are documents in
    //	the navigation history

    if(!session_id()){
		session_start();
	}

    $_head = "";
    $_body = "";

    $_head = STYLESHEET_BUTTONS_ONLY . SCRIPT_BUTTONS_ONLY;

    $we_button = new we_button();

    $_backbutton = $we_button->create_button("back", "javascript:top.weNavigationHistory.navigateBack();");



	$_table = new we_htmlTable(	array(	"cellpadding" => 0,
										"cellspacing" => 0,
										"border"      => 0),
										2,
										2);
	$_table->setColContent(0, 0, getPixel(20,6));
	$_table->setColContent(1, 1, $_backbutton);


    $_body = $_table->getHtmlCode();
    $_head = STYLESHEET_BUTTONS_ONLY . SCRIPT_BUTTONS_ONLY;


    $_body = we_htmlElement::htmlBody(	array(	"bgcolor"      => "white",
    											"background"   => EDIT_IMAGE_DIR . "editfooterback.gif",
    											"marginwidth"  => 0,
    											"marginheight" => 0,
    											"leftmargin"   => 0,
    											"topmargin"    => 0),
										$_body);

	print we_htmlElement::htmlHtml("\n" . $_head . "\n" . $_body );
?>