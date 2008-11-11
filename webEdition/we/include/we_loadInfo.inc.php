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