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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/inlcude/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/inlcude/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/global.inc.php");

?>

<html>
<head>
<title></title>
		<?php
		print STYLESHEET;
		?>
	</head>

<body>
<span class="defaultfont">
			<?php
			print $l_global["load_menu_info"];
			?>
		</span>
</body>

</html>