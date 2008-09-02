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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

print STYLESHEET;
$we_button = new we_button();
?>
    <script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
    <script language="JavaScript" type="text/javascript">
	function get_selection() {
		parent.do_selupdate();
	}

    </script>
  </head>
  <body background="/webEdition/images/edit/editfooterback.gif" style="padding:10px;">
    <?php
      print $we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:get_selection();"),
      											"",
      											$we_button->create_button("cancel", "javascript:parent.close();")
      											);
    ?>
  </body>
</html>
